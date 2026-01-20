<!-- Faculty Page Custom Styles -->
<style>
    .faculty-card {
        position: relative;
        border-radius: 8px !important;
        overflow: hidden !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
        border: none !important;
        transition: all 0.3s ease;
    }
    
    .faculty-card:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.12) !important;
        transform: translateY(-4px);
    }
    
    .faculty-card img {
        display: block;
        width: 100%;
        height: auto;
    }
</style>

<!-- ============================================
     INNER HERO SECTION
     ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>



<!-- Faculty Section -->
<section class="ftco-section">
    <div class="container">
        <!-- Search & Filter Bar -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="background: #f8f9fa;">
                    <div class="card-body">
                        <form action="<?= base_url('faculty/search') ?>" method="GET" id="filterForm" class="filter-form">
                            <div class="row align-items-end g-3">
                                <div class="col-md-6">
                                    <label for="searchInput" class="form-label fw-600 mb-2">Search Faculty</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text border-0 bg-white">
                                            <i class="fa fa-search text-muted"></i>
                                        </span>
                                        <input type="text" id="searchInput" name="q" class="form-control border-0 pl-0" placeholder="Name, email, or specialization..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                            <i class="fa fa-search mr-2"></i>Search
                                        </button>
                                        <a href="<?= base_url('faculty') ?>" class="btn btn-outline-secondary btn-lg">
                                            <i class="fa fa-redo mr-2"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Summary -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h4 class="mb-0">
                            <?php if (!empty($keyword)): ?>
                                Search Results for "<strong><?= htmlspecialchars($keyword) ?></strong>"
                            <?php else: ?>
                                <strong>All Faculty & Staff Members</strong>
                            <?php endif; ?>
                        </h4>
                        <p class="text-muted small mt-1">
                            Showing <?= !empty($faculty) ? count($faculty) : 0 ?> of <?= isset($total_pages) ? ($current_page - 1) * 12 + count($faculty) : '0' ?> members
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($faculty)): ?>
            <div style="display: grid; gap: 20px;">
                <?php foreach ($faculty as $member): ?>
                    <div class="faculty-card-horizontal" style="background: #faf8f6; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; gap: 24px; align-items: flex-start; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.12)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'">
                        
                        <!-- Left: Image -->
                        <div style="flex-shrink: 0;">
                            <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%); display: flex; align-items: center; justify-content: center;">
                                <?php if (!empty($member->photo)): ?>
                                    <img src="<?= base_url('assets/images/faculty/' . $member->photo) ?>" 
                                         alt="<?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <?php $favicon_url = !empty($site_favicon) ? base_url($site_favicon) : base_url('assets/img/favicon.png'); ?>
                                    <img src="<?= $favicon_url ?>" 
                                         alt="<?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>" 
                                         style="width: 100%; height: 100%; object-fit: cover; padding: 12px;">
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Center: Info -->
                        <div style="flex-grow: 1;">
                            <h4 class="card-title fw-700 mb-1" style="font-size: 1.3rem; color: #1a1a2e; margin: 0;">
                                <?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>
                            </h4>
                            
                            <p style="margin: 6px 0; font-size: 0.9rem; color: var(--theme-primary, #C7805C); font-weight: 600;">
                                <?= htmlspecialchars($member->title ?? 'Staff') ?>
                            </p>

                            <div style="display: flex; gap: 16px; margin: 12px 0; flex-wrap: wrap;">
                                <?php if (!empty($member->department_name)): ?>
                                    <span style="font-size: 0.85rem; color: #666;">
                                        <strong>Dept:</strong> <?= htmlspecialchars($member->department_name) ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if (!empty($member->email)): ?>
                                    <span style="font-size: 0.85rem; color: #666;">
                                        <i class="fa fa-envelope" style="color: var(--theme-secondary, #90B3A7); margin-right: 4px;"></i>
                                        <a href="mailto:<?= htmlspecialchars($member->email) ?>" style="color: #666; text-decoration: none;">
                                            <?= htmlspecialchars($member->email) ?>
                                        </a>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($member->specialization)): ?>
                                <p style="font-size: 0.9rem; color: #777; margin: 8px 0;">
                                    <i class="fa fa-flask" style="color: var(--theme-secondary, #90B3A7); margin-right: 6px;"></i>
                                    <?= htmlspecialchars($member->specialization) ?>
                                </p>
                            <?php endif; ?>
                            
                            <!-- Review Stats -->
                            <?php if (!empty($member->review_count) && $member->review_count > 0): ?>
                                <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #eee;">
                                    <span style="font-size: 0.85rem; color: #666;">
                                        <i class="fa fa-star" style="color: #ffc107; margin-right: 4px;"></i>
                                        <strong><?= number_format($member->average_rating, 1) ?></strong>
                                        <span style="color: #999;">(<?= $member->review_count ?> review<?= $member->review_count != 1 ? 's' : '' ?>)</span>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Right: Buttons -->
                        <div style="flex-shrink: 0; display: flex; gap: 12px; flex-direction: column; min-width: 110px;">
                            <a href="<?= base_url('faculty/view/' . $member->slug) ?>" class="btn btn-primary btn-sm" style="font-weight: 600; border: none; white-space: nowrap; padding: 8px 16px; width: 100%; text-align: center;">
                                <i class="fa fa-eye mr-2"></i>View
                            </a>
                            <button class="btn btn-outline-primary btn-sm review-btn" data-faculty-id="<?= $member->id ?>" data-faculty-name="<?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>" style="font-weight: 600; white-space: nowrap; padding: 8px 16px; width: 100%; text-align: center;">
                                <i class="fa fa-star mr-2"></i>Review
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if (!empty($total_pages) && $total_pages > 1): ?>
                <div class="row mt-6 mb-5">
                    <div class="col-12">
                        <nav aria-label="Page navigation" class="d-flex justify-content-center">
                            <ul class="pagination pagination-lg shadow-sm rounded">
                                <?php if ($current_page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('faculty?page=1') ?>" title="First page">
                                            <i class="fa fa-chevron-left"></i> First
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('faculty?page=' . ($current_page - 1)) ?>" title="Previous page">
                                            <i class="fa fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fa fa-chevron-left"></i> First</span>
                                    </li>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fa fa-chevron-left"></i></span>
                                    </li>
                                <?php endif; ?>

                                <?php 
                                    $start = max(1, $current_page - 2);
                                    $end = min($total_pages, $current_page + 2);
                                    
                                    if ($start > 1): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif;
                                    
                                    for ($i = $start; $i <= $end; $i++): ?>
                                        <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                                            <a class="page-link" href="<?= base_url('faculty?page=' . $i) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor;
                                    
                                    if ($end < $total_pages): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>

                                <?php if ($current_page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('faculty?page=' . ($current_page + 1)) ?>" title="Next page">
                                            <i class="fa fa-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('faculty?page=' . $total_pages) ?>" title="Last page">
                                            Last <i class="fa fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fa fa-chevron-right"></i></span>
                                    </li>
                                    <li class="page-item disabled">
                                        <span class="page-link">Last <i class="fa fa-chevron-right"></i></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <p class="text-center text-muted small mt-3">
                            Page <?= $current_page ?> of <?= $total_pages ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm bg-light p-5 text-center">
                        <div class="mb-4">
                            <i class="fa fa-search" style="font-size: 60px; color: #ccc;"></i>
                        </div>
                        <h4 class="card-title mb-2 fw-700">No Faculty Members Found</h4>
                        <p class="card-text text-muted mb-4">
                            <?php if (!empty($keyword)): ?>
                                We couldn't find any faculty members matching "<strong><?= htmlspecialchars($keyword) ?></strong>". 
                                <br>Try refining your search or browse all faculty.
                            <?php else: ?>
                                We are currently updating our faculty directory. Please check back soon.
                            <?php endif; ?>
                        </p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="<?= base_url('faculty') ?>" class="btn btn-primary btn-lg">
                                <i class="fa fa-arrow-left mr-2"></i>View All Faculty
                            </a>
                            <?php if (!empty($keyword)): ?>
                                <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg">
                                    <i class="fa fa-undo mr-2"></i>Go Back
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>


<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%); padding: 20px;">
                <h5 class="modal-title" id="reviewModalLabel" style="color: white; font-weight: 700;">
                    <i class="fa fa-star mr-2"></i>Write a Review
                    <br><small style="font-size: 0.8rem; font-weight: 500; opacity: 0.95;" id="reviewFacultyName">for Faculty Member</small>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.8;"></button>
            </div>
            <form id="reviewForm">
                <div class="modal-body" style="padding: 24px;">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    <input type="hidden" id="facultyId" name="faculty_id" value="">
                    
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


<!-- Final CTA -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>


<!-- Review Modal Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#ratingStars i');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');
    const reviewForm = document.getElementById('reviewForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertDiv = document.getElementById('reviewAlert');
    const alertMessage = document.getElementById('reviewAlertMessage');
    const reviewFacultyName = document.getElementById('reviewFacultyName');
    
    // Handle Review button clicks
    document.querySelectorAll('.review-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const facultyId = this.getAttribute('data-faculty-id');
            const facultyName = this.getAttribute('data-faculty-name');
            
            document.getElementById('facultyId').value = facultyId;
            reviewFacultyName.textContent = 'for ' + facultyName;
            
            // Reset form
            reviewForm.reset();
            ratingInput.value = 0;
            ratingText.textContent = 'Click to rate (1-5 stars)';
            stars.forEach(s => s.className = 'fa fa-star-o');
            alertDiv.style.display = 'none';
            document.querySelectorAll('.text-danger[id^="error_"]').forEach(el => el.style.display = 'none');
            
            // Show modal
            const modal = document.getElementById('reviewModal');
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        });
    });
    
    if (stars.length === 0) return;
    
    // Star rating click handler
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;
            
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.className = 'fa fa-star';
                } else {
                    s.className = 'fa fa-star-o';
                }
            });
            
            const labels = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            ratingText.textContent = labels[rating] + ' (' + rating + '/5)';
            
            const errorEl = document.getElementById('error_rating');
            if (errorEl) errorEl.style.display = 'none';
        });
        
        star.addEventListener('mouseover', function() {
            const rating = this.getAttribute('data-rating');
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.style.opacity = '1';
                    s.style.transform = 'scale(1.15)';
                } else {
                    s.style.opacity = '0.4';
                    s.style.transform = 'scale(1)';
                }
            });
        });
    });
    
    document.getElementById('ratingStars').addEventListener('mouseout', function() {
        stars.forEach((s, index) => {
            s.style.opacity = '1';
            s.style.transform = 'scale(1)';
        });
    });
    
    // Form submission
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
        
        fetch('<?= base_url("faculty/store_review") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
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
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) {
                        bsModal.hide();
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
                    alertMessage.textContent = data.message || 'An error occurred. Please try again.';
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
});
</script>

