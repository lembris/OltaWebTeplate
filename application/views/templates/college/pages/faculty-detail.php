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
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div>
                            <h5 style="margin: 0; color: #333; font-weight: 700;">
                                <i class="fa fa-star mr-2" style="color: #ffc107;"></i>Student Reviews
                            </h5>
                            <div style="margin-top: 8px;">
                                <span id="reviewCount" style="color: #666; font-size: 0.9rem;"></span>
                                <span id="averageRating" style="margin-left: 16px; color: #666; font-size: 0.9rem; display: none;"></span>
                            </div>
                        </div>
                        <button class="btn btn-sm" style="background: var(--theme-primary, #C7805C); color: white; border: none; border-radius: 6px; padding: 8px 16px; font-weight: 600;" onclick="openReviewModal()">
                            <i class="fa fa-pencil mr-2"></i>Write Review
                        </button>
                    </div>

                    <div id="reviewsContainer" style="display: grid; gap: 16px;"></div>

                    <div id="reviewsPagination" style="margin-top: 20px; display: none; text-align: center;">
                        <nav aria-label="Review pagination">
                            <ul class="pagination justify-content-center" id="reviewPaginationList" style="gap: 4px;"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%); padding: 20px;">
                <h5 class="modal-title" id="reviewModalLabel" style="color: white; font-weight: 700;">
                    <i class="fa fa-star mr-2"></i>Write a Review
                    <?php if (isset($member)): ?>
                    <br><small style="font-size: 0.8rem; font-weight: 500; opacity: 0.95;">for <?php echo htmlspecialchars($member->first_name . ' ' . $member->last_name); ?></small>
                    <?php endif; ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.8;"></button>
            </div>
            <form id="reviewForm">
                <div class="modal-body" style="padding: 24px;">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" id="facultyId" name="faculty_id" value="<?php echo isset($member) ? $member->id : ''; ?>">
                    
                    <div id="reviewAlert" style="display: none; margin-bottom: 16px;" class="alert alert-dismissible fade show" role="alert">
                        <span id="reviewAlertMessage"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="studentName" style="font-weight: 600; color: #333; font-size: 0.9rem;">
                            <i class="fa fa-user mr-2" style="color: var(--theme-primary, #C7805C);"></i>Your Name
                        </label>
                        <input type="text" class="form-control" id="studentName" name="student_name" placeholder="Enter your full name" required style="border: 2px solid #e0e0e0; border-radius: 6px; padding: 10px;">
                        <small class="text-danger" id="error_student_name" style="display: none;"></small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="studentEmail" style="font-weight: 600; color: #333; font-size: 0.9rem;">
                            <i class="fa fa-envelope mr-2" style="color: var(--theme-primary, #C7805C);"></i>Email (optional)
                        </label>
                        <input type="email" class="form-control" id="studentEmail" name="email" placeholder="your@email.com" style="border: 2px solid #e0e0e0; border-radius: 6px; padding: 10px;">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; color: #333; font-size: 0.9rem; display: block; margin-bottom: 8px;">
                            <i class="fa fa-star mr-2" style="color: var(--theme-primary, #C7805C);"></i>Rating
                        </label>
                        <div id="ratingStars" style="font-size: 28px; cursor: pointer;">
                            <i class="fa fa-star-o" data-rating="1" style="margin-right: 12px; cursor: pointer; color: #ffc107;"></i>
                            <i class="fa fa-star-o" data-rating="2" style="margin-right: 12px; cursor: pointer; color: #ffc107;"></i>
                            <i class="fa fa-star-o" data-rating="3" style="margin-right: 12px; cursor: pointer; color: #ffc107;"></i>
                            <i class="fa fa-star-o" data-rating="4" style="margin-right: 12px; cursor: pointer; color: #ffc107;"></i>
                            <i class="fa fa-star-o" data-rating="5" style="cursor: pointer; color: #ffc107;"></i>
                        </div>
                        <input type="hidden" id="rating" name="rating" value="0" required>
                        <small class="text-muted" id="ratingText" style="display: block; margin-top: 6px; font-size: 0.8rem;">Click to rate (1-5 stars)</small>
                        <small class="text-danger" id="error_rating" style="display: none;"></small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="reviewTitle" style="font-weight: 600; color: #333; font-size: 0.9rem;">
                            <i class="fa fa-heading mr-2" style="color: var(--theme-primary, #C7805C);"></i>Review Title
                        </label>
                        <select class="form-control" id="reviewTitle" name="review_title" required style="border: 2px solid #e0e0e0; border-radius: 6px; padding: 10px;">
                            <option value="">Select a review title</option>
                            <option value="Excellent Teaching">Excellent Teaching</option>
                            <option value="Very Helpful">Very Helpful</option>
                            <option value="Great Instructor">Great Instructor</option>
                            <option value="Knowledgeable">Knowledgeable</option>
                            <option value="Inspiring Mentor">Inspiring Mentor</option>
                            <option value="Supportive">Supportive</option>
                            <option value="Engaging Classes">Engaging Classes</option>
                            <option value="Clear Explanations">Clear Explanations</option>
                            <option value="Good Experience">Good Experience</option>
                            <option value="Could Be Improved">Could Be Improved</option>
                        </select>
                        <small class="text-danger" id="error_review_title" style="display: none;"></small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="reviewText" style="font-weight: 600; color: #333; font-size: 0.9rem;">
                            <i class="fa fa-comments mr-2" style="color: var(--theme-primary, #C7805C);"></i>Your Review
                        </label>
                        <textarea class="form-control" id="reviewText" name="review_text" rows="4" placeholder="Share your experience..." required style="border: 2px solid #e0e0e0; border-radius: 6px; padding: 10px; resize: vertical;"></textarea>
                        <small class="text-danger" id="error_review_text" style="display: none;"></small>
                    </div>
                </div>
                <div class="modal-footer border-0" style="padding: 16px 24px; background: #f8f9fa;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 6px; padding: 8px 20px;">
                        <i class="fa fa-times mr-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn" id="submitBtn" style="background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%); color: white; border: none; border-radius: 6px; padding: 8px 20px; font-weight: 600;">
                        <i class="fa fa-check mr-2"></i><span>Submit Review</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const facultyId = <?php echo isset($member) ? $member->id : 'null'; ?>;
    const reviewsContainer = document.getElementById('reviewsContainer');
    const reviewCount = document.getElementById('reviewCount');
    const averageRating = document.getElementById('averageRating');
    const reviewsPagination = document.getElementById('reviewsPagination');
    const reviewPaginationList = document.getElementById('reviewPaginationList');
    const stars = document.querySelectorAll('#ratingStars i');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');
    const reviewForm = document.getElementById('reviewForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertDiv = document.getElementById('reviewAlert');
    const alertMessage = document.getElementById('reviewAlertMessage');

    // Open review modal
    window.openReviewModal = function() {
        const modal = document.getElementById('reviewModal');
        if (modal) {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
    };

    // Load reviews
    function loadReviews(page = 1) {
        if (!facultyId) return;
        fetch(`<?php echo base_url('faculty/get_reviews'); ?>/${facultyId}?page=${page}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderReviews(data);
                updateStats(data);
                if (data.total > 5) renderPagination(data);
            }
        })
        .catch(error => {
            console.error('Error loading reviews:', error);
        });
    }

    // Render reviews HTML
    function renderReviews(data) {
        if (!data.reviews || data.reviews.length === 0) return;
        let html = '';
        data.reviews.forEach(review => {
            const starHTML = getStarHTML(review.rating);
            const date = new Date(review.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            html += `
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #f0f1f4 100%);">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                            <div>
                                <h6 class="mb-0" style="color: #1a1a2e; font-weight: 600;">${review.student_name}</h6>
                                <small class="text-muted" style="font-size: 0.85rem;">${date}</small>
                            </div>
                            <span style="color: #ffc107;">${starHTML} <strong>${review.rating}.0</strong></span>
                        </div>
                        <p class="mb-2" style="font-weight: 600; color: var(--theme-primary, #C7805C);">${review.review_title}</p>
                        <p class="mb-0" style="font-size: 0.95rem; color: #555;">${review.review_text}</p>
                    </div>
                </div>
            `;
        });
        reviewsContainer.innerHTML = html;
    }

    function getStarHTML(rating) {
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            starsHtml += i <= rating ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>';
        }
        return starsHtml;
    }

    function updateStats(data) {
        if (data.total === 0) {
            reviewCount.textContent = 'No reviews yet';
            if (averageRating) averageRating.style.display = 'none';
        } else {
            reviewCount.textContent = `${data.total} review${data.total !== 1 ? 's' : ''}`;
            if (averageRating) {
                averageRating.innerHTML = `<i class="fa fa-star" style="color: #ffc107;"></i> <strong>${data.average_rating}</strong> average rating`;
                averageRating.style.display = 'inline';
            }
        }
    }

    function renderPagination(data) {
        if (data.total_pages <= 1) {
            reviewsPagination.style.display = 'none';
            return;
        }
        let paginationHTML = '';
        if (data.current_page > 1) {
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="loadReviews(${data.current_page - 1}); return false;">← Previous</a></li>`;
        }
        for (let i = 1; i <= data.total_pages; i++) {
            paginationHTML += i === data.current_page 
                ? `<li class="page-item active"><a class="page-link" href="#">${i}</a></li>`
                : `<li class="page-item"><a class="page-link" href="#" onclick="loadReviews(${i}); return false;">${i}</a></li>`;
        }
        if (data.current_page < data.total_pages) {
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="loadReviews(${data.current_page + 1}); return false;">Next →</a></li>`;
        }
        reviewPaginationList.innerHTML = paginationHTML;
        reviewsPagination.style.display = 'block';
    }

    // Star rating handler
    if (stars.length > 0) {
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;
                stars.forEach((s, index) => {
                    s.className = index < rating ? 'fa fa-star' : 'fa fa-star-o';
                });
                const labels = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
                ratingText.textContent = labels[rating] + ' (' + rating + '/5)';
                const errorEl = document.getElementById('error_rating');
                if (errorEl) errorEl.style.display = 'none';
            });
        });
    }

    // Form submission
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            document.querySelectorAll('.text-danger[id^="error_"]').forEach(el => el.style.display = 'none');
            alertDiv.style.display = 'none';
            
            if (ratingInput.value == 0) {
                const errorEl = document.getElementById('error_rating');
                if (errorEl) {
                    errorEl.textContent = 'Please select a rating';
                    errorEl.style.display = 'block';
                }
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Submitting...';
            
            const formData = new FormData(this);
            fetch('<?php echo base_url("faculty/store_review"); ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa fa-check mr-2"></i><span>Submit Review</span>';
                if (data.success) {
                    alertDiv.className = 'alert alert-success alert-dismissible fade show';
                    alertMessage.textContent = data.message;
                    alertDiv.style.display = 'block';
                    reviewForm.reset();
                    ratingInput.value = 0;
                    ratingText.textContent = 'Click to rate (1-5 stars)';
                    stars.forEach(s => s.className = 'fa fa-star-o');
                    setTimeout(() => {
                        const modal = document.getElementById('reviewModal');
                        if (modal) {
                            const bsModal = bootstrap.Modal.getInstance(modal);
                            if (bsModal) bsModal.hide();
                        }
                    }, 2000);
                } else {
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    if (data.errors) {
                        let errorMsg = 'Please fix the following errors:<ul style="margin-top: 8px; margin-bottom: 0;">';
                        for (let field in data.errors) {
                            errorMsg += '<li>' + data.errors[field] + '</li>';
                            const errorEl = document.getElementById('error_' + field);
                            if (errorEl) {
                                errorEl.textContent = data.errors[field];
                                errorEl.style.display = 'block';
                            }
                        }
                        errorMsg += '</ul>';
                        alertMessage.innerHTML = errorMsg;
                    } else {
                        alertMessage.textContent = data.message || 'An error occurred.';
                    }
                    alertDiv.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa fa-check mr-2"></i><span>Submit Review</span>';
                alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                alertMessage.textContent = 'An error occurred. Please try again.';
                alertDiv.style.display = 'block';
            });
        });
    }

    window.loadReviews = loadReviews;
    loadReviews();
});
</script>
