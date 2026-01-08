-- Bookings Admin Module - Database Schema Updates
-- Run these queries to add soft delete and status history tracking

-- Add deleted_at column to bookings table for soft delete (if not exists)
ALTER TABLE `bookings` 
ADD COLUMN IF NOT EXISTS `deleted_at` DATETIME DEFAULT NULL AFTER `updated_at`;

-- Create booking_status_history table for tracking status changes
CREATE TABLE IF NOT EXISTS `booking_status_history` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `booking_id` INT(11) UNSIGNED NOT NULL,
    `old_status` VARCHAR(50) NOT NULL,
    `new_status` VARCHAR(50) NOT NULL,
    `changed_by` INT(11) UNSIGNED DEFAULT NULL COMMENT 'Admin ID who made the change',
    `notes` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_booking_id` (`booking_id`),
    KEY `idx_created_at` (`created_at`),
    CONSTRAINT `fk_status_history_booking` FOREIGN KEY (`booking_id`) 
        REFERENCES `bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add index for faster filtering by deleted_at
CREATE INDEX IF NOT EXISTS `idx_bookings_deleted_at` ON `bookings` (`deleted_at`);

-- Add index for status filtering
CREATE INDEX IF NOT EXISTS `idx_bookings_status` ON `bookings` (`status`);

-- Add index for travel date filtering
CREATE INDEX IF NOT EXISTS `idx_bookings_travel_date` ON `bookings` (`travel_date`);
