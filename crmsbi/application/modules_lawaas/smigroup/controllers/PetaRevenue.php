<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

class PetaRevenue extends CI_Controller {
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('is_login'))redirect('login');
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('PetaRevenue_model');
    }
    
    function index(){
        $data = array('title'=>'Peta Revenue');
        $this->template->display('PetaRevenue_view',$data);
    }
    
    function getData($org,$tahun,$bulan){        
//        $tahun = date("Y");
//        $bulan = date("m");
        if ($bulan == date("m")) {
            $hari = date("d");
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        $data = $this->PetaRevenue_model->data($org,$tahun,$bulan,$hari);
        $arrData = array(
            "chart" => array(
                "caption" => "Peta Revenue",
                "theme" => "fint",
                "formatNumberScale" => "0",
                "numberSuffix" => "%",                
                "showLabels" => "1",
                "includeNameInLabels" => "1",
                "nullEntityColor"=> "#C2C2D6",
                "nullEntityAlpha"=> "50",
                "hoverOnNull"=> "0",
                "useSNameInLabels" => "1",
                "legendPosition"=> "bottom",
                "showToolTip"=>"1",
                "baseFontSize"=>"14",
            ),
            "colorrange" => array(
                "color" => array(
                    array(
                        "minvalue" => "0",
                        "maxvalue" => "98",
                        "code" => "#ff4545",
                        "displayValue" => "0% - 98%"
                    ),
                    array(
                        "minvalue" => "98",
                        "maxvalue" => "100",
                        "code" => "#fef536",
                        "displayValue" => "98% - 100%"
                    ),
                    array(
                        "minvalue" => "100",
                        "maxvalue" => "1000",
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
                    "internalId"=> "15",
                    "newId"=> "1019"
                ),
                array(
                    "internalId"=> "28",
                    "newId"=> "1039"
                ),
                array(
                    "internalId"=> "42",
                    "newId"=> "1043"
                ),
                array(
                    "internalId"=> "29",
                    "newId"=> "1040"
                ),
                array(
                    "internalId"=> "31",
                    "newId"=> "1037"
                ),
                array(
                    "internalId"=> "26",
                    "newId"=> "1011"
                ),
                array(
                    "internalId"=> "36",
                    "newId"=> "1041"
                ),
                array(
                    "internalId"=> "37",
                    "newId"=> "1013"
                ),
                array(
                    "internalId"=> "40",
                    "newId"=> "1014"
                ),
                array(
                    "internalId"=> "22",
                    "newId"=> "1035"
                ),
                array(
                    "internalId"=> "12",
                    "newId"=> "1030"
                ),
                array(
                    "internalId"=> "38",
                    "newId"=> "1033"
                ),
                array(
                    "internalId"=> "32",
                    "newId"=> "1016"
                ),
                array(
                    "internalId"=> "30",
                    "newId"=> "1022"
                ),
                array(
                    "internalId"=> "11",
                    "newId"=> "1029"
                ),
                array(
                    "internalId"=> "17",
                    "newId"=> "1027"
                ),
                array(
                    "internalId"=> "39",
                    "newId"=> "1042"
                ),
                array(
                    "internalId"=> "41",
                    "newId"=> "1034"
                ),
                array(
                    "internalId"=> "24",
                    "newId"=> "1012"
                ),
                array(
                    "internalId"=> "10",
                    "newId"=> "1024"
                )
            )
        );
        $arrData["data"] = array();
           
        foreach($data as $row){
            if($row["RKAPREVENUH"]!=0){
                $persen = round(($row["REVENUE"]/$row["RKAPREVENUH"])*100);
            } else {
                $persen = 0;
            }
            
            array_push($arrData["data"], array(
                "id" => $row["PROV"],
                "value" => $persen,                
                "toolText" => "<b>".$row['NM_PROV'] . "</b> {br}$persen%"
            ));
        }
        echo json_encode($arrData);
    }
    
    function getDetail($org,$prov,$tahun,$bulan){                
        $data = $this->MarketShare_model->getDetail($prov,$tahun,$bulan);
        $no = 1;
        $table = '';
        $prov = '';
        foreach($data as $row){
            if($org==1){
                if($row['KODE_PERUSAHAAN']=='110'||$row['KODE_PERUSAHAAN']=='112'||$row['KODE_PERUSAHAAN']=='102'){
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            } else if($org==7000){
                if($row['KODE_PERUSAHAAN']=='110'){
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            } else if($org==4000){
                if($row['KODE_PERUSAHAAN']=='112'){
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            } else if($org==3000){
                if($row['KODE_PERUSAHAAN']=='102'){
                    $table .= '<tr class="highlight">';
                } else {
                    $table .= '<tr>';
                }
            }
            
                $table .= '<td align="center">'.$no.'</td>';
                $table .= '<td>'.$row['NAMA_PERUSAHAAN'].'</td>';
                $table .= '<td align="right">'.number_format(round($row['QTY_REAL']),0,'','.').'</td>';
                $table .= '<td align="right">'.round($row['QTY'],2).' %</td>';
                $table .= '<td align="right">0 %</td>';
                $table .= '<td align="right">0 %</td>';
                $table .= '<td align="right">0 %</td>';
                $table .= '<td align="right">0 %</td>';
            $table .= '</tr>';
            $no++;
            $prov = $row['NM_PROV'];
        }
        echo json_encode(array("table"=>$table,"provinsi"=>$prov));
    }
    
    function getUpdateDate(){
        $data = $this->PetaRevenue_model->updateDate();
        echo json_encode($data);
    }
    
    function getRevenue($org,$tahun,$bulan){    
        if ($bulan == date("m")) {
            $hari = date("d");
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        }
        
        $revenueSG = 0;
        $revenueST = 0;
        $revenueSP = 0;
        $revenueSMIG = 0;
        $rkapSG = 0;
        $rkapST = 0;
        $rkapSP = 0;
        $rkapSMIG = 0;
        
        if($org == '7000'){
            $data = $this->PetaRevenue_model->dataSG($tahun,$bulan);
        } else if($org=='4000'){
            $data = $this->PetaRevenue_model->dataST($tahun,$bulan);
        } else if($org=='3000'){
            $data = $this->PetaRevenue_model->dataSP($tahun,$bulan);
        } else if($org=='1'){
            $data = $this->dataSMIG($tahun,$bulan);
            $revenueSG = $data['revenueSG'];
            $revenueST = $data['revenueST'];
            $revenueSP = $data['revenueSP'];
            $revenueSMIG = $data['revenueSMIG'];
            $rkapSG = $data['rkapSG'];
            $rkapST = $data['rkapST'];
            $rkapSP = $data['rkapSP'];
            $rkapSMIG = $data['rkapSMIG'];
            unset($data['revenueSG']);
            unset($data['revenueSP']);
            unset($data['revenueST']);
            unset($data['revenueSMIG']);
            unset($data['rkapSG']);
            unset($data['rkapSP']);
            unset($data['rkapST']);
            unset($data['rkapSMIG']);
        }
        
        $arrData = array(
            "chart" => array(
                "caption" => "Realisasi Revenue Terhadap RKAP s/d " . $hari . " " . $this->bulan($bulan) . " " . $tahun,
                "theme" => "fint",
                "formatNumberScale" => "0",
                "numberSuffix" => "%",                
                "showLabels" => "1",
                "includeNameInLabels" => "1",
                "nullEntityColor"=> "#C2C2D6",
                "nullEntityAlpha"=> "50",
                "hoverOnNull"=> "0",
                "useSNameInLabels" => "1",
                "legendPosition"=> "bottom",
                "showToolTip"=>"1",
                "baseFontSize"=>"14",
            ),
            "colorrange" => array(
                "color" => array(
                    array(
                        "minvalue" => "0",
                        "maxvalue" => "98",
                        "code" => "#ff4545",
                        "displayValue" => "0% - 98%"
                    ),
                    array(
                        "minvalue" => "98",
                        "maxvalue" => "100",
                        "code" => "#fef536",
                        "displayValue" => "98% - 100%"
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
                    "internalId"=> "15",
                    "newId"=> "1019"
                ),
                array(
                    "internalId"=> "28",
                    "newId"=> "1039"
                ),
                array(
                    "internalId"=> "42",
                    "newId"=> "1043"
                ),
                array(
                    "internalId"=> "29",
                    "newId"=> "1040"
                ),
                array(
                    "internalId"=> "31",
                    "newId"=> "1037"
                ),
                array(
                    "internalId"=> "26",
                    "newId"=> "1011"
                ),
                array(
                    "internalId"=> "36",
                    "newId"=> "1041"
                ),
                array(
                    "internalId"=> "37",
                    "newId"=> "1013"
                ),
                array(
                    "internalId"=> "40",
                    "newId"=> "1014"
                ),
                array(
                    "internalId"=> "22",
                    "newId"=> "1035"
                ),
                array(
                    "internalId"=> "12",
                    "newId"=> "1030"
                ),
                array(
                    "internalId"=> "38",
                    "newId"=> "1033"
                ),
                array(
                    "internalId"=> "32",
                    "newId"=> "1016"
                ),
                array(
                    "internalId"=> "30",
                    "newId"=> "1022"
                ),
                array(
                    "internalId"=> "11",
                    "newId"=> "1029"
                ),
                array(
                    "internalId"=> "17",
                    "newId"=> "1027"
                ),
                array(
                    "internalId"=> "39",
                    "newId"=> "1042"
                ),
                array(
                    "internalId"=> "41",
                    "newId"=> "1034"
                ),
                array(
                    "internalId"=> "24",
                    "newId"=> "1012"
                ),
                array(
                    "internalId"=> "10",
                    "newId"=> "1024"
                )
            )
        );
        
        
        
        $arrData["data"] = array();
           
        foreach($data as $row){
            if($row["RKAPREVENUB"]!=0){
                $persen = round(($row["REVENUE"]/$row["RKAPREVENUB"])*100);
            } else {
                $persen = 0;
            }            
            array_push($arrData["data"], array(
                "id" => $row["PROV"],
                "value" => $persen,                
                "toolText" => "<b>".$row['NM_PROV'] . "</b> {br}$persen%"
            ));
        }
        $arr = array(
            "data"=>$arrData,
            "revenueSMIG" => $revenueSMIG,
            "revenueSG" => $revenueSG,
            "revenueST" => $revenueST,
            "revenueSP" => $revenueSP,
            "rkapSMIG" => $rkapSMIG,
            "rkapSG" => $rkapSG,
            "rkapST" => $rkapST,
            "rkapSP" => $rkapSP,
        );
        echo json_encode($arr);
    }
    
    function dataSMIG($tahun,$bulan){
        $prov = $this->PetaRevenue_model->getProv();
        $sg = $this->PetaRevenue_model->dataSG($tahun,$bulan);
        $sp = $this->PetaRevenue_model->dataSP($tahun,$bulan);
        $st = $this->PetaRevenue_model->dataST($tahun,$bulan);
        $data = array();
        $revenueSG = 0;
        $revenueSP = 0;
        $revenueST = 0;
        $revenueSMIG = 0;
        $rkapSG = 0;
        $rkapSP = 0;
        $rkapST = 0;
        $rkapSMIG = 0;
        foreach($prov as $value){            
            $data[$value['KD_PROV']]['REVENUE'] = 0;
            $data[$value['KD_PROV']]['RKAPREVENUB'] = 0;
        }
        foreach($sg as $value){
            $data[$value['PROV']]['PROV'] = $value['PROV'];
            $data[$value['PROV']]['NM_PROV'] = $value['NM_PROV'];
            $data[$value['PROV']]['REVENUE'] += $value['REVENUE'];
            $data[$value['PROV']]['RKAPREVENUB'] += $value['RKAPREVENUB'];
            $revenueSG += $value['REVENUE'];
            $rkapSG += round(str_replace(',','.',$value['RKAPREVENUB']));
        }
        foreach($sp as $value){
            $data[$value['PROV']]['PROV'] = $value['PROV'];
            $data[$value['PROV']]['NM_PROV'] = $value['NM_PROV'];
            $data[$value['PROV']]['REVENUE'] += $value['REVENUE'];
            $data[$value['PROV']]['RKAPREVENUB'] += $value['RKAPREVENUB'];
            $revenueSP += $value['REVENUE'];
            $rkapSP += round(str_replace(',','.',$value['RKAPREVENUB']));
        }
        foreach($st as $value){
            $data[$value['PROV']]['PROV'] = $value['PROV'];
            $data[$value['PROV']]['NM_PROV'] = $value['NM_PROV'];
            $data[$value['PROV']]['REVENUE'] += $value['REVENUE'];
            $data[$value['PROV']]['RKAPREVENUB'] += $value['RKAPREVENUB'];
            $revenueST += $value['REVENUE'];
            $rkapST += round(str_replace(',','.',$value['RKAPREVENUB']));
        }
        $revenueSMIG = $revenueSG+$revenueSP+$revenueST;
        $rkapSMIG = $rkapSG+$rkapSP+$rkapST;
        
        $data['revenueSG'] = $revenueSG;
        $data['revenueSP'] = $revenueSP;
        $data['revenueST'] = $revenueST;
        $data['revenueSMIG'] = $revenueSMIG;
        $data['rkapSG'] = $rkapSG;
        $data['rkapSP'] = $rkapSP;
        $data['rkapST'] = $rkapST;
        $data['rkapSMIG'] = $rkapSMIG;
        return $data;
    }
    function tanggal(){
        $tahun = date("Y");
        $bulan = date("m");
        $hari = date('d');
        $org = '4000';
        $data = $this->PetaRevenue_model->data($org,$tahun,'07','31');
        
        echo '<pre>';
        print_r($data);
        echo '</pre>';
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

}

