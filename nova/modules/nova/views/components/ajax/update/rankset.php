<form method="post">
	<br>
	<div class="control-group">
		<label class="control-label"><?php echo lang('name', 1);?></label>
		<div class="controls">
			<?php echo Form::input('name', $name, array('class' => 'span4'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('order', 1);?></label>
		<div class="controls">
			<?php echo Form::input('order', $order, array('class' => 'span1'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('display', 1);?></label>
		<div class="controls">
			<label class="radio inline"><?php echo lang('on', 1).' '.Form::radio('display', 1, $display);?></label>
			<label class="radio inline"><?php echo lang('off', 1).' '.Form::radio('display', 0, $display);?></label>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'update');?>
	</div>
</form>