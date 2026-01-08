<!-- ============================================
     BLOG PREVIEW SECTION - v4.0 SEO Optimized
     ============================================ -->
<section class="blog-preview-v4 py-6" id="blog" aria-labelledby="blog-heading">
    <div class="container">
        <!-- Section Header -->
        <header class="section-header-v3 text-center mb-5">
            <span class="section-tag" data-aos="fade-up">📝 TRAVEL INSIGHTS</span>
            <h2 class="section-title-v3" data-aos="fade-up" data-aos-delay="100" id="blog-heading">
                Safari Tips & Travel Guides
            </h2>
            <p class="section-desc" data-aos="fade-up" data-aos-delay="200">
                Expert advice to help you plan the perfect African adventure
            </p>
        </header>

        <!-- Blog Cards -->
        <div class="row g-4" id="blogPreviewContainer">
            <?php if(isset($latest_blogs) && !empty($latest_blogs)): ?>
                <?php $delay = 100; foreach($latest_blogs as $blog): ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <article class="blog-preview-card" itemscope itemtype="https://schema.org/BlogPosting">
                        <div class="blog-card-image">
                            <?php if($blog->featured_image): ?>
                            <img src="<?php echo base_url('assets/img/blog/' . $blog->featured_image); ?>" 
                                 alt="<?php echo htmlspecialchars($blog->title); ?>"
                                 loading="lazy"
                                 width="400"
                                 height="250"
                                 itemprop="image">
                            <?php else: ?>
                            <img src="<?php echo base_url('assets/img/blog-placeholder.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($blog->title); ?>"
                                 loading="lazy"
                                 width="400"
                                 height="250">
                            <?php endif; ?>
                            <div class="blog-card-overlay">
                                <a href="<?php echo base_url('blog/post/' . $blog->slug); ?>" class="read-link" aria-label="Read <?php echo htmlspecialchars($blog->title); ?>">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <span class="blog-category-tag"><?php echo ucfirst(str_replace('-', ' ', $blog->category)); ?></span>
                        </div>
                        <div class="blog-card-body">
                            <div class="blog-meta-info">
                                <time datetime="<?php echo date('Y-m-d', strtotime($blog->created_at)); ?>" itemprop="datePublished">
                                    <i class="bi bi-calendar3"></i>
                                    <?php echo date('M d, Y', strtotime($blog->created_at)); ?>
                                </time>
                                <span class="blog-views">
                                    <i class="bi bi-eye"></i>
                                    <?php echo number_format($blog->views); ?>
                                </span>
                            </div>
                            <h3 class="blog-card-title" itemprop="headline">
                                <a href="<?php echo base_url('blog/post/' . $blog->slug); ?>" itemprop="url">
                                    <?php echo htmlspecialchars($blog->title); ?>
                                </a>
                            </h3>
                            <p class="blog-card-excerpt" itemprop="description">
                                <?php echo character_limiter($blog->excerpt ?: strip_tags($blog->content), 100); ?>
                            </p>
                            <a href="<?php echo base_url('blog/post/' . $blog->slug); ?>" class="blog-read-more">
                                Read Article <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </article>
                </div>
                <?php $delay += 100; endforeach; ?>
            <?php else: ?>
                <!-- Placeholder cards if no blog posts exist -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <article class="blog-preview-card">
                        <div class="blog-card-image">
                            <img src="<?php echo base_url('assets/img/hero-bg.jpg'); ?>" alt="Safari Tips" loading="lazy" width="400" height="250">
                            <span class="blog-category-tag">Travel Tips</span>
                        </div>
                        <div class="blog-card-body">
                            <div class="blog-meta-info">
                                <time><i class="bi bi-calendar3"></i> Dec 05, 2025</time>
                            </div>
                            <h3 class="blog-card-title">
                                <a href="<?php echo base_url('blog'); ?>">Best Time to Visit Tanzania for Safari</a>
                            </h3>
                            <p class="blog-card-excerpt">Discover the ideal seasons for your African safari adventure...</p>
                            <a href="<?php echo base_url('blog'); ?>" class="blog-read-more">Read Article <i class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <article class="blog-preview-card">
                        <div class="blog-card-image">
                            <img src="<?php echo base_url('assets/img/hero-bg.jpg'); ?>" alt="Wildlife Guide" loading="lazy" width="400" height="250">
                            <span class="blog-category-tag">Wildlife</span>
                        </div>
                        <div class="blog-card-body">
                            <div class="blog-meta-info">
                                <time><i class="bi bi-calendar3"></i> Dec 04, 2025</time>
                            </div>
                            <h3 class="blog-card-title">
                                <a href="<?php echo base_url('blog'); ?>">The Big Five: Complete Wildlife Guide</a>
                            </h3>
                            <p class="blog-card-excerpt">Learn about Africa's most iconic animals and where to find them...</p>
                            <a href="<?php echo base_url('blog'); ?>" class="blog-read-more">Read Article <i class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <article class="blog-preview-card">
                        <div class="blog-card-image">
                            <img src="<?php echo base_url('assets/img/hero-bg.jpg'); ?>" alt="Photography Tips" loading="lazy" width="400" height="250">
                            <span class="blog-category-tag">Photography</span>
                        </div>
                        <div class="blog-card-body">
                            <div class="blog-meta-info">
                                <time><i class="bi bi-calendar3"></i> Dec 03, 2025</time>
                            </div>
                            <h3 class="blog-card-title">
                                <a href="<?php echo base_url('blog'); ?>">Safari Photography Tips for Beginners</a>
                            </h3>
                            <p class="blog-card-excerpt">Capture stunning wildlife photos with these expert tips...</p>
                            <a href="<?php echo base_url('blog'); ?>" class="blog-read-more">Read Article <i class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </article>
                </div>
            <?php endif; ?>
        </div>

        <!-- View All Button -->
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?php echo base_url('blog'); ?>" class="btn-view-all" aria-label="View all blog posts">
                <i class="bi bi-journal-text me-2"></i>
                View All Articles
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<style>
    /* ============ BLOG PREVIEW V4 ============ */
    .blog-preview-v4 {
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    }

    .blog-preview-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .blog-preview-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .blog-card-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .blog-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .blog-preview-card:hover .blog-card-image img {
        transform: scale(1.1);
    }

    .blog-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(199, 128, 92, 0.9) 0%, rgba(26,26,46,0.9) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .blog-preview-card:hover .blog-card-overlay {
        opacity: 1;
    }

    .read-link {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--theme-primary, #C7805C);
        font-size: 1.5rem;
        text-decoration: none;
        transform: scale(0);
        transition: transform 0.4s ease;
    }

    .blog-preview-card:hover .read-link {
        transform: scale(1);
    }

    .read-link:hover {
        background: var(--theme-primary, #C7805C);
        color: white;
    }

    .blog-category-tag {
        position: absolute;
        top: 15px;
        left: 15px;
        background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #a86a4a) 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 2;
    }

    .blog-card-body {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .blog-meta-info {
        display: flex;
        gap: 15px;
        margin-bottom: 12px;
        font-size: 0.85rem;
        color: #888;
    }

    .blog-meta-info time,
    .blog-meta-info span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .blog-card-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .blog-card-title a {
        color: #1a1a2e;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .blog-card-title a:hover {
        color: var(--theme-primary, #C7805C);
    }

    .blog-card-excerpt {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 15px;
        flex: 1;
    }

    .blog-read-more {
        display: inline-flex;
        align-items: center;
        color: var(--theme-primary, #C7805C);
        font-weight: 600;
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    .blog-read-more:hover {
        color: var(--primary-dark, #a86a4a);
        gap: 5px;
    }

    .blog-read-more i {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .blog-read-more:hover i {
        transform: translateX(5px);
    }

    @media (max-width: 768px) {
        .blog-card-image {
            height: 180px;
        }

        .blog-card-body {
            padding: 20px;
        }

        .blog-card-title {
            font-size: 1.1rem;
        }
    }
</style>
