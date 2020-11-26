<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    require APPPATH . '/controllers/apis/Auth.php';

    class Kecamatan extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_kecamatan', 'mKecamatan');
        }
		
		
        public function index_get($kd_distrik=null){
			
			$kecamatan = $this->mKecamatan->Get_data_kecamatan($kd_distrik);
			if($kecamatan){
				$response = array("status" => "success", "total" => count($kecamatan), "data" => $kecamatan);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($kecamatan), "message" => "Data Kecamatan tidak ada");
			}
			
			$this->response($response);
			
        }
		public function total_get($kd_distrik=null){
			
			$kecamatan = $this->mKecamatan->Get_data_kecamatan($kd_distrik);
			if($kecamatan){
				$response = array("status" => "success", "data" => count($kecamatan));
				
			}
			else {
				 $response = array("status" => "error", "data" => count($kecamatan), "message" => "Data Kecamatan tidak ada");
			}
			
			$this->response($response);
			
		}

    }
?>