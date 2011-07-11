<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nova 3 :: Admin Control Panel</title>
		
		<link rel="stylesheet" href="admin.css">
		
		<script type="text/javascript" src="http://localhost/git/nova/nova/modules/assets/js/jquery.js"></script>
		<script type="text/javascript">
			$(function(){
				var delay = 600;
				
				$("#sidebar a").mousedown(function(e){
					var that = $(this);
					var sec = $(this).attr('rel');
					var relative = this.offsetTop + 20;
					
					// if a popup is visible when the sidebar is clicked, hide it
					if ($('#subnav-popup').is(':visible')) {
						$('#subnav-popup').fadeOut('fast');
						return;
					}
					
					$(this).data("delay", {
						"leavepage": true,
						"todo": setTimeout(function(){
							that.data("delay").leavepage = false;
							
							// hide everything first
							$('#subnav-popup').fadeOut('fast');
							
							$.ajax({
								type: "POST",
								url: "http://localhost/git/nova/mockups/admin-menu.php",
								data: {section: sec},
								dataType: 'html',
								success: function(data){
									$('#subnav-popup-content').html(data);
									$('#subnav-popup').css('top', relative).fadeIn('fast');
								}
							});
					}, delay)});
					
					return false;
				}).click(function(){
					clearTimeout($(this).data("delay").todo);
					return $(this).data("delay").leavepage;
				});
				
				$('#section-nav-trigger').click(function(){
					var visible = $('#section-nav').is(':visible');
					
					if (visible)
						$('#section-nav').fadeOut('fast');
					else {
						$.ajax({
							type: "POST",
							url: "http://localhost/git/nova/mockups/admin-menu.php",
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
		<div id="container">
			<header>Name Goes Here</header>
			
			<section>
				<div id="sidebar">
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
					<div class="inner">
						<div id="section-nav-trigger"><div class="arrow"></div>Writing Control Panel</div>
						<div id="section-nav"></div>
						
						<h1>Writing Control Panel</h1>
					</div>
				</div>
			</section>
		</div>
		
		<footer>Powered by Nova from Anodyne Productions</footer>
	</body>
</html>