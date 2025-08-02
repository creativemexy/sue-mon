<?php
// Check if mod_rewrite is enabled
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>mod_rewrite Check</h1>";

if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    echo "<h2>Available Apache Modules:</h2>";
    echo "<ul>";
    foreach ($modules as $module) {
        echo "<li>$module</li>";
    }
    echo "</ul>";
    
    if (in_array('mod_rewrite', $modules)) {
        echo "<h2 style='color: green;'>✅ mod_rewrite is ENABLED</h2>";
        echo "<p>Your server supports URL rewriting. The .htaccess file should work.</p>";
    } else {
        echo "<h2 style='color: red;'>❌ mod_rewrite is NOT ENABLED</h2>";
        echo "<p>You need to enable mod_rewrite or use an alternative solution.</p>";
    }
} else {
    echo "<h2 style='color: orange;'>⚠️ Cannot check mod_rewrite</h2>";
    echo "<p>This might not be an Apache server, or the function is not available.</p>";
    echo "<p>Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";
}

echo "<h2>Alternative Solutions:</h2>";
echo "<ul>";
echo "<li><a href='index.php?page=auth/login'>Use URL parameters: index.php?page=auth/login</a></li>";
echo "<li><a href='pages/auth/login.php'>Direct file access: pages/auth/login.php</a></li>";
echo "<li>Contact your hosting provider to enable mod_rewrite</li>";
echo "</ul>";
?> 