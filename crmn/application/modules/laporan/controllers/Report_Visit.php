<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Report_Visit extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Report_visit_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Report_visit_model->User_distributor($id_user);
		//$data['list_sales'] = $this->Report_visit_model->User_SALES($id_user);
		$this->template->display('Report_visit_view', $data);	
    }
	
	public function ListSalesDIS(){
		$id_user = $this->session->userdata('user_id');
        $id_dis  = $this->input->post('id_dis');

        $data = $this->Data_sales_model->User_SALES($id_user, $id_dis);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	
	

	
	public function DIS(){
	
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_sales'] = $this->Report_visit_model->Sales_Distributor($id_user);
		$this->template->display('Report_visit_distributor', $data);	
    }
	
	public function GSM(){
	
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Report_visit_model->GSM_dis($id_user);
		$data['list_rsm'] = $this->Report_visit_model->RSMlist($id_user);
		$this->template->display('Report_visit_gsm', $data);
		
    }
	public function SPC(){
	
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Report_visit_model->GSM_dis($id_user);
		$data['list_rsm'] = $this->Report_visit_model->RSMlist($id_user);
		$this->template->display('report_visit_spc', $data);
		
    }
    public function RSM(){
	
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Report_visit_model->RSM_dis($id_user);
		$data['list_asm'] = $this->Report_visit_model->listASM($id_user);
		$this->template->display('Report_visit_rsm', $data);
		
    }
    public function ASM(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Report_visit_model->ASM_dis($id_user);
		$data['list_tso'] = $this->Report_visit_model->User_TSO($id_user);
		$this->template->display('Report_visit_asm', $data);
		
    }
	
	public function filterdata(){
		$id_tso 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		$sales		 	= $this->input->post("sales");
		$kd_distributor = $this->input->post("kd_distributor");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Report_visit_model->get_data_filter_visit($id_tso,$bulan ,$tahun, $kd_distributor, $sales);
			
		echo json_encode($hasil);
	}
	
	public function filterdataasm(){
		$id_asm 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		$tso		 	= $this->input->post("tso");
		$kd_distributor = $this->input->post("kd_distributor");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Report_visit_model->get_data_filter_visit_asm($id_asm,$bulan ,$tahun, $kd_distributor, $tso);
			
		echo json_encode($hasil);
	}
	
	public function filterdatarsm(){
		$id_rsm 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		$asm		 	= $this->input->post("asm");
		$kd_distributor = $this->input->post("kd_distributor");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Report_visit_model->get_data_filter_visit_rsm($id_rsm,$bulan ,$tahun, $kd_distributor, $asm);
			
		echo json_encode($hasil);
	}
	
	public function filterdatagsm(){
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		$rsm		 	= $this->input->post("rsm");
		$id_dis		 	= $this->input->post("id_dis");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$rsmgsm = $this->Report_visit_model->RSM_GSM($id_user);
		$id_rsm = '';
		$c=1;
		foreach($rsmgsm as $s){
			if(count($rsmgsm)>$c){
				$id_rsm .= "'". $s['ID_RSM']."',";
			}
			else {
				$id_rsm .= "'". $s['ID_RSM']."'";
			}
			$c=$c+1;
		}
		
		if($id_rsm ==null){
			$id_rsm .= '0';
		}
		
		$hasil			= $this->Report_visit_model->get_data_filter_visit_grm($id_rsm,$bulan,$tahun, $rsm , $id_dis);
			
		echo json_encode($hasil);
	}
	public function filterdataspc(){
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$hasil			= $this->Report_visit_model->get_data_filter_visit_spcEXEL($id_user,$bulan,$tahun);
			
		echo json_encode($hasil);
	}
	
	public function filterdatadis(){
		$id_dis 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		$idsales		= $this->input->post("idsales");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Report_visit_model->get_data_filter_visit_dis($id_dis,$bulan ,$tahun, $idsales);
			
		echo json_encode($hasil);
	}
	
	
	public function toExcelTSO(){

		$id_tso 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		$sales		 	= $this->input->get("sales");
		$kd_distributor = $this->input->get("kd_distributor");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Report_visit_model->get_data_filter_visit_exel($id_tso,$bulan ,$tahun, $kd_distributor, $sales);
		
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
		$objPHPExcel->getActiveSheet()->mergeCells('A1:I2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "TAHUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "BULAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "TARGET");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "REALISASI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "UNPLAN VISIT");
		
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
		foreach ($hasil as $list_VisitKey => $list_VisitValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_VisitValue['ID_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_VisitValue['NAMA_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_VisitValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_VisitValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_VisitValue['TAHUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_VisitValue['BULAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_VisitValue['HARI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_VisitValue['TARGET']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_VisitValue['REALISASI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_VisitValue['UNPLAN_TARGET']));

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
	
	public function toExcelASM(){

		$id_asm 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		$tso		 	= $this->input->get("tso");
		$kd_distributor = $this->input->get("kd_distributor");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Report_visit_model->get_data_filter_visit_asm($id_asm,$bulan ,$tahun, $kd_distributor, $tso);
		
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
		$objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA SO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "TAHUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "BULAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "TARGET");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "REALISASI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "UNPLAN VISIT");

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VisitKey => $list_VisitValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_VisitValue['ID_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_VisitValue['NAMA_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_VisitValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_VisitValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_VisitValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_VisitValue['TAHUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_VisitValue['BULAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_VisitValue['HARI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_VisitValue['TARGET']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_VisitValue['REALISASI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_VisitValue['UNPLAN_TARGET']));

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

		$id_rsm 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		$asm		 	= $this->input->get("asm");
		$kd_distributor = $this->input->get("kd_distributor");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Report_visit_model->get_data_filter_visit_rsm($id_rsm,$bulan ,$tahun, $kd_distributor, $asm);
		
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
		$objPHPExcel->getActiveSheet()->mergeCells('A1:K2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA SO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA SM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "TAHUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "BULAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "TARGET");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "REALISASI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "UNPLAN VISIT");

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VisitKey => $list_VisitValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_VisitValue['ID_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_VisitValue['NAMA_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_VisitValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_VisitValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_VisitValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_VisitValue['NAMA_SM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_VisitValue['TAHUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_VisitValue['BULAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_VisitValue['HARI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_VisitValue['TARGET']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_VisitValue['REALISASI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_VisitValue['UNPLAN_TARGET']));

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
	
	public function toExcelGSM(){

		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		$rsm		 	= $this->input->get("rsm");
		$id_dis		 	= $this->input->get("id_dis");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$rsmgsm = $this->Report_visit_model->RSM_GSM($id_user);
		$id_rsm = '';
		$c=1;
		foreach($rsmgsm as $s){
			if(count($rsmgsm)>$c){
				$id_rsm .= "'". $s['ID_RSM']."',";
			}
			else {
				$id_rsm .= "'". $s['ID_RSM']."'";
			}
			$c=$c+1;
		}
		
		if($id_rsm ==null){
			$id_rsm .= '0';
		}
		
		$hasil			= $this->Report_visit_model->get_data_filter_visit_grm($id_rsm,$bulan,$tahun, $rsm , $id_dis);
		
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
		$objPHPExcel->getActiveSheet()->mergeCells('A1:K2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA SO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA SM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "TAHUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "BULAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "TARGET");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "REALISASI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "UNPLAN VISIT");

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VisitKey => $list_VisitValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_VisitValue['ID_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_VisitValue['NAMA_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_VisitValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_VisitValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_VisitValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_VisitValue['NAMA_SM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_VisitValue['TAHUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_VisitValue['BULAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_VisitValue['HARI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_VisitValue['TARGET']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_VisitValue['REALISASI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_VisitValue['UNPLAN_TARGET']));

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
	
	public function toExcelSPC(){

		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$hasil			= $this->Report_visit_model->get_data_filter_visit_spcEXEL($id_user,$bulan,$tahun);
		
		//print_r($hasil);
		
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
		$objPHPExcel->getActiveSheet()->mergeCells('A1:K2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA SO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA SM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "TAHUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "BULAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "TARGET");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "REALISASI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "UNPLAN VISIT");

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VisitKey => $list_VisitValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_VisitValue['ID_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_VisitValue['NAMA_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_VisitValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_VisitValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_VisitValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_VisitValue['NAMA_SM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_VisitValue['TAHUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_VisitValue['BULAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_VisitValue['HARI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_VisitValue['TARGET']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_VisitValue['REALISASI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_VisitValue['UNPLAN_TARGET']));

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

		$id_dis 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		$idsales		= $this->input->get("sales");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
			
		$hasil			= $this->Report_visit_model->get_data_filter_visit_dis($id_dis,$bulan ,$tahun, $idsales);
		
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
		$objPHPExcel->getActiveSheet()->mergeCells('A1:I2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "TAHUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "BULAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "TARGET");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "REALISASI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "UNPLAN VISIT");
		
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
		foreach ($hasil as $list_VisitKey => $list_VisitValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_VisitValue['ID_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_VisitValue['NAMA_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_VisitValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_VisitValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_VisitValue['TAHUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_VisitValue['BULAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_VisitValue['HARI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_VisitValue['TARGET']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_VisitValue['REALISASI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_VisitValue['UNPLAN_TARGET']));

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