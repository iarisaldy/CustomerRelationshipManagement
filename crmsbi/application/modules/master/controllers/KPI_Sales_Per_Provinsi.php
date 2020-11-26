<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class KPI_Sales_Per_Provinsi extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('M_KPI_Sales_Per_Provinsi');
    }
	
	public function index()
	{
		$data = array("title"=>"Data Index KPI Sales per Provinsi");
		
		$data['provs'] = $this->M_KPI_Sales_Per_Provinsi->get_prov();
		$data['index_kpi'] = $this->M_KPI_Sales_Per_Provinsi->get_data();
		
		$this->template->display('V_KPI_Sales_Per_Provinsi', $data);
    }
	
	public function action_add_data()
	{
		$data['id_prov']	= $this->input->post('id_prov');
		$data['visit']		= $this->input->post('visit');
		$data['c_a']		= $this->input->post('c_a');
		$data['noo']		= $this->input->post('noo');
		$data['vso']		= $this->input->post('vso');
		$data['harga']		= $this->input->post('harga');
		$data['revenue']	= $this->input->post('revenue');
	
		$data['user'] = $this->session->userdata('id_jenis_user');
		
		$this->M_KPI_Sales_Per_Provinsi->add_data($data);
    	
		$this->session->set_userdata('status_act', 'Penambahan Index KPI Sales per Provinsi berhasil.');
		redirect(site_url('master/KPI_Sales_Per_Provinsi'));
	}
	
	public function action_update_data()
	{
		$data['no_index'] 	= $this->input->post('id_index');
		
		$data['id_prov']	= $this->input->post('id_prov');
		$data['visit']		= $this->input->post('visit');
		$data['c_a']		= $this->input->post('c_a');
		$data['noo']		= $this->input->post('noo');
		$data['vso']		= $this->input->post('vso');
		$data['harga']		= $this->input->post('harga');
		$data['revenue']	= $this->input->post('revenue');
	
		$data['user'] = $this->session->userdata('id_jenis_user');
		
		$this->M_KPI_Sales_Per_Provinsi->update_data($data);
    	
		$this->session->set_userdata('status_act', 'Edit Index KPI Sales per Provinsi berhasil.');
		redirect(site_url('master/KPI_Sales_Per_Provinsi'));
	}
	
	public function action_delete_data()
	{
		$id_index = $this->input->post('id_index');
		
		$this->M_KPI_Sales_Per_Provinsi->make_delete_data($id_index);
		
		$this->session->set_userdata('status_act', 'Hapus Index KPI Sales per Provinsi berhasil.');
		redirect(site_url('master/KPI_Sales_Per_Provinsi'));
	}
	
}