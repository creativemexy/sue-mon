<?php
// Script to create an admin user
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Create Admin User</h1>";

// Include required files
require_once 'config/config.php';
require_once 'config/supabase_client.php';

try {
    $supabase = new SupabaseClient();
    
    // Check if admin already exists
    $existing_admin = $supabase->select('users', '*', ['email' => 'admin@sueandmon.com']);
    
    if (!empty($existing_admin)) {
        echo "<p style='color: orange;'>⚠️ Admin user already exists!</p>";
        echo "<p>Email: admin@sueandmon.com</p>";
        echo "<p>Password: admin123</p>";
    } else {
        // Create admin user
        $admin_data = [
            'name' => 'Admin User',
            'email' => 'admin@sueandmon.com',
            'password' => password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 12]),
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $supabase->insert('users', $admin_data);
        
        if ($result) {
            echo "<p style='color: green;'>✅ Admin user created successfully!</p>";
            echo "<p><strong>Email:</strong> admin@sueandmon.com</p>";
            echo "<p><strong>Password:</strong> admin123</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to create admin user</p>";
        }
    }
    
    echo "<h2>How to Access Admin Dashboard:</h2>";
    echo "<ol>";
    echo "<li>Go to: <a href='index.php?page=auth/login'>Login Page</a></li>";
    echo "<li>Login with: admin@sueandmon.com / admin123</li>";
    echo "<li>After login, go to: <a href='index.php?page=admin'>Admin Dashboard</a></li>";
    echo "</ol>";
    
    echo "<h2>Alternative URLs:</h2>";
    echo "<ul>";
    echo "<li><a href='pages/auth/login.php'>Direct Login Page</a></li>";
    echo "<li><a href='pages/admin/dashboard.php'>Direct Admin Dashboard</a></li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Make sure your Supabase credentials are configured correctly.</p>";
}
?> 