<!-- Medical Operations Dashboard -->
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
    
    .quick-action-btn.blue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
    }
    
    .quick-action-btn.green {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: #fff;
    }
    
    .quick-action-btn.orange {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: #fff;
    }
    
    .quick-action-btn.purple {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: #fff;
    }
    
    .status-pill {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pill.new { background: #cce5ff; color: #004085; }
    .status-pill.read { background: #d4edda; color: #155724; }
    .status-pill.pending { background: #fff3cd; color: #856404; }
    .status-pill.accepted { background: #d4edda; color: #155724; }
    .status-pill.enrolled { background: #cce5ff; color: #004085; }
    .status-pill.rejected { background: #f8d7da; color: #721c24; }
    .status-pill.upcoming { background: #d1ecf1; color: #0c5460; }
    .status-pill.active { background: #d4edda; color: #155724; }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }
</style>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4 col-lg mb-3">
        <div class="stat-card-modern blue">
            <div class="stat-icon-wrapper">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-number"><?= isset($total_events) ? number_format($total_events) : '0' ?></div>
            <div class="stat-label">Total Events</div>
        </div>
    </div>
    
    <div class="col-md-4 col-lg mb-3">
        <div class="stat-card-modern orange">
            <div class="stat-icon-wrapper">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-number"><?= isset($unread_messages) ? number_format($unread_messages) : '0' ?></div>
            <div class="stat-label">Unread Messages</div>
        </div>
    </div>
    
    <div class="col-md-4 col-lg mb-3">
        <div class="stat-card-modern purple">
            <div class="stat-icon-wrapper">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-number"><?= isset($pending_appointments) ? number_format($pending_appointments) : '0' ?></div>
            <div class="stat-label">Pending Appointments</div>
        </div>
    </div>
    
    <div class="col-md-4 col-lg mb-3">
        <div class="stat-card-modern teal">
            <div class="stat-icon-wrapper">
                <i class="fas fa-user-md"></i>
            </div>
            <div class="stat-number"><?= isset($total_team_members) ? number_format($total_team_members) : '0' ?></div>
            <div class="stat-label">Team Members</div>
        </div>
    </div>
    
    <div class="col-md-4 col-lg mb-3">
        <div class="stat-card-modern green">
            <div class="stat-icon-wrapper">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number"><?= isset($total_users) ? number_format($total_users) : '0' ?></div>
            <div class="stat-label">Registered Users</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col">
        <a href="<?= base_url('admin/events/create') ?>" class="quick-action-btn blue">
            <i class="fas fa-calendar-plus"></i> Add Event
        </a>
        <a href="<?= base_url('admin/contacts') ?>" class="quick-action-btn orange">
            <i class="fas fa-envelope-open"></i> View Messages
        </a>
        <a href="<?= base_url('admin/appointments') ?>" class="quick-action-btn purple">
            <i class="fas fa-calendar-alt"></i> View Appointments
        </a>
    </div>
</div>

<div class="row">
    <!-- Upcoming Events -->
    <div class="col-lg-6 mb-4">
        <div class="table-card">
            <div class="card-header">
                <h5><i class="fas fa-calendar-alt"></i> Upcoming Events</h5>
            </div>
            <div class="card-body">
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
                                    <strong><?= htmlspecialchars($event->title) ?></strong>
                                    <?php if (!empty($event->location)): ?>
                                    <br><small class="text-muted"><?= htmlspecialchars($event->location) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('M d, Y', strtotime($event->start_date)) ?></td>
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
                    <i class="fas fa-calendar-times fa-3x mb-3"></i>
                    <p>No upcoming events scheduled.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Messages -->
    <div class="col-lg-6 mb-4">
        <div class="table-card">
            <div class="card-header">
                <h5><i class="fas fa-envelope"></i> Recent Messages</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_contacts)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_contacts as $contact): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($contact->customer_name ?? 'Unknown') ?></strong>
                                    <br><small class="text-muted"><?= htmlspecialchars($contact->customer_email ?? '') ?></small>
                                </td>
                                <td><?= htmlspecialchars(substr($contact->special_requests ?? $contact->message ?? '', 0, 30)) ?>...</td>
                                <td>
                                    <span class="status-pill <?= strtolower($contact->status ?? 'new') ?>">
                                        <?= ucfirst($contact->status ?? 'New') ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>No messages received yet.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Appointments -->
    <div class="col-lg-12">
        <div class="table-card">
            <div class="card-header">
                <h5><i class="fas fa-calendar-alt"></i> Recent Appointments</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_appointments)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Specialty</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_appointments as $appointment): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($appointment->patient_name ?? 'Unknown') ?></strong>
                                    <br><small class="text-muted"><?= htmlspecialchars($appointment->patient_email ?? '') ?></small>
                                </td>
                                <td><?= htmlspecialchars($appointment->medical_specialty ?? 'General') ?></td>
                                <td><?= !empty($appointment->preferred_date) ? date('M d, Y', strtotime($appointment->preferred_date)) : 'Not specified' ?></td>
                                <td>
                                    <span class="status-pill <?= strtolower($appointment->status ?? 'pending') ?>">
                                        <?= ucfirst($appointment->status ?? 'Pending') ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                    <p>No appointments yet.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
