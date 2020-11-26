<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Role extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('Model_role');
    }

    public function index(){
        $data = array("title" => "Dashboard CRM");
        $this->template->display('RoleList_view', $data);
    }

    public function dataRole(){
        $data = array();

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $role = $this->Model_role->listRole();

        if($role){
            foreach ($role as $roleKey => $roleValue) {
                $data[] = array(
                    $roleValue->ID_JENIS_USER,
                    $roleValue->JENIS_USER,
                    "<center>
                        <button class='btn btn-sm btn-warning'><i class='fa fa-edit'></i></button>
                        &nbsp;
                        <button class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                        &nbsp;
                        <button class='btn btn-sm btn-success'><i class='fa fa-arrow-right'></i> Detail</button>
                    </center>"
                );
            }
        } else {
            $data[] = array("-","-","-","-");
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($role),
            "recordsFiltered" => count($role),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

}
?>