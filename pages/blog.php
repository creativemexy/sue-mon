<?php
$page_title = 'Blog';
$page_description = 'Read our latest articles about herbal tea benefits, wellness tips, and healthy living.';

// Get blog posts with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$posts = getBlogPosts(6, ($page - 1) * 6);

// Get total count for pagination
$totalPosts = $db->count('blog_posts', 'published = 1');
$pagination = paginate($totalPosts, 6, $page);

ob_start();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Our Blog</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    Discover the latest insights on herbal tea benefits, wellness tips, and healthy living practices.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Featured Post -->
        <?php if (!empty($posts)): ?>
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Featured Article</h2>
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="relative">
                            <img src="<?php echo asset($posts[0]['featured_image'] ?: 'images/blog-placeholder.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($posts[0]['title']); ?>" 
                                 class="w-full h-64 lg:h-full object-cover">
                        </div>
                        <div class="p-8">
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-calendar mr-2"></i>
                                <?php echo formatDate($posts[0]['created_at']); ?>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">
                                <a href="<?php echo url('blog/' . $posts[0]['slug']); ?>" class="hover:text-green-600 transition-colors">
                                    <?php echo htmlspecialchars($posts[0]['title']); ?>
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-6">
                                <?php echo htmlspecialchars($posts[0]['excerpt']); ?>
                            </p>
                            <a href="<?php echo url('blog/' . $posts[0]['slug']); ?>" 
                               class="inline-flex items-center text-green-600 hover:text-green-700 font-medium">
                                Read More
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Blog Posts Grid -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Latest Articles</h2>
            
            <?php if (empty($posts)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-newspaper text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No blog posts yet</h3>
                    <p class="text-gray-600">Check back soon for our latest articles and wellness tips.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach (array_slice($posts, 1) as $post): ?>
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative">
                                <img src="<?php echo asset($post['featured_image'] ?: 'images/blog-placeholder.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($post['title']); ?>" 
                                     class="w-full h-48 object-cover">
                            </div>
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <?php echo formatDate($post['created_at']); ?>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                    <a href="<?php echo url('blog/' . $post['slug']); ?>" class="hover:text-green-600 transition-colors">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    <?php echo htmlspecialchars(substr($post['excerpt'], 0, 120)); ?>...
                                </p>
                                <a href="<?php echo url('blog/' . $post['slug']); ?>" 
                                   class="inline-flex items-center text-green-600 hover:text-green-700 font-medium text-sm">
                                    Read More
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($pagination['total_pages'] > 1): ?>
            <div class="flex justify-center">
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

        <!-- Newsletter Signup -->
        <div class="mt-16 bg-green-50 rounded-lg p-8">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Stay Updated</h3>
                <p class="text-gray-600 mb-6">
                    Subscribe to our newsletter to get the latest wellness tips and herbal tea insights delivered to your inbox.
                </p>
                <form action="<?php echo url('newsletter/subscribe'); ?>" method="POST" class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                    <input type="email" name="email" placeholder="Enter your email" required
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition-colors font-medium">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 