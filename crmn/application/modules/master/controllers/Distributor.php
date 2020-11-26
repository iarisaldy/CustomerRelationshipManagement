<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Distributor extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('M_A_Distributor');
    }
	
	public function index()
	{
		$data = array("title"=>"Data Distributor");
		$data['distributors'] = $this->M_A_Distributor->get_distributor();
		
		$this->template->display('V_A_Distributor', $data);
    }
	
	public function ajax_data()
	{
		$kode	= $this->input->post("kode");
		$hasil 	= $this->M_A_Distributor->get_distributor($kode);
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
		//echo json_encode($hasil);
	}
	
	public function action_add_dist()
	{
		$data['kode'] = $this->input->post('kode_distributor');
		$data['nama'] = $this->input->post('nama_distributor');
		$data['flag'] = $this->input->post('flag');
		$data['user'] = $this->session->userdata('id_jenis_user');
		
		$this->M_A_Distributor->add_distributor($data);
		$hasil = $this->M_A_Distributor->get_distributor();
    	//echo json_encode(array('notify' => 1, 'html' => $hasil));
		$this->session->set_userdata('status_act', 'Penambahan data distributor berhasil.');
		redirect(site_url('master/Distributor'));
	}
	
	public function action_update_dist()
	{
		$data['kode_lama'] = $this->input->post('kode_lama');
		
		$data['kode'] = $this->input->post('kode_distributor');
		$data['nama'] = $this->input->post('nama_distributor');
		$data['flag'] = $this->input->post('flag');
		$data['user'] = $this->session->userdata('id_jenis_user');
		
		$this->M_A_Distributor->update_distributor($data);
		$hasil = $this->M_A_Distributor->get_distributor();
    	//echo json_encode(array('notify' => 1, 'html' => $hasil));
		$this->session->set_userdata('status_act', 'Perubahan data distributor berhasil.');
		redirect(site_url('master/Distributor'));
	}
	
	public function action_delete_dist()
	{
		$kode = $this->input->post('kode');
		
		$this->M_A_Distributor->make_delete_distributor($kode);
		$hasil = $this->M_A_Distributor->get_distributor();
    	//echo json_encode(array('notify' => 1, 'html' => $hasil));
		
		$this->session->set_userdata('status_act', 'Hapus data distributor berhasil.');
		redirect(site_url('master/Distributor'));
	}
}

