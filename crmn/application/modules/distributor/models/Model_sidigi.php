<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

date_default_timezone_set('Asia/Jakarta');
 
class Model_sidigi extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('Point', TRUE);
		$this->db3 = $this->load->database('3pl', TRUE);
		
	}
	public function get_data_kpi(){
		
		$sql ="
			SELECT * FROM TPL_T_STOK_MATERIAL
		";
		
		return $this->db3->query($sql)->result_array();
	}
	
}


?>