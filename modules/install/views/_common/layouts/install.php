<?php
/**
 * Layout File (Install)
 *
 * @package		Install Module
 * @subpackage	Layout
 * @author		Anodyne Productions
 * @version		2.0
 */

$styles = array(
	'stylesheets' => array(
		MODFOLDER.'/nova/views/_common/css/nova.css',
		MODFOLDER.'/install/views/install/css/skin.css',
		MODFOLDER.'/install/views/install/css/jquery.ui.core.css',
		MODFOLDER.'/install/views/install/css/jquery.ui.theme.css',
		MODFOLDER.'/nova/assets/js/css/jquery.ui.progressbar.css'
	),
	'media' => array('screen', 'screen', 'screen', 'screen', 'screen')
);

$scripts = array(
	MODFOLDER.'/nova/assets/js/jquery.js',
	MODFOLDER.'/nova/assets/js/jquery.ui.core.min.js',
	MODFOLDER.'/nova/assets/js/jquery.ui.widget.min.js',
	MODFOLDER.'/nova/assets/js/jquery.ui.progressbar.min.js',
);

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
		<?php echo html::stylesheet($styles['stylesheets'], $styles['media'], FALSE);?>
		
		<!-- JAVASCRIPT -->
		<?php echo html::script($scripts);?>
		<?php echo $javascript;?>
	</head>
	<body>
		<?php echo $layout;?>
	</body>
</html>