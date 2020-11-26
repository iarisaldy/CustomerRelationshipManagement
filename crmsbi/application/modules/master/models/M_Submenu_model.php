<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class M_Submenu_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data()
	{

		$sql =" 
			SELECT 
				PS.ID_SUBMENU,
				PS.NAMA_MENU,
                JPG.NAMA_MENU AS MENU
			FROM CRMNEW_SUBMENU PS 
            LEFT JOIN CRMNEW_MENU JPG ON PS.ID_MENU=JPG.ID_MENU
            WHERE PS.DELETED_MARK='0'
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
	
	public function get_data_id($id_submenu)
	{

		$sql =" 
			SELECT 
				PS.NAMA_MENU,
				PS.LINK,
				JPG.ID_MENU,
                JPG.NAMA_MENU AS MENU
			FROM CRMNEW_SUBMENU PS 
            LEFT JOIN CRMNEW_MENU JPG ON PS.ID_MENU=JPG.ID_MENU
            WHERE PS.ID_SUBMENU ='$id_submenu'
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function insert_data($id_menu, $nama_menu, $link,$USER)
	{
		
		$sql ="
			INSERT INTO
				CRMNEW_SUBMENU(ID_MENU,NAMA_MENU,LINK,DELETED_MARK,CREATED_BY,CREATED_AT)
			VALUES 
				('$id_menu', '$nama_menu', '$link',0,'$USER',SYSDATE)
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data($id_submenu,$id_menu, $nama_menu, $link, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_SUBMENU
				SET
					NAMA_MENU = '$nama_menu',
					ID_MENU ='$id_menu',
					LINK = '$link',
					UPDATED_BY='$USER',
					UPDATED_AT=SYSDATE
				WHERE 
					ID_SUBMENU = '$id_submenu'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function hapus_data($id_submenu, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_SUBMENU
				SET
					DELETED_MARK='1',
					UPDATED_BY='$USER',
					UPDATED_AT=SYSDATE
				WHERE 
					ID_SUBMENU ='$id_submenu'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}	
}
?>