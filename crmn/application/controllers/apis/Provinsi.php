<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    require APPPATH . '/controllers/apis/Auth.php';

    class Provinsi extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_provinsi', 'mProvinsi');
        }

        public function index_get(){
            $provinsi = $this->mProvinsi->listProvinsi();
            if($provinsi){
                foreach ($provinsi as $provinsiKey => $provinsiValue) {
                    $data['id_provinsi'] = $provinsiValue->ID_PROVINSI;
                    $data['id_region'] = $provinsiValue->ID_REGION;
                    $data['nama_provinsi'] = $provinsiValue->NAMA_PROVINSI;

                    $json[] = $data;
                }
                $response = array("status" => "success", "total" => count($json), "data" => $json);
            } else {
                $response = array("status" => "error", "total" => 0, "message" => "Data provinsi tidak ada");
            }

            $this->response($response);
        }
		public function total_get(){
			$provinsi = $this->mProvinsi->listProvinsi();
            if($provinsi){
                foreach ($provinsi as $provinsiKey => $provinsiValue) {
                    $data['id_provinsi'] = $provinsiValue->ID_PROVINSI;
                    $data['id_region'] = $provinsiValue->ID_REGION;
                    $data['nama_provinsi'] = $provinsiValue->NAMA_PROVINSI;

                    $json[] = $data;
                }
                $response = array("status" => "success", "data" => count($json));
            } else {
                $response = array("status" => "error", "data" => 0, "message" => "Data provinsi tidak ada");
            }

            $this->response($response);
		}

    }
?>