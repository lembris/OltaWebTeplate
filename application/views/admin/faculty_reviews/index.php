<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="h3 d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-star text-warning"></i>Faculty Reviews
                    </h1>
                    <p class="text-muted mb-0">Manage and moderate student reviews for faculty members</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Theme Info -->
    <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
        <i class="fas fa-palette me-3 fa-lg"></i>
        <div>
            <strong>Active Theme:</strong> <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template) ?></span>
            <span class="ms-3 text-muted">Showing reviews for "<?= ucfirst($active_template) ?>" theme</span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small mb-2">Total Reviews</h6>
                    <h3 class="mb-0"><?= $stats['total'] ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small mb-2">Pending Approval</h6>
                    <h3 class="mb-0 text-warning"><?= $stats['pending'] ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small mb-2">Approved</h6>
                    <h3 class="mb-0 text-success"><?= $stats['approved'] ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small mb-2">Rejected</h6>
                    <h3 class="mb-0 text-danger"><?= $stats['rejected'] ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i><?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i><?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filters and Tools -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <!-- Search -->
                <div class="col-md-4">
                    <label class="form-label small fw-600">Search</label>
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Name, title, or text..." 
                           value="<?= isset($filters['search']) ? $filters['search'] : '' ?>">
                </div>

                <!-- Status Filter -->
                <div class="col-md-3">
                    <label class="form-label small fw-600">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Statuses</option>
                        <option value="pending" <?= $filters['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= $filters['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="rejected" <?= $filters['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>

                <!-- Faculty Filter -->
                <div class="col-md-3">
                    <label class="form-label small fw-600">Faculty</label>
                    <select name="faculty_id" class="form-select form-select-sm">
                        <option value="">All Faculty</option>
                        <?php foreach ($faculty_list as $faculty): ?>
                            <option value="<?= $faculty->id ?>" 
                                    <?= $filters['faculty_id'] == $faculty->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($faculty->first_name . ' ' . $faculty->last_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Rating Filter -->
                <div class="col-md-2">
                    <label class="form-label small fw-600">Rating</label>
                    <select name="rating" class="form-select form-select-sm">
                        <option value="">All Ratings</option>
                        <option value="5" <?= $filters['rating'] == '5' ? 'selected' : '' ?>>★★★★★ (5)</option>
                        <option value="4" <?= $filters['rating'] == '4' ? 'selected' : '' ?>>★★★★☆ (4)</option>
                        <option value="3" <?= $filters['rating'] == '3' ? 'selected' : '' ?>>★★★☆☆ (3)</option>
                        <option value="2" <?= $filters['rating'] == '2' ? 'selected' : '' ?>>★★☆☆☆ (2)</option>
                        <option value="1" <?= $filters['rating'] == '1' ? 'selected' : '' ?>>★☆☆☆☆ (1)</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="<?= base_url('admin/faculty_reviews') ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                    <a href="<?= base_url('admin/faculty_reviews/export?status=' . $filters['status'] . '&faculty_id=' . $filters['faculty_id']) ?>" 
                       class="btn btn-outline-primary btn-sm float-end">
                        <i class="fas fa-download mr-2"></i>Export CSV
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 30px;">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th>Student Name</th>
                        <th>Faculty</th>
                        <th style="width: 80px;">Rating</th>
                        <th>Review</th>
                        <th style="width: 100px;">Status</th>
                        <th>Date</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reviews)): ?>
                        <?php foreach ($reviews as $review): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input review-checkbox" value="<?= $review->uid ?>">
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($review->student_name) ?></strong>
                                    <?php if ($review->email): ?>
                                        <br><small class="text-muted"><?= htmlspecialchars($review->email) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/faculty_reviews?faculty_id=' . $review->faculty_id) ?>">
                                        <?= htmlspecialchars($review->first_name . ' ' . $review->last_name) ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="text-warning">
                                        <?php for ($i = 0; $i < $review->rating; $i++): ?>
                                            <i class="fas fa-star"></i>
                                        <?php endfor; ?>
                                        <?php for ($i = $review->rating; $i < 5; $i++): ?>
                                            <i class="fas fa-star-half-alt text-muted"></i>
                                        <?php endfor; ?>
                                    </span>
                                    <strong><?= $review->rating ?>/5</strong>
                                </td>
                                <td>
                                    <div style="max-width: 300px;">
                                        <strong><?= htmlspecialchars($review->review_title) ?></strong>
                                        <br><small class="text-muted text-truncate d-block">
                                            <?= htmlspecialchars(substr($review->review_text, 0, 80)) ?>...
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge 
                                        <?php
                                            if ($review->status == 'approved') {
                                                echo 'bg-success';
                                            } elseif ($review->status == 'pending') {
                                                echo 'bg-warning text-dark';
                                            } else {
                                                echo 'bg-danger';
                                            }
                                        ?>">
                                        <?= ucfirst($review->status) ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('M d, Y', strtotime($review->created_at)) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('admin/faculty_reviews/view/' . $review->uid) ?>" 
                                           class="btn btn-outline-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($review->status != 'approved'): ?>
                                            <button type="button" class="btn btn-outline-success approve-btn" 
                                                    data-uid="<?= $review->uid ?>" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($review->status != 'rejected'): ?>
                                            <button type="button" class="btn btn-outline-danger reject-btn" 
                                                    data-uid="<?= $review->uid ?>" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox" style="font-size: 32px; opacity: 0.3;"></i>
                                <p class="mt-2">No reviews found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
        <nav class="mt-4" aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=1&<?= http_build_query($filters) ?>">First</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                    <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&<?= http_build_query($filters) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $total_pages ?>&<?= http_build_query($filters) ?>">Last</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<!-- Hidden form templates for AJAX-like POST requests -->
<form id="approveForm" method="POST" style="display: none;">
    <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
</form>
<form id="rejectForm" method="POST" style="display: none;">
    <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.review-checkbox').forEach(cb => {
            cb.checked = this.checked;
        });
    });

    // Approve button handler
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const reviewUid = this.dataset.uid;
            if (confirm('Are you sure you want to approve this review?')) {
                const form = document.getElementById('approveForm');
                form.action = '<?= base_url("admin/faculty_reviews/approve") ?>/' + reviewUid;
                form.submit();
            }
        });
    });

    // Reject button handler
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const reviewUid = this.dataset.uid;
            if (confirm('Are you sure you want to reject this review?')) {
                const form = document.getElementById('rejectForm');
                form.action = '<?= base_url("admin/faculty_reviews/reject") ?>/' + reviewUid;
                form.submit();
            }
        });
    });
});
</script>
