<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_provider_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all SMS providers
     */
    public function get_all()
    {
        return $this->db->get('sms_providers')->result();
    }

    /**
     * Get all active SMS providers
     */
    public function get_active()
    {
        return $this->db->get_where('sms_providers', ['is_active' => 1])->result();
    }

    /**
     * Get provider by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where('sms_providers', ['id' => $id])->row();
    }

    /**
     * Get provider by name
     */
    public function get_by_name($name)
    {
        return $this->db->get_where('sms_providers', ['name' => $name])->row();
    }

    /**
     * Create new SMS provider
     */
    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('sms_providers', $data);
    }

    /**
     * Update SMS provider
     */
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('sms_providers', $data);
    }

    /**
     * Delete SMS provider
     */
    public function delete($id)
    {
        return $this->db->delete('sms_providers', ['id' => $id]);
    }

    /**
     * Toggle provider status
     */
    public function toggle_status($id)
    {
        $provider = $this->get_by_id($id);
        if ($provider) {
            return $this->update($id, ['is_active' => !$provider->is_active]);
        }
        return false;
    }

    /**
     * Get request params for SMS sending
     */
    public function get_request_params($id)
    {
        $provider = $this->get_by_id($id);
        if ($provider && $provider->request_params) {
            return json_decode($provider->request_params, true);
        }
        return [];
    }

    /**
     * Get API headers for SMS sending
     */
    public function get_api_headers($id)
    {
        $provider = $this->get_by_id($id);
        if ($provider && $provider->api_headers) {
            return json_decode($provider->api_headers, true);
        }
        return [];
    }

    /**
     * Decrypt API key (if encrypted)
     */
    public function get_decrypted_key($id)
    {
        $provider = $this->get_by_id($id);
        if ($provider) {
            // If using encryption library, decrypt here
            // For now, return as-is
            return $provider->api_key;
        }
        return null;
    }
}
