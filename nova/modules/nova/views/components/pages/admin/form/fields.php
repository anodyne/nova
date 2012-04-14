<?php if ($tabs !== false): ?>
	<?php foreach ($tabs as $t): ?>
		<h2><?php echo ucfirst(__('tab'));?>: <?php echo $t->name;?></h2>
		<div class="well">
			<?php if (array_key_exists($t->id, $sections)): ?>
				<?php foreach ($sections[$t->id] as $s): ?>
					<fieldset>
						<legend><?php echo ucfirst(__('section'));?>: <?php echo $s->name;?></legend>

						<?php if (array_key_exists($s->id, $fields)): ?>
							<table class="sort">
								<tbody class="sort-body">
								<?php foreach ($fields[$s->id] as $f): ?>
									<tr id="field_<?php echo $f->id;?>">
										<td class="span9 control-group">
											<label class="control-label"><?php echo $f->label;?></label>
											<div class="controls">
												<?php if ($f->type == 'text'): ?>
													<?php echo Form::input(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value));?>
												<?php elseif ($f->type == 'textarea'): ?>
													<?php echo Form::textarea(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value, 'rows' => $f->html_rows));?>
												<?php elseif ($f->type == 'select'): ?>
													<?php echo Form::select($f->html_name, $f->value, $f->get_values(), array('class' => $f->html_class, 'id' => $f->html_id));?>
												<?php else: ?>
													Not done yet.
												<?php endif;?>
											</div>
										</td>
										<td class="span2 btn-group">
											<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo ucfirst(__('action.edit')).' '.$f->label;?>"><?php echo ucfirst(__('action.edit'));?></a>
											<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo ucfirst(__('action.delete')).' '.$f->label;?>"><?php echo ucfirst(__('action.delete'));?></a>
										</td>
										<td class="span1 reorder"></td>
									</tr>
								<?php endforeach;?>
								</tbody>
							</table>
						<?php endif;?>
					</fieldset>
				<?php endforeach;?>
			<?php endif;?>
		</div>
	<?php endforeach;?>
<?php else: ?>
	<?php if ($sections !== false): ?>
		<?php foreach ($sections as $s): ?>
			<fieldset>
				<legend><?php echo ucfirst(__('section'));?>: <?php echo $s->name;?></legend>

				<?php if (array_key_exists($s->id, $fields)): ?>
					<table>
						<tbody>
						<?php foreach ($fields[$s->id] as $f): ?>
							<tr>
								<td class="span10 control-group">
									<label class="control-label"><?php echo $f->label;?></label>
									<div class="controls">
										<?php if ($f->type == 'text'): ?>
											<?php echo Form::input(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value));?>
										<?php elseif ($f->type == 'textarea'): ?>
											<?php echo Form::textarea(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value, 'rows' => $f->html_rows));?>
										<?php elseif ($f->type == 'select'): ?>
											<?php echo Form::select($f->html_name, $f->value, $f->get_values(), array('class' => $f->html_class, 'id' => $f->html_id));?>
										<?php else: ?>
											Not done yet.
										<?php endif;?>
									</div>
								</td>
								<td class="span2">
									<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo ucfirst(__('action.edit')).' '.$f->label;?>"><?php echo ucfirst(__('action.edit'));?></a>
									<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo ucfirst(__('action.delete')).' '.$f->label;?>"><?php echo ucfirst(__('action.delete'));?></a>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php endif;?>
			</fieldset>
		<?php endforeach;?>
	<?php else: ?>
		<?php if ($fields !== false): ?>
			<table>
				<tbody>
				<?php foreach ($fields as $f): ?>
					<tr>
						<td class="span10 control-group">
							<label class="control-label"><?php echo $f->label;?></label>
							<div class="controls">
								<?php if ($f->type == 'text'): ?>
									<?php echo Form::input(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value));?>
								<?php elseif ($f->type == 'textarea'): ?>
									<?php echo Form::textarea(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value, 'rows' => $f->html_rows));?>
								<?php elseif ($f->type == 'select'): ?>
									<?php echo Form::select($f->html_name, $f->value, $f->get_values(), array('class' => $f->html_class, 'id' => $f->html_id));?>
								<?php else: ?>
									Not done yet.
								<?php endif;?>
							</div>
						</td>
						<td class="span2">
							<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo ucfirst(__('action.edit')).' '.$f->label;?>"><?php echo ucfirst(__('action.edit'));?></a>
							<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo ucfirst(__('action.delete')).' '.$f->label;?>"><?php echo ucfirst(__('action.delete'));?></a>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php endif;?>
	<?php endif;?>
<?php endif;?>