<?php
defined('BASEPATH') OR exit('No direct script access less than');
?>

<style>
  .expertise-section {
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
    box-shadow: 0 20px 40px rgba(30, 64, 175, 0.12);
    border-color: #c7d2fe;
  }

  .expertise-icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
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
    color: #1e40af;
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
    font-size: 0.75rem;
  }

  .expertise-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #1e40af;
    font-weight: 600;
    text-decoration: none;
    font-size: 0.9rem;
    transition: gap 0.3s ease;
  }

  .expertise-link:hover {
    gap: 0.75rem;
    color: #3730a3;
  }

  .expertise-category {
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    background: #eff6ff;
    color: #1e40af;
    font-weight: 500;
  }

  .section-header {
    text-align: center;
    margin-bottom: 3rem;
  }

  .section-header h2 {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e40af;
    margin-bottom: 1rem;
  }

  .section-header p {
    font-size: 1.1rem;
    color: #64748b;
    max-width: 600px;
    margin: 0 auto;
  }

  .page-banner {
    background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
    padding: 100px 0 60px;
    color: white;
  }

  .page-banner h1 {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
  }

  .page-banner p {
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 600px;
  }
  
  .expertise-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .expertise-hero::before {
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

  .expertise-hero .page-header {
    margin-bottom: 3rem;
  }

  .expertise-hero .page-header h1 {
    font-size: 2.75rem;
    font-weight: 800;
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .expertise-hero .page-header p {
    font-size: 1.125rem;
    color: #64748b;
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
  }
</style>

<section class="expertise-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="page-header" data-aos="fade-up">
          <h1>Our Medical Expertise</h1>
          <p>World-class medical professionals across multiple specialties</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="expertise-section">
  <div class="container">
    <div class="section-header">
      <h2>Our Specialized Fields</h2>
      <p>Our team of highly skilled medical professionals brings expertise across various specialized healthcare fields.</p>
    </div>

    <div class="row g-4">
      <?php if (!empty($expertises)): ?>
        <?php foreach ($expertises as $expertise): ?>
          <div class="col-lg-4 col-md-6">
            <div class="expertise-card">
              <span class="expertise-category"><?php echo ucwords(str_replace('_', ' ', htmlspecialchars($expertise->category))); ?></span>
              
              <div class="expertise-icon-wrapper">
                <?php if (!empty($expertise->icon)): ?>
                  <i class="<?php echo htmlspecialchars($expertise->icon); ?>"></i>
                <?php else: ?>
                  <i class="fa fa-user-md"></i>
                <?php endif; ?>
              </div>
              
              <div class="expertise-content">
                <h4><?php echo htmlspecialchars($expertise->name); ?></h4>
                <p><?php echo htmlspecialchars($expertise->short_description); ?></p>
                
                <?php
                $features = json_decode($expertise->features ?? '[]', true);
                if (!empty($features) && is_array($features)):
                ?>
                <ul class="expertise-features">
                  <?php foreach (array_slice($features, 0, 4) as $feature): ?>
                    <li>
                      <i class="fas fa-check-circle"></i>
                      <?php echo htmlspecialchars($feature); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                
                <a href="<?php echo base_url('expertise/' . $expertise->slug); ?>" class="expertise-link">
                  Learn More <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-center">
          <p class="text-muted">No expertise areas available at the moment. Please check back later.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php echo $this->load->view('templates/medical/sections/home_cta', [], TRUE); ?>
