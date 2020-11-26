<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Report_toko_sales extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Toko_sales_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$this->template->display('Toko_sales_view', $data);
		
    }
	
	public function DIS(){
	
		$data = array("title"=>"Dashboard CRM Administrator");
		$this->template->display('Toko_sales_DIS', $data);	
    }
	
	public function ASM(){
	
		$data = array("title"=>"Dashboard CRM Administrator");
		$this->template->display('Toko_sales_ASM', $data);	
    }
	
	public function RSM(){
	
		$data = array("title"=>"Dashboard CRM Administrator");
		$this->template->display('Toko_sales_RSM', $data);	
    }
	
	public function Admin(){
	
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Toko_sales_model->Get_region_all();
		$data['list_provinsi'] = $this->Toko_sales_model->Get_provinsi_all();
		$data['list_area'] = $this->Toko_sales_model->Get_area_all();
		$this->template->display('Toko_sales_Admin', $data);	
    }
	
	public function Get_Data(){
		$id_tso 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Toko_sales_model->get_data($id_tso,$bulan ,$tahun);
			
		echo json_encode($hasil);
	}
	
	public function Get_Data_DIS(){
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		
			
		$hasil			= $this->Toko_sales_model->get_data_dis($id_user, $bulan, $tahun);

		echo json_encode($hasil);
	}
	
	public function Get_Data_ASM(){
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$kode_tso		= $this->Toko_sales_model->User_TSO($id_user);
		$id_tso = '';
		$c=1;
		foreach($kode_tso as $tso){
			if(count($kode_tso)>$c){
				$id_tso .= "'". $tso['ID_TSO']."',";
			}
			else {
				$id_tso .= "'". $tso['ID_TSO']."'";
			}
			$c=$c+1;
		}
			
		$hasil			= $this->Toko_sales_model->get_data_asm($id_user,$bulan ,$tahun);

		echo json_encode($hasil);
	}
	
	public function Get_Data_RSM(){
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
			
		$hasil			= $this->Toko_sales_model->get_data_rsm($id_user,$bulan ,$tahun);

		echo json_encode($hasil);
	}
	
	public function Get_Data_Admin(){
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		$region		 	= $this->input->post("region");
		$id_prov		= $this->input->post("id_prov");
		$id_area		= $this->input->post("id_area");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Toko_sales_model->get_data_admin($bulan ,$tahun,$region,$id_prov,$id_area);
			
		echo json_encode($hasil);
	}
	
	
	public function toExcelTSO(){

		$id_tso 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			=	$this->Toko_sales_model->get_data($id_tso,$bulan ,$tahun);
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data STATUS KUNJUNGAN TOKO');
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
		
		$filename = "Rekap_STATUS_KUNJUNGAN_TOKO";
		$objPHPExcel->getActiveSheet(0)->setTitle("STATUS KUNJUNGAN TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA STATUS KUNJUNGAN TOKO");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:I2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "KD CUSTOMER");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA AREA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA DISTRIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "NAMA KECAMATAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "JUMLAH DIKUNJUNGI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "STATUS");

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_TokoKey => $list_TokoValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_TokoValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_TokoValue['NAMA_TOKO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_TokoValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_TokoValue['NAMA_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_TokoValue['NAMA_AREA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_TokoValue['NAMA_DISTRIK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_TokoValue['NAMA_KECAMATAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_TokoValue['JML_TOKO_DIKUNJUNGI_BULANAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_TokoValue['STATUS']));

			$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$numRow)->applyFromArray($style_row);

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
	
	public function toExcelDIS(){

		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		
			
		$hasil			= $this->Toko_sales_model->get_data_dis($id_user, $bulan, $tahun);
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Toko Sales');
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
		
		$filename = "Rekap_Data_Toko_Sales";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA TOKO SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA TOKO SALES");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:I2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "KD CUSTOMER");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA AREA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA DISTRIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "NAMA KECAMATAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "JUMLAH DIKUNJUNGI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "STATUS");

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_TokoKey => $list_TokoValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_TokoValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_TokoValue['NAMA_TOKO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_TokoValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_TokoValue['NAMA_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_TokoValue['NAMA_AREA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_TokoValue['NAMA_DISTRIK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_TokoValue['NAMA_KECAMATAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_TokoValue['JML_TOKO_DIKUNJUNGI_BULANAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_TokoValue['STATUS']));

			$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$numRow)->applyFromArray($style_row);

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
	
	public function toExcelASM(){

		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$kode_tso		= $this->Toko_sales_model->User_TSO($id_user);
		$id_tso = '';
		$c=1;
		foreach($kode_tso as $tso){
			if(count($kode_tso)>$c){
				$id_tso .= "'". $tso['ID_TSO']."',";
			}
			else {
				$id_tso .= "'". $tso['ID_TSO']."'";
			}
			$c=$c+1;
		}
			
		$hasil	= $this->Toko_sales_model->get_data_asm($id_user,$bulan ,$tahun);
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Toko Sales');
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
		
		$filename = "Rekap_Data_Toko_Sales";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA TOKO SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA TOKO SALES");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:I2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "KD CUSTOMER");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA AREA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA DISTRIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "NAMA KECAMATAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "JUMLAH DIKUNJUNGI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "STATUS");

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_TokoKey => $list_TokoValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_TokoValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_TokoValue['NAMA_TOKO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_TokoValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_TokoValue['NAMA_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_TokoValue['NAMA_AREA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_TokoValue['NAMA_DISTRIK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_TokoValue['NAMA_KECAMATAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_TokoValue['JML_TOKO_DIKUNJUNGI_BULANAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_TokoValue['STATUS']));

			$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$numRow)->applyFromArray($style_row);

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
	
	public function toExcelRSM(){

		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
			
		$hasil			= $this->Toko_sales_model->get_data_rsm($id_user,$bulan ,$tahun);
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Toko Sales');
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
		
		$filename = "Rekap_Data_Toko_Sales";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA TOKO SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA TOKO SALES");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:I2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "KD CUSTOMER");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA AREA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA DISTRIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "NAMA KECAMATAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "JUMLAH DIKUNJUNGI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "STATUS");

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_TokoKey => $list_TokoValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_TokoValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_TokoValue['NAMA_TOKO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_TokoValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_TokoValue['NAMA_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_TokoValue['NAMA_AREA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_TokoValue['NAMA_DISTRIK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_TokoValue['NAMA_KECAMATAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_TokoValue['JML_TOKO_DIKUNJUNGI_BULANAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_TokoValue['STATUS']));

			$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$numRow)->applyFromArray($style_row);

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
	
	public function toExcelAdmin(){

		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		$region		 	= $this->input->get("region");
		$id_prov		= $this->input->get("id_prov");
		$id_area		= $this->input->get("id_area");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$hasil			= $this->Toko_sales_model->get_data_admin($bulan, $tahun, $region, $id_prov, $id_area);
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Toko Sales');
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
		
		$filename = "Rekap_Data_Toko_Sales";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA TOKO SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA TOKO SALES");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "KD CUSTOMER");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "REGION");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA AREA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "NAMA DISTRIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "NAMA KECAMATAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "JUMLAH DIKUNJUNGI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "STATUS");

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_TokoKey => $list_TokoValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_TokoValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_TokoValue['NAMA_TOKO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_TokoValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_TokoValue['NEW_REGION']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_TokoValue['NAMA_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_TokoValue['NAMA_AREA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_TokoValue['NAMA_DISTRIK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_TokoValue['NAMA_KECAMATAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_TokoValue['JML_TOKO_DIKUNJUNGI_BULANAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_TokoValue['STATUS']));

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