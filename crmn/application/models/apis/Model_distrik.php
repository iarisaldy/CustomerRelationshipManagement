<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}
    
    
    class Model_distrik extends CI_Model {

        public function listDistik($idProvinsi = null){
            if(isset($idProvinsi)){
                $this->db->where('CRMNEW_M_DISTRIK.ID_PROVINSI', $idProvinsi);
            } else {
                $this->db->where_not_in('CRMNEW_M_DISTRIK.ID_PROVINSI', array("1063", "1062"));
            }
            $this->db->select('ID_DISTRIK, ID_PROVINSI, NAMA_DISTRIK');
            $this->db->from('CRMNEW_M_DISTRIK');

            $distrik = $this->db->get();
            if($distrik->num_rows() > 0){
                return $distrik->result();
            } else {
                return false;
            }
        }
    }
?>