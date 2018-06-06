<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['welcome'], 'h2');?>

<?php echo text_output($label['intro'], 'p', 'fontMedium');?>

<?php if ($this->uri->segment(3) == 'full'): ?>
	<br />

	<?php echo text_output($label['firststeps'], 'h2', 'page-subhead');?>

	<ul id="options" class="fontLarge none">
		<li>
			<a href="<?php echo site_url('install/readme');?>">
				<span class="icon ui-icon ui-icon-lightbulb"></span>
				<?php echo $label['options_readme'];?>
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('install/verify');?>">
				<span class="icon ui-icon ui-icon-check"></span>
				<?php echo $label['options_verify'];?>
			</a>
		</li>
		<li>
			<a href="https://help.anodyne-productions.com/article/nova-2/install" target="_blank">
				<span class="icon ui-icon ui-icon-bookmark"></span>
				<?php echo $label['options_guide'];?>
			</a>
		</li>

		<?php if ($installed === TRUE): ?>
			<li>
				<a href="<?php echo site_url('install/remove');?>">
					<span class="icon ui-icon ui-icon-trash"></span>
					<?php echo $label['options_remove'];?>
				</a>
			</li>
		<?php endif;?>
	</ul>

	<?php echo text_output($label['whatsnext'], 'h2', 'page-subhead');?>

	<ul class="fontLarge none">
		<?php if ($installed === FALSE): ?>
			<li>
				<a href="<?php echo site_url('install/step/1');?>" id="install">
					<span class="icon ui-icon ui-icon-newwin"></span>
					<?php echo $label['options_install'];?>
				</a>
			</li>
			<li>
				<a href="<?php echo site_url('upgrade/index');?>">
					<span class="icon ui-icon ui-icon-transferthick-e-w"></span>
					<?php echo $label['options_upgrade'];?>
				</a>
			</li>
		<?php endif;?>

		<?php if ($installed === TRUE): ?>
			<li>
				<a href="<?php echo site_url('update/index');?>">
					<span class="icon ui-icon ui-icon-signal-diag"></span>
					<?php echo $label['options_update'];?>
				</a>
			</li>
			<li>
				<a href="<?php echo site_url('install/genre');?>">
					<span class="icon ui-icon ui-icon-plusthick"></span>
					<?php echo $label['options_genre'];?>
				</a>
			</li>
			<li>
				<a href="<?php echo site_url('install/changedb');?>">
					<span class="icon ui-icon ui-icon-plusthick"></span>
					<?php echo $label['options_database'];?>
				</a>
			</li>
		<?php endif;?>
	</ul>
<?php endif;?>
