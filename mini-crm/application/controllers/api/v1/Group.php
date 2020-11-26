<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Group extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
        $this->load->model('Model_group');
    }

    public function index_get(){
        $group_customer = $this->Model_group->list_group();
        if($group_customer){
            foreach ($group_customer as $key => $value) {
                $data['GROUP_CUSTOMER_ID'] = $value->KD_GROUP;
                $data['GROUP_CUSTOMER'] = $value->NM_GROUP;
                $json[] = $data;
            }
            $response = array("status" => "success", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "Data Tidak Ada");
        }

        $this->print_api($response);
    }
}
