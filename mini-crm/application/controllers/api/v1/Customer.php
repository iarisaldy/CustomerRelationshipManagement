<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Customer extends Auth {
	function __construct(){
		ini_set('memory_limit', '500M');
		parent::__construct();
		$this->validate();
		$this->load->model('Model_customer');
		$this->load->model('Model_area');
	}

	public function nonaktif_put(){
		$customer_id = $this->put('customer_id');
		$data = array("IS_DELETED" => "Y", "UPDATED_AT" => date('Y-m-d H:i:s'));

		$nonaktif = $this->Model_customer->nonaktif($data, $customer_id);
		if($nonaktif){
			$response = array("status" => "success", "data" => $customer_id);
		} else {
			$response = array("status" => "error", "message" => "Cant delete customer");
		}

		$this->print_api($response);
	}

	public function index_get($city = null, $limit = null, $start = null){
		$customer = $this->Model_customer->list_customer($city, $limit, $start);
		foreach ($customer['customer'] as $key => $value) {
			$data['CUSTOMER_ID'] = (int)$customer['customer'][$key]->CUSTOMER_ID;
			$data['KD_CUSTOMER'] = (int)$customer['customer'][$key]->KD_CUSTOMER;
			$data['NM_TOKO'] = $customer['customer'][$key]->NM_TOKO;
			$data['NO_TELP_TOKO'] = $customer['customer'][$key]->NO_TELP_TOKO;
			if($customer['customer'][$key]->KD_GROUP == "0"){
				$data['GROUP'] = null;
			} else {
				$data['GROUP']['GROUP_CUSTOMER_ID'] = $customer['customer'][$key]->KD_GROUP;
				$data['GROUP']['GROUP_CUSTOMER'] = $customer['customer'][$key]->GROUP_CUSTOMER;
			}

			if($customer['customer'][$key]->KD_DISTRIBUTOR == "0"){
				$data['DISTRIBUTOR'] = null;
			} else {
				$data['DISTRIBUTOR']['KD_DISTRIBUTOR'] = $customer['customer'][$key]->KD_DISTRIBUTOR;
				$data['DISTRIBUTOR']['NM_DISTRIBUTOR'] = $customer['customer'][$key]->NM_DISTRIBUTOR;
			}

			$data['KD_SAP'] = (int)$customer['customer'][$key]->KD_SAP;

			if($customer['customer'][$key]->STATUS_TOKO_ID == "0"){
				$data['STATUS_TOKO'] = null;
			} else {
				$data['STATUS_TOKO']['STATUS_TOKO_ID'] = (int)$customer['customer'][$key]->STATUS_TOKO_ID;
				$data['STATUS_TOKO']['STATUS_TOKO'] = $customer['customer'][$key]->STATUS_TOKO;
			}

			if($customer['customer'][$key]->TIPE_TOKO_ID == "0"){
				$data['TIPE_TOKO'] = null;
			} else {
				$data['TIPE_TOKO']['TIPE_TOKO_ID'] = (int)$customer['customer'][$key]->TIPE_TOKO_ID;
				$data['TIPE_TOKO']['TIPE_TOKO'] = $customer['customer'][$key]->TIPE_TOKO;
			}

			if($customer['customer'][$key]->KD_AREA == "0"){
				$data['AREA'] = null;
			} else {
				$data['AREA']['KD_AREA'] = (int)$customer['customer'][$key]->KD_AREA;
				$data['AREA']['NM_AREA'] = $customer['customer'][$key]->NM_AREA;
			}

			$data['PNT_STATUS'] = $customer['customer'][$key]->PNT_STATUS;

			if($customer['customer'][$key]->STATUS_ACTIVE_ID == "0"){
				$data['STATUS_ACTIVE'] = null;
			} else {
				$data['STATUS_ACTIVE']['STATUS_ACTIVE_ID'] = (int)$customer['customer'][$key]->STATUS_ACTIVE_ID;
				$data['STATUS_ACTIVE']['STATUS_ACTIVE_TOKO'] = $customer['customer'][$key]->STATUS_ACTIVE_TOKO;
			}

			$data['IS_VERIFIED'] = $customer['customer'][$key]->IS_VERIFIED;
			$data['IS_VERIFIED_BARCODE'] = $customer['customer'][$key]->IS_VERIFIED_BARCODE;
			$data['NM_OWNER'] = $customer['customer'][$key]->NM_OWNER;
			$data['NOKTP_OWNER'] = $customer['customer'][$key]->NOKTP_OWNER;
			$data['NO_HANDPHONE'] = $customer['customer'][$key]->NO_HANDPHONE;
			$data['EMAIL'] = $customer['customer'][$key]->EMAIL;

			if($customer['customer'][$key]->KD_REGION == "0"){
				$data['REGION'] = null;
			} else {
				$data['REGION']['KD_REGION'] = (int)$customer['customer'][$key]->KD_REGION;
				$data['REGION']['NM_REGION'] = $customer['customer'][$key]->NM_REGION;
			}

			if($customer['customer'][$key]->KD_CITY == "0"){
				$data['CITY'] = null;
			} else {
				$data['CITY']['KD_CITY'] = (int)$customer['customer'][$key]->KD_CITY;
				$data['CITY']['NM_CITY'] = $customer['customer'][$key]->NM_CITY;
			}

			if($customer['customer'][$key]->KD_DISTRICT == "0"){
				$data['DISTRICT'] = null;
			} else {
				$data['DISTRICT']['KD_DISTRICT'] = (int)$customer['customer'][$key]->KD_DISTRICT;
				$data['DISTRICT']['NM_DISTRICT'] = $customer['customer'][$key]->NM_DISTRICT;
			}

			$data['ALAMAT_TOKO'] = $customer['customer'][$key]->ALAMAT_TOKO;
			$data['COORDINATE']['LATITUDE'] = (float)$customer['customer'][$key]->LATITUDE;
			$data['COORDINATE']['LONGITUDE'] = (float)$customer['customer'][$key]->LONGITUDE;
			$data['GPS_ACCURACY'] = $customer['customer'][$key]->GPS_ACCURACY;
			$data['KETERANGAN'] = $customer['customer'][$key]->KETERANGAN;
			$data['UPDATED_AT'] = $customer['customer'][$key]->UPDATED_AT;
			$data['IS_DELETED'] = $customer['customer'][$key]->IS_DELETED;
			$json[] = $data;
		}
		$total = $this->Model_customer->list_customer($city);
		if($customer){
			$response = array("status" => "success", "total" => $total['total'], "data" => $json);
		} else {
			$response = array("status" => "error", "message" => "Data Tidak ada");
		}
		$this->print_api($response);
	}

	public function detail_get($customer_id){
		try {
			$detail_customer = $this->Model_customer->detail_customer($customer_id);
			$response = array("status" => "success", "data" => $detail_customer);
		} catch(Exception $e){
			$response = array("status" => "error", "message" => $e->getMessage());
		}

		$this->response($response);
	}

	public function list_customer_post($region = null, $city = null){
		$list = $this->Model_customer->get_datatables($region, $city);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $customers->CUSTOMER_ID;
			$row[] = $customers->NM_TOKO;
			$row[] = $customers->NM_OWNER;
			$row[] = $customers->NM_REGION;
			$row[] = $customers->NM_CITY;
			$row[] = $customers->NM_DISTRICT;
			$row[] = $customers->NM_AREA;
			$row[] = '<button class="btn btn-sm btn-danger" onclick="detail_customer('.$customers->CUSTOMER_ID.')" >DETAIL</button>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_customer->count_all(),
			"recordsFiltered" => $this->Model_customer->count_filtered(),
			"data" => $data,
		);
		$this->response($output);
	}

	public function add_post(){
		$local_id = $this->post('local_id');
		$nm_customer = strtoupper($this->post('nm_customer'));
		$no_telp_customer = strtoupper($this->post('no_telp_customer'));
		$status_toko = $this->post('status_toko');
		$group_customer = $this->post('group_customer');
		$tipe_toko = $this->post('tipe_toko');
		$pnt_status = $this->post('pnt_status');
		$status_active_toko = $this->post('status_active_toko');
		$nm_owner = strtoupper($this->post('nm_owner'));
		$noktp_owner = $this->post('noktp_owner');
		$no_handphone = $this->post('no_handphone');
		$email = strtoupper($this->post('email'));
		$kd_region = $this->post('kd_region');
		$kd_city = $this->post('kd_city');
		$kd_district = $this->post('kd_district');
		// $area = $this->post('area');
		$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$address = strtoupper($this->post('address'));
		$postal_code = $this->post('postal_code');

		$check_area = $this->Model_area->check_area($kd_city);
		$date = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
		$date = $date->format('Y-m-d H:i:s');

		$data_customer = array("NM_TOKO" => $nm_customer, "NO_TELP_TOKO" => $no_telp_customer, "STATUS_TOKO" => $status_toko, "TIPE_TOKO" => $tipe_toko, "PNT_STATUS" => $pnt_status, "STATUS_ACTIVE_TOKO" => $status_active_toko, "GROUP_CUSTOMER" => $group_customer, "UPDATED_AT" => $date, "IS_DELETED" => "N", "IS_VERIFIED" => "N", "IS_VERIFIED_BARCODE" => "N");
		$insert_customer = $this->Model_customer->insert_tabel('MASTER_CUSTOMER', $data_customer);
		if($insert_customer){
			$customer_id = $this->last_customer_id();
			$insert_owner = array("CUSTOMER_ID" => $customer_id->CUSTOMER_ID, "NM_OWNER" => $nm_owner, "NO_HANDPHONE" => $no_handphone, "EMAIL" => $email, "NOKTP_OWNER" => $noktp_owner);
			$insert_location = array("CUSTOMER_ID" => $customer_id->CUSTOMER_ID, "KD_REGION" => $kd_region, "KD_CITY" => $kd_city, "KD_DISTRICT" => $kd_district, "AREA" => $check_area->KD_AREA, "LATITUDE" => $latitude, "LONGITUDE" => $longitude, "ALAMAT_TOKO" => $address, "POSTAL_CODE" => $postal_code);
			$insert_owner = $this->Model_customer->insert_tabel('CUSTOMER_OWNER', $insert_owner);
			$insert_location = $this->Model_customer->insert_tabel('CUSTOMER_LOCATION', $insert_location);
			if($insert_owner && $insert_location){
				$data = array("customer_id" => $customer_id->CUSTOMER_ID, "local_id" => $local_id);
				$response = array("status" => "success", "data" => $data);
			} else {
				$response = array("status" => "error", "message" => "Gagal Menambahkan Customer Baru");
			}
		}

		$this->print_api($response);
	}

	public function last_customer_id(){
		$customer_id = $this->Model_customer->last_customer_id();
		if($customer_id){
			return $customer_id;
		} else {
			return false;
		}
	}

	public function customer_by_date_post(){
		$date = $this->post('date');
		$city = $this->post('city');
		$is_deleted = $this->post('is_deleted');
		$customer = $this->Model_customer->customer_by_date($date, $city, $is_deleted);
		$total = $this->Model_customer->customer_by_date($date, $city, $is_deleted);

		if($customer){
			foreach ($customer['customer'] as $key => $value) {
				$data['CUSTOMER_ID'] = (int)$customer['customer'][$key]->CUSTOMER_ID;
				$data['KD_CUSTOMER'] = (int)$customer['customer'][$key]->KD_CUSTOMER;
				$data['NM_TOKO'] = $customer['customer'][$key]->NM_TOKO;
				$data['NO_TELP_TOKO'] = $customer['customer'][$key]->NO_TELP_TOKO;
				if($customer['customer'][$key]->KD_GROUP == "0"){
					$data['GROUP'] = null;
				} else {
					$data['GROUP']['GROUP_CUSTOMER_ID'] = $customer['customer'][$key]->KD_GROUP;
					$data['GROUP']['GROUP_CUSTOMER'] = $customer['customer'][$key]->GROUP_CUSTOMER;
				}


				if($customer['customer'][$key]->KD_DISTRIBUTOR == "0"){
					$data['DISTRIBUTOR'] = null;
				} else {
					$data['DISTRIBUTOR']['KD_DISTRIBUTOR'] = $customer['customer'][$key]->KD_DISTRIBUTOR;
					$data['DISTRIBUTOR']['NM_DISTRIBUTOR'] = $customer['customer'][$key]->NM_DISTRIBUTOR;
				}
				
				$data['KD_SAP'] = (int)$customer['customer'][$key]->KD_SAP;
				
				if($customer['customer'][$key]->STATUS_TOKO_ID == "0"){
					$data['STATUS_TOKO'] = null;
				} else {
					$data['STATUS_TOKO']['STATUS_TOKO_ID'] = (int)$customer['customer'][$key]->STATUS_TOKO_ID;
					$data['STATUS_TOKO']['STATUS_TOKO'] = $customer['customer'][$key]->STATUS_TOKO;
				}

				if($customer['customer'][$key]->TIPE_TOKO_ID == "0"){
					$data['TIPE_TOKO'] = null;
				} else {
					$data['TIPE_TOKO']['TIPE_TOKO_ID'] = (int)$customer['customer'][$key]->TIPE_TOKO_ID;
					$data['TIPE_TOKO']['TIPE_TOKO'] = $customer['customer'][$key]->TIPE_TOKO;
				}

				if($customer['customer'][$key]->KD_AREA == "0"){
					$data['AREA'] = null;
				} else {
					$data['AREA']['KD_AREA'] = (int)$customer['customer'][$key]->KD_AREA;
					$data['AREA']['NM_AREA'] = $customer['customer'][$key]->NM_AREA;
				}
				
				$data['PNT_STATUS'] = $customer['customer'][$key]->PNT_STATUS;

				if($customer['customer'][$key]->STATUS_ACTIVE_ID == "0"){
					$data['STATUS_ACTIVE'] = null;
				} else {
					$data['STATUS_ACTIVE']['STATUS_ACTIVE_ID'] = (int)$customer['customer'][$key]->STATUS_ACTIVE_ID;
					$data['STATUS_ACTIVE']['STATUS_ACTIVE_TOKO'] = $customer['customer'][$key]->STATUS_ACTIVE_TOKO;
				}
				
				$data['IS_VERIFIED'] = $customer['customer'][$key]->IS_VERIFIED;
				$data['IS_VERIFIED_BARCODE'] = $customer['customer'][$key]->IS_VERIFIED_BARCODE;
				$data['NM_OWNER'] = $customer['customer'][$key]->NM_OWNER;
				$data['NOKTP_OWNER'] = $customer['customer'][$key]->NOKTP_OWNER;
				$data['NO_HANDPHONE'] = $customer['customer'][$key]->NO_HANDPHONE;
				$data['EMAIL'] = $customer['customer'][$key]->EMAIL;

				if($customer['customer'][$key]->KD_REGION == "0"){
					$data['REGION'] = null;
				} else {
					$data['REGION']['KD_REGION'] = (int)$customer['customer'][$key]->KD_REGION;
					$data['REGION']['NM_REGION'] = $customer['customer'][$key]->NM_REGION;
				}

				if($customer['customer'][$key]->KD_CITY == "0"){
					$data['CITY'] = null;
				} else {
					$data['CITY']['KD_CITY'] = (int)$customer['customer'][$key]->KD_CITY;
					$data['CITY']['NM_CITY'] = $customer['customer'][$key]->NM_CITY;
				}

				if($customer['customer'][$key]->KD_DISTRICT == "0"){
					$data['DISTRICT'] = null;
				} else {
					$data['DISTRICT']['KD_DISTRICT'] = (int)$customer['customer'][$key]->KD_DISTRICT;
					$data['DISTRICT']['NM_DISTRICT'] = $customer['customer'][$key]->NM_DISTRICT;
				}
				
				$data['ALAMAT_TOKO'] = $customer['customer'][$key]->ALAMAT_TOKO;
				$data['COORDINATE']['LATITUDE'] = (float)$customer['customer'][$key]->LATITUDE;
				$data['COORDINATE']['LONGITUDE'] = (float)$customer['customer'][$key]->LONGITUDE;
				$data['GPS_ACCURACY'] = $customer['customer'][$key]->GPS_ACCURACY;
				$data['KETERANGAN'] = $customer['customer'][$key]->KETERANGAN;
				$data['UPDATED_AT'] = $customer['customer'][$key]->UPDATED_AT;
				$data['IS_DELETED'] = $customer['customer'][$key]->IS_DELETED;
				$json[] = $data;
				
				$response = array("status" => "success", "total" => $total['total'], "data" => $json);
			}
		} else {
			$response = array("status" => "success", "total" => 0, "data" => null);
		}
		$this->print_api($response);
		
	}

	public function search_post(){
		$name = $this->post('name');
		$region = $this->post('region');
		$city = $this->post('city');
		$district = $this->post('district');
		$limit = $this->post('limit');
		$is_verified = $this->post('is_verified');
		$is_verified_barcode = $this->post('is_verified_barcode');
		$start = $this->post('start');

		$customer = $this->Model_customer->search_customer($name, $region, $city, $district, $is_verified, $is_verified_barcode, $limit, $start);
		// echo $this->db->last_query();
		$total = $this->Model_customer->search_customer($name, $region, $city, $district, $is_verified);
		
		if($customer){
			foreach ($customer['customer'] as $key => $value) {
				$data['CUSTOMER_ID'] = (int)$customer['customer'][$key]->CUSTOMER_ID;
				$data['KD_CUSTOMER'] = (int)$customer['customer'][$key]->KD_CUSTOMER;
				$data['NM_TOKO'] = $customer['customer'][$key]->NM_TOKO;
				$data['NO_TELP_TOKO'] = $customer['customer'][$key]->NO_TELP_TOKO;
				if($customer['customer'][$key]->KD_GROUP == "0"){
					$data['GROUP'] = null;
				} else {
					$data['GROUP']['GROUP_CUSTOMER_ID'] = $customer['customer'][$key]->KD_GROUP;
					$data['GROUP']['GROUP_CUSTOMER'] = $customer['customer'][$key]->GROUP_CUSTOMER;
				}


				if($customer['customer'][$key]->KD_DISTRIBUTOR == "0"){
					$data['DISTRIBUTOR'] = null;
				} else {
					$data['DISTRIBUTOR']['KD_DISTRIBUTOR'] = $customer['customer'][$key]->KD_DISTRIBUTOR;
					$data['DISTRIBUTOR']['NM_DISTRIBUTOR'] = $customer['customer'][$key]->NM_DISTRIBUTOR;
				}
				
				$data['KD_SAP'] = (int)$customer['customer'][$key]->KD_SAP;
				
				if($customer['customer'][$key]->STATUS_TOKO_ID == "0"){
					$data['STATUS_TOKO'] = null;
				} else {
					$data['STATUS_TOKO']['STATUS_TOKO_ID'] = (int)$customer['customer'][$key]->STATUS_TOKO_ID;
					$data['STATUS_TOKO']['STATUS_TOKO'] = $customer['customer'][$key]->STATUS_TOKO;
				}

				if($customer['customer'][$key]->TIPE_TOKO_ID == "0"){
					$data['TIPE_TOKO'] = null;
				} else {
					$data['TIPE_TOKO']['TIPE_TOKO_ID'] = (int)$customer['customer'][$key]->TIPE_TOKO_ID;
					$data['TIPE_TOKO']['TIPE_TOKO'] = $customer['customer'][$key]->TIPE_TOKO;
				}

				if($customer['customer'][$key]->KD_AREA == "0"){
					$data['AREA'] = null;
				} else {
					$data['AREA']['KD_AREA'] = (int)$customer['customer'][$key]->KD_AREA;
					$data['AREA']['NM_AREA'] = $customer['customer'][$key]->NM_AREA;
				}
				
				$data['PNT_STATUS'] = $customer['customer'][$key]->PNT_STATUS;

				if($customer['customer'][$key]->STATUS_ACTIVE_ID == "0"){
					$data['STATUS_ACTIVE'] = null;
				} else {
					$data['STATUS_ACTIVE']['STATUS_ACTIVE_ID'] = (int)$customer['customer'][$key]->STATUS_ACTIVE_ID;
					$data['STATUS_ACTIVE']['STATUS_ACTIVE_TOKO'] = $customer['customer'][$key]->STATUS_ACTIVE_TOKO;
				}
				
				$data['IS_VERIFIED'] = $customer['customer'][$key]->IS_VERIFIED;
				$data['IS_VERIFIED_BARCODE'] = $customer['customer'][$key]->IS_VERIFIED_BARCODE;
				$data['NM_OWNER'] = $customer['customer'][$key]->NM_OWNER;
				$data['NOKTP_OWNER'] = $customer['customer'][$key]->NOKTP_OWNER;
				$data['NO_HANDPHONE'] = $customer['customer'][$key]->NO_HANDPHONE;
				$data['EMAIL'] = $customer['customer'][$key]->EMAIL;

				if($customer['customer'][$key]->KD_REGION == "0"){
					$data['REGION'] = null;
				} else {
					$data['REGION']['KD_REGION'] = (int)$customer['customer'][$key]->KD_REGION;
					$data['REGION']['NM_REGION'] = $customer['customer'][$key]->NM_REGION;
				}

				if($customer['customer'][$key]->KD_CITY == "0"){
					$data['CITY'] = null;
				} else {
					$data['CITY']['KD_CITY'] = (int)$customer['customer'][$key]->KD_CITY;
					$data['CITY']['NM_CITY'] = $customer['customer'][$key]->NM_CITY;
				}

				if($customer['customer'][$key]->KD_DISTRICT == "0"){
					$data['DISTRICT'] = null;
				} else {
					$data['DISTRICT']['KD_DISTRICT'] = (int)$customer['customer'][$key]->KD_DISTRICT;
					$data['DISTRICT']['NM_DISTRICT'] = $customer['customer'][$key]->NM_DISTRICT;
				}
				
				$data['ALAMAT_TOKO'] = $customer['customer'][$key]->ALAMAT_TOKO;
				$data['COORDINATE']['LATITUDE'] = (float)$customer['customer'][$key]->LATITUDE;
				$data['COORDINATE']['LONGITUDE'] = (float)$customer['customer'][$key]->LONGITUDE;
				$data['GPS_ACCURACY'] = $customer['customer'][$key]->GPS_ACCURACY;
				$data['KETERANGAN'] = $customer['customer'][$key]->KETERANGAN;
				$data['UPDATED_AT'] = $customer['customer'][$key]->UPDATED_AT;
				$data['IS_DELETED'] = $customer['customer'][$key]->IS_DELETED;
				$json[] = $data;
			}
			$response = array("status" => "success", "total" => $total['total'], "data" => $json);
		} else {
			$response = array("status" => "success", "total" => 0, "data" => null);
		}

		$this->print_api($response);
	}

	public function edit_put(){
		$data_customer = array();
		$data_owner = array();
		$data_location = array();

		//customer
		$customer_id = $this->put('customer_id');
		$nama_toko = $this->put('nama_toko');
		$no_telp_toko = $this->put('no_telp_toko');
		$pnt_status = $this->put('pnt_status');
		$gps_accuracy = $this->put('gps_accuracy');
		$is_verified = $this->put('is_verified');
		$is_verified_barcode = $this->put('is_verified_barcode');
		$status_active_toko = $this->put('status_active_toko');
		$keterangan = $this->put('keterangan');
		$tipe_toko = $this->put('tipe_toko');
		// $updated_at = $this->put('updated_at');

		//owner
		$nama_owner = $this->put('nama_owner');
		$noktp_owner = $this->put('noktp_owner');
		$no_handphone = $this->put('no_handphone');
		$email = $this->put('email');

		//location
		$district = $this->put('district');
		$latitude = $this->put('latitude');
		$longitude = $this->put('longitude');
		$alamat = $this->put('alamat');

		$i=0;
		$j=0;
		$k=0;

		foreach ($customer_id as $customer_key => $customer_value) {
			$date = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
			$date = $date->format('Y-m-d H:i:s');
			$data = array("CUSTOMER_ID" => $customer_id[$i], "TIPE_TOKO" => $tipe_toko[$i], "NM_TOKO" => $nama_toko[$i], "NO_TELP_TOKO" => $no_telp_toko[$i], "PNT_STATUS" => $pnt_status[$i], "GPS_ACCURACY" => (int)$gps_accuracy[$i], "IS_VERIFIED" => $is_verified[$i], "IS_VERIFIED_BARCODE" => $is_verified_barcode[$i], "STATUS_ACTIVE_TOKO" => $status_active_toko[$i], "KETERANGAN" => $keterangan[$i], "UPDATED_AT" => $date);
			array_push($data_customer, $data);
			$i++;
		}

		foreach ($customer_id as $customer_key => $customer_value) {
			$data = array("CUSTOMER_ID" => $customer_id[$j], "NM_OWNER" => $nama_owner[$j], "NO_HANDPHONE" => $no_handphone[$j], "EMAIL" => $email[$j], "NOKTP_OWNER" => (int)$noktp_owner[$j]);
			array_push($data_owner, $data);
			$j++;
		}

		foreach ($customer_id as $customer_key => $customer_value) {
			$data = array("CUSTOMER_ID" => $customer_id[$k], "KD_DISTRICT" => (int)$district[$k], "LATITUDE" => (float)$latitude[$k], "LONGITUDE" => (float)$longitude[$k], "ALAMAT_TOKO" => $alamat[$k]);
			array_push($data_location, $data);
			$k++;
		}

		$update_customer = $this->Model_customer->update_tabel('MASTER_CUSTOMER', $data_customer, 'CUSTOMER_ID');
		$update_owner = $this->Model_customer->update_tabel('CUSTOMER_OWNER', $data_owner, 'CUSTOMER_ID');
		$update_location = $this->Model_customer->update_tabel('CUSTOMER_LOCATION', $data_location, 'CUSTOMER_ID');

		if($update_customer && $update_owner && $update_location){
			$total = array("total_customer" => $update_customer, "total_owner" => $update_owner, "total_location" => $update_location);
			$response = array("status" => "success", "data" => $total);
		} else {
			$response = array("status" => "error", "message" => "Can't Save Customer");
		}

		$this->print_api($response);
	}
}
