<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

class Demandpl extends CI_Controller {
	private $db2;
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('is_login'))redirect('login');
        $this->load->model('Demandpl_model');
    }

    public function index()
    {
    	$data = array('title' => 'DASHBOARD DEMAND PL');
    	$data['head'] = array('Produksi Terak', 'Produksi Semen', 'Stok Terak (Plant)', 'Stok Semen (Plant)', 'Vol Penjualan Domestik');
    	$data['org']	= $this->Demandpl_model->org();
    	$data['teraks']	= $this->Demandpl_model->terak();
    	$data['produksiSemen']	= $this->Demandpl_model->produksiSemen();
    	$this->template->display('Demandpl_view', $data);
    }
}