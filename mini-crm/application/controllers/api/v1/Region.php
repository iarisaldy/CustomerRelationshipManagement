<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Region extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
        $this->load->model('Model_region');
    }

    public function index_get(){
        $region = $this->Model_region->list_region();
        if($region){
            foreach ($region as $key => $value) {
                $data['KD_REGION'] = $value->KD_REGION;
                $data['NM_REGION'] = $value->NM_REGION;
                $json[] = $data;
            }
            $response = array("status" => "ok", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "Region not found");
        }

        $this->print_api($response);
    }
}
