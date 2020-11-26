<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Dashboard_PMB_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        // $this->load->database();
        $this->db = $this->load->database('crm', TRUE);
        $this->db2 = $this->load->database('3pl', TRUE);
        $this->db3 = $this->load->database('SCM', TRUE);
		$this->db4 = $this->load->database('Point', TRUE);
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

    public function get_Distr($id_user, $id_jenis_user, $region){

    	$gm = $this->get_gm($region);

    	$list_gm = "'1','2','3','4'";

    	

		// print_r('<pre>');
		// print_r($id_user);exit;

		$param_user = "";
		$param_distr = "";
		if ($id_jenis_user == '1012') {
			$param_user = "ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$gm = $this->get_gm($list_gm);
			$param_user = "ID_GSM IN ($gm)";
		} elseif ($id_jenis_user == '1013') {
			$param_distr = "TO_NUMBER(NVL(KODE_DISTRIBUTOR, 0)) = TO_NUMBER('$kdDistr')";
		}

        $sql = "
        	SELECT
				*
			FROM
				(
				SELECT
					DISTINCT(KODE_DISTRIBUTOR) AS KODE_DISTRIBUTOR
				FROM
					HIRARCKY_GSM_SALES_DISTRIK
				WHERE
					KODE_DISTRIBUTOR IS NOT NULL
					AND ID_GSM IN ($gm)
				ORDER BY
					KODE_DISTRIBUTOR)
        ";

        $res = $this->db->query($sql)->result_array();

    	// $kd_distr = '';
    	// $distr = '';
    	// $distr_fix = '';
    	// $distr_in = '';

    	// if (!empty($res)) {
	    //     foreach ($res as $k => $v){
	    //     	if (!empty($v['KODE_DISTRIBUTOR'])) {
	    //     		$kd_distr .= "OR SOLD_TO = '" . $v['KODE_DISTRIBUTOR'] . "' ";

	    //     	}
	    //     }

	    //     $distr = substr_replace($kd_distr, '', -1);
	    //     $distr_fix = substr_replace($distr, '', 0, 3);
	    //     $distr_in = "AND KODE_DISTRIBUTOR IN ($distr)";
	        
    	// }


		// print_r('<pre>');
		// print_r($sql);exit;

		return $res;


    }

    public function get_Distrik($id_user, $id_jenis_user, $region){

    	$gm = $this->get_gm($region);

    	$list_gm = "'1','2','3','4'";

    	

		// print_r('<pre>');
		// print_r($id_user);exit;

		$param_user = "";
		$param_distr = "";
		if ($id_jenis_user == '1012') {
			$param_user = "ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$gm = $this->get_gm($list_gm);
			$param_user = "ID_GSM IN ($gm)";
		} elseif ($id_jenis_user == '1013') {
			$param_distr = "TO_NUMBER(NVL(KODE_DISTRIBUTOR, 0)) = TO_NUMBER('$kdDistr')";
		}

        $sql = "
        	SELECT
				*
			FROM
				(
	        	SELECT
					DISTINCT(ID_DISTRIK) AS ID_DISTRIK
				FROM
					HIRARCKY_GSM_SALES_DISTRIK
				WHERE
					ID_DISTRIK IS NOT NULL
					AND ID_GSM IN ($gm)
				ORDER BY
					ID_DISTRIK)
        ";

		// print_r('<pre>');
		// print_r($sql);exit;

        $res = $this->db->query($sql)->result_array();

    	$kd_distrik = '';
    	$distrik = '';
    	$distrik_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['ID_DISTRIK'])) {
	        		$kd_distrik .= "'" . $v['ID_DISTRIK'] . "',";

	        	}
	        }

	        $distrik = substr_replace($kd_distrik, '', -1);
	        
    	}


		// print_r('<pre>');
		// print_r($distr);exit;

		return $distrik;


    }

    public function get_Distr_TBL($by, $set, $id_user, $id_jenis_user){

		$u_distr = "
        	SELECT
				KODE_DISTRIBUTOR
			FROM
				CRMNEW_USER_DISTRIBUTOR
			WHERE
				ID_USER = '$id_user'
        ";

    	$kd_u_distr = $this->db->query($u_distr)->row_array();
    	$kdDistr = $kd_u_distr['KODE_DISTRIBUTOR'];

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;

		$param_user = "";
		$param_distr = "";
		if ($id_jenis_user == '1012') {
			$param_user = "AND ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "AND ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "AND ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "AND ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "AND ID_GSM IN ($gm)";
		} elseif ($id_jenis_user == '1013') {
			$param_distr = "AND TO_NUMBER(NVL(KODE_DISTRIBUTOR, 0)) = TO_NUMBER('$kdDistr')";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGION_ID = '$set'";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND ID_PROVINSI = '$set'";
		} elseif ($by == 'AREA') {
			$param_filter = "AND KD_AREA = '$set'";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND ID_DISTRIK = '$set'";
		} elseif ($by == 'DISTRIBUTOR') {
			$param_filter = "AND KODE_DISTRIBUTOR = '$set'";
		}

        $sql = "
        	SELECT
				*
			FROM
				(
				SELECT
					DISTINCT(KODE_DISTRIBUTOR) AS KODE_DISTRIBUTOR
				FROM
					HIRARCKY_GSM_SALES_DISTRIK
				WHERE
					KODE_DISTRIBUTOR IS NOT NULL
					$param_user
					$param_distr
					$param_filter
				ORDER BY
					KODE_DISTRIBUTOR)
        ";

		// print_r('<pre>');
		// print_r($sql);exit;

        $res = $this->db->query($sql)->result_array();

    	// $kd_distr = '';
    	// $distr = '';
    	// $distr_fix = '';
    	// $distr_in = '';

    	// if (!empty($res)) {
	    //     foreach ($res as $k => $v){
	    //     	if (!empty($v['KODE_DISTRIBUTOR'])) {
	    //     		$kd_distr .= "OR SOLD_TO = '" . $v['KODE_DISTRIBUTOR'] . "' ";

	    //     	}
	    //     }

	    //     $distr = substr_replace($kd_distr, '', -1);
	    //     $distr_fix = substr_replace($distr, '', 0, 3);
	    //     $distr_in = "AND KODE_DISTRIBUTOR IN ($distr)";
	        
    	// }


		// print_r('<pre>');
		// print_r($res);exit;

		return $res;


    }

    public function get_Distrik_TBL($by, $set, $id_user, $id_jenis_user){

		$u_distr = "
        	SELECT
				KODE_DISTRIBUTOR
			FROM
				CRMNEW_USER_DISTRIBUTOR
			WHERE
				ID_USER = '$id_user'
        ";

    	$kd_u_distr = $this->db->query($u_distr)->row_array();
    	$kdDistr = $kd_u_distr['KODE_DISTRIBUTOR'];

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;

		$param_user = "";
		$param_distr = "";
		if ($id_jenis_user == '1012') {
			$param_user = "AND ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "AND ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "AND ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "AND ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "AND ID_GSM IN ($gm)";
		} elseif ($id_jenis_user == '1013') {
			$param_distr = "AND TO_NUMBER(NVL(KODE_DISTRIBUTOR, 0)) = TO_NUMBER('$kdDistr')";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGION_ID = '$set'";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND ID_PROVINSI = '$set'";
		} elseif ($by == 'AREA') {
			$param_filter = "AND KD_AREA = '$set'";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND ID_DISTRIK = '$set'";
		} elseif ($by == 'DISTRIBUTOR') {
			$param_filter = "AND KODE_DISTRIBUTOR = '$set'";
		}

        $sql = "
        	SELECT
				*
			FROM
				(
				SELECT
					DISTINCT(ID_DISTRIK) AS ID_DISTRIK
				FROM
					HIRARCKY_GSM_SALES_DISTRIK
				WHERE
					ID_DISTRIK IS NOT NULL
					$param_user
					$param_distr
					$param_filter
				ORDER BY
					ID_DISTRIK)
        ";

		// print_r('<pre>');
		// print_r($sql);exit;

        $res = $this->db->query($sql)->result_array();

    	// $kd_distr = '';
    	// $distr = '';
    	// $distr_fix = '';
    	// $distr_in = '';

    	// if (!empty($res)) {
	    //     foreach ($res as $k => $v){
	    //     	if (!empty($v['KODE_DISTRIBUTOR'])) {
	    //     		$kd_distr .= "OR SOLD_TO = '" . $v['KODE_DISTRIBUTOR'] . "' ";

	    //     	}
	    //     }

	    //     $distr = substr_replace($kd_distr, '', -1);
	    //     $distr_fix = substr_replace($distr, '', 0, 3);
	    //     $distr_in = "AND KODE_DISTRIBUTOR IN ($distr)";
	        
    	// }


		// print_r('<pre>');
		// print_r($res);exit;

		return $res;


    }

    public function get_Customer_TBL($id_user, $id_jenis_user, $getDistr_TBL, $getDistrik_TBL){

    	$kd_distr = '';
    	$distr = '';
    	$distr_fix = '';
    	$distr_in = '';

    	if (!empty($getDistr_TBL)) {
	        foreach ($getDistr_TBL as $k => $v){
	        	if (!empty($v['KODE_DISTRIBUTOR'])) {
	        		$kd_distr .= "OR KODE_DISTRIBUTOR = '" . $v['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr = substr_replace($kd_distr, '', -1);
	        $distr_fix = "AND (".substr_replace($distr, '', 0, 3).")";
	        
    	}

    	$kd_distrik = '';
    	$distrik = '';
    	$distrik_fix = '';
    	$distrik_in = '';

    	if (!empty($getDistrik_TBL)) {
	        foreach ($getDistrik_TBL as $k2 => $v2){
	        	if (!empty($v2['ID_DISTRIK'])) {
	        		$kd_distrik .= "OR ID_DISTRIK = '" . $v2['ID_DISTRIK'] . "' ";

	        	}
	        }

	        $distrik = substr_replace($kd_distrik, '', -1);
	        $distrik_fix = "AND (".substr_replace($distrik, '', 0, 3).")";
	        
    	}

        $sql = "
        	SELECT
				DISTINCT(KD_CUSTOMER) AS KD_CUSTOMER
			FROM
				T_TOKO_SALES_TSO
			WHERE
				KD_CUSTOMER IS NOT NULL
				$distr_fix
				$distrik_fix
			ORDER BY
				KD_CUSTOMER
        ";

		// print_r('<pre>');
		// print_r($sql);exit;

        $res = $this->db->query($sql)->result_array();

    	// $kd_distr = '';
    	// $distr = '';
    	// $distr_fix = '';
    	// $distr_in = '';

    	// if (!empty($res)) {
	    //     foreach ($res as $k => $v){
	    //     	if (!empty($v['KODE_DISTRIBUTOR'])) {
	    //     		$kd_distr .= "OR SOLD_TO = '" . $v['KODE_DISTRIBUTOR'] . "' ";

	    //     	}
	    //     }

	    //     $distr = substr_replace($kd_distr, '', -1);
	    //     $distr_fix = substr_replace($distr, '', 0, 3);
	    //     $distr_in = "AND KODE_DISTRIBUTOR IN ($distr)";
	        
    	// }


		// print_r('<pre>');
		// print_r($res);exit;

		return $res;


    }

    public function get_Region_new($id_user, $id_jenis_user){

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		$param_user = "";
		$param_distr = "";
		if ($id_jenis_user == '1012') {
			$param_user = "ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "ID_GSM IN ($gm)";
		} elseif ($id_jenis_user == '1013') {
			$param_distr = "TO_NUMBER(NVL(KODE_DISTRIBUTOR, 0)) = TO_NUMBER('$kdDistr')";
		}

        $sql = "
        	SELECT
				DISTINCT(REGION_ID) AS REGION_ID
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE
				$param_user
				$param_distr
				AND REGION_ID IS NOT NULL
        ";

        $res = $this->db->query($sql)->row_array();


		// print_r('<pre>');
		// print_r($res);exit;

		return $res['REGION_ID'];


    }
	
	public function get_mapping_user($by, $set, $id_user, $id_jenis_user){

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;

		$param_user = "";
		$param_distr = "";
		if ($id_jenis_user == '1012') {
			$param_user = "ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "ID_GSM IN ($gm)";
		} elseif ($id_jenis_user == '1013') {
			$param_distr = "TO_NUMBER(NVL(KODE_DISTRIBUTOR, 0)) = TO_NUMBER('$kdDistr')";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGION_ID = '$set'";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND ID_PROVINSI = '$set'";
		} elseif ($by == 'AREA') {
			$param_filter = "AND KD_AREA = '$set'";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND ID_DISTRIK = '$set'";
		} elseif ($by == 'DISTRIBUTOR') {
			$param_filter = "AND KODE_DISTRIBUTOR = '$set'";
		}

		$sql_fix = "
			SELECT
				COUNT(*) AS JML
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE
				$param_user
				$param_distr
				$param_filter
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		return $this->db->query($sql_fix)->row_array();

	}
        
    public function getRegion(){
        /*$sql = "
            SELECT DISTINCT(NEW_REGION) AS ID_REGION, NEW_REGION AS REGION FROM R_REPORT_VISIT_SALES
            WHERE NEW_REGION IS NOT NULL
            ORDER BY NEW_REGION ASC
        ";
        */
        $sqlNew = "
            SELECT DISTINCT(REGION_ID) AS ID_REGION, REGION_ID AS REGION FROM WILAYAH_SMI
            WHERE REGION_ID IS NOT NULL
            ORDER BY REGION_ID ASC
        ";
        return $this->db->query($sqlNew)->result();
    }
    
    public function getProvinsi(){
        /*
        $sql = "
            SELECT DISTINCT(ID_PROVINSI) AS ID_PROVINSI, NAMA_PROVINSI FROM R_REPORT_VISIT_SALES
            WHERE ID_PROVINSI IS NOT NULL
            ORDER BY NAMA_PROVINSI ASC
        ";
        */
        $sqlNew = "
            SELECT DISTINCT(ID_PROVINSI) AS ID_PROVINSI, NAMA_PROVINSI FROM WILAYAH_SMI
            WHERE ID_PROVINSI IS NOT NULL
            ORDER BY NAMA_PROVINSI ASC
        ";
        return $this->db->query($sqlNew)->result();
    }
    
    public function getArea(){
        /*
        $sql = "
            SELECT DISTINCT(KD_AREA) AS ID_AREA, NAMA_AREA FROM R_REPORT_VISIT_SALES
            WHERE KD_AREA IS NOT NULL
            ORDER BY NAMA_AREA ASC
        ";
        */
        $sqlNew = "
            SELECT DISTINCT(KD_AREA) AS ID_AREA, NM_AREA AS NAMA_AREA FROM WILAYAH_SMI
            WHERE KD_AREA IS NOT NULL
            ORDER BY KD_AREA ASC
        ";
        return $this->db->query($sqlNew)->result();
    }
    
    public function getDistriK(){
    	
        $sqlNew = "
            SELECT
                DISTINCT(ID_DISTRIK) AS ID_DISTRIK,
                NAMA_DISTRIK
            FROM
                CRMNEW_M_DISTRIK
            WHERE
                DELETE_MARK = '0'
                AND ID_PROVINSI != '1000'
            ORDER BY
                ID_DISTRIK ASC
        ";
        return $this->db->query($sqlNew)->result();
    }
        
        public function getDistributor(){
            /*
            $sql = "
                SELECT DISTINCT(KODE_DISTRIBUTOR) AS KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR FROM R_REPORT_VISIT_SALES
                WHERE KODE_DISTRIBUTOR IS NOT NULL
                ORDER BY NAMA_DISTRIBUTOR ASC
            ";
            */
            $sqlNew = "
                SELECT DISTINCT(KODE_DISTRIBUTOR) AS KODE_DISTRIBUTOR, NAMA_DISTRIBUTOR FROM CRMNEW_DISTRIBUTOR
                WHERE KODE_DISTRIBUTOR IS NOT NULL
                ORDER BY NAMA_DISTRIBUTOR ASC
            ";
            return $this->db->query($sqlNew)->result();
        }
	
	public function set_User($id_user, $id_jenis_user, $nama, $username, $password, $email){
		$hasil = false;
		if($id_user != '0000'){
			$sqlUp = "
				UPDATE CRMNEW_USER
				SET 
					NAMA = '$nama',
					USERNAME = '$username',
					PASSWORD = '$password',
					ID_JENIS_USER = '$id_jenis_user',
					EMAIL = '$email',
					UPDATED_BY = '1000',
					UPDATED_AT = SYSDATE,
					DELETED_MARK = 0
				WHERE ID_USER = '$id_user'
			";
			$this->db->query($sqlUp);
			$hasil = true;
		} else {
			$sqlIn = "
				INSERT INTO CRMNEW_USER (NAMA, USERNAME, PASSWORD, ID_JENIS_USER, EMAIL, CREATED_BY, CREATED_AT, FLAG, DELETED_MARK)
				VALUES 
				('$nama', '$username', '$password', '$id_jenis_user', '$email', '1000', SYSDATE, 'SBI', 0)
			";
			$this->db->query($sqlIn);
			$hasil = true;
		}
		return $hasil;
	}
	
	public function del_User($id_user){
		$sqlnext = "
			UPDATE CRMNEW_MAPPING_HIERARKI_USER
			SET 
				DELETE_MARK = 1
			WHERE USER_ID = '$id_user' OR ID_ATASAN_LANGSUNG = '$id_user'
		";
		$hasil2 = $this->db->query($sqlnext);
		
		$sqlFirst = "
			UPDATE CRMNEW_USER
			SET 
				DELETED_MARK = 1
			WHERE ID_USER = '$id_user'
		";
		$hasil1 = $this->db->query($sqlFirst);
		
		return $hasil1.' dan '.$hasil2;
	}
	
	public function get_GSM($id_user = null){
		$sqlIn = "";
		if($id_user != null){
			$sqlIn = " AND CU.ID_USER = '$id_user' ";
		}
		
		$sql = "
			SELECT  
				CU.ID_USER, CU.NAMA, CU.USERNAME, CU.PASSWORD, CU.ID_JENIS_USER, CU.EMAIL, CMHU.ID_ATASAN_LANGSUNG,CMHU.CAKUPAN_WILAYAH, CCW.LABEL 
			FROM CRMNEW_USER CU
			LEFT JOIN CRMNEW_MAPPING_HIERARKI_USER CMHU
				ON CU.ID_USER = CMHU.USER_ID AND CMHU.DELETE_MARK IS NULL
			LEFT JOIN CRMNEW_CAKUPAN_WILAYAH CCW
				ON CMHU.CAKUPAN_WILAYAH = CCW.KODE AND DELETED_MARK IS NULL
			WHERE CU.ID_JENIS_USER = '1016' AND CU.FLAG = 'SBI' AND CU.DELETED_MARK = 0
			$sqlIn AND CU.ID_USER IS NULL
			ORDER BY CU.NAMA ASC
		"; 
		return $this->db->query($sql)->result_array();
	}
	
	public function get_fromCRMSLS($by, $set, $tahun, $bulan, $id_user, $id_jenis_user){ 

		$tahunbulan = date('Ym', strtotime($tahun.'-'.$bulan));

		$am = "";

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;


		$param_user = "";
		if ($id_jenis_user == '1012') {
			$param_user = "AND ID_SO = '$id_user'";
			$am = "AND CREATE_BY = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "AND ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "AND ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "AND ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "AND ID_GSM IN ($gm)";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGION_ID = '$set'";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND ID_PROVINSI = '$set'";
		} elseif ($by == 'AREA') {
			$param_filter = "AND KD_AREA = '$set'";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND ID_DISTRIK = '$set'";
		} elseif ($by == 'DISTRIBUTOR') {
			$param_filter = "AND KODE_DISTRIBUTOR = '$set'";
		}

		$tgl_awal = $tahunbulan.'01';
		$tgl_akhir = date('Ymd', strtotime('-1 days'));
		$param_tgl = "";
		if ($tahunbulan == date('Ym')) {
			$param_tgl = "AND TAHUN || BULAN || HARI BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		}

		// print_r('<pre>');
		// print_r($param_tgl);exit;

        $sql = "
        	SELECT
				CASE
					WHEN HRR.ID_SALES IS NULL THEN VS.ID_SALES
					ELSE HRR.ID_SALES
				END AS ID_SALES,
				HRR.NM_SALES,
				CASE
					WHEN HRR.USER_SALES IS NULL THEN VS.NAMA_SALES
					ELSE HRR.USER_SALES
				END AS USER_SALES,
				SUM(NVL(VS.TARGET_VISIT, 0)) AS TRG_VISIT,
				SUM(NVL(VS.ACTUAL_VISIT, 0)) AS ACT_VISIT,
				SUM(NVL(TRG_SLS.TRG_TOKO_UNIT, 0)) AS TRG_TOKO_UNIT,
				SUM(NVL(TRG_SLS.TRG_TOKO_AKTIF, 0)) AS TRG_TOKO_AKTIF,
				SUM(NVL(TRG_SLS.TRG_TOKO_BARU, 0)) AS TRG_TOKO_BARU,
				SUM(NVL(TRG_SLS.TRG_SELL_OUT_SDG, 0)) AS TRG_SELL_OUT_SDG,
				SUM(NVL(TRG_SLS.TRG_SELL_OUT_BK, 0)) AS TRG_SELL_OUT_BK
			FROM
				(
				SELECT
					DISTINCT(ID_SALES) AS ID_SALES,
					NAMA_SALES AS NM_SALES,
					USER_SALES
				FROM
					HIRARCKY_GSM_SALES_DISTRIK
				WHERE
					NAMA_SALES IS NOT NULL
					AND USER_SALES IS NOT NULL
					$param_user
					$param_filter
			) HRR
			LEFT JOIN (
				SELECT
					ID_SALES,
					NAMA_SALES,
					SUM(TARGET) AS TARGET_VISIT,
					SUM(REALISASI) AS ACTUAL_VISIT
				FROM
					VISIT_SALES_DISTRIBUTOR
				WHERE
					TAHUN || BULAN = '$tahunbulan'
					$param_tgl
				GROUP BY
					ID_SALES,
					NAMA_SALES ) VS ON
				HRR.ID_SALES = VS.ID_SALES
			LEFT JOIN (
				SELECT
					ID_SALES,
					SUM(TOKO_UNIT) AS TRG_TOKO_UNIT,
					SUM(TOKO_AKTIF) AS TRG_TOKO_AKTIF,
					SUM(TOKO_BARU) AS TRG_TOKO_BARU,
					SUM(SELL_OUT_SDG) AS TRG_SELL_OUT_SDG,
					SUM(SELL_OUT_BK) AS TRG_SELL_OUT_BK
				FROM
					CRMNEW_TARGET_SELLING_OUT_S
				WHERE
					TAHUN || BULAN = '$tahunbulan'
					AND DELETED_MARK = '0'
					$am
				GROUP BY
					ID_SALES ) TRG_SLS ON
				HRR.ID_SALES = TRG_SLS.ID_SALES
			GROUP BY
				HRR.ID_SALES,
				VS.ID_SALES,
				HRR.NM_SALES,
				HRR.USER_SALES,
				VS.NAMA_SALES
			ORDER BY
				HRR.USER_SALES
        ";

		return $this->db->query($sql)->result_array();

	}
	
	public function get_cusCRM($by, $set, $tahun, $bulan, $id_user, $id_jenis_user){

		$tahunbulan = date('Ym', strtotime($tahun.'-'.$bulan));

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;


		$param_user = "";
		if ($id_jenis_user == '1012') {
			$param_user = "AND ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "AND ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "AND ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "AND ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "AND ID_GSM IN ($gm)";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGION_ID = '$set'";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND ID_PROVINSI = '$set'";
		} elseif ($by == 'AREA') {
			$param_filter = "AND KD_AREA = '$set'";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND ID_DISTRIK = '$set'";
		} elseif ($by == 'DISTRIBUTOR') {
			$param_filter = "AND KODE_DISTRIBUTOR = '$set'";
		}

   //      $sql = "
   //      	SELECT
			// 	DISTINCT(T_TK.KD_CUSTOMER) AS KD_CUSTOMER,
			// 	HRR.ID_SALES,
			// 	HRR.USER_SALES
			// FROM
			// 	(
			// 	SELECT
			// 		DISTINCT(ID_SALES) AS ID_SALES,
			// 		NAMA_SALES AS NM_SALES,
			// 		USER_SALES
			// 	FROM
			// 		HIRARCKY_GSM_SALES_DISTRIK
			// 	WHERE
			// 		NAMA_SALES IS NOT NULL
			// 		AND USER_SALES IS NOT NULL
			// 		$param_user
			// 		$param_filter
			// ) HRR
			// LEFT JOIN (
			// 	SELECT
			// 		ID_SALES,
			// 		KD_CUSTOMER
			// 	FROM
			// 		T_TOKO_SALES_TSO ) T_TK ON
			// 	HRR.ID_SALES = T_TK.ID_SALES
   //      ";

        $sql = "
        	SELECT
				T_TK.KD_CUSTOMER,
				HRR.KODE_DISTRIBUTOR,
				HRR.ID_SALES,
				HRR.USER_SALES
			FROM
				(
				SELECT
					KODE_DISTRIBUTOR,
					ID_SALES,
					NAMA_SALES AS NM_SALES,
					USER_SALES
				FROM
					HIRARCKY_GSM_SALES_DISTRIK
				WHERE
					NAMA_SALES IS NOT NULL
					AND USER_SALES IS NOT NULL
					$param_user
					$param_filter
				GROUP BY
					ID_SALES,
					KODE_DISTRIBUTOR,
					NAMA_SALES,
					USER_SALES
			) HRR
			LEFT JOIN (
				SELECT
					ID_SALES,
					KODE_DISTRIBUTOR,
					KD_CUSTOMER
				FROM
					T_TOKO_SALES_TSO
				GROUP BY
					ID_SALES,
					KODE_DISTRIBUTOR,
					KD_CUSTOMER ) T_TK ON
				TO_NUMBER(HRR.KODE_DISTRIBUTOR) = TO_NUMBER(T_TK.KODE_DISTRIBUTOR)
				AND HRR.ID_SALES = T_TK.ID_SALES
        ";

		return $this->db->query($sql)->result_array();

	}
	
	public function get_cusSIDIGI($by, $set, $tahun, $bulan, $id_user, $id_jenis_user){

		$tahunbulan = date('Ym', strtotime($tahun.'-'.$bulan));

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;


		$param_user = "";
		if ($id_jenis_user == '1012') {
			$param_user = "AND ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "AND ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "AND ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "AND ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "AND ID_GSM IN ($gm)";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGION = '$set'";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND KD_PROVINSI = '$set'";
		} elseif ($by == 'AREA') {
			$param_filter = "AND KD_AREA = '$set'";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND KD_DISTRIK = '$set'";
		} elseif ($by == 'DISTRIBUTOR') {
			$param_filter = "AND KD_DISTRIBUTOR = '$set'";
		}

        $sql = "
        	SELECT
				DISTINCT(ID_DISTRIK) AS ID_DISTRIK
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE
				ID_DISTRIK IS NOT NULL
				$param_user
			ORDER BY
				ID_DISTRIK
        ";


		// print_r('<pre>');
		// print_r($sql);exit;

        $res = $this->db->query($sql)->result_array();

    	$kd_distrik = '';
    	$distrik = '';
    	$distrik_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['ID_DISTRIK'])) {
	        		$kd_distrik .= "'" . $v['ID_DISTRIK'] . "',";

	        	}
	        }

	        $distrik = substr_replace($kd_distrik, '', -1);
	        
        	$distrik_in = "AND KD_DISTRIK IN ($distrik)";
	        
    	}

		$tgl_awal = $tahunbulan.'01';
		$tgl_akhir = date('Ymd', strtotime('-1 days'));
		$param_tgl = "";
		if ($tahunbulan == date('Ym')) {
			$param_tgl = "AND TO_CHAR(TGL_SPJ, 'YYYYMMDD') BETWEEN '$tgl_awal' AND '$tgl_akhir' ";
		}

		// print_r('<pre>');
		// print_r($param_tgl);exit;

		// $sql_fix = "
		// 	SELECT
		// 		KD_CUSTOMER,
		// 		SUM(QTY_SELL_OUT) AS QTY_SELL_OUT
		// 	FROM
		// 		V_SELL_OUT_TO_CRM
		// 	WHERE
		// 		KD_CUSTOMER IS NOT NULL
		// 		$param_filter
		// 		$distrik_in
		// 		AND TO_CHAR(TGL_SPJ, 'YYYYMM') = '$tahunbulan'
		// 		$param_tgl
		// 	GROUP BY
		// 		KD_CUSTOMER
		// "; 

		$sql_fix = "
			SELECT
				KD_CUSTOMER,
				KD_DISTRIBUTOR,
				SUM(QTY_SELL_OUT) AS QTY_SELL_OUT
			FROM
				V_SELL_OUT_TO_CRM
			WHERE
				KD_CUSTOMER IS NOT NULL
				$param_filter
				$distrik_in
				AND TO_CHAR(TGL_SPJ, 'YYYYMM') = '$tahunbulan'
				$param_tgl
			GROUP BY
				KD_CUSTOMER,
				KD_DISTRIBUTOR
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		return $this->db2->query($sql_fix)->result_array();

	}
	
	public function get_cusBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, $jenis){

		$tahunbulan = date("Ym", strtotime($tahun."-".$bulan));
        $tahunbulanmin1  = date("Ym", strtotime("$tahunbulan -1 months"));
        $tahunbulanmin2  = date("Ym", strtotime("$tahunbulan -2 months"));

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;


		$param_user = "";
		if ($id_jenis_user == '1012') {
			$param_user = "AND ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "AND ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "AND ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "AND ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "AND ID_GSM IN ($gm)";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGIONAL = '$set'";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND KD_PROVINSI = '$set'";
		} elseif ($by == 'AREA') {
			$param_filter = "AND ID_AREA = '$set'";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND KD_DISTRIK = '$set'";
		} elseif ($by == 'DISTRIBUTOR') {
			$param_filter = "AND KD_DISTRIBUTOR = '$set'";
		}

        $sql = "
        	SELECT
				DISTINCT(ID_DISTRIK) AS ID_DISTRIK
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE
				ID_DISTRIK IS NOT NULL
				$param_user
			ORDER BY
				ID_DISTRIK
        ";

        $res = $this->db->query($sql)->result_array();

    	$kd_distrik = '';
    	$distrik = '';
    	$distrik_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['ID_DISTRIK'])) {
	        		$kd_distrik .= "'" . $v['ID_DISTRIK'] . "',";

	        	}
	        }

	        $distrik = substr_replace($kd_distrik, '', -1);
	        
        	$distrik_in = "AND KD_DISTRIK IN ($distrik)";
	        
    	}

		// print_r('<pre>');
		// print_r($tahunbulanmin1.' AND '.$tahunbulanmin3);exit;

		$param_bulan = "TAHUN || LPAD(BULAN,2,'0') = '$tahunbulan'";
		if ($jenis == 'tu') {
			$param_bulan = "TAHUN || LPAD(BULAN,2,'0') BETWEEN '$tahunbulanmin2' AND '$tahunbulan'";
		}

		// $sql_fix = "
		// 	SELECT
		// 		KD_CUSTOMER,
		// 		SUM(NVL(JML_POIN, 0)) + SUM(NVL(JML_POIN_SP, 0)) + SUM(NVL(JML_POIN_SBI, 0)) AS POIN_SELL_OUT
		// 	FROM
		// 		POIN_PENJUALAN
		// 	WHERE
		// 		$param_bulan
		// 		$distrik_in
		// 		$param_filter
		// 	GROUP BY
		// 		KD_CUSTOMER
		// "; 

		$sql_fix = "
			SELECT
				KD_CUSTOMER,
				KD_DISTRIBUTOR,
				SUM(NVL(JML_POIN, 0)) + SUM(NVL(JML_POIN_SP, 0)) + SUM(NVL(JML_POIN_SBI, 0)) AS POIN_SELL_OUT
			FROM
				POIN_PENJUALAN
			WHERE
				$param_bulan
				$distrik_in
				$param_filter
			GROUP BY
				KD_CUSTOMER,
				KD_DISTRIBUTOR
		"; 

		return $this->db4->query($sql_fix)->result_array();

	}
	
	public function get_TBBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user){

		$tahunbulan = date("Ym", strtotime($tahun."-".$bulan));

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;


		$param_user = "";
		if ($id_jenis_user == '1012') {
			$param_user = "AND ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "AND ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "AND ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "AND ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "AND ID_GSM IN ($gm)";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGIONAL = '$set'";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND KD_PROVINSI = '$set'";
		} elseif ($by == 'AREA') {
			$param_filter = "AND ID_AREA = '$set'";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND KD_DISTRIK = '$set'";
		} elseif ($by == 'DISTRIBUTOR') {
			$param_filter = "AND KD_DISTRIBUTOR = '$set'";
		}

        $sql = "
        	SELECT
				DISTINCT(ID_DISTRIK) AS ID_DISTRIK
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE
				ID_DISTRIK IS NOT NULL
				$param_user
			ORDER BY
				ID_DISTRIK
        ";

        $res = $this->db->query($sql)->result_array();

    	$kd_distrik = '';
    	$distrik = '';
    	$distrik_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['ID_DISTRIK'])) {
	        		$kd_distrik .= "'" . $v['ID_DISTRIK'] . "',";

	        	}
	        }

	        $distrik = substr_replace($kd_distrik, '', -1);
	        
        	$distrik_in = "KD_DISTRIK IN ($distrik)";
	        
    	}

		// print_r('<pre>');
		// print_r($tahunbulanmin1.' AND '.$tahunbulanmin3);exit;
 
		// $sql_fix = "
		// 	SELECT
		// 		A.KD_CUSTOMER,
		// 		NVL(JML, 0) AS JML
		// 	FROM
		// 		(
		// 		SELECT
		// 			DISTINCT(KD_CUSTOMER) AS KD_CUSTOMER
		// 		FROM
		// 			POIN_PENJUALAN
		// 		WHERE
		// 			$distrik_in
		// 			$param_filter ) A
		// 	LEFT JOIN (
		// 		SELECT
		// 			KD_CUSTOMER,
		// 			COUNT(*) AS JML
		// 		FROM
		// 			(
		// 			SELECT
		// 				KD_CUSTOMER,
		// 				MIN(TAHUN || LPAD(BULAN, 2, '0')) AS MIN_DATE
		// 			FROM
		// 				POIN_PENJUALAN
		// 			WHERE
		// 				$distrik_in
		// 				$param_filter
		// 			GROUP BY
		// 				KD_CUSTOMER )
		// 		WHERE
		// 			MIN_DATE = '$tahunbulan'
		// 		GROUP BY
		// 			KD_CUSTOMER ) B ON
		// 		A.KD_CUSTOMER = B.KD_CUSTOMER
		// "; 
 
		$sql_fix = "
			SELECT
				A.KD_CUSTOMER,
				A.KD_DISTRIBUTOR,
				NVL(JML, 0) AS JML
			FROM
				(
				SELECT
					DISTINCT(KD_CUSTOMER) AS KD_CUSTOMER,
					KD_DISTRIBUTOR
				FROM
					POIN_PENJUALAN
				WHERE
					$distrik_in
					$param_filter ) A
			LEFT JOIN (
				SELECT
					KD_CUSTOMER,
					KD_DISTRIBUTOR,
					COUNT(*) AS JML
				FROM
					(
					SELECT
						KD_CUSTOMER,
						KD_DISTRIBUTOR,
						MIN(TAHUN || LPAD(BULAN, 2, '0')) AS MIN_DATE
					FROM
						POIN_PENJUALAN
					WHERE
						$distrik_in
						$param_filter
					GROUP BY
						KD_CUSTOMER,
						KD_DISTRIBUTOR )
				WHERE
					MIN_DATE = '$tahunbulan'
				GROUP BY
					KD_CUSTOMER,
					KD_DISTRIBUTOR ) B ON
				TO_NUMBER(A.KD_DISTRIBUTOR) = TO_NUMBER(B.KD_DISTRIBUTOR)
				AND A.KD_CUSTOMER = B.KD_CUSTOMER
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		return $this->db4->query($sql_fix)->result_array();

	}
	
	public function get_user_sales($id_jenis_user){ // tak dipakai lagi
		$sqlCekAtas = "";
		if($id_jenis_user == 1010){
			$sqlCekAtas = ",(SELECT ID_GSM FROM SO_TOPDOWN_RSM WHERE ID_RSM = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		} else if ($id_jenis_user == 1011){
			$sqlCekAtas = ",(SELECT ID_RSM FROM SO_TOPDOWN_ASM WHERE ID_ASM = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		} else if ($id_jenis_user == 1012){
			$sqlCekAtas = ",(SELECT ID_ASM FROM SO_TOPDOWN_TSO WHERE ID_TSO = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		} else if ($id_jenis_user == 1015){
			$sqlCekAtas = ",(SELECT ID_TSO FROM SO_TOPDOWN_SALES WHERE ID_USER = CU.ID_USER AND ROWNUM = 1) AS ID_ATASAN_ON";
		}
		
		$sql = "
			SELECT  
				CU.ID_USER, CU.NAMA, CU.USERNAME, CU.PASSWORD, CU.ID_JENIS_USER, CU.EMAIL, CMHU.ID_ATASAN_LANGSUNG, 
				(SELECT NAMA FROM CRMNEW_USER WHERE ID_USER = CMHU.ID_ATASAN_LANGSUNG) AS ATASAN, CMHU.CAKUPAN_WILAYAH
				$sqlCekAtas
			FROM CRMNEW_USER CU
			LEFT JOIN CRMNEW_MAPPING_HIERARKI_USER CMHU
				ON CU.ID_USER = CMHU.USER_ID AND CMHU.DELETE_MARK IS NULL
			WHERE (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK != 1) OR (CU.ID_JENIS_USER = '$id_jenis_user' AND CU.DELETED_MARK IS NULL)
			ORDER BY CU.NAMA ASC
		";
		return $this->db->query($sql)->result();
	}
	
	public function get_user($id_user){
		$sql = "
			SELECT CU.ID_USER, CU.NAMA, CU.USERNAME, CU.PASSWORD, CU.EMAIL, CU.ID_JENIS_USER, 
				(SELECT JENIS_USER FROM CRMNEW_JENIS_USER WHERE ID_JENIS_USER = CU.ID_JENIS_USER) AS JENIS_USER
			FROM CRMNEW_USER CU 
			WHERE CU.ID_USER = '$id_user'
		";
		return $this->db->query($sql)->result_array();
	}
	
	// ----------------------------------------------------------------------------- >>> TERBARU 13/02/2020
	
	public function get_user_ssm_Unmap(){
		$sql = "
			SELECT ID_RSM as ID_USER, NAMA_RSM as NAMA FROM SO_TOPDOWN_RSM
			WHERE ID_GSM IS NULL
			ORDER BY NAMA_RSM
		";
		return $this->db->query($sql)->result();
	}
	
	public function get_user_sm_Unmap(){
		$sql = "
			SELECT ID_ASM as ID_USER, NAMA_ASM as NAMA FROM SO_TOPDOWN_ASM
			WHERE ID_RSM IS NULL
			ORDER BY NAMA_ASM
		";
		return $this->db->query($sql)->result();
	}
	
	public function get_user_so_Unmap(){
		$sql = "
			SELECT ID_TSO as ID_USER, NAMA_TSO as NAMA FROM SO_TOPDOWN_TSO
			WHERE ID_ASM IS NULL
			ORDER BY NAMA_TSO
		";
		return $this->db->query($sql)->result();
	}
	
	public function get_user_sd_Unmap(){
		$sql = "
			SELECT ID_USER, NAMA FROM SO_TOPDOWN_SALES
			WHERE ID_TSO IS NULL
			ORDER BY NAMA
		";
		return $this->db->query($sql)->result();
	}
	
	/*
	public function get_region(){
		$sql = "
			SELECT kode,label FROM CRMNEW_CAKUPAN_WILAYAH WHERE LENGTH(kode)=2 ORDER BY label
		";
		return $this->db->query($sql)->result();
	}
	
	public function set_Wilayah_GSM($id_gsm, $wilayah){
		$sqlCek = "
			SELECT * FROM CRMNEW_MAPPING_HIERARKI_USER
			WHERE USER_ID = '$id_gsm'
		";
		$hasil_cek = $this->db->query($sqlCek)->result_array();
		$hasil = false;
		if(count($hasil_cek) == 1){
			$sqlUp = "
				UPDATE CRMNEW_MAPPING_HIERARKI_USER
				SET 
					CAKUPAN_WILAYAH = '$wilayah',
					UPDATE_BY = '1000',
					UPDATE_AT = SYSDATE
				WHERE USER_ID = '$id_gsm'
			";
			$this->db->query($sqlUp);
			$hasil = true;
		} else {
			$sqlIn = "
				INSERT INTO CRMNEW_MAPPING_HIERARKI_USER (USER_ID, CAKUPAN_WILAYAH, CREATE_BY, CREATE_AT)
				VALUES 
				('$id_gsm', '$wilayah', '1000', SYSDATE)
			";
			$this->db->query($sqlIn);
			$hasil = true;
		}
		return $hasil;
	}
	
	public function set_Atasan($id_user, $atasan){
		$sqlCek = "
			SELECT * FROM CRMNEW_MAPPING_HIERARKI_USER
			WHERE USER_ID = '$id_user'
		";
		$hasil_cek = $this->db->query($sqlCek)->result_array();
		$hasil = false;
		if(count($hasil_cek) == 1){
			$sqlUp = "
				UPDATE CRMNEW_MAPPING_HIERARKI_USER
				SET 
					ID_ATASAN_LANGSUNG = '$atasan',
					UPDATE_BY = '1000',
					UPDATE_AT = SYSDATE
				WHERE USER_ID = '$id_user'
			";
			$this->db->query($sqlUp);
			$hasil = true;
		} else {
			$sqlIn = "
				INSERT INTO CRMNEW_MAPPING_HIERARKI_USER (USER_ID, ID_ATASAN_LANGSUNG, CREATE_BY, CREATE_AT)
				VALUES 
				('$id_user', '$atasan', '1000', SYSDATE)
			";
			$this->db->query($sqlIn);
			$hasil = true;
		}
		return $hasil;
	}
	*/
	
	public function get_jenis_user(){
		$sql = "
			SELECT * FROM CRMNEW_JENIS_USER 
			WHERE CREATED_BY IS NOT NULL
			ORDER BY CREATED_BY DESC
		";
		return $this->db->query($sql)->result();
	}
	
	public function getJenisUser($id_j_u){
        $this->db->from("CRMNEW_JENIS_USER");
        $this->db->where("ID_JENIS_USER", $id_j_u);
        $query = $this->db->get();
		return $query->row();
    }
	
	public function add_user_batch($nama, $username, $password, $id_jenis_user){
		$date = date('d-m-Y H:i:s');
        	$this->db->set('CREATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
			$this->db->set('CREATED_BY', '1009');
			$this->db->set('DELETED_MARK', 0);
			$this->db->set('NAMA', $nama);
            $this->db->set('USERNAME', $username);
            $this->db->set('PASSWORD', $password);
			$this->db->set('ID_JENIS_USER', $id_jenis_user);
			$this->db->set('FLAG', 'SBI');
        $this->db->insert("CRMNEW_USER");
	}
	
	//--------------------------------------------------------------------------------------------
	// TERKAIT USER MAPPING // 
	//-------------------------------------------------------------------------------------------- HIERAKI USER / tidak dipakai lagi
	
		public function list_gsm_user($id_user){
			$sql = "
				SELECT 
					CUG.ID_GSM AS ID, CU.NAMA
				FROM CRMNEW_USER_GSM CUG
				LEFT JOIN CRMNEW_USER CU 
					ON CUG.ID_GSM = CU.ID_USER
				WHERE CUG.ID_USER = '$id_user' AND CUG.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_ssm_user($id_user){
			$sql = "
				SELECT 
					CUR.ID_RSM AS ID, CU.NAMA
				FROM CRMNEW_USER_RSM CUR
				LEFT JOIN CRMNEW_USER CU 
					ON CUR.ID_RSM = CU.ID_USER
				WHERE CUR.ID_USER = '$id_user' AND CUR.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_sm_user($id_user){
			$sql = "
				SELECT 
					CUA.ID_ASM AS ID, CU.NAMA
				FROM CRMNEW_USER_ASM CUA
				LEFT JOIN CRMNEW_USER CU 
					ON CUA.ID_ASM = CU.ID_USER
				WHERE CUA.ID_USER = '$id_user' AND CUA.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_so_user($id_user){
			$sql = "
				SELECT 
					CUT.ID_TSO AS ID, CU.NAMA
				FROM CRMNEW_USER_TSO CUT
				LEFT JOIN CRMNEW_USER CU 
					ON CUT.ID_TSO = CU.ID_USER
				WHERE CUT.ID_USER = '$id_user' AND CUT.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_sd_user($id_user){
			$sql = "
				SELECT 
					CUS.ID_SALES AS ID, CU.NAMA
				FROM CRMNEW_USER_SALESMAN CUS
				LEFT JOIN CRMNEW_USER CU 
					ON CUS.ID_SALES = CU.ID_USER
				WHERE CUS.ID_USER = '$id_user' AND CUS.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		// ------------------------------------------------------------------------------------ >>> NEW UNTUK FITUR HIRARKI
		
		public function list_ssm_userOfGsm($id_user){
			$sql = "
				SELECT 
					CUG.ID_USER AS ID, CU.NAMA
				FROM CRMNEW_USER_GSM CUG
				LEFT JOIN CRMNEW_USER CU 
					ON CUG.ID_USER = CU.ID_USER
				WHERE CUG.ID_GSM = '$id_user' AND CUG.DELETE_MARK = 0
				ORDER BY CU.NAMA ASC
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_sm_userOfSsm($id_user){
			$sql = "
				SELECT 
					CUR.ID_USER AS ID, CU.NAMA
				FROM CRMNEW_USER_RSM CUR
				LEFT JOIN CRMNEW_USER CU 
					ON CUR.ID_USER = CU.ID_USER
				WHERE CUR.ID_RSM = '$id_user' AND CUR.DELETE_MARK = 0
				ORDER BY CU.NAMA ASC
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_so_userOfSm($id_user){
			$sql = "
				SELECT 
					CUA.ID_USER AS ID, CU.NAMA
				FROM CRMNEW_USER_ASM CUA
				LEFT JOIN CRMNEW_USER CU 
					ON CUA.ID_USER = CU.ID_USER
				WHERE CUA.ID_ASM = '$id_user' AND CUA.DELETE_MARK = 0
				ORDER BY CU.NAMA ASC
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_sd_userOfSo($id_user){
			$sql = "
				SELECT 
					CUT.ID_USER AS ID, CU.NAMA
				FROM CRMNEW_USER_TSO CUT
				LEFT JOIN CRMNEW_USER CU 
					ON CUT.ID_USER = CU.ID_USER
				WHERE CUT.ID_TSO = '$id_user' AND CUT.DELETE_MARK = 0
				ORDER BY CU.NAMA ASC
			";
			return $this->db->query($sql)->result();
		}
		
		//------------------------------------------------------------------------------ CAKUPAN WILAYAH
		
		public function get_cakupan_wilayah($DtRequest){
			$sqlEksekusi = "";
			
			$sqlRegion = "
				SELECT DISTINCT(REGION_ID) as ID, REGION_NAME as NAMA FROM WILAYAH_SMI ORDER BY REGION_NAME
			";
			
			$sqlProvinsi = "
				SELECT DISTINCT(ID_PROVINSI) as ID, NAMA_PROVINSI as NAMA FROM WILAYAH_SMI ORDER BY NAMA_PROVINSI
			";
			
			$sqlArea = "
				SELECT DISTINCT(KD_AREA) as ID, NM_AREA as NAMA FROM WILAYAH_SMI WHERE KD_AREA IS NOT NULL ORDER BY KD_AREA
			";
			// SELECT DISTINCT(KD_KOTA) as ID, NM_KOTA as NAMA FROM WILAYAH_SMI WHERE KD_KOTA IS NOT NULL ORDER BY NM_KOTA
			$sqlDistrik = "
				SELECT DISTINCT(KD_KOTA) as ID, NM_KOTA as NAMA FROM DISTRIK_TSO WHERE ID_USER IS NULL ORDER BY NM_KOTA
			";
			
			if($DtRequest == 'region'){
				$sqlEksekusi = $sqlRegion;
			} elseif($DtRequest == 'provinsi'){
				$sqlEksekusi = $sqlProvinsi;
			} elseif($DtRequest == 'area'){
				$sqlEksekusi = $sqlArea;
			} elseif($DtRequest == 'distrik'){
				$sqlEksekusi = $sqlDistrik;
			}
			
			return $this->db->query($sqlEksekusi)->result();
		}
		
		public function list_region_user($id_user){
			$sql = "
				SELECT 
					CUR.ID_REGION AS ID, WS.REGION_NAME AS LABEL
				FROM CRMNEW_USER_REGION CUR
				LEFT JOIN (SELECT DISTINCT(REGION_ID), REGION_NAME FROM WILAYAH_SMI ORDER BY REGION_NAME) WS
					ON CUR.ID_REGION = WS.REGION_ID
				WHERE CUR.ID_USER = '$id_user' AND CUR.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_provinsi_user($id_user){
			$sql = "
				SELECT 
					CUR.ID_PROVINSI AS ID, WS.NAMA_PROVINSI AS LABEL
				FROM CRMNEW_USER_PROVINSI CUR
                LEFT JOIN (SELECT DISTINCT(ID_PROVINSI), NAMA_PROVINSI FROM WILAYAH_SMI ORDER BY NAMA_PROVINSI) WS
					ON CUR.ID_PROVINSI = WS.ID_PROVINSI
				WHERE CUR.ID_USER = '$id_user' AND CUR.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_area_user($id_user){
			$sql = "
				SELECT 
					CUR.KD_AREA AS ID, WS.NM_AREA AS LABEL
				FROM CRMNEW_USER_AREA1 CUR
                LEFT JOIN (SELECT DISTINCT(KD_AREA), NM_AREA FROM WILAYAH_SMI WHERE KD_AREA IS NOT NULL ORDER BY KD_AREA) WS
					ON CUR.KD_AREA = WS.KD_AREA
				WHERE CUR.ID_USER = '$id_user' AND CUR.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
			//olde=: tabel AREA
		}
		
		public function list_distrik_user($id_user){
			$sql = "
				SELECT 
					CUR.ID_DISTRIK AS ID, WS.NM_KOTA AS LABEL
				FROM CRMNEW_USER_DISTRIK CUR
                LEFT JOIN (SELECT DISTINCT(KD_KOTA), NM_KOTA FROM WILAYAH_SMI WHERE KD_KOTA IS NOT NULL ORDER BY NM_KOTA) WS
					ON CUR.ID_DISTRIK = WS.KD_KOTA
				WHERE CUR.ID_USER = '$id_user' AND CUR.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		//------------------------------------------------------------------------------ DISTRIBUTOR DAN GUDANG
		
		public function get_distributor_gudang($DtRequest){
			$sqlEksekusi = "";
			
			$sqlDistributor = "
				SELECT DISTINCT(KODE_DISTRIBUTOR) as KD, NAMA_DISTRIBUTOR as NAMA, ORG FROM CRMNEW_DISTRIBUTOR 
				WHERE DELETE_MARK = 0
				ORDER BY ORG ASC, NAMA_DISTRIBUTOR ASC 
			";
			
			$sqlGudang = "
				SELECT DISTINCT(KD_GUDANG) as KD, NAMA_GUDANG as NAMA FROM CRMNEW_MASTER_GUDANG 
				ORDER BY NAMA_GUDANG ASC 
			";
			
			if($DtRequest == 'distributor'){
				$sqlEksekusi = $sqlDistributor;
			} elseif($DtRequest == 'gudang'){
				$sqlEksekusi = $sqlGudang;
			}
			
			return $this->db->query($sqlEksekusi)->result();
		}
		
		public function list_distributor_user($id_user){
			$sql = "
				SELECT 
					CUD.KODE_DISTRIBUTOR AS KODE, CD.NAMA_DISTRIBUTOR AS NAMA
				FROM CRMNEW_USER_DISTRIBUTOR CUD
				LEFT JOIN CRMNEW_DISTRIBUTOR CD 
					ON CUD.KODE_DISTRIBUTOR = CD.KODE_DISTRIBUTOR
				WHERE CUD.ID_USER = '$id_user' AND CUD.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		public function list_gudang_user($id_user){
			$sql = "
				SELECT 
					CUD.KD_GUDANG AS KODE, CD.NAMA_GUDANG AS NAMA
				FROM CRMNEW_USER_GUDANG1 CUD
				LEFT JOIN CRMNEW_MASTER_GUDANG CD 
					ON CUD.KD_GUDANG = CD.KD_GUDANG
				WHERE CUD.ID_USER = '$id_user' AND CUD.DELETE_MARK = 0
			";
			return $this->db->query($sql)->result();
		}
		
		// ------------------------------------------------------------------------------------> Set IN OR DEL Mapping Hierarki // TIDAK DIPAKAI
		
			public function set_gsm_user($actIn_or_Del, $id_user, $valueIn){
				
			}
			
			public function set_ssm_user($actIn_or_Del, $id_user, $valueIn){ //RSM
				$sqlIn = "
						INSERT INTO CRMNEW_USER_RSM (ID_USER, ID_RSM, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_RSM SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_RSM = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_RSM WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_RSM = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_sm_user($actIn_or_Del, $id_user, $valueIn){ //ASM
				$sqlIn = "
						INSERT INTO CRMNEW_USER_ASM (ID_USER, ID_ASM, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_ASM SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_ASM = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_ASM WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_ASM = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_so_user($actIn_or_Del, $id_user, $valueIn){ //TSO
				$sqlIn = "
						INSERT INTO CRMNEW_USER_TSO (ID_USER, ID_TSO, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_TSO SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_TSO = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_TSO WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_TSO = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_sd_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_SALESMAN (ID_USER, ID_SALES, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_SALESMAN SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_SALES = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_SALESMAN WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_SALES = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
		
		// ------------------------------------------------------------------------------------>> Set IN OR DEL Mapping Hierarki
		
			public function set_ssm_userGsm($actIn_or_Del, $id_user, $valueIn){ //RSM
				$sqlIn = "
						INSERT INTO CRMNEW_USER_GSM (ID_USER, ID_GSM, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$valueIn', '$id_user', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_GSM SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$valueIn' AND ID_GSM = '$id_user'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_GSM WHERE DELETE_MARK = 0 AND
						ID_USER = '$valueIn' AND ID_GSM = '$id_user' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_sm_userSsm($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_RSM (ID_USER, ID_RSM, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$valueIn', '$id_user', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_RSM SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$valueIn' AND ID_RSM = '$id_user'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_RSM WHERE DELETE_MARK = 0 AND
						ID_USER = '$valueIn' AND ID_RSM = '$id_user' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_so_userSm($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_ASM (ID_USER, ID_ASM, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$valueIn', '$id_user', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_ASM SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$valueIn' AND ID_ASM = '$id_user'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_ASM WHERE DELETE_MARK = 0 AND
						ID_USER = '$valueIn' AND ID_ASM = '$id_user' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_sd_userSo($actIn_or_Del, $id_user, $valueIn){ // TSO
				$sqlIn = "
						INSERT INTO CRMNEW_USER_TSO (ID_USER, ID_TSO, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$valueIn', '$id_user', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_TSO SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$valueIn' AND ID_TSO = '$id_user'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_TSO WHERE DELETE_MARK = 0 AND
						ID_USER = '$valueIn' AND ID_TSO = '$id_user' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
		
		// ------------------------------------------------------------------------------------> Set IN OR DEL Mapping Wilayah
		
			public function set_region_user($actIn_or_Del, $id_user, $valueIn){
				
				$sqlIn = "
						INSERT INTO CRMNEW_USER_REGION (ID_USER, ID_REGION, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
					
				$sqlDel = "
					UPDATE CRMNEW_USER_REGION SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_REGION = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_REGION WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_REGION = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_provinsi_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_PROVINSI (ID_USER, ID_PROVINSI, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
				$sqlDel = "
					UPDATE CRMNEW_USER_PROVINSI SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_PROVINSI = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_PROVINSI WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_PROVINSI = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_area_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_AREA1 (ID_USER, KD_AREA, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
				$sqlDel = "
					UPDATE CRMNEW_USER_AREA1 SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND KD_AREA = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_AREA1 WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND KD_AREA = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
			public function set_distrik_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_DISTRIK (ID_USER, ID_DISTRIK, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
				$sqlDel = "
					UPDATE CRMNEW_USER_DISTRIK SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND ID_DISTRIK = '$valueIn'
				";
				
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_DISTRIK WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND ID_DISTRIK = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
		// ------------------------------------------------------------------------------------> Set IN OR DEL Mapping DISTRIBUTOR dan GUDANG
			
			public function set_distributor_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_DISTRIBUTOR (ID_USER, KODE_DISTRIBUTOR, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
				$sqlDel = "
					UPDATE CRMNEW_USER_DISTRIBUTOR SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND KODE_DISTRIBUTOR = '$valueIn'
				";
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND KODE_DISTRIBUTOR = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
				
			}
			
			public function set_gudang_user($actIn_or_Del, $id_user, $valueIn){
				$sqlIn = "
						INSERT INTO CRMNEW_USER_GUDANG1 (ID_USER, KD_GUDANG, CREATE_BY, CREATE_DATE, DELETE_MARK)
						VALUES 
						('$id_user', '$valueIn', '$id_user',  SYSDATE, 0)
					";
				$sqlDel = "
					UPDATE CRMNEW_USER_GUDANG1 SET 
						DELETE_MARK = 1,
						UPDATE_DATE = SYSDATE,
						UPDATE_BY = '$id_user'
					WHERE
						ID_USER = '$id_user' AND KD_GUDANG = '$valueIn'
				";
				$sqlEksekusi = "";
				if ($actIn_or_Del == 'in'){
					$sqlCek = "
						SELECT * FROM CRMNEW_USER_GUDANG1 WHERE DELETE_MARK = 0 AND
						ID_USER = '$id_user' AND KD_GUDANG = '$valueIn' 
					";					
					$hasilCek = $this->db->query($sqlCek)->result();;
					
					if(count($hasilCek) > 0){
						return "ready";
						exit();
					} else {
						$sqlEksekusi = $sqlIn;
					}
					
				} elseif($actIn_or_Del == 'del') {
					$sqlEksekusi = $sqlDel;
				}
				
				$this->db->trans_start();
				$this->db->query($sqlEksekusi);
				$this->db->trans_complete();

				   if ($this->db->trans_status() === FALSE) {
					   return "failed";
				   } else {
					   return "success";
				   }
			}
			
	// ----------------------------------- Pencocokan mapping hierarkki
	
	public function get_gsm_hierarki($datas_id){
		$sql = "
			SELECT ID_RSM AS ID, NAMA_RSM AS NAMA FROM SO_TOPDOWN_RSM 
			WHERE ID_GSM IN ($datas_id)
		";
		$this->db->query($sql)->result_array();;
	}

	//----------------------------------------------------------------------------------------------------------------------------
	
	public function valCoverage()
	{
		$bln = date("m");
		$thn = date("yy");
		$bln_beg = date("m", strtotime("-3 months"));
			$q = $this->db4->query("		 
				SELECT COUNT(DISTINCT KD_CUSTOMER) AS JUMLAH FROM POIN_PENJUALAN WHERE BULAN > {$bln_beg} AND BULAN <= {$bln}  AND TAHUN = {$thn}
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valNOO()
	{
		$q = $this->db4->query("		 
				SELECT COUNT(*) AS JUMLAH FROM VIEW_M_CUSTOMER where TO_DATE(AKUISISI_DATE, 'dd-MM-yyyy') >= TRUNC(SYSDATE) - 30
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valSellin()
	{
		$q = $this->db3->query("		 
				SELECT SUM(KWANTUMX) AS JUMLAH FROM ZREPORT_SCM_REAL_SALES_SIDIGI
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valRevenue()
	{
		$q = $this->db3->query("		 
				SELECT SUM(HARGA) AS JUMLAH FROM ZREPORT_SCM_REAL_SALES_SIDIGI
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valSellOut()
	{
		$q = $this->db4->query("		 
				SELECT SUM(JML_POIN) AS JUMLAH FROM POIN_PENJUALAN
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valVisit()
	{
		$q = $this->db->query("		 
				SELECT SUM(REALISASI) AS JUMLAH, SUM(TARGET) AS TARGET FROM VISIT_SALES_DISTRIBUTOR
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valSOCC()
	{
		$q = $this->db3->query("		 
				SELECT SUM(SISA_TO) AS JUMLAH FROM ZREPORT_SO_CNC
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valTarget()
	{
		$q = $this->db->query("		 
				SELECT COALESCE(SUM(TOKO_UNIT), 0) AS COVERAGE, COALESCE(SUM(VOLUME), 0) AS SELL_IN, COALESCE(SUM(REVENUE), 0) AS REVENUE, COALESCE(SUM(SELL_OUT), 0) AS SELL_OUT, COALESCE(SUM(SO_CLEAN_CLEAR), 0) AS SO_CC FROM CRMNEW_TARGET_SELLING_OUT_D
			");
		return $r = $q ? $q->result_array() : array();
	}
	
	public function valTarget2()
	{
		$q = $this->db->query("		 
				SELECT COALESCE(SUM(TOKO_BARU), 0) AS NOO FROM CRMNEW_TARGET_SELLING_OUT_S
			");
		return $r = $q ? $q->result_array() : array();
	}


	//------------------------------------------------------------------------------------------------
	
	public function get_fromCRMDistr($by, $set, $tahun, $bulan, $id_user, $id_jenis_user){

		$tahunbulan = date('Ym', strtotime($tahun.'-'.$bulan));

		$distr = "
        	SELECT
				KODE_DISTRIBUTOR
			FROM
				CRMNEW_USER_DISTRIBUTOR
			WHERE
				ID_USER = '$id_user'
        ";

    	$kd_distr = $this->db->query($distr)->row_array();
    	$kdDistr = $kd_distr['KODE_DISTRIBUTOR'];

    	$am = "";

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($gm);exit;

		$param_user = "";
		$param_distr = "";
		if ($id_jenis_user == '1012') {
			$param_user = "ID_SO = '$id_user'";
			$am = "AND CREATE_BY = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "ID_GSM IN ($gm)";
		} elseif ($id_jenis_user == '1013') {
			$param_distr = "TO_NUMBER(NVL(KODE_DISTRIBUTOR, 0)) = TO_NUMBER('$kdDistr')";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGION_ID = '$set'";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND ID_PROVINSI = '$set'";
		} elseif ($by == 'AREA') {
			$param_filter = "AND KD_AREA = '$set'";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND ID_DISTRIK = '$set'";
		}

		if (empty($param_user) && empty($param_distr)) {
			$param_filter = substr($param_filter, 4);
		}

		$where = 'WHERE';
		if (empty($param_user) && empty($param_distr) && empty($param_filter)) {
			$where = '';
		}

		$sql_fix = "
			SELECT
				HRR.KD_DISTRIBUTOR,
				HRR.NM_DISTRIBUTOR,
				SUM(NVL(TRG_DISTR.TRG_TOKO_UNIT, 0)) AS TRG_TOKO_UNIT,
				SUM(NVL(TRG_DISTR.TRG_TOKO_AKTIF, 0)) AS TRG_TOKO_AKTIF,
				SUM(NVL(TRG_DISTR.TRG_SO_CLEAN_CLEAR, 0)) AS TRG_SO_CLEAN_CLEAR,
				SUM(NVL(TRG_DISTR.TRG_VOLUME, 0)) AS TRG_VOLUME,
				SUM(NVL(TRG_DISTR.TRG_REVENUE, 0)) AS TRG_REVENUE,
				SUM(NVL(TRG_DISTR.TRG_SELL_OUT, 0)) AS TRG_SELL_OUT
			FROM
				(
				SELECT
					DISTINCT(KODE_DISTRIBUTOR) AS KD_DISTRIBUTOR,
					NAMA_DISTRIBUTOR AS NM_DISTRIBUTOR
				FROM
					HIRARCKY_GSM_SALES_DISTRIK
				$where
					$param_user
					$param_distr
					$param_filter
			) HRR
			LEFT JOIN (
				SELECT
					KD_DISTRIBUTOR,
					SUM(TOKO_UNIT) AS TRG_TOKO_UNIT,
					SUM(TOKO_AKTIF) AS TRG_TOKO_AKTIF,
					SUM(SO_CLEAN_CLEAR) AS TRG_SO_CLEAN_CLEAR,
					SUM(VOLUME) AS TRG_VOLUME,
					SUM(REVENUE) AS TRG_REVENUE,
					SUM(SELL_OUT) AS TRG_SELL_OUT
				FROM
					CRMNEW_TARGET_SELLING_OUT_D
				WHERE
					TAHUN || BULAN = '$tahunbulan'
					AND DELETED_MARK = '0'
					$am
				GROUP BY
					KD_DISTRIBUTOR) TRG_DISTR ON
				TO_NUMBER(HRR.KD_DISTRIBUTOR) = TO_NUMBER(TRG_DISTR.KD_DISTRIBUTOR)
			GROUP BY
				HRR.KD_DISTRIBUTOR,
				HRR.NM_DISTRIBUTOR
			ORDER BY
				HRR.NM_DISTRIBUTOR

		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		return $this->db->query($sql_fix)->result_array();

	}
	
	public function get_fromSCMDistr($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, $getDistr_TBL){

    	$kd_distr = '';
    	$distr = '';
    	$distr_fix = '';
    	$distr_in = '';

    	if (!empty($getDistr_TBL)) {
	        foreach ($getDistr_TBL as $ke => $ve){
	        	if (!empty($ve['KODE_DISTRIBUTOR'])) {
	        		$kd_distr .= "OR A.SOLD_TO = '" . $ve['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr = substr_replace($kd_distr, '', -1);
	        $distr_fix = "AND (".substr_replace($distr, '', 0, 3).")";
	        
    	}

		// print_r('<pre>');
		// print_r($getDistr_TBL);exit;

		$tahunbulan = date('Ym', strtotime($tahun.'-'.$bulan));

		$distr = "
        	SELECT
				KODE_DISTRIBUTOR
			FROM
				CRMNEW_USER_DISTRIBUTOR
			WHERE
				ID_USER = '$id_user'
        ";

    	$kd_distr = $this->db->query($distr)->row_array();
    	$kdDistr = $kd_distr['KODE_DISTRIBUTOR'];

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;

		$param_user = "";
		$param_distr = "";
		if ($id_jenis_user == '1012') {
			$param_user = "AND ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "AND ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "AND ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "AND ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "AND ID_GSM IN ($gm)";
		} elseif ($id_jenis_user == '1013') {
			$param_distr = "AND TO_NUMBER(A.SOLD_TO) = TO_NUMBER('$kdDistr')";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND B.ID_SCM_SALESREG2 IN ('$set')";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND B.KD_PROV IN ('$set')";
		} elseif ($by == 'AREA') {
			$param_filter = "AND B.KD_AREA IN ('$set')";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND B.KD_KOTA IN ('$set')";
		}

        $sql = "
        	SELECT
				DISTINCT(ID_DISTRIK) AS ID_DISTRIK
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE
				ID_DISTRIK IS NOT NULL
				$param_user
			ORDER BY
				ID_DISTRIK
        ";

		// print_r('<pre>');
		// print_r($sql);exit;

        $res = $this->db->query($sql)->result_array();

    	$kd_distrik = '';
    	$distrik = '';
    	$distrik_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['ID_DISTRIK'])) {
	        		$kd_distrik .= "'" . $v['ID_DISTRIK'] . "',";

	        	}
	        }

	        $distrik = substr_replace($kd_distrik, '', -1);
	        if ($id_jenis_user != '1013') {
	        	$distrik_in = "AND B.KD_KOTA IN ($distrik)";
	        }
	        
    	}

		$tgl_awal = $tahunbulan.'01';
		$tgl_akhir = date('Ymd', strtotime('-1 days'));
		$param_tgl = "";

		if ($tahunbulan == date('Ym')) {
			$param_tgl = "AND TAHUN || BULAN || HARI BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		}

		// print_r('<pre>');
		// print_r($param_tgl);exit;

		$sql_fix = "
			SELECT
				AA.KD_DISTRIBUTOR,
				NVL(BB.ACT_VOLUME,0) AS ACT_VOLUME,
				NVL(BB.HARGA,0) AS HARGA,
				NVL(BB.ACT_REVENUE,0) AS ACT_REVENUE
			FROM
				(
				SELECT
					DISTINCT(A.SOLD_TO) AS KD_DISTRIBUTOR
				FROM ZREPORT_SCM_REAL_SALES_SIDIGI A
				WHERE
					A.SOLD_TO IS NOT NULL
					$distr_fix
					$param_distr
					) AA
			LEFT JOIN (
				SELECT
					A.SOLD_TO AS KD_DISTRIBUTOR,
					NVL(SUM(KWANTUMX), 0) AS  ACT_VOLUME,
					NVL(SUM(HARGA), 0) AS  HARGA,
					SUM(NVL(HARGA, 0) / 1000000) AS ACT_REVENUE
				FROM
					ZREPORT_SCM_REAL_SALES_SIDIGI A
				LEFT JOIN (
					SELECT
						PR.KD_PROV,
						PR.ID_SCM_SALESREG2,
						DS.KD_AREA,
						DS.KD_KOTA
					FROM
						ZREPORT_M_KOTA DS
					FULL OUTER JOIN ZREPORT_M_PROVINSI PR ON
						DS.KD_PROP = PR.KD_PROV
					WHERE
						PR.KD_PROV NOT IN ('0001',
						'1092')) B ON
					A.PROPINSI_TO = B.KD_PROV
					AND A.KOTA = B.KD_KOTA
				LEFT JOIN MASTER_DISTRIBUTOR C ON
					TO_NUMBER(A.SOLD_TO) = TO_NUMBER(C.KD_DISTR)
				WHERE
					TAHUN || BULAN = '$tahunbulan'
					$distr_fix
					$param_tgl
					$param_distr
					$param_filter
					$distrik_in
				GROUP BY
					A.SOLD_TO ) BB ON
			AA.KD_DISTRIBUTOR = BB.KD_DISTRIBUTOR
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		return $this->db3->query($sql_fix)->result_array();

	}
	
	public function get_distrBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, $jenis, $getDistr_TBL){

    	$kd_distr = '';
    	$distr = '';
    	$distr_fix = '';
    	$distr_in = '';

    	if (!empty($getDistr_TBL)) {
	        foreach ($getDistr_TBL as $ke => $ve){
	        	if (!empty($ve['KODE_DISTRIBUTOR'])) {
	        		$kd_distr .= "OR KD_DISTRIBUTOR = '" . $ve['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr = substr_replace($kd_distr, '', -1);
	        $distr_fix = "AND (".substr_replace($distr, '', 0, 3).")";
	        
    	}

		$tahunbulan = date('Ym', strtotime($tahun.'-'.$bulan));
        $tahunbulanmin1  = date("Ym", strtotime("$tahunbulan -1 months"));
        $tahunbulanmin2  = date("Ym", strtotime("$tahunbulan -2 months"));

		$distr = "
        	SELECT
				KODE_DISTRIBUTOR
			FROM
				CRMNEW_USER_DISTRIBUTOR
			WHERE
				ID_USER = '$id_user'
        ";

    	$kd_distr = $this->db->query($distr)->row_array();
    	$kdDistr = $kd_distr['KODE_DISTRIBUTOR'];

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;

		$param_user = "";
		$param_distr = "";
		if ($id_jenis_user == '1012') {
			$param_user = "AND ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "AND ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "AND ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "AND ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "AND ID_GSM IN ($gm)";
		} elseif ($id_jenis_user == '1013') {
			$param_distr = "AND TO_NUMBER(KD_DISTRIBUTOR) = TO_NUMBER('$kdDistr')";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGIONAL IN ('$set')";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND KD_PROVINSI IN ('$set')";
		} elseif ($by == 'AREA') {
			$param_filter = "AND ID_AREA IN ('$set')";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND KD_DISTRIK IN ('$set')";
		}

        $sql = "
        	SELECT
				DISTINCT(ID_DISTRIK) AS ID_DISTRIK
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE
				ID_DISTRIK IS NOT NULL
				$param_user
			ORDER BY
				ID_DISTRIK
        ";

		// print_r('<pre>');
		// print_r($sql);exit;

        $res = $this->db->query($sql)->result_array();

    	$kd_distrik = '';
    	$distrik = '';
    	$distrik_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['ID_DISTRIK'])) {
	        		$kd_distrik .= "'" . $v['ID_DISTRIK'] . "',";

	        	}
	        }

	        $distrik = substr_replace($kd_distrik, '', -1);
	        if ($id_jenis_user != '1013') {
	        	$distrik_in = "AND KD_DISTRIK IN ($distrik)";
	        }
	        
    	}

		// print_r('<pre>');
		// print_r($id_user.'/'.$id_jenis_user);exit;

		$param_bulan = "TAHUN || LPAD(BULAN,2,'0') = '$tahunbulan'";
		if ($jenis == 'tu') {
			$param_bulan = "TAHUN || LPAD(BULAN,2,'0') BETWEEN '$tahunbulanmin2' AND '$tahunbulan'";
		}

		$sql_fix = "
			SELECT
				AA.KD_DISTRIBUTOR,
				NVL(BB.SELL_OUT,0) AS SELL_OUT,
				NVL(BB.TA_DISTR,0) AS TA_DISTR
			FROM
				(
				SELECT
					DISTINCT(KD_DISTRIBUTOR) AS KD_DISTRIBUTOR
				FROM
					POIN_PENJUALAN
				WHERE
					KD_DISTRIBUTOR IS NOT NULL
					$distr_fix
					$param_distr
						
					) AA
			LEFT JOIN (
				SELECT
					KD_DISTRIBUTOR,
					SUM(SELL_OUT) AS SELL_OUT,
					COUNT(KD_CUSTOMER) TA_DISTR
				FROM
					(
					SELECT
						KD_DISTRIBUTOR,
						KD_CUSTOMER,
						SUM(NVL(JML_POIN, 0)) + SUM(NVL(JML_POIN_SP, 0)) + SUM(NVL(JML_POIN_SBI, 0)) AS SELL_OUT
					FROM
						POIN_PENJUALAN
					WHERE
						$param_bulan
						$distr_fix
						$param_distr
						$param_filter
						$distrik_in
					GROUP BY
						KD_DISTRIBUTOR,
						KD_CUSTOMER )
				GROUP BY
					KD_DISTRIBUTOR ) BB ON
			AA.KD_DISTRIBUTOR = BB.KD_DISTRIBUTOR
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		return $this->db4->query($sql_fix)->result_array();

	}
	
	public function get_distrTBBK($by, $set, $tahun, $bulan, $id_user, $id_jenis_user, $jenis, $getDistr_TBL){

    	$kd_distr = '';
    	$distr = '';
    	$distr_fix = '';
    	$distr_in = '';

    	if (!empty($getDistr_TBL)) {
	        foreach ($getDistr_TBL as $ke => $ve){
	        	if (!empty($ve['KODE_DISTRIBUTOR'])) {
	        		$kd_distr .= "OR KD_DISTRIBUTOR = '" . $ve['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr = substr_replace($kd_distr, '', -1);
	        $distr_fix = "AND (".substr_replace($distr, '', 0, 3).")";
	        
    	}

		$tahunbulan = date('Ym', strtotime($tahun.'-'.$bulan));
        $tahunbulanmin1  = date("Ym", strtotime("$tahunbulan -1 months"));
        $tahunbulanmin2  = date("Ym", strtotime("$tahunbulan -2 months"));

		$distr = "
        	SELECT
				KODE_DISTRIBUTOR
			FROM
				CRMNEW_USER_DISTRIBUTOR
			WHERE
				ID_USER = '$id_user'
        ";

    	$kd_distr = $this->db->query($distr)->row_array();
    	$kdDistr = $kd_distr['KODE_DISTRIBUTOR'];

    	$list_gm = "'1','2','3','4'";

    	$gm = $this->get_gm($list_gm);

		// print_r('<pre>');
		// print_r($id_user);exit;

		$param_user = "";
		$param_distr = "";
		if ($id_jenis_user == '1012') {
			$param_user = "AND ID_SO = '$id_user'";
		} elseif ($id_jenis_user == '1011') {
			$param_user = "AND ID_SM = '$id_user'";
		} elseif ($id_jenis_user == '1010') {
			$param_user = "AND ID_SSM = '$id_user'";
		} elseif ($id_jenis_user == '1016') {
			$param_user = "AND ID_GSM = '$id_user'";
		} elseif ($id_jenis_user == '1009') {
			$param_user = "AND ID_GSM IN ($gm)";
		} elseif ($id_jenis_user == '1013') {
			$param_distr = "AND TO_NUMBER(KD_DISTRIBUTOR) = TO_NUMBER('$kdDistr')";
		}

		$param_filter = "";
		if ($by == 'REGION') {
			$param_filter = "AND REGIONAL IN ('$set')";
		} elseif ($by == 'PROVINSI') {
			$param_filter = "AND KD_PROVINSI IN ('$set')";
		} elseif ($by == 'AREA') {
			$param_filter = "AND ID_AREA IN ('$set')";
		} elseif ($by == 'DISTRIK') {
			$param_filter = "AND KD_DISTRIK IN ('$set')";
		}

        $sql = "
        	SELECT
				DISTINCT(ID_DISTRIK) AS ID_DISTRIK
			FROM
				HIRARCKY_GSM_SALES_DISTRIK
			WHERE
				NAMA_SALES IS NOT NULL
				AND USER_SALES IS NOT NULL
				$param_user
        ";

        $res = $this->db->query($sql)->result_array();

    	$kd_distrik = '';
    	$distrik = '';
    	$distrik_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['ID_DISTRIK'])) {
	        		$kd_distrik .= "'" . $v['ID_DISTRIK'] . "',";

	        	}
	        }

	        $distrik = substr_replace($kd_distrik, '', -1);
	        if ($id_jenis_user != '1013') {
	        	$distrik_in = "AND KD_DISTRIK IN ($distrik)";
	        }
	        
    	}

		// print_r('<pre>');
		// print_r($id_user.'/'.$id_jenis_user);exit;

		$param_bulan = "TAHUN || LPAD(BULAN,2,'0') = '$tahunbulan'";
		if ($jenis == 'tu') {
			$param_bulan = "TAHUN || LPAD(BULAN,2,'0') BETWEEN '$tahunbulanmin2' AND '$tahunbulan'";
		}

		$sql_fix = "
			SELECT
				A.KD_DISTRIBUTOR,
				NVL(JML, 0) AS JML
			FROM
				(
				SELECT
					DISTINCT(KD_DISTRIBUTOR) AS KD_DISTRIBUTOR
				FROM
					POIN_PENJUALAN
				WHERE
					KD_DISTRIBUTOR IS NOT NULL
					$distr_fix ) A
			LEFT JOIN (
				SELECT
					KD_DISTRIBUTOR,
					COUNT(*) AS JML
				FROM
					(
					SELECT
						KD_CUSTOMER,
						KD_DISTRIBUTOR,
						MIN(TAHUN || LPAD(BULAN, 2, '0')) AS MIN_DATE
					FROM
						POIN_PENJUALAN
					WHERE
						TAHUN = '$tahun'
						AND KD_CUSTOMER IS NOT NULL
						AND KD_DISTRIBUTOR IS NOT NULL
						$distr_fix
						$param_distr
						$param_filter
						$distrik_in
					GROUP BY
						KD_CUSTOMER,
						KD_DISTRIBUTOR )
				WHERE
					MIN_DATE = '$tahunbulan'
				GROUP BY
					KD_DISTRIBUTOR ) B ON
				TO_NUMBER(A.KD_DISTRIBUTOR) = TO_NUMBER(B.KD_DISTRIBUTOR)
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		return $this->db4->query($sql_fix)->result_array();

	}
	
	public function get_HariKerja($tahun, $bulan){

		$tahunbulan = date('Ym', strtotime($tahun.'-'.$bulan));

		$akhir = date('t', strtotime($tahun.'-'.$bulan));
		if ($tahunbulan == date('Ym')) {
			$akhir = str_pad(date('d', strtotime('-1 days')),2,"0",STR_PAD_LEFT);
		}

		$sql_fix = "
			SELECT
				HARI / HARI_TOT * 100 AS PRSN_HARI_KERJA
			FROM
				(
				SELECT
					COUNT(*) HARI
				FROM
					CALENDER_CRM
				WHERE
					TO_CHAR(TANGGAL, 'YYYYMM') = '$tahunbulan'
					AND TO_CHAR(TANGGAL, 'DD') BETWEEN '01' AND '$akhir'
					AND HARI NOT LIKE ('%SUNDAY%')),
				(
				SELECT
					COUNT(*) HARI_TOT
				FROM
					CALENDER_CRM
				WHERE
					TO_CHAR(TANGGAL, 'YYYYMM') = '202005'
					AND HARI NOT LIKE ('%SUNDAY%') )
		"; 

		return $this->db->query($sql_fix)->row_array();

	}
	
	public function get_month(){

		$awal = date('Y01');
		$akhir = date('Ym');

        $sql = "
        	SELECT
				DISTINCT(TO_CHAR(TANGGAL, 'MM')) AS BULAN
			FROM
				CALENDER_CRM
			WHERE
				TO_CHAR(TANGGAL, 'YYYYMM') BETWEEN '$awal' AND '$akhir'
			ORDER BY
				TO_CHAR(TANGGAL, 'MM')
        ";

        $res = $this->db->query($sql)->result_array();

    	$kd_bulan = '';
    	$bulan = '';
    	$bulan_in = '';

    	if (!empty($res)) {
	        foreach ($res as $k => $v){
	        	if (!empty($v['BULAN'])) {
	        		$kd_bulan .= "'" . $v['BULAN'] . "',";

	        	}
	        }

	        $bulan = substr_replace($kd_bulan, '', -1);
        	$bulan_in = "$bulan";
	        
    	}

    	return $bulan_in;

	}
	
	public function get_tdftrregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,$nas=null){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR NOMOR_DISTRIBUTOR = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR NOMOR_DISTRIBUTOR = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR NOMOR_DISTRIBUTOR = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR NOMOR_DISTRIBUTOR = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		// print_r('<pre>');
		// print_r($distr_fix_3);exit;

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_DISTRIK IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_DISTRIK IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_DISTRIK IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_DISTRIK IN ($getDistrik_4)";
		}

		$dfr1 = "ID_REGION,";
		$dfr2 = "ID_REGION,";

		if ($nas == 'nas') {
			$dfr1 = "";
			$dfr2 = "";
		}

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					$dfr1
					ID_DATA,
					BULAN,
					NVL(SUM(JML_CUS),0) AS JML_CUS
				FROM
					(
					SELECT
						A.ID_REGION,
						'0' AS ID_DATA,
						B.BULAN,
						CASE
							WHEN B.BULAN = '01' THEN NVL(C.JML_CUS_THN_LALU,0) + NVL(B.JML_CUS, 0)
							ELSE NVL(B.JML_CUS, 0)
						END AS JML_CUS
					FROM
						(
						SELECT
							DISTINCT(REGIONAL) AS ID_REGION,
							SUBSTR(AKUISISI_DATE,4,2) AS BULAN
						FROM
							VIEW_M_CUSTOMER
						WHERE
							REGIONAL IN ('1')) A
					LEFT JOIN(
						SELECT
							REGIONAL AS ID_REGION,
							SUBSTR(AKUISISI_DATE,4,2) AS BULAN,
							COUNT(KD_CUSTOMER) AS JML_CUS
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) BETWEEN '$awal' AND '$akhir'
							AND STATUS NOT IN ('6')
							$distr_in_1
							$distrik_in_1
						GROUP BY
							REGIONAL,
							SUBSTR(AKUISISI_DATE,4,2)) B ON
						A.ID_REGION = B.ID_REGION
						AND A.BULAN = B.BULAN
					LEFT JOIN (
						SELECT
							REGIONAL AS ID_REGION,
							COUNT(KD_CUSTOMER) AS JML_CUS_THN_LALU
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) < '$awal'
							AND STATUS NOT IN ('6')
							$distr_in_1
							$distrik_in_1
						GROUP BY
							REGIONAL) C ON
						A.ID_REGION = C.ID_REGION
					UNION
					SELECT
						A.ID_REGION,
						'0' AS ID_DATA,
						B.BULAN,
						CASE
							WHEN B.BULAN = '01' THEN NVL(C.JML_CUS_THN_LALU,0) + NVL(B.JML_CUS, 0)
							ELSE NVL(B.JML_CUS, 0)
						END AS JML_CUS
					FROM
						(
						SELECT
							DISTINCT(REGIONAL) AS ID_REGION,
							SUBSTR(AKUISISI_DATE,4,2) AS BULAN
						FROM
							VIEW_M_CUSTOMER
						WHERE
							REGIONAL IN ('2')) A
					LEFT JOIN(
						SELECT
							REGIONAL AS ID_REGION,
							SUBSTR(AKUISISI_DATE,4,2) AS BULAN,
							COUNT(KD_CUSTOMER) AS JML_CUS
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) BETWEEN '$awal' AND '$akhir'
							AND STATUS NOT IN ('6')
							$distr_in_2
							$distrik_in_2
						GROUP BY
							REGIONAL,
							SUBSTR(AKUISISI_DATE,4,2)) B ON
						A.ID_REGION = B.ID_REGION
						AND A.BULAN = B.BULAN
					LEFT JOIN (
						SELECT
							REGIONAL AS ID_REGION,
							COUNT(KD_CUSTOMER) AS JML_CUS_THN_LALU
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) < '$awal'
							AND STATUS NOT IN ('6')
							$distr_in_2
							$distrik_in_2
						GROUP BY
							REGIONAL) C ON
						A.ID_REGION = C.ID_REGION
					UNION
					SELECT
						A.ID_REGION,
						'0' AS ID_DATA,
						B.BULAN,
						CASE
							WHEN B.BULAN = '01' THEN NVL(C.JML_CUS_THN_LALU,0) + NVL(B.JML_CUS, 0)
							ELSE NVL(B.JML_CUS, 0)
						END AS JML_CUS
					FROM
						(
						SELECT
							DISTINCT(REGIONAL) AS ID_REGION,
							SUBSTR(AKUISISI_DATE,4,2) AS BULAN
						FROM
							VIEW_M_CUSTOMER
						WHERE
							REGIONAL IN ('3')) A
					LEFT JOIN(
						SELECT
							REGIONAL AS ID_REGION,
							SUBSTR(AKUISISI_DATE,4,2) AS BULAN,
							COUNT(KD_CUSTOMER) AS JML_CUS
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) BETWEEN '$awal' AND '$akhir'
							AND STATUS NOT IN ('6')
							$distr_in_3
							$distrik_in_3
						GROUP BY
							REGIONAL,
							SUBSTR(AKUISISI_DATE,4,2)) B ON
						A.ID_REGION = B.ID_REGION
						AND A.BULAN = B.BULAN
					LEFT JOIN (
						SELECT
							REGIONAL AS ID_REGION,
							COUNT(KD_CUSTOMER) AS JML_CUS_THN_LALU
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) < '$awal'
							AND STATUS NOT IN ('6')
							$distr_in_3
							$distrik_in_3
						GROUP BY
							REGIONAL) C ON
						A.ID_REGION = C.ID_REGION
					UNION
					SELECT
						A.ID_REGION,
						'0' AS ID_DATA,
						B.BULAN,
						CASE
							WHEN B.BULAN = '01' THEN NVL(C.JML_CUS_THN_LALU,0) + NVL(B.JML_CUS, 0)
							ELSE NVL(B.JML_CUS, 0)
						END AS JML_CUS
					FROM
						(
						SELECT
							DISTINCT(REGIONAL) AS ID_REGION,
							SUBSTR(AKUISISI_DATE,4,2) AS BULAN
						FROM
							VIEW_M_CUSTOMER
						WHERE
							REGIONAL IN ('4')) A
					LEFT JOIN(
						SELECT
							REGIONAL AS ID_REGION,
							SUBSTR(AKUISISI_DATE,4,2) AS BULAN,
							COUNT(KD_CUSTOMER) AS JML_CUS
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) BETWEEN '$awal' AND '$akhir'
							AND STATUS NOT IN ('6')
							$distr_in_4
							$distrik_in_4
						GROUP BY
							REGIONAL,
							SUBSTR(AKUISISI_DATE,4,2)) B ON
						A.ID_REGION = B.ID_REGION
						AND A.BULAN = B.BULAN
					LEFT JOIN (
						SELECT
							REGIONAL AS ID_REGION,
							COUNT(KD_CUSTOMER) AS JML_CUS_THN_LALU
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) < '$awal'
							AND STATUS NOT IN ('6')
							$distr_in_4
							$distrik_in_4
						GROUP BY
							REGIONAL) C ON
						A.ID_REGION = C.ID_REGION )
					GROUP BY
						$dfr2
						ID_DATA,
					BULAN) PIVOT ( SUM (JML_CUS) FOR BULAN IN ( $month_in ) )
		"; 

		$jml_cus = $this->db4->query($sql_fix)->result_array();

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			if ($nas == 'nas') {

				$dt_arr[] = array(
					'ID_DATA'	=> $jml['ID_DATA'],
					"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
					"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2,
					"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3,
					"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4,
					"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5,
					"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6,
					"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7,
					"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8,
					"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9,
					"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10,
					"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11,
					"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11 + $dt12,
				);

			} else{

				$dt_arr[] = array(
					'ID_REGION'	=> $jml['ID_REGION'],
					'ID_DATA'	=> $jml['ID_DATA'],
					"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
					"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2,
					"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3,
					"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4,
					"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5,
					"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6,
					"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7,
					"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8,
					"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9,
					"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10,
					"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11,
					"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11 + $dt12,
				);
				
			}

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_tbregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,$nas=null){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR KD_DISTRIBUTOR = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR KD_DISTRIBUTOR = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR KD_DISTRIBUTOR = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR KD_DISTRIBUTOR = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in = "";
		$distrik_in = "";

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_DISTRIK IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_DISTRIK IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_DISTRIK IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_DISTRIK IN ($getDistrik_4)";
		}

		$dfr1 = "A.ID_REGION,";
		$dfr2 = "
				(
				SELECT
					DISTINCT(REGIONAL) AS ID_REGION
				FROM
					POIN_PENJUALAN
				WHERE
					REGIONAL IN ('1','2','3','4')) A
			LEFT JOIN
		";
		$dfr3 = "ID_REGION,";
		$dfr4 = "REGIONAL AS ID_REGION,";
		$dfr5 = "REGIONAL,";
		$dfr6 = "ID_REGION,";
		$dfr7 = "ON A.ID_REGION = B.ID_REGION";
		$dfr8 = "";

		if ($nas == 'nas') {
			$dfr1 = "";
			$dfr2 = "";
			$dfr3 = "";
			$dfr4 = "";
			$dfr5 = "";
			$dfr6 = "";
			$dfr7 = "";
			$dfr8 = "AND REGIONAL IN ('1','2','3','4')";
		}

		// print_r('<pre>');
		// print_r($month_in);exit;

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					$dfr1
					'1' AS ID_DATA,
					B.BULAN,
					B.JML_TB
				FROM
					$dfr2
					(
					SELECT
						$dfr3
						SUBSTR(MIN_DATE, 5, 2) AS BULAN,
						COUNT(*) AS JML_TB
					FROM
						(
						SELECT
							$dfr4
							KD_DISTRIBUTOR,
							KD_CUSTOMER,
							MIN(TAHUN || LPAD(BULAN, 2, '0')) AS MIN_DATE
						FROM
							POIN_PENJUALAN
						WHERE
							TAHUN = '$tahun'
							$dfr8
							$distr_in_1
							$distrik_in_1
						GROUP BY
							$dfr5
							KD_DISTRIBUTOR,
							KD_CUSTOMER )
					WHERE
						MIN_DATE BETWEEN '$bln_awal' AND '$bln_akhir'
					GROUP BY
						$dfr6
						SUBSTR(MIN_DATE, 5, 2)
					UNION
					SELECT
						$dfr3
						SUBSTR(MIN_DATE, 5, 2) AS BULAN,
						COUNT(*) AS JML_TB
					FROM
						(
						SELECT
							$dfr4
							KD_DISTRIBUTOR,
							KD_CUSTOMER,
							MIN(TAHUN || LPAD(BULAN, 2, '0')) AS MIN_DATE
						FROM
							POIN_PENJUALAN
						WHERE
							TAHUN = '$tahun'
							$dfr8
							$distr_in_2
							$distrik_in_2
						GROUP BY
							$dfr5
							KD_DISTRIBUTOR,
							KD_CUSTOMER )
					WHERE
						MIN_DATE BETWEEN '$bln_awal' AND '$bln_akhir'
					GROUP BY
						$dfr6
						SUBSTR(MIN_DATE, 5, 2)
					UNION
					SELECT
						$dfr3
						SUBSTR(MIN_DATE, 5, 2) AS BULAN,
						COUNT(*) AS JML_TB
					FROM
						(
						SELECT
							$dfr4
							KD_DISTRIBUTOR,
							KD_CUSTOMER,
							MIN(TAHUN || LPAD(BULAN, 2, '0')) AS MIN_DATE
						FROM
							POIN_PENJUALAN
						WHERE
							TAHUN = '$tahun'
							$dfr8
							$distr_in_3
							$distrik_in_3
						GROUP BY
							$dfr5
							KD_DISTRIBUTOR,
							KD_CUSTOMER )
					WHERE
						MIN_DATE BETWEEN '$bln_awal' AND '$bln_akhir'
					GROUP BY
						$dfr6
						SUBSTR(MIN_DATE, 5, 2)
					UNION
					SELECT
						$dfr3
						SUBSTR(MIN_DATE, 5, 2) AS BULAN,
						COUNT(*) AS JML_TB
					FROM
						(
						SELECT
							$dfr4
							KD_DISTRIBUTOR,
							KD_CUSTOMER,
							MIN(TAHUN || LPAD(BULAN, 2, '0')) AS MIN_DATE
						FROM
							POIN_PENJUALAN
						WHERE
							TAHUN = '$tahun'
							$dfr8
							$distr_in_4
							$distrik_in_4
						GROUP BY
							$dfr5
							KD_DISTRIBUTOR,
							KD_CUSTOMER )
					WHERE
						MIN_DATE BETWEEN '$bln_awal' AND '$bln_akhir'
					GROUP BY
						$dfr6
						SUBSTR(MIN_DATE, 5, 2)
					) B
						$dfr7
					) PIVOT ( SUM (JML_TB) FOR BULAN IN ( $month_in ) )
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db4->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_taIBKregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,$nas=null){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR KD_DISTRIBUTOR = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR KD_DISTRIBUTOR = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR KD_DISTRIBUTOR = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR KD_DISTRIBUTOR = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in = "";
		$distrik_in = "";

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_DISTRIK IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_DISTRIK IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_DISTRIK IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_DISTRIK IN ($getDistrik_4)";
		}

		$dfr1 = "A.ID_REGION,";
		$dfr2 = "
				(
				SELECT
					DISTINCT(REGIONAL) AS ID_REGION
				FROM
					POIN_PENJUALAN
				WHERE
					REGIONAL IN ('1','2','3','4')) A
			LEFT JOIN
		";
		$dfr3 = "ID_REGION,";
		$dfr4 = "REGIONAL AS ID_REGION,";
		$dfr5 = "REGIONAL,";
		$dfr6 = "ID_REGION,";
		$dfr7 = "ON A.ID_REGION = B.ID_REGION";
		$dfr8 = "";

		if ($nas == 'nas') {
			$dfr1 = "";
			$dfr2 = "";
			$dfr3 = "";
			$dfr4 = "";
			$dfr5 = "";
			$dfr6 = "";
			$dfr7 = "";
			$dfr8 = "AND REGIONAL IN ('1','2','3','4')";
		}

		// print_r('<pre>');
		// print_r($month_in);exit;

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					$dfr1
					'2' AS ID_DATA,
					B.BULAN,
					NVL(B.TA_IBK,0) AS TA_IBK
				FROM
					$dfr2
					(
					SELECT
						$dfr3
						BULAN,
						COUNT(KD_CUSTOMER) AS TA_IBK
					FROM
						(
						SELECT
							KD_CUSTOMER,
							$dfr4
							BULAN,
							SUM(JML_POIN) AS JML_POIN
						FROM
							POIN_PENJUALAN
						WHERE
							TAHUN || LPAD(BULAN, 2, '0') BETWEEN '$bln_awal' AND '$bln_akhir'
							$dfr8
							AND TAHUN IS NOT NULL
							AND BULAN IS NOT NULL
							$distr_in_1
							$distrik_in_1
						GROUP BY
							KD_CUSTOMER,
							$dfr5
							BULAN
						UNION
						SELECT
							KD_CUSTOMER,
							$dfr4
							BULAN,
							SUM(JML_POIN) AS JML_POIN
						FROM
							POIN_PENJUALAN
						WHERE
							TAHUN || LPAD(BULAN, 2, '0') BETWEEN '$bln_awal' AND '$bln_akhir'
							$dfr8
							AND TAHUN IS NOT NULL
							AND BULAN IS NOT NULL
							$distr_in_2
							$distrik_in_2
						GROUP BY
							KD_CUSTOMER,
							$dfr5
							BULAN
						UNION
						SELECT
							KD_CUSTOMER,
							$dfr4
							BULAN,
							SUM(JML_POIN) AS JML_POIN
						FROM
							POIN_PENJUALAN
						WHERE
							TAHUN || LPAD(BULAN, 2, '0') BETWEEN '$bln_awal' AND '$bln_akhir'
							$dfr8
							AND TAHUN IS NOT NULL
							AND BULAN IS NOT NULL
							$distr_in_3
							$distrik_in_3
						GROUP BY
							KD_CUSTOMER,
							$dfr5
							BULAN
						UNION
						SELECT
							KD_CUSTOMER,
							$dfr4
							BULAN,
							SUM(JML_POIN) AS JML_POIN
						FROM
							POIN_PENJUALAN
						WHERE
							TAHUN || LPAD(BULAN, 2, '0') BETWEEN '$bln_awal' AND '$bln_akhir'
							$dfr8
							AND TAHUN IS NOT NULL
							AND BULAN IS NOT NULL
							$distr_in_4
							$distrik_in_4
						GROUP BY
							KD_CUSTOMER,
							$dfr5
							BULAN
						)
					GROUP BY
						$dfr6
						BULAN ) B
						$dfr7
					) PIVOT ( SUM (TA_IBK) FOR BULAN IN ( $month_in ) )
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db4->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_taALLregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,$nas=null){

		// $nas = 'nas';

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR KD_DISTRIBUTOR = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR KD_DISTRIBUTOR = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR KD_DISTRIBUTOR = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR KD_DISTRIBUTOR = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in = "";
		$distrik_in = "";

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_KOTA IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_KOTA IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_KOTA IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_KOTA IN ($getDistrik_4)";
		}

		$dfr1 = "A.ID_REGION,";
		$dfr2 = "A.ID_REGION,";

		if ($nas == 'nas') {
			$dfr1 = "";
			$dfr2 = "";
		}

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					$dfr1
					'4' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.JML_TOKO),0) AS JML_TOKO
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('1')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_1) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						COUNT(CS.TOKO) AS JML_TOKO
					FROM
						(
						SELECT
							DISTINCT(KD_TOKO || '-' || NM_TOKO || '-' || ALAMAT) AS TOKO,
							KD_CUSTOMER,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							$distr_in_1
							AND DELETE_MARK = '0' ) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					$dfr2
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (JML_TOKO) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					$dfr1
					'4' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.JML_TOKO),0) AS JML_TOKO
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('2')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_2) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						COUNT(CS.TOKO) AS JML_TOKO
					FROM
						(
						SELECT
							DISTINCT(KD_TOKO || '-' || NM_TOKO || '-' || ALAMAT) AS TOKO,
							KD_CUSTOMER,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							$distr_in_2
							AND DELETE_MARK = '0' ) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					$dfr2
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (JML_TOKO) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					$dfr1
					'4' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.JML_TOKO),0) AS JML_TOKO
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('3')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_3) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						COUNT(CS.TOKO) AS JML_TOKO
					FROM
						(
						SELECT
							DISTINCT(KD_TOKO || '-' || NM_TOKO || '-' || ALAMAT) AS TOKO,
							KD_CUSTOMER,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							$distr_in_3
							AND DELETE_MARK = '0' ) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					$dfr2
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (JML_TOKO) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					$dfr1
					'4' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.JML_TOKO),0) AS JML_TOKO
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('4')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_4) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						COUNT(CS.TOKO) AS JML_TOKO
					FROM
						(
						SELECT
							DISTINCT(KD_TOKO || '-' || NM_TOKO || '-' || ALAMAT) AS TOKO,
							KD_CUSTOMER,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							$distr_in_4
							AND DELETE_MARK = '0' ) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					$dfr2
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (JML_TOKO) FOR BULAN IN ( $month_in ) )
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db2->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_tvmsregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR NOMOR_DISTRIBUTOR = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR NOMOR_DISTRIBUTOR = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR NOMOR_DISTRIBUTOR = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR NOMOR_DISTRIBUTOR = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		// print_r('<pre>');
		// print_r($distr_fix_3);exit;

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_DISTRIK IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_DISTRIK IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_DISTRIK IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_DISTRIK IN ($getDistrik_4)";
		}

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'5' AS ID_DATA,
					A.BULAN,
				CASE
						WHEN B.BULAN = '01' THEN NVL(C.JML_CUS_VMS_THN_LALU,0)+ NVL(B.JML_CUS_VMS, 0)
						ELSE NVL(B.JML_CUS_VMS, 0)
				END AS JML_CUS_VMS
				FROM
					(
					SELECT
						DISTINCT(REGIONAL) AS ID_REGION,
						SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN
					FROM
						VIEW_M_CUSTOMER
					WHERE
						SUBSTR(AKUISISI_DATE, 4, 2) IS NOT NULL
						AND REGIONAL IN ('1')) A
				LEFT JOIN(
					SELECT
						BL.ID_REGION,
						BL.BULAN,
						NVL(DT.JML_CUS_VMS,0) AS JML_CUS_VMS
					FROM
						(
						SELECT
							DISTINCT(REGIONAL) AS ID_REGION,
							SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE, 4, 2) IS NOT NULL
							AND REGIONAL IN ('1')) BL
					LEFT JOIN(
						SELECT
							ID_REGION,
							BULAN,
							COUNT(KD_CUSTOMER) AS JML_CUS_VMS
						FROM
							(
							SELECT
								REGIONAL AS ID_REGION,
								SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN,
								KD_CUSTOMER,
								CASE
									WHEN NOMOR_DISTRIBUTOR IS NULL THEN 0
									ELSE 1
								END AS DISTR_1,
								CASE
									WHEN NOMOR_DISTRIBUTOR1 IS NULL THEN 0
									ELSE 1
								END AS DISTR_2,
								CASE
									WHEN NOMOR_DISTRIBUTOR2 IS NULL THEN 0
									ELSE 1
								END AS DISTR_3,
								CASE
									WHEN NOMOR_DISTRIBUTOR3 IS NULL THEN 0
									ELSE 1
								END AS DISTR_4
							FROM
								VIEW_M_CUSTOMER
							WHERE
								SUBSTR(AKUISISI_DATE, 7, 4) || SUBSTR(AKUISISI_DATE, 4, 2) || SUBSTR(AKUISISI_DATE, 1, 2) BETWEEN '$awal' AND '$akhir'
								$distr_in_1
								$distrik_in_1 )
						WHERE
							DISTR_1 + DISTR_2 + DISTR_3 + DISTR_4 > 1
						GROUP BY
							ID_REGION,
							BULAN ) DT ON
						BL.ID_REGION = DT.ID_REGION
						AND BL.BULAN = DT.BULAN) B ON
					A.ID_REGION = B.ID_REGION
					AND A.BULAN = B.BULAN
				LEFT JOIN(
					SELECT
						ID_REGION,
						COUNT(KD_CUSTOMER) AS JML_CUS_VMS_THN_LALU
					FROM
						(
						SELECT
							REGIONAL AS ID_REGION,
							SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN,
							KD_CUSTOMER,
							CASE
								WHEN NOMOR_DISTRIBUTOR IS NULL THEN 0
								ELSE 1
							END AS DISTR_1,
							CASE
								WHEN NOMOR_DISTRIBUTOR1 IS NULL THEN 0
								ELSE 1
							END AS DISTR_2,
							CASE
								WHEN NOMOR_DISTRIBUTOR2 IS NULL THEN 0
								ELSE 1
							END AS DISTR_3,
							CASE
								WHEN NOMOR_DISTRIBUTOR3 IS NULL THEN 0
								ELSE 1
							END AS DISTR_4
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE, 7, 4) || SUBSTR(AKUISISI_DATE, 4, 2) || SUBSTR(AKUISISI_DATE, 1, 2) < '$awal'
							$distr_in_1
							$distrik_in_1 )
					WHERE
						DISTR_1 + DISTR_2 + DISTR_3 + DISTR_4 > 1
					GROUP BY
						ID_REGION ) C ON
					A.ID_REGION = C.ID_REGION) PIVOT ( SUM (JML_CUS_VMS) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'5' AS ID_DATA,
					A.BULAN,
				CASE
						WHEN B.BULAN = '01' THEN NVL(C.JML_CUS_VMS_THN_LALU,0) + NVL(B.JML_CUS_VMS, 0)
						ELSE NVL(B.JML_CUS_VMS, 0)
				END AS JML_CUS_VMS
				FROM
					(
					SELECT
						DISTINCT(REGIONAL) AS ID_REGION,
						SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN
					FROM
						VIEW_M_CUSTOMER
					WHERE
						SUBSTR(AKUISISI_DATE, 4, 2) IS NOT NULL
						AND REGIONAL IN ('2')) A
				LEFT JOIN(
					SELECT
						BL.ID_REGION,
						BL.BULAN,
						NVL(DT.JML_CUS_VMS,0) AS JML_CUS_VMS
					FROM
						(
						SELECT
							DISTINCT(REGIONAL) AS ID_REGION,
							SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE, 4, 2) IS NOT NULL
							AND REGIONAL IN ('2')) BL
					LEFT JOIN(
						SELECT
							ID_REGION,
							BULAN,
							COUNT(KD_CUSTOMER) AS JML_CUS_VMS
						FROM
							(
							SELECT
								REGIONAL AS ID_REGION,
								SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN,
								KD_CUSTOMER,
								CASE
									WHEN NOMOR_DISTRIBUTOR IS NULL THEN 0
									ELSE 1
								END AS DISTR_1,
								CASE
									WHEN NOMOR_DISTRIBUTOR1 IS NULL THEN 0
									ELSE 1
								END AS DISTR_2,
								CASE
									WHEN NOMOR_DISTRIBUTOR2 IS NULL THEN 0
									ELSE 1
								END AS DISTR_3,
								CASE
									WHEN NOMOR_DISTRIBUTOR3 IS NULL THEN 0
									ELSE 1
								END AS DISTR_4
							FROM
								VIEW_M_CUSTOMER
							WHERE
								SUBSTR(AKUISISI_DATE, 7, 4) || SUBSTR(AKUISISI_DATE, 4, 2) || SUBSTR(AKUISISI_DATE, 1, 2) BETWEEN '$awal' AND '$akhir'
								$distr_in_2
								$distrik_in_2 )
						WHERE
							DISTR_1 + DISTR_2 + DISTR_3 + DISTR_4 > 1
						GROUP BY
							ID_REGION,
							BULAN ) DT ON
						BL.ID_REGION = DT.ID_REGION
						AND BL.BULAN = DT.BULAN) B ON
					A.ID_REGION = B.ID_REGION
					AND A.BULAN = B.BULAN
				LEFT JOIN(
					SELECT
						ID_REGION,
						COUNT(KD_CUSTOMER) AS JML_CUS_VMS_THN_LALU
					FROM
						(
						SELECT
							REGIONAL AS ID_REGION,
							SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN,
							KD_CUSTOMER,
							CASE
								WHEN NOMOR_DISTRIBUTOR IS NULL THEN 0
								ELSE 1
							END AS DISTR_1,
							CASE
								WHEN NOMOR_DISTRIBUTOR1 IS NULL THEN 0
								ELSE 1
							END AS DISTR_2,
							CASE
								WHEN NOMOR_DISTRIBUTOR2 IS NULL THEN 0
								ELSE 1
							END AS DISTR_3,
							CASE
								WHEN NOMOR_DISTRIBUTOR3 IS NULL THEN 0
								ELSE 1
							END AS DISTR_4
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE, 7, 4) || SUBSTR(AKUISISI_DATE, 4, 2) || SUBSTR(AKUISISI_DATE, 1, 2) < '$awal'
							$distr_in_2
							$distrik_in_2 )
					WHERE
						DISTR_1 + DISTR_2 + DISTR_3 + DISTR_4 > 1
					GROUP BY
						ID_REGION ) C ON
					A.ID_REGION = C.ID_REGION) PIVOT ( SUM (JML_CUS_VMS) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'5' AS ID_DATA,
					A.BULAN,
				CASE
						WHEN B.BULAN = '01' THEN NVL(C.JML_CUS_VMS_THN_LALU,0) + NVL(B.JML_CUS_VMS, 0)
						ELSE NVL(B.JML_CUS_VMS, 0)
				END AS JML_CUS_VMS
				FROM
					(
					SELECT
						DISTINCT(REGIONAL) AS ID_REGION,
						SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN
					FROM
						VIEW_M_CUSTOMER
					WHERE
						SUBSTR(AKUISISI_DATE, 4, 2) IS NOT NULL
						AND REGIONAL IN ('3')) A
				LEFT JOIN(
					SELECT
						BL.ID_REGION,
						BL.BULAN,
						NVL(DT.JML_CUS_VMS,0) AS JML_CUS_VMS
					FROM
						(
						SELECT
							DISTINCT(REGIONAL) AS ID_REGION,
							SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE, 4, 2) IS NOT NULL
							AND REGIONAL IN ('3')) BL
					LEFT JOIN(
						SELECT
							ID_REGION,
							BULAN,
							COUNT(KD_CUSTOMER) AS JML_CUS_VMS
						FROM
							(
							SELECT
								REGIONAL AS ID_REGION,
								SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN,
								KD_CUSTOMER,
								CASE
									WHEN NOMOR_DISTRIBUTOR IS NULL THEN 0
									ELSE 1
								END AS DISTR_1,
								CASE
									WHEN NOMOR_DISTRIBUTOR1 IS NULL THEN 0
									ELSE 1
								END AS DISTR_2,
								CASE
									WHEN NOMOR_DISTRIBUTOR2 IS NULL THEN 0
									ELSE 1
								END AS DISTR_3,
								CASE
									WHEN NOMOR_DISTRIBUTOR3 IS NULL THEN 0
									ELSE 1
								END AS DISTR_4
							FROM
								VIEW_M_CUSTOMER
							WHERE
								SUBSTR(AKUISISI_DATE, 7, 4) || SUBSTR(AKUISISI_DATE, 4, 2) || SUBSTR(AKUISISI_DATE, 1, 2) BETWEEN '$awal' AND '$akhir'
								$distr_in_3
								$distrik_in_3 )
						WHERE
							DISTR_1 + DISTR_2 + DISTR_3 + DISTR_4 > 1
						GROUP BY
							ID_REGION,
							BULAN ) DT ON
						BL.ID_REGION = DT.ID_REGION
						AND BL.BULAN = DT.BULAN) B ON
					A.ID_REGION = B.ID_REGION
					AND A.BULAN = B.BULAN
				LEFT JOIN(
					SELECT
						ID_REGION,
						COUNT(KD_CUSTOMER) AS JML_CUS_VMS_THN_LALU
					FROM
						(
						SELECT
							REGIONAL AS ID_REGION,
							SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN,
							KD_CUSTOMER,
							CASE
								WHEN NOMOR_DISTRIBUTOR IS NULL THEN 0
								ELSE 1
							END AS DISTR_1,
							CASE
								WHEN NOMOR_DISTRIBUTOR1 IS NULL THEN 0
								ELSE 1
							END AS DISTR_2,
							CASE
								WHEN NOMOR_DISTRIBUTOR2 IS NULL THEN 0
								ELSE 1
							END AS DISTR_3,
							CASE
								WHEN NOMOR_DISTRIBUTOR3 IS NULL THEN 0
								ELSE 1
							END AS DISTR_4
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE, 7, 4) || SUBSTR(AKUISISI_DATE, 4, 2) || SUBSTR(AKUISISI_DATE, 1, 2) < '$awal'
							$distr_in_3
							$distrik_in_3 )
					WHERE
						DISTR_1 + DISTR_2 + DISTR_3 + DISTR_4 > 1
					GROUP BY
						ID_REGION ) C ON
					A.ID_REGION = C.ID_REGION) PIVOT ( SUM (JML_CUS_VMS) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'5' AS ID_DATA,
					A.BULAN,
				CASE
						WHEN B.BULAN = '01' THEN NVL(C.JML_CUS_VMS_THN_LALU,0) + NVL(B.JML_CUS_VMS, 0)
						ELSE NVL(B.JML_CUS_VMS, 0)
				END AS JML_CUS_VMS
				FROM
					(
					SELECT
						DISTINCT(REGIONAL) AS ID_REGION,
						SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN
					FROM
						VIEW_M_CUSTOMER
					WHERE
						SUBSTR(AKUISISI_DATE, 4, 2) IS NOT NULL
						AND REGIONAL IN ('4')) A
				LEFT JOIN(
					SELECT
						BL.ID_REGION,
						BL.BULAN,
						NVL(DT.JML_CUS_VMS,0) AS JML_CUS_VMS
					FROM
						(
						SELECT
							DISTINCT(REGIONAL) AS ID_REGION,
							SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE, 4, 2) IS NOT NULL
							AND REGIONAL IN ('4')) BL
					LEFT JOIN(
						SELECT
							ID_REGION,
							BULAN,
							COUNT(KD_CUSTOMER) AS JML_CUS_VMS
						FROM
							(
							SELECT
								REGIONAL AS ID_REGION,
								SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN,
								KD_CUSTOMER,
								CASE
									WHEN NOMOR_DISTRIBUTOR IS NULL THEN 0
									ELSE 1
								END AS DISTR_1,
								CASE
									WHEN NOMOR_DISTRIBUTOR1 IS NULL THEN 0
									ELSE 1
								END AS DISTR_2,
								CASE
									WHEN NOMOR_DISTRIBUTOR2 IS NULL THEN 0
									ELSE 1
								END AS DISTR_3,
								CASE
									WHEN NOMOR_DISTRIBUTOR3 IS NULL THEN 0
									ELSE 1
								END AS DISTR_4
							FROM
								VIEW_M_CUSTOMER
							WHERE
								SUBSTR(AKUISISI_DATE, 7, 4) || SUBSTR(AKUISISI_DATE, 4, 2) || SUBSTR(AKUISISI_DATE, 1, 2) BETWEEN '$awal' AND '$akhir'
								$distr_in_4
								$distrik_in_4 )
						WHERE
							DISTR_1 + DISTR_2 + DISTR_3 + DISTR_4 > 1
						GROUP BY
							ID_REGION,
							BULAN ) DT ON
						BL.ID_REGION = DT.ID_REGION
						AND BL.BULAN = DT.BULAN) B ON
					A.ID_REGION = B.ID_REGION
					AND A.BULAN = B.BULAN
				LEFT JOIN(
					SELECT
						ID_REGION,
						COUNT(KD_CUSTOMER) AS JML_CUS_VMS_THN_LALU
					FROM
						(
						SELECT
							REGIONAL AS ID_REGION,
							SUBSTR(AKUISISI_DATE, 4, 2) AS BULAN,
							KD_CUSTOMER,
							CASE
								WHEN NOMOR_DISTRIBUTOR IS NULL THEN 0
								ELSE 1
							END AS DISTR_1,
							CASE
								WHEN NOMOR_DISTRIBUTOR1 IS NULL THEN 0
								ELSE 1
							END AS DISTR_2,
							CASE
								WHEN NOMOR_DISTRIBUTOR2 IS NULL THEN 0
								ELSE 1
							END AS DISTR_3,
							CASE
								WHEN NOMOR_DISTRIBUTOR3 IS NULL THEN 0
								ELSE 1
							END AS DISTR_4
						FROM
							VIEW_M_CUSTOMER
						WHERE
							SUBSTR(AKUISISI_DATE, 7, 4) || SUBSTR(AKUISISI_DATE, 4, 2) || SUBSTR(AKUISISI_DATE, 1, 2) < '$awal'
							$distr_in_4
							$distrik_in_4 )
					WHERE
						DISTR_1 + DISTR_2 + DISTR_3 + DISTR_4 > 1
					GROUP BY
						ID_REGION ) C ON
					A.ID_REGION = C.ID_REGION) PIVOT ( SUM (JML_CUS_VMS) FOR BULAN IN ( $month_in ) )
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db4->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11 + $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_tlelangregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR NOMOR_DISTRIBUTOR = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR NOMOR_DISTRIBUTOR = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR NOMOR_DISTRIBUTOR = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR NOMOR_DISTRIBUTOR = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		// print_r('<pre>');
		// print_r($distr_fix_3);exit;

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_DISTRIK IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_DISTRIK IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_DISTRIK IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_DISTRIK IN ($getDistrik_4)";
		}

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'6' AS ID_DATA,
					B.BULAN,
					NVL(B.JML_CUS_LELANG,0) AS JML_CUS_LELANG
				FROM
					(
					SELECT
						DISTINCT(REGIONAL) AS ID_REGION
					FROM
						VIEW_M_CUSTOMER
					WHERE
						REGIONAL IN ('1','2','3','4')) A
				LEFT JOIN (
					SELECT
						REGIONAL AS ID_REGION,
						SUBSTR(AKUISISI_DATE,4,2) AS BULAN,
						COUNT(KD_CUSTOMER) AS JML_CUS_LELANG
					FROM
						VIEW_M_CUSTOMER
					WHERE
						SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) BETWEEN '$awal' AND '$akhir'
						AND STATUS = '10'
						$distr_in_1
						$distrik_in_1
						AND REGIONAL IN ('1')
					GROUP BY
						REGIONAL,
						SUBSTR(AKUISISI_DATE,4,2)
					UNION
					SELECT
						REGIONAL AS ID_REGION,
						SUBSTR(AKUISISI_DATE,4,2) AS BULAN,
						COUNT(KD_CUSTOMER) AS JML_CUS_LELANG
					FROM
						VIEW_M_CUSTOMER
					WHERE
						SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) BETWEEN '$awal' AND '$akhir'
						AND STATUS = '10'
						$distr_in_2
						$distrik_in_2
						AND REGIONAL IN ('2')
					GROUP BY
						REGIONAL,
						SUBSTR(AKUISISI_DATE,4,2)
					UNION
					SELECT
						REGIONAL AS ID_REGION,
						SUBSTR(AKUISISI_DATE,4,2) AS BULAN,
						COUNT(KD_CUSTOMER) AS JML_CUS_LELANG
					FROM
						VIEW_M_CUSTOMER
					WHERE
						SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) BETWEEN '$awal' AND '$akhir'
						AND STATUS = '10'
						$distr_in_3
						$distrik_in_3
						AND REGIONAL IN ('3')
					GROUP BY
						REGIONAL,
						SUBSTR(AKUISISI_DATE,4,2)
					UNION
					SELECT
						REGIONAL AS ID_REGION,
						SUBSTR(AKUISISI_DATE,4,2) AS BULAN,
						COUNT(KD_CUSTOMER) AS JML_CUS_LELANG
					FROM
						VIEW_M_CUSTOMER
					WHERE
						SUBSTR(AKUISISI_DATE,7,4) || SUBSTR(AKUISISI_DATE,4,2) || SUBSTR(AKUISISI_DATE,1,2) BETWEEN '$awal' AND '$akhir'
						AND STATUS = '10'
						$distr_in_4
						$distrik_in_4
						AND REGIONAL IN ('4')
					GROUP BY
						REGIONAL,
						SUBSTR(AKUISISI_DATE,4,2)
					) B ON
					A.ID_REGION = B.ID_REGION) PIVOT ( SUM (JML_CUS_LELANG) FOR BULAN IN ( $month_in ) )
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db4->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_visitregional($nas=null){

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$dfr1 = "ID_REGION,";
		$dfr2 = "ID_REGION,";

		if ($nas == 'nas') {
			$dfr1 = "";
			$dfr2 = "";
		}

		// print_r('<pre>');
		// print_r($month_in);exit;

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					$dfr1
					'16' AS ID_DATA,
					BULAN,
					NVL(SUM(SLS_VISIT),0) AS SLS_VISIT
				FROM
					(
					SELECT
						A.ID_REGION,
						B.BULAN,
						B.SLS_VISIT
					FROM
						(
						SELECT
							DISTINCT(REGION_ID) AS ID_REGION
						FROM
							R1_REPORT_VISIT_CRM
						WHERE
							REGION_ID IN ('1','2','3','4')) A
					LEFT JOIN (
						SELECT
							REGION_ID,
							BULAN,
							COUNT(ID_SALES) AS SLS_VISIT
						FROM
							(
							SELECT
								DISTINCT(ID_SALES) AS ID_SALES,
								REGION_ID,
								BULAN
							FROM
								R1_REPORT_VISIT_CRM
							WHERE
								TAHUN || BULAN || HARI BETWEEN '$awal' AND '$akhir'
								AND REGION_ID IN ('1','2','3','4')
								AND TAHUN IS NOT NULL
								AND BULAN IS NOT NULL
								AND HARI IS NOT NULL)
						GROUP BY
							REGION_ID,
							BULAN) B ON
						A.ID_REGION = B.REGION_ID)
				GROUP BY
					$dfr2
					BULAN ) PIVOT ( SUM (SLS_VISIT) FOR BULAN IN ( $month_in ) )
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_sellinMSCregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR SOLD_TO = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR SOLD_TO = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR SOLD_TO = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR SOLD_TO = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		// print_r('<pre>');
		// print_r($distr_fix_3);exit;

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KOTA IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KOTA IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KOTA IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KOTA IN ($getDistrik_4)";
		}

		// print_r('<pre>');
		// print_r($month_in);exit;

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'7' AS ID_DATA,
					B.BULAN,
					NVL(B.SELLIN,0) AS SELLIN
				FROM
					(
					SELECT
						DISTINCT(ID_SCM_SALESREG2) AS ID_REGION
					FROM
						ZREPORT_M_PROVINSI
					WHERE
						ID_SCM_SALESREG2 IN ('1','2','3','4')
					) A
					LEFT JOIN (
					SELECT
						BB.ID_SCM_SALESREG2 AS ID_REGION,
						AA.BULAN,
						SUM(AA.KWANTUMX) AS SELLIN
					FROM
						ZREPORT_SCM_REAL_SALES_SIDIGI AA
					LEFT JOIN ZREPORT_M_PROVINSI BB ON
						AA.PROPINSI_TO = BB.KD_PROV
					WHERE
						TAHUN || BULAN || HARI BETWEEN '$awal' AND '$akhir'
						AND AA.TAHUN IS NOT NULL
						AND AA.BULAN IS NOT NULL
						AND AA.HARI IS NOT NULL
						$distr_in_1
						$distrik_in_1
						AND BB.ID_SCM_SALESREG2 IN ('1')
					GROUP BY
						BB.ID_SCM_SALESREG2,
						AA.BULAN
					UNION
					SELECT
						BB.ID_SCM_SALESREG2 AS ID_REGION,
						AA.BULAN,
						SUM(AA.KWANTUMX) AS SELLIN
					FROM
						ZREPORT_SCM_REAL_SALES_SIDIGI AA
					LEFT JOIN ZREPORT_M_PROVINSI BB ON
						AA.PROPINSI_TO = BB.KD_PROV
					WHERE
						TAHUN || BULAN || HARI BETWEEN '$awal' AND '$akhir'
						AND AA.TAHUN IS NOT NULL
						AND AA.BULAN IS NOT NULL
						AND AA.HARI IS NOT NULL
						$distr_in_2
						$distrik_in_2
						AND BB.ID_SCM_SALESREG2 IN ('2')
					GROUP BY
						BB.ID_SCM_SALESREG2,
						AA.BULAN
					UNION
					SELECT
						BB.ID_SCM_SALESREG2 AS ID_REGION,
						AA.BULAN,
						SUM(AA.KWANTUMX) AS SELLIN
					FROM
						ZREPORT_SCM_REAL_SALES_SIDIGI AA
					LEFT JOIN ZREPORT_M_PROVINSI BB ON
						AA.PROPINSI_TO = BB.KD_PROV
					WHERE
						TAHUN || BULAN || HARI BETWEEN '$awal' AND '$akhir'
						AND AA.TAHUN IS NOT NULL
						AND AA.BULAN IS NOT NULL
						AND AA.HARI IS NOT NULL
						$distr_in_3
						$distrik_in_3
						AND BB.ID_SCM_SALESREG2 IN ('3')
					GROUP BY
						BB.ID_SCM_SALESREG2,
						AA.BULAN
					UNION
					SELECT
						BB.ID_SCM_SALESREG2 AS ID_REGION,
						AA.BULAN,
						SUM(AA.KWANTUMX) AS SELLIN
					FROM
						ZREPORT_SCM_REAL_SALES_SIDIGI AA
					LEFT JOIN ZREPORT_M_PROVINSI BB ON
						AA.PROPINSI_TO = BB.KD_PROV
					WHERE
						TAHUN || BULAN || HARI BETWEEN '$awal' AND '$akhir'
						AND AA.TAHUN IS NOT NULL
						AND AA.BULAN IS NOT NULL
						AND AA.HARI IS NOT NULL
						$distr_in_4
						$distrik_in_4
						AND BB.ID_SCM_SALESREG2 IN ('4')
					GROUP BY
						BB.ID_SCM_SALESREG2,
						AA.BULAN
					) B ON
					A.ID_REGION = B.ID_REGION ) PIVOT ( SUM (SELLIN) FOR BULAN IN ( $month_in ) )
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db3->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_selloutSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,$nas=null){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR KD_DISTRIBUTOR = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR KD_DISTRIBUTOR = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR KD_DISTRIBUTOR = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR KD_DISTRIBUTOR = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in = "";
		$distrik_in = "";

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_DISTRIK IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_DISTRIK IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_DISTRIK IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_DISTRIK IN ($getDistrik_4)";
		}

		$dfr1 = "ID_REGION,";
		$dfr2 = "ID_REGION,";

		if ($nas == 'nas') {
			$dfr1 = "";
			$dfr2 = "";
		}

		// print_r('<pre>');
		// print_r($month_in);exit;

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					$dfr1
					'8' AS ID_DATA,
					BULAN,
					NVL(SUM(SELLOUT_SDG),0) AS SELLOUT_SDG
				FROM
					(
					SELECT
						A.ID_REGION,
						B.BULAN,
						B.SELLOUT_SDG
					FROM
						(
						SELECT
							DISTINCT(REGION) AS ID_REGION
						FROM
							V_SELL_OUT_TO_CRM
						WHERE
							REGION IN ('1','2','3','4')) A
					LEFT JOIN (
						SELECT
							REGION AS ID_REGION,
							TO_CHAR(TGL_SPJ, 'MM') AS BULAN,
							SUM(QTY_SELL_OUT) AS SELLOUT_SDG
						FROM
							V_SELL_OUT_TO_CRM
						WHERE
							KD_CUSTOMER IS NOT NULL
							AND TO_CHAR(TGL_SPJ, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND REGION IN ('1')
							AND TGL_SPJ IS NOT NULL
							$distr_in_1
							$distrik_in_1
						GROUP BY
							REGION,
							TO_CHAR(TGL_SPJ, 'MM')
						UNION
						SELECT
							REGION AS ID_REGION,
							TO_CHAR(TGL_SPJ, 'MM') AS BULAN,
							SUM(QTY_SELL_OUT) AS SELLOUT_SDG
						FROM
							V_SELL_OUT_TO_CRM
						WHERE
							KD_CUSTOMER IS NOT NULL
							AND TO_CHAR(TGL_SPJ, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND REGION IN ('2')
							AND TGL_SPJ IS NOT NULL
							$distr_in_2
							$distrik_in_2
						GROUP BY
							REGION,
							TO_CHAR(TGL_SPJ, 'MM')
						UNION
						SELECT
							REGION AS ID_REGION,
							TO_CHAR(TGL_SPJ, 'MM') AS BULAN,
							SUM(QTY_SELL_OUT) AS SELLOUT_SDG
						FROM
							V_SELL_OUT_TO_CRM
						WHERE
							KD_CUSTOMER IS NOT NULL
							AND TO_CHAR(TGL_SPJ, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND REGION IN ('3')
							AND TGL_SPJ IS NOT NULL
							$distr_in_3
							$distrik_in_3
						GROUP BY
							REGION,
							TO_CHAR(TGL_SPJ, 'MM')
						UNION
						SELECT
							REGION AS ID_REGION,
							TO_CHAR(TGL_SPJ, 'MM') AS BULAN,
							SUM(QTY_SELL_OUT) AS SELLOUT_SDG
						FROM
							V_SELL_OUT_TO_CRM
						WHERE
							KD_CUSTOMER IS NOT NULL
							AND TO_CHAR(TGL_SPJ, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND REGION IN ('4')
							AND TGL_SPJ IS NOT NULL
							$distr_in_4
							$distrik_in_4
						GROUP BY
							REGION,
							TO_CHAR(TGL_SPJ, 'MM')
						) B ON
						A.ID_REGION = B.ID_REGION ) 
				GROUP BY
					$dfr2
					BULAN ) PIVOT ( SUM (SELLOUT_SDG) FOR BULAN IN ( $month_in ) )
		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db2->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_selloutERPSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR KD_DISTRIBUTOR = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR KD_DISTRIBUTOR = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR KD_DISTRIBUTOR = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR KD_DISTRIBUTOR = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in = "";
		$distrik_in = "";

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_KOTA IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_KOTA IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_KOTA IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_KOTA IN ($getDistrik_4)";
		}

		// print_r('<pre>');
		// print_r($month_in);exit;

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'10' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.QTY),0) AS QTY
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('1')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_1 ) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.QTY) AS QTY
					FROM
						(
						SELECT
							SUM(QTY) AS QTY,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_1
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (QTY) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'10' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.QTY),0) AS QTY
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('2')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_2 ) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.QTY) AS QTY
					FROM
						(
						SELECT
							SUM(QTY) AS QTY,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_2
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (QTY) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'10' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.QTY),0) AS QTY
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('3')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_3 ) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.QTY) AS QTY
					FROM
						(
						SELECT
							SUM(QTY) AS QTY,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_3
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (QTY) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'10' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.QTY),0) AS QTY
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('4')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_4 ) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.QTY) AS QTY
					FROM
						(
						SELECT
							SUM(QTY) AS QTY,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_4
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (QTY) FOR BULAN IN ( $month_in ) )

		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db2->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_REVselloutSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR KD_DISTRIBUTOR = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR KD_DISTRIBUTOR = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR KD_DISTRIBUTOR = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR KD_DISTRIBUTOR = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in = "";
		$distrik_in = "";

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_KOTA IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_KOTA IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_KOTA IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_KOTA IN ($getDistrik_4)";
		}

		// print_r('<pre>');
		// print_r($month_in);exit;

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'11' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.REV),0) AS REV
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('1')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_1) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.REV) AS REV
					FROM
						(
						SELECT
							SUM(NVL(QTY,0) * NVL(HARGA,0) / 1000000) AS REV,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_1
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (REV) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'11' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.REV),0) AS REV
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('2')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_2) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.REV) AS REV
					FROM
						(
						SELECT
							SUM(NVL(QTY,0) * NVL(HARGA,0) / 1000000) AS REV,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_2
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (REV) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'11' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.REV),0) AS REV
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('3')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_3) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.REV) AS REV
					FROM
						(
						SELECT
							SUM(NVL(QTY,0) * NVL(HARGA,0) / 1000000) AS REV,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_3
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (REV) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'11' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.REV),0) AS REV
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('4')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_4) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.REV) AS REV
					FROM
						(
						SELECT
							SUM(NVL(QTY,0) * NVL(HARGA,0) / 1000000) AS REV,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_4
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (REV) FOR BULAN IN ( $month_in ) )


		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db2->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_REVselloutERPSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR KD_DISTRIBUTOR = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR KD_DISTRIBUTOR = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR KD_DISTRIBUTOR = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR KD_DISTRIBUTOR = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in = "";
		$distrik_in = "";

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_KOTA IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_KOTA IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_KOTA IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_KOTA IN ($getDistrik_4)";
		}

		// print_r('<pre>');
		// print_r($month_in);exit;

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'13' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.REV),0) AS REV
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('1')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_1) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.REV) AS REV
					FROM
						(
						SELECT
							SUM(NVL(QTY,0) * NVL(HARGA,0) / 1000000) AS REV,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_1
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (REV) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'13' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.REV),0) AS REV
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('2')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_2) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.REV) AS REV
					FROM
						(
						SELECT
							SUM(NVL(QTY,0) * NVL(HARGA,0) / 1000000) AS REV,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_2
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (REV) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'13' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.REV),0) AS REV
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('3')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_3) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.REV) AS REV
					FROM
						(
						SELECT
							SUM(NVL(QTY,0) * NVL(HARGA,0) / 1000000) AS REV,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_3
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (REV) FOR BULAN IN ( $month_in ) )
			UNION
			SELECT
				*
			FROM
				(
				SELECT
					A.ID_REGION,
					'13' AS ID_DATA,
					SUBSTR(B.TAHUN_BULAN, 5, 2) AS BULAN,
					NVL(SUM(B.REV),0) AS REV
				FROM
					(
					SELECT
						KT.KD_KOTA,
						PR.KD_PROV,
						PR.ID_REGION
					FROM
						(
						SELECT
							DISTINCT(KD_PROV) AS KD_PROV,
							ID_SCM_SALESREG_NEW AS ID_REGION
						FROM
							MASTER_PROVINSI
						WHERE
							KD_PROV IS NOT NULL
							AND ID_SCM_SALESREG_NEW IN ('4')
							AND KD_PROV NOT IN ('1092',
							'0001')) PR
					LEFT JOIN(
						SELECT
							DISTINCT(KD_KOTA) AS KD_KOTA,
							KD_PROP
						FROM
							MASTER_KOTA
						WHERE
							KD_KOTA IS NOT NULL
							$distrik_in_4) KT ON
						PR.KD_PROV = KT.KD_PROP) A
				LEFT JOIN (
					SELECT
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK,
						SUM(CS.REV) AS REV
					FROM
						(
						SELECT
							SUM(NVL(QTY,0) * NVL(HARGA,0) / 1000000) AS REV,
							TO_CHAR(TGL_KIRIM, 'YYYYMM') AS TAHUN_BULAN,
							KD_CUSTOMER
						FROM
							TPL_T_JUAL_DTL_SERVICE
						WHERE
							TO_CHAR(TGL_KIRIM, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
							AND DELETE_MARK = '0'
							$distr_in_4
						GROUP BY
							KD_TOKO,
							TO_CHAR(TGL_KIRIM, 'YYYYMM'),
							KD_CUSTOMER) CS
					LEFT JOIN(
						SELECT
							KD_GDG,
							KD_DISTRIK
						FROM
							GUDANG_SIDIGI
						WHERE
							DELETE_MARK = '0') GDG ON
						TO_NUMBER(CS.KD_CUSTOMER) = TO_NUMBER(GDG.KD_GDG)
					GROUP BY
						CS.TAHUN_BULAN,
						GDG.KD_DISTRIK) B ON
					A.KD_KOTA = B.KD_DISTRIK
				GROUP BY
					A.ID_REGION,
					SUBSTR(B.TAHUN_BULAN, 5, 2)) PIVOT ( SUM (REV) FOR BULAN IN ( $month_in ) )


		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db2->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			$dt_arr[] = array(
				'ID_REGION'	=> $jml['ID_REGION'],
				'ID_DATA'	=> $jml['ID_DATA'],
				"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
				"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
				"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
				"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
				"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
				"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
				"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
				"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
				"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
				"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
				"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
				"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
			);

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_levelstokSDGregional($getDistr_1,$getDistrik_1,$getDistr_2,$getDistrik_2,$getDistr_3,$getDistrik_3,$getDistr_4,$getDistrik_4,$nas=null){

    	$kd_distr_1 = '';
    	$distr_1 = '';
    	$distr_fix_1 = '';
    	$distr_in_1 = '';

    	if (!empty($getDistr_1)) {
	        foreach ($getDistr_1 as $k_1 => $v_1){

	        	if (!empty($v_1['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_1 .= "OR SOLD_TO = '" . $v_1['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_1 = substr_replace($kd_distr_1, '', -1);
	        $distr_fix_1 = substr_replace($distr_1, '', 0, 3);
	        
    	}

    	$kd_distr_2 = '';
    	$distr_2 = '';
    	$distr_fix_2 = '';
    	$distr_in_2 = '';

    	if (!empty($getDistr_2)) {
	        foreach ($getDistr_2 as $k_2 => $v_2){

	        	if (!empty($v_2['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_2 .= "OR SOLD_TO = '" . $v_2['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_2 = substr_replace($kd_distr_2, '', -1);
	        $distr_fix_2 = substr_replace($distr_2, '', 0, 3);
	        
    	}

    	$kd_distr_3 = '';
    	$distr_3 = '';
    	$distr_fix_3 = '';
    	$distr_in_3 = '';

    	if (!empty($getDistr_3)) {
	        foreach ($getDistr_3 as $k_3 => $v_3){

	        	if (!empty($v_3['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_3 .= "OR SOLD_TO = '" . $v_3['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_3 = substr_replace($kd_distr_3, '', -1);
	        $distr_fix_3 = substr_replace($distr_3, '', 0, 3);
	        
    	}

    	$kd_distr_4 = '';
    	$distr_4 = '';
    	$distr_fix_4 = '';
    	$distr_in_4 = '';

    	if (!empty($getDistr_4)) {
	        foreach ($getDistr_4 as $k_4 => $v_4){

	        	if (!empty($v_4['KODE_DISTRIBUTOR'])) {
	        		$kd_distr_4 .= "OR SOLD_TO = '" . $v_4['KODE_DISTRIBUTOR'] . "' ";

	        	}
	        }

	        $distr_4 = substr_replace($kd_distr_4, '', -1);
	        $distr_fix_4 = substr_replace($distr_4, '', 0, 3);
	        
    	}

		// print_r('<pre>');
		// print_r($distr_fix_3);exit;

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$tahun = date('Y');

		$bln_awal = date('Y01');
		$bln_akhir = date('Ym');

		$distr_in_1 = "";
		$distrik_in_1 = "";

		if (!empty($getDistr_1)) {
			$distr_in_1 = "AND ($distr_fix_1)";
		}

		if (!empty($getDistrik_1)) {
			$distrik_in_1 = "AND KD_KOTA IN ($getDistrik_1)";
		}

		$distr_in_2 = "";
		$distrik_in_2 = "";

		if (!empty($getDistr_2)) {
			$distr_in_2 = "AND ($distr_fix_2)";
		}

		if (!empty($getDistrik_2)) {
			$distrik_in_2 = "AND KD_KOTA IN ($getDistrik_2)";
		}

		$distr_in_3 = "";
		$distrik_in_3 = "";

		if (!empty($getDistr_3)) {
			$distr_in_3 = "AND ($distr_fix_3)";
		}

		if (!empty($getDistrik_3)) {
			$distrik_in_3 = "AND KD_KOTA IN ($getDistrik_3)";
		}

		$distr_in_4 = "";
		$distrik_in_4 = "";

		if (!empty($getDistr_4)) {
			$distr_in_4 = "AND ($distr_fix_4)";
		}

		if (!empty($getDistrik_4)) {
			$distrik_in_4 = "AND KD_KOTA IN ($getDistrik_4)";
		}

		$dfr1 = "Q_QTY.ID_REGION,";
		$dfr2 = "Q_QTY.ID_REGION,";

		if ($nas == 'nas') {
			$dfr1 = "";
			$dfr2 = "";
		}

		// print_r('<pre>');
		// print_r($month_in);exit;

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					$dfr1	
			 		Q_QTY.ID_DATA,
					Q_QTY.BULAN,
					NVL(SUM(Q_QTY.QTY_STOK), 0) / NVL(SUM(Q_KAP.KAPASITAS), 0) AS LVL_STOK
				FROM
					(
					SELECT
						A.ID_REGION,
						'14' AS ID_DATA,
						B.BULAN,
						NVL(SUM(B.QTY_STOK), 0) AS QTY_STOK
					FROM
						(
						SELECT
							KT.KD_KOTA,
							PR.KD_PROV,
							PR.ID_REGION
						FROM
							(
							SELECT
								DISTINCT(KD_PROV) AS KD_PROV,
								ID_SCM_SALESREG_NEW AS ID_REGION
							FROM
								MASTER_PROVINSI
							WHERE
								KD_PROV IS NOT NULL
								AND ID_SCM_SALESREG_NEW IN ('1')
								AND KD_PROV NOT IN ('1092',
								'0001')) PR
						LEFT JOIN(
							SELECT
								DISTINCT(KD_KOTA) AS KD_KOTA,
								KD_PROP
							FROM
								MASTER_KOTA
							WHERE
								KD_KOTA IS NOT NULL
								$distrik_in_1) KT ON
							PR.KD_PROV = KT.KD_PROP) A
					LEFT JOIN (
						SELECT
							CS.BULAN,
							GDG.KD_DISTRIK,
							SUM(CS.QTY_STOK) AS QTY_STOK,
							SUM(GDG.KAPASITAS) AS KAPASITAS
						FROM
							(
							SELECT
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') AS BULAN,
								SUM(QTY_STOK) AS QTY_STOK
							FROM
								TPL_CRM_GUDANG_SERVICE_HSTR
							WHERE
								TO_CHAR(TGL_STOK, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
								AND DELETE_MARK = '0'
								$distr_in_1
							GROUP BY
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') ) CS
						LEFT JOIN(
							SELECT
								KD_GDG,
								KD_DISTRIK,
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								GUDANG_SIDIGI
							WHERE
								DELETE_MARK = '0'
							GROUP BY
								KD_GDG,
								KD_DISTRIK) GDG ON
							TO_NUMBER(CS.KODE_SHIPTO) = TO_NUMBER(GDG.KD_GDG)
						GROUP BY
							CS.BULAN,
							GDG.KD_DISTRIK) B ON
						A.KD_KOTA = B.KD_DISTRIK
					WHERE
						B.BULAN IS NOT NULL
					GROUP BY
						A.ID_REGION,
						B.BULAN
				UNION
					SELECT
						A.ID_REGION,
						'14' AS ID_DATA,
						B.BULAN,
						NVL(SUM(B.QTY_STOK), 0) AS QTY_STOK
					FROM
						(
						SELECT
							KT.KD_KOTA,
							PR.KD_PROV,
							PR.ID_REGION
						FROM
							(
							SELECT
								DISTINCT(KD_PROV) AS KD_PROV,
								ID_SCM_SALESREG_NEW AS ID_REGION
							FROM
								MASTER_PROVINSI
							WHERE
								KD_PROV IS NOT NULL
								AND ID_SCM_SALESREG_NEW IN ('2')
								AND KD_PROV NOT IN ('1092',
								'0001')) PR
						LEFT JOIN(
							SELECT
								DISTINCT(KD_KOTA) AS KD_KOTA,
								KD_PROP
							FROM
								MASTER_KOTA
							WHERE
								KD_KOTA IS NOT NULL
								$distrik_in_2) KT ON
							PR.KD_PROV = KT.KD_PROP) A
					LEFT JOIN (
						SELECT
							CS.BULAN,
							GDG.KD_DISTRIK,
							SUM(CS.QTY_STOK) AS QTY_STOK,
							SUM(GDG.KAPASITAS) AS KAPASITAS
						FROM
							(
							SELECT
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') AS BULAN,
								SUM(QTY_STOK) AS QTY_STOK
							FROM
								TPL_CRM_GUDANG_SERVICE_HSTR
							WHERE
								TO_CHAR(TGL_STOK, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
								AND DELETE_MARK = '0'
								$distr_in_2
							GROUP BY
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') ) CS
						LEFT JOIN(
							SELECT
								KD_GDG,
								KD_DISTRIK,
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								GUDANG_SIDIGI
							WHERE
								DELETE_MARK = '0'
							GROUP BY
								KD_GDG,
								KD_DISTRIK) GDG ON
							TO_NUMBER(CS.KODE_SHIPTO) = TO_NUMBER(GDG.KD_GDG)
						GROUP BY
							CS.BULAN,
							GDG.KD_DISTRIK) B ON
						A.KD_KOTA = B.KD_DISTRIK
					WHERE
						B.BULAN IS NOT NULL
					GROUP BY
						A.ID_REGION,
						B.BULAN
				UNION
					SELECT
						A.ID_REGION,
						'14' AS ID_DATA,
						B.BULAN,
						NVL(SUM(B.QTY_STOK), 0) AS QTY_STOK
					FROM
						(
						SELECT
							KT.KD_KOTA,
							PR.KD_PROV,
							PR.ID_REGION
						FROM
							(
							SELECT
								DISTINCT(KD_PROV) AS KD_PROV,
								ID_SCM_SALESREG_NEW AS ID_REGION
							FROM
								MASTER_PROVINSI
							WHERE
								KD_PROV IS NOT NULL
								AND ID_SCM_SALESREG_NEW IN ('3')
								AND KD_PROV NOT IN ('1092',
								'0001')) PR
						LEFT JOIN(
							SELECT
								DISTINCT(KD_KOTA) AS KD_KOTA,
								KD_PROP
							FROM
								MASTER_KOTA
							WHERE
								KD_KOTA IS NOT NULL
								$distrik_in_3) KT ON
							PR.KD_PROV = KT.KD_PROP) A
					LEFT JOIN (
						SELECT
							CS.BULAN,
							GDG.KD_DISTRIK,
							SUM(CS.QTY_STOK) AS QTY_STOK,
							SUM(GDG.KAPASITAS) AS KAPASITAS
						FROM
							(
							SELECT
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') AS BULAN,
								SUM(QTY_STOK) AS QTY_STOK
							FROM
								TPL_CRM_GUDANG_SERVICE_HSTR
							WHERE
								TO_CHAR(TGL_STOK, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
								AND DELETE_MARK = '0'
								$distr_in_3
							GROUP BY
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') ) CS
						LEFT JOIN(
							SELECT
								KD_GDG,
								KD_DISTRIK,
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								GUDANG_SIDIGI
							WHERE
								DELETE_MARK = '0'
							GROUP BY
								KD_GDG,
								KD_DISTRIK) GDG ON
							TO_NUMBER(CS.KODE_SHIPTO) = TO_NUMBER(GDG.KD_GDG)
						GROUP BY
							CS.BULAN,
							GDG.KD_DISTRIK) B ON
						A.KD_KOTA = B.KD_DISTRIK
					WHERE
						B.BULAN IS NOT NULL
					GROUP BY
						A.ID_REGION,
						B.BULAN
				UNION
					SELECT
						A.ID_REGION,
						'14' AS ID_DATA,
						B.BULAN,
						NVL(SUM(B.QTY_STOK), 0) AS QTY_STOK
					FROM
						(
						SELECT
							KT.KD_KOTA,
							PR.KD_PROV,
							PR.ID_REGION
						FROM
							(
							SELECT
								DISTINCT(KD_PROV) AS KD_PROV,
								ID_SCM_SALESREG_NEW AS ID_REGION
							FROM
								MASTER_PROVINSI
							WHERE
								KD_PROV IS NOT NULL
								AND ID_SCM_SALESREG_NEW IN ('4')
								AND KD_PROV NOT IN ('1092',
								'0001')) PR
						LEFT JOIN(
							SELECT
								DISTINCT(KD_KOTA) AS KD_KOTA,
								KD_PROP
							FROM
								MASTER_KOTA
							WHERE
								KD_KOTA IS NOT NULL
								$distrik_in_4) KT ON
							PR.KD_PROV = KT.KD_PROP) A
					LEFT JOIN (
						SELECT
							CS.BULAN,
							GDG.KD_DISTRIK,
							SUM(CS.QTY_STOK) AS QTY_STOK,
							SUM(GDG.KAPASITAS) AS KAPASITAS
						FROM
							(
							SELECT
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') AS BULAN,
								SUM(QTY_STOK) AS QTY_STOK
							FROM
								TPL_CRM_GUDANG_SERVICE_HSTR
							WHERE
								TO_CHAR(TGL_STOK, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
								AND DELETE_MARK = '0'
								$distr_in_4
							GROUP BY
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') ) CS
						LEFT JOIN(
							SELECT
								KD_GDG,
								KD_DISTRIK,
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								GUDANG_SIDIGI
							WHERE
								DELETE_MARK = '0'
							GROUP BY
								KD_GDG,
								KD_DISTRIK) GDG ON
							TO_NUMBER(CS.KODE_SHIPTO) = TO_NUMBER(GDG.KD_GDG)
						GROUP BY
							CS.BULAN,
							GDG.KD_DISTRIK) B ON
						A.KD_KOTA = B.KD_DISTRIK
					WHERE
						B.BULAN IS NOT NULL
					GROUP BY
						A.ID_REGION,
						B.BULAN ) Q_QTY
				LEFT JOIN (
					SELECT
						A.ID_REGION,
						'14' AS ID_DATA,
						B.BULAN,
						NVL(SUM(B.KAPASITAS), 0) AS KAPASITAS
					FROM
						(
						SELECT
							KT.KD_KOTA,
							PR.KD_PROV,
							PR.ID_REGION
						FROM
							(
							SELECT
								DISTINCT(KD_PROV) AS KD_PROV,
								ID_SCM_SALESREG_NEW AS ID_REGION
							FROM
								MASTER_PROVINSI
							WHERE
								KD_PROV IS NOT NULL
								AND ID_SCM_SALESREG_NEW IN ('1')
								AND KD_PROV NOT IN ('1092',
								'0001')) PR
						LEFT JOIN(
							SELECT
								DISTINCT(KD_KOTA) AS KD_KOTA,
								KD_PROP
							FROM
								MASTER_KOTA
							WHERE
								KD_KOTA IS NOT NULL
								$distrik_in_1) KT ON
							PR.KD_PROV = KT.KD_PROP) A
					LEFT JOIN (
						SELECT
							CS.BULAN,
							GDG.KD_DISTRIK,
							SUM(CS.QTY_STOK) AS QTY_STOK,
							SUM(GDG.KAPASITAS) AS KAPASITAS
						FROM
							(
							SELECT
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') AS BULAN,
								SUM(QTY_STOK) AS QTY_STOK
							FROM
								TPL_CRM_GUDANG_SERVICE_HSTR
							WHERE
								TO_CHAR(TGL_STOK, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
								AND DELETE_MARK = '0'
								$distr_in_1
							GROUP BY
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') ) CS
						LEFT JOIN(
							SELECT
								KD_GDG,
								KD_DISTRIK,
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								GUDANG_SIDIGI
							WHERE
								DELETE_MARK = '0'
							GROUP BY
								KD_GDG,
								KD_DISTRIK) GDG ON
							TO_NUMBER(CS.KODE_SHIPTO) = TO_NUMBER(GDG.KD_GDG)
						GROUP BY
							CS.BULAN,
							GDG.KD_DISTRIK) B ON
						A.KD_KOTA = B.KD_DISTRIK
					WHERE
						B.BULAN IS NOT NULL
					GROUP BY
						A.ID_REGION,
						B.BULAN
				UNION
					SELECT
						A.ID_REGION,
						'14' AS ID_DATA,
						B.BULAN,
						NVL(SUM(B.KAPASITAS), 0) AS KAPASITAS
					FROM
						(
						SELECT
							KT.KD_KOTA,
							PR.KD_PROV,
							PR.ID_REGION
						FROM
							(
							SELECT
								DISTINCT(KD_PROV) AS KD_PROV,
								ID_SCM_SALESREG_NEW AS ID_REGION
							FROM
								MASTER_PROVINSI
							WHERE
								KD_PROV IS NOT NULL
								AND ID_SCM_SALESREG_NEW IN ('2')
								AND KD_PROV NOT IN ('1092',
								'0001')) PR
						LEFT JOIN(
							SELECT
								DISTINCT(KD_KOTA) AS KD_KOTA,
								KD_PROP
							FROM
								MASTER_KOTA
							WHERE
								KD_KOTA IS NOT NULL
								$distrik_in_2) KT ON
							PR.KD_PROV = KT.KD_PROP) A
					LEFT JOIN (
						SELECT
							CS.BULAN,
							GDG.KD_DISTRIK,
							SUM(CS.QTY_STOK) AS QTY_STOK,
							SUM(GDG.KAPASITAS) AS KAPASITAS
						FROM
							(
							SELECT
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') AS BULAN,
								SUM(QTY_STOK) AS QTY_STOK
							FROM
								TPL_CRM_GUDANG_SERVICE_HSTR
							WHERE
								TO_CHAR(TGL_STOK, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
								AND DELETE_MARK = '0'
								$distr_in_2
							GROUP BY
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') ) CS
						LEFT JOIN(
							SELECT
								KD_GDG,
								KD_DISTRIK,
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								GUDANG_SIDIGI
							WHERE
								DELETE_MARK = '0'
							GROUP BY
								KD_GDG,
								KD_DISTRIK) GDG ON
							TO_NUMBER(CS.KODE_SHIPTO) = TO_NUMBER(GDG.KD_GDG)
						GROUP BY
							CS.BULAN,
							GDG.KD_DISTRIK) B ON
						A.KD_KOTA = B.KD_DISTRIK
					WHERE
						B.BULAN IS NOT NULL
					GROUP BY
						A.ID_REGION,
						B.BULAN
				UNION
					SELECT
						A.ID_REGION,
						'14' AS ID_DATA,
						B.BULAN,
						NVL(SUM(B.KAPASITAS), 0) AS KAPASITAS
					FROM
						(
						SELECT
							KT.KD_KOTA,
							PR.KD_PROV,
							PR.ID_REGION
						FROM
							(
							SELECT
								DISTINCT(KD_PROV) AS KD_PROV,
								ID_SCM_SALESREG_NEW AS ID_REGION
							FROM
								MASTER_PROVINSI
							WHERE
								KD_PROV IS NOT NULL
								AND ID_SCM_SALESREG_NEW IN ('3')
								AND KD_PROV NOT IN ('1092',
								'0001')) PR
						LEFT JOIN(
							SELECT
								DISTINCT(KD_KOTA) AS KD_KOTA,
								KD_PROP
							FROM
								MASTER_KOTA
							WHERE
								KD_KOTA IS NOT NULL
								$distrik_in_3) KT ON
							PR.KD_PROV = KT.KD_PROP) A
					LEFT JOIN (
						SELECT
							CS.BULAN,
							GDG.KD_DISTRIK,
							SUM(CS.QTY_STOK) AS QTY_STOK,
							SUM(GDG.KAPASITAS) AS KAPASITAS
						FROM
							(
							SELECT
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') AS BULAN,
								SUM(QTY_STOK) AS QTY_STOK
							FROM
								TPL_CRM_GUDANG_SERVICE_HSTR
							WHERE
								TO_CHAR(TGL_STOK, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
								AND DELETE_MARK = '0'
								$distr_in_3
							GROUP BY
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') ) CS
						LEFT JOIN(
							SELECT
								KD_GDG,
								KD_DISTRIK,
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								GUDANG_SIDIGI
							WHERE
								DELETE_MARK = '0'
							GROUP BY
								KD_GDG,
								KD_DISTRIK) GDG ON
							TO_NUMBER(CS.KODE_SHIPTO) = TO_NUMBER(GDG.KD_GDG)
						GROUP BY
							CS.BULAN,
							GDG.KD_DISTRIK) B ON
						A.KD_KOTA = B.KD_DISTRIK
					WHERE
						B.BULAN IS NOT NULL
					GROUP BY
						A.ID_REGION,
						B.BULAN
				UNION
					SELECT
						A.ID_REGION,
						'14' AS ID_DATA,
						B.BULAN,
						NVL(SUM(B.KAPASITAS), 0) AS KAPASITAS
					FROM
						(
						SELECT
							KT.KD_KOTA,
							PR.KD_PROV,
							PR.ID_REGION
						FROM
							(
							SELECT
								DISTINCT(KD_PROV) AS KD_PROV,
								ID_SCM_SALESREG_NEW AS ID_REGION
							FROM
								MASTER_PROVINSI
							WHERE
								KD_PROV IS NOT NULL
								AND ID_SCM_SALESREG_NEW IN ('4')
								AND KD_PROV NOT IN ('1092',
								'0001')) PR
						LEFT JOIN(
							SELECT
								DISTINCT(KD_KOTA) AS KD_KOTA,
								KD_PROP
							FROM
								MASTER_KOTA
							WHERE
								KD_KOTA IS NOT NULL
								$distrik_in_4) KT ON
							PR.KD_PROV = KT.KD_PROP) A
					LEFT JOIN (
						SELECT
							CS.BULAN,
							GDG.KD_DISTRIK,
							SUM(CS.QTY_STOK) AS QTY_STOK,
							SUM(GDG.KAPASITAS) AS KAPASITAS
						FROM
							(
							SELECT
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') AS BULAN,
								SUM(QTY_STOK) AS QTY_STOK
							FROM
								TPL_CRM_GUDANG_SERVICE_HSTR
							WHERE
								TO_CHAR(TGL_STOK, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir'
								AND DELETE_MARK = '0'
								$distr_in_4
							GROUP BY
								KODE_SHIPTO,
								TO_CHAR(TGL_STOK, 'MM') ) CS
						LEFT JOIN(
							SELECT
								KD_GDG,
								KD_DISTRIK,
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								GUDANG_SIDIGI
							WHERE
								DELETE_MARK = '0'
							GROUP BY
								KD_GDG,
								KD_DISTRIK) GDG ON
							TO_NUMBER(CS.KODE_SHIPTO) = TO_NUMBER(GDG.KD_GDG)
						GROUP BY
							CS.BULAN,
							GDG.KD_DISTRIK) B ON
						A.KD_KOTA = B.KD_DISTRIK
					WHERE
						B.BULAN IS NOT NULL
					GROUP BY
						A.ID_REGION,
						B.BULAN) Q_KAP ON
					Q_QTY.BULAN = Q_KAP.BULAN
					AND Q_QTY.ID_REGION = Q_KAP.ID_REGION
				GROUP BY
					$dfr2
			 		Q_QTY.ID_DATA,
					Q_QTY.BULAN) PIVOT ( SUM (LVL_STOK) FOR BULAN IN ( $month_in ) )

		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_cus = $this->db2->query($sql_fix)->result_array();

		foreach ($jml_cus as $jml) {

			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			if ($nas == 'nas') {

				$dt_arr[] = array(
					'ID_REGION'	=> 'ALL',
					'ID_DATA'	=> $jml['ID_DATA'],
					"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
					"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
					"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
					"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
					"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
					"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
					"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
					"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
					"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
					"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
					"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
					"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
				);

			} else{

				$dt_arr[] = array(
					'ID_REGION'	=> $jml['ID_REGION'],
					'ID_DATA'	=> $jml['ID_DATA'],
					"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
					"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt2,
					"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt3,
					"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt4,
					"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt5,
					"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt6,
					"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt7,
					"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt8,
					"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt9,
					"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt10,
					"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt11,
					"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt12,
				);

			}

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
	public function get_jmlsalesregional($nas=null){

		$month_in = $this->get_month();

		$awal = date('Y0101');
		$akhir = date('Ymd', strtotime('-1 days'));

		$dfr1 = "ID_REGION,";
		$dfr2 = "ID_REGION,";

		if ($nas == 'nas') {
			$dfr1 = "";
			$dfr2 = "";
		}

		// print_r('<pre>');
		// print_r($month_in);exit;

		$sql_fix = "
			SELECT
				*
			FROM
				(
				SELECT
					ID_REGION,
					ID_DATA,
					BULAN,
					NVL(SUM(JML_SALES), 0) AS JML_SALES
				FROM
					(
					SELECT
						A.ID_REGION,
						'15' AS ID_DATA,
						C.BULAN,
						CASE
							WHEN C.BULAN = '01' THEN B.JML_SALES_THN_LALU + NVL(C.JML_SALES, 0)
							ELSE NVL(C.JML_SALES, 0)
						END AS JML_SALES
					FROM
						(
						SELECT
							DISTINCT(REGION_ID) AS ID_REGION
						FROM
							HIRARCKY_CRM_SALES_GSM
						WHERE
							REGION_ID IN ('1',
							'2',
							'3',
							'4')) A
					LEFT JOIN (
						SELECT
							RG.ID_REGION,
							COUNT(*) AS JML_SALES_THN_LALU
						FROM
							(
							SELECT
								ID_USER,
								TO_CHAR(CREATED_AT, 'MM') AS BULAN
							FROM
								CRMNEW_USER
							WHERE
								ID_JENIS_USER = '1015'
								AND DELETED_MARK = '0'
								AND TO_CHAR(CREATED_AT, 'YYYYMMDD') < '$awal' ) DT
						LEFT JOIN (
							SELECT
								DISTINCT(ID_SALES) AS ID_SALES,
								REGION_ID AS ID_REGION
							FROM
								HIRARCKY_CRM_SALES_GSM) RG ON
							DT.ID_USER = RG.ID_SALES
						WHERE
							RG.ID_REGION IN ('1',
							'2',
							'3',
							'4')
						GROUP BY
							RG.ID_REGION ) B ON
						A.ID_REGION = B.ID_REGION
					LEFT JOIN (
						SELECT
							DT.BULAN,
							RG.ID_REGION,
							COUNT(*) AS JML_SALES
						FROM
							(
							SELECT
								ID_USER,
								TO_CHAR(CREATED_AT, 'MM') AS BULAN
							FROM
								CRMNEW_USER
							WHERE
								ID_JENIS_USER = '1015'
								AND DELETED_MARK = '0'
								AND TO_CHAR(CREATED_AT, 'YYYYMMDD') BETWEEN '$awal' AND '$akhir' ) DT
						LEFT JOIN (
							SELECT
								DISTINCT(ID_SALES) AS ID_SALES,
								REGION_ID AS ID_REGION
							FROM
								HIRARCKY_CRM_SALES_GSM) RG ON
							DT.ID_USER = RG.ID_SALES
						WHERE
							RG.ID_REGION IN ('1',
							'2',
							'3',
							'4')
						GROUP BY
							DT.BULAN,
							RG.ID_REGION ) C ON
						A.ID_REGION = C.ID_REGION )
				GROUP BY
					ID_REGION,
					ID_DATA,
					BULAN ) PIVOT ( SUM (JML_SALES) FOR BULAN IN ( $month_in ) )

		"; 

		// print_r('<pre>');
		// print_r($sql_fix);exit;

		$jml_sales = $this->db->query($sql_fix)->result_array();


		foreach ($jml_sales as $jml) {
			$dt1 =  0;
			if (isset($jml["'01'"])) {
				$dt1 =  $jml["'01'"];
			}

			$dt2 =  0;
			if (isset($jml["'02'"])) {
				$dt2 =  $jml["'02'"];
			}

			$dt3 =  0;
			if (isset($jml["'03'"])) {
				$dt3 =  $jml["'03'"];
			}

			$dt4 =  0;
			if (isset($jml["'04'"])) {
				$dt4 =  $jml["'04'"];
			}

			$dt5 =  0;
			if (isset($jml["'05'"])) {
				$dt5 =  $jml["'05'"];
			}

			$dt6 =  0;
			if (isset($jml["'06'"])) {
				$dt6 =  $jml["'06'"];
			}

			$dt7 =  0;
			if (isset($jml["'07'"])) {
				$dt7 =  $jml["'07'"];
			}

			$dt8 =  0;
			if (isset($jml["'08'"])) {
				$dt8 =  $jml["'08'"];
			}

			$dt9 =  0;
			if (isset($jml["'09'"])) {
				$dt9 =  $jml["'09'"];
			}

			$dt10 =  0;
			if (isset($jml["'10'"])) {
				$dt10 =  $jml["'10'"];
			}

			$dt11 =  0;
			if (isset($jml["'11'"])) {
				$dt11 =  $jml["'11'"];
			}

			$dt12 =  0;
			if (isset($jml["'12'"])) {
				$dt12 =  $jml["'12'"];
			}

			if ($nas == 'nas') {

				$dt_arr[] = array(
					'ID_DATA'	=> $jml['ID_DATA'],
					"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
					"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2,
					"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3,
					"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4,
					"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5,
					"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6,
					"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7,
					"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8,
					"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9,
					"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10,
					"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11,
					"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11 + $dt12,
				);

			} else{

				$dt_arr[] = array(
					'ID_REGION'	=> $jml['ID_REGION'],
					'ID_DATA'	=> $jml['ID_DATA'],
					"'".str_pad(1,2,"0",STR_PAD_LEFT)."'"	=> $dt1,
					"'".str_pad(2,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2,
					"'".str_pad(3,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3,
					"'".str_pad(4,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4,
					"'".str_pad(5,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5,
					"'".str_pad(6,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6,
					"'".str_pad(7,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7,
					"'".str_pad(8,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8,
					"'".str_pad(9,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9,
					"'".str_pad(10,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10,
					"'".str_pad(11,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11,
					"'".str_pad(12,2,"0",STR_PAD_LEFT)."'"	=> $dt1 + $dt2 + $dt3 + $dt4 + $dt5 + $dt6 + $dt7 + $dt8 + $dt9 + $dt10 + $dt11 + $dt12,
				);
				
			}

			// print_r('<pre>');
			// print_r($dt_arr);exit;

		}

		// print_r('<pre>');
		// print_r($dt_arr);exit;

		return $dt_arr;

	}
	
}

?>