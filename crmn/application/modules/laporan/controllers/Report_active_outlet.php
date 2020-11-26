<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Report_active_outlet extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Active_outlet_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		//$data['list'] = $this->make_isi_table($this->Report_visit_model->get_data());
		// $id_user = $this->session->userdata('user_id');
		// $data['list_distributor'] = $this->Report_visit_model->User_distributor($id_user);
		// $data['list_sales'] = $this->Report_visit_model->User_SALES($id_user);
		$this->template->display('Active_outlet_view', $data);
		
    }
	
	public function filterdata(){
	// $tanggalawal 	= $this->input->post("start_date");
    // $tanggalselesai = $this->input->post("end_date");
	// $sales		 	= $this->input->post("sales");
    // $kd_distributor = $this->input->post("kd_distributor");
		
	// $hasil			= $this->Report_visit_model->get_data_filter_visit($tanggalawal ,$tanggalselesai, $kd_distributor, $sales);
		
	// echo json_encode($hasil);		
	}
	
	public function Ajax_data_id()
	{
		
	}
	
	public function Ajax_tambah_data()
	{
		
	}
	public function Ajax_simpan_edit()
	{

	}
	public function Ajax_hapus_data()
	{

	}
}
?> 