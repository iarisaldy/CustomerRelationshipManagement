<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Tracking_sync extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_tracking_sync', "TRACKING");
        }
		
		public function getTrackingSync_post(){
			
			$id_user 	= $this->input->post("id_user");
			$hasil = $this->TRACKING->get();

			if($hasil){
                $response = array("status" => "success", "data" => $hasil);
            } else {
                $response = array("status" => "error", "data" => []);
            }
			 $this->response($response);
		}
		
		public function AddTrackingSync_post(){
			
			$id_user 	= $this->input->post("id_user");
			$data = json_decode($_POST['data'], true);
			
			// print($_POST['data']);
			// exit;
			$hasil = $this->TRACKING->insert($id_user, $data);
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Disimpan', "data" => []);
			} else {
				$response = array("status" => "error", "message" => 'Data Gagal Disimpan', "data" => []);
			}
			$this->response($response);
		}

    }
?>
