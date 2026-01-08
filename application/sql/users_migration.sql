-- Users Table Migration
-- This table stores system users for the application

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(120) NOT NULL UNIQUE,
  `username` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('super_admin', 'admin', 'staff', 'user') NOT NULL DEFAULT 'user',
  `status` enum('active', 'inactive') NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  KEY `email` (`email`),
  KEY `username` (`username`),
  KEY `role` (`role`),
  KEY `status` (`status`),
  KEY `is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default super admin user if not exists
INSERT INTO `users` (`full_name`, `email`, `username`, `password`, `phone`, `role`, `status`, `created_at`, `updated_at`)
SELECT 'Super Administrator', 'superadmin@institute.local', 'super_admin', '$2y$10$7L/l0qBKZGJ5K6NZRgR8Ku.bqJ5q1x8zK4Z5d5e5d5e5d5e5d5e5d', '000-000-0000', 'super_admin', 'active', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `users` WHERE `username` = 'super_admin');
