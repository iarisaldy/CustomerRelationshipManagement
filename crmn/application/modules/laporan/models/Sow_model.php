<?php
if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');
 
class Sow_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('3pl', TRUE);
	}
	
	public function Get_sidigi(){
		
	}
	
	public function User_distributor($id_user=null, $jenis=null){
		$sql ="
			SELECT
			KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR

			FROM HIRARCKY_GSM_SALES_DISTRIK
			
			
		";
		
		if($jenis!=null){
			if($jenis=='SO'){
				$sql .= " WHERE ID_SO='$id_user' ";
			}
			else if($jenis=='SM'){
				$sql .= " WHERE ID_SM='$id_user' ";
			}
			else if($jenis=='SSM'){	
				$sql .= " WHERE ID_SSM='$id_user' ";
			}
			else if($jenis=='GSM'){
				$sql .= " WHERE ID_GSM='$id_user' ";
			}
			else if($jenis=='DIS'){
				$sql .= "  WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
			}
			else if($jenis=='SPC'){
				$sql .= "  WHERE REGION_ID IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
			}
			
		}

		$sql .= " GROUP BY KODE_DISTRIBUTOR,
			NAMA_DISTRIBUTOR ";
		
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
	public function User_TSO($id_user=null){
		$sql ="
			SELECT
			UT.NO_USER_TSO,
			UT.ID_USER,
			UT.ID_TSO,
			U.NAMA
			FROM CRMNEW_USER_TSO UT
			LEFT JOIN CRMNEW_USER U ON UT.ID_TSO=U.ID_USER
			WHERE UT.DELETE_MARK='0'			
		";
		
		if($id_user!=null){
			$sql .= " AND UT.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result();
	}
	public function listASM($id_user=null){
        $sql ="
            SELECT
            CU.ID_USER,
            CU.NAMA
            FROM CRMNEW_USER CU
            WHERE CU.DELETED_MARK='0'
            AND CU.ID_JENIS_USER='1011'              
        ";
        
        if($id_user!=null){
            $sql .= " AND CU.ID_USER NOT IN (SELECT ID_ASM FROM CRMNEW_USER_ASM WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
        }

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
    public function GET_SALES($id_user=null, $DIS=NULL){
        $sql ="
            SELECT
			ID_SALES,
			NAMA_SALES

			FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE ID_SO='$id_user'
        ";
        if($DIS!=null){
        	 $sql .= " AND KODE_DISTRIBUTOR='$DIS' ";
        }

         $sql .= " GROUP BY ID_SALES,
			NAMA_SALES ";
        
        return $this->db->query($sql)->result();
    }
	public function get_sd($id_ud){
		
		$sql ="
            SELECT
			ID_SALES,
			NAMA_SALES

			FROM HIRARCKY_GSM_TO_DISTRIBUTOR
			WHERE KODE_DISTRIBUTOR IN (SELECT
			KODE_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR
			WHERE DELETE_MARK='0'
			AND ID_USER='$id_ud')
			
			GROUP BY ID_SALES,
			NAMA_SALES
        ";
        
        return $this->db->query($sql)->result();
	}

	
	public function distributor_user($id_user=null, $jenis=null){
		$sql ="
			SELECT
			KODE_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK		
		";

		if($jenis!=null){
			if($jenis=='SO'){
				$sql .= " WHERE ID_SO='$id_user' ";
			}
			else if($jenis=='SM'){
				$sql .= " WHERE ID_SM='$id_user' ";
			}
			else if($jenis=='SSM'){	
				$sql .= " WHERE ID_SSM='$id_user' ";
			}
			else if($jenis=='GSM'){
				$sql .= " WHERE ID_GSM='$id_user' ";
			}
			else if($jenis=='DIS'){
				$sql .= "  WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
			}
			else if($jenis=='SPC'){
				$sql .= "  WHERE REGION_ID IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
			}
		}

		$sql .= " GROUP BY KODE_DISTRIBUTOR ";
		//echo $sql;
		return $this->db->query($sql)->result_array();
	}
	public function distrik_user($id_user=null, $jenis=null){
		$sql ="
			SELECT
			ID_DISTRIK
			FROM HIRARCKY_GSM_SO_DISTRIK		
		";

		if($jenis!=null){
			if($jenis=='SO'){
				$sql .= " WHERE ID_SO='$id_user' ";
			}
			else if($jenis=='SM'){
				$sql .= " WHERE ID_SM='$id_user' ";
			}
			else if($jenis=='SSM'){
				$sql .= " WHERE ID_SSM='$id_user' ";
			}
			else if($jenis=='GSM'){
				$sql .= " WHERE ID_GSM='$id_user' ";
			}
			else if($jenis=='SPC'){
				$sql .= "WHERE REGION_ID IN (SELECT
							ID_REGION
							FROM CRMNEW_USER_REGION
							WHERE DELETE_MARK='0'
							AND ID_USER='$id_user') ";
			}
		}

		$sql .= " GROUP BY ID_DISTRIK ";
		
		return $this->db->query($sql)->result_array();
	}
	public function Customer_user($id_user=null){
		
		$sql ="
			SELECT
			KD_CUSTOMER
			FROM MAPPING_TOKO_SALES
		";
		
		if($id_user!=null){
			$sql .= " WHERE ID_SALES='$id_user' ";
		}

		$sql .= " GROUP BY KD_CUSTOMER ";
		//echo $sql;
		return $this->db->query($sql)->result_array();
	}

	public function get_data_sidigi($tahun,$bulan, $id_user, $prov=null, $region=null, $JENIS=null)
	{	
		$dis_user = $this->distributor_user($id_user, $JENIS);
		$n=1;
		$fild = '';
		foreach($dis_user as $d){
			
			if(count($dis_user)>$n){
				$fild .= "'". $d['KODE_DISTRIBUTOR']."',";
			}
			else {
				$fild .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;		
		}
		
		//exit;
		$distrik_user = $this->distrik_user($id_user, $JENIS);
		$n=1;
		$fild2 = '';
		foreach($distrik_user as $d){
			
			if(count($distrik_user)>$n){
				$fild2 .= "'". $d['ID_DISTRIK']."',";
			}
			else {
				$fild2 .= "'". $d['ID_DISTRIK']."'";
			}
			$n=$n+1;		
		}

		$sql =" 
				SELECT
				TO_CHAR(TGL_SPJ, 'YYYY') AS TAHUN,
				TO_CHAR(TGL_SPJ, 'MM') AS BULAN,
				KD_CUSTOMER,
				NM_CUSTOMER,
				KD_DISTRIBUTOR,
				NM_DISTRIBUTOR,
				KD_PRODUK,
				NM_PRODUK,
				KD_DISTRIK,
				NM_DISTRIK,
				KD_AREA,
				NM_AREA,
				KD_PROVINSI,
				NM_PROVINSI,
				REGION,
				SUM(QTY_SELL_OUT) AS TOTAL_PJ

				FROM V_SELL_OUT_TO_CRM
				WHERE TO_CHAR(TGL_SPJ, 'YYYY')='2020'
				AND TO_CHAR(TGL_SPJ, 'MM')='04'
				AND KD_CUSTOMER IS NOT NULL
				AND KD_DISTRIBUTOR IS NOT NULL
				AND KD_DISTRIBUTOR IN ($fild)
				AND KD_DISTRIK IN ($fild2)

				";
				
		if($region!=null){
            $sql .= " AND REGION='$region' ";
        }
		if($prov!=null){
            $sql .= " AND KD_PROVINSI='$prov' ";
        }
		 $sql .= " GROUP BY TO_CHAR(TGL_SPJ, 'YYYY'),
				TO_CHAR(TGL_SPJ, 'MM'),
				KD_CUSTOMER,
				NM_CUSTOMER,
				KD_DISTRIBUTOR,
				NM_DISTRIBUTOR,
				KD_PRODUK,
				NM_PRODUK,
				KD_DISTRIK,
				NM_DISTRIK,
				KD_AREA,
				NM_AREA,
				KD_PROVINSI,
				NM_PROVINSI,
				REGION ";
		//echo $sql;

		return $this->db2->query($sql)->result_array();
		
	}
	
	public function Data_kapasitas_toko($id_user, $region, $id_prov, $jenis){
		$sql ="
			SELECT
			ID_CUSTOMER, KAPASITAS_JUAL AS KAPASITAS_ZAK
			FROM CRMNEW_CUSTOMER
			WHERE DELETE_MARK='0'
            AND KAPASITAS_JUAL IS NOT NULL
			AND ID_CUSTOMER IN (SELECT ID_CUSTOMER FROM M_CUSTOMER WHERE ID_DISTRIK IN (SELECT
						ID_DISTRIK
						FROM HIRARCKY_GSM_SALES_DISTRIK "; 	

		if($jenis!=null){
			if($jenis=='SO'){
				$sql .= " WHERE ID_SO='$id_user' ";
				$sql .= " GROUP BY  ID_DISTRIK)) ";
			}
			else if($jenis=='SM'){
				$sql .= " WHERE ID_SM='$id_user' ";
				$sql .= " GROUP BY  ID_DISTRIK)) ";
			}
			else if($jenis=='SSM'){	
				$sql .= " WHERE ID_SSM='$id_user' ";
				$sql .= " GROUP BY  ID_DISTRIK)) ";
			}
			else if($jenis=='GSM'){
				$sql .= " WHERE ID_GSM='$id_user' ";
				$sql .= " GROUP BY  ID_DISTRIK)) ";
			}
			else if($jenis=='DIS'){
				$sql .= "  WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
				$sql .= " GROUP BY  ID_DISTRIK)) ";
			}
			else if($jenis=='SPC'){
				$sql .= "  WHERE REGION_ID IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
				$sql .= " GROUP BY  ID_DISTRIK)) ";
			}
			else {
				$sql .= " GROUP BY  ID_DISTRIK)) ";
			}
		}
		
		
		
		return $this->db->query($sql)->result_array();
	}
	public function get_data_hsd_pj($tahun, $bulan, $id_user, $region, $id_prov, $jenis){
		$sql ="
			SELECT
			ID_TOKO,
			NAMA_TOKO,
			NAMA_DISTRIBUTOR,
			ID_DISTRIK,
			NAMA_DISTRIK,
			KD_AREA,
			NAMA_AREA,
			ID_PROVINSI,
			NAMA_PROVINSI,
			REGION_ID,
			ID_PRODUK,
			NAMA_PRODUK,
			SUM(VOLUME_PENJUALAN) AS VOLUME_PENJUALAN
			FROM R1_HASIL_SURVEY_SD
			WHERE VOLUME_PENJUALAN IS NOT NULL
			AND TAHUN='$tahun'
			AND BULAN='$bulan' "; 	

		if($jenis!=null){
			if($jenis=='SO'){
				$sql .= " AND ID_SO='$id_user' ";
			}
			else if($jenis=='SM'){
				$sql .= " AND ID_SM='$id_user' ";
			}
			else if($jenis=='SSM'){	
				$sql .= " AND ID_SSM='$id_user' ";
			}
			else if($jenis=='GSM'){
				$sql .= " AND ID_GSM='$id_user' ";
			}
			else if($jenis=='DIS'){
				$sql .= "  AND KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
			}
			else if($jenis=='SPC'){
				$sql .= "  AND REGION_ID IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE DELETE_MARK='0' AND ID_USER='$id_user') ";
			}
		}
		
		$sql .= " GROUP BY  ID_TOKO,
					NAMA_TOKO,
					NAMA_DISTRIBUTOR,
					ID_DISTRIK,
					NAMA_DISTRIK,
					KD_AREA,
					NAMA_AREA,
					ID_PROVINSI,
					NAMA_PROVINSI,
					REGION_ID,
					ID_PRODUK,
					NAMA_PRODUK ";
		
		return $this->db->query($sql)->result_array();
	}
	
	
	
	
	
	
	
	
	
	
	public function Get_data_gsm_so($id_user, $jenis=null){
		$sql =" 
				SELECT
				NAMA_GSM,
				NAMA_SSM,
				NAMA_SM,
				ID_SO,
				NAMA_SO,
				ID_DISTRIK
				FROM HIRARCKY_GSM_SALES_DISTRIK
				
				
				";
		if($jenis!=null){
			if($jenis=='SO'){
				$sql .= "WHERE ID_SO='$id_user' ";
			}
			else if($jenis=='SM'){
				$sql .= "WHERE ID_SM='$id_user' ";
			}
			else if($jenis=='SSM'){
				$sql .= "WHERE ID_SSM='$id_user' ";
			}
			else if($jenis=='GSM'){
				$sql .= "WHERE ID_GSM='$id_user' ";
			}
			else if($jenis=='DIS'){
				$sql .= "WHERE KODE_DISTRIBUTOR IN (SELECT
															KODE_DISTRIBUTOR
															FROM CRMNEW_USER_DISTRIBUTOR
															WHERE DELETE_MARK='0'
															AND ID_USER='$id_user') ";
			}
			else if($jenis=='SPC'){
				$sql .= "WHERE REGION_ID IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE DELETE_MARK='0' AND ID_USER='$id_user' ) ";
			}
		}	

		$sql .= " GROUP BY
				NAMA_GSM,
				NAMA_SSM,
				NAMA_SM,
				ID_SO,
				NAMA_SO,
				ID_DISTRIK ";

		return $this->db->query($sql)->result_array();
	}
	public function Get_data_sales_toko($id_user, $jenis=null, $sales=null, $distributor=null){
		
		$sql =" 
				SELECT
				ID_SALES, NAMA,
				KODE_DISTRIBUTOR,
				KD_CUSTOMER,
				NAMA_TOKO,
				ALAMAT
				FROM MAPPING_TOKO_SALES		

				";

		

		if($jenis!=null){
			if($jenis=='SO'){
				$sql .= " WHERE ID_DISTRIK IN (SELECT ID_DISTRIK FROM HIRARCKY_GSM_SO_DISTRIK WHERE ID_SO='$id_user' GROUP BY  ID_DISTRIK ) ";
			}
			else if($jenis=='SM'){
				$sql .= " WHERE ID_DISTRIK IN (SELECT ID_DISTRIK FROM HIRARCKY_GSM_SO_DISTRIK WHERE ID_SM='$id_user' GROUP BY  ID_DISTRIK ) ";
			}
			else if($jenis=='SSM'){
				$sql .= " WHERE ID_DISTRIK IN (SELECT ID_DISTRIK FROM HIRARCKY_GSM_SO_DISTRIK WHERE ID_SSM='$id_user' GROUP BY  ID_DISTRIK ) ";
			}
			else if($jenis=='GSM'){
				$sql .= " WHERE ID_DISTRIK IN (SELECT ID_DISTRIK FROM HIRARCKY_GSM_SO_DISTRIK WHERE ID_GSM='$id_user' GROUP BY  ID_DISTRIK ) ";
			}
			else if($jenis=='DIS'){
				$sql .= " WHERE ID_DISTRIK IN (SELECT ID_DISTRIK 
												FROM HIRARCKY_GSM_SO_DISTRIK 
												WHERE KODE_DISTRIBUTOR IN (SELECT
																			KODE_DISTRIBUTOR
																			FROM CRMNEW_USER_DISTRIBUTOR
																			WHERE DELETE_MARK='0'
																			AND ID_USER='$id_user')
												GROUP BY  ID_DISTRIK ) ";
			}
			else if($jenis=='SPC'){
				$sql .= " WHERE ID_DISTRIK IN (SELECT ID_DISTRIK 
												FROM HIRARCKY_GSM_SALES_DISTRIK 
												WHERE REGION_ID IN (SELECT ID_REGION FROM CRMNEW_USER_REGION WHERE DELETE_MARK='0' AND ID_USER='$id_user' )
												GROUP BY  ID_DISTRIK ) ";
			}
		}

		if($sales!=null){
			$sql .= " AND ID_SALES='$sales' ";
		}
		if($distributor!=null){
			$sql .= " AND KODE_DISTRIBUTOR='$distributor' ";
		}

		

		$sql .= " 
		GROUP BY
		ID_SALES, NAMA,
					KODE_DISTRIBUTOR,
					KD_CUSTOMER,
					NAMA_TOKO,
					ALAMAT ";
					
					//ECHO $sql;

		return $this->db->query($sql)->result_array();
	}























	
	public function get_data_sidigi_rsm($star , $end, $fild)
	{	
		$sql =" 
				SELECT 
					NO_SPJ,
					TGL_SPJ,
					KD_CUSTOMER,
					KD_DISTRIBUTOR,
					NM_DISTRIBUTOR,
					KD_GUDANG,
					NM_GUDANG,
					KD_PRODUK,
					NM_PRODUK,
					ZAK_KG,
					QTY_SELL_OUT,
					HARGA_SELL_OUT,
					HARGA_PER_ZAK,
					CASE AKSES_TOKO WHEN 0 THEN 'ERP DISTRIBUTOR' WHEN 1 THEN 'AKSES TOKO' END AS AKSES_TOKO
				FROM V_SELL_OUT_TO_CRM
				WHERE TGL_SPJ BETWEEN TO_DATE('$star', 'YYYY/MM/DD')AND TO_DATE('$end','YYYY/MM/DD')
				AND KD_CUSTOMER IS NOT NULL
				AND KD_DISTRIBUTOR IS NOT NULL
				AND KD_DISTRIBUTOR IN ($fild) 
				
				";
				//ECHO $sql;
		return $this->db2->query($sql)->result_array();
		
	}
	
	public function get_data_crm($id_tso , $id_distributor = null , $idsales = null)
	{	
		$sql =" 
				SELECT
					MC.ID_SALES,
					MC.NAMA_SALES,
					MC.KODE_DISTRIBUTOR,
					MC.NAMA_DISTRIBUTOR,
					DC.NAMA_TOKO,
					DC.KD_CUSTOMER,
					AC.ALAMAT,
					AC.NAMA_PROVINSI,
					AC.NAMA_AREA,
					AC.NAMA_DISTRIK
				FROM HIRARCKY_GSM_SALES_DISTRIK MC 
				LEFT JOIN MAPPING_TOKO_SALES DC ON MC.ID_SALES = DC.ID_SALES
                LEFT JOIN M_CUSTOMER AC ON DC.KD_CUSTOMER = AC.ID_CUSTOMER
                WHERE MC.ID_SALES IS NOT NULL
                AND MC.NAMA_SALES IS NOT NULL
                AND AC.ID_CUSTOMER IS NOT NULL
				AND MC.ID_SO = '$id_tso'
				";
				
		if($idsales!=null){
            $sql .= " AND MC.ID_SALES = '$idsales' ";
        }
		
		if($id_distributor!=null){
            $sql .= " AND MC.KODE_DISTRIBUTOR = '$id_distributor' ";
        }
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_crm_asm($id_asm , $id_distributor = null , $idsales = null)
	{	
		$sql =" 
				SELECT
					MC.ID_SALES,
					MC.NAMA_SALES AS NM_SALES,
                    MC.ID_SO ,
                    MC.NAMA_SO ,
                    MC.ID_SM ,
                    MC.NAMA_SM,
                    MC.ID_SSM,
                    MC.NAMA_SSM,
                    MC.ID_GSM,
                    MC.NAMA_GSM,
                    MC.REGION_ID,
					MC.KODE_DISTRIBUTOR,
					MC.NAMA_DISTRIBUTOR,
					DC.NAMA_TOKO,
					DC.KD_CUSTOMER,
					AC.ALAMAT,
					AC.NAMA_PROVINSI,
					AC.NAMA_AREA,
					AC.NAMA_DISTRIK
				FROM HIRARCKY_GSM_SALES_DISTRIK MC 
				LEFT JOIN MAPPING_TOKO_SALES DC ON MC.ID_SALES = DC.ID_SALES
                LEFT JOIN M_CUSTOMER AC ON DC.KD_CUSTOMER = AC.ID_CUSTOMER
				WHERE AC.NAMA_TOKO IS NOT NULL
                AND MC.NAMA_SALES IS NOT NULL
				AND MC.ID_SM = '$id_asm'
				";
				
		if($idsales!=null){
            $sql .= " AND MC.ID_USER = '$idsales' ";
        }
		
		if($id_distributor!=null){
            $sql .= " AND MC.KODE_DISTRIBUTOR = '$id_distributor' ";
        }
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_crm_rsm($id_rsm , $id_distributor = null , $idsales = null)
	{	
		$sql =" 
				SELECT
					MC.ID_SALES,
					MC.NAMA_SALES AS NM_SALES,
                    MC.ID_SO ,
                    MC.NAMA_SO ,
                    MC.ID_SM ,
                    MC.NAMA_SM,
                    MC.ID_SSM,
                    MC.NAMA_SSM,
                    MC.ID_GSM,
                    MC.NAMA_GSM,
                    MC.REGION_ID,
					MC.KODE_DISTRIBUTOR,
					MC.NAMA_DISTRIBUTOR,
					DC.NAMA_TOKO,
					DC.KD_CUSTOMER,
					AC.ALAMAT,
					AC.NAMA_PROVINSI,
					AC.NAMA_AREA,
					AC.NAMA_DISTRIK
				FROM HIRARCKY_GSM_SALES_DISTRIK MC 
				LEFT JOIN MAPPING_TOKO_SALES DC ON MC.ID_SALES = DC.ID_SALES
                LEFT JOIN M_CUSTOMER AC ON DC.KD_CUSTOMER = AC.ID_CUSTOMER
				WHERE AC.NAMA_TOKO IS NOT NULL
                AND MC.NAMA_SALES IS NOT NULL
				AND MC.ID_SSM = '$id_rsm'
				";
				
		if($idsales!=null){
            $sql .= " AND MC.ID_USER = '$idsales' ";
        }
		
		if($id_distributor!=null){
            $sql .= " AND MC.KODE_DISTRIBUTOR = '$id_distributor' ";
        }
		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_data_crm_admin($id_distributor =null, $id_region =null, $id_provinsi =null)
	{	
		$sql =" 
				SELECT
					MC.ID_SALES,
					MC.NAMA_SALES AS NM_SALES,
                    MC.ID_SO ,
                    MC.NAMA_SO ,
                    MC.ID_SM ,
                    MC.NAMA_SM,
                    MC.ID_SSM,
                    MC.NAMA_SSM,
                    MC.ID_GSM,
                    MC.NAMA_GSM,
                    MC.REGION_ID,
					MC.KODE_DISTRIBUTOR,
					MC.NAMA_DISTRIBUTOR,
					DC.NAMA_TOKO,
					DC.KD_CUSTOMER,
					AC.ALAMAT,
					AC.NAMA_PROVINSI,
					AC.NAMA_AREA,
					AC.NAMA_DISTRIK
				FROM HIRARCKY_GSM_SALES_DISTRIK MC 
				LEFT JOIN MAPPING_TOKO_SALES DC ON MC.ID_SALES = DC.ID_SALES
                LEFT JOIN M_CUSTOMER AC ON DC.KD_CUSTOMER = AC.ID_CUSTOMER
				WHERE AC.NAMA_TOKO IS NOT NULL
                AND MC.NAMA_SALES IS NOT NULL
				";
		
		if($id_distributor!=null){
            $sql .= " AND MC.KODE_DISTRIBUTOR = '$id_distributor' ";
        }
		
		if($id_region!=null){
            $sql .= " AND MC.REGION_ID = '$id_region' ";
        }
		
		if($id_provinsi!=null){
            $sql .= " AND MC.ID_PROVINSI = '$id_provinsi' ";
        }
		
		return $this->db->query($sql)->result_array();
	}
	
	public function User_dis($id_user=null){
		$sql ="
			SELECT
			UD.KODE_DISTRIBUTOR
			FROM CRMNEW_USER_DISTRIBUTOR UD
			LEFT JOIN CRMNEW_DISTRIBUTOR D ON UD.KODE_DISTRIBUTOR=D.KODE_DISTRIBUTOR
			WHERE UD.DELETE_MARK='0'
		";
		
		if($id_user!=null){
			$sql .= " AND UD.ID_USER='$id_user' ";
		}
		
		return $this->db->query($sql)->result_array();
	}
	
	public function User_dis_asm($id_user=null){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SM = '$id_user'
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function User_dis_rsm($id_user=null){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE ID_SSM = '$id_user'
		";
		
		return $this->db->query($sql)->result_array();
	}
	
	public function User_dis_admin(){
		$sql ="
			SELECT DISTINCT
			KODE_DISTRIBUTOR
			FROM HIRARCKY_GSM_SALES_DISTRIK
			WHERE KODE_DISTRIBUTOR IS NOT NULL
		";
		
		return $this->db->query($sql)->result_array();
	}
	public function get_sales_asm($id_dis,$id_asm)
	{
		$sql =" 
			SELECT
            ID_SALES AS ID_USER,
            NAMA_SALES AS NAMA
			FROM
			HIRARCKY_GSM_SALES_DISTRIK 
			WHERE KODE_DISTRIBUTOR = '$id_dis'
			AND ID_SM = '$id_asm'
			AND NAMA_SALES IS NOT NULL
			GROUP BY
			ID_SALES, NAMA_SALES		
			
		";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_sales_rsm($id_dis,$id_rsm)
	{
		$sql =" 
			SELECT
            ID_SALES AS ID_USER,
            NAMA_SALES AS NAMA
			FROM
			HIRARCKY_GSM_SALES_DISTRIK 
			WHERE KODE_DISTRIBUTOR = '$id_dis'
			AND ID_SSM = '$id_rsm'
		";
		return $this->db->query($sql)->result_array();
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
			$sql .= " AND ID_PROVINSI = '$id_provinsi'";
		}
		
		return $this->db->query($sql)->result();
	}
	
}
?>