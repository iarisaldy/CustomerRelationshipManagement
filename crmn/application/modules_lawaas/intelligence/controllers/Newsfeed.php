<?php

error_reporting(0);
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Newsfeed extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }
        $this->load->model('Newsfeed_model');
        $this->load->helper('url');
        $this->load->helper('form');
        date_default_timezone_set("Asia/Jakarta");
    }

    function index($error = NULL) {
        //ambil data report terbaru
        $new =  $this->Newsfeed_model->newreport();
        foreach ($new as $value) {
            $newfile = $value['NAMA_FILE'];
        }
//        $file = $this->Newsfeed_model->m_filereport('151');
//        foreach ($file as $files){
//            $filereport = $files['NAMA_FILE'];
//        }
        $data = array(
            'title' => 'Cement Newsfeed',
            'error' => $error['error'],
            'jstree' => $this->jstree(),
            'newfile' => $newfile,
//            'newfiles' => $filereport
        );
        $this->template->display('Newsfeed_view', $data);
    }
/*
 * Upload + save data file upload
 */
    function proses() {
        $bulan['01']='Jan';
        $bulan['02']='Feb';
        $bulan['03']='Mar';
        $bulan['04']='Apr';
        $bulan['05']='Mei';
        $bulan['06']='Jun';
        $bulan['07']='Jul';
        $bulan['08']='Ags';
        $bulan['09']='Sep';
        $bulan['10']='Okt';
        $bulan['11']='Nov';
        $bulan['12']='Des';
        // settingan upload file report
        $config['upload_path'] = realpath(APPPATH . '../assets/periodicreport/web');
        $config['allowed_types'] = 'pdf';
//        $config['max_size'] = '100000';
        $config['file_name'] = $_FILES['NAMA_FILE']['name'];
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('NAMA_FILE')) { //kondisi gagal upload
//            $error = array('error' => $this->upload->display_errors());
//            $this->index($error);
        } else {
//            $nm_report = $this->input->post('NAMA_REPORT').' '.$bulan[$this->input->post('BULAN')].' '.$this->input->post('TAHUN');
            $nm_report = $this->input->post('NAMA_REPORT');
            $tahun = $this->input->post('TAHUN');
            $bulan = $this->input->post('BULAN');
            $nm_file = $this->upload->file_name;
            $create_by = $this->session->userdata('usernamescm');
            $this->db->query("insert into SCM_MI_REPORT values ('','$nm_report','$tahun','$bulan','$nm_file','$create_by',SYSDATE)");
        }
        echo json_encode(array("status" => TRUE));
    }
