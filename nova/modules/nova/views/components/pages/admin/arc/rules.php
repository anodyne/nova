<br>
<div class="btn-group">
	<a href="<?php echo Uri::create('admin/application/index');?>" class="btn tooltip-top" title="<?php echo lang('applications index', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
	
	<?php if (Sentry::user()->has_level('character.create', 2)): ?>
		<a href="<?php echo Uri::create('admin/application/rules/0');?>" class="btn tooltip-top" title="<?php echo lang('action.add rule', 1);?>"><i class="icon-plus icon-75"></i></a>
	<?php endif;?>
</div>
<br>

<?php if (count($rules) > 0): ?>
	<table class="table table-striped">
		<tbody>
		<?php foreach ($rules as $r): ?>
			<?php $users = json_decode($r->users);?>
			<tr>
				<td>
					<?php if ($r->type == 'global'): ?>
						<?php echo lang('for all applications action.add', 1);?>
					<?php else: ?>
						<?php echo lang('for all applications to the', 1).' '.Model_Department::find($r->condition)->name.' '.lang('department action.add');?>
					<?php endif;?>
						
					<?php if (property_exists($users, 'position')):?>
						<?php foreach ($users->position as $p): ?>
							<span class="badge badge-info"><?php echo Model_Position::find($p)->name;?></span>
						<?php endforeach;?>
					<?php endif;?>

					<?php if (property_exists($users, 'user')):?>
						<?php foreach ($users->user as $u): ?>
							<span class="badge badge-important"><?php echo Model_User::find($u)->name;?></span>
						<?php endforeach;?>
					<?php endif;?>

					<?php echo lang('to the review');?>.
				</td>
				<td class="span2">
					<?php if (Sentry::user()->has_level('character.create', 2)): ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<a href="<?php echo Uri::create('admin/application/rules/'.$r->id);?>" class="btn btn-mini tooltip-top" title="<?php echo lang('action.edit', 1);?>"><i class="icon-pencil icon-75"></i></a>
							</div>

							<div class="btn-group">
								<a href="#" class="btn btn-danger btn-mini tooltip-top apprule-action" title="<?php echo lang('action.delete', 1);?>" data-action="delete" data-id="<?php echo $r->id;?>"><i class="icon-remove icon-white icon-50"></i></a>
							</div>
						</div>
					<?php endif;?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p class="alert"><?php echo lang('[[error.not_found|application rules]]');?></p>
<?php endif;?>