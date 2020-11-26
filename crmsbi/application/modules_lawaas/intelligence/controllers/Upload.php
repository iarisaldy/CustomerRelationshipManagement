<?php

error_reporting(E_ALL);
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Upload extends CI_Controller {

    private $parser;

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }
        $this->load->model('Upload_model');
        $this->load->helper('url');
        $this->load->helper('form');
        date_default_timezone_set("Asia/Jakarta");
    }

    function index() {
        $data = array(
            'title' => 'Upload Market Share',
//            'error' => $error['error'],
            'jstree' => $this->treeview(),
//            'newfile' => $newfile,
//            'totalnews' => $this->Newsfeed_model->countNews(),
//            'newfiles' => $filereport
        );
        $this->template->display('upload_view', $data);
    }

    function treeview() {
        $menu = array();
        $child = array();

        $child[0]['text'] = 'Perusahaan';
        $child[0]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
        $child[0]['a_attr']['title'] = 'Perusahaan';
        $child[0]['a_attr']['href'] = 'perusahaan/template_upload_perusahaan.xls';
        $child[1]['text'] = 'RKAP Market Share';
        $child[1]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
        $child[1]['a_attr']['title'] = 'RKAP Market Share';
        $child[1]['a_attr']['href'] = 'rkapms/template_upload_rkapms.xls';
        $child[2]['text'] = 'Market Share Bulanan';
        $child[2]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
        $child[2]['a_attr']['title'] = 'Market Share';
        $child[2]['a_attr']['href'] = 'trans/template_upload_mstrans.xls';
        $child[3]['text'] = 'Proyeksi Demand';
        $child[3]['icon'] = base_url() . 'assets/periodicreport/file_icon.png';
        $child[3]['a_attr']['title'] = 'Demand Harian';
        $child[3]['a_attr']['href'] = 'demand_harian/template_upload_ms_demand.xls';

        $menu[0]['text'] = 'Market Share';
        $menu[0]['children'] = $child;

        return json_encode($menu);
    }

    function Uview($title = false, $action = '', $urlfile = '', $dataX = array()) {
        $data = array(
            'title' => urldecode($title),
            'urlfile' => base_url('assets/Templates/template_excel/' . $urlfile),
            'action' => base_url('intelligence/Upload/' . $action),
            'dataX' => $dataX
        );
        if ($title) {
            $this->load->view('uploadfile_view', $data);
        } else {
            $this->load->view('upload_home', $data);
        }
    }

    function perusahaan() {
        include_once ( APPPATH . "libraries/excel_reader2.php");
        $datax = array();
        if (isset($_POST['Upload'])) {
            $allowedExts = "xls";
            $extension = end(explode(".", $_FILES["file"]["name"]));
            if ($extension == $allowedExts) {
                //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                $pecah = $_FILES["file"]["name"];
                $pecahTanda = explode("_", $pecah);

                $cell = new Spreadsheet_Excel_Reader($_FILES['file']['tmp_name']);
                $jumlah_row = $cell->rowcount($sheet_index = 0);
                $jumlah_col = $cell->colcount($sheet_index = 0);

                $arr = array();
                for ($row = 2; $row <= $jumlah_row; $row++) {
                    if ($cell->val($row, 2) != 0 || $cell->val($row, 2) != '') {
                        array_push($arr, array(
                            "KODE_PERUSAHAAN" => $cell->val($row, 2),
                            "NAMA_PERUSAHAAN" => $cell->val($row, 3),
                            "INISIAL" => $cell->val($row, 4),
                            "PRODUK" => $cell->val($row, 5),
                            "KELOMPOK" => $cell->val($row, 6),
                            "STATUS" => 0,
                            "CREATE_DATE" => 'SYSDATE',
                            "CREATE_BY" => $this->session->userdata('usernamescm')
                        ));
                    }
                }
                foreach ($arr as $key => $value) {
                    $cekdata = $this->Upload_model->cek_msperusahaan($value);
                    //$cekdata = true;
                    //$message = 'detected';
                    if ($cekdata) {
                        //var_dump($value); die();
                        $value['UPDATE_BY'] = $this->session->userdata('usernamescm');
                        $message = $this->Upload_model->update_msperusahaan($value);
                        //echo $this->db->last_query();
                        //echo 'ada<br/>';
                    } else {
                        $message = $this->Upload_model->insert_scm($value, 'ZREPORT_MS_PERUSAHAAN');
                        //echo $this->db->last_query();
                        //echo 'tidak ada<br/>';
                    }
                    array_push($datax, array(
                        "KODE_PERUSAHAAN" => $value["KODE_PERUSAHAAN"],
                        "NAMA_PERUSAHAAN" => $value["NAMA_PERUSAHAAN"],
                        "INISIAL" => $value["INISIAL"],
                        "PRODUK" => $value["PRODUK"],
                        "KELOMPOK" => $value["KELOMPOK"],
                        "MESSAGE" => $message
                    ));
                }
                
                //var_dump($datax);
            } else {
                echo "<script>alert('Invalid file, Must be Excel 2003...!!');</script>";
            }

            $this->Uview('Perusahaan', 'perusahaan', 'template_upload_perusahaan.xls', $datax);
        }
    }

    function rkapms() {
        include_once ( APPPATH . "libraries/excel_reader2.php");
        $datax = array();
        if (isset($_POST['Upload'])) {
            $allowedExts = "xls";
            $extension = end(explode(".", $_FILES["file"]["name"]));
            if ($extension == $allowedExts) {
                //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                $pecah = $_FILES["file"]["name"];
                $pecahTanda = explode("_", $pecah);

                $cell = new Spreadsheet_Excel_Reader($_FILES['file']['tmp_name']);
                $jumlah_row = $cell->rowcount($sheet_index = 0);
                $jumlah_col = $cell->colcount($sheet_index = 0);

                $rkapms = array();
                $data = array();
                $arr = array();

                $data['tahun'] = $cell->val(1, 2);
                for ($i = 4; $i <= $jumlah_row; $i++) {
                    $data['kode_provinsi'][$i] = $cell->val($i, 2);
                }
                $data['kode_perusahaan'][4] = '102';
                $data['perusahaan']['102'] = 'SEMEN PADANG';
                $data['kode_perusahaan'][5] = '110';
                $data['perusahaan']['110'] = 'SEMEN GRESIK';
                $data['kode_perusahaan'][6] = '112';
                $data['perusahaan']['112'] = 'SEMEN TONASA';

                for ($row = 4; $row <= $jumlah_row; $row++) {
                    for ($col = 4; $col <= $jumlah_col; $col++) {
                        if ($cell->val($row, $col) != '' || $cell->val($row, $col) != 0) {
                            $rkapms[$data['kode_perusahaan'][$col]][$data['kode_provinsi'][$row]] = $cell->val($row, $col);
                        }
                    }
                }

                foreach ($rkapms as $perusahaan => $provinsi) {
                    foreach ($provinsi as $kd_provinsi => $value) {
                        $nama_perusahaan = $data['perusahaan'][$perusahaan];
                        array_push($arr, array(
                            "KODE_PERUSAHAAN" => $perusahaan,
                            "NAMA_PERUSAHAAN" => $nama_perusahaan,
                            "PROPINSI" => $kd_provinsi,
                            "QTY" => $value,
                            "THN" => $data['tahun'],
                            "STATUS" => 0,
                            "CREATE_DATE" => 'SYSDATE',
                            "CREATE_BY" => $this->session->userdata('usernamescm')
                        ));
                    }
                }

                foreach ($arr as $key => $value) {
                    //$cekdata = true;
                    $cekdata = $this->Upload_model->cek_rkapms($value["KODE_PERUSAHAAN"], $value["PROPINSI"], $data['tahun']);
                    if ($cekdata) {
                        $value['UPDATE_BY'] = $this->session->userdata('usernamescm');
                        $message = $this->Upload_model->update_rkapms($value);
                        //echo 'ada<br/>';
                    } else {
                        $message = $this->Upload_model->insert_scm($value, 'ZREPORT_MS_RKAPMS');
                        //echo 'tidak ada<br/>';
                    }
                    array_push($datax, array(
                        "KODE_PERUSAHAAN" => $value["KODE_PERUSAHAAN"],
                        "NAMA_PERUSAHAAN" => $value["NAMA_PERUSAHAAN"],
                        "PROPINSI" => $value["PROPINSI"],
                        "QTY" => $value["QTY"],
                        "THN" => $value["THN"],
                        "STATUS" => $value["STATUS"],
                        "MESSAGE" => $message
                    ));
                }
            } else {
                echo "<script>alert('Invalid file, Must be Excel 2003...!!');</script>";
            }

            $this->Uview('RKAP Market Share', 'rkapms', 'template_upload_rkapms.xls', $datax);
        }
    }

    function trans() {
        include_once ( APPPATH . "libraries/excel_reader2.php");
        $datax = array();
        if (isset($_POST['Upload'])) {
            $allowedExts = "xls";
            $extension = @end(explode(".", $_FILES["file"]["name"]));
            if ($extension == $allowedExts) {
                //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                $pecah = $_FILES["file"]["name"];
                $pecahTanda = explode("_", $pecah);

                $cell = new Spreadsheet_Excel_Reader($_FILES['file']['tmp_name']);
                $jumlah_row = $cell->rowcount($sheet_index = 0);
                $jumlah_col = $cell->colcount($sheet_index = 0);

                $marketshare = array();
                $data = array();
                $arr = array();

                if (strlen($cell->val(2, 2)) == 1) {
                    $data['bulan'] = '0' . $cell->val(2, 2);
                } else {
                    $data['bulan'] = $cell->val(2, 2);
                }
                $data['tahun'] = $cell->val(1, 2);

                for ($i = 7; $i <= $jumlah_row; $i++) {
                    $data['kode_daerah'][$i] = $cell->val($i, 2);
                }

                for ($i = 4; $i <= $jumlah_col; $i++) {
                    $data['kode_perusahaan'][$i] = $cell->val(4, $i);
                }

                for ($i = 4; $i <= $jumlah_col; $i++) {
                    $data['tipe'][$i] = $cell->val(6, $i);
                }

                for ($row = 7; $row <= $jumlah_row; $row++) {
                    for ($col = 4; $col <= $jumlah_row; $col++) {
                        if ($cell->val($row, $col) != '' || $cell->val($row, $col) != 0) {
                            $marketshare[$data['kode_perusahaan'][$col]][$data['kode_daerah'][$row]][$data['tipe'][$col]] = $cell->val($row, $col);
                        }
                    }
                }
                //echo $fungsi->getNamaPerusahaan(101);
                foreach ($marketshare as $perusahaan => $value) {
                    foreach ($value as $provinsi => $prov_value) {
                        if ($perusahaan != '') {
                            $nama_perusahaan = $this->Upload_model->getNamaPerusahaan($perusahaan);
                            //echo $perusahaan;
                        }
                        if (key_exists('Bag', $prov_value)) {
                            array_push($arr, array(
                                "KODE_PERUSAHAAN" => $perusahaan,
                                "NAMA_PERUSAHAAN" => $nama_perusahaan,
                                "PROPINSI" => $provinsi,
                                "QTY_REAL" => $prov_value['Bag'],
                                "BULAN" => $data['bulan'],
                                "TAHUN" => $data['tahun'],
                                "TIPE" => '121-301',
                                "STATUS" => 0,
                                "CREATE_DATE" => 'SYSDATE',
                                "CREATE_BY" => $this->session->userdata('usernamescm')
                            ));
                        }
                        if (key_exists('Bulk', $prov_value)) {
                            array_push($arr, array(
                                "KODE_PERUSAHAAN" => $perusahaan,
                                "NAMA_PERUSAHAAN" => $nama_perusahaan,
                                "PROPINSI" => $provinsi,
                                "QTY_REAL" => $prov_value['Bulk'],
                                "BULAN" => $data['bulan'],
                                "TAHUN" => $data['tahun'],
                                "TIPE" => '121-302',
                                "STATUS" => 0,
                                "CREATE_DATE" => 'SYSDATE',
                                "CREATE_BY" => $this->session->userdata('usernamescm')
                            ));
                        }
                    }
                }

                foreach ($arr as $value) {
                    //$cekdata = true;
                    $cekdata = $this->Upload_model->cek_mstrans($value);
                    if ($cekdata) {
                        $value['UPDATE_BY'] = $this->session->userdata('usernamescm');
                        $message = $this->Upload_model->update_mstrans($value);
                        //echo 'ada<br/>';
                    } else {
                        $message = $this->Upload_model->insert_scm($value, 'ZREPORT_MS_TRANS1');
                        //echo 'tidak ada<br/>';
                    }
                    //$message = 'detected';
                    array_push($datax, array(
                        "KODE_PERUSAHAAN" => $value["KODE_PERUSAHAAN"],
                        "NAMA_PERUSAHAAN" => $value["NAMA_PERUSAHAAN"],
                        "PROPINSI" => $value["PROPINSI"],
                        "QTY_REAL" => $value["QTY_REAL"],
                        "BULAN" => $value["BULAN"],
                        "TAHUN" => $value["TAHUN"],
                        "TIPE" => $value["TIPE"],
                        "STATUS" => $value["STATUS"],
                        "MESSAGE" => $message
                    ));
                }
            } else {
                echo "<script>alert('Invalid file, Must be Excel 2003...!!');</script>";
            }
            $this->Uview('Market Share', 'trans', 'template_upload_mstrans.xls', $datax);
        }
    }

    function demand_harian() {
        include_once ( APPPATH . "libraries/excel_reader2.php");
        $datax = array();
        if (isset($_POST['Upload'])) {
            $allowedExts = "xls";
            $extension = end(explode(".", $_FILES["file"]["name"]));
            if ($extension == $allowedExts) {
                //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                $pecah = $_FILES["file"]["name"];
                $pecahTanda = explode("_", $pecah);

                $cell = new Spreadsheet_Excel_Reader($_FILES['file']['tmp_name']);
                $jumlah_row = $cell->rowcount($sheet_index = 0);
                $jumlah_col = $cell->colcount($sheet_index = 0);

                $rkapms = array();
                $data = array();
                $arr = array();

                $data['tahun'] = $cell->val(1, 2);
                $data['bulan'] = str_pad($cell->val(2, 2), 2, '0', STR_PAD_LEFT);
                $propinsi = array();
                for ($row = 5; $row <= $jumlah_row; $row++) {
                    if ($cell->val($row, 4) != '') {
                        array_push($arr, array(
                            "KD_PROV" => $cell->val($row, 2),
                            "QTY" => $cell->val($row, 4),
                            "TAHUN" => $data['tahun'],
                            "BULAN" => $data['bulan'],
                            "CREATE_DATE" => 'SYSDATE',
                            "CREATE_BY" => $this->session->userdata('usernamescm')
                        ));
                        $propinsi[$cell->val($row, 2)] = $cell->val($row, 3);
                    }
                }

                foreach ($arr as $key => $value) {
                    
                    $cekdata = $this->Upload_model->cek_msdemand($value);
                    if ($cekdata) {
                        $value['UPDATED_BY'] = $this->session->userdata('usernamescm');
                        $message = $this->Upload_model->update_msdemand($value);
                        //echo 'ada<br/>';
                    } else {
                        $message = $this->Upload_model->insert_scm($value, 'ZREPORT_SCM_DEMAND_PROVINSI');
                        //echo 'tidak ada<br/>';
                    }
                    array_push($datax, array(
                        "KD_PROV" => $value["KD_PROV"],
                        "PROPINSI" => $propinsi[$value["KD_PROV"]],
                        "TAHUN" => $value["TAHUN"],
                        "BULAN" => $value["BULAN"],
                        "QTY" => $value["QTY"],
                        "MESSAGE" => $message
                    ));
                }
            } else {
                echo "<script>alert('Invalid file, Must be Excel 2003...!!');</script>";
            }
            $this->Uview('Demand Harian', 'demand_harian', 'template_upload_ms_demand.xls', $datax);
        }
    }

}
