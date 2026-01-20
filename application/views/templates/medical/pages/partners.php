<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .partners-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .partners-hero::before {
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

  .partners-section {
    padding: 80px 0;
    background: #f8fafc;
  }

  .partner-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    height: 100%;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .partner-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(30, 64, 175, 0.12);
    border-color: #c7d2fe;
  }

  .partner-logo {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.25rem;
    border-radius: 12px;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .partner-logo img {
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;
  }

  .partner-logo i {
    font-size: 2.5rem;
    color: #94a3b8;
  }

  .partner-content h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.5rem;
  }

  .partner-type {
    display: inline-block;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    background: #eff6ff;
    color: var(--theme-primary);
    font-weight: 500;
    margin-bottom: 0.75rem;
  }

  .partner-type.international {
    background: #fef3c7;
    color: #d97706;
  }

  .partner-content p {
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 1rem;
  }

  .partner-website {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--theme-accent);
    font-weight: 600;
    text-decoration: none;
    font-size: 0.9rem;
    transition: gap 0.3s ease;
  }

  .partner-website:hover {
    gap: 0.75rem;
    color: var(--theme-primary);
  }

  .section-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .section-subtitle {
    color: #64748b;
    max-width: 600px;
    margin: 0 auto 3rem;
  }

  .subsection-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin: 3rem 0 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 3px solid #e2e8f0;
  }

  .subsection-title.local {
    border-bottom-color: #22c55e;
  }

  .subsection-title.international {
    border-bottom-color: #3b82f6;
  }

  .stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
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

  @media (max-width: 768px) {
    .partners-hero {
      padding: 80px 0 60px;
    }

    .page-header h1 {
      font-size: 2rem;
    }

    .stats-row {
      grid-template-columns: 1fr;
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
<section class="partners-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="page-header" data-aos="fade-up">
          <h1>Our Hospital Partners</h1>
          <p>Collaborating with leading healthcare organizations across Tanzania and internationally to provide world-class medical services.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="partners-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12" data-aos="fade-up">
        <div class="stats-row">
          <div class="stat-item">
            <div class="number">50+</div>
            <div class="label">Hospital Partners</div>
          </div>
          <div class="stat-item">
            <div class="number">15</div>
            <div class="label">International Partners</div>
          </div>
          <div class="stat-item">
            <div class="number">35</div>
            <div class="label">Local Partners</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Partners Section -->
<section class="partners-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-10 text-center" data-aos="fade-up">
        <h2 class="section-title">Our Healthcare Partners</h2>
        <p class="section-subtitle">Trusted partnerships with leading medical institutions</p>
      </div>
    </div>

    <?php if (!empty($tz_partners)): ?>
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <h3 class="subsection-title local">Tanzania Partners</h3>
        </div>
      </div>
      <div class="row g-4 mb-5">
        <?php foreach ($tz_partners as $partner): ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo rand(100, 300); ?>">
            <div class="partner-card">
              <div class="partner-logo">
                <?php if (!empty($partner->logo)): ?>
                  <img src="<?php echo base_url('uploads/partners/' . htmlspecialchars($partner->logo)); ?>" alt="<?php echo htmlspecialchars($partner->name); ?>">
                <?php else: ?>
                  <i class="bi bi-hospital"></i>
                <?php endif; ?>
              </div>
              
              <span class="partner-type">Tanzania</span>
              
              <div class="partner-content">
                <h4><?php echo htmlspecialchars($partner->name); ?></h4>
                <p><?php echo htmlspecialchars($partner->short_description); ?></p>
                
                <?php if (!empty($partner->website)): ?>
                  <a href="<?php echo htmlspecialchars($partner->website); ?>" target="_blank" class="partner-website">
                    Visit Website <i class="bi bi-box-arrow-up-right"></i>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($int_partners)): ?>
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <h3 class="subsection-title international">International Partners</h3>
        </div>
      </div>
      <div class="row g-4">
        <?php foreach ($int_partners as $partner): ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo rand(100, 300); ?>">
            <div class="partner-card">
              <div class="partner-logo">
                <?php if (!empty($partner->logo)): ?>
                  <img src="<?php echo base_url('uploads/partners/' . htmlspecialchars($partner->logo)); ?>" alt="<?php echo htmlspecialchars($partner->name); ?>">
                <?php else: ?>
                  <i class="bi bi-hospital-fill"></i>
                <?php endif; ?>
              </div>
              
              <span class="partner-type international">International</span>
              
              <div class="partner-content">
                <h4><?php echo htmlspecialchars($partner->name); ?></h4>
                <p><?php echo htmlspecialchars($partner->short_description); ?></p>
                
                <?php if (!empty($partner->country)): ?>
                  <p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($partner->country); ?></p>
                <?php endif; ?>
                
                <?php if (!empty($partner->website)): ?>
                  <a href="<?php echo htmlspecialchars($partner->website); ?>" target="_blank" class="partner-website">
                    Visit Website <i class="bi bi-box-arrow-up-right"></i>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

      <?php if (empty($tz_partners) && empty($int_partners)): ?>
      <div class="text-center">
        <p class="text-muted">No partners available at the moment. Please check back later.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php echo $this->load->view('templates/medical/sections/home_cta', [], TRUE); ?>
