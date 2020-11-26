<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_customer extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
			$this->db = $this->load->database('default', TRUE);
			$this->db_BK  = $this->load->database('Point', TRUE);
		}

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
			
			/*
			$sql ="
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
					VDTC.ID_CUSTOMER,
					VDTC.ID_CUSTOMER AS KODE_CUSTOMER,	
					VDTC.NAMA_TOKO,
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
					MTDS.NAMA_DISTRIBUTOR
				FROM VIEW_DATA_TOKO_CUSTOMER VDTC
					LEFT JOIN MAPPING_TOKO_DIST_SALES MTDS
						ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
				WHERE VDTC.ID_CUSTOMER IS NOT NULL 
			";
			
			// WHERE MTDS.ID_SALES = '$id_sales' 
			
			if($distributor!=null){
				$distributor = "'".str_replace(",", "','", str_replace("'", "", $distributor))."'";
				$sql .= " AND MTDS.ID_DISTRIBUTOR IN ($distributor) "; 
			}
			if($provinsi!=null){
				$sql .= " AND VDTC.ID_PROVINSI IN ($provinsi) ";
			}
			if($distrik!=null){
				$sql .= " AND VDTC.ID_DISTRIK IN ($distrik) ";
			}
			if($area!=null){
				$sql .= " AND VDTC.ID_AREA IN ($area) ";
			}
			if($kecamatan!=null){
				$sql .= " AND VDTC.ID_KECAMATAN IN ($kecamatan) ";
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
			
			//$sql .= " ORDER BY  MTDS.NAMA_DISTRIBUTOR, MTDS.NAMA_TOKO ";
			//echo $sql;
			// exit;
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function UpdateDataCustomer($id_sales, $data){
			$data_id_in = array();
			$id_in = '';
			$i = 1;
			foreach($data as $d){
				$id_customer = $d['ID_CUSTOMER'];
				
				$nama_toko = null;
				if($d['NAMA_TOKO'] != null OR $d['NAMA_TOKO'] != ''){
					$nama_toko = $d['NAMA_TOKO'];
					$this->db->set('NAMA_TOKO', $nama_toko);
				}
				
				$telp_toko = null;
				if($d['TELP_TOKO'] != null OR $d['TELP_TOKO'] != ''){
					$telp_toko = $d['TELP_TOKO'];
					$this->db->set('TELP_TOKO', $telp_toko);
					
					// UPDATE TO DATA BK TELP TOKO
					///*
						$this->db_BK->set('NO_TELP_TOKO', $telp_toko);
						$this->db_BK->where('ID_CUSTOMER', $id_customer);
						$this->db_BK->update('M_CUSTOMER');
					//*/
				}
				
				$nama_pemilik = null;
				if($d['NAMA_PEMILIK'] != null OR $d['NAMA_PEMILIK'] != ''){
					$nama_pemilik = $d['NAMA_PEMILIK'];
					$this->db->set('NAMA_PEMILIK', $nama_pemilik);
				}
				
				$telp_pemilik = null;
				if($d['TELP_PEMILIK'] != null OR $d['TELP_PEMILIK'] != ''){
					$telp_pemilik = $d['TELP_PEMILIK'];
					$this->db->set('TELP_PEMILIK', $telp_pemilik);
					
					// UPDATE TO DATA BK TELP PEMILIK
					///*
						$this->db_BK->set('NO_HANDPHONE', $telp_pemilik);
						$this->db_BK->where('ID_CUSTOMER', $id_customer);
						$this->db_BK->update('M_CUSTOMER');
					//*/
				}
				
				$noktp_pemilik = null;
				if($d['NOKTP_PEMILIK'] != null OR $d['NOKTP_PEMILIK'] != ''){
					$noktp_pemilik = $d['NOKTP_PEMILIK'];
					$this->db->set('NOKTP_PEMILIK', $noktp_pemilik);
				}
				
				$tgl_lahir = null; 	//dd-mm-yyyy
				if($d['TGL_LAHIR'] != null OR $d['TGL_LAHIR'] != ''){
					$tgl_lahir = $d['TGL_LAHIR'];
					$tgl_lahir_improve = date('d-M-Y', strtotime($tgl_lahir));
					$this->db->set('TGL_LAHIR', $tgl_lahir_improve);
				}
				
				$alamat = null;
				if($d['ALAMAT'] != null OR $d['ALAMAT'] != ''){
					$alamat = $d['ALAMAT'];
					$this->db->set('ALAMAT', $alamat);
				}
				
				$id_kecamatan = null;
				if($d['ID_KECAMATAN'] != null OR $d['ID_KECAMATAN'] != ''){
					$id_kecamatan = $d['ID_KECAMATAN'];
					$this->db->set('ID_KECAMATAN', $id_kecamatan);
				}
				
				$id_distrik = null;
				if($d['ID_DISTRIK'] != null OR $d['ID_DISTRIK'] != ''){
					$id_distrik = $d['ID_DISTRIK'];
					$this->db->set('ID_DISTRIK', $id_distrik);
				}
				
				$id_area = null;
				if($d['ID_AREA'] != null OR $d['ID_AREA'] != ''){
					$id_area = $d['ID_AREA'];
					$this->db->set('ID_AREA', $id_area);
				}
				
				$id_provinsi = null;
				if($d['ID_PROVINSI'] != null OR $d['ID_PROVINSI'] != ''){
					$id_provinsi = $d['ID_PROVINSI'];
					$this->db->set('ID_PROVINSI', $id_provinsi);
				}
				 
				$kode_pos = null;
				if($d['KODE_POS'] != null OR $d['KODE_POS'] != ''){
					$kode_pos = $d['KODE_POS'];
					$this->db->set('KODE_POS', $kode_pos);
				}
				
				$keterangan = null;
				if($d['KETERANGAN'] != null OR $d['KETERANGAN'] != ''){
					$keterangan = $d['KETERANGAN'];
					$this->db->set('KETERANGAN', $keterangan);
				}
				
				$kapasitas_jual = null;
				if($d['KAPASITAS_JUAL'] != null OR $d['KAPASITAS_JUAL'] != ''){
					$kapasitas_jual = $d['KAPASITAS_JUAL'];
					$this->db->set('KAPASITAS_JUAL', $kapasitas_jual);
				}
				
				$kapasitas_toko = null;
				if($d['KAPASITAS_TOKO'] != null OR $d['KAPASITAS_TOKO'] != ''){
					$kapasitas_toko = $d['KAPASITAS_TOKO'];
					$this->db->set('KAPASITAS_TOKO', $kapasitas_toko);
				}
				
				$kapasitas_zak = null;
				$kapasitas_ton = null;
				if(isset($d['KAPASITAS_ZAK']) or isset($d['KAPASITAS_TON'])){
					if(($d['KAPASITAS_ZAK'] != null OR $d['KAPASITAS_ZAK'] != '') OR ($d['KAPASITAS_TON'] != null OR $d['KAPASITAS_TON'] != '')){
						$kapasitas_zak = $d['KAPASITAS_ZAK'];
						$kapasitas_ton = $d['KAPASITAS_TON'];
						$this->set_kapasitas_gudang_toko($id_sales, $id_customer, $kapasitas_zak, $kapasitas_ton);
					}
				}
				
				
				$this->db->set('IS_UPDATE', 1);
				$this->db->set('UPDATED_BY', $id_sales);
				$this->db->where('ID_CUSTOMER', $id_customer);
				$this->db->where('DELETE_MARK', 0);
				$this->db->update('CRMNEW_CUSTOMER');
				
				array_push($data_id_in, $id_customer);
			}
			
			// manipulation string
			for($i = 0 ; $i < count($data_id_in); $i++){
				$id_in = $id_in.$data_id_in[$i];
				if($i < count($data)-1){
					$id_in = $id_in.",";
				}
			}
			
			// print_r($id_in);
			// exit();
	
			// $this->db->select('
					// ID_CUSTOMER,
					// NAMA_TOKO,
					// TELP_TOKO,
					// NAMA_PEMILIK,
					// TELP_PEMILIK,
					// NOKTP_PEMILIK,
					// TGL_LAHIR,
					// ALAMAT,
					// ID_KECAMATAN,
					// ID_DISTRIK,
					// ID_AREA,
					// ID_PROVINSI,
					// KODE_POS,
					// KAPASITAS_TOKO,
					// KAPASITAS_JUAL,
					// KETERANGAN'
			// );
			// $this->db->select('DATE_FORMAT(TGL_LAHIR, "%Y-%m-%d") AS added_date');
			// $this->db->from('CRMNEW_CUSTOMER');
			// $this->db->where('DELETE_MARK', 0);
			// $this->db->where_in('ID_CUSTOMER', $data_id_in);
			// $hasil = $this->db->get();
			//return $hasil->result();
			
			$sql = " 
				SELECT 
					CC.ID_CUSTOMER,
					CC.NAMA_TOKO,
					CC.TELP_TOKO,
					CC.NAMA_PEMILIK,
					CC.TELP_PEMILIK,
					CC.NOKTP_PEMILIK,
					TO_CHAR(CC.TGL_LAHIR, 'YYYY-MM-DD') AS TGL_LAHIR,
					CC.ALAMAT,
					CC.ID_KECAMATAN,
					CC.ID_DISTRIK,
					CC.ID_AREA,
					CC.ID_PROVINSI,
					CC.KODE_POS,
					CC.KAPASITAS_TOKO,
					CKT.KAPASITAS_ZAK,
					CKT.KAPASITAS_TON,
					CC.KAPASITAS_JUAL,
					CC.KETERANGAN			
				FROM CRMNEW_CUSTOMER CC
					LEFT JOIN CRMNEW_KAPASITAS_TOKO CKT
						ON CC.ID_CUSTOMER = CKT.ID_CUSTOMER AND CKT.DELETE_MARK = 0
				WHERE CC.DELETE_MARK = 0 AND CC.ID_CUSTOMER IN ($id_in)
				GROUP BY
					CC.ID_CUSTOMER,
					CC.NAMA_TOKO,
					CC.TELP_TOKO,
					CC.NAMA_PEMILIK,
					CC.TELP_PEMILIK,
					CC.NOKTP_PEMILIK,
					CC.TGL_LAHIR,
					CC.ALAMAT,
					CC.ID_KECAMATAN,
					CC.ID_DISTRIK,
					CC.ID_AREA,
					CC.ID_PROVINSI,
					CC.KODE_POS,
					CC.KAPASITAS_TOKO,
					CKT.KAPASITAS_ZAK,
					CKT.KAPASITAS_TON,
					CC.KAPASITAS_JUAL,
					CC.KETERANGAN	
				";
			return $this->db->query($sql)->result_array();
			
			// print_r($id_in);
			// exit();
			
		}
		
		private function set_kapasitas_gudang_toko($id_user, $id_cus, $kap_sak, $kap_ton){
	
			//foreach($kapasitasToko as $dt){
				
				// $id_cus = $dt['ID_CUSTOMER'];
				// $kap_sak = $dt['KAPASITAS_ZAK'];
				// $kap_ton = $dt['KAPASITAS_TON'];
				
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
			//}
		}

    }
?>