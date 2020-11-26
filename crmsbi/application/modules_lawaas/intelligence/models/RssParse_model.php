<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class RssParse_model extends CI_Model {

    var $table = 'SCM_MI_RSS_NEWS';
    var $column_search = array('TITLE', 'LINK', 'DESCRIPTION');
    var $column_order = array('ID','TITLE', 'LINK', 'PUBDATE','TAMPIL');
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function getLink(){
        $data = $this->db->get('SCM_MI_RSS_LINK');
        return $data->result_array();
    }
    
    function getKeyword(){
        $data = $this->db->get('SCM_MI_RSS_KEYWORD');
        return $data->result_array();
    }
    
    function saveNews($data){
        $save = $this->db->query("INSERT INTO SCM_MI_RSS_NEWS (TITLE, DESCRIPTION, LINK, PUBDATE) "
                . "VALUES ('".$data['TITLE']."','".$data['DESCRIPTION']."','".$data['LINK']."',TO_TIMESTAMP('".$data['PUBDATE']."','YYYY-MM-DD HH24:MI:SS'))");
        
        return $save;
    }
    
    function cekLink($link){
        $data = $this->db->query("SELECT * FROM SCM_MI_RSS_NEWS WHERE LINK = '".$link."'");
        return $data->num_rows();
    }
    
    function newsQuery(){
        $this->db->select("ID, TITLE, LINK, DESCRIPTION, TO_CHAR(PUBDATE,'DD-MM-YYYY') PUBDATE, TAMPIL");
        $this->db->from($this->table);
        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                $this->db->like("LOWER(TITLE)", strtolower($_POST["search"]["value"]));
                //$this->db->or_like("LOWER(DESCRIPTION)", strtolower($_POST["search"]["value"]));
            }
        }
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        } else {
            $this->db->order_by('ID', 'DESC');
        }
    }
    function getNews() {
        $this->newsQuery();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function countNews() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    function filterNews() {
        $this->newsQuery();
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function getNewsSidebar(){
        $data = $this->db->query(" SELECT * FROM 
                        (SELECT
                                ID, TITLE, LINK, DESCRIPTION, TO_CHAR (
                                                    PUBDATE,
                                                    'DD-MM-YYYY HH24:MI:SS'
                                            ) AS PUBDATE
                        FROM
                                SCM_MI_RSS_NEWS
                        WHERE
                                TAMPIL = 1
                        ORDER BY TO_DATE(PUBDATE, 'DD-MM-YYYY HH24:MI:SS') DESC)
                        WHERE ROWNUM <= 100");
        
        return $data->result_array();
    }
    
    function delete($id){
        $this->db->where('ID',$id);
        $delete = $this->db->delete('SCM_MI_RSS_NEWS');
        return $delete;
    }
    
    function show($id){
        $this->db->where('ID',$id);
        $update = $this->db->update('SCM_MI_RSS_NEWS',array("TAMPIL"=>1));
        return $update;
    }
    
    function hide($id){
        $this->db->where('ID',$id);
        $update = $this->db->update('SCM_MI_RSS_NEWS',array("TAMPIL"=>0));
        return $update;
    }
}