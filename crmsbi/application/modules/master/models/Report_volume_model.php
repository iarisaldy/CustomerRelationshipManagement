<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Report_volume_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	// public function get_data()
	// {
		// $sql =" 
			// SELECT 
		// ";
		// return $this->db->query($sql)->result_array();
	// }
	
	// public function get_sales()
	// {
		// $sql =" 
			
		// ";
		// return $this->db->query($sql)->result_array();
	// }
	
	// public function get_data_id($id_menu)
	// {

		// $sql =" 

		// ";

		// return $this->db->query($sql)->result_array();
	// }
	
	// public function insert_data()
	// {
		
		// $sql ="
			
		// ";
	
		// $hasil = $this->db->query($sql);
		// return $hasil;
	// }
	
	// public function update_data($id)
	// {
		
		// $sql ="
				
		// ";
	
		// $hasil = $this->db->query($sql);
		// return $hasil;
	// }
	
	// public function hapus_data($id)
	// {
		
		// $sql ="
			
		// ";
		
		// $hasil = $this->db->query($sql);
		// return $hasil;
	// }	
}
?>