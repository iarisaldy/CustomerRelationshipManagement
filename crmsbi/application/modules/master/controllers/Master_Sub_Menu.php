<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Master_Sub_Menu extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('M_Submenu_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list'] = $this->make_isi_table($this->M_Submenu_model->get_data());
		$data['list_menu'] = $this->M_Submenu_model->get_menu();
		
		$this->template->display('M_Submenu_view', $data);
		
    }
	
	private function make_isi_table($data)
	{
		$isi = '';
		$no =1;
		foreach($data as $d){
			$btn_edit = '<button class="btn btn-info waves-effect " id="edit_Submenu" idpd="'.$d['ID_SUBMENU'].'"><span class="fa fa-pencil-square-o"></span></button>';
			$btn_hapus = '<button class="btn btn-danger waves-effect" id="Hapus_Submenu" idpd="'.$d['ID_SUBMENU'].'"><span class="fa fa-trash-o "></span></button>';
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$d['ID_SUBMENU'].'</td>';
			$isi .= '<td>'.$d['NAMA_MENU'].'</td>';
			$isi .= '<td>'.$d['MENU'].'</td>';
			$isi .= '<td><center>'.$btn_edit. ' ' .$btn_hapus.'</center></td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		return $isi;
	}
	
	public function Ajax_data_id()
	{
		
		$id_submenu 	= $this->input->post("id_submenu");
		$hasil			= $this->M_Submenu_model->get_data_id($id_submenu);
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_tambah_data()
	{
		$id_menu 			= $this->input->post("id_menu");
		$nama_menu			= $this->input->post("nama_menu");
		$link				= $this->input->post("link");
		$USER 				= $this->session->userdata('user_id');
		
		$this->M_Submenu_model->insert_data($id_menu,$nama_menu,$link,$USER);
		$hasil = $this->make_isi_table($this->M_Submenu_model->get_data());
    	echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_simpan_edit()
	{	
		$id_submenu		= $this->input->post("id_submenu");
		$id_menu		= $this->input->post("id_menu");
		$nama_menu		= $this->input->post("nama_menu");
		$link			= $this->input->post("link");
		$USER 			= $this->session->userdata('user_id');
		
		$this->M_Submenu_model->update_data($id_submenu,$id_menu, $nama_menu, $link, $USER);
		$hasil = $this->make_isi_table($this->M_Submenu_model->get_data());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_hapus_data()
	{
		$id_submenu 		= $this->input->post("id_submenu");
		$USER 				= $this->session->userdata('user_id');
		
		$this->M_Submenu_model->hapus_data($id_submenu, $USER);
		$hasil = $this->make_isi_table($this->M_Submenu_model->get_data());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
}
?> 