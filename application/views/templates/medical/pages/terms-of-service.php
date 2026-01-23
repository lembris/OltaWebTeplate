<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .terms-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .terms-hero::before {
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

  .terms-content {
    padding: 80px 0;
    background: white;
  }

  .terms-content h2 {
    color: var(--theme-primary);
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
  }

  .terms-content h3 {
    color: var(--theme-primary);
    font-weight: 600;
    margin: 2rem 0 1rem 0;
    font-size: 1.25rem;
  }

  .terms-content p {
    color: #64748b;
    line-height: 1.8;
    margin-bottom: 1rem;
  }

  .terms-content ul {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
  }

  .terms-content li {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 0.5rem;
  }

  .terms-contact {
    background: #f8fafc;
    padding: 3rem;
    border-radius: 16px;
    margin-top: 3rem;
    text-align: center;
  }

  .terms-contact h3 {
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .terms-contact p {
    color: #64748b;
    margin-bottom: 1.5rem;
  }

  .terms-contact .btn {
    background: var(--theme-primary);
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .terms-contact .btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
  }

  @media (max-width: 768px) {
    .terms-hero {
      padding: 80px 0 60px;
    }

    .terms-content {
      padding: 60px 0;
    }

    .terms-contact {
      padding: 2rem;
    }
  }
</style>

<!-- Page Header -->
<section class="terms-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="page-header" data-aos="fade-up">
          <h1>Terms of Service</h1>
          <p>Terms and conditions for using TNA CARE healthcare services</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Terms Content -->
<section class="terms-content">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10" data-aos="fade-up">

        <div class="content-section">
          <h2>Last Updated: <?php echo date('F j, Y'); ?></h2>

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
            <li>Travel arrangements are the patient's responsibility</li>
          </ul>

          <h3>5. Payment Terms</h3>

          <p>Payment for services is required according to the following terms:</p>
          <ul>
            <li>All fees are quoted in Tanzanian Shillings unless otherwise specified</li>
            <li>Payment is due at the time of service unless arranged otherwise</li>
            <li>Late payments may incur additional charges</li>
            <li>Refunds are processed according to our refund policy</li>
            <li>Insurance claims are the patient's responsibility to pursue</li>
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
            <li><strong>Email:</strong> <?php echo !empty($site_email) ? $site_email : 'legal@tnacare.com'; ?></li>
            <li><strong>Phone:</strong> <?php echo !empty($phone_number) ? $phone_number : '+255 XXX XXX XXX'; ?></li>
            <li><strong>Address:</strong> <?php echo !empty($physical_address) ? $physical_address : 'Dar es Salaam, Tanzania'; ?></li>
          </ul>

          <div class="terms-contact">
            <h3>Questions About Our Terms?</h3>
            <p>Contact our legal team for clarification on any terms or conditions.</p>
            <a href="<?php echo base_url('contact'); ?>" class="btn">Contact Us</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>