<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_region extends CI_Model{

    public function list_region(){

    	$this->db->select('KD_REGION, NM_REGION')->from('MASTER_REGION');

        $region = $this->db->get();
        if($region->num_rows() > 0){
            return $region->result();
        } else {
            return false;
        }
    }

}