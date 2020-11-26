
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level_stok extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('M_level_stok'); 
	}
	//fungsi yang digunakan untuk pemanggilan halaman home
	public function index()
	{
		$data['title'] = "Dashboard Kunjungan Sales"; 
		
		$this->template->display('level_stok', $data); 
	}
     public function Monitoring()
    {  
	$id_user = $this->session->userdata("user_id");
	$jenisUser = $this->session->userdata("id_jenis_user");
	$where_bawahan = '';
	if($jenisUser=='1016'){
		$where_bawahan = " HGTD.ID_GSM = '{$id_user}'";
	}else if($jenisUser=='1010'){
		$where_bawahan = " HGTD.ID_SSM =  '{$id_user}'";
	}else if($jenisUser=='1011'){
		$where_bawahan = " HGTD.ID_SM =  '{$id_user}'";
	}else if($jenisUser=='1012'){
		$where_bawahan = " HGTD.ID_SO =  '{$id_user}'";
	}else if($jenisUser=='1013'){
		$where_bawahan = "DISTRIBUTOR";
	}else if($jenisUser=='1017'){
		$where_bawahan = "SPC";
	}
	 
	
	$listFilterBy = explode('-', $_POST['listFilterByVal']);
	$listFilterByVal = $listFilterBy[0];
	$brand = $_POST['listFilterSetVal']; 
	$filterTahun = $_POST['filterTahun'];
	$filterBulan = str_pad($_POST['filterBulan'], 2, "0", STR_PAD_LEFT);
	$filterMinggu = $_POST['filterMinggu']; 
	
		$getBy = $this->M_level_stok->getBy($listFilterByVal); 
		$Datagraph = array();
		$Datagraph_Order = array(); 
		$jumlahKapasitas = 0;
		$dataTitle = array();
		$dataValue = array();
		foreach($getBy as $v){
			$getStok = $this->M_level_stok->getTotal( $listFilterByVal, $v['ID'], $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $brand );  
			$getKapasitasToko = $this->M_level_stok->getKapasitasToko1($v['ID'], $listFilterByVal, $where_bawahan ); 
			$jumlahStok = 0;
			
			foreach($getStok as $s){ 
				if($s['STOK_PRODUK_SIG']!=''){  
					$jumlahStok += floatval($s['STOK_PRODUK_SIG']);
				}
			}
			
			$jumlahKapasitas = (count($getKapasitasToko)> 0 ? $getKapasitasToko[0]['KAPASITAS_ZAK'] : 0); 
			$jumlahTotal = $jumlahStok==0 || $jumlahKapasitas == 0 ? 0 :  ($jumlahStok / $jumlahKapasitas) * 100;
			array_push($dataTitle, $v['NAME']);
			array_push($dataValue, floatval($jumlahTotal));
			$datas['name'] = $v['NAME'];
			$datas['y'] = floatval($jumlahTotal);  
			$datas['id'] = $v['ID'];  
			$datas['jumlahStok'] = floatval($jumlahStok);  
			$datas['jumlahKapasitas'] = floatval($jumlahKapasitas);   
			$Datagraph[] = $datas;
		}
		// echo "<pre>";
		// 	print_r($dataValue);
		// 	echo "</pre>";
		// exit;
		
		echo json_encode(array('dataTitle' => $dataTitle,'dataValue' => $dataValue  ,'Datagraph' => $Datagraph  ));  
	} 
	
	
	public function List_sig(){
		$data = array();
			
		$list = $this->M_level_stok->getSig();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$data[]  = array(
					$list_Val->GROUP_ID,
					$list_Val->JENIS_PRODUK
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

     
    
}
