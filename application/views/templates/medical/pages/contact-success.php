<?php
/**
 * Medical Template - Contact Success Page
 * 
 * Success message displayed after contact form submission.
 * Tailored for TNA CARE medical theme.
 */
?>

<style>
  .success-container {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
  }

  .success-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
  }

  .success-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 2rem;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 0.6s ease-out;
  }

  .success-icon i {
    font-size: 3rem;
    color: white;
  }

  @keyframes pulse {
    0% {
      transform: scale(0.8);
      opacity: 0;
    }
    100% {
      transform: scale(1);
      opacity: 1;
    }
  }

  .success-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .success-message {
    font-size: 1.1rem;
    color: #64748b;
    margin-bottom: 2rem;
    line-height: 1.6;
  }

  .details-section {
    background: #f8fafc;
    border-radius: 12px;
    padding: 2rem;
    margin: 2rem 0;
    border-left: 4px solid var(--theme-primary);
  }

  .detail-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e2e8f0;
  }

  .detail-row:last-child {
    border-bottom: none;
  }

  .detail-label {
    font-weight: 600;
    color: var(--theme-primary);
    flex: 0 0 150px;
  }

  .detail-value {
    color: #475569;
    word-break: break-word;
  }

  .next-steps {
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    color: white;
    border-radius: 12px;
    padding: 2rem;
    margin: 2rem 0;
  }

  .next-steps h5 {
    margin-bottom: 1rem;
    font-weight: 700;
  }

  .next-steps p {
    margin-bottom: 0;
    opacity: 0.95;
  }

  .action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
  }

  .btn-primary-medical {
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 1rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-primary-medical:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(var(--theme-primary-rgb), 0.3);
    color: white;
    text-decoration: none;
  }

  .btn-outline-medical {
    border: 2px solid var(--theme-primary);
    color: var(--theme-primary);
    background: white;
    padding: 0.875rem 1.75rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-outline-medical:hover {
    background: var(--theme-primary);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(var(--theme-primary-rgb), 0.2);
  }

  .alert-success-medical {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .alert-success-medical i {
    font-size: 1.5rem;
  }

  @media (max-width: 768px) {
    .success-container {
      padding: 60px 0 40px;
    }

    .success-card {
      padding: 1.5rem;
    }

    .success-title {
      font-size: 1.5rem;
    }

    .action-buttons {
      flex-direction: column;
    }

    .btn-primary-medical,
    .btn-outline-medical {
      width: 100%;
      justify-content: center;
    }
  }
</style>

<section class="success-container">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="success-card" data-aos="fade-up">

          <!-- Success Flash Message -->
          <?php $success = $this->session->flashdata('success'); ?>
          <?php if($success): ?>
          <div class="alert-success-medical">
            <i class="bi bi-check-circle-fill"></i>
            <span><?php echo $success; ?></span>
          </div>
          <?php endif; ?>

          <!-- Success Icon -->
          <div class="success-icon">
            <i class="bi bi-check-lg"></i>
          </div>

          <!-- Success Title -->
          <h1 class="success-title text-center">Message Received!</h1>

          <!-- Success Message -->
          <p class="success-message text-center">
            Thank you for contacting TNA CARE. We've successfully received your message and will review your inquiry right away. Our healthcare team is committed to providing you with the best support.
          </p>

          <!-- Submitted Details -->
          <?php if(isset($contact) && is_object($contact)): ?>
          <div class="details-section">
            <h5 style="color: var(--theme-primary); margin-bottom: 1.5rem; font-weight: 700;">
              <i class="bi bi-info-circle me-2"></i> Submission Summary
            </h5>
            
            <?php if(!empty($contact->name)): ?>
            <div class="detail-row">
              <span class="detail-label">Name</span>
              <span class="detail-value"><?php echo htmlspecialchars($contact->name); ?></span>
            </div>
            <?php endif; ?>

            <?php if(!empty($contact->email)): ?>
            <div class="detail-row">
              <span class="detail-label">Email</span>
              <span class="detail-value"><?php echo htmlspecialchars($contact->email); ?></span>
            </div>
            <?php endif; ?>

            <?php if(!empty($contact->subject)): ?>
            <div class="detail-row">
              <span class="detail-label">Subject</span>
              <span class="detail-value"><?php echo htmlspecialchars($contact->subject); ?></span>
            </div>
            <?php endif; ?>

            <?php if(!empty($contact->created_at)): ?>
            <div class="detail-row">
              <span class="detail-label">Submitted</span>
              <span class="detail-value"><?php echo date('F j, Y \a\t g:i A', strtotime($contact->created_at)); ?></span>
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <!-- Next Steps -->
          <div class="next-steps">
            <h5>
              <i class="bi bi-hourglass-split me-2"></i> What Happens Next?
            </h5>
            <p>
              Our healthcare team will review your inquiry and respond to your email within 24-48 business hours. If your matter is urgent, please don't hesitate to call us directly at <strong><?php echo isset($phone_number) ? $phone_number : '+255 759 399 919'; ?></strong>.
            </p>
          </div>

          <!-- Action Buttons -->
          <div class="action-buttons">
            <a href="<?php echo base_url(); ?>" class="btn-primary-medical">
              <i class="bi bi-house-fill"></i> Back to Home
            </a>
            <a href="<?php echo base_url('services'); ?>" class="btn-outline-medical">
              <i class="bi bi-heart-pulse"></i> Explore Services
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section style="padding: 80px 0; background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%); color: white; text-align: center;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up">
        <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">Looking to Learn More About Our Services?</h2>
        <p style="font-size: 1.1rem; margin-bottom: 2rem; opacity: 0.95;">
          While you wait for our response, explore our healthcare solutions and discover how TNA CARE can help you and your organization access quality healthcare.
        </p>
        <div class="action-buttons" style="justify-content: center;">
          <a href="<?php echo base_url('services'); ?>" style="background: white; color: var(--theme-primary); padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;">
            <i class="bi bi-heart-pulse"></i> View All Services
          </a>
          <a href="<?php echo base_url('about'); ?>" style="border: 2px solid white; color: white; background: transparent; padding: 0.875rem 1.75rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; margin-left: 1rem;">
            <i class="bi bi-info-circle"></i> About TNA CARE
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Add subtle animation on load
  document.addEventListener('DOMContentLoaded', function() {
    const successIcon = document.querySelector('.success-icon');
    if (successIcon) {
      successIcon.style.animation = 'pulse 0.6s ease-out';
    }
  });
</script>
