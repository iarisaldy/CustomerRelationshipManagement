<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Version extends Auth {

	function __construct(){
		parent::__construct();
        $this->load->model('Model_version');
    }

    public function list_get($id_version = null){
    	$this->validate();
        $version = $this->Model_version->list_version($id_version);
        if($version){
            foreach ($version as $key => $value) {
                $data['VERSION_ID'] = $value->VERSION_ID;
                $data['APPS_VERSION'] = $value->APPS_VERSION;
                $data['TYPE_UPDATE'] = $value->TYPE_UPDATE;
                $data['DESC_UPDATE'] = $value->DESC_UPDATE;
                $json[] = $data;
            }
            $response = array("status" => "success", "data" => $json);
        } else {
            $response = array("status" => "error", "message" => "Version not found");
        }

        $this->print_api($response);
    }

    public function index_get($apps_version){
        $version = $this->Model_version->last_version($apps_version);
        if($version){
            foreach ($version as $key => $value) {
                if($value->LAST_VERSION == NULL){
                    $data['STATUS'] = 'Version Not Found';
                } else {
                    $data['LAST_VERSION'] = $value->LAST_VERSION;

                    $haystack = (string)$value->TYPE_UPDATE;
                    $needle = "MAJOR";

                    if(strpos($haystack, $needle ) !== false ) {
                        $data["UPDATE"] = TRUE;
                    } else {
                        $data["UPDATE"] = FALSE;
                    } 
                }
            }
            $response = array("status" => "success", "data" => $data);
        } else {
            $response = array("status" => "error", "message" => "Version not found");
        }

        $this->print_api($response);
    }

    public function add_post(){
    	$this->validate();
        $version_code = $this->post('version_code');
        $update_type = $this->post('update_type');
        $desc_version = $this->post('desc_version');

        $latest_version = $this->Model_version->last_version(0);
        if((int)$version_code > (int)$latest_version[0]->LAST_VERSION){
            $data = array("APPS_VERSION" => $version_code, "TYPE_UPDATE" => $update_type, "DESC_UPDATE" => $desc_version, "ISACTIVE" => "Y");
            $add_version = $this->Model_version->add_version($data);
            if($add_version){
                $response = array("status" => "success", "data" => $add_version);
            } else {
                $response = array("status" => "error", "message" => "Cant add new version");
            }
        } else {
            $response = array("status" => "error", "message" => "Current version is smaller than the previous version");
        }

        $this->print_api($response);
    }

    public function edit_put(){
        $this->validate();
        $version_id = $this->put('version_id');
        $version_code = $this->put('version_code');
        $update_type = $this->put('update_type');
        $desc_version = $this->put('desc_version');

        $data = array("APPS_VERSION" => $version_code, "TYPE_UPDATE" => $update_type, "DESC_UPDATE" => $desc_version);
        $edit_version = $this->Model_version->edit_version($data, $version_id);
        if($edit_version){
            $response = array("status" => "success", "data" => $edit_version);
        } else {
            $response = array("status" => "error", "message" => "Cant edit version");
        }

        $this->print_api($response);
    }

    public function hapus_delete(){
    	$this->validate();
        $version_id = $this->delete('version_id');
        $data = array("ISACTIVE" => "N");

        $hapus_version = $this->Model_version->edit_version($data, $version_id);
        if($hapus_version){
            $response = array("status" => "success", "data" => $version_id);
        } else {
            $response = array("status" => "error", "message" => "Cant delete version");
        }

        $this->print_api($response);
    }
}
