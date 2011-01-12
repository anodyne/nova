<?php
/*
|---------------------------------------------------------------
| TEMPLATE - WIKI
|---------------------------------------------------------------
|
| File: application/views/default/template_wiki.php
| Skin Version: 1.0
|
| Wiki layout file used by the default skin.
|
| $sec options are: main, wiki, admin, login
| $css can be anything you want (with a .css extension of course)
|
*/

$sec = 'wiki'; /* set the section of the system */
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

$this->load->helper('panel');

$panel = array(
	'inbox' => array(
		'src' => APPFOLDER .'/views/'. $current_skin .'/'. $sec .'/images/panel-mail.png'),
	'writing' => array(
		'src' => APPFOLDER .'/views/'. $current_skin .'/'. $sec .'/images/panel-writing.png'),
	'dashboard' => array(
		'src' => APPFOLDER .'/views/'. $current_skin .'/'. $sec .'/images/panel-dashboard.png'),
);

$button_login = array(
	'class' => 'button-signin',
	'value' => 'submit',
	'type' => 'submit',
	'name' => 'submit',
	'content' => ucfirst(lang('actions_login'))
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
		<?php include_once($this->config->item('include_head_wiki')); ?>
		
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER;?>/views/<?php echo $current_skin;?>/jquery.blockUI.js"></script>
		
		<?php echo $javascript;?>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('body').click(function(event){
					if (! $(event.target).closest('div').hasClass('signin-panel'))
					{
						$('.signin-panel').hide();
						$('a#signin').addClass('corner-lower-left').addClass('corner-lower-right').removeClass('signin-active');
						
						$.unblockUI();
					}
				});
				
				$('a#signin').click(function(e){
					$('.signin-panel').toggle();
					$('a#signin').toggleClass('corner-lower-left').toggleClass('corner-lower-right').toggleClass('signin-active');
					$('.signin-panel input:first').focus();
					
					return false;
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
			
			/* if the escape key is pressed, close the menu */
			$(document).keyup(function(event){
				if (event.keyCode == 27) {
					$('.signin-panel').hide();
					$('a#signin').addClass('corner-lower-left').addClass('corner-lower-right').removeClass('signin-active');
					
					$.unblockUI();
				}
			});
		</script>
	</head>
	<body>
		<noscript>
			<div class="system_warning"><?php echo lang_output('text_javascript_off', '');?></div>
		</noscript>
		
		<?php if ($this->auth->is_logged_in()): ?>
			<!-- USER PANEL -->
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
		<?php endif; ?>
		
		<!-- HEAD -->
		<div id="head"></div>
		
		<!-- BODY -->
		<div class="wrapper">
			<div id="body">
				<div id="upper-body">
					<div class="signin-container">
						<?php if (!$this->auth->is_logged_in()): ?>
							<div class="signin-panel corner-upper-left corner-lower-left corner-lower-right">
								<?php echo form_open('login/check_login');?>
									<p>
										<?php echo ucfirst(lang('labels_email'));?><br />
										<input type="text" name="email" class="signin-panel-input" />
									</p>
							
									<p>
										<?php echo ucfirst(lang('labels_password'));?><br />
										<input type="password" name="password" class="signin-panel-input">
									</p>
							
									<p>
										<?php echo form_button($button_login);?>
										&nbsp;&nbsp;
										<input id="remember" type="checkbox" name="remember" value="yes" />
										<label for="remember"><?php echo ucfirst(lang('actions_remember') .' '. lang('labels_me'));?></label>
									</p>
							
									<p><?php echo anchor('login/reset_password', lang('login_forgot'));?></p>
								<?php echo form_close();?>
							</div>
							<a href="<?php echo site_url('login/index');?>" id="signin" class="signin corner-upper-left corner-upper-right corner-lower-left corner-lower-right"><?php echo ucfirst(lang('actions_login'));?></a>
							
							<div class="logged-in-controls"></div>
						<?php else: ?>
							<a href="<?php echo site_url('login/logout');?>" class="signin corner-upper-left corner-upper-right corner-lower-left corner-lower-right"><?php echo ucfirst(lang('actions_logout'));?></a>
							
							<div class="logged-in-controls">
								<?php if ($this->auth->is_logged_in()): ?>
									<?php echo panel_inbox(TRUE, TRUE, FALSE, '(x)', img($panel['inbox']));?> &nbsp;
									<?php echo panel_writing(TRUE, TRUE, FALSE, '(x)', img($panel['writing']));?> &nbsp;
									<?php echo panel_dashboard(FALSE, img($panel['dashboard']));?>
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
				
				<!-- SUB NAVIGATION -->
				<div class="nav-sub">
					<?php echo $nav_sub;?>
				</div>
			
				<!-- PAGE CONTENT -->
				<div class="content">
					<?php echo $flash_message;?>
					<?php echo $content;?>
					<?php echo $ajax;?>
				
					<div style="clear:both;"></div>
				</div>
				
				<!-- FOOTER -->
				<div id="footer">
					Powered by <strong><?php echo APP_NAME;?></strong> from <a href="http://www.anodyne-productions.com" target="_blank">Anodyne Productions</a> | 
					<?php echo anchor('main/credits', 'Site Credits');?>
				</div>
			</div>
		</div>
	</body>
</html>