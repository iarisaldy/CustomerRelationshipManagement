
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pmb_dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('M_pmb_dashboard'); 
	}
	//fungsi yang digunakan untuk pemanggilan halaman home
	public function index()
	{
		$data['title'] = "PMB Dashboard"; 
		
		$data['coverage'] = $this->M_pmb_dashboard->valCoverage();
		$data['noo'] = $this->M_pmb_dashboard->valNOO();
		$data['sell_in'] = $this->M_pmb_dashboard->valSellin();
		$data['revenue'] = $this->M_pmb_dashboard->valRevenue();
		$data['sell_out'] = $this->M_pmb_dashboard->valSellOut();
		$data['visit'] = $this->M_pmb_dashboard->valVisit();
		$data['so_cc'] = $this->M_pmb_dashboard->valSOCC();
		$data['target'] = $this->M_pmb_dashboard->valTarget();
		$data['target2'] = $this->M_pmb_dashboard->valTarget2();
		$this->template->display('pmb_dashboard', $data); 
	}
	
	 public function get_data_dist()
    { 
        $s = $this->input->post('search') != null ? $this->input->post('search')["value"] : "";
		$p = $this->input->post('start') != null && $this->input->post('start') != "" && is_numeric($this->input->post('start')) ? intval($this->input->post('start')) : 0;
		$e = $this->input->post('length') != null && $_POST["length"] != "" && is_numeric($_POST["length"]) ? intval($_POST["length"]) : 10;
		$c = array("NAMA_DISTRIBUTOR","NAMA_DISTRIBUTOR");
		$o = isset($_POST["order"]) ? array($c[intval($_POST["order"][0]["column"])], strtoupper($_POST["order"][0]["dir"])) : array($c[0], "ASC");
		
		$jenisUser = $this->session->userdata("id_jenis_user");
	
		// $listFilterBy = explode('-', $_POST['listFilterByVal']);
		// $listFilterByVal = $listFilterBy[0];
		// $listFilterSetVal = $_POST['listFilterSetVal'];
		// $filterTahun = $_POST['filterTahun'];
		// $filterBulan = str_pad($_POST['filterBulan'], 2, "0", STR_PAD_LEFT);
		// $filterMinggu = $_POST['filterMinggu'];
		
		$hasil = $this->M_pmb_dashboard->get_dist($s, $p, $e, $c, $o);
		
		$result["draw"] = isset($_POST["draw"]) ? intval($_POST["draw"]) : 1;
		$result["recordsTotal"] = intval($hasil["total"]);
		$result["recordsFiltered"] = intval($hasil["filtered"]);
		$result["data"] = array();
		
		$thn = DATE('yy');
		$bln = DATE('m');
		$arr_dist = array();
		$ada = array();
		$isi = array("tu_t"=>0, "tu_a"=>0, "ta_t"=>0, "ta_a"=>0, "so_t"=>0, "so_a"=>0, "vol_t"=>0, "vol_a"=>0, "rev_t"=>0, "rev_a"=>0, "vso_t"=>0, "vso_a"=>0, "acp_t"=>0, "acp_a"=>0 );
		$arrayr = array();
		
		foreach($hasil["data"] as $h) {
			$arr_dist[] = "'".$h["KODE_DISTRIBUTOR"]."'";
		}
		
		if(count($arr_dist) > 0) {
			$get_data_vol_rev = $this->M_pmb_dashboard->get_data_dist();
			$get_data_ta_vso = $this->M_pmb_dashboard->get_data_dist_ta($bln, $thn);
			$get_data_tu = $this->M_pmb_dashboard->get_data_dist_tu($bln, $thn);
			$get_data_so = $this->M_pmb_dashboard->get_data_dist_so();
			$get_data_target = $this->M_pmb_dashboard->get_data_dist_target();
			foreach($get_data_vol_rev as $r) {
				$arrayr = $r;
				if(!isset($ada[$r["KODE_DISTRIBUTOR"]])) {
					$ada[$r["KODE_DISTRIBUTOR"]] = array();
					$arrayr = array_merge($r,$isi);
				}
				$ada[$r["KODE_DISTRIBUTOR"]][] = $arrayr;
				
				$ada[$r['KODE_DISTRIBUTOR']][0]['vol_a']+=intval($r['VOLUME']);
				$ada[$r['KODE_DISTRIBUTOR']][0]['rev_a']+=intval($r['REVENUE']);
			}
			
			foreach($get_data_ta_vso as $r) {
				$arrayr = $r;
				if(!isset($ada[$r["KODE_DISTRIBUTOR"]])) {
					$ada[$r["KODE_DISTRIBUTOR"]] = array();
					$arrayr = array_merge($r,$isi);
				}
				$ada[$r["KODE_DISTRIBUTOR"]][] = $arrayr;
				
				$ada[$r['KODE_DISTRIBUTOR']][0]['vso_a']+=intval($r['POIN']);
				$ada[$r['KODE_DISTRIBUTOR']][0]['ta_a']+=intval($r['JUMLAH']);
			}
			
			foreach($get_data_tu as $r) {
				$arrayr = $r;
				if(!isset($ada[$r["KODE_DISTRIBUTOR"]])) {
					$ada[$r["KODE_DISTRIBUTOR"]] = array();
					$arrayr = array_merge($r,$isi);
				}
				$ada[$r["KODE_DISTRIBUTOR"]][] = $arrayr;
				
				$ada[$r['KODE_DISTRIBUTOR']][0]['tu_a']+=intval($r['JUMLAH']);
			}
			
			foreach($get_data_so as $r) {
				$arrayr = $r;
				if(!isset($ada[$r["KODE_DISTRIBUTOR"]])) {
					$ada[$r["KODE_DISTRIBUTOR"]] = array();
					$arrayr = array_merge($r,$isi);
				}
				$ada[$r["KODE_DISTRIBUTOR"]][] = $arrayr;
				
				$ada[$r['KODE_DISTRIBUTOR']][0]['so_a']+=intval($r['JUMLAH']);
			}
			
			foreach($get_data_target as $r) {
				$arrayr = $r;
				if(!isset($ada[$r["KD_DISTRIBUTOR"]])) {
					$ada[$r["KD_DISTRIBUTOR"]] = array();
					$arrayr = array_merge($r,$isi);
				}
				$ada[$r["KD_DISTRIBUTOR"]][] = $arrayr;
				
				$ada[$r['KD_DISTRIBUTOR']][0]['so_t']+=intval($r['SO_CLEAN_CLEAR']);
				$ada[$r['KD_DISTRIBUTOR']][0]['vol_t']+=intval($r['VOLUME']);
				$ada[$r['KD_DISTRIBUTOR']][0]['rev_t']+=intval($r['REVENUE']);
				$ada[$r['KD_DISTRIBUTOR']][0]['tu_t']+=intval($r['TOKO_UNIT']);
				$ada[$r['KD_DISTRIBUTOR']][0]['vso_t']+=intval($r['SELL_OUT']);
				$ada[$r['KD_DISTRIBUTOR']][0]['ta_t']+=intval($r['TOKO_AKTIF']);
			}
		}
		
		$baris = 0;
		
		foreach($hasil["data"] as $r) {
			$tu_a = 0;
			$ta_a = 0;
			$so_a = 0;
			$vol_a = 0;
			$rev_a = 0;
			$vso_a = 0;
			$tu_t = 0;
			$ta_t = 0;
			$so_t = 0;
			$vol_t = 0;
			$rev_t = 0;
			$vso_t = 0;
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['ta_a'])) { 
			$ta_a = $ada[$r['KODE_DISTRIBUTOR']][0]['ta_a'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['tu_a'])) { 
			$tu_a = $ada[$r['KODE_DISTRIBUTOR']][0]['tu_a'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['vso_a'])) { 
			$vso_a = $ada[$r['KODE_DISTRIBUTOR']][0]['vso_a'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['so_a'])) { 
			$so_a = $ada[$r['KODE_DISTRIBUTOR']][0]['so_a'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['vol_a'])) { 
			$vol_a = $ada[$r['KODE_DISTRIBUTOR']][0]['vol_a'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['rev_a'])) { 
			$rev_a = $ada[$r['KODE_DISTRIBUTOR']][0]['rev_a'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['tu_t'])) { 
			$tu_t = $ada[$r['KODE_DISTRIBUTOR']][0]['tu_t'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['ta_t'])) { 
			$ta_t = $ada[$r['KODE_DISTRIBUTOR']][0]['ta_t'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['so_t'])) { 
			$so_t = $ada[$r['KODE_DISTRIBUTOR']][0]['so_t'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['vol_t'])) { 
			$vol_t = $ada[$r['KODE_DISTRIBUTOR']][0]['vol_t'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['rev_t'])) { 
			$rev_t = $ada[$r['KODE_DISTRIBUTOR']][0]['rev_t'];
			}
			if(isset($ada[$r['KODE_DISTRIBUTOR']][0]['vso_t'])) { 
			$vso_t = $ada[$r['KODE_DISTRIBUTOR']][0]['vso_t'];
			}
			$tu_p = $tu_t == 0  ? "Target Kosong" : ($tu_a > $tu_t ? "100 %" : number_format((($tu_a/$tu_t)*100),2)." %");
			$ta_p = $ta_t == 0  ? "Target Kosong" : ($ta_a > $ta_t ? "100 %" : number_format((($ta_a/$ta_t)*100),2)." %");
			$so_p = $so_t == 0  ? "Target Kosong" : ($so_a > $so_t ? "100 %" : number_format((($so_a/$so_t)*100),2)." %");
			$vol_p = $vol_t == 0 ? "Target Kosong" : ($vol_a > $vol_t ? "100 %" : number_format((($vol_a/$vol_t)*100),2)." %");
			$rev_p = $rev_t == 0 ? "Target Kosong" : ($rev_a > $rev_t ? "100 %" : number_format((($rev_a/$rev_t)*100),2)." %");
			$vso_p = $vso_t == 0 ? "Target Kosong" : ($vso_a > $vso_t ? "100 %" : number_format((($vso_a/$vso_t)*100),2)." %");
			$result["data"][] = array(
				htmlspecialchars($baris+1),
				htmlspecialchars($r["NAMA_DISTRIBUTOR"]),
				htmlspecialchars(number_format($tu_t)),
				htmlspecialchars(number_format($tu_a)),
				htmlspecialchars($tu_p),
				htmlspecialchars(number_format($ta_t)),
				htmlspecialchars(number_format($ta_a)),
				htmlspecialchars($ta_p),
				htmlspecialchars(number_format($so_t)),
				htmlspecialchars(number_format($so_a)),
				htmlspecialchars($so_p),
				htmlspecialchars(number_format($vol_t)),
				htmlspecialchars(number_format($vol_a)),
				htmlspecialchars($vol_p),
				htmlspecialchars(number_format($rev_t)),
				htmlspecialchars(number_format($rev_a)),
				htmlspecialchars($rev_p),
				htmlspecialchars(number_format($vso_t)),
				htmlspecialchars(number_format($vso_a)),
				htmlspecialchars($vso_p),
				"",
				"",
				""
			);
			$baris++;
		}
		
		echo json_encode($result);

    }
	
	 public function get_data_sales()
    { 
        $s = $this->input->post('search') != null ? $this->input->post('search')["value"] : "";
		$p = $this->input->post('start') != null && $this->input->post('start') != "" && is_numeric($this->input->post('start')) ? intval($this->input->post('start')) : 0;
		$e = $this->input->post('length') != null && $_POST["length"] != "" && is_numeric($_POST["length"]) ? intval($_POST["length"]) : 10;
		$c = array("USERNAME","USERNAME");
		$o = isset($_POST["order"]) ? array($c[intval($_POST["order"][0]["column"])], strtoupper($_POST["order"][0]["dir"])) : array($c[0], "ASC");
		
		$jenisUser = $this->session->userdata("id_jenis_user");
	
		// $listFilterBy = explode('-', $_POST['listFilterByVal']);
		// $listFilterByVal = $listFilterBy[0];
		// $listFilterSetVal = $_POST['listFilterSetVal'];
		// $filterTahun = $_POST['filterTahun'];
		// $filterBulan = str_pad($_POST['filterBulan'], 2, "0", STR_PAD_LEFT);
		// $filterMinggu = $_POST['filterMinggu'];
		
		$hasil = $this->M_pmb_dashboard->get_sales($s, $p, $e, $c, $o);
		
		$result["draw"] = isset($_POST["draw"]) ? intval($_POST["draw"]) : 1;
		$result["recordsTotal"] = intval($hasil["total"]);
		$result["recordsFiltered"] = intval($hasil["filtered"]);
		$result["data"] = array();
		
		$arr_sales = array();
		$ada = array();
		$isi = array("tu_t"=>0, "tu_a"=>0, "ks_t"=>0, "ks_a"=>0, "ta_t"=>0, "ta_a"=>0, "tb_t"=>0, "tb_a"=>0, "vso_t"=>0, "vso_a"=>0, "vso_bk_t"=>0, "vso_bk_a"=>0 );
		$arrayr = array();
		
		foreach($hasil["data"] as $h) {
			$arr_sales[] = "'".$h["ID_SALES"]."'";
		}
		if(count($arr_sales) > 0) {
			$get_data_visit = $this->M_pmb_dashboard->get_data_sales_visit();
			$get_data_target = $this->M_pmb_dashboard->get_data_sales_target();
			foreach($get_data_visit as $r) {
				$arrayr = $r;
				if(!isset($ada[$r["ID_SALES"]])) {
					$ada[$r["ID_SALES"]] = array();
					$arrayr = array_merge($r,$isi);
				}
				$ada[$r["ID_SALES"]][] = $arrayr;
				
				$ada[$r['ID_SALES']][0]['ks_a']+=intval($r['JUMLAH']);
				$ada[$r['ID_SALES']][0]['ks_t']+=intval($r['TARGET']);
			}
			
			foreach($get_data_target as $r) {
				$arrayr = $r;
				if(!isset($ada[$r["ID_SALES"]])) {
					$ada[$r["ID_SALES"]] = array();
					$arrayr = array_merge($r,$isi);
				}
				$ada[$r["ID_SALES"]][] = $arrayr;
				
				$ada[$r['ID_SALES']][0]['tu_t']+=intval($r['TOKO_UNIT']);
				$ada[$r['ID_SALES']][0]['ta_t']+=intval($r['TOKO_AKTIF']);
				$ada[$r['ID_SALES']][0]['tb_t']+=intval($r['TOKO_BARU']);
				$ada[$r['ID_SALES']][0]['vso_t']+=intval($r['SELL_OUT_SDG']);
				$ada[$r['ID_SALES']][0]['vso_bk_t']+=intval($r['SELL_OUT_BK']);
			}
		}
		
		$baris = 0;
		
		foreach($hasil["data"] as $r) {
			$tu_a = 0;
			$ks_a = 0;
			$ta_a = 0;
			$tb_a = 0;
			$vso_a = 0;
			$vso_bk_a = 0;
			$tu_t = 0;
			$ks_t = 0;
			$ta_t = 0;
			$tb_t = 0;
			$vso_t = 0;
			$vso_bk_t = 0;
			if(isset($ada[$r['ID_SALES']][0]['tu_a'])) { 
			$tu_a = $ada[$r['ID_SALES']][0]['tu_a'];
			}
			if(isset($ada[$r['ID_SALES']][0]['ks_a'])) { 
			$ks_a = $ada[$r['ID_SALES']][0]['ks_a'];
			}
			if(isset($ada[$r['ID_SALES']][0]['ta_a'])) { 
			$ta_a = $ada[$r['ID_SALES']][0]['ta_a'];
			}
			if(isset($ada[$r['ID_SALES']][0]['tb_a'])) { 
			$tb_a = $ada[$r['ID_SALES']][0]['tb_a'];
			}
			if(isset($ada[$r['ID_SALES']][0]['vso_a'])) { 
			$vso_a = $ada[$r['ID_SALES']][0]['vso_a'];
			}
			if(isset($ada[$r['ID_SALES']][0]['vso_bk_a'])) { 
			$vso_bk_a = $ada[$r['ID_SALES']][0]['vso_bk_a'];
			}
			if(isset($ada[$r['ID_SALES']][0]['tu_t'])) { 
			$tu_t = $ada[$r['ID_SALES']][0]['tu_t'];
			}
			if(isset($ada[$r['ID_SALES']][0]['ks_t'])) { 
			$ks_t = $ada[$r['ID_SALES']][0]['ks_t'];
			}
			if(isset($ada[$r['ID_SALES']][0]['ta_t'])) { 
			$ta_t = $ada[$r['ID_SALES']][0]['ta_t'];
			}
			if(isset($ada[$r['ID_SALES']][0]['tb_t'])) { 
			$tb_t = $ada[$r['ID_SALES']][0]['tb_t'];
			}
			if(isset($ada[$r['ID_SALES']][0]['vso_t'])) { 
			$vso_t = $ada[$r['ID_SALES']][0]['vso_t'];
			}
			if(isset($ada[$r['ID_SALES']][0]['vso_bk_t'])) { 
			$vso_bk_t = $ada[$r['ID_SALES']][0]['vso_bk_t'];
			}
			$tu_p = $tu_t == 0  ? "Target Kosong" : ($tu_a > $tu_t ? "100 %" : number_format((($tu_a/$tu_t)*100),2)." %");
			$ks_p = $ks_t == 0  ? "Target Kosong" : ($ks_a > $ks_t ? "100 %" : number_format((($ks_a/$ks_t)*100),2)." %");
			$ta_p = $ta_t == 0  ? "Target Kosong" : ($ta_a > $ta_t ? "100 %" : number_format((($ta_a/$ta_t)*100),2)." %");
			$tb_p = $tb_t == 0 ? "Target Kosong" : ($tb_a > $tb_t ? "100 %" : number_format((($tb_a/$tb_t)*100),2)." %");
			$vso_p = $vso_t == 0 ? "Target Kosong" : ($vso_a > $vso_t ? "100 %" : number_format((($vso_a/$vso_t)*100),2)." %");
			$vso_bk_p = $vso_bk_t == 0 ? "Target Kosong" : ($vso_bk_a > $vso_bk_t ? "100 %" : number_format((($vso_bk_a/$vso_bk_t)*100),2)." %");
			$result["data"][] = array(
				htmlspecialchars($baris+1),
				htmlspecialchars($r["USERNAME"]),
				htmlspecialchars(number_format($tu_t)),
				htmlspecialchars(number_format($tu_a)),
				htmlspecialchars($tu_p),
				htmlspecialchars(number_format($ks_t)),
				htmlspecialchars(number_format($ks_a)),
				htmlspecialchars($ks_p),
				htmlspecialchars(number_format($ta_t)),
				htmlspecialchars(number_format($ta_a)),
				htmlspecialchars($ta_p),
				htmlspecialchars(number_format($tb_t)),
				htmlspecialchars(number_format($tb_a)),
				htmlspecialchars($tb_p),
				htmlspecialchars(number_format($vso_t)),
				htmlspecialchars(number_format($vso_a)),
				htmlspecialchars($vso_p),
				htmlspecialchars(number_format($vso_bk_t)),
				htmlspecialchars(number_format($vso_bk_a)),
				htmlspecialchars($vso_bk_p)
			);
			$baris++;
		}
		
		echo json_encode($result);

    }
	
	public function refreshDist() {
         
		echo "<option value='' data-hidden='true' selected='selected'>-- Pilih Distributor --</option>"; 
		$id_jenis_user = 1015;
		// $hasil = $this->user_model->get_user_sales($id_jenis_user);
		$data = $this->M_pmb_dashboard->getDist($id_jenis_user);
		foreach($data as $p) { 
			echo "<option value='{$p["KODE_DISTRIBUTOR"]}'  >".htmlspecialchars($p["NAMA_DISTRIBUTOR"]. " ( ID : ".$p["KODE_DISTRIBUTOR"]." )")."</option>";
		}
	}
     public function Monitoring()
    { 
	$id_user = $this->session->userdata("user_id");
	$jenisUser = $this->session->userdata("id_jenis_user");
	
	$listFilterBy = explode('-', $_POST['listFilterByVal']);
	$listFilterByVal = $listFilterBy[0];
	$listFilterSetVal = $_POST['listFilterSetVal'];
	$filterTahun = $_POST['filterTahun'];
	$filterBulan = str_pad($_POST['filterBulan'], 2, "0", STR_PAD_LEFT);
	$filterMinggu = $_POST['filterMinggu'];
	
		$getKeluhan = $this->M_pmb_dashboard->getTotalKeluhan($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $jenisUser); 
		$getTidakKeluhan = $this->M_pmb_dashboard->getTotalTidakKeluhan($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $jenisUser); 
		$getPromosi = $this->M_pmb_dashboard->getPromosi($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $jenisUser); 
		$getTidakPromosi = $this->M_pmb_dashboard->getTidakPromosi($listFilterByVal, $listFilterSetVal, $filterTahun, $filterBulan, $filterMinggu, $jenisUser); 
		
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
		// $getProdukGroup = $this->M_pmb_dashboard->getMrDetail('42'); 
		
		echo json_encode(array(
		 'keluhan' => $Datagraph
		,'daftarKeluhan' => $daftarKeluhan
		,'dataDaftarKeluhan' => $dataDaftarKeluhan 
		,'promosi' => $DatagraphPromosi 
		,'daftarPromosi' => $daftarPromosi
		,'dataDaftarPromosi' => $dataDaftarPromosi 
		));  
	} 
     
	public function List_region(){
		$data = array(); 
		$id_user = $this->session->userdata("user_id");
		$jenisUser = $this->session->userdata("id_jenis_user"); 
		$list = $this->M_pmb_dashboard->getRegion($id_user, $jenisUser);
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
			
		$list = $this->M_pmb_dashboard->getProvinsi();
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
			
		$list = $this->M_pmb_dashboard->getArea();
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
			
		$list = $this->M_pmb_dashboard->getDistrik();
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
