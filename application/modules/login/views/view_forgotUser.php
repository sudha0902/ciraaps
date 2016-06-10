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
<link
	href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"
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
<!-- Skin CSS -->
<link rel="stylesheet" href="/assets/stylesheets/skins/default.css" />
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
						<i class="fa fa-refresh mr-xs"></i> Reset Password
					</h2>
				</div>
				<!-- Step One -->
				<div id = "forgotUserNamePanel" class="panel-body">
					<form id="forgotUserName">
						<div class="alert alert-info">
							<p class="m-none text-weight-semibold h6">Enter your details and
								email below to begin the process.</p>
						</div>

						<div class="form-group mb-lg">
							<label>FirstName</label>
							<div class="input-group input-group-icon">
								<input id="fname" type="text" class="form-control input-lg"
									tabindex=1 required autofoxus />
								<!--  <span class="input-group-addon"> 
								<span	class="icon icon-lg"> 
								    <i class="fa fa-user"></i>
								</span>-->
								</span>
							</div>
						</div>
						<div class="form-group mb-lg">
							<label>Lastname</label>
							<div class="input-group input-group-icon">
								<input id="lname" type="text" class="form-control input-lg"
									tabindex=2 required />
								<!--  <span class="input-group-addon"> 
								<span	class="icon icon-lg"> 
								    <i class="fa fa-user"></i>
								</span>
							</span>-->
							</div>
						</div>
						<div class="form-group mb-lg">
							<label>Email</label>
							<div class="input-group input-group-icon">
								<input id="email" type="email" class="form-control input-lg"
									tabindex=3 required /> <span class="input-group-addon"> <span
									class="icon icon-lg"> <i class="fa fa-envelope"></i>
								</span>
								</span>
							</div>
						</div>
						<div id="infomsg" class="row hidden">
							<div class="col-sm-12 ">
								<div class="alert alert-info">
									<p id="message" class="m-none text-weight-semibold h6 "></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-8"></div>
							<div id="bttnBegin" class="col-sm-4 text-right">
								<button type="submit" class="btn btn-primary hidden-xs">Begin</button>
								<button type="submit"
									class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Begin</button>
							</div>
						</div>

					</form>
				</div>

				<!-- Step Two ContactAdmin Message -->
				<div id="contactadmin" class="panel-body hidden">
					<div class="alert alert-danger">
						<p id="errmessage" class="m-none text-weight-semibold h6"></p>
						<p class="m-none text-weight-semibold h6">Please contact your
							system administrator for help accessing this site.</p>
					</div>
				</div>

				<p class="text-center text-muted mt-md mb-sm">&copy; Copyright 2014.
					Possibilities for Change All Rights Reserved.</p>
				<p class="text-center text-muted mt-md mb-md">powered by luovadesign</p>
			</div>
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
	<script src="/assets/vendor/pnotify/pnotify.custom.js"></script>

	<!-- Theme Base, Components and Settings -->
	<script src="/assets/javascripts/theme.js"></script>

	<!-- Theme Custom -->
	<script src="/assets/javascripts/theme.custom.js"></script>

	<!-- Theme Initialization Files -->
	<script src="/assets/javascripts/theme.init.js"></script>
	<script>
	(function($){

		var Lost = {
	   	events: function(){

		      $("#forgotUserName").on('submit', function(e){

	         	e.preventDefault();
	            var fname = $("#fname").val();
	            var lname = $("#lname").val();
		         var email = $("#email").val();
	            var params = {'fname' : fname,
			            		  'lname' : lname,
			                    'email' : email};
	           	$.ajax({
					    url: '/login/forgotUserName', 
					    type: 'POST', 
					    data: params,
					    dataType: 'json',
					    async: true,
					    success: function(data){
					       if (data.success){
						      $("#infomsg").removeClass("hidden")
					         $("#message").html(data.message);
					       }
					       else{
						      $("#forgotUserNamePanel").hide();
						      $("#errmessage").html(data.message);
					       	$("#contactadmin").removeClass('hidden');
					       }
					    }
				    });    
	                
	    		});
	    	},
	    	init: function(){
		 		Lost.events();
	    	}
		}
		if(location.pathname === "/login/forgotUserName"){
		    Lost.init();
		}
	})(jQuery);
	</script>
</body>
</html>
