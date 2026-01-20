<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>Soft Panel</title>
    <!-- CSRF Token -->
    <meta name="<?= $this->security->get_csrf_token_name() ?>" content="<?= $this->security->get_csrf_hash() ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --primary-dark: #1a252f;
            --accent-color: #e67e22;
            --accent-hover: #d35400;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #3498db;
            --sidebar-width: 260px;
            --header-height: 60px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }
        
        .admin-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        
        .admin-sidebar::-webkit-scrollbar-track {
            background: var(--primary-dark);
        }
        
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: var(--accent-color);
            border-radius: 5px;
        }
        
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand img {
            max-width: 150px;
            height: auto;
        }
        
        .sidebar-brand h4 {
            color: #fff;
            margin: 10px 0 0;
            font-weight: 600;
        }
        
        .sidebar-brand span {
            color: var(--accent-color);
        }
        
        .sidebar-menu {
            padding: 15px 0;
            list-style: none;
        }
        
        .sidebar-menu li {
            margin: 2px 0;
        }
        
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-left-color: var(--accent-color);
        }
        
        .sidebar-menu li a.active {
            background: rgba(230, 126, 34, 0.2);
        }
        
        .sidebar-menu li a i {
            width: 20px;
            margin-right: 12px;
            font-size: 1rem;
        }
        
        /* Submenu Styling */
        .sidebar-menu .submenu {
            list-style: none;
            padding: 0;
            margin: 5px 0;
            background: rgba(0,0,0,0.1);
            border-left: 2px solid rgba(230, 126, 34, 0.3);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .sidebar-menu li.expanded > .submenu {
            max-height: 500px;
        }
        
        .sidebar-menu li:hover > .submenu {
            max-height: 500px;
        }
        
        .submenu-toggle {
            display: inline-flex;
            margin-left: auto;
            transition: transform 0.3s ease;
            font-size: 0.75rem;
        }
        
        .sidebar-menu li.expanded .submenu-toggle {
            transform: rotate(180deg);
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .sidebar-menu .submenu li {
            margin: 0;
        }
        
        .sidebar-menu .submenu li a {
            padding: 10px 20px 10px 45px;
            border-left: 3px solid transparent;
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
            position: relative;
        }
        
        .sidebar-menu .submenu li a:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-left-color: var(--accent-color);
        }
        
        .sidebar-menu .submenu li a.active {
            background: rgba(230, 126, 34, 0.15);
            color: #fff;
            border-left-color: var(--accent-color);
        }
        
        .sidebar-menu .submenu li a i {
            width: auto;
            margin-right: 8px;
            font-size: 0.85rem;
        }
        
        .sidebar-menu .menu-header {
            padding: 15px 20px 10px;
            color: rgba(255,255,255,0.4);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        /* Sidebar Section Headers (from admin_menu.json) */
        .sidebar-section-header {
            padding: 15px 20px 8px;
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            margin-top: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
        }
        
        .sidebar-section-header::before {
            content: '';
            position: absolute;
            left: 20px;
            bottom: -1px;
            width: 30px;
            height: 2px;
            background: var(--accent-color);
        }
        
        .sidebar-section-header:first-of-type {
            margin-top: 0;
        }
        
        /* Main Content Area */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Top Header */
        .admin-header {
            position: sticky;
            top: 0;
            height: var(--header-height);
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            z-index: 999;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--primary-color);
            cursor: pointer;
            padding: 5px;
            display: none;
        }
        
        .header-search {
            position: relative;
        }
        
        .header-search input {
            width: 300px;
            padding: 8px 15px 8px 40px;
            border: 1px solid #e0e0e0;
            border-radius: 25px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .header-search input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
        }
        
        .header-search i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #999;
            z-index: 1;
        }
        
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
            margin-top: 5px;
            max-height: 400px;
            overflow-y: auto;
            display: none;
            z-index: 1000;
        }
        
        .search-results.show {
            display: block;
        }
        
        .search-results .search-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            text-decoration: none;
            color: var(--primary-color);
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }
        
        .search-results .search-item:hover {
            background: #f8f9fa;
        }
        
        .search-results .search-item:last-child {
            border-bottom: none;
        }
        
        .search-results .search-item i {
            position: static;
            transform: none;
            width: 32px;
            height: 32px;
            background: rgba(230, 126, 34, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color);
            font-size: 0.9rem;
        }
        
        .search-results .search-item .search-info {
            flex: 1;
        }
        
        .search-results .search-item .search-title {
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .search-results .search-item .search-category {
            font-size: 0.75rem;
            color: #888;
        }
        
        .search-results .no-results {
            padding: 20px;
            text-align: center;
            color: #888;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .header-icon {
            position: relative;
            color: var(--primary-color);
            font-size: 1.1rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .header-icon:hover {
            background: #f4f6f9;
        }
        
        .header-icon .badge {
            position: absolute;
            top: 0;
            right: 0;
            width: 18px;
            height: 18px;
            background: var(--danger-color);
            color: #fff;
            font-size: 0.65rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .user-dropdown:hover {
            background: #f4f6f9;
        }
        
        .user-dropdown img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .user-dropdown .user-info {
            text-align: right;
        }
        
        .user-dropdown .user-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.9rem;
        }
        
        .user-dropdown .user-role {
            font-size: 0.75rem;
            color: #999;
        }
        
        /* Role Badge Styling */
        .role-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 5px;
        }
        
        .role-badge.super-admin {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: #fff;
        }
        
        .role-badge.admin {
            background: linear-gradient(135deg, #e67e22, #d35400);
            color: #fff;
        }
        
        .role-badge.editor {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: #fff;
        }
        
        .role-badge.staff {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
            color: #fff;
        }
        
        .role-badge.user {
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
            color: #fff;
        }
        
        /* Menu Item Role Indicator */
        .sidebar-menu li a .role-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-left: auto;
            margin-right: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 0 0 2px rgba(255,255,255,0.2);
        }
        
        .sidebar-menu li a:hover .role-indicator,
        .sidebar-menu li a.active .role-indicator {
            box-shadow: 0 0 6px rgba(255,255,255,0.5);
            transform: scale(1.2);
        }
        
        .sidebar-menu li a.level-super-admin .role-indicator {
            background-color: #e74c3c;
            box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.3);
        }
        
        .sidebar-menu li a.level-admin .role-indicator {
            background-color: #e67e22;
            box-shadow: 0 0 0 2px rgba(230, 126, 34, 0.3);
        }
        
        .sidebar-menu li a.level-editor .role-indicator {
            background-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.3);
        }
        
        .sidebar-menu li a.level-staff .role-indicator {
            background-color: #9b59b6;
            box-shadow: 0 0 0 2px rgba(155, 89, 182, 0.3);
        }
        
        .sidebar-menu li a.level-user .role-indicator {
            background-color: #95a5a6;
            box-shadow: 0 0 0 2px rgba(149, 165, 166, 0.3);
        }
        
        /* Menu Item Hierarchy Levels */
        .menu-hierarchy-label {
            font-size: 0.65rem;
            padding: 2px 6px;
            border-radius: 3px;
            margin-right: 8px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .menu-hierarchy-label.critical {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }
        
        .menu-hierarchy-label.high {
            background: rgba(230, 126, 34, 0.15);
            color: #e67e22;
        }
        
        .menu-hierarchy-label.medium {
            background: rgba(52, 152, 219, 0.15);
            color: #3498db;
        }
        
        .menu-hierarchy-label.low {
            background: rgba(155, 89, 182, 0.15);
            color: #9b59b6;
        }
        
        /* Content Area */
        .admin-content {
            padding: 25px;
        }
        
        /* Page Header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }
        
        .breadcrumb {
            background: none;
            padding: 0;
            margin: 5px 0 0;
        }
        
        .breadcrumb-item a {
            color: var(--accent-color);
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: #999;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        
        .card-header {
            background: #fff;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Stats Cards */
        .stat-card {
            border-radius: 10px;
            padding: 20px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card.primary { background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); }
        .stat-card.accent { background: linear-gradient(135deg, var(--accent-color), var(--accent-hover)); }
        .stat-card.success { background: linear-gradient(135deg, var(--success-color), #1e8449); }
        .stat-card.danger { background: linear-gradient(135deg, var(--danger-color), #c0392b); }
        .stat-card.info { background: linear-gradient(135deg, var(--info-color), #2980b9); }
        .stat-card.warning { background: linear-gradient(135deg, var(--warning-color), #d68910); }
        
        .stat-card .stat-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            opacity: 0.3;
        }
        
        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-card .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-primary:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
        }
        
        .btn-secondary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-secondary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        /* Tables */
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: var(--primary-color);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr:hover {
            background: #fafafa;
        }
        
        .action-btns .btn {
            padding: 5px 10px;
            font-size: 0.85rem;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-badge.active { background: rgba(39, 174, 96, 0.15); color: var(--success-color); }
        .status-badge.inactive { background: rgba(231, 76, 60, 0.15); color: var(--danger-color); }
        .status-badge.pending { background: rgba(243, 156, 18, 0.15); color: var(--warning-color); }
        
        /* Forms */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
        }
        
        .form-label {
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 8px;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .admin-sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            
            .admin-sidebar.show {
                left: 0;
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .header-search input {
                width: 200px;
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        @media (max-width: 576px) {
            .header-search {
                display: none;
            }
            
            .user-dropdown .user-info {
                display: none;
            }
            
            .admin-content {
                padding: 15px;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
