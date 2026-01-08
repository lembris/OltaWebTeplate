<?php $this->load->view('includes/header'); ?>

<div class="container-fluid page-wrapper">
    <div class="page-header mb-4">
        <h1><?php echo htmlspecialchars($member->first_name . ' ' . $member->last_name); ?></h1>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?php if (!empty($member->photo)): ?>
                <img src="<?php echo base_url($member->photo); ?>" class="img-fluid rounded mb-4" alt="<?php echo htmlspecialchars($member->first_name); ?>">
            <?php else: ?>
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded mb-4" style="height: 400px;">
                    <i class="fas fa-user fa-5x"></i>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Title:</dt>
                        <dd class="col-sm-8"><?php echo htmlspecialchars($member->title); ?></dd>

                        <dt class="col-sm-4">Department:</dt>
                        <dd class="col-sm-8"><?php echo htmlspecialchars($member->department_name); ?></dd>

                        <?php if (!empty($member->email)): ?>
                            <dt class="col-sm-4">Email:</dt>
                            <dd class="col-sm-8"><a href="mailto:<?php echo htmlspecialchars($member->email); ?>"><?php echo htmlspecialchars($member->email); ?></a></dd>
                        <?php endif; ?>

                        <?php if (!empty($member->phone)): ?>
                            <dt class="col-sm-4">Phone:</dt>
                            <dd class="col-sm-8"><a href="tel:<?php echo htmlspecialchars($member->phone); ?>"><?php echo htmlspecialchars($member->phone); ?></a></dd>
                        <?php endif; ?>

                        <?php if (!empty($member->office_location)): ?>
                            <dt class="col-sm-4">Office:</dt>
                            <dd class="col-sm-8"><?php echo htmlspecialchars($member->office_location); ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($member->office_hours)): ?>
                            <dt class="col-sm-4">Office Hours:</dt>
                            <dd class="col-sm-8"><?php echo htmlspecialchars($member->office_hours); ?></dd>
                        <?php endif; ?>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <?php if (!empty($member->bio)): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Biography</h5>
                    </div>
                    <div class="card-body">
                        <?php echo nl2br(htmlspecialchars($member->bio)); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($member->specialization)): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Specialization</h5>
                    </div>
                    <div class="card-body">
                        <?php echo htmlspecialchars($member->specialization); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($member->qualifications)): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Qualifications</h5>
                    </div>
                    <div class="card-body">
                        <?php echo nl2br(htmlspecialchars($member->qualifications)); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Reviews Section -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fa fa-star text-warning mr-2"></i>Student Reviews
                    </h5>
                    <button class="btn btn-sm btn-primary" id="writeReviewBtn" onclick="openReviewModal()">
                        <i class="fa fa-pencil mr-1"></i>Write Review
                    </button>
                </div>
                <div class="card-body">
                    <div id="reviewsContainer">
                        <div class="text-center text-muted py-4">
                            <i class="fa fa-spinner fa-spin mr-2"></i>Loading reviews...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?php echo base_url('faculty'); ?>" class="btn btn-outline-secondary">Back to Faculty List</a>
    </div>
</div>

<!-- Include Review Modal -->
<?php $this->load->view('templates/college/modals/review-modal'); ?>

<script>
function openReviewModal() {
    const modal = document.getElementById('reviewModal');
    if (modal) {
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const facultyId = <?php echo $member->id; ?>;
    const reviewsContainer = document.getElementById('reviewsContainer');
    
    // Load reviews via AJAX
    fetch('<?php echo base_url("faculty/get_reviews"); ?>/' + facultyId)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.reviews && data.reviews.length > 0) {
                let reviewsHtml = '';
                data.reviews.forEach(review => {
                    const stars = '<i class="fa fa-star text-warning"></i>'.repeat(review.rating) + 
                                 '<i class="fa fa-star-o text-warning"></i>'.repeat(5 - review.rating);
                    const reviewDate = new Date(review.created_at).toLocaleDateString();
                    
                    reviewsHtml += `
                        <div class="review-item border-bottom pb-3 mb-3" style="last-child: {border-bottom: none}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-0">${escapeHtml(review.review_title)}</h6>
                                    <small class="text-muted">${escapeHtml(review.student_name)} - ${reviewDate}</small>
                                </div>
                                <div class="text-warning">${stars}</div>
                            </div>
                            <p class="mb-0 text-secondary">${escapeHtml(review.review_text)}</p>
                        </div>
                    `;
                });
                reviewsContainer.innerHTML = reviewsHtml;
            } else {
                reviewsContainer.innerHTML = '<div class="text-center text-muted py-4">No reviews yet. Be the first to review!</div>';
            }
        })
        .catch(error => {
            console.error('Error loading reviews:', error);
            reviewsContainer.innerHTML = '<div class="alert alert-danger">Error loading reviews</div>';
        });
    
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
});
</script>

<?php $this->load->view('includes/footer'); ?>
