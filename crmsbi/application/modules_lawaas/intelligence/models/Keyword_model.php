<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Keyword_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //================== FUNCTION CRUD KEYWORD ==================\\
    function ListKeyword() {
        return $this->db->query("select * from SCM_MI_RSS_KEYWORD ORDER BY KEYWORD ASC")->result_array();
//        return $this->db->get('SCM_MI_RSS_KEYWORD')->result_array();
    }

    function CountKeyword() {
        $this->db->from("SCM_MI_RSS_KEYWORD");
        return $this->db->count_all_results();
    }

    function DetailKeyword($id) {
        $this->db->from("SCM_MI_RSS_KEYWORD");
        $this->db->where('ID', $id);
        $query = $this->db->get();

        return $query->row();
    }

    function AddKeyword($keyword,$create_by) {
        $query = $this->db->query("insert into SCM_MI_RSS_KEYWORD (KEYWORD,CREATE_BY,CREATE_DATE) values ('$keyword','$create_by',SYSDATE)");
        return $query;
    }

    function UpdateKeyword($id,$keyword,$update_by) {
        $this->db->query("update SCM_MI_RSS_KEYWORD set KEYWORD='$keyword',UPDATE_DATE=SYSDATE,UPDATE_BY='$update_by' where ID = $id");
        return $this->db->affected_rows();
    }

    function DeleteKeyword($id) {
        $this->db->where('ID', $id);
        $this->db->delete('SCM_MI_RSS_KEYWORD');
    }
}
