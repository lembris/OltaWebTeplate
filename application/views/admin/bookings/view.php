<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Booking: <?= htmlspecialchars($booking->booking_ref) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/bookings') ?>">Bookings</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($booking->booking_ref) ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-secondary">
            <i class="fas fa-print me-2"></i>Print
        </button>
        <a href="<?= base_url('admin/bookings') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>
</div>

<div class="row">
    <!-- Left Column: Booking Details -->
    <div class="col-lg-8">
        <!-- Customer Information -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user me-2"></i>Customer Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="120">Name:</th>
                                <td><strong><?= htmlspecialchars($booking->customer_name) ?></strong></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars($booking->customer_email) ?>">
                                        <?= htmlspecialchars($booking->customer_email) ?>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>
                                    <a href="tel:<?= htmlspecialchars($booking->customer_phone) ?>">
                                        <?= htmlspecialchars($booking->customer_phone) ?>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="120">Country:</th>
                                <td><?= htmlspecialchars($booking->customer_country ?? 'Not specified') ?></td>
                            </tr>
                            <tr>
                                <th>Booked On:</th>
                                <td><?= date('F d, Y \a\t H:i', strtotime($booking->created_at)) ?></td>
                            </tr>
                            <tr>
                                <th>Last Updated:</th>
                                <td><?= date('F d, Y \a\t H:i', strtotime($booking->updated_at ?? $booking->created_at)) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Package Information -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-box me-2"></i>Package Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <?php if (!empty($booking->package_image)): ?>
                            <img src="<?= base_url('assets/img/packages/' . $booking->package_image) ?>" 
                                 alt="<?= htmlspecialchars($booking->package_name) ?>" 
                                 class="img-fluid rounded">
                        <?php else: ?>
                            <div class="bg-secondary d-flex align-items-center justify-content-center text-white rounded" 
                                 style="height: 120px;">
                                <i class="fas fa-image fa-3x"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-9">
                        <h5><?= htmlspecialchars($booking->package_name ?? 'Package Deleted') ?></h5>
                        <?php if (!empty($booking->package_slug)): ?>
                            <p class="text-muted mb-2">
                                <a href="<?= base_url('safari/' . $booking->package_slug) ?>" target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i>View Package
                                </a>
                            </p>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">Duration</small>
                                <p class="mb-0"><strong><?= $booking->duration_days ?? 'N/A' ?> Days</strong></p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Category</small>
                                <p class="mb-0"><strong><?= ucfirst($booking->category ?? 'N/A') ?></strong></p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Destinations</small>
                                <p class="mb-0"><strong><?= htmlspecialchars($booking->destinations ?? 'N/A') ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Travel Details -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plane me-2"></i>Travel Details
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded text-center">
                            <i class="fas fa-calendar fa-2x text-primary mb-2"></i>
                            <h6 class="text-muted mb-1">Travel Date</h6>
                            <strong><?= date('F d, Y', strtotime($booking->travel_date)) ?></strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded text-center">
                            <i class="fas fa-users fa-2x text-primary mb-2"></i>
                            <h6 class="text-muted mb-1">Travelers</h6>
                            <strong>
                                <?= $booking->travelers_adults ?> Adult<?= $booking->travelers_adults > 1 ? 's' : '' ?>
                                <?php if ($booking->travelers_children > 0): ?>
                                    , <?= $booking->travelers_children ?> Child<?= $booking->travelers_children > 1 ? 'ren' : '' ?>
                                <?php endif; ?>
                            </strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded text-center">
                            <i class="fas fa-hotel fa-2x text-primary mb-2"></i>
                            <h6 class="text-muted mb-1">Accommodation</h6>
                            <strong><?= ucfirst($booking->accommodation_preference ?? 'Mid-range') ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Breakdown -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-dollar-sign me-2"></i>Pricing Breakdown
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <?php if (!empty($booking->base_price)): ?>
                        <tr>
                            <td>Base Price</td>
                            <td class="text-end">$<?= number_format($booking->base_price, 2) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($booking->adult_total)): ?>
                        <tr>
                            <td>Adults (<?= $booking->travelers_adults ?>)</td>
                            <td class="text-end">$<?= number_format($booking->adult_total, 2) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($booking->travelers_children > 0 && !empty($booking->children_total)): ?>
                        <tr>
                            <td>Children (<?= $booking->travelers_children ?>)</td>
                            <td class="text-end">$<?= number_format($booking->children_total, 2) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($booking->single_supplement) && $booking->single_supplement > 0): ?>
                        <tr>
                            <td>Single Supplement</td>
                            <td class="text-end">$<?= number_format($booking->single_supplement, 2) ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-primary">
                            <th>Total Amount</th>
                            <th class="text-end fs-5">$<?= number_format($booking->total_price, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Special Requests -->
        <?php if (!empty($booking->special_requests)): ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-comment-alt me-2"></i>Special Requests
            </div>
            <div class="card-body">
                <p class="mb-0"><?= nl2br(htmlspecialchars($booking->special_requests)) ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Right Column: Status & Actions -->
    <div class="col-lg-4">
        <!-- Current Status -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i>Current Status
            </div>
            <div class="card-body text-center">
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
                <span class="badge bg-<?= $status_class ?> fs-5 px-4 py-2 mb-3">
                    <?= ucfirst(str_replace('_', ' ', $booking->status)) ?>
                </span>
                
                <form action="<?= base_url('admin/bookings/update_status/' . $booking->uid) ?>" method="POST" class="mt-3">
                     <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                     <div class="mb-3">
                         <label class="form-label">Update Status</label>
                         <select name="status" class="form-select" required>
                             <option value="">-- Select Status --</option>
                             <option value="pending" <?= $booking->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                             <option value="confirmed" <?= $booking->status == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                             <option value="deposit_paid" <?= $booking->status == 'deposit_paid' ? 'selected' : '' ?>>Deposit Paid</option>
                             <option value="paid" <?= $booking->status == 'paid' ? 'selected' : '' ?>>Paid</option>
                             <option value="completed" <?= $booking->status == 'completed' ? 'selected' : '' ?>>Completed</option>
                             <option value="cancelled" <?= $booking->status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                         </select>
                     </div>
                     <div class="mb-3">
                         <label class="form-label">Notes (optional)</label>
                         <textarea name="notes" class="form-control" rows="2" placeholder="Add a note about this status change..."></textarea>
                     </div>
                     <button type="submit" class="btn btn-primary w-100">
                         <i class="fas fa-save me-2"></i>Update Status
                     </button>
                 </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Quick Actions
            </div>
            <div class="card-body d-grid gap-2">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#emailModal">
                    <i class="fas fa-envelope me-2"></i>Send Email
                </button>
                <form action="<?= base_url('admin/bookings/send_invoice/' . $booking->uid) ?>" method="POST" class="d-grid">
                    <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                    <button type="submit" class="btn btn-outline-info" onclick="return confirm('Send invoice to <?= htmlspecialchars($booking->customer_email) ?>?')">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Send Invoice
                    </button>
                </form>
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#bankDetailsModal">
                    <i class="fas fa-university me-2"></i>Send Bank Details
                </button>
                <a href="tel:<?= htmlspecialchars($booking->customer_phone) ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-phone me-2"></i>Call Customer
                </a>
                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#printModal">
                    <i class="fas fa-print me-2"></i>Print Booking
                </button>
                <form id="deleteForm" method="POST" style="display:none;">
                    <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                </form>
                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete('<?= $booking->uid ?>', 'booking')">
                    <i class="fas fa-trash me-2"></i>Delete Booking
                </button>
            </div>
        </div>

        <!-- Status History -->
        <?php if (!empty($status_history)): ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-history me-2"></i>Status History
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php foreach ($status_history as $history): ?>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <span>
                                    <span class="badge bg-secondary"><?= ucfirst(str_replace('_', ' ', $history->old_status)) ?></span>
                                    <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                    <span class="badge bg-primary"><?= ucfirst(str_replace('_', ' ', $history->new_status)) ?></span>
                                </span>
                            </div>
                            <small class="text-muted">
                                By <?= htmlspecialchars($history->admin_name ?? 'System') ?> on 
                                <?= date('M d, Y H:i', strtotime($history->created_at)) ?>
                            </small>
                            <?php if (!empty($history->notes)): ?>
                                <br><small class="text-info"><?= htmlspecialchars($history->notes) ?></small>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>

        <!-- Email Status -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-paper-plane me-2"></i>Email Status
            </div>
            <div class="card-body">
                <?php if (!empty($booking->email_sent)): ?>
                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Confirmation Sent</span>
                <?php else: ?>
                    <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Pending</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    .page-header > div:last-child,
    .col-lg-4 .card:not(:first-child),
    .btn,
    .sidebar,
    .navbar,
    footer {
        display: none !important;
    }
    .col-lg-8 {
        width: 100% !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
}
</style>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('admin/bookings/send_email/' . $booking->uid) ?>" method="POST">
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">
                        <i class="fas fa-envelope me-2"></i>Send Email to <?= htmlspecialchars($booking->customer_name) ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">To</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($booking->customer_email) ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="email_subject" class="form-control" value="Regarding Your Booking <?= htmlspecialchars($booking->booking_ref) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea name="email_message" class="form-control" rows="8" required placeholder="Write your message here...">Thank you for booking with us!

We wanted to reach out regarding your upcoming safari adventure.

Package: <?= htmlspecialchars($booking->package_name ?? 'Safari Package') ?>
Travel Date: <?= date('F d, Y', strtotime($booking->travel_date)) ?>

If you have any questions, please don't hesitate to contact us.

Best regards,
Osiram Safari Adventure Team</textarea>
                    </div>
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        The email will be sent with your company branding and booking reference automatically included.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="printModalLabel">
                    <i class="fas fa-print me-2"></i>Print Booking: <?= htmlspecialchars($booking->booking_ref) ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="printContent">
                <div class="print-container p-4">
                    <!-- Header -->
                    <div class="text-center pb-3 border-bottom border-3 border-success mb-4">
                        <?php if (!empty($settings['site_logo'])): ?>
                            <img src="<?= base_url('assets/images/' . $settings['site_logo']) ?>" alt="<?= htmlspecialchars($settings['site_name'] ?? 'Company Logo') ?>" style="max-height: 80px; margin-bottom: 10px;">
                        <?php endif; ?>
                        <h1 class="text-success mb-1"><?= htmlspecialchars($settings['site_name'] ?? 'Osiram Safari Adventure') ?></h1>
                        <p class="text-muted"><?= htmlspecialchars($settings['site_tagline'] ?? 'Your Safari Adventure Awaits') ?></p>
                        <p class="text-primary fw-bold fs-5 mb-0">Booking Reference: <?= htmlspecialchars($booking->booking_ref) ?></p>
                    </div>

                    <!-- Summary Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted text-uppercase">Booking Date</small>
                                <p class="fw-bold mb-0"><?= date('M d, Y', strtotime($booking->created_at)) ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted text-uppercase">Status</small>
                                <?php
                                $status_classes = [
                                    'pending' => 'warning',
                                    'confirmed' => 'info',
                                    'deposit_paid' => 'primary',
                                    'paid' => 'primary',
                                    'completed' => 'success',
                                    'cancelled' => 'danger'
                                ];
                                $print_status_class = $status_classes[$booking->status] ?? 'secondary';
                                ?>
                                <p class="mb-0"><span class="badge bg-<?= $print_status_class ?>"><?= ucfirst(str_replace('_', ' ', $booking->status)) ?></span></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted text-uppercase">Payment Status</small>
                                <p class="fw-bold mb-0"><?= ucfirst($booking->payment_status ?? 'Unpaid') ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mb-4">
                        <h5 class="text-success border-bottom pb-2 mb-3"><i class="fas fa-user me-2"></i>Customer Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr><td class="text-muted" width="120">Full Name:</td><td class="fw-bold"><?= htmlspecialchars($booking->customer_name) ?></td></tr>
                                    <tr><td class="text-muted">Email:</td><td><?= htmlspecialchars($booking->customer_email) ?></td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr><td class="text-muted" width="120">Phone:</td><td><?= htmlspecialchars($booking->customer_phone) ?></td></tr>
                                    <tr><td class="text-muted">Country:</td><td><?= htmlspecialchars($booking->customer_country ?? 'Not specified') ?></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Package Information -->
                    <div class="mb-4">
                        <h5 class="text-success border-bottom pb-2 mb-3"><i class="fas fa-box me-2"></i>Package Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr><td class="text-muted" width="120">Package:</td><td class="fw-bold"><?= htmlspecialchars($booking->package_name ?? 'N/A') ?></td></tr>
                                    <tr><td class="text-muted">Duration:</td><td><?= $booking->duration_days ?? 'N/A' ?> Days</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr><td class="text-muted" width="120">Category:</td><td><?= ucfirst($booking->category ?? 'N/A') ?></td></tr>
                                    <tr><td class="text-muted">Destinations:</td><td><?= htmlspecialchars($booking->destinations ?? 'N/A') ?></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Travel Details -->
                    <div class="mb-4">
                        <h5 class="text-success border-bottom pb-2 mb-3"><i class="fas fa-plane me-2"></i>Travel Details</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded border-start border-3 border-success">
                                    <small class="text-muted text-uppercase">Travel Date</small>
                                    <p class="fw-bold mb-0"><?= date('F d, Y', strtotime($booking->travel_date)) ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded border-start border-3 border-success">
                                    <small class="text-muted text-uppercase">Travelers</small>
                                    <p class="fw-bold mb-0">
                                        <?= $booking->travelers_adults ?> Adult<?= $booking->travelers_adults > 1 ? 's' : '' ?>
                                        <?php if ($booking->travelers_children > 0): ?>
                                            , <?= $booking->travelers_children ?> Child<?= $booking->travelers_children > 1 ? 'ren' : '' ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded border-start border-3 border-success">
                                    <small class="text-muted text-uppercase">Accommodation</small>
                                    <p class="fw-bold mb-0"><?= ucfirst($booking->accommodation_preference ?? 'Mid-range') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Breakdown -->
                    <div class="mb-4">
                        <h5 class="text-success border-bottom pb-2 mb-3"><i class="fas fa-dollar-sign me-2"></i>Pricing Breakdown</h5>
                        <table class="table table-striped">
                            <tbody>
                                <?php if (!empty($booking->base_price)): ?>
                                <tr>
                                    <td>Base Price</td>
                                    <td class="text-end">$<?= number_format($booking->base_price, 2) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($booking->adult_total)): ?>
                                <tr>
                                    <td>Adults (<?= $booking->travelers_adults ?>)</td>
                                    <td class="text-end">$<?= number_format($booking->adult_total, 2) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($booking->travelers_children > 0 && !empty($booking->children_total)): ?>
                                <tr>
                                    <td>Children (<?= $booking->travelers_children ?>)</td>
                                    <td class="text-end">$<?= number_format($booking->children_total, 2) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($booking->single_supplement) && $booking->single_supplement > 0): ?>
                                <tr>
                                    <td>Single Supplement</td>
                                    <td class="text-end">$<?= number_format($booking->single_supplement, 2) ?></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-success">
                                    <th>TOTAL AMOUNT DUE</th>
                                    <th class="text-end fs-5">$<?= number_format($booking->total_price, 2) ?> USD</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Special Requests -->
                    <?php if (!empty($booking->special_requests)): ?>
                    <div class="mb-4">
                        <h5 class="text-success border-bottom pb-2 mb-3"><i class="fas fa-comment-alt me-2"></i>Special Requests</h5>
                        <div class="bg-warning bg-opacity-25 p-3 rounded border-start border-3 border-warning">
                            <?= nl2br(htmlspecialchars($booking->special_requests)) ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Footer -->
                    <div class="text-center pt-3 border-top mt-4 text-muted small">
                        <p class="text-success fw-bold mb-1"><?= htmlspecialchars($settings['site_name'] ?? 'Osiram Safari Adventure') ?></p>
                        <p class="mb-1">📍 <?= htmlspecialchars($settings['site_address'] ?? 'Box 15907 Arusha, Tanzania') ?></p>
                        <p class="mb-0">📞 <?= htmlspecialchars($settings['site_phone'] ?? '+255 789 356 961') ?> | ✉️ <?= htmlspecialchars($settings['site_email'] ?? 'welcome@osiramsafari.com') ?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printBooking()">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bank Details Preview Modal -->
