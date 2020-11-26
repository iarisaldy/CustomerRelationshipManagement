<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_customer extends CI_Model {

        public function listCustomer($limit = null, $start = null){
            if(isset($limit) && isset($start)){
                $this->db->limit($limit, $start);
            }

            $this->db->select("CRMNEW_CUSTOMER.ID_CUSTOMER, CRMNEW_CUSTOMER.KODE_CUSTOMER, CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_CUSTOMER.NAMA_PEMILIK,
            CRMNEW_CUSTOMER.TELP_TOKO, CRMNEW_CUSTOMER.TELP_PEMILIK, CRMNEW_CUSTOMER.NOKTP_PEMILIK, CRMNEW_CUSTOMER.KETERANGAN,
            CRMNEW_CUSTOMER.ALAMAT, CRMNEW_CUSTOMER.KODE_POS, CRMNEW_CUSTOMER.FOTO_TOKO, CRMNEW_CUSTOMER.KAPASITAS_TOKO,
            CRMNEW_CUSTOMER.ID_DISTRIBUTOR, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR, CRMNEW_CUSTOMER.ID_PROVINSI, CRMNEW_M_PROVINSI.NAMA_PROVINSI,
            CRMNEW_CUSTOMER.ID_DISTRIK, CRMNEW_M_DISTRIK.NAMA_DISTRIK, CRMNEW_CUSTOMER.ID_AREA, CRMNEW_M_AREA.NAMA_AREA");
            $this->db->from("CRMNEW_CUSTOMER");
            $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_CUSTOMER.ID_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
            $this->db->join("CRMNEW_M_PROVINSI", "CRMNEW_CUSTOMER.ID_PROVINSI = CRMNEW_M_PROVINSI.ID_PROVINSI", "LEFT");
            $this->db->join("CRMNEW_M_DISTRIK", "CRMNEW_CUSTOMER.ID_DISTRIK = CRMNEW_M_DISTRIK.ID_DISTRIK", "LEFT");
            $this->db->join("CRMNEW_M_AREA", "CRMNEW_CUSTOMER.ID_AREA = CRMNEW_M_AREA.ID_AREA", "LEFT");
            
			
            $customer = $this->db->get();
			if($customer->num_rows() > 0){
                return array("data" => $customer->result(), "total" => $customer->num_rows());
            } else {
                return false;
            }
        }
		
		public function get_data_customer($distributor=null, $provinsi=null, $distrik=null, $area=null, $kecamatan=null, $limit=null, $start=null){
			
			
			$sql ="
				SELECT
				*
				FROM (
					SELECT
					C.ID_CUSTOMER,
					C.NAMA_TOKO AS NAMA_CUSTOMER,
					C.ALAMAT,
					C.NAMA_PEMILIK,
					C.TELP_TOKO AS NO_TELP,
					C.ID_DISTRIBUTOR,
					DIST.NAMA_DISTRIBUTOR,
					C.ID_PROVINSI,
					PROV.NAMA_PROVINSI,
					C.ID_DISTRIK,
					DISTRIK.NAMA_DISTRIK,
					C.ID_AREA,
					A.NAMA_AREA,
					C.ID_KECAMATAN,
					K.NAMA_KECAMATAN,
					ROWNUM AS BARIS
					FROM CRMNEW_CUSTOMER C
					LEFT JOIN CRMNEW_DISTRIBUTOR DIST ON C.ID_DISTRIBUTOR=DIST.KODE_DISTRIBUTOR
					LEFT JOIN CRMNEW_M_PROVINSI PROV ON C.ID_PROVINSI=PROV.ID_PROVINSI
					LEFT JOIN CRMNEW_M_DISTRIK DISTRIK ON C.ID_DISTRIK=DISTRIK.ID_DISTRIK
					LEFT JOIN CRMNEW_M_AREA A ON C.ID_AREA=A.ID_AREA
					LEFT JOIN CRMNEW_M_KECAMATAN K ON C.ID_KECAMATAN=K.KD_KECAMATAN
					WHERE C.DELETE_MARK=0
			";
			
			if($distributor!=null){
				$sql .= " AND C.ID_DISTRIBUTOR='$distributor' "; 
			}
			if($provinsi!=null){
				$sql .= " AND C.ID_PROVINSI='$provinsi' ";
			}
			if($distrik!=null){
				$sql .= " AND C.ID_DISTRIK='$distrik' ";
			}
			if($area!=null){
				$sql .= " AND C.ID_AREA='$area' ";
			}
			if($kecamatan!=null){
				$sql .= " AND C.ID_KECAMATAN='$kecamatan' ";
			}
			
			$sql .= " ) ";
			
			if($start!=null && $limit!=null){
				$limit=$start+$limit;
				
				$sql .=" WHERE BARIS > '$start'  AND BARIS <= '$limit' ";
				
			}
			else if($start==null && $limit!=null){
				$start=0;
				$limit=$start+$limit;
				$sql .=" WHERE BARIS > '$start'  AND BARIS <= '$limit' ";
			}
			else if($start!=null && $limit==null){
				$sql .=" WHERE BARIS > '$start' ";
			}
			else {
				
			}
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_data_customer_full($distributor=null, $provinsi=null, $distrik=null, $area=null, $kecamatan=null, $limit=null, $start=null){
			
			
			$sql ="
				SELECT
				*
				FROM (
					SELECT
					C.ID_CUSTOMER,
					C.ID_CUSTOMER AS KODE_CUSTOMER,
					C.NAMA_TOKO,
					C.ALAMAT,
					C.NAMA_PEMILIK,
					c.NOKTP_PEMILIK,
					c.KETERANGAN,
					c.KODE_POS,
					c.KAPASITAS_TOKO,
					C.TELP_TOKO,
					C.TELP_PEMILIK,
					C.ID_DISTRIBUTOR,
					DIST.NAMA_DISTRIBUTOR,
					C.ID_PROVINSI,
					PROV.NAMA_PROVINSI,
					C.ID_DISTRIK,
					DISTRIK.NAMA_DISTRIK,
					C.ID_AREA,
					A.NAMA_AREA,
					C.ID_KECAMATAN,
					C.LATITUDE,
                    C.LONGITUDE,
					K.NAMA_KECAMATAN,
					C.STATUS_TOKO,
					C.GROUP_CUSTOMER,
					TO_CHAR(C.TGL_LAHIR, 'YYYY-MM-DD') AS TGL_LAHIR,
					ROWNUM AS BARIS
					FROM CRMNEW_CUSTOMER C
					LEFT JOIN CRMNEW_DISTRIBUTOR DIST ON C.ID_DISTRIBUTOR=DIST.KODE_DISTRIBUTOR
					LEFT JOIN CRMNEW_M_PROVINSI PROV ON C.ID_PROVINSI=PROV.ID_PROVINSI
					LEFT JOIN CRMNEW_M_DISTRIK DISTRIK ON c.nama_distrik=DISTRIK.NAMA_DISTRIK
					LEFT JOIN CRMNEW_M_AREA A ON C.ID_AREA=A.ID_AREA
					LEFT JOIN CRMNEW_M_KECAMATAN K ON c.nama_kecamatan=k.nama_kecamatan
					WHERE C.DELETE_MARK=0
			";
			
			
			if($distributor!=null){
				$distributor = "'".str_replace(",", "','", str_replace("'", "", $distributor))."'";
				$sql .= " AND C.ID_DISTRIBUTOR IN ($distributor) "; 
			}
			if($provinsi!=null){
				$sql .= " AND C.ID_PROVINSI IN ($provinsi) ";
			}
			if($distrik!=null){
				$sql .= " AND C.ID_DISTRIK IN ($distrik) ";
			}
			if($area!=null){
				$sql .= " AND C.ID_AREA IN ($area) ";
			}
			if($kecamatan!=null){
				$sql .= " AND C.ID_KECAMATAN IN ($kecamatan) ";
			}
			
			$sql .= " ) ";
			
			if($start!=null && $limit!=null){
				$limit=$start+$limit;
				
				$sql .=" WHERE BARIS > '$start'  AND BARIS <= '$limit' ";
				
			}
			else if($start==null && $limit!=null){
				$start=0;
				$limit=$start+$limit;
				$sql .=" WHERE BARIS > '$start'  AND BARIS <= '$limit' ";
			}
			else if($start!=null && $limit==null){
				$sql .=" WHERE BARIS > '$start' ";
			}
			else {
				
			}
			// echo $sql;
			// exit;
			
			return $this->db->query($sql)->result_array();
			
		}

    }
?>