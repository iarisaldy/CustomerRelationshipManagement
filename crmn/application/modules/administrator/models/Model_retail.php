<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

    class Model_retail extends CI_Model {

        public function listRetail($idDistributor = null) {
            if(isset($idDistributor)){
                $this->db->where("ID_DISTRIBUTOR", $idDistributor);
            }

            $this->db->select('ID_CUSTOMER, NAMA_TOKO');
            $this->db->from('CRMNEW_CUSTOMER');
            $this->db->where_in("STATUS_TOKO", array(1, 2));
            
            $region = $this->db->get();
            if($region->num_rows() > 0){
                return $region->result();
            } else {
                return false;
            }
        }

    }
?>