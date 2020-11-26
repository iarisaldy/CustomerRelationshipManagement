<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class APIForca_model extends CI_Model {
  private $db2;
  function __construct() {
    parent::__construct();
  }

  public function getDataCrmStokGudang(){
    $this->db2 = $this->load->database('marketplace', TRUE);

    $sql = "SELECT * FROM TPL_CRM_GUDANG_SERVICE_FORCA";
    $result = $this->db2->query($sql);
    return $result->result_array();
  }

  public function getDataGR(){
    $this->db2 = $this->load->database('marketplace', TRUE);

    $sql = "SELECT * FROM TPL_T_GR_SERVICE_FORCA";
    $result = $this->db2->query($sql);
    return $result->result_array();
  }

  public function getDataPenjualan(){
    $this->db2 = $this->load->database('marketplace', TRUE);

    $sql = "SELECT * FROM TPL_T_JUAL_DTL_SERVICE_FORCA";
    $result = $this->db2->query($sql);
    return $result->result_array();
  }

  function InsertDataStokForca($dataGudang) {
    $this->db2 = $this->load->database('marketplace', TRUE);
    date_default_timezone_set("Asia/Jakarta");

    $DataStokCRM = $this->getDataCrmStokGudang();
    $kd_asal_data   = 'DIST';
    $tgl_kirim      = date("Y-m-d");
    $flag           = 0;
    $dataGdg        = $dataGudang->resultdata;

    foreach ($dataGdg as $dt) {
      $kd_distributor     = $dt->SOLD_TO;//M
      $nm_distributor     = $dt->NM_SOLD_TO;//M
      $kd_shipto          = $dt->KODE_SHIPTO;//M
      $nm_shipto          = $dt->NAMA_SHIPTO;//M
      $qty_stok           = $dt->STOK;//M
      $kd_material        = $dt->ITEM_NO;//M
      $nm_material        = $dt->PRODUK;
      // $satuan             = $dt->SATUAN;//M
      $satuan             = 'ZAK';//M
      $tanggal_transaksi  = $dt->TGL_TRANSAKSI;

      foreach ($DataStokCRM as $dta) {
        // echo '<br>'.$dt->ITEM_NO.'<br>'. $dta['ITEM_NO'].'<br>'.$dt->KODE_SHIPTO .'<br>'. $dta['KODE_SHIPTO'].'<br>'. date('Y-m-d', strtotime($dt->TGL_TRANSAKSI)).'<br>'. date('Y-m-d', strtotime($dta['TGL_STOK']));
        if(($dt->ITEM_NO == $dta['ITEM_NO']) && ($dt->KODE_SHIPTO == $dta['KODE_SHIPTO']) && (date('Y-m-d', strtotime($dt->TGL_TRANSAKSI)) == date('Y-m-d', strtotime($dta['TGL_STOK']))) ){
          $flag=1;
          break;
        }
        else{
          $flag =2;
        }
      }
      echo $flag;
      
      if($flag == 1 ){
        $update = array(
                "QTY_STOK"    => $qty_stok,
                "UDPATE_DATE"   => date('d-M-y'),
                "TANGGAL_KIRIM" => date('d-M-y', strtotime($tanggal_transaksi)),
                "UPDATE_BY"   => $kd_asal_data
          );
        // $this->update_data_gudang($update,$kd_material,$kd_shipto, $qty_stok, $kd_asal_data, $tanggal_transaksi);
      }
      else{
        
        $sqlInsert = "INSERT INTO TPL_CRM_GUDANG_SERVICE_FORCA (SOLD_TO,
                              NAMA_SOLD_TO,
                              KODE_SHIPTO,
                              NAMA_SHIPTO,
                              TGL_STOK,
                              QTY_STOK,
                              CREATE_DATE,
                              CREATE_BY,
                              ITEM_NO,
                              PRODUK,
                              KD_ASAL_DATA,
                              TANGGAL_KIRIM)
                          VALUES('".$kd_distributor."',
                              '".$nm_distributor."',
                              '".$kd_shipto."',
                              '".$nm_shipto."',
                              '".date('d-M-y', strtotime($tanggal_transaksi))."',
                              '".$qty_stok."',
                              SYSTIMESTAMP,
                              '".$kd_asal_data."',
                              '".$kd_material."',
                              '".$nm_material."',
                              '".$kd_asal_data."',
                              '".date('d-M-y', strtotime($tgl_kirim))."') ";
        $this->db2->query($sqlInsert);
      }
    }

    // return $data->result_array();
    }

  function InsertDataGRForca($dataGR) {
    $this->db2 = $this->load->database('marketplace', TRUE);
    date_default_timezone_set("Asia/Jakarta");

    $DataGRForca = $this->getDataGR();

    // $kd_asal_data   = 'DIST';
    $tgl_kirim      = date("Y-m-d");
    $flag           = 0;
    $dataGdgGR        = $dataGR->resultdata;

    foreach ($dataGdgGR as $dt) {
      $kd_customer        = $dt->KD_CUSTOMER;//M
      $nm_customer        = $dt->NAMA_CUSTOMER;//M
      $kd_distributor     = $dt->KD_DISTRIBUTOR;//M
      $no_spj             = $dt->NO_SPJ;//M
      $no_do              = $dt->NO_DO;//M
      $kd_material        = $dt->KD_PRODUK;//M
      $qty_stok           = $dt->QTY;//M
      $satuan             = $dt->SATUAN;//M
      $tanggal_transaksi  = $dt->TANGGAL;
      $opco               = $dt->OPCO;
      $kd_asal_data       = $dt->KD_ASAL_DATA;


      foreach ($DataGRForca as $dta) {
        if(($dt->KD_CUSTOMER == $dta['KD_CUSTOMER']) && ($dt->NO_SPJ == $dta['NO_SPJ']) && ($dt->NO_DO == $dta['NO_DO']) && (date('Y-m-d', strtotime($dt->TANGGAL)) == date('Y-m-d', strtotime($dta['TANGGAL_GR']))) ){
          $flag=1;
          break;
        }
        else{
          $flag =2;
        }
      }

      echo $flag;
      if($flag == 1 ){
        // $update = array(
        //         "QTY_STOK"    => $qty_stok,
        //         "UDPATE_DATE"   => date('d-M-y'),
        //         "TANGGAL_KIRIM" => date('d-M-y', strtotime($tanggal_transaksi)),
        //         "UPDATE_BY"   => $kd_asal_data
        //   );
        // $this->update_data_gudang($update,$kd_material,$kd_shipto, $qty_stok, $kd_asal_data, $tanggal_transaksi);
      }
      else{
        $sqlInsert = "INSERT INTO TPL_T_GR_SERVICE_FORCA (KD_CUSTOMER,
                                                                KD_DISTRIBUTOR,
                                                                NO_SPJ,
                                                                NO_DO,
                                                                CREATE_DATE,
                                                                KD_ASAL_DATA,
                                                                TANGGAL_GR,
                                                                KD_PRODUK,
                                                                QTY,
                                                                QTY_TERIMA,
                                                                QTY_RUSAK,
                                                                QTY_PECAH,
                                                                SATUAN,
                                                                QTY_HILANG,
                                                                ORG)
                                          VALUES('".$kd_customer."',
                                              '".$kd_distributor."',
                                              '".$no_spj."',
                                              '".$no_do."',
                                              SYSTIMESTAMP,
                                              '".$kd_asal_data."',
                                              '".date('d-M-y', strtotime($tanggal_transaksi))."',
                                              '".$kd_material."',
                                              '".$qty_stok."',
                                              '".$qty_stok."',
                                              '0',
                                              '0',
                                              '".$satuan."',
                                              '0',
                                              '".$opco."')";
            $this->db2->query($sqlInsert);
          }
      }
    }

  function InsertDataJualForca($dataJual) {
    $this->db2 = $this->load->database('marketplace', TRUE);
    date_default_timezone_set("Asia/Jakarta");

    $DataGRForca = $this->getDataPenjualan();

    // $kd_asal_data   = 'DIST';
    $tgl_kirim      = date("Y-m-d");
    $flag           = 0;
    $dataPenjualan  = $dataJual->resultdata;

    foreach ($dataPenjualan as $dt) {
      $no_transaksi       = $dt->NO_TRANSAKSI;//M
      $no_transaksi_dtl   = $dt->NO_TRANSAKSI_DTL;//M
      $kd_gudang          = $dt->KD_GUDANG;//M
      $nm_gudang          = $dt->NM_GUDANG;//M
      $kd_tujuan          = $dt->KD_TUJUAN;//M
      $nm_tujuan          = $dt->NM_TUJUAN;//M
      $kd_distributor     = $dt->KD_DISTRIBUTOR;//M
      $nm_distributor     = $dt->NM_DISTRIBUTOR;//M
      $tgl_transaksi      = $dt->TGL_TRANSAKSI;//M
      $no_pol             = $dt->NO_POL;//M
      $kd_produk          = $dt->KD_PRODUK;
      $nm_produk          = $dt->NM_MATERIAL;
      $qty_jual           = $dt->QTY;
      $harga              = $dt->HARGA;
      $satuan              = $dt->SATUAN;
      $opco               = $dt->OPCO;
      // $kd_asal_data       = $dt->KD_ASAL_DATA;


      foreach ($DataGRForca as $dta) {
        if(($dt->NO_TRANSAKSI_DTL == $dta['ID_DTL_JUAL']) && ($dt->NO_TRANSAKSI == $dta['ID_HDR_JUAL']) && ($dt->KD_GUDANG == $dta['KD_GUDANG']) && ($dt->KD_TUJUAN == $dta['KD_TUJUAN']) && ($dt->KD_DISTRIBUTOR == $dta['KD_DISTRIBUTOR']) && (date('Y-m-d', strtotime($dt->TGL_TRANSAKSI)) == date('Y-m-d', strtotime($dta['TGL_TRANSAKSI']))) ){
          $flag=1;
          break;
        }
        else{
          $flag =2;
        }
      }

      echo $flag;
      if($flag == 1 ){
        // $update = array(
        //         "QTY_STOK"    => $qty_stok,
        //         "UDPATE_DATE"   => date('d-M-y'),
        //         "TANGGAL_KIRIM" => date('d-M-y', strtotime($tanggal_transaksi)),
        //         "UPDATE_BY"   => $kd_asal_data
        //   );
        // $this->update_data_gudang($update,$kd_material,$kd_shipto, $qty_stok, $kd_asal_data, $tanggal_transaksi);
      }
      else{
        $sqlInsert = "INSERT INTO TPL_T_JUAL_DTL_SERVICE_FORCA (ID_DTL_JUAL,
                                                          ID_HDR_JUAL,
                                                          NO_TRANSAKSI,
                                                          KD_GUDANG,
                                                          NM_GUDANG,
                                                          KD_TUJUAN,
                                                          NM_TUJUAN,
                                                          KD_DISTRIBUTOR,
                                                          NM_DISTRIBUTOR,
                                                          TGL_TRANSAKSI,
                                                          CREATE_DATE,
                                                          NO_POL,
                                                          KD_PRODUK,
                                                          NM_MATERIAL,
                                                          QTY,
                                                          HARGA,
                                                          SATUAN,
                                                          OPCO)
                                          VALUES('".$no_transaksi."',
                                              '".$no_transaksi_dtl."',
                                              '".$no_transaksi."',
                                              '".$kd_gudang."',
                                              '".$nm_gudang."',
                                              '".$kd_tujuan."',
                                              '".$nm_tujuan."',
                                              '".$kd_distributor."',
                                              '".$nm_distributor."',
                                              '".date('d-M-y', strtotime($tgl_transaksi))."',
                                              SYSTIMESTAMP,
                                              '".$no_pol."',
                                              '".$kd_produk."',
                                              '".$nm_produk."',
                                              '".$qty_jual."',
                                              '".$harga."',
                                              '".$satuan."',
                                              '".$opco."')";
            $this->db2->query($sqlInsert);
          }
      }
    }

  // ==========================================================
}
