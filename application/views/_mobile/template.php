<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $title;?></title>
		
		<?php echo $_redirect;?>
		
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
		
		<?php echo $javascript;?>
	</head>
	<body>
		<div data-role="page" data-theme="b">
			<div data-role="header" data-position="inline">
				<?php
				
				switch ($this->uri->uri_string())
				{
					case 'write/missionpost':
					case 'write/personallog':
					case 'write/newsitem':
						$back_url = 'write/index';
					break;
					
					case 'write/read':
						$back_url = 'messages/index';
					break;
					
					default:
						$back_url = 'admin/index';
					break;
				}
				
				if ($this->uri->uri_string != 'admin/index'): ?>
					<a href="<?php echo site_url($back_url);?>" data-icon="arrow-l" data-transition="slide" data-direction="reverse">Back</a>
				<?php endif;?>
				
				<h1><?php echo $this->options['sim_name'];?></h1>
			</div>
			<div data-role="content" data-theme="b">
				<?php echo $flash_message;?>
				<?php echo $content;?>
				<?php echo $ajax;?>
			</div>
		</div>
	</body>
</html>