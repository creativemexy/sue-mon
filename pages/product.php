<?php
$page_title = 'Product Details';
$page_description = 'View product details and add to cart.';

// Get product ID from URL
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get product details
$product = getProduct($productId);

if (!$product) {
    redirect('404');
}

$page_title = $product['name'];
$page_description = $product['description'];

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    addToCart($productId, $quantity);
    $_SESSION['flash_message'] = 'Product added to cart successfully!';
    redirect('product?id=' . $productId);
}

// Get related products
$relatedProducts = getProductsByCategory($product['category'], 4);

ob_start();
?>

<div class="bg-white">
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
                        <a href="<?php echo url('shop'); ?>" class="text-gray-700 hover:text-green-600">Shop</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="<?php echo url('categories') . '?category=' . urlencode($product['category']); ?>" 
                           class="text-gray-700 hover:text-green-600"><?php echo ucfirst($product['category']); ?></a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500"><?php echo htmlspecialchars($product['name']); ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Image -->
            <div class="space-y-4">
                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200">
                                            <img src="<?php echo getProductImage($product); ?>"  
                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                         class="h-full w-full object-cover object-center">
                </div>
                
                <!-- Product badges -->
                <div class="flex space-x-2">
                    <?php if ($product['is_new']): ?>
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">New</span>
                    <?php endif; ?>
                    
                    <?php if ($product['is_bestseller']): ?>
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-medium">Bestseller</span>
                    <?php endif; ?>
                    
                    <?php if ($product['original_price'] && $product['original_price'] > $product['price']): ?>
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                            <?php echo round((($product['original_price'] - $product['price']) / $product['original_price']) * 100); ?>% OFF
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Details -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($product['name']); ?></h1>
                    
                    <!-- Rating -->
                    <div class="flex items-center mb-4">
                        <div class="flex items-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?php echo $i <= $product['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-gray-600 ml-2"><?php echo $product['rating']; ?> out of 5</span>
                        <span class="text-gray-500 ml-2">(<?php echo $product['reviews_count']; ?> reviews)</span>
                    </div>
                    
                    <!-- Price -->
                    <div class="flex items-center mb-4">
                        <span class="text-3xl font-bold text-green-600"><?php echo formatPrice($product['price']); ?></span>
                        <?php if ($product['original_price'] && $product['original_price'] > $product['price']): ?>
                            <span class="text-xl text-gray-500 line-through ml-3"><?php echo formatPrice($product['original_price']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                    <p class="text-gray-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>

                <!-- Benefits -->
                <?php if (!empty($product['benefits'])): ?>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Health Benefits</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach (json_decode($product['benefits'], true) as $benefit): ?>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                    <?php echo htmlspecialchars($benefit); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Add to Cart Form -->
                <form method="POST" class="space-y-4">
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <button type="button" onclick="updateQuantity(-1)" 
                                        class="px-3 py-2 text-gray-600 hover:text-gray-800">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="99"
                                       class="w-16 text-center border-0 focus:ring-0 focus:outline-none">
                                <button type="button" onclick="updateQuantity(1)" 
                                        class="px-3 py-2 text-gray-600 hover:text-gray-800">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <span class="text-sm text-gray-500">In stock: <?php echo $product['stock_quantity']; ?></span>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" name="add_to_cart" 
                                class="flex-1 bg-green-600 text-white py-3 px-6 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 font-medium">
                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                        </button>
                        
                        <button type="button" onclick="addToWishlist(<?php echo $product['id']; ?>)" 
                                class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </form>

                <!-- Product Info -->
                <div class="border-t border-gray-200 pt-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo ucfirst($product['category']); ?></dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">SKU</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($product['sku']); ?></dd>
                        </div>
                        
                        <?php if ($product['weight']): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Weight</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo $product['weight']; ?>g</dd>
                            </div>
                        <?php endif; ?>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Availability</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <?php if ($product['in_stock']): ?>
                                    <span class="text-green-600">In Stock</span>
                                <?php else: ?>
                                    <span class="text-red-600">Out of Stock</span>
                                <?php endif; ?>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php if (!empty($relatedProducts)): ?>
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($relatedProducts as $related): ?>
                        <?php if ($related['id'] != $product['id']): ?>
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="relative">
                                    <img src="<?php echo getProductImage($related); ?>" 
                                         alt="<?php echo htmlspecialchars($related['name']); ?>" 
                                         class="w-full h-48 object-cover">
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="<?php echo url('product') . '?id=' . $related['id']; ?>" 
                                           class="hover:text-green-600 transition-colors">
                                            <?php echo htmlspecialchars($related['name']); ?>
                                        </a>
                                    </h3>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-green-600"><?php echo formatPrice($related['price']); ?></span>
                                        <button onclick="addToCart(<?php echo $related['id']; ?>)" 
                                                class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function updateQuantity(change) {
    const quantityInput = document.getElementById('quantity');
    let newQuantity = parseInt(quantityInput.value) + change;
    newQuantity = Math.max(1, Math.min(99, newQuantity));
    quantityInput.value = newQuantity;
}

function addToWishlist(productId) {
    // Implement wishlist functionality
    console.log('Add to wishlist:', productId);
}
</script>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 