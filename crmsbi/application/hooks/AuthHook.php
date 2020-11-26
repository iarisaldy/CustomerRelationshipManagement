<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthHook{
  private $CI;
  private $module;
  public function __construct(){
    $this->CI = &get_instance();
    
     $this->module = $this->CI->router->fetch_module();
  }
  public function checkPermission($moduleArr){
      $opco = $this->CI->session->userdata('opco');
   
      //   2000 : 'Semua', 7000 : 'Semen Gresik', 6000 : 'TLCC', 3000 : 'Semen Padang', 4000 : 'Semen Tonasa'};    
      $opco_list = array(
          7000 => 'sg',
          5000 => 'sg',
          6000 => 'tlcc',
          3000 => 'sp',
          4000 => 'st'
      );
      if($opco != '2000'){
          if(in_array($this->module,$moduleArr)){
            if($this->module != $opco_list[$opco]){
                redirect('login/login/');
            }
          } 
      }
  }
}

