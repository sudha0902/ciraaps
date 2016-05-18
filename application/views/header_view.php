<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html class="fixed">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Clinician Dashboard | RAAPS</title>
		<meta name="keywords" content="RAAPS" />
		<meta name="description" content="">
		<meta name="author" content="luovadesign">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<link rel="stylesheet" href="assets/stylesheets/fonts.css"  rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="assets/vendor/morris/morris.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-table/bootstrap-table.min.css" />
		<!-- Main CSS -->
		<link rel="stylesheet" href="assets/stylesheets/default.css" />
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">
		 <link rel="stylesheet" href="assets/stylesheets/main.css"> 
		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
        <script>
        var d = <?php echo json_encode($_SESSION); ?>;
        console.dir(d);
        </script>
	</head>
<body>
<section class="body">		
<!-- start: header -->

<header class="header">
	<div class="logo-container">
		<a href="#" class="logo">
		<img src="assets/images/P4C_logo.gif" height="60" 
			alt="Possibilities for Change Logo" />
		</a>
		<div class="visible-xs toggle-sidebar-left" 
			  data-toggle-class="sidebar-left-opened" 
			  data-target="html" data-fire-event="sidebar-left-opened">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>
	<!-- start: search & user box -->
	<div class="header-right">
		<span class="separator"></span>
		<div id="userbox" class="userbox">
			<a href="" data-toggle="dropdown">
				<div class="profile-info"
				data-lock-name="<?PHP echo $_SESSION['MM_Username'];?>"
				data-lock-email="<?PHP echo $_SESSION['MM_UserEmail'];?>">
				<span class="name"><?PHP echo $_SESSION['MM_FirstName'];?> 
				     <?php echo $_SESSION['MM_LastName']; ?>
				</span>
				<span class="role"><?PHP echo $_SESSION['MM_Userrole']; ?></span>
				</div>
				<i class="fa custom-caret"></i>
			</a>
			<div class="dropdown-menu">
				<ul class="list-unstyled">
					<li class="divider"></li>
					<li> <?php if ($_SESSION['MM_Userrole'] == 'Student') { ?>
						<a role="menuitem" tabindex="-1" href="ProfileStudent.php"><i
							class="fa fa-user"></i> Edit Profile</a> 
						<?php }  else { ?>
						<a role="menuitem" tabindex="-1" href="ProfileUser.php"><i
							class="fa fa-user"></i> Edit Profile</a> 
						<?php } ?>
					</li>
					<li>
						<!--<a role="menuitem" tabindex="-1" href="#" 
					    data-lock-screen="true">
					    <i class="fa fa-file-archive-o"></i> Launch Survey</a> -->
					</li>
					<li>
						<a role="menuitem" tabindex="-1" href="#" 
						data-lock-screen="true">
						<i	class="fa fa-key"></i> Lock Screen</a>
					</li>
					<li>
						<a role="menuitem" tabindex="-1" href="logout.php">
						<i	class="fa fa-power-off"></i> Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
<!-- end: search & user box -->
</header>
</section>
</body>

<!-- end: header -->
