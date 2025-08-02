<?php
// Initialize required variables if accessed directly
if (!isset($auth)) {
    require_once __DIR__ . '/../../config/config.php';
    require_once __DIR__ . '/../../config/supabase_client.php';
    require_once __DIR__ . '/../../includes/auth.php';
    
    $supabase = new SupabaseClient();
    $auth = new Auth();
}

$page_title = 'Admin Dashboard';
$page_description = 'Admin dashboard for managing the website.';

// Check if user is admin
if (!$auth->isLoggedIn() || !$auth->isAdmin()) {
    header('Location: ' . url('auth/login'));
    exit;
}

ob_start();
?>

<div class="bg-gray-50 min-h-screen">
    <!-- Admin Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Welcome, <?php echo $_SESSION['user_name']; ?></span>
                    <a href="<?php echo url('auth/logout'); ?>" class="text-sm text-red-600 hover:text-red-500">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-shopping-bag text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Products</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            <?php 
                            try {
                                $product_count = $supabase->count('products');
                                echo $product_count;
                            } catch (Exception $e) {
                                echo '0';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Users</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            <?php 
                            try {
                                $user_count = $supabase->count('users');
                                echo $user_count;
                            } catch (Exception $e) {
                                echo '0';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-shopping-cart text-2xl text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Orders</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            <?php 
                            try {
                                $order_count = $supabase->count('orders');
                                echo $order_count;
                            } catch (Exception $e) {
                                echo '0';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-newspaper text-2xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Blog Posts</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            <?php 
                            try {
                                $blog_count = $supabase->count('blog_posts');
                                echo $blog_count;
                            } catch (Exception $e) {
                                echo '0';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="<?php echo url('admin/products'); ?>" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-plus text-green-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-900">Add Product</span>
                    </a>
                    
                    <a href="<?php echo url('admin/orders'); ?>" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-list text-blue-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-900">View Orders</span>
                    </a>
                    
                    <a href="<?php echo url('admin/blog'); ?>" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-edit text-purple-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-900">Manage Blog</span>
                    </a>
                    
                    <a href="<?php echo url('shop'); ?>" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-eye text-gray-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-900">View Site</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Recent Activity</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                        <span>Admin dashboard is now active</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span>System is running normally</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-clock text-yellow-500 mr-3"></i>
                        <span>Last updated: <?php echo date('M j, Y g:i A'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 