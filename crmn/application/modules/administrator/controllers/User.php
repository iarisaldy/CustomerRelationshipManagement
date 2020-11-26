<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class User extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Model_jenis_user');
        $this->load->model('Model_user');
        $this->load->model('Model_region');
        $this->load->model('Model_distributor');
        $this->load->model('Model_provinsi');
        $this->load->model('Model_area');
        $this->load->model('Model_retail');
    }

    // Page home for user management
    public function index(){
        $data = array("title"=>"Dashboard CRM");
        $data['jenisUser'] = $this->Model_jenis_user->listJenisUser();
        $this->template->display('UserList_view', $data);
    }

    // page add new user
    public function add(){
        $data = array("title" => "Dashboard CRM");
        $data['jenisUser'] = $this->Model_jenis_user->listJenisUser();
        $data['region'] = $this->Model_region->listRegion();
        $data['distributor'] = $this->Model_distributor->listDistributor();
        $data['provinsi'] = $this->Model_provinsi->listProvinsi();
        $this->template->display("AddUser_view", $data);
    }

    // page update user
    public function update($idUser){
        $data = array("title" => "Dashboard CRM");
        $data['jenisUser'] = $this->Model_jenis_user->listJenisUser();
        $data['region'] = $this->Model_region->listRegion();
        $data['user'] = $this->Model_user->listUser('iduser', $idUser);
        $data['user']['dist'] = $this->Model_user->userDist($idUser);
        $data['user']['retail'] = array();
        $this->template->display("UpdateUser_view", $data);
    }

    public function provinsi($idRegion = null){
        $data = $this->Model_provinsi->listProvinsi($idRegion);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }

    public function area(){
        $idProvinsi = $this->input->post('idprovinsi');
        $data = $this->Model_area->listArea($idProvinsi);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }

    public function retail($idDistributor = null){
        $data = $this->Model_retail->listRetail($idDistributor);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }

    public function changePassword(){
        $idUser = $this->session->userdata("user_id");
        $password = $this->input->post("password");
        $confirmPassword = $this->input->post("confirm_password");

        if($password == $confirmPassword){
            if($password != "" && $confirmPassword != ""){
                $data = array("PASSWORD" => $password);
                $changePassword = $this->Model_user->changePassword($idUser, $data);
                if($changePassword){
                    echo json_encode(array("status" => "success", "data" => $changePassword));
                } else {
                    echo json_encode(array("status" => "error", "message" => "Gagal mengubah password"));
                }
            } else {
                echo json_encode(array("status" => "error", "message" => "Form harus di isi"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Password tidak sama"));
        }
    }

    public function userProvinsi($idUser = null){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $data = array();
        $userProv = $this->Model_user->userProvinsi($idUser);

        if($userProv){
            $i = 1;
            foreach ($userProv as $userProvKey => $userProvValue) {
                $data[]  = array(
                    $i,
                    $userProvValue->ID_PROVINSI,
                    $userProvValue->NAMA_PROVINSI,
                    "<center>
                    <button id='updateUserProvinsi' data-idprov='".$userProvValue->ID_PROVINSI."' data-iduserprov='".$userProvValue->ID_USER_PROVINSI."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i></button>
                    &nbsp;
                    <button id='deleteUserProvinsi' data-iduserprov='".$userProvValue->ID_USER_PROVINSI."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                    </center>"
                );
            $i++;
            }
        } else {
            $data[] = array("-","-","-","-");
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($userProv),
            "recordsFiltered" => count($userProv),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function userArea($idUser = null){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $data = array();
        $userArea = $this->Model_user->userArea($idUser);

        if($userArea){
            $i=1;
            foreach ($userArea as $userAreaKey => $userAreaValue) {
                $data[]  = array(
                    $i,
                    $userAreaValue->ID_AREA,
                    $userAreaValue->NAMA_AREA,
                    "<center>
                    <button id='updateUserArea' data-idarea='".$userAreaValue->ID_AREA."' data-iduserarea='".$userAreaValue->ID_USER_AREA."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i></button>
                    &nbsp;
                    <button id='deleteUserArea' data-iduserarea='".$userAreaValue->ID_USER_AREA."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                    </center>"
                );
                $i++;
            }
        } else {
            $data[] = array("-","-","-","-");
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($userArea),
            "recordsFiltered" => count($userArea),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function userDistributor($idUser = null){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $data = array();
        $userDist = $this->Model_user->userDist($idUser);

        if($userDist){
            $i=1;
            foreach ($userDist as $userDistKey => $userDistValue) {
                $data[]  = array(
                    $i,
                    $userDistValue->KODE_DISTRIBUTOR,
                    $userDistValue->NAMA_DISTRIBUTOR,
                    "<center>
                    <button id='updateUserDistributor' data-iddist='".$userDistValue->KODE_DISTRIBUTOR."' data-iduserdist='".$userDistValue->ID_USER_DISTRIBUTOR."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i></button>
                    &nbsp;
                    <button id='deleteUserDistributor' data-iduserdist='".$userDistValue->ID_USER_DISTRIBUTOR."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                    </center>"
                );
                $i++;
            }
        } else {
            $data[] = array("-","-","-","-");
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($userDist),
            "recordsFiltered" => count($userDist),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function userRetail($idUser = null){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $data = array();
        $userRetail = $this->Model_user->userRetail($idUser);

        if($userRetail){
            $i=1;
            foreach ($userRetail as $userRetailKey => $userRetailValue) {
                $data[]  = array(
                    $i,
                    $userRetailValue->ID_CUSTOMER,
                    $userRetailValue->NAMA_TOKO,
                    ""
                );
                $i++;
            }
        } else {
            $data[] = array("-","-","-","-");
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($userRetail),
            "recordsFiltered" => count($userRetail),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    // list data user
    public function dataUser($idRole = null){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $data = array();

        $user = $this->Model_user->listUser('idrole', $idRole);

        if($user){
            foreach ($user as $userKey => $userValue) {
                $data[] = array(
                    $userValue->ID_USER,
                    $userValue->NAMA,
                    $userValue->JENIS_USER,
                    "<center><a href='".base_url('administrator/User/update')."/".$userValue->ID_USER."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i> Update</a>
                    &nbsp;
                    <button onclick='deleteUser(".$userValue->ID_USER.")' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button></center>"
                );
            }
        } else {
            $data[] = array("-","-","-","-");
        }
        
        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($user),
            "recordsFiltered" => count($user),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function addAction(){
        $region = $this->input->post('region');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $role = $this->input->post('role');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $dataUser = array(
            "NAMA" => $name,
            "EMAIL" => $email,
            "USERNAME" => $username, 
            "PASSWORD" => $password, 
            "ID_JENIS_USER" => $role, 
            "ID_REGION" => $region,
            "CREATED_BY" => $this->session->userdata('user_id'), 
            "DELETED_MARK" => 0
        );

        if($role == "1002" || $role == "1003" || $role == "1004" || $role == "1005" || $role == "1007"){
            $distributor = $this->input->post('distributor');
        }

        if($role == "1003" || $role == "1005" || $role == "1006" || $role == "1007"){
            $provinsi = $this->input->post('provinsi');
            $area = $this->input->post('area');
        }

        $addUser = $this->Model_user->addNewUser($dataUser);
        if($addUser){

            $maxUserId = $this->Model_user->lastUserId();
            if($role == "1002" || $role == "1003" || $role == "1004" || $role == "1005" || $role == "1007"){
                $dataDistributor = array(
                    "ID_USER" => $maxUserId->ID_USER,
                    "KODE_DISTRIBUTOR" => $distributor,
                    "DELETE_MARK" => 0,
                    "CREATE_BY" => $this->session->userdata('user_id')
                );
                $addUserDist = $this->Model_user->addUserDist($dataDistributor);
            }

            if($role == "1003" || $role == "1005" || $role == "1006" || $role == "1007"){
                if(isset($provinsi)){
                    foreach($provinsi as $provinsiKey => $provinsiValue){
                        $prov["ID_USER"] = $maxUserId->ID_USER;
                        $prov["ID_PROVINSI"] = $provinsiValue;
                        $prov["DELETE_MARK"] = 0;
                        $prov["CREATE_BY"] = $this->session->userdata('user_id');
                        $dataProvinsi[] = $prov;

                        $addUserProv = $this->Model_user->addUserProv($dataProvinsi);
                    }
                }  
                if(isset($area)){
                	foreach ($area as $areaKey => $areaValue) {
                		$insertArea["ID_USER"] = $maxUserId->ID_USER;
                		$insertArea["ID_AREA"] = $areaValue;
                		$insertArea["DELETE_MARK"] = 0;
                		$insertArea["CREATE_BY"] = $this->session->userdata('user_id');
                		$dataArea[] = $insertArea;
                	}
                }

                if($this->session->userdata("id_jenis_user") == "1007"){
                	$dataArea[] = array(
                		"ID_USER" => $maxUserId->ID_USER,
                		"ID_AREA" => "37",
                		"DELETE_MARK" => "0",
                		"CREATE_BY" => $this->session->userdata('user_id')
                	);
                }

                $addUserArea = $this->Model_user->addUserArea($dataArea);
                
            }

            if($role == "1004"){
                $retail = $this->input->post("retail");
                $dataUserRetail = array(
                    "ID_USER" => $maxUserId->ID_USER,
                    "ID_CUSTOMER" => $retail,
                    "DELETE_MARK" => 0,
                    "CREATE_BY" => $this->session->userdata("user_id")
                );
                $addUserRetail = $this->Model_user->addUserRetail($dataUserRetail);
                
            }

            $this->session->set_flashdata('message', "Add new user success");
            redirect('administrator/User');
        } else {
            redirect('administrator/User/add');
        }
    }

    public function updateAction($idUser){
        $region = $this->input->post('region');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $role = $this->input->post('role');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $dataUser = array(
            "ID_REGION" => $region,
            "NAMA" => $name,
            "EMAIL" => $email,
            "USERNAME" => $username, 
            "PASSWORD" => $password, 
            "ID_JENIS_USER" => $role, 
            "UPDATED_BY" => $this->session->userdata('user_id'), 
            "DELETED_MARK" => 0
        );

        $updateUser = $this->Model_user->updateUser($idUser,$dataUser);
        if($updateUser){
            $this->session->set_flashdata('message', "Update user success");
            redirect('administrator/User');
        } else {
            redirect('administrator/User/update/'.$idUser);
        }
    }

    public function deleteAction(){
        $idUser = $this->input->post('idUserDelete');

        $data = array(
            "DELETED_MARK" => 1,
            "UPDATED_BY" => $this->session->userdata('user_id')
        );
        $deleteUser = $this->Model_user->updateUser($idUser, $data);
        if($deleteUser){
            $this->session->set_flashdata('message', "Delete user data success");
        } else {
            // $this->session->set_flashdata('message', 1);
        }
        redirect('administrator/Manajemen_user');
    }

    public function listDistributor(){
        $distributor = $this->Model_distributor->listDistributor();
        if($distributor){
            echo json_encode(array("status" => "success", "data" => $distributor));
        } else {
            echo json_encode(array("status" => "error", "message" => "data tidak ada"));
        }
    }

    public function addUserDistributor(){
        $dataDistributor = array(
            "ID_USER" => $this->input->post("id_user"),
            "KODE_DISTRIBUTOR" => $this->input->post("kode_dist"),
            "DELETE_MARK" => 0,
            "CREATE_BY" => $this->session->userdata('user_id')
        );
        $addUserDist = $this->Model_user->addUserDist($dataDistributor);

        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user distributor"));
    }

    public function updateUserDistributor(){
        $idUserDistributor = $this->input->post("id_user_distributor");
        $kodeDist = $this->input->post("kode_dist");
        
        $dataDistributor = array(
            "KODE_DISTRIBUTOR" => $kodeDist,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserDist = $this->Model_user->updateUserDist($idUserDistributor, $dataDistributor);
        if($deleteUserDist){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user distributor"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user distributor"));
        }
    }

    public function deleteUserDistributor(){
        $idUserDistributor = $this->input->post("id_user_distributor");
        $deleteMark = $this->input->post("delete_mark");
        $dataDistributor = array(
            "DELETE_MARK" => $deleteMark,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserDist = $this->Model_user->updateUserDist($idUserDistributor, $dataDistributor);
        if($deleteUserDist){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user distributor"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user distributor"));
        }
    }

    public function addUserProvinsi(){
        $dataProvinsi = array(
            "ID_USER" => $this->input->post("id_user"),
            "ID_PROVINSI" => $this->input->post("id_provinsi"),
            "DELETE_MARK" => 0,
            "CREATE_BY" => $this->session->userdata('user_id')
        );
        $arrayProvinsi[] = $dataProvinsi;
        $addUserProvinsi = $this->Model_user->addUserProv($arrayProvinsi);
        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user provinsi"));
    }

    public function updateUserProvinsi(){
        $idUserProvinsi = $this->input->post("id_user_provinsi");
        $idProvinsi = $this->input->post("id_provinsi");
        
        $dataProvinsi = array(
            "ID_PROVINSI" => $idProvinsi,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserProv = $this->Model_user->updateUserProv($idUserProvinsi, $dataProvinsi);
        if($deleteUserProv){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user provinsi"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user provinsi"));
        }
    }

    public function deleteUserProvinsi(){
        $idUserProvinsi = $this->input->post("id_user_provinsi");
        $deleteMark = $this->input->post("delete_mark");
        $dataProvinsi = array(
            "DELETE_MARK" => $deleteMark,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserProv = $this->Model_user->updateUserProv($idUserProvinsi, $dataProvinsi);
        if($deleteUserProv){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user provinsi"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user provinsi"));
        }
    }

    // CRUD USER RETAIL
    public function updateUserRetail(){
        $idCustomer = $this->input->post("id_customer");
        $idUser = $this->input->post("id_user");
        $dataRetail = array(
            "ID_CUSTOMER" => $idCustomer
        );
        $updateUserRetail = $this->Model_user->updateUserRetail($idUser, $dataRetail);
        if($updateUserRetail){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user retail"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user retail"));
        }
    }
    // END CRUD USER RETAIL


    // CRUD USER AREA
    public function addUserArea(){
        $dataArea = array(
            "ID_USER" => $this->input->post("id_user"),
            "ID_AREA" => $this->input->post("id_area"),
            "DELETE_MARK" => 0,
            "CREATE_BY" => $this->session->userdata('user_id')
        );
        $arrayArea[] = $dataArea;
        $addUserArea = $this->Model_user->addUserArea($arrayArea);
        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user area"));
    }

    public function updateUserArea(){
        $idUserArea = $this->input->post("id_user_area");
        $idArea = $this->input->post("id_area");
        
        $dataArea = array(
            "ID_AREA" => $idArea,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $updateUserArea = $this->Model_user->updateUserArea($idUserArea, $dataArea);
        if($updateUserArea){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user area"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user area"));
        }
    }

    public function deleteUserArea(){
        $idUserArea = $this->input->post("id_user_area");
        $deleteMark = $this->input->post("delete_mark");
        $dataArea = array(
            "DELETE_MARK" => $deleteMark,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserArea = $this->Model_user->updateUserArea($idUserArea, $dataArea);
        if($deleteUserArea){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user area"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user area"));
        }
    }
    // END CRUD USER AREA
}

?>