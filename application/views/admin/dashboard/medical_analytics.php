<!-- Medical Analytics Dashboard -->
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
    
    .popular-page-item .page-url {
        font-size: 0.85rem;
        color: #667eea;
        text-decoration: none;
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .popular-page-item .page-url:hover {
        text-decoration: underline;
    }
    
    .popular-page-item .page-views {
        font-size: 0.9rem;
        font-weight: 600;
        color: #667eea;
        margin-left: 15px;
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
    
    .live-visitor .visitor-time {
        font-size: 0.75rem;
        color: #999;
        margin-left: auto;
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
        margin-right: 12px;
        font-size: 1.2rem;
    }
    
    .country-item .country-name {
        flex: 1;
        font-weight: 500;
    }
    
    .country-item .country-count {
        font-weight: 600;
        color: #667eea;
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
        background: linear-gradient(90deg, #667eea, #f5576c);
        border-radius: 3px;
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
    
    .table-card .card-body {
        padding: 0;
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
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }
    
    .line-chart-container {
        position: relative;
        height: 250px;
        padding: 10px 0;
    }
    
    .line-chart-container canvas {
        width: 100% !important;
        height: 100% !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<?php
function get_country_emoji($country) {
    $flags = [
        'Tanzania' => '🇹🇿',
        'Kenya' => '🇰🇪',
        'Uganda' => '🇺🇬',
        'Rwanda' => '🇷🇼',
        'Burundi' => '🇧🇮',
        'United States' => '🇺🇸',
        'United Kingdom' => '🇬🇧',
        'Germany' => '🇩🇪',
        'France' => '🇫🇷',
        'South Africa' => '🇿🇦',
        'India' => '🇮🇳',
        'China' => '🇨🇳',
        'Nigeria' => '🇳🇬',
        'Canada' => '🇨🇦',
        'Australia' => '🇦🇺',
        'Local' => '🏠',
    ];
    return isset($flags[$country]) ? $flags[$country] : '🌍';
}
?>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="stat-card-modern blue">
            <div class="stat-icon-wrapper">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number"><?= isset($visitor_stats['total_page_views']) ? number_format((int)$visitor_stats['total_page_views']) : '0' ?></div>
            <div class="stat-label">Total Visitors</div>
            <div class="stat-trend"><i class="fas fa-arrow-up"></i> All time</div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="stat-card-modern green">
            <div class="stat-icon-wrapper">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="stat-number"><?= isset($visitor_stats['this_week_views']) ? number_format((int)$visitor_stats['this_week_views']) : '0' ?></div>
            <div class="stat-label">This Week</div>
            <div class="stat-trend"><i class="fas fa-arrow-up"></i> Last 7 days</div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="stat-card-modern orange">
            <div class="stat-icon-wrapper">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-number"><?= isset($visitor_stats['today_views']) ? number_format((int)$visitor_stats['today_views']) : '0' ?></div>
            <div class="stat-label">Today</div>
            <div class="stat-trend"><i class="fas fa-clock"></i> Page views</div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="stat-card-modern purple">
            <div class="stat-icon-wrapper">
                <i class="fas fa-globe"></i>
            </div>
            <div class="stat-number"><?= isset($visitor_stats['total_unique_visitors']) ? number_format((int)$visitor_stats['total_unique_visitors']) : '0' ?></div>
            <div class="stat-label">Unique Visitors</div>
            <div class="stat-trend"><i class="fas fa-user"></i> All time</div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Weekly Visitors Chart -->
    <div class="col-lg-8 mb-4">
        <div class="table-card">
            <div class="card-header">
                <h5><i class="fas fa-chart-line"></i> Weekly Visitors</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($weekly_visitors) && is_array($weekly_visitors)): ?>
                <div class="line-chart-container">
                    <canvas id="weeklyVisitorsChart"></canvas>
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('weeklyVisitorsChart').getContext('2d');
                    
                    const labels = <?php 
                        $labels = [];
                        foreach ($weekly_visitors as $day) {
                            $labels[] = isset($day->date) ? date('D', strtotime($day->date)) : 'N/A';
                        }
                        echo json_encode($labels);
                    ?>;
                    
                    const pageViews = <?php 
                        $counts = [];
                        foreach ($weekly_visitors as $day) {
                            $counts[] = isset($day->page_views) ? (int)$day->page_views : 0;
                        }
                        echo json_encode($counts);
                    ?>;
                    
                    const uniqueVisitors = <?php 
                        $counts = [];
                        foreach ($weekly_visitors as $day) {
                            $counts[] = isset($day->unique_visitors) ? (int)$day->unique_visitors : 0;
                        }
                        echo json_encode($counts);
                    ?>;
                    
                    const allValues = [...pageViews, ...uniqueVisitors];
                    const maxData = allValues.length > 0 ? Math.max(...allValues, 1) : 1;
                    
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Page Views',
                                    data: pageViews,
                                    borderColor: '#667eea',
                                    backgroundColor: 'rgba(102, 126, 234, 0.15)',
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#667eea',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 5,
                                    pointHoverRadius: 7
                                },
                                {
                                    label: 'Unique Visitors',
                                    data: uniqueVisitors,
                                    borderColor: '#38ef7d',
                                    backgroundColor: 'rgba(56, 239, 125, 0.1)',
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#38ef7d',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 5,
                                    pointHoverRadius: 7
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    labels: {
                                        color: '#666',
                                        usePointStyle: true,
                                        padding: 20,
                                        font: { size: 13 }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0,0,0,0.8)',
                                    padding: 12,
                                    titleFont: { size: 14 },
                                    bodyFont: { size: 13 },
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': ' + context.parsed.y;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#888',
                                        font: { size: 12 }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.05)'
                                    },
                                    ticks: {
                                        color: '#888',
                                        font: { size: 12 },
                                        stepSize: Math.ceil(maxData / 5) || 1
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            }
                        }
                    });
                });
                </script>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-chart-line fa-3x mb-3"></i>
                    <p>No visitor data available</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Device Statistics -->
    <div class="col-lg-4 mb-4">
        <div class="table-card">
            <div class="card-header">
                <h5><i class="fas fa-mobile-alt"></i> Devices</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($device_stats) && is_array($device_stats)): ?>
                <?php 
                $total_devices = array_sum($device_stats);
                foreach ($device_stats as $device_name => $cnt):
                    $percent = $total_devices > 0 ? round(($cnt / $total_devices) * 100) : 0;
                    $dev_name = ucfirst(strtolower($device_name));
                    $dev_icon = '';
                    if (stripos($dev_name, 'desktop') !== false) $dev_icon = 'fa-desktop';
                    elseif (stripos($dev_name, 'mobile') !== false) $dev_icon = 'fa-mobile-alt';
                    else $dev_icon = 'fa-tablet-alt';
                ?>
                <div class="device-stat">
                    <div class="icon <?= strtolower($dev_name) ?>">
                        <i class="fas <?= $dev_icon ?>"></i>
                    </div>
                    <div class="info">
                        <div class="label"><?= $dev_name ?></div>
                        <div class="count"><?= number_format($cnt) ?> visitors</div>
                    </div>
                    <div class="percentage"><?= $percent ?>%</div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-mobile-alt fa-3x mb-3"></i>
                    <p>No device data</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Popular Pages -->
    <div class="col-lg-6 mb-4">
        <div class="table-card">
            <div class="card-header">
                <h5><i class="fas fa-fire"></i> Popular Pages</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($popular_pages)): ?>
                <?php foreach ($popular_pages as $page): ?>
                <div class="popular-page-item">
                    <a href="<?= base_url(isset($page->page_url) ? $page->page_url : '#') ?>" class="page-url" title="<?= htmlspecialchars(isset($page->page_url) ? $page->page_url : '') ?>">
                        <?= htmlspecialchars(isset($page->page_url) ? $page->page_url : 'N/A') ?>
                    </a>
                    <span class="page-views"><?= number_format(isset($page->view_count) ? (int)$page->view_count : 0) ?></span>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-fire fa-3x mb-3"></i>
                    <p>No page data</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Visitors -->
    <div class="col-lg-6 mb-4">
        <div class="table-card">
            <div class="card-header">
                <h5><i class="fas fa-clock"></i> Recent Visitors</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_visitors)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>IP Address</th>
                                <th>Page</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_visitors as $visitor): ?>
                            <tr>
                                <td><code><?= htmlspecialchars($visitor->ip_address) ?></code></td>
                                <td>
                                    <a href="<?= base_url(isset($visitor->page_url) ? $visitor->page_url : '#') ?>" class="page-url" title="<?= htmlspecialchars(isset($visitor->page_url) ? $visitor->page_url : '') ?>">
                                        <?= isset($visitor->page_url) ? htmlspecialchars(substr($visitor->page_url, 0, 20)) . '...' : 'N/A' ?>
                                    </a>
                                </td>
                                <td><span class="visitor-time"><?= isset($visitor->visited_at) ? date('H:i', strtotime($visitor->visited_at)) : '' ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-clock fa-3x mb-3"></i>
                    <p>No recent visitors</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Browser Stats -->
    <div class="col-lg-6 mb-4">
        <div class="table-card">
            <div class="card-header">
                <h5><i class="fas fa-globe"></i> Browsers</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($browser_stats) && is_array($browser_stats)): ?>
                <?php 
                $browser_counts = [];
                $total_browsers = 0;
                if (!empty($browser_stats)) {
                    foreach ($browser_stats as $b) {
                        $cnt = isset($b->count) ? (int)$b->count : 0;
                        $browser_counts[] = $cnt;
                        $total_browsers += $cnt;
                    }
                }
                foreach ($browser_stats as $browser): 
                    $cnt = isset($browser->count) ? (int)$browser->count : 0;
                    $percent = $total_browsers > 0 ? round(($cnt / $total_browsers) * 100) : 0;
                ?>
                <div class="device-stat">
                    <div class="info">
                        <div class="label"><?= htmlspecialchars(isset($browser->browser) ? $browser->browser : 'Unknown') ?></div>
                        <div class="country-bar">
                            <div class="fill" style="width: <?= $percent ?>%;"></div>
                        </div>
                    </div>
                    <div class="percentage"><?= $percent ?>%</div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-globe fa-3x mb-3"></i>
                    <p>No browser data</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Top Countries -->
    <div class="col-lg-6 mb-4">
        <div class="table-card">
            <div class="card-header">
                <h5><i class="fas fa-globe-americas"></i> Top Countries</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($country_stats)): ?>
                <?php foreach ($country_stats as $country): ?>
                <div class="country-item">
                    <span class="flag"><?= get_country_emoji(isset($country->country) ? $country->country : 'Unknown') ?></span>
                    <span class="country-name"><?= htmlspecialchars(isset($country->country) ? $country->country : 'Unknown') ?></span>
                    <span class="country-count"><?= number_format(isset($country->count) ? (int)$country->count : 0) ?></span>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-globe-americas fa-3x mb-3"></i>
                    <p>No country data</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
