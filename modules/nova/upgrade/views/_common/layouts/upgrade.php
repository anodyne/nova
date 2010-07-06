<?php
/**
 * Layout File (Upgrade)
 *
 * @package		Upgrade
 * @author		Anodyne Productions
 */
?><!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $title;?></title>
		
		<meta charset="utf-8" />
		<meta name="description" content="<?php echo Kohana::config('nova.meta_desc');?>" />
		<meta name="keywords" content="<?php echo Kohana::config('nova.meta_keywords');?>" />
		<meta name="author" content="<?php echo Kohana::config('nova.meta_author');?>" />
		
		<?php if (isset($_redirect)): echo $_redirect; endif;?>
		
		<!-- STYLESHEETS -->
		<?php echo html::style(MODFOLDER.'/nova/core/views/_common/css/nova.css');?>
		<?php echo html::style(MODFOLDER.'/nova/upgrade/views/upgrade/css/skin.css');?>
		<?php echo html::style(MODFOLDER.'/nova/upgrade/views/upgrade/css/jquery.ui.core.css');?>
		<?php echo html::style(MODFOLDER.'/nova/upgrade/views/upgrade/css/jquery.ui.theme.css');?>
		<?php echo html::style(MODFOLDER.'/assets/css/jquery.ui.progressbar.css');?>
		
		<!-- JAVASCRIPT -->
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