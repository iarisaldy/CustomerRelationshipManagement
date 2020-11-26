<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Template_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function insert_template($data)
	{
		# code...
        $dtnow = date("Y-m-d H:i:s");     
        $this->db->set($data);
        $this->db->set("CREATED_AT", "to_date('".$dtnow."','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $query = $this->db->insert('CRMNEW_TEMPLATE_QUIZ');
        return true;
	}

	public function update_template($data)
	{
		# code...
        $dtnow = date("Y-m-d H:i:s"); 
        $this->db->where("ID", $data['ID']);
        unset($data['ID']);
        $this->db->set($data);
        $this->db->set("UPDATED_AT", "to_date('".$dtnow."','YYYY-MM-DD HH24:MI:SS')", FALSE);
        $query = $this->db->update('CRMNEW_TEMPLATE_QUIZ');
        $rows = $this->db->affected_rows();
        if ($rows > 0) {
            return true;
        }else{
            return false;
        }
	}
	
	public function get_template($id_templ = null){
		$this->db->select("A.*, B.NAMA AS NAMA_USER_INPUT, C.NAMA AS NAMA_USER_UPDATE");
        $this->db->from('CRMNEW_TEMPLATE_QUIZ A');
        $this->db->join("CRMNEW_USER B", "A.CREATED_BY = B.ID_USER", 'left');
        $this->db->join("CRMNEW_USER C", "A.UPDATED_BY = C.ID_USER", 'left');

        $this->db->where('A.DELETED_MARK', 0);
        $this->db->order_by('A.ORDER_TEMPLATE', 'ASC');

		return $this->db->get()->result_array();
	}
	
}

?>