<div class="modal fade" id="bankDetailsModal" tabindex="-1" aria-labelledby="bankDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('admin/bookings/send_bank_details/' . $booking->uid) ?>" method="POST">
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="bankDetailsModalLabel">
                        <i class="fas fa-university me-2"></i>Preview Bank Details Email
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Review the bank details below before sending to <strong><?= htmlspecialchars($booking->customer_email) ?></strong>
                    </div>

                    <!-- Email Preview -->
                    <div class="border rounded p-3 bg-light">
                        <div class="text-center mb-3 pb-3 border-bottom">
                            <?php if (!empty($settings['site_logo'])): ?>
                                <img src="<?= base_url('assets/images/' . $settings['site_logo']) ?>" alt="<?= htmlspecialchars($settings['site_name'] ?? 'Company Logo') ?>" style="max-height: 60px; margin-bottom: 10px;">
                            <?php endif; ?>
                            <h4 class="text-success mb-1">🏦 Payment Details</h4>
                            <p class="text-muted mb-0"><?= htmlspecialchars($settings['site_name'] ?? 'Osiram Safari Adventure') ?></p>
                        </div>

                        <div class="bg-white p-3 rounded border-start border-3 border-primary mb-3">
                            <strong>Booking Reference:</strong> <?= htmlspecialchars($booking->booking_ref) ?><br>
                            <strong>Package:</strong> <?= htmlspecialchars($booking->package_name ?? 'Safari Package') ?>
                        </div>

                        <div class="bg-success text-white p-3 rounded text-center mb-3">
                            <small>Total Amount</small>
                            <p class="fs-3 fw-bold mb-1">$<?= number_format($booking->total_price, 2) ?> USD</p>
                            <small>Deposit Required (30%): <strong>$<?= number_format($booking->total_price * 0.30, 2) ?> USD</strong></small>
                        </div>

                        <div class="bg-white border border-success rounded p-3 mb-3">
                            <h6 class="text-success mb-3"><i class="fas fa-university me-2"></i>Bank Transfer Details</h6>
                            <?php if (!empty($settings['bank_name']) && !empty($settings['bank_account_number'])): ?>
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td class="text-muted" width="40%">Bank Name:</td>
                                    <td class="fw-bold"><?= htmlspecialchars($settings['bank_name'] ?? '') ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Account Name:</td>
                                    <td class="fw-bold"><?= htmlspecialchars($settings['bank_account_name'] ?? '') ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Account Number:</td>
                                    <td class="fw-bold"><?= htmlspecialchars($settings['bank_account_number'] ?? '') ?></td>
                                </tr>
                                <?php if (!empty($settings['bank_swift_code'])): ?>
                                <tr>
                                    <td class="text-muted">SWIFT Code:</td>
                                    <td class="fw-bold"><?= htmlspecialchars($settings['bank_swift_code']) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($settings['bank_branch'])): ?>
                                <tr>
                                    <td class="text-muted">Branch:</td>
                                    <td class="fw-bold"><?= htmlspecialchars($settings['bank_branch']) ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="text-muted">Currency:</td>
                                    <td class="fw-bold"><?= htmlspecialchars($settings['bank_currency'] ?? 'USD') ?></td>
                                </tr>
                            </table>
                            <?php if (!empty($settings['bank_additional_info'])): ?>
                            <hr>
                            <small class="text-muted"><?= nl2br(htmlspecialchars($settings['bank_additional_info'])) ?></small>
                            <?php endif; ?>
                            <?php else: ?>
                            <div class="alert alert-danger mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Bank details not configured!</strong><br>
                                Please go to <a href="<?= base_url('admin/settings') ?>" class="alert-link">Settings → Payment</a> to add your bank details.
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="bg-warning bg-opacity-25 p-3 rounded">
                            <strong><i class="fas fa-exclamation-triangle me-1"></i> Important:</strong>
                            <ul class="mb-0 mt-2 small">
                                <li>Customer should include booking reference <strong><?= htmlspecialchars($booking->booking_ref) ?></strong> in payment description</li>
                                <li>They should send payment receipt via email or WhatsApp for faster confirmation</li>
                                <li>Bank transfers may take 2-3 business days to process</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <?php if (!empty($settings['bank_name']) && !empty($settings['bank_account_number'])): ?>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-2"></i>Send Bank Details
                    </button>
                    <?php else: ?>
                    <a href="<?= base_url('admin/settings') ?>" class="btn btn-primary">
                        <i class="fas fa-cog me-2"></i>Configure Bank Details
                    </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(bookingUid, type) {
    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to delete this ${type}. This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = '<?= base_url('admin/bookings/delete/') ?>' + bookingUid;
            form.submit();
        }
    });
}

function printBooking() {
    const printContent = document.getElementById('printContent').innerHTML;
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Booking: <?= htmlspecialchars($booking->booking_ref) ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
            <style>
                body { padding: 20px; }
                @media print {
                    body { padding: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                    .table-success { background-color: #198754 !important; color: white !important; }
                    .table-success th { color: white !important; }
                    .bg-light { background-color: #f8f9fa !important; }
                    .bg-success { background-color: #198754 !important; }
                    .border-success { border-color: #198754 !important; }
                }
            </style>
        </head>
        <body>
            ${printContent}
            <script>
                window.onload = function() {
                    window.print();
                    window.onafterprint = function() { window.close(); };
                };
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>
