<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    require APPPATH . '/controllers/apis/Auth.php';

    class Total_lokasi extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Total_lokasi_model');
        }
		
		
        public function index_get($kd_distrik=null){
			$provinsi 	= $this->Total_lokasi_model->get_total_provinsi();
			$kabupaten 	= $this->Total_lokasi_model->get_total_distrik();
			$kecamatan 	= $this->Total_lokasi_model->get_total_kecamatan();
			$area 		= $this->Total_lokasi_model->get_total_area();
			
			$hasil = array(
				'provinsi' 	=> $provinsi,
				'kabupaten' => $kabupaten,
				'kecamatan' => $kecamatan,
				'area' 		=> $area
			);
			
			$response = array("status" => "success", "data" => $hasil);
			
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