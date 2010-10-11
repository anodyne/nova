<!DOCTYPE html>
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
		<?php echo html::style(APPFOLDER.'/views/'.$skin.'/'.$sec.'/css/main.css');?>
		
		<!-- jQUERY UI TABS STYLESHEET -->
		<?php if (is_file(APPPATH.'views/'.$skin.'/'.$sec.'/css/jquery.ui.tabs.css')): ?>
			<?php echo html::style(APPFOLDER.'/views/'.$skin.'/'.$sec.'/css/jquery.ui.tabs.css');?>
		<?php else: ?>
			<?php echo html::style(MODFOLDER.'/assets/css/jquery.ui.tabs.css');?>
		<?php endif;?>
		
		<!-- JAVASCRIPT -->
		<?php echo html::script(MODFOLDER.'/assets/js/jquery.js');?>
		<?php echo html::script(MODFOLDER.'/assets/js/jquery.ui.core.min.js');?>
		<?php echo html::script(MODFOLDER.'/assets/js/jquery.ui.widget.min.js');?>
		<?php echo html::script(MODFOLDER.'/assets/js/jquery.ui.tabs.min.js');?>
		<?php echo $javascript;?>
	</head>
	<body>
		<?php echo $layout;?>
	</body>
</html>