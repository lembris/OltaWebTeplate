<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .terms-hero {
    padding: 120px 0 80px;
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    position: relative;
  }

  .terms-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
  }

  .terms-hero .container {
    position: relative;
    z-index: 1;
  }

  .terms-hero h1 {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .terms-hero p {
    font-size: 1.25rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
  }

  .terms-content {
    padding: 80px 0;
    background: white;
  }

  .terms-content h2 {
    color: #1e3a8a;
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
  }

  .terms-content h3 {
    color: #1e3a8a;
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
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 3rem;
    border-radius: 16px;
    margin-top: 3rem;
    text-align: center;
    border: 1px solid #e2e8f0;
  }

  .terms-contact h3 {
    color: #1e3a8a;
    margin-bottom: 1rem;
  }

  .terms-contact p {
    color: #64748b;
    margin-bottom: 1.5rem;
  }

  .terms-contact .btn {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
  }

  .terms-contact .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(30, 58, 138, 0.3);
  }

  @media (max-width: 768px) {
    .terms-hero {
      padding: 80px 0 60px;
    }

    .terms-hero h1 {
      font-size: 2rem;
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
          <p>Terms and conditions for your safari adventure experience</p>
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

          <p>Welcome to Safari Adventure Tours. These Terms of Service ("Terms") govern your use of our safari tour services, website, mobile applications, and related services (collectively, the "Services"). By accessing or using our Services, you agree to be bound by these Terms.</p>

          <h3>1. Acceptance of Terms</h3>

          <p>By accessing and using Safari Adventure Tours services, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>

          <h3>2. Description of Services</h3>

          <p>Safari Adventure Tours provides safari and travel services including:</p>
          <ul>
            <li>Safari tour packages and itineraries</li>
            <li>Accommodation bookings and reservations</li>
            <li>Transportation and transfer services</li>
            <li>Guided tours and wildlife experiences</li>
            <li>Travel consultation and planning</li>
            <li>Emergency assistance during travel</li>
          </ul>

          <h3>3. Booking and Reservations</h3>

          <h4>Booking Process</h4>
          <p>When booking safari tours, you agree to:</p>
          <ul>
            <li>Provide accurate and complete information</li>
            <li>Review and accept tour itineraries and conditions</li>
            <li>Make payments according to the specified schedule</li>
            <li>Notify us immediately of any changes or special requirements</li>
          </ul>

          <h4>Cancellation Policy</h4>
          <ul>
            <li>Cancellations must be made in writing</li>
            <li>Refund amounts depend on cancellation timing</li>
            <li>Force majeure events may affect cancellation terms</li>
            <li>Some bookings may be non-refundable</li>
          </ul>

          <h3>4. Payment Terms</h3>

          <p>Payment for safari services is required according to the following terms:</p>
          <ul>
            <li>All prices are quoted in USD unless otherwise specified</li>
            <li>Deposit payment is required to confirm bookings</li>
            <li>Full payment is due 30 days before tour departure</li>
            <li>Late payments may result in booking cancellation</li>
            <li>Accepted payment methods include credit cards and bank transfers</li>
          </ul>

          <h3>5. Travel Requirements and Responsibilities</h3>

          <h4>Travel Documents</h4>
          <ul>
            <li>Valid passport with minimum 6 months validity</li>
            <li>Appropriate visas for Tanzania and transit countries</li>
            <li>Travel insurance covering safari activities</li>
            <li>Vaccination certificates as required</li>
          </ul>

          <h4>Traveler Responsibilities</h4>
          <ul>
            <li>Comply with all local laws and regulations</li>
            <li>Respect wildlife and natural environments</li>
            <li>Follow guide instructions for safety</li>
            <li>Report any health or safety concerns immediately</li>
          </ul>

          <h3>6. Health and Safety</h3>

          <p>Safari activities involve certain risks. By participating, you acknowledge:</p>
          <ul>
            <li>Safari activities involve inherent risks</li>
            <li>You are physically fit for safari participation</li>
            <li>You understand emergency procedures</li>
            <li>You have appropriate travel insurance</li>
          </ul>

          <p>Safari Adventure Tours takes reasonable measures to ensure safety but cannot guarantee absolute safety in wilderness areas.</p>

          <h3>7. Changes and Modifications</h3>

          <p>Safari itineraries may be modified due to:</p>
          <ul>
            <li>Weather conditions and seasonal changes</li>
            <li>Wildlife behavior and migration patterns</li>
            <li>Transportation schedules and availability</li>
            <li>Local conditions and unforeseen circumstances</li>
          </ul>

          <p>We will make reasonable efforts to maintain the quality and experience of your safari.</p>

          <h3>8. Limitation of Liability</h3>

          <p>Safari Adventure Tours is not liable for:</p>
          <ul>
            <li>Loss or damage to personal property</li>
            <li>Delays caused by weather or transportation issues</li>
            <li>Changes in wildlife viewing opportunities</li>
            <li>Medical emergencies or health issues</li>
          </ul>

          <p>Our liability is limited to the amount paid for safari services.</p>

          <h3>9. Privacy and Data Protection</h3>

          <p>Your privacy is important to us. Our collection and use of personal information is governed by our Privacy Policy, which is incorporated into these Terms by reference. By using our services, you consent to the collection and use of your information as outlined in our Privacy Policy.</p>

          <h3>10. Termination of Services</h3>

          <p>Either party may terminate safari services with written notice. Safari Adventure Tours reserves the right to terminate services for:</p>
          <ul>
            <li>Violation of these terms</li>
            <li>Non-payment of fees</li>
            <li>Unsafe or inappropriate behavior</li>
            <li>Legal or regulatory requirements</li>
          </ul>

          <h3>11. Governing Law</h3>

          <p>These Terms are governed by the laws of Tanzania. Any disputes arising from these terms will be resolved through the courts of Tanzania.</p>

          <h3>12. Changes to Terms</h3>

          <p>We reserve the right to modify these Terms at any time. Changes will be effective immediately upon posting on our website. Continued use of our services constitutes acceptance of the modified terms.</p>

          <h3>13. Contact Information</h3>

          <p>For questions about these Terms of Service, please contact us:</p>
          <ul>
            <li><strong>Email:</strong> <?php echo !empty($site_email) ? $site_email : 'legal@safariadventure.com'; ?></li>
            <li><strong>Phone:</strong> <?php echo !empty($phone_number) ? $phone_number : '+255 XXX XXX XXX'; ?></li>
            <li><strong>Address:</strong> <?php echo !empty($physical_address) ? $physical_address : 'Arusha, Tanzania'; ?></li>
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