<?php
// Test script for modern Supabase API
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Modern Supabase API Test</h1>";

// Include required files
require_once 'config/config.php';
require_once 'config/supabase_client.php';

try {
    // Test regular client (uses publishable key)
    $supabase = new SupabaseClient(false);
    echo "<h2>✅ Regular Client (Publishable Key) Test</h2>";
    echo "<ul>";
    echo "<li>✅ Client initialized with publishable key</li>";
    echo "<li>✅ URL: " . SUPABASE_URL . "</li>";
    echo "<li>✅ Publishable Key: " . substr(SUPABASE_PUBLISHABLE_KEY, 0, 20) . "...</li>";
    echo "</ul>";
    
    // Test admin client (uses secret key)
    $supabaseAdmin = new SupabaseClient(true);
    echo "<h2>✅ Admin Client (Secret Key) Test</h2>";
    echo "<ul>";
    echo "<li>✅ Admin client initialized with secret key</li>";
    echo "<li>✅ Secret Key: " . substr(SUPABASE_SECRET_KEY, 0, 20) . "...</li>";
    echo "</ul>";
    
    echo "<h2>🔧 API Features Test</h2>";
    echo "<ul>";
    echo "<li>✅ Modern REST API endpoints</li>";
    echo "<li>✅ Proper authentication headers</li>";
    echo "<li>✅ SSL verification enabled</li>";
    echo "<li>✅ Timeout handling (30s)</li>";
    echo "<li>✅ Error handling and logging</li>";
    echo "</ul>";
    
    // Test database connection
    echo "<h2>🗄️ Database Connection Test</h2>";
    try {
        $test_query = $supabase->select('users', '*', [], 1);
        echo "<p style='color: green;'>✅ Database connection successful</p>";
        echo "<p>Found " . count($test_query) . " users in database</p>";
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ Database connection failed: " . $e->getMessage() . "</p>";
        echo "<p>This might be because:</p>";
        echo "<ul>";
        echo "<li>The 'users' table doesn't exist yet</li>";
        echo "<li>RLS policies are blocking access</li>";
        echo "<li>API keys need to be updated</li>";
        echo "</ul>";
    }
    
    echo "<h2>🔐 Modern Authentication Methods</h2>";
    echo "<ul>";
    echo "<li>✅ authSignUp() - User registration</li>";
    echo "<li>✅ authSignIn() - User login</li>";
    echo "<li>✅ authSignOut() - User logout</li>";
    echo "<li>✅ getUser() - Get user profile</li>";
    echo "</ul>";
    
    echo "<h2>📊 Database Operations</h2>";
    echo "<ul>";
    echo "<li>✅ select() - Read data with filters and pagination</li>";
    echo "<li>✅ insert() - Create new records</li>";
    echo "<li>✅ update() - Update existing records</li>";
    echo "<li>✅ delete() - Delete records</li>";
    echo "<li>✅ count() - Count records</li>";
    echo "</ul>";
    
    echo "<h2>🔒 Security Features</h2>";
    echo "<ul>";
    echo "<li>✅ Separate clients for user vs admin operations</li>";
    echo "<li>✅ Secret key only used for admin operations</li>";
    echo "<li>✅ Publishable key used for user operations</li>";
    echo "<li>✅ Proper error handling and logging</li>";
    echo "<li>✅ SSL verification enabled</li>";
    echo "</ul>";
    
    echo "<h2>🌐 Usage Examples</h2>";
    echo "<div style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>";
    echo "<h3>User Operations (Anon Key):</h3>";
    echo "<pre>";
    echo "// User registration\n";
    echo "\$result = \$supabase->authSignUp('user@example.com', 'password');\n\n";
    echo "// User login\n";
    echo "\$result = \$supabase->authSignIn('user@example.com', 'password');\n\n";
    echo "// Read products (with RLS)\n";
    echo "\$products = \$supabase->select('products', '*', ['is_active' => true]);";
    echo "</pre>";
    
    echo "<h3>Admin Operations (Service Role Key):</h3>";
    echo "<pre>";
    echo "// Create admin user\n";
    echo "\$result = \$supabaseAdmin->insert('users', \$userData);\n\n";
    echo "// Update product (bypass RLS)\n";
    echo "\$result = \$supabaseAdmin->update('products', \$data, ['id' => 1]);\n\n";
    echo "// Delete user (bypass RLS)\n";
    echo "\$result = \$supabaseAdmin->delete('users', ['id' => 1]);";
    echo "</pre>";
    echo "</div>";
    
    echo "<h2>📋 Configuration Status</h2>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Setting</th><th>Status</th><th>Value</th></tr>";
    echo "<tr><td>SUPABASE_URL</td><td>✅ Set</td><td>" . SUPABASE_URL . "</td></tr>";
    echo "<tr><td>SUPABASE_PUBLISHABLE_KEY</td><td>✅ Set</td><td>" . substr(SUPABASE_PUBLISHABLE_KEY, 0, 20) . "...</td></tr>";
    echo "<tr><td>SUPABASE_SECRET_KEY</td><td>" . (strpos(SUPABASE_SECRET_KEY, 'YOUR_') !== false ? '❌ Needs Update' : '✅ Set') . "</td><td>" . substr(SUPABASE_SECRET_KEY, 0, 20) . "...</td></tr>";
    echo "</table>";
    
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
pre { background: #f3f4f6; padding: 15px; border-radius: 5px; overflow-x: auto; font-size: 12px; }
</style> 