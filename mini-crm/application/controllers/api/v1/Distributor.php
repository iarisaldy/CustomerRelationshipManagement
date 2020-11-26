<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Distributor extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
        $this->load->model('Model_distributor');
    }

    public function index_get(){
        $distributor = $this->Model_distributor->list_distributor();
        if($distributor){
            foreach ($distributor as $key => $value) {
                $data['KD_DISTRIBUTOR'] = $value->KD_DISTRIBUTOR;
                $data['NM_DISTRIBUTOR'] = $value->NM_DISTRIBUTOR;
                $json[] = $data;
            }
            $response = array("status" => "success", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "Status distributor not found");
        }

        $this->response($response);
    }
}
