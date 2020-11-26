
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Harga_competitor_wpm extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('M_harga_competitor_wpm'); 
	}
	//fungsi yang digunakan untuk pemanggilan halaman home
	public function index()
	{
		$data['title'] = "Dashboard Harga Competitor All SKU WPM"; 
		
		// $week_array = $this->getStartAndEndDate(1,2020);
		// print_r($week_array);
		
		$this->template->display('harga_competitor_wpm', $data); 
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
	$kemasan = $_POST['kemasan'];
	$kategori = $_POST['kategori'];
	
		$getProdukGroup = $this->M_harga_competitor_wpm->getProdukGroup($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $kemasan, $kategori); 
		$Datagraph = array();
		$GrafikBeli = array();
		$GrafikJual = array(); 
		$ValueBeli = array();
		$ValueJual = array(); 
		$Bsp = 0;$Bst = 0;$Bsg = 0;$Bsbi = 0; 
		
			if($filterBulan=='ALL'){
				$labelBM = array('Jan', 'Feb', 'Mar', 'Apr','May','Jun',	'Jul','Aug','Sep','Oct','Nov','Dec'); 
			}else{ 
				$labelBM = array('Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4','Minggu 5'); 
			}	 
		foreach($getProdukGroup as $v){
			$getHargaBeli = $this->M_harga_competitor_wpm->getHarga($v['GROUP_ID'], 'BELI', $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $kemasan, $kategori);
			$getHargaJual = $this->M_harga_competitor_wpm->getHarga($v['GROUP_ID'], 'JUAL', $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $where_bawahan, $kemasan, $kategori);
			$beli = (count($getHargaBeli)> 0 ? $getHargaBeli[0]['HARGA_PEMBELIAN'] : '0');
			$jual = (count($getHargaJual)> 0 ? $getHargaJual[0]['HARGA_PENJUALAN'] : '0');
			$datas['GROUP_ID'] = $v['GROUP_ID'];
			$datas['JENIS_PRODUK'] = $v['JENIS_PRODUK'];
			$datas['HARGA_BELI'] = $beli;
			$datas['HARGA_JUAL'] = $jual;
			$datas['MARGIN'] = intval($jual)- intval($beli);
			
			if($v['GROUP_ID']=='1'){
				$Bsp = $beli;
			}else if($v['GROUP_ID']=='2'){
				$Bst = $beli;
			}else if($v['GROUP_ID']=='3'){
				$Bsg = $beli;
			}else if($v['GROUP_ID']=='6'){
				$Bsbi = $beli;
			} 
			$Datagraph[] = $datas;
			
			
			$dataB['name'] = $v['JENIS_PRODUK'];
			$dataJ['name'] = $v['JENIS_PRODUK'];
			if($filterBulan=='ALL'){
				$bulanss = floatval(date('m'));
				for($j=1;$j<=$bulanss;$j++){
					$dateObj   = DateTime::createFromFormat('!m', $j);
					$monthName = $dateObj->format('F');
					$Bulan = str_pad($j, 2, "0", STR_PAD_LEFT);
					$getHargaBeli = $this->M_harga_competitor_wpm->getHarga($v['GROUP_ID'], 'BELI', $listFilterByVal, $listFilterSetVal, $filterTahun, $Bulan, $filterMinggu, $where_bawahan, $kemasan, $kategori);
					$getHargaJual = $this->M_harga_competitor_wpm->getHarga($v['GROUP_ID'], 'JUAL', $listFilterByVal, $listFilterSetVal, $filterTahun, $Bulan, $filterMinggu, $where_bawahan, $kemasan, $kategori);
					$beli = (count($getHargaBeli)> 0 ? $getHargaBeli[0]['HARGA_PEMBELIAN'] : '0');
					$jual = (count($getHargaJual)> 0 ? $getHargaJual[0]['HARGA_PENJUALAN'] : '0');
					array_push($ValueBeli, floatval($beli));
					array_push($ValueJual, floatval($jual)); 
				}
			}else{
				for($j=1;$j<=5;$j++){
					$getHargaBeli = $this->M_harga_competitor_wpm->getHarga($v['GROUP_ID'], 'BELI', $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $j, $where_bawahan, $kemasan, $kategori);
					$getHargaJual = $this->M_harga_competitor_wpm->getHarga($v['GROUP_ID'], 'JUAL', $listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $j, $where_bawahan, $kemasan, $kategori);
					$beli = (count($getHargaBeli)> 0 ? $getHargaBeli[0]['HARGA_PEMBELIAN'] : '0');
					$jual = (count($getHargaJual)> 0 ? $getHargaJual[0]['HARGA_PENJUALAN'] : '0');
					array_push($ValueBeli, floatval($beli));
					array_push($ValueJual, floatval($jual));  
				}
			}
			$dataB['data'] = $ValueBeli;
			$dataJ['data'] = $ValueJual;
			
			$GrafikBeli[] = $dataB;
			$GrafikJual[] = $dataJ; 
			
			$ValueBeli = array();
			$ValueJual = array(); 
		}  
		echo json_encode(array('data' => $Datagraph,
		'Bsp' => $Bsp,
		'Bst' => $Bst,
		'Bsg' => $Bsg,
		'Bsbi' => $Bsbi,
		'GrafikBeli' => $GrafikBeli,
		'GrafikJual' => $GrafikJual,
		'labelBM' => $labelBM));  
	}
	
     private function getStartAndEndDate($week, $year) {
	  $dto = new DateTime();
	  $dto->setISODate($year, $week);
	  $ret['week_start'] = $dto->format('Y-m-d');
	  $dto->modify('+6 days');
	  $ret['week_end'] = $dto->format('Y-m-d');
	  return $ret;
	}

	public function get_cabang()
	{
		if(isset($_POST["id_gelombang"]) && $_POST["id_gelombang"] != "") {
			$q = $this->M_harga_competitor_wpm->get_cabang(intval($_POST["id_gelombang"]));
			$data = array();
			foreach($q as $r) {
				$data[] = array("id"=>$r["id_cabang"], "nm"=>htmlspecialchars($r["nm_cabang"]));
			}
			echo json_encode(array("data"=>$data));
		} else {
			echo json_encode(array("data"=>array()));
		}
	}
     
	public function detail_peserta()
	{ 
			$id_position =$_POST['id_position'];
			$arrPosition =explode(',', $_POST['id_position']);
			$getPosisi = $this->M_harga_competitor_wpm->get_Posisi($id_position);
			$labelPosisi = array();   
			$dataPosisi = array();   
			foreach ( $getPosisi as $val ) { 
				$total= 0;
				array_push($labelPosisi, $val['name']);
				foreach($arrPosition as $p){ 
					if(intval($val['id'])==intval($p)){
						$total+= 1;
					} 
				} 
				
				array_push($dataPosisi, $total);
			}
			$posisiCharts['labels'] = $labelPosisi;
			$posisiCharts['data'] = $dataPosisi;
			
 
			echo json_encode(array("data"=>$posisiCharts));
	 
	}
	
	
	
	
	public function List_region(){
		$data = array(); 
		$id_user = $this->session->userdata("user_id");
		$jenisUser = $this->session->userdata("id_jenis_user"); 
		$list = $this->M_harga_competitor_wpm->getRegion($id_user, $jenisUser);
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
			
		$list = $this->M_harga_competitor_wpm->getProvinsi();
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
			
		$list = $this->M_harga_competitor_wpm->getArea();
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
			
		$list = $this->M_harga_competitor_wpm->getDistrik();
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

     
    
}
