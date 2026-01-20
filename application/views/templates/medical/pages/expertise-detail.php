<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .expertise-detail-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .expertise-detail-hero::before {
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

  .expertise-detail-header {
    margin-bottom: 3rem;
  }

  .expertise-detail-header h1 {
    font-size: 2.75rem;
    font-weight: 800;
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .expertise-detail-header .subtitle {
    font-size: 1.25rem;
    color: #64748b;
    max-width: 700px;
  }

  .expertise-icon-large {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 2rem;
  }

  .expertise-icon-large i {
    font-size: 3.5rem;
    color: white;
  }

  .expertise-content-section {
    padding: 80px 0;
  }

  .expertise-content-section:nth-child(even) {
    background: #f8fafc;
  }

  .expertise-main-content h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .expertise-main-content p {
    color: #475569;
    line-height: 1.8;
    font-size: 1.05rem;
    margin-bottom: 1.5rem;
  }

  .expertise-features-list {
    list-style: none;
    padding: 0;
    margin: 2rem 0;
  }

  .expertise-features-list li {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  .expertise-features-list li i {
    color: #22c55e;
    font-size: 1.25rem;
    margin-top: 2px;
  }

  .expertise-features-list li span {
    color: #334155;
    font-size: 1rem;
    line-height: 1.5;
  }

  .expertise-cta-box {
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
    color: white;
  }

  .expertise-cta-box h3 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 1rem;
  }

  .expertise-cta-box p {
    opacity: 0.9;
    margin-bottom: 1.5rem;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
  }

  .expertise-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    background: white;
    color: var(--theme-primary);
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .expertise-cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  }

  .related-expertises {
    padding: 80px 0;
    background: #f8fafc;
  }

  .related-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid #e2e8f0;
    text-decoration: none;
  }

  .related-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    border-color: var(--theme-primary);
  }

  .related-card .icon-wrapper {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
  }

  .related-card .icon-wrapper i {
    font-size: 1.75rem;
    color: white;
  }

  .related-card h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.5rem;
  }

  .related-card p {
    color: #64748b;
    font-size: 0.9rem;
  }

  @media (max-width: 992px) {
    .expertise-detail-header h1 {
      font-size: 2.25rem;
    }

    .expertise-content-section {
      padding: 60px 0;
    }
  }
</style>

<section class="expertise-detail-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="expertise-detail-header" data-aos="fade-up">
          <div class="expertise-icon-large">
            <?php if (!empty($expertise->icon)): ?>
              <i class="<?php echo htmlspecialchars($expertise->icon); ?>"></i>
            <?php else: ?>
              <i class="fa fa-user-md"></i>
            <?php endif; ?>
          </div>
          <h1><?php echo htmlspecialchars($expertise->name); ?></h1>
          <?php if (!empty($expertise->short_description)): ?>
            <p class="subtitle"><?php echo htmlspecialchars($expertise->short_description); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($expertise->description)): ?>
<section class="expertise-content-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="expertise-main-content">
          <h2>About This Specialty</h2>
          <p><?php echo nl2br(htmlspecialchars($expertise->description)); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php
$features = json_decode($expertise->features ?? '[]', true);
if (!empty($features) && is_array($features)):
?>
<section class="expertise-content-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="expertise-main-content">
          <h2>Key Services & Capabilities</h2>
          <ul class="expertise-features-list">
            <?php foreach ($features as $feature): ?>
              <li>
                <i class="fas fa-check-circle"></i>
                <span><?php echo htmlspecialchars($feature); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="expertise-content-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="expertise-cta-box" data-aos="fade-up">
          <h3>Need Consultation?</h3>
          <p>Our team of experts is ready to help you with your healthcare needs. Get in touch today.</p>
          <a href="<?php echo base_url('#consultation'); ?>" class="expertise-cta-btn">
            <span>Book Free Consultation</span>
            <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($related_expertises) && count($related_expertises) > 1): ?>
<section class="related-expertises">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center mb-5">
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--theme-primary);">Other Areas of Expertise</h2>
        <p style="color: #64748b;">Explore more medical specialties</p>
      </div>
    </div>
    <div class="row justify-content-center g-4">
      <?php foreach (array_slice($related_expertises, 0, 3) as $related): ?>
        <?php if ($related->slug != $expertise->slug): ?>
          <div class="col-lg-4 col-md-6">
            <a href="<?php echo base_url('expertise/' . $related->slug); ?>" class="related-card">
              <div class="icon-wrapper">
                <?php if (!empty($related->icon)): ?>
                  <i class="<?php echo htmlspecialchars($related->icon); ?>"></i>
                <?php else: ?>
                  <i class="fa fa-user-md"></i>
                <?php endif; ?>
              </div>
              <h4><?php echo htmlspecialchars($related->name); ?></h4>
              <p><?php echo htmlspecialchars($related->short_description); ?></p>
            </a>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php echo $this->load->view('templates/medical/sections/home_cta', [], TRUE); ?>
