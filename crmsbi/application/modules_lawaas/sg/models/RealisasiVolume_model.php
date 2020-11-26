<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

class RealisasiVolume_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function ora(){
        $data = $this->db->query("Select a.org, a.kd_prov,
            to_char(a.tanggal, 'YYYYMMDD') as tanggalx, a.material,a.target, b.nm_prov
             from zreport_scm_rkap a left join zreport_m_provinsi b on a.kd_prov=b.kd_prov
             where a.org='7000' and to_char(a.tanggal, 'YYYYMMDD') between '20160101' and '20160131'");
        
        return $data->result_array();
    }
    
    function rel(){
        $data = $this->db->query("select propinsi,nama_prop, to_char(TGL_SPJ, 'YYYYMMDD') as tanggalx, sum(kwmengx) as qty, substr(item_no,1,7)as material
                from ZREPORT_RPT_REAL 
                where  to_char(TGL_SPJ, 'YYYYMMDD') between '20160101' and '20160131' and propinsi=1025
                and propinsi is not null
                group by propinsi,nama_prop, to_char(TGL_SPJ, 'YYYYMMDD'), substr(item_no,1,7)
                order by to_char(TGL_SPJ, 'YYYYMMDD') asc");
        return $data->result_array();
    }
}