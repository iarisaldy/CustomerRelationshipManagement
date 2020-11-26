<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Aproduk_survey extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Aproduk_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_produk'] = $this->make_isi_table($this->Aproduk_model->get_data_produk());
		
		$this->template->display('Aproduk_view', $data);
		
    }
	
	private function make_isi_table($data)
	{
		$isi = '';
		$no =1;
		foreach($data as $d){
			$btn_edit = '<button class="btn btn-info waves-effect " id="edit_produk" idpd="'.$d['ID_PRODUK'].'"><span class="fa fa-pencil-square-o"></span></button>';
			$btn_hapus = '<button class="btn btn-danger waves-effect" id="Hapus_produk" idpd="'.$d['ID_PRODUK'].'"><span class="fa fa-trash-o "></span></button>';
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$d['ID_PRODUK'].'</td>';
			$isi .= '<td>'.$d['NAMA_PRODUK'].'</td>';
			$isi .= '<td>'.$d['JENIS_PRODUK'].'</td>';
			$isi .= '<td><center>'.$btn_edit. ' ' .$btn_hapus.'</center></td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		return $isi;
	}
	public function Ajax_data_Produk_id()
	{
		
		$id_produk 	= $this->input->post("id_produk");
		$hasil = $this->Aproduk_model->get_data_produk_id($id_produk);
		
    	//echo json_encode($hasil);
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	public function Ajax_tambah_data_Produk_dist()
	{
		
		$id_produk 		= $this->input->post("id_produk");
		$nama_produk	= $this->input->post("nama_produk");
		
		
		$this->Aproduk_model->insert_data_produk_dist($id_produk, $nama_produk);
		$hasil = $this->make_isi_table($this->Aproduk_model->get_data_produk());
    	echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	public function Ajax_simpan_edit_produk()
	{	
		$USER 			= $this->session->userdata('user_id');
		$id 			= $this->input->post("id");
		$id_produk 		= $this->input->post("id_produk");
		$nama_produk	= $this->input->post("nama_produk");
		
		$this->Aproduk_model->update_data_produk_dist($id,$id_produk, $nama_produk, $USER);
		$hasil = $this->make_isi_table($this->Aproduk_model->get_data_produk());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	public function Ajax_hapus_data_Produk()
	{
    	$USER 			= $this->session->userdata('user_id');
		$id_produk 		= $this->input->post("id_produk");
		$this->Aproduk_model->hapus_data_produk_dist($id_produk, $USER);
		$hasil = $this->make_isi_table($this->Aproduk_model->get_data_produk());
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
}
?> 