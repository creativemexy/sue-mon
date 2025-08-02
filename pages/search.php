<?php
$page_title = 'Search Results';
$page_description = 'Search results for our herbal tea products.';

$query = isset($_GET['q']) ? sanitizeInput($_GET['q']) : '';
$products = [];

if ($query) {
    $products = searchProducts($query);
}

ob_start();
?>

<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Search Results</h1>
        
        <?php if ($query): ?>
            <p class="text-gray-600 mb-8">Results for "<strong><?php echo htmlspecialchars($query); ?></strong>"</p>
            
            <?php if (!empty($products)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($products as $product): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative">
                                <img src="<?php echo getProductImage($product); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                     class="w-full h-48 object-cover">
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
                    <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-600 mb-4">Try adjusting your search terms or browse our categories.</p>
                    <a href="<?php echo url('shop'); ?>" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                        Browse All Products
                    </a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Enter a search term</h3>
                <p class="text-gray-600 mb-4">Use the search bar above to find products.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 