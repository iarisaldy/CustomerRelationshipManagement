<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

date_default_timezone_set('Asia/Jakarta');

class SalezRealization_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function SalesProvinceTLCC($tahun, $bulan, $hari) {
        $result = $this->db->query("SELECT
                                *
                        FROM
                                (
                                        SELECT
                                                PROV PROV,
                                                NVL (BAG_REAL, 0) REAL_BAG,
                                                NVL (BULK_REAL, 0) REAL_BULK,
                              TOTAL_REAL,
                                                MAXREAL
                                        FROM
                                                (
                                                        SELECT
                                                                PROPINSI_TO PROV,
                                                                SUM(CASE ITEM WHEN '121-301' THEN QTY ELSE 0 END) BAG_REAL,
                                                                SUM(CASE ITEM WHEN '121-302' THEN QTY ELSE 0 END) BULK_REAL,
                                                                SUM (QTY) TOTAL_REAL,
                                                                MAX(QTY) AS MAXREAL
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                org = '6000'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND hari <= '$hari'
                                                        AND ITEM != '121-200'
                                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                                        GROUP BY
                                                                PROPINSI_TO
                                                ) 
                                ) TB1
                        LEFT JOIN (
                                SELECT
                                        KD_PROV,
                                        NM_PROV
                                FROM
                                        ZREPORT_M_PROVINSITLCC
                        ) TB2 ON KD_PROV = PROV
                        LEFT JOIN  (
                            SELECT SUM(QUANTUM) AS RKAP, PROV PR FROM SAP_T_RENCANA_SALES_TYPE 
                            WHERE CO = '6000' AND THN = '$tahun' AND BLN = '$bulan' AND TIPE != '121-200' GROUP BY PROV
                        ) TB3 ON TB1.PROV = TB3.PR 
                        ORDER BY PROV ASC");
        return $result->result_array();
    }

    
    public function sumSalesTLCC($tahun, $bulan) {
        date_default_timezone_set("Asia/Jakarta");
        $date = $tahun . '' . $bulan;
        if ($bulan == date("m")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmren = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tglkmren = $hari;
        }
        $data = $this->db->query("SELECT
                                    TB0.COM,
                                    NVL (TB1.RKAP, 0) RKAP,
                                    NVL (TB3.REALISASI, 0) REAL_SDK,
                                    NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                    NVL (TB2.PROGNOSE, 0) PROGNOSE
                            FROM
                                    (SELECT '6000' COM FROM DUAL) TB0
                            LEFT JOIN (
                                    SELECT
                                            ORG COM,
                                            SUM (TARGET) RKAP
                                    FROM
                                            ZREPORT_TARGET_PLANTSCO
                                    WHERE
                                            DELETE_MARK = 0
                                    AND JENIS IS NULL
                                    AND ORG = '6000'
                                    AND BULAN = '$bulan'
                                    AND TAHUN = '$tahun'
                                    AND PLANT NOT IN ('0001', '1092')
                                    AND TIPE != '121-200'
                                    GROUP BY
                                            ORG
                            ) TB1 ON TB0.COM = TB1.COM
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
                                                    WHEN BUDAT <= '$tahun$bulan$tglkmren' THEN
                                                            'TARGET'
                                                    ELSE
                                                            'PROGNOSE'
                                                    END AS TIPE,
                                                    TARGET
                                            FROM
                                                    (
                                                            SELECT
                                                                    A .org com,
                                                                    c.budat,
                                                                    SUM (
                                                                            A .target * (c.porsi / D .total_porsi)
                                                                    ) AS target
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
                                                                    AND VKORG = '6000'
                                                                    GROUP BY
                                                                            region,
                                                                            tipe
                                                            ) D ON D .tipe = A .tipe
                                                            WHERE
                                                                    DELETE_MARK = 0
                                                            AND JENIS IS NULL
                                                            AND ORG = '6000'
                                                            AND BULAN = '$bulan'
                                                            AND TAHUN = '$tahun'
                                                            AND PLANT NOT IN ('0001', '1092')
                                                            AND A .TIPE != '121-200'
                                                            GROUP BY
                                                                    A .org,
                                                                    c.budat
                                                    )
                                            ) PIVOT (
                                                    SUM (target) AS target FOR (TIPE) IN (
                                                            'TARGET' AS rkap_sdk,
                                                            'PROGNOSE' AS prognose
                                                    )
                                            )
                            ) TB2 ON TB0.COM = TB2.COM
                            LEFT JOIN (
                                    SELECT
                                            ORG COM,
                                            SUM (QTY) REALISASI
                                    FROM
                                            ZREPORT_SCM_REAL_SALES
                                    WHERE
                                            ORG = '6000'
                                    AND TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$tglkmren'
                                    AND ITEM != '121-200'
                                    AND PROPINSI_TO NOT IN ('0001', '1092')
                                    GROUP BY
                                            ORG
                            ) TB3 ON TB0.COM = TB3.COM");
        return $data->row_array();
    }

}
