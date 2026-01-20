<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- 404 Content Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="error-content">
                    <h2 class="display-1 mb-4">404</h2>
                    <h3 class="mb-4">Oops! Post Not Found</h3>
                    <p class="mb-4">The blog post you're looking for doesn't exist or has been removed. But we have plenty of other great content for you to explore!</p>
                    
                    <a href="<?= base_url('blog') ?>" class="btn btn-primary btn-lg">
                        <i class="fa fa-arrow-left"></i> Back to Blog
                    </a>
                </div>
                
                <!-- Recent Posts -->
                <?php if (!empty($latest_posts)): ?>
                <div class="mt-5">
                    <h4 class="mb-4">Recent Blog Posts</h4>
                    <div class="row">
                        <?php foreach (array_slice($latest_posts, 0, 3) as $post): ?>
                        <div class="col-md-4 ftco-animate mb-4">
                            <div class="blog-entry">
                                <?php $img = !empty($post->featured_image) ? base_url($post->featured_image) : get_template_image('image_2.jpg'); ?>
                                <a href="<?= base_url('blog/' . $post->slug) ?>" class="block-20" style="background-image: url('<?= $img ?>');"></a>
                                <div class="text p-3">
                                    <h3 class="heading"><a href="<?= base_url('blog/' . $post->slug) ?>"><?= htmlspecialchars($post->title) ?></a></h3>
                                    <p class="meta"><span class="fa fa-calendar"></span> <?= date('M d, Y', strtotime($post->created_at)) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
