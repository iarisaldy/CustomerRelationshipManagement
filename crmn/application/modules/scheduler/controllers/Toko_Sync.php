<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Toko_Sync extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Sync_model');
		
		set_time_limit(0);
                ini_set('memory_limit', '512M');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$id_user = $this->session->userdata('user_id');
		$data['pilihan_distributor'] = $this->make_option_distributor($this->Sync_model->User_distributor($id_user));
		
		$this->template->display('Sync_view', $data);	
    }
	
	public function admin(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['pilihan_distributor'] = $this->make_option_distributor($this->Sync_model->get_data_distributor());
		
		$this->template->display('Sync_Admin', $data);	
    }
	
	private function make_option_distributor($data){
		
		$isi ='<option value="">Pilih Distributor</option>';
		
		foreach($data as $d){
			$isi .='<option value="'.$d['KODE_DISTRIBUTOR'].'">'.$d['KODE_DISTRIBUTOR'].' - '.$d['NAMA_DISTRIBUTOR'].'</option>';
		}
		
		return $isi;
	}
	public function Ajax_tampil_data_customer_toko(){ 
		
		$distributor = $this->input->post("distributor");
		$id_user = $this->session->userdata('user_id');
		$datadistributor = $this->Sync_model->User_distributor($id_user);
		$dis_tso = '';
		$n=1;
		foreach($datadistributor as $d){
			if(count($datadistributor)>$n){
				$dis_tso .= "'". $d['KODE_DISTRIBUTOR']."',";
			}
			else {
				$dis_tso .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;
		}
		
		$hasil = $this->Sync_model->get_data_customer_distributor($distributor,$dis_tso, $id_user);
		
		echo json_encode($hasil);
		
	}
	
	public function Ajax_tampil_data_customer_toko_admin(){ 
		
		$distributor = $this->input->post("distributor");
		$hasil = $this->Sync_model->get_data_customer_distributor_all($distributor);
		
		echo json_encode($hasil);
		
	}
	
	public function Ajax_sync_customer_distributor(){
		$distributor = $this->input->post("distributor");
		
		$hasil_crm 	= $this->Sync_model->get_data_customer_distributor_NOT_IN($distributor);
		
		$this->Sync_model->get_data_customer_bk($distributor);
	}
	
	public function Scedulller_customer_dist(){
		
		$hasil_crm = $this->Sync_model->get_data_distributor_IN();

		$this->Sync_model->get_data_customer_bk_all($hasil_crm);
	}

	public function Sceduller_dua(){
		$hasil = $this->Sync_model->get_customer_bk();
		$this->Sync_model->insert_data($hasil);
	}

	public function sync_backdate(){
		$inserted = 0;
		$updated = 0;

		$tgl = date('Y-m-d', strtotime(' -1 day'));
		$dataToko = $this->Sync_model->get_customer_bk($tgl);
		if($dataToko){
			foreach ($dataToko as $dataKey => $dataValue) {
				$checkCustomer = $this->Sync_model->checkCustomer($dataValue['ID_CUSTOMER']);
				if($checkCustomer){
					$this->Sync_model->update_data($dataValue);
					$updated++;
				} else {
					$this->Sync_model->insert_new_data($dataValue);
					$inserted++;
				}
			}
		}

		$data = array(
			"SYNC_VALUE" => "",
			"SYNC_INSERTED" => $inserted,
			"SYNC_UPDATED" => $updated
		);

		$insertLog = $this->Sync_model->insertLog($data, $tgl);

		echo json_encode(array("status" => "success", "data" => $dataToko, "inserted" => $inserted, "updated" => $updated));

	}

	public function Sync_harian($tgl = null){
		$inserted = 0;
		$updated = 0;
		if(isset($tgl)){
			$tgl = $tgl;
		} else {
			$tgl = date('Y-m-d');
		}

		$dataToko = $this->Sync_model->get_customer_bk($tgl);
		if($dataToko){
			foreach ($dataToko as $dataKey => $dataValue) {
				$checkCustomer = $this->Sync_model->checkCustomer($dataValue['ID_CUSTOMER']);
				if($checkCustomer){
					$this->Sync_model->update_data($dataValue);
					$updated++;
				} else {
					$this->Sync_model->insert_new_data($dataValue);
					$inserted++;
				}
			}
		} else {
			exit();
		}

		$data = array(
			"SYNC_VALUE" => "",
			"SYNC_INSERTED" => $inserted,
			"SYNC_UPDATED" => $updated
		);

		$insertLog = $this->Sync_model->insertLog($data, $tgl);

		echo json_encode(array("status" => "success", "data" => $dataToko, "inserted" => $inserted, "updated" => $updated));
	}
	
	public function Ajax_Delete_Mark(){	
	
		$distributor = $this->input->post("distributor");	
		$this->Sync_model->hapus_data($distributor);
	}
	
	public function toExcel(){
			$distributor = $this->input->get("distributor");

			$ListSales= $this->Sync_model->get_data_customer_distributor_all($distributor);
				
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
			
			$filename = "Rekap_Data_Toko";
            $objPHPExcel->getActiveSheet(0)->setTitle("DATA TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA TOKO");
            $objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "ID CUSTOMER");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "REGION");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "TELP TOKO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA PEMILIK");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "TELP PEMILIK");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "PROVINSI");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "AREA");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "DISTRIK");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "ALAMAT");

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
						
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_SalesValue['KODE_CUSTOMER']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_SalesValue['NAMA_TOKO']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_SalesValue['NEW_REGION']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_SalesValue['TELP_TOKO']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_SalesValue['NAMA_PEMILIK']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_SalesValue['TELP_PEMILIK']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_SalesValue['NAMA_PROVINSI']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_SalesValue['NAMA_AREA']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_SalesValue['NAMA_DISTRIK']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_SalesValue['ALAMAT']));

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
	
}

?>