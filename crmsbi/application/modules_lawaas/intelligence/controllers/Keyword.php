<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Keyword extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }
         
        $this->load->model('Keyword_model');
    }

    function index() {
        if ($this->session->userdata('akses') == 1) {
        $data = array('title' => 'Keyword');

        $this->template->display('Keyword_view', $data);
        // Selain admin diarahkan ke halaman competitor
        }else {
            redirect(base_url().'intelligence/Newsfeed');
        }
//        $data = array(
//            'title' => 'Keyword',
//        );
//        $this->template->display('Keyword_view', $data);
    }

    //====================== FUNCTION CRUD KEYWORD ======================\\

    function ListKeyword() {
        $list = $this->Keyword_model->ListKeyword();
        $data = array();
        $no = 0;
        foreach ($list as $lists) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $lists['KEYWORD'];
            $row[] = '<center>'
                    . '<a class="btn btn-xs btn-warning" style="margin-right: 5px;" href="javascript:void(0)" title="Edit" onclick="edit_keyword(' . "'" . $lists['ID'] . "'" . ')"><i class="fa fa-edit"></i> Edit</a>'
                    . '<a class="btn btn-xs btn-danger" style="margin-right: 5px;" href="javascript:void(0)" title="Hapus" onclick="delete_keyword(' . "'" . $lists['ID'] . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
                    . '</center>';
            $data[] = $row;
        }
        $out = array(
//            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Keyword_model->CountKeyword(),
            "data" => $data,
        );
        echo json_encode($out);
    }

    function DetailKeyword($id) {
        $data = $this->Keyword_model->DetailKeyword($id);
        echo json_encode($data);
    }

    function AddKeyword() {
        $keyword = $this->input->post('KEYWORD');
        $create_by = strtoupper($this->session->userdata('usernamescm'));
        $return = $this->Keyword_model->AddKeyword($keyword,$create_by);
        echo json_encode(array("status" => $return));
    }

    function UpdateKeyword() {
        $id = $this->input->post('ID');
        $keyword = $this->input->post('KEYWORD');
        $update_by = strtoupper($this->session->userdata('usernamescm'));
        $return = $this->Keyword_model->UpdateKeyword($id,$keyword,$update_by);
        echo json_encode(array("status" => $return));
    }

    function DeleteKeyword($id) {
        $return = $this->Keyword_model->DeleteKeyword($id);
        echo json_encode(array("status" => $return));
    }
}
