<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_reviews extends Admin_Controller {

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

        // Get faculty list for filter dropdown
        $data['faculty_list'] = $this->Faculty_staff_model->get_all();

        // Get applied filters
        $data['filters'] = $filters;
        $data['page_title'] = 'Faculty Reviews';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/faculty_reviews/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * View single review details by UID
     */
    public function view($uid = null)
    {
        if (!$uid) {
            redirect('admin/faculty_reviews');
        }

        $data = $this->get_admin_data();
        $data['review'] = $this->Faculty_review_model->get_by_uid($uid);

        if (!$data['review']) {
            $this->session->set_flashdata('error', 'Review not found');
            redirect('admin/faculty_reviews');
        }

        $data['page_title'] = 'Review Details - ' . $data['review']->student_name;
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/faculty_reviews/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Approve a review by UID
     */
    public function approve($uid = null)
    {

        if (!$uid) {
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid review ID']);
            return;
        }

        if ($this->Faculty_review_model->update_status_by_uid($uid, 'approved')) {
            $this->session->set_flashdata('success', 'Review approved successfully');
            
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => true, 'message' => 'Review approved']);
            } else {
                redirect('admin/faculty_reviews');
            }
        } else {
            $this->session->set_flashdata('error', 'Failed to approve review');
            
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to approve review']);
            } else {
                redirect('admin/faculty_reviews');
            }
        }
    }

    /**
     * Reject a review by UID
     */
    public function reject($uid = null)
    {

        if (!$uid) {
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid review ID']);
            return;
        }

        if ($this->Faculty_review_model->update_status_by_uid($uid, 'rejected')) {
            $this->session->set_flashdata('success', 'Review rejected successfully');
            
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => true, 'message' => 'Review rejected']);
            } else {
                redirect('admin/faculty_reviews');
            }
        } else {
            $this->session->set_flashdata('error', 'Failed to reject review');
            
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to reject review']);
            } else {
                redirect('admin/faculty_reviews');
            }
        }
    }

    /**
     * Delete a review by UID
     */
    public function delete($uid = null)
    {

        if (!$uid) {
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid review ID']);
            return;
        }

        if ($this->Faculty_review_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Review deleted successfully');
            
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => true, 'message' => 'Review deleted']);
            } else {
                redirect('admin/faculty_reviews');
            }
        } else {
            $this->session->set_flashdata('error', 'Failed to delete review');
            
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to delete review']);
            } else {
                redirect('admin/faculty_reviews');
            }
        }
    }

    /**
     * Bulk action handler
     */
    public function bulk_action()
    {
        if (!$this->input->post('action') || !$this->input->post('reviews')) {
            $this->session->set_flashdata('error', 'No action or reviews selected');
            redirect('admin/faculty_reviews');
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

        redirect('admin/faculty_reviews');
    }

    /**
     * Export reviews to CSV
     */
    public function export()
    {
        $filters = [
            'status' => $this->input->get('status') ?: NULL,
            'faculty_id' => $this->input->get('faculty_id') ?: NULL
        ];

        $reviews = $this->Faculty_review_model->get_all(NULL, 0, $filters);

        // Create CSV
        $filename = 'faculty_reviews_' . date('Y-m-d_H-i-s') . '.csv';
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
