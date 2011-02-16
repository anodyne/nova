<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		
		<meta name="description" content="<?php echo Kohana::config('nova.meta_desc');?>">
		<meta name="keywords" content="<?php echo Kohana::config('nova.meta_keywords');?>">
		<meta name="author" content="<?php echo Kohana::config('nova.meta_author');?>">
		
		<?php if (isset($_redirect)): echo $_redirect; endif;?>
		
		<!-- STYLESHEETS -->
		<?php echo html::style(MODFOLDER.'/nova/core/views/_common/css/nova.css');?>
		
		<?php if (is_file(APPPATH.'views/'.$skin.'/foundation.css')): ?>
			<?php echo html::style(APPFOLDER.'/views/'.$skin.'/foundation.css');?>
		<?php endif;?>
		
		<?php echo html::style(APPFOLDER.'/views/'.$skin.'/'.$sec.'/css/main.css');?>
		
		<!-- jQUERY UI THEME STYLESHEET -->
		<?php if (is_file(APPPATH.'views/'.$skin.'/'.$sec.'/css/jquery.ui.theme.css')): ?>
			<?php $uiTheme = url::base().APPFOLDER.'/views/'.$skin.'/'.$sec.'/css/jquery.ui.theme.css';?>
		<?php else: ?>
			<?php $uiTheme = url::base().MODFOLDER.'/assets/css/jquery.ui.theme.css';?>
		<?php endif;?>
		
		<!-- jQUERY UI TABS STYLESHEET -->
		<?php if (is_file(APPPATH.'views/'.$skin.'/'.$sec.'/css/jquery.ui.tabs.css')): ?>
			<?php $uiTabs = url::base().APPFOLDER.'/views/'.$skin.'/'.$sec.'/css/jquery.ui.tabs.css';?>
		<?php else: ?>
			<?php $uiTabs = url::base().MODFOLDER.'/assets/css/jquery.ui.tabs.css';?>
		<?php endif;?>
		
		<!-- JAVASCRIPT -->
		<?php echo html::script(MODFOLDER.'/assets/js/jquery.js');?>
		<?php echo html::script(MODFOLDER.'/assets/js/jquery.lazy.js');?>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
				
				$.lazy({
					src: '<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ui.tabs.min.js',
					name: 'tabs',
					dependencies: {
						js: [
							'<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ui.core.min.js',
							'<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ui.widget.min.js'
						],
						css: [
							'<?php echo $uiTheme;?>',
							'<?php echo $uiTabs;?>'
						]
					},
					cache: true
				});
			});
		</script>
		
		<?php echo $javascript;?>
	</head>
	<body>
		<?php echo $layout;?>
	</body>
</html>