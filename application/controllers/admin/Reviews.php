<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Faculty_review_model');
        $this->load->model('Faculty_staff_model');
    }

    /**
     * List all reviews with filters filtered by active theme
     */
    public function index()
    {
        $data = $this->get_admin_data();
        
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 15;
        $offset = ($page - 1) * $limit;

        // Get active template
        $data['active_template'] = get_active_template();

        // Get filters
        $filters = [
            'theme' => $data['active_template'],
            'type' => $this->input->get('type') ?: NULL,
            'status' => $this->input->get('status') ?: NULL,
            'faculty_id' => $this->input->get('faculty_id') ?: NULL,
            'rating' => $this->input->get('rating') ?: NULL,
            'search' => $this->input->get('search') ?: NULL
        ];

        $data['reviews'] = $this->Faculty_review_model->get_all($limit, $offset, $filters);
        $total = $this->Faculty_review_model->count_all($filters);
        $data['total_pages'] = ceil($total / $limit);
        $data['current_page'] = $page;
        $data['total'] = $total;

        // Get statistics
        $data['stats'] = $this->Faculty_review_model->get_statistics($data['active_template']);

        // Get review types for filter dropdown
        $data['review_types'] = $this->Faculty_review_model->get_types_by_theme($data['active_template']);
        
        // Check if this theme has faculty-related reviews
        $data['has_faculty_reviews'] = $this->Faculty_review_model->theme_has_faculty_reviews($data['active_template']);

        // Get faculty list for filter dropdown (only if needed)
        $data['faculty_list'] = $data['has_faculty_reviews'] ? $this->Faculty_staff_model->get_all() : [];

        // Get applied filters
        $data['filters'] = $filters;
        $data['page_title'] = 'Reviews';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/reviews/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * View single review details by UID
     */
    public function view($uid = null)
    {
        if (!$uid) {
            redirect('admin/reviews');
        }

        $data = $this->get_admin_data();
        $data['review'] = $this->Faculty_review_model->get_by_uid($uid);

        if (!$data['review']) {
            $this->session->set_flashdata('error', 'Review not found');
            redirect('admin/reviews');
        }

        $data['page_title'] = 'Review Details - ' . $data['review']->student_name;
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/reviews/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Approve a review by UID
     */
    public function approve($uid = null)
    {
        if (!$uid) {
            $this->session->set_flashdata('error', 'Invalid review ID');
            redirect('admin/reviews');
        }

        $review = $this->Faculty_review_model->get_by_uid($uid);
        if (!$review) {
            $this->session->set_flashdata('error', 'Review not found');
            redirect('admin/reviews');
        }

        if ($this->Faculty_review_model->update_status_by_uid($uid, 'approved')) {
            $this->session->set_flashdata('success', 'Review approved successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to approve review');
        }

        redirect('admin/reviews');
    }

    /**
     * Reject a review by UID
     */
    public function reject($uid = null)
    {
        if (!$uid) {
            $this->session->set_flashdata('error', 'Invalid review ID');
            redirect('admin/reviews');
        }

        $review = $this->Faculty_review_model->get_by_uid($uid);
        if (!$review) {
            $this->session->set_flashdata('error', 'Review not found');
            redirect('admin/reviews');
        }

        if ($this->Faculty_review_model->update_status_by_uid($uid, 'rejected')) {
            $this->session->set_flashdata('success', 'Review rejected successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to reject review');
        }

        redirect('admin/reviews');
    }

    /**
     * Delete a review by UID
     */
    public function delete($uid = null)
    {
        if (!$uid) {
            $this->session->set_flashdata('error', 'Invalid review ID');
            redirect('admin/reviews');
        }

        $review = $this->Faculty_review_model->get_by_uid($uid);
        if (!$review) {
            $this->session->set_flashdata('error', 'Review not found');
            redirect('admin/reviews');
        }

        if ($this->Faculty_review_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Review deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete review');
        }

        redirect('admin/reviews');
    }

    /**
     * Bulk action handler
     */
    public function bulk_action()
    {
        if (!$this->input->post('action') || !$this->input->post('reviews')) {
            $this->session->set_flashdata('error', 'No action or reviews selected');
            redirect('admin/reviews');
            return;
        }

        $action = $this->input->post('action');
        $reviews = $this->input->post('reviews');

        if (!is_array($reviews)) {
            $reviews = [$reviews];
        }

        $success_count = 0;
        foreach ($reviews as $review_id) {
            $review_id = (int)$review_id;
            
            switch ($action) {
                case 'approve':
                    if ($this->Faculty_review_model->update_status($review_id, 'approved')) {
                        $success_count++;
                    }
                    break;
                    
                case 'reject':
                    if ($this->Faculty_review_model->update_status($review_id, 'rejected')) {
                        $success_count++;
                    }
                    break;
                    
                case 'delete':
                    if ($this->Faculty_review_model->delete($review_id)) {
                        $success_count++;
                    }
                    break;
            }
        }

        if ($success_count > 0) {
            $this->session->set_flashdata('success', "$success_count review(s) {$action}ed successfully");
        } else {
            $this->session->set_flashdata('error', 'No reviews were updated');
        }

        redirect('admin/reviews');
    }

    /**
     * Export reviews to CSV
     */
    public function export()
    {
        $filters = [
            'theme' => get_active_template(),
            'status' => $this->input->get('status') ?: NULL,
            'faculty_id' => $this->input->get('faculty_id') ?: NULL
        ];

        $reviews = $this->Faculty_review_model->get_all(NULL, 0, $filters);

        // Create CSV
        $filename = 'reviews_' . date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Faculty', 'Student Name', 'Email', 'Rating', 'Title', 'Review', 'Status', 'Date']);

        foreach ($reviews as $review) {
            fputcsv($output, [
                $review->id,
                $review->first_name . ' ' . $review->last_name,
                $review->student_name,
                $review->email,
                $review->rating,
                $review->review_title,
                $review->review_text,
                ucfirst($review->status),
                date('Y-m-d H:i', strtotime($review->created_at))
            ]);
        }

        fclose($output);
        exit;
    }
}
