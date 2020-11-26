<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

class Program_promosi extends Auth {

    public function __construct(){
        parent::__construct();
        ini_set('memory_limit','256M');
        $this->validate();
        $this->load->model('apis/Program_promosi_model');
    }
	
	public function getDataPromosi_post(){
		$kd_promosi = null;
		if(isset($_POST['kd_promosi'])){
			$kd_promosi = $_POST['kd_promosi'];
		};
		
		$id_tso = null;
		if(isset($_POST['id_tso'])){
			$id_tso = $_POST['id_tso'];
		};
		
		$hasil = $this->Program_promosi_model->Data_promosi($kd_promosi, $id_tso);
		
		if($hasil != false){
			$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);	
		}
		else {
			$response = array("status" => "error", "message" => "Data LOG SYNC IMAGE Tidak Ditemukan");
		}
		$this->response($response);
	}
	
	public function getDataPromosiByTso_post(){
		$id_tso = null;
		if(isset($_POST['id_tso'])){
			$id_tso = $_POST['id_tso'];
		};
		
		$hasil = $this->Program_promosi_model->Data_promosi_by_tso($id_tso);
		
		if($hasil != false){
			$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);	
		}
		else {
			$response = array("status" => "error", "message" => "Data LOG SYNC IMAGE Tidak Ditemukan");
		}
		$this->response($response);
	}
	
	public function getDataPromosiByNoPromosi_post(){
		$no_promosi = $_POST['no_promosi'];
		
		$hasil = $this->Program_promosi_model->Data_promosi_by_no_promosi($no_promosi);
		
		if($hasil != false){
			$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);	
		}
		else {
			$response = array("status" => "error", "message" => "Data LOG SYNC IMAGE Tidak Ditemukan");
		}
		$this->response($response);
	}
		
}
?>