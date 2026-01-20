<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  /* Featured Expertises Section */
  .featured-expertises {
    padding: 80px 0;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
  }

  .expertise-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    position: relative;
    height: 100%;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .expertise-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(var(--theme-primary-rgb), 0.12);
    border-color: color-mix(in srgb, var(--theme-primary), white 70%);
  }

  .expertise-icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
    transition: transform 0.3s ease;
  }

  .expertise-card:hover .expertise-icon-wrapper {
    transform: scale(1.1);
  }

  .expertise-icon-wrapper i {
    font-size: 1.75rem;
    color: white;
  }

  .expertise-content h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.75rem;
  }

  .expertise-content p {
    color: #64748b;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1rem;
  }

  .expertise-features {
    list-style: none;
    padding: 0;
    margin: 0 0 1.25rem 0;
  }

  .expertise-features li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #475569;
    margin-bottom: 0.5rem;
    padding: 0.25rem 0;
  }

  .expertise-features li i {
    color: #22c55e;
    font-size: 1rem;
  }

  .expertise-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--theme-accent);
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .expertise-link:hover {
    color: var(--theme-primary);
    gap: 0.75rem;
  }

  .expertise-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
  }

  .expertise-badge span {
    background: linear-gradient(135deg, #dbeafe, #e0e7ff);
    color: var(--theme-primary);
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* Simple Service Card (in Services section) */
  .service-card-simple {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
  }

  .service-card-simple:hover {
    transform: translateX(8px);
    box-shadow: 0 8px 24px rgba(var(--theme-primary-rgb), 0.1);
    border-color: color-mix(in srgb, var(--theme-primary), white 70%);
  }

  .service-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .service-icon i {
    font-size: 1.25rem;
    color: white;
  }

  .service-info h5 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.25rem;
  }

  .service-info span {
    font-size: 0.85rem;
    color: #64748b;
  }

  @media (max-width: 768px) {
    .featured-expertises {
      padding: 60px 0;
    }
    
    .expertise-card {
      margin-bottom: 1rem;
    }

    .expertise-card-simple {
      margin-bottom: 0.75rem;
    }
  }
</style>

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content">
              <div class="trust-badges mb-4" data-aos="fade-right" data-aos-delay="200">
                <div class="badge-item">
                  <i class="bi bi-shield-check"></i>
                  <span>Registered & Licensed</span>
                </div>
                <div class="badge-item">
                  <i class="bi bi-people"></i>
                  <span>Community Centered</span>
                </div>
              </div>

              <h1 data-aos="fade-right" data-aos-delay="300">
                <span class="highlight">Connecting Communities</span> to Better Health
              </h1>

              <p class="hero-description" data-aos="fade-right" data-aos-delay="400">
                TIBA NA AFYA CARE (TNA CARE) is a Tanzanian-registered health service company dedicated to bridging the gap between individuals and quality healthcare through education, consultation, and strategic partnerships.
              </p>

              <div class="hero-stats mb-4" data-aos="fade-right" data-aos-delay="500">
                <div class="stat-item">
                  <h3><span data-purecounter-start="0" data-purecounter-end="1" data-purecounter-duration="2" class="purecounter"></span>M</h3>
                  <p>People Impacted</p>
                </div>
                <div class="stat-item">
                  <h3><span data-purecounter-start="0" data-purecounter-end="28000" data-purecounter-duration="2" class="purecounter"></span>+</h3>
                  <p>Subscribers</p>
                </div>
                <div class="stat-item">
                  <h3><span data-purecounter-start="0" data-purecounter-end="50" data-purecounter-duration="2" class="purecounter"></span>+</h3>
                  <p>Partnerships</p>
                </div>
              </div>

              <div class="hero-actions" data-aos="fade-right" data-aos-delay="600">
                <a href="<?php echo base_url('partners'); ?>" class="btn btn-primary">Partner With Us</a>
                <?php if (!empty($youtube)): ?> 
                <a href="<?php echo $youtube; ?>" class="btn btn-outline glightbox">
                  <i class="bi bi-youtube me-2"></i>
                  Visit Our Channel
                </a>
                <?php endif; ?>
              </div>

              <div class="emergency-contact" data-aos="fade-right" data-aos-delay="700">
                <div class="emergency-icon">
                  <i class="bi bi-telephone-fill"></i>
                </div>
                 <?php if (!empty($phone_number)): ?>    
                  <div class="emergency-info">
                    <small>Need Health Assistance?</small>
                    <strong><a href="tel:<?php echo $phone_number; ?>"><?php echo $phone_number; ?></a></strong>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="hero-visual" data-aos="fade-left" data-aos-delay="400">
              <div class="main-image">
                <img src="<?php echo base_url('assets/templates/medical/img/health/tna-female-black-doctor.png'); ?>" alt="TNA CARE Community Health Outreach" class="img-fluid">
                <div class="floating-card appointment-card">
                  <div class="card-icon">
                    <i class="bi bi-calendar-check"></i>
                  </div>
                  <div class="card-content">
                    <h6>Health & Medical</h6>
                    <p>Solutions</p>
                    <small>Access trusted health education, outreach, </br>and care support across Tanzania</small>
                  </div>
                </div>
                <div class="floating-card rating-card">
                  <div class="card-content">
                    <div class="rating-stars">
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-half"></i>
                    </div>
                    <h6>4.8/5</h6>
                    <small>Community Trust</small>
                  </div>
                </div>
              </div>
              <div class="background-elements">
                <div class="element element-1"></div>
                <div class="element element-2"></div>
                <div class="element element-3"></div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section>

    <!-- Home About Section -->
    <section id="home-about" class="home-about section">

      <div class="container section-title" data-aos="fade-up">
        <h2>About Us</h2>
        <p>We bridge the gap between communities and quality medical services with comprehensive healthcare solutions.</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
            <div class="about-content">
              <h2 class="section-heading">Simplifying Access to Quality Healthcare</h2>
              <p class="lead-text">TNA CARE began as a health media initiative to close the gap between reliable health information and underserved communities. We've evolved into a multi-service healthcare facilitation company trusted by individuals, corporates, NGOs, and government agencies.</p>

              <p>Our integrated model combines digital media, direct patient outreach, corporate wellness programs, and innovative digital health solutions to address public health challenges across Tanzania, East and Central Africa, and beyond.</p>

              <div class="cta-section">
                <a href="<?php echo base_url('about'); ?>" class="btn-primary">Learn More About Us</a>
              </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="about-visual">
              <div class="main-image">
                <img src="<?php echo base_url('assets/templates/medical/img/health/tna-male-and-female-black-doctors-wod-round.png'); ?>" alt="TNA CARE Medical Outreach" class="img-fluid">
              </div>
              <div class="floating-card">
                <div class="card-content">
                  <div class="icon">
                    <i class="bi bi-heart-pulse"></i>
                  </div>
                  <div class="card-text">
                    <h4>Community Outreach</h4>
                    <p>Serving urban and rural areas</p>
                  </div>
                </div>
              </div>
              <div class="experience-badge">
                <div class="badge-content">
                  <span class="years">5+</span>
                  <span class="text">Years of Trusted Service</span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section>

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Our Services</h2>
        <p>Comprehensive healthcare solutions that bridge the gap between communities and quality medical services</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-0">

          <div class="col-lg-8" data-aos="fade-right" data-aos-delay="200">
            <div class="featured-service-main">
              <div class="service-image-wrapper">
                <img src="<?php echo base_url('assets/templates/medical/img/health/tna-digital-health.png'); ?>" alt="TNA CARE Digital Health Education" class="img-fluid" loading="lazy">
                <div class="service-overlay">
                  <div class="service-badge">
                    <i class="bi bi-play-btn"></i>
                    <span>Digital Content</span>
                  </div>
                </div>
              </div>
              <div class="service-details">
                <h2>Integrated Health Solutions</h2>
                <p>We combine digital innovation with on-ground outreach to deliver impactful health education and services across diverse communities in Tanzania and beyond.</p>
                <a href="<?php echo base_url('services'); ?>" class="main-cta">Explore Our Services</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-left" data-aos-delay="300">
            <div class="services-sidebar">
              <?php if (!empty($medical_specialties)): ?>
                <?php foreach (array_slice($medical_specialties, 0, 3) as $specialty): ?>
                  <div class="service-item" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-icon-wrapper">
                      <i class="bi bi-capsule"></i>
                    </div>
                    <div class="service-info">
                      <h4><?php echo htmlspecialchars($specialty->name); ?></h4>
                      <p><?php echo htmlspecialchars($specialty->short_description ?? 'TNA CARE service'); ?></p>
                      <a href="<?php echo base_url('services#' . $specialty->slug); ?>" class="service-link">Learn More</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
              <div class="service-item" data-aos="fade-up" data-aos-delay="400">
                <div class="service-icon-wrapper">
                  <i class="bi bi-capsule"></i>
                </div>
                <div class="service-info">
                  <h4>Health Education</h4>
                  <p>Digital and physical health awareness programs to enhance public health literacy.</p>
                  <a href="<?php echo base_url('services#education'); ?>" class="service-link">Learn More</a>
                </div>
              </div>

              <div class="service-item" data-aos="fade-up" data-aos-delay="500">
                <div class="service-icon-wrapper">
                  <i class="bi bi-bandaid"></i>
                </div>
                <div class="service-info">
                  <h4>Medical Outreach</h4>
                  <p>Mobile screening and treatment camps in schools, communities, and hospitals.</p>
                  <a href="<?php echo base_url('services#outreach'); ?>" class="service-link">Learn More</a>
                </div>
              </div>

              <div class="service-item" data-aos="fade-up" data-aos-delay="600">
                <div class="service-icon-wrapper">
                  <i class="bi bi-activity"></i>
                </div>
                <div class="service-info">
                  <h4>Corporate Wellness</h4>
                  <p>Customized wellness and mental health solutions for companies and institutions.</p>
                  <a href="<?php echo base_url('services#corporate'); ?>" class="service-link">Learn More</a>
                </div>
              </div>
              <?php endif; ?>

            </div>
          </div>

        </div>

      </div>

    </section>

    <!-- Featured Expertises Section -->
    <section id="featured-expertises" class="featured-expertises section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Our Medical Expertise</h2>
        <p>Access world-class medical expertise across comprehensive specialties through our network of partner hospitals in Tanzania and internationally</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <?php if (!empty($featured_expertises)): ?>
        <div class="row g-4">
          <?php foreach ($featured_expertises as $index => $expertise): ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo 100 + ($index * 50); ?>">
            <div class="expertise-card">
              <div class="expertise-icon-wrapper">
                <?php if (!empty($expertise->icon)): ?>
                <i class="bi <?php echo htmlspecialchars($expertise->icon); ?>"></i>
                <?php else: ?>
                <i class="bi bi-heart-pulse"></i>
                <?php endif; ?>
              </div>
              <div class="expertise-content">
                <h4><?php echo htmlspecialchars($expertise->name); ?></h4>
                <p><?php echo htmlspecialchars($expertise->short_description); ?></p>
                <?php if (!empty($expertise->features)): ?>
                <ul class="expertise-features">
                  <?php 
                    $features = json_decode($expertise->features);
                    if (is_array($features)) {
                      foreach (array_slice($features, 0, 3) as $feature):
                  ?>
                  <li><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($feature); ?></li>
                  <?php 
                      endforeach;
                    }
                  ?>
                </ul>
                <?php endif; ?>
                <a href="<?php echo base_url('expertise/' . $expertise->slug); ?>" class="expertise-link">
                  Learn More <i class="bi bi-arrow-right"></i>
                </a>
              </div>
              <div class="expertise-badge">
                <span><?php echo htmlspecialchars(ucfirst($expertise->category)); ?></span>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="row g-4">
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="expertise-card">
              <div class="expertise-icon-wrapper">
                <i class="bi bi-heart-pulse"></i>
              </div>
              <div class="expertise-content">
                <h4>Cardiology</h4>
                <p>Diagnosis and treatment of heart and blood vessel conditions</p>
                <ul class="expertise-features">
                  <li><i class="bi bi-check-circle"></i> ECG & Stress Testing</li>
                  <li><i class="bi bi-check-circle"></i> Echocardiography</li>
                  <li><i class="bi bi-check-circle"></i> Heart Failure Management</li>
                </ul>
                <a href="<?php echo base_url('expertise/cardiology'); ?>" class="expertise-link">Learn More <i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="expertise-badge"><span>Cardiac</span></div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
            <div class="expertise-card">
              <div class="expertise-icon-wrapper">
                <i class="bi bi-heart"></i>
              </div>
              <div class="expertise-content">
                <h4>Cardiac Surgery</h4>
                <p>Surgical procedures to treat heart conditions and diseases</p>
                <ul class="expertise-features">
                  <li><i class="bi bi-check-circle"></i> Coronary Artery Bypass</li>
                  <li><i class="bi bi-check-circle"></i> Valve Repair/Replacement</li>
                  <li><i class="bi bi-check-circle"></i> Minimally Invasive Surgery</li>
                </ul>
                <a href="<?php echo base_url('expertise/cardiac-surgery'); ?>" class="expertise-link">Learn More <i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="expertise-badge"><span>Surgical</span></div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="expertise-card">
              <div class="expertise-icon-wrapper">
                <i class="bi bi-person-arms-up"></i>
              </div>
              <div class="expertise-content">
                <h4>Orthopaedic Surgery</h4>
                <p>Treatment for bone, joint, and muscle conditions</p>
                <ul class="expertise-features">
                  <li><i class="bi bi-check-circle"></i> Total Joint Replacement</li>
                  <li><i class="bi bi-check-circle"></i> Sports Medicine</li>
                  <li><i class="bi bi-check-circle"></i> Fracture Care</li>
                </ul>
                <a href="<?php echo base_url('expertise/orthopaedic-surgery'); ?>" class="expertise-link">Learn More <i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="expertise-badge"><span>Orthopedic</span></div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
            <div class="expertise-card">
              <div class="expertise-icon-wrapper">
                <i class="bi bi-droplet-half"></i>
              </div>
              <div class="expertise-content">
                <h4>Kidney Transplant</h4>
                <p>Surgical replacement of a diseased kidney with a healthy one</p>
                <ul class="expertise-features">
                  <li><i class="bi bi-check-circle"></i> Pre-transplant Evaluation</li>
                  <li><i class="bi bi-check-circle"></i> Living Donor Transplant</li>
                  <li><i class="bi bi-check-circle"></i> Post-transplant Care</li>
                </ul>
                <a href="<?php echo base_url('expertise/kidney-transplant'); ?>" class="expertise-link">Learn More <i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="expertise-badge"><span>Transplant</span></div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="expertise-card">
              <div class="expertise-icon-wrapper">
                <i class="bi bi-brain"></i>
              </div>
              <div class="expertise-content">
                <h4>Neurology</h4>
                <p>Diagnosis and treatment of disorders of the nervous system</p>
                <ul class="expertise-features">
                  <li><i class="bi bi-check-circle"></i> Stroke Care</li>
                  <li><i class="bi bi-check-circle"></i> Epilepsy Management</li>
                  <li><i class="bi bi-check-circle"></i> Neurodiagnostics</li>
                </ul>
                <a href="<?php echo base_url('expertise/neurology'); ?>" class="expertise-link">Learn More <i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="expertise-badge"><span>Specialized</span></div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
            <div class="expertise-card">
              <div class="expertise-icon-wrapper">
                <i class="bi bi-eye"></i>
              </div>
              <div class="expertise-content">
                <h4>Ophthalmology</h4>
                <p>Diagnosis and treatment of eye disorders and vision care</p>
                <ul class="expertise-features">
                  <li><i class="bi bi-check-circle"></i> Cataract Surgery</li>
                  <li><i class="bi bi-check-circle"></i> LASIK & Refractive Surgery</li>
                  <li><i class="bi bi-check-circle"></i> Glaucoma Treatment</li>
                </ul>
                <a href="<?php echo base_url('expertise/ophthalmology'); ?>" class="expertise-link">Learn More <i class="bi bi-arrow-right"></i></a>
              </div>
              <div class="expertise-badge"><span>Specialized</span></div>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="400">
          <a href="<?php echo base_url('expertise'); ?>" class="btn btn-primary">
            View All Expertises <i class="bi bi-arrow-right ms-2"></i>
          </a>
        </div>
      </div>

    </section>

    <?php echo $this->load->view('templates/medical/sections/core_values', [], TRUE); ?>

    <?php if (!empty($testimonials)): ?>
    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <div class="container section-title" data-aos="fade-up">
        <h2>What Our Patients Say</h2>
        <p>Real stories from people who have experienced our healthcare services</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper init-swiper">
          <div class="swiper-config" style="display: none;">
            {
              "slidesPerView": 1,
              "spaceBetween": 30,
              "loop": true,
              "pagination": {
                "el": ".swiper-pagination",
                "clickable": true
              },
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1
                },
                "768": {
                  "slidesPerView": 2
                },
                "992": {
                  "slidesPerView": 3
                }
              }
            }
          </div>
          <div class="swiper-wrapper">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row gy-4 justify-content-center">
                  <div class="col-lg-10">
                    <div class="testimonial-content">
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        <?php echo htmlspecialchars($testimonial->content ?? $testimonial->message); ?>
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                      <h3><?php echo htmlspecialchars($testimonial->name); ?></h3>
                      <h4><?php echo htmlspecialchars($testimonial->role ?? 'Patient'); ?></h4>
                      <div class="stars">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                        <i class="bi bi-star-fill"></i>
                        <?php endfor; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>

    </section>
    <?php endif; ?>

    <!-- Partners Section -->
    <section id="partners" class="partners section">

      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-lg-8 text-center" data-aos="fade-up">
            <span class="section-badge">Healthcare Network</span>
            <h2 class="section-heading">Our Partner Hospitals</h2>
            <p class="section-subtitle">We collaborate with leading healthcare institutions in Tanzania and around the world to provide comprehensive medical services through our extensive network of partners.</p>
          </div>
        </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="partners-tabs mb-5" data-aos="fade-up" data-aos-delay="200">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="tabs-wrapper">
                <div class="nav nav-tabs hospital-tabs" id="hospitalTabs" role="tablist">
                  <button class="nav-link active" id="tanzanian-tab" data-bs-toggle="tab" data-bs-target="#tanzanian-hospitals" type="button" role="tab" aria-controls="tanzanian-hospitals" aria-selected="true">
                    <span class="flag-icon"><i class="bi bi-map"></i></span>
                    <span>Tanzanian Hospitals</span>
                  </button>
                  <button class="nav-link" id="international-tab" data-bs-toggle="tab" data-bs-target="#international-hospitals" type="button" role="tab" aria-controls="international-hospitals" aria-selected="false">
                    <span class="flag-icon"><i class="bi bi-globe"></i></span>
                    <span>International Hospitals</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="tab-content" id="hospitalTabsContent">

          <div class="tab-pane fade show active" id="tanzanian-hospitals" role="tabpanel" aria-labelledby="tanzanian-tab">
            <?php if (!empty($tz_partners)): ?>
            <div class="partners-carousel-wrapper mb-5">
              <div class="partners-carousel partners-carousel-right">
                <div class="partners-track">
                  <?php foreach ($tz_partners as $partner): ?>
                  <div class="partners-slide">
                    <div class="partner-logo-card">
                      <div class="partner-logo-wrapper">
                        <?php if (!empty($partner->logo)): ?>
                        <img src="<?php echo base_url('assets/img/partners/' . $partner->logo); ?>" alt="<?php echo htmlspecialchars($partner->name); ?>" class="partner-logo-img">
                        <?php else: ?>
                        <i class="bi bi-hospital partner-icon-large"></i>
                        <?php endif; ?>
                      </div>
                      <div class="partner-info">
                        <h5><?php echo htmlspecialchars($partner->name); ?></h5>
                        <p class="partner-type">Tanzania</p>
                      </div>
                      <div class="partner-badge tz-badge"><i class="bi bi-geo-alt"></i></div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

            <div class="partners-details-grid">
              <div class="row g-4" data-aos="fade-up" data-aos-delay="300">
                <?php foreach ($tz_partners as $partner): ?>
                <div class="col-lg-4 col-md-6">
                  <div class="hospital-detail-card">
                    <div class="hospital-header">
                      <div class="hospital-icon"><i class="bi bi-hospital"></i></div>
                      <h4><?php echo htmlspecialchars($partner->name); ?></h4>
                    </div>
                    <p class="hospital-description"><?php echo htmlspecialchars($partner->short_description ?? 'Healthcare partner institution in Tanzania.'); ?></p>
                    <div class="hospital-tag">
                      <span><i class="bi bi-geo-alt"></i> Tanzania</span>
                      <?php if (!empty($partner->country)): ?>
                      <span><i class="bi bi-star"></i> <?php echo htmlspecialchars($partner->country); ?></span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php else: ?>
            <div class="partners-carousel-wrapper mb-5">
              <div class="partners-carousel partners-carousel-right">
                <div class="partners-track">
                  <div class="partners-slide">
                    <div class="partner-logo-card">
                      <div class="partner-logo-wrapper">
                        <i class="bi bi-hospital partner-icon-large"></i>
                      </div>
                      <div class="partner-info">
                        <h5>Muhimbili National Hospital</h5>
                        <p class="partner-type">Tanzania</p>
                      </div>
                      <div class="partner-badge tz-badge"><i class="bi bi-geo-alt"></i></div>
                    </div>
                  </div>
                  <div class="partners-slide">
                    <div class="partner-logo-card">
                      <div class="partner-logo-wrapper">
                        <i class="bi bi-hospital partner-icon-large"></i>
                      </div>
                      <div class="partner-info">
                        <h5>Kilimanjaro Christian Medical Centre</h5>
                        <p class="partner-type">Tanzania</p>
                      </div>
                      <div class="partner-badge tz-badge"><i class="bi bi-geo-alt"></i></div>
                    </div>
                  </div>
                  <div class="partners-slide">
                    <div class="partner-logo-card">
                      <div class="partner-logo-wrapper">
                        <i class="bi bi-heart-pulse partner-icon-large"></i>
                      </div>
                      <div class="partner-info">
                        <h5>JK Cardiac Institute</h5>
                        <p class="partner-type">Tanzania</p>
                      </div>
                      <div class="partner-badge tz-badge"><i class="bi bi-geo-alt"></i></div>
                    </div>
                  </div>
                  <div class="partners-slide">
                    <div class="partner-logo-card">
                      <div class="partner-logo-wrapper">
                        <i class="bi bi-hospital partner-icon-large"></i>
                      </div>
                      <div class="partner-info">
                        <h5>Bugando Medical Centre</h5>
                        <p class="partner-type">Tanzania</p>
                      </div>
                      <div class="partner-badge tz-badge"><i class="bi bi-geo-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="partners-details-grid">
              <div class="row g-4" data-aos="fade-up" data-aos-delay="300">
                <div class="col-lg-4 col-md-6">
                  <div class="hospital-detail-card">
                    <div class="hospital-header">
                      <div class="hospital-icon"><i class="bi bi-hospital"></i></div>
                      <h4>Muhimbili National Hospital</h4>
                    </div>
                    <p class="hospital-description">National referral hospital offering comprehensive medical services in Dar es Salaam.</p>
                    <div class="hospital-tag">
                      <span><i class="bi bi-geo-alt"></i> Tanzania</span>
                      <span><i class="bi bi-star"></i> Referral Hospital</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <div class="hospital-detail-card">
                    <div class="hospital-header">
                      <div class="hospital-icon"><i class="bi bi-hospital"></i></div>
                      <h4>Kilimanjaro Christian Medical Centre</h4>
                    </div>
                    <p class="hospital-description">Regional referral hospital in Moshi providing specialized healthcare services.</p>
                    <div class="hospital-tag">
                      <span><i class="bi bi-geo-alt"></i> Tanzania</span>
                      <span><i class="bi bi-star"></i> Specialized Care</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <div class="hospital-detail-card">
                    <div class="hospital-header">
                      <div class="hospital-icon"><i class="bi bi-activity"></i></div>
                      <h4>Jakaya Kikwete Cardiac Institute</h4>
                    </div>
                    <p class="hospital-description">Tanzania's specialized cardiac center with advanced heart care treatments.</p>
                    <div class="hospital-tag">
                      <span><i class="bi bi-geo-alt"></i> Tanzania</span>
                      <span><i class="bi bi-star"></i> Cardiac Specialists</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>

          <div class="tab-pane fade" id="international-hospitals" role="tabpanel" aria-labelledby="international-tab">
            <?php if (!empty($int_partners)): ?>
            <div class="partners-carousel-wrapper mb-5">
              <div class="partners-carousel partners-carousel-left">
                <div class="partners-track">
                  <?php foreach ($int_partners as $partner): ?>
                  <div class="partners-slide">
                    <div class="partner-logo-card">
                      <div class="partner-logo-wrapper">
                        <?php if (!empty($partner->logo)): ?>
                        <img src="<?php echo base_url('assets/img/partners/' . $partner->logo); ?>" alt="<?php echo htmlspecialchars($partner->name); ?>" class="partner-logo-img">
                        <?php else: ?>
                        <i class="bi bi-hospital partner-icon-large"></i>
                        <?php endif; ?>
                      </div>
                      <div class="partner-info">
                        <h5><?php echo htmlspecialchars($partner->name); ?></h5>
                        <p class="partner-type">International</p>
                      </div>
                      <div class="partner-badge int-badge"><i class="bi bi-globe"></i></div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

            <div class="partners-details-grid">
              <div class="row g-4" data-aos="fade-up" data-aos-delay="300">
                <?php foreach ($int_partners as $partner): ?>
                <div class="col-lg-4 col-md-6">
                  <div class="hospital-detail-card">
                    <div class="hospital-header">
                      <div class="hospital-icon"><i class="bi bi-hospital"></i></div>
                      <h4><?php echo htmlspecialchars($partner->name); ?></h4>
                    </div>
                    <p class="hospital-description"><?php echo htmlspecialchars($partner->short_description ?? 'International healthcare partner.'); ?></p>
                    <div class="hospital-tag">
                      <span><i class="bi bi-globe"></i> International</span>
                      <?php if (!empty($partner->country)): ?>
                      <span><i class="bi bi-star"></i> <?php echo htmlspecialchars($partner->country); ?></span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php else: ?>
            <div class="partners-carousel-wrapper mb-5">
              <div class="partners-carousel partners-carousel-left">
                <div class="partners-track">
                  <div class="partners-slide">
                    <div class="partner-logo-card">
                      <div class="partner-logo-wrapper">
                        <i class="bi bi-hospital partner-icon-large"></i>
                      </div>
                      <div class="partner-info">
                        <h5>Apollo Hospitals</h5>
                        <p class="partner-type">International</p>
                      </div>
                      <div class="partner-badge int-badge"><i class="bi bi-globe"></i></div>
                    </div>
                  </div>
                  <div class="partners-slide">
                    <div class="partner-logo-card">
                      <div class="partner-logo-wrapper">
                        <i class="bi bi-hospital partner-icon-large"></i>
                      </div>
                      <div class="partner-info">
                        <h5>Fortis Healthcare</h5>
                        <p class="partner-type">International</p>
                      </div>
                      <div class="partner-badge int-badge"><i class="bi bi-globe"></i></div>
                    </div>
                  </div>
                  <div class="partners-slide">
                    <div class="partner-logo-card">
                      <div class="partner-logo-wrapper">
                        <i class="bi bi-hospital partner-icon-large"></i>
                      </div>
                      <div class="partner-info">
                        <h5>Medanta Hospital</h5>
                        <p class="partner-type">International</p>
                      </div>
                      <div class="partner-badge int-badge"><i class="bi bi-globe"></i></div>
                    </div>
                  </div>
                  <div class="partners-slide">
                    <div class="partner-logo-card">
                      <div class="partner-logo-wrapper">
                        <i class="bi bi-hospital partner-icon-large"></i>
                      </div>
                      <div class="partner-info">
                        <h5>Manipal Hospitals</h5>
                        <p class="partner-type">International</p>
                      </div>
                      <div class="partner-badge int-badge"><i class="bi bi-globe"></i></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="partners-details-grid">
              <div class="row g-4" data-aos="fade-up" data-aos-delay="300">
                <div class="col-lg-4 col-md-6">
                  <div class="hospital-detail-card">
                    <div class="hospital-header">
                      <div class="hospital-icon"><i class="bi bi-hospital"></i></div>
                      <h4>World Health Organization</h4>
                    </div>
                    <p class="hospital-description">Global health organization supporting healthcare initiatives worldwide.</p>
                    <div class="hospital-tag">
                      <span><i class="bi bi-globe"></i> International</span>
                      <span><i class="bi bi-star"></i> Global Partner</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <div class="hospital-detail-card">
                    <div class="hospital-header">
                      <div class="hospital-icon"><i class="bi bi-hospital"></i></div>
                      <h4>UNICEF Tanzania</h4>
                    </div>
                    <p class="hospital-description">United Nations agency supporting child health and development programs.</p>
                    <div class="hospital-tag">
                      <span><i class="bi bi-globe"></i> International</span>
                      <span><i class="bi bi-star"></i> Child Health</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <div class="hospital-detail-card">
                    <div class="hospital-header">
                      <div class="hospital-icon"><i class="bi bi-hospital"></i></div>
                      <h4>ICAP Columbia University</h4>
                    </div>
                    <p class="hospital-description">International research organization focused on HIV/AIDS and health systems.</p>
                    <div class="hospital-tag">
                      <span><i class="bi bi-globe"></i> International</span>
                      <span><i class="bi bi-star"></i> Research Partner</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>

        </div>

        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="400">
          <a href="<?php echo base_url('partners'); ?>" class="btn-view-all">
            View All Hospital Partners <i class="bi bi-arrow-right"></i>
          </a>
        </div>

      </div>

    </section>

    <!-- Consultation Form Section -->
    <section id="consultation" class="consultation-section section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <?php if ($this->session->flashdata('success')): ?>
              <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')): ?>
              <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            
            <div class="consultation-wrapper">
              <div class="consultation-top-bar">
                <div class="gradient-line"></div>
              </div>
              
              <div class="consultation-header text-center mb-5">
                <h2 class="section-title mb-3">Request Medical Consultation</h2>
                <p class="section-description mb-4">
                  Take the first step towards world-class healthcare. Our medical experts will review your case and provide personalized treatment recommendations.
                </p>
                <div class="header-divider">
                  <div class="gradient-divider"></div>
                </div>
              </div>

              <div class="consultation-form-wrapper">
                <div class="form-card">
                  <form id="consultationForm" action="<?php echo base_url('consultation/submit'); ?>" method="post" class="consultation-form">
                    <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                    <div class="row g-4">
                      <div class="col-md-6">
                        <div class="form-group mb-4">
                          <label for="fullName" class="form-label">Full Name <span class="required">*</span></label>
                          <input type="text" name="fullName" id="fullName" class="form-control" placeholder="Enter your full name" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group mb-4">
                          <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                          <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group mb-4">
                          <label for="country" class="form-label">Country <span class="required">*</span></label>
                          <select name="country" id="country" class="form-select" required>
                            <option value="">Select country</option>
                            <option value="Tanzania">Tanzania (+255)</option>
                            <option value="Kenya">Kenya (+254)</option>
                            <option value="India">India (+91)</option>
                            <option value="Other">Other</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group mb-4">
                          <label for="phone" class="form-label">Phone <span class="required">*</span></label>
                          <input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone number" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group mb-4">
                          <label for="medical_speciality" class="form-label">Medical Specialty <span class="required">*</span></label>
                          <select name="medical_speciality" id="medical_speciality" class="form-select" required>
                            <option value="">Select specialty</option>
                            <option value="Not sure">Not sure</option>
                            <option value="Cardiology">Cardiology</option>
                            <option value="Orthopaedic">Orthopaedic Surgery</option>
                            <option value="Neurology">Neurology</option>
                            <option value="Oncology">Oncology</option>
                            <option value="Other">Other specialty</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group mb-4">
                          <label for="treatment" class="form-label">Treatment Timeline <span class="required">*</span></label>
                          <select name="treatment" id="treatment" class="form-select" required>
                            <option value="">Select timeline</option>
                            <option value="Emergency">Emergency (Immediate)</option>
                            <option value="Within 1 week">Within 1 week</option>
                            <option value="Within 1 month">Within 1 month</option>
                            <option value="Within 3 months">Within 3 months</option>
                            <option value="Not urgent">Not urgent</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group mb-4">
                          <label for="preferred_date" class="form-label">Preferred Date</label>
                          <input type="date" name="preferred_date" id="preferred_date" class="form-control" min="<?= date('Y-m-d') ?>">
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group mb-4">
                          <label for="preferred_time" class="form-label">Preferred Time</label>
                          <select name="preferred_time" id="preferred_time" class="form-select">
                            <option value="">Any time</option>
                            <option value="Morning (8AM - 12PM)">Morning (8AM - 12PM)</option>
                            <option value="Afternoon (12PM - 5PM)">Afternoon (12PM - 5PM)</option>
                            <option value="Evening (5PM - 8PM)">Evening (5PM - 8PM)</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group mb-4">
                          <label for="additional_notes" class="form-label">Additional Notes (Optional)</label>
                          <textarea name="additional_notes" id="additional_notes" class="form-control" rows="3" placeholder="Any additional information..."></textarea>
                        </div>
                      </div>
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100" id="consultationBtn">
                          <i class="bi bi-heart-pulse me-2"></i> Request Free Consultation
                        </button>
                        <p class="form-note text-center mt-2">
                          Our medical coordinator will contact you within 24 hours
                        </p>
                       </div>
                     </div>
                   </form>
                 </div>
               </div>

               <div class="consultation-benefits mt-5">
                 <div class="row g-4">
                   <div class="col-md-4">
                     <div class="benefit-card text-center">
                       <div class="benefit-icon"><i class="bi bi-person-check"></i></div>
                       <h5>Expert Review</h5>
                       <p>Your case reviewed by specialist doctors</p>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="benefit-card text-center">
                       <div class="benefit-icon"><i class="bi bi-calendar-check"></i></div>
                       <h5>Personalized Plan</h5>
                       <p>Customized treatment recommendations</p>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="benefit-card text-center">
                       <div class="benefit-icon"><i class="bi bi-shield-check"></i></div>
                       <h5>No Obligation</h5>
                       <p>Free initial assessment with no commitment</p>
                     </div>
                   </div>
                 </div>
               </div>

             </div>
           </div>
         </div>
       </div>

     </section>

     <?php if (!empty($latest_blogs)): ?>
    <!-- Recent Posts Section -->
    <section id="recent-posts" class="recent-posts section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Latest Health Tips & News</h2>
        <p>Stay informed with our latest articles and health updates</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4">
          <?php foreach ($latest_blogs as $blog): ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <article class="blog-card">
              <?php if (!empty($blog->featured_image)): ?>
              <div class="post-img">
                <img src="<?php echo base_url('assets/img/blog/' . $blog->featured_image); ?>" alt="<?php echo htmlspecialchars($blog->title); ?>" class="img-fluid">
              </div>
              <?php endif; ?>
              <p class="post-category"><?php echo htmlspecialchars(ucfirst($blog->category ?? 'Health')); ?></p>
              <h2 class="title">
                <a href="<?php echo base_url('blog/post/' . $blog->slug); ?>"><?php echo htmlspecialchars($blog->title); ?></a>
              </h2>
              <p class="post-excerpt">
                <?php 
                  $excerpt = $blog->excerpt ?? strip_tags($blog->content ?? '');
                  echo htmlspecialchars(substr($excerpt, 0, 100) . (strlen($excerpt) > 100 ? '...' : '')); 
                ?>
              </p>
            </article>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

    </section>
    <?php endif; ?>

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="hero-content">
          <div class="row align-items-center">

            <div class="col-lg-6">
              <div class="content-wrapper" data-aos="fade-up" data-aos-delay="200">
                <h1>Join Us in Transforming Community Health</h1>
                <p>Whether you're a corporation looking to invest in employee wellness, an NGO planning an outreach, or a health provider seeking media solutions, TNA CARE is your ideal partner.</p>

                <div class="cta-wrapper">
                  <a href="<?php echo base_url('partners'); ?>" class="primary-cta">
                    <span>Partner With Us</span> <i class="bi bi-arrow-right"></i>
                  </a>
                  <a href="<?php echo base_url('services'); ?>" class="secondary-cta">
                    <span>Explore Services</span> <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="image-container" data-aos="fade-left" data-aos-delay="300">
                <img src="<?php echo base_url('assets/templates/medical/img/health/tna-female-doctor-community-health.png'); ?>" alt="Community Health Transformation" class="img-fluid">
              </div>
            </div>

          </div>
        </div>

        <div class="features-section">

          <div class="row g-0">

            <div class="col-lg-4">
              <div class="feature-block" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                <h3>Registered & Licensed</h3>
                <p>Tanzanian Registered Health Service organization.</p>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="feature-block" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon"><i class="bi bi-geo"></i></div>
                <h3>National Coverage</h3>
                <p>Serving communities across Tanzania with expansion plans throughout East Africa.</p>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="feature-block" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon"><i class="bi bi-people"></i></div>
                <h3>Expert Team</h3>
                <p>Dedicated professionals committed to bridging healthcare gaps in communities.</p>
              </div>
            </div>

          </div>

        </div>

        <?php echo $this->load->view('templates/medical/sections/home_cta', [], TRUE); ?>

      </div>

    </section>

