<?php
	class Import_Excel_Canvassing extends CI_Controller {
		
		private $filename = "import_data_canvasing"; 	// menententukan nama file'
		
		public function __construct(){
			parent::__construct();
			$this->load->model("Model_import_excel_canvasing"); 
			$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel'));
		}
		
		public function index(){
			
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
			$idDistributor = $this->session->userdata("kode_dist");
			
			$data['salesku'] = $this->Model_import_excel_canvasing->getSalesPerDistributor($idDistributor);
			$data['customerku'] = $this->Model_import_excel_canvasing->getCustomerPerDistributor($idDistributor);
			$data['title'] = "Import Excel Routing Canvassing";
            $this->template->display('Import_excel_canvassing_view', $data);
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
				// Artinya karena baris pertama adalah nama-nama kolom
				// Jadi dilewat saja, tidak usah diimport
				if($numrow > 1){
					// Kita push (add) array data ke variabel data
					/*
					array_push($data, array(
						'ID_USER'=>$row['A'], // Insert data id sales dari kolom A
						'ID_TOKO'=>$row['B'], // Insert data id customer dari kolom B
						//'TGL_RENCANA_KUNJUNGAN'=>"TO_DATE('.$row['C'].','dd/mm/yyyy')", false), // Insert data tanggal kunjungan dari kolom C 
						'KETERANGAN'=>$row['D'], // Insert data penugasan dari kolom D 
						//'CREATED_AT'=>"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false),
					));
					*/
					//cek data exsisting
					if(sizeof($this->Model_import_excel_canvasing->checkKunjungan($row['A'], $row['B'], $row['C'])) == 0){
						// Panggil fungsi addCanvasing yg telah di buat di model
						$this->Model_import_excel_canvasing->addCanvasing($row['A'], $row['B'], $row['C'], $row['D']);
						$data_sukses++;
					} else {
						$data_sama++;
					}
				}
				
				$numrow++; // Tambah 1 setiap kali looping
			}
			$this->session->set_userdata("after_import", true);
			$this->session->set_userdata("baris_data", sizeof($sheet)-1);
			$this->session->set_userdata("data_sukses", $data_sukses);
			$this->session->set_userdata("data_sama", $data_sama);
			//$this->Model_import_excel_canvasing->addCanvasing($data);
			redirect(site_url('sales/Import_Excel_Canvassing'));
		}
		
		
		
		
		
		
		
	}
?>