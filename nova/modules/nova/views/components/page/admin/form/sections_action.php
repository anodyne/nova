<?php

function section($obj, $property, $default = false)
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
		<a href="<?php echo Uri::create('admin/form/sections/'.Uri::segment(4));?>" class="btn icn16 tooltip-top" title="<?php echo lang('action.back to sections', 1);?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>
<?php endif;?>

<br>
<form method="post" action="<?php echo Uri::create('admin/form/sections/'.Uri::segment(4));?>">
	<div class="control-group">
		<label class="control-label"><?php echo lang('name', 1);?></label>
		<div class="controls">
			<?php echo Form::input(array('name' => 'name', 'value' => section($section, 'name'), 'class' => 'span3'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('order', 1);?></label>
		<div class="controls">
			<?php echo Form::input(array('name' => 'order', 'value' => section($section, 'order'), 'class' => 'span1'));?>
			<p class="help-block"><?php echo lang('short.forms.order');?></p>
		</div>
	</div>

	<?php if (count($tabs) > 0): ?>
		<div class="control-group">
			<label class="control-label"><?php echo lang('tab', 1);?></label>
			<div class="controls">
				<?php echo Form::select('tab_id', section($section, 'tab_id'), $tabs, array('class' => 'span3'));?>
			</div>
		</div>
	<?php else: ?>
		<?php echo Form::hidden('tab_id', 0);?>
	<?php endif;?>

	<div class="controls">
		<br>
		<button type="submit" class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
	</div>

	<?php echo Form::hidden('action', $action);?>
	<?php echo Form::hidden('form_key', Uri::segment(4));?>
	<?php echo Form::hidden('id', Uri::segment(5));?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
</form>