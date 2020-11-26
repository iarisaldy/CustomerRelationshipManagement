<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Master_Menu extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Master_Menu_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list'] = $this->make_isi_table($this->Master_Menu_model->get_data());
		
		$this->template->display('Master_Menu_view', $data);
		
    }
	
	private function make_isi_table($data)
	{
		$isi = '';
		$no =1;
		foreach($data as $d){
			$btn_edit = '<button class="btn btn-info waves-effect " id="edit_produk" idpd="'.$d['ID_MENU'].'"><span class="fa fa-pencil-square-o"></span></button>';
			$btn_hapus = '<button class="btn btn-danger waves-effect" id="Hapus_produk" idpd="'.$d['ID_MENU'].'"><span class="fa fa-trash-o "></span></button>';
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$d['ID_MENU'].'</td>';
			$isi .= '<td>'.$d['NAMA_MENU'].'</td>';
			$isi .= '<td><center>'.$btn_edit. ' ' .$btn_hapus.'</center></td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		return $isi;
	}
	
	public function Ajax_data_id()
	{
		
		$id_menu 	= $this->input->post("id_menu");
		$hasil 		= $this->Master_Menu_model->get_data_id($id_menu);
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_tambah_data()
	{
		
		$nama_menu		= $this->input->post("nama_menu");
		$USER 			= $this->session->userdata('user_id');
		
		$this->Master_Menu_model->insert_data($nama_menu, $USER);
		$hasil = $this->make_isi_table($this->Master_Menu_model->get_data());
    	echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	public function Ajax_simpan_edit()
	{	
		$USER 			= $this->session->userdata('user_id');
		$id 			= $this->input->post("id");
		$nama_menu		= $this->input->post("nama_menu");
		
		$this->Master_Menu_model->update_data($id, $nama_menu, $USER);
		$hasil = $this->make_isi_table($this->Master_Menu_model->get_data());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	public function Ajax_hapus_data()
	{
    	$USER 			= $this->session->userdata('user_id');
		$id_menu 		= $this->input->post("id_menu");
		
		$this->Master_Menu_model->hapus_data($id_menu, $USER);
		$hasil = $this->make_isi_table($this->Master_Menu_model->get_data());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
}
?> 