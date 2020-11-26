<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_group extends CI_Model{

    public function list_group(){
    	$this->db->select('KD_GROUP, NM_GROUP')->from('MASTER_GROUP_CUSTOMER');

        $group = $this->db->get();
        if($group->num_rows() > 0){
            return $group->result();
        } else {
            return false;
        }
    }

}