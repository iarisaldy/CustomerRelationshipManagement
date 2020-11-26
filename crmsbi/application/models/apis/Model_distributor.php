<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}
    
    
    class Model_distributor extends CI_Model {
		
		public function get_data_distributor(){
			
			$sql ="
				SELECT
				KODE_DISTRIBUTOR,
				NAMA_DISTRIBUTOR
				FROM CRMNEW_DISTRIBUTOR
			";
			return $this->db->query($sql)->result_array();
		}
                public function get_data_program_theday($user, $start, $limit){
                    
                    $SQL = " SELECT
                                cu.id_user,
                                cu.id_jenis_user,
                                ud.kode_distributor
                                FROM CRMNEW_USER CU
                                LEFT JOIN CRMNEW_USER_DISTRIBUTOR UD ON CU.ID_USER=UD.ID_USER
                                WHERE cu.deleted_mark=0
                                AND cu.id_user='$user'
                            ";
                    
                    $JENIS_USER =  $this->db->query($SQL)->result_array();
                    
                    $status = null;
                    
                    if(count($JENIS_USER)==1){
                        $distributor = $JENIS_USER[0]['KODE_DISTRIBUTOR'];
                        
                        if($JENIS_USER[0]['ID_JENIS_USER']=='1003'){
                            $bql= " 
                                    SELECT
                                    *
                                    FROM 
                                    (
                                        SELECT 
                                        ID_PROGRAM,
                                        JUDUL_PROGRAM,
                                        DETAIL_PROGRAM,
                                        CREATE_AT,
                                        CREATE_BY,
                                        UPDATE_AT,
                                        UPDATE_BY,
                                        DELETE_MARK,
                                        PIC_PROGRAM,
                                        TO_CHAR(END_DATE, 'YYYY-MM-DD') AS END_DATE,
                                        TO_CHAR(START_DATE, 'YYYY-MM-DD') AS START_DATE,
                                        KODE_DISTRIBUTOR,
                                        ROWNUM AS BARIS
                                        FROM CRMNEW_PROGRAM_THEDAY
                                        where delete_mark=0
                                        and kode_distributor='$distributor'
                                        and PIC_PROGRAM='1002'
                                        and rownum < '$limit'
                                    )
                                    WHERE BARIS >='$start'
                            ";
                        }
                        else {
                            $bql= " 
                                SELECT
                                    *
                                    FROM 
                                    (
                                        SELECT 
                                        ID_PROGRAM,
                                        JUDUL_PROGRAM,
                                        DETAIL_PROGRAM,
                                        CREATE_AT,
                                        CREATE_BY,
                                        UPDATE_AT,
                                        UPDATE_BY,
                                        DELETE_MARK,
                                        PIC_PROGRAM,
                                        TO_CHAR(END_DATE, 'YYYY-MM-DD') AS END_DATE,
                                        TO_CHAR(START_DATE, 'YYYY-MM-DD') AS START_DATE,
                                        KODE_DISTRIBUTOR,
                                        ROWNUM AS BARIS
                                        FROM CRMNEW_PROGRAM_THEDAY
                                        where delete_mark=0
                                        and kode_distributor='$distributor' OR kode_distributor is null
                                        and rownum < '$limit'
                                    )
                                    WHERE BARIS >='$start'
                            ";
                        }
                        
                        $status   =   $this->db->query($bql)->result_array();
                    }
                    return $status;
                }
        
    }
?>