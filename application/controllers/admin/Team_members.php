<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_members extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Team_member_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Team Members';
        $data['active_template'] = get_active_template();
        
        $keyword = $this->input->get('keyword');
        if ($keyword) {
            $data['team_members'] = $this->Team_member_model->search($keyword, 100);
            $data['keyword'] = $keyword;
        } else {
            $data['team_members'] = $this->Team_member_model->get_all_by_theme(100);
            $data['keyword'] = '';
        }
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/team_members/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Team Member';
        $data['team_member'] = null;
        $data['active_template'] = get_active_template();
        $data['form_action'] = base_url('admin/team_members/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('member_type', 'Member Type', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email', TRUE);
                $first_name = $this->input->post('first_name', TRUE);
                $last_name = $this->input->post('last_name', TRUE);
                
                $slug = strtolower(trim($first_name . ' ' . $last_name));
                $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $slug);
                $slug = preg_replace('/^-|-$/', '', $slug);
                
                $original_slug = $slug;
                $counter = 1;
                while ($this->Team_member_model->get_by_slug($slug)) {
                    $slug = $original_slug . '-' . $counter++;
                }
                
                if ($email && $this->Team_member_model->email_exists($email)) {
                    $this->session->set_flashdata('error', 'This email address is already registered.');
                } else {
                    $social_links_post = $this->input->post('social_links', TRUE);
                    $social_links_json = !empty($social_links_post) ? json_encode(array_filter($social_links_post)) : '{}';
                    
                    $member_data = [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'slug' => $slug,
                        'title' => $this->input->post('title', TRUE),
                        'email' => $email,
                        'member_type' => $this->input->post('member_type', TRUE),
                        'specialization' => $this->input->post('specialization', TRUE),
                        'bio' => $this->input->post('bio', TRUE),
                        'phone' => $this->input->post('phone', TRUE),
                        'social_links' => $social_links_json,
                        'template' => $this->input->post('template', TRUE) ?: 'all',
                        'status' => $this->input->post('status', TRUE) ?: 'active',
                        'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                        'display_order' => $this->input->post('display_order', TRUE) ?: 0
                    ];

                    if (!empty($_FILES['photo']['name'])) {
                        $photo = $this->upload_photo();
                        if ($photo) {
                            $member_data['photo'] = $photo;
                        }
                    }

                    if ($this->Team_member_model->create($member_data)) {
                        $this->session->set_flashdata('success', 'Team member created successfully.');
                        redirect('admin/team_members');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to create team member.');
                    }
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/team_members/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $member = $this->Team_member_model->get_by_uid($uid);
        if (!$member) {
            $this->session->set_flashdata('error', 'Team member not found.');
            redirect('admin/team_members');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Team Member';
        $data['team_member'] = $member;
        $data['active_template'] = get_active_template();
        $data['form_action'] = base_url('admin/team_members/edit/' . $uid);

        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('member_type', 'Member Type', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email', TRUE);
                $first_name = $this->input->post('first_name', TRUE);
                $last_name = $this->input->post('last_name', TRUE);
                
                $slug = strtolower(trim($first_name . ' ' . $last_name));
                $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $slug);
                $slug = preg_replace('/^-|-$/', '', $slug);
                
                $original_slug = $slug;
                $counter = 1;
                $existing = $this->Team_member_model->get_by_slug($slug);
                while ($existing && $existing->id != $member->id) {
                    $slug = $original_slug . '-' . $counter++;
                    $existing = $this->Team_member_model->get_by_slug($slug);
                }
                
                if ($email && $this->Team_member_model->email_exists($email, $member->id)) {
                    $this->session->set_flashdata('error', 'This email address is already registered.');
                } else {
                    $social_links_post = $this->input->post('social_links', TRUE);
                    $social_links_json = !empty($social_links_post) ? json_encode(array_filter($social_links_post)) : '{}';
                    
                    $member_data = [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'slug' => $slug,
                        'title' => $this->input->post('title', TRUE),
                        'email' => $email,
                        'member_type' => $this->input->post('member_type', TRUE),
                        'specialization' => $this->input->post('specialization', TRUE),
                        'bio' => $this->input->post('bio', TRUE),
                        'phone' => $this->input->post('phone', TRUE),
                        'social_links' => $social_links_json,
                        'template' => $this->input->post('template', TRUE) ?: 'all',
                        'status' => $this->input->post('status', TRUE) ?: 'active',
                        'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                        'display_order' => $this->input->post('display_order', TRUE) ?: 0
                    ];

                    if (!empty($_FILES['photo']['name'])) {
                        $photo = $this->upload_photo();
                        if ($photo) {
                            if ($member->photo && file_exists('assets/images/team/' . $member->photo)) {
                                unlink('assets/images/team/' . $member->photo);
                            }
                            $member_data['photo'] = $photo;
                        }
                    }

                    if ($this->Team_member_model->update_by_uid($uid, $member_data)) {
                        $this->session->set_flashdata('success', 'Team member updated successfully.');
                        redirect('admin/team_members');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to update team member.');
                    }
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/team_members/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function view($uid)
    {
        $member = $this->Team_member_model->get_by_uid($uid);
        if (!$member) {
            $this->session->set_flashdata('error', 'Team member not found.');
            redirect('admin/team_members');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Team Member Details';
        $data['team_member'] = $member;
        $data['active_template'] = get_active_template();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/team_members/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        $member = $this->Team_member_model->get_by_uid($uid);
        if (!$member) {
            $this->session->set_flashdata('error', 'Team member not found.');
            redirect('admin/team_members');
        }

        if ($member->photo && file_exists('assets/images/team/' . $member->photo)) {
            unlink('assets/images/team/' . $member->photo);
        }

        if ($this->Team_member_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Team member deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete team member.');
        }

        redirect('admin/team_members');
    }

    public function toggle_status($uid)
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $member = $this->Team_member_model->get_by_uid($uid);
        if (!$member) {
            echo json_encode(['status' => 'error', 'message' => 'Team member not found']);
            return;
        }

        $statuses = ['active', 'inactive'];
        $current_index = array_search($member->status, $statuses);
        $new_status = $statuses[($current_index + 1) % count($statuses)];
        
        if ($this->Team_member_model->toggle_status_by_uid($uid, $new_status)) {
            echo json_encode(['status' => 'success', 'new_status' => $new_status]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
        }
    }

    private function upload_photo()
    {
        $config['upload_path']   = './assets/images/team/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 5120;
        $config['file_name']     = 'team_' . time() . '_' . substr(md5(uniqid()), 0, 8);

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('photo')) {
            log_message('error', 'Team member photo upload failed: ' . $this->upload->display_errors());
            return false;
        }

        $upload_data = $this->upload->data();
        return $upload_data['file_name'];
    }
}
