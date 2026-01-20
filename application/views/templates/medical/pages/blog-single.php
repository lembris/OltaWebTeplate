<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  /* Blog Single Page Styles */
  .blog-hero {
    padding: 120px 0 60px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
  }
  
  .blog-content-section {
    padding: 60px 0;
  }
  
  /* Article Header */
  .article-header {
    text-align: center;
    max-width: 900px;
    margin: 0 auto 2rem;
  }
  
  .article-category {
    display: inline-block;
    background: var(--theme-accent, #175cdd);
    color: white;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 1rem;
    text-decoration: none;
  }
  
  .article-category:hover {
    background: var(--theme-primary);
    color: white;
  }
  
  .article-title {
    font-size: 2.25rem;
    font-weight: 800;
    color: var(--theme-primary);
    margin-bottom: 1.25rem;
    line-height: 1.3;
  }
  
  .article-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
    color: #64748b;
    font-size: 0.9rem;
  }
  
  .article-meta span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .article-meta i {
    color: var(--theme-accent, #175cdd);
  }
  
  /* Featured Image */
  .article-featured-image {
    max-width: 900px;
    margin: 0 auto 2.5rem;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
  }
  
  .article-featured-image img {
    width: 100%;
    height: auto;
    display: block;
  }
  
  /* Social Share */
  .social-share {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
  }
  
  .social-share span {
    font-weight: 600;
    color: #64748b;
    margin-right: 0.5rem;
  }
  
  .share-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: transform 0.2s ease;
  }
  
  .share-btn:hover {
    transform: translateY(-3px);
  }
  
  .share-btn.fb { background: #1877f2; }
  .share-btn.tw { background: #000000; }
  .share-btn.wa { background: #25d366; }
  .share-btn.li { background: #0a66c2; }
  
  /* Article Content */
  .article-content {
    max-width: 800px;
    margin: 0 auto;
    font-size: 1.1rem;
    line-height: 1.85;
    color: #334155;
  }
  
  .article-content p {
    margin-bottom: 1.5rem;
  }
  
  .article-content h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin: 2.5rem 0 1rem;
  }
  
  .article-content h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin: 2rem 0 0.75rem;
  }
  
  .article-content ul, .article-content ol {
    margin: 1.5rem 0;
    padding-left: 2rem;
  }
  
  .article-content li {
    margin-bottom: 0.75rem;
  }
  
  .article-content blockquote {
    border-left: 4px solid var(--theme-accent, #175cdd);
    padding: 1.5rem 2rem;
    margin: 2rem 0;
    background: #f8fafc;
    border-radius: 0 12px 12px 0;
    font-style: italic;
  }
  
  .article-content blockquote p {
    margin: 0;
  }
  
  /* Tags */
  .article-tags {
    max-width: 800px;
    margin: 2rem auto 0;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
  }
  
  .article-tags span {
    font-weight: 600;
    color: #64748b;
    margin-right: 0.5rem;
  }
  
  .tag {
    background: #f1f5f9;
    color: #475569;
    padding: 0.35rem 0.85rem;
    border-radius: 20px;
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  
  .tag:hover {
    background: var(--theme-accent, #175cdd);
    color: white;
  }
  
  /* Sidebar */
  .sidebar-widget {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
  }
  
  .sidebar-widget .widget-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f1f5f9;
  }
  
  /* Search Widget */
  .search-form {
    display: flex;
    gap: 0.5rem;
  }
  
  .search-form input {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: border-color 0.2s ease;
  }
  
  .search-form input:focus {
    outline: none;
    border-color: var(--theme-accent, #175cdd);
  }
  
  .search-form button {
    padding: 0.75rem 1rem;
    background: var(--theme-accent, #175cdd);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s ease;
  }
  
  .search-form button:hover {
    background: var(--theme-primary);
  }
  
  /* Latest Posts Widget */
  .latest-posts-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  
  .latest-posts-list li {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
  }
  
  .latest-posts-list li:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
  }
  
  .post-link {
    display: block;
    text-decoration: none;
    color: inherit;
    transition: color 0.2s ease;
  }
  
  .post-link:hover {
    color: var(--theme-accent, #175cdd);
  }
  
  .post-link strong {
    display: block;
    font-size: 0.95rem;
    color: var(--theme-primary);
    margin-bottom: 0.25rem;
    line-height: 1.4;
  }
  
  .post-link small {
    font-size: 0.8rem;
    color: #94a3b8;
  }
  
  /* Categories Widget */
  .categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  
  .categories-list li {
    margin-bottom: 0.5rem;
  }
  
  .categories-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    background: #f8fafc;
    border-radius: 8px;
    color: var(--theme-primary);
    text-decoration: none;
    transition: all 0.2s ease;
  }
  
  .categories-list a:hover {
    background: var(--theme-accent, #175cdd);
    color: white;
  }
  
  .categories-list .count {
    background: white;
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
    font-size: 0.75rem;
    color: #64748b;
  }
  
  /* CTA Widget */
  .cta-widget {
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    color: white;
    text-align: center;
  }
  
  .cta-widget .widget-title {
    color: white;
    border-bottom-color: rgba(255,255,255,0.2);
  }
  
  .cta-widget p {
    font-size: 0.95rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
  }
  
  .cta-widget .btn {
    width: 100%;
    padding: 0.85rem;
    font-weight: 600;
  }
  
  /* Related Posts */
  .related-posts-section {
    background: #f8fafc;
    padding: 60px 0;
    margin-top: 4rem;
  }
  
  .related-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
  }
  
  .related-post-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
  }
  
  .related-post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.1);
  }
  
  .rp-image {
    height: 160px;
    overflow: hidden;
  }
  
  .rp-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .related-post-card:hover .rp-image img {
    transform: scale(1.08);
  }
  
  .rp-content {
    padding: 1.25rem;
  }
  
  .rp-content h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.5rem;
    line-height: 1.4;
  }
  
  .rp-content h4 a {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
  }
  
  .rp-content h4 a:hover {
    color: var(--theme-accent, #175cdd);
  }
  
  .rp-date {
    font-size: 0.8rem;
    color: #94a3b8;
  }
  
  /* Author Box */
  .author-box {
    max-width: 800px;
    margin: 3rem auto 0;
    background: white;
    border-radius: 16px;
    padding: 2rem;
    display: flex;
    gap: 1.5rem;
    align-items: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  }
  
  .author-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
  }
  
  .author-info h4 {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.5rem;
  }
  
  .author-info p {
    color: #64748b;
    font-size: 0.95rem;
    margin-bottom: 0;
  }
  
  @media (max-width: 991px) {
    .article-title {
      font-size: 1.75rem;
    }
    
    .article-meta {
      gap: 1rem;
    }
  }
  
  @media (max-width: 768px) {
    .blog-hero {
      padding: 100px 0 40px;
    }
    
    .related-posts-grid {
      grid-template-columns: 1fr;
    }
    
    .author-box {
      flex-direction: column;
      text-align: center;
    }
  }
</style>

<!-- Hero Section -->
<section class="blog-hero">
  <div class="container">
    <!-- Article Header -->
    <header class="article-header" data-aos="fade-up">
      <?php if (!empty($post->category)): ?>
      <a href="<?= base_url('blog/category/' . strtolower(str_replace(' ', '-', $post->category))) ?>" class="article-category">
        <?= htmlspecialchars(ucfirst($post->category)) ?>
      </a>
      <?php endif; ?>
      
      <h1 class="article-title"><?= htmlspecialchars($post->title) ?></h1>
      
      <div class="article-meta">
        <span><i class="bi bi-calendar3"></i> <?= date('F d, Y', strtotime($post->created_at)) ?></span>
        <span><i class="bi bi-eye"></i> <?= number_format($post->views ?? 0) ?> views</span>
        <?php if (!empty($post->author)): ?>
        <span><i class="bi bi-person"></i> <?= htmlspecialchars($post->author) ?></span>
        <?php endif; ?>
      </div>
    </header>
    
    <!-- Featured Image -->
    <?php if (!empty($post->featured_image)): ?>
    <div class="article-featured-image" data-aos="fade-up" data-aos-delay="100">
      <img src="<?= base_url('assets/img/blog/' . $post->featured_image) ?>" alt="<?= htmlspecialchars($post->title) ?>">
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- Main Content with Sidebar -->
<section class="blog-content-section">
  <div class="container">
    <div class="row">
      <!-- Main Article -->
      <div class="col-lg-8">
        <!-- Social Share -->
        <div class="social-share" data-aos="fade-up">
          <span>Share:</span>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(current_url()); ?>" target="_blank" class="share-btn fb">
            <i class="bi bi-facebook"></i>
          </a>
          <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(current_url()); ?>&text=<?php echo urlencode($post->title); ?>" target="_blank" class="share-btn tw">
            <i class="bi bi-twitter-x"></i>
          </a>
          <a href="https://wa.me/?text=<?php echo urlencode($post->title . ' ' . current_url()); ?>" target="_blank" class="share-btn wa">
            <i class="bi bi-whatsapp"></i>
          </a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(current_url()); ?>" target="_blank" class="share-btn li">
            <i class="bi bi-linkedin"></i>
          </a>
        </div>

        <!-- Article Content -->
        <article class="article-content" data-aos="fade-up">
          <?= $post->content ?>
        </article>

        <!-- Tags -->
        <?php if (!empty($post->tags)): ?>
        <div class="article-tags">
          <span><i class="bi bi-tags"></i> Tags:</span>
          <?php foreach (explode(',', $post->tags) as $tag): ?>
          <a href="<?= base_url('blog/search?q=' . trim($tag)) ?>" class="tag"><?= trim($tag) ?></a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Author Box -->
        <div class="author-box" data-aos="fade-up">
          <img src="<?= base_url('assets/templates/medical/img/health/tna-female-black-doctor.png') ?>" alt="Author" class="author-avatar">
          <div class="author-info">
            <h4><?= htmlspecialchars($post->author ?? 'TNA CARE Team') ?></h4>
            <p>Healthcare professionals dedicated to providing expert health tips and medical insights for our community.</p>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- Search Widget -->
        <div class="sidebar-widget" data-aos="fade-up">
          <h5 class="widget-title">Search Articles</h5>
          <form action="<?= base_url('blog/search') ?>" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Search health tips..." required>
            <button type="submit"><i class="bi bi-search"></i></button>
          </form>
        </div>

        <!-- Latest Posts Widget -->
        <?php if (!empty($latest_posts)): ?>
        <div class="sidebar-widget" data-aos="fade-up">
          <h5 class="widget-title">Latest Health Tips</h5>
          <ul class="latest-posts-list">
            <?php foreach (array_slice($latest_posts, 0, 5) as $lpost): ?>
            <li>
              <a href="<?= base_url('blog/post/' . $lpost->slug) ?>" class="post-link">
                <strong><?= htmlspecialchars($lpost->title) ?></strong>
                <small><?= date('M d, Y', strtotime($lpost->created_at)) ?></small>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <!-- Categories Widget -->
        <?php if (!empty($categories)): ?>
        <div class="sidebar-widget" data-aos="fade-up">
          <h5 class="widget-title">Health Topics</h5>
          <ul class="categories-list">
            <?php foreach (array_slice($categories, 0, 6) as $cat): ?>
            <li>
              <a href="<?= base_url('blog/category/' . strtolower(str_replace(' ', '-', $cat->category))) ?>">
                <?= htmlspecialchars(ucfirst($cat->category)) ?>
                <span class="count"><?= $cat->post_count ?? '' ?></span>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <!-- CTA Widget -->
        <div class="sidebar-widget cta-widget" data-aos="fade-up">
          <h5 class="widget-title">Need Health Support?</h5>
          <p>Get in touch with our healthcare team for personalized assistance.</p>
          <a href="<?= base_url('contact') ?>" class="btn btn-light" style="color: var(--theme-primary);">
            Contact Us <i class="bi bi-arrow-right ms-2"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Related Posts -->
<?php if (!empty($related_posts)): ?>
<section class="related-posts-section">
  <div class="container">
    <h3 class="text-center mb-4" style="font-size: 1.5rem; font-weight: 700; color: var(--theme-primary);" data-aos="fade-up">
      Related Health Articles
    </h3>
    <div class="related-posts-grid">
      <?php foreach ($related_posts as $index => $rpost): ?>
      <a href="<?= base_url('blog/post/' . $rpost->slug) ?>" class="related-post-card" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
        <?php if (!empty($rpost->featured_image)): ?>
        <div class="rp-image">
          <img src="<?= base_url('assets/img/blog/' . $rpost->featured_image) ?>" alt="<?= htmlspecialchars($rpost->title) ?>">
        </div>
        <?php else: ?>
        <div class="rp-image">
          <img src="<?= base_url('assets/templates/medical/img/health/tna-female-black-doctor.png') ?>" alt="<?= htmlspecialchars($rpost->title) ?>">
        </div>
        <?php endif; ?>
        <div class="rp-content">
          <h4><?= htmlspecialchars($rpost->title) ?></h4>
          <span class="rp-date"><?= date('M d, Y', strtotime($rpost->created_at)) ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
