<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Penugasan_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
		//$this->db = $this->load->database('crm', TRUE);
    }
    public function checkKunjungan($idSurveyor, $idCustomer, $plannedDate){
        $this->db->select("CRMNEW_KUNJUNGAN_CUSTOMER.ID_KUNJUNGAN_CUSTOMER");
        $this->db->from("CRMNEW_KUNJUNGAN_CUSTOMER");
        $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_USER", $idSurveyor);
        $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.ID_TOKO", $idCustomer);
        $this->db->where("TO_CHAR(CRMNEW_KUNJUNGAN_CUSTOMER.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') = ", $plannedDate);
        $this->db->where("CRMNEW_KUNJUNGAN_CUSTOMER.DELETED_MARK", "0");

        $canvasing = $this->db->get();
        if($canvasing->num_rows() > 0){
            return $canvasing->result();
        } else {
            return false;
        }
    }
    public function addCanvasing($data, $plannedDate){
        $date = date('d-m-Y H:i:s');
        $this->db->set('CREATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $this->db->set('TGL_RENCANA_KUNJUNGAN',"TO_DATE('".$plannedDate."','yyyy/mm/dd')", false);
        $canvasing = $this->db->insert("CRMNEW_KUNJUNGAN_CUSTOMER", $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function List_kunjungan_sales_tso($tso=null, $tanggalawal ,$tanggalselesai, $kd_distributor=null, $sales=null){
        $sql ="
            SELECT
            ID_KUNJUNGAN_CUSTOMER,
            ID_USER,
            KODE_DISTRIBUTOR,
            NAMA_DISTRIBUTOR,
            NAMA_USER,
            ID_TOKO,
            NAMA_TOKO,
            ALAMAT,
            ID_PROVINSI,
            ID_AREA,
            ID_DISTRIK,
            ID_KECAMATAN,
            NAMA_KECAMATAN,
            NAMA_DISTRIK,
            LOKASI_LATITUDE,
            LOKASI_LONGITUDE,
            TGL_RENCANA_KUNJUNGAN,
            CHECKIN_TIME,
            CHECKIN_LATITUDE,
            CHECKIN_LONGITUDE,
            CHECKOUT_TIME,
            CHECKOUT_LATITUDE,
            CHECKOUT_LONGITUDE,
            SELESAI,
            MULAI,
            WAKTU_KUNJUNGAN,
            JAM,
            MENIT,
            KETERANGAN
            
            FROM T_KUNJUNGAN_SALES_KE_TOKO
            WHERE ID_USER IN (SELECT ID_SALES FROM SALES_TO_SO WHERE ID_SO='$tso')
            AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '$tanggalawal' AND '$tanggalselesai'           
            
        ";
        if($kd_distributor!=null){
            $sql .= " AND KODE_DISTRIBUTOR='$kd_distributor' ";
        }

        if($sales!=null){
            $sql .= " AND ID_USER='$sales' ";
        }
        // echo $sql;
        return $this->db->query($sql)->result();
    }
    public function listtokoSALES($id_user=null, $id_sales=null){
        
        $sql =" 
            SELECT
            TS.NO_TOKO_SALES,
            TS.ID_SALES,
            TS.NAMA AS NAMA_SALES,
            TS.KD_CUSTOMER,
            TS.NAMA_TOKO,
            TS.NM_KOTA AS KOTA,
            TS.ALAMAT,
            TS.KODE_DISTRIBUTOR AS ID_DISTRIBUTOR,
            TS.NAMA_DISTRIBUTOR
            FROM MAPPING_TOKO_SALES TS
			
        ";
        if($id_sales!=null){
            $sql .= " WHERE TS.ID_SALES='$id_sales' ";
        }
        // ECHO $sql;

        return $this->db->query($sql)->result();        
    }
    public function User_distributor($id_user=null){
        $sql ="
            SELECT
            KODE_DISTRIBUTOR,
            NAMA_DISTRIBUTOR
            FROM SO_DISTRIBUTOR
            
        ";
        
        if($id_user!=null){
            $sql .= " WHERE ID_SO='$id_user' ";
        }
        
        return $this->db->query($sql)->result();
    }
    public function User_SALES($id_user=null){
        $sql ="
            SELECT
            US.ID_SALES,
            US.NAMA_SALES AS NAMA
            FROM SALES_TO_SO US
        ";
        
        if($id_user!=null){
            $sql .= " WHERE US.ID_SO='$id_user' ";
        }
        
        return $this->db->query($sql)->result();
    }
    public function Toko_sales_tso($id_user=null){
        $sql ="
            SELECT
            C.ID_CUSTOMER,
            C.NAMA_TOKO,
            C.ALAMAT,
            C.ID_DISTRIBUTOR,
            D.NAMA_DISTRIBUTOR,
            C.ID_AREA
            FROM CRMNEW_CUSTOMER C
            LEFT JOIN CRMNEW_DISTRIBUTOR D ON C.ID_DISTRIBUTOR=D.KODE_DISTRIBUTOR
            WHERE C.DELETE_MARK='0'
            AND C.FLAG='SBI'
            AND C.ID_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM CRMNEW_USER_DISTRIBUTOR WHERE DELETE_MARK='0' AND ID_USER='$id_user' )
            AND C.ID_AREA IN 
                                (
                                    SELECT
                                    KD_AREA
                                    FROM CRMNEW_M_AREA 
                                    WHERE ID_AREA=(SELECT ID_AREA FROM CRMNEW_USER_AREA WHERE DELETE_MARK='0' AND ID_USER='$id_user')
                                )
            AND C.ID_CUSTOMER NOT IN (SELECT KD_CUSTOMER FROM CRMNEW_TOKO_SALES WHERE DELETE_MARK='0' AND ID_TSO='$id_user')
                                
        ";
        
        return $this->db->query($sql)->result();   
    }
    public function addAssign($data){
        $this->db->insert_batch("CRMNEW_TOKO_SALES", $data);
        if($this->db->affected_rows()){
            return $data;
        } else {
            return false;
        }
    }

    public function listAssignSALES($id_user){
        
        $sql =" 
            SELECT
                TS.NO_TOKO_SALES,
                TS.ID_SALES,
                CU.NAMA AS NAMA_SALES,
                TS.KD_CUSTOMER,
                C.NAMA_TOKO,
                C.NAMA_DISTRIK AS KOTA,
                C.NAMA_KECAMATAN,
                C.ALAMAT,
                C.ID_DISTRIBUTOR,
                D.NAMA_DISTRIBUTOR,
                TS.ID_TSO,
                CT.NAMA AS NAMA_TSO
            FROM CRMNEW_TOKO_SALES TS
            LEFT JOIN CRMNEW_USER CU ON TS.ID_SALES=CU.ID_USER
                AND CU.DELETED_MARK='0'
            LEFT JOIN CRMNEW_USER CT ON TS.ID_TSO=CT.ID_USER
                AND CT.DELETED_MARK='0'
            LEFT JOIN CRMNEW_CUSTOMER C ON TS.KD_CUSTOMER=C.ID_CUSTOMER
                AND C.DELETE_MARK='0' AND C.FLAG='SBI'
            LEFT JOIN CRMNEW_DISTRIBUTOR D ON C.ID_DISTRIBUTOR=D.KODE_DISTRIBUTOR
            WHERE TS.DELETE_MARK='0'
            AND TS.ID_TSO='$id_user'
        ";
        // ECHO $sql;

        return $this->db->query($sql)->result();        
    }
    public function deleteAssign($idAssign, $data){
        $date = date('Y-m-d H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('".$date."','yyyy-mm-dd hh24:mi:ss')", false);
        $this->db->where("NO_TOKO_SALES", $idAssign)->update("CRMNEW_TOKO_SALES", $data);
        if($this->db->affected_rows()){
            return $data;
        } else {
            return false;
        }
    }
    
    public function List_kunjungan_sales_sequence($tso=null, $tanggalawal ,$tanggalselesai, $kd_distributor=null, $sales=null){
        $sql ="
            SELECT
            ID_KUNJUNGAN_CUSTOMER,
            ID_USER,
            KODE_DISTRIBUTOR,
            NAMA_DISTRIBUTOR,
            NAMA_USER,
            ID_TOKO,
            NAMA_TOKO,
            ALAMAT,
            ID_PROVINSI,
            ID_AREA,
            ID_DISTRIK,
            ID_KECAMATAN,
            NAMA_KECAMATAN,
            NAMA_DISTRIK,
            LOKASI_LATITUDE,
            LOKASI_LONGITUDE,
            TGL_RENCANA_KUNJUNGAN,
            CHECKIN_TIME,
            CHECKIN_LATITUDE,
            CHECKIN_LONGITUDE,
            CHECKOUT_TIME,
            CHECKOUT_LATITUDE,
            CHECKOUT_LONGITUDE,
            SELESAI,
            MULAI,
            WAKTU_KUNJUNGAN,
            JAM,
            MENIT,
            KETERANGAN,
            SEQUENCE
            FROM T_KUNJUNGAN_SALES_KE_TOKO
            WHERE KODE_DISTRIBUTOR IN (SELECT KODE_DISTRIBUTOR FROM SO_DISTRIBUTOR WHERE ID_SO='$tso')
            AND ID_USER IN (SELECT ID_SALES FROM SALES_TO_SO WHERE ID_SO='$tso')
            AND TO_CHAR(TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD') BETWEEN '$tanggalawal' AND '$tanggalselesai'
           
        ";
        if($kd_distributor!=null){
            $sql .= " AND KODE_DISTRIBUTOR='$kd_distributor' ";
        }

        if($sales!=null){
            $sql .= " AND ID_USER='$sales' ";
        }
        
        $sql .= " ORDER BY SEQUENCE ASC";
        // echo $sql;
        return $this->db->query($sql)->result();
		
		
    }

    public function setSequenceKunjungan($dt_idKunjungan, $dt_sequence, $idUser){
        $sql = "
            UPDATE CRMNEW_KUNJUNGAN_CUSTOMER SET 
                SEQUENCE = $dt_sequence,
                SEQUENCE_CREATE_BY = $idUser,
                SEQUENCE_CREATE_DATE = SYSDATE
            WHERE 
                ID_KUNJUNGAN_CUSTOMER = $dt_idKunjungan
        ";
        
        $hasil = $this->db->query($sql);
		return $hasil;
    }
    
}
?>