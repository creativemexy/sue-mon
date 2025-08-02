<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../config/config.php';
require_once '../config/supabase_client.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get search query
$query = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $query = trim($input['query'] ?? '');
} else {
    $query = trim($_GET['q'] ?? '');
}

if (empty($query)) {
    echo json_encode(['success' => false, 'message' => 'Search query is required']);
    exit;
}

try {
    // Get all products and filter by search term
    $products = $supabase->select('products', '*');
    
    if (empty($products)) {
        echo json_encode(['success' => true, 'products' => []]);
        exit;
    }
    
    // Filter products by search term
    $filtered_products = [];
    $search_terms = explode(' ', strtolower($query));
    
    foreach ($products as $product) {
        $product_text = strtolower($product['name'] . ' ' . ($product['description'] ?? '') . ' ' . ($product['category'] ?? ''));
        
        $matches = true;
        foreach ($search_terms as $term) {
            if (!empty($term) && strpos($product_text, $term) === false) {
                $matches = false;
                break;
            }
        }
        
        if ($matches) {
            $filtered_products[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image_url' => $product['image_url'] ?? '',
                'description' => $product['description'] ?? '',
                'category' => $product['category'] ?? ''
            ];
        }
    }
    
    // Limit results to 10
    $filtered_products = array_slice($filtered_products, 0, 10);
    
    echo json_encode([
        'success' => true,
        'products' => $filtered_products,
        'count' => count($filtered_products)
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Search failed']);
}
?> 