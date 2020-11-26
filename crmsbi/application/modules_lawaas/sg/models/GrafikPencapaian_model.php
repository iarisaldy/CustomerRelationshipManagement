<?php if(!defined('BASEPATH')) exit ('NO DIRECT SCRIPT ACCESS ALLOWED');

class GrafikPencapaian_model extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function scodatasgNew($tahun,$bulan,$hari){
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
                                                        co = '7000'
                                                AND thn = '$tahun'
                                                AND bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                                GROUP BY
                                                        A .prov
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                MAX(ORG) ORG,
                                                PROPINSI_TO,
                                                SUM (QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG IN ('7000','5000')
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
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
                                                                                AND vkorg = '7000'
                                                                                GROUP BY
                                                                                        region,
                                                                                        tipe
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe
                                                                        WHERE
                                                                                co = '7000'
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
                                                                MAX(ORG) ORG,
                                                                PROPINSI_TO,
                                                                HARI,
                                                                SUM (QTY) qty
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                ORG IN ('7000','5000')
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN = '$bulan'
                                                        AND HARI <= '$hari'
                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                        GROUP BY
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
    function scodatasgBagNew($tahun,$bulan,$hari){
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
                                                        co = '7000'
                                                AND thn = '$tahun'
                                                AND bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                                AND A .tipe = '121-301'
                                                GROUP BY
                                                        A .prov
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                MAX(ORG) ORG,
                                                PROPINSI_TO,
                                                SUM (QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG IN ('7000','5000')
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND ITEM = '121-301'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
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
                                                                                AND vkorg = '7000'
                                                                                GROUP BY
                                                                                        region,
                                                                                        tipe
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe
                                                                        WHERE
                                                                                co = '7000'
                                                                        AND thn = '$tahun'
                                                                        AND bln = '$bulan'
                                                                        AND A .tipe = '121-301'
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
                                                                MAX(ORG) ORG,
                                                                PROPINSI_TO,
                                                                HARI,
                                                                SUM (QTY) qty
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                ORG IN ('7000','5000')
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN = '$bulan'
                                                        AND HARI <= '$hari'
                                                        AND ITEM = '121-301'
                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                        GROUP BY
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
    function scodatasgBulkNew($tahun,$bulan,$hari){
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query("SELECT
                                        TB0.PROV,
                                        TB8.NM_PROV,
                                        TB8.NM_PROV_1,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB2. REAL, 0) REAL,
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH,
                                        NVL (TB4.HARIAN_MAX, 0) HARIAN_MAX
                                FROM
                                        (
                                                SELECT DISTINCT
                                                        A .prov
                                                FROM
                                                        sap_t_rencana_sales_type A
                                                WHERE
                                                        co = '7000'
                                                AND thn = '$tahun'
                                                AND bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                        ) TB0
                                LEFT JOIN (
                                        SELECT
                                                A .prov,
                                                SUM (A .quantum) AS target
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                co = '7000'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND A .prov != '0001'
                                        AND A .prov != '1092'
                                        AND A .tipe = '121-302'
                                        GROUP BY
                                                A .prov
                                ) TB1 ON TB0.PROV = TB1.PROV
                                LEFT JOIN (
                                        SELECT
                                                MAX(ORG) ORG,
                                                PROPINSI_TO,
                                                SUM (QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG IN ('7000','5000')
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND ITEM = '121-302'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
                                                PROPINSI_TO
                                ) TB2 ON TB0.PROV = TB2.PROPINSI_TO
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
                                                                                AND vkorg = '7000'
                                                                                GROUP BY
                                                                                        region,
                                                                                        tipe
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe
                                                                        WHERE
                                                                                co = '7000'
                                                                        AND thn = '$tahun'
                                                                        AND bln = '$bulan'
                                                                        AND A .tipe = '121-302'
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
                                ) TB3 ON TB0.PROV = TB3.PROV
                                LEFT JOIN (
                                        SELECT
                                                org,
                                                PROPINSI_TO,
                                                MAX (qty) HARIAN_MAX
                                        FROM
                                                (
                                                        SELECT
                                                                MAX(ORG) ORG,
                                                                PROPINSI_TO,
                                                                HARI,
                                                                SUM (QTY) qty
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                ORG IN ('7000','5000')
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN = '$bulan'
                                                        AND HARI <= '$hari'
                                                        AND ITEM = '121-302'
                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                PROPINSI_TO,
                                                                HARI
                                                )
                                        GROUP BY
                                                ORG,
                                                PROPINSI_TO
                                ) TB4 ON TB0.PROV = TB4.PROPINSI_TO
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB0.prov = TB8.KD_PROV
                                ORDER BY
                                        TB0.PROV");
        return $data->result_array();
    }
    
    function scodatasg($tahun,$bulan,$hari){
        $data = $this->db->query("select tbm3.*, tbm4.target_realh, tbm5.harian_max from(
                select tbm1.*,tbm2.NM_PROV,tbm2.NM_PROV_1,tbm2.ID_REGION,tbm2.URUT_BARU  from (
                select tb1.*,nvl(tb2.real,0) as real from (
                select a.prov, sum(a.quantum) as target
                from sap_t_rencana_sales_type a                            
                where co = '7000' and thn = '$tahun' and bln = '$bulan' and a.prov!='0001' and a.prov!='1092'
                group by a.prov
                )tb1 left join (
                    select propinsi_to, sum(real) as real from(
                    select propinsi_to, sum(kwantumx) as real
                    from zreport_rpt_real
                    where        
                    to_char(tgl_cmplt,'YYYYMM')='".$tahun.$bulan."'
                    and ( (order_type <>'ZNL' and
                    (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
                    and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                    and sold_to like '0000000%'
                    group by propinsi_to
                    union
                    select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='7000' and LFART='ZLR' and
                    to_char(wadat_ist,'YYYYMM')='".$tahun.$bulan."'
                    and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                    and kunag like '0000000%'
                    group by vkbur
                    )
                    group by propinsi_to
                )tb2 on (tb1.prov=tb2.propinsi_to)
                )tbm1 left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)
                )tbm3 left join (
                    select prov,sum(target_realh) as target_realh from(
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
                        where budat like '".$tahun.$bulan."%' and vkorg = '7000'
                        group by region, tipe
                    )d on c.region = d.region and d.tipe = a.tipe
                    where co = '7000' and thn = '$tahun' and bln = '$bulan'
                    group by co, thn, bln, a.prov, c.budat
                    )
                    where budat <= '".$tahun.$bulan.$hari."'
                    ) group by prov
                )tbm4 on(tbm3.prov=tbm4.prov)
                left join (
                  select propinsi_to, max(real) as harian_max from (
                    select propinsi_to, to_char(tgl_cmplt,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                    from zreport_rpt_real
                    where to_char(tgl_cmplt,'YYYYMM')='".$tahun.$bulan."'
                      and ((order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) 
                        or (item_no like '121-302%' and order_type <>'ZNL')) 
                      and (plant <>'2490' or plant <>'7490') 
                      and com = '7000' 
                      and no_polisi <> 'S11LO' 
                      and sold_to like '0000000%'
                    group by propinsi_to, to_char(tgl_cmplt,'YYYYMMDD')
                    union
                    select vkbur as propinsi_to, to_char(wadat_ist,'YYYYMMDD') as tanggal, sum(ton) as real 
                    from ZREPORT_ONGKOSANGKUT_MOD 
                    where VKORG='7000' 
                      and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='".$tahun.$bulan."'
                      and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                      and kunag like '0000000%'
                    group by vkbur, to_char(wadat_ist,'YYYYMMDD'))
                    group by propinsi_to
                ) tbm5
                on tbm3.prov = tbm5.propinsi_to
                where (TARGET>0 or REAL>0)
                order by URUT_BARU asc");
        
        return $data->result_array();
    }
    function scodatasgBag($tahun,$bulan,$hari){
        $data = $this->db->query("select tbm3.*, nvl(tbm4.target_realh,0) target_realh, nvl(tbm5.harian_max,0) harian_max from(
                select tbm1.*,tbm2.NM_PROV,tbm2.NM_PROV_1,tbm2.ID_REGION,tbm2.URUT_BARU  from (
                select tb1.*,nvl(tb2.real,0) as real from (
                select a.prov, sum(a.quantum) as target
                from sap_t_rencana_sales_type a                            
                where co = '7000' and thn = '$tahun' and bln = '$bulan' 
                and a.prov!='0001' and a.prov!='1092' and a.tipe = '121-301'
                group by a.prov
                )tb1 left join (
                    select propinsi_to, sum(real) as real from(
                    select propinsi_to, sum(kwantumx) as real
                    from zreport_rpt_real
                    where        
                    to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                    and ( (order_type <>'ZNL' and
                    (item_no like '121-301%' and item_no <> '121-301-0240'))) and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                    and sold_to like '0000000%'
                    group by propinsi_to
                    union
                    select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='7000' and LFART='ZLR' and
                    to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                    and  ((matnr like '121-301%' and matnr <> '121-301-0240'))
                    and kunag like '0000000%'
                    group by vkbur
                    )
                    group by propinsi_to
                )tb2 on (tb1.prov=tb2.propinsi_to)
                )tbm1 left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)
                )tbm3 left join (
                    select prov,sum(target_realh) as target_realh from(
                    select * from (
                    select  a.prov, c.budat,
                    sum(a.quantum * (c.porsi/d.total_porsi)) as target_realh
                    from sap_t_rencana_sales_type a
                    left join zreport_m_provinsi b on a.prov = b.kd_prov
                    left join zreport_porsi_sales_region c on c.region=5
                                         and c.vkorg= a.co
                                         and c.budat like '$tahun$bulan%'
                                         and c.tipe = a.tipe
                    left join (
                        select region, tipe,  sum(porsi) as total_porsi
                        from zreport_porsi_sales_region
                        where budat like '$tahun$bulan%' and vkorg = '7000'
                        group by region, tipe
                    )d on c.region = d.region and d.tipe = a.tipe
                    where co = '7000' and thn = '$tahun' and bln = '09' and a.tipe = '121-301'
                    group by co, thn, bln, a.prov, c.budat
                    )
                    where budat <= '$tahun$bulan$hari'
                    ) group by prov
                )tbm4 on(tbm3.prov=tbm4.prov)
                left join(
                select propinsi_to, max(real) as harian_max from (
                    select propinsi_to, to_char(tgl_cmplt,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                    from zreport_rpt_real
                    where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                      and ((order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240'))) 
                      and (plant <>'2490' or plant <>'7490') 
                      and com = '7000' 
                      and no_polisi <> 'S11LO' 
                      and sold_to like '0000000%'
                    group by propinsi_to, to_char(tgl_cmplt,'YYYYMMDD')
                    union
                    select vkbur as propinsi_to, to_char(wadat_ist,'YYYYMMDD') as tanggal, sum(ton) as real 
                    from ZREPORT_ONGKOSANGKUT_MOD 
                    where VKORG='7000' 
                      and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                      and ((matnr like '121-301%' and matnr <> '121-301-0240'))
                      and kunag like '0000000%'
                    group by vkbur, to_char(wadat_ist,'YYYYMMDD'))
                    group by propinsi_to
                )tbm5
                on tbm3.prov = tbm5.propinsi_to
                where (TARGET>0 or REAL>0)
                order by URUT_BARU asc");
        return $data->result_array();
    }
    function scodatasgBulk($tahun,$bulan,$hari){
        $data = $this->db->query("select tbm3.*, nvl(tbm4.target_realh,0) target_realh, nvl(tbm5.harian_max,0) harian_max  from(
                select tbm1.*,tbm2.NM_PROV,tbm2.NM_PROV_1,tbm2.ID_REGION,tbm2.URUT_BARU  
                from (
                    select tb0.prov, nvl(tb1.target,0) target, nvl(tb2.real,0) as real 
                    from (
                        select distinct a.prov
                        from sap_t_rencana_sales_type a 
                        where co = '7000' and thn = '$tahun' and bln = '$bulan' 
                            and a.prov!='0001' and a.prov!='1092'
                )tb0 
                left join(
                    select a.prov, sum(a.quantum) as target
                    from sap_t_rencana_sales_type a 
                    where co = '7000' and thn = '$tahun' and bln = '$bulan' 
                        and a.prov!='0001' and a.prov!='1092' and a.tipe = '121-302'
                    group by a.prov
                )tb1
                on tb0.prov = tb1.prov
                left join (
                    select propinsi_to, sum(real) as real 
                    from(
                        select propinsi_to, sum(kwantumx) as real
                        from zreport_rpt_real
                        where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                            and ((item_no like '121-302%' and order_type <>'ZNL')) 
                            and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                            and sold_to like '0000000%'
                        group by propinsi_to
                        union
                        select vkbur as propinsi_to, sum(ton) as real 
                        from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='7000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                            and ((matnr like '121-302%')) and kunag like '0000000%'
                        group by vkbur
                    )
                    group by propinsi_to
                )tb2 on (tb1.prov=tb2.propinsi_to)
                )tbm1 
                left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)
                )tbm3 left join (
                    select prov,sum(target_realh) as target_realh from(
                    select * from (
                    select  a.prov, c.budat,
                    sum(a.quantum * (c.porsi/d.total_porsi)) as target_realh
                    from sap_t_rencana_sales_type a
                    left join zreport_m_provinsi b on a.prov = b.kd_prov
                    left join zreport_porsi_sales_region c on c.region=5
                                         and c.vkorg= a.co
                                         and c.budat like '$tahun$bulan%'
                                         and c.tipe = a.tipe
                    left join (
                        select region, tipe,  sum(porsi) as total_porsi
                        from zreport_porsi_sales_region
                        where budat like '$tahun$bulan%' and vkorg = '7000'
                        group by region, tipe
                    )d on c.region = d.region and d.tipe = a.tipe
                    where co = '7000' and thn = '$tahun' and bln = '$bulan' and a.tipe = '121-302'
                    group by co, thn, bln, a.prov, c.budat
                    )
                    where budat <= '$tahun$bulan$hari'
                    ) group by prov
                )tbm4 on(tbm3.prov=tbm4.prov)
                left join (
                  select propinsi_to, max(real) as harian_max from (
                    select propinsi_to, to_char(tgl_cmplt,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                    from zreport_rpt_real
                    where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                      and ((item_no like '121-302%' and order_type <>'ZNL')) 
                      and (plant <>'2490' or plant <>'7490') 
                      and com = '7000' 
                      and no_polisi <> 'S11LO' 
                      and sold_to like '0000000%'
                    group by propinsi_to, to_char(tgl_cmplt,'YYYYMMDD')
                    union
                    select vkbur as propinsi_to, to_char(wadat_ist,'YYYYMMDD') as tanggal, sum(ton) as real 
                    from ZREPORT_ONGKOSANGKUT_MOD 
                    where VKORG='7000' 
                      and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                      and ((matnr like '121-302%'))
                      and kunag like '0000000%'
                    group by vkbur, to_char(wadat_ist,'YYYYMMDD'))
                    group by propinsi_to
                ) tbm5
                on tbm3.prov = tbm5.propinsi_to
                --where (TARGET>0 or REAL>0)
                order by URUT_BARU asc");
        return $data->result_array();
    }
}