<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo lang_output('install_index_options_firststeps', 'h3');?>

<ul>
	<li>
		<a href="<?php echo site_url('install/readme');?>">
			<?php echo lang('install_index_options_readme');?>
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('install/verify');?>">
			<?php echo lang('install_index_options_verify');?>
		</a>
	</li>
	<li>
		<a href="https://help.anodyne-productions.com/article/nova-2/install" target="_blank">
			<?php echo lang('install_index_options_guide');?>
		</a>
	</li>

	<?php if ($installed === TRUE): ?>
		<li>
			<a href="<?php echo site_url('install/remove');?>">
				<?php echo lang('install_index_options_remove');?>
			</a>
		</li>
	<?php endif;?>
</ul>

<?php echo lang_output('install_index_options_whatsnext', 'h3');?>

<ul>
	<?php if ($installed === FALSE): ?>
		<li>
			<a href="<?php echo site_url('install/step/1');?>" id="install">
				<?php echo lang('install_index_options_install');?>
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('upgrade/index');?>">
				<?php echo lang('install_index_options_upgrade');?>
			</a>
		</li>
	<?php endif;?>

	<?php if ($installed === TRUE): ?>
		<li>
			<a href="<?php echo site_url('update/index');?>">
				<?php echo lang('install_index_options_update');?>
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('install/genre');?>">
				<?php echo lang('install_index_options_genre');?>
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('install/changedb');?>">
				<?php echo lang('install_index_options_database');?>
			</a>
		</li>
	<?php endif;?>
</ul>
