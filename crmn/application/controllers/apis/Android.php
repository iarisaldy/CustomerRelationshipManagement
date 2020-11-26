<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Android extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Android_model');
        }

        public function GetVersion_post(){
			
			$version_code = $this->input->post('version_code');
			
			$hasil = $this->Android_model->get_data_versi_android($version_code);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Tidak Ada");
			}
			
			$this->response($response);
			
        }

    }
?>