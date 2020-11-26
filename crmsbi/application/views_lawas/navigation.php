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
                            <li><a href="<?php echo base_url(); ?>smigroup/StockLevelGudang"> <i class="fa fa-thumb-tack"></i> Stok Gudang</a></li>
                            <li><a href="<?php echo base_url(); ?>smigroup/SiloPP"><i class="fa fa-thumb-tack"></i> Stok Silo PP</a></li>                                    
                            <li><a href="<?php echo base_url(); ?>smigroup/PetaPencapaian"><i class="fa fa-thumb-tack"></i> Realisasi Sales</a></li>
                            <!--<li><a href="<?php // echo base_url(); ?>smigroup/MarketShare"><i class="fa fa-thumb-tack"></i> Realisasi Market Share</a></li>-->
                            <li><a href="<?php echo base_url(); ?>dashboard/Demandpl"><i class="fa fa-thumb-tack"></i> S&OP</a></li>
                            <li><a href="<?php echo base_url(); ?>smigroup/Revenue"><i class="fa fa-thumb-tack"></i> Monitoring Revenue</a></li>
                            <!--<li><a href="<?php echo base_url(); ?>smigroup/Intelligent"><i class="fa fa-thumb-tack"></i> Intelligent System</a></li>-->
                            <li><a href="<?php echo base_url(); ?>smigroup/MarineTraffic"><i class="fa fa-thumb-tack"></i> Marine Traffic</a></li>
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
                        foreach($menus as $menu){                                                        
                            foreach($menu as $m){  
                                ?>
                            <li class="dropdown menu-icon">
                                    <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                                        <img class="logo-menu" style="<?php if($m['icon']['title']=='MI'){echo 'width:85px';} ?>" src="<?=base_url().$m['icon']['icon']?>"><br/><?php if($m['icon']['title']!='MI'){echo $m['icon']['title'];}?><span class="caret"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu">
                                        <?php
                                    foreach($m['menu'] as $mm){
                                        echo '<li><a href="'.site_url($mm['url']).'"><i class="'.$mm['icon'].'"></i> '.$mm['title'].'</a></li>';
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
                                <i class="fa fa-list fa-3x" style="font-size: 25px"></i><br/><span class="caret"></span>
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