<?php

class M_pmb_dashboard Extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db_3pl = $this->load->database('3pl', TRUE);
		$this->db_scm = $this->load->database('SCM', TRUE);
		$this->db_point = $this->load->database('Point', TRUE);
		
	}
	
	public function get_dist($s, $p, $e, $c, $o)
	{
		$ep = $p == 0 ? $e + $p : ($e + $p)-1;
		$q1 = $this->db->query("SELECT KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR FROM CRMNEW_DISTRIBUTOR WHERE DELETE_MARK = 0")->num_rows();
		// $r1 = isset($q1[0]["TOTAL"]) ? $q1[0]["TOTAL"] : 0;
		
		$q2 = $this->db->query("SELECT KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR FROM CRMNEW_DISTRIBUTOR WHERE DELETE_MARK = 0 AND (NAMA_DISTRIBUTOR LIKE '%{$s}%' OR KODE_DISTRIBUTOR LIKE '%{$s}%')")->num_rows();
		// $r2 = isset($q2[0]["FILTERED"]) ? $q2[0]["FILTERED"] : 0;
		
		$q3 = $this->db->query("		 
				SELECT * FROM (
				SELECT a.*, ROWNUM rnum FROM (
					SELECT KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR FROM CRMNEW_DISTRIBUTOR WHERE DELETE_MARK = 0 AND (NAMA_DISTRIBUTOR LIKE '%{$s}%' OR KODE_DISTRIBUTOR LIKE '%{$s}%') ORDER BY {$o[0]} {$o[1]}
				) a WHERE ROWNUM <= {$ep}
				) WHERE rnum >= {$p}
			");
		$r3 = $q3 ? $q3->result_array() : array();
		
		return array(
			"total"		=> $q1,
			"filtered"	=> $q2,
			"data"		=> $r3
		);
	}
	
	public function get_data_dist()
	{
		// SELECT NM_DISTRIBUTOR, SUM(HARGA_SELL_OUT) AS REVENUE, SUM(QTY_SELL_OUT) AS VOLUME, SUM(ZAK_KG) AS KG FROM V_SELL_OUT_TO_CRM GROUP BY NM_DISTRIBUTOR
		$q = $this->db_scm->query("		 
				SELECT SOLD_TO AS KODE_DISTRIBUTOR, SUM(HARGA) AS REVENUE, SUM(KWANTUMX) AS VOLUME FROM ZREPORT_SCM_REAL_SALES_SIDIGI GROUP BY SOLD_TO
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function get_data_dist_so()
	{
		// SELECT NM_DISTRIBUTOR, SUM(HARGA_SELL_OUT) AS REVENUE, SUM(QTY_SELL_OUT) AS VOLUME, SUM(ZAK_KG) AS KG FROM V_SELL_OUT_TO_CRM GROUP BY NM_DISTRIBUTOR
		$q = $this->db_scm->query("		 
				SELECT SOLD_TO AS KODE_DISTRIBUTOR, SUM(SISA_TO) AS JUMLAH FROM ZREPORT_SO_CNC GROUP BY SOLD_TO
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function get_data_dist_ta($bln, $tahun)
	{
		// SELECT NM_DISTRIBUTOR, SUM(HARGA_SELL_OUT) AS REVENUE, SUM(QTY_SELL_OUT) AS VOLUME, SUM(ZAK_KG) AS KG FROM V_SELL_OUT_TO_CRM GROUP BY NM_DISTRIBUTOR
		$q = $this->db_point->query("		 
				SELECT KD_DISTRIBUTOR AS KODE_DISTRIBUTOR, COUNT(DISTINCT KD_CUSTOMER) AS JUMLAH, SUM(JML_POIN) AS POIN FROM POIN_PENJUALAN WHERE BULAN = {$bln} AND TAHUN = {$tahun} GROUP BY KD_DISTRIBUTOR
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function get_data_dist_tu($bln, $tahun)
	{
		$cur_month = date("m");
		$bln_beg = date("m", strtotime("-6 months"));
		$last_year = intval($tahun) - 1;
		$between = $cur_month < $bln_beg ? "WHERE ( BULAN > {$bln_beg} AND TAHUN = {$last_year} ) OR ( BULAN <= {$bln} AND TAHUN = {$tahun} )" : "WHERE BULAN > {$bln_beg} AND BULAN <= {$bln}  AND TAHUN = {$tahun}";
		// SELECT NM_DISTRIBUTOR, SUM(HARGA_SELL_OUT) AS REVENUE, SUM(QTY_SELL_OUT) AS VOLUME, SUM(ZAK_KG) AS KG FROM V_SELL_OUT_TO_CRM GROUP BY NM_DISTRIBUTOR
		$q = $this->db_point->query("		 
				SELECT KD_DISTRIBUTOR AS KODE_DISTRIBUTOR, COUNT(DISTINCT KD_CUSTOMER) AS JUMLAH FROM POIN_PENJUALAN {$between} GROUP BY KD_DISTRIBUTOR
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function get_data_dist_tb()
	{
		// SELECT NM_DISTRIBUTOR, SUM(HARGA_SELL_OUT) AS REVENUE, SUM(QTY_SELL_OUT) AS VOLUME, SUM(ZAK_KG) AS KG FROM V_SELL_OUT_TO_CRM GROUP BY NM_DISTRIBUTOR
		$q = $this->db_point->query("		 
				SELECT NOMOR_DISTRIBUTOR AS KODE_DISTRIBUTOR, COUNT(*) AS JUMLAH FROM VIEW_M_CUSTOMER OFFSET where TO_DATE(AKUISISI_DATE, 'dd-MM-yyyy') >= TRUNC(SYSDATE) - 30 GROUP BY NOMOR_DISTRIBUTOR
			");
		return $r = $q ? $q->result_array() : array();
	}
	public function get_data_dist_target()
	{
		$q = $this->db->query("		 
				SELECT * FROM CRMNEW_TARGET_SELLING_OUT_D WHERE DELETED_MARK = '0'
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function get_sales($s, $p, $e, $c, $o)
	{
		$ep = $p == 0 ? $e + $p : ($e + $p)-1;
		$q1 = $this->db->query("SELECT SD.*, U.USERNAME FROM SALES_DISTRIBUTOR SD LEFT JOIN CRMNEW_USER U ON SD.ID_SALES = U.ID_USER WHERE U.DELETED_MARK = 0")->num_rows();
		// $r1 = isset($q1[0]["TOTAL"]) ? $q1[0]["TOTAL"] : 0;
		
		$q2 = $this->db->query("SELECT SD.*, U.USERNAME FROM SALES_DISTRIBUTOR SD LEFT JOIN CRMNEW_USER U ON SD.ID_SALES = U.ID_USER WHERE U.DELETED_MARK = 0 AND (SD.ID_SALES LIKE '%{$s}%' OR U.USERNAME LIKE '%{$s}%')")->num_rows();
		// $r2 = isset($q2[0]["FILTERED"]) ? $q2[0]["FILTERED"] : 0;
		
		$q3 = $this->db->query("		 
				SELECT * FROM (
				SELECT a.*, ROWNUM rnum FROM (
					SELECT SD.*, U.USERNAME FROM SALES_DISTRIBUTOR SD LEFT JOIN CRMNEW_USER U ON SD.ID_SALES = U.ID_USER WHERE U.DELETED_MARK = 0 AND (SD.ID_SALES LIKE '%{$s}%' OR U.USERNAME LIKE '%{$s}%') ORDER BY {$o[0]} {$o[1]}
				) a WHERE ROWNUM <= {$ep}
				) WHERE rnum >= {$p}
			");
		$r3 = $q3 ? $q3->result_array() : array();
		
		return array(
			"total"		=> $q1,
			"filtered"	=> $q2,
			"data"		=> $r3
		);
	}
	
	public function get_data_sales_visit()
	{
		// SELECT NM_DISTRIBUTOR, SUM(HARGA_SELL_OUT) AS REVENUE, SUM(QTY_SELL_OUT) AS VOLUME, SUM(ZAK_KG) AS KG FROM V_SELL_OUT_TO_CRM GROUP BY NM_DISTRIBUTOR
		$q = $this->db->query("		 
				SELECT ID_SALES, SUM(REALISASI) AS JUMLAH, SUM(TARGET) AS TARGET FROM VISIT_SALES_DISTRIBUTOR GROUP BY ID_SALES
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function get_data_sales_kc()
	{
		// SELECT NM_DISTRIBUTOR, SUM(HARGA_SELL_OUT) AS REVENUE, SUM(QTY_SELL_OUT) AS VOLUME, SUM(ZAK_KG) AS KG FROM V_SELL_OUT_TO_CRM GROUP BY NM_DISTRIBUTOR
		$q = $this->db_scm->query("		 
				SELECT SOLD_TO AS KODE_DISTRIBUTOR, SUM(HARGA) AS REVENUE, SUM(KWANTUM * KWANTUMX) AS VOLUME FROM ZREPORT_SCM_REAL_SALES_SIDIGI GROUP BY SOLD_TO
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function get_data_sales_target()
	{
		$q = $this->db->query("		 
				SELECT * FROM CRMNEW_TARGET_SELLING_OUT_S WHERE DELETED_MARK = '0'
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function getDist($id_jenis_user){
		$sqlCekAtas = "";
		if($id_jenis_user == 1010){
			$sqlCekAtas = ",(SELECT ID_GSM FROM SO_TOPDOWN_RSM WHERE ID_RSM = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		} else if ($id_jenis_user == 1011){
			$sqlCekAtas = ",(SELECT ID_RSM FROM SO_TOPDOWN_ASM WHERE ID_ASM = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		} else if ($id_jenis_user == 1012){
			$sqlCekAtas = ",(SELECT ID_ASM FROM SO_TOPDOWN_TSO WHERE ID_TSO = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		} else if ($id_jenis_user == 1015){
			$sqlCekAtas = ",(SELECT ID_TSO FROM SO_TOPDOWN_SALES WHERE ID_USER = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		}
		
		// $sql = "
			// SELECT  
				// CU.ID_USER, CU.NAMA, CU.ID_JENIS_USER
			// FROM CRMNEW_USER CU
			// WHERE (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK != 1) OR (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK IS NULL)
			// ORDER BY CU.NAMA ASC
		// ";
		$sql = "
			SELECT  
				KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR
			FROM CRMNEW_DISTRIBUTOR
			WHERE DELETE_MARK = 0 OR DELETE_MARK IS NULL
			ORDER BY NAMA_DISTRIBUTOR ASC
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function valCoverage()
	{
		$bln = date("m");
		$thn = date("yy");
		$bln_beg = date("m", strtotime("-3 months"));
			$q = $this->db_point->query("		 
				SELECT COUNT(DISTINCT KD_CUSTOMER) AS JUMLAH FROM POIN_PENJUALAN WHERE BULAN > {$bln_beg} AND BULAN <= {$bln}  AND TAHUN = {$thn}
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valNOO()
	{
		$q = $this->db_point->query("		 
				SELECT COUNT(*) AS JUMLAH FROM VIEW_M_CUSTOMER where TO_DATE(AKUISISI_DATE, 'dd-MM-yyyy') >= TRUNC(SYSDATE) - 30
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valSellin()
	{
		$q = $this->db_scm->query("		 
				SELECT SUM(KWANTUMX) AS JUMLAH FROM ZREPORT_SCM_REAL_SALES_SIDIGI
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valRevenue()
	{
		$q = $this->db_scm->query("		 
				SELECT SUM(HARGA) AS JUMLAH FROM ZREPORT_SCM_REAL_SALES_SIDIGI
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valSellOut()
	{
		$q = $this->db_point->query("		 
				SELECT SUM(JML_POIN) AS JUMLAH FROM POIN_PENJUALAN
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valVisit()
	{
		$q = $this->db->query("		 
				SELECT SUM(REALISASI) AS JUMLAH, SUM(TARGET) AS TARGET FROM VISIT_SALES_DISTRIBUTOR
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valSOCC()
	{
		$q = $this->db_scm->query("		 
				SELECT SUM(SISA_TO) AS JUMLAH FROM ZREPORT_SO_CNC
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valTarget()
	{
		$q = $this->db->query("		 
				SELECT COALESCE(SUM(TOKO_UNIT), 0) AS COVERAGE, COALESCE(SUM(VOLUME), 0) AS SELL_IN, COALESCE(SUM(REVENUE), 0) AS REVENUE, COALESCE(SUM(SELL_OUT), 0) AS SELL_OUT, COALESCE(SUM(SO_CLEAN_CLEAR), 0) AS SO_CC FROM CRMNEW_TARGET_SELLING_OUT_D
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valTarget2()
	{
		$q = $this->db->query("		 
				SELECT COALESCE(SUM(TOKO_BARU), 0) AS NOO FROM CRMNEW_TARGET_SELLING_OUT_S
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function getTotalKeluhan($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $jenisUser)
	{ 
	
	$where_bawahan = '';
	if($jenisUser=='1016'){
		$where_bawahan = " AND ID_GSM = '5034'";
	}else if($jenisUser=='1010'){
		$where_bawahan = " AND ID_SSM = '5339' ";
	}else if($jenisUser=='1011'){
		$where_bawahan = " AND ID_SM = '3251' ";
	}else if($jenisUser=='1012'){
		$where_bawahan = " AND ID_SO = '3243'";
	}
	
	if($listFilterByVal == 0){
		$sqlIn = " ";
	}else if($listFilterByVal == 1){
		$sqlIn = $listFilterSetVal == 0 ? " " : " AND REGION_ID = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 2){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND ID_PROVINSI = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 3){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND ID_DISTRIK = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 4){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND KD_AREA = '$listFilterSetVal' ";
	} 
	
	$tahun = '';
	$bulan = '';
	$mingguan = '';
	$dataminggu = '';
	if($filterMinggu=='ALL'){
		$tahun = $filterTahun != 'ALL' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'YYYY' ) = '{$filterTahun}' " : "";
		$bulan = $filterBulan != 'ALL' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'MM' ) = '{$filterBulan}' " : ""; 
	}else{ 
		$minggu = $this->db->query("SELECT CAL.TGL FROM CALENDER_CRM CAL WHERE TO_CHAR( CAL.TANGGAL, 'YYYY' ) = '{$filterTahun}'  AND  TO_CHAR( CAL.TANGGAL, 'MM' ) = '{$filterBulan}'  AND CAL.WEEKS = '{$filterMinggu}' ORDER BY 	NUMBER_HARI ASC")->result_array(); 
		foreach($minggu as $v){
			$mingguan	 .= "'".$v['TGL']."',";
		}
		$mingguan = rtrim($mingguan,",");
		$dataminggu = $mingguan !='' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD' ) in ({$mingguan}) " : ''  ; 
	}
		$q = $this->db->query("
				SELECT 
					COUNT (*) AS TOTAL_KELUHAN,
					COUNT (SEMEN_MENBATU) AS SEMEN_MENBATU,
					COUNT (SEMEN_TERLAMBAT_DATANG) AS SEMEN_TERLAMBAT_DATANG,
					COUNT (KANTONG_TIDAK_KUAT) AS KANTONG_TIDAK_KUAT,
					COUNT (HARGA_TIDAK_STABIL) AS HARGA_TIDAK_STABIL,
					COUNT (SEMEN_RUSAK_SAAT_DITERIMA) AS SEMEN_RUSAK_SAAT_DITERIMA,
					COUNT (TOP_KURANG_LAMA) AS TOP_KURANG_LAMA,
					COUNT (PEMESANAN_SULIT) AS PEMESANAN_SULIT,
					COUNT (KOMPLAIN_SULIT) AS KOMPLAIN_SULIT,
					COUNT (STOK_SERING_KOSONG) AS STOK_SERING_KOSONG,
					COUNT (PROSEDUR_RUMIT) AS PROSEDUR_RUMIT,
					COUNT (TIDAK_SESUAI_SPESIFIKASI) AS TIDAK_SESUAI_SPESIFIKASI,
					COUNT (KELUHAN_LAIN_LAIN) AS KELUHAN_LAIN_LAIN
				FROM R1_HASIL_SURVEY_SD 
				WHERE 
					TIDAK_ADA_KELUHAN IS NULL 
					AND (SEMEN_MENBATU IS NOT NULL OR SEMEN_TERLAMBAT_DATANG IS NOT NULL OR KANTONG_TIDAK_KUAT IS NOT NULL OR HARGA_TIDAK_STABIL IS NOT NULL OR SEMEN_RUSAK_SAAT_DITERIMA IS NOT NULL OR TOP_KURANG_LAMA IS NOT NULL OR PEMESANAN_SULIT IS NOT NULL OR KOMPLAIN_SULIT IS NOT NULL OR STOK_SERING_KOSONG IS NOT NULL OR PROSEDUR_RUMIT IS NOT NULL OR TIDAK_SESUAI_SPESIFIKASI IS NOT NULL OR KELUHAN_LAIN_LAIN IS NOT NULL)
					{$tahun}  {$bulan}  {$dataminggu}
					{$sqlIn}
					{$where_bawahan}
		");
			 
				
		return $q ? $q->result_array() : array();
	}  
	public function getTotalTidakKeluhan($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $jenisUser)
	{ 
	
	$where_bawahan = '';
	if($jenisUser=='1016'){
		$where_bawahan = " AND ID_GSM = '5034'";
	}else if($jenisUser=='1010'){
		$where_bawahan = " AND ID_SSM = '5339' ";
	}else if($jenisUser=='1011'){
		$where_bawahan = " AND ID_SM = '3251' ";
	}else if($jenisUser=='1012'){
		$where_bawahan = " AND ID_SO = '3243'";
	}
	 
	if($listFilterByVal == 0){
		$sqlIn = " ";
	}else if($listFilterByVal == 1){
		$sqlIn = $listFilterSetVal == 0 ? " " : " AND REGION_ID = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 2){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND ID_PROVINSI = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 3){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND ID_DISTRIK = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 4){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND KD_AREA = '$listFilterSetVal' ";
	} 
	
	$tahun = '';
	$bulan = '';
	$mingguan = '';
	$dataminggu = '';
	if($filterMinggu=='ALL'){
		$tahun = $filterTahun != 'ALL' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'YYYY' ) = '{$filterTahun}' " : "";
		$bulan = $filterBulan != 'ALL' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'MM' ) = '{$filterBulan}' " : ""; 
	}else{ 
		$minggu = $this->db->query("SELECT CAL.TGL FROM CALENDER_CRM CAL WHERE TO_CHAR( CAL.TANGGAL, 'YYYY' ) = '{$filterTahun}'  AND  TO_CHAR( CAL.TANGGAL, 'MM' ) = '{$filterBulan}'  AND CAL.WEEKS = '{$filterMinggu}' ORDER BY 	NUMBER_HARI ASC")->result_array(); 
		foreach($minggu as $v){
			$mingguan	 .= "'".$v['TGL']."',";
		}
		$mingguan = rtrim($mingguan,",");
		$dataminggu = $mingguan !='' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD' ) in ({$mingguan}) " : ''  ; 
	}
		$q = $this->db->query("
				SELECT 
					COUNT (*) AS TOTAL_TIDAK_ADA_KELUHAN
				FROM R1_HASIL_SURVEY_SD 
				WHERE 
					TIDAK_ADA_KELUHAN IS NOT NULL
					AND SEMEN_MENBATU IS NULL AND SEMEN_TERLAMBAT_DATANG IS NULL AND KANTONG_TIDAK_KUAT IS NULL AND HARGA_TIDAK_STABIL IS NULL AND SEMEN_RUSAK_SAAT_DITERIMA IS NULL AND TOP_KURANG_LAMA IS NULL AND PEMESANAN_SULIT IS NULL AND KOMPLAIN_SULIT IS NULL AND STOK_SERING_KOSONG IS NULL AND PROSEDUR_RUMIT IS NULL AND TIDAK_SESUAI_SPESIFIKASI IS NULL AND KELUHAN_LAIN_LAIN IS NULL
					{$tahun}  {$bulan}  {$dataminggu}
					{$sqlIn}
					{$where_bawahan}
		");
			 
				
		return $q ? $q->result_array() : array();
	}  
	
	public function getPromosi($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $jenisUser)
	{ 
	
	$where_bawahan = '';
	if($jenisUser=='1016'){
		$where_bawahan = " AND ID_GSM = '5034'";
	}else if($jenisUser=='1010'){
		$where_bawahan = " AND ID_SSM = '5339' ";
	}else if($jenisUser=='1011'){
		$where_bawahan = " AND ID_SM = '3251' ";
	}else if($jenisUser=='1012'){
		$where_bawahan = " AND ID_SO = '3243'";
	}
	
	if($listFilterByVal == 0){
		$sqlIn = " ";
	}else if($listFilterByVal == 1){
		$sqlIn = $listFilterSetVal == 0 ? " " : " AND REGION_ID = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 2){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND ID_PROVINSI = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 3){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND ID_DISTRIK = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 4){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND KD_AREA = '$listFilterSetVal' ";
	} 
	
	$tahun = '';
	$bulan = '';
	$mingguan = '';
	$dataminggu = '';
	if($filterMinggu=='ALL'){
		$tahun = $filterTahun != 'ALL' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'YYYY' ) = '{$filterTahun}' " : "";
		$bulan = $filterBulan != 'ALL' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'MM' ) = '{$filterBulan}' " : ""; 
	}else{ 
		$minggu = $this->db->query("SELECT CAL.TGL FROM CALENDER_CRM CAL WHERE TO_CHAR( CAL.TANGGAL, 'YYYY' ) = '{$filterTahun}'  AND  TO_CHAR( CAL.TANGGAL, 'MM' ) = '{$filterBulan}'  AND CAL.WEEKS = '{$filterMinggu}' ORDER BY 	NUMBER_HARI ASC")->result_array(); 
		foreach($minggu as $v){
			$mingguan	 .= "'".$v['TGL']."',";
		}
		$mingguan = rtrim($mingguan,",");
		$dataminggu = $mingguan !='' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD' ) in ({$mingguan}) " : ''  ; 
	}
		$q = $this->db->query("
				SELECT 
					COUNT (*) AS TOTAL_PROMOSI,
					COUNT (BONUS_SEMEN) AS BONUS_SEMEN,
					COUNT (BONUS_WISATA) AS BONUS_WISATA,
					COUNT (POINT_REWARD) AS POINT_REWARD,
					COUNT (VOUCER) AS VOUCER,
					COUNT (POTONGAN_HARGA) AS POTONGAN_HARGA
				FROM R1_HASIL_SURVEY_SD 
				WHERE 
					(BONUS_SEMEN IS NOT NULL OR BONUS_WISATA IS NOT NULL OR POINT_REWARD IS NOT NULL OR VOUCER IS NOT NULL OR POTONGAN_HARGA IS NOT NULL)
					{$tahun}  {$bulan}  {$dataminggu}
					{$sqlIn}
					{$where_bawahan}
		");
			 
				
		return $q ? $q->result_array() : array();
	}  
	
	public function getTidakPromosi($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $jenisUser)
	{ 
	
	$where_bawahan = '';
	if($jenisUser=='1016'){
		$where_bawahan = " AND ID_GSM = '5034'";
	}else if($jenisUser=='1010'){
		$where_bawahan = " AND ID_SSM = '5339' ";
	}else if($jenisUser=='1011'){
		$where_bawahan = " AND ID_SM = '3251' ";
	}else if($jenisUser=='1012'){
		$where_bawahan = " AND ID_SO = '3243'";
	}
	
	if($listFilterByVal == 0){
		$sqlIn = " ";
	}else if($listFilterByVal == 1){
		$sqlIn = $listFilterSetVal == 0 ? " " : " AND REGION_ID = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 2){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND ID_PROVINSI = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 3){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND ID_DISTRIK = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 4){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND KD_AREA = '$listFilterSetVal' ";
	} 
	
	$tahun = '';
	$bulan = '';
	$mingguan = '';
	$dataminggu = '';
	if($filterMinggu=='ALL'){
		$tahun = $filterTahun != 'ALL' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'YYYY' ) = '{$filterTahun}' " : "";
		$bulan = $filterBulan != 'ALL' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'MM' ) = '{$filterBulan}' " : ""; 
	}else{ 
		$minggu = $this->db->query("SELECT CAL.TGL FROM CALENDER_CRM CAL WHERE TO_CHAR( CAL.TANGGAL, 'YYYY' ) = '{$filterTahun}'  AND  TO_CHAR( CAL.TANGGAL, 'MM' ) = '{$filterBulan}'  AND CAL.WEEKS = '{$filterMinggu}' ORDER BY 	NUMBER_HARI ASC")->result_array(); 
		foreach($minggu as $v){
			$mingguan	 .= "'".$v['TGL']."',";
		}
		$mingguan = rtrim($mingguan,",");
		$dataminggu = $mingguan !='' ? " AND TO_CHAR( TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD' ) in ({$mingguan}) " : ''  ; 
	}
		$q = $this->db->query("
				SELECT 
					COUNT (*) AS TOTAL_TIDAK_PROMOSI
				FROM R1_HASIL_SURVEY_SD 
				WHERE 
					BONUS_SEMEN IS NULL AND BONUS_WISATA IS NULL AND POINT_REWARD IS NULL AND VOUCER IS NULL AND POTONGAN_HARGA IS NULL
					{$tahun}  {$bulan}  {$dataminggu}
					{$sqlIn}
					{$where_bawahan}
		");
			 
				
		return $q ? $q->result_array() : array();
	}  
	
	public function getRegion($id_user, $jenisUser){
		$region_id = '';		 
			
		if($jenisUser=='1017'){
			$sqlNew = "
                SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE DELETE_MARK = 0 AND ID_USER = '{$id_user}'
            ";
             $q = $this->db->query($sqlNew)->result_array();
			 $id_region = '';
			 foreach($q as $v){
				 $id_region .= $$v['ID_REGION'].",";
			 }
			 $region_ids =  rtrim($id_region,","); 
			$region_id =  $region_ids!='' ? " AND REGION_ID IN ({$region_ids})" : '';
		}
            $sqlNew = "
                SELECT DISTINCT(REGION_ID) AS ID_REGION, REGION_NAME AS REGION FROM WILAYAH_SMI
                WHERE REGION_ID IS NOT NULL {$region_id}
                ORDER BY REGION_ID ASC
            ";
            return $this->db->query($sqlNew)->result();
        }
        
        public function getProvinsi(){ 
            $sqlNew = "
                SELECT DISTINCT(ID_PROVINSI) AS ID_PROVINSI, NAMA_PROVINSI FROM WILAYAH_SMI
                WHERE ID_PROVINSI IS NOT NULL
                ORDER BY NAMA_PROVINSI ASC
            ";
            return $this->db->query($sqlNew)->result();
        }
        
        public function getArea(){ 
            $sqlNew = "
                SELECT DISTINCT(KD_AREA) AS ID_AREA, NM_AREA AS NAMA_AREA FROM WILAYAH_SMI
                WHERE KD_AREA IS NOT NULL
                ORDER BY KD_AREA ASC
            ";
            return $this->db->query($sqlNew)->result();
        }
        
        public function getDistrik(){ 
            $sqlNew = "
                SELECT DISTINCT(ID_DISTRIK) AS ID_DISTRIK, NAMA_DISTRIK FROM CRMNEW_M_DISTRIK
                WHERE ID_DISTRIK IS NOT NULL
                ORDER BY NAMA_DISTRIK ASC
            ";
            return $this->db->query($sqlNew)->result();
        }
	

	
	

 
}
