<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_common extends CI_Model 
{
    function data_add($table, $data) {
        
        if($this->db->insert($table,$data)){
            return $this->db->insert_id();
        }else{
            return FALSE;
        }
        
    }
    function data_update($table, $whr_value,$data) {
        $this->db->where('id',$whr_value);
        if($this->db->update($table,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function data_delete($table, $whr_value)
    {
        $this->db->where('id',$whr_value);
        if($this->db->delete($table)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function get_data($table, $id_value)
    {
        $this->db->where('id',$id_value);
        $query = $this->db->get($table);
        return $query->first_row('array');
    }
    function get_all_table_data($table)
    {
        $this->db->where(array('is_deleted' => 0));
        $query = $this->db->get($table);
        return $query->result_array();
    }
    function get_table_data($table)
    {
        $this->db->where(array('is_deleted' => 0, 'status' => 'Active'));
        $query = $this->db->get($table);
        return $query->result_array();
    }
    function get_table_data_by_priority($table)
    {
        $this->db->where(array('is_deleted' => 0, 'status' => 'Active'));
        $this->db->order_by('Priority ASC');
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function data_count($table) {
        $this->db->where('is_deleted', 0); 
        $query = $this->db->get($table); 
        if($query->num_rows()){
            return $query->num_rows();
        }else{
            return 0;
        }
    }
    
    function extension_check_photo($value) {
        $this->db->like('extensions', $value); 
        $query = $this->db->get('tbl_file_extensions'); 
        if($query->num_rows()){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    
}