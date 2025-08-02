<?php
$page_title = 'Returns & Refunds';
$page_description = 'Information about our return and refund policy.';

ob_start();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Returns & Refunds</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    We want you to be completely satisfied with your purchase. Learn about our return and refund policy.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="space-y-12">
            <!-- Return Policy -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Return Policy</h2>
                <div class="bg-green-50 p-6 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">30-Day Return Window</h3>
                    <p class="text-gray-600">We accept returns within 30 days of delivery for unused products in their original packaging.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">What Can Be Returned</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Unused products in original packaging</li>
                            <li>• Products with manufacturing defects</li>
                            <li>• Wrong items received</li>
                            <li>• Damaged items during shipping</li>
                        </ul>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">What Cannot Be Returned</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Used or opened products</li>
                            <li>• Products without original packaging</li>
                            <li>• Perishable items</li>
                            <li>• Sale or clearance items</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Return Process -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">How to Return an Item</h2>
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">1</div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Contact Customer Service</h3>
                            <p class="text-gray-600">Email us at returns@sueandmon.com or call +234 123 456 7890 to initiate your return.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">2</div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Get Return Authorization</h3>
                            <p class="text-gray-600">We'll provide you with a return authorization number and shipping instructions.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">3</div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Package and Ship</h3>
                            <p class="text-gray-600">Securely package the item in its original packaging and ship it to our returns address.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">4</div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Receive Refund</h3>
                            <p class="text-gray-600">Once we receive and inspect your return, we'll process your refund within 5-7 business days.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Refund Information -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Refund Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Refund Timeline</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Processing: 1-2 business days</li>
                            <li>• Bank transfer: 3-5 business days</li>
                            <li>• Credit card: 5-10 business days</li>
                            <li>• PayPal: 1-3 business days</li>
                        </ul>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">What You'll Receive</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Full product price</li>
                            <li>• Original shipping cost (if applicable)</li>
                            <li>• Return shipping cost (for defective items)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Return Shipping</h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipping Costs</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Customer Pays Shipping</h4>
                            <p class="text-gray-600">For returns due to change of mind or buyer's remorse, customers are responsible for return shipping costs.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">We Pay Shipping</h4>
                            <p class="text-gray-600">For defective items, wrong items received, or damage during shipping, we cover return shipping costs.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Need Help?</h2>
                <div class="bg-green-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Our Returns Team</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600 mb-2"><strong>Email:</strong> returns@sueandmon.com</p>
                            <p class="text-gray-600 mb-2"><strong>Phone:</strong> +234 123 456 7890</p>
                            <p class="text-gray-600"><strong>Hours:</strong> Monday - Friday, 9AM - 6PM</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-2"><strong>Response Time:</strong> Within 24 hours</p>
                            <p class="text-gray-600 mb-2"><strong>Live Chat:</strong> Available on website</p>
                            <p class="text-gray-600"><strong>Support:</strong> 7 days a week</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I return a gift?</h3>
                        <p class="text-gray-600">Yes, you can return gifts within 30 days of delivery. You'll need the order number or gift receipt.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">What if my item arrives damaged?</h3>
                        <p class="text-gray-600">Contact us immediately with photos of the damage. We'll arrange a replacement or refund at no cost to you.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I exchange an item?</h3>
                        <p class="text-gray-600">Yes, you can exchange for a different size, color, or product. Contact us to arrange the exchange.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">How long does the return process take?</h3>
                        <p class="text-gray-600">From the time we receive your return, processing takes 1-2 business days, plus shipping time back to you.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 