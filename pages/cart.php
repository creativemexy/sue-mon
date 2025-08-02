<?php
$page_title = 'Shopping Cart';
$page_description = 'Review and manage your shopping cart items.';

$cartItems = getCartItems();
$cartTotal = getCartTotal();

ob_start();
?>

<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

        <?php if (empty($cartItems)): ?>
            <!-- Empty Cart -->
            <div class="text-center py-12">
                <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Your cart is empty</h2>
                <p class="text-gray-600 mb-8">Looks like you haven't added any products to your cart yet.</p>
                <a href="<?php echo url('shop'); ?>" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Start Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">Cart Items (<?php echo count($cartItems); ?>)</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="p-6">
                                    <div class="flex items-center space-x-4">
                                        <img src="<?php echo getProductImage($item); ?>" 
                                             alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                             class="w-20 h-20 object-cover rounded-md">
                                        
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                <a href="<?php echo url('product') . '?id=' . $item['id']; ?>" class="hover:text-green-600 transition-colors">
                                                    <?php echo htmlspecialchars($item['name']); ?>
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 text-sm"><?php echo ucfirst($item['category']); ?></p>
                                            <p class="text-green-600 font-semibold"><?php echo formatPrice($item['price']); ?></p>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <button onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] - 1; ?>)" 
                                                    class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <span class="w-12 text-center font-medium"><?php echo $item['quantity']; ?></span>
                                            <button onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] + 1; ?>)" 
                                                    class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="text-right">
                                            <p class="text-lg font-semibold text-gray-900"><?php echo formatPrice($item['total']); ?></p>
                                            <button onclick="removeFromCart(<?php echo $item['id']; ?>)" 
                                                    class="text-red-500 hover:text-red-700 text-sm mt-1 transition-colors">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal (<?php echo count($cartItems); ?> items)</span>
                                <span><?php echo formatPrice($cartTotal); ?></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span><?php echo formatPrice(500); ?></span>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between text-lg font-semibold text-gray-900">
                                    <span>Total</span>
                                    <span><?php echo formatPrice($cartTotal + 500); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <a href="<?php echo url('checkout'); ?>" 
                               class="w-full bg-green-600 text-white py-3 px-6 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 font-medium text-center block">
                                Proceed to Checkout
                            </a>
                            
                            <a href="<?php echo url('shop'); ?>" 
                               class="w-full bg-gray-200 text-gray-800 py-3 px-6 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium text-center block">
                                Continue Shopping
                            </a>
                        </div>
                        
                        <!-- Coupon Code -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Have a coupon?</h3>
                            <div class="flex">
                                <input type="text" placeholder="Enter coupon code" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <button class="bg-green-600 text-white px-4 py-2 rounded-r-md hover:bg-green-700 transition-colors">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommended Products -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">You might also like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php 
                    $recommendedProducts = getFeaturedProducts(4);
                    foreach ($recommendedProducts as $product): 
                    ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative">
                                <img src="<?php echo getProductImage($product); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                     class="w-full h-48 object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    <a href="<?php echo url('product') . '?id=' . $product['id']; ?>" class="hover:text-green-600 transition-colors">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </a>
                                </h3>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-green-600"><?php echo formatPrice($product['price']); ?></span>
                                    <button onclick="addToCart(<?php echo $product['id']; ?>)" 
                                            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function updateQuantity(productId, quantity) {
    fetch('<?php echo url('api/cart/update'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function removeFromCart(productId) {
    fetch('<?php echo url('api/cart/remove'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 