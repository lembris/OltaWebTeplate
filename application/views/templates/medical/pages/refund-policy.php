<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .refund-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .refund-hero::before {
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

  .refund-content {
    padding: 80px 0;
    background: white;
  }

  .refund-content h2 {
    color: var(--theme-primary);
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
  }

  .refund-content h3 {
    color: var(--theme-primary);
    font-weight: 600;
    margin: 2rem 0 1rem 0;
    font-size: 1.25rem;
  }

  .refund-content p {
    color: #64748b;
    line-height: 1.8;
    margin-bottom: 1rem;
  }

  .refund-content ul {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
  }

  .refund-content li {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 0.5rem;
  }

  .refund-contact {
    background: #f8fafc;
    padding: 3rem;
    border-radius: 16px;
    margin-top: 3rem;
    text-align: center;
  }

  .refund-contact h3 {
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .refund-contact p {
    color: #64748b;
    margin-bottom: 1.5rem;
  }

  .refund-contact .btn {
    background: var(--theme-primary);
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .refund-contact .btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
  }

  @media (max-width: 768px) {
    .refund-hero {
      padding: 80px 0 60px;
    }

    .refund-content {
      padding: 60px 0;
    }

    .refund-contact {
      padding: 2rem;
    }
  }
</style>

<!-- Page Header -->
<section class="refund-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="page-header" data-aos="fade-up">
          <h1>Refund Policy</h1>
          <p>Understanding our refund terms for healthcare services</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Refund Content -->
<section class="refund-content">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10" data-aos="fade-up">

        <div class="content-section">
          <h2>Last Updated: <?php echo date('F j, Y'); ?></h2>

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
            <li><strong>Email:</strong> <?php echo !empty($site_email) ? $site_email : 'refunds@tnacare.com'; ?></li>
            <li><strong>Phone:</strong> <?php echo !empty($phone_number) ? $phone_number : '+255 XXX XXX XXX'; ?></li>
            <li><strong>Address:</strong> <?php echo !empty($physical_address) ? $physical_address : 'Dar es Salaam, Tanzania'; ?></li>
          </ul>

          <div class="refund-contact">
            <h3>Need a Refund?</h3>
            <p>Contact our billing department to initiate a refund request.</p>
            <a href="<?php echo base_url('contact'); ?>" class="btn">Contact Us</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>