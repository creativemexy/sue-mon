<?php
$page_title = 'Privacy Policy';
$page_description = 'How we collect, use, and protect your personal information.';

ob_start();
?>

<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Privacy Policy</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    We are committed to protecting your privacy and personal information.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="prose prose-lg max-w-none">
            <h2>Information We Collect</h2>
            <p>We collect information you provide directly to us, such as when you create an account, place an order, or contact us. This may include:</p>
            <ul>
                <li>Name and contact information</li>
                <li>Billing and shipping addresses</li>
                <li>Payment information</li>
                <li>Order history</li>
                <li>Communication preferences</li>
            </ul>

            <h2>How We Use Your Information</h2>
            <p>We use the information we collect to:</p>
            <ul>
                <li>Process and fulfill your orders</li>
                <li>Communicate with you about your orders</li>
                <li>Send you marketing communications (with your consent)</li>
                <li>Improve our products and services</li>
                <li>Provide customer support</li>
                <li>Comply with legal obligations</li>
            </ul>

            <h2>Information Sharing</h2>
            <p>We do not sell, trade, or otherwise transfer your personal information to third parties except in the following circumstances:</p>
            <ul>
                <li>With your consent</li>
                <li>To process payments (Paystack)</li>
                <li>To fulfill orders (shipping partners)</li>
                <li>To comply with legal requirements</li>
                <li>To protect our rights and safety</li>
            </ul>

            <h2>Data Security</h2>
            <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. These measures include:</p>
            <ul>
                <li>Encryption of sensitive data</li>
                <li>Secure payment processing</li>
                <li>Regular security assessments</li>
                <li>Access controls and authentication</li>
            </ul>

            <h2>Cookies and Tracking</h2>
            <p>We use cookies and similar technologies to:</p>
            <ul>
                <li>Remember your preferences</li>
                <li>Analyze website traffic</li>
                <li>Improve user experience</li>
                <li>Provide personalized content</li>
            </ul>
            <p>You can control cookie settings through your browser preferences.</p>

            <h2>Your Rights</h2>
            <p>You have the right to:</p>
            <ul>
                <li>Access your personal information</li>
                <li>Correct inaccurate information</li>
                <li>Request deletion of your data</li>
                <li>Opt out of marketing communications</li>
                <li>Withdraw consent at any time</li>
            </ul>

            <h2>Data Retention</h2>
            <p>We retain your personal information for as long as necessary to:</p>
            <ul>
                <li>Provide our services</li>
                <li>Comply with legal obligations</li>
                <li>Resolve disputes</li>
                <li>Enforce our agreements</li>
            </ul>

            <h2>Children's Privacy</h2>
            <p>Our website is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13.</p>

            <h2>Third-Party Links</h2>
            <p>Our website may contain links to third-party websites. We are not responsible for the privacy practices of these websites. We encourage you to read their privacy policies.</p>

            <h2>International Transfers</h2>
            <p>Your information may be transferred to and processed in countries other than your own. We ensure appropriate safeguards are in place to protect your data.</p>

            <h2>Changes to This Policy</h2>
            <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last Updated" date.</p>

            <h2>Contact Us</h2>
            <p>If you have any questions about this Privacy Policy, please contact us at:</p>
            <ul>
                <li>Email: privacy@sueandmon.com</li>
                <li>Phone: +234 123 456 7890</li>
                <li>Address: 123 Wellness Street, Lagos, Nigeria</li>
            </ul>

            <h2>Data Protection Officer</h2>
            <p>For privacy-related inquiries, you can also contact our Data Protection Officer at dpo@sueandmon.com</p>

            <p class="text-sm text-gray-500 mt-8">Last updated: <?php echo date('F j, Y'); ?></p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?> 