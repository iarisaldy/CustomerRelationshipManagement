<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crm_stok_gudang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->ci = &get_instance();
		// $this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->library('Htmllib');
        $this->load->model('Crm_stok_gudang_model');
        $this->load->model('Blok_stok_model');
	}
	
	public function GetData(){
		$data = $this->ci->session->all_userdata();
		echo '<pre>';
			print_r($data);
		echo '</pre>';
	}
	public function index(){

		$data['title'] = "LIST STOK GUDANG";
		$this->htmllib->_set_form_css();
        $this->htmllib->_set_form_js();
        $this->htmllib->set_table2_js();
        $this->htmllib->set_table2_cs();

		// $data["list_crm_stok_gudang"] 	= $this->list_stok_crm();

		$this->layout->render('si/daftar_crm_stok_gudang', $data);
	}
	
	public function get_data_stok(){
		$org				= $this->input->post('ORG');
		$kd_soldto 			= $this->input->post('SOLD_TO');
		$nm_soldto			= $this->input->post('NAMA_SOLD_TO');
		$kd_shipto			= $this->input->post('KODE_SHIPTO');
		$nm_shipto			= $this->input->post('NAMA_SHIPTO');
		$alamat_shipto 		= $this->input->post('ALAMAT_SHIPTO');
		$kota_shipto 		= $this->input->post('KOTA_SHIPTO');
		$nm_kota_shipto 	= $this->input->post('NAMA_KOTA_SHIPTO');
		$tgl_rilis			= $this->input->post('TGL_RILIS');
		$qty_rilis			= $this->input->post('QTY_RILIS');
		$qty_terima			= $this->input->post('QTY_TERIMA');
		$qty_stok			= $this->input->post('QTY_STOK');
		$update_date 		= $this->input->post('UDPATE_DATE');
		$update_by			= $this->input->post('UPDATE_BY');
		$kd_material 		= $this->input->post('ITEM_NO');
		$nm_material 		= $this->input->post('PRODUK');
		$token 				= $this->input->post('TOKEN');

		$this->retrieve_data_stok($token, $org, $kd_soldto, $nm_soldto, $kd_shipto, $nm_shipto, $alamat_shipto, $kota_shipto, $nm_kota_shipto, $tgl_rilis, $qty_rilis, $qty_terima, $qty_stok, $update_date, $update_by, $kd_material, $nm_material);
	}

	public function retrieve_data_stok($token, $org, $kd_soldto, $nm_soldto, $kd_shipto, $nm_shipto, $alamat_shipto, $kota_shipto, $nm_kota_shipto, $tgl_rilis, $qty_rilis, $qty_terima, $qty_stok, $update_date, $update_by, $kd_material, $nm_material){
		$getDataToken = $this->Crm_stok_gudang_model->getDtToken($kd_soldto);
		if($getDataToken == NULL || $getDataToken == ""){
			$url 				= "10.15.2.101/3PL/Data_gudang_api/notif_fail";
			// $url 				= "3pl.semenindonesia.com/Data_gudang_api/sent_data_stok";
			
			// $dataStokValue 					= array_values($dataStok);

	        $ket 							= array();
	        $ket['KETERANGAN_NOTIFIKASI'] 	= "Berhasil Mengirim Data ";
	        $ket['USER'] 					= $this->ci->session->userdata('USERNAME');

	        $api 							= array();
	        $api['NOTIF'] 					= 'Maaf Data User Tidak Ditemukan';
	        $json 							= json_encode($api);
	        $fields 						= "json=".$json;

	        $headers 						= array(
	        											'Content-Type: application/x-www-form-urlencoded'
	        										);

	        $ch 							= curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	        
	        $result = curl_exec($ch);           
	        if ($result === FALSE) {
	              die('Curl failed: ' . curl_error($ch));
	        }
	        
	        print_r($result);
	        curl_close($ch);
		}
		else{
			if((int)$token == (int)$getDataToken['KD_CUSTOMER']){
				$url 				= "10.15.2.101/3PL/Data_gudang_api/sent_data_stok";
		        // $url 				= "3pl.semenindonesia.com/Data_gudang_api/sent_data_stok";

				$org 				= $this->ci->session->userdata('ORG');
				if($kd_distributor == null || $kd_distributor == ""){
					$kd_distributor 	= $this->ci->session->userdata('KD_DISTRIBUTOR');
				}
				else{
					$kd_distributor = $kd_distributor;
				}
				$DTcrm = $this->Crm_stok_gudang_model->getDataCRM($org, $kd_soldto, $nm_soldto, $kd_shipto, $nm_shipto, $alamat_shipto, $kota_shipto, $nm_kota_shipto, $tgl_rilis, $qty_rilis, $qty_terima, $qty_stok, $update_date, $update_by, $kd_material, $nm_material);
				if($DTcrm == NULL || $DTcrm == ""){
					$dataStok 			= $this->Crm_stok_gudang_model->insertDataCRMStokAPI($org, $kd_soldto, $nm_soldto, $kd_shipto, $nm_shipto, $alamat_shipto, $kota_shipto, $nm_kota_shipto, $tgl_rilis, $qty_rilis, $qty_terima, $qty_stok, $update_date, $update_by, $kd_material, $nm_material);
					
					if($dataStok == 1){
						$pesan = 'Data Berhasil di Simpan';
					}
					else{
						$pesan = 'Data gagal  di Simpan';
					}
				}
				else{
					$dataStok 			= $this->Crm_stok_gudang_model->updateDtCRMStokAPI($org, $kd_soldto, $nm_soldto, $kd_shipto, $nm_shipto, $alamat_shipto, $kota_shipto, $nm_kota_shipto, $tgl_rilis, $qty_rilis, $qty_terima, $qty_stok, $update_date, $update_by, $kd_material, $nm_material);

					if($dataStok == 1){
						$pesan = 'Data Berhasil di Update';
					}
					else{
						$pesan = 'Data gagal  di Update';
					}
				}
				
				// $dataStokValue 					= array_values($dataStok);

		        $ket 							= array();
		        $ket['KETERANGAN_NOTIFIKASI'] 	= "Berhasil Mengirim Data ";
		        $ket['USER'] 					= $this->ci->session->userdata('USERNAME');

		        $api 							= array();
		        $api['dataStok'] 				= $pesan;
		        $json 							= json_encode($api);
		        $fields 						= "json=".$json;

		        $headers 						= array(
		        											'Content-Type: application/x-www-form-urlencoded'
		        										);

		        $ch 							= curl_init();
		        curl_setopt($ch, CURLOPT_URL, $url);
		        curl_setopt($ch, CURLOPT_POST, true);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
		        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		        
		        $result = curl_exec($ch);           
		        if ($result === FALSE) {
		              die('Curl failed: ' . curl_error($ch));
		        }
		        
		        print_r($result);
		        curl_close($ch);
			}
			else{
				$url 				= "10.15.2.101/3PL/Data_gudang_api/notif_fail";
				// $url 				= "3pl.semenindonesia.com/Data_gudang_api/sent_data_stok";
				
				// $dataStokValue 					= array_values($dataStok);

		        $ket 							= array();
		        $ket['KETERANGAN_NOTIFIKASI'] 	= "Berhasil Mengirim Data ";
		        $ket['USER'] 					= $this->ci->session->userdata('USERNAME');

		        $api 							= array();
		        $api['NOTIF'] 					= 'Maaf Data User Tidak Ditemukan';
		        $json 							= json_encode($api);
		        $fields 						= "json=".$json;

		        $headers 						= array(
		        											'Content-Type: application/x-www-form-urlencoded'
		        										);

		        $ch 							= curl_init();
		        curl_setopt($ch, CURLOPT_URL, $url);
		        curl_setopt($ch, CURLOPT_POST, true);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
		        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		        
		        $result = curl_exec($ch);           
		        if ($result === FALSE) {
		              die('Curl failed: ' . curl_error($ch));
		        }
		        
		        print_r($result);
		        curl_close($ch);
			}
		}		
    }

    Public function sent_data_stok() {
		$string = isset($_POST['json']) ? $_POST['json'] : "";
		$data 	= json_decode($string, true);

		if($data == null OR $data == ""){
			$status = 'Error';
		}
		else{
			$status = 'Berhasil Mengirim Data';
		}

		header('Content-Type: application/json');
		echo json_encode(array("status" => $status, "dataStok" => $data['dataStok'] ));
	}
	Public function notif_fail() {
		$string = isset($_POST['json']) ? $_POST['json'] : "";
		$data 	= json_decode($string, true);

		if($data == null OR $data == ""){
			$status = 'Error';
		}
		else{
			$status = 'Berhasil Mengirim Data';
		}

		header('Content-Type: application/json');
		echo json_encode(array("status" => $status, "Notif" => $data['NOTIF'] ));
	}

	/////////////////////////////////////////////////////////////////////// GR ////////////////////////////////////////////////////////////////

	// public function retrieve_data_gr($kd_customer, $kd_distributor, $no_spj, $no_do, $create_by, $update_by, $kd_asal_data, $tanggal_gr){
	public function retrieve_data_gr(){
			$input  = file_get_contents("php://input");
			$dtGR 	= json_decode($input, TRUE);
            
            //==========jika token tidak ada
            if($dtGR['TOKEN']==null || $dtGR['TOKEN']==''){
                header('Content-Type: application/json');
                echo json_encode(array("STATUS" => 0, "NOTIF" => 'DATA GAGAL DIKIRIM, TOKEN KOSONG'));
            }
            else{
               $cek_login_token = $this->Crm_stok_gudang_model->getDtTokenWhere($dtGR['TOKEN'],$dtGR['JENIS_DATA'],$dtGR['KD_DISTRIBUTOR']);
               //=====jika token salah
               if($cek_login_token == null){
                    header('Content-Type: application/json');
                    echo json_encode(array("STATUS" => 2, "NOTIF" => 'DATA GAGAL DIKIRIM, PERIKSA TOKEN DAN DATA LAINNYA'));
               }
               //=====jika benar
               else{
                /*TEST
        			$DataStokCRM 	= $this->Crm_stok_gudang_model->getDataCrmStokGudang();
        
        			foreach ($dtGR as $dt) {
        				$kd_customer 		= $dt['KD_CUSTOMER'];//M
        				$kd_distributor 	= $dt['KD_DISTRIBUTOR'];//M
        				$no_spj				= $dt['NO_SPJ'];//M
        				$no_do				= $dt['NO_DO'];//M
        				(int)$kd_produk		= $dt['KD_PRODUK'];//M
        				$satuan				= $dt['SATUAN'];//M
        				(int)$qty_total		= $dt['QTY_TOTAL'];//M
        				(int)$qty_terima	= $dt['QTY_TERIMA'];//M
        				(int)$qty_pecah		= $dt['QTY_PECAH'];//M
        				// $qty_rusak			= $dt['QTY_RUSAK'];//M
        				(int)$qty_hilang	= $dt['QTY_HILANG'];//M
        				$kd_asal_data 		= $dt['KD_ASAL_DATA'];
        				$tanggal_gr 		= $dt['TANGGAL_GR'];//M
        
        				$this->Crm_stok_gudang_model->insertGRx($kd_customer, $kd_distributor, $no_spj, $no_do, $kd_produk, $satuan, $qty_total, $qty_terima, $qty_pecah, $qty_hilang, $kd_asal_data, $tanggal_gr);
        			}*/
        			// $dtGR 			= $this->Crm_stok_gudang_model->insertGRx($kd_customer, $kd_distributor, $no_spj, $no_do, $create_by, $update_by, $kd_asal_data, $tanggal_gr);
        
        	        
                    header('Content-Type: application/json');
                    //echo json_encode(array("STATUS" => 1, "NOTIF" => 'DATA BERHASIL DIKIRIM'));
                    echo json_encode(array("STATUS" => 1, "NOTIFY" => 'DATA BERHASIL DIKIRIM', "TOTAL_DATA"=> $dtGR['TOTAL_DATA'], "DATA"=>$dtGR));
               }          
            }
            
    }
    
    public function retrieve_data_gr_week(){
			$input  = file_get_contents("php://input");
			$dtGR 	= json_decode($input, TRUE);
            
            //==========jika token tidak ada
            if($dtGR['TOKEN']==null || $dtGR['TOKEN']==''){
                header('Content-Type: application/json');
                echo json_encode(array("STATUS" => 0, "NOTIF" => 'DATA GAGAL DIKIRIM, TOKEN KOSONG'));
            }
            else{
               $cek_login_token = $this->Crm_stok_gudang_model->getDtTokenWhere($dtGR['TOKEN'],$dtGR['JENIS_DATA'],$dtGR['KD_DISTRIBUTOR']);
               //=====jika token salah
               if($cek_login_token == null){
                    header('Content-Type: application/json');
                    echo json_encode(array("STATUS" => 2, "NOTIF" => 'DATA GAGAL DIKIRIM, PERIKSA TOKEN DAN DATA LAINNYA'));
               }
               //=====jika benar
               else{
                /*TEST
        			$DataStokCRM 	= $this->Crm_stok_gudang_model->getDataCrmStokGudang();
        
        			foreach ($dtGR as $dt) {
        				$kd_customer 		= $dt['KD_CUSTOMER'];//M
        				$kd_distributor 	= $dt['KD_DISTRIBUTOR'];//M
        				$no_spj				= $dt['NO_SPJ'];//M
        				$no_do				= $dt['NO_DO'];//M
        				(int)$kd_produk		= $dt['KD_PRODUK'];//M
        				$satuan				= $dt['SATUAN'];//M
        				(int)$qty_total		= $dt['QTY_TOTAL'];//M
        				(int)$qty_terima	= $dt['QTY_TERIMA'];//M
        				(int)$qty_pecah		= $dt['QTY_PECAH'];//M
        				// $qty_rusak			= $dt['QTY_RUSAK'];//M
        				(int)$qty_hilang	= $dt['QTY_HILANG'];//M
        				$kd_asal_data 		= $dt['KD_ASAL_DATA'];
        				$tanggal_gr 		= $dt['TANGGAL_GR'];//M
        
        				$this->Crm_stok_gudang_model->insertGRx($kd_customer, $kd_distributor, $no_spj, $no_do, $kd_produk, $satuan, $qty_total, $qty_terima, $qty_pecah, $qty_hilang, $kd_asal_data, $tanggal_gr);
        			}*/
        			// $dtGR 			= $this->Crm_stok_gudang_model->insertGRx($kd_customer, $kd_distributor, $no_spj, $no_do, $create_by, $update_by, $kd_asal_data, $tanggal_gr);
        
        	        
                    header('Content-Type: application/json');
                    //echo json_encode(array("STATUS" => 1, "NOTIF" => 'DATA BERHASIL DIKIRIM'));
                    echo json_encode(array("STATUS" => 1, "NOTIFY" => 'DATA BERHASIL DIKIRIM', "TOTAL_DATA"=> $dtGR['TOTAL_DATA'], "DATA"=>$dtGR));
               }          
            }
            
    }

    Public function sent_data_gr() {
		$string = isset($_POST['json']) ? $_POST['json'] : "";
		$data 	= json_decode($string, true);

		if($data == null OR $data == ""){
			$status = 2;
		}
		else{
			$status = 1;
		}

		header('Content-Type: application/json');
		echo json_encode(array("STATUS" => $status, "TOTAL_DATA" => $data['TOTAL_DATA'], "NOTIF" => $data['NOTIFY'], "DATA" => $data['LIST_DATA']));
	}
	/////////////////////////////////////////////////////////////////////// GR ////////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////////// Stok Gudang GR ////////////////////////////////////////////////////////////////
	public function insert_data_stok_gudang_distributor(){
	   	$url 				= "https://10.15.2.101/3PL/Crm_stok_gudang/sent_data_stok_gudang_distributor";	
		// $url 				= "https://3pl.semenindonesia.com/Crm_stok_gudang/sent_data_stok_gudang_distributor";

		$input              = file_get_contents('php://input');
    	$dataGudang 		= json_decode($input, TRUE);
        
        $kd_asal_data		= $dataGudang['KD_ASAL_DATA'];
		$uid				= $dataGudang['UID'];

		//$dtLogHistory 	= $this->Crm_stok_gudang_model->insertLogHisory($input, $dataGudang);
		//$DataStokCRM 	= $this->Crm_stok_gudang_model->getDataCrmStokGudang();
		if($dataGudang['TOKEN'] == NULL ||  $dataGudang['TOKEN'] == "")
		{
		  	header('Content-Type: application/json');
    		echo json_encode(array("STATUS" => 0, "NOTIFY" => 'DATA GAGAL DIKIRIM, TOKEN KOSONG'));
		}
		else{
		  //cek login token
          $cek_login_token = $this->Crm_stok_gudang_model->getDtTokenWhere($dataGudang['TOKEN'],$dataGudang['JENIS_DATA'],$dataGudang['KD_DISTRIBUTOR']);
          //jika token sesuai
          if($cek_login_token != null){
            //$batchData 		= $this->Crm_stok_gudang_model->IUDataStok($DataStokCRM, $dataGudang);	
			
    		header('Content-Type: application/json');
    		echo json_encode(array("STATUS" => 1, "NOTIFY" => 'DATA BERHASIL DIKIRIM', "TOTAL_DATA"=> $dataGudang['TOTAL_DATA'], "DATA"=>$dataGudang));
          }
          //jika token tidak sesuai
          else{
            header('Content-Type: application/json');
    		echo json_encode(array("STATUS" => 2, "NOTIFY" => 'DATA GAGAL DIKIRIM, PERIKSA TOKEN DAN DATA LAINNYA'));
          }
			
		}	
	}
    
    public function insert_data_stok_gudang_distributor_week(){
	   	$url 				= "https://10.15.2.101/3PL/Crm_stok_gudang/sent_data_stok_gudang_distributor";	
		// $url 				= "https://3pl.semenindonesia.com/Crm_stok_gudang/sent_data_stok_gudang_distributor";

		$input              = file_get_contents('php://input');
    	$dataGudang 		= json_decode($input, TRUE);
        
        $kd_asal_data		= $dataGudang['KD_ASAL_DATA'];
		$uid				= $dataGudang['UID'];

		//$dtLogHistory 	= $this->Crm_stok_gudang_model->insertLogHisory($input, $dataGudang);
		//$DataStokCRM 	= $this->Crm_stok_gudang_model->getDataCrmStokGudang();
		if($dataGudang['TOKEN'] == NULL ||  $dataGudang['TOKEN'] == "")
		{
		  	header('Content-Type: application/json');
    		echo json_encode(array("STATUS" => 0, "NOTIFY" => 'DATA GAGAL DIKIRIM, TOKEN KOSONG'));
		}
		else{
		  //cek login token
          $cek_login_token = $this->Crm_stok_gudang_model->getDtTokenWhere($dataGudang['TOKEN'],$dataGudang['JENIS_DATA'],$dataGudang['KD_DISTRIBUTOR']);
          //jika token sesuai
          if($cek_login_token != null){
            //$batchData 		= $this->Crm_stok_gudang_model->IUDataStok($DataStokCRM, $dataGudang);	
			
    		header('Content-Type: application/json');
    		echo json_encode(array("STATUS" => 1, "NOTIFY" => 'DATA BERHASIL DIKIRIM', "TOTAL_DATA"=> $dataGudang['TOTAL_DATA'], "DATA"=>$dataGudang));
          }
          //jika token tidak sesuai
          else{
            header('Content-Type: application/json');
    		echo json_encode(array("STATUS" => 2, "NOTIFY" => 'DATA GAGAL DIKIRIM, PERIKSA TOKEN DAN DATA LAINNYA'));
          }
			
		}	
	}

	Public function sent_data_stok_gudang_distributor_fail() {
		$string = isset($_POST['json']) ? $_POST['json'] : "";
		$data 	= json_decode($string, true);

		header('Content-Type: application/json');
		echo json_encode(array("STATUS" => 0, "NOTIF" => $data['NOTIFY']));
	}
	Public function sent_data_stok_gudang_distributor() {
		$string = isset($_POST['json']) ? $_POST['json'] : "";
		$data 	= json_decode($string, true);

		if($data == null OR $data == ""){
			$status = 2;
		}
		else{
			$status = 1;
		}

		header('Content-Type: application/json');
		echo json_encode(array("STATUS" => $status, "TOTAL_DATA" => $data['TOTAL_DATA'], "NOTIF" => $data['NOTIFY'], "DATA" => $data['LIST_DATA']));
	}

	/////////////////////////////////////////////////////////////////////// Stok Gudang GR ////////////////////////////////////////////////////////////////

	////////////////////////////////////////////////////////////////////// JUAL ///////////////////////////////////////////////////////////////////////////
	public function retrieve_data_penjualan(){
	   	// $url 				= "https://3pl.semenindonesia.com/Crm_stok_gudang/sent_data_penjualan_service";
		$url 				= "https://10.15.2.101/3PL/Crm_stok_gudang/sent_data_penjualan_service";	
		$input              = file_get_contents("php://input");
    	$dataPenjualan 		= json_decode($input, TRUE);
        
        //=================jika token kosong
        if($dataPenjualan['TOKEN']==null || $dataPenjualan['TOKEN']==''){
            header('Content-Type: application/json');
    		echo json_encode(array("STATUS" => 0, "NOTIF" => 'DATA GAGAL DIKIRIM, TOKEN KOSONG'));
        }
        //======jika token tidak kosong
        else {
          $cek_login_token = $this->Crm_stok_gudang_model->getDtTokenWhere($dataPenjualan['TOKEN'],$dataPenjualan['JENIS_DATA'],$dataPenjualan['KD_DISTRIBUTOR']);
          //====================jika data token salah
          if($cek_login_token == null){
            header('Content-Type: application/json');
    		echo json_encode(array("STATUS" => 2, "NOTIF" => 'DATA GAGAL DIKIRIM, PERIKSA TOKEN DAN DATA LAINNYA'));
          }
          //=================jika token benar
          else{
            //$DataStokCRM 		= $this->Crm_stok_gudang_model->insert_penjualan($dataPenjualan);
    		header('Content-Type: application/json');
    		//echo json_encode(array("STATUS" => 1, "NOTIF" => 'DATA BERHASIL DIKIRIM'));
            echo json_encode(array("STATUS" => 1, "NOTIFY" => 'DATA BERHASIL DIKIRIM', "TOTAL_DATA"=> $dataPenjualan['TOTAL_DATA'], "DATA"=>$dataPenjualan));
          }
            
        }
        
	}
    
    public function retrieve_data_penjualan_week(){
	   	// $url 				= "https://3pl.semenindonesia.com/Crm_stok_gudang/sent_data_penjualan_service";
		$url 				= "https://10.15.2.101/3PL/Crm_stok_gudang/sent_data_penjualan_service";	
		$input              = file_get_contents("php://input");
    	$dataPenjualan 		= json_decode($input, TRUE);
        
        //=================jika token kosong
        if($dataPenjualan['TOKEN']==null || $dataPenjualan['TOKEN']==''){
            header('Content-Type: application/json');
    		echo json_encode(array("STATUS" => 0, "NOTIF" => 'DATA GAGAL DIKIRIM, TOKEN KOSONG'));
        }
        //======jika token tidak kosong
        else {
          $cek_login_token = $this->Crm_stok_gudang_model->getDtTokenWhere($dataPenjualan['TOKEN'],$dataPenjualan['JENIS_DATA'],$dataPenjualan['KD_DISTRIBUTOR']);
          //====================jika data token salah
          if($cek_login_token == null){
            header('Content-Type: application/json');
    		echo json_encode(array("STATUS" => 2, "NOTIF" => 'DATA GAGAL DIKIRIM, PERIKSA TOKEN DAN DATA LAINNYA'));
          }
          //=================jika token benar
          else{
            //$DataStokCRM 		= $this->Crm_stok_gudang_model->insert_penjualan($dataPenjualan);
    		header('Content-Type: application/json');
    		//echo json_encode(array("STATUS" => 1, "NOTIF" => 'DATA BERHASIL DIKIRIM'));
            echo json_encode(array("STATUS" => 1, "NOTIFY" => 'DATA BERHASIL DIKIRIM', "TOTAL_DATA"=> $dataPenjualan['TOTAL_DATA'], "DATA"=>$dataPenjualan));
          }
            
        }
        
	}

    Public function sent_data_penjualan_service() {
		$string = isset($_POST['json']) ? $_POST['json'] : "";
		$data 	= json_decode($string, true);

		if($data == null OR $data == ""){
			$status = 2;
		}
		else{
			$status = 1;
		}

		header('Content-Type: application/json');
		echo json_encode(array("STATUS" => $status, "TOTAL_DATA" => $data['TOTAL_DATA'], "NOTIF" => $data['NOTIFY'], "DATA" => $data['LIST_DATA']));
	}
	////////////////////////////////////////////////////////////////////// JUAL ///////////////////////////////////////////////////////////////////////////
	
	////////////////////////////////////////////////////////////////////// AMBIL STOK ///////////////////////////////////////////////////////////////////////////
	public function getAllDataDistributor(){
		$dtTanggal 		= $this->input->post('tanggal_mulai');
		$sumber_data 	= $this->input->post('sumber_data');
		
		$this->get_data_stok_gudangSILOGS($dtTanggal, $sumber_data);
		$this->get_data_stok_gudangKWSG($dtTanggal, $sumber_data);

		// echo json_encode(array('notify'=>1, 'messages' => 'Data Berhasil Di Simpan', 'tot_data' => ''));
	}

	public function getAllDataDistributorHistory(){
		$dtTanggal 		= $this->input->post('tanggal_mulai');
		$sumber_data 	= $this->input->post('sumber_data');
		
		$this->get_data_stok_gudangSILOGSHistory($dtTanggal, $sumber_data);
		$this->get_data_stok_gudangKWSGHistory($dtTanggal, $sumber_data);

		// echo json_encode(array('notify'=>1, 'messages' => 'Data Berhasil Di Simpan', 'tot_data' => ''));
	}

	public function getAllDataDistributorScheduller(){
		$dtTanggal 		= date('Y-m-d');
		$sumber_data 	= 'DIST';
		
		$this->get_data_stok_gudangSILOGSScheduller($dtTanggal, $sumber_data);
		$this->get_data_stok_gudangKWSGScheduller($dtTanggal, $sumber_data);
	}

	public function getAllDataAreaManager(){
		$dtTanggal 		= $this->input->post('tanggal_mulai');
		$sumber_data 	= $this->input->post('sumber_data');
		
		$this->get_data_stok_gudangSILOGS($dtTanggal, $sumber_data);
		$this->get_data_stok_gudangKWSG($dtTanggal, $sumber_data);
	}

	public function get_data_stok_gudangSILOGS($dtTanggal, $sumber_data){

		$dtTanggal = date('Ymd', strtotime(str_replace('/','-',$dtTanggal)));
		$url 	= "http://202.162.212.157:8080/apiStok/restFull/apiStokGlobal.php";
		// $url 	= "https://3pl.semenindonesia.com/Crm_stok_gudang/sent_data_stok_gudang";

        $api 							= array();
        $api['KD_ASAL_DATA'] 			= 'DIST';
        $api['TANGGAL_STOK_AWAL'] 		= date("Y-m-d", strtotime("$dtTanggal -1 days"));
        
        $fields 						= "tgl=".$dtTanggal;
        $headers 						= array(
        										'Content-Type: application/x-www-form-urlencoded'
        										);

        $ch 							= curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        $result = curl_exec($ch);           
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        
        $dataGudang 	= json_decode($result);
        // print_r($dataGudang);
        if($dataGudang == NULL or $dataGudang == ""){
        	$keterangan = 'Error / Data Tidak Ada';

            echo json_encode(array('notify'=>2, 'messages' => $keterangan, 'tot_data' => 0));
        }
        else{
        	$keterangan =  'Data Berhasil Disimpan';

        	$DataStokCRM 	= $this->Crm_stok_gudang_model->getDataCrmStokGudang();
        	$batchData 		= $this->Crm_stok_gudang_model->InsertDataCRMSILOGS($DataStokCRM, $dataGudang);
            // echo json_encode(array('notify'=>1, 'messages' => $keterangan, 'tot_data' => $dataGudang->TOTAL_DATA));
        }

        curl_close($ch);	
    }

    public function get_data_stok_gudangSILOGSHistory($dtTanggal, $sumber_data){

		$dtTanggal = date('Ymd', strtotime(str_replace('/','-',$dtTanggal)));
		$url 	= "http://202.162.212.157:8080/apiStok/restFull/apiStokGlobal.php";
		// $url 	= "https://3pl.semenindonesia.com/Crm_stok_gudang/sent_data_stok_gudang";

        $api 							= array();
        $api['KD_ASAL_DATA'] 			= 'DIST';
        $api['TANGGAL_STOK_AWAL'] 		= date("Y-m-d", strtotime("$dtTanggal -1 days"));
        
        $fields 						= "tgl=".$dtTanggal;
        $headers 						= array(
        										'Content-Type: application/x-www-form-urlencoded'
        										);

        $ch 							= curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        $result = curl_exec($ch);           
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        
        $dataGudang 	= json_decode($result);
        // print_r($dataGudang);
        if($dataGudang == NULL or $dataGudang == ""){
        	$keterangan = 'Error / Data Tidak Ada';

            echo json_encode(array('notify'=>2, 'messages' => $keterangan, 'tot_data' => 0));
        }
        else{
        	$keterangan =  'Data Berhasil Disimpan';

        	$DataStokCRM 	= $this->Crm_stok_gudang_model->getDataCrmStokGudangHTSR();
        	$batchData 		= $this->Crm_stok_gudang_model->InsertDataCRMSILOGSHistory($DataStokCRM, $dataGudang);
            // echo json_encode(array('notify'=>1, 'messages' => $keterangan, 'tot_data' => $dataGudang->TOTAL_DATA));
        }

        curl_close($ch);	
    }
    
    public function get_data_stok_gudangKWSG($dtTanggal, $sumber_data){

		$dtTanggal = date('Y-m-d', strtotime(str_replace('/','-',$dtTanggal)));
		$url 				= "http://101.50.3.17:10808/serviceapp/apistokgudang.php";
		// $url 	= "https://3pl.semenindonesia.com/Crm_stok_gudang/sent_data_stok_gudang";

        $api 							= array();
        $api['KD_ASAL_DATA'] 			= 'DIST';
        $api['TANGGAL_STOK_AWAL'] 		= date("Y-m-d", strtotime("$dtTanggal -1 days"));
        
        $fields 						= "tanggal=".$dtTanggal;

        $headers 						= array(
        										'Content-Type: application/x-www-form-urlencoded'
        										);

        $ch 							= curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        $result = curl_exec($ch);           
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        
        $dataGudang 	= json_decode($result);
        // print_r($dataGudang);
        if($dataGudang == NULL or $dataGudang == ""){
        	$keterangan = 'Error / Data Tidak Ada';

            echo json_encode(array('notify'=>2, 'messages' => $keterangan, 'tot_data' => 0));
        }
        else{
        	$keterangan =  'Data Berhasil Disimpan';

        	$DataStokCRM 	= $this->Crm_stok_gudang_model->getDataCrmStokGudang();
        	$batchData 		= $this->Crm_stok_gudang_model->InsertDataCRMKWSG($DataStokCRM, $dataGudang);
            // echo json_encode(array('notify'=>1, 'messages' => $keterangan, 'tot_data' => $dataGudang->TOTAL_DATA));
        }

        curl_close($ch);	
    }

    public function get_data_stok_gudangKWSGHistory($dtTanggal, $sumber_data){

		$dtTanggal = date('Y-m-d', strtotime(str_replace('/','-',$dtTanggal)));
		$url 				= "http://101.50.3.17:10808/serviceapp/apistokgudang.php";
		// $url 	= "https://3pl.semenindonesia.com/Crm_stok_gudang/sent_data_stok_gudang";

        $api 							= array();
        $api['KD_ASAL_DATA'] 			= 'DIST';
        $api['TANGGAL_STOK_AWAL'] 		= date("Y-m-d", strtotime("$dtTanggal -1 days"));
        
        $fields 						= "tanggal=".$dtTanggal;

        $headers 						= array(
        										'Content-Type: application/x-www-form-urlencoded'
        										);

        $ch 							= curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        $result = curl_exec($ch);           
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        
        $dataGudang 	= json_decode($result);
        // print_r($dataGudang);
        if($dataGudang == NULL or $dataGudang == ""){
        	$keterangan = 'Error / Data Tidak Ada';

            echo json_encode(array('notify'=>2, 'messages' => $keterangan, 'tot_data' => 0));
        }
        else{
        	$keterangan =  'Data Berhasil Disimpan';

        	$DataStokCRM 	= $this->Crm_stok_gudang_model->getDataCrmStokGudangHTSR();
        	$batchData 		= $this->Crm_stok_gudang_model->InsertDataCRMKWSGHistory($DataStokCRM, $dataGudang);
            // echo json_encode(array('notify'=>1, 'messages' => $keterangan, 'tot_data' => $dataGudang->TOTAL_DATA));
        }

        curl_close($ch);	
    }
	////////////////////////////////////////////////////////////////////// AMBIL STOK SCHEDULER ///////////////////////////////////////////////////////////////////////////
	public function get_data_stok_gudangSILOGSScheduller($dtTanggal, $sumber_data){

		$dtTanggal = date('Ymd', strtotime(str_replace('/','-',$dtTanggal)));
		$url 	= "http://202.162.212.157:8080/apiStok/restFull/apiStokGlobal.php";
		// $url 	= "https://3pl.semenindonesia.com/Crm_stok_gudang/sent_data_stok_gudang";

        $api 							= array();
        $api['KD_ASAL_DATA'] 			= 'DIST';
        $api['TANGGAL_STOK_AWAL'] 		= date("Y-m-d", strtotime("$dtTanggal -1 days"));
        
        $fields 						= "tgl=".$dtTanggal;
        $headers 						= array(
        										'Content-Type: application/x-www-form-urlencoded'
        										);

        $ch 							= curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        $result = curl_exec($ch);           
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        
        $dataGudang 	= json_decode($result);
        // print_r($dataGudang);
        if($dataGudang == NULL or $dataGudang == ""){
        	$keterangan = 'Error / Data Tidak Ada';

            echo json_encode(array('notify'=>2, 'messages' => $keterangan, 'tot_data' => 0));
        }
        else{
        	$keterangan =  'Data Berhasil Disimpan';

        	$DataStokCRM 	= $this->Crm_stok_gudang_model->getDataCrmStokGudang();
        	$batchData 		= $this->Crm_stok_gudang_model->InsertDataCRMSILOGS($DataStokCRM, $dataGudang);
            echo json_encode(array('notify'=>1, 'messages' => $keterangan, 'tot_data' => $dataGudang->TOTAL_DATA));
        }

        curl_close($ch);	
    }
    
    public function get_data_stok_gudangKWSGScheduller($dtTanggal, $sumber_data){

		$dtTanggal = date('Y-m-d', strtotime(str_replace('/','-',$dtTanggal)));
		$url 				= "http://101.50.3.17:10808/serviceapp/apistokgudang.php";
		// $url 	= "https://3pl.semenindonesia.com/Crm_stok_gudang/sent_data_stok_gudang";

        $api 							= array();
        $api['KD_ASAL_DATA'] 			= 'DIST';
        $api['TANGGAL_STOK_AWAL'] 		= date("Y-m-d", strtotime("$dtTanggal -1 days"));
        
        $fields 						= "tanggal=".$dtTanggal;

        $headers 						= array(
        										'Content-Type: application/x-www-form-urlencoded'
        										);

        $ch 							= curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        $result = curl_exec($ch);           
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        
        $dataGudang 	= json_decode($result);
        // print_r($dataGudang);
        if($dataGudang == NULL or $dataGudang == ""){
        	$keterangan = 'Error / Data Tidak Ada';

            echo json_encode(array('notify'=>2, 'messages' => $keterangan, 'tot_data' => 0));
        }
        else{
        	$keterangan =  'Data Berhasil Disimpan';

        	$DataStokCRM 	= $this->Crm_stok_gudang_model->getDataCrmStokGudang();
        	$batchData 		= $this->Crm_stok_gudang_model->InsertDataCRMKWSG($DataStokCRM, $dataGudang);
            echo json_encode(array('notify'=>1, 'messages' => $keterangan, 'tot_data' => $dataGudang->TOTAL_DATA));
        }

        curl_close($ch);	
    }
	////////////////////////////////////////////////////////////////////// AMBIL STOK SCHEDULER ///////////////////////////////////////////////////////////////////////////

	////////////////////////////////////////////////////////////////////// AMBIL STOK ///////////////////////////////////////////////////////////////////////////

    //==start get data from forca==========================================================
    //AMBIL DATA STOK DARI FORCA
    public function get_all_data_stok_forca(){
		$tgl 		= "2018-02-20";//$this->input->post('tanggal');
		$token 	    = "26f82158-566a-4c08-b183-a0ba8b2e7543";
		
		$send_data = $this->get_data_stok_from_forca($tgl, $token);
		echo json_encode($send_data);
		// echo json_encode(array('notify'=>1, 'messages' => 'Data Berhasil Di Simpan', 'tot_data' => ''));
	}
    //AMBIL DATA JUAL DARI FORCA
    public function get_all_data_jual_forca(){
		$tgl 		= "2018-02-20";//$this->input->post('tanggal');
		$token 	    = "26f82158-566a-4c08-b183-a0ba8b2e7543";
		
		$send_data = $this->get_data_jual_from_forca($tgl, $token);
		echo json_encode($send_data);
		// echo json_encode(array('notify'=>1, 'messages' => 'Data Berhasil Di Simpan', 'tot_data' => ''));
	}
    //AMBIL DATA GR DARI FORCA
    public function get_all_data_gr_forca(){
		$tgl_start 		= "2018-02-20";//$this->input->post('tanggal_start');
        $tgl_end 		= "2018-02-22";//$this->input->post('tanggal_end');
		$token 	    = "26f82158-566a-4c08-b183-a0ba8b2e7543";
		
		$send_data = $this->get_data_gr_from_forca($tgl_start, $tgl_end, $token);
		echo json_encode($send_data);
		// echo json_encode(array('notify'=>1, 'messages' => 'Data Berhasil Di Simpan', 'tot_data' => ''));
	}
    
    private function get_data_stok_from_forca($tgl, $token){
        $url        = "http://dist1.forca.id:8080/apiforca/ws/forca/dist/getmaterialstock";
        
        $data_kirim = array();
        $data_kirim['token'] = $tgl;
        $data_kirim['movementdate'] = $token;
        $fields = $data_kirim;
        
        $headers = array(
							'Content-Type: application/json'
							// 'Content-Type: application/x-www-form-urlencoded'
						);

        $ch 							= curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);           
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        
        curl_close($ch);
        //echo 'CEK';
        return $result;
    }
    
    private function get_data_jual_from_forca($tgl, $token){
        $url        = "http://dist1.forca.id:8080/apiforca/ws/forca/dist/getsalesinvoice";
        
        $data_kirim = array();
        $data_kirim['token'] = $token;
        $data_kirim['accountdate'] = $tgl;
        $fields = $data_kirim;
        
        $headers = array(
							'Content-Type: application/json'
						);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);


        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);           
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        
        curl_close($ch);
        //echo 'CEK';
        return $result;
    }
    
    private function get_data_gr_from_forca($tgl_start, $tgl_end, $token){
        $url        = "http://dist1.forca.id:8080/apiforca/ws/forca/dist/getpenerimaansemen";
        
        $data_kirim = array();
        $data_kirim['token'] = $token;
        $data_kirim['xtglfrom'] = $tgl_start;
        $data_kirim['xtglto'] = $tgl_end;
        $fields = $data_kirim;
        
        $headers = array(
							'Content-Type: application/json'
						);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);           
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        
        curl_close($ch);
        //echo 'CEK';
        return $result;
    }
    //==end======================================================================================================
}

?>
