<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p>
	<?php echo anchor('site/rolepages', img($images['pages']) .' '. $label['manage_pages'], array('class' => 'image bold'));?>
	<br /><br />
	<?php echo anchor('site/roles/add', img($images['add']) .' '. $label['add'], array('class' => 'image bold'));?><br />
	<a href="#" rel="facebox" class="image bold" title="<?php echo $label['duplicate'];?>" myAction="duplicate"><?php echo img($images['add']) .' '. $label['duplicate_role'];?></a>
</p>

<?php if (isset($roles)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['name'];?></th>
				<th><?php echo $label['desc'];?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($roles as $key => $value): ?>
			<tr>
				<td class="col_30pct"><strong><?php echo $value['name'];?></strong></td>
				<td class="fontSmall"><?php echo $value['desc'];?></td>
				<td class="col_100 align_right">
					<a href="#" rel="facebox" class="image" title="<?php echo $label['view'];?>" myID="<?php echo $value['id'];?>" myAction="view"><?php echo img($images['view']);?></a>
					&nbsp;
					<a href="#" rel="facebox" class="delete image" title="<?php echo $label['delete'];?>" myID="<?php echo $value['id'];?>" myAction="delete"><?php echo img($images['delete']);?></a>
					&nbsp;
					<?php echo anchor('site/roles/edit/'. $value['id'], img($images['edit']), array('class' => 'image', 'title' => $label['edit']));?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody> 
	</table>
<?php endif;?>