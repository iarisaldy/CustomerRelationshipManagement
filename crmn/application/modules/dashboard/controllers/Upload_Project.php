<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Upload_Project extends CI_Controller {

	private $filename = "TEMPLATE_UPLOADS_PROJECT_TOKO"; 	// menententukan nama file'
	
    function __construct(){
        parent::__construct();
		
		$this->load->model('Upload_Project_model');
		$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel'));
    }
	
	public function index(){
		$data = array("title"=>"Dashboard CRM");

		// $startTimeStamp = strtotime("2020/04/25");
		// $endTimeStamp = strtotime("2020/05/4");

		// $day = date('D', $startTimeStamp);
		// echo $day;exit;

		// $timeDiff = abs($endTimeStamp - $startTimeStamp);

		// $numberDays = $timeDiff/86400;  // 86400 seconds in one day

		// // and you might want to convert to integer
		// $numberDays = intval($numberDays)+1;
		// echo $numberDays;exit;
		
			if(isset($_POST['preview'])){ 
				$upload = $this->upload_file($this->filename);
				
				if($upload['result'] == "success"){ 
					//include APPPATH.'third_party/PHPExcel/PHPExcel.php';
					$excelreader = new PHPExcel_Reader_Excel2007();
					$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); 
					$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
						
					$data['sheet'] = $sheet; 

					// print_r('<pre>');
					// print_r($sheet);exit;
						
				} else { 
					$data['upload_error'] = $upload['error']; 
				}
			}
		
        $this->template->display('Upload_Project_view', $data);
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
		
		//lakukan replacing
		$inputGoingReplace = $_POST['list_data_replacing'];
		$this->do_replacing_data($inputGoingReplace);
		
		$inputGoingImporting = $_POST['list_data_importing'];
		$Importing_data 	 = json_decode($inputGoingImporting, true);
		
		// print_r(json_decode($inputGoingReplace));
		// print_r($Importing_data);
		// exit();
		
		$date = date('d-m-Y H:i:s');
		//Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
		$data = array();
		$baris_data_in = count($Importing_data);
		$data_sukses = 0;
		$data_fail = 0;
		$numrow = 1;
		
		foreach($Importing_data as $dt_in){
			$id_sales  = $dt_in['ID_SALES'];
			$id_toko = $dt_in['ID_TOKO'];
			$id_dist  = $dt_in['ID_DISTRIBUTOR'];
			
			$insert = $this->Upload_Project_model->mapping_toko_batch($id_sales, $id_toko, $id_dist);
			if($insert == 1){
				$data_sukses++;
			} else {
				$data_fail++;
			}
			
		}
		
		/* fungsi lama langsung ambil dari file excel.
		foreach($sheet as $row){
			// Cek $numrow apakah lebih dari 1
			
			if($row['A'] == "" && $row['B'] == "" && $row['C'] == "" && $row['D'] == "" && $row['E'] == "" && $row['F'] == ""){
			continue;
			} else {
				$baris_data_in++;
			}
			
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Panggil fungsi yg telah di buat di model
				$insert = $this->Upload_Project_model->mapping_toko_batch($row['A'], $row['C'],$row['E']);
				$data_sukses++;
			}
			$numrow++; // Tambah 1 setiap kali looping
		}
		*/
		
		//$data_fail = $baris_data_in-$data_sukses-1;
		$this->session->set_userdata("after_import", true);
		$this->session->set_userdata("baris_data", $baris_data_in);
		$this->session->set_userdata("data_sukses", $data_sukses);
		$this->session->set_userdata("data_fail", $data_fail);

		redirect(site_url('dashboard/Upload_Project'));
	}
	
	public function export_preview(){
		$data 	= json_decode($_POST['data'], true);
		print_r($data);
		exit();
	}
	
	private function do_replacing_data($data_in){
		$data 		= json_decode($data_in, true);
		$hasil 		= $this->Upload_Project_model->do_repalacing_data_mapping($data);
			
			if($hasil != '0_0'){
				$response = "sukses";
			}
			else {
				 $response = "error";
			}
			
		return $response;	
	}
	
}
