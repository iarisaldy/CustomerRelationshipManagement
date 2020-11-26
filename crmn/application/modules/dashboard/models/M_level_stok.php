<?php

class M_level_stok Extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		// $this->db = $this->load->database('PROD_TES', TRUE);
		$this->db = $this->load->database('crm', TRUE);
		
	}


	public function getBy($tipe)
	{ 
	if($tipe == "1"){ 
		$q = $this->db->query("SELECT A.REGION_ID AS ID, REGION_NAME AS NAME FROM CRMNEW_REGION A WHERE DELETED_MARK = 0 "); 
	}else if($tipe == "2"){
		$q = $this->db->query("SELECT  A.ID_PROVINSI  AS ID, NAMA_PROVINSI AS NAME FROM CRMNEW_M_PROVINSI  A   "); 
	}else if($tipe == "3"){
		$q = $this->db->query("SELECT  A.ID_DISTRIK  AS ID, NAMA_DISTRIK AS NAME FROM CRMNEW_M_DISTRIK  A WHERE DELETE_MARK = 0 ");  
	}else if($tipe == "4"){
		$q = $this->db->query("SELECT  A.ID_AREA  AS ID, NAMA_AREA AS NAME FROM CRMNEW_M_AREA  A WHERE DELETE_MARK = 0 ");  
	}
				
		return $q ? $q->result_array() : array();
	}
	
	public function getTotal( $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $brand )
	{ 
	 
	if($listFilterByVal == 0){
		$sqlIn = " ";
	}else if($listFilterByVal == 1){
		$sqlIn = $listFilterSetVal == 0 ? " " : " AND E.NEW_REGION = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 2){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND C.ID_PROVINSI = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 3){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND C.ID_DISTRIK = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 4){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND C.ID_AREA = '$listFilterSetVal' ";
	} 
	
	$tahun = '';
	$bulan = '';
	$mingguan = '';
	$dataminggu = '';
	if($filterMinggu=='ALL'){
		$tahun = $filterTahun != 'ALL' ? "  TO_CHAR( A.TGL_RENCANA_KUNJUNGAN, 'YYYY' ) = '{$filterTahun}' " : "";
		$bulan = $filterBulan != 'ALL' ? " AND TO_CHAR( A.TGL_RENCANA_KUNJUNGAN, 'MM' ) = '{$filterBulan}' " : ""; 
	}else{ 
		$minggu = $this->db->query("SELECT CAL.TGL FROM CALENDER_CRM CAL WHERE TO_CHAR( CAL.TANGGAL, 'YYYY' ) = '{$filterTahun}'  AND  TO_CHAR( CAL.TANGGAL, 'MM' ) = '{$filterBulan}'  AND CAL.WEEKS = '{$filterMinggu}' ORDER BY 	NUMBER_HARI ASC")->result_array(); 
		foreach($minggu as $v){
			$mingguan	 .= "'".$v['TGL']."',";
		}
		$mingguan = rtrim($mingguan,",");
		$dataminggu = $mingguan !='' ? "  TO_CHAR( A.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD' ) in ({$mingguan}) " : ''  ; 
	}
	
	$bawahan ='';
	$id_user = $this->session->userdata("user_id"); 
	if( $where_bawahan != '' && $where_bawahan=='DISTRIBUTOR'){
		$bawahan = "	AND B.ID_TOKO IN (			
					SELECT CCR.ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
					JOIN CRMNEW_KAPASITAS_TOKO CKT ON CCR.ID_CUSTOMER = CKT.ID_CUSTOMER
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
		$bawahan = " AND B.ID_TOKO IN (
				SELECT CCR.ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
				JOIN CRMNEW_KAPASITAS_TOKO CKT ON CCR.ID_CUSTOMER = CKT.ID_CUSTOMER
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
		$bawahan = "AND B.ID_TOKO IN (
		SELECT 
			MTDS.ID_CUSTOMER 
			FROM MAPPING_TOKO_DIST_SALES MTDS
					JOIN CRMNEW_KAPASITAS_TOKO CKT ON MTDS.ID_CUSTOMER = CKT.ID_CUSTOMER
					LEFT JOIN HIRARCKY_GSM_TO_DISTRIBUTOR HGTD
							ON MTDS.ID_SALES = HGTD.ID_SALES AND MTDS.ID_DISTRIBUTOR = HGTD.KODE_DISTRIBUTOR
					LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
							ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
			WHERE 
			{$where_bawahan}    
			group by  MTDS.ID_CUSTOMER 
		)";
	}
	$brande = '';
	if($brand != '' ){
		$brande = " AND B.ID_PRODUK IN ( SELECT CPS.ID_PRODUK FROM CRMNEW_PRODUK_SURVEY CPS JOIN CRMNEW_JENIS_PRODUK_GROUP JPG ON CPS.GROUP_ID = JPG.GROUP_ID WHERE CPS.DELETE_MARK = 0 AND JPG.GROUP_ID = {$brand} ) ";
	}
		$q = $this->db->query("	 SELECT  
			B.ID_TOKO, B.ID_PRODUK, (SELECT STOK_SAAT_INI FROM CRMNEW_HASIL_SURVEY CHS WHERE CHS.ID_TOKO = B.ID_TOKO AND CHS.ID_PRODUK = B.ID_PRODUK AND ROWNUM = 1) AS STOK_PRODUK_SIG
		FROM
			CRMNEW_KUNJUNGAN_CUSTOMER A
			JOIN CRMNEW_HASIL_SURVEY B ON A.ID_KUNJUNGAN_CUSTOMER = B.ID_KUNJUNGAN_CUSTOMER
			JOIN CRMNEW_CUSTOMER C ON A.ID_TOKO = C.ID_CUSTOMER
			LEFT JOIN CRMNEW_PRODUK_SURVEY D ON B.ID_PRODUK = D.ID_PRODUK
			JOIN CRMNEW_M_PROVINSI E ON C.ID_PROVINSI = E.ID_PROVINSI
			JOIN CRMNEW_M_DISTRIK F ON C.ID_DISTRIK = F.ID_DISTRIK 
			JOIN CRMNEW_JENIS_PRODUK_GROUP G ON D.GROUP_ID = G.GROUP_ID
		WHERE G.GROUP_ID IN (SELECT GROUP_ID FROM CRMNEW_JENIS_PRODUK_GROUP WHERE SMI_GROUP = 'Y')
		AND ( {$tahun}  {$bulan}  {$dataminggu} ) 
		{$sqlIn}
			{$brande}
					{$bawahan}
		GROUP BY B.ID_TOKO, B.ID_PRODUK
		 
		"); 
			 
				
		return $q ? $q->result_array() : array();
	}   
	
	
	public function getKapasitasToko1($idBy, $listFilterByVal, $where_bawahan){
		if($listFilterByVal == 0){
			$sl = " ";
		}
		else if($listFilterByVal == 1){
			$sl = "
				SELECT
				SUM(KAPASITAS_ZAK) AS KAPASITAS_ZAK
				FROM CRMNEW_KAPASITAS_TOKO1
				WHERE REGION_ID='$idBy'

			";
		}

		else if($listFilterByVal == 2){
			$sl = "
				SELECT
				SUM(KAPASITAS_ZAK) AS KAPASITAS_ZAK
				FROM CRMNEW_KAPASITAS_TOKO1
				WHERE ID_PROVINSI='$idBy'

			";
		}
		else if($listFilterByVal == 3){
			$sl = "
				SELECT
				SUM(KAPASITAS_ZAK) AS KAPASITAS_ZAK
				FROM CRMNEW_KAPASITAS_TOKO1
				WHERE KD_AREA='$idBy'

			";
		}
		else if($listFilterByVal == 4){
			$sl = "
				SELECT
				SUM(KAPASITAS_ZAK) AS KAPASITAS_ZAK
				FROM CRMNEW_KAPASITAS_TOKO1
				WHERE ID_DISTRIK='$idBy'

			";
		}
		
		return $this->db->query($sl)->result_array();
	}
	public function getKapasitasToko($idBy, $listFilterByVal, $where_bawahan )
	{ 
	 
	if($listFilterByVal == 0){
		$sqlIn = " ";
	}else if($listFilterByVal == 1){
		$sqlIn =  "  (SELECT ID_REGION FROM CRMNEW_CUSTOMER C 
				JOIN CRMNEW_M_PROVINSI E ON C.ID_PROVINSI = E.ID_PROVINSI
				JOIN CRMNEW_REGION CR ON CR.REGION_ID = E.NEW_REGION
				WHERE C.ID_CUSTOMER = KT.ID_CUSTOMER AND ROWNUM = 1 ) = {$idBy} ";
	} else if ($listFilterByVal == 2){
		$sqlIn = "  (SELECT ID_PROVINSI FROM CRMNEW_CUSTOMER C
			 WHERE C.ID_CUSTOMER = KT.ID_CUSTOMER AND ROWNUM = 1 ) = {$idBy}";
	} else if ($listFilterByVal == 3){
		$sqlIn =  "  (SELECT ID_DISTRIK FROM CRMNEW_CUSTOMER C
			 WHERE C.ID_CUSTOMER = KT.ID_CUSTOMER AND ROWNUM = 1 ) = {$idBy}
			 ";
	} else if ($listFilterByVal == 4){
		$sqlIn = "  (SELECT ID_AREA FROM CRMNEW_CUSTOMER C
			 WHERE C.ID_CUSTOMER = KT.ID_CUSTOMER AND ROWNUM = 1 ) = {$idBy}";
	} 
	 
	$bawahan ='';
	$id_user = $this->session->userdata("user_id"); 
	if( $where_bawahan != '' && $where_bawahan=='DISTRIBUTOR'){
		$bawahan = "	AND KT.ID_CUSTOMER IN (			
					SELECT CCR.ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
					JOIN CRMNEW_KAPASITAS_TOKO CKT ON CCR.ID_CUSTOMER = CKT.ID_CUSTOMER
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
		$bawahan = " AND KT.ID_CUSTOMER IN (
				SELECT CCR.ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
				JOIN CRMNEW_KAPASITAS_TOKO CKT ON CCR.ID_CUSTOMER = CKT.ID_CUSTOMER
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
		$bawahan = "AND KT.ID_CUSTOMER IN (
		SELECT 
			MTDS.ID_CUSTOMER 
			FROM MAPPING_TOKO_DIST_SALES MTDS
					JOIN CRMNEW_KAPASITAS_TOKO CKT ON MTDS.ID_CUSTOMER = CKT.ID_CUSTOMER
					LEFT JOIN HIRARCKY_GSM_TO_DISTRIBUTOR HGTD
							ON MTDS.ID_SALES = HGTD.ID_SALES AND MTDS.ID_DISTRIBUTOR = HGTD.KODE_DISTRIBUTOR
					LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
							ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
			WHERE 
			{$where_bawahan}    
			group by  MTDS.ID_CUSTOMER 
		)";
	}
		$s= " SELECT  SUM(KAPASITAS_ZAK) AS KAPASITAS_ZAK  FROM CRMNEW_KAPASITAS_TOKO KT  
			WHERE	  
					{$sqlIn}
					{$bawahan} ";
		$q = $this->db->query("	 
		SELECT  SUM(KAPASITAS_ZAK) AS KAPASITAS_ZAK  FROM CRMNEW_KAPASITAS_TOKO KT  
			WHERE	  
					{$sqlIn}
					{$bawahan}
		"); 
		
		// echo "<pre>";
		// 	echo $s;
		// 	echo "</pre>";
		// exit;
		//echo $q;	
		return $q ? $q->result_array() : array();
	}  
	 
        public function getSig(){ 
            $sqlNew = "
                SELECT DISTINCT(GROUP_ID) AS GROUP_ID, JENIS_PRODUK FROM CRMNEW_JENIS_PRODUK_GROUP
                WHERE GROUP_ID IS NOT NULL AND SMI_GROUP = 'Y'
                ORDER BY GROUP_ID ASC 
            ";
            return $this->db->query($sqlNew)->result();
        }
	 
	
	

	
	

 
}
