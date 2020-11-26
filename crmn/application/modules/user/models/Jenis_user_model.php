<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Jenis_user_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	public function get_jenis_user($id_jenis = null){
		$sql = "
			SELECT * FROM CRMNEW_JENIS_USER 
			WHERE DELETED_MARK = 0
		";
		if($id_jenis != null){
			$sql .= " AND ID_JENIS_USER = '$id_jenis' ";
		}
		$sql .= " order by level_user asc ";
		return $this->db->query($sql)->result();
	}
	
	public function set_Jenis_user($id_jenis, $jenis_user){
		$hasil = false;
		if($id_jenis != '0000'){
			$sqlUp = "
				UPDATE CRMNEW_JENIS_USER
				SET 
					JENIS_USER = '$jenis_user',
					UPDATED_BY = '1000',
					UPDATED_AT = SYSDATE
				WHERE ID_JENIS_USER = '$id_jenis'
			";
			$this->db->query($sqlUp);
			$hasil = true;
		} else {
			$setId = "(SELECT MAX(ID_JENIS_USER)+1 FROM CRMNEW_JENIS_USER)";
			
			$sqlIn = "
				INSERT INTO CRMNEW_JENIS_USER (ID_JENIS_USER, JENIS_USER, CREATED_BY, CREATED_AT, DELETED_MARK)
				VALUES 
				($setId, '$jenis_user', '1000', SYSDATE, 0)
			";
			$this->db->query($sqlIn);
			$hasil = true;
		}
		return $hasil;
	}
	
	public function del_Jenis_user($id_jenis){
		$sqlFirst = "
			UPDATE CRMNEW_JENIS_USER
			SET 
				DELETED_MARK = 1
			WHERE ID_JENIS_USER = '$id_jenis'
		";
		$hasil = $this->db->query($sqlFirst);
		return $hasil;
	}

}