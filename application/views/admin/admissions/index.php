<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Admissions</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Admissions</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/admissions/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Admission
        </a>
        <a href="<?= base_url('admin/admissions/export') . ($current_status ? '?status=' . $current_status : '') . ($current_program ? ($current_status ? '&' : '?') . 'program_id=' . $current_program : '') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-download me-2"></i>Export CSV
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
            <div class="stat-value"><?= $stats['total'] ?></div>
            <div class="stat-label">Total</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #ffc107, #e0a800);">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-value"><?= $stats['pending'] ?></div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card info">
            <div class="stat-icon"><i class="fas fa-search"></i></div>
            <div class="stat-value"><?= $stats['under_review'] ?></div>
            <div class="stat-label">Under Review</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value"><?= $stats['accepted'] ?></div>
            <div class="stat-label">Accepted</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="stat-value"><?= $stats['rejected'] ?></div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-value"><?= $stats['enrolled'] ?></div>
            <div class="stat-label">Enrolled</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Name, email, phone, reference..." value="<?= htmlspecialchars($search ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" <?= ($current_status === 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="under_review" <?= ($current_status === 'under_review') ? 'selected' : '' ?>>Under Review</option>
                    <option value="accepted" <?= ($current_status === 'accepted') ? 'selected' : '' ?>>Accepted</option>
                    <option value="rejected" <?= ($current_status === 'rejected') ? 'selected' : '' ?>>Rejected</option>
                    <option value="waitlisted" <?= ($current_status === 'waitlisted') ? 'selected' : '' ?>>Waitlisted</option>
                    <option value="enrolled" <?= ($current_status === 'enrolled') ? 'selected' : '' ?>>Enrolled</option>
                    <option value="withdrawn" <?= ($current_status === 'withdrawn') ? 'selected' : '' ?>>Withdrawn</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Program</label>
                <select name="program_id" class="form-select">
                    <option value="">All Programs</option>
                    <?php if (!empty($programs)): ?>
                        <?php foreach ($programs as $program): ?>
                            <option value="<?= $program->id ?>" <?= ($current_program == $program->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($program->name) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
                <a href="<?= base_url('admin/admissions') ?>" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Admissions Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Admissions (<?= $total_admissions ?>)</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="admissionsTable">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Applicant</th>
                        <th>Program</th>
                        <th>Qualification</th>
                        <th>Applied Date</th>
                        <th width="120">Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($admissions)): ?>
                        <?php foreach ($admissions as $admission): ?>
                            <tr class="<?= $admission->status === 'pending' && !$admission->is_read ? 'table-warning' : '' ?>">
                                <td>
                                    <strong><?= htmlspecialchars($admission->reference_number) ?></strong>
                                    <?php if (!$admission->is_read): ?>
                                        <span class="badge bg-danger ms-1">New</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($admission->full_name) ?></strong><br>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i><?= htmlspecialchars($admission->email) ?>
                                    </small>
                                    <?php if (!empty($admission->phone)): ?>
                                        <br><small class="text-muted">
                                            <i class="fas fa-phone me-1"></i><?= htmlspecialchars($admission->phone) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($admission->program_name)): ?>
                                        <span class="badge bg-info"><?= htmlspecialchars($admission->program_code ?? '') ?></span><br>
                                        <small><?= htmlspecialchars($admission->program_name) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">Not specified</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($admission->previous_qualification)): ?>
                                        <?= htmlspecialchars($admission->previous_qualification) ?>
                                        <?php if (!empty($admission->institution_name)): ?>
                                            <br><small class="text-muted"><?= htmlspecialchars($admission->institution_name) ?></small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small><?= date('M d, Y', strtotime($admission->created_at)) ?></small><br>
                                    <small class="text-muted"><?= date('H:i', strtotime($admission->created_at)) ?></small>
                                </td>
                                <td>
                                    <?php
                                    $status_classes = [
                                        'pending' => 'bg-warning text-dark',
                                        'under_review' => 'bg-info',
                                        'accepted' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                        'waitlisted' => 'bg-secondary',
                                        'enrolled' => 'bg-primary',
                                        'withdrawn' => 'bg-dark'
                                    ];
                                    $status_labels = [
                                        'pending' => 'Pending',
                                        'under_review' => 'Under Review',
                                        'accepted' => 'Accepted',
                                        'rejected' => 'Rejected',
                                        'waitlisted' => 'Waitlisted',
                                        'enrolled' => 'Enrolled',
                                        'withdrawn' => 'Withdrawn'
                                    ];
                                    $class = $status_classes[$admission->status] ?? 'bg-secondary';
                                    $label = $status_labels[$admission->status] ?? ucfirst($admission->status);
                                    ?>
                                    <span class="badge <?= $class ?>"><?= $label ?></span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('admin/admissions/view/' . $admission->uid) ?>" 
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/admissions/edit/' . $admission->uid) ?>" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete('<?= base_url('admin/admissions/delete/' . $admission->uid) ?>', 'admission')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>No admission applications found.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= base_url('admin/admissions?page=' . ($current_page - 1) . ($current_status ? '&status=' . $current_status : '') . ($current_program ? '&program_id=' . $current_program : '') . ($search ? '&search=' . urlencode($search) : '')) ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                        <li class="page-item <?= $i === $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="<?= base_url('admin/admissions?page=' . $i . ($current_status ? '&status=' . $current_status : '') . ($current_program ? '&program_id=' . $current_program : '') . ($search ? '&search=' . urlencode($search) : '')) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= base_url('admin/admissions?page=' . ($current_page + 1) . ($current_status ? '&status=' . $current_status : '') . ($current_program ? '&program_id=' . $current_program : '') . ($search ? '&search=' . urlencode($search) : '')) ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
