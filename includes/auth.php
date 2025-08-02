<?php
class Auth {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function register($data) {
        // Validate input
        if (empty($data['email']) || empty($data['password']) || empty($data['name'])) {
            return ['success' => false, 'message' => 'All fields are required'];
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }

        if (strlen($data['password']) < 6) {
            return ['success' => false, 'message' => 'Password must be at least 6 characters'];
        }

        // Check if email already exists
        $existing = $this->db->fetch("SELECT id FROM users WHERE email = ?", [$data['email']]);
        if ($existing) {
            return ['success' => false, 'message' => 'Email already registered'];
        }

        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => PASSWORD_COST]);

        // Insert user
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashedPassword,
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $userId = $this->db->insert('users', $userData);
        
        if ($userId) {
            // Auto login after registration
            $this->login($data['email'], $data['password']);
            return ['success' => true, 'message' => 'Registration successful'];
        }

        return ['success' => false, 'message' => 'Registration failed'];
    }

    public function login($email, $password) {
        $user = $this->db->fetch("SELECT * FROM users WHERE email = ?", [$email]);
        
        if (!$user) {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }

        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }

        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['logged_in'] = true;

        // Update last login
        $this->db->update('users', 
            ['last_login' => date('Y-m-d H:i:s')], 
            'id = ?', 
            [$user['id']]
        );

        return ['success' => true, 'message' => 'Login successful'];
    }

    public function logout() {
        session_destroy();
        return ['success' => true, 'message' => 'Logout successful'];
    }

    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public function isAdmin() {
        return $this->isLoggedIn() && $_SESSION['user_role'] === 'admin';
    }

    public function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }

        return [
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'name' => $_SESSION['user_name'],
            'role' => $_SESSION['user_role']
        ];
    }

    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            redirect('auth/login');
        }
    }

    public function requireAdmin() {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            redirect('home');
        }
    }

    public function updateProfile($userId, $data) {
        $updateData = [];
        
        if (!empty($data['name'])) {
            $updateData['name'] = $data['name'];
        }
        
        if (!empty($data['email'])) {
            // Check if email is already taken by another user
            $existing = $this->db->fetch("SELECT id FROM users WHERE email = ? AND id != ?", [$data['email'], $userId]);
            if ($existing) {
                return ['success' => false, 'message' => 'Email already taken'];
            }
            $updateData['email'] = $data['email'];
        }

        if (!empty($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => PASSWORD_COST]);
        }

        if (empty($updateData)) {
            return ['success' => false, 'message' => 'No data to update'];
        }

        $updateData['updated_at'] = date('Y-m-d H:i:s');
        
        $result = $this->db->update('users', $updateData, 'id = ?', [$userId]);
        
        if ($result) {
            // Update session if name or email changed
            if (isset($updateData['name'])) {
                $_SESSION['user_name'] = $updateData['name'];
            }
            if (isset($updateData['email'])) {
                $_SESSION['user_email'] = $updateData['email'];
            }
            
            return ['success' => true, 'message' => 'Profile updated successfully'];
        }

        return ['success' => false, 'message' => 'Failed to update profile'];
    }

    public function resetPassword($email) {
        $user = $this->db->fetch("SELECT id, name FROM users WHERE email = ?", [$email]);
        
        if (!$user) {
            return ['success' => false, 'message' => 'Email not found'];
        }

        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $this->db->insert('password_resets', [
            'user_id' => $user['id'],
            'token' => $token,
            'expires_at' => $expires,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Send reset email (implement email sending)
        // sendPasswordResetEmail($email, $token);

        return ['success' => true, 'message' => 'Password reset email sent'];
    }

    public function verifyResetToken($token) {
        $reset = $this->db->fetch(
            "SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW() AND used = 0",
            [$token]
        );
        
        return $reset ? $reset : false;
    }

    public function setNewPassword($token, $newPassword) {
        $reset = $this->verifyResetToken($token);
        
        if (!$reset) {
            return ['success' => false, 'message' => 'Invalid or expired token'];
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => PASSWORD_COST]);
        
        $this->db->beginTransaction();
        
        try {
            // Update password
            $this->db->update('users', 
                ['password' => $hashedPassword, 'updated_at' => date('Y-m-d H:i:s')], 
                'id = ?', 
                [$reset['user_id']]
            );
            
            // Mark token as used
            $this->db->update('password_resets', 
                ['used' => 1], 
                'id = ?', 
                [$reset['id']]
            );
            
            $this->db->commit();
            return ['success' => true, 'message' => 'Password updated successfully'];
        } catch (Exception $e) {
            $this->db->rollback();
            return ['success' => false, 'message' => 'Failed to update password'];
        }
    }
}

// Global auth instance
$auth = new Auth();
?> 