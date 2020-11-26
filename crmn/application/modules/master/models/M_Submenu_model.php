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
	
	public function get_data_produk_id($id_produk)
	{

		$sql =" 
			SELECT 
				ID_PRODUK,
				NAMA_PRODUK 
			FROM 
				CRMNEW_PRODUK_SURVEY
			WHERE 
				ID_PRODUK = '$id_produk'
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function insert_data_produk_dist($id_produk, $nama_produk)
	{
		
		$sql ="
			INSERT INTO
				CRMNEW_PRODUK_SURVEY(ID_PRODUK,NAMA_PRODUK,DELETE_MARK,GROUP_ID,CREATE_BY,CREATE_DATE)
			VALUES 
				('$id_produk', '$nama_produk',0,15,'CRM',SYSDATE)
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data_produk_dist($id,$id_produk, $nama_produk, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_PRODUK_SURVEY
				SET
					ID_PRODUK ='$id_produk',
					NAMA_PRODUK = '$nama_produk',
					UPDATE_BY='$USER',
					UPDATE_DATE=SYSDATE
				WHERE 
					ID_PRODUK ='$id'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function hapus_data_produk_dist($id_produk, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_PRODUK_SURVEY
				SET
					DELETE_MARK='1',
					UPDATE_BY='$USER',
					UPDATE_DATE=SYSDATE
				WHERE 
					ID_PRODUK ='$id_produk'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}	
}
?>