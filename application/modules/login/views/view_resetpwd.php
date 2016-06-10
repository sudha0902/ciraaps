<?php
$page = 'UpdatePwd';
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

	<link rel="stylesheet" href="/assets/stylesheets/fonts.css" type="text/css">
	<link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="/assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="/assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
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
						<i class="fa fa-refresh mr-xs"></i> Update Password
					</h2>
				</div>
				<!-- Step One -->
				<form id="pwResetUser" class="panel-body">

					<form id="pwUpdate" class="panel-body hidden">
						<div class="alert alert-info">
							New passwords must begin with a letter and must contain:
							<ul>
								<li>At least <b>7</b> characters</i></li>
								<li>At least <b>1</b> number <i>[0-9]</i></li>
								<li>At least <b>1</b> uppercase <i>[A-Z]</i></li>
								<li>At least <b>1</b> lowercase <i>[a-z]</i></li>
								<li>At least <b>1</b> non-alphanumeric character <i>[!@$#%&_]</i></li>
							</ul>
						</div>

						<div id="newpw" class="form-group mb-lg">
							<label>New Password</label>
							<div class="input-group input-group-icon">
								<input id="newpassword" type="password"
									class="form-control input-lg" tabindex=1 autofocus /> <span
									class="input-group-addon"> <span class="icon icon-lg"> <i
										class="fa fa-exclamation"></i>
								</span>
								</span>
							</div>
						</div>

						<div id="matchpw" class="form-group mb-lg">
							<label>Confirm Password</label>
							<div class="input-group input-group-icon">
								<input id="confirmpassword" type="password"
									class="form-control input-lg" tabindex=2 disabled /> <span
									class="input-group-addon"> <span class="icon icon-lg"> <i
										class="fa fa-exlamation"></i>
								</span>
								</span>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-8"></div>
							<div id="bttnUpdate" class="col-sm-4 text-right">
								<button type="submit" class="btn btn-primary hidden-xs"
									disabled="disabled">Update</button>
								<button type="submit"
									class="btn btn-primary btn-block btn-lg visible-xs mt-lg"
									disabled="disabled">Update</button>
							</div>
						</div>

					</form>
			
			</div>

			<p class="text-center text-muted mt-md mb-sm">&copy; Copyright 2014.
				Possibilities for Change All Rights Reserved.</p>
			<p class="text-center text-muted mt-md mb-md">powered by luovadesign</p>
		</div>
	</section>
	<!-- end: page -->

	<!-- Vendor -->
	<script src="/assets/vendor/jquery/jquery.js"></script>
	<script src="/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="/assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="/assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
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
	/* JS Controller for UpdatePassword.php */
	(function($){

	    var Update = {
	        pass: "",
	        update: function(newPwd){

        		   var params = {
	                "newPwd": newPwd
	                };
	            
	            var uuid = '<?php echo $uuid;?>';
	            $.ajax({
	                url: '/login/resetpwd/'+uuid,
	                type: 'POST', 
	                data: params,
	                dataType: 'json',
	                async: true,
	                success: function(data){
	                    console.dir(data);
	                    if (data.success)
	                    		window.location.assign(data.url);
	                }
	            }); 
	        
	        },
	        checkPassword: function(pass){
	            
	            var test = false,
	                hasDigit = /[0-9]/,
	                hasLC = /[a-z]/,
	                hasUC = /[A-Z]/,
	                hasSpec = /[^a-zA-Z0-9]/;
	             
	            if(pass.length < 7){ return false; }
	            
	            if(!hasDigit.test(pass)){ return false; }
	            
	            if(!hasLC.test(pass)){ return false; }
	            
	            if(!hasUC.test(pass)){ return false; }
	            
	            if(!hasSpec.test(pass)){ return false; }
	            
	            return true;
	        },
	        events: function(){
	            
	            $("#newpassword").on('keyup', function(){
	                
	                Update.pass = $(this).val();
	                
	                if(Update.checkPassword(Update.pass)){
	                    
	                    $("#newpw i").removeClass("fa-exclamation");
	                    $("#newpw i").addClass("fa-check");
	                    $("#confirmpassword").prop( "disabled", false );
	                    
	                }else{
	                
	                    $("#newpw i").removeClass("fa-check");
	                    $("#newpw i").addClass("fa-exclamation");
	                    $("#confirmpassword").prop( "disabled", true );
	                    
	                }
	                
	            });
	            
	            $("#confirmpassword").on('keyup', function(){
	                var test = $(this).val()
	                
	                if(test === Update.pass){
	                	
	                    $("#matchpw i").removeClass("fa-exclamation");
	                    $("#matchpw i").addClass("fa-check");
	                    $("#bttnUpdate button").removeAttr("disabled");
	                    
	                } else {
	                
	                    $("#matchpw i").removeClass("fa-check");
	                    $("#matchpw i").addClass("fa-exclamation");
	                    $("#bttnUpdate button").attr("disabled", "disabled");
	                    
	                }
	            });
	            
	            
	            $('#pwResetUser').on('submit', function(e){
	               e.preventDefault();
	               Update.update($("#newpassword").val());
	            });
	            
	        },
	        init: function(){
	            
	            Update.events();
	            
	        }
	    };

	//    if(location.pathname === "/login/resetpwd"){ 
	            
	        // console.log("Update.init()");   
	        Update.init(); 
	        
	    //}
	      
	})(jQuery);
	</script>
</body>
</html>