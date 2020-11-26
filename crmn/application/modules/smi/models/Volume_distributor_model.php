<?php
    class Volume_distributor_model extends CI_Model {

        public function __construct(){
            parent::__construct();  
        }

        public function Get_data_distributor(){
            $db     = $this->load->database("crm", true);
            
            $sql ="
                SELECT
                CD.KODE_DISTRIBUTOR,
                CD.NAMA_DISTRIBUTOR
                FROM CRMNEW_DISTRIBUTOR CD
                ORDER BY CD.KODE_DISTRIBUTOR
            ";
            return $db->query($sql)->result_array();

        }
        public function Get_data_volume_HJ($tahun, $bulan){
            $db     = $this->load->database("marketplace", true);
            
            $sql ="
                SELECT
                VOLUME.KD_DISTRIBUTOR,
                VOLUME.TAHUN,
                VOLUME.BULAN,
                ROUND(VOLUME.QTY_TON, 0) AS QTY_TON,
                ROUND(VOLUME.HARGA_TON, 0) AS HARGA_TON,
                ROUND((VOLUME.QTY_TON*VOLUME.HARGA_TON), 0) AS REVENUE
                FROM 
                    (
                        SELECT
                        *
                        FROM
                            (
                                SELECT
                                    JS.KD_DISTRIBUTOR,
                                    TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
                                    TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
                                    SUM(JS.QTY) AS QTY_ZAK,
                                    (SUM(JS.QTY)/25) AS QTY_TON,
                                    (SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
                                    (SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
                                FROM TPL_T_JUAL_DTL_SERVICE_BULANAN JS
                                WHERE JS.DELETE_MARK=0
                                AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
                                GROUP BY 
                                    JS.KD_DISTRIBUTOR,
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
                                    TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
                                    TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
                                    SUM(JS.QTY) AS QTY_ZAK,
                                    (SUM(JS.QTY)/20) AS QTY_TON,
                                    (SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
                                    (SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
                                FROM TPL_T_JUAL_DTL_SERVICE_BULANAN JS
                                WHERE JS.DELETE_MARK=0
                                AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
                                GROUP BY 
                                    JS.KD_DISTRIBUTOR,
                                    TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
                                    TO_CHAR(JS.TGL_KIRIM, 'MM')
                                ORDER BY TO_CHAR(JS.TGL_KIRIM, 'YYYY'), TO_CHAR(JS.TGL_KIRIM, 'MM')
                            ) DATA50
                    ) VOLUME
                
            ";
            if($tahun==2018){
                $sql .= " WHERE VOLUME.BULAN>9 
                        AND VOLUME.TAHUN='$tahun'
                        AND VOLUME.BULAN='$bulan'
                ";
            }
            else {
                $sql .= " WHERE VOLUME.TAHUN='$tahun'
                        AND VOLUME.BULAN='$bulan'
                ";   
            }

            return $db->query($sql)->result_array();
        }

        public function Get_data_volume_HB($tahun, $bulan){
            $db     = $this->load->database("SCM", true);
            
            $sql ="
                SELECT
                 DATA1.KD_DISTRIBUTOR,
                 DATA1.TAHUN,
                 DATA1.BULAN,
                 ROUND(DATA1.VOLUME, 0) AS VOLUME,
                 ROUND(DATA1.HARGAPERTON) AS HARGA,
                 ROUND(DATA1.REVENUE,0) AS REVENUE
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
                ORDER BY
                     VOLUME DESC
            ";

            return $db->query($sql)->result_array();

        }

        public function Get_data_HB_Peringkat($tahun, $bulan){
            $db     = $this->load->database("SCM", true);
            
            $tgl_terakhir   = date('t', strtotime($tahun."-".$bulan."-01")); 
            $tgl_sdk        = date('Ymd');
            $tgl_mulai      = $tahun. $bulan. '01';
            $tgl_selesai    = $tahun. $bulan.  $tgl_terakhir;

            $sql ="
                SELECT
                    REALISASI.KD_DISTRIBUTOR,
					D1.NM_DISTRIBUTOR,
                    REALISASI.TAHUN,
                    REALISASI.BULAN,
                    REALISASI.VOLUME,
                    ROUND(NVL(RKAP.TARGET, 0), 0) AS TARGET,
                    NVL(ROUND(((REALISASI.VOLUME/RKAP.TARGET)*100), 0), 0) AS PERSEN
                    FROM 
                        (
                            SELECT
                                 DATA1.KD_DISTRIBUTOR,
                                 DATA1.TAHUN,
                                 DATA1.BULAN,
                                 ROUND(DATA1.VOLUME, 0) AS VOLUME,
                                 ROUND(DATA1.HARGAPERTON) AS HARGA,
                                 ROUND(DATA1.REVENUE,0) AS REVENUE
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
                                ORDER BY
                                     VOLUME DESC
                        ) REALISASI
                    LEFT JOIN
                        (
									SELECT
										CONCAT('0000000',SD.KUNNR) AS KD_DISTRIBUTOR,
										SD.TAHUN,
										SD.BULAN,
										SUM(SD.QTY) AS QTY,
										SUM(SD.PORSI) AS PORSI,
										SUM(SD.SDK) AS SDK,
										((SUM(SD.SDK)/SUM(SD.PORSI))*SUM(SD.QTY)) AS TARGET
										FROM 
											(
												SELECT
												DATA.*,
												PORSI_BLN.PORSI,
												PORSI_SDK.PORSI AS SDK
												FROM 
													(
														SELECT
															RKAP.VKORG,
															RKAP.KUNNR,
															RKAP.TAHUN,
															RKAP.BULAN,
															SUM(RKAP.QTY) AS QTY
														FROM SAP_T_INDEX_DIST_ADJ_SVM RKAP
														WHERE RKAP.MATNR='121-301'
														AND RKAP.TAHUN='$tahun'
														AND RKAP.BULAN='$bulan'
														GROUP BY 
															RKAP.VKORG,
															RKAP.KUNNR,
															RKAP.TAHUN,
															RKAP.BULAN
													) DATA
												LEFT JOIN 
													(
														SELECT 
															VKORG AS ORG, 
															SUM(PORSI) AS PORSI
														FROM ZREPORT_PORSI_SALES_REGION
														WHERE VKORG IN (3000, 4000, 5000, 7000)
														AND BUDAT BETWEEN '$tgl_mulai' AND '$tgl_selesai'
														GROUP BY VKORG
													) PORSI_BLN ON DATA.VKORG=PORSI_BLN.ORG
												LEFT JOIN 
													(
														SELECT 
															VKORG AS ORG, 
															SUM(PORSI) AS PORSI
														FROM ZREPORT_PORSI_SALES_REGION
														WHERE VKORG IN (3000, 4000, 5000, 7000)
														AND BUDAT BETWEEN '$tgl_mulai' AND '$tgl_sdk'
														GROUP BY VKORG  
													) PORSI_SDK ON DATA.VKORG=PORSI_SDK.ORG
											) SD
										GROUP BY
											SD.KUNNR,
											SD.TAHUN,
											SD.BULAN    
										ORDER BY KUNNR						
									
									
                        ) RKAP ON REALISASI.KD_DISTRIBUTOR=RKAP.KD_DISTRIBUTOR
                            AND REALISASI.TAHUN=RKAP.TAHUN
                                AND REALISASI.BULAN=RKAP.BULAN
					LEFT JOIN 
						(
							SELECT 
								CONCAT('0000000',D.KD_DISTR) AS KD_DISTRIBUTOR,
								D.NM_DISTR AS NM_DISTRIBUTOR
							FROM MASTER_DISTRIBUTOR D
                            
						) D1 ON REALISASI.KD_DISTRIBUTOR=D1.KD_DISTRIBUTOR
					WHERE D1.NM_DISTRIBUTOR IS NOT NULL
                    ORDER BY REALISASI.VOLUME DESC
            ";
			// ECHO $sql;
			// EXIT;
            return $db->query($sql)->result_array();
        }   

        public function Get_data_growth_distributor($distributor, $tahun){
            $db     = $this->load->database("SCM", true);

            $sql ="
                SELECT
                HASIL.LABEL,
                SUM(HASIL.VALUE) AS VALUE
                FROM 
                    (
                                SELECT
                                    DATA1.BULAN AS label,
                                    ROUND(DATA1.VOLUME, 0) AS VALUE
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
                                WHERE DATA1.KD_DISTRIBUTOR='$distributor'
                                AND DATA1.TAHUN='$tahun'
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
                    ) HASIL
                GROUP BY 
                    HASIL.LABEL
                ORDER BY LABEL
            

            ";

             //return $db->query($sql)->result_array();
            $hasil = $db->query($sql)->result_array();
            if(count($hasil)>0){

                $array = array();
                $isi = '{"name":"'.$tahun.'","data":[';
                $no=1;
                foreach ($hasil as $h) {

                    if($no<count($hasil)){
                        $isi .= $h['VALUE'].',';
                    }
                    else {
                        $isi .= $h['VALUE'];
                        $isi .= ']}';
                    }
                    $no=$no+1;
                }
                return $isi;
            }
        } 

        public function Get_data_hj_grouth($tahun, $bulan){
            
            $db     = $this->load->database("marketplace", true);

            $sql ="
                SELECT
                DATA_REALISASI.KD_DISTRIBUTOR,
                DISTRIBUTOR.NM_DISTRIBUTOR,
                DATA_REALISASI.TAHUN,
                DATA_REALISASI.BULAN,
                DATA_REALISASI.QTY_TON,
                DATA_REALISASI.HARGA_TON,
                DATA_REALISASI.REVENUE
                FROM 
                    (
                        SELECT
                        VOLUME.KD_DISTRIBUTOR,
                        VOLUME.TAHUN,
                        VOLUME.BULAN,
                        ROUND(VOLUME.QTY_TON, 0) AS QTY_TON,
                        ROUND(VOLUME.HARGA_TON, 0) AS HARGA_TON,
                        ROUND((VOLUME.QTY_TON*VOLUME.HARGA_TON), 0) AS REVENUE
                        FROM 
                            (
                                SELECT
                                *
                                FROM
                                    (
                                        SELECT
                                            JS.KD_DISTRIBUTOR,
                                            TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
                                            TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
                                            SUM(JS.QTY) AS QTY_ZAK,
                                            (SUM(JS.QTY)/25) AS QTY_TON,
                                            (SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
                                            (SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/25)) HARGA_TON
                                        FROM TPL_T_JUAL_DTL_SERVICE_BULANAN JS
                                        WHERE JS.DELETE_MARK=0
                                        AND JS.KD_PRODUK IN  ('10110003','10110004','121-301-0050','121-301-0050 ','121-301-0110','121-301-0110P','121-301-0180')
                                        GROUP BY 
                                            JS.KD_DISTRIBUTOR,
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
                                            TO_CHAR(JS.TGL_KIRIM, 'YYYY') AS TAHUN,
                                            TO_CHAR(JS.TGL_KIRIM, 'MM') AS BULAN,
                                            SUM(JS.QTY) AS QTY_ZAK,
                                            (SUM(JS.QTY)/20) AS QTY_TON,
                                            (SUM(JS.HARGA*JS.QTY)) AS HARGA_TOTAL,
                                            (SUM(JS.HARGA*JS.QTY)/(SUM(JS.QTY)/20)) HARGA_TON
                                        FROM TPL_T_JUAL_DTL_SERVICE_BULANAN JS
                                        WHERE JS.DELETE_MARK=0
                                        AND JS.KD_PRODUK IN  ('10110001', '10110002', '10110005', '121-301-0020','121-301-0020P', '121-301-0056', '121-301-0056P', '121-301-0056SP', '121-301-0060', '121-301-0060 ')
                                        GROUP BY 
                                            JS.KD_DISTRIBUTOR,
                                            TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
                                            TO_CHAR(JS.TGL_KIRIM, 'MM')
                                        ORDER BY TO_CHAR(JS.TGL_KIRIM, 'YYYY'), TO_CHAR(JS.TGL_KIRIM, 'MM')
                                    ) DATA50
                            ) VOLUME
                    ) DATA_REALISASI
                LEFT JOIN 
                    (
                        SELECT
                            KD_DISTRIBUTOR,
                            NM_DISTRIBUTOR
                        FROM M_DISTRIBUTOR 
                        WHERE SIDIGI_MARK=1
                    ) DISTRIBUTOR ON DATA_REALISASI.KD_DISTRIBUTOR=DISTRIBUTOR.KD_DISTRIBUTOR
                WHERE DATA_REALISASI.TAHUN='$tahun' 
                AND DATA_REALISASI.BULAN='$bulan'
                ORDER BY QTY_TON DESC
            ";

            return $db->query($sql)->result_array();
        }
        
        public function Get_Penjualan_per_gudang_distributor($distrbutor, $tahun, $bulan){
            $db     = $this->load->database("marketplace", true);

            $sql ="
                SELECT
                    DATA_REALISASI.KD_GUDANG,
                    DATA_REALISASI.NM_GUDANG,
                    DATA_REALISASI.TAHUN,
                    DATA_REALISASI.BULAN,
                    DATA_REALISASI.QTY_TON,
                    DATA_REALISASI.HARGA_TON,
                    DATA_REALISASI.REVENUE
                    FROM 
                        (
                            SELECT
                            VOLUME.KD_DISTRIBUTOR,
                            VOLUME.KD_GUDANG,
                            VOLUME.NM_GUDANG,
                            VOLUME.TAHUN,
                            VOLUME.BULAN,
                            ROUND(VOLUME.QTY_TON, 0) AS QTY_TON,
                            ROUND(VOLUME.HARGA_TON, 0) AS HARGA_TON,
                            ROUND((VOLUME.QTY_TON*VOLUME.HARGA_TON), 0) AS REVENUE
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
                                                TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
                                                TO_CHAR(JS.TGL_KIRIM, 'MM')
                                            ORDER BY TO_CHAR(JS.TGL_KIRIM, 'YYYY'), TO_CHAR(JS.TGL_KIRIM, 'MM')
                                        ) DATA50
                                ) VOLUME
                        ) DATA_REALISASI
                    WHERE DATA_REALISASI.KD_DISTRIBUTOR='$distrbutor'
                    AND DATA_REALISASI.TAHUN='$tahun'
                    AND DATA_REALISASI.BULAN='$bulan'
            ";
            // echo $sql;
            return $db->query($sql)->result_array();
        }

        public function Get_grafik_gudang($gudang, $tahun){
            $db     = $this->load->database("marketplace", true);

            $sql ="
                SELECT
                CASE HASIL.LABEL
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
                SUM(VALUE) AS VALUE
                FROM 
                    (
                        SELECT
                            DATA_REALISASI.BULAN AS LABEL,
                            DATA_REALISASI.QTY_TON AS VALUE
                            FROM 
                                (
                                    SELECT
                                    VOLUME.KD_DISTRIBUTOR,
                                    VOLUME.KD_GUDANG,
                                    VOLUME.NM_GUDANG,
                                    VOLUME.TAHUN,
                                    VOLUME.BULAN,
                                    ROUND(VOLUME.QTY_TON, 0) AS QTY_TON,
                                    ROUND(VOLUME.HARGA_TON, 0) AS HARGA_TON,
                                    ROUND((VOLUME.QTY_TON*VOLUME.HARGA_TON), 0) AS REVENUE
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
                                                        TO_CHAR(JS.TGL_KIRIM, 'YYYY'),
                                                        TO_CHAR(JS.TGL_KIRIM, 'MM')
                                                    ORDER BY TO_CHAR(JS.TGL_KIRIM, 'YYYY'), TO_CHAR(JS.TGL_KIRIM, 'MM')
                                                ) DATA50
                                        ) VOLUME
                                ) DATA_REALISASI
                            WHERE DATA_REALISASI.KD_GUDANG='$gudang'
                            AND DATA_REALISASI.TAHUN='$tahun'
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
                    ) HASIL
                GROUP BY 
                    label
                ORDER BY HASIL.LABEL
                    
            ";

            // return $db->query($sql)->result_array();
             $hasil = $db->query($sql)->result_array();
            if(count($hasil)>0){

                $array = array();
                $isi = '{"name":"'.$tahun.'","data":[';
                $no=1;
                foreach ($hasil as $h) {

                    if($no<count($hasil)){
                        $isi .= $h['VALUE'].',';
                    }
                    else {
                        $isi .= $h['VALUE'];
                        $isi .= ']}';
                    }
                    $no=$no+1;
                }
                return $isi;
            }
        }

        public function Get_data_toko_detile($gudang, $tahun, $bulan){
            
            $db     = $this->load->database("marketplace", true);

            $sql ="
                SELECT
                    VOLUME.KD_GUDANG,
                    VOLUME.KD_TOKO,
                    VOLUME.NM_TOKO,
                    VOLUME.TAHUN,
                    VOLUME.BULAN,
                    ROUND(VOLUME.QTY_TON, 0) AS QTY_TON,
                    ROUND(VOLUME.HARGA_TON, 0) AS HARGA_TON,
                    ROUND((VOLUME.QTY_TON*VOLUME.HARGA_TON), 0) AS REVENUE
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
                    WHERE VOLUME.KD_GUDANG='$gudang'
                    AND VOLUME.TAHUN='$tahun'
                    AND VOLUME.BULAN='$bulan'

            ";

            return $db->query($sql)->result_array();
        }

        public function Get_toko_volume_growth($id_toko, $tahun){
            $db     = $this->load->database("marketplace", true);

            $sql ="
                SELECT
                VOLUME3.BULAN,
                SUM(VOLUME3.QTY_TON) AS VALUE
                FROM 
                    (
                        SELECT
                        VOLUME2.*
                        FROM 
                            (
                                SELECT
                                VOLUME.BULAN,
                                SUM(VOLUME.QTY_TON) AS QTY_TON
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
                                WHERE VOLUME.KD_TOKO='$id_toko'
                                AND VOLUME.TAHUN='$tahun'
                                GROUP BY
                                    VOLUME.BULAN
                                ORDER BY BULAN
                            ) VOLUME2
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

                    ) VOLUME3
                GROUP BY 
                    VOLUME3.BULAN
                ORDER BY 
                    VOLUME3.BULAN

            ";

            // return $db->query($sql)->result_array(); 
             $hasil = $db->query($sql)->result_array();
            if(count($hasil)>0){

                $array = array();
                $isi = '{"name":"'.$tahun.'","data":[';
                $no=1;
                foreach ($hasil as $h) {

                    if($no<count($hasil)){
                        $isi .= $h['VALUE'].',';
                    }
                    else {
                        $isi .= $h['VALUE'];
                        $isi .= ']}';
                    }
                    $no=$no+1;
                }
                return $isi;
            }  
        }
        
    }
?>