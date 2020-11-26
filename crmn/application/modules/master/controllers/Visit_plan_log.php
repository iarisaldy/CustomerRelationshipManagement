<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Visit_plan_log extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Visit_plan_log_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_sales'] = $this->Visit_plan_log_model->User_SALES($id_user);
		
		$this->template->display('Visit_plan_log_view', $data);
		
    }
	
	public function Admin(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$data['list_distributor'] = $this->Visit_plan_log_model->User_distributor();
		
		$this->template->display('Visit_plan_log_admin', $data);
		
    }
	
	public function tampildata(){
		$idsales		= $this->input->post("idsales");
		$tahun			= $this->input->post("tahun");
		$bulan			= $this->input->post("bulan");
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$USER 			= $this->session->userdata('user_id');
		$hasil			= $this->Visit_plan_log_model->get_data($idsales, $tahun, $bulan, $USER);
		
		echo json_encode($hasil);
	}
	
	public function tampildataall(){
		$tahun			= $this->input->post("tahun");
		$bulan			= $this->input->post("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$hasil			= $this->Visit_plan_log_model->get_data_admin($tahun, $bulan);
		
		echo json_encode($hasil);
	}
	
	public function dis_sales_admin(){
        $id_dis = $this->input->post("id");
        $data = $this->Visit_plan_log_model->dis_sales($id_dis);
		
        echo json_encode($data);
    }

	public function Ajax_tambah_data()
	{
		$USER 		= $this->session->userdata('user_id');
		$id_sales 	= $this->input->post("idsales");
		$tahun 		= $this->input->post("tahun");
		$bulan 		= $this->input->post("bulan");
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
	
		$hasil = $this->Visit_plan_log_model->insert_data($id_sales,$tahun,$bulan,$USER);
		echo json_encode($hasil);
	}
	public function Ajax_simpan_edit()
	{	
		$USER 		= $this->session->userdata('user_id');
		$no			= $this->input->post("no");
		
		// print_r($_POST);
		// exit;
		
		$hasil = $this->Visit_plan_log_model->update_data($no, $USER);
		echo json_encode($hasil);
	}
	public function Ajax_hapus()
	{	
		$USER 		= $this->session->userdata('user_id');
		$no			= $this->input->post("no");
		
		$hasil = $this->Visit_plan_log_model->hapus_data($no, $USER);
		echo json_encode($hasil);
	}
}
?> 