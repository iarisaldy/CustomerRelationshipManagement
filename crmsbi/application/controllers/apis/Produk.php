<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Produk extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Produk_model');
        }
		
		public function ProdukSurvey_post(){
			
			$id_group 	= null;
			if(isset($_POST['id_group'])){
				$id_group = $_POST['id_group'];
			}
			
			$smi_group 	= null;
			if(isset($_POST['smi_group'])){
				$smi_group = $_POST['smi_group'];
			}
			
			
			$hasil = $this->Produk_model->get_data_produk($id_group, $smi_group);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Survey Keluhan Tidak Ditemukan");
			}
			
			$this->response($response);
			
			
			
		}
		
		
	}


?>