<?php
$page_title = 'Health Benefits';
$page_description = 'Discover the amazing health benefits of our herbal tea blends and wellness products.';

ob_start();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Health Benefits</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    Discover the incredible health benefits of our premium herbal tea blends, crafted to support your wellness journey.
                </p>
            </div>
        </div>
    </div>

    <!-- Benefits Overview -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Herbal Teas?</h2>
                <p class="text-xl text-gray-600">Our herbal teas offer a natural way to support your health and wellness goals.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">100% Natural</h3>
                    <p class="text-gray-600">Made with pure, organic ingredients without artificial additives or preservatives.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Health Supporting</h3>
                    <p class="text-gray-600">Each blend is formulated to provide specific health benefits and wellness support.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Traditional Wisdom</h3>
                    <p class="text-gray-600">Based on centuries of traditional herbal medicine and modern scientific research.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Specific Benefits -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Specific Health Benefits</h2>
                <p class="text-xl text-gray-600">Explore the targeted benefits of our different herbal tea categories.</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Immunity Support -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <i class="fas fa-shield-alt text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Immunity Support</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Strengthen your immune system with our specially formulated blends containing powerful antioxidants and immune-boosting herbs.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Rich in vitamin C and antioxidants
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Natural anti-inflammatory properties
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Supports overall immune function
                        </li>
                    </ul>
                </div>
                
                <!-- Energy & Vitality -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <i class="fas fa-bolt text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Energy & Vitality</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Boost your energy levels naturally with our energizing herbal blends that provide sustained vitality without jitters.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Natural energy boosters
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Improved mental clarity
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Enhanced physical endurance
                        </li>
                    </ul>
                </div>
                
                <!-- Relaxation & Sleep -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <i class="fas fa-moon text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Relaxation & Sleep</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Unwind and prepare for restful sleep with our calming herbal blends designed to promote relaxation and better sleep quality.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Natural stress relief
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Improved sleep quality
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Calming and soothing effects
                        </li>
                    </ul>
                </div>
                
                <!-- Digestive Health -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <i class="fas fa-stomach text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Digestive Health</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Support your digestive system with our gentle herbal blends that promote healthy digestion and gut wellness.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Improved digestion
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Natural bloating relief
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            Gut health support
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Use -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">How to Maximize Benefits</h2>
                <p class="text-xl text-gray-600">Get the most out of your herbal tea experience with these tips.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">1</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Choose the Right Time</h3>
                    <p class="text-gray-600 text-sm">Drink energizing teas in the morning and calming blends in the evening.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">2</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Proper Brewing</h3>
                    <p class="text-gray-600 text-sm">Use hot water (80-90°C) and steep for 5-7 minutes for optimal benefits.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">3</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Consistency is Key</h3>
                    <p class="text-gray-600 text-sm">Drink regularly to experience the full benefits of herbal teas.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">4</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Listen to Your Body</h3>
                    <p class="text-gray-600 text-sm">Pay attention to how different blends affect you and adjust accordingly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-green-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Start Your Wellness Journey</h2>
            <p class="text-xl mb-8 text-green-100">
                Experience the amazing health benefits of our premium herbal tea blends today.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo url('shop'); ?>" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Shop Our Products
                </a>
                <a href="<?php echo url('categories'); ?>" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-colors">
                    Explore Categories
                </a>
            </div>
        </div>
    </section>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 