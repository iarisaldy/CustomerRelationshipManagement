
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promosi extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('M_promosi'); 
	}
	//fungsi yang digunakan untuk pemanggilan halaman home
	public function index()
	{
		$data['title'] = "Dashboard Promosi Brand TR"; 
		
		$this->template->display('promosi', $data); 
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
	$brand = $_POST['brand'];
	
		 $getPromosi = $this->M_promosi->getPromosi($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $brand); 
		$getTidakPromosi = $this->M_promosi->getTidakPromosi($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $brand); 
		
		$Datagraph = array();
		$DatagraphPromosi = array();
		$daftarKeluhan = array('SEMEN MEMBATU', 'SEMEN TERLAMBAT DATANG', 'KANTONG TIDAK KUAT', 'HARGA TIDAK STABIL', 'SEMEN RUSAK SAAT DITERIMA', 'TOP KURANG LAMA', 'PEMESANAN SULIT', 'KOMPLAIN SULIT', 'STOK SERING KOSONG', 'PROSEDUR RUMIT', 'TIDAK SESUAI SPESIFIKASI', 'KELUHAN LAIN LAIN');
		$daftarPromosi = array('BONUS SEMEN', 'BONUS WISATA', 'POINT REWARD', 'VOUCHER', 'POTONGAN HARGA');
		$dataDaftarKeluhan = array();
		$dataDaftarPromosi = array();
		
		 
		foreach($getPromosi as $v){
			$datas['name'] = 'Ada Promosi';
			$datas['y'] = floatval($v['TOTAL_PROMOSI']);   
			$dataDaftarPromosi = array(
										floatval($v['BONUS_SEMEN']), 
										floatval($v['BONUS_WISATA']),
										floatval($v['POINT_REWARD']),
										floatval($v['VOUCER']),
										floatval($v['POTONGAN_HARGA'])
									);
			$DatagraphPromosi[] = $datas;
		}
		foreach($getTidakPromosi as $v){
			$datas['name'] = 'Tidak Ada Promosi';
			$datas['y'] = floatval($v['TOTAL_TIDAK_PROMOSI']);   
			$DatagraphPromosi[] = $datas;
		}
		// $getProdukGroup = $this->M_promosi->getMrDetail('42'); 
		
		echo json_encode(array( 'promosi' => $DatagraphPromosi 
		,'daftarPromosi' => $daftarPromosi
		,'dataDaftarPromosi' => $dataDaftarPromosi 
		));  
	} 
     
	public function List_region(){
		$data = array(); 
		$id_user = $this->session->userdata("user_id");
		$jenisUser = $this->session->userdata("id_jenis_user"); 
		$list = $this->M_promosi->getRegion($id_user, $jenisUser);
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$region =  $list_Val->REGION;
				$data[]  = array(
					$list_Val->ID_REGION,
					$region
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
	
	public function List_provinsi(){
		$data = array();
			
		$list = $this->M_promosi->getProvinsi();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$data[]  = array(
					$list_Val->ID_PROVINSI,
					$list_Val->NAMA_PROVINSI
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
	
	public function List_area(){
		$data = array();
			
		$list = $this->M_promosi->getArea();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$data[]  = array(
					$list_Val->ID_AREA,
					$list_Val->NAMA_AREA
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
	
	public function List_distrik(){
		$data = array();
			
		$list = $this->M_promosi->getDistrik();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$data[]  = array(
					$list_Val->ID_DISTRIK,
					$list_Val->NAMA_DISTRIK
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
	public function List_brand(){
		$data = array();
			
		$list = $this->M_promosi->getBrand();
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
