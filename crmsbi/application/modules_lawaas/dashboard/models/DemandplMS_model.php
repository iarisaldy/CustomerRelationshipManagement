<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

class DemandplMS_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function getPerusahaan(){
        $data = $this->db->get('ZREPORT_MS_PERUSAHAAN');
        return $data->result_array();
    }
    function getNumPerusahaan(){
        $data = $this->db->get('ZREPORT_MS_PERUSAHAAN');
        return $data->num_rows();
    }
    function getDataASIGDN($tahun, $bulan){
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
        $data = $this->db->query("SELECT NVL(TBL1.QTY_REAL,0) REAL_BLN, NVL((SELECT SUM(QTY_REAL) QTY_REAL FROM ZREPORT_MS_TRANS1 
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

        return $data->result_array();
    }
    function getDataASI($tahun, $bulan) {
//        $kd_perusahaan = "' '";
//        foreach($perusahaan as $value){
//            foreach($value as $kode){
//                $kd_perusahaan .= ",'".$kode."'";
//            }            
//        }
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
        $data = $this->db->query("SELECT TBL3.KODE_PERUSAHAAN, TBL3.NAMA_PERUSAHAAN, TBL3.PRODUK, TBL3.INISIAL, TBL3.QTY, nvl(TBL3.REAL_BLN,0) QTY_REAL, nvl(TBL4.QTY,0) REAL_BULAN, 
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
                ORDER BY TBL3.KODE_PERUSAHAAN ASC");
        //echo $this->db->last_query();
        return $data->result_array();
    }
    
    function getDataMomSG($tahun, $bulan){
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
        $date = $tahun.''.$bulankemarin;
        $datemin = $tahunkemarin.''.$bulankemarin;
        $data = $this->db->query("select org, sum(real) as REALISASI, tgl from(
                      select com org, sum(kwantumx) as real, to_char(tgl_cmplt,'YYYYMM') tgl
                      from zreport_rpt_real
                      where to_char(tgl_cmplt,'YYYYMM')<='$date' and to_char(tgl_cmplt,'YYYYMM')>='$datemin'
                        and ( (order_type <>'ZNL' and
                              (item_no like '121-301%' and item_no <> '121-301-0240')) or 
                              (item_no like '121-302%' and order_type <>'ZNL') 
                            ) 
                        and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                        and sold_to like '0000000%'
                      group by com, to_char(tgl_cmplt,'YYYYMM')
                      union
                      select vkorg org, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl 
                      from ZREPORT_ONGKOSANGKUT_MOD 
                      where VKORG='7000' and LFART='ZLR' 
                        and to_char(wadat_ist,'YYYYMM')<='$date' and to_char(wadat_ist,'YYYYMM')>='$datemin'
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                        and kunag like '0000000%'
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                      )
                      group by org, tgl order by tgl");
        return $data->result_array();
    }
    function getDataYoySG($tahun,$bulan){
        $tahunkemarin = $tahun - 1;
        $tahunkemarin2 = $tahun - 2;
        $bulankemarin = $bulan - 1;
        $tahunbanding = $tahun;
        if($bulankemarin==0){
            $bulankemarin = 12;
            $tahunbanding = $tahun-1;
        }
        if (strlen($bulankemarin) == 1) {
            $bulankemarin = '0' . $bulankemarin;
        }
        $date = $tahun.''.$bulankemarin;
        $datemin = $tahunkemarin.''.$bulankemarin;
        $dateminthn = $tahunkemarin.''.$bulan;
        $dateminthn2 = $tahunkemarin2.''.$bulan;
        $data = $this->db->query("select org, sum(real) as REALISASI, tgl from(
                      select com org, sum(kwantumx) as real, to_char(tgl_cmplt,'YYYYMM') tgl
                      from zreport_rpt_real
                      where ((to_char(tgl_cmplt,'YYYYMM')<='$date' and to_char(tgl_cmplt,'YYYYMM')>='$dateminthn') or
                      (to_char(tgl_cmplt,'YYYYMM')<='$datemin' and to_char(tgl_cmplt,'YYYYMM')>='$dateminthn2'))
                        and ( (order_type <>'ZNL' and
                              (item_no like '121-301%' and item_no <> '121-301-0240')) or 
                              (item_no like '121-302%' and order_type <>'ZNL') 
                            ) 
                        and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                        and sold_to like '0000000%'
                      group by com, to_char(tgl_cmplt,'YYYYMM')
                      union
                      select vkorg org, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl 
                      from ZREPORT_ONGKOSANGKUT_MOD 
                      where VKORG='7000' and LFART='ZLR' 
                        and ((to_char(wadat_ist,'YYYYMM')<='$date' and to_char(wadat_ist,'YYYYMM')>='$dateminthn') or
                        (to_char(wadat_ist,'YYYYMM')<='$datemin' and to_char(wadat_ist,'YYYYMM')>='$dateminthn2'))
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                        and kunag like '0000000%'
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                      )
                      group by org, tgl order by tgl");
        return $data->result_array();
    }
    function getDataKumYoySG($tahun,$bulan){
        $tahunkemarin = $tahun - 2;
        $bulankemarin = $bulan - 1;
        $tahunbanding = $tahun;
        if($bulankemarin==0){
            $bulankemarin = 12;
            $tahunbanding = $tahun-1;
        }
        if (strlen($bulankemarin) == 1) {
            $bulankemarin = '0' . $bulankemarin;
        }
        $date = $tahun.''.$bulankemarin;
        $data = $this->db->query("select org, sum(real) as REALISASI, tgl from(
                      select com org, sum(kwantumx) as real, to_char(tgl_cmplt,'YYYYMM') tgl
                      from zreport_rpt_real
                      where (to_char(tgl_cmplt,'YYYY')<='$tahun' and to_char(tgl_cmplt,'YYYY')>='$tahunkemarin') 
                        and to_char(tgl_cmplt,'YYYYMM')<='$date'
                        and ( (order_type <>'ZNL' and
                              (item_no like '121-301%' and item_no <> '121-301-0240')) or 
                              (item_no like '121-302%' and order_type <>'ZNL') 
                            ) 
                        and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                        and sold_to like '0000000%'
                      group by com, to_char(tgl_cmplt,'YYYYMM')
                      union
                      select vkorg org, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl 
                      from ZREPORT_ONGKOSANGKUT_MOD 
                      where VKORG='7000' and LFART='ZLR' 
                        and (to_char(wadat_ist,'YYYY')<='$tahun' and to_char(wadat_ist,'YYYY')>='$tahunkemarin') and
                        to_char(wadat_ist,'YYYYMM')<='$date'
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                        and kunag like '0000000%'
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                      )
                      group by org, tgl order by tgl");
        return $data;
    }
    function getDataMomSP($tahun,$bulan){
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
        $date = $tahun.''.$bulankemarin;
        $datemin = $tahunkemarin.''.$bulankemarin;
        $data = $this->db->query("select vkorg org, sum(real) as realisasi, tgl from(    
                      select vkorg, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl from ZREPORT_ONGKOSANGKUT_MOD 
                      where 
                        to_char(wadat_ist,'YYYYMM')<='$date' and to_char(wadat_ist,'YYYYMM')>='$datemin' 
                        and LFART <> 'ZNL'
                        and  (
                          (matnr like '121-301%' and matnr <> '121-301-0240') or 
                          (matnr like '121-302%')
                        )
                      and vkorg = '3000'
                      and kunag not in ('0000040084','0000040147','0000040272') 
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                      union
                      select vkorg, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl from ZREPORT_ONGKOSANGKUT_MOD 
                      where VKORG='3000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')<='$date' and to_char(wadat_ist,'YYYYMM')>='$datemin'
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                        and kunag not in ('0000040084','0000040147','0000040272') 
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                    )
                    group by vkorg, tgl
                    order by tgl");
        return $data->result_array();
    }
    function getDataYoySP($tahun,$bulan){
        $tahunkemarin = $tahun - 1;
        $tahunkemarin2 = $tahun - 2;
        $bulankemarin = $bulan - 1;
        $tahunbanding = $tahun;
        if($bulankemarin==0){
            $bulankemarin = 12;
            $tahunbanding = $tahun-1;
        }
        if (strlen($bulankemarin) == 1) {
            $bulankemarin = '0' . $bulankemarin;
        }
        $date = $tahun.''.$bulankemarin;
        $datemin = $tahunkemarin.''.$bulankemarin;
        $dateminthn = $tahunkemarin.''.$bulan;
        $dateminthn2 = $tahunkemarin2.''.$bulan;
        $data = $this->db->query("select vkorg org, sum(real) as realisasi, tgl from(    
                      select vkorg, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl from ZREPORT_ONGKOSANGKUT_MOD 
                      where 
                        ((to_char(wadat_ist,'YYYYMM')<='$date' and to_char(wadat_ist,'YYYYMM')>='$dateminthn') or 
			(to_char(wadat_ist,'YYYYMM')<='$datemin' and to_char(wadat_ist,'YYYYMM')>='$dateminthn2'))
                        and LFART <> 'ZNL'
                        and  (
                          (matnr like '121-301%' and matnr <> '121-301-0240') or 
                          (matnr like '121-302%')
                        )
                      and vkorg = '3000'
                      and kunag not in ('0000040084','0000040147','0000040272') 
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                      union
                      select vkorg, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl from ZREPORT_ONGKOSANGKUT_MOD 
                      where VKORG='3000' and LFART='ZLR' and 
                      ((to_char(wadat_ist,'YYYYMM')<='$date' and to_char(wadat_ist,'YYYYMM')>='$dateminthn') or 
                      (to_char(wadat_ist,'YYYYMM')<='$datemin' and to_char(wadat_ist,'YYYYMM')>='$dateminthn2'))
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                        and kunag not in ('0000040084','0000040147','0000040272') 
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                    )
                    group by vkorg, tgl
                    order by tgl");
        return $data->result_array();
    }
    function getDataKumYoySP($tahun,$bulan){
        $tahunkemarin = $tahun - 2;
        $bulankemarin = $bulan - 1;
        $tahunbanding = $tahun;
        if($bulankemarin==0){
            $bulankemarin = 12;
            $tahunbanding = $tahun-1;
        }
        if (strlen($bulankemarin) == 1) {
            $bulankemarin = '0' . $bulankemarin;
        }
        $date = $tahun.''.$bulankemarin;
        $data = $this->db->query("select vkorg org, sum(real) as realisasi, tgl from(    
                      select vkorg, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl from ZREPORT_ONGKOSANGKUT_MOD 
                      where 
                        (to_char(wadat_ist,'YYYY')<='$tahun' and to_char(wadat_ist,'YYYY')>='$tahunkemarin') 
                        and to_char(wadat_ist,'YYYYMM')<='$date'
                        and LFART <> 'ZNL'
                        and  (
                          (matnr like '121-301%' and matnr <> '121-301-0240') or 
                          (matnr like '121-302%')
                        )
                      and vkorg = '3000'
                      and kunag not in ('0000040084','0000040147','0000040272') 
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                      union
                      select vkorg, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl from ZREPORT_ONGKOSANGKUT_MOD 
                      where VKORG='3000' and LFART='ZLR' and 
                      (to_char(wadat_ist,'YYYY')<='$tahun' and to_char(wadat_ist,'YYYY')>='$tahunkemarin') 
                        and to_char(wadat_ist,'YYYYMM')>='$date'
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                        and kunag not in ('0000040084','0000040147','0000040272') 
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                    )
                    group by vkorg, tgl
                    order by tgl");
        return $data;
    }
    function getDataMomST($tahun,$bulan){
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
        $date = $tahun.''.$bulankemarin;
        $datemin = $tahunkemarin.''.$bulankemarin;
        $data = $this->db->query("select org, sum(real) as realisasi, tgl from(
                      select com as org, sum(kwantumx) as real, to_char(tgl_cmplt,'YYYYMM') tgl
                      from zreport_rpt_real_st
                      where to_char(tgl_cmplt,'YYYYMM')<='$date' and to_char(tgl_cmplt,'YYYYMM')>='$datemin'
                        and ( (order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) 
                              or (item_no like '121-302%' and order_type <>'ZNL') ) 
                        and com = '4000' and no_polisi <> 'S11LO'
                        and sold_to like '000000%' and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                        and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                        and ORDER_TYPE<>'ZLFE'
                      group by com, to_char(tgl_cmplt,'YYYYMM')
                      union
                      select vkorg as org, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl
                      from ZREPORT_ONGKOSANGKUT_MOD 
                      where VKORG='4000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')<='$date' and to_char(wadat_ist,'YYYYMM')>='$datemin'
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                        and kunnr not like '000000%'
                        and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                        and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                      union
                      select ti.com as org,sum(ti.KWANTUMX) as real, to_char(tgl_cmplt,'YYYYMM') tgl
                      from ZREPORT_RPT_REAL_NON70_ST ti
                      where ti.ITEM_NO LIKE '121-301%' and item_no <> '121-301-0240' and to_char(tgl_cmplt,'YYYYMM')<='$date' and to_char(tgl_cmplt,'YYYYMM')>='$datemin'
                        and ti.COM='4000' and ti.ROUTE='ZR0001' and ti.STATUS in ('50')
                        and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                      group by ti.com, to_char(tgl_cmplt,'YYYYMM')
                    )
                    group by org, tgl
                    ORDER BY tgl");
        return $data->result_array();
    }
    
    function getDataYoyST($tahun,$bulan){
        $tahunkemarin = $tahun - 1;
        $tahunkemarin2 = $tahun - 2;
        $bulankemarin = $bulan - 1;
        $tahunbanding = $tahun;
        if($bulankemarin==0){
            $bulankemarin = 12;
            $tahunbanding = $tahun-1;
        }
        if (strlen($bulankemarin) == 1) {
            $bulankemarin = '0' . $bulankemarin;
        }
        $date = $tahun.''.$bulankemarin;
        $datemin = $tahunkemarin.''.$bulankemarin;
        $dateminthn = $tahunkemarin.''.$bulan;
        $dateminthn2 = $tahunkemarin2.''.$bulan;
        $data = $this->db->query("select org, sum(real) as realisasi, tgl from(
                      select com as org, sum(kwantumx) as real, to_char(tgl_cmplt,'YYYYMM') tgl
                      from zreport_rpt_real_st
                      where ((to_char(tgl_cmplt,'YYYYMM')<='$date' and to_char(tgl_cmplt,'YYYYMM')>='$dateminthn') or 
                        (to_char(tgl_cmplt,'YYYYMM')<='$datemin' and to_char(tgl_cmplt,'YYYYMM')>='$dateminthn2'))
                        and ( (order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) 
                              or (item_no like '121-302%' and order_type <>'ZNL') ) 
                        and com = '4000' and no_polisi <> 'S11LO'
                        and sold_to like '000000%' and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                        and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                        and ORDER_TYPE<>'ZLFE'
                      group by com, to_char(tgl_cmplt,'YYYYMM')
                      union
                      select vkorg as org, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl
                      from ZREPORT_ONGKOSANGKUT_MOD 
                      where VKORG='4000' and LFART='ZLR' and ((to_char(wadat_ist,'YYYYMM')<='$date' and to_char(wadat_ist,'YYYYMM')>='$dateminthn') OR
                        to_char(wadat_ist,'YYYYMM')<='$datemin' and to_char(wadat_ist,'YYYYMM')>='$dateminthn2')
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                        and kunnr not like '000000%'
                        and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                        and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                      union
                      select ti.com as org,sum(ti.KWANTUMX) as real, to_char(tgl_cmplt,'YYYYMM') tgl
                      from ZREPORT_RPT_REAL_NON70_ST ti
                      where ti.ITEM_NO LIKE '121-301%' and item_no <> '121-301-0240' and ((to_char(tgl_cmplt,'YYYYMM')<='$date' and to_char(tgl_cmplt,'YYYYMM')>='$dateminthn') or 
                        to_char(tgl_cmplt,'YYYYMM')<='$datemin' and to_char(tgl_cmplt,'YYYYMM')>='$dateminthn2')
                        and ti.COM='4000' and ti.ROUTE='ZR0001' and ti.STATUS in ('50')
                        and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                      group by ti.com, to_char(tgl_cmplt,'YYYYMM')
                    )
                    group by org, tgl
                    ORDER BY tgl");
        return $data->result_array();
    }
    function getDataKumYoyST($tahun,$bulan){
        $tahunkemarin = $tahun - 2;
        $bulankemarin = $bulan - 1;
        $tahunbanding = $tahun;
        if($bulankemarin==0){
            $bulankemarin = 12;
            $tahunbanding = $tahun-1;
        }
        if (strlen($bulankemarin) == 1) {
            $bulankemarin = '0' . $bulankemarin;
        }
        $date = $tahun.''.$bulankemarin;
        $data = $this->db->query("select org, sum(real) as realisasi, tgl from(
                      select com as org, sum(kwantumx) as real, to_char(tgl_cmplt,'YYYYMM') tgl
                      from zreport_rpt_real_st
                      where (to_char(tgl_cmplt,'YYYY')<='$tahun' and to_char(tgl_cmplt,'YYYY')>='$tahunkemarin') 
                        and to_char(tgl_cmplt,'YYYYMM')<='$date'
                        and ( (order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) 
                              or (item_no like '121-302%' and order_type <>'ZNL') ) 
                        and com = '4000' and no_polisi <> 'S11LO'
                        and sold_to like '000000%' and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                        and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                        and ORDER_TYPE<>'ZLFE'
                      group by com, to_char(tgl_cmplt,'YYYYMM')
                      union
                      select vkorg as org, sum(ton) as real, to_char(wadat_ist,'YYYYMM') tgl
                      from ZREPORT_ONGKOSANGKUT_MOD 
                      where VKORG='4000' and LFART='ZLR' and (to_char(wadat_ist,'YYYY')<='$tahun' and to_char(wadat_ist,'YYYY')>='$tahunkemarin') 
                        and to_char(wadat_ist,'YYYYMM')<='$date'
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                        and kunnr not like '000000%'
                        and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                        and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                      group by vkorg, to_char(wadat_ist,'YYYYMM')
                      union
                      select ti.com as org,sum(ti.KWANTUMX) as real, to_char(tgl_cmplt,'YYYYMM') tgl
                      from ZREPORT_RPT_REAL_NON70_ST ti
                      where ti.ITEM_NO LIKE '121-301%' and item_no <> '121-301-0240' and (to_char(tgl_cmplt,'YYYY')<='$tahun' and to_char(tgl_cmplt,'YYYY')>='$tahunkemarin')
                        and to_char(tgl_cmplt,'YYYYMM')<='$date'
                        and ti.COM='4000' and ti.ROUTE='ZR0001' and ti.STATUS in ('50')
                        and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                      group by ti.com, to_char(tgl_cmplt,'YYYYMM')
                    )
                    group by org, tgl
                    ORDER BY tgl");
        return $data;
    }
}