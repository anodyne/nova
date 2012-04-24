<?php

function data($obj, $i)
{
	if (is_array($obj))
	{
		return $obj[$i];
	}

	return false;
}

?><form class="form-<?php echo $form->orientation;?>" method="post">
	<?php if ($tabs !== false): ?>
		<ul class="nav nav-tabs">
		<?php foreach ($tabs as $t): ?>
			<li><a href="#<?php echo $t->link_id;?>" data-toggle="tab"><?php echo $t->name;?></a></li>
		<?php endforeach;?>
		</ul>
		
		<div class="tab-content">
		<?php foreach ($tabs as $t): ?>
			<div class="tab-pane" id="<?php echo $t->link_id;?>">
			<?php if (is_array($sections) and array_key_exists($t->id, $sections)): ?>
				<?php foreach ($sections[$t->id] as $s): ?>
					<fieldset>
						<legend><?php echo $s->name;?></legend>

						<?php if (is_array($fields) and array_key_exists($s->id, $fields)): ?>
							<?php foreach ($fields[$s->id] as $f): ?>
								<div class="control-group">
									<label class="control-label"><?php echo $f->label;?></label>
									<div class="controls">
										<?php if ($f->type == 'text'): ?>
											<?php echo Form::input(array('name' => $f->id, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => data($data, $f->id)));?>
										<?php elseif ($f->type == 'textarea'): ?>
											<?php echo Form::textarea(array('name' => $f->id, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => data($data, $f->id), 'rows' => $f->html_rows));?>
										<?php elseif ($f->type == 'select'): ?>
											<?php echo Form::select($f->id, data($data, $f->id), $f->get_values(), array('class' => $f->html_class, 'id' => $f->html_id));?>
										<?php endif;?>

										<?php if ( ! empty($f->help)): ?>
											<p class="help-block"><?php echo $f->help;?></p>
										<?php endif;?>
									</div>
								</div>
							<?php endforeach;?>
						<?php endif;?>
					</fieldset>
				<?php endforeach;?>
			<?php endif;?>
			</div>
		<?php endforeach;?>
		</div>
	<?php else: ?>
		<?php if ($sections !== false): ?>
			<?php foreach ($sections as $s): ?>
				<fieldset>
					<legend><?php echo $s->name;?></legend>

					<?php if (is_array($fields) and array_key_exists($s->id, $fields)): ?>
						<?php foreach ($fields[$s->id] as $f): ?>
							<div class="control-group">
								<label class="control-label"><?php echo $f->label;?></label>
								<div class="controls">
									<?php if ($f->type == 'text'): ?>
										<?php echo Form::input(array('name' => $f->id, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => data($data, $f->id)));?>
									<?php elseif ($f->type == 'textarea'): ?>
										<?php echo Form::textarea(array('name' => $f->id, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => data($data, $f->id), 'rows' => $f->html_rows));?>
									<?php elseif ($f->type == 'select'): ?>
										<?php echo Form::select($f->id, data($data, $f->id), $f->get_values(), array('class' => $f->html_class, 'id' => $f->html_id));?>
									<?php endif;?>

									<?php if ( ! empty($f->help)): ?>
										<p class="help-block"><?php echo $f->help;?></p>
									<?php endif;?>
								</div>
							</div>
						<?php endforeach;?>
					<?php endif;?>
				</fieldset>
			<?php endforeach;?>
		<?php else: ?>
			<?php if ($fields !== false): ?>
				<?php foreach ($fields[$s->id] as $f): ?>
					<div class="control-group">
						<label class="control-label"><?php echo $f->label;?></label>
						<div class="controls">
							<?php if ($f->type == 'text'): ?>
								<?php echo Form::input(array('name' => $f->id, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => data($data, $f->id)));?>
							<?php elseif ($f->type == 'textarea'): ?>
								<?php echo Form::textarea(array('name' => $f->id, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => data($data, $f->id), 'rows' => $f->html_rows));?>
							<?php elseif ($f->type == 'select'): ?>
								<?php echo Form::select($f->id, data($data, $f->id), $f->get_values(), array('class' => $f->html_class, 'id' => $f->html_id));?>
							<?php endif;?>

							<?php if ( ! empty($f->help)): ?>
								<p class="help-block"><?php echo $f->help;?></p>
							<?php endif;?>
						</div>
					</div>
				<?php endforeach;?>
			<?php endif;?>
		<?php endif;?>
	<?php endif;?>

	<div class="controls">
		<button type="submit" class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
	</div>
</form>