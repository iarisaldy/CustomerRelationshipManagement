<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class C_V_Dmodel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data()
	{

		$sql =" 
			SELECT 
                CRMNEW_USER_AKSES.ID_USER_AKSES,
				CRMNEW_JENIS_USER.JENIS_USER,
                CRMNEW_MENU.NAMA_MENU
			FROM CRMNEW_USER_AKSES 
            LEFT JOIN CRMNEW_JENIS_USER ON 
				CRMNEW_USER_AKSES.ID_JENIS_USER=CRMNEW_JENIS_USER.ID_JENIS_USER
			LEFT JOIN CRMNEW_MENU ON 
				CRMNEW_USER_AKSES.ID_MENU = CRMNEW_MENU.ID_MENU
            WHERE 
				CRMNEW_USER_AKSES.DELETED_MARK='0'
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_menu()
	{

		$sql =" 
			SELECT 
				ID_MENU,
				NAMA_MENU
			FROM 
				CRMNEW_MENU
            WHERE DELETED_MARK='0'
            ORDER BY ID_MENU ASC
            
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_jenis()
	{

		$sql =" 
			SELECT 
				ID_JENIS_USER,
				JENIS_USER
			FROM 
				CRMNEW_JENIS_USER
            WHERE DELETED_MARK='0'
            ORDER BY ID_JENIS_USER ASC
            
		";
		return $this->db->query($sql)->result_array();
	}
	
	
	public function get_data_id($id_user)
	{

		$sql =" 
			SELECT 
                CRMNEW_USER_AKSES.ID_USER_AKSES,
				CRMNEW_JENIS_USER.ID_JENIS_USER,
				CRMNEW_JENIS_USER.JENIS_USER,
				CRMNEW_MENU.ID_MENU,
                CRMNEW_MENU.NAMA_MENU
			FROM CRMNEW_USER_AKSES 
            LEFT JOIN CRMNEW_JENIS_USER ON 
				CRMNEW_USER_AKSES.ID_JENIS_USER=CRMNEW_JENIS_USER.ID_JENIS_USER
			LEFT JOIN CRMNEW_MENU ON 
				CRMNEW_USER_AKSES.ID_MENU = CRMNEW_MENU.ID_MENU
            WHERE 
				CRMNEW_USER_AKSES.ID_USER_AKSES = '$id_user'
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function insert_data($id_jenis,$id_menu,$USER)
	{
		
		$sql ="
			INSERT INTO
				CRMNEW_USER_AKSES(ID_JENIS_USER,ID_MENU,DELETED_MARK,CREATED_BY,CREATED_AT)
			VALUES 
				('$id_jenis', '$id_menu',0,'$USER',SYSDATE)
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data($id_user_akses, $id_jenis, $id_menu, $USER)
	{
		$sql ="
				UPDATE 
					CRMNEW_USER_AKSES
				SET
					ID_JENIS_USER = '$id_jenis',
					ID_MENU = '$id_menu',
					UPDATED_BY='$USER',	
					UPDATED_AT=SYSDATE
				WHERE 
					ID_USER_AKSES = '$id_user_akses'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function hapus_data($id_user, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_USER_AKSES
				SET
					DELETED_MARK='1',
					UPDATED_BY='$USER',
					UPDATED_AT=SYSDATE
				WHERE 
					ID_USER_AKSES ='$id_user'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}	
}
?>