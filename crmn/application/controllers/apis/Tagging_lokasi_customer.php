<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Tagging_lokasi_customer extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Tagging_lokasi_customer_model');
        }
		
		public function index_post(){
			$data_set = array();
			
			$data_set['id_customer'] = $_POST['id_customer'];
			$data_set['id_user'] 	 = $_POST['id_user'];
			$data_set['ltd']		 = $_POST['latitude'];
			$data_set['lng']		 = $_POST['longitude'];
			
			$hasil = $this->Tagging_lokasi_customer_model->set_tangging_lokasi($data_set);
			
			if($hasil == 1){
				$response = array("status" => "success", "message" => "Data lokasi tersimpan");
				
			}
			else {
				 $response = array("status" => "error", "message" => "Data lokasi tidak dapat tersimpan");
			}
			 
			$this->response($response);
		}
		
		public function setTaggingToko_post(){
			$id_user 	= $this->input->post('id_user');
			$dataLokasi = json_decode($_POST['data'], true);
			
			$hasil = $this->Tagging_lokasi_customer_model->set_TaggingToko_array($id_user, $dataLokasi);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);
		}
		
	}

?>