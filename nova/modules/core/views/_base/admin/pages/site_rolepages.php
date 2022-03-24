<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p>
	<?php echo anchor('site/roles', img($images['roles']) .' '. $label['roles'], array('class' => 'image bold'));?><br />
	<?php echo anchor('site/rolepagegroups', img($images['groups']) .' '. $label['groups'], array('class' => 'image bold'));?>
	<br /><br />
	<a href="#" rel="facebox" class="image bold" myAction="add">
		<?php echo img($images['add']) .' '. $label['add'];?>
	</a>
</p>

<?php if (isset($pages)): ?>
	<?php foreach ($pages['groups'] as $group): ?>
		<?php echo text_output($group['name'], 'h3', 'page-subhead');?>
		
		<table class="table100 zebra">
			<thead>
				<tr>
					<th><?php echo $label['name'];?></th>
					<th><?php echo $label['url'];?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($group['pages'] as $page): ?>
				<tr>
					<td class="col_50pct">
						<?php echo $page['name'];?>
						<?php if (!empty($page['desc'])): ?>
							<span class="fontSmall">
								<a href="#" rel="tooltip" title="<?php echo $page['desc'];?>">[?]</a>
							</span>
						<?php endif;?>
					</td>
					<td><?php echo $page['url'];?></td>
					<td class="col_75 align_right">
						<a href="#" rel="facebox" class="delete image" title="<?php echo $label['delete'];?>" myID="<?php echo $page['id'];?>" myAction="delete"><?php echo img($images['delete']);?></a>
						&nbsp;
						<a href="#" rel="facebox" class="edit image" title="<?php echo $label['edit'];?>" myID="<?php echo $page['id'];?>" myAction="edit"><?php echo img($images['edit']);?></a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endforeach;?>
<?php endif; ?>