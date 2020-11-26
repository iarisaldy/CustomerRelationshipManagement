<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Koordinat_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function getData($filterBy = null, $filterSet = null){
		$sql = " 
			SELECT * FROM VIEW_DATA_TOKO_CUSTOMER WHERE ID_CUSTOMER IS NOT NULL
		";
		
		if($filterBy == 1){
			$sql .= " AND ID_PROVINSI = '$filterSet' ";
		} elseif($filterBy == 2){
			$sql .= " AND ID_AREA = '$filterSet' ";
		}
		
		$sql .= " ORDER BY NAMA_TOKO ASC";
		//print_r($sql);
		//exit;
		return $this->db->query($sql)->result_array();
	}
	
	public function cariData($id_customer = null){
		$sql = " 
			SELECT * FROM VIEW_DATA_TOKO_CUSTOMER WHERE ID_CUSTOMER IS NOT NULL
		";
		if($id_customer != null){
			$sql .= " AND ID_CUSTOMER = $id_customer ";
		}
		return $this->db->query($sql)->result_array();
	}
	
	public function getProvinsi(){
		$sql = " 
			SELECT distinct(ID_PROVINSI), nama_provinsi FROM VIEW_DATA_TOKO_CUSTOMER
			where nama_provinsi is not null
			ORDER BY NAMA_PROVINSI ASC
		";
		return $this->db->query($sql)->result();
	} 
	
	public function getArea(){
		$sql = " 
			SELECT distinct(ID_AREA), NAMA_AREA FROM VIEW_DATA_TOKO_CUSTOMER
			where NAMA_AREA is not null
			ORDER BY NAMA_AREA ASC
		";
		return $this->db->query($sql)->result();
	}
	
}

?>