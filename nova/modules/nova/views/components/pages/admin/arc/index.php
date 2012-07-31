<?php if (Sentry::user()->has_level('character.create', 2)): ?>
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/application/rules');?>" class="btn tooltip-top" title="<?php echo lang('action.manage rules', 1);?>"><?php echo $images['rules'];?></a>
		<a href="<?php echo Uri::create('admin/application/history');?>" class="btn tooltip-top" title="<?php echo lang('action.view history', 1);?>"><?php echo $images['clock'];?></a>
	</div>
	<br>
<?php endif;?>

<?php if (count($reviews) > 0): ?>
	<table class="table table-striped">
		<tbody>
		<?php foreach ($reviews as $r): ?>
			<tr>
				<td>
					<span class="lead"><?php echo $r->character->name(false);?></span><br>
					<span class="muted"><?php echo $r->position->name;?></span>
				</td>
				<td class="span3">
					<div class="btn-group">
						<?php if (count($r->comments()) > 0): ?>
							<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>"  class="btn btn-small"><i class="icon-comment icon-50"></i> <?php echo count($r->comments());?></a>
						<?php endif;?>

						<?php if (count($r->votes('yes')) > 0): ?>
							<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>"  class="btn btn-small btn-success"><i class="icon-thumbs-up icon-white"></i> <?php echo count($r->votes('yes'));?></a>
						<?php endif;?>

						<?php if (count($r->votes('no')) > 0): ?>
							<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>"  class="btn btn-small btn-danger"><i class="icon-thumbs-down icon-white"></i> <?php echo count($r->votes('no'));?></a>
						<?php endif;?>
					</div>
				</td>
				<td class="span1">
					<div class="btn-group">
						<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>" class="btn btn-small"><i class="icon-chevron-right icon-50"></i></a>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p class="alert"><?php echo lang('[[error.not_found|application reviews]]');?></p>
<?php endif;?>