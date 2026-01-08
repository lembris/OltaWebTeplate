<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

    protected $table = 'site_settings';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all settings for the active template
     * Template-specific settings override shared settings
     * 
     * @param string $template Template name (null = shared only)
     * @return array Key-value array of settings
     */
    public function get_all($template = null)
    {
        // First get shared settings (where template is NULL or empty)
        $this->db->where('template IS NULL OR template = ""', null, false);
        $query = $this->db->get($this->table);
        $result = [];
        
        foreach ($query->result() as $row) {
            $result[$row->setting_key] = $row->setting_value;
        }
        
        // Then overlay template-specific settings if template provided
        if ($template) {
            $this->db->where('template', $template);
            $query = $this->db->get($this->table);
            
            foreach ($query->result() as $row) {
                $result[$row->setting_key] = $row->setting_value;
            }
        }
        
        return $result;
    }

    /**
     * Get a specific setting value
     * Checks template-specific first, then falls back to shared
     * 
     * @param string $key Setting key
     * @param string $template Template name (optional)
     * @return string|null Setting value or null
     */
    public function get($key, $template = null)
    {
        // Try template-specific first
        if ($template) {
            $this->db->where('setting_key', $key);
            $this->db->where('template', $template);
            $query = $this->db->get($this->table);
            
            if ($query->num_rows() > 0) {
                return $query->row()->setting_value;
            }
        }
        
        // Fall back to shared setting
        $this->db->where('setting_key', $key);
        $this->db->where('template IS NULL OR template = ""', null, false);
        $query = $this->db->get($this->table);
        
        if ($query->num_rows() > 0) {
            return $query->row()->setting_value;
        }
        
        return null;
    }

    public function get_group($group)
    {
        $this->db->where('setting_group', $group);
        $query = $this->db->get($this->table);
        $result = [];
        
        foreach ($query->result() as $row) {
            $result[$row->setting_key] = $row->setting_value;
        }
        
        return $result;
    }

    public function get_all_grouped()
    {
        $query = $this->db->get($this->table);
        $result = [];
        
        foreach ($query->result() as $row) {
            if (!isset($result[$row->setting_group])) {
                $result[$row->setting_group] = [];
            }
            $result[$row->setting_group][$row->setting_key] = $row->setting_value;
        }
        
        return $result;
    }

    /**
     * Update a setting (template-specific or shared)
     * 
     * @param string $key Setting key
     * @param string $value Setting value
     * @param string $template Template name (null = shared)
     * @param string $group Setting group
     * @return bool Success
     */
    public function update($key, $value, $template = null, $group = 'general')
    {
        // Check if this exact setting exists (considering template)
        $this->db->where('setting_key', $key);
        if ($template) {
            $this->db->where('template', $template);
        } else {
            $this->db->where('template IS NULL OR template = ""', null, false);
        }
        $exists = $this->db->count_all_results($this->table);
        
        if ($exists) {
            $this->db->where('setting_key', $key);
            if ($template) {
                $this->db->where('template', $template);
            } else {
                $this->db->where('template IS NULL OR template = ""', null, false);
            }
            return $this->db->update($this->table, [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            return $this->db->insert($this->table, [
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_group' => $group,
                'template' => $template,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Update multiple settings in batch
     * 
     * @param array $data Key-value pairs
     * @param string $template Template name (null = shared)
     * @return bool Success
     */
    public function update_batch($data, $template = null)
    {
        $this->db->trans_start();
        
        foreach ($data as $key => $value) {
            $this->update($key, $value, $template);
        }
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    /**
     * Delete a setting
     * 
     * @param string $key Setting key
     * @param string $template Template name (null = shared)
     * @return bool Success
     */
    public function delete($key, $template = null)
    {
        $this->db->where('setting_key', $key);
        if ($template) {
            $this->db->where('template', $template);
        } else {
            $this->db->where('template IS NULL OR template = ""', null, false);
        }
        return $this->db->delete($this->table);
    }
    
    /**
     * Create template-specific settings by copying from shared
     * 
     * @param string $template Template name
     * @return bool Success
     */
    public function create_template_settings($template)
    {
        // Get all shared settings
        $this->db->where('template IS NULL OR template = ""', null, false);
        $query = $this->db->get($this->table);
        
        $this->db->trans_start();
        
        foreach ($query->result() as $row) {
            // Skip if template setting already exists
            $exists = $this->db->where('setting_key', $row->setting_key)
                               ->where('template', $template)
                               ->count_all_results($this->table);
            
            if (!$exists) {
                $this->db->insert($this->table, [
                    'setting_key' => $row->setting_key,
                    'setting_value' => $row->setting_value,
                    'setting_group' => $row->setting_group,
                    'template' => $template,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
}
