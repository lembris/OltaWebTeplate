<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notices extends Admin_Controller 
{
    private $upload_path = './assets/uploads/notices/';
    private $categories = [
        'General' => 'General',
        'Academic' => 'Academic',
        'Examination' => 'Examination',
        'Admission' => 'Admission',
        'Events' => 'Events',
        'Facilities' => 'Facilities',
        'Financial' => 'Financial',
        'Sports' => 'Sports',
        'Other' => 'Other'
    ];
    
    private $priorities = [
        'low' => 'Low',
        'normal' => 'Normal',
        'high' => 'High',
        'urgent' => 'Urgent'
    ];
    
    private $audiences = [
        'all' => 'Everyone',
        'students' => 'Students Only',
        'faculty' => 'Faculty Only',
        'staff' => 'Staff Only',
        'parents' => 'Parents Only'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notice_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Notices';
        $data['notices'] = $this->Notice_model->get_all(100, 0);
        $data['categories'] = $this->categories;
        $data['priorities'] = $this->priorities;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/notices/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Create Notice';
        $data['categories'] = $this->categories;
        $data['priorities'] = $this->priorities;
        $data['audiences'] = $this->audiences;
        $data['notice'] = null;
        $data['form_action'] = base_url('admin/notices/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('content', 'Content', 'required');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->generate_slug($this->input->post('title', TRUE));
                }

                $notice_data = [
                    'title' => $this->input->post('title', TRUE),
                    'slug' => $slug,
                    'category' => $this->input->post('category', TRUE),
                    'content' => $this->input->post('content'),
                    'excerpt' => $this->input->post('excerpt', TRUE),
                    'priority' => $this->input->post('priority', TRUE) ?: 'normal',
                    'target_audience' => $this->input->post('target_audience', TRUE) ?: 'all',
                    'start_date' => $this->input->post('start_date', TRUE) ?: null,
                    'end_date' => $this->input->post('end_date', TRUE) ?: null,
                    'published' => $this->input->post('published') ? 1 : 0,
                    'pinned' => $this->input->post('pinned') ? 1 : 0,
                    'created_by' => $this->session->userdata('admin_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['attachment']['name'])) {
                    $file = $this->upload_file('attachment');
                    if ($file) {
                        $notice_data['attachment'] = $file['file_name'];
                        $notice_data['attachment_name'] = $file['orig_name'];
                    }
                }

                if ($this->Notice_model->create($notice_data)) {
                    $this->session->set_flashdata('success', 'Notice created successfully.');
                    redirect('admin/notices');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create notice.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/notices/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $notice = $this->Notice_model->get_by_uid($uid);
        if (!$notice) {
            $this->session->set_flashdata('error', 'Notice not found.');
            redirect('admin/notices');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Notice';
        $data['categories'] = $this->categories;
        $data['priorities'] = $this->priorities;
        $data['audiences'] = $this->audiences;
        $data['notice'] = $notice;
        $data['form_action'] = base_url('admin/notices/edit/' . $uid);

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('content', 'Content', 'required');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->generate_slug($this->input->post('title', TRUE), $notice->id);
                }

                $notice_data = [
                    'title' => $this->input->post('title', TRUE),
                    'slug' => $slug,
                    'category' => $this->input->post('category', TRUE),
                    'content' => $this->input->post('content'),
                    'excerpt' => $this->input->post('excerpt', TRUE),
                    'priority' => $this->input->post('priority', TRUE) ?: 'normal',
                    'target_audience' => $this->input->post('target_audience', TRUE) ?: 'all',
                    'start_date' => $this->input->post('start_date', TRUE) ?: null,
                    'end_date' => $this->input->post('end_date', TRUE) ?: null,
                    'published' => $this->input->post('published') ? 1 : 0,
                    'pinned' => $this->input->post('pinned') ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['attachment']['name'])) {
                    $file = $this->upload_file('attachment');
                    if ($file) {
                        if (!empty($notice->attachment) && file_exists($this->upload_path . $notice->attachment)) {
                            @unlink($this->upload_path . $notice->attachment);
                        }
                        $notice_data['attachment'] = $file['file_name'];
                        $notice_data['attachment_name'] = $file['orig_name'];
                    }
                }

                if ($this->Notice_model->update_by_uid($uid, $notice_data)) {
                    $this->session->set_flashdata('success', 'Notice updated successfully.');
                    redirect('admin/notices');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update notice.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/notices/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        $notice = $this->Notice_model->get_by_uid($uid);
        if (!$notice) {
            $this->session->set_flashdata('error', 'Notice not found.');
            redirect('admin/notices');
        }

        if (!empty($notice->attachment) && file_exists($this->upload_path . $notice->attachment)) {
            @unlink($this->upload_path . $notice->attachment);
        }

        if ($this->Notice_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Notice deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete notice.');
        }

        redirect('admin/notices');
    }

    public function toggle_publish($uid)
    {
        $notice = $this->Notice_model->get_by_uid($uid);
        if (!$notice) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Notice not found']);
                exit;
            }
            $this->session->set_flashdata('error', 'Notice not found.');
            redirect('admin/notices');
        }

        $new_status = $notice->published ? 0 : 1;
        $result = $this->Notice_model->toggle_publish_by_uid($uid, $new_status);

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result,
                'published' => $new_status,
                'message' => $result ? 'Status updated successfully' : 'Failed to update status'
            ]);
            exit;
        }

        if ($result) {
            $this->session->set_flashdata('success', 'Notice status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status.');
        }
        redirect('admin/notices');
    }

    public function toggle_pinned($uid)
    {
        $notice = $this->Notice_model->get_by_uid($uid);
        if (!$notice) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Notice not found']);
                exit;
            }
            $this->session->set_flashdata('error', 'Notice not found.');
            redirect('admin/notices');
        }

        $new_status = $notice->pinned ? 0 : 1;
        $result = $this->Notice_model->toggle_pinned_by_uid($uid, $new_status);

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result,
                'pinned' => $new_status,
                'message' => $result ? 'Pin status updated successfully' : 'Failed to update pin status'
            ]);
            exit;
        }

        if ($result) {
            $this->session->set_flashdata('success', 'Notice pin status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update pin status.');
        }
        redirect('admin/notices');
    }

    private function upload_file($field_name)
    {
        $config = [
            'upload_path' => $this->upload_path,
            'allowed_types' => 'pdf|doc|docx|xls|xlsx|ppt|pptx|txt|jpg|jpeg|png|gif',
            'max_size' => 10240,
            'encrypt_name' => TRUE
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            return $this->upload->data();
        }

        $error_msg = $this->upload->display_errors('', '');
        log_message('error', 'Notice file upload failed: ' . $error_msg);
        $this->session->set_flashdata('error', 'File upload failed: ' . $error_msg);
        return false;
    }

    private function generate_slug($title, $exclude_id = null)
    {
        $slug = url_title($title, '-', TRUE);
        
        if ($this->Notice_model->slug_exists($slug, $exclude_id)) {
            $slug = $slug . '-' . time();
        }
        
        return $slug;
    }
}
