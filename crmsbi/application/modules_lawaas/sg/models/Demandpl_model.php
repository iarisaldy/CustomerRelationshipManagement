<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

date_default_timezone_set('Asia/Jakarta');

class Demandpl_model extends CI_Model {
	private $db2;
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function org()
    {
    	$this->db->order_by('URUTAN', 'ASC');
    	return $this->db->get('ZREPORT_M_ORG');
    }
    public function terak($value='')
    {
    	#PRODUKSI TERAK & STOK TERAK
		$q = "SELECT SUM(QTY_STOK) QTY_STOK, SUM(QTY_PRODUKSI) QTY_PRODUKSI, SUM(QTY_PAKAI) QTY_PAKAI, ORG, KODE_MATERIAL, TGL_STOK 
				FROM ZREPORT_MM_STOK 
				WHERE KODE_MATERIAL = '121-400-0010' AND STATUS = 0 AND TO_char(TGL_STOK, 'DD/MM/YYYY') = '19/05/2016'
				GROUP BY ORG, KODE_MATERIAL, TGL_STOK";
		return $this->db->query($q);
    }

    public function produksiSemen($value='')
    {
    	$q = "SELECT SUM(QTY_STOK) QTY_STOK, SUM(QTY_PRODUKSI) QTY_PRODUKSI, SUM(QTY_PAKAI) QTY_PAKAI, ORG, KODE_MATERIAL, TGL_STOK 
			FROM ZREPORT_MM_STOK 
			WHERE KODE_MATERIAL LIKE '121-30%' AND STATUS = 0 AND TGL_STOK = '19/05/2016'
			GROUP BY ORG, KODE_MATERIAL, TGL_STOK";
		return $this->db->query($q);
    }
 }