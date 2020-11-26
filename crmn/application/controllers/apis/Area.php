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
        
        public function radiusAreaLock_post(){
            $radius_area_lock = $this->mArea->listRadiusAreaLock();
            if($radius_area_lock){
                foreach ($radius_area_lock as $radius_area_lockKey => $ralValue) {
                    $data['id_radius_area'] = $ralValue->ID_RADIUS_AREA;
                    $data['kd_area'] = $ralValue->KD_AREA;
                    $data['id_area'] = $ralValue->ID_AREA;
                    $data['nama_area'] = $ralValue->NAMA_AREA;
                    $data['id_provinsi'] = $ralValue->ID_PROVINSI;
                    $data['nama_provinsi'] = $ralValue->NAMA_PROVINSI;
                    $data['region'] = $ralValue->REGION;
                    $data['radius_lock'] = $ralValue->RADIUS_LOCK;
                    
                    $json_dt[] = $data;
                }
                $response = array("status" => "success", "data" => $json_dt);
            } else {
                $response = array("status" => "error", "message" => "Data area lock tidak ada");
            }
            $this->response($response);
        }

    }
?>