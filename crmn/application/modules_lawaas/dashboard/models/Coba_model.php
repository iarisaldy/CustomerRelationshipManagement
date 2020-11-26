<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

class Coba_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function get_data(){
        $data = $this->db->get('MAHASISWA')->result();
        return $data;
    }
}