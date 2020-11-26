<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Intelligent extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }
        $this->load->model('Intelligent_model');
    }

    function index() {
        $data = array(
            'title' => 'Intelligent System',
            'listperusahaan' => $this->ceklistPerusahaan(),
            'listfasilitas' => $this->ceklistFasilitas()
        );
        $this->template->display('Intelligent_view', $data);
    }
    
    function getData(){
        $data = $this->Intelligent_model->getDataFasilitas();
        $foto = $this->Intelligent_model->getFoto();
        $info = $this->Intelligent_model->getInfo();
        
        foreach($data as $key=>$value){
            $data[$key]['FOTO'] = array();
            foreach($foto as $f){
                if($value['ID'] == $f['ID_PRSH_FASILITAS']){
                    array_push($data[$key]['FOTO'], base_url()."upload/".$f['FOTO']);
                }
            }
            foreach($info as $inf){
                if($value['ID'] == $inf['ID_PRSH_FASILITAS']){
                    array_push($data[$key]['INFO'], $inf['INFO']);
                }
            }
        }
        echo json_encode($data);
    }

    function ceklistPerusahaan() {
        $data = $this->Intelligent_model->getPerusahaan();

        $jumlah = count($data);
        //$bagi = ceil($jumlah/2);

        $list = "<form id='fListPerusahaan'><ul class='list-group'><li class='list-group-item active'>Pilih Perusahaan</li>";

        foreach ($data as $value) {
            $list .= "<li class='list-group-item'>";
            $list .= "<label class='checkbox-inline'>";
            $list .= "       <input id='cb".$value['KODE_PERUSAHAAN']."' type='checkbox' value='" . $value['KODE_PERUSAHAAN'] . "' checked>";
            $list .= $value['NAMA_PERUSAHAAN'];
            $list .= "</label>";
            $list .= "</li>";
        }

        $list .= "</ul></form>";

        return $list;
    }

    function ceklistFasilitas() {
        $data = $this->Intelligent_model->getFasilitas();

        //$jumlah = count($data);
        //$bagi = ceil($jumlah/2);

        $list = "<form id='fListFasilitas'><ul class='list-group'><li class='list-group-item active'>Pilih Fasilitas</li>";

        foreach ($data as $value) {
            $list .= "<li class='list-group-item'>";
            $list .= "<label class='checkbox-inline'>";
            $list .= "       <input id='cbf".$value['ID']."' type='checkbox' value='" . $value['ID'] . "' checked>";
            $list .= $value['NAMA'];
            $list .= "</label>";
            $list .= "</li>";
        }

        $list .= "</ul></form>";

        return $list;
    }
}
