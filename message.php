<?php

// get the type of message
$type = (isset($_GET['type'])) ? $_GET['type'] : false;

switch ($type)
{
	case 'php':
		$title = 'Nova Notice';
		$header = 'Uh oh!';
		$headerClass = 'error';
		$message = 'Unforunately, your server isn\'t running a compatible version of PHP. In order to run Nova 2, your server needs to have at least PHP 5.1 (you only have PHP '.PHP_VERSION.'. Please contact your host to resolve this issue. Additional support is available from <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne Productions</a>.';
	break;
	
	case 'maintenance':
		$title = 'Nova Maintenance';
		$header = 'Nova Maintenance';
		$headerClass = 'notice';
		$message = 'We\'re doing some maintenance on the site right now and it isn\'t available. This shouldn\'t take very long, so please try again in a little while.';
	break;
	
	case 'banned':
		$title = 'Nova Notice';
		$header = 'Uh oh!';
		$headerClass = 'error';
		$message = 'It looks like you\'ve been naughty and the game master has completely banned you from viewing the site. This ban can be lifted by the game master, but you\'ll need to <a href="index.php/main/contact">contact them</a> to do so.';
	break;
	
	case 'browser':
		$title = 'Nova Notice';
		$header = 'Uh oh!';
		$headerClass = 'notice';
		$message = 'It looks like you\'re running a version of Internet Explorer that isn\'t supported. In order to use this version of Nova, you need to be running Internet Explorer 7 or higher (we recommend IE 8). You can find updates to Internet Explorer in Windows Update or from <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx" target="_blank">microsoft.com</a>. Or better yet, give <a href="http://www.getfirefox.com" target="_blank">Firefox</a> or <a href="http://www.google.com/chrome" target="_blank">Google Chrome</a> a try.';
	break;
}

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		
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
				border-radius: 3px;
				-moz-border-radius: 3px;
				box-shadow: inset 0 1px 0 rgba(255, 255, 255, .55), 0 2px 7px rgba(0, 0, 0, .2);
				-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .55), 0 2px 7px rgba(0, 0, 0, .2);
				-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .55), 0 2px 7px rgba(0, 0, 0, .2);
			}
			#container h1 { text-shadow: 0 1px 0 rgba(255, 255, 255, .55); }
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
			<h1 class="<?php echo $headerClass;?>"><?php echo $header;?></h1>
			
			<p><?php echo $message;?></p>
		</div>
	</body>
</html>