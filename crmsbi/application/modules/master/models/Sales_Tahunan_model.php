<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Sales_Tahunan_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get_data($idsales)
	{
		$sql =" 
			SELECT 
				CRMNEW_JADWAL_TAHUNAN.NO_JADWAL,
				CRMNEW_JADWAL_TAHUNAN.ID_SALES,
				CRMNEW_CUSTOMER.NAMA_TOKO,
				CRMNEW_JADWAL_TAHUNAN.SUN,
				CRMNEW_JADWAL_TAHUNAN.MON,
				CRMNEW_JADWAL_TAHUNAN.TUE,
				CRMNEW_JADWAL_TAHUNAN.WED,
				CRMNEW_JADWAL_TAHUNAN.THU,
				CRMNEW_JADWAL_TAHUNAN.FRI,
				CRMNEW_JADWAL_TAHUNAN.SAT,
				CRMNEW_JADWAL_TAHUNAN.WEEK1,
				CRMNEW_JADWAL_TAHUNAN.WEEK2,
				CRMNEW_JADWAL_TAHUNAN.WEEK3,
				CRMNEW_JADWAL_TAHUNAN.WEEK4
				FROM CRMNEW_JADWAL_TAHUNAN 
				LEFT JOIN CRMNEW_CUSTOMER ON CRMNEW_JADWAL_TAHUNAN.ID_CUSTOMER = CRMNEW_CUSTOMER.ID_CUSTOMER
				WHERE ID_SALES = '$idsales'
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_sales()
	{
		$sql =" 
			SELECT ID_USER,NAMA FROM CRMNEW_USER WHERE FLAG = 'SBI'
		";
		return $this->db->query($sql)->result();
	}
	
	public function get_jadwal($nojadwal)
	{
		$sql =" 
			SELECT 
				CRMNEW_JADWAL_TAHUNAN.ID_SALES,
				CRMNEW_CUSTOMER.NAMA_TOKO,
				CRMNEW_JADWAL_TAHUNAN.SUN,
				CRMNEW_JADWAL_TAHUNAN.MON,
				CRMNEW_JADWAL_TAHUNAN.TUE,
				CRMNEW_JADWAL_TAHUNAN.WED,
				CRMNEW_JADWAL_TAHUNAN.THU,
				CRMNEW_JADWAL_TAHUNAN.FRI,
				CRMNEW_JADWAL_TAHUNAN.SAT,
				CRMNEW_JADWAL_TAHUNAN.WEEK1,
				CRMNEW_JADWAL_TAHUNAN.WEEK2,
				CRMNEW_JADWAL_TAHUNAN.WEEK3,
				CRMNEW_JADWAL_TAHUNAN.WEEK4
				FROM CRMNEW_JADWAL_TAHUNAN 
				LEFT JOIN CRMNEW_CUSTOMER ON CRMNEW_JADWAL_TAHUNAN.ID_CUSTOMER = CRMNEW_CUSTOMER.ID_CUSTOMER
				WHERE NO_JADWAL = '$nojadwal'
		";
		return $this->db->query($sql)->result();
	}
	
	public function User_SALES($id_user=null){
        $sql ="
            SELECT
            US.NO_USER_SALES,
            US.ID_SALES,
            CU.NAMA
            FROM CRMNEW_USER_SALES US
            LEFT JOIN CRMNEW_USER CU ON US.ID_SALES=CU.ID_USER
            WHERE US.DELETE_MARK='0'
        ";
        
        if($id_user!=null){
            $sql .= " AND US.ID_USER='$id_user' ";
        }
        
        return $this->db->query($sql)->result();
    }
	
	// public function insert_data($idsales,$senin,$selasa,$rabo,$kamis,$jumat,$sabtu,$minggu,$week1,$week2,$week3,$week4)
	// {
		
		// $sql ="
			// INSERT INTO
				// CRMNEW_JADWAL_TAHUNAN(ID_SALES,SENIN,SELASA,RABO,KAMIS,JUMAT,SABTU,MINGGU,WEEK1,WEEK2,WEEK3,WEEK4)
			// VALUES 
				// ('$idsales','$senin','$selasa','$rabo','$kamis','$jumat','$sabtu','$minggu','$week1','$week2','$week3','$week4')
		// ";
	
		// $hasil = $this->db->query($sql);
		// return $hasil;
	// }
	
}
?>