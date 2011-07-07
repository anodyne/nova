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
									$('#subnav-popup').html(data).css('top', relative).fadeIn('fast');
								}
							});
					}, delay)});
					
					return false;
				}).click(function(){
					clearTimeout($(this).data("delay").todo);
					return $(this).data("delay").leavepage;
				});
			});
			
			// if the escape key is pressed, close the menu
			$(document).keyup(function(event){
				if (event.keyCode == 27) {
					$('#subnav-popup').fadeOut('fast');
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
						<li><a href="#" rel="admin" class="active"><img src="images/admin/nav-main.png"><br>main</a></li>
						<li><a href="#" rel="write"><img src="images/admin/nav-write.png"><br>write</a></li>
						<li><a href="#" rel="messages"><img src="images/admin/nav-messages.png"><br>messages</a></li>
						<li><a href="#" rel="site"><img src="images/admin/nav-site.png"><br>site</a></li>
						<li><a href="#" rel="manage"><img src="images/admin/nav-manage.png"><br>manage</a></li>
						<li><a href="#" rel="characters"><img src="images/admin/nav-characters.png"><br>characters</a></li>
						<li><a href="#" rel="user"><img src="images/admin/nav-users.png"><br>users</a></li>
						<li><a href="#" rel="report"><img src="images/admin/nav-reports.png"><br>reports</a></li>
					</ul>
				</div>
				
				<div id="subnav-popup"></div>
				
				<div id="content">
					<div class="inner">
						<h1>Control Panel</h1>
					</div>
				</div>
			</section>
		</div>
		
		<footer>Powered by Nova</footer>
	</body>
</html>