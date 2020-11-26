<?php
    class Model_area extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listArea($idProvinsi){
            if(isset($idProvinsi)){
                if($idProvinsi[0] != "00"){
                    // $this->db->where_in("ID_PROVINSI", $idProvinsi);
                }
            }
            $this->db->select("ID_AREA, NAMA_AREA");
            $this->db->from("CRMNEW_M_AREA");
            $this->db->where("DELETE_MARK", 0);

            $area = $this->db->get();
            if($area->num_rows() > 0){
                return $area->result();
            } else {
                return false;
            }
        }
    }
?>