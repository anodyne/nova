<?php if (count($pending) > 0): ?>
	<?php foreach ($pending as $dir => $files): ?>
		<?php $location = str_replace(DS, '', $dir);?>
		<?php $has_readme = file_exists(APPPATH.'modules/'.$location.'/readme.md');?>

		<div class="alert alert-block">
			<div class="btn-group pull-right">
				<a class="btn btn-mini btn-icon tooltip-top install" title="<?php echo lang('action.install', 1);?>" href="#" data-location="<?php echo $location;?>"><i class="icon-ok-sign icon-50"></i></a>
				<?php if ($has_readme): ?>
					<a class="btn btn-mini btn-icon show-readme tooltip-top" title="<?php echo lang('action.view readme', 2);?>" href="#"><i class="icon-info-sign icon-50"></i></a>
				<?php endif;?>
			</div>

			<h4 class="alert-heading"><?php echo lang('{{'.$location.'}}', 2);?></h4>
			<?php if ($has_readme): ?>
				<span class="hide"><?php echo Markdown::parse(file_get_contents(APPPATH.'modules/'.$location.'/readme.md'));?></span>
			<?php endif;?>
		</div>
	<?php endforeach;?>
<?php endif;?>

<?php if (count($update) > 0): ?>
	<?php foreach ($update as $u): ?>
		<?php $has_readme = file_exists(APPPATH.'modules/'.$u->location.'/readme.md');?>

		<div class="alert alert-info alert-block">
			<div class="btn-group pull-right">
				<a class="btn btn-mini btn-icon tooltip-top update" title="<?php echo lang('action.update', 1);?>" href="#" data-location="<?php echo $u->location;?>"><i class="icon-circle-arrow-up icon-50"></i></a>
				<?php if ($has_readme): ?>
					<a class="btn btn-mini btn-icon show-readme tooltip-top" title="<?php echo lang('action.view readme', 2);?>" href="#"><i class="icon-info-sign icon-50"></i></a>
				<?php endif;?>
			</div>

			<h4 class="alert-heading"><?php echo $u->name;?></h4>
			<?php if ($has_readme): ?>
				<span class="hide"><?php echo Markdown::parse(file_get_contents(APPPATH.'modules/'.$u->location.'/readme.md'));?></span>
			<?php endif;?>
		</div>
	<?php endforeach;?>
<?php endif;?>

<?php if (count($installed) > 0): ?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th><?php echo lang('module', 1);?></th>
				<th><?php echo lang('desc', 1);?></th>
				<th class="span2"><?php echo lang('actions', 1);?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($installed as $i): ?>
			<tr>
				<td>
					<?php echo $i->name;?><br>
					<span class="muted font-small"><?php echo 'app/modules/'.$i->location;?></span>
				</td>
				<td><?php echo $i->desc;?></td>
				<td>
					<div class="btn-group">
						<a href="#" class="btn btn-mini btn-icon tooltip-top" title="<?php echo lang('action.edit', 1);?>"><i class="icon-pencil icon-50"></i></a>
						<a href="#" class="btn btn-mini btn-icon tooltip-top" title="<?php echo lang('action.uninstall', 1);?>"><i class="icon-ban-circle icon-50"></i></a>

						<?php if (array_key_exists($i->id, $update)): ?>
							<a href="#" class="btn btn-mini btn-icon tooltip-top update" title="<?php echo lang('action.update', 1);?>" data-location="<?php echo $i->location;?>"><i class="icon-circle-arrow-up icon-50"></i></a>
						<?php endif;?>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p class="alert"><?php echo lang('[[error.not_found|modules]]');?></p>
<?php endif;?>