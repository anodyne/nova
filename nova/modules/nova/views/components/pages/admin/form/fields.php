<br>
<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/index');?>" class="btn tooltip-top" title="<?php echo lang('all forms', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
		<a href="<?php echo Uri::create('admin/form/fields/'.Uri::segment(4).'/0');?>" class="btn tooltip-top" title="<?php echo lang('action.add field', 1);?>"><i class="icon-plus icon-75"></i></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/tabs/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo lang('action.edit tabs', 1);?>"><?php echo $images['tabs'];?></a>
		<a href="<?php echo Uri::create('admin/form/sections/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo lang('action.edit sections', 1);?>"><?php echo $images['sections'];?></a>
	</div>
</div>
<br>

<?php if ($tabs !== false): ?>
	<ul class="nav nav-tabs">
	<?php foreach ($tabs as $t): ?>
		<li><a href="#<?php echo $t->link_id;?>" data-toggle="tab"><?php echo $t->name;?><?php if ($t->status === Status::INACTIVE){ echo ' ('.lang('inactive', 1).')';}?></a></li>
	<?php endforeach;?>
	</ul>
	
	<div class="tab-content">
	<?php foreach ($tabs as $t): ?>
		<div class="tab-pane" id="<?php echo $t->link_id;?>">
		<?php if (is_array($sections) and array_key_exists($t->id, $sections)): ?>
			<?php foreach ($sections[$t->id] as $s): ?>
				<fieldset>
					<legend><?php echo $s->name;?><?php if ($s->status === Status::INACTIVE){ echo ' <small>'.lang('inactive', 1).'</small>';}?></legend>

					<?php if (is_array($fields) and array_key_exists($s->id, $fields)): ?>
						<table width="100%" class="table-striped sort-field">
							<tbody class="sort-body">
							<?php foreach ($fields[$s->id] as $f): ?>
								<tr id="field_<?php echo $f->id;?>">
									<td class="span9 control-group">
										<label class="control-label">
											<?php echo $f->label;?>
											<?php if ($f->status === Status::INACTIVE): ?>
												<span class="muted">(<?php echo lang('inactive', 1);?>)</span>
											<?php endif;?>
										</label>
										<div class="controls">
											<?php if ($f->type == 'text'): ?>
												<?php echo Form::input(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value));?>
											<?php elseif ($f->type == 'textarea'): ?>
												<?php echo Form::textarea(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value, 'rows' => $f->html_rows));?>
											<?php elseif ($f->type == 'select'): ?>
												<?php echo Form::select($f->html_name, $f->value, $f->get_values(), array('class' => $f->html_class, 'id' => $f->html_id));?>
											<?php endif;?>

											<?php if ( ! empty($f->help)): ?>
												<p class="help-block"><?php echo $f->help;?></p>
											<?php endif;?>
										</div>
									</td>
									<td class="span2">
										<div class="btn-group">
											<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo lang('action.edit', 1).' '.$f->label;?>"><i class="icon-pencil icon-75"></i></a>
											<?php if (Sentry::user()->has_access('form.delete')): ?>
												<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key);?>" class="btn btn-mini tooltip-top field-action" title="<?php echo lang('action.delete', 1).' '.$f->label;?>" data-action="delete" data-id="<?php echo $f->id;?>"><i class="icon-remove icon-75"></i></a>
											<?php endif;?>
										</div>
									</td>
									<td class="span1 reorder"></td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					<?php else: ?>
						<p class="alert"><?php echo lang('[[error.not_found|fields]] for this section', 1);?></p>
					<?php endif;?>
				</fieldset><br>
			<?php endforeach;?>
		<?php else: ?>
			<p class="alert"><?php echo lang('[[error.not_found|sections]] for this tab', 1);?></p>
		<?php endif;?>
		</div>
	<?php endforeach;?>
	</div>
