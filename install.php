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
				<h1>Nova 3 Server Verification</h1>
			</div>

			<div class="row">
				<div class="span4">
					<h2>Environment Tests</h2>

					<p>These tests will determine if Nova 3 will run on your server. If any of these have failed, Nova 3 won't work and you'll need to contact your host to address the problems.</p>
				</div>
				
				<div class="span8">
					<?php $failed = false;?>
					<br>
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
								<td>MySQLi Enabled</td>
								<?php if (class_exists('mysqli')): ?>
									<td><span class="label label-success">Yes</span></td>
								<?php else: $failed = true;?>
									<td class="fail">The MySQLi class isn't available.</td>
								<?php endif;?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<?php if ($failed === true): ?>
				<p class="alert alert-danger">Nova 3 will not work in your environment. Please contact your host to address the above issues.</p>
			<?php else: ?>
				<p class="alert alert-success">Your environment passed all requirements.</p>
			<?php endif;?>

			<div class="row">
				<div class="span4">
					<h2>Nova 3 Tests</h2>

					<p>Now that the environment tests are complete, we can verify all of the Nova 3 pieces are in place and ready to use. Issues with these tests can be remedied by uploading a fresh copy of Nova 3 to your server.<sup class="tip" title="Issues of directory writability can be fixed from inside an FTP client or cPanel">1</sup></p>
				</div>
				
				<div class="span8">
					<?php $failed = false;?>
					<br>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="span3">Component</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>FuelPHP Core</td>
								<?php if (is_dir('nova/fuel') AND is_dir('nova/packages') AND is_file('nova/fuel/classes/fuel.php')): ?>
									<td><code>nova/fuel/</code> <code>nova/packages/</code></td>
								<?php else: $failed = true;?>
									<td class="fail">The FuelPHP directories do not exist or do not contain required files.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>Nova Core</td>
								<?php if (is_dir('nova/modules/nova') AND is_dir('nova/modules/setup') AND is_dir('nova/packages/fusion')): ?>
									<td>
										<code>nova/modules/nova/</code>
										<code>nova/modules/setup/</code>
										<code>nova/packages/fusion/</code>
									</td>
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
								<?php elseif (is_dir('app') AND is_dir('app/cache') AND ! is_writable('app/cache')): $failed = true;?>
									<td><code>app/cache/</code> exists but is not writable. Make sure the directory permissions are set to 775 or 777.</td>
								<?php else: $failed = true;?>
									<td class="fail">The <code>app/cache/</code> directory does not exist.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>Logs Directory</td>
								<?php if (is_dir('app') AND is_dir('app/logs') AND is_writable('app/logs')): ?>
									<td><code>app/logs/</code> exists and is writable</td>
								<?php elseif (is_dir('app') AND is_dir('app/logs') AND ! is_writable('app/logs')): $failed = true;?>
									<td><code>app/logs/</code> exists but is not writable. Make sure the directory permissions are set to 775 or 777.</td>
								<?php else: $failed = true;?>
									<td class="fail">The <code>app/logs/</code> directory does not exist.</td>
								<?php endif;?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<?php if ($failed === true): ?>
				<p class="alert alert-danger">There are issues with your copy of Nova 3. Please correct the above problems and refresh the page.</p>
			<?php else: ?>
				<p class="alert alert-success">Your copy of Nova 3 checks out. You should remove or rename the <code>install.php</code> file now before continuing.</p>
			<?php endif;?>
			
			<div class="row">
				<div class="span4">
					<h2>Optional Tests</h2>

					<p>These optional tests will determine if certain extensions and classes are available for use by Nova. The following extensions are not required to run Nova 3, but if enabled can provide additional functionality.</p>
				</div>
				
				<div class="span8">
					<br>
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
									<td><span class="label label-success">Yes</span></td>
								<?php else: ?>
									<td class="fail">The <a href="http://php.net/mbstring">mbstring</a> extension is not loaded. Nova will not have multibyte support.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>mcrypt Enabled</td>
								<?php if (extension_loaded('mcrypt')): ?>
									<td><span class="label label-success">Yes</span></td>
								<?php else: ?>
									<td class="fail">The <a href="http://php.net/mcrypt">mcrypt</a> extension is not loaded. PHPSecLib will be used to emulate its functionality.</td>
								<?php endif;?>
							</tr>
							<tr>
								<td>fileinfo Enabled</td>
								<?php if (extension_loaded('fileinfo')): ?>
									<td><span class="label label-success">Yes</span></td>
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