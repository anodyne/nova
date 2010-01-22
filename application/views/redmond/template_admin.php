<?php
/*
|---------------------------------------------------------------
| TEMPLATE - ADMIN
|---------------------------------------------------------------
|
| File: application/views/redmond/template_admin.php
| Skin Version: 1.0
|
| Main layout file used by the redmond skin.
|
| $sec options are: main, wiki, admin, login
| $css can be anything you want (with a .css extension of course)
|
*/

$sec = 'admin'; /* set the section of the system */
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

/* load the panel helper */
$this->load->helper('panel');

$panel = array(
	'inbox' => array(
		'src' => APPFOLDER .'/views/'. $current_skin .'/'. $sec .'/images/panel-mail.png'),
	'writing' => array(
		'src' => APPFOLDER .'/views/'. $current_skin .'/'. $sec .'/images/panel-writing.png'),
	'dashboard' => array(
		'src' => APPFOLDER .'/views/'. $current_skin .'/'. $sec .'/images/panel-dashboard.png'),
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
		<?php include_once($this->config->item('include_head_admin')); ?>
		
		<?php echo $javascript;?>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('body').click(function(event){
					console.log($(event.target).closest('div'));
					if (! $(event.target).closest('div').hasClass('nav-main'))
					{
						$('.go-button-click').removeClass('active');
						$('.nav-main').addClass('hidden');
					}
				});
				
				$('a.go-button-click').click(function(){
					$('.go-button-click').toggleClass('active');
					$('.nav-main').toggleClass('hidden');
					return false;
				});
			});
			
			/* if the escape key is pressed, close the menu */
			$(document).keyup(function(event){
				if (event.keyCode == 27) {
					$('.go-button-click').removeClass('active');
					$('.nav-main').addClass('hidden');
				}
			});
		</script>
	</head>
	<body>
		<div id="wrap">
			<noscript>
				<span class="UITheme">
					<div class="system_warning ui-state-error"><?php echo lang_output('text_javascript_off', '');?></div>
				</span>
			</noscript>
			
			<?php if ($this->auth->is_logged_in()): ?>
				<!-- USER PANEL -->
				<div id="panel">
					<div class="panel-body">
						<div class="wrapper">
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
				</div>
			<?php endif; ?>
			
			<div id="header">
				<div class="wrapper">
					<div class="go">
						<div class="go-button"><a href="#" class="go-button-click"><?php echo strtoupper(APP_NAME);?></a></div>
						<div class="nav-main hidden"><?php echo $nav_main;?></div>
					</div>
					<div style="float:right">
						<?php if ($this->auth->is_logged_in()): ?>
							<?php echo panel_inbox(TRUE, TRUE, FALSE, '(x)', img($panel['inbox']));?> &nbsp;&nbsp;
							<?php echo panel_writing(TRUE, TRUE, FALSE, '(x)', img($panel['writing']));?> &nbsp;&nbsp;
							<?php echo panel_dashboard(FALSE, img($panel['dashboard']));?>
						<?php else: ?>
							<strong><?php echo anchor('login/index', ucfirst(lang('actions_login')), array('class' => 'login-text'));?></strong>
						<?php endif;?>
					</div>
					<?php echo $title;?>
				</div>
			</div>
		
			<div id="body" class="wrapper clearfix">
				<!-- SUB NAVIGATION -->
				<div class="nav-sub">
					<?php echo $nav_sub;?>
				</div>
				
				<!-- PAGE CONTENT -->
				<div class="content">
					<?php echo $flash_message;?>
					<?php echo $content;?>
					<?php echo $ajax;?>
					
					<div style="clear:both;">&nbsp;</div>
				</div>
			</div>
		</div>
		
		<!-- FOOTER -->
		<div id="footer">
			Powered by <strong><?php echo APP_NAME;?></strong> from <a href="http://www.anodyne-productions.com" target="_blank">Anodyne Productions</a> | 
			<?php echo anchor('main/credits', 'Site Credits');?>
		</div>
	</body>
</html>