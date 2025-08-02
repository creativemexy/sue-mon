<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : SITE_DESCRIPTION; ?>">
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo asset('favicon.ico'); ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo asset('logo.svg'); ?>">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo asset('css/style.css'); ?>" rel="stylesheet">
    
    <!-- Additional CSS for specific pages -->
    <?php if (isset($additional_css)): ?>
        <?php foreach ($additional_css as $css): ?>
            <link href="<?php echo $css; ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    
    <!-- Main Content -->
    <main class="min-h-screen">
        <?php if (isset($content)): ?>
            <?php echo $content; ?>
        <?php endif; ?>
    </main>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    
    <!-- Cart Sidebar -->
    <?php include 'includes/cart-sidebar.php'; ?>
    
    <!-- Search Modal -->
    <?php include 'includes/search-modal.php'; ?>
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.3.5/dist/alpine.min.js" defer></script>
    <script src="<?php echo asset('js/app.js'); ?>"></script>
    
    <!-- Additional JavaScript for specific pages -->
    <?php if (isset($additional_js)): ?>
        <?php foreach ($additional_js as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Flash Messages -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div id="flash-message" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <?php echo $_SESSION['flash_message']; ?>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('flash-message').style.display = 'none';
            }, 5000);
        </script>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div id="error-message" class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <?php echo $_SESSION['error_message']; ?>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('error-message').style.display = 'none';
            }, 5000);
        </script>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
</body>
</html> 