<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Project_Toko extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Project_Toko_model", "mProject");
		
	}

	public function index(){
		
		//print_r($this->session->userdata());
		//exit();
		
		$id_user = $this->session->userdata("user_id");
		$jenisUser = $this->session->userdata("id_jenis_user");
		$bulan = date('m');
		$tahun = date('Y');
			
		if (isset($_POST["filterBulan"]) and isset($_POST["filterTahun"])) {
			if($_POST["filterBulan"] < 10){
				$this->session->set_userdata('set_bulan', $bulan);
				$bulan = "0".$_POST["filterBulan"];
			} else {
				$bulan = $_POST["filterBulan"];
			}
			$tahun = $_POST["filterTahun"];
			$this->session->set_userdata('set_tahun', $tahun);
		}
		$this->session->set_userdata('set_bulan', $bulan);
		$this->session->set_userdata('set_tahun', $tahun);
		
        $data = array("title"=>"Dashboard CRM Administrator");
        
		$filterBy = null; $filterSet = null;
		$this->session->set_userdata('set_filterBy', "ALL");
		$this->session->set_userdata('set_filterSet', "~");
		if (isset($_POST["FilterBy"]) and isset($_POST["FilterSet"])){
			if($_POST["FilterBy"] != 0){
				$By = explode("-",$_POST["FilterBy"]);
				$Set = explode("-",$_POST["FilterSet"]);
				$filterBy = $By[0]; 
				$filterSet = $Set[0];
				$this->session->set_userdata('set_filterBy', $By[1]);
				$this->session->set_userdata('set_filterSet', $Set[1]);
				//print_r($filterBy." ".$filterSet);
				//exit;
			}
		} 

		$dt_project = $this->mProject->getProject($filterBy, $filterSet);


		// print_r('<pre>');
		// print_r($dt_project);exit;

		$arr_tgl = array();

		$vol = 0;
		$tot_vol = 0;
		$rata = 0;
		foreach ($dt_project as $prj) {

			$list_tgl = $this->mProject->getListTanggal($prj['START_PROJECT'], $prj['END_PROJECT'], $bulan, $tahun);

			// print_r('<pre>');
			// print_r($list_tgl);exit;

			
			if (!empty($list_tgl)) {
				foreach ($list_tgl as $tgl) {
					$arr_tgl[] = array(
						'TAHUN'	=> $tgl['TAHUN'],
						'BULAN'	=> $tgl['BULAN'],
						'HARI'	=> $tgl['HARI'],
						'VOLUME'	=> $prj['VOL_HARI']
					);
				}
			} else {

				for ($i=1; $i <= date('t', strtotime($tahun.'-'.$bulan)); $i++) { 
					$arr_tgl[] = array(
						'TAHUN'	=> $tahun,
						'BULAN'	=> $bulan,
						'HARI'	=> str_pad($i,2,"0",STR_PAD_LEFT),
						'VOLUME'	=> 0
					);
				}

			}

		}

		// print_r('<pre>');
		// print_r($arr_tgl);exit;

		$list_week = $this->mProject->getListWeek($bulan, $tahun);
		$distinct_week = $this->mProject->getDistinctWeek($bulan, $tahun);

		for ($i=1; $i <= count($distinct_week); $i++) { 
			foreach ($arr_tgl as $dt) {
				foreach ($list_week as $wk) {
					if ($dt['TAHUN'] == $wk['TAHUN'] && $dt['BULAN'] == $wk['BULAN'] && $dt['HARI'] == $wk['HARI'] && $wk['WEEKS'] == $i) {
						$arr_tanggal[] = array(
							'TAHUN'	=> $dt['TAHUN'],
							'BULAN'	=> $dt['BULAN'],
							'WEEK'	=> $wk['WEEKS'],
							'HARI'	=> $dt['HARI'],
							'VOLUME'	=> $dt['VOLUME']
						);

						$vol += $dt['VOLUME'];
					}
				}
			}

			$arr_tanggal2[$i-1] = array(
				'WEEK'	=> $i,
				'VOLUME'	=> $vol
			);

			// print_r('<pre>');
			// print_r($tot_vol);exit;
		}

		// print_r('<pre>');
		// print_r($arr_tanggal2);exit;

		foreach ($arr_tanggal2 as $k => $v) {


			$rata = $arr_tanggal2[count($distinct_week) - 1]['VOLUME'] / count($distinct_week);

			if ($k == 0) {

				$arr[] = (object)array(
					'WEEK'	=> $v['WEEK'],
					'VOLUME'	=> round($v['VOLUME'], 2),
					'RATA'	=> round($rata, 2)
				);
			
			} elseif ($k > 0) {
				
				$before = $k - 1;

				$vol_now = $v['VOLUME'] - $arr_tanggal2[$before]['VOLUME'];
				// print_r('<pre>');
				// print_r($rata);exit;

				$arr[] = (object)array(
					'WEEK'	=> $v['WEEK'],
					'VOLUME'	=> round($vol_now, 2),
					'RATA'	=> round($rata, 2)
				);

			}
		
		}

		// print_r('<pre>');
		// print_r($arr);exit;
		$data['project'] = $arr;

		// print_r('<pre>');
		// print_r($week);exit;

		$this->template->display('Project_Toko_view', $data);
    }
	
	public function List_region(){
		$data = array();
			
		$list = $this->mProject->getRegion();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$region = "REGIONAL ".$list_Val->REGION;
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
			
		$list = $this->mProject->getProvinsi();
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
			
		$list = $this->mProject->getArea();
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
	
	public function List_distributor(){
		$data = array();
			
		$list = $this->mProject->getDistributor();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$data[]  = array(
					$list_Val->KODE_DISTRIBUTOR,
					$list_Val->NAMA_DISTRIBUTOR
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
			
		$list = $this->mProject->getDistriK();
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

?>