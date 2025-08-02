<?php
class Auth {
    private $supabase;

    public function __construct() {
        global $supabase;
        $this->supabase = $supabase;
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

        try {
            // Check if email already exists
            $existing = $this->supabase->select('users', '*', ['email' => $data['email']]);
            if (!empty($existing)) {
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

            $result = $this->supabase->insert('users', $userData);
            
            if ($result) {
                // Auto login after registration
                $this->login($data['email'], $data['password']);
                return ['success' => true, 'message' => 'Registration successful'];
            }

            return ['success' => false, 'message' => 'Registration failed'];
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Registration failed'];
        }
    }

    public function login($email, $password) {
        try {
            $users = $this->supabase->select('users', '*', ['email' => $email]);
            $user = $users[0] ?? null;
            
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
            $this->supabase->update('users', 
                ['last_login' => date('Y-m-d H:i:s')], 
                ['id' => $user['id']]
            );

            return ['success' => true, 'message' => 'Login successful'];
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Login failed'];
        }
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
            redirect('404');
        }
    }

    public function updateProfile($userId, $data) {
        try {
            $updateData = [];
            
            if (isset($data['name'])) {
                $updateData['name'] = $data['name'];
            }
            
            if (isset($data['email'])) {
                // Check if email is already taken by another user
                $existing = $this->supabase->select('users', '*', ['email' => $data['email']]);
                if (!empty($existing) && $existing[0]['id'] != $userId) {
                    return ['success' => false, 'message' => 'Email already taken'];
                }
                $updateData['email'] = $data['email'];
            }
            
            if (isset($data['phone'])) {
                $updateData['phone'] = $data['phone'];
            }
            
            if (isset($data['address'])) {
                $updateData['address'] = $data['address'];
            }
            
            if (!empty($updateData)) {
                $updateData['updated_at'] = date('Y-m-d H:i:s');
                $this->supabase->update('users', $updateData, ['id' => $userId]);
                
                // Update session if name was changed
                if (isset($updateData['name'])) {
                    $_SESSION['user_name'] = $updateData['name'];
                }
                if (isset($updateData['email'])) {
                    $_SESSION['user_email'] = $updateData['email'];
                }
                
                return ['success' => true, 'message' => 'Profile updated successfully'];
            }
            
            return ['success' => false, 'message' => 'No changes to update'];
        } catch (Exception $e) {
            error_log("Profile update error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Profile update failed'];
        }
    }

    public function resetPassword($email) {
        try {
            $users = $this->supabase->select('users', '*', ['email' => $email]);
            $user = $users[0] ?? null;
            
            if (!$user) {
                return ['success' => false, 'message' => 'Email not found'];
            }

            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store reset token
            $this->supabase->update('users', [
                'reset_token' => $token,
                'reset_token_expires' => $expires
            ], ['id' => $user['id']]);

            // Send email (implement your email sending logic here)
            // For now, just return success
            return ['success' => true, 'message' => 'Password reset email sent'];
        } catch (Exception $e) {
            error_log("Password reset error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Password reset failed'];
        }
    }

    public function verifyResetToken($token) {
        try {
            $users = $this->supabase->select('users', '*', ['reset_token' => $token]);
            $user = $users[0] ?? null;
            
            if (!$user) {
                return false;
            }

            if (strtotime($user['reset_token_expires']) < time()) {
                return false;
            }

            return $user;
        } catch (Exception $e) {
            error_log("Token verification error: " . $e->getMessage());
            return false;
        }
    }

    public function setNewPassword($token, $newPassword) {
        try {
            $user = $this->verifyResetToken($token);
            if (!$user) {
                return ['success' => false, 'message' => 'Invalid or expired token'];
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => PASSWORD_COST]);
            
            $this->supabase->update('users', [
                'password' => $hashedPassword,
                'reset_token' => null,
                'reset_token_expires' => null
            ], ['id' => $user['id']]);

            return ['success' => true, 'message' => 'Password updated successfully'];
        } catch (Exception $e) {
            error_log("Password update error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Password update failed'];
        }
    }
}

// Create global instance
$auth = new Auth();
?> 