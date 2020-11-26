<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_customer_sbi extends CI_Model {
		
		public function get_data_customer_sbi_full($id_sales, $start = null, $limit = null){
			/*
			$sql = "
				SELECT
				*
				FROM (
					SELECT
						CTS.ID_SALES,
						C.ID_CUSTOMER,
						C.ID_CUSTOMER AS KODE_CUSTOMER,
						C.NAMA_TOKO,
						C.ALAMAT,
						C.NAMA_PEMILIK,
						C.NOKTP_PEMILIK,
						C.KETERANGAN,
						C.KODE_POS,
						C.TELP_TOKO,
						C.TELP_PEMILIK,
						C.ID_DISTRIBUTOR,
						DIST.NAMA_DISTRIBUTOR,
						C.ID_PROVINSI,
						PROV.NAMA_PROVINSI,
						C.ID_DISTRIK,
						C.NAMA_DISTRIK,
						C.ID_AREA,
						A.NAMA_AREA,
						C.ID_KECAMATAN,
						C.NAMA_KECAMATAN,
						C.LATITUDE,
						C.LONGITUDE,
						C.STATUS_TOKO,
						C.GROUP_CUSTOMER,
						TO_CHAR(C.TGL_LAHIR, 'YYYY-MM-DD') AS TGL_LAHIR,
						C.KAPASITAS_TOKO,
                        CK.KAPASITAS_ZAK,
                         CK.KAPASITAS_TON,
						C.KAPASITAS_JUAL,
						
						ROWNUM AS BARIS
					FROM CRMNEW_TOKO_SALES CTS
					LEFT JOIN CRMNEW_CUSTOMER C ON CTS.KD_CUSTOMER = C.ID_CUSTOMER 
						AND C.FLAG = 'SBI' AND C.DELETE_MARK='0'
                        AND CTS.ID_DISTRIBUTOR=C.ID_DISTRIBUTOR
					LEFT JOIN CRMNEW_KAPASITAS_TOKO CK ON CTS.KD_CUSTOMER = CK.ID_CUSTOMER
					LEFT JOIN CRMNEW_DISTRIBUTOR DIST ON C.ID_DISTRIBUTOR = DIST.KODE_DISTRIBUTOR
					LEFT JOIN CRMNEW_M_PROVINSI PROV ON C.ID_PROVINSI = PROV.ID_PROVINSI
					LEFT JOIN CRMNEW_M_AREA A ON C.ID_AREA = A.KD_AREA
					WHERE CTS.DELETE_MARK = 0
					
			";
			*/
			$sql = "
			SELECT
				*
				FROM (
				SELECT 
					ROWNUM AS BARIS,
					MTDS.ID_CUSTOMER, 
					MTDS.ID_CUSTOMER AS KODE_CUSTOMER,
					MTDS.NAMA_TOKO,
					VDTC.TELP_TOKO,					
					VDTC.ALAMAT,
					VDTC.KODE_POS,
					VDTC.NAMA_PEMILIK, 
					VDTC.TELP_PEMILIK,
					VDTC.NOKTP_PEMILIK,
					TO_CHAR(VDTC.TGL_LAHIR, 'YYYY-MM-DD') AS TGL_LAHIR,
					VDTC.ID_KECAMATAN, 
					VDTC.NAMA_KECAMATAN, 
					VDTC.ID_DISTRIK, 
					VDTC.NAMA_DISTRIK, 
					VDTC.ID_AREA, 
					VDTC.NAMA_AREA, 
					VDTC.ID_PROVINSI, 
					VDTC.NAMA_PROVINSI, 
					VDTC.NEW_REGION AS REGION, 
					VDTC.LONGITUDE, 
					VDTC.LATITUDE, 
					VDTC.KOORDINAT_LOCK, 
					VDTC.KAPASITAS_ZAK,
					VDTC.KAPASITAS_TON, 
					VDTC.KAPASITAS_JUAL,
					VDTC.KAPASITAS_TOKO,
					VDTC.STATUS_TOKO,
					VDTC.GROUP_CUSTOMER,
					VDTC.KETERANGAN,
					MTDS.ID_DISTRIBUTOR,
					MTDS.NAMA_DISTRIBUTOR,
					MTDS.ID_SALES,
					MTDS.USERNAME
				FROM MAPPING_TOKO_DIST_SALES MTDS
					LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
						ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
				WHERE MTDS.ID_SALES = '$id_sales' 
				ORDER BY  MTDS.NAMA_DISTRIBUTOR, MTDS.NAMA_TOKO
			";
			
			/* AND VDTC.TGL_LAHIR IS NOT NULL
			if($id_sales != null){ 
				$sql .= " AND CTS.ID_SALES = '$id_sales' ";
			}
			*/
			
			$sql .= " ) ";
			
			if($start!=null && $limit!=null){
				$limit=$start+$limit;
				$sql .=" WHERE BARIS > $start AND BARIS <= $limit ";
			} else if($start==null && $limit!=null){
				$start=0;
				$limit=$start+$limit;
				$sql .=" WHERE BARIS > $start AND BARIS <= $limit ";
			} else if($start!=null && $limit==null){
				$sql .=" WHERE BARIS > $start ";
			} else {
				
			}
			//echo $sql;
			//exit;
			
			return $this->db->query($sql)->result_array();
		}
		
		public function cekSalesSbi($id_user){
			
			$sql = "
				SELECT ID_USER, NAMA, ID_JENIS_USER FROM CRMNEW_USER WHERE ID_USER = $id_user AND DELETED_MARK = 0
			";
			
			return $this->db->query($sql)->result_array();
		}
		
	}
	
?>