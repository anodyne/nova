<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<?php echo anchor('site/menus', img($images['menu']) .' '. $label['menus'], array('class' => 'image'));?><br /><br />
	<a href="#" rel="facebox" myAction="add" class="image"><?php echo img($images['add']) .' '. $label['addcat'];?></a>
</p>

<?php if (isset($cats)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['name'];?></th>
				<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($cats as $cat): ?>
			<tr>
				<td>
					<strong><?php echo $cat['name'];?></strong><br />
					<span class="gray fontSmall">
						<?php echo $label['category'] .' '. $cat['cat'];?>
					</span>
				</td>
				<td class="col_75 align_right">
					<a href="#" rel="facebox" class="delete image" myAction="delete" myID="<?php echo $cat['id'];?>" title="<?php echo $label['delete'];?>">
						<?php echo img($images['delete']);?>
					</a>
					&nbsp;
					<a href="#" rel="facebox" class="edit image" myAction="edit" myID="<?php echo $cat['id'];?>" title="<?php echo $label['edit'];?>">
						<?php echo img($images['edit']);?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>