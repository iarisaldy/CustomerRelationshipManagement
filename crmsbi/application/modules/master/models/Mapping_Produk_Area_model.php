<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Mapping_Produk_Area_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data()
	{

		$sql =" 
			SELECT 
				CRMNEW_PRODUK_AREA.NO_MAPPING,
				CRMNEW_PRODUK_AREA.ID_AREA,
                CRMNEW_M_AREA.NAMA_AREA,
				CRMNEW_PRODUK_AREA.ID_PRODUK,
                CRMNEW_PRODUK_SURVEY.NAMA_PRODUK
			FROM 
				CRMNEW_PRODUK_AREA 
            LEFT JOIN CRMNEW_PRODUK_SURVEY ON CRMNEW_PRODUK_AREA.ID_PRODUK = CRMNEW_PRODUK_SURVEY.ID_PRODUK
            LEFT JOIN CRMNEW_M_AREA ON CRMNEW_PRODUK_AREA.ID_AREA = CRMNEW_M_AREA.ID_AREA
			WHERE
				CRMNEW_PRODUK_AREA.DELETE_MARK='0'
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_area()
	{

		$sql =" 
			SELECT 
				ID_AREA,
				NAMA_AREA
			FROM 
				CRMNEW_M_AREA
			WHERE 
				DELETE_MARK='0'
            
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_produk()
	{

		$sql =" 
			SELECT 
				ID_PRODUK,
				NAMA_PRODUK
			FROM 
				CRMNEW_PRODUK_SURVEY
            WHERE 
				DELETE_MARK='0'
            
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_id($id_map)
	{
		$sql =" 
			SELECT 
				CRMNEW_PRODUK_AREA.NO_MAPPING,
				CRMNEW_PRODUK_AREA.ID_AREA,
                CRMNEW_M_AREA.NAMA_AREA,
				CRMNEW_PRODUK_AREA.ID_PRODUK,
                CRMNEW_PRODUK_SURVEY.NAMA_PRODUK
			FROM 
				CRMNEW_PRODUK_AREA 
            LEFT JOIN CRMNEW_PRODUK_SURVEY ON CRMNEW_PRODUK_AREA.ID_PRODUK = CRMNEW_PRODUK_SURVEY.ID_PRODUK
            LEFT JOIN CRMNEW_M_AREA ON CRMNEW_PRODUK_AREA.ID_AREA = CRMNEW_M_AREA.ID_AREA
			WHERE
				CRMNEW_PRODUK_AREA.NO_MAPPING = '$id_map'
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function insert_data($id_area,$id_produk,$USER)
	{
		
		$sql ="
			INSERT INTO
				CRMNEW_PRODUK_AREA(ID_AREA,ID_PRODUK,DELETE_MARK,CREATE_BY,CREATE_AT)
			VALUES 
				('$id_area', '$id_produk',0,'$USER',SYSDATE)
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data($no_map, $id_area, $id_produk, $USER)
	{
		$sql ="
				UPDATE 
					CRMNEW_PRODUK_AREA
				SET
					ID_AREA = '$id_area',
					ID_PRODUK = '$id_produk',
					UPDATE_BY='$USER',	
					UPDATE_AT=SYSDATE
				WHERE 
					NO_MAPPING = '$no_map'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	// public function hapus_data($id_user, $USER)
	// {
		
		// $sql ="
				// UPDATE 
					// CRMNEW_USER_AKSES
				// SET
					// DELETED_MARK='1',
					// UPDATED_BY='$USER',
					// UPDATED_AT=SYSDATE
				// WHERE 
					// ID_USER_AKSES ='$id_user'
		// ";
		
		// $hasil = $this->db->query($sql);
		// return $hasil;
	// }	
}
?>