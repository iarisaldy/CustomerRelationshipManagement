<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class ReportSurveySales extends CI_Controller {
	
    function __construct(){
        parent::__construct();
		
		$this->load->model('Model_report_survey_sales','MRSS');
		//$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel'));
    }
	
	public function index(){
		$data = array("title"=>"Dashboard CRM");
		
		$id_user       = $this->session->userdata('user_id');
		$jenis_user    = $this->session->userdata('id_jenis_user');
			
		//admin = 1009, gsm = 1016, rsm = 1010, asm = 1011, tso = 1012
		$this->template->display('ReportSurveySales_view', $data);
	}
	
	public function detail($no_visit){
		$data = array("title"=>"Dashboard CRM");
		
		$data['survei'] =  $this->MRSS->getDetailSurvei($no_visit); 
		$data['foto'] = $this->MRSS->List_foto($no_visit);
		$data['jp'] = $this->MRSS->Distinct_jenis_penilaian($no_visit);
		//$data['penilaian'] = $this->MRSS->List_penilaian($no_visit);
		
        $this->template->display('SurveySalesDetail_view', $data);
	}
	
	// --> FOR DATA LIST JS FUNCTION
	
		public function List_dt_select(){
			$request = $this->input->post("dt_set_in");
			$data = array();
			
			$list_dt = $this->MRSS->List_setDt_select($request);
			
			if($list_dt){
				foreach ($list_dt as $list_Key => $list_Val) {
					$data[]  = array(
						$list_Val->ID,
						$list_Val->NAMA
					);
				}
			} else {
                //$data[] = array("","");
            }
			
			$output = array(
                "recordsTotal" => count($list_dt),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
		public function TampilData(){
			$data = array();
			
			$By  = explode("-",$_POST["by"]);
			$Set = explode("-",$_POST["set"]);
			$filterBy 	= $By[0]; 
			$filterSet 	= $Set[0];
			$tahun 		= $_POST["tahun"];
			
			$hasil = $this->MRSS->getDataSurvei($filterBy, $filterSet, $tahun); 

			$output = array(
				"recordsTotal" => count($hasil),
				"data" => $hasil
			);
			
			echo json_encode($output);
			 
		}
	
	public function to_excel_survey(){
		$By  = explode("-",$_GET["by"]);
		$Set = explode("-",$_GET["set"]);
		$filterBy 	= $By[0]; 
		$filterSet 	= $Set[0];
		$tahun 		= $_GET["tahun"];
			
		$hasil = $this->MRSS->getDataSurvei($filterBy, $filterSet, $tahun); 
		
		if(count($hasil) == 0){
			print_r("Data Tidak Tersedia.");
			exit();
		}
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Supervisor Visit TSO');
            $objSet = $objPHPExcel->setActiveSheetIndex(0);
            $objGet = $objPHPExcel->getActiveSheet();
            $objPHPExcel->setActiveSheetIndex(0);
            $style_col = array(
                'font' => array('bold' => true),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
                'borders' => array(
                    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
                )
            );

            $style_row = array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
                'borders' => array(
                    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
                )
            );
			
		$filename = "Rekap_Data_Supervisor_Visit";
            $objPHPExcel->getActiveSheet(0)->setTitle("Data Supervisor Visit");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP SUPERVISOR VISIT [By:  ".$By[1]." - Set:  ".$Set[1]." - Tahun: ".$tahun." ]");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:Z2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO_VISIT");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "TGL_KUNJUNGAN_TSO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "ID_SO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "ID_SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA_SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "KODE_DISTRIBUTOR");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "NAMA_DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "ID_TOKO");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "NAMA_TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "TELP_TOKO");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "NAMA_PEMILIK");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "ALAMAT");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "NAMA_KECAMATAN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "NAMA_DISTRIK");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "NAMA_PROVINSI");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "NAMA_AREA");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "REGION");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "POINT_PEROLEHAN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', "POINT_MAX");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', "NILAI");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U3', "KESIMPULAN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V3', "NAMA_SO");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W3', "NAMA_SM");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X3', "NAMA_SSM");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y3', "NAMA_GSM");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z3', "ID_KUNJUNGAN_SALES");
			

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);

            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('U3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('V3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('W3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('X3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('Y3')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('Z3')->applyFromArray($style_col);
			
			$no = 1;
            $numRow = 4;
            foreach ($hasil as $list_hasilKey => $list_SalesValue) {
				
				$nilaiSales = ($list_SalesValue->POINT_PEROLEHAN / $list_SalesValue->POINT_MAX) * 100;
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_SalesValue->NO_VISIT));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_SalesValue->TGL_KUNJUNGAN_TSO));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_SalesValue->ID_SO));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_SalesValue->ID_SALES));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_SalesValue->NAMA_SALES));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$numRow, strtoupper($list_SalesValue->KODE_DISTRIBUTOR), PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_SalesValue->NAMA_DISTRIBUTOR));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_SalesValue->ID_TOKO));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_SalesValue->NAMA_TOKO));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_SalesValue->TELP_TOKO));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_SalesValue->NAMA_PEMILIK));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_SalesValue->ALAMAT));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_SalesValue->NAMA_KECAMATAN));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_SalesValue->NAMA_DISTRIK));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, strtoupper($list_SalesValue->NAMA_PROVINSI));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, strtoupper($list_SalesValue->NAMA_AREA));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numRow, strtoupper($list_SalesValue->REGION));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numRow, strtoupper($list_SalesValue->POINT_PEROLEHAN));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numRow, strtoupper($list_SalesValue->POINT_MAX));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numRow, number_format($nilaiSales,2));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$numRow, strtoupper($list_SalesValue->KESIMPULAN));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$numRow, strtoupper($list_SalesValue->NAMA_SO));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$numRow, strtoupper($list_SalesValue->NAMA_SM));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$numRow, strtoupper($list_SalesValue->NAMA_SSM));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$numRow, strtoupper($list_SalesValue->NAMA_GSM));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$numRow, strtoupper($list_SalesValue->ID_KUNJUNGAN_SALES));

                $objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('K'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('M'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('O'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('P'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('R'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('S'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('U'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('V'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('X'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('Y'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('Z'.$numRow)->applyFromArray($style_row);
				
                $no++;
                $numRow++;
            }
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '".xls');
            header('Cache-Control: max-age=0');
            header("Pragma: no-cache");

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $reader = PHPExcel_IOFactory::createReader('Excel5');

            ob_end_clean();
            ob_start();
            $objWriter->save('php://output');
		
	}
	
}

?>