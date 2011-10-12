<?php

$sec = 'login';
$css = 'main.css';

$path = explode('/', dirname(__FILE__));

// Windows servers user back slashes, so we have to capture for that
if (count($path) <= 1)
	$path = explode('\\', dirname(__FILE__));

$pcount = count($path);
$skin_loc = $pcount -1;
$current_skin = $path[$skin_loc];

// set the final style location
$style_loc = APPFOLDER.'/views/'.$current_skin.'/'.$sec.'/css/'. $css;

// set up the link tag parameters
$link = array(
	'href'	=> 	$style_loc,
	'rel'	=> 	'stylesheet',
	'type'	=> 	'text/css',
	'media'		=> 'screen',
	'charset'	=> 'utf-8'
);

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		
		<meta name="description" content="<?php echo $this->config->item('meta_desc');?>" />
		<meta name="keywords" content="<?php echo $this->config->item('meta_keywords');?>" />
		<meta name="author" content="<?php echo $this->config->item('meta_author');?>" />
		
		<?php echo $_redirect;?>
		
		<?php echo link_tag($link);?>
		
		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<?php include_once($this->config->item('include_head_login'));?>
		
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER;?>/views/<?php echo $current_skin;?>/jquery.blockUI.js"></script>
		
		<?php echo $javascript;?>
	</head>
	<body>
		<h1 id="name"><?php echo $this->options['sim_name'];?></h1>
		<section>
			<div class="wrapper">
				<div class="content">
					<?php echo $flash_message;?>
					<?php echo $content;?>
				</div>
				
				<footer>
					<?php if ($this->uri->segment(2) and $this->uri->segment(2) !== 'index'): ?>
						<strong><?php echo anchor('login/index', ucwords(lang('actions_login') .' '. lang('time_now')));?></strong>
						&nbsp; | &nbsp;
					<?php endif; ?>

					<?php if ($this->uri->segment(2) !== 'reset_password'): ?>
						<strong><?php echo anchor('login/reset_password', ucwords(lang('actions_reset') .' '. lang('labels_password')));?></strong>
						&nbsp; | &nbsp;
					<?php endif; ?>

					<strong><?php echo anchor('main/index', ucfirst(lang('actions_back') .' '. lang('labels_to') .' '. lang('labels_site')));?></strong>
					
					<br><br>
					
					Powered by <strong><?php echo APP_NAME;?></strong>
				</footer>
			</div>
		</section>
	</body>
</html>