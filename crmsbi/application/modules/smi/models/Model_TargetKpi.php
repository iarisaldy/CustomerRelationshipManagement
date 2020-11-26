<?php
    class Model_TargetKpi extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function checkTarget($data, $type){
            $this->db->select("*");
            $this->db->from("CRMNEW_TARGET_".$type."_KPI");
            $this->db->where($data);

            $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }

        public function deleteNull($type){
            $this->db->where(array($type => NULL));
            $this->db->delete("CRMNEW_TARGET_".$type."_KPI");
        }

        public function deleteTarget($data, $type){
            $this->db->where($data);
            $this->db->delete("CRMNEW_TARGET_".$type."_KPI");
            if($this->db->affected_rows() > 0){
                $this->deleteNull($type);
                return true;
            } else {
                return false;
            }
        }

        public function listTarget($bulan, $tahun, $distributor = null, $provinsi = null, $area = null){
            $whereDistributor = "";
            $whereProvinsi = "";
            $whereArea = "";

            $whereDistributor2 = "";
            $whereProvinsi2 = "";
            $whereArea2 = "";

            if(isset($distributor)){
                if($distributor != ""){
                    $whereDistributor = "AND TVK.KODE_DISTRIBUTOR = '$distributor'";
                    $whereDistributor2 = "AND KODE_DISTRIBUTOR = '$distributor'";
                }
            }

            if(isset($provinsi)){
                if($provinsi != ""){
                    $whereProvinsi = "AND TVK.ID_PROVINSI = '$provinsi'";
                    $whereProvinsi2 = "AND ID_PROVINSI = '$provinsi'";
                }
            }

            if(isset($area)){
                if($area != ""){
                    $area = substr($area, -2);
                    $whereArea = "AND TVK.ID_AREA = '$area'";
                    $whereArea2 = "AND ID_AREA = '$area'";
                }
            }

            $sql = "SELECT
                         CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR,
                        TVK.KODE_DISTRIBUTOR,
                        CRMNEW_M_PROVINSI.NAMA_PROVINSI,
                        TVK.ID_PROVINSI,
                        TVK.ID_AREA,
                        SUM( TVK.VOLUME ) AS VOLUME,
                        SUM(THK.HARGA) AS HARGA,
                        (SUM(TVK.VOLUME) * SUM(THK.HARGA)) AS REVENUE
                    FROM
                        CRMNEW_TARGET_VOLUME_KPI TVK
                        LEFT JOIN ( SELECT KODE_DISTRIBUTOR, ID_PROVINSI, ID_AREA, HARGA FROM CRMNEW_TARGET_HARGA_KPI WHERE BULAN = '$bulan' AND TAHUN = '$tahun' $whereDistributor2 $whereProvinsi2 $whereArea2 AND KODE_DISTRIBUTOR IS NOT NULL AND ID_PROVINSI IS NOT NULL AND ID_AREA IS NOT NULL AND HARGA IS NOT NULL AND DELETE_MARK = 0 ) THK ON TVK.KODE_DISTRIBUTOR = THK.KODE_DISTRIBUTOR AND  TVK.ID_PROVINSI = THK.ID_PROVINSI AND TVK.ID_AREA = THK.ID_AREA
                        LEFT JOIN CRMNEW_DISTRIBUTOR ON TVK.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR
                        LEFT JOIN CRMNEW_M_PROVINSI ON TVK.ID_PROVINSI = CRMNEW_M_PROVINSI.ID_PROVINSI
                    WHERE
                        TVK.BULAN = '$bulan' 
                        AND TVK.TAHUN = '$tahun' 
                        $whereDistributor
                        $whereProvinsi $whereArea AND TVK.KODE_DISTRIBUTOR IS NOT NULL AND TVK.ID_PROVINSI IS NOT NULL AND TVK.ID_AREA IS NOT NULL AND TVK.VOLUME IS NOT NULL AND TVK.DELETE_MARK = 0
                    GROUP BY
                        TVK.KODE_DISTRIBUTOR,
                        TVK.ID_PROVINSI,
                        TVK.ID_AREA, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR, CRMNEW_M_PROVINSI.NAMA_PROVINSI";
            $target = $this->db->query($sql);
            if($target->num_rows() > 0){
                return $target->result();
            } else {
                return false;
            }
        }

        public function listTargetCustomer($bulan, $tahun, $idDistributor = null){
            if(isset($bulan) || isset($tahun)){
                $this->db->where("CRMNEW_TARGET_CUSTOMER_KPI.BULAN", $bulan);
                $this->db->where("CRMNEW_TARGET_CUSTOMER_KPI.TAHUN", $tahun);
            }

            if(isset($idDistributor)){
                if($idDistributor != ""){
                    $this->db->where("CRMNEW_TARGET_CUSTOMER_KPI.KODE_DISTRIBUTOR", $idDistributor);
                }
            }

            $this->db->select("CRMNEW_TARGET_CUSTOMER_KPI.ID_TARGET_CUSTOMER, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR, CRMNEW_TARGET_CUSTOMER_KPI.TARGET_KEEP, CRMNEW_TARGET_CUSTOMER_KPI.TARGET_GET, CRMNEW_TARGET_CUSTOMER_KPI.TARGET_GROWTH")->from("CRMNEW_TARGET_CUSTOMER_KPI")->join("CRMNEW_DISTRIBUTOR", "CRMNEW_TARGET_CUSTOMER_KPI.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR")->where("CRMNEW_TARGET_CUSTOMER_KPI.DELETE_MARK", "0");
            $target = $this->db->get();
            if($target->num_rows() > 0){
                return $target->result();
            } else {
                return false;
            }
        }

        public function insertVolume($data){
            $this->db->insert_batch("CRMNEW_TARGET_VOLUME_KPI", $data);

            if($this->db->affected_rows() > 0){
                return true;
            } else {
                return false;
            }
        }

        public function insertHarga($data){
            $this->db->insert_batch("CRMNEW_TARGET_HARGA_KPI", $data);

            if($this->db->affected_rows() > 0){
                return true;
            } else {
                return false;
            }
        }

        public function insertCustomer($data){
            $this->db->insert_batch("CRMNEW_TARGET_CUSTOMER_KPI", $data);

            if($this->db->affected_rows() > 0){
                return true;
            } else {
                return false;
            }
        }
    }
?>