<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Faculty Detail Section -->
<section class="ftco-section">
    <div class="container">
        <!-- Header with Title and Department -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-2"><?= htmlspecialchars($member->title ?? 'Faculty Member') ?></h2>
                <p class="h5" style="color: var(--theme-primary, #C7805C); font-weight: 600; margin: 0;">
                    <i class="fa fa-building mr-2"></i><?= htmlspecialchars($member->department_name ?? '') ?>
                </p>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Photo & Contact -->
            <div class="col-lg-3">
                <!-- Faculty Photo -->
                <?php if (!empty($member->photo)): ?>
                    <div class="mb-4">
                        <img src="<?= base_url('assets/images/faculty/' . $member->photo) ?>" class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>" style="width: 100%;">
                    </div>
                <?php else: ?>
                    <div class="mb-4 bg-light d-flex align-items-center justify-content-center rounded shadow-sm" style="height: 320px; width: 100%;">
                        <?php $favicon_url = !empty($site_favicon) ? base_url($site_favicon) : base_url('assets/img/favicon.png'); ?>
                        <img src="<?= $favicon_url ?>" alt="<?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>" style="max-width: 70%; max-height: 70%; object-fit: contain;">
                    </div>
                <?php endif; ?>

                <!-- Contact Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase" style="color: var(--theme-primary, #C7805C); font-weight: 700; letter-spacing: 0.5px; font-size: 0.85rem;">Contact</h6>
                        <hr style="margin: 12px 0;">

                        <?php if (!empty($member->email)): ?>
                            <div class="mb-3">
                                <small class="d-block text-muted mb-1"><i class="fa fa-envelope mr-2" style="color: var(--theme-primary, #C7805C);"></i>Email</small>
                                <a href="mailto:<?= htmlspecialchars($member->email) ?>" style="color: var(--theme-primary, #C7805C); text-decoration: none; word-break: break-all;">
                                    <?= htmlspecialchars($member->email) ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($member->phone)): ?>
                            <div class="mb-3">
                                <small class="d-block text-muted mb-1"><i class="fa fa-phone mr-2" style="color: var(--theme-primary, #C7805C);"></i>Phone</small>
                                <a href="tel:<?= htmlspecialchars($member->phone) ?>" style="color: var(--theme-primary, #C7805C); text-decoration: none;">
                                    <?= htmlspecialchars($member->phone) ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($member->office_location)): ?>
                            <div class="mb-0">
                                <small class="d-block text-muted mb-1"><i class="fa fa-map-marker mr-2" style="color: var(--theme-primary, #C7805C);"></i>Office</small>
                                <span><?= htmlspecialchars($member->office_location) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Action Button -->
                <a href="<?= base_url('faculty') ?>" class="btn btn-outline-primary w-100">
                    <i class="fa fa-arrow-left mr-2"></i>Back to Faculty
                </a>
            </div>

            <!-- Right Column: Content -->
            <div class="col-lg-9">
                <!-- Biography Section -->
                <?php if (!empty($member->bio)): ?>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #1a1a2e; font-weight: 700; margin-bottom: 16px;">About</h5>
                            <div style="line-height: 1.8; color: #555;">
                                <?= nl2br($member->bio) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Education & Specialization Row -->
                <div class="row mb-4">
                    <!-- Education -->
                    <?php if (!empty($member->education)): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #1a1a2e; font-weight: 700; margin-bottom: 12px;">
                                        <i class="fa fa-graduation-cap mr-2" style="color: var(--theme-primary, #C7805C);"></i>Education
                                    </h5>
                                    <p style="color: #555; line-height: 1.6; margin: 0;">
                                        <?= nl2br(htmlspecialchars($member->education)) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Specialization -->
                    <?php if (!empty($member->specialization)): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #1a1a2e; font-weight: 700; margin-bottom: 12px;">
                                        <i class="fa fa-flask mr-2" style="color: var(--theme-primary, #C7805C);"></i>Specialization
                                    </h5>
                                    <p style="color: #555; line-height: 1.6; margin: 0;">
                                        <?= htmlspecialchars($member->specialization) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Research Interests -->
                <?php if (!empty($member->research_interests)): ?>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #1a1a2e; font-weight: 700; margin-bottom: 12px;">
                                <i class="fa fa-lightbulb-o mr-2" style="color: var(--theme-primary, #C7805C);"></i>Research Interests
                            </h5>
                            <p style="color: #555; line-height: 1.6; margin: 0;">
                                <?= nl2br(htmlspecialchars($member->research_interests)) ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Reviews Section -->
                <div class="mb-4">
                    <!-- Reviews Header with Stats -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
                        <div>
                            <h5 style="margin: 0; color: #1a1a2e; font-weight: 700;">
                                <i class="fa fa-star mr-2" style="color: #ffc107;"></i>Student Reviews
                            </h5>
                            <div id="reviewStats" style="margin-top: 8px;">
                                <span id="reviewCount" style="color: #666; font-size: 0.9rem;">Loading reviews...</span>
                                <span id="averageRating" style="margin-left: 16px; color: #666; font-size: 0.9rem; display: none;"></span>
                            </div>
                        </div>
                        <button class="btn" style="background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%); color: white; border: none; border-radius: 6px; padding: 10px 20px; font-weight: 600;" id="writeReviewBtn" onclick="openReviewModal()">
                            <i class="fa fa-pencil mr-2"></i>Write Review
                        </button>
                    </div>

                    <!-- Reviews Container -->
                    <div id="reviewsContainer" style="display: grid; gap: 16px;">
                        <div style="text-align: center; padding: 32px;">
                            <i class="fa fa-spinner fa-spin" style="font-size: 28px; color: var(--theme-primary, #C7805C);"></i>
                            <p style="margin-top: 12px; color: #999;">Loading reviews...</p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div id="reviewsPagination" style="margin-top: 20px; display: none; text-align: center;">
                        <nav aria-label="Review pagination">
                            <ul class="pagination justify-content-center" id="reviewPaginationList"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Review Modal -->
