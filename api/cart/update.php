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

if (!$input || !isset($input['product_id']) || !isset($input['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$product_id = $input['product_id'];
$quantity = (int)$input['quantity'];

if ($quantity < 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid quantity']);
    exit;
}

try {
    // Initialize cart if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Update cart
    if ($quantity === 0) {
        // Remove item
        unset($_SESSION['cart'][$product_id]);
    } else {
        // Update quantity
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        }
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
        'message' => 'Cart updated',
        'cart_count' => $cart_count,
        'cart_total' => $cart_total
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error updating cart']);
}
?> 