<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactGroups extends Admin_Controller 
{
    private $icons = [
        'fa-users' => 'Users Group',
        'fa-user-graduate' => 'Graduate',
        'fa-chalkboard-teacher' => 'Teacher',
        'fa-users-cog' => 'Staff',
        'fa-user-tie' => 'Business/Professional',
        'fa-user-friends' => 'Friends/Family',
        'fa-graduation-cap' => 'Graduation Cap',
        'fa-building' => 'Building/Department',
        'fa-university' => 'University',
        'fa-briefcase' => 'Briefcase',
        'fa-id-card' => 'ID Card',
        'fa-address-book' => 'Address Book'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ContactGroup_model');
        $this->load->library(['form_validation']);
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Contact Groups';
        $data['groups'] = $this->ContactGroup_model->get_all_with_counts();
        $data['icons'] = $this->icons;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/contact-groups/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Create Contact Group';
        $data['icons'] = $this->icons;
        $data['group'] = null;
        $data['form_action'] = base_url('admin/contact-groups/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Group Name', 'required|trim|min_length[2]');

            if ($this->form_validation->run() === TRUE) {
                $group_data = [
                    'name' => $this->input->post('name', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'color' => $this->input->post('color', TRUE) ?: '#0d6efd',
                    'icon' => $this->input->post('icon', TRUE) ?: 'fa-users',
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'created_by' => $this->session->userdata('admin_id'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $group_id = $this->ContactGroup_model->create($group_data);
                
                if ($group_id) {
                    $group = $this->ContactGroup_model->get_by_id($group_id);
                    $this->session->set_flashdata('success', 'Contact group created successfully.');
                    redirect('admin/contact-groups/members/' . $group->uid);
                } else {
                    $this->session->set_flashdata('error', 'Failed to create contact group.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/contact-groups/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $group = $this->ContactGroup_model->get_by_uid($uid);
        if (!$group) {
            $this->session->set_flashdata('error', 'Contact group not found.');
            redirect('admin/contact-groups');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Contact Group';
        $data['icons'] = $this->icons;
        $data['group'] = $group;
        $data['form_action'] = base_url('admin/contact-groups/edit/' . $uid);

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Group Name', 'required|trim|min_length[2]');

            if ($this->form_validation->run() === TRUE) {
                $group_data = [
                    'name' => $this->input->post('name', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'color' => $this->input->post('color', TRUE) ?: '#0d6efd',
                    'icon' => $this->input->post('icon', TRUE) ?: 'fa-users',
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->ContactGroup_model->update_by_uid($uid, $group_data)) {
                    $this->session->set_flashdata('success', 'Contact group updated successfully.');
                    redirect('admin/contact-groups');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update contact group.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/contact-groups/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        $group = $this->ContactGroup_model->get_by_uid($uid);
        if (!$group) {
            $this->session->set_flashdata('error', 'Contact group not found.');
            redirect('admin/contact-groups');
        }

        if ($this->ContactGroup_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Contact group deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete contact group.');
        }

        redirect('admin/contact-groups');
    }

    public function toggle_status($uid)
    {
        $group = $this->ContactGroup_model->get_by_uid($uid);
        if (!$group) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Group not found']);
                exit;
            }
            redirect('admin/contact-groups');
        }

        $result = $this->ContactGroup_model->toggle_status($group->id);

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Status updated successfully' : 'Failed to update status'
            ]);
            exit;
        }

        if ($result) {
            $this->session->set_flashdata('success', 'Group status updated.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status.');
        }
        redirect('admin/contact-groups');
    }

    // ===== MEMBERS MANAGEMENT =====

    public function members($uid)
    {
        $group = $this->ContactGroup_model->get_by_uid($uid);
        if (!$group) {
            $this->session->set_flashdata('error', 'Contact group not found.');
            redirect('admin/contact-groups');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Members - ' . $group->name;
        $data['group'] = $group;
        $data['members'] = $this->ContactGroup_model->get_members($group->id, false);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/contact-groups/members', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function add_member($uid)
    {
        $group = $this->ContactGroup_model->get_by_uid($uid);
        if (!$group) {
            $this->session->set_flashdata('error', 'Contact group not found.');
            redirect('admin/contact-groups');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');

            if ($this->form_validation->run() === TRUE) {
                $member_data = [
                    'name' => $this->input->post('name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'designation' => $this->input->post('designation', TRUE),
                    'department' => $this->input->post('department', TRUE),
                    'notes' => $this->input->post('notes', TRUE),
                    'is_active' => 1
                ];

                if ($this->ContactGroup_model->add_member($group->id, $member_data)) {
                    $this->session->set_flashdata('success', 'Member added successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add member.');
                }
            }
        }

        redirect('admin/contact-groups/members/' . $uid);
    }

    public function edit_member($member_uid)
    {
        $member = $this->ContactGroup_model->get_member_by_uid($member_uid);
        if (!$member) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Member not found']);
                exit;
            }
            $this->session->set_flashdata('error', 'Member not found.');
            redirect('admin/contact-groups');
        }

        $group = $this->ContactGroup_model->get_by_id($member->group_id);

        if ($this->input->post()) {
            $member_data = [
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'designation' => $this->input->post('designation', TRUE),
                'department' => $this->input->post('department', TRUE),
                'notes' => $this->input->post('notes', TRUE)
            ];

            if ($this->ContactGroup_model->update_member_by_uid($member_uid, $member_data)) {
                $this->session->set_flashdata('success', 'Member updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update member.');
            }
        }

        redirect('admin/contact-groups/members/' . $group->uid);
    }

    public function delete_member($member_uid)
    {
        $member = $this->ContactGroup_model->get_member_by_uid($member_uid);
        if (!$member) {
            $this->session->set_flashdata('error', 'Member not found.');
            redirect('admin/contact-groups');
        }

        $group = $this->ContactGroup_model->get_by_id($member->group_id);

        if ($this->ContactGroup_model->delete_member_by_uid($member_uid)) {
            $this->session->set_flashdata('success', 'Member deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete member.');
        }

        redirect('admin/contact-groups/members/' . $group->uid);
    }

    public function toggle_member_status($member_uid)
    {
        $member = $this->ContactGroup_model->get_member_by_uid($member_uid);
        if (!$member) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Member not found']);
                exit;
            }
            redirect('admin/contact-groups');
        }

        $group = $this->ContactGroup_model->get_by_id($member->group_id);
        $result = $this->ContactGroup_model->toggle_member_status_by_uid($member_uid);

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Status updated' : 'Failed to update'
            ]);
            exit;
        }

        redirect('admin/contact-groups/members/' . $group->uid);
    }

    public function import_members($uid)
    {
        $group = $this->ContactGroup_model->get_by_uid($uid);
        if (!$group) {
            $this->session->set_flashdata('error', 'Contact group not found.');
            redirect('admin/contact-groups');
        }

        if ($this->input->post() && !empty($_FILES['csv_file']['name'])) {
            $file = $_FILES['csv_file']['tmp_name'];
            
            if (($handle = fopen($file, 'r')) !== FALSE) {
                $header = fgetcsv($handle);
                $csv_data = [];
                
                while (($row = fgetcsv($handle)) !== FALSE) {
                    $item = [];
                    foreach ($header as $i => $column) {
                        $col_lower = strtolower(trim($column));
                        $item[$col_lower] = $row[$i] ?? '';
                    }
                    $csv_data[] = $item;
                }
                fclose($handle);

                $result = $this->ContactGroup_model->import_members($group->id, $csv_data);
                $this->session->set_flashdata('success', "Import complete: {$result['imported']} imported, {$result['skipped']} skipped.");
            } else {
                $this->session->set_flashdata('error', 'Failed to read CSV file.');
            }
        }

        redirect('admin/contact-groups/members/' . $uid);
    }

    public function get_member_json($member_uid)
    {
        $member = $this->ContactGroup_model->get_member_by_uid($member_uid);
        header('Content-Type: application/json');
        echo json_encode($member);
    }
}
