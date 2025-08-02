<?php
// Test .htaccess and server configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Server Configuration Test</h1>";

echo "<h2>Server Information:</h2>";
echo "<strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";
echo "<strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "<br>";
echo "<strong>Script Name:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'Unknown') . "<br>";
echo "<strong>Request URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Unknown') . "<br>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";

echo "<h2>File System Test:</h2>";
$files_to_check = [
    'index.php',
    'config/config.php',
    'config/supabase_client.php',
    'includes/auth.php',
    'pages/auth/login.php',
    '.htaccess'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file missing<br>";
    }
}

echo "<h2>mod_rewrite Test:</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "✅ mod_rewrite is enabled<br>";
    } else {
        echo "❌ mod_rewrite is NOT enabled<br>";
    }
} else {
    echo "⚠️ Cannot check mod_rewrite status (not Apache or function not available)<br>";
}

echo "<h2>URL Rewriting Test:</h2>";
echo "If you can see this page, basic PHP is working.<br>";
echo "Now test if URL rewriting works:<br>";
echo "<a href='test_rewrite'>Test URL Rewriting</a><br>";
echo "<a href='auth/login'>Test auth/login</a><br>";
echo "<a href='shop'>Test shop</a><br>";

echo "<h2>Direct File Access Test:</h2>";
echo "<a href='pages/auth/login.php'>Direct access to login.php</a><br>";
echo "<a href='pages/shop.php'>Direct access to shop.php</a><br>";

echo "<h2>Recommendations:</h2>";
if (strpos($_SERVER['SERVER_SOFTWARE'] ?? '', 'Apache') !== false) {
    echo "✅ You're using Apache server<br>";
    echo "Try the .htaccess solution<br>";
} elseif (strpos($_SERVER['SERVER_SOFTWARE'] ?? '', 'nginx') !== false) {
    echo "✅ You're using Nginx server<br>";
    echo "Use the Nginx configuration solution<br>";
} elseif (strpos($_SERVER['SERVER_SOFTWARE'] ?? '', 'Caddy') !== false) {
    echo "✅ You're using Caddy server<br>";
    echo "Use the Caddy configuration solution<br>";
} else {
    echo "⚠️ Unknown server type<br>";
    echo "Try the URL parameters solution<br>";
}
?> 