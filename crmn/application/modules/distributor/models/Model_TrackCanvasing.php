<?php
    class Model_TrackCanvasing extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listCanvasing($idSalesDistributor, $startDate, $endDate){
            $this->db->select("CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER ,CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_LATITUDE, CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_LONGITUDE");
            $this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK", 0);
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME IS NOT NULL");
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.CHECKOUT_TIME IS NOT NULL");
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER", $idSalesDistributor);
            $this->db->where("TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'YYYY-MM-DD') BETWEEN '$startDate' AND '$endDate'");
            $this->db->order_by("CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME", "asc");
            $canvasing = $this->db->get();
            if($canvasing->num_rows() > 0){
                return $canvasing->result();
            } else {
                return false;
            }
        }

        public function detailCanvasing($idKunjungan){
            $this->db->select("CRMNEW_CUSTOMER.NAMA_TOKO, 
                TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'DD - MM - YYYY') AS TGL_KUNJUNGAN,
                ROUND((TO_DATE(TO_CHAR(CHECKOUT_TIME, 'DD-MM-YYYY HH24:MI:SS'), 'DD-MM-YYYY HH24:MI:SS') - TO_DATE(TO_CHAR(CHECKIN_TIME, 'DD-MM-YYYY HH24:MI:SS'),'DD-MM-YYYY HH24:MI:SS'))*(24*60), 2) AS DURASI_KUNJUNGAN,
                CRMNEW_KUNJUNGAN_CUSTOMER.KETERANGAN");
            $this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
            $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER", $idKunjungan);
            $detailCanvasing = $this->db->get();
            if($detailCanvasing->num_rows() > 0){
                return $detailCanvasing->row();
            } else {
                return false;
            }
        }

    }
?>