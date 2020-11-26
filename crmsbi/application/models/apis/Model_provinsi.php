<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_provinsi extends CI_Model {

        public function listProvinsi(){
            $this->db->select('ID_PROVINSI, NAMA_PROVINSI, ID_REGION');
            $this->db->from('CRMNEW_M_PROVINSI');
            $provinsi = $this->db->get();
            if($provinsi->num_rows() > 0){
                return $provinsi->result();
            } else {
                return false;
            }
        }

    }
?>