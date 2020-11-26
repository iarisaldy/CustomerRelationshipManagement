
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action_log extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('M_action_log'); 
	}
	//fungsi yang digunakan untuk pemanggilan halaman home
	public function index()
	{
		$data['title'] = "Action Log"; 
		$this->template->display('action_log', $data);
	}
    
	 public function get_data()
    { 
        $s = isset($_POST["search"]) ? $_POST["search"]["value"] : "";
		$p = isset($_POST["start"]) && $_POST["start"] != "" && is_numeric($_POST["start"]) ? intval($_POST["start"]) : 0;
		$e = isset($_POST["length"]) && $_POST["length"] != "" && is_numeric($_POST["length"]) ? intval($_POST["length"]) : 10;
		$c = array("A.ISU", "A.TANGGAL", "A.SOLUSI", "A.PROGRESS");
		$o = isset($_POST["order"]) ? array($c[intval($_POST["order"][0]["column"])], strtoupper($_POST["order"][0]["dir"])) : array($c[0], "ASC");
		
		$id_user = $this->session->userdata("user_id"); 
		$jenisUser = $this->session->userdata("id_jenis_user");	
		$hasil = $this->M_action_log->get_data($s, $p, $e, $c, $o, $id_user, $jenisUser);
		
		$result["draw"] = isset($_POST["draw"]) ? intval($_POST["draw"]) : 1;
		$result["recordsTotal"] = intval($hasil["total"]);
		$result["recordsFiltered"] = intval($hasil["filtered"]);
		$result["data"] = array();
		
		$baris = 0;
		$status = '';
		$no = 1;
		foreach($hasil["data"] as $r) {
			if($r["STATUS"]=='11' || $r["STATUS"]=='21'){
				$status = 'Open';
				$id_status = '1';
			} else if($r["STATUS"]=='12' || $r["STATUS"]=='22'){
				$status = 'On Progress ';
				$id_status = '2';
			}else if($r["STATUS"]=='13' ){
				$status = 'Menunggu Approval SM ';
				$id_status = '31';
			}else if($r["STATUS"]=='23'){
				$status = 'Menunggu Approval SSM ';
				$id_status = '32';
			}else if($r["STATUS"]=='14' || $r["STATUS"]=='24'){
				$status = 'Done';
				$id_status = '4';
			}
			$tombol_approve ='';
			$tombol_update ='';
			$tombol_hapus = '';
			if($id_status=='31' && $jenisUser=='1011' ){
				$tombol_approve = "<button title='Approve' style='font-size: 10px;' onclick='approve({$baris})' class='btn btn-info btn-sm waves-effect '><span class='btn-labelx'><i class='fa fa-thumbs-up'></i></span></button>&nbsp;"; 
			}
			if($id_status=='32' && $jenisUser=='1010' ){
				$tombol_approve = "<button title='Approve' style='font-size: 10px;' onclick='approve({$baris})' class='btn btn-info btn-sm waves-effect '><span class='btn-labelx'><i class='fa fa-thumbs-up'></i></span></button>&nbsp;"; 
			}
			if($r["CREATE_BY"]==$id_user && $id_status!='31' && $id_status!='32' && $id_status!='4'){
				$tombol_update = "<button title='Update' style='font-size: 10px;' onclick='edit({$baris})' class='btn btn-primary btn-sm waves-effect btn_edit'><span class='btn-labelx'><i class='fa fa-pencil'></i></span></button>"; 
				$tombol_hapus = "<button title='Non Active' style='font-size: 10px;' onclick='konfirmasi({$baris})' class='btn btn-danger btn-sm waves-effect btn_hapus'><span class='btn-labelx'><i class='fa fa-trash'></i></span> </button>";
			}
			
			$tombol = array(
				"{$tombol_approve} {$tombol_update}","{$tombol_hapus}"
				
			); 
			
			if($r["TOPIK"]=='1'){
				$topik = 'Penjualan';
			}else if($r["TOPIK"]=='2'){
				$topik = 'Stok';
			}else if($r["TOPIK"]=='3'){
				$topik = 'Program';
			}else if($r["TOPIK"]=='4'){
				$topik = 'Komplain';
			}else if($r["TOPIK"]=='5'){
				$topik = 'Administrasi';
			}else{
				$topik = ' ';
			}
			$result["data"][] = array(
				htmlspecialchars($no),
				 $topik ,
				 $r["ISU"] ,
				htmlspecialchars($r["SOLUSI"]),
				htmlspecialchars($r["TANGGAL_BUAT"]),
				htmlspecialchars($r["DATELINE"]),
				htmlspecialchars($r["PROGRESS"]),
				htmlspecialchars($status),
				"<center>{$tombol[0]}&nbsp;{$tombol[1]}</center>",
				array(
					$r["ID_ACTION_LOG"],
					$id_status,
					$r["TOPIK"],
				)
			);
			$baris++;
			$no++;
		}
		echo json_encode($result);

    }
      
	public function simpan() { 
	
		if(isset($_POST["isu"]) && isset($_POST["dateline"])) {
			$id_user = $this->session->userdata("user_id"); 
            $topik = $_POST["topik"]; 
            $isu = $_POST["isu"]; 
            $solusi = $_POST["solusi"]; 
            $dateline = $_POST["dateline"]; 
            $progress = $_POST["progress"];  
			
			$id_user = $this->session->userdata("user_id"); 
			$jenisUser = $this->session->userdata("id_jenis_user");		 			
			if($jenisUser=='1011'){
				$statusT = '2';
			}else if($jenisUser=='1012'){
				$statusT = '1';
			}
			 
			$status = $statusT."1";		
			 
			$column = array( 'TOPIK','ISU', 'SOLUSI', 'TANGGAL', 'PROGRESS', 'STATUS', 'CREATE_BY', 'CREATE_DATE'
			);
			$hariini = date('d-m-Y');
			$data = array(
				"'{$topik}'","'{$isu}'","'{$solusi}'","TO_DATE('{$dateline}', 'DD-MM-YY')","'{$progress}'","'{$status}'" ,"'{$id_user}'" ,"TO_DATE('{$hariini}', 'DD-MM-YY')" 
			);
			 
			$q = $this->M_action_log->simpan($column, $data); 
			if($q) { 
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			}
			 
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	}
    
    
	public function update() {
		if(isset($_POST["isu"]) && isset($_POST["dateline"])) { 
			$id = intval($_POST["id"]);
			$topik = $_POST["topik"]; 
			$isu = $_POST["isu"]; 
            $solusi = $_POST["solusi"]; 
            $dateline = $_POST["dateline"]; 
            $progress = $_POST["progress"]; 
            $id_user = $this->session->userdata("user_id");		
            $jenisUser = $this->session->userdata("id_jenis_user");			
			if($jenisUser=='1011'){
				$statusT = '2';
			}else if($jenisUser=='1012'){
				$statusT = '1';
			}
			
			if($_POST["status"]=='1'){
				$status = $statusT."1";		
			}else if($_POST["status"]=='2'){
				$status = $statusT."2";
			}else if($_POST["status"]=="3"){
				$status = $statusT."3";
			}
			
			$column = array( 'TOPIK', 'ISU', 'SOLUSI', 'TANGGAL', 'PROGRESS', 'STATUS', 'UPDATE_BY', 'UPDATE_DATE'
			);
			$hariini = date('d-m-Y');
			$data = array(
				"'{$topik}'","'{$isu}'","'{$solusi}'","TO_DATE('{$dateline}', 'DD-MM-YY')","'{$progress}'","'{$status}'" ,"'{$id_user}'" ,"TO_DATE('{$hariini}', 'DD-MM-YY')" 
			);
			 
			
			$jml_kolom = count($column);
			$data_baru = array();
			
			for($i = 0; $i < $jml_kolom; $i++) {
				$data_baru[] = $column[$i]."=".$data[$i];
			}
			 
			$q = $this->M_action_log->update($id, $data_baru);
			if($q) { 
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			} 
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	} 
    
	public function approve() {
		if(isset($_POST["id"])) {
			
            $id_user = $this->session->userdata("user_id");		
            $jenisUser = $this->session->userdata("id_jenis_user");	
			if($jenisUser=='1010'){
				$status = "24";
			}else if($jenisUser=='1011'){
				$status = "14";
			}
			$id = intval($_POST["id"]);
			$q = $this->M_action_log->approve($id, $status);
			
           if($q) { 
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil Approve'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			}
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	}
    
	public function reject() {
		if(isset($_POST["id"])) { 
            $id_user = $this->session->userdata("user_id");		
            $jenisUser = $this->session->userdata("id_jenis_user");	
			if($jenisUser=='1010'){
				$status = "22";
			}else if($jenisUser=='1011'){
				$status = "12";
			}
			$id = intval($_POST["id"]);
			$q = $this->M_action_log->approve($id, $status);
			
           if($q) { 
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil Reject'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			}
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	}
    
	public function hapus() {
		if(isset($_POST["id"])) {
			$id = intval($_POST["id"]);
			$q = $this->M_action_log->hapus($id);
			
           if($q) { 
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			}
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	}
     
	 
    public function export_excel()
    {
         
		$id_user = $this->session->userdata("user_id");		
		$jenisUser = $this->session->userdata("id_jenis_user");	
		
        $getData     = $this->M_action_log->dataExport($id_user,$jenisUser);
         
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory')); 

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $styles    = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        ); 
		
		$objPHPExcel  = $objReader->load("assets/excel/ExportActionLog.xlsx");
		$objWorksheet = $objPHPExcel->getActiveSheet(); 
		$urut = 1;
		$no = 3 ;
		
		foreach($getData as $v){ 
		
			if($v["STATUS"]=='11' || $v["STATUS"]=='21'){
				$status = 'Open'; 
			} else if($v["STATUS"]=='12' || $v["STATUS"]=='22'){
				$status = 'On Progress '; 
			}else if($v["STATUS"]=='13' || $v["STATUS"]=='23'){
				$status = 'Menunggu Approval SM '; 
			}else if($v["STATUS"]=='14' || $v["STATUS"]=='24'){
				$status = 'Done'; 
			}  
			$objWorksheet->setCellValue("B{$no}", $urut); 
			$objWorksheet->setCellValue("C{$no}", $v["TOPIK"]); 
			$objWorksheet->setCellValue("D{$no}", $v["ISU"]); 
			$objWorksheet->setCellValue("E{$no}", $v["SOLUSI"]); 
			$objWorksheet->setCellValue("F{$no}", $v["TANGGAL_BUAT"]); 
			$objWorksheet->setCellValue("G{$no}", $v["DATELINE"]); 
			$objWorksheet->setCellValue("H{$no}", $v["PROGRESS"]); 
			$objWorksheet->setCellValue("I{$no}", $status); 
			$objWorksheet->setCellValue("J{$no}", $v["NAMA"]); 
			$urut += 1;
			$no += 1;
		} 

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=Export_ActionLog.xls');
		header('Cache-Control: max-age=0');
		header("Pragma: no-cache");

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$reader = PHPExcel_IOFactory::createReader('Excel5');

		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');
		 
    }
     
    
}
