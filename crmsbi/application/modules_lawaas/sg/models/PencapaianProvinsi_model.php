<?php

if (!defined('BASEPATH'))
    exit('NO DIRECT SCRIPT ACCESS ALLOWED');

class PencapaianProvinsi_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function scodatasgNew($tahun, $bulan, $hari) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query("SELECT
                                        TB1.PROV,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB2. REAL, 0) REAL,
                                        TB8.NM_PROV,
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH,
                                        NVL (TB4.HARIAN_MAX, 0) HARIAN_MAX,
                                        NVL (TB6.RKAP_MS, 0) RKAP_MS,
                                        NVL (TB9.TARGET_REVENUE, 0) TARGET_REVENUE,
                                        NVL (TB10.REAL_REVENUE, 0) REAL_REVENUE,
                                        CASE TB7.DEMAND_HARIAN
                                WHEN 0 THEN
                                        0
                                ELSE
                                        NVL (
                                                (
                                                        (TB2. REAL / TB7.DEMAND_HARIAN) * 100
                                                ),
                                                0
                                        )
                                END AS MARKETSHARE
                                FROM
                                        (
                                                SELECT
                                                        A .prov,
                                                        SUM (A .quantum) AS target
                                                FROM
                                                        sap_t_rencana_sales_type A
                                                WHERE
                                                        co IN ('7000','5000')
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
                                                                                        vkorg,
                                                                                        region,
                                                                                        tipe,
                                                                                        SUM (porsi) AS total_porsi
                                                                                FROM
                                                                                        zreport_porsi_sales_region
                                                                                WHERE
                                                                                        budat LIKE '$tahun$bulan%'
                                                                                AND vkorg IN ('7000','5000')
                                                                                GROUP BY
                                                                                        region,
                                                                                        tipe,
                                                                                        vkorg
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe AND D.vkorg = A.co
                                                                        WHERE
                                                                                co IN ('7000','5000')
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
                                                MAX(ORG) ORG,
                                                PROPINSI_TO,
                                                MAX (QTY) HARIAN_MAX
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
                                ) TB4 ON TB1.PROV = TB4.PROPINSI_TO
                                LEFT JOIN (
                                        SELECT
                                                PROPINSI,
                                                QTY RKAP_MS
                                        FROM
                                                ZREPORT_MS_RKAPMS
                                        WHERE
                                                KODE_PERUSAHAAN = '110'
                                        AND THN = '$tahun'
                                        AND STATUS = '0'
                                ) TB6 ON TB1.PROV = TB6.PROPINSI
                                LEFT JOIN (
                                        SELECT
                                                TB1.KD_PROV,
                                                (
                                                        tb1.qty * tb2.porsi / tb3.porsi_total
                                                ) DEMAND_HARIAN
                                        FROM
                                                (
                                                        SELECT
                                                                KD_PROV,
                                                                SUM (qty) qty
                                                        FROM
                                                                ZREPORT_SCM_DEMAND_PROVINSI
                                                        WHERE
                                                                tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        GROUP BY
                                                                KD_PROV
                                                ) tb1
                                        LEFT JOIN (
                                                SELECT
                                                        vkorg org,
                                                        SUM (porsi) porsi
                                                FROM
                                                        zreport_porsi_sales_region c
                                                WHERE
                                                        c.region = 5
                                                AND c.vkorg = '7000'
                                                AND c.budat LIKE '$tahun$bulan%'
                                                AND c.budat <= '$tahun$bulan$hari'
                                                GROUP BY
                                                        VKORG
                                        ) tb2 ON TB2.org = '7000'
                                        LEFT JOIN (
                                                SELECT
                                                        vkorg org,
                                                        SUM (porsi) porsi_total
                                                FROM
                                                        zreport_porsi_sales_region c
                                                WHERE
                                                        c.region = 5
                                                AND c.vkorg = '7000'
                                                AND c.budat LIKE '$tahun$bulan%'
                                                GROUP BY
                                                        VKORG
                                        ) tb3 ON TB2.org = tb3.org
                                ) TB7 ON TB1.PROV = TB7.KD_PROV
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN (
	SELECT
		prov,
		SUM (TARGET_REVENUE) AS TARGET_REVENUE
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
							A .revenue * (c.porsi / D .total_porsi)
						) AS target_revenue
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
                                ) TB9 ON TB1.PROV = TB9.PROV
                                LEFT JOIN (
                                        SELECT
                                        VKBUR prov,
                                        SUM (REVENUE) REAL_REVENUE
                                FROM
                                        MV_REVENUE
                                WHERE
                                        VKORG IN ('7000','5000')
                                AND VKBUR NOT IN ('0001', '1092')
                                AND MATERIAL != '121-200'
                                AND TO_CHAR (BUDAT, 'yyyymm') = '$tahun$bulan'
                                AND TO_CHAR (BUDAT, 'dd') <= '$hari'
                                GROUP BY
                                        VKBUR
                                ) TB10 ON TB1.PROV = TB10.PROV
                                ORDER BY
                                        TB1.PROV");
       
        return $data->result_array();
    }

    function scodatasg($tahun, $bulan, $hari) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $harik = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $harik = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query("select tbm3.*, tbm4.target_realh, tbm7.rkap_ms, case tbm6.demand_harian when 0 then 0 else nvl(((tbm3.real/tbm6.demand_harian)*100),0) end as marketshare
            from(
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
                    to_char(tgl_cmplt,'YYYYMM')='" . $tahun . $bulan . "'
                    and ( (order_type <>'ZNL' and
                    (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
                    and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                    and sold_to like '0000000%'
                    group by propinsi_to
                    union
                    select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='7000' and LFART='ZLR' and
                    to_char(wadat_ist,'YYYYMM')='" . $tahun . $bulan . "'
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
                                         and c.budat like '" . $tahun . $bulan . "%'
                                         and c.tipe = a.tipe
                    left join (
                        select region, tipe,  sum(porsi) as total_porsi
                        from zreport_porsi_sales_region
                        where budat like '" . $tahun . $bulan . "%' and vkorg = '7000'
                        group by region, tipe
                    )d on c.region = d.region and d.tipe = a.tipe
                    where co = '7000' and thn = '$tahun' and bln = '$bulan'
                    group by co, thn, bln, a.prov, c.budat
                    )
                    where budat <= '" . $tahun . $bulan . $hari . "'
                    ) group by prov
                )tbm4 on(tbm3.prov=tbm4.prov)
                left join (
                    SELECT
                            TB1.KD_PROV,
                            (
                                    tb1.qty * tb2.porsi / tb3.porsi_total
                            ) DEMAND_HARIAN
                    FROM
                            (
                                    SELECT
                                            --'7000' org,
                                            KD_PROV,
                                            SUM (qty) qty
                                    FROM
                                            ZREPORT_SCM_DEMAND_PROVINSI
                                    WHERE
                                            tahun = '$tahun'
                                    AND bulan = '$bulan'
                                    GROUP BY
                                            KD_PROV
                            ) tb1
                    LEFT JOIN (
                            SELECT
                                    vkorg org,
                                    SUM (porsi) porsi
                            FROM
                                    zreport_porsi_sales_region c
                            WHERE
                                    c.region = 5
                            AND c.vkorg = '7000'
                            AND c.budat LIKE '$tahun$bulan%'
                            AND c.budat <= '$tahun$bulan$harik'
                            GROUP BY
                                    VKORG
                    ) tb2 ON TB2.org = '7000'
                    LEFT JOIN (
                            SELECT
                                    vkorg org,
                                    SUM (porsi) porsi_total
                            FROM
                                    zreport_porsi_sales_region c
                            WHERE
                                    c.region = 5
                            AND c.vkorg = '7000'
                            AND c.budat LIKE '$tahun$bulan%'
                            GROUP BY
                                    VKORG
                    ) tb3 ON TB2.org = tb3.org
                )tbm6 on tbm3.prov = tbm6.kd_prov
                LEFT JOIN (
                        SELECT
                                PROPINSI,
                                QTY RKAP_MS
                        FROM
                                ZREPORT_MS_RKAPMS
                        WHERE
                                KODE_PERUSAHAAN = '110'
                        AND THN = '$tahun'
                        AND STATUS = '0'
                ) TBM7 ON TBM7.PROPINSI = TBM3.PROV
                where (tbm3.TARGET>0 or tbm3.REAL>0)
                order by URUT_BARU asc");

        return $data->result_array();
    }

    function scodatasgBagNew($tahun, $bulan, $hari) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query("SELECT
                                        TB1.PROV,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB2. REAL, 0) REAL,
                                        TB8.NM_PROV,
                                        TB8.NM_PROV_1,
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH,
                                        TB5.NAMA_KABIRO
                                FROM
                                        (
                                                SELECT
                                                        A .prov,
                                                        SUM (A .quantum) AS target
                                                FROM
                                                        sap_t_rencana_sales_type A
                                                WHERE
                                                        co IN ('7000','5000')
                                                AND thn = '$tahun'
                                                AND bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                                AND A .TIPE = '121-301'
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
                                        AND ITEM = '121-301'
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
                                                                                        vkorg,
                                                                                        region,
                                                                                        tipe,
                                                                                        SUM (porsi) AS total_porsi
                                                                                FROM
                                                                                        zreport_porsi_sales_region
                                                                                WHERE
                                                                                        budat LIKE '$tahun$bulan%'
                                                                                AND vkorg IN ('7000','5000')
                                                                                GROUP BY
                                                                                        region,
                                                                                        tipe,
                                                                                        vkorg
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe AND A.co = D.vkorg
                                                                        WHERE
                                                                                co IN ('7000','5000')
                                                                        AND thn = '$tahun'
                                                                        AND bln = '$bulan'
                                                                        AND A .TIPE = '121-301'
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
                                                tb5.id_prov PROV,
                                                tb6.nama_kabiro
                                        FROM
                                                ZREPORT_SCM_KABIRO_SALES tb5
                                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                                        WHERE
                                                TB5.ORG = '7000'
                                ) TB5 ON TB1.PROV = TB5.PROV
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                ORDER BY
                                        TB1.PROV");
        return $data->result_array();
    }

    function scodatasgBag($tahun, $bulan, $hari) {
        $data = $this->db->query("select tbm3.*, nvl(tbm4.target_realh,0) target_realh, tbm5.nama_kabiro from(
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
                    where co = '7000' and thn = '$tahun' and bln = '$bulan' and a.tipe = '121-301'
                    group by co, thn, bln, a.prov, c.budat
                    )
                    where budat <= '$tahun$bulan$hari'
                    ) group by prov
                )tbm4 on(tbm3.prov=tbm4.prov)
                left join (
                    select tb5.id_region, tb6.nama_kabiro
                    from ZREPORT_SCM_KABIRO_SALES tb5 
                    left join ZREPORT_SCM_M_KABIRO tb6
                    on tb5.id_kabiro = tb6.id_kabiro
                    where item_no = '121-301' and TB5.ORG = '7000'
                ) tbm5 on tbm3.id_region = tbm5.id_region
                where (TARGET>0 or REAL>0)
                order by URUT_BARU asc");
        return $data->result_array();
    }

    function scodatasgBulk($tahun, $bulan, $hari) {
        $data = $this->db->query("select tbm3.*, nvl(tbm4.target_realh,0) target_realh, tbm5.nama_kabiro from(
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
                    select tb5.id_region, tb6.nama_kabiro, tb5.item_no
                    from ZREPORT_SCM_KABIRO_SALES tb5 
                    left join ZREPORT_SCM_M_KABIRO tb6
                    on tb5.id_kabiro = tb6.id_kabiro
                    where tb5.item_no = '121-302' and TB5.ORG = '7000'
                ) tbm5 on tbm5.item_no = '121-302'
                --where (TARGET>0 or REAL>0)
                order by URUT_BARU asc");
        return $data->result_array();
    }

    function scodatasgBulkNew($tahun, $bulan, $hari) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query("SELECT
                                        TB0.PROV,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB2. REAL, 0) REAL,
                                        TB8.NM_PROV,
                                        TB8.NM_PROV_1,
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH,
                                        TB4.NAMA_KABIRO
                                FROM
                                        (
                                                SELECT DISTINCT
                                                        A .prov
                                                FROM
                                                        sap_t_rencana_sales_type A
                                                WHERE
                                                        co IN ('7000','5000')
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
                                                co IN ('7000','5000')
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
                                                MAX(ORG)  ORG,
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
                                                                                        vkorg,
                                                                                        region,
                                                                                        tipe,
                                                                                        SUM (porsi) AS total_porsi
                                                                                FROM
                                                                                        zreport_porsi_sales_region
                                                                                WHERE
                                                                                        budat LIKE '$tahun$bulan%'
                                                                                AND vkorg IN ('7000','5000')
                                                                                GROUP BY
                                                                                        vkorg,
                                                                                        region,
                                                                                        tipe
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe AND A.co = D.vkorg
                                                                        WHERE
                                                                                co IN ('7000','5000')
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
                                                tb5.id_region,
                                                tb6.nama_kabiro,
                                                tb5.item_no
                                        FROM
                                                ZREPORT_SCM_KABIRO_SALES tb5
                                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                                        WHERE
                                                tb5.item_no = '121-302'
                                        AND TB5.ORG = '7000'
                                ) TB4 ON TB4.item_no = '121-302'
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB0.prov = TB8.KD_PROV
                                ORDER BY
                                        TB0.PROV");
        return $data->result_array();
    }

    function getChartBagNew($tahun, $bulan, $hari) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query("SELECT
                                        ID_KABIRO,
                                        NAMA_KABIRO,
                                        SUM (TARGET) TARGET,
                                        SUM (REAL) REAL,
                                        SUM (TARGET_REALH) TARGET_REALH
                                FROM
                                        (
                                                SELECT
                                                        TB1.PROV,
                                                        NVL (TB1.TARGET, 0) TARGET,
                                                        NVL (TB2. REAL, 0) REAL,
                                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH,
                                                        TB4.ID_KABIRO,
                                                        TB4.NAMA_KABIRO
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
                                                                AND A .TIPE = '121-301'
                                                                GROUP BY
                                                                        A .prov
                                                        ) TB1
                                                LEFT JOIN (
                                                        SELECT
                                                                MAX(ORG),
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
                                                                                        AND A .TIPE = '121-301'
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
                                                                tb5.id_prov PROV,
                                                                tb6.ID_KABIRO,
                                                                tb6.nama_kabiro
                                                        FROM
                                                                ZREPORT_SCM_KABIRO_SALES tb5
                                                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                                                        WHERE
                                                                TB5.ORG = '7000' AND tb5.ITEM_NO = '121-301'
                                                ) TB4 ON TB1.PROV = TB4.PROV
                                        )
                                GROUP BY
                                        ID_KABIRO,
                                        NAMA_KABIRO
                                ORDER BY
                                        ID_KABIRO");
        return $data->result_array();
    }

    function getChartBag($tahun, $bulan, $hari) {
        $data = $this->db->query("select id_kabiro, nama_kabiro, sum(target) target, sum(target_realh) target_realh, sum(real) real from(
                select tbm1.*,tbm2.ID_REGION, tbm3.target_realh, tbm4.id_kabiro, tbm4.nama_kabiro from (
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
                left join (
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
                    where co = '7000' and thn = '$tahun' and bln = '$bulan' and a.tipe = '121-301'
                    group by co, thn, bln, a.prov, c.budat
                    )
                    where budat <= '$tahun$bulan$hari'
                    ) group by prov
                ) tbm3
                on tbm1.prov = tbm3.prov
                left join (
                    select tb5.id_region, tb5.id_kabiro, tb6.nama_kabiro
                    from ZREPORT_SCM_KABIRO_SALES tb5 
                    left join ZREPORT_SCM_M_KABIRO tb6
                    on tb5.id_kabiro = tb6.id_kabiro
                    where item_no = '121-301' and TB5.ORG = '7000'
                ) tbm4 on tbm2.id_region = tbm4.id_region
            )group by id_kabiro, nama_kabiro");
        return $data->result_array();
    }

    function getChartBulkNew($tahun, $bulan, $hari) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query("SELECT
                                        TARGET,
                                        REAL,
                                        TARGET_REALH,
                                        (
                                                SELECT
                                                        tb6.nama_kabiro
                                                FROM
                                                        ZREPORT_SCM_KABIRO_SALES tb5
                                                LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                                                WHERE
                                                        item_no = '121-302'
                                                AND TB5.ORG IN ('7000','5000')
                                        ) nama_kabiro
                                FROM
                                        (
                                                SELECT
                                                        SUM (TARGET) TARGET,
                                                        SUM (REAL) REAL,
                                                        SUM (TARGET_REALH) TARGET_REALH
                                                FROM
                                                        (
                                                                SELECT
                                                                        TB1.PROV,
                                                                        NVL (TB1.TARGET, 0) TARGET,
                                                                        NVL (TB2. REAL, 0) REAL,
                                                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH
                                                                FROM
                                                                        (
                                                                                SELECT
                                                                                        A .prov,
                                                                                        SUM (A .quantum) AS target
                                                                                FROM
                                                                                        sap_t_rencana_sales_type A
                                                                                WHERE
                                                                                        co IN ('7000','5000')
                                                                                AND thn = '$tahun'
                                                                                AND bln = '$bulan'
                                                                                AND A .prov != '0001'
                                                                                AND A .prov != '1092'
                                                                                AND A .TIPE = '121-302'
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
                                                                        AND ITEM = '121-302'
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
                                                                                                                        vkorg,
                                                                                                                        region,
                                                                                                                        tipe,
                                                                                                                        SUM (porsi) AS total_porsi
                                                                                                                FROM
                                                                                                                        zreport_porsi_sales_region
                                                                                                                WHERE
                                                                                                                        budat LIKE '$tahun$bulan%'
                                                                                                                AND vkorg IN ('7000','5000')
                                                                                                                GROUP BY
                                                                                                                        vkorg,
                                                                                                                        region,
                                                                                                                        tipe
                                                                                                        ) D ON c.region = D .region
                                                                                                        AND D .tipe = A .tipe AND D.vkorg = A.co
                                                                                                        WHERE
                                                                                                                co IN ('7000','5000')
                                                                                                        AND thn = '$tahun'
                                                                                                        AND bln = '$bulan'
                                                                                                        AND A .TIPE = '121-302'
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
                                                        )
                                        )");
        return $data->result_array();
    }

    function getChartBulk($tahun, $bulan, $hari) {
        $data = $this->db->query("select target, real, target_realh, (select tb6.nama_kabiro
                    from ZREPORT_SCM_KABIRO_SALES tb5 
                    left join ZREPORT_SCM_M_KABIRO tb6
                    on tb5.id_kabiro = tb6.id_kabiro
                    where item_no = '121-302' and TB5.ORG = '7000') nama_kabiro from (select sum(target) target, sum(real) real, sum(target_realh) target_realh from (select tbm1.*,tbm2.NM_PROV,tbm2.NM_PROV_1,tbm2.ID_REGION,tbm2.URUT_BARU  
                from (
                    select tb0.prov, nvl(tb1.target,0) target, nvl(tb2.real,0) as real, nvl(tb3.target_realh,0) as target_realh  
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
                left join (
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
                )tb3
                on tb1.prov = tb3.prov
                )tbm1 
                left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)))");
        return $data->result_array();
    }

    function getDemandNasional($tahun, $bulan, $hari) {
        $data = $this->db->query("SELECT
                                        (
                                                tb1.qty * tb2.porsi / tb3.porsi_total
                                        ) demand_nasional
                                FROM
                                        (
                                                SELECT
                                                        '7000' org,
                                                        SUM (qty) qty
                                                FROM
                                                        ZREPORT_SCM_DEMAND_PROVINSI
                                                WHERE
                                                        tahun = '$tahun'
                                                AND bulan = '$bulan'
                                        ) tb1
                                LEFT JOIN (
                                        SELECT
                                                vkorg org,
                                                SUM (porsi) porsi
                                        FROM
                                                zreport_porsi_sales_region c
                                        WHERE
                                                c.region = 5
                                        AND c.vkorg = '7000'
                                        AND c.budat LIKE '$tahun$bulan%'
                                        AND c.budat <= '$tahun$bulan$hari'
                                        GROUP BY
                                                VKORG
                                ) tb2 ON TB2.org = '7000'
                                LEFT JOIN (
                                        SELECT
                                                vkorg org,
                                                SUM (porsi) porsi_total
                                        FROM
                                                zreport_porsi_sales_region c
                                        WHERE
                                                c.region = 5
                                        AND c.vkorg = '7000'
                                        AND c.budat LIKE '$tahun$bulan%'
                                        GROUP BY
                                                VKORG
                                ) tb3 ON TB2.org = tb3.org");
        return $data->row_array();
    }

    function getRKAPMS($tahun) {
        $this->db->select('TARGET');
        $this->db->where('KODE_PERUSAHAAN', '110');
        $this->db->where('TAHUN', $tahun);
        $data = $this->db->get('ZREPORT_MS_RKAP');
        return $data->row_array();
    }

    function scodatamvSum($org, $tahun, $bulan, $hari) {

        if ($org == '7000') {
            $orgparams = "ORG IN (7000,5000)";
            $orgparams2 = "\"org\" IN (7000,5000)";
        } else {
            $orgparams = "ORG = '{$org}'";
            $orgparams2 = "\"org\" = '{$org}'";
        }

        $sql = "SELECT
                        TB1.ORG,
                        NVL(TB1.RKAP,0) TARGET,
                        NVL(TB2. REAL,0) REAL,
                        NVL(TB3.TARGET_REALH,0) TARGET_REALH
                FROM
                        (
                                SELECT
                                        MAX(CO) ORG,
                                        SUM (QUANTUM) RKAP
                                FROM
                                        SAP_T_RENCANA_SALES_TYPE
                                WHERE
                                        THN = '$tahun'
                                AND BLN = '$bulan'
                                AND TIPE != '121-200'
                                AND PROV NOT IN ('1092', '0001')
                                AND CO IN ('7000','5000')
                               
                        ) TB1
                LEFT JOIN (
                        SELECT
                                MAX(ORG) ORG,
                                SUM (QTY) REAL
                        FROM
                                ZREPORT_SCM_REAL_SALES
                        WHERE
                                TAHUN = '$tahun'
                        AND BULAN = '$bulan'
                        AND HARI <= '$hari'
                        AND PROPINSI_TO NOT IN ('1092', '0001')
                        AND ITEM != '121-200'
                        AND --ORG = '$org'
                        $orgparams
                        
                ) TB2 ON TB1.ORG = TB2.ORG
                LEFT JOIN (
                        SELECT
                                MAX(ORG) ORG,
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
                                                        vkorg,
                                                        region,
                                                        tipe,
                                                        SUM (porsi) AS total_porsi
                                                FROM
                                                        zreport_porsi_sales_region
                                                WHERE
                                                        budat LIKE '$tahun$bulan%'
                                                AND vkorg IN ('7000','5000')
                                                GROUP BY
                                                        vkorg,
                                                        region,
                                                        tipe
                                        ) D ON c.region = D .region
                                        AND D .tipe = A .tipe AND A.co = D.vkorg
                                        WHERE
                                                co IN ('7000','5000')
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND A .prov NOT IN ('1092', '0001')
                                        GROUP BY
                                                co,
                                                c.budat
                                )
                        WHERE
                                budat <= '$tahun$bulan$hari'
                        
                ) TB3 ON TB1.ORG = TB3.ORG";
        //echo $sql;
        $data = $this->db->query($sql);
        return $data->row_array();
    }

    public function RevenuePerKabiro($tahun, $bulan, $hari) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $sql = "SELECT
                        ID_KABIRO,
                        MAX (NAMA_KABIRO) NAMA_KABIRO,
                        SUM (TARGET_REVENUE) TARGET_REVENUE,
                        SUM (TARGET_REVENUE_SDK) TARGET_REVENUE_SDK,
                        SUM (REAL_REVENUE) REAL_REVENUE,
                        SUM (REAL_REVENUE) - SUM (TARGET_REVENUE) SELISIH
                FROM
                        (
                                SELECT
                                        PROV,
                                        SUM (CASE WHEN budat<='$tahun$bulan$hari' THEN target_revenue ELSE 0 END) TARGET_REVENUE_SDK,
                                        SUM (target_revenue) TARGET_REVENUE
                                FROM
                                        (
                                                SELECT
                                                        A .prov,
                                                        c.budat,
                                                        SUM (
                                                                A .revenue * (c.porsi / D .total_porsi)
                                                        ) AS target_revenue
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
                                                AND A .TIPE = '121-301'
                                                GROUP BY
                                                        co,
                                                        thn,
                                                        bln,
                                                        A .prov,
                                                        c.budat
                                        ) TB
                                WHERE
                                        budat LIKE '$tahun$bulan%'
                                AND PROV NOT IN ('0001', '1092')
                                GROUP BY
                                        PROV
                        ) TB1
                LEFT JOIN (
                        SELECT
                                VKBUR prov,
                                SUM (REVENUE) REAL_REVENUE
                        FROM
                                MV_REVENUE
                        WHERE
                                VKORG IN ('7000','5000')
                        AND VKBUR NOT IN ('0001', '1092')
                        AND MATERIAL = '121-301'
                        AND TO_CHAR (BUDAT, 'yyyymm') = '$tahun$bulan'
                        AND TO_CHAR (BUDAT, 'dd') <= '$hari'
                        GROUP BY
                                VKBUR
                ) TB3 ON TB1.PROV = TB3.PROV
                LEFT JOIN (
                        SELECT
                                tb5.id_prov PROV,
                                tb6.ID_KABIRO,
                                tb6.nama_kabiro
                        FROM
                                ZREPORT_SCM_KABIRO_SALES tb5
                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                        WHERE
                                TB5.ORG = '7000'
                        AND tb5.ITEM_NO = '121-301'
                ) TB4 ON TB1.PROV = TB4.PROV
                GROUP BY
                        ID_KABIRO
                UNION
                        SELECT
                                MAX(( SELECT
                                                zsmk.id_kabiro
                                        FROM
                                                ZREPORT_SCM_KABIRO_SALES zsks
                                        LEFT JOIN ZREPORT_SCM_M_KABIRO zsmk ON zsks.id_kabiro = zsmk.id_kabiro
                                        WHERE
                                                item_no = '121-302'
                                        AND zsks.ORG = '7000' )) ID_KABIRO,
                                MAX(( SELECT
                                                zsmk.nama_kabiro
                                        FROM
                                                ZREPORT_SCM_KABIRO_SALES zsks
                                        LEFT JOIN ZREPORT_SCM_M_KABIRO zsmk ON zsks.id_kabiro = zsmk.id_kabiro
                                        WHERE
                                                item_no = '121-302'
                                        AND zsks.ORG = '7000' )) AS NAMA_KABIRO,
                                SUM (TARGET_REVENUE) TARGET_REVENUE,
                                SUM (TARGET_REVENUE_SDK) TARGET_REVENUE_SDK,
                                SUM (REAL_REVENUE) REAL_REVENUE,
                                SUM (REAL_REVENUE) - SUM (TARGET_REVENUE) SELISIH
                        FROM
                                (
                                        SELECT
                                                PROV,
                                                SUM (CASE WHEN budat<='$tahun$bulan$hari' THEN target_revenue ELSE 0 END) TARGET_REVENUE_SDK,
                                                SUM (target_revenue) TARGET_REVENUE
                                        FROM
                                                (
                                                        SELECT
                                                                A .prov,
                                                                c.budat,
                                                                SUM (
                                                                        A .revenue * (c.porsi / D .total_porsi)
                                                                ) AS target_revenue
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
                                                        AND A .TIPE = '121-302'
                                                        GROUP BY
                                                                co,
                                                                thn,
                                                                bln,
                                                                A .prov,
                                                                c.budat
                                                ) TB
                                        WHERE
                                                budat LIKE '$tahun$bulan%'
                                        AND PROV NOT IN ('0001', '1092')
                                        GROUP BY
                                                PROV
                                ) TB1
                        LEFT JOIN (
                                SELECT
                                        VKBUR prov,
                                        SUM (REVENUE) REAL_REVENUE
                                FROM
                                        MV_REVENUE
                                WHERE
                                        VKORG = '7000'
                                AND VKBUR NOT IN ('0001', '1092')
                                AND MATERIAL = '121-302'
                                AND TO_CHAR (BUDAT, 'yyyymm') = '$tahun$bulan'
                                AND TO_CHAR (BUDAT, 'dd') <= '$hari'
                                GROUP BY
                                        VKBUR
                        ) TB3 ON TB1.PROV = TB3.PROV";
        $data = $this->db->query($sql);
        return $data->result_array();
    }

}
