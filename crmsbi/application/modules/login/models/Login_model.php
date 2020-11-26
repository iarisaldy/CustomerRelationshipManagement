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

    // Function CRM
    function checkUser($username, $password){
        $this->db->select('CRMNEW_USER.ID_USER, CRMNEW_USER.NAMA, CRMNEW_USER.ID_REGION, CRMNEW_JENIS_USER.ID_JENIS_USER, CRMNEW_JENIS_USER.JENIS_USER');
        $this->db->from('CRMNEW_USER');
        $this->db->join('CRMNEW_JENIS_USER', 'CRMNEW_USER.ID_JENIS_USER = CRMNEW_JENIS_USER.ID_JENIS_USER');
        $this->db->where('USERNAME', $username);
        $this->db->where('PASSWORD', $password);
        $this->db->where('CRMNEW_USER.DELETED_MARK', 0);

        $user = $this->db->get();
        if($user->num_rows() > 0){
            return $user->row();
        } else {
            return false;
        }
    }

    public function checkUserDistributor($idUser){
        $this->db->select("CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR");
        $this->db->from("CRMNEW_USER_DISTRIBUTOR");
        $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
        $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", 0);
        $this->db->where("CRMNEW_USER_DISTRIBUTOR.ID_USER", $idUser);

        $user = $this->db->get();
        if($user->num_rows() > 0){
            return $user->row();
        } else {
            return false;
        }
    }

    public function checkUserProvinsi($idUser){
        $this->db->select("CRMNEW_USER_PROVINSI.ID_PROVINSI");
        $this->db->from("CRMNEW_USER_PROVINSI");
        $this->db->where("CRMNEW_USER_PROVINSI.DELETE_MARK", 0);
        $this->db->where("CRMNEW_USER_PROVINSI.ID_USER", $idUser);

        $user = $this->db->get();
        if($user->num_rows() > 0){
            return $user->row();
        } else {
            return false;
        }
    }
    // End function CRM 
}
