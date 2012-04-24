<?php if (isset($characters) and Uri::segment(4) === false): ?>
	<ul class="thumbnails">
	<?php foreach ($characters as $c): ?>
		<li class="span6">
			<div class="thumbnail">
				<div class="caption">
					<div class="btn-group pull-right">
						<a href="<?php echo Uri::create('admin/character/edit/'.$c->id);?>" class="btn btn-small"><?php echo lang('action.edit', 1);?></a>
					</div>

					<h3><?php echo $c->name(true, true);?></h3>
				</div>
			</div>
		</li>
	<?php endforeach;?>
	</ul>
<?php else: ?>
	<div class="row">
		<div class="span6">
			<div class="control-group">
				<label class="control-label"><?php echo lang('first name', 2);?></label>
				<div class="controls">
					<?php echo Form::input('first_name', $character->first_name, array('class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('middle name', 2);?></label>
				<div class="controls">
					<?php echo Form::input('middle_name', $character->middle_name, array('class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('last name', 2);?></label>
				<div class="controls">
					<?php echo Form::input('last_name', $character->last_name, array('class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('suffix', 1);?></label>
				<div class="controls">
					<?php echo Form::input('suffix', $character->suffix, array('class' => 'span1'));?>
				</div>
			</div>
		</div>

		<div class="span6">
			<div class="control-group">
				<label class="control-label">Rank</label>
				<div class="controls">
					<?php echo NovaForm::rank('rank_id', $character->rank_id, array('class' => 'span4'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Position 1</label>
				<div class="controls">
					<?php echo NovaForm::position('position_id', false, array('class' => 'span4'));?>
				</div>
			</div>
		</div>
	</div><br>

	<?php echo $form;?>
<?php endif;?>