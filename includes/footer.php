<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="bg-gradient-to-r from-green-600 to-green-800 p-2 rounded-lg">
                        <img src="<?php echo asset('logo.svg'); ?>" alt="<?php echo SITE_NAME; ?> Logo" class="w-6 h-6 object-contain">
                    </div>
                    <div>
                        <h3 class="text-xl font-bold"><?php echo SITE_NAME; ?></h3>
                        <p class="text-sm text-gray-400"><?php echo SITE_DESCRIPTION; ?></p>
                    </div>
                </div>
                <p class="text-gray-400 mb-4 max-w-md">
                    Discover our premium herbal tea blends crafted for health, wellness, and relaxation. 
                    Each blend is carefully selected to provide you with the finest natural ingredients.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-youtube text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="<?php echo url('shop'); ?>" class="text-gray-400 hover:text-white transition-colors">Shop</a></li>
                    <li><a href="<?php echo url('categories'); ?>" class="text-gray-400 hover:text-white transition-colors">Tea Types</a></li>
                    <li><a href="<?php echo url('benefits'); ?>" class="text-gray-400 hover:text-white transition-colors">Health Benefits</a></li>
                    <li><a href="<?php echo url('subscription'); ?>" class="text-gray-400 hover:text-white transition-colors">Subscription</a></li>
                    <li><a href="<?php echo url('blog'); ?>" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                    <li><a href="<?php echo url('about'); ?>" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Customer Service</h4>
                <ul class="space-y-2">
                    <li><a href="<?php echo url('contact'); ?>" class="text-gray-400 hover:text-white transition-colors">Contact Us</a></li>
                    <li><a href="<?php echo url('shipping'); ?>" class="text-gray-400 hover:text-white transition-colors">Shipping Info</a></li>
                    <li><a href="<?php echo url('returns'); ?>" class="text-gray-400 hover:text-white transition-colors">Returns</a></li>
                    <li><a href="<?php echo url('faq'); ?>" class="text-gray-400 hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="<?php echo url('track'); ?>" class="text-gray-400 hover:text-white transition-colors">Track Order</a></li>
                    <li><a href="<?php echo url('support'); ?>" class="text-gray-400 hover:text-white transition-colors">Support</a></li>
                </ul>
            </div>
        </div>

        <!-- Newsletter Signup -->
        <div class="mt-12 pt-8 border-t border-gray-800">
            <div class="max-w-md">
                <h4 class="text-lg font-semibold mb-2">Stay Updated</h4>
                <p class="text-gray-400 mb-4">Subscribe to our newsletter for exclusive offers and health tips.</p>
                <form action="<?php echo url('newsletter/subscribe'); ?>" method="POST" class="flex">
                    <input type="email" name="email" placeholder="Enter your email" required
                           class="flex-1 px-4 py-2 bg-gray-800 border border-gray-700 rounded-l-md focus:outline-none focus:ring-2 focus:ring-green-500 text-white placeholder-gray-400">
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 rounded-r-md transition-colors">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="mt-8 pt-8 border-t border-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                </div>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="<?php echo url('privacy'); ?>" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
                    <a href="<?php echo url('terms'); ?>" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
                    <a href="<?php echo url('sitemap'); ?>" class="text-gray-400 hover:text-white text-sm transition-colors">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer> 