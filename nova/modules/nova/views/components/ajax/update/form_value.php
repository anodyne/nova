<form class="ajax" method="post" action="<?php echo Uri::create('ajax/update/field_value/'.$id);?>">
	<div class="control-group">
		<label class="control-label"><?php echo lang('content', 1);?></label>
		<div class="controls">
			<?php echo Form::input('content', $content, array('class' => 'span3'));?>
			<p class="help-block"><?php echo lang('short.forms.values_content');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('value', 1);?></label>
		<div class="controls">
			<?php echo Form::input('value', $value, array('class' => 'span3'));?>
			<p class="help-block"><?php echo lang('short.forms.values_value');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('field', 1);?></label>
		<div class="controls">
			<?php echo Form::select('field_id', $field, $fields, array('class' => 'span3'));?>
			<p class="help-block"><?php echo lang('short.forms.values_dropdown_only');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('order', 1);?></label>
		<div class="controls">
			<?php echo Form::input('order', $order, array('class' => 'span1'));?>
			<p class="help-block"><?php echo lang('short.forms.order');?></p>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
		<?php echo Form::hidden('id', $id);?>
	</div>
</form>