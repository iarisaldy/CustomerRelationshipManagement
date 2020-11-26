<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Report_Sellin extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Report_sellin_model');
		
		set_time_limit(0);
        ini_set('memory_limit', '512M');
    }
    public function SO(){
    	$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		
		$this->template->display('sell_in_so', $data);
    }
    public function REV_SO(){
    	$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		
		$this->template->display('rev_sell_in_so', $data);
    }
    public function SM(){
    	$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		
		$this->template->display('sell_in_sm', $data);
    }
    public function REV_SM(){
    	$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		
		$this->template->display('rev_sell_in_sm', $data);
    }
    public function SSM(){
    	$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		
		$this->template->display('sell_in_ssm', $data);
    }
    public function REV_SSM(){
    	$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		
		$this->template->display('rev_sell_in_ssm', $data);
    }
    public function GSM(){
    	$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		
		$this->template->display('sell_in_gsm', $data);
    }
    public function REV_GSM(){
    	$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		
		$this->template->display('rev_sell_in_gsm', $data);
    }
    public function SPC(){
    	$data = array("title"=>"Dashboard CRM Administrator");
    	$id_user = $this->session->userdata('user_id');
		$data['list_region'] = $this->Report_sellin_model->Get_region_SPC($id_user);
		
		$this->template->display('sell_in_spc', $data);
    }
    public function REV_SPC(){
    	$data = array("title"=>"Dashboard CRM Administrator");
    	$id_user = $this->session->userdata('user_id');
		$data['list_region'] = $this->Report_sellin_model->Get_region_SPC($id_user);
		
		$this->template->display('rev_sell_in_spc', $data);
    }
	public function DIS(){
    	$data = array("title"=>"Dashboard CRM Administrator");
    	$id_user = $this->session->userdata('user_id');
		
		$this->template->display('sell_in_dis', $data);
    }
    public function REV_DIS(){
    	$data = array("title"=>"Dashboard CRM Administrator");
    	$id_user = $this->session->userdata('user_id');
		
		$this->template->display('rev_sell_in_dis', $data);
    }

    public function index(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		
		$this->template->display('Report_sellin_admin', $data);
    }
	
	public function Reveneu(){ 
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['list_region'] = $this->Report_sellin_model->Get_region_all();
		
		$this->template->display('Report_sellin_reveneu', $data);
    }
	
	public function ListProvinsi(){
        $id_region    = $this->input->post('id_region');
		
        $data = $this->Report_sellin_model->Get_provinsi_all($id_region);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	public function ListDistributor(){
        $id_provinsi    = $this->input->post('id_provinsi');
		
        $data = $this->Report_sellin_model->Get_Dis_all($id_provinsi);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	public function Get_data_sell_in_SO(){
		//print_r($_POST);
		$mulai 			= $this->input->post("MULAI");
		$SELESAI 		= $this->input->post("SELESAI");
		$id_dis			= $this->input->post("distributor");
		$provinsi		= $this->input->post("provinsi");
		$region			= $this->input->post("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SO');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SO');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		

		echo json_encode($hasil);
	}
	public function Get_data_sell_in_SM(){
		//print_r($_POST);
		$mulai 			= $this->input->post("MULAI");
		$SELESAI 		= $this->input->post("SELESAI");
		$id_dis			= $this->input->post("distributor");
		$provinsi		= $this->input->post("provinsi");
		$region			= $this->input->post("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SM');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SM');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		echo json_encode($hasil);
	}
	public function Get_data_sell_in_SSM(){
		//print_r($_POST);
		$mulai 			= $this->input->post("MULAI");
		$SELESAI 		= $this->input->post("SELESAI");
		$id_dis			= $this->input->post("distributor");
		$provinsi		= $this->input->post("provinsi");
		$region			= $this->input->post("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SSM');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SSM');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		echo json_encode($hasil);
	}
	public function Get_data_sell_in_GSM(){
		//print_r($_POST);
		$mulai 			= $this->input->post("MULAI");
		$SELESAI 		= $this->input->post("SELESAI");
		$id_dis			= $this->input->post("distributor");
		$provinsi		= $this->input->post("provinsi");
		$region			= $this->input->post("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'GSM');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'GSM');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		echo json_encode($hasil);
	}
	public function Get_data_sell_in_SPC(){
		//print_r($_POST);
		$mulai 			= $this->input->post("MULAI");
		$SELESAI 		= $this->input->post("SELESAI");
		$id_dis			= $this->input->post("distributor");
		$provinsi		= $this->input->post("provinsi");
		$region			= $this->input->post("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SPC');
		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SPC');
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		echo json_encode($hasil);
	}
	public function Get_data_sell_in_DIS(){
		//print_r($_POST);
		$mulai 			= $this->input->post("MULAI");
		$SELESAI 		= $this->input->post("SELESAI");

		$id_user = $this->session->userdata('user_id');
		
		$dt_msc = $this->Report_sellin_model->Get_data_msc_DIS($mulai, $SELESAI, $id_user);
		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so_DIS($id_user);
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		echo json_encode($hasil);
	}

	private function Make_array_hasil($dt_msc, $dt_crm){
		$hasil = array();
		foreach ($dt_msc as $d) {
			foreach ($dt_crm as $c) {
				if($d['ID_DISTRIK']==$c['ID_DISTRIK']){
					array_push($hasil, 
						array 	(
								'TAHUN' 			=> $d['TAHUN'],
								'BULAN' 			=> $d['BULAN'],
								'TANGGAL' 			=> $d['TANGGAL'],
								'KODE_DISTRIBUTOR' 	=> $d['KODE_DISTRIBUTOR'],
								'NM_DISTRIBUTOR' 	=> $d['NM_DISTRIBUTOR'],
								'KODE_GUDANG' 		=> $d['KODE_GUDANG'],
								'REGION' 			=> $d['REGION'],
								'NM_PROV' 			=> $d['NM_PROV'],
								'NM_KOTA' 			=> $d['NM_KOTA'],
								'TIPE_ZAK' 			=> $d['TIPE_ZAK'],
								'ITEM_NO' 			=> $d['ITEM_NO'],
								'NM_PRODUK' 		=> $d['NM_PRODUK'],
								'JUMLAH' 			=> $d['JUMLAH'],
								'TOTAL_SELLIN' 		=> number_format($d['TOTAL_SELLIN']),//ditambah data crm.

								'NAMA_SO' 			=> $c['NAMA_SO'],
								'NAMA_SM' 			=> $c['NAMA_SM'],
								'NAMA_SSM' 			=> $c['NAMA_SSM'],
								'NAMA_GSM' 			=> $c['NAMA_GSM'],
								
								)
					);
				}
			}
		}

		return $hasil;
	}
	public function getdata(){
		$tanggal		= $this->input->post("tanggal");
		$bulan			= $this->input->post("bulan");
		$tahun			= $this->input->post("tahun");
		$id_dis			= $this->input->post("distributor");
		$provinsi		= $this->input->post("provinsi");
		$region			= $this->input->post("region");
		
		$datacrm		 = $this->Report_sellin_model->get_data_crm($id_dis);
		
		$datadistributor = $this->Report_sellin_model->get_data_distributor();
		$fild = '';
		$n=1;
		foreach($datadistributor as $d){
			
			if(count($datadistributor)>$n){
				$fild .= "'". $d['KODE_DISTRIBUTOR']."',";
			}
			else {
				$fild .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;
				
		}
		
		$datacsm = $this->Report_sellin_model->get_data_scm($tanggal, $bulan, $tahun, $fild, $region, $provinsi);
		
		$hasil = array();
		
		foreach($datacrm as $c){
			foreach($datacsm as $d){
				$disc = $c['KODE_DISTRIBUTOR'];
				$provinsi = $c['ID_PROVINSI'];
				$distrik = $c['ID_DISTRIK'];
				if($disc==$d['KODE_DISTRIBUTOR']){
					if($provinsi==$d['KODE_PROVINSI']){
						if($distrik==$d['ID_DISTRIK']){
							array_push($hasil, 
								array 	(
										//Data SCM
										'KODE_DISTRIBUTOR' => $d['KODE_DISTRIBUTOR'],
										'KODE_GUDANG' => $d['KODE_GUDANG'],
										'KODE_PROVINSI' => $d['KODE_PROVINSI'],
										'NM_KOTA' => $d['NM_KOTA'],
										'TAHUN' => $d['TAHUN'],
										'BULAN' => $d['BULAN'],
										'TANGGAL' => $d['TANGGAL'],
										'TIPE_ZAK' => $d['TIPE_ZAK'],
										'REGION' => $d['REGION'],
										'ID_DISTRIK' => $d['ID_DISTRIK'],
										'JUMLAH' => number_format($d['JUMLAH']),
										'TOTAL_SELLIN' => number_format($d['TOTAL_SELLIN']),
										'ITEM_NO' => $d['ITEM_NO'],
										'NM_PRODUK' => $d['NM_PRODUK'],
										
										//Data CRM
										'NAMA_DISTRIBUTOR' => $c['NAMA_DISTRIBUTOR'],
										'NAMA_PROVINSI' => $c['NAMA_PROVINSI'],
										'NAMA_SO' => $c['NAMA_SO'],
										'NAMA_SM' => $c['NAMA_SM'],
										'NAMA_SSM' => $c['NAMA_SSM'],
										'NAMA_GSM' => $c['NAMA_GSM'],
										
								)
							);
						}
					}
				}
			}
			
		}
		echo json_encode($hasil);
	}
	
	public function toExcel_so(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SO');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SO');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		$this->print_Excel($hasil);

	}
	public function toExcel_so_rev(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SO');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SO');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		$this->print_Excel_rev($hasil);

	}
	public function toExcel_sm(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SM');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SM');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		$this->print_Excel($hasil);

	}
	public function toExcel_sm_rev(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SM');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SM');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		$this->print_Excel_rev($hasil);

	}
	public function toExcel_ssm(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SSM');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SSM');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		$this->print_Excel($hasil);

	}
	public function toExcel_ssm_rev(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SSM');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SSM');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		$this->print_Excel($hasil);

	}
	public function toExcel_gsm(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'GSM');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'GSM');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		$this->print_Excel_rev($hasil);

	}
	public function toExcel_gsm_rev(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'GSM');

		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'GSM');
		
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);

		$this->print_Excel_rev($hasil);

	}
	public function toExcel_SPC(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SPC');
		//exit;
		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SPC');
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);
		$this->print_Excel($hasil);
		
	}
	public function toExcel_SPC_rev(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");

		$id_user = $this->session->userdata('user_id');

		$dt_msc = $this->Report_sellin_model->Get_data_msc($mulai, $SELESAI, $id_user, $region, $provinsi, $id_dis, 'SPC');
		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so($id_user, 'SPC');
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);
		$this->print_Excel_rev($hasil);
	}
	public function toExcel_DIS(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");

		$id_user = $this->session->userdata('user_id');
		
		$dt_msc = $this->Report_sellin_model->Get_data_msc_DIS($mulai, $SELESAI, $id_user);
		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so_DIS($id_user);
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);
		$this->print_Excel($hasil);
		
	}
	public function toExcel_DIS_REV(){
		$mulai 			= $this->input->get("MULAI");
		$SELESAI 		= $this->input->get("SELESAI");

		$id_user = $this->session->userdata('user_id');
		
		$dt_msc = $this->Report_sellin_model->Get_data_msc_DIS($mulai, $SELESAI, $id_user);
		$dt_crm = $this->Report_sellin_model->Get_data_gsm_so_DIS($id_user);
		$hasil = $this->Make_array_hasil($dt_msc, $dt_crm);
		$this->print_Excel_rev($hasil);
	}
	
	public function print_Excel($hasil){
		
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Sellin');
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
		
		$filename = "Rekap_Data_Sellin";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA SELLIN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA SELLIN");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:O2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "BULAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "TAHUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "KODE GUDANG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "KOTA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "TIPE ZAK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "KD_PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "NM PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "VOLUME");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "SO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "SM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "SSM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "GSM");

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VolumeKey => $list_ValumeValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_ValumeValue['TANGGAL']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_ValumeValue['BULAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_ValumeValue['TAHUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_ValumeValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_ValumeValue['KODE_GUDANG']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_ValumeValue['NM_PROV']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_ValumeValue['NM_KOTA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_ValumeValue['TIPE_ZAK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_ValumeValue['ITEM_NO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_ValumeValue['NM_PRODUK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_ValumeValue['JUMLAH']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_ValumeValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_ValumeValue['NAMA_SM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, strtoupper($list_ValumeValue['NAMA_SSM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, strtoupper($list_ValumeValue['NAMA_GSM']));

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
	public function print_Excel_rev($hasil){
		
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Sellin');
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
		
		$filename = "Rekap_Data_Sellin";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA SELLIN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA SELLIN");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:O2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "BULAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "TAHUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "KODE GUDANG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "KOTA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "TIPE ZAK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "REVENUE");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "SO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "SM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "SSM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "GSM");

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
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_ValumeValue['TANGGAL']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_ValumeValue['BULAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_ValumeValue['TAHUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_ValumeValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_ValumeValue['NM_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_ValumeValue['KODE_GUDANG']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_ValumeValue['NM_PROV']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_ValumeValue['NM_KOTA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_ValumeValue['TIPE_ZAK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_ValumeValue['TOTAL_SELLIN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_ValumeValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_ValumeValue['NAMA_SM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_ValumeValue['NAMA_SSM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_ValumeValue['NAMA_GSM']));

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
	
	public function toExcel_ADMIN(){
		
		$tanggal		= $this->input->get("tanggal");
		$bulan			= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");
		
		$datacrm		 = $this->Report_sellin_model->get_data_crm($id_dis);
		
		$datadistributor = $this->Report_sellin_model->get_data_distributor();
		$fild = '';
		$n=1;
		foreach($datadistributor as $d){
			
			if(count($datadistributor)>$n){
				$fild .= "'". $d['KODE_DISTRIBUTOR']."',";
			}
			else {
				$fild .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;
				
		}
		
		$datacsm = $this->Report_sellin_model->get_data_scm($tanggal, $bulan, $tahun, $fild, $region, $provinsi);
		
		
		$hasil = array();
		
		foreach($datacrm as $c){
			foreach($datacsm as $d){
				$disc = $c['KODE_DISTRIBUTOR'];
				$provinsi = $c['ID_PROVINSI'];
				$distrik = $c['ID_DISTRIK'];
				if($disc==$d['KODE_DISTRIBUTOR']){
					if($provinsi==$d['KODE_PROVINSI']){
						if($distrik==$d['ID_DISTRIK']){
							array_push($hasil, 
								array 	(
										//Data SCM
										'KODE_DISTRIBUTOR' => $d['KODE_DISTRIBUTOR'],
										'KODE_GUDANG' => $d['KODE_GUDANG'],
										'KODE_PROVINSI' => $d['KODE_PROVINSI'],
										'NM_KOTA' => $d['NM_KOTA'],
										'TAHUN' => $d['TAHUN'],
										'BULAN' => $d['BULAN'],
										'TANGGAL' => $d['TANGGAL'],
										'TIPE_ZAK' => $d['TIPE_ZAK'],
										'REGION' => $d['REGION'],
										'ID_DISTRIK' => $d['ID_DISTRIK'],
										'JUMLAH' => number_format($d['JUMLAH']),
										'TOTAL_SELLIN' => number_format($d['TOTAL_SELLIN']),
										'ITEM_NO' => $d['ITEM_NO'],
										'NM_PRODUK' => $d['NM_PRODUK'],
										//Data CRM
										'NAMA_DISTRIBUTOR' => $c['NAMA_DISTRIBUTOR'],
										'NAMA_PROVINSI' => $c['NAMA_PROVINSI'],
										'NAMA_SO' => $c['NAMA_SO'],
										'NAMA_SM' => $c['NAMA_SM'],
										'NAMA_SSM' => $c['NAMA_SSM'],
										'NAMA_GSM' => $c['NAMA_GSM'],
										
								)
							);
						}
					}
				}
			}
			
		}
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Sellin');
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
		
		$filename = "Rekap_Data_Sellin";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA SELLIN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA SELLIN");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:O2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "BULAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "TAHUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "KODE GUDANG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "KOTA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "TIPE ZAK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "KD_PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "NM PRODUK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "VOLUME");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "SO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "SM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "SSM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "GSM");
		

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VolumeKey => $list_ValumeValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_ValumeValue['TANGGAL']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_ValumeValue['BULAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_ValumeValue['TAHUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_ValumeValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_ValumeValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_ValumeValue['KODE_GUDANG']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_ValumeValue['NAMA_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_ValumeValue['NM_KOTA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_ValumeValue['TIPE_ZAK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_ValumeValue['ITEM_NO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_ValumeValue['NM_PRODUK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_ValumeValue['JUMLAH']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_ValumeValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_ValumeValue['NAMA_SM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, strtoupper($list_ValumeValue['NAMA_SSM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numRow, strtoupper($list_ValumeValue['NAMA_GSM']));

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
	
	public function toExcelRevenue(){
		
		$tanggal		= $this->input->get("tanggal");
		$bulan			= $this->input->get("bulan");
		$tahun			= $this->input->get("tahun");
		$id_dis			= $this->input->get("distributor");
		$provinsi		= $this->input->get("provinsi");
		$region			= $this->input->get("region");
		
		$datacrm		 = $this->Report_sellin_model->get_data_crm($id_dis);
		
		$datadistributor = $this->Report_sellin_model->get_data_distributor();
		$fild = '';
		$n=1;
		foreach($datadistributor as $d){
			
			if(count($datadistributor)>$n){
				$fild .= "'". $d['KODE_DISTRIBUTOR']."',";
			}
			else {
				$fild .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;
				
		}
		
		$datacsm = $this->Report_sellin_model->get_data_scm($tanggal, $bulan, $tahun, $fild, $region, $provinsi);
		
		
		$hasil = array();
		
		foreach($datacrm as $c){
			foreach($datacsm as $d){
				$disc = $c['KODE_DISTRIBUTOR'];
				$provinsi = $c['ID_PROVINSI'];
				$distrik = $c['ID_DISTRIK'];
				if($disc==$d['KODE_DISTRIBUTOR']){
					if($provinsi==$d['KODE_PROVINSI']){
						if($distrik==$d['ID_DISTRIK']){
							array_push($hasil, 
								array 	(
										//Data SCM
										'KODE_DISTRIBUTOR' => $d['KODE_DISTRIBUTOR'],
										'KODE_GUDANG' => $d['KODE_GUDANG'],
										'KODE_PROVINSI' => $d['KODE_PROVINSI'],
										'NM_KOTA' => $d['NM_KOTA'],
										'TAHUN' => $d['TAHUN'],
										'BULAN' => $d['BULAN'],
										'TANGGAL' => $d['TANGGAL'],
										'TIPE_ZAK' => $d['TIPE_ZAK'],
										'REGION' => $d['REGION'],
										'ID_DISTRIK' => $d['ID_DISTRIK'],
										'JUMLAH' => number_format($d['JUMLAH']),
										'TOTAL_SELLIN' => number_format($d['TOTAL_SELLIN']),
										
										//Data CRM
										'NAMA_DISTRIBUTOR' => $c['NAMA_DISTRIBUTOR'],
										'NAMA_PROVINSI' => $c['NAMA_PROVINSI'],
										'NAMA_SO' => $c['NAMA_SO'],
										'NAMA_SM' => $c['NAMA_SM'],
										'NAMA_SSM' => $c['NAMA_SSM'],
										'NAMA_GSM' => $c['NAMA_GSM'],
										
								)
							);
						}
					}
				}
			}
			
		}
		
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('Admin-CRM-SemenIndonesia')->setTitle('Rekap Data Sellin');
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
		
		$filename = "Rekap_Data_Sellin";
		$objPHPExcel->getActiveSheet(0)->setTitle("DATA SELLIN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA SELLIN");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:O2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "TANGGAL");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "BULAN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "TAHUN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "KODE DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA DISTRIBUTOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "KODE GUDANG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "PROVINSI");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "KOTA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "TIPE ZAK");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "JUMLAH");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "TOTAL SELLIN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "SO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "SM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "SSM");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "GSM");

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

		
		$no = 1;
		$numRow = 4;
		foreach ($hasil as $list_VolumeKey => $list_ValumeValue) {
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, strtoupper($list_ValumeValue['TANGGAL']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numRow, strtoupper($list_ValumeValue['BULAN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numRow, strtoupper($list_ValumeValue['TAHUN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numRow, strtoupper($list_ValumeValue['KODE_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numRow, strtoupper($list_ValumeValue['NAMA_DISTRIBUTOR']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numRow, strtoupper($list_ValumeValue['KODE_GUDANG']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numRow, strtoupper($list_ValumeValue['NAMA_PROVINSI']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numRow, strtoupper($list_ValumeValue['NM_KOTA']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numRow, strtoupper($list_ValumeValue['TIPE_ZAK']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numRow, strtoupper($list_ValumeValue['JUMLAH']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numRow, strtoupper($list_ValumeValue['TOTAL_SELLIN']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numRow, strtoupper($list_ValumeValue['NAMA_SO']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numRow, strtoupper($list_ValumeValue['NAMA_SM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numRow, strtoupper($list_ValumeValue['NAMA_SSM']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numRow, strtoupper($list_ValumeValue['NAMA_GSM']));

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