<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class OptimasiMargin extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        date_default_timezone_set("Asia/Jakarta");
//        $this->load->model('Demandpl_model');
//        $this->load->model('DemandplMS_model');
        set_time_limit(0);
    }

    function index() {
        $data = array('title' => 'Optimasi Margin');
        $this->template->display('OptimasiMargin_view', $data);
    }
    
    function getPersen($a, $b) {
        if ($b == 0 || $b == '') {
            return 0;
        } else {
            return $a / $b * 100;
        }
    }

    function getDataChart($region, $tahun, $bulan, $hari) {
        $this->load->model('OptimasiMargin_model');
        
        $bulanText = array (
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );
        
        switch ($region){
            case 'all' :
                $reg = '1,2,3,4';
                break;
            case 'curah' :
                $reg = '4';
                break;
            default :
                $reg = $region;
                break;
           
        }
        
        $data = $this->OptimasiMargin_model->getData($reg, $tahun, $bulan, $hari);
       // echo $this->db->last_query();

        $bag = array(
            'PROV' => array(),
            'TARGET' => array(),
            'REAL' => array(),
            'TARGETSDK' => array(),
            'SELISIH' => array(),
            'MARGIN' => array(),
            'PERSENSDK' => array(),
            'PERSENBLN' => array(),
            'PERSENTARGET' => array(),
            'PERSENBLNGF' => array(),
            'PERSENSEH' => array(),
            'TES1' => array(),
            'TES2' => array()
        );
        $bulk = array(
            'PROV' => array(),
            'TARGET' => array(),
            'REAL' => array(),
            'TARGETSDK' => array(),
            'SELISIH' => array(),
            'MARGIN' => array(),
            'PERSENSDK' => array(),
            'PERSENBLNGF' => array(),
            'PERSENBLN' => array(),
            'PERSENTARGET' => array(),
            'PERSENSEH' => array(),
            'TES1' => array(),
            'TES2' => array()
        );
        $nobag = 0;
        $nobulk = 0;
        foreach ($data as $key => $value) {
            if ($value['MATERIAL'] == '121-301') {
                array_push($bag['PROV'], ++$nobag .'. '.$value['NM_PROV']);
                array_push($bag['TARGET'], number_format(($value['TARGET']), 0, ',', '.'));
                array_push($bag['REAL'], number_format(($value['REAL']), 0, ',', '.'));
                array_push($bag['TARGETSDK'], number_format(($value['TARGET_REALH']), 0, ',', '.'));
                array_push($bag['SELISIH'], number_format(($value['SEL_SDK']), 0, ',', '.'));
                array_push($bag['MARGIN'], number_format(($value['MARGIN']), 0, ',', '.'));
                array_push($bag['PERSENSDK'], floatval($value['PERSENTARGETH']));
                array_push($bag['PERSENBLNGF'], floatval($value['PERSENTARGET'])>100? 100: floatval($value['PERSENTARGET']));
                array_push($bag['PERSENBLN'], floatval($value['PERSENTARGET']));
                array_push($bag['PERSENSEH'], round($this->getPersen($value['TARGET_REALH'],$value['TARGET'])));
                array_push($bag['PERSENTARGET'], floatval(100));
                array_push($bag['TES1'], floatval(170));
                array_push($bag['TES2'], floatval(130));
            } else {
                array_push($bulk['PROV'], ++$nobulk .'. '.$value['NM_PROV']);
                array_push($bulk['TARGET'], number_format(($value['TARGET']), 0, ',', '.'));
                array_push($bulk['REAL'], number_format(($value['REAL']), 0, ',', '.'));
                array_push($bulk['TARGETSDK'], number_format(($value['TARGET_REALH']), 0, ',', '.'));
                array_push($bulk['PERSENBLNGF'], floatval($value['PERSENTARGET'])>100? 100: floatval($value['PERSENTARGET']));
                array_push($bulk['SELISIH'], number_format(($value['SEL_SDK']), 0, ',', '.'));
                 array_push($bulk['MARGIN'], number_format(($value['MARGIN']), 0, ',', '.'));
                array_push($bulk['PERSENSDK'], floatval($value['PERSENTARGETH']));
                array_push($bulk['PERSENBLN'], floatval($value['PERSENTARGET']));
                array_push($bulk['PERSENSEH'],round($this->getPersen($value['TARGET_REALH'],$value['TARGET'])));
                array_push($bulk['PERSENTARGET'], floatval(100));
                array_push($bulk['TES1'], floatval(170));
                array_push($bulk['TES2'], floatval(130));
            }
        }

        echo json_encode(
                array(
                    'bag' => $bag,
                    'bulk' => $bulk,
                    'pencSeharusnya' => (isset($data[0]['TARGET_REALH']) ? round($data[0]['TARGET_REALH'] / $data[0]['TARGET'] * 100) : ''),
                    'dateMargin' => (isset($data[0]['BLNMARGIN']) ? $bulanText[$data[0]['BLNMARGIN']] . ' ' . $data[0]['THNMARGIN'] : '-'),
                    'sdkVis' => ($tahun.''.$bulan == date('Ym') ? true:false)
                )
        );
    }

    

}
