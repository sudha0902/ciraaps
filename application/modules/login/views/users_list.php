<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html class="fixed">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>User Management</title>
	<meta name="keywords" content="" />
	<meta name="description" content="RAAPS"/>
	<meta name="author" content=""/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0,
	      maximum-scale=1.0, user-scalable=no"/>

	<link rel="stylesheet" href="assets/stylesheets/fonts.css" type="text/css">
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="stylesheet" href="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="assets/vendor/bootstrap-table/bootstrap-table.min.css" />

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/stylesheets/theme.css" />
	<link rel="stylesheet" href="assets/stylesheets/theme-custom.css" />
	<link rel="stylesheet" href="assets/vendor/pnotify/pnotify.custom.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="assets/stylesheets/default.css" />

	<!-- Head Libs -->
	<script src="assets/vendor/modernizr/modernizr.js"></script>
	
</head>
<body>
	<section class="panel panel-featured panel-featured-primary">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
			</div>
		   <h2 class='panel-title'>User Listing</h2>
		</header>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="mb-md"></div>
				</div>
			</div>

			<table id="userList"
				class="table table-striped mb-none input-sm table-hover"
				data-sort-name="location" "role" "name"
				data-pagination = true
				data-page-size = 10
				data-page-number = 1>
				<thead>
					<tr>
						<th data-field="uuid" data-visible="false"></th>
						<th data-field="client" data-visible="false"></th>
						<th data-field="clientName" data-visible="false"></th>
						<th data-field="clientLoc" data-visible = "false"></th>
						<th data-sortable="true" data-field="name">Name</th>
						<th data-sortable="true" data-field="username">Username</th>
						<th data-sortable="true" data-field="role">Role</th>
						<th data-sortable="true" data-field="location">Location</th>
						<th data-sortable="true" data-field="status">Status</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					foreach ($qresult->result() as $row){
						$html= "<tr>
								<td> ".$row->ua_uuid." </td>".
                        "<td>". $row->ClientID. "</td>".
            //            "<td>". $row->CompanyName." </td>".
                        "<td>". $row->clientCode. "</td>".
				//				"<td>". $row->FirstName." ". $row->LastName."</td>".
                        "<td>". $row->Username. "</td>".
								"<td>". $row->Role ."</td>".
								"<td>". $row->Location. "</td>".
                        "<td>". $row->UserStatus. "</td>
								</tr>";
						echo $html;
		         }
				?>
				</tbody>
			</table>
		</div>
	</section>

