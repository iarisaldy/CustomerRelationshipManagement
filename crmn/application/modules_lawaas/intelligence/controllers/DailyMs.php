<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class DailyMs extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('DailyMs_model');
//        error_reporting(0);
    }

    function index() {
        $data = array(
            'title' => 'Daily Market Share',
            'prov' => $this->DailyMs_model->dataProv(),
            'kota' => $this->DailyMs_model->dataKota(),
        );
        $this->template->display('DailyMs_view', $data);
    }

    //untuk memperoleh nilai persen
    function getPersen($a, $b) {
        /*
         * $a = penyebut
         * $b = pembilang
         */
        if ($b == 0 || $b == '') {
            return 0;
        } else {
            return $a / $b * 100;
        }
    }

    /*
     * pengambilan data marketshare untuk pembuatan peta
     */

    function getData($org, $tahun, $bulan) {
        $arrData = array(
            "chart" => array(
                "caption" => "Realisasi Market Share Harian Terhadap RKAP",
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
                    //baris berikut digunakan untuk menentukan pewarnaan peta
                    array(
                        "minvalue" => "0",
                        "maxvalue" => "98",
                        "code" => "#ff4545",
                        "displayValue" => "MS dibawah target > 2%"
                    ),
                    array(
                        "minvalue" => "98",
                        "maxvalue" => "100",
                        "code" => "#fef536",
                        "displayValue" => "MS dibawah target <= 2%"
                    ),
                    array(
                        "minvalue" => "100",
                        "maxvalue" => "1000",
                        "code" => "#49ff56",
                        "displayValue" => "MS >= target"
                    )
                )
            ),
            /*
             * baris berikut digunakan untuk mengganti ID default bawaan dari library 
             * dengan ID provinsi standar SMI
             */
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
        $hari = date('d');
        if ($org == 7000) {
            $data = $this->DailyMs_model->datas($org, $tahun, $bulan, $hari);
        } else if ($org == 4000) {
            $data = $this->DailyMs_model->datas($org, $tahun, $bulan, $hari);
        } else if ($org == 3000) {
            $data = $this->DailyMs_model->datas($org, $tahun, $bulan, $hari);
        } else if ($org == 1) {
//            $data = $this->DailyMs_model->datasmig($tahun, $bulan, $hari);
            // total buat peta SMIG
            $propinsi = $this->DailyMs_model->getProv();
            $sg = $this->DailyMs_model->datas('7000', $tahun, $bulan, $hari);
            $st = $this->DailyMs_model->datas('4000', $tahun, $bulan, $hari);
            $sp = $this->DailyMs_model->datas('3000', $tahun, $bulan, $hari);

            $prov = array();
            foreach ($propinsi as $value) {
                $prov[$value['KD_PROV']]['RKAP_MS'] = 0;
                $prov[$value['KD_PROV']]['MARKETSHARE'] = 0;
                $prov[$value['KD_PROV']]['REAL'] = 0;
                $prov[$value['KD_PROV']]['DEMAND_HARIAN'] = 0;
            }
            foreach ($sg as $value) {
                $prov[$value['PROV']]['RKAP_MS'] += $value['RKAP_MS'];
                $prov[$value['PROV']]['MARKETSHARE'] += $value['MARKETSHARE'];
                $prov[$value['PROV']]['REAL'] += $value['REAL'];
                $prov[$value['PROV']]['DEMAND_HARIAN'] += $value['DEMAND_HARIAN'];
                $prov[$value['PROV']]['NM_PROV'] = $value['NM_PROV'];
            }
            foreach ($st as $value) {
                $prov[$value['PROV']]['RKAP_MS'] += $value['RKAP_MS'];
                $prov[$value['PROV']]['MARKETSHARE'] += $value['MARKETSHARE'];
                $prov[$value['PROV']]['REAL'] += $value['REAL'];
                $prov[$value['PROV']]['DEMAND_HARIAN'] += $value['DEMAND_HARIAN'];
                $prov[$value['PROV']]['NM_PROV'] = $value['NM_PROV'];
            }
            foreach ($sp as $value) {
                $prov[$value['PROV']]['RKAP_MS'] += $value['RKAP_MS'];
                $prov[$value['PROV']]['MARKETSHARE'] += $value['MARKETSHARE'];
                $prov[$value['PROV']]['REAL'] += $value['REAL'];
                $prov[$value['PROV']]['DEMAND_HARIAN'] += $value['DEMAND_HARIAN'];
                $prov[$value['PROV']]['NM_PROV'] = $value['NM_PROV'];
            }
        }
        // kondisi pengambilan data peta SMIG atau Opco (SG, SP, ST)
        if ($org == 1) {// peta data SMIG
            foreach ($prov as $key => $row) {
                $targetrkap = round(str_replace(',', '.', $row["RKAP_MS"]));
                $realrkap = round($row["MARKETSHARE"]);
                $perbandingan = $this->getPersen($row["MARKETSHARE"], $row['RKAP_MS']);
                $realisasi = str_replace(',', '.', number_format(round(str_replace(',', '.', $row["REAL"]))));
                $demand = str_replace(',', '.', number_format(round(str_replace(',', '.', $row['DEMAND_HARIAN']))));
                if ($perbandingan >= 0 && $perbandingan <= 98) {
                    $color = '#ff4545';
                } else if ($perbandingan >= 98 && $perbandingan < 100) {
                    $color = '#fef536';
                } else if ($perbandingan >= 100) {
                    $color = '#49ff56';
                }
                $tooltip = "<div style='color:black;width:150px;'>"
                        . "<div style='background-color:$color';><b>" . $row['NM_PROV'] . "</b></div>"
                        . "<table border=0 style='margin-top:4px;width:100%' class=''>"
                        . "<tr>"
                        . "<td style='text-align:left'>MS :</td>"
                        . "<td style='text-align:right'>" . $realrkap . "%</td>"
                        . "</tr>"
                        . "<tr style='padding:8px;'>"
                        . "<td style='text-align:left'>RKAP :</td>"
                        . "<td style='text-align:right'>" . $targetrkap . "%</td>"
                        . "</tr>"
                        . "<tr style='padding:8px;'>"
                        . "<td style='text-align:left'>Realisasi :</td>"
                        . "<td style='text-align:right'>" . $realisasi . "</td>"
                        . "</tr>"
                        . "<tr style='padding:8px;'>"
                        . "<td style='text-align:left'>Demand :</td>"
                        . "<td style='text-align:right'>" . $demand . "</td>"
                        . "</tr>"
                        . "<tr style='padding:8px;'>"
                        . "<td></td>"
                        . "<td style='font-size:10px;font-style:italic;text-align:right'>Klik untuk detail</td>"
                        . "</tr>"
                        . "</table>"
                        . "</div>";
                array_push($arrData["data"], array(
                    "id" => $key . "",
                    "value" => $perbandingan . '',
                    "toolText" => $tooltip
                ));
            }
        } else {// peta data Opco (SG, SP, ST)
            foreach ($data as $row) {
                //$persen = ($row["REAL"]/$row["TARGET_REALH"])*100;
                //$ms = round(str_replace(',', '.', $row['RKAP_MS']));
                $targetrkap = round(str_replace(',', '.', $row["RKAP_MS"]));
                $realrkap = round($row["MARKETSHARE"]);
                $perbandingan = $this->getPersen($row["MARKETSHARE"], $row['RKAP_MS']);
                $realisasi = str_replace(',', '.', number_format(round(str_replace(',', '.', $row["REAL"]))));
                $demand = str_replace(',', '.', number_format(round(str_replace(',', '.', $row['DEMAND_HARIAN']))));
                if ($perbandingan >= 0 && $perbandingan <= 98) {
                    $color = '#ff4545';
                } else if ($perbandingan >= 98 && $perbandingan < 100) {
                    $color = '#fef536';
                } else if ($perbandingan >= 100) {
                    $color = '#49ff56';
                }
                $tooltip = "<div style='color:black;width:150px;'>"
                        . "<div style='background-color:$color';><b>" . $row['NM_PROV'] . "</b></div>"
                        . "<table border=0 style='margin-top:4px;width:100%' class=''>"
                        . "<tr>"
                        . "<td style='text-align:left'>MS :</td>"
                        . "<td style='text-align:right'>" . $realrkap . "%</td>"
                        . "</tr>"
                        . "<tr style='padding:8px;'>"
                        . "<td style='text-align:left'>RKAP :</td>"
                        . "<td style='text-align:right'>" . $targetrkap . "%</td>"
                        . "</tr>"
                        . "<tr style='padding:8px;'>"
                        . "<td style='text-align:left'>Realisasi :</td>"
                        . "<td style='text-align:right'>" . $realisasi . "</td>"
                        . "</tr>"
                        . "<tr style='padding:8px;'>"
                        . "<td style='text-align:left'>Demand :</td>"
                        . "<td style='text-align:right'>" . $demand . "</td>"
                        . "</tr>"
                        . "<tr style='padding:8px;'>"
                        . "<td></td>"
                        . "<td style='font-size:10px;font-style:italic;text-align:right'>Klik untuk detail</td>"
                        . "</tr>"
                        . "</table>"
                        . "</div>";
                array_push($arrData["data"], array(
                    "id" => $row["PROV"],
                    "value" => $perbandingan . '',
                    "toolText" => $tooltip
                ));
            }
        }
        echo json_encode($arrData);
    }

    /*
     * pengambilan data MS Harian dan MS Akumulatif untuk pembuatan grafik line chart
     */

    function grafik_msH($tahun, $bulan) {
        $hari = date('t', strtotime($tahun . "-" . $bulan));
        $tanggal = array();
        for ($i = 1; $i <= $hari; $i++) {
            if (strlen($i) < 2) {
                $tgl = '0' . $i;
            } else {
                $tgl = $i . '';
            }
            array_push($tanggal, $tgl);
        }
        $data1 = $this->DailyMs_model->grafik(7000, $tahun, $bulan);
        $data2 = $this->DailyMs_model->grafik(4000, $tahun, $bulan);
        $data3 = $this->DailyMs_model->grafik(3000, $tahun, $bulan);
        $arr['TANGGAL'] = $tanggal;
        // data ms Harian SMIG, SG, SP, ST
        $datams1 = array();
        $datams2 = array();
        $datams3 = array();
        $arr['DATAMSSG'] = array();
        $arr['DATAMSSP'] = array();
        $arr['DATAMSST'] = array();
        // data ms Akumulatif SMIG, SG, SP, ST
        $kumRealsg = 0;
        $kumDemandsg = 0;
        $kumRealst = 0;
        $kumDemandst = 0;
        $kumRealsp = 0;
        $kumDemandsp = 0;
        $arr['REALKUMSG'] = array();
        $arr['DEMANDSG'] = array();
        $arr['REALKUMST'] = array();
        $arr['DEMANDST'] = array();
        $arr['REALKUMSP'] = array();
        $arr['DEMANDSP'] = array();
        $arr['AKUMSMIG'] = array();
        $arr['AKUMSG'] = array();
        $arr['AKUMST'] = array();
        $arr['AKUMSP'] = array();

        foreach ($data1 as $value1) {
            array_push($datams1, $value1['MARKETSHARE']);
            array_push($arr['DATAMSSG'], number_format($value1['MARKETSHARE'], 2));
            $kumRealsg += $value1['REAL_VOL'];
            $kumDemandsg += $value1['DEMAND'];
            array_push($arr['REALKUMSG'], $kumRealsg);
            array_push($arr['DEMANDSG'], $kumDemandsg);
            array_push($arr['AKUMSG'], number_format($this->getPersen($kumRealsg, $kumDemandsg), 2));
        } //SG
        foreach ($data2 as $value2) {
            array_push($datams2, $value2['MARKETSHARE']);
            array_push($arr['DATAMSST'], number_format($value2['MARKETSHARE'], 2));
            $kumRealst += $value2['REAL_VOL'];
            $kumDemandst += $value2['DEMAND'];
            array_push($arr['REALKUMST'], $kumRealst);
            array_push($arr['DEMANDST'], $kumDemandst);
            array_push($arr['AKUMST'], number_format($this->getPersen($kumRealst, $kumDemandst), 2));
        } // ST
        foreach ($data3 as $value3) {
            array_push($datams3, $value3['MARKETSHARE']);
            array_push($arr['DATAMSSP'], number_format($value3['MARKETSHARE'], 2));
            $kumRealsp += $value3['REAL_VOL'];
            $kumDemandsp += $value3['DEMAND'];
            array_push($arr['REALKUMSP'], $kumRealsp);
            array_push($arr['DEMANDSP'], $kumDemandsp);
            array_push($arr['AKUMSP'], number_format($this->getPersen($kumRealsp, $kumDemandsp), 2));
        } // SP
        $arr['DATAMS'] = array();
        if ($bulan == date('m')) {
            $hari = date('d');
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        // data MS harian dan MS Akumulasi SMIG
        for ($i = 0; $i < $hari; $i++) {
            $hasil = $datams1[$i] + $datams2[$i] + $datams3[$i];
            $akumsmig = $arr['AKUMSG'][$i] + $arr['AKUMST'][$i] + $arr['AKUMSP'][$i];
            array_push($arr['DATAMS'], number_format($hasil, 2));
            array_push($arr['AKUMSMIG'], number_format($akumsmig, 2));
        }
        echo json_encode($arr);
    }

    /*
     * pengambilan data Realisasi, Target, dan Marketshare untuk tabel summary market share
     */

    function summaryDMS($tahun, $bulan) {
        if ($bulan == date('m')) {
            $hari = date('d');
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        } else {
            $hari = date('t') - 1;
        }
        $arr = array();
        // realisasi SMIG dan per Opco (SG, SP, SP)
        $realsmig = $this->DailyMs_model->realisasi($tahun, $bulan, $hari);
        foreach ($realsmig as $row) {
            $arr['REAL'] = str_replace(',', '.', number_format(round($row['REAL'])));
        }
        $realsg = $this->DailyMs_model->realisasico(7000, $tahun, $bulan, $hari);
        foreach ($realsg as $row) {
            $arr['REALSG'] = str_replace(',', '.', number_format(round($row['REAL'])));
        }
        $realst = $this->DailyMs_model->realisasico(4000, $tahun, $bulan, $hari);
        foreach ($realst as $row) {
            $arr['REALST'] = str_replace(',', '.', number_format(round($row['REAL'])));
        }
        $realsp = $this->DailyMs_model->realisasico(3000, $tahun, $bulan, $hari);
        foreach ($realsp as $row) {
            $arr['REALSP'] = str_replace(',', '.', number_format(round($row['REAL'])));
        }
        // target SMIG dan per Opco (SG, SP, SP)
        $targetsmig = $this->DailyMs_model->targetsmig($tahun);
        foreach ($targetsmig as $row) {
            $arr['TARGETSMIG'] = str_replace('.', ',', $row['TARGETSMIG']);
        }
        $targetsg = $this->DailyMs_model->targetco(7000, $tahun);
        foreach ($targetsg as $row) {
            $arr['TARGETSG'] = str_replace('.', ',', $row['TARGETCO']);
        }
        $targetst = $this->DailyMs_model->targetco(4000, $tahun);
        foreach ($targetst as $row) {
            $arr['TARGETST'] = str_replace('.', ',', $row['TARGETCO']);
        }
        $targetsp = $this->DailyMs_model->targetco(3000, $tahun);
        foreach ($targetsp as $row) {
            $arr['TARGETSP'] = str_replace('.', ',', $row['TARGETCO']);
        }
        // marketshare SMIG dan per Opco (SG, SP, SP)
        $mssg = $this->DailyMs_model->msco(7000, $tahun, $bulan, $hari);
        foreach ($mssg as $row) {
            $arr['MSSG'] = str_replace('.', ',', number_format($row['MARKETSHARE'], 1));
            $sgms = $row['MARKETSHARE'];
        }
        $msst = $this->DailyMs_model->msco(4000, $tahun, $bulan, $hari);
        foreach ($msst as $row) {
            $arr['MSST'] = str_replace('.', ',', number_format($row['MARKETSHARE'], 1));
            $stms = $row['MARKETSHARE'];
        }
        $mssp = $this->DailyMs_model->msco(3000, $tahun, $bulan, $hari);
        foreach ($mssp as $row) {
            $arr['MSSP'] = str_replace('.', ',', number_format($row['MARKETSHARE'], 1));
            $spms = $row['MARKETSHARE'];
        }
        $arr['MSSMIG'] = str_replace('.', ',', number_format($sgms + $stms + $spms, 1));
        echo json_encode($arr);
    }

    /*
     * fungsi handle upload file excel
     */

    function upload() {
        $this->load->library('Excel_reader');
        $file_name = $_FILES["userfile"]["name"];
        $tmp = explode('.', $file_name);
        $extension = end($tmp);
        $data = array();
        if ($extension == 'xls' || $extension == 'xlsx') {

            $file = $_FILES['userfile']['tmp_name'];
            $this->excel_reader->read($file);
            $worksheet = $this->excel_reader->sheets[0];
//            print_r($worksheet);

            $numRow = $worksheet['numRows'];
            $numCol = $worksheet['numCols'];
            $cells = $worksheet['cells'];

            $tahun = $cells[1][2];
            $bulan = str_pad($cells[2][2], 2, '0', STR_PAD_LEFT);

            for ($i = 5; $i <= $numRow; $i++) {
                $temp = array(
                    "KD_PROV" => substr($cells[$i][2], 0, 4),
                    "PROV" => substr($cells[$i][2], 6),
                    "KD_KOTA" => substr($cells[$i][3], 0, 6),
                    "KOTA" => ucwords(strtolower(substr($cells[$i][3], 8))),
                    "KD_PERUSAHAAN" => substr($cells[$i][4], 0, 3),
                    "PERUSAHAAN" => substr($cells[$i][4], 5),
                    "TAHUN" => $tahun,
                    "BULAN" => $bulan,
                    "HARI" => str_pad($cells[$i][1], 2, '0', STR_PAD_LEFT),
                    "HARGA_JUAL" => $cells[$i][6],
                    "HARGA_TEBUS" => $cells[$i][5],
                    "TIPE" => $cells[$i][7],
                    "CREATE_BY" => $this->session->userdata('usernamescm')
                );
                array_push($data, $temp);
            }
            foreach ($data as $key => $value) {
                $cek = $this->DailyMs_model->cekData($value);
//                if ($cek > 0) {
//                    if ($this->DailyMs_model->update($value)) {
//                        $data[$key]['PESAN'] = 'Update data sukses';
//                    } else {
//                        $data[$key]['PESAN'] = 'Update data gagal';
//                    }
//                } else {
                if ($this->DailyMs_model->insert($value)) {
                    $data[$key]['PESAN'] = 'Insert data sukses';
                } else {
                    $data[$key]['PESAN'] = 'Insert data gagal';
                }
//                }
            }
            echo json_encode($this->generateTable($data));
        }
    }

    function generateTable($data) {
        $table = '';
        $no = 1;
        foreach ($data as $key => $value) {
            $table .= '<tr>';
            $table .= '<td>' . $no . '</td>';
            $table .= '<td>' . $value["PROV"] . '</td>';
            $table .= '<td>' . $value["KOTA"] . '</td>';
            $table .= '<td>' . $value["PERUSAHAAN"] . '</td>';
            $table .= '<td>' . $value["HARI"] . '-' . $value["BULAN"] . '-' . $value["TAHUN"] . '</td>';
            $table .= '<td>' . $value["HARGA_TEBUS"] . '</td>';
            $table .= '<td>' . $value["HARGA_JUAL"] . '</td>';
            $table .= '<td>' . $value["TIPE"] . '</td>';
            $table .= '<td>' . $value["PESAN"] . '</td>';
            $table .= '</tr>';
            $no++;
        }
        return $table;
    }

    function getPrice() {
        $kd_prov = $this->input->post('kd_prov');
        $kd_kota = $this->input->post('kd_kota');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');

        $tipe_semen = $this->input->post('tipe_semen'); // 1 = semen 40kg; 2 = semen 50kg;

        $data = $this->DailyMs_model->getPrice($kd_prov, $kd_kota, $tahun, $bulan, $tipe_semen);
        $brand = $this->DailyMs_model->getBrand($kd_prov, $kd_kota, $tahun, $bulan, $tipe_semen);
        $kota = $this->DailyMs_model->getKota($kd_prov);
        $provinsi = $this->DailyMs_model->getProvinsi($kd_prov);

        $traceJual = array();
        $traceTebus = array();
        $traceTmpJual = array();
        $tkota = '<option value="0">-- Pilih Kota --</option>';

        foreach ($brand as $key => $value) {
            $traceTmpJual[$value['KD_PERUSAHAAN']] = array(
                "type" => "box",
                "name" => $value['PRODUK'],
                "y" => array()
            );
        }

        $traceTmpTebus = $traceTmpJual;

        foreach ($data as $key => $value) {
            array_push($traceTmpJual[$value['KD_PERUSAHAAN']]["y"], $value['HARGA_JUAL']);
            array_push($traceTmpTebus[$value['KD_PERUSAHAAN']]["y"], $value['HARGA_TEBUS']);
        }
        foreach ($traceTmpJual as $key => $value) {
            array_push($traceJual, $value);
        }
        foreach ($traceTmpTebus as $key => $value) {
            array_push($traceTebus, $value);
        }
        foreach ($kota as $key => $value) {
            $tkota .= '<option value="' . $value["KD_KOTA"] . '">' . $value["NM_KOTA"] . '</option>';
        }
        $dataReturn = array(
            "provinsi" => $provinsi,
            "kota" => $tkota,
            "jual" => $traceJual,
            "tebus" => $traceTebus
        );
        echo json_encode($dataReturn);
    }

    function getTrendPrice() {
//        print_r($this->input->post(null,true));
        $kd_prov = $this->input->post('kd_prov');
        $kd_kota = $this->input->post('kd_kota');
        $bulan_awal = $this->input->post('bulan_awal');
        $bulan_akhir = $this->input->post('bulan_akhir');
        $tahun_awal = $this->input->post('tahun_awal');
        $tahun_akhir = $this->input->post('tahun_akhir');
        $type_semen = $this->input->post('type_semen');

        $jenis_price = $this->input->post('jenis_price'); // 1 = lowest; 2 = median; 3 = highest;

        $data = $this->DailyMs_model->getPriceRange($kd_prov, $kd_kota, $tahun_awal, $tahun_akhir, $bulan_awal, $bulan_akhir, $type_semen);
        $brand = $this->DailyMs_model->getBrandPrice($kd_prov, $kd_kota, $tahun_awal, $tahun_akhir, $bulan_awal, $bulan_akhir, $type_semen);
        $dataTempJual = array();
        $dataTempTebus = array();
        $traceTmpJual = array();
        $traceTmpTebus = array();

        $n = 0;
        foreach ($brand as $value) {
            $dataTempJual[$value['KD_PERUSAHAAN']] = array();
            $traceTmpJual[$value['KD_PERUSAHAAN']] = array(
                "label" => $value['PRODUK'],
                "type" => "line",
                "fill" => false,
                "data" => array(),
                "borderColor" => $this->warna($n),
                "backgroundColor" => $this->warna($n),
                "borderWidth" => 3,
                "spanGaps" => false
            );
            $n++;
        }
        $traceTmpTebus = $traceTmpJual;

        $bulan = array();
        $awal = $tahun_awal . '-' . $bulan_awal . '-01';
        $akhir = $tahun_akhir . '-' . $bulan_akhir . '-01';

        $dateAwal = new DateTime($awal);
        $dateAkhir = new DateTime($akhir);

        for ($i = $dateAwal; $i <= $dateAkhir;) {

            $keybulan = $i->format('m');
            $tahun = $i->format('Y');
            $bln = $keybulan . '/' . $tahun;
            //echo $bln;
            foreach ($dataTempJual as $key => $value) {
                $dataTempJual[$key][$bln] = array();
            }
            array_push($bulan, $bln);
            $i->modify('+1 months');
        }

        $dataTempTebus = $dataTempJual;

        foreach ($data as $value) {
            array_push($dataTempJual[$value['KD_PERUSAHAAN']][$value['BULAN']], $value['HARGA_JUAL']);
            array_push($dataTempTebus[$value['KD_PERUSAHAAN']][$value['BULAN']], $value['HARGA_TEBUS']);
        }
//        echo '<pre>';
//        print_r($data);
//        print_r($dataTempJual);
//        print_r($dataTempTebus);
//        echo '</pre>';


        foreach ($dataTempJual as $key => $value) {
            $dateAwal = new DateTime($awal);
            $dateAkhir = new DateTime($akhir);
            for ($i = $dateAwal; $i <= $dateAkhir;) {
                //echo $dateAwal.' ';
                $keybulan = $i->format('m');
                $tahun = $i->format('Y');
                $bln = $keybulan . '/' . $tahun;
                //echo $bln;
                if (count($dataTempJual[$key][$bln]) > 0) {
                    //echo 'ada<br/>';
                    if ($jenis_price == 1) {
                        array_push($traceTmpJual[$key]['data'], min($dataTempJual[$key][$bln]));
                    } else if ($jenis_price == 2) {
                        array_push($traceTmpJual[$key]['data'], $this->median($dataTempJual[$key][$bln]));
                    } else if ($jenis_price == 3) {
                        array_push($traceTmpJual[$key]['data'], max($dataTempJual[$key][$bln]));
                    }
                } else {
                    //echo 'gak ada<br/>';
                    array_push($traceTmpJual[$key]['data'], 0);
                }
                $i->modify('+1 months');
            }
        }


        //harga tebus
        foreach ($dataTempTebus as $key => $value) {
            $dateAwal = new DateTime($awal);
            $dateAkhir = new DateTime($akhir);
            for ($i = $dateAwal; $i <= $dateAkhir;) {
                $keybulan = $i->format('m');
                $tahun = $i->format('Y');
                $bln = $keybulan . '/' . $tahun;
                if (count($dataTempTebus[$key][$bln]) > 0) {
                    if ($jenis_price == 1) {
                        array_push($traceTmpTebus[$key]['data'], min($dataTempTebus[$key][$bln]));
                    } else if ($jenis_price == 2) {
                        array_push($traceTmpTebus[$key]['data'], $this->median($dataTempTebus[$key][$bln]));
                    } else if ($jenis_price == 3) {
                        array_push($traceTmpTebus[$key]['data'], max($dataTempTebus[$key][$bln]));
                    }
                } else {
                    array_push($traceTmpTebus[$key]['data'], 0);
                }
                //echo $key.' - '.$bln;
                $i->modify('+1 months');
            }
            //echo $key.'<br/>';
        }

        $dataReturnJual = array();
        $dataReturnTebus = array();
        //echo '<pre>';
        //print_r($dataTempJual);
        //echo '</pre>';
        $n = 0;
        foreach ($traceTmpJual as $value) {
            $dataReturnJual[$n] = $value;
            $n++;
        }
        $n = 0;
        foreach ($traceTmpTebus as $value) {
            $dataReturnTebus[$n] = $value;
            $n++;
        }

//        echo '<pre>';
        echo json_encode(array("bulan" => $bulan, "dataJual" => $dataReturnJual, "dataTebus" => $dataReturnTebus));
//        print_r($traceTmp);
//        echo '</pre>';
    }
    /*
     * Pembuatan datatable price semen
     */
    function listprice($bulan_fil,$tahun_fil) {
        if($bulan_fil==0){
            $bulan_fil = date('m');
        }
        if($tahun_fil==0){
            $tahun_fil = date('Y');
        }
        $list = $this->DailyMs_model->dataprice($bulan_fil,$tahun_fil);
        $data = array();
        $no = 0;
        $bulan['01'] = 'Januari';
        $bulan['02'] = 'Februari';
        $bulan['03'] = 'Maret';
        $bulan['04'] = 'April';
        $bulan['05'] = 'Mei';
        $bulan['06'] = 'Juni';
        $bulan['07'] = 'Juli';
        $bulan['08'] = 'Agustus';
        $bulan['09'] = 'September';
        $bulan['10'] = 'Oktober';
        $bulan['11'] = 'November';
        $bulan['12'] = 'Desember';
        foreach ($list as $lists) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            $row[] = $lists['NM_PROV'];
            $row[] = $lists['NM_KOTA'];
            $row[] = $lists['PRODUK'];
            $row[] = $lists['HARI'] . ' ' . $bulan[$lists['BULAN']] . ' ' . $lists['TAHUN'];
            $row[] = '<div style="text-align:right;">' . str_replace(',', '.', number_format($lists['HARGA_TEBUS'])) . '</div>';
            $row[] = '<div style="text-align:right;">' . str_replace(',', '.', number_format($lists['HARGA_JUAL'])) . '</div>';
            $row[] = '<center>' . $lists['TIPE'] . '</center>';
            $row[] = '<center>'
                    . '<a style="margin-right:5px;" class="btn btn-xs btn-warning" href="javascript:void(0)" title="Edit" onclick="edit_price(' . "'" . $lists['ID'] . "'" . ')"><i class="fa fa-edit"></i></a>'
                    . '<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_price(' . "'" . $lists['ID'] . "'" . ')"><i class="fa fa-trash"></i></a>'
                    . '</center>';
            $data[] = $row;
        }
        $out = array(
//            "draw" => $_POST['draw'],
//            "recordsTotal" => $this->Newsfeed_model->paging(),
            "data" => $data,
        );
        echo json_encode($out);
    }
    // View data price per id
    function detail_price($id) {
        $data = $this->DailyMs_model->price_get_by_id($id);
        echo json_encode($data);
    }
    // Edit data price
    function update_price() {
        $data = $this->input->post(null, true);
        $UPDATE_BY = strtoupper($this->session->userdata('usernamescm'));
        $data['UPDATE_BY'] = $UPDATE_BY;
        $save = $this->DailyMs_model->update_price($data);
        echo json_encode(array("status" => $save));
    }
    // Delete data price
    function delete_price($id) {
        $this->DailyMs_model->price_delete($id);
        echo json_encode(array("status" => TRUE));
    }

    function cek_kota() {
        $list_kota = $this->DailyMs_model->cek_kota($this->input->post('NM_PROV'));
        $result = '<option value="0">-- Pilih Kota --</option>';
        foreach ($list_kota as $i) {
            $result .= '<option value="' . $i['KD_KOTA'] . '">' . $i['NM_KOTA'] . '</option>';
        }
        echo json_encode(
                array('list_kota_dibawa' => $result)
        );
    }

    function warna($n) {
        $warna = array("#FF0000", "#FFFF00", "#FF8000", "#80FF00", "#00FF00", "#00FF80", "#00FFFF",
            "#0080FF", "#0000FF", "#7F00FF", "#FF00FF", "#FF007F", "#FF9999", "#B266FF", "#F0000F", "#FF9922");
        return $warna[$n];
    }

    function median($arr) {
        sort($arr);
        $count = count($arr); //hitung jumlah elemen array
        $middleval = floor(($count - 1) / 2); // temukan elemen tengah
        if ($count % 2) { // jika nomor ganjil maka elemen tengah adalah median
            $median = $arr[$middleval];
        } else { // jika genap maka hitung rata-rata 2 elemen tengah
            $low = $arr[$middleval];
            $high = $arr[$middleval + 1];
            $median = (($low + $high) / 2);
        }
        return $median;
    }

    function tes() {
        $tahun = '2016';
        $tahunAkhir = '2017';
        $bulan = '10';
        $bulanAkhir = '12';

        $awal = $tahun . '-' . $bulan . '-01';
        $akhir = $tahunAkhir . '-' . $bulanAkhir . '-01';

        $dateAwal = new DateTime($awal);
        $dateAkhir = new DateTime($akhir);
        if ($dateAwal == $dateAkhir) {
            $dateAkhir->modify('+1 months');
        }

        for ($i = $dateAwal; $i <= $dateAkhir;) {
            $keybulan = $i->format('m');
            $tahun = $i->format('Y');
            echo $keybulan . '-' . $tahun . '<br/>';
            //$data[$tahun . '' . $keybulan] = $this->DemandplMS_model->getDataASI($tahun, $keybulan);
            //$dataDN[$tahun . '' . $keybulan] = $this->DemandplMS_model->getDataASIGDN($tahun, $keybulan);            
            $i->modify('+1 months');
        }
    }
    /*
     * Export excel data price
     */
    function downloadPrice($kd_prov,$kd_kota,$tahun,$bulan){
        //$post = $this->input->post(null,true);
        $data = $this->DailyMs_model->downloadDataPrice($kd_prov,$kd_kota,$tahun,$bulan);
        
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        /* buat header */
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Nomor');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Provinsi');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Kota');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Brand');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Tanggal');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Harga Tebus');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Harga Jual');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Tipe');

        $no = 1;
        $row = 2;
        foreach ($data as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['NM_PROV']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['NM_KOTA']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['PRODUK']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, '\''.$value['HARI'].'/'.$value['BULAN'].'/'.$value['TAHUN']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['HARGA_TEBUS']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['HARGA_JUAL']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['TIPE']);
            $row++;
            $no++;
        }

        $namafile = 'Data Price.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $namafile . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        //header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
//        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("php://output");
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
    }
}
