<?php
	/**
	 * 
	 */
	class Volume_distributor extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			
			$this->load->model('Volume_distributor_model');
		}
		public function Distributor(){
			$data = array("title"=>"Dashboard CRM VOLUME DISTRIBUTOR");
			
			$data['bulan']	= date('m');
			if(isset($_POST['filterBulan'])){
				$data['bulan'] = $_POST['filterBulan'];
			}

			$data['tahun']	= date('Y');
			if(isset($_POST['filterTahun'])){
				$data['tahun'] = $_POST['filterTahun'];
			}			

			$distributor 	= $_SESSION['kode_dist'];

			$data['isi_table'] 	= $this->make_list_gudang_detile($this->Volume_distributor_model->Get_Penjualan_per_gudang_distributor($distributor, $data['tahun'], $data['bulan']));

			$this->template->display('selling_out_distributor', $data);
			
		}		
		public function Sellinginout($a=1){
			$data = array("title"=>"Dashboard CRM VOLUME DISTRIBUTOR");
			
			$data['bulan']	= date('m');
			if(isset($_POST['filterBulan'])){
				$data['bulan'] = $_POST['filterBulan'];
			}

			$data['tahun']	= date('Y');
			if(isset($_POST['filterTahun'])){
				$data['tahun'] = $_POST['filterTahun'];
			}			
			
			if($a==1){
				$hb 			= $this->Volume_distributor_model->Get_data_HB_Peringkat($data['tahun'], $data['bulan']);
				$distributor 	= $this->Volume_distributor_model->Get_data_distributor();

				$hasil 				= $this->make_array_peringkat($distributor, $hb);
				$data['isi_table'] 	= $this->make_list_table_volume_selling_in($hb);

				$this->template->display('selling_in', $data);				
			}
			else {
				$hj 				= $this->Volume_distributor_model-> Get_data_hj_grouth($data['tahun'], $data['bulan']);
				$data['isi_table'] 	= $this->make_list_selling_out($hj);

				$this->template->display('selling_out', $data);
			}
		}
		public function index(){
			$data = array("title"=>"Dashboard CRM VOLUME DISTRIBUTOR");
			
			$data['bulan']	= date('m');
			if(isset($_POST['filterBulan'])){
				$data['bulan'] = $_POST['filterBulan'];
			}

			$data['tahun']	= date('Y');
			if(isset($_POST['filterTahun'])){
				$data['tahun'] = $_POST['filterTahun'];
			}			

			$hj 			= $this->Volume_distributor_model->Get_data_volume_HJ($data['tahun'], $data['bulan']);
			$hb 			= $this->Volume_distributor_model->Get_data_volume_HB($data['tahun'], $data['bulan']);
			$distributor 	= $this->Volume_distributor_model->Get_data_distributor();

			$hasil 				= $this->make_array_volume_dist($distributor, $hb, $hj);
			$data['isi_table'] 	= $this->make_table_volume_dist($hasil);

			// echo '<pre>';
			// print_r($hasil);
			// echo '</pre>';

			$this->template->display('volume_distributor', $data);
			
		}
		private function make_table_volume_dist($data){

			$isi = '';
			$no  = 1;
			$b 	 = 'x';
			foreach ($data as $d) {
				$tombol = '<center><button class="btn btn-primary" style="font-size:16px"><center><i class="fa fa-line-chart"></i></center></button></center>';
				$isi  .= '<tr class="'.$b.'">';
				$isi  .= '<td>'.$no.'</td>';
				$isi  .= '<td>'.$d['KD_DISTRIBUTOR'].'</td>';
				$isi  .= '<td>'.$d['NM_DISTRIBUTOR'].'</td>';
				$isi  .= '<td>'.number_format($d['HB_VOLUME']).'</td>';
				$isi  .= '<td>'.number_format($d['HB_HARGA']).'</td>';
				$isi  .= '<td>'.number_format($d['HB_REVENUE']).'</td>';
				$isi  .= '<td>'.number_format($d['HJ_VOLUME']).'</td>';
				$isi  .= '<td>'.number_format($d['HJ_HARGA']).'</td>';
				$isi  .= '<td>'.number_format($d['HJ_REVENUE']).'</td>';
				$isi  .= '<td>'.$tombol.'</td>';
				$isi  .= '</tr>';
				$no=$no+1;
				if($b=='x'){
					$b='y';
				}
				else {
					$b='x';
				}
			}
			return $isi;
		}
		private function make_array_volume_dist($distributor, $hb, $hj){

			$hasil 	= array();
			$no		= 0;
			foreach ($distributor as $d) {
				$hasil[$no]['KD_DISTRIBUTOR'] = $d['KODE_DISTRIBUTOR'];
				$hasil[$no]['NM_DISTRIBUTOR'] = $d['NAMA_DISTRIBUTOR'];

				$hasil[$no]['HB_VOLUME'] 	= 0;
				$hasil[$no]['HB_HARGA'] 	= 0;
				$hasil[$no]['HB_REVENUE'] 	= 0;
				foreach ($hb as $b) {
					if($d['KODE_DISTRIBUTOR']==$b['KD_DISTRIBUTOR']){
						$hasil[$no]['HB_VOLUME'] 	= $b['VOLUME'];
						$hasil[$no]['HB_HARGA'] 	= $b['HARGA'];
						$hasil[$no]['HB_REVENUE'] 	= $b['REVENUE'];
					}
				}

				$hasil[$no]['HJ_VOLUME'] 	= 0;
				$hasil[$no]['HJ_HARGA'] 	= 0;
				$hasil[$no]['HJ_REVENUE'] 	= 0;
				foreach ($hj as $j) {
					if($d['KODE_DISTRIBUTOR']==$j['KD_DISTRIBUTOR']){
						$hasil[$no]['HJ_VOLUME'] 	= $j['QTY_TON'];
						$hasil[$no]['HJ_HARGA'] 	= $j['HARGA_TON'];
						$hasil[$no]['HJ_REVENUE'] 	= $j['REVENUE'];
					}
				}
				$no=$no+1;

			}
			return $hasil;
		}

		public function selling_in(){
			$data = array("title"=>"Dashboard CRM VOLUME DISTRIBUTOR");
			
			$data['bulan']	= date('m');
			if(isset($_POST['filterBulan'])){
				$data['bulan'] = $_POST['filterBulan'];
			}

			$data['tahun']	= date('Y');
			if(isset($_POST['filterTahun'])){
				$data['tahun'] = $_POST['filterTahun'];
			}			

			//$hj 			= $this->Volume_distributor_model->Get_data_volume_HJ($data['tahun'], $data['bulan']);
			$hb 			= $this->Volume_distributor_model->Get_data_HB_Peringkat($data['tahun'], $data['bulan']);
			$distributor 	= $this->Volume_distributor_model->Get_data_distributor();

			$hasil 				= $this->make_array_peringkat($distributor, $hb);
			$data['isi_table'] 	= $this->make_list_table_volume_selling_in($hb);

			// echo '<pre>';
			// print_r($hasil);
			// echo '</pre>';

			$this->template->display('selling_in', $data);
		}
		private function make_array_peringkat($distributor, $hb){
			$hasil 	= array();
			$no		= 0;
			foreach ($hb as $d) {
				$hasil[$no]['KD_DISTRIBUTOR'] = $d['KD_DISTRIBUTOR'];
				$hasil[$no]['NM_DISTRIBUTOR'] = '';

				foreach ($distributor as $b) {
					if($d['KD_DISTRIBUTOR']==$b['KODE_DISTRIBUTOR']){
						$hasil[$no]['NM_DISTRIBUTOR'] = $b['NAMA_DISTRIBUTOR'];
					}
				}
				$hasil[$no]['HB_VOLUME'] 	= $d['VOLUME'];
				$hasil[$no]['HB_TARGET'] 	= $d['TARGET'];
				$hasil[$no]['HB_PERSEN'] 	= $d['PERSEN'];

				$no=$no+1;
			}

			return $hasil;
		}

		private function make_list_table_volume_selling_in($data){
			$isi = '';
			$no  = 1;
			$b 	 = 'x';
			foreach ($data as $d) {
				$tombol = '<center><button class="btn btn-primary Tampilkan_form_growth" distributor="'.$d['KD_DISTRIBUTOR'].'"
				nm_dist="'.$d['NM_DISTRIBUTOR'].'" style="font-size:16px"><center><i class="fa fa-line-chart"></i></center></button></center>';
				$isi  .= '<tr class="'.$b.'">';
				$isi  .= '<td>'.$no.'</td>';
				$isi  .= '<td>'.$d['KD_DISTRIBUTOR'].'</td>';
				$isi  .= '<td>'.$d['NM_DISTRIBUTOR'].'</td>';
				$isi  .= '<td>'.number_format($d['VOLUME']).'</td>';
				$isi  .= '<td>'.number_format($d['TARGET']).'</td>';
				$isi  .= '<td>'.number_format($d['PERSEN']).' %</td>';
				$isi  .= '<td>'.$tombol.'</td>';
				$isi  .= '</tr>';
				$no=$no+1;
				if($b=='x'){
					$b='y';
				}
				else {
					$b='x';
				}
			}
			return $isi;
		}
		public function Ajax_tampil_growth_distributor(){

			$distributor 	= $this->input->post('distributor');


			$h2017 			= $this->Volume_distributor_model->Get_data_growth_distributor($distributor, 2017);
			$h2018 			= $this->Volume_distributor_model->Get_data_growth_distributor($distributor, 2018);
			$h2019 			= $this->Volume_distributor_model->Get_data_growth_distributor($distributor, 2019);
			
			$isi ='[';
			$isi .= $h2017. ','. $h2018. ', '. $h2019;
			$isi .= ']';

			// echo '[{"name":"2017","data":[0,0,0,0,0,0,0,0,0,0,27741,24475]},
   //              {"name":"2018","data":[0,0,0,0,0,0,0,0,0,0,27741,24475]}]';
			echo $isi;
		}
		public function selling_out(){
			$data = array("title"=>"Dashboard CRM VOLUME DISTRIBUTOR");
			
			$data['bulan']	= date('m');
			if(isset($_POST['filterBulan'])){
				$data['bulan'] = $_POST['filterBulan'];
			}

			$data['tahun']	= date('Y');
			if(isset($_POST['filterTahun'])){
				$data['tahun'] = $_POST['filterTahun'];
			}			

			//$hj 			= $this->Volume_distributor_model->Get_data_volume_HJ($data['tahun'], $data['bulan']);
			$hj 			= $this->Volume_distributor_model-> Get_data_hj_grouth($data['tahun'], $data['bulan']);
			
			// $hasil 				= $this->make_array_peringkat($distributor, $hb);
			$data['isi_table'] 	= $this->make_list_selling_out($hj);

			// echo '<pre>';
			// print_r($hj);
			// echo '</pre>';

			$this->template->display('selling_out', $data);
		}
		private function make_list_selling_out($data){

			$isi = '';
			$no  = 1;
			$b 	 = 'x';
			foreach ($data as $d) {
				$tombol = '<button class="btn btn-primary Tampilkan_form_growth" distributor="'.$d['KD_DISTRIBUTOR'].'"
				nm_dist="'.$d['NM_DISTRIBUTOR'].'" style="font-size:16px"><center><i class="fa fa-list"></i></center></button>';
				$isi  .= '<tr class="'.$b.'">';
				$isi  .= '<td>'.$no.'</td>';
				$isi  .= '<td>'.$d['KD_DISTRIBUTOR'].'</td>';
				$isi  .= '<td>'.$d['NM_DISTRIBUTOR'].'</td>';
				$isi  .= '<td>'.number_format($d['QTY_TON']).'</td>';
				$isi  .= '<td>'.number_format($d['HARGA_TON']).'</td>';
				$isi  .= '<td>'.number_format($d['REVENUE']).'</td>';
				$isi  .= '<td><center>'.$tombol.'</center></td>';
				$isi  .= '</tr>';
				$no=$no+1;
				if($b=='x'){
					$b='y';
				}
				else {
					$b='x';
				}
			}
			return $isi;
		}
		public function AJax_tampil_detile_gudang(){

			$distributor 	= $this->input->post('distributor');
			$tahun 			= $this->input->post('tahun');
			$bulan 			= $this->input->post('bulan');

			$hasil = $this->make_list_gudang_detile($this->Volume_distributor_model->Get_Penjualan_per_gudang_distributor($distributor, $tahun, $bulan));

			echo $hasil;
		}
		private function make_list_gudang_detile($data){
			$isi = '';
			$no  = 1;
			$b='x';
			foreach ($data as $d) {
				$tombol_grafik = '<button class="btn btn-primary Tampilkan_grafik_per_gudang" gudang="'.$d['KD_GUDANG'].'"
				nm_gudang="'.$d['NM_GUDANG'].'" style="font-size:16px"><center><i class="fa fa-line-chart"></i></center></button>';
				$tombol = '<button class="btn btn-primary Tampilkan_detile_toko" gudang="'.$d['KD_GUDANG'].'"
				nm_gudang="'.$d['NM_GUDANG'].'" style="font-size:16px"><center><i class="fa fa-home"></i></center></button>';
				$isi  .= '<tr class="'.$b.'">';
				$isi  .= '<td>'.$no.'</td>';
				$isi  .= '<td>'.$d['KD_GUDANG'].'</td>';
				$isi  .= '<td>'.$d['NM_GUDANG'].'</td>';
				$isi  .= '<td>'.number_format($d['QTY_TON']).'</td>';
				$isi  .= '<td>'.number_format($d['HARGA_TON']).'</td>';
				$isi  .= '<td>'.number_format($d['REVENUE']).'</td>';
				$isi  .= '<td><center>'.$tombol_grafik.'</center></td>';
				$isi  .= '<td><center>'.$tombol.'</center></td>';
				$isi  .= '</tr>';
				$no=$no+1;
				if($b=='x'){
					$b='y';
				}
				else {
					$b='x';
				}
			}
			return $isi;	
		}
		public function Ajax_tampil_grafik_gudang(){
			$gudang 		= $this->input->post('gudang');


			$hasil2018 = $this->Volume_distributor_model->Get_grafik_gudang($gudang, 2018);
			$hasil2019 = $this->Volume_distributor_model->Get_grafik_gudang($gudang, 2019);
			// print_r($hasil2018);
			// EXIT;
			$isi ='[';
			$isi .= $hasil2018. ','. $hasil2019;
			$isi .= ']';
			// $output = array(
			// 	'h2018' 	=> $hasil2018,
			// 	'h2019'		=> $hasil2019
			// 	);

			// echo json_encode($output);
			echo $isi;
		}

		public function Ajax_tampil_detile_toko_gudang(){
			
			$gudang 		= $this->input->post('gudang');
			$tahun 			= $this->input->post('tahun');
			$bulan 			= $this->input->post('bulan');

			$hasil 	= $this->make_list_detile_toko($this->Volume_distributor_model->Get_data_toko_detile($gudang, $tahun, $bulan));

			echo $hasil;			

		}
		private function make_list_detile_toko($data){
			$isi = '';
			$no  = 1;
			$b='x';
			foreach ($data as $d) {
				$tombol = '<button class="btn btn-primary Tampilkan_form_growth_toko" kd_toko="'.$d['KD_TOKO'].'"
				nm_toko="'.$d['NM_TOKO'].'" style="font-size:16px"><center><i class="fa fa-line-chart"></i></center></button>';
				$isi  .= '<tr class="'.$b.'">';
				$isi  .= '<td>'.$no.'</td>';
				$isi  .= '<td>'.$d['KD_TOKO'].'</td>';
				$isi  .= '<td>'.$d['NM_TOKO'].'</td>';
				$isi  .= '<td>'.number_format($d['QTY_TON']).'</td>';
				$isi  .= '<td>'.number_format($d['HARGA_TON']).'</td>';
				$isi  .= '<td>'.number_format($d['REVENUE']).'</td>';
				$isi  .= '<td><center>'.$tombol.'</center></td>';
				$isi  .= '</tr>';
				$no=$no+1;
				if($b=='x'){
					$b='y';
				}
				else {
					$b='x';
				}
			}
			return $isi;
		}
		public function Ajax_tampil_grafik_toko(){
			$kd_toko 	= $this->input->post('kd_toko');

			$hasil2018 	= $this->Volume_distributor_model->Get_toko_volume_growth($kd_toko, 2018);
			$hasil2019 	= $this->Volume_distributor_model->Get_toko_volume_growth($kd_toko, 2019);
			
			// $output = array(
			// 	'h2018' 	=> $hasil2018,
			// 	'h2019'		=> $hasil2019
			// 	);

			// echo json_encode($output);
			$isi ='[';
			$isi .= $hasil2018. ','. $hasil2019;
			$isi .= ']';

			echo $isi;


		}

	}
?>