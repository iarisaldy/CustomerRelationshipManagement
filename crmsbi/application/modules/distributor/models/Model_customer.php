<?php
	if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

	date_default_timezone_set('Asia/Jakarta');
 
	class Model_customer extends CI_Model {

		var $table = 'CRMNEW_CUSTOMER';
    	var $column_order = array(null, 'ID_CUSTOMER', 'NAMA_TOKO', 'NAMA_PEMILIK', null, null, null, null, null, null, null, null, "TOTAL_DIKUNJUNGI");
    	var $column_search = array('CRMNEW_CUSTOMER.ID_CUSTOMER', 'CRMNEW_CUSTOMER.NAMA_TOKO', 'CRMNEW_CUSTOMER.NAMA_PEMILIK');
    	var $order = array('ID_CUSTOMER' => 'ASC');

		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function customer($idDistributor = null, $idProvinsi = null, $kodeLt = null, $startDate = null, $endDate = null){
			if(isset($idDistributor)){
				if($idDistributor != ""){
					$this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
				}
			}

			if(isset($idProvinsi)){
				if($idProvinsi != ""){
					$this->db->where("CRMNEW_CUSTOMER.ID_PROVINSI", $idProvinsi);
				}
			}

			if(isset($kodeLt)){
				if($kodeLt != ""){
					$this->db->where("CRMNEW_CUSTOMER.KD_LT", $kodeLt);
				}
			}

			$this->db->select("CRMNEW_CUSTOMER.ID_CUSTOMER, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_CUSTOMER.NAMA_PEMILIK, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR, 
				CRMNEW_CUSTOMER.ID_PROVINSI, CRMNEW_M_PROVINSI.NAMA_PROVINSI, CRMNEW_CUSTOMER.NAMA_DISTRIK, 
				CRMNEW_CUSTOMER.ID_AREA, CRMNEW_CUSTOMER.ALAMAT, CRMNEW_CUSTOMER.NAMA_KECAMATAN, CRMNEW_CUSTOMER.GROUP_CUSTOMER, CRMNEW_CUSTOMER.KD_LT, TOKO_LT.NAMA_TOKO AS NAMA_LT, CRMNEW_CUSTOMER.CLUSTER_TOKO AS CLUSTER, NVL(KUNJUNGAN.TOTAL_DIKUNJUNGI, 0) AS TOTAL_DIKUNJUNGI");
			$this->db->from("CRMNEW_CUSTOMER");
			$this->db->join("CRMNEW_M_PROVINSI", "CRMNEW_CUSTOMER.ID_PROVINSI = CRMNEW_M_PROVINSI.ID_PROVINSI");
			$this->db->join("(SELECT ID_TOKO, COUNT(ID_KUNJUNGAN_CUSTOMER) AS TOTAL_DIKUNJUNGI FROM CRMNEW_KUNJUNGAN_CUSTOMER WHERE TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'YYYY-MM-DD') BETWEEN '$startDate' AND '$endDate' AND CHECKIN_TIME IS NOT NULL GROUP BY ID_TOKO) KUNJUNGAN", "CRMNEW_CUSTOMER.ID_CUSTOMER = KUNJUNGAN.ID_TOKO", "left");
			$this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_CUSTOMER.ID_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
			$this->db->join("(SELECT KD_SAP, NAMA_TOKO FROM CRMNEW_CUSTOMER WHERE GROUP_CUSTOMER = 'LT') TOKO_LT", "CRMNEW_CUSTOMER.KD_LT = TOKO_LT.KD_SAP", "LEFT");
			
			$customer = $this->db->get();
			return $customer->result();
		}

		public function getProvinsiDist($idDistributor){
			$sql = "SELECT
						SUBSTR( KD_DISTRIK, 1, 2 ) AS PROVINSI,
						COUNT( ID_GUDANG_DIST ) AS JUMLAH 
					FROM
						CRMNEW_M_GUDANG_DISTRIBUTOR 
					WHERE
						KODE_DISTRIBUTOR = $idDistributor 
					GROUP BY
						SUBSTR( KD_DISTRIK, 1, 2 ) 
					ORDER BY
						COUNT(
						ID_GUDANG_DIST) DESC";
			$dist = $this->db->query($sql)->row();
			return $dist;
		}

		private function _get_datatables_query($startDate = null, $endDate = null){
			$this->db->select("CRMNEW_CUSTOMER.ID_CUSTOMER, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_CUSTOMER.NAMA_PEMILIK, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR, 
				CRMNEW_CUSTOMER.ID_PROVINSI, CRMNEW_M_PROVINSI.NAMA_PROVINSI, CRMNEW_CUSTOMER.NAMA_DISTRIK, 
				CRMNEW_CUSTOMER.ID_AREA, CRMNEW_CUSTOMER.ALAMAT, CRMNEW_CUSTOMER.NAMA_KECAMATAN, CRMNEW_CUSTOMER.GROUP_CUSTOMER, CRMNEW_CUSTOMER.KD_LT, TOKO_LT.NAMA_TOKO AS NAMA_LT, CRMNEW_CUSTOMER.CLUSTER_TOKO AS CLUSTER, NVL(KUNJUNGAN.TOTAL_DIKUNJUNGI, 0) AS TOTAL_DIKUNJUNGI");
			$this->db->from($this->table);
			$this->db->join("CRMNEW_M_PROVINSI", "CRMNEW_CUSTOMER.ID_PROVINSI = CRMNEW_M_PROVINSI.ID_PROVINSI");
			$this->db->join("(SELECT ID_TOKO, COUNT(ID_KUNJUNGAN_CUSTOMER) AS TOTAL_DIKUNJUNGI FROM CRMNEW_KUNJUNGAN_CUSTOMER WHERE TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.CHECKIN_TIME, 'YYYY-MM-DD') BETWEEN '$startDate' AND '$endDate' AND CHECKIN_TIME IS NOT NULL GROUP BY ID_TOKO) KUNJUNGAN", "CRMNEW_CUSTOMER.ID_CUSTOMER = KUNJUNGAN.ID_TOKO", "left");
			$this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_CUSTOMER.ID_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
			$this->db->join("(SELECT KD_SAP, NAMA_TOKO FROM CRMNEW_CUSTOMER WHERE GROUP_CUSTOMER = 'LT') TOKO_LT", "CRMNEW_CUSTOMER.KD_LT = TOKO_LT.KD_SAP", "LEFT");
			$idJenisUser = $this->session->userdata("id_jenis_user");
			if($idJenisUser != "1001"){
				$this->db->where("ID_DISTRIBUTOR", $this->session->userdata("kode_dist"));
			}
			
			$i = 0;
			foreach ($this->column_search as $item){
				if($_POST['search']['value']){
					if($i===0){
						$this->db->group_start(); 
						$this->db->like($item, strtoupper($_POST['search']['value']));
					} else {
						$this->db->or_like($item, strtoupper($_POST['search']['value']));
					}

					if(count($this->column_search) - 1 == $i) 
						$this->db->group_end();
				}
				$i++;
			}
			if(isset($_POST['order'])){
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} else if(isset($this->order)) {
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}

		function get_datatables($idDistributor = null, $idProvinsi = null, $startDate = null, $endDate = null, $kodeLt = null, $cluster = null){
			$this->_get_datatables_query($startDate, $endDate);
			if(isset($idDistributor)){
				if($idDistributor != ""){
					$this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
				}
			}

			if(isset($idProvinsi)){
				if($idProvinsi != ""){
					$this->db->where("CRMNEW_CUSTOMER.ID_PROVINSI", $idProvinsi);
				}
			}

			if(isset($kodeLt)){
				if($kodeLt != ""){
					$this->db->where("CRMNEW_CUSTOMER.KD_LT", $kodeLt);
				}
			}

			if($_POST['length'] != -1)
				$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}

		function count_filtered(){
			$this->_get_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}

		public function count_all(){
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}

		public function detailCustomer($idCustomer = null){
			if(isset($idCustomer)){
				$this->db->where("CRMNEW_CUSTOMER.ID_CUSTOMER", $idCustomer);
			}

			$this->db->select("CRMNEW_CUSTOMER.ID_CUSTOMER, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_LOKASI_CUSTOMER.LATITUDE, CRMNEW_LOKASI_CUSTOMER.LONGITUDE, CRMNEW_LOKASI_CUSTOMER.ID_LOKASI_CUSTOMER");
			$this->db->from("CRMNEW_CUSTOMER");
			$this->db->join("CRMNEW_LOKASI_CUSTOMER", "CRMNEW_CUSTOMER.ID_CUSTOMER = CRMNEW_LOKASI_CUSTOMER.ID_CUSTOMER", "left");
			$this->db->where("CRMNEW_LOKASI_CUSTOMER.DELETE_MARK", "0");
			$data =  $this->db->get();
			if($data->num_rows() > 0){
				return $data->result();
			} else {
				return false;
			}
		}

		public function addTagging($data){
			$this->db->insert("CRMNEW_LOKASI_CUSTOMER", $data);
			if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
		}

		public function updateTagging($idLokasiCustomer, $data){
			$this->db->where("ID_LOKASI_CUSTOMER", $idLokasiCustomer)->update("CRMNEW_LOKASI_CUSTOMER", $data);
			if($this->db->affected_rows()){
                return true;
            } else {
                return false;
            }
		}

		public function clusterToko($idDistributor){
			$db_point = $this->load->database("Point", true);
			$sql = "SELECT ID_CUSTOMER,
			CASE
				WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) >= 2200 THEN 'SUPER PLATINUM'
				WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 680 AND 2199 THEN 'PLATINUM'
				WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 400 AND 679 THEN 'GOLD'
				WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 280 AND 399 THEN 'SILVER'
				WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) BETWEEN 0.1 AND 279 THEN 'NON CLUSTER'
				WHEN SUM(PP.PENJUALAN + PP.PENJUALAN_SP) = 0 THEN 'TIDAK ADA PENJUALAN' END AS CLUSTERR
			FROM
				M_CUSTOMER MC
			LEFT JOIN P_POIN PP ON MC.KD_CUSTOMER = PP.KD_CUSTOMER 
			WHERE MC.NOMOR_DISTRIBUTOR = '$idDistributor' AND PP.BULAN = '10' AND PP.TAHUN = '2018' GROUP BY ID_CUSTOMER";
			$data = $db_point->query($sql);			
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
		}
	}
?>