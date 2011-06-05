<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		
		<meta name="description" content="<?php echo Kohana::config('nova.meta_desc');?>">
		<meta name="keywords" content="<?php echo Kohana::config('nova.meta_keywords');?>">
		<meta name="author" content="<?php echo Kohana::config('nova.meta_author');?>">
		
		<?php if (isset($_redirect)): echo $_redirect; endif;?>
		
		<!-- jQUERY UI TABS STYLESHEET -->
		<?php if (is_file(APPPATH.'views/'.$skin.'/'.$sec.'/css/jquery.ui.tabs.css')): ?>
			<?php //echo html::style(APPFOLDER.'/views/'.$skin.'/'.$sec.'/css/jquery.ui.tabs.css');?>
		<?php else: ?>
			<?php echo Html::style(MODFOLDER.'/modules/assets/css/jquery.ui.tabs.css');?>
		<?php endif;?>
		
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<?php echo Html::script(MODFOLDER.'/modules/assets/js/jquery.js');?>
		<?php echo Html::script(MODFOLDER.'/modules/assets/js/jquery.ui.core.min.js');?>
		<?php echo Html::script(MODFOLDER.'/modules/assets/js/jquery.ui.widget.min.js');?>
		<?php echo Html::script(MODFOLDER.'/modules/assets/js/jquery.ui.tabs.min.js');?>
		
		<?php echo Html::script(MODFOLDER.'/modules/assets/contenteditable/shortcut.js');?>
		<?php echo Html::script(MODFOLDER.'/modules/assets/contenteditable/farbtastic/farbtastic.js');?>
		<?php echo Html::script(MODFOLDER.'/modules/assets/contenteditable/freshereditor.js');?>
		<?php echo Html::style(MODFOLDER.'/modules/assets/contenteditable/freshereditor.css');?>
		<?php echo Html::style(MODFOLDER.'/modules/assets/contenteditable/farbtastic/farbtastic.css');?>
		
		<?php echo $javascript;?>
		
		<?php if (is_file(APPPATH.'views/'.$skin.'/design/style.css')): ?>
			<?php echo Html::style(APPFOLDER.'/views/'.$skin.'/design/style.css');?>
		<?php else: ?>
			<?php echo Html::style(MODFOLDER.'/app/views/design/style.css');?>
			
			<?php if (is_file(APPPATH.'views/'.$skin.'/design/custom.css')): ?>
				<?php echo Html::style(APPFOLDER.'/views/'.$skin.'/design/custom.css');?>
			<?php endif;?>
		<?php endif;?>
	</head>
	<body>
		<?php echo $layout;?>
	</body>
</html>