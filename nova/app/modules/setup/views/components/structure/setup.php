<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		
		<meta name="description" content="<?php echo Kohana::config('nova.meta_desc');?>">
		<meta name="keywords" content="<?php echo Kohana::config('nova.meta_keywords');?>">
		<meta name="author" content="<?php echo Kohana::config('nova.meta_author');?>">
		
		<?php if (isset($_redirect)): echo $_redirect; endif;?>
		
		<link rel="stylesheet" href="<?php echo Url::base();?>nova/app/modules/setup/views/design/style.css">
		<link rel="stylesheet" href="<?php echo Url::base();?>nova/app/modules/setup/views/design/jquery.ui.core.css">
		<link rel="stylesheet" href="<?php echo Url::base();?>nova/app/modules/setup/views/design/jquery.ui.theme.css">
		
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<script type="text/javascript" src="<?php echo Url::base().MODFOLDER;?>/modules/assets/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo Url::base().MODFOLDER;?>/modules/assets/js/jquery.ui.core.min.js"></script>
		<script type="text/javascript" src="<?php echo Url::base().MODFOLDER;?>/modules/assets/js/jquery.ui.widget.min.js"></script>
		<script type="text/javascript" src="<?php echo Url::base().MODFOLDER;?>/modules/assets/js/jquery.ui.progressbar.min.js"></script>
		
		<?php echo $javascript;?>
	</head>
	<body>
		<?php echo $layout;?>
	</body>
</html>