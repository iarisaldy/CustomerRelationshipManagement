<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class PetaPencapaian extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->model('PetaPencapaian_model');
        error_reporting(0);
    }

    function index() {
        $data = array('title' => 'Peta Pencapaian');
        $this->template->display('PetaPencapaian_view', $data);
    }

    function scodata($org, $tahun, $bulan) {
        date_default_timezone_set("Asia/Jakarta");
//        $tahun = date("Y");
//        $bulan = date("m");
        $date = $tahun . '' . $bulan;
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad( --$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        $arrData = array(
            "chart" => array(
                "caption" => "Realisasi Penjualan Terhadap RKAP s/d " . $hari . " " . $this->bulan($bulan) . " " . $tahun,
                "theme" => "fint",
                "formatNumberScale" => "0",
                "numberSuffix" => "%",
                "showLabels" => "1",
                "includeNameInLabels" => "1",
                "nullEntityColor" => "#C2C2D6",
                "nullEntityAlpha" => "50",
                "hoverOnNull" => "0",
                "useSNameInLabels" => "1",
                "legendPosition" => "bottom",
                "showToolTip" => "1",
                "baseFontSize" => "14",
                "legendItemFontColor" => "#000",
                "toolTipBgColor" => "#E0E0E0"
            ),
            "colorrange" => array(
                "color" => array(
                    array(
                        "minvalue" => "-100",
                        "maxvalue" => "90",
                        "code" => "#ff4545",
                        "displayValue" => "< 90%"
                    ),
                    array(
                        "minvalue" => "90",
                        "maxvalue" => "100",
                        "code" => "#fef536",
                        "displayValue" => "90%-100%"
                    ),
                    array(
                        "minvalue" => "100",
                        "maxvalue" => "1000000",
                        "code" => "#49ff56",
                        "displayValue" => "> 100%"
                    )
                )
            ),
            "entityDef" => array(
                array(
                    "internalId" => "01",
                    "newId" => "1010"
                ),
                array(
                    "internalId" => "02",
                    "newId" => "1026"
                ),
                array(
                    "internalId" => "35",
                    "newId" => "1017"
                ),
                array(
                    "internalId" => "33",
                    "newId" => "1020"
                ),
                array(
                    "internalId" => "03",
                    "newId" => "1018"
                ),
                array(
                    "internalId" => "07",
                    "newId" => "1023"
                ),
                array(
                    "internalId" => "13",
                    "newId" => "1031"
                ),
                array(
                    "internalId" => "21",
                    "newId" => "1036"
                ),
                array(
                    "internalId" => "08",
                    "newId" => "1025"
                ),
                array(
                    "internalId" => "14",
                    "newId" => "1032"
                ),
                array(
                    "internalId" => "18",
                    "newId" => "1028"
                ),
                array(
                    "internalId" => "34",
                    "newId" => "1038"
                ),
                array(
                    "internalId" => "04",
                    "newId" => "1021"
                ),
                array(
                    "internalId" => "05",
                    "newId" => "1015"
                ),
                array(
                    "internalId" => "15",
                    "newId" => "1019"
                ),
                array(
                    "internalId" => "28",
                    "newId" => "1039"
                ),
                array(
                    "internalId" => "42",
                    "newId" => "1043"
                ),
                array(
                    "internalId" => "29",
                    "newId" => "1040"
                ),
                array(
                    "internalId" => "31",
                    "newId" => "1037"
                ),
                array(
                    "internalId" => "26",
                    "newId" => "1011"
                ),
                array(
                    "internalId" => "36",
                    "newId" => "1041"
                ),
                array(
                    "internalId" => "37",
                    "newId" => "1013"
                ),
                array(
                    "internalId" => "40",
                    "newId" => "1014"
                ),
                array(
                    "internalId" => "22",
                    "newId" => "1035"
                ),
                array(
                    "internalId" => "12",
                    "newId" => "1030"
                ),
                array(
                    "internalId" => "38",
                    "newId" => "1033"
                ),
                array(
                    "internalId" => "32",
                    "newId" => "1016"
                ),
                array(
                    "internalId" => "30",
                    "newId" => "1022"
                ),
                array(
                    "internalId" => "11",
                    "newId" => "1029"
                ),
                array(
                    "internalId" => "17",
                    "newId" => "1027"
                ),
                array(
                    "internalId" => "39",
                    "newId" => "1042"
                ),
                array(
                    "internalId" => "41",
                    "newId" => "1034"
                ),
                array(
                    "internalId" => "24",
                    "newId" => "1012"
                ),
                array(
                    "internalId" => "10",
                    "newId" => "1024"
                )
            )
        );
        $arrData["data"] = array();
        $data = array();

        if ($org == 1) {
            $dataSMIG = $this->scodatasmig($tahun, $bulan);
            $arrData["data"] = $dataSMIG;
        } else {
            $data = $this->getscodataopco($org, $tahun, $bulan, $hari);
        }

        $bulanBaru = date('t', strtotime($tahun . "-" . $bulan));
        $a_date = $tahun . "-" . $bulan;
        $tgl_akhir = date("t", strtotime($a_date));
        $harisisa = $tgl_akhir - $hari;
        $harisisa = $harisisa != 0 ? $harisisa : 1;
        foreach ($data as $row) {
            if (empty($row['TARGET_REALH']) || $row['TARGET_REALH'] < 1) {
                $tRealH = ($row['TARGET'] * $hari) / $bulanBaru;
            } else {
                $tRealH = $row['TARGET_REALH'];
            }
            if ($tRealH == 0) {
                $persen = 0;
            } else {
                $persen = ($row["REAL"] / $tRealH) * 100;
            }
            $target = round($row['TARGET']);
            if ($target == 0) {
                $tampilpersen = 0;
            } else {
                $tampilpersen = ($row["REAL"] / $target) * 100;
            }
            $target_harian = round(($target - round($row['REAL'])) / $harisisa);
            if ($target_harian <= 0) {
                $target_harian = '-';
            } else {
                $target_harian = number_format($target_harian, 0, '', '.');
            }
            $harian_max = number_format(round($row['HARIAN_MAX']), 0, '', '.');
            $totalreal = number_format(round($row['REAL']), 0, '', '.');
            $totalrealbag = number_format(round($row['REAL_BAG']), 0, '', '.');
            $totalrealbulk = number_format(round($row['REAL_BULK']), 0, '', '.');
            $totalrealtl = number_format(round($row['REAL_THNLALU']), 0, '', '.');
            $totalrealbagtl = number_format(round($row['REAL_BAG_THNLALU']), 0, '', '.');
            $totalrealbulktl = number_format(round($row['REAL_BULK_THNLALU']), 0, '', '.');
            $growthreal =  round($this->getpersen($row['REAL'],$row['REAL_THNLALU']));
            $growthrealbag =  round($this->getpersen($row['REAL_BAG'],$row['REAL_BAG_THNLALU']));
            $growthrealbulk =  round($this->getpersen($row['REAL_BULK'],$row['REAL_BULK_THNLALU']));
            $pencapaian = round($persen);
            $pencapaianrkap = round($tampilpersen);
            if ($pencapaian >= -100 && $pencapaian <= 90) {
                $color = '#ff4545';
            } else if ($pencapaian >= 90 && $pencapaian < 100) {
                $color = '#fef536';
            } else if ($pencapaian >= 100) {
                $color = '#49ff56';
            }
            if ($target < round($row['REAL'])) {
                $colorreal = 'green';
            } else {
                $colorreal = 'red';
            }
            
            if($growthreal<100){
                $warnareal = '#ff4545'; 
            }
            
            if($growthrealbag<100){
                $warnarealbag = '#ff4545';
            }
            
            if($growthrealbulk<100){
                $warnarealbulk = '#ff4545';
            }
            
            $tooltip = "<table style='color:black;width:150px;'>
                            <thead>
                            <tr><th colspan='2' style='background-color:$color'><b>" . $row['NM_PROV'] . "</b></th></tr>
                            </thead>
                            <tbody>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Pencapaian Target RKAP :</td>
                                    <td><span class='pull-right'>" . $pencapaianrkap . " %</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Pencapaian Target Harian :</td>
                                    <td><span class='pull-right'>" . $pencapaian . " %</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>RKAP :</td>
                                    <td><span class='pull-right'>" . number_format($target, 0, '', '.') . " Ton</span></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>Realisasi</td>
                                </tr>
                                <tr>
                                    <td>Bag :</td>
                                    <td><span class='pull-right'>$totalrealbag Ton</span></td>
                                </tr>
                                <tr>
                                    <td>Bulk :</td>
                                    <td><span class='pull-right'>$totalrealbulk Ton</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Total :</td>
                                    <td><span class='pull-right'>$totalreal Ton</span></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>Realisasi Tahun Lalu</td>
                                </tr>
                                <tr>
                                    <td>Bag :</td>
                                    <td><span class='pull-right'>$totalrealbagtl Ton</span></td>
                                </tr>
                                <tr>
                                    <td>Bulk :</td>
                                    <td><span class='pull-right'>$totalrealbulktl Ton</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Total :</td>
                                    <td><span class='pull-right'>$totalrealtl Ton</span></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>Growth</td>
                                </tr>
                                <tr>
                                    <td>Bag :</td>
                                    <td><span class='pull-right' style='color:$warnarealbag'>$growthrealbag %</span></td>
                                </tr>
                                <tr>
                                    <td>Bulk :</td>
                                    <td><span class='pull-right' style='color:$warnarealbulk'>$growthrealbulk %</span></td>
                                </tr>
                                <tr style='border-bottom: 2px solid;'>
                                    <td>Total :</td>
                                    <td><span class='pull-right' style='color:$warnareal'>$growthreal %</span></td>
                                </tr>
                                <tr>
                                    <td>Max Real / day :</td>
                                    <td><span class='pull-right' style='color:$colorreal'>$harian_max Ton</span></td>
                                </tr>
                                <tr>
                                    <td>Plan Target / day :</td>
                                    <td><span class='pull-right' style='color:$colorreal'>" . $target_harian . " Ton</span></td>
                                </tr>
                            </tbody>
                        </table>";
            array_push($arrData["data"], array(
                "id" => $row["PROV"],
                "value" => $pencapaian,
                "tooltext" => $tooltip
            ));
        }
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
        echo json_encode(array(
            "data" => $arrData
        ));
    }

    function bulan($n) {
        $bulan['01'] = "Januari";
        $bulan['02'] = "Februari";
        $bulan['03'] = "Maret";
        $bulan['04'] = "April";
        $bulan['05'] = "Mei";
        $bulan['06'] = "Juni";
        $bulan['07'] = "Juli";
        $bulan['08'] = "Agustus";
        $bulan['09'] = "September";
        $bulan['10'] = "Oktober";
        $bulan['11'] = "November";
        $bulan['12'] = "Desember";

        return $bulan[$n];
    }

    function scodatasmig($tahun, $bulan) {
        date_default_timezone_set("Asia/Jakarta");
//        $tahun = date("Y");
//        $bulan = date("m");
        $date = $tahun . '' . $bulan;
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad( --$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $bulanBaru = date('t', strtotime($tahun . "-" . $bulan));

        /* INISIALISASI VARIABLE */

        $data = $this->PetaPencapaian_model->getProv();

        $sg = $this->PetaPencapaian_model->scodatamv('7000', $tahun, $bulan, $hari);
        $st = $this->PetaPencapaian_model->scodatamv('4000', $tahun, $bulan, $hari);
        $sp = $this->PetaPencapaian_model->scodatamv('3000', $tahun, $bulan, $hari);

        
        $prov = array();
        foreach ($data as $value) {
            $prov[$value['KD_PROV']]['REAL'] = 0;
            $prov[$value['KD_PROV']]['TARGET_REALH'] = 0;
            $prov[$value['KD_PROV']]['TARGET'] = 0;
            $prov[$value['KD_PROV']]['REAL_TAHUN_INI'] = 0;
            $prov[$value['KD_PROV']]['REAL_TAHUN_KEMARIN'] = 0;
            $prov[$value['KD_PROV']]['REAL_BAG'] = 0;
            $prov[$value['KD_PROV']]['REAL_BULK'] = 0;
            $prov[$value['KD_PROV']]['REAL_THNLALU'] = 0;
            $prov[$value['KD_PROV']]['REAL_BAG_THNLALU'] = 0;
            $prov[$value['KD_PROV']]['REAL_BULK_THNLALU'] = 0;
        }
        foreach ($sg as $value) {
            if ($value['TARGET_REALH'] != 0) {
                $prov[$value['PROV']]['REAL'] += $value['REAL'];
                $prov[$value['PROV']]['TARGET_REALH'] += $value['TARGET_REALH'];
            } else if ($value['TARGET_REALH'] == 0 || empty($value['TARGET_REALH'])) {
                $prov[$value['PROV']]['REAL'] += $value['REAL'];
                $temp = ($value['TARGET'] * $hari) / $bulanBaru;
                $prov[$value['PROV']]['TARGET_REALH'] += $temp;
            }
            $prov[$value['PROV']]['REAL_BAG'] += $value['REAL_BAG'];
            $prov[$value['PROV']]['REAL_BULK'] += $value['REAL_BULK'];
            $prov[$value['PROV']]['TARGET'] += $value['TARGET'];
            $prov[$value['PROV']]['NM_PROV'] = $value['NM_PROV'];
            $prov[$value['PROV']]['REAL_THNLALU'] += $value['REAL_THNLALU'];
            $prov[$value['PROV']]['REAL_BAG_THNLALU'] += $value['REAL_BAG_THNLALU'];
            $prov[$value['PROV']]['REAL_BULK_THNLALU'] += $value['REAL_BULK_THNLALU'];
            
        }
        foreach ($st as $value) {
            if ($value['TARGET_REALH'] != 0) {
                $prov[$value['PROV']]['REAL'] += $value['REAL'];
                $prov[$value['PROV']]['TARGET_REALH'] += $value['TARGET_REALH'];
            } else if ($value['TARGET_REALH'] == 0 || empty($value['TARGET_REALH'])) {
                $prov[$value['PROV']]['REAL'] += $value['REAL'];
                $temp = ($value['TARGET'] * $hari) / $bulanBaru;
                $prov[$value['PROV']]['TARGET_REALH'] += $temp;
            }
            $prov[$value['PROV']]['REAL_BAG'] += $value['REAL_BAG'];
            $prov[$value['PROV']]['REAL_BULK'] += $value['REAL_BULK'];
            $prov[$value['PROV']]['TARGET'] += $value['TARGET'];
            $prov[$value['PROV']]['NM_PROV'] = $value['NM_PROV'];
            $prov[$value['PROV']]['REAL_THNLALU'] += $value['REAL_THNLALU'];
            $prov[$value['PROV']]['REAL_BAG_THNLALU'] += $value['REAL_BAG_THNLALU'];
            $prov[$value['PROV']]['REAL_BULK_THNLALU'] += $value['REAL_BULK_THNLALU'];
        }
        foreach ($sp as $value) {
            if ($value['TARGET_REALH'] != 0) {
                $prov[$value['PROV']]['REAL'] += $value['REAL'];
                $prov[$value['PROV']]['TARGET_REALH'] += $value['TARGET_REALH'];
            } else if ($value['TARGET_REALH'] == 0 || empty($value['TARGET_REALH'])) {
                $prov[$value['PROV']]['REAL'] += $value['REAL'];
                $temp = ($value['TARGET'] * $hari) / $bulanBaru;
                $prov[$value['PROV']]['TARGET_REALH'] += $temp;
            }
            $prov[$value['PROV']]['REAL_BAG'] += $value['REAL_BAG'];
            $prov[$value['PROV']]['REAL_BULK'] += $value['REAL_BULK'];
            $prov[$value['PROV']]['TARGET'] += $value['TARGET'];
            $prov[$value['PROV']]['NM_PROV'] = $value['NM_PROV'];
            $prov[$value['PROV']]['REAL_THNLALU'] += $value['REAL_THNLALU'];
            $prov[$value['PROV']]['REAL_BAG_THNLALU'] += $value['REAL_BAG_THNLALU'];
            $prov[$value['PROV']]['REAL_BULK_THNLALU'] += $value['REAL_BULK_THNLALU'];
        }
        
        

        $arrData = array();
        foreach ($prov as $key => $row) {
            if ($row["TARGET_REALH"] != 0) {
                $persen = ($row["REAL"] / $row["TARGET_REALH"]) * 100;
            } else {
                $persen = 0;
            }
            $totalreal = number_format(round($row['REAL']), 0, '', '.');
            $totalrealbag = number_format(round($row['REAL_BAG']), 0, '', '.');
            $totalrealbulk = number_format(round($row['REAL_BULK']), 0, '', '.');
            $totalrealtl = number_format(round($row['REAL_THNLALU']), 0, '', '.');
            $totalrealbagtl = number_format(round($row['REAL_BAG_THNLALU']), 0, '', '.');
            $totalrealbulktl = number_format(round($row['REAL_BULK_THNLALU']), 0, '', '.');
            $growthreal =  round($this->getpersen($row['REAL'],$row['REAL_THNLALU']));
            $growthrealbag =  round($this->getpersen($row['REAL_BAG'],$row['REAL_BAG_THNLALU']));
            $growthrealbulk =  round($this->getpersen($row['REAL_BULK'],$row['REAL_BULK_THNLALU']));
//            $target = number_format($row['TARGET'], 0, '', '.');
            $pencapaian = round($persen);
            if ($pencapaian >= -100 && $pencapaian <= 90) {
                $color = '#ff4545';
            } else if ($pencapaian >= 90 && $pencapaian < 100) {
                $color = '#fef536';
            } else if ($pencapaian >= 100) {
                $color = '#49ff56';
            }
            
            $warnareal ='';
            $warnarealbag='';
            $warnarealbulk='';
            if($growthreal<100){
                $warnareal = '#ff4545'; 
            }
            
            if($growthrealbag<100){
                $warnarealbag = '#ff4545';
            }
            
            if($growthrealbulk<100){
                $warnarealbulk = '#ff4545';
            }
            
            $tooltip = "<div style='color:black; width:150px;'>"
                    . "<div style='background-color:$color';><b>" . $row['NM_PROV'] . "</b></div>"
                    . "<div><span class='pull-right'>" . $pencapaian . " %</span></div>"
                    . "<div>Pencapaian :<br><span class='pull-right'>$totalrealbag Ton </span></div>"
                    . "<div>Bag :<br><span class='pull-right'>$totalrealbulk Ton </span></div>"
                    . "<div>Bulk :<br><span class='pull-right'><b>$totalreal Ton</span></b></div>"
                    . "<div><b>Total :</b><br><br></</div>"
                    . "<div>Penc. Tahun Lalu :<br><span class='pull-right'>$totalrealbagtl Ton </span></div>"
                    . "<div>Bag :<br><span class='pull-right'>$totalrealbulktl Ton </span></div>"
                    . "<div>Bulk :<br><span class='pull-right'><b>$totalrealtl Ton</span></b></div>"
                    . "<div><b>Total :<br></b><br></div>"
                    . "<div>Growth :<br><span class='pull-right' style='color:$warnarealbag'>$growthrealbag % </span></div>"
                    . "<div>Bag :<br><span class='pull-right' style='color:$warnarealbulk'>$growthrealbulk % </span></div>"
                    . "<div>Bulk :<br><span class='pull-right' style='color:$warnareal'><b>$growthreal %</span></b></div>"
                    . "<div><b>Total :<br></b></div>"
                    . "</div>";
            array_push($arrData, array(
                "id" => $key . "",
                "value" => round($persen),
                "tooltext" => $tooltip
            ));
        }
        return $arrData;
    }

    function getscodataopco($org, $tahun, $bulan, $hari) {
        $data = $this->PetaPencapaian_model->scodatamv($org, $tahun, $bulan, $hari);
        $maxharian = $this->PetaPencapaian_model->maxharianNew($org, $tahun, $bulan, $hari);
//        if ($org == '7000') {
//            $maxharian = $this->PetaPencapaian_model->maxhariansg($tahun, $bulan);
//        } else if ($org == '3000') {
//            $maxharian = $this->PetaPencapaian_model->maxhariansp($tahun, $bulan);
//        } else if ($org == '4000') {
//            $maxharian = $this->PetaPencapaian_model->maxharianst($tahun, $bulan);
//        }

        foreach ($data as $key => $value) {
            $data[$key]['HARIAN_MAX'] = 0;
            foreach ($maxharian as $k => $v) {
                if ($value['PROV'] == $v['PROV']) {
                    $data[$key]['HARIAN_MAX'] = $v['HARIAN_MAX'];
                }
            }
        }

        return $data;
    }

    function getSummary($tahun, $bulan) {
        date_default_timezone_set("Asia/Jakarta");
//        $tahun = date("Y");
//        $bulan = date("m");
        $date = $tahun . '' . $bulan;
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad( --$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $data = array();
        /* INISIALISASI VARIABLE */

        $sg = $this->PetaPencapaian_model->scodatamvSum('7000', $tahun, $bulan, $hari);
        $sg2 = $this->PetaPencapaian_model->scodatamvSum('5000', $tahun, $bulan, $hari);
        //$st = $this->PetaPencapaian_model->scodatamvSumTonasa('4000', $tahun, $bulan, $hari);
        $st = $this->PetaPencapaian_model->scodatamvSum('4000', $tahun, $bulan, $hari);
        $sp = $this->PetaPencapaian_model->scodatamvSum('3000', $tahun, $bulan, $hari);


        $realSG = floatval($sg['REAL'] + $sg2['REAL']);
        $rkapSG = floatval($sg['TARGET'] + $sg2['TARGET']);
        $targetHSG = floatval($sg['TARGET_REALH'] + $sg2['TARGET_REALH']);


        $realST = floatval($st['REAL']);
        $rkapST = floatval($st['TARGET']);
        $targetHST = floatval($st['TARGET_REALH']);

        $realSP = floatval($sp['REAL']);
        $rkapSP = floatval($sp['TARGET']);
        $targetHSP = floatval($sp['TARGET_REALH']);

        $realSMIG = $realSG + $realSP + $realST;
        $rkapSMIG = $rkapSG + $rkapSP + $rkapST;
        $targetHSMIG = $targetHSG + $targetHSP + $targetHST;
        $persenRealSG = round($this->getPersen($realSG, $targetHSG));
        $persenRealSP = round($this->getPersen($realSP, $targetHSP));
        $persenRealST = round($this->getPersen($realST, $targetHST));
        $persenRealSMIG = round($this->getPersen($realSMIG, $targetHSMIG));
        $persenRKAPSG = round($this->getPersen($realSG, $rkapSG));
        $persenRKAPSP = round($this->getPersen($realSP, $rkapSP));
        $persenRKAPST = round($this->getPersen($realST, $rkapST));
        $persenRKAPSMIG = round($this->getPersen($realSMIG, $rkapSMIG));
        $arrData = array();
        $arrData['realSG'] = round($realSG);
        $arrData['realSP'] = round($realSP);
        $arrData['realST'] = round($realST);
        $arrData['realSMIG'] = round($realSMIG);
        $arrData['rkapSG'] = round($rkapSG);
        $arrData['rkapSP'] = round($rkapSP);
        $arrData['rkapST'] = round($rkapST);
        $arrData['rkapSMIG'] = round($rkapSMIG);
        $arrData['persenRealSG'] = $persenRealSG;
        $arrData['persenRealSP'] = $persenRealSP;
        $arrData['persenRealST'] = $persenRealST;
        $arrData['persenRealSMIG'] = $persenRealSMIG;
        $arrData['persenRKAPSG'] = $persenRKAPSG;
        $arrData['persenRKAPSP'] = $persenRKAPSP;
        $arrData['persenRKAPST'] = $persenRKAPST;
        $arrData['persenRKAPSMIG'] = $persenRKAPSMIG;
//        echo '<pre>';
//        print_r($arrData);
//        echo '</pre>';
        echo json_encode($arrData);
    }

    function getPersen($a, $b) {
        if ($b == 0 || $b == '') {
            return 0;
        } else {
            return $a / $b * 100;
        }
    }

    function coba() {
        $tahun = '2016';
        $bulan = '12';
        $hari = '27';
        $org = '3000';
        $data = $this->PetaPencapaian_model->scodatamvsum($org, $tahun, $bulan, $hari);
        //$data = $this->PetaPencapaian_model->scodatasp2($tahun, $bulan, $hari);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    function getChart($org, $prov, $tahun, $bulan) {

        if ($org == 1) {

            //inisialisasi
            $result['sg']['target'] = array();
            $result['sg']['real'] = array();
            $result['sg']['target_ak'] = array();
            $result['sg']['real_ak'] = array();
            $target_ak_sg = 0;
            $real_ak_sg = 0;
            $result['sp']['target'] = array();
            $result['sp']['real'] = array();
            $result['sp']['target_ak'] = array();
            $result['sp']['real_ak'] = array();
            $target_ak_sp = 0;
            $real_ak_sp = 0;
            $result['st']['target'] = array();
            $result['st']['real'] = array();
            $result['st']['target_ak'] = array();
            $result['st']['real_ak'] = array();
            $target_ak_st = 0;
            $real_ak_st = 0;

            $dataSG = $this->PetaPencapaian_model->getChart('7000', $prov, $tahun, $bulan);
            foreach ($dataSG as $key => $value) {
                $target_ak_sg += $value['TARGET'];
                $real_ak_sg += $value['REAL'];
                array_push($result['sg']['target'], $value['TARGET']);
                array_push($result['sg']['real'], $value['REAL']);
                if ($value['TANGGAL'] <= date("d")) {
                    array_push($result['sg']['real_ak'], $real_ak_sg);
                }
                array_push($result['sg']['target_ak'], $target_ak_sg);
            }
            //echo $this->db->last_query();
            $dataST = $this->PetaPencapaian_model->getChart('4000', $prov, $tahun, $bulan);
            foreach ($dataST as $key => $value) {
                $target_ak_st += $value['TARGET'];
                $real_ak_st += $value['REAL'];
                array_push($result['st']['target'], $value['TARGET']);
                array_push($result['st']['real'], $value['REAL']);
                if ($value['TANGGAL'] <= date("d")) {
                    array_push($result['st']['real_ak'], $real_ak_st);
                }
                array_push($result['st']['target_ak'], $target_ak_st);
            }
            //echo $this->db->last_query();
            $dataSP = $this->PetaPencapaian_model->getChart('3000', $prov, $tahun, $bulan);
            foreach ($dataSP as $key => $value) {
                $target_ak_sp += $value['TARGET'];
                $real_ak_sp += $value['REAL'];
                array_push($result['sp']['target'], $value['TARGET']);
                array_push($result['sp']['real'], $value['REAL']);
                if ($value['TANGGAL'] <= date("d")) {
                    array_push($result['sp']['real_ak'], $real_ak_sp);
                }
                array_push($result['sp']['target_ak'], $target_ak_sp);
            }
            //echo $this->db->last_query();

            $data = $dataSG;
            foreach ($dataST as $key => $value) {
                foreach ($value as $key2 => $value2) {

                    if (isset($data[$key][$key2]) && $key2 != 'TANGGAL' && $key2 != 'NM_PROV') {
                        $data[$key][$key2] += $value2;
                    } else {
                        $data[$key][$key2] = $value2;
                    }
                }
            }

            foreach ($dataSP as $key => $value) {
                foreach ($value as $key2 => $value2) {

                    if (isset($data[$key][$key2]) && $key2 != 'TANGGAL' && $key2 != 'NM_PROV') {
                        $data[$key][$key2] += $value2;
                    } else {
                        $data[$key][$key2] = $value2;
                    }
                }
            }
        } else {
            $result['real_bag'] = array();
            $result['real_bulk'] = array();
            $data = $this->PetaPencapaian_model->getChart($org, $prov, $tahun, $bulan);
            foreach ($data as $value) {
                array_push($result['real_bag'], $value['BAG']);
                array_push($result['real_bulk'], $value['BULK']);
            }
        }


        $result['tanggal'] = array();
        $result['target'] = array();
        $result['real'] = array();
        $result['target_ak'] = array();
        $result['real_ak'] = array();
        $target_ak = 0;
        $real_ak = 0;
        foreach ($data as $key => $value) {
            $target_ak += $value['TARGET'];
            $real_ak += $value['REAL'];
            array_push($result['tanggal'], $value['TANGGAL']);
            array_push($result['target'], round($value['TARGET']), 2);
            array_push($result['real'], $value['REAL']);
            if ($value['TANGGAL'] <= date("d")) {
                array_push($result['real_ak'], $real_ak);
            }
            array_push($result['target_ak'], $target_ak);
            $result['nm_prov'] = $value['NM_PROV'];
        }

        echo json_encode($result);
    }

}
