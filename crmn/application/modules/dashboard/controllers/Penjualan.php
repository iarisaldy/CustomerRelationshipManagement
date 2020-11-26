
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('M_penjualan'); 
	}
	//fungsi yang digunakan untuk pemanggilan halaman home
	public function index()
	{
		$data['title'] = "Dashboard Penjualan Per Area";
		
		// $week_array = $this->getStartAndEndDate(1,2020);
		// print_r($week_array);
		$data['penjualan_area'] = $this->M_penjualan->penjualan_by_area();
		$this->template->display('Penjualan', $data); 
	}
    
	 public function get_data()
    { 
		// $id_cabang = $_POST['id_cabang'];
		// $id_gelombang = $_POST['id_gelombang'];
         $getData = $this->M_penjualan->get_data();  
		 for($i=1;$i>=4;$i++){
			 
		 }
		
		
		$pesertaCharts['labels'] = ["Week 1", "Week 2", "Week 3", "Week 4"];
		$pesertaCharts['data'] = [$total, $lulus, $tidak_lulus, $belum_selesai]; 
		$dataPosisi = array();
		$labelPosisi = array();
		
		$no = 1;
		foreach($getPosisi as $val){ 
				array_push($dataPosisi, $val['total']);
				array_push($labelPosisi, $val['name']); 
			$no += 1;
		}
		$posisiCharts['labels'] = $labelPosisi;
		$posisiCharts['data'] = $dataPosisi;

		$q = $this->M_penjualan->get_cabang(intval($_POST["id_gelombang"]));
		$data = array();
		foreach($q as $r) {
			$data[] = array("id"=>$r["id_cabang"], "nm"=>htmlspecialchars($r["nm_cabang"]));
			}  
		echo json_encode(array('pesertaCharts' => $pesertaCharts,
		'posisiCharts' => $posisiCharts,
		"data"=>$data,
		"idP_total"=> rtrim($idP_total,","),
		"idP_lulus"=>rtrim($idP_lulus,","),
		"idP_tidak_lulus"=>rtrim($idP_tidak_lulus,","),
		"idP_belum_selesai"=>rtrim($idP_belum_selesai,",")
		));
			  
    }
        
     private function getStartAndEndDate($week, $year) {
	  $dto = new DateTime();
	  $dto->setISODate($year, $week);
	  $ret['week_start'] = $dto->format('Y-m-d');
	  $dto->modify('+6 days');
	  $ret['week_end'] = $dto->format('Y-m-d');
	  return $ret;
	}

	public function get_cabang()
	{
		if(isset($_POST["id_gelombang"]) && $_POST["id_gelombang"] != "") {
			$q = $this->M_penjualan->get_cabang(intval($_POST["id_gelombang"]));
			$data = array();
			foreach($q as $r) {
				$data[] = array("id"=>$r["id_cabang"], "nm"=>htmlspecialchars($r["nm_cabang"]));
			}
			echo json_encode(array("data"=>$data));
		} else {
			echo json_encode(array("data"=>array()));
		}
	}
     
	public function detail_peserta()
	{ 
			$id_position =$_POST['id_position'];
			$arrPosition =explode(',', $_POST['id_position']);
			$getPosisi = $this->M_penjualan->get_Posisi($id_position);
			$labelPosisi = array();   
			$dataPosisi = array();   
			foreach ( $getPosisi as $val ) { 
				$total= 0;
				array_push($labelPosisi, $val['name']);
				foreach($arrPosition as $p){ 
					if(intval($val['id'])==intval($p)){
						$total+= 1;
					} 
				} 
				
				array_push($dataPosisi, $total);
			}
			$posisiCharts['labels'] = $labelPosisi;
			$posisiCharts['data'] = $dataPosisi;
			
 
			echo json_encode(array("data"=>$posisiCharts));
	 
	}
     
    
}
