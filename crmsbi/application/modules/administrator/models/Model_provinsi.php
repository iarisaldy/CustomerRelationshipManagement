<?php
    class Model_provinsi extends CI_Model {
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listProvinsi($idRegion = null){
            if(isset($idRegion)){
                if($idRegion != "N"){
                    $this->db->where("ID_REGION", $idRegion);
                }
            }
            $this->db->select("ID_PROVINSI, NAMA_PROVINSI");
            $this->db->from("CRMNEW_M_PROVINSI");
            $provinsi = $this->db->get();
            if($provinsi->num_rows() > 0){
                return $provinsi->result();
            } else {
                return false;
            }
        }
    }
?>