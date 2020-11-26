<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class PackingPlantSemenIndonesia extends CI_Controller {
	function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->model('PackingPlantSemenIndonesia_model');
    }

    function index() {
        $data = array('title' => 'Packing Plant Semen Gersik', 'nm_plant' => 'Semen Indonesia Group', 'url' => 'sg/PackingPlantSemenIndonesia/get_packing_plant/');
        $this->template->display('PackingPlant_view', $data);
    }

    function get_packing_plant(){
    	date_default_timezone_set("Asia/Jakarta");
    	$dt = '';
    	$tahun = date("Y");
		$bulan = date("m");
		$hari = date("d");
		$date = $tahun."-".$bulan."-".$hari;

    	$data = $this->PackingPlantSemenIndonesia_model->get_packing_plant($date);
    	$data_color = array('#F5F5F6' => array('bg' => 'white', 'color' => 'black'),
    						'white' => array('bg' => '#F5F5F6', 'color' => 'black'));
    	$data_fix = array();
    	$color = '#F5F5F6';

    	if (!empty($data)) {
    		foreach ($data as $d) {
    			$style = '';
    			if ($this->hidden_satuan($d['ZMP_KD_PLANT']) == 'ada') {
    				
    			}elseif ($this->hidden_range($d['ZMP_KD_PLANT']) == 'ada') {
    				# code...
    			}else{
    				$c_bg = $data_color[$color]['bg'];
    				$c_color = $data_color[$color]['color'];
    				$style = 'style="background: '.$c_bg.';color: '.$c_color.';"';

    				$dt .= '<tr '.$style.'>';
	    			$dt .= 	'<td rowspan="2" style="vertical-align: middle;text-align: center;">'.$d['ZMP_NAME'].'<br/>('.$d['ZMP_KD_PLANT'].')</td>';
	                $dt .= 	'<td class="center">Jumlah</td>';
	                $dt .= 	'<td class="center">'.$d['JTRUK_ZAK_10'].'</td>';                
	                $dt .= 	'<td class="center">'.$d['JTRUK_CURAH_10'].'</td>';                
	                $dt .= 	'<td class="center">'.$d['JTRUK_ZAK_40'].'</td>';                
	                $dt .= 	'<td class="center">'.$d['JTRUK_CURAH_40'].'</td>';                
	                $dt .= 	'<td class="center">'.$d['JTRUK_ZAK_5060'].'</td>';                
	                $dt .= 	'<td class="center">'.$d['JTRUK_CURAH_5060'].'</td>';                
	                $dt .= 	'<td class="center">'.$d['JTRUK_ZAK_70'].'</td>';                
	                $dt .= 	'<td class="center">'.$d['JTRUK_CURAH_70'].'</td>';
	                $dt .= 	'<td class="right">'.$this->cek_null_4_number((int)$d['VOLUME_ZAK']).' TON</td>';
	                $dt .= 	'<td class="right">'.$this->cek_null_4_number((int)$d['VOLUME_CURAH']).' TON</td>';
	    			$dt .= '</tr>';

	    			$dt .= '<tr '.$style.'>';
	    			$dt .= 	'<td style="display: none;">'.$d['ZMP_NAME'].'<br/>('.$d['ZMP_KD_PLANT'].')</td>';
	                $dt .= 	'<td class="center">Waktu</td>';
	                $dt .= 	'<td class="center">'.$this->jam($d['JWAKTU_ZAK_10']).'</td>';                
	                $dt .= 	'<td class="center">'.$this->jam($d['JWAKTU_CURAH_10']).'</td>';                
	                $dt .= 	'<td class="center">'.$this->jam($d['JWAKTU_ZAK_40']).'</td>';                
	                $dt .= 	'<td class="center">'.$this->jam($d['JWAKTU_CURAH_40']).'</td>';                
	                $dt .= 	'<td class="center">'.$this->jam($d['JWAKTU_ZAK_5060']).'</td>';                
	                $dt .= 	'<td class="center">'.$this->jam($d['JWAKTU_CURAH_5060']).'</td>';                
	                $dt .= 	'<td class="center">'.$this->jam($d['JWAKTU_ZAK_70']).'</td>';                
	                $dt .= 	'<td class="center">'.$this->jam($d['JWAKTU_CURAH_70']).'</td>';
	                $dt .= 	'<td></td>';
	                $dt .= 	'<td></td>';
	    			$dt .= '</tr>';

	    			$color = $data_color[$color]['bg'];
    			}
    		}
    	}

    	$data_fix['table'] = $dt;
    	echo json_encode($data_fix);
    }

    function jam($menit){
    	$detik = $menit * 60;
        $jam = (int)($detik / 3600);
        $sisa = $detik % 3600;
        $menit = (int)($sisa / 60);

        $hasil = '';
        if (strlen($jam) === 1) {
            $hasil .= '0' . $jam;
        } else if (is_nan($jam)) {
            $hasil .= '00';
        } else {
            $hasil .= $jam;
        }

        $hasil .= ':';
        if (strlen($menit) === 1) {
            $hasil .= '0' . $menit;
        } else if (is_nan($menit)) {
            $hasil .= '00';
        } else {
            $hasil .= $menit;
        }

        if ($hasil == '00:00') {
        	$hasil = '-';
        }else{
        	$hasil .= ' JAM';
        }

        return $hasil;
    }

    function hidden_satuan($plan){
    	$r = 'tidak_ada';
    	$a = array(3201,3301,3302,3303,3304,3305,3401,3402,3405,3501,3601,3602,3603,3604,3605,3606,3607,3608,3609,3610,3611,3612,3613,3614,3615,3616,3617,3618,3619,3620,3621,3622,3623,3624,3625,
    				3626,3627,3628,3629,3630,3631,3632,4406,4407,4410,4403,4501,4601,4602,4603,4604,4605,4606,4607,4608,4609,4610,4611,4612,4613,4614,4701,4801,4802,4803,4901,4902,5490,7301,7302,7303,7304,7305,
    				7306,7307,7402,7404,7416,7601,7602,7603,7604,7605,7606,7607,7608,7609,7610,7611,7612,7613,7614,7615,7616,7617,7618,7619,7620,7621,7622,7623,7624,7811);

    	if (in_array($plan, $a)) {
    		$r = 'ada';
    	}

    	return $r;
    }

    function hidden_range($plan){
    	$r = 'tidak_ada';

    	if ((int)$plan >= 3634 && (int)$plan <= 3902) {
    		$r = 'ada';
    	}elseif ((int)$plan >= 4201 && (int)$plan <= 4402) {
    		$r = 'ada';
    	}elseif ((int)$plan == 7812) { // pengecualian, plant ini tetap di tampilkan
    		$r = 'tidak_ada';
    	}elseif ((int)$plan >= 7600 && (int)$plan < 8000) {
    		$r = 'ada';
    	}

    	return $r;
    }

    function cek_null_4_number($n){
    	$r = 0;
    	if ($n != '' || $n != null) {
    		$r = $n;
    	}

    	return $r;
    }
}