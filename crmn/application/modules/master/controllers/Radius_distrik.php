<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Radius_distrik extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('Master_radius_distrik_model','MRDM');
    }
	
	public function index()
	{
		$data = array("title"=>"Setting Radius Lock Distrik");
		
		$data['distrik'] = $this->MRDM->get_distrik_on_BK();
		
		$this->template->display('Radius_distrik_view', $data);
    }
	
	public function list_data(){
		$hasil = $this->MRDM->List_radius_distrik();
		echo json_encode($hasil);
		exit();
	}
	
	public function Set_radius_distrik(){
		$id_rd 		 = $_POST['id_rd'];
		$distrik  	 = $_POST['distrik'];
		$radius_lock = $_POST['radius_lock'];
		
		$exp_distrik = explode('-',$distrik);
		$id_distrik   = $exp_distrik[0];
		$nm_distrik  = $exp_distrik[1];
		
		$hasil = $this->MRDM->set_radius_distrik($id_rd, $id_distrik, $nm_distrik, $radius_lock);
		
		$output = array(
			"pesan" => $hasil
		);
		echo json_encode($output);
		exit();
	}
	
	public function Del_radius_distrik(){
		$id_rd 		 = $_POST['id_rd'];
		
		$hasil = $this->MRDM->delete_radius_distrik($id_rd);
		
		$output = array(
			"pesan" => $hasil
		);
		echo json_encode($output);
		exit();
	}

}

?>