<?php

class M_sow_wpm Extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('crm', TRUE);
		// $this->db = $this->load->database('PROD_TES', TRUE);
		$this->sell = $this->load->database('3pl', TRUE);
		
	}


	public function getProdukSIG() {
		return $this->db->query("SELECT GROUP_ID, JENIS_PRODUK FROM CRMNEW_JENIS_PRODUK_GROUP CJP WHERE CJP.SMI_GROUP = 'Y' AND DELETE_MARK = 0")->result_array();
	}
	public function getProduknonSIG1() {
		return $this->db->query("SELECT GROUP_ID, JENIS_PRODUK FROM CRMNEW_JENIS_PRODUK_GROUP CJP WHERE CJP.SMI_GROUP = 'N' AND DELETE_MARK = 0")->result_array();
	}
	public function getProduknonSIG($CustomerAllC,  $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu ) {
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
	
		$q = $this->db->query("	SELECT
				D.GROUP_ID
				FROM
				CRMNEW_HASIL_SURVEY A
				JOIN CRMNEW_CUSTOMER VSOTC ON A.ID_TOKO = VSOTC.ID_CUSTOMER 
				JOIN CRMNEW_M_PROVINSI E ON VSOTC.ID_PROVINSI = E.ID_PROVINSI
				JOIN CRMNEW_M_DISTRIK F ON VSOTC.ID_DISTRIK = F.ID_DISTRIK 
				LEFT JOIN CRMNEW_PRODUK_SURVEY D ON A.ID_PRODUK = D.ID_PRODUK 
				JOIN CRMNEW_JENIS_PRODUK_GROUP G ON D.GROUP_ID = G.GROUP_ID
			WHERE 
				( {$tahun}  {$bulan}  {$dataminggu} )   AND A.VOLUME_PENJUALAN IS NOT NULL  
				AND G.SMI_GROUP = 'N' AND G.DELETE_MARK = 0
				{$sqlIn} 	 AND A.ID_TOKO in ({$CustomerAllC})
			GROUP BY
				D.GROUP_ID
		");  
		return $q ? $q->result_array() : array();
	}
	
	public function getSellout($CustomerAllC,$whProduk, $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu )
	{ 
	 
	if($listFilterByVal == 0){
		$sqlIn = " ";
	}else if($listFilterByVal == 1){
		$sqlIn = $listFilterSetVal == 0 ? " " : " AND  VSOTC.REGION = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 2){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND VSOTC.KD_PROVINSI = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 3){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND VSOTC.KD_DISTRIK = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 4){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND VSOTC.KD_AREA = '$listFilterSetVal' ";
	} 
	
	$tahun = '';
	$bulan = '';
	$mingguan = '';
	$dataminggu = '';
	if($filterMinggu=='ALL'){
		$tahun = $filterTahun != 'ALL' ? "  TO_CHAR( VSOTC.TGL_SPJ, 'YYYY' ) = '{$filterTahun}' " : "";
		$bulan = $filterBulan != 'ALL' ? " AND TO_CHAR( VSOTC.TGL_SPJ, 'MM' ) = '{$filterBulan}' " : ""; 
	}else{ 
		$minggu = $this->db->query("SELECT CAL.TGL FROM CALENDER_CRM CAL WHERE TO_CHAR( CAL.TANGGAL, 'YYYY' ) = '{$filterTahun}'  AND  TO_CHAR( CAL.TANGGAL, 'MM' ) = '{$filterBulan}'  AND CAL.WEEKS = '{$filterMinggu}' ORDER BY 	NUMBER_HARI ASC")->result_array(); 
		foreach($minggu as $v){
			$mingguan	 .= "'".$v['TGL']."',";
		} 
		$mingguan = rtrim($mingguan,",");
		$dataminggu = $mingguan !='' ? "  TO_CHAR( VSOTC.TGL_SPJ, 'YYYY-MM-DD' ) in ({$mingguan}) " : ''  ; 
	} 
	
		$q = $this->sell->query("	 SELECT SUM(QTY_SELL_OUT) AS JUMLAH FROM V_SELL_OUT_TO_CRM VSOTC  
				WHERE 
					( {$tahun}  {$bulan}  {$dataminggu} ) 
					{$sqlIn} 	{$CustomerAllC} AND VSOTC.KD_PRODUK in ({$whProduk})
		"); 
			 
				
		return $q ? $q->row_array() : array();
	}  
	
	
public function getSelloutNONSIG($CustomerAllC,$group_id, $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu )
	{ 
	 
	if($listFilterByVal == 0){
		$sqlIn = " ";
	}else if($listFilterByVal == 1){
		$sqlIn = $listFilterSetVal == 0 ? " " : " AND E.REGION = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 2){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND VSOTC.KD_PROVINSI = '$listFilterSetVal' ";
	} else if ($listFilterByVal == 3){
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND VSOTC.KD_DISTRIK = '$listFilterSetVal' ";
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
	
		$q = $this->db->query("	SELECT
				A.ID_TOKO,
				A.ID_PRODUK,
					(SELECT
						CHS.VOLUME_PENJUALAN 
					FROM
						CRMNEW_HASIL_SURVEY CHS 
					WHERE
						CHS.ID_TOKO = A.ID_TOKO 
						AND CHS.ID_PRODUK = A.ID_PRODUK 
						AND ( {$tahunIN}  {$bulanIN}  {$datamingguIN} ) 
						AND ROWNUM = 1  
					GROUP BY
						CHS.ID_TOKO,
						CHS.ID_PRODUK,
						VOLUME_PENJUALAN
						) AS TOTAL
				FROM
				CRMNEW_HASIL_SURVEY A
				JOIN CRMNEW_CUSTOMER VSOTC ON A.ID_TOKO = VSOTC.ID_CUSTOMER 
				JOIN CRMNEW_M_PROVINSI E ON VSOTC.ID_PROVINSI = E.ID_PROVINSI
				JOIN CRMNEW_M_DISTRIK F ON VSOTC.ID_DISTRIK = F.ID_DISTRIK 
				LEFT JOIN CRMNEW_PRODUK_SURVEY D ON A.ID_PRODUK = D.ID_PRODUK 
				JOIN CRMNEW_JENIS_PRODUK_GROUP G ON D.GROUP_ID = G.GROUP_ID
			WHERE
				( {$tahun}  {$bulan}  {$dataminggu} )   AND A.VOLUME_PENJUALAN IS NOT NULL 
				AND G.GROUP_ID = {$group_id}
				{$sqlIn} 	 AND A.ID_TOKO in ({$CustomerAllC})
			GROUP BY
				A.ID_TOKO,
				A.ID_PRODUK
		"); 
			 
				
		return $q ? $q->result_array() : array();
	}  
	public function getCustomerAll($id_user, $jenisUser, $where_bawahan)
	{ 	
		$sql ='';
		$id_user = $this->session->userdata("user_id"); 
		if( $where_bawahan != '' && $where_bawahan=='DISTRIBUTOR'){
			$q = $this->db->query("	 			
						SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR 
						JOIN CRMNEW_TOKO_WPM CTW ON CCR.ID_CUSTOMER = CTW.ID_CUSTOMER
						WHERE ID_DISTRIBUTOR IN ( 
									SELECT 
										CUD.KODE_DISTRIBUTOR AS ID_DISTRIBUTOR 
									FROM CRMNEW_USER_DISTRIBUTOR CUD
									LEFT JOIN CRMNEW_DISTRIBUTOR CD 
										ON CUD.KODE_DISTRIBUTOR = CD.KODE_DISTRIBUTOR
									WHERE CUD.ID_USER = '{$id_user}' AND CUD.DELETE_MARK = 0 
						) ");
		}else if($where_bawahan != '' && $where_bawahan=='SPC'){
			$q = $this->db->query("  
					SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER CCR
					JOIN CRMNEW_TOKO_WPM CTW ON CCR.ID_CUSTOMER = CTW.ID_CUSTOMER
					JOIN CRMNEW_M_PROVINSI CMP ON CCR.ID_PROVINSI = CMP.ID_PROVINSI
					WHERE NEW_REGION IN ( 
								SELECT 
										CUR.ID_REGION AS ID 
									FROM CRMNEW_USER_REGION CUR
									LEFT JOIN (SELECT DISTINCT(REGION_ID), REGION_NAME FROM WILAYAH_SMI ORDER BY REGION_NAME) WS
										ON CUR.ID_REGION = WS.REGION_ID
									WHERE CUR.ID_USER = '{$id_user}' AND CUR.DELETE_MARK = 0 
					)
			 ");
		}else if($where_bawahan != ''){
			$q = $this->db->query(" 
			SELECT 
				MTDS.ID_CUSTOMER 
				FROM MAPPING_TOKO_DIST_SALES MTDS
						JOIN CRMNEW_TOKO_WPM CTW ON MTDS.ID_CUSTOMER = CTW.ID_CUSTOMER
						LEFT JOIN HIRARCKY_GSM_TO_DISTRIBUTOR HGTD
								ON MTDS.ID_SALES = HGTD.ID_SALES AND MTDS.ID_DISTRIBUTOR = HGTD.KODE_DISTRIBUTOR
						LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
								ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
				WHERE 
				{$where_bawahan}    
				group by  MTDS.ID_CUSTOMER 
			 ");
		}
		else {
			$q = $this->db->query(" 
			SELECT 
				MTDS.ID_CUSTOMER 
				FROM MAPPING_TOKO_DIST_SALES MTDS
						JOIN CRMNEW_TOKO_WPM CTW ON MTDS.ID_CUSTOMER = CTW.ID_CUSTOMER
						LEFT JOIN HIRARCKY_GSM_TO_DISTRIBUTOR HGTD
								ON MTDS.ID_SALES = HGTD.ID_SALES AND MTDS.ID_DISTRIBUTOR = HGTD.KODE_DISTRIBUTOR
						LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
								ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
				  
				group by  MTDS.ID_CUSTOMER 
			 ");
		}
		
		return $q ? $q->result_array() : array();
	}  
	
	
	public function CustomerAllC($id)
	{
		$q = $this->sell->query("SELECT KD_CUSTOMER FROM V_SELL_OUT_TO_CRM  WHERE KD_CUSTOMER IN ($id)
			GROUP BY KD_CUSTOMER");
		return $q ? $q->result_array() : array();
	}  
	
	 
	public function getProdukSIDIGI($id) {
		return $this->db->query("SELECT A.KD_PRODUK, A.NM_PRODUK FROM CRMNEW_PRODUK_SIDIGI_CRM A
			JOIN CRMNEW_PRODUK_SURVEY B ON A.KD_PRODUK_SURVEY = B.ID_PRODUK
			JOIN CRMNEW_JENIS_PRODUK_GROUP C ON C.GROUP_ID = B.GROUP_ID
			WHERE C.SMI_GROUP = 'Y'  AND A.DELETE_MARK = 0	AND B.DELETE_MARK = 0 AND C.DELETE_MARK = 0
			AND C.GROUP_ID = '{$id}'
			")->result_array();
	}
	public function getKapasitasJual($CustomerAllC, $listFilterByVal, $listFilterSetVal) { 
		if($listFilterByVal == 0){
		$sqlIn = " ";
		}else if($listFilterByVal == 1){
			$sqlIn = $listFilterSetVal == 0 ? " " : " AND A.REGION = '$listFilterSetVal' ";
		} else if ($listFilterByVal == 2){
			$sqlIn = $listFilterSetVal == 0 ? " " :  " AND A.KD_PROVINSI = '$listFilterSetVal' ";
		} else if ($listFilterByVal == 3){
			$sqlIn = $listFilterSetVal == 0 ? " " :  " AND A.KD_DISTRIK = '$listFilterSetVal' ";
		} else if ($listFilterByVal == 4){
			$sqlIn = $listFilterSetVal == 0 ? " " :  " AND A.KD_AREA = '$listFilterSetVal' ";
		} 
		
		$q = $this->db->query("SELECT SUM(KAPASITAS_JUAL) AS JUMLAH FROM VIEW_DATA_TOKO_CUSTOMER A
			WHERE KAPASITAS_JUAL IS NOT NULL AND ID_CUSTOMER IN ({$CustomerAllC})");
		return  $q->row_array();
	}
	
	
	

	
	

 
}
