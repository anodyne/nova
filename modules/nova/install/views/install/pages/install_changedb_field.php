<p>
	<kbd><?php echo __('changedb.field_choose');?></kbd>
	<span class="fontSmall subtle"><?php echo __('changedb.field_choose_desc');?></span><br />
	<?php echo form::select('table_name', $options);?>
</p>

<p>
	<kbd><?php echo __('changedb.field_name');?></kbd>
	<span class="fontSmall subtle"><?php echo __('changedb.field_name_desc');?></span><br />
	<?php echo form::input('field_name');?>
</p>

<p>
	<kbd><?php echo __('changedb.field_type');?></kbd>
	<span class="fontSmall subtle"><?php echo __('changedb.field_type_desc');?></span><br />
	<?php echo form::select('field_type', $fieldtypes);?>
</p>

<p>
	<kbd><?php echo __('changedb.field_constraint');?></kbd>
	<span class="fontSmall subtle"><?php echo __('changedb.field_constraint_desc');?></span><br />
	<?php echo form::input('field_constraint');?>
</p>

<p>
	<kbd><?php echo __('changedb.field_default');?></kbd>
	<span class="fontSmall subtle"><?php echo __('changedb.field_default_desc');?></span><br />
	<?php echo form::input('field_default');?>
</p>

<p>
	<span class="hidden loading-field"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>
	
	<span class="hidden error-field">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/exclamation-red.png', array('class' => 'inline-image-left'));?>
		<strong class="error"><?php echo __('changedb.failure_field');?></strong>
	</span>
	
	<span class="hidden success-field">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/tick-circle.png', array('class' => 'inline-image-left'));?>
		<strong class="success"><?php echo __('changedb.success_field');?></strong>
	</span>
</p>