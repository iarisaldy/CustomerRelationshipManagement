<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Kpi extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Kpi_model');
        }
		
		public function Kpi_post(){

			$id_user 	= $this->input->post('id_user');
			$tahun 		= $this->input->post('tahun');
			$bulan 		= $this->input->post('bulan');
			
			$index_kpi 			= $this->Kpi_model->get_data_index($id_user, $tahun, $bulan);
			$target_kunjungan 	= $this->Kpi_model->get_target_kunjungan($id_user); 
			$real_kunjungan		= $this->Kpi_model->get_realisasi_kunjungan($id_user, $tahun, $bulan);
			$distributor 		= $index_kpi[0]['KODE_DISTRIBUTOR'];
			$real_hvr			= $this->Kpi_model->get_data_realisasi($distributor, $tahun, $bulan);
			
			$hasil = $this->Make_perhitungan($index_kpi, $target_kunjungan, $real_kunjungan, $real_hvr);
			
			$KPI = $hasil['NILAI_VOLUME']+$hasil['NILAI_HARGA']+$hasil['NILAI_REVENUE']+$hasil['NILAI_KUNJUNGAN'];
			
			$response = array("status" => "success", "TOTAL_KPI" => $KPI, "data" => $hasil);
			
			$this->response($response);
			
		}
		public function KpiLamabackup_post(){
			
			$id_user 	= $this->input->post('id_user');
			$tahun 		= $this->input->post('tahun');
			$bulan 		= $this->input->post('bulan');
			
			$index_kpi 			= $this->Kpi_model->get_data_index($id_user, $tahun, $bulan);
			$target_kunjungan 	= $this->Kpi_model->get_target_kunjungan($id_user); 
			$real_kunjungan		= $this->Kpi_model->get_realisasi_kunjungan($id_user);
			
			if(count($index_kpi)==0){
				$distributor 		= null;//$index_kpi[0]['KODE_DISTRIBUTOR'];
			}
			else {
				$distributor 		= $index_kpi[0]['KODE_DISTRIBUTOR'];
			}
			
			$real_hvr				= $this->Kpi_model->get_data_realisasi($distributor, $tahun, $bulan);
			
			$hasil = $this->Make_perhitungan($index_kpi, $target_kunjungan, $real_kunjungan, $real_hvr);
			// print_r($index_kpi);
			// exit;
			
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
		
		public function KpiLama_post(){
			
			$id_user 	= $this->input->post('id_user');
			$tahun 		= $this->input->post('tahun');
			$bulan 		= $this->input->post('bulan');
			
			$index_kpi 			= $this->Kpi_model->get_data_index($id_user, $tahun, $bulan);
			$target_kunjungan 	= $this->Kpi_model->get_target_kunjungan($id_user); 
			$real_kunjungan		= $this->Kpi_model->get_realisasi_kunjungan($id_user, $tahun, $bulan);
			$target_sales 		= $this->Kpi_model->Get_target_sales($id_user, $tahun, $bulan);
			
			$TOKO 					= $this->Kpi_model->get_TOKO_SALES($id_user);
			// echo $TOKO;
			
			
			if(count($index_kpi)==0){
				$distributor 		= null;//$index_kpi[0]['KODE_DISTRIBUTOR'];
			}
			else {
				$distributor 		= $index_kpi[0]['KODE_DISTRIBUTOR'];
			}
			
			//$real_hvr				= $this->Kpi_model->get_data_realisasi($distributor, $tahun, $bulan);
			$realisasi 				= $this->Kpi_model->Get_data_realsales($tahun, $bulan, $TOKO);
			//$hasil = $this->Make_perhitungan($index_kpi, $target_kunjungan, $real_kunjungan, $real_hvr, $target_sales);
			
			
			//index Kpi
			$hasil['INDEX_VOLUME'] 			= 0;
			$hasil['INDEX_HARGA'] 			= 0;
			$hasil['INDEX_REVENUE'] 		= 0;
			$hasil['INDEX_KUNJUNGAN'] 		= 0;
			$hasil['TARGET_VOLUME_BLN'] 	= 0;
			$hasil['TARGET_HARGA_BLN'] 		= 0;
			$hasil['TARGET_REVENUE_BLN'] 	= 0;
			if(count($index_kpi)>0){
				$hasil['INDEX_VOLUME'] 			= $index_kpi[0]['INDEX_VOLUME'];
				$hasil['INDEX_HARGA'] 			= $index_kpi[0]['INDEX_HARGA'];
				$hasil['INDEX_REVENUE'] 		= $index_kpi[0]['INDEX_REVENUE'];
				$hasil['INDEX_KUNJUNGAN'] 		= $index_kpi[0]['INDEX_KUNJUNGAN'];
			}
			
			
			$hasil['TARGET_VOLUME_BLN'] 	= 0;
			$hasil['TARGET_HARGA_BLN'] 		= 0;
			$hasil['TARGET_REVENUE_BLN'] 	= 0;
			$hasil['TARGET_KUNJUNGAN_BLN']	= 0;
			if(count($target_sales)>0){
				$hasil['TARGET_VOLUME_BLN'] 	= $target_sales[0]['VOLUME'];
				$hasil['TARGET_HARGA_BLN'] 		= $target_sales[0]['HARGA']*25;
				$hasil['TARGET_REVENUE_BLN'] 	= $target_sales[0]['REVENUE'];
				$hasil['TARGET_KUNJUNGAN_BLN']	= $target_sales[0]['KUNJUNGAN'];
			}
			
			$hasil['REALISASI_VOLUME_BLN'] 	= 0;
			$hasil['REALiSASI_HARGA_BLN'] 	= 0;
			$hasil['REALISASI_REVENUE_BLN'] = 0;
			if(count($realisasi)>0){
				$hasil['REALISASI_VOLUME_BLN'] 	= $realisasi[0]['QTY_TON'];
				$hasil['REALiSASI_HARGA_BLN'] 	= $realisasi[0]['HARGAPERTON'];
				$hasil['REALISASI_REVENUE_BLN'] = $realisasi[0]['REVENUE'];
			}
			
			$hasil['REALISASI_KUNJUNGAN_BLN'] = 0;
			if(count($real_kunjungan)>0){
				$hasil['REALISASI_KUNJUNGAN_BLN'] = $real_kunjungan[0]['REALISASI_KUNJUNGAN'];
			}
			
			
			//ini perhitungan persentasenya
			if($hasil['REALISASI_VOLUME_BLN']==0 || $hasil['TARGET_VOLUME_BLN']==0){//realisasi volume persent
				$hasil['REALISASI_VOLUME_PERSEN']=0;
			}
			else{
				$hasil['REALISASI_VOLUME_PERSEN'] 		= (($hasil['REALISASI_VOLUME_BLN']/$hasil['TARGET_VOLUME_BLN'])*100);
			}
			if($hasil['REALiSASI_HARGA_BLN']==0 || $hasil['TARGET_HARGA_BLN']==0){//harga persent
				$hasil['REALISASI_HARGA_PERSEN'] = 0;
			}
			else {
				$hasil['REALISASI_HARGA_PERSEN'] 		= (($hasil['REALiSASI_HARGA_BLN']/$hasil['TARGET_HARGA_BLN'])*100);
			}
			if($hasil['REALISASI_REVENUE_BLN']==0 || $hasil['TARGET_REVENUE_BLN']==0){//revenue
				$hasil['REALISASI_REVENUE_PERSEN']=0;
			}
			else {
				$hasil['REALISASI_REVENUE_PERSEN']		= (($hasil['REALISASI_REVENUE_BLN']/$hasil['TARGET_REVENUE_BLN'])*100);
			}
			if($hasil['REALISASI_KUNJUNGAN_BLN']==0 || $hasil['TARGET_KUNJUNGAN_BLN']==0){//kunjungan
				$hasil['REALISASI_KUNJUNGAN_PERSEN']=0;
			}
			else {
				$hasil['REALISASI_KUNJUNGAN_PERSEN']	= (($hasil['REALISASI_KUNJUNGAN_BLN']/$hasil['TARGET_KUNJUNGAN_BLN'])*100);
			}
			
			
			
			$hasil['NILAI_VOLUME'] 			= (($hasil['REALISASI_VOLUME_PERSEN']*$hasil['INDEX_VOLUME'])/100);
			$hasil['NILAI_HARGA'] 			= ($hasil['REALISASI_HARGA_PERSEN']*$hasil['INDEX_HARGA'])/100;
			$hasil['NILAI_REVENUE'] 		= ($hasil['REALISASI_REVENUE_PERSEN']*$hasil['INDEX_REVENUE'])/100;
			$hasil['NILAI_KUNJUNGAN'] 		= ($hasil['REALISASI_KUNJUNGAN_PERSEN']*$hasil['INDEX_KUNJUNGAN'])/100;
			
			// echo "<pre>";
			// print_r($hasil);
			// echo "</pre>";
			
			// exit;
			
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
		private function Make_perhitungan($index_kpi, $target_kunjungan, $real_kunjungan, $real_hvr, $target_sales){
			
			echo "<pre>";
			print_r($target_sales);
			echo "</pre>";
			
			exit;
			$hasil = array();
			
			if(count($index_kpi)==0){
				$hasil['INDEX_VOLUME'] 			= 0;
				$hasil['INDEX_HARGA'] 			= 0;
				$hasil['INDEX_REVENUE'] 		= 0;
				$hasil['INDEX_KUNJUNGAN'] 		= 0;
				$hasil['TARGET_VOLUME_BLN'] 	= 0;
				$hasil['TARGET_HARGA_BLN'] 		= 0;
				$hasil['TARGET_REVENUE_BLN'] 	= 0;
			}
			else {
				$hasil['INDEX_VOLUME'] 			= $index_kpi[0]['INDEX_VOLUME'];
				$hasil['INDEX_HARGA'] 			= $index_kpi[0]['INDEX_HARGA'];
				$hasil['INDEX_REVENUE'] 		= $index_kpi[0]['INDEX_REVENUE'];
				$hasil['INDEX_KUNJUNGAN'] 		= $index_kpi[0]['INDEX_KUNJUNGAN'];
				$hasil['TARGET_VOLUME_BLN'] 	= $index_kpi[0]['TARGET_VOLUME'];
				$hasil['TARGET_HARGA_BLN'] 		= $index_kpi[0]['TARGET_HARGA'];
				$hasil['TARGET_REVENUE_BLN'] 	= $index_kpi[0]['TARGET_REVENUE'];
			}
			
			if(count($target_kunjungan)==0){
				$hasil['TARGET_KUNJUNGAN_BLN'] 	= 0;
			}
			else {
				$hasil['TARGET_KUNJUNGAN_BLN'] 	= $target_kunjungan[0]['TARGET_KUNJUNGAN'];
			}
			
			if(count($real_hvr)==0){
				$hasil['REALISASI_VOLUME_BLN'] 	= 0;
				$hasil['REALiSASI_HARGA_BLN'] 	= 0;
				$hasil['REALISASI_REVENUE_BLN'] = 0;
			}
			else {
				$hasil['REALISASI_VOLUME_BLN'] 	= $real_hvr[0]['REAL_VOLUME'];
				$hasil['REALiSASI_HARGA_BLN'] 	= $real_hvr[0]['REAL_HARGA_PER_TON'];
				$hasil['REALISASI_REVENUE_BLN'] = $real_hvr[0]['REAL_REVENUE'];
			}
			if(count($real_kunjungan)==0){
				$hasil['REALISASI_KUNJUNGAN_BLN'] = 0;
			}
			else{
				$hasil['REALISASI_KUNJUNGAN_BLN'] = $real_kunjungan[0]['REALISASI_KUNJUNGAN'];
			}
			
			
			if($hasil['REALISASI_VOLUME_BLN']==0 || $hasil['TARGET_VOLUME_BLN']==0){//realisasi volume persent
				$hasil['REALISASI_VOLUME_PERSEN']=0;
			}
			else{
				$hasil['REALISASI_VOLUME_PERSEN'] 		= (($hasil['REALISASI_VOLUME_BLN']/$hasil['TARGET_VOLUME_BLN'])*100);
			}
			if($hasil['REALiSASI_HARGA_BLN']==0 || $hasil['TARGET_HARGA_BLN']==0){//harga persent
				$hasil['REALISASI_HARGA_PERSEN'] = 0;
			}
			else {
				$hasil['REALISASI_HARGA_PERSEN'] 		= (($hasil['REALiSASI_HARGA_BLN']/$hasil['TARGET_HARGA_BLN'])*100);
			}
			if($hasil['REALISASI_REVENUE_BLN']==0 || $hasil['TARGET_REVENUE_BLN']==0){//revenue
				$hasil['REALISASI_REVENUE_PERSEN']=0;
			}
			else {
				$hasil['REALISASI_REVENUE_PERSEN']		= (($hasil['REALISASI_REVENUE_BLN']/$hasil['TARGET_REVENUE_BLN'])*100);
			}
			if($hasil['REALISASI_KUNJUNGAN_BLN']==0 || $hasil['INDEX_KUNJUNGAN']==0){//kunjungan
				$hasil['REALISASI_KUNJUNGAN_PERSEN']=0;
			}
			else {
				$hasil['REALISASI_KUNJUNGAN_PERSEN']	= (($hasil['REALISASI_KUNJUNGAN_BLN']/$hasil['INDEX_KUNJUNGAN'])*100);
			}
			
			echo "<pre>";
			print_r($hasil);
			echo "</pre>";
			
			exit;
			
			#//=========================================
			
			$hasil['NILAI_VOLUME'] 			= (($hasil['REALISASI_VOLUME_PERSEN']*$hasil['INDEX_VOLUME'])/100);
			$hasil['NILAI_HARGA'] 			= ($hasil['REALISASI_HARGA_PERSEN']*$hasil['INDEX_HARGA'])/100;
			$hasil['NILAI_REVENUE'] 		= ($hasil['REALISASI_REVENUE_PERSEN']*$hasil['INDEX_REVENUE'])/100;
			$hasil['NILAI_KUNJUNGAN'] 		= ($hasil['REALISASI_KUNJUNGAN_PERSEN']*$hasil['INDEX_KUNJUNGAN'])/100;
			
			// $hasil = array(
				
				 // 'NILAI_VOLUME'				=> (($real_hvr[0]['REAL_VOLUME']/$index_kpi[0]['TARGET_VOLUME'])*$index_kpi[0]['INDEX_VOLUME']),
				// 'NILAI_HARGA'				=> (($real_hvr[0]['REAL_HARGA_PER_TON']/$index_kpi[0]['TARGET_HARGA'])*$index_kpi[0]['INDEX_HARGA']),
				// 'NILAI_REVENUE'				=> (($real_hvr[0]['REAL_REVENUE']/$index_kpi[0]['TARGET_REVENUE'])*$index_kpi[0]['INDEX_REVENUE']),
				// 'NILAI_KUNJUNGAN'			=> (($real_kunjungan[0]['REALISASI_KUNJUNGAN']/$target_kunjungan[0]['TARGET_KUNJUNGAN'])*$index_kpi[0]['INDEX_KUNJUNGAN'])
			// );	
			
			return $hasil;
		}
		
		public function test(){
			
		}
		
	}


?>