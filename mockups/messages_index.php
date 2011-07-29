<?php

$messages = array(
	0 => array(
		'author' => 'Jack Sparrow',
		'subject' => 'Ahoy!',
		'recipients' => 'Captain Barbossa, Me',
		'status' => 'unread',
		'date' => '02/01/2011',
		'content' => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pharetra auctor ante, vel dictum velit congue et. Etiam sit amet tellus risus. Aliquam sem leo, tempor eget adipiscing non, rhoncus a nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed euismod, nulla in condimentum tristique, dolor risus adipiscing risus, eget lobortis tortor nulla fringilla magna. Praesent et lacus et odio feugiat auctor et vitae erat. Phasellus dictum purus eu quam varius et lacinia elit mattis. Fusce sodales metus a dui tempor ac aliquam libero vehicula. Morbi semper leo a erat malesuada ac sollicitudin libero dictum. Phasellus ultrices leo at ligula tincidunt non congue dolor pellentesque. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p><p>In hac habitasse platea dictumst. Maecenas malesuada feugiat libero vel sollicitudin. Cras in augue id justo commodo dignissim nec tincidunt lorem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla accumsan, lacus sed ultrices tempor, augue nisi vehicula turpis, ac eleifend quam lectus fermentum odio. Aenean ut felis lacus, vitae elementum orci. Proin eu pharetra justo. Phasellus aliquam tortor quis purus sollicitudin nec tempor velit dapibus. Duis sodales laoreet orci, quis porttitor felis accumsan quis. Proin accumsan, eros sit amet tempor vestibulum, velit lorem sodales ligula, eu porta orci est ut mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>"),
	1 => array(
		'author' => 'Starbuck',
		'subject' => 'Frakking Awesome',
		'recipients' => 'Me',
		'status' => 'unread',
		'date' => '01/01/2011',
		'content' => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pharetra auctor ante, vel dictum velit congue et. Etiam sit amet tellus risus. Aliquam sem leo, tempor eget adipiscing non, rhoncus a nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed euismod, nulla in condimentum tristique, dolor risus adipiscing risus, eget lobortis tortor nulla fringilla magna. Praesent et lacus et odio feugiat auctor et vitae erat. Phasellus dictum purus eu quam varius et lacinia elit mattis. Fusce sodales metus a dui tempor ac aliquam libero vehicula. Morbi semper leo a erat malesuada ac sollicitudin libero dictum. Phasellus ultrices leo at ligula tincidunt non congue dolor pellentesque. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p><p>In hac habitasse platea dictumst. Maecenas malesuada feugiat libero vel sollicitudin. Cras in augue id justo commodo dignissim nec tincidunt lorem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla accumsan, lacus sed ultrices tempor, augue nisi vehicula turpis, ac eleifend quam lectus fermentum odio. Aenean ut felis lacus, vitae elementum orci. Proin eu pharetra justo. Phasellus aliquam tortor quis purus sollicitudin nec tempor velit dapibus. Duis sodales laoreet orci, quis porttitor felis accumsan quis. Proin accumsan, eros sit amet tempor vestibulum, velit lorem sodales ligula, eu porta orci est ut mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>"),
);

?><!DOCTYPE html>
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
			$(document).ready(function(){
				$('ul.zebra > li:nth-child(odd)').addClass('alt');
				
				$('#add').click(function(){
					$('#compose').fadeIn();
					return false;
				});
				
				$('#add-cancel').click(function(){
					$('#compose').fadeOut();
					return false;
				});
				
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
				
				$('.msg-list-item').click(function(){
					var key = $(this).attr('id');
					var obj = <?php echo json_encode($messages);?>;
					
					// info
					$('#info-subject').html(obj[key].subject);
					$('#info-from').html(obj[key].author);
					$('#info-to').html(obj[key].recipients);
					$('#info-sent').html(obj[key].date);
					$('.msg-content-info').removeClass('hidden');
					
					// content
					$('#content-body').html(obj[key].content);
					$('.msg-content-body').removeClass('hidden');
					
					// de-select others
					$('.msg-list ul li').each(function(){
						if ($(this).hasClass('inbox-selected'))
							$(this).removeClass('inbox-selected');
					});
					
					// select
					$(this).parent().addClass('inbox-selected');
					
					return false;
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
						<p><button id="add" class="btn-main">New Message</button></p>
						
						<div id="compose" class="callout hidden">
							<div class="float-right"><a href="#" id="add-cancel">Cancel</a></div>
							
							<h2 class="page-subhead">Compose New Message</h2>
							
							<p><input type="text" placeholder="Choose Recipients"></p>
							<p><input type="text" placeholder="Subject"></p>
							<p><textarea placeholder="Your message"></textarea></p>
							<p><button class="btn-main">Send</button></p>
						</div>
						
						<div id="inbox">
							<div class="msg-list">
								<ul class="zebra">
								<?php foreach ($messages as $id => $m): ?>
									<li><a href="#" class="msg-list-item" id="<?php echo $id;?>">
										<div class="msg-list-item-icons">
											<?php if ($m['status'] == 'unread'): ?>
												<img src="images/admin/unread.png" alt="">
											<?php endif;?>
										</div>
										<div class="msg-list-item-date"><?php echo $m['date'];?></div>
										<div class="msg-list-item-author"><?php echo $m['author'];?></div>
										<div class="msg-list-item-subject"><?php echo $m['subject'];?></div>
									</a></li>
								<?php endforeach;?>
								</ul>
							</div>
							
							<div class="msg-content">
								<div class="msg-content-info hidden">
									<h3 id="info-subject"></h3>
									<p><strong class="subtle">From:</strong> <span id="info-from"></span></p>
									<p><strong class="subtle">To:</strong> <span id="info-to"></span></p>
									<p><strong class="subtle">Sent:</strong> <span id="info-sent"></span></p>
									
									<p>
										<button class="float-right btn-dest">Delete</button>
										<button class="btn-sec">Reply</button>
										&nbsp;
										<button class="btn-sec">Reply All</button>
										&nbsp;
										<button class="btn-sec">Forward</button>
									</p>
								</div>
								
								<div class="msg-content-body hidden">
									<span id="content-body"></span>
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