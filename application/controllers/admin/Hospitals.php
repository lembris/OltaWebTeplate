<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hospitals extends Admin_Controller 
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
        $data['page_title'] = 'Manage Hospital Partners';
        $data['active_template'] = get_active_template();
        $data['hospitals'] = $this->Partner_model->get_all(100, 0);
        $data['types'] = $this->Partner_model->get_types();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/hospitals/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Hospital Partner';
        $data['hospital'] = null;
        $data['types'] = $this->Partner_model->get_types();
        $data['form_action'] = base_url('admin/hospitals/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Hospital Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim|max_length[255]');

            if ($this->form_validation->run() === TRUE) {
                $hospital_data = [
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
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['logo']['name'])) {
                    $logo = $this->upload_image('logo');
                    if ($logo) {
                        $hospital_data['logo'] = $logo;
                    }
                }

                if ($this->Partner_model->create($hospital_data)) {
                    $this->session->set_flashdata('message', 'Hospital partner added successfully!');
                    $this->session->set_flashdata('message_type', 'success');
                    redirect(base_url('admin/hospitals'));
                    return;
                } else {
                    $this->session->set_flashdata('message', 'Error adding hospital!');
                    $this->session->set_flashdata('message_type', 'danger');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/hospitals/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Hospital Partner';
        $data['hospital'] = $this->Partner_model->get_by_uid($uid);
        $data['types'] = $this->Partner_model->get_types();
        $data['form_action'] = base_url('admin/hospitals/edit/' . $uid);

        if (!$data['hospital']) {
            $this->session->set_flashdata('message', 'Hospital not found!');
            $this->session->set_flashdata('message_type', 'danger');
            redirect(base_url('admin/hospitals'));
            return;
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Hospital Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim|max_length[255]');

            if ($this->form_validation->run() === TRUE) {
                $hospital_data = [
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
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['logo']['name'])) {
                    $logo = $this->upload_image('logo');
                    if ($logo) {
                        $hospital_data['logo'] = $logo;
                        if (!empty($data['hospital']->logo) && file_exists($this->upload_path . $data['hospital']->logo)) {
                            unlink($this->upload_path . $data['hospital']->logo);
                        }
                    }
                }

                if ($this->Partner_model->update_by_uid($uid, $hospital_data)) {
                    $this->session->set_flashdata('message', 'Hospital partner updated successfully!');
                    $this->session->set_flashdata('message_type', 'success');
                    redirect(base_url('admin/hospitals'));
                    return;
                } else {
                    $this->session->set_flashdata('message', 'Error updating hospital!');
                    $this->session->set_flashdata('message_type', 'danger');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/hospitals/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        $hospital = $this->Partner_model->get_by_uid($uid);
        if ($hospital) {
            if (!empty($hospital->logo) && file_exists($this->upload_path . $hospital->logo)) {
                unlink($this->upload_path . $hospital->logo);
            }
            $this->Partner_model->delete_by_uid($uid);
            $this->session->set_flashdata('message', 'Hospital partner deleted successfully!');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Hospital not found!');
            $this->session->set_flashdata('message_type', 'danger');
        }
        redirect(base_url('admin/hospitals'));
    }

    public function toggle_status($uid)
    {
        $hospital = $this->Partner_model->get_by_uid($uid);
        if ($hospital) {
            $new_status = $hospital->status === 'active' ? 'inactive' : 'active';
            $this->Partner_model->toggle_status_by_uid($uid, $new_status);
            $this->session->set_flashdata('message', 'Status updated successfully!');
            $this->session->set_flashdata('message_type', 'success');
        }
        redirect(base_url('admin/hospitals'));
    }

    public function toggle_featured($uid)
    {
        $hospital = $this->Partner_model->get_by_uid($uid);
        if ($hospital) {
            $new_featured = $hospital->is_featured ? 0 : 1;
            $this->Partner_model->toggle_featured_by_uid($uid, $new_featured);
            $this->session->set_flashdata('message', 'Featured status updated!');
            $this->session->set_flashdata('message_type', 'success');
        }
        redirect(base_url('admin/hospitals'));
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
