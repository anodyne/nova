<?php
/*
|---------------------------------------------------------------
| TEMPLATE - WIKI
|---------------------------------------------------------------
|
| File: application/views/lightness/template_wiki.php
| Skin Version: 1.0
|
| Wiki layout file used by the lightness skin.
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
		
		<?php echo $javascript;?>
	</head>
	<body>
		<noscript>
			<span class="UITheme">
				<div class="system_warning ui-state-error"><?php echo lang_output('text_javascript_off', '');?></div>
			</span>
		</noscript>
		
		<?php if ($this->session->userdata('userid') !== FALSE): ?>
			<!-- USER PANEL -->
			<div id="panel" class="UITheme">
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
				<div class="panel-handle">
					<div class="wrapper">
						<?php echo $panel_workflow;?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
		<!-- HEAD -->
		<div id="head">
			<div class="wrapper">
				<div id="menu">
					<div class="nav-main">
						<?php echo $nav_main;?>
					</div>
				</div>
				
				<div class="head_content">
					<?php echo img(APPFOLDER .'/views/'. $current_skin .'/'. $sec .'/images/head-logo.png', FALSE);?>
				</div>
			</div>
		</div>
		
		<div id="lower-head">
			<div class="wrapper head-content">
				<?php
				
				$this->load->helper('text');
				
				$created = $this->wiki->get_recently_created(2);
				$updated = $this->wiki->get_recently_updated(2);
				
				if ($updated->num_rows() > 0)
				{
					echo '<div class="right">';
						echo '<h2>'. ucwords(lang('status_recently') .' '. lang('actions_updated')) .'</h2>';
						
						echo '<ul>';
						foreach ($updated->result() as $u)
						{
							echo '<li>';
							echo '<strong>'. anchor('wiki/view/page/'. $u->page_id, $u->draft_title .' '. RARROW) .'</strong><br />';
							echo '<span class="fontSmall">'. word_limiter($u->draft_summary, 25) .'</span>';
							echo '</li>';
						}
						echo '</ul>';
					echo '</div>';
				}
				
				if ($created->num_rows() > 0)
				{
					echo '<h2>'. ucwords(lang('status_recently') .' '. lang('actions_created')) .'</h2>';
					
					echo '<ul>';
					foreach ($created->result() as $c)
					{
						echo '<li>';
						echo '<strong>'. anchor('wiki/view/page/'. $c->page_id, $c->draft_title .' '. RARROW) .'</strong><br />';
						echo '<span class="fontSmall">'. word_limiter($c->draft_summary, 25) .'</span>';
						echo '</li>';
					}
					echo '</ul>';
				}
				else
				{
					echo '<h1>'. $this->options['sim_name'] .'</h1>';
				}
				
				?>
			</div>
		</div>
		
		<!-- BODY -->
		<div id="body">
			<div class="wrapper">
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