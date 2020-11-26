<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Survey Validation Apps</title>
  <link rel="icon" href="<?php echo base_url('assets/images/icon.png'); ?>" type="image/x-icon">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/Ionicons/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css');?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
   folder instead of downloading all of them to reduce the load. -->
   <link rel="stylesheet" href="<?php echo base_url('assets/css/_all-skins.min.css');?>">
   <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js');?>"></script>
   <script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>

   <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
   <script src="<?php echo base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
   <script src="<?php echo base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
   <!-- SlimScroll -->
   <script src="<?php echo base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
   <!-- FastClick -->
   <script src="<?php echo base_url('assets/bower_components/fastclick/lib/fastclick.js');?>"></script>
   <!-- AdminLTE App -->
   <script src="<?php echo base_url('assets/js/adminlte.min.js');?>"></script>
   <!-- AdminLTE for demo purposes -->
   <script src="<?php echo base_url('assets/js/demo.js');?>"></script>

   <!-- Google Font -->
   <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
   
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/plugins/sweetalert/sweetalert.css');?>">

   <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/sweetalert/sweetalert.min.js');?>"></script>
   <style type="text/css">
   .no-js #loader { display: none;  }
   .js #loader { display: block; position: absolute; left: 100px; top: 0; }
   .se-pre-con {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url(<?php echo base_url('assets/images/Preloader_8.gif');?>) center no-repeat #fff;
  }

  thead th {
    background-color: #dd4b39;
    color: white;
  }

  tfoot th {
    background-color: #dd4b39;
    color: white;
  }
</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-red sidebar-mini">
  <div class="se-pre-con"></div>
  <!-- Site wrapper -->
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S</b>V</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Survey</b>Validation</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo base_url('assets/images/user1-160x160.png');?>" class="user-image" alt="User Image">
                <span class="hidden-xs" id="name-user">Alexander Pierce</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="<?php echo base_url('assets/images/user1-160x160.png');?>" class="img-circle" alt="User Image">
                  <p id="name-user2">
                    Alexander Pierce - Web Developer
                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                  <!-- <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                  </div> -->
                  <center>
                    <a href="#" id="btn-logout" class="btn btn-sm btn-danger">LOG OUT</a>
                  </center>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?php echo base_url('assets/images/user1-160x160.png');?>" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p id="name-user1">Alexander Pierce</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <li id="home" <?php if($this->uri->segment(1) == "home"){ echo "class='active'";}?>>
            <a href="<?php echo base_url('home'); ?>">
              <i class="fa fa-home"></i> <span>Home</span>
            </a>
          </li>
          <li id="customer" <?php if($this->uri->segment(1) == "customer"){ echo "class='active'";}?>>
            <a href="<?php echo base_url('customer'); ?>">
              <i class="fa fa-id-badge"></i> <span>Customer</span>
            </a>
          </li>
          <li id="user" <?php if($this->uri->segment(1) == "user"){ echo "class='treeview active'";} else { echo "class='treeview'"; } ?>>
            <a href="#">
              <i class="fa fa-users"></i> <span>User Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li <?php if($this->uri->segment(2) != "add"){ echo "class='active'";}?>><a href="<?php echo base_url('user'); ?>"><i class="fa fa-circle-o"></i> User List</a></li>
              <li <?php if($this->uri->segment(2) == "add"){ echo "class='active'";}?>><a href="<?php echo base_url('user/add'); ?>"><i class="fa fa-circle-o"></i> Add New User</a></li>
            </ul>
          </li>
          <li id="version" <?php if($this->uri->segment(1) == "version"){ echo "class='active'";}?>>
            <a href="<?php echo base_url('version'); ?>">
              <i class="fa fa-mobile"></i> <span>Application Version</span>
            </a>
          </li>

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <?= $contents; ?>

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.006
      </div>
      <strong>Copyright &copy; <?php echo date('Y') ?> <a href="#">PT. Semen Indonesia</a>.</strong> All rights
      reserved.
    </footer>

    <script>
      var token = localStorage.getItem('token');
      var base_url = '<?php echo base_url(); ?>';

      $(document).ready(function () {
        $('.sidebar-menu').tree();
        $(".se-pre-con").fadeOut("slow");
        if(token == "undefined" || token == null) {
          window.location.href = base_url;
          clearsession();
        } else {
          var data_token   = JSON.parse(atob(token.split('.')[1]));
          var exp_token = data_token.exp;
          if(exp_token < Date.now() / 1000){
            window.location.href = base_url;
            clearsession();
          } else {
            $('#name-user, #name-user1').html(data_token.name);
            $('#name-user2').html(data_token.name+' <br/> '+data_token.role);
            if(data_token.role != "ADMIN"){
              $('#user, #version').css('display', 'none');
            }
          }
        }
      });

      $('#btn-logout').on('click', function(){
        swal({
          title: "Apakah Yakin Ingin Keluar ?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          cancelButtonColor: "Batal",
          confirmButtonText: "Ya, Keluar",
          closeOnCancel: true,
        }, function (isConfirm) {
          if(isConfirm){
            clearsession();
            window.location.href = base_url;
          }
        });
      });

      function clearsession(){
        localStorage.removeItem('token');
        localStorage.clear();
      }
    </script>
  </body>
  </html>
