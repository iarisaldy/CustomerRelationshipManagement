<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}
require APPPATH . '/controllers/apis/Auth.php';

    class Area extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_area', 'mArea');
        }

        public function index_get($idArea = null){
            $area = $this->mArea->listArea($idArea);
            if($area){
                foreach ($area as $areaKey => $areaValue) {
                    $data['id_area'] = $areaValue->ID_AREA;
                    $data['id_provinsi'] = $areaValue->ID_PROVINSI;
                    $data['nama_area'] = $areaValue->NAMA_AREA;

                    $json[] = $data;
                }
                $response = array("status" => "success", "data" => $json);
            } else {
                $response = array("status" => "error", "message" => "Data area tidak ada");
            }

            $this->response($response);
        }

    }
?>