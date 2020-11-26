<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Koordinat extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Koordinat_model');
    } 

    public function index(){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data['provinsi'] = $this->Koordinat_model->getProvinsi();
		$this->template->display('Koordinat_view', $data);
    }
	
	public function TampilData(){
		//$id_prov = $this->input->post("provinsi");
		$By = explode("-",$_POST["By"]);
		$Set = explode("-",$_POST["Set"]);
		$filterBy = $By[0]; 
		$filterSet = $Set[0];
		$hasil = $this->Koordinat_model->getData($filterBy, $filterSet);  
		echo json_encode($hasil);
	}
	
	public function CariData(){
		$id_customer = $this->input->post("customer");
		$hasil = $this->Koordinat_model->cariData($id_customer);
		echo json_encode($hasil);
	}
	
	public function Provinsi(){
		$data = array();
			
		$list = $this->Koordinat_model->getProvinsi();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$data[]  = array(
					$list_Val->ID_PROVINSI,
					$list_Val->NAMA_PROVINSI
				);
			}
		} else {
            $data[] = array("","");
        }
		
		$output = array(
            "recordsTotal" => count($list),
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	
	public function Area(){
		$data = array();
			
		$list = $this->Koordinat_model->getArea();
		if($list){
			foreach ($list as $list_Key => $list_Val) {
				$data[]  = array(
					$list_Val->ID_AREA,
					$list_Val->NAMA_AREA
				);
			}
		} else {
            $data[] = array("","");
        }
		
		$output = array(
            "recordsTotal" => count($list),
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	
}

?>