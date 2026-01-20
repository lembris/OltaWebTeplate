<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .contact-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .contact-hero::before {
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

  .page-header {
    margin-bottom: 3rem;
  }

  .page-header h1 {
    font-size: 2.75rem;
    font-weight: 800;
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .page-header p {
    font-size: 1.125rem;
    color: #64748b;
    max-width: 700px;
  }

  .contact-section {
    padding: 80px 0;
  }

  .contact-section:nth-child(even) {
    background: #f8fafc;
  }

  .contact-info-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    height: 100%;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
  }

  .contact-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    border-color: var(--theme-primary);
  }

  .contact-icon-wrapper {
    width: 70px;
    height: 70px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .contact-icon-wrapper i {
    font-size: 1.75rem;
    color: white;
  }

  .contact-info-card h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.75rem;
  }

  .contact-info-card p {
    color: #64748b;
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
  }

  .contact-info-card a {
    color: var(--theme-accent);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
  }

  .contact-info-card a:hover {
    color: var(--theme-primary);
  }

  .contact-form-wrapper {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
  }

  .contact-form-wrapper h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.5rem;
  }

  .contact-form-wrapper > p {
    color: #64748b;
    margin-bottom: 2rem;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-group label {
    display: block;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
  }

  .form-group label .required {
    color: #ef4444;
  }

  .form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    font-size: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    transition: all 0.3s ease;
    background: #f8fafc;
  }

  .form-control:focus {
    outline: none;
    border-color: var(--theme-primary);
    background: white;
    box-shadow: 0 0 0 4px rgba(var(--theme-primary-rgb), 0.1);
  }

  textarea.form-control {
    resize: vertical;
    min-height: 150px;
  }

  .btn-submit {
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 1rem 2.5rem;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(var(--theme-primary-rgb), 0.3);
  }

  .map-wrapper {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  }

  .map-wrapper iframe {
    width: 100%;
    height: 450px;
    border: none;
  }

  .website_url {
    display: none;
  }

  .alert {
    padding: 1rem 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    font-weight: 500;
  }

  .alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
  }

  .alert-error {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
  }

  .faq-section {
    padding: 80px 0;
  }

  .faq-item {
    background: white;
    border-radius: 12px;
    margin-bottom: 1rem;
    border: 1px solid #e2e8f0;
    overflow: hidden;
  }

  .faq-question {
    padding: 1.25rem 1.5rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    color: var(--theme-primary);
    transition: background 0.3s ease;
  }

  .faq-question:hover {
    background: #f8fafc;
  }

  .faq-question i {
    transition: transform 0.3s ease;
  }

  .faq-item.active .faq-question i {
    transform: rotate(180deg);
  }

  .faq-answer {
    padding: 0 1.5rem;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
    color: #64748b;
    line-height: 1.7;
  }

  .faq-item.active .faq-answer {
    padding: 0 1.5rem 1.25rem;
    max-height: 500px;
  }

  @media (max-width: 768px) {
    .contact-hero {
      padding: 80px 0 60px;
    }

    .page-header h1 {
      font-size: 2rem;
    }

    .contact-section {
      padding: 60px 0;
    }

    .contact-form-wrapper {
      padding: 2rem;
    }

    .contact-form-wrapper h3 {
      font-size: 1.5rem;
    }
  }
</style>

<!-- Page Header -->
<section class="contact-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="page-header" data-aos="fade-up">
          <h1>Contact TNA CARE</h1>
          <p>Get in touch with us for healthcare inquiries, partnerships, or to schedule a consultation. We're here to help you access quality healthcare.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Info Section -->
