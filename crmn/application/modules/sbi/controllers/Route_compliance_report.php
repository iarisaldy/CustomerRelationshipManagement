<?php
	class Route_compliance_report extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Route_compliance_report_model", "RCRM");
		}
		
		public function index(){
			$data = array("title" => "Dashboard CRM Administrator");
			$id_user             = $this->session->userdata('user_id');
			 
			 // print_r($id_user);
			 // exit;
			
			 $this->session->set_userdata('set_tanda', 0);
			 
			if (isset($_POST["sales"]) and isset($_POST["tanggal"])) {
				$sales = explode('-',$_POST["sales"]);
				$data['kunjungans'] = $this->RCRM->get_kunjunganHarian($sales[0], $_POST["tanggal"]);
				$this->session->set_userdata('set_id_sales', $sales[0]);
				$this->session->set_userdata('set_sales', $sales[1]);
				$this->session->set_userdata('set_tanggal', $_POST["tanggal"]);
				$this->session->set_userdata('set_tanda', 1);
			}

			$jenis_user    = $this->session->userdata('id_jenis_user');
			
			//admin = 1009, rsm = 1010, asm = 1011, tso = 1012
			
			if($jenis_user == 1009){
				$this->template->display('Route_compliance_report_admin_view', $data);
			} else if($jenis_user == 1010){
				$this->template->display('Route_compliance_report_rsm_view', $data);
			} else if($jenis_user == 1011){
				$this->template->display('Route_compliance_report_asm_view', $data);
			} else if($jenis_user == 1012){
				$data['list_sales']  = $this->RCRM->User_SALES($id_user);
				$this->template->display('Route_compliance_report_tso_view', $data);
			}
			
			//$this->template->display('Route_compliance_report_tso_view', $data);
		}
		
		public function koordinatKunjungan(){
			$sales = $this->input->post("sales");
			$tanggal = $this->input->post("tanggal");
			$kunjungans = $this->RCRM->get_kunjunganHarian($sales, $tanggal);
			if($kunjungans){
				echo json_encode($kunjungans);
			} else {
				echo json_encode(array("status" => "error", "data" => array(), "message" => "Data Kunjungan Tidak Ada"));
			}
		}
		
		//list user
		
		public function List_gsm(){
			$data = array(); 
			
			$list_gsm = $this->RCRM->List_Gsm();
			if($list_gsm){
				foreach ($list_gsm as $list_gsmKey => $list_gsmVal) {
					$data[]  = array(
						$list_gsmVal->ID_GSM,
						$list_gsmVal->NAMA_GSM
					);
				}
			} else {
                $data[] = array("","");
            }
			
			$output = array(
                "recordsTotal" => count($list_gsm),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
		public function List_rsm(){
			$data = array();
			$id_gsm = $this->input->post("gsm");
			$list_rsm = $this->RCRM->List_rsm($id_gsm);
			if($list_rsm){
				foreach ($list_rsm as $list_rsmKey => $list_rsmVal) {
					$data[]  = array(
						$list_rsmVal->ID_SSM,
						$list_rsmVal->NAMA_SSM
					);
				}
			} else {
                $data[] = array("","");
            }
			
			$output = array(
                "recordsTotal" => count($list_rsm),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
		public function List_asm(){	//SM
			$data = array();
			$id_gsm = $this->input->post("gsm");
			$id_rsm = $this->input->post("rsm");
			$list_asm = $this->RCRM->List_asm($id_gsm, $id_rsm);
			if($list_asm){
				foreach ($list_asm as $list_asmKey => $list_asmVal) {
					$data[]  = array(
						$list_asmVal->ID_SM,
						$list_asmVal->NAMA_SM
					);
				}
			} else {
                $data[] = array("","");
            }
			
			$output = array(
                "recordsTotal" => count($list_asm),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
		public function List_tso(){
			$data = array();
			$id_gsm = $this->input->post("gsm");
			$id_rsm = $this->input->post("rsm");
			$id_asm = $this->input->post("asm");
			$list_tso = $this->RCRM->List_tso($id_gsm, $id_rsm, $id_asm);
			if($list_tso){
				foreach ($list_tso as $list_tsoKey => $list_tsoVal) {
					$data[]  = array(
						$list_tsoVal->ID_SO,
						$list_tsoVal->NAMA_SO
					);
				}
			} else {
                $data[] = array("","");
            }
			
			$output = array(
                "recordsTotal" => count($list_tso),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
		public function List_sales(){
			$data = array();
			$id_gsm = $this->input->post("gsm");
			$id_rsm = $this->input->post("rsm");
			$id_asm = $this->input->post("asm");
			$id_tso = $this->input->post("tso");
			
			$list_sales = $this->RCRM->List_sales($id_gsm, $id_rsm, $id_asm, $id_tso);
			if($list_sales){
				foreach ($list_sales as $list_salesKey => $list_salesVal) {
					$data[]  = array(
						$list_salesVal->ID_SALES,
						$list_salesVal->NAMA_SALES
					);
				}
			} else {
                $data[] = array("","");
            }
			
			$output = array(
                "recordsTotal" => count($list_sales),
                "data" => $data
            );
            echo json_encode($output);
            exit();
		}
		
	}
?>