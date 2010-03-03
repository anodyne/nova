<?php
/*
|---------------------------------------------------------------
| TEMPLATE - LOGIN
|---------------------------------------------------------------
|
| File: application/views/beta/template_login.php
| Skin Version: 1.0
|
| Login template file used by the beta skin.
|
| $sec options are: main, wiki, admin, login
| $css can be anything you want (with a .css extension of course)
|
*/

$sec = 'login'; /* set the section of the system */
$css = 'main.css'; /* the name of the main css file */

$path_raw = dirname(__FILE__); /* absolute path of the current file */
$path = explode('/', $path_raw); /* explode the string into an array */

if (count($path) <= 1)
{ /* Windows servers use back slashes, so we have to capture for that */
	$path = explode('\\', $path_raw);
}

$pcount = count($path); /* count the number of keys in the array */
$skin_loc = $pcount -1; /* create the first element used */
$current_skin = $path[$skin_loc];

/* set the final style location */
$style_loc = APPFOLDER . '/views/' . $current_skin . '/' . $sec . '/css/' . $css;

/* set up the link tag parameters */
$link = array(
	'href'	=> 	$style_loc,
	'rel'	=> 	'stylesheet',
	'type'	=> 	'text/css',
	'media'		=> 'screen',
	'charset'	=> 'utf-8'
);

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
		
		<!-- STYLESHEETS -->
		<?php echo link_tag($link); ?>
		
		<!-- JAVASCRIPT FILES -->
		<?php include_once($this->config->item('include_head_login')); ?>
		
		<?php echo $javascript;?>
	</head>
	<body>
		<!-- BODY -->
		<div id="body">
			<div class="wrapper">
				<div id="head">
					<div class="logo">
						<?php echo img(APPFOLDER .'/views/'. $current_skin .'/'. $sec .'/images/nova-small.png', FALSE);?>
					</div>
					
					<?php echo text_output($this->options['sim_name'], '');?>
				</div>
			
				<!-- PAGE CONTENT -->
				<div class="content">
					<?php echo $flash_message;?>
					<?php echo $content;?>
					
					<?php if (!$this->uri->segment(2) || $this->uri->segment(2) == 'index' || $this->uri->segment(2) == 'reset_password'): ?>
						<!-- FAUX FOOTER -->
						<div class="lower_content">
							<?php if ($this->uri->segment(2) && $this->uri->segment(2) != 'index'): ?>
								<strong><?php echo anchor('login/index', ucwords(lang('actions_login') .' '. lang('time_now')));?></strong>
								&nbsp; | &nbsp;
							<?php endif; ?>
	
							<?php if ($this->uri->segment(2) != 'reset_password'): ?>
								<strong><?php echo anchor('login/reset_password', ucwords(lang('actions_reset') .' '. lang('labels_password')));?></strong>
								&nbsp; | &nbsp;
							<?php endif; ?>
	
							<strong><?php echo anchor('main/index', ucfirst(lang('actions_back') .' '. lang('labels_to') .' '. lang('labels_site')));?></strong>
						</div>
					<?php endif; ?>
				</div>
				
				<!-- FOOTER -->
				<div id="footer">
					Powered by <strong><?php echo APP_NAME;?></strong>
				</div>
			</div>
		</div>
	</body>
</html>