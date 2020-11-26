<?php
	if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
 
	class Model_PerformanceSales extends CI_Model {

		public function __construct(){
			parent::__construct();
			$this->load->database();
			$this->db = $this->load->database('default', TRUE);
			$this->db_crm = $this->load->database('crm', TRUE);
			$this->db2 = $this->load->database('SCM', TRUE);
			$this->db3 = $this->load->database('3pl', TRUE);
			
		}
		public function get_target_harga_jual_distributor($distributor, $tahun){
			
			$sql ="
				SELECT
				CASE BULAN
					WHEN '1' THEN 'Jan'
					WHEN '2' THEN 'Feb'
					WHEN '3' THEN 'Mar'
					WHEN '4' THEN 'Apr'
					WHEN '5' THEN 'May'
					WHEN '6' THEN 'Jun'
					WHEN '7' THEN 'Jul'
					WHEN '8' THEN 'Aug'
					WHEN '9' THEN 'Sep'
					WHEN '10' THEN 'Oct'
					WHEN '11' THEN 'Nov'
					WHEN '12' THEN 'Dec'
				END AS label,
				ROUND(((HARGA*1.08)/1000), 0) as value
				FROM CRMNEW_TARGET_HARGA_KPI
				WHERE DELETE_MARK=0
				AND KODE_DISTRIBUTOR='0000000147'
				AND TAHUN='$tahun'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function get_target_harga_beli_distributor($distributor, $tahun){
			
			$sql ="
				SELECT
				CASE BULAN
					WHEN '1' THEN 'Jan'
					WHEN '2' THEN 'Feb'
					WHEN '3' THEN 'Mar'
					WHEN '4' THEN 'Apr'
					WHEN '5' THEN 'May'
					WHEN '6' THEN 'Jun'
					WHEN '7' THEN 'Jul'
					WHEN '8' THEN 'Aug'
					WHEN '9' THEN 'Sep'
					WHEN '10' THEN 'Oct'
					WHEN '11' THEN 'Nov'
					WHEN '12' THEN 'Dec'
				END AS label,
				ROUND((HARGA/1000), 0) as value
				FROM CRMNEW_TARGET_HARGA_KPI
				WHERE DELETE_MARK=0
				AND KODE_DISTRIBUTOR='0000000147'
				AND TAHUN='$tahun'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function get_data_harga_beli_distributor($distributor, $tahun){
			
			$sql = "
					SELECT
						CASE HS.BULAN
							WHEN '01' THEN 'Jan'
							WHEN '02' THEN 'Feb'
							WHEN '03' THEN 'Mar'
							WHEN '04' THEN 'Apr'
							WHEN '05' THEN 'May'
							WHEN '06' THEN 'Jun'
							WHEN '07' THEN 'Jul'
							WHEN '08' THEN 'Aug'
							WHEN '09' THEN 'Sep'
							WHEN '10' THEN 'Oct'
							WHEN '11' THEN 'Nov'
							WHEN '12' THEN 'Dec'
						END AS label,
						
						--SUM(HS.KWANTUMX) AS KWANTUMX,
						--SUM(HS.HARGA) AS HARGA,
						ROUND((SUM(HS.HARGA)/SUM(HS.KWANTUMX)/1000), 0) AS value
					FROM ZREPORT_SCM_HARGA_SOLDTO HS
					WHERE HS.SOLD_TO='$distributor'
					AND HS.TAHUN='$tahun'
					GROUP BY 
						HS.BULAN
					ORDER BY HS.BULAN
					
			";
			
			
			return $this->db2->query($sql)->result_array();
			
		}
		
		public function get_target_volume_distributor($distributor, $tahun){
			
			$sql ="
				SELECT
					CASE DATAKU.BULAN
											WHEN '01' THEN 'Jan'
											WHEN '02' THEN 'Feb'
											WHEN '03' THEN 'Mar'
											WHEN '04' THEN 'Apr'
											WHEN '05' THEN 'May'
											WHEN '06' THEN 'Jun'
											WHEN '07' THEN 'Jul'
											WHEN '08' THEN 'Aug'
											WHEN '09' THEN 'Sep'
											WHEN '10' THEN 'Oct'
											WHEN '11' THEN 'Nov'
											WHEN '12' THEN 'Dec'
										END AS label,
					DATAKU.TOTAL_TARGET AS VALUE
				FROM 
						(
							SELECT
								BULAN,
								SUM(RKAP) AS TOTAL_TARGET
							FROM M_TARGET_DISTRIBUTOR
							WHERE KD_SOLDTO='147'
							AND TAHUN='$tahun'
							GROUP BY 
								KD_SOLDTO,
								BULAN
							ORDER BY 
								BULAN
						) DATAKU
			";
			
			return $this->db2->query($sql)->result_array();
		}
		public function get_data_volume_pertahun($distributor, $tahun=null){
			
			if($tahun==2018){
			
				$sql ="
					SELECT
					DATA_ALL.LABEL,
					CASE DATA_ALL.LABEL
								WHEN '01' THEN 'Jan'
								WHEN '02' THEN 'Feb'
								WHEN '03' THEN 'Mar'
								WHEN '04' THEN 'Apr'
								WHEN '05' THEN 'May'
								WHEN '06' THEN 'Jun'
								WHEN '07' THEN 'Jul'
								WHEN '08' THEN 'Aug'
								WHEN '09' THEN 'Sep'
								WHEN '10' THEN 'Oct'
								WHEN '11' THEN 'Nov'
								WHEN '12' THEN 'Dec'
							END AS label,
					ROUND(SUM(DATA_ALL.VALUE), 0) AS VALUE
					FROM 
						(
						SELECT
							DATAKU.BULAN AS LABEL,
							DATAKU.VALUE
							FROM 
								(
									
									SELECT
										DATA_HARGA_VOLUME.BULAN,
										SUM(DATA_HARGA_VOLUME.QTY_TON) AS VALUE

										FROM 
											(
												SELECT
												*
												FROM
													(
														SELECT
															TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
															TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
															SUM(JS.QTY) AS QTY_ZAK,
															(SUM(JS.QTY)/25) AS QTY_TON,
															(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
															(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
														FROM TPL_T_JUAL_DTL_SERVICE JS
														WHERE JS.DELETE_MARK=0
														AND JS.KD_DISTRIBUTOR='$distributor'
														AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
														AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
														AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
														GROUP BY 
															TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
															TO_CHAR(JS.TGL_KIRIM, 'MM')
														ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
													) DATA40
												UNION ALL
												SELECT
												*
												FROM 
													(
														SELECT
															TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
															TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
															SUM(JS.QTY) AS QTY_ZAK,
															(SUM(JS.QTY)/20) AS QTY_TON,
															(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
															(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
														FROM TPL_T_JUAL_DTL_SERVICE JS
														WHERE JS.DELETE_MARK=0
														AND JS.KD_DISTRIBUTOR='$distributor'
														AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
														AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
														AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
														GROUP BY 
															TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
															TO_CHAR(JS.TGL_KIRIM, 'MM')
														ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
													) DATA50
												UNION ALL
												SELECT
												*
												FROM 
													(
														SELECT
															TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
															TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
															SUM(JS.QTY) AS QTY_ZAK,
															(SUM(JS.QTY)/25) AS QTY_TON,
															(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
															(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
														FROM TPL_T_JUAL_DTL_SERVICE JS
														WHERE JS.DELETE_MARK=0
														AND JS.KD_DISTRIBUTOR='$distributor'
														AND JS.KD_PRODUK IN  ('121-301-0240')
														AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
														AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
														GROUP BY 
															TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
															TO_CHAR(JS.TGL_KIRIM, 'MM')
														ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
													) DATAPUTIH	
												
											) DATA_HARGA_VOLUME
										GROUP BY 
											DATA_HARGA_VOLUME.BULAN
										ORDER BY DATA_HARGA_VOLUME.BULAN
									
								) DATAKU
						UNION
							SELECT
								BULAN.LABEL,
								BULAN.VALUE
							FROM 
							(
								SELECT '01' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '02' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '03' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '04' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '05' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '06' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '07' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '08' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '09' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '10' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '11' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '12' LABEL, 0 VALUE FROM DUAL    
							) BULAN
						) DATA_ALL
						GROUP BY
							DATA_ALL.LABEL
						ORDER BY DATA_ALL.LABEL
				";
				
			}
			else {
				$sql ="
					SELECT
					DATA_ALL.LABEL,
					CASE DATA_ALL.LABEL
								WHEN '01' THEN 'Jan'
								WHEN '02' THEN 'Feb'
								WHEN '03' THEN 'Mar'
								WHEN '04' THEN 'Apr'
								WHEN '05' THEN 'May'
								WHEN '06' THEN 'Jun'
								WHEN '07' THEN 'Jul'
								WHEN '08' THEN 'Aug'
								WHEN '09' THEN 'Sep'
								WHEN '10' THEN 'Oct'
								WHEN '11' THEN 'Nov'
								WHEN '12' THEN 'Dec'
							END AS label,
					ROUND(SUM(DATA_ALL.VALUE), 0) AS VALUE
					FROM 
						(
						SELECT
							DATAKU.BULAN AS LABEL,
							DATAKU.VALUE
							FROM 
								(
									
									SELECT
										DATA_HARGA_VOLUME.BULAN,
										SUM(DATA_HARGA_VOLUME.QTY_TON) AS VALUE

										FROM 
											(
												SELECT
												*
												FROM
													(
														SELECT
															TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
															TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
															SUM(JS.QTY) AS QTY_ZAK,
															(SUM(JS.QTY)/25) AS QTY_TON,
															(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
															(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
														FROM TPL_T_JUAL_DTL_SERVICE JS
														WHERE JS.DELETE_MARK=0
														AND JS.KD_DISTRIBUTOR='$distributor'
														AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
														AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
														GROUP BY 
															TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
															TO_CHAR(JS.TGL_KIRIM, 'MM')
														ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
													) DATA40
												UNION ALL
												SELECT
												*
												FROM 
													(
														SELECT
															TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
															TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
															SUM(JS.QTY) AS QTY_ZAK,
															(SUM(JS.QTY)/20) AS QTY_TON,
															(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
															(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
														FROM TPL_T_JUAL_DTL_SERVICE JS
														WHERE JS.DELETE_MARK=0
														AND JS.KD_DISTRIBUTOR='$distributor'
														AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
														AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
														GROUP BY 
															TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
															TO_CHAR(JS.TGL_KIRIM, 'MM')
														ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
													) DATA50
												UNION ALL
												SELECT
												*
												FROM 
													(
														SELECT
															TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
															TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
															SUM(JS.QTY) AS QTY_ZAK,
															(SUM(JS.QTY)/25) AS QTY_TON,
															(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
															(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
														FROM TPL_T_JUAL_DTL_SERVICE JS
														WHERE JS.DELETE_MARK=0
														AND JS.KD_DISTRIBUTOR='$distributor'
														AND JS.KD_PRODUK IN  ('121-301-0240')
														AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
														GROUP BY 
															TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
															TO_CHAR(JS.TGL_KIRIM, 'MM')
														ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
													) DATAPUTIH	
												
											) DATA_HARGA_VOLUME
										GROUP BY 
											DATA_HARGA_VOLUME.BULAN
										ORDER BY DATA_HARGA_VOLUME.BULAN
									
								) DATAKU
						UNION
							SELECT
								BULAN.LABEL,
								BULAN.VALUE
							FROM 
							(
								SELECT '01' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '02' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '03' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '04' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '05' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '06' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '07' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '08' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '09' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '10' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '11' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '12' LABEL, 0 VALUE FROM DUAL    
							) BULAN
						) DATA_ALL
						GROUP BY
							DATA_ALL.LABEL
						ORDER BY DATA_ALL.LABEL
				";
			}

			return $this->db3->query($sql)->result_array();
			
		}
		public function get_data_revenue_pertahun($distributor, $tahun=null){
			
			$sql ="
				SELECT
				DATA_ALL.LABEL,
				CASE DATA_ALL.LABEL
							WHEN '01' THEN 'Jan'
							WHEN '02' THEN 'Feb'
							WHEN '03' THEN 'Mar'
							WHEN '04' THEN 'Apr'
							WHEN '05' THEN 'May'
							WHEN '06' THEN 'Jun'
							WHEN '07' THEN 'Jul'
							WHEN '08' THEN 'Aug'
							WHEN '09' THEN 'Sep'
							WHEN '10' THEN 'Oct'
							WHEN '11' THEN 'Nov'
							WHEN '12' THEN 'Dec'
						END AS label,
				ROUND((SUM(DATA_ALL.VALUE))/1000000, 0) AS VALUE
				FROM 
					(
					SELECT
						DATAKU.BULAN AS LABEL,
						DATAKU.VALUE
						FROM 
							(
								
								SELECT
									DATA_HARGA_VOLUME.BULAN,
									SUM(DATA_HARGA_VOLUME.HARGA_TOTAL) AS VALUE

									FROM 
										(
											SELECT
											*
											FROM
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/25) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATA40
											UNION ALL
											SELECT
											*
											FROM 
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/20) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATA50
											UNION ALL
											SELECT
											*
											FROM 
												(
													SELECT
														TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
														TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
														SUM(JS.QTY) AS QTY_ZAK,
														(SUM(JS.QTY)/25) AS QTY_TON,
														(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
														(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
													FROM TPL_T_JUAL_DTL_SERVICE JS
													WHERE JS.DELETE_MARK=0
													AND JS.KD_DISTRIBUTOR='$distributor'
													AND JS.KD_PRODUK IN  ('121-301-0240')
													AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
													AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
													GROUP BY 
														TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
														TO_CHAR(JS.TGL_KIRIM, 'MM')
													ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
												) DATAPUTIH	
											
										) DATA_HARGA_VOLUME
									GROUP BY 
										DATA_HARGA_VOLUME.BULAN
									ORDER BY DATA_HARGA_VOLUME.BULAN
								
							) DATAKU
					UNION
						SELECT
							BULAN.LABEL,
							BULAN.VALUE
						FROM 
						(
							SELECT '01' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '02' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '03' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '04' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '05' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '06' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '07' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '08' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '09' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '10' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '11' LABEL, 0 VALUE FROM DUAL
							UNION ALL
							SELECT '12' LABEL, 0 VALUE FROM DUAL    
						) BULAN
					) DATA_ALL
					GROUP BY
						DATA_ALL.LABEL
					ORDER BY DATA_ALL.LABEL
			";

			return $this->db3->query($sql)->result_array();
			
		}
		
		public function get_data_harga_pertahun($distributor, $tahun=null){
			
			if($tahun==2018){				
				$sql ="
					SELECT
					DATA_ALL.LABEL,
					CASE DATA_ALL.LABEL
								WHEN '01' THEN 'Jan'
								WHEN '02' THEN 'Feb'
								WHEN '03' THEN 'Mar'
								WHEN '04' THEN 'Apr'
								WHEN '05' THEN 'May'
								WHEN '06' THEN 'Jun'
								WHEN '07' THEN 'Jul'
								WHEN '08' THEN 'Aug'
								WHEN '09' THEN 'Sep'
								WHEN '10' THEN 'Oct'
								WHEN '11' THEN 'Nov'
								WHEN '12' THEN 'Dec'
							END AS label,
					ROUND((SUM(DATA_ALL.VALUE)), 0) AS VALUE
					FROM 
						(
						SELECT
							DATAKU.BULAN AS LABEL,
							DATAKU.VALUE
							FROM 
								(
									
									SELECT
										DATA_HARGA_VOLUME.BULAN,
										(SUM(DATA_HARGA_VOLUME.HARGA_TON)/COUNT(DATA_HARGA_VOLUME.BULAN)/1000) AS VALUE

										FROM 
											(
												SELECT
												*
												FROM
													(
														SELECT
															TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
															TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
															SUM(JS.QTY) AS QTY_ZAK,
															(SUM(JS.QTY)/25) AS QTY_TON,
															(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
															(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
														FROM TPL_T_JUAL_DTL_SERVICE JS
														WHERE JS.DELETE_MARK=0
														AND JS.KD_DISTRIBUTOR='$distributor'
														AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
														AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
														AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
														GROUP BY 
															TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
															TO_CHAR(JS.TGL_KIRIM, 'MM')
														ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
													) DATA40
												UNION ALL
												SELECT
												*
												FROM 
													(
														SELECT
															TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
															TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
															SUM(JS.QTY) AS QTY_ZAK,
															(SUM(JS.QTY)/20) AS QTY_TON,
															(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
															(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
														FROM TPL_T_JUAL_DTL_SERVICE JS
														WHERE JS.DELETE_MARK=0
														AND JS.KD_DISTRIBUTOR='$distributor'
														AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
														AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
														AND TO_CHAR(JS.TGL_KIRIM, 'MM')>='10'
														GROUP BY 
															TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
															TO_CHAR(JS.TGL_KIRIM, 'MM')
														ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
													) DATA50
												
											) DATA_HARGA_VOLUME
										GROUP BY 
											DATA_HARGA_VOLUME.BULAN
										ORDER BY DATA_HARGA_VOLUME.BULAN
									
								) DATAKU
						UNION
							SELECT
								BULAN.LABEL,
								BULAN.VALUE
							FROM 
							(
								SELECT '01' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '02' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '03' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '04' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '05' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '06' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '07' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '08' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '09' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '10' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '11' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '12' LABEL, 0 VALUE FROM DUAL    
							) BULAN
						) DATA_ALL
						GROUP BY
							DATA_ALL.LABEL
						ORDER BY DATA_ALL.LABEL
				";
			
			}
			else {
				$sql ="
					SELECT
					DATA_ALL.LABEL,
					CASE DATA_ALL.LABEL
								WHEN '01' THEN 'Jan'
								WHEN '02' THEN 'Feb'
								WHEN '03' THEN 'Mar'
								WHEN '04' THEN 'Apr'
								WHEN '05' THEN 'May'
								WHEN '06' THEN 'Jun'
								WHEN '07' THEN 'Jul'
								WHEN '08' THEN 'Aug'
								WHEN '09' THEN 'Sep'
								WHEN '10' THEN 'Oct'
								WHEN '11' THEN 'Nov'
								WHEN '12' THEN 'Dec'
							END AS label,
					ROUND((SUM(DATA_ALL.VALUE)), 0) AS VALUE
					FROM 
						(
						SELECT
							DATAKU.BULAN AS LABEL,
							DATAKU.VALUE
							FROM 
								(
									
									SELECT
										DATA_HARGA_VOLUME.BULAN,
										(SUM(DATA_HARGA_VOLUME.HARGA_TON)/COUNT(DATA_HARGA_VOLUME.BULAN)/1000) AS VALUE

										FROM 
											(
												SELECT
												*
												FROM
													(
														SELECT
															TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
															TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
															SUM(JS.QTY) AS QTY_ZAK,
															(SUM(JS.QTY)/25) AS QTY_TON,
															(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
															(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
														FROM TPL_T_JUAL_DTL_SERVICE JS
														WHERE JS.DELETE_MARK=0
														AND JS.KD_DISTRIBUTOR='$distributor'
														AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
														AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
														GROUP BY 
															TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
															TO_CHAR(JS.TGL_KIRIM, 'MM')
														ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
													) DATA40
												UNION ALL
												SELECT
												*
												FROM 
													(
														SELECT
															TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
															TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
															SUM(JS.QTY) AS QTY_ZAK,
															(SUM(JS.QTY)/20) AS QTY_TON,
															(SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
															(SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
														FROM TPL_T_JUAL_DTL_SERVICE JS
														WHERE JS.DELETE_MARK=0
														AND JS.KD_DISTRIBUTOR='$distributor'
														AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
														AND TO_CHAR(JS.TGL_KIRIM, 'YYYY')='$tahun'
														GROUP BY 
															TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
															TO_CHAR(JS.TGL_KIRIM, 'MM')
														ORDER BY TO_CHAR(JS.TGL_KIRIM, 'MM')
													) DATA50
												
											) DATA_HARGA_VOLUME
										GROUP BY 
											DATA_HARGA_VOLUME.BULAN
										ORDER BY DATA_HARGA_VOLUME.BULAN
									
								) DATAKU
						UNION
							SELECT
								BULAN.LABEL,
								BULAN.VALUE
							FROM 
							(
								SELECT '01' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '02' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '03' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '04' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '05' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '06' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '07' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '08' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '09' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '10' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '11' LABEL, 0 VALUE FROM DUAL
								UNION ALL
								SELECT '12' LABEL, 0 VALUE FROM DUAL    
							) BULAN
						) DATA_ALL
						GROUP BY
							DATA_ALL.LABEL
						ORDER BY DATA_ALL.LABEL
				";
			}
			//echo $sql;
			return $this->db3->query($sql)->result_array();
			
		}
		

		public function kunjunganHarian($idUser = null, $bulan = null, $tahun = null){
            $sql = "SELECT
                TO_CHAR( CHECKIN_TIME, 'DD' ) AS TGL,
                NVL(COUNT( ID_KUNJUNGAN_CUSTOMER ), 0) AS TOTAL 
            FROM
                CRMNEW_KUNJUNGAN_CUSTOMER 
            WHERE
                CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = $idUser 
                AND TO_CHAR( CHECKIN_TIME, 'MM' ) = '$bulan' 
                AND TO_CHAR( CHECKIN_TIME, 'YYYY' ) = '$tahun' 
                AND CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK = 0
            GROUP BY
                TO_CHAR(
                CHECKIN_TIME,
                'DD')";
            $kunjunganHarian = $this->db->query($sql);
            if($kunjunganHarian->num_rows() > 0){
                return $kunjunganHarian->result();
            } else {
                return false;
            }
        }

		public function canvasingPerformance($bulan1 = null, $tahun = null){
			if($bulan1 < 10){
				$bulan = "0".$bulan1;
			} else {
				$bulan = $bulan1;
			}
			
			$idDistributor = $this->session->userdata('kode_dist');
			$sql = "SELECT
						CRMNEW_USER.ID_USER,
						CRMNEW_USER.NAMA,
						NVL(KUNJUNGAN.JML_KUNJUNGAN, 0) AS JML_KUNJUNGAN
					FROM
						CRMNEW_USER
						JOIN CRMNEW_USER_DISTRIBUTOR ON CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER
						LEFT JOIN (
					SELECT
						ID_USER,
						COUNT( ID_KUNJUNGAN_CUSTOMER ) AS JML_KUNJUNGAN 
					FROM
						CRMNEW_KUNJUNGAN_CUSTOMER 
					WHERE
						TO_CHAR( CHECKIN_TIME, 'MM' ) = '$bulan' 
						AND TO_CHAR( CHECKIN_TIME, 'YYYY' ) = '$tahun' 
					GROUP BY
						ID_USER 
						) KUNJUNGAN ON CRMNEW_USER.ID_USER = KUNJUNGAN.ID_USER 
					WHERE
						CRMNEW_USER.ID_JENIS_USER = 1003 
						AND CRMNEW_USER.DELETED_MARK = 0 
						AND CRMNEW_USER_DISTRIBUTOR.DELETE_MARK = 0 
						AND CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = '$idDistributor' ORDER BY NVL(KUNJUNGAN.JML_KUNJUNGAN, 0) DESC";
			$canvasing = $this->db->query($sql);
			if($canvasing->num_rows() > 0){
				return $canvasing->result();
			} else {
				return false;
			}
		}

		public function totalKunjungan($idUser = null, $bulan = null, $tahun = null){
            $whereUser = "";
            if(isset($idUser)){
            	$whereUser = "AND CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = $idUser";
            }

            $sql = "SELECT
                COUNT( CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER ) AS TOTAL 
            FROM
                CRMNEW_KUNJUNGAN_CUSTOMER 
            JOIN CRMNEW_USER ON CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER
            LEFT JOIN CRMNEW_USER_DISTRIBUTOR ON CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER
            WHERE
                TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'MM' ) = '$bulan' 
                AND TO_CHAR( CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'YYYY' ) = '$tahun'
                AND CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK = '0' AND CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME IS NOT NULL
                AND CRMNEW_USER_DISTRIBUTOR.DELETE_MARK = '0'
                $whereUser";
            $kunjunganHarian = $this->db->query($sql);
            if($kunjunganHarian->num_rows() > 0){
                return $kunjunganHarian->row();
            } else {
                return false;
            }
        }

	}
?>