<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class Laporan_penugasan extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Laporan_penugasan_model","LPM");
        }
        
        public function index(){
            $data = array("title"=>"Dashboard CRM Administrator");

            $id_user                    = $this->session->userdata('user_id');
			$dist 						= $this->LPM->userCheckingDist($id_user);
			
			
			$kd_dist 					= $dist->KODE_DISTRIBUTOR;
			$this->session->set_userdata('kd_dist', $kd_dist);
            $data['list_sales']         = $this->LPM->listSales($id_user);
            $this->template->display('Laporan_penugasan_view', $data);
        }
		
		public function listCanvassing(){
            $data = array();
            $id_user  = $this->session->userdata('user_id');
            
			$dist 				= $this->LPM->userCheckingDist($id_user);
			$kd_distributor 	= $dist->KODE_DISTRIBUTOR;
			$salesDistributor = $this->input->post("sales_distributor");
            $startDate = $this->input->post("start_date");
            $endDate = $this->input->post("end_date");
           

            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));

            $routingCanvasing = $this->LPM->List_kunjungan_sales($startDate, $endDate, $kd_distributor, $salesDistributor);

            if($routingCanvasing){
                $i = 1;
                foreach ($routingCanvasing as $routingCanvasingKey => $routingCanvasingValue) {
                    // echo $i."=".$routingCanvasingValue->CHECKOUT_TIME."<br/>";
                    if($routingCanvasingValue->CHECKIN_TIME != NULL){
                        if($routingCanvasingValue->CHECKOUT_TIME == ""){ 
                            $notif = "<span class='label label-info'>Belum Checkout</span>";
                            $button = "<center><a href=".base_url('sales/RoutingCanvasing/detail')."/".$routingCanvasingValue->ID_KUNJUNGAN_CUSTOMER." class='btn btn-sm btn-info'><i class='fa fa-info'></i> Detail</a></center>";
                        } else {
                            $notif = "<span class='label label-success'>Dikunjungi</span>";
                            $button = "<center><a href=".base_url('sales/RoutingCanvasing/detail')."/".$routingCanvasingValue->ID_KUNJUNGAN_CUSTOMER." class='btn btn-sm btn-info'><i class='fa fa-info'></i> Detail</a></center>";
                        }
                    } else {
                        $startDate  = new DateTime($routingCanvasingValue->TGL_RENCANA_KUNJUNGAN);
                        $endDate    = new DateTime(date('Y-m-d'));
                        $interval   = $startDate->diff($endDate);
						
                        if($interval->days >= 3){
                            $notif  = "<span class='label label-danger'>Kunjungan Tidak Dikunjungi > 3 Hari</span>"; 
                        } else {
                            $notif  = "<span class='label label-warning'>Belum Dikunjungi</span>";   
                        }

                        $button = "<center>
                            
                            </center>";
                        
                    }
                    $waktu_kunjungan = (intval($routingCanvasingValue->JAM)* 60) + intval($routingCanvasingValue->MENIT);
                    $data[]  = array(
                        $i,
                        
                        $routingCanvasingValue->NAMA_DISTRIBUTOR,
						strtoupper($routingCanvasingValue->NAMA_USER),
                        strtoupper($routingCanvasingValue->NAMA_TOKO),
                        $routingCanvasingValue->TGL_RENCANA_KUNJUNGAN,
                        $routingCanvasingValue->CHECKIN_TIME,
                        $waktu_kunjungan,
                        $notif,
                        strtoupper(str_replace("lain-lain ,", "", $routingCanvasingValue->KETERANGAN)),
                        $button
                    );
                $i++;
                }
            } else {
                $data[] = array("-","-","-","-","-","-","-","-","-","-","-");
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => count($routingCanvasing),
                "recordsFiltered" => count($routingCanvasing),
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }
		
		public function toExcel(){
			$dist 				= $this->LPM->userCheckingDist($id_user);
			$kd_distributor 	= $dist->KODE_DISTRIBUTOR;
			$sales = $this->input->get("sales");
			$startDate = $this->input->get("startDate");
			$endDate = $this->input->get("endDate");
			
			if($sales == "null"){
				$sales = null;
			}
			
			$routingCanvasing = $this->LPM->List_kunjungan_sales($startDate, $endDate, $kd_distributor, $sales);
			
			$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Laporan Kunjungan Harian Sales');
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
			
			$filename = "Rekap_Laporan_Kunjungan_Harian_Sales_".$startDate."_-_".$endDate;
            $objPHPExcel->getActiveSheet(0)->setTitle("Laporan Kunjungan Sales");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Rekap Laporan Kunjungan Harian Sales");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:I2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "SURVEYOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "CUSTOMER/TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "RENCANA KUNJUNGAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "TANGGAL KUNJUNGAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "DURASI KUNJUNGAN (Menit)");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "STATUS");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "KETERANGAN");
			
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
            foreach ($routingCanvasing as $routingCanvasingKey => $routingCanvasingValue) {
				
				$waktu_kunjungan = (intval($routingCanvasingValue->JAM)* 60) + intval($routingCanvasingValue->MENIT);
                $notif = "";
				
					if($routingCanvasingValue->CHECKIN_TIME != NULL){
                        if($routingCanvasingValue->CHECKOUT_TIME == ""){ 
                            $notif = "Belum Checkout";
                        } else {
                            $notif = "Dikunjungi";
                        }
                    } else {
                        $startDate  = new DateTime($routingCanvasingValue->TGL_RENCANA_KUNJUNGAN);
                        $endDate    = new DateTime(date('Y-m-d'));
                        $interval   = $startDate->diff($endDate);
						
                        if($interval->days >= 3){
                            $notif  = "Kunjungan Tidak Dikunjungi > 3 Hari"; 
                        } else {
                            $notif  = "Belum Dikunjungi";   
                        }
                    }
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $no);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($routingCanvasingValue->NAMA_DISTRIBUTOR));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($routingCanvasingValue->NAMA_USER));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($routingCanvasingValue->NAMA_TOKO));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, $routingCanvasingValue->TGL_RENCANA_KUNJUNGAN);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, $routingCanvasingValue->CHECKIN_TIME);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, $waktu_kunjungan);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, $notif);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper(str_replace("lain-lain ,", "", $routingCanvasingValue->KETERANGAN)));

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
		
	}