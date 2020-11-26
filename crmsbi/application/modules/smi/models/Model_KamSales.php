<?php
    class Model_KamSales extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listKamSales(){
            $idJenisUser = $this->session->userdata("id_jenis_user");
            $idRegion = $this->session->userdata("id_region");
            if($idJenisUser == "1001"){
                $this->db->where("CRMNEW_USER.ID_JENIS_USER", "1005");
                $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            } else if($idJenisUser == "1002" || $idJenisUser == "1007"){
                $kodeDist = $this->session->userdata("kode_dist");
                $this->db->where("ID_JENIS_USER", "1003");
                $this->db->where("CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR", $kodeDist);
            } else {
                $idUser = $this->session->userdata("user_id");
                $this->db->where("CRMNEW_USER.ID_USER", $idUser);
            }

            $this->db->select("CRMNEW_USER.ID_USER, CRMNEW_USER.NAMA, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR");
            $this->db->from("CRMNEW_USER");
            $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER", "left");
            $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
            $this->db->where("CRMNEW_USER.DELETED_MARK", "0");
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", "0");

            $region = $this->db->get();
            if($region->num_rows() > 0){
                return $region->result();
            } else {
                return false;
            }
        }
    }
?>