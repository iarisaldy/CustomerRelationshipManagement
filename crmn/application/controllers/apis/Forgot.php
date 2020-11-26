<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

require APPPATH . '/controllers/apis/Auth.php';

    class Forgot extends Auth {

        public function __construct(){
            parent::__construct();
            ini_set('memory_limit','256M');
            //$this->validate();
			$this->load->model('apis/A_forgot_model', 'forgot_model');
        }
		
		public function Lupa_post(){
			//echo "love";
			$no_hp = $this->post("no_hp");
			$checkUser = $this->forgot_model->Cek_no_hp($no_hp);
			//exit();
			
			if($checkUser){
				$response = array("status" => "success",  "message" => "Data Berhasil ditemukan");
			}
			else {
				 $response = array("status" => "error", "message" => "Data Tidak Ditemukan");
			}
			$this->response($response);
			
		}
		public function curlblok_post(){
			echo phpinfo();
			exit();
			$email_api = urlencode("forcasupport@sisi.id");
			$passkey_api = urlencode("tcQdCz631gbprM54LcIP0zEl5");
			$no_hp_tujuan = urlencode('081358635810');
			$isi_pesan = urlencode("CRM SIG -  12345  Adalah Kode OTP untuk password anda. PENTING demi keamanan password anda jangan diserbakan ke orang lain");

			$url = "https://reguler.medansms.co.id/sms_api.php?action=kirim_sms&email=".$email_api."&passkey=".$passkey_api."&no_tujuan=".$no_hp_tujuan."&pesan=".$isi_pesan. "&json=1";
			$result = $this->SendAPI_SMS($url);
			print_r($result);
		}
		function SendAPI_SMS($url){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response  = curl_exec($ch);
			//curl_close($ch);
			curl_getinfo($ch);
			exit();
			return $response;
		}
		public function ResetPassword_post(){
			$no_hp 	= $this->post("no_hp");
			$otp 	= $this->post("otp");
			
			$hasil = $this->forgot_model->Reset_password($no_hp, $otp);
			if($hasil){
				if($hasil['STATUS']==true){
					$response = array("status" => "success",  "message" => $hasil['PESAN']);
				}
				else {
					$response = array("status" => "error",  "message" => $hasil['PESAN']);
				}
				
			}
			else {
				 $response = array("status" => "error", "message" => "Data Tidak Ditemukan");
			}
			$this->response($response);
		}
		
		
		
	}

?>