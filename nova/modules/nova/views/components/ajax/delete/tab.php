<p><?php echo lang('[[short.delete_confirm|tab|{{'.$name.'}}]]');?></p>

<form method="post">
	<?php if (count($tabs) > 0): ?>
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls">
				<?php echo Form::select('new_tab_id', false, $tabs, array('class' => 'span3'));?>
				<p class="help-block"><?php echo lang('[[short.forms.tab_update_sections|{{'.$name.'}}]]');?></p>
			</div>
		</div>
	<?php else: ?>
		<?php echo Form::hidden('new_tab_id', 0);?>
	<?php endif;?>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'delete');?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
</form>