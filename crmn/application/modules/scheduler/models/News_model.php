<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

date_default_timezone_set('Asia/Jakarta');
 
class News_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            $this->db = $this->load->database('default', TRUE);
            $this->db2 = $this->load->database('Point', TRUE);
            set_time_limit(0);
    }
    public function Insert_data_News($data){
        
    }
    	
	
	
}


?>