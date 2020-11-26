<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('coba_model');
        if (!$this->session->userdata('is_login'))
            redirect('login');
    }

    function index() {
        //$this->template->display('home_view', array('title' => 'Dashboard'));
        redirect('dashboard/Demandpl');
    }

    function get_data() {
        $data = $this->coba_model->get_data();
        //print_r($data);
        $rows = '';
        if ($data) {
            foreach ($data as $r) {
                $rows .= '<tr>';
                $rows .= '<td>' . $r->NIM . '</td>';
                $rows .= '<td>' . $r->NAMA . '</td>';
                $rows .= '<td>' . $r->JURUSAN . '</td>';
                $rows .= '<td>' . $r->NIM . '</td>';
                $rows .= '</tr>';
            }
        }

        echo json_encode($rows);
    }

    function table() {
        $this->template->display('table_view', array('title' => 'Table'));
    }

    function coba() {
        $data = $this->coba_model->get_data();
        print_r($data);
    }

}
