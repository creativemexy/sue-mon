<?php
// Initialize required variables if accessed directly
if (!isset($auth)) {
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../config/supabase_client.php';
    require_once __DIR__ . '/../includes/auth.php';
    require_once __DIR__ . '/../includes/functions.php';
    
    $supabase = new SupabaseClient();
    $auth = new Auth();
}

$page_title = 'Checkout';
$page_description = 'Complete your order and payment.';

// Redirect if cart is empty
$cartItems = getCartItems();
if (empty($cartItems)) {
    redirect('cart');
}

$cartTotal = getCartTotal();

// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $_SESSION['error_message'] = 'Invalid request. Please try again.';
    } else {
        $shippingData = [
            'name' => sanitizeInput($_POST['name']),
            'email' => sanitizeInput($_POST['email']),
            'phone' => sanitizeInput($_POST['phone']),
            'address' => sanitizeInput($_POST['address']),
            'city' => sanitizeInput($_POST['city']),
            'state' => sanitizeInput($_POST['state']),
            'postal_code' => sanitizeInput($_POST['postal_code']),
            'country' => sanitizeInput($_POST['country'])
        ];
        
        // Basic validation
        $errors = [];
        if (empty($shippingData['name'])) $errors[] = 'Name is required';
        if (empty($shippingData['email'])) $errors[] = 'Email is required';
        if (!validateEmail($shippingData['email'])) $errors[] = 'Valid email is required';
        if (empty($shippingData['phone'])) $errors[] = 'Phone is required';
        if (empty($shippingData['address'])) $errors[] = 'Address is required';
        if (empty($shippingData['city'])) $errors[] = 'City is required';
        if (empty($shippingData['state'])) $errors[] = 'State is required';
        
        if (empty($errors)) {
            // Create order
            $userId = $auth->isLoggedIn() ? $_SESSION['user_id'] : null;
            $result = createOrder($userId, $cartItems, $shippingData);
            
            if ($result['success']) {
                $_SESSION['flash_message'] = 'Order placed successfully! Order #' . $result['order_id'];
                redirect('orders');
            } else {
                $_SESSION['error_message'] = $result['message'];
            }
        } else {
            $_SESSION['error_message'] = implode(', ', $errors);
        }
    }
}

ob_start();
?>

<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Checkout Form -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Shipping Information</h2>
                    
                    <form method="POST" class="space-y-6">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" name="name" id="name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" name="email" id="email" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" name="phone" id="phone" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <input type="text" name="address" id="address" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" name="city" id="city" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                                <input type="text" name="state" id="state" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>
                        
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                            <select name="country" id="country"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="Nigeria" selected>Nigeria</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Kenya">Kenya</option>
                                <option value="South Africa">South Africa</option>
                            </select>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Method</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="paystack" id="paystack" checked
                                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <label for="paystack" class="ml-3 text-sm font-medium text-gray-700">
                                        Paystack (Credit/Debit Card, Bank Transfer)
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="cash" id="cash"
                                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <label for="cash" class="ml-3 text-sm font-medium text-gray-700">
                                        Cash on Delivery
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Order Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                      placeholder="Any special instructions for your order..."></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-3 px-6 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 font-medium">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="flex items-center space-x-4">
                                <img src="<?php echo getProductImage($item); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                     class="w-12 h-12 object-cover rounded-md">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($item['name']); ?></h4>
                                    <p class="text-sm text-gray-500">Qty: <?php echo $item['quantity']; ?></p>
                                </div>
                                <p class="text-sm font-medium text-gray-900"><?php echo formatPrice($item['total']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Totals -->
                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal</span>
                            <span><?php echo formatPrice($cartTotal); ?></span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Shipping</span>
                            <span><?php echo formatPrice(500); ?></span>
                        </div>
                        <div class="border-t border-gray-200 pt-2">
                            <div class="flex justify-between text-lg font-semibold text-gray-900">
                                <span>Total</span>
                                <span><?php echo formatPrice($cartTotal + 500); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Security Notice -->
                    <div class="mt-6 text-center">
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-lock mr-1"></i>
                            Your payment information is secure and encrypted
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 