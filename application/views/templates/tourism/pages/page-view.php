<!-- Page View -->
<section class="page-view-section py-6">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Page Article -->
                <article class="page-article">
                    <?php if ($page->featured_image): ?>
                        <div class="article-featured-image">
                            <img 
                                src="<?php echo base_url('assets/img/pages/' . $page->featured_image); ?>" 
                                alt="<?php echo htmlspecialchars($page->title); ?>"
                                class="img-fluid"
                            >
                        </div>
                    <?php endif; ?>

                    <!-- Page Title -->
                    <h1 class="article-title"><?php echo htmlspecialchars($page->title); ?></h1>

                    <?php if ($page->excerpt): ?>
                        <p class="excerpt"><?php echo htmlspecialchars($page->excerpt); ?></p>
                    <?php endif; ?>

                    <!-- Page Content -->
                    <div class="article-content">
                        <?php echo $page->content; ?>
                    </div>

                    <!-- Updated Date -->
                    <div class="article-footer">
                        <small class="text-muted">
                            <i class="bi bi-calendar"></i>
                            Last updated: <?php echo date('F j, Y', strtotime($page->updated_at)); ?>
                        </small>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Pages List -->
                <?php if (isset($all_pages) && $all_pages): ?>
                    <div class="sidebar-widget mb-4">
                        <h5 class="widget-title">More Pages</h5>
                        <ul class="pages-list">
                            <?php foreach ($all_pages as $p): ?>
                                <li <?php echo ($p->uid === $page->uid) ? 'class="active"' : ''; ?>>
                                    <a href="<?php echo base_url('page/' . $p->slug); ?>">
                                        <?php echo htmlspecialchars($p->title); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- CTA Box -->
                <div class="sidebar-widget cta-box">
                    <h5 class="widget-title">Ready to Book?</h5>
                    <p>Start planning your African safari adventure today!</p>
                    <a href="<?php echo base_url('booking'); ?>" class="btn btn-primary btn-block w-100">
                        Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .page-view-section {
        background: var(--blog-cream, #F5F0E1);
        min-height: 80vh;
    }

    .page-article {
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .article-featured-image {
        margin: -40px -40px 30px -40px;
        border-radius: 12px 12px 0 0;
        overflow: hidden;
        height: 400px;
    }

    .article-featured-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .article-title {
        font-size: clamp(2rem, 5vw, 2.8rem);
        font-weight: 800;
        color: var(--dark, #3D3029);
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .excerpt {
        font-size: 1.1rem;
        color: #666;
        font-style: italic;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #eee;
    }

    .article-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #333;
        margin-bottom: 30px;
    }

    .article-content h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark, #3D3029);
        margin-top: 30px;
        margin-bottom: 15px;
    }

    .article-content h3 {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--dark, #3D3029);
        margin-top: 25px;
        margin-bottom: 15px;
    }

    .article-content h4 {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--dark, #3D3029);
        margin-top: 20px;
        margin-bottom: 12px;
    }

    .article-content p {
        margin-bottom: 15px;
    }

    .article-content ul,
    .article-content ol {
        margin-bottom: 15px;
        margin-left: 25px;
    }

    .article-content li {
        margin-bottom: 8px;
    }

    .article-content blockquote {
        border-left: 4px solid var(--primary, #C7805C);
        padding-left: 20px;
        margin-left: 0;
        margin-bottom: 15px;
        color: #666;
        font-style: italic;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        margin-bottom: 15px;
        border-radius: 8px;
    }

    .article-content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .article-content table th {
        background-color: #f8f9fa;
        padding: 12px;
        text-align: left;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }

    .article-content table td {
        padding: 12px;
        border: 1px solid #dee2e6;
    }

    .article-footer {
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    /* Sidebar */
    .sidebar-widget {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .widget-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark, #3D3029);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 3px solid var(--primary, #C7805C);
    }

    .pages-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pages-list li {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .pages-list li:last-child {
        border-bottom: none;
    }

    .pages-list a {
        color: #666;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .pages-list a:hover {
        color: var(--primary, #C7805C);
    }

    .pages-list li.active a {
        color: var(--primary, #C7805C);
        font-weight: 600;
    }

    .cta-box {
        background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
        color: white;
        text-align: center;
    }

    .cta-box .widget-title {
        color: white;
        border-bottom-color: rgba(255,255,255,0.3);
    }

    .cta-box p {
        color: rgba(255,255,255,0.9);
        margin-bottom: 20px;
    }

    .cta-box .btn {
        width: 100%;
        padding: 12px;
        background: white;
        color: var(--primary, #C7805C);
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .cta-box .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    @media (max-width: 768px) {
        .page-article {
            padding: 20px;
        }

        .article-featured-image {
            margin: -20px -20px 20px -20px;
            height: 250px;
        }

        .article-title {
            font-size: 1.8rem;
        }

        .article-content {
            font-size: 1rem;
        }
    }
</style>
