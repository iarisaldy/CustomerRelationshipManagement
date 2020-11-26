<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class KPI_Sales_Per_Distributor extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('M_KPI_Sales_Per_Distributor');
    }
	
	public function index()
	{
		$data = array("title"=>"Data Index KPI Sales SBI per Distributor");
		
		$data['distributors'] = $this->M_KPI_Sales_Per_Distributor->get_distributor();
		$data['index_kpi'] = $this->M_KPI_Sales_Per_Distributor->get_data();
		
		$this->template->display('V_KPI_Sales_Per_Distributor', $data);
    }
	
	public function action_add_data()
	{
		$data['id_dist']	= $this->input->post('id_dist');
		$data['visit']		= $this->input->post('visit');
		$data['c_a']		= $this->input->post('c_a');
		$data['noo']		= $this->input->post('noo');
		$data['vso']		= $this->input->post('vso');
	
		$data['user'] = $this->session->userdata('id_jenis_user');
		
		$this->M_KPI_Sales_Per_Distributor->add_data($data);
    	
		$this->session->set_userdata('status_act', 'Penambahan Index KPI Sales SBI per Distributor berhasil.');
		redirect(site_url('master/KPI_Sales_Per_Distributor'));
	}
	
	public function action_update_data()
	{
		$data['no_index'] 	= $this->input->post('id_index');
		
		$data['id_dist']	= $this->input->post('id_dist');
		$data['visit']		= $this->input->post('visit');
		$data['c_a']		= $this->input->post('c_a');
		$data['noo']		= $this->input->post('noo');
		$data['vso']		= $this->input->post('vso');
	
		$data['user'] = $this->session->userdata('id_jenis_user');
		
		$this->M_KPI_Sales_Per_Distributor->update_data($data);
    	
		$this->session->set_userdata('status_act', 'Edit Index KPI Sales SBI per Distributor berhasil.');
		redirect(site_url('master/KPI_Sales_Per_Distributor'));
	}
	
	public function action_delete_data()
	{
		$id_index = $this->input->post('id_index');
		
		$this->M_KPI_Sales_Per_Distributor->make_delete_data($id_index);
		
		$this->session->set_userdata('status_act', 'Hapus Index KPI Sales SBI per Distributor berhasil.');
		redirect(site_url('master/KPI_Sales_Per_Distributor'));
	}
	
}