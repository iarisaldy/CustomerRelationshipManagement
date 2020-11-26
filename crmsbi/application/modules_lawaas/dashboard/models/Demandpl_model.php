<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

date_default_timezone_set('Asia/Jakarta');

class Demandpl_model extends CI_Model {

    private $db2;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function org() {
        $this->db->order_by('NAMA_ORG', 'ASC');
        return $this->db->get('ZREPORT_M_ORG');
    }

    function prodTerak($date) {
        $data = $this->db->query("SELECT ORG, SUM(PROG_PRODUK) PROGNOSE, SUM(RKAP_PRODUK) RKAP
                FROM ZREPORT_DEMAND_PLANNING 
                WHERE KODE_PRODUK = 1 
                  AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                GROUP BY ORG");
        return $data->result_array();
    }

    //Query By Yunita (Source :PIS)
    function prodRealHarian_PIS($org, $date, $tipe) {
        $this->db2 = $this->load->database('oramso', TRUE);
        $data = $this->db2->query(" 
            SELECT
                    ORG,
                    REAL_PROD REALISASI_PROD,
                    TO_CHAR (DATE_PROD, 'DD') TANGGAL
            FROM
                    V_SCM_PRODUKSI
            WHERE
                    TIPE = '$tipe'
            AND ORG = '$org'
            AND TO_CHAR (DATE_PROD, 'YYYYMM') = '$date'
            ORDER BY
                    DATE_PROD ASC
                ");
        return $data->result_array();
    }

    function prodTerakSemenReal_PIS($org, $type, $date) {

        if ($type == '1') {
            $tipe = 'CL';
        } else {
            $tipe = 'SM';
        }

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 2);
        if (date('Ym') == $date) {
            $hari = date('d');
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }

        $this->db2 = $this->load->database('oramso', TRUE);

        $data = $this->db2->query(" 
                      SELECT
                                ORG,
                                SUM (REAL_PROD) REALISASI,
                                MAX (DATE_PROD) LASTDATE
                        FROM
                                V_SCM_PRODUKSI
                        WHERE
                                TIPE = '$tipe'
                        AND TO_CHAR (DATE_PROD, 'YYYYMM') = '$date'
                        AND ORG = '$org'
                        GROUP BY
                                ORG
                 ");
        return $data->row_array();
    }

    function prodTerakSemenMax($org, $type, $date) {
        //$tanggal = $this->db->query("SELECT TO_CHAR(MAX(TANGGAL),'YYYYMM') TANGGAL FROM ZREPORT_REAL_PROD_DEMANDPL")->row_array();
        //$date = $tanggal['TANGGAL'];
        //$date = date('Ym');
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 2);
        if (date('Ym') == $date) {
            $hari = date('d');
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        TB0.ORG,
                                        TB1.RKAP,
                                        TB4.RKAP_SD,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        TB3.REALISASI,
                                        TB3.LASTDATE
                                FROM
                                        (
                                            SELECT '$org' as ORG FROM DUAL 
                                        ) TB0 LEFT JOIN
                                        (
                                                SELECT
                                                        ORG,
                                                        SUM (RKAP_PRODUK) RKAP
                                                FROM
                                                        ZREPORT_DEMAND_PLANNING
                                                WHERE
                                                        KODE_PRODUK = $type
                                                AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                                                AND ORG = '$org'
                                                GROUP BY
                                                        ORG
                                        ) TB1 ON TB1.ORG=TB0.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (PROG_PRODUK) PROGNOSE
                                        FROM
                                                ZREPORT_DEMAND_PLANNING
                                        WHERE
                                                KODE_PRODUK = $type
                                        AND ORG = '$org'
                                        AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                                        AND TO_CHAR (TANGGAL, 'DD') > '$tglkmrn'
                                        --TO_CHAR (
                                        --        (
                                        --                SELECT
                                        --                        MAX (TANGGAL)
                                        --                FROM
                                        --                        ZREPORT_REAL_PROD_DEMANDPL
                                        --                WHERE
                                        --                        KODE_PRODUK = $type
                                        --                AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                                        --                AND ORG = '$org'
                                        --        ),
                                        --        'DD'
                                        --)
                                        GROUP BY
                                                ORG
                                ) TB2 ON TB1.ORG = TB2.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (QTY_PROD) REALISASI,
                                                MAX (TANGGAL) LASTDATE
                                        FROM
                                                ZREPORT_REAL_PROD_DEMANDPL
                                        WHERE
                                                KODE_PRODUK = $type
                                        AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                                        AND ORG = '$org'
                                        GROUP BY
                                                ORG
                                ) TB3 ON TB1.ORG = TB3.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (RKAP_PRODUK) RKAP_SD
                                        FROM
                                                ZREPORT_DEMAND_PLANNING
                                        WHERE
                                                KODE_PRODUK = $type
                                        AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                                        AND ORG = '$org'
                                        AND TO_CHAR (TANGGAL, 'DD') <= '$tglkmrn'
                                        --TO_CHAR (
                                        --        (
                                        --                SELECT
                                        --                        MAX (TANGGAL)
                                        --                FROM
                                        --                        ZREPORT_REAL_PROD_DEMANDPL
                                        --                WHERE
                                        --                        KODE_PRODUK = $type
                                        --                AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                                        --                AND ORG = '$org'
                                        --        ),
                                        --        'DD'
                                        --)
                                        GROUP BY
                                                ORG
                                ) TB4 ON TB1.ORG = TB4.ORG");
        //echo $this->db->last_query();
        return $data->row_array();
    }

    function prodTerakSemen($org, $type, $date) {
        //$date = date('Ym');
        $data = $this->db->query("SELECT
                                        TB0.ORG,
                                        NVL (TB1.RKAP, 0) RKAP,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        '0' REALISASI
                                FROM
                                        (SELECT '$org' ORG FROM DUAL) TB0
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (RKAP_PRODUK) RKAP
                                        FROM
                                                ZREPORT_DEMAND_PLANNING
                                        WHERE
                                                KODE_PRODUK = $type
                                        AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                                        AND ORG = '$org'
                                        GROUP BY
                                                ORG
                                ) TB1 ON TB0.ORG = TB1.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (PROG_PRODUK) PROGNOSE
                                        FROM
                                                ZREPORT_DEMAND_PLANNING
                                        WHERE
                                                KODE_PRODUK = $type
                                        AND ORG = '$org'
                                        AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                                        GROUP BY
                                                ORG
                                ) TB2 ON TB0.ORG = TB2.ORG");
