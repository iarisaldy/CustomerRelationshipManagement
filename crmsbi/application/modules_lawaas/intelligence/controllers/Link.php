<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Link extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }
         
        $this->load->model('Link_model');
    }

    function index() {
        if ($this->session->userdata('akses') == 1) {
        $data = array('title' => 'Link');

        $this->template->display('Link_view', $data);
        // Selain admin diarahkan ke halaman competitor
        }else {
            redirect(base_url().'intelligence/Newsfeed');
        }
//        $data = array(
//            'title' => 'Link',
//        );
//        $this->template->display('Link_view', $data);
    }

    //====================== FUNCTION CRUD LINK ======================\\

    function ListLink() {
        $list = $this->Link_model->Listlink();
        $data = array();
        $no = 0;
        foreach ($list as $lists) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = '<a href="'.$lists['LINK'].'">'.$lists['LINK'].'</a>';
            $row[] = '<center>'
                    . '<a class="btn btn-xs btn-warning" style="margin-right: 5px;" href="javascript:void(0)" title="Edit" onclick="edit_link(' . "'" . $lists['ID'] . "'" . ')"><i class="fa fa-edit"></i> Edit</a>'
                    . '<a class="btn btn-xs btn-danger" style="margin-right: 5px;" href="javascript:void(0)" title="Hapus" onclick="delete_link(' . "'" . $lists['ID'] . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
                    . '</center>';
            $data[] = $row;
        }
        $out = array(
//            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Link_model->CountLink(),
            "data" => $data,
        );
        echo json_encode($out);
    }

    function DetailLink($id) {
        $data = $this->Link_model->DetailLink($id);
        echo json_encode($data);
    }

    function AddLink() {
        $link = $this->input->post('LINK');
        $create_by = strtoupper($this->session->userdata('usernamescm'));
        $return = $this->Link_model->AddLink($link,$create_by);
        echo json_encode(array("status" => $return));
    }

    function UpdateLink() {
        $id = $this->input->post('ID');
        $link = $this->input->post('LINK');
        $update_by = strtoupper($this->session->userdata('usernamescm'));
        $return = $this->Link_model->UpdateLink($id,$link,$update_by);
        echo json_encode(array("status" => $return));
    }

    function DeleteLink($id) {
        $return = $this->Link_model->DeleteLink($id);
        echo json_encode(array("status" => $return));
    }
}
