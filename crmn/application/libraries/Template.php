<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Template {

    private $_obj = null;

    function __construct() {
        $this->_obj = &get_instance();
    }

    function display($view, $data = array()) {
        $menu = $this->mappingMenu();
        $this->_obj->load->view('header_dua', $data);
        $this->_obj->load->view('navigation_dua', array('menus' => $menu));
        $this->_obj->load->view($view, $data);
        $this->_obj->load->view('footer_dua');
    }
	
    // untuk mendapatkan menu sesuai dengan user yang login (CRM)
    function mappingMenu(){
        $this->_obj->load->database();
		
		
        $dataMenu = array("dataMenu" => $this->listMenu(), "subMenu" => $this->subMenu());
        return $dataMenu;
    }

    // mendapatkan menu untuk CRM
    function listMenu(){
        $this->_obj->load->library('session');
        $idJenisUser = $this->_obj->session->userdata('id_jenis_user');

        $this->_obj->db->select('CRMNEW_MENU.ID_MENU, CRMNEW_MENU.NAMA_MENU, CRMNEW_MENU.LINK');
        $this->_obj->db->from('CRMNEW_MENU');
        $this->_obj->db->join('CRMNEW_USER_AKSES', 'CRMNEW_MENU.ID_MENU = CRMNEW_USER_AKSES.ID_MENU');
        $this->_obj->db->where('CRMNEW_USER_AKSES.ID_JENIS_USER', $idJenisUser);
        $this->_obj->db->where('CRMNEW_MENU.DELETED_MARK', 0);
		$this->_obj->db->where('CRMNEW_USER_AKSES.DELETED_MARK', 0);
        $this->_obj->db->order_by('CRMNEW_MENU.ORDER_MENU', 'ASC');
		
		
        $menu = $this->_obj->db->get();
		//echo $this->db->last_query();
		//exit;
        return $menu->result();
    }

    // mendapatkan submenu untuk CRM
    function subMenu(){
        $this->_obj->db->select('CRMNEW_SUBMENU.ID_SUBMENU, CRMNEW_SUBMENU.ID_MENU, CRMNEW_SUBMENU.NAMA_MENU, CRMNEW_SUBMENU.LINK');
        $this->_obj->db->from('CRMNEW_SUBMENU');
        $this->_obj->db->where('CRMNEW_SUBMENU.DELETED_MARK', 0);
        $this->_obj->db->order_by('CRMNEW_SUBMENU.ORDER_MENU', 'ASC');

        $subMenu = $this->_obj->db->get();

        return $subMenu->result();
    }

}
