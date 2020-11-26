<?php

if (!defined('BASEPATH'))
	exit('No Direct Script Access Allowed');

class AdjustmentGudang_model extends CI_Model {

	protected $table = 'CRM_GUDANG';
	var $column_search = array('COMPANY','NM_GDG','TAHUN','BULAN');

	function __construct() {
		parent::__construct();
		$this->db2 = $this->load->database('scmproduction', TRUE);
	}

	private function gudang_query() {
        $this->db2->select("SCM_GUDANG_ADJ.*,NM_GDG", FALSE);
        $this->db2->from("SCM_GUDANG_ADJ");

//        $this->db->where('SCM_MI_M_FASILITAS.STATUS', 0);
        $i = 0;

        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                $this->db2->like("LOWER(COMPANY)", strtolower($_POST["search"]["value"]));
                $this->db2->or_like("LOWER(NM_GDG)", strtolower($_POST["search"]["value"]));
                $this->db2->or_like("LOWER(TAHUN)", strtolower($_POST["search"]["value"]));
                $this->db2->or_like("LOWER(BULAN)", strtolower($_POST["search"]["value"]));
            }
            $i++;
        }
        $this->db2->join('CRM_GUDANG', 'SCM_GUDANG_ADJ.SHIPTO = CRM_GUDANG.KD_GDG', 'left');

    }

    public function get_child($id){
        $this->db2->where('ORG',$id);
        $this->db2->order_by('NM_GDG','ASC');
        $gsj = $this->db2->get($this->table);
        if ($gsj->num_rows()>0) {
            $result[]= '-PILIH GUDANG-';
            foreach ($gsj->result_array() as $row){
                $result[$row['KD_GDG']]= $row['NM_GDG'];
            } 
        } else {
           $result[]= '-BELUM ADA-';
        }
        return $result;
    }

    function ListAdjGudang() {
        $this->gudang_query();
        if ($_POST['length'] != -1)
            $this->db2->limit($_POST['length'], $_POST['start']);
        $query = $this->db2->get();
        return (array) $query->result_array();
    }

    function FilterAdjGudang() {
        $this->gudang_query();
        $query = $this->db2->get();
        return $query->num_rows();
    }

    function CountAdjGudang() {
        // $this->gudang_query();
        $this->db2->from("SCM_GUDANG_ADJ");
        return $this->db2->count_all_results();
    }

    function DetailAdjGudang($id) {
        $this->db2->from("SCM_GUDANG_ADJ");
        $this->db2->where('ID', $id);
        $query = $this->db2->get();

        return $query->row();
    }

    function max_id() {
        return $this->db2->query("select max(ID) MAXID FROM CRM_GUDANG")->result();
    }

    function AddAdjGudang($company, $gudang, $bulan, $tahun, $stok) {
        $query = $this->db2->query("insert into SCM_GUDANG_ADJ (COMPANY,SHIPTO,BULAN,TAHUN,STOK) values ('$company','$gudang','$bulan','$tahun','$stok')");
        return $query;
    }

    function UpdateAdjGudang($id,$company, $gudang, $bulan, $tahun, $stok) {
        $this->db2->query("update SCM_GUDANG_ADJ set ID='$id',COMPANY='$company',SHIPTO='$gudang',BULAN='$bulan',TAHUN='$tahun',STOK='$stok' where ID = $id");
//        $this->db->update("ZREPORT_MS_PERUSAHAAN", $data, $where);
        return $this->db2->affected_rows();
    }

    function DeleteAdjGudang($id) {
        $this->db2->where('ID', $id);
        $this->db2->delete('SCM_GUDANG_ADJ');
    }

	// public function GetListGudang() {
	// 	$this->db2->from($this->table);
	// 	$result = $this->db2->get();
	// 	return (array) $result->result_array();
	// }

}