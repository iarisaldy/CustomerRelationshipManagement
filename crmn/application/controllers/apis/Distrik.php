<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Distrik extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_distrik', 'mDistrik');
        }

        public function index_get($idProvinsi = null){
            $distrik = $this->mDistrik->listDistik($idProvinsi);

            if($distrik){
                foreach ($distrik as $distrikKey => $distrikValue) {
                    $data['id_distrik'] = $distrikValue->ID_DISTRIK;
                    $data['id_provinsi'] = $distrikValue->ID_PROVINSI;
                    $data['nama_distrik'] = $distrikValue->NAMA_DISTRIK;

                    $json[] = $data;
                }
                $response = array("status" => "success", "total" => count($json), "data" => $json);
            } else {
                $response = array("status" => "error", "total" => 0, "message" => "Data distrik tidak ada");
            }

            $this->response($response);
        }

    }
?>