<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once APPPATH . 'controllers/api/v1/Auth.php';

class Export extends CI_Controller {

	function __construct(){
		parent::__construct();
        $this->load->model('Model_customer');
        $this->load->model('Model_city');
		// $this->validate();
    }

    public function excel($kd_city){
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("MINI CRM")->setTitle("Semen Indonesia");

        $objset = $objPHPExcel->setActiveSheetIndex(0);
        $objget = $objPHPExcel->getActiveSheet();
        $objget->setTitle('Data Customer');

        $style_center = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
            )
        );

        // data yang di tampilkan
        $objset->setCellValue('A1', 'CUSTOMER ID');
        $objget->getStyle('A1')->applyFromArray($style_center);
        $objset->setCellValue('B1', 'KODE CUSTOMER');
        $objget->getStyle('B1')->applyFromArray($style_center);
        $objset->setCellValue('C1', 'NAMA TOKO');
        $objget->getStyle('C1')->applyFromArray($style_center);
        $objset->setCellValue('D1', 'NAMA PEMILIK');
        $objget->getStyle('D1')->applyFromArray($style_center);
        $objset->setCellValue('E1', 'PROVINSI');
        $objget->getStyle('E1')->applyFromArray($style_center);
        $objset->setCellValue('F1', 'KOTA');
        $objget->getStyle('F1')->applyFromArray($style_center);
        $objset->setCellValue('G1', 'KECAMATAN');
        $objget->getStyle('G1')->applyFromArray($style_center);
        $objset->setCellValue('H1', 'AREA');
        $objget->getStyle('H1')->applyFromArray($style_center);
        $objset->setCellValue('I1', 'ALAMAT');
        $objget->getStyle('I1')->applyFromArray($style_center);
        $objget->getColumnDimension('A')->setAutoSize($style_center);
        $objget->getColumnDimension('B')->setAutoSize($style_center);
        $objget->getColumnDimension('C')->setAutoSize($style_center);
        $objget->getColumnDimension('D')->setAutoSize($style_center);
        $objget->getColumnDimension('E')->setAutoSize($style_center);
        $objget->getColumnDimension('F')->setAutoSize($style_center);
        $objget->getColumnDimension('G')->setAutoSize($style_center);
        $objget->getColumnDimension('H')->setAutoSize($style_center);
        $objget->getColumnDimension('I')->setAutoSize($style_center);
        $baris = 2;
        $no = 1;

        $customer = $this->Model_customer->export($kd_city);
        $check_city = $this->Model_city->detail_city($kd_city);
        foreach ($customer as $key => $value) {
            $objset->setCellValue("A".$baris, $value->CUSTOMER_ID);
            $objset->setCellValue("B".$baris, $value->KD_CUSTOMER);
            $objset->setCellValue("C".$baris, $value->NM_TOKO);
            $objset->setCellValue("D".$baris, $value->NM_OWNER);
            $objset->setCellValue("E".$baris, $value->NM_REGION);
            $objset->setCellValue("F".$baris, $value->NM_CITY);
            $objset->setCellValue("G".$baris, $value->NM_DISTRICT);
            $objset->setCellValue("H".$baris, $value->NM_AREA);
            $objset->setCellValue("I".$baris, $value->ALAMAT_TOKO);
            $baris++;
            $no++;
        }
        // data yang di tampilkan

        $objPHPExcel->getActiveSheet()->setTitle('Data Customer');
        $objPHPExcel->setActiveSheetIndex(0);  
        $filename = urlencode("Data_Customer-".$check_city->NM_CITY."-".date('Ymd').".xls");

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header("Pragma: no-cache");

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');     
        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
    }

}
