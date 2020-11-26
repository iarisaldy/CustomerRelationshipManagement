<?php
	if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
 
	class Performa_Sales_model extends CI_Model {

		public function __construct(){
			parent::__construct();
			$this->load->database();
			$this->db = $this->load->database('default', TRUE);
			
		}
		
		public function get_data_performa_tso($bulan ,$tahun ,$tso){
			
			$sql ="
				SELECT 
					ID_SALES,
					NAMA_SALES,
					NAMA_DISTRIBUTOR,
					TAHUN,
					BULAN,
					TARGET,
					REALISASI
				FROM R1_PERFORMAN_VISIT_SALES 
				WHERE ID_SO = '$tso'
				AND BULAN = '$bulan'
				AND TAHUN = '$tahun'
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_data_performa_asm($bulan ,$tahun ,$asm){
			
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
				AND ID_ASM = '$asm'
				GROUP BY ID_USER,NAMA_SALES,NAMA_DISTRIBUTOR,TAHUN,BULAN
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_data_performa_rsm($bulan ,$tahun ,$rsm){
			
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
				AND ID_RSM = '$rsm'
				GROUP BY ID_USER,NAMA_SALES,NAMA_DISTRIBUTOR,TAHUN,BULAN
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_data_performa_dis($bulan ,$tahun ,$id_dis){
			
			$sql ="
				SELECT
					ID_USER, 
					NAMA_SALES,
					NAMA_DISTRIBUTOR,
					TAHUN,
					BULAN,
					SUM(TOTAL_TARGET)AS TARGET,
					SUM(REALISASI)AS REALISASI
				FROM
					R_REPORT_VISIT_SALES
				WHERE KODE_DISTRIBUTOR IN ('$id_dis')
				AND TAHUN = '$tahun'
				AND BULAN = '$bulan'
				GROUP BY ID_USER,NAMA_SALES,NAMA_DISTRIBUTOR,TAHUN,BULAN
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function get_kode_dis($id_user){
			
			$sql ="
				SELECT
					KODE_DISTRIBUTOR
				FROM 
					M_SALES_USER_DISTRIBUTOR
				WHERE
				ID_USER_DISTRIBUTOR = '$id_user'
				GROUP BY KODE_DISTRIBUTOR
			";
			
			return $this->db->query($sql)->result_array();
			
		}
		
		public function GrafikKunjungan($id, $bulan, $tahun){
			
            $sql = "
				SELECT
                KALENDER.HARI AS TANGGAL,
                NVL(VISIT.TARGET, 0) AS TARGET,
                NVL(VISIT.REALISASI, 0) AS REALISASI
                FROM 
                        (
                            SELECT
                            TO_CHAR(TANGGAL, 'DD') AS HARI
                            FROM CALENDER_CRM
                            WHERE TO_CHAR(TANGGAL, 'YYYY') ='2020'
                            AND TO_CHAR(TANGGAL, 'MM') ='02'
                            ORDER BY HARI
                        ) KALENDER
                LEFT JOIN 
                        (
                            SELECT
                            V.HARI,
                            SUM(V.TARGET) AS TARGET,
                            SUM(V.REALISASI) AS REALISASI
                            FROM VISIT_SALES_DISTRIBUTOR_A1 V
                            WHERE V.TAHUN='$tahun'
                            AND V.BULAN='$bulan'
                            AND V.ID_SALES='$id'
                            GROUP BY V.HARI
                            ORDER BY HARI        
                        ) VISIT ON KALENDER.HARI=VISIT.HARI
                ORDER BY TANGGAL
            ";
            			
			return $this->db->query($sql)->result_array();
        }
		
	}
?>