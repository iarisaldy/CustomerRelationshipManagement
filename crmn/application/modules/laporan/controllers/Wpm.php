<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Wpm extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Wpm_model');
		$this->load->model('Data_sales_model');
    }

    public function index(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Data_sales_model->Get_region_all();
		$this->template->display('wpm', $data);
    }
	public function datawpm(){
		$region = $this->input->post("region");
		$prov 	= $this->input->post("id_prov");
		
		$id_user = $this->session->userdata('user_id');
		
		$hasil = $this->make_table_hasil($this->Wpm_model->data_wpm($region, $prov));
		
		echo json_encode($hasil);
	}
	private function make_table_hasil($hasil){
		$isi ='';
		$no =1;
		$c = "x";
		foreach($hasil as $h){
			//$btn_tambah_stok = '<button class="btn btn-primary waves-effect Tambah_stok_history" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'"><span class="fa fa-pencil"></span></button>';
			//$btn_DM_stok = '<button class="btn btn-success waves-effect" id="Tampilkan_history_distributor" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'"><span class="fa fa-list"></span></button>';
			$isi .= '<tr class="'.$c.'">';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['ID_CUSTOMER'].'</td>';
			$isi .= '<td>'.$h['NAMA_TOKO'].'</td>';
			$isi .= '<td>'.$h['NAMA_DISTRIBUTOR'].'</td>';
			$isi .= '<td>'.$h['NEW_REGION'].'</td>';
			$isi .= '<td>'.$h['NAMA_PROVINSI'].'</td>';
			$isi .= '<td>'.$h['NAMA_DISTRIK'].'</td>';
			$isi .= '<td>'.$h['NAMA_KECAMATAN'].'</td>';
			if($h['STATUS']==null){
				$isi .= '<td><span class="label label-warning">NON WPM</span></td>';
				$isi .= '<td><button class="btn btn-primary" onclick="SAVE('.$h['ID_CUSTOMER'].')" ><span class="fa fa-save"></span></button></td>';
			}
			else {
				$isi .= '<td><span class="label label-success">WPM</span></td>';
				$isi .= '<td><button class="btn btn-danger" onclick="Delete('.$h['ID_CUSTOMER'].')" ><span class="fa fa-trash-o"></span></button></td>';
			}
			$isi .= '</tr>';
			
			$no=$no+1;
			if($c=="x"){
				$c = "y"  ;
			}else{
				$c = "x" ;
			}
		}
		return $isi;
	}
	public function Delete_wpm(){
		$idc = $this->input->post("id_customer");
		$id_user = $this->session->userdata('user_id');
		
		$a = "DELETE FROM CRMNEW_TOKO_WPM WHERE ID_CUSTOMER='$idc' ";
		$hasil = $this->Wpm_model->crud($a);
		
		if($hasil){
			$array = array('Data Berhasil Di Hapus');
			echo json_encode($array);
		}
		
	}
	public function SIMPAN_wpm(){
		$idc = $this->input->post("id_customer");
		$id_user = $this->session->userdata('user_id');
		
		$a = "INSERT INTO CRMNEW_TOKO_WPM 
				(ID_CUSTOMER,
				CREATE_BY,
				CRETE_DATE,
				DELETE_MARK)
				VALUES 
				('$idc','$id_user',SYSDATE,'0') ";
				
		$hasil = $this->Wpm_model->crud($a);
		
		if($hasil){
			$array = array('Data Berhasil Di Simpan');
			echo json_encode($array);
		}
	}
}
?> 