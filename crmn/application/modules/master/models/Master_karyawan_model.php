<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Master_karyawan_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data($id_dis=null)
	{

		$sql =" 
			SELECT DISTINCT
			K.NO_KARYAWAN,
			K.NAMA_KARYAWAN,
			K.ALAMAT,
			K.NO_HP,
			K.EMAIL,
			K.KODE_DISTRIBUTOR,
			D.NAMA_DISTRIBUTOR
		FROM CRMNEW_DT_KARYAWAN K
		LEFT JOIN M_SALES_DISTRIBUTOR D ON K.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR 
		WHERE DELETE_MARK='0'
		";
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR='$id_dis' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function Get_dis_all(){
		
		$sql ="
			SELECT DISTINCT 
				KODE_DISTRIBUTOR,
				NAMA_DISTRIBUTOR 
			FROM 
				M_SALES_DISTRIBUTOR 
			WHERE 
				KODE_DISTRIBUTOR IS NOT NULL
			ORDER BY NAMA_DISTRIBUTOR ASC
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function get_data_id($id_edit)
	{

		$sql =" 
			SELECT 
			K.NO_KARYAWAN,
			K.NAMA_KARYAWAN,
			K.ALAMAT,
			K.NO_HP,
			K.EMAIL,
			K.KODE_DISTRIBUTOR,
			D.NAMA_DISTRIBUTOR
		FROM CRMNEW_DT_KARYAWAN K
		LEFT JOIN M_SALES_DISTRIBUTOR D ON K.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR 
		WHERE NO_KARYAWAN = '$id_edit'
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function insert_data($nama,$alamat,$telp,$imail,$id_dis,$USER)
	{	
		$sql ="
			INSERT INTO
				CRMNEW_DT_KARYAWAN(NAMA_KARYAWAN,ALAMAT,NO_HP,EMAIL,KODE_DISTRIBUTOR,DELETE_MARK,CREATE_BY,CREATE_DATE)
			VALUES 
				('$nama','$alamat','$telp','$imail','$id_dis',0,$USER,SYSDATE)
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data($id_edit, $nama,$alamat,$telp,$imail,$id_dis, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_DT_KARYAWAN
				SET
					NAMA_KARYAWAN = '$nama',
					ALAMAT = '$alamat',
					NO_HP = '$telp',
					EMAIL = '$imail',
					KODE_DISTRIBUTOR = '$id_dis',
					UPDATE_BY='$USER',
					UPDATE_DATE=SYSDATE
				WHERE 
					NO_KARYAWAN ='$id_edit'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function hapus_data($id_hapus, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_DT_KARYAWAN
				SET
					DELETE_MARK='1',
					UPDATE_BY='$USER',
					UPDATE_DATE=SYSDATE
				WHERE 
					NO_KARYAWAN ='$id_hapus'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}	
}
?>