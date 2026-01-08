
<body class="<?php echo ($current_page_name == 'Home') ? 'home-page' : ''; ?>">
    <!-- Preloader -->
    <div id="spinner" class="preloader-v3">
        <div class="preloader-content">
            <div class="spinner-safari"></div>
            <p>Loading your adventure...</p>
        </div>
    </div>

    <!-- Navigation Wrapper - Sticky Navigation -->
    <div class="navigation-wrapper sticky-nav <?php echo ($current_page_name == 'Home') ? 'nav-transparent' : 'nav-solid'; ?>">
        
        <!-- Top Info Bar -->
        <div class="top-bar-v3 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="top-bar-left">
                            <div class="top-bar-item">
                                <i class="bi bi-geo-alt"></i>
                                <span><?php echo $physical_address; ?></span>
                            </div>
                            <div class="top-bar-divider"></div>
                            <div class="top-bar-item">
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:<?php echo $email_address; ?>"><?php echo $email_address; ?></a>
                            </div>
                            <div class="top-bar-divider"></div>
                            <div class="top-bar-item">
                                <i class="bi bi-clock"></i>
                                <span>24/7 Support</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="top-bar-right">
                            <div class="top-bar-social">
                                <?php if (!empty($facebook)): ?><a href="<?php echo $facebook; ?>" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a><?php endif; ?>
                                <?php if (!empty($instagram)): ?><a href="<?php echo $instagram; ?>" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a><?php endif; ?>
                                <?php if (!empty($twitter)): ?><a href="<?php echo $twitter; ?>" target="_blank" title="Twitter"><i class="bi bi-twitter-x"></i></a><?php endif; ?>
                                <a href="https://wa.me/<?php echo $consult_number_call; ?>" target="_blank" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                            </div>
                            <div class="top-bar-phone">
                                <i class="bi bi-telephone-fill"></i>
                                <a href="tel:<?php echo $consult_number_call; ?>"><?php echo $phone_number; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <header class="navbar-v3" id="mainNavbar">
            <div class="container">
                <nav class="nav-wrapper">
                    <!-- Logo -->
                    <a href="<?php echo base_url(); ?>" class="nav-logo">
                        <img src="<?php echo base_url(); ?>assets/img/logo/osiram_safari_100x100.png" alt="Osiram Safari Adventure">
                    </a>

                    <!-- Desktop Navigation -->
                    <div class="nav-menu" id="navMenu">
                        <ul class="nav-links">
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>" class="nav-link <?php if($current_page_name == 'Home') echo 'active'; ?>">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>about" class="nav-link <?php if($current_page_name == 'About us') echo 'active'; ?>">
                                    About
                                </a>
                            </li>
                            <li class="nav-item has-dropdown">
                                <a href="<?php echo base_url('destinations'); ?>" class="nav-link <?php if($main_page == 'Destinations') echo 'active'; ?>">
                                    Destinations <i class="bi bi-chevron-down"></i>
                                </a>
                                <div class="dropdown-menu-v3">
                                    <div class="dropdown-grid">
                                        <?php if (isset($nav_destinations) && !empty($nav_destinations)): ?>
                                            <?php foreach ($nav_destinations as $dest): ?>
                                            <a href="<?php echo base_url('destinations/' . $dest->slug); ?>" class="dropdown-item-v3">
                                                <div class="dropdown-icon"><?php echo $dest->nav_icon; ?></div>
                                                <div class="dropdown-text">
                                                    <strong><?php echo htmlspecialchars($dest->name); ?></strong>
                                                    <span><?php echo htmlspecialchars($dest->nav_label); ?></span>
                                                </div>
                                            </a>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <!-- Fallback static items -->
                                            <a href="<?php echo base_url('destinations/serengeti-national-park'); ?>" class="dropdown-item-v3">
                                                <div class="dropdown-icon">🦁</div>
                                                <div class="dropdown-text">
                                                    <strong>Serengeti NP</strong>
                                                    <span>Great Migration</span>
                                                </div>
                                            </a>
                                            <a href="<?php echo base_url('destinations/ngorongoro-conservation-area'); ?>" class="dropdown-item-v3">
                                                <div class="dropdown-icon">🌋</div>
                                                <div class="dropdown-text">
                                                    <strong>Ngorongoro</strong>
                                                    <span>Crater Highlands</span>
                                                </div>
                                            </a>
                                            <a href="<?php echo base_url('destinations/zanzibar'); ?>" class="dropdown-item-v3">
                                                <div class="dropdown-icon">🏝️</div>
                                                <div class="dropdown-text">
                                                    <strong>Zanzibar</strong>
                                                    <span>Beach Paradise</span>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="dropdown-footer">
                                        <a href="<?php echo base_url('destinations'); ?>">View All Destinations <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item has-dropdown">
                                <a href="<?php echo base_url('packages'); ?>" class="nav-link <?php if($main_page == 'Packages') echo 'active'; ?>">
                                    Packages <i class="bi bi-chevron-down"></i>
                                </a>
                                <div class="dropdown-menu-v3 dropdown-sm">
                                    <?php if(isset($package_filters) && !empty($package_filters)): ?>
                                        <?php 
                                        $nav_icons = [
                                            'popular' => '⭐', 'budget' => '💵', 'luxury' => '💎', 
                                            'wildlife' => '🦁', 'beach' => '🏖️', 'mountain' => '🏔️',
                                            'cultural' => '🎭', 'honeymoon' => '💕', 'adventure' => '🏕️'
                                        ];
                                        $nav_desc = [
                                            'popular' => 'Most booked safaris', 'budget' => 'Affordable adventures',
                                            'luxury' => 'Premium experiences', 'wildlife' => 'Big Five encounters',
                                            'beach' => 'Sun & sand relaxation', 'mountain' => 'Kilimanjaro treks',
                                            'cultural' => 'Maasai experiences', 'honeymoon' => 'Romantic getaways',
                                            'adventure' => 'Thrilling expeditions'
                                        ];
                                        foreach($package_filters as $filter): 
                                            if($filter['key'] === 'all') continue;
                                            $icon = isset($nav_icons[$filter['key']]) ? $nav_icons[$filter['key']] : '📦';
                                            $desc = isset($nav_desc[$filter['key']]) ? $nav_desc[$filter['key']] : 'Safari packages';
                                        ?>
                                        <a href="<?php echo base_url('packages'); ?>?category=<?php echo $filter['key']; ?>" class="dropdown-item-v3">
                                            <div class="dropdown-icon"><?php echo $icon; ?></div>
                                            <div class="dropdown-text">
                                                <strong><?php echo $filter['label']; ?></strong>
                                                <span><?php echo $desc; ?></span>
                                            </div>
                                        </a>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <!-- Fallback static items -->
                                        <a href="<?php echo base_url('packages'); ?>?category=popular" class="dropdown-item-v3">
                                            <div class="dropdown-icon">⭐</div>
                                            <div class="dropdown-text">
                                                <strong>Popular</strong>
                                                <span>Most booked safaris</span>
                                            </div>
                                        </a>
                                        <a href="<?php echo base_url('packages'); ?>?category=budget" class="dropdown-item-v3">
                                            <div class="dropdown-icon">💵</div>
                                            <div class="dropdown-text">
                                                <strong>Budget</strong>
                                                <span>Affordable adventures</span>
                                            </div>
                                        </a>
                                        <a href="<?php echo base_url('packages'); ?>?category=luxury" class="dropdown-item-v3">
                                            <div class="dropdown-icon">💎</div>
                                            <div class="dropdown-text">
                                                <strong>Luxury</strong>
                                                <span>Premium experiences</span>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                    <div class="dropdown-footer">
                                        <a href="<?php echo base_url('packages'); ?>">View All Packages <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item has-dropdown">
                                <a href="<?php echo base_url('guide'); ?>" class="nav-link <?php if($main_page == 'Guide') echo 'active'; ?>">
                                    Travel Guide <i class="bi bi-chevron-down"></i>
                                </a>
                                <div class="dropdown-menu-v3 dropdown-sm">
                                    <a href="<?php echo base_url('guide/weather'); ?>" class="dropdown-item-v3">
                                        <div class="dropdown-icon">🌤️</div>
                                        <div class="dropdown-text">
                                            <strong>Weather</strong>
                                            <span>Best time to visit</span>
                                        </div>
                                    </a>
                                    <a href="<?php echo base_url('guide/visa'); ?>" class="dropdown-item-v3">
                                        <div class="dropdown-icon">📄</div>
                                        <div class="dropdown-text">
                                            <strong>Visa Info</strong>
                                            <span>Entry requirements</span>
                                        </div>
                                    </a>
                                    <a href="<?php echo base_url('guide/cost'); ?>" class="dropdown-item-v3">
                                        <div class="dropdown-icon">💰</div>
                                        <div class="dropdown-text">
                                            <strong>Safari Costs</strong>
                                            <span>Budget planning</span>
                                        </div>
                                    </a>
                                    <a href="<?php echo base_url('guide/food'); ?>" class="dropdown-item-v3">
                                        <div class="dropdown-icon">🍽️</div>
                                        <div class="dropdown-text">
                                            <strong>Local Cuisine</strong>
                                            <span>Food & dining</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>gallery" class="nav-link <?php if($current_page_name == 'Gallery') echo 'active'; ?>">
                                    Gallery
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>blog" class="nav-link <?php if($current_page_name == 'Blog') echo 'active'; ?>">
                                    Blog
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>contact" class="nav-link <?php if($current_page_name == 'Contact us') echo 'active'; ?>">
                                    Contact
                                </a>
                            </li>
                            </ul>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="nav-actions">
                        <a href="<?php echo base_url('enquiry'); ?>" class="nav-enquiry-btn">
                            <i class="bi bi-send me-1"></i>
                            <span>Enquire</span>
                        </a>
                        <a href="<?php echo base_url('booking'); ?>" class="nav-cta-btn">
                            <i class="bi bi-calendar-check me-2"></i>
                            <span>Book Now</span>
                        </a>
                        
                        <!-- Mobile Toggle -->
                        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </nav>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu" id="mobileMenu">
                <div class="mobile-menu-content">
                    <ul class="mobile-nav-links">
                        <li><a href="<?php echo base_url(); ?>" class="<?php if($current_page_name == 'Home') echo 'active'; ?>">Home</a></li>
                        <li><a href="<?php echo base_url(); ?>about" class="<?php if($current_page_name == 'About us') echo 'active'; ?>">About</a></li>
                        <li class="mobile-dropdown">
                            <a href="#" class="mobile-dropdown-toggle">Destinations <i class="bi bi-chevron-down"></i></a>
                            <ul class="mobile-dropdown-menu">
                                <?php if (isset($nav_destinations) && !empty($nav_destinations)): ?>
                                    <?php foreach ($nav_destinations as $dest): ?>
                                    <li><a href="<?php echo base_url('destinations/' . $dest->slug); ?>"><?php echo $dest->nav_icon; ?> <?php echo htmlspecialchars($dest->name); ?></a></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li><a href="<?php echo base_url('destinations/serengeti-national-park'); ?>">Serengeti NP</a></li>
                                    <li><a href="<?php echo base_url('destinations/ngorongoro-conservation-area'); ?>">Ngorongoro</a></li>
                                    <li><a href="<?php echo base_url('destinations/zanzibar'); ?>">Zanzibar</a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo base_url('destinations'); ?>">View All →</a></li>
                            </ul>
                        </li>
                        <li class="mobile-dropdown">
                            <a href="#" class="mobile-dropdown-toggle">Packages <i class="bi bi-chevron-down"></i></a>
                            <ul class="mobile-dropdown-menu">
                                <?php if(isset($package_filters) && !empty($package_filters)): ?>
                                    <?php foreach($package_filters as $filter): 
                                        if($filter['key'] === 'all') continue;
                                    ?>
                                    <li><a href="<?php echo base_url('packages'); ?>?category=<?php echo $filter['key']; ?>"><?php echo $filter['icon']; ?> <?php echo $filter['label']; ?></a></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li><a href="<?php echo base_url('packages'); ?>?category=popular">Popular</a></li>
                                    <li><a href="<?php echo base_url('packages'); ?>?category=budget">Budget</a></li>
                                    <li><a href="<?php echo base_url('packages'); ?>?category=luxury">Luxury</a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo base_url('packages'); ?>">View All →</a></li>
                            </ul>
                        </li>
                        <li class="mobile-dropdown">
                            <a href="#" class="mobile-dropdown-toggle">Travel Guide <i class="bi bi-chevron-down"></i></a>
                            <ul class="mobile-dropdown-menu">
                                <li><a href="<?php echo base_url('guide/weather'); ?>">Weather</a></li>
                                <li><a href="<?php echo base_url('guide/visa'); ?>">Visa Info</a></li>
                                <li><a href="<?php echo base_url('guide/cost'); ?>">Safari Costs</a></li>
                                <li><a href="<?php echo base_url('guide/food'); ?>">Local Cuisine</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url(); ?>gallery" class="<?php if($current_page_name == 'Gallery') echo 'active'; ?>">Gallery</a></li>
                         <li><a href="<?php echo base_url(); ?>blog" class="<?php if($current_page_name == 'Blog') echo 'active'; ?>">Blog</a></li>
                         <li><a href="<?php echo base_url(); ?>contact" class="<?php if($current_page_name == 'Contact us') echo 'active'; ?>">Contact</a></li>
                    </ul>
                    <div class="mobile-menu-footer">
                        <a href="<?php echo base_url('enquiry'); ?>" class="mobile-enquiry-btn">
                            <i class="bi bi-send me-2"></i> Get Free Quote
                        </a>
                        <a href="<?php echo base_url('booking'); ?>" class="mobile-cta-btn">
                            <i class="bi bi-calendar-check me-2"></i> Book Your Safari
                        </a>
                        <div class="mobile-contact">
                            <a href="tel:<?php echo $consult_number_call; ?>"><i class="bi bi-telephone"></i> <?php echo $phone_number; ?></a>
                            <a href="mailto:<?php echo $email_address; ?>"><i class="bi bi-envelope"></i> <?php echo $email_address; ?></a>
                        </div>
                        <div class="mobile-social">
                            <?php if (!empty($facebook)): ?><a href="<?php echo $facebook; ?>" target="_blank"><i class="bi bi-facebook"></i></a><?php endif; ?>
                            <?php if (!empty($instagram)): ?><a href="<?php echo $instagram; ?>" target="_blank"><i class="bi bi-instagram"></i></a><?php endif; ?>
                            <a href="https://wa.me/<?php echo $consult_number_call; ?>" target="_blank"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

