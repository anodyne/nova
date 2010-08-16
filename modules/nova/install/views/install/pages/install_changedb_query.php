<p>
	<kbd><?php echo __('Your MySQL Query');?></kbd>
	<span class="fontSmall subtle"><?php echo __('This is the query that will be executed on your Nova database');?></span><br />
	<?php echo form::textarea('query');?>
</p>

<p>
	<span class="hidden loading-query"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>
	
	<span class="hidden error-query">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/exclamation-red.png', array('class' => 'inline-image-left'));?>
		<strong class="error"><?php echo __('Query was not successfully run');?></strong>
	</span>
	
	<span class="hidden success-query">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/tick-circle.png', array('class' => 'inline-image-left'));?>
		<strong class="success"><?php echo __('Query was successfully run');?></strong>
	</span>
	
	<span class="hidden warning-query">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/exclamation.png', array('class' => 'inline-image-left'));?>
		<strong class="warning"><?php echo __('Query was run but no rows were affected');?></strong>
	</span>
	
	<span class="hidden special-query">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/information.png', array('class' => 'inline-image-left'));?>
		<strong class="info"><?php echo __('Query was run but cannot be automatically verified');?></strong>
	</span>
</p>