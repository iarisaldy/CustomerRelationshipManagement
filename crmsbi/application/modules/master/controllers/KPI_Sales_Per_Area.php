<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class KPI_Sales_Per_Area extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('M_KPI_Sales_Per_Area');
    }
	
	public function index()
	{
		$data = array("title"=>"Data Index KPI Sales per Area");
		
		$data['areas'] = $this->M_KPI_Sales_Per_Area->get_area();
		$data['index_kpi'] = $this->M_KPI_Sales_Per_Area->get_data();
		
		$this->template->display('V_KPI_Sales_Per_Area', $data);
    }
	
	public function action_add_data()
	{
		$data['id_area']	= $this->input->post('id_area');
		$data['visit']		= $this->input->post('visit');
		$data['c_a']		= $this->input->post('c_a');
		$data['noo']		= $this->input->post('noo');
		$data['vso']		= $this->input->post('vso');
		$data['harga']		= $this->input->post('harga');
		$data['revenue']	= $this->input->post('revenue');
	
		$data['user'] = $this->session->userdata('id_jenis_user');
		
		$this->M_KPI_Sales_Per_Area->add_data($data);
    	
		$this->session->set_userdata('status_act', 'Penambahan Index KPI Sales per Area berhasil.');
		redirect(site_url('master/KPI_Sales_Per_Area'));
	}
	
	public function action_update_data()
	{
		$data['no_index'] 	= $this->input->post('id_index');
		
		$data['id_area']	= $this->input->post('id_area');
		$data['visit']		= $this->input->post('visit');
		$data['c_a']		= $this->input->post('c_a');
		$data['noo']		= $this->input->post('noo');
		$data['vso']		= $this->input->post('vso');
		$data['harga']		= $this->input->post('harga');
		$data['revenue']	= $this->input->post('revenue');
	
		$data['user'] = $this->session->userdata('id_jenis_user');
		
		$this->M_KPI_Sales_Per_Area->update_data($data);
    	
		$this->session->set_userdata('status_act', 'Edit Index KPI Sales per Area berhasil.');
		redirect(site_url('master/KPI_Sales_Per_Area'));
	}
	
	public function action_delete_data()
	{
		$id_index = $this->input->post('id_index');
		
		$this->M_KPI_Sales_Per_Area->make_delete_data($id_index);
		
		$this->session->set_userdata('status_act', 'Hapus Index KPI Sales per Area berhasil.');
		redirect(site_url('master/KPI_Sales_Per_Area'));
	}
	
}