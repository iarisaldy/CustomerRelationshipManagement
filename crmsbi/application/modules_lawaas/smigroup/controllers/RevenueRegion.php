<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class RevenueRegion extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        date_default_timezone_set("Asia/Jakarta");
//        $this->load->model('Demandpl_model');
//        $this->load->model('DemandplMS_model');
        $this->load->model('PetaPencapaianSales_model');
        $this->load->model('PencapaianProvinsi_model');
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
        $data['head'] = array('VOLUME (TON)', 'HARGA BRUTO (RP/TON)', 'OA (RP/TON)', 'HARGA NETT (RP/TON)', 'REVENUE NETT (RP. JT)'); //, 'Growth Real / Prognose');
       

        $this->template->display('RevenueRegion_view', $data);
    }

    function get_data_sdk($tahun, $bulan) {
        $region = 'all';

        if ($region == 'all') {
            $region = '1,2,3,4';
        } else if ($region == 'curah') {
            $region = '4';
        }

       
        $date = $tahun . '' . $bulan;

        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad(--$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $hari = date('d');

        $data = $this->PencapaianProvinsi_model->get_chart_volume($tahun, $bulan, $hari, $region);
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // echo $data[0]['PERSENTARGETH'];
        return $data;
    }

    // function getSummary($tahun, $bulan) {
    function getSummary($tahun,$bulan) {
        $this->load->model('RevenueRegion_model');
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Jakarta");

       
        $date = $tahun . '' . $bulan;

        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad(--$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $data = array();
        /* INISIALISASI VARIABLE */

        $region1 = $this->RevenueRegion_model->sumSalesRegion2('1', $tahun, $bulan, $hari);

        $region2 = $this->RevenueRegion_model->sumSalesRegion2('2', $tahun, $bulan, $hari);
        $region3 = $this->RevenueRegion_model->sumSalesRegion2('3', $tahun, $bulan, $hari);
        $curah = $this->RevenueRegion_model->sumSalesRegion2('4', $tahun, $bulan, $hari);

        $SMIG = $region1;

        foreach ($SMIG as $key => $value) {
            $SMIG[$key] = $value + $region2[$key] + $region3[$key] + $curah[$key];
        }

        $SMIG['PERSEN'] = ($this->getPersen($SMIG['REAL'], $SMIG['TARGET_REALH']));
        $SMIG['PERSENRKAP'] = ($this->getPersen($SMIG['REAL'], $SMIG['TARGET']));

        $arrData = array();

        $arrData = array(
            'SMIG' => $SMIG,
            'REGION1' => $region1,
            'REGION2' => $region2,
            'REGION3' => $region3,
            'CURAH' => $curah
        );

        return $arrData;
    }

    function getSummaryRevenue($tahun,$bulan) {
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Jakarta");

       
        $date = $tahun . '' . $bulan;

        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad(--$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $data = array();
        /* INISIALISASI VARIABLE */

        $region1 = $this->PetaPencapaianSales_model->sumSalesRegionRevenue('1', $tahun, $bulan, $hari);

        $region2 = $this->PetaPencapaianSales_model->sumSalesRegionRevenue('2', $tahun, $bulan, $hari);
        $region3 = $this->PetaPencapaianSales_model->sumSalesRegionRevenue('3', $tahun, $bulan, $hari);
        $curah = $this->PetaPencapaianSales_model->sumSalesRegionRevenue('4', $tahun, $bulan, $hari);

        $SMIG = $region1;

        foreach ($SMIG as $key => $value) {
            $SMIG[$key] = $value + $region2[$key] + $region3[$key] + $curah[$key];
        }

        $SMIG['PERSEN'] = ($this->getPersen($SMIG['REAL'], $SMIG['TARGET_REALH']));
        $SMIG['PERSENRKAP'] = ($this->getPersen($SMIG['REAL'], $SMIG['TARGET']));

        $arrData = array();

        $arrData = array(
            'SMIG' => $SMIG,
            'REGION1' => $region1,
            'REGION2' => $region2,
            'REGION3' => $region3,
            'CURAH' => $curah
        );

        // echo '<pre>';
        //     print_r($arrData);
        // echo '<pre>';
        // echo '<br>';

        return $arrData;
    }

    function getSummaryHarga($tahun,$bulan) {
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Jakarta");

       
        $date = $tahun . '' . $bulan;

        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad(--$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $data = array();
        /* INISIALISASI VARIABLE */

        $region1 = $this->PetaPencapaianSales_model->sumSalesRegionHarga('1', $tahun, $bulan, $hari);

        $region2 = $this->PetaPencapaianSales_model->sumSalesRegionHarga('2', $tahun, $bulan, $hari);
        $region3 = $this->PetaPencapaianSales_model->sumSalesRegionHarga('3', $tahun, $bulan, $hari);
        $curah = $this->PetaPencapaianSales_model->sumSalesRegionHarga('4', $tahun, $bulan, $hari);

        $SMIG = $region1;

        foreach ($SMIG as $key => $value) {
            $SMIG[$key] = $value + $region2[$key] + $region3[$key] + $curah[$key];
        }

        $SMIG['PERSEN'] = ($this->getPersen($SMIG['REAL'], $SMIG['TARGET_REALH']));
        $SMIG['PERSENRKAP'] = ($this->getPersen($SMIG['REAL'], $SMIG['TARGET']));

        $arrData = array();

        $arrData = array(
            'SMIG' => $SMIG,
            'REGION1' => $region1,
            'REGION2' => $region2,
            'REGION3' => $region3,
            'CURAH' => $curah
        );

        // echo '<pre>';
        //     print_r($arrData);
        // echo '<pre>';
        // echo '<br>';

        return $arrData;
    }

    function getSummaryOA($tahun,$bulan) {
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Jakarta");

        
        $date = $tahun . '' . $bulan;

        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad(--$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $data = array();
        /* INISIALISASI VARIABLE */

        $region1 = $this->PetaPencapaianSales_model->sumSalesRegionOA('1', $tahun, $bulan, $hari);
        $region2 = $this->PetaPencapaianSales_model->sumSalesRegionOA('2', $tahun, $bulan, $hari);
        $region3 = $this->PetaPencapaianSales_model->sumSalesRegionOA('3', $tahun, $bulan, $hari);
        $curah = $this->PetaPencapaianSales_model->sumSalesRegionOA('4', $tahun, $bulan, $hari);

        $SMIG = $region1;

        foreach ($SMIG as $key => $value) {
            $SMIG[$key] = $value + $region2[$key] + $region3[$key] + $curah[$key];
        }

        $SMIG['PERSEN'] = ($this->getPersen($SMIG['REAL'], $SMIG['TARGET_REALH']));
        $SMIG['PERSENRKAP'] = ($this->getPersen($SMIG['REAL'], $SMIG['TARGET']));

        $arrData = array();

        $arrData = array(
            'SMIG' => $SMIG,
            'REGION1' => $region1,
            'REGION2' => $region2,
            'REGION3' => $region3,
            'CURAH' => $curah
        );

        // echo '<pre>';
        //     print_r($arrData);
        // echo '<pre>';
        // echo '<br>';

        return $arrData;
    }

    function getHVR($tahun, $bulan) {
        $date = $tahun . $bulan;
        $this->load->model('RevenueRegion_model');
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad(--$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $SMIG = $this->RevenueRegion_model->getVHR('1,2,3,4', $tahun, $bulan, $hari);
//        echo $this->db->last_query();
        $region1 = $this->RevenueRegion_model->getVHR('1', $tahun, $bulan, $hari);
        $region2 = $this->RevenueRegion_model->getVHR('2', $tahun, $bulan, $hari);
        $region3 = $this->RevenueRegion_model->getVHR('3', $tahun, $bulan, $hari);
        $curah = $this->RevenueRegion_model->getVHR('4', $tahun, $bulan, $hari);
      
        $arrData = array(
            'SMIG' => $SMIG,
            'REGION1' => $region1,
            'REGION2' => $region2,
            'REGION3' => $region3,
            'CURAH' => $curah,
            'DataRKAP' => $this->getSummary($tahun, $bulan),
            'DataRevenue' => $this->getSummaryRevenue($tahun, $bulan),
            'DataHarga' => $this->getSummaryHarga($tahun, $bulan),
            'DataHargaOA' => $this->getSummaryOA($tahun, $bulan),
            'Pencapaian' => $this->get_data_sdk($tahun, $bulan)
        );
        echo json_encode($arrData);
    }

    function getPersen($a, $b) {
        if ($b == 0 || $b == '') {
            return 0;
        } else {
            return $a / $b * 100;
        }
    }

}
