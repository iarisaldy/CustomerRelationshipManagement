<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class MarketInfo extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('DailyMs_model');
        $this->load->library('upload');
        $this->load->model('MarketShareInfo_model');
        $this->load->helper('form');
        error_reporting(0);
    }

    function index() {
        $data = array(
            'title' => 'Market & Competition Info',
            'countNews' => $this->MarketShareInfo_model->countNewsToday()
        );

        $this->template->display('MarketShareInfo_view', $data);
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
                "caption" => "Market & Competition Info",
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
            $pencapaian = round($persen);
            $pencapaianrkap = round($tampilpersen);
            if ($row['UPD_COUNT'] < 7 && $row['UPD_COUNT'] >= 0 && $row['UPD_COUNT'] != NULL) {
                $color = '#49ff56';
            } else if ($row['UPD_COUNT'] >= 7 && $row['UPD_COUNT'] <= 14) {
                $color = '#fef536';
            } else {
                $color = '#ff4545';
            }
            if ($target < round($row['REAL'])) {
                $colorreal = 'green';
            } else {
                $colorreal = 'red';
            }
            $tooltip = "<div style='color:black;width:350px;'>"
                    . "<div style='background-color:$color';><b>" . $row['NM_PROV'] . "</b></div>"
                    . "<table border=0 style='margin-top:4px;width:100%' class=''>"
                    . "<tr style='border-bottom: 2px solid;>"
                    . "  <tr style='border-bottom: 2px solid;'>"
                    . ($row['UPD_DATE'] == NULL ? "<td colspan='2'>No Update Available</td>" : "                <td>Last Update :</td>
                                    <td><span class='pull-right'>" . $row['UPD_DATE'] . " </span></td>")
                    . " </tr>
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
                                    <td>Max Real / day :</td>
                                    <td><span class='pull-right' style='color:$colorreal'>$harian_max Ton</span></td>
                                </tr>
                                <tr>
                                    <td>Plan Target / day :</td>
                                    <td><span class='pull-right' style='color:$colorreal'>" . $target_harian . " Ton</span></td>
                                </tr> "
                    . "<tr style='padding:8px;'>"
                    . "<td></td>"
                    . "<td style='font-size:10px;font-style:italic;text-align:right'>Klik untuk detail</td>"
                    . "</tr>"
                    . "</table>"
                    . "</div>";
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

    //untuk memperoleh nilai persen
    function detailProv($idprov, $org, $bulan, $tahun) {

        error_reporting(E_ALL);
        if ($idprov == '0001') {
            $org = 1;
        }
        $data = $this->MarketShareInfo_model->getDetailprov($idprov, $org, $bulan, $tahun);
        $content = '';
        foreach ($data['info'] as $value) {
            //$comp = ($value->COMPANY == '7000' ? ' (SG)' : ($value->COMPANY == '3000' ? ' (SP)' : ($value->COMPANY == '4000' ? ' (ST)' : '')));

            $content .= " <tr><td><img src='{$this->setPict($value->COMPANY)}' width ='50'></td>
                     <td style='font-size: 14px !important;min-width:125px !important'><strong>{$value->NAMA_INFO} </strong></td >
                        <td colspan='4' style='font-size: 14px !important;' class='item-intro'>{$value->INFORMASI}</td></tr>";
        }
        $content .= '<tr>';
        if (!empty($data['foto_lap'])) {

            $content .= "<td></td><td style='font-size: 14px !important; vertical-align: top !important' ><strong>Foto Lapangan</strong></td><td colspan='2'>";
            $content .= "<a href='javascript:void(0)' onClick=\"detailFoto('" . $idprov . "','LAPANGAN')\"><img src='" . base_url('assets/marketshare_gambar/' . $data['foto_lap']->MSFOTO) . "' width='400' height='300'></a><br><span class='text-muted'><em>(klik gambar untuk melihat gambar lainya)</em></span>";
            $content .= "</td>";
        }
        if (!empty($data['foto_gf'])) {

            $content .= "<td style='font-size: 14px !important;min-width:125px !important; vertical-align: top !important' ><strong>Gambar Grafik<strong></td><td colspan='2'>";
            $content .= "<a href='javascript:void(0)' onClick=\"detailFoto('" . $idprov . "','GRAFIK')\"><img src='" . base_url('assets/marketshare_gambar/' . $data['foto_gf']->MSFOTO) . "' width='400' height='300'></a><br><span class='text-muted'><em>(klik gambar untuk melihat gambar lainya)</em></span>";
            $content .= "</td>";
        }
        $content .= '</tr>';
        echo json_encode(array('data' => $content, 'prov' => $data['prov']->NM_PROV));
    }

    function getFoto($prov, $tipe) {
        $data = $this->MarketShareInfo_model->getFoto($prov, $tipe);
        $content = '';

        foreach ($data as $value) {
            $comp = ($value->COMPANY == '7000' ? ' SG : ' : ($value->COMPANY == '3000' ? ' SP : ' : ($value->COMPANY == '4000' ? ' ST : ' : ($value->COMPANY == '6000' ? ' TLCC : ' : ''))));
            $content .= '<div class="col-xs-3 lightBoxGallery"> 
                <a data-gallery="" title="' . $comp . ' ' . $value->CAPTION . '" href="' . base_url('assets/marketshare_gambar/' . $value->MSFOTO) . '" class="" >
                        <img src="' . base_url('assets/marketshare_gambar/' . $value->MSFOTO) . '" class="img-responsive img-gallery" alt="First image">
                     </a>
                </div>';
        }
        echo $content;
    }

    function masterInformasi() {
        $data = array('title' => 'Market Info');
        $data['dropdown'] = $this->MarketShareInfo_model->getProv();
        $this->template->display('master-informasi', $data);
    }

    function listMarketInfo() {
        $list = $this->MarketShareInfo_model->listMarketInfo();
        $data = array();
        $no = 1;
        $jml = 0;
        foreach ($list as $info) {
            $jml = $info->RESULT_COUNT;
            $nm_prov = ($info->KD_PROV == '0001' ? 'International Market' : $info->NM_PROV);
            $row = array(
                $no++,
                $nm_prov,
                '<center style="cursor: pointer;"><a href="javascript:void(0);" onclick="show_info(\'' . $nm_prov . '\',\'' . $info->KD_PROV . '\')"><i class="fa fa-info-circle" style="font-size: 25px;"></i></a></center>',
                '<center style="cursor: pointer;"><a href="javascript:void(0);" onclick="show_fotoLap(\'' . $nm_prov . '\',\'' . $info->KD_PROV . '\')"><i class="fa fa-image" style="font-size: 25px;"></i></a></center>',
                '<center style="cursor: pointer;"><a href="javascript:void(0);" onclick="show_gambarGrafik(\'' . $nm_prov . '\',\'' . $info->KD_PROV . '\')"><i class="fa fa-image" style="font-size: 25px;"></i></a></center>'
            );
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->MarketShareInfo_model->getCountAll('SCM_MI_M_MSINFO'),
            "recordsFiltered" => $jml,
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function ListInformasi($prov) {

        $list = $this->MarketShareInfo_model->listInformasi($prov);

        $data = array();
        $no = 1;
        $jml = 0;
        foreach ($list as $info) {
            $jml = $info->RESULT_COUNT;
            if (strlen($info->INFORMASI) > 150) {
                $infor = substr($info->INFORMASI, 0, 150) . '...';
            } else {
                $infor = $info->INFORMASI;
            }
            $row = array(
                $no++,
                $info->COMPANY,
                $info->URUTAN_INFO,
                $info->TGLINFO,
                $info->NAMA_INFO,
                $infor,
                $info->CREATED_BY,
                $info->CREATED_ON,
                $info->UPDATE_BY,
                $info->UPDATE_ON,
                '<center>'
                . '<a class="btn btn-xs btn-warning" style="margin-right: 5px;" href="javascript:void(0)" title="Edit" onclick="edit_information(' . "'" . $info->IDMSINFO . "'" . ')"><i class="fa fa-edit"></i> Edit</a>'
                . '<a class="btn btn-xs btn-danger" style="margin-right: 5px;" href="javascript:void(0)" title="Hapus" onclick="delete_information(' . "'" . $info->IDMSINFO . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
                . '</center>'
            );
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->MarketShareInfo_model->getCountAll('SCM_MI_M_MSINFO'),
            "recordsFiltered" => $jml,
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function check_urutan($val, $org, $tgl, $prov, $id = false) {
        echo $this->MarketShareInfo_model->check_urutan($val, $org, $tgl, $prov, $id);
    }

    public function check_urutan_foto($val, $org, $tgl, $prov, $tipe, $id = false) {
        echo $this->MarketShareInfo_model->check_urutan_foto($val, $org, $tgl, $prov, $tipe, $id);
    }

    public function AddInformasi() {
        $stat = $this->MarketShareInfo_model->addInformasi();
        echo json_encode(array('status' => TRUE));
    }

    public function DetailInformasi($id) {
        $row = $this->MarketShareInfo_model->detailInformasi($id);
        echo json_encode($row);
    }

    public function UpdateInformasi() {
        $stat = $this->MarketShareInfo_model->updateInformasi();
        echo json_encode(array('status' => TRUE));
    }

    public function DeleteInformasi($id) {
        $stat = $this->MarketShareInfo_model->deleteInformasi($id);
        echo json_encode(array('status' => TRUE));
    }

    function masterGambar() {
        $data = array('title' => 'Market Share Info - Foto');
        $data['dropdown'] = $this->MarketShareInfo_model->getProv();
        $this->template->display('master-gambar', $data);
    }

    public function ListGambar($prov, $tipe) {

        $list = $this->MarketShareInfo_model->listGambar($prov, $tipe);

        $data = array();
        $no = 1;
        $jml = 0;
        foreach ($list as $info) {
            $jml = $info->RESULT_COUNT;
            $row = array(
                $no++,
                $info->COMPANY,
                '<div class="lightBoxGallery"><a data-gallery="" href="' . base_url('assets/marketshare_gambar/' . $info->MSFOTO) . '" ><img src="' . base_url('assets/marketshare_gambar/' . $info->MSFOTO) . '" id="NtPctB" class="img-rounded" alt="Picture Before" width="50"></a></div>',
                $info->CAPTION,
                $info->TGLFOTO,
                $info->CREATED_BY,
                $info->CREATED_ON,
                $info->UPDATE_BY,
                $info->UPDATE_ON,
                '<center>'
                . '<a class="btn btn-xs btn-warning" style="margin-right: 5px;" href="javascript:void(0)" title="Edit" onclick="edit_Gambar(' . "'" . $info->IDMSFOTO . "'" . ')"><i class="fa fa-edit"></i> Edit</a>'
                . '<a class="btn btn-xs btn-danger" style="margin-right: 5px;" href="javascript:void(0)" title="Hapus" onclick="delete_Gambar(' . "'" . $info->IDMSFOTO . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>'
                . '</center>'
            );
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->MarketShareInfo_model->getCountAll('SCM_MI_M_MSINFO'),
            "recordsFiltered" => $jml,
            "data" => $data,
        );
        echo json_encode($output);
    }

    function AddGambar() {
        error_reporting(E_ALL);

        $config = array(
            'upload_path' => realpath(APPPATH . '../assets/marketshare_gambar'),
            'allowed_types' => "tif|gif|jpg|png|jpeg",
            'file_name' => time() . $_FILES['FOTO']['name'],
            'max_size' => '3072'
        );

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('FOTO')) {
            $this->MarketShareInfo_model->addGambar($this->upload->file_name);
            echo json_encode(array("status" => TRUE));
        } else {

            echo $this->upload->display_errors();
        }
    }

    function detailGambar($id) {
        $row = $this->MarketShareInfo_model->detailGambar($id);
        echo json_encode($row);
    }

    function updateGambar() {
        $data = $_POST;
        if ($_FILES['FOTO']['name'] != "") {
            $config = array(
                'upload_path' => realpath(APPPATH . '../assets/marketshare_gambar'),
                'allowed_types' => "tif|gif|jpg|png|jpeg",
                'file_name' => time() . $_FILES['FOTO']['name'],
                'max_size' => '3072'
            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('FOTO');
            $data['MSFOTO'] = $this->upload->file_name;
            echo $this->upload->display_errors();
        }
        unset($data['ID']);
        unset($data['FOTO']);

        $this->MarketShareInfo_model->updateGambar($data, $_POST['ID']);
        echo json_encode(array("status" => TRUE));
    }

    function DeleteGambar($id) {
        $stat = $this->MarketShareInfo_model->deleteGambar($id);
        echo json_encode(array('status' => TRUE));
    }

    function listLog($prov, $tipe) {
        $list = array();
        $data = $this->MarketShareInfo_model->ListLog($prov, $tipe);
        $no = 1;
        $jml = 0;
        foreach ($data as $value) {
            $jml = $value->RESULT_COUNT;
            $row = array(
                $no++,
                $value->ACTION,
                $value->LOGTIME,
                $value->AUTHOR
            );
            $list[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->MarketShareInfo_model->getCountAll('SCM_MI_MS_LOG'),
            "recordsFiltered" => $jml,
            "data" => $list,
        );
        echo json_encode($output);
    }

    function GetNews() {
        $data = $this->MarketShareInfo_model->getNews();
        echo json_encode($data);
    }

    function scodatasmig($tahun, $bulan) {
        date_default_timezone_set("Asia/Jakarta");
//        $tahun = date("Y");
//        $bulan = date("m");
        $date = $tahun . '' . $bulan;
        if ($date == date("Ym")) {
            $hari = date("d");
            $hari = intval($hari) > 1 ? str_pad(--$hari, 2, '0', STR_PAD_LEFT) : $hari;
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }

        $bulanBaru = date('t', strtotime($tahun . "-" . $bulan));

        /* INISIALISASI VARIABLE */

        $data = $this->MarketShareInfo_model->getProv2();

        $sg = $this->MarketShareInfo_model->scodatamv('7000', $tahun, $bulan, $hari);
        $st = $this->MarketShareInfo_model->scodatamv('4000', $tahun, $bulan, $hari);
        $sp = $this->MarketShareInfo_model->scodatamv('3000', $tahun, $bulan, $hari);

        $sgmi = $this->MarketShareInfo_model->getData('7000', $tahun, $bulan);
        $stmi = $this->MarketShareInfo_model->getData('4000', $tahun, $bulan);
        $spmi = $this->MarketShareInfo_model->getData('3000', $tahun, $bulan);


        $prov = array();
        foreach ($data as $value) {
            $prov[$value['KD_PROV']]['REAL'] = 0;
            $prov[$value['KD_PROV']]['TARGET_REALH'] = 0;
            $prov[$value['KD_PROV']]['TARGET'] = 0;
            $prov[$value['KD_PROV']]['REAL_TAHUN_INI'] = 0;
            $prov[$value['KD_PROV']]['REAL_TAHUN_KEMARIN'] = 0;
            $prov[$value['KD_PROV']]['REAL_BAG'] = 0;
            $prov[$value['KD_PROV']]['REAL_BULK'] = 0;
            $prov[$value['KD_PROV']]['UPD_DATE'] = NULL;
            $prov[$value['KD_PROV']]['UPD_COUNT'] = NULL;
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
            foreach ($sgmi as $val) {
                if ($val['PROV'] == $value['PROV']) {
                    $prov[$value['PROV']]['UPD_DATE'] = ($prov[$value['PROV']]['UPD_DATE'] > $val['UPD_DATE'] ? $prov[$value['PROV']]['UPD_DATE'] : $val['UPD_DATE'] );
                    $prov[$value['PROV']]['UPD_COUNT'] = ($val['UPD_COUNT'] == NULL ? $prov[$value['PROV']]['UPD_COUNT'] : ($val['UPD_COUNT'] < $prov[$value['PROV']]['UPD_COUNT'] ? $val['UPD_COUNT'] : ($prov[$value['PROV']]['UPD_COUNT'] == NULL ? $val['UPD_COUNT'] : $prov[$value['PROV']]['UPD_COUNT'] )));
                }
            }
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
            foreach ($stmi as $val) {
                if ($val['PROV'] == $value['PROV']) {
                    $prov[$value['PROV']]['UPD_DATE'] = ($prov[$value['PROV']]['UPD_DATE'] > $val['UPD_DATE'] ? $prov[$value['PROV']]['UPD_DATE'] : $val['UPD_DATE'] );
                    $prov[$value['PROV']]['UPD_COUNT'] = ($val['UPD_COUNT'] == NULL ? $prov[$value['PROV']]['UPD_COUNT'] : ($val['UPD_COUNT'] < $prov[$value['PROV']]['UPD_COUNT'] ? $val['UPD_COUNT'] : ($prov[$value['PROV']]['UPD_COUNT'] == NULL ? $val['UPD_COUNT'] : $prov[$value['PROV']]['UPD_COUNT'] )));
                }
            }
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

            foreach ($spmi as $val) {
                if ($val['PROV'] == $value['PROV']) {
                    $prov[$value['PROV']]['UPD_DATE'] = ($prov[$value['PROV']]['UPD_DATE'] > $val['UPD_DATE'] ? $prov[$value['PROV']]['UPD_DATE'] : $val['UPD_DATE'] );
                    $prov[$value['PROV']]['UPD_COUNT'] = ($val['UPD_COUNT'] == NULL ? $prov[$value['PROV']]['UPD_COUNT'] : ($val['UPD_COUNT'] < $prov[$value['PROV']]['UPD_COUNT'] ? $val['UPD_COUNT'] : ($prov[$value['PROV']]['UPD_COUNT'] == NULL ? $val['UPD_COUNT'] : $prov[$value['PROV']]['UPD_COUNT'] )));
                }
            }
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
//            $target = number_format($row['TARGET'], 0, '', '.');
            $pencapaian = round($persen);

            if ($row['UPD_COUNT'] < 7 && $row['UPD_COUNT'] >= 0 && $row['UPD_COUNT'] != NULL) {
                $color = '#49ff56';
            } else if ($row['UPD_COUNT'] >= 7 && $row['UPD_COUNT'] <= 14) {
                $color = '#fef536';
            } else {
                $color = '#ff4545';
            }
//            $tooltip = "<div style='color:black;width:200px;'>"
//                    . "<div style='background-color:$color';><b>" . $row['NM_PROV'] . "</b></div>"
//                    . "<table border=0 style='margin-top:4px;width:100%' class=''>"
//                    . "<tr>"
//                    . ($row['UPD_DATE'] != NULL ? "<td style='text-align:left'>Last Update :</td><td style='text-align:right'>" . $row['UPD_DATE'] . "</td></tr>" : "<td style='text-align:left'>No Update Available</td></tr>")
//                    . "<div><span class='pull-right'>" . $pencapaian . " %</span></div>"
//                    . "<div>Pencapaian :<span class='pull-right'>$totalrealbag Ton </span></div>"
//                    . "<div>Bag :<span class='pull-right'>$totalrealbulk Ton </span></div>"
//                    . "<div>Bulk :<span class='pull-right'><b>$totalreal Ton</span></b></div>"
//                    . "<div><b>Total :</b></div>"
//                    . "<tr style='padding:8px;'>"
//                    . "<td></td>"
//                    . "<td style='font-size:10px;font-style:italic;text-align:right'>Klik untuk detail</td>"
//                    . "</tr>"
//                    . "</table>"
//                    . "</div>";
            $tooltip = "<div style='color:black; width:200px;'>"
                    . "<div style='background-color:$color';><b>" . $row['NM_PROV'] . "</b></div>"
                    . "<div>" . ($row['UPD_DATE'] != NULL ? "Last update :" : "No Update Available") . "<span class='pull-right'>" . ($row['UPD_DATE'] != NULL ? $row['UPD_DATE'] : "") . " </span></div>"
                    . "<div><span class='pull-right'></span></div>"
                    . "<div>Pencapaian :<span class='pull-right'>" . $pencapaian . " %</span></div>"
                    . "<div>Bag :<span class='pull-right'>$totalrealbag Ton </span></div>"
                    . "<div>Bulk :<span class='pull-right'> $totalrealbulk Ton</span></div>"
                    . "<div><b>Total :</b><span class='pull-right'><b>$totalreal Ton</b></span></div>"
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
        $data = $this->MarketShareInfo_model->scodatamv($org, $tahun, $bulan, $hari);
        $maxharian = $this->MarketShareInfo_model->maxharianNew($org, $tahun, $bulan, $hari);
        $dataMI = $this->MarketShareInfo_model->getData($org, $tahun, $bulan);
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
            foreach ($dataMI as $k => $v) {
                if ($value['PROV'] == $v['PROV']) {
                    $data[$key]['UPD_DATE'] = $v['UPD_DATE'];
                    $data[$key]['UPD_COUNT'] = $v['UPD_COUNT'];
                }
            }
        }


        return $data;
    }

    function setPict($opco) {
        switch ($opco) {
            case '3000':
                $pict = base_url('assets/img/menu/semen_padang.png');
                break;
            case '4000':
                $pict = base_url('assets/img/menu/semen_tonasa.png');
                break;
            case '7000':
                $pict = base_url('assets/img/menu/semen_gresik.png');
                break;
            case '6000':
                $pict = base_url('assets/img/menu/thang_long.jpg');
                break;
            default:
                $pict = '';
                break;
        }
        return $pict;
    }

}
