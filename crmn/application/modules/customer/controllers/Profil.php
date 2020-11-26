<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Profil extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Profil_model');
    } 

    public function detail($id_customer){
		$data = array("title"=>"Dashboard CRM Administrator");
		$data["id"] = $id_customer;
		$data['dt_customer'] = $this->Profil_model->getDataCustomer($id_customer);
		$data['dt_kunjung'] = $this->Profil_model->getDataKunjungUpdate($id_customer);
		$data['dt_mapping'] = $this->Profil_model->getMappingCustomer($id_customer);
		
		//print_r($data['dt_mapping']);
		//exit; 
		
		// $id_user = $this->session->userdata('id_jenis_user');
		// print_r($id_user);
		// exit;
			 
		$this->session->set_userdata('set_id_customer', $id_customer);
		$this->template->display('Profil_view', $data);
    }
	
	public function HisKunjungan(){
		$id_customer = $this->input->post("customer");
		$hasil = $this->Profil_model->get_his_kunjungan($id_customer);
		echo json_encode($hasil);
	}
	
	public function set_lock(){
		$id_customer = $this->session->userdata("set_id_customer");
		
		$this->Profil_model->set_lock_unlock($id_customer, 'lock');
		redirect(site_url('customer/Profil/detail/'.$id_customer));
	}
	
	public function set_unlock(){
		$id_customer = $this->session->userdata("set_id_customer");
		
		$this->Profil_model->set_lock_unlock($id_customer, 'unlock');
		redirect(site_url('customer/Profil/detail/'.$id_customer));
	}
	
}

?>