<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access allowed');

class PackingPlantSemenIndonesia_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db2 = $this->load->database('scmproduction', TRUE);
    }

    function get_packing_plant($date){
    	
    	$data = $this->db->query("
    	 	SELECT
				ZMP.KD_PLANT AS ZMP_KD_PLANT,
				ZMP. NAME AS ZMP_NAME,
				(
					SELECT
						COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK
					FROM
						ZREPORT_RPT_REAL_NON70
					WHERE
						STATUS = 10
					AND tipe_truk BETWEEN 107
					AND 307
					AND DATE_CVY IS NULL
					AND PLANT = ZMP.KD_PLANT
				) AS JTRUK_ZAK_10,
				(
					SELECT
						COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK
					FROM
						ZREPORT_RPT_REAL_NON70
					WHERE
						STATUS = 10
					AND tipe_truk = 308
					AND DATE_CVY IS NULL
					AND PLANT = ZMP.KD_PLANT
				) AS JTRUK_CURAH_10,
				(
					SELECT
						COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK
					FROM
						ZREPORT_RPT_REAL_NON70
					WHERE
						STATUS = 40
					AND tipe_truk BETWEEN 107
					AND 307
					AND DATE_CVY IS NULL
					AND PLANT = ZMP.KD_PLANT
				) AS JTRUK_ZAK_40,
				(
					SELECT
						COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK
					FROM
						ZREPORT_RPT_REAL_NON70
					WHERE
						STATUS = 40
					AND tipe_truk = 308
					AND DATE_CVY IS NULL
					AND PLANT = ZMP.KD_PLANT
				) AS JTRUK_CURAH_40,
				(
					SELECT
						COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK
					FROM
						ZREPORT_RPT_REAL_NON70
					WHERE
						STATUS >= 50
					AND STATUS <= 60
					AND tipe_truk BETWEEN 107
					AND 307
					AND DATE_CVY IS NULL
					AND PLANT = ZMP.KD_PLANT
				) AS JTRUK_ZAK_5060,
				(
					SELECT
						COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK
					FROM
						ZREPORT_RPT_REAL_NON70
					WHERE
						STATUS >= 50
					AND STATUS <= 60
					AND tipe_truk = 308
					AND DATE_CVY IS NULL
					AND PLANT = ZMP.KD_PLANT
				) AS JTRUK_CURAH_5060,
				(
					SELECT
						COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK
					FROM
						ZREPORT_RPT_REAL
					WHERE
						STATUS = 70
					AND tipe_truk BETWEEN 107
					AND 307
					AND PLANT = ZMP.KD_PLANT
					AND ORDER_TYPE IN ('ZLF', 'ZLFP')
					AND TO_CHAR (TGL_SPJ, 'YYYY-MM-DD') = '$date'
				) AS JTRUK_ZAK_70,
				(
					SELECT
						COUNT (DISTINCT(NO_POLISI)) JUML_TRUCK
					FROM
						ZREPORT_RPT_REAL
					WHERE
						STATUS = 70
					AND tipe_truk = 308
					AND PLANT = ZMP.KD_PLANT
					AND ORDER_TYPE IN ('ZLF', 'ZLFP')
					AND TO_CHAR (TGL_SPJ, 'YYYY-MM-DD') = '$date'
				) AS JTRUK_CURAH_70,
				(
					SELECT
						ROUND (AVG(selisih), 2) AVERAGE
					FROM
						(
							SELECT DISTINCT
								(NO_POLISI),
								((SYSDATE - TGL_ANTRI) * 24 * 60) selisih
							FROM
								ZREPORT_RPT_REAL_NON70
							WHERE
								STATUS = 10
							AND DATE_CVY IS NULL
							AND tipe_truk BETWEEN 107
							AND 307
							AND PLANT = ZMP.KD_PLANT
						)
				) AS JWAKTU_ZAK_10,
				(
					SELECT
						ROUND (AVG(selisih), 2) AVERAGE
					FROM
						(
							SELECT DISTINCT
								(NO_POLISI),
								((SYSDATE - TGL_ANTRI) * 24 * 60) selisih
							FROM
								ZREPORT_RPT_REAL_NON70
							WHERE
								STATUS = 10
							AND DATE_CVY IS NULL
							AND tipe_truk = 308
							AND PLANT = ZMP.KD_PLANT
						)
				) AS JWAKTU_CURAH_10,
				(
					SELECT
						ROUND (AVG(selisih), 2) AVERAGE
					FROM
						(
							SELECT DISTINCT
								(NO_POLISI),
								((SYSDATE - TGL_ANTRI) * 24 * 60) selisih
							FROM
								ZREPORT_RPT_REAL_NON70
							WHERE
								STATUS = 40
							AND DATE_CVY IS NULL
							AND tipe_truk BETWEEN 107
							AND 307
							AND PLANT = ZMP.KD_PLANT
						)
				) AS JWAKTU_ZAK_40,
				(
					SELECT
						ROUND (AVG(selisih), 2) AVERAGE
					FROM
						(
							SELECT DISTINCT
								(NO_POLISI),
								((SYSDATE - TGL_ANTRI) * 24 * 60) selisih
							FROM
								ZREPORT_RPT_REAL_NON70
							WHERE
								STATUS = 40
							AND DATE_CVY IS NULL
							AND tipe_truk = 308
							AND PLANT = ZMP.KD_PLANT
						)
				) AS JWAKTU_CURAH_40,
				(
					SELECT
						ROUND (AVG(selisih), 2) AVERAGE
					FROM
						(
							SELECT DISTINCT
								(NO_POLISI),
								((SYSDATE - TGL_ANTRI) * 24 * 60) selisih
							FROM
								ZREPORT_RPT_REAL_NON70
							WHERE
								STATUS >= 50
							AND STATUS <= 60
							AND DATE_CVY IS NULL
							AND tipe_truk BETWEEN 107
							AND 307
							AND PLANT = ZMP.KD_PLANT
						)
				) AS JWAKTU_ZAK_5060,
				(
					SELECT
						ROUND (AVG(selisih), 2) AVERAGE
					FROM
						(
							SELECT DISTINCT
								(NO_POLISI),
								((SYSDATE - TGL_ANTRI) * 24 * 60) selisih
							FROM
								ZREPORT_RPT_REAL_NON70
							WHERE
								STATUS >= 50
							AND STATUS <= 60
							AND DATE_CVY IS NULL
							AND tipe_truk = 308
							AND PLANT = ZMP.KD_PLANT
						)
				) AS JWAKTU_CURAH_5060,
				(
					SELECT
						ROUND (AVG(selisih), 2) AVERAGE
					FROM
						(
							SELECT DISTINCT
								(NO_POLISI),
								((SYSDATE - TGL_ANTRI) * 24 * 60) selisih
							FROM
								ZREPORT_RPT_REAL
							WHERE
								STATUS = 70
							AND ORDER_TYPE IN ('ZLF', 'ZLFP')
							AND tipe_truk BETWEEN 107
							AND 307
							AND PLANT = ZMP.KD_PLANT
							AND TO_CHAR (TGL_SPJ, 'YYYY-MM-DD') = '$date'
						)
				) AS JWAKTU_ZAK_70,
				(
					SELECT
						ROUND (AVG(selisih), 2) AVERAGE
					FROM
						(
							SELECT DISTINCT
								(NO_POLISI),
								((SYSDATE - TGL_ANTRI) * 24 * 60) selisih
							FROM
								ZREPORT_RPT_REAL
							WHERE
								STATUS = 70
							AND ORDER_TYPE IN ('ZLF', 'ZLFP')
							AND tipe_truk = 308
							AND PLANT = ZMP.KD_PLANT
							AND TO_CHAR (TGL_SPJ, 'YYYY-MM-DD') = '$date'
						)
				) AS JWAKTU_CURAH_70,
				(
					SELECT
						SUM (KWANTUMX) SUM
					FROM
						ZREPORT_RPT_REAL
					WHERE
						STATUS = 70
					AND ORDER_TYPE IN ('ZLF', 'ZLFP')
					AND tipe_truk BETWEEN 107
					AND 307
					AND PLANT = ZMP.KD_PLANT
					AND TO_CHAR (TGL_SPJ, 'YYYY-MM-DD') = '$date'
				) AS VOLUME_ZAK,
				(
					SELECT
						SUM (KWANTUMX) SUM
					FROM
						ZREPORT_RPT_REAL
					WHERE
						STATUS = 70
					AND ORDER_TYPE IN ('ZLF', 'ZLFP')
					AND tipe_truk = 308
					AND PLANT = ZMP.KD_PLANT
					AND TO_CHAR (TGL_SPJ, 'YYYY-MM-DD') = '$date'
				) AS VOLUME_CURAH
			FROM
				ZREPORT_M_PLANT ZMP
			WHERE
				ZMP.KD_PLANT NOT BETWEEN 6000
			AND 6999
			AND ZMP.KD_PLANT >= 3000
			ORDER BY
				ZMP_KD_PLANT DESC
    	 	");
		
		 return $data->result_array();
    }
}