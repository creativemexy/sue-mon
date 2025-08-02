<?php
$page_title = 'Page Not Found';
$page_description = 'The page you are looking for could not be found.';

ob_start();
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                404 - Page Not Found
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                The page you are looking for could not be found. It might have been moved, deleted, or you entered the wrong URL.
            </p>
        </div>
        
        <div class="mt-8 space-y-4">
            <a href="<?php echo url(); ?>" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Go to Homepage
            </a>
            
            <a href="<?php echo url('shop'); ?>" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Browse Products
            </a>
        </div>
        
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">
                Need help? <a href="<?php echo url('contact'); ?>" class="font-medium text-green-600 hover:text-green-500">Contact us</a>
            </p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 