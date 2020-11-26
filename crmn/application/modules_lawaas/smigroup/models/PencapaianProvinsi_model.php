<?php

if (!defined('BASEPATH'))
    exit('NO DIRECT SCRIPT ACCESS ALLOWED');

class PencapaianProvinsi_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * OLD FUNCTION BEFORE EDIT DASHBOARDBOD TEAM
     */
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


    /**
     * EDITED BY DASHBOARDBOD TEAM
     */
    function scodataRegion($tahun, $bulan, $hari, $region) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $sqlmaterial = "in('121-301','121-302')";
        if (strtolower($region) == "all") {
            $sqlregion = "in (1,2,3)";
        } else if (strtolower($region) == 'curah') {
            $sqlregion = "in(2)";
            $sqlmaterial = "in('121-302')";
        } else if ($region == '2') {
            $sqlregion = "in(2)";
            $sqlmaterial = " in('121-301')";
        } else {
            $sqlregion = "in(" . $region . ")";
        }
        $sql = "SELECT
                                        TB1.PROV,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB2. REAL, 0) REAL,
                                        TB8.NM_PROV,
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH,
                                        NVL (TB4.HARIAN_MAX, 0) HARIAN_MAX,
                                        NVL (TB6.RKAP_MS, 0) RKAP_MS,
                                        NVL (TB9.RKAP_HARGA, 0) RKAP_HARGA,
                                        NVL (TB1.REVENUE, 0) TARGET_REVENUE,
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
                                                        SUM (A.quantum) AS target,
                                                        SUM (A.revenue) AS revenue
                                                FROM
                                                        sap_t_rencana_sales_type A
                                                            left join ZREPORT_M_PROVINSI B on A.PROV=B.KD_PROV
                                                WHERE
                                                A.co in (3000,4000,5000,7000)
                                                AND A.thn = '$tahun'
                                                AND A.bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                                AND A.tipe $sqlmaterial
                                                and B.ID_SCM_SALESREG $sqlregion
                                                GROUP BY
                                                        A.prov
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                    A.PROPINSI_TO,
                                                    SUM (A.QTY) REAL
                                        FROM
                                                    ZREPORT_SCM_REAL_SALES A
                                                    left join ZREPORT_M_PROVINSI B on A.PROPINSI_TO=B.KD_PROV
                                        WHERE
                                        A.ORG IN (3000,4000,5000,7000)
                                        AND A.TAHUN = '$tahun'
                                        AND A.BULAN = '$bulan'
                                        AND A.HARI <= '$hari'
                                        AND A.item $sqlmaterial
                                        AND A.PROPINSI_TO NOT IN ('1092', '0001')
                                        and B.ID_SCM_SALESREG $sqlregion
                                        GROUP BY 
                                                    A.PROPINSI_TO
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
                                                                        and b.ID_SCM_SALESREG $sqlregion
                                                                        LEFT JOIN (
                                                                                SELECT
                                                                                        region,
                                                                                        vkorg,
                                                                                        tipe,
                                                                                        SUM (porsi) AS total_porsi
                                                                                FROM
                                                                                        zreport_porsi_sales_region
                                                                                WHERE
                                                                                        budat LIKE '$tahun$bulan%'
                                                                                     AND vkorg in (3000,4000,5000,7000)
                                                                                GROUP BY
                                                                                        vkorg,
                                                                                        region,
                                                                                        tipe
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe AND A.co=D.vkorg
                                                                        WHERE
                                                                        A.co in (3000,4000,5000,7000)
                                                                        AND A.thn = '$tahun'
                                                                        AND A.bln = '$bulan'
                                                                        AND A.tipe $sqlmaterial
                                                                        GROUP BY
                                                                                A.thn,
                                                                                A.bln,
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
                                                A.PROPINSI_TO,
                                                MAX (A.QTY) HARIAN_MAX
                                        FROM
                                                ZREPORT_SCM_REAL_SALES A
                                                left join ZREPORT_M_PROVINSI B on A.PROPINSI_TO=B.KD_PROV
                                        WHERE
                                        A.ORG IN (3000,4000,5000,7000)
                                        AND A.TAHUN = '$tahun'
                                        AND A.BULAN = '$bulan'
                                        AND A.HARI <= '$hari'
                                        AND A.PROPINSI_TO NOT IN ('1092', '0001')
                                        and B.ID_SCM_SALESREG $sqlregion
                                        AND A.item $sqlmaterial
                                        GROUP BY
                                                A.PROPINSI_TO
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
                                                                A.KD_PROV,
                                                                SUM (A.qty) qty
                                                        FROM
                                                                ZREPORT_SCM_DEMAND_PROVINSI A
                                                                left join ZREPORT_M_PROVINSI B on A.KD_PROV=B.KD_PROV
                                                        WHERE
                                                                A.tahun = '$tahun'
                                                        AND A.bulan = '$bulan'
                                                        and B.ID_SCM_SALESREG $sqlregion
                                                        GROUP BY
                                                               A.KD_PROV
                                                ) tb1
                                        LEFT JOIN (
                                                SELECT
                                                        vkorg org,
                                                        SUM (porsi) porsi
                                                FROM
                                                        zreport_porsi_sales_region c
                                                WHERE
                                                c.region = 5
                                                AND c.vkorg in (3000,4000,5000,7000)
                                                AND c.budat LIKE '$tahun$bulan%'
                                                AND c.budat <= '$tahun$bulan$hari'
                                                GROUP BY
                                                        VKORG 
                                        ) tb2 ON TB2.org in  (3000,4000,5000,7000)
                                        LEFT JOIN (
                                                SELECT
                                                        vkorg org,
                                                        SUM (porsi) porsi_total
                                                FROM
                                                        zreport_porsi_sales_region c
                                                WHERE
                                                        c.region = 5
                                                AND c.vkorg in  (3000,4000,5000,7000)
                                                AND c.tipe $sqlmaterial
                                                AND c.budat LIKE '$tahun$bulan%'
                                                
                                                GROUP BY
                                                        VKORG
                                        ) tb3 ON TB2.org = tb3.org
                                ) TB7 ON TB1.PROV = TB7.KD_PROV
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN (
                                    SELECT
                                            PROV,
                                            CASE
                                    WHEN SUM (QUANTUM) = 0 THEN
                                            0
                                    ELSE
                                            SUM(REVENUE) / SUM (QUANTUM)
                                    END RKAP_HARGA
                                    FROM
                                            SAP_T_RENCANA_SALES_TYPE
                                    WHERE
                                            THN = '$tahun'
                                    AND BLN = '$bulan'
                                    AND TIPE $sqlmaterial
                                    AND PROV NOT LIKE '6%'
                                    GROUP BY
                                            PROV
                                ) TB9 ON TB1.PROV = TB9.PROV
                                LEFT JOIN (
                                        SELECT
                                                A .PROPINSI_TO PROV,
                                               NVL (((HARGA/VOL)-CASE WHEN VOL=0 THEN 0 ELSE (OA/VOL) END)*VOL,0) REAL_REVENUE
                                        FROM
                                                (
                                                         SELECT
                                                        PROPINSI_TO,
                                                        SUM (QTY) VOL
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        BULAN = '$bulan'
                                                AND HARI <= '$hari'
                                                AND TAHUN = '$tahun'
                                                AND ITEM $sqlmaterial
                                                GROUP BY
                                                        PROPINSI_TO
                                                        
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        PROV PROPINSI_TO,
                                                        SUM (OA) OA,
                                                        SUM (QTY) OA_QTY
                                                FROM
                                                        ZREPORT_SCM_OA
                                                WHERE
                                                        TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND HARI <= '$hari'
                                                AND SUBSTR(MATERIAL,1,7) $sqlmaterial
                                                GROUP BY
                                                        PROV
                                        ) B ON A .PROPINSI_TO = B.PROPINSI_TO
                                        LEFT JOIN (
                                               SELECT
                                                                PROPINSI_TO,
                                                                SUM (HARGA) HARGA,
                                                                SUM (KWANTUMX) HARGA_QTY
                                                        FROM
                                                                ZREPORT_SCM_HARGA
                                                        WHERE
                                                                BULAN = '$bulan'
                                                        AND TAHUN = '$tahun'
                                                        AND HARI <= '$hari'
                                                        AND SUBSTR(ITEM,1,7) $sqlmaterial
                                                        GROUP BY
                                                                PROPINSI_TO
                                        ) C ON A .PROPINSI_TO = C.PROPINSI_TO
                                        LEFT JOIN ZREPORT_M_PROVINSI D on A.PROPINSI_TO=D.KD_PROV
                                        WHERE D.ID_SCM_SALESREG $sqlregion
                                ) TB10 ON TB1.PROV = TB10.PROV
                                ORDER BY
                                        TB1.PROV";
        $data = $this->db->query($sql);
