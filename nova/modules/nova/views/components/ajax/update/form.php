<form method="post">
	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(__('name'));?></label>
		<div class="controls">
			<?php echo Form::input('name', $name, array('class' => 'span3'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(__('orientation'));?></label>
		<div class="controls">
			<?php echo Form::select('orientation', $orientation, $values, array('class' => 'span3'));?>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo ucfirst(__('action.submit'));?></button>
		<?php echo Form::hidden('id', $id);?>
	</div>
</form>