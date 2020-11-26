<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Master_Reason extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('M_Master_Reason');
    }
	
	public function index()
	{
		$data = array("title"=>"Data Master Reason");
		$data['master_reasons'] = $this->M_Master_Reason->get_master_reason();
		
		$this->template->display('V_Master_Reason', $data);
    }
	
	public function ajax_data()
	{
		$id_mr	= $this->input->post("id_mr");
		$hasil 	= $this->M_Master_Reason->get_master_reason($id_mr);
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function action_add_mr()
	{
		$data['id_mr'] 		= $this->input->post('id_mr');
		$data['nama_mr'] 	= $this->input->post('nama_mr');
		$data['deskripsi'] 	= $this->input->post('deskripsi');
		$data['user'] 		= $this->session->userdata('id_jenis_user');
		
		$this->M_Master_Reason->add_master_reason($data);
    	
		$this->session->set_userdata('status_act', 'Penambahan data master reason berhasil.');
		redirect(site_url('master/Master_Reason'));
	}
	
	public function action_update_mr()
	{
		$data['id_mr_lama'] = $this->input->post('id_mr_lama');
		
		$data['id_mr'] 		= $this->input->post('id_mr');
		$data['nama_mr'] 	= $this->input->post('nama_mr');
		$data['deskripsi'] 	= $this->input->post('deskripsi');
		$data['user'] 		= $this->session->userdata('id_jenis_user');
		
		$this->M_Master_Reason->update_master_reason($data);
		
		$this->session->set_userdata('status_act', 'Perubahan data master reason berhasil.');
		redirect(site_url('master/Master_Reason'));
	}
	
	public function action_delete_mr()
	{
		$id_mr = $this->input->post('kode');
		
		$this->M_Master_Reason->make_delete_master_reason($id_mr);
	
		$this->session->set_userdata('status_act', 'Hapus data master reason berhasil.');
		redirect(site_url('master/Master_Reason'));
	}
}

