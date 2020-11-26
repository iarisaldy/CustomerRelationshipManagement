<?php
    class Model_survey extends CI_Model {
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function surveyToko($name = null, $id = null, $provinsi = null, $merkProduk = null, $startDate = null, $endDate = null){
            $idRegion = $this->session->userdata("id_region");
            if($idRegion != "1003"){
                $this->db->where("CRMNEW_USER.ID_REGION", $idRegion);
            }
            if(isset($name) && isset($id)){
                $this->db->where("CRMNEW_HASIL_SURVEY.".$name, $id);
            }

            if($startDate != "" && $endDate != ""){
                $this->db->where("TO_CHAR(CRMNEW_HASIL_SURVEY.CREATE_DATE, 'YYYY-MM-DD') BETWEEN '$startDate' AND '$endDate'");
            }

            if(isset($provinsi)){
                if($provinsi != ""){
                    $this->db->where("CRMNEW_CUSTOMER.ID_PROVINSI", $provinsi);
                }
            }

            if(isset($merkProduk)){
                if($merkProduk != ""){
                    $this->db->like("CRMNEW_PRODUK_SURVEY.NAMA_PRODUK", ucwords(strtolower($merkProduk)), "both");
                }
            }

            $this->db->select("CRMNEW_HASIL_SURVEY.ID_HASIL_SURVEY, CRMNEW_HASIL_SURVEY.ID_KUNJUNGAN_CUSTOMER,
            CRMNEW_HASIL_SURVEY.ID_TOKO, CRMNEW_CUSTOMER.NAMA_TOKO,
            CRMNEW_HASIL_SURVEY.ID_PRODUK, CRMNEW_PRODUK_SURVEY.NAMA_PRODUK,
            CRMNEW_HASIL_SURVEY.STOK_SAAT_INI, CRMNEW_HASIL_SURVEY.VOLUME_PEMBELIAN, CRMNEW_HASIL_SURVEY.VOLUME_PENJUALAN,
            CRMNEW_HASIL_SURVEY.HARGA_PEMBELIAN, CRMNEW_HASIL_SURVEY.HARGA_PENJUALAN, CRMNEW_HASIL_SURVEY.TOP_PEMBELIAN,
            TO_CHAR(CRMNEW_HASIL_SURVEY.TGL_PEMBELIAN, 'YYYY-MM-DD') AS TGL_PEMBELIAN, TO_CHAR(CRMNEW_HASIL_SURVEY.CREATE_DATE, 'DD-MM-YYYY') AS TGL_ISI_SURVEY");
            $this->db->from("CRMNEW_HASIL_SURVEY");
            $this->db->join("CRMNEW_PRODUK_SURVEY", "CRMNEW_HASIL_SURVEY.ID_PRODUK = CRMNEW_PRODUK_SURVEY.ID_PRODUK");
            $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_HASIL_SURVEY.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $this->db->join("CRMNEW_USER", "CRMNEW_HASIL_SURVEY.ID_USER = CRMNEW_USER.ID_USER");
            $this->db->where("CRMNEW_HASIL_SURVEY.DELETE_MARK", 0);
            $survey = $this->db->get();
            if($survey->num_rows() > 0){
                return $survey->result();
            } else {
                return false;
            }

        }

        public function addSurvey($data, $tglBeli = null){
            if(isset($tglBeli)){
                $this->db->set('TGL_PEMBELIAN',"TO_DATE('$tglBeli','yyyy/mm/dd')", false);
            }
            
            $date = date('d-m-Y H:i:s');
            $this->db->set('CREATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
            
            $survey = $this->db->insert("CRMNEW_HASIL_SURVEY", $data);
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }

        public function updateSurvey($idSurvey, $data, $tglBeli = null){
            if(isset($tglBeli)){
                $this->db->set('TGL_PEMBELIAN',"TO_DATE('$tglBeli','yyyy/mm/dd')", false);
            }
            
            $date = date('d-m-Y H:i:s');
            $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);

            $survey = $this->db->where("ID_HASIL_SURVEY", $idSurvey)->update("CRMNEW_HASIL_SURVEY", $data);
            if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
        }
    }
?>