<?php

class M_harga_competitor_all Extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('crm', TRUE);
		// $this->db = $this->load->database('PROD_TES', TRUE);
		
	}


	public function getProdukGroup($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $kemasan, $kategori)
	{ 
		if($listFilterByVal == 0){
		$sqlIn = " ";
		}else if($listFilterByVal == 1){
			$sqlIn = $listFilterSetVal == 0 ? " " : " AND E.NEW_REGION = '$listFilterSetVal' ";
		} else if ($listFilterByVal == 2){
			$sqlIn = $listFilterSetVal == 0 ? " " :  " AND VSOTC.ID_PROVINSI = '$listFilterSetVal' ";
		} else if ($listFilterByVal == 3){
			$sqlIn = $listFilterSetVal == 0 ? " " :  " AND VSOTC.ID_DISTRIK = '$listFilterSetVal' ";
		} else if ($listFilterByVal == 4){
			$sqlIn = $listFilterSetVal == 0 ? " " :  " AND VSOTC.ID_AREA = '$listFilterSetVal' ";
		} 
	
	$tahun = '';
	$bulan = '';
	$tahunIN = '';
	$bulanIN = '';
	$mingguan = '';
	$dataminggu = '';
	$datamingguIN = '';
	if($filterMinggu=='ALL'){
		$tahun = $filterTahun != 'ALL' ? "  TO_CHAR( A.CREATE_DATE, 'YYYY' ) = '{$filterTahun}' " : "";
		$tahunIN = $filterTahun != 'ALL' ? "  TO_CHAR( CHS.CREATE_DATE, 'YYYY' ) = '{$filterTahun}' " : "";
		$bulan = $filterBulan != 'ALL' ? " AND TO_CHAR( A.CREATE_DATE, 'MM' ) = '{$filterBulan}' " : ""; 
		$bulanIN = $filterBulan != 'ALL' ? " AND TO_CHAR( CHS.CREATE_DATE, 'MM' ) = '{$filterBulan}' " : ""; 
	}else{ 
		$minggu = $this->db->query("SELECT CAL.TGL FROM CALENDER_CRM CAL WHERE TO_CHAR( CAL.TANGGAL, 'YYYY' ) = '{$filterTahun}'  AND  TO_CHAR( CAL.TANGGAL, 'MM' ) = '{$filterBulan}'  AND CAL.WEEKS = '{$filterMinggu}' ORDER BY 	NUMBER_HARI ASC")->result_array(); 
		foreach($minggu as $v){
			$mingguan	 .= "'".$v['TGL']."',";
		} 
		$mingguan = rtrim($mingguan,",");
		$dataminggu = $mingguan !='' ? "  TO_CHAR( A.CREATE_DATE, 'YYYY-MM-DD' ) in ({$mingguan}) " : ''  ; 
		$datamingguIN = $mingguan !='' ? "  TO_CHAR( CHS.CREATE_DATE, 'YYYY-MM-DD' ) in ({$mingguan}) " : ''  ; 
	} 
	$bawahan ='';
	$id_user = $this->session->userdata("user_id"); 
	if( $where_bawahan != '' && $where_bawahan=='DISTRIBUTOR'){
		$bawahan = "	AND B.ID_TOKO IN (			
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
		$bawahan = " AND B.ID_TOKO IN (
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
		$bawahan = "AND B.ID_TOKO IN (
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
	
	$kemas = ($kemasan =='' ? '' : " AND D.KEMASAN = '{$kemasan}'");
	$katego = ($kategori =='' ? '' : " AND D.KATEGORI = '{$kategori}'");
		$q = $this->db->query("	SELECT
				D.GROUP_ID, JENIS_PRODUK
				FROM
				CRMNEW_HASIL_SURVEY A
				JOIN CRMNEW_HASIL_SURVEY B ON A.ID_KUNJUNGAN_CUSTOMER = B.ID_KUNJUNGAN_CUSTOMER
				JOIN CRMNEW_CUSTOMER VSOTC ON A.ID_TOKO = VSOTC.ID_CUSTOMER 
				JOIN CRMNEW_M_PROVINSI E ON VSOTC.ID_PROVINSI = E.ID_PROVINSI
				JOIN CRMNEW_M_DISTRIK F ON VSOTC.ID_DISTRIK = F.ID_DISTRIK 
				LEFT JOIN CRMNEW_PRODUK_SURVEY D ON A.ID_PRODUK = D.ID_PRODUK 
				JOIN CRMNEW_JENIS_PRODUK_GROUP G ON D.GROUP_ID = G.GROUP_ID
			WHERE  
				( {$tahun}  {$bulan}  {$dataminggu} )   AND A.VOLUME_PENJUALAN IS NOT NULL  
				AND  G.DELETE_MARK = 0
				{$sqlIn} 	 {$bawahan} {$kemas} {$katego}
			GROUP BY
				D.GROUP_ID, JENIS_PRODUK
		");  
		return $q ? $q->result_array() : array();
	}
	
	public function getHarga($group_id, $tipe, $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $kemasan, $kategori)
	{ 
	if($tipe=='BELI'){
		$kolom = "COUNT(HARGA_PEMBELIAN) AS TOTAL,  HARGA_PEMBELIAN";
		$group = "AND ( HARGA_PEMBELIAN IS NOT NULL AND HARGA_PEMBELIAN != 0 ) 
			GROUP BY HARGA_PEMBELIAN ORDER BY COUNT(HARGA_PEMBELIAN) DESC";
	}else{ 
		$kolom = "COUNT(HARGA_PENJUALAN) AS TOTAL,  HARGA_PENJUALAN";
		$group = "AND ( HARGA_PENJUALAN IS NOT NULL AND HARGA_PENJUALAN != 0 ) 
			GROUP BY HARGA_PENJUALAN ORDER BY COUNT(HARGA_PENJUALAN) DESC";
	} 
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
		$bawahan = " AND B.ID_TOKO IN (
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
		$bawahan = "AND B.ID_TOKO IN (
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
	
	 
	$kemas = ($kemasan =='' ? '' : " AND D.KEMASAN = '{$kemasan}'");
	$katego = ($kategori =='' ? '' : " AND D.KATEGORI = '{$kategori}'");
	
		$q = $this->db->query("SELECT  
			{$kolom}
		FROM
			CRMNEW_KUNJUNGAN_CUSTOMER A
			JOIN CRMNEW_HASIL_SURVEY B ON A.ID_KUNJUNGAN_CUSTOMER = B.ID_KUNJUNGAN_CUSTOMER
			JOIN CRMNEW_CUSTOMER C ON A.ID_TOKO = C.ID_CUSTOMER
			LEFT JOIN CRMNEW_PRODUK_SURVEY D ON B.ID_PRODUK = D.ID_PRODUK
			JOIN CRMNEW_M_PROVINSI E ON C.ID_PROVINSI = E.ID_PROVINSI
			JOIN CRMNEW_M_DISTRIK F ON C.ID_DISTRIK = F.ID_DISTRIK 
			JOIN CRMNEW_JENIS_PRODUK_GROUP G ON D.GROUP_ID = G.GROUP_ID
		WHERE
			( {$tahun}  {$bulan}  {$dataminggu} ) 
			AND G.GROUP_ID = {$group_id}
			AND A.DELETED_MARK = 0 
			AND B.DELETE_MARK = 0	
			{$sqlIn}
			{$bawahan}
			{$kemas}
			{$katego}
			{$group}
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
