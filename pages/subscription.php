<?php
$page_title = 'Tea Subscription';
$page_description = 'Subscribe to our premium herbal tea subscription service and never run out of your favorite blends.';

ob_start();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Tea Subscription</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    Never run out of your favorite herbal teas with our convenient subscription service. Save money and enjoy fresh tea delivered to your door.
                </p>
            </div>
        </div>
    </div>

    <!-- Subscription Plans -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Choose Your Subscription Plan</h2>
                <p class="text-xl text-gray-600">Select the perfect plan for your tea consumption needs.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Basic Plan -->
                <div class="bg-white rounded-lg shadow-md border-2 border-gray-200 p-8">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Basic</h3>
                        <div class="text-4xl font-bold text-green-600 mb-2">₦5,000</div>
                        <p class="text-gray-600">per month</p>
                    </div>
                    
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            2 tea blends per month
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Free shipping
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Flexible delivery schedule
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Cancel anytime
                        </li>
                    </ul>
                    
                    <button class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        Choose Basic
                    </button>
                </div>
                
                <!-- Premium Plan -->
                <div class="bg-white rounded-lg shadow-lg border-2 border-green-500 p-8 relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-green-500 text-white px-4 py-1 rounded-full text-sm font-medium">Most Popular</span>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Premium</h3>
                        <div class="text-4xl font-bold text-green-600 mb-2">₦8,000</div>
                        <p class="text-gray-600">per month</p>
                    </div>
                    
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            4 tea blends per month
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Free shipping
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Priority customer support
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Exclusive blends
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Tea brewing guide
                        </li>
                    </ul>
                    
                    <button class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        Choose Premium
                    </button>
                </div>
                
                <!-- Ultimate Plan -->
                <div class="bg-white rounded-lg shadow-md border-2 border-gray-200 p-8">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Ultimate</h3>
                        <div class="text-4xl font-bold text-green-600 mb-2">₦12,000</div>
                        <p class="text-gray-600">per month</p>
                    </div>
                    
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            6 tea blends per month
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Free shipping
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            VIP customer support
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Limited edition blends
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Wellness consultation
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-3"></i>
                            Early access to new products
                        </li>
                    </ul>
                    
                    <button class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        Choose Ultimate
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-xl text-gray-600">Getting started with your tea subscription is simple and convenient.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">1</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Choose Your Plan</h3>
                    <p class="text-gray-600">Select the subscription plan that best fits your tea consumption needs.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">2</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Customize Your Box</h3>
                    <p class="text-gray-600">Pick your favorite tea blends or let us surprise you with our curated selections.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">3</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Receive Monthly Delivery</h3>
                    <p class="text-gray-600">Get your fresh tea blends delivered to your door every month.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">4</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Enjoy & Repeat</h3>
                    <p class="text-gray-600">Sip, relax, and look forward to your next tea delivery.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Subscribe?</h2>
                <p class="text-xl text-gray-600">Discover the benefits of our tea subscription service.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Convenient Delivery</h3>
                    <p class="text-gray-600">Never run out of your favorite teas with automatic monthly deliveries.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-percentage text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Save Money</h3>
                    <p class="text-gray-600">Enjoy discounted prices and free shipping on all subscription orders.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Discover New Blends</h3>
                    <p class="text-gray-600">Try new and exclusive tea blends that are only available to subscribers.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Flexible Schedule</h3>
                    <p class="text-gray-600">Pause, skip, or cancel your subscription anytime with no commitment.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Health Benefits</h3>
                    <p class="text-gray-600">Support your wellness journey with carefully selected herbal tea blends.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Premium Quality</h3>
                    <p class="text-gray-600">Receive only the highest quality, organic tea blends in every delivery.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Everything you need to know about our subscription service.</p>
            </div>
            
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I cancel my subscription anytime?</h3>
                    <p class="text-gray-600">Yes, you can cancel, pause, or modify your subscription at any time with no penalties.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">How often will I receive deliveries?</h3>
                    <p class="text-gray-600">Deliveries are made monthly, but you can adjust the frequency to bi-weekly or quarterly.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I choose which teas I receive?</h3>
                    <p class="text-gray-600">Absolutely! You can select specific blends or let us curate a selection for you.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is shipping included?</h3>
                    <p class="text-gray-600">Yes, all subscription plans include free shipping to anywhere in Nigeria.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-green-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Start Your Tea Journey Today</h2>
            <p class="text-xl mb-8 text-green-100">
                Join thousands of tea lovers who enjoy fresh, premium herbal teas delivered to their door every month.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#subscription-plans" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Choose Your Plan
                </a>
                <a href="<?php echo url('contact'); ?>" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </section>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 