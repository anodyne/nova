<p>
	<kbd><?php echo __('changedb.field_query');?></kbd>
	<span class="fontSmall subtle"><?php echo __('changedb.field_query_desc');?></span><br />
	<?php echo form::textarea('query');?>
</p>

<p>
	<span class="hidden loading-query"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>
	
	<span class="hidden error-query">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/exclamation-red.png', array('class' => 'inline-image-left'));?>
		<strong class="error"><?php echo __('changedb.failure_query');?></strong>
	</span>
	
	<span class="hidden success-query">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/tick-circle.png', array('class' => 'inline-image-left'));?>
		<strong class="success"><?php echo __('changedb.success_query');?></strong>
	</span>
</p>