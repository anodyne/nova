<p><?php echo lang('[[short.delete_confirm|rank group|{{'.$name.'}}]]');?></p>

<form method="post">
	<br>
	<div class="control-group">
		<?php echo Form::select('new_group', 0, $groups, array('class' => 'span4'));?>
		<p class="help-block"><?php echo lang('[[short.ranks.change_group|rank|ranks]]');?></p>
	</div>

	<div class="control-group">
		<label class="checkbox"><input type="checkbox" name="delete_ranks" value="1"> <?php echo lang('action.delete ranks', 1);?></label>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'delete');?>
	</div>
</form>