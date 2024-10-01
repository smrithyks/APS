<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function record_sale($user_id, $amount) {
        $data = [
            'user_id' => $user_id,
            'amount' => $amount
        ];
        $comm = 0;
        $this->db->insert('sales', $data);
        $salesid = $this->db->insert_id();
        $comm = $this->calculate_commissions($user_id, $amount);
        $sql = "select * from commission_details where sales_id='".$salesid."'";
        $query = $this->db->query($sql);
        if ( $query->num_rows() == 0 )
        {
            foreach($comm as $val){
                $commission_data = [
                    'sales_id' => $salesid,
                    'user_id' => $val['id'],
                    'commission_amount' => $val['commission']
                ];  
                $this->db->insert('commission_details', $commission_data);
            }
        }
        return $comm;
    }

    private function calculate_commissions($user_id, $amount) {
        $this->load->model('User_model');
        $level = $this->User_model->get_user_level($user_id);
        $commission_structure = $this->User_model->get_commission_structure();
        
        $commissions = [];
        $current_user = $user_id;
        if($level >= 5){
            for ($i = $level; $i > 0; $i--) {
                $parent_user = $this->User_model->get_user_hierarchy($current_user);
                if (!empty($parent_user)) {
                    $current_user = $parent_user[0]->parent_id;
                    $commissions[$current_user]["commission"] = $amount * $commission_structure[$i];
                    $commissions[$current_user]["username"] = $parent_user[0]->username;
                    $commissions[$current_user]["level"] = $parent_user[0]->level;
                    $commissions[$current_user]["id"] = $current_user;
                } else {
                    break; 
                }
            }
        }
        return $commissions;
    }
    public function getcommissions($user_id, $amount){
        $sql = "Select id from sales where user_id='".$user_id."' and amount='".$amount."'";
        $query = $this->db->query($sql);
        if ( $query->num_rows() > 0 )
        {
            $sales_id = $query->row()->id;
        }

        $sql1 = "Select c.*,u.username,u.level  
        from commission_details c
        left join users u on u.parent_id=c.user_id
        where c.sales_id='".$sales_id."'";
        $query1 = $this->db->query($sql1);
            $details = $query1->result();
        return $details;

    }
}
?>