<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Toko_noo_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('Point', TRUE);
	}
	
	public function User_distributor($id_user=null){
		$sql ="
			SELECT
			UD.ID_USER_DISTRIBUTOR,
			UD.ID_USER,
			UD.KODE_DISTRIBUTOR,
			D.NAMA_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR UD
			LEFT JOIN CRMNEW_DISTRIBUTOR D ON UD.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR
			WHERE UD.DELETE_MARK='0'
		";
		
		if($id_user!=null){
			$sql .= " AND UD.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	
	
	public function get_data_bk_sbi($bulan , $tahun, $fild , $id_distributor)
	{	
		$sql =" 
				SELECT * FROM VOLUME_CUSTOMER_SBI 
				WHERE BULAN = '$bulan'
				AND TAHUN = '$tahun'
				";
		
		if($id_distributor!=null){
			$sql .= " AND NOMOR_DISTRIBUTOR = '$id_distributor' ";
        }else{
			$sql .= " AND NOMOR_DISTRIBUTOR IN($fild) ";
		}
				
		return $this->db2->query($sql)->result_array();
		
	}
	
	public function get_data_bk_smi($bulan , $tahun, $fild , $id_distributor)
	{	
		$sql =" 
				SELECT 
					AKUISISI_DATE,
					KD_CUSTOMER,
					KD_SAP,
					NAMA_TOKO,
					NOMOR_DISTRIBUTOR,
					DISTRIBUTOR AS NM_DISTRIBUTOR,
					NM_CUSTOMER,
					ALAMAT_TOKO,
					KECAMATAN,
					KD_DISTRIK,
					NM_DISTRIK,
					KD_PROVINSI,
					PROVINSI,
					ID_AREA,
					AREA,
					BULAN,
					TAHUN,
					PENJUALAN,
					PENJUALAN_SP
				FROM VOLUME_CUSTOMER_SMI 
				WHERE BULAN = '$bulan'
				AND TAHUN = '$tahun'
				";
		
		if($id_distributor!=null){
			$sql .= " AND NOMOR_DISTRIBUTOR = '$id_distributor' ";
        }else{
			$sql .= " AND NOMOR_DISTRIBUTOR IN($fild) ";
		}
				
		return $this->db2->query($sql)->result_array();
		
	}
	
	
	public function User_dis($id_user=null){
		$sql ="
			SELECT
			UD.KODE_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR UD
			LEFT JOIN CRMNEW_DISTRIBUTOR D ON UD.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR
			WHERE UD.DELETE_MARK='0'
		";
		
		if($id_user!=null){
			$sql .= " AND UD.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
}
?>