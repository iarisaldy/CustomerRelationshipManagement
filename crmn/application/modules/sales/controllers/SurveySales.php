<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class SurveySales extends CI_Controller {
	
    function __construct(){
        parent::__construct();
		
		$this->load->model('Model_survey_sales','MSS');
		//$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel'));
    }
	
	public function index(){
		$data = array("title"=>"Dashboard CRM");
		
        $this->template->display('Setting_master_penilaian_sales', $data);
	}
	
	public function list_jp(){
		$id_jp = null; 
		if(isset($_POST['id_jp'])){
			$id_jp = $_POST['id_jp'];
		};
		$hasil = $this->MSS->get_jenis_penilaian($id_jp);
		echo json_encode($hasil);
	}
	
		public function simpanJenisPenilaian(){
			$id_jp 	= $_POST['id_jp'];
			$jp 	= $_POST['jp'];
			 
			$hasil = $this->MSS->simpanJP($id_jp, $jp);
			return $hasil;
		}
		
		public function hapusJenisPenilaian(){
			$id_jp 	= $_POST['id_jp'];
			 
			$hasil = $this->MSS->hapusJP($id_jp);
			return $hasil;
		}
	
	public function list_jp_full_pertanyaan(){ 	//list data by id_jp
		$id_jp = null; 
		if(isset($_POST['id_jp'])){
			$id_jp = $_POST['id_jp'];
			if($id_jp == null){
				$id_jp = null; 
			}
		};
		
		$json = array();
		$hasil = $this->MSS->list_jenis_penilaian($id_jp);
		
		if(count($hasil) > 0){
			foreach($hasil as $dt_get){
				$data['ID_JP'] 	= $dt_get->ID_JP;
                $data['JP'] 	= $dt_get->JP;
				$data['JML_SOAL']	= $dt_get->JML;
				$data['LIST_PERTANYAAN'] = $this->pertanyaan($dt_get->ID_JP);

                $json[] = $data;
			}
			$response = array("status" => "success", "data" => $json);
        } else {
            $response = array("status" => "success", "data" => $json);
        }
		
		echo json_encode($response);
	}
	
		private function pertanyaan($id_jp){ 
		$json = array();
			$pertanyaan = $this->MSS->List_pertanyaan($id_jp);
				foreach ($pertanyaan as $Key => $Value) {
					$data['ID_PERTANYAAN'] 		 = $Value['ID_PERTANYAAN'];
					$data['PERTANYAAN'] 		 = $Value['NM_PERTANYAAN'];
					$data['JML_OPSI'] 			 = $Value['JML'];
					$data['OPSI_JAWABAN'] 		 = $this->MSS->List_jawaban($Value['ID_PERTANYAAN']);
					
					$json[] = $data;
				}
			return $json;
		}
		
		public function simpanPertanyaan(){
			$id_jp 	= $_POST['id_jp'];
			$id_p 	= $_POST['id_p'];
			$p 		= $_POST['p'];
			 
			$hasil = $this->MSS->simpanP($id_p, $p, $id_jp);
			return $hasil;
		}
		
		public function hapusPertanyaan(){
			$id_p 	= $_POST['id_p'];
			 
			$hasil = $this->MSS->hapusP($id_p);
			return $hasil;
		}
	
	public function list_opsional_jawaban(){
		$id_p = $_POST['id_p'];
		
		$hasil = $this->MSS->List_jawaban($id_p);
		echo json_encode($hasil);
	}
	
		public function simpanOJ(){
			$id_oj 	= $_POST['id_oj'];
			$id_p 	= $_POST['id_p'];
			$oj 	= $_POST['oj'];
			$point 	= $_POST['point'];
			 
			$hasil = $this->MSS->simpanOJ($id_oj, $id_p, $oj, $point);
			return $hasil;
		}
		
		public function hapusOJ(){
			$id_oj 	= $_POST['id_oj'];
			 
			$hasil = $this->MSS->hapusOJ($id_oj);
			return $hasil;
		}

}

?>