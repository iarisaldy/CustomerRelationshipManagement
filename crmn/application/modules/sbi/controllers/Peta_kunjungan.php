<?php
	class Peta_kunjungan extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Peta_kunjungan_model");
		}

		public function index(){
			$data = array("title" => "Dashboard CRM Administrator");
			
			// gsm = 1016, rsm = 1010, asm = 1011, tso = 1012
			
			$jenis_user     = $this->session->userdata('id_jenis_user');
			$id_user 		= $this->session->userdata('user_id');
			
			
			
			//$this->template->display('Peta_kunjungan_view_tso', $data);
			
			if($jenis_user == 1016){		
				$data['tso'] = $this->Peta_kunjungan_model->listTsoGsm($id_user); 
				$i = 1;
				foreach($data['tso'] as $tso){
					if($i == 1){
						$data['id_tso_1'] = $tso['ID_SO'];
						$data['nm_tso_1'] = $tso['NAMA_SO'];
					}
					$i++;
				}
				$this->template->display('Peta_kunjungan_view_all', $data);
			} else if($jenis_user == 1010){
				$data['tso'] = $this->Peta_kunjungan_model->listTsoSsm($id_user); 
				$i = 1;
				foreach($data['tso'] as $tso){
					if($i == 1){
						$data['id_tso_1'] = $tso['ID_SO'];
						$data['nm_tso_1'] = $tso['NAMA_SO'];
					}
					$i++;
				}
				$this->template->display('Peta_kunjungan_view_all', $data);
			} else if($jenis_user == 1011){
				$data['tso'] = $this->Peta_kunjungan_model->listTsoSm($id_user); 
				$i = 1;
				foreach($data['tso'] as $tso){
					if($i == 1){
						$data['id_tso_1'] = $tso['ID_SO'];
						$data['nm_tso_1'] = $tso['NAMA_SO'];
					}
					$i++;
				}
				$this->template->display('Peta_kunjungan_view_all', $data);
			} else if($jenis_user == 1012){
				$this->template->display('Peta_kunjungan_view_tso', $data);
			} else if ($jenis_user == 1009){
				$data['tso'] = $this->Peta_kunjungan_model->listTsoAdmin($id_user); 
				$i = 1;
				foreach($data['tso'] as $tso){
					if($i == 1){
						$data['id_tso_1'] = $tso['ID_SO'];
						$data['nm_tso_1'] = $tso['NAMA_SO'];
					}
					$i++;
				}
				$this->template->display('Peta_kunjungan_view_all', $data);
			}
			
			
		}
		
		public function jadwalKunjunganToko(){
			$id_customer 	= $this->input->post("toko");
			$stardate		= $this->input->post("stardate");
			$enddate		= $this->input->post("enddate");
			
			$jadwal = $this->Peta_kunjungan_model->jadwalKunjungan($id_customer, $stardate, $enddate);
			if($jadwal){
				echo json_encode(array("status" => "success", "data" => $jadwal));
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Tidak Ada"));
			}
		}
		
		public function dataSurvey(){
			$id_survey 		= $this->input->post("survey");
			
			$jadwal = $this->Peta_kunjungan_model->Data_Survey($id_survey);
			if($jadwal){
				echo json_encode(array("status" => "success", "data" => $jadwal));
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Tidak Ada"));
			}
		}
		
		public function petaTokoTso(){
			$id_tso			= $this->session->userdata('user_id');
			$stardate		= $this->input->post("stardate");
			$enddate		= $this->input->post("enddate");
			
			
			$data = $this->Peta_kunjungan_model->petaTokoTso($id_tso, $stardate, $enddate);
			$toko_jml = $this->Peta_kunjungan_model->TotalToko($id_tso);
			//$kunjungan_jml = $this->Peta_kunjungan_model->TotalKunjungan($id_tso, $stardate, $enddate);
			
			if($data){
				$a = 0; $b = 0; $c =0; $d=0;
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
					$Toko["ID_KUNJUNGAN_CUSTOMER"] = $value->ID_KUNJUNGAN_CUSTOMER;
					$Toko["NAMA_DISTRIBUTOR"] = $value->NAMA_DISTRIBUTOR;
					$Toko["SALES"] = $value->NAMA;
					$Toko["RENCANA"] = $value->RENCANA;
					$Toko["KUNJUNGAN"] = $value->KUNJUNGAN;
					$Toko["KAPASITAS_ZAK"] = $value->KAPASITAS_ZAK;
					
					$s  = strtotime($value->KUNJUNGAN);
                    $e  = time(date('Y-m-d'));
                    $i  = $s-$e;
					$inter = floor($i / (60 * 60 * 24));
					
					if($value->KUNJUNGAN != NULL){
					if($inter == -3 || $inter == -2 || $inter == -1){
						$marker = "GREEN";
						$Toko["DIKUNJUNGI 1-3 HARI"] = $a++;
					} else if($inter == -4 || $inter == -5 || $inter == -6 || $inter == -7){
						$marker = "YELLO";
						$Toko["DIKUNJUNGI 3-7 HARI"] = $b++;
					}else{
						$marker = "RED";
						$Toko["DIKUNJUNGI 7-14 HARI"] = $c++;
					}	
					}else{
						$marker = "BLACK";
						$Toko["OFF_JADWAL"] = $d++;
					}
					
					$Toko["MARKER"] = $marker;
					$Toko["TOT_TOKO"] = $tot_toko_on_area;
					$Toko["ON_KOOR"] = $on_koor;
					$Toko["OFF_KOOR"] = $off_koor;
					$Toko["JUMLAH_TOKO"] = $toko_jml[0]->JML;
					$Toko["JUMLAH_KUNJUNGAN"] = ($a+$b+$c); //$kunjungan_jml[0]->KUNJUNGAN;
					$Toko["A"] = $a;
					$Toko["B"] = $b;
					$Toko["C"] = $c;
					$Toko["OFF_JADWAL"] = $d;
					$json[] = $Toko;
				}
				echo json_encode($json);
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Toko Tidak Ada"));
			}
		}
		
		
		// ---> New
		
		public function petaTokoKunjungan(){
			$id_tso			= $this->input->post("id_tso");
			$stardate		= $this->input->post("stardate");
			$enddate		= $this->input->post("enddate");
			
			
			$data = $this->Peta_kunjungan_model->petaTokoTso($id_tso, $stardate, $enddate);
			$toko_jml = $this->Peta_kunjungan_model->TotalToko($id_tso);
			//$kunjungan_jml = $this->Peta_kunjungan_model->TotalKunjungan($id_tso, $stardate, $enddate);
			
			if($data){
				$a = 0; $b = 0; $c =0; $d=0;
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
					$Toko["ID_KUNJUNGAN_CUSTOMER"] = $value->ID_KUNJUNGAN_CUSTOMER;
					$Toko["NAMA_DISTRIBUTOR"] = $value->NAMA_DISTRIBUTOR;
					$Toko["SALES"] = $value->NAMA;
					$Toko["RENCANA"] = $value->RENCANA;
					$Toko["KUNJUNGAN"] = $value->KUNJUNGAN;
					$Toko["KAPASITAS_ZAK"] = $value->KAPASITAS_ZAK;
					
					$s  = strtotime($value->KUNJUNGAN);
                    $e  = time(date('Y-m-d'));
                    $i  = $s-$e;
					$inter = floor($i / (60 * 60 * 24));
					
					if($value->KUNJUNGAN != NULL){
					if($inter == -3 || $inter == -2 || $inter == -1){
						$marker = "GREEN";
						$Toko["DIKUNJUNGI 1-3 HARI"] = $a++;
					} else if($inter == -4 || $inter == -5 || $inter == -6 || $inter == -7){
						$marker = "YELLO";
						$Toko["DIKUNJUNGI 3-7 HARI"] = $b++;
					}else{
						$marker = "RED";
						$Toko["DIKUNJUNGI 7-14 HARI"] = $c++;
					}	
					}else{
						$marker = "BLACK";
						$Toko["OFF_JADWAL"] = $d++;
					}
					
					$Toko["MARKER"] = $marker;
					$Toko["TOT_TOKO"] = $tot_toko_on_area;
					$Toko["ON_KOOR"] = $on_koor;
					$Toko["OFF_KOOR"] = $off_koor;
					$Toko["JUMLAH_TOKO"] = $toko_jml[0]->JML;
					$Toko["JUMLAH_KUNJUNGAN"] = ($a+$b+$c); //$kunjungan_jml[0]->KUNJUNGAN;
					$Toko["A"] = $a;
					$Toko["B"] = $b;
					$Toko["C"] = $c;
					$Toko["OFF_JADWAL"] = $d;
					$json[] = $Toko;
				}
				echo json_encode($json);
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Toko Tidak Ada"));
			}
		}
		
	}


?>