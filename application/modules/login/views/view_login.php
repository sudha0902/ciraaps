<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html class="fixed">
<head>
	<meta charset="UTF-8">
	<title>RAAPS Login</title>
	<meta name="keywords"
	content="RAAPS, P4C, Possibilities for Change, BIT, Behavioral Intervention Technology, Teens, Risk" />
	<meta name="description" content="P4C Login">
	<meta name="author" content="luovadesign">
	<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />


	<link rel="stylesheet" href="/assets/stylesheets/fonts.css"
	rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet"
	href="/assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet"
	href="/assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet"
	href="/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="stylesheet" href="/assets/vendor/pnotify/pnotify.custom.css" />
	<!-- Main CSS -->
	<link rel="stylesheet" href="/assets/stylesheets/theme.css" />
	<link rel="stylesheet" href="/assets/stylesheets/theme-custom.css" />

	<!-- Head Libs -->
	<script src="/assets/vendor/modernizr/modernizr.js"></script>
</head>
<body>
	<!-- start: page -->
	<section class="body-sign">
		<div class="center-sign">
			<a href="/" class="logo pull-left"> <img
				src="/assets/images/P4C_logo.gif" height="70" alt="P4C" />
			</a>

			<div class="panel panel-sign">
				<div class="panel-title-sign mt-xl text-right">
					<h2 class="title text-uppercase text-bold m-none">
						<i class="fa fa-user mr-xs"></i> Sign In
					</h2>
				</div>
				<div class="panel-body">
					<form id="login_form" method = "post" action="/login">
						<div class="form-group mb-lg">
							<div class="clearfix">
								<label>Username</label>
								<?php if($login_setup['Username_Retrieval']){?>
								  <a	href="/login/forgotUserName" class="pull-right">Forgot UserName?</a>
								<?php }?>
							</div>
							<div class="input-group input-group-icon">
								<input id="username" name="username" type="text"
									class="form-control input-lg" tabindex=1 autofocus
									<?php if (isset($username))
									{ echo "value = '$username'";}?> />
								<span	class="input-group-addon">
									<span class="icon icon-lg"> 
										<i class="fa fa-user"></i>
									</span>
								</span>
							</div>
						</div>

						<div class="form-group mb-lg">
							<div class="clearfix">
								<label class="pull-left">Password</label> 
								<?php if($login_setup['Pwd_Retrieval']){?>
								  <a	href="/login/forgotPwd" class="pull-right">Forgot Password?</a>
								<?php }?>
							</div>
							<div class="input-group input-group-icon">
								<input id="pwd" name="pwd" type="password"
									class="form-control input-lg" tabindex=2
									<?php if (isset($pwd))
									{ echo "value = '$pwd'";}?> /> 
								<span	class="input-group-addon">
								   <span class="icon icon-lg"> 
										<i class="fa fa-lock"></i>
								   </span>
								</span>
							</div>
						</div>

						<div class=""form-group mb-lg"">
							<div class="col-sm-8">
							</div>
							
							<div id="signIn" class="col-sm-4 text-right">
								<button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
								<button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">
								Sign In</button>
							</div>
							<?php if ($login_setup['Sign_Up']){?>
							<div class="clearfix">
								<a	href="/login/register" class="pull-left">Register</a>
							</div>
							<?php }?>
						</div>

						<div class="row ">
							<div class="col-sm-12 ">
							  	<label id="msg" class="error alert-danger"></label>
								<div class="error alert-danger">
							     <p id="errmsg" class ="alert-danger text-center "> 
								    		<?php if (isset($errmsg)) echo $errmsg;?>
								    </p>
								</div>
							</div>
						</div>

					</form>
				</div>
			</div>

			<p class="text-center text-muted mt-md mb-sm">&copy; Copyright 2014.
				Possibilities for Change All Rights Reserved.</p>
			<p class="text-center text-muted mt-md mb-md">powered by luovadesign</p>
		</div>
	</section>
	<!-- end: page -->

	<!-- Vendor -->
	<script src="/assets/vendor/jquery/jquery.js"></script>
	<script
		src="/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="/assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="/assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script
		src="/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="/assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>


	<!-- Theme Base, Components and Settings -->
	<script src="/assets/javascripts/theme.js"></script>

	<!-- Theme Custom -->
	<script src="/assets/javascripts/theme.custom.js"></script>

	<!-- Theme Initialization Files -->
	<script src="/assets/javascripts/theme.init.js"></script>
   <script>

   function sleepFor( sleepDuration ){
	    var now = new Date().getTime();
	    while(new Date().getTime() < now + sleepDuration){ /* do nothing */ } 
	} 
	$(document).ready(function()	{
		if ($('#errmsg').text() !== ""){
			sleepFor(3000);
			$('#errmsg').text("");
		}
		
	})
   </script>
</body>
</html>