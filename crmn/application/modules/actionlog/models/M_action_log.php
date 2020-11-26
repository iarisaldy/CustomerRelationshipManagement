<?php

class M_action_log Extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_data($s, $p, $e, $c, $o, $id_user, $jenisUser)
	{
		  $where_bawahan = '';
		if($jenisUser=='1016'){
			$where_bawahan = "(
			CREATE_BY IN (
		SELECT
			CUR.ID_USER AS ID 
		FROM
			CRMNEW_USER_RSM CUR
			LEFT JOIN CRMNEW_USER CUSS ON CUR.ID_USER = CUSS.ID_USER 
		WHERE
			CUR.ID_RSM IN (
			SELECT
				CUG.ID_USER AS ID 
			FROM
				CRMNEW_USER_GSM CUGSM
				LEFT JOIN CRMNEW_USER CUG ON CUGSM.ID_USER = CUG.ID_USER 
			WHERE
				CUGSM.ID_GSM = '{$id_user}' 
				AND CUGSM.DELETE_MARK = 0 
			) 
			AND CUR.DELETE_MARK = 0  
		)   OR
		CREATE_BY IN
		(
			SELECT
				CUA.ID_USER AS ID 
			FROM
				CRMNEW_USER_ASM CUA
				LEFT JOIN CRMNEW_USER CUS ON CUA.ID_USER = CUS.ID_USER 
			WHERE
				CUA.ID_ASM IN (
				SELECT
					CUR.ID_USER AS ID 
				FROM
					CRMNEW_USER_RSM CUR
					LEFT JOIN CRMNEW_USER CUSS ON CUR.ID_USER = CUSS.ID_USER 
				WHERE
					CUR.ID_RSM IN (
					SELECT
						CUG.ID_USER AS ID 
					FROM
						CRMNEW_USER_GSM CUGSM
						LEFT JOIN CRMNEW_USER CUG ON CUGSM.ID_USER = CUG.ID_USER 
					WHERE
						CUGSM.ID_GSM = '{$id_user}' 
						AND CUGSM.DELETE_MARK = 0 
					) 
					AND CUR.DELETE_MARK = 0 
				) 
				AND CUA.DELETE_MARK = 0 
			) 
		)";
		}else if($jenisUser=='1010'){
			$where_bawahan = " (CREATE_BY IN (SELECT 
						CUR.ID_USER AS ID 
					FROM CRMNEW_USER_RSM CUR
					LEFT JOIN CRMNEW_USER CUSS 
						ON CUR.ID_USER = CUSS.ID_USER
					WHERE CUR.ID_RSM= {$id_user} AND CUR.DELETE_MARK = 0 ) 
				OR 
				CREATE_BY IN (SELECT 
					CUA.ID_USER AS ID 
				FROM CRMNEW_USER_ASM CUA
				LEFT JOIN CRMNEW_USER CUS 
					ON CUA.ID_USER = CUS.ID_USER
				WHERE CUA.ID_ASM IN (
					SELECT 
						CUR.ID_USER AS ID 
					FROM CRMNEW_USER_RSM CUR
					LEFT JOIN CRMNEW_USER CUSS 
						ON CUR.ID_USER = CUSS.ID_USER
					WHERE CUR.ID_RSM= {$id_user} AND CUR.DELETE_MARK = 0 
				) AND CUA.DELETE_MARK = 0 
			)) ";
		}else if($jenisUser=='1011'){
			$where_bawahan = " (CREATE_BY = '{$id_user}' OR CREATE_BY IN (SELECT 
					CUA.ID_USER AS ID 
				FROM CRMNEW_USER_ASM CUA
				LEFT JOIN CRMNEW_USER CUS 
					ON CUA.ID_USER = CUS.ID_USER
				WHERE CUA.ID_ASM = '{$id_user}' AND CUA.DELETE_MARK = 0) ) ";
		}else if($jenisUser=='1012'){
			$where_bawahan = " CREATE_BY = '{$id_user}'";
		}
		$q1 = $this->db->query("SELECT COUNT(*) AS total FROM CRMNEW_ACTION_LOG WHERE {$where_bawahan} AND DELETE_MARK = 0")->result_array();
		$r1 = isset($q1[0]["total"]) ? $q1[0]["total"] : 0;
		
		$q2 = $this->db->query("SELECT COUNT(*) AS filtered FROM CRMNEW_ACTION_LOG  WHERE {$where_bawahan} AND (ISU  LIKE '%{$s}%' OR TANGGAL LIKE '%{$s}%' OR SOLUSI LIKE '%{$s}%' OR PROGRESS LIKE '%{$s}%' OR STATUS LIKE '%{$s}%') AND DELETE_MARK = 0")->result_array();
		$r2 = isset($q2[0]["filtered"]) ? $q2[0]["filtered"] : 0;
		
		$q3 = $this->db->query("SELECT A.*, TO_CHAR(A.TANGGAL, 'DD-MM-YYYY') AS DATELINE, TO_CHAR(A.CREATE_DATE, 'DD-MM-YYYY') AS TANGGAL_BUAT FROM CRMNEW_ACTION_LOG A  WHERE {$where_bawahan} AND (A.ISU  LIKE '%{$s}%' OR A.TANGGAL LIKE '%{$s}%' OR A.SOLUSI LIKE '%{$s}%' OR A.PROGRESS LIKE '%{$s}%' OR A.STATUS LIKE '%{$s}%') AND ROWNUM >= {$p} AND ROWNUM <= {$e} AND DELETE_MARK = 0  ORDER BY {$o[0]} {$o[1]} ");
		$r3 = $q3 ? $q3->result_array() : array();
		
		return array(
			"total"		=> $r1,
			"filtered"	=> $r2,
			"data"		=> $r3
		);
	}

	public function dataExport($id_user, $jenisUser)
	{
		  $where_bawahan = '';
		if($jenisUser=='1016'){
			$where_bawahan = "(
			CREATE_BY IN (
		SELECT
			CUR.ID_USER AS ID 
		FROM
			CRMNEW_USER_RSM CUR
			LEFT JOIN CRMNEW_USER CUSS ON CUR.ID_USER = CUSS.ID_USER 
		WHERE
			CUR.ID_RSM IN (
			SELECT
				CUG.ID_USER AS ID 
			FROM
				CRMNEW_USER_GSM CUGSM
				LEFT JOIN CRMNEW_USER CUG ON CUGSM.ID_USER = CUG.ID_USER 
			WHERE
				CUGSM.ID_GSM = '{$id_user}' 
				AND CUGSM.DELETE_MARK = 0 
			) 
			AND CUR.DELETE_MARK = 0  
		)   OR
		CREATE_BY IN
		(
			SELECT
				CUA.ID_USER AS ID 
			FROM
				CRMNEW_USER_ASM CUA
				LEFT JOIN CRMNEW_USER CUS ON CUA.ID_USER = CUS.ID_USER 
			WHERE
				CUA.ID_ASM IN (
				SELECT
					CUR.ID_USER AS ID 
				FROM
					CRMNEW_USER_RSM CUR
					LEFT JOIN CRMNEW_USER CUSS ON CUR.ID_USER = CUSS.ID_USER 
				WHERE
					CUR.ID_RSM IN (
					SELECT
						CUG.ID_USER AS ID 
					FROM
						CRMNEW_USER_GSM CUGSM
						LEFT JOIN CRMNEW_USER CUG ON CUGSM.ID_USER = CUG.ID_USER 
					WHERE
						CUGSM.ID_GSM = '{$id_user}' 
						AND CUGSM.DELETE_MARK = 0 
					) 
					AND CUR.DELETE_MARK = 0 
				) 
				AND CUA.DELETE_MARK = 0 
			) 
		)";
		}else if($jenisUser=='1010'){
			$where_bawahan = " (CREATE_BY IN (SELECT 
						CUR.ID_USER AS ID 
					FROM CRMNEW_USER_RSM CUR
					LEFT JOIN CRMNEW_USER CUSS 
						ON CUR.ID_USER = CUSS.ID_USER
					WHERE CUR.ID_RSM= {$id_user} AND CUR.DELETE_MARK = 0 ) 
			OR
			CREATE_BY IN (SELECT 
					CUA.ID_USER AS ID 
				FROM CRMNEW_USER_ASM CUA
				LEFT JOIN CRMNEW_USER CUS 
					ON CUA.ID_USER = CUS.ID_USER
				WHERE CUA.ID_ASM IN (
					SELECT 
						CUR.ID_USER AS ID 
					FROM CRMNEW_USER_RSM CUR
					LEFT JOIN CRMNEW_USER CUSS 
						ON CUR.ID_USER = CUSS.ID_USER
					WHERE CUR.ID_RSM= {$id_user} AND CUR.DELETE_MARK = 0 
				) AND CUA.DELETE_MARK = 0 
	)) ";
		}else if($jenisUser=='1011'){
			$where_bawahan = " (CREATE_BY = '{$id_user}' OR CREATE_BY IN (SELECT 
					CUA.ID_USER AS ID 
				FROM CRMNEW_USER_ASM CUA
				LEFT JOIN CRMNEW_USER CUS 
					ON CUA.ID_USER = CUS.ID_USER
				WHERE CUA.ID_ASM = '{$id_user}' AND CUA.DELETE_MARK = 0) ) ";
		}else if($jenisUser=='1012'){
			$where_bawahan = " CREATE_BY = '{$id_user}'";
		}
		return $this->db->query("SELECT A.*, TO_CHAR(A.TANGGAL, 'DD-MM-YYYY') AS DATELINE, TO_CHAR(A.CREATE_DATE, 'DD-MM-YYYY') AS TANGGAL_BUAT, CU.NAMA  FROM CRMNEW_ACTION_LOG A 
	JOIN CRMNEW_USER CU ON A.CREATE_BY = CU.ID_USER WHERE {$where_bawahan} AND DELETE_MARK = 0  ")->result_array();
	}

	public function simpan($column, $data)
	{
		  
		return $this->db->query("INSERT INTO CRMNEW_ACTION_LOG (".implode(",", $column).") VALUES (".implode(",", $data).")");
	}

	public function update($id, $data)
	{
		return $this->db->query("UPDATE CRMNEW_ACTION_LOG SET ".implode(",", $data)." WHERE ID_ACTION_LOG={$id}");
	}

	public function approve($id, $status)
	{
		return $this->db->query("UPDATE CRMNEW_ACTION_LOG SET STATUS = {$status} WHERE ID_ACTION_LOG={$id}");
	}
	public function hapus($id)
	{
		return $this->db->query("UPDATE CRMNEW_ACTION_LOG SET DELETE_MARK = 1 WHERE ID_ACTION_LOG={$id}");
	}


 
}
