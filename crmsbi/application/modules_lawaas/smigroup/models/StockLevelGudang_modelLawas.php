<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class StockLevelGudang_model extends CI_Model {

    private $db2;

    function __construct() {
        parent::__construct();
    }
    
    function getRptReal2(){
        $this->load->database();
        date_default_timezone_set("Asia/Jakarta");
        $tgl = date('d-m-Y');
       $data =  $this->db->query("
            SELECT
  KODE_DA,
  JML_TRUK,
  KWANTUM,
  NVL (SISASO, 0) AS SISA_SO,
  KWANTUMX,
  NVL (SISA_TO, 0) AS SISA_TO
FROM
  (
    SELECT
      KODE_DA,
      COUNT (DISTINCT NO_TRANSAKSI) AS JML_TRUK,
      SUM (KWANTUM) AS KWANTUM,
      SUM (KWANTUMX) AS KWANTUMX
    FROM
      ZREPORT_RPT_REAL
    WHERE
      TGL_SPJ = TO_DATE ('$tgl', 'dd-mm-yyyy')
    AND ITEM_NO = '121-301-0110'
    GROUP BY
      KODE_DA
  ) RPT
LEFT JOIN (
  SELECT
    so.SHIP_TO_CODE,
    SUM (SO.SISA_QTY) AS SISASO,
    SUM (SO.SISA_TO) AS SISA_TO
  FROM
    ZREPORT_SO_BUFFER so
  WHERE
    so.NMORG IN ('7000', '5000')
  AND ITEM_NO NOT IN (
    SELECT
      item_no
    FROM
      ZREPORT_EXCLUDE_ITEM
    WHERE
      delete_mark = 0
  ) /*and to_char(SO.TGL_DELIV,'YYYYMMDD')='20160115'*/
  -- and so.SISA_TO >= 25  
  GROUP BY
    SHIP_TO_CODE
) SO ON SO.SHIP_TO_CODE = RPT.KODE_DA
                ");
       return $data->result_array();
    }

    // function getRptReal() {
    //     $this->load->database();
    //     date_default_timezone_set("Asia/Jakarta");
    //     $tgl = date('d-m-Y', strtotime("-8 days"));
    //     $data = $this->db->query("SELECT KODE_DA, JML_TRUK, KWANTUM, NVL(SISASO,0) AS SISA_SO, KWANTUMX,NVL(SISA_TO,0) AS SISA_TO
    //                     FROM
    //                     (SELECT KODE_DA, COUNT(distinct NO_TRANSAKSI) as JML_TRUK, SUM(KWANTUM) AS KWANTUM, SUM(KWANTUMX) AS KWANTUMX
    //                       FROM ZREPORT_RPT_REAL
    //                       WHERE TGL_SPJ >= to_date('$tgl','dd-mm-yyyy')
    //                       AND ITEM_NO = '121-301-0110'
    //                       AND NO_TRANSAKSI IN(SELECT TRX
    //                       FROM
    //                       (SELECT MAX(NO_TRANSAKSI) AS TRX, NO_POLISI
    //                       FROM ZREPORT_RPT_REAL
    //                       WHERE TGL_SPJ >= to_date('$tgl','dd-mm-yyyy')
    //                       GROUP BY NO_POLISI))
    //                       GROUP BY KODE_DA) RPT
    //                   LEFT JOIN 
    //                   (
    //                     SELECT so.SHIP_TO_CODE,sum(SO.SISA_QTY) as SISASO, sum(SO.SISA_TO) as SISA_TO
    //                     FROM   ZREPORT_SO_BUFFER so
    //                     WHERE  so.NMORG IN ('7000','5000') 
    //                     AND ITEM_NO not IN (select item_no from ZREPORT_EXCLUDE_ITEM where delete_mark=0) 
    //                     /*and to_char(SO.TGL_DELIV,'YYYYMMDD')='20160115'*/
    //                    -- and so.SISA_TO >= 25  
    //                     group by SHIP_TO_CODE
    //                   ) SO
    //                   ON SO.SHIP_TO_CODE = RPT.KODE_DA");
    //     return $data->result_array();
    // }
    //////
    function getRptReal() {
        $this->db2 = $this->load->database('marketplace', TRUE);
        date_default_timezone_set("Asia/Jakarta");
        $tgl = date('d-m-Y', strtotime("-8 days"));

        $data = $this->db2->query(" SELECT
            KODE_DA,
            COUNT (DISTINCT NO_TRANSAKSI) AS JML_TRUK,
            SUM (KWANTUM) AS KWANTUM,
            SUM (KWANTUMX) AS KWANTUMX
          FROM
            (
              SELECT
                COUNT (DISTINCT TRANSACTION_NUMBER) OVER () AS JML_TRUK,
                NO_SPJ,
                NO_POL NO_POLISI,
                M_EXPEDITUR.NAMA NAMA_EXPEDITUR,
                TO_DATE (
                  TGL_SPJ || JAM_CMPLT,
                  'YYYYMMDDhh24miss'
                ) AS TGL_BERANGKAT,
                KD_SHIP_TO KODE_DA,
                TRANSACTION_NUMBER NO_TRANSAKSI,
                KWANTUM,
                KWANTUMX,
                DISTRIK KOTA,
                LT.STANDART_AREA LEAD_TIME,
                24 * (
                  SYSDATE - TO_DATE (
                    TGL_SPJ || JAM_CMPLT,
                    'YYYYMMDDhh24miss'
                  )
                ) REALISASI,
                TO_CHAR (
                  TO_DATE (
                    TGL_SPJ || JAM_CMPLT,
                    'YYYYMMDDhh24miss'
                  ) + STANDART_AREA / 24,
                  'yyyy-mm-dd HH24:MI:SS'
                ) AS ETA
              FROM
                T_SPJ
              JOIN (
                SELECT
                  STANDART_AREA,
                  KD_DISTRIK
                FROM
                  M_LEADTIME
              ) LT ON LT.KD_DISTRIK = T_SPJ.DISTRIK
              JOIN M_EXPEDITUR ON M_EXPEDITUR.KODE = T_SPJ.KD_EXPEDITUR
              WHERE
                STATUS NOT IN ('MULAI_BONGKAR','SELESAI_BONGKAR', 'KELUAR') AND
                                  CLOSE_MARK = 0 AND
                                   24*(SYSDATE-TO_DATE(TGL_SPJ  || JAM_CMPLT, 'YYYYMMDDhh24miss')) < LT.STANDART_AREA
              ORDER BY
                TO_DATE (
                  TGL_SPJ || JAM_CMPLT,
                  'YYYYMMDDhh24miss'
                ) DESC
            )
          GROUP BY
            KODE_DA ");


        return $data->result_array();
    }
    
   

    function getSisaSO($kd_da) {
        $this->load->database();
        $data = $this->db->query("SELECT
            so.SHIP_TO_CODE,
            SUM (SO.SISA_QTY) AS SISASO,
            SUM (SO.SISA_TO) AS SISA_TO
              FROM
                ZREPORT_SO_BUFFER so
              WHERE
                so.NMORG IN ('7000', '5000')
                           AND SHIP_TO_CODE = '$kd_da'
              AND ITEM_NO NOT IN (
                SELECT
                  item_no
                FROM
                  ZREPORT_EXCLUDE_ITEM
                WHERE
                  delete_mark = 0
              ) /*and to_char(SO.TGL_DELIV,'YYYYMMDD')='20160115'*/
              -- and so.SISA_TO >= 25  
              GROUP BY
                SHIP_TO_CODE");
        return $data->row_array();
    }

    /////
    function getPeta() {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        $data = $this->db2->query("SELECT crm_gudang.kd_distr, crm_gudang.kd_distrik, nm_distrik, kd_provinsi, crm_gudang.kd_gdg, crm_gudang.org, crm_gudang.area, 
                                    crm_gudang.nm_gdg, stok, STOK_GDG_AVG.AVGSTOK, ((crm_gudang.kapasitas*40)/1000) as kapasitas, NVL(to_char(last_update,'yyyy/mm/dd'),'1970/12/12') as TGL_UPDATE, last_update, 
                                    round((stok/((crm_gudang.kapasitas*40)/1000)), 2)*100 STOK_LEVEL, LATITUDE, LONGITUDE, NM_DISTR
                                    FROM
                                      (SELECT * FROM crm_gudang WHERE DELETE_MARK=0 AND LATITUDE IS NOT NULL AND LONGITUDE IS NOT NULL) CRM_GUDANG
                                    LEFT JOIN
                                      (
                                        select KODE_SHIPTO as KD_GDG, NAMA_SHIPTO as NM_GDG,
                                        QTY_STOK as STOK, LAST_UPDATEOLDF as last_update, '' as kd_material,0 as delete_mark
                                        from CRM_GUDANG_SERVICEM
                                      ) stok_gdg ON (stok_gdg.kd_gdg = crm_gudang.kd_gdg)
                                    LEFT JOIN 
                                      (
                                        SELECT kode_distrik as kd_distrik, distrik as nm_distrik, kode_provinsi as kd_provinsi from PT_MASTER_DISTRIK
                                      ) MASTER_DISTRIK on (CRM_GUDANG.kd_distrik = MASTER_DISTRIK.kd_distrik)
                                      LEFT JOIN
                                      (
                                        select KODE_SHIPTO AS KD_GDG, SUM(QTY_STOK) AS AVGSTOK
                                        from CRM_GUDANG_SERVICE where org='7000' AND TGL_RILIS = (SELECT TO_CHAR(CURRENT_DATE - INTERVAL '7' DAY,'DD-MON-YY') FROM DUAL) 
                                        GROUP BY KODE_SHIPTO
                                      ) STOK_GDG_AVG ON (STOK_GDG_AVG.KD_GDG = CRM_GUDANG.KD_GDG)");
        return $data->result_array();
    }
    function getDataStokElogs($kd_shipto) {
        $this->db2  = $this->load->database('marketplace', TRUE);
        // $data       = $this->db2->query("SELECT KODE_SHIPTO, SUM(QTY_STOK) STOK FROM TPL_CRM_GUDANG_SERVICE  WHERE KODE_SHIPTO = '".$kd_shipto."' GROUP BY KODE_SHIPTO ORDER BY KODE_SHIPTO");
        $data       = $this->db2->query("SELECT
                                          KODE_SHIPTO,
                                          SUM(CASE WHEN (ITEM_NO IN ('10110003','10110004', '121-301-0110P', '121-301-0110', '121-301-0110P')) THEN QTY_STOK/25
                                              ELSE
                                                  QTY_STOK/20
                                          END) STOK
                                        FROM
                                            TPL_CRM_GUDANG_SERVICE
                                        WHERE 
                                            KODE_SHIPTO = '".$kd_shipto."'
                                        GROUP BY
                                            KODE_SHIPTO");
        return $data->result_array();
    }

    function getKdGudang($comp) {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        $this->db2->select('KD_GDG');
        $this->db2->where('DELETE_MARK=0');
        $this->db2->where('LATITUDE IS NOT NULL');
        $this->db2->where('LONGITUDE IS NOT NULL');
        $this->db2->where('ORG', $comp);
        $data = $this->db2->get('CRM_GUDANG');
        return $data->result_array();
    }

    function getAdjGudang() {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        $this->db2->where('TAHUN', date('Y'));
        $this->db2->where('BULAN', date('m'));
        $result = $this->db2->get('SCM_GUDANG_ADJ');
        return $result->result_array();
    }
    
    

    function getStokTransit($kd_gdg) {
        $this->load->database();
        date_default_timezone_set("Asia/Jakarta");
        $tgl = date('d-m-Y', strtotime("-2 days"));
        $data = $this->db->query("SELECT NO_SPJ, NO_POLISI, NAMA_EXPEDITUR, TO_CHAR(TGL_CMPLT,'yyyy-mm-dd - HH24:MI:SS') AS TGL_BERANGKAT, TO_CHAR(TGL_CMPLT,'dd') AS TGL, 
                        KODE_DA, NO_TRANSAKSI, KWANTUM, KWANTUMX, RPT.KOTA, LEAD_TIME,  TO_CHAR(TGL_CMPLT+LEAD_TIME/24,'yyyy-mm-dd - HH24:MI:SS') as ETA
                     FROM ZREPORT_RPT_REAL RPT
                     JOIN
                     (SELECT TRX
                     FROM
                     (SELECT MAX(NO_TRANSAKSI) AS TRX, NO_POLISI
                     FROM ZREPORT_RPT_REAL
                     WHERE TGL_SPJ >= to_date('$tgl','dd-mm-yyyy')
                     GROUP BY NO_POLISI)) TRANSAKSI 
                     ON NO_TRANSAKSI = TRX
                     JOIN (SELECT (SUBSTR(STANDART_AREA,1,2)) as LEAD_TIME, KOTA  from ZAPPSD_TRANS_STD_KPI_AREA 
                     WHERE com in ('2000','7000','5000') AND plant in ('7403') and kota is not null AND tahun='2014' and pros_antri is null
                     AND bulan='7' ORDER BY id DESC) LT
                     ON LT.KOTA = RPT.KOTA
                     AND KODE_DA = '$kd_gdg' AND ITEM_NO = '121-301-0110'
                     ORDER BY TGL_CMPLT DESC");
        return $data->result_array();
    }

    function getSpjAll($kd_gdg) {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        $data = $this->db2->query("select CRM_GR_SPJ_ALL.*, 
                            to_char(TANGGAL_MASUK,'yyyy-mm-dd HH24:MI:SS') as TANGGAL_MASUK,
                            to_char(TANGGAL_MASUK,'DD-MM-YYYY') as TANGGAL_MASUKF,
                            to_char(TANGGAL_MASUK,'HH24:MI:SS') as DATE_MASUKF,
                            to_char(TANGGAL_KELUAR,'yyyy-mm-dd HH24:MI:SS') as TANGGAL_KELUAR
          from crm_gr_spj_all 
          where kd_gdg='$kd_gdg' AND DELET = '0' AND TANGGAL_KELUAR IS NULL");
        return $data->result_array();
    }

    function getProv() {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        $data = $this->db2->query("SELECT KD_PROV2 as KD_PROV, NM_PROV, LATITUDE, LONGITUDE "
                . "FROM ZREPORT_M_PROVINSI WHERE LATITUDE IS NOT NULL AND LONGITUDE IS NOT NULL");
        return $data->result_array();
    }

    function getArea() {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        $data = $this->db2->query("SELECT KD_AREA, DESCH, ID_PROV, LATITUDE, LONGITUDE "
                . "FROM ZREPORT_M_AREA WHERE LATITUDE IS NOT NULL AND LONGITUDE IS NOT NULL");
        return $data->result_array();
    }

    function getLeadTime() {
        $this->load->database();
        date_default_timezone_set("Asia/Jakarta");
        $tgl = date('d-m-Y', strtotime("-4 days"));
        $tgl2 = date('d-m-Y', strtotime("-8 days"));
        $data = $this->db->query("SELECT RPT.KODE_DA, RPT.JML_TRUK, RPT.KWANTUM, NVL(SO.SISASO,0) AS SISA_SO, RPT.KWANTUMX, NVL(SO.SISA_TO,0) AS SISA_TO, SDP.TGL_BERANGKAT, SDP.LEAD_TIME
                        FROM
                        (SELECT KODE_DA, COUNT(distinct NO_TRANSAKSI) as JML_TRUK, SUM(KWANTUM) AS KWANTUM, SUM(KWANTUMX) AS KWANTUMX
                          FROM ZREPORT_RPT_REAL
                          WHERE TGL_SPJ >= to_date('$tgl2','dd-mm-yyyy')
                          AND ITEM_NO = '121-301-0110'
                          AND NO_TRANSAKSI IN(SELECT TRX
                          FROM
                          (SELECT MAX(NO_TRANSAKSI) AS TRX, NO_POLISI
                          FROM ZREPORT_RPT_REAL
                          WHERE TGL_SPJ >= to_date('$tgl2','dd-mm-yyyy')
                          GROUP BY NO_POLISI))
                          GROUP BY KODE_DA) RPT
                      LEFT JOIN 
                      (
                        SELECT so.SHIP_TO_CODE,sum(SO.SISA_QTY) as SISASO, sum(SO.SISA_TO) as SISA_TO
                        FROM   ZREPORT_SO_BUFFER so
                        WHERE  so.NMORG='7000' 
                        AND ITEM_NO not IN (select item_no from ZREPORT_EXCLUDE_ITEM where delete_mark=0) 
                        /*and to_char(SO.TGL_DELIV,'YYYYMMDD')='20160115'*/
                        and so.SISA_TO >= 25  
                        group by SHIP_TO_CODE
                      ) SO
                      ON SO.SHIP_TO_CODE = RPT.KODE_DA
                      LEFT JOIN (
SELECT  KODE_DA, TO_CHAR(TGL_CMPLT,'yyyy-mm-dd HH24:MI:SS') AS TGL_BERANGKAT, LEAD_TIME 
FROM ZREPORT_RPT_REAL RPT
JOIN (
      SELECT TRX
      FROM (
            SELECT MAX(NO_TRANSAKSI) AS TRX, NO_POLISI
            FROM ZREPORT_RPT_REAL
            WHERE TGL_SPJ >= to_date('$tgl','dd-mm-yyyy')
            GROUP BY NO_POLISI
            )
      ) TRANSAKSI 
ON NO_TRANSAKSI = TRX
JOIN (
      SELECT (SUBSTR(STANDART_AREA,1,2)) as LEAD_TIME, KOTA  
      FROM ZAPPSD_TRANS_STD_KPI_AREA 
      WHERE com in ('2000','7000') AND plant in ('7403') and kota is not null AND tahun='2014' and pros_antri is null
      AND bulan='7' ORDER BY id DESC
      ) LT
ON LT.KOTA = RPT.KOTA AND ITEM_NO = '121-301-0110' 
ORDER BY TGL_CMPLT DESC) SDP
ON SDP.KODE_DA = RPT.KODE_DA");
        return $data->result_array();
    }

    function getStokSebelumnya($kode_shipto) {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        $data = $this->db2->query("SELECT KODE_SHIPTO AS KD_GDG, SUM(QTY_STOK) AS AVGSTOK
            FROM (
              CRM_GUDANG_SERVICE
              )
            WHERE ORG = '7000'
              AND TGL_RILIS = (SELECT MAX(TGL_RILIS) FROM (SELECT * FROM CRM_GUDANG_SERVICE WHERE TGL_RILIS <= (SELECT TO_CHAR(CURRENT_DATE - INTERVAL '7' DAY,'DD-MON-YY') FROM DUAL) AND KODE_SHIPTO = '1470155000')) 
              AND KODE_SHIPTO = '$kode_shipto'
            GROUP BY KODE_SHIPTO");
        return $data->result_array();
    }

    function getStok($kode_gudang, $tanggal) {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        //date_default_timezone_set("Asia/Jakarta");
        //$tanggal = date('Ym');
        $data = $this->db2->query("SELECT TB1.*, TB2.NM_GDG, (TB2.KAPASITAS*40/1000) KAPASITAS FROM (SELECT KODE_SHIPTO, TO_CHAR(TGL_RILIS,'DD') TANGGAL, SUM(QTY_STOK) QTY_STOK 
                FROM CRM_GUDANG_SERVICE
                WHERE TO_CHAR(TGL_RILIS,'YYYYMM') = '$tanggal'
                AND KODE_SHIPTO = '$kode_gudang'
                GROUP BY KODE_SHIPTO, TGL_RILIS)TB1
                LEFT JOIN
                CRM_GUDANG TB2
                ON TB1.KODE_SHIPTO = TB2.KD_GDG
                ORDER BY TB1.TANGGAL");
        return $data->result_array();
    }

    function getRilis($kode_gudang, $tanggal) {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        //date_default_timezone_set("Asia/Jakarta");
        //$tanggal = date('Ym');
        $data = $this->db2->query("SELECT TB1.*, TB2.NM_GDG, (TB2.KAPASITAS*40/1000) KAPASITAS FROM (SELECT KODE_SHIPTO, TO_CHAR(TGL_RILIS,'DD') TANGGAL, SUM(QTY_RILIS) QTY_RILIS 
                FROM CRM_GUDANG_SERVICE
                WHERE TO_CHAR(TGL_RILIS,'YYYYMM') = '$tanggal'
                AND KODE_SHIPTO = '$kode_gudang'
                GROUP BY KODE_SHIPTO, TGL_RILIS)TB1
                LEFT JOIN
                CRM_GUDANG TB2
                ON TB1.KODE_SHIPTO = TB2.KD_GDG
                ORDER BY TB1.TANGGAL");
        return $data->result_array();
    }

    function getStokRilis($kode_gudang, $tanggal) {
        $this->db2 = $this->load->database('scmproduction', TRUE);
        //date_default_timezone_set("Asia/Jakarta");
        //$tanggal = date('Ym');
        $data = $this->db2->query("SELECT TB1.*, TB2.NM_GDG, (TB2.KAPASITAS*40/1000) KAPASITAS FROM (SELECT KODE_SHIPTO, TO_CHAR(TGL_RILIS,'DD') TANGGAL, 
            SUM(QTY_STOK) QTY_STOK, SUM(QTY_RILIS) QTY_RILIS 
                FROM CRM_GUDANG_SERVICE
                WHERE TO_CHAR(TGL_RILIS,'YYYYMM') = '$tanggal'
                AND KODE_SHIPTO = '$kode_gudang'
                GROUP BY KODE_SHIPTO, TGL_RILIS)TB1
                LEFT JOIN
                CRM_GUDANG TB2
                ON TB1.KODE_SHIPTO = TB2.KD_GDG
                ORDER BY TB1.TANGGAL");
        return $data->result_array();
    }
    
    function getStokElogsHarian($kode_gudang, $tanggal){
        $this->db2 = $this->load->database('marketplace', TRUE);
        return $this->db2->query("SELECT
                        MAX(KD_GUDANG) KD_SHIPTO,
                        TO_CHAR (TANGGAL_STOK, 'DD') TANGGAL,
                        SUM (JUMLAH_TON) QTY_STOK,
                        MAX(NM_CUSTOMER) NM_GUDANG,
                        MAX(KAPASITAS * 40 / 1000) KAPASITAS
                FROM
                        TPL_T_STOK_HARIAN
                LEFT JOIN M_CUSTOMER ON KD_GUDANG = KD_CUSTOMER
                WHERE
                        KD_GUDANG = '$kode_gudang'
                AND TO_CHAR (TANGGAL_STOK, 'YYYYMM') = '$tanggal'
                GROUP BY
                        TANGGAL_STOK
                ORDER BY
                        TANGGAL_STOK")->result_array();
    }

    function getStokElogsHarianDist($kode_gudang, $tanggal){
        $this->db2 = $this->load->database('marketplace', TRUE);
        return $this->db2->query("SELECT
                                    MAX (KODE_SHIPTO) KD_SHIPTO,
                                    TO_CHAR (TGL_STOK, 'DD') TANGGAL,
                                    SUM (QTY_STOK) QTY_STOK,
                                    MAX (NAMA_SHIPTO) NM_GUDANG,
                                    MAX (KAPASITAS * 40 / 1000) KAPASITAS
                                  FROM
                                    TPL_CRM_GUDANG_SERVICE_HSTR
                                  LEFT JOIN M_CUSTOMER ON KODE_SHIPTO = KD_CUSTOMER
                                  WHERE
                                    KODE_SHIPTO = '$kode_gudang'
                                  AND TO_CHAR (TGL_STOK, 'YYYYMM') = '$tanggal'
                                  GROUP BY
                                    TGL_STOK
                                  ORDER BY
                                    TGL_STOK")->result_array();
    }

    function getdataElogs() {
        $this->db2 = $this->load->database('marketplace', TRUE);
        return $this->db2->query("SELECT
  KD_CUSTOMER,
  NM_CUSTOMER,
  KAPASITAS,
  SUM (STOK) STOK_TON,
  TO_CHAR (
    MAX (CREATE_DATE),
    'dd-mm-yyyy'
  ) CREATE_DATE
FROM
  (
    SELECT
      A.KD_CUSTOMER,
      A.NM_CUSTOMER,
      C.KAPASITAS,
      A .KD_PRODUK,
      A.STOK,
      B.BRT_PRODUK,
      B.\"ALIAS\",
      A.CREATE_DATE
    FROM
      TPL_T_STOK A
    LEFT JOIN TPL_M_PRODUK B ON A .KD_PRODUK = B.KD_PRODUK
    LEFT JOIN M_CUSTOMER C ON C.KD_CUSTOMER = A.KD_CUSTOMER
  )
GROUP BY
  KD_CUSTOMER,
  NM_CUSTOMER,
  KAPASITAS")->result_array();
    }

    //data GPS
    
    function getStokTransit_gps($kd_gdg) {
        $this->load->database();
        //$this->db2 = $this->load->database('marketplace', TRUE);
        date_default_timezone_set("Asia/Jakarta");
        $tgl = date('d-m-Y', strtotime("-7 days"));
        


        $data = $this->db2->query("SELECT
  count( DISTINCT TRANSACTION_NUMBER) over ()  AS JML_TRUK,
        STATUS,
  NO_SPJ,
  NO_POL NO_POLISI,
  M_EXPEDITUR.NAMA NAMA_EXPEDITUR,
  TO_CHAR(TO_DATE(TGL_SPJ  || JAM_CMPLT, 'YYYYMMDDhh24miss'),'DD-MM-YYYY HH24:MI:SS') AS TGL_BERANGKAT,
  KD_SHIP_TO KODE_DA,
  TRANSACTION_NUMBER NO_TRANSAKSI,
  KWANTUM,
  KWANTUMX,
  DISTRIK KOTA,
  LT.STANDART_AREA \"LEAD_TIME\",
  24*(SYSDATE-TO_DATE(TGL_SPJ  || JAM_CMPLT, 'YYYYMMDDhh24miss')) REALISASI,
  TO_CHAR (
    TO_DATE(TGL_SPJ  || JAM_CMPLT, 'YYYYMMDDhh24miss') + STANDART_AREA / 24,
    'yyyy-mm-dd HH24:MI:SS'
  ) AS ETA

FROM
  T_SPJ
JOIN (
  SELECT
    STANDART_AREA,
KD_DISTRIK
  FROM
    M_LEADTIME
 ) LT ON LT.KD_DISTRIK = T_SPJ.DISTRIK
JOIN M_EXPEDITUR ON M_EXPEDITUR.KODE = T_SPJ.KD_EXPEDITUR
WHERE
        STATUS NOT IN ('MULAI_BONGKAR','SELESAI_BONGKAR', 'KELUAR') AND
        24*(SYSDATE-TO_DATE(TGL_SPJ  || JAM_CMPLT, 'YYYYMMDDhh24miss')) < LT.STANDART_AREA AND
  CLOSE_MARK = 0
  AND KD_SHIP_TO = '$kd_gdg'
ORDER BY TO_DATE(TGL_SPJ  || JAM_CMPLT, 'YYYYMMDDhh24miss') DESC
");

        return $data->result_array();
    }
      function getRptReal_gps() {
        $this->db2 = $this->load->database('marketplace', TRUE);
        date_default_timezone_set("Asia/Jakarta");
        $tgl = date('d-m-Y', strtotime("-8 days"));

        $data = $this->db2->query(" SELECT
  KODE_DA,
  COUNT (DISTINCT NO_TRANSAKSI) AS JML_TRUK,
  SUM (KWANTUM) AS KWANTUM,
  SUM (KWANTUMX) AS KWANTUMX
FROM
  (
    SELECT
      COUNT (DISTINCT TRANSACTION_NUMBER) OVER () AS JML_TRUK,
      NO_SPJ,
      NO_POL NO_POLISI,
      M_EXPEDITUR.NAMA NAMA_EXPEDITUR,
      TO_DATE (
        TGL_SPJ || JAM_CMPLT,
        'YYYYMMDDhh24miss'
      ) AS TGL_BERANGKAT,
      KD_SHIP_TO KODE_DA,
      TRANSACTION_NUMBER NO_TRANSAKSI,
      KWANTUM,
      KWANTUMX,
      DISTRIK KOTA,
      LT.STANDART_AREA LEAD_TIME,
      24 * (
        SYSDATE - TO_DATE (
          TGL_SPJ || JAM_CMPLT,
          'YYYYMMDDhh24miss'
        )
      ) REALISASI,
      TO_CHAR (
        TO_DATE (
          TGL_SPJ || JAM_CMPLT,
          'YYYYMMDDhh24miss'
        ) + STANDART_AREA / 24,
        'yyyy-mm-dd HH24:MI:SS'
      ) AS ETA
    FROM
      T_SPJ
    JOIN (
      SELECT
        STANDART_AREA,
        KD_DISTRIK
      FROM
        M_LEADTIME
    ) LT ON LT.KD_DISTRIK = T_SPJ.DISTRIK
    JOIN M_EXPEDITUR ON M_EXPEDITUR.KODE = T_SPJ.KD_EXPEDITUR
    WHERE
      STATUS NOT IN ('MULAI_BONGKAR','SELESAI_BONGKAR', 'KELUAR') AND
                        CLOSE_MARK = 0 AND
                         24*(SYSDATE-TO_DATE(TGL_SPJ  || JAM_CMPLT, 'YYYYMMDDhh24miss')) < LT.STANDART_AREA
    ORDER BY
      TO_DATE (
        TGL_SPJ || JAM_CMPLT,
        'YYYYMMDDhh24miss'
      ) DESC
  )
GROUP BY
  KODE_DA ");


        return $data->result_array();
    }
}
