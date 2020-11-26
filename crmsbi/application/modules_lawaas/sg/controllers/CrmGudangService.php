<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class CrmGudangService extends CI_Controller {

    private $db2;

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login'))
            redirect('login');
        $this->load->model('CrmGudangService_model');
    }

    function index() {
        $data = array('title' => 'Semen Gresik');
        $this->template->display('CrmGudangService_view', $data);
    }

    function test($date) {
        $area = array(
            array(
                array(
                    "LABELS" => "AREA SURABAYA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA MALANG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BOJONEGORO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA KEDIRI",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA MADIUN",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA JEMBER",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SITUBONDO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA MADURA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            ),
            array(
                array(
                    "LABELS" => "AREA KUDUS",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SEMARANG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SOLO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA TEGAL",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA JOGJAKARTA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA PURWOKERTO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            ),
            array(
                array(
                    "LABELS" => "AREA CIREBON",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA TASIKMALAYA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA DKI JAKARTA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BANDUNG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA KERAWANG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SUKABUMI",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BOGOR",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BANTEN",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            ),
            array(
                array(
                    "LABELS" => "AREA BALI",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            )
        );
        $data = $this->CrmGudangService_model->getData($date);
        $numrows = $data['values']->num_rows();
        while ($numrows <= 0) {
            $newdate = strtotime('-1 day', strtotime($date));
            $date = date('d-m-Y', $newdate);
            $data = $this->CrmGudangService_model->getData($date);
            $numrows = $data['values']->num_rows();
        }
        /*
         * $data['properties'] = head and rows
         * $data['values'] = values
         */
        $properties = $data['properties'];
        $values = $data['values'];
        #REGON
        $region = array(
            1 => 'AREA JATIM',
            2 => 'AREA JATENG & DIY',
            3 => 'AREA JABAR DKI & BANTEN',
            4 => 'AREA 4',
            5 => 'AREA 5',
        );
        $arr = array();

        if (!$properties->result()) {
            foreach ($area as $k => $data) {
                foreach ($data as $key => $value) {
                    $arr[$k]['labels'][] = $value['LABELS'];
                    $arr[$k]['stok'][] = round($value['STOK']);
                    $arr[$k]['kapasitas'][] = round($value['KAPASITAS']);
                }
            }
        } else {
            $regionData = array();
            foreach ($region as $key => $value) {
                foreach ($properties->result() as $pro) {
                    if ($pro->ID_REGION == $key) {
                        $regionData[$key][] = $pro;
                    }
                }
            }

            foreach ($values->result() as $val) {
                foreach ($regionData as $keyReg => $valReg) {
                    foreach ($valReg as $key => $value) {
                        if ($value->KD_KOTA == $val->KOTA_SHIPTO) {
                            $dataRegion[$keyReg][] = array('KD_AREA' => (int) $value->NO_AREA,
                                'KD_KOTA' => $value->KD_KOTA,
                                'KD_PROV' => $value->KD_PROV,
                                'NM_PROV' => $value->NM_PROV,
                                'QTY_STOK' => $val->QTY_STOK,
                                'KAPASITAS' => $val->KAPASITAS,
                                'DESCH' => $value->DESCH);
                        }
                    }
                }
            }
            if (key_exists(3, $dataRegion)) {
                foreach ($dataRegion[3] as $key => $value) {
                    if ($value['KD_KOTA'] == '212001') {
                        $dataRegion[3][$key]['KD_AREA'] = 3;
                    }
                    if ($value['KD_AREA'] == 3 && $value['KD_KOTA'] != '212001') {
                        $dataRegion[3][$key]['KD_AREA'] = 4;
                    } else if ($value['KD_AREA'] == 4) {
                        $dataRegion[3][$key]['KD_AREA'] = 5;
                    } else if ($value['KD_AREA'] == 5) {
                        $dataRegion[3][$key]['KD_AREA'] = 6;
                    } else if ($value['KD_AREA'] == 6) {
                        $dataRegion[3][$key]['KD_AREA'] = 7;
                    } else if ($value['KD_AREA'] == 7) {
                        $dataRegion[3][$key]['KD_AREA'] = 8;
                    }
                }
            }
            $xData = array();
            $sid2 = array();
            foreach ($dataRegion as $key => $value) {
                $sid = array();
                foreach ($value as $k => $v) {
                    @$sid[$v['KD_AREA']]['LABELS'] = $v['DESCH'];
                    @$sid[$v['KD_AREA']]['STOK'] += $v['QTY_STOK'];
                    @$sid[$v['KD_AREA']]['KAPASITAS'] += $v['KAPASITAS'];
                    //@$sid2[$v['KD_PROV']][$v['NM_PROV']]  += $v['QTY_STOK'];
                }
                ksort($sid);
                @$xData[$key] = $sid;
            }
            ksort($sid);
            //ksort($sid2);       

            foreach ($xData as $key => $value) {
                foreach ($value as $ke => $data) {
                    $area[$key - 1][$ke - 1]['LABELS'] = $data['LABELS'];
                    $area[$key - 1][$ke - 1]['STOK'] = $data['STOK'];
                    $area[$key - 1][$ke - 1]['KAPASITAS'] = $data['KAPASITAS'];
                }
            }
            foreach ($area as $k => $data) {
                foreach ($data as $key => $value) {
                    $arr[$k]['labels'][] = $value['LABELS'];
                    $arr[$k]['stok'][] = round($value['STOK']);
                    $arr[$k]['kapasitas'][] = round($value['KAPASITAS']);
                }
            }
        }
        return $arr;
    }

    function getHariIni() {
        $area = array(
            array(
                array(
                    "LABELS" => "AREA SURABAYA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA MALANG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BOJONEGORO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA KEDIRI",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA MADIUN",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA JEMBER",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SITUBONDO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA MADURA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            ),
            array(
                array(
                    "LABELS" => "AREA KUDUS",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SEMARANG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SOLO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA TEGAL",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA JOGJAKARTA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA PURWOKERTO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            ),
            array(
                array(
                    "LABELS" => "AREA CIREBON",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA TASIKMALAYA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA DKI JAKARTA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BANDUNG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA KERAWANG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SUKABUMI",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BOGOR",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BANTEN",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            ),
            array(
                array(
                    "LABELS" => "AREA BALI",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            )
        );
        $data = $this->CrmGudangService_model->getDataMax();
        /*
         * $data['properties'] = head and rows
         * $data['values'] = values
         */
        $properties = $data['properties'];
        $values = $data['values'];

        #REGON
        $region = array(
            1 => 'AREA JATIM',
            2 => 'AREA JATENG & DIY',
            3 => 'AREA JABAR DKI & BANTEN',
            4 => 'AREA 4',
            5 => 'AREA 5',
        );
        $arr = array();

        if (!$properties->result()) {
            foreach ($area as $k => $data) {
                foreach ($data as $key => $value) {
                    $arr[$k]['labels'][] = $value['LABELS'];
                    $arr[$k]['stok'][] = round($value['STOK']);
                    $arr[$k]['kapasitas'][] = round($value['KAPASITAS']);
                }
            }
        } else {
            $regionData = array();
            foreach ($region as $key => $value) {
                foreach ($properties->result() as $pro) {
                    if ($pro->ID_REGION == $key) {
                        $regionData[$key][] = $pro;
                    }
                }
            }
            $maxDate = '';
            foreach ($values->result() as $val) {
                $maxDate = $val->TGL_RILIS;
                foreach ($regionData as $keyReg => $valReg) {
                    foreach ($valReg as $key => $value) {
                        if ($value->KD_KOTA == $val->KOTA_SHIPTO) {
                            $dataRegion[$keyReg][] = array('KD_AREA' => (int) $value->NO_AREA,
                                'KD_KOTA' => $value->KD_KOTA,
                                'KD_PROV' => $value->KD_PROV,
                                'NM_PROV' => $value->NM_PROV,
                                'QTY_STOK' => $val->QTY_STOK,
                                'KAPASITAS' => $val->KAPASITAS,
                                'DESCH' => $value->DESCH);
                        }
                    }
                }
            }
            if (key_exists(3, $dataRegion)) {
                foreach ($dataRegion[3] as $key => $value) {
                    if ($value['KD_KOTA'] == '212001') {
                        $dataRegion[3][$key]['KD_AREA'] = 3;
                    }
                    if ($value['KD_AREA'] == 3 && $value['KD_KOTA'] != '212001') {
                        $dataRegion[3][$key]['KD_AREA'] = 4;
                    } else if ($value['KD_AREA'] == 4) {
                        $dataRegion[3][$key]['KD_AREA'] = 5;
                    } else if ($value['KD_AREA'] == 5) {
                        $dataRegion[3][$key]['KD_AREA'] = 6;
                    } else if ($value['KD_AREA'] == 6) {
                        $dataRegion[3][$key]['KD_AREA'] = 7;
                    } else if ($value['KD_AREA'] == 7) {
                        $dataRegion[3][$key]['KD_AREA'] = 8;
                    }
                }
            }

            $xData = array();
            $sid2 = array();
            foreach ($dataRegion as $key => $value) {
                $sid = array();
                foreach ($value as $k => $v) {
                    @$sid[$v['KD_AREA']]['LABELS'] = $v['DESCH'];
                    @$sid[$v['KD_AREA']]['STOK'] += $v['QTY_STOK'];
                    @$sid[$v['KD_AREA']]['KAPASITAS'] += $v['KAPASITAS'];
                    //@$sid2[$v['KD_PROV']][$v['NM_PROV']]  += $v['QTY_STOK'];
                }
                ksort($sid);
                @$xData[$key] = $sid;
            }
            ksort($sid);
            //ksort($sid2);       

            foreach ($xData as $key => $value) {
                foreach ($value as $ke => $data) {
                    $area[$key - 1][$ke - 1]['LABELS'] = $data['LABELS'];
                    $area[$key - 1][$ke - 1]['STOK'] = $data['STOK'];
                    $area[$key - 1][$ke - 1]['KAPASITAS'] = $data['KAPASITAS'];
                }
            }
            foreach ($area as $k => $data) {
                foreach ($data as $key => $value) {
                    $arr[$k]['labels'][] = $value['LABELS'];
                    $arr[$k]['stok'][] = round($value['STOK']);
                    $arr[$k]['kapasitas'][] = round($value['KAPASITAS']);
                }
            }
        }
//        echo '<pre>';
//        print_r($arr);
//        echo '</pre>';
        return array("arr" => $arr, "maxDate" => $maxDate);
    }

    function getDataw() {
        $dataHariIni = $this->getHariIni();
        $date = $dataHariIni['maxDate'];

        $newdate = strtotime('-1 day', strtotime($date));
        $kemarin = date('d-m-Y', $newdate);

        $newdate = strtotime('-1 week', strtotime($date));
        $newdate = date('d-m-Y', $newdate);
        $minggulalu = $newdate;

        $newdate = strtotime('-2 week', strtotime($date));
        $newdate = date('d-m-Y', $newdate);
        $minggulalu2 = $newdate;

        $newdate = strtotime('-30 day', strtotime($date));
        $newdate = date('d-m-Y', $newdate);
        $bulanlalu = $newdate;

        $data1 = $dataHariIni['arr'];
        $data2 = $this->test($kemarin);
        $data3 = $this->test($minggulalu);
        $data4 = $this->test($minggulalu2);
        $data5 = $this->test($bulanlalu);

        $data = array_merge(array("hariini" => $data1, "kemarin" => $data2, "seminggu" => $data3, "duaminggu" => $data4, "sebulan" => $data5, "tanggal" => $date));

        echo json_encode($data);
    }

    function getData($date) {
        $area = array(
            array(
                array(
                    "LABELS" => "AREA SURABAYA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA MALANG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BOJONEGORO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA KEDIRI",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA MADIUN",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA JEMBER",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SITUBONDO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA MADURA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            ),
            array(
                array(
                    "LABELS" => "AREA KUDUS",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SEMARANG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SOLO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA TEGAL",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA JOGJAKARTA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA PURWOKERTO",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            ),
            array(
                array(
                    "LABELS" => "AREA CIREBON",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA TASIKMALAYA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA DKI JAKARTA",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BANDUNG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA KERAWANG",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA SUKABUMI",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BOGOR",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                ),
                array(
                    "LABELS" => "AREA BANTEN",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            ),
            array(
                array(
                    "LABELS" => "AREA BALI",
                    "STOK" => 0,
                    "KAPASITAS" => 0
                )
            )
        );
        $data = array();
        $data[0] = array();
        $data[1] = array();
        $data[2] = array();
        $data[3] = array();
        for ($i = 1; $i <= 8; $i++) {
            array_push($data[0], $this->CrmGudangService_model->getDataJatim($i, $date));
        }
        for ($i = 1; $i <= 6; $i++) {
            array_push($data[1], $this->CrmGudangService_model->getDataJateng($i, $date));
        }
//        for ($i = 1; $i <= 8; $i++) {
//            array_push($data[2], $this->CrmGudangService_model->getDataJabar($i, $date));
//        }
        array_push($data[3], $this->CrmGudangService_model->getDataBali($date));

        $arr = array();
        foreach ($area as $k => $v) {
            foreach ($v as $key => $value) {
                $arr[$k]['labels'][] = $value['LABELS'];
                $arr[$k]['stok'][] = round($value['STOK']);
                $arr[$k]['kapasitas'][] = round($value['KAPASITAS']);
            }
        }

        foreach ($data as $key => $value) {
            foreach ($value as $ka => $ve) {
                foreach ($ve as $k => $v) {
                    $arr[$key]['stok'][$ka] = round(str_replace(',', '.', $v['QTY_STOK']));
                    $arr[$key]['kapasitas'][$ka] = round(str_replace(',', '.', $v['KAPASITAS']));
                }
            }
        }
        
        $dataJabar = $this->show($date);
        foreach($dataJabar as $key=>$value){
            $arr[2]['stok'][$key] = $value['QTY_STOK'];
            $arr[2]['kapasitas'][$key] = $value['KAPASITAS'];
        }
//        echo '<pre>';
//        print_r($arr);
//        echo '</pre>';
        return $arr;
    }

    public function dataStokAwal() {
        $tanggal = date('d/m/Y');
        $date = date('Ymd');
        $newdate = strtotime('-1 day', strtotime($date));
        $kemarin = date('Ymd', $newdate);
        $data['tanggal'] = $tanggal;
        $data['today'] = $this->getData($date);
        $data['yesterday'] = $this->getData($kemarin);
        echo json_encode($data);
//        echo '<pre>';
//        print_r($arr);
//        echo '</pre>';
    }

    public function dataStok($n) {
        $date = date('Ymd');

        if ($n == 0) {
            $tanggal = $date;
        } else if ($n == 1) {
            $newdate = strtotime('-1 day', strtotime($date));
            $tanggal = date('Ymd', $newdate);
        } else if ($n == 2) {
            $newdate = strtotime('-1 week', strtotime($date));
            $newdate = date('Ymd', $newdate);
            $tanggal = $newdate;
        } else if ($n == 3) {
            $newdate = strtotime('-2 week', strtotime($date));
            $newdate = date('Ymd', $newdate);
            $tanggal = $newdate;
        } else if ($n == 4) {
            $newdate = strtotime('-1 month', strtotime($date));
            $newdate = date('Ymd', $newdate);
            $tanggal = $newdate;
        }
        $data = $this->getData($tanggal);
        echo json_encode($data);
    }

    public function show($date) {
        //$date = date('Ymd');
        $data = array();
        for ($i = 1; $i <= 8; $i++) {
            array_push($data, $this->CrmGudangService_model->getDataJabar2($i, $date));
        }
        //$data = $this->test($kurang);
        //$data = $this->test($kurang);
        $area = array(
            array(
                "LABELS" => "AREA CIREBON",
                "QTY_STOK" => 0,
                "KAPASITAS" => 0
            ),
            array(
                "LABELS" => "AREA TASIKMALAYA",
                "QTY_STOK" => 0,
                "KAPASITAS" => 0
            ),
            array(
                "LABELS" => "AREA DKI JAKARTA",
                "QTY_STOK" => 0,
                "KAPASITAS" => 0
            ),
            array(
                "LABELS" => "AREA BANDUNG",
                "QTY_STOK" => 0,
                "KAPASITAS" => 0
            ),
            array(
                "LABELS" => "AREA KERAWANG",
                "QTY_STOK" => 0,
                "KAPASITAS" => 0
            ),
            array(
                "LABELS" => "AREA SUKABUMI",
                "QTY_STOK" => 0,
                "KAPASITAS" => 0
            ),
            array(
                "LABELS" => "AREA BOGOR",
                "QTY_STOK" => 0,
                "KAPASITAS" => 0
            ),
            array(
                "LABELS" => "AREA BANTEN",
                "QTY_STOK" => 0,
                "KAPASITAS" => 0
            )
        );
        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
//                echo '<pre>';
//                print_r($v);
//                echo '</pre>';
                if($v['NO_AREA']==1){
                    $area[$v['NO_AREA']-1]['QTY_STOK'] += $v['QTY_STOK'];
                    $area[$v['NO_AREA']-1]['KAPASITAS'] += $v['KAPASITAS'];
                }else if($v['NO_AREA']==2){
                    if($v['KD_KOTA']==212001){
                        $area[2]['QTY_STOK'] += $v['QTY_STOK'];
                        $area[2]['KAPASITAS'] += $v['KAPASITAS'];
                    } else {
                        $area[1]['QTY_STOK'] += $v['QTY_STOK'];
                        $area[1]['KAPASITAS'] += $v['KAPASITAS'];
                    }
                } else if($v['NO_AREA']==8){
                    $area[7]['QTY_STOK'] += $v['QTY_STOK'];
                    $area[7]['KAPASITAS'] += $v['KAPASITAS'];
                } else {
                    $area[$v['NO_AREA']+0]['QTY_STOK'] += $v['QTY_STOK'];
                    $area[$v['NO_AREA']+0]['KAPASITAS'] += $v['KAPASITAS'];
                }               
            }
        }
        return $area;
    }

}
