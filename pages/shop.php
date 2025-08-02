<?php
$page_title = 'Shop';
$page_description = 'Browse our complete collection of premium herbal tea blends.';

// Get filter parameters
$category = isset($_GET['category']) ? sanitizeInput($_GET['category']) : null;
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : null;
$sort = isset($_GET['sort']) ? sanitizeInput($_GET['sort']) : 'newest';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Get products with filters
$products = getProducts(ITEMS_PER_PAGE, ($page - 1) * ITEMS_PER_PAGE, $category, $search);

// Get total count for pagination
$totalProducts = count($products); // Simplified for now

$pagination = paginate($totalProducts, ITEMS_PER_PAGE, $page);

// Get categories for filter
$categories = getCategories();

ob_start();
?>

<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Shop Our Products</h1>
            <p class="text-gray-600">Discover our premium herbal tea blends crafted for health and wellness.</p>
        </div>

        <!-- Filters and Search -->
        <div class="mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search ?? ''); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                           placeholder="Search products...">
                </div>
                
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" id="category" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['category']); ?>" 
                                    <?php echo ($category === $cat['category']) ? 'selected' : ''; ?>>
                                <?php echo ucfirst(htmlspecialchars($cat['category'])); ?> (<?php echo $cat['count']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select name="sort" id="sort" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <option value="newest" <?php echo ($sort === 'newest') ? 'selected' : ''; ?>>Newest First</option>
                        <option value="oldest" <?php echo ($sort === 'oldest') ? 'selected' : ''; ?>>Oldest First</option>
                        <option value="price_low" <?php echo ($sort === 'price_low') ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo ($sort === 'price_high') ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="name" <?php echo ($sort === 'name') ? 'selected' : ''; ?>>Name: A to Z</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Summary -->
        <div class="mb-6">
            <p class="text-gray-600">
                Showing <?php echo count($products); ?> of <?php echo $totalProducts; ?> products
                <?php if ($search): ?>
                    for "<strong><?php echo htmlspecialchars($search); ?></strong>"
                <?php endif; ?>
                <?php if ($category): ?>
                    in <strong><?php echo ucfirst(htmlspecialchars($category)); ?></strong>
                <?php endif; ?>
            </p>
        </div>

        <!-- Products Grid -->
        <?php if (empty($products)): ?>
            <div class="text-center py-12">
                <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-600 mb-4">Try adjusting your search or filter criteria.</p>
                <a href="<?php echo url('shop'); ?>" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                    View All Products
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($products as $product): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            <img src="<?php echo getProductImage($product); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="w-full h-48 object-cover">
                            
                            <?php if ($product['is_new']): ?>
                                <span class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-medium">New</span>
                            <?php endif; ?>
                            
                            <?php if ($product['is_bestseller']): ?>
                                <span class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-xs font-medium">Bestseller</span>
                            <?php endif; ?>
                            
                            <?php if ($product['original_price'] && $product['original_price'] > $product['price']): ?>
                                <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-medium">
                                    <?php echo round((($product['original_price'] - $product['price']) / $product['original_price']) * 100); ?>% OFF
                                </span>
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
                            
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <span class="text-lg font-bold text-green-600"><?php echo formatPrice($product['price']); ?></span>
                                    <?php if ($product['original_price'] && $product['original_price'] > $product['price']): ?>
                                        <span class="text-sm text-gray-500 line-through ml-2"><?php echo formatPrice($product['original_price']); ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?php echo $i <= $product['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?> text-sm"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="text-sm text-gray-600 ml-1">(<?php echo $product['reviews_count']; ?>)</span>
                                </div>
                            </div>
                            
                            <button onclick="addToCart(<?php echo $product['id']; ?>)" 
                                    class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors">
                                <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($pagination['total_pages'] > 1): ?>
                <div class="mt-8 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <?php if ($pagination['has_prev']): ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $pagination['prev_page']])); ?>" 
                               class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Previous
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                            <?php if ($i == $pagination['current_page']): ?>
                                <span class="px-3 py-2 bg-green-600 text-white rounded-md text-sm font-medium">
                                    <?php echo $i; ?>
                                </span>
                            <?php else: ?>
                                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" 
                                   class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <?php echo $i; ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($pagination['has_next']): ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $pagination['next_page']])); ?>" 
                               class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Next
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 