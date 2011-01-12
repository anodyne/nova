<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Banned!</title>
		<meta charset="utf-8" />
		
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
				
				color: #c00;
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
		</style>
	</head>
	<body>
		<div id="container">
			<h1>Uh oh!</h1>
			<p>Looks like you've been naughty and the game master has completely banned you from viewing the site.
				This ban can be lifted by the game master, but you'll need to <a href="index.php/main/contact">contact
				them</a> to do so.</p>
		</div>
	</body>
</html>