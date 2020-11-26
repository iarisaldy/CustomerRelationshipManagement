<?php

if (!defined('BASEPATH')) {
    exit('NO DIRECT SCRIPT ACCESS ALLOWED');
}

class Logout_model extends CI_Model {
	private $dbh;
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function updateLoginHis($username){
        $save = $this->db->query("UPDATE ZREPORT_SCM_LOGIN_LOG SET AKTIF_LOGIN = NULL WHERE USERNAME = '$username' AND AKTIF_LOGIN = '1'");
        // return $save;
    }
}