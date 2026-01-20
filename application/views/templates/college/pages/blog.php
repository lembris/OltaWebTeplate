<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ftco-animate">
                <?php if (!empty($posts)): ?>
                    <div class="row">
                        <?php foreach ($posts as $post): ?>
                            <div class="col-md-6 d-flex">
                                <div class="blog-entry justify-content-end">
                                    <a href="<?= base_url('blog/' . $post->slug) ?>" class="block-20" style="background-image: url('<?= !empty($post->featured_image) ? base_url('assets/img/blog/' . $post->featured_image) : get_template_image('image_1.jpg') ?>');">
                                    </a>
                                    <div class="text mt-3 float-right d-block">
                                        <div class="d-flex align-items-center mb-3 meta">
                                            <p class="mb-0">
                                                <span class="mr-2"><?= date('F j, Y', strtotime($post->created_at)) ?></span>
                                                <?php if (!empty($post->author)): ?>
                                                    <a href="#" class="mr-2">By <?= htmlspecialchars($post->author) ?></a>
                                                <?php endif; ?>
                                                <?php if (!empty($post->category_name)): ?>
                                                    <a href="<?= base_url('blog/category/' . $post->category_slug) ?>" class="meta-chat"><span class="icon-folder"></span> <?= htmlspecialchars($post->category_name) ?></a>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <h3 class="heading"><a href="<?= base_url('blog/' . $post->slug) ?>"><?= htmlspecialchars($post->title) ?></a></h3>
                                        <p><?= character_limiter(strip_tags($post->excerpt ?? $post->content), 120) ?></p>
                                        <a href="<?= base_url('blog/' . $post->slug) ?>" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if (!empty($pagination)): ?>
                        <div class="row mt-5">
                            <div class="col text-center">
                                <div class="block-27">
                                    <?= $pagination ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <h4>No Posts Found</h4>
                                <p>There are no blog posts available at the moment. Please check back later.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4 sidebar ftco-animate">
                <div class="sidebar-box">
                    <form action="<?= base_url('blog/search') ?>" method="get" class="search-form">
                        <div class="form-group">
                            <span class="icon ion-ios-search"></span>
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                        </div>
                    </form>
                </div>

                <?php if (!empty($categories)): ?>
                    <div class="sidebar-box ftco-animate">
                        <h3 class="heading">Categories</h3>
                        <ul class="categories">
                            <?php foreach ($categories as $cat): ?>
                                <li>
                                    <a href="<?= base_url('blog/category/' . urlencode($cat->category)) ?>">
                                        <?= htmlspecialchars(ucfirst($cat->category)) ?>
                                        <span>(<?= $cat->post_count ?>)</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($latest_posts)): ?>
                    <div class="sidebar-box ftco-animate">
                        <h3 class="heading">Recent Blog</h3>
                        <?php foreach ($latest_posts as $recent): ?>
                            <div class="block-21 mb-4 d-flex">
                                <a class="blog-img mr-4" style="background-image: url('<?= !empty($recent->featured_image) ? base_url('assets/img/blog/' . $recent->featured_image) : get_template_image('image_1.jpg') ?>');"></a>
                                <div class="text">
                                    <h3 class="heading-2"><a href="<?= base_url('blog/' . $recent->slug) ?>"><?= htmlspecialchars($recent->title) ?></a></h3>
                                    <div class="meta">
                                        <div><span class="icon-calendar"></span> <?= date('M j, Y', strtotime($recent->created_at)) ?></div>
                                        <?php if (!empty($recent->author)): ?>
                                            <div><span class="icon-person"></span> <?= htmlspecialchars($recent->author) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="sidebar-box ftco-animate">
                    <h3 class="heading">Popular Tags</h3>
                    <div class="tagcloud dynamic-tags" id="popularTags">
                        <p class="text-muted text-center py-3">Loading tags...</p>
                    </div>
                </div>

                <div class="sidebar-box ftco-animate">
                    <h3 class="heading">Most Viewed</h3>
                    <div id="mostViewed">
                        <p class="text-muted text-center py-3">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load popular tags dynamically
    fetch('<?= base_url('api/blog/popular-tags') ?>')
        .then(response => response.json())
        .then(data => {
            const tagsContainer = document.getElementById('popularTags');
            if (data.tags && data.tags.length > 0) {
                tagsContainer.innerHTML = data.tags.map(tag => 
                    `<a href="<?= base_url('blog/tag/') ?>${tag.slug}" class="tag-cloud-link">${tag.name}</a>`
                ).join('');
            } else {
                tagsContainer.innerHTML = '<p class="text-muted text-center py-3">No tags available</p>';
            }
        })
        .catch(() => {
            document.getElementById('popularTags').innerHTML = '<p class="text-muted text-center py-3">Unable to load tags</p>';
        });

    // Load most viewed posts dynamically
    fetch('<?= base_url('api/blog/most-viewed') ?>')
        .then(response => response.json())
        .then(data => {
            const viewedContainer = document.getElementById('mostViewed');
            if (data.posts && data.posts.length > 0) {
                const topViews = data.posts[0].views;
                viewedContainer.innerHTML = data.posts.map((post, idx) => {
                    const imgUrl = post.featured_image ? '<?= base_url('assets/img/blog/') ?>' + post.featured_image : '<?= get_template_image('dmi_journey.jpg') ?>';
                    const viewDiff = idx === 0 ? '' : `<span class="view-diff">-${topViews - post.views}</span>`;
                    return `
                        <div class="most-viewed-card mb-3">
                            <a href="<?= base_url('blog/') ?>${post.slug}" class="most-viewed-card-link">
                                <div class="card-image" style="background-image: url('${imgUrl}');"></div>
                                <div class="card-content">
                                    <h4 class="card-title">${post.title}</h4>
                                    ${viewDiff}
                                </div>
                            </a>
                        </div>
                    `;
                }).join('');
            } else {
                viewedContainer.innerHTML = '<p class="text-muted text-center py-3">No posts available</p>';
            }
        })
        .catch(() => {
            document.getElementById('mostViewed').innerHTML = '<p class="text-muted text-center py-3">Unable to load posts</p>';
        });
});
</script>
