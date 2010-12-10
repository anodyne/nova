<h1 class="page-head"><?php echo $header;?></h1>

<div id="tabs">
	<ul>
		<li><a href="#active"><?php echo ucwords(__(":active :users", array(':active' => __('active'), ':users' => __('users'))));?></a></li>
		<li><a href="#inactive"><?php echo ucwords(__(":inactive :users", array(':inactive' => __('inactive'), ':users' => __('users'))));?></a></li>
		<li><a href="#retired"><?php echo ucwords(__(":retired :users", array(':retired' => __('retired'), ':users' => __('users'))));?></a></li>
		<li><a href="#pending"><?php echo ucwords(__(":pending :users", array(':pending' => __('pending'), ':users' => __('users'))));?></a></li>
	</ul>
	
	<div id="active">
		<?php if (isset($users['active'])): ?>
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($users['active'] as $u): ?>
					<tr>
						<td><?php echo $u->name;?></td>
						<td class="col-100 align-center">
							<?php echo html::image($images['link']['src'], $images['link']['attr']);?>
							&nbsp;
							<?php echo html::image($images['delete']['src'], $images['delete']['attr']);?>
							&nbsp;
							<?php echo html::image($images['edit']['src'], $images['edit']['attr']);?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<h3 class="warning"><?php echo ucfirst(__('no :item were found.', array(':item' => __('active').' '.__('users'))));?></h3>
		<?php endif;?>
	</div>
	
	<div id="inactive">
		<?php if (isset($users['inactive'])): ?>
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($users['inactive'] as $u): ?>
					<tr>
						<td><?php echo $u->name;?></td>
						<td class="col-100 align-center">
							<?php echo html::image($images['link']['src'], $images['link']['attr']);?>
							&nbsp;
							<?php echo html::image($images['delete']['src'], $images['delete']['attr']);?>
							&nbsp;
							<?php echo html::image($images['edit']['src'], $images['edit']['attr']);?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<h3 class="warning"><?php echo ucfirst(__('no :item were found.', array(':item' => __('inactive').' '.__('users'))));?></h3>
		<?php endif;?>
	</div>
	
	<div id="retired">
		<?php if (isset($users['retired'])): ?>
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($users['retired'] as $u): ?>
					<tr>
						<td><?php echo $u->name;?></td>
						<td class="col-100 align-center">
							<?php echo html::image($images['link']['src'], $images['link']['attr']);?>
							&nbsp;
							<?php echo html::image($images['delete']['src'], $images['delete']['attr']);?>
							&nbsp;
							<?php echo html::image($images['edit']['src'], $images['edit']['attr']);?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<h3 class="warning"><?php echo ucfirst(__('no :item were found.', array(':item' => __('retired').' '.__('users'))));?></h3>
		<?php endif;?>
	</div>
	
	<div id="pending">
		<?php if (isset($users['pending'])): ?>
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($users['pending'] as $u): ?>
					<tr>
						<td><?php echo $u->name;?></td>
						<td class="col-100 align-center">
							<?php echo html::image($images['approve']['src'], $images['approve']['attr']);?>
							&nbsp;
							<?php echo html::image($images['reject']['src'], $images['reject']['attr']);?>
							&nbsp;
							<?php echo html::image($images['delete']['src'], $images['delete']['attr']);?>
							&nbsp;
							<?php echo html::image($images['edit']['src'], $images['edit']['attr']);?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<h3 class="warning"><?php echo ucfirst(__('no :item were found.', array(':item' => __('pending').' '.__('users'))));?></h3>
		<?php endif;?>
	</div>
</div>