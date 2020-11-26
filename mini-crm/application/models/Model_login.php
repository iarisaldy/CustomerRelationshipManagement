<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_login extends CI_Model{

    public function get_user($username, $password){
    	$this->db->select('USER.USER_ID, USER.NAME, USER.USERNAME, ROLE.ROLE_ID, ROLE.NAME AS ROLE_NAME')->from('USER')->join('USER_ROLE','USER.USER_ID = USER_ROLE.USER_ID')->join('ROLE','USER_ROLE.ROLE_ID = ROLE.ROLE_ID')->where('USER.USERNAME', $username)->where('USER.PASSWORD', $password)->where('USER.ISACTIVE', 'Y')->where('USER_ROLE.ISACTIVE', 'Y');

        $user = $this->db->get();
        if($user->num_rows() > 0){
            return $user->row();
        } else {
            return false;
        }
    }

}