//        echo $this->db->last_query();
        return $data->result_array();
    }

    /**
     * EDIT BY DASHBOARD TEAM
     */
    function getDemandNasionalRegion($tahun, $bulan, $hari, $region) {
        $sql = "SELECT
                                        nvl(
                                           (tb.qty * tb.porsi / tb.porsi_total),0
                                        ) demand_nasional
                                FROM
                                        ( select (
                                                SELECT
                                                        SUM (qty) qty
                                                FROM
                                                        ZREPORT_SCM_DEMAND_PROVINSI A
                                                        left join ZREPORT_M_PROVINSI B on A.KD_PROV=B.KD_PROV
                                                WHERE
                                                    A.tahun = '$tahun'
                                                AND A.bulan = '$bulan'
                                        ) qty,
                                (
                                        SELECT
                                                SUM (porsi) porsi
                                        FROM
                                                zreport_porsi_sales_region c
                                        WHERE
                                                c.region = 5
                                        AND c.vkorg in (3000,4000,5000,7000)
                                        AND c.budat LIKE '$tahun$bulan%'
                                        AND c.budat <= '$tahun$bulan$hari'
                                ) porsi,
                                (
                                        SELECT
                                                SUM (porsi) porsi_total
                                        FROM
                                                zreport_porsi_sales_region c
                                        WHERE
                                                c.region = 5
                                        AND c.vkorg in (3000,4000,5000,7000)
                                        AND c.budat LIKE '$tahun$bulan%'
                                ) porsi_total 
            from dual ) tb";
        $data = $this->db->query($sql);
//         echo $this->db->last_query();
        return $data->row_array();
    }

    /**
     * EDIT BY DASHBOARD TEAM
     */
    function scodatamvSumRegion($tahun, $bulan, $hari, $region) {
        $sqlmaterial = "in('121-301','121-302')";
        if (strtolower($region) == "all") {
            $sqlregion = "in (1,2,3)";
        } else if (strtolower($region) == 'curah') {
            $sqlregion = "in(2)";
            $sqlmaterial = "in('121-302')";
        } else if ($region == '2') {
            $sqlregion = "in(2)";
            $sqlmaterial = " in('121-301')";
        } else {
            $sqlregion = "in(" . $region . ")";
        }
        $sql = "SELECT
                        (
                                SELECT
                                        SUM (A.QUANTUM) RKAP
                                FROM
                                        SAP_T_RENCANA_SALES_TYPE A
                                         LEFT JOIN zreport_m_provinsi b ON A .prov = b.kd_prov 
                                WHERE
                                    A.THN = '$tahun'
                                AND A.BLN = '$bulan'
                                AND A.TIPE != '121-200'
                                AND A.TIPE $sqlmaterial
                                AND A.PROV NOT IN ('1092', '0001')
                                AND A.CO in (3000,4000,5000,7000)
                                and b.ID_SCM_SALESREG $sqlregion
                        ) TARGET,
                (
                        SELECT
                                SUM (A.QTY) REAL
                        FROM
                                ZREPORT_SCM_REAL_SALES A
                                LEFT JOIN zreport_m_provinsi b ON A.PROPINSI_TO = b.kd_prov
                        WHERE
                            A.TAHUN = '$tahun'
                        AND A.BULAN = '$bulan'
                        AND A.HARI <= '$hari'
                        AND A.PROPINSI_TO NOT IN ('1092', '0001')
                        AND A.ITEM != '121-200'
                        AND A.ITEM $sqlmaterial
                        AND A.ORG in (3000,4000,5000,7000)
                        And b.ID_SCM_SALESREG $sqlregion
                ) REAL, 
                (
                        SELECT
                                SUM (TARGET_REALH) TARGET_REALH
                        FROM
                                (
                                        SELECT
                                                c.budat,
                                                SUM (
                                                        A .quantum * (c.porsi / D .total_porsi)
                                                ) AS target_realh
                                        FROM
                                                sap_t_rencana_sales_type A
                                        LEFT JOIN zreport_m_provinsi b ON A.prov = b.kd_prov
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
                                                AND vkorg in (3000,4000,5000,7000)
                                                GROUP BY
                                                    vkorg,
                                                        region,
                                                        tipe
                                        ) D ON c.region = D .region
                                        AND D .tipe = A .tipe AND A.co=D.vkorg
                                        WHERE
                                                co in (3000,4000,5000,7000)
                                        AND thn = '$tahun'
                                         AND A.tipe $sqlmaterial
                                        and b.ID_SCM_SALESREG $sqlregion
                                        AND bln = '$bulan'
                                        AND A .prov NOT IN ('1092', '0001')
                                        GROUP BY
                                                c.budat
                                )
                        WHERE
                                budat <= '$tahun$bulan$hari'
                ) TARGET_REALH from dual";

        //echo $sql;
        $data = $this->db->query($sql);
        return $data->row_array();
    }

    /**
     * FUNCTION edit DASHBOARD TEAM
     */
    function scodatasgBagNewRegion($tahun, $bulan, $hari, $region) {
       
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }


        if (strtolower($region) == "all") {
            $sqlregion = "in (1,2,3)";
        } else if (strtolower($region) == 'curah') {
            $sqlregion = "in(2)";
        } else if ($region == '2') {
            $sqlregion = "in(2)";
        } else {
            $sqlregion = "in(" . $region . ")";
        }
        $sql = "SELECT distinct
                                        TB1.PROV,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB1.REVENUE, 0) TARGET_REVENUE,
                                        NVL (TB2. REAL, 0) REAL,
                                        TB8.NM_PROV,
                                        TB8.NM_PROV_1,
                                         NVL (TB6.REAL_REVENUE, 0) REAL_REVENUE,
                                        
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH
                                FROM
                                        (
                                                SELECT
                                                        A .prov,
                                                        SUM (A .quantum) AS target,
                                                        SUM (A. revenue) AS revenue
                                                FROM
                                                        sap_t_rencana_sales_type A
                                                        left join ZREPORT_M_PROVINSI B on A.prov=B.kd_prov
                                                WHERE
                                                    A.co in (3000,4000,5000,7000)
                                                AND A.thn = '$tahun'
                                                AND A.bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                                AND A .TIPE = '121-301'
                                                and B.ID_SCM_SALESREG $sqlregion
                                                GROUP BY
                                                        A .prov
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                A.PROPINSI_TO,
                                                SUM (A.QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES A
                                            left join ZREPORT_M_PROVINSI B on A.PROPINSI_TO=B.kd_prov
                                        WHERE
                                                ORG IN (3000,4000,5000,7000)
                                        AND A.TAHUN = '$tahun'
                                        AND A.BULAN = '$bulan'
                                        AND A.ITEM = '121-301'
                                        AND A.HARI <= '$hari'
                                        AND A.PROPINSI_TO NOT IN ('1092', '0001')
                                        and B.ID_SCM_SALESREG $sqlregion
                                        GROUP BY
                                                A.PROPINSI_TO
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
                                                                                AND vkorg in (3000,4000,5000,7000)
                                                                                GROUP BY
                                                                                        vkorg,
                                                                                        region,
                                                                                        tipe
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe AND D.vkorg = A.co
                                                                        WHERE
                                                                            A.co in (3000,4000,5000,7000)
                                                                        AND A.thn = '$tahun'
                                                                        AND A.bln = '$bulan'
                                                                        AND A.TIPE = '121-301'
                                                                        and b.ID_SCM_SALESREG $sqlregion
                                                                        GROUP BY
                                                                                A.thn,
                                                                                A.bln,
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
                                        SELECT distinct
                                                tb5.id_prov PROV,
                                                tb6.nama_kabiro
                                        FROM
                                                ZREPORT_SCM_KABIRO_SALES tb5
                                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                                        left JOIN zreport_m_provinsi b ON tb5.id_prov = b.kd_prov
                                        WHERE
                                                TB5.ORG in (3000,4000,5000,7000)
                                                and b.ID_SCM_SALESREG $sqlregion
                                ) TB5 ON TB1.PROV = TB5.PROV
                                LEFT JOIN (
                                   SELECT
                                                A .PROPINSI_TO PROV,
                                                NVL (((HARGA/VOL)-CASE WHEN VOL=0 THEN 0 ELSE (OA/VOL) END)*VOL,0) REAL_REVENUE
                                        FROM
                                                (
                                                       SELECT
                                                        PROPINSI_TO,
                                                        SUM (QTY) VOL
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        BULAN = '$bulan'
                                                AND HARI <= '$hari'
                                                AND TAHUN = '$tahun'
                                                AND ITEM IN ('121-301')
                                                GROUP BY
                                                        PROPINSI_TO 
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        PROV PROPINSI_TO,
                                                        SUM (OA) OA,
                                                        SUM (QTY) OA_QTY
                                                FROM
                                                        ZREPORT_SCM_OA
                                                WHERE
                                                        TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND HARI <= '$hari'
                                                AND SUBSTR(MATERIAL,1,7) IN ('121-301')
                                                GROUP BY
                                                        PROV
                                        ) B ON A .PROPINSI_TO = B.PROPINSI_TO
                                        LEFT JOIN (
                                                 SELECT
                                                                PROPINSI_TO,
                                                                SUM (HARGA) HARGA,
                                                                SUM (KWANTUMX) HARGA_QTY
                                                        FROM
                                                                ZREPORT_SCM_HARGA
                                                        WHERE
                                                                BULAN = '$bulan'
                                                        AND TAHUN = '$tahun'
                                                        AND HARI <= '$hari'
                                                        AND SUBSTR(ITEM,1,7) IN ('121-301')
                                                        GROUP BY
                                                                PROPINSI_TO
                                               
                                        ) C ON A .PROPINSI_TO = C.PROPINSI_TO
                                        LEFT JOIN ZREPORT_M_PROVINSI D on A.PROPINSI_TO=D.KD_PROV
                                        WHERE D.ID_SCM_SALESREG $sqlregion
                                
                                ) TB6 ON TB1.PROV = TB6.PROV
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                where TB8.ID_SCM_SALESREG $sqlregion
                                ORDER BY
                                        TB1.PROV";
        
        $data = $this->db->query($sql);

        return $data->result_array();
    }

    /**
     * FUNCTION edit DASHBOARD TEAM
     */
    function scodatasgBulkNewRegion($tahun, $bulan, $hari, $region) {
        
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }

        if (strtolower($region) == "all") {
            $sqlregion = "in (1,2,3)";
        } else if (strtolower($region) == 'curah') {
            $sqlregion = "in(2)";
        } else if ($region == '2') {
            $sqlregion = "in(2)";
        } else {
            $sqlregion = "in(" . $region . ")";
        }
        $sql = "SELECT distinct
                                        TB0.PROV,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB1.REVENUE, 0) TARGET_REVENUE,
                                        NVL (TB2. REAL, 0) REAL,
                                        TB8.NM_PROV,
                                        TB8.NM_PROV_1,
                                        NVL (TB6.REAL_REVENUE, 0) REAL_REVENUE,
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH
                                FROM
                                        (
                                                SELECT DISTINCT
                                                        A .prov
                                                FROM
                                                        sap_t_rencana_sales_type A
                                                        left join ZREPORT_M_PROVINSI B on A.prov=B.kd_prov
                                                WHERE
                                                A.co in (3000,4000,5000,7000)
                                                AND A.thn = '$tahun'
                                                AND A.bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                                and B.ID_SCM_SALESREG $sqlregion
                                        ) TB0
                                LEFT JOIN (
                                        SELECT
                                                A .prov,
                                                SUM (A .quantum) AS target,
                                                SUM (A.REVENUE) AS REVENUE
                                        FROM
                                                sap_t_rencana_sales_type A
                                                left join ZREPORT_M_PROVINSI B on A.prov=B.kd_prov
                                        WHERE
                                            A.co in (3000,4000,5000,7000)
                                        AND A.thn = '$tahun'
                                        AND A.bln = '$bulan'
                                        AND A .prov != '0001'
                                        AND A .prov != '1092'
                                        AND A .tipe = '121-302'
                                        and B.ID_SCM_SALESREG $sqlregion
                                        GROUP BY
                                                A .prov
                                ) TB1 ON TB0.PROV = TB1.PROV
                                LEFT JOIN (
                                        SELECT
                                                A.PROPINSI_TO,
                                                SUM (A.QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES A
                                                left join ZREPORT_M_PROVINSI B on A.PROPINSI_TO=B.kd_prov
                                        WHERE
                                                A.ORG IN (3000,4000,5000,7000)
                                        AND A.TAHUN = '$tahun'
                                        AND A.BULAN = '$bulan'
                                        AND A.HARI <= '$hari'
                                        AND A.ITEM = '121-302'
                                        AND A.PROPINSI_TO NOT IN ('1092', '0001')
                                        and B.ID_SCM_SALESREG $sqlregion
                                        GROUP BY
                                                A.PROPINSI_TO
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
                                                                                AND vkorg in (3000,4000,5000,7000)
                                                                                GROUP BY
                                                                                        vkorg,
                                                                                        region,
                                                                                        tipe
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe AND A.co=D.vkorg
                                                                        WHERE
                                                                        A.co in (3000,4000,5000,7000)
                                                                        AND A.thn = '$tahun'
                                                                        AND A.bln = '$bulan'
                                                                        AND A .tipe = '121-302'
                                                                        and b.ID_SCM_SALESREG $sqlregion
                                                                        GROUP BY
                                                                                A.thn,
                                                                                A.bln,
                                                                                A.prov,
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
                                        left JOIN zreport_m_provinsi b ON tb5.ID_PROV = b.kd_prov
                                        WHERE
                                                tb5.item_no = '121-302'
                                        AND TB5.ORG in (3000,4000,5000,7000)
                                        and b.ID_SCM_SALESREG $sqlregion
                                ) TB4 ON TB4.item_no = '121-302'
                                 LEFT JOIN (
                                   SELECT
                                                A .PROPINSI_TO PROV,
                                                NVL (((HARGA/VOL)-CASE WHEN VOL=0 THEN 0 ELSE (OA/VOL) END)*VOL,0) REAL_REVENUE
                                        FROM
                                                (
                                                    SELECT
                                                        PROPINSI_TO,
                                                        SUM (QTY) VOL
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        BULAN = '$bulan'
                                                AND HARI <= '$hari'
                                                AND TAHUN = '$tahun'
                                                AND ITEM IN ('121-302')
                                                GROUP BY
                                                        PROPINSI_TO
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        PROV PROPINSI_TO,
                                                        SUM (OA) OA,
                                                        SUM (QTY) OA_QTY
                                                FROM
                                                        ZREPORT_SCM_OA
                                                WHERE
                                                        TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND HARI <= '$hari'
                                                AND MATERIAL IN ('121-302')
                                                GROUP BY
                                                        PROV
                                        ) B ON A .PROPINSI_TO = B.PROPINSI_TO
                                        LEFT JOIN (
                                                 SELECT
                                                                PROPINSI_TO,
                                                                SUM (HARGA) HARGA, 
                                                                SUM (KWANTUMX) HARGA_QTY
                                                        FROM
                                                                ZREPORT_SCM_HARGA
                                                        WHERE
                                                                BULAN = '$bulan'
                                                        AND TAHUN = '$tahun'
                                                        AND HARI <= '$hari'
                                                        AND ITEM IN ('121-302')
                                                        GROUP BY
                                                                PROPINSI_TO
                                                
                                        ) C ON A .PROPINSI_TO = C.PROPINSI_TO
                                        LEFT JOIN ZREPORT_M_PROVINSI D on A.PROPINSI_TO=D.KD_PROV
                                        WHERE D.ID_SCM_SALESREG $sqlregion

                                ) TB6 ON TB1.PROV = TB6.PROV
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB0.prov = TB8.KD_PROV
                                where tb8.ID_SCM_SALESREG $sqlregion
                                ORDER BY
                                        TB0.PROV";
        $data = $this->db->query($sql);
        return $data->result_array();
    }

    /**
     * FUNCTION edit DASHBOARD TEAM
     */
    function getChartBagNewRegion($tahun, $bulan, $hari,$region,$biro) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }

         if (strtolower($region) == "all") {
            $sqlregion = "in (1,2,3)";
        } else if (strtolower($region) == 'curah') {
            $sqlregion = "in(2)";
        } else if ($region == '2') {
            $sqlregion = "in(2)";
        } else {
            $sqlregion = "in(" . $region . ")";
        }
        
        $sql = "SELECT sum(target) TARGET,sum(real) REAL,sum(target_realh) TARGET_REALH
				from (
        			 SELECT
                                        ID_KABIRO,
                                        NAMA_KABIRO,
                                        prov,
        								PROV1,
                                        SUM (TARGET) TARGET,
                                        SUM (REAL) REAL,
                                        SUM (TARGET_REALH) TARGET_REALH
                                FROM
                                        (
                                                SELECT
                                                        TB1.PROV,
                                                        TB4.PROV1,
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
                                                                        left join ZREPORT_M_PROVINSI B on A.prov=B.kd_prov
                                                                WHERE
                                                                A.co in (3000,4000,5000,7000)
                                                                AND A.thn = '$tahun'
                                                                AND A.bln = '$bulan'
                                                                AND A .prov != '0001'
                                                                AND A .prov != '1092'
                                                                AND A .TIPE = '121-301'
                                                                and B.ID_SCM_SALESREG $sqlregion
                                                                GROUP BY
                                                                        A .prov
                                                        ) TB1
                                                LEFT JOIN (
                                                        SELECT
                                                                A.PROPINSI_TO,
                                                                SUM (A.QTY) REAL
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES A
                                                                left join ZREPORT_M_PROVINSI B on A.PROPINSI_TO=B.kd_prov
                                                        WHERE
                                                             A.ORG IN (3000,4000,5000,7000)
                                                        AND A.TAHUN = '$tahun'
                                                        AND A.BULAN = '$bulan'
                                                        AND A.HARI <= '$hari'
                                                        AND A.ITEM = '121-301'
                                                        AND A.PROPINSI_TO NOT IN ('1092', '0001')
                                                        and B.ID_SCM_SALESREG $sqlregion
                                                        GROUP BY
                                                                A.PROPINSI_TO
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
                                                                                                AND vkorg in (3000,4000,5000,7000)
                                                                                                GROUP BY
                                                                                                    vkorg,
                                                                                                        region,
                                                                                                        tipe
                                                                                        ) D ON c.region = D .region
                                                                                        AND D .tipe = A .tipe AND A.co = D.vkorg
                                                                                        WHERE
                                                                                        A.co in (3000,4000,5000,7000)
                                                                                        AND A.thn = '$tahun'
                                                                                        AND A.bln = '$bulan'
                                                                                        AND A .TIPE = '121-301'
                                                                                        and b.ID_SCM_SALESREG $sqlregion
                                                                                        GROUP BY
                                                                                                A.thn,
                                                                                                A.bln,
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
                                                                b.nm_prov_1 PROV1,
                                                                tb6.ID_KABIRO,
                                                                tb6.nama_kabiro
                                                        FROM
                                                                ZREPORT_SCM_KABIRO_SALES tb5
                                                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                                                        left JOIN zreport_m_provinsi b ON tb5.ID_PROV = b.kd_prov
                                                        WHERE
                                                        TB5.ORG in (3000,4000,5000,7000)
                                                        AND tb5.ITEM_NO = '121-301'
                                                        and b.ID_SCM_SALESREG $sqlregion
                                                ) TB4 ON TB1.PROV = TB4.PROV
                                        )
                                where prov in (SELECT A.id_prov FROM ZREPORT_SCM_M_KABIROREGION A
                                                join ZREPORT_SCM_M_KABIRO B on A.ID_KABIRO=B.ID_KABIRO 
                                                where B.nama_kabiro='$biro')
                                GROUP BY
                                        ID_KABIRO,
                                        NAMA_KABIRO,
                                        prov,
        								prov1
                                ORDER BY
                                        ID_KABIRO
               )";
        
        
         $data = $this->db->query($sql);
        // echo $this->db->last_query();
        return $data->result_array();
    } 

    /**
     * FUNCTION edit DASHBOARD TEAM
     */
    function getChartBulkNewRegion($tahun, $bulan, $hari,$region) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }

         if (strtolower($region) == "all") {
            $sqlregion = "in (1,2,3)";
        } else if (strtolower($region) == 'curah') {
            $sqlregion = "in(2)";
        } else if ($region == '2') {
            $sqlregion = "in(2)";
        } else {
            $sqlregion = "in(" . $region . ")";
        }

        $sql = "SELECT
                                        TARGET,
                                        REAL,
                                        TARGET_REALH,
                                        (
                                                SELECT
                                                        tb6.nama_kabiro
                                                FROM
                                                        ZREPORT_SCM_KABIRO_SALES tb5
                                                LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                                                left JOIN zreport_m_provinsi b ON tb5.ID_PROV = b.kd_prov
                                                WHERE
                                                        item_no = '121-302'
                                                AND TB5.ORG in (3000,4000,5000,7000)
                                                and b.ID_SCM_SALESREG $sqlregion
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
                                                                                        left join ZREPORT_M_PROVINSI B on A.prov=B.kd_prov
                                                                                WHERE
                                                                                A.co in (3000,4000,5000,7000)
                                                                                AND thn = '$tahun'
                                                                                AND bln = '$bulan'
                                                                                AND A .prov != '0001'
                                                                                AND A .prov != '1092'
                                                                                AND A .TIPE = '121-302'
                                                                                and B.ID_SCM_SALESREG $sqlregion
                                                                                GROUP BY
                                                                                        A .prov
                                                                        ) TB1
                                                                LEFT JOIN (
                                                                        SELECT
                                                                                A.PROPINSI_TO,
                                                                                SUM (A.QTY) REAL
                                                                        FROM
                                                                                ZREPORT_SCM_REAL_SALES A
                                                                                left join ZREPORT_M_PROVINSI B on A.PROPINSI_TO=B.kd_prov
                                                                        WHERE
                                                                                A.ORG IN (3000,4000,5000,7000)
                                                                        AND A.TAHUN = '$tahun'
                                                                        AND A.BULAN = '$bulan'
                                                                        AND A.HARI <= '$hari'
                                                                        AND A.PROPINSI_TO NOT IN ('1092', '0001')
                                                                        AND A.ITEM = '121-302'
                                                                        and B.ID_SCM_SALESREG $sqlregion
                                                                        GROUP BY
                                                                                A.PROPINSI_TO
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
                                                                                                                AND vkorg in (3000,4000,5000,7000)
                                                                                                                GROUP BY
                                                                                                                        region,
                                                                                                                        tipe
                                                                                                        ) D ON c.region = D .region
                                                                                                        AND D .tipe = A .tipe
                                                                                                        WHERE
                                                                                                            A.co in (3000,4000,5000,7000)
                                                                                                        AND A.thn = '$tahun'
                                                                                                        AND A.bln = '$bulan'
                                                                                                        AND A .TIPE = '121-302'
                                                                                                        and b.ID_SCM_SALESREG $sqlregion
                                                                                                        GROUP BY
                                                                                                                A.co,
                                                                                                                A.thn,
                                                                                                                A.bln,
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
                                        )";
		$data = $this->db->query($sql);                                        
        return $data->result_array();
    }

    /**
     * FUNCTION edit DASHBOARD TEAM
     */
    public function RevenuePerKabiroRegion($tahun, $bulan, $hari,$region,$biro) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }

         if (strtolower($region) == "all") {
            $sqlregion = "in (1,2,3)";
        } else if (strtolower($region) == 'curah') {
            $sqlregion = "in(2)";
        } else if ($region == '2') {
            $sqlregion = "in(2)";
        } else {
            $sqlregion = "in(" . $region . ")";
        }

        $sql = "SELECT
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
                                                        AND vkorg in (3000,4000,5000,7000)
                                                        GROUP BY
                                                                region,
                                                                tipe
                                                ) D ON c.region = D .region
                                                AND D .tipe = A .tipe
                                                WHERE
                                                        co in (3000,4000,5000,7000)
                                                AND thn = '$tahun'
                                                AND bln = '$bulan'
                                                AND A .TIPE = '121-301'
                                                and b.ID_SCM_SALESREG $sqlregion
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
                                A.VKBUR prov,
                                SUM (A.REVENUE) REAL_REVENUE
                        FROM
                                MV_REVENUE A
                                left join ZREPORT_M_PROVINSI B on A.VKBUR=B.KD_PROV
                        WHERE
                                A.VKORG IN (3000,4000,5000,7000)
                        AND A.VKBUR NOT IN ('0001', '1092')
                        AND A.MATERIAL = '121-301'
                        AND TO_CHAR (A.BUDAT, 'yyyymm') = '$tahun$bulan'
                        AND TO_CHAR (A.BUDAT, 'dd') <= '$hari'
                        and B.ID_SCM_SALESREG $sqlregion
                        GROUP BY
                                A.VKBUR
                ) TB3 ON TB1.PROV = TB3.PROV
                LEFT JOIN (
                        SELECT
                                tb5.id_prov PROV,
                                tb6.ID_KABIRO,
                                tb6.nama_kabiro
                        FROM
                                ZREPORT_SCM_KABIRO_SALES tb5
                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                        left JOIN zreport_m_provinsi b ON tb5.id_prov = b.kd_prov
                        WHERE
                                TB5.ORG in (3000,4000,5000,7000)
                        AND tb5.ITEM_NO = '121-301'
                        and b.ID_SCM_SALESREG $sqlregion
                ) TB4 ON TB1.PROV = TB4.PROV
                where TB1.PROV in (SELECT A.id_prov FROM ZREPORT_SCM_M_KABIROREGION A
                                                        join ZREPORT_SCM_M_KABIRO B on A.ID_KABIRO=B.ID_KABIRO 
                                                        where B.nama_kabiro='$biro')";

        /*$sql = "SELECT  SUM (TARGET_REVENUE) TARGET_REVENUE,
                        SUM (TARGET_REVENUE_SDK) TARGET_REVENUE_SDK,
                        SUM (REAL_REVENUE) REAL_REVENUE,
                        SUM (SELISIH) SELISIH
				from (
					SELECT
                        tb1.PROV,
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
                                                        AND vkorg in (3000,4000,5000,7000)
                                                        GROUP BY
                                                                region,
                                                                tipe
                                                ) D ON c.region = D .region
                                                AND D .tipe = A .tipe
                                                WHERE
                                                        co in (3000,4000,5000,7000)
                                                AND thn = '$tahun'
                                                AND bln = '$bulan'
                                                AND A .TIPE = '121-301'
                                                and b.ID_SCM_SALESREG $sqlregion
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
                                A.VKBUR prov,
                                SUM (A.REVENUE) REAL_REVENUE
                        FROM
                                MV_REVENUE A
                                left join ZREPORT_M_PROVINSI B on A.VKBUR=B.KD_PROV
                        WHERE
                                A.VKORG IN (3000,4000,5000,7000)
                        AND A.VKBUR NOT IN ('0001', '1092')
                        AND A.MATERIAL = '121-301'
                        AND TO_CHAR (A.BUDAT, 'yyyymm') = '$tahun$bulan'
                        AND TO_CHAR (A.BUDAT, 'dd') <= '$hari'
                        and B.ID_SCM_SALESREG $sqlregion
                        GROUP BY
                                A.VKBUR
                ) TB3 ON TB1.PROV = TB3.PROV
                LEFT JOIN (
                        SELECT
                                tb5.id_prov PROV,
                                tb6.ID_KABIRO,
                                tb6.nama_kabiro
                        FROM
                                ZREPORT_SCM_KABIRO_SALES tb5
                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                        left JOIN zreport_m_provinsi b ON tb5.id_prov = b.kd_prov
                        WHERE
                        TB5.ORG in (3000,4000,5000,7000)
                        AND tb5.ITEM_NO = '121-301'
                        and b.ID_SCM_SALESREG $sqlregion
                ) TB4 ON TB1.PROV = TB4.PROV
                where TB1.PROV in (SELECT A.id_prov FROM ZREPORT_SCM_M_KABIROREGION A
		                                                join ZREPORT_SCM_M_KABIRO B on A.ID_KABIRO=B.ID_KABIRO 
		                                                where B.nama_kabiro='$biro')
                GROUP BY
                        TB1.PROV
		) 

                UNION
	                select          SUM (TARGET_REVENUE) TARGET_REVENUE,
			                        SUM (TARGET_REVENUE_SDK) TARGET_REVENUE_SDK,
			                        SUM (REAL_REVENUE) REAL_REVENUE,
			                        SUM (SELISIH) SELISIH
				from (
						SELECT
                                TB1.PROV,
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
                                                                AND vkorg in (3000,4000,5000,7000)
                                                                GROUP BY
                                                                        region,
                                                                        tipe
                                                        ) D ON c.region = D .region
                                                        AND D .tipe = A .tipe
                                                        WHERE
                                                            A.co in (3000,4000,5000,7000)
                                                        AND A.thn = '$tahun'
                                                        AND A.bln = '$bulan'
                                                        AND A .TIPE = '121-302'
                                                        and b.ID_SCM_SALESREG $sqlregion
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
                                        A.VKBUR prov,
                                        SUM (A.REVENUE) REAL_REVENUE
                                FROM
                                        MV_REVENUE A
                                        left join ZREPORT_M_PROVINSI B on A.VKBUR=B.KD_PROV
                                WHERE
                                        A.VKORG in (3000,4000,5000,7000)
                                AND A.VKBUR NOT IN ('0001', '1092')
                                AND A.MATERIAL = '121-302'
                                AND TO_CHAR (A.BUDAT, 'yyyymm') = '$tahun$bulan'
                                AND TO_CHAR (A.BUDAT, 'dd') <= '$hari'
                                and B.ID_SCM_SALESREG $sqlregion
                                GROUP BY
                                        A.VKBUR
                        ) TB3 ON TB1.PROV = TB3.PROV
                        where TB1.PROV in (SELECT A.id_prov FROM ZREPORT_SCM_M_KABIROREGION A
                    join ZREPORT_SCM_M_KABIRO B on A.ID_KABIRO=B.ID_KABIRO 
                    where B.nama_kabiro='$biro')
           GROUP BY TB1.PROV
				)
                    ";
                    */
        $data = $this->db->query($sql);
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

    /**
     * OLD FUNCTION before edit DASHBOARD TEAM
     */
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

    
    /**
     * OLD FUNCTION before edit DASHBOARD TEAM
     */
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


    /**
     * OLD FUNCTION before edit DASHBOARD TEAM
     */
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

    /**
     * OLD FUNCTION before edit DASHBOARD TEAM
     */
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
                                                AND TB5.ORG = '7000'
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
                                                                                        co = '7000'
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

    /**
     * OLD FUNCTION before edit DASHBOARD TEAM
     */
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

    /**
     * OLD FUNCTION before edit DASHBOARD TEAM
     */
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
                ) TB3 ON TB1.ORG = TB3.ORG";
        //echo $sql;
        $data = $this->db->query($sql);
        return $data->row_array();
    }

    /**
     * OLD FUNCTION before edit DASHBOARD TEAM
     */
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
    
    //CREATED BY YUNITA
    
    function get_chart_volume($tahun, $bulan, $hari, $region){
         if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query(" 
            SELECT
                    NO_URUT,
                    NAMA_KABIRO,
                    DESC_KABIRO,
                    SUM(TARGET) TARGET,
                    SUM(TARGET_REALH) TARGET_REALH,
                    SUM(REAL) REAL,
                    ROUND(SUM(REAL)/SUM(TARGET)*100) PERSENTARGET,
                    ROUND(SUM(TARGET_REALH)/SUM(TARGET)*100) PERSENTARGETH,
                    SUM (TARGET_REALH) / SUM (TARGET) * 100 PENC_SEH
            FROM
                    (
                            SELECT
                                    NO_URUT,
                                    A.ID_KABIRO,
                                    ID_PROV,
                                    MATERIAL,
                                    NAMA_KABIRO,
                                    DESC_KABIRO
                            FROM
                                    ZREPORT_SCM_M_KABIROREGION A
                            LEFT JOIN ZREPORT_SCM_MATERIALREGION B ON A .ID_REGION = B.ID_REGION
                            LEFT JOIN ZREPORT_SCM_M_KABIRO C ON A.ID_KABIRO = C.ID_KABIRO
                            WHERE
                                    A .ID_REGION IN ($region)
                    ) TB0
            LEFT JOIN (
                    SELECT
                            A .prov,
                            A .TIPE,
                            SUM (A .quantum) AS target
                    FROM
                            sap_t_rencana_sales_type A
                    WHERE
                            A .thn = '$tahun'
                    AND A .bln = '$bulan'
                    AND A .prov != '0001'
                    AND A .prov != '1092'
                    GROUP BY
                            A .prov,
                            A .TIPE
            ) TB1 ON ID_PROV = prov
            AND MATERIAL = TB1.TIPE
            LEFT JOIN (
                    SELECT
                            A .ITEM,
                            A .PROPINSI_TO,
                            SUM (A .QTY) REAL
                    FROM
                            ZREPORT_SCM_REAL_SALES A
                    WHERE
                            A .TAHUN = '$tahun'
                    AND A .BULAN = '$bulan'
                    AND A .HARI <= '$hari'
                    AND A .PROPINSI_TO NOT IN ('1092', '0001')
                    GROUP BY
                            A .ITEM,
                            A .PROPINSI_TO
            ) TB2 ON ID_PROV = PROPINSI_TO
            AND MATERIAL = ITEM
            LEFT JOIN (
                    SELECT
                            prov,
                            TIPE,
                            SUM (target_realh) AS target_realh
                    FROM
                            (
                                    SELECT
                                            *
                                    FROM
                                            (
                                                    SELECT
                                                            A .prov,
                                                            A .tipe,
                                                            c.budat,
                                                            SUM (
                                                                    A .quantum * (c.porsi / D .total_porsi)
                                                            ) AS target_realh
                                                    FROM
                                                            sap_t_rencana_sales_type A
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
                                                            GROUP BY
                                                                    vkorg,
                                                                    region,
                                                                    tipe
                                                    ) D ON c.region = D .region
                                                    AND D .tipe = A .tipe
                                                    AND A .co = D .vkorg
                                                    WHERE

                                                     A .thn = '$tahun'
                                                    AND A .bln = '$bulan'
                                                    GROUP BY
                                                            A .thn,
                                                            A .bln,
                                                            A .prov,
                                                            A .tipe,
                                                            c.budat
                                            )
                                    WHERE
                                            budat <= '$tahun$bulan$hari'
                            )
                    GROUP BY
                            prov,
                            TIPE
            ) TB3 ON ID_PROV = TB3.prov
            AND MATERIAL = TB3.TIPE
            GROUP BY 
            NAMA_KABIRO,
            DESC_KABIRO,
            NO_URUT
            ORDER BY 
            NO_URUT
                 ");
//        echo $this->db->last_query();
        return $data->result_array();
    }

    function refresh_mv() {
        $data = $this->db->query("BEGIN
            DBMS_SNAPSHOT.REFRESH('MV_REVENUE');
            END;");
        return array('proccess' => '1');
    }

}
