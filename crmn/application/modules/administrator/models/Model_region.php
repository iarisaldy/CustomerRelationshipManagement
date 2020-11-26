<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

    class Model_region extends CI_Model {

        public function listRegion() {

            $this->db->select('ID, REGION_NAME, REGION_ID');
            $this->db->from('CRMNEW_REGION');
            
            $region = $this->db->get();
            if($region->num_rows() > 0){
                return $region->result();
            } else {
                return false;
            }
        }

    }
?>