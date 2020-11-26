<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Wpm_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function data_wpm($region=null, $prov=null){
		$sql ="
				SELECT
				MC.ID_CUSTOMER,
				MC.NAMA_TOKO,
				MC.NAMA_DISTRIBUTOR,
				MC.NEW_REGION,
				MC.NAMA_PROVINSI,
				MC.NAMA_DISTRIK,
				MC.NAMA_KECAMATAN,
				W.ID_CUSTOMER AS STATUS
				FROM M_CUSTOMER MC
				LEFT JOIN CRMNEW_TOKO_WPM W ON MC.ID_CUSTOMER=W.ID_CUSTOMER
					AND W.DELETE_MARK='0'
				WHERE MC.ID_CUSTOMER IS NOT NULL 
						
				";
		
		if($region!=null){
			$sql .= " AND NEW_REGION='$region' ";
		}
		if($prov!=null){
			$sql .= " AND ID_PROVINSI='$prov' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	public function crud($sql){
		
		return $this->db->query($sql);
	}
	























	
	
	
}
?>