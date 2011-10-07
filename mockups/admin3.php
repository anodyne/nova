<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nova 3 :: Admin Control Panel</title>
		
		<link rel="stylesheet" href="../nova/app/views/design/style.css">
		<link rel="stylesheet" href="assets/bootstrap.min.css">
		<link rel="stylesheet" href="admin3.css">
		
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<script type="text/javascript" src="../nova/modules/assets/js/jquery.js"></script>
		<script type="text/javascript">
			$(function(){
				var menuDelay = 600;
				
				$("#sidebar a").mousedown(function(e){
					var that = $(this);
					var sec = $(this).attr('rel');
					var relative = this.offsetTop + 20;
					
					// if a popup is visible when the sidebar is clicked, hide it
					if ($('#subnav-popup').is(':visible')) {
						$('#subnav-popup').fadeOut('fast');
						return;
					}
					
					$(this).data("menuDelay", {
						"leavepage": true,
						"todo": setTimeout(function(){
							that.data("menuDelay").leavepage = false;
							
							// hide everything first
							$('#subnav-popup').fadeOut('fast');
							
							$.ajax({
								type: "POST",
								url: "http://localhost/nova/mockups/admin-menu.php",
								data: {section: sec},
								dataType: 'html',
								success: function(data){
									$('#subnav-popup-content').html(data);
									$('#subnav-popup').css('top', relative).fadeIn('fast');
								}
							});
					}, menuDelay)});
					
					return false;
				}).click(function(){
					clearTimeout($(this).data("menuDelay").todo);
					return $(this).data("menuDelay").leavepage;
				});
				
				$('#section-nav-trigger').click(function(){
					var visible = $('#section-nav').is(':visible');
					
					if (visible)
						$('#section-nav').fadeOut('fast');
					else {
						$.ajax({
							type: "POST",
							url: "http://localhost/nova/mockups/admin-menu.php",
							data: {section: 'write'},
							dataType: 'html',
							success: function(data){
								$('#section-nav').html(data).fadeIn('fast');
							}
						});
					}
				});
			});
			
			// if the escape key is pressed, close the menu
			$(document).keyup(function(event){
				if (event.keyCode == 27) {
					$('#subnav-popup').fadeOut('fast');
					$('#section-nav').fadeOut('fast');
				}
			});
		</script>
	</head>
	<body>
		<header>
			<div class="wrapper">
				<img src="../nova/app/views/design/images/main/nova.png" class="float-right">
				<h1>Name Goes Here</h1>
			</div>
		</header>
		
		<div class="wrapper">
			<section>
				<div id="navbar">
					<ul>
						<li><a href="#" rel="admin"><span class="navicn navicn-admin"></span>main</a></li>
						<li><a href="#" rel="write" class="active"><span class="navicn navicn-write"></span>write</a></li>
						<li><a href="#" rel="messages"><span class="navicn navicn-messages"></span>messages</a></li>
						<li><a href="#" rel="site"><span class="navicn navicn-site"></span>site</a></li>
						<li><a href="#" rel="manage"><span class="navicn navicn-manage"></span>manage</a></li>
						<li><a href="#" rel="characters"><span class="navicn navicn-characters"></span>characters</a></li>
						<li><a href="#" rel="user"><span class="navicn navicn-users"></span>users</a></li>
						<li><a href="#" rel="report"><span class="navicn navicn-reports"></span>reports</a></li>
					</ul>
				</div>
				
				<div id="subnav-popup">
					<div id="subnav-popup-arrow"></div>
					<div id="subnav-popup-content"></div>
				</div>
				
				<div id="content">
					<h1 class="page-head">
						<div id="section-nav-trigger"><div class="arrow"></div>Writing Control Panel</div>
						<div id="section-nav"></div>
						
						Writing Control Panel
					</h1>
					
					<div class="inner">
						Content
					</div>
				</div>
			</section>
			
			<footer>
				<div class="footer-extra"></div>
				
				<div class="footer-content">
					<div class="float-right">&copy; <?php echo date('Y');?> <a href="http://www.anodyne-productions.com" target="_blank">Anodyne Productions</a></div>
					Powered by Nova | <a href="#">Site Credits</a>
				</div>
			</footer>
		</div>
	</body>
</html>