<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class RevenueRegion_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getVHR($region, $tahun, $bulan, $hari) {
        $data = $this->db->query(" 
            SELECT
                    MAX(REGION_NAME),
                    SUM (HARGA) / SUM (VOL) HARGA,
                    SUM (OA) / SUM (VOL) OA,
                    (SUM(HARGA) -(SUM(OA))) / SUM (VOL) NETTO,
                    (SUM(HARGA) -SUM(OA))/1000000 REVENUE
            FROM
                    (
                            SELECT
                                    REGION_NAME,
                                    NO_URUT,
                                    ID_PROV,
                                    MATERIAL
                            FROM
                                    ZREPORT_SCM_M_KABIROREGION A
                            LEFT JOIN ZREPORT_SCM_MATERIALREGION B ON A .ID_REGION = B.ID_REGION
                            LEFT JOIN ZREPORT_SCM_M_KABIRO C ON A .ID_KABIRO = C.ID_KABIRO
                            LEFT JOIN ZREPORT_SCM_M_REGION D ON A .ID_REGION = D .ID_REGION
                            WHERE
                                    A .ID_REGION IN ($region)
                    ) TB0
            LEFT JOIN (
                    SELECT
                            A .PROPINSI_TO,
                            HARGA,
                            VOL,
                            OA,
                            A .ITEM
                    FROM
                            (
                                    SELECT
                                            PROPINSI_TO,
                                            SUM (QTY) VOL,
                                            ITEM
                                    FROM
                                            ZREPORT_SCM_REAL_SALES
                                    WHERE
                                            BULAN = '$bulan'
                                    AND HARI <= '$hari'
                                    AND TAHUN = '$tahun'
                                    GROUP BY
                                            PROPINSI_TO,
                                            ITEM
                            ) A
                    LEFT JOIN (
                            SELECT
                                    PROPINSI_TO,
                                    SUM (HARGA) HARGA,
                                    SUM (KWANTUMX) HARGA_QTY,
                                    SUBSTR(ITEM,1,7) ITEM
                            FROM
                                    ZREPORT_SCM_HARGA
                            WHERE
                                    BULAN = '$bulan'
                            AND TAHUN = '$tahun'
                            AND HARI <= '$hari'
                            GROUP BY
                                    PROPINSI_TO,
                                    SUBSTR(ITEM,1,7)
                    ) B ON A .PROPINSI_TO = B.PROPINSI_TO
                    AND A .ITEM = B.ITEM 
                    LEFT JOIN (
                            SELECT
                                    PROV PROPINSI_TO,
                                    SUM (OA) OA,
                                    SUM (QTY) OA_QTY,
                                    SUBSTR(MATERIAL,1,7) ITEM
                            FROM
                                    ZREPORT_SCM_OA
                            WHERE
                                    TAHUN = '$tahun'
                            AND BULAN = '$bulan'
                            AND HARI <= '$hari'
                            GROUP BY
                                    PROV,
                                    SUBSTR(MATERIAL,1,7)
                    ) C ON A .PROPINSI_TO = C.PROPINSI_TO
                    AND A .ITEM = C.ITEM
            ) TB1 ON TB1.PROPINSI_TO = TB0.ID_PROV
            AND TB0.MATERIAL = TB1.ITEM
                  ");
        return $data->row_array();
    }

    function sumSalesRegion2($region, $tahun, $bulan, $hari) {
        $params = $this->getRegionParams($region);
        $data = $this->db->query("SELECT
                    TB0.REGION,
                    NVL ((TB1.RKAP), 0) TARGET,
                    NVL ((TB2. REAL), 0) REAL,
                    NVL2( TB3.TARGET_REALH, (TB2. REAL/TB3.TARGET_REALH*100), 0) PERSEN,
                    NVL2( TB1.RKAP, (TB2. REAL/TB1.RKAP*100), 0) PERSENRKAP,
                    NVL ((TB3.TARGET_REALH), 0) TARGET_REALH
            FROM
                    (SELECT '{$params['region']}' REGION FROM DUAL) TB0
            LEFT JOIN (
                    SELECT
                            '{$params['region']}' REGION,
                            SUM (QUANTUM) RKAP
                    FROM
                            SAP_T_RENCANA_SALES_TYPE
                    WHERE
                            THN = '$tahun'
                    AND BLN = '$bulan'
                    AND TIPE IN ({$params['material']})
                    AND PROV IN (
                            SELECT
                                    KD_PROV
                            FROM
                                    ZREPORT_M_PROVINSI
                            WHERE
                                    ID_SCM_SALESREG IN ({$params['region']})
                    ) 
            ) TB1 ON TB1.REGION = TB0.REGION
            LEFT JOIN (
                    SELECT
                            '{$params['region']}' REGION,
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
                                    AND PROPINSI_TO IN (
                                            SELECT
                                                    KD_PROV
                                            FROM
                                                    ZREPORT_M_PROVINSI
                                            WHERE
                                                    ID_SCM_SALESREG IN ({$params['region']})
                                    )
                                    AND ITEM IN ({$params['material']})
                                    GROUP BY
                                            ORG
                                    UNION
                                            SELECT
                                                    \"org\" ORG,
                                                    SUM (\"qty\") REAL
                                            FROM
                                                    ZREPORT_REAL_ST_ADJ
                                            WHERE
                                                            \"tahun\" = '$tahun'
                                            AND \"bulan\" = '$bulan'
                                            AND \"item\" IN ({$params['material']})
                                            AND \"kd_prov\" IN (
                                                    SELECT
                                                            KD_PROV
                                                    FROM
                                                            ZREPORT_M_PROVINSI
                                                    WHERE
                                                            ID_SCM_SALESREG IN ({$params['region']})
                                            )
                                            AND \"hari\" <= '$hari'
                                            GROUP BY
                                                    \"org\"
                            )
            ) TB2 ON TB0.REGION = TB2.REGION
            LEFT JOIN (
                    SELECT
                            '{$params['region']}' REGION,
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
                                                    vkorg,
                                                    SUM (porsi) AS total_porsi
                                            FROM
                                                    zreport_porsi_sales_region
                                            WHERE
                                                    budat LIKE '$tahun$bulan%'
                                            GROUP BY
                                                    region,
                                                    vkorg,
                                                    tipe
                                    ) D ON c.region = D .region
                                    AND D .tipe = A .tipe AND D.vkorg = A.co
                                    WHERE
                                            thn = '$tahun'
                                    AND A.tipe IN ({$params['material']})
                                    AND bln = '$bulan'
                                    AND A .prov IN (
                                            SELECT
                                                    KD_PROV
                                            FROM
                                                    ZREPORT_M_PROVINSI
                                            WHERE
                                                    ID_SCM_SALESREG IN ({$params['region']})
                                    )
                                    GROUP BY
                                            co,
                                            c.budat
                            )
                    WHERE
                            budat <= '$tahun$bulan$hari'
            ) TB3 ON TB0.REGION = TB3.REGION")->row_array();
        return $data;
    }

    function getRegionParams($region) {
        switch ($region) {
            case 1:
                $material = "'121-301','121-302'";
                break;
            case 2:
                $material = "'121-301'";
                break;
            case 3:
                $material = "'121-301','121-302'";
                break;
            case 4:
                $material = "'121-302'";
                $region = 2;
                break;
            case 5:
                $material = "'121-301','121-302'";
                $region = '1,2,3';
                break;
            default:
                $material = "''";
                break;
        }
        return array(
            'material' => $material,
            'region' => $region
        );
    }

}
