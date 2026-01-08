<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // Navigation Menu Methods
    
    public function get_all_menus()
    {
        return $this->db->get('navigation_menus')->result();
    }

    public function get_menu($id)
    {
        return $this->db->where('id', $id)->get('navigation_menus')->row();
    }

    public function get_menu_by_location($location)
    {
        return $this->db->where('menu_location', $location)
                       ->where('is_active', 1)
                       ->get('navigation_menus')->row();
    }

    public function get_active_menus()
    {
        return $this->db->where('is_active', 1)
                       ->order_by('display_order', 'ASC')
                       ->get('navigation_menus')->result();
    }

    public function create_menu($data)
    {
        return $this->db->insert('navigation_menus', $data);
    }

    public function update_menu($id, $data)
    {
        return $this->db->where('id', $id)->update('navigation_menus', $data);
    }

    public function delete_menu($id)
    {
        // This will cascade delete menu_items due to foreign key constraint
        return $this->db->where('id', $id)->delete('navigation_menus');
    }

    public function toggle_menu_active($id, $status)
    {
        return $this->db->where('id', $id)
                       ->update('navigation_menus', ['is_active' => $status]);
    }

    // Menu Item Methods

    public function get_menu_items($menu_id)
    {
        return $this->db->where('menu_id', $menu_id)
                       ->where('deleted_at', NULL)
                       ->order_by('display_order', 'ASC')
                       ->get('menu_items')->result();
    }

    public function get_menu_items_tree($menu_id)
    {
        $items = $this->db->where('menu_id', $menu_id)
                         ->where('deleted_at', NULL)
                         ->order_by('parent_id', 'ASC')
                         ->order_by('display_order', 'ASC')
                         ->get('menu_items')->result();
        
        return $this->_build_tree($items);
    }

    public function get_menu_item($id)
    {
        return $this->db->where('id', $id)->get('menu_items')->row();
    }

    public function get_menu_item_children($parent_id, $menu_id)
    {
        return $this->db->where('parent_id', $parent_id)
                       ->where('menu_id', $menu_id)
                       ->where('deleted_at', NULL)
                       ->order_by('display_order', 'ASC')
                       ->get('menu_items')->result();
    }

    public function create_menu_item($data)
    {
        return $this->db->insert('menu_items', $data);
    }

    public function update_menu_item($id, $data)
    {
        return $this->db->where('id', $id)->update('menu_items', $data);
    }

    public function delete_menu_item($id)
    {
        // Soft delete
        return $this->db->where('id', $id)
                       ->update('menu_items', ['deleted_at' => date('Y-m-d H:i:s')]);
    }

    public function hard_delete_menu_item($id)
    {
        return $this->db->where('id', $id)->delete('menu_items');
    }

    public function toggle_menu_item_visibility($id, $visible)
    {
        return $this->db->where('id', $id)
                       ->update('menu_items', ['is_visible' => $visible]);
    }

    public function reorder_menu_items($items)
    {
        $this->db->trans_start();
        
        foreach ($items as $order => $item_id) {
            $this->db->where('id', $item_id)
                    ->update('menu_items', ['display_order' => $order]);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_menu_item_hierarchy($id, $parent_id, $depth_level)
    {
        return $this->db->where('id', $id)
                       ->update('menu_items', [
                           'parent_id' => $parent_id === 0 ? NULL : $parent_id,
                           'depth_level' => $depth_level
                       ]);
    }

    // Helper Methods

    private function _build_tree($items, $parent_id = NULL, $depth = 0)
    {
        $branch = [];
        
        foreach ($items as $item) {
            if ($item->parent_id == $parent_id) {
                $item->children = $this->_build_tree($items, $item->id, $depth + 1);
                $branch[] = $item;
            }
        }
        
        return $branch;
    }

    public function get_next_display_order($menu_id, $parent_id = NULL)
    {
        $this->db->where('menu_id', $menu_id)
                ->where('deleted_at', NULL);
        
        if ($parent_id) {
            $this->db->where('parent_id', $parent_id);
        } else {
            $this->db->where('parent_id', NULL);
        }
        
        $result = $this->db->select_max('display_order', 'max_order')
                          ->get('menu_items')->row();
        
        return ($result->max_order ?? -1) + 1;
    }

    public function get_menu_item_count($menu_id)
    {
        return $this->db->where('menu_id', $menu_id)
                       ->where('deleted_at', NULL)
                       ->count_all_results('menu_items');
    }

    public function search_menu_items($search_term, $menu_id = NULL)
    {
        $this->db->where('deleted_at', NULL)
                ->like('item_label', $search_term);
        
        if ($menu_id) {
            $this->db->where('menu_id', $menu_id);
        }
        
        return $this->db->get('menu_items')->result();
    }

    public function restore_menu_item($id)
    {
        return $this->db->where('id', $id)
                       ->update('menu_items', ['deleted_at' => NULL]);
    }

    public function get_deleted_menu_items($menu_id = NULL)
    {
        $this->db->where('deleted_at !=', NULL);
        
        if ($menu_id) {
            $this->db->where('menu_id', $menu_id);
        }
        
        return $this->db->get('menu_items')->result();
    }

    public function get_menu_statistics()
    {
        return [
            'total_menus' => $this->db->count_all('navigation_menus'),
            'active_menus' => $this->db->where('is_active', 1)
                                      ->count_all_results('navigation_menus'),
            'total_items' => $this->db->where('deleted_at', NULL)
                                     ->count_all_results('menu_items'),
            'menu_breakdown' => $this->_get_menu_breakdown()
        ];
    }

    private function _get_menu_breakdown()
    {
        return $this->db->select('m.id, m.menu_name, COUNT(i.id) as item_count')
                       ->from('navigation_menus m')
                       ->join('menu_items i', 'm.id = i.menu_id AND i.deleted_at IS NULL', 'left')
                       ->group_by('m.id')
                       ->get()->result();
    }

    // Batch Operations

    public function bulk_delete_menu_items($item_ids)
    {
        return $this->db->where_in('id', $item_ids)
                       ->update('menu_items', ['deleted_at' => date('Y-m-d H:i:s')]);
    }

    public function bulk_toggle_visibility($item_ids, $visible)
    {
        return $this->db->where_in('id', $item_ids)
                       ->update('menu_items', ['is_visible' => $visible]);
    }

    public function bulk_update_menu($item_ids, $menu_id)
    {
        return $this->db->where_in('id', $item_ids)
                       ->update('menu_items', ['menu_id' => $menu_id]);
    }

}
