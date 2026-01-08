<!-- Page Header -->
<?php $is_edit = isset($is_edit) && $is_edit; ?>
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $is_edit ? 'Edit Notification' : 'Create Notification' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/bulk-notifications') ?>">Bulk Notifications</a></li>
                <li class="breadcrumb-item active"><?= $is_edit ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <?php if ($is_edit && $notification): ?>
            <a href="<?= base_url('admin/bulk-notifications/view/' . $notification->uid) ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to View
            </a>
        <?php else: ?>
            <a href="<?= base_url('admin/bulk-notifications') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= validation_errors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open($form_action, ['id' => 'notificationForm']) ?>
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Message -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-envelope me-2"></i>Message Content</span>
                    <?php if (!empty($templates)): ?>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-file-alt me-1"></i>Use Template
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php foreach ($templates as $template): ?>
                                    <li>
                                        <a class="dropdown-item template-item" href="#" data-id="<?= $template->id ?>">
                                            <?= htmlspecialchars($template->name) ?>
                                            <small class="text-muted d-block"><?= $template->category ?></small>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control" 
                               value="<?= set_value('title', $notification->title ?? '') ?>" 
                               placeholder="Enter email subject"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea name="message" 
                                  id="message" 
                                  class="form-control" 
                                  rows="6"
                                  placeholder="Enter your message here..."
                                  required><?= set_value('message', $notification->message ?? '') ?></textarea>
                        <small class="text-muted">
                            Use <code>{{recipient_name}}</code> or <code>{{name}}</code> to personalize messages.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">HTML Message (Optional)</label>
                        <textarea name="message_html" 
                                  id="message_html" 
                                  class="form-control ckeditor" 
                                  rows="8"><?= set_value('message_html', $notification->message_html ?? '') ?></textarea>
                        <small class="text-muted">Rich HTML version of your message. If empty, plain text will be used.</small>
                    </div>
                </div>
            </div>

            <!-- Scheduling -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-clock me-2"></i>Scheduling
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Send Time</label>
                                <select name="send_option" id="sendOption" class="form-select">
                                    <option value="now">Send Immediately</option>
                                    <option value="schedule">Schedule for Later</option>
                                    <option value="draft">Save as Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3" id="scheduleDateTime" style="display: none;">
                                <label class="form-label">Scheduled Date & Time</label>
                                <input type="datetime-local" 
                                       name="scheduled_at" 
                                       class="form-control"
                                       min="<?= date('Y-m-d\TH:i') ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Recipients -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-users me-2"></i>Recipients
                </div>
                <div class="card-body">
                    <?php if (!empty($groups)): ?>
                        <?php $selected_groups = $selected_groups ?? []; ?>
                        <p class="text-muted small">Select contact groups to send to:</p>
                        
                        <?php foreach ($groups as $group): ?>
                            <?php if ($group->is_active): ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input group-checkbox" 
                                           type="checkbox" 
                                           name="target_groups[]" 
                                           value="<?= $group->id ?>" 
                                           id="group_<?= $group->id ?>"
                                           <?= in_array($group->id, $selected_groups) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="group_<?= $group->id ?>">
                                        <i class="fas <?= $group->icon ?> me-1" style="color: <?= $group->color ?>;"></i>
                                        <?= htmlspecialchars($group->name) ?>
                                        <span class="badge bg-secondary ms-1"><?= $group->member_count ?? 0 ?></span>
                                    </label>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                        <hr>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted">Total Recipients:</span>
                            <span class="badge bg-primary" id="totalRecipients">0</span>
                        </div>
                        
                        <div class="mt-3">
                            <a href="<?= base_url('admin/contact-groups') ?>" class="btn btn-sm btn-outline-secondary w-100">
                                <i class="fas fa-cog me-1"></i>Manage Groups
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No contact groups available.
                            <a href="<?= base_url('admin/contact-groups/create') ?>">Create one first</a>.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Options -->
            <?php $current_type = $notification->type ?? 'email'; ?>
            <?php $current_priority = $notification->priority ?? 'normal'; ?>
            <?php $current_sms_provider = $notification->sms_provider_id ?? ''; ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-cog me-2"></i>Options
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" id="notificationType" class="form-select">
                            <option value="email" <?= $current_type === 'email' ? 'selected' : '' ?>>Email Only</option>
                            <?php if (!empty($sms_providers)): ?>
                                <option value="sms" <?= $current_type === 'sms' ? 'selected' : '' ?>>SMS Only</option>
                                <option value="both" <?= $current_type === 'both' ? 'selected' : '' ?>>Email + SMS</option>
                            <?php else: ?>
                                <option value="sms" disabled>SMS Only (No providers configured)</option>
                                <option value="both" disabled>Email + SMS (No providers configured)</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- SMS Provider Selector -->
                    <div class="mb-3" id="smsProviderSection" style="display: <?= in_array($current_type, ['sms', 'both']) ? 'block' : 'none' ?>;">
                        <label class="form-label">SMS Provider <span class="text-danger">*</span></label>
                        <select name="sms_provider_id" id="smsProviderId" class="form-select">
                            <option value="">-- Select SMS Provider --</option>
                            <?php if (!empty($sms_providers)): ?>
                                <?php foreach ($sms_providers as $provider): ?>
                                    <option value="<?= $provider->id ?>" <?= $current_sms_provider == $provider->id ? 'selected' : '' ?>><?= htmlspecialchars($provider->name) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small class="text-muted">
                            Select which SMS provider to use for sending messages.
                            <a href="<?= base_url('admin/settings#sms-providers') ?>">Manage SMS Providers</a>
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="low" <?= $current_priority === 'low' ? 'selected' : '' ?>>Low</option>
                            <option value="normal" <?= $current_priority === 'normal' ? 'selected' : '' ?>>Normal</option>
                            <option value="high" <?= $current_priority === 'high' ? 'selected' : '' ?>>High</option>
                            <option value="urgent" <?= $current_priority === 'urgent' ? 'selected' : '' ?>>Urgent</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-paper-plane me-2"></i>Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" name="action" value="send_now" class="btn btn-success btn-lg" id="sendNowBtn">
                            <i class="fas fa-paper-plane me-2"></i>Send Now
                        </button>
                        <button type="submit" name="action" value="schedule" class="btn btn-warning" id="scheduleBtn" style="display: none;">
                            <i class="fas fa-clock me-2"></i>Schedule
                        </button>
                        <button type="submit" name="action" value="draft" class="btn btn-outline-secondary" id="draftBtn">
                            <i class="fas fa-save me-2"></i>Save as Draft
                        </button>
                        <a href="<?= base_url('admin/bulk-notifications') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendOption = document.getElementById('sendOption');
    const scheduleDateTime = document.getElementById('scheduleDateTime');
    const sendNowBtn = document.getElementById('sendNowBtn');
    const scheduleBtn = document.getElementById('scheduleBtn');
    const draftBtn = document.getElementById('draftBtn');
    const notificationType = document.getElementById('notificationType');
    const smsProviderSection = document.getElementById('smsProviderSection');
    const smsProviderId = document.getElementById('smsProviderId');
    
    // Handle notification type change (show/hide SMS provider selector)
    notificationType.addEventListener('change', function() {
        if (this.value === 'sms' || this.value === 'both') {
            smsProviderSection.style.display = 'block';
            smsProviderId.required = true;
        } else {
            smsProviderSection.style.display = 'none';
            smsProviderId.required = false;
            smsProviderId.value = '';
        }
    });
    
    // Handle send option change
    sendOption.addEventListener('change', function() {
        if (this.value === 'schedule') {
            scheduleDateTime.style.display = 'block';
            sendNowBtn.style.display = 'none';
            scheduleBtn.style.display = 'block';
            draftBtn.style.display = 'block';
        } else if (this.value === 'draft') {
            scheduleDateTime.style.display = 'none';
            sendNowBtn.style.display = 'none';
            scheduleBtn.style.display = 'none';
            draftBtn.style.display = 'block';
            draftBtn.classList.remove('btn-outline-secondary');
            draftBtn.classList.add('btn-primary', 'btn-lg');
        } else {
            scheduleDateTime.style.display = 'none';
            sendNowBtn.style.display = 'block';
            scheduleBtn.style.display = 'none';
            draftBtn.style.display = 'block';
            draftBtn.classList.remove('btn-primary', 'btn-lg');
            draftBtn.classList.add('btn-outline-secondary');
        }
    });
    
    // Calculate total recipients
    function updateRecipientCount() {
        let total = 0;
        document.querySelectorAll('.group-checkbox:checked').forEach(function(checkbox) {
            const label = checkbox.nextElementSibling;
            const badge = label.querySelector('.badge');
            if (badge) {
                total += parseInt(badge.textContent) || 0;
            }
        });
        document.getElementById('totalRecipients').textContent = total;
    }
    
    document.querySelectorAll('.group-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', updateRecipientCount);
    });
    
    // Calculate initial recipient count on page load (for edit mode)
    updateRecipientCount();
    
    // Form validation - require recipients for send/schedule
    document.getElementById('notificationForm').addEventListener('submit', function(e) {
        const action = e.submitter ? e.submitter.value : '';
        
        // Only validate recipients for send_now and schedule actions (not drafts)
        if (action === 'send_now' || action === 'schedule') {
            const checkedGroups = document.querySelectorAll('.group-checkbox:checked');
            if (checkedGroups.length === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'No Recipients Selected',
                    text: 'Please select at least one recipient group before sending.',
                    confirmButtonColor: '#dc3545'
                });
                return false;
            }
        }
        
        // Validate SMS provider when SMS type is selected
        const notificationType = document.getElementById('notificationType').value;
        if ((notificationType === 'sms' || notificationType === 'both') && action !== 'draft') {
            const smsProvider = document.getElementById('smsProviderId').value;
            if (!smsProvider) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'SMS Provider Required',
                    text: 'Please select an SMS provider for SMS notifications.',
                    confirmButtonColor: '#dc3545'
                });
                return false;
            }
        }
    });
    
    // Template loader
    document.querySelectorAll('.template-item').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const templateId = this.dataset.id;
            
            fetch('<?= base_url('admin/bulk-notifications/get-template-json/') ?>' + templateId)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('title').value = data.subject || '';
                        document.getElementById('message').value = data.body || '';
                        
                        // If CKEditor is available
                        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.message_html) {
                            CKEDITOR.instances.message_html.setData(data.body_html || '');
                        } else {
                            document.getElementById('message_html').value = data.body_html || '';
                        }
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Template Loaded',
                            text: 'Remember to customize the message before sending!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
        });
    });
});
</script>
