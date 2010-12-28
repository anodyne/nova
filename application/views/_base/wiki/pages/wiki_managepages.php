<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold">
	<?php echo anchor('wiki/page', img($images['add']) .' '. $label['add'], array('class' => 'image'));?>
</p>

<?php if (isset($pages)): ?>
	<p class="bold">
		<a href="#" rel="facebox" myAction="cleanup" myID="0" class="image"><?php echo img($images['clean']) .' '. $label['clean'];?></a>
	</p>
	
	<br /><div class="search_pages"></div><br />
	
	<div class="fontSmall">
		<strong><?php echo $label['show'];?></strong>
		<a href="#" rel="toggle" id="show_all"><?php echo $label['show_all'].' '.$label['pages'];?></a>
		&middot;
		<a href="#" rel="toggle" id="show_std"><?php echo $label['show_std'].' '.$label['pages'];?></a>
		&middot;
		<a href="#" rel="toggle" id="show_sys"><?php echo $label['system'].' '.$label['pages'];?></a>
	</div><br />
	
	<table class="zebra table100 pages_search">
		<thead>
			<tr>
				<th><?php echo $label['name'];?></th>
				<th><?php echo $label['created'];?></th>
				<th><?php echo $label['updated'];?></th>
				<th></th>
		</thead>
		<tbody>
		<?php foreach ($pages as $p): ?>
			<tr class="<?php echo $p['type'];?>">
				<td class="col_40pct">
					<?php if ($p['type'] == 'system'): ?>
						<?php echo text_output($label['system'], 'span', 'label-system');?>
					<?php endif;?>
					<strong>
						<?php if ($p['type'] == 'system'): ?>
							<?php echo $p['title'];?>
						<?php else: ?>
							<?php echo anchor('wiki/view/page/'. $p['id'], $p['title']);?>
						<?php endif;?>
					</strong>
				</td>
				<td class="fontSmall gray">
					<?php if ($p['type'] == 'system'): ?>
						<?php echo $label['system'];?>
					<?php else: ?>
						<?php echo $p['created'];?><br />
						<span class="fontTiny"><?php echo $p['created_date'];?></span>
					<?php endif;?>
				</td>
				<td class="fontSmall gray">
					<?php if ($p['updated'] !== FALSE): ?>
						<?php echo $p['updated'];?><br />
						<span class="fontTiny"><?php echo $p['updated_date'];?></span>
					<?php endif;?>
				</td>
				<td class="col_75 align_right">
					<?php if ($p['type'] == 'standard'): ?>
						<a href="#" rel="facebox" myAction="delete" myID="<?php echo $p['id'];?>" class="image"><?php echo img($images['delete']);?></a>
						&nbsp;
					<?php elseif ($p['type'] == 'system'): ?>
						<?php echo anchor('wiki/view/page/'.$p['id'].'/revert', img($images['history']), array('class' => 'image'));?>
						&nbsp;
					<?php endif;?>
					<?php echo anchor('wiki/page/'. $p['id'], img($images['edit']), array('class' => 'image'));?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output($label['nopages'], 'h3', 'orange');?>
<?php endif;?>