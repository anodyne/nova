<?php

// get the type of message
$type = (isset($_GET['type'])) ? $_GET['type'] : false;

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Nova Maintenance</title>
		
		<style>
			body {
				background: #f4f4f4;
				color: #444;
				font: 75%/1.5 "lucida grande", verdana, arial, sans-serif;
			}
			
			#container {
				width: 650px;
				margin: 5em auto;
				padding: 0 1em;
				
				border: 1px solid #aaa;
				background: #ddd;
				background: -moz-linear-gradient(center top, #eee 20%, #ddd 100%);
				background: -webkit-gradient(linear, left top, left bottom, color-stop(.2, #eee), color-stop(1, #ddd));
				
				border-radius: 4px;
				-moz-border-radius: 4px;
				
				box-shadow: inset 0 1px 0 rgba(255, 255, 255, .55), 0 2px 7px rgba(0, 0, 0, .2);
				-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .55), 0 2px 7px rgba(0, 0, 0, .2);
				-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .55), 0 2px 7px rgba(0, 0, 0, .2);
			}
			#container h1 {
				padding: 0 0 0 45px;
				
				background: transparent url('exclamation.png') no-repeat center left;
				text-shadow: 0 1px 0 rgba(255, 255, 255, .55);
			}
			#container p {
				color: #555;
				font-size: 1.2em;
				text-shadow: 0 1px 0 rgba(255, 255, 255, .55);
			}
			#container a { color: #000; }
			#container a:hover { color: #06c; }
			
			.error { color: #c00; }
			.notice { color: #406ceb; }
		</style>
	</head>
	<body>
		<div id="container">
			<?php if ($type == 'php'): ?>
				<h1 class="error">Uh oh!</h1>
				<p>Unforunately, your server isn't running a compatible version of PHP. Please check the server requirements
					and contact your host if necessary. Additional support is available from <a href="http://forums.anodyne-productions.com" target="_blank">
					Anodyne Productions</a>.</p>
			<?php elseif ($type == 'maintenance'): ?>
				<h1 class="notice">Nova Maintenance</h1>
				<p>We're doing some maintenance on the site right now and it isn't available. This shouldn't take very long, 
					so please try again in a little while.</p>
			<?php elseif ($type == 'banned'): ?>
				<h1 class="error">Uh oh!</h1>
				<p>Looks like you've been naughty and the game master has completely banned you from viewing the site.
					This ban can be lifted by the game master, but you'll need to <a href="index.php/main/contact">contact
					them</a> to do so.</p>
			<?php endif;?>
		</div>
	</body>
</html>