<?php else: ?>
	<?php if ($sections !== false): ?>
		<?php foreach ($sections as $s): ?>
			<fieldset>
				<legend><?php echo $s->name;?><?php if ($s->status === Status::INACTIVE){ echo ' <small>'.lang('inactive', 1).'</small>';}?></legend>

				<?php if (is_array($fields) and array_key_exists($s->id, $fields)): ?>
					<table width="100%" class="table-striped sort-field">
						<tbody class="sort-body">
						<?php foreach ($fields[$s->id] as $f): ?>
							<tr id="field_<?php echo $f->id;?>">
								<td class="span9 control-group">
									<label class="control-label">
										<?php echo $f->label;?>
										<?php if ($f->status === Status::INACTIVE): ?>
											<span class="muted">(<?php echo lang('inactive', 1);?>)</span>
										<?php endif;?>
									</label>
									<div class="controls">
										<?php if ($f->type == 'text'): ?>
											<?php echo Form::input(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value));?>
										<?php elseif ($f->type == 'textarea'): ?>
											<?php echo Form::textarea(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value, 'rows' => $f->html_rows));?>
										<?php elseif ($f->type == 'select'): ?>
											<?php echo Form::select($f->html_name, $f->value, $f->get_values(), array('class' => $f->html_class, 'id' => $f->html_id));?>
										<?php endif;?>
									</div>
								</td>
								<td class="span2">
									<div class="btn-group">
										<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo lang('action.edit', 1).' '.$f->label;?>"><i class="icon-pencil icon-75"></i></a>
										<?php if (Sentry::user()->has_access('form.delete')): ?>
											<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key);?>" class="btn btn-mini tooltip-top field-action" title="<?php echo lang('action.delete', 1).' '.$f->label;?>" data-action="delete" data-id="<?php echo $f->id;?>"><i class="icon-remove icon-75"></i></a>
										<?php endif;?>
									</div>
								</td>
								<td class="span1 reorder"></td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php else: ?>
					<p class="alert"><?php echo lang('[[error.not_found|fields]] for this section', 1);?></p>
				<?php endif;?>
			</fieldset>
		<?php endforeach;?>
	<?php else: ?>
		<?php if ($fields !== false): ?>
			<table width="100%" class="table-striped sort-field">
				<tbody class="sort-body">
				<?php foreach ($fields as $f): ?>
					<tr id="field_<?php echo $f->id;?>">
						<td class="span9 control-group">
							<label class="control-label">
								<?php echo $f->label;?>
								<?php if ($f->status === Status::INACTIVE): ?>
									<span class="muted">(<?php echo lang('inactive', 1);?>)</span>
								<?php endif;?>
							</label>
							<div class="controls">
								<?php if ($f->type == 'text'): ?>
									<?php echo Form::input(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value));?>
								<?php elseif ($f->type == 'textarea'): ?>
									<?php echo Form::textarea(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value, 'rows' => $f->html_rows));?>
								<?php elseif ($f->type == 'select'): ?>
									<?php echo Form::select($f->html_name, $f->value, $f->get_values(), array('class' => $f->html_class, 'id' => $f->html_id));?>
								<?php endif;?>
							</div>
						</td>
						<td class="span2">
							<div class="btn-group">
								<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo lang('action.edit', 1).' '.$f->label;?>"><i class="icon-pencil icon-75"></i></a>
								<?php if (Sentry::user()->has_access('form.delete')): ?>
									<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key);?>" class="btn btn-mini tooltip-top field-action" title="<?php echo lang('action.delete', 1).' '.$f->label;?>" data-action="delete" data-id="<?php echo $f->id;?>"><i class="icon-remove icon-75"></i></a>
								<?php endif;?>
							</div>
						</td>
						<td class="span1 reorder"></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<p class="alert"><?php echo lang('[[error.not_found|form fields]]', 1);?></p>
		<?php endif;?>
	<?php endif;?>
<?php endif;?>