<div class="control-group">
	<label class="control-label"><?php echo $f->label;?></label>
	<div class="controls">
		<?php if ($editable): ?>
			<?php if ($f->type == 'text'): ?>
				<?php echo Form::input(array('name' => $f->id, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => data($data, $f->id)));?>
			<?php elseif ($f->type == 'textarea'): ?>
				<?php echo Form::textarea(array('name' => $f->id, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => data($data, $f->id), 'rows' => $f->html_rows));?>
			<?php elseif ($f->type == 'select'): ?>
				<?php echo Form::select($f->id, data($data, $f->id), $f->get_values(), array('class' => $f->html_class, 'id' => $f->html_id));?>
			<?php endif;?>
		<?php else: ?>
			<?php echo data($data, $f->id);?>
		<?php endif;?>

		<?php if ( ! empty($f->help)): ?>
			<p class="help-block"><?php echo $f->help;?></p>
		<?php endif;?>
	</div>
</div>