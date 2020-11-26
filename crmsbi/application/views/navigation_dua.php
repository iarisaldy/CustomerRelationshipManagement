        <!-- Select Plugin Js -->
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
        
        <!-- Waves Effect Plugin Js -->
        <script src="<?php echo base_url();?>assets/plugins/node-waves/waves.js"></script>
        <!-- Jquery DataTable Plugin Js -->
        <script src="<?php echo base_url();?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
        <!-- Custom Js -->
        <script src="<?php echo base_url();?>assets/js/admin.js"></script>
        <script src="<?php echo base_url();?>assets/js/pages/tables/jquery-datatable.js"></script>
        <!-- Demo Js -->
        <script src="<?php echo base_url();?>assets/js/demo.js"></script>
        <!-- jquery session -->
        <script src="<?php echo base_url();?>assets/plugins/jquery-session/jquerysession.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
        
        
<!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->
        <!-- Search Bar -->
        <div class="search-bar">
            <div class="search-icon">
                <i class="material-icons">search</i>
            </div>
            <input type="text" placeholder="START TYPING...">
            <div class="close-search">
                <i class="material-icons">close</i>
            </div>
        </div>
        <!-- #END# Search Bar -->
        <!-- Top Bar -->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"><span></span></a>
                    <a class="navbar-brand" ><span><img class="col-xs-hidden" src="<?php echo base_url();?>assets/logo/sig-putih.png" style="width:60px;margin-top:-16px;"></span> <font style="vertical-align: 4px;">CRM DASHBOARD<font></a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="javascript:void(0);" class="js-search" data-toggle="modal" data-target="#smallModal"><i class="material-icons">settings</i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- #Top Bar -->
        <section>
            <!-- Left Sidebar -->
            <aside id="leftsidebar" class="sidebar">
                <!-- User Info -->
                <div class="user-info">
                    <div class="image">
                        <img src="<?php echo base_url('assets/images/user.png');?>" width="48" height="48" alt="User" />
                    </div>
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;"><?php echo $this->session->userdata('name'); ?></div>
                        <div class="email" style="font-size: 9px; color:black;">
                            <?php echo $this->session->userdata('jenis_user'); ?><br/>
                            <?php
                                if($this->session->userdata("id_jenis_user") == "1002"){
                                    echo $this->session->userdata("nama_dist");
                                }
                            ?>
                        </div>
                        <div class="btn-group user-helper-dropdown" style="right: -5px;bottom: 4px;">
                            <a href="<?php echo base_url('logout/logout') ?>"><button type="button" id="logout" class="btn btn-default btn-sm waves-effect"><span class="glyphicon glyphicon-log-out"></span> Log out</button></a>
                        </div>
                    </div>
                </div>
                <!-- #User Info -->
                <!-- Menu -->
                <div class="menu">
                    <ul class="list">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="active"><a href="<?php echo base_url('administrator/Home'); ?>"><i class="material-icons">home</i><span>Dashboard</span></a></li>
                        <?php if($this->session->userdata('id_jenis_user') == '1000'){ ?>
                            <li><a href="<?php echo base_url('administrator/User') ?>"><i class="material-icons">people</i><span>User Management</span></a></li>
                        <?php } ?>
                        
                        <?php
                            $dataMenu = $menus['dataMenu']; 
                            $subMenus = $menus['subMenu'];

                            foreach ($dataMenu as $menusKey => $menusValue) { 
                        ?>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="material-icons">home</i><span><?php echo $menusValue->NAMA_MENU ?></span></a>
                            <ul class="ml-menu">
                            <?php 
                                foreach ($subMenus as $subMenusKey => $subMenusValue) {
                                    if($subMenusValue->ID_MENU == $menusValue->ID_MENU){
                            ?>
                                <li><a href="<?php echo base_url().$subMenusValue->LINK; ?>"><?php echo $subMenusValue->NAMA_MENU; ?></a></li>
                                <?php } } ?>
                                </ul>
                        <?php } ?>
                    </li>
                        <!-- <li><a href="DurasiSurvey"><i class="material-icons">access_time</i><span>Durasi Survey</span></a></li>
                        <li><a href="KunjunganAreaManagerSales"><i class="material-icons">access_time</i><span>Kunjungan AM & Sales</span></a></li>
                        <li><a href="Web_Marketshare"><i class="material-icons">insert_chart</i><span>Market Share</span></a></li>
                        <li><a href="TrenHarga"><i class="material-icons">insert_chart</i><span>Trend Harga</span></a></li>
                        <li><a href="GrafikStok"><i class="material-icons">insert_chart</i><span>Grafik Stok</span></a></li>
                        <li><a href="GudangToko"><i class="material-icons">location_on</i><span>Peta Stok</span></a></li>
                        <li><a href="GrafikKeluhan"><i class="material-icons">insert_chart</i><span>Grafik Keluhan</span></a></li>
                        <li><a href="ProgramPromosi"><i class="material-icons">insert_chart</i><span>Grafik Program Promosi</span></a></li>
                        <li><a href="PetaPromosi"><i class="material-icons">location_on</i><span>Peta Promosi</span></a></li>
                        <li><a href="MarketInfo"><i class="material-icons">info</i><span>Market Info</span></a></li>
                        <li><a href="PetaLokasi"><i class="material-icons">location_on</i><span>Peta Lokasi</span></a></li>
                        <li><a href="FasilitasPesaing"><i class="material-icons">location_on</i><span>Fasilitas Pesaing</span></a></li>
                        <li><a href="KeyPerformanceIndicators"><i class="material-icons">info</i><span>Key Performance Indicators</span></a></li>
                        <li><a target="_blank" href="apperp.semenindonesia.com:8080/webui/"><i class="material-icons">people</i><span>Management Admin</span></a></li> -->
                    </ul>
                </div>
                <!-- #Menu -->
                <!-- Footer -->
                <div class="legal">
                    <div class="copyright" style="font-size: 11px;">
                        <?php echo date('Y'); ?> &copy; <a href="javascript:void(0);">Customer Relationship Management <sub>V.1.0</sub></a>
                    </div>
                    <!--<div class="version">
                        <b>Version: </b> 1.0.4
                    </div>-->
                </div>
                <!-- #Footer -->
            </aside>
            <!-- #END# Left Sidebar -->
        </section>
<!-- Small Size -->
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #00BCD4; color: white;">
                <h4 class="modal-title" id="smallModalLabel">Edit Password</h4>
            </div>
            
            <div class="modal-body">
                <form>
                    <label for="password">Password</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="password" value="" id="changePassword" class="form-control" placeholder="Enter your new password">
                        </div>
                    </div>
                    
                    <label for="confirmPassword">Confirm Password</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="password" value="" id="confirmPassword" class="form-control" placeholder="Enter your new confirm password">
                        </div>
                    </div>
                </form> 
            </div>
            
            <div class="modal-footer">
                <button type="button" id="btnUpdatePassword" class="btn btn-info waves-effect">SAVE</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", "#btnUpdatePassword", function(e){
        e.preventDefault();
        var password = $("#changePassword").val();
        var confirmPassword = $("#confirmPassword").val();

        $.ajax({
            url : "<?php echo base_url() ?>administrator/User/changePassword",
            type: "POST",
            dataType: "JSON",
            data: {
                "password": password,
                "confirm_password": confirmPassword
            },
            success: function(data){
                if(data.status == "error"){
                    alert(data.message);
                } else {
                    $("#password, #confirmPassword").val("");
                    alert("Ubah password berhasil");
                    $("#smallModal").modal("hide");
                }
            }
        });
    });
</script>