<?php

if (!defined('BASEPATH'))
	exit('No Direct Script Access Allowed');

class MasterGudang_model extends CI_Model {

	protected $table = 'CRM_GUDANG';
	var $column_search = array('NM_DISTR','KD_GDG','NM_GDG','ALAMAT','KAPASITAS','UNLOADING_RATE_TON','ORG');

	function __construct() {
		parent::__construct();
		$this->db2 = $this->load->database('scmproduction', TRUE);
	}

	private function gudang_query() {
        $this->db2->from("CRM_GUDANG");
        if ($this->session->userdata('akses') == 2) {
            $this->db2->where('CRM_GUDANG.ORG', $this->session->userdata('opco'));
        }
//        $this->db->where('SCM_MI_M_FASILITAS.STATUS', 0);
        $i = 0;

        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                $this->db2->like("LOWER(NM_DISTR)", strtolower($_POST["search"]["value"]));
                $this->db2->or_like("LOWER(KD_GDG)", strtolower($_POST["search"]["value"]));
                $this->db2->or_like("LOWER(NM_GDG)", strtolower($_POST["search"]["value"]));
                $this->db2->or_like("LOWER(ALAMAT)", strtolower($_POST["search"]["value"]));
                $this->db2->or_like("LOWER(KAPASITAS)", strtolower($_POST["search"]["value"]));
                $this->db2->or_like("LOWER(UNLOADING_RATE_TON)", strtolower($_POST["search"]["value"]));
                $this->db2->or_like("LOWER(ORG)", strtolower($_POST["search"]["value"]));
            }
            $i++;
        }
    }

    function ListGudang() {
        $this->gudang_query();
        if ($_POST['length'] != -1)
            $this->db2->limit($_POST['length'], $_POST['start']);
        $query = $this->db2->get();
        return (array) $query->result_array();
    }

    function FilterGudang() {
        $this->gudang_query();
        $query = $this->db2->get();
        return $query->num_rows();
    }

    function CountGudang() {
        $this->db2->from("CRM_GUDANG");
        return $this->db2->count_all_results();
    }

    function DetailGudang($id) {
        $this->db2->from("CRM_GUDANG");
        $this->db2->where('ID', $id);
        $query = $this->db2->get();

        return $query->row();
    }

    function max_id() {
        return $this->db2->query("select max(ID) MAXID FROM CRM_GUDANG")->result();
    }

    function AddGudang($id, $kd_distr, $nm_distr, $kd_gdg, $nm_gdg, $alamat, $kapasitas, $kap_bongkar, $create_by, $kd_disktrik, $area, $latitude, $longitude, $org) {
        $query = $this->db2->query("insert into CRM_GUDANG (ID,KD_DISTR,NM_DISTR,KD_GDG,NM_GDG,ALAMAT,KAPASITAS,UNLOADING_RATE_TON,CREATE_DATE,CREATE_BY,KD_DISTRIK,AREA,LATITUDE,LONGITUDE,ORG) values ('$id','$kd_distr','$nm_distr','$kd_gdg','$nm_gdg','$alamat','$kapasitas','$kap_bongkar',SYSDATE,'$create_by','$kd_disktrik','$area','$latitude','$longitude','$org')");
        return $query;
    }

    function UpdateGudang($id, $kd_distr, $nm_distr, $kd_gdg, $nm_gdg, $alamat, $kapasitas, $kap_bongkar, $create_by, $kd_disktrik, $area, $latitude, $longitude, $org) {
        $this->db2->query("update CRM_GUDANG set KD_DISTR='$kd_distr',NM_DISTR='$nm_distr',KD_GDG='$kd_gdg',NM_GDG='$nm_gdg',ALAMAT='$alamat',KAPASITAS='$kapasitas',UNLOADING_RATE_TON='$kap_bongkar',CREATE_DATE=SYSDATE,CREATE_BY='$create_by',KD_DISTRIK='$kd_disktrik',AREA='$area',LATITUDE='$latitude',LONGITUDE='$longitude',ORG='$org' where ID = $id");
//        $this->db->update("ZREPORT_MS_PERUSAHAAN", $data, $where);
        return $this->db2->affected_rows();
    }

    function DeleteGudang($id) {
        $this->db2->where('ID', $id);
        $this->db2->delete('CRM_GUDANG');
    }

	// public function GetListGudang() {
	// 	$this->db2->from($this->table);
	// 	$result = $this->db2->get();
	// 	return (array) $result->result_array();
	// }

}