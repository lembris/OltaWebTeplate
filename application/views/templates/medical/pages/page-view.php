<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .page-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .page-hero::before {
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

  .page-content {
    padding: 80px 0;
    background: white;
  }

  .page-content h1 {
    color: var(--theme-primary);
    font-weight: 700;
    margin-bottom: 2rem;
    font-size: 2.5rem;
  }

  .page-content h2 {
    color: var(--theme-primary);
    font-weight: 600;
    margin: 2rem 0 1rem 0;
    font-size: 1.75rem;
  }

  .page-content h3 {
    color: var(--theme-primary);
    font-weight: 600;
    margin: 2rem 0 1rem 0;
    font-size: 1.25rem;
  }

  .page-content p {
    color: #64748b;
    line-height: 1.8;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
  }

  .page-content ul {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
  }

  .page-content li {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 0.5rem;
  }

  .page-meta {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 3rem;
    border: 1px solid #e2e8f0;
  }

  .page-meta .meta-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #64748b;
    font-size: 0.9rem;
  }

  .page-meta i {
    color: var(--theme-primary);
    font-size: 1.1rem;
  }

  .featured-image {
    margin-bottom: 2rem;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .featured-image img {
    width: 100%;
    height: auto;
    display: block;
  }

  @media (max-width: 768px) {
    .page-hero {
      padding: 80px 0 60px;
    }

    .page-hero h1 {
      font-size: 2rem;
    }

    .page-content {
      padding: 60px 0;
    }

    .page-content h1 {
      font-size: 2rem;
    }
  }
</style>

<!-- Page Header -->
<section class="page-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <div class="page-header" data-aos="fade-up">
          <h1><?php echo htmlspecialchars($page->title); ?></h1>
          <?php if ($page->excerpt): ?>
            <p><?php echo htmlspecialchars($page->excerpt); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Page Content -->
<section class="page-content">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10" data-aos="fade-up">

        <?php if ($page->featured_image): ?>
          <div class="featured-image">
            <img src="<?php echo base_url('assets/img/pages/' . $page->featured_image); ?>" alt="<?php echo htmlspecialchars($page->title); ?>" class="img-fluid">
          </div>
        <?php endif; ?>

        <div class="page-meta">
          <div class="row">
            <div class="col-md-6">
              <div class="meta-item">
                <i class="bi bi-calendar"></i>
                <span>Published: <?php echo date('F j, Y', strtotime($page->created_at)); ?></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="meta-item">
                <i class="bi bi-clock"></i>
                <span>Last Updated: <?php echo date('F j, Y', strtotime($page->updated_at)); ?></span>
              </div>
            </div>
          </div>
        </div>

        <div class="content-section">
          <?php echo $page->content; ?>
        </div>

      </div>
    </div>
  </div>
</section>