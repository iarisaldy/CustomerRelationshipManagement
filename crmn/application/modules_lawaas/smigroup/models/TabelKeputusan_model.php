<?php if(!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class TabelKeputusan_model extends CI_Model {
    private $db2;
    private $db3;
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db2 = $this->load->database('scmproduction',TRUE);
        $this->db3 = $this->load->database('marketplace',TRUE);
    }
    
    function getGudang(){
        $data = $this->db2->query("SELECT * FROM crm_gudang WHERE DELETE_MARK=0 AND LATITUDE IS NOT NULL AND LONGITUDE IS NOT NULL");
        return $data->result_array();
    }
    
    // function getRptReal(){        
    //     date_default_timezone_set("Asia/Jakarta");
    //     $tgl = date('d-m-Y',strtotime("-8 days"));
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
    //                     WHERE  so.NMORG='7000' 
    //                     AND ITEM_NO not IN (select item_no from ZREPORT_EXCLUDE_ITEM where delete_mark=0) 
    //                     /*and to_char(SO.TGL_DELIV,'YYYYMMDD')='20160115'*/
    //                     and so.SISA_TO >= 25  
    //                     group by SHIP_TO_CODE
    //                   ) SO
    //                   ON SO.SHIP_TO_CODE = RPT.KODE_DA");
    //     return $data->result_array();
    // }

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

    function getPeta(){
      $this->db2 = $this->load->database('scmproduction', TRUE);
        $data = $this->db2->query("SELECT crm_gudang.kd_distr, crm_gudang.kd_distrik, nm_distrik, kd_provinsi, crm_gudang.kd_gdg,  crm_gudang.org, crm_gudang.area, 
                                    crm_gudang.nm_gdg, nvl(crm_gudang.unloading_rate_ton,0) load_truk, stok, STOK_GDG_AVG.AVGSTOK, ((crm_gudang.kapasitas*40)/1000) as kapasitas, NVL(to_char(last_update,'yyyy/mm/dd'),'1970/12/12') as TGL_UPDATE, last_update, 
                                    round((stok/((crm_gudang.kapasitas*40)/1000)), 2)*100 STOK_LEVEL, LATITUDE, LONGITUDE, NM_DISTR, NVL(RILIS_GDG_AVG.QTY_RILIS,0) QTY_RILIS
                                    FROM
                                      (SELECT * FROM crm_gudang WHERE DELETE_MARK=0 AND LATITUDE IS NOT NULL AND LONGITUDE IS NOT NULL) CRM_GUDANG
                                    LEFT JOIN
                                      (
                                        select distinct KODE_SHIPTO as KD_GDG, NAMA_SHIPTO as NM_GDG,
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
                                      ) STOK_GDG_AVG ON (STOK_GDG_AVG.KD_GDG = CRM_GUDANG.KD_GDG)
                                        LEFT JOIN
                                        (
                                        SELECT KODE_SHIPTO, SUM(QTY_RILIS) QTY_RILIS 
                                            FROM CRM_GUDANG_SERVICE
                                            WHERE TO_CHAR(TGL_RILIS,'YYYYMMDD') <= (SELECT TO_CHAR(CURRENT_DATE,'YYYYMMDD') FROM DUAL)
                                            AND TO_CHAR(TGL_RILIS,'YYYYMMDD') >= (SELECT TO_CHAR(CURRENT_DATE - INTERVAL '7' DAY,'YYYYMMDD') FROM DUAL)
                                            GROUP BY KODE_SHIPTO
                                        ) RILIS_GDG_AVG
                                        ON RILIS_GDG_AVG.KODE_SHIPTO = CRM_GUDANG.KD_GDG");
        return $data->result_array();
    }
    
    function getRilis($kode){
        $data = $this->db2->query("SELECT sum(QTY_RILIS) QTY_RILIS FROM (SELECT KODE_SHIPTO, TO_CHAR(TGL_RILIS,'DD') TANGGAL, SUM(QTY_RILIS) QTY_RILIS 
                FROM CRM_GUDANG_SERVICE
                WHERE TO_CHAR(TGL_RILIS,'YYYYMMDD') <= (SELECT TO_CHAR(CURRENT_DATE,'YYYYMMDD') FROM DUAL)
		AND TO_CHAR(TGL_RILIS,'YYYYMMDD') >= (SELECT TO_CHAR(CURRENT_DATE - INTERVAL '7' DAY,'YYYYMMDD') FROM DUAL)
                AND KODE_SHIPTO = '$kode'
                GROUP BY KODE_SHIPTO, TGL_RILIS)TB1
                ORDER BY TB1.TANGGAL");
        return $data->row_array();
    }
    function getLeadTime($kode){
        $data = $this->db3->query("select nvl(standart_area,0) standart_area from M_LEADTIME where KD_DISTRIK = '$kode'");
        return $data->row_array();
    }
    function getProvinsi(){
        $data = $this->db->query('select KD_PROV, NM_PROV from ZREPORT_M_PROVINSI where KD_PROV <> 0001 AND KD_PROV <> 1092');
        return $data->result_array();
    }
    function getKota(){
        $data = $this->db2->query("select KD_PROP, KD_KOTA, NM_KOTA from ZREPORT_M_KOTA");
        return $data->result_array();
    }
}