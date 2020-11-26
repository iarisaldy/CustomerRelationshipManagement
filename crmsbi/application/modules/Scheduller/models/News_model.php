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
    public function Insert_artikel($hasil){
        //$this->db = $this->load->database('crm', TRUE);
		$status = null;
		
		foreach($hasil as $h){
			
			$title 			= $h['TITLE'];
			$pup_doc 		= $h['PUP_DATE'];
			$link 			= $h['LINK'];
			$guid 			= $h['GUID'];
			$author 		= $h['AUTHOR'];
			$tumnail 		= $h['THUMBNAIL'];
			$diskripsion 	= $h['DISCRIPTION'];
			
			$content 		= $h['CONTENT'];
			$content2		= $h['CONTENT_2'];
			$content3 		= $h['CONTENT_3'];
			
			$user 			= $h['CREATE_BY'];
			$create_date 	= $h['CREATE_DATE'];
			$dm				= $h['DELETE_MARK'];
			
			
			$sql = "
				INSERT INTO CRMNEW_NEWS 
				(TITLE, PUP_DATE, LINK, GUID, AUTHOR, THUMBNAIL, DISCRIPTION, CREATE_BY, CREATE_DATE, DELETE_MARK, CONTENT_1, CONTENT_2, CONTENT_3)
				VALUES 
				('$title','$pup_doc','$link','$guid','$author','$tumnail','$diskripsion','$user', '$create_date', 0,to_clob('$content')||to_clob('$content2')||to_clob('$content3'), '', '')
			";
			
			if(strlen($h['CONTENT1']) > 4000){
				echo $sql;
				$cek = $this->db->query($sql);
				exit;
			}
			if($cek){
				$status =1;
			}
		}
		return $status;
        //return $this->db->insert_batch('CRMNEW_NEWS', $hasil);
        
    }
    

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


?>