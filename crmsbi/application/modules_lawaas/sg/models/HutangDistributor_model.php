<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

date_default_timezone_set('Asia/Jakarta');

class HutangDistributor_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getRelDist($vkorg) {
        $data = $this->db->query("select com,sold_to,sum(kwantumx) as kwantumx from
            (
                    SELECT sum(a.kwantumx) as kwantumx, a.com,
                        CASE when a.sold_to like '0000003%' then '0000003000'
                        when a.sold_to like '0000004%' then '0000004000'
                        else
                        a.sold_to
                        end as sold_to
                        FROM zreport_rpt_real a, zreport_m_kota b 
                        WHERE 
                        a.kota = b.kd_kota and a.com in($vkorg) and  a.sold_to like '000000%'  and              
                        to_char(a.tgl_cmplt,'YYYYMMDD') between '" . date('Ym') . "01' and '" . date('Ymd') . "'
                    group by a.com,sold_to
                    order by a.com,a.sold_to asc
            )
            GROUP BY com,sold_to
            ORDER BY com,sold_to asc");
        return $data->result_array();
    }

    function getSisaDist($vkorg) {
        $data = $this->db->query("select sum(sisa_qty) as sisa_qty,nmorg,sold_to_code from
                    (SELECT sum(a.sisa_to) as sisa_qty, a.nmorg,
                    CASE when a.sold_to_code like '0000003%' then '0000003000'
                    when a.sold_to_code like '0000004%' then '0000004000'
                    else
                    a.sold_to_code
                    end as sold_to_code
                    FROM zreport_so_buffer a
                    WHERE a.nmorg in($vkorg) and  a.sold_to_code like '000000%'  
                    group by a.nmorg,a.sold_to_code
                    order by a.nmorg,a.sold_to_code asc)
                GROUP BY nmorg,sold_to_code
                ORDER BY nmorg,sold_to_code asc
                ");
        return $data->result_array();
    }

    function getComin($org) {

        $data = $this->db->query("select ORGIN from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0
                    group by ORGIN")->result_array();
        if (count($data) > 0) {
            unset($inorg);
            $orgcounter = 0;
            $inorg = '';
            foreach ($data as $keyOrg => $valorgm) {
                $inorg .= "'" . $valorgm['ORGIN'] . "',";
                $orgcounter++;
            }
            $orgIn = rtrim($inorg, ',');
        } else {
            $orgIn = $org;
        }
       
        return $orgIn;
    }

    function getCustomer($org) {
       // $org = $this->getComin($org);
        $data = $this->db->query("SELECT * FROM (SELECT KUNNR, NAME1, JENIS FROM M_CUSTOMER WHERE STATUS='0' UNION
	SELECT
		'0000003000' KUNNR,
		'Semen Padang' NAME1,
		'ICS' JENIS
	FROM
		dual
	UNION
		SELECT
			'0000004000' KUNNR,
			'Semen Tonasa' NAME1,
			'ICS' JENIS
		FROM
			dual
UNION
SELECT
			'0000005000' KUNNR,
			'Semen Gresik' NAME1,
			'ICS' JENIS
		FROM
			dual) LEFT JOIN
            (select com,sold_to,sum(kwantumx) as kwantumx from
            (
                    SELECT sum(a.kwantumx) as kwantumx, a.com,
                        CASE when a.sold_to like '0000003%' then '0000003000'
                        when a.sold_to like '0000004%' then '0000004000'
                        else
                        a.sold_to
                        end as sold_to
                        FROM zreport_rpt_real a, zreport_m_kota b 
                        WHERE 
                        a.kota = b.kd_kota and a.com in($org) and  a.sold_to like '000000%'  and              
                        to_char(a.tgl_cmplt,'YYYYMMDD') between '" . date('Ym') . "01' and '" . date('Ymd') . "'
                    group by a.com,sold_to
                    order by a.com,a.sold_to asc
            )
            GROUP BY com,sold_to) ON KUNNR=SOLD_TO
            LEFT JOIN (select sum(sisa_qty) as sisa_qty,nmorg,sold_to_code from
                    (SELECT sum(a.sisa_to) as sisa_qty, a.nmorg,
                    CASE when a.sold_to_code like '0000003%' then '0000003000'
                    when a.sold_to_code like '0000004%' then '0000004000'
                    else
                    a.sold_to_code
                    end as sold_to_code
                    FROM zreport_so_buffer a
                    WHERE a.nmorg in($org) and  a.sold_to_code like '000000%'  
                    group by a.nmorg,a.sold_to_code
                    order by a.nmorg,a.sold_to_code asc)
                GROUP BY nmorg,sold_to_code) ON KUNNR=sold_to_code
               ");
        return $data->result_array();
    }
    
    function getPosisiArmada(){
        $data = $this->db->query(" 
                    SELECT
	MAX (DECODE(status, 10, total, 0)) AS daftar_zak_10,
	MAX (DECODE(status, 20, total, 0)) AS daftar_zak_20,
	MAX (DECODE(status, 30, total, 0)) AS cargo_zak_30,
	MAX (
		DECODE (
			item_no,
			'121-301',
			DECODE (status, 40, total, 0),
			0
		)
	) AS alamat_zak_40,
	MAX (
		DECODE (
			item_no,
			'121-302',
			DECODE (status, 40, total, 0),
			0
		)
	) AS alamat_curah_40,
	MAX (
		DECODE (
			item_no,
			'121-301',
			DECODE (status, 50, total, 0),
			0
		)
	) AS conv_zak_50,
	MAX (
		DECODE (
			item_no,
			'121-302',
			DECODE (status, 50, total, 0),
			0
		)
	) AS conv_curah_50,
	MAX (
		DECODE (
			item_no,
			'121-301',
			DECODE (status, 70, total, 0),
			0
		)
	) AS spj_zak_70,
	MAX (
		DECODE (
			item_no,
			'121-302',
			DECODE (status, 70, total, 0),
			0
		)
	) AS spj_curah_70
FROM
	(
		SELECT
			K .status,
			K .item_no,
			COUNT (*) total
		FROM
			(
				SELECT
					no_transaksi,
					status,
					SUBSTR (item_no, 0, 7) AS item_no
				FROM
					zreport_rpt_real
				WHERE
					TO_CHAR (tgl_cmplt, 'ddmmyyyy') = TO_CHAR (SYSDATE, 'ddmmyyyy')
				AND item_no != '121-301-0240'
				AND (
					(tipe_truk BETWEEN 100 AND 307)
					OR (tipe_truk = 308)
				)
				AND (
					(
						item_no LIKE '121-301%'
						AND order_type <> 'ZNL'
					)
					OR (item_no LIKE '121-302%')
				)
				UNION ALL
					SELECT
						no_transaksi,
						status,
						SUBSTR (item_no, 0, 7) AS item_no
					FROM
						zreport_rpt_real_non70
					WHERE
						(
							item_no <> '121-301-0240'
							AND item_no LIKE '121-30%'
							OR item_no IS NULL
						)
					AND (
						(tipe_truk BETWEEN 100 AND 307)
						OR (tipe_truk = 308)
					)
					AND (
						type_match <> 'PO'
						OR type_match IS NULL
					)
					AND no_transaksi NOT IN (
						SELECT
							G .no_transaksi
						FROM
							zreport_rpt_real G
						WHERE
							G .no_transaksi IS NOT NULL
						GROUP BY
							G .no_transaksi
					)
			) K
		GROUP BY
			K .status,
			K .item_no
	)   
                 ")->row_array();
        
        return $data;
    }
    
    function getStok(){
        $data = $this->db->query(" 
                SELECT
	werks,
	SUM (
		silo1_opc + silo2_opc + silo3_opc + silo4_opc
	) AS silo_opc,
	SUM (
		silo1_ppc + silo2_ppc + silo3_ppc + silo4_ppc
	) AS silo_ppc,
	SUM (
		silo1_khusus + silo2_khusus + silo3_khusus + silo4_khusus
	) AS silo_khusus
FROM
	(
		SELECT DISTINCT
			werks,
			group_silo,
			SUM (silo1_opc) AS silo1_opc,
			SUM (silo1_ppc) AS silo1_ppc,
			SUM (silo1_khusus) AS silo1_khusus,
			SUM (silo2_opc) AS silo2_opc,
			SUM (silo2_ppc) AS silo2_ppc,
			SUM (silo2_khusus) AS silo2_khusus,
			SUM (silo3_opc) AS silo3_opc,
			SUM (silo3_ppc) AS silo3_ppc,
			SUM (silo3_khusus) AS silo3_khusus,
			SUM (silo4_opc) AS silo4_opc,
			SUM (silo4_ppc) AS silo4_ppc,
			SUM (silo4_khusus) AS silo4_khusus,
			meins,
			create_date
		FROM
			roma_silo_day2dayx c
		WHERE
			WERKS = '7403'
		AND create_date = (
			SELECT
				MAX (create_date)
			FROM
				roma_silo_day2dayx
			WHERE
				werks = c.werks
		)
		GROUP BY
			werks,
			group_silo,
			meins,
			create_date
	)
GROUP BY
	werks
                 ")->row_array();
        return $data;
    }
}
