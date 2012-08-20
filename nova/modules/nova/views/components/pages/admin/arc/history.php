<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/application/index');?>" class="btn tooltip-top" title="<?php echo lang('action.back to index', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
	</div>

	<div class="btn-group">
		<a href="#" class="btn status-toggle tooltip-top" title="<?php echo lang('action.clear action.filter', 1);?>" data-status="all"><i class="icon-remove icon-75"></i></a>
		<a href="#" class="btn status-toggle tooltip-top" title="<?php echo lang('action.show in_progress', 1);?>" data-status="inprogress"><i class="icon-asterisk icon-75"></i></a>
		<a href="#" class="btn status-toggle tooltip-top" title="<?php echo lang('action.show action.approved', 1);?>" data-status="approved"><i class="icon-ok icon-75"></i></a>
		<a href="#" class="btn status-toggle tooltip-top" title="<?php echo lang('action.show action.rejected', 1);?>" data-status="rejected"><i class="icon-ban-circle icon-75"></i></a>
	</div>
</div>
<br>

<?php if ($applications): ?>
	<table class="table table-striped">
		<tbody>
		<?php foreach ($applications as $r): ?>
			<tr class="status-<?php echo $r->status;?>">
				<td>
					<span class="lead"><?php echo $r->character->name(false);?></span><br>

					<?php if ($r->status == Status::IN_PROGRESS): ?>
						<span class="label label-info"><i class="icon-asterisk icon-white"></i></span>
					<?php elseif ($r->status == Status::APPROVED): ?>
						<span class="label label-success"><i class="icon-ok icon-white"></i></span>
					<?php elseif ($r->status == Status::REJECTED): ?>
						<span class="label label-important"><i class="icon-remove icon-white"></i></span>
					<?php endif;?>

					<span class="muted"><?php echo $r->position->name;?></span>
				</td>
				<td class="span2">
					<div class="btn-toolbar">
						<div class="btn-group">
							<?php if (count($r->comments()) > 0): ?>
								<span class="btn btn-mini btn-icon btn-noclick tooltip-top" title="<?php echo lang('comments', 1);?>"><i class="icon-comment icon-50"></i> <?php echo count($r->comments());?></span>
							<?php endif;?>

							<?php if (count($r->votes('yes')) > 0): ?>
								<span class="btn btn-mini btn-icon btn-noclick tooltip-top" title="<?php echo lang('yes votes', 1);?>"><i class="icon-thumbs-up icon-50"></i> <?php echo count($r->votes('yes'));?></span>
							<?php endif;?>

							<?php if (count($r->votes('no')) > 0): ?>
								<span class="btn btn-mini btn-icon btn-noclick tooltip-top" title="<?php echo lang('no votes', 1);?>"><i class="icon-thumbs-down icon-50"></i> <?php echo count($r->votes('no'));?></span>
							<?php endif;?>
						</div>
					</div>
				</td>
				<td class="span2">
					<div class="btn-toolbar pull-right">
						<?php if ($r->status == Status::REJECTED): ?>
							<div class="btn-group">
								<?php if (Model_Ban::find_items($r->user->email)): ?>
									<a href="#" class="btn btn-mini btn-icon btn-danger tooltip-top unban-user" title="<?php echo lang('action.remove user action.ban', 1);?>" data-user="<?php echo $r->user->id;?>"><i class="icon-ban-circle icon-white icon-50"></i></a>
								<?php else:?>
									<a href="#" class="btn btn-mini btn-icon btn-danger tooltip-top ban-user" title="<?php echo lang('action.ban user', 1);?>" data-user="<?php echo $r->user->id;?>"><i class="icon-ban-circle icon-white icon-50"></i></a>
								<?php endif;?>
							</div>
						<?php endif;?>

						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>" class="btn btn-mini btn-icon"><i class="icon-chevron-right icon-50"></i></a>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p class="alert"><?php echo lang('[[error.not_found|applications]]');?></p>
<?php endif;?>