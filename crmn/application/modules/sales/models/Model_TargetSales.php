<?php
    class Model_TargetSales extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function targetSales($idDistributor, $bulan, $tahun){
            $this->db->select("CRMNEW_KPI_TARGET_SALES.ID_TARGET_SALES, CRMNEW_USER.NAMA AS NAMA_SALES, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR, CRMNEW_KPI_TARGET_SALES.VOLUME, CRMNEW_KPI_TARGET_SALES.HARGA, CRMNEW_KPI_TARGET_SALES.REVENUE, CRMNEW_KPI_TARGET_SALES.KUNJUNGAN");
            $this->db->from("CRMNEW_KPI_TARGET_SALES");
            $this->db->join("CRMNEW_USER", "CRMNEW_KPI_TARGET_SALES.ID_SALES = CRMNEW_USER.ID_USER");
            $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_KPI_TARGET_SALES.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
            $this->db->where("CRMNEW_KPI_TARGET_SALES.KODE_DISTRIBUTOR", $idDistributor);
            $this->db->where("CRMNEW_KPI_TARGET_SALES.BULAN", $bulan);
            $this->db->where("CRMNEW_KPI_TARGET_SALES.TAHUN", $tahun);
            $this->db->where("CRMNEW_KPI_TARGET_SALES.DELETE_MARK", "0");
            $assignToko = $this->db->get();
            if($assignToko->num_rows() > 0){
                return $assignToko->result();
            } else {
                return false;
            }
        }

        public function detailTargetSales($idTarget){
            $this->db->select("CRMNEW_KPI_TARGET_SALES.ID_TARGET_SALES, CRMNEW_KPI_TARGET_SALES.ID_SALES, CRMNEW_KPI_TARGET_SALES.VOLUME, CRMNEW_KPI_TARGET_SALES.HARGA, CRMNEW_KPI_TARGET_SALES.REVENUE, CRMNEW_KPI_TARGET_SALES.KUNJUNGAN, CRMNEW_KPI_TARGET_SALES.BULAN, CRMNEW_KPI_TARGET_SALES.TAHUN");
            $this->db->from("CRMNEW_KPI_TARGET_SALES");
            $this->db->where("CRMNEW_KPI_TARGET_SALES.ID_TARGET_SALES", $idTarget);
            $this->db->where("CRMNEW_KPI_TARGET_SALES.DELETE_MARK", "0");
            $assignToko = $this->db->get();
            if($assignToko->num_rows() > 0){
                return $assignToko->result();
            } else {
                return false;
            }
        }

        public function addTargetSales($data){
            $this->db->insert("CRMNEW_KPI_TARGET_SALES", $data);
            if($this->db->affected_rows() > 0){
                return true;
            } else {
                return false;
            }
        }

        public function updateTarget($idTarget, $data){
            $this->db->where("ID_TARGET_SALES", $idTarget)->update("CRMNEW_KPI_TARGET_SALES", $data);
            if($this->db->affected_rows() > 0){
                return true;
            } else {
                return false;
            }
        }

    }
?>