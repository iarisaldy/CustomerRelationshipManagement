<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class PetaPencapaian_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function scodatasg($tahun, $bulan, $hari) {
        $data = $this->db->query("select tbm3.*, tbm4.target_realh 
                from(
                  select tbm1.*,tbm2.NM_PROV
                  from (
                    select tb1.*,nvl(nvl(tb3.real_bag,0)+nvl(tb4.real_bulk,0),0) as real, nvl(tb3.real_bag,0) as real_bag, nvl(tb4.real_bulk,0) as real_bulk 
                    from (
                      select a.prov, sum(a.quantum) as target
                      from sap_t_rencana_sales_type a 
                      where co = '7000' and thn = '$tahun' and bln = '$bulan' and a.prov!='0001' and a.prov!='1092'
                      group by a.prov
                    )tb1 
                    left join (
                      select propinsi_to, sum(real) as real_bag 
                      from(
                        select propinsi_to, sum(kwantumx) as real
                        from zreport_rpt_real
                        where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                        and ( 
                          (order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) 
                          ) 
                        and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO' and sold_to like '0000000%'
                        group by propinsi_to
                        union
                        select vkbur as propinsi_to, sum(ton) as real 
                        from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='7000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                          and  ((matnr like '121-301%' and matnr <> '121-301-0240'))
                          and kunag like '0000000%'
                        group by vkbur
                      )
                      group by propinsi_to
                    ) tb3
                    on tb1.prov = tb3.propinsi_to
                    left join (
                      select propinsi_to, sum(real) as real_bulk 
                      from(
                        select propinsi_to, sum(kwantumx) as real
                        from zreport_rpt_real
                        where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                        and ( 
                          (order_type <>'ZNL' and (item_no like '121-302%' and order_type <>'ZNL')) 
                          ) 
                        and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO' and sold_to like '0000000%'
                        group by propinsi_to
                        union
                        select vkbur as propinsi_to, sum(ton) as real 
                        from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='7000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                          and  ((matnr like '121-302%'))
                          and kunag like '0000000%'
                        group by vkbur
                      )
                      group by propinsi_to
                    ) tb4
                    on tb1.prov = tb4.propinsi_to
                  )tbm1 
                  left join ZREPORT_M_PROVINSI tbm2 
                  on (tbm1.prov=tbm2.KD_PROV)
                )tbm3 
                left join (
                  select prov,sum(target_realh) as target_realh 
                  from(
                    select * from (
                      select  a.prov, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as target_realh
                      from sap_t_rencana_sales_type a
                      left join zreport_m_provinsi b on a.prov = b.kd_prov
                      left join zreport_porsi_sales_region c on c.region=5
                           and c.vkorg= a.co and c.budat like '$tahun$bulan%' and c.tipe = a.tipe
                      left join (
                        select region, tipe,  sum(porsi) as total_porsi
                        from zreport_porsi_sales_region
                        where budat like '$tahun$bulan%' and vkorg = '7000'
                        group by region, tipe
                      )d on c.region = d.region and d.tipe = a.tipe
                      where co = '7000' and thn = '$tahun' and bln = '$bulan'
                      group by co, thn, bln, a.prov, c.budat
                    )
                    where budat <= '$tahun$bulan$hari'
                  ) group by prov
                )tbm4 on(tbm3.prov=tbm4.prov)
                where (TARGET>0 or REAL>0)");
        return $data->result_array();
    }

    function scodatast($tahun, $bulan, $hari) {
        $target1 = "select prov,sum(target_realh) as target_realh from(
                                    select * from (
                                    select  a.prov, c.budat,
                                    sum(a.quantum * (c.porsi/d.total_porsi)) as target_realh
                                    from sap_t_rencana_sales_type a
                                    left join zreport_m_provinsi b on a.prov = b.kd_prov
                                    left join zreport_porsi_sales_region c on c.region=5
                                                         and c.vkorg= a.co
                                                         and c.budat like '" . $tahun . $bulan . "%'
                                                         and c.tipe = a.tipe
                                    left join (
                                        select region, tipe,  sum(porsi) as total_porsi
                                        from zreport_porsi_sales_region
                                        where budat like '" . $tahun . $bulan . "%' and vkorg = '4000'
                                        group by region, tipe
                                    )d on c.region = d.region and d.tipe = a.tipe
                                    where co = '4000' and thn = '$tahun' and bln = '$bulan'
                                    group by co, thn, bln, a.prov, c.budat
                                    )
                                    where budat <= '" . $tahun . $bulan . $hari . "'
                                    ) group by prov";

        $target2 = "select prov, sum(quantum) as target_realh
                    from zreport_target_harian_sales_st
                    where org = 4000 and budat <= '$tahun$bulan$hari'
                    group by prov";

        $query = "select tbm3.*, tbm4.target_realh from(
                select tbm1.*,tbm2.NM_PROV from (
                  select tb1.*,nvl((nvl(tb3.real_bag,0)+nvl(tb4.real_bulk,0)),0) as real, nvl(tb3.real_bag,0) as real_bag, nvl(tb4.real_bulk,0) as real_bulk from (
                    select a.prov, sum(a.quantum) as target from sap_t_rencana_sales_type a  
                    where co = '4000' and thn = '$tahun' and bln = '$bulan' and a.prov!='0001' and a.prov!='1092'
                    group by a.prov
                  )tb1 
                  left join (
                    select propinsi_to, sum(real) as real_bag from(
                      select propinsi_to, sum(kwantumx) as real from zreport_rpt_real_st
                      where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                        and ((order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240'))) 
                        and com = '4000' and no_polisi <> 'S11LO' and sold_to like '000000%'
                        and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                        and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                        and ORDER_TYPE<>'ZLFE'
                      group by propinsi_to
                      union
                            select vkbur as propinsi_to, sum(ton) as real 
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='4000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                              and  ((matnr like '121-301%' and matnr <> '121-301-0240'))
                              and kunnr not like '000000%'
                              and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                              and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                            group by vkbur
                            union
                            select ti.propinsi_to,sum(ti.KWANTUMX) as real
                            from ZREPORT_RPT_REAL_NON70_ST ti
                            where ti.ITEM_NO LIKE '121-301%'
                              and item_no <> '121-301-0240' and ti.COM='4000' and ti.ROUTE='ZR0001' and ti.STATUS in ('50')
                              and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                            group by ti.propinsi_to
                    ) 
                    group by propinsi_to
                  )tb3
                  on tb1.prov = tb3.propinsi_to
                  left join (
                    select propinsi_to, sum(real) as real_bulk from(
                      select propinsi_to, sum(kwantumx) as real from zreport_rpt_real_st
                      where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                        and ((order_type <>'ZNL' and (item_no like '121-302%' and order_type <>'ZNL'))) 
                        and com = '4000' and no_polisi <> 'S11LO' and sold_to like '000000%'
                        and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                        and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                        and ORDER_TYPE<>'ZLFE'
                      group by propinsi_to
                      union
                            select vkbur as propinsi_to, sum(ton) as real 
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='4000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                              and  ((matnr like '121-302%'))
                              and kunnr not like '000000%'
                              and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                              and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                            group by vkbur
                    )
                    group by propinsi_to
                  )tb4
                  on tb1.prov = tb4.propinsi_to
                )tbm1 
                left join ZREPORT_M_PROVINSI tbm2 
                on (tbm1.prov=tbm2.KD_PROV)
              )tbm3 
              left join (";
        if ($bulan == '09' && $tahun == '2016') {
            $query .= $target2;
        } else {
            $query .= $target1;
        }
        $query .= ")tbm4 on(tbm3.prov=tbm4.prov)
              where (TARGET>0 or REAL>0)";
        $data = $this->db->query($query);

        return $data->result_array();
    }

    function scodatasp($tahun, $bulan, $hari) {
        $data = $this->db->query("select tbm3.*, tbm4.target_realh 
                    from(
                      select tbm1.*,tbm2.NM_PROV,tbm2.NM_PROV_1,tbm2.ID_REGION,tbm2.URUT_BARU 
                      from (
                        select tb1.*,nvl(nvl(tb3.real_bag,0)+nvl(tb4.real_bulk,0),0) as real,nvl(tb3.real_bag,0) as real_bag,nvl(tb4.real_bulk,0) as real_bulk 
                        from (
                          select a.prov, sum(a.quantum) as target
                          from sap_t_rencana_sales_type a
                          where co = '3000' and thn = '$tahun' and bln = '$bulan' and a.prov!='0001' and a.prov!='1092'
                          group by a.prov
                        )tb1 
                        left join (
                          select propinsi_to, sum(real) as real_bag 
                          from(    
                            select vkbur as propinsi_to, sum(ton) as real 
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='3000' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan' and LFART <> 'ZNL'
                              and  ((matnr like '121-301%' and matnr <> '121-301-0240'))
                              and kunag not in ('0000040084','0000040147','0000040272') 
                            group by vkbur
                            union
                            select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='3000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                              and ((matnr like '121-301%' and matnr <> '121-301-0240')) 
                              and kunag not in ('0000040084','0000040147','0000040272') 
                            group by vkbur
                          )
                          group by propinsi_to
                        )tb3 
                        on (tb1.prov=tb3.propinsi_to)
                        left join (
                          select propinsi_to, sum(real) as real_bulk 
                          from(    
                            select vkbur as propinsi_to, sum(ton) as real 
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='3000' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan' and LFART <> 'ZNL'
                              and  ((matnr like '121-302%'))
                              and kunag not in ('0000040084','0000040147','0000040272') 
                            group by vkbur
                            union
                            select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='3000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                              and ((matnr like '121-302%')) 
                              and kunag not in ('0000040084','0000040147','0000040272') 
                            group by vkbur
                          )
                          group by propinsi_to
                        )tb4 
                        on (tb1.prov=tb4.propinsi_to)
                      )tbm1 left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)
                    )tbm3 
                    left join (
                      select prov,sum(target_realh) as target_realh 
                      from(
                        select * from (
                          select  a.prov, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as target_realh
                          from sap_t_rencana_sales_type a
                          left join zreport_m_provinsi b on a.prov = b.kd_prov
                          left join zreport_porsi_sales_region c on c.region=5
                            and c.vkorg= a.co and c.budat like '$tahun$bulan%' and c.tipe = a.tipe
                          left join (
                            select region, tipe,  sum(porsi) as total_porsi
                            from zreport_porsi_sales_region
                            where budat like '$tahun$bulan%' and VKORG = '3000'
                            group by region, tipe
                          )d on c.region = d.region and d.tipe = a.tipe
                          where co = '3000' and thn = '$tahun' and bln = '$bulan'
                          group by co, thn, bln, a.prov, c.budat
                        )
                        where budat <= '$tahun$bulan$hari'
                      ) group by prov
                    )tbm4 on(tbm3.prov=tbm4.prov)
                    where (TARGET>0 or REAL>0)
                    order by URUT_BARU asc");
        return $data->result_array();
    }

    function getProv() {
        $data = $this->db->query("SELECT KD_PROV, NM_PROV FROM ZREPORT_M_PROVINSI WHERE KD_PROV != '0001' AND KD_PROV != '1092'");
        return $data->result_array();
    }

    function scodatasg2($tahun, $bulan, $hari) {
        $data = $this->db->query("select tbm3.*, tbm4.target_realh, nvl(tbm5.harian_max,0) harian_max
                    from(
                      select tbm1.*,tbm2.NM_PROV  
                      from (
                        select tb1.*,nvl(nvl(tb3.real_bag,0)+nvl(tb4.real_bulk,0),0) as real, nvl(tb3.real_bag,0) as real_bag, nvl(tb4.real_bulk,0) as real_bulk 
                        from (
                          select a.prov, sum(a.quantum) as target
                          from sap_t_rencana_sales_type a 
                          where co = '7000' and thn = '$tahun' and bln = '$bulan' and a.prov!='0001' and a.prov!='1092'
                          group by a.prov
                        )tb1 
                        left join (
                          select propinsi_to, sum(real) as real_bag 
                          from(
                            select propinsi_to, sum(kwantumx) as real
                            from zreport_rpt_real
                            where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                            and ( 
                              (order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) 
                              ) 
                            and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO' and sold_to like '0000000%'
                            group by propinsi_to
                            union
                            select vkbur as propinsi_to, sum(ton) as real 
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='7000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                              and  ((matnr like '121-301%' and matnr <> '121-301-0240'))
                              and kunag like '0000000%'
                            group by vkbur
                          )
                          group by propinsi_to
                        ) tb3
                        on tb1.prov = tb3.propinsi_to
                        left join (
                          select propinsi_to, sum(real) as real_bulk 
                          from(
                            select propinsi_to, sum(kwantumx) as real
                            from zreport_rpt_real
                            where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                            and ( 
                              (order_type <>'ZNL' and (item_no like '121-302%' and order_type <>'ZNL')) 
                              ) 
                            and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO' and sold_to like '0000000%'
                            group by propinsi_to
                            union
                            select vkbur as propinsi_to, sum(ton) as real 
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='7000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                              and  ((matnr like '121-302%'))
                              and kunag like '0000000%'
                            group by vkbur
                          )
                          group by propinsi_to
                        ) tb4
                        on tb1.prov = tb4.propinsi_to
                      )tbm1 
                      left join ZREPORT_M_PROVINSI tbm2 
                      on (tbm1.prov=tbm2.KD_PROV)
                    )tbm3 
                    left join (
                      select prov,sum(target_realh) as target_realh 
                      from(
                        select * from (
                          select  a.prov, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as target_realh
                          from sap_t_rencana_sales_type a
                          left join zreport_m_provinsi b on a.prov = b.kd_prov
                          left join zreport_porsi_sales_region c on c.region=5
                               and c.vkorg= a.co and c.budat like '$tahun$bulan%' and c.tipe = a.tipe
                          left join (
                            select region, tipe,  sum(porsi) as total_porsi
                            from zreport_porsi_sales_region
                            where budat like '$tahun$bulan%' and vkorg = '7000'
                            group by region, tipe
                          )d on c.region = d.region and d.tipe = a.tipe
                          where co = '7000' and thn = '$tahun' and bln = '$bulan'
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
                        and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                        and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                        and kunag like '0000000%'
                      group by vkbur, to_char(wadat_ist,'YYYYMMDD'))
                      group by propinsi_to
                    ) tbm5
                    on tbm3.prov = tbm5.propinsi_to
                    where (TARGET>0 or REAL>0)");
        return $data->result_array();
    }

    function scodatast2($tahun, $bulan, $hari) {
        $target1 = "select prov,sum(target_realh) as target_realh from(
                                    select * from (
                                    select  a.prov, c.budat,
                                    sum(a.quantum * (c.porsi/d.total_porsi)) as target_realh
                                    from sap_t_rencana_sales_type a
                                    left join zreport_m_provinsi b on a.prov = b.kd_prov
                                    left join zreport_porsi_sales_region c on c.region=5
                                                         and c.vkorg= a.co
                                                         and c.budat like '" . $tahun . $bulan . "%'
                                                         and c.tipe = a.tipe
                                    left join (
                                        select region, tipe,  sum(porsi) as total_porsi
                                        from zreport_porsi_sales_region
                                        where budat like '" . $tahun . $bulan . "%' and vkorg = '4000'
                                        group by region, tipe
                                    )d on c.region = d.region and d.tipe = a.tipe
                                    where co = '4000' and thn = '$tahun' and bln = '$bulan'
                                    group by co, thn, bln, a.prov, c.budat
                                    )
                                    where budat <= '" . $tahun . $bulan . $hari . "'
                                    ) group by prov";

        $target2 = "select prov, sum(quantum) as target_realh
                    from zreport_target_harian_sales_st
                    where org = 4000 and budat <= '$tahun$bulan$hari'
                    group by prov";

        $query = "select tbm3.*, tbm4.target_realh, nvl(tbm5.harian_max,0) as harian_max 
                    from(
                      select tbm1.*,tbm2.NM_PROV 
                      from (
                        select tb1.*,nvl(nvl(tb3.real_bag,0)+nvl(tb4.real_bulk,0),0) as real, nvl(tb3.real_bag,0) as real_bag, nvl(tb4.real_bulk,0) as real_bulk 
                        from (
                          select a.prov, sum(a.quantum) as target
                          from sap_t_rencana_sales_type a  
                          where co = '4000' and thn = '$tahun' and bln = '$bulan' and a.prov!='0001' and a.prov!='1092'
                          group by a.prov
                        )tb1 
                        left join (
                          select propinsi_to, sum(real) as real_bag 
                          from(
                            select propinsi_to, sum(kwantumx) as real
                            from zreport_rpt_real_st
                            where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                              and ((order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240'))) 
                              and com = '4000' and no_polisi <> 'S11LO' and sold_to like '000000%'
                              and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                              and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                              and ORDER_TYPE<>'ZLFE'
                            group by propinsi_to
                            union
                            select vkbur as propinsi_to, sum(ton) as real 
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='4000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                              and  ((matnr like '121-301%' and matnr <> '121-301-0240'))
                              and kunnr not like '000000%'
                              and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                              and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                            group by vkbur
                            union
                            select ti.propinsi_to,sum(ti.KWANTUMX) as real
                            from ZREPORT_RPT_REAL_NON70_ST ti
                            where ti.ITEM_NO LIKE '121-301%'
                              and item_no <> '121-301-0240' and ti.COM='4000' and ti.ROUTE='ZR0001' and ti.STATUS in ('50')
                              and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                            group by ti.propinsi_to
                          )
                          group by propinsi_to
                        )tb3
                        on tb1.prov = tb3.propinsi_to
                        left join (
                          select propinsi_to, sum(real) as real_bulk 
                          from(
                            select propinsi_to, sum(kwantumx) as real
                            from zreport_rpt_real_st
                            where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                              and ((order_type <>'ZNL' and (item_no like '121-302%' and order_type <>'ZNL'))) 
                              and com = '4000' and no_polisi <> 'S11LO' and sold_to like '000000%'
                              and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                              and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                              and ORDER_TYPE<>'ZLFE'
                            group by propinsi_to
                            union
                            select vkbur as propinsi_to, sum(ton) as real 
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='4000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                              and  ((matnr like '121-302%'))
                              and kunnr not like '000000%'
                              and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                              and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                            group by vkbur
                          )
                          group by propinsi_to
                        )tb4
                        on tb1.prov = tb4.propinsi_to
                      )tbm1 
                      left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)
                    )tbm3 
                    left join (";
        if ($bulan == '09' && $tahun == '2016') {
            $query .= $target2;
        } else {
            $query .= $target1;
        }
        $query .= ")tbm4 on(tbm3.prov=tbm4.prov)
                    left join (
                    select propinsi_to, max(real) as harian_max 
                       from(
                         select propinsi_to, to_char(tgl_cmplt,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                         from zreport_rpt_real_st
                         where to_char(tgl_cmplt,'YYYYMM')='$tahun$bulan'
                           and ((order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%' and order_type <>'ZNL') ) 
                           and com = '4000' and no_polisi <> 'S11LO'
                           and sold_to like '000000%'
                           and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                           and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                           and ORDER_TYPE<>'ZLFE'
                         group by propinsi_to, to_char(tgl_cmplt,'YYYYMMDD')
                         union
                         select vkbur as propinsi_to, to_char(wadat_ist,'YYYYMMDD') as tanggal, sum(ton) as real 
                         from ZREPORT_ONGKOSANGKUT_MOD 
                         where VKORG='4000' and LFART='ZLR' 
                           and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                           and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                           and kunnr not like '000000%'
                           and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                           and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                         group by vkbur, to_char(wadat_ist,'YYYYMMDD')
                         union
                         select ti.propinsi_to, to_char(tgl_do,'YYYYMMDD') as tanggal, sum(ti.KWANTUMX) as real
                         from ZREPORT_RPT_REAL_NON70_ST ti
                         where ti.ITEM_NO LIKE '121-301%'
                           and to_char(tgl_do,'YYYYMM')='$tahun$bulan' 
                           and item_no <> '121-301-0240' and ti.COM='4000' and ti.ROUTE='ZR0001'
                           and ti.STATUS in ('50') and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                         group by ti.propinsi_to,to_char(tgl_do,'YYYYMMDD')
                       )
                       group by propinsi_to
                    )tbm5 on(tbm3.prov=tbm5.propinsi_to)
                    where (TARGET>0 or REAL>0)";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function scodatasp2($tahun, $bulan, $hari) {
        $data = $this->db->query("select tbm3.*, tbm4.target_realh, nvl(tbm5.harian_max,0) as harian_max 
                    from(
                      select tbm1.*,tbm2.NM_PROV
                      from (
                        select tb1.*,nvl(nvl(tb3.real_bag,0)+nvl(tb4.real_bulk,0),0) as real,nvl(tb3.real_bag,0) as real_bag,nvl(tb4.real_bulk,0) as real_bulk 
                        from (
                          select a.prov, sum(a.quantum) as target
                          from sap_t_rencana_sales_type a
                          where co = '3000' and thn = '$tahun' and bln = '$bulan' and a.prov!='0001' and a.prov!='1092'
                          group by a.prov
                        )tb1 
                        left join (
                          select propinsi_to, sum(real) as real_bag 
                          from(    
                            select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD 
                            where 
                              to_char(wadat_ist,'YYYYMM')='$tahun$bulan' 
                              and LFART <> 'ZNL'
                              and  (
                                (matnr like '121-301%' and matnr <> '121-301-0240')
                              )
                            and vkorg = '3000'
                            and kunag not in ('0000040084','0000040147','0000040272') 
                            group by vkbur
                            union
                            select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='3000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                              and ((matnr like '121-301%' and matnr <> '121-301-0240')) 
                              and kunag not in ('0000040084','0000040147','0000040272') 
                            group by vkbur
                          )
                          group by propinsi_to
                        )tb3 
                        on (tb1.prov=tb3.propinsi_to)
                        left join (
                          select propinsi_to, sum(real) as real_bulk 
                          from(    
                            select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD 
                            where 
                              to_char(wadat_ist,'YYYYMM')='$tahun$bulan' 
                              and LFART <> 'ZNL'
                              and  (
                                (matnr like '121-302%')
                              )
                            and vkorg = '3000'
                            and kunag not in ('0000040084','0000040147','0000040272') 
                            group by vkbur
                            union
                            select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='3000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan'
                              and ((matnr like '121-302%')) 
                              and kunag not in ('0000040084','0000040147','0000040272') 
                            group by vkbur
                          )
                          group by propinsi_to
                        )tb4 
                        on (tb1.prov=tb4.propinsi_to)
                      )tbm1 left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)
                    )tbm3 
                    left join (
                      select prov,sum(target_realh) as target_realh 
                      from(
                        select * from (
                          select  a.prov, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as target_realh
                          from sap_t_rencana_sales_type a
                          left join zreport_m_provinsi b on a.prov = b.kd_prov
                          left join zreport_porsi_sales_region c on c.region=5
                            and c.vkorg= a.co and c.budat like '$tahun$bulan%' and c.tipe = a.tipe
                          left join (
                            select region, tipe,  sum(porsi) as total_porsi
                            from zreport_porsi_sales_region
                            where budat like '$tahun$bulan%' and VKORG = '3000'
                            group by region, tipe
                          )d on c.region = d.region and d.tipe = a.tipe
                          where co = '3000' and thn = '$tahun' and bln = '$bulan'
                          group by co, thn, bln, a.prov, c.budat
                        )
                        where budat <= '$tahun$bulan$hari'
                      ) group by prov
                    )tbm4 on(tbm3.prov=tbm4.prov)
                    left join(
                        select propinsi_to, max(real) as harian_max 
                        from(    
                          select vkbur as propinsi_to, to_char(wadat_ist,'YYYYMMDD') as tanggal, sum(ton) as real 
                          from ZREPORT_ONGKOSANGKUT_MOD 
                          where VKORG='3000' and to_char(wadat_ist,'YYYYMM')='$tahun$bulan' 
                            and LFART <> 'ZNL' and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                          group by vkbur, to_char(wadat_ist,'YYYYMMDD')
                        )
                        group by propinsi_to
                      )tbm5
                      on tbm3.prov=tbm5.propinsi_to
                    where (TARGET>0 or REAL>0)");
        return $data->result_array();
    }

    function scodata($org, $tahun, $bulan, $hari) {
        $data = $this->db->query("SELECT
                                        TB1.PROV,
                                        TB1.TARGET,
                                        TB1. REAL,
                                        TB2.REAL_BAG,
                                        TB2.REAL_BULK,
                                        TB3.NM_PROV,
                                        TB4.TARGET_REALH
                                FROM
                                        (
                                                SELECT
                                                        PROPINSI PROV,
                                                        SUM (TARGET_RKAP) TARGET,
                                                        SUM (REALTO) REAL
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        COM = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PROPINSI NOT IN ('0001', '1092')
                                                AND TIPE != '121-200'
                                                GROUP BY
                                                        PROPINSI
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                PROPINSI PROV,
                                                NVL (BAG_REAL, 0) REAL_BAG,
                                                NVL (BULK_REAL, 0) REAL_BULK
                                        FROM
                                                (
                                                        SELECT
                                                                PROPINSI,
                                                                REALTO,
                                                                TIPE
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                COM = '$org'
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN = '$bulan'
                                                        AND PROPINSI NOT IN ('0001', '1092')
                                                        AND TIPE != '121-200'
                                                ) PIVOT (
                                                        SUM (REALTO) AS REAL FOR (TIPE) IN (
                                                                '121-301' AS BAG,
                                                                '121-302' AS BULK
                                                        )
                                                )
                                ) TB2 ON TB1.PROV = TB2.PROV
                                LEFT JOIN ZREPORT_M_PROVINSI TB3 ON TB1.PROV = TB3.KD_PROV
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
                                                                                AND vkorg = '$org'
                                                                                GROUP BY
                                                                                        region,
                                                                                        tipe
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe
                                                                        WHERE
                                                                                co = '$org'
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
                                ) TB4 ON TB1.PROV = TB4.PROV
                                WHERE (TB1.TARGET > 0 OR TB1.REAL >0)");

        return $data->result_array();
    }

    function maxhariansg($tahun, $bulan) {
        $data = $this->db->query("SELECT
                                        propinsi_to prov,
                                        NVL (MAX(REAL),0) AS harian_max
                                FROM
                                        (
                                                SELECT
                                                        propinsi_to,
                                                        TO_CHAR (tgl_cmplt, 'YYYYMMDD') AS tanggal,
                                                        SUM (kwantumx) AS REAL
                                                FROM
                                                        zreport_rpt_real
                                                WHERE
                                                        TO_CHAR (tgl_cmplt, 'YYYYMM') = '$tahun$bulan'
                                                AND (
                                                        (
                                                                order_type <> 'ZNL'
                                                                AND (
                                                                        item_no LIKE '121-301%'
                                                                        AND item_no <> '121-301-0240'
                                                                )
                                                        )
                                                        OR (
                                                                item_no LIKE '121-302%'
                                                                AND order_type <> 'ZNL'
                                                        )
                                                )
                                                AND (
                                                        plant <> '2490'
                                                        OR plant <> '7490'
                                                )
                                                AND com = '7000'
                                                AND no_polisi <> 'S11LO'
                                                AND sold_to LIKE '0000000%'
                                                GROUP BY
                                                        propinsi_to,
                                                        TO_CHAR (tgl_cmplt, 'YYYYMMDD')
                                                UNION
                                                        SELECT
                                                                vkbur AS propinsi_to,
                                                                TO_CHAR (wadat_ist, 'YYYYMMDD') AS tanggal,
                                                                SUM (ton) AS REAL
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '7000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$tahun$bulan'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                OR (matnr LIKE '121-302%')
                                                        )
                                                        AND kunag LIKE '0000000%'
                                                        GROUP BY
                                                                vkbur,
                                                                TO_CHAR (wadat_ist, 'YYYYMMDD')
                                        )
                                GROUP BY
                                        propinsi_to");
        return $data->result_array();
    }

    function maxhariansp($tahun, $bulan) {
        $data = $this->db->query("SELECT
                                        propinsi_to prov,
                                        NVL (MAX(REAL), 0) AS harian_max
                                FROM
                                        (
                                                SELECT
                                                        vkbur AS propinsi_to,
                                                        TO_CHAR (wadat_ist, 'YYYYMMDD') AS tanggal,
                                                        SUM (ton) AS REAL
                                                FROM
                                                        ZREPORT_ONGKOSANGKUT_MOD
                                                WHERE
                                                        VKORG = '3000'
                                                AND TO_CHAR (wadat_ist, 'YYYYMM') = '$tahun$bulan'
                                                AND LFART <> 'ZNL'
                                                AND (
                                                        (
                                                                matnr LIKE '121-301%'
                                                                AND matnr <> '121-301-0240'
                                                        )
                                                        OR (matnr LIKE '121-302%')
                                                )
                                                GROUP BY
                                                        vkbur,
                                                        TO_CHAR (wadat_ist, 'YYYYMMDD')
                                        )
                                GROUP BY
                                        propinsi_to");

        return $data->result_array();
    }

    function maxharianst($tahun, $bulan) {
        $data = $this->db->query("SELECT
                                        propinsi_to prov,
                                        NVL (MAX(REAL), 0) AS harian_max
                                FROM
                                        (
                                                SELECT
                                                        propinsi_to,
                                                        TO_CHAR (tgl_cmplt, 'YYYYMMDD') AS tanggal,
                                                        SUM (kwantumx) AS REAL
                                                FROM
                                                        zreport_rpt_real_st
                                                WHERE
                                                        TO_CHAR (tgl_cmplt, 'YYYYMM') = '$tahun$bulan'
                                                AND (
                                                        (
                                                                order_type <> 'ZNL'
                                                                AND (
                                                                        item_no LIKE '121-301%'
                                                                        AND item_no <> '121-301-0240'
                                                                )
                                                        )
                                                        OR (
                                                                item_no LIKE '121-302%'
                                                                AND order_type <> 'ZNL'
                                                        )
                                                )
                                                AND com = '4000'
                                                AND no_polisi <> 'S11LO'
                                                AND sold_to LIKE '000000%'
                                                AND SOLD_TO NOT IN (
                                                        '0000040084',
                                                        '0000040147',
                                                        '0000040272',
                                                        '0000000888'
                                                )
                                                AND SOLD_TO NOT IN (
                                                        '0000000835',
                                                        '0000000836',
                                                        '0000000837'
                                                ) --Pemakaian Sendiri
                                                AND ORDER_TYPE <> 'ZLFE'
                                                GROUP BY
                                                        propinsi_to,
                                                        TO_CHAR (tgl_cmplt, 'YYYYMMDD')
                                                UNION
                                                        SELECT
                                                                vkbur AS propinsi_to,
                                                                TO_CHAR (wadat_ist, 'YYYYMMDD') AS tanggal,
                                                                SUM (ton) AS REAL
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '4000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$tahun$bulan'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                OR (matnr LIKE '121-302%')
                                                        )
                                                        AND kunnr NOT LIKE '000000%'
                                                        AND kunag NOT IN (
                                                                '0000040084',
                                                                '0000040147',
                                                                '0000040272',
                                                                '0000000888'
                                                        )
                                                        AND kunag NOT IN (
                                                                '0000000835',
                                                                '0000000836',
                                                                '0000000837'
                                                        ) --Pemakaian Sendiri
                                                        GROUP BY
                                                                vkbur,
                                                                TO_CHAR (wadat_ist, 'YYYYMMDD')
                                                        UNION
                                                                SELECT
                                                                        ti.propinsi_to,
                                                                        TO_CHAR (tgl_do, 'YYYYMMDD') AS tanggal,
                                                                        SUM (ti.KWANTUMX) AS REAL
                                                                FROM
                                                                        ZREPORT_RPT_REAL_NON70_ST ti
                                                                WHERE
                                                                        ti.ITEM_NO LIKE '121-301%'
                                                                AND TO_CHAR (tgl_do, 'YYYYMM') = '$tahun$bulan'
                                                                AND item_no <> '121-301-0240'
                                                                AND ti.COM = '4000'
                                                                AND ti.ROUTE = 'ZR0001'
                                                                AND ti.STATUS IN ('50')
                                                                AND ti.no_transaksi NOT IN (
                                                                        SELECT
                                                                                G .no_transaksi
                                                                        FROM
                                                                                zreport_rpt_real_st G
                                                                        WHERE
                                                                                G .COM = '4000'
                                                                )
                                                                GROUP BY
                                                                        ti.propinsi_to,
                                                                        TO_CHAR (tgl_do, 'YYYYMMDD')
                                        )
                                GROUP BY
                                        propinsi_to");

        return $data->result_array();
    }

    function maxharianNew($org, $tahun, $bulan, $hari) {
        $data = $this->db->query("SELECT
                                        org,
                                        PROPINSI_TO PROV,
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
                                                                        ORG = '$org'
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
                                                                                \"org\" = '$org'
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
                                        PROPINSI_TO");
        //echo $this->db->last_query();
        return $data->result_array();
    }

    function scodatamv($org, $tahun, $bulan, $hari) {
        if ($org == '7000') {
            $orgQ = '7000,5000';
        } else {
            $orgQ = $org;
        }
        $tahunlalu = $tahun-1;
        $sql = "SELECT
                        TB1.PROV,
                        TB1.TARGET,
                        NVL (
                                (TB2.REAL_BAG + TB2.REAL_BULK),
                                0
                        ) REAL,
                        NVL (TB2.REAL_BAG, 0) REAL_BAG,
                        NVL (TB2.REAL_BULK, 0) REAL_BULK,
                        TB3.NM_PROV,
                        TB4.TARGET_REALH,
                        NVL (
                                (TB5.REAL_BAG + TB5.REAL_BULK),
                                0
                        ) REAL_THNLALU,
                        NVL (TB5.REAL_BAG, 0) REAL_BAG_THNLALU,
                        NVL (TB5.REAL_BULK, 0) REAL_BULK_THNLALU
                FROM
                        (
                                SELECT
                                        A .prov,
                                        SUM (A .quantum) AS target
                                FROM
                                        sap_t_rencana_sales_type A
                                WHERE
                                        co = '$org'
                                AND thn = '$tahun'
                                AND bln = '$bulan'
                                AND A .prov != '0001'
                                AND A .prov != '1092'
                                GROUP BY
                                        A .prov
                        ) TB1
                LEFT JOIN (
                        SELECT
                                PROV,
                                NVL (BAG_REAL, 0) REAL_BAG,
                                NVL (BULK_REAL, 0) REAL_BULK
                        FROM
                                (
                                        SELECT
                                                PROV,
                                                SUM (REALTO) REALTO,
                                                TIPE
                                        FROM
                                                (
                                                        SELECT
                                                                PROPINSI_TO PROV,
                                                                SUM (QTY) REALTO,
                                                                ITEM TIPE
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                org IN ($orgQ)
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND hari <= '$hari'
                                                        AND ITEM != '121-200'
                                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                                        GROUP BY
                                                                PROPINSI_TO,
                                                                ITEM
                                                        UNION
                                                                SELECT
                                                                        \"kd_prov\" PROV,
                                                                        SUM (\"qty\") REALTO,
                                                                        \"item\" TIPE
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"tahun\" = '$tahun'
                                                                AND \"bulan\" = '$bulan'
                                                                AND \"hari\" <= '$hari'
                                                                AND \"org\" = '$org'
                                                                AND \"kd_prov\" IS NOT NULL
                                                                AND \"item\" IS NOT NULL
                                                                GROUP BY
                                                                        \"kd_prov\",
                                                                        \"item\"
                                                )
                                        GROUP BY
                                                PROV,
                                                TIPE
                                ) PIVOT (
                                        SUM (REALTO) AS REAL FOR (TIPE) IN (
                                                '121-301' AS BAG,
                                                '121-302' AS BULK
                                        )
                                )
                ) TB2 ON TB1.PROV = TB2.PROV
                LEFT JOIN ZREPORT_M_PROVINSI TB3 ON TB1.PROV = TB3.KD_PROV
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
                                                                AND vkorg = '$org'
                                                                GROUP BY
                                                                        region,
                                                                        tipe
                                                        ) D ON c.region = D .region
                                                        AND D .tipe = A .tipe
                                                        WHERE
                                                                co = '$org'
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
                ) TB4 ON TB1.PROV = TB4.PROV
                LEFT JOIN (
                        SELECT
                                PROV,
                                NVL (BAG_REAL, 0) REAL_BAG,
                                NVL (BULK_REAL, 0) REAL_BULK
                        FROM
                                (
                                        SELECT
                                                PROV,
                                                SUM (REALTO) REALTO,
                                                TIPE
                                        FROM
                                                (
                                                        SELECT
                                                                PROPINSI_TO PROV,
                                                                SUM (QTY) REALTO,
                                                                ITEM TIPE
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                org IN ($orgQ)
                                                        AND tahun = '$tahunlalu'
                                                        AND bulan = '$bulan'
                                                        AND hari <= '$hari'
                                                        AND ITEM != '121-200'
                                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                                        GROUP BY
                                                                PROPINSI_TO,
                                                                ITEM
                                                        UNION
                                                                SELECT
                                                                        \"kd_prov\" PROV,
                                                                        SUM (\"qty\") REALTO,
                                                                        \"item\" TIPE
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"tahun\" = '$tahunlalu'
                                                                AND \"bulan\" = '$bulan'
                                                                AND \"hari\" <= '$hari'
                                                                AND \"org\" = '$org'
                                                                AND \"kd_prov\" IS NOT NULL
                                                                AND \"item\" IS NOT NULL
                                                                GROUP BY
                                                                        \"kd_prov\",
                                                                        \"item\"
                                                )
                                        GROUP BY
                                                PROV,
                                                TIPE
                                ) PIVOT (
                                        SUM (REALTO) AS REAL FOR (TIPE) IN (
                                                '121-301' AS BAG,
                                                '121-302' AS BULK
                                        )
                                )
                ) TB5 ON TB1.PROV = TB5.PROV

                ";
        //echo $sql;
        $data = $this->db->query($sql);
        //echo $this->db->last_query();
        return $data->result_array();
    }

    function scodatamvSum($org, $tahun, $bulan, $hari) {
        $sql = "SELECT
                        TB0.ORG,
                        NVL(TB1.RKAP,0) TARGET,
                        NVL(TB2. REAL,0) REAL,
                        NVL(TB3.TARGET_REALH,0) TARGET_REALH
                FROM
                (SELECT '$org' ORG FROM DUAL) TB0 LEFT JOIN 
                        (
                                SELECT
                                        CO ORG,
                                        SUM (QUANTUM) RKAP
                                FROM
                                        SAP_T_RENCANA_SALES_TYPE
                                WHERE
                                        THN = '$tahun'
                                AND BLN = '$bulan'
                                AND TIPE != '121-200'
                                AND PROV NOT IN ('1092', '0001')
                                AND CO = '$org'
                                GROUP BY
                                        CO
                        ) TB1 ON TB1.ORG = TB0.ORG
                LEFT JOIN (
                        SELECT
                                ORG,
                                SUM (REAL) REAL
                        FROM
                                (
                                        SELECT
                                                ORG,
                                                SUM (QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        AND ITEM != '121-200'
                                        AND ORG = '$org'
                                        GROUP BY
                                                ORG
                                        UNION
                                                SELECT
                                                        \"org\" ORG,
                                                        SUM (\"qty\") REAL
                                                FROM
                                                        ZREPORT_REAL_ST_ADJ
                                                WHERE
                                                        \"org\" = '$org'
                                                AND \"tahun\" = '$tahun'
                                                AND \"bulan\" = '$bulan'
                                                AND \"hari\" <= '$hari'
                                                GROUP BY
                                                        \"org\"
                                )
                        GROUP BY
                                ORG
                ) TB2 ON TB0.ORG = TB2.ORG
                LEFT JOIN (
                        SELECT
                                ORG,
                                SUM (TARGET_REALH) TARGET_REALH
                        FROM
                                (
                                        SELECT
                                                A .CO ORG,
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
                                                AND vkorg = '$org'
                                                GROUP BY
                                                        region,
                                                        tipe
                                        ) D ON c.region = D .region
                                        AND D .tipe = A .tipe
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND A .prov NOT IN ('1092', '0001')
                                        GROUP BY
                                                co,
                                                c.budat
                                )
                        WHERE
                                budat <= '$tahun$bulan$hari'
                        GROUP BY
                                ORG
                ) TB3 ON TB0.ORG = TB3.ORG";
        //echo $sql;
        $data = $this->db->query($sql);
        //echo $this->db->last_query();
        return $data->row_array();
    }

    function scodatamvSumTonasa($org, $tahun, $bulan, $hari) {
        $sql = "SELECT
                        TB0.ORG,
                        NVL(TB1.RKAP,0) TARGET,
                        NVL(TB2. REAL,0) REAL,
                        NVL(TB3.TARGET_REALH,0) TARGET_REALH
                FROM
                (SELECT '$org' ORG FROM DUAL) TB0 LEFT JOIN 
                        (
                                SELECT
                                        CO ORG,
                                        SUM (QUANTUM) RKAP
                                FROM
                                        SAP_T_RENCANA_SALES_TYPE
                                WHERE
                                        THN = '$tahun'
                                AND BLN = '$bulan'
                                AND TIPE != '121-200'
                                AND PROV NOT IN ('1092', '0001')
                                AND CO = '$org'
                                GROUP BY
                                        CO
                        ) TB1 ON TB1.ORG = TB0.ORG
                LEFT JOIN (
                        SELECT
                                ORG,
                                SUM (REAL) REAL
                        FROM
                                (
                                        SELECT
                                                ORG,
                                                SUM (QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        --AND ITEM != '121-200'
                                        AND ORG = '$org'
                                        GROUP BY
                                                ORG
                                        UNION
                                                SELECT
                                                        '4000' ORG,
                                                        SUM (\"qty\") REAL
                                                FROM
                                                        ZREPORT_REAL_ST_ADJ
                                                WHERE
                                                       
                                                 \"tahun\" = '$tahun'
                                                AND \"bulan\" = '$bulan'
                                                AND \"hari\" <= '$hari'
                                                GROUP BY
                                                        \"org\"
                                )
                        GROUP BY
                                ORG
                ) TB2 ON TB0.ORG = TB2.ORG
                LEFT JOIN (
                        SELECT
                                ORG,
                                SUM (TARGET_REALH) TARGET_REALH
                        FROM
                                (
                                        SELECT
                                                A .CO ORG,
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
                                                AND vkorg = '$org'
                                                GROUP BY
                                                        region,
                                                        tipe
                                        ) D ON c.region = D .region
                                        AND D .tipe = A .tipe
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND A .prov NOT IN ('1092', '0001')
                                        GROUP BY
                                                co,
                                                c.budat
                                )
                        WHERE
                                budat <= '$tahun$bulan$hari'
                        GROUP BY
                                ORG
                ) TB3 ON TB0.ORG = TB3.ORG";
        //echo $sql;
        $data = $this->db->query($sql);
        //echo $this->db->last_query();
        return $data->row_array();
    }

    function getChart($org, $prov, $tahun,$bulan) {

        $paramsCL = '';
        $paramsORG = '';

        if ($org == '7000') {
            $paramsORG = " IN ('7000', '5000') ";
        } else {
            $paramsORG = " = '$org' ";
        }

        if ($org != '4000') {
            $paramsCL = " AND ITEM != '121-200' ";
        }

       $data = $this->db->query("SELECT
                                tbm1.*, NM_PROV
                        FROM
                                (
                                        SELECT
                                                tb1.*, NVL (tb2. REAL, 0) AS REAL, NVL (tb2. BAG, 0) AS BAG, NVL (tb2. BULK, 0) AS BULK
                                        FROM
                                                (
                                                        SELECT
                                                                org,
                                                                prov,
                                                                tanggal,
                                                                SUM (prog) prog,
                                                                SUM (target) target
                                                        FROM
                                                                (
                                                                        SELECT
                                                                                *
                                                                        FROM
                                                                                (
                                                                                        SELECT
                                                                                                TO_CHAR (A .co) org,
                                                                                                prov,
                                                                                                SUBSTR (c.budat ,- 2) TANGGAL,
                                                                                                SUM (
                                                                                                        A .quantum * (c.porsi / D .total_porsi)
                                                                                                ) AS TARGET,
                                                                                                SUM (
                                                                                                        A .quantum * (c.porsi / D .total_porsi)
                                                                                                ) AS PROG
                                                                                        FROM
                                                                                                sap_t_rencana_sales_type A
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
                                                                                                AND vkorg = '$org'
                                                                                                GROUP BY
                                                                                                        region,
                                                                                                        tipe
                                                                                        ) D ON c.region = D .region
                                                                                        AND D .tipe = A .tipe
                                                                                        WHERE
                                                                                                co = '$org'
                                                                                        AND thn = '$tahun'
                                                                                        AND bln = '$bulan'
                                                                                        AND prov = '$prov' 
                                                                                        GROUP BY
                                                                                                co,
                                                                                                thn,
                                                                                                bln,
                                                                                                c.budat,
                                                                                                prov
                                                                                )
                                                                )
                                                        GROUP BY
                                                                org,
                                                                tanggal,
                                                                prov
                                                        ORDER BY
                                                                TANGGAL
                                                ) tb1
                                        LEFT JOIN (
                                                SELECT
                                                        MAX(ORG) ORG,
                                                        HARI TANGGAL,
                                                        SUM (QTY) REAL,
                                                        SUM (CASE WHEN ITEM = '121-301' THEN QTY ELSE 0 END) AS BAG,
                                                        SUM (CASE WHEN ITEM = '121-302' THEN QTY ELSE 0 END) AS BULK
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG $paramsORG
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PROPINSI_TO = '$prov'
                                                $paramsCL
                                                GROUP BY
                                                        HARI
                                        ) tb2 ON (tb1.ORG = tb2.ORG)
                                        AND (tb1.TANGGAL = tb2.tanggal)
                                ) tbm1
                        LEFT JOIN ZREPORT_M_PROVINSI ON TBM1.PROV = ZREPORT_M_PROVINSI.KD_PROV
                        WHERE
                                (TARGET > 0 OR REAL > 0)
                        ORDER BY
                                tanggal")->result_array();
     //  echo $this->db->last_query();
        return $data;
    }

}
