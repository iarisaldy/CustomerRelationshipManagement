<?php
if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED'); }

class Model_user extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function lastUserId(){
        $this->db->select("MAX(ID_USER) AS ID_USER");
        $this->db->from("CRMNEW_USER");
        return $this->db->get()->row();
    }

    public function changePassword($id, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $this->db->where("ID_USER", $id)->update("CRMNEW_USER", $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function listUser($param = null, $id = null){
        $idJenisUser = $this->session->userdata("id_jenis_user");
        if($idJenisUser == "1007"){
            $kodeDist = $this->session->userdata("kode_dist");
            $this->db->where("CRMNEW_USER.ID_JENIS_USER", "1003");
            $this->db->where("CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR", $kodeDist);
        }

        if(isset($param)){
            if($param == "iduser"){
                if(isset($id)){
                    $this->db->where('CRMNEW_USER.ID_USER', $id);
                }
            } else if($param == "idrole"){
                if(isset($id) || $id != ""){
                    $this->db->where('CRMNEW_USER.ID_JENIS_USER', $id);
                }
            }
        }
        $this->db->select('CRMNEW_USER.ID_USER, CRMNEW_USER.ID_REGION, CRMNEW_USER.EMAIL, CRMNEW_USER.NAMA, CRMNEW_USER.USERNAME, CRMNEW_USER.PASSWORD, CRMNEW_JENIS_USER.JENIS_USER, CRMNEW_USER.ID_JENIS_USER');
        $this->db->from('CRMNEW_USER');
        $this->db->join('CRMNEW_JENIS_USER', 'CRMNEW_USER.ID_JENIS_USER = CRMNEW_JENIS_USER.ID_JENIS_USER');
        $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER", "left");
        $this->db->order_by('CRMNEW_USER.ID_USER', 'DESC');
        $this->db->where('CRMNEW_USER.DELETED_MARK', 0);
        $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", 0);
        $user = $this->db->get();
        if($user->num_rows() > 0){
            return $user->result();
        } else {
            return false;
        }
    }

    public function userDist($idUser = null){
        if(isset($idUser)){
            $this->db->where("CRMNEW_USER.ID_USER", $idUser);
        }
        $this->db->select("CRMNEW_USER_DISTRIBUTOR.ID_USER_DISTRIBUTOR, CRMNEW_USER.ID_USER, CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR, CRMNEW_DISTRIBUTOR.NAMA_DISTRIBUTOR");
        $this->db->from("CRMNEW_USER");
        $this->db->join("CRMNEW_USER_DISTRIBUTOR", "CRMNEW_USER.ID_USER = CRMNEW_USER_DISTRIBUTOR.ID_USER");
        $this->db->join("CRMNEW_DISTRIBUTOR", "CRMNEW_USER_DISTRIBUTOR.KODE_DISTRIBUTOR = CRMNEW_DISTRIBUTOR.KODE_DISTRIBUTOR");
        $this->db->where("CRMNEW_USER_DISTRIBUTOR.DELETE_MARK", 0);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function userProvinsi($idUser = null){
        if(isset($idUser)){
            $this->db->where("CRMNEW_USER_PROVINSI.ID_USER", $idUser);
        }

        $this->db->select("CRMNEW_USER_PROVINSI.ID_USER_PROVINSI, CRMNEW_USER_PROVINSI.ID_PROVINSI, CRMNEW_M_PROVINSI.NAMA_PROVINSI");
        $this->db->from("CRMNEW_USER_PROVINSI");
        $this->db->join("CRMNEW_M_PROVINSI", "CRMNEW_USER_PROVINSI.ID_PROVINSI = CRMNEW_M_PROVINSI.ID_PROVINSI");
        $this->db->where("CRMNEW_USER_PROVINSI.DELETE_MARK", 0);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function userArea($idUser = null){
        if(isset($idUser)){
            $this->db->where("CRMNEW_USER_AREA.ID_USER", $idUser);
        }

        $this->db->select("CRMNEW_USER_AREA.ID_USER_AREA, CRMNEW_USER_AREA.ID_AREA, CRMNEW_M_AREA.NAMA_AREA");
        $this->db->from("CRMNEW_USER_AREA");
        $this->db->join("CRMNEW_M_AREA", "CRMNEW_USER_AREA.ID_AREA = CRMNEW_M_AREA.ID_AREA");
        $this->db->where("CRMNEW_USER_AREA.DELETE_MARK", 0);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function userRetail($idUser = null){
        if(isset($idUser)){
            $this->db->where("CRMNEW_USER_TOKO.ID_USER", $idUser);
        }

        $this->db->select("CRMNEW_USER_TOKO.ID_USER, CRMNEW_CUSTOMER.ID_CUSTOMER, CRMNEW_CUSTOMER.NAMA_TOKO");
        $this->db->from("CRMNEW_USER_TOKO");
        $this->db->join("CRMNEW_CUSTOMER", "CRMNEW_USER_TOKO.ID_CUSTOMER = CRMNEW_CUSTOMER.ID_CUSTOMER");
        $this->db->where("CRMNEW_USER_TOKO.DELETE_MARK", "0");
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function addNewUser($data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('CREATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->insert('CRMNEW_USER', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function addUserDist($data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('CREATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->insert('CRMNEW_USER_DISTRIBUTOR', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function updateUserDist($idUserDist, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("ID_USER_DISTRIBUTOR", $idUserDist)->update('CRMNEW_USER_DISTRIBUTOR', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function updateUserRetail($idUser, $data){
        $addUser = $this->db->where("ID_USER", $idUser)->update('CRMNEW_USER_TOKO', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function addUserProv($data){
        $addUser = $this->db->insert_batch('CRMNEW_USER_PROVINSI', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function addUserArea($data){
        $addUser = $this->db->insert_batch('CRMNEW_USER_AREA', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function addUserRetail($data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('CREATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->insert('CRMNEW_USER_TOKO', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function updateUser($idUser, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATED_AT',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);

        $this->db->where('CRMNEW_USER.ID_USER', $idUser);
        $this->db->update('CRMNEW_USER', $data);

        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function updateUserProv($idUserProv, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("ID_USER_PROVINSI", $idUserProv)->update('CRMNEW_USER_PROVINSI', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    public function updateUserArea($idUserArea, $data){
        $date = date('d-m-Y H:i:s');
        $this->db->set('UPDATE_DATE',"TO_DATE('$date','dd/mm/yyyy HH24:MI:SS')", false);
        $addUser = $this->db->where("ID_USER_AREA", $idUserArea)->update('CRMNEW_USER_AREA', $data);
        if($this->db->affected_rows()){
            return true;
        } else {
            return false;
        }
    }

    
}
?>