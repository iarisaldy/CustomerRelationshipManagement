<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Mapping_user_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data($id_dis=null,$id_region=null, $id_prov=null)
	{

		$sql =" 
			SELECT DISTINCT
				UK.ID_USER_KARYAWAN,
				K.NO_KARYAWAN,
				K.NAMA_KARYAWAN,
				K.ALAMAT,
				K.NO_HP,
				K.EMAIL,
				K.KODE_DISTRIBUTOR,
				D.NAMA_DISTRIBUTOR,
				D.NEW_REGION,
				UK.ID_USER,
				U.USERNAME
			FROM CRMNEW_DT_KARYAWAN K
			LEFT JOIN CRMNEW_USER_KARYAWAN UK ON K.NO_KARYAWAN=UK.NO_KARYAWAN
				AND UK.DELETE_MARK= '0'
			LEFT JOIN M_SALES_DISTRIBUTOR D ON K.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR
			LEFT JOIN CRMNEW_USER U ON UK.ID_USER=U.ID_USER
				WHERE K.DELETE_MARK = '0'
		";
		
		if($id_dis!=null){
			$sql .= " AND K.KODE_DISTRIBUTOR='$id_dis' ";
		}
		
		if($id_region!=null){
			$sql .= " AND D.NEW_REGION='$id_region' ";
		}
		
		if($id_prov!=null){
			$sql .= " AND D.ID_PROVINSI='$id_prov' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function Get_user_all(){
		
		$sql ="
				SELECT 
					ID_USER,
					NAMA 
				FROM 
					CRMNEW_USER 
				WHERE 
					DELETED_MARK ='0'
				AND FLAG = 'SBI'
				ORDER BY NAMA ASC		
			";
		
		return $this->db->query($sql)->result();
	}
	
	public function Get_user_sales_dis($id_dis){
		
		$sql ="
				SELECT 
					ID_USER,
					NAMA 
				FROM 
					M_SALES_DISTRIBUTOR
				WHERE 
                    KODE_DISTRIBUTOR = '$id_dis'
					AND ID_TSO IS NOT NULL
					AND ID_USER NOT IN (SELECT ID_USER FROM CRMNEW_USER_KARYAWAN WHERE KODE_DISTRIBUTOR = '$id_dis' AND DELETE_MARK = '0')
                GROUP BY ID_USER,NAMA
				ORDER BY NAMA ASC
                		
			";
		
		return $this->db->query($sql)->result();
	}
	
	public function Get_karyawan_all(){
		
		$sql ="
			SELECT 
				NO_KARYAWAN,
				NAMA_KARYAWAN,
				KODE_DISTRIBUTOR
			FROM 
				CRMNEW_DT_KARYAWAN 
			WHERE 
				DELETE_MARK ='0'
			ORDER BY NAMA_KARYAWAN ASC
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function get_data_id($id_edit)
	{

		$sql =" 
			SELECT 
				M.ID_USER_KARYAWAN,
				M.ID_USER,
				U.NAMA,
				M.NO_KARYAWAN,
				K.NAMA_KARYAWAN
			FROM CRMNEW_USER_KARYAWAN M
				LEFT JOIN CRMNEW_USER U ON M.ID_USER=U.ID_USER
				LEFT JOIN CRMNEW_DT_KARYAWAN K ON M.NO_KARYAWAN = K.NO_KARYAWAN
			WHERE ID_USER_KARYAWAN = '$id_edit'
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function insert_data($id_user,$id_kar,$USER)
	{	
		$sql ="
			INSERT INTO
				CRMNEW_USER_KARYAWAN(ID_USER,NO_KARYAWAN,DELETE_MARK,CREATE_DATE,CREATE_BY)
			VALUES 
				('$id_user','$id_kar',0,SYSDATE,$USER)
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function update_data($id_edit,$id_user,$id_kar, $USER)
	{
		$sql ="
				UPDATE 
					CRMNEW_USER_KARYAWAN
				SET
					NO_KARYAWAN = '$id_user',
					ID_USER = '$id_kar',
					UPDATE_BY='$USER',
					UPDATE_DATE=SYSDATE
				WHERE 
					ID_USER_KARYAWAN ='$id_edit'
		";
	
		$hasil = $this->db->query($sql);
		return $hasil;
	}
	
	public function hapus_data($id_hapus, $USER)
	{
		
		$sql ="
				UPDATE 
					CRMNEW_USER_KARYAWAN
				SET
					DELETE_MARK='1',
					UPDATE_BY='$USER',
					UPDATE_DATE=SYSDATE
				WHERE 
					ID_USER_KARYAWAN ='$id_hapus'
		";
		
		$hasil = $this->db->query($sql);
		return $hasil;
	}

	public function Get_dis_all(){
		
		$sql ="
			SELECT
				K.KODE_DISTRIBUTOR,
				D.NAMA_DISTRIBUTOR 
			FROM CRMNEW_DT_KARYAWAN K 
            LEFT JOIN M_SALES_DISTRIBUTOR D ON K.KODE_DISTRIBUTOR = D.KODE_DISTRIBUTOR
			WHERE K.DELETE_MARK = '0'
			GROUP BY K.KODE_DISTRIBUTOR,D.NAMA_DISTRIBUTOR
			
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function Get_prov_all(){
		
		$sql ="
			SELECT
				D.ID_PROVINSI,
                D.NAMA_PROVINSI
			FROM CRMNEW_DT_KARYAWAN K 
            LEFT JOIN M_SALES_DISTRIBUTOR D ON K.KODE_DISTRIBUTOR = D.KODE_DISTRIBUTOR
			WHERE K.DELETE_MARK = '0'
			GROUP BY 
                D.ID_PROVINSI,
                D.NAMA_PROVINSI
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function Get_region_all(){
		
		$sql ="
			SELECT
				D.NEW_REGION
			FROM CRMNEW_DT_KARYAWAN K 
            LEFT JOIN M_SALES_DISTRIBUTOR D ON K.KODE_DISTRIBUTOR = D.KODE_DISTRIBUTOR
			WHERE K.DELETE_MARK = '0'
			GROUP BY 
                D.NEW_REGION
		";
		
		return $this->db->query($sql)->result();
	}
}
?>	