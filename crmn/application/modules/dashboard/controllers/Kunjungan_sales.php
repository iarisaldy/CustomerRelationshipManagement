
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kunjungan_sales extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('M_kunjungan_sales'); 
	}
	//fungsi yang digunakan untuk pemanggilan halaman home
	public function index()
	{
		$data['title'] = "Dashboard Kunjungan Sales"; 
		
		$this->template->display('kunjungan_sales', $data); 
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
	
		$getProdukGroup = $this->M_kunjungan_sales->getMrDetail('41'); 
		$Datagraph = array();
		$Datagraph_Order = array(); 
		$total_kunjungan = 0;
		foreach($getProdukGroup as $v){
			$getKunjungan = $this->M_kunjungan_sales->getTotal($v['NO_DETAIL'] , $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan); 
			$total_kunjungan = (count($getKunjungan)> 0 ? count($getKunjungan) : 0); 
			$datas['name'] = $v['NAMA_DETAIL'];
			$datas['y'] = floatval($total_kunjungan);   
			$Datagraph[] = $datas;
		}
		
		$getProdukGroup = $this->M_kunjungan_sales->getMrDetail('42'); 
		$total_kunjungan = 0;
		foreach($getProdukGroup as $o){ 
			$getOrder = $this->M_kunjungan_sales->getTotal($o['NO_DETAIL'] , $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan); 
			$total_order = (count($getOrder)> 0 ? count($getOrder) : 0);
			$data['name'] = $o['NAMA_DETAIL'];
			$data['y'] = floatval($total_kunjungan);   
			$Datagraph_Order[] = $data;
		} 
		echo json_encode(array('kunjungan' => $Datagraph,
		'order' => $Datagraph_Order ));  
	} 
     
    
}
