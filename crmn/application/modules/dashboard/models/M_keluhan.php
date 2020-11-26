<?php

class M_keluhan Extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		
	}
	
	public function getTotalKeluhan($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $brand)
	{ 
	
	$bawahan ='';
	$id_user = $this->session->userdata("user_id"); 
	if( $where_bawahan != '' && $where_bawahan=='DISTRIBUTOR'){
		$bawahan = "	AND SD.ID_TOKO IN (			
					SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
					WHERE ID_DISTRIBUTOR IN ( 
								SELECT 
									CUD.KODE_DISTRIBUTOR AS ID_DISTRIBUTOR 
								FROM CRMNEW_USER_DISTRIBUTOR CUD
								LEFT JOIN CRMNEW_DISTRIBUTOR CD 
									ON CUD.KODE_DISTRIBUTOR = CD.KODE_DISTRIBUTOR
								WHERE CUD.ID_USER = '{$id_user}' AND CUD.DELETE_MARK = 0 
					)
				)";
	}else if($where_bawahan != '' && $where_bawahan=='SPC'){
		$bawahan = " AND SD.ID_TOKO IN (
				SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
				JOIN CRMNEW_M_PROVINSI CMP ON CCR.ID_PROVINSI = CMP.ID_PROVINSI
				WHERE NEW_REGION IN ( 
							SELECT 
									CUR.ID_REGION AS ID 
								FROM CRMNEW_USER_REGION CUR
								LEFT JOIN (SELECT DISTINCT(REGION_ID), REGION_NAME FROM WILAYAH_SMI ORDER BY REGION_NAME) WS
									ON CUR.ID_REGION = WS.REGION_ID
								WHERE CUR.ID_USER = '{$id_user}' AND CUR.DELETE_MARK = 0 
				)
		)";
	}else if($where_bawahan != ''){
		$bawahan = "AND SD.ID_TOKO IN (
		SELECT 
			MTDS.ID_CUSTOMER 
			FROM MAPPING_TOKO_DIST_SALES MTDS
					LEFT JOIN HIRARCKY_GSM_TO_DISTRIBUTOR HGTD
							ON MTDS.ID_SALES = HGTD.ID_SALES AND MTDS.ID_DISTRIBUTOR = HGTD.KODE_DISTRIBUTOR
					LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
							ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
			WHERE 
			{$where_bawahan}    
			group by  MTDS.ID_CUSTOMER 
		)";
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
	$brande = '';
	if($brand != '' ){
		$brande = " AND SD.ID_PRODUK IN ( SELECT CPS.ID_PRODUK FROM CRMNEW_PRODUK_SURVEY CPS JOIN CRMNEW_JENIS_PRODUK_GROUP JPG ON CPS.GROUP_ID = JPG.GROUP_ID WHERE CPS.DELETE_MARK = 0 AND JPG.GROUP_ID = {$brand} ) ";
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
				FROM R1_HASIL_SURVEY_SD  SD
				WHERE 
					TIDAK_ADA_KELUHAN IS NULL 
					AND (SEMEN_MENBATU IS NOT NULL OR SEMEN_TERLAMBAT_DATANG IS NOT NULL OR KANTONG_TIDAK_KUAT IS NOT NULL OR HARGA_TIDAK_STABIL IS NOT NULL OR SEMEN_RUSAK_SAAT_DITERIMA IS NOT NULL OR TOP_KURANG_LAMA IS NOT NULL OR PEMESANAN_SULIT IS NOT NULL OR KOMPLAIN_SULIT IS NOT NULL OR STOK_SERING_KOSONG IS NOT NULL OR PROSEDUR_RUMIT IS NOT NULL OR TIDAK_SESUAI_SPESIFIKASI IS NOT NULL OR KELUHAN_LAIN_LAIN IS NOT NULL)
					{$tahun}  {$bulan}  {$dataminggu}
					{$sqlIn}
						{$brande}
					{$bawahan}
		");
			 
				
		return $q ? $q->result_array() : array();
	}  
	public function getTotalTidakKeluhan($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $brand)
	{ 
	
	$bawahan ='';
	$id_user = $this->session->userdata("user_id"); 
	if( $where_bawahan != '' && $where_bawahan=='DISTRIBUTOR'){
		$bawahan = "	AND SD.ID_TOKO IN (			
					SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
					WHERE ID_DISTRIBUTOR IN ( 
								SELECT 
									CUD.KODE_DISTRIBUTOR AS ID_DISTRIBUTOR 
								FROM CRMNEW_USER_DISTRIBUTOR CUD
								LEFT JOIN CRMNEW_DISTRIBUTOR CD 
									ON CUD.KODE_DISTRIBUTOR = CD.KODE_DISTRIBUTOR
								WHERE CUD.ID_USER = '{$id_user}' AND CUD.DELETE_MARK = 0 
					)
				)";
	}else if($where_bawahan != '' && $where_bawahan=='SPC'){
		$bawahan = " AND SD.ID_TOKO IN (
				SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
				JOIN CRMNEW_M_PROVINSI CMP ON CCR.ID_PROVINSI = CMP.ID_PROVINSI
				WHERE NEW_REGION IN ( 
							SELECT 
									CUR.ID_REGION AS ID 
								FROM CRMNEW_USER_REGION CUR
								LEFT JOIN (SELECT DISTINCT(REGION_ID), REGION_NAME FROM WILAYAH_SMI ORDER BY REGION_NAME) WS
									ON CUR.ID_REGION = WS.REGION_ID
								WHERE CUR.ID_USER = '{$id_user}' AND CUR.DELETE_MARK = 0 
				)
		)";
	}else if($where_bawahan != ''){
		$bawahan = "AND SD.ID_TOKO IN (
		SELECT 
			MTDS.ID_CUSTOMER 
			FROM MAPPING_TOKO_DIST_SALES MTDS
					LEFT JOIN HIRARCKY_GSM_TO_DISTRIBUTOR HGTD
							ON MTDS.ID_SALES = HGTD.ID_SALES AND MTDS.ID_DISTRIBUTOR = HGTD.KODE_DISTRIBUTOR
					LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
							ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
			WHERE 
			{$where_bawahan}    
			group by  MTDS.ID_CUSTOMER 
		)";
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
	$brande = '';
	if($brand != '' ){
		$brande = " AND SD.ID_PRODUK IN ( SELECT CPS.ID_PRODUK FROM CRMNEW_PRODUK_SURVEY CPS JOIN CRMNEW_JENIS_PRODUK_GROUP JPG ON CPS.GROUP_ID = JPG.GROUP_ID WHERE CPS.DELETE_MARK = 0 AND JPG.GROUP_ID = {$brand} ) ";
	}
		$q = $this->db->query("
				SELECT 
					COUNT (*) AS TOTAL_TIDAK_ADA_KELUHAN
				FROM R1_HASIL_SURVEY_SD SD
				WHERE 
					TIDAK_ADA_KELUHAN IS NOT NULL
					AND SEMEN_MENBATU IS NULL AND SEMEN_TERLAMBAT_DATANG IS NULL AND KANTONG_TIDAK_KUAT IS NULL AND HARGA_TIDAK_STABIL IS NULL AND SEMEN_RUSAK_SAAT_DITERIMA IS NULL AND TOP_KURANG_LAMA IS NULL AND PEMESANAN_SULIT IS NULL AND KOMPLAIN_SULIT IS NULL AND STOK_SERING_KOSONG IS NULL AND PROSEDUR_RUMIT IS NULL AND TIDAK_SESUAI_SPESIFIKASI IS NULL AND KELUHAN_LAIN_LAIN IS NULL
					{$tahun}  {$bulan}  {$dataminggu}
					{$sqlIn} 
						{$brande}
					{$bawahan}
		");
			 
				
		return $q ? $q->result_array() : array();
	}  
	
	public function getPromosi($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $brand)
	{ 
	
	$bawahan ='';
	$id_user = $this->session->userdata("user_id"); 
	if( $where_bawahan != '' && $where_bawahan=='DISTRIBUTOR'){
		$bawahan = "	AND SD.ID_TOKO IN (			
					SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
					WHERE ID_DISTRIBUTOR IN ( 
								SELECT 
									CUD.KODE_DISTRIBUTOR AS ID_DISTRIBUTOR 
								FROM CRMNEW_USER_DISTRIBUTOR CUD
								LEFT JOIN CRMNEW_DISTRIBUTOR CD 
									ON CUD.KODE_DISTRIBUTOR = CD.KODE_DISTRIBUTOR
								WHERE CUD.ID_USER = '{$id_user}' AND CUD.DELETE_MARK = 0 
					)
				)";
	}else if($where_bawahan != '' && $where_bawahan=='SPC'){
		$bawahan = " AND SD.ID_TOKO IN (
				SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
				JOIN CRMNEW_M_PROVINSI CMP ON CCR.ID_PROVINSI = CMP.ID_PROVINSI
				WHERE NEW_REGION IN ( 
							SELECT 
									CUR.ID_REGION AS ID 
								FROM CRMNEW_USER_REGION CUR
								LEFT JOIN (SELECT DISTINCT(REGION_ID), REGION_NAME FROM WILAYAH_SMI ORDER BY REGION_NAME) WS
									ON CUR.ID_REGION = WS.REGION_ID
								WHERE CUR.ID_USER = '{$id_user}' AND CUR.DELETE_MARK = 0 
				)
		)";
	}else if($where_bawahan != ''){
		$bawahan = "AND SD.ID_TOKO IN (
		SELECT 
			MTDS.ID_CUSTOMER 
			FROM MAPPING_TOKO_DIST_SALES MTDS
					LEFT JOIN HIRARCKY_GSM_TO_DISTRIBUTOR HGTD
							ON MTDS.ID_SALES = HGTD.ID_SALES AND MTDS.ID_DISTRIBUTOR = HGTD.KODE_DISTRIBUTOR
					LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
							ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
			WHERE 
			{$where_bawahan}    
			group by  MTDS.ID_CUSTOMER 
		)";
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
	$brande = '';
	if($brand != '' ){
		$brande = " AND SD.ID_PRODUK IN ( SELECT CPS.ID_PRODUK FROM CRMNEW_PRODUK_SURVEY CPS JOIN CRMNEW_JENIS_PRODUK_GROUP JPG ON CPS.GROUP_ID = JPG.GROUP_ID WHERE CPS.DELETE_MARK = 0 AND JPG.GROUP_ID = {$brand} ) ";
	}
		$q = $this->db->query("
				SELECT 
					COUNT (*) AS TOTAL_PROMOSI,
					COUNT (BONUS_SEMEN) AS BONUS_SEMEN,
					COUNT (BONUS_WISATA) AS BONUS_WISATA,
					COUNT (POINT_REWARD) AS POINT_REWARD,
					COUNT (BONUS_VOUCER) AS VOUCER,
					COUNT (POTONGAN_HARGA) AS POTONGAN_HARGA
				FROM R1_HASIL_SURVEY_SD SD
				WHERE 
					(BONUS_SEMEN IS NOT NULL OR BONUS_WISATA IS NOT NULL OR POINT_REWARD IS NOT NULL OR BONUS_VOUCER IS NOT NULL OR POTONGAN_HARGA IS NOT NULL)
					{$tahun}  {$bulan}  {$dataminggu}
					{$sqlIn}
						{$brande}
					{$bawahan}
		");
			 
				
		return $q ? $q->result_array() : array();
	}  
	
	public function getTidakPromosi($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $brand)
	{ 
	
	$bawahan ='';
	$id_user = $this->session->userdata("user_id"); 
	if( $where_bawahan != '' && $where_bawahan=='DISTRIBUTOR'){
		$bawahan = "	AND SD.ID_TOKO IN (			
					SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
					WHERE ID_DISTRIBUTOR IN ( 
								SELECT 
									CUD.KODE_DISTRIBUTOR AS ID_DISTRIBUTOR 
								FROM CRMNEW_USER_DISTRIBUTOR CUD
								LEFT JOIN CRMNEW_DISTRIBUTOR CD 
									ON CUD.KODE_DISTRIBUTOR = CD.KODE_DISTRIBUTOR
								WHERE CUD.ID_USER = '{$id_user}' AND CUD.DELETE_MARK = 0 
					)
				)";
	}else if($where_bawahan != '' && $where_bawahan=='SPC'){
		$bawahan = " AND SD.ID_TOKO IN (
				SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
				JOIN CRMNEW_M_PROVINSI CMP ON CCR.ID_PROVINSI = CMP.ID_PROVINSI
				WHERE NEW_REGION IN ( 
							SELECT 
									CUR.ID_REGION AS ID 
								FROM CRMNEW_USER_REGION CUR
								LEFT JOIN (SELECT DISTINCT(REGION_ID), REGION_NAME FROM WILAYAH_SMI ORDER BY REGION_NAME) WS
									ON CUR.ID_REGION = WS.REGION_ID
								WHERE CUR.ID_USER = '{$id_user}' AND CUR.DELETE_MARK = 0 
				)
		)";
	}else if($where_bawahan != ''){
		$bawahan = "AND SD.ID_TOKO IN (
		SELECT 
			MTDS.ID_CUSTOMER 
			FROM MAPPING_TOKO_DIST_SALES MTDS
					LEFT JOIN HIRARCKY_GSM_TO_DISTRIBUTOR HGTD
							ON MTDS.ID_SALES = HGTD.ID_SALES AND MTDS.ID_DISTRIBUTOR = HGTD.KODE_DISTRIBUTOR
					LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
							ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
			WHERE 
			{$where_bawahan}    
			group by  MTDS.ID_CUSTOMER 
		)";
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
	$brande = '';
	if($brand != '' ){
		$brande = " AND SD.ID_PRODUK IN ( SELECT CPS.ID_PRODUK FROM CRMNEW_PRODUK_SURVEY CPS JOIN CRMNEW_JENIS_PRODUK_GROUP JPG ON CPS.GROUP_ID = JPG.GROUP_ID WHERE CPS.DELETE_MARK = 0 AND JPG.GROUP_ID = {$brand} ) ";
	}
		$q = $this->db->query("
				SELECT 
					COUNT (*) AS TOTAL_TIDAK_PROMOSI
				FROM R1_HASIL_SURVEY_SD SD
				WHERE 
					BONUS_SEMEN IS NULL AND BONUS_WISATA IS NULL AND POINT_REWARD IS NULL AND BONUS_VOUCER IS NULL AND POTONGAN_HARGA IS NULL
					{$tahun}  {$bulan}  {$dataminggu}
					{$sqlIn}
					{$brande}
					{$bawahan}
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
	   public function getBrand(){ 
            $sqlNew = "
                SELECT DISTINCT(GROUP_ID) AS GROUP_ID, JENIS_PRODUK FROM CRMNEW_JENIS_PRODUK_GROUP
                WHERE GROUP_ID IS NOT NULL
				--AND SMI_GROUP = 'Y'
                ORDER BY GROUP_ID ASC 
            ";
            return $this->db->query($sqlNew)->result();
        }

	
	

 
}
