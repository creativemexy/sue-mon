<?php
// Debug script to identify HTTP 500 errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "=== Debug Information ===\n\n";

// 1. Check PHP version
echo "1. PHP Version: " . phpversion() . "\n";

// 2. Check if required extensions are loaded
echo "\n2. Required Extensions:\n";
$required_extensions = ['curl', 'json', 'mbstring', 'xml'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext extension loaded\n";
    } else {
        echo "❌ $ext extension NOT loaded\n";
    }
}

// 3. Check file permissions
echo "\n3. File Permissions:\n";
$files_to_check = [
    'index.php',
    'config/config.php',
    'config/supabase_client.php',
    'includes/functions.php',
    'includes/auth.php'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        $perms = fileperms($file);
        $perms_octal = substr(sprintf('%o', $perms), -4);
        echo "✅ $file exists (permissions: $perms_octal)\n";
    } else {
        echo "❌ $file missing\n";
    }
}

// 4. Test configuration loading
echo "\n4. Configuration Test:\n";
try {
    require_once 'config/config.php';
    echo "✅ config.php loaded successfully\n";
    
    // Check if constants are defined
    if (defined('SUPABASE_URL')) {
        echo "✅ SUPABASE_URL defined: " . SUPABASE_URL . "\n";
    } else {
        echo "❌ SUPABASE_URL not defined\n";
    }
    
    if (defined('SUPABASE_ANON_KEY')) {
        echo "✅ SUPABASE_ANON_KEY defined\n";
    } else {
        echo "❌ SUPABASE_ANON_KEY not defined\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error loading config: " . $e->getMessage() . "\n";
}

// 5. Test Supabase client
echo "\n5. Supabase Client Test:\n";
try {
    require_once 'config/supabase_client.php';
    echo "✅ Supabase client loaded\n";
    
    $supabase = new SupabaseClient();
    echo "✅ Supabase client initialized\n";
    
    // Test a simple query
    try {
        $result = $supabase->select('products', 'count', [], true);
        echo "✅ Supabase connection successful\n";
    } catch (Exception $e) {
        echo "⚠️  Supabase connection failed: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error with Supabase client: " . $e->getMessage() . "\n";
}

// 6. Test includes
echo "\n6. Includes Test:\n";
try {
    require_once 'includes/functions.php';
    echo "✅ functions.php loaded\n";
    
    require_once 'includes/auth.php';
    echo "✅ auth.php loaded\n";
    
    $auth = new Auth();
    echo "✅ Auth object created\n";
    
} catch (Exception $e) {
    echo "❌ Error loading includes: " . $e->getMessage() . "\n";
}

// 7. Test session
echo "\n7. Session Test:\n";
try {
    session_start();
    echo "✅ Session started successfully\n";
} catch (Exception $e) {
    echo "❌ Session error: " . $e->getMessage() . "\n";
}

// 8. Test routing logic
echo "\n8. Routing Test:\n";
try {
    $_SERVER['REQUEST_URI'] = '/';
    $request_uri = $_SERVER['REQUEST_URI'];
    $base_path = '/';
    $path = str_replace($base_path, '', $request_uri);
    $path = parse_url($path, PHP_URL_PATH);
    $path = rtrim($path, '/');
    
    if (empty($path)) {
        $path = 'home';
    }
    
    echo "✅ Routing logic works (path: $path)\n";
    
    if (file_exists('pages/home.php')) {
        echo "✅ Home page exists\n";
    } else {
        echo "❌ Home page missing\n";
    }
    
} catch (Exception $e) {
    echo "❌ Routing error: " . $e->getMessage() . "\n";
}

// 9. Check error log location
echo "\n9. Error Log Information:\n";
echo "Error log location: " . ini_get('error_log') . "\n";
echo "Display errors: " . (ini_get('display_errors') ? 'ON' : 'OFF') . "\n";
echo "Log errors: " . (ini_get('log_errors') ? 'ON' : 'OFF') . "\n";

// 10. Test index.php inclusion
echo "\n10. Index.php Test:\n";
try {
    ob_start();
    include 'index.php';
    $output = ob_get_clean();
    echo "✅ index.php loaded successfully\n";
    echo "Output length: " . strlen($output) . " characters\n";
    
} catch (Exception $e) {
    echo "❌ Error loading index.php: " . $e->getMessage() . "\n";
}

echo "\n=== Debug Complete ===\n";
echo "\nIf you're still getting HTTP 500 errors:\n";
echo "1. Check your server's error logs\n";
echo "2. Verify your Supabase credentials\n";
echo "3. Ensure all required files are uploaded\n";
echo "4. Check file permissions on your server\n";
echo "5. Verify PHP version compatibility (PHP 8.0+)\n";
?> 