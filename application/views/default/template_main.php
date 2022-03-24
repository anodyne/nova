<?php

$path = explode('/', dirname(__FILE__));

// Windows servers user back slashes, so we have to capture for that
if (count($path) <= 1) {
    $path = explode('\\', dirname(__FILE__));
}

$pcount = count($path);
$skin_loc = $pcount -1;
$current_skin = $path[$skin_loc];

$stylesheet = [
    'href' => APPFOLDER.'/views/'.$current_skin.'/dist/css/app.css',
    'rel' => 'stylesheet',
    'type' => 'text/css',
    'media' => 'screen',
    'charset' => 'utf-8'
];

$colors = [
    'href' => APPFOLDER.'/views/'.$current_skin.'/dist/css/colors.css',
    'rel' => 'stylesheet',
    'type' => 'text/css',
    'media' => 'screen',
    'charset' => 'utf-8'
];

// load the panel helper
$this->load->helper('panel');

// set up the locations of the icons
$panel = [
    'inbox' => ['src' => APPFOLDER.'/views/'.$current_skin.'/dist/images/panel-mail.png'],
    'writing' => ['src' => APPFOLDER.'/views/'.$current_skin.'/dist/images/panel-writing.png'],
    'dashboard' => ['src' => APPFOLDER.'/views/'.$current_skin.'/dist/images/panel-dashboard.png'],
];

$alternateLogoJpg = APPFOLDER.'/views/'.$current_skin.'/dist/images/logo.jpg';
$alternateLogoPng = APPFOLDER.'/views/'.$current_skin.'/dist/images/logo.png';
$alternateLogoSvg = APPFOLDER.'/views/'.$current_skin.'/dist/images/logo.svg';

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>

		<meta name="description" content="<?php echo $this->config->item('meta_desc');?>" />
		<meta name="keywords" content="<?php echo $this->config->item('meta_keywords');?>" />
		<meta name="author" content="<?php echo $this->config->item('meta_author');?>" />

		<?php echo $_redirect;?>

		<?php echo link_tag($stylesheet);?>
		<?php echo link_tag($colors);?>

		<?php include_once($this->config->item('include_head_main'));?>

		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER;?>/views/<?php echo $current_skin;?>/dist/js/jquery.blockUI.js"></script>

		<?php echo $javascript;?>

		<script type="text/javascript">
			$(document).ready(function(){
				$('body').click(function(event){
					if (! $(event.target).closest('div').hasClass('signin-panel')) {
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
			$(document).keyup(function(event) {
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
				<div class="logo">
					<?php if (file_exists($alternateLogoPng)): ?>
						<?php echo img($alternateLogoPng, false, 'alt="logo"');?>
					<?php elseif (file_exists($alternateLogoSvg)): ?>
						<?php echo img($alternateLogoSvg, false, 'alt="logo"');?>
					<?php elseif (file_exists($alternateLogoJpg)): ?>
						<?php echo img($alternateLogoJpg, false, 'alt="logo"');?>
					<?php else: ?>
						<svg viewBox="0 0 636 170" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path fill="currentColor" class="text-primary-600" d="m297.649 145.332-76.732-68.974v68.974h-26.916V24.01h3.374l76.904 69.129V24.01h27.001v121.322zM366.142 48.864c-14.175 0-21.666 7.492-21.666 21.666v28.94c0 14.174 7.491 21.666 21.666 21.666h9.647c14.175 0 21.666-7.492 21.666-21.665V70.529c0-14.173-7.491-21.665-21.666-21.665h-9.647zm0 96.468c-30.86 0-45.863-15.001-45.863-45.861V70.529c0-30.861 15.002-45.863 45.863-45.863h9.647c30.86 0 45.862 15.001 45.862 45.864v28.94c0 30.86-15.002 45.862-45.862 45.862h-9.647zM483.241 145.332l-58.076-121.01h27.47l32.312 67.904 32.397-67.904h27.782l-58.299 121.01zM562.826 105.922h23.707L574.76 81.015l-11.934 24.907zm44.325 39.41-9.325-19.113h-46.295l-9.327 19.113H514.18l58.358-120.854h4.285l58.434 120.854h-28.105z"/><path d="M169.806 5.905 127.731 47.98c2.488 4.792 1.724 10.835-2.298 14.856-4.968 4.97-13.025 4.97-17.993 0-4.969-4.969-4.969-13.025 0-17.994 4.021-4.02 10.063-4.785 14.855-2.297L164.37.47 40.962 49.778l8.374 71.161 71.161 8.374 49.31-123.408z" fill="currentColor" class="text-primary-600" /><path d="m120.496 129.312-71.16-8.373 58.103-58.103c4.971 4.971 13.023 4.971 17.994 0 4.021-4.02 4.786-10.06 2.294-14.856l42.078-42.077-49.309 123.41z" fill="currentColor" class="text-primary-600"/><path fill="currentColor" class="text-primary-600" d="m43.907 126.366 5.972 22.332L.744 169.53l20.832-49.135z"/><path fill="currentColor" class="text-primary-600" d="M49.88 148.7.746 169.528l43.162-43.163z"/></g></svg>
					<?php endif;?>
				</div>

				<nav class="nav-main">
					<?php echo $nav_main;?>
				</nav>

				<div class="signin-container">
					<?php if (Auth::is_logged_in()): ?>
						<div class="logged-in-controls">
							<span>
								<?php echo panel_inbox(true, true, false, '(x)', img($panel['inbox']));?>
							</span>
							<span>
								<?php echo panel_writing(true, true, false, '(x)', img($panel['writing']));?>
							</span>
							<span>
								<?php echo panel_dashboard(false, img($panel['dashboard']));?>
							</span>
						</div>

						<a href="<?php echo site_url('login/logout');?>" class="signin corner-upper-left corner-upper-right corner-lower-left corner-lower-right"><?php echo ucfirst(lang('actions_logout'));?></a>
					<?php endif;?>
				</div>
			</div>
		</header>

		<div class="wrapper">
			<main>
				<nav class="nav-sub">
					<?php echo $nav_sub;?>
				</nav>

				<div class="content">
					<?php echo $flash_message;?>
					<?php echo $content;?>
					<?php echo $ajax;?>

					<div class="clear_both"></div>
				</div>

				<footer>
					<span>
						Powered by <strong><?php echo APP_NAME;?></strong> from <a href="https://anodyne-productions.com" target="_blank">Anodyne</a>
					</span>
					<span><?php echo anchor('main/credits', 'Site Credits');?></span>
					<span><?php echo anchor('main/policies', 'Privacy Policy'); ?></span>
				</footer>
			</main>
		</div>
	</body>
</html>
