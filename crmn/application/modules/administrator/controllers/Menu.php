<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class Menu extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model('Model_menu');
        }

        public function index(){
            $data = array("title" => "Dashboard CRM");
            $this->template->display('MenuList_view', $data);
        }

        public function dataMenu(){
            $data = array();

            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));

            $menu = $this->Model_menu->listMenu();

            if($menu){
                foreach ($menu as $menuKey => $menuValue) {
                    $data[] = array(
                        $menuValue->ID_MENU,
                        $menuValue->NAMA_MENU,
                        $menuValue->LINK,
                        $menuValue->ICON,
                        "<center>
                            <button class='btn btn-sm btn-warning'><i class='fa fa-edit'></i> Update</button>
                            &nbsp;
                            <button class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button>
                        </center>"
                    );
                }
            } else {
                $data[] = array("-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($menu),
                "recordsFiltered" => count($menu),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

    }
?>