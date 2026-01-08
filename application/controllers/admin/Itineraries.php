<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itineraries extends Admin_Controller 
{
    private $upload_path = './assets/img/itineraries/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Itinerary_model', 'Package_model']);
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Itineraries';
        $data['packages'] = $this->Itinerary_model->get_all_itineraries_admin();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/itineraries/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function manage($uid)
    {
        $package = $this->Package_model->get_package_admin_by_uid($uid);
        if (!$package) {
            $this->session->set_flashdata('error', 'Package not found.');
            redirect('admin/itineraries');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Itinerary - ' . $package->name;
        $data['package'] = $package;
        $data['days'] = $this->Itinerary_model->get_package_itinerary($package->id);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/itineraries/manage', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create($uid)
    {
        $package = $this->Package_model->get_package_admin_by_uid($uid);
        if (!$package) {
            $this->session->set_flashdata('error', 'Package not found.');
            redirect('admin/itineraries');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Itinerary Day - ' . $package->name;
        $data['package'] = $package;
        $data['day'] = null;
        $data['next_day_number'] = $this->Itinerary_model->get_next_day_number($package->id);
        $data['form_action'] = base_url('admin/itineraries/create/' . $uid);

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('day_number', 'Day Number', 'required|integer|greater_than_equal_to[0]');

            if ($this->form_validation->run() === TRUE) {
                $day_data = [
                    'package_id' => $package->id,
                    'day_number' => $this->input->post('day_number'),
                    'title' => $this->input->post('title', TRUE),
                    'description' => $this->input->post('description'),
                    'accommodation' => $this->input->post('accommodation_type', TRUE),
                    'activities' => $this->input->post('activities'),
                    'meals' => $this->format_meals($this->input->post('meals'))
                ];

                $day_id = $this->Itinerary_model->create_itinerary_day($day_data);

                if ($day_id) {
                    $this->session->set_flashdata('success', 'Itinerary day added successfully.');
                    redirect('admin/itineraries/manage/' . $package->uid);
                } else {
                    $this->session->set_flashdata('error', 'Failed to add itinerary day.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/itineraries/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $day = $this->Itinerary_model->get_by_uid($uid);
        if (!$day) {
            $this->session->set_flashdata('error', 'Itinerary day not found.');
            redirect('admin/itineraries');
        }

        $package = $this->Package_model->get_package_admin($day->package_id);
        if (!$package) {
            $this->session->set_flashdata('error', 'Package not found.');
            redirect('admin/itineraries');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Itinerary Day - ' . $package->name;
        $data['package'] = $package;
        $data['day'] = $day;
        $data['next_day_number'] = $day->day_number;
        $data['form_action'] = base_url('admin/itineraries/edit/' . $uid);

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('day_number', 'Day Number', 'required|integer|greater_than_equal_to[0]');

            if ($this->form_validation->run() === TRUE) {
                $day_data = [
                    'day_number' => $this->input->post('day_number'),
                    'title' => $this->input->post('title', TRUE),
                    'description' => $this->input->post('description'),
                    'accommodation' => $this->input->post('accommodation_type', TRUE),
                    'activities' => $this->input->post('activities'),
                    'meals' => $this->format_meals($this->input->post('meals'))
                ];

                if ($this->Itinerary_model->update_itinerary_day($day->id, $day_data)) {
                    $this->session->set_flashdata('success', 'Itinerary day updated successfully.');
                    redirect('admin/itineraries/manage/' . $package->uid);
                } else {
                    $this->session->set_flashdata('error', 'Failed to update itinerary day.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/itineraries/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $day = $this->Itinerary_model->get_by_uid($uid);
        if (!$day) {
            echo json_encode([
                'success' => false, 
                'message' => 'Day not found',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
            return;
        }

        if ($this->Itinerary_model->delete_itinerary_day($day->id)) {
            echo json_encode([
                'success' => true, 
                'message' => 'Day deleted successfully',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Failed to delete day',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
        }
    }

    public function reorder()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $package_id = $this->input->post('package_id');
        $order = $this->input->post('order');

        if (!$package_id || !$order || !is_array($order)) {
            echo json_encode([
                'success' => false, 
                'message' => 'Invalid data',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
            return;
        }

        if ($this->Itinerary_model->reorder_itinerary($package_id, $order)) {
            echo json_encode([
                'success' => true, 
                'message' => 'Order updated successfully',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Failed to update order',
                'csrf_hash' => $this->security->get_csrf_hash()
            ]);
        }
    }

    private function upload_image($field_name)
    {
        $config = [
            'upload_path' => $this->upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 2048,
            'encrypt_name' => TRUE
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }

        $this->session->set_flashdata('warning', 'Image upload failed: ' . $this->upload->display_errors('', ''));
        return false;
    }

    private function format_meals($meals)
    {
        if (empty($meals) || !is_array($meals)) {
            return '';
        }
        return implode(',', array_values($meals));
    }
}
