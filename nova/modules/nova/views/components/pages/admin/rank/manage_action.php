<?php

if ( ! function_exists('rankData'))
{
	function rankData($obj, $property, $default = false)
	{
		if (is_object($obj))
		{
			return $obj->{$property};
		}

		return $default;
	}
}

if (is_numeric(Uri::segment(4))): ?>
	<br>
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/manage');?>" class="btn tooltip-top" title="<?php echo lang('action.back to ranks', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
	</div>
	<br>
<?php endif;?>

<form method="post" action="<?php echo Uri::create('admin/ranks/manage');?>">
	<div class="row">
		<div class="span6">
			<div class="control-group">
				<label class="control-label"><?php echo lang('rank info', 2);?></label>
				<div class="controls">
					<div class="input-append">
						<?php echo Form::select('info_id', rankData($rank, 'info_id', 0), $infos, array('class' => 'span4'));?><a href="<?php echo Uri::create('admin/rank/info');?>" class="btn tooltip-top" title="<?php echo lang('action.edit rank info', 1);?>"><i class="icon-pencil icon-75"></i></a>
					</div>
				</div>
			</div>
		</div>

		<div class="span6">
			<div class="control-group">
				<label class="control-label"><?php echo lang('rank group', 2);?></label>
				<div class="controls">
					<div class="input-append">
						<?php echo Form::select('group_id', rankData($rank, 'group_id'), $groups, array('class' => 'span4'));?><a href="<?php echo Uri::create('admin/rank/groups');?>" class="btn tooltip-top" title="<?php echo lang('action.edit rank groups', 1);?>"><i class="icon-pencil icon-75"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if (isset($bases) and isset($pips)): ?>
		<div class="control-group">
			<label class="control-label"><?php echo lang('preview', 1);?></label>
			<div id="rankPreview">
				<?php if ( ! $rankPreview): ?>
					<div rel="rankBaseImage" style="width:144px; height:40px; position:relative; z-index:100; background:transparent url() no-repeat top left;"><div rel="rankPipImage" style="width:144px; height:40px; position:relative; z-index:10; background:transparent url() no-repeat top left;"></div></div>
				<?php else: ?>
					<?php echo $rankPreview;?>
				<?php endif;?>
			</div>
		</div>
	<?php endif;?>
	<br>

	<?php if (isset($bases) and isset($pips)): ?>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#baseImage" data-toggle="tab"><?php echo lang('base image', 2);?></a></li>
			<li><a href="#pipImage" data-toggle="tab"><?php echo lang('pip image', 2);?></a></li>
		</ul>

		<div class="tab-content">
			<div id="baseImage" class="active tab-pane">
				<ul class="thumbnails">
				<?php foreach($bases as $base => $image): ?>
					<li class="span3">
						<div class="caption"><label class="radio inline"><?php echo Form::radio('base', $base, rankData($rank, 'base')).' '.$image;?></label></div>
					</li>
				<?php endforeach;?>
				</ul>
			</div>

			<div id="pipImage" class="tab-pane">
				<ul class="thumbnails">
				<?php foreach($pips as $pip => $image): ?>
					<li class="span3">
						<div class="caption"><label class="radio inline"><?php echo Form::radio('pip', $pip, rankData($rank, 'pip')).' '.$image;?></label></div>
					</li>
				<?php endforeach;?>
				</ul>
			</div>
		</div>
	<?php else: ?>
		<fieldset>
			<legend><?php echo lang('images', 1);?></legend><br>

			<ul class="thumbnails">
			<?php foreach($imgs as $base => $image): ?>
				<?php $fullImage = rankData($rank, 'base').'-'.rankData($rank, 'pip');?>
				<li class="span3">
					<div class="caption"><label class="radio inline"><?php echo Form::radio('base', $base, $fullImage).' '.$image;?></label></div>
				</li>
			<?php endforeach;?>
			</ul>
	<?php endif;?>
	<br>

	<div class="controls">
		<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
		<input type="hidden" name="id" value="<?php echo Uri::segment(4);?>">
		<input type="hidden" name="action" value="<?php echo $action;?>">
	</div>
</form>