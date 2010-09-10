<?php echo lang_output('upd_index_options_firststeps', 'h2');?>

<ul>
	<li>
		<a href="http://docs.anodyne-productions.com/index.php/nova/tour" target="_blank">
			<?php echo lang('upd_index_options_tour');?>
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('update/readme');?>">
			<?php echo lang('upd_index_options_readme');?>
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('update/verify');?>">
			<?php echo lang('upd_index_options_verify');?>
		</a>
	</li>
	<li>
		<a href="http://docs.anodyne-productions.com/index.php/nova/overview/update" target="_blank">
			<?php echo lang('upd_index_options_upd_guide');?>
		</a>
	</li>
</ul>

<?php if ($installed === TRUE): ?>
	<?php echo lang_output('upd_index_options_whatsnext', 'h2');?>
	
	<ul class="fontLarge none">
		<li>
			<a href="<?php echo site_url('update/check');?>" id="install">
				<?php echo lang('upd_index_options_update');?>
			</a>
		</li>
	</ul>
<?php endif;?>