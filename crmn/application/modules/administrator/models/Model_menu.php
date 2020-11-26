<?php
    if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class Model_menu extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function listMenu($idMenu = null){
            $this->db->select('CRMNEW_MENU.ID_MENU, CRMNEW_MENU.NAMA_MENU, CRMNEW_MENU.LINK, CRMNEW_MENU.ICON');
            $this->db->from('CRMNEW_MENU');
            $this->db->where('CRMNEW_MENU.DELETED_MARK', 0);

            $menu = $this->db->get();
            if($menu->num_rows() > 0){
                return $menu->result();
            } else {
                return false;
            }
        }
    }
?>