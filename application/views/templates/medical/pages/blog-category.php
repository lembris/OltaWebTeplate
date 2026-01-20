<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  /* Blog Category Page Specific Styles */
  .blog-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
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
  
  .category-badge {
    display: inline-block;
    background: var(--theme-accent, #175cdd);
    color: white;
    padding: 0.35rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
  }
  
  .blog-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
  }
  
  .blog-card-image {
    position: relative;
    height: 200px;
    overflow: hidden;
  }
  
  .blog-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .blog-card:hover .blog-card-image img {
    transform: scale(1.08);
  }
  
  .blog-card-category {
    position: absolute;
    top: 1rem;
    left: 1rem;
  }
  
  .blog-card-category span {
    background: var(--theme-accent, #175cdd);
    color: white;
    padding: 0.35rem 0.85rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .blog-card-body {
    padding: 1.5rem;
  }
  
  .blog-card-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.75rem;
    font-size: 0.85rem;
    color: #94a3b8;
  }
  
  .blog-card-meta i {
    margin-right: 0.35rem;
  }
  
  .blog-card-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.75rem;
    line-height: 1.4;
  }
  
  .blog-card-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
  }
  
  .blog-card-title a:hover {
    color: var(--theme-accent, #175cdd);
  }
  
  .blog-card-excerpt {
    color: #64748b;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1rem;
  }
  
  .blog-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 1rem;
    border-top: 1px solid #f1f5f9;
  }
  
  .blog-card-author {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }
  
  .blog-card-author img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
  }
  
  .blog-card-author-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: #334155;
  }
  
  .read-more {
    color: var(--theme-accent, #175cdd);
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: gap 0.2s ease;
  }
  
  .read-more:hover {
    gap: 0.75rem;
  }
  
  .pagination-wrapper {
    margin-top: 3rem;
    display: flex;
    justify-content: center;
  }
  
  .pagination .page-link {
    color: var(--theme-primary);
    border: none;
    padding: 0.75rem 1.25rem;
    margin: 0 0.25rem;
    border-radius: 8px;
    font-weight: 500;
  }
  
  .pagination .page-item.active .page-link {
    background: var(--theme-accent, #175cdd);
    color: white;
  }
  
  .pagination .page-link:hover {
    background: #f1f5f9;
  }
  
  .no-posts {
    text-align: center;
    padding: 4rem 2rem;
    color: #64748b;
  }
  
  .no-posts i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1.5rem;
  }
  
  .no-posts h3 {
    color: var(--theme-primary);
    margin-bottom: 0.75rem;
  }
  
  .breadcrumbs {
    padding: 0.75rem 0 2rem;
    font-size: 0.9rem;
    color: #64748b;
  }
  
  .breadcrumbs a {
    color: var(--theme-accent, #175cdd);
    text-decoration: none;
  }
  
  .breadcrumbs a:hover {
    text-decoration: underline;
  }
  
  .breadcrumbs span {
    margin: 0 0.5rem;
    color: #94a3b8;
  }
  
  @media (max-width: 768px) {
    .blog-hero {
      padding: 100px 0 60px;
    }
    
    .page-header h1 {
      font-size: 2rem;
    }
    
    .blog-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<!-- Hero Section -->
<section class="blog-hero">
  <div class="container">
    <div class="breadcrumbs" data-aos="fade-up">
      <a href="<?= base_url() ?>">Home</a>
      <span>/</span>
      <a href="<?= base_url('blog') ?>">Health Blog</a>
      <span>/</span>
      <span><?= htmlspecialchars(ucfirst(str_replace('-', ' ', $category))) ?></span>
    </div>
    
    <div class="page-header text-center" data-aos="fade-up">
      <span class="category-badge"><?= htmlspecialchars(ucfirst(str_replace('-', ' ', $category))) ?></span>
      <h1>Articles in This Category</h1>
      <p>Browse all health tips, medical insights, and wellness guidance from TNA CARE healthcare professionals.</p>
    </div>
    
    <!-- Blog Grid -->
    <?php if (!empty($posts)): ?>
    <div class="blog-grid">
      <?php foreach ($posts as $post): ?>
      <article class="blog-card" data-aos="fade-up" data-aos-delay="<?= array_search($post, $posts) * 100 ?>">
        <div class="blog-card-image">
          <?php 
          $img_url = !empty($post->featured_image) ? base_url('assets/img/blog/' . $post->featured_image) : base_url('assets/templates/medical/img/health/tna-female-black-doctor.png');
          ?>
          <a href="<?= base_url('blog/post/' . $post->slug) ?>">
            <img src="<?= $img_url ?>" alt="<?= htmlspecialchars($post->title) ?>" loading="lazy">
          </a>
          <?php if (!empty($post->category)): ?>
          <div class="blog-card-category">
            <span><?= htmlspecialchars($post->category) ?></span>
          </div>
          <?php endif; ?>
        </div>
        
        <div class="blog-card-body">
          <div class="blog-card-meta">
            <span><i class="bi bi-calendar3"></i> <?= date('M d, Y', strtotime($post->created_at)) ?></span>
            <span><i class="bi bi-eye"></i> <?= number_format($post->views ?? 0) ?> views</span>
          </div>
          
          <h3 class="blog-card-title">
            <a href="<?= base_url('blog/post/' . $post->slug) ?>"><?= htmlspecialchars($post->title) ?></a>
          </h3>
          
          <?php if (!empty($post->excerpt)): ?>
          <p class="blog-card-excerpt"><?= htmlspecialchars(substr(strip_tags($post->excerpt), 0, 120)) ?>...</p>
          <?php endif; ?>
          
          <div class="blog-card-footer">
            <div class="blog-card-author">
              <?php
              $author_img = base_url('assets/templates/medical/img/health/tna-female-black-doctor.png');
              ?>
              <img src="<?= $author_img ?>" alt="Author">
              <span class="blog-card-author-name"><?= htmlspecialchars($post->author ?? 'TNA CARE Team') ?></span>
            </div>
            <a href="<?= base_url('blog/post/' . $post->slug) ?>" class="read-more">
              Read More <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    
    <!-- Pagination -->
    <?php if (!empty($pagination)): ?>
    <div class="pagination-wrapper" data-aos="fade-up">
      <?= $pagination ?>
    </div>
    <?php endif; ?>
    
    <?php else: ?>
    <div class="no-posts" data-aos="fade-up">
      <i class="bi bi-journal-medical"></i>
      <h3>No Articles in This Category</h3>
      <p>We don't have any articles in the "<?= htmlspecialchars(ucfirst(str_replace('-', ' ', $category))) ?>" category yet.</p>
      <a href="<?= base_url('blog') ?>" class="btn btn-primary mt-3">View All Articles</a>
    </div>
    <?php endif; ?>
  </div>
</section>
