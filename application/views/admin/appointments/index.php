<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Appointments</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Appointments</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/appointments/export') ?>" class="btn btn-success">
            <i class="fas fa-file-export me-2"></i>Export CSV
        </a>
    </div>
</div>

<!-- Active Theme Info -->
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="fas fa-calendar-check me-3 fa-lg"></i>
    <div>
        <strong>Active Theme:</strong> <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template) ?></span>
        <span class="ms-3 text-muted">Showing appointments for "<?= ucfirst($active_template) ?>" theme and universal appointments (template = "all")</span>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-value"><?= $stats['total'] ?></div>
            <div class="stat-label">Total Appointments</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-value"><?= $stats['pending'] ?></div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value"><?= $stats['confirmed'] ?></div>
            <div class="stat-label">Confirmed</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-check-double"></i></div>
            <div class="stat-value"><?= $stats['completed'] ?></div>
            <div class="stat-label">Completed</div>
        </div>
    </div>
</div>

<!-- Appointments Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Appointments</span>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
            <button type="button" class="btn btn-outline-warning filter-btn" data-filter="pending">Pending</button>
            <button type="button" class="btn btn-outline-success filter-btn" data-filter="confirmed">Confirmed</button>
            <button type="button" class="btn btn-outline-info filter-btn" data-filter="completed">Completed</button>
            <button type="button" class="btn btn-outline-danger filter-btn" data-filter="cancelled">Cancelled</button>
        </div>
    </div>
    <div class="card-body">
        <!-- Search & Filter Form -->
        <form method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search patient, email..." value="<?= htmlspecialchars($filters['search']) ?>">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="all" <?= $filters['status'] == 'all' ? 'selected' : '' ?>>All Status</option>
                        <option value="pending" <?= $filters['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="confirmed" <?= $filters['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="completed" <?= $filters['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= $filters['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="<?= $filters['date_from'] ?>" placeholder="From">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="<?= $filters['date_to'] ?>" placeholder="To">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i>Filter</button>
                    <a href="<?= base_url('admin/appointments') ?>" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>

        <?php if (empty($appointments)): ?>
            <div class="text-center py-5">
                <i class="fas fa-calendar-xmark fa-4x mb-3 text-muted"></i>
                <p class="text-muted fs-5">No appointments found.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="appointmentsTable">
                    <thead>
                        <tr>
                            <th>Ref #</th>
                            <th>Patient</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Specialty</th>
                            <th>Preferred Date</th>
                            <th>Status</th>
                            <th>Booked</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $apt): ?>
                            <tr data-status="<?= $apt->status ?>">
                                <td>
                                    <span class="badge bg-primary"><?= htmlspecialchars($apt->booking_ref ?? 'N/A') ?></span>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($apt->patient_name) ?></strong>
                                    <?php if (!empty($apt->country)): ?>
                                        <br><small class="text-muted"><i class="fas fa-globe me-1"></i><?= htmlspecialchars($apt->country) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($apt->patient_email) ?></td>
                                <td><?= htmlspecialchars($apt->patient_phone) ?></td>
                                <td>
                                    <?php if (!empty($apt->medical_specialty)): ?>
                                        <span class="badge bg-info"><?= htmlspecialchars($apt->medical_specialty) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($apt->preferred_date)): ?>
                                        <?= date('M d, Y', strtotime($apt->preferred_date)) ?>
                                        <?php if (!empty($apt->preferred_time)): ?>
                                            <br><small class="text-muted"><?= htmlspecialchars($apt->preferred_time) ?></small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $status_class = 'secondary';
                                    $status_icon = '';
                                    if ($apt->status == 'pending') { $status_class = 'warning'; $status_icon = 'fa-clock'; }
                                    elseif ($apt->status == 'confirmed') { $status_class = 'success'; $status_icon = 'fa-check'; }
                                    elseif ($apt->status == 'completed') { $status_class = 'info'; $status_icon = 'fa-check-double'; }
                                    elseif ($apt->status == 'cancelled') { $status_class = 'danger'; $status_icon = 'fa-times'; }
                                    elseif ($apt->status == 'no_show') { $status_class = 'dark'; $status_icon = 'fa-user-slash'; }
                                    ?>
                                    <span class="badge bg-<?= $status_class ?>">
                                        <i class="fas <?= $status_icon ?> me-1"></i><?= ucfirst($apt->status) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= date('M d, Y', strtotime($apt->created_at)) ?>
                                    <br><small class="text-muted"><?= date('H:i', strtotime($apt->created_at)) ?></small>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/appointments/view/' . $apt->uid) ?>" class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($appointments) && $pagination['total_pages'] > 1): ?>
    <div class="card-footer">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mb-0">
                <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                        <a class="page-link" href="<?= base_url('admin/appointments?page=' . $i . '&status=' . $filters['status'] . '&search=' . urlencode($filters['search']) . '&date_from=' . $filters['date_from'] . '&date_to=' . $filters['date_to']) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<?php if (!empty($appointments)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#appointmentsTable').DataTable({
        responsive: true,
        pageLength: 20,
        order: [[7, 'desc']],
        columnDefs: [
            { orderable: false, targets: [8] }
        ]
    });

    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            const table = $('#appointmentsTable').DataTable();
            
            if (filter === 'all') {
                $.fn.dataTable.ext.search = [];
                table.draw();
            } else {
                $.fn.dataTable.ext.search = [
                    function(settings, data, dataIndex, rowData, counter) {
                        return rowData[6].toLowerCase().indexOf(filter) !== -1;
                    }
                ];
                table.draw();
            }
        });
    });
});
</script>
<?php endif; ?>
