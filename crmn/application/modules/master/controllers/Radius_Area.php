<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Radius_Area extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('Master_Radius_Area_model');
    }
	
	public function index()
	{
		$data = array("title"=>"Setting Radius Lock Area");
		
		$data['areas'] = $this->Master_Radius_Area_model->get_area();
		$data['radius_areas'] = $this->Master_Radius_Area_model->get_data();
		
		$this->template->display('Radius_Area_view', $data);
    }
	
	public function action_add_data()
	{
		$data['id_area']		= $this->input->post('id_area');
		$data['radius_lock']	= $this->input->post('radius_lock');
		
		$data['user'] = $this->session->userdata('id_jenis_user');
		
		$this->Master_Radius_Area_model->add_data($data);
    	
		$this->session->set_userdata('status_act', 'Penambahan Radius Area berhasil.');
		redirect(site_url('master/Radius_Area'));
	}
	
	public function action_update_data()
	{
		$data['id_radius_area'] 	= $this->input->post('id_radius_area');
		
		$data['id_area']	= $this->input->post('id_area');
		$data['radius_lock']	= $this->input->post('radius_lock');
	
		$data['user'] = $this->session->userdata('id_jenis_user');
		
		$this->Master_Radius_Area_model->update_data($data);
    	
		$this->session->set_userdata('status_act', 'Edit Radius Area berhasil.');
		redirect(site_url('master/Radius_Area'));
	}
	
	public function action_delete_data()
	{
		$id_radius_area = $this->input->post('id_radius_area1');
		
		$this->Master_Radius_Area_model->make_delete_data($id_radius_area);
		
		$this->session->set_userdata('status_act', 'Hapus Radius Area berhasil.');
		redirect(site_url('master/Radius_Area'));
	}

}