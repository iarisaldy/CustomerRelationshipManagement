<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Master_karyawan extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Master_karyawan_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_distributor'] = $this->Master_karyawan_model->Get_dis_all();
		
		$this->template->display('Master_karyawan_view', $data);
		
    }
	
	public function Ajax_tampil_data()
	{
		$id_dis 	= $this->input->post("id");
		$hasil 		= $this->Master_karyawan_model->get_data($id_dis);
		
		echo json_encode($hasil);
	}
	
	public function Ajax_data_id()
	{
		$id_edit 	= $this->input->post("id");
		$hasil 		= $this->Master_karyawan_model->get_data_id($id_edit);
		
		echo json_encode(array('notify' => 1, 'html' => $hasil));
	}
	
	public function Ajax_tambah_data()
	{
		$USER 			= $this->session->userdata('user_id');
		$id_dis			= $this->input->post("id");
		$nama			= $this->input->post("nama");
		$alamat			= $this->input->post("alamat");
		$telp			= $this->input->post("telp");
		$imail			= $this->input->post("imail");
		
		$this->Master_karyawan_model->insert_data($nama,$alamat,$telp,$imail,$id_dis,$USER);
	}
	
	public function Ajax_simpan_edit()
	{	
		$USER 			= $this->session->userdata('user_id');
		$id_edit		= $this->input->post("id");
		$id_dis			= $this->input->post("id_dis");
		$nama			= $this->input->post("nama");
		$alamat			= $this->input->post("alamat");
		$telp			= $this->input->post("telp");
		$imail			= $this->input->post("imail");
		
		$this->Master_karyawan_model->update_data($id_edit, $nama,$alamat,$telp,$imail,$id_dis, $USER);
	}
	
	public function Ajax_hapus_data()
	{
    	$USER 			= $this->session->userdata('user_id');
		$id_hapus 		= $this->input->post("id");
		
		$this->Master_karyawan_model->hapus_data($id_hapus, $USER);
	}
	
	public function toExcel(){
		
		$id_dis 	= $this->input->get("id");
		$hasil 		= $this->Master_karyawan_model->get_data($id_dis);
		
		
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
		
		$filename = "Rekap_Data_Karyawan";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA KARYAWAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA KARYAWAN");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:F2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NAMA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "ALAMAT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NO TELP");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "EMAIL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA DISTRIBUTOR");

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_PlanKey => $list_PlanValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_PlanValue['NAMA_KARYAWAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_PlanValue['ALAMAT']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_PlanValue['NO_HP']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_PlanValue['EMAIL']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_PlanValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_PlanValue['NAMA_DISTRIBUTOR']));

			$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numRow)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numRow)->applyFromArray($style_row);

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