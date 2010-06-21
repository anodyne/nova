<strong><?php echo Database::instance()->table_prefix();?></strong>
<?php echo form::input('table_name');?>

&nbsp;&nbsp;

<span class="loading-table hidden"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>

<p>
	<span class="hidden error-table">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/exclamation-red.png', array('class' => 'inline-image-left'));?>
		<strong class="error"><?php echo __('changedb.failure_table');?></strong>
	</span>
	
	<span class="hidden success-table">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/tick-circle.png', array('class' => 'inline-image-left'));?>
		<strong class="success"><?php echo __('changedb.success_table');?></strong>
	</span>
</p>