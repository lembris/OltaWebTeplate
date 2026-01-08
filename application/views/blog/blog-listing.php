<!-- Blog Listing Page -->
<section class="blog-section py-6">
    <div class="container">
        <div class="row">
            <!-- Blog Posts Column -->
            <div class="col-lg-8">
                <!-- Page Header -->
                <div class="mb-5">
                    <h1 class="page-title">Travel Tips & Guides</h1>
                    <p class="page-subtitle">Expert advice for your African safari adventure</p>
                </div>
                

                <!-- Blog Search -->
                <div class="blog-search-box mb-5">
                    <form action="<?php echo base_url('blog/search'); ?>" method="GET" class="input-group">
                        <input 
                            type="text" 
                            name="q" 
                            class="form-control" 
                            placeholder="Search blog posts..." 
                            required
                        >
                        <button class="btn btn-primary btn-search" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </form>
                </div>

                <!-- Posts Grid -->
                <?php if ($posts): ?>
                    <div class="blog-posts-grid">
                        <?php foreach ($posts as $post): ?>
                            <article class="blog-card" data-aos="fade-up">
                                <?php if ($post->featured_image): ?>
                                    <div class="blog-card-image">
                                        <img 
                                            src="<?php echo base_url('assets/img/blog/' . $post->featured_image); ?>" 
                                            alt="<?php echo htmlspecialchars($post->title); ?>"
                                            class="img-fluid"
                                        >
                                        <div class="blog-card-overlay">
                                            <a href="<?php echo base_url('blog/post/' . $post->slug); ?>" class="read-more">
                                                Read More <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="blog-card-content">
                                    <div class="blog-meta">
                                        <span class="blog-category"><?php echo ucfirst(str_replace('-', ' ', $post->category)); ?></span>
                                        <span class="blog-date">
                                            <i class="bi bi-calendar"></i>
                                            <?php echo date('M d, Y', strtotime($post->created_at)); ?>
                                        </span>
                                    </div>
                                    
                                    <h2 class="blog-title">
                                        <a href="<?php echo base_url('blog/post/' . $post->slug); ?>">
                                            <?php echo htmlspecialchars($post->title); ?>
                                        </a>
                                    </h2>
                                    
                                    <p class="blog-excerpt">
                                        <?php echo htmlspecialchars(substr($post->excerpt ?: $post->content, 0, 150)); ?>...
                                    </p>
                                    
                                    <div class="blog-footer">
                                        <span class="blog-author">By <?php echo htmlspecialchars($post->author); ?></span>
                                        <a href="<?php echo base_url('blog/post/' . $post->slug); ?>" class="blog-read-more">
                                            Continue Reading →
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($pagination): ?>
                        <nav class="blog-pagination mt-5">
                            <?php echo $pagination; ?>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        No blog posts found yet. Check back soon!
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Sidebar Search -->
                <div class="sidebar-widget mb-4">
                    <h5 class="widget-title">Search</h5>
                    <form action="<?php echo base_url('blog/search'); ?>" method="GET" class="input-group">
                        <input 
                            type="text" 
                            name="q" 
                            class="form-control form-control-sm" 
                            placeholder="Search posts..."
                            required
                        >
                        <button class="btn btn-sm btn-primary btn-search" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Categories -->
                <?php if ($categories): ?>
                    <div class="sidebar-widget mb-4">
                        <h5 class="widget-title">Categories</h5>
                        <ul class="category-list">
                            <li>
                                <a href="<?php echo base_url('blog'); ?>">
                                    All Posts (<?php echo $total_posts; ?>)
                                </a>
                            </li>
                            <?php foreach ($categories as $cat): ?>
                                <li>
                                    <a href="<?php echo base_url('blog/category/' . $cat->category); ?>">
                                        <?php echo ucfirst(str_replace('-', ' ', $cat->category)); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Latest Posts Widget -->
                <?php if ($latest_posts): ?>
                    <div class="sidebar-widget">
                        <h5 class="widget-title">Latest Posts</h5>
                        <ul class="latest-posts-list">
                            <?php foreach ($latest_posts as $post): ?>
                                <li>
                                    <a href="<?php echo base_url('blog/post/' . $post->slug); ?>" class="post-link">
                                        <strong><?php echo htmlspecialchars($post->title); ?></strong>
                                        <small class="text-muted">
                                            <?php echo date('M d, Y', strtotime($post->created_at)); ?>
                                        </small>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Blog Styles -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/blog.css">
