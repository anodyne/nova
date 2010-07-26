<?php

// get the browser info from the url
$browser = (isset($_GET['b'])) ? $_GET['b'] : FALSE;

// get the version info from the url
$version = (isset($_GET['v'])) ? $_GET['v'] : FALSE;

// get the version info from the url
$properVersion = (isset($_GET['pv'])) ? $_GET['pv'] : FALSE;

?><!DOCTYPE html>
<html lang="en">
	<head>
		<title>.:: Nova 2 - Browser Error ::.</title>
		
		<meta charset="utf-8" />
		
		<style type="text/css">
			html, body {
				margin: 0;
				padding: 0;
				
				background: #eaeaea;
				color: #444;
				font: 75%/1.5 "lucida grande", verdana, arial, sans-serif;
			}
			
			#container {
				position: absolute;
				top: 30%;
				left: 50%;
				margin: 0 0 0 -350px;
				width: 700px;
				padding: 1em;
				
				background: #e22f2f;
				background: -moz-linear-gradient(center top, #f15858 20%, #e22f2f 100%);
				background: -webkit-gradient(linear, left top, left bottom, color-stop(.2, #f15858), color-stop(1, #e22f2f));
				border: 1px solid #c90000;
				color: #fff;
				font-size: 140%;
				font-weight: bold;
				text-shadow: 0 -1px 0 rgba(0, 0, 0, .25);
				
				border-radius: 4px;
				-moz-border-radius: 4px;
				-webkit-border-radius: 4px;
				
				box-shadow: inset 0 1px 0 rgba(255, 255, 255, .4),
					inset 0 0 3px rgba(255, 255, 255, .4),
					1px 2px 4px rgba(0, 0, 0, .65);
				-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .4),
					inset 0 0 3px rgba(255, 255, 255, .4),
					1px 2px 4px rgba(0, 0, 0, .65);
				-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .4),
					inset 0 0 3px rgba(255, 255, 255, .4),
					1px 2px 4px rgba(0, 0, 0, .65);
			}
			
			h1, p { margin: 0 0 8px 0; }
			
			hr {
				height: 0;
				margin: .5em 0 1em 0;
				
				border-top: 1px solid #af2d2d;
				border-bottom: 1px solid #f06d6d;
				border-left: 0;
				border-right: 0;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<h1>Uh-Oh!</h1>
			
			<hr />
			
			<p><?php echo "Unfortunately, the version of $browser that you're using, $version, isn't supported by Nova. At this time, Nova 2 requires $browser $properVersion to run. Don't worry though, you can fix this by just updating to the latest version of $browser.";?></p>
		</div>
	</body>
</html>