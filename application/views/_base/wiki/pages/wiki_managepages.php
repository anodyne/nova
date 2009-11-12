<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold fontMedium">
	<?php echo anchor('wiki/page', img($images['add']) .' '. $label['add'], array('class' => 'image'));?>
</p>

<?php if (isset($pages)): ?>
	<br /><div class="search_pages"></div><br />
	
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
			<tr>
				<td class="col_40pct bold"><?php echo anchor('wiki/view/page/'. $p['id'], $p['title']);?></td>
				<td class="fontSmall gray">
					<?php echo $p['created'];?><br />
					<span class="fontTiny"><?php echo $p['created_date'];?></span>
				</td>
				<td class="fontSmall gray">
					<?php if ($p['updated'] !== FALSE): ?>
						<?php echo $p['updated'];?><br />
						<span class="fontTiny"><?php echo $p['updated_date'];?></span>
					<?php endif;?>
				</td>
				<td class="col_75 align_right">
					<a href="#" rel="facebox" myAction="delete" myID="<?php echo $p['id'];?>" class="image"><?php echo img($images['delete']);?></a>
					&nbsp;
					<?php echo anchor('wiki/page/'. $p['id'], img($images['edit']), array('class' => 'image'));?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output($label['nopages'], 'h3', 'orange');?>
<?php endif;?>