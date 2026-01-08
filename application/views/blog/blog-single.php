<!-- Single Blog Post -->
<section class="blog-single-section py-6">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Article Header -->
                <article class="blog-article">
                    <?php if ($post->featured_image): ?>
                        <div class="article-featured-image">
                            <img 
                                src="<?php echo base_url('assets/img/blog/' . $post->featured_image); ?>" 
                                alt="<?php echo htmlspecialchars($post->title); ?>"
                                class="img-fluid"
                            >
                        </div>
                    <?php endif; ?>

                    <!-- Article Meta -->
                    <div class="article-meta">
                        <div class="meta-left">
                            <span class="category">
                                <i class="bi bi-folder"></i>
                                <a href="<?php echo base_url('blog/category/' . $post->category); ?>">
                                    <?php echo ucfirst(str_replace('-', ' ', $post->category)); ?>
                                </a>
                            </span>
                            <span class="date">
                                <i class="bi bi-calendar"></i>
                                <?php echo date('F j, Y', strtotime($post->created_at)); ?>
                            </span>
                            <span class="views">
                                <i class="bi bi-eye"></i>
                                <?php echo number_format($post->views); ?> views
                            </span>
                        </div>
                        <div class="meta-right">
                            <span class="author">By <?php echo htmlspecialchars($post->author); ?></span>
                        </div>
                    </div>

                    <!-- Article Title -->
                    <h1 class="article-title"><?php echo htmlspecialchars($post->title); ?></h1>

                    <!-- Social Share -->
                    <div class="social-share">
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
                        <a href="https://www.instagram.com/?url=<?php echo urlencode(current_url()); ?>" target="_blank" class="share-btn ig" title="Share on Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(current_url()); ?>" target="_blank" class="share-btn li">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>

                    <!-- Article Content -->
                    <div class="article-content">
                        <?php echo $post->content; ?>
                    </div>

                    <!-- Article Footer -->
                    <div class="article-footer">
                        <div class="tags">
                            <i class="bi bi-tags"></i>
                            <a href="<?php echo base_url('blog/category/' . $post->category); ?>" class="tag">
                                #<?php echo ucfirst(str_replace('-', ' ', $post->category)); ?>
                            </a>
                        </div>
                    </div>
                </article>

                <!-- Related Posts -->
                <?php if ($related_posts): ?>
                    <section class="related-posts mt-5">
                        <h3 class="section-title">Related Posts</h3>
                        <div class="related-posts-grid">
                            <?php foreach ($related_posts as $rpost): ?>
                                <div class="related-post-card" data-aos="fade-up">
                                    <?php if ($rpost->featured_image): ?>
                                        <div class="rp-image">
                                            <img 
                                                src="<?php echo base_url('assets/img/blog/' . $rpost->featured_image); ?>" 
                                                alt="<?php echo htmlspecialchars($rpost->title); ?>"
                                                class="img-fluid"
                                            >
                                        </div>
                                    <?php endif; ?>
                                    <div class="rp-content">
                                        <h4>
                                            <a href="<?php echo base_url('blog/post/' . $rpost->slug); ?>">
                                                <?php echo htmlspecialchars($rpost->title); ?>
                                            </a>
                                        </h4>
                                        <small class="text-muted">
                                            <?php echo date('M d, Y', strtotime($rpost->created_at)); ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
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

                <!-- Latest Posts -->
                <?php if ($latest_posts): ?>
                    <div class="sidebar-widget mb-4">
                        <h5 class="widget-title">Latest Posts</h5>
                        <ul class="latest-posts-list">
                            <?php foreach ($latest_posts as $lpost): ?>
                                <li>
                                    <a href="<?php echo base_url('blog/post/' . $lpost->slug); ?>" class="post-link">
                                        <strong><?php echo htmlspecialchars($lpost->title); ?></strong>
                                        <small class="text-muted">
                                            <?php echo date('M d, Y', strtotime($lpost->created_at)); ?>
                                        </small>
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
                    <a href="<?php echo base_url('booking'); ?>" class="btn btn-primary btn-block w-100 btn-cta-primary">
                        Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
