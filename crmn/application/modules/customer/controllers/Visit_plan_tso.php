<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Visit_plan_tso extends CI_Controller {

	private $filename = "TEMPLATE_UPLOADS_VISIT_PLAN_SALES"; 	// menententukan nama file'
	
    function __construct(){
        parent::__construct();
		
		$this->load->model('Model_visit_plan_tso');
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
		
        $this->template->display('Upload_visit_plan_tso', $data);
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
			
				if($row['A'] == "" && $row['B'] == "" && $row['C'] == "" && $row['D'] == "" && $row['E'] == "" && $row['F'] == "" && $row['G'] == "" && $row['H'] == "" && $row['I'] == "" && $row['J'] == "" && $row['K'] == "" && $row['L'] == "" && $row['M'] == "" && $row['N'] == "" && $row['O'] == "" && $row['P'] == "" && $row['Q'] == ""){
				continue;
				} else {
					$baris_data_in++;
				}
				
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport
				if($numrow > 1){
					// Panggil fungsi yg telah di buat di model
					$insert = $this->Model_visit_plan_tso->visit_plan_batch($row['A'], $row['C'], $row['E'], $row['F'], $row['G'], $row['H'], $row['I'], $row['J'], $row['K'], $row['L'], $row['M'], $row['N'], $row['O'], $row['P'], $row['Q']);
					$data_sukses++;
				}
				$numrow++; // Tambah 1 setiap kali looping
			}
			$data_fail = $baris_data_in-$data_sukses-1;
			$this->session->set_userdata("after_import", true);
			$this->session->set_userdata("baris_data", $baris_data_in-1);
			$this->session->set_userdata("data_sukses", $data_sukses);
			$this->session->set_userdata("data_fail", $data_fail);

			redirect(site_url('customer/Visit_plan_tso'));
		}
	
	public function List_sd(){
		//$id_jenis_user = 3701; 
		$id_user 		= $this->session->userdata('user_id');
		$hasil = $this->Model_visit_plan_tso->Get_sales_tso($id_user);
		echo json_encode($hasil);
	}
	
	public function List_toko(){
		$id_sales 	= $this->input->post("id_sales"); 
		$hasil = $this->Model_visit_plan_tso->get_toko_sales($id_sales);
		echo json_encode($hasil);
	}
	
		public function Export_mapping_toko($id_sales, $nameFile){
			
			$nameFile = urldecode($nameFile);
			
			$getData = $this->Model_visit_plan_tso->get_toko_sales($id_sales);
			
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
	
}

?>