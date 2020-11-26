<style>
    .menu-icon{
        text-align: center; 
        margin-top: -10px; 
        margin-right: 20px;
        line-height: 15px;
    }
    .logo-menu{
        height: 30px;
        width: 30px;
    }
    .dropdown{
        color: black;
    }
    .tree > li{
        padding-bottom: 10px
    }
    .label-cap{
        background-color: #ff4545;
        color: white;
        font-size: 10px;
        border: 2px solid #ff4545;
        border-radius: 25px;
    }
</style>
<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom white-bg" id="menu">
        <nav id="topmenu" class="navbar navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <i class="fa fa-reorder"></i>
                </button>
                <a href="<?php echo base_url(); ?>dashboard" class="navbar-brand">Sales & Operations Planning</a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li class="dropdown menu-icon">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                            <img class="logo-menu" src="<?php echo base_url(); ?>assets/img/menu/semen_indonesia.JPG"><br/>SMI Group<span class="caret"></span>
                        </a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>dashboard/Demandpl"><i class="fa fa-thumb-tack"></i> Sales & Operation Planning</a></li>
                            <li><a href="<?php echo base_url(); ?>smigroup/StockLevelGudang"> <i class="fa fa-thumb-tack"></i> Stok Gudang (Sales)</a></li>
                            <li><a href="<?php echo base_url(); ?>smigroup/SiloPP"><i class="fa fa-thumb-tack"></i> Stok Silo Pabrik dan PP</a></li>                                    
                            <li><a href="javascript:void(0)" class="tree-toggle"><i class="fa fa-thumb-tack"></i> Realisasi By Sales </a>
                                <ul class="tree dropdown-toggle">
                                    <li class="submenu " ><a href="<?php echo base_url(); ?>smigroup/PetaPencapaian" style="color:black">By Sales Opco</a></li>
                                    <li class="submenu " ><a href="<?php echo base_url(); ?>smigroup/PetaPencapaianSales" style="color:black">By Sales Regional</a></li>
                                    <li class="submenu " ><a href="<?php echo base_url(); ?>smigroup/PencapaianProvinsi" style="color:black">By Sales per Provinsi</a></li>
                                    <li class="submenu " ><a href="<?php echo base_url(); ?>smigroup/PencapaianSDK" style="color:black">By Sales Growth per Provinsi</a></li>
                                </ul>
                            </li>
