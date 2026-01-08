<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Reply to Enquiry <?= htmlspecialchars($enquiry->reference_number) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/enquiries') ?>">Enquiries</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/enquiries/view/' . $enquiry->uid) ?>"><?= htmlspecialchars($enquiry->reference_number) ?></a></li>
                <li class="breadcrumb-item active">Reply</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/enquiries/view/' . $enquiry->uid) ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= validation_errors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-reply me-2"></i>Send Reply
            </div>
            <div class="card-body">
                <?= form_open('admin/enquiries/reply/' . $enquiry->uid) ?>
                    <div class="mb-3">
                        <label class="form-label">To</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($enquiry->full_name) ?> <<?= htmlspecialchars($enquiry->email) ?>>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control" 
                               value="<?= set_value('subject', 'Re: Safari Enquiry - ' . $enquiry->reference_number) ?>" required>
                    </div>
                    
                    <?php
                    $default_message = "Dear " . htmlspecialchars($enquiry->full_name) . ",

Thank you for your safari enquiry (Reference: " . $enquiry->reference_number . ").



Best regards,
Osiram Safari Adventure Team
📞 +255 789 356 961
✉️ welcome@osiramsafari.com";
                    ?>
                    <div class="mb-3">
                        <label class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="15" required><?= set_value('message', $default_message) ?></textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane me-1"></i>Send Reply
                        </button>
                        <a href="<?= base_url('admin/enquiries/view/' . $enquiry->uid) ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Original Enquiry Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-envelope me-2"></i>Original Enquiry
            </div>
            <div class="card-body">
                <p><strong>From:</strong> <?= htmlspecialchars($enquiry->full_name) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($enquiry->email) ?></p>
                <?php if (!empty($enquiry->phone)): ?>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($enquiry->phone) ?></p>
                <?php endif; ?>
                <?php if (!empty($enquiry->trip_type)): ?>
                    <p><strong>Trip Type:</strong> <?= htmlspecialchars($enquiry->trip_type) ?></p>
                <?php endif; ?>
                <?php if (!empty($enquiry->duration)): ?>
                    <p><strong>Duration:</strong> <?= htmlspecialchars($enquiry->duration) ?></p>
                <?php endif; ?>
                <p><strong>Travelers:</strong> <?= $enquiry->adults ?? 1 ?> Adult(s)
                    <?php if (($enquiry->children ?? 0) > 0): ?>
                        , <?= $enquiry->children ?> Child(ren)
                    <?php endif; ?>
                </p>
                <?php if (!empty($enquiry->budget)): ?>
                    <p><strong>Budget:</strong> <?= htmlspecialchars($enquiry->budget) ?></p>
                <?php endif; ?>
                <p><strong>Date:</strong> <?= date('M d, Y H:i', strtotime($enquiry->created_at)) ?></p>
            </div>
        </div>

        <!-- Quick Templates -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-alt me-2"></i>Quick Templates
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="insertTemplate('acknowledge')">
                        Acknowledge Receipt
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="insertTemplate('quote')">
                        Send Quote Template
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="insertTemplate('followup')">
                        Follow Up
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const templates = {
    acknowledge: `Dear <?= htmlspecialchars($enquiry->full_name) ?>,

Thank you for your safari enquiry (Reference: <?= $enquiry->reference_number ?>).

We have received your request and our safari experts are currently reviewing your requirements. We will get back to you within 24 hours with personalized recommendations and a detailed quote.

In the meantime, feel free to browse our website for more inspiration or reach out to us directly if you have any questions.

Best regards,
Osiram Safari Adventure Team
📞 +255 789 356 961
✉️ welcome@osiramsafari.com`,

    quote: `Dear <?= htmlspecialchars($enquiry->full_name) ?>,

Thank you for your interest in exploring Tanzania with Osiram Safari Adventure!

Based on your requirements:
- Trip Type: <?= $enquiry->trip_type ?? 'Safari' ?>

- Duration: <?= $enquiry->duration ?? 'To be determined' ?>

- Travelers: <?= $enquiry->adults ?? 1 ?> Adult(s)<?php if (($enquiry->children ?? 0) > 0): ?>, <?= $enquiry->children ?> Child(ren)<?php endif; ?>


We are pleased to present the following customized safari package for your consideration:

[PACKAGE DETAILS HERE]

Total Price: $X,XXX USD per person

This quote includes:
- All park fees and conservation fees
- Professional English-speaking safari guide
- Airport transfers
- Accommodation as specified
- Full board meals during safari
- Safari vehicle with pop-up roof

Please let us know if you would like to proceed with this package or if you have any questions.

Best regards,
Osiram Safari Adventure Team`,

    followup: `Dear <?= htmlspecialchars($enquiry->full_name) ?>,

I hope this message finds you well!

I wanted to follow up on our previous correspondence regarding your safari enquiry (Reference: <?= $enquiry->reference_number ?>).

Have you had a chance to review our proposal? We would love to help make your Tanzania adventure a reality!

If you have any questions or would like to discuss alternative options, please don't hesitate to reach out. We're here to help create the perfect safari experience for you.

Looking forward to hearing from you soon.

Best regards,
Osiram Safari Adventure Team
📞 +255 789 356 961
✉️ welcome@osiramsafari.com`
};

function insertTemplate(type) {
    const textarea = document.querySelector('textarea[name="message"]');
    if (templates[type]) {
        textarea.value = templates[type];
    }
}
</script>

<?php
// Helper function for default reply template
if (!function_exists('_get_reply_template')) {
    function _get_reply_template($enquiry) {
        return "Dear " . htmlspecialchars($enquiry->full_name) . ",

Thank you for your safari enquiry (Reference: " . $enquiry->reference_number . ").



Best regards,
Osiram Safari Adventure Team
📞 +255 789 356 961
✉️ welcome@osiramsafari.com";
    }
}
?>
