<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Produk_distributor extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Produk_survey_model');
		
		set_time_limit(0);
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		//$data['pilihan_distributor'] = $this->make_option_distributor($this->Customer_sync_model->get_data_distributor());
		
		$data['jenis_produk'] = $this->make_option_jenis_produk($this->Produk_survey_model->get_dt_jenis_produk());

		$distributor=$this->session->userdata("kode_dist");
		$data['Stok_distributor'] = $this->make_table_Produk_dist($this->Produk_survey_model->get_data_produk_distributor($distributor));

		$this->template->display('produk_distributor', $data);
		
    }
    private function make_option_jenis_produk($hasil){

    	$isi ='<option value="">Pilihan Produk </option>';
    	foreach ($hasil as $h) {
    		$isi .= '<option value="'.$h['ID_JENIS_PRODUK'].'">'.$h['ID_JENIS_PRODUK'].' - '.$h['JENIS_PRODUK'].'</option>';
    	}

    	return $isi;
    }
    private function make_table_Produk_dist($hasil){
    	
    	$isi ='';
		$no =1;
		foreach($hasil as $h){
			$btn_tambah_stok = '<button class="btn btn-primary waves-effect Tambah_stok_history" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'"><span class="fa fa-pencil"></span></button>';
			$btn_DM_stok = '<button class="btn btn-success waves-effect" id="Tampilkan_history_distributor" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'"><span class="fa fa-list"></span></button>';
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['ID_PRODUK_DISTRIBUTOR'].'</td>';
			$isi .= '<td>'.strtoupper($h['NAMA_PRODUK']).'</td>';
			$isi .= '<td>'.$h['JENIS_PRODUK'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_STOK']).'</td>';
			$isi .= '<td>'.strtoupper($h['SATUAN']).'</td>';
			$isi .= '<td>'.$h['TGL_STOK'].'</td>';
			$isi .= '<td>'.$btn_tambah_stok. ' ' .$btn_DM_stok.'</td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		
		
		if(count($hasil)==0){
			//$isi .= '<tr><td colspan="8"><center>Tidak Ada Record </center></td></tr>';
		}

		return $isi;

    }
	
	public function Ajax_tambah_data_Produk_dist(){
		
		$Id_jenis_produk 	= $this->input->post("Id_jenis_produk");
		$nm_produk 			= $this->input->post("nm_produk");
		$stok 				= $this->input->post("stok");
		$satuan 			= $this->input->post("satuan");
		$kd_produk_sap 		= $this->input->post("kd_produk_sap");
		$tgl_stok 			= $this->input->post("tgl_stok");
		$tgl_stok			= date('d-M-Y', strtotime($tgl_stok));
		$hb_satuan 			= $this->input->post("hb_satuan");
		$hj_satuan 			= $this->input->post("hj_satuan");
		
		$id_user 			= $_SESSION['user_id'];
		$distributor 	 	= $_SESSION['kode_dist'];
		
		
		$idpd = $this->Produk_survey_model->insert_data_produk_dist($Id_jenis_produk, $distributor, $id_user, $nm_produk, $kd_produk_sap, $stok, $satuan, $tgl_stok, $hb_satuan, $hj_satuan);
		
		
		$this->Produk_survey_model->insert_history_stok($idpd, $stok, $satuan, $tgl_stok,  $distributor, $id_user, $hb_satuan, $hj_satuan);
		
		//Menampilkan Hasil Penambahan
		$hasil = $this->make_table_Produk_dist($this->Produk_survey_model->get_data_produk_distributor($distributor));
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
		
	}
	
	public function Ajax_tambah_stok_history(){
		
		$id_pd 				= $this->input->post("id_pd");
		$stok 				= $this->input->post("stok");
		$satuan 			= $this->input->post("satuan");
		$tgl_stok 			= $this->input->post("tgl_stok");
		$tgl_stok			= date('d-M-Y', strtotime($tgl_stok));
		$hb_satuan 			= $this->input->post("hb_satuan");
		$hj_satuan 			= $this->input->post("hj_satuan");
		
		
		$id_user 			= $_SESSION['user_id'];
		$distributor 	 	= $_SESSION['kode_dist'];
		
		$this->Produk_survey_model->insert_history_stok($id_pd, $stok, $satuan, $tgl_stok,  $distributor, $id_user, $hb_satuan, $hj_satuan);
		
		//Menampilkan Hasil Penambahan
		$hasil = $this->make_table_Produk_dist($this->Produk_survey_model->get_data_produk_distributor($distributor));
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
		
	}
	
	public function Ajax_tampil_stok_history(){
		
		$id_pd 				= $this->input->post("id_pd");
		$hasil 	= $this->make_table_history_stok($this->Produk_survey_model->get_history_stok_distributor($id_pd));
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
		
	}
	private function make_table_history_stok($hasil){
		
		$isi ='';
		$no =1;
		foreach($hasil as $h){
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['TGL_STOK'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_STOK']).'</td>';
			$isi .= '<td>'.$h['SATUAN'].'</td>';
			$isi .= '<td>'.number_format($h['HARGA_BELI']).'</td>';
			$isi .= '<td>'.number_format($h['HARGA_JUAL']).'</td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		
		
		if(count($hasil)==0){
			$isi .= '<tr><td colspan="4"><center>Tidak Ada Record </center></td></tr>';
		}

		return $isi;
		
	}
	
	public function Produk_list(){
		
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user 			= $_SESSION['user_id'];
		
		$distributor = $this->Produk_survey_model->get_data_distributor_toko($id_user);
		
		$data['distributor']	= $distributor[0]['KODE_DISTRIBUTOR']. ' - '. $distributor[0]['NAMA_DISTRIBUTOR'];
		
		$data['daftar_produk'] = $this->make_isi_daftar_pd($this->Produk_survey_model->get_daftar_produk_dist_list($id_user));
		
		// $distributor 	 	= $_SESSION['kode_dist'];
		//print_r($_SESSION);
		$this->template->display('produk_list', $data);
	}
	private function make_isi_daftar_pd($hasil){
		
		$isi ='';
		$no =1;
		foreach($hasil as $h){
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['ID_PRODUK_DISTRIBUTOR'].'</td>';
			$isi .= '<td>'.$h['NAMA_PRODUK'].'</td>';
			$isi .= '<td>'.$h['JENIS_PRODUK'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_STOK_ZAK']).'</td>';
			$isi .= '<td>'.number_format($h['HARGA_JUAL']).'</td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		
		
		if(count($hasil)==0){
			//$isi .= '<tr><td colspan="8"><center>Tidak Ada Record </center></td></tr>';
		}

		return $isi;
	}
	public function Ajax_Simpan_order_produk(){
		
		$idpd 		= $this->input->post("Id_jenis_produk");
		$stok 		= $this->input->post("stok");
		$tgl_order 	= $this->input->post("tgl_order");
		$tgl_order	= date('d-M-Y', strtotime($tgl_order));
		
		$id_user 		= $_SESSION['user_id'];
		$id_customer 	= null; 
		
		$hasil = $this->Produk_survey_model->insert_data_order_produk($idpd, $stok, $tgl_order, $id_user);
		
		if($hasil){
			echo json_encode(array('notify' => 1, 'pesan' => 'Order telah dibuat.'));
		}
		else {
			echo json_encode(array('notify' => 2, 'pesan' => 'Error.'));
		}
	}
	public function Konfirmasi_order(){
		
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user 			= $_SESSION['user_id'];
		$distributor 	 	= $_SESSION['kode_dist'];
		
		$data['list_order'] = $this->make_daftar_order_distributor($this->Produk_survey_model->get_data_order_toko($distributor));
		
		// $distributor 	 	= $_SESSION['kode_dist'];
		//print_r($_SESSION);
		$this->template->display('konfirmasi_order', $data);
	}
	private function make_daftar_order_distributor($hasil){
		
		$isi ='';
		$no =1;
		foreach($hasil as $h){
			$btn_konfirm = '<button class="btn btn-primary waves-effect Konfirmasi_order_toko" no_order="'.$h['NO_ORDER'].'" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'" toko="'.$h['NAMA_TOKO'].'" produk="'.$h['NAMA_PRODUK'].'">
			<span class="fa fa-check"></span></button>';
			
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['ID_CUSTOMER'].' - '.$h['NAMA_TOKO'].'</td>';
			$isi .= '<td>'.$h['NAMA_PRODUK'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_ORDER']).'</td>';
			$isi .= '<td>'.$h['TGL_ORDER'].'</td>';
			$isi .= '<td>'.$h['TGL_REQUEST'].'</td>';
			$isi .= '<td>'.number_format($h['HARGA_JUAL']).'</td>';
			if($h['STATUS_ORDER']==0){
				$isi .= '<td>Pengajuan Order</td>';
			}
			$isi .= '<td>'.$btn_konfirm.'</td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		
		return $isi;
		
	}

	public function Ajax_Konfirmasi_Order_toko(){

		$no_order 		= $this->input->post("no_order");
		$idpd 			= $this->input->post("idpd");
		$qty_konfirmasi = $this->input->post("qty_konfirmasi");
		$tgl_rencana 	= $this->input->post("tgl_rencana");
		$tgl_rencana	= date('d-M-Y', strtotime($tgl_rencana));

		$id_user 			= $_SESSION['user_id'];
		$distributor 	 	= $_SESSION['kode_dist'];

		$hasil = $this->Produk_survey_model->Konfirmasi_order($no_order, $idpd, $qty_konfirmasi, $tgl_rencana, $id_user, $distributor);

		if($hasil){
			$data = $this->make_daftar_order_distributor($this->Produk_survey_model->get_data_order_toko($distributor));
			echo json_encode(array('notify' => 1, 'html' => $data, 'pesan' => 'Order telah Dikonfirmasi.'));
		}

	}
	public function Status_order(){
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user 			= $_SESSION['user_id'];
		$distributor 	 	= $_SESSION['kode_dist'];
		
		$data['list_order'] = $this->make_status_order($this->Produk_survey_model->get_data_order_toko_fixs($distributor));
		
		// $distributor 	 	= $_SESSION['kode_dist'];
		//print_r($_SESSION);
		$this->template->display('laporan_status_order', $data);
	}
	public function Status_order_SMI(){
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user 			= $_SESSION['user_id'];
		$distributor 	 	= null;
		
		$data['list_order'] = $this->make_status_order($this->Produk_survey_model->get_data_order_toko_fixs($distributor));
		
		// $distributor 	 	= $_SESSION['kode_dist'];
		//print_r($_SESSION);
		
		$this->template->display('laporan_status_order', $data);
	}
	private function make_status_order($hasil){

		$isi ='';
		$no =1;
		foreach($hasil as $h){
			
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['NAMA_PRODUK'].'</td>';
			$isi .= '<td>'.$h['ID_CUSTOMER'].' - '.$h['NAMA_TOKO'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_ORDER']).'</td>';
			$isi .= '<td>'.number_format($h['QTY_KONFIRMASI']).'</td>';
			$isi .= '<td>'.number_format($h['QTY_TERIMA']).'</td>';
			$isi .= '<td>'.number_format($h['HARGA_JUAL']).'</td>';
			$isi .= '<td>'.$h['TGL_ORDER'].'</td>';
			$isi .= '<td>'.$h['TGL_RENCANA_KIRIM'].'</td>';
			$isi .= '<td>'.$h['WAKTU_TERIMA'].'</td>';
			if($h['STATUS_ORDER']==0){
				$isi .= '<td>Pengajuan Order</td>';
			}
			else if($h['STATUS_ORDER']==1){
				$isi .= '<td color="bg-red">Belum Diterima Toko</td>';
			}
			else if($h['STATUS_ORDER']==2){
				$isi .= '<td color="bg-green">Sudah Diterima Toko</td>';
			}
			$isi .= '</tr>';
			
			$no=$no+1;
		}

		return $isi;
	}
}

?> 