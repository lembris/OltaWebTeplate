<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .services-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .services-hero::before {
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
    margin: 0 auto;
    text-align: center;
  }

  .service-section {
    padding: 80px 0;
  }

  .service-section:nth-child(even) {
    background: #f8fafc;
  }

  .service-card {
    background: white;
    border-radius: 16px;
    padding: 2.5rem 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid #e2e8f0;
  }

  .service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    border-color: var(--theme-primary);
  }

  .service-icon-wrapper {
    width: 90px;
    height: 90px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
  }

  .service-card:hover .service-icon-wrapper {
    transform: scale(1.1);
  }

  .service-icon-wrapper i {
    font-size: 2.5rem;
    color: white;
  }

  .service-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .service-card p {
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 1.5rem;
  }

  .service-features {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem 0;
    text-align: left;
  }

  .service-features li {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    color: #475569;
    font-size: 0.95rem;
  }

  .service-features li i {
    color: #22c55e;
    font-size: 1.1rem;
    margin-top: 2px;
    flex-shrink: 0;
  }

  .service-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--theme-accent);
    color: white;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .service-cta:hover {
    background: var(--theme-primary);
    gap: 0.75rem;
  }

  .process-steps {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
    margin-top: 3rem;
  }

  .process-step {
    text-align: center;
    position: relative;
  }

  .process-step::after {
    content: '';
    position: absolute;
    top: 40px;
    right: -50%;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, var(--theme-primary), var(--theme-accent));
    opacity: 0.3;
  }

  .process-step:last-child::after {
    display: none;
  }

  .step-number {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 800;
    color: white;
    position: relative;
    z-index: 1;
  }

  .process-step h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.5rem;
  }

  .process-step p {
    color: #64748b;
    font-size: 0.9rem;
    margin: 0;
  }

  .stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
    padding: 3rem;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    border-radius: 20px;
    margin: 3rem 0;
  }

  .stat-item {
    text-align: center;
    color: white;
  }

  .stat-item .number {
    font-size: 3rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.5rem;
  }

  .stat-item .label {
    font-size: 0.9rem;
    opacity: 0.9;
  }

  .testimonial-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  }

  .testimonial-card .quote {
    font-size: 1.1rem;
    color: #475569;
    line-height: 1.8;
    font-style: italic;
    margin-bottom: 1.5rem;
  }

  .testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .testimonial-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .testimonial-avatar i {
    font-size: 1.5rem;
    color: white;
  }

  .testimonial-info h5 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.25rem;
  }

  .testimonial-info span {
    font-size: 0.85rem;
    color: #64748b;
  }

  .cta-box {
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    border-radius: 20px;
    padding: 4rem;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
  }

  .cta-box::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .cta-box::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
  }

  .cta-box h2 {
    font-size: 2.25rem;
    font-weight: 800;
    margin-bottom: 1rem;
    position: relative;
  }

  .cta-box p {
    font-size: 1.125rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto 2rem;
    position: relative;
  }

  .cta-box .btn {
    background: white;
    color: var(--theme-primary);
    padding: 1rem 2.5rem;
    font-weight: 600;
    border-radius: 50px;
    border: none;
    transition: all 0.3s ease;
  }

  .cta-box .btn:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  }

  @media (max-width: 992px) {
    .process-steps {
      grid-template-columns: repeat(2, 1fr);
      gap: 3rem;
    }

    .process-step::after {
      display: none;
    }

    .stats-row {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 768px) {
    .services-hero {
      padding: 80px 0 60px;
    }

    .page-header h1 {
      font-size: 2rem;
    }

    .service-section {
      padding: 60px 0;
    }

    .process-steps {
      grid-template-columns: 1fr;
      gap: 2rem;
    }

    .stats-row {
      grid-template-columns: 1fr 1fr;
      padding: 2rem;
    }

    .stat-item .number {
      font-size: 2rem;
    }

    .cta-box {
      padding: 3rem 2rem;
    }

    .cta-box h2 {
      font-size: 1.75rem;
    }
  }
</style>

<!-- Page Header -->
<section class="services-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="page-header" data-aos="fade-up">
          <h1>Our Healthcare Services</h1>
          <p>Comprehensive healthcare solutions designed to bridge the gap between communities and quality medical services across Tanzania, East and Central Africa.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Main Services Section -->
<section class="service-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-10 text-center" data-aos="fade-up">
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--theme-primary); margin-bottom: 1rem;">What We Offer</h2>
        <p style="color: #64748b; max-width: 600px; margin: 0 auto;">Integrated healthcare solutions combining digital innovation with on-ground outreach</p>
      </div>
    </div>
    <div class="row g-4">
      <?php if (!empty($medical_specialties)): ?>
        <?php foreach ($medical_specialties as $index => $specialty): ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo 100 + ($index * 100); ?>">
            <div class="service-card" id="<?php echo htmlspecialchars($specialty->slug); ?>">
              <div class="service-icon-wrapper">
                <?php if (!empty($specialty->icon)): ?>
                  <i class="bi <?php echo htmlspecialchars($specialty->icon); ?>"></i>
                <?php else: ?>
                  <i class="bi bi-heart-pulse"></i>
                <?php endif; ?>
              </div>
              <h3><?php echo htmlspecialchars($specialty->name); ?></h3>
              <p><?php echo htmlspecialchars($specialty->short_description ?? $specialty->description); ?></p>
              <?php if (!empty($specialty->features)): ?>
                <ul class="service-features">
                  <?php 
                    $features = json_decode($specialty->features);
                    if (is_array($features)) {
                      foreach (array_slice($features, 0, 4) as $feature):
                  ?>
                  <li><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($feature); ?></li>
                  <?php 
                      endforeach;
                    }
                  ?>
                </ul>
              <?php endif; ?>
              <?php 
                $cta_url = !empty($specialty->cta_url) ? $specialty->cta_url : 'contact';
                $cta_text = !empty($specialty->cta_text) ? $specialty->cta_text : 'Get Started';
                $cta_icon = !empty($specialty->cta_icon) ? $specialty->cta_icon : 'arrow-right';
              ?>
              <a href="<?php echo base_url($cta_url); ?>" class="service-cta"><?php echo htmlspecialchars($cta_text); ?> <i class="bi bi-<?php echo htmlspecialchars($cta_icon); ?>"></i></a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback to static services if no data in database -->
        <!-- Health Education -->
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="service-card" id="education">
            <div class="service-icon-wrapper">
              <i class="bi bi-mortarboard"></i>
            </div>
            <h3>Health Education</h3>
            <p>Empowering communities with reliable health information through digital media, workshops, and community outreach programs.</p>
            <ul class="service-features">
              <li><i class="bi bi-check-circle"></i> Digital health content creation</li>
              <li><i class="bi bi-check-circle"></i> Community health workshops</li>
              <li><i class="bi bi-check-circle"></i> School health programs</li>
              <li><i class="bi bi-check-circle"></i> Public health campaigns</li>
            </ul>
            <a href="<?php echo base_url('contact'); ?>" class="service-cta">Get Started <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>

        <!-- Medical Outreach -->
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="service-card" id="outreach">
            <div class="service-icon-wrapper">
              <i class="bi bi-people"></i>
            </div>
            <h3>Medical Outreach</h3>
            <p>Bringing healthcare directly to underserved communities through mobile clinics, screening camps, and treatment programs.</p>
            <ul class="service-features">
              <li><i class="bi bi-check-circle"></i> Mobile health clinics</li>
              <li><i class="bi bi-check-circle"></i> Health screening camps</li>
              <li><i class="bi bi-check-circle"></i> Vaccination programs</li>
              <li><i class="bi bi-check-circle"></i> Rural healthcare support</li>
            </ul>
            <a href="<?php echo base_url('contact'); ?>" class="service-cta">Get Started <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>

        <!-- Corporate Wellness -->
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="service-card" id="corporate">
            <div class="service-icon-wrapper">
              <i class="bi bi-briefcase"></i>
            </div>
            <h3>Corporate Wellness</h3>
            <p>Comprehensive wellness solutions for organizations focusing on employee health, mental wellbeing, and productivity.</p>
            <ul class="service-features">
              <li><i class="bi bi-check-circle"></i> Employee health assessments</li>
              <li><i class="bi bi-check-circle"></i> Mental health programs</li>
              <li><i class="bi bi-check-circle"></i> Workplace safety training</li>
              <li><i class="bi bi-check-circle"></i> Health insurance guidance</li>
            </ul>
            <a href="<?php echo base_url('contact'); ?>" class="service-cta">Get Started <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="service-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12" data-aos="fade-up">
        <div class="stats-row">
          <div class="stat-item">
            <div class="number">1M+</div>
            <div class="label">People Reached</div>
          </div>
          <div class="stat-item">
            <div class="number">50+</div>
            <div class="label">Hospital Partners</div>
          </div>
          <div class="stat-item">
            <div class="number">100+</div>
            <div class="label">Communities Served</div>
          </div>
          <div class="stat-item">
            <div class="number">5+</div>
            <div class="label">Years of Experience</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<section class="service-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-10 text-center" data-aos="fade-up">
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--theme-primary); margin-bottom: 1rem;">How It Works</h2>
        <p style="color: #64748b; max-width: 600px; margin: 0 auto;">Simple steps to access our healthcare services</p>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="process-steps" data-aos="fade-up">
          <div class="process-step">
            <div class="step-number">1</div>
            <h4>Contact Us</h4>
            <p>Reach out through our contact form, phone, or visit our office</p>
          </div>
          <div class="process-step">
            <div class="step-number">2</div>
            <h4>Consultation</h4>
            <p>Discuss your healthcare needs with our experienced team</p>
          </div>
          <div class="process-step">
            <div class="step-number">3</div>
            <h4>Custom Solution</h4>
            <p>Receive a tailored healthcare solution for your requirements</p>
          </div>
          <div class="process-step">
            <div class="step-number">4</div>
            <h4>Ongoing Support</h4>
            <p>Access continuous support and follow-up care services</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<?php if (!empty($testimonials)): ?>
<section class="service-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-10 text-center" data-aos="fade-up">
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--theme-primary); margin-bottom: 1rem;">What Our Clients Say</h2>
        <p style="color: #64748b; max-width: 600px; margin: 0 auto;">Real experiences from individuals and organizations we've served</p>
      </div>
    </div>
    <div class="row g-4">
      <?php foreach ($testimonials as $testimonial): ?>
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo rand(100, 300); ?>">
        <div class="testimonial-card">
          <p class="quote">"<?php echo htmlspecialchars($testimonial->content ?? $testimonial->message); ?>"</p>
          <div class="testimonial-author">
            <div class="testimonial-avatar">
              <i class="bi bi-person-fill"></i>
            </div>
            <div class="testimonial-info">
              <h5><?php echo htmlspecialchars($testimonial->name); ?></h5>
              <span><?php echo htmlspecialchars($testimonial->role ?? 'Client'); ?></span>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  </section>
<?php endif; ?>

<?php echo $this->load->view('templates/medical/sections/home_cta', [], TRUE); ?>
