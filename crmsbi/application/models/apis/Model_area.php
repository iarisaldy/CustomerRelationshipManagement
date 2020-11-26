<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_area extends CI_Model {

        public function listArea($idArea = null){
            if(isset($idArea)){
                $this->db->where('CRMNEW_M_AREA.ID_PROVINSI', $idArea);
            }
            $this->db->select('ID_AREA, ID_PROVINSI, NAMA_AREA');
            $this->db->from('CRMNEW_M_AREA');

            $area = $this->db->get();
            if($area->num_rows() > 0){
                return $area->result();
            } else {
                return false;
            }
        }

    }
?>