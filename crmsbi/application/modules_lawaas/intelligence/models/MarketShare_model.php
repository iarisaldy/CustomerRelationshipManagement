<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class MarketShare_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function datasmig($tahun, $bulan) {
        $whereBulan = "";
        if ($bulan != 00) {
            $whereBulan = "BULAN = '$bulan' AND";
        }
        $data = $this->db->query("SELECT TBL1.PROPINSI, TBL4.NM_PROV, (((TBL1.REALISASI/TBL2.REALISASI)*100)/TBL3.REAL)*100 QTY, (TBL1.REALISASI/TBL2.REALISASI)*100 MS, TBL3.REAL RKAP /*NVL(TBL5.MS,0) MS, NVL(TBL6.TARGET_RKAP,0) TARGET_RKAP, NVL(TBL7.QTY_REAL,0)QTY_REAL */
            FROM  (
                SELECT a.PROPINSI, SUM(a.QTY_REAL) REALISASI 
                FROM ZREPORT_MS_TRANS1 a 
                LEFT JOIN 
                  ZREPORT_MS_PERUSAHAAN b 
                ON a.KODE_PERUSAHAAN = b.KODE_PERUSAHAAN
                WHERE " . $whereBulan . " TAHUN = '$tahun' AND b.KELOMPOK = 'SMI'
                GROUP BY a.PROPINSI
              ) TBL1
              LEFT JOIN 
              (
                SELECT PROPINSI, SUM(QTY_REAL) REALISASI FROM ZREPORT_MS_TRANS1 
                WHERE " . $whereBulan . " TAHUN = '$tahun'
                GROUP BY PROPINSI
              )TBL2
              ON (TBL1.PROPINSI = TBL2.PROPINSI)
              LEFT JOIN 
              (
                SELECT PROPINSI, SUM(QTY) REAL FROM ZREPORT_MS_RKAPMS
                WHERE THN = '$tahun' AND STATUS = '0'
                GROUP BY PROPINSI
              )TBL3
              ON(TBL1.PROPINSI = TBL3.PROPINSI)
              LEFT JOIN ZREPORT_M_PROVINSI TBL4
              ON (TBL1.PROPINSI = TBL4.KD_PROV)
              /* -- TIDAK DIPAKAI --
              LEFT JOIN
                (
                  SELECT PROPINSI, ((SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'))*100) MS
                  FROM ZREPORT_MS_TRANS1
                  WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'
                  GROUP BY PROPINSI
                ) TBL5
                ON TBL1.PROPINSI = TBL5.PROPINSI
                LEFT JOIN
                (
                  SELECT PROPINSI, ((SUM(QTY)/(SELECT SUM(QTY) FROM ZREPORT_MS_RKAPMS WHERE THN = '$tahun' AND STATUS = '0'))*100) TARGET_RKAP                  
                  FROM ZREPORT_MS_RKAPMS
                  WHERE THN = '$tahun' AND STATUS = '0'
                  GROUP BY PROPINSI
                ) TBL6
                ON TBL1.PROPINSI = TBL6.PROPINSI
                LEFT JOIN (
                  SELECT TBL1.PROPINSI, (TBL1.REAL/TBL2.REAL_PROV)*100 QTY_REAL 
                    FROM (SELECT a.PROPINSI, SUM(a.QTY_REAL) REAL 
                          FROM ZREPORT_MS_TRANS1 a
                          WHERE a.BULAN = '$bulan' AND a.TAHUN = '$tahun' AND a.STATUS = '0' AND KODE_PERUSAHAAN IN('110','111','102')
                          GROUP BY a.PROPINSI) TBL1                                                    
                          LEFT JOIN (
                            SELECT PROPINSI, SUM(QTY_REAL) REAL_PROV 
                            FROM ZREPORT_MS_TRANS1 
                            WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'
                            GROUP BY PROPINSI
                          ) TBL2
                          ON TBL1.PROPINSI = TBL2.PROPINSI
                ) TBL7
                ON TBL1.PROPINSI = TBL7.PROPINSI*/");
        return $data->result_array();
    }

    function datas($org, $tahun, $bulan) {
        $whereBulan = "";
        if ($bulan != 00) {
            $whereBulan = "BULAN = '$bulan' AND";
        }
        $data = $this->db->query("SELECT TBL1.PROPINSI, TBL4.NM_PROV, (((TBL1.REALISASI/TBL2.REALISASI)*100)/TBL3.REALISASI)*100 QTY, (TBL1.REALISASI/TBL2.REALISASI)*100 MS, TBL3.REALISASI RKAP /*NVL(TBL5.MS,0) MS, NVL(TBL6.TARGET_RKAP,0) TARGET_RKAP, NVL(TBL7.QTY_REAL,0)QTY_REAL */
            FROM
                (
                  SELECT PROPINSI, SUM(QTY_REAL) REALISASI 
                  FROM ZREPORT_MS_TRANS1 
                  WHERE " . $whereBulan . " TAHUN = '$tahun' AND KODE_PERUSAHAAN = '$org'
                  GROUP BY PROPINSI
                ) TBL1
                LEFT JOIN 
                (
                  SELECT PROPINSI, SUM(QTY_REAL) REALISASI FROM ZREPORT_MS_TRANS1 
                  WHERE " . $whereBulan . " TAHUN = '$tahun' 
                  GROUP BY PROPINSI
                )TBL2
                ON (TBL1.PROPINSI = TBL2.PROPINSI)
                LEFT JOIN 
                (
                  SELECT PROPINSI, SUM(QTY) REALISASI FROM ZREPORT_MS_RKAPMS
                  WHERE THN = '$tahun' AND STATUS = '0' AND KODE_PERUSAHAAN = '$org'
                  GROUP BY PROPINSI
                )TBL3
                ON(TBL1.PROPINSI = TBL3.PROPINSI)
                LEFT JOIN ZREPORT_M_PROVINSI TBL4
                ON (TBL1.PROPINSI = TBL4.KD_PROV)
                /* -- TIDAK DIPAKAI --
                LEFT JOIN
                (
                  SELECT PROPINSI, ((SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'))*100) MS
                  FROM ZREPORT_MS_TRANS1
                  WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'
                  GROUP BY PROPINSI
                ) TBL5
                ON TBL1.PROPINSI = TBL5.PROPINSI
                LEFT JOIN
                (
                  SELECT PROPINSI, ((SUM(QTY)/(SELECT SUM(QTY) FROM ZREPORT_MS_RKAPMS WHERE THN = '$tahun' AND STATUS = '0'))*100) TARGET_RKAP                  
                  FROM ZREPORT_MS_RKAPMS
                  WHERE THN = '$tahun' AND STATUS = '0'
                  GROUP BY PROPINSI
                ) TBL6
                ON TBL1.PROPINSI = TBL6.PROPINSI 
                LEFT JOIN (
                  SELECT TBL1.PROPINSI, (TBL1.REAL/TBL2.REAL_PROV)*100 QTY_REAL 
                    FROM (SELECT a.PROPINSI, SUM(a.QTY_REAL) REAL 
                          FROM ZREPORT_MS_TRANS1 a
                          WHERE a.BULAN = '$bulan' AND a.TAHUN = '$tahun' AND a.STATUS = '0' AND KODE_PERUSAHAAN IN('110','111','102')
                          GROUP BY a.PROPINSI) TBL1                                                    
                          LEFT JOIN (
                            SELECT PROPINSI, SUM(QTY_REAL) REAL_PROV 
                            FROM ZREPORT_MS_TRANS1 
                            WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'
                            GROUP BY PROPINSI
                          ) TBL2
                          ON TBL1.PROPINSI = TBL2.PROPINSI
                ) TBL7
                ON TBL1.PROPINSI = TBL7.PROPINSI*/");
        return $data->result_array();
    }

    function getDetail($provinsi, $tahun, $bulan) {
        $tahunkemarin = $tahun - 1;
        $bulankemarin = $bulan - 1;
        $tahunbanding = $tahun;
        if($bulankemarin==0){
            $bulankemarin = 12;
            $tahunbanding = $tahun-1;
        }
        if (strlen($bulankemarin) == 1) {
            $bulankemarin = '0' . $bulankemarin;
        }
        $data['body'] = $this->db->query("SELECT TBL1.*, TBL2.NAMA_PERUSAHAAN, NVL(BAG.QTY_BAG,0) QTY_BAG, NVL(TBULK.QTY_BULK,0) QTY_BULK, NVL(TBL4.REAL_BULAN,0) REAL_BULAN, NVL(TBL4.QTY_BULAN,0) QTY_BULAN, NVL(TBL5.REAL_TAHUN,0) REAL_TAHUN, NVL(TBL5.QTY_TAHUN,0) QTY_TAHUN, 
            NVL(TBL6.REAL_TAHUN_KUM,0) REAL_TAHUN_KUM, NVL(TBL6.QTY_TAHUN_KUM,0) QTY_TAHUN_KUM, NVL(TBL7.REAL_TAHUNINI_KUM,0) REAL_TAHUNINI_KUM, NVL(TBL7.QTY_TAHUNINI_KUM,0) QTY_TAHUNINI_KUM, TBL8.NM_PROV, NVL(TBL9.TARGET_RKAP,0) TARGET_RKAP  
                    FROM (
                          SELECT a.KODE_PERUSAHAAN, a.PROPINSI, SUM(a.QTY_REAL) QTY, ((SUM(a.QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE PROPINSI = '$provinsi' AND BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'))*100) QTY_REAL 
                          FROM ZREPORT_MS_TRANS1 a
                          WHERE a.PROPINSI = '$provinsi' AND a.BULAN = '$bulan' AND a.TAHUN = '$tahun' AND a.STATUS = '0' 
                          GROUP BY a.KODE_PERUSAHAAN, a.PROPINSI
                          ) TBL1
                    LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2
                    ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                    LEFT JOIN (
                              SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY_BAG 
                              FROM ZREPORT_MS_TRANS1
                              WHERE TIPE = '121-301' AND PROPINSI = '$provinsi' AND BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0' 
                              GROUP BY KODE_PERUSAHAAN
                              ) BAG
                    ON TBL1.KODE_PERUSAHAAN = BAG.KODE_PERUSAHAAN
                    LEFT JOIN (
                              SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY_BULK 
                              FROM ZREPORT_MS_TRANS1
                              WHERE TIPE = '121-302' AND PROPINSI = '$provinsi' AND BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0' 
                              GROUP BY KODE_PERUSAHAAN
                              ) TBULK
                    ON TBL1.KODE_PERUSAHAAN = TBULK.KODE_PERUSAHAAN
                    LEFT JOIN (
                          SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) REAL_BULAN, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE STATUS = '0' AND BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' AND PROPINSI = '$provinsi'))*100 QTY_BULAN
                          FROM ZREPORT_MS_TRANS1 
                          WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' AND PROPINSI = '$provinsi'
                          GROUP BY KODE_PERUSAHAAN
                          ) TBL4
                    ON TBL1.KODE_PERUSAHAAN = TBL4.KODE_PERUSAHAAN
                    LEFT JOIN (
                          SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) REAL_TAHUN, ((SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE STATUS = '0' AND BULAN = '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi'))*100) QTY_TAHUN
                          FROM ZREPORT_MS_TRANS1 
                          WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi'
                          GROUP BY KODE_PERUSAHAAN
                          ) TBL5
                    ON TBL1.KODE_PERUSAHAAN = TBL5.KODE_PERUSAHAAN
                    LEFT JOIN (
                          SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) REAL_TAHUN_KUM, ((SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE STATUS = '0' AND BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi'))*100) QTY_TAHUN_KUM
                          FROM ZREPORT_MS_TRANS1 
                          WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi'
                          GROUP BY KODE_PERUSAHAAN
                          ) TBL6
                    ON TBL1.KODE_PERUSAHAAN = TBL6.KODE_PERUSAHAAN
                    LEFT JOIN (
                          SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) REAL_TAHUNINI_KUM, ((SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE STATUS = '0' AND BULAN <= '$bulan' AND TAHUN = '$tahun' AND PROPINSI = '$provinsi'))*100) QTY_TAHUNINI_KUM
                          FROM ZREPORT_MS_TRANS1 
                          WHERE BULAN <= '$bulan' AND TAHUN = '$tahun' AND PROPINSI = '$provinsi'
                          GROUP BY KODE_PERUSAHAAN
                          ) TBL7
                    ON TBL1.KODE_PERUSAHAAN = TBL7.KODE_PERUSAHAAN
                    LEFT JOIN ZREPORT_M_PROVINSI TBL8
                    ON TBL1.PROPINSI = TBL8.KD_PROV
                    LEFT JOIN 
                    (
                      SELECT PROPINSI, KODE_PERUSAHAAN, SUM(QTY) TARGET_RKAP FROM ZREPORT_MS_RKAPMS
                      WHERE THN = '$tahun' AND STATUS = '0'
                      GROUP BY PROPINSI, KODE_PERUSAHAAN
                    )TBL9
                    ON TBL1.PROPINSI = TBL9.PROPINSI AND TBL1.KODE_PERUSAHAAN = TBL9.KODE_PERUSAHAAN
                    ORDER BY TBL1.QTY_REAL DESC");
        
        $data['footer'] = $this->db->query("SELECT TBL1.PROPINSI, NVL(TBL1.QTY,0) QTY, NVL(TBL1.QTY_REAL,0) QTY_REAL, NVL(TBL2.REAL_BULAN,0) REAL_BULAN, NVL(TBL2.QTY_BULAN,0) QTY_BULAN, NVL(TBL3.REAL_TAHUN,0) REAL_TAHUN, NVL(TBL3.QTY_TAHUN,0) QTY_TAHUN, NVL(TBL4.REAL_TAHUNINI_KUM,0) REAL_TAHUNINI_KUM, NVL(TBL5.REAL_TAHUN_KUM,0) REAL_TAHUN_KUM    
                    FROM (SELECT PROPINSI, SUM(QTY_REAL) QTY, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'))*100 QTY_REAL 
                    FROM ZREPORT_MS_TRANS1 
                    WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND PROPINSI = '$provinsi' AND STATUS = '0' 
                    GROUP BY PROPINSI) TBL1
                    LEFT JOIN (
                              SELECT PROPINSI, SUM(QTY_REAL) REAL_BULAN, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' AND STATUS = '0'))*100 QTY_BULAN 
                              FROM ZREPORT_MS_TRANS1 
                              WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' AND PROPINSI = '$provinsi' AND STATUS = '0'
                              GROUP BY PROPINSI
                    ) TBL2
                    ON TBL1.PROPINSI = TBL2.PROPINSI
                    LEFT JOIN (
                              SELECT PROPINSI, SUM(QTY_REAL) REAL_TAHUN, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin' AND STATUS = '0'))*100 QTY_TAHUN 
                              FROM ZREPORT_MS_TRANS1 
                              WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi' AND STATUS = '0'
                              GROUP BY PROPINSI
                    ) TBL3
                    ON TBL1.PROPINSI = TBL3.PROPINSI
                    LEFT JOIN (
                              SELECT PROPINSI, SUM(QTY_REAL) REAL_TAHUNINI_KUM, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN <= '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'))*100 QTY_TAHUN 
                              FROM ZREPORT_MS_TRANS1 
                              WHERE BULAN <= '$bulan' AND TAHUN = '$tahun' AND PROPINSI = '$provinsi' AND STATUS = '0'
                              GROUP BY PROPINSI
                    ) TBL4
                    ON TBL1.PROPINSI = TBL4.PROPINSI
                    LEFT JOIN (
                              SELECT PROPINSI, SUM(QTY_REAL) REAL_TAHUN_KUM, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' AND STATUS = '0'))*100 QTY_TAHUN 
                              FROM ZREPORT_MS_TRANS1 
                              WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi' AND STATUS = '0'
                              GROUP BY PROPINSI
                    ) TBL5
                    ON TBL1.PROPINSI = TBL5.PROPINSI");

        return $data;
    }

    function getDetail2($provinsi, $tahun, $bulan) {
        $data = $this->db->query("SELECT a.KODE_PERUSAHAAN, b.NAMA_PERUSAHAAN, SUM(QTY_REAL) QTY_REAL, (sum(a.QTY_REAL)/TBL1.REALISASI)*100 QTY, NVL(BAG.QTY_BAG,0) BAG, NVL(TBULK.QTY_BULK,0) BULK, TBL2.NM_PROV 
                FROM ZREPORT_MS_TRANS1 a 
                LEFT JOIN ZREPORT_MS_PERUSAHAAN b
                ON a.KODE_PERUSAHAAN = b.KODE_PERUSAHAAN
                LEFT JOIN
                  (
                  SELECT PROPINSI, SUM(QTY_REAL) REALISASI FROM ZREPORT_MS_TRANS1
                  WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0' 
                  GROUP BY PROPINSI
                  )TBL1
                ON a.PROPINSI = TBL1.PROPINSI
                LEFT JOIN
                  (
                  SELECT KD_PROV, NM_PROV FROM ZREPORT_M_PROVINSI
                  )TBL2
                ON a.PROPINSI = TBL2.KD_PROV
                LEFT JOIN
                  (
                  SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY_BAG 
                  FROM ZREPORT_MS_TRANS1
                  WHERE TIPE = '121-301' AND PROPINSI = '$provinsi'
                  GROUP BY KODE_PERUSAHAAN
                  ) BAG
                ON a.KODE_PERUSAHAAN = BAG.KODE_PERUSAHAAN
                LEFT JOIN
                  (
                  SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY_BULK 
                  FROM ZREPORT_MS_TRANS1
                  WHERE TIPE = '121-302' AND PROPINSI = '$provinsi'
                  GROUP BY KODE_PERUSAHAAN
                  ) TBULK
                ON a.KODE_PERUSAHAAN = TBULK.KODE_PERUSAHAAN
                WHERE a.PROPINSI = '$provinsi'
                GROUP BY a.KODE_PERUSAHAAN, b.NAMA_PERUSAHAAN, TBL1.REALISASI, TBL2.NM_PROV, BAG.QTY_BAG, TBULK.QTY_BULK");
        return $data->result_array();
    }

    function updateDate() {
        $data = $this->db->query("SELECT NVL(TO_CHAR(MAX(CREATE_DATE),'dd-mm-YYYY'),'01-01-1997') TGL_UPDATE FROM ZREPORT_MS_TRANS1");
        return $data->result_array();
    }

    function getSummary($tahun, $bulan) {
        $tahunkemarin = $tahun - 1;
        $bulankemarin = $bulan - 1;
        $tahunbanding = $tahun;
        if($bulankemarin==0){
            $bulankemarin = 12;
            $tahunbanding = $tahun-1;
        }
        if (strlen($bulankemarin) == 1) {
            $bulankemarin = '0' . $bulankemarin;
        }
        $data['body'] = $this->db->query("SELECT TBL3.KODE_PERUSAHAAN, TBL3.NAMA_PERUSAHAAN, TBL3.PRODUK, TBL3.INISIAL, TBL3.QTY, nvl(TBL3.REAL_BLN,0) QTY_REAL, nvl(TBL4.QTY,0) REAL_BULAN, 
nvl(TBL4.REAL_BLN_K,0) QTY_BULAN, nvl(TBL5.QTY,0) REAL_TAHUN, nvl(TBL5.REAL_THN_K,0) QTY_TAHUN, nvl(TBL6.QTY,0) REAL_TAHUNINI_KUM, nvl(TBL6.REAL_THN_K,0) QTY_TAHUNINI_KUM, nvl(TBL7.QTY,0) REAL_TAHUN_KUM, NVL(TBL8.RKAP,0) RKAP 
          FROM (SELECT * FROM (SELECT TBL1.KODE_PERUSAHAAN, TBL1.QTY QTY, TBL2.NAMA_PERUSAHAAN, TBL2.PRODUK, TBL2.INISIAL,
                ((TBL1.QTY/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulan' AND TAHUN = '$tahun'))*100) REAL_BLN
                FROM (SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY 
                      FROM ZREPORT_MS_TRANS1 
                      WHERE BULAN = '$bulan' AND TAHUN = '$tahun' 
                      GROUP BY KODE_PERUSAHAAN 
                      ORDER BY QTY DESC) TBL1
                JOIN ZREPORT_MS_PERUSAHAAN TBL2
                ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                ORDER BY TBL1.QTY DESC)
                ) TBL3
                JOIN 
                (SELECT TBL1.KODE_PERUSAHAAN, TBL1.QTY,
                ((TBL1.QTY/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding'))*100) REAL_BLN_K
                FROM (SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY 
                      FROM ZREPORT_MS_TRANS1 
                      WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' 
                      GROUP BY KODE_PERUSAHAAN 
                      ORDER BY QTY DESC) TBL1
                JOIN ZREPORT_MS_PERUSAHAAN TBL2
                ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                ORDER BY TBL1.QTY DESC) TBL4
                ON TBL3.KODE_PERUSAHAAN = TBL4.KODE_PERUSAHAAN
                LEFT JOIN 
                (SELECT TBL1.KODE_PERUSAHAAN, TBL1.QTY,
                ((TBL1.QTY/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin'))*100) REAL_THN_K
                FROM (SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY 
                      FROM ZREPORT_MS_TRANS1 
                      WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin' 
                      GROUP BY KODE_PERUSAHAAN 
                      ORDER BY QTY DESC) TBL1
                LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2
                ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                ORDER BY TBL1.QTY DESC) TBL5
                ON TBL3.KODE_PERUSAHAAN = TBL5.KODE_PERUSAHAAN
                LEFT JOIN 
                (SELECT TBL1.KODE_PERUSAHAAN, TBL1.QTY,
                ((TBL1.QTY/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN <= '$bulan' AND TAHUN = '$tahun'))*100) REAL_THN_K
                FROM (SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY 
                      FROM ZREPORT_MS_TRANS1 
                      WHERE BULAN <= '$bulan' AND TAHUN = '$tahun' 
                      GROUP BY KODE_PERUSAHAAN 
                      ORDER BY QTY DESC) TBL1
                LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2
                ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                ORDER BY TBL1.QTY DESC) TBL6
                ON TBL3.KODE_PERUSAHAAN = TBL6.KODE_PERUSAHAAN
                LEFT JOIN 
                (SELECT TBL1.KODE_PERUSAHAAN, TBL1.QTY,
                ((TBL1.QTY/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin'))*100) REAL_THN_K
                FROM (SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY 
                      FROM ZREPORT_MS_TRANS1 
                      WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' 
                      GROUP BY KODE_PERUSAHAAN 
                      ORDER BY QTY DESC) TBL1
                LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2
                ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                ORDER BY TBL1.QTY DESC) TBL7
                ON TBL3.KODE_PERUSAHAAN = TBL7.KODE_PERUSAHAAN
                LEFT JOIN 
                  (SELECT KODE_PERUSAHAAN, (SUM(QTY)/COUNT(PROPINSI)) RKAP 
                    FROM ZREPORT_MS_RKAPMS
                    WHERE THN = '$tahun' AND STATUS = '0'
                    GROUP BY KODE_PERUSAHAAN) TBL8
                ON TBL3.KODE_PERUSAHAAN = TBL8.KODE_PERUSAHAAN
                ORDER BY TBL3.QTY DESC");
        //echo $this->db->last_query();
        $data['footer'] = $this->db->query("SELECT NVL(TBL1.QTY_REAL,0) REAL_BLN, NVL((SELECT SUM(QTY_REAL) QTY_REAL FROM ZREPORT_MS_TRANS1 
                    WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' AND STATUS = '0'),0) REAL_BLN_K, NVL(TBL3.QTY_REAL,0) REAL_THN_K, 
                  NVL(( SELECT  SUM(QTY_REAL) QTY_REAL 
                    FROM ZREPORT_MS_TRANS1 
                    WHERE BULAN <= '$bulan' AND TAHUN = '$tahun' AND STATUS = '0' ),0) REAL_THNINI_KUM,
                  NVL(( SELECT  SUM(QTY_REAL) QTY_REAL 
                    FROM ZREPORT_MS_TRANS1 
                    WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' AND STATUS = '0' ),0) REAL_THN_KUM  
          FROM (SELECT BULAN, TAHUN, SUM(QTY_REAL) QTY_REAL 
                FROM ZREPORT_MS_TRANS1
                WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'
                GROUP BY BULAN, TAHUN) TBL1
                LEFT JOIN
                  (
                    SELECT BULAN, SUM(QTY_REAL) QTY_REAL 
                    FROM ZREPORT_MS_TRANS1 
                    WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin' AND STATUS = '0' 
                    GROUP BY BULAN
                  ) TBL3
                ON TBL1.BULAN = TBL3.BULAN");
        return $data;
    }
    
    public function marketVolume($awal,$akhir,$tipe = NULL){
        $filter_tipe = !empty($tipe) ? " and tipe IN ('".$tipe."')" : "";  
        $sql = "
            select * from (
            SELECT KODE_PERUSAHAAN
		,NAMA_PERUSAHAAN
		,sum(QTY_REAL)  QTY  
		,to_char(to_date(bulan||'-'||tahun,'MM-YYYY'),'MM/YY') bulan
                FROM ZREPORT_MS_TRANS1
                WHERE tahun IS NOT NULL AND bulan IS NOT null
                $filter_tipe
                AND  tahun||''||bulan BETWEEN '$awal' AND '$akhir' 
                GROUP BY KODE_PERUSAHAAN,NAMA_PERUSAHAAN
                ,to_char(to_date(bulan||'-'||tahun,'MM-YYYY'),'MM/YY')
            )y ORDER BY to_date(y.bulan,'MM-YYYY')              
            ";
        
        return $this->db->query($sql)->result_array();
    }
    
    public function dataHistory($awal,$akhir){
        $sql = "SELECT zmt.KODE_PERUSAHAAN
                        ,zmt.NAMA_PERUSAHAAN
                        ,zmt.PROPINSI
                        ,zmp.NM_PROV
                        ,zmt.tahun||''||zmt.bulan TAHUNBULAN
                        ,zmt.QTY_REAL
                        ,zmt.TIPE
                FROM ZREPORT_MS_TRANS1 zmt
                INNER JOIN ZREPORT_M_PROVINSI zmp
                        ON zmp.kd_prov = zmt.propinsi
                WHERE zmt.tahun||''||zmt.bulan BETWEEN '$awal' AND '$akhir' 	
                order by to_number(zmt.KODE_PERUSAHAAN),zmt.tahun||''||zmt.bulan

        ";
        return $this->db->query($sql)->result_array();
    }

    function getRkap($tahun){
        $this->db->where("TAHUN",$tahun);
        $data = $this->db->get("ZREPORT_MS_RKAP");
        
        return $data->result_array();
    }

}
