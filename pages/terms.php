<?php
$page_title = 'Terms of Service';
$page_description = 'Terms and conditions for using Sue & Mon services.';

ob_start();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Terms of Service</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    Please read these terms carefully before using our services.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="prose prose-lg max-w-none">
            <h2>1. Acceptance of Terms</h2>
            <p>By accessing and using the Sue & Mon website and services, you accept and agree to be bound by the terms and provision of this agreement.</p>

            <h2>2. Use License</h2>
            <p>Permission is granted to temporarily download one copy of the materials (information or software) on Sue & Mon's website for personal, non-commercial transitory viewing only.</p>

            <h2>3. Product Information</h2>
            <p>We strive to provide accurate product information, but we do not warrant that product descriptions or other content is accurate, complete, reliable, current, or error-free.</p>

            <h2>4. Pricing and Payment</h2>
            <p>All prices are in Nigerian Naira (₦). We reserve the right to modify prices at any time. Payment must be made at the time of order placement.</p>

            <h2>5. Shipping and Delivery</h2>
            <p>We will ship your order to the address you provide. Delivery times are estimates only. We are not responsible for delays beyond our control.</p>

            <h2>6. Returns and Refunds</h2>
            <p>We accept returns within 30 days of delivery for unused products in original packaging. Return shipping costs are the responsibility of the customer.</p>

            <h2>7. Privacy Policy</h2>
            <p>Your privacy is important to us. Please review our Privacy Policy, which also governs your use of the website.</p>

            <h2>8. User Account</h2>
            <p>You are responsible for maintaining the confidentiality of your account and password. You agree to accept responsibility for all activities under your account.</p>

            <h2>9. Prohibited Uses</h2>
            <p>You may not use our website for any unlawful purpose or to solicit others to perform unlawful acts.</p>

            <h2>10. Disclaimer</h2>
            <p>The materials on Sue & Mon's website are provided on an 'as is' basis. Sue & Mon makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>

            <h2>11. Limitations</h2>
            <p>In no event shall Sue & Mon or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on Sue & Mon's website.</p>

            <h2>12. Revisions and Errata</h2>
            <p>The materials appearing on Sue & Mon's website could include technical, typographical, or photographic errors. Sue & Mon does not warrant that any of the materials on its website are accurate, complete or current.</p>

            <h2>13. Links</h2>
            <p>Sue & Mon has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by Sue & Mon of the site.</p>

            <h2>14. Modifications</h2>
            <p>Sue & Mon may revise these terms of service for its website at any time without notice. By using this website you are agreeing to be bound by the then current version of these Terms of Service.</p>

            <h2>15. Governing Law</h2>
            <p>These terms and conditions are governed by and construed in accordance with the laws of Nigeria and you irrevocably submit to the exclusive jurisdiction of the courts in that location.</p>

            <h2>Contact Information</h2>
            <p>If you have any questions about these Terms of Service, please contact us at:</p>
            <ul>
                <li>Email: legal@sueandmon.com</li>
                <li>Phone: +234 123 456 7890</li>
                <li>Address: 123 Wellness Street, Lagos, Nigeria</li>
            </ul>

            <p class="text-sm text-gray-500 mt-8">Last updated: <?php echo date('F j, Y'); ?></p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 