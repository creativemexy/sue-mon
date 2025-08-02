<?php
$page_title = 'About Us';
$page_description = 'Learn about Sue & Mon and our mission to provide premium herbal tea blends.';

ob_start();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">About Sue & Mon</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    We are passionate about bringing you the finest herbal tea blends, crafted with care and tradition for your health and wellness.
                </p>
            </div>
        </div>
    </div>

    <!-- Our Story -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Founded with a deep appreciation for traditional herbal medicine and modern wellness practices, 
                        Sue & Mon began as a small family business with a big vision: to make premium herbal tea blends 
                        accessible to everyone.
                    </p>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Our journey started in the heart of Nigeria, where we discovered the incredible healing properties 
                        of local herbs and spices. We combined this traditional knowledge with modern research to create 
                        blends that not only taste amazing but also support your health and wellness goals.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Today, we're proud to serve customers across the country, offering carefully curated herbal tea 
                        blends that promote immunity, relaxation, energy, and overall well-being.
                    </p>
                </div>
                <div>
                                            <img src="<?php echo asset('images/hero-tea-image.jpg'); ?>" alt="Our Story" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Our Mission -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    To provide premium, natural herbal tea blends that enhance your health, wellness, and daily rituals.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Natural Ingredients</h3>
                    <p class="text-gray-600">We source only the finest, organic ingredients from trusted suppliers to ensure the highest quality in every blend.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Health Focused</h3>
                    <p class="text-gray-600">Every blend is carefully formulated to provide specific health benefits, from immunity support to relaxation.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Community Driven</h3>
                    <p class="text-gray-600">We believe in building a community of wellness enthusiasts who share our passion for natural health solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Values</h2>
                <p class="text-xl text-gray-600">The principles that guide everything we do</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-green-600">Quality First</h3>
                    <p class="text-gray-600">We never compromise on quality. Every ingredient is carefully selected and tested to meet our high standards.</p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-green-600">Sustainability</h3>
                    <p class="text-gray-600">We're committed to sustainable practices, from sourcing to packaging, to protect our planet for future generations.</p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-green-600">Transparency</h3>
                    <p class="text-gray-600">We believe in complete transparency about our ingredients, processes, and the benefits of our products.</p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-green-600">Customer Care</h3>
                    <p class="text-gray-600">Your satisfaction and health are our top priorities. We're here to support your wellness journey every step of the way.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
                <p class="text-xl text-gray-600">The passionate people behind Sue & Mon</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-32 h-32 rounded-full bg-gray-300 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-gray-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Sue</h3>
                    <p class="text-gray-600">Co-founder & Herbal Expert</p>
                    <p class="text-sm text-gray-500 mt-2">Passionate about traditional herbal medicine and creating blends that truly work.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-32 h-32 rounded-full bg-gray-300 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-gray-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Mon</h3>
                    <p class="text-gray-600">Co-founder & Wellness Advocate</p>
                    <p class="text-sm text-gray-500 mt-2">Dedicated to helping people achieve optimal health through natural solutions.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-32 h-32 rounded-full bg-gray-300 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-users text-4xl text-gray-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Our Team</h3>
                    <p class="text-gray-600">Customer Care & Operations</p>
                    <p class="text-sm text-gray-500 mt-2">Committed to providing exceptional service and supporting your wellness journey.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-green-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Join Our Wellness Community</h2>
            <p class="text-xl mb-8 text-green-100">
                Discover the power of premium herbal tea blends and start your journey to better health today.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo url('shop'); ?>" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Shop Our Products
                </a>
                <a href="<?php echo url('contact'); ?>" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-colors">
                    Get in Touch
                </a>
            </div>
        </div>
    </section>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 