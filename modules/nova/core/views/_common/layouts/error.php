<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		
		<!-- STYLESHEETS -->
		<?php echo html::style(MODFOLDER.'/nova/core/views/_common/css/nova.css');?>
		<?php echo html::style(MODFOLDER.'/nova/core/views/_common/css/error.css');?>
	</head>
	<body>
		<div id="container">
			<?php echo $content;?>
		</div>
	</body>
</html>