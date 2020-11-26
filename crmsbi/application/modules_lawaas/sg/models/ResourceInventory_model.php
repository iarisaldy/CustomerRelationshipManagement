<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

date_default_timezone_set('Asia/Jakarta');

class ResourceInventory_model extends CI_Model {
	private $db2;
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db2 = $this->load->database('scmproduction',TRUE);
    }
    public function getData()
    {
      $date = $this->input->get('tanggal');
      if($date){
          
      }else{
          $date = "26/05/2016";
      }
      
    	$sql = "select KODE_MATERIAL, ATTRIBUTTE, KODE_KELOMPOK, sum(QTY_STOK) QTY_STOK, TGL_STOK from
    			(
    			 select stok.KODE_MATERIAL, stok.ATTRIBUTTE, sum(stok.QTY_STOK) QTY_STOK, SUM(stok.QTY_PRODUKSI) QTY_PRODUKSI, stok.TGL_STOK, 
    			   material.NAMA_MATERIAL, material.DESC_ATTRIBUTTE, material.KODE_KELOMPOK
    			 from (SELECT ZREPORT_MM_STOK.*, (case when ATTRIBUTTE is null then '1' else ATTRIBUTTE END) ATTRIBUTTE2 FROM ZREPORT_MM_STOK) stok
    			 LEFT JOIN (SELECT ZREPORT_MM_MATERIAL.*,(case when ATTRIBUTTE is null then '1' else ATTRIBUTTE END) ATTRIBUTTE2 FROM ZREPORT_MM_MATERIAL) material 
    			   on material.KODE_MATERIAL = stok.KODE_MATERIAL and material.ATTRIBUTTE2 = stok.ATTRIBUTTE2
    			 where stok.org = 7000 and stok.status = 0
    			 group by stok.PLANT_GROUP, stok.KODE_MATERIAL, stok.ATTRIBUTTE, material.NAMA_MATERIAL, material.DESC_ATTRIBUTTE, stok.TGL_STOK, material.KODE_KELOMPOK
    			 order by stok.TGL_STOK ASC
    			) a 
    			where to_char(tgl_stok,'DD/MM/YYYY') = '$date'
    			group by kode_material, ATTRIBUTTE, KODE_KELOMPOK, tgl_stok";
    	return $this->db->query($sql);
    }
    public function getHead($value='')
    {
    	$date = $this->input->get('tanggal');
      if($date){
          
      }else{
          $date = "26/05/2016";
      }
      $explode = explode('/', $date);
      $d = $explode[0];
      $m = $explode[1];
      $y = $explode[2];

    	$q = "select material.ATTRIBUTTE, kelompok.NAMA_KELOMPOK, material.KODE_KELOMPOK
				from zreport_mm_rkap rkap
				left join zreport_mm_material material on material.kode_material = rkap.kode_material 
				  and nvl(material.attributte, 'null') = nvl(rkap.attributte,'null')
        left join ZREPORT_MM_kelompok kelompok on material.KODE_KELOMPOK =  kelompok.KODE_KELOMPOK
				where rkap.org = 7000 and bulan = '$m' and tahun = $y and TIPE = 'BB'
				group by material.ATTRIBUTTE, kelompok.NAMA_KELOMPOK, material.KODE_KELOMPOK ";
        return $this->db->query($q);
    }

    public function getDetail()
    {
        //$kodeMaterial   = $this->input->post('kodeMaterial');
        $attribute      = $this->input->post('attribute');
        $kelompok       = $this->input->post('kelompok');

        $q = "select SUM(PLANT.STOK_MIN) STOK_MIN, SUM(PLANT.STOK_MAX) STOK_MAX, SUM(PLANT.ROP) ROP, 
                KELOMPOK.NAMA_KELOMPOK NAMA_MATERIAL
              from ZREPORT_MM_MATERIAL MATERIAL
              LEFT JOIN ZREPORT_MM_MATERIAL_PLANT PLANT 
                ON PLANT.KODE_MATERIAL = MATERIAL.KODE_MATERIAL
                AND nvl(MATERIAL.ATTRIBUTTE, 'null') = nvl(PLANT.ATTRIBUTTE,'null')
              LEFT JOIN ZREPORT_MM_KELOMPOK KELOMPOK
                ON KELOMPOK.KODE_KELOMPOK = MATERIAL.KODE_KELOMPOK
              WHERE MATERIAL.KODE_KELOMPOK = '$kelompok' AND PLANT.ORG = 7000
                AND MATERIAL.STATUS = 0 AND PLANT.STATUS = 0
              GROUP BY KELOMPOK.NAMA_KELOMPOK";
        $data['head'] = $this->db->query($q)->row();
        return $data;
    }

    public function getgrafikOld($orderTgl = "ASC")
    {
      $date = $this->input->get('tanggal');
      if($date){
          
      }else{
          $date = "26/05/2016";
      }
      $explode = explode('/', $date);
      $d = $explode[0];
      $m = $explode[1];
      $y = $explode[2];
      $kodeMaterial   = $this->input->post('kodeMaterial');
      $attribute      = $this->input->post('attribute');
      $kelompok      = $this->input->post('kelompok');
      
      $attributeQuery = '';
      $kodeMaterialQuery = '';
      $kodeMaterialQuery = "AND KODE_MATERIAL = '$kodeMaterial'";
      if($attribute)
        $attributeQuery = "AND ATTRIBUTTE = '$attribute'";
      if($kelompok == 1700)
        $kodeMaterialQuery = '';
      $q = "select sum(QTY_STOK) QTY_STOK, TO_CHAR(TGL_STOK, 'DD') TGL_STOK 
          FROM 
          (select stok.KODE_MATERIAL, stok.ATTRIBUTTE, sum(stok.QTY_STOK) QTY_STOK, SUM(stok.QTY_PRODUKSI) QTY_PRODUKSI, stok.TGL_STOK, 
                                   material.NAMA_MATERIAL, material.DESC_ATTRIBUTTE, material.KODE_KELOMPOK
                                 from (SELECT ZREPORT_MM_STOK.*, (case when ATTRIBUTTE is null then '1' else ATTRIBUTTE END) ATTRIBUTTE2 FROM ZREPORT_MM_STOK) stok
                                 LEFT JOIN (SELECT ZREPORT_MM_MATERIAL.*,(case when ATTRIBUTTE is null then '1' else ATTRIBUTTE END) ATTRIBUTTE2 FROM ZREPORT_MM_MATERIAL) material 
                                   on material.KODE_MATERIAL = stok.KODE_MATERIAL and material.ATTRIBUTTE2 = stok.ATTRIBUTTE2
                                 where stok.org = 7000 and stok.status = 0
                                 group by stok.PLANT_GROUP, stok.KODE_MATERIAL, stok.ATTRIBUTTE, material.NAMA_MATERIAL, material.DESC_ATTRIBUTTE, stok.TGL_STOK, material.KODE_KELOMPOK
                                 order by stok.TGL_STOK $orderTgl) a 
                                 WHERE TO_CHAR(TGL_STOK, 'MM/YYYY') = '$date' 
                                 $kodeMaterialQuery
                                 $attributeQuery
                                 AND KODE_KELOMPOK = '$kelompok'
                                 group by TGL_STOK
                                 ORDER BY TGL_STOK $orderTgl";
        return $this->db->query($q);
    }
    public function getgrafik($orderTgl = "ASC")
    {
      $date = $this->input->get('tanggal');
      $attribute = $this->input->post('attribute');
      $kelompok = $this->input->post('kelompok');
      if($date){
          
      }else{
          $date = "26/05/2016";
      }
      $explode = explode('/', $date);
      $d = $explode[0];
      $m = $explode[1];
      $y = $explode[2];
      //$kodeMaterial   = $this->input->post('kodeMaterial');
      $filterAttribute = $attribute ? " AND ATTRIBUTTE = $attribute" : "";
      $q = "SELECT TO_CHAR(TGL_STOK, 'DD') TGL_STOK, SUM(QTY_STOK) QTY_STOK
              FROM ZREPORT_MM_STOK WHERE KODE_MATERIAL in (select KODE_MATERIAL from ZREPORT_MM_MATERIAL where KODE_KELOMPOK = $kelompok $filterAttribute)
                AND TO_CHAR(TGL_STOK, 'MMYYYY') = '$m$y' AND ORG = 7000 AND STATUS = 0
            GROUP BY TGL_STOK
            ORDER BY TGL_STOK $orderTgl";
      
            return  $this->db->query($q);
    }
    public function getHeadDetail($value)
    {
      $date = $this->input->get('tanggal');
      if($date){
          
      }else{
          $date = "26/05/2016";
      }
      $explode = explode('/', $date);
      $d = $explode[0];
      $m = $explode[1];
      $y = $explode[2];

      $q = "select material.KODE_MATERIAL, material.ATTRIBUTTE, kelompok.NAMA_KELOMPOK, material.KODE_KELOMPOK, material.NAMA_MATERIAL
        from zreport_mm_rkap rkap
        left join zreport_mm_material material on material.kode_material = rkap.kode_material 
          and nvl(material.attributte, 'null') = nvl(rkap.attributte,'null')
        left join ZREPORT_MM_kelompok kelompok on material.KODE_KELOMPOK =  kelompok.KODE_KELOMPOK
        where rkap.org = 7000 and bulan = '$m' and tahun = $y and TIPE = 'BB' AND material.KODE_KELOMPOK = '$value'
        group by  material.KODE_MATERIAL, material.ATTRIBUTTE, material.NAMA_MATERIAL, kelompok.NAMA_KELOMPOK, material.KODE_KELOMPOK ";
        return $this->db->query($q)->result_array();
    }
    
    public function listMaterial($opco,$plant_group){
      $q = "SELECT distinct kl.KODE_KELOMPOK,
                kl.NAMA_KELOMPOK,
                kl.NAMA_KELOMPOK ALIAS_NAMA     
            FROM zreport_scm_mm_kelompok kl
            JOIN zreport_scm_mm_material_plant mp
                ON kl.KODE_KELOMPOK = mp.KODE_KELOMPOK and mp.plant_group = '".$plant_group."' and org = '".$opco."'
               order by kl.NAMA_KELOMPOK";  
      return $this->db->query($q)->result_array();
    }
    /* $period 2016-01 */
    public function getStok($opco,$plant_group,$period){
      $q = "SELECT zs.kode_kelompok, 
		zs.qty_terima, 
		zs.qty_pakai, 
		zs.qty_stok,
		zp.stok_min,
		zp.stok_max,
		zp.rp,
                t.TGL_STOK
            FROM zreport_scm_mm_stok zs
            JOIN (
                    SELECT max(st.TGL_STOK) TGL_STOK, st.kode_kelompok FROM zreport_scm_mm_stok st
                    WHERE substr(to_char(st.tgl_stok,'YYYY-MM-DD'),0,7) = '".$period."' AND st.plant_group = '".$plant_group."'
                        and st.org = '".$opco."'
                    GROUP BY kode_kelompok
            )t 	
                    ON t.TGL_STOK = zs.TGL_STOK AND zs.kode_kelompok = t.kode_kelompok
            JOIN zreport_scm_mm_material_plant zp
                    ON zp.KODE_KELOMPOK = zs.kode_kelompok AND zp.PLANT_GROUP = zs.PLANT_GROUP	
            WHERE zs.plant_group = '".$plant_group."' and substr(to_char(zs.tgl_stok,'YYYY-MM-DD'),0,7) = '".$period."'
                and zs.org = '".$opco."'
        ";
        return $this->db->query($q)->result_array();
    }
    
    public function getDetailStok($opco,$plant_group,$period,$kode_kelompok){
      $in_kelompok = '';  
      if(is_array($kode_kelompok)){
        $in_kelompok = implode("','",$kode_kelompok);  
      }else{
        $in_kelompok = $kode_kelompok;  
      } 
      $q = "SELECT to_char(ph.tanggal,'DD') tanggal,
		ph.qty_terima terima_prognose,
		ph.qty_pakai pakai_prognose,
                ph.qty_stok stok_prognose,
		zs.qty_terima, 
		zs.qty_pakai, 
		zs.qty_stok,
		zp.stok_min,
		zp.stok_max,		
		zp.rp,
                zp.dead_stock
            FROM zreport_scm_mm_prognose_harian ph                                    
            RIGHT JOIN zreport_scm_mm_material_plant zp
                ON zp.KODE_KELOMPOK = ph.kode_kelompok AND zp.PLANT_GROUP = ph.PLANT_GROUP 	
                    and ph.org = zp.org         
            LEFT JOIN zreport_scm_mm_stok zs  
            	ON zs.KODE_KELOMPOK = ph.kode_kelompok AND zs.plant_group = ph.plant_group AND ph.tanggal = zs.TGL_STOK and zs.org = ph.org
            WHERE ph.plant_group = '".$plant_group."' and substr(to_char(ph.tanggal,'YYYY-MM-DD'),0,7) = '".$period."'
                and ph.org = '".$opco."' and ph.kode_kelompok in ('".$in_kelompok."')
            order by ph.tanggal        
        ";
      /* 
      $q_stok = "SELECT to_char(zs.TGL_STOK,'DD') tanggal,
		null terima_prognose,
		null pakai_prognose,
            null stok_prognose,
			zs.qty_terima, 
			zs.qty_pakai, 
			zs.qty_stok,
			zp.stok_min,
			zp.stok_max,		
			zp.rp,
	        zp.dead_stock
        FROM zreport_scm_mm_material_plant zp                                                  
            JOIN zreport_scm_mm_stok zs  
            	ON zs.KODE_KELOMPOK = zp.kode_kelompok and zs.org = zp.org and substr(to_char(zs.TGL_STOK,'YYYY-MM-DD'),0,7) = '".$period."'
            WHERE zp.plant_group = '".$plant_group."' and zp.org = '".$opco."' and zp.kode_kelompok in ('".$in_kelompok."')"
        ;      
      $q_prognose = "SELECT to_char(ph.tanggal,'DD') tanggal,
		ph.qty_terima terima_prognose,
		ph.qty_pakai pakai_prognose,
        ph.qty_stok stok_prognose,
			NULL qty_terima, 
			NULL qty_pakai, 
			NULL qty_stok,
			zp.stok_min,
			zp.stok_max,		
			zp.rp,
	        zp.dead_stock
        FROM zreport_scm_mm_material_plant zp                                                  
        JOIN zreport_scm_mm_prognose_harian ph
        	ON zp.KODE_KELOMPOK = ph.kode_kelompok AND zp.PLANT_GROUP = ph.PLANT_GROUP 	
                    and ph.org = zp.org and substr(to_char(ph.tanggal,'YYYY-MM-DD'),0,7) = '".$period."'        
        WHERE zp.plant_group = '".$plant_group."' and zp.org = '".$opco."' and zp.kode_kelompok in ('".$in_kelompok."')";
        
        $q_prognose_result = $this->groupingByColumn($this->db->query($q_prognose)->result_array(),'TANGGAL');
        $q_stok_result = $this->groupingByColumn($this->db->query($q_stok)->result_array(),'TANGGAL');
        $result = array();
        if(!empty($q_prognose_result)){
            foreach($q_prognose_result as $tgl => $prog){
                $tmp = $prog;
                if(isset($q_stok_result[$tgl])){
                   $tmp['QTY_TERIMA'] = $q_stok_result[$tgl]['QTY_TERIMA'];
                   $tmp['QTY_PAKAI'] = $q_stok_result[$tgl]['QTY_PAKAI'];
                   $tmp['QTY_STOK'] = $q_stok_result[$tgl]['QTY_STOK'];
                }
                array_push($result,$tmp);
            }
        }else{
            foreach($q_stok_result as $tgl => $prog){
                $tmp = $prog;                
                if(isset($q_prognose_result[$tgl])){
                   $tmp['TERIMA_PROGNOSE'] = $q_prognose_result[$tgl]['TERIMA_PROGNOSE'];
                   $tmp['PAKAI_PROGNOSE'] = $q_prognose_result[$tgl]['PAKAI_PROGNOSE'];
                   $tmp['STOK_PROGNOSE'] = $q_prognose_result[$tgl]['STOK_PROGNOSE'];
                }
                array_push($result,$tmp);
            }
        }
        return $result;*/
        return $this->db->query($q)->result_array();
    }
    
    
    /* cari pemakaian 7 hari terakhir */
    public function getLastAverageWeek($opco,$plant_group,$period,$kode_kelompok){
      $q = "SELECT avg(zs.qty_pakai) stok					
            FROM zreport_scm_mm_stok zs
            JOIN (
                    SELECT max(st.TGL_STOK) TGL_STOK, st.kode_kelompok FROM zreport_scm_mm_stok st
                    WHERE substr(to_char(st.tgl_stok,'YYYY-MM-DD'),0,7) = '".$period."' AND st.plant_group = '".$plant_group."'
                        and st.org = '".$opco."' and st.kode_kelompok = '".$kode_kelompok."'
                    GROUP BY kode_kelompok
            )t 	
                    ON  zs.TGL_STOK BETWEEN t.TGL_STOK - 7 AND t.TGL_STOK  AND zs.kode_kelompok = t.kode_kelompok
            WHERE zs.plant_group = '".$plant_group."' -- and substr(to_char(zs.tgl_stok,'YYYY-MM-DD'),0,7) = '".$period."'
                and zs.org = '".$opco."' and zs.kode_kelompok = '".$kode_kelompok."'        
        ";      
        return $this->db->query($q)->row_array();
    }
    public function getRKAP($opco,$plant_group,$period,$kode_kelompok){
        $_t = explode('-',$period);        
        $q = "select target_pakai from zreport_scm_mm_rkap where org = '$opco' and plant_group='$plant_group' and tahun = '$_t[0]' and bulan = '$_t[1]' and  kode_kelompok = '$kode_kelompok' ";
        return $this->db->query($q)->row_array();
    }
    
    public function getRKAP_dev($opco,$plant_group,$period,$kode_kelompok){
        //$_t = explode('-',$period);        
        //$q = "select target_pakai from zreport_scm_mm_rkap where org = '$opco' and plant_group='$plant_group' and tahun = '$_t[0]' and bulan = '$_t[1]' and  kode_kelompok = '$kode_kelompok' ";
        //return $this->db->query($q)->row_array();
        return array();
    }
    
    
    public function getDetailStok_history($opco,$plant_group,$startDate,$endDate,$kode_kelompok){
      $in_kelompok = '';  
      if(is_array($kode_kelompok)){
        $in_kelompok = implode("','",$kode_kelompok);  
      }else{
        $in_kelompok = $kode_kelompok;  
      }  
      $q = "SELECT to_char(ph.tanggal,'DD-MM-YYYY') tanggal,
		ph.qty_terima terima_prognose,
		ph.qty_pakai pakai_prognose,
                ph.qty_stok stok_prognose,
		zs.qty_terima, 
		zs.qty_pakai, 
		zs.qty_stok,
		zp.stok_min,
		zp.stok_max,		
		zp.rp,
                zp.dead_stock
            FROM zreport_scm_mm_prognose_harian ph                                    
            JOIN zreport_scm_mm_material_plant zp
                ON zp.KODE_KELOMPOK = ph.kode_kelompok AND zp.PLANT_GROUP = ph.PLANT_GROUP 	
                    and ph.org = zp.org         
            LEFT JOIN zreport_scm_mm_stok zs  
            	ON zs.KODE_KELOMPOK = ph.kode_kelompok AND zs.plant_group = ph.plant_group AND ph.tanggal = zs.TGL_STOK and zs.org = ph.org
            WHERE ph.plant_group = '".$plant_group."' and ph.tanggal between to_date('".$startDate."','YYYY-MM-DD') and to_date('".$endDate."','YYYY-MM-DD')
                and ph.org = '".$opco."' and ph.kode_kelompok in ('".$in_kelompok."')
            order by ph.tanggal        
        ";
        return $this->db->query($q)->result_array();
    }
    
    /* $period 2016-01 */
    public function getStok_history($opco,$plant_group,$startDate,$endDate){
      $q = "SELECT zs.kode_kelompok, 
		zs.qty_terima, 
		zs.qty_pakai, 
		zs.qty_stok,
		zp.stok_min,
		zp.stok_max,
		zp.rp,
                t.TGL_STOK
            FROM zreport_scm_mm_stok zs
            JOIN (
                    SELECT max(st.TGL_STOK) TGL_STOK, st.kode_kelompok FROM zreport_scm_mm_stok st
                    WHERE st.tgl_stok between to_date('".$startDate."','YYYY-MM-DD') and to_date('".$endDate."','YYYY-MM-DD')
                    AND st.plant_group = '".$plant_group."'  and st.org = '".$opco."'
                    GROUP BY kode_kelompok
            )t 	
                    ON t.TGL_STOK = zs.TGL_STOK AND zs.kode_kelompok = t.kode_kelompok
            JOIN zreport_scm_mm_material_plant zp
                    ON zp.KODE_KELOMPOK = zs.kode_kelompok AND zp.PLANT_GROUP = zs.PLANT_GROUP	
            WHERE zs.plant_group = '".$plant_group."' and zs.tgl_stok = t.TGL_STOK
                and zs.org = '".$opco."'
        ";
        return $this->db->query($q)->result_array();
    }
    
    private function groupingByColumn($arr,$column){
        $r = array();
        foreach($arr as $ar){
           $r[$ar[$column]] = $ar; 
        }
        return $r;
    }
}