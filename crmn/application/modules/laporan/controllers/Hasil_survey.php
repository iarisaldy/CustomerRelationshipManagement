<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Hasil_survey extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Hasil_survey_model');

		set_time_limit(0);
		ini_set('memory_limit','2048M');
		
		
		
    }
	
	public function DISTRIBUTOR_SURVEY(){
        //$id_provinsi    = $this->input->post('id_provinsi');
		
        $data = $this->Hasil_survey_model->Get_Distributor();
       
    }
	private function make_distributor_option($data){
		$isi ='';
		foreach($data as $h){
			$isi .= '<select id="listDistributor" class="form-control selectpicker show-tick" data-live-search="true">';
		}
		
	}
	

    public function index(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Hasil_survey_model->Get_region_all();
		$this->template->display('hasil_survey', $data);
		
    }
	public function So(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Hasil_survey_model->Get_region_all();

		
		$this->template->display('hasil_survey_so', $data);
		
	}
	public function SM(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Hasil_survey_model->Get_region_all();

		
		$this->template->display('hasil_survey_sm', $data);
		
	}
	public function SSM(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Hasil_survey_model->Get_region_all();

		
		$this->template->display('hasil_survey_ssm', $data);
		
	}
	public function GSM(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Hasil_survey_model->Get_region_all();
		$this->template->display('hasil_survey_gsm', $data);
	}
	public function SPC(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_region'] 		= $this->Hasil_survey_model->Get_region_all();
		$data['list_distributor'] 	= $this->Hasil_survey_model->Get_Distributor();
		$this->template->display('hasil_survey_spc', $data);
	}
	public function ADMIN(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] 		= $this->Hasil_survey_model->Get_region_all();
		$data['list_distributor'] 	= $this->Hasil_survey_model->Get_Distributor();
		
		$this->template->display('hasil_survey_admin1', $data);
	}
	public function DIS(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Hasil_survey_model->Get_region_all();

		
		$this->template->display('hasil_survey_dis', $data);
    }
		
	public function ListProvinsi(){
        $id_region    = $this->input->post('id_region');
		
        $data = $this->Hasil_survey_model->Get_provinsi_all($id_region);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	public function ListDistributor(){
        $id_provinsi    = $this->input->post('id_provinsi');
		
        $data = $this->Hasil_survey_model->Get_Dis_all($id_provinsi);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	
	public function TSO(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Data_sales_model->User_distributor($id_user);
		//$data['list_sales'] = $this->Data_sales_model->User_SALES($id_user);
		$this->template->display('Repot_data_salesTSO', $data);
    }
	
	public function ListSalesDIS(){
		$id_user = $this->session->userdata('user_id');
        $id_dis  = $this->input->post('id_dis');

        $data = $this->Data_sales_model->User_SALES($id_user, $id_dis);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	public function ASM(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Data_sales_model->ASM_dis($id_user);
		$data['list_tso'] = $this->Data_sales_model->User_TSO($id_user);
		$this->template->display('Repot_data_salesASM', $data);
    }
	
	public function RSM(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Data_sales_model->RSM_dis($id_user);
		$data['list_asm'] = $this->Data_sales_model->listASM($id_user);
		$this->template->display('Repot_data_salesRSM', $data);
    }
	
	
	public function ambildataall(){
		//$id_dis = $this->input->post("id");
		$tahun 	= '2020'; //$this->input->post("tahun");
		$bulan 	= 3; //$this->input->post("bulan");
		
		if($bulan<10){
			$bulan = '0'. $bulan;
		}	
		$hasil= $this->Hasil_survey_model->get_data_admin($tahun, $bulan);
		echo "<pre>";
		print_r($hasil);
		echo "<pre>";
		//echo json_encode($hasil);
	}
	
	public function ambildatatso(){
		$mulai 		= $this->input->post("mulai");
		$selesai 	= $this->input->post("selesai");
		$id_user = $this->session->userdata('user_id');
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($mulai, $selesai, $id_user, 'SO');
		
		echo json_encode($hasil);
	}
	public function ambildata_dis(){
		$tahun 	= $this->input->post("tahun");
		$bulan 	= $this->input->post("bulan");
		$id_user = $this->session->userdata('user_id');
		if($bulan<10){
			$bulan = '0'. $bulan;
		}	
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($tahun, $bulan, $id_user, 'DIS');
		
		echo json_encode($hasil);
	}
	public function ambildata_SM(){
		$mulai 		= $this->input->post("mulai");
		$selesai 	= $this->input->post("selesai");
		$id_user = $this->session->userdata('user_id');
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($mulai, $selesai, $id_user, 'SM');
		
		echo json_encode($hasil);
	}
	public function ambildata_SSM(){
		$mulai 		= $this->input->post("mulai");
		$selesai 	= $this->input->post("selesai");
		$id_user = $this->session->userdata('user_id');
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($mulai, $selesai, $id_user, 'SSM');
		
		echo json_encode($hasil);
	}
	
	public function ambildataadmin(){
		$id_dis 	= $this->input->post("id");
		$region 	= $this->input->post("region");
		$mulai 		= $this->input->post("mulai");
		$selesai 	= $this->input->post("selesai");
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey_a1($id_dis, $mulai, $selesai, $region);
		
		echo json_encode($hasil);
	}
	public function ambildatagsm(){
		$mulai 		= $this->input->post("mulai");
		$selesai 	= $this->input->post("selesai");
		$id_user = $this->session->userdata('user_id');
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($mulai, $selesai, $id_user, 'GSM');
		echo json_encode($hasil);
	}
	public function ambildataspc(){
		$id_dis 	= $this->input->post("id");
		//$region 	= $this->input->post("region");
		$mulai 		= $this->input->post("mulai");
		$selesai 	= $this->input->post("selesai");
		$id_user = $this->session->userdata('user_id');
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($mulai, $selesai, $id_user, 'SPC', null, $id_dis);
		
		echo json_encode($hasil);
	}
	
	public function ambildataasm(){
		$id_dis = $this->input->post("id");
		$id_tso = $this->input->post("id_tso");
		$id_user = $this->session->userdata('user_id');
			
		$hasil= $this->Hasil_survey_model->get_data_asm($id_user, $id_dis, $id_tso);
		echo json_encode($hasil);
	}
	
	public function ambildatarsm(){
		$id_dis = $this->input->post("id");
		$id_user = $this->session->userdata('user_id');
			
		$hasil= $this->Hasil_survey_model->get_data_rsm($id_user , $id_dis);
		echo json_encode($hasil);
	}
	
	
	
	public function ambildatadis(){
		$id_user = $this->session->userdata('user_id');
			
		$hasil= $this->Hasil_survey_model->get_data_dis($id_user);
		echo json_encode($hasil);
	}
	
	public function toExcel_dis(){
		$tahun 	= $this->input->get("tahun");
		$bulan 	= $this->input->get("bulan");
		$id_user = $this->session->userdata('user_id');
		if($bulan<10){
			$bulan = '0'. $bulan;
		}	
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($tahun, $bulan, $id_user, 'DIS');
		$this->toExcel($hasil);
		
	}
	public function toExcel_SO(){
		$mulai 		= $this->input->get("mulai");
		$selesai 	= $this->input->get("selesai");
		$id_user = $this->session->userdata('user_id');
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($mulai, $selesai, $id_user, 'SO');
		$this->toExcel($hasil);
	}
	public function toExcel_SPC(){
		$id_dis 	= $this->input->get("id");
		$mulai 		= $this->input->get("mulai");
		$selesai 	= $this->input->get("selesai");
		//$region 	= $this->input->get("region");
		$id_user = $this->session->userdata('user_id');
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($mulai, $selesai, $id_user, 'SPC');
		$this->toExcel($hasil);
	}
	
	public function toExcel_ADMIN(){
		$id_dis 	= $this->input->get("id");
		$mulai 		= $this->input->get("mulai");
		$selesai 	= $this->input->get("selesai");
		$region 	= $this->input->get("region");
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey_a1($id_dis, $mulai, $selesai, $region);
		
		$this->toExcel($hasil);
	}
	public function toExcel_SM(){
		$mulai 		= $this->input->get("mulai");
		$selesai 	= $this->input->get("selesai");
		$id_user = $this->session->userdata('user_id');
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($mulai, $selesai, $id_user, 'SM');
		
		$this->toExcel($hasil);
	}
	public function toExcel_SSM(){
		$mulai 		= $this->input->get("mulai");
		$selesai 	= $this->input->get("selesai");
		$id_user = $this->session->userdata('user_id');
		
		$hasil= $this->Hasil_survey_model->get_data_hasil_survey($mulai, $selesai, $id_user, 'SSM');
		$this->toExcel($hasil);
	}
	
	
	public function toExcel($ListSales){
			
			$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Sales');
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
			
			$filename = "Data Hasil Survey";
            $objPHPExcel->getActiveSheet(0)->setTitle("DATA HASIL SURVEY");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA HASIL SURVEY SALES");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:L2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "TGL KUNJUNGAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "KD TOKO");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA TOKO");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA DISTRIBUTOR");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "DISTRIK");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "AREA");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "PROVINSI");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "REGION");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "KD PRODUK");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "NAMA PRODUK");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "STOK SAAT INI");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "VOLUME PEMBELIAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "HARGA PEMBELIAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "TGL PEMBELIAN");
			
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "VOLUME PENJUALAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "HARGA PENJUALAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', "KAPASITAS TOKO");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', "KAPASITAS JUAL TOKO SEMEUA MEREK (BULAN)");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U3', "SEMEN MEMBATU");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V3', "SEMEN TERLAMBAT DATANG");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W3', "KANTONG TIDAK KUAT");
			
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X3', "HARGA TIDAK STABIL");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y3', "TOP KURANG LAMA");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z3', "PEMESANAN SULIT");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA3', "KOMPLIN SULIT");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB3', "STOK SERING KOSONG");
			
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC3', "PROSEDUR RUMIT");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD3', "TIDAK SESUAI SPESIFIKASI");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE3', "TIDAK ADA KELUHAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF3', "KELUHAN LAIN-LAN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG3', "BONUS SEMEN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH3', "SETIAP PEMBELIAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI3', "BONUS WISATA");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ3', "SETIAP PEMBELIAN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK3', "POINT REWARD");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL3', "SETIAP PEMBELIAN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM3', "VOUCER");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN3', "SETIAP PEMBELIAN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO3', "POTONGAN HARGA");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP3', "SETIAP PEMBELIAN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AQ3', "LAIN LAIN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR3', "TIDAK ADA PROMOSI");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS3', "STATUS VISIT");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT3', "NAMA AM");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU3', "NAMA SM");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV3', "HARGA TIDAK BERSAING DENGAN KOMPETITOR");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW3', "PROGRAM PENJUALAN TIDAK MENARIK");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AX3', "HADIAH PROGRAM PENJUALAN BELUM DICAIRKAN");
			
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
			$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true);

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
            $objPHPExcel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('U3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('V3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('W3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('X3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('Y3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('Z3')->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('AA3')->applyFromArray($style_col);
             $objPHPExcel->getActiveSheet()->getStyle('AB3')->applyFromArray($style_col);
             $objPHPExcel->getActiveSheet()->getStyle('AC3')->applyFromArray($style_col);
              $objPHPExcel->getActiveSheet()->getStyle('AD3')->applyFromArray($style_col);
               $objPHPExcel->getActiveSheet()->getStyle('AE3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AF3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AG3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AH3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AI3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AJ3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AK3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AL3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AM3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AN3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AO3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AP3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AQ3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AR3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AS3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AT3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AU3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AV3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AW3')->applyFromArray($style_col);
			   $objPHPExcel->getActiveSheet()->getStyle('AX3')->applyFromArray($style_col);
            
			$no = 1;
            $numRow = 4;
            foreach ($ListSales as $list_SalesKey => $list_SalesValue) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_SalesValue['ID_SALES']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_SalesValue['NAMA_SALES']));		
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_SalesValue['TGL_RENCANA_KUNJUNGAN']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_SalesValue['ID_TOKO']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_SalesValue['NAMA_TOKO']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_SalesValue['NAMA_DISTRIBUTOR']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_SalesValue['NAMA_DISTRIK']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_SalesValue['NAMA_AREA']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_SalesValue['NAMA_PROVINSI']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_SalesValue['REGION_ID']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_SalesValue['ID_PRODUK']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_SalesValue['NAMA_PRODUK']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_SalesValue['STOK_SAAT_INI']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_SalesValue['VOLUME_PEMBELIAN']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, strtoupper($list_SalesValue['HARGA_PEMBELIAN']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, strtoupper($list_SalesValue['TGL_PEMBELIAN']));
				
                //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, strtoupper($list_SalesValue['TOP_PEMBELIAN']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numRow, strtoupper($list_SalesValue['VOLUME_PENJUALAN']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numRow, strtoupper($list_SalesValue['HARGA_PENJUALAN']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numRow, strtoupper($list_SalesValue['KAPASITAS_TOKO']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numRow, strtoupper($list_SalesValue['KAPASITAS_ZAK']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$numRow, strtoupper($list_SalesValue['SEMEN_MENBATU']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$numRow, strtoupper($list_SalesValue['SEMEN_TERLAMBAT_DATANG']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$numRow, strtoupper($list_SalesValue['KANTONG_TIDAK_KUAT']));
				
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$numRow, strtoupper($list_SalesValue['HARGA_TIDAK_STABIL']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$numRow, strtoupper($list_SalesValue['TOP_KURANG_LAMA']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$numRow, strtoupper($list_SalesValue['PEMESANAN_SULIT']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$numRow, strtoupper($list_SalesValue['KOMPLAIN_SULIT']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$numRow, strtoupper($list_SalesValue['STOK_SERING_KOSONG']));
				
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$numRow, strtoupper($list_SalesValue['PROSEDUR_RUMIT']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$numRow, strtoupper($list_SalesValue['TIDAK_SESUAI_SPESIFIKASI']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.$numRow, strtoupper($list_SalesValue['TIDAK_ADA_KELUHAN']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$numRow, strtoupper($list_SalesValue['KELUHAN_LAIN_LAIN']));
				
                  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$numRow, strtoupper($list_SalesValue['BONUS_SEMEN']));
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH'.$numRow, strtoupper($list_SalesValue['SETIAP_PEMBELIAN_SEMEN']));
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.$numRow, strtoupper($list_SalesValue['BONUS_WISATA']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ'.$numRow, strtoupper($list_SalesValue['SETIAP_PEMBELIAN_WISATA']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK'.$numRow, strtoupper($list_SalesValue['POINT_REWARD']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL'.$numRow, strtoupper($list_SalesValue['SETIAP_PEMBELIAN_POINT']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM'.$numRow, strtoupper($list_SalesValue['BONUS_VOUCER']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN'.$numRow, strtoupper($list_SalesValue['SETIAP_PEMBELIAN_VOUCER']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO'.$numRow, strtoupper($list_SalesValue['POTONGAN_HARGA']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP'.$numRow, strtoupper($list_SalesValue['SETIAP_PEMBELIAN_POTONGAN']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AQ'.$numRow, strtoupper($list_SalesValue['LAN_LAIN']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR'.$numRow, strtoupper($list_SalesValue['TIDAK_ADA_PROMOSI']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS'.$numRow, strtoupper($list_SalesValue['STATUS_VISIT']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT'.$numRow, strtoupper($list_SalesValue['NAMA_SO']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU'.$numRow, strtoupper($list_SalesValue['NAMA_SM']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV'.$numRow, strtoupper($list_SalesValue['HARGA_TIDAK_BERSAING']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW'.$numRow, strtoupper($list_SalesValue['PP_TIDAK_MENARIK']));
				   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AX'.$numRow, strtoupper($list_SalesValue['HADIAH_BELUM_DICAIRKAN']));

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
                            $objPHPExcel->getActiveSheet()->getStyle('X'.$numRow)->applyFromArray($style_row);
                             $objPHPExcel->getActiveSheet()->getStyle('Y'.$numRow)->applyFromArray($style_row);
                              $objPHPExcel->getActiveSheet()->getStyle('Z'.$numRow)->applyFromArray($style_row);
                               $objPHPExcel->getActiveSheet()->getStyle('AA'.$numRow)->applyFromArray($style_row);
                                $objPHPExcel->getActiveSheet()->getStyle('AB'.$numRow)->applyFromArray($style_row);
                                 $objPHPExcel->getActiveSheet()->getStyle('AC'.$numRow)->applyFromArray($style_row);
                                  $objPHPExcel->getActiveSheet()->getStyle('AD'.$numRow)->applyFromArray($style_row);
                                   $objPHPExcel->getActiveSheet()->getStyle('AE'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AF'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AG'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AH'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AI'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AJ'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AK'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AL'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AM'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AN'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AO'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AP'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AQ'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AR'.$numRow)->applyFromArray($style_row);
								   $objPHPExcel->getActiveSheet()->getStyle('AS'.$numRow)->applyFromArray($style_row);
                                   $objPHPExcel->getActiveSheet()->getStyle('AT'.$numRow)->applyFromArray($style_row);
                                   $objPHPExcel->getActiveSheet()->getStyle('AU'.$numRow)->applyFromArray($style_row);
                                   $objPHPExcel->getActiveSheet()->getStyle('AV'.$numRow)->applyFromArray($style_row);
								    $objPHPExcel->getActiveSheet()->getStyle('AW'.$numRow)->applyFromArray($style_row);
									 $objPHPExcel->getActiveSheet()->getStyle('AX'.$numRow)->applyFromArray($style_row);
                                    
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