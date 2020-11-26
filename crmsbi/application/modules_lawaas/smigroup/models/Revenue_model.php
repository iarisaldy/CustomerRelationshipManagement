<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Revenue_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    ################### VOLUME TOTAL ###################

    function getTotalVolsdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.REAL_VOL,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_VOL, 0) REAL_VOL_SDBK
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_VOL
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND HARI <= '$hari'
                                                AND PROPINSI_TO NOT IN ('1092','0001')
                                                GROUP BY
                                                        ORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .quantum * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
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
                                                                AND prov != '1092'
                                                                AND prov != '0001'
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB1.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT 
                                                co org,
                                                SUM (quantum) AS RKAP
                                        FROM
                                                sap_t_rencana_sales_type
                                        WHERE 
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov NOT IN ('1092', '0001')
                                        GROUP BY
                                                co
                                ) TB3 ON TB1.ORG = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A .co org,
                                                (SUM(quantum) *(12 - $bulanlalu) / 12) prog,
                                                SUM (quantum) rkap
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                A .co = '$org'
                                        AND A .thn = '$tahun'
                                        AND prov NOT IN ('1092', '0001')
                                        GROUP BY
                                                A .co
                                ) TB4 ON TB3.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (QTY) REAL_VOL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN < '$bulansdbk'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG
                                ) TB5 ON TB1.ORG = TB5.ORG");
        return $data->row_array();
    }

    function getTotalVolsdkTonasa($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.REAL_VOL,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_VOL, 0) REAL_VOL_SDBK
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        SUM (REALISASI) REAL_VOL
                                                FROM
                                                        (
                                                                SELECT
                                                                        ORG,
                                                                        SUM (QTY) REALISASI
                                                                FROM
                                                                        ZREPORT_SCM_REAL_SALES
                                                                WHERE
                                                                        ORG = '$org'
                                                                AND TAHUN = '$tahun'
                                                                AND BULAN = '$bulan'
                                                                AND HARI <= '$hari'
                                                                -- AND ITEM != '121-200'
                                                                AND PROPINSI_TO NOT IN ('0001', '1092')
                                                                GROUP BY
                                                                        ORG
                                                                UNION
                                                                        SELECT
                                                                                '4000' COM,
                                                                                SUM (\"qty\") realisasi
                                                                        FROM
                                                                                ZREPORT_REAL_ST_ADJ
                                                                        WHERE
                                                                                \"tahun\" = '$tahun'
                                                                        AND \"bulan\" = '$bulan'
                                                                        --AND \"org\" = '$org'
                                                                        group by \"org\"
                                                        )
                                                GROUP BY
                                                        ORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .quantum * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
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
                                                                AND prov != '1092'
                                                                AND prov != '0001'
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB1.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT 
                                                co org,
                                                SUM (quantum) AS RKAP
                                        FROM
                                                sap_t_rencana_sales_type
                                        WHERE 
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov NOT IN ('1092', '0001')
                                        GROUP BY
                                                co
                                ) TB3 ON TB1.ORG = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A .co org,
                                                (SUM(quantum) *(12 - $bulanlalu) / 12) prog,
                                                SUM (quantum) rkap
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                A .co = '$org'
                                        AND A .thn = '$tahun'
                                        AND prov NOT IN ('1092', '0001')
                                        GROUP BY
                                                A .co
                                ) TB4 ON TB3.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (QTY) REAL_VOL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN < '$bulansdbk'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG
                                ) TB5 ON TB1.ORG = TB5.ORG");
        return $data->row_array();
    }

    function getTotalVolTLCCsdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.REAL_VOL,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_VOL, 0) REAL_VOL_SDBK
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_VOL
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND HARI <= '$hari'
                                                AND PROPINSI_TO NOT IN ('1092','0001')
                                                GROUP BY
                                                        ORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .org COM,
                                                                        SUM (
                                                                                A .target * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
                                                                FROM
                                                                        ZREPORT_TARGET_PLANTSCO A
                                                                LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
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
                                                                ) D ON D .tipe = A .tipe
                                                                WHERE
                                                                        org = '$org'
                                                                AND tahun = '$tahun'
                                                                AND bulan = '$bulan'
                                                                AND plant NOT IN ('1092','0001')
                                                                GROUP BY
                                                                        org,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB1.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                org,
                                                SUM (target) AS RKAP
                                        FROM
                                                ZREPORT_TARGET_PLANTSCO
                                        WHERE
                                                org = '$org'
                                        AND tahun = '$tahun'
                                        AND bulan = '$bulan'
                                        AND plant != '1092'
                                        GROUP BY
                                                org
                                ) TB3 ON TB1.ORG = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A.org,
                                                (SUM(target) *(12 - $bulanlalu) / 12) prog,
                                                SUM (target) rkap
                                        FROM
                                                ZREPORT_TARGET_PLANTSCO A
                                        WHERE
                                                A .org = '$org'
                                        AND A .tahun = '$tahun'
                                        AND plant NOT IN ('1092','0001')
                                        GROUP BY
                                                A .org
                                ) TB4 ON TB3.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (QTY) REAL_VOL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN < '$bulansdbk'
                                        AND PROPINSI_TO NOT IN ('1092','0001')
                                        GROUP BY
                                                ORG
                                ) TB5 ON TB1.ORG = TB5.ORG");
        return $data->row_array();
    }

    ################### REVENUE TOTAL ###################

    function getTotalRevsdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.REAL_REV,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_REV, 0) REAL_REV_SDBK
                                FROM
                                        (
                                                SELECT
                                                        VKORG ORG,
                                                        SUM (REVENUE) REAL_REV
                                                FROM
                                                        MV_REVENUE
                                                WHERE
                                                        VKORG = '$org'
                                                AND TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                                                AND TO_CHAR (BUDAT, 'DD') <= '$hari'
                                                AND VKBUR NOT IN ('1092','0001')
                                                GROUP BY
                                                        VKORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .REVENUE * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
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
                                                                AND prov not in ('1092','0001')
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB1.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                co org,
                                                SUM (REVENUE) AS RKAP
                                        FROM
                                                sap_t_rencana_sales_type
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov not in ('1092','0001')
                                        GROUP BY
                                                co
                                ) TB3 ON TB1.ORG = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A .co org,
                                                (SUM(REVENUE) *(12 - $bulanlalu) / 12) prog,
                                                SUM (REVENUE) rkap
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                A .co = '$org'
                                        AND A .thn = '$tahun'
                                        AND prov != '1092'
                                        GROUP BY
                                                A .co
                                ) TB4 ON TB3.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                SUM (REVENUE) REAL_REV
                                        FROM
                                                MV_REVENUE
                                        WHERE
                                                VKORG = '$org'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND TO_CHAR (BUDAT, 'MM') < '$bulansdbk'
                                        AND VKBUR NOT IN ('1092','0001')
                                        GROUP BY
                                                VKORG
                                ) TB5 ON TB1.ORG = TB5.ORG");
        return $data->row_array();
    }

    function getTotalRevTLCCsdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.REAL_REV,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_REV, 0) REAL_REV_SDBK
                                FROM
                                        (
                                                SELECT
                                                        VKORG ORG,
                                                        SUM (PENJUALAN) REAL_REV
                                                FROM
                                                        MV_REVENUE
                                                WHERE
                                                        VKORG = '$org'
                                                AND TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                                                AND TO_CHAR (BUDAT, 'DD') <= '$hari'
                                                AND VKBUR NOT IN ('1092','0001')
                                                GROUP BY
                                                        VKORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .REVENUE * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
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
                                                                AND prov not in ('1092','0001')
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB1.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                co org,
                                                SUM (REVENUE) AS RKAP
                                        FROM
                                                sap_t_rencana_sales_type
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov not in ('1092','0001')
                                        GROUP BY
                                                co
                                ) TB3 ON TB1.ORG = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A .co org,
                                                (SUM(REVENUE) *(12 - $bulanlalu) / 12) prog,
                                                SUM (REVENUE) rkap
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                A .co = '$org'
                                        AND A .thn = '$tahun'
                                        AND prov not in ('1092','0001')
                                        GROUP BY
                                                A .co
                                ) TB4 ON TB3.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                SUM (REVENUE) REAL_REV
                                        FROM
                                                MV_REVENUE
                                        WHERE
                                                VKORG = '$org'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND TO_CHAR (BUDAT, 'MM') < '$bulansdbk'
                                        AND VKBUR NOT IN ('1092','0001')
                                        GROUP BY
                                                VKORG
                                ) TB5 ON TB1.ORG = TB5.ORG");