<style>
/* Prevent horizontal scroll from off-screen mobile menu */
body {
    overflow-x: hidden;
}

/* ============ PRELOADER V3 ============ */
.preloader-v3 {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

.preloader-v3.hide {
    opacity: 0;
    visibility: hidden;
}

.preloader-content {
    text-align: center;
}

.spinner-safari {
    width: 60px;
    height: 60px;
    border: 4px solid rgba(255,255,255,0.1);
    border-top-color: var(--primary, #C7805C);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

.preloader-content p {
    color: rgba(255,255,255,0.7);
    font-size: 0.95rem;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ============ NAVIGATION WRAPPER ============ */
.navigation-wrapper {
    position: relative;
    z-index: 1000;
}

.navigation-wrapper.sticky-nav {
    position: sticky;
    top: 0;
}

/* Transparent Nav for Home Page */
.navigation-wrapper.nav-transparent {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

.navigation-wrapper.nav-transparent .top-bar-v3 {
    background: rgba(26, 26, 46, 0.8);
    backdrop-filter: blur(10px);
}

.navigation-wrapper.nav-transparent .navbar-v3 {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
}

.navigation-wrapper.nav-transparent .navbar-v3.scrolled {
    background: white;
    box-shadow: 0 5px 30px rgba(0,0,0,0.12);
}

/* Solid Nav for other pages */
.navigation-wrapper.nav-solid .top-bar-v3 {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
}

.navigation-wrapper.nav-solid .navbar-v3 {
    background: white;
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
}

/* ============ TOP BAR V3 ============ */
.top-bar-v3 {
    padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
}

.top-bar-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

.top-bar-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255,255,255,0.8);
    font-size: 0.85rem;
}

.top-bar-item i {
    color: var(--primary, #C7805C);
}

.top-bar-item a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}

.top-bar-item a:hover {
    color: var(--primary, #C7805C);
}

.top-bar-divider {
    width: 1px;
    height: 15px;
    background: rgba(255,255,255,0.2);
}

.top-bar-right {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 25px;
}

.top-bar-social {
    display: flex;
    gap: 10px;
}

.top-bar-social a {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.top-bar-social a:hover {
    background: var(--primary, #C7805C);
    transform: translateY(-2px);
}

.top-bar-phone {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(199, 128, 92, 0.2);
    padding: 6px 15px;
    border-radius: 20px;
    white-space: nowrap;
}

.top-bar-phone i {
    color: var(--primary, #C7805C);
}

.top-bar-phone a {
    color: white;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
}

/* ============ NAVBAR V3 ============ */
.navbar-v3 {
    position: sticky;
    top: 0;
    z-index: 1000;
    transition: all 0.3s ease;
}

.nav-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
}

/* Logo */
.nav-logo img {
    height: 60px;
    width: auto;
    transition: transform 0.3s ease;
}

.nav-logo:hover img {
    transform: scale(1.05);
}

/* Nav Menu */
.nav-menu {
    display: flex;
    align-items: center;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 5px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 12px 18px;
    color: #1a1a2e;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.nav-link:hover,
.nav-link.active {
    color: var(--primary, #C7805C);
    background: rgba(199, 128, 92, 0.08);
}

.nav-link i {
    font-size: 0.7rem;
    transition: transform 0.3s ease;
}

.nav-item:hover .nav-link i {
    transform: rotate(180deg);
}

/* Dropdown Menu */
.dropdown-menu-v3 {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(10px);
    background: white;
    min-width: 500px;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 100;
}

.dropdown-menu-v3.dropdown-sm {
    min-width: 280px;
}

.nav-item:hover .dropdown-menu-v3 {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}

.dropdown-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.dropdown-sm .dropdown-grid {
    grid-template-columns: 1fr;
}

.dropdown-item-v3 {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.dropdown-item-v3:hover {
    background: #f8f9fa;
}

.dropdown-icon {
    font-size: 1.5rem;
}

.dropdown-text strong {
    display: block;
    color: #1a1a2e;
    font-size: 0.95rem;
}

.dropdown-text span {
    font-size: 0.8rem;
    color: #888;
}

.dropdown-footer {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
    text-align: center;
}

.dropdown-footer a {
    color: var(--primary, #C7805C);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.dropdown-footer a:hover {
    text-decoration: underline;
}

/* Nav Actions */
.nav-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.nav-phone {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
}

.phone-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: rgba(199, 128, 92, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary, #C7805C);
    font-size: 1.1rem;
}

.phone-text span {
    display: block;
    font-size: 0.75rem;
    color: #888;
}

.phone-text strong {
    color: #1a1a2e;
    font-size: 0.95rem;
    white-space: nowrap;
}

.nav-enquiry-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: transparent;
    color: #1a1a2e;
    border: 2px solid #1a1a2e;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-right: 10px;
    white-space: nowrap;
}

.nav-enquiry-btn:hover {
    background: #1a1a2e;
    color: white;
}

.nav-cta-btn {
    display: inline-flex;
    align-items: center;
    padding: 12px 25px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(199, 128, 92, 0.3);
    white-space: nowrap;
}

.nav-cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(199, 128, 92, 0.4);
    color: white;
}

/* Mobile Toggle */
.nav-toggle {
    display: none;
    flex-direction: column;
    gap: 5px;
    padding: 10px;
    background: none;
    border: none;
    cursor: pointer;
}

.nav-toggle span {
    display: block;
    width: 25px;
    height: 3px;
    background: #1a1a2e;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.nav-toggle.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 6px);
}

.nav-toggle.active span:nth-child(2) {
    opacity: 0;
}

.nav-toggle.active span:nth-child(3) {
    transform: rotate(-45deg) translate(6px, -7px);
}

/* Mobile Menu */
.mobile-menu {
    position: fixed;
    top: 0;
    right: -100%;
    width: 100%;
    max-width: 350px;
    height: 100vh;
    background: white;
    box-shadow: -10px 0 30px rgba(0,0,0,0.1);
    z-index: 9999;
    transition: right 0.3s ease;
    overflow-y: auto;
}

.mobile-menu.active {
    right: 0;
}

.mobile-menu-content {
    padding: 80px 25px 30px;
}

.mobile-nav-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.mobile-nav-links > li {
    border-bottom: 1px solid #f0f0f0;
}

.mobile-nav-links > li > a {
    display: block;
    padding: 15px 0;
    color: #1a1a2e;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.05rem;
}

.mobile-nav-links > li > a.active {
    color: var(--primary, #C7805C);
}

.mobile-dropdown-toggle {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.mobile-dropdown-menu {
    list-style: none;
    padding: 0 0 10px 15px;
    margin: 0;
    display: none;
}

.mobile-dropdown.active .mobile-dropdown-menu {
    display: block;
}

.mobile-dropdown-menu li a {
    display: block;
    padding: 10px 0;
    color: #666;
    text-decoration: none;
    font-size: 0.95rem;
}

.mobile-menu-footer {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid #f0f0f0;
}

.mobile-enquiry-btn {
    display: block;
    width: 100%;
    padding: 15px;
    background: transparent;
    color: #1a1a2e;
    text-align: center;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    margin-bottom: 10px;
    border: 2px solid #1a1a2e;
}

.mobile-cta-btn {
    display: block;
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    text-align: center;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    margin-bottom: 20px;
}

.mobile-contact {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

.mobile-contact a {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #666;
    text-decoration: none;
    font-size: 0.9rem;
}

.mobile-contact i {
    color: var(--primary, #C7805C);
}

.mobile-social {
    display: flex;
    gap: 10px;
}

.mobile-social a {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1a1a2e;
    text-decoration: none;
    transition: all 0.3s ease;
}

.mobile-social a:hover {
    background: var(--primary, #C7805C);
    color: white;
}

/* Responsive */
@media (max-width: 1199px) {
    .nav-phone {
        display: none !important;
    }
}

@media (max-width: 991px) {
    .nav-menu {
        display: none;
    }
    
    .nav-toggle {
        display: flex;
    }
    
    .nav-cta-btn span {
        display: none;
    }
    
    .nav-cta-btn {
        padding: 12px 15px;
    }
}

@media (max-width: 576px) {
    .nav-logo img {
        height: 50px;
    }
    
    .nav-wrapper {
        padding: 10px 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide preloader
    setTimeout(function() {
        document.getElementById('spinner').classList.add('hide');
    }, 500);
    
    // Mobile menu toggle
    const navToggle = document.getElementById('navToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (navToggle && mobileMenu) {
        navToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });
    }
    
    // Mobile dropdowns
    document.querySelectorAll('.mobile-dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            this.parentElement.classList.toggle('active');
        });
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (navbar) {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    });
    
    // Close mobile menu on link click
    document.querySelectorAll('.mobile-nav-links a:not(.mobile-dropdown-toggle)').forEach(function(link) {
        link.addEventListener('click', function() {
            if (mobileMenu) {
                mobileMenu.classList.remove('active');
            }
            if (navToggle) {
                navToggle.classList.remove('active');
            }
            document.body.style.overflow = '';
        });
    });
});
</script>
