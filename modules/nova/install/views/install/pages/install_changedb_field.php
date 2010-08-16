<p>
	<kbd><?php echo __('Database Table');?></kbd>
	<span class="fontSmall subtle"><?php echo __('Which database table do you want your field in?');?></span><br />
	<?php echo form::select('table_name', $options);?>
</p>

<p>
	<kbd><?php echo __('Field Name');?></kbd>
	<span class="fontSmall subtle"><?php echo __('What do you want your field to be called?');?></span><br />
	<?php echo form::input('field_name');?>
</p>

<p>
	<kbd><?php echo __('Field Type');?></kbd>
	<span class="fontSmall subtle"><?php echo __('What kind of data is going to go into the field?');?></span><br />
	<?php echo form::select('field_type', $fieldtypes);?>
</p>

<p>
	<kbd><?php echo __('Field Constraint');?></kbd>
	<span class="fontSmall subtle"><?php echo __("What's the cosntraint for this field?");?></span><br />
	<?php echo form::input('field_constraint');?>
</p>

<p>
	<kbd><?php echo __('Field Default Value');?></kbd>
	<span class="fontSmall subtle"><?php echo __('What do you want the default value of this field to be?');?></span><br />
	<?php echo form::input('field_default');?>
</p>

<p>
	<span class="hidden loading-field"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>
	
	<span class="hidden error-field">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/exclamation-red.png', array('class' => 'inline-image-left'));?>
		<strong class="error"><?php echo __('Field creation failed');?></strong>
	</span>
	
	<span class="hidden success-field">
		<?php echo html::image(MODFOLDER.'/nova/install/views/install/images/tick-circle.png', array('class' => 'inline-image-left'));?>
		<strong class="success"><?php echo __('Field created');?></strong>
	</span>
</p>