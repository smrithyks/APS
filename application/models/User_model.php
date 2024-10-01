<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function add_user($username, $parent_id = null) {
        $level = $parent_id ? $this->get_user_level($parent_id) + 1 : 1;
        $data = [
            'username' => $username,
            'parent_id' => $parent_id,
            'level' => $level
        ];
        return $this->db->insert('users', $data);
    }

    public function get_user_level($user_id) {
        $this->db->select('level');
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row() ? $query->row()->level : 0;
    }
    public function get_commission_structure() {
        return [
            1 => 0.10,
            2 => 0.05,
            3 => 0.03,
            4 => 0.02,
            5 => 0.01,
            6 => 0
        ];
    }
    public function get_user_hierarchy($user_id) {
        $this->db->select('id, parent_id, username, level');
        $this->db->where('id', $user_id);
        return $this->db->get('users')->result();
    }
}
?>