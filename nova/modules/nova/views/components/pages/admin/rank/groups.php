<br>
<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/index');?>" class="btn tooltip-top" title="<?php echo lang('ranks index', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/info');?>" class="btn tooltip-top" title="<?php echo lang('action.edit rank info', 1);?>"><?php echo $images['info'];?></a>
		<a href="<?php echo Uri::create('admin/rank/manage');?>" class="btn tooltip-top" title="<?php echo lang('action.edit ranks', 1);?>"><?php echo $images['ranks'];?></a>
	</div>
</div>
<br>

<form method="post">
	<input type="hidden" name="action" value="create">
	<div class="control-group">
		<label class="control-label"><?php echo lang('action.add rank group', 2);?></label>
		<div class="controls">
			<div class="input-append">
				<input type="text" name="name" class="span4"><button class="btn"><?php echo lang('action.submit', 1);?></button>
			</div>
		</div>
	</div>
</form>

<?php if (count($groups) > 0): ?>
	<table width="100%" class="table-striped sort-rankgroups">
		<tbody class="sort-body">
		<?php foreach ($groups as $g): ?>
			<tr height="40" id="group_<?php echo $g->id;?>">
				<td>
					<?php if ($g->status === Status::INACTIVE): ?>
						<span class="label label-important"><?php echo lang('off', 1);?></span>
					<?php endif;?>
					<?php echo $g->name;?>
				</td>
				<td class="span2">
					<div class="btn-toolbar">
						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/rank/groups/'.$g->id);?>" class="btn btn-mini tooltip-top rankgroup-action" title="<?php echo lang('action.edit', 1);?>" data-action="update" data-id="<?php echo $g->id;?>"><i class="icon-pencil icon-75"></i></a>
							<a href="<?php echo Uri::create('admin/rank/groups/'.$g->id);?>" class="btn btn-mini tooltip-top rankgroup-action" title="<?php echo lang('action.duplicate', 1);?>" data-action="duplicate" data-id="<?php echo $g->id;?>"><i class="icon-share-alt icon-75"></i></a>
						</div>

						<?php if (Sentry::user()->has_access('rank.delete')): ?>
							<div class="btn-group">
								<a href="<?php echo Uri::create('admin/rank/groups');?>" class="btn btn-danger btn-mini tooltip-top rankgroup-action" title="<?php echo lang('action.delete', 1);?>" data-action="delete" data-id="<?php echo $g->id;?>"><i class="icon-remove icon-white icon-50"></i></a>
							</div>
						<?php endif;?>
					</div>
				</td>
				<td class="span1 reorder"></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p class="alert"><?php echo lang('[[error.not_found|rank groups]]');?></p>
<?php endif;?>