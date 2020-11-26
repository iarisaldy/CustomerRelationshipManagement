<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Mini_model extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
			$this->db 		= $this->load->database('default', TRUE);
			$this->db_BK	= $this->load->database('Point', TRUE);
			$this->db_SDG   = $this->load->database('3pl', TRUE);
		}
		public function get_customer_sales($id_sales=null, $tahun=null, $bulan=null){
			
			$data = array(
				'COVERAGE' 			=> 0,
				'NOO' 				=> 0,
				'CUSTOMER_AKTIF' 	=> 0,
				'VOLUME_SELL_OUT'	=> 0,
				'TARGET_VISIT'  	=> 0,
				'REALISASI_VISIT' 	=> 0,
				'UNPLANNED_VISIT' 	=> 0,
			);
			
			if($id_sales!=null){
				
				$sql_ceking ="
					SELECT KODE_DISTRIBUTOR FROM SALES_DISTRIBUTOR WHERE ID_SALES='$id_sales'
				";	
				
				$ceking = $this->db->query($sql_ceking)->result_array();
				if(count($ceking)>0){
					$DISTRIBUTOR = $ceking[0]['KODE_DISTRIBUTOR'];
				}
				
				
				$sql ="
					SELECT
					KD_CUSTOMER
					FROM CRMNEW_TOKO_SALES
					WHERE DELETE_MARK='0' 
					AND ID_SALES='$id_sales'
					GROUP BY KD_CUSTOMER
				";	
				
				$hasil = $this->db->query($sql)->result_array();
				
				if(count($hasil)>0){
					$CustomerAll = '';
					foreach($hasil as $v){
						$CustomerAll .= "'".$v['KD_CUSTOMER']."',";
					}
					$CustomerAll .= "''";
					
					//data NOO
					$sno = "
						SELECT
						COUNT(KD_CUSTOMER) AS JML_NOO

						FROM VIEW_M_CUSTOMER
						WHERE SUBSTR(AKUISISI_DATE, 7, 4)='$tahun'
						AND SUBSTR(AKUISISI_DATE, 4, 2)='$bulan'
						AND KD_CUSTOMER IN ($CustomerAll)
					";
					//echo $sno; 
					$N1 = $this->db_BK->query($sno)->result_array();
					if(count($N1)>0){
						$NOO = $N1[0]['JML_NOO'];
						$data['NOO'] = $NOO;
					}
					
					//toko aktif
					$sno1 = "
						SELECT
						COUNT(*) AS JML_TOKO_AKTIF
						FROM POIN_PENJUALAN
						WHERE (JML_POIN>0 OR JML_POIN_SP>0 OR JML_POIN_SBI>0)
						AND TAHUN='$tahun'
						AND BULAN='$bulan'
						AND KD_CUSTOMER IN ($CustomerAll)
					";
					//echo $sno1;
					$N2 = $this->db_BK->query($sno1)->result_array();
					if(count($N2)>0){
						$AKTIF = $N2[0]['JML_TOKO_AKTIF'];
						$data['CUSTOMER_AKTIF'] = $AKTIF;
					}
					//coverage
					$bulanmin = $bulan-2;
					
					$sno2 = "
						SELECT
						COUNT(*) AS JML_TOKO_AKTIF
						FROM POIN_PENJUALAN
						WHERE (JML_POIN>0 OR JML_POIN_SP>0 OR JML_POIN_SBI>0)
						AND TAHUN='$tahun'
						AND BULAN BETWEEN '$bulanmin' AND '$bulan'
						AND KD_CUSTOMER IN ($CustomerAll)
					";
					//echo $sno2;
					$N3 = $this->db_BK->query($sno2)->result_array();
					if(count($N3)>0){
						$COVERAGE = $N3[0]['JML_TOKO_AKTIF'];
						$data['COVERAGE'] = $COVERAGE;
					}
					//Sellout
					
					
					$THNBLN = $tahun. $bulan;
					$sno3 = "
						SELECT
						(SUM(ZAK_KG*qty_sell_out)/1000) AS VOLUME_SELL_OUT
						FROM V_SELL_OUT_TO_CRM
						WHERE TO_CHAR(TGL_SPJ, 'YYYYMM')='$THNBLN'
						AND KD_CUSTOMER IN ($CustomerAll)
						
					";
					//echo $sno3;
					//exit();
					
					
					$N4 = $this->db_SDG->query($sno3)->result_array();
					if(count($N4)>0){
						$COVERAGE = $N4[0]['VOLUME_SELL_OUT'];
						$data['VOLUME_SELL_OUT'] = $COVERAGE;
					}
					
					$sno4 = "
						select
						SUM(TARGET) AS TARGET,
						SUM(REALISASI) AS REALISASI,
						SUM(UNPLAN_TARGET) AS UNPLANNED

						from VISIT_SALES_DISTRIBUTOR
						where TAHUN='$tahun'
						AND BULAN='$bulan'
						AND ID_SALES='$id_sales'
					";
					//echo $sno3;
					//exit();
					
					
					$N5 = $this->db->query($sno4)->result_array();
					if(count($N4)>0){
						$COVERAGE = $N5[0]['TARGET'];
						$data['TARGET_VISIT'] = $COVERAGE;
						$data['REALISASI_VISIT'] = $N5[0]['REALISASI'];
						$data['UNPLANNED_VISIT'] =  $N5[0]['UNPLANNED'];
					}
					
					
					
				}
				
			}
			return $data;
		}
		public function get_customer_AM($id_user=null, $tahun=null, $bulan=null){
			
			$data = array(
				'COVERAGE' 			=> 0,
				'NOO' 				=> 0,
				'CUSTOMER_AKTIF' 	=> 0,
				'COACHING_VISIT' 	=> 0,
				'MARKET_VISIT' 		=> 0,
				'VOLUME_SELL_OUT' 	=> 0,
				'TARGET_VISIT'  	=> 0,
				'REALISASI_VISIT' 	=> 0,
				'UNPLANNED_VISIT' 	=> 0,
			);
			
			if($id_user!=null){
				$p1 = $tahun. $bulan;
				if($bulan<10){
					$p1 = $tahun. '0'. $bulan;
					$mbulan = '0'. intval($bulan);
				}
				else {
					$mbulan=$bulan;
				}
				
				//coacing visit am
				$sql_ceking ="
					SELECT
					COUNT(*) AS JML_COACH
					FROM CRMNEW_SUPERVISORY_VISIT
					WHERE TO_CHAR(TGL_VISIT, 'YYYYMM')='$p1'
					AND ID_TSO='$id_user'
				";	
				
				$ceking = $this->db->query($sql_ceking)->result_array();
				if(count($ceking)>0){
					$COACH 	= $ceking[0]['JML_COACH'];
					$data['COACHING_VISIT'] = $COACH;
				}
				//market visit am
				$sql_ceking2 ="
					SELECT
						'PK' AS PK,
						SUM(TARGET) AS TARGET,
						SUM(REALISASI) AS REALISASI,
						SUM(UNPLAN_TARGET) AS UNPLAN_TARGET,
						SUM(UNPLAN_REAL) AS UNPLAN_REAL
					FROM VISIT_SALES_DISTRIBUTOR
					WHERE ID_SALES='$id_user'
					AND TAHUN='$tahun'
					AND BULAN='$mbulan'
					GROUP BY 
						'PK'
				";	
				
				$ceking2 = $this->db->query($sql_ceking2)->result_array();
				if(count($ceking2)>0){
					$REALISASI 	= $ceking2[0]['REALISASI'];
					$data['MARKET_VISIT'] = $REALISASI;
				}
				
				//
				$sql ="
				SELECT ID_DISTRIK FROM HIRARCKY_GSM_SO_DISTRIK WHERE ID_SO='$id_user' GROUP BY ID_DISTRIK
				";	
				
				$hasil = $this->db->query($sql)->result_array();
				
				if(count($hasil)>0){
					$CustomerAll = '';
					foreach($hasil as $v){
						$CustomerAll .= "'".$v['ID_DISTRIK']."',";
					}
					$CustomerAll .= "''";
					
					//data NOO
					$sno = "
						SELECT
						COUNT(KD_CUSTOMER) AS JML_NOO

						FROM VIEW_M_CUSTOMER
						WHERE SUBSTR(AKUISISI_DATE, 7, 4)='$tahun'
						AND SUBSTR(AKUISISI_DATE, 4, 2)='$bulan'
						AND KD_DISTRIK IN ($CustomerAll)
					";
					$N1 = $this->db_BK->query($sno)->result_array();
					if(count($N1)>0){
						$NOO = $N1[0]['JML_NOO'];
						$data['NOO'] = $NOO;
					}
					
					//toko aktif
					$sno1 = "
						SELECT
						COUNT(*) AS JML_TOKO_AKTIF
						FROM POIN_PENJUALAN
						WHERE (JML_POIN>0 OR JML_POIN_SP>0 OR JML_POIN_SBI>0)
						AND TAHUN='$tahun'
						AND BULAN='$bulan'
						AND KD_DISTRIK IN ($CustomerAll)
					";
					$N2 = $this->db_BK->query($sno1)->result_array();
					if(count($N2)>0){
						$AKTIF = $N2[0]['JML_TOKO_AKTIF'];
						$data['CUSTOMER_AKTIF'] = $AKTIF;
					}
					//coverage
					$bulanmin = $bulan-2;
					
					$sno2 = "
						SELECT
						COUNT(*) AS JML_TOKO_AKTIF
						FROM POIN_PENJUALAN
						WHERE (JML_POIN>0 OR JML_POIN_SP>0 OR JML_POIN_SBI>0)
						AND TAHUN='$tahun'
						AND BULAN BETWEEN '$bulanmin' AND '$bulan'
						AND KD_DISTRIK IN ($CustomerAll)
					";
					$N3 = $this->db_BK->query($sno2)->result_array();
					if(count($N3)>0){
						$COVERAGE = $N3[0]['JML_TOKO_AKTIF'];
						$data['COVERAGE'] = $COVERAGE;
					}
					
					$THNBLN = $tahun. $bulan;
					///sell out
					$sno3 = "
						SELECT
						(SUM(ZAK_KG*qty_sell_out)/1000) AS VOLUME_SELL_OUT
						FROM V_SELL_OUT_TO_CRM
						WHERE TO_CHAR(TGL_SPJ, 'YYYYMM')='$THNBLN'
                        AND KD_CUSTOMER IS NOT NULL
						AND KD_DISTRIK IN ($CustomerAll)
						
					";
					$N4 = $this->db_SDG->query($sno3)->result_array();
					if(count($N3)>0){
						$COVERAGE = $N4[0]['VOLUME_SELL_OUT'];
						$data['VOLUME_SELL_OUT'] = $COVERAGE;
					}
					
					$sql_ceking222 ="
					SELECT
						'PK' AS PK,
						SUM(TARGET) AS TARGET,
						SUM(REALISASI) AS REALISASI,
						SUM(UNPLAN_TARGET) AS UNPLAN_TARGET,
						SUM(UNPLAN_REAL) AS UNPLAN_REAL
					FROM VISIT_SALES_DISTRIBUTOR
					WHERE ID_SALES IN (SELECT ID_SALES FROM HIRARCKY_GSM_SALES_DISTRIK WHERE ID_SO='$id_user' GROUP BY ID_SALES)
					AND TAHUN='$tahun'
					AND BULAN='$mbulan'
					GROUP BY 
						'PK'
					";	
					
					$N5 = $this->db->query($sql_ceking222)->result_array();
					if(count($N5)>0){
						$COVERAGE = $N5[0]['TARGET'];
						$data['TARGET_VISIT'] = $COVERAGE;
						$data['REALISASI_VISIT'] = $N5[0]['REALISASI'];
						$data['UNPLANNED_VISIT'] =  $N5[0]['UNPLAN_TARGET'];
					}	
				
				}
				
			}
			return $data;
		}
		public function Insert_order_survey($id_user, $data){
			
			if(count($data)>0){
				foreach($data as $d){
					$ID_KUNJUNGAN 	= $d['ID_KUNJUNGAN'];
					$ID_PRODUK 		= $d['ID_PRODUK'];
					$JUMLAH_ORDER 	= $d['JUMLAH_ORDER'];
					//INSERT DATA SURVEY ORDER TOKO
					$sql = "
						INSERT INTO CRMNEW_DETILE_PRODUK_ORDER
						(ID_KUNJUNGAN, ID_PRODUK, JUMLAH_ORDER)
						VALUES
						('$ID_KUNJUNGAN','$ID_PRODUK','$JUMLAH_ORDER')
					";
					
					$this->db->query($sql);
					
				}
				
				$jml_data = count($data);
				$sqL2 = "
					SELECT
					ID_ORDER,
					ID_KUNJUNGAN,
					ID_PRODUK,
					JUMLAH_ORDER
					FROM CRMNEW_DETILE_PRODUK_ORDER
					WHERE ID_ORDER > ((SELECT MAX(ID_ORDER) FROM CRMNEW_DETILE_PRODUK_ORDER)- '$jml_data')
					ORDER BY ID_ORDER
				";
				return $this->db->query($sqL2)->result_array();
				
			}
			else {
				return false;
			}
			
		}
		
		public function Update_order_survey($id_user, $data){
			
			if(count($data)>0){
				foreach($data as $d){
					$ID_KUNJUNGAN 	= $d['ID_KUNJUNGAN'];
					$ID_PRODUK 		= $d['ID_PRODUK'];
					$JUMLAH_ORDER 	= $d['JUMLAH_ORDER'];
					//INSERT DATA SURVEY ORDER TOKO
					$sql = "
						UPDATE CRMNEW_DETILE_PRODUK_ORDER
						SET 
							ID_PRODUK='$ID_PRODUK',
							JUMLAH_ORDER='$JUMLAH_ORDER'
						WHERE ID_KUNJUNGAN='$ID_KUNJUNGAN'
						";
					
					$this->db->query($sql);
					
				}
				
				$jml_data = count($data);
				$sqL2 = "
					SELECT
					ID_ORDER,
					ID_KUNJUNGAN,
					ID_PRODUK,
					JUMLAH_ORDER
					FROM CRMNEW_DETILE_PRODUK_ORDER
					WHERE ID_ORDER > ((SELECT MAX(ID_ORDER) FROM CRMNEW_DETILE_PRODUK_ORDER)- '$jml_data')
					ORDER BY ID_ORDER
				";
				return $this->db->query($sqL2)->result_array();
				
			}
			else {
				return false;
			}
			
		}
		
		public function Delete_order_survey($id_user, $data=null){
			
			if($data!=null){
				$sql = "
					DELETE FROM CRMNEW_DETILE_PRODUK_ORDER
					WHERE ID_ORDER IN ($data)
					";
				
				$hasil = $this->db->query($sql);
				return $hasil;
			}
			else {
				return false;
			}
			
		}
		
		public function Get_list_order($id_user, $limit=null){
			
			$sqL2 = "
					SELECT
					*
					FROM (
					SELECT
					A.ID_ORDER,
					A.ID_KUNJUNGAN,
					A.ID_PRODUK,
					A.JUMLAH_ORDER, ROWNUM
					FROM CRMNEW_DETILE_PRODUK_ORDER A
					LEFT JOIN CRMNEW_KUNJUNGAN_CUSTOMER B  ON A.ID_KUNJUNGAN=B.ID_KUNJUNGAN_CUSTOMER  
					WHERE B.ID_USER='$id_user'
					AND ROWNUM < '$limit'
					)
					ORDER BY ID_ORDER DESC
					
				";
				
				return $this->db->query($sqL2)->result_array();
		}
		
		public function Statistik_sales($id_user, $tahun=null, $bulan=null){
			
			$sqL2 = "
					SELECT
					SUM(TARGET) AS TARGET,
					SUM(REALISASI) AS TOTAL_PLANNED,
					SUM(UNPLAN_REAL) AS TOTAL_UNPLANNED
					FROM VISIT_SALES_DISTRIBUTOR_A1
					WHERE ID_SALES='$id_user'
					AND TAHUN='$tahun'
					AND BULAN='$bulan'
					
				";
				
				return $this->db->query($sqL2)->result_array();
		}
		
	}
?>