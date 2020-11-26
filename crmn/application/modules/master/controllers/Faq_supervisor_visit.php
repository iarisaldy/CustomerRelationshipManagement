<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Faq_supervisor_visit extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('Faq_supervisor_visit_model');
    }
	
	public function index()
	{
		$data = array("title"=>"FAQ Supervisor Visit");
		
		$data['faqs'] = $this->Faq_supervisor_visit_model->get_data();
		
		// print_r($this->session->userdata());
		// exit();
		
		$this->template->display('Faq_supervisor_visit_view', $data);
    }
	
	public function action_add_data()
	{
		$data['tanya']		= $this->input->post('tanya');
		$data['jawab']		= $this->input->post('jawab');
		
		$data['user'] = $this->session->userdata('user_id');
		
		$this->Faq_supervisor_visit_model->add_data($data);
		
		$this->session->set_userdata('status_act', 'Penambahan Faq supervisor visit berhasil.');
		redirect(site_url('master/Faq_supervisor_visit'));
	}
	
	public function action_update_data()
	{
		$data['id_faq']		= $this->input->post('id_faq');
		$data['tanya']		= $this->input->post('tanya');
		$data['jawab']		= $this->input->post('jawab'); 
	
		$data['user'] = $this->session->userdata('user_id');
		
		$this->Faq_supervisor_visit_model->update_data($data);
    	
		$this->session->set_userdata('status_act', 'Edit Faq supervisor visit berhasil.');
		redirect(site_url('master/Faq_supervisor_visit'));
	}
	
	public function action_delete_data()
	{
		$id_faq = $this->input->post('id_faq1');
		
		$this->Faq_supervisor_visit_model->make_delete_data($id_faq);
		
		$this->session->set_userdata('status_act', 'Hapus Faq supervisor visit berhasil.');
		redirect(site_url('master/Faq_supervisor_visit'));
	}

}