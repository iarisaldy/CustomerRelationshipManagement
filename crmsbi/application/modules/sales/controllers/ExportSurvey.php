<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
    class ExportSurvey extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Model_ExportSurvey", "mExportSurvey");
        }

        public function canvassing(){
            $idJenisUser = $this->session->userdata("id_jenis_user");
            $idPosisi = $this->input->get("posisi");
            $distributor = $this->input->get("dist");
            $provinsi = $this->input->get("prov");
            $startDate = $this->input->get("start");
            $endDate = $this->input->get("end");
            $sales = $this->input->get("sales");

            if($idJenisUser == "1001"){
                $canvassing = $this->mExportSurvey->listCanvasing($idPosisi, $distributor, $provinsi, $startDate, $endDate);
            } else if($idJenisUser == "1002" || $idJenisUser == "1007"){
                $kodeDist = $this->session->userdata("kode_dist");
                $canvassing = $this->mExportSurvey->listCanvasing($idPosisi, $kodeDist, $provinsi, $startDate, $endDate, $sales);
            } else if($idJenisUser == "1005"){
                $kodeDist = $this->session->userdata("kode_dist");
                $canvassing = $this->mExportSurvey->listCanvasing($idPosisi, $kodeDist, $provinsi, $startDate, $endDate);
            }

            $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Daftar Kunjungan Pelanggan');
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

            $filename = "Rekap_Kunjungan_Pelanggan";
            $objPHPExcel->getActiveSheet(0)->setTitle("Kunjungan Pelanggan");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DAFTAR KUNJUNGAN PELANGGAN");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:M2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "SURVEYOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "POSISI");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "CUSTOMER / TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "PROVINSI");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "KOTA");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "KECAMATAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "RENCANA KUNJUNGAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "TANGGAL CHECKIN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "DURASI KUNJUNGAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "TUJUAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "PEMBERI TUGAS");

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

            $no = 1;
            $numRow = 4;
            foreach ($canvassing as $canvassingKey => $canvassingValue) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $no);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, $canvassingValue->NAMA);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, $canvassingValue->JENIS_USER);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, $canvassingValue->NAMA_DISTRIBUTOR);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, $canvassingValue->NAMA_TOKO);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, $canvassingValue->NAMA_PROVINSI);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, $canvassingValue->NAMA_KOTA);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, $canvassingValue->NAMA_KECAMATAN);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, $canvassingValue->TGL_RENCANA_KUNJUNGAN);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, $canvassingValue->CHECKIN_TIME);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, round($canvassingValue->SELISIH, 2));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, $canvassingValue->KETERANGAN);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, $canvassingValue->NAMA_ASSIGN);

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