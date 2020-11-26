<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}
require APPPATH . '/controllers/apis/Auth.php';

    class Radius_area extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_area', 'mArea');
        }
		
		public function getRadiusAreaCustomer_post(){
			//id_user, id_customer, 
			
			
		}
		
	}
	
?>