<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="<?= base_url('admin/reviews') ?>" class="text-decoration-none">
                <i class="fas fa-arrow-left mr-2"></i>Back to Reviews
            </a>
            <h1 class="h3 mt-2">Review Details</h1>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <!-- Reviewer Info -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h5 class="mb-3">Reviewer Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Name:</strong><br>
                                    <?= htmlspecialchars($review->student_name) ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Email:</strong><br>
                                    <?= htmlspecialchars($review->email ?: 'Not provided') ?>
                                </p>
                            </div>
                        </div>
                        <p class="mb-0">
                            <small class="text-muted">
                                <i class="fas fa-globe mr-2"></i>IP: <?= $review->ip_address ?>
                                <br><i class="fas fa-calendar mr-2"></i>Submitted: <?= date('F d, Y H:i A', strtotime($review->created_at)) ?>
                            </small>
                        </p>
                    </div>

                    <!-- Faculty Info -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h5 class="mb-3">Faculty Member</h5>
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                <h6 class="mb-1">
                                    <a href="<?= base_url('admin/faculty_staff/edit/' . $review->faculty_id) ?>">
                                        <?= htmlspecialchars($review->first_name . ' ' . $review->last_name) ?>
                                    </a>
                                </h6>
                                <small class="text-muted">Click to edit faculty profile</small>
                            </div>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h5 class="mb-3">Rating</h5>
                        <div style="font-size: 24px;">
                            <span class="text-warning">
                                <?php for ($i = 0; $i < $review->rating; $i++): ?>
                                    <i class="fas fa-star"></i>
                                <?php endfor; ?>
                                <?php for ($i = $review->rating; $i < 5; $i++): ?>
                                    <i class="fas fa-star text-muted" style="opacity: 0.3;"></i>
                                <?php endfor; ?>
                            </span>
                            <strong class="ml-3" style="font-size: 18px;"><?= $review->rating ?>/5</strong>
                        </div>
                    </div>

                    <!-- Review Title -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h5 class="mb-3">Review Title</h5>
                        <h6><?= htmlspecialchars($review->review_title) ?></h6>
                    </div>

                    <!-- Review Text -->
                    <div class="mb-4">
                        <h5 class="mb-3">Review Text</h5>
                        <div class="bg-light p-4 rounded" style="line-height: 1.8;">
                            <?= nl2br(htmlspecialchars($review->review_text)) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">Status</h6>
                    <div class="mb-3">
                        <span class="badge 
                            <?php
                                if ($review->status == 'approved') {
                                    echo 'bg-success';
                                } elseif ($review->status == 'pending') {
                                    echo 'bg-warning text-dark';
                                } else {
                                    echo 'bg-danger';
                                }
                            ?> fs-6 px-3 py-2">
                            <?= ucfirst($review->status) ?>
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="btn-group-vertical w-100" role="group">
                        <?php if ($review->status != 'approved'): ?>
                            <button type="button" class="btn btn-success mb-2 w-100" 
                                    onclick="confirmAction('<?= base_url('admin/reviews/approve/' . $review->uid) ?>', 'approve', 'review')">
                                <i class="fas fa-check me-2"></i>Approve Review
                            </button>
                        <?php endif; ?>

                        <?php if ($review->status != 'rejected'): ?>
                            <button type="button" class="btn btn-warning mb-2 w-100" 
                                    onclick="confirmAction('<?= base_url('admin/reviews/reject/' . $review->uid) ?>', 'reject', 'review')">
                                <i class="fas fa-ban me-2"></i>Reject Review
                            </button>
                        <?php endif; ?>

                        <button type="button" class="btn btn-danger w-100" 
                                onclick="confirmDelete('<?= base_url('admin/reviews/delete/' . $review->uid) ?>', 'review')">
                            <i class="fas fa-trash me-2"></i>Delete Review
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">Details</h6>
                    <small class="text-muted d-block mb-2">
                        <strong>Review ID:</strong> #<?= $review->id ?>
                    </small>
                    <small class="text-muted d-block mb-2">
                        <strong>Review UID:</strong> <?= $review->uid ?>
                    </small>
                    <small class="text-muted d-block mb-2">
                        <strong>Created:</strong> <?= date('M d, Y H:i A', strtotime($review->created_at)) ?>
                    </small>
                    <small class="text-muted d-block mb-2">
                        <strong>Updated:</strong> <?= date('M d, Y H:i A', strtotime($review->updated_at)) ?>
                    </small>
                    <small class="text-muted d-block">
                        <strong>IP Address:</strong> <?= $review->ip_address ?>
                    </small>
                </div>
            </div>
        </div>
        </div>
        </div>
