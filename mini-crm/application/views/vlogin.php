<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
	<title>Survey Validation Apps</title>
	<link rel="icon" href="assets/images/icon.png" type="image/x-icon">
	<script src="assets/js/jquery.min.js"></script>
	<!-- Custom Theme files -->
	<link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all"/>
	<link rel="stylesheet" type="text/css" href="assets/css/plugins/sweetalert/sweetalert.css">

	<script type="text/javascript" src="assets/js/plugins/sweetalert/sweetalert.min.js"></script>
	<!-- for-mobile-apps -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<!-- //for-mobile-apps -->
	<!--Google Fonts-->
	<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>

	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
	<style type="text/css">
	::placeholder{
		color:white;
	}

	.no-js #loader { display: none;  }
	.js #loader { display: block; position: absolute; left: 100px; top: 0; }
	.se-pre-con {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url(assets/images/Preloader_8.gif) center no-repeat #fff;
	}
</style>
</head>
<body>
	<div class="se-pre-con"></div>
	<!--header start here-->
	<div class="header">
		<div class="header-main">
			<h1>Survey Validation Apps</h1>
			<div class="header-bottom">
				<div class="header-right w3agile">	
					<div class="header-left-bottom agileinfo">
						<form id="login">
							<input type="text" id="username" name="name" placeholder="Your Username" />
							<input type="password" id="password" name="password" placeholder="Your Password" />
							<input type="submit" value="LOGIN">
						</form>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--header end here-->
	<div class="copyright">
		<p>PT. Sinergi Informatika Semen Indonesia <br/> © <?php echo date('Y'); ?> </p>
	</div>
	<!--footer end here-->
	<script type="text/javascript">
		var base_url = '<?php echo base_url(); ?>';
		$('document').ready(function(){
			$(".se-pre-con").fadeOut("slow");
		});

		$('#login').on('submit', function(e){
			e.preventDefault();
			$.ajax({
				url: 'api/v1/auth',
				type: 'POST',
				header : {
					'Content-Type' : 'application/x-www-form-urlencoded',
				},
				data : {
					'username' : $('#username').val(),
					'password' : $('#password').val()
				},
				dataType: 'JSON',
				success: function(data){
					if(data.status == "error"){
						swal("Perhatian !", data.message, "error");
					} else {
						localStorage.setItem('token', data.data['token']);
						window.location.href = base_url+'home';
					}
				}
			});
		});
	</script>
</body>
</html>