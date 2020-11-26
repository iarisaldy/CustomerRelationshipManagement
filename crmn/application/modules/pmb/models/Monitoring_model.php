<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

class Monitoring_model extends CI_Model {
	
	public function dummy_data(){
		$sql = "SELECT
		
		from crmnew_distributor
		";
		
        $data_in = 254;
        if($data_in != 0){
                for ($i = 0; $i<$data_in; $i++) {
					$data['distributor'] = 'DISTRIBUTOR'.($i+1).' DUMMY';
                    $data['volume_t'] 	 = rand(10000,999999);
                    $data['volume_a'] 	 = rand(10000,999999);
                    $data['so_t'] 		 = rand(10000,999999);
					$data['so_a'] 		 = rand(10000,999999);
					$data['revenue_t'] 	 = rand(1000,99999);
					$data['revenue_a'] 	 = rand(1000,99999);
					$data['acp_t']		 = rand(10,99);
                    $data['acp_a']		 = rand(10,99);
					
                    $json_dt[] = $data;
                }
            $response = array("status" => "success", "data" => $json_dt);
        } else {
            $response = array("status" => "error", "message" => "Data tidak ada");
        }
        //$this->response($response);
		
		//return $response;
		
		return $json_dt;
    }
	
	public function dummy_pmb_sales(){
        $data_in = 241;
        if($data_in != 0){
                for ($i = 0; $i<$data_in; $i++) {
					$data['salesman'] = 'SALES'.($i+1).' DUMMY';
                    $data['toko_t'] 	 = rand(100,999);
                    $data['toko_a'] 	 = rand(10,999);
                    $data['kunjungan_t'] = rand(100,999);
					$data['kunjungan_a'] = rand(10,999);
					$data['ke_t'] 	 	 = rand(100,999);
					$data['ke_a'] 	 	 = rand(10,999);
					$data['ta_t']		 = rand(100,999);
                    $data['ta_a']		 = rand(10,999);
					$data['tb_t']		 = rand(100,999);
                    $data['tb_a']		 = rand(10,999);
					$data['vol_t']		 = rand(100,999);
                    $data['vol_a']		 = rand(10,999);
					
                    $json_dt[] = $data;
                }
            $response = array("status" => "success", "data" => $json_dt);
        } else {
            $response = array("status" => "error", "message" => "Data tidak ada");
        }
        //$this->response($response);
		
		//return $response;
		
		return $json_dt;
    }
	
}

?>