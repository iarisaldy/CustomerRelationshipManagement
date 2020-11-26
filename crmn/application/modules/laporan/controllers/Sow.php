<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Sow extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Sow_model');
		$this->load->model('Data_sales_model');
    }
	public function SO(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Data_sales_model->Get_region_all();
		$this->template->display('asow_so', $data);
	}
	public function SM(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Data_sales_model->Get_region_all();
		$this->template->display('asow_sm', $data);
	}
	public function SSM(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Data_sales_model->Get_region_all();
		$this->template->display('asow_ssm', $data);
	}
	public function GSM(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Data_sales_model->Get_region_all();
		$this->template->display('asow_gsm', $data);
	}
	public function SPC(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Data_sales_model->Get_region_all();
		$this->template->display('asow_spc', $data);
	}
	public function DIS(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Data_sales_model->Get_region_all();
		$this->template->display('asow_distributor', $data);
	}
	public function ADMIN(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Data_sales_model->Get_region_all();
		$this->template->display('asow_admin', $data);
	}
	
	public function datasow_so(){
		$region 		= $this->input->post("region");
		$id_prov 		= $this->input->post("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->post("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'SO');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'SO'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'SO');
		
		$hasil = $this->make_table_hasil($this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn));
		
		echo json_encode($hasil);
		//print_r($hasil);
		
	}
	public function datasow_sm(){
		$region 		= $this->input->post("region");
		$id_prov 		= $this->input->post("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->post("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'SM');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'SM'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'SM');
		
		$hasil = $this->make_table_hasil($this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn));
		
		echo json_encode($hasil);
		//print_r($hasil);
		
	}
	public function datasow_ssm(){
		$region 		= $this->input->post("region");
		$id_prov 		= $this->input->post("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->post("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'SSM');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'SSM'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'SSM');
		
		$hasil = $this->make_table_hasil($this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn));
		
		echo json_encode($hasil);
		//print_r($hasil);
		
	}
	public function datasow_gsm(){
		$region 		= $this->input->post("region");
		$id_prov 		= $this->input->post("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->post("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'GSM');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'GSM'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'GSM');
		
		$hasil = $this->make_table_hasil($this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn));
		
		echo json_encode($hasil);
		//print_r($hasil);
		
	}
	public function datasow_spc(){
		$region 		= $this->input->post("region");
		$id_prov 		= $this->input->post("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->post("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'SPC');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'SPC'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'SPC');
		
		$hasil = $this->make_table_hasil($this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn));
		
		echo json_encode($hasil);
		//print_r($hasil);
		
	}
	public function datasow_dis(){
		$region 		= $this->input->post("region");
		$id_prov 		= $this->input->post("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->post("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'DIS');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'DIS'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'DIS');
		
		$hasil = $this->make_table_hasil($this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn));
		
		echo json_encode($hasil);
		//print_r($hasil);
		
	}
	public function datasow_admin(){
		$region 		= $this->input->post("region");
		$id_prov 		= $this->input->post("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->post("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->post("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'ADMIN');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'ADMIN'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'ADMIN');
		
		$hasil = $this->make_table_hasil($this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn));
		
		echo json_encode($hasil);
		//print_r($hasil);
		
	}
	
	private function make_marger_data($sidigi, $dt_crm, $dt_survey_nn){
		$hasil = array();
		
		foreach($sidigi as $d){
			$kapasitas = 0;
			if(count($dt_crm>0)){
				$kapasitas = 0;
				foreach($dt_crm as $c){
					if($d['KD_CUSTOMER']==$c['ID_CUSTOMER']){
						$kapasitas = $c['KAPASITAS_ZAK'];
					}
				}
			} 
			
			array_push($hasil, array 	(
									'KD_CUSTOMER' => $d['KD_CUSTOMER'],
									'NM_CUSTOMER' => $d['NM_CUSTOMER'],
									'NM_DISTRIBUTOR' => $d['NM_DISTRIBUTOR'],
									'REGION' => $d['REGION'],
									'NM_PROVINSI' => $d['NM_PROVINSI'],
									'NM_DISTRIK' => $d['NM_DISTRIK'],
									'KAPASITAS' => $kapasitas,
									'KD_PRODUK' => $d['KD_PRODUK'],
									'NM_PRODUK' => $d['NM_PRODUK'],
									'TOTAL_PJ' => $d['TOTAL_PJ']								
									)
							);
			
		}
		
		
		foreach($dt_survey_nn as $d){
			$kapasitas = 0;
			if(count($dt_crm>0)){
				$kapasitas = 0;
				foreach($dt_crm as $c){
					if($d['ID_TOKO']==$c['ID_CUSTOMER']){
						$kapasitas = $c['KAPASITAS_ZAK'];
					}
				}
			} 
			
			array_push($hasil, array 	(
									'KD_CUSTOMER' => $d['ID_TOKO'],
									'NM_CUSTOMER' => $d['NAMA_TOKO'],
									'NM_DISTRIBUTOR' => $d['NAMA_DISTRIBUTOR'],
									'REGION' => $d['REGION_ID'],
									'NM_PROVINSI' => $d['NAMA_PROVINSI'],
									'NM_DISTRIK' => $d['NAMA_DISTRIK'],
									'KAPASITAS' => $kapasitas,
									'KD_PRODUK' => $d['ID_PRODUK'],
									'NM_PRODUK' => $d['NAMA_PRODUK'],
									'TOTAL_PJ' => $d['VOLUME_PENJUALAN']								
									)
							);
			
		}
		
		
		return $hasil;
	}

   private function make_table_hasil($hasil){
		$isi ='';
		$no =1;
		$c = "x";
		foreach($hasil as $h){
			//$btn_tambah_stok = '<button class="btn btn-primary waves-effect Tambah_stok_history" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'"><span class="fa fa-pencil"></span></button>';
			//$btn_DM_stok = '<button class="btn btn-success waves-effect" id="Tampilkan_history_distributor" idpd="'.$h['ID_PRODUK_DISTRIBUTOR'].'"><span class="fa fa-list"></span></button>';
			$isi .= '<tr class="'.$c.'">';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['KD_CUSTOMER'].'</td>';
			$isi .= '<td>'.$h['NM_CUSTOMER'].'</td>';
			$isi .= '<td>'.$h['NM_DISTRIBUTOR'].'</td>';
			$isi .= '<td>'.$h['REGION'].'</td>';
			$isi .= '<td>'.$h['NM_PROVINSI'].'</td>';
			$isi .= '<td>'.$h['NM_DISTRIK'].'</td>';
			$isi .= '<td>'.$h['KD_PRODUK'].'</td>';
			$isi .= '<td>'.$h['NM_PRODUK'].'</td>';
			if($h['KAPASITAS']==0){
				//$isi .= '<td><span class="label label-warning">NON WPM</span></td>';
				$isi .= '<td>'.$h['KAPASITAS'].'</td>';
				$isi .= '<td>'.number_format($h['TOTAL_PJ']).'</td>';
				$isi .= '<td>0 %</td>';
				//$isi .= '<td><button class="btn btn-primary" onclick="SAVE('.$h['ID_CUSTOMER'].')" ><span class="fa fa-save"></span></button></td>';
			}
			else {
				//$isi .= '<td><span class="label label-warning">NON WPM</span></td>';
				$isi .= '<td>'.$h['KAPASITAS'].'</td>';
				$isi .= '<td>'.number_format($h['TOTAL_PJ']).'</td>';
				$persen = $h['TOTAL_PJ']/$h['KAPASITAS']*100;
				$isi .= '<td>'.$persen.' %</td>';
				//$isi .= '<td><button class="btn btn-primary" onclick="SAVE('.$h['ID_CUSTOMER'].')" ><span class="fa fa-save"></span></button></td>';
			}
			$isi .= '</tr>';
			
			$no=$no+1;
			if($c=="x"){
				$c = "y"  ;
			}else{
				$c = "x" ;
			}
		}
		return $isi;
	}
	
	public function toExcel_SO(){
		$region 		= $this->input->get("region");
		$id_prov 		= $this->input->get("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->get("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'SO');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'SO'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'SO');
		
		$hasil = $this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn);
		$this->Cetak_exel($hasil);
		
		//echo json_encode($hasil);
	}
	public function toExcel_SM(){
		$region 		= $this->input->get("region");
		$id_prov 		= $this->input->get("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->get("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'SM');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'SM'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'SM');
		
		$hasil = $this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn);
		$this->Cetak_exel($hasil);
		
		//echo json_encode($hasil);
	}
	public function toExcel_SSM(){
		$region 		= $this->input->get("region");
		$id_prov 		= $this->input->get("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->get("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'SSM');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'SSM'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'SSM');
		
		$hasil = $this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn);
		$this->Cetak_exel($hasil);
		
		//echo json_encode($hasil);
	}
	public function toExcel_GSM(){
		$region 		= $this->input->get("region");
		$id_prov 		= $this->input->get("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->get("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'GSM');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'GSM'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'GSM');
		
		$hasil = $this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn);
		$this->Cetak_exel($hasil);
		
		//echo json_encode($hasil);
	}
	public function toExcel_SPC(){
		$region 		= $this->input->get("region");
		$id_prov 		= $this->input->get("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->get("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'SPC');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'SPC'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'SPC');
		
		$hasil = $this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn);
		$this->Cetak_exel($hasil);
		
		//echo json_encode($hasil);
	}
	public function toExcel_ADMIN(){
		$region 		= $this->input->get("region");
		$id_prov 		= $this->input->get("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->get("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'ADMIN');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'ADMIN'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'ADMIN');
		
		$hasil = $this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn);
		$this->Cetak_exel($hasil);
		
		//echo json_encode($hasil);
	}
	public function toExcel_DIS(){
		$region 		= $this->input->get("region");
		$id_prov 		= $this->input->get("id_prov");
		$id_user 		= $this->session->userdata('user_id');
		$bulan		 	= $this->input->get("bulan");
		
		if($bulan<10){
			$bulan= '0'. $bulan;
		}
		
		$tahun			= $this->input->get("tahun");
		
		$sidigi 		= $this->Sow_model->get_data_sidigi($tahun, $bulan, $id_user, $id_prov, $region, 'DIS');
			
		$dt_crm			= $this->Sow_model->Data_kapasitas_toko($id_user, $region, $id_prov, 'DIS'); 	
		$dt_survey_nn	= $this->Sow_model->get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, 'DIS');
		
		$hasil = $this->make_marger_data($sidigi, $dt_crm, $dt_survey_nn);
		$this->Cetak_exel($hasil);
		
		//echo json_encode($hasil);
	}

	private function Cetak_exel($hasil){
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Kapasitas Toko');
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
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
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
		
		$filename = "Rekap_Data_Volume_Sellout";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA SOW");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT DATA SOW");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:N2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "KD CUSTOMER");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "REGION");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA DISTRIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "KD PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "NM PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "Jumlah Kapasitas Jual per Bulan (semua merek)");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "Volume Penjualan (per Bulan)");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "PERSENTASE");

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VolumeKey => $list_ValumeValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_ValumeValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_ValumeValue['NM_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_ValumeValue['REGION']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_ValumeValue['NM_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_ValumeValue['KD_PRODUK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_ValumeValue['NM_PRODUK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_ValumeValue['KAPASITAS']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_ValumeValue['TOTAL_PJ']));
			if($list_ValumeValue['KAPASITAS']==0){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, '0');
			}
			else {
				$persen = $list_ValumeValue['TOTAL_PJ']/$list_ValumeValue['KAPASITAS']*100;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($persen));
			}
			

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
	
}
?> 