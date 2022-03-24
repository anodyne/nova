<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p>
	<?php echo anchor('site/roles', img($images['roles']) .' '. $label['roles'], array('class' => 'image bold'));?><br />
	<?php echo anchor('site/rolepages', img($images['pages']) .' '. $label['pages'], array('class' => 'image bold'));?>
	<br /><br />
	<a href="#" rel="facebox" class="image bold" myAction="add">
		<?php echo img($images['add']) .' '. $label['add'];?>
	</a>
</p>

<?php if (isset($groups)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['group'];?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($groups as $group): ?>
			<tr>
				<td><?php echo $group['name'];?></td>
				<td class="col_75 align_right">
					<a href="#" rel="facebox" class="delete image" title="<?php echo $label['delete'];?>" myID="<?php echo $group['id'];?>" myAction="delete"><?php echo img($images['delete']);?></a>
					&nbsp;
					<a href="#" rel="facebox" class="edit image" title="<?php echo $label['edit'];?>" myID="<?php echo $group['id'];?>" myAction="edit"><?php echo img($images['edit']);?></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>