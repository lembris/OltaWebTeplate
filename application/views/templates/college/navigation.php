<body>
    <!-- Preloader - auto-hides after 2 seconds as fallback -->
    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="<?php echo get_theme_color('primary'); ?>"/>
        </svg>
    </div>
    <style>
        /* Fallback: auto-hide loader after 2s if JS fails */
        #ftco-loader {
            animation: hideLoader 0s 2s forwards;
        }
        @keyframes hideLoader {
            to { opacity: 0; visibility: hidden; pointer-events: none; }
        }
        #ftco-loader:not(.show) {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
    </style>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light sticky-top" id="ftco-navbar">
        <div class="container">
            <a class="" href="<?php echo base_url(); ?>">
                <?php if (!empty($site_logo)): ?>
                    <img src="<?php echo base_url($site_logo); ?>" alt="<?php echo $site_name; ?>" style="max-height: 50px;">
                <?php else: ?>
                    <span><?php echo $site_name; ?></span>
                <?php endif; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item <?php echo ($current_page_name == 'Home') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url(); ?>" class="nav-link <?php echo ($current_page_name == 'Home') ? 'active' : ''; ?>">Home</a>
                    </li>
                    <li class="nav-item <?php echo ($current_page_name == 'About Us') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('about'); ?>" class="nav-link <?php echo ($current_page_name == 'About Us') ? 'active' : ''; ?>">About</a>
                    </li>
                    <!-- Academics Dropdown Menu -->
                    <li class="nav-item dropdown <?php echo ($main_page == 'Programs' || $main_page == 'Faculty' || $main_page == 'Directory' || $current_page_name == 'Programs' || $current_page_name == 'Faculty' || $current_page_name == 'Directory') ? 'active' : ''; ?>">
                        <a href="javascript:void(0);" class="nav-link dropdown-toggle <?php echo ($main_page == 'Programs' || $main_page == 'Faculty' || $main_page == 'Directory' || $current_page_name == 'Programs' || $current_page_name == 'Faculty' || $current_page_name == 'Directory') ? 'active' : ''; ?>">
                            Academics
                        </a>
                        <ul class="dropdown-menu" style="background-color: #f8f9fa; border: 1px solid #dee2e6;">
                            <li>
                                <a href="<?php echo base_url('programs'); ?>" class="dropdown-item <?php echo ($main_page == 'Programs' || $current_page_name == 'Programs') ? 'active' : ''; ?>">
                                    Programs
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('faculty'); ?>" class="dropdown-item <?php echo ($main_page == 'Faculty' || $current_page_name == 'Faculty') ? 'active' : ''; ?>">
                                    Faculty & Departments
                                </a>
                            </li>
                            <!-- <li>
                                <a href="<php echo base_url('directory'); ?>" class="dropdown-item <php echo ($main_page == 'Directory' || $current_page_name == 'Directory') ? 'active' : ''; ?>">
                                    Directory
                                </a>
                            </li> -->
                        </ul>
                    </li>
                    <li class="nav-item <?php echo ($current_page_name == 'Events' || $main_page == 'Events') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('events'); ?>" class="nav-link <?php echo ($current_page_name == 'Events' || $main_page == 'Events') ? 'active' : ''; ?>">Events</a>
                    </li>
                    <li class="nav-item <?php echo ($current_page_name == 'Notices' || $main_page == 'Notices') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('notices'); ?>" class="nav-link <?php echo ($current_page_name == 'Notices' || $main_page == 'Notices') ? 'active' : ''; ?>">Notices</a>
                    </li>
                    <!-- <li class="nav-item <php echo ($current_page_name == 'Gallery') ? 'active' : ''; ?>">
                        <a href="<php echo base_url('gallery'); ?>" class="nav-link <php echo ($current_page_name == 'Gallery') ? 'active' : ''; ?>">Gallery</a>
                    </li> -->
                    <li class="nav-item <?php echo ($current_page_name == 'Blog' || $main_page == 'Blog') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('blog'); ?>" class="nav-link <?php echo ($current_page_name == 'Blog' || $main_page == 'Blog') ? 'active' : ''; ?>">Blog</a>
                    </li>
                    <li class="nav-item <?php echo ($current_page_name == 'Contact Us') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('contact'); ?>" class="nav-link <?php echo ($current_page_name == 'Contact Us') ? 'active' : ''; ?>">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->
