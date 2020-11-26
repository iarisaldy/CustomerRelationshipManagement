<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Login - Customer Relationship Management</title>

        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/pe-icon-7-stroke.css" rel="stylesheet">

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
                /*background-repeat: no-repeat;*/
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
                        <div class="panel panel-default text-center animated fadeInLeft bayang">
                            <div class="panel-body">
                                <div class="row">
                                    <center>
                                        <img class="gmb-scm" width="100%" src="<?php echo base_url(); ?>assets/img/logos/header-logo-scm.png">
                                    </center>
                                </div><br/><br/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <img style="margin-bottom: 12px;" width="50%" src="<?php echo base_url(); ?>assets/img/smig_logo.jpg">
                                            <form action="<?php echo base_url(); ?>login/action" method="post" accept-charset="UTF-8" role="form">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                            <input class="form-control" placeholder="username" name="username" type="text" required="">
                                                        </div>                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                            <input class="form-control" placeholder="password" name="password" type="password" required="">
                                                        </div>                                        
                                                    </div>
                                                    <input class="btn btn-primary block full-width m-b" type="submit" style="font-weight: bold;" value="LOGIN">
                                                </fieldset>
                                            </form>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <p>Silahkan login dengan username & password email (tanpa @semenindonesia.com)</p>
                                    <span style="color:#d32132"><?php echo isset($message) ? $message : ''; ?></span>
                                </div>
                            </div>
                        </div>                 
                    </div>
                </div>
            </div>
        </div>
        <script>
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

        </script>
    </body>
</html>
