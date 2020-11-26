<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class PetaRevenue_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function datas($org, $tahun, $bulan) {
        $hariini = date('d');
        $data = $this->db->query("select tb3.*,tb4.rkaprevenub from (
                        select tb1.*,tb2.REVENUE from(
                        select prov,NM_PROV,sum(revenuh) as RKAPrevenuh from (
                        select * from (
                        select a.prov, c.budat,b.NM_PROV,
                        sum(a.revenue * (c.porsi/d.total_porsi)) as revenuh
                        from sap_t_rencana_sales_type a
                        left join zreport_m_provinsi b on a.prov = b.kd_prov
                        left join zreport_porsi_sales_region c on c.region=5
                        and c.vkorg= a.co
                        and c.budat like '$tahun$bulan%'
                        and c.tipe = a.tipe
                        left join (
                        select region, tipe, sum(porsi) as total_porsi
                        from zreport_porsi_sales_region
                        where budat like '$tahun$bulan%'
                        group by region, tipe
                        )d on c.region = d.region and d.tipe = a.tipe
                        where co = '$org' and thn = '$tahun' and bln = '$bulan'
                        group by co, thn, bln, a.prov, c.budat, b.NM_PROV
                        )
                        where budat <= '$tahun$bulan$hariini'
                        )
                        group by prov,NM_PROV
                        )tb1 left join (
                        select VKBUR, SUM(NET) AS REVENUE from ZREPORT_REAL_PENJUALAN
                        where vkorg = '$org' and lfart <> 'ZNL'
                        AND to_char(BUDAT,'YYYYMMDD') BETWEEN '".$tahun.$bulan."01' and '$tahun$bulan$hariini'
                        AND KUNAG LIKE '0000000%'
                        GROUP BY VKBUR
                        )tb2 on(tb1.PROV=tb2.VKBUR)
                        )tb3 left join (
                        select prov, sum(revenue) as rkaprevenub
                        from sap_t_rencana_sales_type
                        where co = '$org' and thn = '$tahun' and bln= '$bulan'
                        group by prov
                        )tb4 on (tb3.prov=tb4.prov)");
        return $data->result_array();
    }

    function updateDate() {
        $data = $this->db->query("SELECT NVL(TO_CHAR(MAX(CREATE_DATE),'dd-mm-YYYY'),'01-01-1997') TGL_UPDATE FROM ZREPORT_MS_TRANS");
        return $data->result_array();
    }

    function dataSG($tahun,$bulan){
        $data = $this->db->query("SELECT TB1.PROV, TB2.NM_PROV, NVL(TB3.REVENUE,0) REVENUE, NVL(TB1.RKAPREVENUB,0) RKAPREVENUB FROM (
                    select prov, sum(revenue) as rkaprevenub
                    from sap_t_rencana_sales_type
                    where co = '7000' and thn = '$tahun' and bln= '$bulan' AND PROV != '1092' and PROV != '0001'
                    group by prov
                  ) TB1 
                  LEFT JOIN ZREPORT_M_PROVINSI TB2
                  ON TB1.PROV = TB2.KD_PROV
                  LEFT JOIN (
                    select vkbur, sum(net-netwr) as revenue        
                    from zreport_real_penjualan
                    where to_char(budat,'YYYYMM') ='$tahun$bulan' and vkorg='7000'
                    and (
                         (MATNR like '121-301%' and MATNR <> '121-301-0240') or
                         (MATNR like '121-302%' and MATNR <> '121-302-0100')
                        )
                    and VKBUR!='1092' and VKBUR!='0001'
                    and lfart<>'ZNL' and lfart<>'ZLFE' and add01<>'S11LO' and kunag like '0000000%'
                    group by vkbur
                  ) TB3 
                  ON TB1.PROV = TB3.VKBUR
                  WHERE (REVENUE>0 OR RKAPREVENUB>0)");
        return $data->result_array();
    }
    
    function dataST($tahun,$bulan){
        $data = $this->db->query("SELECT TB1.PROV, TB2.NM_PROV, NVL(TB3.REVENUE,0) REVENUE, NVL(TB1.RKAPREVENUB,0) RKAPREVENUB FROM (
                    select prov, sum(revenue)*1000 as rkaprevenub
                    from sap_t_rencana_sales_type
                    where co = '4000' and thn = '$tahun' and bln= '$bulan' AND PROV != '1092' and PROV != '0001'
                    group by prov
                  ) TB1 
                  LEFT JOIN ZREPORT_M_PROVINSI TB2
                  ON TB1.PROV = TB2.KD_PROV
                  LEFT JOIN (
                    select vkbur, sum(net-netwr) as revenue        
                    from zreport_real_penjualan
                    where to_char(budat,'YYYYMM') ='$tahun$bulan' and vkorg='4000'
                    and (
                         (MATNR like '121-301%' and MATNR <> '121-301-0240') or
                         (MATNR like '121-302%' and MATNR <> '121-302-0100')
                        )
                    and VKBUR!='1092' and VKBUR!='0001'
                    and lfart<>'ZNL' and lfart<>'ZLFE' and add01<>'S11LO' and kunag like '0000000%'
                    and kunag <> '0000000888'
                    group by vkbur
                  ) TB3 
                  ON TB1.PROV = TB3.VKBUR
                  WHERE (REVENUE>0 OR RKAPREVENUB>0)");
        return $data->result_array();
    }
    
    function dataSP($tahun,$bulan){
        $data = $this->db->query("SELECT TB1.PROV, TB2.NM_PROV, NVL(TB3.REVENUE,0) REVENUE, NVL(TB1.RKAPREVENUB,0) RKAPREVENUB FROM (
                    select prov, sum(revenue) as rkaprevenub
                    from sap_t_rencana_sales_type
                    where co = '3000' and thn = '$tahun' and bln= '$bulan' AND PROV != '1092' and PROV != '0001'
                    group by prov
                  ) TB1 
                  LEFT JOIN ZREPORT_M_PROVINSI TB2
                  ON TB1.PROV = TB2.KD_PROV
                  LEFT JOIN (
                    select vkbur, sum(net-netwr) as revenue        
                    from zreport_real_penjualan
                    where to_char(budat,'YYYYMM') ='$tahun$bulan' and vkorg='3000'
                    and (
                         (MATNR like '121-301%' and MATNR <> '121-301-0240') or
                         (MATNR like '121-302%' and MATNR <> '121-302-0100')
                        )
                    and kunag not in ('0000040084','0000040147','0000040272') 
                    and VKBUR!='1092' and VKBUR!='0001'
                    and lfart<>'ZNL' --and lfart<>'ZLFE' and add01<>'S11LO'
                    group by vkbur
                  ) TB3 
                  ON TB1.PROV = TB3.VKBUR
                  WHERE (REVENUE>0 OR RKAPREVENUB>0)");
        return $data->result_array();
    }
    
    function getProv() {
        $data = $this->db->query("SELECT KD_PROV, NM_PROV FROM ZREPORT_M_PROVINSI WHERE KD_PROV != '0001' AND KD_PROV != '1092'");
        return $data->result_array();
    }
}
  
