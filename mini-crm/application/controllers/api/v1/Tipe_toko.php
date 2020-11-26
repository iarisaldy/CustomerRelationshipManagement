<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Tipe_toko extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
        $this->load->model('Model_tipe_toko');
    }

    public function index_get(){
        $tipeToko = $this->Model_tipe_toko->list_tipe();
        if($tipeToko){
        	foreach ($tipeToko as $key => $value) {
        		$data['TIPE_TOKO_ID'] = $value->TIPE_TOKO_ID;
        		$data['TIPE_TOKO'] = $value->NAMA_TIPE;
        		$json[] = $data;
        	}
            $response = array("status" => "success", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "Tipe toko not found");
        }

        $this->response($response);
    }
}
