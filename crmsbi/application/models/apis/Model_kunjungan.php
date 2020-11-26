<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_kunjungan extends CI_Model {
		
		public function Add_schedule_kunjungan($data){
			
			$data_result = array();
			
			$status 			= 0;
			$cek 				= null;
			
			$id_user 			= $data['ID_USER'];
			$id_customer 		= $data['ID_CUSTOMER'];
			$tgl_rencana		= $data['TGL_RENCANA_KUNJUNGAN'];
			$keterangan 		= $data['KETERANGAN'];
			$CHECKIN_LATITUDE 	= $data['CHECKIN_LATITUDE'];
			$CHECKIN_LONGITUDE 	= $data['CHECKIN_LONGITUDE'];
			$CHECKOUT_LATITUDE 	= $data['CHECKOUT_LATITUDE'];
			$CHECKOUT_LONGITUDE = $data['CHECKOUT_LONGITUDE'];
			
			if($data['CHECKIN_TIME']==null || $data['CHECKIN_TIME']==''){
				$CHECKIN_TIME 	= null;
			}
			else {
				$CHECKIN_TIME 	= date('d-M-y h.s.i A', strtotime($data['CHECKIN_TIME']));
			}
			if($data['CHECKOUT_TIME']==null || $data['CHECKOUT_TIME']==''){
				$CHECKOUT_TIME 	= null;
			}
			else {
				$CHECKOUT_TIME 	= date('d-M-y h.s.i A', strtotime($data['CHECKOUT_TIME']));
			}
					
			$sql ="
				SELECT 
					TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL
				FROM CRMNEW_KUNJUNGAN_CUSTOMER
				WHERE ID_TOKO='$id_customer'
				AND ID_USER='$id_user'
				AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD')='$tgl_rencana'
			";
			
			$hasil  = $this->db->query($sql)->result_array();
			// print_r($hasil);
			
			// exit;
			$TGL_KUN = date('d-M-y', strtotime($tgl_rencana));
			
			if(count($hasil)==0){
				$sql2 = "
					INSERT INTO CRMNEW_KUNJUNGAN_CUSTOMER 
					(ID_USER, ID_TOKO, TGL_RENCANA_KUNJUNGAN, CREATED_BY, CREATED_AT, CHECKIN_TIME, CHECKIN_LATITUDE, CHECKIN_LONGITUDE, CHECKOUT_TIME, CHECKOUT_LATITUDE, CHECKOUT_LONGITUDE, KETERANGAN, DELETED_MARK)
					VALUES 
					('$id_user', '$id_customer', '$TGL_KUN', '$id_user', SYSDATE, '$CHECKIN_TIME', '$CHECKIN_LATITUDE', '$CHECKIN_LONGITUDE', '$CHECKOUT_TIME', '$CHECKOUT_LATITUDE', '$CHECKOUT_LONGITUDE', '$keterangan', 0)
				";
				$cek = $this->db->query($sql2);
				if($cek){
					$sql_select ="
						SELECT
							CC.ID_KUNJUNGAN_CUSTOMER,
							CC.ID_USER,
							JU.JENIS_USER,
							U.NAMA AS NAMA_SALES,
							CC.ID_TOKO AS ID_CUSTOMER,
							C.NAMA_TOKO AS NM_CUSTOMER,
							C.TELP_TOKO AS TELP_CUSTOMER,
							C.ALAMAT,
							C.NAMA_PEMILIK,
							CC.CHECKIN_LATITUDE,
							CC.CHECKIN_LONGITUDE,
							TO_CHAR(CC.CHECKIN_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKIN_TIME,
							CC.CHECKOUT_LATITUDE,
							CC.CHECKOUT_LONGITUDE,
							TO_CHAR(CC.CHECKOUT_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKOUT_TIME,
							TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
							CC.KETERANGAN
						FROM CRMNEW_KUNJUNGAN_CUSTOMER CC
						LEFT JOIN CRMNEW_USER U ON CC.ID_USER=U.ID_USER
						LEFT JOIN CRMNEW_JENIS_USER JU ON U.ID_JENIS_USER=JU.ID_JENIS_USER
						LEFT JOIN CRMNEW_CUSTOMER C ON CC.ID_TOKO=C.ID_CUSTOMER
						WHERE CC.ID_TOKO='$id_customer'
						AND CC.ID_USER='$id_user'
						AND TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD')='$tgl_rencana'
						ORDER BY CC.ID_KUNJUNGAN_CUSTOMER DESC
					";
					$result_insert  = $this->db->query($sql_select)->row();
					
					$data_result = $result_insert;
				}
			}
			else {
				
					
				if($data['CHECKIN_TIME']==null || $data['CHECKIN_TIME']==''){
					$status = 1;
				}else if($data['CHECKOUT_TIME']==null || $data['CHECKOUT_TIME']==''){
					$sql3 = "
					UPDATE CRMNEW_KUNJUNGAN_CUSTOMER
					SET 
						CHECKIN_TIME='$CHECKIN_TIME',
						CHECKIN_LATITUDE='$CHECKIN_LATITUDE',
						CHECKIN_LONGITUDE='$CHECKIN_LONGITUDE'
					WHERE ID_TOKO='$id_customer'
					AND ID_USER='$id_user'
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD')='$tgl_rencana' ";
											//echo $sql3;
					$cek = $this->db->query($sql3);
					if($cek){
						$status=1;
						//echo "di update 1";
					}
				}else {
					$sql3 = "
					UPDATE CRMNEW_KUNJUNGAN_CUSTOMER
					SET 
						CHECKIN_TIME='$CHECKIN_TIME',
						CHECKIN_LATITUDE='$CHECKIN_LATITUDE',
						CHECKIN_LONGITUDE='$CHECKIN_LONGITUDE',
						CHECKOUT_TIME='$CHECKOUT_TIME',
						CHECKOUT_LATITUDE='$CHECKOUT_LATITUDE',
						CHECKOUT_LONGITUDE='$CHECKOUT_LONGITUDE'
					WHERE ID_TOKO='$id_customer'
					AND ID_USER='$id_user'
					AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD')='$tgl_rencana' ";
					//echo $sql3;
					$cek = $this->db->query($sql3);
					if($cek){
						$status=1;
						//echo "di update 1";
					}
				}
				
				$sql_select_update ="
						SELECT
							CC.ID_KUNJUNGAN_CUSTOMER,
							CC.ID_USER,
							JU.JENIS_USER,
							U.NAMA AS NAMA_SALES,
							CC.ID_TOKO AS ID_CUSTOMER,
							C.NAMA_TOKO AS NM_CUSTOMER,
							C.TELP_TOKO AS TELP_CUSTOMER,
							C.ALAMAT,
							C.NAMA_PEMILIK,
							CC.CHECKIN_LATITUDE,
							CC.CHECKIN_LONGITUDE,
							TO_CHAR(CC.CHECKIN_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKIN_TIME,
							CC.CHECKOUT_LATITUDE,
							CC.CHECKOUT_LONGITUDE,
							TO_CHAR(CC.CHECKOUT_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKOUT_TIME,
							TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
							CC.KETERANGAN
						FROM CRMNEW_KUNJUNGAN_CUSTOMER CC
						LEFT JOIN CRMNEW_USER U ON CC.ID_USER=U.ID_USER
						LEFT JOIN CRMNEW_JENIS_USER JU ON U.ID_JENIS_USER=JU.ID_JENIS_USER
						LEFT JOIN CRMNEW_CUSTOMER C ON CC.ID_TOKO=C.ID_CUSTOMER
						WHERE CC.ID_TOKO='$id_customer'
						AND CC.ID_USER='$id_user'
						AND TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD')='$tgl_rencana'
					";
				$result_update  = $this->db->query($sql_select_update)->row();
					
				if($status==1){
					$data_result = $result_update;
				}
				
				
			}
				
			
			return $data_result;
			
			
		}

        public function get_data_jadwal_kunjungan($user, $tahun, $bulan){
			
			$sql ="
				SELECT
					CC.ID_KUNJUNGAN_CUSTOMER,
					CC.ID_USER,
					JU.JENIS_USER,
					U.NAMA AS NAMA_SALES,
					CC.ID_TOKO AS ID_CUSTOMER,
					C.NAMA_TOKO AS NM_CUSTOMER,
					C.TELP_TOKO AS TELP_CUSTOMER,
					C.ALAMAT,
					C.NAMA_PEMILIK,
					CC.CHECKIN_LATITUDE,
					CC.CHECKIN_LONGITUDE,
					TO_CHAR(CC.CHECKIN_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKIN_TIME,
					CC.CHECKOUT_LATITUDE,
					CC.CHECKOUT_LONGITUDE,
					TO_CHAR(CC.CHECKOUT_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKOUT_TIME,
					TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
					CC.KETERANGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER CC
				LEFT JOIN CRMNEW_USER U ON CC.ID_USER=U.ID_USER
				LEFT JOIN CRMNEW_JENIS_USER JU ON U.ID_JENIS_USER=JU.ID_JENIS_USER
				LEFT JOIN CRMNEW_CUSTOMER C ON CC.ID_TOKO=C.ID_CUSTOMER
				WHERE CC.DELETED_MARK=0 AND CC.ID_TOKO IS NOT NULL
				
			";
			
			if($user!=null){
				$sql .= " AND CC.ID_USER='$user' ";
			}
			if($tahun!=null){
				$sql .= " AND TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY')='$tahun' ";
			}
			if($bulan!=null){
				$sql .= " AND TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'MM')='$bulan' ";
			}
			
			$sql .= " ORDER BY CC.ID_KUNJUNGAN_CUSTOMER ";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_data_keluhan_pelanggan(){
			
			$sql =" 
				SELECT
				ID_KELUHAN,
				KELUHAN
				FROM CRMNEW_KELUHAN
				WHERE DELETE_MARK=0
			";
			
			return $this->db->query($sql)->result_array();			
		}
		
		public function get_data_promosi(){
			
			$sql =" 
				SELECT
				ID_PROMOSI,
				PROMOSI,
				TYPE_INPUT,
				LABEL_FIELD
				FROM CRMNEW_PROMOSI
				WHERE DELETE_MARK=0
			";
			
			return $this->db->query($sql)->result_array();			
		}
		public function get_jadwal_kunjungan($user, $TGL){
			
			$sql ="
				SELECT
					CC.ID_KUNJUNGAN_CUSTOMER,
					CC.ID_USER,
					JU.JENIS_USER,
					U.NAMA AS NAMA_SALES,
					CC.ID_TOKO AS ID_CUSTOMER,
					C.NAMA_TOKO AS NM_CUSTOMER,
					C.TELP_TOKO AS TELP_CUSTOMER,
					C.ALAMAT,
					C.NAMA_PEMILIK,
					CC.CHECKIN_LATITUDE,
					CC.CHECKIN_LONGITUDE,
					TO_CHAR(CC.CHECKIN_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKIN_TIME,
					CC.CHECKOUT_LATITUDE,
					CC.CHECKOUT_LONGITUDE,
					TO_CHAR(CC.CHECKOUT_TIME, 'YYYY-MM-DD HH24:MI:SS') AS CHECKOUT_TIME,
					TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
					CC.KETERANGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER CC
				LEFT JOIN CRMNEW_USER U ON CC.ID_USER=U.ID_USER
				LEFT JOIN CRMNEW_JENIS_USER JU ON U.ID_JENIS_USER=JU.ID_JENIS_USER
				LEFT JOIN CRMNEW_CUSTOMER C ON CC.ID_TOKO=C.ID_CUSTOMER
				WHERE CC.DELETED_MARK=0
                AND CC.ID_USER='$user'
				AND TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD')='$TGL'
				
			";
			
			return $this->db->query($sql)->result_array();
		}
    }
?>