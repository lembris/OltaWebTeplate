-- Bulk Notifications Module Migration
-- For sending mass notifications to students, faculty, and staff

-- =====================================================
-- CONTACT GROUPS (Configured in Settings)
-- =====================================================

CREATE TABLE IF NOT EXISTS `contact_groups` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uid` VARCHAR(36) NOT NULL UNIQUE,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `color` VARCHAR(7) DEFAULT '#0d6efd',
    `icon` VARCHAR(50) DEFAULT 'fa-users',
    `is_active` TINYINT(1) DEFAULT 1,
    `sort_order` INT(11) DEFAULT 0,
    `created_by` INT(11) UNSIGNED NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_active` (`is_active`),
    INDEX `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contact Group Members
CREATE TABLE IF NOT EXISTS `contact_group_members` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uid` VARCHAR(36) NOT NULL UNIQUE,
    `group_id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NULL,
    `phone` VARCHAR(20) NULL,
    `designation` VARCHAR(255) NULL,
    `department` VARCHAR(255) NULL,
    `notes` TEXT NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_group` (`group_id`),
    INDEX `idx_active` (`is_active`),
    INDEX `idx_email` (`email`),
    FOREIGN KEY (`group_id`) REFERENCES `contact_groups`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add UID column to existing contact_group_members if not exists (for upgrades)
-- ALTER TABLE `contact_group_members` ADD COLUMN `uid` VARCHAR(36) NOT NULL UNIQUE AFTER `id`;
-- UPDATE `contact_group_members` SET `uid` = UUID() WHERE `uid` IS NULL OR `uid` = '';

-- Sample Contact Groups
INSERT INTO `contact_groups` (`uid`, `name`, `description`, `color`, `icon`, `sort_order`) VALUES
(UUID(), 'All Students', 'All enrolled students', '#198754', 'fa-user-graduate', 1),
(UUID(), 'All Faculty', 'All faculty members', '#0d6efd', 'fa-chalkboard-teacher', 2),
(UUID(), 'All Staff', 'Administrative and support staff', '#6c757d', 'fa-users-cog', 3),
(UUID(), 'Department Heads', 'Heads of all departments', '#dc3545', 'fa-user-tie', 4),
(UUID(), 'Parents/Guardians', 'Student parents and guardians', '#ffc107', 'fa-user-friends', 5),
(UUID(), 'Alumni', 'Former students', '#17a2b8', 'fa-graduation-cap', 6);

-- =====================================================
-- BULK NOTIFICATIONS
-- =====================================================

