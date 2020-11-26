<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class District extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
        $this->load->model('Model_district');
    }

    public function index_get($city = null){
        $district = $this->Model_district->list_district($city);
        if($district){
            foreach ($district as $key => $value) {
                $data['KD_DISTRICT'] = $value->KD_DISTRICT;
                $data['KD_CITY'] =  $value->KD_CITY;
                $data['KD_REGION'] = $value->KD_REGION;
                $data['NM_DISTRICT'] = $value->NM_DISTRICT;
                $json[] = $data;
            }
            $response = array("status" => "ok", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "District not found");
        }

        $this->print_api($response);
    }
}