<?php include_once APPPATH . 'views/templates/college/modals/review-modal.php'; ?>

<script>
function openReviewModal() {
    const modal = document.getElementById('reviewModal');
    if (modal) {
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const facultyId = <?= isset($member) ? $member->id : 'null' ?>;
    const reviewsContainer = document.getElementById('reviewsContainer');
    const reviewCount = document.getElementById('reviewCount');
    const averageRating = document.getElementById('averageRating');
    const reviewsPagination = document.getElementById('reviewsPagination');
    const reviewPaginationList = document.getElementById('reviewPaginationList');
    
    if (!facultyId) return;
    
    // Load reviews
    function loadReviews(page = 1) {
        fetch(`<?= base_url('faculty/get_reviews') ?>/${facultyId}?page=${page}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderReviews(data);
                updateStats(data);
                if (data.total > 5) {
                    renderPagination(data);
                }
            } else {
                reviewsContainer.innerHTML = '<div style="text-align: center; padding: 32px; color: #999;">No reviews yet. Be the first to review!</div>';
                reviewCount.textContent = '0 reviews';
            }
        })
        .catch(error => {
            console.error('Error loading reviews:', error);
            reviewsContainer.innerHTML = '<div style="text-align: center; padding: 32px; color: #999;">Error loading reviews. Please try again.</div>';
        });
    }
    
    // Render reviews HTML
    function renderReviews(data) {
        if (!data.reviews || data.reviews.length === 0) {
            reviewsContainer.innerHTML = '<div style="text-align: center; padding: 32px; color: #999;">No reviews yet. Be the first to review!</div>';
            return;
        }
        
        let html = '';
        data.reviews.forEach(review => {
            const stars = getStarHTML(review.rating);
            const date = new Date(review.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            
            html += `
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #f0f1f4 100%); transition: all 0.3s;">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                            <div>
                                <h6 class="mb-1" style="color: #1a1a2e; font-weight: 600;">${review.student_name}</h6>
                                <small class="text-muted" style="font-size: 0.85rem;">${date}</small>
                            </div>
                            <span style="color: #ffc107; font-size: 0.95rem; white-space: nowrap;">
                                ${stars}
                                <span class="ml-2" style="color: #666; font-weight: 600;">${review.rating}.0</span>
                            </span>
                        </div>
                        <p class="text-muted small mb-2" style="font-weight: 600; color: var(--theme-primary, #C7805C);">${review.review_title}</p>
                        <p class="mb-0" style="font-size: 0.95rem; color: #555; line-height: 1.6;">${review.review_text}</p>
                    </div>
                </div>
            `;
        });
        
        reviewsContainer.innerHTML = html;
    }
    
    // Get star HTML
    function getStarHTML(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += '<i class="fa fa-star" style="margin-right: 2px;"></i>';
            } else {
                stars += '<i class="fa fa-star-o" style="margin-right: 2px;"></i>';
            }
        }
        return stars;
    }
    
    // Update stats
    function updateStats(data) {
        if (data.total === 0) {
            reviewCount.textContent = 'No reviews yet';
            averageRating.style.display = 'none';
        } else {
            reviewCount.textContent = `${data.total} review${data.total !== 1 ? 's' : ''}`;
            averageRating.innerHTML = `<i class="fa fa-star" style="color: #ffc107;"></i> <strong>${data.average_rating}</strong> average rating`;
            averageRating.style.display = 'inline';
        }
    }
    
    // Render pagination
    function renderPagination(data) {
        if (data.total_pages <= 1) {
            reviewsPagination.style.display = 'none';
            return;
        }
        
        let paginationHTML = '';
        
        // Previous button
        if (data.current_page > 1) {
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="loadReviews(${data.current_page - 1}); return false;">← Previous</a></li>`;
        }
        
        // Page numbers
        for (let i = 1; i <= data.total_pages; i++) {
            if (i === data.current_page) {
                paginationHTML += `<li class="page-item active"><a class="page-link" href="#">${i}</a></li>`;
            } else {
                paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="loadReviews(${i}); return false;">${i}</a></li>`;
            }
        }
        
        // Next button
        if (data.current_page < data.total_pages) {
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="loadReviews(${data.current_page + 1}); return false;">Next →</a></li>`;
        }
        
        reviewPaginationList.innerHTML = paginationHTML;
        reviewsPagination.style.display = 'block';
    }
    
    // Make loadReviews accessible globally for pagination
    window.loadReviews = loadReviews;
    
    // Initial load
    loadReviews();
});
</script>
