<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nova 3 :: Users</title>
		
		<link rel="stylesheet" href="../nova/app/views/design/style.css">
		<link rel="stylesheet" href="admin2.css">
		
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<script type="text/javascript" src="../nova/modules/assets/js/jquery.js"></script>
		<script type="text/javascript">
			var delay = (function(){
				var timer = 0;
				return function(callback, ms){
					clearTimeout (timer);
					timer = setTimeout(callback, ms);
				};
			})();
			
			$(function(){
				var wait = 600;
				
				$("#sidebar a").mousedown(function(e){
					var that = $(this);
					var sec = $(this).attr('rel');
					var relative = this.offsetTop + 20;
					
					// if a popup is visible when the sidebar is clicked, hide it
					if ($('#subnav-popup').is(':visible')) {
						$('#subnav-popup').fadeOut('fast');
						return;
					}
					
					$(this).data("wait", {
						"leavepage": true,
						"todo": setTimeout(function(){
							that.data("wait").leavepage = false;
							
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
					}, wait)});
					
					return false;
				}).click(function(){
					clearTimeout($(this).data("wait").todo);
					return $(this).data("wait").leavepage;
				});
				
				$('#section-nav-trigger').click(function(){
					var visible = $('#section-nav').is(':visible');
					
					if (visible)
						$('#section-nav').fadeOut('fast');
					else {
						$.ajax({
							type: "POST",
							url: "http://localhost/nova/mockups/admin-menu.php",
							data: {section: 'user'},
							dataType: 'html',
							success: function(data){
								$('#section-nav').html(data).fadeIn('fast');
							}
						});
					}
				});
			});
			
			$(document).ready(function(){
				$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
				
				$('[rel=change_user_view]').click(function(){
					var view = $(this).attr('id');
					
					if (view == 'show_all')
					{
						$('#actives').fadeOut('fast', function(){
							$('#all').fadeIn('fast');
						});
					}
					else
					{
						$('#all').fadeOut('fast', function(){
							$('#actives').fadeIn('fast');
						});
					}
					
					return false;
				});
				
				$("#users").keyup(function(){
					delay(function(){
						$.ajax({
							beforeSend: function(){
								$('#no-results').hide();
								$('#results').hide();
								
								$('#results-name').hide();
								$('#results-name ul').empty();
								
								$('#results-email').hide();
								$('#results-email ul').empty();
								
								$('#results-characters').hide();
								$('#results-characters ul').empty();
								
								$('.search-indicator').show();
							},
							url: 'search.php',
							type: 'GET',
							dataType: 'json',
							data: { query: $('#users').val(), type: 'results' },
							success: function(data){
								$('.search-indicator').hide();
								
								if ( ! $.isEmptyObject(data))
								{
									if ( ! $.isEmptyObject(data.name))
									{
										$.each(data.name, function(key, value){
											$('#results-name ul').append('<li>' + value.name + '</li>');
										});
										
										$('#results-name').show();
									}
									
									if ( ! $.isEmptyObject(data.email))
									{
										$.each(data.email, function(key, value){
											$('#results-email ul').append('<li>' + value.name + ' (' + value.email + ')' + '</li>');
										});
										
										$('#results-email').show();
									}
									
									if ( ! $.isEmptyObject(data.characters))
									{
										$.each(data.characters, function(key, value){
											$('#results-characters ul').append('<li>' + value.name + ' (' + value.fname + ' ' + value.lname + ')' + '</li>');
										});
										
										$('#results-characters').show();
									}
									
									$('#results').show();
								}
								else
								{
									$('#no-results').show();
								}
							}
						});
					}, 500);
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
				<div id="sidebar">
					<ul>
						<li><a href="#" rel="admin"><span class="navicn navicn-admin"></span>main</a></li>
						<li><a href="#" rel="write"><span class="navicn navicn-write"></span>write</a></li>
						<li><a href="#" rel="messages"><span class="navicn navicn-messages"></span>messages</a></li>
						<li><a href="#" rel="site"><span class="navicn navicn-site"></span>site</a></li>
						<li><a href="#" rel="manage"><span class="navicn navicn-manage"></span>manage</a></li>
						<li><a href="#" rel="characters"><span class="navicn navicn-characters"></span>characters</a></li>
						<li><a href="#" rel="user" class="active"><span class="navicn navicn-users"></span>users</a></li>
						<li><a href="#" rel="report"><span class="navicn navicn-reports"></span>reports</a></li>
					</ul>
				</div>
				
				<div id="subnav-popup">
					<div id="subnav-popup-arrow"></div>
					<div id="subnav-popup-content"></div>
				</div>
				
				<div id="content">
					<h1 class="page-head">
						<div id="section-nav-trigger"><div class="arrow"></div>Users</div>
						<div id="section-nav"></div>
						
						User Management
					</h1>
					
					<div class="inner">
						<div class="callout">
							<h2 class="page-subhead">Add User</h2>
							
							<p>You can add a new user to the system by entering their name and email address and clicking submit. During creation, a password will be generated for the user and emailed to them along with the rest of their information.</p>
							
							<table class="tableAuto">
								<tbody>
									<tr>
										<td><kbd>Name</kbd></td>
										<td><kbd>Email Address</kbd></td>
										<td></td>
									</tr>
									<tr>
										<td><input type="text" name="name" placeholder="Name"></td>
										<td><input type="email" name="email" placeholder="Email Address"></td>
										<td><button class="btn-main">Submit</button></td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div class="callout">
							<h2 class="page-subhead">Add Character to User Account</h2>
							
							<p>You can add characters to a user's account by entering the user name or email address and entering the name of the character. During creation, the user will be emailed to notify them of the new character associated with their account.</p>
							
							<table class="tableAuto">
								<tbody>
									<tr>
										<td><kbd>User Name</kbd></td>
										<td><kbd>Character Name</kbd></td>
										<td></td>
									</tr>
									<tr>
										<td><input type="text" name="name" placeholder="User name"></td>
										<td><input type="text" name="email" placeholder="Charcter name"></td>
										<td><button class="btn-main">Submit</button></td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div id="actives">
							<p><em>Didn't find the user you were looking for? You can <a href="#" rel="change_user_view" id="show_all">find</a> any user in the system instead.</em></p>
							
							<table class="zebra">
								<tbody>
									<tr class="height-40">
										<td>First Last</td>
										<td>first.last@example.com</td>
										<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
									</tr>
									<tr class="height-40">
										<td>First Last</td>
										<td>first.last@example.com</td>
										<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
									</tr>
									<tr class="height-40">
										<td>First Last</td>
										<td>first.last@example.com</td>
										<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
									</tr>
									<tr class="height-40">
										<td>First Last</td>
										<td>first.last@example.com</td>
										<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
									</tr>
									<tr class="height-40">
										<td>First Last</td>
										<td>first.last@example.com</td>
										<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
									</tr>
									<tr class="height-40">
										<td>First Last</td>
										<td>first.last@example.com</td>
										<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
									</tr>
									<tr class="height-40">
										<td>First Last</td>
										<td>first.last@example.com</td>
										<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
									</tr>
									<tr class="height-40">
										<td>First Last</td>
										<td>first.last@example.com</td>
										<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
									</tr>
									<tr class="height-40">
										<td>First Last</td>
										<td>first.last@example.com</td>
										<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
									</tr>
									<tr class="height-40">
										<td>First Last</td>
										<td>first.last@example.com</td>
										<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div id="all" class="hidden">
							<p><em>Done searching? Head <a href="#" rel="change_user_view" id="show_actives">back</a> to the list of active users.</em></p>
							
							<p>Find any user by typing their name, email address or any characters linked to their account.</p>
							
							<p>
								<input type="text" id="users" placeholder="Search for users...">
								<span class="search-indicator hidden">&nbsp; <img src="images/admin/loading.gif" alt=""></span>
							</p>
							
							<div id="results" class="hidden">
								<div id="results-name" class="hidden">
									<h2 class="page-subhead">Names</h2>
									<ul></ul>
								</div>
								
								<div id="results-email" class="hidden">
									<h2 class="page-subhead">Email Addresses</h2>
									<ul></ul>
								</div>
								
								<div id="results-characters" class="hidden">
									<h2 class="page-subhead">Linked Characters</h2>
									<ul></ul>
								</div>
							</div>
							
							<div id="no-results" class="hidden">No results found</div>
						</div>
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