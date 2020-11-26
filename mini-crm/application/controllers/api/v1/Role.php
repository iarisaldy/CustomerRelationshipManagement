<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Role extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
        $this->load->model('Model_role');
    }

    public function index_get(){
        $role = $this->Model_role->list_role();
        if($role){
            foreach ($role as $key => $value) {
                $data['ROLE_ID'] = $value->ROLE_ID;
                $data['NAME'] = $value->NAME;
                $json[] = $data;
            }
            $response = array("status" => "success", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "Role not found");
        }

        $this->response($response);
    }
}
