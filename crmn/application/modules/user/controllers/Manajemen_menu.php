<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Manajemen_menu extends CI_Controller {
	
    function __construct(){
        parent::__construct();
		
		$this->load->model('Menu_model');
		$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel'));
    }
	
	// ------------------------------------------------------------------->>> MENU
	
	public function index(){
		$data = array("title"=>"Dashboard CRM");
        $this->template->display('Menu_view', $data);
	}
	
	public function list_menu_and_sub(){
		$id_menu = null;
		if(isset($_POST['id_menu'])){
			$id_menu = $_POST['id_menu'];
		};
		$hasil = $this->Menu_model->get_menu($id_menu);
		
			if(count($hasil) != 0){
				foreach ($hasil as $Key => $Value) {
					
					$data['ID_MENU'] 		 = $Value['ID_MENU'];
					$data['NAMA_MENU'] 		 = $Value['NAMA_MENU'];
					$data['ICON'] 			 = $Value['ICON'];
					$data['LINK'] 	 		 = $Value['LINK'];
					$data['ORDER_MENU'] 	 = $Value['ORDER_MENU'];
					$data['SUB_MENU'] 		 = $this->Menu_model->get_submenu($Value['ID_MENU']);
					
					$json[] = $data;
				}
				$response = array("status" => "success", "total" => count($hasil), "data" => $json);
			} else {
				$response = array("status" => "error", "message" => "Data tidak ditemukan");
			}
			echo json_encode($response);
	}
	
	public function List_menu(){
		$id_menu = null;
		if(isset($_POST['id_menu'])){
			$id_menu = $_POST['id_menu'];
		};
		$hasil = $this->Menu_model->get_menu($id_menu);
		echo json_encode($hasil);
	} 
	
	public function set_menu(){
		$id_menu 	= $this->input->post("id_menu");
		$nama_menu 	= $this->input->post("nama_menu");
		$icon		= $this->input->post("icon");
		$link		= $this->input->post("link");
		$order		= $this->input->post("order");
		
		$hasil = $this->Menu_model->set_menu($id_menu, $nama_menu, $icon, $link, $order);
		return $hasil;
	}
	
	public function del_menu(){
		$id_menu 	= $this->input->post("id_menu");
		$hasil 		= $this->Menu_model->del_menu($id_menu);
		return $hasil;
	}
	
	// ------------------------------------------------------------------- >>> SUBMENU
	
	public function Submenu($id_menu, $nama_menu){
		$data = array("title"=>"Dashboard CRM");
		$data['id_menu_in'] = $id_menu;
		$data['menu_nama'] = urldecode($nama_menu);
        $this->template->display('Submenu_view', $data);
	}
	
	public function List_submenu(){
		$id_menu = null;
		if(isset($_POST['id_menu'])){
			$id_menu = $_POST['id_menu'];
		};
		$hasil = $this->Menu_model->get_submenu($id_menu);
		echo json_encode($hasil);
	} 
	
	public function set_submenu(){
		$id_menu 	= $this->input->post("id_menu_in");
		$id_submenu = $this->input->post("id_submenu");
		$nama_menu 	= $this->input->post("nama_menu");
		$icon		= $this->input->post("icon");
		$link		= $this->input->post("link");
		$order		= $this->input->post("order");
		
		$hasil = $this->Menu_model->set_submenu($id_menu, $id_submenu, $nama_menu, $icon, $link, $order);
		return $hasil;
	}
	
	public function del_submenu(){
		$id_menu 	= $this->input->post("id_menu_in");
		$id_submenu = $this->input->post("id_submenu");
		$hasil 		= $this->Menu_model->del_submenu($id_menu, $id_submenu);
		return $hasil;
	}
	
	// ------------------------------------------------------------------- >>> AKSES MENU
	
	public function Akses(){
		$data = array("title"=>"Dashboard CRM");
		
        $this->template->display('Akses_menu_view', $data);
	}
	
	// -------------------- > START
	
	public function list_akses_menu_by_jenis_user(){
		$id_jenis_user = null;
		if(isset($_POST['id_jenis_user'])){
			$id_jenis_user = $_POST['id_jenis_user'];
		};
		$hasil = $this->Menu_model->get_jenis_user($id_jenis_user);
		if(count($hasil) != 0){
			foreach ($hasil as $Key => $Value) {
				$data['ID_JENIS_USER'] 	 = $Value['ID_JENIS_USER'];
				$data['JENIS_USER'] 	 = $Value['JENIS_USER'];
				$data['MENU'] 		  	 = $this->list_menu_and_sub_send($Value['ID_JENIS_USER']);
				
				$json[] = $data;
		}
			$response = array("status" => "success", "total" => count($hasil), "data" => $json);
		} else {
			$response = array("status" => "error", "message" => "Data tidak ditemukan");
		}
		echo json_encode($response);
	}
	
		private function list_menu_and_sub_send($id_j_user){
			$hasil = $this->Menu_model->get_akses_menu($id_j_user);
				if(count($hasil) != 0){
					foreach ($hasil as $Key => $Value) {
						$data['ID_MENU'] 	= $Value['ID_MENU'];
						$data['NAMA_MENU'] 	= $Value['NAMA_MENU'];
						$data['SUB_MENU'] 	= $this->Menu_model->get_submenu($Value['ID_MENU']);
						$json[] = $data;
					}
					$response = $json;
				} else {
					$response = null;
				}
			return $response;
		}
	
	// ----- END <<
	
	//------------------------------------------------------------------- >>> KONFIGURASI MENU
	
	public function Konfigurasi_akses($id_j_user, $jenis_user){
		$data = array("title"=>"Dashboard CRM");
		$data['id_j_user_in'] = $id_j_user;
		$data['jenis_user_in'] = urldecode($jenis_user);
        $this->template->display('Konfigurasi_akses_view', $data);
	}
	
	public function set_akses_menu_to_user(){
		$actIn_or_Del   = $this->input->post("actIn_or_Del");
		$id_j_user		= $this->input->post("id_jenis_user");
		$id_menu		= $this->input->post("id_menu");
		
		$hasil = $this->Menu_model->set_AksesMenu($actIn_or_Del, $id_j_user, $id_menu);
		
		$output = array(
				"pesan" => $hasil
			);
			echo json_encode($output);
			//print_r($hasil);
			exit();
	}
	
}

?>