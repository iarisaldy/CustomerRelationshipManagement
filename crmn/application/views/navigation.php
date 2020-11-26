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
                <a href="<?php echo base_url('administrator/Home'); ?>" class="navbar-brand">Customer Relationship Management</a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <?php if($this->session->userdata('id_jenis_user') == '1000'){ ?>
                    <li class="dropdown menu-icon">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                            <img class="logo-menu" src="<?php echo base_url(); ?>assets/img/menu/semen_indonesia.JPG"><br/>User Management<span class="caret"></span>
                        </a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="<?php echo base_url('administrator/User/add'); ?>"><i class="fa fa-thumb-tack"></i> Add New User</a></li>
                            <li><a href="<?php echo base_url('administrator/User'); ?>"><i class="fa fa-thumb-tack"></i> User List</a></li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php 
                        $dataMenu = $menus['dataMenu']; 
                        $subMenus = $menus['subMenu'];
                        
                        foreach ($dataMenu as $menusKey => $menusValue) { ?>
                        <li class="dropdown menu-icon">
                                <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                                    <img class="logo-menu" src="<?php echo base_url(); ?>assets/img/menu/semen_indonesia.JPG"><br/><?php echo $menusValue->NAMA_MENU ?><span class="caret"></span>
                                </a>
                                <ul role="menu" class="dropdown-menu">
                            <?php 
                                foreach ($subMenus as $subMenusKey => $subMenusValue) {
                                    if($subMenusValue->ID_MENU == $menusValue->ID_MENU){
                            ?>
                                    <li><a href="<?php echo base_url().$subMenusValue->LINK; ?>"><i class="fa fa-thumb-tack"></i> <?php echo $subMenusValue->NAMA_MENU; ?></a></li>
                            <?php } } ?>
                                </ul>
                            </li>
                    <?php } ?>

                        </ul>      
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown menu-icon">
                                <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                                    <i class="fa fa-reorder fa-3x" style="font-size: 25px"></i><br/><span class="caret" style="margin-left:-5px"></span>
                                </a>
                                <ul role="menu" class="dropdown-menu">
                                    <!-- <li><a href="<?php echo base_url(); ?>assets/document/USER_GUIDE.pdf" target="_blank"><i class="fa fa-download"></i> Download Userguide</a></li> -->
                                    <li><a href="<?php echo base_url(); ?>logout"><i class="fa fa-power-off"></i> Log Out</a></li>
                                </ul>
                            </li>
                        </ul>

                        </div>
                        </nav>
                        </div>
                        <div class="wrapper wrapper-content">
                            <div class="container">
                                <div class="row">