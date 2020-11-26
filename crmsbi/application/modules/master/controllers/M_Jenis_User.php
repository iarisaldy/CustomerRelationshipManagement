<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class M_Jenis_User extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('M_Jenisuser_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list'] = $this->make_isi_table($this->M_Jenisuser_model->get_data());
		
		$this->template->display('M_Jenisuser_view', $data);
		
    }
	
	private function make_isi_table($data)
	{
		$isi = '';
		$no =1;
		foreach($data as $d){
			$btn_edit = '<button class="btn btn-info waves-effect " id="edit_jenis" idpd="'.$d['ID_JENIS_USER'].'"><span class="fa fa-pencil-square-o"></span></button>';
			$btn_hapus = '<button class="btn btn-danger waves-effect" id="Hapus_jenis" idpd="'.$d['ID_JENIS_USER'].'"><span class="fa fa-trash-o "></span></button>';
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$d['ID_JENIS_USER'].'</td>';
			$isi .= '<td>'.$d['JENIS_USER'].'</td>';
			$isi .= '<td><center>'.$btn_edit. ' ' .$btn_hapus.'</center></td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		return $isi;
	}
	public function Ajax_data_id()
	{
		
		$id_jns_user 	= $this->input->post("id");
		$hasil			= $this->M_Jenisuser_model->get_data_id($id_jns_user);
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	public function Ajax_tambah_data()
	{
		$jns_user			= $this->input->post("jenis_user");
		$USER 				= $this->session->userdata('user_id');
		
		$this->M_Jenisuser_model->insert_data($jns_user, $USER);
		$hasil = $this->make_isi_table($this->M_Jenisuser_model->get_data());
    	echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	public function Ajax_simpan_edit()
	{	
		$id_jns_user	= $this->input->post("id_jns_user");
		$jns_user		= $this->input->post("jenis_user");
		$USER 			= $this->session->userdata('user_id');
		
		$this->M_Jenisuser_model->update_data($id_jns_user, $jns_user, $USER);
		$hasil = $this->make_isi_table($this->M_Jenisuser_model->get_data());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_hapus_data()
	{
		$id_jenis	 		= $this->input->post("id");
		$USER 				= $this->session->userdata('user_id');
		
		$this->M_Jenisuser_model->hapus_data($id_jenis, $USER);
		$hasil = $this->make_isi_table($this->M_Jenisuser_model->get_data());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
}
?> 