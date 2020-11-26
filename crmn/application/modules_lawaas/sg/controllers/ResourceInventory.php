<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');

class ResourceInventory extends CI_Controller {
	private $db2;
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('is_login'))redirect('login');
        $this->load->model('ResourceInventory_model');
    }
    
    function index(){
        $data = array('title'=>'Stok Bahan & Batubara');
        $opco = 7000;
        $plant_group = $this->input->post('plant_group');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        
        $tahun = empty($tahun) ? date('Y') : $tahun;
        $bulan = empty($bulan) ? date('m') : $bulan;
        $plant_group = empty($plant_group) ? '7403' : $plant_group;
        $period = $tahun.'-'.$bulan;
        $data['head'] = $this->ResourceInventory_model->listMaterial($opco,$plant_group);
        $stok = $this->ResourceInventory_model->getStok($opco,$plant_group,$period);
        $data['stok'] = $this->groupingByColumn($stok,'KODE_KELOMPOK');
        $data['periode'] = $period;
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;       
        $data['plant_group'] = $plant_group;
    //    $data['data'] = $this->ResourceInventory_model->getData();
        $this->template->display('ResourceInventory_view', $data);
        // $this->load->view('ResourceInventory_view', $data);
    }
    public function getDetail()
    {   
        $data = $this->ResourceInventory_model->getDetail();
        $data['data'] = $this->ResourceInventory_model->getgrafik('DESC');
        $this->load->view('DetailResourceInventory', $data);
    }
    public function getChart()
    {
        $data = $this->ResourceInventory_model->getDetail();
        $data['data'] = $this->ResourceInventory_model->getgrafik();
        $this->load->view('ChartResourceInventory', $data);
    }
    
    private function groupingByColumn($arr,$column){
        $r = array();
        foreach($arr as $ar){
           $r[$ar[$column]] = $ar; 
        }
        return $r;
    }


    public function getData(){
        $label = array();
        $kode_kelompok = $this->input->get('kode_kelompok');
        $period = $this->input->get('period');
        $plant_group = $this->input->get('plant_group');
                
        $opco = 7000;
        $kode_gypsum = array(1300,1400,2700);
        $gypsum_detail = array();
        $detail = $this->ResourceInventory_model->getDetailStok($opco,$plant_group,$period,$kode_kelompok);
        $lastAverageWeek = $this->ResourceInventory_model->getLastAverageWeek($opco,$plant_group,$period,$kode_kelompok);
        $satuan = $this->db->where(array('KODE_KELOMPOK' => $kode_kelompok))->get('ZREPORT_SCM_MM_KELOMPOK')->row_array();
        /* jika gypsum maka cari juga pemakaian untuk gypsum lainnya supaya mendapatkan total pemakaian gypsum */
        if(in_array($kode_kelompok, $kode_gypsum)){           
           $gypsum_detail = $this->ResourceInventory_model->getDetailStok($opco,$plant_group,$period,$kode_gypsum); 
        }
        $rkap = $this->ResourceInventory_model->getRKAP($opco,$plant_group,$period,$kode_kelompok);
        $tmp = array('1' => array(), '2' => array(), '3' => array(),'4' => array());
        $data = array('1' => array(), '2' => array(), '3' => array(), '4' => array());
        $pakai = array(
            'terima' => array(),'pakai' => array(), 'total_terima' => array(), 'total_pakai' => array()
        );
        $stok = array(
            'min' => array(),'max' => array(),'rp' => array(),'dead_stock' => array(),'stok' => array()
        );
        $color = array(
            'terima' => array(),
            'pakai'  => array(),
            'total_terima' => array(),
            'stok' => array(),
            'total_pakai' => array()
        );
    
        $info = array('min' => 0, 'max' => 0, 'rp' => 0,'total_stok' => 0, 'total_terima' => 0, 'total_pakai' => 0, 'rkap' => 0, 'prognose_pakai'=>0, 'lastAverageWeek' => $lastAverageWeek['STOK'], 'total_pakai_gypsum' => 0, 'total_prognose_gypsum' => 0);
        $punya_deadstock = 0;
        $info['rkap'] = isset($rkap['TARGET_PAKAI']) ? $rkap['TARGET_PAKAI'] : 0;
        if(in_array($kode_kelompok, $kode_gypsum)){
            
            $_pakai = array('total_terima'=> array(),'total_pakai'=>array());
            foreach($gypsum_detail as $gd){
                $tgl = $gd['TANGGAL'];
                if(!isset($_pakai['total_terima'][$tgl])){
                    $_pakai['total_terima'][$tgl] = 0;
                }
                if(!isset($_pakai['total_pakai'][$tgl])){
                    $_pakai['total_pakai'][$tgl] = 0;
                }
                if(!is_null($gd['QTY_STOK'])){                    
                    $_pakai['total_terima'][$tgl] += $gd['QTY_TERIMA'];
                    $_pakai['total_pakai'][$tgl] += $gd['QTY_PAKAI'];                    
                    $info['total_pakai_gypsum'] += $gd['QTY_PAKAI']; 
                    $info['total_prognose_gypsum'] += $gd['QTY_PAKAI'];
                }else{
                    $_pakai['total_terima'][$tgl] += $gd['TERIMA_PROGNOSE'];
                    $_pakai['total_pakai'][$tgl] += $gd['PAKAI_PROGNOSE'];                    
                    $info['total_prognose_gypsum'] += $gd['PAKAI_PROGNOSE'];
                }                
            }
            foreach($_pakai as $k => $val){
                foreach($val as  $v){
                   array_push($pakai[$k],$v); 
                }                
            }
        }
        foreach($detail as $key => $d){
           $tgl =  $d['TANGGAL'];
           array_push($label,$tgl);                      
           array_push($stok['min'],$d['STOK_MIN']);
           array_push($stok['max'],$d['STOK_MAX']);
           $info['min'] = $d['STOK_MIN'];
           $info['max'] = $d['STOK_MAX'];
           $info['rp'] = $d['RP'];
           array_push($stok['rp'],$d['RP']);
           array_push($stok['dead_stock'],$d['DEAD_STOCK']);                      
           
           if(!$punya_deadstock){
               if(!empty($d['DEAD_STOCK'])){
                   $punya_deadstock = 1;
               }
           }
           if(!is_null($d['QTY_STOK'])){
              array_push($stok['stok'],$d['QTY_STOK']);  
              array_push($pakai['terima'],$d['QTY_TERIMA']);
              array_push($pakai['pakai'],$d['QTY_PAKAI']);
              
              array_push($color['stok'],'blue');
              array_push($color['pakai'],'green');              
              array_push($color['terima'],'red');              
              array_push($color['total_pakai'],'blue');              
              array_push($color['total_terima'],'brown');              
              
              $info['total_terima'] += $d['QTY_TERIMA'];
              $info['total_pakai'] += $d['QTY_PAKAI'];              
              $info['prognose_pakai'] += $d['QTY_PAKAI'];            
              
              $info['total_stok'] = $d['QTY_STOK'];                                                       
              
          
              
           }else{
              array_push($pakai['terima'],$d['TERIMA_PROGNOSE']);
              array_push($pakai['pakai'],$d['PAKAI_PROGNOSE']);                      
              array_push($stok['stok'],$d['STOK_PROGNOSE']); 
              
              array_push($color['stok'],'gray');
              array_push($color['terima'],'gray');
              array_push($color['pakai'],'gray');
              array_push($color['total_pakai'],'gray');              
              array_push($color['total_terima'],'gray');              
              $info['prognose_pakai'] += $d['PAKAI_PROGNOSE'];            
              
            
           }                     
                      
        }
        
    $result = array(    
        'satuan' => $satuan['SATUAN'],
        'pakai' => array(
            'labels' => $label,
            'datasets'=> array(
                array(
                    'label' => 'Terima',                  
                    'pointBackgroundColor' => $color['terima'],
                    'pointBorderColor' => $color['terima'],
                    'pointColor' => $color['terima'], 
                    'borderColor' => 'red',
                    'backgroundColor'=> 'red',                    
                    'fill' => false,                    
                    'data' => $pakai['terima'],                    
                   
                ),
                array(
                    'label' => 'Pakai',
                    'borderColor' => 'green',
                    'backgroundColor'=> 'green',
                    'pointBackgroundColor' => $color['pakai'],
                    'pointBorderColor' => $color['pakai'],
                    'fill' => false,                    
                    'data' => $pakai['pakai']
                ),
                array(
                    'label' => 'Prognose',                    
                    'borderColor' => 'gray',
                    'backgroundColor'=> 'gray',                                        
                    'fill' => false,
                    'data' => array()
                ),
                
            ),
        ),
        'minmax' => array(
            'labels' => $label,
            'datasets'=> array(
                array(
                    'label' => 'Stok',         
                    'borderColor' => 'blue',
                    'backgroundColor'=> 'blue',
                    'pointBackgroundColor' => $color['stok'],
                    'pointBorderColor' => $color['stok'],                    
                    'fill' => false,                    
                    'data' => $stok['stok']
                ),
                array(
                    'label' => 'Min',
                    'borderColor' => 'red',
                    'backgroundColor'=> 'red',
                    'fill' => false,
                    'data' => $stok['min'],
                    'pointRadius' => 0,
                ),
                array(
                    'label' => 'Max',
                    'borderColor' => 'green',
                    'backgroundColor'=> 'green',
                    'fill' => false,
                    'data' => $stok['max'],
                    'pointRadius' => 0,
                ),
                array(
                    'label' => 'RP',
                    'borderColor' => 'orange',
                    'backgroundColor'=> 'orange',
                    'fill' => false,
                    'data' => $stok['rp'],
                    'pointRadius' => 0,
                ),
                
            ),
        ),
        'info' => $info
    );
    if($punya_deadstock){
        array_push($result['minmax']['datasets'],array(
                'label' => 'Dead Stock',
                'borderColor' => 'black',
                'backgroundColor'=> 'black',
                'fill' => false,
                'data' => $stok['dead_stock'],
                'pointRadius' => 0,
            )
        );
    }
    if(in_array($kode_kelompok, $kode_gypsum)){
        array_push($result['pakai']['datasets'],array(
                'label' => 'Total Terima Gypsum',
                'borderColor' => 'brown',
                'backgroundColor'=> 'brown',
                'fill' => false,
                'data' => $pakai['total_terima'],
                'pointBackgroundColor' => $color['total_terima'],
                'pointBorderColor' => $color['total_terima'],
            )
        );
        array_push($result['pakai']['datasets'],array(
                'label' => 'Total Pakai Gypsum',
                'borderColor' => 'blue',
                'backgroundColor'=> 'blue',
                'fill' => false,
                'data' => $pakai['total_pakai'],
                'pointBackgroundColor' => $color['total_pakai'],
                'pointBorderColor' => $color['total_pakai'],
            )
        );
    }
    // echo '<pre>';
    //  print_r($result['minmax']);
    //  echo '</pre>'; 
    //  die();
    unset($result['minmax']['datasets'][3]);
    echo json_encode($result);
    }
    
    
    function detail(){
        $data = array('title'=>'Resource Inventory Detail');
        $opco = 7000;
        $plant_group = $this->input->post('plant_group');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $awalBulan = date('01 M Y');
        $akhirBulan = date('t M Y');
        $startDate = empty($startDate) ? $awalBulan : urldecode($startDate);
        $endDate = empty($endDate) ? $akhirBulan : urldecode($endDate);
        $viewStartDate = $startDate;
        $viewEndDate = $endDate;
        $plant_group = empty($plant_group) ? '7403' : $plant_group;
        $_startDate = new DateTime($startDate);
        $_endDate = new DateTime($endDate);
        $startDate = $_startDate->format('Y-m-d');
        $endDate = $_endDate->format('Y-m-d');
        
        $data['head'] = $this->ResourceInventory_model->listMaterial($opco,$plant_group);
        $stok = $this->ResourceInventory_model->getStok_history($opco,$plant_group,$startDate,$endDate);
        $data['stok'] = $this->groupingByColumn($stok,'KODE_KELOMPOK');
        $data['startDate'] = $viewStartDate;
        $data['endDate'] = $viewEndDate;            
        $data['startDateDb'] = $startDate;
        $data['endDateDb'] = $endDate;            
        $data['plant_group'] = $plant_group;
        $data['periode'] = '2016-12';
    //    $data['data'] = $this->ResourceInventory_model->getData();
        $this->template->display('ResourceInventory_view_history', $data);
        // $this->load->view('ResourceInventory_view', $data);
    }
    
    public function getData_history(){
        $label = array();
        $kode_kelompok = $this->input->get('kode_kelompok');
        $period = $this->input->get('period');
        $startDate = $this->input->get('startDate');
        $endDate = $this->input->get('endDate');
        $plant_group = $this->input->get('plant_group');
        $opco = 7000;
        $kode_gypsum = array(1300,1400,2700);
        $gypsum_detail = array();
        
        //$period = '2016-12';
        $detail = $this->ResourceInventory_model->getDetailStok_history($opco,$plant_group,$startDate,$endDate,$kode_kelompok);
        
        /* jika gypsum maka cari juga pemakaian untuk gypsum lainnya supaya mendapatkan total pemakaian gypsum */
        if(in_array($kode_kelompok, $kode_gypsum)){           
           $gypsum_detail = $this->ResourceInventory_model->getDetailStok_history($opco,$plant_group,$startDate,$endDate,$kode_gypsum); 
        }
        
        
        $tmp = array('1' => array(), '2' => array(), '3' => array(),'4' => array());
        $data = array('1' => array(), '2' => array(), '3' => array(), '4' => array());
        $pakai = array(
            'terima' => array(),'pakai' => array(), 'total_terima' => array(), 'total_pakai' => array()
        );
        $stok = array(
            'min' => array(),'max' => array(),'rp' => array(),'dead_stock' => array(),'stok' => array()
        );
        $color = array(
            'terima' => array(),
            'pakai'  => array(),
            'total_terima' => array(),
            'stok' => array(),
            'total_pakai' => array()
        );
        $info = array('min' => 0, 'max' => 0, 'rp' => 0,'total_stok' => 0, 'total_terima' => 0, 'total_pakai' => 0, 'rkap' => 0, 'prognose_pakai'=>0, 'total_pakai_gypsum' => 0, 'total_prognose_gypsum' => 0);
        $punya_deadstock = 0;
        
        if(in_array($kode_kelompok, $kode_gypsum)){
            
            $_pakai = array('total_terima'=> array(),'total_pakai'=>array());
            foreach($gypsum_detail as $gd){
                $tgl = $gd['TANGGAL'];
                if(!isset($_pakai['total_terima'][$tgl])){
                    $_pakai['total_terima'][$tgl] = 0;
                }
                if(!isset($_pakai['total_pakai'][$tgl])){
                    $_pakai['total_pakai'][$tgl] = 0;
                }
                if(!is_null($gd['QTY_STOK'])){                    
                    $_pakai['total_terima'][$tgl] += $gd['QTY_TERIMA'];
                    $_pakai['total_pakai'][$tgl] += $gd['QTY_PAKAI'];                    
                    $info['total_pakai_gypsum'] += $gd['QTY_PAKAI']; 
                    $info['total_prognose_gypsum'] += $gd['QTY_PAKAI'];
                }else{
                    $_pakai['total_terima'][$tgl] += $gd['TERIMA_PROGNOSE'];
                    $_pakai['total_pakai'][$tgl] += $gd['PAKAI_PROGNOSE'];                    
                    $info['total_prognose_gypsum'] += $gd['PAKAI_PROGNOSE'];
                }                
            }
            foreach($_pakai as $k => $val){
                foreach($val as  $v){
                   array_push($pakai[$k],$v); 
                }                
            }
        }
        foreach($detail as $key => $d){
           $tgl =  $d['TANGGAL'];
           array_push($label,$tgl);                      
           array_push($stok['min'],$d['STOK_MIN']);
           array_push($stok['max'],$d['STOK_MAX']);
           $info['min'] = $d['STOK_MIN'];
           $info['max'] = $d['STOK_MAX'];
           $info['rp'] = $d['RP'];
           array_push($stok['rp'],$d['RP']);
           array_push($stok['dead_stock'],$d['DEAD_STOCK']);
           
           if(!$punya_deadstock){
               if(!empty($d['DEAD_STOCK'])){
                   $punya_deadstock = 1;
               }
           }
           if(!is_null($d['QTY_STOK'])){
              array_push($stok['stok'],$d['QTY_STOK']);  
              array_push($pakai['terima'],$d['QTY_TERIMA']);
              array_push($pakai['pakai'],$d['QTY_PAKAI']);
              
              array_push($color['stok'],'blue');
              array_push($color['pakai'],'green');              
              array_push($color['terima'],'red');              
              array_push($color['total_pakai'],'blue');              
              array_push($color['total_terima'],'brown');              
              $info['total_stok'] += $d['QTY_STOK'];              
              $info['total_terima'] += $d['QTY_TERIMA'];
              $info['total_pakai'] += $d['QTY_PAKAI'];              
              $info['prognose_pakai'] += $d['QTY_PAKAI'];            
             
           }else{
              array_push($pakai['terima'],$d['TERIMA_PROGNOSE']);
              array_push($pakai['pakai'],$d['PAKAI_PROGNOSE']);                      
              array_push($stok['stok'],$d['STOK_PROGNOSE']); 
              
              array_push($color['stok'],'gray');
              array_push($color['terima'],'gray');
              array_push($color['pakai'],'gray');
              array_push($color['total_pakai'],'gray');              
              array_push($color['total_terima'],'gray');              
              $info['prognose_pakai'] += $d['PAKAI_PROGNOSE'];            
           }           
        }
        
    $result = array(    
        'pakai' => array(
            'labels' => $label,
            'datasets'=> array(
                array(
                    'label' => 'Terima',                  
                    'pointBackgroundColor' => $color['terima'],
                    'pointBorderColor' => $color['terima'],
                    'pointColor' => $color['terima'], 
                    'borderColor' => 'red',
                    'backgroundColor'=> 'red',
                    'fill' => false,
                   
                    'data' => $pakai['terima'],                    
                   
                ),
                array(
                    'label' => 'Pakai',
                    'borderColor' => 'green',
                    'backgroundColor'=> 'green',
                    'pointBackgroundColor' => $color['pakai'],
                    'pointBorderColor' => $color['pakai'],
                    'fill' => false,
                    'data' => $pakai['pakai']
                ),
                array(
                    'label' => 'Prognose',                    
                    'borderColor' => 'gray',
                    'backgroundColor'=> 'gray',
                    'fill' => false,
                    'data' => array()
                ),
            ),
        ),
        'minmax' => array(
            'labels' => $label,
            'datasets'=> array(
                array(
                    'label' => 'Stok',         
                    'borderColor' => 'blue',
                    'backgroundColor'=> 'blue',
                    'pointBackgroundColor' => $color['stok'],
                    'pointBorderColor' => $color['stok'],                    
                    'fill' => false,
                    'data' => $stok['stok']
                ),
                array(
                    'label' => 'Min',
                    'borderColor' => 'red',
                    'backgroundColor'=> 'red',
                    'fill' => false,
                    'data' => $stok['min'],
                    'pointRadius' => 0,
                ),
                array(
                    'label' => 'Max',
                    'borderColor' => 'green',
                    'backgroundColor'=> 'green',
                    'fill' => false,
                    'data' => $stok['max'],
                    'pointRadius' => 0,
                ),
                array(
                    'label' => 'RP',
                    'borderColor' => 'orange',
                    'backgroundColor'=> 'orange',
                    'fill' => false,
                    'data' => $stok['rp'],
                    'pointRadius' => 0,
                ),
            ),
        ),
        
    );
    if($punya_deadstock){
        array_push($result['minmax']['datasets'],array(
                'label' => 'Dead Stock',
                'borderColor' => 'black',
                'backgroundColor'=> 'black',
                'fill' => false,
                'data' => $stok['dead_stock'],
                'pointRadius' => 0,
            )
        );
    }
    if(in_array($kode_kelompok, $kode_gypsum)){
        array_push($result['pakai']['datasets'],array(
                'label' => 'Total Terima Gypsum',
                'borderColor' => 'brown',
                'backgroundColor'=> 'brown',
                'fill' => false,
                'data' => $pakai['total_terima'],
                'pointBackgroundColor' => $color['total_terima'],
                'pointBorderColor' => $color['total_terima'],
            )
        );
        array_push($result['pakai']['datasets'],array(
                'label' => 'Total Pakai Gypsum',
                'borderColor' => 'blue',
                'backgroundColor'=> 'blue',
                'fill' => false,
                'data' => $pakai['total_pakai'],
                'pointBackgroundColor' => $color['total_pakai'],
                'pointBorderColor' => $color['total_pakai'],
            )
        );
    }
    echo json_encode($result);
    }
    
    public function toExcel(){
        $startDate = $this->input->get('startDate');
        $endDate = $this->input->get('endDate');
        $kodeKelompok = $this->input->get('kodekelompok');
        $plant = $this->input->get('plant');
        $nama = $this->input->get('nama');
        $opco = 7000;
        $listPlant = array(
            '7401' => 'Gresik',
            '7403' => 'Tuban'
        );
        $namafile = 'Data '.$nama.' plant '.$listPlant[$plant].' '.$startDate.' sd '.$endDate;
     #   $kode_gypsum = array(1300,1400);
        $gypsum_detail = array();
        
        //$period = '2016-12';
        $detail = $this->ResourceInventory_model->getDetailStok_history($opco,$plant,$startDate,$endDate,$kodeKelompok);
        
        /* jika gypsum maka cari juga pemakaian untuk gypsum lainnya supaya mendapatkan total pemakaian gypsum */
    #    if(in_array($kodeKelompok, $kode_gypsum)){           
    #       $gypsum_detail = $this->ResourceInventory_model->getDetailStok_history($opco,$plant,$startDate,$endDate,$kode_gypsum); 
    #    }
        
        
        $judul = array('tanggal','terima_prognose','pakai_prognose','stok_prognose','terima','pakai','stok','min','max','rp','dead stock');
        
        $this->load->library('Excel');        
        $objPHPExcel = new PHPExcel();
        
        
        array_unshift($detail,$judul);
        array_unshift($detail,array('Tanggal '.$startDate.' sd '.$endDate));
        array_unshift($detail,array('Pabrik '.$listPlant[$plant]));
        array_unshift($detail,array('Prognose Penerimaan, Pemakaian, Stok Bahan Baku Dan Penolong'));
        $style = array(
        'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb'=>'1006A3')
        );
        $style_header = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
        /*    'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb'=>'E1E0F7'),
            ),*/
            'font' => array(
                'bold' => true,
            )
        );
        $style_body = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            )
        
        );
        
        $objPHPExcel->getActiveSheet()->mergeCells("A1:K1")->getStyle("A1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells("A2:K2")->getStyle("A2")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells("A3:K3")->getStyle("A3")->applyFromArray($style);
        #$objPHPExcel->getStyle("A1:L1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->fromArray($detail);
        $objPHPExcel->getActiveSheet()->getStyle("A4:K4")->applyFromArray($style_header)->getAlignment()->setIndent(1);
        
        $objPHPExcel->getActiveSheet()->getStyle("A5:K".count($detail))->applyFromArray($style_body);
     
        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$namafile.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("php://output");  
        
    }
}