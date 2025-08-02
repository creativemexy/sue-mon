<?php
session_start();
require_once 'config/config.php';
require_once 'config/supabase_client.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';

// Initialize auth object
$auth = new Auth();

// Simple routing
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
    'orders' => 'pages/orders.php',
    'auth/login' => 'pages/auth/login.php',
    'auth/register' => 'pages/auth/register.php',
    'auth/logout' => 'pages/auth/logout.php'
];

// Check if route exists
if (isset($routes[$path])) {
    $page_file = $routes[$path];
    if (file_exists($page_file)) {
        include $page_file;
    } else {
        include 'pages/404.php';
    }
} else {
    // Check for dynamic routes (like product pages)
    if (strpos($path, 'product/') === 0) {
        $_GET['id'] = substr($path, 8); // Remove 'product/' prefix
        include 'pages/product.php';
    } else {
        include 'pages/404.php';
    }
}
?> 