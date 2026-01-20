<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partners extends Admin_Controller 
{
    private $upload_path = './assets/img/partners/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Partner_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Partners';
        $data['active_template'] = get_active_template();
        $data['partners'] = $this->Partner_model->get_all(100, 0, get_active_template());
        $data['types'] = $this->Partner_model->get_types();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/partners/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Partner';
        $data['partner'] = null;
        $data['types'] = $this->Partner_model->get_types();
        $data['form_action'] = base_url('admin/partners/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Partner Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim|max_length[255]');

            if ($this->form_validation->run() === TRUE) {
                $partner_data = [
                    'name' => $this->input->post('name', TRUE),
                    'type' => $this->input->post('type', TRUE),
                    'short_description' => $this->input->post('short_description', TRUE),
                    'description' => $this->input->post('description'),
                    'website' => $this->input->post('website', TRUE),
                    'contact_email' => $this->input->post('contact_email', TRUE),
                    'contact_phone' => $this->input->post('contact_phone', TRUE),
                    'address' => $this->input->post('address'),
                    'country' => $this->input->post('country', TRUE),
                    'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'status' => $this->input->post('status') ? 'active' : 'inactive',
                    'template' => $this->input->post('template', TRUE) ?: get_active_template(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['logo']['name'])) {
                    $logo = $this->upload_image('logo');
                    if ($logo) {
                        $partner_data['logo'] = $logo;
                    }
                }

                if ($this->Partner_model->create($partner_data)) {
                    $this->session->set_flashdata('message', 'Partner added successfully!');
                    $this->session->set_flashdata('message_type', 'success');
                    redirect(base_url('admin/partners'));
                    return;
                } else {
                    $this->session->set_flashdata('message', 'Error adding partner!');
                    $this->session->set_flashdata('message_type', 'danger');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/partners/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Partner';
        $data['partner'] = $this->Partner_model->get_by_uid($uid);
        $data['types'] = $this->Partner_model->get_types();
        $data['form_action'] = base_url('admin/partners/edit/' . $uid);

        if (!$data['partner']) {
            $this->session->set_flashdata('message', 'Partner not found!');
            $this->session->set_flashdata('message_type', 'danger');
            redirect(base_url('admin/partners'));
            return;
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Partner Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim|max_length[255]');

            if ($this->form_validation->run() === TRUE) {
                $partner_data = [
                    'name' => $this->input->post('name', TRUE),
                    'type' => $this->input->post('type', TRUE),
                    'short_description' => $this->input->post('short_description', TRUE),
                    'description' => $this->input->post('description'),
                    'website' => $this->input->post('website', TRUE),
                    'contact_email' => $this->input->post('contact_email', TRUE),
                    'contact_phone' => $this->input->post('contact_phone', TRUE),
                    'address' => $this->input->post('address'),
                    'country' => $this->input->post('country', TRUE),
                    'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'status' => $this->input->post('status') ? 'active' : 'inactive',
                    'template' => $this->input->post('template', TRUE) ?: get_active_template(),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['logo']['name'])) {
                    $logo = $this->upload_image('logo');
                    if ($logo) {
                        $partner_data['logo'] = $logo;
                        if (!empty($data['partner']->logo) && file_exists($this->upload_path . $data['partner']->logo)) {
                            unlink($this->upload_path . $data['partner']->logo);
                        }
                    }
                }

                if ($this->Partner_model->update_by_uid($uid, $partner_data)) {
                    $this->session->set_flashdata('message', 'Partner updated successfully!');
                    $this->session->set_flashdata('message_type', 'success');
                    redirect(base_url('admin/partners'));
                    return;
                } else {
                    $this->session->set_flashdata('message', 'Error updating partner!');
                    $this->session->set_flashdata('message_type', 'danger');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/partners/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        $partner = $this->Partner_model->get_by_uid($uid);
        if ($partner) {
            if (!empty($partner->logo) && file_exists($this->upload_path . $partner->logo)) {
                unlink($this->upload_path . $partner->logo);
            }
            $this->Partner_model->delete_by_uid($uid);
            $this->session->set_flashdata('message', 'Partner deleted successfully!');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Partner not found!');
            $this->session->set_flashdata('message_type', 'danger');
        }
        redirect(base_url('admin/partners'));
    }

    public function toggle_status($uid)
    {
        $partner = $this->Partner_model->get_by_uid($uid);
        if ($partner) {
            $new_status = $partner->status === 'active' ? 'inactive' : 'active';
            $this->Partner_model->toggle_status_by_uid($uid, $new_status);
            $this->session->set_flashdata('message', 'Status updated successfully!');
            $this->session->set_flashdata('message_type', 'success');
        }
        redirect(base_url('admin/partners'));
    }

    public function toggle_featured($uid)
    {
        $partner = $this->Partner_model->get_by_uid($uid);
        if ($partner) {
            $new_featured = $partner->is_featured ? 0 : 1;
            $this->Partner_model->toggle_featured_by_uid($uid, $new_featured);
            $this->session->set_flashdata('message', 'Featured status updated!');
            $this->session->set_flashdata('message_type', 'success');
        }
        redirect(base_url('admin/partners'));
    }

    private function upload_image($field_name)
    {
        $config['upload_path'] = $this->upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048;
        $config['file_ext_tolower'] = TRUE;
        $config['file_name'] = time() . '_' . rand(1000, 9999);

        $this->upload->initialize($config);
        if ($this->upload->do_upload($field_name)) {
            return $this->upload->data('file_name');
        }
        return FALSE;
    }
}
