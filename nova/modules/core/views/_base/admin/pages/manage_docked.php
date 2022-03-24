<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['status_active'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['status_inactive'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['status_pending'];?> (<?php echo $count;?>)</span></a></li>
	</ul>
	
	<div id="one">
		<?php if (isset($docking['active'])): ?>
			<br />
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['info'];?></th>
						<th><?php echo $label['name'];?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($docking['active'] as $d): ?>
					<tr>
						<td>
							<strong><?php echo $d['sim_name'];?></strong><br />
							<span class="fontSmall"><a href="<?php echo $d['sim_url'];?>" target="_blank"><?php echo $d['sim_url'];?></a></span>
						</td>
						<td><?php echo $d['gm_name'];?></td>
						<td class="col_75 align_right">
							<?php echo anchor('sim/docked/'. $d['id'], img($images['view']), array('class' => 'image'));?>
							&nbsp;
							<a href="#" rel="facebox" class="image" myAction="delete" myID="<?php echo $d['id'];?>"><?php echo img($images['delete']);?></a>
							&nbsp;
							<?php echo anchor('manage/docked/edit/'. $d['id'], img($images['edit']), array('class' => 'image'));?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['noitems'], 'h3', 'orange');?>
		<?php endif;?>
	</div>
	
	<div id="two">
		<?php if (isset($docking['inactive'])): ?>
			<br />
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['info'];?></th>
						<th><?php echo $label['name'];?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($docking['inactive'] as $d): ?>
					<tr>
						<td>
							<strong><?php echo $d['sim_name'];?></strong><br />
							<span class="fontSmall"><a href="<?php echo $d['sim_url'];?>" target="_blank"><?php echo $d['sim_url'];?></a></span>
						</td>
						<td><?php echo $d['gm_name'];?></td>
						<td class="col_75 align_right">
							<?php echo anchor('sim/docked/'. $d['id'], img($images['view']), array('class' => 'image'));?>
							&nbsp;
							<a href="#" rel="facebox" class="image" myAction="delete" myID="<?php echo $d['id'];?>"><?php echo img($images['delete']);?></a>
							&nbsp;
							<?php echo anchor('manage/docked/edit/'. $d['id'], img($images['edit']), array('class' => 'image'));?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['noitems'], 'h3', 'orange');?>
		<?php endif;?>
	</div>
	
	<div id="three">
		<?php if (isset($docking['pending'])): ?>
			<br />
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['info'];?></th>
						<th><?php echo $label['name'];?></th>
						<th colspan="2"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($docking['pending'] as $d): ?>
					<tr>
						<td>
							<strong><?php echo $d['sim_name'];?></strong><br />
							<span class="fontSmall"><a href="<?php echo $d['sim_url'];?>" target="_blank"><?php echo $d['sim_url'];?></a></span>
						</td>
						<td><?php echo $d['gm_name'];?></td>
						<td class="col_75 align_center">
							<a href="#" rel="facebox" class="image" myAction="reject" myID="<?php echo $d['id'];?>"><?php echo img($images['reject']);?></a>
							&nbsp;
							<a href="#" rel="facebox" class="image" myAction="approve" myID="<?php echo $d['id'];?>"><?php echo img($images['accept']);?></a>
						</td>
						<td class="col_75 align_right">
							<?php echo anchor('sim/docked/'. $d['id'], img($images['view']), array('class' => 'image'));?>
							&nbsp;
							<a href="#" rel="facebox" class="image" myAction="delete" myID="<?php echo $d['id'];?>"><?php echo img($images['delete']);?></a>
							&nbsp;
							<?php echo anchor('manage/docked/edit/'. $d['id'], img($images['edit']), array('class' => 'image'));?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['noitems'], 'h3', 'orange');?>
		<?php endif;?>
	</div>
</div>