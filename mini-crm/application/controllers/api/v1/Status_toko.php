<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Status_toko extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
        $this->load->model('Model_status_toko');
    }

    public function index_get(){
        $statusToko = $this->Model_status_toko->list_status();
        if($statusToko){
            foreach ($statusToko as $key => $value) {
                $data['STATUS_TOKO_ID'] = $value->STATUS_TOKO_ID;
                $data['STATUS_TOKO'] = $value->NAMA_STATUS;
                $json[] = $data;
            }
            $response = array("status" => "success", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "Status toko not found");
        }

        $this->response($response);
    }
}
