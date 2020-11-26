<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_city extends CI_Model{

    function _query_city(){
        $this->db->select('KD_CITY, KD_REGION, NM_CITY')->from('MASTER_CITY');
    }

    public function list_city($region = null){
        if(isset($region)){
            $this->db->where_in('KD_REGION', $region);
        }

        $this->_query_city();

        $city = $this->db->get();
        if($city->num_rows() > 0){
            return $city->result();
        } else {
            return false;
        }
    }

    public function detail_city($city = null){
        if(isset($city)){
            $this->db->where('KD_CITY', $city);
        }
        $this->_query_city();

        $city = $this->db->get();
        if($city->num_rows() > 0){
            return $city->row();
        } else {
            return false;
        }
    }

}