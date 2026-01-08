<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Gallery Section -->
<section class="ftco-section">
    <div class="container">
        <!-- Filter Buttons -->
        <?php if (!empty($gallery_categories)): ?>
        <div class="row justify-content-center mb-5">
            <div class="col-md-12 text-center">
                <div class="gallery-filter ftco-animate">
                    <button class="btn btn-primary active" data-filter="*">All</button>
                    <?php foreach ($gallery_categories as $category): ?>
                        <?php if ($category !== 'all'): ?>
                        <button class="btn btn-outline-primary" data-filter=".<?= url_title($category, 'dash', true) ?>"><?= ucwords(htmlspecialchars($category)) ?></button>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Gallery Grid -->
        <div class="row gallery-grid">
            <?php if (!empty($gallery_images)): ?>
                <?php foreach ($gallery_images as $image): ?>
                <div class="col-md-4 col-sm-6 gallery-item ftco-animate <?= url_title($image['category'], 'dash', true) ?>" data-category="<?= htmlspecialchars($image['category']) ?>">
                    <div class="gallery-box">
                        <a href="<?= base_url($image['src']) ?>" class="gallery-popup" title="<?= htmlspecialchars($image['title']) ?>">
                            <div class="gallery-img" style="background-image: url('<?= base_url($image['thumb']) ?>');">
                                <div class="gallery-overlay">
                                    <div class="gallery-content">
                                        <h4><?= htmlspecialchars($image['title']) ?></h4>
                                        <?php if (!empty($image['description'])): ?>
                                        <p><?= htmlspecialchars($image['description']) ?></p>
                                        <?php endif; ?>
                                        <span class="icon-search"></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12 text-center">
                <p>No gallery images available.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Load More Button -->
        <?php if (!empty($use_load_more)): ?>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <button class="btn btn-primary btn-load-more" id="loadMoreGallery">Load More</button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.gallery-filter {
    margin-bottom: 30px;
}
.gallery-filter .btn {
    margin: 5px;
    border-radius: 30px;
    padding: 10px 25px;
}
.gallery-box {
    margin-bottom: 30px;
    overflow: hidden;
    border-radius: 5px;
}
.gallery-img {
    height: 250px;
    background-size: cover;
    background-position: center;
    position: relative;
    transition: all 0.3s ease;
}
.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}
.gallery-box:hover .gallery-overlay {
    opacity: 1;
}
.gallery-box:hover .gallery-img {
    transform: scale(1.1);
}
.gallery-content {
    text-align: center;
    color: #fff;
    padding: 20px;
}
.gallery-content h4 {
    color: #fff;
    margin-bottom: 10px;
    font-size: 18px;
}
.gallery-content p {
    font-size: 14px;
    margin-bottom: 10px;
}
.gallery-content .icon-search {
    font-size: 24px;
}
</style>

<!-- Isotope JS for filtering -->
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Isotope after images load
    var $grid = $('.gallery-grid').imagesLoaded(function() {
        $grid.isotope({
            itemSelector: '.gallery-item',
            layoutMode: 'fitRows'
        });
    });

    // Fallback: Initialize immediately if imagesLoaded not available
    if (typeof $.fn.imagesLoaded === 'undefined') {
        $grid = $('.gallery-grid').isotope({
            itemSelector: '.gallery-item',
            layoutMode: 'fitRows'
        });
    }

    // Filter items on button click
    $('.gallery-filter').on('click', 'button', function() {
        var filterValue = $(this).attr('data-filter');
        $('.gallery-grid').isotope({ filter: filterValue });
        
        // Update active class
        $('.gallery-filter button').removeClass('active btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('active btn-primary');
    });

    // Initialize Magnific Popup
    $('.gallery-popup').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1]
        },
        image: {
            titleSrc: 'title'
        },
        zoom: {
            enabled: true,
            duration: 300
        }
    });

    // Load More functionality
    <?php if (!empty($use_load_more)): ?>
    var itemsPerPage = 6;
    var $items = $('.gallery-item');
    var totalItems = $items.length;
    var visibleItems = itemsPerPage;

    // Initially hide items beyond the first page
    $items.slice(itemsPerPage).hide();

    $('#loadMoreGallery').on('click', function() {
        visibleItems += itemsPerPage;
        $items.slice(0, visibleItems).show();
        $('.gallery-grid').isotope('layout');

        if (visibleItems >= totalItems) {
            $(this).hide();
        }
    });
    <?php endif; ?>
});
</script>
