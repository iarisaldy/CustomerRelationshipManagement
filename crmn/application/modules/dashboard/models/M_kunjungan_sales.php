<?php

class M_kunjungan_sales Extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		
	}


	public function getMrDetail($id_mr)
	{ 
		$q = $this->db->query("SELECT * FROM CRMNEW_MR_DETAIL
				WHERE DELETE_MARK = 0 AND ID_MR = {$id_mr}
				ORDER BY  NO_DETAIL ASC
		"); 
				
		return $q ? $q->result_array() : array();
	}
	
	public function getTotal($id_detail, $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan )
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
		$sqlIn = $listFilterSetVal == 0 ? " " :  " AND C.KD_AREA = '$listFilterSetVal' ";
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
		$bawahan = "	AND C.ID_CUSTOMER IN (			
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
		$bawahan = " AND C.ID_CUSTOMER IN (
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
		$bawahan = "AND C.ID_CUSTOMER IN (
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
		$q = $this->db->query("	 SELECT DISTINCT(TTD.ID_KUNJUNGAN) FROM CRMNEW_TOKO_TIDAK_DIKUNJUNGI TTD
				JOIN CRMNEW_MR_DETAIL MD ON TTD.NO_MR_DETAIL = MD.NO_DETAIL
				JOIN CRMNEW_MASTER_REASON MR ON MD.ID_MR = MR.ID_MR
				JOIN CRMNEW_KUNJUNGAN_CUSTOMER A ON TTD.ID_KUNJUNGAN = A.ID_KUNJUNGAN_CUSTOMER
				JOIN CRMNEW_CUSTOMER C ON A.ID_TOKO = C.ID_CUSTOMER
				JOIN CRMNEW_M_PROVINSI E ON C.ID_PROVINSI = E.ID_PROVINSI
				JOIN CRMNEW_M_DISTRIK F ON C.ID_DISTRIK = F.ID_DISTRIK 
				WHERE 
					( {$tahun}  {$bulan}  {$dataminggu} ) 
					AND TTD.DELETE_MARK = 0 AND MD.DELETE_MARK = 0 AND MR.DELETE_MARK = 0
					AND TTD.NO_MR_DETAIL = {$id_detail} 
					{$sqlIn}
					{$bawahan}
		"); 
			 
				
		return $q ? $q->result_array() : array();
	}  
	public function getPeserta($id_gelombang, $id_cabang)
	{ 	
		$cabang = ($id_cabang=='all' || $id_cabang=='' ? '' :" and mc.id_cabang = {$id_cabang}"); 
		$gelombang = ($id_gelombang==''  ? '' :" and a.id_gelombang = {$id_gelombang}  ");  
		$q = $this->db->query("SELECT
					a.id,
					a.status,
				mc.*, d.*, mp.id as id_position, mp.name	
				FROM
					pendaftaran a
					JOIN gelombang b ON a.id_gelombang = b.id
					JOIN m_user c ON a.id_user = c.id  
					LEFT JOIN detail_kegiatan d ON d.id_detail_kegiatan=a.id_detail_kegiatan
					LEFT JOIN m_kegiatan k ON k.id_kegiatan=d.id_kegiatan 
					LEFT JOIN m_cabang mc ON mc.id_cabang=k.id_cabang
					JOIN m_position mp ON d.id_position = mp.id 
				WHERE
					 a.is_delete = 0 {$cabang} {$gelombang} 
					 ");
		return $q ? $q->result_array() : array();
	}  
	
	public function cekNilai($id)
	{
		$q = $this->db->query("select nl.*, ttd.id as id_ttd, jt.* from test_transaction tt
			join pendaftaran pd on tt.id_pendaftaran = pd.id
			 join nilai nl on tt.id = nl.id_test_transaction
			 join test_transaction_detail ttd on tt.id_test_transaction_detail = ttd.id
			 join m_jenis_tes jt on ttd.id_jenis_test = jt.id_jenis 
			where tt.id_pendaftaran = {$id}
			order by nl.id asc");
		return $q ? $q->result_array() : array();
	}  
	
	 
	public function get_gelombang() {
		return $this->db->query("SELECT
				a.*,
				b.nm_cabang,
				c.*,
				begda,
				endda 
			FROM
				m_kegiatan a
				JOIN m_cabang b ON a.id_cabang = b.id_cabang
				JOIN gelombang c ON a.id_gelombang = c.id 
			WHERE
				is_delete = 0 
			ORDER BY
				a.id_kegiatan DESC")->result_array();
	}
	public function get_cabang($id_gelombang) {
		if($id_gelombang == 'all' ||  $id_gelombang == ''){
			$gelombang = "";
		}else{
			$gelombang = "  AND k.id_gelombang={$id_gelombang}";
		}
		$q = $this->db->query("SELECT c.* FROM m_kegiatan k LEFT JOIN m_cabang c ON c.id_cabang=k.id_cabang WHERE c.id_cabang IS NOT NULL and k.is_delete = 0  {$gelombang}");
		return $q ? $q->result_array() : array();
	}
	
	public function get_Posisi($id) {
		return $this->db->query("SELECT * FROM m_position where id in ({$id})")->result_array();
	}
	
	

	
	

 
}