<!--                            <li><a href="<?php echo base_url(); ?>smigroup/PetaPencapaianSales"><i class="fa fa-thumb-tack"></i> Realisasi By Sales Regional </a></li>
                            <li><a href="<?php echo base_url(); ?>smigroup/PencapaianProvinsi"><i class="fa fa-thumb-tack"></i> Realisasi By Sales per Provinsi</a></li>-->
                           <!--<li><a href="<?php // echo base_url();      ?>smigroup/MarketShare"><i class="fa fa-thumb-tack"></i> Realisasi Market Share</a></li>-->
                            <li><a href="javascript:void(0)" class="tree-toggle"><i class="fa fa-thumb-tack"></i> Realisasi OA & Revenue   <span class="label-cap"> progress </span></a>
                                <ul class="tree dropdown-toggle">
                                    <li class="submenu " ><a href="<?php echo base_url(); ?>smigroup/MonitoringRevenue" style="color:black"> By Opco   <span class="label-cap"> progress </span></a></li>
                                    <li class="submenu " ><a href="<?php echo base_url(); ?>smigroup/RevenueRegion" style="color:black"> By Regional   <span class="label-cap"> progress </span></a></li>
                                </ul>
                            </li>
                            <!--<li><a href="<?php echo base_url(); ?>smigroup/Revenue"><i class="fa fa-thumb-tack"></i> Monitoring Revenue  <span class="label-cap"> progress </span></a></li>-->
                            <!--<li><a href="<?php echo base_url(); ?>smigroup/Intelligent"><i class="fa fa-thumb-tack"></i> Intelligent System</a></li>-->
                            <!--<li><a href="<?php echo base_url(); ?>smigroup/MarineTraffic"><i class="fa fa-thumb-tack"></i> Marine Traffic</a></li>-->
                            <li><a href="<?php echo base_url(); ?>smigroup/MonitoringMargin"><i class="fa fa-thumb-tack"></i> Realisasi Rev Per Plant & Per Distrik   <span class="label-cap"> progress </span></a></li>
                            <li><a href="<?php echo base_url(); ?>smigroup/HargaTebus"><i class="fa fa-thumb-tack"></i> HargaTebus</a></li>


                        </ul>
                    </li>
                    <!--    
                    <?php if ($this->session->userdata('opco') == '7000' || $this->session->userdata('opco') == '5000' || $this->session->userdata('opco') == '2000') { ?>
                                                <li class="dropdown menu-icon">
                                                    <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                                                        <img class="logo-menu" src="<?php echo base_url(); ?>assets/img/menu/semen_gresik.png"><br/>SG<span class="caret"></span>
                                                    </a>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a href="<?php echo base_url(); ?>sg/InPlantTuban"><i class="fa fa-thumb-tack"></i> Truck In Plant Tuban</a></li>
                                                        <li><a href="<?php echo base_url(); ?>sg/StatusPabrik"><i class="fa fa-thumb-tack"></i> Status Pabrik</a></li>
                                                        <li><a href="<?php echo base_url(); ?>sg/ResourceInventory"><i class="fa fa-thumb-tack"></i> Stok Bahan & Batubara</a></li>
                                                        <li><a href="<?php echo base_url(); ?>sg/CrmGudangService"><i class="fa fa-thumb-tack"></i> Stok Per Area</a></li>
                                                        <li><a href="<?php echo base_url(); ?>sg/PencapaianProvinsi"><i class="fa fa-thumb-tack"></i> Kinerja Kepala Biro Penjualan</a></li>
                                                        <li><a href="<?php echo base_url(); ?>sg/GrafikPencapaian"><i class="fa fa-thumb-tack"></i> Grafik Sales Per Provinsi</a></li>
                                                    </ul>
                                                </li>
                    <?php } ?>
                    <?php if ($this->session->userdata('opco') == '3000' || $this->session->userdata('opco') == '2000') { ?>
                                                <li class="dropdown menu-icon">
                                                    <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                                                        <img class="logo-menu" src="<?php echo base_url(); ?>assets/img/menu/semen_padang.png"><br/>SP<span class="caret"></span>
                                                    </a>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a href="<?php echo base_url(); ?>sp/ResourceInventory"><i class="fa fa-thumb-tack"></i> Stok Bahan & Batubara</a></li>
                                                        <li><a href="<?php echo base_url(); ?>sp/PencapaianProvinsi"><i class="fa fa-thumb-tack"></i> Kinerja Kepala Biro Penjualan</a></li>
                                                        <li><a href="<?php echo base_url(); ?>sp/GrafikPencapaian"><i class="fa fa-thumb-tack"></i> Grafik Sales Per Provinsi</a></li>
                                                    </ul>
                                                </li>
                    <?php } ?>
                    <?php if ($this->session->userdata('opco') == '4000' || $this->session->userdata('opco') == '2000') { ?>
                                                <li class="dropdown menu-icon">
                                                    <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                                                        <img class="logo-menu" src="<?php echo base_url(); ?>assets/img/menu/semen_tonasa.png"><br/>ST<span class="caret"></span>
                                                    </a>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a href="<?php echo base_url(); ?>st/ResourceInventory"><i class="fa fa-thumb-tack"></i> Stok Bahan & Batubara</a></li>
                                                        <li><a href="<?php echo base_url(); ?>st/PencapaianProvinsi"><i class="fa fa-thumb-tack"></i> Kinerja Kepala Biro Penjualan</a></li>
                                                        <li><a href="<?php echo base_url(); ?>st/GrafikPencapaian"><i class="fa fa-thumb-tack"></i> Grafik Sales Per Provinsi</a></li>
                                                    </ul>
                                                </li>
                    <?php } ?>
                    <?php if ($this->session->userdata('opco') == '6000' || $this->session->userdata('opco') == '2000') { ?>
                                                <li class="dropdown menu-icon">
                                                    <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                                                        <img class="logo-menu" src="<?php echo base_url(); ?>assets/img/menu/thang_long.jpg"><br/>TLCC<span class="caret"></span>
                                                    </a>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a href="<?php echo base_url(); ?>tlcc/PetaPenjualan"><i class="fa fa-thumb-tack"></i> Peta Penjualan</a></li>
                                                        <li><a href="<?php echo base_url(); ?>tlcc/SalesRealization"><i class="fa fa-thumb-tack"></i> Sales Realization</a></li> 
                                                    </ul>
                                                </li>
                    <?php } ?>
                    -->        
                    <?php
