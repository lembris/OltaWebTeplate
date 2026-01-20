-- Migration 008: Create partners table for medical template
-- Run this SQL in phpMyAdmin (database: dmi)

CREATE TABLE IF NOT EXISTS `partners` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `uid` varchar(36) NOT NULL,
    `name` varchar(255) NOT NULL,
    `type` enum('tanzania','international') NOT NULL DEFAULT 'tanzania',
    `short_description` varchar(255) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `logo` varchar(255) DEFAULT NULL,
    `website` varchar(255) DEFAULT NULL,
    `contact_email` varchar(255) DEFAULT NULL,
    `contact_phone` varchar(50) DEFAULT NULL,
    `address` text DEFAULT NULL,
    `country` varchar(100) DEFAULT NULL,
    `specialties` text DEFAULT NULL COMMENT 'JSON array of specialties',
    `display_order` int(11) NOT NULL DEFAULT 0,
    `is_featured` tinyint(1) NOT NULL DEFAULT 0,
    `status` enum('active','inactive') NOT NULL DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add sample partner data for TNA CARE
INSERT INTO `partners` (`uid`, `name`, `type`, `short_description`, `website`, `country`, `status`) VALUES
('partner-001', 'Muhimbili National Hospital', 'tanzania', 'National referral hospital in Dar es Salaam', 'https://mnh.or.tz', 'Tanzania', 'active'),
('partner-002', 'Kilimanjaro Christian Medical Centre', 'tanzania', 'Regional referral hospital in Moshi', 'https://kcmc.ac.tz', 'Tanzania', 'active'),
('partner-003', 'Bugando Medical Centre', 'tanzania', 'Zonal referral hospital in Mwanza', NULL, 'Tanzania', 'active'),
('partner-004', ' Jakaya Kikwete Cardiac Institute', 'tanzania', 'Specialized cardiac care in Dar es Salaam', NULL, 'Tanzania', 'active'),
('partner-005', 'Mwananyamala Regional Referral Hospital', 'tanzania', 'Regional referral hospital in Dar es Salaam', NULL, 'Tanzania', 'active'),
('partner-006', 'St. Francis Regional Referral Hospital', 'tanzania', 'Regional referral hospital in Ifakara', NULL, 'Tanzania', 'active'),
('partner-007', 'Meru District Hospital', 'tanzania', 'District hospital in Arusha region', NULL, 'Tanzania', 'active'),
('partner-008', 'World Health Organization', 'international', 'Global health organization', 'https://who.int', 'International', 'active'),
('partner-009', 'UNICEF Tanzania', 'international', 'United Nations children agency', 'https://unicef.org/tanzania', 'International', 'active'),
('partner-010', 'ICAP Columbia University', 'international', 'International AIDS care and research', 'https://icap.columbia.edu', 'International', 'active');
