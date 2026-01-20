<style>
    .dashboard-page {
        padding:0 60px 120px ;
        background: #f8fafc;
        min-height: calc(100vh - 200px);
    }

    .dashboard-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 20px;
    }

    .dashboard-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--theme-accent, #175cdd);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: 700;
    }

    .user-info h2 {
        margin: 0 0 5px;
        color: var(--theme-primary);
        font-size: 1.5rem;
    }

    .user-info p {
        margin: 0;
        color: #64748b;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        background: #e0f2fe;
        color: #0369a1;
    }

    .dashboard-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .dashboard-menu li {
        margin-bottom: 10px;
    }

    .dashboard-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px 20px;
        background: #f8fafc;
        border-radius: 10px;
        color: #334155;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .dashboard-menu a:hover {
        background: var(--theme-accent, #175cdd);
        color: white;
        transform: translateX(5px);
    }

    .dashboard-menu a i {
        font-size: 1.2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--theme-primary) 0%, var(--theme-accent) 100%);
        border-radius: 12px;
        padding: 25px;
        color: white;
        text-align: center;
    }

    .stat-card i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        opacity: 0.9;
    }

    .stat-card h3 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .stat-card p {
        margin: 10px 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="dashboard-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="dashboard-card">
                    <div class="dashboard-header">
                        <div class="user-avatar">
                            <?= strtoupper(substr($user_name, 0, 1)) ?>
                        </div>
                        <div class="user-info">
                            <h2><?= htmlspecialchars($user_name) ?></h2>
                            <p>Welcome back!</p>
                            <span class="badge">User</span>
                        </div>
                    </div>
                    
                    <ul class="dashboard-menu">
                        <li>
                            <a href="<?= base_url('users/dashboard') ?>">
                                <i class="bi bi-house-door"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="bi bi-person"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('users/logout') ?>">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="dashboard-card">
                    <h3 style="margin-bottom: 25px; color: var(--theme-primary);">Dashboard Overview</h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="stat-card">
                                <i class="bi bi-calendar-check"></i>
                                <h3>0</h3>
                                <p>Active Bookings</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                <i class="bi bi-file-text"></i>
                                <h3>0</h3>
                                <p>Enquiries</p>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 30px; padding: 20px; background: #f8fafc; border-radius: 10px;">
                        <h4 style="margin-bottom: 15px; color: var(--theme-primary);">Recent Activity</h4>
                        <p style="color: #64748b; margin: 0;">No recent activity found.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
