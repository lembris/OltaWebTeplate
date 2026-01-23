<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Medical Legal Pages Seeder
 *
 * This seeder creates essential legal pages for the Medical template:
 * - Privacy Policy
 * - Terms of Service
 * - Refund Policy
 * - Cookie Policy
 * - Disclaimer
 *
 * Run this seeder to populate the pages table with medical-themed legal content.
 */

class Medical_Legal_Pages_Seeder {

    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Page_model');
    }

    public function run()
    {
        echo "🌡️ Seeding Medical Legal Pages...\n";

        $pages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => $this->get_privacy_policy_content(),
                'excerpt' => 'Learn how TNA CARE protects your privacy and handles your personal information in our healthcare services.',
                'seo_title' => 'Privacy Policy | TNA CARE - Healthcare Privacy Protection',
                'seo_description' => 'Learn how TNA CARE protects your privacy and handles your personal information in our healthcare services.',
                'seo_keywords' => 'privacy policy, data protection, healthcare privacy, TNA CARE privacy',
                'template' => 'default',
                'status' => 'published',
                'sort_order' => 1,
                'show_in_footer' => 1,
                'show_in_header' => 0,
                'theme' => 'medical'
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => $this->get_terms_of_service_content(),
                'excerpt' => 'Terms and conditions for using TNA CARE healthcare services.',
                'seo_title' => 'Terms of Service | TNA CARE - Healthcare Service Terms',
                'seo_description' => 'Read TNA CARE\'s terms of service for our healthcare consultation, education, and outreach services.',
                'seo_keywords' => 'terms of service, healthcare terms, TNA CARE terms, service conditions',
                'template' => 'default',
                'status' => 'published',
                'sort_order' => 2,
                'show_in_footer' => 1,
                'show_in_header' => 0,
                'theme' => 'medical'
            ],
            [
                'title' => 'Refund Policy',
                'slug' => 'refund-policy',
                'content' => $this->get_refund_policy_content(),
                'excerpt' => 'Understanding our refund terms for healthcare services.',
                'seo_title' => 'Refund Policy | TNA CARE - Service Refund Terms',
                'seo_description' => 'Learn about TNA CARE\'s refund policy for healthcare services, consultations, and treatments.',
                'seo_keywords' => 'refund policy, healthcare refunds, TNA CARE refunds, cancellation policy',
                'template' => 'default',
                'status' => 'published',
                'sort_order' => 3,
                'show_in_footer' => 1,
                'show_in_header' => 0,
                'theme' => 'medical'
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookie-policy',
                'content' => $this->get_cookie_policy_content(),
                'excerpt' => 'Learn about how TNA CARE uses cookies and tracking technologies.',
                'seo_title' => 'Cookie Policy | TNA CARE - Website Cookie Usage',
                'seo_description' => 'Learn about how TNA CARE uses cookies and tracking technologies on our healthcare website.',
                'seo_keywords' => 'cookie policy, website cookies, tracking, TNA CARE privacy',
                'template' => 'default',
                'status' => 'published',
                'sort_order' => 4,
                'show_in_footer' => 1,
                'show_in_header' => 0,
                'theme' => 'medical'
            ],
            [
                'title' => 'Disclaimer',
                'slug' => 'disclaimer',
                'content' => $this->get_disclaimer_content(),
                'excerpt' => 'Important disclaimer regarding TNA CARE healthcare services.',
                'seo_title' => 'Disclaimer | TNA CARE - Healthcare Service Disclaimer',
                'seo_description' => 'Important disclaimer regarding TNA CARE healthcare services, medical advice, and treatment information.',
                'seo_keywords' => 'disclaimer, healthcare disclaimer, medical advice, TNA CARE terms',
                'template' => 'default',
                'status' => 'published',
                'sort_order' => 5,
                'show_in_footer' => 1,
                'show_in_header' => 0,
                'theme' => 'medical'
            ]
        ];

        $inserted = 0;
        $skipped = 0;

        foreach ($pages as $page_data) {
            // Check if page already exists
            if ($this->CI->Page_model->get_by_slug($page_data['slug'])) {
                echo "⚠️  Skipping '{$page_data['title']}' - already exists\n";
                $skipped++;
                continue;
            }

            // Create the page
            $uid = $this->CI->Page_model->create($page_data);
            if ($uid) {
                echo "✅ Created '{$page_data['title']}' (UID: {$uid})\n";
                $inserted++;
            } else {
                echo "❌ Failed to create '{$page_data['title']}'\n";
            }
        }

        echo "\n📊 Seeder Results:\n";
        echo "   ✅ Inserted: {$inserted} pages\n";
        echo "   ⚠️  Skipped: {$skipped} pages (already exist)\n";
        echo "   📄 Total: " . ($inserted + $skipped) . " pages processed\n\n";

        if ($inserted > 0) {
            echo "🎉 Medical legal pages seeded successfully!\n";
            echo "   Visit your website to see them in the footer.\n";
            echo "   Admin can edit them at: /admin/pages\n\n";
        }
    }

    private function get_privacy_policy_content()
    {
        return '<h2>Last Updated: ' . date('F j, Y') . '</h2>

<p>At TIBA NA AFYA CARE (TNA CARE), we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our healthcare services, website, or mobile applications.</p>

<h3>1. Information We Collect</h3>

<h4>Personal Information</h4>
<p>We may collect the following types of personal information:</p>
<ul>
    <li>Name, address, phone number, and email address</li>
    <li>Date of birth and gender</li>
    <li>Medical history and health information</li>
    <li>Insurance information</li>
    <li>Emergency contact information</li>
    <li>Payment information for services</li>
</ul>

<h4>Usage Information</h4>
<p>We automatically collect certain information when you visit our website:</p>
<ul>
    <li>IP address and location information</li>
    <li>Browser type and version</li>
    <li>Pages visited and time spent on our site</li>
    <li>Device information and screen resolution</li>
    <li>Referral sources</li>
</ul>

<h3>2. How We Use Your Information</h3>

<p>We use the information we collect for the following purposes:</p>
<ul>
    <li>Provide healthcare services and consultations</li>
    <li>Process appointments and medical referrals</li>
    <li>Communicate with you about your health and services</li>
    <li>Improve our healthcare services and website</li>
    <li>Send you important updates about your health</li>
    <li>Comply with legal and regulatory requirements</li>
    <li>Process payments for services</li>
</ul>

<h3>3. Information Sharing and Disclosure</h3>

<p>We do not sell, trade, or rent your personal information to third parties. We may share your information only in the following circumstances:</p>

<ul>
    <li><strong>Healthcare Providers:</strong> With doctors, hospitals, and specialists involved in your care</li>
    <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
    <li><strong>Business Partners:</strong> With trusted partners who help us provide services</li>
    <li><strong>Emergency Situations:</strong> To protect your health or safety</li>
</ul>

<h3>4. Data Security</h3>

<p>We implement appropriate security measures to protect your personal information:</p>
<ul>
    <li>Encryption of sensitive data in transit and at rest</li>
    <li>Secure server infrastructure</li>
    <li>Regular security audits and updates</li>
    <li>Limited access to personal information</li>
    <li>Employee training on data protection</li>
</ul>

<h3>5. Your Rights</h3>

<p>You have the following rights regarding your personal information:</p>
<ul>
    <li><strong>Access:</strong> Request access to your personal information</li>
    <li><strong>Correction:</strong> Request correction of inaccurate information</li>
    <li><strong>Deletion:</strong> Request deletion of your personal information</li>
    <li><strong>Portability:</strong> Request transfer of your data</li>
    <li><strong>Objection:</strong> Object to processing of your information</li>
</ul>

<h3>6. Cookies and Tracking</h3>

<p>Our website uses cookies and similar technologies to enhance your experience:</p>
<ul>
    <li><strong>Essential Cookies:</strong> Required for website functionality</li>
    <li><strong>Analytics Cookies:</strong> Help us understand how you use our site</li>
    <li><strong>Preference Cookies:</strong> Remember your settings and preferences</li>
</ul>

<p>You can control cookie settings through your browser preferences.</p>

<h3>7. Contact Us</h3>

<p>If you have any questions about this Privacy Policy or our privacy practices, please contact us:</p>
<ul>
    <li><strong>Email:</strong> privacy@tnacare.com</li>
    <li><strong>Phone:</strong> +255 XXX XXX XXX</li>
    <li><strong>Address:</strong> Dar es Salaam, Tanzania</li>
</ul>';
    }

    private function get_terms_of_service_content()
    {
        return '<h2>Last Updated: ' . date('F j, Y') . '</h2>

<p>Welcome to TIBA NA AFYA CARE (TNA CARE). These Terms of Service ("Terms") govern your use of our healthcare services, website, mobile applications, and related services (collectively, the "Services"). By accessing or using our Services, you agree to be bound by these Terms.</p>

<h3>1. Acceptance of Terms</h3>

<p>By accessing and using TNA CARE services, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>

<h3>2. Description of Services</h3>

<p>TNA CARE provides healthcare facilitation services including:</p>
<ul>
    <li>Health education and awareness programs</li>
    <li>Medical outreach and screening services</li>
    <li>Corporate wellness programs</li>
    <li>Telemedicine consultations</li>
    <li>Medical tourism and referrals</li>
    <li>Health media production and content</li>
</ul>

<h3>3. User Responsibilities</h3>

<h4>Account Registration</h4>
<p>When registering for our services, you agree to:</p>
<ul>
    <li>Provide accurate and complete information</li>
    <li>Maintain the confidentiality of your account credentials</li>
    <li>Notify us immediately of any unauthorized use</li>
    <li>Accept responsibility for all activities under your account</li>
</ul>

<h4>Medical Information</h4>
<p>You agree to provide accurate medical information and understand that:</p>
<ul>
    <li>Inaccurate information may affect the quality of care</li>
    <li>You are responsible for informing us of changes in your health</li>
    <li>Medical advice should be verified with qualified healthcare providers</li>
</ul>

<h3>4. Healthcare Services Terms</h3>

<h4>Consultations and Appointments</h4>
<ul>
    <li>Appointments should be scheduled in advance</li>
    <li>Cancellation requires 24-hour notice</li>
    <li>Emergency services take priority over scheduled appointments</li>
    <li>Consultation fees are due at the time of service</li>
</ul>

<h4>Medical Referrals</h4>
<ul>
    <li>Referrals are recommendations, not guarantees of treatment</li>
    <li>Final acceptance depends on the receiving facility</li>
    <li>Referral fees may apply for international services</li>
    <li>Travel arrangements are the patient\'s responsibility</li>
</ul>

<h3>5. Payment Terms</h3>

<p>Payment for services is required according to the following terms:</p>
<ul>
    <li>All fees are quoted in Tanzanian Shillings unless otherwise specified</li>
    <li>Payment is due at the time of service unless arranged otherwise</li>
    <li>Late payments may incur additional charges</li>
    <li>Refunds are processed according to our refund policy</li>
    <li>Insurance claims are the patient\'s responsibility to pursue</li>
</ul>

<h3>6. Privacy and Data Protection</h3>

<p>Your privacy is important to us. Our collection and use of personal information is governed by our Privacy Policy, which is incorporated into these Terms by reference. By using our services, you consent to the collection and use of your information as outlined in our Privacy Policy.</p>

<h3>7. Limitation of Liability</h3>

<p>TNA CARE provides healthcare facilitation services but is not a licensed medical facility. We are not liable for:</p>
<ul>
    <li>Medical outcomes or treatment results</li>
    <li>Actions or omissions of healthcare providers</li>
    <li>Delays in treatment due to external factors</li>
    <li>Loss of personal property during services</li>
</ul>

<p>Our liability is limited to the amount paid for our specific services.</p>

<h3>8. Disclaimers</h3>

<p>The information provided through our services is for educational purposes only and should not be considered medical advice. Always consult qualified healthcare professionals for medical concerns.</p>

<h3>9. Termination of Services</h3>

<p>Either party may terminate these services with written notice. TNA CARE reserves the right to terminate services for:</p>
<ul>
    <li>Violation of these terms</li>
    <li>Non-payment of fees</li>
    <li>Abusive or inappropriate behavior</li>
    <li>Legal or regulatory requirements</li>
</ul>

<h3>10. Governing Law</h3>

<p>These Terms are governed by the laws of Tanzania. Any disputes arising from these terms will be resolved through the courts of Tanzania.</p>

<h3>11. Changes to Terms</h3>

<p>We reserve the right to modify these Terms at any time. Changes will be effective immediately upon posting on our website. Continued use of our services constitutes acceptance of the modified terms.</p>

<h3>12. Contact Information</h3>

<p>For questions about these Terms of Service, please contact us:</p>
<ul>
    <li><strong>Email:</strong> legal@tnacare.com</li>
    <li><strong>Phone:</strong> +255 XXX XXX XXX</li>
    <li><strong>Address:</strong> Dar es Salaam, Tanzania</li>
</ul>';
    }

    private function get_refund_policy_content()
    {
        return '<h2>Last Updated: ' . date('F j, Y') . '</h2>

<p>At TIBA NA AFYA CARE (TNA CARE), we strive to provide excellent healthcare services. This Refund Policy outlines the terms and conditions for refunds related to our services.</p>

<h3>1. General Refund Policy</h3>

<p>Refunds are processed according to the following general guidelines:</p>
<ul>
    <li>All refund requests must be submitted in writing</li>
    <li>Refunds are processed within 14-30 business days</li>
    <li>Original payment method will be used for refunds</li>
    <li>Processing fees may apply to certain refund methods</li>
</ul>

<h3>2. Consultation Services</h3>

<h4>Telemedicine Consultations</h4>
<ul>
    <li>Cancellations made 24+ hours before appointment: Full refund</li>
    <li>Cancellations made 12-24 hours before: 50% refund</li>
    <li>Cancellations made less than 12 hours before: No refund</li>
    <li>No-shows: No refund</li>
</ul>

<h4>In-Person Consultations</h4>
<ul>
    <li>Cancellations made 48+ hours before appointment: Full refund</li>
    <li>Cancellations made 24-48 hours before: 75% refund</li>
    <li>Cancellations made less than 24 hours before: No refund</li>
    <li>No-shows: No refund</li>
</ul>

<h3>3. Medical Services</h3>

<p>Refunds for medical services vary based on the type and timing:</p>
<ul>
    <li><strong>Preventive Screenings:</strong> 80% refund if cancelled 7+ days before</li>
    <li><strong>Diagnostic Tests:</strong> 50% refund if cancelled 48+ hours before</li>
    <li><strong>Treatment Services:</strong> No refund once service begins</li>
    <li><strong>Emergency Services:</strong> No refunds for emergency care</li>
</ul>

<h3>4. Corporate Wellness Programs</h3>

<h4>Individual Sessions</h4>
<ul>
    <li>Cancellations made 48+ hours before: Full refund</li>
    <li>Cancellations made 24-48 hours before: 75% refund</li>
    <li>Cancellations made less than 24 hours before: No refund</li>
</ul>

<h4>Program Packages</h4>
<ul>
    <li>Unused sessions: Refunded at prorated rate</li>
    <li>Program cancellation: 50% refund for unused portion</li>
    <li>Custom programs: Terms specified in agreement</li>
</ul>

<h3>5. Education and Training Programs</h3>

<ul>
    <li>Workshop cancellations 7+ days before: Full refund</li>
    <li>Workshop cancellations 3-7 days before: 50% refund</li>
    <li>Workshop cancellations less than 3 days before: No refund</li>
    <li>Online courses: 30-day money-back guarantee</li>
</ul>

<h3>6. Medical Tourism Services</h3>

<h4>Consultation Fees</h4>
<ul>
    <li>Refunds available if treatment cannot be arranged</li>
    <li>Service fees non-refundable once treatment begins</li>
    <li>Travel-related cancellations follow standard terms</li>
</ul>

<h4>Hospital Referrals</h4>
<ul>
    <li>Referral fees non-refundable</li>
    <li>Treatment cost refunds depend on hospital policies</li>
    <li>Travel and accommodation refunds per booking terms</li>
</ul>

<h3>7. Exceptional Circumstances</h3>

<p>In certain exceptional circumstances, we may consider refunds outside our standard policy:</p>
<ul>
    <li>Medical emergencies preventing service delivery</li>
    <li>Service unavailability due to unforeseen circumstances</li>
    <li>Quality issues with delivered services</li>
    <li>Administrative errors on our part</li>
</ul>

<h3>8. Refund Processing</h3>

<h4>Processing Time</h4>
<ul>
    <li>Credit/Debit cards: 5-10 business days</li>
    <li>Bank transfers: 7-14 business days</li>
    <li>Mobile payments: 3-7 business days</li>
    <li>International transfers: 14-30 business days</li>
</ul>

<h4>Refund Methods</h4>
<ul>
    <li>Original payment method used when possible</li>
    <li>Alternative methods available upon request</li>
    <li>Processing fees may apply for alternative methods</li>
</ul>

<h3>9. Contact Information</h3>

<p>For refund requests or questions about this policy:</p>
<ul>
    <li><strong>Email:</strong> refunds@tnacare.com</li>
    <li><strong>Phone:</strong> +255 XXX XXX XXX</li>
    <li><strong>Address:</strong> Dar es Salaam, Tanzania</li>
</ul>';
    }

    private function get_cookie_policy_content()
    {
        return '<h2>Last Updated: ' . date('F j, Y') . '</h2>

<p>This Cookie Policy explains how TIBA NA AFYA CARE (TNA CARE) uses cookies and similar technologies on our website. By using our website, you consent to the use of cookies in accordance with this policy.</p>

<h3>1. What Are Cookies?</h3>

<p>Cookies are small text files that are stored on your computer or mobile device when you visit our website. They help us provide you with a better browsing experience and allow certain features to work properly.</p>

<h3>2. How We Use Cookies</h3>

<p>We use cookies for the following purposes:</p>

<ul>
    <li><strong>Essential Cookies:</strong> Required for the website to function properly, including navigation and secure areas</li>
    <li><strong>Analytics Cookies:</strong> Help us understand how visitors use our website and improve our services</li>
    <li><strong>Functional Cookies:</strong> Remember your preferences and settings</li>
    <li><strong>Marketing Cookies:</strong> Used to deliver relevant advertisements and track campaign effectiveness</li>
</ul>

<h3>3. Types of Cookies We Use</h3>

<h4>Session Cookies</h4>
<p>Temporary cookies that expire when you close your browser. Used to maintain your session while browsing.</p>

<h4>Persistent Cookies</h4>
<p>Cookies that remain on your device for a set period or until you delete them. Used to remember your preferences.</p>

<h4>Third-Party Cookies</h4>
<p>Cookies set by third-party services we use, such as Google Analytics for website analytics.</p>

<h3>4. Managing Cookies</h3>

<p>You can control and manage cookies in various ways:</p>

<h4>Browser Settings</h4>
<p>Most web browsers allow you to control cookies through their settings. You can:</p>
<ul>
    <li>Block all cookies</li>
    <li>Block third-party cookies</li>
    <li>Delete existing cookies</li>
    <li>Receive notifications before cookies are set</li>
</ul>

<h4>Opt-Out Options</h4>
<p>You can opt out of certain third-party cookies by visiting:</p>
<ul>
    <li>Google Analytics: <a href="https://tools.google.com/dlpage/gaoptout" target="_blank">Google Analytics Opt-out</a></li>
    <li>Google Ads: <a href="https://www.google.com/settings/ads" target="_blank">Google Ads Settings</a></li>
</ul>

<h3>5. Impact of Disabling Cookies</h3>

<p>Please note that disabling cookies may affect your browsing experience:</p>
<ul>
    <li>Some website features may not work properly</li>
    <li>You may need to re-enter information more frequently</li>
    <li>Certain personalization features may be unavailable</li>
    <li>Analytics and performance monitoring may be limited</li>
</ul>

<h3>6. Updates to This Policy</h3>

<p>We may update this Cookie Policy from time to time to reflect changes in our practices or for other operational, legal, or regulatory reasons. We will post the updated policy on this page with a revised "Last Updated" date.</p>

<h3>7. Contact Us</h3>

<p>If you have any questions about our use of cookies or this Cookie Policy, please contact us:</p>
<ul>
    <li><strong>Email:</strong> privacy@tnacare.com</li>
    <li><strong>Phone:</strong> +255 XXX XXX XXX</li>
    <li><strong>Address:</strong> Dar es Salaam, Tanzania</li>
</ul>';
    }

    private function get_disclaimer_content()
    {
        return '<h2>Last Updated: ' . date('F j, Y') . '</h2>

<p>This disclaimer governs your use of TIBA NA AFYA CARE (TNA CARE) website and services. By accessing or using our services, you agree to the terms of this disclaimer.</p>

<h3>1. Medical Disclaimer</h3>

<p><strong>TNA CARE is not a licensed medical facility.</strong> We provide healthcare facilitation services, health education, and medical outreach programs. We do not provide direct medical treatment, diagnosis, or prescribe medications.</p>

<p>The information provided on our website and through our services is for educational and informational purposes only. It should not be considered medical advice, diagnosis, or treatment recommendations.</p>

<p><strong>Always consult qualified healthcare professionals</strong> for medical concerns, diagnosis, and treatment. Do not rely on information from our website as a substitute for professional medical advice.</p>

<h3>2. No Professional Medical Advice</h3>

<p>The content on our website, including articles, blog posts, and educational materials:</p>
<ul>
    <li>Is not intended to diagnose, treat, cure, or prevent any disease</li>
    <li>Should not replace professional medical advice</li>
    <li>May not be applicable to your specific health situation</li>
    <li>Is provided "as is" without warranties of any kind</li>
</ul>

<h3>3. Service Limitations</h3>

<p>While we strive to provide accurate and helpful information, we cannot guarantee:</p>
<ul>
    <li>The completeness or accuracy of all information</li>
    <li>The availability of specific healthcare services</li>
    <li>The outcome of any medical referrals or consultations</li>
    <li>The compatibility of services with your individual needs</li>
</ul>

<h3>4. External Links and Third Parties</h3>

<p>Our website may contain links to third-party websites and services. These links are provided for convenience only. We do not endorse or assume responsibility for:</p>
<ul>
    <li>The content of external websites</li>
    <li>The privacy practices of third parties</li>
    <li>The accuracy of information on external sites</li>
    <li>The availability or quality of third-party services</li>
</ul>

<h3>5. Medical Tourism Services</h3>

<p>For medical tourism and international healthcare services:</p>
<ul>
    <li>We facilitate connections but do not guarantee treatment outcomes</li>
    <li>Final treatment decisions are made by healthcare providers</li>
    <li>Travel arrangements are the responsibility of the patient</li>
    <li>Visa and immigration requirements vary by country</li>
</ul>

<h3>6. Limitation of Liability</h3>

<p>To the fullest extent permitted by law, TNA CARE shall not be liable for:</p>
<ul>
    <li>Any direct, indirect, incidental, or consequential damages</li>
    <li>Loss of profits, data, or business opportunities</li>
    <li>Medical outcomes or treatment results</li>
    <li>Delays in treatment or service delivery</li>
    <li>Actions or omissions of healthcare providers</li>
</ul>

<h3>7. Indemnification</h3>

<p>You agree to indemnify and hold harmless TNA CARE, its officers, directors, employees, and agents from any claims, damages, losses, or expenses arising from:</p>
<ul>
    <li>Your use of our website or services</li>
    <li>Your violation of these terms</li>
    <li>Your violation of applicable laws or regulations</li>
    <li>Any third-party claims related to your use of our services</li>
</ul>

<h3>8. Changes to This Disclaimer</h3>

<p>We reserve the right to modify this disclaimer at any time without prior notice. Changes will be effective immediately upon posting on our website. Your continued use of our services constitutes acceptance of the modified disclaimer.</p>

<h3>9. Governing Law</h3>

<p>This disclaimer is governed by the laws of Tanzania. Any disputes arising from this disclaimer will be resolved through the courts of Tanzania.</p>

<h3>10. Contact Information</h3>

<p>If you have questions about this disclaimer, please contact us:</p>
<ul>
    <li><strong>Email:</strong> legal@tnacare.com</li>
    <li><strong>Phone:</strong> +255 XXX XXX XXX</li>
    <li><strong>Address:</strong> Dar es Salaam, Tanzania</li>
</ul>

<h3>11. Acknowledgment</h3>

<p>By using TNA CARE services, you acknowledge that you have read, understood, and agree to be bound by this disclaimer. If you do not agree with any part of this disclaimer, please discontinue use of our services immediately.</p>';
    }
}

// Execute the seeder if this file is run directly
if (!defined('BASEPATH')) {
    // Include the CodeIgniter bootstrap
    require_once __DIR__ . '/../../index.php';

    // Create and run the seeder
    $seeder = new Medical_Legal_Pages_Seeder();
    $seeder->run();
}