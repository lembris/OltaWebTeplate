<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .privacy-hero {
    padding: 120px 0 80px;
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    position: relative;
  }

  .privacy-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
  }

  .privacy-hero .container {
    position: relative;
    z-index: 1;
  }

  .privacy-hero h1 {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .privacy-hero p {
    font-size: 1.25rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
  }

  .privacy-content {
    padding: 80px 0;
    background: white;
  }

  .privacy-content h2 {
    color: #1e3a8a;
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
  }

  .privacy-content h3 {
    color: #1e3a8a;
    font-weight: 600;
    margin: 2rem 0 1rem 0;
    font-size: 1.25rem;
  }

  .privacy-content p {
    color: #64748b;
    line-height: 1.8;
    margin-bottom: 1rem;
  }

  .privacy-content ul {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
  }

  .privacy-content li {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 0.5rem;
  }

  .privacy-contact {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 3rem;
    border-radius: 16px;
    margin-top: 3rem;
    text-align: center;
    border: 1px solid #e2e8f0;
  }

  .privacy-contact h3 {
    color: #1e3a8a;
    margin-bottom: 1rem;
  }

  .privacy-contact p {
    color: #64748b;
    margin-bottom: 1.5rem;
  }

  .privacy-contact .btn {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
  }

  .privacy-contact .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(30, 58, 138, 0.3);
  }

  @media (max-width: 768px) {
    .privacy-hero {
      padding: 80px 0 60px;
    }

    .privacy-hero h1 {
      font-size: 2rem;
    }

    .privacy-content {
      padding: 60px 0;
    }

    .privacy-contact {
      padding: 2rem;
    }
  }
</style>

<!-- Page Header -->
<section class="privacy-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="page-header" data-aos="fade-up">
          <h1>Privacy Policy</h1>
          <p>Your privacy is our priority during your safari adventure</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Privacy Content -->
<section class="privacy-content">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10" data-aos="fade-up">

        <div class="content-section">
          <h2>Last Updated: <?php echo date('F j, Y'); ?></h2>

          <p>At Safari Adventure Tours, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our safari tour services, website, or mobile applications.</p>

          <h3>1. Information We Collect</h3>

          <h4>Personal Information</h4>
          <p>We may collect the following types of personal information:</p>
          <ul>
            <li>Name, address, phone number, and email address</li>
            <li>Date of birth and nationality</li>
            <li>Passport and visa information</li>
            <li>Emergency contact information</li>
            <li>Travel preferences and special requirements</li>
            <li>Payment information for bookings</li>
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
            <li>Process safari tour bookings and reservations</li>
            <li>Provide travel and accommodation arrangements</li>
            <li>Communicate with you about your safari plans</li>
            <li>Send you important updates about your trip</li>
            <li>Improve our safari services and website</li>
            <li>Process payments for tours and services</li>
            <li>Comply with legal and regulatory requirements</li>
          </ul>

          <h3>3. Information Sharing and Disclosure</h3>

          <p>We do not sell, trade, or rent your personal information to third parties. We may share your information only in the following circumstances:</p>

          <ul>
            <li><strong>Travel Partners:</strong> With hotels, airlines, and tour operators involved in your safari</li>
            <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
            <li><strong>Business Partners:</strong> With trusted partners who help us provide safari services</li>
            <li><strong>Emergency Situations:</strong> To protect your safety during travel</li>
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

          <h3>7. Third-Party Services</h3>

          <p>Our website may contain links to third-party websites and services. We are not responsible for the privacy practices of these external sites. We encourage you to review their privacy policies.</p>

          <h3>8. Children's Privacy</h3>

          <p>Our safari services are designed for adults and families. We do not knowingly collect personal information from children under 13. If we become aware that we have collected such information, we will take steps to delete it.</p>

          <h3>9. Changes to This Policy</h3>

          <p>We may update this Privacy Policy from time to time. We will notify you of any significant changes by posting the new policy on this page and updating the "Last Updated" date.</p>

          <h3>10. Contact Us</h3>

          <p>If you have any questions about this Privacy Policy or our privacy practices, please contact us:</p>
          <ul>
            <li><strong>Email:</strong> <?php echo !empty($site_email) ? $site_email : 'privacy@safariadventure.com'; ?></li>
            <li><strong>Phone:</strong> <?php echo !empty($phone_number) ? $phone_number : '+255 XXX XXX XXX'; ?></li>
            <li><strong>Address:</strong> <?php echo !empty($physical_address) ? $physical_address : 'Arusha, Tanzania'; ?></li>
          </ul>

          <div class="privacy-contact">
            <h3>Questions About Your Privacy?</h3>
            <p>Contact our privacy team for assistance with any privacy-related concerns.</p>
            <a href="<?php echo base_url('contact'); ?>" class="btn">Contact Us</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>