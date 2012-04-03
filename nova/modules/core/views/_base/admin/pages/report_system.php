<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($label['systeminfo'], 'h2', 'page-subhead');?>
<p>
	<strong><?php echo $label['url'];?></strong> <?php echo base_url();?><br /><br />
	
	<strong><?php echo $label['version_files'];?></strong> <?php echo $version['files'];?><br />
	<strong><?php echo $label['version_db'];?></strong> <?php echo $version['database'];?><br />
	<strong><?php echo $label['version_ci'];?></strong> <?php echo $version['ci'];?>
</p>

<?php echo text_output($label['versions'], 'h2', 'page-subhead');?>
<?php echo text_output($label['versions_redirect']);?>

<?php echo text_output($label['components'], 'h2', 'page-subhead');?>
<?php echo text_output($label['components_redirect']);?>