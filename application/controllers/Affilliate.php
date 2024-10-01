<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Affilliate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Sale_model');
        $this->load->helper('url');
    }
    
    public function add_user() {
        $username = $this->input->post('username');
        $parent_id = $this->input->post('parent_id');
        if($username !== null && $parent_id !== null){
        $this->User_model->add_user($username, $parent_id);
        }
        // redirect('affiliate/list_users');
        $this->list_users();
    }
    public function list_users() {
        $data['users'] = $this->db->get('users')->result();
        $this->load->view('user_list', $data);
    }
    public function record_sale() {
        $user_id = $this->input->post('user_id');
        $amount = $this->input->post('amount');
        $commissions = $this->Sale_model->record_sale($user_id, $amount);
        echo json_encode($commissions);
    }
    public function view_commission(){
        $user_id = $this->input->post('userid');
        $amount = $this->input->post('amount');
        $comm_details = $this->Sale_model->getcommissions($user_id, $amount);
        if ($comm_details) {
            $data['comm_details'] = $comm_details; 
            $this->load->view('commission_chart', $data);
        } else {
            $data['comm_details'] = []; 
            $this->load->view('commission_chart', $data);
        }
    }
}
?>