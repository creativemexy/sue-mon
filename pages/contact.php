<?php
// Initialize required variables if accessed directly
if (!isset($auth)) {
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../config/supabase_client.php';
    require_once __DIR__ . '/../includes/auth.php';
    require_once __DIR__ . '/../includes/functions.php';
    
    $supabase = new SupabaseClient();
    $auth = new Auth();
}

$page_title = 'Contact Us';
$page_description = 'Get in touch with Sue & Mon for questions, support, or wholesale inquiries.';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $_SESSION['error_message'] = 'Invalid request. Please try again.';
    } else {
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $subject = sanitizeInput($_POST['subject']);
        $message = sanitizeInput($_POST['message']);
        
        // Basic validation
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            $_SESSION['error_message'] = 'All fields are required.';
        } elseif (!validateEmail($email)) {
            $_SESSION['error_message'] = 'Please enter a valid email address.';
        } else {
            // Store contact message in database
            try {
                $contact_data = [
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message,
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => 'new'
                ];
                
                $result = $supabase->insert('contact_messages', $contact_data);
                
                if ($result) {
                    $_SESSION['flash_message'] = 'Thank you for your message! We will get back to you soon.';
                } else {
                    $_SESSION['error_message'] = 'Sorry, there was an error sending your message. Please try again.';
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Sorry, there was an error sending your message. Please try again.';
            }
        }
    }
}

ob_start();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Contact Us</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                
                <form method="POST" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="name" id="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="Enter your full name">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" name="email" id="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="Enter your email address">
                        </div>
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                        <select name="subject" id="subject" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select a subject</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Product Questions">Product Questions</option>
                            <option value="Order Support">Order Support</option>
                            <option value="Wholesale Inquiry">Wholesale Inquiry</option>
                            <option value="Partnership">Partnership</option>
                            <option value="Feedback">Feedback</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                        <textarea name="message" id="message" rows="6" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                  placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    
                    <div>
                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-3 px-6 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 font-medium">
                            <i class="fas fa-paper-plane mr-2"></i>Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                    <p class="text-gray-600 mb-8">
                        We're here to help and answer any questions you might have. We look forward to hearing from you.
                    </p>
                </div>

                <!-- Contact Details -->
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-envelope text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                            <p class="text-gray-600">contact@sueandmon.com</p>
                            <p class="text-sm text-gray-500">We'll respond within 24 hours</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-phone text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Phone</h3>
                            <p class="text-gray-600">+234 123 456 7890</p>
                            <p class="text-sm text-gray-500">Monday - Friday, 9AM - 6PM</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-map-marker-alt text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Address</h3>
                            <p class="text-gray-600">
                                123 Wellness Street<br>
                                Lagos, Nigeria<br>
                                100001
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-clock text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Business Hours</h3>
                            <p class="text-gray-600">
                                Monday - Friday: 9:00 AM - 6:00 PM<br>
                                Saturday: 10:00 AM - 4:00 PM<br>
                                Sunday: Closed
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div>
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
        </div>

        <!-- FAQ Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Frequently Asked Questions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">How long does shipping take?</h3>
                    <p class="text-gray-600">Standard shipping takes 3-5 business days. Express shipping is available for 1-2 business days.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you ship internationally?</h3>
                    <p class="text-gray-600">Currently, we ship within Nigeria. International shipping will be available soon.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Are your products organic?</h3>
                    <p class="text-gray-600">Yes, all our herbal tea blends are made with certified organic ingredients.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What is your return policy?</h3>
                    <p class="text-gray-600">We offer a 30-day return policy for unused products in original packaging.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 