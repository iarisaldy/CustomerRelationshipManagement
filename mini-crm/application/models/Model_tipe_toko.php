<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_tipe_toko extends CI_Model{

    public function list_tipe(){
    	$this->db->select('TIPE_TOKO_ID, NAMA_TIPE')->from('MASTER_TIPE_TOKO')->where('IS_ACTIVE', 'Y');

        $tipeToko = $this->db->get();
        if($tipeToko->num_rows() > 0){
            return $tipeToko->result();
        } else {
            return false;
        }
    }

}