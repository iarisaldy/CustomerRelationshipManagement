<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Manajemen_user extends CI_Controller {

	private $filename = "import_data_user"; 	// menententukan nama file'
	
    function __construct(){
        parent::__construct();
		
		$this->load->model('user_model');
		$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel'));
    }
	
	public function index(){
		$data = array("title"=>"Dashboard CRM");
		
        $this->template->display('Manajemen_user_view', $data);
	}
	
	//---------------------------------------------------------------------
	// LIST DATA USER => yang belum di mapping ke atasan
	//---------------------------------------------------------------------
	
		public function List_gsm(){
			$hasil = $this->user_model->get_GSM();
			echo json_encode($hasil);
		}
		
		public function List_ssm(){ // Unmapping
			//$id_jenis_user = 1010;
			//$hasil = $this->user_model->get_user_sales($id_jenis_user);
			$hasil = $this->user_model->get_user_ssm_Unmap();
			echo json_encode($hasil);
		}
		
		public function List_ssm_all(){
			$id_jenis_user = 1010;
			$hasil = $this->user_model->get_user_sales($id_jenis_user);
			echo json_encode($hasil);
		}
		
		public function List_sm(){
			//$id_jenis_user = 1011; 
			//$hasil = $this->user_model->get_user_sales($id_jenis_user);
			$hasil = $this->user_model->get_user_sm_Unmap();
			echo json_encode($hasil);
		}
		
		public function List_sm_all(){
			$id_jenis_user = 1011; 
			$hasil = $this->user_model->get_user_sales($id_jenis_user);
			echo json_encode($hasil);
		}
		
		public function List_so(){
			//$id_jenis_user = 1012;
			//$hasil = $this->user_model->get_user_sales($id_jenis_user);
			$hasil = $this->user_model->get_user_so_Unmap();
			echo json_encode($hasil);
		}
		
		public function List_so_all(){
			$id_jenis_user = 1012;
			$hasil = $this->user_model->get_user_sales($id_jenis_user);
			echo json_encode($hasil);
		}
		
		public function List_sd(){
			//$id_jenis_user = 1015;
			//$hasil = $this->user_model->get_user_sales($id_jenis_user);
			$hasil = $this->user_model->get_user_sd_Unmap();
			echo json_encode($hasil);
		}
		
		public function List_sd_all(){
			$id_jenis_user = 1015;
			$hasil = $this->user_model->get_user_sales($id_jenis_user);
			echo json_encode($hasil);
		}
		
		//---------------------
		
		public function List_dist(){
			$id_jenis_user = 1013;
			$hasil = $this->user_model->get_user_sales($id_jenis_user);
			echo json_encode($hasil);
		}
		
		public function List_spc(){
			$id_jenis_user = 1017;
			$hasil = $this->user_model->get_user_sales($id_jenis_user);
			echo json_encode($hasil);
		}
	
	//-------------------------------------------------------------------------- WILAYAH CAKUPAN
	
	public function List_wilayah_cakupan(){
		$request 	= $this->input->post("request");  // region, provinsi, area, distrik
		$hasil 		= $this->user_model->get_cakupan_wilayah($request);
		echo json_encode($hasil);
	}
	
	public function List_distributor_gudang(){ 
		$request 	= $this->input->post("request");  // distributor, gudang
		$hasil 		= $this->user_model->get_distributor_gudang($request);
		echo json_encode($hasil);
	}
	
	// ------------------------------------------------------------------------- DIST & GUDANG
	
	public function List_jenis_user(){
		$hasil = $this->user_model->get_jenis_user();
		echo json_encode($hasil);
	}
	
	public function set_user_sales(){
		$id_user 		= $this->input->post("id_user");
		$id_jenis_user 	= $this->input->post("id_jenis_user");
		$nama 			= $this->input->post("nama");
		$username 		= $this->input->post("username");
		$password 		= $this->input->post("password");
		$email 			= $this->input->post("email");
		
		$hasil = $this->user_model->set_User($id_user, $id_jenis_user, $nama, $username, $password, $email);
		return $hasil;
	}
	
	public function del_user_sales(){
		$id_user 	= $this->input->post("id_user");
		$hasil 		= $this->user_model->del_User($id_user);
		return $hasil;
	}
	
	/*
	public function setWilayahGsm(){ 
		$id_gsm = $this->input->post("id_gsm");
		$wilayah = $this->input->post("wilayah");
		$hasil = $this->user_model->set_Wilayah_GSM($id_gsm, $wilayah);
		return $hasil;
	}
	
	public function setAtasan(){ 
		$id_user = $this->input->post("id_user");
		$atasan = $this->input->post("atasan");
		$hasil = $this->user_model->set_Atasan($id_user, $atasan);
		return $hasil;
	}
	*/
	
	//-------------------------------------------------------------------------------------------
	// SET USER MAPPING
	//-------------------------------------------------------------------------------------------
	
		public function List_mappingan_hierarki(){			// tidak dipakai
			$id_user 	= $this->input->post("id_user");
			$request 	= $this->input->post("request");
			
			// request -> datalist : gsm, ssm, sm, so, sd
			
			if($request == 'gsm'){
				$hasil = $this->user_model->list_gsm_user($id_user);
			} elseif ($request == 'ssm'){
				$hasil = $this->user_model->list_ssm_user($id_user);
			} elseif ($request == 'sm'){
				$hasil = $this->user_model->list_sm_user($id_user);
			} elseif ($request == 'so'){
				$hasil = $this->user_model->list_so_user($id_user);
			} elseif ($request == 'sd'){
				$hasil = $this->user_model->list_sd_user($id_user);
			}
			echo json_encode($hasil);
		}
	
		public function Mapping($id_user){
			$data = array("title"=>"Dashboard CRM");
			$data['users'] = $this->user_model->get_user($id_user); 
			$data['id_user_in'] = $id_user;
			
			// foreach ($data['users'] as $getDt){
				// $id_j_user = $getDt['ID_JENIS_USER']
			// }
			
        	$this->template->display('Mapping_user_view', $data);
		}
		
		public function List_mappingan_hierarkiNew(){
			$id_user 	= $this->input->post("id_user");
			$request 	= $this->input->post("request");
			
			// request -> datalist : gsm, ssm, sm, so, sd
			
			if($request == 'gsm'){
				//$hasil = $this->user_model->list_gsm_user($id_user);
			} elseif ($request == 'ssm'){
				$hasil = $this->user_model->list_ssm_userOfGsm($id_user);
			} elseif ($request == 'sm'){
				$hasil = $this->user_model->list_sm_userOfSsm($id_user);
			} elseif ($request == 'so'){
				$hasil = $this->user_model->list_so_userOfSm($id_user);
			} elseif ($request == 'sd'){
				$hasil = $this->user_model->list_sd_userOfSo($id_user);
			}
			echo json_encode($hasil);
		}
		
		public function List_mappingan_wilayah(){
			$id_user 	= $this->input->post("id_user");
			$request 	= $this->input->post("request");
			
			// request -> datalist : region, provinsi, area, distrik
			
			if($request == 'region'){
				$hasil = $this->user_model->list_region_user($id_user);
			} elseif ($request == 'provinsi'){
				$hasil = $this->user_model->list_provinsi_user($id_user);
			} elseif ($request == 'area'){
				$hasil = $this->user_model->list_area_user($id_user);
			} elseif ($request == 'distrik'){
				$hasil = $this->user_model->list_distrik_user($id_user);
			} 
			echo json_encode($hasil);
		}
		
		public function List_mappingan_dist_gudang(){
			$id_user 	= $this->input->post("id_user");
			$request 	= $this->input->post("request");
			
			// request -> datalist : distributor, gudang
			
			if($request == 'distributor'){
				$hasil = $this->user_model->list_distributor_user($id_user);
			} elseif ($request == 'gudang'){
				$hasil = $this->user_model->list_gudang_user($id_user);
			}
			echo json_encode($hasil);
		}
		
		// ACTION MAPPING [ INSERT AND DELETE ]
		
		public function Set_mapping_hierarki(){	 			// Tidak dipakai lagi // Set hierarki, user mapping and unmapping 
			$actControl		= $this->input->post("actControl_js");
			
			$actIn_or_Del	= $this->input->post("actIn_or_Del");
			$valueIn		= $this->input->post("valueIn");
			$id_user		= $this->input->post("id_user");
			
			if($actControl == 'gsm'){
				$hasil = $this->user_model->set_gsm_user($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'ssm'){
				$hasil = $this->user_model->set_ssm_user($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'sm'){
				$hasil = $this->user_model->set_sm_user($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'so'){
				$hasil = $this->user_model->set_so_user($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'sd'){
				$hasil = $this->user_model->set_sd_user($actIn_or_Del, $id_user, $valueIn);
			} 
			 
			$output = array(
				"pesan" => $hasil
			);
			echo json_encode($output);
			//print_r($hasil);
			exit();
		}
		
		public function Set_mapping_hierarkiNew(){	 			// Tidak dipakai lagi // Set hierarki, user mapping and unmapping 
			$actControl		= $this->input->post("actControl_js");
			
			$actIn_or_Del	= $this->input->post("actIn_or_Del");
			$valueIn		= $this->input->post("valueIn");
			$id_user		= $this->input->post("id_user");
			
			if($actControl == 'gsm'){
				//$hasil = $this->user_model->set_gsm_user($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'ssm'){
				$hasil = $this->user_model->set_ssm_userGsm($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'sm'){
				$hasil = $this->user_model->set_sm_userSsm($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'so'){
				$hasil = $this->user_model->set_so_userSm($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'sd'){
				$hasil = $this->user_model->set_sd_userSo($actIn_or_Del, $id_user, $valueIn);
			} 
			 
			$output = array(
				"pesan" => $hasil
			);
			echo json_encode($output);
			//print_r($hasil);
			exit();
		}
		
		public function Set_mapping_wilayah_cakupan(){	 			// Set wilayah, user mapping and unmapping 
			$actControl		= $this->input->post("actControl_js");
			
			$actIn_or_Del	= $this->input->post("actIn_or_Del");
			$valueIn		= $this->input->post("valueIn");
			$id_user		= $this->input->post("id_user");
			
			if($actControl == 'region'){
				$hasil = $this->user_model->set_region_user($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'provinsi'){
				$hasil = $this->user_model->set_provinsi_user($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'area'){
				$hasil = $this->user_model->set_area_user($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'distrik'){
				$hasil = $this->user_model->set_distrik_user($actIn_or_Del, $id_user, $valueIn);
			} 
			 
			$output = array(
				"pesan" => $hasil
			);
			echo json_encode($output);
			//print_r($hasil);
			exit();
		}
		
		public function Set_mapping_distributor_gudang(){	 			// Set distributor dan gudang, user mapping and unmapping 
			$actControl		= $this->input->post("actControl_js");
			
			$actIn_or_Del	= $this->input->post("actIn_or_Del");
			$valueIn		= $this->input->post("valueIn");
			$id_user		= $this->input->post("id_user");
			
			if($actControl == 'distributor'){
				$hasil = $this->user_model->set_distributor_user($actIn_or_Del, $id_user, $valueIn);
			} elseif ($actControl == 'gudang'){
				$hasil = $this->user_model->set_gudang_user($actIn_or_Del, $id_user, $valueIn);
			} 
			 
			$output = array(
				"pesan" => $hasil
			);
			echo json_encode($output);
			//print_r($hasil);
			exit();
		}
		
	
	//-------------------------------------------------------------------------------------------
	// 	IMPORT EXCEL DATA USER
	//-------------------------------------------------------------------------------------------
	
		public function Import_excel(){
			$data = array(); 
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
			$data['title'] = "Import User";
			$data['jenis_user_u'] = $this->user_model->get_jenis_user();
			$this->template->display('Import_user_view', $data);
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
			$data_sukses = 0;
			$data_sama = 0;
			$numrow = 1;
			foreach($sheet as $row){
				// Cek $numrow apakah lebih dari 1
				if($row['A'] == "" && $row['B'] == "" && $row['C'] == "" && $row['D'] == "")
				continue;
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport
				if($numrow > 1){
					// Panggil fungsi addCanvasing yg telah di buat di model
					$insert = $this->user_model->add_user_batch($row['A'], $row['B'], $row['C'], $row['D']);
					$data_sukses++;
				}
				$numrow++; // Tambah 1 setiap kali looping
			}
			$this->session->set_userdata("after_import", true);
			$this->session->set_userdata("baris_data", sizeof($sheet)-1);
			$this->session->set_userdata("data_sukses", $data_sukses);
			$this->session->set_userdata("data_sama", $data_sama);

			redirect(site_url('user/Manajemen_user/Import_excel'));
		}
		
	//-------------------------------------------------------------------------------------------
	// 	EXPORT EXCEL DATA USER
	//-------------------------------------------------------------------------------------------
	
		public function Export_excel($request){
			$getData; $nameFile;
			
			if ($request == 'gsm'){
				$nameFile = "General_Sales_Manager";
				$getData = $this->user_model->get_GSM();
			} else if($request == 'ssm'){
				$nameFile = "Senior_Sales_Manager";
				$getData = $this->user_model->get_user_sales(1010);
			} else if($request == 'sm'){
				$nameFile = "Salaes_Manager";
				$getData = $this->user_model->get_user_sales(1011);
			} else if($request == 'so'){
				$nameFile = "Sales_Officer";
				$getData = $this->user_model->get_user_sales(1012);
			} else if($request == 'sd'){
				$nameFile = "Sales_Distributor";
				$getData = $this->user_model->get_user_sales(1015);
			} else if($request == 'dist'){
				$nameFile = "Distributor";
				$getData = $this->user_model->get_user_sales(1013);
			} else if($request == 'spc'){
				$nameFile = "Spc";
				$getData = $this->user_model->get_user_sales(1017);
			}

			// print_r('<pre>');
			// print_r($getData);exit;
			
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
			
			$filename = "Daftar_User_".$nameFile;
            $objPHPExcel->getActiveSheet(0)->setTitle("Daftar User ".$request);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DAFTAR USER ".$nameFile);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:F2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "ID USER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA USER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "USERNAME");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "PASSWORD");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "EMAIL");

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
            foreach ($getData as $list_mappingKey => $list_mappingValue) {
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $no);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, $list_mappingValue->ID_USER);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, $list_mappingValue->NAMA);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, $list_mappingValue->USERNAME);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, $list_mappingValue->PASSWORD);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, $list_mappingValue->EMAIL);

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