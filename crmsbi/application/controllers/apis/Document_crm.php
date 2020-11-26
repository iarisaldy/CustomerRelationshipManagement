<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Document_crm extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Dokument_crm_model');
        }
		public function TampilanImage_post(){
			
			$id_user 	= $this->input->post("id_user");
			$id_kc		= $this->input->post("id_kunjungan_customer");
			
			$hasil = $this->Dokument_crm_model->get_tampilan_foto_kunjungan($id_user, $id_kc);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			
			$this->response($response);
			
		}
		public function FotoKunjungan_post(){
			
			$id_user 	= $this->input->post("id_user");
			$id_kc		= $this->input->post("id_kunjungan_customer");
			$tahun 		= $this->input->post("tahun");
			$bulan 		= $this->input->post("bulan");
			
			$hasil = $this->Dokument_crm_model->get_data_foto_kunjungan($id_user, $id_kc, $tahun, $bulan);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			
			$this->response($response);
			
		}
		
		public function InsertFoto_post(){
			
			$id_user 	= $this->input->post("id_user");
			$id_kc		= $this->input->post("id_kunjungan_customer");
			$foto 		= $_FILES["foto"]['tmp_name'];
			$nama 		= $_FILES["foto"]['name'];
			
			//Pemindahan FIle Ke server.tmp_name
			$fixs_foto =array();
			$status_uploads = null;
			for($i=0; $i<count($foto); $i++){
				$target_file = 'assets/Survey/';
				$target_file = $target_file. $nama[$i]; 

				if (file_exists($target_file)) {
					$pesan = "File Sudah Ada";
					$status_uploads = 0;
				}
				else {
					$status_uploads = 1;
					move_uploaded_file($foto[$i], $target_file);
					array_push($fixs_foto, $target_file);
				}
				
			}
			
			$hasil = null;
			if($status_uploads){
				
				$insert = array();
				$lokasi_gambar = 'assets/Survey/';
				
				for($i=0; $i<count($foto); $i++){
					
					array_push($insert, array(
						'ID_KUNJUNGAN_CUSTOMER' => $id_kc,
						'FOTO_SURVEY' => $lokasi_gambar. $nama[$i],
						'DELETE_MARK' => 0,
						'CREATE_BY' => $id_user,
						'CREATE_DATE' => date('d-M-y h.s.i A')
					));
				}
				
				$hasil = $this->Dokument_crm_model->Tambah_data_foto_kunjungan($insert, $id_user, $id_kc);
			}
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data berhasil ditambah", "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "message" => "Data Gagal Ditambah");
			}
			
			$this->response($response);
			
		}
		
		
		public function UpdateFoto_post(){
			$id_user 	= $this->input->post("id_user");
			$id_kc		= $this->input->post("id_kunjungan_customer");
			$foto 		= $_FILES["foto"]['tmp_name'];
			$nama 		= $_FILES["foto"]['name'];
			
			//Proses delete FILE di server.
			$data_foto_s = $this->Dokument_crm_model->Tampilan_foto_kunjungan($id_user, $id_kc);
			
			foreach($data_foto_s as $d){
				if (file_exists($d['FOTO_SURVEY'])) {
					unlink($d['FOTO_SURVEY']);
				}
			}
			
			//Proses delete data di database
			$delete_mark = $this->Dokument_crm_model->Update_delete_mark_KC($id_user, $id_kc);
			
			
			//Pemindahan FIle Ke server.tmp_name
			$status_uploads = null;
			for($i=0; $i<count($foto); $i++){
				$target_file = 'assets/Survey/';
				$target_file = $target_file. $nama[$i]; 

				if (file_exists($target_file)) {
					$pesan = "File Sudah Ada";
					$status_uploads = 0;
				}
				else {
					$status_uploads = 1;
					move_uploaded_file($foto[$i], $target_file);
				}
				
			}
			
			if($status_uploads){
				
				$insert = array();
				$lokasi_gambar = 'assets/Survey/';
				
				for($i=0; $i<count($foto); $i++){
					
					array_push($insert, array(
						'ID_KUNJUNGAN_CUSTOMER' => $id_kc,
						'FOTO_SURVEY' => $lokasi_gambar. $nama[$i],
						'DELETE_MARK' => 0,
						'CREATE_BY' => $id_user,
						'CREATE_DATE' => date('d-M-y h.s.i A')
					));
				}
				
				$hasil = $this->Dokument_crm_model->Tambah_data_foto_kunjungan($insert, $id_user, $id_kc);
			}
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data berhasil ditambah", "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "message" => "Data Gagal Ditambah", "data" => "[]");
			}
			
			$this->response($response);
			
			
		}
		
		public function UploadSync_post(){
			
			$id_user 	= $this->input->post("id_user");
			$data 	= json_decode($_POST['data'], true);
			
			$insert = array();
			
			foreach($data as $d){
				
				array_push($insert, array(
					'ID_KUNJUNGAN_CUSTOMER' => $d['ID_KUNJUNGAN_CUSTOMER'],
					'FOTO_SURVEY' => $d['FOTO'],
					'DELETE_MARK' => 0,
					'CREATE_BY' => $id_user,
					'CREATE_DATE' => date('d-M-y h.s.i A')
				));
			}
			
			$hasil = $this->Dokument_crm_model->Tambah_data_foto_kunjungan($insert);
			
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data berhasil ditambah");
			}
			else {
				 $response = array("status" => "error", "message" => "Data Gagal Ditambah");
			}
			
			$this->response($response);
			
		}
		
		public function DeleteFoto_post(){
			
			$id_user 	= $this->input->post("id_user");
			//$data 		= json_decode($_POST['data'], true);
			$in 		= $this->input->post("data");
			
			//proses delete data di server
			//$in = "''";
			
			// foreach($data as $d){
				
				// $in = $in. ",".  "'". $d['ID_FOTO_KUNJUNGAN']. "'";
				
			// }
			
			$foto_di_server = $this->Dokument_crm_model->get_foto_diserver($in);
			
			$status_hapus_file = null;
			foreach($foto_di_server as $ds){
				if (file_exists($ds['FOTO_SURVEY'])) {
					unlink($ds['FOTO_SURVEY']);
					
					$status_hapus_file =1;
				}
			}
			
			$hasil = $this->Dokument_crm_model->Delete_foto($id_user, $in);
			
			
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data berhasil dihapus");
			}
			else {
				 $response = array("status" => "error", "message" => "Data Gagal Dihapus");
			}
			
			$this->response($response);
			
		}
		public function InsertfotoSatuan_post(){
			
			$id_user 	= $this->input->post("id_user");
			$id_kc		= $this->input->post("id_kunjungan_customer");
			$foto 		= $_FILES["foto"]['tmp_name'];
			$nama 		= $_FILES["foto"]['name'];
			
			//Pemindahan File
			$target_file = 'assets/Survey/';
			$target_file = $target_file. $nama; 
			
			$status_uploads = null;
			
			if (file_exists($target_file)) {
				$pesan = "File Sudah Ada";
				$status_uploads = 0;
			}
			else {
				$status_uploads = 1;
				move_uploaded_file($foto, $target_file);
			}
			
			$hasil = null;
			if($status_uploads==1 || $status_uploads==0){
				
				$insert = array();
				
				array_push($insert, array(
					'ID_KUNJUNGAN_CUSTOMER' => $id_kc,
					'FOTO_SURVEY' => $target_file,
					'DELETE_MARK' => 0,
					'CREATE_BY' => $id_user,
					'CREATE_DATE' => date('d-M-y h.s.i A')
				));
				
				$hasil = $this->Dokument_crm_model->Tambah_data_foto_kunjungan($insert, $id_user, $id_kc, $target_file);
			}
			
			// print_r($insert);
			// print_r($hasil);
			if($hasil){
				$response = array("status" => "success", "message" => "Data berhasil ditambah", "data" => $hasil);
			}
			else {
				 $response = array("status" => "error", "message" => $hasil);
			}
			
			$this->response($response);
			
			
		}
		
		public function DownloadsFoto_post(){
			
			$id_user 	= $this->input->post("id_user");
			$idkf 		= $this->input->post("id_foto_kunjungan");
			
			//print_r($_POST);
			
			$data = $this->Dokument_crm_model->get_foto_by_id($idkf);
			$n1 = explode('/', $data);
			$filename = $n1[2];
			
			if ($filename == '' || $data == '')
			{
				return false;
			}
		 
			if (!file_exists($data))
			{
				return false;
			}
		 
			if (false === strpos($filename, '.'))
			{
				return false;
			}
		 
			$extension = strtolower(pathinfo(basename($filename), PATHINFO_EXTENSION));
		 
			$mime_types = array(
				'txt' => 'text/plain',
				'htm' => 'text/html',
				'html' => 'text/html',
				'php' => 'text/html',
				'css' => 'text/css',
				'js' => 'application/javascript',
				'json' => 'application/json',
				'xml' => 'application/xml',
				'swf' => 'application/x-shockwave-flash',
				'flv' => 'video/x-flv',
				// images
				'png' => 'image/png',
				'jpe' => 'image/jpeg',
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpeg',
				'gif' => 'image/gif',
				'bmp' => 'image/bmp',
				'ico' => 'image/vnd.microsoft.icon',
				'tiff' => 'image/tiff',
				'tif' => 'image/tiff',
				'svg' => 'image/svg+xml',
				'svgz' => 'image/svg+xml',
				// archives
				'zip' => 'application/zip',
				'rar' => 'application/x-rar-compressed',
				'exe' => 'application/x-msdownload',
				'msi' => 'application/x-msdownload',
				'cab' => 'application/vnd.ms-cab-compressed',
				// audio/video
				'mp3' => 'audio/mpeg',
				'qt' => 'video/quicktime',
				'mov' => 'video/quicktime',
				// adobe
				'pdf' => 'application/pdf',
				'psd' => 'image/vnd.adobe.photoshop',
				'ai' => 'application/postscript',
				'eps' => 'application/postscript',
				'ps' => 'application/postscript',
				// ms office
				'doc' => 'application/msword',
				'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'rtf' => 'application/rtf',
				'xls' => 'application/vnd.ms-excel',
				'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'ppt' => 'application/vnd.ms-powerpoint',
				'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				// open office
				'odt' => 'application/vnd.oasis.opendocument.text',
				'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			);
		 
			if (!isset($mime_types[$extension]))
			{
				$mime = 'application/octet-stream';
			} else
			{
				$mime = ( is_array($mime_types[$extension]) ) ? $mime_types[$extension][0] : $mime_types[$extension];
			}
		 
			if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
			{
				header('Content-Type: "' . $mime . '"');
				header('Content-Disposition: attachment; filename="' . $filename . '"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header("Content-Transfer-Encoding: binary");
				header('Pragma: public');
				header("Content-Length: " . filesize($data));
			} else
			{
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private", false);
				header("Content-Type: " . $mime, true, 200);
				header('Content-Length: ' . filesize($data));
				header('Content-Disposition: attachment; filename=' . $filename);
				header("Content-Transfer-Encoding: binary");
			}
			
			readfile($data);
			exit;
			
			
		}
		
	}


?>