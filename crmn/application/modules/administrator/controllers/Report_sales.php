<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Report_Sales extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Report_sales_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sales_model->Get_region_all();
		//$data['list_provinsi'] = $this->Report_sales_model->Get_provinsi_all();
		$this->template->display('Report_sales_view', $data);
		
    }
	
	public function filterdata(){
	$tahun		 	= $this->input->post("tahun");
    $bulan			= $this->input->post("bulan");
	$region		 	= $this->input->post("region");
    $id_prov		= $this->input->post("id_prov");
	
	if($bulan<10){
		$bulan= '0'. $bulan;
	}
	
	$hasil			= $this->Report_sales_model->get_data_filter_visit($tahun, $bulan, $region, $id_prov);
	echo json_encode($hasil);
	
	}
	
	public function ListProvinsi(){
        $id_region    = $this->input->post('id_region');
		
        $data = $this->Report_sales_model->Get_provinsi_all($id_region);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	public function toExcel(){
	$tahun		 	= $this->input->get("tahun");
    $bulan			= $this->input->get("bulan");
	$region		 	= $this->input->get("region");
    $id_prov		= $this->input->get("id_prov");
	
	if($bulan<10){
		$bulan= '0'. $bulan;
	}
	
	//$hasil			= $this->Report_sales_model->get_data_filter_visit_exel($tahun, $bulan, $region, $id_prov);	
	$hasil			= $this->Report_sales_model->get_data_filter_visit($tahun, $bulan, $region, $id_prov);	
	$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Visit Sales');
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
	
	$filename = "Rekap_Data_Visit_Sales";
	$objPHPExcel->getActiveSheet(0)->setTitle("DATA VISIT SALES");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA VISIT SALES");
	$objPHPExcel->getActiveSheet()->mergeCells('A1:N2');
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "KODE DISTRIBUTOR");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA DISTRIBUTOR");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "REGION");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "PROVINSI");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "NAMA SO");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "NAMA SM");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "NAMA SSM");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "TAHUN");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "BULAN");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "TANGGAL");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "TARGET");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "REALISASI");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "UNPLAN VISIT");

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

	
	$no = 1;
	$numRow = 4;
	foreach ($hasil as $list_VisitKey => $list_VisitValue) {
				
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_VisitValue['ID_SALES']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_VisitValue['NAMA_SALES']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_VisitValue['KODE_DISTRIBUTOR']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_VisitValue['NAMA_DISTRIBUTOR']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_VisitValue['REGION_ID']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_VisitValue['NAMA_PROVINSI']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_VisitValue['NAMA_SO']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_VisitValue['NAMA_SM']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_VisitValue['NAMA_SSM']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_VisitValue['TAHUN']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_VisitValue['BULAN']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_VisitValue['HARI']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_VisitValue['TARGET']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_VisitValue['REALISASI']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, strtoupper($list_VisitValue['UNPLAN_TARGET']));

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