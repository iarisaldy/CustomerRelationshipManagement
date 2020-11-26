<?php
    class Model_promosi extends CI_Model {
        public function __construct(){
            parent::__construct();
            $this->load->database("");
        }

        public function addSurveyPromosi($data){
            $this->db->insert_batch("CRMNEW_SURVEY_PROMO_CUSTOMER", $data);
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function updateSurveyPromosi($data){
            $this->db->update_batch("CRMNEW_SURVEY_PROMO_CUSTOMER", $data, "ID_SURVEY_PROMOSI");
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function deleteSurveyPromosi($idKunjungan, $idProduk, $data){
            $this->db->where("ID_KUNJUNGAN_CUSTOMER", $idKunjungan);
            $this->db->where("ID_PRODUK", $idProduk);
            $this->db->update("CRMNEW_SURVEY_PROMO_CUSTOMER", $data);

            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function checkIdSurveyPromosi($idKunjungan, $idProduk){
            $this->db->select("ID_SURVEY_PROMOSI");
            $this->db->from("CRMNEW_SURVEY_PROMO_CUSTOMER");
            $this->db->where("ID_KUNJUNGAN_CUSTOMER", $idKunjungan);
            $this->db->where("ID_PRODUK", $idProduk);
            $this->db->where("DELETE_MARK", 0);
            $this->db->order_by("ID_PROMOSI", "ASC");

            $promosi = $this->db->get();
            if($promosi->num_rows() > 0){
                return $promosi->result();
            } else {
                return false;
            }
        }

        public function listSurveyPromosi($idKunjungan = null, $idProduk = null, $provinsi = null, $merk = null, $startDate = null, $endDate = null){
            $idRegion = $this->session->userdata("id_region");
            if($idRegion != "1003"){
                $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            }
            
            if(isset($idKunjungan)){
                $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER", $idKunjungan);
            }

            if(isset($idProduk)){
                $this->db->where("ID_PRODUK", $idProduk);
            }

            if(isset($merk)){
                if($merk != ""){
                    $this->db->like("HASIL_SURVEY_PROMOSI.NAMA_PRODUK", ucwords(strtolower($merk)), "both");
                }
            }

            if(isset($provinsi)){
                if($provinsi != ""){
                    $this->db->where("CRMNEW_CUSTOMER.ID_PROVINSI", $provinsi); 
                }
            }

            if($startDate != "" && $endDate != ""){
                $this->db->where("HASIL_SURVEY_PROMOSI.TANGGAL_KUNJUNGAN BETWEEN '$startDate' AND '$endDate'");
            }
            $this->db->join("CRMNEW_KUNJUNGAN_CUSTOMER", "HASIL_SURVEY_PROMOSI.ID_KUNJUNGAN_CUSTOMER = CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER");
            $this->db->join("CRMNEW_USER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER = CRMNEW_USER.ID_USER");
            $this->db->join("CRMNEW_CUSTOMER", "HASIL_SURVEY_PROMOSI.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $promosi = $this->db->get("HASIL_SURVEY_PROMOSI");
            if($promosi->num_rows() > 0){
                return $promosi->result();
            } else {
                return false;
            }
        }
    }
?>