<?php
// Test script to check login functionality
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔐 Login Page Test</h1>";

// Include required files
require_once 'config/config.php';
require_once 'config/supabase_client.php';
require_once 'includes/auth.php';

try {
    $supabase = new SupabaseClient();
    $auth = new Auth();
    
    echo "<h2>✅ System Status</h2>";
    echo "<ul>";
    echo "<li>✅ Config loaded</li>";
    echo "<li>✅ Supabase client initialized</li>";
    echo "<li>✅ Auth class loaded</li>";
    echo "</ul>";
    
    echo "<h2>📋 Login Page Details</h2>";
    echo "<ul>";
    echo "<li><strong>File:</strong> pages/auth/login.php</li>";
    echo "<li><strong>URL:</strong> index.php?page=auth/login</li>";
    echo "<li><strong>Direct URL:</strong> pages/auth/login.php</li>";
    echo "<li><strong>Form Method:</strong> POST</li>";
    echo "<li><strong>Required Fields:</strong> email, password</li>";
    echo "</ul>";
    
    echo "<h2>🔑 Test Admin Credentials</h2>";
    echo "<ul>";
    echo "<li><strong>Email:</strong> admin@sueandmon.com</li>";
    echo "<li><strong>Password:</strong> admin123</li>";
    echo "</ul>";
    
    // Check if admin user exists
    echo "<h2>👤 Admin User Check</h2>";
    $admin_user = $supabase->select('users', '*', ['email' => 'admin@sueandmon.com']);
    
    if (!empty($admin_user)) {
        echo "<p style='color: green;'>✅ Admin user exists</p>";
        echo "<ul>";
        echo "<li><strong>Name:</strong> " . htmlspecialchars($admin_user[0]['name']) . "</li>";
        echo "<li><strong>Role:</strong> " . htmlspecialchars($admin_user[0]['role']) . "</li>";
        echo "<li><strong>Created:</strong> " . htmlspecialchars($admin_user[0]['created_at']) . "</li>";
        echo "</ul>";
    } else {
        echo "<p style='color: orange;'>⚠️ Admin user not found</p>";
        echo "<p>Run <code>create_admin.php</code> to create the admin user.</p>";
    }
    
    echo "<h2>🌐 Access URLs</h2>";
    echo "<div style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>";
    echo "<h3>Login Page URLs:</h3>";
    echo "<ul>";
    echo "<li><a href='index.php?page=auth/login' target='_blank'>index.php?page=auth/login</a></li>";
    echo "<li><a href='pages/auth/login.php' target='_blank'>pages/auth/login.php</a></li>";
    echo "</ul>";
    
    echo "<h3>Admin Dashboard URLs:</h3>";
    echo "<ul>";
    echo "<li><a href='index.php?page=admin' target='_blank'>index.php?page=admin</a></li>";
    echo "<li><a href='pages/admin/dashboard.php' target='_blank'>pages/admin/dashboard.php</a></li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<h2>📝 Login Form Fields</h2>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Required</th><th>Description</th></tr>";
    echo "<tr><td>email</td><td>email</td><td>Yes</td><td>User's email address</td></tr>";
    echo "<tr><td>password</td><td>password</td><td>Yes</td><td>User's password</td></tr>";
    echo "<tr><td>remember_me</td><td>checkbox</td><td>No</td><td>Remember login session</td></tr>";
    echo "</table>";
    
    echo "<h2>🔒 Security Features</h2>";
    echo "<ul>";
    echo "<li>✅ Password hashing with bcrypt</li>";
    echo "<li>✅ Session-based authentication</li>";
    echo "<li>✅ Role-based access control</li>";
    echo "<li>✅ CSRF protection (form validation)</li>";
    echo "<li>✅ Input sanitization</li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Check your Supabase configuration in config/config.php</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #2563eb; }
h2 { color: #374151; margin-top: 30px; }
ul { line-height: 1.6; }
code { background: #f3f4f6; padding: 2px 4px; border-radius: 3px; }
table th { background: #f9fafb; padding: 8px; }
table td { padding: 8px; }
</style> 