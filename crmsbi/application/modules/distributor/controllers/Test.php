<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Test extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("Model_sidigi");
    }
    
	public function index(){
		
		$hasil = $this->Model_sidigi->get_data_kpi();
		print_r($hasil);
		
	}

}

?>