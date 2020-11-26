<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

date_default_timezone_set('Asia/Jakarta');

class CrmGudangService_model extends CI_Model {

    private $db2;

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db2 = $this->load->database('scmproduction', TRUE);
    }

    function getShip() {
        $data = $this->db2->query("SELECT DISTINCT(KOTA_SHIPTO) as KOTA_SHIPTO FROM CRM_GUDANG_SERVICE WHERE ORG=7000 and DELETE_MARK = 0");
        return $data;
    }

    function crmGudangServiceMax() {
        $sql = "SELECT a.KOTA_SHIPTO, SUM(a.QTY_RILIS) QTY_RILIS, SUM(a.QTY_TERIMA) QTY_TERIMA, SUM(a.QTY_STOK) QTY_STOK, SUM(b.KAPASITAS) KAPASITAS, TO_CHAR(a.TGL_RILIS, 'DD-MM-YYYY') TGL_RILIS 
		FROM CRM_GUDANG_SERVICE a
                LEFT JOIN CRM_GUDANG b 
                ON a.KODE_SHIPTO = b.KD_GDG
                WHERE TO_CHAR(a.TGL_RILIS, 'DD-MM-YYYY') = TO_CHAR((SELECT MAX(TGl_RILIS) FROM CRM_GUDANG_SERVICE WHERE ORG = 7000 and DELETE_MARK = 0 and QTY_RILIS > 0), 'DD-MM-YYYY')
                and a.ORG = 7000 and a.DELETE_MARK = 0 
                                and QTY_RILIS > 0
		GROUP BY a.KOTA_SHIPTO, a.TGL_RILIS";
        return $this->db2->query($sql);
    }

    function crmGudangServiceKap($date) {
        $sql = "SELECT a.KOTA_SHIPTO, SUM(a.QTY_RILIS) QTY_RILIS, SUM(a.QTY_TERIMA) QTY_TERIMA, SUM(a.QTY_STOK) QTY_STOK, SUM(b.KAPASITAS) KAPASITAS 
		FROM CRM_GUDANG_SERVICE a
                LEFT JOIN CRM_GUDANG b ON a.KODE_SHIPTO = b.KD_GDG
                WHERE TO_CHAR(a.TGL_RILIS, 'DD-MM-YYYY') = '$date' and a.ORG = 7000 and a.DELETE_MARK = 0 
                    and QTY_RILIS > 0
		GROUP BY a.KOTA_SHIPTO";
        return $this->db2->query($sql);
    }

    public function crmGudangService($date) {
        $sql = "SELECT KOTA_SHIPTO, SUM(QTY_RILIS) QTY_RILIS, SUM(QTY_TERIMA) QTY_TERIMA, SUM(QTY_STOK) QTY_STOK
		FROM CRM_GUDANG_SERVICE WHERE TO_CHAR(TGL_RILIS, 'DD-MM-YYYY') = '$date' and ORG = 7000 and DELETE_MARK = 0 
        and QTY_RILIS > 0
		GROUP BY KOTA_SHIPTO";
        return $this->db2->query($sql);
    }

    public function getData($date) {
        $xCrmGudangService = $this->crmGudangServiceKap($date);

        $kotaShipto = array();
        if (!$xCrmGudangService->result()) {
//            $ship = $this->getShip()->result();
//            foreach($ship as $row){
//                $kotaShipto[] = $row->KOTA_SHIPTO;
//            }            
//            $kotaShipto = array('255004', '258002', '245004', '233004', '236008', '202001', '254001', '232001', '236012', '234006', '233002', '236002', '236010', '202002', '261018', '261006', '236014', '233003', '233001', '226002', '255003', '256001', '257001', '257002', '232004', '245005', '245002', '223006', '224003', '222002', '225001', '223001', '202003', '251002', '252001', '253003', '252002', '255006', '258004', '231006', '231008', '236011', '236003', '245007', '234002', '234001', '234009', '222004', '224015', '224007', '261010', '233005', '254005', '255005', '257003', '231004', '234007', '231007', '232002', '245006', '222005', '212001', '261007', '224004', '225002', '252003', '254002', '254003', '255002', '258003', '232003', '231002', '232006', '255001', '256004', '231003', '224002', '224019', '226004', '261004', '225005', '251001', '254004', '256003', '258001', '234004', '232008', '236006', '232005', '201003', '224006', '224027', '261005', '261008', '261009', '251005', '251006', '253001', '253009');
            $kotaShipto[] = '0';
        } else {
            foreach ($xCrmGudangService->result() as $row) {
                $kotaShipto[] = $row->KOTA_SHIPTO;
            }
        }
        /* $this->db->where_in('KD_KOTA', $kotaShipto);
          $this->db->get('zreport_m_kota'); */
        $this->db->select('prov.KD_PROV, prov.NM_PROV,prov.ID_REGION, kota.KD_KOTA, kota.KD_AREA, area.DESCH, area.NO_AREA');
        $this->db->from('ZREPORT_M_KOTA kota');
        $this->db->join('ZREPORT_M_PROVINSI prov', 'prov.KD_PROV = kota.KD_PROP');
        $this->db->join('ZREPORT_M_AREA area', 'area.KD_AREA = kota.KD_AREA');
        $this->db->where('kota.KD_AREA IS NOT NULL');
        $this->db->where_in('kota.KD_KOTA', $kotaShipto);
        $this->db->order_by('prov.KD_PROV', 'ASC');
        $this->db->order_by('area.NO_AREA', 'ASC');

        $data['properties'] = $this->db->get();
        //echo $this->db->last_query();
        $data['values'] = $xCrmGudangService;
        return $data;
        /* $q = "select
          prov.NM_PROV,prov.ID_REGION, kota.KD_KOTA, kota.KD_AREA
          from zreport_m_kota kota
          left join zreport_m_provinsi prov on prov.KD_PROV = kota.KD_PROP
          WHERE kota.KD_AREA IS NOT NULL
          order by prov.KD_PROV2 ASC;" */


        /*
          - return array in index
          - NAMA PROVINSI, KODE REGION, KOTA_ID, KD_AREA
          - select * from zreport_m_provinsi where id_region = 5;
          - select * from zreport_m_kota where kd_prop = 1025;
          - select * from zreport_m_area where kd_area in (select kd_area from zreport_m_kota where kd_prop = 1025);
         */
    }

    public function getDataMax() {
        $xCrmGudangService = $this->crmGudangServiceMax();

        $kotaShipto = array();
        if (!$xCrmGudangService->result()) {
//            $ship = $this->getShip()->result();
//            foreach($ship as $row){
//                $kotaShipto[] = $row->KOTA_SHIPTO;
//            }            
//            $kotaShipto = array('255004', '258002', '245004', '233004', '236008', '202001', '254001', '232001', '236012', '234006', '233002', '236002', '236010', '202002', '261018', '261006', '236014', '233003', '233001', '226002', '255003', '256001', '257001', '257002', '232004', '245005', '245002', '223006', '224003', '222002', '225001', '223001', '202003', '251002', '252001', '253003', '252002', '255006', '258004', '231006', '231008', '236011', '236003', '245007', '234002', '234001', '234009', '222004', '224015', '224007', '261010', '233005', '254005', '255005', '257003', '231004', '234007', '231007', '232002', '245006', '222005', '212001', '261007', '224004', '225002', '252003', '254002', '254003', '255002', '258003', '232003', '231002', '232006', '255001', '256004', '231003', '224002', '224019', '226004', '261004', '225005', '251001', '254004', '256003', '258001', '234004', '232008', '236006', '232005', '201003', '224006', '224027', '261005', '261008', '261009', '251005', '251006', '253001', '253009');
            $kotaShipto[] = '0';
        } else {
            foreach ($xCrmGudangService->result() as $row) {
                $kotaShipto[] = $row->KOTA_SHIPTO;
            }
        }
        $this->db->select('prov.KD_PROV, prov.NM_PROV,prov.ID_REGION, kota.KD_KOTA, kota.KD_AREA, area.DESCH, area.NO_AREA');
        $this->db->from('ZREPORT_M_KOTA kota');
        $this->db->join('ZREPORT_M_PROVINSI prov', 'prov.KD_PROV = kota.KD_PROP');
        $this->db->join('ZREPORT_M_AREA area', 'area.KD_AREA = kota.KD_AREA');
        $this->db->where('kota.KD_AREA IS NOT NULL');
        $this->db->where_in('kota.KD_KOTA', $kotaShipto);
        $this->db->order_by('prov.KD_PROV', 'ASC');
        $this->db->order_by('area.NO_AREA', 'ASC');

        $data['properties'] = $this->db->get();
        $data['values'] = $xCrmGudangService;
        return $data;
    }

    public function getDataJatim($area,$date){
        $data = $this->db2->query("SELECT * FROM (SELECT TBL1.KD_PROV, TBL1.NO_AREA, SUM(TBL2.QTY_STOK) QTY_STOK, SUM(TBL2.KAPASITAS) KAPASITAS, TBL2.TGL_RILIS FROM (
                SELECT PROV.KD_PROV, AREA.KD_AREA, AREA.NO_AREA, KOTA.KD_KOTA
                FROM ZREPORT_M_PROVINSI PROV 
                LEFT JOIN ZREPORT_M_AREA AREA
                ON PROV.KD_PROV = AREA.ID_PROV
                JOIN ZREPORT_M_KOTA KOTA
                ON AREA.KD_AREA = KOTA.KD_AREA
                WHERE PROV.KD_PROV = '1025' AND AREA.NO_AREA = $area
              ) TBL1
              LEFT JOIN (
                SELECT a.KOTA_SHIPTO, SUM(a.QTY_STOK) QTY_STOK, SUM(b.KAPASITAS) KAPASITAS, TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') TGL_RILIS 
                FROM CRM_GUDANG_SERVICE a
                LEFT JOIN CRM_GUDANG b 
                ON a.KODE_SHIPTO = b.KD_GDG
                WHERE TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') <= TO_CHAR((SELECT MAX(TGl_RILIS) FROM CRM_GUDANG_SERVICE WHERE ORG = 7000 and DELETE_MARK = 0 and QTY_RILIS > 0 AND TO_CHAR(TGL_RILIS,'YYYYMMDD') <= '$date'), 'YYYYMMDD')
                and a.ORG = 7000 and a.DELETE_MARK = 0 
                and QTY_RILIS > 0
                GROUP BY a.KOTA_SHIPTO, a.TGL_RILIS
              ) TBL2
              ON TBL1.KD_KOTA = TBL2.KOTA_SHIPTO
              WHERE TBL2.TGL_RILIS IS NOT NULL
              GROUP BY KD_PROV,NO_AREA,TGL_RILIS
              ORDER BY TGL_RILIS DESC
              ) WHERE ROWNUM = 1");
        return $data->result_array();
    }
    public function getDataJateng($area,$date){
        $data = $this->db2->query("SELECT * FROM (SELECT TBL1.NO_AREA, SUM(TBL2.QTY_STOK) QTY_STOK, SUM(TBL2.KAPASITAS) KAPASITAS, TBL2.TGL_RILIS FROM (
                SELECT PROV.KD_PROV, AREA.KD_AREA, AREA.NO_AREA, KOTA.KD_KOTA
                FROM ZREPORT_M_PROVINSI PROV 
                LEFT JOIN ZREPORT_M_AREA AREA
                ON PROV.KD_PROV = AREA.ID_PROV
                JOIN ZREPORT_M_KOTA KOTA
                ON AREA.KD_AREA = KOTA.KD_AREA
                WHERE (PROV.KD_PROV = '1023' OR PROV.KD_PROV = '1024') AND AREA.NO_AREA = $area
              ) TBL1
              LEFT JOIN (
                SELECT a.KOTA_SHIPTO, SUM(a.QTY_STOK) QTY_STOK, SUM(b.KAPASITAS) KAPASITAS, TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') TGL_RILIS 
                FROM CRM_GUDANG_SERVICE a
                LEFT JOIN CRM_GUDANG b 
                ON a.KODE_SHIPTO = b.KD_GDG
                WHERE TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') <= TO_CHAR((SELECT MAX(TGl_RILIS) FROM CRM_GUDANG_SERVICE WHERE ORG = 7000 and DELETE_MARK = 0 and QTY_RILIS > 0 AND TO_CHAR(TGL_RILIS,'YYYYMMDD') <= '$date'), 'YYYYMMDD')
                and a.ORG = 7000 and a.DELETE_MARK = 0 
                and QTY_RILIS > 0
                GROUP BY a.KOTA_SHIPTO, a.TGL_RILIS
              ) TBL2
              ON TBL1.KD_KOTA = TBL2.KOTA_SHIPTO
              WHERE TBL2.TGL_RILIS IS NOT NULL
              GROUP BY NO_AREA, TGL_RILIS
              ORDER BY TGL_RILIS DESC
              ) WHERE ROWNUM = 1");
        return $data->result_array();
    }
    
    public function getDataJabar($area,$date){
        $data = $this->db2->query("SELECT * FROM (SELECT TBL1.NO_AREA, SUM(TBL2.QTY_STOK) QTY_STOK, SUM(TBL2.KAPASITAS) KAPASITAS, TBL2.TGL_RILIS FROM (
                SELECT PROV.KD_PROV, AREA.KD_AREA, AREA.NO_AREA, KOTA.KD_KOTA
                FROM ZREPORT_M_PROVINSI PROV 
                LEFT JOIN ZREPORT_M_AREA AREA
                ON PROV.KD_PROV = AREA.ID_PROV
                JOIN ZREPORT_M_KOTA KOTA
                ON AREA.KD_AREA = KOTA.KD_AREA
                WHERE (PROV.KD_PROV = '1020' OR PROV.KD_PROV = '1021' OR PROV.KD_PROV = '1022') AND AREA.NO_AREA = $area
              ) TBL1
              LEFT JOIN (
                SELECT a.KOTA_SHIPTO, SUM(a.QTY_STOK) QTY_STOK, SUM(b.KAPASITAS) KAPASITAS, TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') TGL_RILIS 
                FROM CRM_GUDANG_SERVICE a
                LEFT JOIN CRM_GUDANG b 
                ON a.KODE_SHIPTO = b.KD_GDG
                WHERE TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') <= TO_CHAR((SELECT MAX(TGl_RILIS) FROM CRM_GUDANG_SERVICE WHERE ORG = 7000 and DELETE_MARK = 0 and QTY_RILIS > 0 AND TO_CHAR(TGL_RILIS,'YYYYMMDD') <= '$date'), 'YYYYMMDD')
                and a.ORG = 7000 and a.DELETE_MARK = 0 
                and QTY_RILIS > 0
                GROUP BY a.KOTA_SHIPTO, a.TGL_RILIS
              ) TBL2
              ON TBL1.KD_KOTA = TBL2.KOTA_SHIPTO
              WHERE TBL2.TGL_RILIS IS NOT NULL
              GROUP BY NO_AREA, TGL_RILIS
              ORDER BY TGL_RILIS DESC
              ) WHERE ROWNUM = 1");
        return $data->result_array();
    }
    
    public function getDataBali($date){
        $data = $this->db2->query("SELECT * FROM (SELECT TBL1.NO_AREA, SUM(TBL2.QTY_STOK) QTY_STOK, SUM(TBL2.KAPASITAS) KAPASITAS, TBL2.TGL_RILIS FROM (
                SELECT PROV.KD_PROV, AREA.KD_AREA, AREA.NO_AREA, KOTA.KD_KOTA
                FROM ZREPORT_M_PROVINSI PROV 
                LEFT JOIN ZREPORT_M_AREA AREA
                ON PROV.KD_PROV = AREA.ID_PROV
                JOIN ZREPORT_M_KOTA KOTA
                ON AREA.KD_AREA = KOTA.KD_AREA
                WHERE PROV.KD_PROV = '1026' OR PROV.KD_PROV = '1027' OR PROV.KD_PROV = '1028'
              ) TBL1
              LEFT JOIN (
                SELECT a.KOTA_SHIPTO, SUM(a.QTY_STOK) QTY_STOK, SUM(b.KAPASITAS) KAPASITAS, TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') TGL_RILIS 
                FROM CRM_GUDANG_SERVICE a
                LEFT JOIN CRM_GUDANG b 
                ON a.KODE_SHIPTO = b.KD_GDG
                WHERE TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') <= TO_CHAR((SELECT MAX(TGl_RILIS) FROM CRM_GUDANG_SERVICE WHERE ORG = 7000 and DELETE_MARK = 0 and QTY_RILIS > 0 AND TO_CHAR(TGL_RILIS,'YYYYMMDD') <= '$date'), 'YYYYMMDD')
                and a.ORG = 7000 and a.DELETE_MARK = 0 
                and QTY_RILIS > 0
                GROUP BY a.KOTA_SHIPTO, a.TGL_RILIS
              ) TBL2
              ON TBL1.KD_KOTA = TBL2.KOTA_SHIPTO
              WHERE TBL2.TGL_RILIS IS NOT NULL
              GROUP BY NO_AREA, TGL_RILIS
              ORDER BY TGL_RILIS DESC
              ) WHERE ROWNUM = 1");
        return $data->result_array();
    }
    
    function getDataJabar2($area,$date){
        $data = $this->db2->query("SELECT * FROM (SELECT TBL1.KD_PROV, TBL1.KD_KOTA, TBL1.NO_AREA, SUM(TBL2.QTY_STOK) QTY_STOK, SUM(TBL2.KAPASITAS) KAPASITAS, TBL2.TGL_RILIS FROM (
                SELECT PROV.KD_PROV, AREA.KD_AREA, AREA.NO_AREA, KOTA.KD_KOTA, KOTA.NM_KOTA
                FROM ZREPORT_M_PROVINSI PROV 
                LEFT JOIN ZREPORT_M_AREA AREA
                ON PROV.KD_PROV = AREA.ID_PROV
                JOIN ZREPORT_M_KOTA KOTA
                ON AREA.KD_AREA = KOTA.KD_AREA
                WHERE (PROV.KD_PROV = '1020' OR PROV.KD_PROV = '1021' OR PROV.KD_PROV = '1022') AND AREA.NO_AREA = $area
              ) TBL1
              LEFT JOIN (
                SELECT a.KOTA_SHIPTO, SUM(a.QTY_STOK) QTY_STOK, SUM(b.KAPASITAS) KAPASITAS, TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') TGL_RILIS 
                FROM CRM_GUDANG_SERVICE a
                LEFT JOIN CRM_GUDANG b 
                ON a.KODE_SHIPTO = b.KD_GDG
                WHERE TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') <= TO_CHAR((SELECT MAX(TGl_RILIS) FROM CRM_GUDANG_SERVICE WHERE ORG = 7000 and DELETE_MARK = 0 and QTY_RILIS > 0 AND TO_CHAR(TGL_RILIS,'YYYYMMDD') <= '$date'), 'YYYYMMDD')
                and a.ORG = 7000 and a.DELETE_MARK = 0 
                and QTY_RILIS > 0
                GROUP BY a.KOTA_SHIPTO, a.TGL_RILIS
              ) TBL2
              ON TBL1.KD_KOTA = TBL2.KOTA_SHIPTO
              WHERE TBL2.TGL_RILIS IS NOT NULL
              GROUP BY NO_AREA, TGL_RILIS, KD_KOTA, KD_PROV
              ORDER BY TGL_RILIS DESC
              ) WHERE TGL_RILIS = (SELECT MAX(TGL_RILIS) FROM (
                  SELECT TBL1.KD_PROV, TBL1.KD_KOTA, TBL1.NO_AREA, SUM(TBL2.QTY_STOK) QTY_STOK, SUM(TBL2.KAPASITAS) KAPASITAS, TBL2.TGL_RILIS FROM (
                    SELECT PROV.KD_PROV, AREA.KD_AREA, AREA.NO_AREA, KOTA.KD_KOTA, KOTA.NM_KOTA
                    FROM ZREPORT_M_PROVINSI PROV 
                    LEFT JOIN ZREPORT_M_AREA AREA
                    ON PROV.KD_PROV = AREA.ID_PROV
                    JOIN ZREPORT_M_KOTA KOTA
                    ON AREA.KD_AREA = KOTA.KD_AREA
                    WHERE (PROV.KD_PROV = '1020' OR PROV.KD_PROV = '1021' OR PROV.KD_PROV = '1022') AND AREA.NO_AREA = $area
                  ) TBL1
                  LEFT JOIN (
                    SELECT a.KOTA_SHIPTO, SUM(a.QTY_STOK) QTY_STOK, SUM(b.KAPASITAS) KAPASITAS, TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') TGL_RILIS 
                    FROM CRM_GUDANG_SERVICE a
                    LEFT JOIN CRM_GUDANG b 
                    ON a.KODE_SHIPTO = b.KD_GDG
                    WHERE TO_CHAR(a.TGL_RILIS, 'YYYYMMDD') <= TO_CHAR((SELECT MAX(TGl_RILIS) FROM CRM_GUDANG_SERVICE WHERE ORG = 7000 and DELETE_MARK = 0 and QTY_RILIS > 0 AND TO_CHAR(TGL_RILIS,'YYYYMMDD') <= '$date'), 'YYYYMMDD')
                    and a.ORG = 7000 and a.DELETE_MARK = 0 
                    and QTY_RILIS > 0
                    GROUP BY a.KOTA_SHIPTO, a.TGL_RILIS
                  ) TBL2
                  ON TBL1.KD_KOTA = TBL2.KOTA_SHIPTO
                  WHERE TBL2.TGL_RILIS IS NOT NULL
                  GROUP BY NO_AREA, TGL_RILIS, KD_KOTA, KD_PROV
                  ORDER BY TGL_RILIS DESC
                ))");
        return $data->result_array();
    }
}
