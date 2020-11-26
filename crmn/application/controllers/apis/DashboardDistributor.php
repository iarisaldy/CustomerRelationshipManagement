<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class DashboardDistributor extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Dashboard_distributor_model');
			$this->load->model('apis/Dashboard_model');
			
        }
		
		public function ltDistributor_post(){
			$start	= $this->input->post("start");
			$limit	= $this->input->post("limit");
			$idDistributor	= $this->input->post("id_distributor");
			$namaToko	= $this->input->post("customer");
			
            $ltDistributor = $this->Dashboard_distributor_model->ltDistributor($start, $limit, $idDistributor, $namaToko);
            
			if($ltDistributor){
				$response = array("status" => "success", "total" => count($ltDistributor), "data" => $ltDistributor);
			}
			else {
				$response = array("status" => "error", "total" => count($ltDistributor), "message" => "Gaga mengambil data");
			}
			
			$this->response($response);	
        }
		
		public function DataResumePerformanceDetile_post(){
			
			$id_sales 		= $this->input->post("id_sales");
			$id_distributor = $this->input->post("id_distributor");
			$id_kunjungan 	= $this->input->post("id_kunjungan");
			
			$hasil_kun 		= $this->Dashboard_distributor_model->get_data_customer_survey($id_distributor, $id_sales, $id_kunjungan);
			
			$hasil_produk 	= $this->Dashboard_distributor_model->get_data_produk($id_distributor, $id_sales, $id_kunjungan);
			
			$data = array(
				'data_canvasing' 	=> $hasil_kun,
				'data_product'		=> $hasil_produk,
			);
			
			if($data){
				$response = array("status" => "success", "total" => count($data), "data" => $data);
			}
			else {
				$response = array("status" => "error", "total" => count($data), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);	
			
		}
		public function InsertDataError_post(){
			
			$id_user 		= $this->input->post("id_user");
			$id_kunjungan 	= $this->input->post("id_kunjungan");
			$id_customer 	= $this->input->post("id_customer");
			$id_error 		= $this->input->post("id_error");
			$ket_log 		= $this->input->post("ket_log");
			$status 		= $this->input->post("status");
			
			$hasil = $this->Dashboard_distributor_model->Insert_data_error($id_user, $id_kunjungan, $id_customer, $id_error, $ket_log, $status);
			
			if($hasil){
				$response = array("status" => "success", "message" => 'DATA BERHASIL DITAMBAH');
			}
			else {
				 $response = array("status" => "error", "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);
			
		}
		public function Addvisit_post(){
			$id_user 	= $this->input->post("id_user");
			$data 		= json_decode($_POST['data'], true);
			//print_r($data); 
			//exit();
			
			$hasil 		= $this->Dashboard_distributor_model->Add_schedule_kunjungan_mini($id_user, $data);
			
			// print_r($hasil); 
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);
		}
		public function Addkunjungan_post(){
			
			$id_user 	= $this->input->post("id_user");
			$data 		= json_decode($_POST['data'], true);
			print_r($data); 
			exit();
			
			$hasil 		= $this->Dashboard_distributor_model->Add_schedule_kunjungan($id_user, $data);
			
			// print_r($hasil); 
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);	
		}
		
		public function RetailresumePerformance_post(){
			
			print_r($_POST);
			
			
		}
		
		public function ResumeCustomer_post(){
			
			$kode_distributor 		= $this->input->post("kode_distributor");
			$limit 					= $this->input->post("limit");
			$start 					= $this->input->post("start");
			$jenis_order 			= $this->input->post("jenis_order");
			$order 					= $this->input->post("order");
			
			$hasil = $this->Dashboard_distributor_model->Get_data_resume_performance_ritail($kode_distributor, $limit, $start, $jenis_order, $order);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);
		}
		public function ClusterToko_post(){
			$kode_provinsi 		= $this->input->post('kode_provinsi');
			$kode_distributor 	= $this->input->post('kode_distributor');
			$tahun 				= $this->input->post('tahun');
			$bulan 				= $this->input->post('bulan');
			
			if($kode_provinsi == null || $kode_provinsi == ""){
				$kode_provinsi = $this->getProvinsiDist($kode_distributor);
			}
			
			
			$hasil 		= $this->Dashboard_model->get_cluster_toko($kode_provinsi, $kode_distributor, $tahun, $bulan);
			$hasil_tl 	= $this->Dashboard_model->get_toko_tidak_lapor($kode_provinsi, $kode_distributor, $tahun, $bulan);
			
			
			$SUPER_PLATINUM 		= 0;
			$PLATINUM 				= 0;
			$GOLD 					= 0;
			$SILVER 				= 0;
			$NON_CLUSTER 			= 0;
			if(empty($hasil_tl[0]['TOTAL'])){
				$TIDAK_ADA_PENJUALAN	= 0;
			}
			else {
				$TIDAK_ADA_PENJUALAN	= $hasil_tl[0]['TOTAL'];
			}
			
			$tdk_penjualan=0;
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
		
		public function getProvinsiDist($idDistributor){
			$getProvinsiDist = $this->Dashboard_distributor_model->getProvinsiDist($idDistributor);

			$idProvinsiDist = (int)"10".$getProvinsiDist->PROVINSI;
			
			return $idProvinsiDist;
		}
		
		
		public function ListCustomer_post(){
			
			$kode_distributor	= $this->input->post("kode_distributor");
			$kode_provinsi      = $this->input->post("kode_provinsi");
			if($kode_provinsi == null || $kode_provinsi == ""){
				$kode_provinsi = $this->getProvinsiDist($kode_distributor);
			}
			
			
			$tahun 			= $this->input->post("tahun");
			$tgl_mulai 			= date('d-m-Y', strtotime($this->input->post("tgl_mulai")));
			
			$bulan 			= $this->input->post("bulan");
			$tgl_selesai 		= date('d-m-Y', strtotime($this->input->post("tgl_selesai")));
			
			$start 				= $this->input->post("start");
			$limit 				= $this->input->post("limit");
			$sort 				= $this->input->post("sort");
			$sort_by 			= $this->input->post("sort_by"); 
			$id_lt				= $this->input->post("id_lt");
			
			$hasil 		= $this->Dashboard_distributor_model->get_cluster_toko($kode_provinsi, $kode_distributor, $tahun, $bulan);
			
			//$cluster = $this->Dashboard_distributor_model->cluster($idProvinsiDist, $month, null, $id_lt);
			
			$hasil_CUSTOMER = $this->Dashboard_distributor_model->get_data_customer($kode_distributor, $tgl_mulai, $tgl_selesai, $start, $limit, $sort, $sort_by);
			
			if($hasil_CUSTOMER){
				$response = array("status" => "success", "total" => count($hasil_CUSTOMER), "data" => $hasil_CUSTOMER);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil_CUSTOMER), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);
			
			
		}
		
		public function RPSales_post(){
			
			$kode_distributor	= $this->input->post("kode_distributor");
			$tahun 				= $this->input->post("tahun");
			$bulan 				= $this->input->post("bulan");
			
			
			$nama_sales =null;
			if(isset($_POST['nama_sales'])){
				$nama_sales =$_POST['nama_sales'];
			};
			
			$bulan 				= $this->input->post("bulan");
			
			$jenis_order = null;
			if(isset($_POST['jenis_order'])){
				$jenis_order = $_POST['jenis_order'];
			};
			
			$order = null;
			if(isset($_POST['order'])){
				$order = $_POST['order'];
			};
			
			
			$hasil = $this->Dashboard_distributor_model->get_data_resume_sales($kode_distributor, $tahun, $bulan, $nama_sales, $jenis_order, $order);
			
			// print_r($_POST);
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);
			
		}
		
		public function ResumePerformanceSalesDetile_post(){
			
			$user 			= $this->input->post("id_user");
			$tahun 			= $this->input->post("tahun");
			$bulan 			= $this->input->post("bulan");
			
			// print_r($_POST);
			$hasil = $this->Dashboard_distributor_model->get_grafik_kunjungan_user($user, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);
			
			//print_r($hasil);
		}
		
		public function ResumePerformance_post(){
			
			$distributor 	= $this->input->post("kode_distributor");
			$tahun 			= $this->input->post("tahun");
			
			$harga_beli 		= $this->Dashboard_distributor_model->get_data_harga_beli_distributor($distributor, $tahun);
			$target_harga_beli 	= $this->Dashboard_distributor_model->get_target_harga_beli_distributor($distributor, $tahun);
			
			for($i=0; $i<count($harga_beli); $i++){
				if(empty($target_harga_beli[$i]['LABEL'])){
					$harga_beli[$i]['TARGET']=0;
				}
				else {
					if($harga_beli[$i]['MONTH']==$target_harga_beli[$i]['LABEL']){
						$harga_beli[$i]['TARGET']=$target_harga_beli[$i]['VALUE'];
					}
				}
				
			}
			
			$volume_sidigi 	= $this->Dashboard_distributor_model->get_data_volume_pertahun($distributor, $tahun);
			$target_volume 	= $this->Dashboard_distributor_model->get_target_volume_distributor($distributor, $tahun);
			
			for($i=0; $i<count($volume_sidigi); $i++){
				if(empty($target_volume[$i]['LABEL'])){
					$volume_sidigi[$i]['TARGET']=0;
				}
				else {
					if($volume_sidigi[$i]['MONTH']==$target_volume[$i]['LABEL']){
						$volume_sidigi[$i]['TARGET']=$target_volume[$i]['VALUE'];
					}
				}
			}
			
			
			$harga_jual_sidigi 	= $this->Dashboard_distributor_model->get_data_harga_pertahun($distributor, $tahun);
			$target_harga_jual 	= $this->Dashboard_distributor_model->get_target_harga_jual_distributor($distributor, $tahun);
			
			for($i=0; $i<count($harga_jual_sidigi); $i++){
				if(empty($target_harga_jual[$i]['LABEL'])){
					$harga_jual_sidigi[$i]['TARGET']=0;
				}
				else {
					if($harga_jual_sidigi[$i]['MONTH']==$target_harga_jual[$i]['LABEL']){
						$harga_jual_sidigi[$i]['TARGET']=$target_harga_jual[$i]['VALUE'];
					}
				}
			}
			
			// print_r($harga_jual_sidigi);
			
			$data = array(
				'harga_beli' => $harga_beli,
				'harga_jual' => $harga_jual_sidigi,
				'volume_penjualan' => $volume_sidigi
			);
			
			$response = array("status" => "success", "data" => $data);
			
			$this->response($response);
			
		}
		public function Tokoaktive_post(){
			
			$kode_distributor 	= $this->input->post('kode_distributor');
			
			$hasil = $this->Dashboard_distributor_model->get_data_retail_activation($kode_distributor);
			
			$jml_aktiv 		= $hasil[0]['JML_AKTIF']+$hasil[1]['JML_AKTIF'];
			if(count($hasil) > 2){
				$jml_non_aktiv 	= $hasil[2]['JML_AKTIF'];
			}else {
				$jml_non_aktiv = 0;
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
					$response = array("status" => "success", "total" => count($data), "data" => $data);

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
		public function TaggingLokasi_post(){
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
		public function TaggingUpdate_post(){
			$dataLokasi = json_decode($_POST['data'], true);
			$data = array();
			foreach ($dataLokasi as $key => $value) {
				$data["ID_LOKASI_CUSTOMER"] = (int)$value["ID_LOKASI_CUSTOMER"];
				$data["ID_CUSTOMER"] = (int)$value["ID_CUSTOMER"];
				$data["LATITUDE"] = $value["LATITUDE"];
				$data["LONGITUDE"] = $value["LONGITUDE"];
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