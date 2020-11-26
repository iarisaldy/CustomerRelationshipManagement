<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Report_kapasitas_toko extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Kapasitas_toko_model');
		$this->load->model('Report_sellin_model');

		set_time_limit(0);
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Kapasitas_toko_model->User_distributor($id_user, 'SO');
		$this->template->display('V_kapasitas_toko', $data);
		
    }
	
	public function Admin(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		$data['list_distributor'] = $this->Kapasitas_toko_model->User_distributor($id_user, 'ADMIN');
		$this->template->display('V_kapasitas_toko_admin', $data);
		
    }
    public function GSM(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Kapasitas_toko_model->Distributor_gsm($id_user, 'GSM');
		$this->template->display('V_kapasitas_toko_gsm', $data);
		
    }
    public function SPC(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Kapasitas_toko_model->User_distributor($id_user, 'SPC');
		$this->template->display('V_kapasitas_toko_spc', $data);	
    }
	
	public function RSM(){
	
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Kapasitas_toko_model->User_distributor($id_user, 'SSM');
		$this->template->display('V_kapasitas_toko_rsm', $data);
		
    }
    
    public function ASM(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Kapasitas_toko_model->User_distributor($id_user, 'SM');
		$this->template->display('V_kapasitas_toko_asm', $data);
		
    }
	
	public function DIS(){
	
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		//$data['list_distrik'] = $this->Kapasitas_toko_model->User_Distrik($id_user);
		$this->template->display('V_kapasitas_toko_dis', $data);	
    }
	
	public function filterdata(){
		$id_tso 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->post("kd_distributor");
		
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas($id_tso, $kd_distributor);
			
		echo json_encode($hasil);
	}

	public function filterdata_GSM(){
		$id_user 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->post("kd_distributor");
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_GSM($id_user, $kd_distributor);
			
		echo json_encode($hasil);
	}
	public function filterdata_SPC(){
		$id_user 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->post("kd_distributor");
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_SPC($id_user, $kd_distributor);
			
		echo json_encode($hasil);
	}
	
	public function filterdataasm(){
		$id_asm 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->post("kd_distributor");
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_asm($id_asm,$kd_distributor);
			
		echo json_encode($hasil);
	}
	
	public function filterdatarsm(){
		$id_rsm 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->post("kd_distributor");
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_rsm($id_rsm,$kd_distributor);
			
		echo json_encode($hasil);
	}
	
	public function filterdataadmin(){
		$id_admin		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->post("kd_distributor");
		$region 		= $this->input->post("region");
		$provinsi 		= $this->input->post("provinsi");
	
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_admin($id_admin,$kd_distributor, $region, $provinsi);
			
		echo json_encode($hasil);
	}
	
	public function filterdatadis(){
		$id_dis 		= $this->session->userdata('user_id');
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_dis($id_dis);
			
		echo json_encode($hasil);
	}
	public function toExce_GSM(){
		$id_user 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->get("id");
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_GSM($id_user, $kd_distributor);
		$this->toExcel($hasil);
	}
	
	public function toExce_SPC(){
		$id_user 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->get("id");
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_SPC($id_user, $kd_distributor);
		$this->toExcel($hasil);
	}
	
	public function toExcel_SSM(){
		$id_user 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->get("id");
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_rsm($id_user, $kd_distributor);
		
		$this->toExcel($hasil);
	}
	
	public function toExce_SM(){
		$id_user 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->get("id");
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_asm($id_user, $kd_distributor);
		
		$this->toExcel($hasil);
	}
	public function toExce_SO(){
		$id_user 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->get("id");
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas($id_user, $kd_distributor);
		
		$this->toExcel($hasil);
	}
	public function toExce_DIS(){
		$id_dis 		= $this->session->userdata('user_id');
			
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_dis($id_dis);
		
		$this->toExcel($hasil);
	}
	
	public function toExce_ADMIN(){
		$id_user 		= $this->session->userdata('user_id');
		$kd_distributor = $this->input->get("id");
		$region 		= $this->input->get("region");
		$provinsi 		= $this->input->get("provinsi");
	
		$hasil			= $this->Kapasitas_toko_model->get_data_filter_kapasitas_admin($id_admin,$kd_distributor, $region, $provinsi);
		
		$this->toExcel($hasil);
	}
	
	public function toExcel($ListKapasitas){
			
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
			
			$filename = "Rekap_Data_Kapasitas_Toko";
            $objPHPExcel->getActiveSheet(0)->setTitle("DATA KAPASITAS TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA KAPASITAS TOKO");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:I2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID CUSTOMER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "ALAMAT");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "PROVINSI");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "DISTRIK");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "AREA");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "KECAMATAN");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "KAPASITAS/ZAK");

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

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

            
			$no = 1;
            $numRow = 4;
            foreach ($ListKapasitas as $list_KapasitasKey => $list_KapasitasValue) {
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_KapasitasValue['ID_CUSTOMER']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_KapasitasValue['NAMA_TOKO']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_KapasitasValue['ALAMAT']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_KapasitasValue['NAMA_DISTRIBUTOR']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_KapasitasValue['NAMA_PROVINSI']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_KapasitasValue['NAMA_DISTRIK']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_KapasitasValue['NAMA_AREA']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_KapasitasValue['NAMA_KECAMATAN']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_KapasitasValue['KAPASITAS_ZAK']));

                $objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$numRow)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$numRow)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$numRow)->applyFromArray($style_row);

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