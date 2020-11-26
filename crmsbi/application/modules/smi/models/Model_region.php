<?php
    class Model_region extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listRegion(){
            $this->db->select("ID AS ID_REGION, REGION_NAME, REGION_ID");
            $this->db->from("CRMNEW_REGION");

            $region = $this->db->get();
            if($region->num_rows() > 0){
                return $region->result();
            } else {
                return false;
            }
        }

        public function listProvinsi($idProvinsi = null, $idRegion = null){
            if(isset($idProvinsi)){
                $this->db->where("ID_PROVINSI", $idProvinsi);
            }

            if(isset($idRegion)){
                if($idRegion != "0"){
                    $this->db->where("ID_REGION", $idRegion);
                }
            }
            
            $this->db->select("ID_PROVINSI, NAMA_PROVINSI, LATITUDE, LONGITUDE");
            $this->db->from("CRMNEW_M_PROVINSI");
            $this->db->where("ID_REGION IS NOT NULL");
            $this->db->order_by("ID_PROVINSI", "ASC");

            $provinsi = $this->db->get();
            if($provinsi->num_rows() > 0){
                return $provinsi->result();
            } else {
                return false;
            }
        }
    }
?>