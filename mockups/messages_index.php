<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nova 3 :: Messages</title>
		
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
							data: {section: 'messages'},
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
				$('ul.zebra > li:nth-child(odd)').addClass('alt');
				
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
						<li><a href="#" rel="messages" class="active"><span class="navicn navicn-messages"></span>messages</a></li>
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
						<div id="section-nav-trigger"><div class="arrow"></div>Messages</div>
						<div id="section-nav"></div>
						
						Messages
					</h1>
					
					<div class="inner">
						<p><button class="btn-main">New Message</button></p>
						
						<div class="callout">
							<h2 class="page-subhead">Compose New Message</h2>
							
							<p><input type="text" placeholder="Choose Recipients"></p>
							<p><input type="text" placeholder="Subject"></p>
							<p><textarea placeholder="Your message"></textarea></p>
							<p><button class="btn-main">Send</button></p>
						</div>
						
						<div id="inbox">
							<div class="msg-list">
								<ul class="zebra">
									<li><a href="#">
										<div class="msg-list-item-icons">
											<img src="images/admin/unread.png" alt="">
										</div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>John Smith</strong><br>
											Subject Line
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons">
											<img src="images/admin/reply.png" alt="">
										</div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #2
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons">
											<img src="images/admin/replyall.png" alt="">
										</div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #3
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons">
											<img src="images/admin/forward.png" alt="">
										</div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #4
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
									<li><a href="#">
										<div class="msg-list-item-icons"></div>
										<div class="msg-list-item-date">01/01/2011</div>
										<div class="msg-list-item-content">
											<strong>Jane Doe</strong><br>
											Subject Line #5
										</div>
									</a></li>
								</ul>
							</div>
							
							<div class="msg-content">
								<div class="msg-content-info">
									<h3>Subject Line</h3>
									<p><strong class="subtle">From:</strong> Jane Doe</p>
									<p><strong class="subtle">To:</strong> Me, Jack Sparrow, The Dude</p>
									<p><strong class="subtle">Sent:</strong> 01/01/2011</p>
									
									<p>
										<button class="btn-sec">Reply</button>
										&nbsp;
										<button class="btn-sec">Reply All</button>
										&nbsp;
										<button class="btn-sec">Forward</button>
									</p>
								</div>
								
								<div class="msg-content-body">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pharetra auctor ante, vel dictum velit congue et. Etiam sit amet tellus risus. Aliquam sem leo, tempor eget adipiscing non, rhoncus a nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed euismod, nulla in condimentum tristique, dolor risus adipiscing risus, eget lobortis tortor nulla fringilla magna. Praesent et lacus et odio feugiat auctor et vitae erat. Phasellus dictum purus eu quam varius et lacinia elit mattis. Fusce sodales metus a dui tempor ac aliquam libero vehicula. Morbi semper leo a erat malesuada ac sollicitudin libero dictum. Phasellus ultrices leo at ligula tincidunt non congue dolor pellentesque. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

									<p>In hac habitasse platea dictumst. Maecenas malesuada feugiat libero vel sollicitudin. Cras in augue id justo commodo dignissim nec tincidunt lorem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla accumsan, lacus sed ultrices tempor, augue nisi vehicula turpis, ac eleifend quam lectus fermentum odio. Aenean ut felis lacus, vitae elementum orci. Proin eu pharetra justo. Phasellus aliquam tortor quis purus sollicitudin nec tempor velit dapibus. Duis sodales laoreet orci, quis porttitor felis accumsan quis. Proin accumsan, eros sit amet tempor vestibulum, velit lorem sodales ligula, eu porta orci est ut mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
									<br>
									
									<div class="callout">
										<h4>Quick Reply</h4>
										
										<p><textarea placeholder="Send a quick response to the author..."></textarea></p>
										
										<button class="btn-sec">Send</button>
									</div>
								</div>
							</div>
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