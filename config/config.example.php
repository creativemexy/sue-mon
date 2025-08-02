<?php
// Site Configuration
define('SITE_NAME', 'Sue & Mon');
define('SITE_DESCRIPTION', 'Premium Herbal Blends');
define('SITE_URL', 'http://localhost:8000'); // Change for production

// Supabase/PostgreSQL Configuration
define('DB_HOST', 'your-database-host.supabase.co');
define('DB_NAME', 'postgres');
define('DB_USER', 'postgres');
define('DB_PASS', 'your-database-password'); // Fill this in
define('DB_PORT', '5432');

// Supabase Configuration (for API calls)
define('SUPABASE_URL', 'https://your-project.supabase.co');
define('SUPABASE_ANON_KEY', 'your-supabase-anon-key');
define('SUPABASE_SERVICE_ROLE_KEY', 'your-supabase-service-role-key');

// Paystack Configuration
define('PAYSTACK_SECRET_KEY', 'your-paystack-secret-key');
define('PAYSTACK_PUBLIC_KEY', 'your-paystack-public-key');

// Session Configuration
define('SESSION_LIFETIME', 3600); // 1 hour

// Currency
define('CURRENCY', 'NGN');
if (!defined('CURRENCY_SYMBOL')) {
    define('CURRENCY_SYMBOL', '₦');
}

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);

// Helper function for asset URLs
function asset($path) {
    return SITE_URL . '/public/' . ltrim($path, '/');
}

// Helper function for URLs
function url($path = '') {
    return SITE_URL . '/' . ltrim($path, '/');
}
?> 