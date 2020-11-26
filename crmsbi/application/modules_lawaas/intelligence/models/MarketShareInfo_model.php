<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class MarketShareInfo_model extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->database();
    }

    function getData($org, $tahun, $bulan) {
        $data = $this->db->query("SELECT
		PROV,
		TO_CHAR(MAX (upd_date),'DD-MM-YYYY') AS upd_date,
		MIN(TRUNC(SYSDATE - upd_date)) as upd_count
	FROM
		(
			SELECT
				IDPROV AS PROV,
				(
					CASE
					WHEN UPDATE_ON IS NOT NULL THEN
						UPDATE_ON
					ELSE
						CREATED_ON
					END
				) AS upd_date
			FROM
				SCM_MI_M_MSFOTO
                        WHERE TO_CHAR(FOTODATE, 'mm-yyyy') = '" . $bulan . "-" . $tahun . "' 
                            " . ($org != 1 ? "AND COMPANY = '" . $org . "'" : "") . "
			UNION
				SELECT
					PROV_ID AS PROV,
					(
						CASE
						WHEN UPDATE_ON IS NOT NULL THEN
							UPDATE_ON
						ELSE
							CREATED_ON
						END
					) AS upd_date
				FROM
					SCM_MI_M_MSINFO
                                 WHERE TO_CHAR(INFODATE, 'mm') = '" . $bulan . "' 
                                     " . ($org != 1 ? "AND COMPANY = '" . $org . "'" : "") . "
		)
	GROUP BY
		PROV")->result_array();
        return $data;
    }

    function datas($org, $tahun, $bulan, $hari) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        if ($org == 7000) {
            $kd_per = 110;
        } elseif ($org == 3000) {
            $kd_per = 102;
        } elseif ($org == 4000) {
            $kd_per = 112;
        }
        $data = $this->db->query("SELECT
                                        TB1.PROV,
                                        TB8.NM_PROV,
                                        TB9.upd_date,
                                        TB9.upd_count,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB2. REAL, 0) REAL,
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH,
                                        NVL (TB4.HARIAN_MAX, 0) HARIAN_MAX,
                                        TB5.NAMA_KABIRO,
                                        NVL (TB6.RKAP_MS, 0) RKAP_MS,
                                        NVL (TB8.DEMAND_HARIAN, 0) DEMAND_HARIAN,
                                        CASE TB7.DEMAND_HARIAN
                                WHEN 0 THEN
                                        0
                                ELSE
                                        NVL (
                                                (
                                                        (TB2. REAL / TB7.DEMAND_HARIAN) * 100
                                                ),
                                                0
                                        )
                                END AS MARKETSHARE
                                FROM
                                        (
                                                SELECT
                                                        A .prov,
                                                        SUM (A .quantum) AS target
                                                FROM
                                                        sap_t_rencana_sales_type A
                                                WHERE
                                                        co = '$org'
                                                AND thn = '$tahun'
                                                AND bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                                GROUP BY
                                                        A .prov
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                PROPINSI_TO,
                                                SUM (QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG,
                                                PROPINSI_TO
                                ) TB2 ON TB1.PROV = TB2.PROPINSI_TO
                                LEFT JOIN (
                                        SELECT
                                                prov,
                                                SUM (target_realh) AS target_realh
                                        FROM
                                                (
                                                        SELECT
                                                                *
                                                        FROM
                                                                (
                                                                        SELECT
                                                                                A .prov,
                                                                                c.budat,
                                                                                SUM (
                                                                                        A .quantum * (c.porsi / D .total_porsi)
                                                                                ) AS target_realh
                                                                        FROM
                                                                                sap_t_rencana_sales_type A
                                                                        LEFT JOIN zreport_m_provinsi b ON A .prov = b.kd_prov
                                                                        LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                                                        AND c.vkorg = A .co
                                                                        AND c.budat LIKE '$tahun$bulan%'
                                                                        AND c.tipe = A .tipe
                                                                        LEFT JOIN (
                                                                                SELECT
                                                                                        region,
                                                                                        tipe,
                                                                                        SUM (porsi) AS total_porsi
                                                                                FROM
                                                                                        zreport_porsi_sales_region
                                                                                WHERE
                                                                                        budat LIKE '$tahun$bulan%'
                                                                                AND vkorg = '$org'
                                                                                GROUP BY
                                                                                        region,
                                                                                        tipe
                                                                        ) D ON c.region = D .region
                                                                        AND D .tipe = A .tipe
                                                                        WHERE
                                                                                co = '$org'
                                                                        AND thn = '$tahun'
                                                                        AND bln = '$bulan'
                                                                        GROUP BY
                                                                                co,
                                                                                thn,
                                                                                bln,
                                                                                A .prov,
                                                                                c.budat
                                                                )
                                                        WHERE
                                                                budat <= '$tahun$bulan$hari'
                                                )
                                        GROUP BY
                                                prov
                                ) TB3 ON TB1.PROV = TB3.PROV
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                PROPINSI_TO,
                                                MAX (QTY) HARIAN_MAX
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG,
                                                PROPINSI_TO
                                ) TB4 ON TB1.PROV = TB4.PROPINSI_TO
                                LEFT JOIN (
                                        SELECT
                                                tb5.id_prov PROV,
                                                tb6.nama_kabiro
                                        FROM
                                                ZREPORT_SCM_KABIRO_SALES tb5
                                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                                        WHERE
                                                TB5.ORG = '$org'
                                ) TB5 ON TB1.PROV = TB5.PROV
                                LEFT JOIN (
                                        SELECT
                                                PROPINSI,
                                                QTY RKAP_MS
                                        FROM
                                                ZREPORT_MS_RKAPMS
                                        WHERE
                                                KODE_PERUSAHAAN = '$kd_per'
                                        AND THN = '$tahun'
                                        AND STATUS = '0'
                                ) TB6 ON TB1.PROV = TB6.PROPINSI
                                LEFT JOIN (
                                        SELECT
                                                TB1.KD_PROV,
                                                (
                                                        tb1.qty * tb2.porsi / tb3.porsi_total
                                                ) DEMAND_HARIAN
                                        FROM
                                                (
                                                        SELECT
                                                                KD_PROV,
                                                                SUM (qty) qty
                                                        FROM
                                                                ZREPORT_SCM_DEMAND_PROVINSI
                                                        WHERE
                                                                tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        GROUP BY
                                                                KD_PROV
                                                ) tb1
                                        LEFT JOIN (
                                                SELECT
                                                        vkorg org,
                                                        SUM (porsi) porsi
                                                FROM
                                                        zreport_porsi_sales_region c
                                                WHERE
                                                        c.region = 5
                                                AND c.vkorg = '$org'
                                                AND c.budat LIKE '$tahun$bulan%'
                                                AND c.budat <= '$tahun$bulan$hari'
                                                GROUP BY
                                                        VKORG
                                        ) tb2 ON TB2.org = '$org'
                                        LEFT JOIN (
                                                SELECT
                                                        vkorg org,
                                                        SUM (porsi) porsi_total
                                                FROM
                                                        zreport_porsi_sales_region c
                                                WHERE
                                                        c.region = 5
                                                AND c.vkorg = '$org'
                                                AND c.budat LIKE '$tahun$bulan%'
                                                GROUP BY
                                                        VKORG
                                        ) tb3 ON TB2.org = tb3.org
                                ) TB7 ON TB1.PROV = TB7.KD_PROV
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN(
SELECT
	tbm1.KD_PROV,
	(
		tbm1.qty * tbm2.porsi / tbm3.porsi_total
	) DEMAND_HARIAN
FROM
	(
		SELECT
			KD_PROV,
			SUM (qty) qty
		FROM
			ZREPORT_SCM_DEMAND_PROVINSI
		WHERE
			tahun = '$tahun'
		AND bulan = '$bulan'
		GROUP BY
			KD_PROV
	) tbm1
LEFT JOIN (
	SELECT
		vkorg org,
		SUM (porsi) porsi
	FROM
		zreport_porsi_sales_region c
	WHERE
		c.region = 5
	AND c.vkorg = '$org'
	AND c.budat LIKE '$tahun$bulan%'
	AND c.budat <= '$tahun$bulan$hari'
	GROUP BY
		VKORG
) tbm2 ON tbm2.org = '$org'
LEFT JOIN (
	SELECT
		vkorg org,
		SUM (porsi) porsi_total
	FROM
		zreport_porsi_sales_region c
	WHERE
		c.region = 5
	AND c.vkorg = '$org'
	AND c.budat LIKE '$tahun$bulan%'
	GROUP BY
		VKORG
) tbm3 ON tbm2.org = tbm3.org)TB8 ON TB1.PROV = TB8.KD_PROV
LEFT JOIN (
	SELECT
		PROV,
		TO_CHAR(MAX (upd_date),'DD-MM-YYYY') AS upd_date,
		MIN(TRUNC(SYSDATE - upd_date)) as upd_count
	FROM
		(
			SELECT
				IDPROV AS PROV,
				(
					CASE
					WHEN UPDATE_ON IS NOT NULL THEN
						UPDATE_ON
					ELSE
						CREATED_ON
					END
				) AS upd_date
			FROM
				SCM_MI_M_MSFOTO
                        WHERE TO_CHAR(FOTODATE, 'mm') = '" . $bulan . "' 
                            " . ($org != 1 ? "AND COMPANY = '" . $org . "'" : "") . "
			UNION
				SELECT
					PROV_ID AS PROV,
					(
						CASE
						WHEN UPDATE_ON IS NOT NULL THEN
							UPDATE_ON
						ELSE
							CREATED_ON
						END
					) AS upd_date
				FROM
					SCM_MI_M_MSINFO
                                 WHERE TO_CHAR(INFODATE, 'mm') = '" . $bulan . "' 
                                     " . ($org != 1 ? "AND COMPANY = '" . $org . "'" : "") . "
		)
	GROUP BY
		PROV
) TB9 ON TB1.PROV = TB9.PROV
ORDER BY
	TB1.PROV");
        return $data->result_array();
    }

    function getDetailprov($idprov, $org, $bulan, $tahun) {
        if ($org != 1) {
            $this->db->where('COMPANY', $org);
        }
        $this->db->where('TO_CHAR(FOTODATE, \'mmyyyy\') = \''.$bulan.$tahun.'\'');
        $this->db->where('IDPROV', $idprov);
        $this->db->where('TIPEFOTO', 'LAPANGAN');
        $this->db->order_by("UPDATE_ON", "DESC");
        $this->db->order_by("CREATED_ON", "DESC");
        $data['foto_lap'] = $this->db->get('SCM_MI_M_MSFOTO')->row();
        if ($org != 1) {
            $this->db->where('COMPANY', $org);
        }
       $this->db->where('TO_CHAR(FOTODATE, \'mmyyyy\') = \''.$bulan.$tahun.'\'');
        $this->db->where('IDPROV', $idprov);
        $this->db->where('TIPEFOTO', 'GRAFIK');
        $this->db->order_by("UPDATE_ON", "DESC");
        $this->db->order_by("CREATED_ON", "DESC");
        $data['foto_gf'] = $this->db->get('SCM_MI_M_MSFOTO')->row();
        if ($org != 1) {
            $this->db->where('COMPANY', $org);
        }
       $this->db->where('TO_CHAR(INFODATE, \'mmyyyy\') = \''.$bulan.$tahun.'\'');
        $this->db->where('PROV_ID', $idprov);
        $this->db->order_by("COMPANY", "DESC");
        $this->db->order_by("URUTAN_INFO", "ASC");
        $data['info'] = $this->db->get('SCM_MI_M_MSINFO')->result();
        $this->db->select('NM_PROV');
        $this->db->where('KD_PROV', $idprov);
        $data['prov'] = $this->db->get('ZREPORT_M_PROVINSI')->row();
        if($idprov == '0001'){
            $data['prov']->NM_PROV = 'International Market';
        }
        return $data;
    }

    function getFoto($prov, $tipe) {
        $this->db->where('IDPROV', $prov);
        $this->db->where('TIPEFOTO', $tipe);
        $this->db->order_by("URUTAN_FOTO", "ASC");
//echo $this->db->last_query();
        return $this->db->get('SCM_MI_M_MSFOTO')->result();
    }

    function listInformasi($prov) {
        $search = $_POST['search'];
        $where = '';
        if (!empty($search['value'])) {
            $where = "AND (LOWER(INFORMASI) LIKE LOWER('%{$search['value']}%') 
                OR LOWER(NAMA_INFO) LIKE LOWER('%{$search['value']}%')
                OR LOWER(CREATED_BY) LIKE LOWER('%{$search['value']}%') 
                OR LOWER(UPDATE_BY) LIKE LOWER('%{$search['value']}%') 
                OR UPDATE_ON LIKE '%{$search['value']}%' 
                OR CREATED_ON LIKE '%{$search['value']}%')";
        }
        $query = $this->db->query("SELECT * FROM 
                (SELECT row_number() over (ORDER BY IDMSINFO desc) as seqnum,
                    COUNT(*) OVER () RESULT_COUNT,TO_CHAR(INFODATE,'MONTH-YYYY') tglinfo,SCM_MI_M_MSINFO.*
                FROM SCM_MI_M_MSINFO
                WHERE PROV_ID = '{$prov}' 
                {$where}
                ORDER BY IDMSINFO desc )
            WHERE seqnum BETWEEN " . ($_POST['start'] + 1) . " AND " . ($_POST['start'] + $_POST['length']) . "");
        return $query->result();
    }
    
    function check_urutan($val, $org, $tgl,$prov, $id){
        $this->db->where('URUTAN_INFO', $val);
        $this->db->where('COMPANY', $org);
        $this->db->where('PROV_ID', $prov);
        $this->db->where('INFODATE', "TO_DATE('{$tgl}', 'mm-yyyy')", FALSE);
        if($id){
            $this->db->where("IDMSINFO != '$id'");
        }
        //echo $this->db->last_query();
        return $this->db->count_all_results('SCM_MI_M_MSINFO');
        
    }
    
    function check_urutan_foto($val, $org, $tgl,$prov,$tipe, $id){
        $this->db->where('URUTAN_FOTO', $val);
        $this->db->where('COMPANY', $org);
        $this->db->where('TIPEFOTO', $tipe);
        $this->db->where('IDPROV', $prov);
        $this->db->where('FOTODATE', "TO_DATE('{$tgl}', 'mm-yyyy')", FALSE);
        if($id){
            $this->db->where("IDMSFOTO != '$id'");
        }
        //echo $this->db->last_query();
        return $this->db->count_all_results('SCM_MI_M_MSFOTO');
        
        
    }

    function addInformasi() {
        $data = $_POST;
        unset($data['ID']);
        unset($data['INFODATE']);
        $data['CREATED_BY'] = strtoupper($this->session->userdata('usernamescm'));
        $this->db->set('CREATED_ON', 'SYSDATE', FALSE);
        $this->db->set('INFODATE', "TO_DATE('{$_POST['INFODATE']}','mm-yyyy')", FALSE);
        $this->db->insert('SCM_MI_M_MSINFO', $data);
        $this->addLogActivity('', 'Menambahkan data Informasi Market Info ' . $data['NAMA_INFO'], $data['CREATED_BY'], 'SCM_MI_M_MSINFO', $data['PROV_ID'], 'INFORMASI');
    }

    function getCountAll($table) {
        return $this->db->count_all($table);
    }

    function detailInformasi($id) {
        $this->db->select("IDMSINFO,CREATED_BY,CREATED_ON,URUTAN_INFO,UPDATE_BY,UPDATE_ON,NAMA_INFO,PROV_ID,INFORMASI,TO_CHAR(INFODATE,'mm-yyyy') INFODATE,COMPANY");
        $this->db->where('IDMSINFO', $id);
        return $this->db->get('SCM_MI_M_MSINFO')->row_array();
    }

    function deleteInformasi($id) {
        $rsl = $this->detailInformasi($id);
        $this->db->where('IDMSINFO', $id);
        $this->db->delete('SCM_MI_M_MSINFO');
        $this->addLogActivity($id, 'Menghapus data Informasi Market Info ' . $rsl['NAMA_INFO'], strtoupper($this->session->userdata('usernamescm')), 'SCM_MI_M_MSINFO', $rsl['PROV_ID'], 'INFORMASI');
    }

    function updateInformasi() {
        $data = $_POST;
        unset($data['ID']);
        unset($data['INFODATE']);
        $data['UPDATE_BY'] = strtoupper($this->session->userdata('usernamescm'));
        $this->db->set('INFODATE', "TO_DATE('{$_POST['INFODATE']}','mm-yyyy')", FALSE);
        $this->db->set('UPDATE_ON', 'SYSDATE', FALSE);
        $this->db->where('IDMSINFO', $_POST['ID']);
        $this->db->update('SCM_MI_M_MSINFO', $data);
        $this->addLogActivity($_POST['ID'], 'Mengubah data Informasi Market Info ' . $data['NAMA_INFO'], $data['UPDATE_BY'], 'SCM_MI_M_MSINFO', $data['PROV_ID'], 'INFORMASI');
    }

    function listGambar($prov, $tipe) {
        $search = $_POST['search'];
        $where = '';
        if (!empty($search['value'])) {
            $where = "AND (LOWER(CAPTION) LIKE LOWER('%{$search['value']}%') 
                OR LOWER(CREATED_BY) LIKE LOWER('%{$search['value']}%') 
                OR LOWER(UPDATE_BY) LIKE LOWER('%{$search['value']}%') 
                OR UPDATE_ON LIKE '%{$search['value']}%' 
                OR CREATED_ON LIKE '%{$search['value']}%')";
        }
        $query = $this->db->query("SELECT * FROM 
                (SELECT row_number() over (ORDER BY IDMSFOTO desc) as seqnum,
                    COUNT(*) OVER () RESULT_COUNT,TO_CHAR(FOTODATE,'MONTH-YYYY') tglfoto,SCM_MI_M_MSFOTO.*
                FROM SCM_MI_M_MSFOTO
                WHERE IDPROV='{$prov}' AND TIPEFOTO='{$tipe}'
                {$where}
                ORDER BY IDMSFOTO desc )
            WHERE seqnum BETWEEN " . ($_POST['start'] + 1) . " AND " . ($_POST['start'] + $_POST['length']) . "");
        return $query->result();
    }

    function addGambar($foto) {
        $data = $_POST;
        unset($data['ID']);
        unset($data['FOTO']);
        unset($data['FOTODATE']);
        $data['MSFOTO'] = $foto;
        $data['CREATED_BY'] = strtoupper($this->session->userdata('usernamescm'));
        $this->db->set('CREATED_ON', 'SYSDATE', FALSE);
        $this->db->set('FOTODATE', "TO_DATE('{$_POST['FOTODATE']}','mm-yyyy')", FALSE);
        $this->db->insert('SCM_MI_M_MSFOTO', $data);
        if ($data['TIPEFOTO'] == 'LAPANGAN') {
            $this->addLogActivity('', 'Menambahkan data foto lapangan marketinfo', $data['CREATED_BY'], 'SCM_MI_M_MSFOTO', $data['IDPROV'], 'LAPANGAN');
        } else {
            $this->addLogActivity('', 'Menambahkan data gambar grafik marketinfo', $data['CREATED_BY'], 'SCM_MI_M_MSFOTO', $data['IDPROV'], 'GRAFIK');
        }
    }

    function detailGambar($id) {
        $this->db->select("IDMSFOTO,MSFOTO,IDPROV,URUTAN_FOTO,CREATED_BY,CREATED_ON,CAPTION,UPDATE_BY,UPDATE_ON,TIPEFOTO,TO_CHAR(FOTODATE,'mm-yyyy') FOTODATE,COMPANY");
        $this->db->where('IDMSFOTO', $id);
        return $this->db->get('SCM_MI_M_MSFOTO')->row_array();
    }

    function updateGambar($data, $id) {
        $data['UPDATE_BY'] = strtoupper($this->session->userdata('usernamescm'));
        $this->db->set('UPDATE_ON', 'SYSDATE', FALSE);
        $this->db->set('FOTODATE', "TO_DATE('{$data['FOTODATE']}','mm-yyyy')", FALSE);
        unset($data['FOTODATE']);
        $this->db->where('IDMSFOTO', $id);
        $this->db->update('SCM_MI_M_MSFOTO', $data);
        $rsl = $this->detailGambar($id);
        if ($rsl['TIPEFOTO'] == 'LAPANGAN') {
            $this->addLogActivity($id, 'Mengubah data foto lapangan marketinfo', $data['UPDATE_BY'], 'SCM_MI_M_MSFOTO', $rsl['IDPROV'], 'LAPANGAN');
        } else {
            $this->addLogActivity($id, 'Mengubah data gambar grafik marketinfo', $data['UPDATE_BY'], 'SCM_MI_M_MSFOTO', $rsl['IDPROV'], 'GRAFIK');
        }
    }

    function deleteGambar($id) {
        $rsl = $this->detailGambar($id);
        $this->db->where('IDMSFOTO', $id);
        $this->db->delete('SCM_MI_M_MSFOTO');
        if ($rsl['TIPEFOTO'] == 'LAPANGAN') {
            $this->addLogActivity($id, 'Menghapus data foto lapangan marketinfo', strtoupper($this->session->userdata('usernamescm')), 'SCM_MI_M_MSFOTO', $rsl['IDPROV'], 'LAPANGAN');
        } else {
            $this->addLogActivity($id, 'Menghapus data gambar grafik marketinfo', strtoupper($this->session->userdata('usernamescm')), 'SCM_MI_M_MSFOTO', $rsl['IDPROV'], 'GRAFIK');
        }
    }

    function getProv() {
        $this->db->select('KD_PROV,NM_PROV');
        $this->db->where_not_in('KD_PROV', array('1092','0001'));
        $result = $this->db->get('ZREPORT_M_PROVINSI');

        $dd = array();
        foreach ($result->result() as $row) {
            $dd[$row->KD_PROV] = $row->NM_PROV;
        }
        return $dd;
    }

    function listMarketInfo() {
        $search = $_POST['search'];
        $where = '';
        if (!empty($search['value'])) {
            $where = "WHERE LOWER(CASE KD_PROV WHEN '0001' THEN 'International Market' ELSE NM_PROV END) LIKE LOWER('%{$search['value']}%')";
        }
        $query = $this->db->query("SELECT * FROM 
                (SELECT row_number() over (ORDER BY NM_PROV asc) as seqnum,
                    COUNT(*) OVER () RESULT_COUNT,KD_PROV,NM_PROV
                FROM ZREPORT_M_PROVINSI
                {$where}
                ORDER BY NM_PROV asc )
            WHERE seqnum BETWEEN " . ($_POST['start'] + 1) . " AND " . ($_POST['start'] + $_POST['length']) . "");
        return $query->result();
    }

    function addLogActivity($id, $action, $user, $tablename, $provid, $tipe) {
        $data = array(
            'TABLENAME' => $tablename,
            'ACTION' => $action,
            'AUTHOR' => $user,
            'PROVID' => $provid,
            'TIPE' => $tipe
        );
        $this->db->set('LOGID', 'SCM_MI_MS_LOG_SEQ.nextval', FALSE);
        $this->db->set('LOGTIME', 'SYSDATE', FALSE);
        if ($id == '') {
            $this->db->set('TABLENAMEID', $tablename . '_SEQ.currval', FALSE);
        } else {
            $this->db->set('TABLENAMEID', $id);
        }
        $this->db->insert('SCM_MI_MS_LOG', $data);
    }

    function ListLog($prov, $tipe) {
        $search = $_POST['search'];
        $where = '';
        if (!empty($search['value'])) {
            $where = "AND (LOWER(ACTION) LIKE LOWER('%{$search['value']}%') 
                OR LOWER(AUTHOR) LIKE LOWER('%{$search['value']}%')  
                OR LOWER(LOGTIME) LIKE LOWER('%{$search['value']}%') ) ";
        }
        $query = $this->db->query("SELECT * FROM 
                (SELECT row_number() over (ORDER BY LOGID desc) as seqnum,
                    COUNT(*) OVER () RESULT_COUNT,SCM_MI_MS_LOG.*
                FROM SCM_MI_MS_LOG
                WHERE PROVID = '{$prov}' 
                    AND TIPE = '{$tipe}' 
                {$where}
                ORDER BY LOGID desc )
            WHERE seqnum BETWEEN " . ($_POST['start'] + 1) . " AND " . ($_POST['start'] + $_POST['length']) . "");
        return $query->result();
    }

///////////Notification//////////////
    function countNewsToday() {
        $this->db->where('TO_CHAR(LOGTIME, \'DD-MM-YYYY\') = TO_CHAR(SYSDATE, \'DD-MM-YYYY\')');
        //$this->db->not_like('LOWER(ACTION)', 'menghapus');
        $this->db->from('SCM_MI_MS_LOG');
        $data = $this->db->count_all_results();
        return $data;
    }

    function getNews() {
        return $this->db->query("
            SELECT
                    LOWER (AUTHOR) AUTHOR,
                    ACTION,
                    PROVID,
                    NM_PROV,
                    TO_CHAR (LOGTIME, 'DD-MM-YYYY') LOGTIME,
                    TIPE,
                    NAMA_INFO
            FROM
                    SCM_MI_MS_LOG \"LOG\"
            JOIN ZREPORT_M_PROVINSI PROV ON \"LOG\".PROVID = PROV.KD_PROV
            LEFT JOIN SCM_MI_M_MSINFO ON IDMSINFO = TABLENAMEID
            LEFT JOIN SCM_MI_M_MSFOTO ON IDMSFOTO = TABLENAMEID
            WHERE
                    ROWNUM <= 100
            ORDER BY
                    LOGID DESC
                ")->result_array();
    }
    
    //////////SCO PETA PENCAPAIAN/////////
    function scodatamv($org,$tahun,$bulan,$hari){
        if($org=='7000'){
            $orgQ = '7000,5000';
        }else{
            $orgQ = $org;
        }
        $sql = "SELECT
                        TB1.PROV,
                        TB1.TARGET,
                        NVL (
                                (TB2.REAL_BAG + TB2.REAL_BULK),
                                0
                        ) REAL,
                        NVL (TB2.REAL_BAG, 0) REAL_BAG,
                        NVL (TB2.REAL_BULK, 0) REAL_BULK,
                        TB3.NM_PROV,
                        TB4.TARGET_REALH
                FROM
                        (
                                SELECT
                                        A .prov,
                                        SUM (A .quantum) AS target
                                FROM
                                        sap_t_rencana_sales_type A
                                WHERE
                                        co = '$org'
                                AND thn = '$tahun'
                                AND bln = '$bulan'
                                AND A .prov != '0001'
                                AND A .prov != '1092'
                                GROUP BY
                                        A .prov
                        ) TB1
                LEFT JOIN (
                        SELECT
                                PROV,
                                NVL (BAG_REAL, 0) REAL_BAG,
                                NVL (BULK_REAL, 0) REAL_BULK
                        FROM
                                (
                                        SELECT
                                                PROV,
                                                SUM (REALTO) REALTO,
                                                TIPE
                                        FROM
                                                (
                                                        SELECT
                                                                PROPINSI_TO PROV,
                                                                SUM (QTY) REALTO,
                                                                ITEM TIPE
                                                        FROM
                                                                ZREPORT_SCM_REAL_SALES
                                                        WHERE
                                                                org IN ($orgQ)
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND hari <= '$hari'
                                                        AND ITEM != '121-200'
                                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                                        GROUP BY
                                                                PROPINSI_TO,
                                                                ITEM
                                                        UNION
                                                                SELECT
                                                                        \"kd_prov\" PROV,
                                                                        SUM (\"qty\") REALTO,
                                                                        \"item\" TIPE
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"tahun\" = '$tahun'
                                                                AND \"bulan\" = '$bulan'
                                                                AND \"hari\" <= '$hari'
                                                                AND \"org\" = '$org'
                                                                AND \"kd_prov\" IS NOT NULL
                                                                AND \"item\" IS NOT NULL
                                                                GROUP BY
                                                                        \"kd_prov\",
                                                                        \"item\"
                                                )
                                        GROUP BY
                                                PROV,
                                                TIPE
                                ) PIVOT (
                                        SUM (REALTO) AS REAL FOR (TIPE) IN (
                                                '121-301' AS BAG,
                                                '121-302' AS BULK
                                        )
                                )
                ) TB2 ON TB1.PROV = TB2.PROV
                LEFT JOIN ZREPORT_M_PROVINSI TB3 ON TB1.PROV = TB3.KD_PROV
                LEFT JOIN (
                        SELECT
                                prov,
                                SUM (target_realh) AS target_realh
                        FROM
                                (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                A .prov,
                                                                c.budat,
                                                                SUM (
                                                                        A .quantum * (c.porsi / D .total_porsi)
                                                                ) AS target_realh
                                                        FROM
                                                                sap_t_rencana_sales_type A
                                                        LEFT JOIN zreport_m_provinsi b ON A .prov = b.kd_prov
                                                        LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                                        AND c.vkorg = A .co
                                                        AND c.budat LIKE '$tahun$bulan%'
                                                        AND c.tipe = A .tipe
                                                        LEFT JOIN (
                                                                SELECT
                                                                        region,
                                                                        tipe,
                                                                        SUM (porsi) AS total_porsi
                                                                FROM
                                                                        zreport_porsi_sales_region
                                                                WHERE
                                                                        budat LIKE '$tahun$bulan%'
                                                                AND vkorg = '$org'
                                                                GROUP BY
                                                                        region,
                                                                        tipe
                                                        ) D ON c.region = D .region
                                                        AND D .tipe = A .tipe
                                                        WHERE
                                                                co = '$org'
                                                        AND thn = '$tahun'
                                                        AND bln = '$bulan'
                                                        GROUP BY
                                                                co,
                                                                thn,
                                                                bln,
                                                                A .prov,
                                                                c.budat
                                                )
                                        WHERE
                                                budat <= '$tahun$bulan$hari'
                                )
                        GROUP BY
                                prov
                ) TB4 ON TB1.PROV = TB4.PROV";
        //echo $sql;
        $data = $this->db->query($sql);
        return $data->result_array();
    }
    
    function maxharianNew($org,$tahun,$bulan,$hari){
        $data = $this->db->query("SELECT
                                        org,
                                        PROPINSI_TO PROV,
                                        MAX (qty) HARIAN_MAX
                                FROM
                                        (
                                                SELECT
                                                        ORG,
                                                        PROPINSI_TO,
                                                        HARI,
                                                        SUM (QTY) QTY
                                                FROM
                                                        (
                                                                SELECT
                                                                        ORG,
                                                                        PROPINSI_TO,
                                                                        HARI,
                                                                        SUM (QTY) qty
                                                                FROM
                                                                        ZREPORT_SCM_REAL_SALES
                                                                WHERE
                                                                        ORG = '$org'
                                                                AND TAHUN = '$tahun'
                                                                AND BULAN = '$bulan'
                                                                AND HARI <= '$hari'
                                                                AND PROPINSI_TO NOT IN ('1092', '0001')
                                                                GROUP BY
                                                                        ORG,
                                                                        PROPINSI_TO,
                                                                        HARI
                                                                UNION
                                                                        SELECT
                                                                                \"org\" ORG,
                                                                                \"kd_prov\" PROPINSI_TO,
                                                                                \"hari\" HARI,
                                                                                SUM (\"qty\") QTY
                                                                        FROM
                                                                                ZREPORT_REAL_ST_ADJ
                                                                        WHERE
                                                                                \"org\" = '$org'
                                                                        AND \"tahun\" = '$tahun'
                                                                        AND \"bulan\" = '$bulan'
                                                                        AND \"hari\" <= '$hari'
                                                                        AND \"kd_prov\" IS NOT NULL
                                                                        GROUP BY
                                                                                \"org\",
                                                                                \"kd_prov\",
                                                                                \"hari\"
                                                        )
                                                GROUP BY
                                                        ORG,
                                                        PROPINSI_TO,
                                                        HARI
                                        )
                                GROUP BY
                                        ORG,
                                        PROPINSI_TO");
        return $data->result_array();
    }
    
    function getProv2() {
        $data = $this->db->query("SELECT KD_PROV, NM_PROV FROM ZREPORT_M_PROVINSI WHERE KD_PROV != '0001' AND KD_PROV != '1092'");
        return $data->result_array();
    }
    
    
}

