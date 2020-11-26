<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Jenis_user extends CI_Controller {
	
    function __construct(){
        parent::__construct();
		
		$this->load->model('Jenis_user_model');
		$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel'));
    }
	
	public function index(){
		$data = array("title"=>"Dashboard CRM");
		
        $this->template->display('Jenis_user_view', $data);
	}
	
	public function List_jenis_user(){
		$id_jenis = null;
		if(isset($_POST['id_jenis_user'])){
			$id_jenis = $_POST['id_jenis_user'];
		};
		$hasil = $this->Jenis_user_model->get_jenis_user($id_jenis);
		echo json_encode($hasil);
	}
	
	public function set_jenis_user(){
		$id_jenis_user 	= $this->input->post("id_jenis_user");
		$jenis_user 	= $this->input->post("jenis_user");
		
		$hasil = $this->Jenis_user_model->set_Jenis_user($id_jenis_user, $jenis_user);
		return $hasil;
	}
	
	public function del_jenis_user(){
		$id_jenis 	= $this->input->post("id_jenis_user");
		$hasil 		= $this->Jenis_user_model->del_Jenis_user($id_jenis);
		return $hasil;
	}

}

?>