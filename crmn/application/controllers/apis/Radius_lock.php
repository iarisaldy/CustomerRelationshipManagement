<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}
require APPPATH . '/controllers/apis/Auth.php';

    class Radius_lock extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_radius_lock', 'mRadius');
        }
        
        public function radiusLockDistrict_post(){
			
			$id_district 	= $this->input->post('id_district');
			
            $radius_lock = $this->mRadius->listRadiusDistrictLock($id_district);
			
            if($radius_lock){
                
                $response = array("status" => "success", "data" => $radius_lock);
            } else {
                $response = array("status" => "error", "message" => "Data area lock tidak ada");
            }
            $this->response($response);
        }

    }
?>