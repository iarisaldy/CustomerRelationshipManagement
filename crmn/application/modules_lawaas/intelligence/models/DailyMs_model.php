<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class DailyMs_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /*
     * query MS SMIG
     */

    function datasmig($tahun, $bulan, $hari) {
//        $whereBulan = "";
//        if ($bulan != 00) {
//            $whereBulan = "BULAN = '$bulan' AND";
//        }
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query("SELECT
	TB1.PROV,
	TB8.NM_PROV,
	NVL (TB1.TARGET, 0) TARGET,
	NVL (TB2. REAL, 0) REAL,
	NVL (TB6.RKAP_MS, 0) RKAP_MS,
        NVL (TB8.DEMAND_HARIAN, 0) DEMAND_HARIAN,
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
			co != '6000'
		AND thn = '$tahun'
		AND bln = '$bulan'
		AND A .prov != '0001'
		AND A .prov != '1092'
		GROUP BY
			A .prov
	) TB1
LEFT JOIN (
	SELECT
		PROPINSI_TO,
		SUM (QTY) REAL
	FROM
		ZREPORT_SCM_REAL_SALES
	WHERE
		ORG != '6000'
	AND TAHUN = '$tahun'
	AND BULAN = '$bulan'
	AND HARI <= '$hari'
	AND PROPINSI_TO NOT IN ('1092', '0001')
	GROUP BY
		PROPINSI_TO
) TB2 ON TB1.PROV = TB2.PROPINSI_TO
LEFT JOIN (
	SELECT
		PROPINSI,
		SUM(QTY) RKAP_MS
	FROM
		ZREPORT_MS_RKAPMS
	WHERE KODE_PERUSAHAAN IN ('110','102','112')
	AND THN = '$tahun'
	AND STATUS = '0'
GROUP BY PROPINSI
) TB6 ON TB1.PROV = TB6.PROPINSI
LEFT JOIN (
	SELECT
	TB1.KD_PROV,
	(
		tb1.qty * (
			SELECT
				SUM (porsi) porsi
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat LIKE '$tahun$bulan%'
			AND c.budat <= '$tahun$bulan$hari'
		) / (
			SELECT
				SUM (porsi) porsi_total
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat LIKE '$tahun$bulan%'
		)
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
) TB7 ON TB1.PROV = TB7.KD_PROV
LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
LEFT JOIN(
SELECT
	tbm1.KD_PROV,
	(
		tbm1.qty * tbm2.porsi / tbm3.porsi_total
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
	) tbm1
LEFT JOIN (
	SELECT
		vkorg org,
		SUM (porsi) porsi
	FROM
		zreport_porsi_sales_region c
	WHERE
		c.region = 5
	AND c.vkorg != '6000'
	AND c.budat LIKE '$tahun$bulan%'
	AND c.budat <= '$tahun$bulan$hari'
	GROUP BY
		VKORG
) tbm2 ON tbm2.org != '6000'
LEFT JOIN (
	SELECT
		vkorg org,
		SUM (porsi) porsi_total
	FROM
		zreport_porsi_sales_region c
	WHERE
		c.region = 5
	AND c.vkorg != '6000'
	AND c.budat LIKE '$tahun$bulan%'
	GROUP BY
		VKORG
) tbm3 ON tbm2.org = tbm3.org)TB8 ON TB1.PROV = TB8.KD_PROV
ORDER BY
	TB1.PROV");
        return $data->result_array();
    }

    /*
     * query MS per Opco (SG, SP, ST)
     */

    function datas($org, $tahun, $bulan, $hari) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        if ($org == 7000) {
            $kd_per = 110;
        } elseif ($org == 3000) {
            $kd_per = 102;
        } elseif ($org == 4000) {
            $kd_per = 112;
        }
        $data = $this->db->query("SELECT
                                        TB1.PROV,
                                        TB8.NM_PROV,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB2. REAL, 0) REAL,
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH,
                                        NVL (TB4.HARIAN_MAX, 0) HARIAN_MAX,
                                        TB5.NAMA_KABIRO,
                                        NVL (TB6.RKAP_MS, 0) RKAP_MS,
                                        NVL (TB8.DEMAND_HARIAN, 0) DEMAND_HARIAN,
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
                                                        co = '$org'
                                                AND thn = '$tahun'
                                                AND bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                                GROUP BY
                                                        A .prov
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                PROPINSI_TO,
                                                SUM (QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG,
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
                                                ORG,
                                                PROPINSI_TO,
                                                MAX (QTY) HARIAN_MAX
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG,
                                                PROPINSI_TO
                                ) TB4 ON TB1.PROV = TB4.PROPINSI_TO
                                LEFT JOIN (
                                        SELECT
                                                tb5.id_prov PROV,
                                                tb6.nama_kabiro
                                        FROM
                                                ZREPORT_SCM_KABIRO_SALES tb5
                                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                                        WHERE
                                                TB5.ORG = '$org'
                                ) TB5 ON TB1.PROV = TB5.PROV
                                LEFT JOIN (
                                        SELECT
                                                PROPINSI,
                                                QTY RKAP_MS
                                        FROM
                                                ZREPORT_MS_RKAPMS
                                        WHERE
                                                KODE_PERUSAHAAN = '$kd_per'
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
                                                AND c.vkorg = '$org'
                                                AND c.budat LIKE '$tahun$bulan%'
                                                AND c.budat <= '$tahun$bulan$hari'
                                                GROUP BY
                                                        VKORG
                                        ) tb2 ON TB2.org = '$org'
                                        LEFT JOIN (
                                                SELECT
                                                        vkorg org,
                                                        SUM (porsi) porsi_total
                                                FROM
                                                        zreport_porsi_sales_region c
                                                WHERE
                                                        c.region = 5
                                                AND c.vkorg = '$org'
                                                AND c.budat LIKE '$tahun$bulan%'
                                                GROUP BY
                                                        VKORG
                                        ) tb3 ON TB2.org = tb3.org
                                ) TB7 ON TB1.PROV = TB7.KD_PROV
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN(
SELECT
	tbm1.KD_PROV,
	(
		tbm1.qty * tbm2.porsi / tbm3.porsi_total
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
	) tbm1
LEFT JOIN (
	SELECT
		vkorg org,
		SUM (porsi) porsi
	FROM
		zreport_porsi_sales_region c
	WHERE
		c.region = 5
	AND c.vkorg = '$org'
	AND c.budat LIKE '$tahun$bulan%'
	AND c.budat <= '$tahun$bulan$hari'
	GROUP BY
		VKORG
) tbm2 ON tbm2.org = '$org'
LEFT JOIN (
	SELECT
		vkorg org,
		SUM (porsi) porsi_total
	FROM
		zreport_porsi_sales_region c
	WHERE
		c.region = 5
	AND c.vkorg = '$org'
	AND c.budat LIKE '$tahun$bulan%'
	GROUP BY
		VKORG
) tbm3 ON tbm2.org = tbm3.org)TB8 ON TB1.PROV = TB8.KD_PROV
ORDER BY
	TB1.PROV");
        //echo $this->db->last_query();
        return $data->result_array();
    }

    /*
     * query grafik line chart
     */

    function grafik($org, $tahun, $bulan) {
        return $this->db->query("SELECT
                                        TB2.ORG,
                                        TB2.TAHUN,
                                        TB2.BULAN,
                                        TB2.TANGGAL HARI,
                                        NVL (TB1.REAL_VOL, 0) REAL_VOL,
                                        TB2. DEMAND,
                                        NVL (
                                                CASE TB2. DEMAND
                                                WHEN 0 THEN
                                                        0
                                                ELSE
                                                        (TB1.REAL_VOL / TB2. DEMAND) * 100
                                                END,
                                                0
                                        ) AS MARKETSHARE
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        TAHUN,
                                                        BULAN,
                                                        HARI,
                                                        SUM (QTY) REAL_VOL
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND ITEM != '121-200'
                                                AND PROPINSI_TO NOT IN ('1092', '0001')
                                                GROUP BY
                                                        ORG,
                                                        TAHUN,
                                                        BULAN,
                                                        HARI
                                        ) TB1
                                RIGHT JOIN (
                                        SELECT
                                                TO_CHAR (c.VKORG) org,
                                                TAHUN,
                                                BULAN,
                                                SUBSTR (c.budat ,- 2) TANGGAL,
                                                SUM (
                                                        A .QTY * (c.porsi / D .total_porsi)
                                                ) AS DEMAND
                                        FROM
                                                ZREPORT_SCM_DEMAND_PROVINSI A
                                        LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                        AND c.vkorg = '$org'
                                        AND c.budat LIKE '$tahun$bulan%' --AND c.tipe = A .tipe
                                        LEFT JOIN (
                                                SELECT
                                                        region,
                                                        SUM (porsi) AS total_porsi
                                                FROM
                                                        zreport_porsi_sales_region
                                                WHERE
                                                        budat LIKE '$tahun$bulan%'
                                                AND vkorg = '$org'
                                                GROUP BY
                                                        region
                                        ) D ON c.region = D .region --AND D .tipe = A .tipe
                                        WHERE
                                                TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND KD_PROV NOT IN ('0001', '1092')
                                        GROUP BY
                                                TO_CHAR (c.VKORG),
                                                TAHUN,
                                                BULAN,
                                                c.budat
                                ) TB2 ON TB1.HARI = TB2.TANGGAL
                                ORDER BY
                                        TB2.TANGGAL")->result_array();
    }

    /*
     * query ambil data provinsi
     */

    function getProv() {
        $data = $this->db->query("SELECT KD_PROV, NM_PROV FROM ZREPORT_M_PROVINSI WHERE KD_PROV != '0001' AND KD_PROV != '1092'");
        return $data->result_array();
    }

    /*
     * query summary market share start
     */

    // query realisasi SMIG
    function realisasi($tahun, $bulan, $hari) {
        return $this->db->query("SELECT
                                SUM (qty) real
                        FROM
                                ZREPORT_SCM_REAL_SALES
                        WHERE
                                tahun = '$tahun'
                        AND bulan = '$bulan'
                        AND hari <= '$hari'
                        AND propinsi_to NOT IN ('1092', '0001')
                        AND item != '121-200'")->result_array();
    }

    // query realisasi per Opco (SG, SP, ST)
    function realisasico($org, $tahun, $bulan, $hari) {
        return $this->db->query("SELECT
                       SUM(qty) real
                       FROM
                               ZREPORT_SCM_REAL_SALES
                       WHERE
                            tahun = '$tahun'
                     AND bulan = '$bulan'
                     AND hari <= '$hari'
                     AND propinsi_to NOT IN ('1092', '0001')
                     AND item != '121-200'
                     AND ORG='$org'")->result_array();
    }

    // query target SMIG
    function targetsmig($tahun) {
        return $this->db->query("select sum(target) targetsmig from ZREPORT_MS_RKAP where tahun = '$tahun'")->result_array();
    }

    // query target per Opco (SG, SP, ST)
    function targetco($org, $tahun) {
        if ($org == 7000) {
            $kd_per = 110;
        } elseif ($org == 3000) {
            $kd_per = 102;
        } elseif ($org == 4000) {
            $kd_per = 112;
        }
        return $this->db->query("select target as targetco from ZREPORT_MS_RKAP where KODE_PERUSAHAAN = '$kd_per' and tahun = '$tahun'")->result_array();
    }

    // query ms per Opco (SG, SP, ST)
    function msco($org, $tahun, $bulan, $hari) {
        return $this->db->query("SELECT
                                        CASE TB2.DEMANDHARIAN
                                WHEN 0 THEN
                                        0
                                ELSE
                                        (tb1. REAL / TB2.DEMANDHARIAN) * 100
                                END AS marketshare
                                FROM
                                        (
                                                SELECT
                                                        SUM (qty) REAL,
                                                        org
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND hari <= '$hari'
                                                AND propinsi_to NOT IN ('1092', '0001')
                                                AND item != '121-200'
                                                AND ORG = '$org'
                                                GROUP BY
                                                        org
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                TB1.ORG,
                                                CASE TB3.PORSI_TOTAL
                                        WHEN 0 THEN
                                                0
                                        ELSE
                                                TB1.QTY * TB2.PORSI / TB3.PORSI_TOTAL
                                        END AS DEMANDHARIAN
                                        FROM
                                                (
                                                        SELECT
                                                                '$org' org,
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
                                                AND c.vkorg = '$org'
                                                AND c.budat LIKE '$tahun$bulan%'
                                                AND c.budat <= '$tahun$bulan$hari'
                                                GROUP BY
                                                        VKORG
                                        ) tb2 ON TB2.org = '$org'
                                        LEFT JOIN (
                                                SELECT
                                                        vkorg org,
                                                        SUM (porsi) porsi_total
                                                FROM
                                                        zreport_porsi_sales_region c
                                                WHERE
                                                        c.region = 5
                                                AND c.vkorg = '$org'
                                                AND c.budat LIKE '$tahun$bulan%'
                                                GROUP BY
                                                        VKORG
                                        ) tb3 ON TB2.org = tb3.org
                                ) TB2 ON TB1.ORG = TB2.ORG")->result_array();
    }

    /*
     * query summary market share end
     */

    function insert($data) {
        $kd_prov = $data['KD_PROV'];
        $kd_kota = $data['KD_KOTA'];
        $kd_perusahaan = $data['KD_PERUSAHAAN'];
        $tahun = $data['TAHUN'];
        $bulan = $data['BULAN'];
        $hari = $data['HARI'];
        $harga_jual = $data['HARGA_JUAL'];
        $harga_tebus = $data['HARGA_TEBUS'];
        $tipe = $data['TIPE'];
        $user = $data['CREATE_BY'];
        $query = "INSERT INTO SCM_MI_PRICE_SURVEY "
                . "(KD_PROV,KD_KOTA,KD_PERUSAHAAN,TAHUN,BULAN,HARI,HARGA_JUAL,HARGA_TEBUS,TIPE,CREATE_BY,CREATE_DATE) "
                . "VALUES ('$kd_prov','$kd_kota','$kd_perusahaan','$tahun','$bulan','$hari',$harga_jual,$harga_tebus,'$tipe',"
                . "'$user',SYSDATE)";
//        echo $query;
        return $this->db->query($query);
//        return $this->db->insert_id();
    }

    function update($data) {
        $kd_prov = $data['KD_PROV'];
        $kd_kota = $data['KD_KOTA'];
        $kd_perusahaan = $data['KD_PERUSAHAAN'];
        $tahun = $data['TAHUN'];
        $bulan = $data['BULAN'];
        $hari = $data['HARI'];
        $tipe = $data['TIPE'];
        $harga_jual = $data['HARGA_JUAL'];
        $harga_tebus = $data['HARGA_TEBUS'];
        $user = $data['CREATE_BY'];
        $updt = $this->db->query("UPDATE SCM_MI_PRICE_SURVEY
                SET HARGA_JUAL = '$harga_jual',
                 HARGA_TEBUS = '$harga_tebus',
                     UPDATE_BY = '$user',
                         UPDATE_DATE = SYSDATE
                WHERE
                        KD_PROV = '$kd_prov'
                AND KD_KOTA = '$kd_kota'
                AND KD_PERUSAHAAN = '$kd_perusahaan'
                AND TAHUN = '$tahun'
                AND BULAN = '$bulan'
                AND HARI = '$hari'
                AND TIPE = '$tipe'");
        return $updt;
    }

    function cekData($data) {
        $kd_prov = $data['KD_PROV'];
        $kd_kota = $data['KD_KOTA'];
        $kd_perusahaan = $data['KD_PERUSAHAAN'];
        $tahun = $data['TAHUN'];
        $bulan = $data['BULAN'];
        $hari = $data['HARI'];
        $tipe = $data['TIPE'];
        $cek = $this->db->query("SELECT
                            *
                    FROM
                            SCM_MI_PRICE_SURVEY
                    WHERE
                            KD_PROV = '$kd_prov'
                    AND KD_KOTA = '$kd_kota'
                    AND KD_PERUSAHAAN = '$kd_perusahaan'
                    AND TAHUN = '$tahun'
                    AND BULAN = '$bulan'
                    AND HARI = '$hari'
                    AND TIPE = '$tipe'");
        return $cek->num_rows();
    }

    function getPrice($kd_prov, $kd_kota, $tahun, $bulan, $tipe) {
        $kota = '';
        if ($kd_kota != 0) {
            $kota = "AND TB1.KD_KOTA = '$kd_kota'";
        }
        $data = $this->db->query("SELECT
                                        TB2.NM_PROV,
                                        TB3.NM_KOTA,
                                        TB4.PRODUK,
                                        TB1.KD_PERUSAHAAN,
                                        TB1.TAHUN,
                                        TB1.BULAN,
                                        TB1.HARI,
                                        TB1.HARGA_JUAL,
                                        TB1.HARGA_TEBUS,
                                        TB1.TIPE
                                FROM
                                        SCM_MI_PRICE_SURVEY TB1
                                LEFT JOIN ZREPORT_M_PROVINSI TB2 ON TB1.KD_PROV = TB2.KD_PROV
                                LEFT JOIN ZREPORT_M_KOTA TB3 ON TB1.KD_KOTA = TB3.KD_KOTA
                                LEFT JOIN ZREPORT_MS_PERUSAHAAN TB4 ON TB1.KD_PERUSAHAAN = TB4.KODE_PERUSAHAAN
                                WHERE
                                        TB1.KD_PROV = '$kd_prov'
                                AND TB1.TIPE = '$tipe'
                                AND TB1.TAHUN = '$tahun'
                                AND TB1.BULAN = '$bulan' 
                                    $kota
                                ORDER BY
                                        TB1.KD_PERUSAHAAN,
                                        TB1.TIPE");
//        echo $this->db->last_query();
        return $data->result_array();
    }

    function getPriceRange($kd_prov, $kd_kota, $tahun_awal, $tahun_akhir, $bulan_awal, $bulan_akhir, $tipe) {
        $kota = '';
        if ($kd_kota != 0) {
            $kota = "AND TB1.KD_KOTA = '$kd_kota'";
        }
        $data = $this->db->query("SELECT
                                        TB2.NM_PROV,
                                        TB3.NM_KOTA,
                                        TB4.PRODUK,
                                        TB1.KD_PERUSAHAAN,
                                        CONCAT(CONCAT(TB1.BULAN,'/'),TB1.TAHUN) BULAN,
                                        TB1.HARI,
                                        TB1.HARGA_JUAL,
                                        TB1.HARGA_TEBUS,
                                        TB1.TIPE
                                FROM
                                        SCM_MI_PRICE_SURVEY TB1
                                LEFT JOIN ZREPORT_M_PROVINSI TB2 ON TB1.KD_PROV = TB2.KD_PROV
                                LEFT JOIN ZREPORT_M_KOTA TB3 ON TB1.KD_KOTA = TB3.KD_KOTA
                                LEFT JOIN ZREPORT_MS_PERUSAHAAN TB4 ON TB1.KD_PERUSAHAAN = TB4.KODE_PERUSAHAAN
                                WHERE
                                        TB1.KD_PROV = '$kd_prov'
                                AND TB1.TIPE = '$tipe'
                                AND (
                                        TB1.TAHUN >= '$tahun_awal'
                                        AND TB1.TAHUN <= '$tahun_akhir'
                                )
                                AND (
                                        (
                                                TB1.BULAN >= '$bulan_awal'
                                                AND TAHUN = '$tahun_awal'
                                        )
                                        OR (
                                                TB1.BULAN <= '$bulan_akhir'
                                                AND TAHUN = '$tahun_akhir'
                                        )
                                )
                                    $kota
                                ORDER BY
                                        TB1.KD_PERUSAHAAN,
                                        TB1.TIPE");
//        echo $this->db->last_query();
        return $data->result_array();
    }

    function getBrand($kd_prov, $kd_kota, $tahun, $bulan, $tipe) {
        $kota = '';
        if ($kd_kota != 0) {
            $kota = "AND TB1.KD_KOTA = '$kd_kota'";
        }
        $data = $this->db->query("SELECT DISTINCT
                            (TB1.KD_PERUSAHAAN),
                            TB2.PRODUK
                    FROM
                            SCM_MI_PRICE_SURVEY TB1
                    LEFT JOIN ZREPORT_MS_PERUSAHAAN TB2 ON TB1.KD_PERUSAHAAN = TB2.KODE_PERUSAHAAN
                    WHERE
                            TB1.KD_PROV = '$kd_prov'
                    AND TB1.TIPE = '$tipe'
                    AND TB1.TAHUN = '$tahun'
                    AND TB1.BULAN = '$bulan'
                        $kota
                    ORDER BY
                            TB1.KD_PERUSAHAAN");
        return $data->result_array();
    }

    function getBrandPrice($kd_prov, $kd_kota, $tahunawal, $tahunakhir, $bulanawal, $bulanakhir, $tipe) {
        $kota = '';
        if ($kd_kota != 0) {
            $kota = "AND TB1.KD_KOTA = '$kd_kota'";
        }
        $data = $this->db->query("SELECT DISTINCT
                            (TB1.KD_PERUSAHAAN),
                            TB2.PRODUK
                    FROM
                            SCM_MI_PRICE_SURVEY TB1
                    LEFT JOIN ZREPORT_MS_PERUSAHAAN TB2 ON TB1.KD_PERUSAHAAN = TB2.KODE_PERUSAHAAN
                    WHERE
                            TB1.KD_PROV = '$kd_prov'
                    AND TB1.TIPE = '$tipe'            
                    AND (
                            TB1.TAHUN >= '$tahunawal'
                            AND TB1.TAHUN <= '$tahunakhir'
                    )
                    AND (
                            (
                                    TB1.BULAN >= '$bulanawal'
                                    AND TAHUN = '$tahunawal'
                            )
                            OR (
                                    TB1.BULAN <= '$bulanakhir'
                                    AND TAHUN = '$tahunakhir'
                            )
                    )
                        $kota
                    ORDER BY
                            TB1.KD_PERUSAHAAN");
        return $data->result_array();
    }

    function getKota($kd_prov) {
        $data = $this->db->query("SELECT KD_KOTA, NM_KOTA FROM ZREPORT_M_KOTA WHERE KD_PROP = '$kd_prov'");
        return $data->result_array();
    }

    function getProvinsi($kd_prov) {
        $data = $this->db->query("SELECT NM_PROV FROM ZREPORT_M_PROVINSI WHERE KD_PROV = '$kd_prov'");
        return $data->row_array();
    }

    /*
     * Ambil data price 
     */
    function dataprice($bulan_fil, $tahun_fil) {
//        $bulan = date('m');
//        $tahun = date('Y');
        return $this->db->query("SELECT
	ZREPORT_M_PROVINSI.NM_PROV,
	ZREPORT_M_KOTA.NM_KOTA,
        ZREPORT_MS_PERUSAHAAN.PRODUK,
	SCM_MI_PRICE_SURVEY.*
FROM
	ZREPORT_M_PROVINSI,
	ZREPORT_M_KOTA,
	SCM_MI_PRICE_SURVEY,
        ZREPORT_MS_PERUSAHAAN
WHERE
SCM_MI_PRICE_SURVEY.KD_PROV=ZREPORT_M_PROVINSI.KD_PROV
AND
SCM_MI_PRICE_SURVEY.KD_KOTA=ZREPORT_M_KOTA.KD_KOTA
AND
SCM_MI_PRICE_SURVEY.KD_PERUSAHAAN=ZREPORT_MS_PERUSAHAAN.KODE_PERUSAHAAN
AND
SCM_MI_PRICE_SURVEY.BULAN='$bulan_fil'
AND
SCM_MI_PRICE_SURVEY.TAHUN='$tahun_fil'
")->result_array();
    }
    // query view data price per id
    function price_get_by_id($id) {
        $query = $this->db->query("SELECT
	ZREPORT_M_PROVINSI.NM_PROV,
	ZREPORT_M_KOTA.NM_KOTA,
        ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN,
	SCM_MI_PRICE_SURVEY.*
FROM
	ZREPORT_M_PROVINSI,
	ZREPORT_M_KOTA,
	SCM_MI_PRICE_SURVEY,
        ZREPORT_MS_PERUSAHAAN
WHERE
SCM_MI_PRICE_SURVEY.KD_PROV=ZREPORT_M_PROVINSI.KD_PROV
AND
SCM_MI_PRICE_SURVEY.KD_KOTA=ZREPORT_M_KOTA.KD_KOTA
AND
SCM_MI_PRICE_SURVEY.KD_PERUSAHAAN=ZREPORT_MS_PERUSAHAAN.KODE_PERUSAHAAN 
AND
SCM_MI_PRICE_SURVEY.ID='$id'");
        return $query->row();
    }
    // query delete price
    function price_delete($id) {

        $this->db->where("ID", $id);
        $this->db->delete("SCM_MI_PRICE_SURVEY");
    }

    /*
     * query data provinsi
     */

    function dataProv() {
        $data = $this->db->query("SELECT KD_PROV, NM_PROV FROM ZREPORT_M_PROVINSI WHERE KD_PROV != '0001' AND KD_PROV != '1092' order by NM_PROV");
        return $data->result_array();
    }

    /*
     * query data kota
     */

    function dataKota() {
        $data = $this->db->query("SELECT KD_KOTA, NM_KOTA FROM ZREPORT_M_KOTA order by NM_KOTA");
        return $data->result_array();
    }
    // query data kota per prov
    function cek_kota($prov) {
        $lihat = $this->db->query("SELECT
                                    ZREPORT_M_KOTA.KD_KOTA,
                                    ZREPORT_M_KOTA.NM_KOTA,
                                    ZREPORT_M_PROVINSI.NM_PROV,
                                    ZREPORT_M_PROVINSI.KD_PROV,
                                    ZREPORT_M_KOTA.KD_PROP
                                FROM
                                    ZREPORT_M_KOTA,
                                    ZREPORT_M_PROVINSI
                                WHERE
                                    ZREPORT_M_KOTA.KD_PROP = ZREPORT_M_PROVINSI.KD_PROV
                                    AND ZREPORT_M_PROVINSI.KD_PROV != '0001'
                                    AND ZREPORT_M_PROVINSI.KD_PROV != '1092'
                                    AND ZREPORT_M_PROVINSI.KD_PROV='" . $prov . "'");
        return $lihat->result_array();
    }
    // update price
    function update_price($data) {
        $ID = $data['ID'];
        $HARGA_TEBUS = $data['HARGA_TEBUS'];
        $HARGA_JUAL = $data['HARGA_JUAL'];
        $UPDATE_BY = $data['UPDATE_BY'];
        $save = $this->db->query("update SCM_MI_PRICE_SURVEY set HARGA_TEBUS='$HARGA_TEBUS', HARGA_JUAL='$HARGA_JUAL', UPDATE_BY='$UPDATE_BY', UPDATE_DATE=SYSDATE WHERE ID=$ID ");
        return $save;
    }
    // query export excel data price
    function downloadDataPrice($kd_prov, $kd_kota, $tahun, $bulan) {
        $kota = '';
        if ($kd_kota != 0) {
            $kota = "AND TB3.KD_KOTA = '$kd_kota'";
        }
        $prov = '';
        if ($kd_prov != 0) {
            $prov = "AND TB2.KD_PROV = '$kd_prov'";
        }
        $andTahun = '';
        if ($tahun != 0) {
            $andTahun = "AND TB1.TAHUN = '$tahun'";
        }
        $andBulan = '';
        if ($bulan != 0) {
            $andBulan = "AND TB1.BULAN = '$bulan'";
        }
        $data = $this->db->query("SELECT
                                        TB2.NM_PROV,
                                        TB3.NM_KOTA,
                                        TB4.PRODUK,
                                        TB1.KD_PERUSAHAAN,
                                        TB1.TAHUN,
                                        TB1.BULAN,
                                        TB1.HARI,
                                        TB1.HARGA_JUAL,
                                        TB1.HARGA_TEBUS,
                                        TB1.TIPE
                                FROM
                                        SCM_MI_PRICE_SURVEY TB1
                                LEFT JOIN ZREPORT_M_PROVINSI TB2 ON TB1.KD_PROV = TB2.KD_PROV
                                LEFT JOIN ZREPORT_M_KOTA TB3 ON TB1.KD_KOTA = TB3.KD_KOTA
                                LEFT JOIN ZREPORT_MS_PERUSAHAAN TB4 ON TB1.KD_PERUSAHAAN = TB4.KODE_PERUSAHAAN
                                WHERE
                                        TB1.KD_PROV IS NOT null
                                    $andBulan
                                    $andTahun
                                    $prov
                                    $kota
                                ORDER BY
                                        TB1.KD_PERUSAHAAN,
                                        TB1.TIPE");
//        echo $this->db->last_query();
        return $data->result_array();
    }

}
