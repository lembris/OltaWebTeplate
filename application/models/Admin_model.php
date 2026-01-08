<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model 
{
    protected $table = 'admin_users';

    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('status', 'active');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get($this->table);

        if ($query->num_rows() === 1) {
            $admin = $query->row();
            if (password_verify($password, $admin->password)) {
                $this->update_last_login($admin->id);
                return $admin;
            }
        }
        return FALSE;
    }

    public function get_admin($id)
    {
        $this->db->where('id', $id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function get_admin_by_email($email)
    {
        $this->db->where('email', $email);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function get_admin_by_username($username)
    {
        $this->db->where('username', $username);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function get_all_admins()
    {
        $this->db->where('is_deleted', 0);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function get_active_admins()
    {
        $this->db->where('status', 'active');
        $this->db->where('is_deleted', 0);
        $this->db->order_by('full_name', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function create_admin($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function update_admin($id, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete_admin($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'is_deleted' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function update_last_login($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'last_login' => date('Y-m-d H:i:s')
        ]);
    }

    public function change_password($id, $new_password)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'password' => password_hash($new_password, PASSWORD_BCRYPT),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function verify_current_password($id, $current_password)
    {
        $admin = $this->get_admin($id);
        if ($admin) {
            return password_verify($current_password, $admin->password);
        }
        return FALSE;
    }

    public function check_username_exists($username, $exclude_id = NULL)
    {
        $this->db->where('username', $username);
        $this->db->where('is_deleted', 0);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    public function check_email_exists($email, $exclude_id = NULL)
    {
        $this->db->where('email', $email);
        $this->db->where('is_deleted', 0);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }
}
