<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class MarketVisit_AM_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('crm', TRUE);
	}

    public function get_gm($region){
    	// $region = 3;

        $sql = "
        	SELECT
				ID_USER
			FROM
				CRMNEW_USER
			WHERE
				DELETED_MARK = '0'
				AND ID_REGION IN ($region)
				AND ID_JENIS_USER = '1016'
        ";

		// print_r('<pre>');
		// print_r($sql);exit;

        $res = $this->db->query($sql)->result_array();

    	$id_gm = '';
    	$gm = '';
    	$distr_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['ID_USER'])) {
	        		$id_gm .= "'" . $v['ID_USER'] . "',";

	        	}
	        }

	        $gm = substr_replace($id_gm, '', -1);
	        
    	}

		// print_r('<pre>');
		// print_r($gm);exit;

		return $gm;

    }

	public function get_MarketVisit_AM($tahun, $bulan, $id_user, $id_jenis_user){

		// $region = "'1','2','3','4'";
		$tahunbulan = $tahun.$bulan;

  //   	$gm = $this->get_gm($region);

    	$list_gm = "'1','2','3','4'";

		// print_r('<pre>');
		// print_r($tahun.' - '.$bulan);exit;

		$param_user = "";
		if ($id_jenis_user == '1012') {
			$param_user = "HRR.ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "HRR.ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "HRR.ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "HRR.ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$gm = $this->get_gm($list_gm);
			$param_user = "HRR.ID_GSM IN ($gm)";
		}


		$sql ="
			SELECT
				HSFF.ID_KUNJUNGAN_CUSTOMER,
				HSFF.TGL_RENCANA_KUNJUNGAN,
				HSFF.ID_USER AS ID_SO,
				HRR.NAMA_SO,
				HRR.ID_SM,
				HRR.NAMA_SM,
				HRR.ID_SSM,
				HRR.NAMA_SSM,
				HRR.ID_GSM,
				HRR.NAMA_GSM,
				HSFF.ID_TOKO,
				TK.NAMA_TOKO,
				TK.ID_REGION,
				TK.ID_PROVINSI,
				TK.NAMA_PROVINSI,
				TK.ID_AREA,
				TK.NAMA_AREA,
				TK.ID_DISTRIK,
				TK.NAMA_DISTRIK,
				TK.NAMA_KECAMATAN,
				HSFF.ID_HASIL_SURVEY,
				HSFF.ID_PRODUK,
				HSFF.NAMA_PRODUK,
				HSFF.STOK_SAAT_INI,
				HSFF.VOLUME_PEMBELIAN,
				HSFF.HARGA_PEMBELIAN,
				HSFF.TGL_PEMBELIAN,
				HSFF.TOP_PEMBELIAN,
				HSFF.VOLUME_PENJUALAN,
				HSFF.HARGA_PENJUALAN,
				HSFF.KAPASITAS_TOKO,
				KLFF.ID_SURVEY_KELUHAN,
				KLFF.ID_KELUHAN,
				KLFF.KELUHAN,
				KLFF.JAWABAN AS JAWABAN_KELUHAN,
				PMFF.ID_SURVEY_PROMOSI,
				PMFF.ID_PROMOSI,
				PMFF.PROMOSI,
				PMFF.JAWABAN AS JAWABAN_PROMOSI
			FROM
				(
				SELECT
					KJF.ID_KUNJUNGAN_CUSTOMER,
					KJF.TGL_RENCANA_KUNJUNGAN,
					KJF.ID_USER,
					KJF.ID_TOKO,
					HSF.ID_PRODUK,
					HSF.ID_HASIL_SURVEY,
					HSF.NAMA_PRODUK,
					HSF.STOK_SAAT_INI,
					HSF.VOLUME_PEMBELIAN,
					HSF.HARGA_PEMBELIAN,
					HSF.TGL_PEMBELIAN,
					HSF.TOP_PEMBELIAN,
					HSF.VOLUME_PENJUALAN,
					HSF.HARGA_PENJUALAN,
					HSF.KAPASITAS_TOKO
				FROM
					(
					SELECT
						KJ.ID_KUNJUNGAN_CUSTOMER,
						KJ.TGL_RENCANA_KUNJUNGAN,
						KJ.ID_USER,
						KJ.ID_TOKO,
						US.ID_JENIS_USER
					FROM
						(
						SELECT
							ID_KUNJUNGAN_CUSTOMER,
							TGL_RENCANA_KUNJUNGAN,
							ID_USER,
							ID_TOKO
						FROM
							CRMNEW_KUNJUNGAN_CUSTOMER
						WHERE
							TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYYMM') = '$tahunbulan') KJ
					LEFT JOIN CRMNEW_USER US ON
						KJ.ID_USER = US.ID_USER
					WHERE
						US.ID_JENIS_USER = '1012') KJF
				LEFT JOIN (
					SELECT
						HS.ID_HASIL_SURVEY,
						HS.ID_TOKO,
						HS.ID_KUNJUNGAN_CUSTOMER,
						HS.ID_PRODUK,
						PD.NAMA_PRODUK,
						HS.STOK_SAAT_INI,
						HS.VOLUME_PEMBELIAN,
						HS.HARGA_PEMBELIAN,
						HS.TGL_PEMBELIAN,
						HS.TOP_PEMBELIAN,
						HS.VOLUME_PENJUALAN,
						HS.HARGA_PENJUALAN,
						HS.KAPASITAS_TOKO
					FROM
						(
						SELECT
							ID_HASIL_SURVEY,
							ID_TOKO,
							ID_KUNJUNGAN_CUSTOMER,
							ID_PRODUK,
							STOK_SAAT_INI,
							VOLUME_PEMBELIAN,
							HARGA_PEMBELIAN,
							TGL_PEMBELIAN,
							TOP_PEMBELIAN,
							VOLUME_PENJUALAN,
							HARGA_PENJUALAN,
							KAPASITAS_TOKO
						FROM
							CRMNEW_HASIL_SURVEY
						WHERE
							DELETE_MARK = '0') HS
					LEFT JOIN (
						SELECT
							ID_PRODUK,
							NAMA_PRODUK
						FROM
							CRMNEW_PRODUK_SURVEY) PD ON
						HS.ID_PRODUK = PD.ID_PRODUK ) HSF ON
					KJF.ID_KUNJUNGAN_CUSTOMER = HSF.ID_KUNJUNGAN_CUSTOMER
					AND KJF.ID_TOKO = HSF.ID_TOKO ) HSFF
			LEFT JOIN (
				SELECT
					KJF.ID_KUNJUNGAN_CUSTOMER,
					KJF.ID_USER,
					KJF.ID_TOKO,
					KLF.ID_PRODUK,
					KLF.ID_SURVEY_KELUHAN,
					KLF.ID_KELUHAN,
					KLF.KELUHAN,
					KLF.JAWABAN
				FROM
					(
					SELECT
						KJ.ID_KUNJUNGAN_CUSTOMER,
						KJ.TGL_RENCANA_KUNJUNGAN,
						KJ.ID_USER,
						KJ.ID_TOKO,
						US.ID_JENIS_USER
					FROM
						(
						SELECT
							ID_KUNJUNGAN_CUSTOMER,
							TGL_RENCANA_KUNJUNGAN,
							ID_USER,
							ID_TOKO
						FROM
							CRMNEW_KUNJUNGAN_CUSTOMER
						WHERE
							TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYYMM') = '$tahunbulan') KJ
					LEFT JOIN CRMNEW_USER US ON
						KJ.ID_USER = US.ID_USER
					WHERE
						US.ID_JENIS_USER = '1012') KJF
				LEFT JOIN (
					SELECT
						KL.ID_KUNJUNGAN_CUSTOMER,
						KL.ID_PRODUK,
						KL.ID_SURVEY_KELUHAN,
						KL.ID_KELUHAN,
						NKL.KELUHAN,
						KL.JAWABAN
					FROM
						(
						SELECT
							ID_KUNJUNGAN_CUSTOMER,
							ID_PRODUK,
							ID_SURVEY_KELUHAN,
							ID_KELUHAN,
							JAWABAN
						FROM
							CRMNEW_SURVEY_KELUHAN_CUSTOMER
						WHERE
							DELETE_MARK = '0'
							AND JAWABAN IS NOT NULL) KL
					LEFT JOIN (
						SELECT
							ID_KELUHAN,
							KELUHAN
						FROM
							CRMNEW_KELUHAN) NKL ON
						KL.ID_KELUHAN = NKL.ID_KELUHAN) KLF ON
					KJF.ID_KUNJUNGAN_CUSTOMER = KLF.ID_KUNJUNGAN_CUSTOMER ) KLFF ON
				HSFF.ID_KUNJUNGAN_CUSTOMER = KLFF.ID_KUNJUNGAN_CUSTOMER
				AND HSFF.ID_USER = KLFF.ID_USER
				AND HSFF.ID_TOKO = KLFF.ID_TOKO
				AND HSFF.ID_PRODUK = KLFF.ID_PRODUK
			LEFT JOIN (
				SELECT
					KJF.ID_KUNJUNGAN_CUSTOMER,
					KJF.ID_USER,
					KJF.ID_TOKO,
					TO_CHAR(PMF.ID_PRODUK) AS ID_PRODUK,
					PMF.ID_SURVEY_PROMOSI,
					PMF.ID_PROMOSI,
					PMF.PROMOSI,
					PMF.JAWABAN
				FROM
					(
					SELECT
						KJ.ID_KUNJUNGAN_CUSTOMER,
						KJ.TGL_RENCANA_KUNJUNGAN,
						KJ.ID_USER,
						KJ.ID_TOKO,
						US.ID_JENIS_USER
					FROM
						(
						SELECT
							ID_KUNJUNGAN_CUSTOMER,
							TGL_RENCANA_KUNJUNGAN,
							ID_USER,
							ID_TOKO
						FROM
							CRMNEW_KUNJUNGAN_CUSTOMER
						WHERE
							TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYYMM') = '$tahunbulan') KJ
					LEFT JOIN CRMNEW_USER US ON
						KJ.ID_USER = US.ID_USER
					WHERE
						US.ID_JENIS_USER = '1012') KJF
				LEFT JOIN (
					SELECT
						PM.ID_KUNJUNGAN_CUSTOMER,
						PM.ID_PRODUK,
						PM.ID_SURVEY_PROMOSI,
						PM.ID_PROMOSI,
						NPM.PROMOSI,
						PM.JAWABAN
					FROM
						(
						SELECT
							ID_KUNJUNGAN_CUSTOMER,
							ID_PRODUK,
							ID_SURVEY_PROMOSI,
							ID_PROMOSI,
							JAWABAN
						FROM
							CRMNEW_SURVEY_PROMO_CUSTOMER
						WHERE
							DELETE_MARK = '0'
							AND JAWABAN IS NOT NULL) PM
					LEFT JOIN (
						SELECT
							ID_PROMOSI,
							PROMOSI
						FROM
							CRMNEW_PROMOSI) NPM ON
						PM.ID_PROMOSI = NPM.ID_PROMOSI) PMF ON
					KJF.ID_KUNJUNGAN_CUSTOMER = PMF.ID_KUNJUNGAN_CUSTOMER ) PMFF ON
				HSFF.ID_KUNJUNGAN_CUSTOMER = PMFF.ID_KUNJUNGAN_CUSTOMER
				AND HSFF.ID_USER = PMFF.ID_USER
				AND HSFF.ID_TOKO = PMFF.ID_TOKO
				AND HSFF.ID_PRODUK = PMFF.ID_PRODUK
			LEFT JOIN HIRARCKY_GSM_TO_SO HRR ON
				HSFF.ID_USER = HRR.ID_SO
			LEFT JOIN (
				SELECT
					DISTINCT(KD_CUSTOMER) AS KD_CUSTOMER,
					NAMA_TOKO,
					NEW_REGION AS ID_REGION,
					ID_PROVINSI,
					NAMA_PROVINSI,
					ID_AREA,
					NAMA_AREA,
					ID_DISTRIK,
					NAMA_DISTRIK,
					NAMA_KECAMATAN
				FROM
					T_TOKO_SALES_TSO) TK ON
				HSFF.ID_TOKO = TK.KD_CUSTOMER
			WHERE
				$param_user
			ORDER BY
				HSFF.ID_KUNJUNGAN_CUSTOMER
		";

		// print_r('<pre>');
		// print_r($sql);exit;
		
		return $this->db->query($sql)->result_array();
	}

	public function get_data_hasil_survey($tahun=null, $bulan=null, $id_user=null, $jenis=null){
		$sql =" 
			SELECT
			R.*

			FROM R1_HASIL_SURVEY_SD R
			WHERE TAHUN='$tahun'
			AND BULAN='$bulan'

		";
		if($jenis!=null){
			if($jenis=='SO'){
				$sql .=" AND ID_SO='$id_user' ";
			}
			else if($jenis=='SM'){
				$sql .=" AND ID_SM='$id_user' ";
			}
			else if($jenis=='SSM'){
				$sql .=" AND ID_SSM='$id_user' ";
			}
			else if($jenis=='DIS'){
				$sql .=" AND KODE_DISTRIBUTOR IN (SELECT
			KODE_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR
			WHERE DELETE_MARK='0'
			AND ID_USER='$id_user') ";
			}
			
		}

		// print_r('<pre>');
		// print_r($sql);exit;
		
		return $this->db->query($sql)->result_array();
	}

	public function get_data_admin($tahun=null, $bulan=null, $id_tso=null, $id_gsm=null, $spc=null)
	{	
		$sql =" 
			SELECT
			R.*

			FROM R1_HASIL_SURVEY_SD R
			WHERE TAHUN='$tahun'
			AND BULAN='$bulan'

		";
		
		if($id_tso!=null){
			$sql .=" AND ID_SO='$id_tso' ";
		}
		if($id_gsm!=null){
			$sql .=" AND ID_GSM='$id_gsm' ";
		}
		if($spc!=null){
			$sql .=" AND REGION_ID IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE ID_USER='$spc' ) ";
		}
		
		//ECHO $sql;
		
		//
		// if($id_dis!=null){
		// 	$sql .= " AND KODE_DISTRIBUTOR ='$id_dis' ";
		// }
		
		// if($region!=null){
		// 	$sql .= " AND REGION_ID ='$region' ";
		// }
		
		// if($id_prov!=null){
		// 	$sql .= " AND ID_PROVINSI ='$id_prov' ";
		// }
		
		
		return $this->db->query($sql)->result_array();
	}
	
	
	public function get_data_tso($id_user, $id_dis=null,  $id_sales=null)
	{	
		$sql =" 
			SELECT 
				ID_SALES,
				NAMA_SALES,
				KODE_DISTRIBUTOR,
				NAMA_DISTRIBUTOR,
				NAMA_SO,
				NAMA_SM,
				NAMA_SSM,
				NAMA_PROVINSI,
				REGION_ID,
				NAMA_GSM,
                NM_AREA,
                NM_DISTRIK
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SO = '$id_user'
			AND ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
		";
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR='$id_dis' ";
		}
		
		if($id_sales!=null){
			$sql .= " AND ID_SALES='$id_sales' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_asm($id_user , $id_dis=null, $id_tso=null)
	{	
		$sql =" 
			SELECT 
				ID_SALES,
				NAMA_SALES,
				NAMA_DISTRIBUTOR,
				NAMA_SO,
				NAMA_SM,
				NAMA_SSM,
				NAMA_PROVINSI,
				REGION_ID,
				NAMA_GSM,
                NM_AREA,
                NM_DISTRIK
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SM = '$id_user'
			AND ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
		";
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR='$id_dis' ";
		}
		
		if($id_tso!=null){
			$sql .= " AND ID_SO='$id_tso' ";
		}
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_rsm($id_user , $id_dis =null)
	{	
		$sql =" 
			SELECT 
				ID_SALES,
				NAMA_SALES,
				NAMA_DISTRIBUTOR,
				NAMA_SO,
				NAMA_SM,
				NAMA_SSM,
				NAMA_PROVINSI,
				REGION_ID,
				NAMA_GSM,
                NM_AREA,
                NM_DISTRIK
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SSM = '$id_user'
			AND ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
		";
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR='$id_dis' ";
		}
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_gsm($id_rsm , $rsm =null, $id_dis=null)
	{	
		$sql =" 
			SELECT 
				ID_SALES,
				NAMA_SALES,
				NAMA_DISTRIBUTOR,
				NAMA_SO,
				NAMA_SM,
				NAMA_SSM,
				NAMA_PROVINSI,
				REGION_ID,
                NM_AREA,
                NM_DISTRIK
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SSM IN ($id_rsm)
			AND ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
		";
		
		if($rsm!=null){
			$sql .= " AND ID_SSM = '$rsm' ";
		}
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR = '$id_dis' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_dis($id_user)
	{	
		$sql =" 
			SELECT 
				MS.ID_SALES AS ID_USER,
				MS.NAMA_SALES AS NAMA,
				MS.NAMA_DISTRIBUTOR,
				MD.NAMA_TSO,
				MD.NAMA_ASM,
				MD.NAMA_RSM,
				MD.NAMA_PROVINSI,
				MD.NEW_REGION,
				MD.NAMA_GSM
			FROM M_SALES_USER_DISTRIBUTOR MS LEFT JOIN M_SALES_DISTRIBUTOR MD
			ON MS.ID_SALES = MD.ID_USER
			WHERE MS.ID_USER_DISTRIBUTOR = '$id_user'
		";

		return $this->db->query($sql)->result_array();
	}
	
	public function RSM_GSM($id_user){
		
		$sql ="
			SELECT 
			ID_RSM,NAMA_RSM
			FROM SO_TOPDOWN_RSM
			WHERE ID_GSM = '$id_user'
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function RSMlist($id_user){
		
		$sql ="
			SELECT 
			ID_RSM,NAMA_RSM
			FROM SO_TOPDOWN_RSM
			WHERE ID_GSM = '$id_user'
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function User_distributor($id_user=null){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_user!=null){
			$sql .= " AND ID_SO='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	
	public function ASM_dis($id_user){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_user!=null){
			$sql .= " AND ID_SM='$id_user' ";
		}
		
		
		return $this->db->query($sql)->result();
	}
	
	public function RSM_dis($id_user){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_user!=null){
			$sql .= " AND ID_SSM='$id_user' ";
		}
		
		
		return $this->db->query($sql)->result();
	}
	
	public function GSM_dis($id_user){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_user!=null){
			$sql .= " AND ID_GSM='$id_user' ";
		}
		
		
		return $this->db->query($sql)->result();
	}
	
	public function User_Area($id_user=null){
		$sql ="
			SELECT
			UA.ID_USER_AREA,
			UA.ID_USER,
			MA.KD_AREA AS ID_AREA,
			MA.NAMA_AREA
			FROM CRMNEW_USER_AREA UA
			LEFT JOIN CRMNEW_M_AREA MA ON UA.ID_AREA=MA.ID_AREA
			WHERE UA.DELETE_MARK='0'		
		";
		
		if($id_user!=null){
			$sql .= " AND UA.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	public function User_Provinsi($id_user=null){
		$sql ="
			SELECT
			UP.ID_USER_PROVINSI,
			UP.ID_USER,
			UP.ID_PROVINSI,
			P.NAMA_PROVINSI
			FROM CRMNEW_USER_PROVINSI UP
			LEFT JOIN CRMNEW_M_PROVINSI P ON UP.ID_PROVINSI=P.ID_PROVINSI
			WHERE UP.DELETE_MARK='0' 			
		";
		
		if($id_user!=null){
			$sql .= " AND UP.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	public function User_TSO($id_user){
		$sql ="
			SELECT DISTINCT
				ID_SO,
				NAMA_SO
			FROM HIRARCKY_GSM_SALES_DISTRIK
				WHERE ID_SM = '$id_user'			
		";
		
		return $this->db->query($sql)->result();
	}
	public function listASM($id_user){
        $sql ="
			SELECT DISTINCT
				ID_SM,
				NAMA_SM
			FROM HIRARCKY_GSM_SALES_DISTRIK
				WHERE ID_SSM = '$id_user'             
        ";

        return $this->db->query($sql)->result();
    }
	public function User_RSM($id_user=null){
		$sql ="
			SELECT
			UR.NO_USER_RSM,
			UR.ID_USER,
			UR.ID_RSM,
			U.NAMA
			FROM CRMNEW_USER_RSM UR
			LEFT JOIN CRMNEW_USER U ON UR.ID_RSM=U.ID_USER
			WHERE UR.DELETE_MARK='0'			
		";
		
		if($id_user!=null){
			$sql .= " AND UR.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
    public function User_GUDANG($id_user=null){
        $sql ="
            SELECT
            UG.NO_USER_GUDANG,
            UG.ID_USER,
            UG.ID_GUDANG_DISTRIBUTOR,
            GD.KD_GUDANG,
            GD.NM_GUDANG
            FROM CRMNEW_USER_GUDANG UG
            LEFT JOIN CRMNEW_GUDANG_DISTRIBUTOR GD ON UG.ID_GUDANG_DISTRIBUTOR=GD.NO_GD
            WHERE UG.DELETE_MARK='0' 
                      
        ";
        
        if($id_user!=null){
            $sql .= " AND UG.ID_USER='$id_user' ";
        }
        
        return $this->db->query($sql)->result();
    }
	
    public function User_SALES($id_user=null, $id_dis=null){
        $sql ="
            SELECT DISTINCT
				ID_SALES,
				NAMA_SALES
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SO = '$id_user'
			AND ID_SALES IS NOT NULL
			AND NAMA_SALES IS NOT NULL
        ";
		
		if($id_dis!=null){
			$sql .= " AND KODE_DISTRIBUTOR = '$id_dis' ORDER BY NAMA_SALES ASC";
		}
        
        return $this->db->query($sql)->result();
    }
	
	public function Get_region_all(){
		
		$sql ="
			SELECT DISTINCT 
				NEW_REGION
			FROM 
				CRMNEW_M_PROVINSI
            WHERE 
                NEW_REGION IS NOT NULL
            ORDER BY NEW_REGION ASC 
		";
		
		return $this->db->query($sql)->result();
	}
	
	public function Get_provinsi_all($id_region=null){
		
		$sql ="
			SELECT DISTINCT 
				ID_PROVINSI,
				NAMA_PROVINSI 
			FROM 
				CRMNEW_M_PROVINSI
		";
		
		if($id_region!=null){
			$sql .= " WHERE NEW_REGION = '$id_region' ORDER BY NAMA_PROVINSI ASC";
		}
		
		return $this->db->query($sql)->result();
	}
	
	public function Get_dis_all($id_provinsi=null){
		
		$sql ="
			SELECT DISTINCT 
				KODE_DISTRIBUTOR,
				NAMA_DISTRIBUTOR 
			FROM 
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		if($id_provinsi!=null){
			$sql .= " AND ID_PROVINSI = '$id_provinsi' ORDER BY NAMA_DISTRIBUTOR ASC";
		}
		
		return $this->db->query($sql)->result();
	}
}
?>