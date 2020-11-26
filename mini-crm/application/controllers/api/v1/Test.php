<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v1/Auth.php';

class Test extends Auth {

	function __construct(){
		parent::__construct();
		$this->validate();
    }

    public function index_get(){
        $data = array();
        $data['data'] = array();
        for ($i=0; $i < 4; $i++) { 
            array_push($data['data'], $i);
        }
        
        print_r($data['data']);
        print_r(array_sum($data['data']));
        // echo array_sum($a);
    	// $awal = date('Y-m-d h:i:s');
    	// $tujuh_hari = mktime(0,0,0,date('n')+1,date('j'), date('Y'));
    	// $kembali = date('Y-m-d h:i:s', $tujuh_hari);
    	// $this->response(array("awal" => $awal, "akhir" => $kembali));
    }
}
