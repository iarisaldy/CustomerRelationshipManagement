<?php
	class ExportExcel extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Model_ExportExcel", "mExportExcel");
		}

		public function toko(){
            $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
            $objPHPExcel = new PHPExcel();

            $jenis = $this->input->get("jenis");
			$status = $this->input->get("status");
			$distrik = $this->input->get("distrik");

            $cluster = $this->input->get("cluster");
            $provinsi = $this->input->get("provinsi");
            $bulan = $this->input->get("bulan");
            $tahun = $this->input->get("tahun");

            $idJenisUser = $this->session->userdata("id_jenis_user");

            if($jenis == "aktif"){
                $filename = "Daftar_Toko_".$status." _Kecamatan_".$distrik;
                $objPHPExcel->getActiveSheet(0)->setTitle("Toko Aktif_Non");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DAFTAR TOKO ".$status." KECAMATAN ".$distrik);
                
                if($idJenisUser == "1002" || $idJenisUser == "1007"){
                    $kodeDist = $this->session->userdata("kode_dist");
                    $toko = $this->mExportExcel->dataToko($status, $distrik, $kodeDist);
                } else {
                    $toko = $this->mExportExcel->dataToko($status, $distrik);
                }
            } else if($jenis == "cluster"){
                $toko = $this->mExportExcel->clusterToko(trim($cluster), $provinsi, $bulan, $distrik, $tahun);

                if(isset($distrik)){
                    $filename = "Daftar_Toko_".trim($cluster);
                    $objPHPExcel->getActiveSheet(0)->setTitle("Toko ".$cluster);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DAFTAR TOKO ".$cluster." BULAN ".$bulan);
                } else {
                    $filename = "Daftar_Toko_".trim($cluster)." _Kecamatan_".$distrik;
                    $objPHPExcel->getActiveSheet(0)->setTitle("Toko ".$cluster);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DAFTAR TOKO ".$cluster." KECAMATAN ".$distrik." BULAN ".$bulan);
                }
            }

            $objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Daftar Toko Distributor');
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

            $objPHPExcel->getActiveSheet()->mergeCells('A1:H2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA PEMILIK");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "KECAMATAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "ALAMAT");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "TIPE TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "NAMA LT");

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);

            $no = 1;
            $numRow = 4;
            foreach ($toko as $tokoKey => $tokoValue) {
            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $no);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, $tokoValue->NAMA_TOKO);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, $tokoValue->NAMA_DISTRIBUTOR);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, $tokoValue->NAMA_PEMILIK);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, $tokoValue->KECAMATAN);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, $tokoValue->ALAMAT);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, $tokoValue->GROUP_CUSTOMER);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, $tokoValue->LT);

                $objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$numRow)->applyFromArray($style_row);

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