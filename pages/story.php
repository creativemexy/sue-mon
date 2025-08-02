<?php
$page_title = 'Our Story';
$page_description = 'Learn about the journey and passion behind Sue & Mon.';

ob_start();
?>

<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Story</h1>
            <p class="text-xl text-gray-600">The journey behind Sue & Mon's passion for herbal wellness.</p>
        </div>
        
        <div class="text-center py-12">
            <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Coming Soon</h3>
            <p class="text-gray-600 mb-4">We're working on sharing our complete story with you.</p>
            <a href="<?php echo url('about'); ?>" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                Learn More About Us
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 