<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		
		<meta name="description" content="<?php echo Kohana::config('nova.meta_desc');?>">
		<meta name="keywords" content="<?php echo Kohana::config('nova.meta_keywords');?>">
		<meta name="author" content="<?php echo Kohana::config('nova.meta_author');?>">
		
		<?php if (isset($_redirect)): echo $_redirect; endif;?>
		
		<?php echo html::style(MODFOLDER.'/nova/update/views/design/style.css');?>
		<?php echo html::style(MODFOLDER.'/nova/update/views/design/jquery.ui.core.css');?>
		<?php echo html::style(MODFOLDER.'/nova/update/views/design/jquery.ui.theme.css');?>
		<?php echo html::style(MODFOLDER.'/assets/css/jquery.ui.progressbar.css');?>
		
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<?php echo html::script(MODFOLDER.'/assets/js/jquery.js');?>
		<?php echo html::script(MODFOLDER.'/assets/js/jquery.ui.core.min.js');?>
		<?php echo html::script(MODFOLDER.'/assets/js/jquery.ui.widget.min.js');?>
		<?php echo html::script(MODFOLDER.'/assets/js/jquery.ui.progressbar.min.js');?>
		<?php echo $javascript;?>
	</head>
	<body>
		<?php echo $layout;?>
	</body>
</html>