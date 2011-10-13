<?php

$sec = 'main';
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

// load the panel helper
$this->load->helper('panel');

// set up the locations of the icons
$panel = array(
	'inbox'		=> array('src' => APPFOLDER.'/views/'.$current_skin.'/'.$sec.'/images/panel-mail.png'),
	'writing'	=> array('src' => APPFOLDER.'/views/'.$current_skin.'/'.$sec.'/images/panel-writing.png'),
	'dashboard'	=> array('src' => APPFOLDER.'/views/'.$current_skin.'/'.$sec.'/images/panel-dashboard.png'),
);

$button_login = array(
	'class' => 'button-signin',
	'value' => 'submit',
	'type' => 'submit',
	'name' => 'submit',
	'content' => ucwords(lang('actions_login'))
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
		
		<?php include_once($this->config->item('include_head_main'));?>
		
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER;?>/views/<?php echo $current_skin;?>/jquery.blockUI.js"></script>
		
		<?php echo $javascript;?>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('body').click(function(event){
					if (! $(event.target).closest('div').hasClass('signin-panel'))
					{
						$.unblockUI();
					}
				});
				
				$('a#userpanel').unbind('click').click(function(){
					$.blockUI({
						message: $('#panel'),
						css: { 
							border: '0', 
							cursor: 'cursor',
							background: 'transparent',
							width: '800px',
							top: '10%',
							left: '50%',
							margin: '0 0 0 -400px'
						}
					});
					
					return false;
				});
			});
			
			// if the escape key is pressed, close the menu
			$(document).keyup(function(event){
				if (event.keyCode == 27) {
					$.unblockUI();
				}
			});
		</script>
	</head>
	<body>
		<noscript>
			<div class="system_warning"><?php echo lang_output('text_javascript_off', '');?></div>
		</noscript>
		
		<?php if (Auth::is_logged_in()): ?>
			<div id="panel" class="hidden">
				<div class="panel-body">
					<table class="table100">
						<tbody>
							<tr>
								<td class="panel_1 align_top"><?php echo $panel_1;?></td>
								<td class="panel_spacer"></td>
								<td class="panel_2 align_top"><?php echo $panel_2;?></td>
								<td class="panel_spacer"></td>
								<td class="panel_3 align_top"><?php echo $panel_3;?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		<?php endif;?>
		
		<header>
			<div class="wrapper">
				<div class="signin-container">
					<?php if ( ! Auth::is_logged_in()): ?>
						<div class="signin-panel corner-upper-left corner-lower-left corner-lower-right">
							<?php echo form_open('login/check_login');?>
								<table>
									<tbody>
										<tr>
											<td>
												<?php echo ucwords(lang('labels_email_address'));?><br>
												<input type="text" name="email" class="signin-panel-input">
											</td>
											<td>
												<?php echo ucfirst(lang('labels_password'));?><br>
												<input type="password" name="password" class="signin-panel-input">
											</td>
											<td class="align_bottom"><?php echo form_button($button_login);?></td>
										</tr>
										<tr>
											<td>
												<input id="remember" type="checkbox" name="remember" value="yes">
												<label for="remember"><?php echo ucfirst(lang('actions_remember').' '.lang('labels_me'));?></label>
											</td>
											<td><?php echo anchor('login/reset_password', lang('login_forgot'));?></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							<?php echo form_close();?>
						</div>
					<?php else: ?>
						<a href="<?php echo site_url('login/logout');?>" class="signin corner-upper-left corner-upper-right corner-lower-left corner-lower-right"><?php echo ucfirst(lang('actions_logout'));?></a>
						
						<div class="logged-in-controls">
							<?php if (Auth::is_logged_in()): ?>
								<?php echo panel_inbox(true, true, false, '(x)', img($panel['inbox']));?> &nbsp;
								<?php echo panel_writing(true, true, false, '(x)', img($panel['writing']));?> &nbsp;
								<?php echo panel_dashboard(false, img($panel['dashboard']));?>
							<?php endif;?>
						</div>
					<?php endif;?>
				</div>
			
				<div style="clear:both;"></div>
				
				<div id="menu">
					<div class="nav-main">
						<?php echo $nav_main;?>
					</div>
				</div>
			</div>
		</header>
		
		<div class="wrapper">
			<div id="body">
				<div class="nav-sub">
					<?php echo $nav_sub;?>
				</div>
			
				<div class="content">
					<?php echo $flash_message;?>
					<?php echo $content;?>
					<?php echo $ajax;?>
				
					<div style="clear:both;"></div>
				</div>
				
				<footer>
					Powered by <strong><?php echo APP_NAME;?></strong> from <a href="http://www.anodyne-productions.com" target="_blank">Anodyne Productions</a> | 
					<?php echo anchor('main/credits', 'Site Credits');?>
				</footer>
			</div>
		</div>
	</body>
</html>