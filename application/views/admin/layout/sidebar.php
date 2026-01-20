<!-- Admin Sidebar -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <?php if (isset($site_logo) && $site_logo): ?>
            <img src="<?= base_url('assets/images/' . $site_logo) ?>" alt="Logo">
        <?php else: ?>
            <h4><span>Soft</span> Panel</h4>
        <?php endif; ?>
    </div>
    
    <ul class="sidebar-menu">
        <?php
            // Get the admin menu from template configuration
            $admin_menu = get_admin_menu();
            
            // Prepare badge counts
            $badges = [
                'unread_contacts' => isset($unread_contacts) ? $unread_contacts : 0,
                'booking_count' => isset($booking_count) ? $booking_count : 0,
                'notification_count' => isset($notification_count) ? $notification_count : 0
            ];
            
            // Render the menu from JSON configuration
            echo render_admin_menu($admin_menu, $this, $badges);
        ?>
    </ul>
</aside>

<!-- Main Content Wrapper -->
<main class="admin-main">
    <!-- Top Header -->
    <header class="admin-header">
        <div class="header-left">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="header-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search faculty, events, programs..." id="adminSearch" autocomplete="off">
                <div class="search-results" id="searchResults"></div>
            </div>
        </div>
        
        <div class="header-right">
            <a href="<?= base_url() ?>" target="_blank" class="header-icon" title="Visit Website">
                <i class="fas fa-globe"></i>
            </a>
            
            <div class="header-icon" title="Notifications">
                <i class="fas fa-bell"></i>
                <?php if (isset($notification_count) && $notification_count > 0): ?>
                    <span class="badge"><?= $notification_count ?></span>
                <?php endif; ?>
            </div>
            
            <a href="<?= base_url('admin/contacts') ?>" class="header-icon" title="Messages">
                <i class="fas fa-envelope"></i>
                <?php if (isset($unread_contacts) && $unread_contacts > 0): ?>
                    <span class="badge"><?= $unread_contacts ?></span>
                <?php endif; ?>
            </a>
            
            <div class="dropdown">
                <div class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-info">
                        <div class="user-name"><?= isset($admin_name) ? $admin_name : 'Administrator' ?></div>
                        <div class="user-role"><?= isset($admin_role) ? $admin_role : 'Super Admin' ?></div>
                    </div>
                    <?php
                        $admin_name_display = isset($admin_name) ? $admin_name : 'Admin';
                        $avatar_src = 'https://ui-avatars.com/api/?name=' . urlencode($admin_name_display) . '&background=e67e22&color=fff';
                        
                        if (isset($admin_avatar) && !empty($admin_avatar)) {
                            // admin_avatar already contains the full relative path (e.g., assets/images/avatars/filename.jpg)
                            $avatar_file = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $admin_avatar);
                            if (file_exists($avatar_file)) {
                                $avatar_src = base_url($admin_avatar);
                            }
                        }
                    ?>
                    <img src="<?= $avatar_src ?>" alt="Admin" class="avatar-image">
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?= base_url('admin/profile') ?>"><i class="fas fa-user me-2"></i> My Profile</a></li>
                    <?php 
                    $is_super_admin = (isset($admin_role) && $admin_role === 'super_admin') || 
                                      (isset($user_role) && $user_role === 'super_admin');
                    if ($is_super_admin): ?>
                    <li><a class="dropdown-item" href="<?= base_url('admin/settings') ?>"><i class="fas fa-cog me-2"></i> Settings</a></li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('admin/auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>
    
    <!-- Content Area -->
    <div class="admin-content">