//        echo $this->db->last_query();
        return $data->row_array();
    }

    ################### PRICE TOTAL ##################

    function getTotalPricesdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        NVL(TB1.PRICE_REAL,0) REAL_PRICE,
                                        NVL(TB2.RKAP_PRICE_BULAN,0) RKAP_PRICE_BULAN,
                                        NVL(TB3.RKAP_PRICE_TAHUN,0) RKAP_PRICE_TAHUN
                                FROM
                                        (
                                                SELECT
                                                        VKORG ORG,
                                                        SUM (REVENUE) / SUM (TOTAL_QTY) PRICE_REAL,
                                                FROM
                                                        MV_REVENUE
                                                WHERE
                                                        VKORG = '$org'
                                                AND TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                                                AND TO_CHAR (BUDAT, 'DD') <= '$hari'
                                                GROUP BY
                                                        VKORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND BLN = '$bulan'
                                        AND PROV NOT IN ('1092')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO
                                ) TB2 ON TB1.ORG = TB2.ORG
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_TAHUN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO
                                ) TB3 ON TB1.ORG = TB3.ORG");
        return $data->row_array();
    }

    function getTotalPricesdk2($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        NVL(TB1.PRICE_REAL,0) REAL_PRICE,
                                        NVL(TB2.RKAP_PRICE_BULAN,0) RKAP_PRICE_BULAN,
                                        NVL(TB3.RKAP_PRICE_TAHUN,0) RKAP_PRICE_TAHUN,
                                        NVL(TB1.REV,0) REV,
                                        NVL(TB1.QTY,0) QTY
                                FROM
                                        (
                                                SELECT
                                                        VKORG ORG,
                                                        SUM (PENJUALAN) / SUM (TOTAL_QTY) PRICE_REAL,
                                                        SUM (PENJUALAN) REV,
                                                        SUM (TOTAL_QTY) QTY
                                                FROM
                                                        MV_REVENUE
                                                WHERE
                                                        VKORG = '$org'
                                                AND TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                                                AND TO_CHAR (BUDAT, 'DD') <= '$hari'
                                                GROUP BY
                                                        VKORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND BLN = '$bulan'
                                        AND PROV NOT IN ('1092','0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO
                                ) TB2 ON TB1.ORG = TB2.ORG
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_TAHUN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092','0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO
                                ) TB3 ON TB1.ORG = TB3.ORG");
        return $data->row_array();
    }

    ################### VOLUME DOMESTIK ###################

    function getDomestikVolsdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $hari = str_pad($tgl - 1, 2, '0', STR_PAD_LEFT);
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB0.ORG,
                                        NVL(TB1.REAL_VOL,0) REAL_VOL,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_VOL, 0) REAL_VOL_SDBK
                                FROM
                                (
                                    SELECT '$org' ORG FROM DUAL
                                )TB0
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (REAL_VOL) REAL_VOL
                                        FROM
                                                (
                                                        SELECT
                                                                ORG,
                                                                SUM (QTY) REAL_VOL
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                ORG = '$org'
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN = '$bulan'
                                                        AND HARI <= '$hari'
                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                ORG
                                                       
                                                )
                                        GROUP BY
                                                ORG
                                ) TB1 ON TB0.ORG = TB1.ORG
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .quantum * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
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
                                                                AND prov != '0001'
                                                                AND prov != '1092'
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB0.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                co org,
                                                SUM (quantum) AS RKAP
                                        FROM
                                                sap_t_rencana_sales_type
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov != '1092'
                                        AND prov != '0001'
                                        GROUP BY
                                                co
                                ) TB3 ON TB0.ORG = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A .co org,
                                                (SUM(quantum) *(12 - $bulanlalu) / 12) prog,
                                                SUM (quantum) rkap
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                A .co = '$org'
                                        AND A .thn = '$tahun'
                                        AND prov != '1092'
                                        AND prov != '0001'
                                        GROUP BY
                                                A .co
                                ) TB4 ON TB0.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (REAL_VOL) REAL_VOL
                                        FROM
                                                (
                                                        SELECT
                                                                ORG,
                                                                SUM (QTY) REAL_VOL
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                ORG = '$org'
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN < '$bulansdbk'
                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                ORG
                                                        UNION
                                                                SELECT
                                                                        \"org\" ORG,
                                                                        SUM (\"qty\") REAL_VOL
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"org\" = '$org'
                                                                AND \"tahun\" = '$tahun'
                                                                AND \"bulan\" < '$bulansdbk'
                                                                GROUP BY
                                                                        \"org\"
                                                )
                                        GROUP BY
                                                ORG
                                ) TB5 ON TB0.ORG = TB5.ORG");
//        echo $this->db->last_query();
        return $data->row_array();
    }

    function getDomestikVolsdkTonasa($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $hari = str_pad($tgl - 1, 2, '0', STR_PAD_LEFT);
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB0.ORG,
                                        NVL(TB1.REAL_VOL,0) REAL_VOL,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_VOL, 0) REAL_VOL_SDBK
                                FROM
                                (
                                    SELECT '$org' ORG FROM DUAL
                                )TB0
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (REAL_VOL) REAL_VOL
                                        FROM
                                                (
                                                        SELECT
                                                                ORG,
                                                                SUM (QTY) REAL_VOL
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                ORG = '$org'
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN = '$bulan'
                                                        AND HARI <= '$hari'
                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                ORG
                                                        UNION
                                                                SELECT
                                                                        '4000' ORG,
                                                                        SUM (\"qty\") REAL_VOL
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
                                ) TB1 ON TB0.ORG = TB1.ORG
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .quantum * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
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
                                                                AND prov != '0001'
                                                                AND prov != '1092'
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB0.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                co org,
                                                SUM (quantum) AS RKAP
                                        FROM
                                                sap_t_rencana_sales_type
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov != '1092'
                                        AND prov != '0001'
                                        GROUP BY
                                                co
                                ) TB3 ON TB0.ORG = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A .co org,
                                                (SUM(quantum) *(12 - $bulanlalu) / 12) prog,
                                                SUM (quantum) rkap
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                A .co = '$org'
                                        AND A .thn = '$tahun'
                                        AND prov != '1092'
                                        AND prov != '0001'
                                        GROUP BY
                                                A .co
                                ) TB4 ON TB0.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (REAL_VOL) REAL_VOL
                                        FROM
                                                (
                                                        SELECT
                                                                ORG,
                                                                SUM (QTY) REAL_VOL
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                ORG = '$org'
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN < '$bulansdbk'
                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                ORG
                                                        UNION
                                                                SELECT
                                                                        \"org\" ORG,
                                                                        SUM (\"qty\") REAL_VOL
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"org\" = '$org'
                                                                AND \"tahun\" = '$tahun'
                                                                AND \"bulan\" < '$bulansdbk'
                                                                GROUP BY
                                                                        \"org\"
                                                )
                                        GROUP BY
                                                ORG
                                ) TB5 ON TB0.ORG = TB5.ORG");
