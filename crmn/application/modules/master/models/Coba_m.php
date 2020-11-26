<?php
	if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
 
	class Coba_m extends CI_Model {

		public function __construct(){
			parent::__construct();
			$this->load->database();
			$this->db = $this->load->database('default', TRUE);
			$this->db2 = $this->load->database('crm', TRUE);
			
		}
		public function h(){
			$sql ="
				SELECT
				ID_CUSTOMER,
				KAPASITAS_TOKO AS KAPASITAS_ZAK,
				KAPASITAS_JUAL AS KAPASITAS_TON,
				'SYSTEM' AS CREATE_BY,
				SYSDATE  AS CREATE_DATE,
				'0' AS DELETE_MARK
				FROM CRMNEW_CUSTOMER
				WHERE KAPASITAS_TOKO IS NOT NULL OR KAPASITAS_JUAL IS NOT NULL
				GROUP BY 
				ID_CUSTOMER,
				KAPASITAS_TOKO,
				KAPASITAS_JUAL,
				'SYSTEM',
				SYSDATE,
				'0'
			";
			
			return $this->db2->query($sql)->result_array();
		}
		
		
		public function get_data_performa_tso($bulan ,$tahun ,$tso){
			
			$sql ="
				SELECT 
					ID_USER,
					NAMA_SALES,
					NAMA_DISTRIBUTOR,
					TAHUN,
					BULAN,
					SUM(TOTAL_TARGET) AS TARGET,
					SUM(REALISASI) AS REALISASI
				FROM R_REPORT_VISIT_SALES 
				WHERE TAHUN = '$tahun'
				AND BULAN = '$bulan'
				AND ID_TSO = '$tso'
				GROUP BY ID_USER,NAMA_SALES,NAMA_DISTRIBUTOR,TAHUN,BULAN
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function GrafikKunjungan($id_user, $bulan, $tahun){
			
            $sql = "
					SELECT
                    BULAN_TAHUN.TANGGAL,
                    NVL(DATA_VISIT.Target, 0) AS TARGET,
                    NVL(DATA_VISIT.realisasi, 0) AS REALISASI
                    FROM 
                        (
                            SELECT
                            TO_CHAR(TANGGAL, 'DD') AS TANGGAL
                            FROM CALENDER_CRM
                            WHERE TO_CHAR(TANGGAL, 'YYYY') = '$tahun'
                            AND TO_CHAR(TANGGAL, 'MM') = '$bulan'
                        ) BULAN_TAHUN
                    LEFT JOIN
                        (   
                            SELECT 
                                hari as tanggal, 
                                sum(total_target) as Target,
                                sum(realisasi) as realisasi 
                            FROM R_REPORT_VISIT_SALES
                                where id_user = '$id_user' and bulan = '$bulan' and tahun = '$tahun'
                            GROUP BY 
                                hari
                            order by tanggal    
                        ) DATA_VISIT ON BULAN_TAHUN.TANGGAL = DATA_VISIT.tanggal
                    ORDER BY TANGGAL
            ";
            			
			return $this->db->query($sql)->result_array();
        }
		
		public function PieDiagram($id_user, $bulan, $tahun){
			
            $sql = "
					SELECT
						T.ID_TSO,
						COUNT(NVL(TD.JML_KUNJUNGAN, 0))  AS JUMLAHALL,
						COUNT(CASE WHEN NVL(TD.JML_KUNJUNGAN, 0) = 0 THEN 1 END)  AS JUMLAH,
						COUNT(CASE WHEN NVL(TD.JML_KUNJUNGAN, 0) >= 1 THEN 1 END)  AS JUMLAHS
						FROM T_TOKO_SALES_TSO T
						LEFT JOIN   (
										SELECT
										ID_TOKO,
										JML_KUNJUNGAN   
										FROM T_TOKO_DIKUNJUNGI
										WHERE TAHUN='$tahun'
										AND BULAN='$bulan'
									) TD ON T.KD_CUSTOMER=TD.ID_TOKO
						WHERE T.ID_TSO = '$id_user'
						AND NAMA_TOKO IS NOT NULL
						GROUP BY ID_TSO
            ";
            			
			return $this->db->query($sql)->result_array();
        }
		
		public function PieDiagramTSO($id_user, $bulan, $tahun){
			
            $sql = "
					SELECT 
					NAMA_TSO,
					SUM(TOTAL_TARGET) AS TARGET,
					SUM(REALISASI) AS REALISASI,
                    SUM(TOTAL_TARGET)-SUM(REALISASI) AS GAP
				FROM R_REPORT_VISIT_SALES 
				WHERE TAHUN = '$tahun'
				AND BULAN = '$bulan'
				AND ID_TSO = '$id_user'
				GROUP BY NAMA_TSO
            ";
            			
			return $this->db->query($sql)->result_array();
        }
		
	}
?>