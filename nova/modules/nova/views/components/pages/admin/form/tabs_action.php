<?php

function tab($obj, $property, $default = false)
{
	if (is_object($obj))
	{
		return $obj->{$property};
	}

	return $default;
}

?>

<?php if (is_numeric(Uri::segment(5))): ?>
	<br>
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/tabs/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo lang('action.back to tabs', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
	</div>
<?php endif;?>

<br>
<form method="post" action="<?php echo Uri::create('admin/form/tabs/'.Uri::segment(4));?>">
	<div class="control-group">
		<label class="control-label"><?php echo lang('name', 1);?></label>
		<div class="controls">
			<?php echo Form::input(array('name' => 'name', 'value' => tab($tab, 'name'), 'class' => 'span3'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('order', 1);?></label>
		<div class="controls">
			<?php echo Form::input(array('name' => 'order', 'value' => tab($tab, 'order'), 'class' => 'span1'));?>
			<p class="help-block"><?php echo lang('short.forms.order');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('link id', 1);?></label>
		<div class="controls">
			<?php echo Form::input(array('name' => 'link_id', 'value' => tab($tab, 'link_id'), 'class' => 'span3'));?>
			<p class="help-block"><?php echo lang('short.forms.tab_link_id');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('display', 1);?></label>
		<div class="controls">
			<?php if (Uri::segment(5) == 0): ?>
				<label class="radio inline">
					<input type="radio" name="display" value="1" checked="checked"> <?php echo lang('yes', 1);?>
				</label>
				<label class="radio inline">
					<input type="radio" name="display" value="0"> <?php echo lang('no', 1);?>
				</label>
			<?php else: ?>
				<label class="radio inline">
					<input type="radio" name="display" value="1"<?php if ( (int) tab($tab, 'display') === 1){ echo ' checked="checked"';}?>>
					<?php echo lang('yes', 1);?>
				</label>
				<label class="radio inline">
					<input type="radio" name="display" value="0"<?php if ( (int) tab($tab, 'display') === 0){ echo ' checked="checked"';}?>>
					<?php echo lang('no', 1);?>
				</label>
			<?php endif;?>
		</div>
	</div>

	<div class="controls">
		<br>
		<?php echo Form::hidden('action', $action);?>
		<?php echo Form::hidden('form_key', Uri::segment(4));?>
		<?php echo Form::hidden('id', Uri::segment(5));?>
		<button type="submit" class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
	</div>
</form>