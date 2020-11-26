<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Customer_sync extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Customer_sync_model');
		
		set_time_limit(0);
                ini_set('memory_limit', '512M');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['pilihan_distributor'] = $this->make_option_distributor($this->Customer_sync_model->get_data_distributor());
		
		$this->template->display('customer_sync', $data);
		
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
		
		$hasil = $this->Customer_sync_model->get_data_customer_distributor($distributor);
		
		$isi_table_customer = $this->make_table_data_customer_distributor($hasil);
		
		echo json_encode(array('notify' => 1, 'html' => $isi_table_customer));
		
	}
	private function make_table_data_customer_distributor($hasil){
		
		$isi ='';
		$no =1;
		foreach($hasil as $h){

			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h['KODE_CUSTOMER'].'</td>';
			$isi .= '<td>'.$h['NAMA_TOKO'].'</td>';
			$isi .= '<td>'.$h['ALAMAT'].'</td>';
			$isi .= '<td>'.$h['TELP_TOKO'].'</td>';
			$isi .= '<td>'.$h['NAMA_PEMILIK'].'</td>';
			$isi .= '<td>'.$h['NOKTP_PEMILIK'].'</td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		
		return $isi;
	}
	
	public function Ajax_sync_customer_distributor(){
		$distributor = '0000000106';//$this->input->post("distributor");
		
		$hasil_crm 	= $this->Customer_sync_model->get_data_customer_distributor_NOT_IN($distributor);
		
		$this->Customer_sync_model->get_data_customer_bk($distributor, $hasil_crm);
		
		print_r($hasil_crm);
	}
	
	public function Scedulller_customer_dist(){
		
		$hasil_crm = $this->Customer_sync_model->get_data_distributor_IN();

		$this->Customer_sync_model->get_data_customer_bk_all($hasil_crm);
	}

	public function Sceduller_dua(){
		$hasil = $this->Customer_sync_model->get_customer_bk();
		$this->Customer_sync_model->insert_data($hasil);
	}

	public function sync_backdate(){
		$inserted = 0;
		$updated = 0;

		$tgl = date('Y-m-d', strtotime(' -1 day'));
		$dataToko = $this->Customer_sync_model->get_customer_bk($tgl);
		if($dataToko){
			foreach ($dataToko as $dataKey => $dataValue) {
				$checkCustomer = $this->Customer_sync_model->checkCustomer($dataValue['ID_CUSTOMER']);
				if($checkCustomer){
					$this->Customer_sync_model->update_data($dataValue);
					$updated++;
				} else {
					$this->Customer_sync_model->insert_new_data($dataValue);
					$inserted++;
				}
			}
		}

		$data = array(
			"SYNC_VALUE" => "",
			"SYNC_INSERTED" => $inserted,
			"SYNC_UPDATED" => $updated
		);

		$insertLog = $this->Customer_sync_model->insertLog($data, $tgl);

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

		$dataToko = $this->Customer_sync_model->get_customer_bk($tgl);
		if($dataToko){
			foreach ($dataToko as $dataKey => $dataValue) {
				$checkCustomer = $this->Customer_sync_model->checkCustomer($dataValue['ID_CUSTOMER']);
				if($checkCustomer){
					$this->Customer_sync_model->update_data($dataValue);
					$updated++;
				} else {
					$this->Customer_sync_model->insert_new_data($dataValue);
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

		$insertLog = $this->Customer_sync_model->insertLog($data, $tgl);

		echo json_encode(array("status" => "success", "data" => $dataToko, "inserted" => $inserted, "updated" => $updated));
	}
	
}

?>