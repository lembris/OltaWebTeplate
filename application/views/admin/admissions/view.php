<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Admission <?= htmlspecialchars($admission->reference_number) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/admissions') ?>">Admissions</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($admission->reference_number) ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/admissions/edit/' . $admission->uid) ?>" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="<?= base_url('admin/admissions') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Personal Information -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user me-2"></i>Personal Information</span>
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
                <span class="badge <?= $class ?> fs-6"><?= $label ?></span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Full Name:</strong>
                        <p><?= htmlspecialchars($admission->full_name) ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <p><a href="mailto:<?= htmlspecialchars($admission->email) ?>"><?= htmlspecialchars($admission->email) ?></a></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Phone:</strong>
                        <p><?= !empty($admission->phone) ? htmlspecialchars($admission->phone) : '<span class="text-muted">Not provided</span>' ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Date of Birth:</strong>
                        <p><?= !empty($admission->date_of_birth) ? date('F d, Y', strtotime($admission->date_of_birth)) : '<span class="text-muted">Not provided</span>' ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Gender:</strong>
                        <p><?= !empty($admission->gender) ? ucfirst(str_replace('_', ' ', $admission->gender)) : '<span class="text-muted">Not provided</span>' ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nationality:</strong>
                        <p><?= !empty($admission->nationality) ? htmlspecialchars($admission->nationality) : '<span class="text-muted">Not provided</span>' ?></p>
                    </div>
                </div>

                <?php if (!empty($admission->address) || !empty($admission->city) || !empty($admission->country)): ?>
                    <div class="mb-3">
                        <strong>Address:</strong>
                        <p>
                            <?= !empty($admission->address) ? htmlspecialchars($admission->address) . '<br>' : '' ?>
                            <?= !empty($admission->city) ? htmlspecialchars($admission->city) . ', ' : '' ?>
                            <?= !empty($admission->country) ? htmlspecialchars($admission->country) : '' ?>
                            <?= !empty($admission->postal_code) ? ' ' . htmlspecialchars($admission->postal_code) : '' ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Program & Academic Information -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-graduation-cap me-2"></i>Program & Academic Information
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Applied Program:</strong>
                        <p>
                            <?php if (!empty($admission->program_name)): ?>
                                <span class="badge bg-info"><?= htmlspecialchars($admission->program_code ?? '') ?></span>
                                <?= htmlspecialchars($admission->program_name) ?>
                                <?php if (!empty($admission->department_name)): ?>
                                    <br><small class="text-muted"><?= htmlspecialchars($admission->department_name) ?></small>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">Not specified</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Intake:</strong>
                        <p>
                            <?php if (!empty($admission->intake_term) || !empty($admission->intake_year)): ?>
                                <?= htmlspecialchars($admission->intake_term ?? '') ?> <?= htmlspecialchars($admission->intake_year ?? '') ?>
                            <?php else: ?>
                                <span class="text-muted">Not specified</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Previous Qualification:</strong>
                        <p><?= !empty($admission->previous_qualification) ? htmlspecialchars($admission->previous_qualification) : '<span class="text-muted">Not provided</span>' ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Institution:</strong>
                        <p><?= !empty($admission->institution_name) ? htmlspecialchars($admission->institution_name) : '<span class="text-muted">Not provided</span>' ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Graduation Year:</strong>
                        <p><?= !empty($admission->graduation_year) ? htmlspecialchars($admission->graduation_year) : '<span class="text-muted">Not provided</span>' ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>GPA/Score:</strong>
                        <p><?= !empty($admission->gpa_score) ? htmlspecialchars($admission->gpa_score) : '<span class="text-muted">Not provided</span>' ?></p>
                    </div>
                </div>

                <?php if (!empty($admission->personal_statement)): ?>
                    <div class="mb-3">
                        <strong>Personal Statement:</strong>
                        <div class="p-3 bg-light rounded mt-2">
                            <?= nl2br(htmlspecialchars($admission->personal_statement)) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Emergency Contact -->
        <?php if (!empty($admission->emergency_contact_name) || !empty($admission->emergency_contact_phone)): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-phone-alt me-2"></i>Emergency Contact
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Name:</strong>
                            <p><?= htmlspecialchars($admission->emergency_contact_name ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Phone:</strong>
                            <p><?= htmlspecialchars($admission->emergency_contact_phone ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Relationship:</strong>
                            <p><?= htmlspecialchars($admission->emergency_contact_relation ?? 'N/A') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Admin Notes -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-sticky-note me-2"></i>Admin Notes
            </div>
            <div class="card-body">
                <!-- Internal Notes -->
                <?php if (!empty($admission->admin_notes)): ?>
                    <div class="alert alert-info mb-4">
                        <strong>Internal Notes:</strong><br>
                        <?= nl2br(htmlspecialchars($admission->admin_notes)) ?>
                    </div>
                <?php endif; ?>

                <!-- Add Note Form -->
                <form id="addNoteForm" class="mb-4">
                    <div class="mb-3">
                        <textarea name="note" class="form-control" rows="3" placeholder="Add a note about this application..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Add Note
                    </button>
                </form>

                <!-- Notes List -->
                <div id="notesList">
                    <?php if (!empty($notes)): ?>
                        <?php foreach ($notes as $note): ?>
                            <div class="note-item border-start border-3 border-primary ps-3 mb-3">
                                <p class="mb-1"><?= nl2br(htmlspecialchars($note->note)) ?></p>
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i><?= htmlspecialchars($note->admin_name ?? 'System') ?>
                                    <i class="fas fa-clock ms-2 me-1"></i><?= date('M d, Y H:i', strtotime($note->created_at)) ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted mb-0" id="noNotesMsg">No notes yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Status History -->
        <?php if (!empty($status_history)): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-history me-2"></i>Status History
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <?php foreach ($status_history as $history): ?>
                            <div class="timeline-item mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <span class="badge bg-secondary"><?= date('M d', strtotime($history->created_at)) ?></span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1">
                                            <?php if (!empty($history->old_status)): ?>
                                                Status changed from <strong><?= ucfirst(str_replace('_', ' ', $history->old_status)) ?></strong> to
                                            <?php else: ?>
                                                Status set to
                                            <?php endif; ?>
                                            <strong><?= ucfirst(str_replace('_', ' ', $history->new_status)) ?></strong>
                                        </p>
                                        <?php if (!empty($history->notes)): ?>
                                            <small class="text-muted"><?= htmlspecialchars($history->notes) ?></small>
                                        <?php endif; ?>
                                        <br>
                                        <small class="text-muted">
                                            <?php if (!empty($history->admin_name)): ?>
                                                By <?= htmlspecialchars($history->admin_name) ?> •
                                            <?php endif; ?>
                                            <?= date('M d, Y H:i', strtotime($history->created_at)) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Applicant Quick Info -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-id-card me-2"></i>Applicant Info
            </div>
            <div class="card-body">
                <h5 class="mb-3"><?= htmlspecialchars($admission->full_name) ?></h5>
                
                <p class="mb-2">
                    <i class="fas fa-envelope text-muted me-2"></i>
                    <a href="mailto:<?= htmlspecialchars($admission->email) ?>"><?= htmlspecialchars($admission->email) ?></a>
                </p>
                
                <?php if (!empty($admission->phone)): ?>
                    <p class="mb-2">
                        <i class="fas fa-phone text-muted me-2"></i>
                        <a href="tel:<?= htmlspecialchars($admission->phone) ?>"><?= htmlspecialchars($admission->phone) ?></a>
                    </p>
                <?php endif; ?>
                
                <?php if (!empty($admission->country)): ?>
                    <p class="mb-2">
                        <i class="fas fa-globe text-muted me-2"></i>
                        <?= htmlspecialchars($admission->country) ?>
                    </p>
                <?php endif; ?>

                <hr>
                
                <p class="mb-2">
                    <i class="fas fa-calendar text-muted me-2"></i>
                    Applied: <?= date('M d, Y', strtotime($admission->created_at)) ?>
                </p>
                
                <?php if (!empty($admission->reviewed_at)): ?>
                    <p class="mb-2">
                        <i class="fas fa-check-circle text-muted me-2"></i>
                        Reviewed: <?= date('M d, Y', strtotime($admission->reviewed_at)) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($admission->how_did_you_hear)): ?>
                    <p class="mb-2">
                        <i class="fas fa-bullhorn text-muted me-2"></i>
                        Source: <?= htmlspecialchars($admission->how_did_you_hear) ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Update Status -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-tag me-2"></i>Update Status
            </div>
            <div class="card-body">
                <?= form_open('admin/admissions/update_status/' . $admission->uid, ['id' => 'statusForm']) ?>
                    <select name="status" class="form-select mb-3" id="statusSelect">
                        <option value="pending" <?= $admission->status === 'pending' ? 'selected' : '' ?>>🟡 Pending</option>
                        <option value="under_review" <?= $admission->status === 'under_review' ? 'selected' : '' ?>>🔵 Under Review</option>
                        <option value="accepted" <?= $admission->status === 'accepted' ? 'selected' : '' ?>>🟢 Accepted</option>
                        <option value="rejected" <?= $admission->status === 'rejected' ? 'selected' : '' ?>>🔴 Rejected</option>
                        <option value="waitlisted" <?= $admission->status === 'waitlisted' ? 'selected' : '' ?>>⚪ Waitlisted</option>
                        <option value="enrolled" <?= $admission->status === 'enrolled' ? 'selected' : '' ?>>🎓 Enrolled</option>
                        <option value="withdrawn" <?= $admission->status === 'withdrawn' ? 'selected' : '' ?>>⚫ Withdrawn</option>
                    </select>
                    <div class="mb-3">
                        <textarea name="notes" class="form-control" rows="2" placeholder="Add notes for this status change (optional)"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-1"></i>Update Status
                    </button>
                <?= form_close() ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('admin/admissions/edit/' . $admission->uid) ?>" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>Edit Application
                    </a>
                    <a href="mailto:<?= htmlspecialchars($admission->email) ?>" class="btn btn-outline-primary">
                        <i class="fas fa-envelope me-1"></i>Send Email
                    </a>
                    <?php if (!empty($admission->phone)): ?>
                        <a href="tel:<?= htmlspecialchars($admission->phone) ?>" class="btn btn-outline-success">
                            <i class="fas fa-phone me-1"></i>Call
                        </a>
                    <?php endif; ?>
                    <button type="button" class="btn btn-outline-danger" 
                            onclick="confirmDelete('<?= base_url('admin/admissions/delete/' . $admission->uid) ?>', 'admission')">
                        <i class="fas fa-trash me-1"></i>Delete Application
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Note Form
    document.getElementById('addNoteForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const noteText = form.querySelector('textarea[name="note"]').value;
        
        fetch('<?= base_url('admin/admissions/add_note/' . $admission->uid) ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'note=' + encodeURIComponent(noteText) + '&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const noNotesMsg = document.getElementById('noNotesMsg');
                if (noNotesMsg) noNotesMsg.remove();
                
                const notesList = document.getElementById('notesList');
                const noteHtml = `
                    <div class="note-item border-start border-3 border-primary ps-3 mb-3">
                        <p class="mb-1">${noteText.replace(/\n/g, '<br>')}</p>
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i><?= $admin_name ?? 'Admin' ?>
                            <i class="fas fa-clock ms-2 me-1"></i>Just now
                        </small>
                    </div>
                `;
                notesList.insertAdjacentHTML('afterbegin', noteHtml);
                form.querySelector('textarea[name="note"]').value = '';
                
                Swal.fire({
                    icon: 'success',
                    title: 'Note Added',
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred. Please try again.'
            });
        });
    });

    // Status Update Form
    document.getElementById('statusForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const params = new URLSearchParams();
        for (const pair of formData) {
            params.append(pair[0], pair[1]);
        }
        params.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: params.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Status Updated',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred. Please try again.'
            });
        });
    });
});
</script>
