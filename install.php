<?php

if (version_compare(PHP_VERSION, '5.3', '<'))
{
	// Clear out the cache to prevent errors. This typically happens on Windows/FastCGI.
	clearstatcache();
}
else
{
	// Clearing the realpath() cache is only possible PHP 5.3+
	clearstatcache(true);
}

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Nova 3 :: Environment Tests</title>

		<link rel="stylesheet" href="nova/modules/assets/css/bootstrap.min.css">
		<style>
			body {
				background: #fafafa;
				color: #333;
			}
			p, td, th {
				font-size: 14px;
				line-height: 1.6;
			}
			.fail {
				color: #c00;
			}
			.tip {
				cursor: help;
				color: #08c;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1>Environment Tests</h1>
			</div>
			
			<div class="row">
				<div class="span3">
					<p>Nova 3 has been designed to work in as many environments as possible. That being said, there are still some requirements that must be met in order for Nova 3 to run. These environment tests are designed to determine if Nova 3 will run on your server. If any of these tests have failed, Nova 3 won't work and you'll need to contact your host to address the problems.<sup class="tip" title="Issues of directory writability can be fixed from inside an FTP client or cPanel">1</sup></p>
				</div>
				
				<div class="span9">
					<?php $failed = false;?>

					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="span3">Component</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>PHP Version</td>
								<?php if (version_compare(PHP_VERSION, '5.3.0', '>=')): ?>
									<td><span class="label label-success"><?php echo PHP_VERSION ?></span></td>
								<?php else: $failed = true;?>
									<td><span class="label label-important"><?php echo PHP_VERSION ?></span></td>
								<?php endif;?>
							</tr>
							<tr>
								<td>MySQL Enabled</td>
								<?php if (function_exists('mysql_connect')): ?>
									<td><span class="label label-success">Pass</span></td>
								<?php else: $failed = true;?>
									<td class="fail">FuelPHP can use the <a href="http://php.net/mysql">MySQL</a> extension to support MySQL databases.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>FuelPHP</td>
								<?php if (is_dir('nova/fuel') AND is_dir('nova/packages') AND is_file('nova/fuel/classes/fuel.php')): ?>
									<td><code>nova/fuel/</code>, <code>nova/packages/</code></td>
								<?php else: $failed = true;?>
									<td class="fail">The FuelPHP directory does not exist or does not contain required files.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>Nova Core</td>
								<?php if (is_dir('nova/modules/nova') AND is_dir('nova/modules/setup')): ?>
									<td><code>nova/modules/nova/</code>, <code>nova/modules/setup/</code></td>
								<?php else: $failed = true;?>
									<td class="fail">The Nova core does not exist or is missing required directories.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>Application Directory</td>
								<?php if (is_dir('app') AND is_file('app/bootstrap.php')): ?>
									<td><code>app/</code></td>
								<?php else: $failed = true;?>
									<td class="fail">The <code>app</code> directory does not exist or does not contain required files.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>Cache Directory</td>
								<?php if (is_dir('app') AND is_dir('app/cache') AND is_writable('app/cache')): ?>
									<td><code>app/cache/</code> exists and is writable</td>
								<?php else: $failed = true;?>
									<td class="fail">The <code>app/cache/</code> directory is not writable.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>Logs Directory</td>
								<?php if (is_dir('app') AND is_dir('app/logs') AND is_writable('app/logs')): ?>
									<td><code>app/logs/</code> exists and is writable</td>
								<?php else: $failed = true;?>
									<td class="fail">The <code>app/logs/</code> directory is not writable.</td>
								<?php endif;?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<?php if ($failed === true): ?>
				<div class="alert alert-danger alert-block">
					<h4 class="alert-heading">Warning!</h4>
					<p>Nova 3 will not work in your environment. Please contact your host to address the above issues.</p>
				</div>
			<?php else: ?>
				<div class="alert alert-success alert-block">
					<h4 class="alert-heading">Success!</h4>
					<p>Your environment passed all requirements. You should remove or rename the <code>install.php</code> file now before continuing.</p>
				</div>
			<?php endif;?>
			
			<div class="page-header">
				<h1>Optional Tests</h1>
			</div>
			
			<div class="row">
				<div class="span3">
					<p>These optional tests will determine if certain extensions and classes are available for use by Nova. The following extensions are not required to run Nova 3, but if enabled can provide additional functionality.</p>
				</div>
				
				<div class="span9">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="span3">Component</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>mbstring Enabled</td>
								<?php if (extension_loaded('mbstring')): ?>
									<td><span class="label label-success">Pass</span></td>
								<?php else: ?>
									<td class="fail">The <a href="http://php.net/mbstring">mbstring</a> extension is not loaded. Nova will not have multibyte support.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>mcrypt Enabled</td>
								<?php if (extension_loaded('mcrypt')): ?>
									<td><span class="label label-success">Pass</span></td>
								<?php else: ?>
									<td class="fail">The <a href="http://php.net/mcrypt">mcrypt</a> extension is not loaded. PHPSecLib will be used to emulate its functionality.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>fileinfo Enabled</td>
								<?php if (extension_loaded('fileinfo')): ?>
									<td><span class="label label-success">Pass</span></td>
								<?php else: ?>
									<td class="fail">The <a href="http://us.php.net/manual/en/book.fileinfo.php">fileinfo</a> extension is not loaded. If you are running on a Windows server, additional DLLs may need to be installed in order for FileInfo to work.</td>
								<?php endif;?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="nova/modules/assets/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.tip').tooltip({ placement: 'right' });
			});
		</script>
	</body>
</html>