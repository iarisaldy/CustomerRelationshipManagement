<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Link_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //================== FUNCTION CRUD LINK ==================\\
    function ListLink() {
//        return $this->db->query("select * FROM SCM_MI_RSS_LINK")->result_array();
        return $this->db->get('SCM_MI_RSS_LINK')->result_array();
    }

    function CountLink() {
        $this->db->from("SCM_MI_RSS_LINK");
        return $this->db->count_all_results();
    }

    function DetailLink($id) {
        $this->db->from("SCM_MI_RSS_LINK");
        $this->db->where('ID', $id);
        $query = $this->db->get();

        return $query->row();
    }

    function AddLink($keyword,$create_by) {
        $query = $this->db->query("insert into SCM_MI_RSS_LINK (LINK,CREATE_BY,CREATE_DATE) values ('$keyword','$create_by',SYSDATE)");
        return $query;
    }

    function UpdateLink($id,$keyword,$update_by) {
        $this->db->query("update SCM_MI_RSS_LINK set LINK='$keyword',UPDATE_DATE=SYSDATE,UPDATE_BY='$update_by' where ID = $id");
        return $this->db->affected_rows();
    }

    function DeleteLink($id) {
        $this->db->where('ID', $id);
        $this->db->delete('SCM_MI_RSS_LINK');
    }
}
