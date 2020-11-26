<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Area extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
        $this->load->model('Model_area');
    }

    public function index_get(){
        $area = $this->Model_area->list_area();
        if($area){
            foreach ($area as $key => $value) {
                $data['KD_AREA'] = $value->KD_AREA;
                $data['NM_AREA'] = $value->NM_AREA;
                $json[] = $data;
            }
            $response = array("status" => "success", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "List Area Not Found");
        }

        $this->response($response);
    }
}
