<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_district extends CI_Model{

    public function list_district($city = null, $region = null){
        if(isset($city)){
            $this->db->where('KD_CITY', $city);
        }

        if(isset($region)){
            $this->db->where_in('KD_REGION', $region);
        }

        $this->db->select('KD_DISTRICT, KD_CITY, KD_REGION, NM_DISTRICT')->from('MASTER_DISTRICT');

        $district = $this->db->get();
        if($district->num_rows() > 0){
            return $district->result();
        } else {
            return false;
        }
    }

}