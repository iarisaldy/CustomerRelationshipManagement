<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class MonitoringRevenue extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
         date_default_timezone_set("Asia/Jakarta");
//        $this->load->model('Demandpl_model');
//        $this->load->model('DemandplMS_model');
        set_time_limit(0);
    }

    public function index() {
        $data = array('title' => 'Sales & Operations Planning');
        $tgl = date("d-m-Y");
        $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
        $bulan = array(
            "01" => "Januari",
            "02" => "Februari",
            "03" => "Maret",
            "04" => "April",
            "05" => "Mei",
            "06" => "Juni",
            "07" => "Juli",
            "08" => "Agustus",
            "09" => "September",
            "10" => "Oktober",
            "11" => "November",
            "12" => "Desember"
        );
        $n = date("w", strtotime($tgl));
        
        $data['tanggal'] = $hari[$n] . ", " . date('d') . " " . $bulan[date('m')] . " " . date('Y');
        $data['head'] = array('Volume Dom', 'Harga Bruto Dom', 'OA Dom', 'Harga Nett Dom', 'Revenue Dom(JT)', 'Volume Export', 'Volume Total', 'Revenue Total (JT)'); //, 'Growth Real / Prognose');
        $this->template->display('MonitoringRevenue_view', $data);
    }
}