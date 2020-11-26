<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class GrafikRevenue_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function monitoring_harian($date, $filter) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 2);
        $filterSQLReal = "";
        $filterSQLRkap = "";
        switch ($filter) {
            case 'all':
                break;
            case 'cement':
                break;
            case 'clinker':
                break;
            case 'domestik':
                $filterSQLReal = " AND LFART != 'ZLFE'";
                $filterSQLRkap = " AND prov != '0001'";
                break;
            case 'ekspor':
                $filterSQLReal = " AND LFART = 'ZLFE'";
                $filterSQLRkap = " AND prov = '0001'";
                break;
            default:
                break;
        }
        $data = $this->db->query(" 
            SELECT
                    ORG,
                    TGL,
                    PRICE_REAL,
                    ROUND(REV/1000000000,2) REV,
                    QTY,
                    TGL2,
                    VKORG,
                    ROUND(TARGET/1000000000,2) TARGET,
                    TGL3
                    
            FROM
                    (
                            SELECT
                                    VKORG ORG,
                                    TO_CHAR (BUDAT, 'DD') TGL,
                                    SUM (PENJUALAN) / SUM (TOTAL_QTY) PRICE_REAL,
                                    SUM (ROUND(REVENUE)) REV,
                                    SUM (TOTAL_QTY) QTY
                            FROM
                                    MV_REVENUE
                            WHERE
                                    TO_CHAR (BUDAT, 'YYYYMM') = '$date'
                            AND VKORG != '2000' 
                            $filterSQLReal
                            GROUP BY
                                    TO_CHAR (BUDAT, 'DD'),
                                    VKORG
                            ORDER BY
                                    VKORG
                    ) TB1
            RIGHT JOIN (
                    SELECT
                            TGL2,
                            VKORG
                    FROM
                            (
                                    SELECT
                                            TO_CHAR (
                                                    TRUNC (SYSDATE, 'MONTH') + ROWNUM - 1,
                                                    'dd'
                                            ) TGL2,
                                            'E' AS BRIDGE2
                                    FROM
                                            dual CONNECT BY ROWNUM <= TO_NUMBER (
                                                    TO_CHAR (
                                                            LAST_DAY (TO_DATE('$date', 'yyyymm')),
                                                            'DD'
                                                    )
                                            )
                            ) TB1
                    LEFT JOIN (
                            SELECT DISTINCT
                                    VKORG,
                                    'E' AS BRIDGE
                            FROM
                                    MV_REVENUE
                            WHERE
                                    VKORG != '2000'
                    ) ON BRIDGE = BRIDGE2
            ) Tb2 ON TGL = TGL2
            AND VKORG = ORG
            LEFT JOIN (
                    SELECT
                            A .co COM,
                            SUM (
                                    A .REVENUE * (c.porsi / D .total_porsi)
                            ) AS target,
                            SUBSTR (BUDAT, 7, 2) TGL3
                    FROM
                            sap_t_rencana_sales_type A
                    LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                    AND c.vkorg = A .co
                    AND c.budat LIKE '$date%'
                    AND c.tipe = A .tipe
                    LEFT JOIN (
                            SELECT
                                    region,
                                    tipe,
                                    SUM (porsi) AS total_porsi,
                                    VKORG
                            FROM
                                    zreport_porsi_sales_region
                            WHERE
                                    budat LIKE '$date%' 
                            GROUP BY
                                    region,
                                    vkorg,
                                    tipe
                    ) D ON c.region = D .region
                    AND D .tipe = A .tipe
                    AND D .VKORG = CO
                    WHERE
                            thn = '$tahun'
                    AND bln = '$bulan'
                    AND prov NOT IN ('1092')
                    $filterSQLRkap
                    GROUP BY
                            co,
                            budat
                    ORDER BY
                            budat,
                            COM
            ) tb3 ON TGL2 = TGL3
            AND COM = VKORG
            ORDER BY
                    VKORG,
                    TGL2
                 ");
        //  echo $this->db->last_query();
        return $data->result_array();
    }

    public function monitoring_tahunan($tahun, $filter) {
        $filterSQLReal = "";
        $filterSQLRkap = "";
        switch ($filter) {
            case 'all':
                break;
            case 'cement':
                break;
            case 'clinker':
                break;
            case 'domestik':
                $filterSQLReal = " AND LFART != 'ZLFE'";
                $filterSQLRkap = " AND prov != '0001'";
                break;
            case 'ekspor':
                $filterSQLReal = " AND LFART = 'ZLFE'";
                $filterSQLRkap = " AND prov = '0001'";
                break;
            default:
                break;
        }

        $data = $this->db->query(" 
                    SELECT
                            vkorg ORG,
                            months BLN,
                            '$tahun' THN,
                            NVL(ROUND(REV/1000000000,2),0) REV,
                            NVL (ROUND(RKAP/1000000000,2), 0) RKAP
                    FROM
                    (
                            SELECT
                                    months,
                                    '$tahun' THN,
                                    VKORG
                            FROM
                                    (
                                            SELECT
                                                    TO_CHAR (
                                                            ADD_MONTHS (
                                                                    TRUNC (SYSDATE, 'YYYY'),
                                                                    LEVEL - 1
                                                            ),
                                                            'MM'
                                                    ) months,
                                                    'E' AS BRIDGE2
                                            FROM
                                                    dual CONNECT BY LEVEL <= 12
                                    ) TB1
                            LEFT JOIN (
                                    SELECT DISTINCT
                                            VKORG,
                                            'E' AS BRIDGE
                                    FROM
                                            MV_REVENUE
                                    WHERE
                                            VKORG != '2000'
                            ) ON BRIDGE = BRIDGE2
                    ) MTH
            LEFT JOIN (
                    SELECT
                            VKORG ORG,
                            TO_CHAR (BUDAT, 'YYYY') THN,
                            TO_CHAR (BUDAT, 'MM') BLN,
                            --SUM (PENJUALAN) / SUM (TOTAL_QTY) PRICE_REAL,
                            SUM (REVENUE) REV --SUM (TOTAL_QTY) QTY
                    FROM
                            MV_REVENUE
                    WHERE
                            TO_CHAR (BUDAT, 'YYYY') = $tahun
                            $filterSQLReal
                    AND VKORG != '2000'
                    GROUP BY
                            TO_CHAR (BUDAT, 'MM'),
                            TO_CHAR (BUDAT, 'YYYY'),
                            VKORG
                    ORDER BY
                            VKORG
            ) A ON MTH.months = A .BLN AND MTH.VKORG = A.ORG
            LEFT JOIN (
                    SELECT
                            CO,
                            THN,
                            BLN,
                            SUM (REVENUE) RKAP
                    FROM
                            sap_t_rencana_sales_type
                    WHERE
                            thn = $tahun
                            $filterSQLRkap
                    AND prov NOT IN ('1092')
                    GROUP BY
                            THN,
                            BLN,
                            CO
                    ORDER BY
                            CO,
                            THN,
                            BLN
            ) B ON CO = VKORG
            AND MTH .THN = B.THN
            AND MTH .months = B.BLN
            ORDER BY
                    VKORG,
                    MONTHS,
                    THN
                    ");
         // echo $this->db->last_query();
        return $data->result_array();
    }

    function getPencapaian($date, $filter, $comp = FALSE) {
        $filterSQLReal = "";
        $filterSQLRkap = "";
        switch ($filter) {
            case 'all':
                break;
            case 'cement':
                break;
            case 'clinker':
                break;
            case 'domestik':
                $filterSQLReal = " AND LFART != 'ZLFE'";
                $filterSQLRkap = " AND prov != '0001'";
                break;
            case 'ekspor':
                $filterSQLReal = " AND LFART = 'ZLFE'";
                $filterSQLRkap = " AND prov = '0001'";
                break;
            default:
                break;
        }

//        $tahun = date('Y');
//        $bulan = date('m');
//        $tgl = date('d');
        
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 2);
        
        if ($tahun == date('Y') && $bulan == date('m')) {
            $tgl = date('d');
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tgl = $hari + 1;
        }

        if ($comp) {
            $company = implode("','", $comp);
            $filterCompReal = "AND VKORG IN ('$company')";
            $filterCompRkap = "AND CO IN ('$company')";
        } else {
            $filterCompReal = '';
            $filterCompRkap = '';
        }

        $data = $this->db->query(" SELECT
                A .THN,
                ROUND(REV/1000000000,2) REV,
                ROUND(RKAP/1000000000,2) RKAP,
                ROUND (REV / RKAP * 100) AS PENC,
                RKAP-REV AS GAP
        FROM
                (SELECT '$tahun' THN FROM DUAL) A
        LEFT JOIN (
                SELECT
                        TO_CHAR (BUDAT, 'YYYY') TGL,
                        SUM (REVENUE) REV
                FROM
                        MV_REVENUE
                WHERE
                        TO_CHAR (BUDAT, 'YYYYMM') = '$tahun$bulan'
                            $filterCompReal
                            $filterSQLReal
                AND TO_CHAR (BUDAT, 'DD') < '$tgl'
                AND VKORG != '2000'
                GROUP BY
                        TO_CHAR (BUDAT, 'YYYY')
        ) B ON A .THN = B.TGL
        LEFT JOIN (
                SELECT
                        SUBSTR (BUDAT, 1, 4) THN,
                        SUM (TARGET) RKAP
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
                                                SUM (porsi) AS total_porsi,
                                                VKORG
                                        FROM
                                                zreport_porsi_sales_region
                                        WHERE
                                                budat LIKE '$tahun$bulan%'
                                        GROUP BY
                                                region,
                                                vkorg,
                                                tipe
                                ) D ON c.region = D .region
                                AND D .tipe = A .tipe
                                AND D .VKORG = CO
                                WHERE
                                        thn = '$tahun'
                                AND bln = '$bulan'
                                AND prov NOT IN ('1092')
                                $filterCompRkap
                                $filterSQLRkap
                                GROUP BY
                                        co,
                                        budat
                                ORDER BY
                                        budat,
                                        COM
                        )
                WHERE
                        SUBSTR (BUDAT, 7, 2) < '$tgl'
                AND BUDAT IS NOT NULL
                AND TARGET IS NOT NULL
                GROUP BY
                        SUBSTR (BUDAT, 1, 4)
        ) C ON A .THN = C.THN ");

        return $data->row_array();
    }

    function getPencapaianTahun($date, $filter, $comp = FALSE) {
        $filterSQLReal = "";
        $filterSQLRkap = "";
        switch ($filter) {
            case 'all':
                break;
            case 'cement':
                break;
            case 'clinker':
                break;
            case 'domestik':
                $filterSQLReal = " AND LFART != 'ZLFE'";
                $filterSQLRkap = " AND prov != '0001'";
                break;
            case 'ekspor':
                $filterSQLReal = " AND LFART = 'ZLFE'";
                $filterSQLRkap = " AND prov = '0001'";
                break;
            default:
                break;
        }

        if ($comp) {
            $company = implode("','", $comp);
            $filterCompReal = "AND VKORG IN ('$company')";
            $filterCompRkap = "AND CO IN ('$company')";
        } else {
            $filterCompReal = '';
            $filterCompRkap = '';
        }

        $tahun = substr($date, 0, 4);
        
        if ($tahun == date('Y')) {
            $bulan = date('m');
            $tgl = date('d');
        } else {
            $bulan = '12';
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tgl = $hari + 1;
        }

        $data = $this->db->query(" SELECT
                A.THN,
                ROUND(REV/1000000000,2) REV,
                ROUND(RKAP/1000000000,2) RKAP,
                ROUND(REV/RKAP*100) AS PENC,
                ROUND(RKAP-REV) AS GAP
        FROM
                (SELECT '$tahun' THN FROM DUAL) A
        LEFT JOIN (
                SELECT
                        TO_CHAR (BUDAT, 'YYYY') TGL,
                        SUM (REVENUE) REV
                FROM
                        MV_REVENUE
                WHERE
                        TO_CHAR (BUDAT, 'YYYY') = '$tahun'
                        $filterSQLReal
                        $filterCompReal
                AND TO_CHAR (BUDAT, 'MMDD') < '$bulan$tgl'
                AND VKORG != '2000'
                GROUP BY
                        TO_CHAR (BUDAT, 'YYYY')
        ) B ON A .THN = B.TGL
        LEFT JOIN (
                SELECT
                        THN,
                        SUM (RKAP) RKAP
                FROM
                        (
                                SELECT
                                        THN,
                                        SUM (REVENUE) RKAP
                                FROM
                                        sap_t_rencana_sales_type
                                WHERE
                                        thn = $tahun
                                $filterSQLRkap
                                $filterCompRkap
                                AND prov NOT IN ('1092')
                                AND BLN < $bulan 
                                GROUP BY
                                        THN
                                UNION ALL
                                        SELECT
                                                SUBSTR (BUDAT, 1, 4) TAHUN,
                                                SUM (TARGET) RKAP
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
                                                                        SUM (porsi) AS total_porsi,
                                                                        VKORG
                                                                FROM
                                                                        zreport_porsi_sales_region
                                                                WHERE
                                                                        budat LIKE '$tahun$bulan%'
                                                                GROUP BY
                                                                        region,
                                                                        vkorg,
                                                                        tipe
                                                        ) D ON c.region = D .region
                                                        AND D .tipe = A .tipe
                                                        AND D .VKORG = CO
                                                        WHERE
                                                                thn = '$tahun'
                                                        AND bln = '$bulan'
                                                        $filterSQLRkap
                                                        $filterCompRkap
                                                        AND prov NOT IN ('1092')
                                                        GROUP BY
                                                                co,
                                                                budat
                                                        ORDER BY
                                                                budat,
                                                                COM
                                                )
                                        WHERE
                                                SUBSTR (BUDAT, 7, 2) < '$tgl'
                                        AND BUDAT IS NOT NULL
                                        AND TARGET IS NOT NULL
                                        GROUP BY
                                                SUBSTR (BUDAT, 1, 4)
                        )
                GROUP BY
                        THN
        ) C ON A .THN = C.THN ");

        return $data->row_array();
    }

}
