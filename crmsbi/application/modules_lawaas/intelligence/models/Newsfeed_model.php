<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Newsfeed_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /*
     * ambil semua data report
     */

    function datareport() {
        return $this->db->query("select * FROM SCM_MI_REPORT ORDER BY id desc")->result_array();
//        return $this->db->get('SCM_MI_REPORT')->result_array();
    }

    /*
     * insert file report
     */

    function insert($nm_report, $tahun, $bulan, $nm_file, $create_by) {
        $this->db->query("insert into SCM_MI_REPORT (NAMA_REPORT,TAHUN,BULAN,NAMA_FILE,CREATE_BY,CREATE_DATE) values ('$nm_report','$tahun','$bulan','$nm_file','$create_by',SYSDATE)");
    }

    /*
     * ambil data nama file report berdasarkan id
     */

    function m_filereport($id) {
        return $this->db->query("SELECT NAMA_FILE FROM SCM_MI_REPORT WHERE ID='$id'")->result_array();
    }

    /*
     * Delete data report
     */

    function delete($id) {
        $this->db->where('ID', $id);
        $this->db->delete('SCM_MI_REPORT');
    }

    /*
     * Ambil data report terbaru
     */

    function newreport() {
        return $this->db->query('select id, NAMA_FILE from SCM_MI_REPORT where ROWNUM=1 order by id DESC ')->result_array();
    }

    /*
     * paging datatabel file report
     */

    function paging() {
        $this->db->from('SCM_MI_REPORT');
        return $this->db->count_all_results();
    }

    /*
     * Total news feed terbaru
     */

    function countNews() {
        $data = $this->db->query(" 
            SELECT
                    COUNT (TITLE) AS TOTAL
            FROM
                    SCM_MI_RSS_NEWS
            WHERE
                    TAMPIL = 1
            AND PUBDATE >= SYSDATE-7
            ");
        return $data->result();
    }

}
