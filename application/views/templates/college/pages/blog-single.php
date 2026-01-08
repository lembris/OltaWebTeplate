<?php
/**
 * College Template - Single Blog Post
 */
?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Blog Content Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 ftco-animate">
                <div class="blog-single">
                    <!-- Featured Image -->
                    <?php 
                    $featured_image = !empty($post->featured_image) ? base_url('assets/img/blog/' . $post->featured_image) : get_template_image('image_1.jpg');
                    ?>
                    <img src="<?php echo $featured_image; ?>" alt="<?php echo htmlspecialchars($post->title); ?>" class="img-fluid mb-4">
                    
                    <!-- Post Meta -->
                    <div class="post-meta mb-4">
                        <span class="mr-3"><i class="fa fa-calendar"></i> <?php echo date('M d, Y', strtotime($post->created_at)); ?></span>
                        <span class="mr-3"><i class="fa fa-user"></i> <?php echo htmlspecialchars($post->author ?? 'Admin'); ?></span>
                        <?php if (!empty($post->category)): ?>
                        <span class="mr-3"><i class="fa fa-folder"></i> <?php echo htmlspecialchars($post->category); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($post->views)): ?>
                        <span><i class="fa fa-eye"></i> <?php echo number_format($post->views); ?> views</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Post Content -->
                    <div class="post-content">
                        <?php echo $post->content; ?>
                    </div>
                    
                    <!-- Tags -->
                    <?php if (!empty($post->tags)): ?>
                    <div class="tag-widget post-tag-container mt-5 mb-5">
                        <div class="tagcloud">
                            <?php 
                            $tags = is_array($post->tags) ? $post->tags : explode(',', $post->tags);
                            foreach ($tags as $tag): 
                                $tag = trim($tag);
                            ?>
                            <a href="<?php echo base_url('blog/tag/' . urlencode($tag)); ?>" class="tag-cloud-link"><?php echo htmlspecialchars($tag); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Share Buttons -->
                    <div class="share-buttons mb-5">
                        <h5>Share this post:</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(current_url()); ?>" target="_blank" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px;" title="Share on Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(current_url()); ?>&text=<?php echo urlencode($post->title); ?>" target="_blank" class="btn btn-dark rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px;" title="Share on X">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(current_url()); ?>&title=<?php echo urlencode($post->title); ?>" target="_blank" class="btn btn-secondary rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px;" title="Share on LinkedIn">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a href="https://wa.me/?text=<?php echo urlencode($post->title . ' ' . current_url()); ?>" target="_blank" class="btn rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px; background-color: #25D366; color: white; border: none;" title="Share on WhatsApp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                            <a href="https://www.instagram.com" target="_blank" class="btn rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 18px; background: linear-gradient(45deg, #405de6, #5b51d8, #833ab4, #c13584, #e1306c, #fd1d1d); color: white; border: none;" title="Follow on Instagram">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Author Bio -->
                    <div class="about-author d-flex p-4 mb-5" style="background-color: <?php echo htmlspecialchars($sidebar_bg_color ?? '#f8f9fa'); ?>;">
                        <div class="bio align-self-md-center mr-4">
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: #ffffff; display: flex; align-items: center; justify-content: center; padding: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                <img src="<?php echo base_url(!empty($site_favicon) ? $site_favicon : get_template_image('person_1.jpg')); ?>" alt="Author" class="img-fluid" style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                        </div>
                        <div class="desc align-self-md-center">
                            <h4><?php echo htmlspecialchars($post->author ?? 'Admin'); ?></h4>
                            <p>A passionate educator and writer sharing insights about academic excellence and student success.</p>
                        </div>
                    </div>
                    
                    <!-- Related Posts -->
                    <?php if (!empty($related_posts)): ?>
                    <div class="related-posts">
                        <h3 class="mb-4">Related Posts</h3>
                        <div class="row">
                            <?php foreach ($related_posts as $related): ?>
                            <div class="col-md-4 ftco-animate">
                                <div class="blog-entry">
                                    <?php $rel_image = !empty($related->featured_image) ? base_url('assets/img/blog/' . $related->featured_image) : get_template_image('image_2.jpg'); ?>
                                            <a href="<?php echo base_url('blog/' . $related->slug); ?>" class="block-20" style="background-image: url('<?php echo $rel_image; ?>');"></a>
                                    <div class="text p-3">
                                        <h3 class="heading"><a href="<?php echo base_url('blog/' . $related->slug); ?>"><?php echo htmlspecialchars($related->title); ?></a></h3>
                                        <p class="meta"><span class="fa fa-calendar"></span> <?php echo date('M d, Y', strtotime($related->created_at)); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4 sidebar ftco-animate">
                <!-- Search -->
                <div class="sidebar-box p-4" style="background-color: <?php echo htmlspecialchars($sidebar_bg_color ?? '#f8f9fa'); ?>;">
                    <form action="<?php echo base_url('blog/search'); ?>" method="GET" class="search-form">
                        <div class="form-group">
                            <span class="icon fa fa-search"></span>
                            <input type="text" name="q" class="form-control" placeholder="Search posts...">
                        </div>
                    </form>
                </div>
                
                <!-- Categories -->
                <?php if (!empty($categories)): ?>
                <div class="sidebar-box p-4 mt-4" style="background-color: <?php echo htmlspecialchars($sidebar_bg_color ?? '#f8f9fa'); ?>;">
                    <h3 class="heading-sidebar">Categories</h3>
                    <ul class="categories">
                        <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="<?php echo base_url('blog/category/' . urlencode($cat->category)); ?>">
                                <?php echo htmlspecialchars(ucfirst($cat->category)); ?>
                                <span>(<?php echo $cat->post_count; ?>)</span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <!-- Recent Posts -->
                <?php if (!empty($latest_posts)): ?>
                <div class="sidebar-box p-4 mt-4" style="background-color: <?php echo htmlspecialchars($sidebar_bg_color ?? '#f8f9fa'); ?>;">
                    <h3 class="heading-sidebar">Recent Posts</h3>
                    <?php foreach ($latest_posts as $recent): ?>
                    <div class="block-21 mb-4 d-flex">
                        <?php $recent_img = !empty($recent->featured_image) ? base_url('assets/img/blog/' . $recent->featured_image) : get_template_image('image_3.jpg'); ?>
                        <a class="blog-img mr-4" style="background-image: url(<?php echo $recent_img; ?>);"></a>
                        <div class="text">
                            <h3 class="heading"><a href="<?php echo base_url('blog/' . $recent->slug); ?>"><?php echo htmlspecialchars($recent->title); ?></a></h3>
                            <div class="meta">
                                <span><i class="fa fa-calendar"></i> <?php echo date('M d, Y', strtotime($recent->created_at)); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>

