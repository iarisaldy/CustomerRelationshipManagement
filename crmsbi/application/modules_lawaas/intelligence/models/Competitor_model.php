<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Competitor_model extends CI_Model {

    var $table = 'SCM_MI_M_FASILITAS';
    var $column_search = array('NAMA');
    var $table1 = 'SCM_MI_PRSH_FASILITAS';
    var $column_search1 = array('NAMA_PERUSAHAAN', 'JENIS_FASILITAS', 'NAMA_FASILITAS');
    var $table2 = 'SCM_MI_PRSH_INFORMASI';
    var $column_search2 = array('NAMA_PERUSAHAAN', 'INFO');

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

//================ FUNCTION MENAMPILKAN DAFTAR NAMA PERUSAHAAN ================\\

    function getPerusahaan() {
        $this->db->from("ZREPORT_MS_PERUSAHAAN");
        //$this->db->where("STATUS", 0);
        $data = $this->db->get();
        return $data->result_array();
    }

//=================== FUNCTION MENAMPILKAN JENIS FASILITAS ===================\\

    function getFasilitas() {
        $this->db->from("SCM_MI_M_FASILITAS");
        $this->db->where('STATUS', 0);
        $data = $this->db->get();
        return $data->result_array();
    }

//============== FUNCTION MENAMPILKAN FOTO FASILITAS PERUSAHAAN ==============\\

    function getFoto() {
        $this->db->from("SCM_MI_PRSH_FOTO");
        $this->db->where('STATUS', 0);
        $data = $this->db->get();
        return $data->result_array();
    }

//============ FUNCTION MENAMPILKAN INFORMASI FASILITAS PERUSAHAAN ============\\

    function getInfo() {
        $data = $this->db->query("select * from SCM_MI_PRSH_INFO ORDER BY ID ASC");
        return $data->result_array();
    }

//================ FUNCTION MENAMPILKAN FASILITAS PERUSAHAAN ================\\

    function getDataFasilitas() {
        $data = $this->db->query("SELECT
                                        TB1.ID,
                                        TB1.KODE_PERUSAHAAN,
                                        TB3.NAMA_PERUSAHAAN,
                                        TB1.FASILITAS KODE_FASILITAS,
                                        TB2.NAMA FASILITAS,
                                        TB1.NAMA NAMA_FASILITAS,
                                        TB1.LATITUDE,
                                        TB1.LONGITUDE,
                                        TB1.STATUS,
                                        TB1.MARKER
                                FROM
                                        SCM_MI_PRSH_FASILITAS TB1
                                LEFT JOIN SCM_MI_M_FASILITAS TB2 ON TB1.FASILITAS = TB2.ID
                                LEFT JOIN ZREPORT_MS_PERUSAHAAN TB3 ON TB1.KODE_PERUSAHAAN = TB3.KODE_PERUSAHAAN
                                WHERE TB1.STATUS=0 AND TB1.STATUS_FASILITAS=0");
        return $data->result_array();
    }

//====================== FUNCTION MENAMPILKAN PROVINSI ======================\\

    function getProv() {
        $data = $this->db->query("select NM_PROV_1, LATITUDE, LONGITUDE from ZREPORT_M_PROVINSI where LATITUDE IS NOT NULL AND LATITUDE IS NOT NULL ORDER BY NM_PROV_1 ASC");
        return $data->result();
    }

//====================== FUNCTION MENAMPILKAN INFORMASI ======================\\

    function getNews() {
        $data = $this->db->query("SELECT
	ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN,
	SCM_MI_M_FASILITAS.NAMA AS JENIS_FASILITAS,
	SCM_MI_PRSH_FASILITAS.NAMA AS NAMA_FASILITAS,
	SCM_MI_PRSH_LOG.CREATE_BY,
	UPPER (
		SUBSTR (
			SCM_MI_PRSH_LOG.INFO,
			1,
			1
		)
	) || SUBSTR (
		SCM_MI_PRSH_LOG.INFO,
		2
	) AS KALIMAT,
	TO_CHAR (
		SCM_MI_PRSH_LOG.CREATE_DATE,
		'DD-MM-YYYY HH24:MI:SS'
	) AS WAKTU,
	TO_CHAR (
		SCM_MI_PRSH_LOG.CREATE_DATE,
		'DD-MM-YYYY'
	) AS TANGGAL,
	SCM_MI_PRSH_FASILITAS.LATITUDE,
	SCM_MI_PRSH_FASILITAS.LONGITUDE
FROM
	ZREPORT_MS_PERUSAHAAN,
	SCM_MI_M_FASILITAS,
	SCM_MI_PRSH_FASILITAS,
	SCM_MI_PRSH_LOG
WHERE
	SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN = ZREPORT_MS_PERUSAHAAN.KODE_PERUSAHAAN
AND SCM_MI_PRSH_FASILITAS.FASILITAS = SCM_MI_M_FASILITAS. ID
AND SCM_MI_PRSH_LOG.ID_PRSH_FASILITAS = SCM_MI_PRSH_FASILITAS. ID
AND ROWNUM <= 100
ORDER BY
	SCM_MI_PRSH_LOG. ID DESC");
        return $data->result_array();
    }

//================= FUNCTION  HITUNG TOTAL INFORMASI HARI INI =================\\

    function countNews() {
        $data = $this->db->query("SELECT 
                                        COUNT (SCM_MI_PRSH_LOG.INFO) AS TOTAL
                                  FROM 
                                        SCM_MI_PRSH_LOG,
                                        SCM_MI_PRSH_FASILITAS
                                  WHERE 
                                        SCM_MI_PRSH_LOG.ID_PRSH_FASILITAS=SCM_MI_PRSH_FASILITAS.ID 
                                        AND TO_CHAR(SCM_MI_PRSH_LOG.CREATE_DATE,'YYYYMMDD') = TO_CHAR(SYSDATE,'YYYYMMDD')");
        return $data->result();
    }

//====================== FUNCTION CRUD MASTER FASILITAS ======================\\

    private function facility_query() {
        $this->db->from("SCM_MI_M_FASILITAS");
        $this->db->where('SCM_MI_M_FASILITAS.STATUS', 0);
        $i = 0;

        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                $this->db->like("LOWER(NAMA)", strtolower($_POST["search"]["value"]));
            }
            $i++;
        }
    }

    function ListFasilitas() {
        $this->facility_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function FilterFasilitas() {
        $this->facility_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function CountFasilitas() {
        $this->db->from("SCM_MI_M_FASILITAS");
        $this->db->where("STATUS", 0);
        return $this->db->count_all_results();
    }

    function DetailFasilitas($id) {
        $this->db->from("SCM_MI_M_FASILITAS");
        $this->db->where('ID', $id);
        $query = $this->db->get();

        return $query->row();
    }

    function AddFasilitas($data) {
        $query = $this->db->insert("SCM_MI_M_FASILITAS", $data);
        return $query;
    }

    function UpdateFasilitas($where, $data) {
        $this->db->update("SCM_MI_M_FASILITAS", $data, $where);
        return $this->db->affected_rows();
    }

    function DeleteFasilitas($id) {
        $this->db->query("update SCM_MI_M_FASILITAS set STATUS=1 where ID=$id ");
    }

//==================== FUNCTION CRUD FASILITAS PERUSAHAAN ====================\\


    private function infofacility_query() {
        $this->db->select('SCM_MI_PRSH_FASILITAS.ID,
                                    ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN, 
                                    SCM_MI_M_FASILITAS.NAMA as JENIS_FASILITAS, 
                                    SCM_MI_PRSH_FASILITAS.NAMA as NAMA_FASILITAS, 
                                    rtrim(to_char(SCM_MI_PRSH_FASILITAS.LATITUDE, \'FM90.999999\'), \'.\') LATITUDE,
                                    rtrim(to_char(SCM_MI_PRSH_FASILITAS.LONGITUDE, \'FM990.999999\'), \'.\') LONGITUDE,
                                    SCM_MI_PRSH_FASILITAS.MARKER,
                                    SCM_MI_PRSH_FASILITAS.STATUS_FASILITAS');
        $this->db->from('ZREPORT_MS_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_FASILITAS', 'SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN = ZREPORT_MS_PERUSAHAAN.KODE_PERUSAHAAN', 'left');
        $this->db->join('SCM_MI_M_FASILITAS', 'SCM_MI_M_FASILITAS.ID = SCM_MI_PRSH_FASILITAS.FASILITAS', 'left');
        //$this->db->join('SCM_MI_PRSH_INFORMASI', 'SCM_MI_PRSH_INFORMASI.ID_PRSH_FASILITAS = SCM_MI_M_FASILITAS.ID', 'left');
        //$this->db->join('SCM_MI_PRSH_FOTO', 'SCM_MI_PRSH_FOTO.ID_PRSH_FASILITAS = SCM_MI_PRSH_INFORMASI.ID_PRSH_FASILITAS', 'left');
        $this->db->where('SCM_MI_PRSH_FASILITAS.STATUS', 0);
        $this->db->order_by('SCM_MI_PRSH_FASILITAS.CREATE_DATE', 'DESC'); // or 'DESC'

        if ($_POST['search']['value']) { // if datatable send POST for search
            $this->db->like("LOWER(ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN)", strtolower($_POST["search"]["value"]));
            $this->db->or_like("LOWER(SCM_MI_M_FASILITAS.NAMA)", strtolower($_POST["search"]["value"]));
            $this->db->or_like("LOWER(SCM_MI_PRSH_FASILITAS.NAMA)", strtolower($_POST["search"]["value"]));
            $this->db->or_like("LOWER(SCM_MI_PRSH_FASILITAS.STATUS)", strtolower($_POST["search"]["value"]));
        }
    }

    function ListInfoFasilitas() {
        $this->infofacility_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function FilterInfoFasilitas() {
        $this->infofacility_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function CountInfoFasilitas() {
        $this->infofacility_query();
        return $this->db->count_all_results();
    }

    function get_jenis_fasilitas() {
        $query = $this->db->query("SELECT
                                        SCM_MI_M_FASILITAS.ID, 
                                        SCM_MI_M_FASILITAS.NAMA 
                                   FROM 
                                        SCM_MI_M_FASILITAS  
                                   WHERE STATUS = 0
                                   ORDER BY
                                        NAMA ");
        return $query->result();
    }

    function get_perusahaan() {
        $query = $this->db->query("SELECT 
                                        KODE_PERUSAHAAN, 
                                        NAMA_PERUSAHAAN 
                                   FROM 
                                        ZREPORT_MS_PERUSAHAAN 
                                   ORDER BY
                                        NAMA_PERUSAHAAN");
        return $query->result();
    }

    function AddInfoFasilitas($FASILITAS, $KODE_PERUSAHAAN, $LATITUDE, $LONGITUDE, $STATUS_FASILITAS, $CREATE_BY, $NAMA, $MARKER) {
        $this->db->query("insert into SCM_MI_PRSH_FASILITAS (FASILITAS, KODE_PERUSAHAAN, LATITUDE, LONGITUDE, STATUS_FASILITAS, CREATE_DATE, CREATE_BY, UPDATE_DATE, UPDATE_BY, NAMA, MARKER, STATUS) values ('$FASILITAS', '$KODE_PERUSAHAAN', '$LATITUDE', '$LONGITUDE', '$STATUS_FASILITAS', SYSDATE, '$CREATE_BY', '', '', '$NAMA', '$MARKER', 0)");
    }

    function UpdateInfoFasilitas1($ID, $FASILITAS, $KODE_PERUSAHAAN, $LATITUDE, $LONGITUDE, $STATUS_FASILITAS, $UPDATE_BY, $NAMA) {
        $this->db->query("update SCM_MI_PRSH_FASILITAS set FASILITAS='$FASILITAS', KODE_PERUSAHAAN='$KODE_PERUSAHAAN', LATITUDE='$LATITUDE', LONGITUDE='$LONGITUDE', STATUS_FASILITAS='$STATUS_FASILITAS', UPDATE_DATE=SYSDATE, UPDATE_BY='$UPDATE_BY', NAMA='$NAMA', STATUS=0 WHERE ID=$ID ");
    }

    function UpdateInfoFasilitas2($ID, $FASILITAS, $KODE_PERUSAHAAN, $LATITUDE, $LONGITUDE, $STATUS_FASILITAS, $UPDATE_BY, $NAMA, $MARKER) {
        $this->db->query("update SCM_MI_PRSH_FASILITAS set FASILITAS='$FASILITAS', KODE_PERUSAHAAN='$KODE_PERUSAHAAN', LATITUDE='$LATITUDE', LONGITUDE='$LONGITUDE', STATUS_FASILITAS='$STATUS_FASILITAS', UPDATE_DATE=SYSDATE, UPDATE_BY='$UPDATE_BY', NAMA='$NAMA', MARKER='$MARKER', STATUS=0 WHERE ID=$ID ");
    }

    function HistoryAddInfoFasilitas() {
        $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
        //Query mendapatkan id
        $data = $this->db->query("select max(SCM_MI_PRSH_FASILITAS.ID) as PK from SCM_MI_PRSH_FASILITAS");
        foreach ($data->result() as $value) {
            $bawa = $value->PK;
        }
        $this->db->query("insert into SCM_MI_PRSH_LOG (ID_PRSH_FASILITAS, INFO, CREATE_DATE, CREATE_BY) values ('$bawa', 'Menambahkan data fasilitas perusahaan', SYSDATE, '$CREATE_BY')");
    }

    function HistoryUpdateInfoFasilitas($id) {
        $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
        $this->db->query("insert into SCM_MI_PRSH_LOG (ID_PRSH_FASILITAS, INFO, CREATE_DATE, CREATE_BY) values ('$id', 'Mengubah data fasilitas perusahaan', SYSDATE, '$CREATE_BY')");
    }

    function HistoryDeleteInfoFasilitas($id) {
        $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
        $this->db->query("insert into SCM_MI_PRSH_LOG (ID_PRSH_FASILITAS, INFO, CREATE_DATE, CREATE_BY) values ('$id', 'Menghapus data fasilitas perusahaan', SYSDATE, '$CREATE_BY')");
    }

    function DetailInfoFasilitas($id) {
        $this->db->select(' SCM_MI_PRSH_FASILITAS.ID,
                                    ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN, 
                                    SCM_MI_M_FASILITAS.NAMA,
                                    SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN, 
                                    SCM_MI_PRSH_FASILITAS.FASILITAS, 
                                    SCM_MI_PRSH_FASILITAS.NAMA, 
                                    SCM_MI_PRSH_FASILITAS.LATITUDE, 
                                    SCM_MI_PRSH_FASILITAS.LONGITUDE,
                                    SCM_MI_PRSH_FASILITAS.MARKER,
                                    SCM_MI_PRSH_FASILITAS.STATUS_FASILITAS');
        $this->db->from('ZREPORT_MS_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_FASILITAS', 'SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN = ZREPORT_MS_PERUSAHAAN.KODE_PERUSAHAAN', 'left');
        $this->db->join('SCM_MI_M_FASILITAS', 'SCM_MI_M_FASILITAS.ID = SCM_MI_PRSH_FASILITAS.FASILITAS', 'left');
        $this->db->where('SCM_MI_PRSH_FASILITAS.ID', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function UpdateInfoFasilitas($where, $data) {
        $this->db->update($this->table1, $data, $where);
        return $this->db->affected_rows();
    }

    function DeleteInfoFasilitas($id) {
        $this->db->query("update SCM_MI_PRSH_FASILITAS set STATUS=1 where SCM_MI_PRSH_FASILITAS.ID=$id ");
    }

//=============== FUNCTION CRUD INFORMASI FASILITAS PERUSAHAAN ===============\\

    private function info_query($id) {

        $this->db->select('ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN,
                                    SCM_MI_PRSH_FASILITAS.ID,
                                    SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN, 
                                    SCM_MI_PRSH_INFO.ID AS PK,
                                    SCM_MI_PRSH_INFO.HEADER,
                                    SCM_MI_PRSH_INFO.TEXT');
        $this->db->from('ZREPORT_MS_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_FASILITAS', 'SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN = ZREPORT_MS_PERUSAHAAN.KODE_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_INFO', 'SCM_MI_PRSH_INFO.ID_PRSH_FASILITAS = SCM_MI_PRSH_FASILITAS.ID');
        $this->db->where('SCM_MI_PRSH_FASILITAS.ID', $id);
        $this->db->order_by('SCM_MI_PRSH_INFO.CREATE_DATE', 'DESC'); // or 'DESC'
        if ($_POST['search']['value']) { // if datatable send POST for search
            $this->db->like("LOWER(SCM_MI_PRSH_INFO.TEXT)", strtolower($_POST["search"]["value"]));
        }
    }

    function ListInfo($id) {
        $this->info_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function FilterInfo($id) {

        $this->info_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function CountInfo($id) {

        $this->info_query($id);
        return $this->db->count_all_results();
    }

    function AddInfo($ID_PRSH_FASILITAS, $HEADER, $INFO, $CREATE_BY) {
        $this->db->query("insert into SCM_MI_PRSH_INFO(ID, ID_PRSH_FASILITAS, HEADER, TEXT, CREATE_DATE, CREATE_BY) values ('','$ID_PRSH_FASILITAS', '$HEADER', '$INFO', SYSDATE, '$CREATE_BY')");
    }

    function UpdateInfo($ID, $ID_PRSH_FASILITAS, $HEADER, $INFO, $UPDATE_BY) {
        $this->db->query("update SCM_MI_PRSH_INFO set ID_PRSH_FASILITAS='$ID_PRSH_FASILITAS', HEADER='$HEADER', TEXT='$INFO', UPDATE_DATE=SYSDATE, UPDATE_BY='$UPDATE_BY' WHERE ID=$ID ");
    }

    function DetailInfo($id) {
        $this->db->select('ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN,
                                    SCM_MI_PRSH_FASILITAS.ID,
                                    SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN, 
                                    SCM_MI_PRSH_INFO.ID AS PK,
                                    SCM_MI_PRSH_INFO.HEADER,
                                    SCM_MI_PRSH_INFO.TEXT');
        $this->db->from('ZREPORT_MS_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_FASILITAS', 'SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN = ZREPORT_MS_PERUSAHAAN.KODE_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_INFO', 'SCM_MI_PRSH_INFO.ID_PRSH_FASILITAS = SCM_MI_PRSH_FASILITAS.ID');
        $this->db->where('SCM_MI_PRSH_INFO.ID', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function DeleteInfo($id) {
//        $this->db->query("update SCM_MI_PRSH_INFO set STATUS=1 where ID=$id");
        $this->db->query("DELETE SCM_MI_PRSH_INFO WHERE ID=$id");
    }

//================== FUNCTION CRUD FOTO FASILITAS PERUSAHAAN ==================\\

    private function foto_query($id) {

        $this->db->select('ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN,
                                    SCM_MI_PRSH_FASILITAS.ID,
                                    SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN,
                                    SCM_MI_PRSH_FOTO.ID AS ID_FOTO,
                                    SCM_MI_PRSH_FOTO.FOTO');
        $this->db->from('ZREPORT_MS_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_FASILITAS', 'SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN = ZREPORT_MS_PERUSAHAAN.KODE_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_FOTO', 'SCM_MI_PRSH_FOTO.ID_PRSH_FASILITAS = SCM_MI_PRSH_FASILITAS.ID');
        $this->db->where('SCM_MI_PRSH_FASILITAS.ID', $id);
        $this->db->where('SCM_MI_PRSH_FOTO.STATUS', 0);
        if ($_POST['search']['value']) { // if datatable send POST for search
            $this->db->like("LOWER(ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN)", strtolower($_POST["search"]["value"]));
        }
    }

    function ListFoto($id) {
        $this->foto_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
//        echo $this->db->last_query();
        return $query->result();
    }

    function FilterFoto($id) {

        $this->foto_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function CountFoto($id) {

        $this->foto_query($id);
        return $this->db->count_all_results();
    }

    function DetailFoto($id) {
        $this->db->select('ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN,
                                    SCM_MI_PRSH_FASILITAS.ID,
                                    SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN, 
                                    SCM_MI_PRSH_FOTO.FOTO');
        $this->db->from('ZREPORT_MS_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_FASILITAS', 'SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN = ZREPORT_MS_PERUSAHAAN.KODE_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_FOTO', 'SCM_MI_PRSH_FOTO.ID_PRSH_FASILITAS = SCM_MI_PRSH_FASILITAS.ID');
        $this->db->where('SCM_MI_PRSH_FOTO.ID', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function AddFoto($ID_PRSH_FASILITAS, $CREATE_BY, $FOTO) {
        $this->db->query("insert into SCM_MI_PRSH_FOTO (CREATE_DATE, CREATE_BY, FOTO, ID_PRSH_FASILITAS, STATUS) values (SYSDATE, '$CREATE_BY', '$FOTO', '$ID_PRSH_FASILITAS', 0)");
    }

    function HistoryAddFotoFasilitas($ID_PRSH_FASILITAS) {
        $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
        //Query mendapatkan id
//        $data = $this->db->query("select max(SCM_MI_PRSH_FASILITAS.ID) as PK from SCM_MI_PRSH_FASILITAS");
//        foreach ($data->result() as $value) {
//            $bawa = $value->PK;
//        }
        $this->db->query("insert into SCM_MI_PRSH_LOG (ID_PRSH_FASILITAS, INFO, CREATE_DATE, CREATE_BY) values ('$ID_PRSH_FASILITAS', 'Menambahkan data foto fasilitas perusahaan', SYSDATE, '$CREATE_BY')");
    }

    function HistoryDeleteFotoFasilitas($id) {
        $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
        $data = $this->db->query("select SCM_MI_PRSH_FOTO.ID_PRSH_FASILITAS as PK from SCM_MI_PRSH_FOTO where ID=$id");
        foreach ($data->result() as $value) {
            $bawa = $value->PK;
        }
        $this->db->query("insert into SCM_MI_PRSH_LOG (ID_PRSH_FASILITAS, INFO, CREATE_DATE, CREATE_BY) values ('$bawa', 'Menghapus data foto fasilitas perusahaan', SYSDATE, '$CREATE_BY')");
    }

    function DeleteFoto($id) {
        $this->db->query("update SCM_MI_PRSH_FOTO set STATUS=1 where SCM_MI_PRSH_FOTO.ID=$id ");
    }

    //================== FUNCTION CRUD MASTER PERUSAHAAN ==================\\
    private function perusahaan_query() {
        $this->db->from("ZREPORT_MS_PERUSAHAAN");
//        $this->db->where('SCM_MI_M_FASILITAS.STATUS', 0);
        $i = 0;

        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                $this->db->like("LOWER(NAMA_PERUSAHAAN)", strtolower($_POST["search"]["value"]));
            }
            $i++;
        }
    }

    function ListPerusahaan() {
        $this->perusahaan_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function FilterPerusahaan() {
        $this->perusahaan_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function CountPerusahaan() {
        $this->db->from("ZREPORT_MS_PERUSAHAAN");
        return $this->db->count_all_results();
    }

    function DetailPerusahaan($id) {
        $this->db->from("ZREPORT_MS_PERUSAHAAN");
        $this->db->where('KODE_PERUSAHAAN', $id);
        $query = $this->db->get();

        return $query->row();
    }

    function AddPerusahaan($kd_perusahaan, $nm_perusahaan, $inisial, $produk, $status, $create_by) {
        $query = $this->db->query("insert into ZREPORT_MS_PERUSAHAAN (KODE_PERUSAHAAN,NAMA_PERUSAHAAN,INISIAL,PRODUK,STATUS,CREATE_DATE,CREATE_BY) values ('$kd_perusahaan','$nm_perusahaan','$inisial','$produk','$status',SYSDATE,'$create_by')");
        return $query;
    }

    function UpdatePerusahaan($kd_perusahaan, $nm_perusahaan, $inisial, $produk, $status, $update_by) {
        $this->db->query("update ZREPORT_MS_PERUSAHAAN set NAMA_PERUSAHAAN='$nm_perusahaan',INISIAL='$inisial',PRODUK='$produk',STATUS='$status',UPDATE_DATE=SYSDATE,UPDATE_BY='$update_by' where KODE_PERUSAHAAN = $kd_perusahaan");
//        $this->db->update("ZREPORT_MS_PERUSAHAAN", $data, $where);
        return $this->db->affected_rows();
    }

    function DeletePerusahaan($id) {
        $this->db->where('KODE_PERUSAHAAN', $id);
        $this->db->delete('ZREPORT_MS_PERUSAHAAN');
    }

    function max_id() {
        return $this->db->query("select max(KODE_PERUSAHAAN) MAXID FROM ZREPORT_MS_PERUSAHAAN")->result();
    }

    /*
     * Log Activity
     */

    private function Log_query($id) {

        $this->db->select('ZREPORT_MS_PERUSAHAAN.NAMA_PERUSAHAAN,
                                    SCM_MI_PRSH_FASILITAS.ID,
                                    SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN, 
                                    SCM_MI_PRSH_LOG.ID AS PK,
                                    SCM_MI_PRSH_LOG.CREATE_DATE,
                                    SCM_MI_PRSH_LOG.CREATE_BY,
                                    SCM_MI_PRSH_LOG.INFO');
        $this->db->from('ZREPORT_MS_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_FASILITAS', 'SCM_MI_PRSH_FASILITAS.KODE_PERUSAHAAN = ZREPORT_MS_PERUSAHAAN.KODE_PERUSAHAAN');
        $this->db->join('SCM_MI_PRSH_LOG', 'SCM_MI_PRSH_LOG.ID_PRSH_FASILITAS = SCM_MI_PRSH_FASILITAS.ID');
        $this->db->where('SCM_MI_PRSH_FASILITAS.ID', $id);
        $this->db->order_by('SCM_MI_PRSH_LOG.CREATE_DATE', 'DESC'); // or 'DESC'
        if ($_POST['search']['value']) { // if datatable send POST for search
            $this->db->like("LOWER(SCM_MI_PRSH_LOG.INFO)", strtolower($_POST["search"]["value"]));
        }
    }

    function ListLog($id) {
        $this->Log_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function FilterLog($id) {

        $this->Log_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function CountLog($id) {

        $this->Log_query($id);
        return $this->db->count_all_results();
    }

    function HistoryAddInfo($ID_PRSH_FASILITAS) {
        $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
        //Query mendapatkan id
        $this->db->query("insert into SCM_MI_PRSH_LOG (ID_PRSH_FASILITAS, INFO, CREATE_DATE, CREATE_BY) values ('$ID_PRSH_FASILITAS', 'Menambahkan data informasi fasilitas perusahaan', SYSDATE, '$CREATE_BY')");
    }

    function HistoryUpdateInfo($id) {
        $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
        $this->db->query("insert into SCM_MI_PRSH_LOG (ID_PRSH_FASILITAS, INFO, CREATE_DATE, CREATE_BY) values ('$id', 'Mengubah data informasi fasilitas perusahaan', SYSDATE, '$CREATE_BY')");
    }

    function HistoryDeleteInfo($id) {
        $CREATE_BY = strtoupper($this->session->userdata('usernamescm'));
        $this->db->query("insert into SCM_MI_PRSH_LOG (ID_PRSH_FASILITAS, INFO, CREATE_DATE, CREATE_BY) values ('$id', 'Menghapus data informasi fasilitas perusahaan', SYSDATE, '$CREATE_BY')");
    }
    function IdPrshFasilitas($id) {
        return $this->db->query("select * from SCM_MI_PRSH_INFO where id='$id'")->result();
    }
    /*
     * Ambil default marker
     */
    function DefaultMarker($FASILITAS,$KODE_PERUSAHAAN) {
        return $this->db->query("select * from SCM_MI_MASTER_MARKER where FASILITAS='$FASILITAS' AND KODE_PERUSAHAAN='$KODE_PERUSAHAAN'")->result();
    }
    
    function getDataFasilitasAll(){
        $data = $this->db->query("SELECT
                            TB1.ID,
                            TB2.NAMA JENIS_FASILITAS,
                            TB3.NAMA_PERUSAHAAN,
                            TB1.NAMA,
                            TB1.LATITUDE,
                            TB1.LONGITUDE,
                            CASE TB1.STATUS_FASILITAS
                    WHEN '0' THEN
                            'AKTIF'
                    ELSE
                            'TIDAK AKTIF'
                    END AS STATUS_FASILITAS
                    FROM
                            SCM_MI_PRSH_FASILITAS TB1
                    LEFT JOIN SCM_MI_M_FASILITAS TB2 ON TB1.FASILITAS = TB2. ID
                    LEFT JOIN ZREPORT_MS_PERUSAHAAN TB3 ON TB1.KODE_PERUSAHAAN = TB3.KODE_PERUSAHAAN
                    WHERE
                            TB1.STATUS = 0");
        return $data->result_array();
    }
    
    function getDataInfoFasilitas(){
        $data = $this->db->query("SELECT
                                        TB1. ID,
                                        TB2. HEADER,
                                        TB2.TEXT
                                FROM
                                        SCM_MI_PRSH_FASILITAS TB1
                                RIGHT JOIN SCM_MI_PRSH_INFO TB2 ON TB1. ID = TB2.ID_PRSH_FASILITAS
                                WHERE
                                        TB1.STATUS = 0");
        return $data->result_array();
    }
}
