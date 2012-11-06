<?php

function field($obj, $property, $default = false)
{
	if (is_object($obj))
	{
		return $obj->{$property};
	}

	return $default;
}

?>

<?php if (is_numeric(Uri::segment(5))): ?>
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/fields/'.Uri::segment(4));?>" class="btn icn16 tooltip-top" title="<?php echo lang('action.back to fields', 1);?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>
<?php endif;?>

<ul class="nav nav-tabs">
	<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('general attributes', 2);?></a></li>
	<li><a href="#html" data-toggle="tab"><?php echo lang('html attributes', 2);?></a></li>
	<li<?php if (field($field, 'type') != 'select' or Uri::segment(5) == 0){ echo ' class="hide"';}?>><a href="#values" data-toggle="tab"><?php echo lang('values', 1);?></a></li>
</ul>

<form method="post" action="<?php echo Uri::create('admin/form/fields/'.Uri::segment(4));?>">
	<div class="tab-content">
		<div class="tab-pane active" id="general">
			<div class="control-group">
				<label class="control-label"><?php echo lang('type', 1);?></label>
				<div class="controls">
					<?php echo Form::select('type', field($field, 'type'), $types, array('class' => 'span3'));?>
					<p class="help-block help-values hide"><?php echo lang('short.forms.value_creation');?></p>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('restrictions', 1);?></label>
				<div class="controls">
					<?php echo Form::select('restriction', field($field, 'restriction'), $roles, array('class' => 'span3'));?>
					<p class="help-block"><?php echo lang('short.forms.field_restriction');?></p>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('label', 1);?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'label', 'value' => field($field, 'label'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('inline_help', 2);?></label>
				<div class="controls">
					<?php echo Form::textarea(array('name' => 'help', 'value' => field($field, 'help'), 'class' => 'span6'));?>
				</div>
			</div>

			<?php if (count($sections) > 0): ?>
				<div class="control-group">
					<label class="control-label"><?php echo lang('section', 1);?></label>
					<div class="controls">
						<?php echo Form::select('section_id', field($field, 'section_id'), $sections, array('class' => 'span3'));?>
					</div>
				</div>
			<?php endif;?>

			<div class="control-group">
				<label class="control-label"><?php echo lang('order', 1);?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'order', 'value' => field($field, 'order'), 'class' => 'span1'));?>
					<p class="help-block"><?php echo lang('short.forms.order');?></p>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('display', 1);?></label>
				<div class="controls">
					<?php if (Uri::segment(5) == 0): ?>
						<label class="radio inline">
							<input type="radio" name="status" value="<?php echo Status::ACTIVE;?>" checked="checked"> <?php echo lang('yes', 1);?>
						</label>
						<label class="radio inline">
							<input type="radio" name="status" value="<?php echo Status::INACTIVE;?>"> <?php echo lang('no', 1);?>
						</label>
					<?php else: ?>
						<label class="radio inline">
							<input type="radio" name="status" value="<?php echo Status::ACTIVE;?>"<?php if ( (int) field($field, 'status') === Status::ACTIVE){ echo ' checked="checked"';}?>>
							<?php echo lang('yes', 1);?>
						</label>
						<label class="radio inline">
							<input type="radio" name="status" value="<?php echo Status::INACTIVE;?>"<?php if ( (int) field($field, 'status') === Status::INACTIVE){ echo ' checked="checked"';}?>>
							<?php echo lang('no', 1);?>
						</label>
					<?php endif;?>
				</div>
			</div>
		</div>

		<div class="tab-pane" id="html">
			<div class="control-group">
				<label class="control-label"><?php echo lang('name', 1);?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_name', 'value' => field($field, 'html_name'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('id', 1);?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_id', 'value' => field($field, 'html_id'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('class', 1);?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_class', 'value' => field($field, 'html_class'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group field-placeholder">
				<label class="control-label"><?php echo lang('placeholder', 1);?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'placeholder', 'value' => field($field, 'placeholder'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group field-value">
				<label class="control-label"><?php echo lang('value', 1);?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'value', 'value' => field($field, 'value'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group field-rows hide">
				<label class="control-label"><?php echo lang('rows', 1);?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_rows', 'value' => field($field, 'html_rows'), 'class' => 'span1'));?>
				</div>
			</div>
		</div>
		
		<?php if (Uri::segment(5) > 0): ?>
			<div class="tab-pane" id="values">
				<div class="row">
					<div class="span6">
						<div class="controls">
							<div class="input-append">
								<input name="value-add-content" type="text" placeholder="<?php echo lang('action.add field values', 2);?>" class="span3"><button class="btn icn16 tooltip-top value-action" data-action="add" title="<?php echo lang('action.add value', 1);?>"><div class="icn icn-50" data-icon="+"></div></button>
							</div>
						</div>

						<table class="table table-bordered sort-value">
							<thead>
								<tr>
									<th><?php echo lang('content', 1);?></th>
									<th><?php echo lang('actions', 1);?></th>
									<th></th>
								</tr>
							</thead>
							<tbody class="sort-body">
							<?php if (count($values) == 0): ?>
								<tr>
									<td colspan="3">
										<strong class="muted"><?php echo lang('[[error.not_found|field values]]', 1);?></strong>
									</td>
								</tr>
							<?php else: ?>
								<?php foreach ($values as $v): ?>
									<tr id="value_<?php echo $v->id;?>">
										<td><?php echo $v->content;?></td>
										<td class="span2">
											<div class="btn-toolbar">
												<div class="btn-group">
													<a href="#" class="btn btn-mini value-action tooltip-top" title="<?php echo lang('action.edit', 1);?>" data-action="update" data-id="<?php echo $v->id;?>"><div class="icn icn-50" data-icon="p"></div></a>
												</div>

												<div class="btn-group">
													<a href="#" class="btn btn-mini btn-danger value-action tooltip-top" title="<?php echo lang('action.delete', 1);?>" data-action="delete" data-id="<?php echo $v->id;?>"><div class="icn icn-50" data-icon="x"></div></a>
												</div>
											</div>
										</td>
										<td class="span1 reorder"></td>
									</tr>
								<?php endforeach;?>
							<?php endif;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php endif;?>
	</div>

	<div class="controls">
		<button type="submit" class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>

		<?php if (Uri::segment(5) == 0): ?>
			<button class="btn next-tab"><?php echo lang('next', 1);?></button>
		<?php endif;?>
	</div>

	<?php echo Form::hidden('action', $action);?>
	<?php echo Form::hidden('form_key', Uri::segment(4));?>
	<?php echo Form::hidden('id', Uri::segment(5));?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
</form>