<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $title;?></title>
		
		<meta charset="utf-8">
		
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