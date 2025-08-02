<?php
$page_title = 'Tea Categories';
$page_description = 'Explore our different categories of herbal teas and wellness products.';

// Get categories and products
$categories = getCategories();
$selectedCategory = isset($_GET['category']) ? sanitizeInput($_GET['category']) : null;

if ($selectedCategory) {
    $products = getProductsByCategory($selectedCategory);
    $page_title = ucfirst($selectedCategory) . ' Products';
    $page_description = 'Browse our ' . $selectedCategory . ' collection.';
}

ob_start();
?>

<div class="bg-white">
    <?php if ($selectedCategory): ?>
        <!-- Category Products -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="<?php echo url(); ?>" class="text-gray-700 hover:text-green-600">
                            <i class="fas fa-home mr-2"></i>Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="<?php echo url('categories'); ?>" class="text-gray-700 hover:text-green-600">Categories</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-500"><?php echo ucfirst($selectedCategory); ?></span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Category Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4"><?php echo ucfirst($selectedCategory); ?> Products</h1>
                <p class="text-xl text-gray-600">Discover our premium <?php echo $selectedCategory; ?> collection</p>
            </div>

            <!-- Products Grid -->
            <?php if (!empty($products)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($products as $product): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative">
                                <img src="<?php echo getProductImage($product); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                     class="w-full h-48 object-cover">
                                
                                <?php if (strtotime($product['created_at']) > strtotime('-7 days')): ?>
                                    <span class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-medium">New</span>
                                <?php endif; ?>
                                
                                <?php if ($product['featured']): ?>
                                    <span class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-xs font-medium">Featured</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    <a href="<?php echo url('product') . '?id=' . $product['id']; ?>" 
                                       class="hover:text-green-600 transition-colors">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </a>
                                </h3>
                                
                                <p class="text-gray-600 text-sm mb-3">
                                    <?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>...
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-green-600"><?php echo formatPrice($product['price']); ?></span>
                                    <button onclick="addToCart('<?php echo $product['id']; ?>')" 
                                            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <i class="fas fa-leaf text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-600 mb-4">We're working on adding more <?php echo $selectedCategory; ?> products.</p>
                    <a href="<?php echo url('categories'); ?>" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                        View All Categories
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <!-- All Categories -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Tea Categories</h1>
                <p class="text-xl text-gray-600">Explore our diverse range of herbal tea categories, each designed for specific health benefits.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($categories as $category): ?>
                    <a href="<?php echo url('categories') . '?category=' . urlencode($category['category']); ?>" 
                       class="group block bg-gray-50 rounded-lg p-8 text-center hover:bg-green-50 transition-colors">
                        <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-200 transition-colors">
                            <i class="fas fa-leaf text-3xl text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-3"><?php echo ucfirst($category['category']); ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo $category['count']; ?> products available</p>
                        <div class="text-green-600 font-medium group-hover:text-green-700">
                            Explore Category <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <!-- Category Benefits -->
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Why Choose Our Categories?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-heart text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Health Focused</h3>
                        <p class="text-gray-600">Each category is designed to target specific health benefits and wellness goals.</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-leaf text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Natural Ingredients</h3>
                        <p class="text-gray-600">All our products are made with premium, organic ingredients for maximum benefits.</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-star text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Quality Assured</h3>
                        <p class="text-gray-600">Every product undergoes rigorous quality testing to ensure the highest standards.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 