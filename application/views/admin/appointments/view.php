<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Appointment Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/appointments') ?>">Appointments</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($appointment->uid) ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <span class="badge bg-<?= $appointment->status == 'pending' ? 'warning' : ($appointment->status == 'confirmed' ? 'success' : ($appointment->status == 'completed' ? 'info' : 'danger')) ?> fs-6 me-2">
            <?= ucfirst($appointment->status) ?>
        </span>
    </div>
</div>

<div class="row">
    <!-- Appointment Details -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-calendar-check me-2"></i>Appointment Information</span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Patient Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="120" class="text-muted">Reference:</td>
                                <td>
                                    <span class="badge bg-primary fs-6"><?= htmlspecialchars($appointment->booking_ref ?? 'N/A') ?></span>
                                    <?php if (!empty($appointment->uid)): ?>
                                        <br><small class="text-muted">UID: <?= htmlspecialchars($appointment->uid) ?></small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Name:</td>
                                <td><strong><?= htmlspecialchars($appointment->patient_name) ?></strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email:</td>
                                <td><a href="mailto:<?= htmlspecialchars($appointment->patient_email) ?>"><?= htmlspecialchars($appointment->patient_email) ?></a></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Phone:</td>
                                <td><a href="tel:<?= htmlspecialchars($appointment->patient_phone) ?>"><?= htmlspecialchars($appointment->patient_phone) ?></a></td>
                            </tr>
                            <?php if (!empty($appointment->country)): ?>
                            <tr>
                                <td class="text-muted">Country:</td>
                                <td><?= htmlspecialchars($appointment->country) ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Appointment Details</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="120" class="text-muted">Specialty:</td>
                                <td><?= !empty($appointment->medical_specialty) ? '<span class="badge bg-info">' . htmlspecialchars($appointment->medical_specialty) . '</span>' : '-' ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Preferred Date:</td>
                                <td><?= date('l, F d, Y', strtotime($appointment->preferred_date)) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Preferred Time:</td>
                                <td><?= htmlspecialchars($appointment->preferred_time) ?></td>
                            </tr>
                            <?php if (!empty($appointment->treatment_timeline)): ?>
                            <tr>
                                <td class="text-muted">Timeline:</td>
                                <td><?= htmlspecialchars($appointment->treatment_timeline) ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td class="text-muted">Booked On:</td>
                                <td><?= date('F d, Y H:i', strtotime($appointment->created_at)) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Template:</td>
                                <td>
                                    <span class="badge <?= $appointment->template == 'all' ? 'bg-info' : 'bg-secondary' ?>">
                                        <?= htmlspecialchars(ucfirst($appointment->template ?: 'all')) ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php if (!empty($appointment->additional_notes)): ?>
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Additional Notes</h6>
                    <div class="bg-light p-3 rounded">
                        <?= nl2br(htmlspecialchars($appointment->additional_notes)) ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($appointment->admin_notes)): ?>
                <div>
                    <h6 class="text-muted mb-2">Admin Notes</h6>
                    <div class="bg-warning bg-opacity-10 p-3 rounded border border-warning">
                        <?= nl2br(htmlspecialchars($appointment->admin_notes)) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Actions Sidebar -->
    <div class="col-lg-4">
        <!-- Update Status -->
        <div class="card mb-3">
            <div class="card-header">
                <span><i class="fas fa-edit me-2"></i>Update Status</span>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('admin/appointments/update_status/' . $appointment->uid) ?>">
                    <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" <?= $appointment->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="confirmed" <?= $appointment->status == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                            <option value="completed" <?= $appointment->status == 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= $appointment->status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            <option value="no_show" <?= $appointment->status == 'no_show' ? 'selected' : '' ?>>No Show</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Add notes about this update..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card mb-3">
            <div class="card-header">
                <span><i class="fas fa-bolt me-2"></i>Quick Actions</span>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:<?= htmlspecialchars($appointment->patient_email) ?>" class="btn btn-outline-info">
                        <i class="fas fa-envelope me-2"></i>Send Email
                    </a>
                    <a href="tel:<?= htmlspecialchars($appointment->patient_phone) ?>" class="btn btn-outline-success">
                        <i class="fas fa-phone me-2"></i>Call Patient
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Delete -->
        <div class="card">
            <div class="card-header bg-danger">
                <span class="text-danger"><i class="fas fa-trash me-2"></i>Danger Zone</span>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-danger w-100" onclick="confirmDelete('<?= base_url('admin/appointments/delete/' . $appointment->uid) ?>', 'appointment')">
                    <i class="fas fa-trash me-2"></i>Delete Appointment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this <span id="deleteItemType">item</span>?</p>
                <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i>This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancel</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger"><i class="fas fa-trash me-2"></i>Delete</a>
            </div>
        </div>
    </div>
</div>
