<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/application/index');?>" class="btn icn16 tooltip-top" title="<?php echo lang('action.back to index', 1);?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>

	<div class="btn-group">
		<a href="#" class="btn icn16 status-toggle tooltip-top" title="<?php echo lang('action.clear action.filter', 1);?>" data-status="all"><div class="icn icn-75" data-icon="x"></div></a>
		<a href="#" class="btn icn16 status-toggle tooltip-top" title="<?php echo lang('action.show in_progress', 1);?>" data-status="inprogress"><div class="icn icn-75" data-icon="'"></div></a>
		<a href="#" class="btn icn16 status-toggle tooltip-top" title="<?php echo lang('action.show action.approved', 1);?>" data-status="approved"><div class="icn icn-75" data-icon="4"></div></a>
		<a href="#" class="btn icn16 status-toggle tooltip-top" title="<?php echo lang('action.show action.rejected', 1);?>" data-status="rejected"><div class="icn icn-75" data-icon="2"></div></a>
	</div>
</div>
<br>

<?php if ($applications): ?>
	<table class="table table-striped">
		<tbody>
		<?php foreach ($applications as $r): ?>
			<tr class="status-<?php echo $r->status;?>">
				<td>
					<span class="lead"><?php echo $r->character->getName(false);?></span><br>

					<?php if ($r->status == Status::IN_PROGRESS): ?>
						<span class="label label-info"><span class="icn icn-75" data-icon="'"></span></span>
					<?php elseif ($r->status == Status::APPROVED): ?>
						<span class="label label-success"><span class="icn icn-75" data-icon="4"></span></span>
					<?php elseif ($r->status == Status::REJECTED): ?>
						<span class="label label-important"><span class="icn icn-75" data-icon="x"></span></span>
					<?php endif;?>

					<span class="muted"><?php echo $r->position->name;?></span>
				</td>
				<td class="span2">
					<div class="btn-toolbar">
						<div class="btn-group">
							<?php if (count($r->getComments()) > 0): ?>
								<span class="btn btn-small btn-noclick tooltip-top" title="<?php echo lang('comments', 1);?>"><span class="icn icn-50" data-icon="c"></span> <?php echo count($r->getComments());?></span>
							<?php endif;?>

							<?php if (count($r->getVotes('yes')) > 0): ?>
								<span class="btn btn-small btn-noclick tooltip-top" title="<?php echo lang('yes votes', 1);?>"><span class="icn icn-50" data-icon="."></span> <?php echo count($r->getVotes('yes'));?></span>
							<?php endif;?>

							<?php if (count($r->getVotes('no')) > 0): ?>
								<span class="btn btn-small btn-noclick tooltip-top" title="<?php echo lang('no votes', 1);?>"><span class="icn icn-50" data-icon="/"></span> <?php echo count($r->getVotes('no'));?></span>
							<?php endif;?>
						</div>
					</div>
				</td>
				<td class="span2">
					<div class="btn-toolbar pull-right">
						<?php if ($r->status == Status::REJECTED): ?>
							<div class="btn-group">
								<?php if (Model_Ban::getItems($r->user->email)): ?>
									<a href="#" class="btn btn-mini btn-danger tooltip-top unban-user" title="<?php echo lang('action.remove user action.ban', 1);?>" data-user="<?php echo $r->user->id;?>"><div class="icn icn-50" data-icon="2"></div></a>
								<?php else:?>
									<a href="#" class="btn btn-mini btn-danger tooltip-top ban-user" title="<?php echo lang('action.ban user', 1);?>" data-user="<?php echo $r->user->id;?>"><div class="icn icn-50" data-icon="2"></div></a>
								<?php endif;?>
							</div>
						<?php endif;?>

						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>" class="btn btn-mini"><div class="icn icn-50" data-icon=">"></div></a>
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