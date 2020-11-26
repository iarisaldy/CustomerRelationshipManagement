<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Order extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Model_order');
        }
		
		public function AddOrder_post(){
			
			$id_user 	= $this->input->post("id_user");
			$data = json_decode($_POST['data'], true);
			//echo json_encode($data);
			
			$hasil = $this->Model_order->AddOrder($id_user, $data);
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Disimpan', "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Disimpan', "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function UpdateOrder_post(){
			
			$id_user 	= $this->input->post("id_user");
			$data = json_decode($_POST['data'], true);
			//echo json_encode($hasil);
			
			$hasil = $this->Model_order->UpdateOrder($id_user, $data);
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Diupdate', "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Diupdate', "data" => $hasil);
			}
			
			$this->response($response);
		}
		
		public function DeleteOrder_post(){
			
			$id_user 			= $this->input->post("id_user");
			$data 				= $this->input->post("data");
			
			$hasil = $this->Model_order->DeleteOrder($id_user, $data);
			
			if($hasil == true){
				$response = array("status" => "success", "message" => "Data Berhasil di Delete");
			} else {
				$response = array("status" => "Error", "message" => "Data Gagal dihapus");
			}
			
			$this->response($response);
		}
		
		public function GetOrder_post(){
			$id_user = $this->input->post("id_user");
			$limit 	= $this->input->post("limit");
			
			$get_data = $this->Model_order->GetOrder($id_user, $limit);
			
			$response = array("status" => "success", "total" => count($get_data), "data" => $get_data);
			
			$this->response($response);
		}
		
	}


?>