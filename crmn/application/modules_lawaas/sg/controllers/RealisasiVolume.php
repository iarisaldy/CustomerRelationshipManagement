<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

class RealisasiVolume extends CI_Controller {
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('is_login'))redirect('login');
        $this->load->model('RealisasiVolume_model');
    }
    
    function index(){
        $data = array('title'=>'Realisasi Volume');
        $this->template->display('RealisasiVolume_view',$data);
    }
    
    function get_data(){
        $ora = $this->RealisasiVolume_model->ora();
        $rel = $this->RealisasiVolume_model->rel();
        
        if(is_array($ora))
        foreach ($ora as $n => $val) {   
            $tanggal = $val['TANGGALX']."";
            $prov[trim($val['KD_PROV'])] = $val['NM_PROV'];
            if($val['MATERIAL'] == "121-301"){
                $dataTrans['BAG'][$val['KD_PROV']][$val['TANGGALX']] = $val;
                $dataTrans['BAG']["2016-0106"]['TOTAL'] += $val['TARGET'];
            }else{
                $dataTrans['CURAH'][$val['KD_PROV']][$val['TANGGALX']] = $val;
                $dataTrans['CURAH'][$val['TANGGALX']]['TOTAL'] += $val{'TARGET'};
            }            
        }
        
        echo '<pre>';
        print_r($ora);
        echo '</pre>';
        
//        if(is_array($rel))
//        foreach ($rel as $a => $vrel)
//        {   $prop[$vrel['PROPINSI']] = $vrel['NAMA_PROP'];
//            if($vrel['MATERIAL'] == "121-301"){
//                $dataRilis['BAG'][$vrel['PROPINSI']][$vrel['TANGGALX']] = $vrel;
//                $dataRilis['BAG'][$vrel['TANGGALX']]['TOTAL'] += $vrel{'QTY'};                
//            }else{
//                $dataRilis['CURAH'][$vrel['PROPINSI']][$vrel['TANGGALX']] = $vrel;
//                $dataRilis['CURAH'][$vrel['TANGGALX']]['TOTAL'] += $vrel{'QTY'};
//            }            
//        }
    }
}