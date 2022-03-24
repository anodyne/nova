<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['intro'], 'p', 'fontMedium');?>

<?php if ($this->uri->segment(3) == 'full'): ?>
	<?php echo text_output($label['firststeps'], 'h2', 'page-subhead');?>

	<ul id="options" class="fontLarge none">
		<li>
			<a href="<?php echo site_url('upgrade/readme');?>">
				<?php echo $label['options_readme'];?>
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('upgrade/verify');?>">
				<?php echo $label['options_verify'];?>
			</a>
		</li>
		<li>
			<a href="https://help.anodyne-productions.com/article/nova-1/upgrade" target="_blank">
				<?php echo $label['options_guide'];?>
			</a>
		</li>
	</ul>

	<?php if ($installed === FALSE): ?>
		<?php echo text_output($label['whatsnext'], 'h2', 'page-subhead');?>

		<?php echo $label['text'];?>

		<br />
		<?php echo form_open('upgrade/step/1');?>
			<?php echo form_button($next);?>
		<?php echo form_close();?>
	<?php endif;?>
<?php endif;?>
