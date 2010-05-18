<?php
/**
 * Layout File (Main)
 *
 * @package		Nova Core
 * @subpackage	Layout
 * @author		Anodyne Productions
 * @version		2.0
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
		<?php echo html::style(MODFOLDER.'/nova/views/_common/css/nova.css');?>
		<?php echo html::style(APPFOLDER.'/views/'.$skin.'/'.$sec.'/css/main.css');?>
		
		<!-- JAVASCRIPT -->
		<?php echo $javascript;?>
	</head>
	<body>
		<?php echo $layout;?>
	</body>
</html>