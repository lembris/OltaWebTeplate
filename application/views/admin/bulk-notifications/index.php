<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Bulk Notifications</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Bulk Notifications</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/contact-groups') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-users-cog me-2"></i>Manage Groups
        </a>
        <a href="<?= base_url('admin/bulk-notifications/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>New Notification
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-paper-plane"></i></div>
            <div class="stat-value"><?= $stats['total'] ?? 0 ?></div>
            <div class="stat-label">Total Notifications</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value"><?= $stats['sent'] ?? 0 ?></div>
            <div class="stat-label">Sent</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-value"><?= $stats['scheduled'] ?? 0 ?></div>
            <div class="stat-label">Scheduled</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-envelope-open"></i></div>
            <div class="stat-value"><?= number_format($stats['total_sent'] ?? 0) ?></div>
            <div class="stat-label">Emails Sent</div>
        </div>
    </div>
</div>

<!-- Notifications Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Notifications</span>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
            <button type="button" class="btn btn-outline-success filter-btn" data-filter="sent">Sent</button>
            <button type="button" class="btn btn-outline-warning filter-btn" data-filter="scheduled">Scheduled</button>
            <button type="button" class="btn btn-outline-secondary filter-btn" data-filter="draft">Drafts</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="notificationsTable">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Type</th>
                        <th>Recipients</th>
                        <th>Sent/Failed</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($notifications)): ?>
                        <?php foreach ($notifications as $notification): ?>
                            <tr data-status="<?= $notification->status ?>">
                                <td>
                                    <strong><?= htmlspecialchars($notification->title) ?></strong>
                                    <?php if ($notification->priority === 'urgent'): ?>
                                        <span class="badge bg-danger ms-1">Urgent</span>
                                    <?php elseif ($notification->priority === 'high'): ?>
                                        <span class="badge bg-warning text-dark ms-1">High</span>
                                    <?php endif; ?>
                                    <br>
                                    <small class="text-muted"><?= substr(strip_tags($notification->message), 0, 60) ?>...</small>
                                </td>
                                <td>
                                    <?php
                                    $type_icons = ['email' => 'fa-envelope', 'sms' => 'fa-sms', 'both' => 'fa-paper-plane'];
                                    $icon = $type_icons[$notification->type] ?? 'fa-envelope';
                                    ?>
                                    <span class="badge bg-info">
                                        <i class="fas <?= $icon ?> me-1"></i><?= ucfirst($notification->type) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?= number_format($notification->total_recipients) ?></span>
                                </td>
                                <td>
                                    <span class="text-success"><?= $notification->sent_count ?></span>
                                    /
                                    <span class="text-danger"><?= $notification->failed_count ?></span>
                                </td>
                                <td>
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
                                    <?php if ($notification->scheduled_at && $notification->status === 'scheduled'): ?>
                                        <br><small class="text-muted"><?= date('M d, g:i A', strtotime($notification->scheduled_at)) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= date('M d, Y', strtotime($notification->created_at)) ?>
                                    <br><small class="text-muted"><?= date('g:i A', strtotime($notification->created_at)) ?></small>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('admin/bulk-notifications/view/' . $notification->uid) ?>" 
                                           class="btn btn-sm btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <?php if (in_array($notification->status, ['draft', 'failed'])): ?>
                                            <a href="<?= base_url('admin/bulk-notifications/send/' . $notification->uid) ?>" 
                                               class="btn btn-sm btn-outline-success" title="Send Now"
                                               onclick="return confirm('Send this notification now?')">
                                                <i class="fas fa-paper-plane"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($notification->status === 'scheduled'): ?>
                                            <a href="<?= base_url('admin/bulk-notifications/cancel/' . $notification->uid) ?>" 
                                               class="btn btn-sm btn-outline-warning" title="Cancel"
                                               onclick="return confirm('Cancel this scheduled notification?')">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <a href="<?= base_url('admin/bulk-notifications/duplicate/' . $notification->uid) ?>" 
                                           class="btn btn-sm btn-outline-secondary" title="Duplicate">
                                            <i class="fas fa-copy"></i>
                                        </a>
                                        
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete('<?= base_url('admin/bulk-notifications/delete/' . $notification->uid) ?>', 'notification')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = $('#notificationsTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[5, 'desc']],
        language: {
            emptyTable: '<div class="text-center py-4"><div class="text-muted"><i class="fas fa-bell fa-3x mb-3"></i><p>No notifications yet.</p><a href="<?= base_url('admin/bulk-notifications/create') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Create First Notification</a></div></div>'
        }
    });

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            document.querySelectorAll('#notificationsTable tbody tr').forEach(row => {
                const status = row.dataset.status;
                if (filter === 'all' || filter === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
});
</script>
