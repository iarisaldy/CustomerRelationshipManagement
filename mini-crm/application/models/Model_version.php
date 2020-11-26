<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_version extends CI_Model{

    public function list_version($id_version = null){
        if(isset($id_version)){
            $this->db->where('VERSION_ID', $id_version);
        }

        $this->db->select('VERSION_ID, APPS_VERSION, TYPE_UPDATE, DESC_UPDATE')->from('SURVEY_APPS_VERSION')->where('ISACTIVE', 'Y')->order_by('VERSION_ID', 'DESC');
        $version = $this->db->get();
        if($version->num_rows() > 0){
            return $version->result();
        } else {
            return false;
        }
    }

    public function last_version($apps_version){
    	$version = $this->db->query("SELECT MAX( APPS_VERSION ) AS LAST_VERSION, LISTAGG ( TYPE_UPDATE, ' ' ) WITHIN GROUP ( ORDER BY APPS_VERSION ) AS TYPE_UPDATE FROM SURVEY_APPS_VERSION WHERE APPS_VERSION > $apps_version AND ISACTIVE = 'Y'");
        if($version->num_rows() > 0){
            return $version->result();
        } else {
            return false;
        }
    }

    public function add_version($data){
        $this->db->insert('APPS_VERSION', $data);
        if($this->db->affected_rows()){
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    public function edit_version($data, $version_id){
        $this->db->where('VERSION_ID', $version_id)->update('APPS_VERSION', $data);
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

}