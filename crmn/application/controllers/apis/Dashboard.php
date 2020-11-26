<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Dashboard extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Dashboard_model');
			$this->load->model('apis/Model_customer_sbi', 'mCustomerSbi');
        }
		
		public function Tokoaktive_post(){
			
			$id_user 			= $this->input->post('id_user');
			$kode_provinsi 		= $this->input->post('kode_provinsi');
			$kode_distributor 	= $this->input->post('kode_distributor');
			
			//SBI harcode 0
			$jml_aktiv = 0;
			$jml_non_aktiv=0;
			
			$cekUser = $this->mCustomerSbi->cekSalesSbi($id_user);
			
			//echo $cekUser[0]['ID_JENIS_USER'];
			//exit;
			
			if($cekUser[0]['ID_JENIS_USER'] == 1003){
			
				$hasil = $this->Dashboard_model->get_data_retail_activation($id_user, $tahun=null, $bulan=null, $kode_provinsi, $kode_distributor);
				
				$jml_aktiv 		= $hasil[0]['JML_AKTIF']+$hasil[1]['JML_AKTIF'];
				
				$jml_non_aktiv=0;
				if(count($hasil)>2){
					$jml_non_aktiv 	= $hasil[2]['JML_AKTIF'];
				}
			}
			
			$ouput = array(
				array(
					'name' 		=> 'TOKO AKTIF',
					'value'		=> $jml_aktiv,
				),
				array(
					'name' 		=> 'TOKO NON AKTIF',
					'value'		=> $jml_non_aktiv,
				),
			);
			
			$response = array("status" => "success", "data" => $ouput);
			
			$this->response($response);
			
		}
		public function ClusterToko_post(){
			
			$id_user 			= $this->input->post('id_user');
			$kode_provinsi 		= $this->input->post('kode_provinsi');
			$kode_distributor 	= $this->input->post('kode_distributor');
			$tahun 				= $this->input->post('tahun');
			$bulan 				= $this->input->post('bulan');
			
			//harcode 0 SBI
			$SUPER_PLATINUM 		= 0;
			$PLATINUM 				= 0;
			$GOLD 					= 0;
			$SILVER 				= 0;
			$NON_CLUSTER 			= 0;
			$TIDAK_ADA_PENJUALAN	= 0;
			$tdk_penjualan = 0;
			
			if($kode_provinsi != null or $kode_provinsi != ''){
				$hasil 		= $this->Dashboard_model->get_cluster_toko($kode_provinsi, $kode_distributor, $tahun, $bulan);
				$hasil_tl 	= $this->Dashboard_model->get_toko_tidak_lapor($kode_provinsi, $kode_distributor, $tahun, $bulan);
				
				$SUPER_PLATINUM 		= 0;
				$PLATINUM 				= 0;
				$GOLD 					= 0;
				$SILVER 				= 0;
				$NON_CLUSTER 			= 0;
				$TIDAK_ADA_PENJUALAN	= $hasil_tl[0]['TOTAL'];
				
				
				$tdk_penjualan = 0;
				
				foreach($hasil as $h){
					
					if($h['CLUSTERR']=='SUPER PLATINUM'){
						$SUPER_PLATINUM = $h['JUMLAH'];
					}
					
					if($h['CLUSTERR']=='PLATINUM'){
						$PLATINUM = $h['JUMLAH'];
					}
					
					if($h['CLUSTERR']=='GOLD'){
						$GOLD = $h['JUMLAH'];
					}
					
					if($h['CLUSTERR']=='SILVER'){
						$SILVER = $h['JUMLAH'];
					}
					
					if($h['CLUSTERR']=='NON CLUSTER'){
						$NON_CLUSTER = $h['JUMLAH'];
					}

					if($h['CLUSTERR'] == "TIDAK ADA PENJUALAN"){
						$tdk_penjualan = $h["JUMLAH"];
					}
				}
			}
			
			$ouput = array(
				array(
					'name' 		=> 'SUPER PLATINUM',
					'value'		=> $SUPER_PLATINUM,
				),
				array(
					'name' 		=> 'PLATINUM',
					'value'		=> $PLATINUM,
				),
				array(
					'name' 		=> 'GOLD',
					'value'		=> $GOLD,
				),
				array(
					'name' 		=> 'SILVER',
					'value'		=> $SILVER,
				),
				array(
					'name' 		=> 'NON CLUSTER',
					'value'		=> $NON_CLUSTER,
				),
				array(
					'name' 		=> 'TIDAK ADA PENJUALAN',
					'value'		=> $TIDAK_ADA_PENJUALAN + $tdk_penjualan,
				)
			);
			
			$response = array("status" => "success", "data" => $ouput);
			
			$this->response($response);
			
		}
		
		public function Getartikel_post(){
			
			$rss_url = 'https://semenindonesia.com/rss';
			$api_endpoint = 'https://api.rss2json.com/v1/api.json?rss_url=';
			$data = json_decode( file_get_contents($api_endpoint . urlencode($rss_url)) , true );
                        
                        $hasil = array();
			
//                        print_r($data);
//                        exit;
                        $n=0;
                        foreach ($data['items'] as $d){
                            $hasil[$n]['title']         =$d['title'];
                            $hasil[$n]['pubDate']       =$d['pubDate'];
                            $hasil[$n]['link']          =$d['link'];
                            $hasil[$n]['guid']          =$d['link'];
                            $hasil[$n]['author']        =$d['link'];
                            $hasil[$n]['thumbnail']     =$d['thumbnail'];
                            $hasil[$n]['description']   = trim(strip_tags($d['description']), "\n");
                            $hasil[$n]['content']       = trim(strip_tags($d['content']), "\n");
                            $n=$n+1;
                        }
                        $data = $hasil;
                        
                        //print_r($hasil);
                        
//                      
//                          foreach ($data as $d){
//                            
//                            
//                        }
                        //exit;
			// print_r($data);
			
			// if($data['status'] == 'ok'){
				// echo "====== {$data['feed']['title']} ======\n";

				// foreach ($data['items'] as $item) {
					// echo "{$item['title']}\n";
				// }
			// }
			
			$response = array("status" => "success", "TOTAL" => count($data), "data" => $data);
			
			$this->response($response);
			
		}
		public function GetartikelLocal_get(){
			
			$iduser = null; 
            if(isset($_GET['id_user'])){
                $iduser = $_GET['id_user'];
            }
			
			// print_r($iduser);
			// exit;
			
			$hasil = $this->Dashboard_model->Get_artikel();
			$data = array();
			$n=0;
			foreach($hasil as $h){
				
				$data[$n]['ID_ARTIKEL']		= $h['ID_ARTIKEL'];
				$data[$n]['TITLE']			= $h['TITLE'];
				$data[$n]['PUP_DATE']		= $h['PUP_DATE'];
				$data[$n]['LINK']			= $h['LINK'];
				$data[$n]['GUID']			= $h['GUID'];
				$data[$n]['AUTHOR']			= $h['AUTHOR'];
				$data[$n]['THUMBNAIL']	   	= $h['THUMBNAIL'];
				$data[$n]['DISCRIPTION']	= $h['DISCRIPTION'];
				$data[$n]['CONTENT']		= $h['CONTENT_1']. $h['CONTENT_2']. $h['CONTENT_3'];
				
				
				$n=$n+1;
			}
			
			 if($data){
					$response = array("status" => "success", "total" => count($data), "data" => $data, "user" => $iduser);

			}
			else {
					 $response = array("status" => "error", "total" => count($data), "message" => "Data tidak ada");
			}

			$this->response($response);
			
			
		}
		
		public function Kpi_post(){

			$id_user 	= $this->input->post('id_user');
			$tahun 		= $this->input->post('tahun');
			$bulan 		= $this->input->post('bulan');
			
			$index_kpi 			= $this->Kpi_model->get_data_index($id_user, $tahun, $bulan);
			$target_kunjungan 	= $this->Kpi_model->get_target_kunjungan($id_user); 
			$real_kunjungan		= $this->Kpi_model->get_realisasi_kunjungan($id_user);
			$distributor 		= $index_kpi[0]['KODE_DISTRIBUTOR'];
			$real_hvr			= $this->Kpi_model->get_data_realisasi($distributor, $tahun, $bulan);
			
			$hasil = $this->Make_perhitungan($index_kpi, $target_kunjungan, $real_kunjungan, $real_hvr);
			
			$KPI = $hasil['NILAI_VOLUME']+$hasil['NILAI_HARGA']+$hasil['NILAI_REVENUE']+$hasil['NILAI_KUNJUNGAN'];
			
			$response = array("status" => "success", "TOTAL_KPI" => $KPI, "data" => $hasil);
			
			$this->response($response);
			
		}
		public function KpiLama_post(){
			
			$id_user 	= $this->input->post('id_user');
			$tahun 		= $this->input->post('tahun');
			$bulan 		= $this->input->post('bulan');
			
			$index_kpi 			= $this->Kpi_model->get_data_index($id_user, $tahun, $bulan);
			$target_kunjungan 	= $this->Kpi_model->get_target_kunjungan($id_user); 
			$real_kunjungan		= $this->Kpi_model->get_realisasi_kunjungan($id_user);
			$distributor 		= $index_kpi[0]['KODE_DISTRIBUTOR'];
			$real_hvr			= $this->Kpi_model->get_data_realisasi($distributor, $tahun, $bulan);
			
			$hasil = $this->Make_perhitungan($index_kpi, $target_kunjungan, $real_kunjungan, $real_hvr);
			
			$output = array(
				array(
					'deskripsi_kpi' => "Volume",
					'satuan'		=> "TON",
					'index_kpi'		=> $hasil['INDEX_VOLUME'],
					'target'		=> $hasil['TARGET_VOLUME_BLN'],
					'realisasi_bulan' => $hasil['REALISASI_VOLUME_BLN'],
					'realisasi_prosentase' 	=> $hasil['REALISASI_VOLUME_PERSEN'],
					'nilai' 				=> $hasil['NILAI_VOLUME'],
				),
				array(
					'deskripsi_kpi' => "Harga",
					'satuan'		=> "Rupiah/Ton",
					'index_kpi'		=> $hasil['INDEX_HARGA'],
					'target'		=> $hasil['TARGET_HARGA_BLN'],
					'realisasi_bulan' => $hasil['REALiSASI_HARGA_BLN'],
					'realisasi_prosentase' 	=> $hasil['REALISASI_HARGA_PERSEN'],
					'nilai' 				=> $hasil['NILAI_HARGA'],
				),
				array(
					'deskripsi_kpi' => "Revenue",
					'satuan'		=> "Rupiah/Juta",
					'index_kpi'		=> $hasil['INDEX_REVENUE'],
					'target'		=> $hasil['TARGET_REVENUE_BLN'],
					'realisasi_bulan' => $hasil['REALISASI_REVENUE_BLN'],
					'realisasi_prosentase' 	=> $hasil['REALISASI_REVENUE_PERSEN'],
					'nilai' 				=> $hasil['NILAI_REVENUE'],
				),
				array(
					'deskripsi_kpi' => "Kunjungan",
					'satuan'		=> "",
					'index_kpi'		=> $hasil['INDEX_KUNJUNGAN'],
					'target'		=> $hasil['TARGET_KUNJUNGAN_BLN'],
					'realisasi_bulan' => $hasil['REALISASI_KUNJUNGAN_BLN'],
					'realisasi_prosentase' 	=> $hasil['REALISASI_KUNJUNGAN_PERSEN'],
					'nilai' 				=> $hasil['NILAI_KUNJUNGAN'],
				)
			);
			
			
			$KPI = $hasil['NILAI_VOLUME']+$hasil['NILAI_HARGA']+$hasil['NILAI_REVENUE']+$hasil['NILAI_KUNJUNGAN'];
			
			$response = array("status" => "success", "TOTAL_KPI" => $KPI, "data" => $output);
			
			$this->response($response);
			
		}
		
		private function Make_perhitungan($index_kpi, $target_kunjungan, $real_kunjungan, $real_hvr){
			
			$hasil = array(
				'INDEX_VOLUME'				=> $index_kpi[0]['INDEX_VOLUME'],
				'INDEX_HARGA'				=> $index_kpi[0]['INDEX_HARGA'],
				'INDEX_REVENUE'				=> $index_kpi[0]['INDEX_REVENUE'],
				'INDEX_KUNJUNGAN'			=> $index_kpi[0]['INDEX_KUNJUNGAN'],
				'TARGET_VOLUME_BLN'			=> $index_kpi[0]['TARGET_VOLUME'],
				'TARGET_HARGA_BLN' 			=> $index_kpi[0]['TARGET_HARGA'],
				'TARGET_REVENUE_BLN' 		=> $index_kpi[0]['TARGET_REVENUE'],
				'TARGET_KUNJUNGAN_BLN' 		=> $target_kunjungan[0]['TARGET_KUNJUNGAN'],
				'REALISASI_VOLUME_BLN' 		=> $real_hvr[0]['REAL_VOLUME'],
				'REALiSASI_HARGA_BLN' 		=> $real_hvr[0]['REAL_HARGA_PER_TON'],
				'REALISASI_REVENUE_BLN' 	=> $real_hvr[0]['REAL_REVENUE'],
				'REALISASI_KUNJUNGAN_BLN' 	=> $real_kunjungan[0]['REALISASI_KUNJUNGAN'],
				'REALISASI_VOLUME_PERSEN'	=> (($real_hvr[0]['REAL_VOLUME']/$index_kpi[0]['TARGET_VOLUME'])*100),
				'REALISASI_HARGA_PERSEN'	=> (($real_hvr[0]['REAL_HARGA_PER_TON']/$index_kpi[0]['TARGET_HARGA'])*100),
				'REALISASI_REVENUE_PERSEN'	=> (($real_hvr[0]['REAL_REVENUE']/$index_kpi[0]['TARGET_REVENUE'])*100),
				'REALISASI_KUNJUNGAN_PERSEN' => (($real_kunjungan[0]['REALISASI_KUNJUNGAN']/$target_kunjungan[0]['TARGET_KUNJUNGAN'])*100),
				'NILAI_VOLUME'				=> (($real_hvr[0]['REAL_VOLUME']/$index_kpi[0]['TARGET_VOLUME'])*$index_kpi[0]['INDEX_VOLUME']),
				'NILAI_HARGA'				=> (($real_hvr[0]['REAL_HARGA_PER_TON']/$index_kpi[0]['TARGET_HARGA'])*$index_kpi[0]['INDEX_HARGA']),
				'NILAI_REVENUE'				=> (($real_hvr[0]['REAL_REVENUE']/$index_kpi[0]['TARGET_REVENUE'])*$index_kpi[0]['INDEX_REVENUE']),
				'NILAI_KUNJUNGAN'			=> (($real_kunjungan[0]['REALISASI_KUNJUNGAN']/$target_kunjungan[0]['TARGET_KUNJUNGAN'])*$index_kpi[0]['INDEX_KUNJUNGAN'])
			);	
			
			return $hasil;
		}
		public function TagginglokasiInsertUpdate_post(){
			
			$id_user 	= $this->input->post('id_user');
			$dataLokasi = json_decode($_POST['data'], true);
			
			$hasil = $this->Dashboard_model->Insert_update_tagging_lokasi($id_user, $dataLokasi);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);
			
		}
		public function TaggingLokasi_post(){ //revision
			$dataLokasi = json_decode($_POST['data'], true);
			$data = array();
			$where = '';
			$n=0;
			foreach ($dataLokasi as $key => $value) {
				$data["ID_CUSTOMER"] = $value["ID_CUSTOMER"];
				$data["LATITUDE"] = $value["LATITUDE"];
				$data["LONGITUDE"] = $value["LONGITUDE"];
				$data["DELETE_MARK"] = "0";
				$data["CREATE_BY"] = (int)$this->post("id_user");
				//$data["CREATE_DATE"] = date('d-M-y h.s.i A');
				$json[] = $data;
				$dataIdCustomer[] = $data["ID_CUSTOMER"];
				
				$n=$n+1;
			}

			$addLokasi = $this->Dashboard_model->Insert_data_taggig($json, $dataIdCustomer);
			
			if($addLokasi){
				$response = array("status" => "success", "data" => $addLokasi, "message" => "Data Berhasil di Tambah");
			} else {
				$response = array("status" => "Error", "data" => array(), "message" => "Data gagal ditambah");
			}
			$this->response($response);
			exit();
			
			// $id_user 			= $this->input->post('id_user');
			// $id_customer 		= $this->input->post('id_customer');
			// $kd_provinsi 		= $this->input->post('kd_provinsi');
			// $kd_distrik 		= $this->input->post('kd_distrik');
			// $kd_area 			= $this->input->post('kd_area');
			// $Latitude 			= $this->input->post('Latitude');
			// $longitude 			= $this->input->post('longitude');
			
			// $hasil = $this->Dashboard_model->Insert_data_taggig($id_user, $id_customer, $kd_provinsi, $kd_distrik, $kd_area, $Latitude, $longitude);
			
			// if($hasil){
			// 	$response = array("status" => "success", "message" => "Data Berhasil di Tambah");
			// }
			// else {
			// 	$response = array("status" => "Error", "message" => "Data gagal ditambah");
			// }
			
			// $this->response($response);
			
		}
		public function TaggingUpdate_post(){  //revision
			$dataLokasi = json_decode($_POST['data'], true);
			$data = array();
			foreach ($dataLokasi as $key => $value) {
				$data["ID_LOKASI_CUSTOMER"] = (int)$value["ID_LOKASI_CUSTOMER"];
				$data["ID_CUSTOMER"] = (int)$value["ID_CUSTOMER"];
				$data["LATITUDE"] = strval($value["LATITUDE"]);
				$data["LONGITUDE"] = strval($value["LONGITUDE"]);
				//$data["CREATE_DATE"] = date('d-M-y h.s.i A');
				$data["CREATE_BY"] = (int)$this->post("id_user");
				$json[] = $data;
			}

			$addLokasi = $this->Dashboard_model->Update_data_tagging($json);
			if($addLokasi){
				$response = array("status" => "success", "message" => "Data Berhasil di ubah");
			} else {
				$response = array("status" => "Error", "message" => "Data gagal diubah");
			}
			$this->response($response);
			exit();
			
			// $id_user 			= $this->input->post('id_user');
			// $id_customer 		= $this->input->post('id_customer');
			// $kd_provinsi 		= $this->input->post('kd_provinsi');
			// $kd_distrik 		= $this->input->post('kd_distrik');
			// $kd_area 			= $this->input->post('kd_area');
			// $Latitude 			= $this->input->post('Latitude');
			// $longitude 			= $this->input->post('longitude');
			
			// $hasil = $this->Dashboard_model->Update_data_tugging($id_user, $id_customer, $kd_provinsi, $kd_distrik, $kd_area, $Latitude, $longitude);
			
			// if($hasil){
			// 	$response = array("status" => "success", "message" => "Data Berhasil di Update");
			// }
			// else {
			// 	$response = array("status" => "Error", "message" => "Data gagal Di Update");
			// }
			
			// $this->response($response);
			
			
		}
                public function TampilanTagging_post(){
                    
                    $id_user        = $this->input->post('id_user');
                    $id_customer    = $this->input->post('id_customer');
                    
                    $hasil = $this->Dashboard_model->Tampilan_customer($id_customer);
                    
                    if($hasil){
                            $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);

                    }
                    else {
                             $response = array("status" => "error", "total" => count($hasil), "message" => "Data tidak ada");
                    }

                    $this->response($response);
                }
		
		
	}


?>