<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Intelligent_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getPerusahaan(){
        $data = $this->db->get("ZREPORT_MS_PERUSAHAAN");
        return $data->result_array();
    }

    function getFasilitas(){
        $data = $this->db->get("ZREPORT_MS_M_FASILITAS");
        return $data->result_array();
    }
    
    function getFoto(){
        $data = $this->db->get("ZREPORT_MS_PRSH_FOTO");
        
        return $data->result_array();
    }
    
    function getInfo(){
        $data = $this->db->get("ZREPORT_MS_PRSH_INFORMASI");
        
        return $data->result_array();
    }
    
    function getDataFasilitas(){
        $data = $this->db->query("SELECT
                                        TB1.ID,
                                        TB1.KODE_PERUSAHAAN,
                                        TB3.NAMA_PERUSAHAAN,
                                        TB1.FASILITAS KODE_FASILITAS,
                                        TB2.NAMA FASILITAS,
                                        TB1.NAMA NAMA_FASILITAS,
                                        TB1.LATITUDE,
                                        TB1.LONGITUDE,
                                        TB1.STATUS
                                FROM
                                        ZREPORT_MS_PRSH_FASILITAS TB1
                                JOIN ZREPORT_MS_M_FASILITAS TB2 ON TB1.FASILITAS = TB2.ID
                                JOIN ZREPORT_MS_PERUSAHAAN TB3 ON TB1.KODE_PERUSAHAAN = TB3.KODE_PERUSAHAAN");
        return $data->result_array();
    }
}
