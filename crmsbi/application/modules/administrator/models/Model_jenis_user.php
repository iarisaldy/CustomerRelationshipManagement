<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Model_jenis_user extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function listJenisUser(){
        if($this->session->userdata("id_jenis_user") == "1007"){
            $this->db->where("ID_JENIS_USER", "1003");
        }
        $this->db->select('ID_JENIS_USER, JENIS_USER');
        $this->db->from('CRMNEW_JENIS_USER');
        $this->db->order_by('ID_JENIS_USER', 'ASC');
        $jenisUser = $this->db->get();
        if($jenisUser->num_rows() > 0){
            return $jenisUser->result();
        } else {
            return false;
        }
    }
}
?>