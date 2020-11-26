<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Model_area extends CI_Model {

        public function listArea($idArea = null){
            if(isset($idArea)){
                $this->db->where('CRMNEW_M_AREA.ID_PROVINSI', $idArea);
            }
            $this->db->select('ID_AREA, ID_PROVINSI, NAMA_AREA');
            $this->db->from('CRMNEW_M_AREA');

            $area = $this->db->get();
            if($area->num_rows() > 0){
                return $area->result();
            } else {
                return false;
            }
        }
        
        public function listRadiusAreaLock(){
            $kdArea = null;
            if(isset($_POST['kd_area'])){
                $kdArea = $_POST['kd_area'];
            }
            
            $sql = "
                SELECT 
                    cra.id_radius_area,
                    cma.kd_area,
                    cra.id_area,
                    cma.nama_area,
                    cma.id_provinsi,
                    cmp.nama_provinsi,
                    cmp.id_region as region,
                    cra.radius_lock
                FROM CRMNEW_RADIUS_AREA CRA
                    JOIN CRMNEW_M_AREA CMA ON CMA.ID_AREA = CRA.ID_AREA
                    JOIN CRMNEW_M_PROVINSI CMP ON cma.id_provinsi = cmp.id_provinsi
                WHERE cra.deleted_mark = 0
            ";
            
            if($kdArea != null){
                $sql .= " AND cma.kd_area in ($kdArea)";
            }
            
            $sql .= " ORDER BY cma.nama_area ASC";
            //return $this->db->query($sql)->result_array();
            
            $list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
            
        }
        
        public function CustomerRadiusArea(){
            $kd_customer = null;
            if(isset($_POST['kd_customer'])){
                $kd_customer = $_POST['kd_customer'];
            }
            
            $sql = "
            
            ";
            
        }

    }
?>