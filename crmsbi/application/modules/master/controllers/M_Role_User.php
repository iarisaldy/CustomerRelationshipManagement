<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class M_Role_User extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('M_Role_User_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list'] = $this->make_isi_table($this->M_Role_User_model->get_data());
		$data['list_jenis'] = $this->M_Role_User_model->get_jenis();
		$data['list_menu'] = $this->M_Role_User_model->get_menu();
		
		$this->template->display('M_Role_User_view', $data);
		
    }
	
	private function make_isi_table($data)
	{
		$isi = '';
		$no =1;
		foreach($data as $d){
			$btn_edit = '<button class="btn btn-info waves-effect " id="edit_user" idpd="'.$d['ID_USER_AKSES'].'"><span class="fa fa-pencil-square-o"></span></button>';
			$btn_hapus = '<button class="btn btn-danger waves-effect" id="Hapus_user" idpd="'.$d['ID_USER_AKSES'].'"><span class="fa fa-trash-o "></span></button>';
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$d['ID_USER_AKSES'].'</td>';
			$isi .= '<td>'.$d['JENIS_USER'].'</td>';
			$isi .= '<td>'.$d['NAMA_MENU'].'</td>';
			$isi .= '<td><center>'.$btn_edit. ' ' .$btn_hapus.'</center></td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		return $isi;
	}
	
	public function Ajax_data_id()
	{
		$id_user	 	= $this->input->post("id");
		$hasil			= $this->M_Role_User_model->get_data_id($id_user);
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_tambah_data()
	{
		$id_jenis 			= $this->input->post("id_jenis");
		$id_menu			= $this->input->post("id_menu");
		$USER 				= $this->session->userdata('user_id');
		
		$this->M_Role_User_model->insert_data($id_jenis, $id_menu,$USER);
		$hasil = $this->make_isi_table($this->M_Role_User_model->get_data());
    	echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	public function Ajax_simpan_edit()
	{	
		$id_user_akses	= $this->input->post("id_user_akses");
		$id_jenis		= $this->input->post("id_jenis");
		$id_menu		= $this->input->post("id_menu");
		$USER 			= $this->session->userdata('user_id');
		
		$this->M_Role_User_model->update_data($id_user_akses, $id_jenis, $id_menu, $USER);
		$hasil = $this->make_isi_table($this->M_Role_User_model->get_data());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_hapus_data()
	{
		$id_user 			= $this->input->post("id_user");
		$USER 				= $this->session->userdata('user_id');
		
		$this->M_Role_User_model->hapus_data($id_user, $USER);
		$hasil = $this->make_isi_table($this->M_Role_User_model->get_data());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
}
?> 