<p><?php echo lang('[[short.delete_confirm|section|{{'.$name.'}}]]');?></p>
<br>

<form method="post">
	<?php if (count($sections) > 0): ?>
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls">
				<?php echo Form::select('new_section_id', false, $sections, array('class' => 'span3'));?>
				<p class="help-block"><?php echo lang('[[short.forms.section_update_fields|{{'.$name.'}}]]');?></p>
			</div>
		</div>
	<?php else: ?>
		<?php echo Form::hidden('new_section_id', 0);?>
	<?php endif;?>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'delete');?>
	</div>
</form>