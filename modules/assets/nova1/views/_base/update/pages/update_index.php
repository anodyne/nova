<?php echo text_output($label['intro'], 'p', 'fontMedium');?>

<?php if ($this->uri->segment(3) == 'full'): ?>
	<?php echo text_output($label['firststeps'], 'h2', 'page-subhead');?>
	
	<ul id="options" class="fontLarge none">
		<li>
			<a href="http://docs.anodyne-productions.com/index.php/nova/tour" target="_blank">
				<?php echo $label['options_tour'];?>
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('update/readme');?>">
				<?php echo $label['options_readme'];?>
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('update/verify');?>">
				<?php echo $label['options_verify'];?>
			</a>
		</li>
		<li>
			<a href="http://docs.anodyne-productions.com/index.php/nova/overview/update" target="_blank">
				<?php echo $label['options_guide'];?>
			</a>
		</li>
	</ul>
	
	<?php if ($installed === true): ?>
		<?php echo text_output($label['whatsnext'], 'h2', 'page-subhead');?>
		
		<ul class="fontLarge none">
			<li>
				<a href="<?php echo site_url('update/check');?>" id="install">
					<?php echo $label['options_check'];?>
				</a>
			</li>
		</ul>
	<?php endif;?>
<?php endif;?>