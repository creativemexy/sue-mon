<?php
$page_title = 'Customer Support';
$page_description = 'Get help and support for your orders and products.';

ob_start();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Customer Support</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    We're here to help you with any questions or concerns about our products and services.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Get in Touch</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-envelope text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Email Support</h3>
                            <p class="text-gray-600">support@sueandmon.com</p>
                            <p class="text-sm text-gray-500">Response within 24 hours</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-phone text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Phone Support</h3>
                            <p class="text-gray-600">+234 123 456 7890</p>
                            <p class="text-sm text-gray-500">Monday - Friday, 9AM - 6PM</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-comments text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Live Chat</h3>
                            <p class="text-gray-600">Available on our website</p>
                            <p class="text-sm text-gray-500">Real-time assistance</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-map-marker-alt text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Visit Us</h3>
                            <p class="text-gray-600">123 Wellness Street<br>Lagos, Nigeria</p>
                            <p class="text-sm text-gray-500">By appointment only</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-green-600 text-white p-3 rounded-full hover:bg-green-700 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-green-600 text-white p-3 rounded-full hover:bg-green-700 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-green-600 text-white p-3 rounded-full hover:bg-green-700 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-green-600 text-white p-3 rounded-full hover:bg-green-700 transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Support Form -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Send us a Message</h2>
                
                <form method="POST" action="<?php echo url('contact'); ?>" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" name="name" id="name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input type="email" name="email" id="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                        <select name="subject" id="subject" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select a subject</option>
                            <option value="Order Support">Order Support</option>
                            <option value="Product Questions">Product Questions</option>
                            <option value="Shipping Issues">Shipping Issues</option>
                            <option value="Returns & Refunds">Returns & Refunds</option>
                            <option value="Technical Support">Technical Support</option>
                            <option value="General Inquiry">General Inquiry</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                        <textarea name="message" id="message" rows="6" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                  placeholder="Please describe your issue or question..."></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-3 px-6 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 font-medium">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Common Questions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">How do I track my order?</h3>
                    <p class="text-gray-600">You can track your order by logging into your account or using the tracking number sent to your email.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What is your return policy?</h3>
                    <p class="text-gray-600">We accept returns within 30 days for unused products in original packaging.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">How long does shipping take?</h3>
                    <p class="text-gray-600">Standard shipping takes 3-5 business days. Express shipping is 1-2 business days.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you ship internationally?</h3>
                    <p class="text-gray-600">Currently, we ship within Nigeria. International shipping will be available soon.</p>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <a href="<?php echo url('faq'); ?>" class="text-green-600 hover:text-green-700 font-medium">
                    View All FAQ →
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 