/*
 *  Pembuatan Tree view (Menu Tree) data report berdasarkan bulan dan tahun
 */
    function jstree() {
        // ambil data report terbaru 
        $new =  $this->Newsfeed_model->newreport();
        foreach ($new as $value) {
            $newfile = $value['NAMA_FILE'];
        }
        // ambil semua data report
        $data = $this->Newsfeed_model->datareport();
        $arr = array();
        $bln = array();
        $thn_awal = 2016;
        $thn_akhir = date('Y');
        $selisih = $thn_akhir - $thn_awal;
        $no = 0;
        // build tahun pada tree view
        for ($i = $thn_awal; $i <= $thn_akhir; $i++) {
            if ($i == date('Y')) {
                $arr[]['text'] = $i;
//                $arr[$no]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                $arr[$no]['state']['opened'] = 'true';
                $arr[$no]['state']['disabled'] = 'true';
            } else {
                $arr[]['text'] = $i;
                $arr[$no]['state']['disabled'] = 'true';
            }
            $no++;
        }
        // build bulan pada tree view
        $bln[0]['text'] = 'January';
        $bln[1]['text'] = 'Februari';
        $bln[2]['text'] = 'Maret';
        $bln[3]['text'] = 'April';
        $bln[4]['text'] = 'Mei';
        $bln[5]['text'] = 'Juni';
        $bln[6]['text'] = 'Juli';
        $bln[7]['text'] = 'Agustus';
        $bln[8]['text'] = 'September';
        $bln[9]['text'] = 'Oktober';
        $bln[10]['text'] = 'November';
        $bln[11]['text'] = 'Desember';
        // disable submenu bulan pada tree
        for ($i = 0; $i <= 11; $i++) {
            $bln[$i]['state']['disabled'] = 'true'; 
        }
        //kondisi jika bulan sekarang sama dengan bulan pada tree
        $bln_skrg = date('m');
        if ($bln_skrg == date('m')) {
            $bln[$bln_skrg - 1]['state']['opened'] = 'true'; // expand submenu yang sama dengan bulan sekarang
        }
        // pembuatan submenu bulan (jan-des) pada tiap tahun
        for ($i = 0; $i <= $selisih; $i++) {
            $arr[$i]['children'] = $bln;
        }
        // build data file report
        $file = array();
        $file1 = array();
        $no = 0;
        foreach ($data as $key => $dt) {
            $file[$dt['TAHUN']][$dt['BULAN']][] = $dt;
            $no++;
        }
        // pembuatan submenu file report berdasarkan tahun dan bulan
        $th = 2016;
        $no = 0;
        for ($j = 0; $j <= $selisih; $j++) {
            for ($i = 1; $i <= 12; $i++) {
                if (strlen($i) < 2) {
                    $i = '0' . $i;
                } else {
                    $i = $i . '';
                }
                // pembuatan index array untuk mencocokkan data report berdasarkan tahun dan bulan
                $file1 = $file[$th][$i];
//            $file1=$file;
                // kondisi penempatan file report berdasarkan tahun dan bulan yang cocok
                if ($i == '01') { //data report pada bulan januari
                    if ($file != null) {
                        $arr[$no]['children'][0]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            //pembatasan jumlah string judul report yang tampil pada treeview
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            //struktur submenu tree view untuk file report
                            $arr[$no]['children'][0]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][0]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][0]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][0]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][0]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][0]['children'] = '';
                    }
                } elseif ($i == '02') { //data report pada bulan Februari
                    if ($file != null) {
                        $arr[$no]['children'][1]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][1]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][1]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][1]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][1]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][1]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][1]['children'] = '';
                    }
                } elseif ($i == '03') { //data report pada bulan Maret
                    if ($file != null) {
                        $arr[$no]['children'][2]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][2]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][2]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][2]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][2]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][2]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][2]['children'] = '';
                    }
                } elseif ($i == '04') { //data report pada bulan April
                    if ($file != null) {
                        $arr[$no]['children'][3]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][3]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][3]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][3]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][3]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][3]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][3]['children'] = '';
                    }
                } elseif ($i == '05') { //data report pada bulan Mei
                    if ($file != null) {
                        $arr[$no]['children'][4]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][4]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][4]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][4]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][4]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][4]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][4]['children'] = '';
                    }
                } elseif ($i == '06') { //data report pada bulan juni
                    if ($file != null) {
                        $arr[$no]['children'][5]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][5]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][5]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][5]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][5]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][5]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][5]['children'] = '';
                    }
                } elseif ($i == '07') { //data report pada bulan Juli
                    if ($file != null) {
                        $arr[$no]['children'][6]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][6]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][6]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][6]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][6]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][6]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][6]['children'] = '';
                    }
                } elseif ($i == '08') { //data report pada bulan Agustus
                    if ($file != null) {
                        $arr[$no]['children'][7]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][7]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][7]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][7]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][7]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][7]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][7]['children'] = '';
                    }
                } elseif ($i == '09') { //data report pada bulan September
                    if ($file != null) {
                        $arr[$no]['children'][8]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][8]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][8]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][8]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][8]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][8]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][8]['children'] = '';
                    }
                } elseif ($i == '10') { //data report pada bulan Oktober
                    if ($file != null) {
                        $arr[$no]['children'][9]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][9]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][9]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][9]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][9]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][9]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][9]['children'] = '';
                    }
                } elseif ($i == '11') { //data report pada bulan November
                    if ($file != null) {
                        $arr[$no]['children'][10]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][10]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][10]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][10]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][10]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][10]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][10]['children'] = '';
                    }
                } elseif ($i == '12') { //data report pada bulan Desember
                    if ($file != null) {
                        $arr[$no]['children'][11]['children'] = $file1;
                        foreach ($file1 as $key => $val) {
                            if(strlen($val['NAMA_REPORT']) > 20){
                                $judul = substr($val['NAMA_REPORT'],0,20).'...';    
                            }else{
                                $judul = $val['NAMA_REPORT']; 
                            }
                            $arr[$no]['children'][11]['children'][$key]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
                            $arr[$no]['children'][11]['children'][$key]['a_attr']['title'] = $val['NAMA_REPORT'];
                            $arr[$no]['children'][11]['children'][$key]['a_attr']['href'] = $val['NAMA_FILE'];
                            $arr[$no]['children'][11]['children'][$key]['text'] = $judul;
                            if ($newfile == $val['NAMA_FILE']){ // kondisi jika report terbaru selected
                                $arr[$no]['children'][11]['children'][$key]['state']['selected'] = 'true';
                            }
                        }
                    } else {
                        $arr[$no]['children'][11]['children'] = '';
                    }
                }
            }
            $th++;
            $no++;
        }

        return json_encode($arr);
    }
/*
 *  Pembuatan datatabel list file report
 */
    function listreport() {
        $list = $this->Newsfeed_model->datareport();
        $data = array();
        $no = 0;
        $bulan['01']='Januari';
        $bulan['02']='Februari';
        $bulan['03']='Maret';
        $bulan['04']='April';
        $bulan['05']='Mei';
        $bulan['06']='Juni';
        $bulan['07']='Juli';
        $bulan['08']='Agustus';
        $bulan['09']='September';
        $bulan['10']='Oktober';
        $bulan['11']='November';
        $bulan['12']='Desember';
        foreach ($list as $lists) {
            $no++;
            $row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $lists['NAMA_REPORT'];
            $row[] = $bulan[$lists['BULAN']];
            $row[] = '<center>'.$lists['TAHUN'].'</center>';
            $row[] = $lists['NAMA_FILE'];
            $row[] = '<center><a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_report('."'".$lists['ID']."'".','."'".$lists['NAMA_FILE']."'".')"><i class="fa fa-trash"></i> Delete</a></center>';
            $data[] = $row;
        }
        $out = array(
//            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Newsfeed_model->paging(),
            "data" => $data,
        );
        echo json_encode($out);
    }
/*
 *  Delete data report beserta file report
 */
    function delreport($id) {
        $file = $this->Newsfeed_model->m_filereport($id);
        foreach ($file as $files){
            $filereport = $files['NAMA_FILE'];
                    }
        if(file_exists(realpath(APPPATH . "../assets/periodicreport/web/$filereport"))){    // cek file report pada direktori
            unlink(realpath(APPPATH . "../assets/periodicreport/web/$filereport"));         // hapus file report pada direktori
            $this->Newsfeed_model->delete($id);
        }
	echo json_encode(array("status" => TRUE));
    }

}
