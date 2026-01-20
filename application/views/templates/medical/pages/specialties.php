<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .specialties-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .specialties-hero::before {
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

  .specialties-section {
    padding: 80px 0;
  }

  .specialties-section:nth-child(even) {
    background: #f8fafc;
  }

  .specialty-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    position: relative;
    height: 100%;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .specialty-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(var(--theme-primary-rgb), 0.12);
    border-color: color-mix(in srgb, var(--theme-primary), white 70%);
  }

  .specialty-icon-wrapper {
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

  .specialty-card:hover .specialty-icon-wrapper {
    transform: scale(1.1);
  }

  .specialty-icon-wrapper i {
    font-size: 1.75rem;
    color: white;
  }

  .specialty-content h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.75rem;
  }

  .specialty-content p {
    color: #64748b;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1rem;
  }

  .specialty-features {
    list-style: none;
    padding: 0;
    margin: 0 0 1.25rem 0;
  }

  .specialty-features li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #475569;
    margin-bottom: 0.5rem;
    padding: 0.25rem 0;
  }
  .specialty-features li i {
    color: #22c55e;
    font-size: 0.75rem;
  }

  .specialty-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--theme-accent);
    font-weight: 600;
    text-decoration: none;
    font-size: 0.9rem;
    transition: gap 0.3s ease;
  }

  .specialty-link:hover {
    gap: 0.75rem;
    color: var(--theme-primary);
  }

  .specialty-category {
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    background: linear-gradient(135deg, var(--theme-primary), var(--primary-dark));
    color: white;
    font-weight: 500;
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
    .stats-row {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 768px) {
    .specialties-hero {
      padding: 80px 0 60px;
    }

    .page-header h1 {
      font-size: 2rem;
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
<section class="specialties-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="page-header" data-aos="fade-up">
          <h1>Our Medical Specialties</h1>
          <p>Comprehensive healthcare services across multiple medical specialties designed to promote wellness and deliver exceptional care.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="specialties-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12" data-aos="fade-up">
        <div class="stats-row">
          <div class="stat-item">
            <div class="number"><?php echo count($specialties); ?></div>
            <div class="label">Specialties</div>
          </div>
          <div class="stat-item">
            <div class="number">50+</div>
            <div class="label">Hospital Partners</div>
          </div>
          <div class="stat-item">
            <div class="number">1M+</div>
            <div class="label">People Reached</div>
          </div>
          <div class="stat-item">
            <div class="number">5+</div>
            <div class="label">Years Experience</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Specialties Section -->
<section class="specialties-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-10 text-center" data-aos="fade-up">
        <h2 class="section-title">What We Offer</h2>
        <p class="section-subtitle">TNA CARE provides a wide range of medical and healthcare services designed to promote wellness and deliver exceptional care.</p>
      </div>
    </div>

    <div class="row g-4">
      <?php if (!empty($specialties)): ?>
        <?php foreach ($specialties as $specialty): ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo rand(100, 300); ?>">
            <div class="specialty-card">
              <span class="specialty-category"><?php echo ucwords(str_replace('_', ' ', htmlspecialchars($specialty->category ?? 'General'))); ?></span>
              
              <div class="specialty-icon-wrapper">
                <?php if (!empty($specialty->icon)): ?>
                  <i class="bi <?php echo htmlspecialchars($specialty->icon); ?>"></i>
                <?php else: ?>
                  <i class="bi bi-heart-pulse"></i>
                <?php endif; ?>
              </div>
              
              <div class="specialty-content">
                <h4><?php echo htmlspecialchars($specialty->name); ?></h4>
                <p><?php echo htmlspecialchars($specialty->short_description); ?></p>
                
                <?php
                $features = json_decode($specialty->features ?? '[]', true);
                if (!empty($features) && is_array($features)):
                ?>
                <ul class="specialty-features">
                  <?php foreach (array_slice($features, 0, 4) as $feature): ?>
                    <li>
                      <i class="bi bi-check-circle"></i>
                      <?php echo htmlspecialchars($feature); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                
                <a href="<?php echo base_url('specialties/view/' . $specialty->slug); ?>" class="specialty-link">
                  Learn More <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-center">
          <p class="text-muted">No specialties available at the moment. Please check back later.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php echo $this->load->view('templates/medical/sections/home_cta', [], TRUE); ?>
