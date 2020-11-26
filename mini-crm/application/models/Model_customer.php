<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_customer extends CI_Model{

	var $column_order = array(null, 'MC.CUSTOMER_ID','MC.NM_TOKO','CO.NM_OWNER','MR.NM_REGION','MC.NM_CITY','MD.NM_DISTRICT','MA.NM_AREA');
    var $column_search = array('MC.CUSTOMER_ID','MC.NM_TOKO','CO.NM_OWNER','MR.NM_REGION','MC.NM_CITY','MD.NM_DISTRICT','MA.NM_AREA');
    var $order = array('MC.CUSTOMER_ID' => 'asc');

    function query_datatable(){
		$table = 'MASTER_CUSTOMER';

		//query backup master customer
		// $this->db->select("MC.CUSTOMER_ID, NVL(MC.KD_CUSTOMER, '') AS KD_CUSTOMER, MC.NM_TOKO, NVL(MC.NO_TELP_TOKO, 0) AS NO_TELP_TOKO, NVL(MC.GROUP_CUSTOMER, 0) AS KD_GROUP, NVL(MGC.NM_GROUP, '-') AS GROUP_CUSTOMER, NVL(MC.KD_SAP, 0) AS KD_SAP, NVL(MC.KD_DISTRIBUTOR, 0) AS KD_DISTRIBUTOR, NVL(MDIST.NM_DISTRIBUTOR, '-') AS NM_DISTRIBUTOR, NVL(MC.STATUS_TOKO, 0) AS STATUS_TOKO_ID, NVL(MST.NAMA_STATUS, '-') AS STATUS_TOKO, NVL(MC.TIPE_TOKO, 0) AS TIPE_TOKO_ID, NVL(MTT.NAMA_TIPE, '-') AS TIPE_TOKO, CL.AREA, NVL(MC.PNT_STATUS, '-') AS PNT_STATUS, NVL(MC.STATUS_ACTIVE_TOKO, 0) AS STATUS_ACTIVE_ID, NVL(MAS.NM_STATUS_ACTIVE, '-') AS STATUS_ACTIVE_TOKO, NVL(MC.IS_VERIFIED, '-') AS IS_VERIFIED, CO.NM_OWNER, NVL(CO.NOKTP_OWNER, 0) AS NOKTP_OWNER, NVL(CO.NO_HANDPHONE, '0') AS NO_HANDPHONE, NVL(CO.EMAIL, '-') AS EMAIL, CL.KD_REGION, MR.NM_REGION, CL.KD_CITY, MC.NM_CITY, NVL(CL.KD_DISTRICT, 0) AS KD_DISTRICT, NVL(MD.NM_DISTRICT, '-') AS NM_DISTRICT, NVL(MA.KD_AREA, 0) AS KD_AREA, NVL(MA.NM_AREA, '-') AS NM_AREA, CL.ALAMAT_TOKO, NVL(CL.LATITUDE, 0) AS LATITUDE, NVL(CL.LONGITUDE, 0) AS LONGITUDE, NVL(MC.GPS_ACCURACY, 0) AS GPS_ACCURACY, NVL(MC.KETERANGAN, '-') AS KETERANGAN, NVL(MC.UPDATED_AT, '-') AS UPDATED_AT");
		$this->db->select("MC.CUSTOMER_ID, MC.KD_CUSTOMER, MC.NM_TOKO, NVL(MC.NO_TELP_TOKO, 0) AS NO_TELP_TOKO, NVL(MC.GROUP_CUSTOMER, 0) AS KD_GROUP, NVL(MGC.NM_GROUP, '-') AS GROUP_CUSTOMER, NVL(MC.KD_SAP, 0) AS KD_SAP, NVL(MC.KD_DISTRIBUTOR, 0) AS KD_DISTRIBUTOR, NVL(MDIST.NM_DISTRIBUTOR, '-') AS NM_DISTRIBUTOR, NVL(MC.STATUS_TOKO, 0) AS STATUS_TOKO_ID, NVL(MST.NAMA_STATUS, '-') AS STATUS_TOKO, NVL(MC.TIPE_TOKO, 0) AS TIPE_TOKO_ID, NVL(MTT.NAMA_TIPE, '-') AS TIPE_TOKO, CL.AREA, NVL(MC.PNT_STATUS, '-') AS PNT_STATUS, NVL(MC.STATUS_ACTIVE_TOKO, 0) AS STATUS_ACTIVE_ID, NVL(MAS.NM_STATUS_ACTIVE, '-') AS STATUS_ACTIVE_TOKO, NVL(IS_VERIFIED, 'N') AS IS_VERIFIED, NVL(IS_VERIFIED_BARCODE, 'N') AS IS_VERIFIED_BARCODE, CO.NM_OWNER, NVL(CO.NOKTP_OWNER, 0) AS NOKTP_OWNER, NVL(CO.NO_HANDPHONE, '0') AS NO_HANDPHONE, EMAIL, CL.KD_REGION, MR.NM_REGION, CL.KD_CITY, MC.NM_CITY, NVL(CL.KD_DISTRICT, 0) AS KD_DISTRICT, NVL(MD.NM_DISTRICT, '-') AS NM_DISTRICT, NVL(MA.KD_AREA, 0) AS KD_AREA, NVL(MA.NM_AREA, '-') AS NM_AREA, CL.ALAMAT_TOKO, NVL(CL.LATITUDE, 0) AS LATITUDE, NVL(CL.LONGITUDE, 0) AS LONGITUDE, NVL(MC.GPS_ACCURACY, 0) AS GPS_ACCURACY, MC.KETERANGAN, MC.UPDATED_AT, NVL(MC.IS_DELETED, 'N') AS IS_DELETED");
		$this->db->from('MASTER_CUSTOMER MC');
		$this->db->join('CUSTOMER_OWNER CO', 'MC.CUSTOMER_ID = CO.CUSTOMER_ID');
		$this->db->join('CUSTOMER_LOCATION CL', 'MC.CUSTOMER_ID = CL.CUSTOMER_ID');
		$this->db->join('MASTER_STATUS_TOKO MST', 'MC.STATUS_TOKO = MST.STATUS_TOKO_ID', 'LEFT');
		$this->db->join('MASTER_TIPE_TOKO MTT', 'MC.TIPE_TOKO = MTT.TIPE_TOKO_ID', 'LEFT');
		$this->db->join('MASTER_ACTIVE_STATUS MAS', 'MC.STATUS_ACTIVE_TOKO = MAS.STATUS_ACTIVE_ID', 'LEFT');
		$this->db->join('MASTER_GROUP_CUSTOMER MGC', 'MC.GROUP_CUSTOMER = MGC.KD_GROUP', 'LEFT');
		$this->db->join('MASTER_DISTRIBUTOR MDIST', 'MC.KD_DISTRIBUTOR = MDIST.KD_DISTRIBUTOR','LEFT');
		$this->db->join('MASTER_REGION MR', 'CL.KD_REGION = MR.KD_REGION');
		$this->db->join('MASTER_CITY MC', 'CL.KD_CITY = MC.KD_CITY');
		$this->db->join('MASTER_DISTRICT MD', 'CL.KD_DISTRICT = MD.KD_DISTRICT', 'LEFT');
		$this->db->join('MASTER_AREA MA', 'CL.AREA = MA.KD_AREA', 'LEFT');
		$this->db->order_by('MC.CUSTOMER_ID', 'DESC');
	}

	public function list_customer($city = null, $limit = null, $start = null){
		if(isset($city)){
			if($city != "" && $city != "00"){
				$this->db->where('CL.KD_CITY', $city);
			}
		}

		if(isset($limit) && isset($start)){
			$this->db->limit($limit, $start);
		}

		$this->query_datatable();
		
		$customer = $this->db->get();
		if($customer->num_rows() > 0){
			return array("customer" => $customer->result(), "total" => $customer->num_rows());
		} else {
			return false;
		}
	}

	public function detail_customer($customer_id){
		$this->db->where('MC.CUSTOMER_ID', $customer_id);
		$this->query_datatable();

		$customer = $this->db->get();
		if($customer->num_rows() > 0){
			return $customer->result();
		} else {
			return false;
		}
	}


	public function search_customer($name, $region = null, $city = null, $district = null, $is_verified = null, $is_verified_barcode = null, $limit = null, $start = null){
		if(isset($region)){
			$this->db->where('CL.KD_REGION', $region);
		}

		if(isset($city)){
			if($city != ""){
				$this->db->where_in('CL.KD_CITY', $city);
				// $this->db->where('CL.KD_CITY', $city);
			}
		}

		if(isset($district)){
			if($district != ""){
				$this->db->where('CL.KD_DISTRICT', $district);
			}
		}

		if(isset($limit) || isset($start)){
			$this->db->limit($limit, $start);
		}

		if($name != ""){
			$this->db->like('MC.NM_TOKO', strtoupper($name), 'both');
		}

		if(isset($is_verified)){
			if($is_verified != ""){
				$this->db->where('MC.IS_VERIFIED', $is_verified);
			}
		}

		if(isset($is_verified_barcode)){
			if($is_verified_barcode != ""){
				$this->db->where('MC.IS_VERIFIED_BARCODE', $is_verified_barcode);
			}
		}		

		$this->db->where('MC.IS_DELETED', 'N');
		$this->query_datatable();

		$customer = $this->db->get();
		if($customer->num_rows() > 0){
			return array("customer" => $customer->result(), "total" => $customer->num_rows());
		} else {
			return false;
		}
	}

	public function customer_by_date($date, $city, $is_deleted = null){
		if(isset($date)){
			$this->db->where('MC.UPDATED_AT >=', $date);
			$this->db->where('MC.UPDATED_AT <=', date('Y-m-d H:i:s'));
		}

		if(isset($city)){
			$this->db->where_in('MC.KD_CITY', $city);
		}

		if(isset($is_deleted)){
			if($is_deleted != ""){
				$this->db->where('MC.IS_DELETED', $is_deleted);
			}
		}
		$this->query_datatable();

		$customer = $this->db->get();
		if($customer->num_rows() > 0){
			return array("customer" => $customer->result(), "total" => $customer->num_rows());
		} else {
			return false;
		}
	}

	public function export($kd_city){
		if(isset($kd_city)){
			$this->db->where('CL.KD_CITY', $kd_city);
		}
		$this->query_datatable();

		$customer = $this->db->get();
		if($customer){
			return $customer->result();
		} else {
			return false;
		}
	}

	private function _get_datatables_query(){
    	$this->query_datatable();
    	$i = 0;
    	foreach ($this->column_search as $item){
    		if($_POST['search']['value']){
    			if($i===0){
    				$this->db->group_start();
    				$this->db->like($item, strtoupper($_POST['search']['value']));
    			} else {
    				$this->db->or_like($item, strtoupper($_POST['search']['value']));
    			}

    			if(count($this->column_search) - 1 == $i){
    				$this->db->group_end();
    			}
    			$i++;
    		}

    		if(isset($_POST['order'])){
    			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    		} else if(isset($this->order)){
    			$order = $this->order;
    			$this->db->order_by(key($order), $order[key($order)]);
    		}
    	}
    }

    public function get_datatables($region, $city){
    	if($region != 0){
    		$this->db->where('CL.KD_REGION', $region);
    	}

    	if($city != 0){
    		$this->db->where('CL.KD_CITY', $city);
    	}
    	$this->_get_datatables_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    public function count_filtered(){
    	$this->_get_datatables_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function count_all(){
    	$this->db->from($this->query_datatable());
    	return $this->db->count_all_results();
    }

	public function last_customer_id(){
		$this->db->select_max('CUSTOMER_ID');
		$customer_id = $this->db->get('MASTER_CUSTOMER');
		if($customer_id->num_rows() > 0){
			return $customer_id->row();
		} else {
			return false;
		}
	}

	public function insert_tabel($tabel, $data){
		$insert = $this->db->insert($tabel, $data);
		if($this->db->affected_rows() > 0){
			return true;
		} else {
			return false;
		}
	}
	public function insert_batch_tabel($table, $data){
		$this->db->insert_batch($table, $data);
		if($this->db->affected_rows() > 0){
			return $this->db->affected_rows();
		} else {
			return false;
		}
	}

	public function update_tabel($table, $data, $id){
		$this->db->update_batch($table, $data, $id);
		if($this->db->affected_rows() > 0){
			return $this->db->affected_rows();
		} else {
			return false;
		}
	}

	public function check_column($table){
		return $this->db->field_data($table);
	}

	public function nonaktif($data, $customer_id){
		$this->db->where('CUSTOMER_ID', $customer_id)->update('MASTER_CUSTOMER', $data);
		if($this->db->affected_rows() > 0){
			return $this->db->affected_rows();
		} else {
			return false;
		}
	}


}