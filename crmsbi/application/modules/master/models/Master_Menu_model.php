<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Master_Menu_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data()
	{

		$sql =" 
			SELECT 
				ID_MENU,
				NAMA_MENU,
				ORDER_MENU
			FROM CRMNEW_MENU 
            WHERE DELETED_MARK='0'
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_id($id_menu)
	{

		$sql =" 
			SELECT 
				NAMA_MENU,
				ORDER_MENU
			FROM 
				CRMNEW_MENU
			WHERE 
				ID_MENU = '$id_menu'
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function insert_data($nama_menu,$order_menu, $USER)
	{
		
		$sql ="
			INSERT INTO
				CRMNEW_MENU(NAMA_MENU,ORDER_MENU,DELETED_MARK,CREATED_BY,CREATED_AT)
			VALUES 
				('$nama_menu','$order_menu',0,'$USER',SYSDATE)
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data($id, $nama_menu,$order_menu, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_MENU
				SET
					NAMA_MENU = '$nama_menu',
					ORDER_MENU = '$order_menu',
					UPDATED_BY='$USER',
					UPDATED_AT=SYSDATE
				WHERE 
					ID_MENU ='$id'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function hapus_data($id_menu, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_MENU
				SET
					DELETED_MARK='1',
					UPDATED_BY='$USER',
					UPDATED_AT=SYSDATE
				WHERE 
					ID_MENU ='$id_menu'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}	
}
?>