-- Bulk Notifications Table
CREATE TABLE IF NOT EXISTS `bulk_notifications` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uid` VARCHAR(36) NOT NULL UNIQUE,
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `message_html` TEXT NULL,
    `type` ENUM('email', 'sms', 'both') DEFAULT 'email',
    `priority` ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    `target_groups` TEXT NULL COMMENT 'JSON array of contact group IDs',
    `scheduled_at` DATETIME NULL COMMENT 'NULL means send immediately',
    `sent_at` DATETIME NULL,
    `status` ENUM('draft', 'scheduled', 'sending', 'sent', 'failed', 'cancelled') DEFAULT 'draft',
    `total_recipients` INT(11) UNSIGNED DEFAULT 0,
    `sent_count` INT(11) UNSIGNED DEFAULT 0,
    `failed_count` INT(11) UNSIGNED DEFAULT 0,
    `opened_count` INT(11) UNSIGNED DEFAULT 0,
    `error_log` TEXT NULL,
    `created_by` INT(11) UNSIGNED NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_status` (`status`),
    INDEX `idx_type` (`type`),
    INDEX `idx_scheduled` (`scheduled_at`),
    INDEX `idx_sent` (`sent_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Notification Recipients Table (for tracking individual sends)
CREATE TABLE IF NOT EXISTS `notification_recipients` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `notification_id` INT(11) UNSIGNED NOT NULL,
    `recipient_type` ENUM('student', 'faculty', 'staff', 'parent', 'alumni', 'other') DEFAULT 'other',
    `recipient_id` INT(11) UNSIGNED NULL COMMENT 'Reference to user ID if applicable',
    `recipient_name` VARCHAR(255) NULL,
    `recipient_email` VARCHAR(255) NULL,
    `recipient_phone` VARCHAR(20) NULL,
    `status` ENUM('pending', 'sent', 'failed', 'opened', 'bounced') DEFAULT 'pending',
    `sent_at` DATETIME NULL,
    `opened_at` DATETIME NULL,
    `error_message` VARCHAR(500) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_notification` (`notification_id`),
    INDEX `idx_status` (`status`),
    INDEX `idx_email` (`recipient_email`),
    FOREIGN KEY (`notification_id`) REFERENCES `bulk_notifications`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Notification Templates Table
CREATE TABLE IF NOT EXISTS `notification_templates` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uid` VARCHAR(36) NOT NULL UNIQUE,
    `name` VARCHAR(255) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `body` TEXT NOT NULL,
    `body_html` TEXT NULL,
    `category` VARCHAR(100) DEFAULT 'General',
    `variables` TEXT NULL COMMENT 'JSON array of available variables',
    `is_active` TINYINT(1) DEFAULT 1,
    `created_by` INT(11) UNSIGNED NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_category` (`category`),
    INDEX `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample Notification Templates
INSERT INTO `notification_templates` (`uid`, `name`, `subject`, `body`, `body_html`, `category`, `variables`) VALUES
(UUID(), 'Welcome Message', 'Welcome to {{institution_name}}', 'Dear {{recipient_name}},\n\nWelcome to {{institution_name}}! We are excited to have you join our community.\n\nBest regards,\n{{institution_name}} Team', '<p>Dear {{recipient_name}},</p><p>Welcome to <strong>{{institution_name}}</strong>! We are excited to have you join our community.</p><p>Best regards,<br>{{institution_name}} Team</p>', 'Welcome', '["recipient_name", "institution_name"]'),
(UUID(), 'Event Reminder', 'Reminder: {{event_name}} on {{event_date}}', 'Dear {{recipient_name}},\n\nThis is a reminder that {{event_name}} is scheduled for {{event_date}} at {{event_time}}.\n\nLocation: {{event_location}}\n\nWe look forward to seeing you there!\n\nBest regards,\n{{institution_name}}', '<p>Dear {{recipient_name}},</p><p>This is a reminder that <strong>{{event_name}}</strong> is scheduled for {{event_date}} at {{event_time}}.</p><p><strong>Location:</strong> {{event_location}}</p><p>We look forward to seeing you there!</p><p>Best regards,<br>{{institution_name}}</p>', 'Events', '["recipient_name", "event_name", "event_date", "event_time", "event_location", "institution_name"]'),
(UUID(), 'Exam Schedule', 'Examination Schedule - {{semester}}', 'Dear {{recipient_name}},\n\nThe examination schedule for {{semester}} has been released.\n\nPlease check the notice board or student portal for detailed timings.\n\nImportant: Bring your ID card to all examinations.\n\nBest regards,\nExamination Department', '<p>Dear {{recipient_name}},</p><p>The examination schedule for <strong>{{semester}}</strong> has been released.</p><p>Please check the notice board or student portal for detailed timings.</p><p><strong>Important:</strong> Bring your ID card to all examinations.</p><p>Best regards,<br>Examination Department</p>', 'Academic', '["recipient_name", "semester"]'),
(UUID(), 'Fee Reminder', 'Fee Payment Reminder - Due Date: {{due_date}}', 'Dear {{recipient_name}},\n\nThis is a reminder that your fee payment of {{amount}} is due on {{due_date}}.\n\nPlease ensure timely payment to avoid late fees.\n\nFor any queries, contact the accounts department.\n\nBest regards,\nAccounts Department', '<p>Dear {{recipient_name}},</p><p>This is a reminder that your fee payment of <strong>{{amount}}</strong> is due on <strong>{{due_date}}</strong>.</p><p>Please ensure timely payment to avoid late fees.</p><p>For any queries, contact the accounts department.</p><p>Best regards,<br>Accounts Department</p>', 'Finance', '["recipient_name", "amount", "due_date"]'),
(UUID(), 'Holiday Notice', 'Holiday Notice - {{holiday_name}}', 'Dear All,\n\nPlease note that the institution will remain closed on {{holiday_date}} on account of {{holiday_name}}.\n\nRegular classes/work will resume on {{resume_date}}.\n\nBest regards,\n{{institution_name}}', '<p>Dear All,</p><p>Please note that the institution will remain closed on <strong>{{holiday_date}}</strong> on account of <strong>{{holiday_name}}</strong>.</p><p>Regular classes/work will resume on {{resume_date}}.</p><p>Best regards,<br>{{institution_name}}</p>', 'General', '["holiday_name", "holiday_date", "resume_date", "institution_name"]'),
(UUID(), 'Emergency Alert', 'URGENT: {{alert_title}}', 'URGENT NOTICE\n\n{{alert_message}}\n\nPlease follow all instructions and stay safe.\n\nFor emergencies, contact: {{emergency_contact}}\n\n{{institution_name}} Administration', '<p style="color: red; font-weight: bold;">URGENT NOTICE</p><p>{{alert_message}}</p><p>Please follow all instructions and stay safe.</p><p><strong>For emergencies, contact:</strong> {{emergency_contact}}</p><p>{{institution_name}} Administration</p>', 'Emergency', '["alert_title", "alert_message", "emergency_contact", "institution_name"]');
