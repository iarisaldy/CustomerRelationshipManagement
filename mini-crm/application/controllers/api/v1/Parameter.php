<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Parameter extends Auth {

    function __construct(){
        parent::__construct();
        $this->validate();
        $this->load->model('Model_group');
        $this->load->model('Model_keaktifan_toko');
        $this->load->model('Model_status_toko');
        $this->load->model('Model_tipe_toko');
        $this->load->model('Model_city');
        $this->load->model('Model_district');
    }

    public function index_get(){
        $group = $this->Model_group->list_group();
        $keaktifan_toko = $this->Model_keaktifan_toko->list_keaktifan();
        $status_toko = $this->Model_status_toko->list_status();
        $tipe_toko = $this->Model_tipe_toko->list_tipe();
        $arraycity = ['1000051','1000053'];
        $city = $this->Model_city->list_city($arraycity);
        $arraydistrik = ['1000051','1000053'];
        $district = $this->Model_district->list_district(null, $arraydistrik);
        if($group){
            foreach ($group as $groupKey => $groupValue) {
                $data_group['GROUP_CUSTOMER_ID'] = $groupValue->KD_GROUP;
                $data_group['GROUP_CUSTOMER'] = $groupValue->NM_GROUP;
                $json_group[] = $data_group;
            }
        } else {
            $data_group['STATUS'] = NULL;
            $json_group[] = $data_group;
        }

        if($keaktifan_toko){
            foreach ($keaktifan_toko as $keaktifanKey => $keaktifanValue) {
                $data_keaktifan['STATUS_ACTIVE_ID'] = $keaktifanValue->STATUS_ACTIVE_ID;
                $data_keaktifan['STATUS_ACTIVE_TOKO'] = $keaktifanValue->NM_STATUS_ACTIVE;
                $json_keaktifan[] = $data_keaktifan;
            }
        } else {
            $data_keaktifan['STATUS'] = NULL;
            $json_keaktifan[] = $data_keaktifan;
        }

        if($status_toko){
            foreach ($status_toko as $status_toko_key => $status_toko_value) {
                $data_status_toko['STATUS_TOKO_ID'] = $status_toko_value->STATUS_TOKO_ID;
                $data_status_toko['STATUS_TOKO'] = $status_toko_value->NAMA_STATUS;
                $json_status_toko[] = $data_status_toko;
            }
        } else {
            $data_status_toko['STATUS'] = NULL;
            $json_status_toko[] = $data_status_toko;
        }

        if($tipe_toko){
            foreach ($tipe_toko as $tipe_toko_key => $tipe_toko_value) {
                $data_tipe_toko['TIPE_TOKO_ID'] = $tipe_toko_value->TIPE_TOKO_ID;
                $data_tipe_toko['TIPE_TOKO'] = $tipe_toko_value->NAMA_TIPE;
                $json_tipe_toko[] = $data_tipe_toko;
            }
        } else {
            $data_tipe_toko['STATUS'] = NULL;
            $json_tipe_toko[] = $data_tipe_toko;
        }

        if($city){
            foreach ($city as $city_key => $city_value) {
                $data_city['KD_REGION'] = $city_value->KD_REGION;
                $data_city['KD_CITY'] = $city_value->KD_CITY;
                $data_city['NM_CITY'] = $city_value->NM_CITY;
                $json_city[] = $data_city;
            }
        } else {
            $data_city['STATUS'] = NULL;
            $json_city[] = $data_city;
        }

        if($district){
            foreach ($district as $district_key => $district_value) {
                $data_district['KD_DISTRICT'] = $district_value->KD_DISTRICT;
                $data_district['KD_CITY'] = $district_value->KD_CITY;
                $data_district['NM_DISTRICT'] = $district_value->NM_DISTRICT;
                $json_district[] = $data_district;
            }
        } else {
            $data_district['STATUS'] = NULL;
            $json_district[] = $data_district;
        }

        $response = array("status" => "success", "data" => array("GROUP_CUSTOMER" => $json_group, "STATUS" => $json_keaktifan, "CLUSTER" => $json_status_toko, "TIPE_TOKO" => $json_tipe_toko, "CITY" => $json_city, "DISTRICT" => $json_district));

        $this->response($response);
    }
}
