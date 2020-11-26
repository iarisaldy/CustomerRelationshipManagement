<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class Canvasing extends CI_Controller {

        public function __construct(){
            parent::__construct();
        }

        public function index(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('CanvasingList_view', $data);
        }

        public function detail($idCanvasing){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('CanvasingDetail_view', $data);
        }
    }
?>