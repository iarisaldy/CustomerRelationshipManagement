<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class A_forgot_model extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
			$this->db 		= $this->load->database('default', TRUE);
			$this->db_BK	= $this->load->database('Point', TRUE);
			$this->db_SDG   = $this->load->database('3pl', TRUE);
			
		}
		
		public function Cek_no_hp($no_hp=null){
			//echo $no_hp;
			//exit();
			if($no_hp!=null){
				
				$sql ="
					SELECT
					*
					FROM CRMNEW_USER WHERE NO_HP='$no_hp'
				";
				
				$hasil = $this->db->query($sql)->result_array();
				
				if(count($hasil)>0){ //create OTP.
					$id_user = $hasil[0]['ID_USER'];
					$otp = rand(10000, 99999);
					
					$n2= "
					INSERT INTO CRMNEW_OTP
					(ID_USER, TGL_PERMINTAAN, KODE_OTP, VALIDE_DATE, STATUS, DELETE_MARK)
					VALUES
					('$id_user', sysdate,'$otp', SYSDATE, '0', '0')
					";
					
					$cek = $this->db->query($n2);
					if($cek){
						//echo 111;
						//kirim pesan ke wa
						/*
						$pesan = "CRM%20SMIG%20-%20%7B%2020019%20%7D%20Adalah%20Kode%20OTP%20untuk%20password%20anda.%20PENTING%20demi%20keamanan%20password%20anda%20jangan%20diserbakan%20ke%20orang%20lain.";
						
						$link = "https://api.whatsapp.com/send?phone=6281331179583&text=". $pesan ;
						echo $link;
						exit;
						return true;
						*/
						
						
						$email_api = urlencode("forcasupport@sisi.id");
						$passkey_api = urlencode("tcQdCz631gbprM54LcIP0zEl5");
						$no_hp_tujuan = urlencode($no_hp);
						$isi_pesan = urlencode("CRM SIG -  ".$otp."  Adalah Kode OTP untuk password anda. PENTING demi keamanan password anda jangan diserbakan ke orang lain");

						$url = "https://reguler.medansms.co.id/sms_api.php?action=kirim_sms&email=".$email_api."&passkey=".$passkey_api."&no_tujuan=".$no_hp_tujuan."&pesan=".$isi_pesan. "&json=1";
						$result = $this->SendAPI_SMS($url);
							
						//$result = file_get_contents($url);
						//$data = explode("~~~", $result);
							
						//echo $url;
						/*
						$cURLConnection = curl_init();

						curl_setopt($cURLConnection, CURLOPT_URL, $url);
						curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

						$phoneList = curl_exec($cURLConnection);
						curl_close($cURLConnection);

						//$jsonArrayResponse - json_decode($phoneList);
						/*
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response  = curl_exec($ch);
						if($response){
							print_r($response);
						}
						else {
							//echo "respone emboh";
						}
						
						exit();
						/*
						curl_close($ch);
						print_r($response);
						return $response;
						
						exit();
						$result = file_get_contents($url);
						$data = explode("~~~", $result);
						
						print_r($data);
						exit();
						echo $data[0]; //1=SUKSES, selain itu GAGAL
						*/
						return true;
						
					}
				}
				else {
					return false;
				}
			}
		}
		public function SendAPI_SMS($url){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response  = curl_exec($ch);
			curl_close($ch);
			return $response;
		}
		
		public function Reset_password($no_hp, $otp){
			if($otp!=null){
				
				$sql ="
					SELECT
					VALIDE_DATE AS TGL_CREATE_OTP,
					--to_char(VALIDE_DATE, 'YYYYMMDDHH24MISS') as OTP_TIME,
					--TO_CHAR(SYSDATE, 'YYYYMMDDHH24MISS') AS SEKARANG,
					ROUND((TO_CHAR(SYSDATE, 'YYYYMMDDHH24MISS')-to_char(VALIDE_DATE, 'YYYYMMDDHH24MISS'))/60, 0) AS OTP_VALID_MENIT
					FROM CRMNEW_OTP
					WHERE KODE_OTP='$otp'
					AND DELETE_MARK='0'
				";
				
				$hasil = $this->db->query($sql)->result_array();
				if(count($hasil)>0){//otp tidak ditemukan
					if($hasil[0]['OTP_VALID_MENIT']<5){//perubahan password
						$n2= "
						UPDATE CRMNEW_USER 
							SET PASSWORD='12345'
						WHERE NO_HP='$no_hp'
						";
						
						$cek = $this->db->query($n2);
						if($cek){
							$mhasil = array(
												'STATUS'			=> true,
												'PASSWORD_BARU' 	=>  '12345',
												'OTP_VALID_DATE' 	=> $hasil[0]['OTP_VALID_MENIT'],
												'PESAN'				=> 'PASSWORD BERHASIL DI RESET',
											);
											
							//pengiriman pesan melalui SMS
							
							$email_api = urlencode("forcasupport@sisi.id");
							$passkey_api = urlencode("tcQdCz631gbprM54LcIP0zEl5");
							$no_hp_tujuan = urlencode($no_hp);
							$isi_pesan = urlencode("CRM SIG - { '12345' } Adalah password untuk user anda yang baru. PENTING demi keamanan password anda jangan diserbakan ke orang lain.");

							$url = "https://reguler.medansms.co.id/sms_api.php?action=kirim_sms&email=".$email_api."&passkey=".$passkey_api."&no_tujuan=".$no_hp_tujuan."&pesan=".$isi_pesan. "&json=1";
							$result = $this->SendAPI_SMS($url);
							
							//$result = file_get_contents($url);
							//$data = explode("~~~", $result);
							/*
							$cURLConnection = curl_init();

							curl_setopt($cURLConnection, CURLOPT_URL, $url);
							curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

							$phoneList = curl_exec($cURLConnection);
							curl_close($cURLConnection);
							*/
							//echo $data[0]; //1=SUKSES, selain itu GAGAL
							
						}
					}
					else {//otp kadaluarsa
						$mhasil = array(
												'STATUS'			=> false,
												'PASSWORD_BARU' 	=>  null,
												'OTP_VALID_DATE' 	=> $hasil[0]['OTP_VALID_MENIT'],
												'PESAN'				=> 'OTP KADALUARSA',
											);
					}
				}
				else {
						$mhasil = array(
												'STATUS'			=> false,
												'PASSWORD_BARU' 	=>  null,
												'OTP_VALID_DATE' 	=> null,
												'PESAN'				=> 'NO OTP TIDAK VALID',
											);
				}
				
				
			}
			else {
				$mhasil = array(
												'STATUS'			=> false,
												'PASSWORD_BARU' 	=>  null,
												'OTP_VALID_DATE' 	=> null,
												'PESAN'				=> 'NO OTP TIDAK VALID',
											);
			}
			
			return $mhasil;
		}
		public function set_kapasitas_gudang_toko($data_set){
			$status = 0;
			
			$id_customer = $data_set['id_customer'];
			$id_user 	 = $data_set['id_user'];
			
			$kap_zak	 = $data_set['kapasitas_zak'];
			$kap_ton	 = $data_set['kapasitas_ton'];
			
			// echo $id_customer;
			// echo $id_user;
			// echo $ltd;
			// echo $lng;
			
			// exit(); 
			
				//CEK DATA DI DATABASE
				$sql_ceking ="
					SELECT
						*
					FROM CRMNEW_KAPASITAS_TOKO
					WHERE ID_CUSTOMER = '$id_customer'
					AND DELETE_MARK = 0
				";
				
			$ceking = $this->db->query($sql_ceking)->result_array();
			
			// print_r($ceking);
			// exit();
				
			if(count($ceking) == 1){
				//update data
				$sqlup = "
						UPDATE CRMNEW_KAPASITAS_TOKO
						SET 
						KAPASITAS_ZAK = '$kap_zak',
						KAPASITAS_TON = '$kap_ton',
						UPDATE_BY = '$id_user',
						UPDATE_DATE = SYSDATE
						WHERE ID_CUSTOMER = '$id_customer'
						AND DELETE_MARK = 0
				";
					
					$this->db->query($sqlup);
					$status=2;
			} else {
				//insert data
				$sqlin = "
						INSERT INTO CRMNEW_KAPASITAS_TOKO (ID_CUSTOMER, KAPASITAS_ZAK, KAPASITAS_TON, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_customer', '$kap_zak', '$kap_ton', '$id_user', SYSDATE, 0)
					";
					$this->db->query($sqlin);
					$status=1;
			}
			return $status;	
		}
		
		public function get_kapasitas_gudang_toko($id_customer = null){
			$sql = "
				SELECT ID_KAPASITAS_TOKO, ID_CUSTOMER, KAPASITAS_ZAK, KAPASITAS_TON FROM CRMNEW_KAPASITAS_TOKO 
				WHERE DELETE_MARK = 0
			";
			
			if($id_customer!=null){
				$sql .= " AND ID_CUSTOMER IN ($id_customer) "; 
			}
			
			$list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
		}
		
		public function set_kapasitas_gudang_toko_array($id_user, $kapasitasToko){
			$datacustomer = array();
			$getDatain = "";
			$i = 0;
			foreach($kapasitasToko as $dt){
				
				$id_cus = $dt['ID_CUSTOMER'];
				$kap_sak = $dt['KAPASITAS_ZAK'];
				$kap_ton = $dt['KAPASITAS_TON'];
				
				//CEK DATA DI DATABASE
				$sql_ceking ="
					SELECT
						*
					FROM CRMNEW_KAPASITAS_TOKO
					WHERE ID_CUSTOMER = '$id_cus'
					AND DELETE_MARK = 0
				";	
				$ceking = $this->db->query($sql_ceking)->result_array();
				
				if(count($ceking) == 1){
					$sqlin = "
						UPDATE CRMNEW_KAPASITAS_TOKO
						SET 
						KAPASITAS_ZAK 	= $kap_sak,
						KAPASITAS_TON 	= $kap_ton,
						UPDATE_BY 		= '$id_user',
						UPDATE_DATE 	= SYSDATE
						WHERE 
							ID_CUSTOMER 	= '$id_cus'
							AND DELETE_MARK 	= 0
					";
					$this->db->query($sqlin);
				} else {
					
					$sqlin = "
						INSERT INTO CRMNEW_KAPASITAS_TOKO (ID_CUSTOMER, KAPASITAS_ZAK, KAPASITAS_TON, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_cus', '$kap_sak', '$kap_ton', '$id_user', SYSDATE, 0)
					";
					$this->db->query($sqlin);
				}
				
				// set data idcutomer balikan
				$i++;
				if($i == count($kapasitasToko)){
					$getDatain .= $id_cus;
				} else {
					$getDatain .= $id_cus.",";
				}
				
			}
			
			//print_r($getDatain);
			//exit;
			
			//get data after input --
			$sqlget = "
				SELECT ID_KAPASITAS_TOKO, ID_CUSTOMER, KAPASITAS_ZAK, KAPASITAS_TON
				FROM CRMNEW_KAPASITAS_TOKO
    			WHERE ID_CUSTOMER IN ($getDatain) AND DELETE_MARK = 0
			";
			$list_data = $this->db->query($sqlget);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
		}
		
	}
?>