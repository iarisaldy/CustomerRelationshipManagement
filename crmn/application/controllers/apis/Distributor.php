<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Distributor extends Auth {

        public function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_distributor');
            $this->load->model('apis/Model_kunjungan');
        }
		

        public function index_get(){
            
			$hasil = $this->Model_distributor->get_data_distributor();
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				$response = array("status" => "error", "total" => 0, "message" => "Data distrik tidak ada");
			}
			
			$this->response($response);
        }
		
		public function Addkunjungan_post(){
			
			$input = json_decode(file_get_contents("php://input"));
			$data = json_decode(json_encode($input), true);
			
			// $data["ID_USER"] 				= $this->input->post("ID_USER");
			// $data["ID_CUSTOMER"] 			= $this->input->post("ID_CUSTOMER");
			// $data["TGL_RENCANA_KUNJUNGAN"] 	= $this->input->post("TGL_RENCANA_KUNJUNGAN");
			// $data["KETERANGAN"] 			= $this->input->post("KETERANGAN");
			// $data["CHECKIN_LATITUDE"] 		= $this->input->post("CHECKIN_LATITUDE");
			// $data["CHECKIN_LONGITUDE"] 		= $this->input->post("CHECKIN_LONGITUDE");
			// $data["CHECKIN_TIME"] 			= $this->input->post("CHECKIN_TIME");
			// $data["CHECKOUT_LATITUDE"] 		= $this->input->post("CHECKOUT_LATITUDE");
			// $data["CHECKOUT_LONGITUDE"] 	= $this->input->post("CHECKOUT_LONGITUDE");
			// $data["CHECKOUT_TIME"] 			= $this->input->post("CHECKOUT_TIME");
			// $data["ORDER_SEMEN"] 			= $this->input->post("ORDER_SEMEN");
			// $data["FLAG_UNPLANNED"] 		= $this->input->post("FLAG_UNPLANNED");
			// $data["FLAG_ORDER"] 			= $this->input->post("FLAG_ORDER");
			
			$hasil = $this->Model_kunjungan->Add_schedule_kunjungan($data);
			
			// print_r($data);
			
			if($hasil){
				$response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
			}
			else {
				$response = array("status" => "error", "total" => count($hasil), "message" => "Data Gagal disimpan");
			}
			
			$this->response($response);	
		}
		
        public function total_get(){

                $hasil = $this->Model_distributor->get_data_distributor();

                $total = array(
                        'distributor' => count($hasil)
                );

                if($hasil){
                        $response = array("status" => "success", "data" => $total);
                }
                else {
                        $response = array("status" => "error", "data" => 0, "message" => "Data distrik tidak ada");
                }

                $this->response($response);

        }
        
        public function GetdataProgramtheday_post(){
            $id_user    = $this->input->post('id_user');
            $start      = $this->input->post('start');
            $limit      = $this->input->post('limit');
            
//            print_r($_POST);
            $hasil = $this->Model_distributor->get_data_program_theday($id_user, $start, $limit);
            
            if($hasil){
                    $response = array("status" => "success", "total" => count($hasil), "data" => $hasil);
            }
            else {
                    $response = array("status" => "error", "total" => 0, "message" => "Data tidak ada.");
            }

            $this->response($response);
            
            
        }

    }
?>