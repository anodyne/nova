<?php

$sec = 'login';

$path = explode('/', dirname(__FILE__));

// Windows servers user back slashes, so we have to capture for that
if (count($path) <= 1) {
    $path = explode('\\', dirname(__FILE__));
}

$pcount = count($path);
$skin_loc = $pcount -1;
$current_skin = $path[$skin_loc];

$stylesheet = [
    'href' => APPFOLDER.'/views/'.$current_skin.'/dist/css/login.css',
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

		<?php include_once MODFOLDER.'/assets/include_head_login_next.php';?>

		<?php echo $javascript;?>
	</head>
	<body>
		<noscript>
			<div class="system_warning"><?php echo lang_output('text_javascript_off', '');?></div>
		</noscript>

		<div class="container">
			<div class="head">
				<div class="logo">
					<?php if (file_exists($alternateLogoPng)): ?>
						<?php echo img($alternateLogoPng, false, 'alt="logo"');?>
					<?php elseif (file_exists($alternateLogoSvg)): ?>
						<?php echo img($alternateLogoSvg, false, 'alt="logo"');?>
					<?php elseif (file_exists($alternateLogoJpg)): ?>
						<?php echo img($alternateLogoJpg, false, 'alt="logo"');?>
					<?php else: ?>
						<svg viewBox="0 0 170 170" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M169.806 5.905 127.731 47.98c2.488 4.792 1.724 10.835-2.298 14.856-4.968 4.97-13.025 4.97-17.993 0-4.969-4.969-4.969-13.025 0-17.994 4.021-4.02 10.063-4.785 14.855-2.297L164.37.47 40.962 49.778l8.374 71.161 71.161 8.374 49.31-123.408h-.001Z" fill="currentColor" class="text-primary-600"/><path fill-rule="evenodd" clip-rule="evenodd" d="m120.496 129.312-71.16-8.373 58.103-58.103c4.971 4.971 13.023 4.971 17.994 0 4.021-4.02 4.786-10.06 2.294-14.856l42.078-42.077-49.309 123.41v-.001Z" fill="currentColor" class="text-primary-600"/><path fill-rule="evenodd" clip-rule="evenodd" d="m43.907 126.366 5.972 22.332L.744 169.53l20.832-49.135 22.331 5.971Z" fill="currentColor" class="text-primary-600"/><path fill-rule="evenodd" clip-rule="evenodd" d="M49.88 148.7.746 169.528l43.162-43.163L49.88 148.7Z" fill="currentColor" class="text-primary-600"/></svg>
					<?php endif;?>
				</div>

				<h2 class="title"><?php echo $this->options['sim_name'];?></h2>
			</div>

			<div class="body">
				<div class="card">
					<?php echo $flash_message;?>
					<?php echo $content;?>
				</div>
			</div>
		</div>
	</body>
</html>