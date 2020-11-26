<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class PetaPencapaianSales_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function maxharianNew($region, $tahun, $bulan, $hari) {
        $params = $this->getRegionParams($region);
        $data = $this->db->query("SELECT
                                        
                                        PROPINSI_TO PROV,
                                        MAX (qty) HARIAN_MAX
                                FROM
                                        (
                                                SELECT
                                                        ID_SCM_SALESREG,
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
                                                                     TAHUN = '$tahun'
                                                                AND BULAN = '$bulan'
                                                                AND ITEM IN ({$params['material']})
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
                                                                             \"tahun\" = '$tahun'
                                                                        AND \"bulan\" = '$bulan'
                                                                        AND \"item\" IN ({$params['material']})
                                                                        AND \"hari\" <= '$hari'
                                                                        AND \"kd_prov\" IS NOT NULL
                                                                        GROUP BY
                                                                                \"org\",
                                                                                \"kd_prov\",
                                                                                \"hari\"
                                                        )
                                                LEFT JOIN ZREPORT_M_PROVINSI ON KD_PROV = PROPINSI_TO
                                                WHERE
                                                    ID_SCM_SALESREG IN ({$params['region']})
                                                GROUP BY
                                                        ID_SCM_SALESREG,
                                                        PROPINSI_TO,
                                                        HARI
                                        )
                                GROUP BY
                                        PROPINSI_TO");
      //echo $this->db->last_query();
       return $data->result_array();
    }

    function scodatamv_region($region, $tahun, $bulan, $hari) {
        $params = $this->getRegionParams($region);
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
                        TB3.ID_SCM_SALESREG,
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
                                    thn = '$tahun'
                                AND bln = '$bulan'
                                AND TIPE IN ({$params['material']})
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
                                                             tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND hari <= '$hari'
                                                        AND ITEM IN ({$params['material']})
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
                                                                AND \"item\" IN ({$params['material']})
                                                                AND \"hari\" <= '$hari'
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
                                                        AND D .tipe = A .tipe AND  A.co=D.VKORG
                                                        WHERE
                                                            thn = '$tahun'
                                                        AND bln = '$bulan'
                                                        AND A.tipe IN ({$params['material']})
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
                                                             tahun = '$tahunlalu'
                                                        AND bulan = '$bulan'
                                                        AND hari <= '$hari'
                                                        AND ITEM IN ({$params['material']})
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
                                                                AND \"item\" IN ({$params['material']})
                                                                AND \"hari\" <= '$hari'
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
                WHERE ID_SCM_SALESREG IN ({$params['region']})
                ";
        //echo $sql;
 $data = $this->db->query($sql);
        //echo $this->db->last_query();
        return $data->result_array();
    }

    function sumSalesRegion($region, $tahun, $bulan, $hari) {
        $params = $this->getRegionParams($region);
        $data = $this->db->query("SELECT
                    TB0.REGION,
                    NVL (ROUND(TB1.RKAP), 0) TARGET,
                    NVL (ROUND(TB2. REAL), 0) REAL,
                    NVL2( TB3.TARGET_REALH, ROUND(TB2. REAL/TB3.TARGET_REALH*100), 0) PERSEN,
                    NVL2( TB1.RKAP, ROUND(TB2. REAL/TB1.RKAP*100), 0) PERSENRKAP,
                    NVL (ROUND(TB3.TARGET_REALH), 0) TARGET_REALH
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

    

    function getChart($org, $prov, $tahun, $bulan, $region) {
        $params = $this->getRegionParams($region);
        $paramsCL = '';
        $paramsORG = '';

        if ($org == '7000') {
            $paramsORG = " IN ('7000', '5000') ";
        } else {
            $paramsORG = " = '$org' ";
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
                                                                                                TO_CHAR(MAX (A .co)) org,
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
                                                                                                        vkorg,
                                                                                                        region,
                                                                                                        tipe,
                                                                                                        SUM (porsi) AS total_porsi
                                                                                                FROM
                                                                                                        zreport_porsi_sales_region
                                                                                                WHERE
                                                                                                        budat LIKE '$tahun$bulan%'
                                                                                                AND vkorg $paramsORG
                                                                                                GROUP BY
                                                                                                        vkorg,
                                                                                                        region,
                                                                                                        tipe
                                                                                        ) D ON c.region = D .region
                                                                                        AND D .tipe = A .tipe AND A.co = D.vkorg
                                                                                        WHERE
                                                                                                co $paramsORG
                                                                                        AND thn = '$tahun'
                                                                                        AND A.tipe IN ({$params['material']})
                                                                                        AND bln = '$bulan'
                                                                                        AND prov = '$prov' 
                                                                                        GROUP BY
                                                                                                
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
                                                AND ITEM IN ({$params['material']}) 
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
        //echo $this->db->last_query();
        return $data;
    }
    
    function sumSalesRegionRevenue($region, $tahun, $bulan, $hari) {
        $month_end  = strtotime('last day of this month', time());
        $lastday    = date('Ymd', $month_end);
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
                                                    A .REVENUE * (c.porsi / D .total_porsi)
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
                            budat <= '".$tahun."".$bulan."31'
            ) TB3 ON TB0.REGION = TB3.REGION")->row_array();
        return $data;
    }

    function sumSalesRegionHarga($region, $tahun, $bulan, $hari) {
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
                                                    A .HARGA * (c.porsi / D .total_porsi)
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
                            budat <= '".$tahun."".$bulan."31'
            ) TB3 ON TB0.REGION = TB3.REGION")->row_array();
        return $data;
    }

    function sumSalesRegionOA($region, $tahun, $bulan, $hari) {
        $params = $this->getRegionParams($region);
        // echo '<br>'. $sql = "";
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
                                                    A .OA * (c.porsi / D .total_porsi)
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
                            budat <= '".$tahun."".$bulan."31'
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
