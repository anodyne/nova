<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Layout File (Install)
 *
 * @package		Install
 * @author		Anodyne Productions
 */

// set the final style location
$style_loc = MODFOLDER.'/core/views/_base/install/css/skin.css';

?><!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $title;?></title>
		
		<meta charset="utf-8" />
		<meta name="description" content="<?php echo $this->config->item('meta_desc');?>" />
		<meta name="keywords" content="<?php echo $this->config->item('meta_keywords');?>" />
		<meta name="author" content="<?php echo $this->config->item('meta_author');?>" />
		
		<?php if (isset($_redirect)): echo $_redirect; endif;?>
		
		<style type="text/css">
			@import url("<?php echo base_url().MODFOLDER.'/core/views/_base/install/css/jquery.ui.core.css';?>");
			@import url("<?php echo base_url().MODFOLDER.'/core/views/_base/install/css/jquery.ui.theme.css';?>");
			@import url("<?php echo base_url().MODFOLDER.'/assets/js/css/jquery.ui.progressbar.css';?>");
		</style>
		
		<!-- STYLESHEETS -->
		<?php echo link_tag($style_loc); ?>
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/jquery.ui.core.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/jquery.ui.widget.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/jquery.ui.progressbar.min.js';?>"></script>
		<?php echo $javascript;?>
	</head>
	<body>
		<div id="header"></div>
		
		<div id="container">
			<div class="head">
				<h1><?php echo $label;?></h1>
			</div>
			
			<div class="content">
				<div id="loading" class="hidden">
					<img src="<?php echo base_url().MODFOLDER;?>/core/views/_base/install/images/loading-circle-large.gif" alt="" />
					<br />
					<strong><?php echo lang('global_processing');?></strong>
				</div>
				
				<div id="loaded" class="UITheme">
					<?php if ($this->uri->segment(2) == 'step' and $this->uri->segment(3) > 0): ?>
						<div id="amount">
							<span id="percent">0%</span>
							<div id="progress-container">
								<div id="progress"></div>
							</div>
						</div>
						<div style="clear:both;"></div>
					<?php endif;?>
				
					<?php echo $flash_message;?>
					<?php echo $content;?>
				</div>
			</div>
			
			<?php if ($controls !== false): ?>	
				<div class="lower">
					<div class="control"><?php echo $controls;?></div>
				</div>
			<?php endif;?>
			
			<div class="footer">
				Powered by <strong><?php echo APP_NAME;?></strong>
			</div>
		</div>
	</body>
</html>