<?php

if (!defined('BASEPATH')) {
    exit('NO DIRECT SCRIPT ACCESS ALLOWED');
}

class Login_model extends CI_Model {
    private $dbh;
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getDataKaryawan($username){
        $this->dbh = $this->load->database('hris',true);
        $eselon = array('30','20','10');
        $this->dbh->where('mk_email',$username);
        $this->dbh->where_in('mk_eselon_code',$eselon);
        $this->dbh->where('mk_stat2','3');
        $data = $this->dbh->get('v_karyawan');
        //echo $this->dbh->last_query();
        return $data->row();
    }
    
    function getDataUser($username){
        $this->db->where('USERNAME',$username);
        $this->db->where('STATUS','0');
        $data = $this->db->get('ZREPORT_SCM_USER');
        
        return $data->row();
    }
    
    function insertLoginHis($username,$opco,$status){
        $save = $this->db->query("INSERT INTO ZREPORT_SCM_LOGIN_LOG (USERNAME, LOGIN_TIME, COMPANY, STATUS_LOGIN) VALUES ('$username',SYSDATE,'$opco','$status')");
        return $save;
    }
}
