<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Sales_Tahunan extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Sales_Tahunan_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		//$data['list'] 		= $this->make_isi_table($this->Sales_Tahunan_model->get_data());
		$data['list_sales'] = $this->Sales_Tahunan_model->get_sales();
		
		$this->template->display('Sales_Tahunan_view', $data);
		
    }
	
	public function tampildata(){
		
	$idsales		= $this->input->post("idsales");
	$hasil			= $this->Sales_Tahunan_model->get_data($idsales);
		
	echo json_encode($hasil);
	
	}
	
	public function Ajax_data_id()
	{
		$nojadwal	 	= $this->input->post("nojadwal");
		$hasil			= $this->Sales_Tahunan_model->get_jadwal($nojadwal);
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	// private function make_isi_table($hasil)
	// {
		// $isi ='';
		// $no =1;
		// foreach($hasil as $h){
			// $senin 	= '<input type="checkbox" id="senin" value ="" class="filled-in"><label for=""></label>';
			// $selasa = '<input type="checkbox" id="selasa" value ="" class="filled-in"><label for=""></label>';
			// $rabo 	= '<input type="checkbox" id="rabo" value ="" class="filled-in"><label for=""></label>';
			// $kamis 	= '<input type="checkbox" id="kamis" value ="" class="filled-in"><label for=""></label>';
			// $jumat 	= '<input type="checkbox" id="jumat" value ="" class="filled-in"><label for=""></label>';
			// $sabtu 	= '<input type="checkbox" id="sabtu" value ="" class="filled-in"><label for=""></label>';
			// $minggu = '<input type="checkbox" id="minggu" value ="" class="filled-in"><label for=""></label>';
			// $week1 	= '<input type="checkbox" id="week1" value ="" class="filled-in"><label for=""></label>';
			// $week2 	= '<input type="checkbox" id="week2" value ="" class="filled-in"><label for=""></label>';
			// $week3 	= '<input type="checkbox" id="week3" value ="" class="filled-in"><label for=""></label>';
			// $week4 = '<input type="checkbox" id="week4" value ="" class="filled-in"><label for=""></label>';
			// $btn_save = '<button class="btn btn-success waves-effect " id="save" idpd="'.$h['ID_CUSTOMER'].'"><span class="fa fa-save"></span></button>';
			// $btn_tambah = '<button class="btn btn-danger waves-effect " id="tambah" idpd="'.$h['ID_CUSTOMER'].'"><span class="fa fa-plus"></span></button>';
			// $isi .= '<tr>';
			// $isi .= '<td>'.$no.'</td>';
			// $isi .= '<td>'.$h['ID_CUSTOMER'].'</td>';
			// $isi .= '<td>'.$h['NAMA_PEMILIK'].'</td>';
			// $isi .= '<td>'.$h['ALAMAT'].'</td>';
			// $isi .= '<td>'.$senin.'</td>';
			// $isi .= '<td>'.$selasa.'</td>';
			// $isi .= '<td>'.$rabo.'</td>';
			// $isi .= '<td>'.$kamis.'</td>';
			// $isi .= '<td>'.$jumat.'</td>';
			// $isi .= '<td>'.$sabtu.'</td>';
			// $isi .= '<td>'.$minggu.'</td>';
			// $isi .= '<td>'.$week1.'</td>';
			// $isi .= '<td>'.$week2.'</td>';
			// $isi .= '<td>'.$week3.'</td>';
			// $isi .= '<td>'.$week4.'</td>';
			// $isi .= '<td>'.$btn_save. ' ' .$btn_tambah.'</td>';
			// $isi .= '</tr>';
			
			// $no=$no+1;
		// }
		
		// return $isi;
	// }
	
	
	// public function Ajax_tambah_data()
	// {
		// $idsales		= $this->input->post("idsales");
		// $senin			= $this->input->post("senin");
		// $selasa			= $this->input->post("selasa");
		// $rabo			= $this->input->post("rabo");
		// $kamis			= $this->input->post("kamis");
		// $jumat			= $this->input->post("jumat");
		// $sabtu			= $this->input->post("sabtu");
		// $minggu			= $this->input->post("minggu");
		// $week1			= $this->input->post("week1");
		// $week2			= $this->input->post("week2");
		// $week3			= $this->input->post("week3");
		// $week4			= $this->input->post("week4");
		
		// $hasil = $this->Sales_Tahunan_model->insert_data($idsales,$senin,$selasa,$rabo,$kamis,$jumat,$sabtu,$minggu,$week1,$week2,$week3,$week4);
		// echo json_encode($hasil);
	// }

}
?> 