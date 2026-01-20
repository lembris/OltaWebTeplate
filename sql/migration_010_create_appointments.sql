-- Migration 010: Create appointments table for medical template
-- Updated with booking reference and email tracking
-- Run this SQL in phpMyAdmin (database: dmi)

CREATE TABLE IF NOT EXISTS `appointments` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `uid` varchar(36) NOT NULL,
    `booking_ref` varchar(20) DEFAULT NULL COMMENT 'Human-readable reference (e.g., CNSLT-0001)',
    `patient_name` varchar(255) NOT NULL,
    `patient_email` varchar(255) NOT NULL,
    `patient_phone` varchar(50) NOT NULL,
    `country` varchar(100) DEFAULT NULL,
    `medical_specialty` varchar(100) DEFAULT NULL,
    `treatment_timeline` varchar(50) DEFAULT NULL,
    `preferred_date` date DEFAULT NULL,
    `preferred_time` varchar(20) DEFAULT NULL,
    `additional_notes` text DEFAULT NULL,
    `status` enum('pending','confirmed','completed','cancelled','no_show') NOT NULL DEFAULT 'pending',
    `assigned_to` varchar(100) DEFAULT NULL,
    `admin_notes` text DEFAULT NULL,
    `is_mail_success` tinyint(1) DEFAULT 0 COMMENT 'Customer email sent status',
    `is_admin_mail_success` tinyint(1) DEFAULT 0 COMMENT 'Admin email sent status',
    `mail_sent_at` datetime DEFAULT NULL COMMENT 'When emails were sent',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `uid` (`uid`),
    KEY `booking_ref` (`booking_ref`),
    KEY `status` (`status`),
    KEY `patient_email` (`patient_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Medical consultation appointments';

-- Sample data for testing
INSERT INTO `appointments` (`uid`, `booking_ref`, `patient_name`, `patient_email`, `patient_phone`, `country`, `medical_specialty`, `treatment_timeline`, `preferred_date`, `preferred_time`, `additional_notes`, `status`) VALUES
('a1b2c3d4-e5f6-7890-abcd-ef1234567890', 'CNSLT-0001', 'John Doe', 'john.doe@email.com', '+255789123456', 'Tanzania', 'Cardiology', 'Within 1 month', '2025-02-15', 'Morning', 'Looking for cardiac consultation', 'pending'),
('b2c3d4e5-f6a7-8901-bcde-f12345678901', 'CNSLT-0002', 'Jane Smith', 'jane.smith@email.com', '+254712345678', 'Kenya', 'Orthopaedic Surgery', 'Emergency', '2025-01-20', 'Any time', 'Sports injury follow-up', 'confirmed');
