<?php
    class Model_AssignToko extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listAssign($idDistributor){
            $this->db->select("CRMNEW_ASSIGN_TOKO_SALES.ID_ASSIGN_TOKO, CRMNEW_CUSTOMER.ID_CUSTOMER, CRMNEW_ASSIGN_TOKO_SALES.ID_USER, CRMNEW_USER.NAMA AS NAMA_SALES, CRMNEW_ASSIGN_TOKO_SALES.ID_CUSTOMER, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_CUSTOMER.ALAMAT, CRMNEW_CUSTOMER.NAMA_KECAMATAN, CRMNEW_CUSTOMER.NAMA_DISTRIK AS KOTA");
            $this->db->from("CRMNEW_ASSIGN_TOKO_SALES");
            $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_ASSIGN_TOKO_SALES.ID_CUSTOMER = CRMNEW_CUSTOMER.ID_CUSTOMER");
            $this->db->join("CRMNEW_USER", "CRMNEW_ASSIGN_TOKO_SALES.ID_USER = CRMNEW_USER.ID_USER");
            $this->db->where("CRMNEW_ASSIGN_TOKO_SALES.DELETE_MARK", 0);
            $this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
            $this->db->order_by("CRMNEW_USER.ID_USER", "ASC");
            $assignToko = $this->db->get();
            if($assignToko->num_rows() > 0){
                return $assignToko->result();
            } else {
                return false;
            }
        }

        public function addAssign($data){
            $this->db->insert_batch("CRMNEW_ASSIGN_TOKO_SALES", $data);
            if($this->db->affected_rows()){
                return $data;
            } else {
                return false;
            }
        }

        public function deleteAssign($idAssign, $data){
            $date = date('Y-m-d H:i:s');
            $this->db->set('UPDATED_AT',"TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss')", false);
            $this->db->where("ID_ASSIGN_TOKO", $idAssign)->update("CRMNEW_ASSIGN_TOKO_SALES", $data);
            if($this->db->affected_rows()){
                return $data;
            } else {
                return false;
            }
        }

        public function listCustomer($idDistributor){
            $sql = "SELECT
                        TOKO_ASSIGN.ID_CUSTOMER,
                        CUSTOMER.NAMA_TOKO,
                        CUSTOMER.ALAMAT 
                    FROM
                        ( SELECT ID_CUSTOMER FROM CRMNEW_CUSTOMER WHERE ID_DISTRIBUTOR = '$idDistributor' MINUS SELECT ID_CUSTOMER FROM CRMNEW_ASSIGN_TOKO_SALES WHERE DELETE_MARK = '0' ) TOKO_ASSIGN
                        JOIN (SELECT ID_CUSTOMER, NAMA_TOKO, ALAMAT FROM CRMNEW_CUSTOMER) CUSTOMER ON TOKO_ASSIGN.ID_CUSTOMER = CUSTOMER.ID_CUSTOMER";
            $customer = $this->db->query($sql);
            if($customer->num_rows() > 0){
                return $customer->result();
            } else {
                return false;
            }
        }

    }
?>