//        echo $this->db->last_query();
        return $data->row_array();
    }

    ################### REVENUE DOMESTIK ###################

    function getDomestikRevsdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $hari = str_pad($tgl - 1, 2, '0', STR_PAD_LEFT);
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB0.ORG,
                                        NVL(TB1.REAL_REV,0) REAL_REV,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_REV, 0) REAL_REV_SDBK
                                FROM (SELECT '$org' ORG FROM DUAL)TB0
                                LEFT JOIN (
                                                SELECT
                                                        VKORG ORG,
                                                        SUM (REVENUE) REAL_REV
                                                FROM
                                                        MV_REVENUE
                                                WHERE
                                                        VKORG = '$org'
                                                AND TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                                                AND TO_CHAR (BUDAT, 'DD') <= '$hari'
                                                AND VKBUR NOT IN ('1092', '0001')
                                                GROUP BY
                                                        VKORG
                                        ) TB1 ON TB0.ORG = TB1.ORG
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .REVENUE * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
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
                                                                AND prov != '0001'
                                                                AND prov != '1092'
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB0.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                co org,
                                                SUM (REVENUE) AS RKAP
                                        FROM
                                                sap_t_rencana_sales_type
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov != '1092'
                                        AND prov != '0001'
                                        GROUP BY
                                                co
                                ) TB3 ON TB0.ORG = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A .co org,
                                                (SUM(REVENUE) *(12 - $bulanlalu) / 12) prog,
                                                SUM (REVENUE) rkap
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                A .co = '$org'
                                        AND A .thn = '$tahun'
                                        AND prov != '1092'
                                        AND prov != '0001'
                                        GROUP BY
                                                A .co
                                ) TB4 ON TB0.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                SUM (REVENUE) REAL_REV
                                        FROM
                                                MV_REVENUE
                                        WHERE
                                                VKORG = '$org'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND TO_CHAR (BUDAT, 'MM') < '$bulansdbk'
                                        AND VKBUR NOT IN ('1092', '0001')
                                        GROUP BY
                                                VKORG
                                ) TB5 ON TB0.ORG = TB5.ORG");
        return $data->row_array();
    }

    ################### PRICE DOMESTIK ##################

    function getDomestikPricesdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        NVL(TB1.PRICE_REAL,0) REAL_PRICE,
                                        NVL(TB2.RKAP_PRICE_BULAN,0) RKAP_PRICE_BULAN,
                                        NVL(TB3.RKAP_PRICE_TAHUN,0) RKAP_PRICE_TAHUN
                                FROM
                                        (
                                                SELECT
                                                        VKORG ORG,
                                                        SUM (REVENUE) / SUM (TOTAL_QTY) PRICE_REAL
                                                FROM
                                                        MV_REVENUE
                                                WHERE
                                                        VKORG = '$org'
                                                AND TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                                                AND TO_CHAR (BUDAT, 'DD') <= '$hari'
                                                AND VKBUR != '0001'
                                                GROUP BY
                                                        VKORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND BLN = '$bulan'
                                        AND PROV NOT IN ('1092', '0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO
                                ) TB2 ON TB1.ORG = TB2.ORG
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_TAHUN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO
                                ) TB3 ON TB1.ORG = TB3.ORG");
        return $data->row_array();
    }

    function getDomestikPricesdk2($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        NVL(TB1.PRICE_REAL,0) REAL_PRICE,
                                        NVL(TB2.RKAP_PRICE_BULAN,0) RKAP_PRICE_BULAN,
                                        NVL(TB3.RKAP_PRICE_TAHUN,0) RKAP_PRICE_TAHUN,
                                        NVL(TB1.REV, 0) REV,
                                        NVL(TB1.QTY, 0) QTY
                                FROM
                                        (
                                                SELECT
                                                        VKORG ORG,
                                                        SUM (PENJUALAN) / SUM (TOTAL_QTY) PRICE_REAL,
                                                        SUM(PENJUALAN) REV,
                                                        SUM(TOTAL_QTY) QTY
                                                FROM
                                                        MV_REVENUE
                                                WHERE
                                                        VKORG = '$org'
                                                AND TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                                                AND TO_CHAR (BUDAT, 'DD') <= '$hari'
                                                AND VKBUR != '0001'
                                                GROUP BY
                                                        VKORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND BLN = '$bulan'
                                        AND PROV NOT IN ('1092', '0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO
                                ) TB2 ON TB1.ORG = TB2.ORG
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_TAHUN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO
                                ) TB3 ON TB1.ORG = TB3.ORG");
        return $data->row_array();
    }

    ################### VOLUME EKSPOR ###################

    function getEksporVolsdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.REAL_VOL,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_VOL, 0) REAL_VOL_SDBK
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_VOL
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND HARI <= '$hari'
                                                AND PROPINSI_TO = '0001'
                                                GROUP BY
                                                        ORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .quantum * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
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
                                                                AND prov = '0001'
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB1.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                co org,
                                                SUM (quantum) AS RKAP
                                        FROM
                                                sap_t_rencana_sales_type
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov = '0001'
                                        GROUP BY
                                                co
                                ) TB3 ON TB1.ORG = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A .co org,
                                                (SUM(quantum) *(12 - $bulanlalu) / 12) prog,
                                                SUM (quantum) rkap
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                A .co = '$org'
                                        AND A .thn = '$tahun'
                                        AND prov = '0001'
                                        GROUP BY
                                                A .co
                                ) TB4 ON TB3.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (QTY) REAL_VOL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN < '$bulansdbk'
                                        AND PROPINSI_TO = '0001'
                                        GROUP BY
                                                ORG
                                ) TB5 ON TB1.ORG = TB5.ORG");
        return $data->row_array();
    }

    ################### REVENUE EKSPOR ###################

    function getEksporRevsdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB2.COM ORG,
                                        TB1.REAL_REV,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_REV, 0) REAL_REV_SDBK
                                FROM
                                        (
                                                SELECT
                                                        VKORG ORG,
                                                        SUM (REVENUE)*13000 REAL_REV
                                                FROM
                                                        MV_REVENUE
                                                WHERE
                                                        VKORG = '$org'
                                                AND TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                                                AND TO_CHAR (BUDAT, 'DD') <= '$hari'
                                                AND VKBUR = '0001'
                                                GROUP BY
                                                        VKORG
                                        ) TB1
                               RIGHT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .REVENUE * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
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
                                                                AND prov = '0001'
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB1.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                co org,
                                                SUM (REVENUE) AS RKAP
                                        FROM
                                                sap_t_rencana_sales_type
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov = '0001'
                                        GROUP BY
                                                co
                                ) TB3 ON TB2.COM = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A .co org,
                                                (SUM(REVENUE) *(12 - $bulanlalu) / 12) prog,
                                                SUM (REVENUE) rkap
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                A .co = '$org'
                                        AND A .thn = '$tahun'
                                        AND prov = '0001'
                                        GROUP BY
                                                A .co
                                ) TB4 ON TB3.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                SUM (REVENUE) REAL_REV
                                        FROM
                                                MV_REVENUE
                                        WHERE
                                                VKORG = '$org'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND TO_CHAR (BUDAT, 'MM') < '$bulansdbk'
                                        AND VKBUR = '0001'
                                        GROUP BY
                                                VKORG
                                ) TB5 ON TB1.ORG = TB5.ORG");
        return $data->row_array();
    }

    function getEksporRevSTsdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        if ($tahun == date("Y")) {
            $bulansdbk = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $bulansdbk = '12';
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB2.COM ORG,
                                        NVL(TB1.REAL_REV,0) REAL_REV,
                                        TB2.PROGNOSE,
                                        TB2.RKAP_SDK,
                                        NVL (TB3.RKAP, 0) RKAP_BULAN,
                                        NVL (TB4.PROG, 0) PROGNOSE_SISABULAN,
                                        NVL (TB4.RKAP, 0) RKAP_TAHUN,
                                        NVL (TB5.REAL_REV, 0) REAL_REV_SDBK
                                FROM
                                        (
                                                SELECT
                                                        VKORG ORG,
                                                        SUM (   CASE WAERS_P
                                                                WHEN 'USD' THEN
                                                                        NET * 13000
                                                                WHEN 'VND' THEN
                                                                        NET * 0.6
                                                                ELSE
                                                                        NET
                                                                END
                                                        ) REAL_REV
                                                FROM
                                                        ZREPORT_REAL_PENJUALAN
                                                WHERE
                                                        VKORG = '$org'
                                                AND TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                                                AND TO_CHAR (BUDAT, 'DD') <= '$hari'
                                                AND VKGRP = '473'
                                                AND LFART <> 'ZNL'
                                                AND add01 <> 'S11LO'
                                                GROUP BY
                                                        VKORG
                                        ) TB1
                               RIGHT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$hari' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .REVENUE * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
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
                                                                AND prov = '0001'
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB1.ORG = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                co org,
                                                SUM (REVENUE) AS RKAP
                                        FROM
                                                sap_t_rencana_sales_type
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov = '0001'
                                        GROUP BY
                                                co
                                ) TB3 ON TB2.COM = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                A .co org,
                                                (SUM(REVENUE) *(12 - $bulanlalu) / 12) prog,
                                                SUM (REVENUE) rkap
                                        FROM
                                                sap_t_rencana_sales_type A
                                        WHERE
                                                A .co = '$org'
                                        AND A .thn = '$tahun'
                                        AND prov = '0001'
                                        GROUP BY
                                                A .co
                                ) TB4 ON TB3.ORG = TB4.ORG
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                SUM (NET)*13000 REAL_REV
                                        FROM
                                                ZREPORT_REAL_PENJUALAN
                                        WHERE
                                                VKORG = '$org'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND TO_CHAR (BUDAT, 'MM') < '$bulansdbk'
                                        AND VKGRP = '473'
                                        AND LFART <> 'ZNL'
                                        AND add01 <> 'S11LO'
                                        GROUP BY
                                                VKORG
                                ) TB5 ON TB2.COM = TB5.ORG");
