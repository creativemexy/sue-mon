<?php
// Cart Functions
function addToCart($productId, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

function updateCartQuantity($productId, $quantity) {
    if ($quantity <= 0) {
        removeFromCart($productId);
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

function getCartItems() {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return [];
    }
    
    $items = [];
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $product = getProduct($productId);
        if ($product) {
            $product['quantity'] = $quantity;
            $product['total'] = $product['price'] * $quantity;
            $items[] = $product;
        }
    }
    return $items;
}

function getCartTotal() {
    $items = getCartItems();
    return array_sum(array_column($items, 'total'));
}

function getCartCount() {
    if (!isset($_SESSION['cart'])) {
        return 0;
    }
    return array_sum($_SESSION['cart']);
}

function clearCart() {
    unset($_SESSION['cart']);
}

// Product Functions
function getProducts($limit = null, $offset = 0, $category = null, $search = null) {
    global $supabase;
    
    try {
        $filters = ['is_active' => true];
        if ($category) {
            $filters['category'] = $category;
        }
        
        $result = $supabase->select('products', '*', $filters);
        
        // Apply search filter if provided
        if ($search) {
            $result = array_filter($result, function($product) use ($search) {
                return stripos($product['name'], $search) !== false || 
                       stripos($product['description'], $search) !== false;
            });
        }
        
        if ($limit) {
            $result = array_slice($result, $offset, $limit);
        }
        
        return $result;
    } catch (Exception $e) {
        error_log("Error getting products: " . $e->getMessage());
        return [];
    }
}

function getProduct($id) {
    global $supabase;
    
    try {
        $result = $supabase->select('products', '*', ['id' => $id]);
        return $result[0] ?? null;
    } catch (Exception $e) {
        error_log("Error getting product: " . $e->getMessage());
        return null;
    }
}

function getFeaturedProducts($limit = 6) {
    global $supabase;
    
    try {
        $result = $supabase->select('products', '*', ['featured' => true, 'is_active' => true]);
        return array_slice($result, 0, $limit);
    } catch (Exception $e) {
        error_log("Error getting featured products: " . $e->getMessage());
        return [];
    }
}

function getNewProducts($limit = 6) {
    global $supabase;
    
    try {
        // Get products ordered by created_at desc
        $result = $supabase->select('products', '*', ['is_active' => true]);
        // Sort by created_at desc and take the latest
        usort($result, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        return array_slice($result, 0, $limit);
    } catch (Exception $e) {
        error_log("Error getting new products: " . $e->getMessage());
        return [];
    }
}

function getProductsByCategory($category, $limit = 4) {
    return getProducts($limit, 0, $category);
}

function getCategories() {
    global $supabase;
    
    try {
        // Get unique categories from products
        $products = $supabase->select('products', 'category', ['is_active' => true]);
        $categories = [];
        $categoryCounts = [];
        
        foreach ($products as $product) {
            $category = $product['category'];
            if (!isset($categoryCounts[$category])) {
                $categoryCounts[$category] = 0;
            }
            $categoryCounts[$category]++;
        }
        
        foreach ($categoryCounts as $category => $count) {
            $categories[] = [
                'category' => $category,
                'count' => $count
            ];
        }
        
        return $categories;
    } catch (Exception $e) {
        error_log("Error getting categories: " . $e->getMessage());
        return [];
    }
}

// Order Functions
function createOrder($userId, $cartItems, $shippingData) {
    global $supabase;
    
    try {
        // Create order
        $orderData = [
            'user_id' => $userId,
            'total_amount' => getCartTotal(),
            'shipping_address' => json_encode($shippingData),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $orderId = $supabase->insert('orders', $orderData);
        
        // Create order items
        foreach ($cartItems as $item) {
            $orderItemData = [
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ];
            $supabase->insert('order_items', $orderItemData);
        }
        
        clearCart();
        
        return ['success' => true, 'order_id' => $orderId];
    } catch (Exception $e) {
        error_log("Error creating order: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to create order'];
    }
}

function getOrder($orderId) {
    global $supabase;
    
    try {
        $result = $supabase->select('orders', '*', ['id' => $orderId]);
        return $result[0] ?? null;
    } catch (Exception $e) {
        error_log("Error getting order: " . $e->getMessage());
        return null;
    }
}

function getUserOrders($userId) {
    global $supabase;
    
    try {
        $result = $supabase->select('orders', '*', ['user_id' => $userId]);
        return $result;
    } catch (Exception $e) {
        error_log("Error getting user orders: " . $e->getMessage());
        return [];
    }
}

// Blog Functions
function getBlogPosts($limit = 6, $offset = 0) {
    global $supabase;
    
    try {
        $result = $supabase->select('blog_posts', '*', ['published' => true]);
        return array_slice($result, $offset, $limit);
    } catch (Exception $e) {
        error_log("Error getting blog posts: " . $e->getMessage());
        return [];
    }
}

function getBlogPost($id) {
    global $supabase;
    
    try {
        $result = $supabase->select('blog_posts', '*', ['id' => $id]);
        return $result[0] ?? null;
    } catch (Exception $e) {
        error_log("Error getting blog post: " . $e->getMessage());
        return null;
    }
}

// Utility Functions
function formatPrice($price) {
    return CURRENCY_SYMBOL . number_format($price, 2);
}

function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

function getProductImage($product) {
    if (!empty($product['image_url'])) {
        return asset($product['image_url']);
    }
    
    // Return a placeholder image
    return 'data:image/svg+xml;base64,' . base64_encode('
        <svg width="300" height="200" xmlns="http://www.w3.org/2000/svg">
            <rect width="100%" height="100%" fill="#f3f4f6"/>
            <text x="50%" y="50%" font-family="Arial" font-size="16" fill="#9ca3af" text-anchor="middle" dy=".3em">
                Product Image
            </text>
        </svg>
    ');
}

function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return $text;
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function uploadImage($file, $directory = 'products') {
    $uploadDir = 'public/images/' . $directory . '/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $fileName = uniqid() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'images/' . $directory . '/' . $fileName;
    }
    
    return false;
}

function paginate($total, $perPage, $currentPage) {
    $totalPages = ceil($total / $perPage);
    $currentPage = max(1, min($currentPage, $totalPages));
    
    return [
        'current_page' => $currentPage,
        'total_pages' => $totalPages,
        'has_prev' => $currentPage > 1,
        'has_next' => $currentPage < $totalPages,
        'prev_page' => $currentPage - 1,
        'next_page' => $currentPage + 1
    ];
}

// Newsletter Functions
function subscribeNewsletter($email) {
    global $supabase;
    
    try {
        $data = [
            'email' => $email,
            'subscribed_at' => date('Y-m-d H:i:s')
        ];
        
        $supabase->insert('newsletter_subscribers', $data);
        return true;
    } catch (Exception $e) {
        error_log("Error subscribing to newsletter: " . $e->getMessage());
        return false;
    }
}

// Search Functions
function searchProducts($query) {
    global $supabase;
    
    try {
        // Get all active products and filter by search term
        $products = $supabase->select('products', '*', ['is_active' => true]);
        
        $results = array_filter($products, function($product) use ($query) {
            return stripos($product['name'], $query) !== false || 
                   stripos($product['description'], $query) !== false;
        });
        
        return array_values($results);
    } catch (Exception $e) {
        error_log("Error searching products: " . $e->getMessage());
        return [];
    }
}
?> 
?> 