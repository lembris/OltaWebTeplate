<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Bookings</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Bookings</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/bookings/export?' . http_build_query($filters)) ?>" class="btn btn-success">
            <i class="fas fa-file-csv me-2"></i>Export CSV
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-value"><?= $stats['total'] ?></div>
            <div class="stat-label">Total Bookings</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-value"><?= $stats['pending'] ?></div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card info">
            <div class="stat-icon"><i class="fas fa-check"></i></div>
            <div class="stat-value"><?= $stats['confirmed'] ?></div>
            <div class="stat-label">Confirmed</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-double"></i></div>
            <div class="stat-value"><?= $stats['completed'] ?></div>
            <div class="stat-label">Completed</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="fas fa-times"></i></div>
            <div class="stat-value"><?= $stats['cancelled'] ?></div>
            <div class="stat-label">Cancelled</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" action="<?= base_url('admin/bookings') ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Ref, name, email, phone..." value="<?= htmlspecialchars($filters['search']) ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" <?= $filters['status'] == 'all' ? 'selected' : '' ?>>All Status</option>
                    <option value="pending" <?= $filters['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="confirmed" <?= $filters['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                    <option value="deposit_paid" <?= $filters['status'] == 'deposit_paid' ? 'selected' : '' ?>>Deposit Paid</option>
                    <option value="paid" <?= $filters['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="completed" <?= $filters['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="cancelled" <?= $filters['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Travel Date From</label>
                <input type="date" name="date_from" class="form-control" value="<?= htmlspecialchars($filters['date_from']) ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Travel Date To</label>
                <input type="date" name="date_to" class="form-control" value="<?= htmlspecialchars($filters['date_to']) ?>">
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search me-1"></i> Filter</button>
                <a href="<?= base_url('admin/bookings') ?>" class="btn btn-secondary"><i class="fas fa-redo me-1"></i> Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Bookings Table -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-list me-2"></i>Bookings 
        <span class="badge bg-secondary"><?= $pagination['total'] ?> results</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="bookingsTable">
                <thead>
                    <tr>
                        <th>Booking Ref</th>
                        <th>Customer</th>
                        <th>Package</th>
                        <th>Travel Date</th>
                        <th>Travelers</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings)): ?>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($booking->booking_ref) ?></strong>
                                    <br>
                                    <small class="text-muted"><?= date('M d, Y H:i', strtotime($booking->created_at)) ?></small>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($booking->customer_name) ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i><?= htmlspecialchars($booking->customer_email) ?>
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i><?= htmlspecialchars($booking->customer_phone) ?>
                                    </small>
                                </td>
                                <td>
                                    <?= htmlspecialchars($booking->package_name ?? 'N/A') ?>
                                    <?php if (!empty($booking->duration_days)): ?>
                                        <br><small class="text-muted"><?= $booking->duration_days ?> days</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <i class="fas fa-calendar me-1"></i>
                                    <?= date('M d, Y', strtotime($booking->travel_date)) ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= $booking->travelers_adults ?> Adult<?= $booking->travelers_adults > 1 ? 's' : '' ?>
                                    </span>
                                    <?php if ($booking->travelers_children > 0): ?>
                                        <span class="badge bg-info">
                                            <?= $booking->travelers_children ?> Child<?= $booking->travelers_children > 1 ? 'ren' : '' ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong class="text-success">$<?= number_format($booking->total_price, 2) ?></strong>
                                </td>
                                <td>
                                    <?php
                                    $status_classes = [
                                        'pending' => 'warning',
                                        'confirmed' => 'info',
                                        'deposit_paid' => 'primary',
                                        'paid' => 'primary',
                                        'completed' => 'success',
                                        'cancelled' => 'danger'
                                    ];
                                    $status_class = $status_classes[$booking->status] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $status_class ?>">
                                        <?= ucfirst(str_replace('_', ' ', $booking->status)) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('admin/bookings/view/' . $booking->uid) ?>" 
                                           class="btn btn-sm btn-outline-primary" title="View Details">
                                             <i class="fas fa-eye"></i>
                                         </a>
                                         <button type="button" 
                                                 class="btn btn-sm btn-outline-danger" 
                                                 onclick="confirmDelete('<?= base_url('admin/bookings/delete/' . $booking->uid) ?>', 'booking')">
                                             <i class="fas fa-trash"></i>
                                         </button>
                                     </div>
                                 </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                    <p>No bookings found.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($pagination['total_pages'] > 1): ?>
            <nav aria-label="Bookings pagination" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($pagination['current_page'] > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= base_url('admin/bookings?' . http_build_query(array_merge($filters, ['page' => $pagination['current_page'] - 1]))) ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php 
                    $start = max(1, $pagination['current_page'] - 2);
                    $end = min($pagination['total_pages'], $pagination['current_page'] + 2);
                    ?>
                    
                    <?php if ($start > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= base_url('admin/bookings?' . http_build_query(array_merge($filters, ['page' => 1]))) ?>">1</a>
                        </li>
                        <?php if ($start > 2): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                            <a class="page-link" href="<?= base_url('admin/bookings?' . http_build_query(array_merge($filters, ['page' => $i]))) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($end < $pagination['total_pages']): ?>
                        <?php if ($end < $pagination['total_pages'] - 1): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= base_url('admin/bookings?' . http_build_query(array_merge($filters, ['page' => $pagination['total_pages']]))) ?>"><?= $pagination['total_pages'] ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= base_url('admin/bookings?' . http_build_query(array_merge($filters, ['page' => $pagination['current_page'] + 1]))) ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>


