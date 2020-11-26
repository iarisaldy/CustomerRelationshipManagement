<?php
	class Peta_rencana_kunjungan_toko extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Peta_toko_model", "PTM");
		}

		public function index(){
			$data = array("title" => "Dashboard CRM Administrator");
			$bulan = date('m');
			$tahun = date('Y');
			if (isset($_POST["filterBulan"]) and isset($_POST["filterTahun"])) {
				if($_POST["filterBulan"] < 10){
					$this->session->set_userdata('set_bulan', $bulan);
					$bulan = "0".$_POST["filterBulan"];
				} else {
					$bulan = $_POST["filterBulan"];
				}
				$tahun = $_POST["filterTahun"];
				$this->session->set_userdata('set_tahun', $tahun);
			}
			$this->session->set_userdata('set_bulan', $bulan);
			$this->session->set_userdata('set_tahun', $tahun);
			
			//$this->template->display('Peta_toko_view', $data);
			// gsm = 1016, rsm = 1010, asm = 1011, tso = 1012
			
			$jenis_user     = $this->session->userdata('id_jenis_user');
			$id_user 		= $this->session->userdata('user_id');
			
			if($jenis_user == 1016){		
				$data['tso'] = $this->PTM->listTsoGsm($id_user); 
				$i = 1;
				foreach($data['tso'] as $tso){
					if($i == 1){
						$data['id_tso_1'] = $tso['ID_SO'];
						$data['nm_tso_1'] = $tso['NAMA_SO'];
					}
					$i++;
				}
				$this->template->display('View_peta_toko', $data);
			} else if($jenis_user == 1010){
				$data['tso'] = $this->PTM->listTsoSsm($id_user); 
				$i = 1;
				foreach($data['tso'] as $tso){
					if($i == 1){
						$data['id_tso_1'] = $tso['ID_SO'];
						$data['nm_tso_1'] = $tso['NAMA_SO'];
					}
					$i++;
				}
				$this->template->display('View_peta_toko', $data);
			} else if($jenis_user == 1011){
				$data['tso'] = $this->PTM->listTsoSm($id_user); 
				$i = 1;
				foreach($data['tso'] as $tso){
					if($i == 1){
						$data['id_tso_1'] = $tso['ID_SO'];
						$data['nm_tso_1'] = $tso['NAMA_SO'];
					}
					$i++;
				}
				$this->template->display('View_peta_toko', $data);
			} else if($jenis_user == 1012){
				$this->template->display('View_peta_toko_tso', $data);
			} else if ($jenis_user == 1009){
				$data['tso'] = $this->PTM->listTsoAdmin($id_user); 
				$i = 1;
				foreach($data['tso'] as $tso){
					if($i == 1){
						$data['id_tso_1'] = $tso['ID_SO'];
						$data['nm_tso_1'] = $tso['NAMA_SO'];
					}
					$i++;
				}
				$this->template->display('View_peta_toko', $data);
			}
			
		}
		/*
		public function masterAreaTso(){
			$id_user = $this->session->userdata('user_id');
			$area = $this->PTM->masterAreaTso($id_user);
			if($area){
				echo json_encode($area);
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Master Area Tidak Ada"));
			}
		}
		
		public function petaToko(){
			$id_user 		= $this->session->userdata('user_id');
			
			$bulan		 	= $this->input->post("bulan");
			$tahun			= $this->input->post("tahun");
			$area			= $this->input->post("area");
			
			$data = $this->PTM->petaToko($id_user, $bulan, $tahun, $area);
			
			if($data){
				$a = 0; $b = 0;
				$on_koor = 0;
				$off_koor = 0;
				$tot_toko_on_area = 0;
				foreach ($data as $key => $value){
					
					$Toko["TOT_TOKO"] = $tot_toko_on_area++;
					if($value->LATITUDE != null){
						$Toko["ON_KOOR"] = $on_koor++;
					} else {
						$Toko["OFF_KOOR"] = $off_koor++;
					}
					
					$Toko["KD_CUSTOMER"] = $value->KD_CUSTOMER;
					$Toko["NAMA_TOKO"] = $value->NAMA_TOKO;
					$Toko["PEMILIK"] = $value->NAMA_PEMILIK;
					$Toko["TELP_TOKO"] = $value->TELP_TOKO;
					$Toko["ID_AREA"] = $value->ID_AREA;
					$Toko["AREA"] = $value->NAMA_AREA;
					$Toko["ALAMAT"] = $value->ALAMAT;
					$Toko["NAMA_KECAMATAN"] = $value->NAMA_KECAMATAN;
					$Toko["NAMA_DISTRIK"] = $value->NAMA_DISTRIK;
					$Toko["NAMA_PROVINSI"] = $value->NAMA_PROVINSI;
					$Toko["LATITUDE"] = $value->LATITUDE;
					$Toko["LONGITUDE"] = $value->LONGITUDE;
					$Toko["NAMA_DISTRIBUTOR"] = $value->NAMA_DISTRIBUTOR;
					$Toko["SALES"] = $value->NAMA;
					$Toko["KUNJUNGAN"] = $value->JML_TOKO_DIKUNJUNGI_BULANAN;
					$Toko["BULAN"] = $bulan;
					$Toko["TAHUN"] = $tahun;
					if($value->JML_TOKO_DIKUNJUNGI_BULANAN == "0"){
						$marker = "BLACK";
						$Toko["OFF_JADWAL"] = $a++;
					} else {
						$marker = "RED";
						$Toko["ON_JADWAL"] = $b++;
					}
					$Toko["MARKER"] = $marker;
					$Toko["TOT_TOKO"] = $tot_toko_on_area;
					$Toko["ON_KOOR"] = $on_koor;
					$Toko["OFF_KOOR"] = $off_koor;
					$Toko["OFF_JADWAL"] = $a;
					$Toko["ON_JADWAL"] = $b;
					$json[] = $Toko;
				}
				echo json_encode($json);
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Toko Tidak Ada"));
			}
		}
		*/
		
		public function jadwalKunjunganToko(){
			$id_toko 		= $this->input->post("toko");
			$bulan		 	= $this->input->post("bulan");
			$tahun			= $this->input->post("tahun");
			
			if($bulan < 10){
				$bulan = '0'.$bulan;
			}
			
			$jadwal = $this->PTM->jadwalKunjungan($id_toko, $bulan, $tahun);
			if(count($jadwal) > 0){
				echo json_encode(array("status" => "success", "data" => $jadwal));
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Tidak Ada"));
			}
		}
		
		
		public function petaTokoTso(){
			$jenis_user     = $this->session->userdata('id_jenis_user');
			
			$id_user 		= $this->session->userdata('user_id');
			$bulan		 	= $this->input->post("bulan");
			$tahun			= $this->input->post("tahun");
			//$area			= $this->input->post("area");
			
			if($bulan < 10){
				$bulan = '0'.$bulan;
			}
			
			$data = $this->PTM->TokoTsopdPeta($id_user, $bulan, $tahun);
			
			if($data){
				$a = 0; $b = 0;
				$on_koor = 0;
				$off_koor = 0;
				$tot_toko_on_area = 0;
				foreach ($data as $key => $value){
					
					$Toko["TOT_TOKO"] = $tot_toko_on_area++;
					if($value->LATITUDE != null){
						$Toko["ON_KOOR"] = $on_koor++;
					} else {
						$Toko["OFF_KOOR"] = $off_koor++;
					} 
					
					$Toko["KD_CUSTOMER"] = $value->ID_CUSTOMER;
					$Toko["NAMA_TOKO"] = $value->NAMA_TOKO;
					$Toko["PEMILIK"] = $value->NAMA_PEMILIK;
					$Toko["TELP_TOKO"] = $value->TELP_TOKO;
					$Toko["ID_AREA"] = $value->ID_AREA;
					$Toko["AREA"] = $value->NAMA_AREA;
					$Toko["ALAMAT"] = $value->ALAMAT;
					$Toko["NAMA_KECAMATAN"] = $value->NAMA_KECAMATAN;
					$Toko["NAMA_DISTRIK"] = $value->NAMA_DISTRIK;
					$Toko["NAMA_PROVINSI"] = $value->NAMA_PROVINSI;
					$Toko["LATITUDE"] = $value->LATITUDE;
					$Toko["LONGITUDE"] = $value->LONGITUDE;
					$Toko["NAMA_DISTRIBUTOR"] = $value->NAMA_DISTRIBUTOR;
					$Toko["SALES"] = $value->NAMA;
					$Toko["KUNJUNGAN"] = $value->JML_TOKO_DIKUNJUNGI_BULANAN;
					$Toko["BULAN"] = $bulan;
					$Toko["TAHUN"] = $tahun;
					if($value->JML_TOKO_DIKUNJUNGI_BULANAN == "0"){
						$marker = "BLACK";
						//$Toko["OFF_JADWAL"] = 
						$a++;
					} else {
						$marker = "RED";
						//$Toko["ON_JADWAL"] = 
						$b++;
					}
					$Toko["MARKER"] = $marker;
					$Toko["TOT_TOKO"] = $tot_toko_on_area;
					$Toko["ON_KOOR"] = $on_koor;
					$Toko["OFF_KOOR"] = $off_koor;
					$Toko["OFF_JADWAL"] = $a;
					$Toko["ON_JADWAL"] = $b;
					$json[] = $Toko;
				}
				echo json_encode($json);
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Toko Tidak Ada"));
			}
		}
		
		public function petaTokoBaru(){
			//$jenis_user     = $this->session->userdata('id_jenis_user');
			
			$id_user 		= $this->input->post("tso");
			$bulan		 	= $this->input->post("bulan");
			$tahun			= $this->input->post("tahun");
			//$area			= $this->input->post("area");
			
			//if($bulan < 10){
				//$bulan = '0'.$bulan;
			//}
			
			$data = $this->PTM->TokoTsopdPeta($id_user, $bulan, $tahun);
			
			if($data){
				$a = 0; $b = 0;
				$on_koor = 0;
				$off_koor = 0;
				$tot_toko_on_area = 0;
				foreach ($data as $key => $value){
					
					$Toko["TOT_TOKO"] = $tot_toko_on_area++;
					if($value->LATITUDE != null){
						$Toko["ON_KOOR"] = $on_koor++;
					} else {
						$Toko["OFF_KOOR"] = $off_koor++;
					} 
					
					$Toko["KD_CUSTOMER"] = $value->ID_CUSTOMER;
					$Toko["NAMA_TOKO"] = $value->NAMA_TOKO;
					$Toko["PEMILIK"] = $value->NAMA_PEMILIK;
					$Toko["TELP_TOKO"] = $value->TELP_TOKO;
					$Toko["ID_AREA"] = $value->ID_AREA;
					$Toko["AREA"] = $value->NAMA_AREA;
					$Toko["ALAMAT"] = $value->ALAMAT;
					$Toko["NAMA_KECAMATAN"] = $value->NAMA_KECAMATAN;
					$Toko["NAMA_DISTRIK"] = $value->NAMA_DISTRIK;
					$Toko["NAMA_PROVINSI"] = $value->NAMA_PROVINSI;
					$Toko["LATITUDE"] = $value->LATITUDE;
					$Toko["LONGITUDE"] = $value->LONGITUDE;
					$Toko["NAMA_DISTRIBUTOR"] = $value->NAMA_DISTRIBUTOR;
					$Toko["SALES"] = $value->NAMA;
					$Toko["KUNJUNGAN"] = $value->JML_TOKO_DIKUNJUNGI_BULANAN;
					$Toko["BULAN"] = $bulan;
					$Toko["TAHUN"] = $tahun;
					if($value->JML_TOKO_DIKUNJUNGI_BULANAN == "0"){
						$marker = "BLACK";
						//$Toko["OFF_JADWAL"] =
						$a++;
					} else {
						$marker = "RED";
						// $Toko["ON_JADWAL"] = 
						$b++;
					}
					$Toko["MARKER"] = $marker;
					$Toko["TOT_TOKO"] = $tot_toko_on_area;
					$Toko["ON_KOOR"] = $on_koor;
					$Toko["OFF_KOOR"] = $off_koor;
					$Toko["OFF_JADWAL"] = $a;
					$Toko["ON_JADWAL"] = $b;
					$json[] = $Toko;
				}
				echo json_encode($json);
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Toko Tidak Ada"));
			}
		}
		
		
	}


?>