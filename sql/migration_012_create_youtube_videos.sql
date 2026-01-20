-- Create YouTube Videos table
CREATE TABLE IF NOT EXISTS `youtube_videos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(36) UNIQUE NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` LONGTEXT,
  `youtube_url` VARCHAR(500) NOT NULL,
  `youtube_video_id` VARCHAR(100),
  `thumbnail_url` VARCHAR(500),
  `category` VARCHAR(100),
  `is_active` TINYINT(1) DEFAULT 1,
  `is_featured` TINYINT(1) DEFAULT 0,
  `display_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_is_active` (`is_active`),
  INDEX `idx_is_featured` (`is_featured`),
  INDEX `idx_display_order` (`display_order`),
  INDEX `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
