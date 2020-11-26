<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class City extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
        $this->load->model('Model_city');
    }

    public function index_get($region = null){
        $city = $this->Model_city->list_city($region);
        if($city){
            foreach ($city as $key => $value) {
                $data['KD_CITY'] = $value->KD_CITY;
                $data['KD_REGION'] = $value->KD_REGION;
                $data['NM_CITY'] = $value->NM_CITY;
                $json[] = $data;
            }
            $response = array("status" => "ok", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "City not found");
        }

        $this->print_api($response);
    }
}
