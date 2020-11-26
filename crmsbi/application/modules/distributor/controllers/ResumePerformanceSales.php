<?php
	/**
	 * 
	 */
	class ResumePerformanceSales extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->load->model("Model_PerformanceSales", "mPerformanceSales");
			
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
            $this->load->library('PHPExcel');
		}

		public function index(){
			$data = array("title"=>"Dashboard CRM Administrator");
            $this->template->display('ResumePerformanceSales_view', $data);
		}

		public function canvasingPerformance(){
			$bulan = $this->input->post("bulan");
			$tahun = $this->input->post("tahun");

			$draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));

			$canvasingPerformance = $this->mPerformanceSales->canvasingPerformance($bulan, $tahun);
			if($canvasingPerformance){
				$i=1;
				foreach ($canvasingPerformance as $key => $value) {
					$data[] = array(
						$i,
						strtoupper($value->NAMA),
						strtoupper($value->NAMA_DIST),
						$value->JML_KUNJUNGAN,
						"<center><button id='detailSales' data-iduser='".$value->ID_USER."' data-nama='".$value->NAMA."' class='btn btn-sm btn-info'><i class='fa fa-info'></i> Detail</button></center>"
					);
					$i++;
				}
			} else {
				 $data[] = array("-","-","-","-");
			}

			$output = array(
                "draw" => $draw,
                "recordsTotal" => count($canvasingPerformance),
                "recordsFiltered" => count($canvasingPerformance),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}

		public function countSunday($bulan = null, $tahun = null){
			$startDate = $tahun."-".$bulan."-01";
			$endDate = $tahun."-".$bulan."-d";

	    	$begin = new DateTime(date($startDate));
	    	$end = new DateTime(date($endDate));
	    	$day = 0;
	    	while ($begin <= $end){
	    		if($begin->format("D") == "Sun"){
	    			$day++;
	    		}
	    		$begin->modify('+1 day');
	    	}

	    	return $day;
	    }

		public function kunjunganHarian($idUser = null, $bulan = null, $tahun = null){
			if($bulan < 10){
				$bulan = "0".$bulan;
			} else {
				$bulan = $bulan;
			}
			
	    	$data = array();

	    	$begin = new DateTime(date(''.$tahun.'-'.$bulan.'-1'));
			$finish = new DateTime(date(''.$tahun.'-'.$bulan.'-t', strtotime($tahun."-".$bulan."-01")));
			$end = $finish->modify( '+1 day' ); 
			$interval = new DateInterval('P1D');
			$period = new DatePeriod($begin, $interval ,$end);
			
			$kunjunganHarian = $this->mPerformanceSales->kunjunganHarian($idUser, $bulan, $tahun);
			$totalKunjungan = $this->mPerformanceSales->totalKunjungan($idUser, $bulan, $tahun);
			if($kunjunganHarian){
				foreach ($period as $key) {
					$loopDate = date_format($key, 'd');
					$data["label"] = $loopDate;
					$data["value"] = 0;
					foreach ($kunjunganHarian as $kunjunganKey => $kunjunganValue) {
						if($loopDate == $kunjunganValue->TGL){
							$data["value"] = $kunjunganValue->TOTAL;
						}
					}
					$json[] = $data;
				}
			} else {
				foreach ($period as $key) {
					$loopDate = date_format($key, 'd');
					$data["label"] = $loopDate;
					$data["value"] = 0;
					$json[] = $data;
				}
			}

			$tglBulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
			$sunday = $this->countSunday($bulan, $tahun);
			$date = $tglBulan - $sunday;

			$trend = array("line" => array(array("startvalue" => round($totalKunjungan->TOTAL / $date), "color" => "#29C3BE", "thickness" => "2", "dashed" => "1", "dashLen" => "4", "dashGap" => "2")));

			echo json_encode(array("status" => "success", "data" => $json, "trendlines" => array($trend)));
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
			$canvasingPerformance = $this->mPerformanceSales->canvasingPerformance($bulan, $tahun);
			if($canvasingPerformance){
				$i=1;
				foreach ($canvasingPerformance as $key => $value) {
					$data[] = array(
						$i,
						strtoupper($value->NAMA),
						strtoupper($value->NAMA_DIST),
						$value->JML_KUNJUNGAN
					);
					$i++;
				}
			} else {
				 $data[] = array("-","-","-","-");
			}
			
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

            $objDrawing->setCoordinates('B1');
            $objDrawing->setHeight(130);
            $objDrawing->setWidth(50);

            $objDrawing->setResizeProportional(true);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

            $objget->getStyle('B1:F2')->applyFromArray($style_center);
            
            $objset->setCellValue('A1', "");
            $objget->getStyle('A1')->applyFromArray($style_bgformat);

            $objset->setCellValue('B1', "Laporan Sales Resume Performance (Bulan: "+$bulan+" Tahun: "+$tahun+")");
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:H2');
            $objget->getStyle('B1')->getFont()->setSize(18);
            $objget->getStyle('B1')->getFont()->setBold(true);
            $objget->getRowDimension('1')->setRowHeight(18);
			
			// TITLE LIST =====================================================================      
            $baris = 5;
            $bm    = $baris+1;
            $objset->setCellValue("B".$baris , "No");
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("B". $baris. ":B". $bm);
            $objget->getStyle('B5')->applyFromArray($style_center);
            $objget->getColumnDimension('B')->setWidth('5');
            
            $objset->setCellValue("C".$baris , "Nama Sales");
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("C". $baris. ":C". $bm);
            $objget->getStyle('C5')->applyFromArray($style_center);
            $objget->getColumnDimension('C')->setWidth('40');
            
            $objset->setCellValue("D".$baris , "Distributor");
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("D". $baris. ":D". $bm);
            $objget->getStyle('D5')->applyFromArray($style_center);
            $objget->getColumnDimension('D')->setWidth('50');
            
            $objset->setCellValue("E".$baris , "Total Kunjungan");
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
			
			$objPHPExcel->getActiveSheet()->setTitle('Sheet1');

            $filename = "Laporan Sales Resume Performance - ".date('Y-m-d H:i:s a').".xls";
			
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="apa_saja.xls"'); //tell browser what's the file name ' . $filename . '
            header('Cache-Control: max-age=0'); //no cache

            ob_end_clean();
            ob_start();
            $objWriter->save('php://output');
        }
	}
?>