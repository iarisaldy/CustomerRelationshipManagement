<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Sales_Tahunan extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Sales_Tahunan_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_sales'] = $this->Sales_Tahunan_model->User_SALES($id_user);
		
		$this->template->display('Sales_Tahunan_view', $data);
		
    }
	
	function toko_sales_tso(){
        $id_sales = $this->input->post("id");
        $data = $this->Sales_Tahunan_model->Toko_sales($id_sales);
		
        echo json_encode($data);
    }
	
	public function tampildata(){
		$idsales		= $this->input->post("idsales");
		$USER 			= $this->session->userdata('user_id');
		$hasil			= $this->Sales_Tahunan_model->get_data($idsales,$USER);
		
		echo json_encode($hasil);
	}
	
	public function Ajax_data_id()
	{
		$nojadwal	 	= $this->input->post("nojadwal");
		$hasil			= $this->Sales_Tahunan_model->get_jadwal($nojadwal);
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_tambah_data()
	{
		$USER 		= $this->session->userdata('user_id');
		$idsales 	= $this->input->post("idsales");
		$idcustomer = $this->input->post("idcus");
		$dis 		= $this->input->post("dis");
		$sun 		= $this->input->post("sun");
		$mon 		= $this->input->post("mon");
		$tue 		= $this->input->post("tue");
		$wed 		= $this->input->post("wed");
		$thu 		= $this->input->post("thu");
		$fri 		= $this->input->post("fri");
		$sat 		= $this->input->post("sat");
		$w1 		= $this->input->post("w1");
		$w2 		= $this->input->post("w2");
		$w3 		= $this->input->post("w3");
		$w4 		= $this->input->post("w4");
		$w5 		= $this->input->post("w5");
		
		$hasil = $this->Sales_Tahunan_model->insert_data($idsales,$idcustomer,$dis,$sun,$mon,$tue,$wed,$thu,$fri,$sat,$w1,$w2,$w3,$w4,$w5, $USER);
    	echo json_encode($hasil);
	}
	
	public function Ajax_simpan_edit()
	{	
		$USER 		= $this->session->userdata('user_id');
		$no			= $this->input->post("no");
		$sun 		= $this->input->post("sun");
		$mon 		= $this->input->post("mon");
		$tue 		= $this->input->post("tue");
		$wed 		= $this->input->post("wed");
		$thu 		= $this->input->post("thu");
		$fri 		= $this->input->post("fri");
		$sat 		= $this->input->post("sat");
		$w1 		= $this->input->post("w1");
		$w2 		= $this->input->post("w2");
		$w3 		= $this->input->post("w3");
		$w4 		= $this->input->post("w4");
		$w5 		= $this->input->post("w5");
		
		$hasil = $this->Sales_Tahunan_model->update_data($no,$sun,$mon,$tue,$wed,$thu,$fri,$sat,$w1,$w2,$w3,$w4,$w5, $USER);
		echo json_encode($hasil);
	}
	
	public function Ajax_hapus_data()
	{	
		$no			= $this->input->post("no");
		$USER 		= $this->session->userdata('user_id');
		
		$hasil = $this->Sales_Tahunan_model->hapus_data($no, $USER);
		echo json_encode($hasil);
	}
	public function toExcel(){
		$idsales		= $this->input->get("idsales");
		$USER 			= $this->session->userdata('user_id');
		$hasil			= $this->Sales_Tahunan_model->get_data($idsales,$USER);
		
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data VISIT PLAN');
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
		
		$filename = "Rekap_Data_Visit_Plan";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA VISIT PLAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA VISIT PLAN");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:O2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "SUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "MON");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "TUE");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "WED");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "THU");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "FRI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "SAT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "WEEK 1");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "WEEK 2");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "WEEK 3");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "WEEK 4");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "WEEK 5");

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
		foreach ($hasil as $list_PlanKey => $list_PlanValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_PlanValue['NAMA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_PlanValue['NAMA_TOKO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_PlanValue['ID_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_PlanValue['SUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_PlanValue['MON']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_PlanValue['TUE']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_PlanValue['WED']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_PlanValue['THU']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_PlanValue['FRI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_PlanValue['SAT']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_PlanValue['W1']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_PlanValue['W2']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_PlanValue['W3']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_PlanValue['W4']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, strtoupper($list_PlanValue['W5']));

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