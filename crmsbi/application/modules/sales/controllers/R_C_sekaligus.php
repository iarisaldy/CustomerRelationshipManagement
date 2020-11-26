<?php
	class R_C_sekaligus extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Model_R_C_sekaligus"); 
		}

		public function index(){
			$data = array("title"=>"Routing Canvasing Sekaligus");
			//$distributor = $this->session->userdata("kode_dist");
			//$data['dt_costumers'] = $this->Model_R_C_sekaligus->listCustomer($distributor);
            $this->template->display('R_C_sekaligus_view', $data);
		}
		
		public function action_canvasing(){
			$distributor = $this->session->userdata("kode_dist");
			//$sales = $this->input->post("salesDistributor");
			$bulan = $this->input->post("setBulan");
			$tahun = $this->input->post("setTahun");
			
			$this->session->set_userdata('prosesCanvasing', 'aktif');
			//$this->session->set_userdata('prosesCanvasing_sales', $sales);
			$this->session->set_userdata('prosesCanvasing_bulan', $bulan);
			$this->session->set_userdata('prosesCanvasing_tahun', $tahun);
			
			$data['range_tanggal'] = $tahun.'-'.$bulan.'-01';
			$data['dt_saless'] = $this->Model_R_C_sekaligus->salesDistributor($distributor);
			$data['dt_costumers'] = $this->Model_R_C_sekaligus->listCustomer($distributor);
			
			//echo json_encode($data['set_range_tanggal']);die;
			$data['title'] = "Routing Canvasing Sekaligus Proses";
			
			//$data = array("title"=>"Routing Canvasing Sekaligus Proses");
            $this->template->display('R_C_sekaligus_view', $data);
			//$this->load->view('R_C_sekaligus_view', $data);
		}
		
	}
?>