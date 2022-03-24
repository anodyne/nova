<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<?php echo anchor('site/bioform', img($images['form']) .' '. $label['bioform'], array('class' => 'image'));?><br />
	<?php echo anchor('site/biosections', img($images['sections']) .' '. $label['biosections'], array('class' => 'image'));?>
	<br /><br />
	<a href="#" rel="facebox" myAction="add" class="image"><?php echo img($images['add']) .' '. $label['addtab'];?></a>
</p>

<?php if (isset($tabs)): ?>
	<table class="table100 zebra">
		<tbody>
		<?php foreach ($tabs as $tab): ?>
			<tr>
				<td class="bold">
					<?php echo ($tab['display'] == 'n') ? '<span class="red fontSmall">['. $label['off'] .']</span>' : '';?>
					<?php echo $tab['name'];?>
				</td>
				<td class="col_30 align_center">
					<a href="#" rel="facebox" class="delete image" myAction="delete" myID="<?php echo $tab['id'];?>" title="<?php echo $label['delete'];?>">
						<?php echo img($images['delete']);?>
					</a>
				</td>
				<td class="col_30 align_center">
					<a href="#" rel="facebox" class="edit image" myAction="edit" myID="<?php echo $tab['id'];?>" title="<?php echo $label['edit'];?>">
						<?php echo img($images['edit']);?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>