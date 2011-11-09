<?php echo Form::open('admin/manage/forms/field/'.$field->id);?>
	<p>
		<kbd><?php echo ucwords(___("field type"));?></kbd>
	</p>
	
	<p>
		<kbd><?php echo ucwords(___("field name"));?></kbd>
	</p>
	
	<p>
		<kbd><?php echo ucwords(___("field ID"));?></kbd>
	</p>
	
	<p>
		<kbd><?php echo ucwords(___("field class"));?></kbd>
	</p>
	
	<p>
		<kbd><?php echo ucwords(___("field rows"));?></kbd>
	</p>
<?php echo Form::close();?>