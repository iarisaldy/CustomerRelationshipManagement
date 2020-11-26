<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Mapping_Produk_Area extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Mapping_Produk_Area_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list'] = $this->make_isi_table($this->Mapping_Produk_Area_model->get_data());
		$data['list_area'] = $this->Mapping_Produk_Area_model->get_area();
		$data['list_produk'] = $this->Mapping_Produk_Area_model->get_produk();
		
		$this->template->display('Mapping_Produk_Area_view', $data);
		
    }
	
	private function make_isi_table($data)
	{
		$isi = '';
		$no =1;
		foreach($data as $d){
			$btn_edit = '<button class="btn btn-info waves-effect " id="edit" idpd="'.$d['NO_MAPPING'].'"><span class="fa fa-pencil-square-o"></span></button>';
			$btn_hapus = '<button class="btn btn-danger waves-effect" id="Hapus" idpd="'.$d['NO_MAPPING'].'"><span class="fa fa-trash-o "></span></button>';
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$d['ID_AREA'].'</td>';
			$isi .= '<td>'.$d['NAMA_AREA'].'</td>';
			$isi .= '<td>'.$d['ID_PRODUK'].'</td>';
			$isi .= '<td>'.$d['NAMA_PRODUK'].'</td>';
			$isi .= '<td><center>'.$btn_edit. ' ' .$btn_hapus.'</center></td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		return $isi;
	}
	
	public function Ajax_data_id()
	{
		$id_map	 			= $this->input->post("id");
		$hasil				= $this->Mapping_Produk_Area_model->get_data_id($id_map);
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_tambah_data()
	{
		$id_area 			= $this->input->post("id_area");
		$id_produk			= $this->input->post("id_produk");
		$USER 				= $this->session->userdata('user_id');
		
		$this->Mapping_Produk_Area_model->insert_data($id_area, $id_produk,$USER);
		$hasil = $this->make_isi_table($this->Mapping_Produk_Area_model->get_data());
    	echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_simpan_edit()
	{	
		$no_map			= $this->input->post("no_map");
		$id_area		= $this->input->post("id_area");
		$id_produk		= $this->input->post("id_produk");
		$USER 			= $this->session->userdata('user_id');
		
		$this->Mapping_Produk_Area_model->update_data($no_map, $id_area, $id_produk, $USER);
		$hasil = $this->make_isi_table($this->Mapping_Produk_Area_model->get_data());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	// public function Ajax_hapus_data()
	// {
		// $id_user 			= $this->input->post("id_user");
		// $USER 				= $this->session->userdata('user_id');
		
		// $this->M_Role_User_model->hapus_data($id_user, $USER);
		// $hasil = $this->make_isi_table($this->M_Role_User_model->get_data());
		// echo json_encode(array('notify' => 1, 'html' => $hasil));
	// }
}
?> 