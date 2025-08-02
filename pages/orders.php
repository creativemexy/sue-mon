<?php
$page_title = 'My Orders';
$page_description = 'View your order history and track your deliveries.';

// Check if user is logged in
if (!$auth->isLoggedIn()) {
    redirect('auth/login');
}

ob_start();
?>

<div class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">My Orders</h1>
            <p class="text-xl text-gray-600">View your order history and track your deliveries.</p>
        </div>
        
        <div class="text-center py-12">
            <i class="fas fa-shopping-bag text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Coming Soon</h3>
            <p class="text-gray-600 mb-4">Order history features are being developed.</p>
            <a href="<?php echo url('shop'); ?>" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                Shop Products
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 