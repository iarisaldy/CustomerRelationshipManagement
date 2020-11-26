<?php
    class Peta_toko_model extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
        /*
        public function masterAreaTso($id_tso){
            $sql = "
                SELECT DISTINCT(TTST.ID_AREA) AS KD_AREA, TTST.NAMA_AREA, cma.id_area, cma.latitude, cma.longitude
                FROM T_TOKO_SALES_TSO TTST
                LEFT JOIN CRMNEW_M_AREA CMA ON TTST.ID_AREA = CMA.KD_AREA
                WHERE TTST.ID_TSO = '$id_tso' AND TTST.ID_AREA IS NOT NULL
            ";
            
            $data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }
        */
        /*
         
        public function petaToko($id_tso, $bulan, $tahun, $area){
            $sql = "
                SELECT
                TS.ID_SALES,
                SD.NAMA,
                TS.ID_TSO,
                SD.NAMA_TSO,
                SD.KODE_DISTRIBUTOR,
                SD.NAMA_DISTRIBUTOR,
                TS.KD_CUSTOMER,
                MC.NAMA_TOKO,
                MC.ALAMAT,
                MC.NAMA_PEMILIK,
                MC.TELP_TOKO,
                MC.ID_PROVINSI,
                MC.NAMA_PROVINSI,
                MC.ID_DISTRIK,
                MC.NAMA_DISTRIK,
                MC.ID_AREA,
                MC.NAMA_AREA,
                MC.NAMA_KECAMATAN,
                MC.LATITUDE,
                MC.LONGITUDE,
                NVL(TD.JML_KUNJUNGAN, 0)  AS JML_TOKO_DIKUNJUNGI_BULANAN
                FROM CRMNEW_TOKO_SALES TS
                LEFT JOIN M_SALES_DISTRIBUTOR SD ON TS.ID_SALES=SD.ID_USER
                    AND TS.ID_TSO=SD.ID_TSO
                LEFT JOIN M_CUSTOMER MC ON TS.KD_CUSTOMER=MC.ID_CUSTOMER
                    AND SD.KODE_DISTRIBUTOR=MC.ID_DISTRIBUTOR
                LEFT JOIN (
                                SELECT
                                ID_TOKO,
                                JML_KUNJUNGAN   
                                FROM T_TOKO_DIKUNJUNGI
                                WHERE TAHUN='$tahun'
                                AND BULAN='$bulan'
                            ) TD ON TS.KD_CUSTOMER=TD.ID_TOKO
                WHERE TS.DELETE_MARK='0'
                AND TS.ID_TSO = '$id_tso' AND MC.ID_AREA = '$area' AND MC.NAMA_TOKO IS NOT NULL
                GROUP BY 
                    TS.ID_SALES,
                    SD.NAMA,
                    TS.ID_TSO,
                    SD.NAMA_TSO,
                    SD.KODE_DISTRIBUTOR,
                    SD.NAMA_DISTRIBUTOR,
                    TS.KD_CUSTOMER,
                    MC.NAMA_TOKO,
                    MC.ALAMAT,
                    MC.NAMA_PEMILIK,
                    MC.TELP_TOKO,
                    MC.ID_PROVINSI,
                    MC.NAMA_PROVINSI,
                    MC.ID_DISTRIK,
                    MC.NAMA_DISTRIK,
                    MC.ID_AREA,
                    MC.NAMA_AREA,
                    MC.NAMA_KECAMATAN,
                    MC.LATITUDE,
                    MC.LONGITUDE,
                    TD.JML_KUNJUNGAN
            ";
            
            ///echo $sql;
            //exit();
            
            $data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }
        */
        
        public function jadwalKunjungan($id_customer, $bulan, $tahun){
            $sql ="
				SELECT
					CC.ID_TOKO AS ID_CUSTOMER,
					TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'DD-MM-YYYY') AS TGL_RENCANA_KUNJUNGAN,
					CC.KETERANGAN
				FROM CRMNEW_KUNJUNGAN_CUSTOMER CC
				WHERE CC.DELETED_MARK = 0 AND CC.ID_TOKO IS NOT NULL
				
			";
			
			if($id_customer!=null){
				$sql .= " AND CC.ID_TOKO='$id_customer' ";
			}
			if($tahun!=null){
				$sql .= " AND TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'YYYY')='$tahun' ";
			}
			if($bulan!=null){
				$sql .= " AND TO_CHAR(CC.TGL_RENCANA_KUNJUNGAN, 'MM')='$bulan' ";
			}
            
            $sql .= " ORDER BY CC.TGL_RENCANA_KUNJUNGAN";
            
            $data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                 return $data->result();
            } 
        }
        
        /*
        public function petaTokoTso($id_tso, $bulan, $tahun){       // Tidak dipakai
            $sql = "
                SELECT
                TS.ID_SALES,
                SD.NAMA,
                TS.ID_TSO,
                SD.NAMA_TSO,
                SD.KODE_DISTRIBUTOR,
                SD.NAMA_DISTRIBUTOR,
                TS.KD_CUSTOMER,
                MC.NAMA_TOKO,
                MC.ALAMAT,
                MC.NAMA_PEMILIK,
                MC.TELP_TOKO,
                MC.ID_PROVINSI,
                MC.NAMA_PROVINSI,
                MC.ID_DISTRIK,
                MC.NAMA_DISTRIK,
                MC.ID_AREA,
                MC.NAMA_AREA,
                MC.NAMA_KECAMATAN,
                LC.LATITUDE,
                LC.LONGITUDE,
                NVL(TD.JML_KUNJUNGAN, 0)  AS JML_TOKO_DIKUNJUNGI_BULANAN
                FROM CRMNEW_TOKO_SALES TS
                LEFT JOIN M_SALES_DISTRIBUTOR SD ON TS.ID_SALES=SD.ID_USER
                    AND TS.ID_TSO=SD.ID_TSO
                LEFT JOIN M_CUSTOMER MC ON TS.KD_CUSTOMER=MC.ID_CUSTOMER
                    AND SD.KODE_DISTRIBUTOR=MC.ID_DISTRIBUTOR
                LEFT JOIN CRMNEW_LOKASI_CUSTOMER LC ON LC.ID_CUSTOMER=MC.ID_CUSTOMER
                LEFT JOIN (
                                SELECT
                                ID_TOKO,
                                JML_KUNJUNGAN   
                                FROM T_TOKO_DIKUNJUNGI
                                WHERE TAHUN='$tahun'
                                AND BULAN='$bulan'
                            ) TD ON TS.KD_CUSTOMER=TD.ID_TOKO
                WHERE TS.DELETE_MARK='0'
                AND TS.ID_TSO = '$id_tso' AND MC.NAMA_TOKO IS NOT NULL
                GROUP BY 
                    TS.ID_SALES,
                    SD.NAMA,
                    TS.ID_TSO,
                    SD.NAMA_TSO,
                    SD.KODE_DISTRIBUTOR,
                    SD.NAMA_DISTRIBUTOR,
                    TS.KD_CUSTOMER,
                    MC.NAMA_TOKO,
                    MC.ALAMAT,
                    MC.NAMA_PEMILIK,
                    MC.TELP_TOKO,
                    MC.ID_PROVINSI,
                    MC.NAMA_PROVINSI,
                    MC.ID_DISTRIK,
                    MC.NAMA_DISTRIK,
                    MC.ID_AREA,
                    MC.NAMA_AREA,
                    MC.NAMA_KECAMATAN,
                    LC.LATITUDE,
                    LC.LONGITUDE,
                    TD.JML_KUNJUNGAN
            ";
            
            ///echo $sql;
            //exit();
            
            $data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }
        */
        
        public function TokoTsopdPeta($id_tso, $bulan, $tahun){
            $sql = "
                SELECT 
					MTDS.ID_CUSTOMER, 
					MTDS.NAMA_TOKO, 
					VDTC.NAMA_PEMILIK, 
					VDTC.TELP_TOKO, 
					VDTC.ALAMAT, 
					--VDTC.ID_KECAMATAN, 
					VDTC.NAMA_KECAMATAN, 
					--VDTC.ID_DISTRIK, 
					VDTC.NAMA_DISTRIK, 
					VDTC.ID_AREA, 
					VDTC.NAMA_AREA, 
					--VDTC.ID_PROVINSI, 
					VDTC.NAMA_PROVINSI, 
					VDTC.NEW_REGION AS REGION, 
					VDTC.LONGITUDE, 
					VDTC.LATITUDE, 
					--VDTC.KOORDINAT_LOCK, 
					--VDTC.KAPASITAS_ZAK, 
					--VDTC.KAPASITAS_TON,
                    NVL(TD.JML_KUNJUNGAN, 0) AS JML_TOKO_DIKUNJUNGI_BULANAN,
					MTDS.ID_DISTRIBUTOR,
					MTDS.NAMA_DISTRIBUTOR,
					MTDS.ID_SALES,
					MTDS.USERNAME as NAMA
                FROM MAPPING_TOKO_DIST_SALES MTDS
                    LEFT JOIN VIEW_DATA_TOKO_CUSTOMER VDTC
                        ON VDTC.ID_CUSTOMER = MTDS.ID_CUSTOMER
                    LEFT JOIN ( SELECT ID_TOKO, JML_KUNJUNGAN FROM T_TOKO_DIKUNJUNGI WHERE TAHUN = '$tahun' AND BULAN = '$bulan' ) TD 
                        ON VDTC.ID_CUSTOMER = TD.ID_TOKO 
                WHERE MTDS.ID_SALES IN (SELECT DISTINCT(ID_SALES) FROM HIRARCKY_GSM_TO_DISTRIBUTOR WHERE ID_SO IS NOT NULL AND ID_SO = '$id_tso')
                    ORDER BY TD.JML_KUNJUNGAN DESC 
            ";
            
             //echo $sql;
            //exit();
            
            $data = $this->db->query($sql);
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }
        
        public function listTsoSm($id_sm){        // list for sm
            $sql = "
                SELECT DISTINCT(ID_SO), NAMA_SO 
                FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                WHERE ID_SO IS NOT NULL AND ID_SM = '$id_sm'
                ORDER BY NAMA_SO
            "; 
            
            $data = $this->db->query($sql)->result_array();
            return $data;
        }
        
        public function listTsoSsm($id_ssm){        // list for ssm
            $sql = "
                SELECT DISTINCT(ID_SO), NAMA_SO 
                FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                WHERE ID_SO IS NOT NULL AND ID_SSM = '$id_ssm'
                ORDER BY NAMA_SO
            ";
            
            $data = $this->db->query($sql)->result_array();
            return $data;
        }
        
        public function listTsoGsm($id_gsm){        // list for gsm
            $sql = "
                SELECT DISTINCT(ID_SO), NAMA_SO 
                FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                WHERE ID_SO IS NOT NULL AND ID_GSM = '$id_gsm'
                ORDER BY NAMA_SO
            ";
            
            $data = $this->db->query($sql)->result_array();
            return $data;
        }
        
        public function listTsoAdmin($id_gsm){        // list for Admin
            $sql = "
                SELECT DISTINCT(ID_SO), NAMA_SO 
                FROM HIRARCKY_GSM_TO_DISTRIBUTOR
                WHERE ID_SO IS NOT NULL 
                ORDER BY NAMA_SO
            ";
            
            $data = $this->db->query($sql)->result_array();
            return $data;
        }
        
        
	}
	
?>