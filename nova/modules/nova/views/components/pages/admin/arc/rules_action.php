<?php

if ( ! function_exists('ruleData'))
{
	function ruleData($obj, $property, $default = false)
	{
		if (is_object($obj))
		{
			if ($property == 'users.user' or $property == 'users.position')
			{
				// parse the users field
				$data = json_decode($obj->users);

				if ($property == 'users.user' and property_exists($data, 'user'))
				{
					return $data->user;
				}

				if ($property == 'users.position' and property_exists($data, 'position'))
				{
					return $data->position;
				}

				return $default;
			}
			else
			{
				return $obj->{$property};
			}
		}

		return $default;
	}
}

?>
<br>
<div class="btn-group">
	<a href="<?php echo Uri::create('admin/application/rules');?>" class="btn tooltip-top" title="<?php echo lang('action.back to rules', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
</div>
<br>

<form method="post" action="<?php echo Uri::create('admin/application/rules');?>">
	<div class="control-group">
		<label class="control-label"><?php echo lang('type', 1);?></label>
		<div class="controls">
			<?php echo Form::select('type', ruleData($rule, 'type'), array('global' => lang('global', 1), 'dept' => lang('department', 1)), array('id' => 'ruleType', 'class' => 'chzn span2'));?>
		</div>
	</div>

	<div id="deptRule" class="hide">
		<div class="control-group">
			<label class="control-label"><?php echo lang('department is', 1);?>...</label>
			<div class="controls">
				<?php echo NovaForm::department('condition', ruleData($rule, 'condition'), array('class' => 'chzn span4'));?>
			</div>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('action.add users', 1);?>...</label>
		<div class="controls">
			<?php echo NovaForm::users('users[user]', ruleData($rule, 'users.user'), array('multiple' => 'multiple', 'class' => 'chzn span4'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('action.add users in positions', 1);?>...</label>
		<div class="controls">
			<?php echo NovaForm::position('users[position]', ruleData($rule, 'users.position'), array('multiple' => 'multiple', 'class' => 'chzn span4'));?>
		</div>
	</div>

	<br>
	<div class="controls">
		<?php echo Form::hidden('action', $action);?>
		<?php echo Form::hidden('id', Uri::segment(4));?>

		<button type="submit" class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
	</div>
</form>