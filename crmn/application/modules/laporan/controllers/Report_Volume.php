<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Report_Volume extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Report_volume_model');
		
		set_time_limit(0);
        ini_set('memory_limit', '512M');
    }

    public function index(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Report_volume_model->User_distributor($id_user, 'SO');
		$data['list_sales'] = $this->Report_volume_model->GET_SALES($id_user);
		
		$this->template->display('Report_volume_view', $data);
    }
	public function DIS(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_sales'] = $this->Report_volume_model->get_sd($id_user);
		
		$this->template->display('report_volume_distributor', $data);
		
    }
    public function ADMIN(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_volume_model->Get_region_all();
		
		$this->template->display('Report_Volume_Admin', $data);
    }
    public function GSM(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Report_volume_model->User_distributor($id_user, 'GSM');
		
		$this->template->display('report_volume_gsm', $data);
    }
    public function SPC(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Report_volume_model->User_distributor($id_user, 'SPC');
		
		$this->template->display('report_volume_spc', $data);
    }
    public function RSM(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Report_volume_model->User_distributor($id_user, 'SSM');
		
		$this->template->display('Report_volume_RSM', $data);
    }
	
	
	public function ASM(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Report_volume_model->User_distributor($id_user, 'SM');
		
		$this->template->display('Report_volume_ASM', $data);
    }
	
	
	public function ListProvinsi(){
        $id_region    = $this->input->post('id_region');
		
        $data = $this->Report_volume_model->Get_provinsi_all($id_region);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	public function ListDistributor(){
        $id_provinsi    = $this->input->post('id_provinsi');
		
        $data = $this->Report_volume_model->Get_Dis_all($id_provinsi);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	function distributor_sales(){
        $id_dis = $this->input->post("id");
		$id_tso = $this->session->userdata('user_id');
        $data = $this->Report_volume_model->GET_SALES($id_tso, $id_dis);
		
        echo json_encode($data);
    }
	
	function distributor_sales_asm(){
        $id_dis = $this->input->post("id");
		$id_asm = $this->session->userdata('user_id');
        $data = $this->Report_volume_model->get_sales_asm($id_dis,$id_asm);
		
        echo json_encode($data);
    }
	
	function distributor_sales_rsm(){
        $id_dis = $this->input->post("id");
		$id_rsm = $this->session->userdata('user_id');
        $data = $this->Report_volume_model->get_sales_rsm($id_dis,$id_rsm);
		
        echo json_encode($data);
    }
	
	private function make_array_hasil($datasedigi, $gsm_to_so, $data_sales){
		$hasil = array();
		foreach($datasedigi as $d){
			foreach ($gsm_to_so as $gs) {
				if($d['KD_DISTRIK']==$gs['ID_DISTRIK']){
					
					$r1 = "";
					$r2 = "";
					$r3 = "";
					$r4 = "";
					foreach($data_sales as $sa){
						if($d['KD_DISTRIBUTOR']==$sa['KODE_DISTRIBUTOR']){
							if($d['KD_CUSTOMER']==$sa['KD_CUSTOMER']){
								$r1 = $sa['ID_SALES'];
								$r2 = $sa['NAMA'];
								$r3 = $sa['ALAMAT'];
								$r4 = $sa['NAMA_TOKO'];
							}
						}
					}
					array_push($hasil, 
						array 	(
								'NO_SPJ' => $d['NO_SPJ'],
								'TGL_SPJ' => $d['TGL_SPJ'],
								'KD_CUSTOMER' => $d['KD_CUSTOMER'],
								'NM_CUSTOMER' => $d['NM_CUSTOMER'],
								'KD_DISTRIBUTOR' => $d['KD_DISTRIBUTOR'],
								'NM_DISTRIBUTOR' => $d['NM_DISTRIBUTOR'],
								'KD_GUDANG' 	=> $d['KD_GUDANG'],
								'NM_GUDANG' => $d['NM_GUDANG'],
								'NM_PRODUK' => $d['NM_PRODUK'],
								'ZAK_KG' => $d['ZAK_KG'],
								'QTY_SELL_OUT' => $d['QTY_SELL_OUT'],
								'HARGA_SELL_OUT' => $d['HARGA_SELL_OUT'],
								'HARGA_PER_ZAK' => number_format($d['HARGA_PER_ZAK']),//ditambah data crm.
								'ID_SALES' 		=> $r1,
								'NAMA_SALES' 	=> $r2,
								'ALAMAT' 		=> $r3,

								'NM_DISTRIK' 	=> $d['NM_DISTRIK'],
								'NM_AREA' 		=> $d['NM_AREA'],
								'NM_PROVINSI' 	=> $d['NM_PROVINSI'],
								'REGION' 		=> $d['REGION'],

								'NAMA_GSM' 	=> $gs['NAMA_GSM'],
								'NAMA_SSM' 	=> $gs['NAMA_SSM'],
								'NAMA_SM' 	=> $gs['NAMA_SM'],
								'NAMA_SO' 	=> $gs['NAMA_SO'],
								
								)
					);
				}
			}
			
		}
		return $hasil;
	}
	public function getdata_so(){
		$star			= $this->input->post("startDate");
		$end			= $this->input->post("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$id_distributor	= $this->input->post("id_distributor");
		$idsales		= $this->input->post("idsales");
		
		//$datacrm		 = $this->Report_volume_model->get_data_crm($id_user, $id_distributor, $idsales);

		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'SO', $idsales,  $id_distributor);

		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'SO');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, $idsales, 'SO');		
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		
		echo json_encode($hasil);
	}
	
	public function get_data_dis(){
		$star			= $this->input->post("startDate");
		$end			= $this->input->post("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$idsales		= $this->input->post("idsales");

		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'DIS', $idsales,  null);
		
		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'DIS');
		
		
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, null, $idsales, 'DIS');	
		// print_r($datasedigi);
		
		// exit;
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		
		echo json_encode($hasil);
	}
	public function getdataasm(){
		$star			= $this->input->post("startDate");
		$end			= $this->input->post("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$id_distributor	= $this->input->post("id_distributor");
		$idsales		= $this->input->post("idsales");
		
		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'SM', $idsales,  $id_distributor);

		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'SM');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, $idsales, 'SM');		
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		
		echo json_encode($hasil);
	}
	
	public function getdata_rsm(){
		$star			= $this->input->post("startDate");
		$end			= $this->input->post("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$id_distributor	= $this->input->post("id_distributor");
		$idsales		= $this->input->post("idsales");
		
		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'SSM', $idsales,  $id_distributor);

		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'SSM');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, $idsales, 'SSM');		
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		
		echo json_encode($hasil);
	}
	public function getdata_GSM(){
		$star			= $this->input->post("startDate");
		$end			= $this->input->post("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$id_distributor	= $this->input->post("id_distributor");
		$idsales		= $this->input->post("idsales");
		
		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'GSM', $idsales,  $id_distributor);

		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'GSM');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, $idsales, 'GSM');		
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		
		echo json_encode($hasil);
	}
	public function getdata_SPC(){
		$star			= $this->input->post("startDate");
		$end			= $this->input->post("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$id_distributor	= $this->input->post("id_distributor");
		$idsales		= $this->input->post("idsales");
		
		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'SPC', $idsales,  $id_distributor);

		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'SPC');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, $idsales, 'SPC');		
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		
		echo json_encode($hasil);
	}
	public function getdataAdmin(){
		$star			= $this->input->post("startDate");
		$end			= $this->input->post("endDate");
		
		$id_distributor	= $this->input->post("id_distributor");
		$id_region		= $this->input->post("region");
		$id_provinsi	= $this->input->post("id_provinsi");
		
		$datacrm		 = $this->Report_volume_model->get_data_crm_admin($id_distributor, $id_region, $id_provinsi);
		
		$datadistributor = $this->Report_volume_model->User_dis_admin();
		$fild='';
		$n=1;
		foreach($datadistributor as $d){
			if(count($datadistributor)>$n){
				$fild .= "'". $d['KODE_DISTRIBUTOR']."',";;
			}
			else {
				$fild .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;	
		}
		
		$datasedigi = $this->Report_volume_model->get_data_sidigi_rsm($star , $end, $fild);
		
		
		$hasil = array();
		foreach($datasedigi as $d){
			foreach($datacrm as $c){
				if($c['KD_CUSTOMER']==$d['KD_CUSTOMER']){
					$disc = $c['KODE_DISTRIBUTOR'];
					
					if($disc==$d['KD_DISTRIBUTOR']){
						array_push($hasil, 
							array 	(
									'NO_SPJ' => $d['NO_SPJ'],
									'TGL_SPJ' => $d['TGL_SPJ'],
									'KD_CUSTOMER' => $d['KD_CUSTOMER'],
									'KD_DISTRIBUTOR' => $d['KD_DISTRIBUTOR'],
									'NM_DISTRIBUTOR' => $d['NM_DISTRIBUTOR'],
									'KD_GUDANG' 	=> $d['KD_GUDANG'],
									'NM_GUDANG' => $d['NM_GUDANG'],
									'NM_PRODUK' => $d['NM_PRODUK'],
									'ZAK_KG' => $d['ZAK_KG'],
									'QTY_SELL_OUT' => $d['QTY_SELL_OUT'],
									'HARGA_SELL_OUT' => number_format($d['HARGA_SELL_OUT']),
									'AKSES_TOKO' => $d['AKSES_TOKO'],
									'HARGA_PER_ZAK' => number_format($d['HARGA_PER_ZAK']),//ditambah data crm.
									
									'ID_SALES' => $c['ID_SALES'],
									'NM_SALES' => $c['NM_SALES'],
									'NAMA_DISTRIBUTOR' => $c['NAMA_DISTRIBUTOR'],
									'NAMA_TOKO' => $c['NAMA_TOKO'],
									'ALAMAT' => $c['ALAMAT'],
									'NAMA_PROVINSI' => $c['NAMA_PROVINSI'],
									'NAMA_AREA' => $c['NAMA_AREA'],
									'NAMA_DISTRIK' => $c['NAMA_DISTRIK'],
									'NAMA_TSO' => $c['NAMA_SO'],
									'NAMA_ASM' => $c['NAMA_SM'],
									'NAMA_RSM' => $c['NAMA_SSM'],
									'NAMA_GSM' => $c['NAMA_GSM'],
									'NEW_REGION' => $c['REGION_ID']
									
									)
						);
					}
					
				}

				
			}
			
		}
		echo json_encode($hasil);
	}
	
	/*
	public function getdataAdmin(){
		$star			= $this->input->post("startDate");
		$end			= $this->input->post("endDate");
		
		$id_distributor	= $this->input->post("id_distributor");
		$id_region		= $this->input->post("region");
		$id_provinsi	= $this->input->post("id_provinsi");
		
		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'ADMIN', null,  $id_distributor);

		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'ADMIN');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, null, 'ADMIN');		
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		
		echo json_encode($hasil);
		
	}*/
	
	public function toExcel_DIS(){
		$star			= $this->input->get("startDate");
		$end			= $this->input->get("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$idsales		= $this->input->get("id");

		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'DIS', $idsales,  null);
		
		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'DIS');
		
		
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, null, $idsales, 'DIS');	
		// print_r($datasedigi);
		
		// exit;
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		// echo '<pre>';
		// print_r($hasil);
		// echo '</pre>';
		// exit;
		
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
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA VOLUME SELLOUT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA VOLUME SELLOUT");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:N2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "GUDANG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NO SPJ");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "QTY SELLOUT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "HARGA/ZAK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "KODE TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "ALAMAT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "REGION");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "AREA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "DISTRIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "Sales Officer");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "Sales Manajer");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "Senior Sales Manajer");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', "General Sales Manajer");

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
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);

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
		$objPHPExcel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VolumeKey => $list_ValumeValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_ValumeValue['NAMA_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_ValumeValue['NM_GUDANG']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_ValumeValue['NO_SPJ']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_ValumeValue['TGL_SPJ']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_ValumeValue['NM_PRODUK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_ValumeValue['QTY_SELL_OUT']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_ValumeValue['HARGA_PER_ZAK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_ValumeValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_ValumeValue['NM_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_ValumeValue['ALAMAT']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_ValumeValue['REGION']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_ValumeValue['NM_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_ValumeValue['NM_AREA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIK']));

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, strtoupper($list_ValumeValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numRow, strtoupper($list_ValumeValue['NAMA_SM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numRow, strtoupper($list_ValumeValue['NAMA_SSM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numRow, strtoupper($list_ValumeValue['NAMA_GSM']));

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
	
	public function toExcelTSO(){
		$star			= $this->input->get("startDate");
		$end			= $this->input->get("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$id_distributor	= $this->input->get("id");
		$idsales		= $this->input->get("idsales");
		
		//$datacrm		 = $this->Report_volume_model->get_data_crm($id_user, $id_distributor, $idsales);

		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'SO', $idsales,  $id_distributor);

		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'SO');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, $idsales);		
		
		$hasil = array();
		foreach($datasedigi as $d){
			foreach ($gsm_to_so as $gs) {
				if($d['KD_DISTRIK']==$gs['ID_DISTRIK']){
					
					$r1 = "";
					$r2 = "";
					$r3 = "";
					$r4 = "";
					foreach($data_sales as $sa){
						if($d['KD_DISTRIBUTOR']==$sa['KODE_DISTRIBUTOR']){
							if($d['KD_CUSTOMER']==$sa['KD_CUSTOMER']){
								$r1 = $sa['ID_SALES'];
								$r2 = $sa['NAMA'];
								$r3 = $sa['ALAMAT'];
								$r4 = $sa['NAMA_TOKO'];
							}
						}
					}
					array_push($hasil, 
						array 	(
								'NO_SPJ' => $d['NO_SPJ'],
								'TGL_SPJ' => $d['TGL_SPJ'],
								'KD_CUSTOMER' => $d['KD_CUSTOMER'],
								'NM_CUSTOMER' => $d['NM_CUSTOMER'],
								'KD_DISTRIBUTOR' => $d['KD_DISTRIBUTOR'],
								'NM_DISTRIBUTOR' => $d['NM_DISTRIBUTOR'],
								'KD_GUDANG' 	=> $d['KD_GUDANG'],
								'NM_GUDANG' => $d['NM_GUDANG'],
								'NM_PRODUK' => $d['NM_PRODUK'],
								'ZAK_KG' => $d['ZAK_KG'],
								'QTY_SELL_OUT' => $d['QTY_SELL_OUT'],
								'HARGA_SELL_OUT' => $d['HARGA_SELL_OUT'],
								'HARGA_PER_ZAK' => number_format($d['HARGA_PER_ZAK']),//ditambah data crm.
								'ID_SALES' 		=> $r1,
								'NAMA_SALES' 	=> $r2,
								'ALAMAT' 		=> $r3,

								'NM_DISTRIK' 	=> $d['NM_DISTRIK'],
								'NM_AREA' 		=> $d['NM_AREA'],
								'NM_PROVINSI' 	=> $d['NM_PROVINSI'],
								'REGION' 		=> $d['REGION'],

								'NAMA_GSM' 	=> $gs['NAMA_GSM'],
								'NAMA_SSM' 	=> $gs['NAMA_SSM'],
								'NAMA_SM' 	=> $gs['NAMA_SM'],
								'NAMA_SO' 	=> $gs['NAMA_SO'],
								
								)
					);
				}
			}
			
		}
		// echo '<pre>';
		// print_r($hasil);
		// echo '</pre>';
		// exit;
		
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
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA VOLUME SELLOUT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA VOLUME SELLOUT");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:N2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "GUDANG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NO SPJ");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "QTY SELLOUT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "HARGA/ZAK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "KODE TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "ALAMAT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "REGION");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "AREA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "DISTRIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "Sales Officer");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "Sales Manajer");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "Senior Sales Manajer");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', "General Sales Manajer");

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
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);

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
		$objPHPExcel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VolumeKey => $list_ValumeValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_ValumeValue['NAMA_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_ValumeValue['NM_GUDANG']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_ValumeValue['NO_SPJ']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_ValumeValue['TGL_SPJ']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_ValumeValue['NM_PRODUK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_ValumeValue['QTY_SELL_OUT']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_ValumeValue['HARGA_PER_ZAK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_ValumeValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_ValumeValue['NM_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_ValumeValue['ALAMAT']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_ValumeValue['REGION']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_ValumeValue['NM_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_ValumeValue['NM_AREA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIK']));

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, strtoupper($list_ValumeValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numRow, strtoupper($list_ValumeValue['NAMA_SM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numRow, strtoupper($list_ValumeValue['NAMA_SSM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numRow, strtoupper($list_ValumeValue['NAMA_GSM']));

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
	
	public function toExcelASM(){
		$star			= $this->input->get("startDate");
		$end			= $this->input->get("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$id_distributor	= $this->input->get("id_distributor");
		$idsales		= $this->input->get("idsales");
		if($idsales=='undefined'){
			$idsales=null;
		}
		
		
		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'SM', $idsales,  $id_distributor);

		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'SM');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, $idsales, 'SM');		
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		$this->Cetak_exel($hasil);
		
	}
	public function toExcel_RSM(){
		$star			= $this->input->get("startDate");
		$end			= $this->input->get("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$id_distributor	= $this->input->get("id_distributor");
		$idsales		= $this->input->get("idsales");
		if($idsales=='undefined'){
			$idsales=null;
		}
		
		
		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'SSM', $idsales,  $id_distributor);

		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'SSM');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, $idsales, 'SSM');		
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		$this->Cetak_exel($hasil);
		
	}
	public function toExcel_GSM(){
		$star			= $this->input->get("startDate");
		$end			= $this->input->get("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$id_distributor	= $this->input->get("id_distributor");
		$idsales		= $this->input->get("idsales");
		if($idsales=='undefined'){
			$idsales=null;
		}
		
		
		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'GSM', $idsales,  $id_distributor);

		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'GSM');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, $idsales, 'GSM');		
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		$this->Cetak_exel($hasil);
		
	}
	public function toExcel_SPC(){
		$star			= $this->input->get("startDate");
		$end			= $this->input->get("endDate");
		
		$id_user 		= $this->session->userdata('user_id');
		$id_distributor	= $this->input->get("id_distributor");
		$idsales		= $this->input->get("idsales");
		if($idsales=='undefined'){
			$idsales=null;
		}
		
		$data_sales = $this->Report_volume_model->Get_data_sales_toko($id_user, 'SPC', $idsales,  $id_distributor);
		$gsm_to_so 	= $this->Report_volume_model->Get_data_gsm_so($id_user, 'SPC');
		$datasedigi = $this->Report_volume_model->get_data_sidigi($star, $end, $id_user, $id_distributor, $idsales, 'SPC');		
		
		$hasil = $this->make_array_hasil($datasedigi, $gsm_to_so, $data_sales);
		$this->Cetak_exel($hasil);
		
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
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA VOLUME SELLOUT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA VOLUME SELLOUT");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:N2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "GUDANG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NO SPJ");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "QTY SELLOUT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "HARGA/ZAK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "KODE TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "ALAMAT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "REGION");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "AREA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "DISTRIK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "Sales Officer");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "Sales Manajer");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "Senior Sales Manajer");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', "General Sales Manajer");

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
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);

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
		$objPHPExcel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VolumeKey => $list_ValumeValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_ValumeValue['NAMA_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_ValumeValue['NM_GUDANG']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_ValumeValue['NO_SPJ']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_ValumeValue['TGL_SPJ']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_ValumeValue['NM_PRODUK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_ValumeValue['QTY_SELL_OUT']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_ValumeValue['HARGA_PER_ZAK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_ValumeValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_ValumeValue['NM_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_ValumeValue['ALAMAT']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_ValumeValue['REGION']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_ValumeValue['NM_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_ValumeValue['NM_AREA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIK']));

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, strtoupper($list_ValumeValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numRow, strtoupper($list_ValumeValue['NAMA_SM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numRow, strtoupper($list_ValumeValue['NAMA_SSM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numRow, strtoupper($list_ValumeValue['NAMA_GSM']));

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
	
	public function toExcelAdmin(){
		$star			= $this->input->get("startDate");
		$end			= $this->input->get("endDate");
		
		$id_distributor	= $this->input->get("id_distributor");
		$id_region		= $this->input->get("region");
		$id_provinsi	= $this->input->get("id_provinsi");
		
		$datacrm		 = $this->Report_volume_model->get_data_crm_admin($id_distributor, $id_region, $id_provinsi);
		
		$datadistributor = $this->Report_volume_model->User_dis_admin();
		$fild='';
		$n=1;
		foreach($datadistributor as $d){
			if(count($datadistributor)>$n){
				$fild .= "'". $d['KODE_DISTRIBUTOR']."',";;
			}
			else {
				$fild .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;
				
		}
		
		$datasedigi = $this->Report_volume_model->get_data_sidigi_rsm($star , $end, $fild);
		
		
		$hasil = array();
		foreach($datasedigi as $d){
			foreach($datacrm as $c){
				if($c['KD_CUSTOMER']==$d['KD_CUSTOMER']){
					$disc = $c['KODE_DISTRIBUTOR'];
					
					if($disc==$d['KD_DISTRIBUTOR']){
						array_push($hasil, 
							array 	(
									'NO_SPJ' => $d['NO_SPJ'],
									'TGL_SPJ' => $d['TGL_SPJ'],
									'KD_CUSTOMER' => $d['KD_CUSTOMER'],
									'KD_DISTRIBUTOR' => $d['KD_DISTRIBUTOR'],
									'NM_DISTRIBUTOR' => $d['NM_DISTRIBUTOR'],
									'KD_GUDANG' 	=> $d['KD_GUDANG'],
									'NM_GUDANG' => $d['NM_GUDANG'],
									'NM_PRODUK' => $d['NM_PRODUK'],
									'ZAK_KG' => $d['ZAK_KG'],
									'QTY_SELL_OUT' => $d['QTY_SELL_OUT'],
									'HARGA_SELL_OUT' => number_format($d['HARGA_SELL_OUT']),
									'AKSES_TOKO' => $d['AKSES_TOKO'],
									'HARGA_PER_ZAK' => number_format($d['HARGA_PER_ZAK']),//ditambah data crm.
									
									'ID_SALES' => $c['ID_SALES'],
									'NM_SALES' => $c['NM_SALES'],
									'NAMA_DISTRIBUTOR' => $c['NAMA_DISTRIBUTOR'],
									'NAMA_TOKO' => $c['NAMA_TOKO'],
									'ALAMAT' => $c['ALAMAT'],
									'NAMA_PROVINSI' => $c['NAMA_PROVINSI'],
									'NAMA_AREA' => $c['NAMA_AREA'],
									'NAMA_DISTRIK' => $c['NAMA_DISTRIK'],
									'NAMA_TSO' => $c['NAMA_SO'],
									'NAMA_ASM' => $c['NAMA_SM'],
									'NAMA_RSM' => $c['NAMA_SSM'],
									'NAMA_GSM' => $c['NAMA_GSM'],
									'NEW_REGION' => $c['REGION_ID']
									
									)
						);
					}
					
				}

				
			}
			
		}
		
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
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA VOLUME SELLOUT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA VOLUME SELLOUT");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:N2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "SALES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "GUDANG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NO SPJ");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "QTY SELLOUT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "HARGA/ZAK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "KODE TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "NAMA TOKO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "ALAMAT");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "AREA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "DISTRIK");

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
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

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
		$objPHPExcel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VolumeKey => $list_ValumeValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_ValumeValue['NM_SALES']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_ValumeValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_ValumeValue['NM_GUDANG']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_ValumeValue['NO_SPJ']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_ValumeValue['TGL_SPJ']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_ValumeValue['NM_PRODUK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_ValumeValue['QTY_SELL_OUT']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_ValumeValue['HARGA_PER_ZAK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_ValumeValue['KD_CUSTOMER']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_ValumeValue['NAMA_TOKO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_ValumeValue['ALAMAT']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_ValumeValue['NAMA_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_ValumeValue['NAMA_AREA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_ValumeValue['NAMA_DISTRIK']));

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