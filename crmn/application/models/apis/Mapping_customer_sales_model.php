<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Mapping_customer_sales_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function getMappingTokoSales($id_customer = null){
		$sql = " 
			SELECT * FROM T_TOKO_SALES_TSO WHERE KD_CUSTOMER IS NOT NULL
		";
		if($id_customer != null){
			$sql .= " AND KD_CUSTOMER = $id_customer ";
		}
		
		return $this->db->query($sql)->result();
	}
}

?>