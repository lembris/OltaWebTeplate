<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcements extends Admin_Controller 
{
    private $upload_path = './assets/uploads/announcements/';
    
    private $types = [
        'info' => 'Information (Blue)',
        'success' => 'Success (Green)',
        'warning' => 'Warning (Yellow)',
        'danger' => 'Alert (Red)'
    ];
    
    private $icons = [
        'fa-bullhorn' => 'Bullhorn',
        'fa-bell' => 'Bell',
        'fa-info-circle' => 'Info Circle',
        'fa-exclamation-triangle' => 'Warning Triangle',
        'fa-check-circle' => 'Check Circle',
        'fa-star' => 'Star',
        'fa-gift' => 'Gift',
        'fa-calendar' => 'Calendar',
        'fa-graduation-cap' => 'Graduation Cap',
        'fa-book' => 'Book',
        'fa-users' => 'Users',
        'fa-trophy' => 'Trophy',
        'fa-heart' => 'Heart',
        'fa-lightbulb' => 'Lightbulb'
    ];
    
    private $locations = [
        'homepage' => 'Homepage',
        'header' => 'Header Banner',
        'sidebar' => 'Sidebar',
        'footer' => 'Footer',
        'popup' => 'Popup Modal'
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
        $this->load->model('Announcement_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Announcements';
        $data['announcements'] = $this->Announcement_model->get_all(100, 0);
        $data['types'] = $this->types;
        $data['locations'] = $this->locations;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/announcements/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Create Announcement';
        $data['types'] = $this->types;
        $data['icons'] = $this->icons;
        $data['locations'] = $this->locations;
        $data['audiences'] = $this->audiences;
        $data['announcement'] = null;
        $data['form_action'] = base_url('admin/announcements/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('content', 'Content', 'required');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->generate_slug($this->input->post('title', TRUE));
                }

                $display_locations = $this->input->post('display_location');
                $display_location = is_array($display_locations) ? implode(',', $display_locations) : $display_locations;

                $announcement_data = [
                    'title' => $this->input->post('title', TRUE),
                    'slug' => $slug,
                    'content' => $this->input->post('content'),
                    'excerpt' => $this->input->post('excerpt', TRUE),
                    'type' => $this->input->post('type', TRUE) ?: 'info',
                    'icon' => $this->input->post('icon', TRUE) ?: 'fa-bullhorn',
                    'link_url' => $this->input->post('link_url', TRUE),
                    'link_text' => $this->input->post('link_text', TRUE),
                    'display_location' => $display_location,
                    'target_audience' => $this->input->post('target_audience', TRUE) ?: 'all',
                    'start_date' => $this->input->post('start_date', TRUE) ?: null,
                    'end_date' => $this->input->post('end_date', TRUE) ?: null,
                    'sort_order' => $this->input->post('sort_order', TRUE) ?: 0,
                    'published' => $this->input->post('published') ? 1 : 0,
                    'created_by' => $this->session->userdata('admin_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['image']['name'])) {
                    $image = $this->upload_image('image');
                    if ($image) {
                        $announcement_data['image'] = $image;
                    }
                }

                if ($this->Announcement_model->create($announcement_data)) {
                    $this->session->set_flashdata('success', 'Announcement created successfully.');
                    redirect('admin/announcements');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create announcement.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/announcements/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $announcement = $this->Announcement_model->get_by_uid($uid);
        if (!$announcement) {
            $this->session->set_flashdata('error', 'Announcement not found.');
            redirect('admin/announcements');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Announcement';
        $data['types'] = $this->types;
        $data['icons'] = $this->icons;
        $data['locations'] = $this->locations;
        $data['audiences'] = $this->audiences;
        $data['announcement'] = $announcement;
        $data['form_action'] = base_url('admin/announcements/edit/' . $uid);

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('content', 'Content', 'required');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->generate_slug($this->input->post('title', TRUE), $announcement->id);
                }

                $display_locations = $this->input->post('display_location');
                $display_location = is_array($display_locations) ? implode(',', $display_locations) : $display_locations;

                $announcement_data = [
                    'title' => $this->input->post('title', TRUE),
                    'slug' => $slug,
                    'content' => $this->input->post('content'),
                    'excerpt' => $this->input->post('excerpt', TRUE),
                    'type' => $this->input->post('type', TRUE) ?: 'info',
                    'icon' => $this->input->post('icon', TRUE) ?: 'fa-bullhorn',
                    'link_url' => $this->input->post('link_url', TRUE),
                    'link_text' => $this->input->post('link_text', TRUE),
                    'display_location' => $display_location,
                    'target_audience' => $this->input->post('target_audience', TRUE) ?: 'all',
                    'start_date' => $this->input->post('start_date', TRUE) ?: null,
                    'end_date' => $this->input->post('end_date', TRUE) ?: null,
                    'sort_order' => $this->input->post('sort_order', TRUE) ?: 0,
                    'published' => $this->input->post('published') ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['image']['name'])) {
                    $image = $this->upload_image('image');
                    if ($image) {
                        if (!empty($announcement->image) && file_exists($this->upload_path . $announcement->image)) {
                            @unlink($this->upload_path . $announcement->image);
                        }
                        $announcement_data['image'] = $image;
                    }
                }

                if ($this->Announcement_model->update_by_uid($uid, $announcement_data)) {
                    $this->session->set_flashdata('success', 'Announcement updated successfully.');
                    redirect('admin/announcements');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update announcement.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/announcements/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        $announcement = $this->Announcement_model->get_by_uid($uid);
        if (!$announcement) {
            $this->session->set_flashdata('error', 'Announcement not found.');
            redirect('admin/announcements');
        }

        if (!empty($announcement->image) && file_exists($this->upload_path . $announcement->image)) {
            @unlink($this->upload_path . $announcement->image);
        }

        if ($this->Announcement_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Announcement deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete announcement.');
        }

        redirect('admin/announcements');
    }

    public function toggle_publish($uid)
    {
        $announcement = $this->Announcement_model->get_by_uid($uid);
        if (!$announcement) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Announcement not found']);
                exit;
            }
            $this->session->set_flashdata('error', 'Announcement not found.');
            redirect('admin/announcements');
        }

        $new_status = $announcement->published ? 0 : 1;
        $result = $this->Announcement_model->toggle_publish_by_uid($uid, $new_status);

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
            $this->session->set_flashdata('success', 'Announcement status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status.');
        }
        redirect('admin/announcements');
    }

    public function update_order()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $items = $this->input->post('items');
        if (!empty($items) && is_array($items)) {
            $result = $this->Announcement_model->update_sort_order($items);
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Order updated successfully' : 'Failed to update order'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
        }
    }

    private function upload_image($field_name)
    {
        $config = [
            'upload_path' => $this->upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 5120,
            'encrypt_name' => TRUE
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }

        $error_msg = $this->upload->display_errors('', '');
        log_message('error', 'Announcement image upload failed: ' . $error_msg);
        $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
        return false;
    }

    private function generate_slug($title, $exclude_id = null)
    {
        $slug = url_title($title, '-', TRUE);
        
        if ($this->Announcement_model->slug_exists($slug, $exclude_id)) {
            $slug = $slug . '-' . time();
        }
        
        return $slug;
    }
}
