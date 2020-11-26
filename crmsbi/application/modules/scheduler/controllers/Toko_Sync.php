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
	
	private function make_option_distributor($data){
		
		$isi ='<option value=""></option>';
		foreach($data as $d){
			$isi .='<option value="'.$d['KODE_DISTRIBUTOR'].'">'.$d['KODE_DISTRIBUTOR'].' - '.$d['NAMA_DISTRIBUTOR'].'</option>';
		}
		
		return $isi;
	}
	public function Ajax_tampil_data_customer_toko(){
		
		$distributor = $this->input->post("distributor");		
		$hasil = $this->Sync_model->get_data_customer_distributor($distributor);
		
		echo json_encode($hasil);
		
	}
	
	public function Ajax_sync_customer_distributor(){
		//$distributor = '0000000106';
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
	
}

?>