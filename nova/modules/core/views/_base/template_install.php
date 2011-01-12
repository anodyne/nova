<?php
/*
|---------------------------------------------------------------
| TEMPLATE - INSTALL
|---------------------------------------------------------------
|
| File: application/views/_base/template_install.php
| Skin Version: 1.0
|
| Main layout file used by the install system
|
*/

/* set the final style location */
$style_loc = APPFOLDER . '/views/_base/install/css/skin.css';

echo "<?xml version='1.0' encoding='UTF-8'?>\r\n";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title><?php echo $title;?></title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />
		<meta name="description" content="<?php echo $this->config->item('meta_desc');?>" />
		<meta name="keywords" content="<?php echo $this->config->item('meta_keywords');?>" />
		<meta name="author" content="<?php echo $this->config->item('meta_author');?>" />
		
		<?php echo $_redirect;?>
		
		<style type="text/css">
			@import url("<?php echo base_url() . APPFOLDER .'/views/_base/install/css/jquery.ui.core.css';?>");
			@import url("<?php echo base_url() . APPFOLDER .'/views/_base/install/css/jquery.ui.theme.css';?>");
			@import url("<?php echo base_url() . APPFOLDER .'/assets/js/css/jquery.ui.progressbar.css';?>");
		</style>
		
		<!-- STYLESHEETS -->
		<?php echo link_tag($style_loc); ?>
		
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.ui.core.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.ui.widget.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.ui.progressbar.min.js';?>"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('body').click(function(event){
					if (! $(event.target).closest('div').hasClass('signin-panel'))
					{
						$('.signin-panel').hide();
						$('a#signin').addClass('corner-lower-left').addClass('corner-lower-right').removeClass('signin-active');
					}
				});
				
				$('a#signin').click(function(e){
					$('.signin-panel').toggle();
					$('a#signin').toggleClass('corner-lower-left').toggleClass('corner-lower-right').toggleClass('signin-active');
					$('.signin-panel input:first').focus();
					
					return false;
				});
			});
			
			/* if the escape key is pressed, close the menu */
			$(document).keyup(function(event){
				if (event.keyCode == 27) {
					$('.signin-panel').hide();
					$('a#signin').addClass('corner-lower-left').addClass('corner-lower-right').removeClass('signin-active');
				}
			});
		</script>
		
		<?php echo $javascript;?>
	</head>
	<body>
		<div id="header"></div>
		
		<div id="container">
			<div class="head">
				<?php if ($this->uri->rsegment(2) != 'index'): ?>
					<div class="more-options">
						<div class="signin-panel corner-upper-left corner-lower-left corner-lower-right">
							<?php echo $install_options;?>
						</div>
						<a href="<?php echo site_url('install/main/full');?>" id="signin" class="signin corner-upper-left corner-upper-right corner-lower-left corner-lower-right"><?php echo lang('global_more_options');?></a>
					</div>
				<?php endif;?>
							
				<?php echo text_output($label, 'h1');?>
			</div>
			
			<div class="content">
				<div id="loading" class="hidden">
					<img src="<?php echo base_url() . APPFOLDER;?>/views/_base/install/images/loading-circle-large.gif" alt="" />
					<br />
					<strong><?php echo lang('global_processing');?></strong>
				</div>
				
				<div id="loaded" class="UITheme">
					<?php if ($this->uri->segment(2) == 'step'): ?>
						<div id="amount"><?php echo lang('global_progress');?>: <span id="percent">0%</span></div>
						<div id="progress"></div>
					<?php endif;?>
				
					<?php echo $flash_message;?>
					<?php echo $content;?>
				</div>
			</div>
			
			<div class="lower"><?php echo $controls;?></div>
			
			<div class="footer">
				Powered by <strong><?php echo APP_NAME;?></strong>
			</div>
		</div>
	</body>
</html>