<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_role extends CI_Model{

    public function list_role(){
    	$this->db->select('ROLE_ID, NAME')->from('ROLE')->where('ISACTIVE', 'Y');

        $role = $this->db->get();
        if($role->num_rows() > 0){
            return $role->result();
        } else {
            return false;
        }
    }

}