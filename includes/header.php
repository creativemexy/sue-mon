<header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="<?php echo url(); ?>" class="flex items-center space-x-3 group">
                    <div class="bg-gradient-to-r from-green-600 to-green-800 p-2 rounded-lg shadow-lg group-hover:shadow-xl transition-all duration-200">
                        <img src="<?php echo asset('logo.svg'); ?>" alt="<?php echo SITE_NAME; ?> Logo" class="w-6 h-6 object-contain">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900"><?php echo SITE_NAME; ?></h1>
                        <p class="text-xs text-gray-600"><?php echo SITE_DESCRIPTION; ?></p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="<?php echo url('shop'); ?>" class="text-gray-700 hover:text-green-600 transition-colors font-medium text-sm">Shop</a>
                <a href="<?php echo url('categories'); ?>" class="text-gray-700 hover:text-green-600 transition-colors font-medium text-sm">Tea Types</a>
                <a href="<?php echo url('benefits'); ?>" class="text-gray-700 hover:text-green-600 transition-colors font-medium text-sm">Health Benefits</a>
                <a href="<?php echo url('subscription'); ?>" class="text-gray-700 hover:text-green-600 transition-colors font-medium text-sm">Subscription</a>
                <a href="<?php echo url('blog'); ?>" class="text-gray-700 hover:text-green-600 transition-colors font-medium text-sm">Blog</a>
                <a href="<?php echo url('about'); ?>" class="text-gray-700 hover:text-green-600 transition-colors font-medium text-sm">About</a>
            </nav>

            <!-- Search and Actions -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <button onclick="openSearchModal()" class="hidden sm:flex items-center justify-center w-10 h-10 text-gray-600 hover:text-green-600 transition-colors">
                    <i class="fas fa-search"></i>
                </button>

                <!-- Wishlist -->
                <a href="<?php echo url('wishlist'); ?>" class="hidden sm:flex items-center justify-center w-10 h-10 text-gray-600 hover:text-green-600 transition-colors">
                    <i class="fas fa-heart"></i>
                </a>

                <!-- Account -->
                <?php if ($auth->isLoggedIn()): ?>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-green-600 transition-colors">
                            <i class="fas fa-user"></i>
                            <span class="hidden sm:block text-sm font-medium"><?php echo $_SESSION['user_name']; ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <?php if ($auth->isAdmin()): ?>
                                <a href="<?php echo url('admin'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Admin Dashboard
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo url('profile'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="<?php echo url('orders'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-shopping-bag mr-2"></i>My Orders
                            </a>
                            <hr class="my-1">
                            <a href="<?php echo url('auth/logout'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo url('auth/login'); ?>" class="hidden sm:flex items-center space-x-2 text-gray-700 hover:text-green-600 transition-colors">
                        <i class="fas fa-user"></i>
                        <span class="text-sm font-medium">Login</span>
                    </a>
                <?php endif; ?>

                <!-- Cart -->
                <button onclick="openCartSidebar()" class="relative flex items-center justify-center w-10 h-10 text-gray-600 hover:text-green-600 transition-colors">
                    <i class="fas fa-shopping-cart"></i>
                    <?php $cartCount = getCartCount(); ?>
                    <?php if ($cartCount > 0): ?>
                        <span class="absolute -top-1 -right-1 bg-green-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            <?php echo $cartCount; ?>
                        </span>
                    <?php endif; ?>
                </button>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden flex items-center justify-center w-10 h-10 text-gray-600 hover:text-green-600 transition-colors">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="<?php echo url('shop'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md">Shop</a>
                <a href="<?php echo url('categories'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md">Tea Types</a>
                <a href="<?php echo url('benefits'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md">Health Benefits</a>
                <a href="<?php echo url('subscription'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md">Subscription</a>
                <a href="<?php echo url('blog'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md">Blog</a>
                <a href="<?php echo url('about'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md">About</a>
                
                <?php if (!$auth->isLoggedIn()): ?>
                    <hr class="my-2">
                    <a href="<?php echo url('auth/login'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-user mr-2"></i>Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}

function openSearchModal() {
    // This will be handled by the search modal component
    const searchModal = document.getElementById('search-modal');
    if (searchModal) {
        searchModal.classList.remove('hidden');
    }
}

function openCartSidebar() {
    // This will be handled by the cart sidebar component
    const cartSidebar = document.getElementById('cart-sidebar');
    if (cartSidebar) {
        cartSidebar.classList.remove('hidden');
    }
}
</script> 