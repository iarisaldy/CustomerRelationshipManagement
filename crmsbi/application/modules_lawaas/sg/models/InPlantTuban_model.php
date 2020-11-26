<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access allowed');

class InPlantTuban_model extends CI_Model {

    private $db2;

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db2 = $this->load->database('scmproduction', TRUE);
    }

    function sql_stok() {
        $data = $this->db2->query("select KD_GDG,LT,KD_DISTR from CRM_GUDANG where LT is null");
        return $data->result_array();
    }

    function tonaseOverall() {
        $data = $this->db->query("SELECT COUNT(NO_TRANSAKSI) COUNTER, sum(KWANTUMX) jumlahx, TIPE_TRUK,ORDER_TYPE,KODE_DA
		FROM ZREPORT_RPT_REAL WHERE (SELECT TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\" 
		FROM DUAL) = TO_CHAR(TGL_SPJ, 'DD-MM-YYYY') AND COM=7000 
		AND PLANT=7403  GROUP BY TIPE_TRUK,ORDER_TYPE,KODE_DA");
        return $data->result_array();
    }

    function avgOverall() {
        $data = $this->db->query("SELECT ROUND((avg(TGL_ISI - TGL_ANTRI)*24*60),2) AVERAGE, 'BAG' tipe_truk 
				from ZREPORT_RPT_REAL 
				where (SELECT TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\" FROM DUAL) = TO_CHAR(TGL_SPJ, 'DD-MM-YYYY')
				AND COM=7000 AND PLANT=7403 and tipe_truk between 107 and 307
				union 
				SELECT ROUND((avg(TGL_ISI - TGL_ANTRI)*24*60),2) AVERAGE, 'BULK' tipe_truk 
				from ZREPORT_RPT_REAL 
				where (SELECT TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\" FROM DUAL) = TO_CHAR(TGL_SPJ, 'DD-MM-YYYY')
				AND COM=7000 AND PLANT=7403 and kode_da not like '0000007%' and tipe_truk=308");
        return $data->result_array();
    }

    function avgcargo() {
        $data = $this->db->query("SELECT  ROUND(AVG(selisih),2) AVERAGE, 'BAG' tipe_truck
                FROM (SELECT DISTINCT(NO_POLISI), ((sysdate - TGL_ANTRI)*24*60) selisih
		FROM ZREPORT_RPT_REAL_NON70 
		WHERE STATUS<=40 AND STATUS>=10 AND DATE_CVY IS NULL  and tipe_truk between 107 and 307 
		AND COM='7000' AND PLANT='7403')
                UNION
                SELECT  ROUND(AVG(selisih),2) AVERAGE, 'BULK' tipe_truck
                FROM (SELECT DISTINCT(NO_POLISI), ((sysdate - TGL_ANTRI)*24*60) selisih
		FROM ZREPORT_RPT_REAL_NON70 
		WHERE STATUS<=40 AND STATUS>=10 AND DATE_CVY IS NULL  and tipe_truk=308 
		AND COM='7000' AND PLANT='7403')
                ");
        return $data->result();
    }

    function cntcargo() {
        $data = $this->db->query("SELECT COUNT(DISTINCT(NO_POLISI)) JUML_TRUCK, 301 tipe_truck
		FROM ZREPORT_RPT_REAL_NON70 
		WHERE STATUS<=40 AND STATUS>=10 AND DATE_CVY IS NULL  and tipe_truk between 107 and 307 
		AND COM='7000' AND PLANT='7403'
                UNION 
                SELECT COUNT(DISTINCT(NO_POLISI)) JUML_TRUCK, 308 tipe_truck
		FROM ZREPORT_RPT_REAL_NON70 
		WHERE STATUS<=40 AND STATUS>=10 AND DATE_CVY IS NULL  and tipe_truk=308 
		AND COM='7000' AND PLANT='7403'
                ");
        return $data->result();
    }

    function avgtmbgn() {
        $data = $this->db->query("SELECT ROUND((avg(sysdate - DATE_CVY)*24*60),2) AVERAGE, 301 tipe_truk 
		from ZREPORT_RPT_REAL_NON70 where date_cvy is not null and status=40 
		AND COM='7000' AND PLANT='7403'  and tipe_truk between 107 and 307
                UNION 
                SELECT ROUND((avg(sysdate - DATE_CVY)*24*60),2) AVERAGE, 308 tipe_truk 
                from ZREPORT_RPT_REAL_NON70 where date_cvy is not null and status=40 
		AND COM='7000' AND PLANT='7403' and tipe_truk=308
                ");
        return $data->result();
    }

    function cnttmbgn() {
        $data = $this->db->query("SELECT COUNT(DISTINCT(NO_POLISI)) JUML_TRUCK, 301 tipe_truck
		FROM ZREPORT_RPT_REAL_NON70 WHERE STATUS=40 AND DATE_CVY IS NOT NULL 
		AND COM='7000' AND PLANT='7403' and kode_da not like '0000007%' and tipe_truk between 107 and 307
                UNION
                SELECT COUNT(DISTINCT(NO_POLISI)) JUML_TRUCK, 308 tipe_truck
		FROM ZREPORT_RPT_REAL_NON70 WHERE STATUS=40 AND DATE_CVY IS NOT NULL 
		AND COM='7000' AND PLANT='7403' and tipe_truk=308
                ");
        return $data->result();
    }

    function detailBagCargo() {
        $data = $this->db->query("SELECT tanggal,status, nama_sopir,
                jam_mulai,durasi, no_polisi, nama_expeditur, tipe_truk,nm_kota,sum(KWANTUMX) kwantumx 
                FROM(SELECT kwantumx,nm_kota,tgl_antri AS tanggal, ZREPORT_RPT_REAL_NON70.status, nama_sopir, 
                TO_CHAR(tgl_antri, 'HH24:MI') jam_mulai, ROUND((sysdate - tgl_antri)*24*60,2)durasi, no_polisi, nama_expeditur, tipe_truk 
          	FROM ZREPORT_RPT_REAL_NON70 WHERE STATUS<=40 AND STATUS>=10 AND DATE_CVY IS NULL AND COM=7000 AND PLANT=7403 
                and tipe_truk between 107 and 307 )group by tanggal,status, nama_sopir,
                jam_mulai,durasi, no_polisi, nama_expeditur, tipe_truk,nm_kota");
        return $data->result();
    }

    function detailBulkCargo() {
        $data = $this->db->query("SELECT tanggal,status, nama_sopir,
                jam_mulai,durasi, no_polisi, nama_expeditur, tipe_truk,nm_kota,sum(KWANTUMX) kwantumx 
                FROM(SELECT kwantumx,nm_kota,tgl_antri AS tanggal, ZREPORT_RPT_REAL_NON70.status, nama_sopir, 
                TO_CHAR(tgl_antri, 'HH24:MI') jam_mulai, ROUND((sysdate - tgl_antri)*24*60,2) durasi, no_polisi, nama_expeditur, tipe_truk 
          	FROM ZREPORT_RPT_REAL_NON70 WHERE STATUS<=40 AND STATUS>=10 AND DATE_CVY IS NULL AND COM=7000 AND PLANT=7403 
                and tipe_truk=308)group by tanggal,status, nama_sopir,
                jam_mulai,durasi, no_polisi, nama_expeditur, tipe_truk,nm_kota");
        return $data->result();
    }

    function detailBagTmbgn() {
        $data = $this->db->query("SELECT tanggal,status, nama_sopir,
                jam_mulai,durasi, no_polisi, nama_expeditur, tipe_truk,nm_kota,sum(KWANTUMX) kwantumx 
                FROM(SELECT kwantumx,nm_kota,date_cvy AS tanggal,nama_sopir, ZREPORT_RPT_REAL_NON70.status, 
                TO_CHAR(date_cvy, 'HH24:MI') jam_mulai, (sysdate - date_cvy)*24*60 durasi, no_polisi, nama_expeditur, tipe_truk 
                FROM ZREPORT_RPT_REAL_NON70 WHERE STATUS=40 AND DATE_CVY IS NOT NULL AND COM=7000 AND PLANT=7403 
                and tipe_truk between 107 and 307)group by tanggal,status, nama_sopir,
                jam_mulai,durasi, no_polisi, nama_expeditur, tipe_truk,nm_kota");
        return $data->result();
    }

    function detailBulkTmbgn() {
        $data = $this->db->query("SELECT tanggal,status, nama_sopir,
                jam_mulai,durasi, no_polisi, nama_expeditur, tipe_truk,nm_kota,sum(KWANTUMX) kwantumx 
                FROM(SELECT kwantumx,nm_kota,date_cvy AS tanggal,nama_sopir, ZREPORT_RPT_REAL_NON70.status, 
                TO_CHAR(date_cvy, 'HH24:MI') jam_mulai, (sysdate - date_cvy)*24*60 durasi, no_polisi, nama_expeditur, tipe_truk 
                FROM ZREPORT_RPT_REAL_NON70 WHERE STATUS=40 AND DATE_CVY IS NOT NULL AND COM=7000 AND PLANT=7403 
                and tipe_truk=308)group by tanggal,status, nama_sopir,
                jam_mulai,durasi, no_polisi, nama_expeditur, tipe_truk,nm_kota");

        return $data->result();
    }

    function overall() {
        $data = $this->db->query("SELECT ROUND(SUM(CASE WHEN TIPE_TRUK>=107 and TIPE_TRUK<308 THEN ((TGL_ISI - TGL_ANTRI)*24*60) ELSE 0 END)/
                SUM(CASE WHEN TIPE_TRUK>=107 and TIPE_TRUK<308 THEN 1 ELSE 0 END),2) AS BAG_AVG,
                ROUND(SUM(CASE WHEN kode_da not like '0000007%' and TIPE_TRUK=308 THEN ((TGL_ISI - TGL_ANTRI)*24*60) ELSE 0 END)/
                SUM(CASE WHEN kode_da not like '0000007%' and TIPE_TRUK=308 THEN 1 ELSE 0 END),2) AS BULK_AVG,
                ROUND(SUM(CASE WHEN ORDER_TYPE!='ZNL' and TIPE_TRUK>=107 and TIPE_TRUK<308 THEN KWANTUMX ELSE 0 END),0) AS Dist_DA,
                ROUND(SUM(CASE WHEN TIPE_TRUK>=107 and TIPE_TRUK<308 and ORDER_TYPE='ZNL' THEN KWANTUMX ELSE 0 END),0) AS bag_sg,
                ROUND(SUM(CASE WHEN TIPE_TRUK>=107 and TIPE_TRUK<308 THEN KWANTUMX ELSE 0 END),0) AS bag_sub_total,
                ROUND(SUM(CASE WHEN TIPE_TRUK>=308 and ORDER_TYPE='ZNL' THEN KWANTUMX ELSE 0 END),0) AS bulk_port,
                ROUND(SUM(CASE WHEN TIPE_TRUK>=308 and (ORDER_TYPE='ZLF' OR ORDER_TYPE='ZLFP') THEN KWANTUMX ELSE 0 END),0) AS bulk_lokal,
                ROUND(SUM(CASE WHEN TIPE_TRUK>=308 THEN KWANTUMX ELSE 0 END),0) AS bulk_sub_total,
                ROUND(sum(KWANTUMX),0) TOTAL
		FROM ZREPORT_RPT_REAL WHERE (SELECT TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\" FROM DUAL) = TO_CHAR(TGL_SPJ, 'DD-MM-YYYY') 
                AND COM=7000 AND PLANT=7403");
        return $data->result();
    }

    function avgpbrk() {
        $data = $this->db->query("SELECT PABRIK, MATNR, ROUND((avg(sysdate - TGL_MASUK)*24*60),2) 
		AVERAGE FROM (   
                SELECT CVY.PABRIK, SUBSTR(CVY.MATNR,5,3) MATNR,rel.TGL_ISI,rel.TGL_MASUK, rel.NO_TRANSAKSI 
                FROM zreport_rpt_real_non70 rel JOIN ZREPORT_M_CVY_MAT CVY ON REL.LSTEL = CVY.LINE_BOOMER 
                WHERE rel.COM='7000' AND rel.PLANT='7403' AND CVY.PABRIK is not null and rel.status = 50 
                and rel.kode_da not like '0000007%') GROUP BY PABRIK, MATNR");
        return $data->result();
    }

    function cntpbrk() {
        $data = $this->db->query("SELECT STATUS,PABRIK,LSTEL,MATNR,LINE_BOOMER,SUM(COUNTER) COUNTER ,DESKRIPSI
		FROM(SELECT CVY.STATUS,CVY.PABRIK,CVY.LINE_BOOMER LSTEL, SUBSTR(CVY.MATNR,5,3) MATNR, COUNTER,CVY.LINE_BOOMER ,DESKRIPSI
		FROM (SELECT PABRIK, LSTEL, MATNR, SUM(COUNTER) COUNTER,NAMA_SOPIR,NAMA_EXPEDITUR,NO_POLISI,NM_KOTA ,DESKRIPSI 
			from(SELECT PABRIK, LSTEL, MATNR, 1 COUNTER,NAMA_SOPIR,NAMA_EXPEDITUR,NO_POLISI,NM_KOTA ,DESKRIPSI 
				FROM(SELECT LSTEL, PABRIK, SUBSTR(MATNR,5,3) MATNR, NO_TRANSAKSI,NAMA_SOPIR,NAMA_EXPEDITUR,NO_POLISI,NM_KOTA,cvy.DESC2  DESKRIPSI 
					FROM ZREPORT_RPT_REAL_NON70 REL JOIN ZREPORT_M_CVY_MAT CVY ON REL.LSTEL = CVY.LINE_BOOMER 
					WHERE COM=7000 AND PLANT=7403 AND PABRIK IS NOT NULL AND REL.STATUS=50 and kode_da not like '0000007%') 
		GROUP BY PABRIK, LSTEL, MATNR,NAMA_SOPIR,NAMA_EXPEDITUR,NO_POLISI,NM_KOTA,DESKRIPSI ) 
		GROUP BY PABRIK, LSTEL, MATNR,NM_KOTA,NAMA_SOPIR,NAMA_EXPEDITUR,NO_POLISI,DESKRIPSI ) A
		RIGHT JOIN ZREPORT_M_CVY_MAT CVY
		ON CVY.LINE_BOOMER=A.LSTEL WHERE CVY.PABRIK
		IS NOT NULL)
		GROUP BY STATUS,PABRIK,LSTEL,MATNR,LINE_BOOMER,DESKRIPSI  
		ORDER BY LSTEL");
        return $data->result();
    }

    function detailConveyor($tipe) {
        $data = $this->db->query("SELECT PABRIK, LSTEL, MATNR, STATUS,TANGGAL,NAMA_SOPIR,JAM_MULAI,DURASI,NO_POLISI,NAMA_EXPEDITUR,NM_KOTA,sum(KWANTUMX) kwantumx
		FROM(SELECT PABRIK, LSTEL, MATNR, STATUS, date_cvy AS tanggal, nama_sopir, TO_CHAR(date_cvy, 'HH24:MI') jam_mulai,
		(sysdate - date_cvy)*24*60 durasi, no_polisi, nama_expeditur,nm_kota,kwantumx
		from(SELECT PABRIK, LSTEL, MATNR,date_cvy, no_polisi, nama_expeditur,nama_sopir,status,kwantumx,nm_kota 
		FROM(SELECT rel.status,nama_sopir,LSTEL, PABRIK, SUBSTR(MATNR,1,7) MATNR, NO_TRANSAKSI,date_cvy, no_polisi
		,nama_expeditur,kwantumx,nm_kota FROM ZREPORT_RPT_REAL_NON70
		REL JOIN ZREPORT_M_CVY_MAT CVY ON REL.LSTEL = CVY.LINE_BOOMER WHERE COM=7000 AND PLANT=7403 AND PABRIK
		IS NOT NULL AND REL.STATUS=50 and LSTEL=$tipe and kode_da not like '0000007%')))
		GROUP BY PABRIK, LSTEL, MATNR, STATUS,TANGGAL,NAMA_SOPIR,JAM_MULAI,DURASI,NO_POLISI,NAMA_EXPEDITUR,NM_KOTA");
        return $data->result();
    }

    function detailBagTonase() {
        $data = $this->db->query("SELECT ITEM_NO, UOM, PRODUK, SUM(KWANTUM) KWANTUM, SUM(KWANTUMX) KWANTUMX,'ZNL' ORDER_TYPE FROM ZREPORT_RPT_REAL 
		WHERE (SELECT TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\" FROM DUAL) = TO_CHAR(TGL_SPJ, 'DD-MM-YYYY') AND COM=7000 AND PLANT=7403 
		AND TIPE_TRUK between 107 and 307 and ORDER_TYPE='ZNL'
		GROUP BY ITEM_NO, PRODUK, UOM
		UNION
		SELECT ITEM_NO, UOM, PRODUK, SUM(KWANTUM) KWANTUM, SUM(KWANTUMX) KWANTUMX,'ZLF' ORDER_TYPE FROM ZREPORT_RPT_REAL 
		WHERE (SELECT TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\" FROM DUAL) = TO_CHAR(TGL_SPJ, 'DD-MM-YYYY') AND COM=7000 AND PLANT=7403 
		AND TIPE_TRUK between 107 and 307 and ORDER_TYPE!='ZNL'
		GROUP BY ITEM_NO, PRODUK, UOM");
        return $data->result();
    }

    function detailBulkTonase() {
        $data = $this->db->query("SELECT ITEM_NO, UOM, PRODUK, SUM(KWANTUM) KWANTUM, SUM(KWANTUMX) KWANTUMX,'ZNL' ORDER_TYPE
		FROM ZREPORT_RPT_REAL 
		WHERE (SELECT TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\" FROM DUAL) = TO_CHAR(TGL_SPJ, 'DD-MM-YYYY') 
		AND COM=7000 AND PLANT=7403 AND TIPE_TRUK=308 and ORDER_TYPE='ZNL'
		GROUP BY ITEM_NO, PRODUK, UOM
		UNION
		SELECT ITEM_NO, UOM, PRODUK, SUM(KWANTUM) KWANTUM, SUM(KWANTUMX) KWANTUMX,'ZLF' ORDER_TYPE
		FROM ZREPORT_RPT_REAL 
		WHERE (SELECT TO_CHAR (SYSDATE, 'DD-MM-YYYY') \"NOW\" FROM DUAL) = TO_CHAR(TGL_SPJ, 'DD-MM-YYYY') 
		AND COM=7000 AND PLANT=7403 AND TIPE_TRUK=308 and ORDER_TYPE!='ZNL'
		GROUP BY ITEM_NO, PRODUK, UOM");
        return $data->result();
    }

    function waktuUpdate() {
        $data = $this->db->query("SELECT TO_CHAR(MAX(TGL_LAST_UPDATE),'DD-MM-YYYY HH24:MI:SS') as waktu_update
			FROM ZREPORT_RPT_REAL");
        return $data->result();
    }

    function grafRataBag($posisi, $bulan, $tahun) {
        $data = $this->db->query("SELECT TO_CHAR(tgl_antri, 'dd') TANGGAL, $posisi
					FROM ZREPORT_RPT_REAL
					WHERE COM=7000 AND PLANT=7403 and tipe_truk between 107 and 307 and DATE_CVY is not null and kode_da not like '0000007%'
					AND TO_CHAR(tgl_antri, 'MM') = $bulan AND TO_CHAR(tgl_antri, 'YYYY') = $tahun
					GROUP BY TO_CHAR(tgl_antri, 'dd') order by TO_CHAR(tgl_antri, 'dd') asc");
        return $data->result_array();
    }

    function grafRataBulk($posisi, $bulan, $tahun) {
        $data = $this->db->query("SELECT TO_CHAR(tgl_antri, 'dd') TANGGAL, $posisi
					FROM ZREPORT_RPT_REAL
					WHERE COM=7000 AND PLANT=7403 and tipe_truk=308 and DATE_CVY is not null and kode_da not like '0000007%'
					AND TO_CHAR(tgl_antri, 'MM') = $bulan AND TO_CHAR(tgl_antri, 'YYYY') = $tahun
					GROUP BY TO_CHAR(tgl_antri, 'dd') order by TO_CHAR(tgl_antri, 'dd') asc");
        return $data->result_array();
    }

    function grafXpBag($posisi, $bulan, $tahun) {
        $data = $this->db->query("SELECT b.NO_EXPEDITUR, ZREPORT_M_EXPEDITUR.NAMA_EXPEDITUR, b.AVERAGE from
                                        (SELECT NO_EXPEDITUR, $posisi
					FROM ZREPORT_RPT_REAL
					WHERE COM=7000 AND PLANT=7403 and tipe_truk between 107 and 307 and DATE_CVY is not null and kode_da not like '0000007%'
					AND TO_CHAR(tgl_antri, 'MM') = $bulan AND TO_CHAR(tgl_antri, 'YYYY') = $tahun
					GROUP BY NO_EXPEDITUR order by average desc
                                        ) b
                                        LEFT JOIN ZREPORT_M_EXPEDITUR
                                        ON b.NO_EXPEDITUR = ZREPORT_M_EXPEDITUR.KODE_EXPEDITUR
                                        where rownum <=10");
        return $data->result_array();
    }

    function grafXpBulk($posisi, $bulan, $tahun) {
        $data = $this->db->query("SELECT NO_EXPEDITUR, ZREPORT_M_EXPEDITUR.NAMA_EXPEDITUR, AVERAGE from
                                        (SELECT NO_EXPEDITUR, $posisi
                                        FROM ZREPORT_RPT_REAL
                                        WHERE COM=7000 AND PLANT=7403 and tipe_truk=308 and DATE_CVY is not null and kode_da not like '0000007%'
                                        AND TO_CHAR(tgl_antri, 'MM') = $bulan AND TO_CHAR(tgl_antri, 'YYYY') = $tahun
                                        GROUP BY NO_EXPEDITUR order by average desc
                                        ) b
                                        LEFT JOIN ZREPORT_M_EXPEDITUR
                                        ON b.NO_EXPEDITUR = ZREPORT_M_EXPEDITUR.KODE_EXPEDITUR
                                        where rownum <=10");
        return $data->result_array();
    }

    function coba() {
        $data = $this->db->query("SELECT DISTINCT(NO_POLISI), ((sysdate - TGL_ANTRI)*24*60) selisih, tipe_truk
		FROM ZREPORT_RPT_REAL_NON70 
		WHERE STATUS<=40 AND STATUS>=10 AND DATE_CVY IS NULL and tipe_truk between 107 and 308
		AND COM='7000' AND PLANT='7403'");
        return $data->result_array();
    }

    function sisaSO(){
        $data = $this->db->query("SELECT TB1.NMORG, NVL(TB1.SISA_BAG,0) SISA_BAG, NVL(TB2.SISA_BULK,0) SISA_BULK FROM (SELECT NMORG, SUM(SISA_TO) SISA_BAG
                FROM ZREPORT_SO_BUFFER
                WHERE NMORG = '7000' AND ITEM_NO LIKE '121-301%' AND NMPLAN = '7403'
                GROUP BY NMORG) TB1
                LEFT JOIN (
                  SELECT NMORG, SUM(SISA_TO) SISA_BULK
                  FROM ZREPORT_SO_BUFFER
                  WHERE NMORG = '7000' AND ITEM_NO LIKE '121-302%' AND NMPLAN = '7403'
                  GROUP BY NMORG
                ) TB2
                ON TB1.NMORG = TB2.NMORG");
        return $data->result_array();
    }
}
