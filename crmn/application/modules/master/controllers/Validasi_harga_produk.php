<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Validasi_harga_produk extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('Validasi_harga_produk_model');
    }
	
	public function index()
	{
		$data = array("title"=>"Validasi harga produk");
		
		$data['produks'] = $this->Validasi_harga_produk_model->get_produk();
		$data['validasi_hargas'] = $this->Validasi_harga_produk_model->get_data();
		
		// print_r($this->session->userdata());
		// exit();
		
		$this->template->display('Validasi_harga_produk_view', $data);
    }
	
	public function action_add_data()
	{
		$data['id_produk']	= $this->input->post('id_produk');
		$data['hb_min']		= $this->input->post('hb_min');
		$data['hb_max']		= $this->input->post('hb_max');
		$data['hj_min']		= $this->input->post('hj_min');
		$data['hj_max']		= $this->input->post('hj_max');
		
		$data['user'] = $this->session->userdata('user_id');
		
		$data_is_exsis = $this->Validasi_harga_produk_model->get_data($data['id_produk']);
		if(sizeof($data_is_exsis) == 0){
			$this->Validasi_harga_produk_model->add_data($data);
		}
		$this->session->set_userdata('status_act', 'Penambahan Validasi harga produk berhasil.');
		redirect(site_url('master/Validasi_harga_produk'));
	}
	
	public function action_update_data()
	{
		$data['id_produk']	= $this->input->post('id_produk_hide');
		$data['hb_min']		= $this->input->post('hb_min');
		$data['hb_max']		= $this->input->post('hb_max');
		$data['hj_min']		= $this->input->post('hj_min');
		$data['hj_max']		= $this->input->post('hj_max'); 
	
		$data['user'] = $this->session->userdata('user_id');
		
		$this->Validasi_harga_produk_model->update_data($data);
    	
		$this->session->set_userdata('status_act', 'Edit Validasi harga produk berhasil.');
		redirect(site_url('master/Validasi_harga_produk'));
	}
	
	public function action_delete_data()
	{
		$id_produk = $this->input->post('id_produk1');
		
		$this->Validasi_harga_produk_model->make_delete_data($id_produk);
		
		$this->session->set_userdata('status_act', 'Hapus Validasi harga produk berhasil.');
		redirect(site_url('master/Validasi_harga_produk'));
	}

}