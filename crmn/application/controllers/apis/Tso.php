<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Tso extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_tso', "TSO");
        }
		
		public function listSales_post(){ //old gak dipakai
			$tso = $this->post("id_tso");
			$hasil = $this->TSO->get_sales($tso);
			
			//print_r($hasil);
			//exit;
			
			if(count($hasil) != 0){
				 foreach ($hasil as $hasilKey => $hasilValue) {
                    $data['id_sales'] = $hasilValue->ID_SALES;
                    $data['nama_sales'] = $hasilValue->NAMA;

                    $json[] = $data;
                }
                $response = array("status" => "success", "total" => count($hasil), "data" => $json);
            } else {
                $response = array("status" => "error", "message" => "Data Sales tidak ditemukan");
            }
			 $this->response($response);
		}
		
		public function listCustomer_post(){
			$tso = $this->post("id_tso");
			$hasil = $this->TSO->get_customer($tso);
			
			if(count($hasil) != 0){
				 foreach ($hasil as $hasilKey => $hasilValue) {
                    $data['id_customer'] = $hasilValue->KD_CUSTOMER;
                    $data['nama_toko'] = $hasilValue->NAMA_TOKO;
					$data['alamat'] = $hasilValue->ALAMAT.' - '.$hasilValue->NAMA_DISTRIK.' - '.$hasilValue->NAMA_PROVINSI;
					$data['area'] = $hasilValue->NAMA_AREA;
					
                    $json[] = $data;
                }
                $response = array("status" => "success", "total" => count($hasil), "data" => $json);
            } else {
                $response = array("status" => "error", "message" => "Data Customer tidak ditemukan");
            }
			 $this->response($response);
			
		}
		
		public function listKunjunganSales_post(){
			$tso = $this->post("id_tso");
			$tanggal = null;
			if(isset($_POST['tanggal'])){
				$tanggal = $_POST['tanggal'];
			};
			
			$hasil = $this->TSO->listKunjunganSales($tso, $tanggal);
			
			if(count($hasil) != 0){
				 foreach ($hasil as $Key => $Value) {
					$statusVisitSales = 'UNVISITED';
					if($Value['CHECKIN_TIME'] != null){
						$statusVisitSales = 'VISITED';
					}
					$statusVisitTso = 'ON';
					if($Value['ID_KUNJUNGAN_SALES'] != null and $Value['APPROVAL_SALES'] != null){
						$statusVisitTso = 'COMPLETED';
					} elseif($Value['ID_KUNJUNGAN_SALES'] != null){
						$statusVisitTso = 'WAITING APPROVAL';
					}
					
					$data['KD_KUNJUNGAN'] = $Value['ID_KUNJUNGAN_CUSTOMER'];
					$data['TGL_KUNJUNGAN'] = $Value['TGL_RENCANA_KUNJUNGAN'];
					$data['ID_SALES'] = $Value['ID_USER'];
					$data['NAMA_SALES'] = $Value['NAMA_USER'];
					$data['ID_TOKO'] = $Value['ID_TOKO'];
					$data['NAMA_TOKO'] = $Value['NAMA_TOKO'];
					$data['ALAMAT'] = $Value['ALAMAT'].' - '.$Value['NAMA_KECAMATAN'].' - '.$Value['NAMA_DISTRIK'];
					$data['TELP'] = $Value['TELP_TOKO'];
					$data['PEMILIK'] = $Value['NAMA_PEMILIK'];
					$data['ID_DISTRIBUTOR'] = $Value['KODE_DISTRIBUTOR'];
					$data['NAMA_DISTRIBUTOR'] = $Value['NAMA_DISTRIBUTOR'];
					$data['STATUS_KUNJUNGAN_SALES'] = $statusVisitSales;
					$data['STATUS_VISIT_TSO'] = $statusVisitTso;
		
                    $json[] = $data; //$Value;
                }
                $response = array("status" => "success", "total" => count($hasil), "data" => $json);
            } else {
                $response = array("status" => "error", "message" => "Data Kunjungan Sales tidak ditemukan");
            }
			 $this->response($response);
		}
		
		public function Visiting_post(){
			$id_tso = $this->input->post("id_tso");
			$data = json_decode($_POST['visit'], true);
			
			$hasil = $this->TSO->Simpan_visiting($id_tso, $data);
			
			if($hasil > 0){
				$response = array("status" => "success", "message" => 'Data Berhasil Disimpan', "total" => count($hasil), "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Disimpan', "total" => count($hasil), "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function VisitingSatu_post(){
			$input = json_decode(file_get_contents("php://input"));
			$data = json_decode(json_encode($input), true);
			
			$data_in = array();
			$data_in[0]['ID_SALES'] = $data['ID_SALES'];
			$data_in[0]['ID_CUSTOMER'] = $data['ID_CUSTOMER'];
			$data_in[0]['KD_DISTRIBUTOR'] = $data['KD_DISTRIBUTOR'];
			$data_in[0]['ID_KUNJUNGAN_SALES'] = $data['ID_KUNJUNGAN_CUSTOMER'];
			$data_in[0]['TGL_VISIT_TSO'] = $data['TGL_VISIT_TSO']; 
			$data_in[0]['KESIMPULAN'] = $data['KESIMPULAN'];
			$data_in[0]['APPROVAL_SALES'] = $data['APPROVAL_SALES'];
			$data_in[0]['APPROVAL_AT_SALES'] = $data['APPROVAL_AT_SALES'];
			
			$hasil = $this->TSO->Simpan_visiting($data['ID_TSO'], $data_in, 1);
			
			$obj_hasil = (object)$hasil;
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Disimpan', "data" => $obj_hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Disimpan', "data" => $obj_hasil);
			}
			
			$object = (object)$response;
			$this->response($object);
		}
		
		public function VisitingOne_post(){
			$id_tso = $this->input->post("ID_TSO");
			
			$id_sales = null;
			if(isset($_POST['ID_SALES'])){
				$id_sales = $_POST['ID_SALES'];
			}
			
			$id_customer = null;
			if(isset($_POST['ID_CUSTOMER'])){
				$id_customer = $_POST['ID_CUSTOMER'];
			}
			
			$kd_distributor = null;
			if(isset($_POST['KD_DISTRIBUTOR'])){
				$kd_distributor = $_POST['KD_DISTRIBUTOR'];
			}
			
			$id_kunjungan_sales	 = $this->input->post("ID_KUNJUNGAN_CUSTOMER");
			$tgl_visit_tso	 	 = $this->input->post("TGL_VISIT_TSO");
			$kesimpulan			 = $this->input->post("KESIMPULAN");
			$approval_sales		 = $this->input->post("APPROVAL_SALES");
			$approval_at_sales 	 = $this->input->post("APPROVAL_AT_SALES");
			
			$data_in = array();
			
			$data_in[0]['ID_SALES'] = $id_sales;
			$data_in[0]['ID_CUSTOMER'] = $id_customer;
			$data_in[0]['KD_DISTRIBUTOR'] = $kd_distributor;
			$data_in[0]['ID_KUNJUNGAN_SALES'] = $id_kunjungan_sales;
			$data_in[0]['TGL_VISIT_TSO'] = $tgl_visit_tso; 
			$data_in[0]['KESIMPULAN'] = $kesimpulan;
			$data_in[0]['APPROVAL_SALES'] = $approval_sales;
			$data_in[0]['APPROVAL_AT_SALES'] = $approval_at_sales;
			
			$hasil = $this->TSO->Simpan_visiting($id_tso, $data_in, 1);
			
			$obj_hasil = (object)$hasil;
			
			if($hasil){
				$response = array("status" => "success", "message" => 'Data Berhasil Disimpan', "data" => $obj_hasil);
			} else {
				$response = array("status" => "success", "message" => 'Data Gagal Disimpan', "data" => $obj_hasil);
			}
			
			$object = (object)$response;
			$this->response($object);
		}
		
		public function UpdateVisiting_post(){
			$id_tso = $this->input->post("id_tso");
			$data = json_decode($_POST['data'], true);
			
			$hasil = $this->TSO->Update_visiting($id_tso, $data);
			
			if($hasil > 0){
				$response = array("status" => "success", "message" => 'Update Visiting Berhasil Disimpan', "total" => count($hasil), "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Update Visiting Gagal Disimpan', "total" => count($hasil), "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function Pertanyaan_get(){ 
			$pertanyaan = $this->TSO->List_pertanyaan();
			
			if(count($pertanyaan) != 0){
				foreach ($pertanyaan as $Key => $Value) {
					
					$data['id_pertanyaan'] 		 = $Value['ID_PERTANYAAN'];
					$data['pertanyaan'] 		 = $Value['NM_PERTANYAAN'];
					$data['id_jenis_pertanyaan'] = $Value['ID_JENIS_PENILAIAN'];
					$data['jenis_pertanyaan'] 	 = $Value['NM_JENIS_PENILAIAN'];
					$data['opsi_jawaban'] 		 = $this->TSO->List_jawaban($Value['ID_PERTANYAAN']);
					
					$json[] = $data;
				}
				$response = array("status" => "success", "total" => count($pertanyaan), "data" => $json);
			} else {
				$response = array("status" => "error", "message" => "Data Customer tidak ditemukan");
			}
			$this->response($response);
		}
		
		public function Penilaian_post(){
			$id_tso = $this->input->post("id_tso");
			$data = json_decode($_POST['penilaian'], true);
			
			$hasil = $this->TSO->Simpan_penilaian($id_tso, $data);
			
			if($hasil > 0){
				$response = array("status" => "success", "message" => 'Penilaian Berhasil Disimpan', "total" => count($hasil), "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Penilaian Gagal Disimpan', "total" => count($hasil), "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function UpdatePenilaian_post(){
			$id_tso = $this->input->post("id_tso");
			$data = json_decode($_POST['penilaian'], true);
			
			$hasil = $this->TSO->Update_penilaian($id_tso, $data);
			
			if($hasil > 0){
				$response = array("status" => "success", "message" => 'Update Penilaian Berhasil Disimpan', "total" => count($hasil), "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Update Penilaian Gagal Disimpan', "total" => count($hasil), "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function Kesimpulan_post(){
			$data = json_decode($_POST['kesimpulan'], true);
			
			$hasil = $this->TSO->Simpan_kesimpulan($data);
			
			if($hasil > 0){
				$response = array("status" => "success", "data" => $hasil, "message" => 'Kesimpulan Berhasil Disimpan');
			} else {
				$response = array("status" => "success", "data" => $hasil, "message" => 'Kesimpulan Gagal Disimpan');
			}
			$this->response($response);
		}
		
		public function Foto_post(){
			$id_tso 		= $this->input->post("id_tso");
			//$id_kunjungan 	= $this->input->post("id_kunjungan_sales");
			$no_visit		= $this->input->post("no_visit");
			$foto 			= $_FILES["foto"]['tmp_name'];
			$nama 			= $no_visit.'_'.$_FILES["foto"]['name'];
			
			$at_apps		= $this->input->post("create_at_apps");
			
			
			//Pemindahan File
			$target_file = 'assets/Visit_tso/';
			$path_file = $target_file. $nama; 
			
			$status_uploads = 0;
			
			if (file_exists($path_file)) {
				$pesan = "File Sudah Ada";
				$get_data = $this->TSO->get_foto_survey_byPath($no_visit, $path_file);
				$response = array("status" => "success", "pesan" => $pesan, "data" => $get_data);
			} else {
				move_uploaded_file($foto, $path_file);
				$simpan = $this->TSO->Simpan_foto($id_tso, $no_visit, $path_file, $at_apps);
				$pesan = "File Tersimpan";
				$response = array("status" => "success", "pesan" => $pesan, "data" => $simpan); 
			}
			$this->response($response);
		}
		
		public function getFoto_post(){
			$id_tso = $this->input->post("id_tso");
			$limit 	= $this->input->post("limit");
			
			$get_data = $this->TSO->get_foto_survey($id_tso, $limit);
			$response = array("status" => "success", "total" => count($get_data), "data" => $get_data);
			$this->response($response);
		}
		
		public function delFoto_post(){
			$id_tso 		= $this->input->post("id_tso");
			$datasIdFoto 	= $this->input->post("data");
			
			$get_fotoExist = $this->TSO->get_foto_survey_inId($datasIdFoto);
			foreach($get_fotoExist as $data_in){
				$img = explode('/',$data_in['PATH_FOTO']);
				
				// print_r($img);
				// exit();
				
				$set_path_new = "assets/Foto_del_Visit_tso/".$img[2];
				do {
					//unlink();
					rename($data_in['PATH_FOTO'], $set_path_new); 
				} while (file_exists($data_in['PATH_FOTO']));
			}
			
			$set_Del_data = $this->TSO->Del_foto_survey($id_tso, $datasIdFoto);
			
			if($set_Del_data != 0){
				$response = array("status" => "success", "total data dihapus" => count($get_fotoExist));
			} else {
				$response = array("status" => "success", "total data dihapus" => 0);
			}
			$this->response($response);
		}
		
		public function Approval_sales(){
			
		}
		
		public function Report_post(){
			$id_tso  = $this->input->post("id_tso");
			
			$tanggal = null;
			if(isset($_POST['tanggal'])){
				$tanggal = $_POST['tanggal'];
			};
			
			$hasil = $this->TSO->Report_visit($id_tso, $tanggal);
			
			if(count($hasil) != 0){
				 foreach ($hasil as $Key => $Value) {
					
					$statusVisitTso = 'ON';
					if($Value['ID_KUNJUNGAN_SALES'] != null and $Value['APPROVAL_SALES'] != null){
						$statusVisitTso = 'COMPLETED';
					} elseif($Value['ID_KUNJUNGAN_SALES'] != null){
						$statusVisitTso = 'WAITING APPROVAL';
					}
					
					$data['KD_KUNJUNGAN'] 			= $Value['ID_KUNJUNGAN_CUSTOMER'];
					$data['TGL_KUNJUNGAN_TSO'] 		= $Value['TGL_KUNJUNGAN_TSO'];
					$data['NO_VISIT']				= $Value['NO_VISIT'];
					$data['ID_SALES'] 				= $Value['ID_USER'];
					$data['NAMA_SALES'] 			= $Value['NAMA_USER'];
					$data['ID_TOKO'] 				= $Value['ID_TOKO'];
					$data['NAMA_TOKO'] 				= $Value['NAMA_TOKO'];
					$data['ALAMAT'] 				= $Value['ALAMAT'].' - '.$Value['NAMA_KECAMATAN'].' - '.$Value['NAMA_DISTRIK'];
					$data['TELP'] 					= $Value['TELP_TOKO'];
					$data['PEMILIK'] 				= $Value['NAMA_PEMILIK'];
					$data['ID_DISTRIBUTOR'] 		= $Value['KODE_DISTRIBUTOR'];
					$data['NAMA_DISTRIBUTOR'] 		= $Value['NAMA_DISTRIBUTOR'];
					$data['PENILAIAN']				= $this->TSO->List_penilaian($Value['ID_KUNJUNGAN_CUSTOMER']);
					$data['FOTO']					= $this->TSO->List_foto($Value['ID_KUNJUNGAN_CUSTOMER']);
					$data['KESIMPULAN']				= $Value['KESIMPULAN'];
					$data['STATUS_VISIT_TSO'] 		= $statusVisitTso;
		
                    $json[] = $data; //$Value;
                }
                $response = array("status" => "success", "total" => count($hasil), "data" => $json);
            } else {
                $response = array("status" => "error", "message" => "Data Kunjungan Tso tidak ditemukan");
            }
			 $this->response($response);
		}
		
		public function getSalesTso_post(){
			$id_tso  = $this->input->post("id_tso");
			$hasil = $this->TSO->get_sales_tso($id_tso);
			
			if(count($hasil) != 0){
				 foreach ($hasil as $hasilKey => $hasilValue) {
                    $data['ID_SALES'] = $hasilValue->ID_SALES;
                    $data['NAMA_SALES'] = $hasilValue->NAMA_SALES;
					$data['ID_DISTRIBUTOR'] = $hasilValue->KODE_DISTRIBUTOR;
					$data['NAMA_DISTRIBUTOR'] = $hasilValue->NAMA_DISTRIBUTOR;
					
                    $json[] = $data;
                }
                $response = array("status" => "success", "total" => count($hasil), "data" => $json);
            } else {
                $response = array("status" => "error", "total" => count($hasil), "data" => $json);
            }
			 $this->response($response);
		}
		
		public function getCustomerTso_post(){
			$id_tso  = $this->input->post("id_tso");
			
			$start = null;
			if($this->input->post('start') != null){
				$start = $this->input->post('start');
			};
			
			$limit = null;
			if($this->input->post('limit') != null){
				$limit = $this->input->post('limit');
			};
			
			$hasil 	 = $this->TSO->get_toko_tso($id_tso, $start, $limit);
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		
		public function OpsionalJawabanSurveySales_get(){
			$hasil 	 = $this->TSO->Opsional_Jawaban_Survey_Sales();
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		
		public function PertanyaanSurveySales_get(){
			$hasil 	 = $this->TSO->Pertanyaan_Survey_Sales();
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		
		public function JenisPertanyaanSurveySales_get(){
			$hasil 	 = $this->TSO->Jenis_Pertanyaan_Survey_Sales();
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		
		public function HasilPenilaianSurveySales_post(){
			$id_tso  = $this->input->post("id_tso");
			
			$hasil 	 = $this->TSO->Hasil_Penilaian_Survey_Sales($id_tso);
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		
		public function SoVisit_post(){
			$id_tso  = $this->input->post("id_tso");
			
			$hasil 	 = $this->TSO->So_Visit($id_tso);
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		
		public function HasilAssessmentSales_post(){
			$id_tso  = $this->input->post("id_user");
			$limit  = $this->input->post("limit");
			
			$hasil 	 = $this->TSO->Hasil_Penilaian($id_tso, $limit);
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		// ============================================= fauzan Start
		public function HasilAssessment_post(){
			$id_sales  = $this->input->post("id_sales");
			$limit  = $this->input->post("limit");
			
			$hasil 	 = $this->TSO->Hasil_Penilaian_Sales($id_sales, $limit);
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		// ============================================= fauzan End
		public function coachingVisit_post(){
			$id_tso  = $this->input->post("id_user");
			$limit  = $this->input->post("limit");
			
			$hasil 	 = $this->TSO->Coaching_Visit($id_tso, $limit);
			
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		public function coachingVisitSales_post(){
			$id_sales = $this->input->post("id_sales");
			$limit  = $this->input->post("limit");
			
			$hasil 	 = $this->TSO->Coaching_Visit_sales($id_sales, $limit);
			
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		
		public function getSalesTsoNew_post(){
			$id_tso  = $this->input->post("id_user");
			$hasil = $this->TSO->get_sales_tso($id_tso);
			
			if(count($hasil) != 0){
				 foreach ($hasil as $hasilKey => $hasilValue) {
                    $data['ID_SALES'] = $hasilValue->ID_SALES;
                    $data['NAMA_SALES'] = $hasilValue->NAMA_SALES;
					$data['ID_DISTRIBUTOR'] = $hasilValue->KODE_DISTRIBUTOR;
					$data['NAMA_DISTRIBUTOR'] = $hasilValue->NAMA_DISTRIBUTOR;
					
                    $json[] = $data;
                }
                $response = array("status" => "success", "total" => count($hasil), "data" => $json);
            } else {
                $response = array("status" => "error", "total" => count($hasil), "data" => []);
            }
			 $this->response($response);
		}
		
		public function listVisitSales_post(){
			$tso = $this->post("id_user");
			$tglStart = null;
			$tglEnd = null;
			if(isset($_POST['tanggal_start'])){
				$tglStart = $_POST['tanggal_start'];
			};
			if(isset($_POST['tanggal_end'])){
				$tglEnd = $_POST['tanggal_end'];
			};
			
			$hasil = $this->TSO->listVisitSales($tso, $tglStart, $tglEnd);
			
			if(count($hasil) != 0){
				 foreach ($hasil as $Key => $Value) {
					$statusVisitSales = 'UNVISITED';
					if($Value['CHECKIN_TIME'] != null){
						$statusVisitSales = 'VISITED';
					}
					$statusVisitTso = 'ON';
					if($Value['ID_KUNJUNGAN_SALES'] != null and $Value['APPROVAL_SALES'] != null){
						$statusVisitTso = 'COMPLETED';
					} elseif($Value['ID_KUNJUNGAN_SALES'] != null){
						$statusVisitTso = 'WAITING APPROVAL';
					}
					
					$data['KD_KUNJUNGAN'] = $Value['ID_KUNJUNGAN_CUSTOMER'];
					$data['TGL_KUNJUNGAN'] = $Value['TGL_RENCANA_KUNJUNGAN'];
					$data['ID_SALES'] = $Value['ID_USER'];
					$data['NAMA_SALES'] = $Value['NAMA_USER'];
					$data['ID_TOKO'] = $Value['ID_TOKO'];
					$data['NAMA_TOKO'] = $Value['NAMA_TOKO'];
					$data['ALAMAT'] = $Value['ALAMAT'].' - '.$Value['NAMA_KECAMATAN'].' - '.$Value['NAMA_DISTRIK'];
					$data['TELP'] = $Value['TELP_TOKO'];
					$data['PEMILIK'] = $Value['NAMA_PEMILIK'];
					$data['ID_DISTRIBUTOR'] = $Value['KODE_DISTRIBUTOR'];
					$data['NAMA_DISTRIBUTOR'] = $Value['NAMA_DISTRIBUTOR'];
					$data['ALASAN_KUNJUNGAN'] = $Value['ALASAN_KUNJUNGAN'];
					$data['ORDER_SEMEN'] = $Value['ORDER_SEMEN'];
					$data['FLAG_UNPLANNED'] = $Value['FLAG_UNPLANNED'];
					$data['FLAG_TIDAK_ORDER'] = $Value['FLAG_TIDAK_ORDER'];
					$data['STATUS_KUNJUNGAN_SALES'] = $statusVisitSales;
					$data['STATUS_VISIT_TSO'] = $statusVisitTso;
		
                    $json[] = $data; //$Value;
                }
                $response = array("status" => "success", "total" => count($hasil), "data" => $json);
            } else {
                $response = array("status" => "error", "message" => "Data Kunjungan Sales tidak ditemukan");
            }
			 $this->response($response);
		}
		
		public function getFotoAssessment_post(){
			$id_tso = $this->input->post("id_user");
			$limit 	= $this->input->post("limit");
			
			$get_data = $this->TSO->get_foto_survey($id_tso, $limit);
			$response = array("status" => "success", "total" => count($get_data), "data" => $get_data);
			$this->response($response);
		}
		// ================================== Fauzan
		public function getFotoAssessmentSales_post(){
			$id_sales = $this->input->post("id_sales");
			$limit 	= $this->input->post("limit");
			
			$get_data = $this->TSO->get_foto_supervisi_sales($id_sales, $limit);
			$response = array("status" => "success", "total" => count($get_data), "data" => $get_data);
			$this->response($response);
		}
		// ================================== Fauzan
		public function updateVisitTso_post(){
			$id_tso = $this->input->post("id_user");
			$data = json_decode($_POST['data'], true);
			
			$hasil = $this->TSO->Update_visiting($id_tso, $data);
			
			if($hasil > 0){
				$response = array("status" => "success", "message" => 'Update Visiting Berhasil Disimpan', "total" => count($hasil), "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Update Visiting Gagal Disimpan', "total" => count($hasil), "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function PenilaianNew_post(){
			$id_tso = $this->input->post("id_user");
			$data = json_decode($_POST['data'], true);
			
			$hasil = $this->TSO->Simpan_penilaian($id_tso, $data);
			
			if($hasil > 0){
				$response = array("status" => "success", "message" => 'Penilaian Berhasil Disimpan', "total" => count($hasil), "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Penilaian Gagal Disimpan', "total" => count($hasil), "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function UpdatePenilaianNew_post(){
			$id_tso = $this->input->post("id_user");
			$data = json_decode($_POST['data'], true);
			
			$hasil = $this->TSO->Update_penilaian($id_tso, $data);
			
			if($hasil > 0){
				$response = array("status" => "success", "message" => 'Update Penilaian Berhasil Disimpan', "total" => count($hasil), "data" => $hasil);
			} else {
				$response = array("status" => "success", "message" => 'Update Penilaian Gagal Disimpan', "total" => count($hasil), "data" => $hasil);
			}
			$this->response($response);
		}
		
		public function delPhoto_post(){
			$id_tso 		= $this->input->post("id_user");
			$datasIdFoto 	= $this->input->post("data");
			
			$get_fotoExist = $this->TSO->get_foto_survey_inId($datasIdFoto);
			foreach($get_fotoExist as $data_in){
				$img = explode('/',$data_in['PATH_FOTO']);
				
				// print_r($img);
				// exit();
				
				$set_path_new = "assets/Foto_del_Visit_tso/".$img[2];
				do {
					//unlink();
					rename($data_in['PATH_FOTO'], $set_path_new); 
				} while (file_exists($data_in['PATH_FOTO']));
			}
			
			$set_Del_data = $this->TSO->Del_foto_survey($id_tso, $datasIdFoto);
			
			if($set_Del_data != 0){
				$response = array("status" => "success", "total data dihapus" => count($get_fotoExist));
			} else {
				$response = array("status" => "success", "total data dihapus" => 0);
			}
			$this->response($response);
		}
		
		public function getCustomer_post(){
			$id_tso  = $this->input->post("id_user");
			
			$start = null;
			if($this->input->post('start') != null){
				$start = $this->input->post('start');
			};
			
			$limit = null;
			if($this->input->post('limit') != null){
				$limit = $this->input->post('limit');
			};
			
			$hasil 	 = $this->TSO->get_toko_tso($id_tso, $start, $limit);
			if(count($hasil) != 0){
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            } else {
                $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
			 $this->response($response);
		}
		
	}
	
?>