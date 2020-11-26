<?php
    class Model_product extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listProduct(){
            $this->db->select("CRMNEW_PRODUK_SURVEY.ID_PRODUK, CRMNEW_PRODUK_SURVEY.NAMA_PRODUK");
            $this->db->from("CRMNEW_PRODUK_SURVEY");
            $this->db->where("CRMNEW_PRODUK_SURVEY.DELETE_MARK", 0);
            $this->db->order_by("CRMNEW_PRODUK_SURVEY.GROUP_ID", "ASC");

            $product = $this->db->get();
            if($product){
                return $product->result();
            } else {
                return false;
            }
        }

    }

?>