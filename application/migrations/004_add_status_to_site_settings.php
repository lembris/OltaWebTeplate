<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_status_to_site_settings extends CI_Migration {

    public function up()
    {
        // Check if column doesn't already exist
        $fields = $this->db->field_data('site_settings');
        $column_exists = false;
        
        foreach ($fields as $field) {
            if ($field->name === 'status') {
                $column_exists = true;
                break;
            }
        }
        
        if (!$column_exists) {
            $this->dbforge->add_column('site_settings', array(
                'status' => array(
                    'type' => 'ENUM',
                    'constraint' => array('published', 'draft'),
                    'default' => 'published',
                    'after' => 'setting_value'
                )
            ));
        }
    }

    public function down()
    {
        // Check if column exists before dropping
        $fields = $this->db->field_data('site_settings');
        $column_exists = false;
        
        foreach ($fields as $field) {
            if ($field->name === 'status') {
                $column_exists = true;
                break;
            }
        }
        
        if ($column_exists) {
            $this->dbforge->drop_column('site_settings', 'status');
        }
    }
}
