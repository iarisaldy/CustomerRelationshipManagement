<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Mapping_user_tso extends CI_Controller {

    function __construct(){
        parent::__construct();
		
		$this->load->model('Mapping_user_tso_model');
    }
	
    public function index(){
		$data = array("title" => "Dashboard CRM");
		$idUser						= $this->session->userdata('user_id');
        $idJenisUser                = $this->session->userdata("id_jenis_user");
		$data['dt_user'] 	        = $this->Mapping_user_tso_model->Get_data_user(null, $idUser);
		$data['JENIS_USER']         = $this->make_jenis_user($this->Mapping_user_tso_model->Jenis_user(), $idJenisUser);
		$data['user_distributor']   = $this->Mapping_user_tso_model->User_distributor($idUser);
		$data['region']             = $this->Mapping_user_tso_model->listRegion($idUser);

        $this->template->display("Mapping_tso_view", $data);
    }
	
	public function ROLEASM(){
		$data = array("title" => "Dashboard CRM");
		$idUser						= $this->session->userdata('user_id');
        $idJenisUser                = $this->session->userdata("id_jenis_user");
		$data['dt_user'] 	        = $this->Mapping_user_tso_model->Get_data_user(null, $idUser);
		$data['JENIS_USER']         = $this->make_jenis_user($this->Mapping_user_tso_model->Jenis_user(), $idJenisUser);
		$data['user_distributor']   = $this->Mapping_user_tso_model->User_distributor($idUser);
		$data['region']             = $this->Mapping_user_tso_model->listRegion($idUser);

        $this->template->display("Mapping_asm_view", $data);
    }
	
	public function ROLERSM(){
		$data = array("title" => "Dashboard CRM");
		$idUser						= $this->session->userdata('user_id');
        $idJenisUser                = $this->session->userdata("id_jenis_user");
		$data['dt_user'] 	        = $this->Mapping_user_tso_model->Get_data_user(null, $idUser);
		$data['JENIS_USER']         = $this->make_jenis_user($this->Mapping_user_tso_model->Jenis_user(), $idJenisUser);
		$data['user_distributor']   = $this->Mapping_user_tso_model->User_distributor($idUser);
		$data['region']             = $this->Mapping_user_tso_model->listRegion($idUser);

        $this->template->display("Mapping_rsm_view", $data);
    }
	
	public function ROLEGSM(){
		$data = array("title" => "Dashboard CRM");
		$idUser						= $this->session->userdata('user_id');
        $idJenisUser                = $this->session->userdata("id_jenis_user");
		$data['dt_user'] 	        = $this->Mapping_user_tso_model->Get_data_user(null, $idUser);
		$data['JENIS_USER']         = $this->make_jenis_user($this->Mapping_user_tso_model->Jenis_user(), $idJenisUser);
		$data['user_distributor']   = $this->Mapping_user_tso_model->User_distributor($idUser);
		$data['region']             = $this->Mapping_user_tso_model->listRegion($idUser);

        $this->template->display("Mapping_gsm_view", $data);
    }
	
	private function make_jenis_user($hasil, $jenis_user=null){
		$isi ='';
		foreach ($hasil as $p) {
            if($jenis_user==$p['ID_JENIS_USER']){
                $isi .= '<option value="'.$p['ID_JENIS_USER'].'" selected >'.$p['JENIS_USER'].'</option>';    
            }
            else {
                $isi .= '<option value="'.$p['ID_JENIS_USER'].'" >'.$p['JENIS_USER'].'</option>';
            }
		}
		return $isi;
	}
	
	private function make_table_user($hasil){
		$isi ='';
		foreach ($hasil as $d) {				
			$edit = "<center><a href='".base_url('administrator/Manajemen_user/update')."/".$d['ID_USER']."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i> Mapping</a> &nbsp;";
			$delete = "<button onclick='deleteUser(".$d['ID_USER'].")' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button></center>";
			$isi .= '<tr>';
			$isi .= '<td>'.$d['ID_USER'].'</td>';
			$isi .= '<td>'.$d['NAMA'].'</td>';
			$isi .= '<td>'.$d['JENIS_USER'].' </td>';
			$isi .= '<td>'.$edit. $delete .'</td>';
			$isi .= '</tr>';
		}
		return $isi;
	}
	private function make_user_distributor($data){
		$isi ='';
		foreach ($hasil as $d) {
			$edit = "<center><a href='".base_url('administrator/Manajemen_user/update')."/".$d['ID_USER']."' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i> Update</a> &nbsp;";
			$delete = "<button onclick='deleteUser(".$d['ID_USER'].")' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</button></center>";
			$isi .= '<tr>';
			$isi .= '<td>'.$d['ID_USER'].'</td>';
			$isi .= '<td>'.$d['NAMA'].'</td>';
			$isi .= '<td>'.$d['JENIS_USER'].' </td>';
			$isi .= '<td>'.$edit. $delete .'</td>';
			$isi .= '</tr>';
		}
		return $isi;
	}
	

    // page add new user
    public function add(){
        $data = array("title" => "Dashboard CRM");
		$data['JENIS_USER'] = $this->make_jenis_user($this->Mapping_user_tso_model->Jenis_user());
        $data['region'] = $this->Mapping_user_tso_model->listRegion();
		
        $data['distributor'] = $this->Mapping_user_tso_model->listDistributor();
        $data['provinsi'] = $this->Mapping_user_tso_model->listProvinsi();
        $this->template->display("tambah_user_sbi", $data);
    }

    // page update user
    public function update(){
        
        $data = array("title" => "Dashboard CRM");
		$idUser						= $this->session->userdata('user_id');
        $idJenisUser                = $this->session->userdata("id_jenis_user");
		$data['dt_user'] 	        = $this->Mapping_user_tso_model->Get_data_user(null, $idUser);
		$data['JENIS_USER']         = $this->make_jenis_user($this->Mapping_user_tso_model->Jenis_user(), $idJenisUser);
		$data['user_distributor']   = $this->Mapping_user_tso_model->User_distributor($idUser);
		$data['region']             = $this->Mapping_user_tso_model->listRegion($idUser);
		
        // print_r($data['region']);
        // exit;

        $this->template->display("Mapping_tso_view", $data);
    }
	public function Ajax_id_region(){
	$id_user = $this->session->userdata('user_id');
	
	$data = $this->Mapping_user_tso_model->Region_tso($id_user);
	echo json_encode(array("status" => "success", "data" => $data));
	}
	
	public function Ajax_id_region_asm(){
	$id_user = $this->session->userdata('user_id');
	
	$data = $this->Mapping_user_tso_model->Region_asm($id_user);
	echo json_encode(array("status" => "success", "data" => $data));
	}
	
	public function Ajax_id_region_rsm(){
	$id_user = $this->session->userdata('user_id');
	
	$data = $this->Mapping_user_tso_model->Region_rsm($id_user);
	echo json_encode(array("status" => "success", "data" => $data));
	}
	
	public function Ajax_id_region_gsm(){
	
	$data = $this->Mapping_user_tso_model->Region_gsm();
	echo json_encode(array("status" => "success", "data" => $data));
	}
	
    public function provinsi($idRegion = null){
		$id_user = $this->session->userdata('user_id');
		
        $data = $this->Mapping_user_tso_model->listProvinsi($idRegion, $id_user);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }

    public function area(){
        $idProvinsi = $this->input->post('idprovinsi');
        $id_user    = $this->input->post('id_user');
        $data = $this->Mapping_user_tso_model->listArea($idProvinsi, $id_user);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }

    public function SALES(){
        $id_user    = $this->input->post('id_user');
		$datadistributor = $this->Mapping_user_tso_model->User_distributor_TSO($id_user);
		$id_dis = '';
		$n=1;
		foreach($datadistributor as $d){
			if(count($datadistributor)>$n){
				$id_dis .= "'". $d['KODE_DISTRIBUTOR']."',";
			}
			else {
				$id_dis .= "'". $d['KODE_DISTRIBUTOR']."'";
			}
			$n=$n+1;
		}
		
        $data = $this->Mapping_user_tso_model->listSALES($id_user,$id_dis);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
	
	public function TSO(){
        $id_user    = $this->input->post('id_user');
        $data = $this->Mapping_user_tso_model->listTSO($id_user);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
    public function ASM(){
        $id_user    = $this->input->post('id_user');
        $data = $this->Mapping_user_tso_model->listASM($id_user);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
    public function RSM(){
        $id_user    = $this->input->post('id_user');
        $data = $this->Mapping_user_tso_model->listRSM($id_user);
        if($data){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "data" => array()));
        }
    }
    public function GUDANG(){
        $id_user    = $this->input->post('id_user');
        $data = $this->Mapping_user_tso_model->listGUDANG($id_user);
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
        $userProv = $this->Mapping_user_tso_model->User_Provinsi($idUser);

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

    public function userSALES($idUser = null){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $data = array();
        $userSALES = $this->Mapping_user_tso_model->User_SALES($idUser);

        if($userSALES){
            $i=1;
            foreach ($userSALES as $userAreaKey => $userAreaValue) {
                $data[]  = array(
                    $i,
                    $userAreaValue->ID_USER,
                    $userAreaValue->USERNAME,
                    "<center>
                    <button id='deleteUserTSO' data-idusertso='".$userAreaValue->NO_USER_TSO."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                    </center>"
                );
                $i++;
            }
        } else {
            $data[] = array("-","-","-","-");
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($userSALES),
            "recordsFiltered" => count($userSALES),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
	
	public function userTSO($idUser = null){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $data = array();
        $userTSO = $this->Mapping_user_tso_model->User_TSO($idUser);

        if($userTSO){
            $i=1;
            foreach ($userTSO as $userAreaKey => $userAreaValue) {
                $data[]  = array(
                    $i,
                    $userAreaValue->ID_USER,
                    $userAreaValue->NAMA,
                    "<center>
                    <button id='deleteUserTSO' data-idusertso='".$userAreaValue->NO_USER_ASM."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                    </center>"
                );
                $i++;
            }
        } else {
            $data[] = array("-","-","-","-");
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($userTSO),
            "recordsFiltered" => count($userTSO),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
	
    public function userASM($idUser = null){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $data = array();
        $userTSO = $this->Mapping_user_tso_model->User_ASM($idUser);

        if($userTSO){
            $i=1;
            foreach ($userTSO as $userAreaKey => $userAreaValue) {
                $data[]  = array(
                    $i,
                    $userAreaValue->ID_USER,
                    $userAreaValue->NAMA,
                    "<center>
                    <button id='deleteUserASM' data-idusertso='".$userAreaValue->NO_USER_RSM."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                    </center>"
                );
                $i++;
            }
        } else {
            $data[] = array("-","-","-","-");
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($userTSO),
            "recordsFiltered" => count($userTSO),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
	
    public function userRSM($idUser = null){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $data = array();
        $userTSO = $this->Mapping_user_tso_model->User_RSM($idUser);

        if($userTSO){
            $i=1;
            foreach ($userTSO as $userAreaKey => $userAreaValue) {
                $data[]  = array(
                    $i,
                    $userAreaValue->ID_USER,
                    $userAreaValue->NAMA,
                    "<center>
                    <button id='deleteUserRSM' data-idusertso='".$userAreaValue->NO_MAPPING."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                    </center>"
                );
                $i++;
            }
        } else {
            $data[] = array("-","-","-","-");
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($userTSO),
            "recordsFiltered" => count($userTSO),
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
	
    public function userGUDANG($idUser = null){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $data = array();
        $userTSO = $this->Mapping_user_tso_model->User_TSO($idUser);

        if($userTSO){
            $i=1;
            foreach ($userTSO as $userAreaKey => $userAreaValue) {
                $data[]  = array(
                    $i,
                    $userAreaValue->ID_TSO,
                    $userAreaValue->NAMA,
                    "<center>
                    <button id='deleteUserGUDANG' data-idusertso='".$userAreaValue->ID_USER."' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                    </center>"
                );
                $i++;
            }
        } else {
            $data[] = array("-","-","-","-");
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($userTSO),
            "recordsFiltered" => count($userTSO),
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
        $userArea = $this->Mapping_user_tso_model->User_Area($idUser);

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
        $userDist = $this->Mapping_user_tso_model->User_distributor($idUser);

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
            "DELETED_MARK" => 0,
			"FLAG" => 'SBI'
        );

        $addUser = $this->Mapping_user_tso_model->addNewUser($dataUser);
        if($addUser){

            $this->session->set_flashdata('message', "Add new user success");
            redirect('administrator/Manajemen_user');
        } else {
            redirect('administrator/Manajemen_user/add');
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

        $updateUser = $this->Mapping_user_tso_model->updateUser($idUser,$dataUser);
        if($updateUser){
            $this->session->set_flashdata('message', "Update user success");
            redirect('administrator/Manajemen_user');
        } else {
            redirect('administrator/Manajemen_user/update/'.$idUser);
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
        redirect('administrator/User');
    }

    public function listDistributor($id_user=null){

        $distributor = $this->Mapping_user_tso_model->listDistributor($id_user);
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
        $addUserDist = $this->Mapping_user_tso_model->addUserDist($dataDistributor);

        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user distributor"));
    }

    public function updateUserDistributor(){
        $idUserDistributor = $this->input->post("id_user_distributor");
        $kodeDist = $this->input->post("kode_dist");
        
        $dataDistributor = array(
            "KODE_DISTRIBUTOR" => $kodeDist,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserDist = $this->Mapping_user_tso_model->updateUserDist($idUserDistributor, $dataDistributor);
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
        $deleteUserDist = $this->Mapping_user_tso_model->updateUserDist($idUserDistributor, $dataDistributor);
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
        $addUserProvinsi = $this->Mapping_user_tso_model->addUserProv($arrayProvinsi);
        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user provinsi"));
    }

    public function updateUserProvinsi(){
        $idUserProvinsi = $this->input->post("id_user_provinsi");
        $idProvinsi = $this->input->post("id_provinsi");
        
        $dataProvinsi = array(
            "ID_PROVINSI" => $idProvinsi,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserProv = $this->Mapping_user_tso_model->updateUserProv($idUserProvinsi, $dataProvinsi);
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
        $deleteUserProv = $this->Mapping_user_tso_model->updateUserProv($idUserProvinsi, $dataProvinsi);
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
        $addUserArea = $this->Mapping_user_tso_model->addUserArea($arrayArea);
        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user area"));
    }

    public function updateUserArea(){
        $idUserArea = $this->input->post("id_user_area");
        $idArea = $this->input->post("id_area");
        
        $dataArea = array(
            "ID_AREA" => $idArea,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $updateUserArea = $this->Mapping_user_tso_model->updateUserArea($idUserArea, $dataArea);
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
        $deleteUserArea = $this->Mapping_user_tso_model->updateUserArea($idUserArea, $dataArea);
        if($deleteUserArea){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user area"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user area"));
        }
    }
    // END CRUD USER AREA

    //CRUD USER TSO
    public function addUserTSO(){
        $dataArea = array(
            "ID_TSO"       => $this->input->post("id_user"),
            "ID_USER"        => $this->input->post("id_TSO"),
            "DELETE_MARK"   => 0,
            "CREATE_BY"     => $this->session->userdata('user_id')
        );
        $arrayArea[] = $dataArea;
        $addUserArea = $this->Mapping_user_tso_model->addUserTSO($arrayArea);
        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user area"));
    }
	
    public function deleteUserTSO(){
        $iduserTSO  = $this->input->post("no_user_tso");
        $deleteMark = $this->input->post("delete_mark");

        $dataArea = array(
            "DELETE_MARK" => 1,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserArea = $this->Mapping_user_tso_model->updateUserTSO($iduserTSO, $dataArea);
        if($deleteUserArea){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user area"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user area"));
        }
    }
	
	public function addUserTSO_ASM(){
        $dataArea = array(
            "ID_ASM"       => $this->input->post("id_user"),
            "ID_USER"        => $this->input->post("id_TSO"),
            "DELETE_MARK"   => 0,
            "CREATE_BY"     => $this->session->userdata('user_id')
        );
        $arrayArea[] = $dataArea;
        $addUserArea = $this->Mapping_user_tso_model->addUserTSO_ASM($arrayArea);
        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user area"));
    }
	
    public function deleteUserTSO_ASM(){
        $iduserTSO  = $this->input->post("no_user_tso");
        $deleteMark = $this->input->post("delete_mark");

        $dataArea = array(
            "DELETE_MARK" => 1,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserArea = $this->Mapping_user_tso_model->updateUserTSO_ASM($iduserTSO, $dataArea);
        if($deleteUserArea){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user area"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user area"));
        }
    }
	
    public function addUserASM(){
        $dataArea = array(
            "ID_RSM"       => $this->input->post("id_user"),
            "ID_USER"       => $this->input->post("id_TSO"),
            "DELETE_MARK"   => 0,
            "CREATE_BY"     => $this->session->userdata('user_id')
        );
        $arrayArea[] = $dataArea;
        $addUserArea = $this->Mapping_user_tso_model->addUserASM($arrayArea);
        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user area"));
    }
    public function deleteUserASM(){
        $iduserTSO  = $this->input->post("no_user_tso");
        $deleteMark = $this->input->post("delete_mark");

        $dataArea = array(
            "DELETE_MARK" => 1,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserArea = $this->Mapping_user_tso_model->updateUserASM($iduserTSO, $dataArea);
        if($deleteUserArea){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user ASM"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user ASM"));
        }
    }
    public function addUserRSM(){
        $dataArea = array(
            "ID_GSM"       => $this->input->post("id_user"),
            "ID_USER"        => $this->input->post("id_TSO"),
            "DELETE_MARK"   => 0,
            "CREATE_BY"     => $this->session->userdata('user_id')
        );
        $arrayArea[] = $dataArea;
        $addUserArea = $this->Mapping_user_tso_model->addUserRSM($arrayArea);
        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user area"));
    }
    public function deleteUserRSM(){
        $iduserTSO  = $this->input->post("no_user_tso");
        $deleteMark = $this->input->post("delete_mark");

        $dataArea = array(
            "DELETE_MARK" => 1,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserArea = $this->Mapping_user_tso_model->updateUserRSM($iduserTSO, $dataArea);
        if($deleteUserArea){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user RSM"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user RSM"));
        }
    }
	
    public function addUserGUDANG(){
        $dataArea = array(
            "ID_USER"       => $this->input->post("id_user"),
            "ID_TSO" 		=> $this->input->post("id_TSO"),
            "DELETE_MARK"   => 0,
            "CREATE_BY"     => $this->session->userdata('user_id')
        );
        $arrayArea[] = $dataArea;
        $addUserArea = $this->Mapping_user_tso_model->addUserGUDANG($arrayArea);
        echo json_encode(array("status" => "success", "message" => "berhasil menambahkan user area"));
    }
	
    public function deleteUserGUDANG(){
        $iduserTSO  = $this->input->post("no_user_tso");

        $dataArea = array(
            "DELETE_MARK" => 1,
            "UPDATE_BY" => $this->session->userdata('user_id')
        );
        $deleteUserArea = $this->Mapping_user_tso_model->updateUserGUDANG($iduserTSO, $dataArea);
        if($deleteUserArea){
            echo json_encode(array("status" => "success", "message" => "berhasil mengubah user RSM"));
        } else {
            echo json_encode(array("status" => "error", "message" => "gagal mengubah user RSM"));
        }
    }
}


?>