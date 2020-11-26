<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_user extends CI_Model{

	public function list_user($user_id = null){
		if(isset($user_id)){
			$this->db->select('USER.PASSWORD');
			$this->db->where('USER.USER_ID', $user_id);
		}
		$this->db->select('USER.USER_ID, USER.NAME, USER.USERNAME, ROLE.ROLE_ID, ROLE.NAME AS ROLE_NAME, USER.ISACTIVE,');
		$this->db->from('USER');
		$this->db->join('USER_ROLE', 'USER.USER_ID = USER_ROLE.USER_ID');
		$this->db->join('ROLE','USER_ROLE.ROLE_ID = ROLE.ROLE_ID');
		$this->db->where('USER.ISACTIVE', 'Y');
		$this->db->order_by('USER.USER_ID','DESC');
		$user = $this->db->get();
		if($user->num_rows() > 0){
			return $user->result();
		} else {
			return false;
		}
	}

	public function add_table($table, $data){
		$date = date('d-m-Y h:i:s');
		$this->db->set('CREATED',"TO_DATE('$date','dd/mm/yyyy hh24:mi:ss')", false);

		$this->db->insert($table, $data);
		if($this->db->affected_rows() > 0){
			return true;
		} else {
			return false;
		}
	}

	public function edit_table($table, $id, $value_id, $data){
		$date = date('d-m-Y h:i:s');
		$this->db->set('UPDATED',"TO_DATE('$date','dd/mm/yyyy hh24:mi:ss')", false);

		$this->db->where($id, $value_id)->update($table, $data);
		if($this->db->affected_rows() > 0){
			return true;
		} else {
			return false;
		}
	}

	public function check_last_id($table, $id){
		$this->db->select_max($id);
		$this->db->from($table);

		$last_id = $this->db->get();
		return $last_id->row();
	}

}