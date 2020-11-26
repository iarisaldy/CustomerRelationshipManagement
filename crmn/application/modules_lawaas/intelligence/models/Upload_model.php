<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class Upload_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function cek_msperusahaan($data) {
        $result = $this->db->query("SELECT * FROM ZREPORT_MS_PERUSAHAAN WHERE KODE_PERUSAHAAN = '{$data['KODE_PERUSAHAAN']}' AND STATUS = 0");

        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_msperusahaan($data) {
        $this->db->set('UPDATE_DATE', 'CURRENT_TIMESTAMP', FALSE);
        $this->db->where('KODE_PERUSAHAAN', $data['KODE_PERUSAHAAN']);
        $this->db->where('STATUS = 0');
        unset($data['KODE_PERUSAHAAN']);
        unset($data['CREATE_BY']);
        unset($data['CREATE_DATE']);
        unset($data['STATUS']);
        $result = $this->db->update('ZREPORT_MS_PERUSAHAAN', $data);
        if ($result == 1) {
            return 'Data Sukses Diupdate';
        } else {
            return 'Data Gagal Diupdate';
        }
    }

    function insert_scm($data, $table) {
        foreach ($data as $key => $value) {
            if ($value == 'SYSDATE' || $value == 'CURRENT_TIMESTAMP') {
                $this->db->set($key, $value, FALSE);
                unset($data[$key]);
            }
        }
        $result = $this->db->insert($table, $data);
        if ($result == 1) {
            return 'Data Sukses Diinputkan';
        } else {
            return 'Data Gagal Diinputkan';
        }
    }

    function cek_rkapms($kode_perusahaan, $propinsi, $tahun) {
        $data = $this->db->query("SELECT * FROM ZREPORT_MS_RKAPMS WHERE KODE_PERUSAHAAN = '$kode_perusahaan' AND PROPINSI = '$propinsi' AND THN = '$tahun' AND STATUS = 0");
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_rkapms($data) {
        $this->db->where('KODE_PERUSAHAAN', $data['KODE_PERUSAHAAN']);
        $this->db->where('THN', $data['THN']);
        $this->db->where('PROPINSI', $data['PROPINSI']);
        unset($data['KODE_PERUSAHAAN']);
        unset($data['PROPINSI']);
        unset($data['THN']);
        unset($data['CREATE_DATE']);
        unset($data['CREATE_BY']);
        $this->db->set('UPDATE_DATE', 'CURRENT_TIMESTAMP', FALSE);
        $result = $this->db->update('ZREPORT_MS_RKAPMS', $data);
        if ($result == 1) {
            return 'Data Sukses Diupdate';
        } else {
            return 'Data Gagal Diupdate';
        }
    }

    function cek_mstrans($data) {
        $this->db->where('KODE_PERUSAHAAN', $data['KODE_PERUSAHAAN']);
        $this->db->where('TAHUN', $data['TAHUN']);
        $this->db->where('PROPINSI', $data['PROPINSI']);
        $this->db->where('BULAN', $data['BULAN']);
        $this->db->where('TIPE', $data['TIPE']);
        $this->db->where('STATUS', '0');
        $result = $this->db->get('ZREPORT_MS_TRANS1');
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_mstrans($data) {
        $this->db->where('KODE_PERUSAHAAN', $data['KODE_PERUSAHAAN']);
        $this->db->where('TAHUN', $data['TAHUN']);
        $this->db->where('PROPINSI', $data['PROPINSI']);
        $this->db->where('BULAN', $data['BULAN']);
        $this->db->where('TIPE', $data['TIPE']);
        unset($data['KODE_PERUSAHAAN']);
        unset($data['TAHUN']);
        unset($data['PROPINSI']);
        unset($data['BULAN']);
        unset($data['TIPE']);
        unset($data['CREATE_BY']);
        unset($data['CREATE_DATE']);
        $this->db->set('UPDATE_DATE', 'CURRENT_TIMESTAMP', false);
        $result = $this->db->update('ZREPORT_MS_TRANS1', $data);
        if ($result == 1) {
            return 'Data Sukses Diupdate';
        } else {
            return 'Data Gagal Diupdate';
        }
    }

    function cek_msdemand($data) {
        $this->db->where('KD_PROV', $data['KD_PROV']);
        $this->db->where('BULAN', $data['BULAN']);
        $this->db->where('TAHUN', $data['TAHUN']);
        $result = $this->db->get('ZREPORT_SCM_DEMAND_PROVINSI', $data);
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_msdemand($data) {
        $this->db->where('KD_PROV', $data['KD_PROV']);
        $this->db->where('BULAN', $data['BULAN']);
        $this->db->where('TAHUN', $data['TAHUN']);
        unset($data['KD_PROV']);
        unset($$data['BULAN']);
        unset($data['TAHUN']);
        unset($data['CREATE_DATE']);
        unset($data['CREATE_BY']);
        $this->db->set('UPDATED_DATE', 'CURRENT_TIMESTAMP', false);
        $result = $this->db->update('ZREPORT_SCM_DEMAND_PROVINSI', $data);
        if ($result == 1) {
            return 'Data Sukses Diupdate';
        } else {
            return 'Data Gagal Diupdate';
        }
    }

    function getNamaPerusahaan($kode_perusahaan) {
        $result = $this->db->query("SELECT NAMA_PERUSAHAAN FROM ZREPORT_MS_PERUSAHAAN WHERE KODE_PERUSAHAAN = '$kode_perusahaan'")->row();
        return $result->NAMA_PERUSAHAAN;
    }

}
