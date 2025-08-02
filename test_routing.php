<?php
// Simple routing test
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Routing Test</h1>";

// Simulate different URLs
$test_urls = [
    '/',
    '/auth/login',
    '/auth/register',
    '/shop',
    '/about',
    '/nonexistent'
];

foreach ($test_urls as $test_url) {
    echo "<h3>Testing: $test_url</h3>";
    
    // Simulate the routing logic
    $_SERVER['REQUEST_URI'] = $test_url;
    $request_uri = $_SERVER['REQUEST_URI'];
    $base_path = '/';
    
    // Remove base path from request URI
    $path = str_replace($base_path, '', $request_uri);
    $path = parse_url($path, PHP_URL_PATH);
    
    // Remove trailing slash
    $path = rtrim($path, '/');
    
    // Default to home if empty
    if (empty($path)) {
        $path = 'home';
    }
    
    echo "Request URI: $request_uri<br>";
    echo "Path: $path<br>";
    
    // Route definitions
    $routes = [
        'home' => 'pages/home.php',
        'shop' => 'pages/shop.php',
        'categories' => 'pages/categories.php',
        'benefits' => 'pages/benefits.php',
        'subscription' => 'pages/subscription.php',
        'blog' => 'pages/blog.php',
        'about' => 'pages/about.php',
        'contact' => 'pages/contact.php',
        'auth/login' => 'pages/auth/login.php',
        'auth/register' => 'pages/auth/register.php',
        'auth/logout' => 'pages/auth/logout.php',
        'admin' => 'pages/admin/dashboard.php',
        'admin/products' => 'pages/admin/products.php',
        'admin/blog' => 'pages/admin/blog.php',
        'admin/orders' => 'pages/admin/orders.php',
        'cart' => 'pages/cart.php',
        'checkout' => 'pages/checkout.php',
        'product' => 'pages/product.php',
        'search' => 'pages/search.php',
        'faq' => 'pages/faq.php',
        'shipping' => 'pages/shipping.php',
        'returns' => 'pages/returns.php',
        'privacy' => 'pages/privacy.php',
        'terms' => 'pages/terms.php',
        'support' => 'pages/support.php',
        'track' => 'pages/track.php',
        'gifts' => 'pages/gifts.php',
        'story' => 'pages/story.php',
        'wholesale' => 'pages/wholesale.php',
        'wishlist' => 'pages/wishlist.php',
        'profile' => 'pages/profile.php',
        'orders' => 'pages/orders.php'
    ];
    
    if (isset($routes[$path])) {
        $page_file = $routes[$path];
        if (file_exists($page_file)) {
            echo "✅ Route found: $page_file<br>";
        } else {
            echo "❌ File not found: $page_file<br>";
        }
    } else {
        echo "❌ Route not found for: $path<br>";
    }
    
    echo "<hr>";
}

echo "<h2>Available Routes:</h2>";
echo "<ul>";
foreach (array_keys($routes) as $route) {
    echo "<li>$route</li>";
}
echo "</ul>";

echo "<h2>Server Information:</h2>";
echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "<br>";
echo "Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'Unknown') . "<br>";
echo "Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'Unknown') . "<br>";
?> 