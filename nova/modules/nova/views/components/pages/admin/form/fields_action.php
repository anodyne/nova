<?php if (isset($field)): ?>
	<br>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#general" data-toggle="tab">General Attributes</a></li>
		<li><a href="#html" data-toggle="tab">HTML Attributes</a></li>
		<li<?php if ($field->type != 'select'){ echo ' class="hide"';}?>><a href="#values" data-toggle="tab">Values</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="general">
			<div class="control-group">
				<label class="control-label">Type</label>
				<div class="controls">
					<div class="btn-group" data-toggle="buttons-radio">
						<button class="btn tooltip-top" title="Text Field"><img src="<?php echo Uri::base(false);?>nova/modules/nova/views/design/images/ui-text-field.png" alt=""></button>
						<button class="btn tooltip-top" title="Text Area"><img src="<?php echo Uri::base(false);?>nova/modules/nova/views/design/images/ui-text-area.png" alt=""></button>
						<button class="btn tooltip-top" title="Dropdown Menu"><img src="<?php echo Uri::base(false);?>nova/modules/nova/views/design/images/ui-combo-box.png" alt=""></button>
					</div>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Label</label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'label', 'value' => $field->label, 'class' => 'span3'));?>
				</div>
			</div>

			<?php if (count($sections) > 0): ?>
				<div class="control-group">
					<label class="control-label">Section</label>
					<div class="controls">
						<?php echo Form::select('section_id', $field->section_id, $sections, array('class' => 'span3'));?>
					</div>
				</div>
			<?php endif;?>

			<div class="control-group">
				<label class="control-label">Order</label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'order', 'value' => $field->order, 'class' => 'span1'));?>
					<p class="help-block">Field order can also be changed by dragging and dropping the fields on the previous page.</p>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Display</label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'order', 'value' => $field->order, 'class' => 'span1'));?>
				</div>
			</div>
		</div>

		<div class="tab-pane" id="html">
			<div class="control-group">
				<label class="control-label">Name</label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_name', 'value' => $field->html_name, 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">ID</label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_id', 'value' => $field->html_id, 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Class</label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_class', 'value' => $field->html_class, 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group field-type-textarea">
				<label class="control-label">Placeholder</label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'placeholder', 'value' => $field->placeholder, 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Value</label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'value', 'value' => $field->value, 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group field-type-textarea">
				<label class="control-label">Rows</label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_rows', 'value' => $field->html_rows, 'class' => 'span1'));?>
				</div>
			</div>
		</div>
		
		<div class="tab-pane" id="values">
			<?php if ($field->values !== null): ?>
				<div class="well">
					<h3>Add New Field Value</h3>

					<div class="control-group">
						<label class="control-label">Content</label>
						<div class="controls">
							<?php echo Form::input(array('name' => 'value', 'value' => $field->value, 'class' => 'span3'));?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Value</label>
						<div class="controls">
							<?php echo Form::input(array('name' => 'value', 'value' => $field->value, 'class' => 'span3'));?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="span7">
						<table class="table table-bordered sort-value">
							<thead>
								<tr>
									<th class="span2">Content  <i class="icon-question-sign icon-50 tooltip-top" title="The content is what will be shown in the dropdown menu"></i></th>
									<th class="span2">Value <i class="icon-question-sign icon-50 tooltip-top" title="The value is what will be stored in the database"></i></th>
									<th>Reorder  <i class="icon-question-sign icon-50 tooltip-top" title="Drag and drop the handle to move the value to a new location"></i></th>
								</tr>
							</thead>
							<tbody class="sort-body">
							<?php foreach ($field->values as $v): ?>
								<tr id="value_<?php echo $v->id;?>">
									<td><?php echo $v->content;?></td>
									<td><?php echo $v->value;?></td>
									<td class="span1 reorder"></td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			<?php endif;?>
		</div>
	</div>
<?php endif;?>