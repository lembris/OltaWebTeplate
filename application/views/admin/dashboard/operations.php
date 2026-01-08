<!-- Business Operations Dashboard -->
<style>
    .ops-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .ops-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .stat-card-modern {
        position: relative;
        padding: 25px;
        border-radius: 15px;
        color: #fff;
        overflow: hidden;
    }
    
    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(30deg);
        pointer-events: none;
    }
    
    .stat-card-modern.blue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stat-card-modern.green {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .stat-card-modern.orange {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .stat-card-modern.purple {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .stat-card-modern.teal {
        background: linear-gradient(135deg, #0dcaf0 0%, #20c997 100%);
    }
    
    .stat-card-modern.indigo {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    }
    
    .stat-card-modern.amber {
        background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
    }
    
    .stat-card-modern.rose {
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
    }
    
    .stat-icon-wrapper {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stat-icon-wrapper i {
        font-size: 1.8rem;
        color: #fff;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 5px;
        line-height: 1;
    }
    
    .stat-label {
        font-size: 0.95rem;
        opacity: 0.9;
        font-weight: 500;
    }
    
    .stat-trend {
        font-size: 0.8rem;
        margin-top: 10px;
        opacity: 0.85;
    }
    
    .stat-trend i {
        margin-right: 5px;
    }
    
    .welcome-banner {
        background: linear-gradient(135deg, #1e3a5f 0%, #0d1b2a 100%);
        color: #fff;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-banner::after {
        content: '';
        position: absolute;
        right: -100px;
        top: -100px;
        width: 300px;
        height: 300px;
        background: rgba(99, 102, 241, 0.15);
        border-radius: 50%;
    }
    
    .welcome-banner h2 {
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .welcome-banner p {
        opacity: 0.85;
        margin-bottom: 0;
    }
    
    .table-card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .table-card .card-header {
        background: #fff;
        border-bottom: 1px solid #eee;
        padding: 18px 20px;
    }
    
    .table-card .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-card .card-header h5 i {
        color: var(--accent-color);
    }
    
    .status-pill {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pill.pending { background: #fff3cd; color: #856404; }
    .status-pill.under_review { background: #cce5ff; color: #004085; }
    .status-pill.accepted { background: #d4edda; color: #155724; }
    .status-pill.rejected { background: #f8d7da; color: #721c24; }
    .status-pill.enrolled { background: #d1ecf1; color: #0c5460; }
    .status-pill.waitlisted { background: #e2e3e5; color: #383d41; }
    .status-pill.withdrawn { background: #6c757d; color: #fff; }
    .status-pill.new { background: #cce5ff; color: #004085; }
    .status-pill.contacted { background: #d1ecf1; color: #0c5460; }
    .status-pill.active { background: #d4edda; color: #155724; }
    .status-pill.upcoming { background: #cce5ff; color: #004085; }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }
    
    .dashboard-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
    }
    
    .dashboard-tabs .tab-btn {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .dashboard-tabs .tab-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
    }
    
    .dashboard-tabs .tab-btn:not(.active) {
        background: #f8f9fa;
        color: #333;
    }
    
    .dashboard-tabs .tab-btn:not(.active):hover {
        background: #e9ecef;
    }
    
    .mini-stat {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 10px;
    }
    
    .mini-stat .icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .mini-stat .icon.blue { background: rgba(102, 126, 234, 0.15); color: #667eea; }
    .mini-stat .icon.green { background: rgba(17, 153, 142, 0.15); color: #11998e; }
    .mini-stat .icon.orange { background: rgba(240, 147, 251, 0.15); color: #f093fb; }
    .mini-stat .icon.purple { background: rgba(79, 172, 254, 0.15); color: #4facfe; }
    
    .mini-stat .info { flex: 1; }
    .mini-stat .info .label { font-size: 0.85rem; color: #666; }
    .mini-stat .info .value { font-size: 1.5rem; font-weight: 700; color: #333; }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Business Operations</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item active">Operations Dashboard</li>
            </ol>
        </nav>
    </div>
    <div>
        <span class="text-muted"><i class="fas fa-clock me-1"></i> <?= date('l, F j, Y') ?></span>
    </div>
</div>

<!-- Dashboard Tabs -->
<div class="dashboard-tabs">
    <a href="<?= base_url('admin/dashboard/operations') ?>" class="tab-btn active">
        <i class="fas fa-briefcase"></i> Operations
    </a>
    <a href="<?= base_url('admin/dashboard/analytics') ?>" class="tab-btn">
        <i class="fas fa-chart-line"></i> Analytics
    </a>
</div>

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2><i class="fas fa-briefcase me-2"></i> Business Operations Dashboard</h2>
            <p>Manage admissions, academic programs, faculty, events, and communications.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="<?= base_url('admin/admissions') ?>" class="btn btn-warning text-white">
                <i class="fas fa-user-graduate me-2"></i> View Admissions
            </a>
        </div>
    </div>
</div>

<!-- Admission Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/admissions') ?>" class="text-decoration-none">
            <div class="stat-card-modern blue ops-card">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-number"><?= number_format($total_admissions ?? 0) ?></div>
                <div class="stat-label">Total Applications</div>
                <div class="stat-trend">
                    <i class="fas fa-clock"></i> <?= number_format($pending_admissions ?? 0) ?> pending review
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/admissions?status=accepted') ?>" class="text-decoration-none">
            <div class="stat-card-modern green ops-card">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number"><?= number_format($accepted_admissions ?? 0) ?></div>
                <div class="stat-label">Accepted Students</div>
                <div class="stat-trend">
                    <i class="fas fa-user-check"></i> <?= number_format($enrolled_admissions ?? 0) ?> enrolled
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/departments') ?>" class="text-decoration-none">
            <div class="stat-card-modern purple ops-card">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-sitemap"></i>
                </div>
                <div class="stat-number"><?= number_format($total_departments ?? 0) ?></div>
                <div class="stat-label">Departments</div>
                <div class="stat-trend">
                    <i class="fas fa-check"></i> <?= number_format($active_departments ?? 0) ?> active
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/faculty') ?>" class="text-decoration-none">
            <div class="stat-card-modern indigo ops-card">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
                <div class="stat-number"><?= number_format($total_faculty ?? 0) ?></div>
                <div class="stat-label">Faculty & Staff</div>
                <div class="stat-trend">
                    <i class="fas fa-user-check"></i> <?= number_format($active_faculty ?? 0) ?> active
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Second Row Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/programs') ?>" class="text-decoration-none">
            <div class="stat-card-modern teal ops-card">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-number"><?= number_format($total_programs ?? 0) ?></div>
                <div class="stat-label">Academic Programs</div>
                <div class="stat-trend">
                    <i class="fas fa-check"></i> <?= number_format($active_programs ?? 0) ?> active
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/events') ?>" class="text-decoration-none">
            <div class="stat-card-modern amber ops-card">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-calendar-days"></i>
                </div>
                <div class="stat-number"><?= number_format($total_events ?? 0) ?></div>
                <div class="stat-label">Total Events</div>
                <div class="stat-trend">
                    <i class="fas fa-calendar-check"></i> <?= count($upcoming_events ?? []) ?> upcoming
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/contacts') ?>" class="text-decoration-none">
            <div class="stat-card-modern rose ops-card">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-number"><?= number_format($unread_messages ?? 0) ?></div>
                <div class="stat-label">Unread Messages</div>
                <div class="stat-trend">
                    <i class="fas fa-inbox"></i> Contact inquiries
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url('admin/enquiries') ?>" class="text-decoration-none">
            <div class="stat-card-modern orange ops-card">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="stat-number"><?= number_format($new_enquiries ?? 0) ?></div>
                <div class="stat-label">New Enquiries</div>
                <div class="stat-trend">
                    <i class="fas fa-list"></i> <?= number_format($total_enquiries ?? 0) ?> total
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Main Content Row -->
<div class="row">
    <!-- Recent Admissions -->
    <div class="col-lg-8 mb-4">
        <div class="card table-card ops-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-user-graduate"></i> Recent Applications</h5>
                <a href="<?= base_url('admin/admissions') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($recent_admissions)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Applicant</th>
                                <th>Program</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_admissions as $admission): ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url('admin/admissions/view/' . $admission->id) ?>" class="fw-bold text-decoration-none">
                                        <?= htmlspecialchars($admission->reference_number) ?>
                                    </a>
                                </td>
                                <td>
                                    <div><?= htmlspecialchars($admission->full_name) ?></div>
                                    <small class="text-muted"><?= htmlspecialchars($admission->email) ?></small>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 150px;" title="<?= htmlspecialchars($admission->program_name ?? 'N/A') ?>">
                                        <?= htmlspecialchars($admission->program_code ?? 'N/A') ?>
                                    </span>
                                </td>
                                <td>
                                    <span title="<?= date('F j, Y g:i A', strtotime($admission->created_at)) ?>">
                                        <?= date('M j, Y', strtotime($admission->created_at)) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-pill <?= strtolower($admission->status) ?>">
                                        <?= ucfirst(str_replace('_', ' ', $admission->status)) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-user-graduate"></i>
                    <p>No applications yet</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Admission Stats Sidebar -->
    <div class="col-lg-4 mb-4">
        <div class="card ops-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-pie text-primary me-2"></i>Admission Overview</h5>
            </div>
            <div class="card-body">
                <?php 
                $stats = $admission_stats ?? [];
                ?>
                <div class="mini-stat">
                    <div class="icon blue"><i class="fas fa-hourglass-half"></i></div>
                    <div class="info">
                        <div class="label">Pending Review</div>
                        <div class="value"><?= number_format($stats['pending'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="mini-stat">
                    <div class="icon purple"><i class="fas fa-search"></i></div>
                    <div class="info">
                        <div class="label">Under Review</div>
                        <div class="value"><?= number_format($stats['under_review'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="mini-stat">
                    <div class="icon green"><i class="fas fa-check-circle"></i></div>
                    <div class="info">
                        <div class="label">Accepted</div>
                        <div class="value"><?= number_format($stats['accepted'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="mini-stat">
                    <div class="icon orange"><i class="fas fa-user-check"></i></div>
                    <div class="info">
                        <div class="label">Enrolled</div>
                        <div class="value"><?= number_format($stats['enrolled'] ?? 0) ?></div>
                    </div>
                </div>
                
                <hr>
                <div class="d-flex justify-content-between text-muted small">
                    <span><i class="fas fa-calendar-week me-1"></i> This Week: <?= number_format($stats['this_week'] ?? 0) ?></span>
                    <span><i class="fas fa-calendar me-1"></i> This Month: <?= number_format($stats['this_month'] ?? 0) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row -->
<div class="row">
    <!-- Upcoming Events -->
    <div class="col-lg-6 mb-4">
        <div class="card table-card ops-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-calendar-days"></i> Upcoming Events</h5>
                <a href="<?= base_url('admin/events') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($upcoming_events)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($upcoming_events as $event): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($event->title) ?></div>
                                    <small class="text-muted"><?= htmlspecialchars($event->department_name ?? 'General') ?></small>
                                </td>
                                <td>
                                    <span title="<?= date('F j, Y', strtotime($event->start_date)) ?>">
                                        <?= date('M j, Y', strtotime($event->start_date)) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-pill <?= strtolower($event->status) ?>">
                                        <?= ucfirst($event->status) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No upcoming events</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Enquiries -->
    <div class="col-lg-6 mb-4">
        <div class="card table-card ops-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-envelope"></i> Recent Enquiries</h5>
                <a href="<?= base_url('admin/enquiries') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($recent_enquiries)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>From</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_enquiries as $enquiry): ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url('admin/enquiries/view/' . $enquiry->id) ?>" class="fw-bold text-decoration-none">
                                        <?= htmlspecialchars($enquiry->reference_number) ?>
                                    </a>
                                </td>
                                <td>
                                    <div><?= htmlspecialchars($enquiry->full_name) ?></div>
                                    <small class="text-muted"><?= htmlspecialchars($enquiry->email) ?></small>
                                </td>
                                <td>
                                    <span title="<?= date('F j, Y g:i A', strtotime($enquiry->created_at)) ?>">
                                        <?= date('M j, Y', strtotime($enquiry->created_at)) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-pill <?= strtolower($enquiry->status) ?>">
                                        <?= ucfirst($enquiry->status) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>No enquiries yet</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Notices -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card table-card ops-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-clipboard-list"></i> Recent Notices</h5>
                <a href="<?= base_url('admin/notices') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($recent_notices)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Created</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_notices as $notice): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold">
                                        <?php if (!empty($notice->pinned)): ?>
                                            <i class="fas fa-thumbtack text-warning me-1" title="Pinned"></i>
                                        <?php endif; ?>
                                        <?= htmlspecialchars($notice->title) ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?= ucfirst($notice->category ?? 'General') ?></span>
                                </td>
                                <td>
                                    <?php 
                                    $priority_class = 'secondary';
                                    if (($notice->priority ?? 0) >= 3) $priority_class = 'danger';
                                    elseif (($notice->priority ?? 0) >= 2) $priority_class = 'warning';
                                    elseif (($notice->priority ?? 0) >= 1) $priority_class = 'info';
                                    ?>
                                    <span class="badge bg-<?= $priority_class ?>">
                                        <?= $notice->priority ?? 0 ?>
                                    </span>
                                </td>
                                <td>
                                    <?= date('M j, Y', strtotime($notice->created_at)) ?>
                                </td>
                                <td>
                                    <?php if ($notice->published): ?>
                                        <span class="badge bg-success">Published</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Draft</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-clipboard"></i>
                    <p>No notices yet</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card ops-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/admissions') ?>" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-user-graduate me-2"></i> Admissions
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/departments/create') ?>" class="btn btn-outline-secondary w-100 py-3">
                            <i class="fas fa-sitemap me-2"></i> Add Department
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/faculty/create') ?>" class="btn btn-outline-success w-100 py-3">
                            <i class="fas fa-user-plus me-2"></i> Add Faculty
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/programs/create') ?>" class="btn btn-outline-info w-100 py-3">
                            <i class="fas fa-graduation-cap me-2"></i> Add Program
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/events/create') ?>" class="btn btn-outline-warning w-100 py-3">
                            <i class="fas fa-calendar-plus me-2"></i> Add Event
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/notices/create') ?>" class="btn btn-outline-dark w-100 py-3">
                            <i class="fas fa-clipboard me-2"></i> Add Notice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
