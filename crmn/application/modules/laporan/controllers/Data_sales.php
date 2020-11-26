<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Data_sales extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Data_sales_model');
    }
	public function curl(){
		$email_api = urlencode("forcasupport@sisi.id");
		$passkey_api = urlencode("tcQdCz631gbprM54LcIP0zEl5");
		$no_hp_tujuan = urlencode('081358635810');
		$isi_pesan = urlencode("CRM SIG -  12345  Adalah Kode OTP untuk password anda. PENTING demi keamanan password anda jangan diserbakan ke orang lain");

		$url = "https://reguler.medansms.co.id/sms_api.php?action=kirim_sms&email=".$email_api."&passkey=".$passkey_api."&no_tujuan=".$no_hp_tujuan."&pesan=".$isi_pesan. "&json=1";
		$result = $this->SendAPI_SMS($url);
		print_r($result);

	}
	function SendAPI_SMS($url){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response  = curl_exec($ch);
			if(($html = curl_exec($ch)) === false)
			{
				echo 'Curl error: ' . curl_error($ch);
				die('111');
			}
			curl_close($ch);
			echo $html;
			curl_close($ch);
			
			return $response;
	}

	
    public function index(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Data_sales_model->Get_region_all();
		$this->template->display('Repot_data_salesAdmin', $data);
    }
	public function info(){
		echo phpinfo();
	}
	
		
	public function ListProvinsi(){
        $id_region    = $this->input->post('id_region');
		
        $data = $this->Data_sales_model->Get_provinsi_all($id_region);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	public function ListDistributor(){
        $id_provinsi    = $this->input->post('id_provinsi');
		
        $data = $this->Data_sales_model->Get_Dis_all($id_provinsi);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
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
	public function GSM(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Data_sales_model->GSM_dis($id_user);
		$data['list_rsm'] = $this->Data_sales_model->RSMlist($id_user);
		$this->template->display('Report_data_salesGSM', $data);
    }
	public function SPC(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
        $data['list_region'] = $this->Data_sales_model->Get_region_SPC($id_user);

		$this->template->display('Report_data_sales_spc', $data);
    }
	public function RSM(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Data_sales_model->RSM_dis($id_user);
		$data['list_asm'] = $this->Data_sales_model->listASM($id_user);
		$this->template->display('Repot_data_salesRSM', $data);
    }
	public function ASM(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Data_sales_model->ASM_dis($id_user);
		$data['list_tso'] = $this->Data_sales_model->User_TSO($id_user);
		$this->template->display('Repot_data_salesASM', $data);
    }
	public function TSO(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		
		$id_user = $this->session->userdata('user_id');
		$data['list_distributor'] = $this->Data_sales_model->User_distributor($id_user);
		//$data['list_sales'] = $this->Data_sales_model->User_SALES($id_user);
		$this->template->display('Repot_data_salesTSO', $data);
    }
	
	public function DIS(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['list_tso'] = $this->Data_sales_model->User_TSO($id_user);
		$data['list_asm'] = $this->Data_sales_model->listASM($id_user);
		$data['list_rsm'] = $this->Data_sales_model->RSMlist($id_user); 
		$this->template->display('Repot_data_salesDIS', $data);
    }
	
	public function ambildataall(){
		$id_dis = $this->input->post("id");
		$region = $this->input->post("region");
		$id_prov = $this->input->post("id_prov");
			
		$hasil= $this->Data_sales_model->get_data_admin($id_dis, $region, $id_prov);
		echo json_encode($hasil);
	}
	
	public function ambildatatso(){
		$id_dis = $this->input->post("id");
		$id_sales = $this->input->post("id_sales");
		$id_user = $this->session->userdata('user_id');
			
		$hasil= $this->Data_sales_model->get_data_tso($id_user, $id_dis, $id_sales);
		echo json_encode($hasil);
	}
	
	public function ambildataasm(){
		$id_dis = $this->input->post("id");
		$id_tso = $this->input->post("id_tso");
		$id_user = $this->session->userdata('user_id');
			
		$hasil= $this->Data_sales_model->get_data_asm($id_user, $id_dis, $id_tso);
		echo json_encode($hasil);
	}
	
	public function ambildatarsm(){
		$id_dis = $this->input->post("id");
		$id_user = $this->session->userdata('user_id');
			
		$hasil= $this->Data_sales_model->get_data_rsm($id_user , $id_dis);
		echo json_encode($hasil);
	}
	
	public function ambildatagsm(){
		$id_user = $this->session->userdata('user_id');
		$rsm = $this->input->post("rsm");
		$id_dis = $this->input->post("id_dis");
		
		$hasil= $this->Data_sales_model->get_data_gsm($id_user , $rsm , $id_dis);
		echo json_encode($hasil);
	}
    public function ambildataspc(){
        $id_user = $this->session->userdata('user_id');
        
        $hasil= $this->Data_sales_model->get_data_spc($id_user);
        echo json_encode($hasil);
    }
	
	public function ambildatadis(){
		$id_user = $this->session->userdata('user_id');
			
		$hasil= $this->Data_sales_model->get_data_dis($id_user);
		echo json_encode($hasil);
	}
	
	public function toExcel(){
			$id_dis = $this->input->get("id");
			$id_sales = $this->input->get("id_sales");
			$id_tso = $this->input->get("id_tso");
			$id_asm = $this->input->get("id_asm");
			$id_user = $this->session->userdata('user_id');
			$login = $this->session->userdata('id_jenis_user');

			if($login == '1012'){
				$ListSales= $this->Data_sales_model->get_data_tso($id_user, $id_dis, $id_sales);
			}else if($login == '1011'){
				$ListSales= $this->Data_sales_model->get_data_asm($id_user ,$id_dis, $id_tso);
			}else if($login == '1010'){
				$ListSales= $this->Data_sales_model->get_data_rsm($id_user ,$id_dis, $id_asm);
			}else{
				$ListSales= $this->Data_sales_model->get_data_dis($id_user);
			}
			
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
			
			$filename = "Rekap_Data_Sales";
            $objPHPExcel->getActiveSheet(0)->setTitle("DATA SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA SALES");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "SALES OFFICER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "SALES MANAJER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "SENIOR SALES MANAJER");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "REGION");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "PROVINSI");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "AREA");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "DISTRIK");

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

            
			$no = 1;
            $numRow = 4;
            foreach ($ListSales as $list_SalesKey => $list_SalesValue) {
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_SalesValue['ID_SALES']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_SalesValue['NAMA_SALES']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_SalesValue['NAMA_DISTRIBUTOR']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_SalesValue['NAMA_SO']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_SalesValue['NAMA_SM']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_SalesValue['NAMA_SSM']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_SalesValue['REGION_ID']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_SalesValue['NAMA_PROVINSI']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_SalesValue['NM_AREA']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_SalesValue['NM_DISTRIK']));

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
		
		public function toExcel_Admin(){
			$id_dis = $this->input->get("id");
			$region = $this->input->get("region");
			$id_prov = $this->input->get("id_prov");

			$ListSales= $this->Data_sales_model->get_data_admin($id_dis, $region, $id_prov);			
			
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
			
			$filename = "Rekap_Data_Sales";
            $objPHPExcel->getActiveSheet(0)->setTitle("DATA SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA SALES");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:L2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "USERNAME");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "REGION");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "PROVINSI");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "ID SO");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "NAMA SO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "NAMA SM");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "NAMA SSM");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "AREA");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "DISTRIK");

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
            
			$no = 1;
            $numRow = 4;
            foreach ($ListSales as $list_SalesKey => $list_SalesValue) {
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_SalesValue['ID_SALES']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_SalesValue['NAMA_SALES']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_SalesValue['USER_SALES']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_SalesValue['REGION_ID']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_SalesValue['NAMA_PROVINSI']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_SalesValue['NAMA_DISTRIBUTOR']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_SalesValue['ID_SO']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_SalesValue['NAMA_SO']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_SalesValue['NAMA_SM']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_SalesValue['NAMA_SSM']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_SalesValue['NM_AREA']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_SalesValue['NM_DISTRIK']));

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
		
		public function toExcel_GSM(){
			$id_user = $this->session->userdata('user_id');
			$rsm = $this->input->get("rsm");
			$id_dis = $this->input->get("id_dis");
			
			$ListSales= $this->Data_sales_model->get_data_gsm($id_user, $rsm , $id_dis);
			// print_r($ListSales);
			// EXIT;
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
			
			$filename = "Rekap_Data_Sales";
            $objPHPExcel->getActiveSheet(0)->setTitle("DATA SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA SALES");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "SALES OFFICER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "SALES MANAJER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "SENIOR SALES MANAJER");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "REGION");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "PROVINSI");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "AREA");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "DISTRIK");

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

            
			$no = 1;
            $numRow = 4;
            foreach ($ListSales as $list_SalesKey => $list_SalesValue) {
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_SalesValue['ID_SALES']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_SalesValue['NAMA_SALES']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_SalesValue['NAMA_DISTRIBUTOR']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_SalesValue['NAMA_SO']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_SalesValue['NAMA_SM']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_SalesValue['NAMA_SSM']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_SalesValue['REGION_ID']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_SalesValue['NAMA_PROVINSI']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_SalesValue['NM_AREA']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_SalesValue['NM_DISTRIK']));

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
            $objWriter->save('php://output');
		}
        public function toExcel_SPC(){
            $id_user = $this->session->userdata('user_id');
            
            $ListSales= $this->Data_sales_model->get_data_spc($id_user);
            // print_r($ListSales);
            // EXIT;
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
            
            $filename = "Rekap_Data_Sales";
            $objPHPExcel->getActiveSheet(0)->setTitle("DATA SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA SALES");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA SALES");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA DISTRIBUTOR");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "SALES OFFICER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "SALES MANAJER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "SENIOR SALES MANAJER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "REGION");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "PROVINSI");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "AREA");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "DISTRIK");

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

            
            $no = 1;
            $numRow = 4;
            foreach ($ListSales as $list_SalesKey => $list_SalesValue) {
                        
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_SalesValue['ID_SALES']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_SalesValue['NAMA_SALES']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_SalesValue['NAMA_DISTRIBUTOR']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_SalesValue['NAMA_SO']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_SalesValue['NAMA_SM']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_SalesValue['NAMA_SSM']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_SalesValue['REGION_ID']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_SalesValue['NAMA_PROVINSI']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_SalesValue['NM_AREA']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_SalesValue['NM_DISTRIK']));

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
            $objWriter->save('php://output');
        }

}
?> 