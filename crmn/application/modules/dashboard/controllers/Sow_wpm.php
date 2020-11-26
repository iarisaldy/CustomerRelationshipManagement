
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sow_wpm extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('M_sow_wpm'); 
	}
	//fungsi yang digunakan untuk pemanggilan halaman home
	public function index()
	{
		$data['title'] = "Dashboard SOW WPM"; 
		
		$this->template->display('sow_wpm', $data); 
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
	$listFilterSetVal = $_POST['listFilterSetVal'];
	$filterTahun = $_POST['filterTahun'];
	$filterBulan = str_pad($_POST['filterBulan'], 2, "0", STR_PAD_LEFT);
	$filterMinggu = $_POST['filterMinggu'];
	
		$getCustomerAll = $this->M_sow_wpm->getCustomerAll($id_user, $jenisUser, $where_bawahan); 
		$Datagraph = array();
		if(count($getCustomerAll)>0){
		$CustomerAll = '';
		$CustomerGabungan = '';
		$no = 1;
		$no_gabungan = 1;
		$gabung_sendiri = 0;
		foreach($getCustomerAll as $v){
			$CustomerAll .= "'".$v['ID_CUSTOMER']."',";
			if($no>995){
				if($no_gabungan==1){ 
					$CustomerAllC = rtrim($CustomerAll,","); 
					$CustomerGabungan .= " AND VSOTC.KD_CUSTOMER IN ({$CustomerAllC})"; 
				}else{
					$CustomerAllC = rtrim($CustomerAll,","); 
					$CustomerGabungan .= " OR VSOTC.KD_CUSTOMER IN ({$CustomerAllC})"; 
				}
				$CustomerAll = '';
				$no = 1;
				$no_gabungan +=1;
				$gabung_sendiri +=1;
			}
			$no += 1;
		}
		if($gabung_sendiri==0){
			$CustomerAllC = rtrim($CustomerAll,","); 
			$CustomerGabungan .= " AND VSOTC.KD_CUSTOMER IN ({$CustomerAllC})"; 
		}  
			$getKapasitasJual = $this->M_sow_wpm->getKapasitasJual($CustomerAllC, $listFilterByVal, $listFilterSetVal);
			$KapasitasJual = isset($getKapasitasJual['JUMLAH'])  ? $getKapasitasJual['JUMLAH'] : '1'; 
			$getProdukSIG = $this->M_sow_wpm->getProdukSIG(); 
			
			$Datagraph_Order = array(); 
			$totalSellout = 0;
			foreach($getProdukSIG as $v){ 
				$getProdukSIDIGI = $this->M_sow_wpm->getProdukSIDIGI($v['GROUP_ID']);  
				if(count($getProdukSIDIGI)>0){
					$wProduk = '';
					foreach($getProdukSIDIGI as $s){
						$wProduk .= "'".$s['KD_PRODUK']."',";
					}
					$whProduk = rtrim($wProduk, ","); 
					$getSellout = $this->M_sow_wpm->getSellout($CustomerGabungan, $whProduk, $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu);  
					$datas['name'] = $v['JENIS_PRODUK']; 
					$totalSellout = (count($getSellout) > 0 ? floatval($getSellout['JUMLAH']) : 0);  
					if($totalSellout>0){ 
						$datas['y'] = ($totalSellout/$KapasitasJual)*100;   
						$datas['totalSellout'] = $totalSellout ;   
						$datas['KapasitasJual'] =  $KapasitasJual;   
						$Datagraph[] = $datas;
					}
					
				}
			} 
			//$getProduknonSIG = $this->M_sow_wpm->getProduknonSIG($CustomerAllC, $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu);  
			$getProduknonSIG = $this->M_sow_wpm->getProduknonSIG1();  
			 
			foreach($getProduknonSIG as $v){
				$getSelloutNONSIG = $this->M_sow_wpm->getSelloutNONSIG($CustomerAllC,$v['GROUP_ID'], $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu );
				$datas['name'] = $v['JENIS_PRODUK'];  
				$totalSellout = 0;
				foreach($getSelloutNONSIG as $s){
					$totalSellout += $s['TOTAL'];
				}
				  
				$datas['y'] = ($totalSellout/$KapasitasJual)*100;   
				$datas['totalSellout'] = $totalSellout ;   
				$datas['KapasitasJual'] =  $KapasitasJual;   
				$Datagraph[] = $datas;
			}
		}
		echo json_encode(array('kunjungan' => $Datagraph,  ));  
	} 
     
    
}
