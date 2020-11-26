<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class Mapping_customer extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->model("Mapping_customer_model","MCM");
			set_time_limit(0);
        }
		
		public function index(){
			$data = array("title"=>"Customer Mapping");
			$id_user       = $this->session->userdata('user_id');
			$jenis_user    = $this->session->userdata('id_jenis_user');
			
			//admin = 1009, rsm = 1010, asm = 1011, tso = 1012
			
			if($jenis_user == 1009){
				$this->template->display('Mapping_customer_admin_new_view', $data);
			} else if($jenis_user == 1010){
				$this->template->display('Mapping_customer_rsm_view', $data);
			} else if($jenis_user == 1011){
				$this->template->display('Mapping_customer_asm_view', $data);
			} else if($jenis_user == 1012){
				$this->template->display('Mapping_customer_tso_view', $data);
			}
			
		}
		
		public function Hirarki(){
			$data = array("title"=>"Customer Mapping");
			$id_user       = $this->session->userdata('user_id');
			$jenis_user    = $this->session->userdata('id_jenis_user');
			
			if($jenis_user == 1009){
				$this->template->display('Mapping_customer_admin_view', $data);
			} else {
				$this->load->helper('url');
				redirect(site_url().'sbi/Mapping_customer', 'refresh');
			}
		}
		
		public function List_rsm(){
			$data = array();
			
			$list_rsm = $this->MCM->List_rsm();
			if($list_rsm){
				foreach ($list_rsm as $list_rsmKey => $list_rsmVal) {
					$data[]  = array(
						$list_rsmVal->ID_RSM,
						$list_rsmVal->NAMA_RSM
					);
				}
			} else {
                $data[] = array("","");
            }
			
			$output = array(
                "recordsTotal" => count($list_rsm),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
		public function List_asm(){
			$data = array();
			$id_rsm = $this->input->post("rsm");
			$list_asm = $this->MCM->List_asm($id_rsm);
			if($list_asm){
				foreach ($list_asm as $list_asmKey => $list_asmVal) {
					$data[]  = array(
						$list_asmVal->ID_ASM,
						$list_asmVal->NAMA_ASM
					);
				}
			} else {
                $data[] = array("","");
            }
			
			$output = array(
                "recordsTotal" => count($list_asm),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
		public function List_tso(){
			$data = array();
			$id_rsm = $this->input->post("rsm");
			$id_asm = $this->input->post("asm");
			$list_tso = $this->MCM->List_tso($id_rsm, $id_asm);
			if($list_tso){
				foreach ($list_tso as $list_tsoKey => $list_tsoVal) {
					$data[]  = array(
						$list_tsoVal->ID_TSO,
						$list_tsoVal->NAMA_TSO
					);
				}
			} else {
                $data[] = array("","");
            }
			
			$output = array(
                "recordsTotal" => count($list_tso),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
		public function List_sales(){
			$data = array();
			$id_rsm = $this->input->post("rsm");
			$id_asm = $this->input->post("asm");
			$id_tso = $this->input->post("tso");
			
			$list_sales = $this->MCM->List_sales($id_rsm, $id_asm, $id_tso);
			if($list_sales){
				foreach ($list_sales as $list_salesKey => $list_salesVal) {
					$data[]  = array(
						$list_salesVal->ID_USER,
						$list_salesVal->NAMA
					);
				}
			} else {
                $data[] = array("","");
            }
			
			$output = array(
                "recordsTotal" => count($list_sales),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
		public function List_mapping(){
			$data = array();
			$id_user  = $this->session->userdata('user_id');
			
			$rsm = $this->input->post("rsm");
			$asm = $this->input->post("asm");
			$tso = $this->input->post("tso");
			$sales = $this->input->post("sales");
			
			// $rsm = null;
			// $asm = null;
			// $tso = null;
			// $sales = null;
			 
			$list_mapping = $this->MCM->List_customer_mapping($rsm, $asm, $tso, $sales);
			
			//print_r($list_mapping); 
			//exit;
			// KEC. ".$list_mappingVal->NAMA_KECAMATAN." -
			/*
				KODE_DISTRIBUTOR, 
				NAMA_DISTRIBUTOR,
				KD_CUSTOMER,
				NAMA_TOKO,
				ALAMAT,
				NAMA_DISTRIK,
				ID_SALES,
				NAMA_SALES,
				NAMA_TSO,
				NAMA_ASM,
				NAMA_RSM
			*/
			
			if($list_mapping > 0){
				$unmapping = 0;
				$i = 1;
                foreach ($list_mapping as $list_mappingKey => $list_mappingVal) {
					$alamat = ucfirst($list_mappingVal->ALAMAT." - ".$list_mappingVal->NAMA_DISTRIK);
					$data[]  = array(
                        $i,
                        $list_mappingVal->KD_CUSTOMER,
						strtoupper($list_mappingVal->NAMA_TOKO),
						$alamat,
						strtoupper($list_mappingVal->NAMA_DISTRIBUTOR),
						strtoupper($list_mappingVal->NAMA_SALES),
						strtoupper($list_mappingVal->NAMA_TSO),
						strtoupper($list_mappingVal->NAMA_ASM),
						strtoupper($list_mappingVal->NAMA_RSM),
						strtoupper($list_mappingVal->NAMA_GSM),
						strtoupper($list_mappingVal->CREATE_DATE)
                    );
					$i++;
					if($list_mappingVal->ID_SALES == null){
						$unmapping++;
					}
                } 
            } else {
                $data[] = array("-","-","-","-","-","-","-","-","-","-","-");
            }
			
			$output = array(
                "recordsTotal" => count($list_mapping),
				"unmapping" => $unmapping,
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
		//List Filter
		
		public function List_region(){
			$data = array();
				
			$list = $this->MCM->getRegion();
			if($list){
				foreach ($list as $list_Key => $list_Val) {
					$region = "REGIONAL ".$list_Val->REGION;
					$data[]  = array(
						$list_Val->ID_REGION,
						$region
					);
				}
			} else {
				$data[] = array("","");
			}
			
			$output = array(
				"recordsTotal" => count($list),
				"data" => $data
			);
			echo json_encode($output);
			exit();
		}
		
		public function List_provinsi(){
			$data = array();
				
			$list = $this->MCM->getProvinsi();
			if($list){
				foreach ($list as $list_Key => $list_Val) {
					$data[]  = array(
						$list_Val->ID_PROVINSI,
						$list_Val->NAMA_PROVINSI
					);
				}
			} else {
				$data[] = array("","");
			}
			
			$output = array(
				"recordsTotal" => count($list),
				"data" => $data
			);
			echo json_encode($output);
			exit();
		}
		
		public function List_area(){
			$data = array();
				
			$list = $this->MCM->getArea();
			if($list){
				foreach ($list as $list_Key => $list_Val) {
					$data[]  = array(
						$list_Val->ID_AREA,
						$list_Val->NAMA_AREA
					);
				}
			} else {
				$data[] = array("","");
			}
			
			$output = array(
				"recordsTotal" => count($list),
				"data" => $data
			);
			echo json_encode($output);
			exit();
		}
		
		public function List_distributor(){
			$data = array();
				
			$list = $this->MCM->getDistributor();
			if($list){
				foreach ($list as $list_Key => $list_Val) {
					$data[]  = array(
						$list_Val->KODE_DISTRIBUTOR,
						$list_Val->NAMA_DISTRIBUTOR
					);
				}
			} else {
				$data[] = array("","");
			}
			
			$output = array(
				"recordsTotal" => count($list),
				"data" => $data
			);
			echo json_encode($output);
			exit();
		}
		
		public function TampilData(){
			//$id_prov = $this->input->post("provinsi");
			$By = explode("-",$_POST["By"]);
			$Set = explode("-",$_POST["Set"]);
			$filterBy = $By[0]; 
			$filterSet = $Set[0];
			$hasil = $this->MCM->getDataMapping($filterBy, $filterSet); 

			$output = array(
				"recordsTotal" => count($hasil),
				"data" => $hasil
			);
			
			echo json_encode($output);
		}
		
		public function to_Excel_point(){
			$By = explode("-",$_GET["by"]);
			$Set = explode("-",$_GET["set"]);
			$filterBy = $By[0]; 
			$filterSet = $Set[0];
			
			if($By == "0-ALL"){
				$Set[1] = "ALL";
			} 
			
			$hasil = $this->MCM->getDataMapping($filterBy, $filterSet); 
			
			// print_r($hasil);
			// exit();
			
			$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Mapping Customer');
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
			
		$filename = "Rekap_Data_Mapping_Customer";
            $objPHPExcel->getActiveSheet(0)->setTitle("DATA MAPPING CUSTOMER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP MAPPING CUSTOMER [By:  ".$By[1]." - Set:  ".$Set[1]."]");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:N2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "KODE CUSTOMER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "ALAMAT");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "SALES");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "SO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "SM");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "SSM");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "GSM");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "CREATE AT");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "DISTRIK");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "PROVINSIN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "REGION");

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
            foreach ($hasil as $list_hasilKey => $list_SalesValue) {
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $no);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_SalesValue['KD_CUSTOMER']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_SalesValue['NAMA_TOKO']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_SalesValue['ALAMAT']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_SalesValue['NAMA_DISTRIBUTOR']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_SalesValue['NAMA_SALES']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_SalesValue['NAMA_TSO']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_SalesValue['NAMA_ASM']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_SalesValue['NAMA_RSM']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_SalesValue['NAMA_GSM']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_SalesValue['CREATE_DATE']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_SalesValue['NAMA_DISTRIK']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_SalesValue['NAMA_PROVINSI']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_SalesValue['NEW_REGION']));

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