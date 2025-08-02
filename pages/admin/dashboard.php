<?php
$page_title = 'Admin Dashboard';
$page_description = 'Admin dashboard for managing the website.';

ob_start();
?>

<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Admin Dashboard</h1>
            <p class="text-xl text-gray-600">Manage your website and products.</p>
        </div>
        
        <div class="text-center py-12">
            <i class="fas fa-cog text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Coming Soon</h3>
            <p class="text-gray-600 mb-4">Admin features are being developed.</p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 