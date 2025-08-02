<?php
// Test script to check for common errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Testing Sue & Mon PHP Application ===\n\n";

// Test 1: Check if required files exist
echo "1. Checking required files...\n";
$required_files = [
    'config/config.php',
    'config/supabase_client.php',
    'includes/functions.php',
    'includes/auth.php',
    'includes/layout.php',
    'includes/header.php',
    'includes/footer.php',
    'pages/home.php',
    'pages/404.php'
];

foreach ($required_files as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists\n";
    } else {
        echo "❌ $file missing\n";
    }
}

echo "\n2. Testing configuration...\n";
try {
    require_once 'config/config.php';
    echo "✅ config.php loaded successfully\n";
    
    // Check if Supabase URL is configured
    if (defined('SUPABASE_URL') && SUPABASE_URL !== 'https://your-project.supabase.co') {
        echo "✅ Supabase URL configured\n";
    } else {
        echo "⚠️  Supabase URL not configured (using placeholder)\n";
    }
    
    // Check if Supabase service role key is configured
    if (defined('SUPABASE_SERVICE_ROLE_KEY') && SUPABASE_SERVICE_ROLE_KEY !== 'your_supabase_service_role_key') {
        echo "✅ Supabase service role key configured\n";
    } else {
        echo "⚠️  Supabase service role key not configured (using placeholder)\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error loading config: " . $e->getMessage() . "\n";
}

echo "\n3. Testing Supabase client...\n";
try {
    require_once 'config/supabase_client.php';
    echo "✅ Supabase client loaded\n";
    
    // Test Supabase connection
    try {
        $supabase = new SupabaseClient();
        echo "✅ Supabase client initialized\n";
        
        // Try a simple query (this might fail if credentials are not set)
        try {
            $result = $supabase->select('products', 'count', [], true);
            echo "✅ Supabase connection successful\n";
        } catch (Exception $e) {
            echo "⚠️  Supabase connection failed: " . $e->getMessage() . "\n";
            echo "   This is expected if Supabase credentials are not configured\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error initializing Supabase client: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error loading Supabase client: " . $e->getMessage() . "\n";
}

echo "\n4. Testing includes...\n";
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

echo "\n5. Testing routing...\n";
try {
    // Simulate a request
    $_SERVER['REQUEST_URI'] = '/';
    
    // Test if the routing logic works
    $request_uri = $_SERVER['REQUEST_URI'];
    $base_path = '/';
    $path = str_replace($base_path, '', $request_uri);
    $path = parse_url($path, PHP_URL_PATH);
    $path = rtrim($path, '/');
    
    if (empty($path)) {
        $path = 'home';
    }
    
    echo "✅ Routing logic works (path: $path)\n";
    
    // Check if home page exists
    if (file_exists('pages/home.php')) {
        echo "✅ Home page exists\n";
    } else {
        echo "❌ Home page missing\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error testing routing: " . $e->getMessage() . "\n";
}

echo "\n6. Testing index.php...\n";
try {
    // Test if index.php can be included without errors
    ob_start();
    include 'index.php';
    $output = ob_get_clean();
    echo "✅ index.php loaded successfully\n";
    
} catch (Exception $e) {
    echo "❌ Error loading index.php: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "\nTo fix any issues:\n";
echo "1. Configure your Supabase credentials in config/config.php\n";
echo "2. Set up your Supabase service role key from Supabase dashboard\n";
echo "3. Ensure all required files are present\n";
echo "4. Check file permissions\n";
echo "5. Make sure your Supabase project is active and accessible\n";
?> 