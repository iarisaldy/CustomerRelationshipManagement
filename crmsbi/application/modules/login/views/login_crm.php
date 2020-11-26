<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Login - Customer Relationship Management</title>

        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/pe-icon-7-stroke.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/font-material.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>assets/css/plugins/slick/slick.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/plugins/slick/slick-theme.css" rel="stylesheet">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo.png">

        <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugins/slick/slick.min.js"></script>

        <style>
            body{
                background-image: url(<?php echo base_url(); ?>assets/img/login-bg.jpeg);
                background-size:100%;
                background-repeat: no-repeat;
                overflow-y: hidden;
                overflow-x: hidden;
            }
            .ibox-content p {
                font-size: 14px;
                text-align: justify;
                text-justify: inter-word;
                line-height: 200%;
                margin-top: 2%;
            }
            h1,h2,h3,h4,h5{
                font-weight: bold;
            }
            .gmb-scm{
                margin-top : -1%;
            }
            .bayang{
                box-shadow: 10px 10px 10px #888888;
            }
        </style>
    </head>

    <body class="white-bg">
        <div class="animated fadeInDown">
            <div class="row" style="padding-top: 5%;">
                <div class="col-md-12">   
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <!-- INI UNtuk CRM LOGIN -->
                        <div class="login-wrap" style="padding: 0 30px;">
                            <div class="background">
                                <div class="login-html" style="padding-top:90">
                                    <div class="card">
                                        <div class="body">
                                            <div class="logo" style="margin: -20px; background-color: #234B8D;     padding: 30px 20px; text-align: center;"> <img src="<?php echo base_url(); ?>assets/img/logo-crmn.png" style="width:70%;">
                                            </div>
                                            <div class="sub-crm" style="margin-left: -20px; margin-right: -20px; text-align: center; font-size: 12px; margin-bottom: 30px;    background-color: #fd0a23;"> <h3 style="color: #ffffff; font-weight: 200; margin-top: 4px; margin-bottom: 4px; font-size: 16px; letter-spacing: 2px; padding: 6px 0;">CRM DASHBOARD</h3> </div>
                                            <?php if($message == "error"){ echo '<center><h5 style="color:red;">Username & Password Salah.</h5></center>'; } ?>
                                            
                                            <form action="<?php echo base_url(); ?>login/action" method="post" accept-charset="UTF-8" role="form">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="user" name="username" placeholder="Username" required autofocus>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">lock</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="password" smi="input" class="form-control" id="pass" name="password" placeholder="Password" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-3"></div>
                                                    <div class="col-xs-6">
                                                        <button id="login" class="btn btn-block btn-primary waves-effect" type="submit">SIGN IN</button>
                                                    </div>
                                                    <div class="col-xs-3" id="config"></div>
                                                </div>
                                            </form>
                                            <div id="msg" style="text-align: center;color: #fe0c21;font-size: 15px;font-weight: normal;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- INI UNtuk CRM LOGIN -->
                                         
                    </div>
                </div>
            </div>
        </div>
        <!-- <script>
            $(document).ready(function () {
                $('.slick_demo_1').slick({
                    autoplay: true,
                    autoplaySpeed: 3000,
                    dots: true,
                    infinite: true,
                    speed: 500,
                    fade: true,
                    cssEase: 'linear'
                });
            });

        </script> -->
    </body>
</html>
