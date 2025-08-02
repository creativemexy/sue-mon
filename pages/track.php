<?php
$page_title = 'Track Order';
$page_description = 'Track your order status and delivery progress.';

ob_start();
?>

<div class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Track Your Order</h1>
            <p class="text-xl text-gray-600">Enter your order number to track your delivery status.</p>
        </div>
        
        <div class="max-w-md mx-auto">
            <form method="GET" class="space-y-4">
                <div>
                    <label for="order_number" class="block text-sm font-medium text-gray-700 mb-2">Order Number</label>
                    <input type="text" name="order_number" id="order_number" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           placeholder="Enter your order number">
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-3 px-6 rounded-md hover:bg-green-700 transition-colors font-medium">
                    Track Order
                </button>
            </form>
        </div>
        
        <div class="mt-12 text-center">
            <p class="text-gray-600">Need help? <a href="<?php echo url('contact'); ?>" class="text-green-600 hover:text-green-700">Contact our support team</a></p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 