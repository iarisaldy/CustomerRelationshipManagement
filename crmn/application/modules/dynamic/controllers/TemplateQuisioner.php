<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class TemplateQuisioner extends CI_Controller {
	
    function __construct(){
        parent::__construct();		
		$this->load->model('Template_model');
		$this->load->model('Model_template_quisioner','MTQ');
		//$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel'));
    }
	
	public function index(){
		$data = array("title"=>"Dashboard CRM");
		
        $this->template->display('Setting_template_quisioner', $data);
	}

	// =============================================================== Template Header Start
	
	public function list_template(){
		$id_templ = null;
		if(isset($_POST['id_templ'])){
			$id_templ = $_POST['id_templ'];
		};
		$hasil = $this->Template_model->get_template($id_templ);
		
			if(count($hasil) != 0){
				foreach ($hasil as $Key => $Value) {
					
					$data['ID'] 		 	= $Value['ID'];
					$data['NAMA_TEMPLATE'] 	= $Value['NAMA_TEMPLATE'];
					$data['IS_ACTIVE'] 		= $Value['IS_ACTIVE'];
					$data['CREATED_AT'] 	= $Value['CREATED_AT'];
					$data['CREATED_BY'] 	= $Value['NAMA_USER_INPUT'];
					$data['ORDER_TEMPLATE'] = $Value['ORDER_TEMPLATE'];
					$data['DESKRIPSI'] 		= $Value['DESKRIPSI'];
					
					$json[] = $data;
				}
				$response = array("status" => "success", "total" => count($hasil), "data" => $json);
			} else {
				$response = array("status" => "error", "message" => "Data tidak ditemukan");
			}
			echo json_encode($response);
	}
	
	public function set_template(){

		$post = $this->input->post();
		$sesi = $this->session->all_userdata();

		if (empty($post["ID"])) {
			# code...
			unset($post["ID"]);
			$post['CREATED_BY'] = $sesi["user_id"];
			$hasil = $this->Template_model->insert_template($post);
			return $hasil;
		} else {
			$post['UPDATED_BY'] = $sesi["user_id"];
			$hasil = $this->Template_model->update_template($post);
			return $hasil;
		}				
	}

	public function del_template(){
		$post = $this->input->post();
		$sesi = $this->session->all_userdata();		
		$post['DELETED_MARK'] = 1;
		$post['UPDATED_BY'] = $sesi["user_id"];
		$hasil = $this->Template_model->update_template($post);
		return $hasil;
	}

	// =============================================================== Template Header End
	
	public function list_jp(){
		$id_jp = null; 
		if(isset($_POST['id_jp'])){
			$id_jp = $_POST['id_jp'];
		};
		$hasil = $this->MTQ->get_jenis_penilaian($id_jp);
		echo json_encode($hasil);
	}
	
	public function simpanJenisPenilaian(){
		// $id_jp 	= $_POST['id_jp'];
		// $jp 	= $_POST['jp'];
		// $post = $this->input->post();
		// $sesi = $this->session->all_userdata();
		// $post['USER_ID'] = $sesi["user_id"];
		 
		// $hasil = $this->MTQ->simpanJP($id_jp, $jp, $post);
		// return $hasil;
		$post = $this->input->post();
		$sesi = $this->session->all_userdata();

		if (empty($post["ID"])) {
			# code...
			unset($post["ID"]);
			$post['CREATED_BY'] = $sesi["user_id"];
			$hasil = $this->MTQ->insert_kategory($post);
			return $hasil;
		} else {
			$post['UPDATED_BY'] = $sesi["user_id"];
			$hasil = $this->MTQ->update_kategory($post);
			return $hasil;
		}				
	}
	
	public function hapusJenisPenilaian(){
		// $id_jp 	= $_POST['id_jp'];		 
		// $hasil = $this->MTQ->hapusJP($id_jp);
		// return $hasil;
		$post = $this->input->post();
		$sesi = $this->session->all_userdata();		
		$post['DELETED_MARK'] = 1;
		$post['UPDATED_BY'] = $sesi["user_id"];
		$hasil = $this->MTQ->update_kategory($post);
		return $hasil;
	}
	
	public function list_jp_full_pertanyaan($idtempl){ 	//list data by id_jp
		$id_jp = null; 
		if(isset($_POST['id_jp'])){
			$id_jp = $_POST['id_jp'];
			if($id_jp == null){
				$id_jp = null; 
			}
		};
		
		$json = array();
		$hasil = $this->MTQ->list_jenis_penilaian($idtempl, $id_jp);

		foreach ($hasil as $key => $value) {
			# code...
			$data['ID_JP'] 	= $value['ID'];
            $data['JP'] 	= $value['NAMA_KATEGORY'];
			$data['JML_SOAL']	= $value['JML'];
			$data['LIST_PERTANYAAN'] = $this->pertanyaan($value['ID']);
			$json[] = $data;
		}

		$response = array("status" => "success", "data" => $json);
		
		// if(count($hasil) > 0){
		// 	foreach($hasil as $dt_get){
		// 		$data['ID_JP'] 	= $dt_get->ID_JP;
  //               $data['JP'] 	= $dt_get->JP;
		// 		$data['JML_SOAL']	= $dt_get->JML;
		// 		$data['LIST_PERTANYAAN'] = $this->pertanyaan($dt_get->ID_JP);

  //               $json[] = $data;
		// 	}
		// 	$response = array("status" => "success", "data" => $json);
  //       } else {
  //           $response = array("status" => "success", "data" => $json);
  //       }
		
		echo json_encode($response);
	}
	
		private function pertanyaan($id_jp){ 
		$json = array();
			$pertanyaan = $this->MTQ->List_pertanyaan($id_jp);
				foreach ($pertanyaan as $Key => $Value) {
					$data['ID_PERTANYAAN'] 		 = $Value['ID'];
					$data['PERTANYAAN'] 		 = $Value['PERTANYAAN'];
					$data['JML_OPSI'] 			 = $Value['JML'];
					$data['OPSI_JAWABAN'] 		 = $this->MTQ->List_jawaban($Value['ID']);
					
					$json[] = $data;
				}
			return $json;
		}
		
		public function simpanPertanyaan(){
			$id_jp 	= $_POST['id_jp'];
			$id_p 	= $_POST['id_p'];
			$p 		= $_POST['p'];
			 
			$hasil = $this->MTQ->simpanP($id_p, $p, $id_jp);
			return $hasil;
		}
		
		public function hapusPertanyaan(){
			$id_p 	= $_POST['id_p'];
			 
			$hasil = $this->MTQ->hapusP($id_p);
			return $hasil;
		}
	
	public function list_opsional_jawaban(){
		$id_p = $_POST['id_p'];
		
		$hasil = $this->MTQ->List_jawaban($id_p);
		echo json_encode($hasil);
	}
	
		public function simpanOJ(){
			$id_oj 	= $_POST['id_oj'];
			$id_p 	= $_POST['id_p'];
			$oj 	= $_POST['oj'];
			$point 	= $_POST['point'];
			 
			$hasil = $this->MTQ->simpanOJ($id_oj, $id_p, $oj, $point);
			return $hasil;
		}
		
		public function hapusOJ(){
			$id_oj 	= $_POST['id_oj'];
			 
			$hasil = $this->MTQ->hapusOJ($id_oj);
			return $hasil;
		}

}

?>