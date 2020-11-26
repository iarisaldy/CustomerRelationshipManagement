<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Dashboard_PMB extends CI_Controller {

	private $filename = "import_data_user"; 	// menententukan nama file'
	
    function __construct(){
        parent::__construct();
		
		$this->load->model('Dashboard_PMB_model');
		$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel'));
    }
	
	public function index_old(){

		$data = array("title"=>"Dashboard CRM");

		$id_user = $this->session->userdata("user_id");
		$id_jenis_user = $this->session->userdata("id_jenis_user");

		$FilterBy = '0-ALL';
		$FilterSet = '0-ALL';
		// $FilterBy = '2-PROVINSI';

		// $getRegion = $this->Dashboard_PMB_model->get_Region_new($id_user, $id_jenis_user);

		// $FilterSet = '';
		// if ($getRegion == '1') {
		// 	$FilterSet = '1011-SUMATERA UTARA';
		// } elseif ($getRegion == '2') {
		// 	$FilterSet = '1023-DKI JAKARTA';
		// } elseif ($getRegion == '3') {
		// 	$FilterSet = '1025-JAWA TIMUR';
		// } elseif ($getRegion == '4') {
		// 	$FilterSet = '1033-SULAWESI SELATAN';
		// }

		$tahun = date('Y');
		$bulan = date('m');

		if (isset($_POST["Tahun3"]) && isset($_POST["Bulan3"])) {
			
			$tahun = $_POST["Tahun3"];
			$bulan = str_pad($_POST["Bulan3"],2,"0",STR_PAD_LEFT);

		}

		if (isset($_POST["FilterBy3"]) && isset($_POST["FilterSet3"])) {
			
			$FilterBy = $_POST["FilterBy3"];
			$FilterSet = $_POST["FilterSet3"];

		}

		// print_r('<pre>');
		// print_r($FilterBy);exit;

		$by = explode('-', $FilterBy)[1];
		$set = $FilterSet;

		if ($FilterBy != '0-ALL' && $FilterSet != '0-ALL') {
			$by = explode('-', $FilterBy)[1];
			$set = explode('-', $FilterSet)[0];
		}

		$fromCRMDistr = $this->Dashboard_PMB_model->get_fromCRMDistr($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);
		$getfromSCMDistr = $this->Dashboard_PMB_model->get_fromSCMDistr($by, $set, $tahun, $bulan, $id_user, $id_jenis_user); // Kolom Volume & Revenue Distributor (Actual)

		$sellin = 0;
		$revenue = 0;
		foreach ($fromCRMDistr as $v1) {
			foreach ($getfromSCMDistr as $v2) {
				if ((int)$v1['KD_DISTRIBUTOR'] == (int)$v2['KD_DISTRIBUTOR']) {
					$sellin += $v2['ACT_VOLUME'];
					$revenue += $v2['ACT_REVENUE'];
				}
			}
		}

		$arr_sellin = array(
			array(
				'JUMLAH'	=> $sellin
			)
		);
		$arr_revenue = array(
			array(
				'JUMLAH'	=> $revenue
			)
		);

		// print_r('<pre>');
		// print_r($sellin);exit;


		$target_d = $this->Dashboard_PMB_model->get_fromCRMDistr($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

		$trg_coverage = 0;
		$trg_ta = 0;
		$trg_sellin = 0;
		$trg_revenue = 0;
		$trg_sellout = 0;
		$trg_so_cnc = 0;
		foreach ($target_d as $v3) {
			$trg_coverage += $v3['TRG_TOKO_UNIT'];
			$trg_ta += $v3['TRG_TOKO_AKTIF'];
			$trg_sellin += $v3['TRG_VOLUME'];
			$trg_revenue += $v3['TRG_REVENUE'];
			$trg_sellout += $v3['TRG_SELL_OUT'];
			$trg_so_cnc += $v3['TRG_SO_CLEAN_CLEAR'];
		}
		$arr_target_d = array(
			array(
                'COVERAGE' => $trg_coverage,
                'TA' => $trg_ta,
                'SELL_IN' => $trg_sellin,
                'REVENUE' => $trg_revenue,
                'SELL_OUT' => $trg_sellout,
                'SO_CC' => $trg_so_cnc
			)
		);

		$target_s = $this->Dashboard_PMB_model->get_fromCRMSLS($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);
		$visit = 0;
		$trg_visit = 0;
		$trg_noo = 0;
		$trg_ta = 0;
		foreach ($target_s as $v4) {
			$visit += $v4['ACT_VISIT'];
			$trg_visit += $v4['TRG_VISIT'];
			$trg_noo += $v4['TRG_TOKO_BARU'];
			$trg_ta += $v4['TRG_TOKO_AKTIF'];
		}
		$arr_visit = array(
			array(
                'JUMLAH' => $visit,
                'TARGET' => $trg_visit
			)
		);
		$arr_target_s = array(
			array(
                'NOO' => $trg_noo,
                'TA'  => $trg_ta
			)
		);

		$getcusCRM = $this->Dashboard_PMB_model->get_cusCRM($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

		$getselloutBK = $this->Dashboard_PMB_model->get_distrBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, 'sellout');

		$gettUBK = $this->Dashboard_PMB_model->get_distrBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, 'tu');

		$sellout = 0;
		$ta = 0;
		foreach ($fromCRMDistr as $v5) {
			foreach ($getselloutBK as $v6) {
				if ((int)$v5['KD_DISTRIBUTOR'] == (int)$v6['KD_DISTRIBUTOR']) {
					$sellout += $v6['SELL_OUT'];
					$ta += $v6['TA_DISTR'];
				}
			}
		}

		$arr_sellout = array(
			array(
                'JUMLAH'	=> $sellout,
                'TA'		=> $ta
 			)
		);

		$tu = 0;
		foreach ($fromCRMDistr as $v7) {
			foreach ($gettUBK as $v8) {
				if ((int)$v7['KD_DISTRIBUTOR'] == (int)$v8['KD_DISTRIBUTOR']) {
					$tu += $v8['TA_DISTR'];
				}
			}
		}

		$arr_tu = array(
			array(
                'JUMLAH'		=> $tu
 			)
		);

		$getcusCRM = $this->Dashboard_PMB_model->get_cusCRM($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

		$getTBBK = $this->Dashboard_PMB_model->get_TBBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

		$tb = 0;
		foreach ($getcusCRM as $v9) {
			foreach ($getTBBK as $v10) {
				if ($v9['KD_CUSTOMER'] == $v10['KD_CUSTOMER']) {
					$tb += $v10['JML'];
				}
			}
		}

		$arr_tB = array(
			array(
                'TB'		=> $tb
 			)
		);


		$getHariKerja = $this->Dashboard_PMB_model->get_HariKerja($tahun, $bulan);

		$prsn_HariKerja = round($getHariKerja['PRSN_HARI_KERJA']);
		$chart_HariKerja = 440 - round($getHariKerja['PRSN_HARI_KERJA'] * 4.4);

		$data['coverage'] = $arr_tu;
		$data['noo'] = $arr_tB;
		$data['sell_in'] = $arr_sellin; //from msc
		$data['revenue'] = $arr_revenue; //from msc
		$data['sell_out'] = $arr_sellout; //sellout bk
		$data['visit'] = $arr_visit;
		$data['so_cc'] = $this->Dashboard_PMB_model->valSOCC();
		$data['target'] = $arr_target_d;
		$data['target2'] = $arr_target_s;

		// $data['coverage'] = 0;
		// $data['noo'] = 0;
		// $data['sell_in'] = 0; //from msc
		// $data['revenue'] = 0; //from msc
		// $data['sell_out'] = 0; //sellout bk
		// $data['visit'] = 0;
		// $data['so_cc'] = 0;
		// $data['target'] = 0;
		// $data['target2'] = 0;

		$data['FilterBy'] = explode('-',$FilterBy)[1];
		$data['FilterSet'] = explode('-',$FilterSet)[1];

		$data['tahun'] = $tahun;
		$data['bulan'] = $bulan;

		$data['prsn_HariKerja'] = $prsn_HariKerja;
		$data['chart_HariKerja'] = $chart_HariKerja;

		$tdftr_regional = $this->Dashboard_PMB_model->get_tdftrregional();

		$tb_regional = $this->Dashboard_PMB_model->get_tbregional();

		$taIBK_regional = $this->Dashboard_PMB_model->get_taIBKregional();

		$taALL_regional = $this->Dashboard_PMB_model->get_taALLregional();

		$tvms_regional = $this->Dashboard_PMB_model->get_tvmsregional();

		$tlelang_regional = $this->Dashboard_PMB_model->get_tlelangregional();

		$sellinMSC_regional = $this->Dashboard_PMB_model->get_sellinMSCregional();

		$selloutSDG_regional = $this->Dashboard_PMB_model->get_selloutSDGregional();

		$selloutERPSDG_regional = $this->Dashboard_PMB_model->get_selloutERPSDGregional();

		$REVselloutSDG_regional = $this->Dashboard_PMB_model->get_REVselloutSDGregional();

		$REVselloutERPSDG_regional = $this->Dashboard_PMB_model->get_REVselloutERPSDGregional();

		$levelstokSDG_regional = $this->Dashboard_PMB_model->get_levelstokSDGregional();

		$jmlsales_regional = $this->Dashboard_PMB_model->get_jmlsalesregional();

		$visit_regional = $this->Dashboard_PMB_model->get_visitregional();

		$arr_merge = array_merge($tdftr_regional,$tb_regional,$taIBK_regional,$taALL_regional,$tvms_regional,$tlelang_regional,$sellinMSC_regional,$selloutSDG_regional,$selloutERPSDG_regional,$REVselloutSDG_regional,$REVselloutERPSDG_regional,$levelstokSDG_regional,$jmlsales_regional,$visit_regional);

		$data['dt_regional'] = $arr_merge;

		$mg_arr = array();
		foreach ($arr_merge as $v_mg) {
			for ($mg=1; $mg <= date('m'); $mg++) { 

				$dt = "'".str_pad($mg,2,"0",STR_PAD_LEFT)."'";

				$nilai = 0;
				if (isset($v_mg["$dt"])) {
					$nilai = round($v_mg["$dt"]);
				}

				$thn_bln = date('Y').'-'.str_pad($mg,2,"0",STR_PAD_LEFT);

				$mg_arr[] = array(
					'ID_REGION'	=> $v_mg['ID_REGION'],
					'ID_DATA'	=> $v_mg['ID_DATA'],
					'BULAN'		=> date('M', strtotime($thn_bln)),
					'DATA'		=> $nilai
				);

			}
		}

		$list_bln = '';
		$arr_bln = '';

		// foreach ($arr_merge as $arr_v) {

		// 	if (!isset($arr_v["'01'"])) {
		// 		$arr_v["'01'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'02'"])) {
		// 		$arr_v["'02'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'03'"])) {
		// 		$arr_v["'03'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'04'"])) {
		// 		$arr_v["'04'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'05'"])) {
		// 		$arr_v["'05'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'06'"])) {
		// 		$arr_v["'06'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'07'"])) {
		// 		$arr_v["'07'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'08'"])) {
		// 		$arr_v["'08'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'09'"])) {
		// 		$arr_v["'09'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'10'"])) {
		// 		$arr_v["'10'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'11'"])) {
		// 		$arr_v["'11'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'12'"])) {
		// 		$arr_v["'12'"] = 0;
		// 	}


		// 	for ($a=1; $a <= date('m'); $a++) { 
		// 		$list_bln .= date('M', strtotime(date('Y').'-'.str_pad($a,2,"0",STR_PAD_LEFT))).',';
		// 		$list_bln_f = substr_replace($list_bln, '', -1);

		// 		$arr_bln .= $arr_v["'".str_pad($a,2,"0",STR_PAD_LEFT)."'"].',';
		// 		$arr_bln_f = substr_replace($arr_bln, '', -1);
		// 	}

		// 	$jan = date('M', strtotime(date('Y').'-01')).',';
		// 	$feb = date('M', strtotime(date('Y').'-02')).',';
		// 	$mar = date('M', strtotime(date('Y').'-03')).',';
		// 	$apr = date('M', strtotime(date('Y').'-04')).',';
		// 	$may = date('M', strtotime(date('Y').'-05')).',';
		// 	$jun = date('M', strtotime(date('Y').'-06')).',';
		// 	$jul = date('M', strtotime(date('Y').'-07')).',';
		// 	$aug = date('M', strtotime(date('Y').'-08')).',';
		// 	$sep = date('M', strtotime(date('Y').'-09')).',';
		// 	$oct = date('M', strtotime(date('Y').'-10')).',';
		// 	$nov = date('M', strtotime(date('Y').'-11')).',';
		// 	$dec = date('M', strtotime(date('Y').'-12')).',';

		// 	$v_jan = round($arr_v["'01'"]).',';
		// 	$v_feb = round($arr_v["'02'"]).',';
		// 	$v_mar = round($arr_v["'03'"]).',';
		// 	$v_apr = round($arr_v["'04'"]).',';
		// 	$v_may = round($arr_v["'05'"]).',';
		// 	$v_jun = round($arr_v["'06'"]).',';
		// 	$v_jul = round($arr_v["'07'"]).',';
		// 	$v_aug = round($arr_v["'08'"]).',';
		// 	$v_sep = round($arr_v["'09'"]).',';
		// 	$v_oct = round($arr_v["'10'"]).',';
		// 	$v_nov = round($arr_v["'11'"]).',';
		// 	$v_dec = round($arr_v["'12'"]).',';

		// 	$list_bln = '';
		// 	$list_value = '';

		// 	if (date('M') == 'Jan') {
		// 		$list_bln = $jan;
		// 		$list_value = $v_jan;
		// 	} elseif (date('M') == 'Feb') {
		// 		$list_bln = $jan.$feb;
		// 		$list_value = $v_jan.$v_feb;
		// 	} elseif (date('M') == 'Mar') {
		// 		$list_bln = $jan.$feb.$mar;
		// 		$list_value = $v_jan.$v_feb.$v_mar;
		// 	} elseif (date('M') == 'Apr') {
		// 		$list_bln = $jan.$feb.$mar.$apr;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr;
		// 	} elseif (date('M') == 'May') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may;
		// 	} elseif (date('M') == 'Jun') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun;
		// 	} elseif (date('M') == 'Jul') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul;
		// 	} elseif (date('M') == 'Aug') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul.$aug;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul.$v_aug;
		// 	} elseif (date('M') == 'Sep') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul.$aug.$sep;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul.$v_aug.$v_sep;
		// 	} elseif (date('M') == 'Oct') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul.$aug.$sep.$oct;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul.$v_aug.$v_sep.$v_oct;
		// 	} elseif (date('M') == 'Nov') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul.$aug.$sep.$oct.$nov;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul.$v_aug.$v_sep.$v_oct.$v_nov;
		// 	} elseif (date('M') == 'Dec') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul.$aug.$sep.$oct.$nov.$dec;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul.$v_aug.$v_sep.$v_oct.$v_nov.$v_dec;
		// 	}

		// 	$list_bln_f = substr_replace($list_bln, '', -1);
		// 	$list_value_f = substr_replace($list_value, '', -1);

		// 	// print_r('<pre>');
		// 	// print_r($list_bln_f);exit;

			
		// 	$graf[] = array(
		// 		'ID_REGION'	=> $arr_v['ID_REGION'],
		// 		'ID_DATA'	=> $arr_v['ID_DATA'],
		// 		'BULAN'		=> $list_bln_f,
		// 		'DATA'		=> $list_value_f
		// 	);

		// }

		$data['dt_grafik'] = $mg_arr;

		$tdftr_regional_nas = $this->Dashboard_PMB_model->get_tdftrregional('nas');

		$tb_regional_nas = $this->Dashboard_PMB_model->get_tbregional('nas');

		$taIBK_regional_nas = $this->Dashboard_PMB_model->get_taIBKregional('nas');

		$taALL_regional_nas = $this->Dashboard_PMB_model->get_taALLregional('nas');

		$selloutSDG_regional_nas = $this->Dashboard_PMB_model->get_selloutSDGregional('nas');

		$levelstokSDG_regional_nas = $this->Dashboard_PMB_model->get_levelstokSDGregional('nas');

		$jmlsales_regional_nas = $this->Dashboard_PMB_model->get_jmlsalesregional('nas');

		$visit_regional_nas = $this->Dashboard_PMB_model->get_visitregional('nas');

		$arr_merge_nas = array_merge($tdftr_regional_nas,$tb_regional_nas,$taIBK_regional_nas,$taALL_regional_nas,$selloutSDG_regional_nas,$levelstokSDG_regional_nas,$jmlsales_regional_nas,$visit_regional_nas);

		$mg_arr_nas = array();
		foreach ($arr_merge_nas as $v_nas) {
			for ($nas=1; $nas <= date('m'); $nas++) { 

				$dt = "'".str_pad($nas,2,"0",STR_PAD_LEFT)."'";

				$nilai_nas = 0;
				if (isset($v_nas["$dt"])) {
					$nilai_nas = round($v_nas["$dt"],2);
				}

				$thn_bln = date('Y').'-'.str_pad($nas,2,"0",STR_PAD_LEFT);

				$mg_arr_nas[] = array(
					'ID_DATA'	=> $v_nas['ID_DATA'],
					'BULAN'		=> date('M', strtotime($thn_bln)),
					'DATA'		=> $nilai_nas
				);

			}
		}

		$data['dt_nasional'] = $mg_arr_nas;
		
		// print_r('<pre>');
		// print_r($mg_arr_nas);exit;

        $this->template->display('Dashboard_PMB_view', $data);
	}
	
	public function index(){

		$data = array("title"=>"Dashboard CRM");

		$id_user = $this->session->userdata("user_id");
		$id_jenis_user = $this->session->userdata("id_jenis_user");

		$data['jenis_user'] = $id_jenis_user;

		// for ($rg=1; $rg <= 4; $rg++) { 
		// 	$getDistr = $this->Dashboard_PMB_model->get_Distr($id_user, $id_jenis_user, $rg);
		// 	$getDistrik = $this->Dashboard_PMB_model->get_Distrik($id_user, $id_jenis_user, $rg);

		// 	$distr_in = "AND KODE_DISTRIBUTOR IN ($getDistr)";
		// 	$distrik_in = "AND ID_DISTRIK IN ($getDistrik)";

		// 	$distr_arr[] = array(
		// 		$distr_in
		// 	);

		// 	$distrik_arr[] = array(
		// 		$distrik_in
		// 	);
		// }

		// // print_r('<pre>');
		// // print_r($distr_arr);exit;

		$FilterBy = '';
		$FilterSet = '';
		if ($id_jenis_user == '1016') {
			$FilterBy = '2-PROVINSI';

			$getRegion = $this->Dashboard_PMB_model->get_Region_new($id_user, $id_jenis_user);

			$FilterSet = '';
			if ($getRegion == '1') {
				$FilterSet = '1011-SUMATERA UTARA';
			} elseif ($getRegion == '2') {
				$FilterSet = '1023-DKI JAKARTA';
			} elseif ($getRegion == '3') {
				$FilterSet = '1025-JAWA TIMUR';
			} elseif ($getRegion == '4') {
				$FilterSet = '1033-SULAWESI SELATAN';
			}
		} else {
			$FilterBy = '0-ALL';
			$FilterSet = '0-ALL';
		}
		
		$FilterBy = '0-ALL';
		$FilterSet = '0-ALL';

		$tahun = date('Y');
		$bulan = date('m');

		if (isset($_POST["Tahun3"]) && isset($_POST["Bulan3"])) {
			
			$tahun = $_POST["Tahun3"];
			$bulan = str_pad($_POST["Bulan3"],2,"0",STR_PAD_LEFT);

		}

		if (isset($_POST["FilterBy3"]) && isset($_POST["FilterSet3"])) {
			
			$FilterBy = $_POST["FilterBy3"];
			$FilterSet = $_POST["FilterSet3"];

		}

		$data['Fby'] = $FilterBy;
		$data['Fset'] = $FilterSet;

		// print_r('<pre>');
		// print_r($FilterBy.' - '.$FilterSet);exit;

		$by = explode('-', $FilterBy)[1];
		$set = $FilterSet;

		if ($FilterBy != '0-ALL' && $FilterSet != '0-ALL') {
			$by = explode('-', $FilterBy)[1];
			$set = explode('-', $FilterSet)[0];
		}


		$getmappinguser = $this->Dashboard_PMB_model->get_mapping_user($by, $set, $id_user, $id_jenis_user);

		if ($getmappinguser['JML'] == 0) {

			$arr_sellin = array(
				array(
					'JUMLAH'	=> 0
				)
			);
			$arr_revenue = array(
				array(
					'JUMLAH'	=> 0
				)
			);
			$arr_target_d = array(
				array(
	                'COVERAGE' 	=> 0,
	                'TA' 		=> 0,
	                'SELL_IN' 	=> 0,
	                'REVENUE' 	=> 0,
	                'SELL_OUT' 	=> 0,
	                'SO_CC' 	=> 0
				)
			);

			$arr_visit = array(
				array(
	                'JUMLAH' => 0,
	                'TARGET' => 0
				)
			);
			$arr_target_s = array(
				array(
	                'NOO' => 0,
	                'TA'  => 0
				)
			);


			$arr_sellout = array(
				array(
	                'JUMLAH'	=> 0,
	                'TA'		=> 0
	 			)
			);


			$arr_tu = array(
				array(
	                'JUMLAH'	=> 0
	 			)
			);


			$arr_tB_2 = array(
				array(
	                'TB'	=> 0
	 			)
			);

		} else {

			$getDistr_TBL = $this->Dashboard_PMB_model->get_Distr_TBL($by, $set, $id_user, $id_jenis_user);

			$getDistrik_TBL = $this->Dashboard_PMB_model->get_Distrik_TBL($by, $set, $id_user, $id_jenis_user);

			$getCustomer_TBL = $this->Dashboard_PMB_model->get_Customer_TBL($id_user, $id_jenis_user, $getDistr_TBL, $getDistrik_TBL);
			

			$getfromSCMDistr = $this->Dashboard_PMB_model->get_fromSCMDistr($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, $getDistr_TBL); // Kolom Volume & Revenue Distributor (Actual)

			// print_r('<pre>');
			// print_r($getCustomer_TBL);exit;

			$sellin = 0;
			$revenue = 0;
			foreach ($getfromSCMDistr as $v2) {
				$sellin += $v2['ACT_VOLUME'];
				$revenue += $v2['ACT_REVENUE'];
			}

			$arr_sellin = array(
				array(
					'JUMLAH'	=> $sellin
				)
			);
			$arr_revenue = array(
				array(
					'JUMLAH'	=> $revenue
				)
			);

			// print_r('<pre>');
			// print_r($sellin);exit;


			$target_d = $this->Dashboard_PMB_model->get_fromCRMDistr($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

			$trg_coverage = 0;
			$trg_ta = 0;
			$trg_sellin = 0;
			$trg_revenue = 0;
			$trg_sellout = 0;
			$trg_so_cnc = 0;
			foreach ($target_d as $v3) {
				$trg_coverage += $v3['TRG_TOKO_UNIT'];
				$trg_ta += $v3['TRG_TOKO_AKTIF'];
				$trg_sellin += $v3['TRG_VOLUME'];
				$trg_revenue += $v3['TRG_REVENUE'];
				$trg_sellout += $v3['TRG_SELL_OUT'];
				$trg_so_cnc += $v3['TRG_SO_CLEAN_CLEAR'];
			}
			$arr_target_d = array(
				array(
	                'COVERAGE' => $trg_coverage,
	                'TA' => $trg_ta,
	                'SELL_IN' => $trg_sellin,
	                'REVENUE' => $trg_revenue,
	                'SELL_OUT' => $trg_sellout,
	                'SO_CC' => $trg_so_cnc
				)
			);

			$target_s = $this->Dashboard_PMB_model->get_fromCRMSLS($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);
			$visit = 0;
			$trg_visit = 0;
			$trg_noo = 0;
			$trg_ta = 0;
			foreach ($target_s as $v4) {
				$visit += $v4['ACT_VISIT'];
				$trg_visit += $v4['TRG_VISIT'];
				$trg_noo += $v4['TRG_TOKO_BARU'];
				$trg_ta += $v4['TRG_TOKO_AKTIF'];
			}
			$arr_visit = array(
				array(
	                'JUMLAH' => $visit,
	                'TARGET' => $trg_visit
				)
			);
			$arr_target_s = array(
				array(
	                'NOO' => $trg_noo,
	                'TA'  => $trg_ta
				)
			);

			// $getcusCRM = $this->Dashboard_PMB_model->get_cusCRM($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

			$getselloutBK = $this->Dashboard_PMB_model->get_distrBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, 'sellout', $getDistr_TBL);

			$gettUBK = $this->Dashboard_PMB_model->get_distrBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, 'tu', $getDistr_TBL);

			$getTBBK_2 = $this->Dashboard_PMB_model->get_distrTBBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, 'tu', $getDistr_TBL);

			$sellout = 0;
			$ta = 0;
			foreach ($getselloutBK as $v6) {
				$sellout += $v6['SELL_OUT'];
				$ta += $v6['TA_DISTR'];
			}

			$arr_sellout = array(
				array(
	                'JUMLAH'	=> $sellout,
	                'TA'		=> $ta
	 			)
			);

			$tu = 0;
			foreach ($gettUBK as $v8) {
				$tu += $v8['TA_DISTR'];
			}

			$arr_tu = array(
				array(
	                'JUMLAH'		=> $tu
	 			)
			);

			$tb_2 = 0;
			foreach ($getTBBK_2 as $vTB) {
				$tb_2 += $vTB['JML'];
			}

			$arr_tB_2 = array(
				array(
	                'JUMLAH'		=> $tb_2
	 			)
			);

			// print_r('<pre>');
			// print_r($arr_tB_2);exit;

			// $getTBBK = $this->Dashboard_PMB_model->get_TBBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

			// $tb = 0;
			// foreach ($getcusCRM as $v9) {
			// 	foreach ($getTBBK as $v10) {
			// 		if ($v9['KD_CUSTOMER'] == $v10['KD_CUSTOMER'] && (int)$v9['KODE_DISTRIBUTOR'] == (int)$v10['KD_DISTRIBUTOR']) {
			// 			$tb += $v10['JML'];
			// 		}
			// 	}
			// }

			// $arr_tB = array(
			// 	array(
	  //               'TB'		=> $tb
	 	// 		)
			// );


		}

		$getHariKerja = $this->Dashboard_PMB_model->get_HariKerja($tahun, $bulan);

		$prsn_HariKerja = round($getHariKerja['PRSN_HARI_KERJA']);
		if (str_pad(date('d'),2,"0",STR_PAD_LEFT) == '01') {
			$prsn_HariKerja = 0;
		}
		
		$chart_HariKerja = 440 - round($prsn_HariKerja * 4.4);


		// print_r('<pre>');
		// print_r($prsn_HariKerja);exit;

		$data['coverage'] = $arr_tu;
		$data['noo'] = $arr_tB_2;
		$data['sell_in'] = $arr_sellin; //from msc
		$data['revenue'] = $arr_revenue; //from msc
		$data['sell_out'] = $arr_sellout; //sellout bk
		$data['visit'] = $arr_visit;
		$data['so_cc'] = $this->Dashboard_PMB_model->valSOCC();
		$data['target'] = $arr_target_d;
		$data['target2'] = $arr_target_s;

		// print_r('<pre>');
		// print_r($data);exit;

		// $data['coverage'] = 0;
		// $data['noo'] = 0;
		// $data['sell_in'] = 0; //from msc
		// $data['revenue'] = 0; //from msc
		// $data['sell_out'] = 0; //sellout bk
		// $data['visit'] = 0;
		// $data['so_cc'] = 0;
		// $data['target'] = 0;
		// $data['target2'] = 0;

		$data['FilterBy'] = explode('-',$FilterBy)[1];
		$data['FilterSet'] = explode('-',$FilterSet)[1];

		$data['tahun'] = $tahun;
		$data['bulan'] = $bulan;

		$data['prsn_HariKerja'] = $prsn_HariKerja;
		$data['chart_HariKerja'] = $chart_HariKerja;


        $this->template->display('Dashboard_PMB_view', $data);
	}
	
	public function Sls_Dis(){

		$data = array("title"=>"Dashboard CRM");

		$id_user = $this->session->userdata("user_id");
		$id_jenis_user = $this->session->userdata("id_jenis_user");

		// print_r('<pre>');
		// print_r($id_user.' - '.$id_jenis_user);exit;

		$getRegion = $this->Dashboard_PMB_model->get_Region_new($id_user, $id_jenis_user);

		$getBy = '';
		if ($id_jenis_user == '1016') {
			$getBy = '2-PROVINSI';
		} else {
			$getBy = '0-ALL';
		}

		$getSet = '';
		if ($id_jenis_user == '1016') {
			if ($getRegion == '1') {
				$getSet = '1011-SUMATERA UTARA';
			} elseif ($getRegion == '2') {
				$getSet = '1023-DKI JAKARTA';
			} elseif ($getRegion == '3') {
				$getSet = '1025-JAWA TIMUR';
			} elseif ($getRegion == '4') {
				$getSet = '1033-SULAWESI SELATAN';
			}
		} else {
			$getSet = 'ALL';
		}	

		$data['by'] = $getBy;
		$data['set'] = $getSet;
		$data['jenis_user'] = $id_jenis_user;

		// print_r('<pre>');
		// print_r($data);exit;

        $this->template->display('Dashboard_PMB_Sls_Dis_view', $data);
	}
	
	public function Nas_Reg(){

		$data = array("title"=>"Dashboard CRM");

		$id_user = $this->session->userdata("user_id");
		$id_jenis_user = $this->session->userdata("id_jenis_user");

		// $getDistr = $this->Dashboard_PMB_model->get_Distr($id_user, $id_jenis_user);

		$FilterBy = '0-ALL';
		$FilterSet = '0-ALL';

		$tahun = date('Y');
		$bulan = date('m');

		if (isset($_POST["Tahun3"]) && isset($_POST["Bulan3"])) {
			
			$tahun = $_POST["Tahun3"];
			$bulan = str_pad($_POST["Bulan3"],2,"0",STR_PAD_LEFT);

		}

		if (isset($_POST["FilterBy3"]) && isset($_POST["FilterSet3"])) {
			
			$FilterBy = $_POST["FilterBy3"];
			$FilterSet = $_POST["FilterSet3"];

		}

		$by = explode('-', $FilterBy)[1];
		$set = $FilterSet;

		if ($FilterBy != '0-ALL' && $FilterSet != 'ALL') {
			$by = explode('-', $FilterBy)[1];
			$set = explode('-', $FilterSet)[0];
		}


		// $arr_tdftrregional = array();
		// $arr_tbregional = array();
		// $arr_taIBKregional = array();
		// $arr_taALLregional = array();
		// $arr_tvmsregional = array();
		// $arr_tlelangregional = array();
		// $arr_sellinMSCregional = array();
		// $arr_selloutSDGregional = array();
		// $arr_selloutERPSDGregional = array();
		// $arr_REVselloutSDGregional = array();
		// $arr_REVselloutERPSDGregional = array();
		// $arr_levelstokSDGregional = array();
		// $arr_jmlsalesregional = array();
		// $arr_visitregional = array();

		// for ($rg=1; $rg <= 4; $rg++) { 

		// 	$reg = "'".$rg."'";

		// 	$getDistr = $this->Dashboard_PMB_model->get_Distr($id_user, $id_jenis_user, $reg);
		// 	$getDistrik = $this->Dashboard_PMB_model->get_Distrik($id_user, $id_jenis_user, $reg);

		// 	$tdftr_regional = $this->Dashboard_PMB_model->get_tdftrregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_tdftrregional, $tdftr_regional);

		// 	$tb_regional = $this->Dashboard_PMB_model->get_tbregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_tbregional, $tb_regional);

		// 	$taIBK_regional = $this->Dashboard_PMB_model->get_taIBKregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_taIBKregional, $taIBK_regional);

		// 	$taALL_regional = $this->Dashboard_PMB_model->get_taALLregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_taALLregional, $taALL_regional);

		// 	$tvms_regional = $this->Dashboard_PMB_model->get_tvmsregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_tvmsregional, $tvms_regional);

		// 	$tlelang_regional = $this->Dashboard_PMB_model->get_tlelangregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_tlelangregional, $tlelang_regional);

		// 	$sellinMSC_regional = $this->Dashboard_PMB_model->get_sellinMSCregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_sellinMSCregional, $sellinMSC_regional);

		// 	$selloutSDG_regional = $this->Dashboard_PMB_model->get_selloutSDGregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_selloutSDGregional, $selloutSDG_regional);

		// 	$selloutERPSDG_regional = $this->Dashboard_PMB_model->get_selloutERPSDGregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_selloutERPSDGregional, $selloutERPSDG_regional);

		// 	$REVselloutSDG_regional = $this->Dashboard_PMB_model->get_REVselloutSDGregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_REVselloutSDGregional, $REVselloutSDG_regional);

		// 	$REVselloutERPSDG_regional = $this->Dashboard_PMB_model->get_REVselloutERPSDGregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_REVselloutERPSDGregional, $REVselloutERPSDG_regional);

		// 	$levelstokSDG_regional = $this->Dashboard_PMB_model->get_levelstokSDGregional($reg, $getDistr, $getDistrik);

		// 	array_push($arr_levelstokSDGregional, $levelstokSDG_regional);

		// 	$jmlsales_regional = $this->Dashboard_PMB_model->get_jmlsalesregional($reg);

		// 	array_push($arr_jmlsalesregional, $jmlsales_regional);

		// 	$visit_regional = $this->Dashboard_PMB_model->get_visitregional($reg);

		// 	array_push($arr_visitregional, $visit_regional);


		// }


		$getDistr_1 = $this->Dashboard_PMB_model->get_Distr($id_user, $id_jenis_user, 1);
		$getDistrik_1 = $this->Dashboard_PMB_model->get_Distrik($id_user, $id_jenis_user, 1);

		$getDistr_2 = $this->Dashboard_PMB_model->get_Distr($id_user, $id_jenis_user, 2);
		$getDistrik_2 = $this->Dashboard_PMB_model->get_Distrik($id_user, $id_jenis_user, 2);

		$getDistr_3 = $this->Dashboard_PMB_model->get_Distr($id_user, $id_jenis_user, 3);
		$getDistrik_3 = $this->Dashboard_PMB_model->get_Distrik($id_user, $id_jenis_user, 3);

		$getDistr_4 = $this->Dashboard_PMB_model->get_Distr($id_user, $id_jenis_user, 4);
		$getDistrik_4 = $this->Dashboard_PMB_model->get_Distrik($id_user, $id_jenis_user, 4);

		$tdftr_regional = $this->Dashboard_PMB_model->get_tdftrregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$dt_nas1_01 = 0;
		if (isset($tdftr_regional[0]["'01'"]) && isset($tdftr_regional[1]["'01'"]) && isset($tdftr_regional[2]["'01'"]) && isset($tdftr_regional[3]["'01'"])) {
			$dt_nas1_01 = $tdftr_regional[0]["'01'"] + $tdftr_regional[1]["'01'"] + $tdftr_regional[2]["'01'"] + $tdftr_regional[3]["'01'"];
		}
		$dt_nas1_02 = 0;
		if (isset($tdftr_regional[0]["'02'"]) && isset($tdftr_regional[1]["'02'"]) && isset($tdftr_regional[2]["'02'"]) && isset($tdftr_regional[3]["'02'"])) {
			$dt_nas1_02 = $tdftr_regional[0]["'02'"] + $tdftr_regional[1]["'02'"] + $tdftr_regional[2]["'02'"] + $tdftr_regional[3]["'02'"];
		}
		$dt_nas1_03 = 0;
		if (isset($tdftr_regional[0]["'03'"]) && isset($tdftr_regional[1]["'03'"]) && isset($tdftr_regional[2]["'03'"]) && isset($tdftr_regional[3]["'03'"])) {
			$dt_nas1_03 = $tdftr_regional[0]["'03'"] + $tdftr_regional[1]["'03'"] + $tdftr_regional[2]["'03'"] + $tdftr_regional[3]["'03'"];
		}
		$dt_nas1_04 = 0;
		if (isset($tdftr_regional[0]["'04'"]) && isset($tdftr_regional[1]["'04'"]) && isset($tdftr_regional[2]["'04'"]) && isset($tdftr_regional[3]["'04'"])) {
			$dt_nas1_04 = $tdftr_regional[0]["'04'"] + $tdftr_regional[1]["'04'"] + $tdftr_regional[2]["'04'"] + $tdftr_regional[3]["'04'"];
		}
		$dt_nas1_05 = 0;
		if (isset($tdftr_regional[0]["'05'"]) && isset($tdftr_regional[1]["'05'"]) && isset($tdftr_regional[2]["'05'"]) && isset($tdftr_regional[3]["'05'"])) {
			$dt_nas1_05 = $tdftr_regional[0]["'05'"] + $tdftr_regional[1]["'05'"] + $tdftr_regional[2]["'05'"] + $tdftr_regional[3]["'05'"];
		}
		$dt_nas1_06 = 0;
		if (isset($tdftr_regional[0]["'06'"]) && isset($tdftr_regional[1]["'06'"]) && isset($tdftr_regional[2]["'06'"]) && isset($tdftr_regional[3]["'06'"])) {
			$dt_nas1_06 = $tdftr_regional[0]["'06'"] + $tdftr_regional[1]["'06'"] + $tdftr_regional[2]["'06'"] + $tdftr_regional[3]["'06'"];
		}
		$dt_nas1_07 = 0;
		if (isset($tdftr_regional[0]["'07'"]) && isset($tdftr_regional[1]["'07'"]) && isset($tdftr_regional[2]["'07'"]) && isset($tdftr_regional[3]["'07'"])) {
			$dt_nas1_07 = $tdftr_regional[0]["'07'"] + $tdftr_regional[1]["'07'"] + $tdftr_regional[2]["'07'"] + $tdftr_regional[3]["'07'"];
		}
		$dt_nas1_08 = 0;
		if (isset($tdftr_regional[0]["'08'"]) && isset($tdftr_regional[1]["'08'"]) && isset($tdftr_regional[2]["'08'"]) && isset($tdftr_regional[3]["'08'"])) {
			$dt_nas1_08 = $tdftr_regional[0]["'08'"] + $tdftr_regional[1]["'08'"] + $tdftr_regional[2]["'08'"] + $tdftr_regional[3]["'08'"];
		}
		$dt_nas1_09 = 0;
		if (isset($tdftr_regional[0]["'09'"]) && isset($tdftr_regional[1]["'09'"]) && isset($tdftr_regional[2]["'09'"]) && isset($tdftr_regional[3]["'09'"])) {
			$dt_nas1_09 = $tdftr_regional[0]["'09'"] + $tdftr_regional[1]["'09'"] + $tdftr_regional[2]["'09'"] + $tdftr_regional[3]["'09'"];
		}
		$dt_nas1_10 = 0;
		if (isset($tdftr_regional[0]["'10'"]) && isset($tdftr_regional[1]["'10'"]) && isset($tdftr_regional[2]["'10'"]) && isset($tdftr_regional[3]["'10'"])) {
			$dt_nas1_10 = $tdftr_regional[0]["'10'"] + $tdftr_regional[1]["'10'"] + $tdftr_regional[2]["'10'"] + $tdftr_regional[3]["'10'"];
		}
		$dt_nas1_11 = 0;
		if (isset($tdftr_regional[0]["'11'"]) && isset($tdftr_regional[1]["'11'"]) && isset($tdftr_regional[2]["'11'"]) && isset($tdftr_regional[3]["'11'"])) {
			$dt_nas1_11 = $tdftr_regional[0]["'11'"] + $tdftr_regional[1]["'11'"] + $tdftr_regional[2]["'11'"] + $tdftr_regional[3]["'11'"];
		}
		$dt_nas1_12 = 0;
		if (isset($tdftr_regional[0]["'12'"]) && isset($tdftr_regional[1]["'12'"]) && isset($tdftr_regional[2]["'12'"]) && isset($tdftr_regional[3]["'12'"])) {
			$dt_nas1_12 = $tdftr_regional[0]["'12'"] + $tdftr_regional[1]["'12'"] + $tdftr_regional[2]["'12'"] + $tdftr_regional[3]["'12'"];
		}

		$arr_nas1[] = array(
			"ID_REGION" => 'ALL',
            "ID_DATA" => $tdftr_regional[0]["ID_DATA"],
            "'01'" => $dt_nas1_01,
            "'02'" => $dt_nas1_02,
            "'03'" => $dt_nas1_03,
            "'04'" => $dt_nas1_04,
            "'05'" => $dt_nas1_05,
            "'06'" => $dt_nas1_06,
            "'07'" => $dt_nas1_07,
            "'08'" => $dt_nas1_08,
            "'09'" => $dt_nas1_09,
            "'10'" => $dt_nas1_10,
            "'11'" => $dt_nas1_11,
            "'12'" => $dt_nas1_12
		);
		
		// print_r('<pre>');
		// print_r($arr_nas1);exit;

		$tb_regional = $this->Dashboard_PMB_model->get_tbregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$dt_nas2_01 = 0;
		if (isset($tb_regional[0]["'01'"]) && isset($tb_regional[1]["'01'"]) && isset($tb_regional[2]["'01'"]) && isset($tb_regional[3]["'01'"])) {
			$dt_nas2_01 = $tb_regional[0]["'01'"] + $tb_regional[1]["'01'"] + $tb_regional[2]["'01'"] + $tb_regional[3]["'01'"];
		}
		$dt_nas2_02 = 0;
		if (isset($tb_regional[0]["'02'"]) && isset($tb_regional[1]["'02'"]) && isset($tb_regional[2]["'02'"]) && isset($tb_regional[3]["'02'"])) {
			$dt_nas2_02 = $tb_regional[0]["'02'"] + $tb_regional[1]["'02'"] + $tb_regional[2]["'02'"] + $tb_regional[3]["'02'"];
		}
		$dt_nas2_03 = 0;
		if (isset($tb_regional[0]["'03'"]) && isset($tb_regional[1]["'03'"]) && isset($tb_regional[2]["'03'"]) && isset($tb_regional[3]["'03'"])) {
			$dt_nas2_03 = $tb_regional[0]["'03'"] + $tb_regional[1]["'03'"] + $tb_regional[2]["'03'"] + $tb_regional[3]["'03'"];
		}
		$dt_nas2_04 = 0;
		if (isset($tb_regional[0]["'04'"]) && isset($tb_regional[1]["'04'"]) && isset($tb_regional[2]["'04'"]) && isset($tb_regional[3]["'04'"])) {
			$dt_nas2_04 = $tb_regional[0]["'04'"] + $tb_regional[1]["'04'"] + $tb_regional[2]["'04'"] + $tb_regional[3]["'04'"];
		}
		$dt_nas2_05 = 0;
		if (isset($tb_regional[0]["'05'"]) && isset($tb_regional[1]["'05'"]) && isset($tb_regional[2]["'05'"]) && isset($tb_regional[3]["'05'"])) {
			$dt_nas2_05 = $tb_regional[0]["'05'"] + $tb_regional[1]["'05'"] + $tb_regional[2]["'05'"] + $tb_regional[3]["'05'"];
		}
		$dt_nas2_06 = 0;
		if (isset($tb_regional[0]["'06'"]) && isset($tb_regional[1]["'06'"]) && isset($tb_regional[2]["'06'"]) && isset($tb_regional[3]["'06'"])) {
			$dt_nas2_06 = $tb_regional[0]["'06'"] + $tb_regional[1]["'06'"] + $tb_regional[2]["'06'"] + $tb_regional[3]["'06'"];
		}
		$dt_nas2_07 = 0;
		if (isset($tb_regional[0]["'07'"]) && isset($tb_regional[1]["'07'"]) && isset($tb_regional[2]["'07'"]) && isset($tb_regional[3]["'07'"])) {
			$dt_nas2_07 = $tb_regional[0]["'07'"] + $tb_regional[1]["'07'"] + $tb_regional[2]["'07'"] + $tb_regional[3]["'07'"];
		}
		$dt_nas2_08 = 0;
		if (isset($tb_regional[0]["'08'"]) && isset($tb_regional[1]["'08'"]) && isset($tb_regional[2]["'08'"]) && isset($tb_regional[3]["'08'"])) {
			$dt_nas2_08 = $tb_regional[0]["'08'"] + $tb_regional[1]["'08'"] + $tb_regional[2]["'08'"] + $tb_regional[3]["'08'"];
		}
		$dt_nas2_09 = 0;
		if (isset($tb_regional[0]["'09'"]) && isset($tb_regional[1]["'09'"]) && isset($tb_regional[2]["'09'"]) && isset($tb_regional[3]["'09'"])) {
			$dt_nas2_09 = $tb_regional[0]["'09'"] + $tb_regional[1]["'09'"] + $tb_regional[2]["'09'"] + $tb_regional[3]["'09'"];
		}
		$dt_nas2_10 = 0;
		if (isset($tb_regional[0]["'10'"]) && isset($tb_regional[1]["'10'"]) && isset($tb_regional[2]["'10'"]) && isset($tb_regional[3]["'10'"])) {
			$dt_nas2_10 = $tb_regional[0]["'10'"] + $tb_regional[1]["'10'"] + $tb_regional[2]["'10'"] + $tb_regional[3]["'10'"];
		}
		$dt_nas2_11 = 0;
		if (isset($tb_regional[0]["'11'"]) && isset($tb_regional[1]["'11'"]) && isset($tb_regional[2]["'11'"]) && isset($tb_regional[3]["'11'"])) {
			$dt_nas2_11 = $tb_regional[0]["'11'"] + $tb_regional[1]["'11'"] + $tb_regional[2]["'11'"] + $tb_regional[3]["'11'"];
		}
		$dt_nas2_12 = 0;
		if (isset($tb_regional[0]["'12'"]) && isset($tb_regional[1]["'12'"]) && isset($tb_regional[2]["'12'"]) && isset($tb_regional[3]["'12'"])) {
			$dt_nas2_12 = $tb_regional[0]["'12'"] + $tb_regional[1]["'12'"] + $tb_regional[2]["'12'"] + $tb_regional[3]["'12'"];
		}

		$arr_nas2[] = array(
			"ID_REGION" => 'ALL',
            "ID_DATA" => $tb_regional[0]["ID_DATA"],
            "'01'" => $dt_nas2_01,
            "'02'" => $dt_nas2_02,
            "'03'" => $dt_nas2_03,
            "'04'" => $dt_nas2_04,
            "'05'" => $dt_nas2_05,
            "'06'" => $dt_nas2_06,
            "'07'" => $dt_nas2_07,
            "'08'" => $dt_nas2_08,
            "'09'" => $dt_nas2_09,
            "'10'" => $dt_nas2_10,
            "'11'" => $dt_nas2_11,
            "'12'" => $dt_nas2_12
		);

		$taIBK_regional = $this->Dashboard_PMB_model->get_taIBKregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$dt_nas3_01 = 0;
		if (isset($taIBK_regional[0]["'01'"]) && isset($taIBK_regional[1]["'01'"]) && isset($taIBK_regional[2]["'01'"]) && isset($taIBK_regional[3]["'01'"])) {
			$dt_nas3_01 = $taIBK_regional[0]["'01'"] + $taIBK_regional[1]["'01'"] + $taIBK_regional[2]["'01'"] + $taIBK_regional[3]["'01'"];
		}
		$dt_nas3_02 = 0;
		if (isset($taIBK_regional[0]["'02'"]) && isset($taIBK_regional[1]["'02'"]) && isset($taIBK_regional[2]["'02'"]) && isset($taIBK_regional[3]["'02'"])) {
			$dt_nas3_02 = $taIBK_regional[0]["'02'"] + $taIBK_regional[1]["'02'"] + $taIBK_regional[2]["'02'"] + $taIBK_regional[3]["'02'"];
		}
		$dt_nas3_03 = 0;
		if (isset($taIBK_regional[0]["'03'"]) && isset($taIBK_regional[1]["'03'"]) && isset($taIBK_regional[2]["'03'"]) && isset($taIBK_regional[3]["'03'"])) {
			$dt_nas3_03 = $taIBK_regional[0]["'03'"] + $taIBK_regional[1]["'03'"] + $taIBK_regional[2]["'03'"] + $taIBK_regional[3]["'03'"];
		}
		$dt_nas3_04 = 0;
		if (isset($taIBK_regional[0]["'04'"]) && isset($taIBK_regional[1]["'04'"]) && isset($taIBK_regional[2]["'04'"]) && isset($taIBK_regional[3]["'04'"])) {
			$dt_nas3_04 = $taIBK_regional[0]["'04'"] + $taIBK_regional[1]["'04'"] + $taIBK_regional[2]["'04'"] + $taIBK_regional[3]["'04'"];
		}
		$dt_nas3_05 = 0;
		if (isset($taIBK_regional[0]["'05'"]) && isset($taIBK_regional[1]["'05'"]) && isset($taIBK_regional[2]["'05'"]) && isset($taIBK_regional[3]["'05'"])) {
			$dt_nas3_05 = $taIBK_regional[0]["'05'"] + $taIBK_regional[1]["'05'"] + $taIBK_regional[2]["'05'"] + $taIBK_regional[3]["'05'"];
		}
		$dt_nas3_06 = 0;
		if (isset($taIBK_regional[0]["'06'"]) && isset($taIBK_regional[1]["'06'"]) && isset($taIBK_regional[2]["'06'"]) && isset($taIBK_regional[3]["'06'"])) {
			$dt_nas3_06 = $taIBK_regional[0]["'06'"] + $taIBK_regional[1]["'06'"] + $taIBK_regional[2]["'06'"] + $taIBK_regional[3]["'06'"];
		}
		$dt_nas3_07 = 0;
		if (isset($taIBK_regional[0]["'07'"]) && isset($taIBK_regional[1]["'07'"]) && isset($taIBK_regional[2]["'07'"]) && isset($taIBK_regional[3]["'07'"])) {
			$dt_nas3_07 = $taIBK_regional[0]["'07'"] + $taIBK_regional[1]["'07'"] + $taIBK_regional[2]["'07'"] + $taIBK_regional[3]["'07'"];
		}
		$dt_nas3_08 = 0;
		if (isset($taIBK_regional[0]["'08'"]) && isset($taIBK_regional[1]["'08'"]) && isset($taIBK_regional[2]["'08'"]) && isset($taIBK_regional[3]["'08'"])) {
			$dt_nas3_08 = $taIBK_regional[0]["'08'"] + $taIBK_regional[1]["'08'"] + $taIBK_regional[2]["'08'"] + $taIBK_regional[3]["'08'"];
		}
		$dt_nas3_09 = 0;
		if (isset($taIBK_regional[0]["'09'"]) && isset($taIBK_regional[1]["'09'"]) && isset($taIBK_regional[2]["'09'"]) && isset($taIBK_regional[3]["'09'"])) {
			$dt_nas3_09 = $taIBK_regional[0]["'09'"] + $taIBK_regional[1]["'09'"] + $taIBK_regional[2]["'09'"] + $taIBK_regional[3]["'09'"];
		}
		$dt_nas3_10 = 0;
		if (isset($taIBK_regional[0]["'10'"]) && isset($taIBK_regional[1]["'10'"]) && isset($taIBK_regional[2]["'10'"]) && isset($taIBK_regional[3]["'10'"])) {
			$dt_nas3_10 = $taIBK_regional[0]["'10'"] + $taIBK_regional[1]["'10'"] + $taIBK_regional[2]["'10'"] + $taIBK_regional[3]["'10'"];
		}
		$dt_nas3_11 = 0;
		if (isset($taIBK_regional[0]["'11'"]) && isset($taIBK_regional[1]["'11'"]) && isset($taIBK_regional[2]["'11'"]) && isset($taIBK_regional[3]["'11'"])) {
			$dt_nas3_11 = $taIBK_regional[0]["'11'"] + $taIBK_regional[1]["'11'"] + $taIBK_regional[2]["'11'"] + $taIBK_regional[3]["'11'"];
		}
		$dt_nas3_12 = 0;
		if (isset($taIBK_regional[0]["'12'"]) && isset($taIBK_regional[1]["'12'"]) && isset($taIBK_regional[2]["'12'"]) && isset($taIBK_regional[3]["'12'"])) {
			$dt_nas3_12 = $taIBK_regional[0]["'12'"] + $taIBK_regional[1]["'12'"] + $taIBK_regional[2]["'12'"] + $taIBK_regional[3]["'12'"];
		}

		$arr_nas3[] = array(
			"ID_REGION" => 'ALL',
            "ID_DATA" => $taIBK_regional[0]["ID_DATA"],
            "'01'" => $dt_nas3_01,
            "'02'" => $dt_nas3_02,
            "'03'" => $dt_nas3_03,
            "'04'" => $dt_nas3_04,
            "'05'" => $dt_nas3_05,
            "'06'" => $dt_nas3_06,
            "'07'" => $dt_nas3_07,
            "'08'" => $dt_nas3_08,
            "'09'" => $dt_nas3_09,
            "'10'" => $dt_nas3_10,
            "'11'" => $dt_nas3_11,
            "'12'" => $dt_nas3_12
		);

		$taALL_regional = $this->Dashboard_PMB_model->get_taALLregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$dt_nas4_01 = 0;
		if (isset($taALL_regional[0]["'01'"]) && isset($taALL_regional[1]["'01'"]) && isset($taALL_regional[2]["'01'"]) && isset($taALL_regional[3]["'01'"])) {
			$dt_nas4_01 = $taALL_regional[0]["'01'"] + $taALL_regional[1]["'01'"] + $taALL_regional[2]["'01'"] + $taALL_regional[3]["'01'"];
		}
		$dt_nas4_02 = 0;
		if (isset($taALL_regional[0]["'02'"]) && isset($taALL_regional[1]["'02'"]) && isset($taALL_regional[2]["'02'"]) && isset($taALL_regional[3]["'02'"])) {
			$dt_nas4_02 = $taALL_regional[0]["'02'"] + $taALL_regional[1]["'02'"] + $taALL_regional[2]["'02'"] + $taALL_regional[3]["'02'"];
		}
		$dt_nas4_03 = 0;
		if (isset($taALL_regional[0]["'03'"]) && isset($taALL_regional[1]["'03'"]) && isset($taALL_regional[2]["'03'"]) && isset($taALL_regional[3]["'03'"])) {
			$dt_nas4_03 = $taALL_regional[0]["'03'"] + $taALL_regional[1]["'03'"] + $taALL_regional[2]["'03'"] + $taALL_regional[3]["'03'"];
		}
		$dt_nas4_04 = 0;
		if (isset($taALL_regional[0]["'04'"]) && isset($taALL_regional[1]["'04'"]) && isset($taALL_regional[2]["'04'"]) && isset($taALL_regional[3]["'04'"])) {
			$dt_nas4_04 = $taALL_regional[0]["'04'"] + $taALL_regional[1]["'04'"] + $taALL_regional[2]["'04'"] + $taALL_regional[3]["'04'"];
		}
		$dt_nas4_05 = 0;
		if (isset($taALL_regional[0]["'05'"]) && isset($taALL_regional[1]["'05'"]) && isset($taALL_regional[2]["'05'"]) && isset($taALL_regional[3]["'05'"])) {
			$dt_nas4_05 = $taALL_regional[0]["'05'"] + $taALL_regional[1]["'05'"] + $taALL_regional[2]["'05'"] + $taALL_regional[3]["'05'"];
		}
		$dt_nas4_06 = 0;
		if (isset($taALL_regional[0]["'06'"]) && isset($taALL_regional[1]["'06'"]) && isset($taALL_regional[2]["'06'"]) && isset($taALL_regional[3]["'06'"])) {
			$dt_nas4_06 = $taALL_regional[0]["'06'"] + $taALL_regional[1]["'06'"] + $taALL_regional[2]["'06'"] + $taALL_regional[3]["'06'"];
		}
		$dt_nas4_07 = 0;
		if (isset($taALL_regional[0]["'07'"]) && isset($taALL_regional[1]["'07'"]) && isset($taALL_regional[2]["'07'"]) && isset($taALL_regional[3]["'07'"])) {
			$dt_nas4_07 = $taALL_regional[0]["'07'"] + $taALL_regional[1]["'07'"] + $taALL_regional[2]["'07'"] + $taALL_regional[3]["'07'"];
		}
		$dt_nas4_08 = 0;
		if (isset($taALL_regional[0]["'08'"]) && isset($taALL_regional[1]["'08'"]) && isset($taALL_regional[2]["'08'"]) && isset($taALL_regional[3]["'08'"])) {
			$dt_nas4_08 = $taALL_regional[0]["'08'"] + $taALL_regional[1]["'08'"] + $taALL_regional[2]["'08'"] + $taALL_regional[3]["'08'"];
		}
		$dt_nas4_09 = 0;
		if (isset($taALL_regional[0]["'09'"]) && isset($taALL_regional[1]["'09'"]) && isset($taALL_regional[2]["'09'"]) && isset($taALL_regional[3]["'09'"])) {
			$dt_nas4_09 = $taALL_regional[0]["'09'"] + $taALL_regional[1]["'09'"] + $taALL_regional[2]["'09'"] + $taALL_regional[3]["'09'"];
		}
		$dt_nas4_10 = 0;
		if (isset($taALL_regional[0]["'10'"]) && isset($taALL_regional[1]["'10'"]) && isset($taALL_regional[2]["'10'"]) && isset($taALL_regional[3]["'10'"])) {
			$dt_nas4_10 = $taALL_regional[0]["'10'"] + $taALL_regional[1]["'10'"] + $taALL_regional[2]["'10'"] + $taALL_regional[3]["'10'"];
		}
		$dt_nas4_11 = 0;
		if (isset($taALL_regional[0]["'11'"]) && isset($taALL_regional[1]["'11'"]) && isset($taALL_regional[2]["'11'"]) && isset($taALL_regional[3]["'11'"])) {
			$dt_nas4_11 = $taALL_regional[0]["'11'"] + $taALL_regional[1]["'11'"] + $taALL_regional[2]["'11'"] + $taALL_regional[3]["'11'"];
		}
		$dt_nas4_12 = 0;
		if (isset($taALL_regional[0]["'12'"]) && isset($taALL_regional[1]["'12'"]) && isset($taALL_regional[2]["'12'"]) && isset($taALL_regional[3]["'12'"])) {
			$dt_nas4_12 = $taALL_regional[0]["'12'"] + $taALL_regional[1]["'12'"] + $taALL_regional[2]["'12'"] + $taALL_regional[3]["'12'"];
		}

		$arr_nas4[] = array(
			"ID_REGION" => 'ALL',
            "ID_DATA" => $taALL_regional[0]["ID_DATA"],
            "'01'" => $dt_nas4_01,
            "'02'" => $dt_nas4_02,
            "'03'" => $dt_nas4_03,
            "'04'" => $dt_nas4_04,
            "'05'" => $dt_nas4_05,
            "'06'" => $dt_nas4_06,
            "'07'" => $dt_nas4_07,
            "'08'" => $dt_nas4_08,
            "'09'" => $dt_nas4_09,
            "'10'" => $dt_nas4_10,
            "'11'" => $dt_nas4_11,
            "'12'" => $dt_nas4_12
		);

		$tvms_regional = $this->Dashboard_PMB_model->get_tvmsregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$tlelang_regional = $this->Dashboard_PMB_model->get_tlelangregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$sellinMSC_regional = $this->Dashboard_PMB_model->get_sellinMSCregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$selloutSDG_regional = $this->Dashboard_PMB_model->get_selloutSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$dt_nas5_01 = 0;
		if (isset($selloutSDG_regional[0]["'01'"]) && isset($selloutSDG_regional[1]["'01'"]) && isset($selloutSDG_regional[2]["'01'"]) && isset($selloutSDG_regional[3]["'01'"])) {
			$dt_nas5_01 = $selloutSDG_regional[0]["'01'"] + $selloutSDG_regional[1]["'01'"] + $selloutSDG_regional[2]["'01'"] + $selloutSDG_regional[3]["'01'"];
		}
		$dt_nas5_02 = 0;
		if (isset($selloutSDG_regional[0]["'02'"]) && isset($selloutSDG_regional[1]["'02'"]) && isset($selloutSDG_regional[2]["'02'"]) && isset($selloutSDG_regional[3]["'02'"])) {
			$dt_nas5_02 = $selloutSDG_regional[0]["'02'"] + $selloutSDG_regional[1]["'02'"] + $selloutSDG_regional[2]["'02'"] + $selloutSDG_regional[3]["'02'"];
		}
		$dt_nas5_03 = 0;
		if (isset($selloutSDG_regional[0]["'03'"]) && isset($selloutSDG_regional[1]["'03'"]) && isset($selloutSDG_regional[2]["'03'"]) && isset($selloutSDG_regional[3]["'03'"])) {
			$dt_nas5_03 = $selloutSDG_regional[0]["'03'"] + $selloutSDG_regional[1]["'03'"] + $selloutSDG_regional[2]["'03'"] + $selloutSDG_regional[3]["'03'"];
		}
		$dt_nas5_04 = 0;
		if (isset($selloutSDG_regional[0]["'04'"]) && isset($selloutSDG_regional[1]["'04'"]) && isset($selloutSDG_regional[2]["'04'"]) && isset($selloutSDG_regional[3]["'04'"])) {
			$dt_nas5_04 = $selloutSDG_regional[0]["'04'"] + $selloutSDG_regional[1]["'04'"] + $selloutSDG_regional[2]["'04'"] + $selloutSDG_regional[3]["'04'"];
		}
		$dt_nas5_05 = 0;
		if (isset($selloutSDG_regional[0]["'05'"]) && isset($selloutSDG_regional[1]["'05'"]) && isset($selloutSDG_regional[2]["'05'"]) && isset($selloutSDG_regional[3]["'05'"])) {
			$dt_nas5_05 = $selloutSDG_regional[0]["'05'"] + $selloutSDG_regional[1]["'05'"] + $selloutSDG_regional[2]["'05'"] + $selloutSDG_regional[3]["'05'"];
		}
		$dt_nas5_06 = 0;
		if (isset($selloutSDG_regional[0]["'06'"]) && isset($selloutSDG_regional[1]["'06'"]) && isset($selloutSDG_regional[2]["'06'"]) && isset($selloutSDG_regional[3]["'06'"])) {
			$dt_nas5_06 = $selloutSDG_regional[0]["'06'"] + $selloutSDG_regional[1]["'06'"] + $selloutSDG_regional[2]["'06'"] + $selloutSDG_regional[3]["'06'"];
		}
		$dt_nas5_07 = 0;
		if (isset($selloutSDG_regional[0]["'07'"]) && isset($selloutSDG_regional[1]["'07'"]) && isset($selloutSDG_regional[2]["'07'"]) && isset($selloutSDG_regional[3]["'07'"])) {
			$dt_nas5_07 = $selloutSDG_regional[0]["'07'"] + $selloutSDG_regional[1]["'07'"] + $selloutSDG_regional[2]["'07'"] + $selloutSDG_regional[3]["'07'"];
		}
		$dt_nas5_08 = 0;
		if (isset($selloutSDG_regional[0]["'08'"]) && isset($selloutSDG_regional[1]["'08'"]) && isset($selloutSDG_regional[2]["'08'"]) && isset($selloutSDG_regional[3]["'08'"])) {
			$dt_nas5_08 = $selloutSDG_regional[0]["'08'"] + $selloutSDG_regional[1]["'08'"] + $selloutSDG_regional[2]["'08'"] + $selloutSDG_regional[3]["'08'"];
		}
		$dt_nas5_09 = 0;
		if (isset($selloutSDG_regional[0]["'09'"]) && isset($selloutSDG_regional[1]["'09'"]) && isset($selloutSDG_regional[2]["'09'"]) && isset($selloutSDG_regional[3]["'09'"])) {
			$dt_nas5_09 = $selloutSDG_regional[0]["'09'"] + $selloutSDG_regional[1]["'09'"] + $selloutSDG_regional[2]["'09'"] + $selloutSDG_regional[3]["'09'"];
		}
		$dt_nas5_10 = 0;
		if (isset($selloutSDG_regional[0]["'10'"]) && isset($selloutSDG_regional[1]["'10'"]) && isset($selloutSDG_regional[2]["'10'"]) && isset($selloutSDG_regional[3]["'10'"])) {
			$dt_nas5_10 = $selloutSDG_regional[0]["'10'"] + $selloutSDG_regional[1]["'10'"] + $selloutSDG_regional[2]["'10'"] + $selloutSDG_regional[3]["'10'"];
		}
		$dt_nas5_11 = 0;
		if (isset($selloutSDG_regional[0]["'11'"]) && isset($selloutSDG_regional[1]["'11'"]) && isset($selloutSDG_regional[2]["'11'"]) && isset($selloutSDG_regional[3]["'11'"])) {
			$dt_nas5_11 = $selloutSDG_regional[0]["'11'"] + $selloutSDG_regional[1]["'11'"] + $selloutSDG_regional[2]["'11'"] + $selloutSDG_regional[3]["'11'"];
		}
		$dt_nas5_12 = 0;
		if (isset($selloutSDG_regional[0]["'12'"]) && isset($selloutSDG_regional[1]["'12'"]) && isset($selloutSDG_regional[2]["'12'"]) && isset($selloutSDG_regional[3]["'12'"])) {
			$dt_nas5_12 = $selloutSDG_regional[0]["'12'"] + $selloutSDG_regional[1]["'12'"] + $selloutSDG_regional[2]["'12'"] + $selloutSDG_regional[3]["'12'"];
		}

		$arr_nas5[] = array(
			"ID_REGION" => 'ALL',
            "ID_DATA" => $selloutSDG_regional[0]["ID_DATA"],
            "'01'" => $dt_nas5_01,
            "'02'" => $dt_nas5_02,
            "'03'" => $dt_nas5_03,
            "'04'" => $dt_nas5_04,
            "'05'" => $dt_nas5_05,
            "'06'" => $dt_nas5_06,
            "'07'" => $dt_nas5_07,
            "'08'" => $dt_nas5_08,
            "'09'" => $dt_nas5_09,
            "'10'" => $dt_nas5_10,
            "'11'" => $dt_nas5_11,
            "'12'" => $dt_nas5_12
		);

		$selloutERPSDG_regional = $this->Dashboard_PMB_model->get_selloutERPSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$REVselloutSDG_regional = $this->Dashboard_PMB_model->get_REVselloutSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$REVselloutERPSDG_regional = $this->Dashboard_PMB_model->get_REVselloutERPSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$levelstokSDG_regional = $this->Dashboard_PMB_model->get_levelstokSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4);

		$arr_nas6 = $this->Dashboard_PMB_model->get_levelstokSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,'nas');

		// print_r('<pre>');
		// print_r($levelstokSDG_regional_nas);exit;

		// $dt_nas6_01 = 0;
		// if (isset($levelstokSDG_regional[0]["'01'"]) && isset($levelstokSDG_regional[1]["'01'"]) && isset($levelstokSDG_regional[2]["'01'"]) && isset($levelstokSDG_regional[3]["'01'"])) {
		// 	$dt_nas6_01 = $levelstokSDG_regional[0]["'01'"] + $levelstokSDG_regional[1]["'01'"] + $levelstokSDG_regional[2]["'01'"] + $levelstokSDG_regional[3]["'01'"];
		// }
		// $dt_nas6_02 = 0;
		// if (isset($levelstokSDG_regional[0]["'02'"]) && isset($levelstokSDG_regional[1]["'02'"]) && isset($levelstokSDG_regional[2]["'02'"]) && isset($levelstokSDG_regional[3]["'02'"])) {
		// 	$dt_nas6_02 = $levelstokSDG_regional[0]["'02'"] + $levelstokSDG_regional[1]["'02'"] + $levelstokSDG_regional[2]["'02'"] + $levelstokSDG_regional[3]["'02'"];
		// }
		// $dt_nas6_03 = 0;
		// if (isset($levelstokSDG_regional[0]["'03'"]) && isset($levelstokSDG_regional[1]["'03'"]) && isset($levelstokSDG_regional[2]["'03'"]) && isset($levelstokSDG_regional[3]["'03'"])) {
		// 	$dt_nas6_03 = $levelstokSDG_regional[0]["'03'"] + $levelstokSDG_regional[1]["'03'"] + $levelstokSDG_regional[2]["'03'"] + $levelstokSDG_regional[3]["'03'"];
		// }
		// $dt_nas6_04 = 0;
		// if (isset($levelstokSDG_regional[0]["'04'"]) && isset($levelstokSDG_regional[1]["'04'"]) && isset($levelstokSDG_regional[2]["'04'"]) && isset($levelstokSDG_regional[3]["'04'"])) {
		// 	$dt_nas6_04 = $levelstokSDG_regional[0]["'04'"] + $levelstokSDG_regional[1]["'04'"] + $levelstokSDG_regional[2]["'04'"] + $levelstokSDG_regional[3]["'04'"];
		// }
		// $dt_nas6_05 = 0;
		// if (isset($levelstokSDG_regional[0]["'05'"]) && isset($levelstokSDG_regional[1]["'05'"]) && isset($levelstokSDG_regional[2]["'05'"]) && isset($levelstokSDG_regional[3]["'05'"])) {
		// 	$dt_nas6_05 = $levelstokSDG_regional[0]["'05'"] + $levelstokSDG_regional[1]["'05'"] + $levelstokSDG_regional[2]["'05'"] + $levelstokSDG_regional[3]["'05'"];
		// }
		// $dt_nas6_06 = 0;
		// if (isset($levelstokSDG_regional[0]["'06'"]) && isset($levelstokSDG_regional[1]["'06'"]) && isset($levelstokSDG_regional[2]["'06'"]) && isset($levelstokSDG_regional[3]["'06'"])) {
		// 	$dt_nas6_06 = $levelstokSDG_regional[0]["'06'"] + $levelstokSDG_regional[1]["'06'"] + $levelstokSDG_regional[2]["'06'"] + $levelstokSDG_regional[3]["'06'"];
		// }
		// $dt_nas6_07 = 0;
		// if (isset($levelstokSDG_regional[0]["'07'"]) && isset($levelstokSDG_regional[1]["'07'"]) && isset($levelstokSDG_regional[2]["'07'"]) && isset($levelstokSDG_regional[3]["'07'"])) {
		// 	$dt_nas6_07 = $levelstokSDG_regional[0]["'07'"] + $levelstokSDG_regional[1]["'07'"] + $levelstokSDG_regional[2]["'07'"] + $levelstokSDG_regional[3]["'07'"];
		// }
		// $dt_nas6_08 = 0;
		// if (isset($levelstokSDG_regional[0]["'08'"]) && isset($levelstokSDG_regional[1]["'08'"]) && isset($levelstokSDG_regional[2]["'08'"]) && isset($levelstokSDG_regional[3]["'08'"])) {
		// 	$dt_nas6_08 = $levelstokSDG_regional[0]["'08'"] + $levelstokSDG_regional[1]["'08'"] + $levelstokSDG_regional[2]["'08'"] + $levelstokSDG_regional[3]["'08'"];
		// }
		// $dt_nas6_09 = 0;
		// if (isset($levelstokSDG_regional[0]["'09'"]) && isset($levelstokSDG_regional[1]["'09'"]) && isset($levelstokSDG_regional[2]["'09'"]) && isset($levelstokSDG_regional[3]["'09'"])) {
		// 	$dt_nas6_09 = $levelstokSDG_regional[0]["'09'"] + $levelstokSDG_regional[1]["'09'"] + $levelstokSDG_regional[2]["'09'"] + $levelstokSDG_regional[3]["'09'"];
		// }
		// $dt_nas6_10 = 0;
		// if (isset($levelstokSDG_regional[0]["'10'"]) && isset($levelstokSDG_regional[1]["'10'"]) && isset($levelstokSDG_regional[2]["'10'"]) && isset($levelstokSDG_regional[3]["'10'"])) {
		// 	$dt_nas6_10 = $levelstokSDG_regional[0]["'10'"] + $levelstokSDG_regional[1]["'10'"] + $levelstokSDG_regional[2]["'10'"] + $levelstokSDG_regional[3]["'10'"];
		// }
		// $dt_nas6_11 = 0;
		// if (isset($levelstokSDG_regional[0]["'11'"]) && isset($levelstokSDG_regional[1]["'11'"]) && isset($levelstokSDG_regional[2]["'11'"]) && isset($levelstokSDG_regional[3]["'11'"])) {
		// 	$dt_nas6_11 = $levelstokSDG_regional[0]["'11'"] + $levelstokSDG_regional[1]["'11'"] + $levelstokSDG_regional[2]["'11'"] + $levelstokSDG_regional[3]["'11'"];
		// }
		// $dt_nas6_12 = 0;
		// if (isset($levelstokSDG_regional[0]["'12'"]) && isset($levelstokSDG_regional[1]["'12'"]) && isset($levelstokSDG_regional[2]["'12'"]) && isset($levelstokSDG_regional[3]["'12'"])) {
		// 	$dt_nas6_12 = $levelstokSDG_regional[0]["'12'"] + $levelstokSDG_regional[1]["'12'"] + $levelstokSDG_regional[2]["'12'"] + $levelstokSDG_regional[3]["'12'"];
		// }

		// $arr_nas6[] = array(
		// 	"ID_REGION" => 'ALL',
  //           "ID_DATA" => $levelstokSDG_regional[0]["ID_DATA"],
  //           "'01'" => $dt_nas6_01,
  //           "'02'" => $dt_nas6_02,
  //           "'03'" => $dt_nas6_03,
  //           "'04'" => $dt_nas6_04,
  //           "'05'" => $dt_nas6_05,
  //           "'06'" => $dt_nas6_06,
  //           "'07'" => $dt_nas6_07,
  //           "'08'" => $dt_nas6_08,
  //           "'09'" => $dt_nas6_09,
  //           "'10'" => $dt_nas6_10,
  //           "'11'" => $dt_nas6_11,
  //           "'12'" => $dt_nas6_12
		// );

		$jmlsales_regional = $this->Dashboard_PMB_model->get_jmlsalesregional();

		$dt_nas7_01 = 0;
		if (isset($jmlsales_regional[0]["'01'"]) && isset($jmlsales_regional[1]["'01'"]) && isset($jmlsales_regional[2]["'01'"]) && isset($jmlsales_regional[3]["'01'"])) {
			$dt_nas7_01 = $jmlsales_regional[0]["'01'"] + $jmlsales_regional[1]["'01'"] + $jmlsales_regional[2]["'01'"] + $jmlsales_regional[3]["'01'"];
		}
		$dt_nas7_02 = 0;
		if (isset($jmlsales_regional[0]["'02'"]) && isset($jmlsales_regional[1]["'02'"]) && isset($jmlsales_regional[2]["'02'"]) && isset($jmlsales_regional[3]["'02'"])) {
			$dt_nas7_02 = $jmlsales_regional[0]["'02'"] + $jmlsales_regional[1]["'02'"] + $jmlsales_regional[2]["'02'"] + $jmlsales_regional[3]["'02'"];
		}
		$dt_nas7_03 = 0;
		if (isset($jmlsales_regional[0]["'03'"]) && isset($jmlsales_regional[1]["'03'"]) && isset($jmlsales_regional[2]["'03'"]) && isset($jmlsales_regional[3]["'03'"])) {
			$dt_nas7_03 = $jmlsales_regional[0]["'03'"] + $jmlsales_regional[1]["'03'"] + $jmlsales_regional[2]["'03'"] + $jmlsales_regional[3]["'03'"];
		}
		$dt_nas7_04 = 0;
		if (isset($jmlsales_regional[0]["'04'"]) && isset($jmlsales_regional[1]["'04'"]) && isset($jmlsales_regional[2]["'04'"]) && isset($jmlsales_regional[3]["'04'"])) {
			$dt_nas7_04 = $jmlsales_regional[0]["'04'"] + $jmlsales_regional[1]["'04'"] + $jmlsales_regional[2]["'04'"] + $jmlsales_regional[3]["'04'"];
		}
		$dt_nas7_05 = 0;
		if (isset($jmlsales_regional[0]["'05'"]) && isset($jmlsales_regional[1]["'05'"]) && isset($jmlsales_regional[2]["'05'"]) && isset($jmlsales_regional[3]["'05'"])) {
			$dt_nas7_05 = $jmlsales_regional[0]["'05'"] + $jmlsales_regional[1]["'05'"] + $jmlsales_regional[2]["'05'"] + $jmlsales_regional[3]["'05'"];
		}
		$dt_nas7_06 = 0;
		if (isset($jmlsales_regional[0]["'06'"]) && isset($jmlsales_regional[1]["'06'"]) && isset($jmlsales_regional[2]["'06'"]) && isset($jmlsales_regional[3]["'06'"])) {
			$dt_nas7_06 = $jmlsales_regional[0]["'06'"] + $jmlsales_regional[1]["'06'"] + $jmlsales_regional[2]["'06'"] + $jmlsales_regional[3]["'06'"];
		}
		$dt_nas7_07 = 0;
		if (isset($jmlsales_regional[0]["'07'"]) && isset($jmlsales_regional[1]["'07'"]) && isset($jmlsales_regional[2]["'07'"]) && isset($jmlsales_regional[3]["'07'"])) {
			$dt_nas7_07 = $jmlsales_regional[0]["'07'"] + $jmlsales_regional[1]["'07'"] + $jmlsales_regional[2]["'07'"] + $jmlsales_regional[3]["'07'"];
		}
		$dt_nas7_08 = 0;
		if (isset($jmlsales_regional[0]["'08'"]) && isset($jmlsales_regional[1]["'08'"]) && isset($jmlsales_regional[2]["'08'"]) && isset($jmlsales_regional[3]["'08'"])) {
			$dt_nas7_08 = $jmlsales_regional[0]["'08'"] + $jmlsales_regional[1]["'08'"] + $jmlsales_regional[2]["'08'"] + $jmlsales_regional[3]["'08'"];
		}
		$dt_nas7_09 = 0;
		if (isset($jmlsales_regional[0]["'09'"]) && isset($jmlsales_regional[1]["'09'"]) && isset($jmlsales_regional[2]["'09'"]) && isset($jmlsales_regional[3]["'09'"])) {
			$dt_nas7_09 = $jmlsales_regional[0]["'09'"] + $jmlsales_regional[1]["'09'"] + $jmlsales_regional[2]["'09'"] + $jmlsales_regional[3]["'09'"];
		}
		$dt_nas7_10 = 0;
		if (isset($jmlsales_regional[0]["'10'"]) && isset($jmlsales_regional[1]["'10'"]) && isset($jmlsales_regional[2]["'10'"]) && isset($jmlsales_regional[3]["'10'"])) {
			$dt_nas7_10 = $jmlsales_regional[0]["'10'"] + $jmlsales_regional[1]["'10'"] + $jmlsales_regional[2]["'10'"] + $jmlsales_regional[3]["'10'"];
		}
		$dt_nas7_11 = 0;
		if (isset($jmlsales_regional[0]["'11'"]) && isset($jmlsales_regional[1]["'11'"]) && isset($jmlsales_regional[2]["'11'"]) && isset($jmlsales_regional[3]["'11'"])) {
			$dt_nas7_11 = $jmlsales_regional[0]["'11'"] + $jmlsales_regional[1]["'11'"] + $jmlsales_regional[2]["'11'"] + $jmlsales_regional[3]["'11'"];
		}
		$dt_nas7_12 = 0;
		if (isset($jmlsales_regional[0]["'12'"]) && isset($jmlsales_regional[1]["'12'"]) && isset($jmlsales_regional[2]["'12'"]) && isset($jmlsales_regional[3]["'12'"])) {
			$dt_nas7_12 = $jmlsales_regional[0]["'12'"] + $jmlsales_regional[1]["'12'"] + $jmlsales_regional[2]["'12'"] + $jmlsales_regional[3]["'12'"];
		}

		$arr_nas7[] = array(
			"ID_REGION" => 'ALL',
            "ID_DATA" => $jmlsales_regional[0]["ID_DATA"],
            "'01'" => $dt_nas7_01,
            "'02'" => $dt_nas7_02,
            "'03'" => $dt_nas7_03,
            "'04'" => $dt_nas7_04,
            "'05'" => $dt_nas7_05,
            "'06'" => $dt_nas7_06,
            "'07'" => $dt_nas7_07,
            "'08'" => $dt_nas7_08,
            "'09'" => $dt_nas7_09,
            "'10'" => $dt_nas7_10,
            "'11'" => $dt_nas7_11,
            "'12'" => $dt_nas7_12
		);

		$visit_regional = $this->Dashboard_PMB_model->get_visitregional();

		$dt_nas8_01 = 0;
		if (isset($visit_regional[0]["'01'"]) && isset($visit_regional[1]["'01'"]) && isset($visit_regional[2]["'01'"]) && isset($visit_regional[3]["'01'"])) {
			$dt_nas8_01 = $visit_regional[0]["'01'"] + $visit_regional[1]["'01'"] + $visit_regional[2]["'01'"] + $visit_regional[3]["'01'"];
		}
		$dt_nas8_02 = 0;
		if (isset($visit_regional[0]["'02'"]) && isset($visit_regional[1]["'02'"]) && isset($visit_regional[2]["'02'"]) && isset($visit_regional[3]["'02'"])) {
			$dt_nas8_02 = $visit_regional[0]["'02'"] + $visit_regional[1]["'02'"] + $visit_regional[2]["'02'"] + $visit_regional[3]["'02'"];
		}
		$dt_nas8_03 = 0;
		if (isset($visit_regional[0]["'03'"]) && isset($visit_regional[1]["'03'"]) && isset($visit_regional[2]["'03'"]) && isset($visit_regional[3]["'03'"])) {
			$dt_nas8_03 = $visit_regional[0]["'03'"] + $visit_regional[1]["'03'"] + $visit_regional[2]["'03'"] + $visit_regional[3]["'03'"];
		}
		$dt_nas8_04 = 0;
		if (isset($visit_regional[0]["'04'"]) && isset($visit_regional[1]["'04'"]) && isset($visit_regional[2]["'04'"]) && isset($visit_regional[3]["'04'"])) {
			$dt_nas8_04 = $visit_regional[0]["'04'"] + $visit_regional[1]["'04'"] + $visit_regional[2]["'04'"] + $visit_regional[3]["'04'"];
		}
		$dt_nas8_05 = 0;
		if (isset($visit_regional[0]["'05'"]) && isset($visit_regional[1]["'05'"]) && isset($visit_regional[2]["'05'"]) && isset($visit_regional[3]["'05'"])) {
			$dt_nas8_05 = $visit_regional[0]["'05'"] + $visit_regional[1]["'05'"] + $visit_regional[2]["'05'"] + $visit_regional[3]["'05'"];
		}
		$dt_nas8_06 = 0;
		if (isset($visit_regional[0]["'06'"]) && isset($visit_regional[1]["'06'"]) && isset($visit_regional[2]["'06'"]) && isset($visit_regional[3]["'06'"])) {
			$dt_nas8_06 = $visit_regional[0]["'06'"] + $visit_regional[1]["'06'"] + $visit_regional[2]["'06'"] + $visit_regional[3]["'06'"];
		}
		$dt_nas8_07 = 0;
		if (isset($visit_regional[0]["'07'"]) && isset($visit_regional[1]["'07'"]) && isset($visit_regional[2]["'07'"]) && isset($visit_regional[3]["'07'"])) {
			$dt_nas8_07 = $visit_regional[0]["'07'"] + $visit_regional[1]["'07'"] + $visit_regional[2]["'07'"] + $visit_regional[3]["'07'"];
		}
		$dt_nas8_08 = 0;
		if (isset($visit_regional[0]["'08'"]) && isset($visit_regional[1]["'08'"]) && isset($visit_regional[2]["'08'"]) && isset($visit_regional[3]["'08'"])) {
			$dt_nas8_08 = $visit_regional[0]["'08'"] + $visit_regional[1]["'08'"] + $visit_regional[2]["'08'"] + $visit_regional[3]["'08'"];
		}
		$dt_nas8_09 = 0;
		if (isset($visit_regional[0]["'09'"]) && isset($visit_regional[1]["'09'"]) && isset($visit_regional[2]["'09'"]) && isset($visit_regional[3]["'09'"])) {
			$dt_nas8_09 = $visit_regional[0]["'09'"] + $visit_regional[1]["'09'"] + $visit_regional[2]["'09'"] + $visit_regional[3]["'09'"];
		}
		$dt_nas8_10 = 0;
		if (isset($visit_regional[0]["'10'"]) && isset($visit_regional[1]["'10'"]) && isset($visit_regional[2]["'10'"]) && isset($visit_regional[3]["'10'"])) {
			$dt_nas8_10 = $visit_regional[0]["'10'"] + $visit_regional[1]["'10'"] + $visit_regional[2]["'10'"] + $visit_regional[3]["'10'"];
		}
		$dt_nas8_11 = 0;
		if (isset($visit_regional[0]["'11'"]) && isset($visit_regional[1]["'11'"]) && isset($visit_regional[2]["'11'"]) && isset($visit_regional[3]["'11'"])) {
			$dt_nas8_11 = $visit_regional[0]["'11'"] + $visit_regional[1]["'11'"] + $visit_regional[2]["'11'"] + $visit_regional[3]["'11'"];
		}
		$dt_nas8_12 = 0;
		if (isset($visit_regional[0]["'12'"]) && isset($visit_regional[1]["'12'"]) && isset($visit_regional[2]["'12'"]) && isset($visit_regional[3]["'12'"])) {
			$dt_nas8_12 = $visit_regional[0]["'12'"] + $visit_regional[1]["'12'"] + $visit_regional[2]["'12'"] + $visit_regional[3]["'12'"];
		}

		$arr_nas8[] = array(
			"ID_REGION" => 'ALL',
            "ID_DATA" => $visit_regional[0]["ID_DATA"],
            "'01'" => $dt_nas8_01,
            "'02'" => $dt_nas8_02,
            "'03'" => $dt_nas8_03,
            "'04'" => $dt_nas8_04,
            "'05'" => $dt_nas8_05,
            "'06'" => $dt_nas8_06,
            "'07'" => $dt_nas8_07,
            "'08'" => $dt_nas8_08,
            "'09'" => $dt_nas8_09,
            "'10'" => $dt_nas8_10,
            "'11'" => $dt_nas8_11,
            "'12'" => $dt_nas8_12
		);

		// print_r('<pre>');
		// print_r($arr_nas1);exit;

		// array_push($arr_tdftrregional, $tdftr_regional);

		$arr_merge = array_merge($tdftr_regional,$tb_regional,$taIBK_regional,$taALL_regional,$tvms_regional,$tlelang_regional,$sellinMSC_regional,$selloutSDG_regional,$selloutERPSDG_regional,$REVselloutSDG_regional,$REVselloutERPSDG_regional,$levelstokSDG_regional,$jmlsales_regional,$visit_regional);

		// print_r('<pre>');
		// print_r($arr_merge);exit;


		$data['dt_regional'] = $arr_merge;

		$mg_arr = array();
		foreach ($arr_merge as $v_mg) {
			for ($mg=1; $mg <= date('m'); $mg++) { 

				// print_r('<pre>');
				// print_r($v_mg[0]['ID_REGION']);exit;

				$dt = "'".str_pad($mg,2,"0",STR_PAD_LEFT)."'";

				$nilai = 0;
				if (isset($v_mg["$dt"])) {
					$nilai = round($v_mg["$dt"]);
				}

				$thn_bln = date('Y').'-'.str_pad($mg,2,"0",STR_PAD_LEFT);

				$mg_arr[] = array(
					'ID_REGION'	=> $v_mg['ID_REGION'],
					'ID_DATA'	=> $v_mg['ID_DATA'],
					'BULAN'		=> date('M', strtotime($thn_bln)),
					'DATA'		=> $nilai
				);

			}
		}

		$data['dt_grafik'] = $mg_arr;






		// $list_bln = '';
		// $arr_bln = '';

		// $reg_all = "'1','2','3','4'";

		// $getDistr_all = $this->Dashboard_PMB_model->get_Distr($id_user, $id_jenis_user, $reg_all);
		// $getDistrik_all = $this->Dashboard_PMB_model->get_Distrik($id_user, $id_jenis_user, $reg_all);

		// $tdftr_regional_nas = $this->Dashboard_PMB_model->get_tdftrregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,'nas');

		// $tb_regional_nas = $this->Dashboard_PMB_model->get_tbregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,'nas');

		// $taIBK_regional_nas = $this->Dashboard_PMB_model->get_taIBKregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,'nas');

		// $taALL_regional_nas = $this->Dashboard_PMB_model->get_taALLregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,'nas');

		// // print_r('<pre>');
		// // print_r($taALL_regional_nas);exit;

		// $selloutSDG_regional_nas = $this->Dashboard_PMB_model->get_selloutSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,'nas');

		// $levelstokSDG_regional_nas = $this->Dashboard_PMB_model->get_levelstokSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,'nas');

		// $jmlsales_regional_nas = $this->Dashboard_PMB_model->get_jmlsalesregional('nas');

		// $visit_regional_nas = $this->Dashboard_PMB_model->get_visitregional('nas');

		$arr_merge_nas = array_merge($arr_nas1,$arr_nas2,$arr_nas3,$arr_nas4,$arr_nas5,$arr_nas6,$arr_nas7,$arr_nas8);

		// print_r('<pre>');
		// print_r($arr_merge_nas);exit;

		$mg_arr_nas = array();
		foreach ($arr_merge_nas as $v_nas) {
			for ($nas=1; $nas <= date('m'); $nas++) { 

				$dt = "'".str_pad($nas,2,"0",STR_PAD_LEFT)."'";

				$nilai_nas = 0;
				if (isset($v_nas["$dt"])) {
					$nilai_nas = round($v_nas["$dt"],2);
				}

				$thn_bln = date('Y').'-'.str_pad($nas,2,"0",STR_PAD_LEFT);

				$mg_arr_nas[] = array(
					'ID_DATA'	=> $v_nas['ID_DATA'],
					'BULAN'		=> date('M', strtotime($thn_bln)),
					'DATA'		=> $nilai_nas
				);

			}
		}

		$data['dt_nasional'] = $mg_arr_nas;
		
		// print_r('<pre>');
		// print_r($mg_arr_nas);exit;
		

		// foreach ($arr_merge as $arr_v) {

		// 	if (!isset($arr_v["'01'"])) {
		// 		$arr_v["'01'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'02'"])) {
		// 		$arr_v["'02'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'03'"])) {
		// 		$arr_v["'03'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'04'"])) {
		// 		$arr_v["'04'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'05'"])) {
		// 		$arr_v["'05'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'06'"])) {
		// 		$arr_v["'06'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'07'"])) {
		// 		$arr_v["'07'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'08'"])) {
		// 		$arr_v["'08'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'09'"])) {
		// 		$arr_v["'09'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'10'"])) {
		// 		$arr_v["'10'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'11'"])) {
		// 		$arr_v["'11'"] = 0;
		// 	}

		// 	if (!isset($arr_v["'12'"])) {
		// 		$arr_v["'12'"] = 0;
		// 	}


		// 	for ($a=1; $a <= date('m'); $a++) { 
		// 		$list_bln .= date('M', strtotime(date('Y').'-'.str_pad($a,2,"0",STR_PAD_LEFT))).',';
		// 		$list_bln_f = substr_replace($list_bln, '', -1);

		// 		$arr_bln .= $arr_v["'".str_pad($a,2,"0",STR_PAD_LEFT)."'"].',';
		// 		$arr_bln_f = substr_replace($arr_bln, '', -1);
		// 	}

		// 	$jan = date('M', strtotime(date('Y').'-01')).',';
		// 	$feb = date('M', strtotime(date('Y').'-02')).',';
		// 	$mar = date('M', strtotime(date('Y').'-03')).',';
		// 	$apr = date('M', strtotime(date('Y').'-04')).',';
		// 	$may = date('M', strtotime(date('Y').'-05')).',';
		// 	$jun = date('M', strtotime(date('Y').'-06')).',';
		// 	$jul = date('M', strtotime(date('Y').'-07')).',';
		// 	$aug = date('M', strtotime(date('Y').'-08')).',';
		// 	$sep = date('M', strtotime(date('Y').'-09')).',';
		// 	$oct = date('M', strtotime(date('Y').'-10')).',';
		// 	$nov = date('M', strtotime(date('Y').'-11')).',';
		// 	$dec = date('M', strtotime(date('Y').'-12')).',';

		// 	$v_jan = round($arr_v["'01'"]).',';
		// 	$v_feb = round($arr_v["'02'"]).',';
		// 	$v_mar = round($arr_v["'03'"]).',';
		// 	$v_apr = round($arr_v["'04'"]).',';
		// 	$v_may = round($arr_v["'05'"]).',';
		// 	$v_jun = round($arr_v["'06'"]).',';
		// 	$v_jul = round($arr_v["'07'"]).',';
		// 	$v_aug = round($arr_v["'08'"]).',';
		// 	$v_sep = round($arr_v["'09'"]).',';
		// 	$v_oct = round($arr_v["'10'"]).',';
		// 	$v_nov = round($arr_v["'11'"]).',';
		// 	$v_dec = round($arr_v["'12'"]).',';

		// 	$list_bln = '';
		// 	$list_value = '';

		// 	if (date('M') == 'Jan') {
		// 		$list_bln = $jan;
		// 		$list_value = $v_jan;
		// 	} elseif (date('M') == 'Feb') {
		// 		$list_bln = $jan.$feb;
		// 		$list_value = $v_jan.$v_feb;
		// 	} elseif (date('M') == 'Mar') {
		// 		$list_bln = $jan.$feb.$mar;
		// 		$list_value = $v_jan.$v_feb.$v_mar;
		// 	} elseif (date('M') == 'Apr') {
		// 		$list_bln = $jan.$feb.$mar.$apr;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr;
		// 	} elseif (date('M') == 'May') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may;
		// 	} elseif (date('M') == 'Jun') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun;
		// 	} elseif (date('M') == 'Jul') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul;
		// 	} elseif (date('M') == 'Aug') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul.$aug;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul.$v_aug;
		// 	} elseif (date('M') == 'Sep') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul.$aug.$sep;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul.$v_aug.$v_sep;
		// 	} elseif (date('M') == 'Oct') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul.$aug.$sep.$oct;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul.$v_aug.$v_sep.$v_oct;
		// 	} elseif (date('M') == 'Nov') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul.$aug.$sep.$oct.$nov;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul.$v_aug.$v_sep.$v_oct.$v_nov;
		// 	} elseif (date('M') == 'Dec') {
		// 		$list_bln = $jan.$feb.$mar.$apr.$may.$jun.$jul.$aug.$sep.$oct.$nov.$dec;
		// 		$list_value = $v_jan.$v_feb.$v_mar.$v_apr.$v_may.$v_jun.$v_jul.$v_aug.$v_sep.$v_oct.$v_nov.$v_dec;
		// 	}

		// 	$list_bln_f = substr_replace($list_bln, '', -1);
		// 	$list_value_f = substr_replace($list_value, '', -1);

		// 	// print_r('<pre>');
		// 	// print_r($list_bln_f);exit;

			
		// 	$graf[] = array(
		// 		'ID_REGION'	=> $arr_v['ID_REGION'],
		// 		'ID_DATA'	=> $arr_v['ID_DATA'],
		// 		'BULAN'		=> $list_bln_f,
		// 		'DATA'		=> $list_value_f
		// 	);

		// }

        $this->template->display('Dashboard_PMB_Nas_Reg_view', $data);
	}
	
	public function ListSalesman($FilterBy, $FilterSet, $tahun, $bulan, $jns=null){

		$bulan = str_pad($bulan,2,"0",STR_PAD_LEFT);

		// print_r('<pre>');
		// print_r($FilterBy.' - '.$FilterSet);exit;

		$id_user = $this->session->userdata("user_id");
		$id_jenis_user = $this->session->userdata("id_jenis_user");


		if ($FilterSet == 'null') {
			$FilterSet = 'ALL';
			$FilterBy = '0-ALL';
		}

		// print_r('<pre>');
		// print_r($FilterBy.' - '.$FilterSet);exit;

		$by = explode('-', $FilterBy)[1];
		$set = $FilterSet;

		if ($FilterBy != '0-ALL' && $FilterSet != 'ALL') {
			$by = explode('-', $FilterBy)[1];
			$set = explode('-', $FilterSet)[0];
		}

		$date_now = date('Ymd');
		$date_min30 = date('Ymd', strtotime('-30 days'));


		$getmappinguser = $this->Dashboard_PMB_model->get_mapping_user($by, $set, $id_user, $id_jenis_user);

		if ($getmappinguser['JML'] == 0) {


			if ($jns == 'export') {
				return $hasil;
			} else {
				echo json_encode(array());
			}

		} else {

			$fromCRMSLS = $this->Dashboard_PMB_model->get_fromCRMSLS($by, $set, $tahun, $bulan, $id_user, $id_jenis_user); // Kolom Kunjungan Salesman	(Target & Actual) && Target Salesman

			foreach ($fromCRMSLS as $fromCRM) {
			    $dt_fromCRM[] = array(
			    	'ID_SALES' => $fromCRM['ID_SALES'],
			    	'NM_SALES' => $fromCRM['NM_SALES'],
		            'USER_SALES' => $fromCRM['USER_SALES'],
		            'TRG_VISIT' => $fromCRM['TRG_VISIT'],
		            'ACT_VISIT' => $fromCRM['ACT_VISIT'],
		            'TRG_TOKO_UNIT' => $fromCRM['TRG_TOKO_UNIT'],
		            'TRG_TOKO_AKTIF' => $fromCRM['TRG_TOKO_AKTIF'],
		            'TRG_TOKO_BARU' => $fromCRM['TRG_TOKO_BARU'],
		            'TRG_SELL_OUT_SDG' => $fromCRM['TRG_SELL_OUT_SDG'],
		            'TRG_SELL_OUT_BK' => $fromCRM['TRG_SELL_OUT_BK'],
			    	'ACT_SELL_OUT_SDG' => 0,
			    	'ACT_SELL_OUT_BK' => 0,
			    	'ACT_TA_BK' => 0,
			    	'ACT_TU_BK' => 0,
			    	'ACT_TB_BK' => 0
			    );
			} 

			$getcusCRM = $this->Dashboard_PMB_model->get_cusCRM($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

			$getcusSIDIGI = $this->Dashboard_PMB_model->get_cusSIDIGI($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

			$getselloutBK = $this->Dashboard_PMB_model->get_cusBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, 'sellout');

			$getTUBK = $this->Dashboard_PMB_model->get_cusBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, 'tu');

			$getTBBK = $this->Dashboard_PMB_model->get_TBBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

			// print_r('<pre>');
			// print_r($getcusCRM);exit;

			//-----sellout SIDIGI-------------------------------------------------

			$selloutSIDIGI = array();
			foreach ($getcusCRM as $cus1) {
				foreach ($getcusSIDIGI as $cus2) {
					if ($cus2['KD_CUSTOMER'] == $cus1['KD_CUSTOMER'] && (int)$cus2['KD_DISTRIBUTOR'] == (int)$cus1['KODE_DISTRIBUTOR']) {
						$selloutSIDIGI[] = array(
							'ID_SALES'	=> $cus1['ID_SALES'],
							'KD_CUSTOMER'	=> $cus1['KD_CUSTOMER'],
							'QTY_SELL_OUT'	=> $cus2['QTY_SELL_OUT']
						);
					}
				}
			}

			$result1 = array();
			foreach($selloutSIDIGI as $so => $sov) {
			    $id_sales = $sov['ID_SALES'];
			    $result1[$id_sales][] = $sov['QTY_SELL_OUT'];
			}

			$sell_out_SIDIGI = array();
			foreach($result1 as $so2 => $sov2) {
			    $sell_out_SIDIGI[] = array(
			    	'ID_SALES' => $so2,
			    	'NM_SALES' => '',
		            'USER_SALES' => '',
		            'TRG_VISIT' => 0,
		            'ACT_VISIT' => 0,
		            'TRG_TOKO_UNIT' => 0,
		            'TRG_TOKO_AKTIF' => 0,
		            'TRG_TOKO_BARU' => 0,
		            'TRG_SELL_OUT_SDG' => 0,
		            'TRG_SELL_OUT_BK' => 0,
			    	'ACT_SELL_OUT_SDG' => array_sum($sov2),
			    	'ACT_SELL_OUT_BK' => 0,
			    	'ACT_TA_BK' => 0,
			    	'ACT_TU_BK' => 0,
			    	'ACT_TB_BK' => 0
			    );
			}
			//-----sellout BK-------------------------------------------------

			$selloutBK = array();
			foreach ($getcusCRM as $cus3) {
				foreach ($getselloutBK as $cus4) {
					if ($cus4['KD_CUSTOMER'] == $cus3['KD_CUSTOMER'] && (int)$cus4['KD_DISTRIBUTOR'] == (int)$cus3['KODE_DISTRIBUTOR']) {
						$selloutBK[] = array(
							'ID_SALES'	=> $cus3['ID_SALES'],
							'KD_CUSTOMER'	=> $cus3['KD_CUSTOMER'],
							'POIN_SELL_OUT'	=> $cus4['POIN_SELL_OUT']
						);
					}
				}
			}

			$result2 = array();
			foreach($selloutBK as $sobk => $sobkv) {
			    $id_sales2 = $sobkv['ID_SALES'];
			    $result2[$id_sales2][] = $sobkv['POIN_SELL_OUT'];
			}

			$sell_out_BK = array();
			foreach($result2 as $sobk2 => $sobkv2) {
			    $sell_out_BK[] = array(
			    	'ID_SALES' => $sobk2,
			    	'NM_SALES' => '',
		            'USER_SALES' => '',
		            'TRG_VISIT' => 0,
		            'ACT_VISIT' => 0,
		            'TRG_TOKO_UNIT' => 0,
		            'TRG_TOKO_AKTIF' => 0,
		            'TRG_TOKO_BARU' => 0,
		            'TRG_SELL_OUT_SDG' => 0,
		            'TRG_SELL_OUT_BK' => 0,
			    	'ACT_SELL_OUT_SDG' => 0,
			    	'ACT_SELL_OUT_BK' => array_sum($sobkv2),
			    	'ACT_TA_BK' => count($sobkv2),
			    	'ACT_TU_BK' => 0,
			    	'ACT_TB_BK' => 0
			    );
			}

			//-----toko unit BK-------------------------------------------------

			$tokounitBK = array();
			foreach ($getcusCRM as $cus5) {
				foreach ($getTUBK as $cus6) {
					if ($cus6['KD_CUSTOMER'] == $cus5['KD_CUSTOMER'] && (int)$cus6['KD_DISTRIBUTOR'] == (int)$cus5['KODE_DISTRIBUTOR']) {
						$tokounitBK[] = array(
							'ID_SALES'	=> $cus5['ID_SALES'],
							'KD_CUSTOMER'	=> $cus5['KD_CUSTOMER'],
							'POIN_SELL_OUT'	=> $cus6['POIN_SELL_OUT']
						);
					}
				}
			}

			$result3 = array();
			foreach($tokounitBK as $tubk => $tubkv) {
			    $id_sales3 = $tubkv['ID_SALES'];
			    $result3[$id_sales3][] = $tubkv['POIN_SELL_OUT'];
			}

			$toko_unit_BK = array();
			foreach($result3 as $tubk2 => $tubkv2) {
			    $toko_unit_BK[] = array(
			    	'ID_SALES' => $tubk2,
			    	'NM_SALES' => '',
		            'USER_SALES' => '',
		            'TRG_VISIT' => 0,
		            'ACT_VISIT' => 0,
		            'TRG_TOKO_UNIT' => 0,
		            'TRG_TOKO_AKTIF' => 0,
		            'TRG_TOKO_BARU' => 0,
		            'TRG_SELL_OUT_SDG' => 0,
		            'TRG_SELL_OUT_BK' => 0,
			    	'ACT_SELL_OUT_SDG' => 0,
			    	'ACT_SELL_OUT_BK' => 0,
			    	'ACT_TA_BK' => 0,
			    	'ACT_TU_BK' => count($tubkv2),
			    	'ACT_TB_BK' => 0
			    );
			}

			//-----toko baru BK-------------------------------------------------

			$tokobaruBK = array();
			foreach ($getcusCRM as $cus7) {
				foreach ($getTBBK as $cus8) {
					if ($cus8['KD_CUSTOMER'] == $cus7['KD_CUSTOMER'] && (int)$cus8['KD_DISTRIBUTOR'] == (int)$cus7['KODE_DISTRIBUTOR']) {
						$tokobaruBK[] = array(
							'ID_SALES'	=> $cus7['ID_SALES'],
							'KD_CUSTOMER'	=> $cus7['KD_CUSTOMER'],
							'JML'	=> $cus8['JML']
						);
					}
				}
			}

			$result4 = array();
			foreach($tokobaruBK as $tbbk => $tbbkv) {
			    $id_sales4 = $tbbkv['ID_SALES'];
			    $result4[$id_sales4][] = $tbbkv['JML'];
			}

			$toko_baru_BK = array();
			foreach($result4 as $tbbk2 => $tbbkv2) {
			    $toko_baru_BK[] = array(
			    	'ID_SALES' => $tbbk2,
			    	'NM_SALES' => '',
		            'USER_SALES' => '',
		            'TRG_VISIT' => 0,
		            'ACT_VISIT' => 0,
		            'TRG_TOKO_UNIT' => 0,
		            'TRG_TOKO_AKTIF' => 0,
		            'TRG_TOKO_BARU' => 0,
		            'TRG_SELL_OUT_SDG' => 0,
		            'TRG_SELL_OUT_BK' => 0,
			    	'ACT_SELL_OUT_SDG' => 0,
			    	'ACT_SELL_OUT_BK' => 0,
			    	'ACT_TA_BK' => 0,
			    	'ACT_TU_BK' => 0,
			    	'ACT_TB_BK' => array_sum($tbbkv2)
			    );
			}

			$merge = array_merge($dt_fromCRM,$sell_out_SIDIGI,$sell_out_BK,$toko_unit_BK,$toko_baru_BK);

			// print_r('<pre>');
			// print_r($merge);exit;

			$mrg_data = array();
		    foreach ($merge as $mrg) {
		        if (isset($mrg_data[$mrg['ID_SALES']])) {
		            $mrg_data[$mrg['ID_SALES']]['TRG_TOKO_UNIT'] += $mrg['TRG_TOKO_UNIT'];
		            $mrg_data[$mrg['ID_SALES']]['ACT_TU_BK'] += $mrg['ACT_TU_BK'];
		            $mrg_data[$mrg['ID_SALES']]['TRG_VISIT'] += $mrg['TRG_VISIT'];
		            $mrg_data[$mrg['ID_SALES']]['ACT_VISIT'] += $mrg['ACT_VISIT'];
		            $mrg_data[$mrg['ID_SALES']]['TRG_TOKO_AKTIF'] += $mrg['TRG_TOKO_AKTIF'];
		            $mrg_data[$mrg['ID_SALES']]['ACT_TA_BK'] += $mrg['ACT_TA_BK'];
		            $mrg_data[$mrg['ID_SALES']]['TRG_TOKO_BARU'] += $mrg['TRG_TOKO_BARU'];
		            $mrg_data[$mrg['ID_SALES']]['ACT_TB_BK'] += $mrg['ACT_TB_BK'];
		            $mrg_data[$mrg['ID_SALES']]['TRG_SELL_OUT_SDG'] += $mrg['TRG_SELL_OUT_SDG'];
		            $mrg_data[$mrg['ID_SALES']]['ACT_SELL_OUT_SDG'] += $mrg['ACT_SELL_OUT_SDG'];
		            $mrg_data[$mrg['ID_SALES']]['TRG_SELL_OUT_BK'] += $mrg['TRG_SELL_OUT_BK'];
		            $mrg_data[$mrg['ID_SALES']]['ACT_SELL_OUT_BK'] += $mrg['ACT_SELL_OUT_BK'];
		        } else {
		            $mrg_data[$mrg['ID_SALES']] = $mrg;
		        }
		    }

			// print_r('<pre>');
			// print_r($mrg_data);exit;

			foreach ($mrg_data as $k1) {

				$persen_tu = '-';
				$persen_visit = '-';
				$persen_ta = '-';
				$persen_tb = '-';
				$persen_selloutSDG = '-';
				$persen_selloutBK = '-';

				if ($jns == 'export') {

					if ($k1['TRG_TOKO_UNIT'] != 0) {
						$persen_tu = $k1['ACT_TU_BK'] / $k1['TRG_TOKO_UNIT'] * 100;
					}

					if ($k1['TRG_VISIT'] != 0) {
						$persen_visit = $k1['ACT_VISIT'] / $k1['TRG_VISIT'] * 100;
					}

					if ($k1['TRG_TOKO_UNIT'] != 0) {
						$persen_ta = $k1['ACT_TA_BK'] / $k1['TRG_TOKO_AKTIF'] * 100;
					}

					if ($k1['TRG_TOKO_UNIT'] != 0) {
						$persen_tb = $k1['ACT_TB_BK'] / $k1['TRG_TOKO_BARU'] * 100;
					}

					if ($k1['TRG_SELL_OUT_SDG'] != 0) {
						$persen_selloutSDG = $k1['ACT_SELL_OUT_SDG'] / $k1['TRG_SELL_OUT_SDG'] * 100;
					}

					if ($k1['TRG_SELL_OUT_BK'] != 0) {
						$persen_selloutBK = $k1['ACT_SELL_OUT_BK'] / $k1['TRG_SELL_OUT_BK'] * 100;
					}

					$hasil[] = array(
						'SALESMAN'	=> $k1['USER_SALES'],
						'A_TARGET'	=> $k1['TRG_TOKO_UNIT'],
						'A_ACTUAL'	=> $k1['ACT_TU_BK'],
						'A_PERSEN'	=> $persen_tu,
						'B_TARGET'	=> $k1['TRG_VISIT'],
						'B_ACTUAL'	=> $k1['ACT_VISIT'],
						'B_PERSEN'	=> $persen_visit,
						'C_TARGET'	=> $k1['TRG_TOKO_AKTIF'],
						'C_ACTUAL'	=> $k1['ACT_TA_BK'],
						'C_PERSEN'	=> $persen_ta,
						'D_TARGET'	=> $k1['TRG_TOKO_BARU'],
						'D_ACTUAL'	=> $k1['ACT_TB_BK'],
						'D_PERSEN'	=> $persen_tb,
						'E_TARGET'	=> $k1['TRG_SELL_OUT_SDG'],
						'E_ACTUAL'	=> $k1['ACT_SELL_OUT_SDG'],
						'E_PERSEN'	=> $persen_selloutSDG,
						'F_TARGET'	=> $k1['TRG_SELL_OUT_BK'],
						'F_ACTUAL'	=> $k1['ACT_SELL_OUT_BK'],
						'F_PERSEN'	=> $persen_selloutBK
					);
					
				} else {

					if ($k1['TRG_TOKO_UNIT'] != 0) {
						$persen_tu = number_format($k1['ACT_TU_BK'] / $k1['TRG_TOKO_UNIT'] * 100);
					}

					if ($k1['TRG_VISIT'] != 0) {
						$persen_visit = number_format($k1['ACT_VISIT'] / $k1['TRG_VISIT'] * 100);
					}

					if ($k1['TRG_TOKO_UNIT'] != 0) {
						$persen_ta = number_format($k1['ACT_TA_BK'] / $k1['TRG_TOKO_AKTIF'] * 100);
					}

					if ($k1['TRG_TOKO_UNIT'] != 0) {
						$persen_tb = number_format($k1['ACT_TB_BK'] / $k1['TRG_TOKO_BARU'] * 100);
					}

					if ($k1['TRG_SELL_OUT_SDG'] != 0) {
						$persen_selloutSDG = number_format($k1['ACT_SELL_OUT_SDG'] / $k1['TRG_SELL_OUT_SDG'] * 100);
					}

					if ($k1['TRG_SELL_OUT_BK'] != 0) {
						$persen_selloutBK = number_format($k1['ACT_SELL_OUT_BK'] / $k1['TRG_SELL_OUT_BK'] * 100);
					}

					$hasil[] = array(
						'SALESMAN'	=> $k1['USER_SALES'],
						'A_TARGET'	=> number_format($k1['TRG_TOKO_UNIT']),
						'A_ACTUAL'	=> number_format($k1['ACT_TU_BK']),
						'A_PERSEN'	=> $persen_tu,
						'B_TARGET'	=> number_format($k1['TRG_VISIT']),
						'B_ACTUAL'	=> number_format($k1['ACT_VISIT']),
						'B_PERSEN'	=> $persen_visit,
						'C_TARGET'	=> number_format($k1['TRG_TOKO_AKTIF']),
						'C_ACTUAL'	=> number_format($k1['ACT_TA_BK']),
						'C_PERSEN'	=> $persen_ta,
						'D_TARGET'	=> number_format($k1['TRG_TOKO_BARU']),
						'D_ACTUAL'	=> number_format($k1['ACT_TB_BK']),
						'D_PERSEN'	=> $persen_tb,
						'E_TARGET'	=> number_format($k1['TRG_SELL_OUT_SDG']),
						'E_ACTUAL'	=> number_format($k1['ACT_SELL_OUT_SDG']),
						'E_PERSEN'	=> $persen_selloutSDG,
						'F_TARGET'	=> number_format($k1['TRG_SELL_OUT_BK']),
						'F_ACTUAL'	=> number_format($k1['ACT_SELL_OUT_BK']),
						'F_PERSEN'	=> $persen_selloutBK
					);

				}
			}

			if ($jns == 'export') {
				return $hasil;
			} else {
				echo json_encode(array('response' => $hasil));
			}
			
		}


		// print_r('<pre>');
		// print_r($fromCRM);exit;

		
		// return $hasil;
	}
	
	public function ListDistributor($FilterBy, $FilterSet, $tahun, $bulan, $jns=null){
				
		// $arr_hasil = array();
		
		// echo json_encode($arr_hasil);

		// print_r('<pre>');
		// print_r($FilterBy.' - '.$FilterSet);exit;

		$bulan = str_pad($bulan,2,"0",STR_PAD_LEFT);

		$id_user = $this->session->userdata("user_id");
		$id_jenis_user = $this->session->userdata("id_jenis_user");

		if ($FilterSet == 'null') {
			$FilterSet = 'ALL';
			$FilterBy = '0-ALL';
		}

		$by = explode('-', $FilterBy)[1];
		$set = $FilterSet;

		if ($FilterBy != '0-ALL' && $FilterSet != 'ALL') {
			$by = explode('-', $FilterBy)[1];
			$set = explode('-', $FilterSet)[0];
		}

		
		$getDistr_TBL = $this->Dashboard_PMB_model->get_Distr_TBL($by, $set, $id_user, $id_jenis_user);
		// $getDistrik = $this->Dashboard_PMB_model->get_Distrik_TBL($id_user, $id_jenis_user);


		$getmappinguser = $this->Dashboard_PMB_model->get_mapping_user($by, $set, $id_user, $id_jenis_user);

		if ($getmappinguser['JML'] == 0) {

			if ($jns == 'export') {
				return $hasil;
			} else {
				
				$arr_hasil = array();

				echo json_encode($arr_hasil);
			}
			
		} else {
			
			$fromCRMDistr = $this->Dashboard_PMB_model->get_fromCRMDistr($by, $set, $tahun, $bulan, $id_user, $id_jenis_user);

			foreach ($fromCRMDistr as $fromCRM) {
			    $dt_fromCRM[] = array(
			    	'KD_DISTRIBUTOR' 		=> $fromCRM['KD_DISTRIBUTOR'],
		            'NM_DISTRIBUTOR' 		=> $fromCRM['NM_DISTRIBUTOR'],
		            'TRG_TOKO_UNIT'			=> $fromCRM['TRG_TOKO_UNIT'],
		            'ACT_TU_BK' 			=> 0,
		            'TRG_TOKO_AKTIF' 		=> $fromCRM['TRG_TOKO_AKTIF'],
		            'ACT_TA_BK' 			=> 0,
		            'TRG_SO_CLEAN_CLEAR'	=> $fromCRM['TRG_SO_CLEAN_CLEAR'],
		            'ACT_SO_CLEAN_CLEAR' 	=> 0,
		            'TRG_VOLUME' 			=> $fromCRM['TRG_VOLUME'],
		            'ACT_VOLUME' 			=> 0,
		            'TRG_REVENUE' 			=> $fromCRM['TRG_REVENUE'],
		            'ACT_REVENUE' 			=> 0,
		            'TRG_SELL_OUT' 			=> $fromCRM['TRG_SELL_OUT'],
		            'ACT_SELL_OUT' 			=> 0,
		            'TRG_ACP' 				=> 0,
		            'ACT_ACP' 				=> 0,
			    );
			}

			$getfromSCMDistr = $this->Dashboard_PMB_model->get_fromSCMDistr($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, $getDistr_TBL); // Kolom Volume & Revenue Distributor (Actual)

			foreach ($getfromSCMDistr as $fromSCM) {
			    $dt_fromSCM[] = array(
			    	'KD_DISTRIBUTOR' 		=> $fromSCM['KD_DISTRIBUTOR'],
		            'NM_DISTRIBUTOR' 		=> 0,
		            'TRG_TOKO_UNIT'			=> 0,
		            'ACT_TU_BK' 			=> 0,
		            'TRG_TOKO_AKTIF' 		=> 0,
		            'ACT_TA_BK' 			=> 0,
		            'TRG_SO_CLEAN_CLEAR'	=> 0,
		            'ACT_SO_CLEAN_CLEAR' 	=> 0,
		            'TRG_VOLUME' 			=> 0,
		            'ACT_VOLUME' 			=> $fromSCM['ACT_VOLUME'],
		            'TRG_REVENUE' 			=> 0,
		            'ACT_REVENUE' 			=> $fromSCM['ACT_REVENUE'],
		            'TRG_SELL_OUT' 			=> 0,
		            'ACT_SELL_OUT' 			=> 0,
		            'TRG_ACP' 				=> 0,
		            'ACT_ACP' 				=> 0,
			    );
			}

			$getselloutBK = $this->Dashboard_PMB_model->get_distrBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, 'sellout', $getDistr_TBL);

			foreach ($getselloutBK as $fromBK1) {
			    $dt_fromBK1[] = array(
			    	'KD_DISTRIBUTOR' 		=> $fromBK1['KD_DISTRIBUTOR'],
		            'NM_DISTRIBUTOR' 		=> 0,
		            'TRG_TOKO_UNIT'			=> 0,
		            'ACT_TU_BK' 			=> 0,
		            'TRG_TOKO_AKTIF' 		=> 0,
		            'ACT_TA_BK' 			=> $fromBK1['TA_DISTR'],
		            'TRG_SO_CLEAN_CLEAR'	=> 0,
		            'ACT_SO_CLEAN_CLEAR' 	=> 0,
		            'TRG_VOLUME' 			=> 0,
		            'ACT_VOLUME' 			=> 0,
		            'TRG_REVENUE' 			=> 0,
		            'ACT_REVENUE' 			=> 0,
		            'TRG_SELL_OUT' 			=> 0,
		            'ACT_SELL_OUT' 			=> $fromBK1['SELL_OUT'],
		            'TRG_ACP' 				=> 0,
		            'ACT_ACP' 				=> 0,
			    );
			}

			$gettUBK = $this->Dashboard_PMB_model->get_distrBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, 'tu', $getDistr_TBL);

			foreach ($gettUBK as $fromBK2) {
			    $dt_fromBK2[] = array(
			    	'KD_DISTRIBUTOR' 		=> $fromBK2['KD_DISTRIBUTOR'],
		            'NM_DISTRIBUTOR' 		=> 0,
		            'TRG_TOKO_UNIT'			=> 0,
		            'ACT_TU_BK' 			=> $fromBK2['TA_DISTR'],
		            'TRG_TOKO_AKTIF' 		=> 0,
		            'ACT_TA_BK' 			=> 0,
		            'TRG_SO_CLEAN_CLEAR'	=> 0,
		            'ACT_SO_CLEAN_CLEAR' 	=> 0,
		            'TRG_VOLUME' 			=> 0,
		            'ACT_VOLUME' 			=> 0,
		            'TRG_REVENUE' 			=> 0,
		            'ACT_REVENUE' 			=> 0,
		            'TRG_SELL_OUT' 			=> 0,
		            'ACT_SELL_OUT' 			=> 0,
		            'TRG_ACP' 				=> 0,
		            'ACT_ACP' 				=> 0,
			    );
			}

			$merge = array_merge($dt_fromCRM,$dt_fromSCM,$dt_fromBK1,$dt_fromBK2);

			// print_r('<pre>');
			// print_r($merge);exit;

			$mrg_data = array();
		    foreach ($merge as $mrg) {
		    	if (!empty($mrg['KD_DISTRIBUTOR'])) {
			        if (isset($mrg_data[$mrg['KD_DISTRIBUTOR']])) {
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['TRG_TOKO_UNIT'] += $mrg['TRG_TOKO_UNIT'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['ACT_TU_BK'] += $mrg['ACT_TU_BK'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['TRG_TOKO_AKTIF'] += $mrg['TRG_TOKO_AKTIF'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['ACT_TA_BK'] += $mrg['ACT_TA_BK'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['TRG_SO_CLEAN_CLEAR'] += $mrg['TRG_SO_CLEAN_CLEAR'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['ACT_SO_CLEAN_CLEAR'] += $mrg['ACT_SO_CLEAN_CLEAR'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['TRG_VOLUME'] += $mrg['TRG_VOLUME'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['ACT_VOLUME'] += $mrg['ACT_VOLUME'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['TRG_REVENUE'] += $mrg['TRG_REVENUE'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['ACT_REVENUE'] += $mrg['ACT_REVENUE'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['TRG_SELL_OUT'] += $mrg['TRG_SELL_OUT'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['ACT_SELL_OUT'] += $mrg['ACT_SELL_OUT'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['TRG_ACP'] += $mrg['TRG_ACP'];
			            $mrg_data[$mrg['KD_DISTRIBUTOR']]['ACT_ACP'] += $mrg['ACT_ACP'];
			        } else {
			            $mrg_data[$mrg['KD_DISTRIBUTOR']] = $mrg;
			        }
		    	}
		    }

			// print_r('<pre>');
			// print_r($mrg_data);exit;

			foreach ($mrg_data as $k1) {

				$persen_tu = '-';
				$persen_ta = '-';
				$persen_so_cnc = '-';
				$persen_volume = '-';
				$persen_revenue = '-';
				$persen_so_BK = '-';
				$persen_acp = '-';

				if ($jns == 'export') {

					if ($k1['TRG_TOKO_UNIT'] != 0) {
						$persen_tu = $k1['ACT_TU_BK'] / $k1['TRG_TOKO_UNIT'] * 100;
					}

					if ($k1['TRG_TOKO_AKTIF'] != 0) {
						$persen_ta = $k1['ACT_TA_BK'] / $k1['TRG_TOKO_AKTIF'] * 100;
					}

					if ($k1['TRG_SO_CLEAN_CLEAR'] != 0) {
						$persen_so_cnc = $k1['ACT_SO_CLEAN_CLEAR'] / $k1['TRG_SO_CLEAN_CLEAR'] * 100;
					}

					if ($k1['TRG_VOLUME'] != 0) {
						$persen_volume = $k1['ACT_VOLUME'] / $k1['TRG_VOLUME'] * 100;
					}

					if ($k1['TRG_REVENUE'] != 0) {
						$persen_revenue = $k1['ACT_REVENUE'] / $k1['TRG_REVENUE'] * 100;
					}

					if ($k1['TRG_SELL_OUT'] != 0) {
						$persen_so_BK = $k1['ACT_SELL_OUT'] / $k1['TRG_SELL_OUT'] * 100;
					}

					if ($k1['TRG_ACP'] != 0) {
						$persen_acp = $k1['ACT_ACP'] / $k1['TRG_ACP'] * 100;
					}

					$hasil[] = array(
						'DISTRIBUTOR'	=> $k1['NM_DISTRIBUTOR'],
						'A_TARGET'	=> $k1['TRG_TOKO_UNIT'],
						'A_ACTUAL'	=> $k1['ACT_TU_BK'],
						'A_PERSEN'	=> $persen_tu,
						'B_TARGET'	=> $k1['TRG_TOKO_AKTIF'],
						'B_ACTUAL'	=> $k1['ACT_TA_BK'],
						'B_PERSEN'	=> $persen_ta,
						'C_TARGET'	=> $k1['TRG_SO_CLEAN_CLEAR'],
						'C_ACTUAL'	=> '-',
						'C_PERSEN'	=> $persen_so_cnc,
						'D_TARGET'	=> $k1['TRG_VOLUME'],
						'D_ACTUAL'	=> $k1['ACT_VOLUME'],
						'D_PERSEN'	=> $persen_volume,
						'E_TARGET'	=> $k1['TRG_REVENUE'],
						'E_ACTUAL'	=> $k1['ACT_REVENUE'],
						'E_PERSEN'	=> $persen_revenue,
						'F_TARGET'	=> $k1['TRG_SELL_OUT'],
						'F_ACTUAL'	=> $k1['ACT_SELL_OUT'],
						'F_PERSEN'	=> $persen_so_BK,
						'G_TARGET'	=> '-',
						'G_ACTUAL'	=> '-',
						'G_PERSEN'	=> $persen_acp,
					);
					
				} else {

					if ($k1['TRG_TOKO_UNIT'] != 0) {
						$persen_tu = number_format($k1['ACT_TU_BK'] / $k1['TRG_TOKO_UNIT'] * 100);
					}

					if ($k1['TRG_TOKO_AKTIF'] != 0) {
						$persen_ta = number_format($k1['ACT_TA_BK'] / $k1['TRG_TOKO_AKTIF'] * 100);
					}

					if ($k1['TRG_SO_CLEAN_CLEAR'] != 0) {
						$persen_so_cnc = number_format($k1['ACT_SO_CLEAN_CLEAR'] / $k1['TRG_SO_CLEAN_CLEAR'] * 100);
					}

					if ($k1['TRG_VOLUME'] != 0) {
						$persen_volume = number_format($k1['ACT_VOLUME'] / $k1['TRG_VOLUME'] * 100);
					}

					if ($k1['TRG_REVENUE'] != 0) {
						$persen_revenue = number_format($k1['ACT_REVENUE'] / $k1['TRG_REVENUE'] * 100);
					}

					if ($k1['TRG_SELL_OUT'] != 0) {
						$persen_so_BK = number_format($k1['ACT_SELL_OUT'] / $k1['TRG_SELL_OUT'] * 100);
					}

					if ($k1['TRG_ACP'] != 0) {
						$persen_acp = number_format($k1['ACT_ACP'] / $k1['TRG_ACP'] * 100);
					}

					$hasil[] = array(
						'DISTRIBUTOR'	=> $k1['NM_DISTRIBUTOR'],
						'A_TARGET'	=> number_format($k1['TRG_TOKO_UNIT']),
						'A_ACTUAL'	=> number_format($k1['ACT_TU_BK']),
						'A_PERSEN'	=> $persen_tu,
						'B_TARGET'	=> number_format($k1['TRG_TOKO_AKTIF']),
						'B_ACTUAL'	=> number_format($k1['ACT_TA_BK']),
						'B_PERSEN'	=> $persen_ta,
						'C_TARGET'	=> number_format($k1['TRG_SO_CLEAN_CLEAR']),
						'C_ACTUAL'	=> '-',
						'C_PERSEN'	=> $persen_so_cnc,
						'D_TARGET'	=> number_format($k1['TRG_VOLUME']),
						'D_ACTUAL'	=> number_format($k1['ACT_VOLUME']),
						'D_PERSEN'	=> $persen_volume,
						'E_TARGET'	=> number_format($k1['TRG_REVENUE']),
						'E_ACTUAL'	=> number_format($k1['ACT_REVENUE']),
						'E_PERSEN'	=> $persen_revenue,
						'F_TARGET'	=> number_format($k1['TRG_SELL_OUT']),
						'F_ACTUAL'	=> number_format($k1['ACT_SELL_OUT']),
						'F_PERSEN'	=> $persen_so_BK,
						'G_TARGET'	=> '-',
						'G_ACTUAL'	=> '-',
						'G_PERSEN'	=> $persen_acp,
					);

				}
			}
			

			if ($jns == 'export') {

				return $hasil;
			
			} else {

				$arr_hasil = array(
					'response' => $hasil
				);

				echo json_encode($arr_hasil);
			}

		}
	}
	
	public function List_sm(){
		//$id_jenis_user = 1011; 
		//$hasil = $this->Dashboard_PMB_model->get_user_sales($id_jenis_user);
		$hasil = $this->Dashboard_PMB_model->get_user_sm_Unmap();
		echo json_encode($hasil);
	}
	
	public function List_sm_all(){
		$id_jenis_user = 1011; 
		$hasil = $this->Dashboard_PMB_model->get_user_sales($id_jenis_user);
		echo json_encode($hasil);
	}
	
	public function List_so(){
		//$id_jenis_user = 1012;
		//$hasil = $this->Dashboard_PMB_model->get_user_sales($id_jenis_user);
		$hasil = $this->Dashboard_PMB_model->get_user_so_Unmap();
		echo json_encode($hasil);
	}
	
	public function List_so_all(){
		$id_jenis_user = 1012;
		$hasil = $this->Dashboard_PMB_model->get_user_sales($id_jenis_user);
		echo json_encode($hasil);
	}
	
	public function List_sd(){
		//$id_jenis_user = 1015;
		//$hasil = $this->Dashboard_PMB_model->get_user_sales($id_jenis_user);
		$hasil = $this->Dashboard_PMB_model->get_user_sd_Unmap();
		echo json_encode($hasil);
	}
	
	public function List_sd_all(){
		$id_jenis_user = 1015;
		$hasil = $this->Dashboard_PMB_model->get_user_sales($id_jenis_user);
		echo json_encode($hasil);
	}
	
	//---------------------
	
	public function List_dist(){
		$id_jenis_user = 1013;
		$hasil = $this->Dashboard_PMB_model->get_user_sales($id_jenis_user);
		echo json_encode($hasil);
	}
	
	public function List_spc(){
		$id_jenis_user = 1017;
		$hasil = $this->Dashboard_PMB_model->get_user_sales($id_jenis_user);
		echo json_encode($hasil);
	}
	
	//-------------------------------------------------------------------------- WILAYAH CAKUPAN
	
	public function List_wilayah_cakupan(){
		$request 	= $this->input->post("request");  // region, provinsi, area, distrik
		$hasil 		= $this->Dashboard_PMB_model->get_cakupan_wilayah($request);
		echo json_encode($hasil);
	}
	
	public function List_distributor_gudang(){ 
		$request 	= $this->input->post("request");  // distributor, gudang
		$hasil 		= $this->Dashboard_PMB_model->get_distributor_gudang($request);
		echo json_encode($hasil);
	}
	
	// ------------------------------------------------------------------------- DIST & GUDANG
	
	public function List_jenis_user(){
		$hasil = $this->Dashboard_PMB_model->get_jenis_user();
		echo json_encode($hasil);
	}
	
	public function set_user_sales(){
		$id_user 		= $this->input->post("id_user");
		$id_jenis_user 	= $this->input->post("id_jenis_user");
		$nama 			= $this->input->post("nama");
		$username 		= $this->input->post("username");
		$password 		= $this->input->post("password");
		$email 			= $this->input->post("email");
		
		$hasil = $this->Dashboard_PMB_model->set_User($id_user, $id_jenis_user, $nama, $username, $password, $email);
		return $hasil;
	}
	
	public function del_user_sales(){
		$id_user 	= $this->input->post("id_user");
		$hasil 		= $this->Dashboard_PMB_model->del_User($id_user);
		return $hasil;
	}
	
	/*
	public function setWilayahGsm(){ 
		$id_gsm = $this->input->post("id_gsm");
		$wilayah = $this->input->post("wilayah");
		$hasil = $this->Dashboard_PMB_model->set_Wilayah_GSM($id_gsm, $wilayah);
		return $hasil;
	}
	
	public function setAtasan(){ 
		$id_user = $this->input->post("id_user");
		$atasan = $this->input->post("atasan");
		$hasil = $this->Dashboard_PMB_model->set_Atasan($id_user, $atasan);
		return $hasil;
	}
	*/
	
	//-------------------------------------------------------------------------------------------
	// SET USER MAPPING
	//-------------------------------------------------------------------------------------------
	
	public function List_mappingan_hierarki(){			// tidak dipakai
		$id_user 	= $this->input->post("id_user");
		$request 	= $this->input->post("request");
		
		// request -> datalist : gsm, ssm, sm, so, sd
		
		if($request == 'gsm'){
			$hasil = $this->Dashboard_PMB_model->list_gsm_user($id_user);
		} elseif ($request == 'ssm'){
			$hasil = $this->Dashboard_PMB_model->list_ssm_user($id_user);
		} elseif ($request == 'sm'){
			$hasil = $this->Dashboard_PMB_model->list_sm_user($id_user);
		} elseif ($request == 'so'){
			$hasil = $this->Dashboard_PMB_model->list_so_user($id_user);
		} elseif ($request == 'sd'){
			$hasil = $this->Dashboard_PMB_model->list_sd_user($id_user);
		}
		echo json_encode($hasil);
	}

	public function Mapping($id_user){
		$data = array("title"=>"Dashboard CRM");
		$data['users'] = $this->Dashboard_PMB_model->get_user($id_user); 
		$data['id_user_in'] = $id_user;
		
		// foreach ($data['users'] as $getDt){
			// $id_j_user = $getDt['ID_JENIS_USER']
		// }
		
    	$this->template->display('Mapping_Dashboard_PMB_view', $data);
	}
	
	public function List_mappingan_hierarkiNew(){
		$id_user 	= $this->input->post("id_user");
		$request 	= $this->input->post("request");
		
		// request -> datalist : gsm, ssm, sm, so, sd
		
		if($request == 'gsm'){
			//$hasil = $this->Dashboard_PMB_model->list_gsm_user($id_user);
		} elseif ($request == 'ssm'){
			$hasil = $this->Dashboard_PMB_model->list_ssm_userOfGsm($id_user);
		} elseif ($request == 'sm'){
			$hasil = $this->Dashboard_PMB_model->list_sm_userOfSsm($id_user);
		} elseif ($request == 'so'){
			$hasil = $this->Dashboard_PMB_model->list_so_userOfSm($id_user);
		} elseif ($request == 'sd'){
			$hasil = $this->Dashboard_PMB_model->list_sd_userOfSo($id_user);
		}
		echo json_encode($hasil);
	}
	
	public function List_mappingan_wilayah(){
		$id_user 	= $this->input->post("id_user");
		$request 	= $this->input->post("request");
		
		// request -> datalist : region, provinsi, area, distrik
		
		if($request == 'region'){
			$hasil = $this->Dashboard_PMB_model->list_region_user($id_user);
		} elseif ($request == 'provinsi'){
			$hasil = $this->Dashboard_PMB_model->list_provinsi_user($id_user);
		} elseif ($request == 'area'){
			$hasil = $this->Dashboard_PMB_model->list_area_user($id_user);
		} elseif ($request == 'distrik'){
			$hasil = $this->Dashboard_PMB_model->list_distrik_user($id_user);
		} 
		echo json_encode($hasil);
	}
	
	public function List_mappingan_dist_gudang(){
		$id_user 	= $this->input->post("id_user");
		$request 	= $this->input->post("request");
		
		// request -> datalist : distributor, gudang
		
		if($request == 'distributor'){
			$hasil = $this->Dashboard_PMB_model->list_distributor_user($id_user);
		} elseif ($request == 'gudang'){
			$hasil = $this->Dashboard_PMB_model->list_gudang_user($id_user);
		}
		echo json_encode($hasil);
	}
	
	// ACTION MAPPING [ INSERT AND DELETE ]
	
	public function Set_mapping_hierarki(){	 			// Tidak dipakai lagi // Set hierarki, user mapping and unmapping 
		$actControl		= $this->input->post("actControl_js");
		
		$actIn_or_Del	= $this->input->post("actIn_or_Del");
		$valueIn		= $this->input->post("valueIn");
		$id_user		= $this->input->post("id_user");
		
		if($actControl == 'gsm'){
			$hasil = $this->Dashboard_PMB_model->set_gsm_user($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'ssm'){
			$hasil = $this->Dashboard_PMB_model->set_ssm_user($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'sm'){
			$hasil = $this->Dashboard_PMB_model->set_sm_user($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'so'){
			$hasil = $this->Dashboard_PMB_model->set_so_user($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'sd'){
			$hasil = $this->Dashboard_PMB_model->set_sd_user($actIn_or_Del, $id_user, $valueIn);
		} 
		 
		$output = array(
			"pesan" => $hasil
		);
		echo json_encode($output);
		//print_r($hasil);
		exit();
	}
	
	public function Set_mapping_hierarkiNew(){	 			// Tidak dipakai lagi // Set hierarki, user mapping and unmapping 
		$actControl		= $this->input->post("actControl_js");
		
		$actIn_or_Del	= $this->input->post("actIn_or_Del");
		$valueIn		= $this->input->post("valueIn");
		$id_user		= $this->input->post("id_user");
		
		if($actControl == 'gsm'){
			//$hasil = $this->Dashboard_PMB_model->set_gsm_user($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'ssm'){
			$hasil = $this->Dashboard_PMB_model->set_ssm_userGsm($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'sm'){
			$hasil = $this->Dashboard_PMB_model->set_sm_userSsm($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'so'){
			$hasil = $this->Dashboard_PMB_model->set_so_userSm($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'sd'){
			$hasil = $this->Dashboard_PMB_model->set_sd_userSo($actIn_or_Del, $id_user, $valueIn);
		} 
		 
		$output = array(
			"pesan" => $hasil
		);
		echo json_encode($output);
		//print_r($hasil);
		exit();
	}
	
	public function Set_mapping_wilayah_cakupan(){	 			// Set wilayah, user mapping and unmapping 
		$actControl		= $this->input->post("actControl_js");
		
		$actIn_or_Del	= $this->input->post("actIn_or_Del");
		$valueIn		= $this->input->post("valueIn");
		$id_user		= $this->input->post("id_user");
		
		if($actControl == 'region'){
			$hasil = $this->Dashboard_PMB_model->set_region_user($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'provinsi'){
			$hasil = $this->Dashboard_PMB_model->set_provinsi_user($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'area'){
			$hasil = $this->Dashboard_PMB_model->set_area_user($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'distrik'){
			$hasil = $this->Dashboard_PMB_model->set_distrik_user($actIn_or_Del, $id_user, $valueIn);
		} 
		 
		$output = array(
			"pesan" => $hasil
		);
		echo json_encode($output);
		//print_r($hasil);
		exit();
	}
	
	public function Set_mapping_distributor_gudang(){	 			// Set distributor dan gudang, user mapping and unmapping 
		$actControl		= $this->input->post("actControl_js");
		
		$actIn_or_Del	= $this->input->post("actIn_or_Del");
		$valueIn		= $this->input->post("valueIn");
		$id_user		= $this->input->post("id_user");
		
		if($actControl == 'distributor'){
			$hasil = $this->Dashboard_PMB_model->set_distributor_user($actIn_or_Del, $id_user, $valueIn);
		} elseif ($actControl == 'gudang'){
			$hasil = $this->Dashboard_PMB_model->set_gudang_user($actIn_or_Del, $id_user, $valueIn);
		} 
		 
		$output = array(
			"pesan" => $hasil
		);
		echo json_encode($output);
		//print_r($hasil);
		exit();
	}
	

//-------------------------------------------------------------------------------------------
// 	IMPORT EXCEL DATA USER
//-------------------------------------------------------------------------------------------

	public function Import_excel(){
		$data = array(); 
		if(isset($_POST['preview'])){ 
			$upload = $this->upload_file($this->filename);
			
			if($upload['result'] == "success"){ 
				//include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); 
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
					
				$data['sheet'] = $sheet; 
					
			} else { 
				$data['upload_error'] = $upload['error']; 
			}
		}
		$data['title'] = "Import User";
		$data['jenis_user_u'] = $this->Dashboard_PMB_model->get_jenis_user();
		$this->template->display('Import_user_view', $data);
	}

	private function upload_file($filename){
		$this->load->library('upload'); // Load librari upload
		
		$config['upload_path'] = './excel/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '2048';
		$config['overwrite'] = true;
		$config['file_name'] = $filename;
	
		$this->upload->initialize($config); // Load konfigurasi uploadnya
		if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
			// Jika gagal :
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}

	public function import(){
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		
		$date = date('d-m-Y H:i:s');
		//Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
		$data = array();
		$data_sukses = 0;
		$data_sama = 0;
		$numrow = 1;
		foreach($sheet as $row){
			// Cek $numrow apakah lebih dari 1
			if($row['A'] == "" && $row['B'] == "" && $row['C'] == "" && $row['D'] == "")
			continue;
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Panggil fungsi addCanvasing yg telah di buat di model
				$insert = $this->Dashboard_PMB_model->add_user_batch($row['A'], $row['B'], $row['C'], $row['D']);
				$data_sukses++;
			}
			$numrow++; // Tambah 1 setiap kali looping
		}
		$this->session->set_userdata("after_import", true);
		$this->session->set_userdata("baris_data", sizeof($sheet)-1);
		$this->session->set_userdata("data_sukses", $data_sukses);
		$this->session->set_userdata("data_sama", $data_sama);

		redirect(site_url('dashboard/Manajemen_user/Import_excel'));
	}
	
//-------------------------------------------------------------------------------------------
// 	EXPORT EXCEL DATA USER
//-------------------------------------------------------------------------------------------

	public function Export_excel_salesman($FilterBy, $FilterSet, $tahun, $bulan){

		$getData = array();

		$getData_fr = $this->ListSalesman($FilterBy, $FilterSet, $tahun, $bulan, 'export');
		foreach ($getData_fr as $k1) {
			
			$getData[] = (object)array(
				'SALESMAN'	=> $k1['SALESMAN'],
				'A_TARGET'	=> $k1['A_TARGET'],
				'A_ACTUAL'	=> $k1['A_ACTUAL'],
				'A_PERSEN'	=> $k1['A_PERSEN'],
				'B_TARGET'	=> $k1['B_TARGET'],
				'B_ACTUAL'	=> $k1['B_ACTUAL'],
				'B_PERSEN'	=> $k1['B_PERSEN'],
				'C_TARGET'	=> $k1['C_TARGET'],
				'C_ACTUAL'	=> $k1['C_ACTUAL'],
				'C_PERSEN'	=> $k1['C_PERSEN'],
				'D_TARGET'	=> $k1['D_TARGET'],
				'D_ACTUAL'	=> $k1['D_ACTUAL'],
				'D_PERSEN'	=> $k1['D_PERSEN'],
				'E_TARGET'	=> $k1['E_TARGET'],
				'E_ACTUAL'	=> $k1['E_ACTUAL'],
				'E_PERSEN'	=> $k1['E_PERSEN'],
				'F_TARGET'	=> $k1['F_TARGET'],
				'F_ACTUAL'	=> $k1['F_ACTUAL'],
				'F_PERSEN'	=> $k1['F_PERSEN']
			);

		}

		if ($FilterSet == 'null') {
			$FilterSet = 'ALL';
		}

		$by = explode('-', $FilterBy)[1];
		$set = $FilterSet;

		if ($FilterBy != '0-ALL' && $FilterSet != 'ALL') {
			$by = explode('-', $FilterBy)[1];
			$set = str_replace("%20"," ",explode('-', $FilterSet)[1]);
		}

		$nameFile = "[FILTER: ".$by." - ".$set." - ".strtoupper(date('M',strtotime($tahun.'-'.$bulan)))." ".$tahun."]";
		// print_r('<pre>');
		// print_r($getData);exit;
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator('Admin-CRM-Semen-Indonesia')->setTitle('Rekap Daftar Mapping Customer');
        $objSet = $objPHPExcel->setActiveSheetIndex(0);
        $objGet = $objPHPExcel->getActiveSheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $style_col = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'allborders' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_col1 = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'allborders' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            ),
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => '00bcd4')
	        )
        );

        $style_col2 = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'allborders' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            ),
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'ffc000')
	        )
        );

        $style_col3 = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'allborders' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            ),
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => '92d050')
	        )
        );

        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
		
		$filename = "Data PMB Dashboard - Tabel Salesman ".$nameFile;
        $objPHPExcel->getActiveSheet(0)->setTitle("PMB Salesman");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Tabel Salesman '.$nameFile);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:T2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "No.");
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "Salesman");
        $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Toko Unit (Coverage) (BK)");
        $objPHPExcel->getActiveSheet()->mergeCells('C3:E3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "Kunjungan Salesman");
        $objPHPExcel->getActiveSheet()->mergeCells('F3:H3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "Toko Aktif (BK)");
        $objPHPExcel->getActiveSheet()->mergeCells('I3:K3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "Toko Baru (NOO) (BK)");
        $objPHPExcel->getActiveSheet()->mergeCells('L3:N3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "Volume Selling Out Sidigi (Ton)");
        $objPHPExcel->getActiveSheet()->mergeCells('O3:Q3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "Volume Selling Out BK (Ton)");
        $objPHPExcel->getActiveSheet()->mergeCells('R3:T3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T4', "%");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('A3:A4')->applyFromArray($style_col1);
        $objPHPExcel->getActiveSheet()->getStyle('B3:B4')->applyFromArray($style_col1);
        $objPHPExcel->getActiveSheet()->getStyle('C3:E3')->applyFromArray($style_col2);
        $objPHPExcel->getActiveSheet()->getStyle('C4:E4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('F3:H3')->applyFromArray($style_col3);
        $objPHPExcel->getActiveSheet()->getStyle('F4:H4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('I3:K3')->applyFromArray($style_col2);
        $objPHPExcel->getActiveSheet()->getStyle('I4:K4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('L3:N3')->applyFromArray($style_col2);
        $objPHPExcel->getActiveSheet()->getStyle('L4:N4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('O3:Q3')->applyFromArray($style_col3);
        $objPHPExcel->getActiveSheet()->getStyle('O4:Q4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('R3:T3')->applyFromArray($style_col2);
        $objPHPExcel->getActiveSheet()->getStyle('R4:T4')->applyFromArray($style_col);
        
		
		$no = 1;
        $numRow = 5;
        foreach ($getData as $list_mappingKey => $list_mappingValue) {
					
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, $list_mappingValue->SALESMAN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, $list_mappingValue->A_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, $list_mappingValue->A_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, $list_mappingValue->A_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, $list_mappingValue->B_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, $list_mappingValue->B_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, $list_mappingValue->B_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, $list_mappingValue->C_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, $list_mappingValue->C_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, $list_mappingValue->C_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, $list_mappingValue->D_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, $list_mappingValue->D_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, $list_mappingValue->D_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, $list_mappingValue->E_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, $list_mappingValue->E_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numRow, $list_mappingValue->E_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numRow, $list_mappingValue->F_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numRow, $list_mappingValue->F_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numRow, $list_mappingValue->F_PERSEN);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('N'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('Q'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('R'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('S'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('T'.$numRow)->applyFromArray($style_row);

            $no++;
            $numRow++;
        }
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '".xls');
        header('Cache-Control: max-age=0');
        header("Pragma: no-cache");

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        $reader = PHPExcel_IOFactory::createReader('Excel5');

        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
		
	}

	public function Export_excel_distributor($FilterBy, $FilterSet, $tahun, $bulan){

		$getData = array();

		$getData_fr = $this->ListDistributor($FilterBy, $FilterSet, $tahun, $bulan, 'export');
		foreach ($getData_fr as $k1) {
			
			$getData[] = (object)array(
				'DISTRIBUTOR'	=> $k1['DISTRIBUTOR'],
				'A_TARGET'		=> $k1['A_TARGET'],	
				'A_ACTUAL'		=> $k1['A_ACTUAL'],
				'A_PERSEN'		=> $k1['A_PERSEN'],	
				'B_TARGET'		=> $k1['B_TARGET'],	
				'B_ACTUAL'		=> $k1['B_ACTUAL'],	
				'B_PERSEN'		=> $k1['B_PERSEN'],
				'C_TARGET'		=> $k1['C_TARGET'],	
				'C_ACTUAL'		=> $k1['C_ACTUAL'],	
				'C_PERSEN'		=> $k1['C_PERSEN'],	
				'D_TARGET'		=> $k1['D_TARGET'],
				'D_ACTUAL'		=> $k1['D_ACTUAL'],
				'D_PERSEN'		=> $k1['D_PERSEN'],	
				'E_TARGET'		=> $k1['E_TARGET'],	
				'E_ACTUAL'		=> $k1['E_ACTUAL'],	
				'E_PERSEN'		=> $k1['E_PERSEN'],	
				'F_TARGET'		=> $k1['F_TARGET'],	
				'F_ACTUAL'		=> $k1['F_ACTUAL'],	
				'F_PERSEN'		=> $k1['F_PERSEN'],	
				'G_TARGET'		=> $k1['G_TARGET'],	
				'G_ACTUAL'		=> $k1['G_ACTUAL'],	
				'G_PERSEN'		=> $k1['G_PERSEN'],	
			);

		}

		if ($FilterSet == 'null') {
			$FilterSet = 'ALL';
		}

		$by = explode('-', $FilterBy)[1];
		$set = $FilterSet;

		if ($FilterBy != '0-ALL' && $FilterSet != 'ALL') {
			$by = explode('-', $FilterBy)[1];
			$set = str_replace("%20"," ",explode('-', $FilterSet)[1]);
		}

		$nameFile = "[FILTER: ".$by." - ".$set." - ".strtoupper(date('M',strtotime($tahun.'-'.$bulan)))." ".$tahun."]";
		// print_r('<pre>');
		// print_r($getData);exit;
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator('Admin-CRM-Semen-Indonesia')->setTitle('Rekap Daftar Mapping Customer');
        $objSet = $objPHPExcel->setActiveSheetIndex(0);
        $objGet = $objPHPExcel->getActiveSheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $style_col = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'allborders' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_col1 = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'allborders' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            ),
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => '00bcd4')
	        )
        );

        $style_col2 = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'allborders' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            ),
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'ffc000')
	        )
        );

        $style_col3 = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'allborders' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            ),
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => '92d050')
	        )
        );

        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
		
		$filename = "Data PMB Dashboard - Tabel Distributor ".$nameFile;
        $objPHPExcel->getActiveSheet(0)->setTitle("PMB Distributor");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Tabel Distributor '.$nameFile);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:W2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "No.");
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "Distributor");
        $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Toko Unit (Coverage) (BK)");
        $objPHPExcel->getActiveSheet()->mergeCells('C3:E3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "Toko Aktif (BK)");
        $objPHPExcel->getActiveSheet()->mergeCells('F3:H3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "SO Clean & Clear (Ton)");
        $objPHPExcel->getActiveSheet()->mergeCells('I3:K3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "Volume Sell In (Ton)");
        $objPHPExcel->getActiveSheet()->mergeCells('L3:N3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "Revenue (Juta)");
        $objPHPExcel->getActiveSheet()->mergeCells('O3:Q3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "Volume Selling Out BK (Ton)");
        $objPHPExcel->getActiveSheet()->mergeCells('R3:T3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T4', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U3', "ACP (hari)");
        $objPHPExcel->getActiveSheet()->mergeCells('U3:W3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U4', "Target");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V4', "Actual");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W4', "%");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('A3:A4')->applyFromArray($style_col1);
        $objPHPExcel->getActiveSheet()->getStyle('B3:B4')->applyFromArray($style_col1);
        $objPHPExcel->getActiveSheet()->getStyle('C3:E3')->applyFromArray($style_col2);
        $objPHPExcel->getActiveSheet()->getStyle('C4:E4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('F3:H3')->applyFromArray($style_col2);
        $objPHPExcel->getActiveSheet()->getStyle('F4:H4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('I3:K3')->applyFromArray($style_col3);
        $objPHPExcel->getActiveSheet()->getStyle('I4:K4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('L3:N3')->applyFromArray($style_col3);
        $objPHPExcel->getActiveSheet()->getStyle('L4:N4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('O3:Q3')->applyFromArray($style_col3);
        $objPHPExcel->getActiveSheet()->getStyle('O4:Q4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('R3:T3')->applyFromArray($style_col2);
        $objPHPExcel->getActiveSheet()->getStyle('R4:T4')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('U3:W3')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('U4:W4')->applyFromArray($style_col);
        
		
		$no = 1;
        $numRow = 5;
        foreach ($getData as $list_mappingKey => $list_mappingValue) {
					
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, $list_mappingValue->DISTRIBUTOR);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, $list_mappingValue->A_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, $list_mappingValue->A_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, $list_mappingValue->A_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, $list_mappingValue->B_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, $list_mappingValue->B_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, $list_mappingValue->B_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, $list_mappingValue->C_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, $list_mappingValue->C_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, $list_mappingValue->C_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, $list_mappingValue->D_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, $list_mappingValue->D_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, $list_mappingValue->D_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, $list_mappingValue->E_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, $list_mappingValue->E_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numRow, $list_mappingValue->E_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numRow, $list_mappingValue->F_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numRow, $list_mappingValue->F_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numRow, $list_mappingValue->F_PERSEN);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$numRow, $list_mappingValue->G_TARGET);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$numRow, $list_mappingValue->G_ACTUAL);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$numRow, $list_mappingValue->G_PERSEN);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('N'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('Q'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('R'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('S'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('T'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('U'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('V'.$numRow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('W'.$numRow)->applyFromArray($style_row);

            $no++;
            $numRow++;
        }
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '".xls');
        header('Cache-Control: max-age=0');
        header("Pragma: no-cache");

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        $reader = PHPExcel_IOFactory::createReader('Excel5');

        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
		
	}

	public function List_region(){
		$data = array();
			
		$list = $this->Dashboard_PMB_model->getRegion();
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
			
		$list = $this->Dashboard_PMB_model->getProvinsi();
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
			
		$list = $this->Dashboard_PMB_model->getArea();
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
			
		$list = $this->Dashboard_PMB_model->getDistributor();
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
			
		$list = $this->Dashboard_PMB_model->getDistriK();
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