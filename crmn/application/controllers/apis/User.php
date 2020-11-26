<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    require APPPATH . '/controllers/apis/Auth.php';

    class User extends Auth {

        function __construct(){
            parent::__construct();
            $this->validate();
            $this->load->model('apis/Model_user');
        }
		
		public function index_post(){
			
			$id_user 		= $this->input->post('id_user');
			$password_lama 	= $this->input->post('upass_lama');
			$password_baru 	= $this->input->post('upass_baru');
			
			
			$hasil = $this->Model_user->Perubahan_password_user($id_user, $password_lama, $password_baru);
			
			if($hasil){
				$response = array("status" => "success", "message" => "Data Berhasil Di Update");
			}
			else {
				 $response = array("status" => "error", "message" => "Password Lama Tidak Sama");
			}
			
			$this->response($response);
			
        }
		
		

    }
?>