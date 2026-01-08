<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">View Notification</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/bulk-notifications') ?>">Bulk Notifications</a></li>
                <li class="breadcrumb-item active">View</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <?php if ($notification->status === 'draft'): ?>
            <a href="<?= base_url('admin/bulk-notifications/edit/' . $notification->uid) ?>" 
               class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        <?php endif; ?>
        <?php if (in_array($notification->status, ['draft', 'failed'])): ?>
            <a href="<?= base_url('admin/bulk-notifications/send/' . $notification->uid) ?>" 
               class="btn btn-success"
               onclick="return confirm('Send this notification now?')">
                <i class="fas fa-paper-plane me-2"></i>Send Now
            </a>
        <?php endif; ?>
        <a href="<?= base_url('admin/bulk-notifications/duplicate/' . $notification->uid) ?>" class="btn btn-outline-secondary">
            <i class="fas fa-copy me-2"></i>Duplicate
        </a>
        <a href="<?= base_url('admin/bulk-notifications') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Notification Details -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-envelope me-2"></i>Notification Details</span>
                <?php
                $status_classes = [
                    'draft' => 'bg-secondary',
                    'scheduled' => 'bg-warning text-dark',
                    'sending' => 'bg-info',
                    'sent' => 'bg-success',
                    'failed' => 'bg-danger',
                    'cancelled' => 'bg-dark'
                ];
                $class = $status_classes[$notification->status] ?? 'bg-secondary';
                ?>
                <span class="badge <?= $class ?>"><?= ucfirst($notification->status) ?></span>
            </div>
            <div class="card-body">
                <h4 class="mb-3"><?= htmlspecialchars($notification->title) ?></h4>
                
                <div class="mb-4">
                    <h6 class="text-muted">Message:</h6>
                    <div class="p-3 bg-light rounded">
                        <?php if ($notification->message_html): ?>
                            <?= $notification->message_html ?>
                        <?php else: ?>
                            <?= nl2br(htmlspecialchars($notification->message)) ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td class="text-muted">Type:</td>
                                <td><span class="badge bg-info"><?= ucfirst($notification->type) ?></span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Priority:</td>
                                <td>
                                    <?php
                                    $priority_classes = [
                                        'low' => 'bg-secondary',
                                        'normal' => 'bg-primary',
                                        'high' => 'bg-warning text-dark',
                                        'urgent' => 'bg-danger'
                                    ];
                                    ?>
                                    <span class="badge <?= $priority_classes[$notification->priority] ?? 'bg-primary' ?>">
                                        <?= ucfirst($notification->priority) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Target Groups:</td>
                                <td>
                                    <?php if (!empty($target_group_names)): ?>
                                        <?php foreach ($target_group_names as $name): ?>
                                            <span class="badge bg-secondary me-1"><?= htmlspecialchars($name) ?></span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td class="text-muted">Created:</td>
                                <td><?= date('M d, Y g:i A', strtotime($notification->created_at)) ?></td>
                            </tr>
                            <?php if ($notification->scheduled_at): ?>
                                <tr>
                                    <td class="text-muted">Scheduled:</td>
                                    <td><?= date('M d, Y g:i A', strtotime($notification->scheduled_at)) ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($notification->sent_at): ?>
                                <tr>
                                    <td class="text-muted">Sent:</td>
                                    <td><?= date('M d, Y g:i A', strtotime($notification->sent_at)) ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recipients -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-users me-2"></i>Recipients (<?= count($recipients) ?>)
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover" id="recipientsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <?php if ($notification->type === 'email' || $notification->type === 'both'): ?>
                                    <th>Email</th>
                                <?php endif; ?>
                                <?php if ($notification->type === 'sms' || $notification->type === 'both'): ?>
                                    <th>Phone</th>
                                <?php endif; ?>
                                <th>Status</th>
                                <th>Sent At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recipients as $recipient): ?>
                                <tr>
                                    <td><?= htmlspecialchars($recipient->recipient_name) ?></td>
                                    <?php if ($notification->type === 'email' || $notification->type === 'both'): ?>
                                        <td><?= htmlspecialchars($recipient->recipient_email) ?></td>
                                    <?php endif; ?>
                                    <?php if ($notification->type === 'sms' || $notification->type === 'both'): ?>
                                        <td><?= htmlspecialchars($recipient->recipient_phone ?? '—') ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <?php
                                        $r_status_classes = [
                                            'pending' => 'bg-secondary',
                                            'sent' => 'bg-success',
                                            'failed' => 'bg-danger',
                                            'opened' => 'bg-info',
                                            'bounced' => 'bg-warning text-dark'
                                        ];
                                        ?>
                                        <span class="badge <?= $r_status_classes[$recipient->status] ?? 'bg-secondary' ?>">
                                            <?= ucfirst($recipient->status) ?>
                                        </span>
                                        <?php if ($recipient->error_message): ?>
                                            <i class="fas fa-info-circle text-danger ms-1" 
                                               title="<?= htmlspecialchars($recipient->error_message) ?>"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $recipient->sent_at ? date('M d, g:i A', strtotime($recipient->sent_at)) : '—' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Statistics -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-pie me-2"></i>Delivery Statistics
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Total Recipients</span>
                        <strong><?= $notification->total_recipients ?></strong>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-success"><i class="fas fa-check me-1"></i>Sent</span>
                        <strong class="text-success"><?= $notification->sent_count ?></strong>
                    </div>
                    <?php 
                    $sent_pct = $notification->total_recipients > 0 
                        ? ($notification->sent_count / $notification->total_recipients) * 100 
                        : 0;
                    ?>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: <?= $sent_pct ?>%;"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-danger"><i class="fas fa-times me-1"></i>Failed</span>
                        <strong class="text-danger"><?= $notification->failed_count ?></strong>
                    </div>
                    <?php 
                    $failed_pct = $notification->total_recipients > 0 
                        ? ($notification->failed_count / $notification->total_recipients) * 100 
                        : 0;
                    ?>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: <?= $failed_pct ?>%;"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-secondary"><i class="fas fa-clock me-1"></i>Pending</span>
                        <strong><?= $recipient_stats['pending'] ?? 0 ?></strong>
                    </div>
                </div>

                <?php if (($recipient_stats['opened'] ?? 0) > 0): ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-info"><i class="fas fa-envelope-open me-1"></i>Opened</span>
                            <strong class="text-info"><?= $recipient_stats['opened'] ?></strong>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-cogs me-2"></i>Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <?php if (in_array($notification->status, ['draft', 'failed'])): ?>
                        <a href="<?= base_url('admin/bulk-notifications/send/' . $notification->uid) ?>" 
                           class="btn btn-success"
                           onclick="return confirm('Send this notification now?')">
                            <i class="fas fa-paper-plane me-2"></i>Send Now
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($notification->status === 'scheduled'): ?>
                        <a href="<?= base_url('admin/bulk-notifications/cancel/' . $notification->uid) ?>" 
                           class="btn btn-warning"
                           onclick="return confirm('Cancel this scheduled notification?')">
                            <i class="fas fa-times me-2"></i>Cancel Schedule
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?= base_url('admin/bulk-notifications/duplicate/' . $notification->uid) ?>" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-copy me-2"></i>Duplicate
                    </a>
                    
                    <button type="button" class="btn btn-outline-danger" 
                            onclick="confirmDelete('<?= base_url('admin/bulk-notifications/delete/' . $notification->uid) ?>', 'notification')">
                        <i class="fas fa-trash me-2"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#recipientsTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[2, 'asc']]
    });
});
</script>
