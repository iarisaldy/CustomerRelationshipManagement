<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Kpi_sbi extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Kpi_sbi_model');
        }
		
		public function Kpi_sbi_post(){		//KPI sales
			
			$id_user 	= $this->input->post('id_user');
			$tahun 		= $this->input->post('tahun');
			$bulan 		= $this->input->post('bulan');
			
			
			$index_nilai = 0;
			
			$date_now = date('j');
			$hari_kerja = (int)$this->countDays($tahun, $bulan, array(0)); 
			$tot_hari_bulan = (int)$this->DatelastOfMonth($tahun, $bulan);
			$hari_libur = (int)$tot_hari_bulan - $hari_kerja;
			
			if($tahun == date('Y') and $bulan == date('m')){
				$index_nilai = (($date_now - $hari_libur - 1)/$hari_kerja) * 100;
			} else {
				$index_nilai = (($tot_hari_bulan - $hari_libur)/$hari_kerja) * 100;
			}
				
			
			// print_r($index_nilai);
			// exit();
			
			// KUNJUNGAN
			
			$target_kunjungan 		= $this->Kpi_sbi_model->get_dt_target_kunjungan($id_user, $tahun, $bulan); 
			$realisasi_kunjungan	= $this->Kpi_sbi_model->get_dt_realisasi_kunjungan($id_user, $tahun, $bulan);
			
			// Kunjungan
			$hasil['TARGET_KUNJUNGAN_BLN'] 		= floatval(0);
			//if(count($target_kunjungan)>0){
				$hasil['TARGET_KUNJUNGAN_BLN'] = floatval($target_kunjungan[0]['TARGET_KUNJUNGAN']);	
			//}
			
			$hasil['REALISASI_KUNJUNGAN_BLN'] 	= floatval(0);
			//if(count($realisasi_kunjungan)>0){
				$hasil['REALISASI_KUNJUNGAN_BLN'] = floatval($realisasi_kunjungan[0]['REALISASI_KUNJUNGAN']);
			//}
			
			$hasil['REALISASI_KUNJUNGAN_PERSEN'] = floatval(0);
			if($hasil['REALISASI_KUNJUNGAN_BLN'] > 0){
				$hasil['REALISASI_KUNJUNGAN_PERSEN'] = ($hasil['REALISASI_KUNJUNGAN_BLN'] / $hasil['TARGET_KUNJUNGAN_BLN']) * 100;
			} 
			
			
			// CUSTOMER AKTIF
			// $customer_sales = count($this->Kpi_sbi_model->get_c_sales($id_user));
			// $customer_aktif_sales =  $this->Kpi_sbi_model->get_ca_sales($id_user);
			// $jml_act = floatval($customer_aktif_sales->JML_AKTIF);
			// if($jml_act > 0){
				// $persen_cas = ($jml_act/$customer_sales) * 100;
			// } else {
				// $persen_cas = 0;
			// }
			
			// SELL OUT
			$target_so_bulan_sales = 1000;		//ton
			$realisasi_so_bulan_sales =  $this->Kpi_sbi_model->get_sellOut_sales($id_user, $bulan, $tahun);
			$jml_ton = floatval($realisasi_so_bulan_sales->JML_TON);
			if($jml_ton > 0){
				$persen_so_bulan_sales = ($jml_ton/$target_so_bulan_sales)*100;
			} else {
				$persen_so_bulan_sales = 0;
			}
			
			// print_r($realisasi_so_bulan_sales); 
			// exit();
			
			$output = array(
				array(
					'deskripsi_kpi' 		=> "Volume Selling Out",
					'satuan'				=> "TON",
					'index_kpi'				=> 0,
					'target'				=> $target_so_bulan_sales,
					'realisasi_bulan' 		=> $jml_ton,
					'realisasi_prosentase' 	=> round($persen_so_bulan_sales,2),
					'nilai' 				=> 0,
					'index_nilai'			=> round($index_nilai,2),
				),
				
				// array(
					// 'deskripsi_kpi' 		=> "Customer Active",
					// 'satuan'				=> "Toko",
					// 'index_kpi'				=> 0,
					// 'target'				=> $customer_sales, 
					// 'realisasi_bulan' 		=> $jml_act,
					// 'realisasi_prosentase' 	=> round($persen_cas,2),
					// 'nilai' 				=> 0,
					// 'index_nilai'			=> round($index_nilai,2),
				// ),
				
				array(
					'deskripsi_kpi' 		=> "Kunjungan Customer",
					'satuan'				=> "Kunjung",
					'index_kpi'				=> 0,
					'target'				=> $hasil['TARGET_KUNJUNGAN_BLN'], 
					'realisasi_bulan' 		=> $hasil['REALISASI_KUNJUNGAN_BLN'],
					'realisasi_prosentase' 	=> round($hasil['REALISASI_KUNJUNGAN_PERSEN'], 2),
					'nilai' 				=> 0,
					'index_nilai'			=> round($index_nilai,2),
				)
			);
			
			$response = array("status" => "success", "total" => 0, "data" => $output);
			$this->response($response);
			
		}
		
		
		
		public function KpiTso_post(){
			$id_tso 	= $this->input->post('id_tso');
			$bulan 		= $this->input->post('bulan');
			$tahun 		= $this->input->post('tahun');
			
			$index_nilai = 0;
			
			$date_now = date('j');
			$hari_kerja = (int)$this->countDays($tahun, $bulan, array(0));
			$tot_hari_bulan = (int)$this->DatelastOfMonth($tahun, $bulan);
			$hari_libur = (int)$tot_hari_bulan - $hari_kerja;
			
			if($tahun == date('Y') and $bulan == date('m')){
				$index_nilai = (($date_now - $hari_libur - 1)/$hari_kerja) * 100;
			} else {
				$index_nilai = (($tot_hari_bulan - $hari_libur)/$hari_kerja) * 100;
			}
			
			// KUNJUNGAN
			$kpi_kunjungan 		= $this->Kpi_sbi_model->get_KPI_TSO($id_tso, $tahun, $bulan); 
			
			
			// CUSTOMER AKTIF
			// $customer_sales = count($this->Kpi_sbi_model->get_c_tso($id_tso));
			// $customer_aktif_sales =  $this->Kpi_sbi_model->get_ca_tso($id_tso);
			// $jml_act = floatval($customer_aktif_sales);
			// if($jml_act > 0){
				// $persen_cas = ($jml_act/$customer_sales) * 100;
			// } else {
				// $persen_cas = 0;
			// }
			
			
			// SELLING OUT
			$tot_sales_tso = count($this->Kpi_sbi_model->get_sales_tso($id_tso));
			$target_so_bulan_tso = 1000 * $tot_sales_tso;		//ton
			$realisasi_so_bulan_tso =  $this->Kpi_sbi_model->get_sellOut_tso($id_tso, $bulan, $tahun);
			$jml_ton = floatval($realisasi_so_bulan_tso);
			if($jml_ton > 0){
				$persen_so_bulan_tso = ($jml_ton/$target_so_bulan_tso)*100;
			} else {
				$persen_so_bulan_tso = 0;
			}
			
			//print_r($kpi_kunjungan);
			//exit();
			
			$output = array(
				array(
					'deskripsi_kpi' 		=> "Volume Selling Out",
					'satuan'				=> "TON",
					'index_kpi'				=> 0,
					'target'				=> $target_so_bulan_tso,
					'realisasi_bulan' 		=> $jml_ton,
					'realisasi_prosentase' 	=> round($persen_so_bulan_tso,2),
					'nilai' 				=> 0,
					'index_nilai'			=> round($index_nilai,2),
				),
				// array(
					// 'deskripsi_kpi' 		=> "Customer Active",
					// 'satuan'				=> "Toko",
					// 'index_kpi'				=> 0,
					// 'target'				=> $customer_sales, 
					// 'realisasi_bulan' 		=> $jml_act,
					// 'realisasi_prosentase' 	=> round($persen_cas,2),
					// 'nilai' 				=> 0,
					// 'index_nilai'			=> round($index_nilai,2),
				// ),
				array(
					'deskripsi_kpi' 		=> "Kunjungan Customer",
					'satuan'				=> "Kunjung",
					'index_kpi'				=> 0,
					'target'				=> $kpi_kunjungan->TARGET_ON, 
					'realisasi_bulan' 		=> $kpi_kunjungan->REALISASI_ON,
					'realisasi_prosentase' 	=> round($kpi_kunjungan->PERSENTASE_ON, 2),
					'nilai' 				=> 0,
					'index_nilai'			=> round($index_nilai,2),
				)
			);
			
			$response = array("status" => "success", "total" => 0, "data" => $output);
			$this->response($response);
		}		
		
		
		private function countDays($year, $month, $ignore) {
			$count = 0;
			$counter = mktime(0, 0, 0, $month, 1, $year);
			while (date("n", $counter) == $month) {
				if (in_array(date("w", $counter), $ignore) == false) {
					$count++;
				}
				$counter = strtotime("+1 day", $counter);
			}
			return $count;
		}
		
		private function DatelastOfMonth($year, $month) {
			return date("j", strtotime('-1 second', strtotime('+1 month',strtotime($month . '/01/' . $year. ' 00:00:00'))));
		}
		
		
		
		// --> toko aktif
		
		public function TokoAktifSales_post(){
			$id_user 	= $this->input->post('id_user');
			
			// CUSTOMER AKTIF
			$customer_sales = count($this->Kpi_sbi_model->get_c_sales($id_user));
			$customer_aktif_sales =  $this->Kpi_sbi_model->get_ca_sales($id_user);
			$jml_act = floatval($customer_aktif_sales->JML_AKTIF);
			if($jml_act > 0){
				$persen_cas = ($jml_act/$customer_sales) * 100;
			} else {
				$persen_cas = 0;
			}
			
			$ouput = array(
				array(
					'name' 		=> 'TOKO AKTIF',
					'value'		=> $jml_act,
				),
				array(
					'name' 		=> 'TOKO NON AKTIF',
					'value'		=> $customer_sales - $jml_act,
				),
			);
			
			$response = array("status" => "success", "data" => $ouput);
			
			$this->response($response);
		}
		
		public function TokoAktifTso_post(){
			$id_tso 	= $this->input->post('id_tso');
			
			//CUSTOMER AKTIF
			$customer_tso = count($this->Kpi_sbi_model->get_c_tso($id_tso));
			$customer_aktif_tso =  $this->Kpi_sbi_model->get_ca_tso($id_tso);
			$jml_act = floatval($customer_aktif_tso);
			if($jml_act > 0){
				$persen_cas = ($jml_act/$customer_tso) * 100;
			} else {
				$persen_cas = 0;
			}
			
			$ouput = array(
				array(
					'name' 		=> 'TOKO AKTIF',
					'value'		=> $jml_act,
				),
				array(
					'name' 		=> 'TOKO NON AKTIF',
					'value'		=> $customer_tso - $jml_act,
				),
			);
			
			$response = array("status" => "success", "data" => $ouput);
			
			$this->response($response);
		}
		
	}
	
?>