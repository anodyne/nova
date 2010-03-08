<?php echo lang_output('upd_index_options_firststeps', 'h2');?>

<ul>
	<li>
		<a href="http://docs.anodyne-productions.com/index.php/nova/tour" target="_blank">
			<?php echo lang('install_index_options_tour');?>
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('upgrade/readme');?>">
			<?php echo lang('install_index_options_readme');?>
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('upgrade/verify');?>">
			<?php echo lang('install_index_options_verify');?>
		</a>
	</li>
	<li>
		<a href="http://docs.anodyne-productions.com/index.php/nova/overview/upgrade" target="_blank">
			<?php echo lang('install_index_options_upg_guide');?>
		</a>
	</li>
</ul>

<?php if ($installed === FALSE): ?>
	<?php echo lang_output('upd_index_options_whatsnext', 'h2');?>
	
	<ul>
		<li>
			<a href="<?php echo site_url('upgrade/info');?>" id="install">
				<?php echo lang('button_begin');?>
			</a>
		</li>
	</ul>
<?php endif;?>