<!-- Dashboard Content -->
<style>
    .dashboard-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .dashboard-card:hover {
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
    
    .stat-card-modern.pink {
        background: linear-gradient(135deg, #e91e63 0%, #9c27b0 100%);
    }
    
    .visitor-chart-container {
        position: relative;
        height: 250px;
    }
    
    .device-stat {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .device-stat:last-child {
        border-bottom: none;
    }
    
    .device-stat .icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .device-stat .icon.desktop { background: rgba(102, 126, 234, 0.15); color: #667eea; }
    .device-stat .icon.mobile { background: rgba(17, 153, 142, 0.15); color: #11998e; }
    .device-stat .icon.tablet { background: rgba(240, 147, 251, 0.15); color: #f093fb; }
    
    .device-stat .info { flex: 1; }
    .device-stat .info .label { font-weight: 500; color: #333; }
    .device-stat .info .count { font-size: 0.85rem; color: #888; }
    
    .device-stat .percentage {
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .popular-page-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .popular-page-item:last-child {
        border-bottom: none;
    }
    
    .popular-page-item .rank {
        width: 28px;
        height: 28px;
        background: var(--accent-color);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
        margin-right: 12px;
    }
    
    .popular-page-item .page-info {
        flex: 1;
        min-width: 0;
    }
    
    .popular-page-item .page-url {
        font-size: 0.85rem;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .popular-page-item .page-views {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--accent-color);
    }
    
    .live-visitor {
        display: flex;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.85rem;
    }
    
    .live-visitor:last-child {
        border-bottom: none;
    }
    
    .live-visitor .device-icon {
        width: 30px;
        color: #888;
    }
    
    .live-visitor .visitor-info {
        flex: 1;
    }
    
    .live-visitor .visitor-time {
        font-size: 0.75rem;
        color: #999;
    }
    
    .country-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .country-item:last-child {
        border-bottom: none;
    }
    
    .country-item .flag {
        width: 28px;
        height: 20px;
        margin-right: 12px;
        border-radius: 3px;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }
    
    .country-item .country-name {
        flex: 1;
        font-weight: 500;
    }
    
    .country-item .country-count {
        font-weight: 600;
        color: var(--accent-color);
    }
    
    .country-bar {
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
        margin-top: 5px;
        overflow: hidden;
    }
    
    .country-bar .fill {
        height: 100%;
        background: linear-gradient(90deg, var(--accent-color), #f5576c);
        border-radius: 3px;
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
        background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
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
        background: rgba(230, 126, 34, 0.1);
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
    
    .quick-action-btn {
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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
    .status-pill.confirmed { background: #d4edda; color: #155724; }
    .status-pill.new { background: #cce5ff; color: #004085; }
    .status-pill.contacted { background: #d1ecf1; color: #0c5460; }
    .status-pill.completed { background: #d4edda; color: #155724; }
    .status-pill.cancelled { background: #f8d7da; color: #721c24; }
    .status-pill.quoted { background: #e2e3e5; color: #383d41; }
    
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
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Analytics Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item active">Analytics</li>
            </ol>
        </nav>
    </div>
    <div>
        <span class="text-muted"><i class="fas fa-clock me-1"></i> <?= date('l, F j, Y') ?></span>
    </div>
</div>

<!-- Dashboard Tabs -->
<style>
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
</style>
<div class="dashboard-tabs">
    <a href="<?= base_url('admin/dashboard/operations') ?>" class="tab-btn">
        <i class="fas fa-briefcase"></i> Operations
    </a>
    <a href="<?= base_url('admin/dashboard/analytics') ?>" class="tab-btn active">
        <i class="fas fa-chart-line"></i> Analytics
    </a>
</div>

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2>Welcome to Soft Panel, <?= isset($admin_name) ? htmlspecialchars($admin_name) : 'Administrator' ?>!</h2>
            <p>Manage your college's academic operations and communications.</p>
        </div>
        <!-- <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="<= base_url('admin/faculty/create') ?>" class="quick-action-btn btn btn-warning text-white">
                <i class="fas fa-plus"></i> Add Faculty
            </a>
        </div> -->
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-modern blue dashboard-card">
            <div class="stat-icon-wrapper">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stat-number"><?= number_format($total_packages) ?></div>
            <div class="stat-label">Academic Programs</div>
            <div class="stat-trend">
                <i class="fas fa-list"></i> Active programs
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-modern green dashboard-card">
            <div class="stat-icon-wrapper">
                <i class="fas fa-chalkboard-user"></i>
            </div>
            <div class="stat-number"><?= number_format($total_blog_posts) ?></div>
            <div class="stat-label">Faculty & Staff</div>
            <div class="stat-trend">
                <i class="fas fa-users"></i> Total members
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-modern orange dashboard-card">
            <div class="stat-icon-wrapper">
                <i class="fas fa-calendar-days"></i>
            </div>
            <div class="stat-number"><?= number_format($total_bookings) ?></div>
            <div class="stat-label">Upcoming Events</div>
            <div class="stat-trend">
                <?php if (isset($pending_bookings) && $pending_bookings > 0): ?>
                    <i class="fas fa-exclamation-circle"></i> <?= $pending_bookings ?> pending
                <?php else: ?>
                    <i class="fas fa-check-circle"></i> All scheduled
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-modern purple dashboard-card">
            <div class="stat-icon-wrapper">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-number"><?= number_format($total_enquiries) ?></div>
            <div class="stat-label">Messages</div>
            <div class="stat-trend">
                <?php if (isset($new_enquiries) && $new_enquiries > 0): ?>
                    <i class="fas fa-bell"></i> <?= $new_enquiries ?> unread
                <?php else: ?>
                    <i class="fas fa-check-circle"></i> All read
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Visitor Stats Cards -->
<?php if (isset($visitor_stats)): ?>
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-modern teal dashboard-card">
            <div class="stat-icon-wrapper">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-number"><?= number_format($visitor_stats['today_views']) ?></div>
            <div class="stat-label">Today's Page Views</div>
            <div class="stat-trend">
                <i class="fas fa-users"></i> <?= number_format($visitor_stats['today_unique']) ?> unique visitors
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-modern pink dashboard-card">
            <div class="stat-icon-wrapper">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-number"><?= number_format($visitor_stats['this_week_views']) ?></div>
            <div class="stat-label">This Week</div>
            <div class="stat-trend">
                <i class="fas fa-calendar-week"></i> Last 7 days
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-body text-center py-4">
                <i class="fas fa-chart-line text-info mb-2" style="font-size: 2rem;"></i>
                <h3 class="mb-1"><?= number_format($visitor_stats['this_month_views']) ?></h3>
                <p class="text-muted mb-0">This Month</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-body text-center py-4">
                <i class="fas fa-globe text-success mb-2" style="font-size: 2rem;"></i>
                <h3 class="mb-1"><?= number_format($visitor_stats['total_page_views']) ?></h3>
                <p class="text-muted mb-0">All Time Views</p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Visitor Analytics Row -->
<?php if (isset($weekly_visitors) || isset($device_stats)): ?>
<div class="row mb-4">
    <!-- Weekly Visitors Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-area text-primary me-2"></i>Visitor Trends (Last 7 Days)</h5>
            </div>
            <div class="card-body">
                <div class="visitor-chart-container">
                    <canvas id="visitorChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Device Breakdown -->
    <div class="col-lg-4 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-mobile-alt text-info me-2"></i>Device Breakdown</h5>
            </div>
            <div class="card-body">
                <?php 
                $total_devices = ($device_stats['desktop'] ?? 0) + ($device_stats['mobile'] ?? 0) + ($device_stats['tablet'] ?? 0);
                $desktop_pct = $total_devices > 0 ? round(($device_stats['desktop'] / $total_devices) * 100) : 0;
                $mobile_pct = $total_devices > 0 ? round(($device_stats['mobile'] / $total_devices) * 100) : 0;
                $tablet_pct = $total_devices > 0 ? round(($device_stats['tablet'] / $total_devices) * 100) : 0;
                ?>
                <div class="device-stat">
                    <div class="icon desktop"><i class="fas fa-desktop"></i></div>
                    <div class="info">
                        <div class="label">Desktop</div>
                        <div class="count"><?= number_format($device_stats['desktop'] ?? 0) ?> visits</div>
                    </div>
                    <div class="percentage"><?= $desktop_pct ?>%</div>
                </div>
                <div class="device-stat">
                    <div class="icon mobile"><i class="fas fa-mobile-alt"></i></div>
                    <div class="info">
                        <div class="label">Mobile</div>
                        <div class="count"><?= number_format($device_stats['mobile'] ?? 0) ?> visits</div>
                    </div>
                    <div class="percentage"><?= $mobile_pct ?>%</div>
                </div>
                <div class="device-stat">
                    <div class="icon tablet"><i class="fas fa-tablet-alt"></i></div>
                    <div class="info">
                        <div class="label">Tablet</div>
                        <div class="count"><?= number_format($device_stats['tablet'] ?? 0) ?> visits</div>
                    </div>
                    <div class="percentage"><?= $tablet_pct ?>%</div>
                </div>
                
                <?php if (isset($browser_stats) && !empty($browser_stats)): ?>
                <hr class="my-3">
                <h6 class="text-muted mb-3"><i class="fas fa-globe me-2"></i>Top Browsers</h6>
                <?php foreach ($browser_stats as $browser): ?>
                <div class="d-flex justify-content-between mb-2">
                    <span><?= htmlspecialchars($browser->browser) ?></span>
                    <span class="text-muted"><?= number_format($browser->count) ?></span>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Country Stats Row -->
<?php if (isset($country_stats) && !empty($country_stats)): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card dashboard-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-globe-americas text-primary me-2"></i>Visitors by Country (Last 30 Days)</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php 
                    $max_count = !empty($country_stats) ? $country_stats[0]->count : 1;
                    $chunks = array_chunk($country_stats, ceil(count($country_stats) / 2));
                    ?>
                    <?php foreach ($chunks as $chunk): ?>
                    <div class="col-md-6">
                        <?php foreach ($chunk as $country): 
                            $percentage = ($country->count / $max_count) * 100;
                        ?>
                        <div class="country-item">
                            <div class="flag">🌍</div>
                            <div class="country-name">
                                <?= htmlspecialchars($country->country) ?>
                                <div class="country-bar">
                                    <div class="fill" style="width: <?= $percentage ?>%"></div>
                                </div>
                            </div>
                            <div class="country-count"><?= number_format($country->count) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<!-- Popular Pages & Recent Visitors -->
<?php if (isset($popular_pages) || isset($recent_visitors)): ?>
<div class="row mb-4">
    <!-- Popular Pages -->
    <div class="col-lg-6 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-fire text-danger me-2"></i>Popular Pages</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($popular_pages)): ?>
                    <?php $rank = 1; foreach ($popular_pages as $page): ?>
                    <div class="popular-page-item">
                        <div class="rank"><?= $rank++ ?></div>
                        <div class="page-info">
                            <div class="page-url" title="<?= htmlspecialchars($page->page_url) ?>">
                                <?= htmlspecialchars(str_replace(base_url(), '/', $page->page_url)) ?>
                            </div>
                        </div>
                        <div class="page-views"><?= number_format($page->view_count) ?></div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state py-4">
                        <i class="fas fa-chart-bar"></i>
                        <p>No page data yet</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Visitors -->
    <div class="col-lg-6 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users text-success me-2"></i>Recent Visitors</h5>
            </div>
            <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                <?php if (!empty($recent_visitors)): ?>
                    <?php foreach ($recent_visitors as $visitor): ?>
                    <div class="live-visitor">
                        <div class="device-icon">
                            <?php if ($visitor->device_type == 'mobile'): ?>
                                <i class="fas fa-mobile-alt"></i>
                            <?php elseif ($visitor->device_type == 'tablet'): ?>
                                <i class="fas fa-tablet-alt"></i>
                            <?php else: ?>
                                <i class="fas fa-desktop"></i>
                            <?php endif; ?>
                        </div>
                        <div class="visitor-info">
                            <div class="text-truncate" style="max-width: 250px;" title="<?= htmlspecialchars($visitor->page_url) ?>">
                                <?= htmlspecialchars(str_replace(base_url(), '/', $visitor->page_url)) ?>
                            </div>
                            <small class="text-muted"><?= $visitor->browser ?> / <?= $visitor->os ?></small>
                        </div>
                        <div class="visitor-time">
                            <?= date('H:i', strtotime($visitor->visited_at)) ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state py-4">
                        <i class="fas fa-user-clock"></i>
                        <p>No visitors recorded yet</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Quick Stats Row -->
<?php if (isset($booking_stats) || isset($enquiry_stats)): ?>
<div class="row mb-4">
    <?php if (isset($booking_stats) && $booking_stats->total_revenue > 0): ?>
    <div class="col-md-4 mb-3">
        <div class="card dashboard-card h-100">
            <div class="card-body text-center">
                <i class="fas fa-dollar-sign text-success mb-2" style="font-size: 2rem;"></i>
                <h3 class="mb-1">$<?= number_format($booking_stats->total_revenue, 2) ?></h3>
                <p class="text-muted mb-0">Total Revenue</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (isset($enquiry_stats)): ?>
    <div class="col-md-4 mb-3">
        <div class="card dashboard-card h-100">
            <div class="card-body text-center">
                <i class="fas fa-chart-line text-primary mb-2" style="font-size: 2rem;"></i>
                <h3 class="mb-1"><?= $enquiry_stats->conversion_rate ?>%</h3>
                <p class="text-muted mb-0">Conversion Rate</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card dashboard-card h-100">
            <div class="card-body text-center">
                <i class="fas fa-calendar-alt text-info mb-2" style="font-size: 2rem;"></i>
                <h3 class="mb-1"><?= $enquiry_stats->this_month ?></h3>
                <p class="text-muted mb-0">This Month's Enquiries</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Tables Row -->
<div class="row">
    <!-- Upcoming Events -->
    <div class="col-lg-6 mb-4">
        <div class="card table-card dashboard-card">
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
                                <th>Event Title</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($upcoming_events as $event): ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url('admin/events/edit/' . $event->id) ?>" class="fw-bold text-decoration-none">
                                        <?= htmlspecialchars($event->title) ?>
                                    </a>
                                </td>
                                <td>
                                    <span title="<?= isset($event->start_time) ? date('F j, Y g:i A', strtotime($event->start_date . ' ' . $event->start_time)) : date('F j, Y', strtotime($event->start_date)) ?>">
                                        <?= date('M j, Y', strtotime($event->start_date)) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 150px;" title="<?= htmlspecialchars($event->location ?? '') ?>">
                                        <?= htmlspecialchars($event->location ?? 'N/A') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-pill <?= strtolower($event->status ?? 'upcoming') ?>">
                                        <?= ucfirst($event->status ?? 'Upcoming') ?>
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
    
    <!-- Recent Messages -->
    <div class="col-lg-6 mb-4">
        <div class="card table-card dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-envelope"></i> Recent Messages</h5>
                <a href="<?= base_url('admin/enquiries') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($recent_enquiries)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Customer</th>
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

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card dashboard-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/departments/create') ?>" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-sitemap me-2"></i> Add Department
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/faculty/create') ?>" class="btn btn-outline-success w-100 py-3">
                            <i class="fas fa-user-plus me-2"></i> Add Faculty
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/admissions') ?>" class="btn btn-outline-danger w-100 py-3">
                            <i class="fas fa-user-graduate me-2"></i> Admissions
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/blog/create') ?>" class="btn btn-outline-dark w-100 py-3">
                            <i class="fas fa-pen me-2"></i> Blog Post
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/events') ?>" class="btn btn-outline-info w-100 py-3">
                            <i class="fas fa-calendar me-2"></i> Events
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/notices/create') ?>" class="btn btn-outline-secondary w-100 py-3">
                            <i class="fas fa-clipboard me-2"></i> Notice
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <a href="<?= base_url('admin/bulk-notifications') ?>" class="btn btn-outline-warning w-100 py-3">
                            <i class="fas fa-bell me-2"></i> Notify All
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js for Visitor Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('visitorChart');
    if (ctx) {
        <?php
        // Prepare chart data
        $labels = [];
        $pageViews = [];
        $uniqueVisitors = [];
        
        if (isset($weekly_visitors) && !empty($weekly_visitors)) {
            foreach ($weekly_visitors as $day) {
                $labels[] = date('D', strtotime($day->date));
                $pageViews[] = (int)$day->page_views;
                $uniqueVisitors[] = (int)$day->unique_visitors;
            }
        } else {
            // Default empty data for 7 days
            for ($i = 6; $i >= 0; $i--) {
                $labels[] = date('D', strtotime("-$i days"));
                $pageViews[] = 0;
                $uniqueVisitors[] = 0;
            }
        }
        ?>
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Page Views',
                    data: <?= json_encode($pageViews) ?>,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }, {
                    label: 'Unique Visitors',
                    data: <?= json_encode($uniqueVisitors) ?>,
                    borderColor: '#11998e',
                    backgroundColor: 'rgba(17, 153, 142, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#11998e',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
});
</script>
