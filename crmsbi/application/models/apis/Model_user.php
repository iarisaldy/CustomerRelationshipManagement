<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_user extends CI_Model {

        public function Perubahan_password_user($id_user, $pass_lama, $pass_baru){
			
			$status = null;
			
			$bkl = "
				SELECT 
				PASSWORD
				FROM CRMNEW_USER
				WHERE ID_USER='$id_user'
			";
			
			$hasil = $this->db->query($bkl)->result_array();
			
			if(count($hasil)==1){
				$passdb = $hasil[0]['PASSWORD'];
				if($passdb==$pass_lama){
					$sql ="
						UPDATE CRMNEW_USER 
						SET 
						PASSWORD='$pass_baru',
						UPDATED_BY='$id_user',
						UPDATED_AT=SYSDATE
						WHERE ID_USER='$id_user'
						AND PASSWORD='$pass_lama'
					";
					$cek = $this->db->query($sql);
					if($cek){
						$status=1;
					}
					
				}
			}
			
			return $status;
		}

    }
?>