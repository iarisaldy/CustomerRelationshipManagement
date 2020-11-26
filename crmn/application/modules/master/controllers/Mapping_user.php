<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Mapping_user extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Mapping_user_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_user'] = $this->Mapping_user_model->Get_user_all();
		$data['list_distributor'] = $this->Mapping_user_model->Get_dis_all();
		$data['list_karyawan'] = $this->Mapping_user_model->Get_karyawan_all();
		$data['list_provinsi'] = $this->Mapping_user_model->Get_prov_all();
		$data['list_region'] = $this->Mapping_user_model->Get_region_all();
	
		$this->template->display('Mapping_user_view', $data);
		
    }
	
	public function Ajax_option_value()
	{
		$id_dis 	= $this->input->post("id");
		$hasil 		= $this->Mapping_user_model->Get_user_sales_dis($id_dis);
		
		echo json_encode($hasil);
	}
	
	public function Ajax_tampil_data()
	{
		$id_dis 	= $this->input->post("id");
		$id_region 	= $this->input->post("region");
		$id_prov 	= $this->input->post("prov");
		$hasil 		= $this->Mapping_user_model->get_data($id_dis,$id_region,$id_prov);
		
		echo json_encode($hasil);
	}
	
	public function Ajax_data_id()
	{
		$id_edit 	= $this->input->post("id");
		$hasil 		= $this->Mapping_user_model->get_data_id($id_edit);
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_tambah_data()
	{
		$USER 			= $this->session->userdata('user_id');
		$id_user		= $this->input->post("id_user");
		$id_kar			= $this->input->post("id_kar");
		
		$this->Mapping_user_model->insert_data($id_user,$id_kar,$USER);
	}
	
	public function Ajax_simpan_edit()
	{	
		$USER 			= $this->session->userdata('user_id');
		$id_edit		= $this->input->post("id");
		$id_kar			= $this->input->post("id_kar");
		$id_user		= $this->input->post("id_user");
		
		$this->Mapping_user_model->update_data($id_edit, $id_kar, $id_user, $USER);
	}
	
	public function Ajax_hapus_data()
	{
    	$USER 			= $this->session->userdata('user_id');
		$id_hapus 		= $this->input->post("id");
		
		$this->Mapping_user_model->hapus_data($id_hapus, $USER);
	}
	
	public function toExcel(){
		$hasil 		= $this->Mapping_user_model->get_data();
		
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
		
		$filename = "Rekap_Data_Mapping_User";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA MAPPING USER");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA MAPPING USER");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO KARYAWAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA KARYAWAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "ID USER");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA");

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_PlanKey => $list_PlanValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_PlanValue['NO_KARYAWAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_PlanValue['NAMA_KARYAWAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_PlanValue['ID_USER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_PlanValue['NAMA']));

			$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);

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