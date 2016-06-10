<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html class="fixed">
<head>
<meta charset="UTF-8">
<title>RAAPS Login</title>
<meta name="keywords" content="RAAPS, P4C, Possibilities for Change, BIT, Behavioral Intervention Technology, Teens, Risk" />
<meta name="description" content="P4C Login">
<meta name="author" content="luovadesign">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<link rel="stylesheet" href="/assets/stylesheets/fonts.css"  rel="stylesheet" type="text/css">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
		<script>
		var returnPage = <?php echo json_encode($_SERVER['HTTP_REFERER']); ?>;
            console.dir(returnPage);
        </script>
	</head> 
	<body>
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				<a href="/" class="logo pull-left">
					<img src="/assets/images/P4C_logo.gif" height="70" alt="P4C" />
				</a>

				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none">
                        <i class="fa fa-refresh mr-xs"></i> Update Security Question</h2>
					</div>
<!-- Step One -->                    
    <form id="pwSQuestion" class="panel-body" method ="post" action = "/login/setSecurityQuestion/<?php echo $uuid?>">
    
    <?php for ($i = 1; $i <= $noOfQuestions; $i++)
    { 
    ?>
    	 <div class="form-group mb-lg">
	    <label>Select Question</label>
	    <!--  <div class="input-group input-group-icon">-->
	    <select id="SelectQuestion<?php echo $i;?>" name="question<?php echo $i;?>" class="form-control input-md" tabindex=1 autofocus>
			 <?php
		    foreach($secQuestions as $question){
		       /* if($userQ === $question['SecQID']){
		            echo "<option value='". $question['SecQID'] ."' selected>". $question['SecQuestion'] ."</option>";
		        } else*/ {
		            echo "<option value='". $question->ID ."'>". $question->sec_question ."</option>";
		        }
		    }
			 ?>    
    	 </select>
   	 <!--  </div> -->
    	 
	    
	    <label>Your Answer</label>
	   <!--  <div class="input-group input-group-icon">-->
	    <input id="InputAnswer<?php echo $i;?>" name="answer<?php echo $i;?>" class="form-control input-md" tabindex=2 />
	    
	   <!-- </div>-->
	    </div>
	    </br>
	 <?php 
    }
    ?>
    <div class="row">
    <div class="col-sm-8">
    </div>
    <div id="bttnQuestion" class="col-sm-4 text-right">
    <button type="submit" class="btn btn-primary hidden-xs">Update</button>
    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Update</button>
    </div>
    </div>

    </form>
           
				</div>

				<p class="text-center text-muted mt-md mb-sm">&copy; Copyright 2014. Possibilities for Change All Rights Reserved.</p><p class="text-center text-muted mt-md mb-md"> powered by luovadesign</p>
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
		<script src="/assets/javascripts/classic/ApplicationSupport.js"></script>
		<script src="/assets/javascripts/classic/lostPassword.js"></script>
	</body>
</html>