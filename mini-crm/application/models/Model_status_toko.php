<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_status_toko extends CI_Model{

    public function list_status(){
    	$this->db->select('STATUS_TOKO_ID, NAMA_STATUS')->from('MASTER_STATUS_TOKO')->where('IS_ACTIVE', 'Y');

        $statusToko = $this->db->get();
        if($statusToko->num_rows() > 0){
            return $statusToko->result();
        } else {
            return false;
        }
    }

}