<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}
require APPPATH . '/controllers/apis/Auth.php';

    class Master_reason extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_master_reason', 'mReason');
        }

        public function index_post(){
            $mr = $this->mReason->listMasterReason();
            if($mr){
                foreach ($mr as $mrKey => $mrValue) {
                    $data['id_mr'] = $mrValue->ID_MR;
                    $data['nama_mr'] = $mrValue->NM_MASTER_REASON;
                    $data['deskripsi'] = $mrValue->DISCRIPTION;
                    
                    $json_dt[] = $data;
                }
                $response = array("status" => "success", "data" => $json_dt);
            } else {
                $response = array("status" => "error", "message" => "Data reason tidak ada");
            }
            $this->response($response);
        }
		
		public function detail_post(){
			$mrd = $this->mReason->listMasterReasonDetail();
            if($mrd){
                foreach ($mrd as $mrdKey => $mrdValue) {
					$data['no_detail'] = $mrdValue->NO_DETAIL;
					$data['nama_detail'] = $mrdValue->NAMA_DETAIL;
                    $data['id_mr'] = $mrdValue->ID_MR;
                    $data['nama_mr'] = $mrdValue->NM_MASTER_REASON;
					
                    $json_dt[] = $data;
                }
                $response = array("status" => "success", "data" => $json_dt);
            } else {
                $response = array("status" => "error", "message" => "Data reason tidak ada");
            }
            $this->response($response);
		}
        
    }
?>