<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
date_default_timezone_set('Asia/Jakarta');

class Sync_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		//$this->db = $this->load->database('default', TRUE);
		$this->db = $this->load->database('crm', TRUE);
		$this->db2 = $this->load->database('Point', TRUE);
		set_time_limit(0);
	}

	public function get_data_distributor(){
		
		$sql ="
			SELECT 
				KODE_DISTRIBUTOR, 
				NAMA_DISTRIBUTOR
			FROM CRMNEW_DISTRIBUTOR
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function User_distributor($id_user=null){
		$sql ="
			SELECT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM SO_DISTRIBUTOR 
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_user!=null){
			$sql .= " AND ID_SO='$id_user' ";
		}
		
		return $this->db->query($sql)->result_array();
	}

	public function get_data_customer_distributor($distributor,$dis_tso, $ID_TSO=null){
		
		$sql ="
			SELECT 
				C.KODE_CUSTOMER,
				C.NAMA_TOKO,
				C.TELP_TOKO,
				C.NAMA_PEMILIK,
				C.TELP_PEMILIK,
				C.NOKTP_PEMILIK,
				C.KETERANGAN,
				C.ALAMAT,
				C.KODE_POS,
				C.FOTO_TOKO,
				C.KAPASITAS_TOKO,		
                DIST.NAMA_DISTRIBUTOR
			FROM CRMNEW_CUSTOMER C
            LEFT JOIN CRMNEW_DISTRIBUTOR DIST ON C.ID_DISTRIBUTOR=DIST.KODE_DISTRIBUTOR
			WHERE C.DELETE_MARK=0
			AND C.ID_DISTRIK IN (SELECT KD_KOTA FROM DISTRIK_TSO WHERE ID_USER='$ID_TSO')
		";
			if($distributor!=null){
			$sql .= "AND C.ID_DISTRIBUTOR='$distributor' GROUP BY KODE_CUSTOMER,NAMA_TOKO,TELP_TOKO,NAMA_PEMILIK,TELP_PEMILIK,NOKTP_PEMILIK,KETERANGAN,ALAMAT,KODE_POS,FOTO_TOKO,KAPASITAS_TOKO,NAMA_DISTRIBUTOR";
			}
			//else{
			//$sql .= "AND C.ID_DISTRIBUTOR IN ($dis_tso) GROUP BY KODE_CUSTOMER,NAMA_TOKO,TELP_TOKO,NAMA_PEMILIK,TELP_PEMILIK,NOKTP_PEMILIK,KETERANGAN,ALAMAT,KODE_POS,FOTO_TOKO,KAPASITAS_TOKO,NAMA_DISTRIBUTOR";
			//}
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_customer_distributor_all($distributor){
		
		$sql ="
			SELECT 
				C.KODE_CUSTOMER,
				C.NAMA_TOKO,
				C.TELP_TOKO,
				C.NAMA_PEMILIK,
				C.TELP_PEMILIK,
				C.NOKTP_PEMILIK,
				C.KETERANGAN,
				C.ALAMAT,
				C.KODE_POS,
				C.FOTO_TOKO,
				C.KAPASITAS_TOKO,
				C.NAMA_DISTRIK,
                P.NEW_REGION,
				P.NAMA_PROVINSI,
                A.NAMA_AREA,
                DIST.NAMA_DISTRIBUTOR
			FROM CRMNEW_CUSTOMER C
            LEFT JOIN CRMNEW_DISTRIBUTOR DIST ON C.ID_DISTRIBUTOR=DIST.KODE_DISTRIBUTOR
            LEFT JOIN CRMNEW_M_PROVINSI P ON C.ID_PROVINSI=P.ID_PROVINSI
            LEFT JOIN CRMNEW_M_AREA A ON C.ID_AREA=A.KD_AREA
			WHERE C.DELETE_MARK=0
			AND C.ID_DISTRIBUTOR = '$distributor'
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_customer_bk($distributor){
		
		$sql =" 
			select
				*
				from (
				SELECT
				BK.KD_CUSTOMER AS ID_CUSTOMER,
				BK.KD_CUSTOMER AS KODE_CUSTOMER,
				BK.NAMA_TOKO,
				BK.NO_TELP_TOKO AS TELP_TOKO,
				BK.NM_CUSTOMER AS NAMA_PEMILIK,
				BK.NO_HANDPHONE AS TELP_PEMILIK,
				'BK' AS CREATED_BY,
				'0' AS DELETE_MARK,
				BK.ALAMAT_TOKO AS ALAMAT,
				BK.NOMOR_DISTRIBUTOR AS ID_DISTRIBUTOR,
				BK.KD_DISTRIK AS ID_DISTRIK,
				BK.ID_AREA AS ID_AREA,
				BK.KD_PROVINSI AS ID_PROVINSI,
				BK.KD_KECAMATAN AS ID_KECAMATAN,
				BK.KECAMATAN AS NAMA_KECAMATAN,
				BK.STATUS AS STATUS_TOKO,
				BK.NM_DISTRIK AS NAMA_DISTRIK,
				BK.GROUP_CUSTOMER AS GROUP_CUSTOMER,
				'SBI' AS FLAG
				FROM VIEW_M_CUSTOMER@S1 BK
				WHERE BK.NOMOR_DISTRIBUTOR IS NOT NULL
				UNION 
				SELECT
				BK.KD_CUSTOMER AS ID_CUSTOMER,
				BK.KD_CUSTOMER AS KODE_CUSTOMER,
				BK.NAMA_TOKO,
				BK.NO_TELP_TOKO AS TELP_TOKO,
				BK.NM_CUSTOMER AS NAMA_PEMILIK,
				BK.NO_HANDPHONE AS TELP_PEMILIK,
				'BK' AS CREATED_BY,
				'0' AS DELETE_MARK,
				BK.ALAMAT_TOKO AS ALAMAT,
				BK.NOMOR_DISTRIBUTOR1 AS ID_DISTRIBUTOR,
				BK.KD_DISTRIK AS ID_DISTRIK,
				BK.ID_AREA AS ID_AREA,
				BK.KD_PROVINSI AS ID_PROVINSI,
				BK.KD_KECAMATAN AS ID_KECAMATAN,
				BK.KECAMATAN AS NAMA_KECAMATAN,
				BK.STATUS AS STATUS_TOKO,
				BK.NM_DISTRIK AS NAMA_DISTRIK,
				BK.GROUP_CUSTOMER AS GROUP_CUSTOMER,
				'SBI' AS FLAG
				FROM VIEW_M_CUSTOMER@S1 BK
				WHERE BK.NOMOR_DISTRIBUTOR1 IS NOT NULL
				UNION 
				SELECT
				BK.KD_CUSTOMER AS ID_CUSTOMER,
				BK.KD_CUSTOMER AS KODE_CUSTOMER,
				BK.NAMA_TOKO,
				BK.NO_TELP_TOKO AS TELP_TOKO,
				BK.NM_CUSTOMER AS NAMA_PEMILIK,
				BK.NO_HANDPHONE AS TELP_PEMILIK,
				'BK' AS CREATED_BY,
				'0' AS DELETE_MARK,
				BK.ALAMAT_TOKO AS ALAMAT,
				BK.NOMOR_DISTRIBUTOR2 AS ID_DISTRIBUTOR,
				BK.KD_DISTRIK AS ID_DISTRIK,
				BK.ID_AREA AS ID_AREA,
				BK.KD_PROVINSI AS ID_PROVINSI,
				BK.KD_KECAMATAN AS ID_KECAMATAN,
				BK.KECAMATAN AS NAMA_KECAMATAN,
				BK.STATUS AS STATUS_TOKO,
				BK.NM_DISTRIK AS NAMA_DISTRIK,
				BK.GROUP_CUSTOMER AS GROUP_CUSTOMER,
				'SBI' AS FLAG
				FROM VIEW_M_CUSTOMER@S1 BK
				WHERE BK.NOMOR_DISTRIBUTOR2 IS NOT NULL
				UNION 
				SELECT
				BK.KD_CUSTOMER AS ID_CUSTOMER,
				BK.KD_CUSTOMER AS KODE_CUSTOMER,
				BK.NAMA_TOKO,
				BK.NO_TELP_TOKO AS TELP_TOKO,
				BK.NM_CUSTOMER AS NAMA_PEMILIK,
				BK.NO_HANDPHONE AS TELP_PEMILIK,
				'BK' AS CREATED_BY,
				'0' AS DELETE_MARK,
				BK.ALAMAT_TOKO AS ALAMAT,
				BK.NOMOR_DISTRIBUTOR3 AS ID_DISTRIBUTOR,
				BK.KD_DISTRIK AS ID_DISTRIK,
				BK.ID_AREA AS ID_AREA,
				BK.KD_PROVINSI AS ID_PROVINSI,
				BK.KD_KECAMATAN AS ID_KECAMATAN,
				BK.KECAMATAN AS NAMA_KECAMATAN,
				BK.STATUS AS STATUS_TOKO,
				BK.NM_DISTRIK AS NAMA_DISTRIK,
				BK.GROUP_CUSTOMER AS GROUP_CUSTOMER,
				'SBI' AS FLAG
				FROM VIEW_M_CUSTOMER@S1 BK
				WHERE BK.NOMOR_DISTRIBUTOR3 IS NOT NULL
				)
				WHERE ID_DISTRIBUTOR='$distributor'
                
		";

		/*
		AND ID_CUSTOMER NOT IN (select ID_CUSTOMER FROM
						CRMNEW_CUSTOMER
					WHERE 
						ID_DISTRIBUTOR ='$distributor'
						AND IS_UPDATE='1')
						
		$dis_user = $this->make_customer_crm_update($distributor);
		$n=1;
		$fild = '';
		if(count($dis_user)>0){
			foreach($dis_user as $d){
						
				if(count($dis_user)>$n){
					$fild .= "'". $d['ID_CUSTOMER']."',";
				}
				else {
					$fild .= "'". $d['ID_CUSTOMER']."'";
				}
				$n=$n+1;		
			}

			$sql .=" AND ID_CUSTOMER NOT IN ($fild)";
		}
		*/
		
		$data_hasil = $this->db->query($sql)->result_array();
		
		if(count($data_hasil)>0){
			return $this->db->insert_batch('CRMNEW_CUSTOMER',$data_hasil);
		}else{
			return false;
		}
		
	}
	
	private function make_customer_crm_update($distributor){

		$sql = " select ID_CUSTOMER FROM
						CRMNEW_CUSTOMER
					WHERE 
						ID_DISTRIBUTOR ='$distributor'
						AND IS_UPDATE='1' ";

		return $this->db->query($sql)->result_array();
	}
	
	
	public function get_data_customer_distributor_NOT_IN($distributor){
		
		$sql ="
			SELECT 
				KODE_CUSTOMER
			FROM CRMNEW_CUSTOMER
			WHERE ID_DISTRIBUTOR='$distributor'
			AND DELETE_MARK=0
		";
		
		$hasil = $this->db->query($sql)->result_array();
		
		$string_NI =null;
		
		if(count($hasil)>0){
			$n=1;
			$mak_row=count($hasil);

			foreach($hasil as $h){
				if($mak_row>$n){
					$string_NI .= "'". $h['KODE_CUSTOMER']. "',";
				}
				else {
					$string_NI .= "'". $h['KODE_CUSTOMER']. "'";
				}
				$n=$n+1;
			}
		}
		
		return $string_NI;
	}

	public function delete_customer_distributor($distributor){
		
		$sql ="
			UPDATE CRMNEW_CUSTOMER 
			SET
			DELETE_MARK=1,
			UPDATED_BY='UPDATE',
			UPDATED_DATE=SYSDATE
			WHERE ID_DISTRIBUTOR='$distributor'
		";
		$this->db->query($sql);
	}

	public function get_data_distributor_IN(){
		
		$sql ="
			SELECT 
			    KODE_DISTRIBUTOR
			FROM CRMNEW_DISTRIBUTOR
			WHERE DELETE_MARK=0
		";
		
		$hasil = $this->db->query($sql)->result_array();
		
		$string_NI =null;
		
		if(count($hasil)>0){
			$n=1;
			$mak_row=count($hasil);

			foreach($hasil as $h){
				if($mak_row>$n){
					$string_NI .= "'". $h['KODE_DISTRIBUTOR']. "',";
				}
				else {
					$string_NI .= "'". $h['KODE_DISTRIBUTOR']. "'";
				}
				$n=$n+1;
			}
		}
		
		return $string_NI;
	}
	
	public function get_data_customer_bk_all($not_in){
		
		$this->db = $this->load->database('crm', TRUE);
		$sql ="
			SELECT
				C.ID_CUSTOMER AS ID_CUSTOMER,
				C.ID_CUSTOMER AS KODE_CUSTOMER,
				C.NAMA_TOKO AS NAMA_TOKO,
				C.NO_TELP_TOKO AS TELP_TOKO,
				C.NM_CUSTOMER AS NAMA_PEMILIK,
				C.NO_HANDPHONE AS TELP_PEMILIK,
				C.NO_KTP AS NOKTP_PEMILIK,
				NULL AS KETERANGAN,
				'BK' AS CREATED_BY,
				NULL AS UPDATED_BY,
				0 AS DELETE_MARK,
				C.ALAMAT_TOKO AS ALAMAT,
				C.POSTAL_CODE AS KODE_POS,
				C.FOTO AS FOTO_TOKO,
				C.KAPASITAS AS KAPASITAS_TOKO,
				C.NOMOR_DISTRIBUTOR AS ID_DISTRIBUTOR,
				SYSDATE AS CREATED_DATE,
				NULL AS UPDATED_DATE,
				C.KD_DISTRIK AS ID_DISTRIK,
				C.ID_AREA,
				C.KD_PROVINSI AS ID_PROVINSI,
				C.KD_KECAMATAN AS ID_KECAMATAN,
                C.KECAMATAN AS NAMA_KECAMATAN,
                P.STATUS AS STATUS_TOKO,
                C.NM_DISTRIK AS NAMA_DISTRIK,
                C.GROUP_CUSTOMER AS GROUP_CUSTOMER,
                C.TGL_LAHIR AS TGL_LAHIR,
                c.status_toko AS CLUSTER_TOKO
			FROM M_CUSTOMER C
			LEFT JOIN P_USER P ON C.ID_CUSTOMER=P.KD_CUSTOMER
			WHERE P.STATUS IN (1, 2, 4)
			
			-- AND C.KD_DISTRIK !=0 
   --          AND C.KD_PROVINSI !=0
   --          AND C.ID_AREA IS NOT NULL
   --          AND C.KD_KECAMATAN IS NOT NULL
			 
		";
		
		if($not_in!=null){
			$sql .= ' AND C.NOMOR_DISTRIBUTOR IN ('.$not_in.') ';
		}
		else {
			
		}
		
		//echo $sql;
		
		$data_hasil = $this->db2->query($sql)->result_array();
		
		 echo '<pre>';
		 print_r($data_hasil);
		 echo '</pre>';
//		 exit;
		
		
		return $this->db->insert_batch('CRMNEW_CUSTOMER',$data_hasil);
		
	}
        
        public function get_customer_bk($tgl = null){
        	$whereDate = "";
        	if(isset($tgl)){
        		if($tgl != ""){
        			$whereDate = "WHERE TO_CHAR(C.UPDATED_AT, 'YYYY-MM-DD') = '$tgl'";
        		}
        	} else {
        		$whereDate = "";
        	}
            
            $sql ="
			SELECT
				C.ID_CUSTOMER AS ID_CUSTOMER,
				C.ID_CUSTOMER AS KODE_CUSTOMER,
				C.NAMA_TOKO AS NAMA_TOKO,
				C.NO_TELP_TOKO AS TELP_TOKO,
				C.NM_CUSTOMER AS NAMA_PEMILIK,
				C.NO_HANDPHONE AS TELP_PEMILIK,
				C.NO_KTP AS NOKTP_PEMILIK,
				NULL AS KETERANGAN,
				'BK' AS CREATED_BY,
				NULL AS UPDATED_BY,
				0 AS DELETE_MARK,
				C.ALAMAT_TOKO AS ALAMAT,
				C.POSTAL_CODE AS KODE_POS,
				C.FOTO AS FOTO_TOKO,
				C.KAPASITAS AS KAPASITAS_TOKO,
				C.NOMOR_DISTRIBUTOR AS ID_DISTRIBUTOR,
				C.CREATED_AT AS CREATED_DATE,
				C.UPDATED_AT AS UPDATED_DATE,
				C.KD_DISTRIK AS ID_DISTRIK,
				C.ID_AREA,
				C.KD_PROVINSI AS ID_PROVINSI,
				C.KD_KECAMATAN AS ID_KECAMATAN,
                C.KECAMATAN AS NAMA_KECAMATAN,
                P.STATUS AS STATUS_TOKO,
                C.NM_DISTRIK AS NAMA_DISTRIK,
                C.GROUP_CUSTOMER AS GROUP_CUSTOMER,
                C.TGL_LAHIR AS TGL_LAHIR,
                c.status_toko AS CLUSTER_TOKO,
                c.kd_sap  AS KD_SAP,
                c.kd_lt as KD_LT
			FROM M_CUSTOMER C
			LEFT JOIN P_USER P ON C.ID_CUSTOMER=P.KD_CUSTOMER
			$whereDate
			";
            
            return $this->db2->query($sql)->result_array();
            
        }

        public function checkCustomer($idCustomer){
        	$this->db->select("ID_CUSTOMER");
        	$this->db->from("CRMNEW_CUSTOMER");
        	$this->db->where("ID_CUSTOMER", $idCustomer);

        	$customer = $this->db->get();
        	if($customer->num_rows() > 0){
        		return $customer->row();
        	} else {
        		return false;
        	}
        }
        
        public function insert_data($data){
        	foreach ($data as $d){
        		$this->db->insert('CRMNEW_CUSTOMER', $d);
        		print_r($d);
        	}
        }

        public function insert_new_data($data){
        	$dbRet = $this->db->insert("CRMNEW_CUSTOMER", $data);
        }

        public function update_data($data){
        	$dbRet = $this->db->where("ID_CUSTOMER", $data['ID_CUSTOMER'])->update("CRMNEW_CUSTOMER", $data);
        }

        public function insertLog($data, $tgl = null){
        	$dateNow = date('Y-m-d H:i:s');
        	$this->db->set('SYNC_DATE',"TO_DATE('$tgl','yyyy-mm-dd HH24:MI:SS')", false);
        	$this->db->set('SYNC_ACTION',"TO_DATE('$dateNow','yyyy-mm-dd HH24:MI:SS')", false);
        	$dbRet = $this->db->insert("CRMNEW_LOG_SYNC_CUSTOMER", $data);
        }
		
		public function hapus_data($distributor)
		{
			
			$sql ="
					DELETE 
					FROM
						CRMNEW_CUSTOMER
					WHERE 
						ID_DISTRIBUTOR ='$distributor'
						
			";
		
			$hasil = $this->db->query($sql);
			return $hasil;
		}

    }


?>