//                        foreach($menus as $menu){                                                        
//                            foreach($menu as $m){                                                        
//                            echo '<li class="dropdown menu-icon">
//                                    <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
//                                        <img class="logo-menu" src="'.base_url().$m['icon']['icon'].'"><br/>'.$m['icon']['title'].'<span class="caret"></span>
//                                    </a>
//                                    <ul role="menu" class="dropdown-menu">';
//                                    foreach($m['menu'] as $mm){
//                                        echo '<li><a href="'.site_url($mm['url']).'"><i class="'.$mm['icon'].'"></i> '.$mm['title'].'</a></li>';
//                                    }
//                            echo '</ul>
//                                </li>';        
//                            }        
//                            
//                        }                    
                    foreach ($menus as $menu) {
                        foreach ($menu as $m) {
                            ?>
                            <li class="dropdown menu-icon">
                                <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                                    <img class="logo-menu" style="<?php
                                    if ($m['icon']['title'] == 'MI') {
                                        echo 'width:85px';
                                    }
                                    ?>" src="<?= base_url() . $m['icon']['icon'] ?>"><br/><?php
                                         if ($m['icon']['title'] != 'MI') {
                                             echo $m['icon']['title'];
                                         }
                                         ?><span class="caret"></span>
                                </a>
                                <ul role="menu" class="dropdown-menu">
                                    <?php
                                    foreach ($m['menu'] as $mm) {
                                        $site = ($mm['url'] == '') ? 'javascript:void(0)' : site_url($mm['url']);
                                        echo '<li><a href="' . $site . '" class="tree-toggle "><i class="' . $mm['icon'] . '"></i> ' . $mm['title'] . '</a>';
                                        if (isset($mm['submenu'])) {
                                            echo '<ul class="tree dropdown-toggle">';
                                            foreach ($mm['submenu'] as $key => $value) {
                                                //$color = ($value['url'] == '' ? 'black' : '');
                                                $color = "black";
                                                echo '<li class="submenu " style="color:' . $color . '"><a href="' . site_url($value['url']) . '" style="color:' . $color . '"> ' . $value['title'] . '</a></li>';
                                            }
                                            echo '</ul>';
                                        }
                                        echo '</li>';
                                    }
                                    echo '</ul>
                                </li>';
                                }
                            }
                            ?>    
                        </ul>      
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown menu-icon">
                                <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                                    <i class="fa fa-reorder fa-3x" style="font-size: 25px"></i><br/><span class="caret" style="margin-left:-5px"></span>
                                </a>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="<?php echo base_url(); ?>assets/document/USER_GUIDE.pdf" target="_blank"><i class="fa fa-download"></i> Download Userguide</a></li>
                                    <li><a href="<?php echo base_url(); ?>logout"><i class="fa fa-power-off"></i> Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!--                <ul class="nav navbar-top-links navbar-right">
                                            <li class="menu-icon">
                                                <a href="<?php echo base_url(); ?>logout">
                                                    <i class="pe-7s-power" style="font-size: 25px"></i><br/>Log out
                                                </a>
                                            </li>
                                        </ul>-->
                        </div>
                        </nav>
                        </div>
                        <div class="wrapper wrapper-content">
                            <div class="container">
                                <div class="row">