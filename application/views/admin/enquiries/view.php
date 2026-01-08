<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Enquiry <?= htmlspecialchars($enquiry->reference_number) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/enquiries') ?>">Enquiries</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($enquiry->reference_number) ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/enquiries/edit/' . $enquiry->uid) ?>" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="<?= base_url('admin/enquiries/reply/' . $enquiry->uid) ?>" class="btn btn-success">
            <i class="fas fa-reply me-2"></i>Reply
        </a>
        <a href="<?= base_url('admin/enquiries') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Enquiry Details -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-envelope-open me-2"></i>Enquiry Details</span>
                <?php
                $status_classes = [
                    'new' => 'bg-danger',
                    'read' => 'bg-info',
                    'replied' => 'bg-primary',
                    'closed' => 'bg-secondary'
                ];
                $class = $status_classes[$enquiry->status] ?? 'bg-secondary';
                ?>
                <span class="badge <?= $class ?> fs-6"><?= ucfirst($enquiry->status) ?></span>
            </div>
            <div class="card-body">
                <!-- Trip Type & Duration -->
                <?php if (!empty($enquiry->trip_type) || !empty($enquiry->duration)): ?>
                    <div class="row mb-3">
                        <?php if (!empty($enquiry->trip_type)): ?>
                            <div class="col-md-6">
                                <strong>Trip Type:</strong>
                                <span class="badge bg-info ms-2"><?= htmlspecialchars($enquiry->trip_type) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($enquiry->duration)): ?>
                            <div class="col-md-6">
                                <strong>Duration:</strong> <?= htmlspecialchars($enquiry->duration) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Destinations -->
                <?php 
                $destinations = json_decode($enquiry->destinations ?? '[]', true);
                if (!empty($destinations) && is_array($destinations)): 
                ?>
                    <div class="mb-3">
                        <strong>Destinations:</strong><br>
                        <?php foreach ($destinations as $dest): ?>
                            <span class="badge bg-success me-1 mb-1"><?= htmlspecialchars($dest) ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Travel Dates -->
                <?php if (!empty($enquiry->travel_date_from) || !empty($enquiry->travel_date_to)): ?>
                    <div class="mb-3">
                        <strong>Travel Dates:</strong> 
                        <?php if (!empty($enquiry->travel_date_from)): ?>
                            <?= date('M d, Y', strtotime($enquiry->travel_date_from)) ?>
                        <?php endif; ?>
                        <?php if (!empty($enquiry->travel_date_from) && !empty($enquiry->travel_date_to)): ?>
                            to
                        <?php endif; ?>
                        <?php if (!empty($enquiry->travel_date_to)): ?>
                            <?= date('M d, Y', strtotime($enquiry->travel_date_to)) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Travelers -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Adults:</strong> <?= $enquiry->adults ?? 1 ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Children:</strong> <?= $enquiry->children ?? 0 ?>
                        <?php if (!empty($enquiry->children_ages)): ?>
                            (Ages: <?= htmlspecialchars($enquiry->children_ages) ?>)
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Accommodation & Budget -->
                <div class="row mb-3">
                    <?php if (!empty($enquiry->accommodation)): ?>
                        <div class="col-md-6">
                            <strong>Accommodation:</strong> <?= htmlspecialchars($enquiry->accommodation) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($enquiry->budget)): ?>
                        <div class="col-md-6">
                            <strong>Budget:</strong> <span class="text-success"><?= htmlspecialchars($enquiry->budget) ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Interests -->
                <?php 
                $interests = json_decode($enquiry->interests ?? '[]', true);
                if (!empty($interests) && is_array($interests)): 
                ?>
                    <div class="mb-3">
                        <strong>Interests:</strong><br>
                        <?php foreach ($interests as $interest): ?>
                            <span class="badge bg-primary me-1 mb-1"><?= htmlspecialchars($interest) ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Special Requirements -->
                <?php if (!empty($enquiry->special_requirements)): ?>
                    <div class="mb-3">
                        <strong>Special Requirements:</strong>
                        <div class="message-content p-3 bg-light rounded mt-2">
                            <?= nl2br(htmlspecialchars($enquiry->special_requirements)) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Message (if any) -->
                <?php if (!empty($enquiry->message)): ?>
                    <div class="mb-3">
                        <strong>Message:</strong>
                        <div class="message-content p-3 bg-light rounded mt-2">
                            <?= nl2br(htmlspecialchars($enquiry->message)) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <hr>
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>Submitted on <?= date('F d, Y \a\t H:i', strtotime($enquiry->created_at)) ?>
                    <?php if (!empty($enquiry->updated_at)): ?>
                        | <i class="fas fa-edit me-1"></i>Updated <?= date('M d, Y H:i', strtotime($enquiry->updated_at)) ?>
                    <?php endif; ?>
                    <?php if (!empty($enquiry->hear_about_us)): ?>
                        | <i class="fas fa-bullhorn me-1"></i>Found via: <?= htmlspecialchars($enquiry->hear_about_us) ?>
                    <?php endif; ?>
                </small>
            </div>
        </div>

        <!-- Admin Notes -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-sticky-note me-2"></i>Admin Notes
            </div>
            <div class="card-body">
                <!-- Add Note Form -->
                <form id="addNoteForm" class="mb-4">
                    <div class="mb-3">
                        <textarea name="note" class="form-control" rows="3" placeholder="Add a note about this enquiry..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Add Note
                    </button>
                </form>

                <!-- Notes List -->
                <div id="notesList">
                    <?php if (!empty($notes)): ?>
                        <?php foreach (array_reverse($notes) as $note): ?>
                            <div class="note-item border-start border-3 border-primary ps-3 mb-3">
                                <p class="mb-1"><?= nl2br(htmlspecialchars($note['note'])) ?></p>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i><?= date('M d, Y H:i', strtotime($note['created_at'])) ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted mb-0" id="noNotesMsg">No notes yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Customer Info -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user me-2"></i>Customer Information
            </div>
            <div class="card-body">
                <h5 class="mb-3"><?= htmlspecialchars($enquiry->full_name) ?></h5>
                
                <p class="mb-2">
                    <i class="fas fa-envelope text-muted me-2"></i>
                    <a href="mailto:<?= htmlspecialchars($enquiry->email) ?>"><?= htmlspecialchars($enquiry->email) ?></a>
                </p>
                
                <?php if (!empty($enquiry->phone)): ?>
                    <p class="mb-2">
                        <i class="fas fa-phone text-muted me-2"></i>
                        <a href="tel:<?= htmlspecialchars($enquiry->phone) ?>"><?= htmlspecialchars($enquiry->phone) ?></a>
                    </p>
                <?php endif; ?>
                
                <?php if (!empty($enquiry->country)): ?>
                    <p class="mb-2">
                        <i class="fas fa-globe text-muted me-2"></i>
                        <?= htmlspecialchars($enquiry->country) ?>
                    </p>
                <?php endif; ?>

                <hr>
                
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#emailModal">
                        <i class="fas fa-envelope me-1"></i>Send Email
                    </button>
                    <?php if (!empty($enquiry->phone)): ?>
                        <a href="tel:<?= htmlspecialchars($enquiry->phone) ?>" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-phone me-1"></i>Call
                        </a>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $enquiry->phone) ?>" target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp me-1"></i>WhatsApp
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-tag me-2"></i>Update Status
            </div>
            <div class="card-body">
                <?= form_open('admin/enquiries/update_status/' . $enquiry->uid, ['id' => 'statusForm']) ?>
                    <select name="status" class="form-select mb-3" id="statusSelect">
                        <option value="new" <?= $enquiry->status === 'new' ? 'selected' : '' ?>>🔴 New</option>
                        <option value="read" <?= $enquiry->status === 'read' ? 'selected' : '' ?>>🔵 Read</option>
                        <option value="replied" <?= $enquiry->status === 'replied' ? 'selected' : '' ?>>🟢 Replied</option>
                        <option value="closed" <?= $enquiry->status === 'closed' ? 'selected' : '' ?>>⚫ Closed</option>
                    </select>
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
                    <a href="<?= base_url('admin/enquiries/edit/' . $enquiry->uid) ?>" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>Edit Enquiry
                    </a>
                    <a href="<?= base_url('admin/enquiries/reply/' . $enquiry->uid) ?>" class="btn btn-success">
                        <i class="fas fa-reply me-1"></i>Send Reply
                    </a>
                    <button type="button" class="btn btn-outline-danger" 
                            onclick="confirmDelete('<?= base_url('admin/enquiries/delete/' . $enquiry->uid) ?>', 'enquiry')">
                        <i class="fas fa-trash me-1"></i>Delete Enquiry
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
        
        fetch('<?= base_url('admin/enquiries/add_note/' . $enquiry->uid) ?>', {
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
                // Remove "no notes" message
                const noNotesMsg = document.getElementById('noNotesMsg');
                if (noNotesMsg) noNotesMsg.remove();
                
                // Add new note to list
                const notesList = document.getElementById('notesList');
                const noteHtml = `
                    <div class="note-item border-start border-3 border-primary ps-3 mb-3">
                        <p class="mb-1">${noteText.replace(/\n/g, '<br>')}</p>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>Just now
                        </small>
                    </div>
                `;
                notesList.insertAdjacentHTML('afterbegin', noteHtml);
                
                // Clear form
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
        const status = document.getElementById('statusSelect').value;
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'status=' + encodeURIComponent(status) + '&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
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

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('admin/enquiries/send_email/' . $enquiry->uid) ?>" method="POST">
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="emailModalLabel">
                        <i class="fas fa-envelope me-2"></i>Send Email to <?= htmlspecialchars($enquiry->full_name) ?>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">To</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($enquiry->email) ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="email_subject" class="form-control" value="Re: Your Safari Enquiry <?= htmlspecialchars($enquiry->reference_number) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea name="email_message" class="form-control" rows="10" required placeholder="Write your message here...">Dear <?= htmlspecialchars($enquiry->full_name) ?>,

Thank you for your interest in our safari services!

<?php if (!empty($enquiry->trip_type)): ?>
Regarding your <?= htmlspecialchars($enquiry->trip_type) ?> enquiry:
<?php endif; ?>

We would be delighted to help you plan your safari adventure.

<?php 
$destinations = json_decode($enquiry->destinations ?? '[]', true);
if (!empty($destinations) && is_array($destinations)): 
?>
Your selected destinations (<?= implode(', ', $destinations) ?>) offer amazing wildlife experiences.
<?php endif; ?>

Please feel free to contact us if you have any questions.

Best regards,
Safari Adventure Team</textarea>
                    </div>
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        The email will be sent with your company branding and enquiry reference automatically included.
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
