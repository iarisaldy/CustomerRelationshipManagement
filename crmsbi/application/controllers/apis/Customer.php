<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Customer extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            $this->validate();
            $this->load->model('apis/Model_customer', 'mCustomer');
        }

        public function index_get(){
            $limit = $this->input->get('limit');
            $start = $this->input->get('start');

            $customer = $this->mCustomer->listCustomer($limit, $start);

            if($customer){
                foreach ($customer['data'] as $customerKey => $customerValue) {
                    $data["ID_CUSTOMER"] = $customerValue->ID_CUSTOMER;
                    $data["KODE_CUSTOMER"] = $customerValue->KODE_CUSTOMER;
                    $data["NAMA_TOKO"] = $customerValue->NAMA_TOKO;
                    $data["NAMA_PEMILIK"] = $customerValue->NAMA_PEMILIK;
                    $data["TELP_TOKO"] = $customerValue->TELP_TOKO;
                    $data["TELP_PEMILIK"] = $customerValue->TELP_PEMILIK;
                    $data["NOKTP_PEMILIK"] = $customerValue->NOKTP_PEMILIK;
                    $data["KETERANGAN"] = $customerValue->KETERANGAN;
                    $data["ALAMAT"] = $customerValue->ALAMAT;
                    $data["KODE_POS"] = $customerValue->KODE_POS;
                    $data["FOTO_TOKO"] = $customerValue->FOTO_TOKO;
                    $data["KAPASITAS_TOKO"] = $customerValue->KAPASITAS_TOKO;
                    $data["ID_DISTRIBUTOR"] = $customerValue->ID_DISTRIBUTOR;
                    $data["NAMA_DISTRIBUTOR"] = $customerValue->NAMA_DISTRIBUTOR;
                    $data["ID_PROVINSI"] = $customerValue->ID_PROVINSI;
                    $data["NAMA_PROVINSI"] = $customerValue->NAMA_PROVINSI;
                    $data["ID_DISTRIK"] = $customerValue->ID_DISTRIK;
                    $data["NAMA_DISTRIK"] = $customerValue->NAMA_DISTRIK;
                    $data["ID_AREA"] = $customerValue->ID_AREA;
                    $data["NAMA_AREA"] = $customerValue->NAMA_AREA;


                    $json[] = $data;
                }
                $total = $this->mCustomer->listCustomer();
                $response = array("status" => "success", "total" => $total['total'], "data" => $json);
            } else {
                $response = array("status" => "error", "message" => "Data customer tidak ada");
            }

            $this->response($response);
        }
		public function CustomerDistributor_post(){
			
			$distributor =null;
			if(isset($_POST['distributor'])){
				$distributor =$_POST['distributor'];
			};
			
			$provinsi =null;
			if(isset($_POST['provinsi'])){
				$provinsi =$_POST['provinsi'];
			};
			
			$distrik =null;
			if(isset($_POST['distrik'])){
				$distrik =$_POST['distrik'];
			};
			
			$area =null;
			if(isset($_POST['area'])){
				$area =$_POST['area'];
			};
			
			$kecamatan =null;
			if(isset($_POST['kecamatan'])){
				$kecamatan =$_POST['kecamatan'];
			};
			
			$limit =null;
			if(isset($_POST['limit'])){
				$limit =$_POST['limit'];
			};
			
			$start =null;
			if(isset($_POST['start'])){
				$start =$_POST['start'];
			};
			
			
			
			$hasil = $this->mCustomer->get_data_customer($distributor, $provinsi, $distrik, $area, $kecamatan, $limit, $start);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Customer Tidak Ditemukan");
			}
			
			$this->response($response);
			
			
			
		}
		
		public function CustomerDistributorTotal_post(){
			
			$distributor =null;
			if(isset($_POST['distributor'])){
				$distributor =$_POST['distributor'];
			};
			
			$provinsi =null;
			if(isset($_POST['provinsi'])){
				$provinsi =$_POST['provinsi'];
			};
			
			$distrik =null;
			if(isset($_POST['distrik'])){
				$distrik =$_POST['distrik'];
			};
			
			$area =null;
			if(isset($_POST['area'])){
				$area =$_POST['area'];
			};
			
			$kecamatan =null;
			if(isset($_POST['kecamatan'])){
				$kecamatan =$_POST['kecamatan'];
			};
			
			$limit =null;
			if(isset($_POST['limit'])){
				$limit =$_POST['limit'];
			};
			
			$start =null;
			if(isset($_POST['start'])){
				$start =$_POST['start'];
			};
			
			
			
			$hasil = $this->mCustomer->get_data_customer($distributor, $provinsi, $distrik, $area, $kecamatan, $limit, $start);
			
			$total = array(
				'Customer' => count($hasil)
			);
			
			if($hasil){
				$response = array("status" => "success", "data" => $total);
				
			}
			else {
				 $response = array("status" => "error", "data" => $total, "message" => "Data Customer Tidak Ditemukan");
			}
			
			$this->response($response);
			
			
			
		}
		
		public function Customerfull_post(){
			
			print_r($_POST['distributor']);
			
			$distributor =null;
			if(isset($_POST['distributor'])){
				
				for($i=0; $i<count($_POST['distributor']); $i++){
					
					if($i==(count($_POST['distributor'])-1)){
						$distributor .= "'".$_POST['distributor'][$i]."'";
					}
					else {
						$distributor .= "'".$_POST['distributor'][$i]."',";
					}
					
					
				}
				
			}
			
			exit;
			$provinsi =null;
			if(isset($_POST['provinsi'])){
				
				for($i=0; $i<count($_POST['provinsi']); $i++){
					
					if($i==(count($_POST['provinsi'])-1)){
						$provinsi .= "'".$_POST['provinsi'][$i]."'";
					}
					else {
						$provinsi .= "'".$_POST['provinsi'][$i]."',";
					}
					
					
				}
			};
			
			$distrik =null;
			if(isset($_POST['distrik'])){
				
				for($i=0; $i<count($_POST['distrik']); $i++){
					
					if($i==(count($_POST['distrik'])-1)){
						$distrik .= "'".$_POST['distrik'][$i]."'";
					}
					else {
						$distrik .= "'".$_POST['distrik'][$i]."',";
					}
				}
			};
			
			$area =null;
			if(isset($_POST['area'])){
				
				for($i=0; $i<count($_POST['area']); $i++){
					
					if($i==(count($_POST['area'])-1)){
						$area .= "'".$_POST['area'][$i]."'";
					}
					else {
						$area .= "'".$_POST['area'][$i]."',";
					}
				}
			};
			
			
			$kecamatan =null;
			if(isset($_POST['kecamatan'])){
				$kecamatan =$_POST['kecamatan'];
			};
			
			$limit =null;
			if(isset($_POST['limit'])){
				$limit =$_POST['limit'];
			};
			
			$start =null;
			if(isset($_POST['start'])){
				$start =$_POST['start'];
			};
			
			
			
			$hasil = $this->mCustomer->get_data_customer_full($distributor, $provinsi, $distrik, $area, $kecamatan, $limit, $start);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Customer Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}
		
		public function CustomerAll_post(){
			
			$distributor =null;
			if(isset($_POST['distributor'])){
				// $N = explode(',', $_POST['distributor']);
				// for($i=0; $i<count($N); $i++){
					
					// if($i==(count($N)-1)){
						// $distributor .= "'".$N[$i]."'";
					// }
					// else {
						// $distributor .= "'".$N[$i]."',";
					// }
					
					
				// }
				$distributor = $_POST['distributor'];
			}
			
			$provinsi =null;
			if(isset($_POST['provinsi'])){
				$provinsi =$_POST['provinsi'];
			};
			
			$distrik =null;
			if(isset($_POST['distrik'])){
				$distrik =$_POST['distrik'];
			};
			
			$area =null;
			if(isset($_POST['area'])){
				$area =$_POST['area'];
			};
			
			$kecamatan =null;
			if(isset($_POST['kecamatan'])){
				$kecamatan =$_POST['kecamatan'];
			};
			
			$limit =null;
			if(isset($_POST['limit'])){
				$limit =$_POST['limit'];
			};
			
			$start =null;
			if(isset($_POST['start'])){
				$start =$_POST['start'];
			};
			
			
			$hasil = $this->mCustomer->get_data_customer_full($distributor, $provinsi, $distrik, $area, $kecamatan, $limit, $start);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
				
			}
			else {
				 $response = array("status" => "error", "total" => count($hasil), "message" => "Data Customer Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}
		
		public function CustomerAllTotal_post(){
			
			$distributor =null;
			if(isset($_POST['distributor'])){
				$distributor = $_POST['distributor'];
			}
			
			$provinsi =null;
			if(isset($_POST['provinsi'])){
				$provinsi =$_POST['provinsi'];
			};
			
			$distrik =null;
			if(isset($_POST['distrik'])){
				$distrik =$_POST['distrik'];
			};
			
			$area =null;
			if(isset($_POST['area'])){
				$area =$_POST['area'];
			};
			
			
			$kecamatan =null;
			if(isset($_POST['kecamatan'])){
				$kecamatan =$_POST['kecamatan'];
			};
			
			$limit =null;
			if(isset($_POST['limit'])){
				$limit =$_POST['limit'];
			};
			
			$start =null;
			if(isset($_POST['start'])){
				$start =$_POST['start'];
			};
			
			
			
			$hasil = $this->mCustomer->get_data_customer_full($distributor, $provinsi, $distrik, $area, $kecamatan, $limit, $start);
			
			
			
			$total = array(
				'customer' => count($hasil)
			);
			
			if($hasil){
				$response = array("status" => "success", "data" => $total);
				
			}
			else {
				 $response = array("status" => "error", "data" => $total, "message" => "Data Customer Tidak Ditemukan");
			}
			
			$this->response($response);
			
		}
	}


?>