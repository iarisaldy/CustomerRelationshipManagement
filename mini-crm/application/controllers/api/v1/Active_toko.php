<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Active_toko extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
        $this->load->model('Model_keaktifan_toko');
    }

    public function index_get(){
        $activeToko = $this->Model_keaktifan_toko->list_keaktifan();
        if($activeToko){
            foreach ($activeToko as $key => $value) {
                $data['STATUS_ACTIVE_ID'] = $value->STATUS_ACTIVE_ID;
                $data['STATUS_ACTIVE_TOKO'] = $value->NM_STATUS_ACTIVE;
                $json[] = $data;
            }
            $response = array("status" => "success", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "Status toko not found");
        }

        $this->response($response);
    }
}
