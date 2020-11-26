<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Kapasitas_gudang_toko extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Kapasitas_gudang_toko_model');
        }
		
		public function index_post(){
			$data_set = array();
			
			$data_set['id_customer'] = $_POST['id_customer'];
			$data_set['id_user'] 	 = $_POST['id_user'];
			
			$data_set['kapasitas_zak'] = null; 
			if(isset($_POST['kapasitas_zak'])){
				$data_set['kapasitas_zak']	 = $_POST['kapasitas_zak'];
			};
			
			$data_set['kapasitas_ton'] = null;
			if(isset($_POST['kapasitas_ton'])){
				$data_set['kapasitas_ton']	 = $_POST['kapasitas_ton'];
			};
			
			$hasil = $this->Kapasitas_gudang_toko_model->set_kapasitas_gudang_toko($data_set);
			
			if($hasil == 1){
				$response = array("status" => "success", "message" => "Data tersimpan");
			}
			else if($hasil == 2){
				$response = array("status" => "success", "message" => "Data berhasil diupdate");
			}
			else {
				 $response = array("status" => "error", "message" => "Data tidak dapat tersimpan");
			}
			 
			$this->response($response);
		}
		
		public function insertArrayData_post(){		//save 
			
			$id_user 		= $this->input->post("id_user");
			$dt_kapasitas 	= json_decode($_POST['data'], true);
			
			$hasil = $this->Kapasitas_gudang_toko_model->set_kapasitas_gudang_toko_array($id_user, $dt_kapasitas);
			
			// print_r($reason);
			// exit;
			
			if($hasil){
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data Berhasil Disimpan');
			}
			else {
				$response = array("status" => "success", "data" => $hasil, "message" => 'Data Gagal Disimpan');
			}
			
			$this->response($response);
		}
		
		public function getAllCustomer_post(){
			$id_customer = null;
			if(isset($_POST['id_customer'])){
				$id_customer = $_POST['id_customer'];
			};
			
			$hasil = $this->Kapasitas_gudang_toko_model->get_kapasitas_gudang_toko($id_customer);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Customer Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}
		
	}

?>