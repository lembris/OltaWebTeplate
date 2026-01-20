<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .about-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .about-hero::before {
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

  .about-section {
    padding: 80px 0;
  }

  .about-section:nth-child(even) {
    background: #f8fafc;
  }

  .about-image-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
  }

  .about-image-wrapper img {
    width: 100%;
    height: auto;
  }

  .about-image-wrapper::after {
    content: '';
    position: absolute;
    top: 20px;
    left: 20px;
    right: -20px;
    bottom: -20px;
    border: 3px solid var(--theme-primary);
    border-radius: 20px;
    z-index: -1;
    opacity: 0.3;
  }

  .about-content h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 1.5rem;
  }

  .about-content p {
    color: #475569;
    line-height: 1.8;
    margin-bottom: 1.5rem;
  }

  .lead-text {
    font-size: 1.125rem;
    font-weight: 500;
    color: #334155;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-top: 2.5rem;
  }

  .stat-item {
    text-align: center;
    padding: 1.5rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease;
  }

  .stat-item:hover {
    transform: translateY(-5px);
  }

  .stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--theme-primary);
    line-height: 1;
    margin-bottom: 0.5rem;
  }

  .stat-label {
    font-size: 0.875rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .timeline {
    position: relative;
    padding: 2rem 0;
  }

  .timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, var(--theme-primary) 0%, var(--theme-accent) 100%);
  }

  .timeline-item {
    position: relative;
    margin-bottom: 3rem;
  }

  .timeline-item:nth-child(odd) {
    padding-right: calc(50% + 30px);
    text-align: right;
  }

  .timeline-item:nth-child(even) {
    padding-left: calc(50% + 30px);
  }

  .timeline-dot {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 20px;
    background: var(--theme-primary);
    border: 4px solid white;
    border-radius: 50%;
    box-shadow: 0 0 0 4px var(--theme-primary);
  }

  .timeline-content {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .timeline-year {
    display: inline-block;
    background: var(--theme-primary);
    color: white;
    padding: 0.25rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
  }

  .timeline-content h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.5rem;
  }

  .timeline-content p {
    color: #64748b;
    font-size: 0.95rem;
    margin: 0;
  }

  .team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    justify-items: center;
  }

  .team-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    max-width: 320px;
    width: 100%;
  }

  .team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }

  .team-image {
    height: 250px;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  .team-image i {
    font-size: 4rem;
    color: white;
    opacity: 0.5;
  }

  .team-info {
    padding: 1.5rem;
    text-align: center;
  }

  .team-info h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.25rem;
  }

  .team-info .role {
    color: var(--theme-accent);
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
  }

  .team-info p {
    color: #64748b;
    font-size: 0.875rem;
    margin: 0;
  }

  .values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
  }

  .value-card {
    background: white;
    padding: 2.5rem 2rem;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
  }

  .value-card:hover {
    transform: translateY(-8px);
    border-color: var(--theme-primary);
  }

  .value-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .value-icon i {
    font-size: 2rem;
    color: white;
  }

  .value-card h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .value-card p {
    color: #64748b;
    font-size: 0.95rem;
    line-height: 1.7;
    margin: 0;
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
    .stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .values-grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .timeline::before {
      left: 20px;
    }

    .timeline-item:nth-child(odd),
    .timeline-item:nth-child(even) {
      padding-left: 60px;
      padding-right: 0;
      text-align: left;
    }

    .timeline-dot {
      left: 20px;
    }
  }

  @media (max-width: 768px) {
    .about-hero {
      padding: 80px 0 60px;
    }

    .page-header h1 {
      font-size: 2rem;
    }

    .stats-grid {
      grid-template-columns: 1fr 1fr;
    }

    .stat-item {
      padding: 1rem;
    }

    .stat-number {
      font-size: 2rem;
    }

    .values-grid {
      grid-template-columns: 1fr;
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
<section class="about-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="page-header" data-aos="fade-up">
          <h1>About TNA CARE</h1>
          <p>Bridging the gap between communities and quality healthcare through education, consultation, and strategic partnerships across Tanzania, East and Central Africa.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Our Story Section -->
<section class="about-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6" data-aos="fade-right">
        <div class="about-image-wrapper">
          <img src="<?php echo base_url('assets/templates/medical/img/health/tna-male-and-female-black-doctors-wod-round.png'); ?>" alt="TNA CARE Medical Team">
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <div class="about-content">
          <h2>Our Story</h2>
          <p class="lead-text">TNA CARE began as a health media initiative to close the gap between reliable health information and underserved communities.</p>
          <p>Founded with a vision to improve healthcare access in Tanzania and East Africa, we've evolved into a multi-service healthcare facilitation company trusted by individuals, corporates, NGOs, and government agencies.</p>
          <p>Registered with BRELA and operating in accordance with the laws and regulatory guidelines of Tanzania’s Ministry of Health, we have evolved from digital content creators into trusted healthcare partners for individuals, corporations, NGOs, and government agencies.</p>
          <p>Our integrated model combines digital media, direct patient outreach, corporate wellness programs, and innovative digital health solutions to address public health challenges across the region.</p>
          <p>We believe that everyone deserves access to quality healthcare information and services, regardless of their location or economic status.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Mission & Vision Section -->
<section class="about-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 order-lg-2" data-aos="fade-left">
        <div class="about-image-wrapper">
          <img src="<?php echo base_url('assets/templates/medical/img/health/tna-female-black-doctor.png'); ?>" alt="TNA CARE Vision">
        </div>
      </div>
      <div class="col-lg-6 order-lg-1" data-aos="fade-right">
        <div class="about-content">
          <h2>Mission & Vision</h2>
          
          <div class="mission-vision-item mb-4">
            <h4 style="color: var(--theme-primary); font-weight: 700;"><i class="bi bi-eye-fill me-2"></i>Our Vision</h4>
            <p>To transform healthcare across Africa by delivering innovative, inclusive, and impactful solutions that empower communities and strengthen health systems.</p>
          </div>
          
          <div class="mission-vision-item">
            <h4 style="color: var(--theme-primary); font-weight: 700;"><i class="bi bi-bullseye me-2"></i>Our Mission</h4>
            <p>To bridge healthcare gaps across Africa by connecting communities and strategic partners to quality care through innovation, collaboration, and sustainable solutions, with initial implementation focused in Tanzania, East and Central Africa.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="about-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10" data-aos="fade-up">
        <div class="stats-grid">
          <div class="stat-item">
            <div class="stat-number">1M+</div>
            <div class="stat-label">People Reached</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">19.7K</div>
            <div class="stat-label">YouTube Subscribers</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">50+</div>
            <div class="stat-label">Hospital Partners</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">5+</div>
            <div class="stat-label">Years of Service</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php echo $this->load->view('templates/medical/sections/core_values', [], TRUE); ?>

<?php echo $this->load->view('templates/medical/sections/timeline', [
    'timeline_title' => 'Our Journey',
    'timeline_subtitle' => 'Key milestones in our mission to transform healthcare access',
    'timeline_items' => $timeline_items ?? []
], TRUE); ?>

<!-- Leadership Team Section -->
<section class="about-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center" data-aos="fade-up">
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--theme-primary); margin-bottom: 1rem;">Our Leadership</h2>
        <p style="color: #64748b; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto;">Dedicated professionals committed to transforming healthcare in Africa</p>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="team-grid" data-aos="fade-up" data-aos-delay="100">
          <?php if (!empty($team_members)): ?>
            <?php foreach ($team_members as $member): ?>
            <div class="team-card">
              <div class="team-image">
                <?php if (!empty($member->photo)): ?>
                  <img src="<?php echo base_url('assets/images/team/' . $member->photo); ?>" alt="<?php echo htmlspecialchars($member->first_name . ' ' . $member->last_name); ?>">
                <?php else: ?>
                  <i class="bi bi-person-fill"></i>
                <?php endif; ?>
              </div>
              <div class="team-info">
                <h4><?php echo htmlspecialchars($member->first_name . ' ' . $member->last_name); ?></h4>
                <p class="role"><?php echo htmlspecialchars($member->title); ?></p>
                <p><?php echo htmlspecialchars($member->bio ?: $member->specialization); ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="team-card">
              <div class="team-image">
                <i class="bi bi-person-fill"></i>
              </div>
              <div class="team-info">
                <h4>Dr. Najma K Hamad</h4>
                <p class="role">Founder & CEO</p>
                <p>Visionary leader with 15+ years in healthcare management and public health initiatives.</p>
              </div>
            </div>
            <div class="team-card">
              <div class="team-image">
                <i class="bi bi-person-fill"></i>
              </div>
              <div class="team-info">
                <h4>Dr. Emmanuel Mfaume</h4>
                <p class="role">Medical Director</p>
                <p>Senior physician overseeing medical content and partnership quality standards.</p>
              </div>
            </div>
            <div class="team-card">
              <div class="team-image">
                <i class="bi bi-person-fill"></i>
              </div>
              <div class="team-info">
                <h4>Sarah Mkomwa</h4>
                <p class="role">Operations Director</p>
                <p>Ensuring seamless delivery of healthcare facilitation services across regions.</p>
              </div>
            </div>
            <div class="team-card">
              <div class="team-image">
                <i class="bi bi-person-fill"></i>
              </div>
              <div class="team-info">
                <h4>James Ochieng</h4>
                <p class="role">Head of Digital</p>
                <p>Leading our digital transformation and online health platform development.</p>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php echo $this->load->view('templates/medical/sections/home_cta', [], TRUE); ?>
