<?php
session_start();
require_once 'config/config.php';
require_once 'config/supabase_client.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';

// Initialize auth object
$auth = new Auth();

// Get page from URL parameter
$page = $_GET['page'] ?? 'home';

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

// Debug mode
if (isset($_GET['debug'])) {
    echo "Page requested: $page<br>";
    echo "Available routes: " . implode(', ', array_keys($routes)) . "<br>";
}

// Check if route exists
if (isset($routes[$page]) && file_exists($routes[$page])) {
    include $routes[$page];
} else {
    include 'pages/404.php';
}
?> 