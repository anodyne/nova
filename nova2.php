<?php

if (isset($_POST['submit']))
{
	$items = array(
		'php'					=> PHP_VERSION,
		'pcre_utf8'				=> (bool) @preg_match('/^.$/u', 'ñ'),
		'pcre_unicode'			=> (bool) @preg_match('/^\pL$/u', 'ñ'),
		'spl'					=> (bool) function_exists('spl_autoload_register'),
		'reflection'			=> (bool) class_exists('ReflectionClass'),
		'filters'				=> (bool) function_exists('filter_list'),
		'iconv'					=> (bool) extension_loaded('iconv'),
		'mbstring'				=> (bool) extension_loaded('mbstring'),
		'mb_overload'			=> (bool) ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING,
		'curl'					=> (bool) extension_loaded('curl'),
		'mcrypt'				=> (bool) extension_loaded('mcrypt'),
		'gd'					=> (bool) function_exists('gd_info'),
		'pdo'					=> (bool) class_exists('PDO'),
		'fopen'					=> (bool) ini_get('allow_url_fopen'),
		'url_include'			=> (bool) ini_get('allow_url_include'),
		'register_globals'		=> (bool) ini_get('register_globals'),
		'memory'				=> ini_get('memory_limit'),
		'xmlrpc'				=> (bool) extension_loaded('xmlrpc'),
		'disabled_functions'	=> ini_get('disable_functions'),
		'disabled_classes'		=> ini_get('disable_classes'),
	);
}

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Nova 2 Requirements Survey</title>
	
		<style type="text/css">
			body { width: 50em; margin: 0 auto; font-family: Georgia, serif; background: #f4f4f4; font-size: 1em; }
			h1 { letter-spacing: -0.04em; }
			em, ul { margin: 0 0 1em; color: #333; font-size: 90%; font-style: italic; display: block; }
			button {
				padding: 0 29px;
				height: 2em;
				line-height: 1.9em;
				
				font-size: 1.5em;
				border: 1px solid #888;
				border-top: 1px solid rgba(255, 255, 255, 1);
				font-weight: bold;
				font-family: Georgia, serif;
				background: #bbb;
				background: -moz-linear-gradient(top, #ddd, #bbb);
				background: -webkit-gradient(linear, 0 0, 0 100%, from(#ddd), to(#bbb));
				text-shadow: 0px 1px 0px rgba(255, 255, 255, .4);
				
				border-radius: 3px;
				-moz-border-radius: 3px;
				-webkit-border-radius: 3px;
				
				box-shadow: 0px -1px 0px #888;
				-moz-box-shadow: 0px -1px 0px #888;
				-webkit-box-shadow: 0px -1px 0px #888;
			}
			button:hover {
				background: #aaa;
				background: -moz-linear-gradient(top, #ccc, #aaa);
				background: -webkit-gradient(linear, 0 0, 0 100%, from(#ccc), to(#aaa));
			}
		</style>
	</head>
	<body>
		<h1>Nova 2.0 Server Survey</h1>
		
		<em>To help us build server requirements for Nova 2 and understand what our customers are using, we've put together this simple survey. How simple? Well, you just have a click a button. Pretty easy, huh?</em>
		
		<em>So what information are we collecting exactly? Rest assured no personal information (including your IP address) will be sent to Anodyne. The only things we're collecting is server information. The following items are being sent to Anodyne:</em>
		
		<ul>
			<li>What version of PHP is running?</li>
			<li>Is PCRE enabled and have Unicode and/or UTF-8 support?</li>
			<li>Is SPL Autoload enabled?</li>
			<li>Is the Reflection class available?</li>
			<li>Is the filters list available?</li>
			<li>Is the Iconv extension loaded?</li>
			<li>Is mbstring available and is it being overloaded?</li>
			<li>Is cURL available?</li>
			<li>Is mcrypt available?</li>
			<li>Is the GD library available?</li>
			<li>Is PDO available for the database connection?</li>
			<li>Is URL file opening permitted?</li>
			<li>Is remote file inclusion permitted?</li>
			<li>Is register globals turned on or off?</li>
			<li>What is your server's memory limit?</li>
			<li>Is the XML-RPC extention available?</li>
			<li>What PHP functions have been disabled by your web host?</li>
			<li>What PHP classes have been disabled by your web host?</li>
		</ul>
		
		<em>The results of the survey are hidden for security reasons (no sense in letting everyone and their mother see all kinds of server settings, right?). As Nova 2 gets closer to release, we'll post a verification utility through AnodyneXtras that you can use to test whether your server meets our requirements. For the time being though, there are no requirements besides PHP 5.</em>
		
		<p>&nbsp;</p>
		
		<form method="post" action="">
			<button type="submit" name="submit" value="submit">Send Report Now &raquo;</button>
		</form>
	</body>
</html>