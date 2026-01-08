<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Reply to Contact</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/contacts') ?>">Contacts</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/contacts/view/' . $enquiry->uid) ?>"><?= htmlspecialchars($enquiry->reference_number) ?></a></li>
                <li class="breadcrumb-item active">Reply</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/contacts/view/' . $enquiry->uid) ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Contact
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Reply Form -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="fas fa-reply me-2"></i>Send Reply to <?= htmlspecialchars($enquiry->full_name) ?>
            </div>
            <div class="card-body">
                <?= form_open('admin/contacts/reply/' . $enquiry->uid) ?>
                    <div class="mb-3">
                        <label class="form-label">To</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($enquiry->email) ?>" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control" 
                               value="Re: <?= htmlspecialchars($contact_subject ?: 'Your Contact Message') ?> - <?= htmlspecialchars($enquiry->reference_number) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="12" required>Dear <?= htmlspecialchars($enquiry->full_name) ?>,

Thank you for contacting Osiram Safari Adventure!

<?php if (!empty($contact_subject)): ?>
Regarding your message about "<?= htmlspecialchars($contact_subject) ?>":
<?php endif; ?>

[Your reply here]

We appreciate you reaching out to us. Please don't hesitate to contact us if you have any further questions.

Best regards,
Osiram Safari Adventure Team
📞 +255 789 356 961
✉️ welcome@osiramsafari.com</textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane me-2"></i>Send Reply
                        </button>
                        <a href="<?= base_url('admin/contacts/view/' . $enquiry->uid) ?>" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Original Message -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-quote-left me-2"></i>Original Message
            </div>
            <div class="card-body">
                <?php if (!empty($contact_subject)): ?>
                    <p class="mb-2"><strong>Subject:</strong><br><?= htmlspecialchars($contact_subject) ?></p>
                    <hr>
                <?php endif; ?>
                <p class="mb-0"><strong>Message:</strong></p>
                <div class="bg-light p-3 rounded mt-2">
                    <?= nl2br(htmlspecialchars($contact_message)) ?>
                </div>
            </div>
        </div>
        
        <!-- Contact Info -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user me-2"></i>Contact Info
            </div>
            <div class="card-body">
                <p class="mb-2"><strong><?= htmlspecialchars($enquiry->full_name) ?></strong></p>
                <p class="mb-2">
                    <i class="fas fa-envelope text-muted me-2"></i>
                    <a href="mailto:<?= htmlspecialchars($enquiry->email) ?>"><?= htmlspecialchars($enquiry->email) ?></a>
                </p>
                <?php if (!empty($enquiry->phone)): ?>
                    <p class="mb-0">
                        <i class="fas fa-phone text-muted me-2"></i>
                        <a href="tel:<?= htmlspecialchars($enquiry->phone) ?>"><?= htmlspecialchars($enquiry->phone) ?></a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
