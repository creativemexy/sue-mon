<?php
$page_title = 'Shipping Information';
$page_description = 'Learn about our shipping options, costs, and delivery times.';

ob_start();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Shipping Information</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    Fast, reliable shipping to get your herbal tea blends delivered right to your doorstep.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="space-y-12">
            <!-- Shipping Options -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Shipping Options</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <i class="fas fa-truck text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Standard Shipping</h3>
                                <p class="text-green-600 font-semibold">₦500</p>
                            </div>
                        </div>
                        <ul class="text-gray-600 space-y-2">
                            <li>• 3-5 business days</li>
                            <li>• Tracking included</li>
                            <li>• Nationwide delivery</li>
                            <li>• Signature required</li>
                        </ul>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <i class="fas fa-rocket text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Express Shipping</h3>
                                <p class="text-green-600 font-semibold">₦1,000</p>
                            </div>
                        </div>
                        <ul class="text-gray-600 space-y-2">
                            <li>• 1-2 business days</li>
                            <li>• Priority handling</li>
                            <li>• Real-time tracking</li>
                            <li>• Insurance included</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Free Shipping -->
            <div class="bg-green-50 p-8 rounded-lg">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Free Shipping</h2>
                <p class="text-lg text-gray-600 mb-4">Get free standard shipping on orders over ₦10,000</p>
                <div class="flex items-center space-x-4">
                    <div class="bg-green-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                        ₦10,000+
                    </div>
                    <span class="text-gray-600">= Free Standard Shipping</span>
                </div>
            </div>

            <!-- Delivery Areas -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Delivery Areas</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Currently Serving</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Lagos</li>
                            <li>• Abuja</li>
                            <li>• Port Harcourt</li>
                            <li>• Kano</li>
                            <li>• Ibadan</li>
                            <li>• Kaduna</li>
                            <li>• And more cities...</li>
                        </ul>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Coming Soon</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• International shipping</li>
                            <li>• Same-day delivery</li>
                            <li>• Pickup locations</li>
                            <li>• Subscription delivery</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Order Tracking -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Track Your Order</h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p class="text-gray-600 mb-4">Once your order ships, you'll receive a tracking number via email. You can also track your order in your account dashboard.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo url('track'); ?>" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition-colors text-center">
                            Track Order
                        </a>
                        <a href="<?php echo url('auth/login'); ?>" class="bg-gray-600 text-white px-6 py-3 rounded-md hover:bg-gray-700 transition-colors text-center">
                            View Account
                        </a>
                    </div>
                </div>
            </div>

            <!-- Delivery Information -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Delivery Information</h2>
                <div class="space-y-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Delivery Hours</h3>
                        <p class="text-gray-600">We deliver Monday through Friday, 9:00 AM to 6:00 PM. Weekend deliveries are available in select areas.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Signature Required</h3>
                        <p class="text-gray-600">All orders require a signature upon delivery to ensure your package reaches you safely.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Failed Deliveries</h3>
                        <p class="text-gray-600">If delivery fails, we'll attempt redelivery the next business day. After 3 attempts, the package will be returned to us.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">When will my order ship?</h3>
                        <p class="text-gray-600">Orders placed before 2:00 PM are typically shipped the same day. Orders placed after 2:00 PM will ship the next business day.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I change my delivery address?</h3>
                        <p class="text-gray-600">You can change your delivery address within 2 hours of placing your order. Contact our customer service team for assistance.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">What if I'm not home for delivery?</h3>
                        <p class="text-gray-600">If you're not home, the delivery person will leave a notice with instructions for pickup or redelivery.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you ship to PO boxes?</h3>
                        <p class="text-gray-600">Currently, we do not ship to PO boxes. We require a physical address for delivery.</p>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="bg-green-50 p-8 rounded-lg text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Need Help?</h3>
                <p class="text-gray-600 mb-6">If you have questions about shipping or delivery, our customer service team is here to help.</p>
                <a href="<?php echo url('contact'); ?>" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 