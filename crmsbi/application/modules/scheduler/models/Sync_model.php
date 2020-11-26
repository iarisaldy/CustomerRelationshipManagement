<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
date_default_timezone_set('Asia/Jakarta');

class Sync_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('Point', TRUE);
		set_time_limit(0);
	}

	public function get_data_distributor(){
		
		$sql ="
			SELECT 
				KODE_DISTRIBUTOR, 
				NAMA_DISTRIBUTOR
			FROM CRMNEW_DISTRIBUTOR
			WHERE DELETE_MARK=0
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function User_distributor($id_user=null){
		$sql ="
			SELECT
			UD.ID_USER_DISTRIBUTOR,
			UD.ID_USER,
			UD.KODE_DISTRIBUTOR,
			D.NAMA_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR UD
			LEFT JOIN CRMNEW_DISTRIBUTOR D ON UD.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR
			WHERE UD.DELETE_MARK='0'
		";
		
		if($id_user!=null){
			$sql .= " AND UD.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result_array();
	}

	public function get_data_customer_distributor($distributor){
		
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
		";
		
		if($distributor!=null){
			$sql .= "AND C.ID_DISTRIBUTOR='$distributor' GROUP BY KODE_CUSTOMER,NAMA_TOKO,TELP_TOKO,NAMA_PEMILIK,TELP_PEMILIK,NOKTP_PEMILIK,KETERANGAN,ALAMAT,KODE_POS,FOTO_TOKO,KAPASITAS_TOKO,NAMA_DISTRIBUTOR";
		}else{
			$sql .= "GROUP BY KODE_CUSTOMER,NAMA_TOKO,TELP_TOKO,NAMA_PEMILIK,TELP_PEMILIK,NOKTP_PEMILIK,KETERANGAN,ALAMAT,KODE_POS,FOTO_TOKO,KAPASITAS_TOKO,NAMA_DISTRIBUTOR";
		}

		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_customer_bk($distributor){
		
		$sql ="
				SELECT
				DATAALL.*
				FROM 
						(
							SELECT
							DATA_CUSTOMER.KODE_CUSTOMER AS ID_CUSTOMER,
							DATA_CUSTOMER.KODE_CUSTOMER,
							DATA_CUSTOMER.NAMA_TOKO,
							DATA_CUSTOMER.TELP_TOKO,
							DATA_CUSTOMER.NAMA_PEMILIK,
							DATA_CUSTOMER.TELP_PEMILIK,
							DATA_CUSTOMER.NOKTP_PEMILIK,
							DATA_CUSTOMER.KETERANGAN,
							DATA_CUSTOMER.CREATED_BY,
							DATA_CUSTOMER.UPDATED_BY,
							DATA_CUSTOMER.DELETE_MARK,
							DATA_CUSTOMER.ALAMAT,
							DATA_CUSTOMER.KODE_POS,
							DATA_CUSTOMER.FOTO_TOKO,
							DATA_CUSTOMER.KAPASITAS_TOKO,
							DATA_CUSTOMER.ID_DISTRIBUTOR,
							DATA_CUSTOMER.CREATED_DATE,
							DATA_CUSTOMER.UPDATED_DATE,
							DATA_CUSTOMER.ID_DISTRIK,
							DATA_CUSTOMER.ID_AREA,
							DATA_CUSTOMER.ID_PROVINSI,
							DATA_CUSTOMER.ID_KECAMATAN,
							DATA_CUSTOMER.NAMA_KECAMATAN,
							DATA_CUSTOMER.STATUS_TOKO,
							DATA_CUSTOMER.NAMA_DISTRIK,
							DATA_CUSTOMER.GROUP_CUSTOMER,
							DATA_CUSTOMER.TGL_LAHIR,
							DATA_CUSTOMER.CLUSTER_TOKO,
							DATA_CUSTOMER.KD_SAP,
							DATA_CUSTOMER.KD_LT,
							DATA_CUSTOMER.FLAG

							FROM 
								(
									SELECT
									KD_CUSTOMER AS KODE_CUSTOMER,
									NOMOR_DISTRIBUTOR AS ID_DISTRIBUTOR,
									DATABK.*,
									'SBI' AS FLAG
									FROM M_CUSTOMER_DETAIL MD
									LEFT JOIN (
												SELECT
													C.ID_CUSTOMER AS ID_CUSTOMER,
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
											)DATABK ON MD.KD_CUSTOMER=DATABK.ID_CUSTOMER
									WHERE MD.NOMOR_DISTRIBUTOR IS NOT NULL
								)  DATA_CUSTOMER

							UNION

							SELECT
							DATA_CUSTOMER.KODE_CUSTOMER AS ID_CUSTOMER,
							DATA_CUSTOMER.KODE_CUSTOMER,
							DATA_CUSTOMER.NAMA_TOKO,
							DATA_CUSTOMER.TELP_TOKO,
							DATA_CUSTOMER.NAMA_PEMILIK,
							DATA_CUSTOMER.TELP_PEMILIK,
							DATA_CUSTOMER.NOKTP_PEMILIK,
							DATA_CUSTOMER.KETERANGAN,
							DATA_CUSTOMER.CREATED_BY,
							DATA_CUSTOMER.UPDATED_BY,
							DATA_CUSTOMER.DELETE_MARK,
							DATA_CUSTOMER.ALAMAT,
							DATA_CUSTOMER.KODE_POS,
							DATA_CUSTOMER.FOTO_TOKO,
							DATA_CUSTOMER.KAPASITAS_TOKO,
							DATA_CUSTOMER.ID_DISTRIBUTOR,
							DATA_CUSTOMER.CREATED_DATE,
							DATA_CUSTOMER.UPDATED_DATE,
							DATA_CUSTOMER.ID_DISTRIK,
							DATA_CUSTOMER.ID_AREA,
							DATA_CUSTOMER.ID_PROVINSI,
							DATA_CUSTOMER.ID_KECAMATAN,
							DATA_CUSTOMER.NAMA_KECAMATAN,
							DATA_CUSTOMER.STATUS_TOKO,
							DATA_CUSTOMER.NAMA_DISTRIK,
							DATA_CUSTOMER.GROUP_CUSTOMER,
							DATA_CUSTOMER.TGL_LAHIR,
							DATA_CUSTOMER.CLUSTER_TOKO,
							DATA_CUSTOMER.KD_SAP,
							DATA_CUSTOMER.KD_LT,
							DATA_CUSTOMER.FLAG

							FROM 
								(
									SELECT
									KD_CUSTOMER AS KODE_CUSTOMER,
									NOMOR_DISTRIBUTOR2 AS ID_DISTRIBUTOR,
									DATABK.*,
									'SBI' AS FLAG
									FROM M_CUSTOMER_DETAIL MD
									LEFT JOIN (
												SELECT
													C.ID_CUSTOMER AS ID_CUSTOMER,
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
											)DATABK ON MD.KD_CUSTOMER=DATABK.ID_CUSTOMER
									WHERE MD.NOMOR_DISTRIBUTOR2 IS NOT NULL
								)  DATA_CUSTOMER

							UNION

							SELECT
							DATA_CUSTOMER.KODE_CUSTOMER AS ID_CUSTOMER,
							DATA_CUSTOMER.KODE_CUSTOMER,
							DATA_CUSTOMER.NAMA_TOKO,
							DATA_CUSTOMER.TELP_TOKO,
							DATA_CUSTOMER.NAMA_PEMILIK,
							DATA_CUSTOMER.TELP_PEMILIK,
							DATA_CUSTOMER.NOKTP_PEMILIK,
							DATA_CUSTOMER.KETERANGAN,
							DATA_CUSTOMER.CREATED_BY,
							DATA_CUSTOMER.UPDATED_BY,
							DATA_CUSTOMER.DELETE_MARK,
							DATA_CUSTOMER.ALAMAT,
							DATA_CUSTOMER.KODE_POS,
							DATA_CUSTOMER.FOTO_TOKO,
							DATA_CUSTOMER.KAPASITAS_TOKO,
							DATA_CUSTOMER.ID_DISTRIBUTOR,
							DATA_CUSTOMER.CREATED_DATE,
							DATA_CUSTOMER.UPDATED_DATE,
							DATA_CUSTOMER.ID_DISTRIK,
							DATA_CUSTOMER.ID_AREA,
							DATA_CUSTOMER.ID_PROVINSI,
							DATA_CUSTOMER.ID_KECAMATAN,
							DATA_CUSTOMER.NAMA_KECAMATAN,
							DATA_CUSTOMER.STATUS_TOKO,
							DATA_CUSTOMER.NAMA_DISTRIK,
							DATA_CUSTOMER.GROUP_CUSTOMER,
							DATA_CUSTOMER.TGL_LAHIR,
							DATA_CUSTOMER.CLUSTER_TOKO,
							DATA_CUSTOMER.KD_SAP,
							DATA_CUSTOMER.KD_LT,
							DATA_CUSTOMER.FLAG

							FROM 
								(
									SELECT
									KD_CUSTOMER AS KODE_CUSTOMER,
									NOMOR_DISTRIBUTOR3 AS ID_DISTRIBUTOR,
									DATABK.*,
									'SBI' AS FLAG
									FROM M_CUSTOMER_DETAIL MD
									LEFT JOIN (
												SELECT
													C.ID_CUSTOMER AS ID_CUSTOMER,
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
											)DATABK ON MD.KD_CUSTOMER=DATABK.ID_CUSTOMER
									WHERE MD.NOMOR_DISTRIBUTOR3 IS NOT NULL
								)  DATA_CUSTOMER

							UNION

							SELECT
							DATA_CUSTOMER.KODE_CUSTOMER AS ID_CUSTOMER,
							DATA_CUSTOMER.KODE_CUSTOMER,
							DATA_CUSTOMER.NAMA_TOKO,
							DATA_CUSTOMER.TELP_TOKO,
							DATA_CUSTOMER.NAMA_PEMILIK,
							DATA_CUSTOMER.TELP_PEMILIK,
							DATA_CUSTOMER.NOKTP_PEMILIK,
							DATA_CUSTOMER.KETERANGAN,
							DATA_CUSTOMER.CREATED_BY,
							DATA_CUSTOMER.UPDATED_BY,
							DATA_CUSTOMER.DELETE_MARK,
							DATA_CUSTOMER.ALAMAT,
							DATA_CUSTOMER.KODE_POS,
							DATA_CUSTOMER.FOTO_TOKO,
							DATA_CUSTOMER.KAPASITAS_TOKO,
							DATA_CUSTOMER.ID_DISTRIBUTOR,
							DATA_CUSTOMER.CREATED_DATE,
							DATA_CUSTOMER.UPDATED_DATE,
							DATA_CUSTOMER.ID_DISTRIK,
							DATA_CUSTOMER.ID_AREA,
							DATA_CUSTOMER.ID_PROVINSI,
							DATA_CUSTOMER.ID_KECAMATAN,
							DATA_CUSTOMER.NAMA_KECAMATAN,
							DATA_CUSTOMER.STATUS_TOKO,
							DATA_CUSTOMER.NAMA_DISTRIK,
							DATA_CUSTOMER.GROUP_CUSTOMER,
							DATA_CUSTOMER.TGL_LAHIR,
							DATA_CUSTOMER.CLUSTER_TOKO,
							DATA_CUSTOMER.KD_SAP,
							DATA_CUSTOMER.KD_LT,
							DATA_CUSTOMER.FLAG

							FROM 
								(
									SELECT
									KD_CUSTOMER AS KODE_CUSTOMER,
									DATABK.KD_DISTRIBUTOR AS ID_DISTRIBUTOR,
									DATABK.ID_CUSTOMER,
									DATABK.NAMA_TOKO,
									DATABK.TELP_TOKO,
									DATABK.NAMA_PEMILIK,
									DATABK.TELP_PEMILIK,
									DATABK.NOKTP_PEMILIK,
									DATABK.KETERANGAN,
									DATABK.CREATED_BY,
									DATABK.UPDATED_BY,
									DATABK.DELETE_MARK,
									DATABK.ALAMAT,
									DATABK.KODE_POS,
									DATABK.FOTO_TOKO,
									DATABK.KAPASITAS_TOKO,
									DATABK.CREATED_DATE,
									DATABK.UPDATED_DATE,
									DATABK.ID_DISTRIK,
									DATABK.ID_AREA,
									DATABK.ID_PROVINSI,
									DATABK.ID_KECAMATAN,
									DATABK.NAMA_KECAMATAN,
									DATABK.STATUS_TOKO,
									DATABK.NAMA_DISTRIK,
									DATABK.GROUP_CUSTOMER,
									DATABK.TGL_LAHIR,
									DATABK.CLUSTER_TOKO,
									DATABK.KD_SAP,
									DATABK.KD_LT,
									'SBI' AS FLAG
									FROM M_CUSTOMER_DETAIL MD
									LEFT JOIN (
												SELECT
													C.ID_CUSTOMER AS ID_CUSTOMER,
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
													C.CREATED_AT AS CREATED_DATE,
													C.UPDATED_AT AS UPDATED_DATE,
													C.NOMOR_DISTRIBUTOR AS KD_DISTRIBUTOR,
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
											)DATABK ON MD.KD_CUSTOMER=DATABK.ID_CUSTOMER
											AND DATABK.KD_DISTRIBUTOR IS NOT NULL
									WHERE MD.NOMOR_DISTRIBUTOR IS NULL
									AND MD.FLAG_SBI='1'
									AND DATABK.NAMA_TOKO IS NOT NULL
								)  DATA_CUSTOMER

							UNION

							SELECT
							DATA_CUSTOMER.KODE_CUSTOMER AS ID_CUSTOMER,
							DATA_CUSTOMER.KODE_CUSTOMER,
							DATA_CUSTOMER.NAMA_TOKO,
							DATA_CUSTOMER.TELP_TOKO,
							DATA_CUSTOMER.NAMA_PEMILIK,
							DATA_CUSTOMER.TELP_PEMILIK,
							DATA_CUSTOMER.NOKTP_PEMILIK,
							DATA_CUSTOMER.KETERANGAN,
							DATA_CUSTOMER.CREATED_BY,
							DATA_CUSTOMER.UPDATED_BY,
							DATA_CUSTOMER.DELETE_MARK,
							DATA_CUSTOMER.ALAMAT,
							DATA_CUSTOMER.KODE_POS,
							DATA_CUSTOMER.FOTO_TOKO,
							DATA_CUSTOMER.KAPASITAS_TOKO,
							DATA_CUSTOMER.ID_DISTRIBUTOR,
							DATA_CUSTOMER.CREATED_DATE,
							DATA_CUSTOMER.UPDATED_DATE,
							DATA_CUSTOMER.ID_DISTRIK,
							DATA_CUSTOMER.ID_AREA,
							DATA_CUSTOMER.ID_PROVINSI,
							DATA_CUSTOMER.ID_KECAMATAN,
							DATA_CUSTOMER.NAMA_KECAMATAN,
							DATA_CUSTOMER.STATUS_TOKO,
							DATA_CUSTOMER.NAMA_DISTRIK,
							DATA_CUSTOMER.GROUP_CUSTOMER,
							DATA_CUSTOMER.TGL_LAHIR,
							DATA_CUSTOMER.CLUSTER_TOKO,
							DATA_CUSTOMER.KD_SAP,
							DATA_CUSTOMER.KD_LT,
							DATA_CUSTOMER.FLAG

							FROM 
								(
									SELECT
									KD_CUSTOMER AS KODE_CUSTOMER,
									DATABK.KD_DISTRIBUTOR AS ID_DISTRIBUTOR,
									DATABK.ID_CUSTOMER,
									DATABK.NAMA_TOKO,
									DATABK.TELP_TOKO,
									DATABK.NAMA_PEMILIK,
									DATABK.TELP_PEMILIK,
									DATABK.NOKTP_PEMILIK,
									DATABK.KETERANGAN,
									DATABK.CREATED_BY,
									DATABK.UPDATED_BY,
									DATABK.DELETE_MARK,
									DATABK.ALAMAT,
									DATABK.KODE_POS,
									DATABK.FOTO_TOKO,
									DATABK.KAPASITAS_TOKO,
									DATABK.CREATED_DATE,
									DATABK.UPDATED_DATE,
									DATABK.ID_DISTRIK,
									DATABK.ID_AREA,
									DATABK.ID_PROVINSI,
									DATABK.ID_KECAMATAN,
									DATABK.NAMA_KECAMATAN,
									DATABK.STATUS_TOKO,
									DATABK.NAMA_DISTRIK,
									DATABK.GROUP_CUSTOMER,
									DATABK.TGL_LAHIR,
									DATABK.CLUSTER_TOKO,
									DATABK.KD_SAP,
									DATABK.KD_LT,
									'SBI' AS FLAG
									FROM M_CUSTOMER_DETAIL MD
									LEFT JOIN (
												SELECT
													C.ID_CUSTOMER AS ID_CUSTOMER,
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
													C.CREATED_AT AS CREATED_DATE,
													C.UPDATED_AT AS UPDATED_DATE,
													C.NOMOR_DISTRIBUTOR AS KD_DISTRIBUTOR,
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
											)DATABK ON MD.KD_CUSTOMER=DATABK.ID_CUSTOMER
											AND DATABK.KD_DISTRIBUTOR IS NOT NULL
									WHERE MD.NOMOR_DISTRIBUTOR IS NULL
									AND MD.FLAG_SBI='0'
									AND DATABK.NAMA_TOKO IS NOT NULL
								)  DATA_CUSTOMER
						) DATAALL
				WHERE DATAALL.ID_DISTRIBUTOR='$distributor' 
		";
		
		$data_hasil = $this->db2->query($sql)->result_array();
		
		return $this->db->insert_batch('CRMNEW_CUSTOMER',$data_hasil);
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