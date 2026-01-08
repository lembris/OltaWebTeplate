<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Only allow local access
        if ($this->input->ip_address() != '127.0.0.1' && $this->input->ip_address() != '::1' && $_SERVER['HTTP_HOST'] != 'localhost') {
            show_404();
        }
    }

    /**
     * Setup faculty reviews table and insert sample data
     */
    public function reviews()
    {
        // Create faculty_reviews table
        $sql = "CREATE TABLE IF NOT EXISTS `faculty_reviews` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `faculty_id` INT NOT NULL,
          `student_name` VARCHAR(255) NOT NULL,
          `email` VARCHAR(255),
          `rating` INT NOT NULL,
          `review_title` VARCHAR(255) NOT NULL,
          `review_text` LONGTEXT NOT NULL,
          `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
          `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `ip_address` VARCHAR(45),
          `user_id` INT,
          KEY `idx_faculty_id` (`faculty_id`),
          KEY `idx_status` (`status`),
          KEY `idx_created_at` (`created_at`),
          KEY `idx_rating` (`rating`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        if ($this->db->query($sql)) {
            echo "✓ Faculty reviews table created successfully!<br>";
        } else {
            $error = $this->db->error();
            if (strpos($error, "already exists") !== false) {
                echo "✓ Faculty reviews table already exists!<br>";
            } else {
                echo "✗ Error: " . $error . "<br>";
            }
        }
        
        echo "<br>";

        // Insert sample approved reviews
        $sample_reviews = [
            ['faculty_id' => 1, 'student_name' => 'John Smith', 'email' => 'john@example.com', 'rating' => 5, 'review_title' => 'Excellent teaching methodology', 'review_text' => 'Prof. Chen is very knowledgeable and makes complex topics easy to understand. Great lectures and always available for office hours.', 'status' => 'approved'],
            ['faculty_id' => 1, 'student_name' => 'Sarah Johnson', 'email' => 'sarah@example.com', 'rating' => 4, 'review_title' => 'Very inspiring and engaging professor', 'review_text' => 'Great insights into real-world applications. The assignments are challenging but help reinforce the concepts effectively.', 'status' => 'approved'],
            ['faculty_id' => 1, 'student_name' => 'Michael Davis', 'email' => 'michael@example.com', 'rating' => 5, 'review_title' => 'Highly recommended for all students', 'review_text' => 'One of the best professors in the department. Very organized, passionate about the subject, and truly cares about student success.', 'status' => 'approved'],
            ['faculty_id' => 2, 'student_name' => 'Emily White', 'email' => 'emily@example.com', 'rating' => 4, 'review_title' => 'Great explanation of complex concepts', 'review_text' => 'Professor Clark explains mathematics in a way that makes sense. Highly recommended for anyone struggling with math.', 'status' => 'approved'],
            ['faculty_id' => 3, 'student_name' => 'David Brown', 'email' => 'david@example.com', 'rating' => 5, 'review_title' => 'Outstanding business professor', 'review_text' => 'Jennifer Davis brings real-world experience to the classroom. Her business case studies are invaluable for understanding strategy.', 'status' => 'approved'],
        ];

        $inserted = 0;
        foreach ($sample_reviews as $review) {
            // Check if already exists
            $check = $this->db->where('faculty_id', $review['faculty_id'])
                            ->where('student_name', $review['student_name'])
                            ->get('faculty_reviews');
            
            if ($check->num_rows() == 0) {
                if ($this->db->insert('faculty_reviews', $review)) {
                    $inserted++;
                }
            }
        }

        echo "✓ Inserted $inserted sample reviews<br><br>";

        // Get statistics
        $total = $this->db->count_all('faculty_reviews');
        $pending = $this->db->where('status', 'pending')->count_all_results('faculty_reviews');
        $approved = $this->db->where('status', 'approved')->count_all_results('faculty_reviews');

        echo "<strong>Database Statistics:</strong><br>";
        echo "Total Reviews: $total<br>";
        echo "Pending Reviews: $pending<br>";
        echo "Approved Reviews: $approved<br><br>";

        echo "<strong>Setup Complete!</strong><br>";
        echo "<a href='" . base_url('faculty') . "'>Go to Faculty Page</a>";
    }
}
