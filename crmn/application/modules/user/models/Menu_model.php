<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Menu_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	public function set_menu($id_menu, $nama_menu, $icon, $link, $order){
		$hasil = false;
		if($id_menu != '0000'){
			$sqlUp = "
				UPDATE CRMNEW_MENU
				SET 
					NAMA_MENU = '$nama_menu',
					LINK = '$link',
					ICON = '$icon',
					ORDER_MENU = '$order',
					UPDATED_BY = '1009',
					UPDATED_AT = SYSDATE
				WHERE ID_MENU = '$id_menu'
			";
			$this->db->query($sqlUp);
			$hasil = true;
		} else {
			$sqlIn = "
				INSERT INTO CRMNEW_MENU (NAMA_MENU, LINK, ICON, ORDER_MENU, CREATED_BY, CREATED_AT, DELETED_MARK)
				VALUES 
				('$nama_menu', '$link', '$icon', '$order', '1009', SYSDATE, 0)
			";
			$this->db->query($sqlIn);
			$hasil = true;
		}
		return $hasil;
	}
	
	public function get_menu($id_menu = null){
		$sql = "
			SELECT * FROM CRMNEW_MENU 
			WHERE DELETED_MARK = 0
		";
		if($id_menu != null){
			$sql .= " AND ID_MENU = '$id_menu' ";
		}
		$sql .= " order by nama_menu asc ";
		return $this->db->query($sql)->result_array();
	}
	
	public function del_menu($id_menu){
		$sqlFirst = "
			UPDATE CRMNEW_MENU
			SET 
				DELETED_MARK = 1
			WHERE ID_MENU = '$id_menu'
		";
		$hasil = $this->db->query($sqlFirst);
		return $hasil;
	}
	
	// ------------------------------------------------------------------------------- >> SUB MENU
	
	public function set_submenu($id_menu, $id_submenu, $nama_menu, $icon, $link, $order){
		$hasil = false;
		if($id_submenu != '0000'){
			$sqlUp = "
				UPDATE CRMNEW_SUBMENU
				SET 
					NAMA_MENU = '$nama_menu',
					LINK = '$link',
					ICON = '$icon',
					ORDER_MENU = '$order',
					UPDATED_BY = '1009',
					UPDATED_AT = SYSDATE
				WHERE ID_SUBMENU = '$id_submenu' AND ID_MENU = '$id_menu'
			";
			$this->db->query($sqlUp);
			$hasil = true;
		} else {
			$sqlIn = "
				INSERT INTO CRMNEW_SUBMENU (ID_MENU, NAMA_MENU, LINK, ICON, ORDER_MENU, CREATED_BY, CREATED_AT, DELETED_MARK)
				VALUES 
				('$id_menu', '$nama_menu', '$link', '$icon', '$order', '1009', SYSDATE, 0)
			";
			$this->db->query($sqlIn);
			$hasil = true;
		}
		return $hasil;
	}
	
	public function del_submenu($id_menu, $id_submenu){
		$sqlFirst = "
			UPDATE CRMNEW_SUBMENU
			SET 
				DELETED_MARK = 1
			WHERE ID_MENU = '$id_menu' AND ID_SUBMENU = '$id_submenu'
		";
		$hasil = $this->db->query($sqlFirst);
		return $hasil;
	}
	
	public function get_submenu($id_menu = null){
		$sql = "
			SELECT ID_SUBMENU, NAMA_MENU AS NAMA_SUBMENU, LINK AS LINK_SUB, ICON AS ICON_SUB, ORDER_MENU AS ORDER_SUB
			FROM CRMNEW_SUBMENU 
			WHERE DELETED_MARK = 0
		";
		if($id_menu != null){
			$sql .= " AND ID_MENU = '$id_menu' ";
		}
		$sql .= " order by ORDER_MENU asc ";
		return $this->db->query($sql)->result_array();
	}
	
	// ------------------------------------------------------------------------------- >> AKSES MENU
	
	public function get_jenis_user($id_j_user = null){
		$sql = "
			SELECT * FROM CRMNEW_JENIS_USER 
			WHERE DELETED_MARK = 0
		";
		if($id_j_user != null){
			$sql .= " AND ID_JENIS_USER = '$id_j_user' ";
		}
		$sql .= " order by level_user asc ";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_akses_menu($id_j_user = null){
		$sql = "
			SELECT CUA.ID_JENIS_USER, CJU.JENIS_USER, CUA.ID_MENU, CM.NAMA_MENU 
			FROM CRMNEW_USER_AKSES CUA
				LEFT JOIN CRMNEW_JENIS_USER CJU
					ON CJU.ID_JENIS_USER = CUA.ID_JENIS_USER AND CJU.DELETED_MARK = 0
				LEFT JOIN CRMNEW_MENU CM
					ON CUA.ID_MENU = CM.ID_MENU
			WHERE CUA.DELETED_MARK = 0
		";
		if($id_j_user != null){
			$sql .= " AND CUA.ID_JENIS_USER = '$id_j_user' ";
		}
		$sql .= " ORDER BY cju.level_user asc, CUA.ID_MENU asc ";
		return $this->db->query($sql)->result_array();
	}
	
	public function set_AksesMenu($actIn_or_Del ,$id_j_user, $id_menu){
		$sqlIn = "
			INSERT INTO CRMNEW_USER_AKSES (ID_JENIS_USER, ID_MENU, CREATED_BY, CREATED_AT, DELETED_MARK)
			VALUES 
			('$id_j_user', '$id_menu', '1009',  SYSDATE, 0)
		";
					
		$sqlDel = "
			UPDATE CRMNEW_USER_AKSES SET 
				DELETED_MARK = 1,
				UPDATED_AT = SYSDATE,
				UPDATED_BY = '1009'
			WHERE
				ID_JENIS_USER = '$id_j_user' AND ID_MENU = '$id_menu'
		";
				
		$sqlEksekusi = "";
		if ($actIn_or_Del == 'in'){
			$sqlCek = "
				SELECT * FROM CRMNEW_USER_AKSES WHERE DELETED_MARK = 0 AND
				ID_JENIS_USER = '$id_j_user' AND ID_MENU = '$id_menu' 
			";					
			$hasilCek = $this->db->query($sqlCek)->result();;
					
			if(count($hasilCek) > 0){
				return "ready";
				exit();
			} else {
				$sqlEksekusi = $sqlIn;
			}
					
		} elseif($actIn_or_Del == 'del') {
			$sqlEksekusi = $sqlDel;
		}
				
		$this->db->trans_start();
		$this->db->query($sqlEksekusi);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
		    return "failed";
		} else {
		    return "success";
		}
	}
	
}

?>