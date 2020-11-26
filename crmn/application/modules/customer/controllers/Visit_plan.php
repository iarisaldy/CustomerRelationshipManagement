<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Visit_plan extends CI_Controller {

	private $filename = "TEMPLATE_UPLOADS_VISIT_PLAN_SALES"; 	// menententukan nama file'
	
    function __construct(){
        parent::__construct();
		
		$this->load->model('Visit_plan_model');
		$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel'));
		
		set_time_limit(0);
		ini_set('memory_limit','1024M');
		
    }
	
	public function index(){
		$data = array("title"=>"Dashboard CRM");
		
			if(isset($_POST['preview'])){ 
				$upload = $this->upload_file($this->filename);
				
				
				if($upload['result'] == "success"){ 
					//include APPPATH.'third_party/PHPExcel/PHPExcel.php';
					$excelreader = new PHPExcel_Reader_Excel2007();
					$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); 
					$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
						
					$data['sheet'] = $sheet; 
						
				} else { 
					$data['upload_error'] = $upload['error']; 
				}
			}
		
        $this->template->display('Visit_plan_upload_view', $data);
	}
	
		private function upload_file($filename){
			$this->load->library('upload'); // Load librari upload
			
			$config['upload_path'] = './excel/';
			$config['allowed_types'] = 'xlsx';
			$config['max_size']	= '2048';
			$config['overwrite'] = true;
			$config['file_name'] = $filename;
		
			$this->upload->initialize($config); // Load konfigurasi uploadnya
			if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
				// Jika berhasil :
				$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
				return $return;
			}else{
				// Jika gagal :
				$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
				return $return;
			}
		}
		
		public function import(){
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			$date = date('d-m-Y H:i:s');
			//Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
			$data = array();
			$baris_data_in = 0;
			$data_sukses = 0;
			$data_fail = 0;
			$numrow = 1;
			foreach($sheet as $row){
				// Cek $numrow apakah lebih dari 1
				/*
										$ID_SALES 			= $row['A']; // Ambil data id sales
										$USERNAME 			= $row['B']; // Ambil data
										$ID_TOKO_BK 		= $row['C']; // Ambil data
										$NAMA_TOKO 			= $row['D']; // Ambil data 
										$KODE_DISTRIBUTOR 	= $row['E']; 
										$SUN = $row['F']; 
										$MON = $row['G']; 
										$TUE = $row['H'];
										$WED = $row['I']; 
										$THU = $row['J'];
										$FRI = $row['K']; 
										$SAT = $row['L'];
										$WEEK_1 = $row['M']; 
										$WEEK_2 = $row['N'];
										$WEEK_3 = $row['O']; 
										$WEEK_4 = $row['P'];
										$WEEK_5 = $row['Q'];
				*/
				if($row['A'] == "" && $row['B'] == "" && $row['C'] == "" && $row['D'] == "" && $row['E'] == "" && $row['F'] == "" && $row['G'] == "" && $row['H'] == "" && $row['I'] == "" && $row['J'] == "" && $row['K'] == "" && $row['L'] == "" && $row['M'] == "" && $row['N'] == "" && $row['O'] == "" && $row['P'] == "" && $row['Q'] == ""){
				continue;
				} else {
					$baris_data_in++;
				}
				
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport
				if($numrow > 1){
					// Panggil fungsi yg telah di buat di model
					$insert = $this->Visit_plan_model->visit_plan_batch($row['A'], $row['C'], $row['E'], $row['F'], $row['G'], $row['H'], $row['I'], $row['J'], $row['K'], $row['L'], $row['M'], $row['N'], $row['O'], $row['P'], $row['Q']);
					$data_sukses++;
				}
				$numrow++; // Tambah 1 setiap kali looping
			}
			$data_fail = $baris_data_in-$data_sukses-1;
			$this->session->set_userdata("after_import", true);
			$this->session->set_userdata("baris_data", $baris_data_in-1);
			$this->session->set_userdata("data_sukses", $data_sukses);
			$this->session->set_userdata("data_fail", $data_fail);

			redirect(site_url('customer/Visit_plan'));
		}
	
	public function List_sd(){
		$id_jenis_user = 1015;
		$hasil = $this->Visit_plan_model->get_user_sales($id_jenis_user);
		echo json_encode($hasil);
	}
	
	public function List_toko(){
		$id_sales 	= $this->input->post("id_sales"); 
		$hasil = $this->Visit_plan_model->get_toko_sales($id_sales);
		echo json_encode($hasil);
	}
	
		public function Export_mapping_toko($id_sales, $nameFile){
			
			$nameFile = urldecode($nameFile);
			
			$getData = $this->Visit_plan_model->get_toko_sales($id_sales);
			
			$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator('Admin-CRM-Semen-Indonesia')->setTitle('Rekap Daftar Mapping Customer');
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
			
			$filename = $nameFile;
            $objPHPExcel->getActiveSheet(0)->setTitle('Daftar Toko Sales');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $nameFile);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:F2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "ID CUSTOMER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "ID DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "KET");

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
			$keterangan= ''; 
            $numRow = 4;
            foreach ($getData as $list_mappingKey => $list_mappingValue) {
				
				$keterangan = $list_mappingValue->NAMA_KECAMATAN.' - '.$list_mappingValue->NM_KOTA.' - '.$list_mappingValue->NAMA_PROVINSI.' - REGION '.$list_mappingValue->REGION_NAME;
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $no);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, $list_mappingValue->KD_CUSTOMER);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, $list_mappingValue->NAMA_TOKO);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$numRow, $list_mappingValue->KODE_DISTRIBUTOR,PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, $list_mappingValue->NAMA_DISTRIBUTOR);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, $keterangan);

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
		
	public function All_data(){
		$data = array("title"=>"Dashboard CRM");
		
        $this->template->display('Visit_plan_data_view', $data);
	}
	
	public function List_visit_plan(){
		$id_distributor = $this->input->post("id_distributor");
		$id_sales 		= $this->input->post("id_sales"); 
		$hasil 		= $this->Visit_plan_model->get_data_visit_plan($id_distributor, $id_sales);
		echo json_encode($hasil);
	}
	
	public function Export_visit_plan($id_sales, $nameFile){
			$nameFile = urldecode($nameFile);
			
			$getData = $this->Visit_plan_model->get_data_visit_plan(null, $id_sales);
			
			$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator('Admin-CRM-Semen-Indonesia')->setTitle('Rekap Daftar Mapping Customer');
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
			
			$filename = $nameFile;
            $objPHPExcel->getActiveSheet(0)->setTitle('Daftar Visit Plan Sales');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $nameFile);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:F2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "ID_SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "USERNAME");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "ID_CUSTOMER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA_TOKO");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "ID_DISTRIBUTOR");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "NAMA_DISTRIBUTOR");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "SUN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "MON");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "TUE");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "WED");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "THU");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "FRI");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "SAT");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "W1");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "W2");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "W3");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', "W4");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', "W5");

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
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);

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
            $objPHPExcel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);
			
			$no = 1;
			$keterangan= ''; 
            $numRow = 4;
            foreach ($getData as $list_mappingKey => $list_mappingValue) {
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $no);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, $list_mappingValue->ID_SALES);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, $list_mappingValue->NAMA);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, $list_mappingValue->USERNAME);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, $list_mappingValue->ID_CUSTOMER);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, $list_mappingValue->NAMA_TOKO);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$numRow, $list_mappingValue->ID_DISTRIBUTOR,PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, $list_mappingValue->NAMA_DISTRIBUTOR);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, $list_mappingValue->SUN);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, $list_mappingValue->MON);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, $list_mappingValue->TUE);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, $list_mappingValue->WED);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, $list_mappingValue->THU);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, $list_mappingValue->FRI);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, $list_mappingValue->SAT);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, $list_mappingValue->W1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numRow, $list_mappingValue->W2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numRow, $list_mappingValue->W3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numRow, $list_mappingValue->W4);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numRow, $list_mappingValue->W5);

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
                $objPHPExcel->getActiveSheet()->getStyle('O'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('P'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('Q'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('R'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('S'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('T'.$numRow)->applyFromArray($style_row);

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