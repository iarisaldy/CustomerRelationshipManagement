<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
		$this->load->model('Koperasimodel');
    }

    public function index(){
        
		$data = $this->Koperasimodel->getdata();
		$this->load->view('simple', $data);
		
    }
	// private function make_isi_table($data){
		
	// 	$isi = '';
	// 	foreach($data as $d){
	// 		$btn_tambah_stok = '<button class="btn btn-primary waves-effect" id="edit"><span class="fa fa-list"></span></button>';
	// 		$btn_DM_stok = '<button class="btn btn-danger waves-effect" id="hapus"><span class="fa fa-trash"></span></button>';
	// 		$isi .= '<tr>';
	// 		$isi .= '<td>'.$d['no_ktp'].'</td>';
	// 		$isi .= '<td>'.$d['nama'].'</td>';
	// 		$isi .= '<td>'.$d['jenis_kelamin'].'</td>';
	// 		$isi .= '<td>'.$d['tanggal_lahir'].'</td>';
	// 		$isi .= '<td>'.$d['foto'].'</td>';
	// 		$isi .= '<td>'.$d['alamat'].'</td>';
	// 		$isi .= '<td>'.$btn_tambah_stok. ' ' .$btn_DM_stok.'</td>';
	// 		$isi .= '</tr>';
	// 	}
	// 	return $isi;
	// }

	public function dataall(){
        $data=$this->Koperasimodel->getdata();
        echo json_encode($data);
    }

	public function Ajax_get_data_id()
	{	
		$no_ktp	= $this->input->get("id");
		$data = $this->Koperasimodel->get_by_id($no_ktp);
		echo json_encode($data);
	}

	public function Ajax_tambah_data()
	{	
		$no_ktp			= $this->input->post("no_ktp");
		$nama 			= $this->input->post("nama");
		$kelamin 		= $this->input->post("kelamin");
		$usia 			= $this->input->post("tanggal_lahir");//date('d-M-Y', strtotime($usia));
		$foto 			= $this->input->post("foto");
		$alamat 		= $this->input->post("alamat");

		$data=$this->Koperasimodel->insertdata($no_ktp,$nama,$kelamin,$usia,$foto,$alamat);
		echo json_encode($data);
	}

	public function Ajax_update_data()
	{	
		$no_ktp			= $this->input->post("no_ktp");
		$nama 			= $this->input->post("nama");
		$kelamin 		= $this->input->post("kelamin");
		$usia 			= $this->input->post("tanggal_lahir");//date('d-M-Y', strtotime($usia));
		$foto 			= $this->input->post("foto");
		$alamat 		= $this->input->post("alamat");

		$data = $this->Koperasimodel->updatedata($no_ktp,$nama,$kelamin,$usia,$foto,$alamat);
		echo json_encode($data);
	}

	public function Ajax_delete_data()
	{	
		$no_ktp	= $this->input->get("no_ktp");

		$data = $this->Koperasimodel->deletedata($no_ktp);
		echo json_encode($data);
	}
}
