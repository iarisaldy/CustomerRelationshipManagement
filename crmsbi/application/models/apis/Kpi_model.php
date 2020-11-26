<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Kpi_model extends CI_Model {

		public function get_realisasi_kunjungan($id_user){
			
			$sql ="
				SELECT
				COUNT(*) AS REALISASI_KUNJUNGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER
				WHERE ID_USER='$id_user'
				AND CHECKIN_TIME IS NOT NULL
			";
			
			return $this->db->query($sql)->result_array();
		}
		public function get_TOKO_SALES($id_user){
			
			
			$sql ="
				SELECT
				ID_CUSTOMER
				FROM CRMNEW_ASSIGN_TOKO_SALES
				WHERE DELETE_MARK=0
				AND ID_USER='$id_user'
			";
			
			$hasil = $this->db->query($sql)->result_array();
			
			$isi = "";
			$n=1;
			foreach($hasil as $h){
				
				if(count($hasil)>$n){
					$isi .= "'". $h['ID_CUSTOMER']. "',";
				}
				else {
					$isi .= "'". $h['ID_CUSTOMER']. "'";
				}
				$n=$n+1;
			}
			return $isi;
			
		}
		
		public function Get_data_realsales($tahun, $bulan, $toko=null){
			$this->db = $this->load->database('3pl', TRUE); 
			$sql ="
				SELECT
                    VOLUME.TAHUN,
                    VOLUME.BULAN,
                    ROUND(SUM(VOLUME.QTY_TON), 0) AS QTY_TON,
                    ROUND(SUM(VOLUME.HARGA_TON), 0) AS HARGA_TON,
                    ROUND(SUM((VOLUME.QTY_TON*VOLUME.HARGA_TON)), 0) AS REVENUE,
                    ROUND((SUM((VOLUME.QTY_TON*VOLUME.HARGA_TON))/SUM(VOLUME.QTY_TON)), 0) AS HARGAPERTON                    
                    FROM 
                        (
                            SELECT
                            *
                            FROM
                                (
                                    SELECT
                                        JS.KD_DISTRIBUTOR,
                                        JS.KD_CUSTOMER AS KD_GUDANG,
                                        GUDANG.NM_GDG AS NM_GUDANG,
                                        JS.KD_TOKO,
                                        JS.NM_TOKO,
                                        TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
                                        TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
                                        SUM(JS.QTY) AS QTY_ZAK,
                                        (SUM(JS.QTY)/25) AS QTY_TON,
                                        (SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
                                        (SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
                                    FROM TPL_T_JUAL_DTL_SERVICE_BULANAN JS
                                    LEFT JOIN GUDANG_SIDIGI GUDANG ON JS.KD_CUSTOMER=GUDANG.KD_GDG
                                    WHERE JS.DELETE_MARK=0
                                    AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
                                    GROUP BY 
                                        JS.KD_DISTRIBUTOR,
                                        JS.KD_CUSTOMER,
                                        GUDANG.NM_GDG,
                                        JS.KD_TOKO,
                                        JS.NM_TOKO,
                                        TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
                                        TO_CHAR(JS.TGL_KIRIM, 'MM')
                                    ORDER BY TO_CHAR(JS.TGL_KIRIM, 'YYYY'), TO_CHAR(JS.TGL_KIRIM, 'MM')
                                ) DATA40
                            UNION ALL
                            SELECT
                            *
                            FROM 
                                (
                                    SELECT
                                        JS.KD_DISTRIBUTOR,
                                        JS.KD_CUSTOMER AS KD_GUDANG,
                                        GUDANG.NM_GDG AS NM_GUDANG,
                                        JS.KD_TOKO,
                                        JS.NM_TOKO,
                                        TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
                                        TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
                                        SUM(JS.QTY) AS QTY_ZAK,
                                        (SUM(JS.QTY)/20) AS QTY_TON,
                                        (SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
                                        (SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
                                    FROM TPL_T_JUAL_DTL_SERVICE_BULANAN JS
                                    LEFT JOIN GUDANG_SIDIGI GUDANG ON JS.KD_CUSTOMER=GUDANG.KD_GDG
                                    WHERE JS.DELETE_MARK=0
                                    AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
                                    GROUP BY 
                                        JS.KD_DISTRIBUTOR,
                                        JS.KD_CUSTOMER,
                                        GUDANG.NM_GDG,
                                        JS.KD_TOKO,
                                        JS.NM_TOKO,
                                        TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
                                        TO_CHAR(JS.TGL_KIRIM, 'MM')
                                    ORDER BY TO_CHAR(JS.TGL_KIRIM, 'YYYY'), TO_CHAR(JS.TGL_KIRIM, 'MM')
                                ) DATA50
                        ) VOLUME
                    WHERE 
						VOLUME.KD_TOKO IN ($toko)
						AND VOLUME.TAHUN='$tahun'
						AND VOLUME.BULAN='$bulan'
                    GROUP BY 
						VOLUME.TAHUN,
						VOLUME.BULAN
            ";
			//echo $sql;
			return $this->db->query($sql)->result_array();
			
		}
		public function Get_target_sales($is_sales, $tahun, $bulan){
			$sql ="
				SELECT
				TS.ID_SALES,
				CU.NAMA AS NAMA_SALES,
				TS.KODE_DISTRIBUTOR,
				TS.TAHUN,
				TS.BULAN,
				TS.VOLUME,
				TS.HARGA,
				(TS.VOLUME*TS.HARGA) AS REVENUE,
				TS.KUNJUNGAN
				FROM CRMNEW_KPI_TARGET_SALES TS 
				LEFT JOIN  CRMNEW_USER CU ON TS.ID_SALES=CU.ID_USER
				WHERE TS.DELETE_MARK='0'
				AND TS.ID_SALES IS NOT NULL
				AND TS.ID_SALES='$is_sales'
				AND TS.TAHUN='$tahun'
				AND TS.BULAN='$bulan'
				ORDER BY TAHUN, BULAN

			";
			
			return $this->db->query($sql)->result_array();
		}
		public function get_target_kunjungan($id_user){
			
			$sql ="
				SELECT
				COUNT(*) AS TARGET_KUNJUNGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER
				WHERE ID_USER='$id_user'
			";
			
			return $this->db->query($sql)->result_array();
		}
		public function get_data_index($id_user, $tahun, $bulan){
			$bulan2 = intval($bulan);
			$sql ="
				SELECT
					DATA_INDEX.*,
					VOL.VOLUME AS TARGET_VOLUME,
					HARGA.HARGA AS TARGET_HARGA,
					(VOL.VOLUME*HARGA.HARGA) AS TARGET_REVENUE
					FROM 
					(
						SELECT
							I.ID_JENIS_USER,
							I.KODE_DISTRIBUTOR,
							I.VOLUME AS INDEX_VOLUME,
							I.HARGA AS INDEX_HARGA,
							I.REVENUE AS INDEX_REVENUE,
							I.KUNJUNGAN AS INDEX_KUNJUNGAN
						FROM CRMNEW_INDEX_KPI I
						WHERE I.DELETE_MARK=0 
						AND I.ID_JENIS_USER='1002'
						AND I.TAHUN='$tahun'
						AND I.BULAN='$bulan'
						AND I.KODE_DISTRIBUTOR=(
													SELECT
														KODE_DISTRIBUTOR
													FROM CRMNEW_USER_DISTRIBUTOR 
													WHERE DELETE_MARK=0
													AND ID_USER='$id_user'
													AND ROWNUM=1
												)
					) DATA_INDEX
					LEFT JOIN CRMNEW_TARGET_VOLUME_KPI VOL ON DATA_INDEX.KODE_DISTRIBUTOR=VOL.KODE_DISTRIBUTOR
						AND VOL.TAHUN='$tahun' AND BULAN='$bulan2'
					LEFT JOIN CRMNEW_TARGET_HARGA_KPI HARGA ON DATA_INDEX.KODE_DISTRIBUTOR=HARGA.KODE_DISTRIBUTOR
						AND HARGA.TAHUN='$tahun' AND HARGA.BULAN='$bulan2'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
        
		public function get_data_realisasi($distributor, $tahun, $bulan){
			
			$this->db = $this->load->database('SCM', TRUE); 
			
			$sql ="				
				SELECT
                                 DATA1.KD_DISTRIBUTOR,
                                 ROUND(DATA1.VOLUME, 0) AS REAL_VOLUME,
                                 ROUND(DATA1.HARGAPERTON) AS REAL_HARGA_PER_TON,
                                 ROUND(DATA1.REVENUE,0) AS REAL_REVENUE
                                FROM 
                                    (
                                        SELECT 
                                        VOLUME1.*,
                                        HARGA1.VOL,
                                        HARGA1.HARGAPERTON,
                                        HARGA1.REVENUE
                                        FROM 
                                            (
                                                SELECT 
                                                    VOLUME.KD_DISTRIBUTOR,
                                                    VOLUME.TAHUN,
                                                    VOLUME.BULAN,
                                                    SUM(VOLUME.QTY) AS VOLUME
                                                FROM ZREPORT_SCM_RPT_SALES_SOLDTO VOLUME
                                                WHERE SUBSTR (ITEM, 1, 7)!='121-200'
                                                AND SUBSTR (ITEM, 1, 7)!='121-302'
                                                GROUP BY 
                                                    VOLUME.KD_DISTRIBUTOR,
                                                    VOLUME.TAHUN,
                                                    VOLUME.BULAN
                                                ORDER BY 
                                                     VOLUME.KD_DISTRIBUTOR,
                                                     VOLUME.TAHUN,
                                                     VOLUME.BULAN
                                            ) VOLUME1
                                        LEFT JOIN 
                                            (
                                                SELECT
                                                    HARGA.SOLD_TO,
                                                    HARGA.TAHUN,
                                                    HARGA.BULAN,
                                                    SUM(HARGA.KWANTUMX) AS VOL,
                                                    SUM(HARGA.HARGA) AS REVENUE,
                                                    ( SUM(HARGA.HARGA)/ SUM(HARGA.KWANTUMX)) AS HARGAPERTON
                                                FROM ZREPORT_SCM_HARGA_SOLDTO HARGA
                                                WHERE SUBSTR(HARGA.ITEM, 1, 7) != '121-201'
                                                 AND SUBSTR (ITEM, 1, 7)!='121-302'
                                                GROUP BY 
                                                    HARGA.SOLD_TO,
                                                    HARGA.TAHUN,
                                                    HARGA.BULAN
                                                ORDER BY 
                                                    HARGA.SOLD_TO,
                                                    HARGA.TAHUN,
                                                    HARGA.BULAN
                                            ) HARGA1 ON VOLUME1.KD_DISTRIBUTOR=HARGA1.SOLD_TO
                                                AND VOLUME1.TAHUN=HARGA1.TAHUN AND VOLUME1.BULAN=HARGA1.BULAN
                                        WHERE HARGA1.SOLD_TO IS NOT NULL
                                    ) DATA1
                                WHERE DATA1.TAHUN='$tahun'
                                AND DATA1.BULAN='$bulan'
								AND DATA1.KD_DISTRIBUTOR='$distributor'
                                ORDER BY
                                     VOLUME DESC
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		
		
		
		
		public function Perubahan_password_user($id_user, $pass_lama, $pass_baru){
			
			$status = null;
			
			$bkl = "
				SELECT 
				PASSWORD
				FROM CRMNEW_USER
				WHERE ID_USER='$id_user'
			";
			
			$hasil = $this->db->query($bkl)->result_array();
			
			if(count($hasil)==1){
				$passdb = $hasil[0]['PASSWORD'];
				if($passdb==$pass_lama){
					$sql ="
						UPDATE CRMNEW_USER 
						SET 
						PASSWORD='$pass_baru',
						UPDATED_BY='$id_user',
						UPDATED_AT=SYSDATE
						WHERE ID_USER='$id_user'
						AND PASSWORD='$pass_lama'
					";
					$cek = $this->db->query($sql);
					if($cek){
						$status=1;
					}
					
				}
			}
			
			return $status;
		}

    }
?>