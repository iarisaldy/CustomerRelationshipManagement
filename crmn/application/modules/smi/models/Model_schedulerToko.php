<?php
    class Model_schedulerToko extends CI_Model {

        public function __construct(){
            parent::__construct();
        }

        public function addTokoNonaktif($data){
            $this->load->database();
            $this->db->insert_batch("CRMNEW_REKAP_TOKO_NONAKTIF", $data);
        }

        public function tokoNonaktif(){
            $this->db_point = $this->load->database("Point", true);
            $sql = "SELECT
                        M_CUSTOMER.NOMOR_DISTRIBUTOR,
                        M_CUSTOMER.KD_PROVINSI,
                        M_CUSTOMER.NM_DISTRIK,
                        M_CUSTOMER.AREA,
                        COUNT( M_CUSTOMER.KD_CUSTOMER ) AS JUMLAH_TOKO_NAKTIF 
                    FROM
                        M_CUSTOMER
                        JOIN P_USER ON M_CUSTOMER.KD_CUSTOMER = P_USER.KD_CUSTOMER 
                    WHERE
                        M_CUSTOMER.NOMOR_DISTRIBUTOR IS NOT NULL 
                        AND M_CUSTOMER.KD_CUSTOMER IS NOT NULL 
                        AND P_USER.STATUS NOT IN ( 1, 2 ) 
                    GROUP BY
                        M_CUSTOMER.NOMOR_DISTRIBUTOR,
                        M_CUSTOMER.KD_PROVINSI,
                        M_CUSTOMER.NM_DISTRIK,
                        M_CUSTOMER.AREA 
                    ORDER BY
                        M_CUSTOMER.NOMOR_DISTRIBUTOR ASC";

            $tokoNonaktif = $this->db_point->query($sql);
            if($tokoNonaktif->num_rows() > 0){
                return $tokoNonaktif->result();
            } else {
                return false;
            }
        }
    }
?>