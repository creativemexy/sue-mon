<?php
$page_title = 'Home';
$page_description = 'Discover our premium herbal tea blends for health, wellness, and relaxation.';

// Get featured products
$featuredProducts = getFeaturedProducts(6);
$newProducts = getNewProducts(6);
$categories = getCategories();

ob_start();
?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Premium Herbal Blends for 
                    <span class="text-yellow-300">Health & Wellness</span>
                </h1>
                <p class="text-xl mb-8 text-green-100">
                    Discover our carefully curated collection of herbal teas, crafted to support your journey to better health and relaxation.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?php echo url('shop'); ?>" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors text-center">
                        Shop Now
                    </a>
                    <a href="<?php echo url('subscription'); ?>" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-colors text-center">
                        Subscribe & Save
                    </a>
                </div>
            </div>
            <div class="hidden lg:block">
                <img src="<?php echo asset('images/hero-tea-image.jpg'); ?>" alt="Premium Herbal Tea" class="rounded-lg shadow-2xl">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-leaf text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">100% Natural</h3>
                <p class="text-gray-600">All our blends are made with premium, organic ingredients sourced from trusted suppliers.</p>
            </div>
            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shipping-fast text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Fast Delivery</h3>
                <p class="text-gray-600">Free shipping on orders over ₦10,000. Same-day dispatch for orders placed before 2 PM.</p>
            </div>
            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Health Benefits</h3>
                <p class="text-gray-600">Each blend is carefully formulated to provide specific health benefits and wellness support.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Products</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Our most popular herbal blends, loved by customers for their exceptional quality and health benefits.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative">
                        <img src="<?php echo getProductImage($product); ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-cover">
                        <?php if (strtotime($product['created_at']) > strtotime('-7 days')): ?>
                            <span class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-medium">New</span>
                        <?php endif; ?>
                        <?php if ($product['featured']): ?>
                            <span class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-xs font-medium">Featured</span>
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo $product['name']; ?></h3>
                        <p class="text-gray-600 text-sm mb-4"><?php echo substr($product['description'], 0, 100); ?>...</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-green-600"><?php echo formatPrice($product['price']); ?></span>
                                <?php if (isset($product['original_price']) && $product['original_price'] && $product['original_price'] > $product['price']): ?>
                                    <span class="text-sm text-gray-500 line-through ml-2"><?php echo formatPrice($product['original_price']); ?></span>
                                <?php endif; ?>
                            </div>
                            <button onclick="addToCart(<?php echo $product['id']; ?>)" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-8">
            <a href="<?php echo url('shop'); ?>" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Shop by Category</h2>
            <p class="text-gray-600">Explore our diverse range of herbal tea categories, each designed for specific health benefits.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($categories as $category): ?>
                <a href="<?php echo url('categories'); ?>?category=<?php echo urlencode($category['category']); ?>" 
                   class="group block bg-gray-50 rounded-lg p-6 text-center hover:bg-green-50 transition-colors">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                        <i class="fas fa-leaf text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo ucfirst($category['category']); ?></h3>
                    <p class="text-gray-600 text-sm"><?php echo $category['count']; ?> products</p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- New Arrivals -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">New Arrivals</h2>
            <p class="text-gray-600">Discover our latest herbal tea blends, freshly added to our collection.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($newProducts as $product): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative">
                        <img src="<?php echo getProductImage($product); ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-cover">
                        <span class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-medium">New</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo $product['name']; ?></h3>
                        <p class="text-gray-600 text-sm mb-4"><?php echo substr($product['description'], 0, 100); ?>...</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-green-600"><?php echo formatPrice($product['price']); ?></span>
                            <button onclick="addToCart(<?php echo $product['id']; ?>)" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-green-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
        <p class="text-xl mb-8 text-green-100">Subscribe to our newsletter for exclusive offers, health tips, and new product announcements.</p>
        <form action="<?php echo url('newsletter/subscribe'); ?>" method="POST" class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            <input type="email" name="email" placeholder="Enter your email" required
                   class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
            <button type="submit" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Subscribe
            </button>
        </form>
    </div>
</section>

<script>
function addToCart(productId) {
    fetch('<?php echo url('api/cart/add'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const message = document.createElement('div');
            message.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            message.textContent = 'Product added to cart!';
            document.body.appendChild(message);
            
            setTimeout(() => {
                message.remove();
            }, 3000);
            
            // Update cart count
            location.reload();
        }
    });
}
</script>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 