<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class Model_role extends CI_Model {

        public function listRole(){
            $this->db->select('ID_JENIS_USER, JENIS_USER');
            $this->db->from('CRMNEW_JENIS_USER');
            $this->db->where('CRMNEW_JENIS_USER.DELETED_MARK', 0);

            $role = $this->db->get();
            if($role->num_rows() > 0){
                return $role->result();
            } else {
                return false;
            }
        }
    }
?>