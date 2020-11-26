<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Repot_toko_noo extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Toko_noo_model');
    }

    public function index(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Toko_noo_model->User_distributor($id_user);
		
		$this->template->display('Toko_noo_view', $data);
    }
	
	function distributor_sales(){
        $id_dis = $this->input->post("id");
		$id_tso = $this->session->userdata('user_id');
        $data = $this->Toko_noo_model->get_sales($id_dis,$id_tso);
		
        echo json_encode($data);
    }
	
	
	public function getdata(){
		$tahun			= $this->input->post("tahun");
		$bulan			= $this->input->post("bulan");
		$id_distributor	= $this->input->post("id_distributor");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$id_user 		= $this->session->userdata('user_id');

		$datadistributor = $this->Toko_noo_model->User_dis($id_user);
		
		$fild = '';
		$n=1;
		foreach($datadistributor as $d){
			
			if(count($datadistributor)>$n){
				$fild .= "'". $d['KODE_DISTRIBUTOR']."',";
			}
			else {
				$fild .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;		
		}
		
		$kondisi = $datadistributor[0]['KODE_DISTRIBUTOR'];
		$kondisi1 = strlen($kondisi);
		
		if($kondisi1 == 10){
			$data = $this->Toko_noo_model->get_data_bk_smi($bulan , $tahun, $fild , $id_distributor);
		}else{
			$data = $this->Toko_noo_model->get_data_bk_sbi($bulan , $tahun, $fild , $id_distributor);
		}
		
		echo json_encode($data);
	}
	
	public function toExcelTSO(){
		$tahun			= $this->input->get("tahun");
		$bulan			= $this->input->get("bulan");
		$id_distributor	= $this->input->get("id");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$id_user 		= $this->session->userdata('user_id');

		$datadistributor = $this->Toko_noo_model->User_dis($id_user);
		$fild = '';
		$n=1;
		foreach($datadistributor as $d){
			
			if(count($datadistributor)>$n){
				$fild .= "'". $d['KODE_DISTRIBUTOR']."',";
			}
			else {
				$fild .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;		
		}
		
		$kondisi = $datadistributor[0]['KODE_DISTRIBUTOR'];
		$kondisi1 = strlen($kondisi);
		
		if($kondisi1 == 10){
			$hasil = $this->Toko_noo_model->get_data_bk_smi($bulan , $tahun, $fild , $id_distributor);
		}else{
			$hasil = $this->Toko_noo_model->get_data_bk_sbi($bulan , $tahun, $fild , $id_distributor);
		}
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Toko Noo');
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
		
		$filename = "Rekap_Data_Toko_NOO";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA TOKO NOO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA TOKO NOO");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:N2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "AKUISISI DATE");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "KD CUSTOMER");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "KD DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA PEMILIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "ALAMAT TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "KECAMATAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "DISTRIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "AREA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "NAMA PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "VOLUME PENJUALAN/TON");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "VOLUME PENJUALAN SP/TON");

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VolumeKey => $list_ValumeValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_ValumeValue['AKUISISI_DATE']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_ValumeValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_ValumeValue['NAMA_TOKO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_ValumeValue['NOMOR_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_ValumeValue['NM_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_ValumeValue['ALAMAT_TOKO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_ValumeValue['KECAMATAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_ValumeValue['PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_ValumeValue['AREA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_ValumeValue['NM_PRODUK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_ValumeValue['PENJUALAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_ValumeValue['PENJUALAN_SP']));

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