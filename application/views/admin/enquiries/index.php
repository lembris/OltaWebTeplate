<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Safari Enquiries</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Safari Enquiries</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/enquiries/export') . ($current_status ? '?status=' . $current_status : '') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-download me-2"></i>Export CSV
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-envelope"></i></div>
            <div class="stat-value"><?= $stats->total ?></div>
            <div class="stat-label">Total</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class="stat-value"><?= $stats->new ?></div>
            <div class="stat-label">New</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card info">
            <div class="stat-icon"><i class="fas fa-eye"></i></div>
            <div class="stat-value"><?= $stats->read ?></div>
            <div class="stat-label">Read</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-reply"></i></div>
            <div class="stat-value"><?= $stats->replied ?></div>
            <div class="stat-label">Replied</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #6c757d, #495057);">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value"><?= $stats->closed ?></div>
            <div class="stat-label">Closed</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6 mb-3">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-value"><?= $stats->today ?></div>
            <div class="stat-label">Today</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Name, email, phone, reference..." value="<?= htmlspecialchars($search ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="new" <?= ($current_status === 'new') ? 'selected' : '' ?>>New</option>
                    <option value="read" <?= ($current_status === 'read') ? 'selected' : '' ?>>Read</option>
                    <option value="replied" <?= ($current_status === 'replied') ? 'selected' : '' ?>>Replied</option>
                    <option value="closed" <?= ($current_status === 'closed') ? 'selected' : '' ?>>Closed</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
                <a href="<?= base_url('admin/enquiries') ?>" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Enquiries Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Enquiries (<?= $total_enquiries ?>)</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="enquiriesTable">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Trip Details</th>
                        <th>Travelers</th>
                        <th>Date</th>
                        <th width="100">Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($enquiries)): ?>
                        <?php foreach ($enquiries as $enquiry): ?>
                            <tr class="<?= $enquiry->status === 'new' ? 'table-warning' : '' ?>">
                                <td>
                                    <strong><?= htmlspecialchars($enquiry->reference_number) ?></strong>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($enquiry->full_name) ?></strong><br>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i><?= htmlspecialchars($enquiry->email) ?>
                                    </small>
                                    <?php if (!empty($enquiry->phone)): ?>
                                        <br><small class="text-muted">
                                            <i class="fas fa-phone me-1"></i><?= htmlspecialchars($enquiry->phone) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($enquiry->trip_type)): ?>
                                        <span class="badge bg-info"><?= htmlspecialchars($enquiry->trip_type) ?></span><br>
                                    <?php endif; ?>
                                    <?php if (!empty($enquiry->duration)): ?>
                                        <small class="text-muted"><?= htmlspecialchars($enquiry->duration) ?></small>
                                    <?php endif; ?>
                                    <?php if (!empty($enquiry->budget)): ?>
                                        <br><small class="text-success"><?= htmlspecialchars($enquiry->budget) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <i class="fas fa-users me-1"></i>
                                    <?= ($enquiry->adults ?? 1) ?> Adult(s)
                                    <?php if (($enquiry->children ?? 0) > 0): ?>
                                        , <?= $enquiry->children ?> Child(ren)
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small><?= date('M d, Y', strtotime($enquiry->created_at)) ?></small><br>
                                    <small class="text-muted"><?= date('H:i', strtotime($enquiry->created_at)) ?></small>
                                </td>
                                <td>
                                    <?php
                                    $status_classes = [
                                        'new' => 'bg-danger',
                                        'read' => 'bg-info',
                                        'replied' => 'bg-primary',
                                        'closed' => 'bg-secondary'
                                    ];
                                    $class = $status_classes[$enquiry->status] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $class ?>"><?= ucfirst($enquiry->status) ?></span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('admin/enquiries/view/' . $enquiry->uid) ?>" 
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/enquiries/edit/' . $enquiry->uid) ?>" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/enquiries/reply/' . $enquiry->uid) ?>" 
                                           class="btn btn-sm btn-outline-success" title="Reply">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete('<?= base_url('admin/enquiries/delete/' . $enquiry->uid) ?>', 'enquiry')">
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
                                    <p>No enquiries found.</p>
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
                            <a class="page-link" href="<?= base_url('admin/enquiries?page=' . ($current_page - 1) . ($current_status ? '&status=' . $current_status : '') . ($search ? '&search=' . urlencode($search) : '')) ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                        <li class="page-item <?= $i === $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="<?= base_url('admin/enquiries?page=' . $i . ($current_status ? '&status=' . $current_status : '') . ($search ? '&search=' . urlencode($search) : '')) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= base_url('admin/enquiries?page=' . ($current_page + 1) . ($current_status ? '&status=' . $current_status : '') . ($search ? '&search=' . urlencode($search) : '')) ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
