<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

    class Model_distributor extends CI_Model {
        
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listDistributor(){
            if($this->session->userdata("id_jenis_user") == "1007"){
                $this->db->where("KODE_DISTRIBUTOR", $this->session->userdata("kode_dist"));
            }
            $this->db->select("KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR");
            $this->db->from("CRMNEW_DISTRIBUTOR");
            $this->db->where("DELETE_MARK", 0);
            $distributor = $this->db->get();
            if($distributor->num_rows() > 0){
                return $distributor->result();
            } else {
                return false;
            }
        }

    }

?>