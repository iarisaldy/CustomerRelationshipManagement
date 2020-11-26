<?php
    class Model_filter extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function salesDistributor($idDistributor){
            $this->db->select("CRMNEW_USER.ID_USER, UPPER(CRMNEW_USER.NAMA) AS NAMA");
            $this->db->from("CRMNEW_USER");
            $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER");
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR", $idDistributor);
            $this->db->where_in("CRMNEW_USER.ID_JENIS_USER", array("1003", "1007"));
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", "0");

            $jenisUser = $this->db->get();
            if($jenisUser){
                return $jenisUser->result();
            } else {
                return false;
            }
        }

        public function jenisUser(){
            $this->db->select("ID_JENIS_USER, JENIS_USER");
            $this->db->from("CRMNEW_JENIS_USER");
            $this->db->where_in("ID_JENIS_USER", array(1005,1006,1003));

            $jenisUser = $this->db->get();
            if($jenisUser){
                return $jenisUser->result();
            } else {
                return false;
            }
        }

        public function ltDistributor($idDistributor){
            $this->db->select("ID_CUSTOMER, KD_SAP, NAMA_TOKO");
            $this->db->from("CRMNEW_CUSTOMER");
            $this->db->where("GROUP_CUSTOMER", "LT");
            $this->db->where("ID_DISTRIBUTOR", $idDistributor);

            $ltDistributor = $this->db->get();
            if($ltDistributor){
                return $ltDistributor->result();
            } else {
                return false;
            }
        }

        public function distributor(){
            $this->db->select("KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR");
            $this->db->from("CRMNEW_DISTRIBUTOR");

            $distributor = $this->db->get();
            if($distributor){
                return $distributor->result();
            } else {
                return false;
            }
        }

        public function provinsi(){
            $this->db->select("ID_PROVINSI, NAMA_PROVINSI");
            $this->db->from("CRMNEW_M_PROVINSI");

            $provinsi = $this->db->get();
            if($provinsi){
                return $provinsi->result();
            } else {
                return false;
            }
        }

        public function kota($idProvinsi){
            $this->db->select("ID_DISTRIK, NAMA_DISTRIK");
            $this->db->from("CRMNEW_M_DISTRIK");
            $this->db->where("ID_PROVINSI", $idProvinsi);

            $kota = $this->db->get();
            if($kota){
                return $kota->result();
            } else {
                return false;
            }
        }

        public function kecamatan(){
            $this->db->select("ID_KECAMATAN, NAMA_KECAMATAN");
            $this->db->from("CRMNEW_M_KECAMATAN");

            $kecamatan = $this->db->get();
            if($kecamatan){
                return $kecamatan->result();
            } else {
                return false;
            }
        }

        public function area(){
            $this->db->select("KD_AREA, NAMA_AREA");
            $this->db->from("CRMNEW_M_AREA");

            $area = $this->db->get();
            if($area){
                return $area->result();
            } else {
                return false;
            }
        }

        public function merkProduk(){
            $this->db->select("GROUP_ID, UPPER(JENIS_PRODUK) AS JENIS_PRODUK");
            $this->db->from("CRMNEW_JENIS_PRODUK_GROUP");
            $merkProduk = $this->db->get();
            if($merkProduk){
                return $merkProduk->result();
            } else {
                return false;
            }
        }

    }
?>