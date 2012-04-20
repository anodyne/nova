<p><?php echo lang('[[short.delete_confirm|field|{{'.$name.'}}]]');?></p>

<form method="post">
	<div class="form-actions">
		<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'delete');?>
	</div>
</form>