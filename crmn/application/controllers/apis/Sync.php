<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Sync extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Sync_model');
        }
		
		public function ImageLog_post(){
			$id_user 	= $this->input->post('id_user'); 
			$data_sync = json_decode($_POST['data'], true);
			
			$hasil = $this->Sync_model->Sync_image_log($id_user, $data_sync);
			
			$cekin = explode("-",$hasil);
			
			if($cekin[0] > 0){
				$response = array("status" => "success", "message" => "$cekin[0] dari $cekin[1] data SYNC IMAGE LOG tersimpan");
			}
			else {
				 $response = array("status" => "error", "message" => "Data SYNC IMAGE LOG tidak dapat tersimpan");
			}
			$this->response($response);
		}
		
		public function getImageLogSurvey_post(){
			$id_user = null;
			if(isset($_POST['id_user'])){
				$id_user = $_POST['id_user'];
			};
			 
			$id_sync = null;
			if(isset($_POST['id_sync'])){
				$id_sync = $_POST['id_sync'];
			};
			 
			$hasil = $this->Sync_model->get_image_log_survey($id_user, $id_sync);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "message" => "Data LOG SYNC IMAGE Tidak Ditemukan");
			}
			
			$this->response($response);
		}
		
	}
	
?>