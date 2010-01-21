<?php echo text_output($label['intro'], 'p', 'fontMedium');?>

<?php echo text_output($label['firststeps'], 'h2', 'page-subhead');?>

<ul id="options" class="fontLarge none">
	<li>
		<a href="http://docs.anodyne-productions.com/index.php/nova/tour" target="_blank">
			<span class="icon ui-icon ui-icon-search"></span>
			<?php echo $label['options_tour'];?>
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('upgrade/readme');?>">
			<span class="icon ui-icon ui-icon-lightbulb"></span>
			<?php echo $label['options_readme'];?>
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('upgrade/verify');?>">
			<span class="icon ui-icon ui-icon-check"></span>
			<?php echo $label['options_verify'];?>
		</a>
	</li>
	<li>
		<a href="http://docs.anodyne-productions.com/index.php/nova/overview/upgrade" target="_blank">
			<span class="icon ui-icon ui-icon-bookmark"></span>
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