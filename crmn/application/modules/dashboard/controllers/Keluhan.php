
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluhan extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('M_keluhan'); 
	}
	//fungsi yang digunakan untuk pemanggilan halaman home
	public function index()
	{
		$data['title'] = "Dashboard Keluhan  Brand TR"; 
		
		$this->template->display('keluhan', $data); 
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
	
		$getKeluhan = $this->M_keluhan->getTotalKeluhan($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $brand); 
		$getTidakKeluhan = $this->M_keluhan->getTotalTidakKeluhan($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $brand); 
		 
		$Datagraph = array();
		$DatagraphPromosi = array();
		$daftarKeluhan = array('SEMEN MEMBATU', 'SEMEN TERLAMBAT DATANG', 'KANTONG TIDAK KUAT', 'HARGA TIDAK STABIL', 'SEMEN RUSAK SAAT DITERIMA', 'TOP KURANG LAMA', 'PEMESANAN SULIT', 'KOMPLAIN SULIT', 'STOK SERING KOSONG', 'PROSEDUR RUMIT', 'TIDAK SESUAI SPESIFIKASI', 'KELUHAN LAIN LAIN');
		$daftarPromosi = array('BONUS SEMEN', 'BONUS WISATA', 'POINT REWARD', 'VOUCHER', 'POTONGAN HARGA');
		$dataDaftarKeluhan = array();
		$dataDaftarPromosi = array();
		
		foreach($getKeluhan as $v){
			$datas['name'] = 'Ada Keluhan';
			$datas['y'] = floatval($v['TOTAL_KELUHAN']);   
			$dataDaftarKeluhan = array(
										floatval($v['SEMEN_MENBATU']), 
										floatval($v['SEMEN_TERLAMBAT_DATANG']),
										floatval($v['KANTONG_TIDAK_KUAT']),
										floatval($v['HARGA_TIDAK_STABIL']),
										floatval($v['SEMEN_RUSAK_SAAT_DITERIMA']),
										floatval($v['TOP_KURANG_LAMA']),
										floatval($v['PEMESANAN_SULIT']),
										floatval($v['KOMPLAIN_SULIT']),
										floatval($v['STOK_SERING_KOSONG']),
										floatval($v['PROSEDUR_RUMIT']),
										floatval($v['TIDAK_SESUAI_SPESIFIKASI']),
										floatval($v['KELUHAN_LAIN_LAIN'])
									);
			$Datagraph[] = $datas;
		}
		foreach($getTidakKeluhan as $v){
			$datas['name'] = 'Tidak Ada Keluhan';
			$datas['y'] = floatval($v['TOTAL_TIDAK_ADA_KELUHAN']);   
			$Datagraph[] = $datas;
		}
		 
		echo json_encode(array(
		 'keluhan' => $Datagraph
		,'daftarKeluhan' => $daftarKeluhan
		,'dataDaftarKeluhan' => $dataDaftarKeluhan  
		));  
	} 
     
	public function List_region(){
		$data = array(); 
		$id_user = $this->session->userdata("user_id");
		$jenisUser = $this->session->userdata("id_jenis_user"); 
		$list = $this->M_keluhan->getRegion($id_user, $jenisUser);
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
			
		$list = $this->M_keluhan->getProvinsi();
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
			
		$list = $this->M_keluhan->getArea();
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
			
		$list = $this->M_keluhan->getDistrik();
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
			
		$list = $this->M_keluhan->getBrand();
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
