<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		
		<meta name="description" content="<?php echo $meta_desc;?>">
		<meta name="keywords" content="<?php echo $meta_keywords;?>">
		<meta name="author" content="<?php echo $meta_author;?>">
		
		<?php if (isset($_redirect)): echo $_redirect; endif;?>
		
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<?php echo Html::script(MODFOLDER.'/modules/assets/js/jquery.js');?>
		<?php echo Html::script(MODFOLDER.'/modules/assets/js/bootstrap/bootstrap-dropdown.js');?>
		
		<?php echo $javascript;?>
		
		<link rel="stylesheet" href="<?php echo Url::base().MODFOLDER;?>/app/views/design/bootstrap.min.css">
		
		<?php if (is_file(APPPATH.'views/'.$skin.'/design/style.css')): ?>
			<?php echo Html::style(APPFOLDER.'/views/'.$skin.'/design/style.css');?>
		<?php else: ?>
			<?php echo Html::style(MODFOLDER.'/app/views/design/style.css');?>
			
			<?php if (is_file(APPPATH.'views/'.$skin.'/design/custom.css')): ?>
				<?php echo Html::style(APPFOLDER.'/views/'.$skin.'/design/custom.css');?>
			<?php endif;?>
		<?php endif;?>
		
		<?php if (is_file(APPPATH.'views/'.$skin.'/design/style.login.css')): ?>
			<?php echo Html::style(APPFOLDER.'/views/'.$skin.'/design/style.login.css');?>
		<?php else: ?>
			<?php echo Html::style(MODFOLDER.'/app/views/design/style.login.css');?>
			
			<?php if (is_file(APPPATH.'views/'.$skin.'/design/custom.login.css')): ?>
				<?php echo Html::style(APPFOLDER.'/views/'.$skin.'/design/custom.login.css');?>
			<?php endif;?>
		<?php endif;?>
	</head>
	<body>
		<?php echo $layout;?>
	</body>
</html>