<section class="contact-section">
  <div class="container">
    <div class="row g-4 mb-5">
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="contact-info-card">
          <div class="contact-icon-wrapper">
            <i class="bi bi-geo-alt"></i>
          </div>
          <h4>Our Location</h4>
          <p><?php echo isset($physical_address) ? htmlspecialchars($physical_address) : 'Dar es Salaam, Tanzania'; ?></p>
          <a href="https://maps.google.com" target="_blank">View on Map</a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="contact-info-card">
          <div class="contact-icon-wrapper">
            <i class="bi bi-telephone"></i>
          </div>
          <h4>Phone Number</h4>
          <p><a href="tel:<?php echo isset($phone_number) ? $phone_number : ''; ?>"><?php echo isset($phone_number) ? htmlspecialchars($phone_number) : '+255 700 000 000'; ?></a></p>
          <p class="text-muted small">Mon - Fri: 8AM - 5PM</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="contact-info-card">
          <div class="contact-icon-wrapper">
            <i class="bi bi-envelope"></i>
          </div>
          <h4>Email Address</h4>
          <p><a href="mailto:<?php echo isset($email_address) ? $email_address : ''; ?>"><?php echo isset($email_address) ? htmlspecialchars($email_address) : 'info@tnacare.co.tz'; ?></a></p>
          <p class="text-muted small">We respond within 24 hours</p>
        </div>
      </div>
    </div>

    <!-- Contact Form & Map -->
    <div class="row g-5">
      <div class="col-lg-6" data-aos="fade-right">
        <div class="contact-form-wrapper">
          <h3>Send Us a Message</h3>
          <p>Fill out the form below and we'll get back to you as soon as possible.</p>
          
          <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
          </div>
          <?php endif; ?>
          
          <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-error">
            <?php echo $this->session->flashdata('error'); ?>
          </div>
          <?php endif; ?>

          <?php echo form_open(base_url('contact/submit'), ['id' => 'contactForm']); ?>
          
          <!-- Honeypot field - hidden from real users -->
          <div class="website_url">
            <label for="website_url">Website</label>
            <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="full_name">Full Name <span class="required">*</span></label>
                <input type="text" class="form-control" id="full_name" name="full_name" required placeholder="Your full name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email_address">Email Address <span class="required">*</span></label>
                <input type="email" class="form-control" id="email_address" name="email_address" required placeholder="your@email.com">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="subject">Subject <span class="required">*</span></label>
            <select class="form-control" id="subject" name="subject" required>
              <option value="">Select a subject</option>
              <option value="General Inquiry">General Inquiry</option>
              <option value="Health Education">Health Education</option>
              <option value="Medical Outreach">Medical Outreach</option>
              <option value="Corporate Wellness">Corporate Wellness</option>
              <option value="Medical Tourism">Medical Tourism</option>
              <option value="Partnership">Partnership Opportunity</option>
              <option value="Other">Other</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="message">Message <span class="required">*</span></label>
            <textarea class="form-control" id="message" name="message" required placeholder="How can we help you?"></textarea>
          </div>
          
          <!-- Safari CAPTCHA -->
          <div class="form-group">
            <label>Security Check <span class="required">*</span></label>
            <div class="captcha-container" id="contactCaptcha">
              <p class="captcha-question" id="captchaQuestion">Loading question...</p>
              <input type="text" class="form-control" id="safari_answer" name="safari_answer" required placeholder="Type your answer">
              <p class="captcha-hint text-muted small mt-2" id="captchaHint"></p>
              <button type="button" class="btn btn-link p-0 small refresh-captcha" data-type="contact">Try Another Question</button>
            </div>
          </div>
          
          <button type="submit" class="btn-submit">
            <i class="bi bi-send"></i> Send Message
          </button>
          
          <?php echo form_close(); ?>
        </div>
      </div>
      
      <div class="col-lg-6" data-aos="fade-left">
        <div class="map-wrapper">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0!2d39.289!3d-6.812!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNDgnNDYuMCJTIDE5wrE1OCcwMC42JlI!5e0!3m2!1sen!2stz!4v1600000000000!5m2!1sen!2stz" 
                  allowfullscreen="" 
                  loading="lazy" 
                  referrerpolicy="no-referrer-when-downgrade"
                  title="TNA CARE Location">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-10 text-center" data-aos="fade-up">
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--theme-primary); margin-bottom: 1rem;">Frequently Asked Questions</h2>
        <p style="color: #64748b; max-width: 600px; margin: 0 auto;">Find answers to common questions about our services</p>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <?php if (!empty($contact_faqs)): ?>
          <?php foreach ($contact_faqs as $category => $faqs): ?>
            <?php if (!empty($category)): ?>
            <h4 style="color: var(--theme-primary); margin-bottom: 1.5rem; font-weight: 700;">
              <i class="bi bi-folder-open me-2"></i><?php echo htmlspecialchars($category); ?>
            </h4>
            <?php endif; ?>
            <?php foreach ($faqs as $index => $faq): ?>
            <div class="faq-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
              <div class="faq-question" onclick="toggleFaq(this)">
                <span><i class="bi bi-question-circle me-2" style="color: var(--theme-accent);"></i><?php echo htmlspecialchars($faq->question); ?></span>
                <i class="bi bi-chevron-down"></i>
              </div>
              <div class="faq-answer">
                <?php echo $faq->answer; ?>
              </div>
            </div>
            <?php endforeach; ?>
          <?php endforeach; ?>
        <?php else: ?>
        <div class="faq-item" data-aos="fade-up">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span>What services does TNA CARE offer?</span>
            <i class="bi bi-chevron-down"></i>
          </div>
          <div class="faq-answer">
            TNA CARE offers comprehensive healthcare services including health education programs, medical outreach initiatives, corporate wellness solutions, digital health platforms, medical tourism facilitation, and health media production.
          </div>
        </div>
        
        <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span>How can I book a consultation?</span>
            <i class="bi bi-chevron-down"></i>
          </div>
          <div class="faq-answer">
            You can book a consultation by filling out the contact form above, calling us directly, or sending us an email. Our team will respond within 24 hours.
          </div>
        </div>
        
        <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span>Do you offer corporate wellness programs?</span>
            <i class="bi bi-chevron-down"></i>
          </div>
          <div class="faq-answer">
            Yes! We provide customized corporate wellness solutions for businesses and organizations, including employee health assessments, mental health programs, and workplace safety training.
          </div>
        </div>
        
        <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span>What areas do you serve?</span>
            <i class="bi bi-chevron-down"></i>
          </div>
          <div class="faq-answer">
            TNA CARE serves communities across Tanzania and East Africa. Our partner hospital network extends internationally.
          </div>
        </div>
        
        <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span>How can my organization partner with TNA CARE?</span>
            <i class="bi bi-chevron-down"></i>
          </div>
          <div class="faq-answer">
            We welcome partnership opportunities with hospitals, NGOs, government agencies, and corporate entities. Please select "Partnership Opportunity" as the subject in our contact form.
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<script>
function toggleFaq(element) {
    const item = element.closest('.faq-item');
    const isActive = item.classList.contains('active');
    
    // Close all other items
    document.querySelectorAll('.faq-item').forEach(faq => {
        faq.classList.remove('active');
    });
    
    // Toggle current item
    if (!isActive) {
        item.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Load initial CAPTCHA question
    loadCaptchaQuestion('contact');
    
    // Handle CAPTCHA refresh
    document.querySelectorAll('.refresh-captcha').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var type = this.getAttribute('data-type');
            loadCaptchaQuestion(type);
        });
    });
    
    function loadCaptchaQuestion(type) {
        fetch(base_url + 'contact/refresh_captcha', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'type=' + type
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('captchaQuestion').textContent = data.question;
                document.getElementById('captchaHint').textContent = 'Hint: ' + data.hint;
                document.getElementById('safari_answer').value = '';
            } else {
                document.getElementById('captchaQuestion').textContent = data.message || 'Please try again';
                document.getElementById('captchaHint').textContent = '';
            }
        })
        .catch(error => {
            console.error('Error loading CAPTCHA:', error);
        });
    }
});
</script>