//        echo $this->db->last_query();
        return $data->row_array();
    }

    function grafProdStokTerak($org, $date) {
        $data = $this->db->query("SELECT ORG, PROG_PRODUK, RKAP_PRODUK, PROG_STOK, MIN_STOK, MAX_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                FROM ZREPORT_DEMAND_PLANNING 
                WHERE KODE_PRODUK = 1 
                  AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                ORDER BY TANGGAL ASC");
        return $data->result_array();
    }

    function grafProdStokTerak2($org, $date) {
        $data = $this->db->query("SELECT DISTINCT TB1.ORG, TB2.REALISASI_PROD,TB3.REALISASI_STOK, TB1.PROG_PRODUK, TB1.RKAP_PRODUK, TB1.PROG_STOK, 
                TB6.MAX_STOK, TB1.TANGGAL, TB4.MAX_TANGGAL, TB5.CREATE_DATE 
                FROM (SELECT ORG, KODE_PRODUK, PROG_PRODUK, RKAP_PRODUK, PROG_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_DEMAND_PLANNING 
                    WHERE KODE_PRODUK = 1 
                      AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    ORDER BY TANGGAL ASC)TB1
                LEFT JOIN (
                    SELECT ORG, QTY_PROD REALISASI_PROD, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_REAL_PROD_DEMANDPL 
                    WHERE KODE_PRODUK = 1 AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    ORDER BY TANGGAL ASC
                )TB2
                ON TB1.ORG = TB2.ORG AND TB1.TANGGAL = TB2.TANGGAL
                LEFT JOIN (
                    SELECT ORG, QTY_STOK REALISASI_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_REAL_STOK_DEMANDPL 
                    WHERE KODE_PRODUK = 1 AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    ORDER BY TANGGAL ASC
                )TB3
                ON TB1.ORG = TB3.ORG AND TB1.TANGGAL = TB3.TANGGAL
                LEFT JOIN (
                    SELECT ORG, TO_CHAR(MAX(TANGGAL),'DD') MAX_TANGGAL 
                    FROM ZREPORT_REAL_PROD_DEMANDPL
                    WHERE KODE_PRODUK = 1 
                            AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    GROUP BY ORG
                )TB4 ON TB1.ORG = TB4.ORG 
                LEFT JOIN (
                    SELECT ORG, TO_CHAR(MAX(CREATED_DATE),'DD-MM-YYYY') CREATE_DATE 
                    FROM ZREPORT_REAL_PROD_DEMANDPL
                    WHERE KODE_PRODUK = 1 
                            AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    GROUP BY ORG
                )TB5 ON TB1.ORG = TB5.ORG 
		LEFT JOIN ZREPORT_SCM_MINMAX_STOK TB6 ON TB1.ORG=TB6.ORG AND TB1.KODE_PRODUK=TB6.KODE_PRODUK
                ORDER BY TB1.TANGGAL ASC");

        $result = $data->result_array();
//        $realPIS = $this->prodRealHarian_PIS($org, $date, 'CL');
//        foreach ($realPIS as $key => $value) {
//            $result[$key]['REALISASI_PROD'] = $value['REALISASI_PROD'];
//        }
        return $result;
    }

    function prodSemen($date) {
        $data = $this->db->query("SELECT ORG, SUM(PROG_PRODUK) PROGNOSE, SUM(RKAP_PRODUK) RKAP
                FROM ZREPORT_DEMAND_PLANNING 
                WHERE KODE_PRODUK = 2 
                  AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                GROUP BY ORG");
        return $data->result_array();
    }

    function grafProdStokSemen($org, $date) {
        $data = $this->db->query("SELECT ORG, PROG_PRODUK, RKAP_PRODUK, PROG_STOK, MIN_STOK, MAX_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                FROM ZREPORT_DEMAND_PLANNING 
                WHERE KODE_PRODUK = 2 
                  AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                ORDER BY TANGGAL ASC");
        return $data->result_array();
    }

    function grafProdStokSemen2($org, $date) {
        $data = $this->db->query("SELECT TB1.ORG, TB2.REALISASI_PROD,TB3.REALISASI_STOK, TB1.PROG_PRODUK, TB1.RKAP_PRODUK, TB1.PROG_STOK, 
            TB6.MAX_STOK, TB1.TANGGAL, TB4.MAX_TANGGAL, TB5.CREATE_DATE 
                FROM (SELECT ORG, KODE_PRODUK, PROG_PRODUK, RKAP_PRODUK, PROG_STOK, MIN_STOK, MAX_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_DEMAND_PLANNING 
                    WHERE KODE_PRODUK = 2 
                      AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    ORDER BY TANGGAL ASC)TB1
                LEFT JOIN (
                    SELECT ORG, QTY_PROD REALISASI_PROD, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_REAL_PROD_DEMANDPL 
                    WHERE KODE_PRODUK = 2 AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    ORDER BY TANGGAL ASC
                )TB2
                ON TB1.ORG = TB2.ORG AND TB1.TANGGAL = TB2.TANGGAL
                LEFT JOIN (
                    SELECT ORG, QTY_STOK REALISASI_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_REAL_STOK_DEMANDPL 
                    WHERE KODE_PRODUK = 2 AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    ORDER BY TANGGAL ASC
                )TB3
                ON TB1.ORG = TB3.ORG AND TB1.TANGGAL = TB3.TANGGAL
                LEFT JOIN (
                    SELECT ORG, TO_CHAR(MAX(TANGGAL),'DD') MAX_TANGGAL 
                    FROM ZREPORT_REAL_PROD_DEMANDPL
                    WHERE KODE_PRODUK = 2 
                            AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    GROUP BY ORG
                )TB4 ON TB1.ORG = TB4.ORG 
                LEFT JOIN (
                    SELECT ORG, TO_CHAR(MAX(CREATED_DATE),'DD-MM-YYYY') CREATE_DATE 
                    FROM ZREPORT_REAL_PROD_DEMANDPL
                    WHERE KODE_PRODUK = 1 
                            AND ORG = '$org' AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    GROUP BY ORG
                )TB5 ON TB1.ORG = TB5.ORG 
                LEFT JOIN ZREPORT_SCM_MINMAX_STOK TB6 ON TB1.ORG=TB6.ORG AND TB1.KODE_PRODUK=TB6.KODE_PRODUK
                ORDER BY TB1.TANGGAL ASC");
        $result = $data->result_array();
//        $realPIS = $this->prodRealHarian_PIS($org, $date, 'SM');
//        foreach ($realPIS as $key => $value) {
//            $result[$key]['REALISASI_PROD'] = $value['REALISASI_PROD'];
//        }
        return $result;
    }

    function stokTerak($date) {
        $data = $this->db->query("SELECT ORG, SUM(PROG_STOK) PROGNOSE, SUM(MAX_STOK) MAX_STOK
                FROM ZREPORT_DEMAND_PLANNING 
                WHERE KODE_PRODUK = 1 
                  AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                GROUP BY ORG");
        return $data->result_array();
    }

    function stokSemen($date) {
        $data = $this->db->query("SELECT ORG, SUM(PROG_STOK) PROGNOSE, SUM(MAX_STOK) MAX_STOK
                FROM ZREPORT_DEMAND_PLANNING 
                WHERE KODE_PRODUK = 2 
                  AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                GROUP BY ORG");
        return $data->result_array();
    }

    function stokTerakSemenMax($date, $org, $type) {
        $data = $this->db->query("SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB1.MAX_DATE FROM (
              SELECT ORG, KODE_PRODUK, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
              FROM ZREPORT_REAL_STOK_DEMANDPL
              WHERE KODE_PRODUK = $type
                AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAX(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL WHERE KODE_PRODUK = $type AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '$org'),'YYYYMMDD')
                AND ORG = '$org'                  
            )TB1
            LEFT JOIN (
              SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = $type
                AND ORG = '$org'
            )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
            LEFT JOIN ZREPORT_SCM_MINMAX_STOK TB3 ON TB1.ORG=TB3.ORG AND TB1.KODE_PRODUK=TB3.KODE_PRODUK");
        //echo 'ada';
        return $data->row_array();
    }

    function stokTerakSemen($date, $org, $type) {
        $data = $this->db->query("SELECT TB1.ORG, NVL(TB2.REALISASI,0) REALISASI, TB1.PROGNOSE, TB3.MAX_STOK FROM (
                  SELECT ORG, KODE_PRODUK, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
                  FROM ZREPORT_DEMAND_PLANNING
                  WHERE KODE_PRODUK = $type
                    AND TO_CHAR(TANGGAL,'YYYYMMDD') = '$date'
                    AND ORG = '$org'                 
                )TB1
                LEFT JOIN (                  
                  SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
                  FROM ZREPORT_REAL_STOK_DEMANDPL
                  WHERE KODE_PRODUK = $type                    
                    AND ORG = '$org' 
                )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
LEFT JOIN ZREPORT_SCM_MINMAX_STOK TB3 ON TB1.ORG=TB3.ORG AND TB1.KODE_PRODUK=TB3.KODE_PRODUK");
        return $data->row_array();
    }

    function inisialStokTerakSemen($org, $type) {
        $data = $this->db->query("SELECT TB1.ORG, '0' REALISASI, TB1.MAX_STOK 
FROM ZREPORT_SCM_MINMAX_STOK TB1
WHERE TB1.ORG = '$org' AND KODE_PRODUK = $type");
        return $data->row_array();
    }

    function sumSalesOpcoOld($org, $date) {
        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        if ($date == date("Ym")) {
//            echo 'sekarang';
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);
            //echo $tanggal;
        } else {
//            echo 'gak sekarang';
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        TB1.COM,
                                        NVL (TB1.REALISASI, 0) REAL_TAHUN_INI,
                                        NVL (TB3.REALISASI, 0) REAL_SDK,
                                        NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        NVL (TB4.REALISASI_TAHUN_LALU, 0) REAL_TAHUNLALU,
                                        NVL (tb5.RKAP_EKSPOR, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNINI,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU,
                                        NVL (tb7.REALISASI, 0) REAL_SDH_TAHUNLALU,
                                        NVL (TB8.REAL_ICS, 0) REAL_ICS,
                                        NVL (TB9.RKAP_ICS, 0) RKAP_ICS
                                FROM
                                        (
                                                SELECT
                                                        ORG COM,
                                                        SUM (QTY) REALISASI
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND ITEM != '121-200'
                                                AND PROPINSI_TO NOT IN ('0001', '1092')
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
                                                        WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
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
                                ) TB2 ON TB1.COM = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (QTY) REALISASI
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$tglkmrn'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB3 ON TB1.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (QTY) REALISASI_TAHUN_LALU
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB4 ON TB1.COM = TB4.COM
                                LEFT JOIN (
                                        SELECT
                                                TB0.ORG COM,
                                                TB1.REAL_SM_EKSPOR,
                                                TB2.REAL_TR_EKSPOR,
                                                TB3.RKAP_EKSPOR
                                        FROM
                                                (SELECT '$org' ORG FROM DUAL) TB0
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_SM_EKSPOR
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PROPINSI_TO = '0001'
                                                AND ITEM != '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB1 ON TB0.ORG = TB1.ORG
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_TR_EKSPOR
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PROPINSI_TO = '0001'
                                                AND ITEM = '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB2 ON TB0.ORG = TB2.ORG
                                        LEFT JOIN (
                                                SELECT
                                                        CO ORG,
                                                        SUM (QUANTUM) RKAP_EKSPOR
                                                FROM
                                                        SAP_T_RENCANA_SALES_TYPE
                                                WHERE
                                                        CO = '$org'
                                                AND THN = '$tahun'
                                                AND BLN = '$bulan'
                                                AND PROV = '0001'
                                                AND TIPE != '121-200'
                                                GROUP BY
                                                        CO
                                        ) TB3 ON TB0.ORG = TB3.ORG
                                ) TB5 ON TB1.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                ORG com,
                                                                TAHUN,
                                                                QTY
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                ORG = '$org'
                                                        AND (TAHUN = '$tahun' OR TAHUN = '$tahunlalu')
                                                        AND BULAN = '$bulan'
                                                        AND PROPINSI_TO = '0001'
                                                        AND ITEM != '121-200'
                                                ) PIVOT (
                                                        SUM (QTY) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb1.com = tb6.com
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (QTY) REALISASI
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB7 ON TB1.COM = TB7.COM
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (QTY) REAL_ICS
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND PROPINSI_TO = '1092'
                                        GROUP BY
                                                ORG
                                ) TB8 ON TB1.COM = TB8.ORG
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM (QUANTUM) RKAP_ICS
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND BLN = '$bulan' --AND HARI <= '20'
                                        AND PROV = '1092'
                                        GROUP BY
                                                CO
                                ) TB9 ON TB1.COM = TB9.ORG");
//        echo $this->db->last_query();
        return $data->row_array();
    }

    function sumSalesOpco($org, $date, $mv = 'ZREPORT_SCM_REAL_SALES') {

        if ($mv == '0') {
            $mv = 'ZREPORT_SCM_REAL_SALES_JAM5';
        } else if ($mv == '1') {
            $mv = 'ZREPORT_SCM_REAL_SALES';
        }

        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        if ($date == date("Ym")) {
//            echo 'sekarang';
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);
            //echo $tanggal;
        } else {
//            echo 'gak sekarang';
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }

        if ($org == '7000') {
            $orgparams = "ORG IN (7000,5000)";
            $rkapparams = "IN(7000,5000)";
            $orgparams2 = "\"org\" IN (7000,5000)";
        } else {
            $orgparams = "ORG = '{$org}'";
            $rkapparams = "= '{$org}'";
            $orgparams2 = "\"org\" = '{$org}'";
        }

        $data = $this->db->query("SELECT
                                        TB0.COM,
                                        NVL (TB1.REALISASI, 0) REAL_TAHUN_INI,
                                        NVL (TB3.REALISASI, 0) REAL_SDK,
                                        NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        NVL (TB4.REALISASI_TAHUN_LALU, 0) REAL_TAHUNLALU,
                                        NVL (tb5.rkap_ekspor, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNINI,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU,
                                        NVL (tb7.REALISASI, 0) REAL_SDH_TAHUNLALU,
                                        NVL (TB8.REAL_ICS, 0) REAL_ICS,
                                        NVL (TB9.RKAP_ICS, 0) RKAP_ICS,
                                        NVL (TB10.PROG,0) PROG_ADJ
                                FROM
                                        (
                                            SELECT '{$org}' as COM
                                                FROM DUAL
                                        ) TB0 
                                LEFT JOIN
                                        (
                                                SELECT
                                                        COM,
                                                        SUM (REALISASI) REALISASI
                                                FROM
                                                        (
                                                                SELECT
                                                                        MAX(ORG) COM,
                                                                        SUM (QTY) REALISASI
                                                                FROM
                                                                        $mv
                                                                WHERE
                                                                --ORG = '$org'
                                                                $orgparams
                                                                AND TAHUN = '$tahun'
                                                                AND BULAN = '$bulan'
                                                                AND ITEM != '121-200'
                                                                AND PROPINSI_TO NOT IN ('0001', '1092')
                                                                
                                                                UNION
                                                                        SELECT
                                                                                \"org\" COM,
                                                                                SUM (\"qty\") realisasi
                                                                        FROM
                                                                                ZREPORT_REAL_ST_ADJ
                                                                        WHERE
                                                                                \"tahun\" = '$tahun'
                                                                        AND \"bulan\" = '$bulan'
                                                                        AND \"org\" = '$org'
                                                                        group by \"org\"
                                                        )
                                                GROUP BY
                                                        COM
                                        ) TB1 ON TB1.COM=TB0.COM
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
                                                        WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        MAX(A .co) COM,
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
                                                                                vkorg,
                                                                                SUM (porsi) AS total_porsi
                                                                        FROM
                                                                                zreport_porsi_sales_region
                                                                        WHERE
                                                                                budat LIKE '$tahun$bulan%'
                                                                        AND vkorg $rkapparams
                                                                        GROUP BY
                                                                                vkorg,
                                                                                region,
                                                                                tipe
                                                                ) D ON c.region = D .region
                                                                AND D .tipe = A .tipe AND A.co = D.vkorg
                                                                WHERE
                                                                        co $rkapparams
                                                                AND thn = '$tahun'
                                                                AND bln = '$bulan'
                                                                AND prov != '0001'
                                                                AND prov != '1092'
                                                                GROUP BY
                                                                        budat
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
                                                COM,
                                                SUM (REALISASI) REALISASI
                                        FROM
                                                (
                                                        SELECT
                                                                MAX(ORG) COM,
                                                                SUM (QTY) REALISASI
                                                        FROM
                                                                $mv
                                                        WHERE
                                                        $orgparams
                                                                --ORG = '$org'
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN = '$bulan'
                                                        AND HARI <= '$tglkmrn'
                                                        AND ITEM != '121-200'
                                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                                       
                                                        UNION
                                                                SELECT
                                                                        \"org\" COM,
                                                                        SUM (\"qty\") realisasi
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"tahun\" = '$tahun'
                                                                AND \"bulan\" = '$bulan'
                                                                AND \"hari\" <= '$tglkmrn'
                                                                AND \"org\" = '$org'
                                                                group by \"org\"
                                                )
                                        GROUP BY
                                                COM
                                ) TB3 ON TB0.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                MAX(ORG) COM,
                                                SUM (QTY) REALISASI_TAHUN_LALU
                                        FROM
                                                $mv
                                        WHERE
                                                --ORG = '$org'
                                        $orgparams
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        
                                ) TB4 ON TB0.COM = TB4.COM
                                LEFT JOIN (
                                        SELECT
                                                TB0.ORG COM,
                                                TB1.REAL_SM_EKSPOR,
                                                TB2.REAL_TR_EKSPOR,
                                                TB3.RKAP_EKSPOR
                                        FROM
                                                (SELECT '$org' ORG FROM DUAL) TB0
                                        LEFT JOIN (
                                                SELECT
                                                        MAX(ORG) ORG,
                                                        SUM (QTY) REAL_SM_EKSPOR
                                                FROM
                                                        $mv
                                                WHERE
                                                --ORG = '$org'
                                                $orgparams
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PROPINSI_TO = '0001'
                                                AND ITEM != '121-200'
                                                
                                        ) TB1 ON TB0.ORG = TB1.ORG
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_TR_EKSPOR
                                                FROM
                                                        $mv
                                                WHERE
                                                --ORG = '$org'
                                                    {$orgparams}
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PROPINSI_TO = '0001'
                                                AND ITEM = '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB2 ON TB0.ORG = TB2.ORG
                                        LEFT JOIN (
                                                SELECT
                                                        CO ORG,
                                                        SUM (QUANTUM) RKAP_EKSPOR
                                                FROM
                                                        SAP_T_RENCANA_SALES_TYPE
                                                WHERE
                                                        CO = '$org'
                                                AND THN = '$tahun'
                                                AND BLN = '$bulan'
                                                AND PROV = '0001'
                                                AND TIPE != '121-200'
                                                GROUP BY
                                                        CO
                                        ) TB3 ON TB0.ORG = TB3.ORG
                                ) TB5 ON TB0.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                ORG com,
                                                                TAHUN,
                                                                QTY
                                                        FROM
                                                                $mv
                                                        WHERE
                                                                --ORG = '$org'
                                                                $orgparams
                                                        AND (TAHUN = '$tahun' OR TAHUN = '$tahunlalu')
                                                        AND BULAN = '$bulan'
                                                        AND PROPINSI_TO = '0001'
                                                        AND ITEM != '121-200'
                                                ) PIVOT (
                                                        SUM (QTY) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb0.com = tb6.com
                                LEFT JOIN (
                                        SELECT
                                                MAX(ORG) COM,
                                                SUM (QTY) REALISASI
                                        FROM
                                                $mv
                                        WHERE
                                               -- ORG = '$org' 
                                               $orgparams
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                       
                                ) TB7 ON TB0.COM = TB7.COM
                                LEFT JOIN (
                                        SELECT
                                                MAX(ORG) ORG,
                                                SUM (QTY) REAL_ICS
                                        FROM
                                                $mv
                                        WHERE
                                               -- ORG = '$org'
                                               $orgparams
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND PROPINSI_TO = '1092'
                                       
                                ) TB8 ON TB0.COM = TB8.ORG
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM (QUANTUM) RKAP_ICS
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND BLN = '$bulan' --AND HARI <= '20'
                                        AND PROV = '1092'
                                        GROUP BY
                                                CO
                                ) TB9 ON TB0.COM = TB9.ORG
                                LEFT JOIN (
                                 SELECT
                                    ORG,
                                    SUM (qty) PROG
                                 FROM
                                    ZREPORT_SCM_PROG_SALES_ADJ
                                 WHERE
                                    tahun = '$tahun'
                                    AND bulan = '$bulan'
                                    AND org = '$org'
                                    AND HARI >= '$hari'
                                 GROUP BY
                                    org
                                ) TB10 ON TB0.COM = TB10.ORG ");
        //echo $this->db->last_query();
        return $data->row_array();
    }

    function sumSalesTonasa($org, $date, $mv = 'ZREPORT_SCM_REAL_SALES') {

        if ($mv == '0') {
            $mv = 'ZREPORT_SCM_REAL_SALES_JAM5';
        } else if ($mv == '1') {
            $mv = 'ZREPORT_SCM_REAL_SALES';
        }

        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        if ($date == date("Ym")) {
//            echo 'sekarang';
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);
            //echo $tanggal;
        } else {
//            echo 'gak sekarang';
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }

        $data = $this->db->query("SELECT
                                        TB0.COM,
                                        NVL (TB1.REALISASI, 0) REAL_TAHUN_INI,
                                        NVL (TB3.REALISASI, 0) REAL_SDK,
                                        NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        NVL (TB4.REALISASI_TAHUN_LALU, 0) REAL_TAHUNLALU,
                                        NVL (tb5.rkap_ekspor, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNINI,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU,
                                        NVL (tb7.REALISASI, 0) REAL_SDH_TAHUNLALU,
                                        NVL (TB8.REAL_ICS, 0) REAL_ICS,
                                        NVL (TB9.RKAP_ICS, 0) RKAP_ICS,
                                        NVL (TB10.PROG, 0) PROG_ADJ
                                FROM
                                        (
                                            SELECT '{$org}' as COM
                                                FROM DUAL
                                        ) TB0 
                                LEFT JOIN
                                        (
                                                SELECT
                                                        COM,
                                                        SUM (REALISASI) REALISASI
                                                FROM
                                                        (
                                                                SELECT
                                                                        ORG COM,
                                                                        SUM (QTY) REALISASI
                                                                FROM
                                                                        $mv
                                                                WHERE
                                                                        ORG = '$org'
                                                                AND TAHUN = '$tahun'
                                                                AND BULAN = '$bulan'
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
                                                        COM
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
                                                        WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
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
                                ) TB2 ON TB0.COM = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REALISASI) REALISASI
                                        FROM
                                                (
                                                        SELECT
                                                                ORG COM,
                                                                SUM (QTY) REALISASI
                                                        FROM
                                                                $mv
                                                        WHERE
                                                                ORG = '$org'
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN = '$bulan'
                                                        AND HARI <= '$tglkmrn'
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
                                                                AND \"hari\" <= '$tglkmrn'
                                                                --AND \"org\" = '$org'
                                                                group by \"org\"
                                                )
                                        GROUP BY
                                                COM
                                ) TB3 ON TB0.COM = TB3.COM
                                LEFT JOIN (
                                    SELECT COM, SUM(REALISASI_TAHUN_LALU) REALISASI_TAHUN_LALU FROM (
                                        SELECT
                                                ORG COM,
                                                SUM (QTY) REALISASI_TAHUN_LALU
                                        FROM
                                                $mv
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        -- AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                        UNION
                                                                SELECT
                                                                        '4000' COM,
                                                                        SUM (\"qty\") REALISASI_TAHUN_LALU
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"tahun\" = '$tahunlalu'
                                                                AND \"bulan\" = '$bulan'
                                                                
                                                                --AND \"org\" = '$org'
                                                                group by \"org\"
                                                                ) GROUP BY COM
                                ) TB4 ON TB0.COM = TB4.COM
                                LEFT JOIN (
                                        SELECT
                                                TB0.ORG COM,
                                                TB1.REAL_SM_EKSPOR,
                                                TB2.REAL_TR_EKSPOR,
                                                TB3.RKAP_EKSPOR
                                        FROM
                                                (SELECT '$org' ORG FROM DUAL) TB0
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_SM_EKSPOR
                                                FROM
                                                        $mv
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PROPINSI_TO = '0001'
                                                AND ITEM != '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB1 ON TB0.ORG = TB1.ORG
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_TR_EKSPOR
                                                FROM
                                                        $mv
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PROPINSI_TO = '0001'
                                                AND ITEM = '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB2 ON TB0.ORG = TB2.ORG
                                        LEFT JOIN (
                                                SELECT
                                                        CO ORG,
                                                        SUM (QUANTUM) RKAP_EKSPOR
                                                FROM
                                                        SAP_T_RENCANA_SALES_TYPE
                                                WHERE
                                                        CO = '$org'
                                                AND THN = '$tahun'
                                                AND BLN = '$bulan'
                                                AND PROV = '0001'
                                                -- AND TIPE != '121-200'
                                                GROUP BY
                                                        CO
                                        ) TB3 ON TB0.ORG = TB3.ORG
                                ) TB5 ON TB0.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                ORG com,
                                                                TAHUN,
                                                                QTY
                                                        FROM
                                                                $mv
                                                        WHERE
                                                                ORG = '$org'
                                                        AND (TAHUN = '$tahun' OR TAHUN = '$tahunlalu')
                                                        AND BULAN = '$bulan'
                                                        AND PROPINSI_TO = '0001'
                                                        -- AND ITEM != '121-200'
                                                ) PIVOT (
                                                        SUM (QTY) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb0.com = tb6.com
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (QTY) REALISASI
                                        FROM
                                                $mv
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        -- AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB7 ON TB0.COM = TB7.COM
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (QTY) REAL_ICS
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND PROPINSI_TO = '1092'
                                        GROUP BY
                                                ORG
                                ) TB8 ON TB0.COM = TB8.ORG
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM (QUANTUM) RKAP_ICS
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '$org'
                                        AND THN = '$tahun'
                                        AND BLN = '$bulan' --AND HARI <= '20'
                                        AND PROV = '1092'
                                        GROUP BY
                                                CO
                                ) TB9 ON TB0.COM = TB9.ORG 
                                LEFT JOIN (
                                 SELECT
                                    ORG,
                                    SUM (qty) PROG
                                 FROM
                                    ZREPORT_SCM_PROG_SALES_ADJ
                                 WHERE
                                    tahun = '$tahun'
                                    AND bulan = '$bulan'
                                    AND org = '$org'
                                    AND HARI >= '$hari'
                                 GROUP BY
                                    org
                                ) TB10 ON TB0.COM = TB10.ORG ");
//        echo $this->db->last_query();
        return $data->row_array();
    }

    function sumSalesOpcoNew($org, $date) {
        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        TB1.COM,
                                        NVL (TB1.REALISASI, 0) REAL_TAHUNINI,
                                        NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        NVL (TB3.REALISASI, 0) REAL_HARIINI,
                                        NVL (TB4.REALISASI_TAHUN_LALU, 0) REAL_TAHUNLALU,
                                        NVL (tb5.target_rkap, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNINI,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU,
                                        NVL (tb7.REALISASI, 0) REAL_SDH_TAHUNLALU
                                FROM
                                        (
                                                SELECT
                                                        COM,
                                                        SUM (REALTO) REALISASI
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND TIPE != '121-200'
                                                AND PROPINSI NOT IN ('0001', '1092')
                                                AND COM = '$org'
                                                GROUP BY
                                                        COM
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
                                                        WHEN BUDAT < '$tanggal' THEN
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
                                                                AND c.budat LIKE '$date%'
                                                                AND c.tipe = A .tipe
                                                                LEFT JOIN (
                                                                        SELECT
                                                                                region,
                                                                                tipe,
                                                                                SUM (porsi) AS total_porsi
                                                                        FROM
                                                                                zreport_porsi_sales_region
                                                                        WHERE
                                                                                budat LIKE '$date%'
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
                                ) TB2 ON TB1.COM = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REAL) REALISASI
                                        FROM
                                                ZREPORT_RPTREAL_RESUM_DAILY
                                        WHERE
                                                TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND TIPE != '121-200'
                                        AND TGL = '$hari' --AND PROPINSI NOT IN ('0001', '1092')
                                        AND COM = '$org'
                                        GROUP BY
                                                COM
                                ) TB3 ON TB1.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REALTO) REALISASI_TAHUN_LALU
                                        FROM
                                                ZREPORT_RPTREAL_RESUM
                                        WHERE
                                                COM = '$org'
                                        AND tipe != '121-200'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND PROPINSI NOT IN ('0001', '1092')
                                        GROUP BY
                                                COM
                                ) TB4 ON TB1.COM = TB4.COM
                                LEFT JOIN (
                                        SELECT
                                                A .com,
                                                A .target_rkap,
                                                A .real_sm_ekspor,
                                                b.REAL_TR_EKSPOR
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                SUM (TARGET_RKAP) TARGET_RKAP,
                                                                SUM (realto) real_sm_ekspor
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                        GROUP BY
                                                                com
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        com,
                                                        SUM (realto) real_tr_ekspor
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                AND tipe = '121-200'
                                                GROUP BY
                                                        com
                                        ) b ON A .com = b.com
                                ) TB5 ON TB1.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                tahun,
                                                                realto
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND (tahun = '$tahun' OR tahun = '$tahunlalu')
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                ) PIVOT (
                                                        SUM (realto) AS realisasi FOR (tahun) IN (
                                                                '2017' AS tahun_ini,
                                                                '2016' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb1.com = tb6.com
                                LEFT JOIN (
                                    SELECT
                                            COM,
                                            SUM (REAL) REALISASI
                                    FROM
                                            ZREPORT_RPTREAL_RESUM_DAILY
                                    WHERE
                                            COM = '$org'
                                    AND tipe != '121-200'
                                    AND TAHUN = '$tahunlalu'
                                    AND BULAN = '$bulan'
                                    AND TGL <= '$hari'
                                    GROUP BY
                                            COM
                                ) TB7 ON TB1.COM = TB7.COM");
        echo $this->db->last_query();
        return $data->row_array();
    }

    function sumSales4000($org, $date) {
        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        TB1.COM ORG,
                                        NVL (TB1.RKAP, 0) RKAP_SDK,
                                        NVL (TB1.REALISASI, 0) REAL_SDK,
                                        NVL (TB2.TAHUN_INI_REALISASI, 0) REAL_SDH,
                                        NVL (TB2.TAHUN_LALU_REALISASI, 0) REAL_TAHUNLALU,
                                        NVL (TB3.PROGNOSE, 0) PROGNOSE,
                                        NVL (tb4.target_rkap, 0) rkap_ekspor,
                                        NVL (tb4.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb4.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb5.REALISASI, 0) REAL_SDH_TAHUNLALU,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNini,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU
                                FROM
                                        (
                                                SELECT
                                                        COM,
                                                        SUM (RKAP) RKAP,
                                                        SUM (REALISASI) REALISASI
                                                FROM
                                                        (
                                                                SELECT
                                                                        TO_CHAR (COM) COM,
                                                                        SUM (RKAP) RKAP,
                                                                        SUM (REAL) REALISASI
                                                                FROM
                                                                        ZREPORT_RPTREAL_RESUM_DAILY TB1
                                                                WHERE
                                                                        TB1.COM = '$org' AND tipe != '121-200'
                                                                AND TB1.TAHUN = '$tahun'
                                                                AND TB1.BULAN = '$bulan'
                                                                AND TB1.TGL <= '$tglkmrn'
                                                                GROUP BY
                                                                        TB1.COM
                                                                UNION
                                                                        SELECT
                                                                                TO_CHAR ('$org') COM,
                                                                                0 RKAP,
                                                                                SUM (\"qty\") REALISASI
                                                                        FROM
                                                                                ZREPORT_REAL_ST_ADJ
                                                                        WHERE
                                                                                \"tahun\" = '$tahun'
                                                                        AND \"bulan\" = '$bulan'
                                                                        AND \"hari\" <= '$tglkmrn'
                                                                        GROUP BY
                                                                                '4000'
                                                        )
                                                GROUP BY
                                                        COM
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                tahun,
                                                                REAL REALISASI
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM_DAILY
                                                        WHERE
                                                                COM = '$org' AND tipe != '121-200'
                                                        AND (TAHUN = '$tahun' OR TAHUN = '$tahunlalu')
                                                        AND BULAN = '$bulan'
                                                        UNION
                                                                SELECT
                                                                        TO_CHAR ('4000') COM,
                                                                        \"tahun\" tahun,
                                                                        \"qty\" REALISASI
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        (
                                                                                \"tahun\" = '$tahun'
                                                                                OR \"tahun\" = '$tahunlalu'
                                                                        )
                                                                AND \"bulan\" = '$bulan'
                                                ) PIVOT (
                                                        SUM (REALISASI) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) TB2 ON TB1.COM = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                A .co COM,
                                                SUM (
                                                        A .quantum * (c.porsi / D .total_porsi)
                                                ) AS prognose
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
                                                        SUM (porsi) AS total_porsi
                                                FROM
                                                        zreport_porsi_sales_region
                                                WHERE
                                                        budat LIKE '$date%'
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
                                        AND budat > '$tanggal'
                                        GROUP BY
                                                co
                                ) TB3 ON TB1.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                A .com,
                                                A .target_rkap,
                                                A .real_sm_ekspor,
                                                b.REAL_TR_EKSPOR
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                SUM (TARGET_RKAP) TARGET_RKAP,
                                                                SUM (realto) real_sm_ekspor
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        --AND tipe != '121-200'
                                                        GROUP BY
                                                                com
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        com,
                                                        SUM (realto) real_tr_ekspor
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                --AND tipe = '121-200'
                                                GROUP BY
                                                        com
                                        ) b ON A .com = b.com
                                ) tb4 ON tb1.com = tb4.com
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REALISASI) REALISASI
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                SUM (REAL) REALISASI
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM_DAILY
                                                        WHERE
                                                                COM = '$org' AND tipe != '121-200'
                                                        AND TAHUN = '$tahunlalu'
                                                        AND BULAN = '$bulan'
                                                        AND TGL <= '$hari'
                                                        GROUP BY
                                                                COM
                                                        UNION
                                                                SELECT
                                                                        TO_CHAR ('4000') COM,
                                                                        SUM (\"qty\") REALISASI
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"tahun\" = '$tahunlalu'
                                                                AND \"bulan\" = '$bulan'
                                                                AND \"hari\" <= '$hari'
                                                                GROUP BY
                                                                        '4000'
                                                )
                                        GROUP BY
                                                COM
                                ) TB5 ON TB1.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                tahun,
                                                                realto
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND (tahun = '$tahun' OR tahun = '$tahunlalu')
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                ) PIVOT (
                                                        SUM (realto) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb1.com = tb6.com");
        //echo $this->db->last_query();
        return $data->row_array();
    }

    function sumSales4000New($org, $date) {
        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        TB1.COM,
                                        NVL (TB1.REALISASI, 0) REAL_TAHUNINI,
                                        NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        NVL (TB3.REALISASI, 0) REAL_HARIINI,
                                        NVL (TB4.REALISASI_TAHUN_LALU, 0) REAL_TAHUNLALU,
                                        NVL (tb5.target_rkap, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNINI,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU,
                                        NVL (tb7.REALISASI, 0) REAL_SDH_TAHUNLALU
                                FROM
                                        (
                                                SELECT
                                                        COM,
                                                        SUM (REALISASI) REALISASI
                                                FROM
                                                        (
                                                                SELECT
                                                                        COM,
                                                                        SUM (REALTO) REALISASI
                                                                FROM
                                                                        ZREPORT_RPTREAL_RESUM
                                                                WHERE
                                                                        TAHUN = '$tahun'
                                                                AND BULAN = '$bulan'
                                                                AND TIPE != '121-200'
                                                                AND PROPINSI NOT IN ('0001', '1092')
                                                                AND COM = '4000'
                                                                GROUP BY
                                                                        COM
                                                                UNION
                                                                        SELECT
                                                                                '4000' COM,
                                                                                SUM (\"qty\") realisasi
                                                                        FROM
                                                                                ZREPORT_REAL_ST_ADJ
                                                                        WHERE
                                                                                \"tahun\" = '$tahun'
                                                                        AND \"bulan\" = '$bulan'
                                                                        AND \"hari\" <= '$tglkmrn'
                                                        )
                                                GROUP BY
                                                        COM
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
                                                        WHEN BUDAT < '$tanggal' THEN
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
                                                                AND c.budat LIKE '$date%'
                                                                AND c.tipe = A .tipe
                                                                LEFT JOIN (
                                                                        SELECT
                                                                                region,
                                                                                tipe,
                                                                                SUM (porsi) AS total_porsi
                                                                        FROM
                                                                                zreport_porsi_sales_region
                                                                        WHERE
                                                                                budat LIKE '$date%'
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
                                ) TB2 ON TB1.COM = '4000'
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REAL) REALISASI
                                        FROM
                                                ZREPORT_RPTREAL_RESUM_DAILY
                                        WHERE
                                                TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND TIPE != '121-200'
                                        AND TGL = '$hari' --AND PROPINSI NOT IN ('0001', '1092')
                                        AND COM = '$org'
                                        GROUP BY
                                                COM
                                ) TB3 ON TB1.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REALTO) REALISASI_TAHUN_LALU
                                        FROM
                                                ZREPORT_RPTREAL_RESUM
                                        WHERE
                                                COM = '$org'
                                        AND tipe != '121-200'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND PROPINSI NOT IN ('0001', '1092')
                                        GROUP BY
                                                COM
                                ) TB4 ON TB1.COM = TB4.COM
                                LEFT JOIN (
                                        SELECT
                                                A .com,
                                                A .target_rkap,
                                                A .real_sm_ekspor,
                                                b.REAL_TR_EKSPOR
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                SUM (TARGET_RKAP) TARGET_RKAP,
                                                                SUM (realto) real_sm_ekspor
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                        GROUP BY
                                                                com
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        com,
                                                        SUM (realto) real_tr_ekspor
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                AND tipe = '121-200'
                                                GROUP BY
                                                        com
                                        ) b ON A .com = b.com
                                ) TB5 ON TB1.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                tahun,
                                                                realto
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND (tahun = '$tahun' OR tahun = '$tahunlalu')
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                ) PIVOT (
                                                        SUM (realto) AS realisasi FOR (tahun) IN (
                                                                '2017' AS tahun_ini,
                                                                '2016' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb1.com = tb6.com
                                LEFT JOIN (
                                    SELECT
                                            COM,
                                            SUM (REAL) REALISASI
                                    FROM
                                            ZREPORT_RPTREAL_RESUM_DAILY
                                    WHERE
                                            COM = '$org'
                                    AND tipe != '121-200'
                                    AND TAHUN = '$tahunlalu'
                                    AND BULAN = '$bulan'
                                    AND TGL <= '$hari'
                                    GROUP BY
                                            COM
                                ) TB7 ON TB1.COM = TB7.COM");
        //echo $this->db->last_query();
        return $data->row_array();
    }

    function sumSales6000($org, $date, $mv = 'ZREPORT_SCM_REAL_SALES') {

        if ($mv == '0') {
            $mv = 'ZREPORT_SCM_REAL_SALES_JAM5';
        } else if ($mv == '1') {
            $mv = 'ZREPORT_SCM_REAL_SALES';
        }

        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        if ($date == date("Ym")) {
//            echo 'sekarang';
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);
            //echo $tanggal;
        } else {
//            echo 'gak sekarang';
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        TB0.COM,
                                        NVL (TB1.REALISASI, 0) REAL_TAHUN_INI,
                                        NVL (TB3.REALISASI, 0) REAL_SDK,
                                        NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        NVL (TB4.REALISASI_TAHUN_LALU, 0) REAL_TAHUNLALU,
                                        NVL (tb5.RKAP_EKSPOR, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNINI,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU,
                                        NVL (tb7.REALISASI, 0) REAL_SDH_TAHUNLALU,
                                        '0' REAL_ICS,
                                        '0' RKAP_ICS,
                                        NVL (tb8.PROG, 0) PROG_ADJ
                                FROM (
                                SELECT '6000' COM FROM DUAL
                                )TB0
                                LEFT JOIN	(
                                                SELECT
                                                        ORG COM,
                                                        SUM (QTY) REALISASI
                                                FROM
                                                        $mv
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND ITEM != '121-200'
                                                AND PROPINSI_TO NOT IN ('0001', '1092')
                                                GROUP BY
                                                        ORG
                                        ) TB1 ON TB1.COM = TB0.COM
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
                                                        WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
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
                                                                        AND VKORG = '$org'
                                                                        GROUP BY
                                                                                region,
                                                                                tipe
                                                                ) D ON D .tipe = A .tipe
                                                                WHERE
                                                                        DELETE_MARK = 0
                                                                AND JENIS IS NULL
                                                                AND ORG = '$org'
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
                                                $mv
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$tglkmrn'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB3 ON TB0.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (QTY) REALISASI_TAHUN_LALU
                                        FROM
                                                $mv
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB4 ON TB0.COM = TB4.COM
                                LEFT JOIN (
                                        SELECT
                                                TB0.ORG COM,
                                                TB1.REAL_SM_EKSPOR,
                                                TB2.REAL_TR_EKSPOR,
                                                TB3.RKAP_EKSPOR
                                        FROM
                                                (SELECT '$org' ORG FROM DUAL) TB0
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_SM_EKSPOR
                                                FROM
                                                        $mv
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PROPINSI_TO = '0001'
                                                AND ITEM != '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB1 ON TB0.ORG = TB1.ORG
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_TR_EKSPOR
                                                FROM
                                                        $mv
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PROPINSI_TO = '0001'
                                                AND ITEM = '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB2 ON TB0.ORG = TB2.ORG
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (TARGET) RKAP_EKSPOR
                                                FROM
                                                        ZREPORT_TARGET_PLANTSCO
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND PLANT = '0001'
                                                AND TIPE != '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB3 ON TB0.ORG = TB3.ORG
                                ) TB5 ON TB0.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                ORG com,
                                                                TAHUN,
                                                                QTY
                                                        FROM
                                                                $mv
                                                        WHERE
                                                                ORG = '$org'
                                                        AND (
                                                                TAHUN = '$tahun'
                                                                OR TAHUN = '$tahunlalu'
                                                        )
                                                        AND BULAN = '$bulan'
                                                        AND PROPINSI_TO = '0001'
                                                        AND ITEM != '121-200'
                                                ) PIVOT (
                                                        SUM (QTY) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON TB0.COM = tb6.com
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (QTY) REALISASI
                                        FROM
                                                $mv
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB7 ON TB0.COM = TB7.COM 
                                    LEFT JOIN (
                                    SELECT
                                       ORG,
                                       SUM (qty) PROG
                                    FROM
                                       ZREPORT_SCM_PROG_SALES_ADJ
                                    WHERE
                                       tahun = '$tahun'
                                       AND bulan = '$bulan'
                                       AND org = '$org'
                                       AND HARI >= '$hari'
                                    GROUP BY
                                       org
                                ) TB8 ON TB0.COM = TB8.ORG ");
//        echo $this->db->last_query();
        return $data->row_array();
    }

    function sumSales6000New($org, $date) {
        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        TB1.COM,
                                        NVL (TB1.REALISASI, 0) REAL_TAHUNINI,
                                        NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        NVL (TB3.REALISASI, 0) REAL_HARIINI,
                                        NVL (TB4.REALISASI_TAHUN_LALU, 0) REAL_TAHUNLALU,
                                        NVL (tb5.target_rkap, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNINI,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU,
                                        NVL (tb7.REALISASI, 0) REAL_SDH_TAHUNLALU
                                FROM
                                        (
                                                SELECT
                                                        COM,
                                                        SUM (REALTO) REALISASI
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND TIPE != '121-200'
                                                AND PROPINSI NOT IN ('0001', '1092')
                                                AND COM = '$org'
                                                GROUP BY
                                                        COM
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
                                                        WHEN BUDAT < '$tanggal' THEN
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
                                                                AND c.budat LIKE '$date%'
                                                                AND c.tipe = A .tipe
                                                                LEFT JOIN (
                                                                        SELECT
                                                                                region,
                                                                                tipe,
                                                                                SUM (porsi) AS total_porsi
                                                                        FROM
                                                                                zreport_porsi_sales_region
                                                                        WHERE
                                                                                budat LIKE '$date%'
                                                                        AND VKORG = '$org'
                                                                        GROUP BY
                                                                                region,
                                                                                tipe
                                                                ) D ON D .tipe = A .tipe
                                                                WHERE
                                                                        DELETE_MARK = 0
                                                                AND JENIS IS NULL
                                                                AND ORG = '$org'
                                                                AND BULAN = '$bulan'
                                                                AND TAHUN = '$tahun'
                                                                AND PLANT NOT IN ('0001', '1092')
                                                                AND A .TIPE != '121-200'
                                                                --AND budat > '$tanggal'
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
                                ) TB2 ON TB1.COM = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REAL) REALISASI
                                        FROM
                                                ZREPORT_RPTREAL_RESUM_DAILY
                                        WHERE
                                                TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND TIPE != '121-200'
                                        AND TGL = '$hari' --AND PROPINSI NOT IN ('0001', '1092')
                                        AND COM = '$org'
                                        GROUP BY
                                                COM
                                ) TB3 ON TB1.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REALTO) REALISASI_TAHUN_LALU
                                        FROM
                                                ZREPORT_RPTREAL_RESUM
                                        WHERE
                                                COM = '$org'
                                        AND tipe != '121-200'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND PROPINSI NOT IN ('0001', '1092')
                                        GROUP BY
                                                COM
                                ) TB4 ON TB1.COM = TB4.COM
                                LEFT JOIN (
                                        SELECT
                                                A .com,
                                                A .target_rkap,
                                                A .real_sm_ekspor,
                                                b.REAL_TR_EKSPOR
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                SUM (TARGET_RKAP) TARGET_RKAP,
                                                                SUM (realto) real_sm_ekspor
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                        GROUP BY
                                                                com
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        com,
                                                        SUM (realto) real_tr_ekspor
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                AND tipe = '121-200'
                                                GROUP BY
                                                        com
                                        ) b ON A .com = b.com
                                ) TB5 ON TB1.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                tahun,
                                                                realto
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND (tahun = '$tahun' OR tahun = '$tahunlalu')
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                ) PIVOT (
                                                        SUM (realto) AS realisasi FOR (tahun) IN (
                                                                '2017' AS tahun_ini,
                                                                '2016' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb1.com = tb6.com
                                LEFT JOIN (
                                    SELECT
                                            COM,
                                            SUM (REAL) REALISASI
                                    FROM
                                            ZREPORT_RPTREAL_RESUM_DAILY
                                    WHERE
                                            COM = '$org'
                                    AND tipe != '121-200'
                                    AND TAHUN = '$tahunlalu'
                                    AND BULAN = '$bulan'
                                    AND TGL <= '$hari'
                                    GROUP BY
                                            COM
                                ) TB7 ON TB1.COM = TB7.COM");
        //echo $this->db->last_query();
        return $data->row_array();
    }

    function lastUpdateAdj($date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        $data = $this->db->query("select max(\"hari\") tanggal_adj 
                        from ZREPORT_REAL_ST_ADJ
                        where \"tahun\" = '$tahun' and \"bulan\" = '$bulan'");
        return $data->row_array();
    }

    function lastUpdate() {
        $data = $this->db->query("select to_char(max(tanggal),'DD/Mon/YYYY') tanggal from ZREPORT_REAL_PROD_DEMANDPL");
        return $data->row_array();
    }

    function getSalesChart($org, $date, $mv = 'ZREPORT_SCM_REAL_SALES') {

        if ($mv == '1') {
            $mv = 'ZREPORT_SCM_REAL_SALES';
        } else if ($mv == '0') {
            $mv = 'ZREPORT_SCM_REAL_SALES_JAM5';
        }

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);

        if ($bulan == date('m')) {
            $hari = date('d');
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }


//        if($org=='7000'){
//            $orgparams = "ORG IN (7000,5000)";
//            $orgparams2 = "\"org\" IN (7000,5000)";
//        }else{
//            $orgparams = "ORG = '{$org}'";
//            $orgparams2 = "\"org\" = '{$org}'";
//        }
        $data = $this->db->query("SELECT
                                        tbm1.*
                                FROM
                                        (
                                                SELECT
                                                        tb1.ORG ORG,
                                                        tb1.TANGGAL TANGGAL,
                                                        PROG + CASE WHEN NVL(ADJ,0)<0 THEN 0 ELSE NVL(ADJ,0) END PROG,
                                                        tb1.TARGET TARGET,
                                                        NVL (tb2. REAL, 0) AS REAL,
                                                        ADJ
                                                FROM
                                                        (
                                                                SELECT
                                                                        org,
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
                                                                                                AND c.budat LIKE '$date%'
                                                                                                AND c.tipe = A .tipe
                                                                                                LEFT JOIN (
                                                                                                        SELECT
                                                                                                                region,
                                                                                                                tipe,
                                                                                                                SUM (porsi) AS total_porsi
                                                                                                        FROM
                                                                                                                zreport_porsi_sales_region
                                                                                                        WHERE
                                                                                                                budat LIKE '$date%'
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
                                                                                                        thn,
                                                                                                        bln,
                                                                                                        c.budat
                                                                                        )
                                                                                UNION
                                                                                        SELECT
                                                                                                ORG,
                                                                                                hari tanggal,
                                                                                                0 target,
                                                                                                SUM (qty) PROG
                                                                                        FROM
                                                                                                ZREPORT_SCM_PROG_SALES_ADJ
                                                                                        WHERE
                                                                                                tahun = '$tahun'
                                                                                        AND bulan = '$bulan'
                                                                                        AND org = '$org'
                                                                                        GROUP BY
                                                                                                org,
                                                                                                hari
                                                                        )
                                                                GROUP BY
                                                                        org,
                                                                        tanggal
                                                                ORDER BY
                                                                        TANGGAL
                                                        ) tb1
                                                LEFT JOIN (
                                                        SELECT
                                                                ORG,
                                                                HARI TANGGAL,
                                                                SUM (QTY) REAL
                                                        FROM
                                                                $mv
                                                        WHERE
                                                                ORG = '$org'
                                                           
                                                        AND TAHUN = '$tahun'
                                                        AND BULAN = '$bulan'
                                                        AND PROPINSI_TO NOT IN ('1092','0001')
                                                        AND ITEM != '121-200'
                                                        GROUP BY
                                                                ORG,
                                                                HARI
                                                ) tb2 ON (tb1.ORG = tb2.ORG)
                                                AND (tb1.TANGGAL = tb2.tanggal)
                                                LEFT JOIN (
                                                    SELECT
                                                            TB0.ORG,
                                                            SUM(TARGET) TARGET,
                                                            SUM(REAL) REAL,
                                                            SUM(TARGET - REAL) PROGSISA,
                                                            SUM(total_porsi),
                                                            SUM(ROUND (
                                                                    CASE
                                                                    WHEN SUBSTR (BUDAT ,- 2) >= '26' THEN
                                                                            porsi
                                                                    ELSE
                                                                            0
                                                                    END / TOTAL_PORSI * (TARGET - REAL),
                                                                    2
                                                            )) ADJ,
                                                            SUBSTR (BUDAT ,- 2) TANGGAL
                                                    FROM
                                                            SCM_ADJ_PROG_BULAN TB0
                                                    LEFT JOIN (
                                                            SELECT
                                                                    region,
                                                                    tipe,
                                                                    SUM (
                                                                            CASE
                                                                            WHEN SUBSTR (BUDAT ,- 2) >= '$hari' THEN
                                                                                    porsi
                                                                            ELSE
                                                                                    0
                                                                            END
                                                                    ) AS total_porsi
                                                            FROM
                                                                    zreport_porsi_sales_region
                                                            WHERE
                                                                    budat LIKE '$tahun$bulan%'
                                                            AND vkorg = '$org'
                                                            GROUP BY
                                                                    region,
                                                                    tipe
                                                    ) TB2 ON TB2.region = 5
                                                    AND TB2.tipe = TB0.tipe
                                                    LEFT JOIN (
                                                            SELECT
                                                                    ORG,
                                                                    ITEM,
                                                                    SUM (QTY) REAL
                                                            FROM
                                                                    $mv
                                                            WHERE
                                                                    ORG = '$org'
                                                            AND TAHUN = '$tahun'
                                                            AND BULAN = '$bulan'
                                                            AND PROPINSI_TO NOT IN ('1092', '0001')
                                                            AND ITEM != '121-200'
                                                            GROUP BY
                                                                    ORG,
                                                                    ITEM
                                                    ) TB1 ON TB0.ORG = TB1.ORG AND TB0.TIPE=TB1.ITEM
                                                    LEFT JOIN zreport_porsi_sales_region TB3 ON TB3.budat LIKE '$tahun$bulan%'
                                                    AND TB3.region = TB2.region
                                                    AND TB3.tipe = TB0.tipe
                                                    AND VKORG = TB0.ORG
                                                    WHERE
                                                            TB0.ORG = '$org'
                                                    AND TAHUN = '$tahun'
                                                    AND BULAN = '$bulan'
                                                    GROUP BY
                                                        TB0.ORG,
                                                        SUBSTR (BUDAT ,- 2) 
                                                    ORDER BY
                                                            SUBSTR (BUDAT ,- 2) ASC
                                            ) TB4 ON TB1.TANGGAL = TB4.TANGGAL
                                        ) tbm1
                                WHERE
                                        (TARGET > 0 OR REAL > 0)
                                ORDER BY
                                        tanggal")->result_array();
        // echo $this->db->last_query();

        return $data;
    }

    function getSalesChartST($org, $date, $mv = 'ZREPORT_SCM_REAL_SALES') {

        if ($mv == '1') {
            $mv = 'ZREPORT_SCM_REAL_SALES';
        } else if ($mv == '0') {
            $mv = 'ZREPORT_SCM_REAL_SALES_JAM5';
        }

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date('m')) {
            $hari = date('d');
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        $data = $this->db->query("SELECT
                                        tbm1.*
                                FROM
                                        (
                                                SELECT
                                                        tb1.ORG ORG,
                                                        tb1.TANGGAL TANGGAL,
                                                        PROG + CASE WHEN NVL(ADJ,0)<0 THEN 0 ELSE NVL(ADJ,0) END PROG,
                                                        tb1.TARGET TARGET,
                                                        NVL (tb2. REAL, 0) AS REAL,
                                                        ADJ
                                                FROM
                                                        (
                                                                SELECT
                                                                        org,
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
                                                                                                AND c.budat LIKE '$date%'
                                                                                                AND c.tipe = A .tipe
                                                                                                LEFT JOIN (
                                                                                                        SELECT
                                                                                                                region,
                                                                                                                tipe,
                                                                                                                SUM (porsi) AS total_porsi
                                                                                                        FROM
                                                                                                                zreport_porsi_sales_region
                                                                                                        WHERE
                                                                                                                budat LIKE '$date%'
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
                                                                                                        thn,
                                                                                                        bln,
                                                                                                        c.budat
                                                                                        )
                                                                                UNION
                                                                                        SELECT
                                                                                                ORG,
                                                                                                hari tanggal,
                                                                                                0 target,
                                                                                                SUM (qty) PROG
                                                                                        FROM
                                                                                                ZREPORT_SCM_PROG_SALES_ADJ
                                                                                        WHERE
                                                                                                tahun = '$tahun'
                                                                                        AND bulan = '$bulan'
                                                                                        AND org = '$org'
                                                                                        GROUP BY
                                                                                                org,
                                                                                                hari
                                                                        )
                                                                GROUP BY
                                                                        org,
                                                                        tanggal
                                                                ORDER BY
                                                                        TANGGAL
                                                        ) tb1
                                                LEFT JOIN (
                                                        SELECT
                                                                ORG,
                                                                TANGGAL,
                                                                SUM (REAL) REAL
                                                        FROM
                                                                (
                                                                        SELECT
                                                                                ORG,
                                                                                HARI TANGGAL,
                                                                                SUM (QTY) REAL
                                                                        FROM
                                                                                $mv
                                                                        WHERE
                                                                                ORG = '$org'
                                                                        AND TAHUN = '$tahun'
                                                                        AND BULAN = '$bulan'
                                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                                        AND ITEM != '121-200'
                                                                        GROUP BY
                                                                                ORG,
                                                                                HARI
                                                                        UNION
                                                                                SELECT
                                                                                        '4000' COM,
                                                                                        \"hari\" tanggal,
                                                                                        SUM (\"qty\") realisasi
                                                                                FROM
                                                                                        ZREPORT_REAL_ST_ADJ
                                                                                WHERE
                                                                                        \"tahun\" = '$tahun'
                                                                                AND \"bulan\" = '$bulan'
                                                                                GROUP BY
                                                                                        \"hari\"
                                                                )
                                                        GROUP BY
                                                                ORG,
                                                                TANGGAL
                                                ) tb2 ON (tb1.ORG = tb2.ORG)
                                                AND (tb1.TANGGAL = tb2.tanggal)
                                                LEFT JOIN (
                                                    SELECT
                                                            TB0.ORG,
                                                            SUM(TARGET) TARGET,
                                                            SUM(REAL) REAL,
                                                            SUM(TARGET - REAL) PROGSISA,
                                                            SUM(total_porsi),
                                                            SUM(ROUND (
                                                                    CASE
                                                                    WHEN SUBSTR (BUDAT ,- 2) >= '26' THEN
                                                                            porsi
                                                                    ELSE
                                                                            0
                                                                    END / TOTAL_PORSI * (TARGET - REAL),
                                                                    2
                                                            )) ADJ,
                                                            SUBSTR (BUDAT ,- 2) TANGGAL
                                                    FROM
                                                            SCM_ADJ_PROG_BULAN TB0
                                                    LEFT JOIN (
                                                            SELECT
                                                                    region,
                                                                    tipe,
                                                                    SUM (
                                                                            CASE
                                                                            WHEN SUBSTR (BUDAT ,- 2) >= '$hari' THEN
                                                                                    porsi
                                                                            ELSE
                                                                                    0
                                                                            END
                                                                    ) AS total_porsi
                                                            FROM
                                                                    zreport_porsi_sales_region
                                                            WHERE
                                                                    budat LIKE '$tahun$bulan%'
                                                            AND vkorg = '$org'
                                                            GROUP BY
                                                                    region,
                                                                    tipe
                                                    ) TB2 ON TB2.region = 5
                                                    AND TB2.tipe = TB0.tipe
                                                    LEFT JOIN (
                                                            SELECT
                                                                ORG,
                                                                ITEM,
                                                                SUM (REAL) REAL
                                                        FROM
                                                                (
                                                                        SELECT
                                                                                ORG,
                                                                                HARI TANGGAL,
                                                                                ITEM,
                                                                                SUM (QTY) REAL
                                                                        FROM
                                                                                $mv
                                                                        WHERE
                                                                                ORG = '$org'
                                                                        AND TAHUN = '$tahun'
                                                                        AND BULAN = '$bulan'
                                                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                                                        AND ITEM != '121-200'
                                                                        GROUP BY
                                                                                ORG,
                                                                                HARI,
                                                                                ITEM
                                                                        UNION
                                                                                SELECT
                                                                                        '4000' COM,
                                                                                        \"hari\" tanggal,
                                                                                        \"item\",
                                                                                        SUM (\"qty\") realisasi
                                                                                FROM
                                                                                        ZREPORT_REAL_ST_ADJ
                                                                                WHERE
                                                                                        \"tahun\" = '$tahun'
                                                                                AND \"bulan\" = '$bulan'
                                                                                GROUP BY
                                                                                        \"hari\",
                                                                                        \"item\"
                                                                )
                                                        GROUP BY
                                                                ORG,
                                                                ITEM
                                                    ) TB1 ON TB0.ORG = TB1.ORG
                                                    AND TB0.TIPE=TB1.ITEM
                                                    LEFT JOIN zreport_porsi_sales_region TB3 ON TB3.budat LIKE '$tahun$bulan%'
                                                    AND TB3.region = TB2.region
                                                    AND TB3.tipe = TB0.tipe
                                                    AND VKORG = TB0.ORG
                                                    WHERE
                                                            TB0.ORG = '$org'
                                                    AND TAHUN = '$tahun'
                                                    AND BULAN = '$bulan'
                                                    GROUP BY
                                                        TB0.ORG,
                                                        SUBSTR (BUDAT ,- 2) 
                                                    ORDER BY
                                                            SUBSTR (BUDAT ,- 2) ASC
                                            ) TB4 ON TB1.TANGGAL = TB4.TANGGAL
                                        ) tbm1
                                WHERE
                                        (TARGET > 0 OR REAL > 0)
                                ORDER BY
                                        tanggal")->result_array();
        return $data;
    }

    function getSalesChartTLCC($org, $date, $mv = 'ZREPORT_SCM_REAL_SALES') {

        if ($mv == '1') {
            $mv = 'ZREPORT_SCM_REAL_SALES';
        } else if ($mv == '0') {
            $mv = 'ZREPORT_SCM_REAL_SALES_JAM5';
        }

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        if ($bulan == date('m')) {
            $hari = date('d');
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $data = $this->db->query("SELECT
                                        TB2.ORG,
                                        TB2.TANGGAL,
                                        NVL (TB1. REAL, 0) REAL,
                                        NVL (TB2.TARGET, 0) TARGET,
                                        NVL (TB2.PROG, 0)+CASE WHEN NVL(ADJ,0)<0 THEN 0 ELSE NVL(ADJ,0) END PROG,
                                        ADJ
                                FROM
                                        (
                                                SELECT
                                                        ORG COM,
                                                        HARI TANGGAL,
                                                        SUM (QTY) REAL
                                                FROM
                                                        $mv
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND ITEM != '121-200'
                                                AND PROPINSI_TO NOT IN ('1092', '0001')
                                                GROUP BY
                                                        ORG,
                                                        HARI
                                        ) TB1
                                RIGHT JOIN (
                                        SELECT
                                                org,
                                                tanggal,
                                                SUM (target) target,
                                                SUM (prog) prog
                                        FROM
                                                (
                                                        (SELECT
                                                                TO_CHAR (A .org) org,
                                                                SUBSTR (c.budat ,- 2) TANGGAL,
                                                                SUM (
                                                                        A .target * (c.porsi / D .total_porsi)
                                                                ) AS TARGET,
                                                                SUM (
                                                                        A .target * (c.porsi / D .total_porsi)
                                                                ) AS PROG
                                                        FROM
                                                                ZREPORT_TARGET_PLANTSCO A
                                                        LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
                                                        AND c.budat LIKE '$date%'
                                                        AND c.tipe = A .tipe
                                                        LEFT JOIN (
                                                                SELECT
                                                                        tipe,
                                                                        SUM (porsi) AS total_porsi
                                                                FROM
                                                                        zreport_porsi_sales_region
                                                                WHERE
                                                                        budat LIKE '$date%'
                                                                AND vkorg = '$org'
                                                                GROUP BY
                                                                        tipe
                                                        ) D ON D .tipe = A .tipe
                                                        WHERE
                                                                org = '$org'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND PLANT NOT IN ('0001', '1092')
                                                        GROUP BY
                                                                org,
                                                                tahun,
                                                                bulan,
                                                                c.budat)
                                                    UNION 
                                                    (SELECT
                                                                                                ORG,
                                                                                                hari tanggal,
                                                                                                0 target,
                                                                                                SUM (qty) PROG
                                                                                        FROM
                                                                                                ZREPORT_SCM_PROG_SALES_ADJ
                                                                                        WHERE
                                                                                                tahun = '$tahun'
                                                                                        AND bulan = '$bulan'
                                                                                        AND org = '$org'
                                                                                        GROUP BY
                                                                                                org,
                                                                                                hari)
                                                )
                                                GROUP BY
                                                org,
                                                tanggal
                                ) TB2 ON TB2.ORG = TB1.COM
                                AND TB1.TANGGAL = TB2.TANGGAL
                                LEFT JOIN (
                                                    SELECT
                                                            TB0.ORG,
                                                            SUM(TARGET) TARGET,
                                                            SUM(REAL) REAL,
                                                            SUM(TARGET - REAL) PROGSISA,
                                                            SUM(total_porsi),
                                                            SUM(ROUND (
                                                                    CASE
                                                                    WHEN SUBSTR (BUDAT ,- 2) >= '26' THEN
                                                                            porsi
                                                                    ELSE
                                                                            0
                                                                    END / TOTAL_PORSI * (TARGET - REAL),
                                                                    2
                                                            )) ADJ,
                                                            SUBSTR (BUDAT ,- 2) TANGGAL
                                                    FROM
                                                            SCM_ADJ_PROG_BULAN TB0
                                                    LEFT JOIN (
                                                            SELECT
                                                                    region,
                                                                    tipe,
                                                                    SUM (
                                                                            CASE
                                                                            WHEN SUBSTR (BUDAT ,- 2) >= '$hari' THEN
                                                                                    porsi
                                                                            ELSE
                                                                                    0
                                                                            END
                                                                    ) AS total_porsi
                                                            FROM
                                                                    zreport_porsi_sales_region
                                                            WHERE
                                                                    budat LIKE '$tahun$bulan%'
                                                            AND vkorg = '$org'
                                                            GROUP BY
                                                                    region,
                                                                    tipe
                                                    ) TB2 ON TB2.region = 5
                                                    AND TB2.tipe = TB0.tipe
                                                    LEFT JOIN (
                                                            SELECT
                                                                    ORG,
                                                                    ITEM,
                                                                    SUM (QTY) REAL
                                                            FROM
                                                                    $mv
                                                            WHERE
                                                                    ORG = '$org'
                                                            AND TAHUN = '$tahun'
                                                            AND BULAN = '$bulan'
                                                            AND ITEM != '121-200'
                                                            AND PROPINSI_TO NOT IN ('1092', '0001')
                                                            GROUP BY
                                                                    ORG,
                                                                    ITEM
                                                    ) TB1 ON TB0.ORG = TB1.ORG AND TB0.TIPE=TB1.ITEM
                                                    LEFT JOIN zreport_porsi_sales_region TB3 ON TB3.budat LIKE '$tahun$bulan%'
                                                    AND TB3.region = TB2.region
                                                    AND TB3.tipe = TB0.tipe
                                                    AND VKORG = TB0.ORG
                                                    WHERE
                                                            TB0.ORG = '$org'
                                                    AND TAHUN = '$tahun'
                                                    AND BULAN = '$bulan'
                                                    GROUP BY
                                                        TB0.ORG,
                                                        SUBSTR (BUDAT ,- 2) 
                                                    ORDER BY
                                                            SUBSTR (BUDAT ,- 2) ASC
                                            ) TB4 ON TB2.TANGGAL = TB4.TANGGAL
                                ORDER BY
                                        tb2.tanggal ASC")->result_array();


        return $data;
    }

    function getSalesChartSMIG($tanggal, $mv) {
        $smig = array();
        $semenGresik = $this->getSalesChart('7000', $tanggal, $mv);
        $semenGresik2 = $this->getSalesChart('5000', $tanggal, $mv);
        $semenPadang = $this->getSalesChart('3000', $tanggal, $mv);
        $semenTonasa = $this->getSalesChart('4000', $tanggal, $mv);
        // $semenTonasa = $this->getSalesChartST('4000', $tanggal, $mv);



        $counter = count($semenGresik) > count($semenPadang) ? count($semenGresik) : (count($semenTonasa) > count($semenPadang) ? count($semenTonasa) : count($semenPadang));
        for ($i = 0; $i < $counter; $i++) {
            $smig[$i]['TARGET'] = 0;
            $smig[$i]['PROG'] = 0;
            $smig[$i]['REAL'] = 0;
        }




        foreach ($semenGresik as $key => $row) {
//            array_push($smig, array(
//                "TANGGAL" => $row['TANGGAL'],
//                "TARGET" => $row['TARGET'],
//                "PROG" => $row['PROG'],
//                "REAL" => $row['REAL']
//            ));
            $smig[$key]['TANGGAL'] = $row['TANGGAL'];
            $smig[$key]['TARGET'] += $row['TARGET'];
            $smig[$key]['PROG'] += $row['PROG'];
            $smig[$key]['REAL'] += $row['REAL'];
        }

        foreach ($semenGresik2 as $key => $row) {
            $smig[$key]['TANGGAL'] = $row['TANGGAL'];
            $smig[$key]['TARGET'] += $row['TARGET'];
            $smig[$key]['PROG'] += $row['PROG'];
            $smig[$key]['REAL'] += $row['REAL'];
        }


        foreach ($semenPadang as $key => $row) {
            $smig[$key]['TANGGAL'] = $row['TANGGAL'];
            $smig[$key]['TARGET'] += $row['TARGET'];
            $smig[$key]['PROG'] += $row['PROG'];
            $smig[$key]['REAL'] += $row['REAL'];
        }

        foreach ($semenTonasa as $key => $row) {
            $smig[$key]['TANGGAL'] = $row['TANGGAL'];
            $smig[$key]['TARGET'] += $row['TARGET'];
            $smig[$key]['PROG'] += $row['PROG'];
            $smig[$key]['REAL'] += $row['REAL'];
        }


        return $smig;
    }

    function getSalesChartSMIGTLCC($tanggal, $mv) {
        $smig = array();
        $semenGresik = $this->getSalesChart('7000', $tanggal, $mv);

        $semenGresik2 = $this->getSalesChart('5000', $tanggal, $mv);
        // $semenGresik2 = $this->getReal5000($tanggal);
        $semenPadang = $this->getSalesChart('3000', $tanggal, $mv);
        // $semenTonasa = $this->getSalesChartST('4000', $tanggal, $mv);
        $semenTonasa = $this->getSalesChart('4000', $tanggal, $mv);
        $semenTLCC = $this->getSalesChartTLCC('6000', $tanggal, $mv);
        // echo $this->db->last_query();
        $counter = count($semenGresik) > count($semenPadang) ? count($semenGresik) : (count($semenTonasa) > count($semenPadang) ? count($semenTonasa) : count($semenPadang));
        for ($i = 0; $i < $counter; $i++) {
            $smig[$i]['TARGET'] = 0;
            $smig[$i]['PROG'] = 0;
            $smig[$i]['REAL'] = 0;
        }

        foreach ($semenGresik as $key => $row) {
//            array_push($smig, array(
//                "TANGGAL" => $row['TANGGAL'],
//                "TARGET" => $row['TARGET'],
//                "PROG" => $row['PROG'],
//                "REAL" => $row['REAL']
//            ));
            $smig[$key]['TANGGAL'] = $row['TANGGAL'];
            $smig[$key]['TARGET'] += $row['TARGET'];
            $smig[$key]['PROG'] += $row['PROG'];
            $smig[$key]['REAL'] += $row['REAL'];
        }

        foreach ($semenGresik2 as $key => $row) {
            $smig[$key]['TANGGAL'] = $row['TANGGAL'];
            $smig[$key]['TARGET'] += $row['TARGET'];
            $smig[$key]['PROG'] += $row['PROG'];
            $smig[$key]['REAL'] += $row['REAL'];
        }

        foreach ($semenPadang as $key => $row) {
            $smig[$key]['TANGGAL'] = $row['TANGGAL'];
            $smig[$key]['TARGET'] += $row['TARGET'];
            $smig[$key]['PROG'] += $row['PROG'];
            $smig[$key]['REAL'] += $row['REAL'];
        }

        foreach ($semenTonasa as $key => $row) {
            $smig[$key]['TANGGAL'] = $row['TANGGAL'];
            $smig[$key]['TARGET'] += $row['TARGET'];
            $smig[$key]['PROG'] += $row['PROG'];
            $smig[$key]['REAL'] += $row['REAL'];
        }

        foreach ($semenTLCC as $key => $row) {
            if (isset($smig[$key]['TANGGAL'])) {
                $smig[$key]['TANGGAL'] = $row['TANGGAL'];
                $smig[$key]['TARGET'] += $row['TARGET'];
                $smig[$key]['PROG'] += $row['PROG'];
                $smig[$key]['REAL'] += $row['REAL'];
            }
        }

        return $smig;
    }

    function getPencTahunLalu($org, $date, $mv = 'ZREPORT_SCM_REAL_SALES') {

        if ($mv == '1') {
            $mv = 'ZREPORT_SCM_REAL_SALES';
        } else if ($mv == '0') {
            $mv = 'ZREPORT_SCM_REAL_SALES_JAM5';
        }

        $tahun = substr($date, 0, 4) - 1;
        $bulan = substr($date, 4, 5);
        $tahunlalu = substr($date, 0, 4) - 1;
        if ($org == '7000') {
            $orgparams = ' IN (7000,5000)';
        } else {
            $orgparams = "='$org'";
        }


        $itemparams = "AND ITEM != '121-200'";


//        if ($org == '4000') {
//            $data = $this->db->query(" 
//                SELECT
//                        TB0.ORG,
//                        TB1. REAL,
//                        TB2.TARGET,
//                        ROUND (REAL / TARGET * 100) PENCAPAIAN
//                FROM
//                        (SELECT '$org' ORG FROM DUAL) TB0
//                LEFT JOIN (
//                        SELECT
//                                ORG,
//                                SUM (REAL) REAL
//                        FROM
//                                (
//                                        SELECT
//                                                ORG,
//                                                SUM (QTY) REAL
//                                        FROM
//                                                $mv
//                                        WHERE
//                                                ORG = '$org'
//                                        AND TAHUN = '$tahun'
//                                        AND BULAN = '$bulan'
//                                        AND PROPINSI_TO NOT IN ('1092', '0001')
//                                        GROUP BY
//                                                ORG
//                                        UNION
//                                                SELECT
//                                                        '$org' COM,
//                                                        SUM (\"qty\") REAL
//                                                FROM
//                                                        ZREPORT_REAL_ST_ADJ
//                                                WHERE
//                                                        \"tahun\" = '$tahun'
//                                                AND \"bulan\" = '$bulan'
//                                                GROUP BY
//                                                        \"bulan\"
//                                )
//                        GROUP BY
//                                ORG
//                ) TB1 ON TB1.ORG = TB0.ORG
//                LEFT JOIN (
//                        SELECT
//                                co ORG,
//                                SUM (QUANTUM) TARGET
//                        FROM
//                                SAP_T_RENCANA_SALES_TYPE
//                        WHERE
//                                co = '$org'
//                        AND thn = '$tahun'
//                        AND bln = '$bulan'
//                        AND PROV NOT IN ('0001', '1092')
//                        GROUP BY
//                                co
//                ) TB2 ON TB2.ORG = TB0.ORG
//                     ");
//        } else
        if ($org == '6000') {
            $data = $this->db->query(" 
                SELECT
                        TB0.ORG,
                        TB1.REAL,
                        TB2.TARGET,
                        ROUND(REAL/TARGET*100) PENCAPAIAN
                FROM
                        (SELECT '6000' ORG FROM DUAL) TB0
                LEFT JOIN (
                        SELECT
                                ORG,
                                SUM (QTY) REAL
                        FROM
                                $mv
                        WHERE
                                ORG = '$org'
                        AND TAHUN = '$tahun'
                        AND BULAN = '$bulan'
                        AND ITEM != '121-200'
                        AND PROPINSI_TO NOT IN ('1092', '0001')
                        GROUP BY
                                ORG
                ) TB1 ON TB1.ORG = TB0.ORG
                LEFT JOIN (
                        SELECT
                                ORG,
                                TARGET
                        FROM
                                ZREPORT_TARGET_PLANTSCO
                        WHERE
                                org = '6000'
                        AND tahun = '2017'
                        AND bulan = '10'
                        AND PLANT NOT IN ('0001', '1092')
                ) TB2 ON TB2.ORG = TB0.ORG
                   ");
        } else {
            $data = $this->db->query(" 
                SELECT
                        TB0.ORG,
                        TB1.REAL,
                        TB2.TARGET,
                        ROUND(REAL/TARGET*100) PENCAPAIAN
                FROM
                        (SELECT '$org' ORG FROM DUAL) TB0
                LEFT JOIN (
                        SELECT
                                MAX(ORG) ORG,
                                SUM (QTY) REAL
                        FROM
                                $mv
                        WHERE
                                ORG $orgparams
                        AND TAHUN = '$tahun'
                        AND BULAN = '$bulan'
                        AND ITEM != '121-200'
                        AND PROPINSI_TO NOT IN ('1092', '0001')
                        
                ) TB1 ON TB1.ORG = TB0.ORG
                LEFT JOIN (
                        SELECT
                                MAX(co) ORG,
                                SUM(QUANTUM) TARGET
                        FROM
                                SAP_T_RENCANA_SALES_TYPE
                        WHERE
                                co $orgparams
                        AND thn = '$tahun'
                        AND bln = '$bulan'
                        AND PROV NOT IN ('0001', '1092')
                        GROUP BY co
                ) TB2 ON TB2.ORG = TB0.ORG
            ");
        }
        return $data->row_array();
    }

    function getEksporSG($date) {
        $data = $this->db->query("SELECT
                                        ORG,
                                        SUM (REAL) AS REAL_EKSPOR,
                                        tanggal
                                FROM
                                        (
                                                SELECT
                                                        COM AS ORG,
                                                        SUM (kwantumx) AS REAL,
                                                        TO_CHAR (tgl_cmplt, 'DD') tanggal
                                                FROM
                                                        zreport_rpt_real
                                                WHERE
                                                        TO_CHAR (tgl_cmplt, 'YYYYMM') = '$date'
                                                AND com = '7000'
                                                AND propinsi_to = '0001'
                                                GROUP BY
                                                        COM,
                                                        TO_CHAR (tgl_cmplt, 'DD')
                                                UNION
                                                        SELECT
                                                                VKORG AS ORG,
                                                                SUM (ton) AS REAL,
                                                                TO_CHAR (wadat_ist, 'DD') tanggal
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '7000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$date'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                OR matnr LIKE '121-302%'
                                                        )
                                                        AND vkbur = '0001'
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (wadat_ist, 'DD')
                                        )
                                GROUP BY
                                        ORG,
                                        tanggal");
        return $data->result_array();
    }

    function getEksporSP($date) {
        $data = $this->db->query("SELECT
                                        org,
                                        SUM (REAL) AS real_ekspor,
                                        tanggal
                                FROM
                                        (
                                                SELECT
                                                        vkorg AS org,
                                                        SUM (ton) AS REAL,
                                                        TO_CHAR (wadat_ist, 'dd') tanggal
                                                FROM
                                                        zreport_ongkosangkut_mod
                                                WHERE
                                                        TO_CHAR (wadat_ist, 'yyyymm') = '$date'
                                                AND vkorg = '3000'
                                                AND vkbur = '0001'
                                                GROUP BY
                                                        vkorg,
                                                        TO_CHAR (wadat_ist, 'dd')
                                                UNION
                                                        SELECT
                                                                vkorg AS org,
                                                                SUM (ton) AS REAL,
                                                                TO_CHAR (wadat_ist, 'DD') tanggal
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '3000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$date'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                OR (matnr LIKE '121-302%')
                                                        )
                                                        AND vkbur = '0001'
                                                        GROUP BY
                                                                vkorg,
                                                                TO_CHAR (wadat_ist, 'DD')
                                        )
                                GROUP BY
                                        org,
                                        tanggal");

        return $data->result_array();
    }

    function getEksporST($date) {
        $data = $this->db->query("SELECT
                                        ORG,
                                        SUM (REAL) AS REAL_EKSPOR,
                                        tanggal
                                FROM
                                        (
                                                SELECT
                                                        com AS ORG,
                                                        '0001' AS propinsi_to,
                                                        SUM (kwantumx) AS REAL,
                                                        TO_CHAR (tgl_cmplt, 'DD') tanggal
                                                FROM
                                                        zreport_rpt_real_st
                                                WHERE
                                                        TO_CHAR (tgl_cmplt, 'YYYYMM') = '$date'
                                                AND com = '4000'
                                                AND SOLD_TO NOT IN (
                                                        '0000000835',
                                                        '0000000836',
                                                        '0000000837'
                                                ) --Pemakaian Sendiri
                                                AND ORDER_TYPE = 'ZLFE'
                                                AND (ITEM_NO LIKE '121-301%' or ITEM_NO LIKE '121-302%')
                                                GROUP BY
                                                        com,
                                                        propinsi_to,
                                                        TO_CHAR (tgl_cmplt, 'DD')
                                                UNION
                                                        SELECT
                                                                vkorg AS org,
                                                                vkbur AS propinsi_to,
                                                                SUM (ton) AS REAL,
                                                                TO_CHAR (wadat_ist, 'DD') tanggal
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '4000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$date'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                or matnr LIKE '121-302%'
                                                        )
                                                        AND vkbur = '0001'
                                                        GROUP BY
                                                                vkorg,
                                                                vkbur,
                                                                TO_CHAR (wadat_ist, 'DD')
                                        )
                                GROUP BY
                                        ORG,
                                        tanggal");
        return $data->result_array();
    }

    function getEksporTLCC($date) {
        $data = $this->db->query("SELECT
                                        com AS ORG,
                                        TO_CHAR (TGL_SPJ, 'dd') tanggal,
                                        SUM (kwantumx) AS REAL_EKSPOR
                                FROM
                                        zreport_rpt_real_tlcc
                                WHERE
                                        TO_CHAR (TGL_SPJ, 'yyyymm') = '$date'
                                AND order_type <> 'ZNL'
                                AND propinsi_to NOT LIKE '6%'
                                AND item_no LIKE '121-30%'
                                AND com = '6000'
                                GROUP BY
                                        COM,
                                        TO_CHAR (TGL_SPJ, 'dd')");
        return $data->result_array();
    }

    function sumEksporSG($date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        ORG,
                                        SUM (REAL) AS REAL_EKSPOR
                                FROM
                                        (
                                                SELECT
                                                        COM AS ORG,
                                                        SUM (kwantumx) AS REAL,
                                                        TO_CHAR (tgl_cmplt, 'DD') tanggal
                                                FROM
                                                        zreport_rpt_real
                                                WHERE
                                                        TO_CHAR (tgl_cmplt, 'YYYYMM') = '$date'
                                                AND com = '7000'
                                                AND propinsi_to = '0001'
                                                GROUP BY
                                                        COM,
                                                        TO_CHAR (tgl_cmplt, 'DD')
                                                UNION
                                                        SELECT
                                                                VKORG AS ORG,
                                                                SUM (ton) AS REAL,
                                                                TO_CHAR (wadat_ist, 'DD') tanggal
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '7000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$date'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                OR matnr LIKE '121-302%'
                                                        )
                                                        AND vkbur = '0001'
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (wadat_ist, 'DD')
                                        )
                                WHERE
                                        tanggal <= '$tglkmrn'
                                GROUP BY
                                        ORG");

        return $data->row_array();
    }

    function sumEksporSP($date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        org,
                                        SUM (REAL) AS real_ekspor
                                FROM
                                        (
                                                SELECT
                                                        vkorg AS org,
                                                        SUM (ton) AS REAL,
                                                        TO_CHAR (wadat_ist, 'dd') tanggal
                                                FROM
                                                        zreport_ongkosangkut_mod
                                                WHERE
                                                        TO_CHAR (wadat_ist, 'yyyymm') = '$date'
                                                AND vkorg = '3000'
                                                AND vkbur = '0001'
                                                GROUP BY
                                                        vkorg,
                                                        TO_CHAR (wadat_ist, 'dd')
                                                UNION
                                                        SELECT
                                                                vkorg AS org,
                                                                SUM (ton) AS REAL,
                                                                TO_CHAR (wadat_ist, 'DD') tanggal
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '3000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$date'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                OR (matnr LIKE '121-302%')
                                                        )
                                                        AND vkbur = '0001'
                                                        GROUP BY
                                                                vkorg,
                                                                TO_CHAR (wadat_ist, 'DD')
                                        )
                                WHERE
                                        tanggal <= '$tglkmrn'
                                GROUP BY
                                        org");

        return $data->row_array();
    }

    function sumEksporST($date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        ORG,
                                        SUM (REAL) AS REAL_EKSPOR
                                FROM
                                        (
                                                SELECT
                                                        com AS ORG,
                                                        '0001' AS propinsi_to,
                                                        SUM (kwantumx) AS REAL,
                                                        TO_CHAR (tgl_cmplt, 'DD') tanggal
                                                FROM
                                                        zreport_rpt_real_st
                                                WHERE
                                                        TO_CHAR (tgl_cmplt, 'YYYYMM') = '$date'
                                                AND com = '4000'
                                                AND SOLD_TO NOT IN (
                                                        '0000000835',
                                                        '0000000836',
                                                        '0000000837'
                                                ) --Pemakaian Sendiri
                                                AND ORDER_TYPE = 'ZLFE'
                                                AND (
                                                        ITEM_NO LIKE '121-301%'
                                                        OR ITEM_NO LIKE '121-302%'
                                                        OR ITEM_NO LIKE '121-200%'
                                                )
                                                GROUP BY
                                                        com,
                                                        propinsi_to,
                                                        TO_CHAR (tgl_cmplt, 'DD')
                                                UNION
                                                        SELECT
                                                                vkorg AS org,
                                                                vkbur AS propinsi_to,
                                                                SUM (ton) AS REAL,
                                                                TO_CHAR (wadat_ist, 'DD') tanggal
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '4000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$date'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                OR matnr LIKE '121-302%'
                                                                OR matnr LIKE '121-200%'
                                                        )
                                                        AND vkbur = '0001'
                                                        GROUP BY
                                                                vkorg,
                                                                vkbur,
                                                                TO_CHAR (wadat_ist, 'DD')
                                        )
                                WHERE
                                        tanggal <= '$tglkmrn'
                                GROUP BY
                                        ORG");

        return $data->row_array();
    }

    function sumEksporTLCC($date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        org,
                                        SUM (real_ekspor) real_ekspor
                                FROM
                                        (
                                                SELECT
                                                        com AS ORG,
                                                        TO_CHAR (TGL_SPJ, 'dd') tanggal,
                                                        SUM (kwantumx) AS REAL_EKSPOR
                                                FROM
                                                        zreport_rpt_real_tlcc
                                                WHERE
                                                        TO_CHAR (TGL_SPJ, 'yyyymm') = '$date'
                                                AND order_type <> 'ZNL'
                                                AND propinsi_to NOT LIKE '6%'
                                                AND item_no LIKE '121-30%'
                                                AND com = '6000'
                                                GROUP BY
                                                        COM,
                                                        TO_CHAR (TGL_SPJ, 'dd')
                                        )
                                WHERE
                                        tanggal <= '$tglkmrn'
                                GROUP BY
                                        org");

        return $data->row_array();
    }

    public function detailSales6000($org, $date, $mv = 'ZREPORT_SCM_REAL_SALES') {

        if ($mv == '0') {
            $mv = 'ZREPORT_SCM_REAL_SALES_JAM5';
        } else if ($mv == '1') {
            $mv = 'ZREPORT_SCM_REAL_SALES';
        }

        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        if ($date == date("Ym")) {
//            echo 'sekarang';
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);
            //echo $tanggal;
        } else {
//            echo 'gak sekarang';
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = array();
        $data['domestik'] = $this->db->query("
            SELECT
                    TB0.ORG COM,
                    NVL (TB1.RKAP_SDK,0) RKAP_SM_SDK,
                    NVL (TB5.RKAP_SDK,0) RKAP_CL_SDK,
                    NVL (TB1.RKAP_SDK,0)+ NVL (TB5.RKAP_SDK,0) RKAP_SDK_ALL,
                    NVL (TB2.REAL_SM_DOMESTIK, 0) REAL_SM_DOMESTIK,
                    NVL (TB3.REAL_CL_DOMESTIK, 0) REAL_CL_DOMESTIK,
                    NVL (TB4.REAL_DOMESTIK_ALL, 0) REAL_DOMESTIK_ALL
            FROM
                    (SELECT '$org' ORG FROM DUAL) TB0
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                            NVL (PROGNOSE_TARGET, 0) PROGNOSE
                    FROM
                            (
                                    SELECT
                                            COM ,
                                            CASE
                                    WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
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
                                                    AND VKORG = '$org'
                                                    GROUP BY
                                                            region,
                                                            tipe
                                            ) D ON D .tipe = A .tipe
                                            WHERE
                                                    DELETE_MARK = 0
                                            AND JENIS IS NULL
                                            AND ORG = '$org'
                                            AND BULAN = '$bulan'
                                            AND TAHUN = '$tahun'
                                            AND PLANT NOT IN ('0001', '1092')
                                            AND A .TIPE IN ('121-301','121-302')
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
            ) TB1 ON TB0.ORG = TB1.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                            NVL (PROGNOSE_TARGET, 0) PROGNOSE
                    FROM
                            (
                                    SELECT
                                            COM ,
                                            CASE
                                    WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
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
                                                    AND VKORG = '$org'
                                                    GROUP BY
                                                            region,
                                                            tipe
                                            ) D ON D .tipe = A .tipe
                                            WHERE
                                                    DELETE_MARK = 0
                                            AND JENIS IS NULL
                                            AND ORG = '$org'
                                            AND BULAN = '$bulan'
                                            AND TAHUN = '$tahun'
                                            AND PLANT NOT IN ('0001', '1092')
                                            AND A .TIPE = '121-200'
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
            ) TB5 ON TB0.ORG = TB5.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            SUM (REALISASI) REAL_SM_DOMESTIK
                    FROM
                            (
                                    SELECT
                                            ORG COM,
                                            SUM (QTY) REALISASI
                                    FROM
                                            $mv
                                    WHERE
                                            ORG = '$org'
                                    AND TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$tglkmrn'
                                    AND ITEM != '121-200'
                                    AND PROPINSI_TO NOT IN ('0001', '1092')
                                    GROUP BY
                                            ORG
                                    UNION
                                            SELECT
                                                    \"org\" COM,
                                                    SUM (\"qty\") realisasi
                                            FROM
                                                    ZREPORT_REAL_ST_ADJ
                                            WHERE
                                                    \"tahun\" = '$tahun'
                                            AND \"bulan\" = '$bulan'
                                            AND \"hari\" <= '$tglkmrn'
                                            AND \"org\" = '$org'
                                            GROUP BY
                                                    \"org\"
                            )
                    GROUP BY
                            COM
            ) TB2 ON TB0.ORG = TB2.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            SUM (REALISASI) REAL_CL_DOMESTIK
                    FROM
                            (
                                    SELECT
                                            ORG COM,
                                            SUM (QTY) REALISASI
                                    FROM
                                            $mv
                                    WHERE
                                            ORG = '$org'
                                    AND TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$tglkmrn'
                                    AND ITEM = '121-200'
                                    AND PROPINSI_TO NOT IN ('0001', '1092')
                                    GROUP BY
                                            ORG
                            )
                    GROUP BY
                            COM
            ) TB3 ON TB0.ORG = TB3.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            SUM (REALISASI) REAL_DOMESTIK_ALL
                    FROM
                            (
                                    SELECT
                                            ORG COM,
                                            SUM (QTY) REALISASI
                                    FROM
                                            $mv
                                    WHERE
                                            ORG = '$org'
                                    AND TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$tglkmrn'
                                    AND PROPINSI_TO NOT IN ('0001', '1092')
                                    GROUP BY
                                            ORG
                                    UNION
                                            SELECT
                                                    \"org\" COM,
                                                    SUM (\"qty\") realisasi
                                            FROM
                                                    ZREPORT_REAL_ST_ADJ
                                            WHERE
                                                    \"tahun\" = '$tahun'
                                            AND \"bulan\" = '$bulan'
                                            AND \"hari\" <= '$tglkmrn'
                                            AND \"org\" = '$org'
                                            GROUP BY
                                                    \"org\"
                            )
                    GROUP BY
                            COM
            ) TB4 ON TB0.ORG = TB4.ORG")->row_array();
        $data['ics'] = $this->db->query("
            SELECT
                    TB0.ORG COM,
                    '0' RKAP_SM_ICS,
                    '0' RKAP_CL_ICS,
                    '0' RKAP_ICS_ALL,
                    '0' REAL_SM_ICS,
                    '0' REAL_CL_ICS,
                    '0' REAL_ICS_ALL
            FROM
                    (SELECT '$org' ORG FROM DUAL) TB0
            ")->row_array();
        $data['ekspor'] = $this->db->query("
            SELECT
                    TB0.ORG COM,
                    NVL(TB3.RKAP_EKSPOR,0) RKAP_SM_EKSPOR,
                    NVL(TB5.RKAP_EKSPOR,0) RKAP_CL_EKSPOR,
                    NVL(TB3.RKAP_EKSPOR,0)+NVL(TB5.RKAP_EKSPOR,0) RKAP_EKSPOR_ALL,
                    NVL(TB1.REAL_SM_EKSPOR,0) REAL_SM_EKSPOR,
                    NVL(TB2.REAL_TR_EKSPOR,0) REAL_CL_EKSPOR,
                    NVL(TB4.REAL_EKSPOR_ALL,0) REAL_EKSPOR_ALL
            FROM
                    (SELECT '$org' ORG FROM DUAL) TB0
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (QTY) REAL_SM_EKSPOR
                    FROM
                            $mv
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PROPINSI_TO = '0001'
                    AND ITEM != '121-200'
                    GROUP BY
                            ORG
            ) TB1 ON TB0.ORG = TB1.ORG
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (QTY) REAL_TR_EKSPOR
                    FROM
                            $mv
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PROPINSI_TO = '0001'
                    AND ITEM = '121-200'
                    GROUP BY
                            ORG
            ) TB2 ON TB0.ORG = TB2.ORG
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (TARGET) RKAP_EKSPOR
                    FROM
                            ZREPORT_TARGET_PLANTSCO
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PLANT = '0001'
                    AND TIPE != '121-200'
                    GROUP BY
                            ORG
            ) TB3 ON TB0.ORG = TB3.ORG
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (TARGET) RKAP_EKSPOR
                    FROM
                            ZREPORT_TARGET_PLANTSCO
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PLANT = '0001'
                    AND TIPE = '121-200'
                    GROUP BY
                            ORG
            ) TB5 ON TB0.ORG = TB5.ORG
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (QTY) REAL_EKSPOR_ALL
                    FROM
                            $mv
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PROPINSI_TO = '0001'
                    GROUP BY
                            ORG
            ) TB4 ON TB0.ORG = TB4.ORG")->row_array();

        return $data;
    }

    public function detailSalesCom($org, $date, $mv = 'ZREPORT_SCM_REAL_SALES') {

        if ($mv == '0') {
            $mv = 'ZREPORT_SCM_REAL_SALES_JAM5';
        } else if ($mv == '1') {
            $mv = 'ZREPORT_SCM_REAL_SALES';
        }

        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        if ($date == date("Ym")) {
//            echo 'sekarang';
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);
            //echo $tanggal;
        } else {
//            echo 'gak sekarang';
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }

        if ($org == '7000') {
            $orgparams = "ORG IN (7000,5000)";
            $rkapparams = " IN(7000,5000)";
            $orgparams2 = "\"org\" IN (7000,5000)";
        } else {
            $orgparams = "ORG = '{$org}'";
            $rkapparams = " = '{$org}'";
            $orgparams2 = "\"org\" = '{$org}'";
        }

        $data = array();
        $data['domestik'] = $this->db->query("
            SELECT
                    TB0.ORG COM,
                    NVL(TB1.RKAP_SDK,0) RKAP_SM_SDK,
                    NVL(TB5.RKAP_SDK,0) RKAP_CL_SDK,
                    NVL(TB1.RKAP_SDK,0)+NVL(TB5.RKAP_SDK,0) RKAP_SDK_ALL,
                    NVL(TB2.REAL_SM_DOMESTIK,0) REAL_SM_DOMESTIK,
                    NVL(TB3.REAL_CL_DOMESTIK,0) REAL_CL_DOMESTIK,
                    NVL(TB4.REAL_DOMESTIK_ALL,0) REAL_DOMESTIK_ALL
            FROM
                    (SELECT '$org' ORG FROM DUAL) TB0
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                            NVL (PROGNOSE_TARGET, 0) PROGNOSE
                    FROM
                            (
                                    SELECT
                                            COM,
                                            CASE
                                    WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
                                            'TARGET'
                                    ELSE
                                            'PROGNOSE'
                                    END AS TIPE,
                                    TARGET
                            FROM
                                    (
                                            SELECT
                                                    MAX(A .co) COM,
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
                                                            vkorg,
                                                            region,
                                                            tipe,
                                                            SUM (porsi) AS total_porsi
                                                    FROM
                                                            zreport_porsi_sales_region
                                                    WHERE
                                                            budat LIKE '$tahun$bulan%'
                                                    AND vkorg $rkapparams
                                                    
                                                    GROUP BY
                                                            vkorg,
                                                            region,
                                                            tipe
                                            ) D ON c.region = D .region
                                            AND D .tipe = A .tipe AND A.co = D.vkorg
                                            WHERE
                                            
                                                    co $rkapparams
                                            AND thn = '$tahun'
                                            AND A.TIPE IN ('121-301', '121-302')
                                            AND bln = '$bulan'
                                            AND prov NOT IN('0001','1092')
                                            GROUP BY
                                                    budat
                                    )
                            ) PIVOT (
                                    SUM (target) AS target FOR (TIPE) IN (
                                            'TARGET' AS rkap_sdk,
                                            'PROGNOSE' AS prognose
                                    )
                            )
            ) TB1 ON TB0.ORG = TB1.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                            NVL (PROGNOSE_TARGET, 0) PROGNOSE
                    FROM
                            (
                                    SELECT
                                            COM,
                                            CASE
                                    WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
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
                                            AND A.TIPE IN('121-200')
                                            AND thn = '$tahun'
                                            AND bln = '$bulan'
                                            AND prov NOT IN('0001','1092')
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
            ) TB5 ON TB0.ORG = TB5.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            SUM (REALISASI) REAL_SM_DOMESTIK
                    FROM
                            (
                                    SELECT
                                            MAX(ORG) COM,
                                            SUM (QTY) REALISASI
                                    FROM
                                            $mv
                                    WHERE
                                            --ORG = '$org'
                                    $orgparams
                                    AND TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$tglkmrn'
                                    AND ITEM != '121-200'
                                    AND PROPINSI_TO NOT IN ('0001', '1092')
                                   
                                    UNION
                                            SELECT
                                                    \"org\" COM,
                                                    SUM (\"qty\") realisasi
                                            FROM
                                                    ZREPORT_REAL_ST_ADJ
                                            WHERE
                                                    \"tahun\" = '$tahun'
                                            AND \"bulan\" = '$bulan'
                                            AND \"hari\" <= '$tglkmrn'
                                            AND \"org\" = '$org'
                                            GROUP BY
                                                    \"org\"
                            )
                    GROUP BY
                            COM
            ) TB2 ON TB0.ORG = TB2.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            SUM (REALISASI) REAL_CL_DOMESTIK
                    FROM
                            (
                                    SELECT
                                            MAX(ORG) COM,
                                            SUM (QTY) REALISASI
                                    FROM
                                            $mv
                                    WHERE
                                           -- ORG = '$org'
                                             $orgparams
                                    AND TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$tglkmrn'
                                    AND ITEM = '121-200'
                                    AND PROPINSI_TO NOT IN ('0001', '1092')
                                    
                            )
                    GROUP BY
                            COM
            ) TB3 ON TB0.ORG = TB3.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            SUM (REALISASI) REAL_DOMESTIK_ALL
                    FROM
                            (
                                    SELECT
                                            MAX(ORG) COM,
                                            SUM (QTY) REALISASI
                                    FROM
                                            $mv
                                    WHERE
                                            --ORG = '$org'
                                    $orgparams
                                    AND TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$tglkmrn'
                                    AND PROPINSI_TO NOT IN ('0001', '1092')
                                    
                                    UNION
                                            SELECT
                                                    \"org\" COM,
                                                    SUM (\"qty\") realisasi
                                            FROM
                                                    ZREPORT_REAL_ST_ADJ
                                            WHERE
                                                    \"tahun\" = '$tahun'
                                            AND \"bulan\" = '$bulan'
                                            AND \"hari\" <= '$tglkmrn'
                                            AND \"org\" = '$org'
                                            GROUP BY
                                                    \"org\"
                            )
                    GROUP BY
                            COM
            ) TB4 ON TB0.ORG = TB4.ORG")->row_array();
        $data['ics'] = $this->db->query("
            SELECT
                    TB0.ORG COM,
                    NVL(TB1.RKAP_ICS,0) RKAP_SM_ICS,
                    NVL(TB5.RKAP_ICS,0) RKAP_CL_ICS,
                    NVL(TB1.RKAP_ICS,0)+NVL(TB5.RKAP_ICS,0) RKAP_ICS_ALL,
                    NVL(TB2.REAL_SM_ICS,0) REAL_SM_ICS,
                    NVL(TB3.REAL_CL_ICS,0) REAL_CL_ICS,
                    NVL(TB4.REAL_ICS_ALL,0) REAL_ICS_ALL
            FROM
                    (SELECT '$org' ORG FROM DUAL) TB0
            LEFT JOIN (
                    SELECT
                            CO ORG,
                            SUM (QUANTUM) RKAP_ICS
                    FROM
                            SAP_T_RENCANA_SALES_TYPE
                    WHERE
                            CO = '$org'
                    AND THN = '$tahun'
                    AND BLN = '$bulan' 
                    AND TIPE IN ('121-301', '121-302')
                    AND PROV = '1092'
                    GROUP BY
                            CO
            ) TB1 ON TB0.ORG = TB1.ORG
             LEFT JOIN (
                    SELECT
                            CO ORG,
                            SUM (QUANTUM) RKAP_ICS
                    FROM
                            SAP_T_RENCANA_SALES_TYPE
                    WHERE
                            CO = '$org'
                    AND THN = '$tahun'
                    AND BLN = '$bulan'
                    AND TIPE IN ('121-200')
                    AND PROV = '1092'
                    GROUP BY
                            CO
            ) TB5 ON TB0.ORG = TB5.ORG
            LEFT JOIN (
            SELECT
                    '$org' ORG,
                    SUM (QTY) REAL_SM_ICS
            FROM
                    $mv
            WHERE
                    --ORG = '$org'
                    $orgparams
            AND TAHUN = '$tahun'
            AND BULAN = '$bulan'
            AND PROPINSI_TO = '1092'
            AND ITEM != '121-200'
          
            ) TB2 ON TB0.ORG = TB2.ORG
            LEFT JOIN (
            SELECT
                    '$org' ORG,
                    SUM (QTY) REAL_CL_ICS
            FROM
                    $mv
            WHERE
                    --ORG = '$org'
                    $orgparams
            AND TAHUN = '$tahun'
            AND BULAN = '$bulan'
            AND PROPINSI_TO = '1092'
            AND ITEM = '121-200'
          
            ) TB3 ON TB0.ORG = TB3.ORG
            LEFT JOIN (
            SELECT
                   '$org' ORG,
                    SUM (QTY) REAL_ICS_ALL
            FROM
                    $mv
            WHERE
                    --ORG = '$org'
                        $orgparams
            AND TAHUN = '$tahun'
            AND BULAN = '$bulan'
            AND PROPINSI_TO = '1092'
          
            ) TB4 ON TB0.ORG = TB4.ORG")->row_array();
        //cho $this->db->last_query();
        $data['ekspor'] = $this->db->query("
            SELECT
                    TB0.ORG COM,
                    NVL(TB3.RKAP_EKSPOR,0) RKAP_SM_EKSPOR,
                    NVL(TB5.RKAP_EKSPOR,0) RKAP_CL_EKSPOR,
                    NVL(TB3.RKAP_EKSPOR,0)+NVL(TB5.RKAP_EKSPOR,0) RKAP_EKSPOR_ALL,
                    NVL(TB1.REAL_SM_EKSPOR,0) REAL_SM_EKSPOR,
                    NVL(TB2.REAL_TR_EKSPOR,0) REAL_CL_EKSPOR,
                    NVL(TB4.REAL_EKSPOR_ALL,0) REAL_EKSPOR_ALL 
            FROM
                    (SELECT '$org' ORG FROM DUAL) TB0
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (QTY) REAL_SM_EKSPOR
                    FROM
                            $mv
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PROPINSI_TO = '0001'
                    AND ITEM != '121-200'
                    GROUP BY
                            ORG
            ) TB1 ON TB0.ORG = TB1.ORG
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (QTY) REAL_TR_EKSPOR
                    FROM
                            $mv
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PROPINSI_TO = '0001'
                    AND ITEM = '121-200'
                    GROUP BY
                            ORG
            ) TB2 ON TB0.ORG = TB2.ORG
            LEFT JOIN (
                    SELECT
                            CO ORG,
                            SUM (QUANTUM) RKAP_EKSPOR
                    FROM
                            SAP_T_RENCANA_SALES_TYPE
                    WHERE
                            CO = '$org'
                    AND THN = '$tahun'
                    AND BLN = '$bulan'
                    AND TIPE IN ('121-301','121-302')
                    AND PROV = '0001'
                    GROUP BY
                            CO
            ) TB3 ON TB0.ORG = TB3.ORG
            LEFT JOIN (
                    SELECT
                            CO ORG,
                            SUM (QUANTUM) RKAP_EKSPOR
                    FROM
                            SAP_T_RENCANA_SALES_TYPE
                    WHERE
                            CO = '$org'
                    AND THN = '$tahun'
                    AND BLN = '$bulan'
                    AND TIPE IN ('121-200')
                    AND PROV = '0001'
                    GROUP BY
                            CO
            ) TB5 ON TB0.ORG = TB5.ORG
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (QTY) REAL_EKSPOR_ALL
                    FROM
                            $mv
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PROPINSI_TO = '0001'
                    GROUP BY
                            ORG
            ) TB4 ON TB0.ORG = TB4.ORG")->row_array();

        return $data;
    }

    public function detailSales4000($org, $date, $mv = 'ZREPORT_SCM_REAL_SALES') {

        if ($mv == '0') {
            $mv = 'ZREPORT_SCM_REAL_SALES_JAM5';
        } else if ($mv == '1') {
            $mv = 'ZREPORT_SCM_REAL_SALES';
        }

        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        if ($date == date("Ym")) {
//            echo 'sekarang';
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);
            //echo $tanggal;
        } else {
//            echo 'gak sekarang';
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = array();
        $data['domestik'] = $this->db->query("
            SELECT
                    TB0.ORG COM,
                    NVL(TB1.RKAP_SDK,0) RKAP_SM_SDK,
                    NVL(TB5.RKAP_SDK,0) RKAP_CL_SDK,
                    NVL(TB1.RKAP_SDK,0)+NVL(TB5.RKAP_SDK,0) RKAP_SDK_ALL,
                    NVL(TB2.REAL_SM_DOMESTIK,0) REAL_SM_DOMESTIK,
                    NVL(TB3.REAL_CL_DOMESTIK,0) REAL_CL_DOMESTIK,
                    NVL(TB4.REAL_DOMESTIK_ALL,0) REAL_DOMESTIK_ALL
            FROM
                    (SELECT '$org' ORG FROM DUAL) TB0
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                            NVL (PROGNOSE_TARGET, 0) PROGNOSE
                    FROM
                            (
                                    SELECT
                                            COM,
                                            CASE
                                    WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
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
                                            AND A.tipe IN ('121-301','121-302')
                                            AND bln = '$bulan'
                                            AND prov NOT IN('0001','1092')
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
            ) TB1 ON TB0.ORG = TB1.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                            NVL (PROGNOSE_TARGET, 0) PROGNOSE
                    FROM
                            (
                                    SELECT
                                            COM,
                                            CASE
                                    WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
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
                                            AND A.tipe IN ('121-200')
                                            AND thn = '$tahun'
                                            AND bln = '$bulan'
                                            AND prov NOT IN('0001','1092')
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
            ) TB5 ON TB0.ORG = TB5.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            SUM (REALISASI) REAL_SM_DOMESTIK
                    FROM
                            (
                                    SELECT
                                            ORG COM,
                                            SUM (QTY) REALISASI
                                    FROM
                                            $mv
                                    WHERE
                                            ORG = '$org'
                                    AND TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$tglkmrn'
                                    AND ITEM != '121-200'
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
                                            AND \"hari\" <= '$tglkmrn'
                                            --AND \"org\" = '$org'
                                            GROUP BY
                                                    \"org\"
                            )
                    GROUP BY
                            COM
            ) TB2 ON TB0.ORG = TB2.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            SUM (REALISASI) REAL_CL_DOMESTIK
                    FROM
                            (
                                    SELECT
                                            ORG COM,
                                            SUM (QTY) REALISASI
                                    FROM
                                            $mv
                                    WHERE
                                            ORG = '$org'
                                    AND TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$tglkmrn'
                                    AND ITEM = '121-200'
                                    AND PROPINSI_TO NOT IN ('0001', '1092')
                                    GROUP BY
                                            ORG
                            )
                    GROUP BY
                            COM
            ) TB3 ON TB0.ORG = TB3.ORG
            LEFT JOIN (
                    SELECT
                            COM ORG,
                            SUM (REALISASI) REAL_DOMESTIK_ALL
                    FROM
                            (
                                    SELECT
                                            ORG COM,
                                            SUM (QTY) REALISASI
                                    FROM
                                            $mv
                                    WHERE
                                            ORG = '$org'
                                    AND TAHUN = '$tahun'
                                    AND BULAN = '$bulan'
                                    AND HARI <= '$tglkmrn'
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
                                            AND \"hari\" <= '$tglkmrn'
                                            --AND \"org\" = '$org'
                                            GROUP BY
                                                    \"org\"
                            )
                    GROUP BY
                            COM
            ) TB4 ON TB0.ORG = TB4.ORG")->row_array();
        //  echo $this->db->last_query();
        $data['ics'] = $this->db->query("
            SELECT
                    TB0.ORG COM,
                    NVL(TB1.RKAP_ICS,0) RKAP_SM_ICS,
                    NVL(TB5.RKAP_ICS,0) RKAP_CL_ICS,
                    NVL(TB1.RKAP_ICS,0)+NVL(TB5.RKAP_ICS,0) RKAP_ICS_ALL,
                    NVL(TB2.REAL_SM_ICS,0) REAL_SM_ICS,
                    NVL(TB3.REAL_CL_ICS,0) REAL_CL_ICS,
                    NVL(TB4.REAL_ICS_ALL,0) REAL_ICS_ALL
            FROM
                    (SELECT '$org' ORG FROM DUAL) TB0
            LEFT JOIN (
                    SELECT
                            CO ORG,
                            SUM (QUANTUM) RKAP_ICS
                    FROM
                            SAP_T_RENCANA_SALES_TYPE
                    WHERE
                            CO = '$org'
                    AND TIPE IN ('121-301','121-302')
                    AND THN = '$tahun'
                    AND BLN = '$bulan' 
                    AND PROV = '1092'
                    GROUP BY
                            CO
            ) TB1 ON TB0.ORG = TB1.ORG
            LEFT JOIN (
                    SELECT
                            CO ORG,
                            SUM (QUANTUM) RKAP_ICS
                    FROM
                            SAP_T_RENCANA_SALES_TYPE
                    WHERE
                            CO = '$org'
                    AND TIPE IN ('121-200')
                    AND THN = '$tahun'
                    AND BLN = '$bulan' 
                    AND PROV = '1092'
                    GROUP BY
                            CO
            ) TB5 ON TB0.ORG = TB5.ORG
            LEFT JOIN (
            SELECT
                    ORG,
                    SUM (QTY) REAL_SM_ICS
            FROM
                    $mv
            WHERE
                    ORG = '$org'
            AND TAHUN = '$tahun'
            AND BULAN = '$bulan'
            AND PROPINSI_TO = '1092'
            AND ITEM != '121-200'
            GROUP BY
                    ORG
            ) TB2 ON TB0.ORG = TB2.ORG
            LEFT JOIN (
            SELECT
                    ORG,
                    SUM (QTY) REAL_CL_ICS
            FROM
                    $mv
            WHERE
                    ORG = '$org'
            AND TAHUN = '$tahun'
            AND BULAN = '$bulan'
            AND PROPINSI_TO = '1092'
            AND ITEM = '121-200'
            GROUP BY
                    ORG
            ) TB3 ON TB0.ORG = TB3.ORG
            LEFT JOIN (
            SELECT
                    ORG,
                    SUM (QTY) REAL_ICS_ALL
            FROM
                    $mv
            WHERE
                    ORG = '$org'
            AND TAHUN = '$tahun'
            AND BULAN = '$bulan'
            AND PROPINSI_TO = '1092'
            GROUP BY
                    ORG
            ) TB4 ON TB0.ORG = TB4.ORG")->row_array();
        $data['ekspor'] = $this->db->query("
            SELECT
                    TB0.ORG COM,
                    NVL(TB3.RKAP_EKSPOR,0) RKAP_SM_EKSPOR,
                    NVL(TB5.RKAP_EKSPOR,0) RKAP_CL_EKSPOR,
                    NVL(TB3.RKAP_EKSPOR,0)+ NVL(TB5.RKAP_EKSPOR,0) RKAP_EKSPOR_ALL,
                    NVL(TB1.REAL_SM_EKSPOR,0) REAL_SM_EKSPOR,
                    NVL(TB2.REAL_TR_EKSPOR,0) REAL_CL_EKSPOR,
                    NVL(TB4.REAL_EKSPOR_ALL,0) REAL_EKSPOR_ALL 
            FROM
                    (SELECT '$org' ORG FROM DUAL) TB0
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (QTY) REAL_SM_EKSPOR
                    FROM
                            $mv
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PROPINSI_TO = '0001'
                    AND ITEM != '121-200'
                    GROUP BY
                            ORG
            ) TB1 ON TB0.ORG = TB1.ORG
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (QTY) REAL_TR_EKSPOR
                    FROM
                            $mv
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PROPINSI_TO = '0001'
                    AND ITEM = '121-200'
                    GROUP BY
                            ORG
            ) TB2 ON TB0.ORG = TB2.ORG
            LEFT JOIN (
                    SELECT
                            CO ORG,
                            SUM (QUANTUM) RKAP_EKSPOR
                    FROM
                            SAP_T_RENCANA_SALES_TYPE
                    WHERE
                            CO = '$org'
                    AND THN = '$tahun'
                    AND BLN = '$bulan'
                    AND PROV = '0001'
                    AND TIPE IN ('121-301','121-302')
                    GROUP BY
                            CO
            ) TB3 ON TB0.ORG = TB3.ORG
            LEFT JOIN (
                    SELECT
                            CO ORG,
                            SUM (QUANTUM) RKAP_EKSPOR
                    FROM
                            SAP_T_RENCANA_SALES_TYPE
                    WHERE
                            CO = '$org'
                    AND THN = '$tahun'
                    AND BLN = '$bulan'
                    AND PROV = '0001'
                    AND TIPE = '121-200'
                    GROUP BY
                            CO
            ) TB5 ON TB0.ORG = TB5.ORG
            LEFT JOIN (
                    SELECT
                            ORG,
                            SUM (QTY) REAL_EKSPOR_ALL
                    FROM
                            $mv
                    WHERE
                            ORG = '$org'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND PROPINSI_TO = '0001'
                    GROUP BY
                            ORG
            ) TB4 ON TB0.ORG = TB4.ORG")->row_array();

        return $data;
    }

    function getReal5000($date) {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        $data = $this->db->query("SELECT
                                        '5000' AS ORG,
                                        TO_CHAR (DT, 'dd') HARI,
                                        CASE
                                WHEN REAL IS NULL THEN
                                        0
                                ELSE
                                        REAL
                                END REAL
                                FROM
                                        (
                                                SELECT
                                                        TRUNC (
                                                                LAST_DAY (TO_DATE('$bulan$tahun', 'mmyyyy')) - (ROWNUM - 1)
                                                        ) dt
                                                FROM
                                                        DUAL CONNECT BY ROWNUM < 32
                                        )
                                LEFT JOIN (
                                        SELECT
                                                MAX (ORG) ORG,
                                                HARI TANGGAL,
                                                SUM (QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '5000'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        AND ITEM != '121-200'
                                        GROUP BY
                                                HARI
                                ) ON TANGGAL = TO_CHAR (DT, 'dd')
                                WHERE
                                        DT >= TRUNC (
                                                TO_DATE ('$bulan$tahun', 'mmyyyy'),
                                                'mm'
                                        )
                                ORDER BY
                                        TO_CHAR (DT, 'dd') ASC")->result_array();
        return $data;
    }

    //-------------------TAHUNAN---------------//
    public function sumSalesOpcoTahunan($org, $tahun) {
        if ($tahun == date("Y")) {
            $bulan = date("m");
            $tanggal = date("Ymd");
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $bulan = '12';
            $hari = date('t');
        }

        if ($org == '7000') {
            $orgQ = '5000,7000';
        } else {
            $orgQ = $org;
        }

        $data = array();
        $data = $this->db->query("SELECT
                            TB0.COM,
                            NVL (TB3.REALISASI, 0) REAL_SDK,
                            NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                            NVL (TB2.PROGNOSE, 0) PROGNOSE,
                            NVL (tb5.rkap_ekspor, 0) rkap_ekspor,
                            NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                            NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                            NVL (TB8.REAL_ICS, 0) REAL_ICS,
                            NVL (TB9.RKAP_ICS, 0) RKAP_ICS
                    FROM
                            (SELECT '$org' AS COM FROM DUAL) TB0
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
                                                            MAX(A .co) COM,
                                                            SUM (
                                                                    A .quantum * (c.porsi / D .total_porsi)
                                                            ) AS target,
                                                            budat
                                                    FROM
                                                            sap_t_rencana_sales_type A
                                                    LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                                    AND c.vkorg = A .co
                                                    AND SUBSTR (c.budat, 1, 4) = THN
                                                    AND SUBSTR (c.budat, 5, 2) = BLN
                                                    AND c.tipe = A .tipe
                                                    LEFT JOIN (
                                                            SELECT
                                                                    vkorg,
                                                                    SUBSTR (budat, 1, 6) budat2,
                                                                    region,
                                                                    tipe,
                                                                    SUM (porsi) AS total_porsi
                                                            FROM
                                                                    zreport_porsi_sales_region
                                                            WHERE
                                                                    budat LIKE '$tahun%'
                                                            AND region = 5
                                                            AND vkorg IN ($orgQ)
                                                            GROUP BY
                                                                    vkorg,
                                                                    SUBSTR (budat, 1, 6),
                                                                    region,
                                                                    tipe
                                                    ) D ON c.region = D .region
                                                    AND D .tipe = A .tipe AND A.co = D.vkorg
                                                    AND BLN = SUBSTR (D .budat2, 5, 2)
                                                    WHERE
                                                            co IN ($orgQ)
                                                    AND thn = '$tahun'
                                                    AND prov != '0001'
                                                    AND prov != '1092'
                                                    GROUP BY
                                                            budat
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
                                    COM,
                                    SUM (REALISASI) REALISASI
                            FROM
                                    (
                                            SELECT
                                                    MAX (ORG) COM,
                                                    SUM (QTY) REALISASI
                                            FROM
                                                    ZREPORT_SCM_REAL_SALES
                                            WHERE
                                                    ORG IN ($orgQ) 
                                            AND TAHUN = '$tahun'
                                            AND BULAN <= '$bulan'
                                            AND HARI <= (
                                                    CASE
                                                    WHEN BULAN = '$bulan' THEN
                                                            '$hari'
                                                    ELSE
                                                            '32'
                                                    END
                                            )
                                            AND ITEM != '121-200'
                                            AND PROPINSI_TO NOT IN ('0001', '1092')
                                            UNION
                                                    SELECT
                                                            \"org\" COM,
                                                            SUM (\"qty\") realisasi
                                                    FROM
                                                            ZREPORT_REAL_ST_ADJ
                                                    WHERE
                                                            \"tahun\" = '$tahun'
                                                    AND \"hari\" <= (
                                                            CASE
                                                            WHEN \"bulan\" = '$bulan' THEN
                                                                    '$hari'
                                                            ELSE
                                                                    '32'
                                                            END
                                                    )
                                                    AND \"org\" = '$org'
                                                    GROUP BY
                                                            \"org\"
                                    )
                            GROUP BY
                                    COM
                    ) TB3 ON TB0.COM = TB3.COM
                    LEFT JOIN (
                            SELECT
                                    TB0.ORG COM,
                                    TB1.REAL_SM_EKSPOR,
                                    TB2.REAL_TR_EKSPOR,
                                    TB3.RKAP_EKSPOR
                            FROM
                                    (SELECT '$org' ORG FROM DUAL) TB0
                            LEFT JOIN (
                                    SELECT
                                            MAX (ORG) ORG,
                                            SUM (QTY) REAL_SM_EKSPOR
                                    FROM
                                            ZREPORT_SCM_REAL_SALES
                                    WHERE
                                            ORG IN ($orgQ)
                                    AND TAHUN = '$tahun'
                                    AND PROPINSI_TO = '0001'
                                    AND ITEM != '121-200'
                            ) TB1 ON TB0.ORG = TB1.ORG
                            LEFT JOIN (
                                    SELECT
                                            ORG,
                                            SUM (QTY) REAL_TR_EKSPOR
                                    FROM
                                            ZREPORT_SCM_REAL_SALES
                                    WHERE
                                            ORG IN ($orgQ)
                                    AND TAHUN = '$tahun'
                                    AND PROPINSI_TO = '0001'
                                    AND ITEM = '121-200'
                                    GROUP BY
                                            ORG
                            ) TB2 ON TB0.ORG = TB2.ORG
                            LEFT JOIN (
                                    SELECT
                                            MAX(CO) ORG,
                                            SUM (QUANTUM) RKAP_EKSPOR
                                    FROM
                                            SAP_T_RENCANA_SALES_TYPE
                                    WHERE
                                            CO IN ($orgQ)
                                    AND THN = '$tahun'
                                    AND PROV = '0001'
                                    AND TIPE != '121-200'
                            ) TB3 ON TB0.ORG = TB3.ORG
                    ) TB5 ON TB0.COM = TB5.COM
                    LEFT JOIN (
                            SELECT
                                    MAX (ORG) ORG,
                                    SUM (QTY) REAL_ICS
                            FROM
                                    ZREPORT_SCM_REAL_SALES
                            WHERE
                                    ORG IN ($orgQ)
                            AND TAHUN = '$tahun'
                            AND PROPINSI_TO = '1092'
                    ) TB8 ON TB0.COM = TB8.ORG
                    LEFT JOIN (
                            SELECT
                                    MAX(CO) ORG,
                                    SUM (QUANTUM) RKAP_ICS
                            FROM
                                    SAP_T_RENCANA_SALES_TYPE
                            WHERE
                                    CO IN ($orgQ)
                            AND THN = '$org'
                            AND PROV = '1092'
                            
                    ) TB9 ON TB0.COM = TB9.ORG")->row_array();
        return $data;
    }

    public function sumSalesTLCCTahunan($tahun) {

        if ($tahun == date("Y")) {
            $bulan = date("m");
            $tanggal = date("Ymd");
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $bulan = '12';
            $hari = date('t');
        }
        $data = $this->db->query("SELECT
                                        TB0.COM,
                                        NVL (TB3.REALISASI, 0) REAL_SDK,
                                        NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        NVL (tb5.RKAP_EKSPOR, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        '0' REAL_ICS,
                                        '0' RKAP_ICS
                                FROM
                                        (SELECT '6000' COM FROM DUAL) TB0
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
                                                                        A .org com,
                                                                        c.budat,
                                                                        SUM (
                                                                                A .target * (c.porsi / D .total_porsi)
                                                                        ) AS target
                                                                FROM
                                                                        ZREPORT_TARGET_PLANTSCO A
                                                                LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
                                                                AND SUBSTR (c.budat, 1, 4) = TAHUN
                                                                AND SUBSTR (c.budat, 5, 2) = BULAN
                                                                AND c.tipe = A .tipe
                                                                LEFT JOIN (
                                                                        SELECT
                                                                                region,
                                                                                tipe,
                                                                                SUBSTR (budat, 1, 6) budat2,
                                                                                SUM (porsi) AS total_porsi
                                                                        FROM
                                                                                zreport_porsi_sales_region
                                                                        WHERE
                                                                                budat LIKE '$tahun%'
                                                                        AND VKORG = '6000'
                                                                        GROUP BY
                                                                                SUBSTR (budat, 1, 6),
                                                                                region,
                                                                                tipe
                                                                ) D ON D .tipe = A .tipe
                                                                AND BULAN = SUBSTR (D .budat2, 5, 2)
                                                                WHERE
                                                                        DELETE_MARK = 0
                                                                AND JENIS IS NULL
                                                                AND ORG = '6000'
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
                                        AND BULAN <= '$bulan'
                                        AND HARI <= CASE
                                        WHEN BULAN = '$bulan' THEN
                                                '$hari'
                                        ELSE
                                                '32'
                                        END
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB3 ON TB0.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                TB0.ORG COM,
                                                TB1.REAL_SM_EKSPOR,
                                                TB2.REAL_TR_EKSPOR,
                                                TB3.RKAP_EKSPOR
                                        FROM
                                                (SELECT '6000' ORG FROM DUAL) TB0
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_SM_EKSPOR
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '6000'
                                                AND TAHUN = '$tahun'
                                                AND BULAN <= '$bulan'
                                                AND PROPINSI_TO = '0001'
                                                AND ITEM != '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB1 ON TB0.ORG = TB1.ORG
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (QTY) REAL_TR_EKSPOR
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '6000'
                                                AND TAHUN = '$tahun'
                                                AND BULAN <= '$bulan'
                                                AND PROPINSI_TO = '0001'
                                                AND ITEM = '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB2 ON TB0.ORG = TB2.ORG
                                        LEFT JOIN (
                                                SELECT
                                                        ORG,
                                                        SUM (TARGET) RKAP_EKSPOR
                                                FROM
                                                        ZREPORT_TARGET_PLANTSCO
                                                WHERE
                                                        ORG = '6000'
                                                AND TAHUN = '$tahun'
                                                AND BULAN <= '$bulan'
                                                AND PLANT = '0001'
                                                AND TIPE != '121-200'
                                                GROUP BY
                                                        ORG
                                        ) TB3 ON TB0.ORG = TB3.ORG
                                ) TB5 ON TB0.COM = TB5.COM")->row_array();
        return $data;
    }

    public function sumSalesTonasaTahunan($tahun) {
        if ($tahun == date("Y")) {
            $bulan = date("m");
            $tanggal = date("Ymd");
            $hari = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $bulan = '12';
            $hari = date('t');
        }

        $data = array();
        $data = $this->db->query("SELECT
                                TB0.COM,
                                NVL (TB3.REALISASI, 0) REAL_SDK,
                                NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                NVL (tb5.rkap_ekspor, 0) rkap_ekspor,
                                NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                NVL (TB8.REAL_ICS, 0) REAL_ICS,
                                NVL (TB9.RKAP_ICS, 0) RKAP_ICS
                        FROM
                                (SELECT '4000' AS COM FROM DUAL) TB0
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
                                                                budat
                                                        FROM
                                                                sap_t_rencana_sales_type A
                                                        LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                                        AND c.vkorg = A .co
                                                        AND SUBSTR (c.budat, 1, 4) = THN
                                                        AND SUBSTR (c.budat, 5, 2) = BLN
                                                        AND c.tipe = A .tipe
                                                        LEFT JOIN (
                                                                SELECT
                                                                        SUBSTR (budat, 1, 6) budat2,
                                                                        region,
                                                                        tipe,
                                                                        SUM (porsi) AS total_porsi
                                                                FROM
                                                                        zreport_porsi_sales_region
                                                                WHERE
                                                                        budat LIKE '$tahun%'
                                                                AND region = 5
                                                                AND vkorg = '4000'
                                                                GROUP BY
                                                                        SUBSTR (budat, 1, 6),
                                                                        region,
                                                                        tipe
                                                        ) D ON c.region = D .region
                                                        AND D .tipe = A .tipe
                                                        AND BLN = SUBSTR (D .budat2, 5, 2)
                                                        WHERE
                                                                co = '4000'
                                                        AND thn = '$tahun'
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
                        ) TB2 ON TB0.COM = TB2.COM
                        LEFT JOIN (
                                SELECT
                                        COM,
                                        SUM (REALISASI) REALISASI
                                FROM
                                        (
                                                SELECT
                                                        ORG COM,
                                                        SUM (QTY) REALISASI
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '4000'
                                                AND TAHUN = '$tahun'
                                                AND BULAN <= '$bulan'
                                                AND HARI <= case when BULAN = '$bulan' THEN '$hari' ELSE '32' END 
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
                                                        AND \"bulan\" <= '$bulan'
                                                        AND \"hari\" <= case when \"bulan\" = '$bulan' THEN '$hari' ELSE '32' END
                                                        GROUP BY
                                                                \"org\"
                                        )
                                GROUP BY
                                        COM
                        ) TB3 ON TB0.COM = TB3.COM
                        LEFT JOIN (
                                SELECT
                                        TB0.ORG COM,
                                        TB1.REAL_SM_EKSPOR,
                                        TB2.REAL_TR_EKSPOR,
                                        TB3.RKAP_EKSPOR
                                FROM
                                        (SELECT '4000' ORG FROM DUAL) TB0
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (QTY) REAL_SM_EKSPOR
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '4000'
                                        AND TAHUN = '$tahun'
                                        AND BULAN <= '$bulan'
                                        AND PROPINSI_TO = '0001'
                                        AND ITEM != '121-200'
                                        GROUP BY
                                                ORG
                                ) TB1 ON TB0.ORG = TB1.ORG
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                SUM (QTY) REAL_TR_EKSPOR
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '4000'
                                        AND TAHUN = '$tahun'
                                        AND BULAN <= '$bulan'
                                        AND PROPINSI_TO = '0001'
                                        AND ITEM = '121-200'
                                        GROUP BY
                                                ORG
                                ) TB2 ON TB0.ORG = TB2.ORG
                                LEFT JOIN (
                                        SELECT
                                                CO ORG,
                                                SUM (QUANTUM) RKAP_EKSPOR
                                        FROM
                                                SAP_T_RENCANA_SALES_TYPE
                                        WHERE
                                                CO = '4000'
                                        AND THN = '$tahun'
                                        AND BLN <= '$bulan'
                                        AND PROV = '0001'
                                        GROUP BY
                                                CO
                                ) TB3 ON TB0.ORG = TB3.ORG
                        ) TB5 ON TB0.COM = TB5.COM
                        LEFT JOIN (
                                SELECT
                                        ORG,
                                        SUM (QTY) REAL_ICS
                                FROM
                                        ZREPORT_SCM_REAL_SALES
                                WHERE
                                        ORG = '4000'
                                AND TAHUN = '$tahun'
                                AND BULAN <= '$bulan'
                                AND PROPINSI_TO = '1092'
                                GROUP BY
                                        ORG
                        ) TB8 ON TB0.COM = TB8.ORG
                        LEFT JOIN (
                                SELECT
                                        CO ORG,
                                        SUM (QUANTUM) RKAP_ICS
                                FROM
                                        SAP_T_RENCANA_SALES_TYPE
                                WHERE
                                        CO = '4000'
                                AND THN = '$tahun'
                                AND BLN <= '$bulan' 
                                AND PROV = '1092'
                                GROUP BY
                                        CO
                        ) TB9 ON TB0.COM = TB9.ORG")->row_array();
        return $data;
    }

    public function getProdTahunan($org, $tahun, $type) {
        if ($tahun == date('Y')) {
            $bulan = date('m');
        } else {
            $bulan = '12';
        }
        $data = $this->db->query("SELECT
                                TB1.ORG,
                                TB1.RKAP,
                                TB4.RKAP_SD,
                                NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                TB3.REALISASI,
                                TB3.LASTDATE
                        FROM
                                (
                                        SELECT
                                                ORG,
                                                SUM (RKAP_PRODUK) RKAP
                                        FROM
                                                ZREPORT_DEMAND_PLANNING
                                        WHERE
                                                KODE_PRODUK = $type
                                        AND TO_CHAR (TANGGAL, 'YYYY') = '$tahun'
                                        AND ORG = '$org'
                                        GROUP BY
                                                ORG
                                ) TB1
                        LEFT JOIN (
                                SELECT
                                        ORG,
                                        SUM (PROG_PRODUK) PROGNOSE
                                FROM
                                        ZREPORT_DEMAND_PLANNING
                                WHERE
                                        KODE_PRODUK = $type
                                AND ORG = '$org'
                                AND TO_CHAR (TANGGAL, 'YYYY') = '$tahun'
                                AND TO_CHAR (TANGGAL, 'MM') >= '$bulan'
                                AND TO_CHAR (TANGGAL, 'DD') > (
                                        CASE
                                        WHEN TO_CHAR (TANGGAL, 'MM') = '$bulan' THEN
                                                TO_CHAR (
                                                        (
                                                                SELECT
                                                                        MAX (TANGGAL)
                                                                FROM
                                                                        ZREPORT_REAL_PROD_DEMANDPL
                                                                WHERE
                                                                        KODE_PRODUK = $type
                                                                AND TO_CHAR (TANGGAL, 'YYYYMM') = '$tahun$bulan'
                                                                AND ORG = '$org'
                                                        ),
                                                        'DD'
                                                )
                                        ELSE
                                                '0'
                                        END
                                )
                                GROUP BY
                                        ORG
                        ) TB2 ON TB1.ORG = TB2.ORG
                        LEFT JOIN (
                                SELECT
                                        ORG,
                                        SUM (QTY_PROD) REALISASI,
                                        MAX (TANGGAL) LASTDATE
                                FROM
                                        ZREPORT_REAL_PROD_DEMANDPL
                                WHERE
                                        KODE_PRODUK = $type
                                AND TO_CHAR (TANGGAL, 'YYYY') = '$tahun'
                                AND ORG = '$org'
                                GROUP BY
                                        ORG
                        ) TB3 ON TB1.ORG = TB3.ORG
                        LEFT JOIN (
                                SELECT
                                        ORG,
                                        SUM (RKAP_PRODUK) RKAP_SD
                                FROM
                                        ZREPORT_DEMAND_PLANNING
                                WHERE
                                        KODE_PRODUK = $type
                                AND TO_CHAR (TANGGAL, 'YYYY') = '$tahun'
                                AND ORG = '$org'
                                AND TO_CHAR (TANGGAL, 'DD') <= TO_CHAR (
                                        (
                                                SELECT
                                                        MAX (TANGGAL)
                                                FROM
                                                        ZREPORT_REAL_PROD_DEMANDPL
                                                WHERE
                                                        KODE_PRODUK = $type
                                                AND TO_CHAR (TANGGAL, 'YYYYMM') = TO_CHAR (
                                                        ZREPORT_DEMAND_PLANNING.TANGGAL,
                                                        'YYYYMM'
                                                )
                                                AND ORG = '$org'
                                        ),
                                        'DD'
                                )
                                GROUP BY
                                        ORG
                        ) TB4 ON TB1.ORG = TB4.ORG")->row_array();
        return $data;
    }

    function detailProdTahunan($org, $tahun, $kode) {
        $data = $this->db->query(" SELECT
                                NVL (TB1.ORG, '$org') ORG,
                                NVL (TB2.REALISASI_PROD, 0) REALISASI_PROD,
                                NVL (TB3.REALISASI_STOK, 0) REALISASI_STOK,
                                NVL (TB1.PROG_PRODUK, 0) PROG_PRODUK,
                                NVL (TB1.RKAP_PRODUK, 0) RKAP_PRODUK,
                                NVL (TB7.PROG_STOK, 0) PROG_STOK,
                                NVL (TB6.MAX_STOK, 0) MAX_STOK,
                                TB0.BULAN,
                                NVL (TB4.MAX_TANGGAL, 0) MAX_TANGGAL,
                                TB5.CREATE_DATE
                        FROM
                                (
                                        SELECT
                                                LPAD (LEVEL, 2, '0') BULAN
                                        FROM
                                                dual CONNECT BY LEVEL <= 12
                                ) TB0
                        LEFT JOIN (
                                SELECT
                                        ORG,
                                        MAX (KODE_PRODUK) KODE_PRODUK,
                                        SUM (PROG_PRODUK) PROG_PRODUK,
                                        SUM (RKAP_PRODUK) RKAP_PRODUK,
                                        MIN (MIN_STOK) MIN_STOK,
                                        MAX (MAX_STOK) MAX_STOK,
                                        TO_CHAR (TANGGAL, 'MM') BULAN
                                FROM
                                        ZREPORT_DEMAND_PLANNING
                                WHERE
                                        KODE_PRODUK = $kode
                                AND ORG = '$org'
                                AND TO_CHAR (TANGGAL, 'YYYY') = '$tahun'
                                GROUP BY
                                        TO_CHAR (TANGGAL, 'MM'),
                                        ORG
                                ORDER BY
                                        TO_CHAR (TANGGAL, 'MM') ASC
                        ) TB1 ON TB1.BULAN = TB0.BULAN
                        LEFT JOIN (
                                SELECT
                                        ORG,
                                        SUM (QTY_PROD) REALISASI_PROD,
                                        TO_CHAR (TANGGAL, 'MM') BULAN
                                FROM
                                        ZREPORT_REAL_PROD_DEMANDPL
                                WHERE
                                        KODE_PRODUK = $kode
                                AND ORG = '$org'
                                AND TO_CHAR (TANGGAL, 'YYYY') = '$tahun'
                                GROUP BY
                                        TO_CHAR (TANGGAL, 'MM'),
                                        ORG
                                ORDER BY
                                        TO_CHAR (TANGGAL, 'MM') ASC
                        ) TB2 ON TB1.ORG = TB2.ORG
                        AND TB0.BULAN = TB2.BULAN
                        LEFT JOIN (
                                SELECT
                                        ORG,
                                        MAX(QTY_STOK) REALISASI_STOK,
                                        TO_CHAR (TANGGAL, 'MM') BULAN
                                FROM
                                        ZREPORT_REAL_STOK_DEMANDPL T1
                                WHERE
                                        KODE_PRODUK = $kode
                                AND TO_CHAR (TANGGAL, 'DD') = (
                                        SELECT
                                                MAX (TO_CHAR(TANGGAL, 'DD'))
                                        FROM
                                                ZREPORT_REAL_STOK_DEMANDPL
                                        WHERE
                                                TO_CHAR (TANGGAL, 'YYYYMM') = TO_CHAR (T1.TANGGAL, 'YYYYMM')
                                                AND ORG = '$org'
                                                AND KODE_PRODUK = $kode
                                )
                                AND ORG = '$org'
                                AND TO_CHAR (TANGGAL, 'YYYY') = '$tahun' 
                                GROUP BY
                                    TO_CHAR (TANGGAL, 'MM'), ORG
                                ORDER BY
                                        TO_CHAR (TANGGAL, 'MM') ASC
                        ) TB3 ON TB1.ORG = TB3.ORG
                        AND TB0.BULAN = TB3.BULAN
                        LEFT JOIN (
                                SELECT
                                        ORG,
                                        TO_CHAR (TANGGAL, 'MM') BULAN,
                                        TO_CHAR (MAX(TANGGAL), 'DD') MAX_TANGGAL
                                FROM
                                        ZREPORT_REAL_PROD_DEMANDPL
                                WHERE
                                        KODE_PRODUK = $kode
                                AND ORG = '$org'
                                AND TO_CHAR (TANGGAL, 'YYYY') = '$tahun'
                                AND TO_CHAR (TANGGAL, 'MM') = TO_CHAR (TANGGAL, 'MM')
                                GROUP BY
                                        TO_CHAR (TANGGAL, 'MM'),
                                        ORG
                                ORDER BY
                                        TO_CHAR (TANGGAL, 'MM')
                        ) TB4 ON TB1.ORG = TB4.ORG
                        AND TB0.BULAN = TB4.BULAN
                        LEFT JOIN (
                                SELECT
                                        ORG,
                                        TO_CHAR (
                                                MAX (CREATED_DATE),
                                                'DD-MM-YYYY'
                                        ) CREATE_DATE
                                FROM
                                        ZREPORT_REAL_PROD_DEMANDPL
                                WHERE
                                        KODE_PRODUK = $kode
                                AND ORG = '$org'
                                AND TO_CHAR (TANGGAL, 'YYYY') = '$tahun'
                                GROUP BY
                                        ORG
                        ) TB5 ON TB1.ORG = TB5.ORG
                        LEFT JOIN ZREPORT_SCM_MINMAX_STOK TB6 ON TB1.ORG = TB6.ORG
                        AND TB1.KODE_PRODUK = TB6.KODE_PRODUK
                        LEFT JOIN (
                                SELECT
                                        ORG,
                                        PROG_STOK PROG_STOK,
                                        TO_CHAR (TANGGAL, 'DD') TGL,
                                        TO_CHAR (TANGGAL, 'MM') BULAN
                                FROM
                                        ZREPORT_DEMAND_PLANNING P2
                                WHERE
                                        KODE_PRODUK = $kode
                                AND ORG = '$org'
                                AND TO_CHAR (TANGGAL, 'YYYY') = '$tahun'
                                AND TO_CHAR (TANGGAL, 'DD') = (
                                        SELECT
                                                MAX(TO_CHAR (P1.TANGGAL, 'DD'))
                                        FROM
                                                ZREPORT_DEMAND_PLANNING P1
                                        WHERE
                                                TO_CHAR (P1.TANGGAL, 'YYYYMM') = TO_CHAR (P2.TANGGAL, 'YYYYMM')
                                                AND ORG = '$org'
                                                AND KODE_PRODUK = $kode
                                )

                                ORDER BY
                                        TO_CHAR (TANGGAL, 'MM') ASC
                        ) TB7 ON TB7.BULAN = TB0.BULAN
                        ORDER BY
                                TB0.BULAN ASC ")->result_array();
        return $data;
    }

    function refresh_mv() {
        $data = $this->db->query("BEGIN
            DBMS_SNAPSHOT.REFRESH('ZREPORT_SCM_REAL_SALES_JAM5');
            END;");
        return array('proccess' => '1');
    }

    function get_lastrefresh_mv() {
        $data = $this->db->query("
            SELECT
                OWNER,
                mview_name,
                TO_CHAR (
                        LAST_REFRESH_DATE,
                        'dd/mm/yyyy hh24:mi'
                ) last_refresh_date
        FROM
                all_mviews
        WHERE
        mview_name = 'ZREPORT_SCM_REAL_SALES_JAM5'");
        return $data->row_array();
    }

}

function getProsentase($orgIn, $tahun, $bulan, $hari) {
    $data = $this->db - query("
        SELECT
	MAX(COM),
	SUM (REALISASI) REALISASI
FROM
	(
		SELECT
			MAX (ORG) COM,
			SUM (QTY) REALISASI,
			ITEM
		FROM
			ZREPORT_SCM_REAL_SALES
		WHERE
			ORG IN ($orgIn)
		AND TAHUN = '$tahun'
		AND BULAN = '$bulan'
		AND HARI <= '$hari'
		AND ITEM != '121-200'
		AND PROPINSI_TO NOT IN ('0001', '1092')
		GROUP BY ITEM
	)
GROUP BY
	ITEM
            ")->result_array();
    return $result;
}
