<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class OptimasiMargin_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function getData($region, $tahun, $bulan, $hari){
        
//        if(date('mY') != $bulan.''.$tahun){
//             $hari = date('t', strtotime($tahun . "-" . $bulan));
//        }
//        $hari = date('d',strtotime("-1 days"));
//        $bulan = date('m');
//        $tahun = date('Y');
        $data = $this->db->query(" 
            
SELECT * FROM (
            SELECT
	MATERIAL,
	MARGIN,
        BLNMARGIN,
        THNMARGIN,
	id_prov,
	NM_PROV,
	NAMA_KABIRO,
	DESC_KABIRO,
	SUM (TARGET) TARGET,
	SUM (TARGET_REALH) TARGET_REALH,
	SUM (REAL) REAL,
	ROUND (SUM(REAL) / SUM(TARGET) * 100) PERSENTARGET,
	ROUND (
		(
			SUM (REAL) / SUM (TARGET_REALH) * 100
		)
	) PERSENTARGETH,
	ROUND(NVL(SUM (REAL),0) - SUM (TARGET_REALH)) SEL_SDK,
	ROUND(NVL(SUM (REAL),0) - SUM (TARGET)) SEL_BLN
FROM
	(
		SELECT
			NO_URUT,
			A .ID_KABIRO,
			A. ID_PROV,
			E.NM_PROV,
			MATERIAL,
			NAMA_KABIRO,
			DESC_KABIRO,
			MARGIN,
                        D.BULAN BLNMARGIN,
                        D.TAHUN THNMARGIN
		FROM
			ZREPORT_SCM_M_KABIROREGION A
		LEFT JOIN ZREPORT_SCM_MATERIALREGION B ON A .ID_REGION = B.ID_REGION
		LEFT JOIN ZREPORT_SCM_M_KABIRO C ON A .ID_KABIRO = C.ID_KABIRO
		LEFT JOIN (SELECT *
                FROM
                        ZREPORT_SCM_M_MARGIN
                WHERE
                        TAHUN || BULAN = (
                                SELECT
                                        *
                                FROM
                                        (
                                                SELECT
                                                        MAX (TAHUN || BULAN) MDATE
                                                FROM
                                                        ZREPORT_SCM_M_MARGIN
                                                WHERE
                                                        TAHUN || BULAN = '201801'
                                                UNION ALL
                                                        SELECT
                                                                MAX (TAHUN || BULAN) MDATE
                                                        FROM
                                                                ZREPORT_SCM_M_MARGIN
                                                        WHERE
                                                                TAHUN || BULAN < '201801'
                                                        UNION ALL
                                                                SELECT
                                                                        MAX (TAHUN || BULAN) MDATE
                                                                FROM
                                                                        ZREPORT_SCM_M_MARGIN
                                                                WHERE
                                                                        TAHUN || BULAN > '201801'
                                        )
                                WHERE
                                        MDATE IS NOT NULL
                                AND ROWNUM = 1
                        ) ) D ON A.ID_PROV = PROV AND MATERIAL = D . TYPE
		LEFT JOIN ZREPORT_M_PROVINSI E ON E.KD_PROV=A.ID_PROV
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
	AND A .HARI < '$hari'
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
				budat < '$tahun$bulan$hari'
		)
	GROUP BY
		prov,
		TIPE
) TB3 ON ID_PROV = TB3.prov
AND MATERIAL = TB3.TIPE
GROUP BY
        BLNMARGIN,
        THNMARGIN,
	MATERIAL,
	MARGIN,
	NAMA_KABIRO,
	DESC_KABIRO,
	ID_PROV,
	NM_PROV
ORDER BY
	MATERIAL, TO_NUMBER(MARGIN) DESC
        ) WHERE TARGET  != '0'
                 ")->result_array();
//        echo $this->db->last_query();
        return $data;
    }
    
}
