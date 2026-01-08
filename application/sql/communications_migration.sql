-- Communications Module Migration
-- Includes: Notices, Announcements

-- Notices Table
CREATE TABLE IF NOT EXISTS `notices` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uid` VARCHAR(36) NOT NULL UNIQUE,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `content` TEXT NOT NULL,
    `excerpt` VARCHAR(500) NULL,
    `category` VARCHAR(100) DEFAULT 'General',
    `priority` ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    `attachment` VARCHAR(255) NULL,
    `attachment_name` VARCHAR(255) NULL,
    `start_date` DATE NULL,
    `end_date` DATE NULL,
    `target_audience` VARCHAR(100) DEFAULT 'all',
    `views` INT(11) UNSIGNED DEFAULT 0,
    `published` TINYINT(1) DEFAULT 0,
    `pinned` TINYINT(1) DEFAULT 0,
    `created_by` INT(11) UNSIGNED NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_published` (`published`),
    INDEX `idx_pinned` (`pinned`),
    INDEX `idx_priority` (`priority`),
    INDEX `idx_dates` (`start_date`, `end_date`),
    INDEX `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Announcements Table
CREATE TABLE IF NOT EXISTS `announcements` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uid` VARCHAR(36) NOT NULL UNIQUE,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `content` TEXT NOT NULL,
    `excerpt` VARCHAR(500) NULL,
    `type` ENUM('info', 'success', 'warning', 'danger') DEFAULT 'info',
    `icon` VARCHAR(50) DEFAULT 'fa-bullhorn',
    `image` VARCHAR(255) NULL,
    `link_url` VARCHAR(500) NULL,
    `link_text` VARCHAR(100) NULL,
    `display_location` SET('homepage', 'header', 'sidebar', 'footer', 'popup') DEFAULT 'homepage',
    `start_date` DATETIME NULL,
    `end_date` DATETIME NULL,
    `target_audience` VARCHAR(100) DEFAULT 'all',
    `views` INT(11) UNSIGNED DEFAULT 0,
    `clicks` INT(11) UNSIGNED DEFAULT 0,
    `published` TINYINT(1) DEFAULT 0,
    `sort_order` INT(11) DEFAULT 0,
    `created_by` INT(11) UNSIGNED NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_published` (`published`),
    INDEX `idx_type` (`type`),
    INDEX `idx_dates` (`start_date`, `end_date`),
    INDEX `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample Data for Notices
INSERT INTO `notices` (`uid`, `title`, `slug`, `content`, `excerpt`, `category`, `priority`, `target_audience`, `published`, `pinned`, `created_at`) VALUES
(UUID(), 'Semester Registration Now Open', 'semester-registration-now-open', '<p>Registration for the upcoming semester is now open. All students are required to complete their registration by the deadline.</p><h3>Important Dates:</h3><ul><li>Registration Opens: January 15, 2025</li><li>Registration Closes: February 15, 2025</li><li>Late Registration: February 16-28, 2025 (with penalty)</li></ul>', 'Registration for the upcoming semester is now open. All students are required to complete their registration by the deadline.', 'Academic', 'high', 'students', 1, 1, NOW()),
(UUID(), 'Library Hours Extended During Exams', 'library-hours-extended-exams', '<p>The main library will extend its operating hours during the examination period to support student study needs.</p><p><strong>Extended Hours:</strong> 6:00 AM - 12:00 AM (Midnight)</p><p><strong>Effective:</strong> During exam week</p>', 'The main library will extend its operating hours during the examination period.', 'Facilities', 'normal', 'all', 1, 0, NOW()),
(UUID(), 'Campus Maintenance Notice', 'campus-maintenance-notice', '<p>Scheduled maintenance work will be carried out on the main building electrical systems this weekend.</p><p>Some areas may experience temporary power outages.</p>', 'Scheduled maintenance work will be carried out on the main building electrical systems this weekend.', 'General', 'normal', 'all', 1, 0, NOW());

-- Sample Data for Announcements
INSERT INTO `announcements` (`uid`, `title`, `slug`, `content`, `excerpt`, `type`, `icon`, `display_location`, `published`, `sort_order`, `created_at`) VALUES
(UUID(), 'Welcome to the New Academic Year', 'welcome-new-academic-year', '<p>We are excited to welcome all students, faculty, and staff to the new academic year. Let us make this year one of growth, learning, and achievement.</p>', 'We are excited to welcome all students, faculty, and staff to the new academic year.', 'success', 'fa-graduation-cap', 'homepage,header', 1, 1, NOW()),
(UUID(), 'Admissions Open for 2025', 'admissions-open-2025', '<p>Applications are now being accepted for the 2025 intake. Apply now and join our community of learners.</p>', 'Applications are now being accepted for the 2025 intake.', 'info', 'fa-user-plus', 'homepage,popup', 1, 2, NOW()),
(UUID(), 'COVID-19 Safety Guidelines', 'covid-19-safety-guidelines', '<p>Please continue to follow all health and safety guidelines while on campus. Your safety is our priority.</p>', 'Please continue to follow all health and safety guidelines while on campus.', 'warning', 'fa-shield-virus', 'header', 1, 3, NOW());
