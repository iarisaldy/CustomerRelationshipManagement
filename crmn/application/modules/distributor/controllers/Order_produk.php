<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Order_produk extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Order_produk_model');
		
		set_time_limit(0);
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user 			= $_SESSION['user_id'];
		
		$distributor = $this->Order_produk_model->get_data_distributor_toko($id_user);
		
		$data['distributor']	= $distributor[0]['KODE_DISTRIBUTOR']. ' - '. $distributor[0]['NAMA_DISTRIBUTOR'];
		
		$data['daftar_produk'] = $this->make_isi_daftar_pd($this->Order_produk_model->get_daftar_produk_dist_list($id_user));
		
		// $distributor 	 	= $_SESSION['kode_dist'];
		//print_r($_SESSION);
		$this->template->display('order_produk', $data);
    }
	
	private function make_isi_daftar_pd($hasil){
		
		$isi ='';
		$no =1;
		foreach($hasil as $h){
			$btn_order = '<button class="btn btn-success btn-block waves-effect Tambah_Order_produk" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'" nmpd="'.$h['NAMA_PRODUK'].'"><span class="fa fa-shopping-cart "></span> Order</button>';
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['ID_PRODUK_DISTRIBUTOR'].'</td>';
			$isi .= '<td>'.$h['NAMA_PRODUK'].'</td>';
			$isi .= '<td>'.$h['JENIS_PRODUK'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_STOK_ZAK']).'</td>';
			$isi .= '<td>'.number_format($h['HARGA_JUAL']).'</td>';
			$isi .= '<td>'.$btn_order.'</td>';
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
		
		$tgl_request = $this->input->post("tgl_request");
		$tgl_request = date('d-M-Y', strtotime($tgl_request));
		
		$id_user 		= $_SESSION['user_id'];
		$id_customer 	= null; 
		
		$hasil = $this->Order_produk_model->insert_data_order_produk($idpd, $stok, $tgl_order, $id_user, $tgl_request);
		
		
		if($hasil){
			echo json_encode(array('notify' => 1, 'pesan' => 'Order telah dibuat.'));
		}
		else {
			echo json_encode(array('notify' => 2, 'pesan' => 'Error.'));
		}
	}

	public function History_order(){

		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user 				= $_SESSION['user_id'];

		$data['daftar_produk'] 	= $this->make_history_order($this->Order_produk_model->get_data_history_order($id_user));	
		
		$this->template->display('order_history', $data);
	}
	private function make_history_order($hasil){
		
		$isi ='';
		$no =1;
		foreach($hasil as $h){
			
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['NAMA_PRODUK'].'</td>';
			$isi .= '<td>'.$h['ID_CUSTOMER'].' - '.$h['NAMA_TOKO'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_ORDER']).'</td>';
			$isi .= '<td>'.$h['TGL_ORDER'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_KONFIRMASI']).'</td>';
			$isi .= '<td>'.$h['TGL_RENCANA_KIRIM'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_TERIMA']).'</td>';
			$isi .= '<td>'.$h['WAKTU_TERIMA'].'</td>';
			$isi .= '<td>'.number_format($h['HARGA_JUAL']).'</td>';
			if($h['STATUS_ORDER']==0){
				$isi .= '<td>Belum Dikonfirmasi</td>';
			}
			else if($h['STATUS_ORDER']==1){
				$isi .= '<td color="bg-red">Sudah Dikonfirmasi</td>';
			}
			else if($h['STATUS_ORDER']==2){
				$isi .= '<td color="bg-green">Sudah Diterima</td>';
			}
			$isi .= '</tr>';
			
			$no=$no+1;
		}

		return $isi;
	}

	public function Konfirmasi_barang(){

		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user 			= $_SESSION['user_id'];
		//$distributor 	 	= $_SESSION['kode_dist'];
		
		$data['list_order'] = $this->make_isi_konfirmasi_penerimaan($this->Order_produk_model->get_tampil_pengiriman_barang($id_user));

		//$data['list_order'] = $this->make_daftar_order_distributor($this->Produk_survey_model->get_data_order_toko($distributor));
		
		// $distributor 	 	= $_SESSION['kode_dist'];
		//print_r($this->Order_produk_model->get_tampil_pengiriman_barang($id_user));
		$this->template->display('konfirmasi_barang', $data);

	}
	private function make_isi_konfirmasi_penerimaan($hasil){
		
		$isi ='';
		$no =1;
		foreach($hasil as $h){
			$btn_konfirm = '<button class="btn btn-primary btn-block waves-effect Konfirmasi_order_toko" no_order="'.$h['NO_ORDER'].'" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'" toko="'.$h['NAMA_TOKO'].'" produk="'.$h['NAMA_PRODUK'].'">
			<span class="fa fa-plus"></span></button>';
			
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['NAMA_PRODUK'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_ORDER']).'</td>';
			$isi .= '<td>'.$h['TGL_ORDER'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_KONFIRMASI']).'</td>';
			$isi .= '<td>'.$h['TGL_KONFIRMASI'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_TERIMA']).'</td>';
			$isi .= '<td>'.number_format($h['HARGA_JUAL']).'</td>';
			if($h['STATUS_ORDER']==1){
				$isi .= '<td>Belum Dikonfirmasi</td>';
			}
			$isi .= '<td>'.$btn_konfirm.'</td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		
		return $isi;		
	}

	public function Ajax_Konfirmasi_barang(){

		$id_user 			= $_SESSION['user_id'];

		$no_order 			= $this->input->post("no_order");
		$qty_konfirmasi 	= $this->input->post("qty_konfirmasi");

		$hasil = $this->Order_produk_model->konfirmasi_barang($id_user, $no_order, $qty_konfirmasi);

		if($hasil){
			$data = $this->make_isi_konfirmasi_penerimaan($this->Order_produk_model->get_tampil_pengiriman_barang($id_user));
			echo json_encode(array('notify' => 1, 'pesan' => 'Barang Telah Diterima.', 'html' => $data ));			
		}

	}
	public function Pemenuhan_order(){
		
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user 			= $_SESSION['user_id'];
		//$distributor 	 	= $_SESSION['kode_dist'];
		$data['distributor'] = $this->make_option_distributor($this->Order_produk_model->get_data_distributor());
		
		$data['bulan'] = array(
						'01' => 'Januari',
						'02' => 'Februari',
						'03' => 'Maret',
						'04' => 'April',
						'05' => 'Mei',
						'06' => 'Juni',
						'07' => 'Juli',
						'08' => 'Agustus',
						'09' => 'September',
						'10' => 'Oktober',
						'11' => 'November',
						'12' => 'Desember',
					);
		
		$this->template->display('pemenuhan_order', $data);
	}
	private function make_option_distributor($data){
		
		$isi ='';
		foreach($data as $d){
			$isi .= '<option value="'.$d['KODE_DISTRIBUTOR'].'">'.$d['KODE_DISTRIBUTOR'].' - '.$d['NAMA_DISTRIBUTOR'].'</option>';
		}
		return $isi;
	}
	public function Ajax_laporan_pemenuhan_order(){
		
		$distributor 	= $this->input->post('distributor');
		$tahun 			= $this->input->post('tahun');
		$bulan 			= $this->input->post('bulan');
		
		$hasil = $this->make_table_pemenuhan_order($this->Order_produk_model->get_data_pemenuhan_order($distributor, $tahun, $bulan));
		
		echo json_encode(array('notify' => 1, 'pesan' => 'Data Berhasil Ditampilkan.', 'html' => $hasil));
	}
	
	private function make_table_pemenuhan_order($hasil){
		
		$isi ='';
		$no =1;
		foreach($hasil as $h){
			$btn_konfirm = '<button class="btn btn-success btn-block waves-effect Detile_order_produk" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'">
			<span class="fa fa-list"></span></button>';
			
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['NAMA_PRODUK'].'</td>';
			$isi .= '<td>'.$h['JENIS_PRODUK'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_STOK_ZAK']).'</td>';
			$isi .= '<td>'.number_format($h['QTY_ORDER']).'</td>';
			$isi .= '<td>'.number_format($h['QTY_KONFIRMASI']).'</td>';
			//$isi .= '<td>'.number_format($h['QTY_TERIMA']).'</td>';
			
			$isi .= '<td>'.$btn_konfirm.'</td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		
		return $isi;	
	}
	public function Ajax_detile_order(){
		
		$id_pd 		= $this->input->post('id_pd');
		$hasil 		= $this->make_table_detile_customer($this->Order_produk_model->get_data_detile_customer($id_pd));
		
		echo json_encode(array('notify' => 1, 'pesan' => 'Data Berhasil Ditampilkan.', 'html' => $hasil));
	}
	private function make_table_detile_customer($hasil){
		
		$isi ='';
		$no =1;
		foreach($hasil as $h){
			$btn_konfirm = '<button class="btn btn-success btn-block waves-effect Detile_order_produk" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'">
			<span class="fa fa-list"></span></button>';
			
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['ID_CUSTOMER'].' - '.$h['NAMA_CUSTOMER'].'</td>';
			$isi .= '<td>'.$h['NAMA_PRODUK'].'</td>';
			$isi .= '<td>'.number_format($h['QTY_ORDER']).'</td>';
			$isi .= '<td>'.number_format($h['QTY_KIRIM']).'</td>';
			$isi .= '<td>'.number_format($h['QTY_TERIMA']).'</td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		
		return $isi;	
	}
	
}

?>