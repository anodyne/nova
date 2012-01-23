<?php

$page = (isset($_GET['page'])) ? $_GET['page'] : 'default';

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Admin</title>
		
		<link rel="stylesheet" href="../assets/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
		
		<script type="text/javascript" src="../../nova/modules/assets/js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-transition.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-tab.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-dropdown.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-twipsy.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('[rel*="twipsy"]').twipsy();
			});
		</script>
	</head>
	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<a href="?page=default" class="brand">Control Panel</a>
					
					<ul class="nav">
						<li><a href="?page=write">Write</a></li>
						<li><a href="?page=manage">Manage</a></li>
						<li><a href="?page=characters">Characters &amp; Users</a></li>
						<li><a href="?page=reports">Report Center</a></li>
					</ul>
					
					<ul class="nav secondary-nav">
						<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label warning">5</span> DVS</a>
							<ul class="dropdown-menu">
								<li><a href="#">My Account</a></li>
								<li><a href="#">Preferences</a></li>
								<li><a href="#">My Characters</a></li>
								<li class="divider"></li>
								<li><a href="#"><span class="label important">2</span> Messages</a></li>
								<li><a href="#"><span class="label warning">3</span> Writing</a></li>
								<li class="divider"></li>
								<li><a href="#">Request LOA</a></li>
								<li><a href="#">Nominate for Award</a></li>
								<li class="divider"></li>
								<li><a href="#">Sign Off</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="content"><?php include 'page.'.$page.'.php';?></div>
		</div>
	</body>
</html>