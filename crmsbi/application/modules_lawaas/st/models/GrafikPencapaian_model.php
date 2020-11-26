<?php if(!defined('BASEPATH')) exit ('NO DIRECT SCRIPT ACCESS ALLOWED');

class GrafikPencapaian_model extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function scodatastNew($tahun,$bulan,$hari){
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query("SELECT
                                        TB1.PROV,
                                        TB8.NM_PROV,
                                        TB8.NM_PROV_1,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB2. REAL, 0) REAL,
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH,
                                        NVL (TB4.HARIAN_MAX, 0) HARIAN_MAX
                                FROM
                                        (
                                                SELECT
                                                        A .prov,
                                                        SUM (A .quantum) AS target
                                                FROM
                                                        sap_t_rencana_sales_type A
                                                WHERE
                                                        co = '4000'
                                                AND thn = '$tahun'
                                                AND bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                                GROUP BY
                                                        A .prov
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                PROPINSI_TO,
                                                SUM (REAL) REAL
                                        FROM
                                                (
                                                        SELECT
                                                                ORG,
                                                                PROPINSI_TO,
                                                                SUM (QTY) REAL
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                ORG = '4000'
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN = '$bulan'
                                                        AND HARI <= '$hari'
                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                ORG,
                                                                PROPINSI_TO
                                                        UNION
                                                                SELECT
                                                                        \"org\" ORG,
                                                                        \"kd_prov\" PROPINSI_TO,
                                                                        SUM (\"qty\") REAL
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"org\" = '4000'
                                                                AND \"tahun\" = '$tahun'
                                                                AND \"bulan\" = '$bulan'
                                                                AND \"hari\" <= '$hari'
                                                                AND \"kd_prov\" IS NOT NULL
                                                                GROUP BY
                                                                        \"org\",
                                                                        \"kd_prov\"
                                                )
                                        GROUP BY
                                                ORG,
                                                PROPINSI_TO
                                ) TB2 ON TB1.PROV = TB2.PROPINSI_TO
                                LEFT JOIN (
                                        SELECT
                                                prov,
                                                SUM (target_realh) AS target_realh
                                        FROM
                                                (
                                                        SELECT
                                                                *
                                                        FROM
                                                                (
                                                                        SELECT
                                                                                A .prov,
                                                                                c.budat,
                                                                                SUM (
                                                                                        A .quantum * (c.porsi / D .total_porsi)
                                                                                ) AS target_realh
                                                                        FROM
                                                                                sap_t_rencana_sales_type A
                                                                        LEFT JOIN zreport_m_provinsi b ON A .prov = b.kd_prov
                                                                        LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                                                        AND c.vkorg = A .co
                                                                        AND c.budat LIKE '$tahun$bulan%'
                                                                        AND c.tipe = A .tipe
                                                                        LEFT JOIN (
                                                                                SELECT
                                                                                        region,
                                                                                        tipe,
                                                                                        SUM (porsi) AS total_porsi
                                                                                FROM
                                                                                        zreport_porsi_sales_region
                                                                                WHERE
                                                                                        budat LIKE '$tahun$bulan%'
                                                                                AND vkorg = '4000'
                                                                                GROUP BY
                                                                                        region,
                                                                                        tipe
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe
                                                                        WHERE
                                                                                co = '4000'
                                                                        AND thn = '$tahun'
                                                                        AND bln = '$bulan'
                                                                        GROUP BY
                                                                                co,
                                                                                thn,
                                                                                bln,
                                                                                A .prov,
                                                                                c.budat
                                                                )
                                                        WHERE
                                                                budat <= '$tahun$bulan$hari'
                                                )
                                        GROUP BY
                                                prov
                                ) TB3 ON TB1.PROV = TB3.PROV
                                LEFT JOIN (
                                        SELECT
                                                org,
                                                PROPINSI_TO,
                                                MAX (qty) HARIAN_MAX
                                        FROM
                                                (
                                                        SELECT
                                                                ORG,
                                                                PROPINSI_TO,
                                                                HARI,
                                                                SUM (QTY) QTY
                                                        FROM
                                                                (
                                                                        SELECT
                                                                                ORG,
                                                                                PROPINSI_TO,
                                                                                HARI,
                                                                                SUM (QTY) qty
                                                                        FROM
                                                                                ZREPORT_SCM_REAL_SALES
                                                                        WHERE
                                                                                ORG = '4000'
                                                                        AND TAHUN = '$tahun'
                                                                        AND BULAN = '$bulan'
                                                                        AND HARI <= '$hari'
                                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                                        GROUP BY
                                                                                ORG,
                                                                                PROPINSI_TO,
                                                                                HARI
                                                                        UNION
                                                                                SELECT
                                                                                        \"org\" ORG,
                                                                                        \"kd_prov\" PROPINSI_TO,
                                                                                        \"hari\" HARI,
                                                                                        SUM (\"qty\") QTY
                                                                                FROM
                                                                                        ZREPORT_REAL_ST_ADJ
                                                                                WHERE
                                                                                        \"org\" = '4000'
                                                                                AND \"tahun\" = '$tahun'
                                                                                AND \"bulan\" = '$bulan'
                                                                                AND \"hari\" <= '$hari'
                                                                                AND \"kd_prov\" IS NOT NULL
                                                                                GROUP BY
                                                                                        \"org\",
                                                                                        \"kd_prov\",
                                                                                        \"hari\"
                                                                )
                                                        GROUP BY
                                                                ORG,
                                                                PROPINSI_TO,
                                                                HARI
                                                )
                                        GROUP BY
                                                ORG,
                                                PROPINSI_TO
                                ) TB4 ON TB1.PROV = TB4.PROPINSI_TO
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                ORDER BY
                                        TB1.PROV");
        return $data->result_array();
    }
    function scodatast($tahun,$bulan,$hari){
        $target1 = "select prov,sum(target_realh) as target_realh from(
                                    select * from (
                                    select  a.prov, c.budat,
                                    sum(a.quantum * (c.porsi/d.total_porsi)) as target_realh
                                    from sap_t_rencana_sales_type a
                                    left join zreport_m_provinsi b on a.prov = b.kd_prov
                                    left join zreport_porsi_sales_region c on c.region=5
                                                         and c.vkorg= a.co
                                                         and c.budat like '".$tahun.$bulan."%'
                                                         and c.tipe = a.tipe
                                    left join (
                                        select region, tipe,  sum(porsi) as total_porsi
                                        from zreport_porsi_sales_region
                                        where budat like '".$tahun.$bulan."%' and vkorg = '4000'
                                        group by region, tipe
                                    )d on c.region = d.region and d.tipe = a.tipe
                                    where co = '4000' and thn = '$tahun' and bln = '$bulan'
                                    group by co, thn, bln, a.prov, c.budat
                                    )
                                    where budat <= '".$tahun.$bulan.$hari."'
                                    ) group by prov";
        
        $target2 = "select prov, sum(quantum) as target_realh
                    from zreport_target_harian_sales_st
                    where org = 4000 and budat <= '$tahun$bulan$hari'
                    group by prov";
        
        $query = "select tbm3.*, tbm4.target_realh, nvl(tbm5.harian_max,0) harian_max from(
                select tbm1.*,tbm2.NM_PROV,tbm2.NM_PROV_1,tbm2.ID_REGION,tbm2.URUT_BARU  from (
                select tb1.*,nvl(tb2.real,0) as real from (
                select a.prov, sum(a.quantum) as target
                from sap_t_rencana_sales_type a                            
                where co = '4000' and thn = '$tahun' and bln = '$bulan' and a.prov!='0001' and a.prov!='1092'
                group by a.prov
                )tb1 left join (
                    select propinsi_to, sum(real) as real from(
                                    select propinsi_to, sum(kwantumx) as real
                                    from zreport_rpt_real_st
                                    where        
                                    to_char(tgl_cmplt,'YYYYMM')='".$tahun.$bulan."'
                                    and ( (order_type <>'ZNL' and
                                    (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
                                    and order_type <>'ZNL') ) and com = '4000' and no_polisi <> 'S11LO'
                                    and sold_to like '000000%'
                                    and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                                    and SOLD_TO not in ('0000000835','0000000836','0000000837') 
                                    and ORDER_TYPE<>'ZLFE'
                                    group by propinsi_to
                                    union
                                    select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='4000' and LFART='ZLR' and
                                    to_char(wadat_ist,'YYYYMM')='".$tahun.$bulan."'
                                    and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                                    and kunnr not like '000000%'
                                    and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                                    and kunag not in ('0000000835','0000000836','0000000837') 
                                    group by vkbur
                                    union
                                    select ti.propinsi_to,sum(ti.KWANTUMX) as real
                                    from ZREPORT_RPT_REAL_NON70_ST ti
                                    where (ti.ITEM_NO LIKE '121-301%' or ti.ITEM_NO LIKE '121-302%')
                                    and item_no <> '121-301-0240'
                                    and ti.COM='4000'
                                    and ti.ROUTE='ZR0001'
                                    and ti.STATUS in ('50')
                                    and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                                    group by ti.propinsi_to
                    )
                                    group by propinsi_to                
                )tb2 on (tb1.prov=tb2.propinsi_to)
                )tbm1 left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)
                )tbm3 left join (";
        if($bulan=='09' && $tahun=='2016'){
            $query .= $target2;
        }else{
            $query .= $target1;
        }
        $query .= ")tbm4 on(tbm3.prov=tbm4.prov)
                left join (
                 select propinsi_to, max(real) as harian_max 
                    from(
                      select propinsi_to, to_char(tgl_cmplt,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                      from zreport_rpt_real_st
                      where to_char(tgl_cmplt,'YYYYMM')='".$tahun.$bulan."'
                        and ((order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%' and order_type <>'ZNL') ) 
                        and com = '4000' and no_polisi <> 'S11LO'
                        and sold_to like '000000%'
                        and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                        and SOLD_TO not in ('0000000835','0000000836','0000000837') 
                        and ORDER_TYPE<>'ZLFE'
                      group by propinsi_to, to_char(tgl_cmplt,'YYYYMMDD')
                      union
                      select vkbur as propinsi_to, to_char(wadat_ist,'YYYYMMDD') as tanggal, sum(ton) as real 
                      from ZREPORT_ONGKOSANGKUT_MOD 
                      where VKORG='4000' and LFART='ZLR' 
                        and to_char(wadat_ist,'YYYYMM')='".$tahun.$bulan."'
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                        and kunnr not like '000000%'
                        and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                        and kunag not in ('0000000835','0000000836','0000000837') 
                      group by vkbur, to_char(wadat_ist,'YYYYMMDD')
                      union
                      select ti.propinsi_to, to_char(tgl_do,'YYYYMMDD') as tanggal, sum(ti.KWANTUMX) as real
                      from ZREPORT_RPT_REAL_NON70_ST ti
                      where ti.ITEM_NO LIKE '121-301%'
                        and to_char(tgl_do,'YYYYMM')='".$tahun.$bulan."' 
                        and item_no <> '121-301-0240' and ti.COM='4000' and ti.ROUTE='ZR0001'
                        and ti.STATUS in ('50') and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                      group by ti.propinsi_to,to_char(tgl_do,'YYYYMMDD')
                    )
                    group by propinsi_to
                )tbm5 on(tbm3.prov=tbm5.propinsi_to)
                where (TARGET>0 or REAL>0)
                order by URUT_BARU asc";
        
        $data = $this->db->query($query);
        //echo $this->db->last_query();
        return $data->result_array();
    }
}