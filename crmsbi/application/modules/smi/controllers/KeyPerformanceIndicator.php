<?php
    require_once APPPATH . 'modules/smi/controllers/KpiSales.php';
    class KeyPerformanceIndicator extends KpiSales {
        public function __construct(){
            parent::__construct();
            $this->load->model("Model_KamSales", "mKamSales");
            $this->load->model("Model_kpi", "mKpi");
			
			 $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
            $this->load->library('PHPExcel');
        }

        public function index(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('KeyPerformanceIndicator_view', $data);
        }

        public function indexKpi(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('IndexKeyPerformanceIndicator_view', $data);
        }

        public function targetKpi(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('TargetKeyPerformanceIndicator_view', $data);
        }

        public function targetKunjungan(){
            $data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('TargetTotalKunjungan_view', $data);
        }

        public function targetCustomer(){
            $data = array("title" => "Dashboard CRM Administrator");
            $this->template->display('TargetCustomer_view', $data);
        }
		
		public function Export_exel($bulan = null, $tahun = null){
            if($bulan < 10){
                $bulan = "0".$bulan;
            } else {
                $bulan = $bulan;
            }

            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));

            $data = array();
            $kamSales = $this->mKamSales->listKamSales();
            if($kamSales){
                $i=1;
                foreach ($kamSales as $kamSalesKey => $kamSalesValue) {
                    // $nilaiKpi = 0;
                    $nilaiKpi = $this->detailKpiSales($kamSalesValue->ID_USER, $bulan, $tahun);
                    $data[] = array(
                        $i,
                        strtoupper($kamSalesValue->NAMA),
                        $kamSalesValue->NAMA_DISTRIBUTOR,
                        $nilaiKpi
                    );
                    $i++;
                }
            } else {
                $data[] = array("-","-","-","-");
            }

            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            // exit;
            //jika user memilih kode material
        
        
            $objPHPExcel = new PHPExcel();

            $objset     = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget     = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $abjad = array(
                    'A','B','C','D','E','F','G','H','I','J'
            );

            $style_center = array(
                    'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
            );
            $style_right = array(
                    'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
            );
            $style_bg = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'ff0000')
                    ),
                    'font' => array(
                            'color' => array('rgb' => 'ffffff')
                    )
            );
            
            $style_list = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFF00')
                    ),
                    'font' => array(
                            'color' => array('rgb' => '333333')
                    )
            );

            $style_bg2 = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '#FFFF00')
                    ),
                    'font' => array(
                            'color' => array('rgb' => '#000000')
                    )
            );
            $style_bg3 = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '#FFFFFF')
                    ),
                    'font' => array(
                            'color' => array('rgb' => '#000000')
                    )
            );
            $style_bgformat = array(
                    'font' => array(
                            'color' => array('rgb' => '#FFFFFF')
                    )
            );
            $style_estimasi = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFACD')
                    )
            );
            $style_realisasi = array(
                    'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFFFF')
                    )
            );
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            //$objDrawing->setPath('./static/img/SI.png');

            $objDrawing->setCoordinates('B1');
            $objDrawing->setHeight(130);
            $objDrawing->setWidth(50);

            $objDrawing->setResizeProportional(true);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

            $objget->getStyle('B1:F2')->applyFromArray($style_center);
            
            $objset->setCellValue('A1', "");
            $objget->getStyle('A1')->applyFromArray($style_bgformat);

            $objset->setCellValue('B1', "Laporan KPI KAM/AM ");
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:H2');
            $objget->getStyle('B1')->getFont()->setSize(18);
            $objget->getStyle('B1')->getFont()->setBold(true);
            $objget->getRowDimension('1')->setRowHeight(18);
            
            
            
            
            
            //TITLE LIST =====================================================================      
            $baris =5;
            $bm     = $baris+1;
            $objset->setCellValue("B".$baris , "NO");
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("B". $baris. ":B". $bm);
            $objget->getStyle('B5')->applyFromArray($style_center);
            $objget->getColumnDimension('B')->setWidth('5');
            
            $objset->setCellValue("C".$baris , "Nama KAM/AM");
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("C". $baris. ":C". $bm);
            $objget->getStyle('C5')->applyFromArray($style_center);
            $objget->getColumnDimension('C')->setWidth('40');
            
            $objset->setCellValue("D".$baris , "Distributor");
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("D". $baris. ":D". $bm);
            $objget->getStyle('D5')->applyFromArray($style_center);
            $objget->getColumnDimension('D')->setWidth('50');
            
            $objset->setCellValue("E".$baris , "Nilai KPI");
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("E". $baris. ":E". $bm);
            $objget->getStyle('E5')->applyFromArray($style_center);
            $objget->getColumnDimension('E')->setWidth('15');
            
            $objget->getStyle('B5:E6')->applyFromArray($style_bg);
            $objget->getStyle('B5:E6')->applyFromArray($style_center);
            $objget->getStyle('B5:E6')->getFont()->setBold(true);

            //Menampilkan Isi data

            $jml_data = count($data);
            $baris=7;
            for($i=0; $i<$jml_data; $i++){
                $objset->setCellValue("B". $baris, $data[$i][0]);
                $objset->setCellValue("C". $baris, $data[$i][1]);
                $objset->setCellValue("D". $baris, $data[$i][2]);
                $objset->setCellValue("E". $baris, $data[$i][3]);  
                $baris = $baris +1;              
            }
            
            // $jml_material   = count($data_material_plant);      
            // $batas_material = $jml_material-1;
            
            // // LIST MATERIAL =====================================================================
            // $jml_material   = count($data_material_plant);
            // $bris_material=7;
            // for($i=0; $i<=$jml_material; $i++){
            //     $objset->setCellValue("P". $bris_material, $data_material_plant[$i]['KD_MATERIAL']);
            //     $objset->setCellValue("Q". $bris_material, $data_material_plant[$i]['NM_MATERIAL']);
                
            //     $bris_material++;
            // }
            
            
            
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

            $filename = "Laporan KPI KAM/AM - ".date('Y/m/d H:i:s a').".xls";

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            ob_end_clean();
            ob_start();
            $objWriter->save('php://output');
        }


        public function listKamSales($bulan = null, $tahun = null){
            if($bulan < 10){
                $bulan = "0".$bulan;
            } else {
                $bulan = $bulan;
            }

        	$draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));

            $data = array();
            $kamSales = $this->mKamSales->listKamSales();
            if($kamSales){
                $i=1;
                foreach ($kamSales as $kamSalesKey => $kamSalesValue) {
                    // $nilaiKpi = 0;
                    $nilaiKpi = $this->detailKpiSales($kamSalesValue->ID_USER, $bulan, $tahun);
                    $data[] = array(
                        $i,
                        strtoupper($kamSalesValue->NAMA),
                        $kamSalesValue->NAMA_DISTRIBUTOR,
                        $nilaiKpi,
                        '<button class="btn btn-success" onClick="detailGrafikKpi('.$kamSalesValue->ID_USER.','.$bulan.','.$tahun.')">DETAIL GRAFIK</button>&nbsp;'.
                        // '<button class="btn btn-info" onClick="detailKpi('.$kamSalesValue->ID_USER.',2,2019)">DETAIL TABEL</button>'
                        '<button class="btn btn-info" onClick="detailKpi('.$kamSalesValue->ID_USER.','.$bulan.','.$tahun.')">DETAIL TABEL</button>'
                    );
                    $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($kamSales),
                "recordsFiltered" => count($kamSales),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

        function calculateDayMonth($month, $year) {
            error_reporting(0);
            $TotalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $DayCount = array();
            for ($i = 1; $i <= $TotalDays; $i++) {
                $DayOfWeek = date('l', mktime(0, 0, 0, $month, $i, $year));
                $DayCount[$DayOfWeek]++;
            }

            $hariKerja = $DayCount['Sunday'] + $DayCount['Saturday'] + $DayCount['Thursday'] + $DayCount['Friday'] + $DayCount['Monday'] + $DayCount['Tuesday'] + $DayCount['Wednesday'];
            return $hariKerja;
        }

        function calculateDays($day, $month, $year){
            error_reporting(0);
            if($month != date('m')){
                $day = date('t');
            }

            for ($i = 1; $i <= $day; $i++) {
                $DayOfWeek = date('l', mktime(0, 0, 0, $month, $i, $year));
                $DayCount[$DayOfWeek]++;
            }

            $hariKerja = $DayCount['Sunday'] +  $DayCount['Saturday'] + $DayCount['Thursday'] + $DayCount['Friday'] + $DayCount['Monday'] + $DayCount['Tuesday'] + $DayCount['Wednesday'];
            return $hariKerja;
        }

        public function detailKpi($bulan = null, $tahun = null){
            if(isset($bulan)){
                $bulan = $bulan;
            } else {
                $bulan = date('m');
            }

            if(isset($tahun)){
                $tahun = $tahun;
            } else {
                $tahun = date('Y');
            }
            
            if($bulan < 10){
                $bulan = str_replace("0", "", $bulan);
            }

            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));

            $idUser = $this->input->post("id_user");
            $level = $this->input->post("level");
            $getIdentitasUser = $this->mKpi->identitasUser($idUser);
            if($getIdentitasUser){
                $kodeDist = $getIdentitasUser->KODE_DISTRIBUTOR;
                $idRegion = $getIdentitasUser->ID_REGION;

                $tokoBaru = $this->mKpi->getTokoBaru($kodeDist, $bulan, $tahun);

                if($getIdentitasUser->ID_JENIS_USER == "1002"){
                    $idProvinsi = $getIdentitasUser->PROV_DIST;
                } else {
                    $idProvinsi = $getIdentitasUser->ID_PROVINSI;
                }

                if($getIdentitasUser->ID_JENIS_USER == "1003"){
                    $target = $this->mKpi->targetKpiSalesDistributor($idUser, $bulan, $tahun);
                    if($target){
                        $targetHarga = $target->TARGET_HARGA;
                    } else {
                        $targetHarga = 0;
                    }
                    
                    $tokoSales = $this->mKpi->getTokoSales($idUser);
                    if($tokoSales){
                        $realisasi = $this->mKpi->realisasiSales($tokoSales->ID_CUSTOMER, $bulan, $tahun);
                    }
                    if(!$target){
                        $data[] = array("-","-","-","-","-","-","-","-","");
                        $output = array(
                            "draw" => $draw,
                            "recordsTotal" => 1,
                            "recordsFiltered" => 1,
                            "data" => array()
                        );
                        echo json_encode($output);
                        exit();
                    }
                } else {
                    $target = $this->mKpi->targetVolumeHargaRevenueUser($kodeDist, $idProvinsi, $bulan, $tahun);
                    if($level == "distributor"){
                        $targetHarga = $target->TARGET_HARGA * (1.08);
                    } else {
                        $targetHarga = $target->TARGET_HARGA;
                    }

                    if($level == "distributor"){                        
                    	$realisasi = $this->mKpi->realisasiDataDistSidigi($kodeDist, $idProvinsi, $bulan, $tahun);
                    } else {
                    	$realisasi = $this->mKpi->realisasiVolumeHarhaRevenueUser($kodeDist, $idProvinsi, $bulan, $tahun);
                    }
                }
            }

            $getIndexKpi = $this->mKpi->indexKpiUser($idRegion, $bulan, $tahun);
			//**/
            $getTargetCustomer = $this->mKpi->targetCustomer($bulan, $tahun, $kodeDist);

            $targetKeep = $this->mKpi->targetKeep($bulan, $tahun, $kodeDist);
            $realisasiKeep = $this->mKpi->realisasiKeep($bulan, $tahun, $kodeDist);

            $targetGrowth = $this->mKpi->targetGrowth($bulan, $tahun, $kodeDist);
            $realisasiGrowth = $this->mKpi->realisasiGrowth($bulan, $tahun, $kodeDist);
			//**/
            if($getIdentitasUser->ID_JENIS_USER == "1002" || $getIdentitasUser->ID_JENIS_USER == "1007"){
                $idDistributor = $this->session->userdata("kode_dist");
                $kunjungan = $this->mKpi->rekapKunjunganDist($idDistributor, $bulan, $tahun);
            } else {
                $kunjungan = $this->mKpi->kpi_kunjungan($idUser, $idRegion, $bulan, $tahun);
            }

            $realisasiSo = $this->mKpi->realisasiSo($kodeDist, $bulan, $tahun);
            $listGudangDist = $this->mKpi->listGudangDist($kodeDist);

            $totalDayMonth = $this->calculateDayMonth($bulan, $tahun);
            $totalDayAktif = $this->calculateDays(date('d'), $bulan, $tahun);
            $prosentaseSdk = (((100 / $totalDayMonth) * $totalDayAktif)/100);
            
            $data[] = array(
                1,
                "Volume (Zak)",
                $getIndexKpi->VOLUME,
                number_format($target->TARGET_VOLUME),
                number_format(round($prosentaseSdk * $target->TARGET_VOLUME)),
                round($prosentaseSdk * 100)."%",
                number_format($realisasi->VOLUME),
                round(($realisasi->VOLUME / round($prosentaseSdk * $target->TARGET_VOLUME)) * 100)."%",
                round(($realisasi->VOLUME / round($prosentaseSdk * $target->TARGET_VOLUME)) * $getIndexKpi->VOLUME, 1)
            );

            $data[] = array(
                2,
                "Harga (Rupiah/Ton)",
                $getIndexKpi->HARGA,
                "Rp ".number_format($targetHarga),
                "Rp ".number_format($targetHarga),
                round(($targetHarga / $targetHarga) * 100, 1)."%",
                "Rp ".number_format($realisasi->HARGA),
                round(($realisasi->HARGA / $targetHarga) * 100)."%",
                round(($realisasi->HARGA / $targetHarga) * $getIndexKpi->HARGA, 1)
            );

            $data[] = array(
                3,
                "Revenue (Rupiah/Juta)",
                $getIndexKpi->REVENUE,
                "Rp ".number_format($target->TARGET_REVENUE / 1000000),
                "Rp ".number_format(round(($prosentaseSdk * $target->TARGET_REVENUE) / 1000000)),
                round($prosentaseSdk * 100)."%",
                "Rp ".number_format($realisasi->REVENUE / 1000000),
                round(($realisasi->REVENUE / round($prosentaseSdk * $target->TARGET_REVENUE)) * 100)."%",
                round(($realisasi->REVENUE / round($prosentaseSdk * $target->TARGET_REVENUE)) * $getIndexKpi->REVENUE, 1)
            );

            if($kunjungan){
                foreach ($kunjungan as $kunjunganKey => $kunjunganValue) {
                    if($getIdentitasUser->ID_JENIS_USER == "1003"){
                        $targetKunjungan = $kunjunganValue->TARGET_SALES_KUNJUNGAN;
                    } else if($getIdentitasUser->ID_JENIS_USER == "1002"){
                        $targetKunjungan = $kunjunganValue->TARGET_KUNJUNGAN;
                    } else {
                        $targetKunjungan = $kunjunganValue->TARGET_KUNJUNGAN;
                    }

                    $rencanaKunjungan = round($targetKunjungan / $totalDayMonth) * $totalDayAktif;
                    $realisasiKunjungan = $kunjunganValue->JUMLAH_REALISASI / $targetKunjungan; 
                    $data[] = array(
                        4,
                        "Kunjungan",
                        $kunjunganValue->INDEX_KUNJUNGAN,
                        $targetKunjungan,
                        round($prosentaseSdk * $targetKunjungan),
                        round($prosentaseSdk * 100)."%",
                        $kunjunganValue->JUMLAH_REALISASI,
                        round(($kunjunganValue->JUMLAH_REALISASI / round($prosentaseSdk * $targetKunjungan)) * 100)."%",
                        round(($kunjunganValue->JUMLAH_REALISASI / round($prosentaseSdk * $targetKunjungan)) * $kunjunganValue->INDEX_KUNJUNGAN, 1)
                    );
                }
            } else {
                $data[] = array("-","-","-","-","-","-","-","-","-");
            }

            //**/
            foreach($realisasiSo as $realisasiSoKey => $realisasiSoValue){
                $data[] = array(
                    8,
                    "Sales Order",
                    $getIndexKpi->SO_DO,
                    $realisasiSoValue->TOTAL,
                    round($prosentaseSdk * $realisasiSoValue->TOTAL),
                    round($prosentaseSdk * 100)."%",
                    $realisasiSoValue->REAL,
                    round($realisasiSoValue->REAL / round($prosentaseSdk * $realisasiSoValue->TOTAL) * 100)."%",
                    round($realisasiSoValue->REAL / round($prosentaseSdk * $realisasiSoValue->TOTAL) * $getIndexKpi->SO_DO, 1)
                );
            }
            //**/
			

            $data[] = array(
            	5,
            	"Get",
            	$getIndexKpi->GET,
            	$getTargetCustomer->TARGET_GET,
            	round($prosentaseSdk * $getTargetCustomer->TARGET_GET),
            	round($prosentaseSdk * 100)." %",
            	$tokoBaru->JML_TOKO_BARU,
            	round(($tokoBaru->JML_TOKO_BARU / round($prosentaseSdk * $getTargetCustomer->TARGET_GET)) * 100)."%",
            	round(($tokoBaru->JML_TOKO_BARU / round($prosentaseSdk * $getTargetCustomer->TARGET_GET)) * 10)
            );

            $data[] = array(
            	6,
            	"Keep",
            	$getIndexKpi->KEEP,
            	$targetKeep,
             	$targetKeep,
            	"100 %",
            	$realisasiKeep,
            	round(($realisasiKeep / $targetKeep) * 100)." %",
            	round(($realisasiKeep / $targetKeep) * $getIndexKpi->KEEP)
            );

            $data[] = array(
            	7,
            	"Growth",
            	$getIndexKpi->GROWTH,
            	$targetGrowth->PENJUALAN_TON,
            	round($prosentaseSdk * $targetGrowth->PENJUALAN_TON),
                round($prosentaseSdk * 100)."%",
            	$realisasiGrowth->PENJUALAN_TON,
            	round(((int)$realisasiGrowth->PENJUALAN_TON / round($prosentaseSdk * (int)$targetGrowth->PENJUALAN_TON)) * 100)." %",
            	round(((int)$realisasiGrowth->PENJUALAN_TON / (int)$targetGrowth->PENJUALAN_TON) * $getIndexKpi->GROWTH),
            );
			//**/
			
            $output = array(
                "draw" => $draw,
                "recordsTotal" => 4,
                "recordsFiltered" => 4,
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

        public function listIndexKpi($bulan = null, $tahun = null){
            $idJenisUser = $this->session->userdata("id_jenis_user");

            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));

            $data = array();
            if($idJenisUser == "1001"){
                $indexKpi = $this->mKpi->indexKpi($idJenisUser, null, $bulan, $tahun);
            } else if($idJenisUser == "1002" || $idJenisUser == "1007"){
                $kodeDist = $this->session->userdata("kode_dist");
                $indexKpi = $this->mKpi->indexKpi($idJenisUser, $kodeDist, $bulan, $tahun);
            }
            
            if($indexKpi){
                $i=1;
                foreach ($indexKpi as $indexKpiKey => $indexKpiValue) {
                    $name = ($idJenisUser == "1001" ? $indexKpiValue->REGION_NAME : $indexKpiValue->NAMA_DISTRIBUTOR);
                    $data[] = array(
                        $i,
                        $name,
                        $indexKpiValue->VOLUME,
                        $indexKpiValue->HARGA,
                        $indexKpiValue->REVENUE,
                        $indexKpiValue->KUNJUNGAN,
						//*
                        $indexKpiValue->KEEP,
                        $indexKpiValue->GET,
                        $indexKpiValue->GROWTH,
                        $indexKpiValue->SO_DO,
						//*
                        $indexKpiValue->TARGET_KUNJUNGAN
                    );
                    $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($indexKpi),
                "recordsFiltered" => count($indexKpi),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }

        public function tambahIndexKpi(){
            $idJenisUser = $this->session->userdata("id_jenis_user");
            $idRegion = $this->input->post("id_region");
            $kodeDist = $this->input->post("kode_dist");
            $bulan = $this->input->post("bulan");
            $tahun = $this->input->post("tahun");
            $volume = $this->input->post("volume");
            $harga = $this->input->post("harga");
            $revenue = $this->input->post("revenue");
            $kunjungan = $this->input->post("kunjungan");
            $keep = $this->input->post("keep");
            $get = $this->input->post("get");
            $growth = $this->input->post("growth");
            $so_do = $this->input->post("so_do");
            $targetKunjungan = $this->input->post("target_kunjungan");

            if($idJenisUser == '1001'){
                $dataIndex = array(
                    "BULAN" => $bulan,
                    "TAHUN" => $tahun,
                    "ID_JENIS_USER" => $idJenisUser,
                    "ID_REGION" => $idRegion,
                    "VOLUME" => $volume,
                    "HARGA" => $harga,
                    "REVENUE" => $revenue,
                    "KUNJUNGAN" => $kunjungan,
                    "KEEP" => $keep,
                    "GET" => $get,
                    "GROWTH" => $growth,
                    "SO_DO" => $so_do,
                    "TARGET_KUNJUNGAN" => $targetKunjungan,
                    "DELETE_MARK" => "0"
                );
                $checkIndex = $this->mKpi->checkIndex($idJenisUser, $idRegion, $bulan, $tahun);
            } else {
                $dataIndex = array(
                    "BULAN" => $bulan,
                    "TAHUN" => $tahun,
                    "ID_REGION" => $idRegion,
                    "ID_JENIS_USER" => $idJenisUser,
                    "KODE_DISTRIBUTOR" => $kodeDist,
                    "VOLUME" => $volume,
                    "HARGA" => $harga,
                    "REVENUE" => $revenue,
                    "KUNJUNGAN" => $kunjungan,
                    "KEEP" => $keep,
                    "GET" => $get,
                    "GROWTH" => $growth,
                    "SO_DO" => $so_do,
                    "TARGET_KUNJUNGAN" => $targetKunjungan,
                    "DELETE_MARK" => "0"
                );
                $checkIndex = $this->mKpi->checkIndex($idJenisUser, $kodeDist, $bulan, $tahun);
            }

            if($checkIndex){
                $idIndex = $checkIndex[0]->KPI_INDEX_ID;
                $updateIndex = $this->mKpi->updateIndex($dataIndex, $idIndex);
                if($updateIndex){
                    echo json_encode(array("status" => "success", "data" => $updateIndex));
                } else {
                    echo json_encode(array("status" => "error", "message" => "Pengubahan index gagal"));
                }
            } else {
                $insertIndex = $this->mKpi->tambahIndex($dataIndex);
                if($insertIndex){
                    echo json_encode(array("status" => "success", "data" => $insertIndex));
                } else {
                    echo json_encode(array("status" => "error", "message" => "Penambahan index gagal"));
                }
            }
        }

    }
?>