<form method="post">
	<div class="control-group">
		<label class="control-label"><?php echo lang('name', 1);?></label>
		<div class="controls">
			<?php echo Form::input('name', $name, array('class' => 'span4'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('short_name', 1);?></label>
		<div class="controls">
			<?php echo Form::input('short_name', $short_name, array('class' => 'span4'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('order', 1);?></label>
		<div class="controls">
			<?php echo Form::input('order', $order, array('class' => 'span1'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('group', 1);?></label>
		<div class="controls">
			<?php echo Form::input('group', $group, array('class' => 'span1'));?>
			<p class="help-block"><?php echo lang('short.ranks.info_group_explain');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('display', 1);?></label>
		<div class="controls">
			<label class="radio inline"><?php echo lang('on', 1).' '.Form::radio('status', Status::ACTIVE, $display);?></label>
			<label class="radio inline"><?php echo lang('off', 1).' '.Form::radio('status', Status::INACTIVE, $display);?></label>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', $action);?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
</form>