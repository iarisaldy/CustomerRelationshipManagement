<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

class M_target_selling_out extends CI_Model {
	
	var $table = 'CRMNEW_RADIUS_AREA';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_data($s, $p, $e, $c, $o)
	{
		$month = date('m');
		$q1 = $this->db->query("SELECT COUNT(*) AS TOTAL FROM CRMNEW_TARGET_SELLING_OUT WHERE DELETED_MARK='0'")->result_array();
		$r1 = isset($q1[0]["TOTAL"]) ? $q1[0]["TOTAL"] : 0;
		
		$q2 = $this->db->query("SELECT COUNT(*) AS FILTERED FROM CRMNEW_TARGET_SELLING_OUT WHERE (VOLUME LIKE '%{$s}%' OR REVENUE LIKE '%{$s}%' OR CA LIKE '%{$s}%' OR VISIT LIKE '%{$s}%' OR NOO LIKE '%{$s}%' OR MARKET_SHARE LIKE '%{$s}%') AND DELETED_MARK='0'")->result_array();
		$r2 = isset($q2[0]["FILTERED"]) ? $q2[0]["FILTERED"] : 0;
		
		$q3 = $this->db->query("		 
				SELECT * FROM (
				SELECT a.*, ROWNUM rnum FROM (
					SELECT TSO.*, U.NAMA AS NAMA_USER, (SELECT SUM(TARGET) FROM VISIT_SALES_DISTRIBUTOR WHERE BULAN = '{$month}') AS VISIT_TARGET FROM CRMNEW_TARGET_SELLING_OUT TSO LEFT JOIN CRMNEW_USER U ON TSO.AM = U.ID_USER WHERE (TSO.VOLUME LIKE '%{$s}%' OR TSO.REVENUE LIKE '%{$s}%' OR TSO.CA LIKE '%{$s}%' OR TSO.VISIT LIKE '%{$s}%' OR TSO.NOO LIKE '%{$s}%' OR TSO.MARKET_SHARE LIKE '%{$s}%') AND TSO.DELETED_MARK='0' ORDER BY {$o[0]} {$o[1]}
				) a WHERE ROWNUM <= {$e}
				) WHERE rnum >= {$p}
			");
		$r3 = $q3 ? $q3->result_array() : array();
		
		return array(
			"total"		=> $r1,
			"filtered"	=> $r2,
			"data"		=> $r3
		);
	}
	
	public function get_data_salesman($s, $p, $e, $c, $o, $id_user, $id_jenis_user){
		
		$param_user = "";
		if ($id_jenis_user == '1012') {
			$param_user = "ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "ID_GSM = '$id_user'";
		}

        $sql = "
        	SELECT
				DISTINCT(ID_SO) AS ID_SO
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE
				$param_user
        ";

        $res = $this->db->query($sql)->result_array();

    	$kd_so = '';
    	$so = '';
    	$so_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['ID_SO'])) {
	        		$kd_so .= "'" . $v['ID_SO'] . "',";

	        	}
	        }

	        $so = substr_replace($kd_so, '', -1);
        	$so_in = "AND CREATE_BY IN ($so)";
	        
    	}

		// print_r('<pre>');
		// print_r($so_in);exit;

		$month = date('m');
		$q1 = $this->db->query("SELECT COUNT(*) AS TOTAL FROM CRMNEW_TARGET_SELLING_OUT_S WHERE DELETED_MARK='0'")->result_array();
		$r1 = isset($q1[0]["TOTAL"]) ? $q1[0]["TOTAL"] : 0;
		
		$q2 = $this->db->query("SELECT COUNT(*) AS FILTERED FROM CRMNEW_TARGET_SELLING_OUT_S TSOS LEFT JOIN CRMNEW_USER CU ON TSOS.ID_SALES = CU.ID_USER WHERE CU.NAMA LIKE '%{$s}%' AND TSOS.DELETED_MARK='0'")->result_array();
		$r2 = isset($q2[0]["FILTERED"]) ? $q2[0]["FILTERED"] : 0;
		
		$q3 = $this->db->query("		 
				SELECT * FROM (
				SELECT ROWNUM ID, a.*, ROWNUM rnum FROM (
					SELECT TSOS.ID_SALES,
						TSOS.TAHUN,
						TSOS.BULAN,
						SUM(NVL(TSOS.TOKO_UNIT, 0)) AS TOKO_UNIT,
						SUM(NVL(TSOS.TOKO_AKTIF, 0)) AS TOKO_AKTIF,
						SUM(NVL(TSOS.TOKO_BARU, 0)) AS TOKO_BARU,
						SUM(NVL(TSOS.SELL_OUT_SDG, 0)) AS SELL_OUT_SDG,
						SUM(NVL(TSOS.SELL_OUT_BK, 0)) AS SELL_OUT_BK, CU.NAMA AS NAMA_USER, (SELECT SUM(TARGET) FROM VISIT_SALES_DISTRIBUTOR WHERE BULAN = '{$month}') AS VISIT_TARGET FROM CRMNEW_TARGET_SELLING_OUT_S TSOS LEFT JOIN CRMNEW_USER CU ON TSOS.ID_SALES = CU.ID_USER WHERE CU.NAMA LIKE '%{$s}%' AND TSOS.DELETED_MARK='0' $so_in GROUP BY TSOS.ID_SALES, TSOS.TAHUN, TSOS.BULAN, CU.NAMA ORDER BY TSOS.ID_SALES, TSOS.TAHUN DESC, TSOS.BULAN DESC 
				) a WHERE ROWNUM <= {$e}
				) WHERE rnum >= {$p}
			");
		$r3 = $q3 ? $q3->result_array() : array();
		
		return array(
			"total"		=> $r1,
			"filtered"	=> $r2,
			"data"		=> $r3
		);
	}
	
	public function get_data_distributor($s, $p, $e, $c, $o, $id_user, $id_jenis_user){
		
		$param_user = "";
		if ($id_jenis_user == '1012') {
			$param_user = "ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "ID_GSM = '$id_user'";
		}

        $sql = "
        	SELECT
				DISTINCT(ID_SO) AS ID_SO
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE
				$param_user
        ";

        $res = $this->db->query($sql)->result_array();

    	$kd_so = '';
    	$so = '';
    	$so_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['ID_SO'])) {
	        		$kd_so .= "'" . $v['ID_SO'] . "',";

	        	}
	        }

	        $so = substr_replace($kd_so, '', -1);
        	$so_in = "AND CREATE_BY IN ($so)";
	        
    	}

		$q1 = $this->db->query("SELECT COUNT(*) AS TOTAL FROM CRMNEW_TARGET_SELLING_OUT_D WHERE DELETED_MARK='0'")->result_array();
		$r1 = isset($q1[0]["TOTAL"]) ? $q1[0]["TOTAL"] : 0;
		
		$q2 = $this->db->query("SELECT COUNT(*) AS FILTERED FROM CRMNEW_TARGET_SELLING_OUT_D TSOD LEFT JOIN CRMNEW_DISTRIBUTOR CD ON TSOD.KD_DISTRIBUTOR = CD.KODE_DISTRIBUTOR WHERE CD.NAMA_DISTRIBUTOR LIKE '%{$s}%' AND TSOD.DELETED_MARK='0' AND CD.DELETE_MARK='0'")->result_array();
		$r2 = isset($q2[0]["FILTERED"]) ? $q2[0]["FILTERED"] : 0;
		
		$q3 = $this->db->query("		 
				SELECT * FROM (
				SELECT ROWNUM ID, a.*, ROWNUM rnum FROM (
					SELECT 
						TSOD.KD_DISTRIBUTOR,
						TSOD.TAHUN,
						TSOD.BULAN,
						SUM(NVL(TSOD.TOKO_UNIT, 0)) AS TOKO_UNIT,
						SUM(NVL(TSOD.TOKO_AKTIF, 0)) AS TOKO_AKTIF,
						SUM(NVL(TSOD.SO_CLEAN_CLEAR, 0)) AS SO_CLEAN_CLEAR,
						SUM(NVL(TSOD.VOLUME, 0)) AS VOLUME,
						SUM(NVL(TSOD.REVENUE, 0)) AS REVENUE,
						SUM(NVL(TSOD.SELL_OUT, 0)) AS SELL_OUT,
						CD.NAMA_DISTRIBUTOR AS NM_DISTRIBUTOR FROM CRMNEW_TARGET_SELLING_OUT_D TSOD
						LEFT JOIN CRMNEW_DISTRIBUTOR CD ON TSOD.KD_DISTRIBUTOR = CD.KODE_DISTRIBUTOR WHERE CD.NAMA_DISTRIBUTOR LIKE '%{$s}%' AND TSOD.DELETED_MARK='0' AND CD.DELETE_MARK='0' $so_in GROUP BY
														TSOD.KD_DISTRIBUTOR,
														TSOD.TAHUN,
														TSOD.BULAN,
														CD.NAMA_DISTRIBUTOR
													ORDER BY
														CD.NAMA_DISTRIBUTOR,
														TSOD.TAHUN DESC,
														TSOD.BULAN DESC 
				) a WHERE ROWNUM <= {$e}
				) WHERE rnum >= {$p}
			");
		$r3 = $q3 ? $q3->result_array() : array();
		
		return array(
			"total"		=> $r1,
			"filtered"	=> $r2,
			"data"		=> $r3
		);
	}
	
	public function getSO($id_jenis_user){
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
		
		$sql = "
			SELECT  
				CU.ID_USER, CU.NAMA, CU.USERNAME, CU.PASSWORD, CU.ID_JENIS_USER, CU.EMAIL, CMHU.ID_ATASAN_LANGSUNG, 
				(SELECT NAMA FROM CRMNEW_USER WHERE ID_USER = CMHU.ID_ATASAN_LANGSUNG) AS ATASAN, CMHU.CAKUPAN_WILAYAH
				$sqlCekAtas
			FROM CRMNEW_USER CU
			LEFT JOIN CRMNEW_MAPPING_HIERARKI_USER CMHU
				ON CU.ID_USER = CMHU.USER_ID AND CMHU.DELETE_MARK IS NULL
			WHERE (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK != 1) OR (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK IS NULL)
			ORDER BY CU.NAMA ASC
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function getSalesman($id_jenis_user, $id_user){
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
		// 	SELECT  
		// 		CU.ID_USER, UPPER(CU.NAMA) AS NAMA, CU.USERNAME, CU.PASSWORD, CU.ID_JENIS_USER, CU.EMAIL, CMHU.ID_ATASAN_LANGSUNG, 
		// 		(SELECT NAMA FROM CRMNEW_USER WHERE ID_USER = CMHU.ID_ATASAN_LANGSUNG) AS ATASAN, CMHU.CAKUPAN_WILAYAH
		// 		$sqlCekAtas
		// 	FROM CRMNEW_USER CU
		// 	LEFT JOIN CRMNEW_MAPPING_HIERARKI_USER CMHU
		// 		ON CU.ID_USER = CMHU.USER_ID AND CMHU.DELETE_MARK IS NULL
		// 	WHERE (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK != 1) OR (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK IS NULL)
		// 	ORDER BY CU.NAMA ASC
		// ";

		
		$sql = "
			SELECT
				HR.ID_SALES AS ID_USER,
				UPPER(CU.NAMA) AS NAMA
			FROM
				(
				SELECT
					DISTINCT(ID_SALES) AS ID_SALES
				FROM
					HIRARCKY_GSM_SALES_DISTRIK
				WHERE
					ID_SO = '$id_user') HR
			LEFT JOIN CRMNEW_USER CU ON
				HR.ID_SALES = CU.ID_USER
			ORDER BY
				CU.NAMA
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function getDistributor($id_jenis_user, $id_user){
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
		// 	SELECT  
		// 		KODE_DISTRIBUTOR, UPPER(NAMA_DISTRIBUTOR) AS NAMA_DISTRIBUTOR
		// 	FROM CRMNEW_DISTRIBUTOR
		// 	WHERE DELETE_MARK ='0'
		// 	ORDER BY NAMA_DISTRIBUTOR ASC
		// ";
		
		$sql = "
			SELECT
				HR.KODE_DISTRIBUTOR,
				UPPER(CU.NAMA_DISTRIBUTOR) AS NAMA_DISTRIBUTOR
			FROM
				(
				SELECT
					DISTINCT(KODE_DISTRIBUTOR) AS KODE_DISTRIBUTOR
				FROM
					HIRARCKY_GSM_SALES_DISTRIK
				WHERE
					ID_SO = '$id_user') HR
			LEFT JOIN CRMNEW_DISTRIBUTOR CU ON
				HR.KODE_DISTRIBUTOR = CU.KODE_DISTRIBUTOR
			ORDER BY
				CU.NAMA_DISTRIBUTOR
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function simpan($column, $data)
	{
		return $this->db->query("INSERT INTO CRMNEW_TARGET_SELLING_OUT (".implode(",", $column).") VALUES (".implode(",", $data).")");
		
	}
	
	public function simpan_salesman($column, $data)
	{
		// print_r('pre>');
  //       print_r($data);exit;
		return $this->db->query("INSERT INTO CRMNEW_TARGET_SELLING_OUT_S (".implode(",", $column).") VALUES (".implode(",", $data).")");
		
	}

	public function simpan_distributor($column, $data)
	{
		return $this->db->query("INSERT INTO CRMNEW_TARGET_SELLING_OUT_D (".implode(",", $column).") VALUES (".implode(",", $data).")");
		
	}

	public function update($id, $data)
	{
		return $this->db->query("UPDATE CRMNEW_TARGET_SELLING_OUT SET ".implode(",", $data)." WHERE id={$id}");
	}

	public function update_distributor($data, $id_user, $id, $thn, $bln)
	{
		return $this->db->query("UPDATE CRMNEW_TARGET_SELLING_OUT_D SET ".implode(",", $data)." WHERE KD_DISTRIBUTOR={$id} AND CREATE_BY = '$id_user' AND DELETED_MARK = '0' AND TAHUN = '$thn' AND BULAN = '$bln'");
	}

	public function update_salesman($data, $id_user, $id, $thn, $bln)
	{
		return $this->db->query("UPDATE CRMNEW_TARGET_SELLING_OUT_S SET ".implode(",", $data)." WHERE ID_SALES={$id} AND CREATE_BY = '$id_user' AND DELETED_MARK = '0' AND TAHUN = '$thn' AND BULAN = '$bln'");
	}
	
	public function hapus($id)
	{
		return $this->db->query("UPDATE CRMNEW_TARGET_SELLING_OUT SET DELETED_MARK = '1' WHERE id={$id}");
	}

	public function hapus_salesman($id, $id_user)
	{
		return $this->db->query("UPDATE CRMNEW_TARGET_SELLING_OUT_S SET DELETED_MARK = '1' WHERE ID_SALES={$id} AND CREATE_BY = '$id_user'");
	}
	
	public function hapus_distributor($id, $id_user)
	{
		return $this->db->query("UPDATE CRMNEW_TARGET_SELLING_OUT_D SET DELETED_MARK = '1' WHERE KD_DISTRIBUTOR={$id} AND CREATE_BY = '$id_user'");
	}
	
	
	public function cek_ada($so, $id=null)
	{
		$i = $id == null ? "" : " AND id != {$id}";
		$q = $this->db->query("SELECT * FROM CRMNEW_TARGET_SELLING_OUT WHERE AM='{$so}' {$i} AND DELETED_MARK=0");
		return $q ? $q->num_rows() : 0;
	}
	
	public function cek_ada_salesman($sales, $id_user, $tahun ,$bulan){

		$by = "AND CREATE_BY = '$id_user'";
		// $i = $id == null ? "" : " AND id != {$id}";
		$q = $this->db->query("SELECT * FROM CRMNEW_TARGET_SELLING_OUT_S WHERE ID_SALES='{$sales}' $by AND DELETED_MARK = '0' AND TAHUN = '$tahun' AND BULAN = '$bulan'");
		return $q ? $q->num_rows() : 0;
	}
	public function cek_ada_distributor($dist, $id_user, $tahun ,$bulan){

		$by = "AND CREATE_BY = '$id_user'";
		// $i = $id == null ? "" : " AND id != {$id}";
		$q = $this->db->query("SELECT * FROM CRMNEW_TARGET_SELLING_OUT_D WHERE KD_DISTRIBUTOR='{$dist}' $by AND DELETED_MARK = '0' AND TAHUN = '$tahun' AND BULAN = '$bulan'");
		return $q ? $q->num_rows() : 0;
	}
	
}