<!-- Review Modal Component -->
<!-- Usage: <?php include_once APPPATH . 'views/templates/college/modals/review-modal.php'; ?> -->
<!-- Pass the faculty member object before including this modal -->

<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header with Theme Gradient -->
            <div class="modal-header border-0" style="background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%); padding: 24px;">
                <h5 class="modal-title" id="reviewModalLabel" style="color: white; font-weight: 700;">
                    <i class="fa fa-star mr-2"></i>Write a Review
                    <?php if (isset($member)): ?>
                        <br><small style="font-size: 0.8rem; font-weight: 500; opacity: 0.95;">for <?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?></small>
                    <?php endif; ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.8;"></button>
            </div>

            <!-- Modal Body -->
            <form id="reviewForm">
                <div class="modal-body" style="padding: 28px;">
                    <!-- CSRF Token -->
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    
                    <!-- Hidden Faculty ID -->
                    <input type="hidden" id="facultyId" name="faculty_id" value="<?= isset($member) ? $member->id : '' ?>">

                    <!-- Alert for errors/success -->
                    <div id="reviewAlert" style="display: none; margin-bottom: 16px;" class="alert alert-dismissible fade show" role="alert">
                        <span id="reviewAlertMessage"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <!-- Student Name -->
                    <div class="form-group mb-4">
                        <label for="studentName" style="font-weight: 600; color: #1a1a2e; font-size: 0.95rem;">
                            <i class="fa fa-user mr-2" style="color: var(--theme-primary, #C7805C);"></i>Your Name
                        </label>
                        <input type="text" class="form-control" id="studentName" name="student_name" placeholder="Enter your full name" required style="border: 2px solid #e0e0e0; border-radius: 6px; padding: 12px; transition: all 0.3s;">
                        <small class="form-text text-danger" id="error_student_name" style="display: none;"></small>
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-4">
                        <label for="studentEmail" style="font-weight: 600; color: #1a1a2e; font-size: 0.95rem;">
                            <i class="fa fa-envelope mr-2" style="color: var(--theme-primary, #C7805C);"></i>Email (optional)
                        </label>
                        <input type="email" class="form-control" id="studentEmail" name="email" placeholder="your@email.com" style="border: 2px solid #e0e0e0; border-radius: 6px; padding: 12px; transition: all 0.3s;">
                        <small class="form-text text-muted">We won't share your email with anyone</small>
                        <small class="form-text text-danger" id="error_email" style="display: none;"></small>
                    </div>

                    <!-- Rating -->
                    <div class="form-group mb-4">
                        <label style="font-weight: 600; color: #1a1a2e; font-size: 0.95rem; display: block; margin-bottom: 12px;">
                            <i class="fa fa-star mr-2" style="color: var(--theme-primary, #C7805C);"></i>Rating
                        </label>
                        <div id="ratingStars" style="font-size: 32px; cursor: pointer; margin-bottom: 10px;">
                            <i class="fa fa-star-o" data-rating="1" style="margin-right: 16px; cursor: pointer; transition: all 0.2s; color: #ffc107;"></i>
                            <i class="fa fa-star-o" data-rating="2" style="margin-right: 16px; cursor: pointer; transition: all 0.2s; color: #ffc107;"></i>
                            <i class="fa fa-star-o" data-rating="3" style="margin-right: 16px; cursor: pointer; transition: all 0.2s; color: #ffc107;"></i>
                            <i class="fa fa-star-o" data-rating="4" style="margin-right: 16px; cursor: pointer; transition: all 0.2s; color: #ffc107;"></i>
                            <i class="fa fa-star-o" data-rating="5" style="cursor: pointer; transition: all 0.2s; color: #ffc107;"></i>
                        </div>
                        <input type="hidden" id="rating" name="rating" value="0" required>
                        <small class="text-muted" id="ratingText" style="display: block; margin-top: 8px;">Click to rate (1-5 stars)</small>
                        <small class="form-text text-danger" id="error_rating" style="display: none;"></small>
                    </div>

                    <!-- Review Title -->
                    <div class="form-group mb-4">
                        <label for="reviewTitle" style="font-weight: 600; color: #1a1a2e; font-size: 0.95rem;">
                            <i class="fa fa-heading mr-2" style="color: var(--theme-primary, #C7805C);"></i>Review Title
                        </label>
                        <input type="text" class="form-control" id="reviewTitle" name="review_title" placeholder="e.g., Excellent teaching methodology" required style="border: 2px solid #e0e0e0; border-radius: 6px; padding: 12px; transition: all 0.3s;">
                        <small class="form-text text-muted">Brief summary of your review</small>
                        <small class="form-text text-danger" id="error_review_title" style="display: none;"></small>
                    </div>

                    <!-- Review Text -->
                    <div class="form-group mb-4">
                        <label for="reviewText" style="font-weight: 600; color: #1a1a2e; font-size: 0.95rem;">
                            <i class="fa fa-comments mr-2" style="color: var(--theme-primary, #C7805C);"></i>Your Review
                        </label>
                        <textarea class="form-control" id="reviewText" name="review_text" rows="5" placeholder="Share your detailed feedback and experience..." required style="border: 2px solid #e0e0e0; border-radius: 6px; padding: 12px; transition: all 0.3s; resize: vertical; font-family: 'Poppins', sans-serif;"></textarea>
                        <small class="form-text text-muted">Minimum 20 characters, maximum 5000</small>
                        <small class="form-text text-danger" id="error_review_text" style="display: none;"></small>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0" style="padding: 16px 28px; background: #f8f9fa;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 6px; padding: 10px 24px;">
                        <i class="fa fa-times mr-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn" id="submitBtn" style="background: linear-gradient(135deg, var(--theme-primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%); color: white; border: none; border-radius: 6px; padding: 10px 24px; font-weight: 600;">
                        <i class="fa fa-check mr-2"></i><span id="submitBtnText">Submit Review</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#ratingStars i');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');
    const reviewForm = document.getElementById('reviewForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertDiv = document.getElementById('reviewAlert');
    const alertMessage = document.getElementById('reviewAlertMessage');
    
    if (stars.length === 0) return;
    
    // Star rating click handler
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;
            
            // Update star display
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.className = 'fa fa-star';
                } else {
                    s.className = 'fa fa-star-o';
                }
            });
            
            // Update rating label
            const labels = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            ratingText.textContent = labels[rating] + ' (' + rating + '/5)';
            
            // Clear error if exists
            const errorEl = document.getElementById('error_rating');
            if (errorEl) errorEl.style.display = 'none';
        });
        
        // Hover effect
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
    
    // Form focus handlers for better UX
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--theme-primary, #C7805C)';
            this.style.boxShadow = '0 0 0 3px rgba(199, 128, 92, 0.1)';
        });
        input.addEventListener('blur', function() {
            this.style.borderColor = '#e0e0e0';
            this.style.boxShadow = 'none';
        });
    });
    
    // Form submission
    reviewForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('.text-danger[id^="error_"]').forEach(el => el.style.display = 'none');
        alertDiv.style.display = 'none';
        
        // Validate rating
        if (ratingInput.value == 0) {
            const errorEl = document.getElementById('error_rating');
            if (errorEl) {
                errorEl.textContent = 'Please select a rating';
                errorEl.style.display = 'block';
            }
            return;
        }
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Submitting...';
        
        // Send AJAX request
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
            submitBtn.innerHTML = '<i class="fa fa-check mr-2"></i><span id="submitBtnText">Submit Review</span>';
            
            if (data.success) {
                // Show success message
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertMessage.textContent = data.message;
                alertDiv.style.display = 'block';
                
                // Reset form
                reviewForm.reset();
                ratingInput.value = 0;
                ratingText.textContent = 'Click to rate (1-5 stars)';
                stars.forEach(s => s.className = 'fa fa-star-o');
                
                // Close modal after 2 seconds
                setTimeout(() => {
                    const modal = document.getElementById('reviewModal');
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) {
                        bsModal.hide();
                    }
                }, 2000);
            } else {
                // Show error message
                alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                
                if (data.errors) {
                    // Show field-specific errors
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
            submitBtn.innerHTML = '<i class="fa fa-check mr-2"></i><span id="submitBtnText">Submit Review</span>';
            
            alertDiv.className = 'alert alert-danger alert-dismissible fade show';
            alertMessage.textContent = 'An error occurred. Please try again.';
            alertDiv.style.display = 'block';
        });
    });
});
</script>
