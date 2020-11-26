<?php
    class Model_keluhan extends CI_Model {
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function questKeluhan(){
            $this->db->select("ID_KELUHAN, KELUHAN");
            $this->db->from("CRMNEW_KELUHAN");
            $this->db->order_by("ID_KELUHAN", "ASC");

            $keluhan = $this->db->get();
            if($keluhan->num_rows() > 0){
                return $keluhan->result();
            } else {
                return false;
            }
        }

        public function addSurveyKeluhan($data){
            $this->db->insert_batch("CRMNEW_SURVEY_KELUHAN_CUSTOMER", $data);
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function updateSurveyKeluhan($data){
            $this->db->update_batch("CRMNEW_SURVEY_KELUHAN_CUSTOMER", $data, "ID_SURVEY_KELUHAN");
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function checkIdSurveyKeluhan($idKunjungan, $idProduk){
            $this->db->select("ID_SURVEY_KELUHAN, ID_KELUHAN, JAWABAN");
            $this->db->from("CRMNEW_SURVEY_KELUHAN_CUSTOMER");
            $this->db->where("ID_KUNJUNGAN_CUSTOMER", $idKunjungan);
            $this->db->where("ID_PRODUK", $idProduk);
            $this->db->where("DELETE_MARK", 0);
            $this->db->order_by("ID_KELUHAN", "ASC");

            $keluhan = $this->db->get();
            if($keluhan){
                return $keluhan->result();
            } else {
                return false;
            }
        }

        public function deleteKeluhan($idKunjungan, $idProduk, $data){
            $this->db->where("ID_KUNJUNGAN_CUSTOMER", $idKunjungan);
            $this->db->where("ID_PRODUK", $idProduk);
            $this->db->update("CRMNEW_SURVEY_KELUHAN_CUSTOMER", $data);

            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function getListKeluhan($idKunjungan = null, $idProduk = null, $provinsi = null, $merk = null, $startDate = null, $endDate = null){
            $idRegion = $this->session->userdata("id_region");
            if($idRegion != "1003"){
                $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            }
            
            if(isset($idKunjungan)){
                $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER", $idKunjungan);
            }

            if(isset($idProduk)){
                $this->db->where("HASIL_SURVEY_KELUHAN.ID_PRODUK", $idProduk);
            }

            if(isset($provinsi)){
                if($provinsi != ""){
                    $this->db->where("CRMNEW_CUSTOMER.ID_PROVINSI", $provinsi);
                }
            }

            if(isset($merk)){
                if($merk != ""){
                    $this->db->like("HASIL_SURVEY_KELUHAN.NAMA_PRODUK", ucwords(strtolower($merk)) ,"both");
                }
            }

            if($startDate != "" && $endDate != ""){
                $this->db->where("HASIL_SURVEY_KELUHAN.TANGGAL_SURVEY BETWEEN '$startDate' AND '$endDate'");
            }

            $this->db->join("CRMNEW_KUNJUNGAN_CUSTOMER", "HASIL_SURVEY_KELUHAN.ID_KUNJUNGAN_CUSTOMER = CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER");
            $this->db->join("CRMNEW_USER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER");
            $this->db->join("CRMNEW_CUSTOMER", "HASIL_SURVEY_KELUHAN.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $keluhan = $this->db->get("HASIL_SURVEY_KELUHAN");

            if($keluhan->num_rows() > 0){
                return $keluhan->result();
            } else {
                return false;
            }
        }

    }
?>