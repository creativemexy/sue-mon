<?php
$page_title = 'Wholesale';
$page_description = 'Wholesale opportunities for businesses and retailers.';

ob_start();
?>

<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Wholesale</h1>
            <p class="text-xl text-gray-600">Partner with us to offer premium herbal teas to your customers.</p>
        </div>
        
        <div class="text-center py-12">
            <i class="fas fa-building text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Coming Soon</h3>
            <p class="text-gray-600 mb-4">We're developing our wholesale program for businesses.</p>
            <a href="<?php echo url('contact'); ?>" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                Contact Us
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 