<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_area extends CI_Model{

    public function list_area(){
    	$this->db->select('KD_AREA, NM_AREA')->from('MASTER_AREA')->where('IS_ACTIVE', 'Y');

        $area = $this->db->get();
        if($area->num_rows() > 0){
            return $area->result();
        } else {
            return false;
        }
    }

    public function check_area($kd_city){
    	$this->db->select('KD_AREA')->from('MASTER_AREA_CITY')->where('KD_CITY', $kd_city);
    	$area = $this->db->get();
        if($area->num_rows() > 0){
            return $area->row();
        } else {
            return false;
        }
    }

}