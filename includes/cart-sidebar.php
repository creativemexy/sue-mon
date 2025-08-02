<div id="cart-sidebar" class="fixed inset-y-0 right-0 w-96 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-50">
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Shopping Cart</h2>
            <button onclick="closeCartSidebar()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-6">
            <?php $cartItems = getCartItems(); ?>
            <?php if (empty($cartItems)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Your cart is empty</p>
                    <a href="<?php echo url('shop'); ?>" class="mt-4 inline-block bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition-colors">
                        Start Shopping
                    </a>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <img src="<?php echo getProductImage($item); ?>" alt="<?php echo $item['name']; ?>" 
                                 class="w-16 h-16 object-cover rounded-md">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900"><?php echo $item['name']; ?></h3>
                                <p class="text-sm text-gray-600"><?php echo formatPrice($item['price']); ?></p>
                                <div class="flex items-center space-x-2 mt-2">
                                    <button onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] - 1; ?>)" 
                                            class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="text-sm font-medium"><?php echo $item['quantity']; ?></span>
                                    <button onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] + 1; ?>)" 
                                            class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-900"><?php echo formatPrice($item['total']); ?></p>
                                <button onclick="removeFromCart(<?php echo $item['id']; ?>)" 
                                        class="text-red-500 hover:text-red-700 text-sm mt-1 transition-colors">
                                    Remove
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Cart Summary -->
        <?php if (!empty($cartItems)): ?>
            <div class="border-t border-gray-200 p-6">
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span>Subtotal:</span>
                        <span><?php echo formatPrice(getCartTotal()); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Shipping:</span>
                        <span><?php echo formatPrice(500); ?></span>
                    </div>
                    <div class="flex justify-between font-semibold text-lg border-t pt-2">
                        <span>Total:</span>
                        <span><?php echo formatPrice(getCartTotal() + 500); ?></span>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <a href="<?php echo url('checkout'); ?>" 
                       class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 transition-colors text-center font-medium">
                        Proceed to Checkout
                    </a>
                    <button onclick="closeCartSidebar()" 
                            class="w-full bg-gray-200 text-gray-800 py-3 px-4 rounded-md hover:bg-gray-300 transition-colors font-medium">
                        Continue Shopping
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Overlay -->
<div id="cart-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeCartSidebar()"></div>

<script>
function openCartSidebar() {
    document.getElementById('cart-sidebar').classList.remove('translate-x-full');
    document.getElementById('cart-overlay').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCartSidebar() {
    document.getElementById('cart-sidebar').classList.add('translate-x-full');
    document.getElementById('cart-overlay').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

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