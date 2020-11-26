<?php

if (!defined("BASEPATH"))
    exit("No Direct Script Access Allowed");

class SiloPP_model extends CI_Model {

    private $db2;

    function __construct() {
        parent::__construct();
        $this->load->database();
        //$this->db2 = $this->load->database('scmproduction',TRUE);
    }

    function getDataPlant() {
        $data = $this->db->get('ZREPORT_PETA_SILOPP');
        return $data->result_array();
    }

    function getNMPlan() {
        $data = $this->db->query("SELECT NMPLAN,TO_CHAR(JAM_CREATE,'dd/mm/yyyy hh:ii:ss') JAM_CREATE FROM ZREPORT_STOCK_SILO X
				WHERE JAM_CREATE = (SELECT MAX(jam_create) FROM ZREPORT_STOCK_SILO where NMPLAN = X.NMPLAN)
				GROUP BY NMPLAN,JAM_CREATE");
        return $data->result_array();
    }

    function getStockSilo_old() {
        $data = $this->db->query("With STOCK as (
                            SELECT ORG,NMPLAN,TIPE,CREATE_DATE,SILO, QTY_ENTRY,
                            ROW_NUMBER() OVER(PARTITION BY ORG,NMPLAN,TIPE,SILO ORDER BY CREATE_DATE DESC) AS ranks
                            FROM ZREPORT_STOCK_SILO
                            WHERE SILO <> '00000SILOS'
                            GROUP BY ORG,NMPLAN, TIPE,CREATE_DATE,SILO,QTY_ENTRY )
                                          Select ORG,NMPLAN,TIPE,NVL(SUM(QTY_ENTRY),0) AS STOCK_SILO from STOCK
                                          where ranks=1
                                          group by ORG,NMPLAN,TIPE
                                          order by ORG,NMPLAN,TIPE");
        return $data->result_array();
    }
    
    function getStockSilo() {
        $data = $this->db->query("SELECT
	ORG,
	NMPLAN,
	TIPE,
	NVL (SUM(QTY_ENTRY), 0) AS STOCK_SILO
FROM
	ZREPORT_STOCK_SILO A
WHERE
	CREATE_DATE = (
		SELECT
			MAX (CREATE_DATE)
		FROM
			ZREPORT_STOCK_SILO B
		WHERE
			A .TIPE = B.TIPE
		AND A .NMPLAN = B.NMPLAN
		AND A .ORG = B.ORG
	)
GROUP BY
	ORG,
	NMPLAN,
	TIPE
ORDER BY
	ORG,
	NMPLAN,
	TIPE");
        return $data->result_array();
    }

    function getGit($plant) {
        $data = $this->db->query("SELECT * FROM (SELECT ORG,NMPLAN,CREATE_DATE, NVL(GIT,0) GIT, ETA
		FROM ZREPORT_STOCK_SILO
		WHERE SILO <> '00000SILOS' AND
					NMPLAN = '$plant'
		GROUP BY ORG,NMPLAN,CREATE_DATE,GIT,ETA
		ORDER BY ORG,NMPLAN ASC,CREATE_DATE DESC)
                WHERE ROWNUM = 1");
        return $data->result_array();
    }

    function getKwantum() {
        $data = $this->db->query("Select PLANT,
             SUM(KWANTUMX) AS KWANTUMX,
             ITEM_NO FROM ZREPORT_RPT_REAL c
             WHERE PLANT like '7%' AND
                   ITEM_NO like '121-30%' AND
                   TGL_cmplt BETWEEN (SELECT MAX(jam_create)
             FROM ZREPORT_STOCK_SILO where NMPLAN=c.PLANT) and
                                           (SELECT MAX(TGL_cmplt)
                                        FROM ZREPORT_RPT_REAL  where PLANT=c.PLANT )
             GROUP BY PLANT,ITEM_NO
             ORDER BY PLANT,ITEM_NO");
        return $data->result_array();
    }

    function getAverage($date1, $date2) {
        $data = $this->db->query("SELECT PLANT, SUM(KWANTUMX) AS KWANTUMX
            FROM ZREPORT_RPT_REAL
            WHERE PLANT LIKE '7%' AND
            ITEM_NO LIKE '121-30%' AND
            TGL_CMPLT BETWEEN TO_DATE('" . $date1 . "01', 'YYYYMMDD') AND TO_DATE('" . $date2 . "', 'YYYYMMDD')
            GROUP BY PLANT
            ORDER BY PLANT");
        return $data->result_array();
    }

    function getVkorgAverage($date1, $date2) {
        $data = $this->db->query("SELECT VKORG, WERKS, SUM(TON) AS KWANTUMX
            FROM ZREPORT_ONGKOSANGKUT_MOD
            WHERE 	VKORG IN ('3000','4000') AND
                            WADAT_IST BETWEEN TO_DATE('" . $date1 . "01', 'YYYYMMDD') AND TO_DATE('" . $date2 . "', 'YYYYMMDD')
            GROUP BY VKORG,WERKS
            ORDER BY VKORG,WERKS");
        return $data->result_array();
    }

    function getVkorgRealKemarin($date) {
        $data = $this->db->query("SELECT VKORG, WERKS, SUM(TON) AS KWANTUMX
            FROM ZREPORT_ONGKOSANGKUT_MOD
            WHERE 	VKORG IN ('3000','4000') AND
                            TO_CHAR(WADAT_IST, 'YYYYMMDD') = '$date'
            GROUP BY VKORG,WERKS
            ORDER BY VKORG,WERKS");
        return $data->result_array();
    }

    function getVkorgRealisasi($date) {
        $data = $this->db->query("SELECT VKORG, WERKS, SUM(TON) AS KWANTUMX
            FROM ZREPORT_ONGKOSANGKUT_MOD
            WHERE VKORG IN ('3000','4000') AND
                TO_CHAR(WADAT_IST, 'YYYYMMDD') = '" . $date . "'
                AND MATNR NOT LIKE '121-200%'
            GROUP BY VKORG,WERKS
            ORDER BY VKORG,WERKS");
        return $data->result_array();
    }

    function getRealKemarin($date) {
        $data = $this->db->query("SELECT PLANT, SUM(KWANTUMX) AS KWANTUMX
            FROM ZREPORT_RPT_REAL
            WHERE COM='7000' and PLANT LIKE '7%' AND
            ITEM_NO LIKE '121-30%' AND
            TO_CHAR(TGL_CMPLT, 'YYYYMMDD') = '$date'
            GROUP BY PLANT
            ORDER BY PLANT");
        return $data->result_array();
    }

    function getInfoPasar($date) {
        $data = $this->db->query("select com,plant,ITEMF,SOLD_TOF,sum(REAL) as REALTO from(
                select tb1.*,
                case when sold_to like '0000003%' then 'SP'
                when sold_to like '0000004%' then 'ST'
                else 'SP'
                end
                SOLD_TOF,
                case when item='121-301' then 'BAG'
                else 'BULK'
                end
                ITEMF
                from(
                select com,plant,substr(item_no,0,7) as item,SOLD_TO,sum(kwantumx) as real from ZREPORT_RPT_REAL where com='7000'
                and to_char(tgl_spj,'YYYYMMDD')='" . $date . "'
                and ( (order_type <>'ZNL' and
                (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
                and order_type <>'ZNL') )
                and sold_to not like '0000000%'
                group by com,plant,substr(item_no,0,7),SOLD_TO
                )tb1
                )group by com,plant,ITEMF,SOLD_TOF");
        return $data->result_array();
    }

    function getChartStock($org, $plant, $date_from, $date_to) {
        $data = $this->db->query("SELECT TB1.ORG,TB1.NMPLAN,TB1.CREATE_DATE,TB1.STOCK,TB2.KAPASITAS FROM (SELECT ORG,NMPLAN,CREATE_DATE,SUM(QTY_ENTRY) AS STOCK
                FROM ZREPORT_STOCK_SILO
                WHERE ORG = '$org' AND
                                        NMPLAN IN('$plant') AND
                                        CREATE_DATE BETWEEN TO_DATE('$date_from', 'ddmmyyyy') AND
                                        TO_DATE('$date_to', 'ddmmyyyy')
                GROUP BY ORG,NMPLAN,CREATE_DATE
                ORDER BY ORG,NMPLAN,CREATE_DATE
                ) TB1
                LEFT JOIN
                ZREPORT_PETA_SILOPP TB2
                ON TB1.NMPLAN = TB2.KODE_PLANT
                ORDER BY TB1.CREATE_DATE ASC");
       // echo $this->db->last_query();
        return $data->result_array();
    }
    //kode awal
//function getChartStock2($org, $plant, $date_from, $date_to) {
//        $data = $this->db->query("SELECT TB1.ORG,TB1.NMPLAN,TB1.CREATE_DATE,TB1.STOCK,TB2.KAPASITAS FROM (SELECT ORG,NMPLAN,CREATE_DATE,SUM(QTY_ENTRY) AS STOCK
//                FROM ZREPORT_STOCK_SILO
//                WHERE ORG = '$org' AND
//                                        NMPLAN = '$plant' AND
//                                        CREATE_DATE BETWEEN TO_DATE('$date_from', 'ddmmyyyy') AND
//                                        TO_DATE('$date_to', 'ddmmyyyy')
//                GROUP BY ORG,NMPLAN,CREATE_DATE
//                ORDER BY ORG,NMPLAN,CREATE_DATE
//                ) TB1
//                LEFT JOIN
//                ZREPORT_PETA_SILOPP TB2
//                ON TB1.NMPLAN = TB2.KODE_PLANT
//                ORDER BY TB1.CREATE_DATE ASC");
//        return $data->result_array();
//    }
    //kode akhir
    function getChartRilis($org, $plant, $date_from, $date_to) {
        $query = "";
        //echo $org;
        if ($org == '2000' || $org == '7000') {
            $query = "SELECT MAX(PLANT),TO_DATE(TGL_CMPLT, 'DD-MM-YYYY') AS TGL, SUM(KWANTUMX) AS RELEASE,
                   SUM (
                            CASE
                            WHEN ITEM_NO LIKE '121-301%' THEN
                                    KWANTUMX
                            ELSE
                                    0
                            END
                    ) BAG,
                    SUM (
                            CASE
                            WHEN ITEM_NO LIKE '121-302%' THEN
                                    KWANTUMX
                            ELSE
                                    0
                            END
                    ) BULK
                    FROM ZREPORT_RPT_REAL
                    WHERE PLANT IN('$plant') AND
                        ITEM_NO LIKE '121-30%' AND
                        TGL_CMPLT BETWEEN TO_DATE('$date_from', 'ddmmyyyy') AND
                        TO_DATE('$date_to', 'ddmmyyyy')
                    GROUP BY TO_DATE(TGL_CMPLT, 'DD-MM-YYYY')
                    ORDER BY TO_DATE(TGL_CMPLT, 'DD-MM-YYYY')";
        } else {
            $query = "SELECT MAX(WERKS), TO_DATE(WADAT_IST, 'DD-MM-YYYY') AS TGL, SUM(TON) AS RELEASE,
                    SUM (
                            CASE
                            WHEN MATNR LIKE '121-301%' THEN
                                    TON
                            ELSE
                                    0
                            END
                    ) BAG,
                    SUM (
                            CASE
                            WHEN MATNR LIKE '121-302%' THEN
                                    TON
                            ELSE
                                    0
                            END
                    ) BULK
                    FROM ZREPORT_ONGKOSANGKUT_MOD
                    WHERE WERKS IN('$plant') AND
                        MATNR LIKE '121-30%' AND
                        WADAT_IST BETWEEN TO_DATE('$date_from', 'ddmmyyyy') AND
                        TO_DATE('$date_to', 'ddmmyyyy')
                    GROUP BY TO_DATE(WADAT_IST, 'DD-MM-YYYY')
                    ORDER BY TO_DATE(WADAT_IST, 'DD-MM-YYYY')";
        }
        $data = $this->db->query($query);
        //echo $this->db->last_query();
        return $data->result_array();
    }

    function getAverage7Hari() {
        $tglskrg = date('Ymd');
        $tgllalu = date('Ymd', strtotime("-7 days"));
        $data = $this->db->query("SELECT PLANT, SUM(KWANTUMX) AS KWANTUMX
            FROM ZREPORT_RPT_REAL
            WHERE PLANT LIKE '7%' AND
            ITEM_NO LIKE '121-30%' AND
            TO_CHAR(TGL_CMPLT,'YYYYMMDD') >= '$tgllalu' AND
            TO_CHAR(TGL_CMPLT,'YYYYMMDD') <= '$tglskrg'
            GROUP BY PLANT
            UNION
            SELECT WERKS PLANT, SUM(TON) AS KWANTUMX
            FROM ZREPORT_ONGKOSANGKUT_MOD
            WHERE VKORG IN ('3000','4000') AND
            TO_CHAR(WADAT_IST,'YYYYMMDD') >= '$tgllalu' AND
            TO_CHAR(WADAT_IST,'YYYYMMDD') <= '$tglskrg'
            GROUP BY WERKS");
        return $data->result_array();
    }

    function getCapacity($plant) {

        $this->db->where('KODE_PLANT', $plant);
        $data = $this->db->get('SCM_SILO_CAPACITY');
        $result['SILO'] = $data->result_array();

        $this->db->where('PLANT', $plant);
        $data = $this->db->get('SCM_PACKER_CAPACITY');
        $result['PACKER'] = $data->result_array();

        return $result;
    }

    function getUtilitySDK($org, $plant) {
        $hari = date("d");
        $tahun = date("Y");
        $bulan = date("m");
        $tanggal = date("Ymd");
        if (date('d') == '01') {
            $tglkmren = date('d');
        } else {
            $tglkmren = date('d', strtotime($tanggal . "-1 days"));
        }
        //$tglkmren = str_pad($hari - 1, 2, '0', STR_PAD_LEFT);

        $data = $this->db->query(" SELECT
                                TB0.*, TB1.*, TO_CHAR(ROUND(
                                        (RELEASE_BAG / UTILITY_SDK * 100), 1
                                ),'0,99') AS prosentase_ultility
                        FROM
                                (
                                        SELECT
                                                MAX (ORG) ORG,
                                                SUM (porsi / total_porsi * UTILITY) UTILITY_SDK
                                        FROM
                                                (
                                                        SELECT
                                                                vkorg ORG,
                                                                budat,
                                                                porsi,
                                                                (
                                                                        SELECT
                                                                                SUM (porsi)
                                                                        FROM
                                                                                zreport_porsi_sales_region
                                                                        WHERE
                                                                                budat LIKE '$tahun$bulan%'
                                                                        AND vkorg = '$org'
                                                                        AND region = '5'
                                                                        AND tipe = '121-301'
                                                                ) AS total_porsi,
                                                                (
                                                                        SELECT
                                                                                SCM_UTILITY.UTILITY_TON * TO_NUMBER (
                                                                                        TO_CHAR (LAST_DAY(SYSDATE), 'DD')
                                                                                ) AS UTILITY
                                                                        FROM
                                                                                SCM_UTILITY
                                                                        WHERE
                                                                                PLANT = '$plant'
                                                                ) AS Utility
                                                        FROM
                                                                zreport_porsi_sales_region
                                                        WHERE
                                                                budat LIKE '$tahun$bulan%'
                                                        AND vkorg = '$org'
                                                        AND region = '5'
                                                        AND tipe = '121-301'
                                                )
                                        WHERE
                                                budat <= '$tahun$bulan$tglkmren'
                                ) TB0
                        LEFT JOIN (
                                SELECT
                                        COM ORG,
                                        PLANT,
                                        TO_CHAR (TGL_CMPLT, 'MM-YYYY') AS TGL,
                                        SUM (KWANTUMX) AS RELEASE_BAG
                                FROM
                                        ZREPORT_RPT_REAL
                                WHERE
                                        PLANT = '$plant'
                                AND ITEM_NO LIKE '121-301%'
                                AND TGL_CMPLT BETWEEN TO_DATE ('01$bulan$tahun', 'ddmmyyyy')
                                AND TO_DATE ('$tglkmren$bulan$tahun', 'ddmmyyyy')
                                GROUP BY
                                        TO_CHAR (TGL_CMPLT, 'MM-YYYY'),
                                        PLANT,
                                        COM
                        ) TB1 ON TB0.ORG = TB1.ORG");
        return $data->row_array();
    }

}
