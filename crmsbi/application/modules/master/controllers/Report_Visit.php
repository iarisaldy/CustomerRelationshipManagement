<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Report_Visit extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Report_visit_model');
    }

    public function index(){
        
		$data = array("title"=>"Dashboard CRM Administrator");
		//$data['list'] = $this->make_isi_table($this->Report_visit_model->get_data());
		
		$this->template->display('Report_visit_view', $data);
		
    }
	
	private function make_isi_table($hasil)
	{
		$isi ='';
		$no =1;
		foreach($hasil as $h){
			$detail = '<button class="btn btn-info waves-effect " id="edit_jenis" idtarget="'.$h[''].'"><span class="fa fa-area-chart"></span></button>';
			$isi .= '<tr>';
			$isi .= '<td>'.$no.'</td>';
			$isi .= '<td>'.$h[''].'</td>';
			$isi .= '<td>'.$h[''].'</td>';
			$isi .= '<td>'.$h[''].'</td>';
			$isi .= '<td>'.$h[''].'</td>';
			$isi .= '<td><center>'.$detail.'</center></td>';
			$isi .= '</tr>';
			
			$no=$no+1;
		}
		
		return $isi;
	}
	
	public function Ajax_data_id()
	{
		
	}
	
	public function Ajax_tambah_data()
	{
		
	}
	public function Ajax_simpan_edit()
	{

	}
	public function Ajax_hapus_data()
	{

	}
}
?> 