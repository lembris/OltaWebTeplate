<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .privacy-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .privacy-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="%23059669" opacity="0.03"/></svg>');
    background-size: 30px 30px;
    pointer-events: none;
  }

  .privacy-content {
    padding: 80px 0;
    background: white;
  }

  .privacy-content h2 {
    color: var(--theme-primary);
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
  }

  .privacy-content h3 {
    color: var(--theme-primary);
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
    background: #f8fafc;
    padding: 3rem;
    border-radius: 16px;
    margin-top: 3rem;
    text-align: center;
  }

  .privacy-contact h3 {
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .privacy-contact p {
    color: #64748b;
    margin-bottom: 1.5rem;
  }

  .privacy-contact .btn {
    background: var(--theme-primary);
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .privacy-contact .btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
  }

  @media (max-width: 768px) {
    .privacy-hero {
      padding: 80px 0 60px;
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
          <p>How we protect your personal information and maintain your privacy in our healthcare services</p>
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

          <h3>7. Third-Party Services</h3>

          <p>Our website may contain links to third-party websites and services. We are not responsible for the privacy practices of these external sites. We encourage you to review their privacy policies.</p>

          <h3>8. Children's Privacy</h3>

          <p>Our services are not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If we become aware that we have collected such information, we will take steps to delete it.</p>

          <h3>9. Changes to This Policy</h3>

          <p>We may update this Privacy Policy from time to time. We will notify you of any significant changes by posting the new policy on this page and updating the "Last Updated" date.</p>

          <h3>10. Contact Us</h3>

          <p>If you have any questions about this Privacy Policy or our privacy practices, please contact us:</p>
          <ul>
            <li><strong>Email:</strong> <?php echo !empty($site_email) ? $site_email : 'privacy@tnacare.com'; ?></li>
            <li><strong>Phone:</strong> <?php echo !empty($phone_number) ? $phone_number : '+255 XXX XXX XXX'; ?></li>
            <li><strong>Address:</strong> <?php echo !empty($physical_address) ? $physical_address : 'Dar es Salaam, Tanzania'; ?></li>
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