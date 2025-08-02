<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../../config/config.php';
require_once '../../config/supabase_client.php';
require_once '../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$product_id = $input['product_id'];

try {
    // Initialize cart if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Remove item from cart
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    
    // Calculate total cart count and price
    $cart_count = 0;
    $cart_total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
        $cart_total += $item['price'] * $item['quantity'];
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Item removed from cart',
        'cart_count' => $cart_count,
        'cart_total' => $cart_total
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error removing from cart']);
}
?> 