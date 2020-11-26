<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Import extends Auth {

	function __construct(){
		parent::__construct();
        $this->load->model('Model_customer');
        $this->load->model('Model_group');
        $this->load->model('Model_status_toko');
        $this->load->model('Model_tipe_toko');
        $this->load->model('Model_region');
        $this->load->model('Model_city');
        $this->load->model('Model_district');
        $this->load->model('Model_area');
    }

    public function index_post(){
        $config['upload_path'] = './assets/excel/';
        $config['allowed_types'] = 'csv|xls|xlsx';

        $this->load->library('upload', $config);
        if(! $this->upload->do_upload('file')){
            echo $this->upload->display_errors();
        } else {
            $data_customer = array();
            $data_owner = array();
            $data_location = array();

            $filename =  $this->upload->data('file_name');
            $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

            $inputFileName = $config['upload_path'] . $filename;

            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);

            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $row = 1;

            $dataGroup = $this->Model_group->list_group();
            $dataStatus = $this->Model_status_toko->list_status();
            $dataTipe = $this->Model_tipe_toko->list_tipe();
            $dataRegion = $this->Model_region->list_region();
            $dataCity = $this->Model_city->list_city();
            $dataDistrict = $this->Model_district->list_district();
            $dataArea = $this->Model_area->list_area();

            $last_customer = $this->Model_customer->last_customer_id();
            $last_customer_id = $last_customer->CUSTOMER_ID;
            for($i=2;$i<=count($allDataInSheet);$i++){
            	$next_id = $last_customer_id + 1;
            	$last_customer_id = $next_id;

            	// start matching kode group customer dengan excel
            	$GROUP_CUSTOMER = "";
            	foreach ($dataGroup as $groupKey => $groupValue) {
            		if($groupValue->NM_GROUP == $allDataInSheet[$i]['F']){
            			$GROUP_CUSTOMER = $groupValue->KD_GROUP;
            		}
            	}
            	// end matching kode group customer dengan excel

            	// start matching status toko
            	$STATUS_TOKO = "";
            	foreach ($dataStatus as $statusKey => $statusValue) {
            		if($statusValue->NAMA_STATUS == $allDataInSheet[$i]['Y']){
            			$STATUS_TOKO = $statusValue->STATUS_TOKO_ID;
            		}
            	}
            	// end matching status toko

            	// start matching tipe toko
            	$TIPE_TOKO = "";
            	foreach ($dataTipe as $tipeKey => $tipeValue) {
            		if($tipeValue->NAMA_TIPE == $allDataInSheet[$i]['AB']){
            			$TIPE_TOKO = $tipeValue->TIPE_TOKO_ID;
            		}
            	}
            	// end matching tipe toko

            	// start matching region
            	$REGION = "";
            	foreach($dataRegion as $regionKey => $regionValue){
            		if($regionValue->NM_REGION == $allDataInSheet[$i]['V']){
            			$REGION = $regionValue->KD_REGION;
            		}
            	}
            	// end matching region

            	// start matching city
            	$CITY = "";
            	foreach ($dataCity as $cityKey => $cityValue) {
            		if ($allDataInSheet[$i]['H'] == trim(str_replace("KOTA", "", str_replace("KABUPATEN", "", $cityValue->NM_CITY)))) {
            			$CITY = $cityValue->KD_CITY;
            		}
            	}
            	// end matching city

            	// start matching district
            	$DISTRICT = "";
            	foreach($dataDistrict as $districtKey => $districtValue){
            		if($districtValue->NM_DISTRICT == $allDataInSheet[$i]['T']){
            			$DISTRICT = $districtValue->KD_DISTRICT;
            		}
            	}
            	// end matching district

            	// start matching area
            	$AREA = "";
            	foreach ($dataArea as $areaKey => $areaValue) {
            		if($areaValue->NM_AREA == $allDataInSheet[$i]['W']){
            			$AREA = $areaValue->KD_AREA;
            		}
            	}
            	// end matching area

                $insert_customer = array("KD_CUSTOMER" => $allDataInSheet[$i]['B'], "NM_TOKO" => $allDataInSheet[$i]['M'], "NO_TELP_TOKO" => $allDataInSheet[$i]['O'], "KD_DISTRIBUTOR" => $allDataInSheet[$i]['P'], "GROUP_CUSTOMER" => $GROUP_CUSTOMER, "KD_SAP" => $allDataInSheet[$i]['X'], "KD_LT" => $allDataInSheet[$i]['AA'], "STATUS_TOKO" => $STATUS_TOKO, "TIPE_TOKO" => $TIPE_TOKO, "KAPASITAS" => $allDataInSheet[$i]['AF'], "UPDATED_AT" => date('Y-m-d h:i:s'), "IS_DELETED" => "N");
                array_push($data_customer, $insert_customer);

                $insert_owner = array("CUSTOMER_ID" => $next_id, "KD_CUSTOMER" => $allDataInSheet[$i]['B'], "NM_OWNER" => $allDataInSheet[$i]['C'], "NO_HANDPHONE" => $allDataInSheet[$i]['R'], "TGL_LAHIR" => $allDataInSheet[$i]['AC'], "HOBI" => $allDataInSheet[$i]['AD'], "AGAMA" => $allDataInSheet[$i]['AE'], "EMAIL" => $allDataInSheet[$i]['AG'], "NOKTP_OWNER" => "");
                array_push($data_owner, $insert_owner);

                $insert_location = array("CUSTOMER_ID" => $next_id, "KD_CUSTOMER"=> $allDataInSheet[$i]['B'], "KD_REGION" => $REGION, "KD_CITY" => $CITY, "KD_DISTRICT" => $DISTRICT, "AREA" => $AREA, "ALAMAT_TOKO" => $allDataInSheet[$i]['N']);
                array_push($data_location, $insert_location);

            }

            // print_r($data_customer);
            // print_r($data_owner);
            // print_r($data_location);

            $import_customer = $this->Model_customer->insert_batch_tabel('MASTER_CUSTOMER', $data_customer);
            $import_owner = $this->Model_customer->insert_batch_tabel('CUSTOMER_OWNER', $data_owner);
            $import_location = $this->Model_customer->insert_batch_tabel('CUSTOMER_LOCATION', $data_location);

            if($import_customer && $import_owner && $import_location){
            	$response = array("status" => "success", "data" => $import_customer);
            } else {
            	$response = array("status" => "error", "message" => "Cant import customer");
            }

            $this->response($response);

            unlink($inputFileName);
        }
    }
}