<p><?php echo __('short.delete_confirm', array('object' => __('field'), 'name' => $name));?></p>

<form method="post">
	<div class="form-actions">
		<button class="btn close-dialog"><?php echo ucfirst(__('action.cancel'));?></button>
		<button class="btn btn-primary"><?php echo ucfirst(__('action.submit'));?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'delete');?>
	</div>
</form>