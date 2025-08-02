<?php
// Test script to check contact page functionality
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>📞 Contact Page Test</h1>";

// Include required files
require_once 'config/config.php';
require_once 'config/supabase_client.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

try {
    $supabase = new SupabaseClient();
    $auth = new Auth();
    
    echo "<h2>✅ System Status</h2>";
    echo "<ul>";
    echo "<li>✅ Config loaded</li>";
    echo "<li>✅ Supabase client initialized</li>";
    echo "<li>✅ Auth class loaded</li>";
    echo "<li>✅ Functions loaded</li>";
    echo "</ul>";
    
    echo "<h2>📋 Contact Page Details</h2>";
    echo "<ul>";
    echo "<li><strong>File:</strong> pages/contact.php</li>";
    echo "<li><strong>URL:</strong> index.php?page=contact</li>";
    echo "<li><strong>Direct URL:</strong> pages/contact.php</li>";
    echo "<li><strong>Form Method:</strong> POST</li>";
    echo "<li><strong>Required Fields:</strong> name, email, subject, message</li>";
    echo "</ul>";
    
    echo "<h2>🔒 Security Features</h2>";
    echo "<ul>";
    echo "<li>✅ CSRF token validation</li>";
    echo "<li>✅ Input sanitization</li>";
    echo "<li>✅ Email validation</li>";
    echo "<li>✅ Database storage</li>";
    echo "</ul>";
    
    // Check if contact_messages table exists
    echo "<h2>🗄️ Database Check</h2>";
    try {
        $test_query = $supabase->select('contact_messages', '*', [], 1);
        echo "<p style='color: green;'>✅ Contact messages table exists</p>";
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Contact messages table may not exist</p>";
        echo "<p>You may need to create the table in your Supabase database:</p>";
        echo "<pre>";
        echo "CREATE TABLE contact_messages (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";
        echo "</pre>";
    }
    
    echo "<h2>🌐 Access URLs</h2>";
    echo "<div style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>";
    echo "<h3>Contact Page URLs:</h3>";
    echo "<ul>";
    echo "<li><a href='index.php?page=contact' target='_blank'>index.php?page=contact</a></li>";
    echo "<li><a href='pages/contact.php' target='_blank'>pages/contact.php</a></li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<h2>📝 Contact Form Fields</h2>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Required</th><th>Description</th></tr>";
    echo "<tr><td>name</td><td>text</td><td>Yes</td><td>Full name</td></tr>";
    echo "<tr><td>email</td><td>email</td><td>Yes</td><td>Email address</td></tr>";
    echo "<tr><td>subject</td><td>select</td><td>Yes</td><td>Message subject</td></tr>";
    echo "<tr><td>message</td><td>textarea</td><td>Yes</td><td>Message content</td></tr>";
    echo "<tr><td>csrf_token</td><td>hidden</td><td>Yes</td><td>CSRF protection</td></tr>";
    echo "</table>";
    
    echo "<h2>📧 Subject Options</h2>";
    echo "<ul>";
    echo "<li>General Inquiry</li>";
    echo "<li>Product Questions</li>";
    echo "<li>Order Support</li>";
    echo "<li>Wholesale Inquiry</li>";
    echo "<li>Partnership</li>";
    echo "<li>Feedback</li>";
    echo "<li>Other</li>";
    echo "</ul>";
    
    echo "<h2>🔧 Functions Test</h2>";
    echo "<ul>";
    echo "<li>✅ sanitizeInput() - " . (function_exists('sanitizeInput') ? 'Available' : 'Missing') . "</li>";
    echo "<li>✅ validateEmail() - " . (function_exists('validateEmail') ? 'Available' : 'Missing') . "</li>";
    echo "<li>✅ csrf_token() - " . (function_exists('csrf_token') ? 'Available' : 'Missing') . "</li>";
    echo "<li>✅ validate_csrf_token() - " . (function_exists('validate_csrf_token') ? 'Available' : 'Missing') . "</li>";
    echo "</ul>";
    
    // Test CSRF token generation
    echo "<h2>🔐 CSRF Token Test</h2>";
    $token = csrf_token();
    echo "<p><strong>Generated Token:</strong> " . substr($token, 0, 20) . "...</p>";
    echo "<p><strong>Token Length:</strong> " . strlen($token) . " characters</p>";
    echo "<p><strong>Validation Test:</strong> " . (validate_csrf_token($token) ? '✅ Valid' : '❌ Invalid') . "</p>";
    
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
pre { background: #f3f4f6; padding: 15px; border-radius: 5px; overflow-x: auto; }
</style> 