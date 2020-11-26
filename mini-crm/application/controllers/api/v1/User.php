<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class User extends Auth {

	function __construct(){        
		parent::__construct();
		$this->validate();
        $this->load->model('Model_user');
    }

    public function index_get(){
        $user = $this->Model_user->list_user();
        if($user){
            $response = array("status" => "success", "data" => $user);
        } else {
            $response = array("status" => "error", "message" => "Data Tidak ada");
        }

        $this->print_api($response);
    }

    public function add_post(){
        $name = $this->post('name');
        $username = $this->post('username');
        $password = $this->post('password');
        $role = $this->post('role');
        $user_id = $this->post('createdby');

        $data_user = array("NAME" => $name, "USERNAME" => $username, "PASSWORD" => $password, "CREATEDBY" => $user_id, "ISACTIVE" => "Y");
        $add_user = $this->Model_user->add_table('USER', $data_user);
        if($add_user){
            $last_id_user = $this->Model_user->check_last_id('USER', 'USER_ID');
            $data_role = array("USER_ID" => $last_id_user->USER_ID, "ROLE_ID" => $role, "CREATEDBY" => $user_id, "ISACTIVE" => "Y");

            $add_role = $this->Model_user->add_table('USER_ROLE', $data_role);
            if($add_role){
                $last_id_user_role = $this->Model_user->check_last_id('USER_ROLE', 'USER_ROLE_ID');

                $response = array("status" => "success", "data" => $last_id_user_role->USER_ROLE_ID);
            } else {
                $response = array("status" => "error", "message" => "Cant Insert User Role");
            }
        } else {
            $response = array("status" => "error", "message" => "Cant Insert User");
        }
        $this->print_api($response);
    }

    public function detail_get($user_id){
        $detail_user = $this->Model_user->list_user($user_id);
        if($detail_user){
            $response = array("status" => "success", "data" => $detail_user);
        } else {
            $response = array("status" => "error", "message" => "Data Tidak ada");
        }

        $this->print_api($response);
    }

    public function edit_put(){
        $user_id = $this->put('user_id');
        $name = $this->put('name');
        $username = $this->put('username');
        $password = $this->put('password');
        $role = $this->put('role');
        $updatedby = $this->put('updatedby');

        $data_user = array("NAME" => $name, "USERNAME" => $username, "PASSWORD" => $password,  "UPDATEDBY" => $updatedby);
        $edit_user = $this->Model_user->edit_table('USER', 'USER_ID', $user_id, $data_user);
        if($edit_user){
            $data_role = array("ROLE_ID" => $role, "UPDATEDBY" => $updatedby);
            $edit_role = $this->Model_user->edit_table('USER_ROLE', 'USER_ID', $user_id, $data_role);
            if($edit_role){
                $response = array("status" => "success", "data" => "");
            } else {
                $response = array("status" => "error", "message" => "Data Gagal diupdate");
            }
        } else {
            $response = array("status" => "error", "message" => "Data Gagal diupdate");
        }

        $this->print_api($response);
    }

    public function hapus_delete(){
        $user_id = $this->delete('user_id');
        $data = array("ISACTIVE" => "N");

        $hapus_user = $this->Model_user->edit_table('USER', 'USER_ID', $user_id, $data);
        $hapus_user_role = $this->Model_user->edit_table('USER_ROLE', 'USER_ID', $user_id, $data);

        if($hapus_user && $hapus_user_role){
            $response = array("status" => "success", "data" => "success delete user");
        } else {
            $response = array("status" => "error", "message" => "Cant delete user");
        }

        $this->print_api($response);
    }
}
