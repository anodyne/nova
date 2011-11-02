<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('site/settings', $label['back']);?></p>

<?php echo text_output($text);?>

<p class="bold"><a href="#" rel="facebox" myAction="add"><?php echo img($images['add']) .' '. $label['add'];?></a></p>

<?php if (isset($settings)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['name'];?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($settings as $k => $v): ?>
			<tr>
				<td class="bold"><?php echo $v;?></td>
				<td class="col_75 align_right">
					<a href="#" class="delete" rel="facebox" myID="<?php echo $k;?>" myAction="delete" title="<?php echo $label['delete'];?>"><?php echo img($images['delete']);?></a>
					&nbsp;
					<a href="#" class="edit" rel="facebox" myID="<?php echo $k;?>" myAction="edit" title="<?php echo $label['edit'];?>"><?php echo img($images['edit']);?></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output($label['no_settings'], 'h3', 'orange');?>
<?php endif; ?>