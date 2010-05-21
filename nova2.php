<?php

if (isset($_POST['submit']))
{
	$items = array(
		'php'				=> PHP_VERSION,
		'pcre_utf8'			=> (bool) @preg_match('/^.$/u', 'ñ'),
		'pcre_unicode'		=> (bool) @preg_match('/^\pL$/u', 'ñ'),
		'spl'				=> (bool) function_exists('spl_autoload_register'),
		'reflection'		=> (bool) class_exists('ReflectionClass'),
		'filters'			=> (bool) function_exists('filter_list'),
		'iconv'				=> (bool) extension_loaded('iconv'),
		'mbstring'			=> (bool) extension_loaded('mbstring'),
		'mb_overload'		=> (bool) ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING,
		'curl'				=> (bool) extension_loaded('curl'),
		'mcrypt'			=> (bool) extension_loaded('mcrypt'),
		'gd'				=> (bool) function_exists('gd_info'),
		'pdo'				=> (bool) class_exists('PDO'),
		'fopen'				=> (bool) ini_get('allow_url_fopen'),
		'url_include'		=> (bool) ini_get('allow_url_include'),
		'register_globals'	=> (bool) ini_get('register_globals'),
		'memory'			=> ini_get('memory_limit'),
		'xmlrpc'			=> (bool) extension_loaded('xmlrpc'),
	);
}

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Nova 2 Requirements Survey</title>
	
		<style type="text/css">
			body { width: 42em; margin: 0 auto; font-family: Georgia, serif; background: #f4f4f4; font-size: 1em; }
			h1 { letter-spacing: -0.04em; }
			h1 + p { margin: 0 0 2em; color: #333; font-size: 90%; font-style: italic; }
			code { font-family: monaco, monospace; }
			table { border-collapse: collapse; width: 100%; }
				table th,
				table td { padding: 0.4em; text-align: left; vertical-align: top; }
				table th { width: 12em; font-weight: normal; }
				table tr:nth-child(odd) { background: #e4e4e4; }
				table td.pass { color: #191; }
				table td.fail { color: #911; }
			#results { padding: 0.8em; color: #fff; font-size: 1.5em; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; }
			#results.pass { background: #191; }
			#results.fail { background: #911; }
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
	
		<h1>Nova 2.0 Requirements List</h1>
		
		<p>
			To help us build server requirements for Nova 2 and understand what our customers are using, we've
			put together this simple survey. This information will be sent to Anodyne to gather information
			for Nova 2. No personal information (including IP addresses) will be sent to Anodyne, only server
			information. To send your survey results, please click the <strong>Send Report Now</strong> button
			at the bottom of the page.<br /><br />
			
			For reference, the information being sent to Anodyne is displayed below. These tests have been will
			help to determine if Nova 2.0 will work on your server. If any of the tests have failed, don't panic,
			there's plenty of time to get the issues resolved with your host before Nova 2.0 is released. If you
			have questions about these tests, please contact <a href="http://www.anodyne-productions.com" target="_blank">Anodyne Productions</a>.
		</p>
	
		<?php $failed = FALSE ?>
	
		<table cellspacing="0">
			<tr>
				<th>PHP Version</th>
				<?php if (version_compare(PHP_VERSION, '5.2.4', '>=')): ?>
					<td class="pass"><?php echo PHP_VERSION ?></td>
				<?php else: $failed = TRUE ?>
					<td class="fail">Nova 2 requires PHP 5.2.4 or newer, this version is <?php echo PHP_VERSION ?>.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>PCRE UTF-8</th>
				<?php if ( ! @preg_match('/^.$/u', 'ñ')): $failed = TRUE ?>
					<td class="fail"><a href="http://php.net/pcre" target="_blank">PCRE</a> has not been compiled with UTF-8 support.</td>
				<?php elseif ( ! @preg_match('/^\pL$/u', 'ñ')): $failed = TRUE ?>
					<td class="fail"><a href="http://php.net/pcre" target="_blank">PCRE</a> has not been compiled with Unicode property support.</td>
				<?php else: ?>
					<td class="pass">Pass</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>SPL Enabled</th>
				<?php if (function_exists('spl_autoload_register')): ?>
					<td class="pass">Pass</td>
				<?php else: $failed = TRUE ?>
					<td class="fail">PHP <a href="http://www.php.net/spl" target="_blank">SPL</a> is either not loaded or not compiled in.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>Reflection Enabled</th>
				<?php if (class_exists('ReflectionClass')): ?>
					<td class="pass">Pass</td>
				<?php else: $failed = TRUE ?>
					<td class="fail">PHP <a href="http://www.php.net/reflection" target="_blank">reflection</a> is either not loaded or not compiled in.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>Filters Enabled</th>
				<?php if (function_exists('filter_list')): ?>
					<td class="pass">Pass</td>
				<?php else: $failed = TRUE ?>
					<td class="fail">The <a href="http://www.php.net/filter" target="_blank">filter</a> extension is either not loaded or not compiled in.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>Iconv Extension Loaded</th>
				<?php if (extension_loaded('iconv')): ?>
					<td class="pass">Pass</td>
				<?php else: $failed = TRUE ?>
					<td class="fail">The <a href="http://php.net/iconv" target="_blank">iconv</a> extension is not loaded.</td>
				<?php endif ?>
			</tr>
			<?php if (extension_loaded('mbstring')): ?>
			<tr>
				<th>Mbstring Not Overloaded</th>
				<?php if (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING): $failed = TRUE ?>
					<td class="fail">The <a href="http://php.net/mbstring" target="_blank">mbstring</a> extension is overloading PHP's native string functions.</td>
				<?php else: ?>
					<td class="pass">Pass</td>
				<?php endif ?>
			</tr>
			<?php endif ?>
			<tr>
				<th>Memory Limit</th>
				<?php if (str_replace('M', '', ini_get('memory_limit')) >= 8): ?>
					<td class="pass">Pass</td>
				<?php else: $failed = TRUE ?>
					<td class="fail">You don't have a high enough memory limit to run Nova. Nova requires 8M and you only have <?php echo ini_get('memory_limit');?>.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>Register Globals</th>
				<?php if ((bool) ini_get('register_globals') === FALSE): ?>
					<td class="pass">Pass</td>
				<?php else: $failed = TRUE ?>
					<td class="fail">Your server has register globals turned ON which is a security issue. Nova requires register globals to be turned OFF.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>cURL Enabled</th>
				<?php if (extension_loaded('curl')): ?>
					<td class="pass">Pass</td>
				<?php else: ?>
					<td class="fail">Kohana requires <a href="http://php.net/curl" target="_blank">cURL</a> for the Remote class. You will still be able to install Nova 2 without cURL loaded, but you will not be able to use Kohana's Remote class.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>mcrypt Enabled</th>
				<?php if (extension_loaded('mcrypt')): ?>
					<td class="pass">Pass</td>
				<?php else: ?>
					<td class="fail">Kohana requires <a href="http://php.net/mcrypt" target="_blank">mcrypt</a> for the Encrypt class. You will still be able to install Nova 2 without mcrypt loaded, but you will not be able to use Kohana's Encrypt class.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>GD Enabled</th>
				<?php if (function_exists('gd_info')): ?>
					<td class="pass">Pass</td>
				<?php else: ?>
					<td class="fail">Kohana requires <a href="http://php.net/gd" target="_blank">GD</a> v2 for the Image class. You will still be able to install Nova 2 without GD enabled, but you will not be able to use Kohana's Image class.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>PDO Enabled</th>
				<?php if (class_exists('PDO')): ?>
					<td class="pass">Pass</td>
				<?php else: ?>
					<td class="fail">Kohana can use <a href="http://php.net/pdo" target="_blank">PDO</a> to support additional databases. You will still be able to install Nova 2 without PDO enabled.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>File Handling</th>
				<?php if ((bool) ini_get('allow_url_fopen')): ?>
					<td class="pass">Pass</td>
				<?php else: ?>
					<td class="fail">Nova's update checking feature requires the inclusion and reading of remote files. You will still be able to install Nova 2 without remote file inclusion enabled, but you will need to manually check for updates to Nova.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>Remote File Includes</th>
				<?php if ((bool) ini_get('allow_url_include')): ?>
					<td class="pass">Pass</td>
				<?php else: ?>
					<td class="fail">Nova's update checking feature requires the inclusion and reading of remote files. You will still be able to install Nova 2 without remote file inclusion enabled, but you will need to manually check for updates to Nova.</td>
				<?php endif ?>
			</tr>
			<tr>
				<th>XML-RPC</th>
				<?php if ((bool) extension_loaded('xmlrpc')): ?>
					<td class="pass">Pass</td>
				<?php else: ?>
					<td class="fail">Nova uses the <a href="http://us3.php.net/manual/en/book.xmlrpc.php" target="_blank">XML-RPC</a> extension to communicate with other servers if so configured. You will still be able to install Nova 2 without XML-RPC enabled.</td>
				<?php endif ?>
			</tr>
		</table>
	
		<?php if ($failed === TRUE): ?>
			<p id="results" class="fail">✘ Your host has some 'splainin' to do...<br />
				Kohana may not work correctly with your environment.</p>
		<?php else: ?>
			<p id="results" class="pass">✔ Your environment passed all requirements.</p>
		<?php endif ?>
		
		<p>&nbsp;</p>
		
		<form method="post" action="">
			<button type="submit" name="submit" value="submit">Send Report Now &raquo;</button>
		</form>
		
		<p>&nbsp;</p>
	</body>
</html>