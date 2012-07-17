<br>
<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/ranks/index');?>" class="btn tooltip-top" title="<?php echo lang('ranks index', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/ranks/info');?>" class="btn tooltip-top" title="<?php echo lang('action.edit rank info', 1);?>"><?php echo $images['info'];?></a>
		<a href="<?php echo Uri::create('admin/ranks/manage');?>" class="btn tooltip-top" title="<?php echo lang('action.edit ranks', 1);?>"><?php echo $images['ranks'];?></a>
	</div>
</div>
<br>

<form method="post">
	<input type="hidden" name="action" value="create">
	<div class="control-group">
		<label class="control-label"><?php echo lang('action.add rank set', 2);?></label>
		<div class="controls">
			<div class="input-append">
				<input type="text" name="name" class="span4"><button class="btn"><?php echo lang('action.submit', 1);?></button>
			</div>
		</div>
	</div>
</form>

<?php if (count($sets) > 0): ?>
	<table width="100%" class="table-striped sort-ranksets">
		<tbody class="sort-body">
		<?php foreach ($sets as $s): ?>
			<tr height="40" id="set_<?php echo $s->id;?>">
				<td>
					<?php if ( ! (bool) $s->display): ?>
						<span class="label label-important"><?php echo lang('off', 1);?></span>
					<?php endif;?>
					<?php echo $s->name;?>
				</td>
				<td class="span2">
					<div class="btn-toolbar">
						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/ranks/sets/'.$s->id);?>" class="btn btn-mini tooltip-top rankset-action" title="<?php echo lang('action.edit', 1);?>" data-action="update" data-id="<?php echo $s->id;?>"><i class="icon-pencil icon-75"></i></a>
							<a href="<?php echo Uri::create('admin/ranks/sets/'.$s->id);?>" class="btn btn-mini tooltip-top rankset-action" title="<?php echo lang('action.duplicate', 1);?>" data-action="duplicate" data-id="<?php echo $s->id;?>"><i class="icon-share-alt icon-75"></i></a>
						</div>

						<?php if (Sentry::user()->has_access('rank.delete')): ?>
							<div class="btn-group">
								<a href="<?php echo Uri::create('admin/ranks/sets');?>" class="btn btn-danger btn-mini tooltip-top rankset-action" title="<?php echo lang('action.delete', 1);?>" data-action="delete" data-id="<?php echo $s->id;?>"><i class="icon-remove icon-white icon-50"></i></a>
							</div>
						<?php endif;?>
					</div>
				</td>
				<td class="span1 reorder"></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>