//        echo $this->db->last_query();
        return $data->row_array();
    }

    ################### PRICE DOMESTIK ##################

    function getEksporPricesdk($org, $date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date("m") && $tahun == date("Y")) {
            $tgl = date("d");
            $tanggal = $tgl . "-" . $bulan . "-" . $tahun;
            $hari = date('d', strtotime($tanggal . "-1 days"));
            $bulanlalu = date('m');
            $bulanlalu--;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $bulanlalu = '12';
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        NVL(TB1.REAL_PRICE,0) REAL_PRICE,
                                        NVL(TB2.RKAP_PRICE_BULAN,0) RKAP_PRICE_BULAN,
                                        NVL(TB3.RKAP_PRICE_TAHUN,0) RKAP_PRICE_TAHUN
                                FROM
                                        (
                                                SELECT
                                                        VKORG ORG,
                                                        (SUM (NET)*130) / SUM(NTGEW) REAL_PRICE
                                                FROM
                                                        ZREPORT_REAL_PENJUALAN
                                                WHERE
                                                        VKORG = '$org'
                                                AND TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                                                AND TO_CHAR (BUDAT, 'DD') <= '$hari'
                                                AND VKGRP = '473'
                                                AND LFART <> 'ZNL'
                                                AND add01 <> 'S11LO'
                                                GROUP BY
                                                        VKORG
                                        ) TB1
                                RIGHT JOIN (
                                        SELECT
                                                CO ORG,
                                                AVG (HARGA) RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND BLN = '$bulan'
                                        AND PROV = '0001'
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO
                                ) TB2 ON TB1.ORG = TB2.ORG
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                AVG (HARGA) RKAP_PRICE_TAHUN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV = '0001'
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO
                                ) TB3 ON TB2.ORG = TB3.ORG");
        return $data->row_array();
    }

    ########################## BULANAN V2 ############################

    function getDomestikBulanan_v2($org, $date) {
        $tahun = substr($date, 0, 4);
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);
            $bulan = date("m");
            $date1 = new DateTime($tahun . "-" . $bulan . "-" . $hari);
            $date1->modify("last day of previous month");
            $bulankemaren = $date1->format("Ymt");

            $tanggal = $tahun . "" . $bulan . "" . $hari;
        } else {
            $bulan = "12";
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $bulankemaren = $tanggal;
        }

        if ($org == '7000') {
            $orgQ = '7000,5000';
        } else {
            $orgQ = $org;
        }

        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.BULAN,
                                        TB1.KWANTUMX,
                                        TB2.RKAP_VOL_BULAN,
                                        TB3.PRICE_REAL,
                                        TB4.RKAP_PRICE_BULAN,
                                        -- TB6.RKAP_REVENUE RKAP_REV_BULAN,
                                        TB2.RKAP_REV_BULAN,
                                        TB5.REAL_REV
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        BULAN,
                                                        SUM (REAL_VOL) KWANTUMX
                                                FROM
                                                        (
                                                                SELECT
                                                                        MAX(ORG) ORG,
                                                                        BULAN,
                                                                        SUM (REAL_VOL) REAL_VOL
                                                                FROM
                                                                        (
                                                                                SELECT
                                                                                        ORG,
                                                                                        CONCAT (CONCAT(TAHUN, BULAN), HARI) TANGGAL,
                                                                                        BULAN,
                                                                                        SUM (QTY) REAL_VOL
                                                                                FROM
                                                                                        ZREPORT_SCM_REAL_SALES
                                                                                WHERE
                                                                                        TAHUN = '$tahun'
                                                                                AND ITEM != '121-200'
                                                                                AND PROPINSI_TO NOT IN ('0001', '1092')
                                                                                AND ORG IN ($orgQ)
                                                                                GROUP BY
                                                                                        ORG,
                                                                                        BULAN,
                                                                                        CONCAT (CONCAT(TAHUN, BULAN), HARI)
                                                                        )
                                                                WHERE
                                                                        TANGGAL <= '$bulankemaren'
                                                                GROUP BY
                                                                        --ORG,
                                                                        BULAN
                                                                UNION
                                                                        SELECT
                                                                                MAX (org) ORG,
                                                                                '$bulan' bulan,
                                                                                SUM (REAL_VOL) REAL_VOL
                                                                        FROM
                                                                                (
                                                                                      SELECT
                                                                                        ORG,
                                                                                        HARI,
                                                                                        TAHUN,
                                                                                        BULAN,
                                                                                        SUM (QTY) REAL_VOL
                                                                                        FROM
                                                                                                ZREPORT_SCM_REAL_SALES
                                                                                        WHERE
                                                                                                TAHUN = '$tahun'
                                                                                            AND BULAN = '$bulan'
                                                                                            AND HARI <= $hari
                                                                                        AND ITEM != '121-200'
                                                                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                                                                        AND ORG IN ($orgQ)
                                                                                        GROUP BY
                                                                                                ORG,
                                                                                                BULAN,
                                                                                                TAHUN,
                                                                                                HARI
                                                                                )
                                                                      
                                                                               
                                                                        GROUP BY
                                                                                BULAN
                                                                        UNION
                                                                        SELECT
                                                                                \"org\" ORG,
                                                                                \"bulan\" BULAN,
                                                                                SUM (\"qty\") KWANTUMX
                                                                        FROM
                                                                                ZREPORT_REAL_ST_ADJ
                                                                        WHERE
                                                                                \"org\" = '$org'
                                                                        AND \"tahun\" = '$tahun'
                                                                        GROUP BY
                                                                                \"org\",
                                                                                \"bulan\"
                                                        )
                                                GROUP BY
                                                        ORG,
                                                        BULAN
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                SUM (QUANTUM) RKAP_VOL_BULAN,
                                                SUM (REVENUE) RKAP_REV_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB2 ON TB1.ORG = TB2.ORG
                                AND TB1.BULAN = TB2.BULAN
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                SUM (PENJUALAN) / SUM (TOTAL_QTY) PRICE_REAL
                                        FROM
                                                MV_REVENUE
                                        WHERE
                                                VKORG = '$org'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND (VKBUR NOT IN('0001') OR VKBUR IS NULL)
                                        GROUP BY
                                                VKORG,
                                                TO_CHAR (BUDAT, 'MM')
                                ) TB3 ON TB1.ORG = TB3.ORG
                                AND TB1.BULAN = TB3.BULAN
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB4 ON TB1.ORG = TB4.ORG
                                AND TB1.BULAN = TB4.BULAN
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (REAL_REV) REAL_REV
                                        FROM
                                                (
                                                        SELECT
                                                                VKORG ORG,
                                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                                SUM (REVENUE) REAL_REV
                                                        FROM
                                                                MV_REVENUE
                                                        WHERE
                                                                VKORG = '$org'
                                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                                        AND TO_CHAR (BUDAT, 'MMDD') <= '$bulan$hari'
                                                        AND VKBUR NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (BUDAT, 'MM')
                                                        UNION
                                                                SELECT
                                                                        TO_CHAR (org) ORG,
                                                                        '$bulan' bulan,
                                                                        SUM (prognose_sisahari) REAL_VOL
                                                                FROM
                                                                        (
                                                                                SELECT
                                                                                        A .co org,
                                                                                        c.budat,
                                                                                        SUM (
                                                                                                A .REVENUE * (c.porsi / D .total_porsi)
                                                                                        ) AS prognose_sisahari
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
                                                                                AND prov != '1092'
                                                                                AND prov != '0001'
                                                                                GROUP BY
                                                                                        co,
                                                                                        thn,
                                                                                        bln,
                                                                                        c.budat
                                                                        )
                                                                WHERE
                                                                        budat > '$tahun$bulan$hari'
                                                                GROUP BY
                                                                        org
                                                )
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB5 ON TB1.ORG = TB5.ORG
                                AND TB1.BULAN = TB5.BULAN
                                LEFT JOIN (
                                    SELECT 
                                            COM ORG,
                                            BULAN,
                                            SUM(CASE WHEN REVENU_RKAP IS NULL THEN 0 ELSE REVENU_RKAP END) RKAP_REVENUE
                                        FROM ZREPORT_RPTREAL_RESUM
                                        WHERE 
                                            COM IN ($org)
                                            AND TAHUN = '$tahun'
                                        GROUP BY COM, BULAN
                                ) TB6 ON TB1.ORG = TB6.ORG
                                AND TB1.BULAN = TB6.BULAN ");
        // echo $this->db->last_query();
        return $data->result_array();
    }

    ########################## BULANAN ###############################

    function getDomestikBulanan($org, $date) {
        $tahun = substr($date, 0, 4);
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);
            $bulan = date("m");
            $date1 = new DateTime($tahun . "-" . $bulan . "-" . $hari);
            $date1->modify("last day of previous month");
            $bulankemaren = $date1->format("Ymt");

            $tanggal = $tahun . "" . $bulan . "" . $hari;
        } else {
            $bulan = "12";
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $bulankemaren = $tanggal;
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.BULAN,
                                        TB1.KWANTUMX,
                                        TB2.RKAP_VOL_BULAN,
                                        TB3.PRICE_REAL,
                                        TB4.RKAP_PRICE_BULAN,
                                        TB2.RKAP_REV_BULAN,
                                        TB5.REAL_REV
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        BULAN,
                                                        SUM (REAL_VOL) KWANTUMX
                                                FROM
                                                        (
                                                                SELECT
                                                                        ORG,
                                                                        BULAN,
                                                                        SUM (REAL_VOL) REAL_VOL
                                                                FROM
                                                                        (
                                                                                SELECT
                                                                                        ORG,
                                                                                        CONCAT (CONCAT(TAHUN, BULAN), HARI) TANGGAL,
                                                                                        BULAN,
                                                                                        SUM (QTY) REAL_VOL
                                                                                FROM
                                                                                        ZREPORT_SCM_REAL_SALES
                                                                                WHERE
                                                                                        TAHUN = '$tahun'
                                                                                AND ITEM != '121-200'
                                                                                AND PROPINSI_TO NOT IN ('0001', '1092')
                                                                                AND ORG = '$org'
                                                                                GROUP BY
                                                                                        ORG,
                                                                                        BULAN,
                                                                                        CONCAT (CONCAT(TAHUN, BULAN), HARI)
                                                                        )
                                                                WHERE
                                                                        TANGGAL <= '$bulankemaren'
                                                                GROUP BY
                                                                        ORG,
                                                                        BULAN
                                                                UNION
                                                                        SELECT
                                                                                TO_CHAR (org) ORG,
                                                                                '$bulan' bulan,
                                                                                SUM (prognose_sisahari) REAL_VOL
                                                                        FROM
                                                                                (
                                                                                        SELECT
                                                                                                A .co org,
                                                                                                c.budat,
                                                                                                SUM (
                                                                                                        A .quantum * (c.porsi / D .total_porsi)
                                                                                                ) AS prognose_sisahari
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
                                                                                        AND prov != '1092'
                                                                                        AND prov != '0001'
                                                                                        GROUP BY
                                                                                                co,
                                                                                                thn,
                                                                                                bln,
                                                                                                c.budat
                                                                                )
                                                                        WHERE
                                                                                budat > '$tahun$bulan$hari'
                                                                        GROUP BY
                                                                                org
                                                                        UNION
                                                                        SELECT
                                                                                \"org\" ORG,
                                                                                \"bulan\" BULAN,
                                                                                SUM (\"qty\") KWANTUMX
                                                                        FROM
                                                                                ZREPORT_REAL_ST_ADJ
                                                                        WHERE
                                                                                \"org\" = '$org'
                                                                        AND \"tahun\" = '$tahun'
                                                                        GROUP BY
                                                                                \"org\",
                                                                                \"bulan\"
                                                        )
                                                GROUP BY
                                                        ORG,
                                                        BULAN
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                SUM (QUANTUM) RKAP_VOL_BULAN,
                                                SUM (REVENUE) RKAP_REV_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB2 ON TB1.ORG = TB2.ORG
                                AND TB1.BULAN = TB2.BULAN
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                SUM (PENJUALAN) / SUM (TOTAL_QTY) PRICE_REAL
                                        FROM
                                                MV_REVENUE
                                        WHERE
                                                VKORG = '$org'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND VKBUR != '0001'
                                        GROUP BY
                                                VKORG,
                                                TO_CHAR (BUDAT, 'MM')
                                ) TB3 ON TB1.ORG = TB3.ORG
                                AND TB1.BULAN = TB3.BULAN
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB4 ON TB1.ORG = TB4.ORG
                                AND TB1.BULAN = TB4.BULAN
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (REAL_REV) REAL_REV
                                        FROM
                                                (
                                                        SELECT
                                                                VKORG ORG,
                                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                                SUM (REVENUE) REAL_REV
                                                        FROM
                                                                MV_REVENUE
                                                        WHERE
                                                                VKORG = '$org'
                                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                                        AND TO_CHAR (BUDAT, 'MMDD') <= '$bulan$hari'
                                                        AND VKBUR NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (BUDAT, 'MM')
                                                        UNION
                                                                SELECT
                                                                        TO_CHAR (org) ORG,
                                                                        '$bulan' bulan,
                                                                        SUM (prognose_sisahari) REAL_VOL
                                                                FROM
                                                                        (
                                                                                SELECT
                                                                                        A .co org,
                                                                                        c.budat,
                                                                                        SUM (
                                                                                                A .REVENUE * (c.porsi / D .total_porsi)
                                                                                        ) AS prognose_sisahari
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
                                                                                AND prov != '1092'
                                                                                AND prov != '0001'
                                                                                GROUP BY
                                                                                        co,
                                                                                        thn,
                                                                                        bln,
                                                                                        c.budat
                                                                        )
                                                                WHERE
                                                                        budat > '$tahun$bulan$hari'
                                                                GROUP BY
                                                                        org
                                                )
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB5 ON TB1.ORG = TB5.ORG
                                AND TB1.BULAN = TB5.BULAN");
        //echo $this->db->last_query();
        return $data->result_array();
    }

    function getEksporBulanan($org, $date) {
        $tahun = substr($date, 0, 4);
        if ($date == date("Ym")) {
            $hari = date("d");
            $bulan = date("m");
            $tanggal = $tahun . "" . $bulan . "" . $hari;
        } else {
            $bulan = "12";
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.BULAN,
                                        TB1.KWANTUMX,
                                        TB2.RKAP_VOL_BULAN,
                                        TB3.PRICE_REAL,
                                        TB4.RKAP_PRICE_BULAN,
                                        TB2.RKAP_REV_BULAN,
                                        TB5.REAL_REV
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        BULAN,
                                                        SUM (REAL_VOL) KWANTUMX
                                                FROM
                                                        (
                                                                SELECT
                                                                        ORG,
                                                                        BULAN,
                                                                        SUM (QTY) REAL_VOL
                                                                FROM
                                                                        ZREPORT_SCM_REAL_SALES
                                                                WHERE
                                                                        TAHUN = '$tahun'
                                                                AND ITEM != '121-200'
                                                                AND PROPINSI_TO = '0001'
                                                                AND ORG = '$org'
                                                                GROUP BY
                                                                        ORG,
                                                                        BULAN
                                                                UNION
                                                                        SELECT
                                                                                TO_CHAR (org) ORG,
                                                                                '$bulan' bulan,
                                                                                SUM (prognose_sisahari) REAL_VOL
                                                                        FROM
                                                                                (
                                                                                        SELECT
                                                                                                A .co org,
                                                                                                c.budat,
                                                                                                SUM (
                                                                                                        A .quantum * (c.porsi / D .total_porsi)
                                                                                                ) AS prognose_sisahari
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
                                                                                        AND prov = '0001'
                                                                                        GROUP BY
                                                                                                co,
                                                                                                thn,
                                                                                                bln,
                                                                                                c.budat
                                                                                )
                                                                        WHERE
                                                                                budat > '$tahun$bulan$hari'
                                                                        GROUP BY
                                                                                org
                                                        )
                                                GROUP BY
                                                        ORG,
                                                        BULAN
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                SUM (QUANTUM) RKAP_VOL_BULAN,
                                                SUM (REVENUE) RKAP_REV_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV = '0001'
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB2 ON TB1.ORG = TB2.ORG
                                AND TB1.BULAN = TB2.BULAN
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                CASE SUM (NTGEW)
                                                WHEN 0 THEN
                                                        0
                                                ELSE
                                                        SUM (NET) / SUM (NTGEW)
                                                END AS PRICE_REAL
                                        FROM
                                                ZREPORT_REAL_PENJUALAN
                                        WHERE
                                                VKORG = '$org'
                                        AND VKGRP = '473'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        GROUP BY
                                                VKORG,
                                                TO_CHAR (BUDAT, 'MM')
                                ) TB3 ON TB1.ORG = TB3.ORG
                                AND TB1.BULAN = TB3.BULAN
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                CASE SUM (QUANTUM)
                                                WHEN 0 THEN
                                                        0
                                                ELSE
                                                        SUM (REVENUE) / SUM (QUANTUM)
                                                END AS RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV = '0001'
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB4 ON TB1.ORG = TB4.ORG
                                AND TB1.BULAN = TB4.BULAN
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (REAL_REV) REAL_REV
                                        FROM
                                                (
                                                        SELECT
                                                                VKORG ORG,
                                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                                SUM (NET) REAL_REV
                                                        FROM
                                                                ZREPORT_REAL_PENJUALAN
                                                        WHERE
                                                                VKORG = '$org'
                                                        AND VKGRP = '473'
                                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (BUDAT, 'MM')
                                                        
                                                )
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB5 ON TB1.ORG = TB5.ORG
                                AND TB1.BULAN = TB5.BULAN");
//        echo $this->db->last_query();
        return $data->result_array();
    }

    function getDomestikBulananTLCC_old($org, $date) {
        $tahun = substr($date, 0, 4);
        if ($date == date("Ym")) {
            $hari = date("d");
            $bulan = date("m");
            $tanggal = $tahun . "" . $bulan . "" . $hari;
        } else {
            $bulan = "12";
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.BULAN,
                                        TB1.KWANTUMX,
                                        TB2.RKAP_VOL_BULAN,
                                        TB3.PRICE_REAL,
                                        TB4.RKAP_PRICE_BULAN,
                                        TB6.RKAP_REVENUE RKAP_REV_BULAN,
                                        TB5.REAL_REV
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        BULAN,
                                                        SUM (REAL_VOL) KWANTUMX
                                                FROM
                                                        (
                                                                SELECT
                                                                        ORG,
                                                                        BULAN,
                                                                        SUM (QTY) REAL_VOL
                                                                FROM
                                                                        ZREPORT_SCM_REAL_SALES
                                                                WHERE
                                                                        TAHUN = '$tahun'
                                                                AND ITEM != '121-200'
                                                                AND PROPINSI_TO NOT IN ('0001', '1092')
                                                                AND ORG = '$org'
                                                                GROUP BY
                                                                        ORG,
                                                                        BULAN
                                                                UNION
                                                                        SELECT
                                                                                TO_CHAR (org) ORG,
                                                                                '$bulan' bulan,
                                                                                SUM (prognose_sisahari) REAL_VOL
                                                                        FROM
                                                                                (
                                                                                        SELECT
                                                                                                A .ORG,
                                                                                                c.budat,
                                                                                                SUM (
                                                                                                        A .TARGET * (c.porsi / D .total_porsi)
                                                                                                ) AS prognose_sisahari
                                                                                        FROM
                                                                                                ZREPORT_TARGET_PLANTSCO A
                                                                                        LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .ORG
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
                                                                                                ORG = '$org'
                                                                                        AND TAHUN = '$tahun'
                                                                                        AND BULAN = '$bulan'
                                                                                        AND PLANT != '1092'
                                                                                        AND PLANT != '0001'
                                                                                        GROUP BY
                                                                                                ORG,
                                                                                                TAHUN,
                                                                                                BULAN,
                                                                                                c.budat
                                                                                )
                                                                        WHERE
                                                                                budat > '$tahun$bulan$hari'
                                                                        GROUP BY
                                                                                org
                                                        )
                                                GROUP BY
                                                        ORG,
                                                        BULAN
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (TARGET) RKAP_VOL_BULAN,
                                                0 RKAP_REV_BULAN
                                        FROM
                                                ZREPORT_TARGET_PLANTSCO
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND PLANT NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB2 ON TB1.ORG = TB2.ORG
                                AND TB1.BULAN = TB2.BULAN
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                SUM (PENJUALAN) / SUM (TOTAL_QTY) PRICE_REAL
                                        FROM
                                                MV_REVENUE
                                        WHERE
                                                VKORG = '$org'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND (VKBUR != '0001' OR VKBUR IS NULL)
                                        GROUP BY
                                                VKORG,
                                                TO_CHAR (BUDAT, 'MM')
                                ) TB3 ON TB1.ORG = TB3.ORG
                                AND TB1.BULAN = TB3.BULAN
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB4 ON TB1.ORG = TB4.ORG
                                AND TB1.BULAN = TB4.BULAN
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (REAL_REV) REAL_REV
                                        FROM
                                                (
                                                        SELECT
                                                                VKORG ORG,
                                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                                SUM (REVENUE) REAL_REV
                                                        FROM
                                                                MV_REVENUE
                                                        WHERE
                                                                VKORG = '$org'
                                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                                        AND VKBUR NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (BUDAT, 'MM')
                                                        UNION
                                                                SELECT
                                                                        TO_CHAR (org) ORG,
                                                                        '$bulan' bulan,
                                                                        SUM (prognose_sisahari) REAL_VOL
                                                                FROM
                                                                        (
                                                                                SELECT
                                                                                        A .co org,
                                                                                        c.budat,
                                                                                        SUM (
                                                                                                A .REVENUE * (c.porsi / D .total_porsi)
                                                                                        ) AS prognose_sisahari
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
                                                                                AND prov != '1092'
                                                                                AND prov != '0001'
                                                                                GROUP BY
                                                                                        co,
                                                                                        thn,
                                                                                        bln,
                                                                                        c.budat
                                                                        )
                                                                WHERE
                                                                        budat > '$tahun$bulan$hari'
                                                                GROUP BY
                                                                        org
                                                )
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB5 ON TB1.ORG = TB5.ORG
                                AND TB1.BULAN = TB5.BULAN 
                                LEFT JOIN (
                                    SELECT 
                                            COM ORG,
                                            BULAN,
                                            SUM(CASE WHEN REVENU_RKAP IS NULL THEN 0 ELSE REVENU_RKAP END) RKAP_REVENUE
                                        FROM ZREPORT_RPTREAL_RESUM
                                        WHERE 
                                            COM IN ($org)
                                            AND TAHUN = '$tahun'
                                        GROUP BY COM, BULAN
                                ) TB6 ON TB1.ORG = TB6.ORG AND TB1.BULAN = TB6.BULAN");
        return $data->result_array();
    }

    function getDomestikBulananTLCC($org, $date) {
        $tahun = substr($date, 0, 4);
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);
            $bulan = date("m");
            $tanggal = $tahun . "" . $bulan . "" . $hari;
        } else {
            $bulan = "12";
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.BULAN,
                                        TB1.KWANTUMX,
                                        TB2.RKAP_VOL_BULAN,
                                        TB3.PRICE_REAL,
                                        TB4.RKAP_PRICE_BULAN,
                                        TB4.RKAP_REV RKAP_REV_BULAN,
                                        TB5.REAL_REV
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        BULAN,
                                                        SUM (REAL_VOL) KWANTUMX
                                                FROM
                                                        (
                                                                SELECT
                                                                        ORG,
                                                                        BULAN,
                                                                        SUM (QTY) REAL_VOL
                                                                FROM
                                                                        ZREPORT_SCM_REAL_SALES
                                                                WHERE
                                                                        TAHUN = '$tahun' AND
                                                                         BULAN || HARI <= '$bulan$hari'
                                                                AND ITEM != '121-200'
                                                                AND PROPINSI_TO NOT IN ('0001', '1092')
                                                                AND ORG = '$org'
                                                                GROUP BY
                                                                        ORG,
                                                                        BULAN
                                                                                                                        )
                                                GROUP BY
                                                        ORG,
                                                        BULAN
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (TARGET) RKAP_VOL_BULAN,
                                                0 RKAP_REV_BULAN
                                        FROM
                                                ZREPORT_TARGET_PLANTSCO
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND PLANT NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB2 ON TB1.ORG = TB2.ORG
                                AND TB1.BULAN = TB2.BULAN
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                SUM (PENJUALAN) / SUM (TOTAL_QTY) PRICE_REAL
                                        FROM
                                                MV_REVENUE
                                        WHERE
                                                VKORG = '$org'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND (VKBUR != '0001' OR VKBUR IS NULL)
                                        GROUP BY
                                                VKORG,
                                                TO_CHAR (BUDAT, 'MM')
                                ) TB3 ON TB1.ORG = TB3.ORG
                                AND TB1.BULAN = TB3.BULAN
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_BULAN,
                                                SUM(REVENUE) RKAP_REV
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB4 ON TB1.ORG = TB4.ORG
                                AND TB1.BULAN = TB4.BULAN
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (REAL_REV) REAL_REV,
                                                SUM (PENJUALAN) PENJUALAN,
                                                SUM (TOTAL_QTY) TOTaL_QTY
                                        FROM
                                                (
                                                        SELECT
                                                                VKORG ORG,
                                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                                SUM (REVENUE) REAL_REV,
                                                                SUM (PENJUALAN) PENJUALAN,
                                                                SUM (TOTAL_QTY) TOTAL_QTY
                                                        FROM
                                                                MV_REVENUE
                                                        WHERE
                                                                VKORG = '$org'
                                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                                        AND TO_CHAR (BUDAT, 'MMDD') <= '$bulan$hari'
                                                        AND VKBUR NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (BUDAT, 'MM')
                                                        
                                                )
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB5 ON TB1.ORG = TB5.ORG
                                AND TB1.BULAN = TB5.BULAN 
                                LEFT JOIN (
                                    SELECT 
                                            COM ORG,
                                            BULAN,
                                            SUM(CASE WHEN REVENU_RKAP IS NULL THEN 0 ELSE REVENU_RKAP END) RKAP_REVENUE
                                        FROM ZREPORT_RPTREAL_RESUM
                                        WHERE 
                                            COM IN ($org)
                                            AND TAHUN = '$tahun'
                                        GROUP BY COM, BULAN
                                ) TB6 ON TB1.ORG = TB6.ORG AND TB1.BULAN = TB6.BULAN ORDER BY  TB1.BULAN");
        return $data->result_array();
    }

    function getEksporBulananTLCC($org, $date) {
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.BULAN,
                                        TB1.KWANTUMX,
                                        NVL (TB2.RKAP_VOL_BULAN, 0) RKAP_VOL_BULAN,
                                        TB3.PRICE_REAL,
                                        '0' RKAP_PRICE_BULAN,
                                        '0' RKAP_REV_BULAN,
                                        TB5.REAL_REV
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        BULAN,
                                                        SUM (REAL_VOL) KWANTUMX
                                                FROM
                                                        (
                                                                SELECT
                                                                        ORG,
                                                                        BULAN,
                                                                        SUM (QTY) REAL_VOL
                                                                FROM
                                                                        ZREPORT_SCM_REAL_SALES
                                                                WHERE
                                                                        TAHUN = '2017'
                                                                AND ITEM != '121-200'
                                                                AND PROPINSI_TO = '0001'
                                                                AND ORG = '6000'
                                                                GROUP BY
                                                                        ORG,
                                                                        BULAN
                                                                UNION
                                                                        SELECT
                                                                                TO_CHAR (org) ORG,
                                                                                '02' bulan,
                                                                                SUM (prognose) REAL_VOL
                                                                        FROM
                                                                                (
                                                                                        SELECT
                                                                                                A .org,
                                                                                                SUM (
                                                                                                        A .target * (c.porsi / D .total_porsi)
                                                                                                ) AS prognose,
                                                                                                BUDAT
                                                                                        FROM
                                                                                                ZREPORT_TARGET_PLANTSCO A
                                                                                        LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
                                                                                        AND c.budat LIKE '201702%'
                                                                                        AND c.tipe = A .tipe
                                                                                        LEFT JOIN (
                                                                                                SELECT
                                                                                                        region,
                                                                                                        tipe,
                                                                                                        SUM (porsi) AS total_porsi
                                                                                                FROM
                                                                                                        zreport_porsi_sales_region
                                                                                                WHERE
                                                                                                        budat LIKE '201702%'
                                                                                                AND vkorg = '6000'
                                                                                                GROUP BY
                                                                                                        region,
                                                                                                        tipe
                                                                                        ) D ON D .tipe = A .tipe
                                                                                        WHERE
                                                                                                org = '6000'
                                                                                        AND tahun = '2017'
                                                                                        AND bulan = '02'
                                                                                        AND plant = '0001'
                                                                                        GROUP BY
                                                                                                org,
                                                                                                budat
                                                                                )
                                                                        WHERE
                                                                                budat > '20170223'
                                                                        GROUP BY
                                                                                org
                                                        )
                                                GROUP BY
                                                        ORG,
                                                        BULAN
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (TARGET) RKAP_VOL_BULAN,
                                                '0' RKAP_REV_BULAN
                                        FROM
                                                ZREPORT_TARGET_PLANTSCO
                                        WHERE
                                                ORG = '6000'
                                        AND TAHUN = '2017'
                                        AND PLANT = '0001'
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB2 ON TB1.ORG = TB2.ORG
                                AND TB1.BULAN = TB2.BULAN
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                CASE SUM (NTGEW)
                                        WHEN 0 THEN
                                                0
                                        ELSE
                                                SUM (NET) / SUM (NTGEW)
                                        END AS PRICE_REAL
                                        FROM
                                                ZREPORT_REAL_PENJUALAN
                                        WHERE
                                                VKORG = '6000'
                                        AND VKGRP = '473'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '2017'
                                        GROUP BY
                                                VKORG,
                                                TO_CHAR (BUDAT, 'MM')
                                ) TB3 ON TB1.ORG = TB3.ORG
                                AND TB1.BULAN = TB3.BULAN
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (REAL_REV) REAL_REV
                                        FROM
                                                (
                                                        SELECT
                                                                VKORG ORG,
                                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                                SUM (NET) REAL_REV
                                                        FROM
                                                                ZREPORT_REAL_PENJUALAN
                                                        WHERE
                                                                VKORG = '6000'
                                                        AND VKGRP = '473'
                                                        AND TO_CHAR (BUDAT, 'YYYY') = '2017'
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (BUDAT, 'MM')
                                                        UNION
                                                                SELECT
                                                                        TO_CHAR (org) ORG,
                                                                        '02' bulan,
                                                                        SUM (prognose_sisahari) REAL_VOL
                                                                FROM
                                                                        (
                                                                                SELECT
                                                                                        A .co org,
                                                                                        c.budat,
                                                                                        SUM (
                                                                                                A .REVENUE * (c.porsi / D .total_porsi)
                                                                                        ) AS prognose_sisahari
                                                                                FROM
                                                                                        sap_t_rencana_sales_type A
                                                                                LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                                                                AND c.vkorg = A .co
                                                                                AND c.budat LIKE '201702%'
                                                                                AND c.tipe = A .tipe
                                                                                LEFT JOIN (
                                                                                        SELECT
                                                                                                region,
                                                                                                tipe,
                                                                                                SUM (porsi) AS total_porsi
                                                                                        FROM
                                                                                                zreport_porsi_sales_region
                                                                                        WHERE
                                                                                                budat LIKE '201702%'
                                                                                        AND vkorg = '6000'
                                                                                        GROUP BY
                                                                                                region,
                                                                                                tipe
                                                                                ) D ON c.region = D .region
                                                                                AND D .tipe = A .tipe
                                                                                WHERE
                                                                                        co = '6000'
                                                                                AND thn = '2017'
                                                                                AND bln = '02'
                                                                                AND prov = '0001'
                                                                                GROUP BY
                                                                                        co,
                                                                                        thn,
                                                                                        bln,
                                                                                        c.budat
                                                                        )
                                                                WHERE
                                                                        budat > '20170223'
                                                                GROUP BY
                                                                        org
                                                )
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB5 ON TB1.ORG = TB5.ORG
                                AND TB1.BULAN = TB5.BULAN");
        return $data->result_array();
    }

    ########################## BULANAN V3 based on BCS ############################

    function getDomestikBulanan_v3($org, $date) {
        $tahun = substr($date, 0, 4);
        if ($date == date("Ym")) {
            $hariini = date("d");
            $hari = str_pad($hariini - 1, 2, '0', STR_PAD_LEFT);
            $bulan = date("m");
            $date1 = new DateTime($tahun . "-" . $bulan . "-" . $hari);
            $date1->modify("last day of previous month");
            $bulankemaren = $date1->format("Ymt");

            $tanggal = $tahun . "" . $bulan . "" . $hari;
        } else {
            $bulan = "12";
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            //$hariini = $hari;
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $bulankemaren = $tanggal;
        }

        if ($org == '7000') {
            $orgQ = '7000,5000';
        } else {
            $orgQ = $org;
        }

        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.BULAN,
                                        TB1.KWANTUMX,
                                        TB2.RKAP_VOL_BULAN,
                                        TB3.PRICE_REAL,
                                        TB4.RKAP_PRICE_BULAN,
                                        TB2.RKAP_REV_BULAN,
                                        TB5.REAL_REV
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        BULAN,
                                                        SUM (REAL_VOL) KWANTUMX
                                                FROM
                                                        (
                                                                SELECT
                                                                        MAX(ORG) ORG,
                                                                        BULAN,
                                                                        SUM (REAL_VOL) REAL_VOL
                                                                FROM
                                                                        (
                                                                                SELECT
                                                                                        ORG,
                                                                                        CONCAT (CONCAT(TAHUN, BULAN), HARI) TANGGAL,
                                                                                        BULAN,
                                                                                        SUM (QTY) REAL_VOL
                                                                                FROM
                                                                                        ZREPORT_SCM_REAL_SALES
                                                                                WHERE
                                                                                        TAHUN = '$tahun'
                                                                                --AND ITEM != '121-200'
                                                                                AND PROPINSI_TO NOT IN ('0001', '1092')
                                                                                AND ORG IN ($orgQ)
                                                                                GROUP BY
                                                                                        ORG,
                                                                                        BULAN,
                                                                                        CONCAT (CONCAT(TAHUN, BULAN), HARI)
                                                                        )
                                                                WHERE
                                                                        TANGGAL <= '$bulankemaren'
                                                                GROUP BY
                                                                        --ORG,
                                                                        BULAN
                                                                UNION
                                                                        SELECT
                                                                                MAX (org) ORG,
                                                                                '$bulan' bulan,
                                                                                SUM (REAL_VOL) REAL_VOL
                                                                        FROM
                                                                                (
                                                                                      SELECT
                                                                                        ORG,
                                                                                        HARI,
                                                                                        TAHUN,
                                                                                        BULAN,
                                                                                        SUM (QTY) REAL_VOL
                                                                                        FROM
                                                                                                ZREPORT_SCM_REAL_SALES
                                                                                        WHERE
                                                                                                TAHUN = '$tahun'
                                                                                            AND BULAN = '$bulan'
                                                                                            AND HARI <= $hari
                                                                                        --AND ITEM != '121-200'
                                                                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                                                                        AND ORG IN ($orgQ)
                                                                                        GROUP BY
                                                                                                ORG,
                                                                                                BULAN,
                                                                                                TAHUN,
                                                                                                HARI
                                                                                )
                                                                      
                                                                               
                                                                        GROUP BY
                                                                                BULAN
                                                                        UNION
                                                                        SELECT
                                                                                \"org\" ORG,
                                                                                \"bulan\" BULAN,
                                                                                SUM (\"qty\") KWANTUMX
                                                                        FROM
                                                                                ZREPORT_REAL_ST_ADJ
                                                                        WHERE
                                                                                \"org\" = '$org'
                                                                        AND \"tahun\" = '$tahun'
                                                                        GROUP BY
                                                                                \"org\",
                                                                                \"bulan\"
                                                        )
                                                GROUP BY
                                                        ORG,
                                                        BULAN
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                SUM (QUANTUM) RKAP_VOL_BULAN,
                                                SUM (REVENUE) RKAP_REV_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB2 ON TB1.ORG = TB2.ORG
                                AND TB1.BULAN = TB2.BULAN
                                LEFT JOIN (
                                        SELECT
                                                '$org' ORG,
                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                SUM (PENJUALAN) / SUM (TOTAL_QTY) PRICE_REAL
                                        FROM
                                                MV_REVENUE
                                        WHERE
                                                VKORG IN ($orgQ)
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND (VKBUR NOT IN('0001') OR VKBUR IS NULL)
                                        GROUP BY
                                                TO_CHAR (BUDAT, 'MM')
                                ) TB3 ON TB1.ORG = TB3.ORG
                                AND TB1.BULAN = TB3.BULAN
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB4 ON TB1.ORG = TB4.ORG
                                AND TB1.BULAN = TB4.BULAN
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (REAL_REV) REAL_REV,
                                                SUM(PENJUALAN) PENJUALAN,
                                                SUM(TOTAL_QTY) TOTAL_QTY
                                        FROM
                                                (
                                                        SELECT
                                                                '$org' ORG,
                                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                                SUM (REVENUE) REAL_REV,
                                                                SUM(PENJUALAN) PENJUALAN,
                                                                SUM(TOTAL_QTY) TOTAL_QTY
                                                        FROM
                                                                MV_REVENUE
                                                        WHERE
                                                                VKORG IN ($orgQ)
                                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                                        AND TO_CHAR (BUDAT, 'MMDD') <= '$bulan$hari'
                                                        AND VKBUR NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (BUDAT, 'MM')
                                                        
                                                )
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB5 ON TB1.ORG = TB5.ORG
                                AND TB1.BULAN = TB5.BULAN
                                LEFT JOIN (
                                    SELECT 
                                            '$org' ORG,
                                            BULAN,
                                            SUM(CASE WHEN REVENU_RKAP IS NULL THEN 0 ELSE REVENU_RKAP END) RKAP_REVENUE
                                        FROM ZREPORT_RPTREAL_RESUM
                                        WHERE 
                                            COM IN ($orgQ)
                                            AND TAHUN = '$tahun'
                                        GROUP BY COM,BULAN
                                ) TB6 ON TB1.ORG = TB6.ORG
                                AND TB1.BULAN = TB6.BULAN ORDER BY TB1.BULAN");
        // echo $this->db->last_query();
        return $data->result_array();
        // TLCC v2 //
    }

    //TLCC v2//
    function getDomestikBulananTLCCv2($org, $date) {
        $tahun = substr($date, 0, 4);
        if ($date == date("Ym")) {
            $hari = date("d");
            $bulan = date("m");
            $tanggal = $tahun . "" . $bulan . "" . $hari;
        } else {
            $bulan = "12";
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
        }
        $data = $this->db->query("SELECT
                                        TB1.ORG,
                                        TB1.BULAN,
                                        TB1.KWANTUMX,
                                        TB2.RKAP_VOL_BULAN,
                                        TB3.PRICE_REAL,
                                        TB4.RKAP_PRICE_BULAN,
                                        TB2.RKAP_REV_BULAN,
                                        TB5.REAL_REV
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        BULAN,
                                                        SUM (REAL_VOL) KWANTUMX
                                                FROM
                                                        (
                                                                SELECT
                                                                        ORG,
                                                                        BULAN,
                                                                        SUM (QTY) REAL_VOL
                                                                FROM
                                                                        ZREPORT_SCM_REAL_SALES
                                                                WHERE
                                                                        TAHUN = '$tahun'
                                                                AND ITEM != '121-200'
                                                                AND PROPINSI_TO NOT IN ('0001', '1092')
                                                                AND ORG = '$org'
                                                                GROUP BY
                                                                        ORG,
                                                                        BULAN
                                                                UNION
                                                                        SELECT
                                                                                TO_CHAR (org) ORG,
                                                                                '$bulan' bulan,
                                                                                SUM (prognose_sisahari) REAL_VOL
                                                                        FROM
                                                                                (
                                                                                        SELECT
                                                                                                A .ORG,
                                                                                                c.budat,
                                                                                                SUM (
                                                                                                        A .TARGET * (c.porsi / D .total_porsi)
                                                                                                ) AS prognose_sisahari
                                                                                        FROM
                                                                                                ZREPORT_TARGET_PLANTSCO A
                                                                                        LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .ORG
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
                                                                                                ORG = '$org'
                                                                                        AND TAHUN = '$tahun'
                                                                                        AND BULAN = '$bulan'
                                                                                        AND PLANT != '1092'
                                                                                        AND PLANT != '0001'
                                                                                        GROUP BY
                                                                                                ORG,
                                                                                                TAHUN,
                                                                                                BULAN,
                                                                                                c.budat
                                                                                )
                                                                        WHERE
                                                                                budat > '$tahun$bulan$hari'
                                                                        GROUP BY
                                                                                org
                                                        )
                                                GROUP BY
                                                        ORG,
                                                        BULAN
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (TARGET) RKAP_VOL_BULAN,
                                                0 RKAP_REV_BULAN
                                        FROM
                                                ZREPORT_TARGET_PLANTSCO
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND PLANT NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB2 ON TB1.ORG = TB2.ORG
                                AND TB1.BULAN = TB2.BULAN
                                LEFT JOIN (
                                        SELECT
                                                VKORG ORG,
                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                SUM (PENJUALAN) / SUM (TOTAL_QTY) PRICE_REAL
                                        FROM
                                                MV_REVENUE
                                        WHERE
                                                VKORG = '$org'
                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                        AND (VKBUR != '0001' OR VKBUR IS NULL)
                                        GROUP BY
                                                VKORG,
                                                TO_CHAR (BUDAT, 'MM')
                                ) TB3 ON TB1.ORG = TB3.ORG
                                AND TB1.BULAN = TB3.BULAN
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                BLN BULAN,
                                                SUM(REVENUE)/SUM(QUANTUM) RKAP_PRICE_BULAN
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND PROV NOT IN ('1092', '0001')
                                        AND (HARGA IS NOT NULL OR HARGA != 0)
                                        GROUP BY
                                                CO,
                                                BLN
                                ) TB4 ON TB1.ORG = TB4.ORG
                                AND TB1.BULAN = TB4.BULAN
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                BULAN,
                                                SUM (REAL_REV) REAL_REV
                                        FROM
                                                (
                                                        SELECT
                                                                VKORG ORG,
                                                                TO_CHAR (BUDAT, 'MM') BULAN,
                                                                SUM (REVENUE) REAL_REV
                                                        FROM
                                                                MV_REVENUE
                                                        WHERE
                                                                VKORG = '$org'
                                                        AND TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                                                        AND VKBUR NOT IN ('1092', '0001')
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (BUDAT, 'MM')
                                                        
                                                )
                                        GROUP BY
                                                ORG,
                                                BULAN
                                ) TB5 ON TB1.ORG = TB5.ORG
                                AND TB1.BULAN = TB5.BULAN 
                                LEFT JOIN (
                                    SELECT 
                                            COM ORG,
                                            BULAN,
                                            SUM(CASE WHEN REVENU_RKAP IS NULL THEN 0 ELSE REVENU_RKAP END) RKAP_REVENUE
                                        FROM ZREPORT_RPTREAL_RESUM
                                        WHERE 
                                            COM IN ($org)
                                            AND TAHUN = '$tahun'
                                        GROUP BY COM, BULAN
                                ) TB6 ON TB1.ORG = TB6.ORG");
        return $data->result_array();
    }

}
