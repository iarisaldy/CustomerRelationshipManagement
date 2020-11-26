<html>
        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?php echo $title; ?> | Customer Relationship Management</title>
        <!-- Favicon-->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo.png">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <!-- Bootstrap Core Css -->
        <link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
        <!-- JQuery DataTable Css -->
        <link href="<?php echo base_url();?>assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
        <!-- Waves Effect Css -->
        <link href="<?php echo base_url();?>assets/plugins/node-waves/waves.css" rel="stylesheet" />
        <!-- Animation Css -->
        <link href="<?php echo base_url();?>assets/plugins/animate-css/animate.css" rel="stylesheet" />
        <!-- Font Awesome -->
        <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <!-- Bootstrap Select Css -->
        <link href="<?php echo base_url();?>assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
         <!-- FusionChart -->
        <script type="text/javascript" src="<?php echo base_url();?>assets/fusioncharts-bod/fusioncharts.js"></script>
       
        <script type="text/javascript" src="<?php echo base_url();?>assets/fusioncharts-bod/fusioncharts.maps.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/fusioncharts/js/maps/fusioncharts.indonesia.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/fusioncharts-bod/themes/fusioncharts.theme.fint.js"></script>
        <!-- <script type="text/javascript" src="<?php echo base_url();?>assets/fusioncharts-bod/themes/fusioncharts.theme.fusion.js"></script> -->


        <!-- Jquery Core Js -->
        <script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
        
        <!-- Bootstrap Material Datetime Picker Css -->
        <link href="<?php echo base_url();?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
        <!-- Bootstrap Material Datetime Picker Plugin Js -->
        <script src="<?php echo base_url();?>assets/plugins/momentjs/moment.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
        
        <!-- Custom Css -->
        <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
        <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
        <link href="<?php echo base_url();?>assets/css/themes/all-themes.css" rel="stylesheet" />
        
        <!-- Bootstrap Core Js -->
        <script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.js"></script>
        <!-- ChartJs -->
        <script src="<?php echo base_url();?>assets/plugins/chartjs/Chart.bundle.js"></script>
        <!-- Select2 -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <link href="<?php echo base_url();?>assets/css/dataTables/datatables.min.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/jquery_ui/jquery-ui.min.css" rel="stylesheet">
        <script src="<?php echo base_url();?>assets/css/jquery_ui/jquery-ui.min.js"></script>
       
        <!-- Bootstrap Material Datetime Picker Css -->
        <link href="<?php echo base_url();?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
        <!-- Bootstrap Material Datetime Picker Plugin Js -->
        <script src="<?php echo base_url();?>assets/plugins/momentjs/moment.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
        
        <!-- Slimscroll Plugin Js -->
        <script src="<?php echo base_url();?>assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
        <!-- Datepicker Css -->
        <link href="<?php echo base_url();?>assets/css/bootstrap-datepicker.css" rel="stylesheet" />
        <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"/></script>

        <!-- slick js -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/slick/slick-theme.css"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/slick/slick.min.js"></script>
        
        <!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/> -->
        <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script> -->

    </head>
<body class="theme-cyan">
    <?php
        $idLogin = $this->session->userdata("is_login");
        if($idLogin != "1"){
            $this->session->sess_destroy();
            redirect(base_url());
        }
    ?>

