<br>
<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/index');?>" class="btn icn16 tooltip-top" title="<?php echo lang('ranks index', 1);?>"><div class="icn icn-75" data-icon="<"></div></a>
		<a href="#" class="btn icn16 tooltip-top rankinfo-action" title="<?php echo lang('action.create rank info', 1);?>" data-action="create" data-id="0"><div class="icn icn-75" data-icon="+"></div></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/groups');?>" class="btn icn16 tooltip-top" title="<?php echo lang('action.edit rank groups', 1);?>"><div class="icn icn-75" data-icon=","></div></a>
		<a href="<?php echo Uri::create('admin/rank/manage');?>" class="btn icn16 tooltip-top" title="<?php echo lang('action.edit ranks', 1);?>"><div class="icn icn-75" data-icon="^"></div></a>
	</div>
</div>
<br>

<?php if (count($info) > 0): ?>
	<?php foreach ($info as $group => $rankinfo): ?>
		<h3><?php echo lang('group', 1).' '.$group;?></h3>
		<table width="100%" class="table-striped sort-rankinfo">
			<tbody class="sort-body">
			<?php foreach ($rankinfo as $i): ?>
				<tr height="40" id="info_<?php echo $i->id;?>">
					<td>
						<?php if ($i->status === Status::INACTIVE): ?>
							<span class="label label-important"><?php echo lang('off', 1);?></span>
						<?php endif;?>
						<?php echo $i->name;?>
					</td>
					<td class="span2">
						<div class="btn-toolbar pull-right">
							<div class="btn-group">
								<a href="#" class="btn btn-mini tooltip-top rankinfo-action" title="<?php echo lang('action.edit', 1);?>" data-action="update" data-id="<?php echo $i->id;?>"><div class="icn icn-50" data-icon="p"></div></a>
							</div>

							<?php if (Sentry::user()->hasAccess('rank.delete')): ?>
								<div class="btn-group">
									<a href="#" class="btn btn-danger btn-mini tooltip-top rankinfo-action" title="<?php echo lang('action.delete', 1);?>" data-action="delete" data-id="<?php echo $i->id;?>"><div class="icn icn-50" data-icon="x"></div></a>
								</div>
							<?php endif;?>
						</div>
					</td>
					<td class="span1 reorder"></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table><br>
	<?php endforeach;?>
<?php else: ?>
	<p class="alert"><?php echo lang('[[error.not_found|rank info]]');?></p>
<?php endif;?>