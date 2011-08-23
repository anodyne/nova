<p>
	<kbd>Database Table</kbd>
	<span class="fontSmall subtle">Which database table do you want your field in?</span><br>
	<?php echo Form::select('table_name', $options);?>
</p>

<p>
	<kbd>Field Name</kbd>
	<span class="fontSmall subtle">What do you want your field to be called?</span><br>
	<?php echo Form::input('field_name');?>
</p>

<p>
	<kbd>Field Type</kbd>
	<span class="fontSmall subtle">What kind of data is going to go into the field?</span><br>
	<?php echo Form::select('field_type', $fieldtypes);?>
</p>

<p>
	<kbd>Field Constraint</kbd>
	<span class="fontSmall subtle">What's the constraint for this field?</span><br>
	<?php echo Form::input('field_constraint');?>
</p>

<p>
	<kbd>Field Default Value</kbd>
	<span class="fontSmall subtle">What do you want the default value of this field to be?</span><br>
	<?php echo Form::input('field_default');?>
</p>

<p>
	<span class="hidden loading-field"><?php echo Html::image($images['loading']['src'], $images['loading']['attr']);?></span>
	
	<span class="hidden error-field">
		<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'inline-image-left'));?>
		<strong class="error">Field creation failed</strong>
	</span>
	
	<span class="hidden success-field">
		<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png', array('class' => 'inline-image-left'));?>
		<strong class="success">Field created</strong>
	</span>
</p>