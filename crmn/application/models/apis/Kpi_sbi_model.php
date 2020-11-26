<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Kpi_sbi_model extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
			$this->db 		= $this->load->database('default', TRUE);
			$this->db_BK	= $this->load->database('Point', TRUE);
			$this->db_SDG   = $this->load->database('3pl', TRUE);
		}
		
		public function get_dt_target_kunjungan($id_user, $tahun, $bulan){
			$sql = "
				SELECT 
					COUNT(*) AS TARGET_KUNJUNGAN
					FROM CRMNEW_KUNJUNGAN_CUSTOMER
					WHERE ID_USER = $id_user
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY') = $tahun
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'MM') = $bulan
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function get_dt_realisasi_kunjungan($id_user, $tahun, $bulan){
			$sql = "
				SELECT
					COUNT(*) AS REALISASI_KUNJUNGAN
					FROM CRMNEW_KUNJUNGAN_CUSTOMER
					WHERE ID_USER = $id_user
					AND CHECKIN_TIME IS NOT NULL
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY') = $tahun
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'MM') = $bulan
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function Get_data_visit($id_user, $tahun, $bulan){
			$sql = "
				SELECT
				ID_SALES,
				SUM(TARGET) AS TARGET_KUNJUNGAN,
				SUM(REALISASI) AS REALISASI_KUNJUNGAN

				FROM R1_REPORT_VISIT_CRM 
				WHERE ID_SALES='$id_user'
				AND TAHUN='$tahun'
				AND BULAN='$bulan'
				GROUP BY ID_SALES
				
			";
			return $this->db->query($sql)->result_array();
		}
		
		
		public function get_dt_target_kunjungan_tso($id_tso, $tahun, $bulan){
			$sql = "
				SELECT 
					COUNT(*) AS TARGET_KUNJUNGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER
				WHERE ID_USER IN 
					(
					SELECT 
						DISTINCT(ID_SALES)
					FROM HIRARCKY_GSM_SALES_DISTRIK
					WHERE ID_SO = '$id_tso'
					)           
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY') = 'tahun'
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'MM') = 'bulan'

			";
			return $this->db->query($sql)->row();
		}
		
		public function get_dt_realisasi_kunjungan_tso($id_tso, $tahun, $bulan){
			$sql = "
				SELECT
					COUNT(*) AS REALISASI_KUNJUNGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER
				WHERE ID_USER IN 
					(
					SELECT 
						DISTINCT(ID_SALES)
					FROM HIRARCKY_GSM_SALES_DISTRIK
					WHERE ID_SO = '$id_tso'
					)         
					AND CHECKIN_TIME IS NOT NULL
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY') = '$tahun'
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'MM') = '$bulan'
			";
			return $this->db->query($sql)->row();
		}
		
		
		public function get_KPI_TSO($id_tso, $tahun, $bulan){
			$sql = "
				SELECT  
					NVL(SUM(TARGET) + SUM(TARGET_UNPLAN), 0) AS TARGET_ON,
    				NVL(SUM(REALISASI) + SUM(REAL_UNPLAN), 0) AS REALISASI_ON,
    				NVL(((SUM(REALISASI) + SUM(REAL_UNPLAN))/(SUM(TARGET) + SUM(TARGET_UNPLAN)))*100, 0) AS PERSENTASE_ON
				FROM R1_PERFORMAN_VISIT_SALES
				WHERE 
					ID_SO = '$id_tso'
					AND BULAN = '$bulan'
					AND TAHUN = '$tahun'
			";
			return $this->db->query($sql)->row();
		}
		
		
		// KPI CUSTOMER AKTIF
		
		public function get_c_sales($id_sales){
			$sql = "
				SELECT KD_CUSTOMER FROM CRMNEW_TOKO_SALES
				WHERE ID_SALES = '$id_sales' AND DELETE_MARK = 0
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function get_c_tso($id_tso){
			$sql = "
				SELECT KD_CUSTOMER FROM CRMNEW_TOKO_SALES
				WHERE ID_SALES IN (SELECT DISTINCT(ID_SALES) FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SO = '$id_tso') AND DELETE_MARK = 0
			";
			return $this->db->query($sql)->result_array();
		}
		
		public function get_ca_sales($id_sales){
			$sql = "
				SELECT KD_CUSTOMER FROM CRMNEW_TOKO_SALES
				WHERE ID_SALES = '$id_sales' AND DELETE_MARK = 0
			";
			$dt_c = $this->db->query($sql)->result_array();
			$dt_cus = "";
			
			$i = 1;
			foreach($dt_c as $dt_in){
				if(count($dt_c) == $i){
					$dt_cus .= $dt_in['KD_CUSTOMER'];
				} else {
					$dt_cus .= $dt_in['KD_CUSTOMER'].","; 
				}
				$i++;
			}
			
			if(count($dt_c) == 0){
				$dt_cus = "404";
			}
			// 1, 2 aktif -> 4 non aktif
			
			$sql ="
				SELECT
					NVL(COUNT(*), 0) as JML_AKTIF
					--PU.STATUS
				FROM M_CUSTOMER MC
				LEFT JOIN P_USER PU ON MC.KD_CUSTOMER = PU.ID_CUSTOMER
				WHERE PU.STATUS IN (0, 1, 2)
				AND MC.KD_CUSTOMER IN ($dt_cus)
				--GROUP BY PU.STATUS
			";
			
			return $this->db_BK->query($sql)->row();
		}
		
		public function get_ca_tso($id_tso){
			$sql = "
				SELECT DISTINCT(ID_SALES) FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SO = '$id_tso'
			";
			$dt_sales_tso = $this->db->query($sql)->result_array();
			$total = 0;
			foreach($dt_sales_tso as $is_dt){
				$id_sales_on = $is_dt['ID_SALES'];
				
				$sql = "
					SELECT KD_CUSTOMER FROM CRMNEW_TOKO_SALES
					WHERE ID_SALES = '$id_sales_on' AND DELETE_MARK = 0
				";
				$dt_c = $this->db->query($sql)->result_array();
				$dt_cus = "";
				
				$i = 1;
				foreach($dt_c as $dt_in){
					if(count($dt_c) == $i){
						$dt_cus .= $dt_in['KD_CUSTOMER'];
					} else {
						$dt_cus .= $dt_in['KD_CUSTOMER'].","; 
					}
					$i++;
				}
				
				if(count($dt_c) == 0){
					$dt_cus = "404";
				}
				// 1, 2 aktif -> 4 non aktif
				
				$sql ="
					SELECT
						NVL(COUNT(*), 0) as JML_AKTIF
						--PU.STATUS
					FROM M_CUSTOMER MC
					LEFT JOIN P_USER PU ON MC.KD_CUSTOMER = PU.ID_CUSTOMER
					WHERE PU.STATUS IN (0, 1, 2)
					AND MC.KD_CUSTOMER IN ($dt_cus)
					--GROUP BY PU.STATUS
				";
				
				$get = $this->db_BK->query($sql)->row();
				$get_aktif = $get->JML_AKTIF;
			
				$total += $get_aktif;
			}
			return $total;
		}
		
		
		public function get_sellOut_sales($id_sales, $bulan, $tahun){
			$sql = "
				SELECT NVL(KODE_DISTRIBUTOR, 404) as KD_DIST FROM SALES_DISTRIBUTOR
				WHERE ID_SALES = '$id_sales' and rownum = 1
			";
			$dist_sales = $this->db->query($sql)->row();
			
			if(count($dist_sales) != 0){
				$id_dist_in = $dist_sales->KD_DIST;
			} else {
				$id_dist_in = '404';
			}
			
			// print_r($id_dist_in);
			// exit();
			
			$sql = "
				SELECT KD_CUSTOMER FROM CRMNEW_TOKO_SALES
				WHERE ID_SALES = '$id_sales' AND DELETE_MARK = 0
			";
			$dt_c = $this->db->query($sql)->result_array();
			$dt_cus = "";
			
			$i = 1;
			foreach($dt_c as $dt_in){
				if(count($dt_c) == $i){
					$dt_cus .= "'".$dt_in['KD_CUSTOMER']."'";
				} else {
					$dt_cus .= "'".$dt_in['KD_CUSTOMER']."',"; 
				}
				$i++;
			}
			
			if(count($dt_c) == 0){
				$dt_cus = "404";
			}
			
			$sql ="
				SELECT 
					NVL(SUM(ZAK_KG * QTY_SELL_OUT / 1000), 0) AS JML_TON
				FROM SELL_OUT_TO_CRM
				WHERE KD_CUSTOMER IN ($dt_cus)
				AND KD_DISTRIBUTOR = '$id_dist_in'
				AND TO_CHAR(TGL_SPJ, 'YYYY') = '$tahun'
				AND TO_CHAR(TGL_SPJ, 'MM') = '$bulan'
			";
			
			return $this->db_SDG->query($sql)->row(); 
		}
		
		public function get_sellOut_tso($id_tso, $bulan, $tahun){
			$sql = "
				SELECT DISTINCT(ID_SALES) FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SO = '$id_tso'
			";
			$dt_sales_tso = $this->db->query($sql)->result_array();
			$total = 0;
			foreach($dt_sales_tso as $is_dt){
				$id_sales_on = $is_dt['ID_SALES'];
				
				$sql = "
					SELECT NVL(KODE_DISTRIBUTOR, 404) as KD_DIST FROM SALES_DISTRIBUTOR
					WHERE ID_SALES = '$id_sales_on' and rownum = 1
				";
				$dist_sales = $this->db->query($sql)->row();
				
				if(count($dist_sales) != 0){
					$id_dist_in = $dist_sales->KD_DIST;
				} else {
					$id_dist_in = '404';
				}
				
				// print_r($id_dist_in);
				// exit();
				
				$sql = "
					SELECT KD_CUSTOMER FROM CRMNEW_TOKO_SALES
					WHERE ID_SALES = '$id_sales_on' AND DELETE_MARK = 0
				";
				$dt_c = $this->db->query($sql)->result_array();
				$dt_cus = "";
				
				$i = 1;
				foreach($dt_c as $dt_in){
					if(count($dt_c) == $i){
						$dt_cus .= "'".$dt_in['KD_CUSTOMER']."'";
					} else {
						$dt_cus .= "'".$dt_in['KD_CUSTOMER']."',"; 
					}
					$i++;
				}
				
				if(count($dt_c) == 0){
					$dt_cus = "404";
				}
				
				$sql ="
					SELECT 
						NVL(SUM(ZAK_KG * QTY_SELL_OUT / 1000), 0) AS JML_TON
					FROM SELL_OUT_TO_CRM
					WHERE KD_CUSTOMER IN ($dt_cus)
					AND KD_DISTRIBUTOR = '$id_dist_in'
					AND TO_CHAR(TGL_SPJ, 'YYYY') = '$tahun'
					AND TO_CHAR(TGL_SPJ, 'MM') = '$bulan'
				";
				
				$get = $this->db_SDG->query($sql)->row(); 
				$get_ton = $get->JML_TON;
			
				$total += $get_ton;
			}
			return $total;
		}
		
		public function get_sales_tso($id_tso){
			$sql = "
				SELECT DISTINCT(ID_SALES) FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SO = '$id_tso'
			";
			return $this->db->query($sql)->result_array();
		}
		
	}
?>