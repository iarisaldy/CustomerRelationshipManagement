<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_distributor extends CI_Model{

    public function list_distributor(){
    	$this->db->select('KD_DISTRIBUTOR, NM_DISTRIBUTOR')->from('MASTER_DISTRIBUTOR');

        $distributor = $this->db->get();
        if($distributor->num_rows() > 0){
            return $distributor->result();
        } else {
            return false;
        }
    }

}