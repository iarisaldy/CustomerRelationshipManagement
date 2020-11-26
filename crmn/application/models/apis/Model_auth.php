<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_auth extends CI_Model {

        function __construct(){
            parent::__construct();
            $this->load->database();
        }
		public function Cek_no_hp($no_hp=null){
			if($no_hp!=null){
				
				$sql ="
					SELECT
					*
					FROM CRMNEW_USER WHERE NO_HP='081331179583'
				";
				
				$hasil = $this->db->query($sql)->result_array();
				if(count($hasil)>0){ //create OTP.
					
				}
				else {
					
				}
			}
		}

        public function checkUser($username, $password){
            /*
			$this->db->select('CRMNEW_USER.ID_USER, CRMNEW_USER.NAMA, CRMNEW_JENIS_USER.ID_JENIS_USER, CRMNEW_JENIS_USER.JENIS_USER, CRMNEW_USER.EMAIL, CRMNEW_USER.ID_REGION');
            $this->db->from('CRMNEW_USER');
            $this->db->join('CRMNEW_JENIS_USER', 'CRMNEW_USER.ID_JENIS_USER = CRMNEW_JENIS_USER.ID_JENIS_USER');
            $this->db->where('USERNAME', $username);
            $this->db->where('PASSWORD', $password);
            $this->db->where('CRMNEW_USER.DELETED_MARK', 0);*/
			
			$sql ="
				SELECT
				A.ID_USER,
				A.NAMA,
				A.ID_JENIS_USER,
				B.JENIS_USER,
				A.EMAIL,
				A.NO_HP
				FROM CRMNEW_USER A
				LEFT JOIN CRMNEW_JENIS_USER B ON A.ID_JENIS_USER=B.ID_JENIS_USER
				WHERE A.DELETED_MARK='0'
				AND (A.USERNAME='$username' OR A.NO_HP='$username')
				AND A.PASSWORD='$password'
			";
			
				
			$user = $this->db->query($sql)->row();
			
			if(count($user)>0){
				return $user;
			}
			else {
				return false;
			}
            /*/$user = $this->db->get();
            if($user->num_rows() > 0){
                return $user->row();
            } else {
                return false;
            }*/
        }
		
		public function User_area($id_user){
			
			$sql ="
				SELECT 
					ID_AREA
				FROM CRMNEW_USER_AREA 
				WHERE ID_USER='$id_user'
				AND DELETE_MARK=0
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		public function User_provinsi($id_user){
			
			$sql ="
				SELECT
				ID_PROVINSI
				FROM CRMNEW_USER_PROVINSI
				WHERE ID_USER='$id_user'
				AND DELETE_MARK=0
			";
			
			return $this->db->query($sql)->result_array();
		}
		
		public function User_distributor($id_user){
			
			$sql ="
				SELECT
				KODE_DISTRIBUTOR
				FROM CRMNEW_USER_DISTRIBUTOR
				WHERE ID_USER='$id_user'
				AND DELETE_MARK=0
			";
			
			return $this->db->query($sql)->result_array();
		}

    }
?>