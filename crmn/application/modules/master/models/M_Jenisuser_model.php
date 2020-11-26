<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class M_Jenisuser_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data()
	{

		$sql =" 
				SELECT 
					ID_JENIS_USER,
					JENIS_USER
				FROM CRMNEW_JENIS_USER
				WHERE DELETED_MARK='0'
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_id($id_jns_user)
	{

		$sql =" 
				SELECT 
					JENIS_USER 
				FROM 
					CRMNEW_JENIS_USER
				WHERE 
					ID_JENIS_USER = '$id_jns_user'
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function insert_data($jns_user, $USER)
	{
		$id ="SELECT MAX(ID_JENIS_USER)+1 FROM CRMNEW_JENIS_USER";
		$sql ="
			INSERT INTO
				CRMNEW_JENIS_USER(ID_JENIS_USER,JENIS_USER,DELETED_MARK,CREATED_BY,CREATED_DATE)
			VALUES 
				('$id', '$jns_user',0,'$USER',SYSDATE)
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data($id, $jns_user, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_JENIS_USER
				SET
					JENIS_USER = '$jns_user',
					UPDATED_BY='$USER',
					UPDATED_DATE=SYSDATE
				WHERE 
					ID_JENIS_USER ='$id'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
		// $hasil = $this->db->query($sql);
		// return $hasil;
	// }
	
	public function hapus_data($id, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_JENIS_USER
				SET
					DELETED_MARK='1',
					UPDATED_BY='$USER',
					UPDATED_DATE=SYSDATE
				WHERE 
					ID_PRODUK ='$id'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}	
}
?>