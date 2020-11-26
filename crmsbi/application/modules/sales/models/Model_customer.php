<?php
    
    class Model_customer extends CI_Model {
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function assignToko($idUser){
            $this->db->select("CRMNEW_CUSTOMER.ID_CUSTOMER, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_CUSTOMER.ALAMAT");
            $this->db->from("CRMNEW_ASSIGN_TOKO_SALES");
            $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_ASSIGN_TOKO_SALES.ID_CUSTOMER = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $this->db->where("CRMNEW_ASSIGN_TOKO_SALES.DELETE_MARK", "0");
            $this->db->where("CRMNEW_ASSIGN_TOKO_SALES.ID_USER", $idUser);
            $customer = $this->db->get();
            if($customer->num_rows() > 0){
                return $customer->result();
            } else {
                return false;
            }
        }

        public function searchToko($idDistributor, $term){
            if(isset($idDistributor)){
                $this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
            }

            if(isset($term)){
                if($term != ""){
                    if(is_numeric($term)){
                        $this->db->or_like("CRMNEW_CUSTOMER.ID_CUSTOMER", $term);
                    } else {
                        $this->db->like("CRMNEW_CUSTOMER.NAMA_TOKO", strtoupper($term), "both");
                        $this->db->or_like("CRMNEW_CUSTOMER.NAMA_KECAMATAN", strtoupper($term), "both");
                    }
                }
            } else {
                $this->db->where("CRMNEW_CUSTOMER.ID_CUSTOMER", "0");
            }

            $this->db->select("CRMNEW_CUSTOMER.ID_CUSTOMER , CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_CUSTOMER.ALAMAT");
            $this->db->from("CRMNEW_CUSTOMER");
            
            $customer = $this->db->get();
            if($customer->num_rows() > 0){
                return $customer->result();
            } else {
                return false;
            }
        }

       public function listCustomer($idDistributor = null, $idArea = null){
            if(isset($idDistributor)){
                $this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
            }

            // if(isset($idArea)){
            //     if($idArea != "null"){
            //         if($idArea != ""){
            //             $this->db->where_in("CRMNEW_CUSTOMER.ID_AREA", array($idArea));
            //         }
            //     }
            // }

            $this->db->select("CRMNEW_CUSTOMER.ID_CUSTOMER, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_CUSTOMER.ALAMAT");
            $this->db->from("CRMNEW_CUSTOMER");
            // $this->db->where_in("CRMNEW_CUSTOMER.STATUS_TOKO", array(1, 2));

            $customer = $this->db->get();
            //echo $this->db->last_query();
            if($customer->num_rows() > 0){
                return $customer->result();
            } else {
                return false;
            }

        }
    }
?>