<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_keaktifan_toko extends CI_Model{

    public function list_keaktifan(){
    	$this->db->select('STATUS_ACTIVE_ID, NM_STATUS_ACTIVE')->from('MASTER_ACTIVE_STATUS')->where('IS_ACTIVE', 'Y');

        $tipeToko = $this->db->get();
        if($tipeToko->num_rows() > 0){
            return $tipeToko->result();
        } else {
            return false;
        }
    }

}