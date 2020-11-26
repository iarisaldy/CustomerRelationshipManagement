<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Program_promosi_model extends CI_Model {
		
		public function Data_promosi($kd_program = null, $id_tso = null){
			$sql = " 
				SELECT
					CMPP.NO_PROMOSI,
					CMPP.KODE_PROGRAM,
					CMPP.NAMA_PROGRAM,
					CMPP.DESCRIPSI_PROGRAM,
					TO_CHAR(CMPP.TGL_MULAI, 'DD-MM-YYYY') AS TGL_MULAI,
					TO_CHAR(CMPP.TGL_SELESAI, 'DD-MM-YYYY') AS TGL_SELESAI,
					CMPP.BERLAKU_SELAMANYA,
					CTPP.NO_TPP,
					CTPP.NO_PRODUK,
					CTPP.PROVINSI,
					CTPP.DISTRIBUTOR,
					CTPP.AREA,
					CTPP.ASM,
					CTPP.TSO,
					CTPP.SALES,
					CTPP.CUSTOMER
				FROM CRMNEW_M_P_PROMOSI CMPP
					JOIN CRMNEW_T_P_PROMOSI CTPP ON CMPP.NO_PROMOSI = CTPP.NO_PROMOSI
				WHERE CMPP.DELETE_MARK IS NULL AND CTPP.DELETE_MARK IS NULL 
			";
			
			if($kd_program != null){
				$sql .= " AND CMPP.KODE_PROGRAM = $kd_program "; 
			}
			if($id_tso != null){
				$sql .= " AND CTPP.TSO = $id_tso "; 
			}
			
			//$sql .= " ";
			
			$list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
		}
		
		public function Data_promosi_by_tso($id_tso = null){
			$sql = " 
				SELECT
					CMPP.NO_PROMOSI,
					CMPP.KODE_PROGRAM,
					CMPP.NAMA_PROGRAM,
					CMPP.DESCRIPSI_PROGRAM,
					TO_CHAR(CMPP.TGL_MULAI, 'YYYY-MM-DD') AS TGL_MULAI,
					TO_CHAR(CMPP.TGL_SELESAI, 'YYYY-MM-DD') AS TGL_SELESAI,
					CMPP.BERLAKU_SELAMANYA
				FROM CRMNEW_M_P_PROMOSI CMPP
					JOIN CRMNEW_T_P_PROMOSI CTPP ON CMPP.NO_PROMOSI = CTPP.NO_PROMOSI
				WHERE CMPP.DELETE_MARK IS NULL AND CTPP.DELETE_MARK IS NULL 
			";
			
			if($id_tso != null){
				$sql .= " AND CTPP.TSO = $id_tso "; 
			}
			
			//$sql .= " ";
			
			$list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
		}

		public function Data_promosi_by_no_promosi($no_promosi = null){
			$sql = " 
				SELECT
					CTPP.NO_PROMOSI,
					CTPP.CUSTOMER AS ID_CUSTOMER,
					CC.KODE_CUSTOMER,
					CC.NAMA_TOKO,
					CC.TELP_TOKO,
					CC.ALAMAT,
					CC.KODE_POS,
					CC.NAMA_PEMILIK,
					CC.TELP_PEMILIK,
					CC.NOKTP_PEMILIK
				FROM CRMNEW_T_P_PROMOSI CTPP
					JOIN CRMNEW_CUSTOMER CC ON CTPP.CUSTOMER = CC.ID_CUSTOMER
				WHERE CTPP.DELETE_MARK IS NULL 
			";
			
			if($no_promosi != null){
				$sql .= " AND CTPP.NO_PROMOSI = $no_promosi "; 
			}
			
			//$sql .= " ";
			
			$list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
		}
		
	}
?>