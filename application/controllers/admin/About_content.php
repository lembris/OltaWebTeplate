<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_content extends Admin_Controller {

    private $upload_path = './assets/img/about/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('About_timeline_model');
        $this->load->model('About_accreditations_model');
        $this->load->model('About_faq_model');
        $this->load->helper('template');
        $this->load->library('form_validation');
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    public function timeline($action = 'index', $uid = null)
    {
        $model = $this->About_timeline_model;
        $data = $this->get_admin_data();
        $data['active_template'] = get_active_template();
        
        switch ($action) {
            case 'index':
                $data['items'] = $model->get_all_by_theme(100, 0);
                $data['page_title'] = 'Timeline / History';
                $data['section'] = 'timeline';
                $this->load->view('admin/layout/header', $data);
                $this->load->view('admin/layout/sidebar', $data);
                $this->load->view('admin/about_content/index', $data);
                $this->load->view('admin/layout/footer', $data);
                break;
                
            case 'create':
                $data['item'] = null;
                $data['page_title'] = 'Create Timeline Item';
                $data['section'] = 'timeline';
                $data['form_action'] = base_url('admin/about_content/timeline/create');
                
                if ($this->input->post()) {
                    $this->form_validation->set_rules('year', 'Year', 'required|trim');
                    $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
                    $this->form_validation->set_rules('description', 'Description', 'required|trim|min_length[10]');
                    
                    if ($this->form_validation->run() === TRUE) {
                        $item_data = [
                            'year' => $this->input->post('year', TRUE),
                            'title' => $this->input->post('title', TRUE),
                            'description' => $this->input->post('description', TRUE),
                            'icon' => $this->input->post('icon', TRUE) ?: 'fa-calendar',
                            'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                            'status' => $this->input->post('status', TRUE) ? 'active' : 'inactive',
                            'theme' => get_active_template()
                        ];
                        
                        if ($model->create($item_data)) {
                            $this->session->set_flashdata('success', 'Timeline item created successfully.');
                            redirect('admin/about_content/timeline');
                        } else {
                            $this->session->set_flashdata('error', 'Failed to create timeline item.');
                        }
                    }
                }
                
                $this->load->view('admin/layout/header', $data);
                $this->load->view('admin/layout/sidebar', $data);
                $this->load->view('admin/about_content/form', $data);
                $this->load->view('admin/layout/footer', $data);
                break;
                
            case 'edit':
                $data['item'] = $model->get_by_uid($uid);
                $data['page_title'] = 'Edit Timeline Item';
                $data['section'] = 'timeline';
                $data['form_action'] = base_url('admin/about_content/timeline/edit/' . $uid);
                
                if (!$data['item']) {
                    $this->session->set_flashdata('error', 'Timeline item not found.');
                    redirect('admin/about_content/timeline');
                    return;
                }
                
                if ($this->input->post()) {
                    $this->form_validation->set_rules('year', 'Year', 'required|trim');
                    $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
                    $this->form_validation->set_rules('description', 'Description', 'required|trim|min_length[10]');
                    
                    if ($this->form_validation->run() === TRUE) {
                        $item_data = [
                            'year' => $this->input->post('year', TRUE),
                            'title' => $this->input->post('title', TRUE),
                            'description' => $this->input->post('description', TRUE),
                            'icon' => $this->input->post('icon', TRUE) ?: 'fa-calendar',
                            'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                            'status' => $this->input->post('status', TRUE) ? 'active' : 'inactive',
                            'theme' => get_active_template()
                        ];
                        
                        if ($model->update_by_uid($uid, $item_data)) {
                            $this->session->set_flashdata('success', 'Timeline item updated successfully.');
                            redirect('admin/about_content/timeline');
                        } else {
                            $this->session->set_flashdata('error', 'Failed to update timeline item.');
                        }
                    }
                }
                
                $this->load->view('admin/layout/header', $data);
                $this->load->view('admin/layout/sidebar', $data);
                $this->load->view('admin/about_content/form', $data);
                $this->load->view('admin/layout/footer', $data);
                break;
                
            case 'delete':
                if ($this->input->method() !== 'post') {
                    $this->session->set_flashdata('error', 'Invalid request method.');
                    redirect('admin/about_content/timeline');
                    return;
                }
                
                if ($model->delete_by_uid($uid)) {
                    $this->session->set_flashdata('success', 'Timeline item deleted successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to delete timeline item.');
                }
                redirect('admin/about_content/timeline');
                break;
                
            case 'toggle':
                $item = $model->get_by_uid($uid);
                if (!$item) {
                    $this->session->set_flashdata('error', 'Timeline item not found.');
                    redirect('admin/about_content/timeline');
                    return;
                }
                
                $new_status = ($item->status === 'active') ? 'inactive' : 'active';
                if ($model->toggle_status_by_uid($uid, $new_status)) {
                    $this->session->set_flashdata('success', 'Status updated successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update status.');
                }
                redirect('admin/about_content/timeline');
                break;
                
            default:
                redirect('admin/about_content/timeline');
        }
    }

    public function accreditations($action = 'index', $uid = null)
    {
        $model = $this->About_accreditations_model;
        $data = $this->get_admin_data();
        $data['active_template'] = get_active_template();
        
        switch ($action) {
            case 'index':
                $data['items'] = $model->get_all_by_theme(100, 0);
                $data['page_title'] = 'Accreditations';
                $data['section'] = 'accreditations';
                $this->load->view('admin/layout/header', $data);
                $this->load->view('admin/layout/sidebar', $data);
                $this->load->view('admin/about_content/index', $data);
                $this->load->view('admin/layout/footer', $data);
                break;
                
            case 'create':
                $data['item'] = null;
                $data['page_title'] = 'Create Accreditation';
                $data['section'] = 'accreditations';
                $data['form_action'] = base_url('admin/about_content/accreditations/create');
                
                if ($this->input->post()) {
                    $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]');
                    
                    if ($this->form_validation->run() === TRUE) {
                        $logo = null;
                        if (!empty($_FILES['logo']['name'])) {
                            $logo = $this->upload_image('logo');
                        }
                        
                        $item_data = [
                            'name' => $this->input->post('name', TRUE),
                            'description' => $this->input->post('description', TRUE),
                            'website_url' => $this->input->post('website_url', TRUE),
                            'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                            'status' => $this->input->post('status', TRUE) ? 'active' : 'inactive',
                            'theme' => get_active_template()
                        ];
                        if ($logo) {
                            $item_data['logo'] = $logo;
                        }
                        
                        if ($model->create($item_data)) {
                            $this->session->set_flashdata('success', 'Accreditation created successfully.');
                            redirect('admin/about_content/accreditations');
                        } else {
                            $this->session->set_flashdata('error', 'Failed to create accreditation.');
                        }
                    }
                }
                
                $this->load->view('admin/layout/header', $data);
                $this->load->view('admin/layout/sidebar', $data);
                $this->load->view('admin/about_content/form', $data);
                $this->load->view('admin/layout/footer', $data);
                break;
                
            case 'edit':
                $data['item'] = $model->get_by_uid($uid);
                $data['page_title'] = 'Edit Accreditation';
                $data['section'] = 'accreditations';
                $data['form_action'] = base_url('admin/about_content/accreditations/edit/' . $uid);
                
                if (!$data['item']) {
                    $this->session->set_flashdata('error', 'Accreditation not found.');
                    redirect('admin/about_content/accreditations');
                    return;
                }
                
                if ($this->input->post()) {
                    $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]');
                    
                    if ($this->form_validation->run() === TRUE) {
                        $item_data = [
                            'name' => $this->input->post('name', TRUE),
                            'description' => $this->input->post('description', TRUE),
                            'website_url' => $this->input->post('website_url', TRUE),
                            'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                            'status' => $this->input->post('status', TRUE) ? 'active' : 'inactive',
                            'theme' => get_active_template()
                        ];
                        
                        if (!empty($_FILES['logo']['name'])) {
                            $logo = $this->upload_image('logo');
                            if ($logo) {
                                if ($data['item']->logo && file_exists($this->upload_path . $data['item']->logo)) {
                                    unlink($this->upload_path . $data['item']->logo);
                                }
                                $item_data['logo'] = $logo;
                            }
                        }
                        
                        if ($model->update_by_uid($uid, $item_data)) {
                            $this->session->set_flashdata('success', 'Accreditation updated successfully.');
                            redirect('admin/about_content/accreditations');
                        } else {
                            $this->session->set_flashdata('error', 'Failed to update accreditation.');
                        }
                    }
                }
                
                $this->load->view('admin/layout/header', $data);
                $this->load->view('admin/layout/sidebar', $data);
                $this->load->view('admin/about_content/form', $data);
                $this->load->view('admin/layout/footer', $data);
                break;
                
            case 'delete':
                if ($this->input->method() !== 'post') {
                    $this->session->set_flashdata('error', 'Invalid request method.');
                    redirect('admin/about_content/accreditations');
                    return;
                }
                
                $item = $model->get_by_uid($uid);
                if ($item && $item->logo && file_exists($this->upload_path . $item->logo)) {
                    unlink($this->upload_path . $item->logo);
                }
                if ($model->delete_by_uid($uid)) {
                    $this->session->set_flashdata('success', 'Accreditation deleted successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to delete accreditation.');
                }
                redirect('admin/about_content/accreditations');
                break;
                
            case 'toggle':
                $item = $model->get_by_uid($uid);
                if (!$item) {
                    $this->session->set_flashdata('error', 'Accreditation not found.');
                    redirect('admin/about_content/accreditations');
                    return;
                }
                
                $new_status = ($item->status === 'active') ? 'inactive' : 'active';
                if ($model->toggle_status_by_uid($uid, $new_status)) {
                    $this->session->set_flashdata('success', 'Status updated successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update status.');
                }
                redirect('admin/about_content/accreditations');
                break;
                
            default:
                redirect('admin/about_content/accreditations');
        }
    }

    public function faq($action = 'index', $uid = null)
    {
        $model = $this->About_faq_model;
        $data = $this->get_admin_data();
        $data['active_template'] = get_active_template();
        
        switch ($action) {
            case 'index':
                $data['items'] = $model->get_all_by_theme(100, 0);
                $data['page_title'] = 'FAQs';
                $data['section'] = 'faq';
                $this->load->view('admin/layout/header', $data);
                $this->load->view('admin/layout/sidebar', $data);
                $this->load->view('admin/about_content/index', $data);
                $this->load->view('admin/layout/footer', $data);
                break;
                
            case 'create':
                $data['item'] = null;
                $data['page_title'] = 'Create FAQ';
                $data['section'] = 'faq';
                $data['form_action'] = base_url('admin/about_content/faq/create');
                
                if ($this->input->post()) {
                    $this->form_validation->set_rules('question', 'Question', 'required|trim|min_length[5]');
                    $this->form_validation->set_rules('answer', 'Answer', 'required|trim|min_length[10]');
                    
                    if ($this->form_validation->run() === TRUE) {
                        $item_data = [
                            'question' => $this->input->post('question', TRUE),
                            'answer' => $this->input->post('answer', TRUE),
                            'category' => $this->input->post('category', TRUE),
                            'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                            'status' => $this->input->post('status', TRUE) ? 'active' : 'inactive',
                            'theme' => get_active_template()
                        ];
                        
                        if ($model->create($item_data)) {
                            $this->session->set_flashdata('success', 'FAQ created successfully.');
                            redirect('admin/about_content/faq');
                        } else {
                            $this->session->set_flashdata('error', 'Failed to create FAQ.');
                        }
                    }
                }
                
                $this->load->view('admin/layout/header', $data);
                $this->load->view('admin/layout/sidebar', $data);
                $this->load->view('admin/about_content/form', $data);
                $this->load->view('admin/layout/footer', $data);
                break;
                
            case 'edit':
                $data['item'] = $model->get_by_uid($uid);
                $data['page_title'] = 'Edit FAQ';
                $data['section'] = 'faq';
                $data['form_action'] = base_url('admin/about_content/faq/edit/' . $uid);
                
                if (!$data['item']) {
                    $this->session->set_flashdata('error', 'FAQ not found.');
                    redirect('admin/about_content/faq');
                    return;
                }
                
                if ($this->input->post()) {
                    $this->form_validation->set_rules('question', 'Question', 'required|trim|min_length[5]');
                    $this->form_validation->set_rules('answer', 'Answer', 'required|trim|min_length[10]');
                    
                    if ($this->form_validation->run() === TRUE) {
                        $item_data = [
                            'question' => $this->input->post('question', TRUE),
                            'answer' => $this->input->post('answer', TRUE),
                            'category' => $this->input->post('category', TRUE),
                            'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                            'status' => $this->input->post('status', TRUE) ? 'active' : 'inactive',
                            'theme' => get_active_template()
                        ];
                        
                        if ($model->update_by_uid($uid, $item_data)) {
                            $this->session->set_flashdata('success', 'FAQ updated successfully.');
                            redirect('admin/about_content/faq');
                        } else {
                            $this->session->set_flashdata('error', 'Failed to update FAQ.');
                        }
                    }
                }
                
                $this->load->view('admin/layout/header', $data);
                $this->load->view('admin/layout/sidebar', $data);
                $this->load->view('admin/about_content/form', $data);
                $this->load->view('admin/layout/footer', $data);
                break;
                
            case 'delete':
                if ($this->input->method() !== 'post') {
                    $this->session->set_flashdata('error', 'Invalid request method.');
                    redirect('admin/about_content/faq');
                    return;
                }
                
                if ($model->delete_by_uid($uid)) {
                    $this->session->set_flashdata('success', 'FAQ deleted successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to delete FAQ.');
                }
                redirect('admin/about_content/faq');
                break;
                
            case 'toggle':
                $item = $model->get_by_uid($uid);
                if (!$item) {
                    $this->session->set_flashdata('error', 'FAQ not found.');
                    redirect('admin/about_content/faq');
                    return;
                }
                
                $new_status = ($item->status === 'active') ? 'inactive' : 'active';
                if ($model->toggle_status_by_uid($uid, $new_status)) {
                    $this->session->set_flashdata('success', 'Status updated successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update status.');
                }
                redirect('admin/about_content/faq');
                break;
                
            default:
                redirect('admin/about_content/faq');
        }
    }

    private function upload_image($field_name)
    {
        $config['upload_path'] = $this->upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|svg|webp';
        $config['max_size'] = 2048;
        $config['file_ext_tolower'] = TRUE;
        $config['encrypt_name'] = TRUE;
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload($field_name)) {
            return $this->upload->data('file_name');
        }
        
        return NULL;
    }
}
