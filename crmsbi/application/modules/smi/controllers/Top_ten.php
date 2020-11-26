<?php
	/**
	 * 
	 */
	class Top_ten extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			
			$this->load->model('Top_salesforce_model');
		}

		public function index(){
			$data = array("title"=>"Dashboard CRM VOLUME DISTRIBUTOR");
			
			$data['list_top'] = $this->make_table_top_ten($this->Top_salesforce_model->Get_top_salesforce());


			$this->template->display('top_ten', $data);
			
		}
		private function make_table_top_ten($data){

			$isi = '';
			$no  = 1;
			foreach ($data as $d) {
				$tombol = '<button class="btn btn-primary" style="font-size:16px"><center><i class="fa fa-line-chart"></i></center></button>';
				$isi  .= '<tr>';
				$isi  .= '<td>'.$no.'</td>';
				$isi  .= '<td>'.$d['NAMA'].'</td>';
				$isi  .= '<td>'.$d['KODE_DISTRIBUTOR'].' - '.$d['NAMA_DISTRIBUTOR'].'</td>';
				$isi  .= '<td><center>'.number_format($d['JML_KUNJUNGAN']).'</center></td>';
				$isi  .= '</tr>';
				$no=$no+1;
			}
			return $isi;
		}
	}
?>